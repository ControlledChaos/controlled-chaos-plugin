<?php
/**
 * Plugin and site settings.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Settings;

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
class Controlled_Chaos_Settings {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

		// Settings dependencies.
		$this->dependencies();

		// Add scripts settings page.
		add_action( 'admin_menu', [ $this, 'scripts_settings_page' ] );

		// Register settings.
		add_action( 'admin_init', [ $this, 'settings' ] );

        // Add ACF options page.
    	add_action( 'admin_menu', [ $this, 'site_settings_page' ] );

	}

	/**
	 * Admin file dependencies.
	 *
	 * @since    1.0.0
	 */
	public function dependencies() {

		// Fields for the Site Settings page.
		require plugin_dir_path( __FILE__ ) . 'class-site-settings-fields.php';

	}
	
	/**
	 * Add scripts settings page.
	 *
	 * @since    1.0.0
	 */
    public function scripts_settings_page() {

		add_options_page(
			__( 'Script Options', 'controlled-chaos' ),
			__( 'Script Options', 'controlled-chaos' ),
			'manage_options',
			'controlled-chaos-scripts',
			[ $this, 'settings_scripts_output' ]
		);

	}

	/**
	 * Script Options page output.
	 *
	 * @since    1.0.0
	 */
    public function settings_scripts_output() {
		
		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-scripts.php';

	}

	/**
	 * Plugin settings, various.
	 * 
	 * @since    1.0.0
	 */
	public function settings() {

		/**
		 * Generl script options.
		 */
		add_settings_section( 'ccp-scripts-general', __( 'General Options', 'controlled-chaos' ), [], 'ccp-scripts-general' );

		// Inline scripts.
		add_settings_field( 'ccp_inline_scripts', __( 'Inline scripts', 'controlled-chaos' ), [ $this, 'ccp_inline_scripts_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Add script contents to footer to reduce HTTP requests and increase load speed', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_inline_scripts'
		);

		// Inline styles.
		add_settings_field( 'ccp_inline_styles', __( 'Inline styles', 'controlled-chaos' ), [ $this, 'ccp_inline_styles_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Add script-related CSS contents to head to reduce HTTP requests and increase load speed', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_inline_styles'
		);

		// Inline jQuery.
		add_settings_field( 'ccp_inline_jquery', __( 'Inline jQuery', 'controlled-chaos' ), [ $this, 'ccp_inline_jquery_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Deregister jQuery and add its contents to footer, ahead of vendor scripts', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_inline_jquery'
		);

		// Remove emoji script.
		add_settings_field( 'ccp_remove_emoji_script', __( 'Emoji script', 'controlled-chaos' ), [ $this, 'remove_emoji_script_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Remove emoji script from <head> (emojis will still work in modern browsers)', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_remove_emoji_script'
		);
		
		// Remove WordPress version appended to script links.
		add_settings_field( 'ccp_remove_script_version', __( 'Script versions', 'controlled-chaos' ), [ $this, 'remove_script_version_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Remove WordPress version from script and stylesheet links in <head>', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_remove_script_version'
		);

		/**
		 * Use included vendor scripts & options.
		 */
		add_settings_section( 'ccp-scripts-vendor', __( 'Included Vendor Scripts', 'controlled-chaos' ), [ $this, 'ccp_scripts_vendor_section_callback' ], 'ccp-scripts-vendor' );

		// Use Slick.
		add_settings_field( 'ccp_enqueue_slick', __( 'Slick', 'controlled-chaos' ), [ $this, 'enqueue_slick_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Slick script and stylesheets', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_slick'
		);

		// Use Tabslet.
		add_settings_field( 'ccp_enqueue_tabslet', __( 'Tabslet', 'controlled-chaos' ), [ $this, 'enqueue_tabslet_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Tabslet script', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_tabslet'
		);

		// Use Sticky-kit.
		add_settings_field( 'ccp_enqueue_stickykit', __( 'Sticky-kit', 'controlled-chaos' ), [ $this, 'enqueue_stickykit_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Sticky-kit script', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_stickykit'
		);

		// Use Tooltipster.
		add_settings_field( 'ccp_enqueue_tooltipster', __( 'Tooltipster', 'controlled-chaos' ), [ $this, 'enqueue_tooltipster_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Tooltipster script and stylesheet', 'controlled-chaos' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_tooltipster'
		);
	
		// Site Settings section.
		if ( class_exists( 'ACF_Pro' ) ) {

			add_settings_section( 'ccp-registered-fields-activate', __( 'Registered Fields Activation', 'controlled-chaos' ), [ $this, 'registered_fields_activate' ], 'ccp-registered-fields-activate' );
			
			add_settings_field( 'ccp_acf_activate_settings_page', __( 'Site Settings Page', 'controlled-chaos' ), [ $this, 'registered_fields_page_callback' ], 'ccp-registered-fields-activate', 'ccp-registered-fields-activate', [ __( 'Deactive the field group for the "Site Settings" options page.', 'controlled-chaos' ) ] );

			register_setting(
				'ccp-registered-fields-activate',
				'ccp_acf_activate_settings_page'
			);

		}

	}

	/**
	 * Inline jQuery.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_inline_jquery_callback( $args ) {

		$option = get_option( 'ccp_inline_jquery' );

		$html = '<p><input type="checkbox" id="ccp_inline_jquery" name="ccp_inline_jquery" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_inline_jquery"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Inline scripts.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_inline_scripts_callback( $args ) {

		$option = get_option( 'ccp_inline_scripts' );

		$html = '<p><input type="checkbox" id="ccp_inline_scripts" name="ccp_inline_scripts" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_inline_scripts"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Inline styles.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_inline_styles_callback( $args ) {

		$option = get_option( 'ccp_inline_styles' );

		$html = '<p><input type="checkbox" id="ccp_inline_styles" name="ccp_inline_styles" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_inline_styles"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Remove emoji script.
	 * 
	 * @since    1.0.0
	 */
	public function remove_emoji_script_callback( $args ) {

		$option = get_option( 'ccp_remove_emoji_script' );

		$html = '<p><input type="checkbox" id="ccp_remove_emoji_script" name="ccp_remove_emoji_script" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_remove_emoji_script"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Script options and enqueue settings.
	 * 
	 * @since    1.0.0
	 */
	public function remove_script_version_callback( $args ) {

		$option = get_option( 'ccp_remove_script_version' );

		$html = '<p><input type="checkbox" id="ccp_remove_script_version" name="ccp_remove_script_version" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_remove_script_version"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Vendor section callback.
	 * 
	 * @since    1.0.0
	 */
	public function ccp_scripts_vendor_section_callback( $args ) {

		$html = sprintf( '<p>%1s</p>', esc_html__( 'Look for Fancybox options on the Media Settings page.' ) );

		echo $html;

	}

	/**
	 * Use Slick.
	 * 
	 * @since    1.0.0
	 */
	public function enqueue_slick_callback( $args ) {

		$option = get_option( 'ccp_enqueue_slick' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_slick" name="ccp_enqueue_slick" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_slick"> '  . $args[0] . '</label>';

		$html .= '<a class="dashicons dashicons-editor-help" title="More info on GitHub" href="https://github.com/kenwheeler/slick" target="_blank"><span class="screen-reader-text">' . esc_html( 'More info on GitHub', 'controlled-chaos' ) . '</span></a></p>';

		echo $html;

	}

	/**
	 * Use Tabslet.
	 * 
	 * @since    1.0.0
	 */
	public function enqueue_tabslet_callback( $args ) {

		$option = get_option( 'ccp_enqueue_tabslet' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_tabslet" name="ccp_enqueue_tabslet" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_tabslet"> '  . $args[0] . '</label>';

		$html .= '<a class="dashicons dashicons-editor-help" title="More info on GitHub" href="https://github.com/vdw/Tabslet" target="_blank"><span class="screen-reader-text">' . esc_html( 'More info on GitHub', 'controlled-chaos' ) . '</span></a></p>';

		echo $html;

	}

	/**
	 * Use Sticky-kit.
	 * 
	 * @since    1.0.0
	 */
	public function enqueue_stickykit_callback( $args ) {

		$option = get_option( 'ccp_enqueue_stickykit' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_stickykit" name="ccp_enqueue_stickykit" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_stickykit"> '  . $args[0] . '</label>';

		$html .= '<a class="dashicons dashicons-editor-help" title="More info on GitHub" href="https://github.com/leafo/sticky-kit" target="_blank"><span class="screen-reader-text">' . esc_html( 'More info on GitHub', 'controlled-chaos' ) . '</span></a></p>';

		echo $html;

	}

	/**
	 * Use Tooltipster.
	 * 
	 * @since    1.0.0
	 */
	public function enqueue_tooltipster_callback( $args ) {

		$option = get_option( 'ccp_enqueue_tooltipster' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_tooltipster" name="ccp_enqueue_tooltipster" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_tooltipster"> '  . $args[0] . '</label>';

		$html .= '<a class="dashicons dashicons-editor-help" title="More info on GitHub" href="https://github.com/iamceege/tooltipster" target="_blank"><span class="screen-reader-text">' . esc_html( 'More info on GitHub', 'controlled-chaos' ) . '</span></a></p>';

		echo $html;

	}

	/**
	 * Site Settings section.
	 * 
	 * @since    1.0.0
	 */
	public function registered_fields_activate() {

		if ( class_exists( 'ACF_Pro' ) ) {

			echo sprintf( '<p>%1s</p>', esc_html( 'The Controlled Chaos plugin registers custom fields for Advanced Custom Fields Pro that can be imported for editing. These built-in field goups must be deactivated for the imported field groups to take effect.', 'controlled-chaos' ) );

		}

	}

	public function registered_fields_page_callback( $args ) {
		
		if ( class_exists( 'ACF_Pro' ) ) {

			$html = '<p><input type="checkbox" id="ccp_acf_activate_settings_page" name="ccp_acf_activate_settings_page" value="1" ' . checked( 1, get_option( 'ccp_acf_activate_settings_page' ), false ) . '/>';
			
			$html .= '<label for="ccp_acf_activate_settings_page"> '  . $args[0] . '</label></p>';
			
			echo $html;
			
		}

	}

    /**
	 * Add ACF options page for site settings.
	 *
	 * @since    1.0.0
	 */
    public function site_settings_page() {

		if ( class_exists( 'ACF_Pro' ) || class_exists( 'acf_admin_options_page' ) ) {

			$title    = get_bloginfo( 'name' );
			$position = get_field( 'ccp_settings_link_position', 'option' );

			if ( 'top' == $position ) {
					
				$settings = apply_filters( 'controlled_chaos_site_settings_page_top', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos' ),
					'menu_title' => __( 'Site Settings', 'controlled-chaos' ),
					'menu_slug'  => 'site-settings',
					'icon_url'   => 'dashicons-admin-settings',
					'position'   => 59,
					'capability' => 'manage_options',
					'redirect'   => false
				] );
				acf_add_options_page( $settings );
				remove_menu_page( 'options-general.php' );

			} else {

				$settings = apply_filters( 'controlled_chaos_site_settings_page_default', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos' ),
					'menu_title' => __( 'Site Settings', 'controlled-chaos' ),
					'menu_slug'  => 'site-settings',
					'parent'     => 'options-general.php',
					'capability' => 'manage_options'
				] );
				acf_add_options_page( $settings );

			}

		} else {
			
			add_options_page(
				__( 'Site Settings', 'controlled-chaos' ),
				__( 'Site Settings', 'controlled-chaos' ),
				'manage_options',
				'controlled-chaos-settings',
				[ $this, 'settings_site_output' ]
			);

		}

	}

	/**
	 * Site Settings page output.
	 *
	 * @since    1.0.0
	 */
    public function settings_site_output() {
		
		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-site.php';

	}

}

$controlled_chaos_settings = new Controlled_Chaos_Settings;