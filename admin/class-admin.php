<?php
/**
 * Admin functiontionality and settings.
 *
 * @package    Controlled_Chaos
 * @subpackage Controlled_Chaos_Plugin\Admin
 * 
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Bail if not in the admin.
if ( ! is_admin() ) {
	//return;
}

/**
 * Admin functiontionality and settings.
 * 
 * @since  1.0.0
 * @access public
 */
class Admin {

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

			// Require the core plugin class files.
			$instance->dependencies();
			
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

		// Remove theme & plugin editor links.
		add_action( 'admin_init', [ $this, 'remove_editor_links' ] );

		// Redirect theme & plugin editor pages.
		add_action( 'admin_init', [ $this, 'redirect_editor_pages' ] );

		// Remove the WordPress logo from the admin bar.
		add_action( 'admin_bar_menu', [ $this, 'remove_wp_logo' ], 999 );

		// Remove search from frontend admin toolbar.
		add_action( 'wp_before_admin_bar_render', [ $this, 'adminbar_search' ] );

		// Hide the WordPress update notification to all but admins.
		add_action( 'admin_head', [ $this, 'admin_only_updates' ], 1 );

		// Credits in admin footer.
		add_filter( 'admin_footer_text', [ $this, 'admin_footer' ], 1 );

		// Enqueue the stylesheets for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ] );

