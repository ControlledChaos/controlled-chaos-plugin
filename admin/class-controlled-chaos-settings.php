<?php
/**
 * Site settings.
 *
 *
 * @package WordPress
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Site settings.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Site_Settings {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled-chaos
	 * @param      string    $version
	 */
    public function __construct() {

        // Add ACF options page.
    	add_action( 'init', [ $this, 'site_settings_page' ] );

    }

    /**
	 * Add ACF options page for site settings.
	 *
	 * @since    1.0.1
	 */
    public function site_settings_page() {

		if ( function_exists( 'acf_add_options_page' ) ) {

			$title = get_bloginfo( 'name' );

			acf_add_options_page( apply_filters( 'controlled_chaos_site_settings_page', [
				'page_title' 	=> $title . __( ' Settings', 'controlled-chaos' ),
				'menu_title'	=> __( 'Site Settings', 'controlled-chaos' ),
				'menu_slug' 	=> 'site-settings',
				'icon_url'      => 'dashicons-admin-settings',
				'position'      => 59,
				'capability'	=> 'manage_options',
				'redirect'		=> false
			] ) );

		}

	}

}

$controlled_chaos_site_settings = new Controlled_Chaos_Site_Settings;