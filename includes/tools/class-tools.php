<?php
/**
 * Various tools included.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Tools
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @todo       Apply a filter to return true or false for
 *             hiding the Development Tools admin page.
 */

namespace CC_Plugin\Includes\Tools;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Various tools included.
 *
 * @since  1.0.0
 * @access public
 */
class Tools {

	/**
	 * Get an instance of the plugin class.
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

			// Get class dependencies.
			$instance->dependencies();

		}

		// Return the instance.
		return $instance;

	}

	/**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void Constructor method is empty.
	 */
	public function __construct() {}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Minify HTML source code.
		$debug = get_option( 'ccp_debug_mode' );

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'tools/class-debug.php';

		// Include the RTL (right to left) test if option selected.
		$rtl = get_option( 'ccp_rtl_test' );

		if ( $rtl ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'tools/class-rtl-test.php';
		}

		// Minify HTML source code.
		$minify = get_option( 'ccp_html_minify' );

		if ( $minify ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'tools/class-minify-process.php';
		}

		// Live theme test.
		$theme_test = get_option( 'ccp_theme_test' );

		if ( $theme_test ) {
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'tools/class-theme-test.php';
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
function ccp_tools() {

	return Tools::instance();

}

// Run an instance of the class.
ccp_tools();