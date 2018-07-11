<?php
/**
 * Controlled Chaos starter plugin
 *
 * Change this header information to suit your needs.
 *
 * @package     Controlled_Chaos_Plugin
 * @version     1.0.0
 * @author      Greg Sweet <greg@ccdzine.com>
 * @copyright   Copyright © 2018, Greg Sweet
 * @link        https://github.com/ControlledChaos/controlled-chaos-plugin
 * @license     GPL-3.0+ http://www.gnu.org/licenses/gpl-3.0.txt
 *
 * Plugin Name: Controlled Chaos Plugin
 * Plugin URI:  https://github.com/ControlledChaos/controlled-chaos-plugin
 * Description: A WordPress starter/boilerplate for site-specific plugins.
 * Version:     1.0.0
 * Author:      Controlled Chaos Design
 * Author URI:  http://ccdzine.com/
 * License:     GPL-3.0+
 * License URI: https://www.gnu.org/licenses/gpl.txt
 * Text Domain: controlled-chaos-plugin
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Keeping the version at 1.0.0 as this is a starter plugin but
 * you may want to start counting as you develop for your use case.
 *
 * @since  1.0.0
 * @return string Returns the latest plugin version.
 */
if ( ! defined( 'CCP_VERSION' ) ) {
	define( 'CCP_VERSION', '1.0.0' );
}

/**
 * Universal slug partial for admin pages.
 *
 * This URL slug is used for various plugin admin & settings pages.
 *
 * The prefix will change in your search & replace in renaming the plugin.
 * Change the second part of the define(), here as 'controlled-chaos-plugin',
 * to your preferred page slug.
 *
 * @since  1.0.0
 * @return string Returns the URL slug of the admin pages.
 */
if ( ! defined( 'CCP_ADMIN_SLUG' ) ) {
	define( 'CCP_ADMIN_SLUG', 'controlled-chaos-plugin' );
}

/**
 * Define default meta image path.
 *
 * Change the path and file name to suit your needs.
 *
 * @since  1.0.0
 * @return string Returns the URL of the image.
 */
if ( ! defined( 'CCP_DEFAULT_META_IMAGE' ) ) {
	define(
		'CCP_DEFAULT_META_IMAGE',
		plugins_url( 'frontend/assets/images/default-meta-image.jpg', __FILE__ )
	);
}

/**
 * The core plugin class.
 *
 * Simply gets the initialization class file plus the
 * activation and deactivation classes.
 *
 * @since  1.0.0
 * @access public
 */
class Controlled_Chaos_Plugin {

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

			// Require the core plugin class files.
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
	 * Require the core plugin class files.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void Gets the file which contains the core plugin class.
	 */
	private function dependencies() {

		// The hub of all other dependency files.
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-init.php';

		// Include the activation class.
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-activate.php';

		// Include the deactivation class.
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivate.php';

	}

}
// End core plugin class.

/**
 * Put an instance of the plugin class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns the instance of the `Controlled_Chaos_Plugin` class.
 */
function ccp_plugin() {

	return Controlled_Chaos_Plugin::instance();

}

// Begin plugin functionality.
ccp_plugin();

/**
 * Register the activaction & deactivation hooks.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
register_activation_hook( __FILE__, '\activate_controlled_chaos' );
register_deactivation_hook( __FILE__, '\deactivate_controlled_chaos' );

/**
 * The code that runs during plugin activation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function activate_controlled_chaos() {

	// Run the activation class.
	ccp_activate();

}

/**
 * The code that runs during plugin deactivation.
 *
 * @since  1.0.0
 * @access public
 * @return void
 */
function deactivate_controlled_chaos() {

	// Run the deactivation class.
	ccp_deactivate();

}

/**
 * Add a link to the plugin's about page on the plugins page.
 *
 * The about page in its original form is intended to be read by
 * developers for getting familiar with the plugin, so it is
 * included in the admin menu under plugins.
 *
 * If you would like to link the page elsewhere as you make it your own then
 * do so in admin/class-admin-pages.php, in the about_plugin method.
 *
 * @param  array $links Default plugin links on the 'Plugins' admin page.
 * @since  1.0.0
 * @access public
 * @return mixed[] Returns an HTML string for the settings page link.
 *                 Returns an array of the settings link with the default plugin links.
 * @link   https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
 */
function controlled_chaos_about_link( $links ) {

	// Create new settings link array as a variable.
	$about_page = [
		sprintf(
			'<a href="%1s" class="' . CCP_ADMIN_SLUG . '-page-link">%2s</a>',
			admin_url( 'plugins.php?page=' . CCP_ADMIN_SLUG . '-page' ),
			esc_attr( 'Documentation', 'controlled-chaos-plugin' )
		),
	];

	// Merge the new settings array with the default array.
	return array_merge( $about_page, $links );

}
// Filter the default settings links with new array.
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'controlled_chaos_about_link' );

/**
 * Add links to the plugin settings pages on the plugins page.
 *
 * Change the links to those which fill your needs.
 *
 * @param  array  $links Default plugin links on the 'Plugins' admin page.
 * @param  object $file Reference the root plugin file with header.
 * @since  1.0.0
 * @return mixed[] Returns HTML strings for the settings pages link.
 *                 Returns an array of custom links with the default plugin links.
 * @link   https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
 */
function controlled_chaos_settings_links( $links, $file ) {

	if ( $file == plugin_basename( __FILE__ ) ) {

		// Add links to settings pages.
		$links[] = sprintf(
			'<a href="%1s" class="' . CCP_ADMIN_SLUG . '-settings-link">%2s</a>',
			admin_url( 'options-general.php?page=' . CCP_ADMIN_SLUG . '-settings' ),
			esc_attr( 'Site Settings', 'controlled-chaos-plugin' )
		);
		$links[] = sprintf(
			'<a href="%1s" class="' . CCP_ADMIN_SLUG . '-scripts-link">%2s</a>',
			admin_url( 'options-general.php?page=' . CCP_ADMIN_SLUG . '-scripts' ),
			esc_attr( 'Script Options', 'controlled-chaos-plugin' )
		);

		// Add a placeholder for an upgrade link.
		$links[] = sprintf(
			'<a href="%1s" title="%2s" class="' . CCP_ADMIN_SLUG . '-upgrade-link" style="color: #888; cursor: default;">%3s</a>',
			''/* Add upgrade URL here */,
			__( 'Upgrade not available', 'controlled-chaos-plugin' ),
			esc_attr( 'Upgrade', 'controlled-chaos-plugin' )
		);

	}

	// Return the full array of links.
	return $links;

}
add_filter( 'plugin_row_meta', 'controlled_chaos_settings_links', 10, 2 );