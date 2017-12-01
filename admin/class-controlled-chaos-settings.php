<?php
/**
 * Plugin and site settings.
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
 * Plugin and site settings.
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

		// Add plugin settings page.
		add_action( 'admin_menu', [ $this, 'plugin_settings_page' ] );

		// Add setting link to Plugins page.
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), [ $this, 'plugin_settings_link' ] );

		// Register settings.
		add_action( 'admin_init', [ $this, 'settings' ] );

        // Add ACF options page.
    	add_action( 'admin_menu', [ $this, 'site_settings_page' ] );

	}
	
	/**
	 * Add plugin settings page.
	 *
	 * @since    1.0.2
	 */
    public function plugin_settings_page() {

		add_options_page( __( 'Controlled Chaos Plugin Settings', 'controlled-chaos' ), __( 'Controlled Chaos', 'controlled-chaos' ), 'manage_options', 'controlled-chaos', [ $this, 'settings_page_output' ] );

	}

	/**
	 * Add setting link to Plugins page.
	 * 
	 * @since    1.0.2
	 */
	public function plugin_settings_link( $links ) {

		$ccp_links = [
			'<a href="' . admin_url( 'options-general.php?page=controlled-chaos' ) . '">Settings</a>',
		];
		return array_merge( $ccp_links, $links );

	}

	/**
	 * Settings page output.
	 *
	 * @since    1.0.2
	 */
    public function settings_page_output() {
		
		require plugin_dir_path( __FILE__ ) . 'partials/controlled-chaos-settings-page.php';

	}

	/**
	 * Plugin settings.
	 * 
	 * @since    1.0.2
	 */
	public function settings() {
		
		if ( class_exists( 'ACF_Pro' ) ) {

			add_settings_section( 'ccp-site-settings', __( 'Site Settings Page', 'controlled-chaos' ), [ $this, 'site_settings_page_section' ], 'controlled-chaos' );
			
			add_settings_field( 'ccp_site_settings_acf_fields', __( 'ACF Field Groups', 'controlled-chaos' ), [ $this, 'site_settings_page_callback' ], 'controlled-chaos', 'ccp-site-settings', [ __( 'Deactive field groups after importing.', 'controlled-chaos' ) ] );

			register_setting(
				'controlled-chaos',
				'ccp_site_settings_acf_fields'
			);

		}

	}

	public function site_settings_page_section() {

		if ( class_exists( 'ACF_Pro' ) ) {

			echo sprintf( '<p>%1s</p>', esc_html( 'The "Site Settings" page registered by the Controlled Chaos plugin and Advanced Custom Fields contains field groups that can be imported for editing. These built-in field goups must be deactivated for the imported field groups to take effect.', 'controlled-chaos' ) );

		}

	}

	public function site_settings_page_callback( $args ) {
		
		if ( class_exists( 'ACF_Pro' ) ) {

			$html = '<p><input type="checkbox" id="ccp_site_settings_acf_fields" name="ccp_site_settings_acf_fields" value="1" ' . checked( 1, get_option( 'ccp_site_settings_acf_fields' ), false ) . '/>';
			
			// Here, we will take the first argument of the array and add it to a label next to the checkbox
			$html .= '<label for="ccp_site_settings_acf_fields"> '  . $args[0] . '</label></p>';

			$html .= sprintf( '<p class="description"><strong>%1s</strong> %2s</p>', esc_html__( 'Note:', 'controlled-chaos' ), esc_html__( 'Do not change the "Field Name" of the imported fields.', 'controlled-chaos' ) );
			
			echo $html;
			
		}

	}

    /**
	 * Add ACF options page for site settings.
	 *
	 * @since    1.0.1
	 */
    public function site_settings_page() {

		if ( class_exists( 'ACF_Pro' ) || class_exists( 'acf_admin_options_page' ) ) {

			$title    = get_bloginfo( 'name' );
			$position = get_field( 'ccp_settings_link_position', 'option' );

			if ( 'top' == $position ) {
					
				$settings = apply_filters( 'controlled_chaos_site_settings_page_top', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos' ),
					'menu_title' => __( 'Site Settings', 'controlled-chaos' ),
					'menu_slug'  => 'site-settings',
					'icon_url'   => 'dashicons-admin-settings',
					'position'   => 59,
					'capability' => 'manage_options',
					'redirect'   => false
				] );
				acf_add_options_page( $settings );
				remove_menu_page( 'options-general.php' );

			} else {

				$settings = apply_filters( 'controlled_chaos_site_settings_page_default', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos' ),
					'menu_title' => __( 'Site Settings', 'controlled-chaos' ),
					'menu_slug'  => 'site-settings',
					'parent'     => 'options-general.php',
					'capability' => 'manage_options'
				] );
				acf_add_options_page( $settings );

			}

		}

	}

}

$controlled_chaos_settings = new Controlled_Chaos_Settings;