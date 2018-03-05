<?php

/**
 * Controlled Chaos admin functions.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Admin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Admin file dependencies.
		$this->dependencies();

		// Remove theme & plugin editor links.
        add_action( 'admin_init', [ $this, 'remove_editor_links' ] );

		// Redirect theme & plugin editor pages.
		add_action( 'admin_init', [ $this, 'redirect_editor_pages' ] );

		// Remove the WordPress logo from the admin bar.
		add_action( 'admin_bar_menu', [ $this, 'remove_wp_logo' ], 999 );

		// Remove search from admin bar.
		add_action( 'wp_before_admin_bar_render', [ $this, 'adminbar_search' ] );

		// Hide the WordPress update notification to all but admins.
		add_action( 'admin_head', [ $this, 'admin_only_updates' ], 1 );

		// Credits in admin footer.
		add_filter( 'admin_footer_text', [ $this, 'admin_footer' ] );

		// Register the stylesheets for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );

		// Register the JavaScript for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

	}

	/**
	 * Admin file dependencies.
	 *
	 * @since    1.0.0
	 */
	public function dependencies() {

		// Functions for dasboard widgets, excluding the welcome panel.
		require plugin_dir_path( __FILE__ ) . 'class-dashboard.php';

		// Functions for admin menu item positions and visibility.
		require plugin_dir_path( __FILE__ ) . 'class-admin-menu.php';

		// Add menus to the admin toolbar.
		require plugin_dir_path( __FILE__ ) . 'class-adminbar-menus.php';

		// Functions for various admin pages and edit screens.
		require plugin_dir_path( __FILE__ ) . 'class-admin-pages.php';

		// Register setting sections and fields for plugin functionality.
		require plugin_dir_path( __FILE__ ) . 'class-settings.php';

		// Include custom fields for Advanced Custom Fields Pro, if active.
		if ( class_exists( 'ACF_Pro' ) && ! get_option( 'ccp_acf_activate_settings_page' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'class-settings-acf-fields.php';
		}

		// Import custom fields for editing, if ACF Pro is active.
		if ( class_exists( 'ACF_Pro' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'class-fields-import.php';
		}

		// Add SVG upload support, various other image related functions for admin.
		require plugin_dir_path( __FILE__ ) . 'class-admin-images.php';

		// Fields for the Media Settings page.
		require plugin_dir_path( __FILE__ ) . 'class-media-options.php';

		// Replace WP gallery shortcode if Fancybox option is used.
		if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {
			require plugin_dir_path( __FILE__ ) . 'class-gallery-shortcode.php';
		}

	}

	/**
     * Remove theme & plugin editor links.
     *
     * @since    1.0.0
     */
    public function remove_editor_links() {

		$remove_theme_editor  = remove_submenu_page( 'themes.php', 'theme-editor.php' );
		$remove_plugin_editor = remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

		return array( $remove_theme_editor, $remove_plugin_editor );
	}

	/**
	 * Redirect theme & plugin editor pages.
	 *
	 * @since    1.0.0
	 */
	public function redirect_editor_pages() {

		global $pagenow;

		if ( $pagenow == ( 'plugin-editor.php' ) || $pagenow == 'theme-editor.php' ) {

			wp_redirect( admin_url( '/', 'http' ), 301 );

			exit;
		}
	}

	/**
	 * Remove the WordPress logo from the admin bar.
	 *
	 * @since    1.0.0
	 */
	public function remove_wp_logo( $wp_admin_bar ) {

		$wp_admin_bar->remove_node( 'wp-logo' );
	}

	/**
	 * Remove search from admin bar.
	 *
	 * @since    1.0.0
	 */
	public function adminbar_search() {

		global $wp_admin_bar;

		$wp_admin_bar->remove_menu( 'search' );

	}

	/**
	 * Hide the WordPress update notification to all but admins.
	 *
	 * @since    1.0.0
	 */
	public function admin_only_updates() {

		if ( ! current_user_can( 'update_core' ) ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
		}

	}

	/**
	 * Credits in admin footer.
	 *
	 * @since    1.0.0
	 */
	public function admin_footer() {

		$site   = get_bloginfo( 'name' );

		if ( class_exists( 'ACF_Pro' ) ) {

			$credit = get_field( 'ccp_admin_footer_credit', 'option' );
			$link   = get_field( 'ccp_admin_footer_link', 'option' );

			if ( $credit && $link ) {
				$footer = sprintf( '%1s %2s <a href="%3s" target="_blank">%4s</a>.', $site, esc_html__( 'website designed & developed by', 'controlled-chaos' ), $link, $credit );
			} elseif ( $credit ) {
				$footer = sprintf( '%1s %2s %3s.', $site, esc_html__( 'website designed & developed by', 'controlled-chaos' ), $credit );
			} else {
				$footer = sprintf( '%1s %2s.', $site, esc_html__( 'website powered by WordPress' ) );
			}
			
		} else {
			$footer = sprintf( '%1s %2s.', $site, esc_html__( 'website powered by WordPress' ) );
		}

		echo $footer;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'controlled-chaos-plugin-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', [], CCP_VERSION, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'controlled-chaos-plugin-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', [ 'jquery' ], CCP_VERSION, true );
		wp_enqueue_script( 'controlled-chaos-excerpts', plugin_dir_url( __FILE__ ) . 'assets/js/excerpts.js', [ 'jquery' ], CCP_VERSION, true );

	}

}

$ccp_admin = new Controlled_Chaos_Admin();