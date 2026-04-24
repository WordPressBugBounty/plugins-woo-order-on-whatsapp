<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omw_show_product     = get_option( 'evwapp_opiton_show_btn_single' ) === 'yes';
$omw_show_cart        = get_option( 'evwapp_opiton_show_cart' ) === 'yes';
$omw_show_thank_raw   = get_option( 'evwapp_opiton_show_thank' );
$omw_thank_redirect   = 'yes' === $omw_show_thank_raw;
$omw_thank_api        = 'api' === $omw_show_thank_raw;
$omw_thank_off        = ! $omw_thank_redirect && ! $omw_thank_api;
$omw_customer_notify  = get_option( 'evwapp_customer_notify_mode' ) === 'yes';
$omw_notify_statuses  = get_option( 'evwapp_notifications_statuses', [ 'processing', 'completed' ] );
$omw_notify_statuses  = is_array( $omw_notify_statuses ) ? $omw_notify_statuses : [];
?>
<div id="tab-setup-content" class="myd-tabs-content myd-tabs-content--active">
	<h2><?php esc_html_e( 'Setup', 'woo-order-on-whatsapp' ); ?></h2>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="evwapp_opiton_phone_number"><?php esc_html_e( 'WhatsApp Number', 'woo-order-on-whatsapp' ); ?></label>
				</th>
				<td>
					<input type="text" name="evwapp_opiton_phone_number" id="evwapp_opiton_phone_number" class="regular-text" value="<?php echo esc_attr( get_option( 'evwapp_opiton_phone_number' ) ); ?>" inputmode="numeric" pattern="\d*" placeholder="5551XXXXXXXXX" required>
					<p class="omw-description"><?php esc_html_e( 'Enter with your country code 5551XXXXXXXXX', 'woo-order-on-whatsapp' ); ?></p>
				</td>
			</tr>
		</tbody>
	</table>

	<div class="owm-wizard-question">
		<h3><?php esc_html_e( 'When a customer visits a product page...', 'woo-order-on-whatsapp' ); ?></h3>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_btn_single" value="yes" <?php checked( $omw_show_product ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( 'Show WhatsApp button', 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'Display an order button on each product page.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_btn_single" value="" <?php checked( ! $omw_show_product ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( "Don't show", 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'No WhatsApp button on product pages.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<div class="owm-wizard-subsetting owm-conditional-subsetting" data-owm-show-when="evwapp_opiton_show_btn_single:yes"<?php echo $omw_show_product ? '' : ' hidden'; ?>>
			<a href="#tab-product-page" class="owm-wizard-subsetting__link" onclick="event.preventDefault(); document.getElementById('tab-product-page').click();">
				<?php esc_html_e( 'Customize button text, message and visibility →', 'woo-order-on-whatsapp' ); ?>
			</a>
		</div>
	</div>

	<div class="owm-wizard-question">
		<h3><?php esc_html_e( 'When a customer is on the cart page...', 'woo-order-on-whatsapp' ); ?></h3>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_cart" value="yes" <?php checked( $omw_show_cart ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( 'Show WhatsApp button', 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'Display an order button on the cart page.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_cart" value="" <?php checked( ! $omw_show_cart ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( "Don't show", 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'No WhatsApp button on the cart.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<div class="owm-wizard-subsetting owm-conditional-subsetting" data-owm-show-when="evwapp_opiton_show_cart:yes"<?php echo $omw_show_cart ? '' : ' hidden'; ?>>
			<a href="#tab-cart" class="owm-wizard-subsetting__link" onclick="event.preventDefault(); document.getElementById('tab-cart').click();">
				<?php esc_html_e( 'Customize cart button and message →', 'woo-order-on-whatsapp' ); ?>
			</a>
		</div>
	</div>

	<div class="owm-wizard-question">
		<h3><?php esc_html_e( 'When a new order is placed...', 'woo-order-on-whatsapp' ); ?></h3>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_thank" value="yes" <?php checked( $omw_thank_redirect ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( 'Redirect customer to WhatsApp', 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'After checkout, send the customer to WhatsApp with an order summary.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_thank" value="api" <?php checked( $omw_thank_api ); ?>>
			<span class="owm-wizard-option__text">
				<strong>
					<?php esc_html_e( 'Automatic alert to my WhatsApp', 'woo-order-on-whatsapp' ); ?>
					<span class="owm-badge owm-badge--recommended"><?php esc_html_e( 'Recommended', 'woo-order-on-whatsapp' ); ?></span>
					<span class="owm-badge owm-badge--integration"><?php esc_html_e( 'Requires MyD Notifications', 'woo-order-on-whatsapp' ); ?></span>
				</strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'Send an automatic alert to the store WhatsApp when a new order is placed. Customer stays on the standard WooCommerce thank-you page.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_opiton_show_thank" value="" <?php checked( $omw_thank_off ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( "Don't redirect", 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'Customer stays on the standard WooCommerce thank-you page. No WhatsApp interaction after checkout.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<div class="owm-wizard-subsetting owm-conditional-subsetting" data-owm-show-when="evwapp_opiton_show_thank:yes"<?php echo $omw_thank_redirect ? '' : ' hidden'; ?>>
			<a href="#tab-checkout" class="owm-wizard-subsetting__link" onclick="event.preventDefault(); document.getElementById('tab-checkout').click();">
				<?php esc_html_e( 'Customize the checkout button and order message →', 'woo-order-on-whatsapp' ); ?>
			</a>
		</div>
		<div class="owm-wizard-subsetting owm-conditional-subsetting" data-owm-show-when="evwapp_opiton_show_thank:api"<?php echo $omw_thank_api ? '' : ' hidden'; ?>>
			<?php include OMW_PLUGIN_PATH . 'templates/admin/partials/license-status.php'; ?>
		</div>
	</div>

	<div class="owm-wizard-question">
		<h3><?php esc_html_e( 'When an order status changes...', 'woo-order-on-whatsapp' ); ?></h3>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_customer_notify_mode" value="yes" <?php checked( $omw_customer_notify ); ?>>
			<span class="owm-wizard-option__text">
				<strong>
					<?php esc_html_e( 'Notify customer via WhatsApp', 'woo-order-on-whatsapp' ); ?>
					<span class="owm-badge owm-badge--recommended"><?php esc_html_e( 'Recommended', 'woo-order-on-whatsapp' ); ?></span>
					<span class="owm-badge owm-badge--integration"><?php esc_html_e( 'Requires MyD Notifications', 'woo-order-on-whatsapp' ); ?></span>
				</strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'Automatically notify the customer on WhatsApp when the order status changes to one of the selected statuses.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<label class="owm-wizard-option">
			<input type="radio" name="evwapp_customer_notify_mode" value="no" <?php checked( ! $omw_customer_notify ); ?>>
			<span class="owm-wizard-option__text">
				<strong><?php esc_html_e( "Don't notify", 'woo-order-on-whatsapp' ); ?></strong>
				<span class="owm-wizard-option__hint"><?php esc_html_e( 'Status changes do not trigger WhatsApp messages.', 'woo-order-on-whatsapp' ); ?></span>
			</span>
		</label>

		<div class="owm-wizard-subsetting owm-conditional-subsetting" data-owm-show-when="evwapp_customer_notify_mode:yes"<?php echo $omw_customer_notify ? '' : ' hidden'; ?>>
			<?php include OMW_PLUGIN_PATH . 'templates/admin/partials/license-status.php'; ?>
		</div>

		<div class="owm-wizard-subsetting owm-conditional-subsetting" data-owm-show-when="evwapp_customer_notify_mode:yes"<?php echo $omw_customer_notify ? '' : ' hidden'; ?>>
			<p class="owm-wizard-subsetting__heading"><strong><?php esc_html_e( 'Trigger on these statuses:', 'woo-order-on-whatsapp' ); ?></strong></p>

			<div class="owm-status-checkboxes">
				<?php
				$omw_wc_statuses = function_exists( 'wc_get_order_statuses' ) ? wc_get_order_statuses() : [];
				foreach ( $omw_wc_statuses as $omw_wc_key => $omw_wc_label ) :
					$omw_slug = preg_replace( '/^wc-/', '', $omw_wc_key );
					?>
					<label class="owm-status-checkbox">
						<input type="checkbox" name="evwapp_notifications_statuses[]" value="<?php echo esc_attr( $omw_slug ); ?>" <?php checked( in_array( $omw_slug, $omw_notify_statuses, true ) ); ?>>
						<?php echo esc_html( $omw_wc_label ); ?>
					</label>
				<?php endforeach; ?>
			</div>
		</div>
	</div>

	<div class="card">
		<h3><?php esc_html_e( 'Elementor widget (optional)', 'woo-order-on-whatsapp' ); ?></h3>
		<p><?php esc_html_e( 'If you use Elementor, drop the "Order on WhatsApp Button" widget on any page, post or template. Target a specific product or use the current page dynamically.', 'woo-order-on-whatsapp' ); ?></p>
	</div>
</div>
