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
						<label for="evwapp_opiton_message_cart"><?php esc_html_e( 'Your custom message', 'woo-order-on-whatsapp' ); ?></label>
					</th>
					<td>
						<textarea name="evwapp_opiton_message_cart" id="evwapp_opiton_message_cart" class="large-text" rows="5"><?php echo esc_textarea( get_option( 'evwapp_opiton_message_cart' ) ); ?></textarea>
					</td>
				</tr>

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
	</div>
</div>
