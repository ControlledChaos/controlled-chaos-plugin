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

namespace Controlled_Chaos;

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
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $controlled_chaos
	 */
	private $controlled_chaos;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled_chaos
	 * @param      string    $version
	 */
	public function __construct( $controlled_chaos, $version ) {

		$this->controlled_chaos = $controlled_chaos;
		$this->version = $version;

		// Include admin function files.
		$this->require_files();

		// Remove theme & plugin editor links.
        add_action( 'admin_init', [ $this, 'remove_editor_links' ] );

		// Redirect theme & plugin editor pages.
		add_action( 'admin_init', [ $this, 'redirect_editor_pages' ] );

		// Disable emoji script.
		add_action( 'init', [ $this, 'disable_emojis' ] );

		// Remove the WordPress logo from the admin bar.
		add_action( 'admin_bar_menu', [ $this, 'remove_wp_logo' ], 999 );

		// Remove search from admin bar.
		add_action( 'wp_before_admin_bar_render', [ $this, 'adminbar_search' ] );

		// Hide the WordPress update notification to all but admins.
		add_action( 'admin_head', [ $this, 'admin_only_updates' ], 1 );

		// Credits in admin footer.
		add_filter( 'admin_footer_text', [ $this, 'admin_footer' ] );

		// Disable the user admin color scheme picker.
		remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );

	}

	/**
	 * Include admin function files.
	 *
	 * @since    1.0.0
	 */
	public function require_files() {

		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-dashboard.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-admin-menu.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-admin-pages.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-settings.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-settings-field-groups.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-post-type-tax.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-images.php';
		require plugin_dir_path( __FILE__ ) . 'class-controlled-chaos-gallery-shortcode.php';

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
	 * Disable emoji script.
	 *
	 * @since    1.0.0
	 */
	public function disable_emojis() {

		remove_action( 'admin_print_styles', 'print_emoji_styles' );
		remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		remove_action( 'wp_print_styles', 'print_emoji_styles' );
		remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

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

		echo sprintf( '%1s website designed & developed by <a href="http://ccdzine.com" target="_blank">%2s</a>.', get_bloginfo( 'name' ), __( 'Controlled Chaos Design', 'controlled-chaos' ) );

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->controlled_chaos, plugin_dir_url( __FILE__ ) . 'css/controlled-chaos-admin.css', [], $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->controlled_chaos, plugin_dir_url( __FILE__ ) . 'js/controlled-chaos-admin.js', [ 'jquery' ], $this->version, false );
		wp_enqueue_script( 'controlled-chaos-excerpts', plugin_dir_url( __FILE__ ) . 'js/excerpts.js', [ 'jquery' ], $this->version, false );

	}

}
