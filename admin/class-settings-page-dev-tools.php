<?php
/**
 * Settings page for site development.
 *
 * This class adds an admin page under Tools in the admin menu
 * at which several tools for the website development process
 * are provieded.
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
 * Settings page for site development.
 *
 * @since  1.0.0
 * @access public
 */
class Settings_Page_Dev_Tools {

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

	}

	/**
	 * Add development subpage to Tools in the admin menu.
	 *
	 * Uses the universal slug partial for admin pages. Set this
     * slug in the core plugin file.
	 *
	 * Adds a contextual help section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function settings_page() {

		$this->page_help_section = add_management_page(
			__( 'Website Development', 'controlled-chaos-plugin' ),
			__( 'Site Development', 'controlled-chaos-plugin' ),
			'manage_options',
			CCP_ADMIN_SLUG . '-dev-tools',
			[ $this, 'page_output' ]
		);

		// Add content to the Help tab.
		add_action( 'load-' . $this->page_help_section, [ $this, 'page_help_section' ] );

	}

	/**
	 * Get development subpage output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function page_output() {

		require CCP_PATH . 'admin/partials/settings-page-development.php';

	}

	/**
     * Output for the development page contextual help section.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function page_help_section() {

		// Add to the development page.
		$screen = get_current_screen();
		if ( $screen->id != $this->page_help_section ) {
			return;
		}

		// More information.
		$screen->add_help_tab( [
			'id'       => 'help_dev_info',
			'title'    => __( 'More Information', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_dev_info_output' ]
		] );

		// Add a help sidebar.
		$screen->set_help_sidebar(
			$this->help_dev_info_sidebar()
		);

    }

    /**
     * Get more information help tab content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_dev_info_output() {

		include_once CCP_PATH . 'admin/partials/help/help-dev-info.php';

    }

    /**
     * Get development page contextual tab sidebar content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function help_dev_info_sidebar() {

		$html = '';

		return $html;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_settings_page_dev_tools() {

	return Settings_Page_Dev_Tools::instance();

}

// Run an instance of the class.
ccp_settings_page_dev_tools();