		// Enqueue the JavaScript for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

	}

	/**
	 * Class dependency files.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Functions for dasboard widgets, excluding the welcome panel.
		require plugin_dir_path( __FILE__ ) . 'class-dashboard.php';

		// Functions for admin menu item positions and visibility.
		require plugin_dir_path( __FILE__ ) . 'class-admin-menu.php';

		// Add development tools page.
		require plugin_dir_path( __FILE__ ) . 'class-development-tools.php';

		// Add menus to the admin toolbar.
		require plugin_dir_path( __FILE__ ) . 'class-toolbar-menus.php';

		// Functions for various admin pages and edit screens.
		require plugin_dir_path( __FILE__ ) . 'class-admin-pages.php';

		// Register setting sections and fields for plugin functionality.
		require plugin_dir_path( __FILE__ ) . 'class-settings.php';

		// Include custom fields for Advanced Custom Fields Pro, if active.
		if ( class_exists( 'acf_pro' ) && ! get_option( 'ccp_acf_activate_settings_page' ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'class-settings-acf-fields.php';
		}

		// Import custom fields for editing, if ACF Pro is active.
		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {
			include_once plugin_dir_path( __FILE__ ) . 'class-fields-import.php';
		}

		// Filter by page template.
		require plugin_dir_path( __FILE__ ) . 'class-admin-template-filter.php';

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
     * @since  1.0.0
	 * @access public
	 * @return array
     */
    public function remove_editor_links() {

		$remove_theme_editor  = remove_submenu_page( 'themes.php', 'theme-editor.php' );
		$remove_plugin_editor = remove_submenu_page( 'plugins.php', 'plugin-editor.php' );

		return array( $remove_theme_editor, $remove_plugin_editor );

	}

	/**
	 * Redirect theme & plugin editor pages.
	 * 
	 * A temporary redirect to the dashboard is created.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object pagenow Gets the current admin screen.
	 * @return void
	 */
	public function redirect_editor_pages() {

		global $pagenow;

		// Redirect if user is on the theme or plugin editor page.
		if ( $pagenow == ( 'plugin-editor.php' ) || $pagenow == 'theme-editor.php' ) {
			wp_redirect( admin_url( '/', 'http' ), 302 );
			exit;
		}

	}

	/**
	 * Remove the WordPress logo from the admin bar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $wp_admin_bar
	 * @return void
	 * 
	 * @todo Make this optional on the Site Settings screen.
	 */
	public function remove_wp_logo( $wp_admin_bar ) {

		$wp_admin_bar->remove_node( 'wp-logo' );

	}

	/**
	 * Remove the search bar from the frontend admin toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object wp_admin_bar
	 * @return void
	 * 
	 * @todo Make this optional on the Site Settings screen.
	 */
	public function adminbar_search() {

		global $wp_admin_bar;

		$wp_admin_bar->remove_menu( 'search' );

	}

	/**
	 * Hide the WordPress update notification to all but admins.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 * 
	 * @todo Make this optional on the Site Settings screen.
	 */
	public function admin_only_updates() {

		// The `update_core` capability includes admins and super admins.
		if ( ! current_user_can( 'update_core' ) ) {
			remove_action( 'admin_notices', 'update_nag', 3 );
		}

	}

	/**
	 * Developer credits in the admin footer text.
	 * 
	 * Give yourself credit for your work and provide your clients
	 * with a link to your site.
	 * 
	 * Replaces the "Thank you for creating with WordPress" text
	 * in the #wpfooter div at the bottom of all admin screens.
	 * 
	 * The output strings contain a trailing space after the period
	 * because other plugins may also tap into the footer. a high 
	 * priority is used on the hook in attempt to put our text first.
	 * 
	 * This replaces text inside the default paragraph (<<p>>) tags.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function admin_footer() {

		// Get the name of the site from Settings > General.
		$site = get_bloginfo( 'name' );

		/**
		 * If the Advanced Custom Fields Pro plugin is active then
		 * we use the input from the fields on the ACF options page.
		 * 
		 * @since  1.0.0
		 */
		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			/**
			 * Get the fields registered by this plugin. An additional parameter
			 * of 'option' must be included to target the options page.
			 */
			$credit = get_field( 'ccp_admin_footer_credit', 'option' );
			$link   = get_field( 'ccp_admin_footer_link', 'option' );

			// If a name and a URL are provided.
			if ( $credit && $link ) {
				$footer = sprintf( 
					'%1s %2s <a href="%3s" target="_blank">%4s</a>. ', 
					$site, 
					esc_html__( 'website designed & developed by', 'controlled-chaos-plugin' ), 
					esc_url( $link ), 
					$credit 
				);
			// If only a name is provided.
			} elseif ( $credit ) {
				$footer = sprintf( 
					'%1s %2s %3s. ', 
					$site, 
					esc_html__( 'website designed & developed by', 'controlled-chaos-plugin' ), 
					$credit 
				);
			// If no input we use the name of the site.
			} else {
				$footer = sprintf( 
					'%1s %2s. ', 
					$site, 
					esc_html__( 'website powered by WordPress', 'controlled-chaos-plugin' ) 
				);
			}
		
		/**
		 * If the Advanced Custom Fields Pro plugin is not active then
		 * we use the input from the fields on the WordPress options page.
		 * 
		 * @since  1.0.0
		 */
		} else {

			$credit = get_option( 'ccp_footer_credit' );
			$link   = get_option( 'ccp_footer_link' );

			// If a name and a URL are provided.
			if ( $credit && $link ) {
				$footer = sprintf( 
					'%1s %2s <a href="%3s" target="_blank">%4s</a>. ', 
					$site, 
					esc_html__( 'website designed & developed by', 'controlled-chaos-plugin' ), 
					esc_url( $link ), 
					$credit 
				);
			// If only a name is provided.
			} elseif ( $credit ) {
				$footer = sprintf( 
					'%1s %2s %3s. ', 
					$site, 
					esc_html__( 'website designed & developed by', 'controlled-chaos-plugin' ), 
					$credit 
				);
			// If no input we use the name of the site.
			} else {
				$footer = sprintf( 
					'%1s %2s. ', 
					$site, 
					esc_html__( 'website powered by WordPress', 'controlled-chaos-plugin' ) 
				);
			}

		}

		// Apply a filter for unforseen possibilities.
		$admin_footer = apply_filters( 'ccp_admin_footer', $footer );

		// Echo the string.
		echo $admin_footer;

	}

	/**
	 * Enqueue the stylesheets for the admin area.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_styles() {

		wp_enqueue_style( 'controlled-chaos-plugin-admin', plugin_dir_url( __FILE__ ) . 'assets/css/admin.css', [], CCP_VERSION, 'all' );

	}

	/**
	 * Enqueue the JavaScript for the admin area.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {

		/**
		 * No custom admin scripts out of the box.
		 * 
		 * This is provided for site-specific development.
		 */
		// wp_enqueue_script( 'controlled-chaos-plugin-admin', plugin_dir_url( __FILE__ ) . 'assets/js/admin.js', [ 'jquery' ], CCP_VERSION, true );

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_admin() {

	return Admin::instance();

}

// Run an instance of the class.
ccp_admin();