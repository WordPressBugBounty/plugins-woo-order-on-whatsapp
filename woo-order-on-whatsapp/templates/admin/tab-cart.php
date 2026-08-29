<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omw_enabled = get_option( 'evwapp_opiton_show_cart' ) === 'yes';
?>
<div id="tab-cart-content" class="myd-tabs-content">
	<h2><?php esc_html_e( 'Cart', 'woo-order-on-whatsapp' ); ?></h2>

	<?php if ( ! $omw_enabled ) : ?>
		<div class="owm-tab-disabled-notice">
			<p>
				<?php esc_html_e( 'This feature is disabled.', 'woo-order-on-whatsapp' ); ?>
				<a href="#tab-setup" onclick="event.preventDefault(); document.getElementById('tab-setup').click();"><?php esc_html_e( 'Enable it in Setup.', 'woo-order-on-whatsapp' ); ?></a>
			</p>
		</div>
	<?php endif; ?>

	<div class="owm-tab-fields<?php echo $omw_enabled ? '' : ' owm-tab-fields--inactive'; ?>"<?php echo $omw_enabled ? '' : ' inert'; ?>>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row">
						<label for="evwapp_opiton_text_button_cart"><?php esc_html_e( 'Button text', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="text" name="evwapp_opiton_text_button_cart" id="evwapp_opiton_text_button_cart" class="regular-text" value="<?php echo esc_attr( get_option( 'evwapp_opiton_text_button_cart' ) ); ?>">
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="evwapp_opiton_cart_button_target"><?php esc_html_e( 'Open in new tab?', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="evwapp_opiton_cart_button_target" id="evwapp_opiton_cart_button_target" value="_blank" <?php checked( get_option( 'evwapp_opiton_cart_button_target' ), '_blank' ); ?>><?php esc_html_e( 'Yes, open in new tab.', 'woo-order-on-whatsapp' ); ?><br>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="card">
			<h3><?php esc_html_e( 'How to use?', 'woo-order-on-whatsapp' ); ?></h3>
			<p>1 - <?php esc_html_e( 'Define the template for products loop in "Template for Products Loop" for use in your custom message.', 'woo-order-on-whatsapp' ); ?></p>
			<p>2 - <?php esc_html_e( 'Create full custom message in "Custom Cart Message" for use when customer sends the cart to WhatsApp.', 'woo-order-on-whatsapp' ); ?></p>
			<p>3 - <?php esc_html_e( 'Leave "Custom Cart Message" empty to keep the default cart layout.', 'woo-order-on-whatsapp' ); ?></p>
		</div>

		<h3><?php esc_html_e( 'Template for Products Loop', 'woo-order-on-whatsapp' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Avaliable tokens for product loop.', 'woo-order-on-whatsapp' ); ?></p>

		<ul>
			<li><code>{product-name}</code> - <?php esc_html_e( 'Product Name', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-price}</code> - <?php esc_html_e( 'Line Total (quantity x price)', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-unit-price}</code> - <?php esc_html_e( 'Product Unit Price', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-qty}</code> - <?php esc_html_e( 'Product Quantity', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-sku}</code> - <?php esc_html_e( 'Product Sku', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-atributes}</code> - <?php esc_html_e( 'Product Atributes', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-weight}</code> - <?php esc_html_e( 'Product Weight', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-height}</code> - <?php esc_html_e( 'Product Height', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-width}</code> - <?php esc_html_e( 'Product Width', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-length}</code> - <?php esc_html_e( 'Product Length', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-category}</code> - <?php esc_html_e( 'Product Category', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-id}</code> - <?php esc_html_e( 'Product ID', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-link}</code> - <?php esc_html_e( 'Product Link. Variations link to the options the customer chose', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-short-description}</code> - <?php esc_html_e( 'Product Short Description', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{product-meta-{[your-field-name]}</code> - <?php esc_html_e( 'Get value from product custom fields (post meta)', 'woo-order-on-whatsapp' ); ?> . </li>
		</ul>

		<textarea name="evwapp_opiton_cart_products_message" class="large-text" rows="6"><?php echo esc_textarea( get_option( 'evwapp_opiton_cart_products_message' ) ); ?></textarea>

		<div class="card">
			<h3><?php esc_html_e( 'Important:', 'woo-order-on-whatsapp' ); ?></h3>
			<p><?php esc_html_e( '"Template for Products Loop" its a loop, so you must use each token once. The plugin will repeat this loop for all products in your cart.', 'woo-order-on-whatsapp' ); ?></p>
		</div>

		<h3><?php esc_html_e( 'Custom Cart Message', 'woo-order-on-whatsapp' ); ?></h3>
		<p class="description"><?php esc_html_e( 'Avaliable tokens for message.', 'woo-order-on-whatsapp' ); ?></p>

		<ul>
			<li><code>{cart-products}</code> - <?php esc_html_e( "Cart Products. This token is the result of the configuration above, don't forget to add it.", 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-subtotal}</code> - <?php esc_html_e( 'Cart Subtotal', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-total}</code> - <?php esc_html_e( 'Cart Total', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-discount}</code> - <?php esc_html_e( 'Cart Discount', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-coupons}</code> - <?php esc_html_e( 'Applied Coupons', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-tax}</code> - <?php esc_html_e( 'Cart Tax', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-fees}</code> - <?php esc_html_e( 'Cart Fees', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-items-count}</code> - <?php esc_html_e( 'Number of items in the cart', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-weight}</code> - <?php esc_html_e( 'Total weight of the cart', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{cart-url}</code> - <?php esc_html_e( 'Cart Link', 'woo-order-on-whatsapp' ); ?> . </li>
			<li><code>{checkout-url}</code> - <?php esc_html_e( 'Checkout Link', 'woo-order-on-whatsapp' ); ?> . </li>
		</ul>

		<textarea name="evwapp_opiton_cart_full_message" class="large-text" rows="20"><?php echo esc_textarea( get_option( 'evwapp_opiton_cart_full_message' ) ); ?></textarea>
	</div>
</div>
