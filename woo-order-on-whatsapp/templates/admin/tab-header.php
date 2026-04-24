<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wrap">

	<h1><?php esc_html_e( 'Order on WhatsApp for WooCommerce', 'woo-order-on-whatsapp' );?></h1>
	<?php settings_errors(); ?>

	<nav class="nav-tab-wrapper">
		<a href="#tab-setup" id="tab-setup" class="nav-tab myd-tab nav-tab-active" onclick="mydChangeTab(event)"><?php esc_html_e( 'Setup', 'woo-order-on-whatsapp' );?></a>
		<a href="#tab-product-page" id="tab-product-page" class="nav-tab myd-tab" onclick="mydChangeTab(event)"><?php esc_html_e( 'Product Page', 'woo-order-on-whatsapp' );?></a>
		<a href="#tab-cart" id="tab-cart" class="nav-tab myd-tab" onclick="mydChangeTab(event)"><?php esc_html_e( 'Cart', 'woo-order-on-whatsapp' );?></a>
		<a href="#tab-checkout" id="tab-checkout" class="nav-tab myd-tab" onclick="mydChangeTab(event)"><?php esc_html_e( 'Checkout', 'woo-order-on-whatsapp' );?></a>
		<a href="#tab-integrations" id="tab-integrations" class="nav-tab myd-tab" onclick="mydChangeTab(event)"><?php esc_html_e( 'Integrations', 'woo-order-on-whatsapp' );?></a>
		<a href="#tab-support" id="tab-support" class="nav-tab myd-tab" onclick="mydChangeTab(event)"><?php esc_html_e( 'Support', 'woo-order-on-whatsapp' );?></a>
	</nav>

	<form method="post" action="options.php">
	<?php settings_fields( 'evwapp-settings-group' ); ?>
