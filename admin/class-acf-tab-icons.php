<?php
/**
 * ACF tab & accordion title icons.
 *
 * Add icons to the titles of ACF tab and accordion fields.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://wordpress.org/plugins/acf-tab-accordion-title-icons/
 *
 * @todo       Modify the icon font.
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

final class ACF_Tab_Icons {

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

		// Enqueue scripts and styles for the icon field..
		add_action( 'acf/input/admin_enqueue_scripts', [ $this, 'enqueue_scripts_styles' ], 11 );

		// Register the field settings for the accordion field.
		add_action( 'acf/render_field_settings/type=accordion', [ $this, 'icon_register_field_settings' ], 11 );

		// Register the field settings for the tab field.
		add_action( 'acf/render_field_settings/type=tab', [ $this, 'icon_register_field_settings' ], 11 );

		// Prepare the field settings for the accordion field.
		add_filter( 'acf/prepare_field/type=accordion', [ $this, 'icon_render_field' ], 11 );

		// Prepare the field settings for the tab field.
		add_filter( 'acf/prepare_field/type=tab', [ $this, 'icon_render_field' ], 11 );

	}

	/**
	 * Load the javascript and CSS files on the ACF admin pages.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object wp_scripts
	 * @global object wp_styles
	 * @return void
	 */
	public function enqueue_scripts_styles() {

		global $wp_scripts, $wp_styles;

		// Register tab icons CSS from theme folder.
		if ( file_exists( get_theme_file_path( 'assets/fonts/icons/afc-icons.css' ) ) ) {
			wp_register_style( 'acf-tab-icons', get_theme_file_uri( 'admin/assets/fonts/icons/afc-icons.css' ), [], CCP_VERSION );

		// Register tab icons CSS from plugin folder.
		} else {
			wp_register_style( 'acf-tab-icons', CCP_URL . 'admin/assets/fonts/icons/afc-icons.css', [], CCP_VERSION );
		}

		// Enqueue styles & scripts.
		wp_enqueue_style( 'acf-tab-icons' );

	}

	/**
	 * Register the tab icon field settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $field
	 * @return void
	 */
	public function icon_register_field_settings( $field ) {

		if ( file_exists( get_theme_file_path() . '/acf-title-icons/selection.json' ) ) {
			$json_file = file_get_contents( get_theme_file_uri( '/acf-title-icons/selection.json' ) );
		} else {
			$json_file = file_get_contents( CCP_URL . 'admin/assets/fonts/icons/selection.json' );
		}

		$json_content = json_decode( $json_file, true );

		if ( ! isset( $json_content['icons'] ) ) {

			acf_render_field_setting( $field, [
				'label'			=> __( 'Icon', 'controlled-chaos-plugin' ),
				'instructions'	=> '',
				'type'			=> 'message',
				'message'		=> __( 'No icons found', 'controlled-chaos-plugin' ),
				'new_lines'		=> ''
			] );

			return;

		}

		$prefix   = $json_content['preferences']['fontPref']['prefix'];
		$iconname = $json_content['preferences']['fontPref']['metadata']['fontFamily'];
		$icons    = [];

		foreach ( $json_content['icons'] as $icon ) {

			$class = $icon['properties']['name'];
			$name  = implode( ' ', $icon['icon']['tags'] );
			$icons[$iconname . '-' . $class] = esc_html( '<span class="acf-icon-title"><i class="' . $iconname . ' ' . $prefix . $class . '"></i>' . $name . '</span>' );

		}

		// Select the icon for the tab.
		acf_render_field_setting( $field, [
			'label'			=> __( 'Icon', 'controlled-chaos-plugin' ),
			'instructions'	=> __( 'Select an icon you want to show before the tab text.', 'controlled-chaos-plugin' ),
			'type'			=> 'select',
			'id'			=> $field['ID'] . 'accordion-select',
			'name'			=> 'icon_class',
			'choices'		=> $icons,
			'allow_null'	=> 1,
			'multiple'		=> 0,
			'ui'			=> 1,
			'ajax'			=> 0,
		] );

		// Option to show only the icon, not text.
		acf_render_field_setting( $field, [
			'label'			=> __( 'Show icon only', 'controlled-chaos-plugin'),
			'instructions'	=> __( 'If set to <em>Yes</em>, you will see only the icon and no text.', 'controlled-chaos-plugin'),
			'name'			=> 'show_icon_only',
			'type'			=> 'true_false',
			'ui'			=> 1,
		] );
	}

	/**
	 * Render the tab icon field settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $field
	 * @return void
	 */
	public function icon_render_field( $field ) {

		if ( array_key_exists( 'icon_class', $field ) && ! $field['icon_class'] == '' ) {

			if ( array_key_exists( 'show_icon_only', $field ) && $field['show_icon_only'] == 1 ) {
				$field['label'] = '<span class="acf-title-icon ' . esc_attr( $field['icon_class'] ) . '"></span>';
			} else {
				$field['label'] = '<span class="acf-title-icon ' . esc_attr( $field['icon_class'] ) . '"></span><span class="acf-title-text">' . esc_attr( $field["label"] ) . '</span>';
			}

			$field['wrapper']['class'] .= ' acf-title-with-icon';

		}

		return $field;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_acf_icons() {

	return ACF_Tab_Icons::instance();

}

// Run an instance of the class.
ccp_acf_icons();