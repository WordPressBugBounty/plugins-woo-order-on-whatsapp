<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to implement admin options
 *
 * @since 2.8
 */
class OMW_Admin {
	/**
	 * Settings option group
	 *
	 * @since 2.8
	 */
	public $option_group;

	/**
	 * Plugin name
	 *
	 * @since 2.8
	 */
	public $plugin_name;

	/**
	 * Page options slug
	 *
	 * @since 2.8
	 */
	public $page_options_slug;

	/**
	 * Page title
	 *
	 * @since 2.0
	 */
	public $page_title;

	/**
	 * Settings
	 *
	 * @since 2.8
	 */
	public $settings = [];

	/**
	 * Page templates
	 *
	 * @since 2.0
	 */
	public $templates = [];

	/**
	 * Construct the class
	 *
	 * @since 2.8
	 */
	public function __construct() {

		$this->option_group = 'evwapp-settings-group';
		$this->plugin_name = 'Order Mobile for WooCommerce';
		$this->page_title = 'Order on Mobile for WooCommerce Options';
		$this->page_options_slug = 'order-on-mobile-for-woocommerce-config';
		$this->settings = [
			'evwapp_opiton_phone_number' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_message' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_message_cart' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_text_button' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_text_button_cart' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_target' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_show_cart' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_remove_btn' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_remove_cart_btn' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_remove_price' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_text_btn_thank' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_message_thank' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_title_thank' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_show_btn_single' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_cart_button_target' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_opiton_show_thank' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => [ __CLASS__, 'sanitize_show_thank' ],
				]
			],
			'evwapp_opiton_order_message' => [
				'option_group' => $this->option_group,
				'args' => [
					'default' => 'Order: {order-number}

					Products:
					{order-products}

					Payment: {order-payment}
					Shipping Total:{shipping-total}
					Shipping Method: {shipping-method}
					Subtotal: {order-subtotal}
					Total: {order-total}

					Name: {customer-name}
					Phone: {customer-phone}
					Mail: {customer-mail}
					Endereço: {customer-address}
					State: {customer-state}
					City: {customer-city}
					Zipcode: {customer-zipcode}',
				]
			],
			'evwapp_opiton_product_order_message' => [
				'option_group' => $this->option_group,
				'args' => [
					'default' => '[{product-qty}] => {product-name} = {product-price}
					{product-atributes}',
				]
			],
			'evwapp_option_checkout_btn_text' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_myd_api_key' => [
				'option_group' => $this->option_group,
				'args' => [
					'sanitize_callback' => 'sanitize_text_field',
				]
			],
			'evwapp_notifications_enabled' => [
				'option_group' => $this->option_group,
				'args' => [
					'default' => 'no',
					'sanitize_callback' => [ __CLASS__, 'sanitize_yes_no' ],
				]
			],
			'evwapp_customer_notify_mode' => [
				'option_group' => $this->option_group,
				'args' => [
					'default' => 'no',
					'sanitize_callback' => [ __CLASS__, 'sanitize_yes_no' ],
				]
			],
			'evwapp_notifications_statuses' => [
				'option_group' => $this->option_group,
				'args' => [
					'default' => [ 'processing', 'completed' ],
					'sanitize_callback' => [ __CLASS__, 'sanitize_notification_statuses' ],
				]
			],
			// Note: evwapp_notifications_error_log is intentionally NOT registered here.
			// It is written programmatically by OMW_Notifications::log_error(); registering
			// it in the settings group would cause every admin save to wipe it to an empty array.
		];

		$this->templates = [
			'setup' => OMW_PLUGIN_PATH . 'templates/admin/tab-setup.php',
			'product_page' => OMW_PLUGIN_PATH . 'templates/admin/tab-product-page.php',
			'cart' => OMW_PLUGIN_PATH . 'templates/admin/tab-cart.php',
			'checkout' => OMW_PLUGIN_PATH . 'templates/admin/tab-checkout.php',
			'integrations' => OMW_PLUGIN_PATH . 'templates/admin/tab-integrations.php',
			'support' => OMW_PLUGIN_PATH . 'templates/admin/tab-support.php',
		];
	}

	/**
	 * Allow only `yes`, `api` or empty for the post-order behavior option.
	 *
	 * @since 3.1
	 * @param mixed $value
	 * @return string
	 */
	public static function sanitize_show_thank( $value ) {
		$value = is_string( $value ) ? $value : '';
		return in_array( $value, [ 'yes', 'api' ], true ) ? $value : '';
	}

	/**
	 * Sanitize a yes/no flag.
	 *
	 * @since 3.1
	 * @param mixed $value
	 * @return string
	 */
	public static function sanitize_yes_no( $value ) {
		return 'yes' === $value ? 'yes' : 'no';
	}

	/**
	 * Sanitize the array of WC status slugs selected for customer notifications.
	 *
	 * Keeps only slugs that correspond to currently registered WC order statuses.
	 *
	 * @since 3.1
	 * @param mixed $value
	 * @return array
	 */
	public static function sanitize_notification_statuses( $value ) {
		if ( ! is_array( $value ) ) {
			return [];
		}

		$valid_slugs = [];
		if ( function_exists( 'wc_get_order_statuses' ) ) {
			foreach ( array_keys( wc_get_order_statuses() ) as $wc_key ) {
				$valid_slugs[] = preg_replace( '/^wc-/', '', $wc_key );
			}
		}

		return array_values( array_intersect( array_map( 'sanitize_text_field', $value ), $valid_slugs ) );
	}

	///'evwapp_opiton_phone_number' intval

	/**
	 * Undocumented function
	 *
	 * @since 2.8
	 * @return void
	 */
	public function add_admin_page() {
		\add_menu_page(
			apply_filters( 'omw_admin_page_title', $this->page_title ),
			apply_filters( 'omw_admin_page_name', $this->plugin_name ),
			'publish_posts',
			'order-on-mobile-for-woocommerce-dashboard',
			'',
			OMW_PLUGN_URL . 'assets/img/whatsapp.webp',
			56,
		);

		\add_submenu_page(
			'order-on-mobile-for-woocommerce-dashboard',
			\esc_html__( 'Dashboard', 'woo-order-on-whatsapp' ),
			\esc_html__( 'Dashboard', 'woo-order-on-whatsapp' ),
			'publish_posts',
			'order-on-mobile-for-woocommerce-dashboard',
			[ $this, 'get_template_dashboard' ],
			0
		);

		\add_submenu_page(
			'order-on-mobile-for-woocommerce-dashboard',
			\esc_html__( 'Settings', 'woo-order-on-whatsapp' ),
			\esc_html__( 'Settings', 'woo-order-on-whatsapp' ),
			'publish_posts',
			apply_filters( 'omw_admin_page_slug', $this->page_options_slug ),
			[ $this, 'create_admin_page' ],
			1
		);
	}

	public function get_template_dashboard() {
		$template = apply_filters( 'omw_template_path_dashboard', OMW_PLUGIN_PATH . 'templates/admin/dashboard.php' );
		include_once $template;
	}

	/**
	 * Register settings
	 *
	 * @since 2.8
	 * @return void
	 */
	public function register_settings() {

		/**
		 * Action to implement more admin settings.
		 */
		$settings = apply_filters( 'omw_before_register_admin_settings', $this->settings );

		foreach( $settings as $setting_name => $data ) {

			register_setting(
				$data['option_group'],
				$setting_name,
				$data['args']
			);
		}
	}

	/**
	 * Admin page
	 *
	 * @since 2.8
	 * @return void
	 */
	public function create_admin_page() {

		/**
		 * Action to edit/extende admin page templates.
		 */
		$templates = apply_filters( 'omw_after_output_templates', $this->templates );

		include_once OMW_PLUGIN_PATH . 'templates/admin/tab-header.php';
		foreach( $templates as $template ) {
			include_once $template;
		}
		include_once OMW_PLUGIN_PATH . 'templates/admin/tab-footer.php';
	}
}
