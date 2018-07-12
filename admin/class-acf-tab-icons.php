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

		// Include the field.
		add_action( 'acf/input/admin_enqueue_scripts', [ $this, 'acf_title_icon_admin_enqueue_scripts' ], 11 );

		add_action( 'acf/render_field_settings/type=accordion', [ $this, 'dhz_title_icon_render_field_settings' ], 11 );
		add_action( 'acf/render_field_settings/type=tab', [ $this, 'dhz_title_icon_render_field_settings' ], 11 );

		add_filter( 'acf/prepare_field/type=accordion', [ $this, 'dhz_acf_title_icon_prepare_field' ], 11 );
		add_filter( 'acf/prepare_field/type=tab', [ $this, 'dhz_acf_title_icon_prepare_field' ], 11 );

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
	public function acf_title_icon_admin_enqueue_scripts() {

		global $wp_scripts, $wp_styles;

		// Register ACF Title Icons CSS from theme folder.
		if ( file_exists( get_theme_file_path() . '/acf-title-icons/style.css' ) ) {
			wp_register_style( 'acf-title-icons', get_theme_file_uri() . '/acf-title-icons/style.css', [], CCP_VERSION );

		// Register ACF Title Icons CSS from plugin folder.
		} else {
			wp_register_style( 'acf-title-icons', plugin_dir_url( __FILE__ ) . 'assets/images/icons/style.css', [], CCP_VERSION );
		}

		// Enqueue styles & scripts.
		wp_enqueue_style( 'acf-title-icons' );

	}

	/**
	 * Undocumented function
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $field
	 * @return void
	 */
	public function dhz_title_icon_render_field_settings( $field ) {

		if ( file_exists( get_theme_file_path() . '/acf-title-icons/selection.json' ) ) {
			$json_file = file_get_contents( get_theme_file_uri( '/acf-title-icons/selection.json' ) );
		} else {
			$json_file = file_get_contents( plugin_dir_url( __FILE__ ) . 'assets/images/icons/selection.json' );
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

		// icon select
		acf_render_field_setting( $field, [
			'label'			=> __( 'Icon', 'controlled-chaos-plugin' ),
			'instructions'	=> __( 'Select an icon you want to show before the title.', 'controlled-chaos-plugin' ),
			'type'			=> 'select',
			'id'			=> $field['ID'] . 'accordion-select',
			'name'			=> 'icon_class',
			'choices'		=> $icons,
			'allow_null'	=> 1,
			'multiple'		=> 0,
			'ui'			=> 1,
			'ajax'			=> 0,
		] );

		// icon only
		acf_render_field_setting( $field, [
			'label'			=> __( 'Show icon only', 'controlled-chaos-plugin'),
			'instructions'	=> __( 'If set to <em>Yes</em>, you will see only the icon and no title.', 'controlled-chaos-plugin'),
			'name'			=> 'show_icon_only',
			'type'			=> 'true_false',
			'ui'			=> 1,
		] );
	}

	/**
	 * Undocumented function
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $field
	 * @return void
	 */
	public function dhz_acf_title_icon_prepare_field( $field ) {

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