<?php
/**
 * The core plugin class.
 * 
 * @package    Controlled_Chaos_Plugin
 * @subpackage Controlled_Chaos_Plugin\includes
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the core functionality of the plugin.
 *
 * @since  1.0.0
 * @access public
 */
class Includes {

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
	 * @return self
	 */
	public function __construct() {

		// Remove the capital P filter.
		remove_filter( 'the_title', 'capital_P_dangit', 11 );
		remove_filter( 'the_content', 'capital_P_dangit', 11 );
		remove_filter( 'comment_text', 'capital_P_dangit', 31 );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Translation functionality.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-i18n.php';

		// Admin/backend functionality, scripts and styles.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		// Frontend functionality, scripts and styles.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'frontend/class-frontend.php';

		// Various media and media library functionality.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/media/class-media.php';

		/**
		 * Register custom editor blocks.
		 * 
		 * Remove conditional statement when Gutenberg is in core?
		 */
		if ( is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/editor-blocks/class-register-block-types.php';
		}

		// Post types and taxonomies.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/post-types-taxes/class-post-type-tax.php';

		// User avatars.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/users/class-user-avatars.php';

		// Minify HTML source code.
		$minify = get_option( 'ccp_html_minify' );

		if ( $minify ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-minify-process.php';
		}

		// Include the RTL (right to left) test if option selected.
		$rtl = get_option( 'ccp_rtl_test' );

		if ( $rtl ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rtl-test.php';
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
function ccp_includes() {

	return Includes::instance();

}

// Run an instance of the class.
ccp_includes();