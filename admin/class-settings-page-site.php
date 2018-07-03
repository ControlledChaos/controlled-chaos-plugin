<?php
/**
 * Settings page for site customization.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Settings page for site customization.
 *
 * @since  1.0.0
 * @access public
 */
class Settings_Page_Site {

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

		}

		// Return the instance.
		return $instance;

	}

    /**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

		// Add the page to the admin menu.
		add_action( 'admin_menu', [ $this, 'settings_page' ] );

	}

	/**
	 * Add a page for site settings.
	 *
	 * If the Advanced Custom Fields Pro plugin is active then
	 * an ACF options page and ACF fields will be used. If not
	 * then a default WordPress admin page and the WP Settings
	 * API will be used.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 *
	 * @todo  Think about whether this is a good idea. Maybe it's
	 *        better to simply provide a sample ACF page. ACF is
	 *        certainly faster for further development but do we
	 *        want the dependency?
	 */
    public function settings_page() {

		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			$title      = apply_filters( 'site_settings_page_name', get_bloginfo( 'name' ) );
			$position   = get_field( 'ccp_settings_link_position', 'option' );
			$link_label = get_field( 'ccp_site_settings_link_label', 'option' );

			if ( $link_label ) {
				$label = $link_label;
			}  else {
				$label = __( 'Site Settings', 'controlled-chaos-plugin' );
			}

			if ( 'top' == $position ) {

				$settings = apply_filters( 'controlled_chaos_site_settings_page_top', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos-plugin' ),
					'menu_title' => $label,
					'menu_slug'  => CCP_ADMIN_SLUG . '-settings',
					'icon_url'   => 'dashicons-admin-settings',
					'position'   => 3,
					'capability' => 'manage_options',
					'redirect'   => false
				] );
				acf_add_options_page( $settings );
				remove_menu_page( 'options-general.php' );

			} else {

				$settings = apply_filters( 'controlled_chaos_site_settings_page_default', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos-plugin' ),
					'menu_title' => $label,
					'menu_slug'  => CCP_ADMIN_SLUG . '-settings',
					'parent'     => 'index.php',
					'capability' => 'manage_options'
				] );
				acf_add_options_page( $settings );

			}

		} else {

			$link_label = sanitize_text_field( get_option( 'ccp_site_settings_link_label' ) );
			$position   = get_option( 'ccp_site_settings_position' );
			$link_icon  = sanitize_text_field( get_option( 'ccp_site_settings_link_icon' ) );

			if ( $link_label ) {
				$label = $link_label;
			}  else {
				$label = __( 'Site Settings', 'controlled-chaos-plugin' );
			}

			if ( $link_icon ) {
				$icon = $link_icon;
			}  else {
				$icon = __( 'dashicons-admin-settings', 'controlled-chaos-plugin' );
			}

			if ( $position ) {
				add_menu_page(
					$label,
					$label,
					'manage_options',
					CCP_ADMIN_SLUG . '-settings',
					[ $this, 'page_output' ],
					$icon,
					3
				);
			} else {
				add_submenu_page(
					'index.php',
					$label,
					$label,
					'manage_options',
					CCP_ADMIN_SLUG . '-settings',
					[ $this, 'page_output' ]
				);
			}

		}

	}

	/**
	 * Site Settings page output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function page_output() {

		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-site.php';

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_settings_page_site() {

	return Settings_Page_Site::instance();

}

// Run an instance of the class.
ccp_settings_page_site();