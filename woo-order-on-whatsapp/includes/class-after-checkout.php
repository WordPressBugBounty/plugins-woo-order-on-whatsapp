<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

Class OWW_After_Checkout {
	/**
	 * Current order object
	 *
	 * @since 2.8
	 * @var array
	 */
	public $current_order;

	/**
	 * Current order id
	 *
	 * @since 2.8
	 * @var int
	 */
	protected $order_id;

	/**
	 * Construct Class
	 *
	 * @since 2.7
	 * @return void
	 */
	public function __construct() {}

	/**
	 * Init function
	 *
	 * @since 2.8
	 * @return void
	 */
	public function init( $order_id ) {
		$this->order_id = $order_id;
		$this->evcode_show_btn_thankyou();
	}

	/*
	*
	* Generate link and redirect after order process.
	*
	*/
	public function evcode_show_btn_thankyou() {

		///get options
		$phone = OMW_Plugin::instance()->phone_number;

		///get order data
		$order_id = $this->order_id;
		$order = wc_get_order( $order_id );
		$this->current_order = $order;
		$item = $order->get_items();

		foreach ($item as $key => $value) {

			$atributes = $value->get_formatted_meta_data(' ', true);

			foreach ($atributes as $key => $atribute) {

				if( !is_numeric( $atribute->value ) ) {

					$list_atributes[] = trim( strip_tags( $atribute->display_value ) );
				} else {
					$list_atributes[] = '';
				}
			}

			$product_obj = wc_get_product( ! empty( $value['variation_id'] ) ? $value['variation_id'] : $value['product_id'] );
			$product_sku = $product_obj ? $product_obj->get_sku() : '';

			$price = OMW_Utils::format_price( $value->get_total() );

			$list_atributes = empty( $list_atributes ) ? '' : implode( PHP_EOL, $list_atributes );
			$p_name = strip_tags( $value['name'] );
			$products[] = ''.$this->convert_custom_loop( $p_name, $price, $value['quantity'], $product_sku, $list_atributes, $product_obj ) . PHP_EOL . PHP_EOL .'';
			unset($list_atributes);
		}

		$order_info = ['user_name' => ''.$order->get_billing_first_name().' '.$order->get_billing_last_name().'',
					'user_phone' => $order->get_billing_phone(),
					'user_mail' => $order->get_billing_email(),
					'user_addres' => ''.$order->get_billing_address_1().' '.$order->get_billing_address_2().'',
					'user_city' => $order->get_billing_city(),
					'user_state' => $order->get_billing_state(),
					'user_zip' => $order->get_billing_postcode(),
					'user_payment' => $order->get_payment_method_title(),
					'user_note' => $order->get_customer_note(),
					'order_subtotal' => OMW_Utils::format_price( $order->get_subtotal() ),
					'order_total' => OMW_Utils::format_price( $order->get_total() ),
					'order_id' => $order_id,
					'shipping_total' => OMW_Utils::format_price( $order->get_shipping_total() ),
					'shipping_method' => $order->get_shipping_method(),
					'dinero_abonas' => get_post_meta( $order_id, 'exwfood_time_deli', true ),
					];

		$txt_final = $this->convert_custom_message( $order_info, implode( $products ) );
		$txt_final = urlencode( html_entity_decode ( $txt_final, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
		$link_redirect = 'https://wa.me/'.$phone.'?text='.$txt_final.'';
		header('Location: '.$link_redirect.'');
		exit;
	}


	/*
	*
	* Convert custom Loop Products
	*
	*/
	public function convert_custom_loop ($name, $price, $qty, $sku, $atributes, $product = null) {

		$option = get_option('evwapp_opiton_product_order_message');

		if( empty($option) ) {
			return ''.$qty.'x - '.$name.' - sku: '.$sku. PHP_EOL .$atributes.'';
		}

		$weight = $product ? $product->get_weight() : '';
		$height = $product ? $product->get_height() : '';
		$width = $product ? $product->get_width() : '';
		$length = $product ? $product->get_length() : '';
		$product_id = $product ? $product->get_id() : '';
		$product_link = $product ? get_permalink( $product->get_parent_id() ?: $product->get_id() ) : '';
		$short_description = '';
		$categories = '';

		if ( $product ) {
			$short_description = strip_tags( $product->get_short_description() );

			if ( empty( $short_description ) && $product->get_parent_id() ) {
				$parent = wc_get_product( $product->get_parent_id() );
				$short_description = $parent ? strip_tags( $parent->get_short_description() ) : '';
			}

			$cat_product_id = $product->get_parent_id() ?: $product->get_id();
			$terms = get_the_terms( $cat_product_id, 'product_cat' );

			if ( $terms && ! is_wp_error( $terms ) ) {
				$categories = implode( ', ', wp_list_pluck( $terms, 'name' ) );
			}
		}

		$tags = [
			'{product-name}' => $name,
			'{product-price}' => $price,
			'{product-qty}' => $qty,
			'{product-sku}' => $sku,
			'{product-atributes}' => $atributes,
			'{product-weight}' => $weight,
			'{product-height}' => $height,
			'{product-width}' => $width,
			'{product-length}' => $length,
			'{product-category}' => $categories,
			'{product-id}' => $product_id,
			'{product-link}' => $product_link,
			'{product-short-description}' => $short_description,
		];

		foreach ($tags as $key => $value) {

			$option = str_replace($key, $value, $option);
		}

		// Dynamic product custom fields: {product-meta-{[field_name]}
		if ( $product ) {
			preg_match_all( '/\{product-meta-\{\[([^\]]+)\]\}/', $option, $meta_matches );

			if ( ! empty( $meta_matches[1] ) ) {
				foreach ( $meta_matches[1] as $index => $field_name ) {
					$meta_value = get_post_meta( $product->get_id(), $field_name, true );

					if ( empty( $meta_value ) && $product->get_parent_id() ) {
						$meta_value = get_post_meta( $product->get_parent_id(), $field_name, true );
					}

					$option = str_replace( $meta_matches[0][ $index ], $meta_value, $option );
				}
			}
		}

		return $option;
	}


	/*
	*
	* Convert custom template message
	*
	*/
	public function convert_custom_message ( $order_info, $products ) {

		$message = get_option( 'evwapp_opiton_order_message' );

		if( empty( $message ) ) {
			return '📦 n: ' . $order_info['order_id'] . '%0D%0A%0D%0A' . implode($products) . '%0D%0A*' . $order_info['order_total'] . '*%0D%0A%0D%0A' . $order_info['user_name'] .'%0D%0A' . $order_info['user_mail'] . '%0D%0A' . $order_info['user_phone'] . '%0D%0A' . $order_info['user_addres'] . '%0D%0A' . $order_info['user_city_state'] . '%0D%0A' . $order_info['user_zip'] . '%0D%0A' . $order_info['user_payment'] . '%0D%0A' . $order_info['user_note'] . '';
		}

		$tags = [
			'{order-number}' => $order_info['order_id'],
			'{order-payment}' => $order_info['user_payment'],
			'{order-subtotal}' => $order_info['order_subtotal'],
			'{order-total}' => $order_info['order_total'],
			'{order-note}' => $order_info['user_note'],
			'{order-products}' => $products,
			'{customer-name}' => $order_info['user_name'],
			'{customer-phone}' => $order_info['user_phone'],
			'{customer-mail}' => $order_info['user_mail'],
			'{customer-address}' => $order_info['user_addres'],
			'{customer-state}' => $order_info['user_state'],
			'{customer-city}' => $order_info['user_city'],
			'{customer-zipcode}' => $order_info['user_zip'],
			'{shipping-total}' => $order_info['shipping_total'],
			'{shipping-method}' => $order_info['shipping_method'],
			'{dinero-abonas}' => $order_info['dinero_abonas']
		];

		foreach ( $tags as $key => $value ) {

			$message = str_replace( $key, $value, $message );
		}

		preg_match_all( '/\{meta-\{\[([^\]]+)\]\}/', $message, $meta_matches );

		if ( ! empty( $meta_matches[1] ) ) {
			foreach ( $meta_matches[1] as $index => $field_name ) {
				$meta_value = get_post_meta( $order_info['order_id'], $field_name, true );
				$message = str_replace( $meta_matches[0][ $index ], $meta_value, $message );
			}
		}

		/**
		 * get and replace meta field data
		 */
		preg_match_all( '/\{meta-data-\{\[([^\]]+)\]\}/', $message, $meta_data_matches );

		if ( ! empty( $meta_data_matches[1] ) ) {
			foreach ( $meta_data_matches[1] as $index => $field_name ) {
				$meta_value = $this->current_order->get_meta( $field_name );
				$message = str_replace( $meta_data_matches[0][ $index ], $meta_value, $message );
			}
		}

		return $message;
	}

}
