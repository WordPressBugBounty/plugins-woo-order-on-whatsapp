<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Client for the MyD Notifications WhatsApp API.
 *
 * @since 3.1
 */
final class OMW_MyD_Client {

	const BASE_URL = 'https://services.myddelivery.com';

	/**
	 * Send a WhatsApp notification via the MyD Notifications service.
	 *
	 * @param string $to           Phone in E.164 format (+CC...).
	 * @param string $order_id     Order identifier.
	 * @param string $status_label Human-readable status label (e.g., "Processing").
	 * @return array{messageId:string,remaining:?int}|\WP_Error
	 */
	public static function send( $to, $order_id, $status_label ) {
		$api_key = get_option( 'evwapp_myd_api_key' );

		if ( empty( $api_key ) ) {
			return new \WP_Error( 'NO_API_KEY', __( 'MyD API key is not configured.', 'woo-order-on-whatsapp' ) );
		}

		$response = wp_remote_post(
			self::BASE_URL . '/api/whatsapp/send',
			[
				'timeout' => 10,
				'headers' => [
					'x-api-key'    => $api_key,
					'Content-Type' => 'application/json',
				],
				'body'    => wp_json_encode(
					[
						'to'      => $to,
						'orderId' => (string) $order_id,
						'status'  => $status_label,
					]
				),
			]
		);

		if ( is_wp_error( $response ) ) {
			return new \WP_Error( 'CONNECTION_ERROR', __( 'Connection error. Please try again.', 'woo-order-on-whatsapp' ) );
		}

		$status_code = wp_remote_retrieve_response_code( $response );
		$body        = json_decode( wp_remote_retrieve_body( $response ), true );

		if ( 401 === $status_code ) {
			return new \WP_Error( 'UNAUTHORIZED', __( 'Invalid API key.', 'woo-order-on-whatsapp' ) );
		}

		if ( 403 === $status_code ) {
			$msg = isset( $body['message'] ) ? $body['message'] : __( 'Service not available.', 'woo-order-on-whatsapp' );
			return new \WP_Error( 'NO_PLAN', $msg );
		}

		if ( 429 === $status_code ) {
			$msg = isset( $body['message'] ) ? $body['message'] : __( 'Monthly notification limit reached.', 'woo-order-on-whatsapp' );
			return new \WP_Error( 'LIMIT_EXCEEDED', $msg );
		}

		if ( 502 === $status_code ) {
			return new \WP_Error( 'EXTERNAL_SERVICE_ERROR', __( 'WhatsApp service temporarily unavailable.', 'woo-order-on-whatsapp' ) );
		}

		if ( $status_code < 200 || $status_code >= 300 ) {
			$msg = isset( $body['message'] ) ? $body['message'] : __( 'Unexpected error.', 'woo-order-on-whatsapp' );
			return new \WP_Error( 'UNKNOWN_ERROR', $msg );
		}

		return [
			'messageId' => isset( $body['messageId'] ) ? $body['messageId'] : '',
			'remaining' => isset( $body['remaining'] ) ? $body['remaining'] : null,
		];
	}

