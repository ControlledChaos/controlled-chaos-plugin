<?php
/**
 * Development admin page.
 * 
 * This class adds an admin page under Tools in the admin menu
 * at which several tools for the website development process
 * are provieded.
 *
 * @package    Controlled_Chaos
 * @subpackage Controlled_Chaos_Plugin\Admin
 * 
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 * 
 * @todo       Add a "Dev Mode", functionality to be determined.
 *             Currently only contains the RTL tester.
 * @todo       Finish converting the debug plugin to work with a setting.
 */

namespace CC_Plugin\Plugin_Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Development admin page.
 *
 * @since  1.0.0
 * @access public
 */
class Admin_Tools {

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

		// Add development subpage.
		add_action( 'admin_menu', [ $this, 'dev_tools_page' ] );

		// Start settings for page.
		add_action( 'admin_init', [ $this, 'dev_settings' ] );
		
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
	public function dev_tools_page() {

		$this->help_development = add_submenu_page( 
			'tools.php', 
			__( 'Website Development', 'controlled-chaos-plugin' ), 
			__( 'Site Development', 'controlled-chaos-plugin' ), 
			'manage_options', 
			CCP_ADMIN_SLUG . '-dev-tools', 
			[ $this, 'dev_tools_output' ] 
		);

		// Add content to the Help tab.
		add_action( 'load-' . $this->help_development, [ $this, 'help_development' ] );

	}

	/**
	 * Get development subpage output.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dev_tools_output() {

		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-development.php';

	}

	/**
     * Output for the development page contextual help section.
	 * 
	 * @since      1.0.0
     */
    public function help_development() {

		// Add to the development page.
		$screen = get_current_screen();
		if ( $screen->id != $this->help_development ) {
			return;
		}
		
		// More information.
		$screen->add_help_tab( [
			'id'       => 'help_dev_info',
			'title'    => __( 'More Information', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_dev_info_output' ]
		] );
		
		$screen->set_help_sidebar(
			$this->help_dev_info_sidebar()
		);
		
    }
    
    /**
     * Get more information help tab content.
	 * 
	 * @since      1.0.0
     */
	public function help_dev_info_output() { 
		
		include_once plugin_dir_path( __FILE__ ) . 'partials/help/help-dev-info.php';
	
    }
    
    /**
     * Get development page contextual tab sidebar content.
	 * 
	 * @since      1.0.0
     */
    public function help_dev_info_sidebar() {

		$html = '';

		return $html;

	}

	/**
	 * Settings for the development page.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dev_settings() {

		/**
		 * Site development.
		 */
		
		// Site development settings section.
		add_settings_section( 
			'site-development', 
			__( 'Site Development', 'controlled-chaos-plugin' ), 
			[ $this, 'site_development_section_callback' ], 
			'site-development' 
		);

		// Site development settings field.
		add_settings_field( 
			'ccp_site_development', 
			__( 'Debug Mode', 'controlled-chaos-plugin' ), 
			[ $this, 'ccp_site_development_callback' ], 
			'site-development', 
			'site-development', 
			[ esc_html__( 'Put the site in Debug Mode via wp-config.', 'controlled-chaos-plugin' ) ] 
		);

		// Register the Site development field.
		register_setting(
			'site-development',
			'ccp_site_development'
		);

		// Live theme test settings field.
		add_settings_field( 
			'ccp_theme_test', 
			__( 'Live Theme Test', 'controlled-chaos-plugin' ), 
			[ $this, 'ccp_theme_test_callback' ], 
			'site-development', 
			'site-development', 
			[ esc_html__( 'Find the theme test page under Appearances.', 'controlled-chaos-plugin' ) ] 
		);

		// Register the live theme test field.
		register_setting(
			'site-development',
			'ccp_theme_test'
		);

		// RTL (right to left) test settings field.
		add_settings_field( 
			'ccp_rtl_test', 
			__( 'RTL (Right to Left) Test', 'controlled-chaos-plugin' ), 
			[ $this, 'ccp_rtl_test_callback' ], 
			'site-development', 
			'site-development', 
			[ esc_html__( 'Add RTL button to the toolbar to test layout in languages that read right to left.', 'controlled-chaos-plugin' ) ] 
		);

		// Register the RTL test field.
		register_setting(
			'site-development',
			'ccp_rtl_test'
		);

	}

	/**
	 * Site development section callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Holds the settings section array.
	 * @return string Returns the section HTML.
	 */
	public function site_development_section_callback( $args ) {

		$html = sprintf( 
			'<p>%1s</p>', 
			esc_html__( '', 'controlled-chaos-plugin' ) 
		);

		echo $html;

	}

	/**
	 * Site development field callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Holds the settings field array.
	 * @return string Returns the field HTML.
	 */
	public function ccp_site_development_callback( $args ) {

		$option = get_option( 'ccp_site_development' );

		$html   = '<p><input type="checkbox" id="ccp_site_development" name="ccp_site_development" value="1" ' . checked( 1, $option, false ) . '/>';		
		$html  .= '<label for="ccp_site_development"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Live theme test field callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Holds the settings field array.
	 * @return string Returns the field HTML.
	 */
	public function ccp_theme_test_callback( $args ) {

		$option = get_option( 'ccp_theme_test' );

		$html   = '<p><input type="checkbox" id="ccp_theme_test" name="ccp_theme_test" value="1" ' . checked( 1, $option, false ) . '/>';
		$html  .= sprintf( 
			'<label for="ccp_theme_test">%1s</label></p>',
			$args[0]
		 );

		echo $html;

	}

	/**
	 * RTL test field callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Holds the settings field array.
	 * @return string Returns the field HTML.
	 */
	public function ccp_rtl_test_callback( $args ) {

		$option = get_option( 'ccp_rtl_test' );

		$html   = '<p><input type="checkbox" id="ccp_rtl_test" name="ccp_rtl_test" value="1" ' . checked( 1, $option, false ) . '/>';
		$html  .= sprintf( 
			'<label for="ccp_rtl_test">%1s</label> <a href="%2s" target="_blank" title="%3s"><span class="dashicons dashicons-editor-help"></span></a></p>',
			$args[0],
			esc_url( 'https://codex.wordpress.org/Right_to_Left_Language_Support' ), 
			__( 'Read more in the WordPress Codex', 'controlled-chaos-plugin' )
		 );

		echo $html;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_admin_tools() {

	return Admin_Tools::instance();

}

// Run an instance of the class.
ccp_admin_tools();