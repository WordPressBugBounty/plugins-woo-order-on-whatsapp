<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omw_enabled = get_option( 'evwapp_opiton_show_btn_single' ) === 'yes';
?>
<div id="tab-product-page-content" class="myd-tabs-content">
	<h2><?php esc_html_e( 'Product Page', 'woo-order-on-whatsapp' ); ?></h2>

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
						<label for="evwapp_opiton_message"><?php esc_html_e( 'Your custom message', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<textarea name="evwapp_opiton_message" id="evwapp_opiton_message" class="large-text" rows="5"><?php echo esc_textarea( get_option( 'evwapp_opiton_message' ) ); ?></textarea>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="evwapp_opiton_text_button"><?php esc_html_e( 'Button text', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="text" name="evwapp_opiton_text_button" id="evwapp_opiton_text_button" class="regular-text" value="<?php echo esc_attr( get_option( 'evwapp_opiton_text_button' ) ); ?>">
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="evwapp_opiton_target"><?php esc_html_e( 'Open in new tab?', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="evwapp_opiton_target" id="evwapp_opiton_target" value="_blank" <?php checked( get_option( 'evwapp_opiton_target' ), '_blank' ); ?>><?php esc_html_e( 'Yes, open in new tab.', 'woo-order-on-whatsapp' ); ?><br>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="evwapp_opiton_remove_btn"><?php esc_html_e( 'Hide button on desktop device?', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="evwapp_opiton_remove_btn" id="evwapp_opiton_remove_btn" value="yes" <?php checked( get_option( 'evwapp_opiton_remove_btn' ), 'yes' ); ?>><?php esc_html_e( 'Yes, remove WhatsApp Button on Desktop.', 'woo-order-on-whatsapp' ); ?><br>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="evwapp_opiton_remove_price"><?php esc_html_e( 'Hide Price in Product Page?', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="evwapp_opiton_remove_price" id="evwapp_opiton_remove_price" value="yes" <?php checked( get_option( 'evwapp_opiton_remove_price' ), 'yes' ); ?>><?php esc_html_e( 'Yes, remove price in Product page.', 'woo-order-on-whatsapp' ); ?><br>
					</td>
				</tr>

				<tr>
					<th scope="row">
						<label for="evwapp_opiton_remove_cart_btn"><?php esc_html_e( 'Hide "Add to Cart" Button?', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<input type="checkbox" name="evwapp_opiton_remove_cart_btn" id="evwapp_opiton_remove_cart_btn" value="yes" <?php checked( get_option( 'evwapp_opiton_remove_cart_btn' ), 'yes' ); ?>><?php esc_html_e( 'Yes, remove Add to Cart button.', 'woo-order-on-whatsapp' ); ?><br>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
