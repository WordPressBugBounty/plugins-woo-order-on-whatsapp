<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$omw_api_key    = get_option( 'evwapp_myd_api_key', '' );
$omw_enabled    = get_option( 'evwapp_notifications_enabled' ) === 'yes';
$omw_error_log  = get_option( 'evwapp_notifications_error_log', [] );
$omw_error_log  = is_array( $omw_error_log ) ? $omw_error_log : [];
?>
<div id="tab-integrations-content" class="myd-tabs-content">
	<h2><?php esc_html_e( 'Integrations', 'woo-order-on-whatsapp' ); ?></h2>

	<h3><?php esc_html_e( 'MyD Notifications', 'woo-order-on-whatsapp' ); ?></h3>
	<p class="description">
		<?php
		printf(
			/* translators: %s: link to MyD Notifications plans */
			esc_html__( 'Send automated WhatsApp notifications through the official Meta API. Configure your license key below to unlock store alerts and customer status updates. %s', 'woo-order-on-whatsapp' ),
			'<a href="https://myddelivery.com/notifications/" target="_blank">' . esc_html__( 'See plans', 'woo-order-on-whatsapp' ) . ' ↗</a>'
		);
		?>
	</p>

	<table class="form-table">
		<tbody>
			<tr>
				<th scope="row">
					<label for="evwapp_myd_api_key"><?php esc_html_e( 'License Key', 'woo-order-on-whatsapp' ); ?></label>
				</th>
				<td>
					<input
						type="password"
						name="evwapp_myd_api_key"
						id="evwapp_myd_api_key"
						class="regular-text"
						value="<?php echo esc_attr( $omw_api_key ); ?>"
						autocomplete="off"
					>
					<p class="description">
						<?php esc_html_e( 'Paste your MyD license key to enable automated WhatsApp notifications.', 'woo-order-on-whatsapp' ); ?>
					</p>
				</td>
			</tr>

			<tr>
				<th scope="row"><?php esc_html_e( 'Status', 'woo-order-on-whatsapp' ); ?></th>
				<td>
					<label>
						<input
							type="checkbox"
							name="evwapp_notifications_enabled"
							id="evwapp_notifications_enabled"
							value="yes"
							<?php checked( $omw_enabled ); ?>
						>
						<?php esc_html_e( 'Send notifications actively', 'woo-order-on-whatsapp' ); ?>
					</label>
					<p class="description">
						<?php esc_html_e( 'Uncheck to pause temporarily. Your Setup choices are preserved.', 'woo-order-on-whatsapp' ); ?>
					</p>
				</td>
			</tr>
		</tbody>
	</table>

	<?php if ( ! empty( $omw_error_log ) ) : ?>
		<h3><?php esc_html_e( 'Recent notification errors', 'woo-order-on-whatsapp' ); ?></h3>
		<p class="description">
			<?php
			printf(
				/* translators: %d: max log entries */
				esc_html__( 'The last %d errors are kept here for troubleshooting.', 'woo-order-on-whatsapp' ),
				(int) OMW_Notifications::ERROR_LOG_MAX
			);
			?>
		</p>

		<table class="wp-list-table widefat fixed striped owm-error-log-table">
			<thead>
				<tr>
					<th><?php esc_html_e( 'Date', 'woo-order-on-whatsapp' ); ?></th>
					<th><?php esc_html_e( 'Order', 'woo-order-on-whatsapp' ); ?></th>
					<th><?php esc_html_e( 'Status', 'woo-order-on-whatsapp' ); ?></th>
					<th><?php esc_html_e( 'Error', 'woo-order-on-whatsapp' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $omw_error_log as $entry ) : ?>
					<tr>
						<td><?php echo esc_html( isset( $entry['date'] ) ? $entry['date'] : '' ); ?></td>
						<td>#<?php echo esc_html( isset( $entry['order_id'] ) ? $entry['order_id'] : '' ); ?></td>
						<td><?php echo esc_html( isset( $entry['status'] ) ? $entry['status'] : '' ); ?></td>
						<td>
							<code><?php echo esc_html( isset( $entry['error_code'] ) ? $entry['error_code'] : '' ); ?></code>
							<?php echo esc_html( isset( $entry['error_message'] ) ? $entry['error_message'] : '' ); ?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
