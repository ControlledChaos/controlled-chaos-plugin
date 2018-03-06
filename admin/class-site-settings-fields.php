<?php
/**
 * Plugin and site settings.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Site_Settings;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin and site settings.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Site_Settings {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

		// Register settings sections and fields.
		add_action( 'admin_init', [ $this, 'settings' ] );

	}

	/**
	 * Plugin site settings.
	 * 
	 * @since    1.0.0
	 */
	public function settings() {

		/**
		 * Dashboard.
		 */
		add_settings_section( 'ccp-site-dashboard', __( 'Dashboard Settings', 'controlled-chaos' ), [], 'ccp-site-dashboard' );

		// Hide Welcome panel.
		add_settings_field( 'ccp_hide_welcome', __( 'Hide Welcome', 'controlled-chaos' ), [ $this, 'ccp_hide_welcome_callback' ], 'ccp-site-dashboard', 'ccp-site-dashboard', [ esc_html__( 'Hide the Welcome panel on the Dashboard', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_welcome'
		);

		// Hide WordPress News widget.
		add_settings_field( 'ccp_hide_wp_news', __( 'Hide WordPress News', 'controlled-chaos' ), [ $this, 'ccp_hide_wp_news_callback' ], 'ccp-site-dashboard', 'ccp-site-dashboard', [ esc_html__( 'Hide the WordPress News widget on the Dashboard', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_wp_news'
		);

		// Hide Quick Draft (QuickPress) widget.
		add_settings_field( 'ccp_hide_quickpress', __( 'Hide Quick Draft', 'controlled-chaos' ), [ $this, 'ccp_hide_quickpress_callback' ], 'ccp-site-dashboard', 'ccp-site-dashboard', [ esc_html__( 'Hide the Quick Draft widget on the Dashboard', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_quickpress'
		);

		// Hide At a Glance widget.
		add_settings_field( 'ccp_hide_at_glance', __( 'Hide At a Glance', 'controlled-chaos' ), [ $this, 'ccp_hide_at_glance_callback' ], 'ccp-site-dashboard', 'ccp-site-dashboard', [ esc_html__( 'Hide the At a Glance widget on the Dashboard', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_at_glance'
		);

		// Hide Activity widget.
		add_settings_field( 'ccp_hide_activity', __( 'Hide Activity', 'controlled-chaos' ), [ $this, 'ccp_hide_activity_callback' ], 'ccp-site-dashboard', 'ccp-site-dashboard', [ esc_html__( 'Hide the Activity widget on the Dashboard', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_activity'
		);

	}

	/**
	 * Hide Welcome panel.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_hide_welcome_callback( $args ) {

		$option = get_option( 'ccp_hide_welcome' );

		$html = '<p><input type="checkbox" id="ccp_hide_welcome" name="ccp_hide_welcome" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_welcome"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide WordPress News widget.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_hide_wp_news_callback( $args ) {

		$option = get_option( 'ccp_hide_wp_news' );

		$html = '<p><input type="checkbox" id="ccp_hide_wp_news" name="ccp_hide_wp_news" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_wp_news"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Quick Draft (QuickPress) widget.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_hide_quickpress_callback( $args ) {

		$option = get_option( 'ccp_hide_quickpress' );

		$html = '<p><input type="checkbox" id="ccp_hide_quickpress" name="ccp_hide_quickpress" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_quickpress"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide At a Glance widget.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_hide_at_glance_callback( $args ) {

		$option = get_option( 'ccp_hide_at_glance' );

		$html = '<p><input type="checkbox" id="ccp_hide_at_glance" name="ccp_hide_at_glance" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_at_glance"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Activity widget.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_hide_activity_callback( $args ) {

		$option = get_option( 'ccp_hide_activity' );

		$html = '<p><input type="checkbox" id="ccp_hide_activity" name="ccp_hide_activity" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_activity"> '  . $args[0] . '</label></p>';

		echo $html;

	}

}

$controlled_chaos_site_settings = new Controlled_Chaos_Site_Settings;