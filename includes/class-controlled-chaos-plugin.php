<?php

/**
 * The file that defines the core plugin class.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */

namespace CCPlugin\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define the core functionality of the plugin.
 *
 * @since      1.0.0
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Plugin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Load dependencies.
		$this->dependencies();

		// Remove the capital P filter.
		remove_filter( 'the_title', 'capital_P_dangit', 11 );
		remove_filter( 'the_content', 'capital_P_dangit', 11 );
		remove_filter( 'comment_text', 'capital_P_dangit', 31 );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function dependencies() {

		// Translation functionality.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-i18n.php';

		// Admin actions and filters.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		// Public actions and filters.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-public.php';

		// Post types and taxonomies.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/post-types-taxes/class-post-type-tax.php';

		// Minify HTML source code.
		$minify = get_option( 'ccp_html_minify' );

		if ( $minify ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-minify-process.php';
		}

	}

}

// Run the core plugin class.
$ccp_run = new Controlled_Chaos_Plugin();