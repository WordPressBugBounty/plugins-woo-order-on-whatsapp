<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Widgets
 *
 * Class to register OWW Elementor Widgets.
 *
 * @since 2.3
 *
 * @access public
 */
final class OWW_Register_Elementor_Widgets {
	/**
	 * Init class
	 *
	 * Init the class to include and register widgets.
	 *
	 * @since 2.3
	 *
	 * @access public
	 */
	public function init() {
		add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
	}

	/**
	 * Includes
	 *
	 * Get requires files to widget.
	 *
	 * @since 2.3
	 *
	 * @access public
	 */
	public function includes() {
		require_once OMW_PLUGIN_PATH . 'includes/elementor-widget/oww-btn.php';
	}

	/**
	 * Register Widgets
	 *
	 * Register Widgets on Elementos actions.
	 *
	 * @since 2.3
	 *
	 * @access public
	 */
	public function register_widgets() {
		$this->includes();
		\Elementor\Plugin::instance()->widgets_manager->register( new OWW_Btn_Widget );
	}
}