	/**
	 * Convert a raw phone string to E.164.
	 *
	 * When $country_iso is provided (ISO-3166-1 alpha-2), prepends the calling code
	 * if the phone doesn't already carry it. Without $country_iso, trusts that the
	 * phone is already international (the store-phone case — placeholder instructs
	 * the operator to type with CC).
	 *
	 * Error messages are verbose on purpose: they land in the Integrations tab log
	 * and tell the store exactly what to fix (add a mask, require the phone field,
	 * capture billing country, etc.).
	 *
	 * @param string      $phone       Raw phone (any format).
	 * @param string|null $country_iso ISO-2 country code for CC derivation. Pass `null`
	 *                                 to signal "trust the input as-is" (store flow,
	 *                                 where the operator is expected to type with CC).
	 *                                 Pass a string (possibly empty) to enable CC
	 *                                 derivation — an empty string fails with NO_COUNTRY.
	 * @return string|\WP_Error E.164 string or WP_Error with actionable message.
	 */
	public static function phone_to_e164( $phone, $country_iso = null ) {
		$raw = (string) $phone;

		if ( '' === trim( $raw ) ) {
			return new \WP_Error(
				'EMPTY_PHONE',
				__( 'Phone is empty. The notification cannot be sent. Make the phone field required at checkout.', 'woo-order-on-whatsapp' )
			);
		}

		$has_plus = 0 === strpos( ltrim( $raw ), '+' );
		$digits   = preg_replace( '/\D/', '', $raw );

		if ( '' === $digits ) {
			return new \WP_Error(
				'INVALID_PHONE',
				sprintf(
					/* translators: %s: raw phone value */
					__( 'Phone "%s" has no digits after normalization. Add a phone mask or validation at checkout.', 'woo-order-on-whatsapp' ),
					$raw
				)
			);
		}

		// Trust mode: caller didn't request CC derivation (null), or phone is already
		// international (leading +). Just validate length.
		if ( null === $country_iso || $has_plus ) {
			return self::validate_e164( $digits, $raw );
		}

		// Country context was requested — must be non-empty.
		$country_iso = strtoupper( trim( (string) $country_iso ) );

		if ( '' === $country_iso ) {
			return new \WP_Error(
				'NO_COUNTRY',
				sprintf(
					/* translators: %s: raw phone value */
					__( 'Phone "%s" has no "+" prefix and no country context. Capture billing country at checkout or instruct customers to enter the phone with country code.', 'woo-order-on-whatsapp' ),
					$raw
				)
			);
		}

		if ( ! class_exists( 'OMW_Calling_Codes' ) ) {
			include_once OMW_PLUGIN_PATH . 'includes/class-calling-codes.php';
		}

		$cc = OMW_Calling_Codes::get( $country_iso );
		if ( null === $cc ) {
			return new \WP_Error(
				'NO_CC_FOR_COUNTRY',
				sprintf(
					/* translators: %s: ISO-2 country code */
					__( 'No calling code mapped for country "%s". The notification cannot be sent.', 'woo-order-on-whatsapp' ),
					$country_iso
				)
			);
		}

		$cc_str = (string) $cc;

		// Prepend CC if digits don't already start with it. This is a heuristic —
		// libphonenumber would be more precise but is overkill for just routing to MyD.
		if ( 0 !== strpos( $digits, $cc_str ) ) {
			$digits = $cc_str . $digits;
		}

		return self::validate_e164( $digits, $raw, $cc );
	}

	/**
	 * Validate E.164 digit-only string; returns "+<digits>" or WP_Error with detail.
	 */
	private static function validate_e164( $digits, $raw, $cc = null ) {
		$len = strlen( $digits );

		if ( $len < 8 || $len > 15 ) {
			return new \WP_Error(
				'INVALID_PHONE',
				sprintf(
					/* translators: 1: raw phone, 2: digit count */
					__( 'Phone "%1$s" normalized to %2$d digits, outside the E.164 range (8-15). Add a phone mask at checkout so customers enter the full number.', 'woo-order-on-whatsapp' ),
					$raw,
					$len
				)
			);
		}

		if ( null !== $cc ) {
			$national_len = $len - strlen( (string) $cc );
			if ( $national_len < 7 || $national_len > 13 ) {
				return new \WP_Error(
					'INVALID_PHONE',
					sprintf(
						/* translators: 1: raw phone, 2: total digits, 3: national digits, 4: country calling code */
						__( 'Phone "%1$s" normalized to %2$d digits total (%3$d after country code +%4$s). National part outside 7-13. Add a phone mask at checkout.', 'woo-order-on-whatsapp' ),
						$raw,
						$len,
						$national_len,
						$cc
					)
				);
			}
		}

		return '+' . $digits;
	}
}
