<?php
/**
 * Inline frontend styles.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Frontend
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Frontend;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The frontend functionality of the plugin.
 *
 * @since  1.0.0
 * @access public
 */
class Inline_Frontend_Styles {

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
	 * @access public
	 * @return self
	 */
	public function __construct() {

		add_action( 'wp_head', [ $this, 'styles' ] );

	}

	/**
	 * Add styles inline if option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function styles() {

		$fancybox    = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/css/jquery.fancybox.min.css' ) );
		$slick       = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/css/slick.min.css' ) );
		$slick_theme = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/css/slick-theme.min.css' ) );
		$tooltipster = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/css/tooltipster.bundle.min.css' ) );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_styles' ) ) {

			/**
			 * Bail if the current theme supports ccd-fancybox by
			 * including its own copy of the Fancybox stylesheet.
			 */
			if ( current_theme_supports( 'ccd-fancybox' ) ) {
				return;
			} else {
				echo '<!-- Fancybox 3 Scripts --><style>' . $fancybox . '</style>';
			}
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			echo '<!-- Slick Scripts --><style>' . $slick . '</style>';
		}

		// Slick theme.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			echo '<!-- Tabslet Scripts --><style>' . $slick_theme . '</style>';
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			echo '<!-- Tooltipster Scripts --><style>' . $tooltipster . '</style>';
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
function ccp_inline_frontend_styles() {

	return Inline_Frontend_Styles::instance();

}

// Run an instance of the class.
ccp_inline_frontend_styles();