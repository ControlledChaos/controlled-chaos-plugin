<?php

/**
 * Controlled Chaos starter plugin
 * 
 * Change this header information to suit your needs.
 *
 * @link              http://ccdzine.com
 * @since             1.0.0
 * @package           Controlled_Chaos
 *
 * @wordpress-plugin
 * Plugin Name:       Controlled Chaos
 * Plugin URI:        https://github.com/ControlledChaos/Controlled-Chaos-Plugin
 * Description:       A WordPress starter/boilerplate plugin.
 * Version:           1.0.0
 * Author:            Controlled Chaos Design
 * Author URI:        http://ccdzine.com/
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl.txt
 * Text Domain:       controlled-chaos
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Keeping the version at 1.0.0 as this is a starter plugin but
 * you may want to start counting as you develop for your use case.
 */
define( 'CCP_VERSION', '1.0.0' );

/**
 * This URL slug is used in various plugin admin & settings pages.
 * 
 * The prefix will change in your search & replace in renaming the plugin.
 * Change the second part of the define(), here as 'controlled-chaos',
 * to your preferred page slug.
 */
define( 'CCP_ADMIN_SLUG', 'controlled-chaos' );

/**
 * The code that runs during plugin activation.
 * 
 * @since 1.0.0
 */
function activate_controlled_chaos() {

	// Include the activation class.
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activate.php';

	// Run the activation method.
	Controlled_Chaos_Activate::activate();

}

/**
 * The code that runs during plugin deactivation.
 * 
 * @since 1.0.0
 */
function deactivate_controlled_chaos() {

	// Include the deactivation class.
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivate.php';

	// Run the deactivation method.
	Controlled_Chaos_Deactivate::deactivate();

}

/**
 * Register the activaction & deactivation hooks.
 * 
 * @since 1.0.0
 */
register_activation_hook( __FILE__, '\activate_controlled_chaos' );
register_deactivation_hook( __FILE__, '\deactivate_controlled_chaos' );

/**
 * Get the core plugin class to begin plugin funtionality.
 * 
 * @since 1.0.0
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-includes.php';

/**
 * Add a link to the plugin's about page on the plugins page.
 * 
 * The about page in its original form is intended to be read by
 * developers for getting familiar with the plugin, so it is not
 * included in the admin menu.
 * 
 * If you would like to show the page as you make it your own then
 * do so in admin/class-admin-pages.php, in the about_plugin method.
 * 
 * @since 1.0.0
 * @return mixed
 * @link https://codex.wordpress.org/Plugin_API/Filter_Reference/plugin_action_links_(plugin_file_name)
 */
function controlled_chaos_settings_link( $links ) {

	// Create the link element.
	$about_page = [
		sprintf( '<a href="%1s" class="controlled-chaos-about-link">%2s</a>', admin_url( 'options-general.php?page=controlled-chaos-page' ), esc_attr( 'Documentation', 'controlled-chaos' ) ),
	];

	// Merge the about link with the default links.
	return array_merge( $about_page, $links );

}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'controlled_chaos_settings_link' );