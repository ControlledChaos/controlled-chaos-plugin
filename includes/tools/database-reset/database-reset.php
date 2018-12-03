<?php
/**
 * Database reset tool.
 *
 * Reset the WordPress database back to its original state.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Tools\Database_Reset
 *
 * @since      1.0.0
 * @author     Chris Berthe <chris.berthe@shopify.com>
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://github.com/chrisberthe/wordpress-database-reset
 *
 * @todo       Make original plugin files consistent with this plugin.
 * @todo       Correct paths & URIs.
 * @todo       Test in a sacrificial install.
 */

// namespace CC_Plugin\Includes\Tools\Database_Reset;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

define( 'DB_RESET_PATH', dirname( __FILE__ ) );
define( 'AUTOLOADER', DB_RESET_PATH . '/lib/class-plugin-autoloader.php' );

require_once( DB_RESET_PATH . '/lib/helpers.php' );

register_activation_hook( __FILE__, 'db_reset_activate' );

if ( file_exists( AUTOLOADER ) ) {
	require_once( AUTOLOADER );
	new Plugin_Autoloader( DB_RESET_PATH );

	add_action( 'wp_loaded', [ new DB_Reset_Manager( '1.0.0' ), 'run' ] );
}

if ( is_command_line() ) {
	require_once( __DIR__ . '/class-db-reset-command.php' );
}