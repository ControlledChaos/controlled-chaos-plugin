<?php

/**
 * Controlled Chaos base plugin
 *
 * @link              http://ccdzine.com
 * @since             1.0.0
 * @package           Controlled_Chaos
 *
 * @wordpress-plugin
 * Plugin Name:       Controlled Chaos
 * Plugin URI:        https://github.com/ControlledChaos/Controlled-Chaos-Plugin
 * Description:       Controlling some WordPress chaos.
 * Version:           1.0.0
 * Author:            Controlled Chaos Design
 * Author URI:        http://ccdzine.com/
 * License:           GPL-3.0+
 * License URI:       https://www.gnu.org/licenses/gpl.txt
 * Text Domain:       controlled-chaos
 * Domain Path:       /languages
 */

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'CONTROLLEDCHAOS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 */
function activate_controlled_chaos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-controlled-chaos-activator.php';
	Controlled_Chaos_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 */
function deactivate_controlled_chaos() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-controlled-chaos-deactivator.php';
	Controlled_Chaos_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_controlled_chaos' );
register_deactivation_hook( __FILE__, 'deactivate_controlled_chaos' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-controlled-chaos.php';

/**
 * Begin execution of the plugin.
 *
 * @since    1.0.0
 */
function run_controlled_chaos() {

	$plugin = new Controlled_Chaos();
	$plugin->run();

}
run_controlled_chaos();