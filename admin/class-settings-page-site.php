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
	 * Instance of the class
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
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

		// Add the page to the admin menu.
		add_action( 'admin_menu', [ $this, 'settings_page' ] );

		// Add ACF documentation link to admin menu.
		add_action( 'admin_menu', [ $this, 'acf_docs_link' ], 101 );

	}

	/**
	 * Add a page for site settings.
	 *
	 * If the Advanced Custom Fields Pro plugin is active then
	 * an ACF options page and ACF fields will be used. If not
	 * then a default WordPress/ClassicPress admin page and the
	 * Settings API will be used.
	 *
	 * Uses the universal slug partial for admin pages. Set this
     * slug in the core plugin file.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global string pagenow Gets the current admin screen URL.
	 * @return void
	 *
	 * @link   https://www.advancedcustomfields.com/resources/acf_add_options_page/
	 * @link   https://developer.wordpress.org/reference/functions/add_menu_page/
	 * @link   https://developer.wordpress.org/reference/functions/add_submenu_page/
	 *
	 * @todo  Think about whether this is a good idea. Maybe it's
	 *        better to simply provide a sample ACF page. ACF is
	 *        certainly faster for further development but do we
	 *        want the dependency?
	 */
    public function settings_page() {

		// If the Advanced Custom Fields Pro plugin is active.
		if ( ccp_acf_options() ) {

			// Use the site name in the title tag but apply a filter for customization.
			$title      = apply_filters( 'site_settings_page_name', get_bloginfo( 'name' ) );

			/**
			 * Get the options firelds related to the ACF settings page.
			 *
			 * @since  1.0.0
			 */

			// The position of the page in the admin menu (top-level or under Dashboard).
			$position   = get_field( 'ccp_settings_link_position', 'option' );

			// The label of the page in the admin menu.
			$link_label = get_field( 'ccp_site_settings_link_label', 'option' );

			// The icon used for the pagin in the admin menu.
			$link_icon  = get_field( 'ccp_site_settings_link_icon', 'option' );

			// Use the custom admin menu label if the field is not empty.
			if ( $link_label ) {
				$label = $link_label;

			// Otherwise use "Site Settings" as the label.
			}  else {
				$label = __( 'Site Settings', 'controlled-chaos-plugin' );
			}

			// Use the custom admin menu icon if the field is not empty.
			if ( $link_icon ) {
				$icon = $link_icon;

			// Otherwise use the Admin Settings icon.
			}  else {
				$icon = 'dashicons-admin-settings';
			}

			/**
			 * If the ACF position has been set to top-level then create
			 * a page with an icon and no parent, just under Dahboard (3).
			 */
			if ( 'top' == $position ) {

				// Page arguments.
				$settings = apply_filters( 'controlled_chaos_site_settings_page_top', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos-plugin' ),
					'menu_title' => $label,
					'menu_slug'  => CCP_ADMIN_SLUG . '-settings',
					'icon_url'   => $icon,
					'position'   => 3,
					'capability' => 'manage_options',
					'redirect'   => false
				] );

				// Add the settings page.
				acf_add_options_page( $settings );

				// Remove the default settings links at the bottom of the admin menu.
				remove_menu_page( 'options-general.php' );

			/**
			 * If the ACF position is default then create a page without an icon and
			 * no parent as a submenu page under Dahboard (index.php).
			 */
			} else {

				$settings = apply_filters( 'controlled_chaos_site_settings_page_default', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos-plugin' ),
					'menu_title' => $label,
					'menu_slug'  => CCP_ADMIN_SLUG . '-settings',
					'parent'     => 'index.php',
					'capability' => 'manage_options'
				] );

				// Add the settings page.
				acf_add_options_page( $settings );

			}

		// If the Advanced Custom Fields Pro plugin is not active.
		} else {

			/**
			 * Get the options firelds related to the WordPress/ClassicPress settings page.
			 *
			 * @since  1.0.0
			 */

			// The position of the page in the admin menu (top-level or under Dashboard).
			$position   = get_option( 'ccp_site_settings_position' );

			// The label of the page in the admin menu.
			$link_label = sanitize_text_field( get_option( 'ccp_site_settings_link_label' ) );

			// The icon used for the pagin in the admin menu.
			$link_icon  = sanitize_text_field( get_option( 'ccp_site_settings_link_icon' ) );

			// Use the custom admin menu icon if the field is not empty.
			if ( $link_label ) {
				$label = $link_label;

			// Otherwise use "Site Settings" as the label.
			}  else {
				$label = __( 'Site Settings', 'controlled-chaos-plugin' );
			}

			// Use the custom admin menu icon if the field is not empty.
			if ( $link_icon ) {
				$icon = $link_icon;

			// Otherwise use the Admin Settings icon.
			}  else {
				$icon = __( 'dashicons-admin-settings', 'controlled-chaos-plugin' );
			}

			/**
			 * If the position has been set to top-level then create a page
			 * with an icon and no parent, just under Dahboard (3).
			 */
			if ( $position ) {
				$this->page_help_section = add_menu_page(
					$label,
					$label,
					'manage_options',
					CCP_ADMIN_SLUG . '-settings',
					[ $this, 'page_output' ],
					$icon,
					3
				);

				// Remove the default settings links at the bottom of the admin menu.
				remove_menu_page( 'options-general.php' );

				// Add content to the Help tab.
				add_action( 'load-' . $this->page_help_section, [ $this, 'page_help_section' ] );

			/**
			 * If the position is default then create a page without an icon and
			 * no parent as a submenu page under Dahboard (index.php).
			 */
			} else {
				$this->page_help_section = add_submenu_page(
					'index.php',
					$label,
					$label,
					'manage_options',
					CCP_ADMIN_SLUG . '-settings',
					[ $this, 'page_output' ]
				);

				// Add content to the Help tab.
				add_action( 'load-' . $this->page_help_section, [ $this, 'page_help_section' ] );
			}

			// Redirect to new settings page URL when menu position is changed.
			if ( isset( $_GET['page'] ) ) {

				// Get the current admin screen URL.
				global $pagenow;

				// If on the Dashboard submenu page and top level option is selected.
				if (
					$position
					&& in_array( $pagenow, [ 'index.php' ] )
					&& ( $_GET['page'] == CCP_ADMIN_SLUG . '-settings' )
				) {
					wp_redirect( admin_url( 'admin.php?page=' . CCP_ADMIN_SLUG . '-settings&tab=admin-menu' ), 302 );

				// If on the top level page and top level option is not selected.
				} elseif (
					! $position
					&& in_array( $pagenow, [ 'admin.php' ] )
					&& ( $_GET['page'] == CCP_ADMIN_SLUG . '-settings' )
				) {
					wp_redirect( admin_url( 'index.php?page=' . CCP_ADMIN_SLUG . '-settings&tab=admin-menu' ), 302 );
				}
			}

		}

	}

	/**
     * Output for the Site Settings page contextual help tab.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function page_help_section() {

		// Add to the plugin settings pages.
		$screen = get_current_screen();
		if ( $screen->id != $this->page_help_section ) {
			return;
		}

		// Inline Scripts.
		$screen->add_help_tab( [
			'id'       => 'inline_scripts',
			'title'    => __( 'ACF Notice', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_acf_settings_notice' ]
		] );

		// Add a help sidebar.
		$screen->set_help_sidebar(
			$this->page_help_section_sidebar()
		);

	}

	/**
     * Get ACF Notice help content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_acf_settings_notice() {

		include_once CCP_PATH . 'admin/partials/help/help-acf-notice.php';

	}

	/**
     * Get Site Settings page contextual tab sidebar content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function page_help_section_sidebar() {

		$html = '<ul>
			<li><a href="https://www.advancedcustomfields.com/resources/" target="_blank" style="text-decoration: none;">' . __( 'ACF Documentation', 'controlled-chaos-plugin' ) . '</a></li>
		</ul>';

		return $html;

	}

	/**
	 * Site Settings page output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function page_output() {

		// Get the partial that contains the settings page HTML.
		require CCP_PATH . 'admin/partials/settings-page-site.php';

	}

	/**
	 * Add ACF documentation link to admin menu.
	 *
	 * Checks for the Advanced Custom Fields plugin,
	 * both the Pro and free editions.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function acf_docs_link() {

		if ( ccp_acf_options() ) {

			global $submenu;
			$url = 'https://www.advancedcustomfields.com/resources/';
			$submenu['edit.php?post_type=acf-field-group'][] = [ __( 'Documentation', 'controlled-chaos-plugin' ), 'manage_options', $url ];

		}

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