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

		// Admin dependencies.
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
	 * Admin dependencies.
	 *
	 * @since    1.0.0
	 */
	public function dependencies() {

		require plugin_dir_path( __FILE__ ) . 'class-dashboard.php';
		require plugin_dir_path( __FILE__ ) . 'class-admin-menu.php';
		require plugin_dir_path( __FILE__ ) . 'class-adminbar-menus.php';
		require plugin_dir_path( __FILE__ ) . 'class-admin-pages.php';
		require plugin_dir_path( __FILE__ ) . 'class-settings.php';
		if ( class_exists( 'ACF_Pro' ) && ! get_option( 'ccp_site_settings_acf_fields' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'class-settings-fields.php';
		}
		if ( class_exists( 'ACF_Pro' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'class-fields-import.php';
		}
		require plugin_dir_path( __FILE__ ) . 'class-admin-images.php';
		require plugin_dir_path( __FILE__ ) . 'class-media-options.php';
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