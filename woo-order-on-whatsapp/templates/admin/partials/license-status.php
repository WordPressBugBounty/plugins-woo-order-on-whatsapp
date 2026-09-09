<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omw_license_configured = ! empty( get_option( 'evwapp_myd_api_key', '' ) );
$omw_license_variant    = $omw_license_configured ? 'success' : 'warning';
?>
<div class="owm-license-status owm-license-status--<?php echo esc_attr( $omw_license_variant ); ?>">
	<?php if ( $omw_license_configured ) : ?>
		<span class="dashicons dashicons-yes-alt"></span>
		<span>
			<?php esc_html_e( 'License configured.', 'woo-order-on-whatsapp' ); ?>
			<a href="#tab-integrations" onclick="event.preventDefault(); document.getElementById('tab-integrations').click();">
				<?php esc_html_e( 'Manage in Integrations', 'woo-order-on-whatsapp' ); ?>
			</a>
		</span>
	<?php else : ?>
		<span class="dashicons dashicons-warning"></span>
		<span>
			<?php esc_html_e( 'License not configured.', 'woo-order-on-whatsapp' ); ?>
			<a href="#tab-integrations" onclick="event.preventDefault(); document.getElementById('tab-integrations').click();">
				<?php esc_html_e( 'Configure in Integrations', 'woo-order-on-whatsapp' ); ?>
			</a>
		</span>
	<?php endif; ?>
</div>

<?php if ( ! $omw_license_configured ) : ?>
	<div class="owm-license-upsell">
		<p class="owm-license-upsell__text">
			<?php
			printf(
				/* translators: %s: price of the cheapest plan, e.g. "$9/month" */
				esc_html__( 'No plan yet? Automated WhatsApp notifications from %s', 'woo-order-on-whatsapp' ),
				'<strong>' . esc_html( OMW_Utils::myd_starter_price() ) . '</strong>'
			);
			?>
		</p>
		<a href="https://services.myddelivery.com/signup?utm_source=woo-order-on-whatsapp&utm_medium=wp-admin&utm_campaign=myd-notifications&utm_content=license-status" target="_blank" class="mydd-admin-button"><?php esc_html_e( 'See plans', 'woo-order-on-whatsapp' ); ?> ↗</a>
	</div>
<?php endif; ?>
