<?php
/**
 * Settings for the Site Settings page.
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
 * Settings for the Site Settings page.
 *
 * @since  1.0.0
 * @access public
 */
class Settings_Fields_Site {

	/**
	 * Holds the values to be used in the fields callbacks.
	 *
	 * @var array
	 */
	private $options;

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

			// Require the class files.
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

		// Register settings sections and fields.
		add_action( 'admin_init', [ $this, 'settings' ] );

	}

	/**
	 * Class dependency files.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Callbacks for the Dashboard tab.
		require plugin_dir_path( __FILE__ ) . 'partials/field-callbacks/class-dashboard-callbacks.php';

		// Callbacks for the Admin Menu tab.
		require plugin_dir_path( __FILE__ ) . 'partials/field-callbacks/class-admin-menu-callbacks.php';

		// Callbacks for the Admin Pages tab.
		require plugin_dir_path( __FILE__ ) . 'partials/field-callbacks/class-admin-pages-callbacks.php';

		// Callbacks for the Meta/SEO tab.
		require plugin_dir_path( __FILE__ ) . 'partials/field-callbacks/class-meta-seo-callbacks.php';

	}

	/**
	 * Plugin site settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 *
	 * @link  https://codex.wordpress.org/Settings_API
	 */
	public function settings() {

		/**
		 * Dashboard settings.
		 *
		 * @since 1.0.0
		 */

		// Dashboard settings section.
		add_settings_section(
			'ccp-site-dashboard',
			__( 'Dashboard Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-dashboard'
		);

		// Use the custom welcome panel.
		add_settings_field(
			'ccp_custom_welcome',
			__( 'Custom Welcome', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'custom_welcome' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Use the custom Welcome panel on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_custom_welcome'
		);

		// Hide the welcome panel.
		add_settings_field(
			'ccp_hide_welcome',
			__( 'Hide Welcome', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'hide_welcome' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Welcome panel on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_welcome'
		);

		// Hide the welcome panel dismiss button.
		add_settings_field(
			'ccp_remove_welcome_dismiss',
			__( 'Remove Welcome Dismiss', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'remove_welcome_dismiss' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Remove the Welcome panel dismiss button', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_remove_welcome_dismiss'
		);

		// Hide WordPress News widget.
		add_settings_field(
			'ccp_hide_wp_news',
			__( 'Hide WordPress News', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'hide_wp_news' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the WordPress News widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_wp_news'
		);

		// Hide Quick Draft (QuickPress) widget.
		add_settings_field(
			'ccp_hide_quickpress',
			__( 'Hide Quick Draft', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'hide_quickpress' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Quick Draft widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_quickpress'
		);

		// Hide At a Glance widget.
		add_settings_field(
			'ccp_hide_at_glance',
			__( 'Hide At a Glance', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'hide_at_glance' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the At a Glance widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_at_glance'
		);

		// Hide Activity widget.
		add_settings_field(
			'ccp_hide_activity',
			__( 'Hide Activity', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Dashboard_Callbacks::instance(), 'hide_activity' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Activity widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_activity'
		);

		/**
		 * Admin menu settings.
		 *
		 * @since 1.0.0
		 */

		// Admin menu settings section.
		add_settings_section(
			'ccp-site-admin-menu',
			__( 'Admin Menu Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-admin-menu'
		);

		// Site Settings page position.
		add_settings_field(
			'ccp_site_settings_position',
			__( 'Site Settings Position', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'site_settings_position' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make this settings page a top-level link.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_settings_position'
		);

		// Site Settings page link label.
		add_settings_field(
			'ccp_site_settings_link_label',
			__( 'Site Settings Label', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'site_settings_link_label' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Change the label of the link to this page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_settings_link_label'
		);

		// Site Settings page link icon if set to top level.
		add_settings_field(
			'ccp_site_settings_link_icon',
			__( 'Site Settings Icon', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'site_settings_link_icon' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Enter a Dashicons CSS class for the icon of the link to this page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_settings_link_icon'
		);

		// Site Plugin page position.
		add_settings_field(
			'ccp_site_plugin_position',
			__( 'Site Plugin Position', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'site_plugin_position' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make the site-specific plugin admin page a top-level link.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_plugin_position'
		);

		// Site Plugin page link label.
		add_settings_field(
			'ccp_site_plugin_link_label',
			__( 'Site Plugin Label', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'site_plugin_link_label' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Change the label of the link to the site-specific plugin page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_plugin_link_label'
		);

		// Site Plugin page link icon if set to top level.
		add_settings_field(
			'ccp_site_plugin_link_icon',
			__( 'Site Plugin Icon', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'site_plugin_link_icon' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Enter a Dashicons CSS class for the icon of the link to the site-specific plugin page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_plugin_link_icon'
		);

		// Menus link position.
		add_settings_field(
			'ccp_menus_position',
			__( 'Menus Position', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'menus_position' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make Menus a top-level link', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_menus_position'
		);

		// Widgets link position.
		add_settings_field(
			'ccp_widgets_position',
			__( 'Widgets Position', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'widgets_position' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make Widgets a top-level link', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_widgets_position'
		);

		// Hide Appearance link.
		add_settings_field(
			'ccp_hide_appearance',
			__( 'Hide Appearance', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'hide_appearance' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Appearance link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_appearance'
		);

		// Hide Plugins link.
		add_settings_field(
			'ccp_hide_plugins',
			__( 'Hide Plugins', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'hide_plugins' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Plugins link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_plugins'
		);

		// Hide Users link.
		add_settings_field(
			'ccp_hide_users',
			__( 'Hide Users', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'hide_users' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Users link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_users'
		);

		// Hide Tools link.
		add_settings_field(
			'ccp_hide_tools',
			__( 'Hide Tools', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'hide_tools' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Tools link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_tools'
		);

		// Show/Hide Links Manager link.
		add_settings_field(
			'ccp_hide_links',
			__( 'Restore Links Manager', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Menu_Callbacks::instance(), 'hide_links' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'The old Links Manager is hidden by default in newer WordPress installations', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_links'
		);

		/**
		 * Admin pages settings.
		 *
		 * @since 1.0.0
		 */

		// Admin pages settings section.
		add_settings_section(
			'ccp-site-admin-pages',
			__( 'Admin Pages Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-admin-pages'
		);

		// Admin footer credit.
		add_settings_field(
			'ccp_footer_credit',
			__( 'Admin Footer Credit', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Pages_Callbacks::instance(), 'footer_credit' ],
			'ccp-site-admin-pages',
			'ccp-site-admin-pages',
			[ esc_html__( 'The "developed by" credit.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-pages',
			'ccp_footer_credit'
		);

		// Admin footer link.
		add_settings_field(
			'ccp_footer_link',
			__( 'Admin Footer Link', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Admin_Pages_Callbacks::instance(), 'footer_link' ],
			'ccp-site-admin-pages',
			'ccp-site-admin-pages',
			[ esc_html__( 'Link to the website devoloper.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-pages',
			'ccp_footer_link'
		);

		/**
		 * Meta & SEO settings.
		 *
		 * @since 1.0.0
		 */

		// Meta/SEO settings section.
		add_settings_section(
			'ccp-site-meta-seo',
			__( 'Meta & SEO Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-meta-seo'
		);

		// Disable meta tags.
		add_settings_field(
			'ccp_meta_disable',
			__( 'Meta Tags', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Meta_SEO_Callbacks::instance(), 'disable_meta' ],
			'ccp-site-meta-seo',
			'ccp-site-meta-seo',
			[ esc_html__( 'Disable if your theme includes SEO meta tags or if you plan on using an SEO plugin.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-meta-seo',
			'ccp_meta_disable'
		);

		// Organization Schema type.
		add_settings_field(
			'schema_org_type',
			__( 'Organization Type', 'controlled-chaos-plugin' ),
			[ Partials\Field_Callbacks\Meta_SEO_Callbacks::instance(), 'schema_org_type' ],
			'ccp-site-meta-seo',
			'ccp-site-meta-seo',
			[ esc_html__( 'Select a category that generally applies to this website.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-meta-seo',
			'schema_org_type'
		);

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_settings_fields_site() {

	return Settings_Fields_Site::instance();

}

// Run an instance of the class.
ccp_settings_fields_site();