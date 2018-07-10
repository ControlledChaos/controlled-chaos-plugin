<?php
/**
 * The core plugin class.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Tools
 *
 * @since      1.0.0
 * @author     SO WP
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://github.com/ControlledChaos/so-turn-on-debug
 */

// namespace CC_Plugin\Includes\Tools;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 *
 * We used the premium [WP Rocket](https://rocket.me) plugin as an example
 * on how to write to the wp-config file, like they do when setting WP_CACHE to true
 *
 */

if ( ! defined( 'DOING_AJAX' ) && ! defined( 'DOING_AUTOSAVE' ) ) {
    add_action( 'admin_init', 'ccp_check_wp_debug_define' );
}

function ccp_check_wp_debug_define() {
	if ( defined( 'WP_DEBUG' ) && ! WP_DEBUG ) {
		$dev_mode = get_option( 'ccp_site_development' );
		if ( $dev_mode ) {
			ccp_set_wp_debug_define( true );
		} elseif ( false == $dev_mode )  {
			ccp_set_wp_debug_define( false );
		}
	}
}

/**
 * Added or set the value of the WP_DEBUG constant
 *
 * @since  1.0.0
 * @access public
 * @param  bool $turn_it_on The value of WP_DEBUG constant
 * @return void
 */
function ccp_set_wp_debug_define( $turn_it_on ) {
	// If WP_DEBUG is already defined, no need to do anything
	if( ( $turn_it_on && defined( 'WP_DEBUG' ) && WP_DEBUG ) ) {
		return;
	}

	// Get path of the config file
	$config_file_path = ccp_find_wpconfig_path();
    if ( ! $config_file_path ) {
		return;
    }

	// Get content of the config file
	$config_file = file( $config_file_path );

	// Get the value of WP_DEBUG constant
	$turn_it_on = $turn_it_on ? 'true' : 'false';

	/**
	 * Filter allow to change the value of WP_DEBUG constant
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $turn_it_on The value of WP_DEBUG constant
	*/
	apply_filters( 'ccp_set_wp_debug_define', $turn_it_on );

	// Lets find out if the constant WP_DEBUG is defined or not
	$is_wp_debug_exist = false;

	// Get WP_DEBUG constant define
	$constant = "define( 'WP_DEBUG', $turn_it_on ); // Added by SO Turn On Debug plugin". "\r\n";

	foreach ( $config_file as &$line ) {
		if ( ! preg_match( '/^define\(\s*\'([A-Z_]+)\',(.*)\)/', $line, $match ) ) {
			continue;
		}

		if ( $match[1] == 'WP_DEBUG' ) {
			$is_wp_debug_exist = true;
			$line = $constant;
		}
	}
	unset( $line );

	// If the constant does not exist, create it
	if ( ! $is_wp_debug_exist ) {
		array_shift( $config_file );
		array_unshift( $config_file, "<?php\r\n", $constant );
	}

	// Insert the constant in wp-config.php file
	$handle = @fopen( $config_file_path, 'w' );
	foreach( $config_file as $line ) {
		@fwrite( $handle, $line );
	}

	@fclose( $handle );

	// Update the writing permissions of wp-config.php file
	$chmod = defined( 'FS_CHMOD_FILE' ) ? FS_CHMOD_FILE : 0644;
	@chmod( $config_file_path, $chmod );
}

/**
 * Try to find the correct wp-config.php file, support one level up in filetree
 *
 * @since  1.0.0
 * @access public
 * @return string|bool The path of wp-config.php file or false
 */
function ccp_find_wpconfig_path() {
	$config_file     = ABSPATH . 'wp-config.php';
	$config_file_alt = dirname( ABSPATH ) . '/wp-config.php';

	if ( file_exists( $config_file ) && is_writable( $config_file ) ) {
		return $config_file;
	} elseif ( @file_exists( $config_file_alt ) && is_writable( $config_file_alt ) && ! file_exists( dirname( ABSPATH ) . '/wp-settings.php' ) ) {
		return $config_file_alt;
	}

	// No writable file found
	return false;
}


/**
 * Set WP_DEBUG to false upon deactivation of the plugin
 *
 * @since  1.0.0
 * @access public
 * @return string|bool The path of wp-config.php file or false
 */
register_deactivation_hook( __FILE__, 'ccp_deactivation' );

function ccp_deactivation() {
    // set WP_DEBUG back to false
    set_ccp_wp_debug_off( false );
}

function set_ccp_wp_debug_off( $turn_it_off ) {
	// Get path of the config file
	$config_file_path = ccp_find_wpconfig_path();
    if ( ! $config_file_path ) {
		return;
    }
	// Get content of the config file
	$config_file = file( $config_file_path );

	// Get the value of WP_DEBUG constant
	$turn_it_off = $turn_it_off ? 'true' : 'false';

	/**
	 * Filter allow to change the value of WP_DEBUG constant
	 *
	 * @since 1.0.0
	 *
	 * @param string $turn_it_on The value of WP_DEBUG constant
	*/
	apply_filters( 'ccp_set_wp_debug_define', $turn_it_off );

	// Lets find out if the constant WP_DEBUG is defined or not
	$is_wp_debug_exist = true;

	// Get WP_DEBUG constant define
	$constant = "define( 'WP_DEBUG', $turn_it_off ); // Added by SO Turn On Debug plugin". "\r\n";

	foreach ( $config_file as &$line ) {
		if ( ! preg_match( '/^define\(\s*\'([A-Z_]+)\',(.*)\)/', $line, $match ) ) {
			continue;
		}

		if ( $match[1] == 'WP_DEBUG' ) {
			$is_wp_debug_exist = true;
			$line = $constant;
		}
	}
	unset( $line );

	// If the constant does not exist, create it
	if ( ! $is_wp_debug_exist ) {
		array_shift( $config_file );
		array_unshift( $config_file, "<?php\r\n", $constant );
	}

	// Insert the constant in wp-config.php file
	$handle = @fopen( $config_file_path, 'w' );
	foreach( $config_file as $line ) {
		@fwrite( $handle, $line );
	}

	@fclose( $handle );

	// Update the writing permissions of wp-config.php file
	$chmod = defined( 'FS_CHMOD_FILE' ) ? FS_CHMOD_FILE : 0644;
	@chmod( $config_file_path, $chmod );
}
