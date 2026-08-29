<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class to implement button in woocommerce cart page
 *
 * @since 2.8
 */
class OMW_Button_Cart extends OMW_Button {
	/**
	 * Cart items object
	 *
	 * @since 2.8
	 */
	public $cart_items;

	/**
	 * Construct the class
	 *
	 * @since 2.8
	 */
	public function __construct() {
		$this->button_custom_message = get_option( 'evwapp_opiton_message_cart' );
		$this->button_text = get_option( 'evwapp_opiton_text_button_cart' );
		$this->target = get_option( 'evwapp_opiton_cart_button_target' );
	}

	/**
	 * Output button
	 *
	 * @since 2.8
	 * @return void
	 */
	public function output_btn() {
		if ( is_cart() ) {
			$this->cart_items = WC()->cart->get_cart_contents();
			$shared_text = $this->create_shared_text();
			$whatsapp_link = $this->create_whatsapp_link( $shared_text );
			$this->create_button( $whatsapp_link, $this->target, $this->button_text );
		}
	}

	/**
	 * Create shared text
	 *
	 * @since 2.8
	 */
	public function create_shared_text() {
		$template = get_option( 'evwapp_opiton_cart_full_message' );

		if ( ! empty( $template ) ) {
			return $this->convert_custom_message( $template );
		}

		return sprintf(
			'%1$s%2$s%3$s%4$s%5$s',
			$this->button_custom_message,
			OMW_Utils::$doble_break_line,
			implode( OMW_Utils::$break_line, $this->get_cart_items() ),
			OMW_Utils::$break_line,
			__( 'Cart Total: ', 'woo-order-on-whatsapp' ) . $this->get_formated_cart_total()
		);
	}

	/**
	 * Replace cart tokens in the custom message template
	 *
	 * @since 4.1
	 * @param string $template
	 * @return string
	 */
	public function convert_custom_message( $template ) {
		$cart = WC()->cart;

		$tags = [
			'{cart-products}' => $this->convert_custom_loop(),
			'{cart-subtotal}' => OMW_Utils::format_price( $cart->get_subtotal() + $cart->get_subtotal_tax() ),
			'{cart-total}' => OMW_Utils::format_price( $cart->get_total( 'edit' ) ),
			'{cart-discount}' => OMW_Utils::format_price( $cart->get_discount_total() + $cart->get_discount_tax() ),
			'{cart-tax}' => OMW_Utils::format_price( $cart->get_total_tax() ),
			'{cart-fees}' => OMW_Utils::format_price( $cart->get_fee_total() ),
			'{cart-items-count}' => $cart->get_cart_contents_count(),
			'{cart-weight}' => $cart->get_cart_contents_weight(),
			'{cart-coupons}' => implode( ', ', $cart->get_applied_coupons() ),
			'{cart-url}' => wc_get_cart_url(),
			'{checkout-url}' => wc_get_checkout_url(),
		];

		return str_replace( array_keys( $tags ), array_values( $tags ), $template );
	}

	/**
	 * Render every cart item through the products loop template
	 *
	 * @since 4.1
	 * @return string
	 */
	public function convert_custom_loop() {
		$template = get_option( 'evwapp_opiton_cart_products_message' );

		$items = empty( $template )
			? $this->get_cart_items()
			: array_map(
				fn( $cart_item ) => $this->convert_product_tokens( $template, $cart_item ),
				(array) $this->cart_items
			);

		return implode( OMW_Utils::$break_line, $items );
	}

