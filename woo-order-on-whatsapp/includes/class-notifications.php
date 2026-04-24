<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dispatcher for WhatsApp notifications via the MyD Notifications service.
 *
 * Listens to WooCommerce order hooks and decides whether to fire a store alert
 * (new order) and/or a customer notification (status change) based on the
 * options configured in Setup and Integrations.
 *
 * @since 3.1
 */
final class OMW_Notifications {

	const ERROR_LOG_OPTION = 'evwapp_notifications_error_log';
	const ERROR_LOG_MAX    = 20;

	public function __construct() {
		add_action( 'woocommerce_new_order', [ $this, 'maybe_notify_store' ], 10, 1 );
		add_action( 'woocommerce_order_status_changed', [ $this, 'maybe_notify_customer' ], 10, 3 );
	}

	/**
	 * Fire a store alert when a new order is placed and Q3 is set to `api`.
	 *
	 * @param int $order_id
	 */
	public function maybe_notify_store( $order_id ) {
		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( get_option( 'evwapp_opiton_show_thank' ) !== 'api' ) {
			return;
		}

		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}

		$store_phone = get_option( 'evwapp_opiton_phone_number' );

		if ( empty( $store_phone ) ) {
			self::log_error(
				$order_id,
				$order->get_status(),
				'EMPTY_STORE_PHONE',
				__( 'Store WhatsApp number is empty. Set it in the Setup tab (enter with country code, e.g., 5551XXXXXXXXX).', 'woo-order-on-whatsapp' )
			);
			return;
		}

		$e164 = $this->require_client()::phone_to_e164( $store_phone );

		if ( is_wp_error( $e164 ) ) {
			self::log_error( $order_id, $order->get_status(), 'INVALID_STORE_PHONE', $e164->get_error_message() );
			return;
		}

		$status_label = wc_get_order_status_name( $order->get_status() );
		$result       = OMW_MyD_Client::send( $e164, (string) $order_id, $status_label );

		if ( is_wp_error( $result ) ) {
			self::log_error( $order_id, $order->get_status(), $result->get_error_code(), $result->get_error_message() );
		}
	}

	/**
	 * Fire a customer notification on status change (Q4=yes).
	 *
	 * @param int    $order_id
	 * @param string $old_status
	 * @param string $new_status
	 */
	public function maybe_notify_customer( $order_id, $old_status, $new_status ) {
		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( get_option( 'evwapp_customer_notify_mode' ) !== 'yes' ) {
			return;
		}

		$allowed = get_option( 'evwapp_notifications_statuses', [ 'processing', 'completed' ] );
		$allowed = is_array( $allowed ) ? $allowed : [];

		if ( ! in_array( $new_status, $allowed, true ) ) {
			return;
		}

		$order = wc_get_order( $order_id );
		if ( ! $order ) {
			return;
		}

		$phone           = $order->get_billing_phone();
		$billing_country = $order->get_billing_country();

		if ( empty( $phone ) ) {
			$note = __( 'WhatsApp notification not sent: customer phone is empty. Make the phone field required at checkout.', 'woo-order-on-whatsapp' );
			$order->add_order_note( $note );
			self::log_error( $order_id, $new_status, 'EMPTY_PHONE', $note );
			return;
		}

		$e164 = $this->require_client()::phone_to_e164( $phone, $billing_country );

		if ( is_wp_error( $e164 ) ) {
			$detail = $e164->get_error_message();
			$order->add_order_note(
				sprintf(
					/* translators: 1: phone value, 2: billing country ISO, 3: detailed reason */
					__( 'WhatsApp notification not sent: customer phone "%1$s" (country: %2$s) could not be normalized. %3$s', 'woo-order-on-whatsapp' ),
					$phone,
					$billing_country ? $billing_country : '-',
					$detail
				)
			);
			self::log_error( $order_id, $new_status, $e164->get_error_code(), $detail );
			return;
		}

		$status_label = wc_get_order_status_name( $new_status );
		$result       = OMW_MyD_Client::send( $e164, (string) $order_id, $status_label );

		if ( is_wp_error( $result ) ) {
			$order->add_order_note(
				sprintf(
					/* translators: 1: status label, 2: error code, 3: error message */
					__( 'WhatsApp notification failed (%1$s): [%2$s] %3$s', 'woo-order-on-whatsapp' ),
					$status_label,
					$result->get_error_code(),
					$result->get_error_message()
				)
			);
			self::log_error( $order_id, $new_status, $result->get_error_code(), $result->get_error_message() );
			return;
		}

		$order->add_order_note(
			sprintf(
				/* translators: %s: status label */
				__( 'Customer notified via WhatsApp (%s).', 'woo-order-on-whatsapp' ),
				$status_label
			)
		);
	}

	/**
	 * Global gate — notifications only run when the toggle is on.
	 *
	 * @return bool
	 */
	public static function is_enabled() {
		return get_option( 'evwapp_notifications_enabled' ) === 'yes';
	}

	/**
	 * Append an error to the option-backed log, capped at 20 entries (newest first).
	 *
	 * @param int    $order_id
	 * @param string $status
	 * @param string $code
	 * @param string $message
	 */
	public static function log_error( $order_id, $status, $code, $message ) {
		$log = get_option( self::ERROR_LOG_OPTION, [] );
		$log = is_array( $log ) ? $log : [];

		array_unshift(
			$log,
			[
				'order_id'      => (int) $order_id,
				'status'        => (string) $status,
				'error_code'    => (string) $code,
				'error_message' => (string) $message,
				'date'          => wp_date( 'Y-m-d H:i:s' ),
			]
		);

		$log = array_slice( $log, 0, self::ERROR_LOG_MAX );

		update_option( self::ERROR_LOG_OPTION, $log, false );
	}

	/**
	 * Lazy-load the client file and return the class name so the caller can
	 * call static methods on it.
	 *
	 * @return string
	 */
	private function require_client() {
		if ( ! class_exists( 'OMW_MyD_Client' ) ) {
			include_once OMW_PLUGIN_PATH . 'includes/class-myd-client.php';
		}
		return 'OMW_MyD_Client';
	}
}
