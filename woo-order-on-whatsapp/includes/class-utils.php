<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class with static methos to help and formating the plugins/functions.
 *
 * @since 2.8
 */
class OMW_Utils {
	/**
	 * Simple break line.
	 *
	 * @var string
	 */
	public static $break_line = PHP_EOL;

	/**
	 * Double breal line
	 *
	 * @var string
	 */
	public static $doble_break_line = PHP_EOL . PHP_EOL;

	/**
	 * Format phone like a woocommerce settins
	 *
	 * @param $price
	 * @return string
	 * @since 2.8
	 */
	public static function format_price( $price ) {
		if ( ! is_numeric( $price ) ) {
			return '';
		}

		$currency = get_woocommerce_currency_symbol();
		$thousand_separator = get_option( 'woocommerce_price_thousand_sep' );
		$decimal_separator = get_option( 'woocommerce_price_decimal_sep');
		$number_of_decimals = get_option( 'woocommerce_price_num_decimals' );

		return $currency . ' ' . number_format( (float) $price, $number_of_decimals, $decimal_separator, $thousand_separator );
	}

	/**
	 * Price of the cheapest MyD Notifications plan (Starter), shown on upgrade prompts.
	 *
	 * @return string
	 * @since 4.2
	 */
	public static function myd_starter_price() {
		return __( '$9/month', 'woo-order-on-whatsapp' );
	}
}
