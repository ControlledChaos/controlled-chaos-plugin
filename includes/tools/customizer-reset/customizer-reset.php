<?php
/**
 * Customizer reset tool
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Tools\Customizer_Reset
 *
 * @since      1.0.0
 * @author     WPZOOM
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://github.com/wpzoom/customizer-reset
 */

namespace CC_Plugin\Includes\Tools\Customizer_Reset;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

final class Customizer_Reset {

	/**
	 * @var WP_Customize_Manager
	 */
	private $wp_customize;

	/**
	 * Instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the instance.
	 */
	public static function instance() {

		// Varialbe for the instance to be used outside the class.
		static $instance = null;

		if ( is_null( $instance ) ) {

			// Set variable for new instance.
			$instance = new self;

		}

		// Return the instance.
		return $instance;

	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access private
	 * @return self
	 */
	private function __construct() {

		add_action( 'customize_controls_print_scripts', [ $this, 'customize_controls_print_scripts' ] );
		add_action( 'wp_ajax_customizer_reset', [ $this, 'ajax_customizer_reset' ] );
		add_action( 'customize_register', [ $this, 'customize_register' ] );

	}

	/**
	 * Print customizer scripts.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function customize_controls_print_scripts() {

		wp_enqueue_script( 'ccp-customizer-reset', CCP_URL . 'includes/tools/customizer-reset/assets/js/customizer-reset.js', [ 'jquery' ], '20150120' );

		wp_localize_script( 'ccp-customizer-reset', '_CCPCustomizerReset', [
			'reset'   => __( 'Reset', 'controlled-chaos-plugin' ),
			'confirm' => __( 'Warning! This will remove all changes made to this theme via the Customizer. This action is irreversible.', 'controlled-chaos-plugin' ),
			'nonce'   => [
				'reset' => wp_create_nonce( 'customizer-reset' ),
			]
		] );

	}

	/**
	 * Store a reference to `WP_Customize_Manager` instance.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $wp_customize An instance of the Customizer.
	 * @return void
	 */
	public function customize_register( $wp_customize ) {

		$this->wp_customize = $wp_customize;

	}

	/**
	 * AJAX load the Customizer preview.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function ajax_customizer_reset() {

		if ( ! $this->wp_customize->is_preview() ) {
			wp_send_json_error( 'not_preview' );
		}

		if ( ! check_ajax_referer( 'customizer-reset', 'nonce', false ) ) {
			wp_send_json_error( 'invalid_nonce' );
		}

		$this->reset_customizer();

		wp_send_json_success();

	}

	/**
	 * Reset the Customizer.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function reset_customizer() {

		$settings = $this->wp_customize->settings();

		// Remove theme_mod settings registered in customizer.
		foreach ( $settings as $setting ) {
			if ( 'theme_mod' == $setting->type ) {
				remove_theme_mod( $setting->id );
			}
		}

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_customizer_reset() {

	return Customizer_Reset::instance();

}

// Run an instance of the class.
ccp_customizer_reset();