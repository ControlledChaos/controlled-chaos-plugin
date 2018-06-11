<?php

/**
 * Controlled Chaos starter plugin
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

// Keeping the version at 1.0.0 as this is a starter plugin.
define( 'CCP_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_controlled_chaos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-activate.php';
	Controlled_Chaos_Activate::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_controlled_chaos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-deactivate.php';
	Controlled_Chaos_Deactivate::deactivate();
}

/**
 * Activaction & deactivation hooks.
 */
register_activation_hook( __FILE__, '\activate_controlled_chaos' );
register_deactivation_hook( __FILE__, '\deactivate_controlled_chaos' );

/**
 * The core plugin class.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-includes.php';

/**
 * Add settings links to the admin page.
 */
function controlled_chaos_settings_link( $links ) {

	$site_settings = [
		sprintf( '<a href="%1s" class="controlled-chaos-settings-link">%2s</a>', admin_url( 'options-general.php?page=controlled-chaos-settings' ), esc_attr( 'Site Settings', 'controlled-chaos' ) ),
	];

	$script_options = [
		sprintf( '<a href="%1s" class="controlled-chaos-settings-link">%2s</a>', admin_url( 'options-general.php?page=controlled-chaos-scripts' ), esc_attr( 'Script Options', 'controlled-chaos' ) ),
	];

	return array_merge( $site_settings, $script_options, $links );

}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'controlled_chaos_settings_link' );