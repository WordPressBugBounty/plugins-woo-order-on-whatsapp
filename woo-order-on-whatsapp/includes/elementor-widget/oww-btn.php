<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * oww Elementor Tabs Widget
 *
 * oww custom widget for tabs on Elementor.
 *
 * @since 2.3
 */
class OWW_Btn_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oww-tabs widget name.
	 *
	 * @since 2.3
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'oww-btn';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oww Tabs widget title.
	 *
	 * @since 2.3
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Order on WhatsApp Button', 'woo-order-on-whatsapp' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 2.3
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-products';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 2.3
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'general' ];
	}

	/**
	 * Get products options.
	 *
	 * Retrieve options to select.
	 *
	 * @since 2.3
	 * @access public
	 *
	 * @return string select options.
	 */
	public function get_products() {

		$args = [
			'post_type' => 'product',
			'no_found_rows' => true,
		];

		$products = new WP_Query( $args );
		$products = $products->get_posts();

		$product_options = [];
		$product_options['select-product'] = 'Selecione';
		$product_options['current'] = 'Current Page/Posts';

		foreach( $products as $value ) {

			$product_options[ $value->ID ] = $value->post_title;
		}

		wp_reset_postdata();
		return $product_options;
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 2.3
	 * @access protected
	 */
	protected function register_controls() {

		/// content control tab
		$this->start_controls_section(
			'oww_section_product',
			[
				'label' => __( 'Product', 'woo-order-on-whatsapp' ),
			]
		);

		$this->add_control(
			'oww_select_product',
			[
				'label' => __( 'Select product', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => 'select-product',
				'description' => __( 'If you select <code>Current Page/Post</code> button get page/post id dynamically.', 'woo-order-on-whatsapp' ),
				'options' => $this->get_products(),
				'label_block' => true,
			]
		);

		$this->add_control(
			'oww_phone',
			[
				'label' => __( 'WhatsApp Phone', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( '', 'woo-order-on-whatsapp' ),
				'placeholder' => __( '5551XXXXXXXXX', 'woo-order-on-whatsapp' ),
				'description' => __( 'Enter with your country code 5551XXXXXXXXX.', 'woo-order-on-whatsapp' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'oww_custom_text',
			[
				'label' => __( 'Custom message', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::TEXTAREA,
				'rows' => 8,
				'default' => __( '', 'woo-order-on-whatsapp' ),
				'placeholder' => __( 'Your custom message...', 'woo-order-on-whatsapp' ),
				'description' => __( 'Avaliable tokens for custom message: <br> <code>{product-name}</code> <br> <code>{product-price}</code> <br> <code>{product-link}</code>', 'woo-order-on-whatsapp' ),
			]
		);

		$this->add_control(
			'oww_text_btn',
			[
				'label' => __( 'Button Text', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => __( 'Button Text', 'woo-order-on-whatsapp' ),
				'placeholder' => __( 'Type text for button', 'woo-order-on-whatsapp' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'oww_target',
			[
				'label' => __( 'Open in new tab?', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::SWITCHER,
				'label_on' => __( '_blank', 'woo-order-on-whatsapp' ),
				'label_off' => __( '_self', 'woo-order-on-whatsapp' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'oww_section_content_style',
			[
				'label' 		=> __( 'Button', 'woo-order-on-whatsapp' ),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'content_background_color',
			[
				'label' => __( 'Background Color', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#47d366',
				'selectors' => [
					'{{WRAPPER}} .oww-btn-widget > a' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_align',
			[
				'label' => __( 'Alignment', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::CHOOSE,
				'options' => [
					'flex-start' => [
						'title' => __( 'Left', 'woo-order-on-whatsapp' ),
						'icon' => 'fa fa-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'woo-order-on-whatsapp' ),
						'icon' => 'fa fa-align-center',
					],
					'flex-end' => [
						'title' => __( 'Right', 'woo-order-on-whatsapp' ),
						'icon' => 'fa fa-align-right',
					],
				],
				'default' => 'flex-start',
				'toggle' => true,
				'selectors' 	=> [
					'{{WRAPPER}} .oww-btn-widget' => 'justify-content: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_margin',
			[
				'label' 		=> __( 'Margin', 'woo-order-on-whatsapp' ),
				'type'       	=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors' 	=> [
					'{{WRAPPER}} .oww-btn-widget > a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label'      	=> __( 'Padding', 'woo-order-on-whatsapp' ),
				'type'       	=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'default' => [
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  	=> [
					'{{WRAPPER}} .oww-btn-widget > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'content_border_radius',
			[
				'label'      	=> __( 'Container Border Radius', 'woo-order-on-whatsapp' ),
				'type'       	=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', '%' ],
				'default' => [
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  	=> [
					'{{WRAPPER}} .oww-btn-widget > a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();

		/// style control (text)
		$this->start_controls_section(
			'oww_section_title_style',
			[
				'label' 		=> __( 'Text', 'woo-order-on-whatsapp' ),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'fields_options' => [
					'typography' => [
						'default' => 'yes'
					],
					'font_size' => [
						'default' => [
							'size' => 16
						]
					],
					'font_weight' => [
						'default' => 600
					],
				],
				'selector' => '{{WRAPPER}} .oww-btn-widget > a',
			]
		);

		$this->add_control(
			'title_text_color',
			[
				'label' => __( 'Text Color', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} .oww-btn-widget > a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'oww_section_icon_style',
			[
				'label' 		=> __( 'Icon', 'woo-order-on-whatsapp' ),
				'tab' 			=> \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'oww_width',
			[
				'label' => __( 'Width', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
					],
				],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .oww-btn-widget > a > svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'icon_text_color',
			[
				'label' => __( 'Text Color', 'woo-order-on-whatsapp' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'default' => '#11bf76',
				'selectors' => [
					'{{WRAPPER}} .oww-btn-widget > a > svg' => 'fill: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_padding',
			[
				'label'      	=> __( 'Padding', 'woo-order-on-whatsapp' ),
				'type'       	=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'selectors'  	=> [
					'{{WRAPPER}} .oww-btn-widget > a > svg' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'icon_margin',
			[
				'label'      	=> __( 'Margin', 'woo-order-on-whatsapp' ),
				'type'       	=> \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em', '%' ],
				'default' => [
					'top' => 0,
					'right' => 10,
					'bottom' => 0,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors'  	=> [
					'{{WRAPPER}} .oww-btn-widget > a > svg' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
	}

	/**
	 * Render tabs widget
	 *
	 * Genarate HTML element to render.
	 *
	 * @since 2.3
	 * @access protected
	 */
	protected function render() {
		$product_id = $this->get_settings_for_display( 'oww_select_product' );
		$buttons_text = $this->get_settings_for_display( 'oww_text_btn' );
		$target = $this->get_settings_for_display( 'oww_target' );
		$custom_text = $this->get_settings_for_display( 'oww_custom_text' );
		$phone = $this->get_settings_for_display( 'oww_phone' );
		$currency = get_woocommerce_currency_symbol();

		$wapp_icon = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px" viewBox="0 0 90 90" xml:space="preserve"><path id="WhatsApp" d="M90,43.841c0,24.213-19.779,43.841-44.182,43.841c-7.747,0-15.025-1.98-21.357-5.455L0,90l7.975-23.522   c-4.023-6.606-6.34-14.354-6.34-22.637C1.635,19.628,21.416,0,45.818,0C70.223,0,90,19.628,90,43.841z M45.818,6.982   c-20.484,0-37.146,16.535-37.146,36.859c0,8.065,2.629,15.534,7.076,21.61L11.107,79.14l14.275-4.537   c5.865,3.851,12.891,6.097,20.437,6.097c20.481,0,37.146-16.533,37.146-36.857S66.301,6.982,45.818,6.982z M68.129,53.938   c-0.273-0.447-0.994-0.717-2.076-1.254c-1.084-0.537-6.41-3.138-7.4-3.495c-0.993-0.358-1.717-0.538-2.438,0.537   c-0.721,1.076-2.797,3.495-3.43,4.212c-0.632,0.719-1.263,0.809-2.347,0.271c-1.082-0.537-4.571-1.673-8.708-5.333   c-3.219-2.848-5.393-6.364-6.025-7.441c-0.631-1.075-0.066-1.656,0.475-2.191c0.488-0.482,1.084-1.255,1.625-1.882   c0.543-0.628,0.723-1.075,1.082-1.793c0.363-0.717,0.182-1.344-0.09-1.883c-0.27-0.537-2.438-5.825-3.34-7.977   c-0.902-2.15-1.803-1.792-2.436-1.792c-0.631,0-1.354-0.09-2.076-0.09c-0.722,0-1.896,0.269-2.889,1.344   c-0.992,1.076-3.789,3.676-3.789,8.963c0,5.288,3.879,10.397,4.422,11.113c0.541,0.716,7.49,11.92,18.5,16.223   C58.2,65.771,58.2,64.336,60.186,64.156c1.984-0.179,6.406-2.599,7.312-5.107C68.398,56.537,68.398,54.386,68.129,53.938z"/></svg>';

		if( $product_id != 'select-product' ) {
			if( $product_id != 'current' ) {
				$product = new WC_Product( $product_id );
			}
			else {

				global $product;
				$product = wc_get_product();

				if ( empty( $product ) ) {
					return;
				}
			}

			$tokens = [
				'{product-name}' => $product->get_name(),
				'{product-price}' => $currency . number_format( $product->get_price(), get_option( 'woocommerce_price_num_decimals' ), get_option( 'woocommerce_price_thousand_sep' ), get_option( 'woocommerce_price_decimal_sep') ),
				'{product-link}' => get_permalink( $product->get_id() )
			];

			foreach( $tokens as $key => $value ) {

				$custom_text = str_replace( $key, $value, $custom_text );
			}

			$custom_text = urlencode( html_entity_decode ( $custom_text, ENT_QUOTES | ENT_HTML5, 'UTF-8' ) );
			$link_btn = 'https://wa.me/'.$phone.'?text='.$custom_text.'';

			?>
			<style>
				.oww-btn-widget {
					display: flex;
				}

				.oww-btn-widget > a {
					display: flex;
					align-items: center;
				}
			</style>
			<div class="oww-btn-widget">
				<a href="<?php echo $link_btn; ?>" target="<?php echo $target; ?>"> <?php echo $wapp_icon . $buttons_text ?> </a>
			</div>
			<?php
		}
		else {
			?>
				<div class="oww-widget-product-notive"><?php esc_html_e( 'Select the product for show.','woo-order-on-whatsapp' ); ?></div>
			<?php
		}
	}
}
