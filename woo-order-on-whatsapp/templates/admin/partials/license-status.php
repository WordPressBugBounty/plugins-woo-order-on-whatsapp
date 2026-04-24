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
