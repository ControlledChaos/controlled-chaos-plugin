<?php
/**
 * Inline frontend scripts.
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
class Inline_Frontend_Scripts {

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

		add_action( 'wp_footer', [ $this, 'scripts' ], 11 );

	}

	/**
	 * Add scripts inline if option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function scripts() {

		$fancybox    = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/js/jquery.fancybox.min.js' ) );
		$slick       = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/js/slick.min.js' ) );
		$tabslet     = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/js/jquery.tabslet.min.js' ) );
		$tooltipster = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/js/tooltipster.bundle.min.js' ) );
		$stickykit   = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/js/sticky-kit.min.js' ) );
		$fitvids     = file_get_contents( esc_html( CCP_PATH . 'frontend/assets/js/jquery.fitvids.min.js' ) );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {
			echo '<!-- Fancybox 3 Scripts --><script>' . $fancybox . '</script>';
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			echo '<!-- Slick Scripts --><script>' . $slick . '</script>';
		}

		// Tabslet.
		if ( get_option( 'ccp_enqueue_tabslet' ) ) {
			echo '<!-- Tabslet Scripts --><script>' . $tabslet . '</script>';
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			echo '<!-- Tooltipster Scripts --><script>' . $tooltipster . '</script>';
		}

		// Sticky-kit.
		if ( get_option( 'ccp_enqueue_stickykit' ) ) {
			echo '<!-- Sticky-kit Scripts --><script>' . $stickykit . '</script>';
		}

		// FitVids.
		if ( ! is_front_page() ) {
			echo '<!-- FitVids Scripts --><script>' . $fitvids . '</script>';
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
function ccp_inline_frontend_scripts() {

	return Inline_Frontend_Scripts::instance();

}

// Run an instance of the class.
ccp_inline_frontend_scripts();