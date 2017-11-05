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
class Controlled_Chaos_Settings {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled-chaos
	 * @param      string    $version
	 */
    public function __construct() {

        // Add ACF options page.
    	$this->acf_options_page();

    }

    /**
     * Add ACF options page.
     *
     * @since    1.0.0
     */
    public function acf_options_page() {

		if ( function_exists( 'acf_add_options_page' ) ) {

            $page_title = apply_filters( 'controlled_chaos_settings_page_title', get_bloginfo( 'name' ) . __( ' Settings', 'controlled-chaos' ) );
            $menu_title = apply_filters( 'controlled_chaos_settings_menu_title', __( 'Site Settings', 'controlled-chaos' ) );

			acf_add_options_page( [
				'page_title' => $page_title,
				'menu_title' => $menu_title,
				'menu_slug'  => 'site-settings',
				'icon_url'   => 'dashicons-admin-settings',
				'position'   => 59,
				'capability' => 'manage_options',
				'redirect'	 => false
			]);

		}

	}

}

$controlled_chaos_settings = new Controlled_Chaos_Settings;