	/**
	 * Replace product tokens for a single cart item
	 *
	 * @since 4.1
	 * @param string $template
	 * @param array $cart_item
	 * @return string
	 */
	public function convert_product_tokens( $template, $cart_item ) {
		$product = $cart_item['data'];
		$catalog_id = $product->get_parent_id() ?: $product->get_id();

		$tags = [
			'{product-name}' => $product->get_name(),
			'{product-price}' => OMW_Utils::format_price( $this->get_item_line_total( $cart_item ) ),
			'{product-unit-price}' => OMW_Utils::format_price( wc_get_price_including_tax( $product ) ),
			'{product-qty}' => $cart_item['quantity'],
			'{product-sku}' => $product->get_sku(),
			'{product-atributes}' => wp_strip_all_tags( wc_get_formatted_cart_item_data( $cart_item, true ) ),
			'{product-weight}' => $product->get_weight(),
			'{product-height}' => $product->get_height(),
			'{product-width}' => $product->get_width(),
			'{product-length}' => $product->get_length(),
			'{product-category}' => implode( ', ', wc_get_product_terms( $catalog_id, 'product_cat', [ 'fields' => 'names' ] ) ),
			'{product-id}' => $product->get_id(),
			'{product-link}' => $product->get_permalink( $cart_item ),
			'{product-short-description}' => $this->get_product_short_description( $product ),
		];

		$message = str_replace( array_keys( $tags ), array_values( $tags ), $template );

		return $this->convert_product_meta_tokens( $message, $product );
	}

	/**
	 * Replace the dynamic {product-meta-{[field]} tokens with product custom fields
	 *
	 * @since 4.1
	 * @param string $message
	 * @param object $product
	 * @return string
	 */
	public function convert_product_meta_tokens( $message, $product ) {
		preg_match_all( '/\{product-meta-\{\[([^\]]+)\]\}/', $message, $matches );

		foreach ( $matches[1] as $index => $field_name ) {
			$value = get_post_meta( $product->get_id(), $field_name, true );

			if ( empty( $value ) && $product->get_parent_id() ) {
				$value = get_post_meta( $product->get_parent_id(), $field_name, true );
			}

			$message = str_replace( $matches[0][ $index ], is_scalar( $value ) ? $value : '', $message );
		}

		return $message;
	}

	/**
	 * Line total including taxes, falling back to the item price when totals were not calculated yet
	 *
	 * @since 4.1
	 * @param array $cart_item
	 * @return float
	 */
	public function get_item_line_total( $cart_item ) {
		if ( isset( $cart_item['line_total'] ) ) {
			return $cart_item['line_total'] + ( $cart_item['line_tax'] ?? 0 );
		}

		return wc_get_price_including_tax( $cart_item['data'], [ 'qty' => $cart_item['quantity'] ] );
	}

	/**
	 * Product short description, falling back to the parent product for variations
	 *
	 * @since 4.1
	 * @param object $product
	 * @return string
	 */
	public function get_product_short_description( $product ) {
		$short_description = wp_strip_all_tags( $product->get_short_description() );

		if ( empty( $short_description ) && $product->get_parent_id() ) {
			$parent = wc_get_product( $product->get_parent_id() );
			$short_description = $parent ? wp_strip_all_tags( $parent->get_short_description() ) : '';
		}

		return $short_description;
	}

	/**
	 * Get cart items
	 *
	 * @since 2.8
	 * @return array
	 */
	public function get_cart_items() {
		$cart = $this->cart_items;
		if( empty( $cart ) ) {
			return array();
		}

		$items = array();
		foreach ( $cart as $cart_item ) {
			$product = $cart_item['data'];
			$product_variation = '';
			if ( $product->get_type() === 'variation' ) {
				$product_variation = implode( ',', $cart_item['data']->get_variation_attributes() );
			}

			$items[] = sprintf(
				'-> %1$s x %2$s %3$s = %4$s %5$s',
				$cart_item['quantity'],
				$product->get_name(),
				$product_variation,
				$this->get_formmated_price( $product ),
				OMW_Utils::$break_line
			);
		}

		return $items;
	}

	/**
	 * Get formated cart total
	 *
	 * @since 2.8
	 */
	public function get_formated_cart_total() {
		$cart_total = WC()->cart->get_cart_contents_total();
		return OMW_Utils::format_price( $cart_total );
	}
}
