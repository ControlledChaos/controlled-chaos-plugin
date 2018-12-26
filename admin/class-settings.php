<?php
/**
 * The core settings class for the plugin.
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
 * Admin functiontionality and settings.
 *
 * @since  1.0.0
 * @access public
 */
class Settings {

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

		}

		// Return the instance.
		return $instance;

	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void Constructor method is empty.
	 *              Change to `self` if used.
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

		/**
		 * Settings pages.
		 *
		 * @since  1.0.0
		 */

		// Settings fields for script loading and more.
		require_once CCP_PATH . 'admin/class-settings-page-scripts.php';

		// Settings fields for site customization.
		require_once CCP_PATH . 'admin/class-settings-page-site.php';

		// Fields for the Media Settings page.
		require_once CCP_PATH . 'admin/class-settings-page-dev-tools.php';

		/**
		 * Settings fields.
		 *
		 * @since  1.0.0
		 */

		// Settings fields for script loading and more.
		require_once CCP_PATH . 'admin/class-settings-fields-scripts.php';

		// Settings fields for site customization.
		require_once CCP_PATH . 'admin/class-settings-fields-site.php';

		// Settings fields for the media settings page.
		require_once CCP_PATH . 'admin/class-settings-fields-media.php';

		// Settings fields for development tools page.
		require_once CCP_PATH . 'admin/class-settings-fields-dev-tools.php';

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_settings() {

	return Settings::instance();

}

// Run an instance of the class.
ccp_settings();