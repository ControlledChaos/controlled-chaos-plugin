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

			// Require the class files.
			$instance->dependencies();

			// Site settings defaults.
			$instance->site_settings();

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
    public function __construct() {}

	/**
	 * Class dependency files.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Settings for the Dashboard tab.
		require CCP_PATH . 'admin/class-settings-fields-site-dashboard.php';

		// Settings for the Admin Menu tab.
		require CCP_PATH . 'admin/class-settings-fields-site-admin-menu.php';

		// Settings for the Admin Menu tab.
		require CCP_PATH . 'admin/class-settings-fields-site-admin-pages.php';

		// Settings for the Admin Menu tab.
		require CCP_PATH . 'admin/class-settings-fields-site-users.php';

		// Callbacks for the Meta/SEO tab.
		require CCP_PATH . 'admin/class-settings-fields-site-meta-seo.php';

	}

	/**
	 * Undocumented function
	 *
	 * @since  1.0.0
	 * @access public
	 * @return array
	 */
	public function site_settings() {

		$defaults = [
			'custom_welcome'      => false,
			'try_gutenberg'       => false,
			'welcome'             => false,
			'dismiss'             => false,
			'wp_news'             => false,
			'quickpress'          => false,
			'at_glance'           => false,
			'activity'            => false,
			'settings_position'   => false,
			'settings_link_label' => __( 'Site Settings', 'controlled-chaos-plugin' ),
			'settings_link_icon'  => 'dashicons-welcome-learn-more',
			'plugin_position'     => false,
			'plugin_link_label'   => false,
			'plugin_link_icon'    => false,
			'menus_position'      => false,
			'widgets_position'    => false,
			'appearance'          => false,
			'plugins'             => false,
			'users'               => false,
			'tools'               => false,
			'links'               => false
		];

		return apply_filters ( 'ccp_site_settings', $defaults );

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