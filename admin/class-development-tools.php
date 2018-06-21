<?php

/**
 * Controlled Chaos development tools page.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage Controlled_Chaos\admin
 */

namespace CC_Plugin\Plugin_Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The admin development page.
 *
 * @package    controlled-chaos
 * @subpackage Controlled_Chaos\admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Admin_Tools {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
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
	 * @since 1.0.0
	 */
	public function dev_tools_page() {

		add_submenu_page( 'tools.php', __( 'Website Development', 'controlled-chaos-plugin' ), __( 'Site Development', 'controlled-chaos-plugin' ), 'manage_options', 'controlled-chaos-dev-tools', [ $this, 'dev_tools_output' ] );

	}

	/**
	 * Get development subpage output.
	 * 
	 * @since 1.0.0
	 */
	public function dev_tools_output() {

		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-development.php';

	}

	/**
	 * Settings for the development page.
	 * 
	 * @since 1.0.0
	 */
	public function dev_settings() {

		/**
		 * Layout testing.
		 */
		add_settings_section( 'layout-testing', __( 'Layout Testing', 'controlled-chaos-plugin' ), [ $this, 'layout_testing_section_callback' ], 'layout-testing' );

		// RTL (right to left) test.
		add_settings_field( 'ccp_rtl_test', __( 'RTL (right to left) test', 'controlled-chaos-plugin' ), [ $this, 'ccp_rtl_test_callback' ], 'layout-testing', 'layout-testing', [ esc_html__( 'Add RTL button to the toolbar to test layout in languages that read right to left.', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'layout-testing',
			'ccp_rtl_test'
		);

	}

	/**
	 * Layout testing section callback.
	 * 
	 * @since    1.0.0
	 */
	public function layout_testing_section_callback( $args ) {

		$html = sprintf( '<p>%1s</p>', esc_html__( '', 'controlled-chaos-plugin' ) );

		echo $html;

	}

	/**
	 * RTL testing.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_rtl_test_callback( $args ) {

		$option = get_option( 'ccp_rtl_test' );

		$html = '<p><input type="checkbox" id="ccp_rtl_test" name="ccp_rtl_test" value="1" ' . checked( 1, $option, false ) . '/>';		
		$html .= '<label for="ccp_rtl_test"> '  . $args[0] . '</label></p>';
		$html .= sprintf( '<p>%1s <a href="%2s" target="_blank">%3s</a></p>', __( 'Reference:', 'controlled-chaos-plugin' ), esc_url( 'https://codex.wordpress.org/Right_to_Left_Language_Support' ), esc_html__( 'https://codex.wordpress.org/Right_to_Left_Language_Support' ) );

		echo $html;

	}

}

$ccp_admin_tools = new Controlled_Chaos_Admin_Tools();