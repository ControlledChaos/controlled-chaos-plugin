<?php
/**
 * Media options.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Media_Options;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Media options.
 */
class Controlled_Chaos_Media_Options {

    /**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        // Media settings.
        add_action( 'admin_init', [ $this, 'settings' ] );
        
        // Hard crop default image sizes.
        add_action( 'after_setup_theme', [ $this, 'crop' ] );

    }

    /**
	 * Media settings.
	 * 
	 * @since    1.0.0
	 */
	public function settings() {

        /**
         * Image crop settings.
         */
        add_settings_field( 'ccp_hard_crop_medium', __( 'Medium size crop', 'controlled-chaos-plugin' ), [ $this, 'medium_crop' ], 'media', 'default', [ __( 'Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'controlled-chaos-plugin' ) ] );

        add_settings_field( 'ccp_hard_crop_large', __( 'Large size crop', 'controlled-chaos-plugin' ), [ $this, 'large_crop' ], 'media', 'default', [ __( 'Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'controlled-chaos-plugin' ) ] );

        register_setting(
            'media',
            'ccp_hard_crop_medium'
        );

        register_setting(
            'media',
            'ccp_hard_crop_large'
        );

        /**
         * SVG options.
         */
        add_settings_section( 'ccp-svg-settings', __( 'SVG Images', 'controlled-chaos-plugin' ), [ $this, 'svg_notice' ], 'media' );

        add_settings_field( 'ccp_add_svg_support', __( 'SVG Support', 'controlled-chaos-plugin' ), [ $this, 'svg_support' ], 'media', 'ccp-svg-settings', [ __( 'Add ability to upload SVG images to the media library.', 'controlled-chaos-plugin' ) ] );

        register_setting(
            'media',
            'ccp_add_svg_support'
        );

        /**
         * Fancybox settings.
         */
        add_settings_section( 'ccp-media-settings', __( 'Fancybox', 'controlled-chaos-plugin' ), [ $this, 'fancybox_description' ], 'media' );

        add_settings_field( 'ccp_enqueue_fancybox_script', __( 'Enqueue Fancybox script', 'controlled-chaos-plugin' ), [ $this, 'fancybox_script' ], 'media', 'ccp-media-settings', [ __( 'Needed for lightbox functionality.', 'controlled-chaos-plugin' ) ] );
        
        if ( ! current_theme_supports( 'ccd-fancybox' ) ) {
            add_settings_field( 'ccp_enqueue_fancybox_styles', __( 'Enqueue Fancybox styles', 'controlled-chaos-plugin' ), [ $this, 'fancybox_styles' ], 'media', 'ccp-media-settings', [ __( 'Leave unchecked to use a custom stylesheet in a theme.', 'controlled-chaos-plugin' ) ] );
        }

        register_setting(
            'media',
            'ccp_enqueue_fancybox_script'
        );

        if ( ! current_theme_supports( 'ccd-fancybox' ) ) {
            register_setting(
                'media',
                'ccp_enqueue_fancybox_styles'
            );
        }
        
    }

    /**
     * Medium crop field.
     * 
     * @since    1.0.0
     */
    public function medium_crop( $args ) {

        $html = '<p><input type="checkbox" id="ccp_hard_crop_medium" name="ccp_hard_crop_medium" value="1" ' . checked( 1, get_option( 'ccp_hard_crop_medium' ), false ) . '/>';
        
        $html .= '<label for="ccp_hard_crop_medium"> '  . $args[0] . '</label></p>';

        echo $html;

    }

    /**
     * Large crop field.
     * 
     * @since    1.0.0
     */
    public function large_crop( $args ) {

        $html = '<p><input type="checkbox" id="ccp_hard_crop_large" name="ccp_hard_crop_large" value="1" ' . checked( 1, get_option( 'ccp_hard_crop_large' ), false ) . '/>';
        
        $html .= '<label for="ccp_hard_crop_large"> '  . $args[0] . '</label></p>';

        echo $html;
        
    }

    /**
     * Update crop options.
     * 
     * @since    1.0.0
     */
    public function crop() {

        if ( get_option( 'ccp_hard_crop_medium' ) ) {
            update_option( 'medium_crop', 1 );
        } else {
            update_option( 'medium_crop', 0 );
        }

        if ( get_option( 'ccp_hard_crop_large' ) ) {
            update_option( 'large_crop', 1 );
        } else {
            update_option( 'large_crop', 0 );
        }

    }

    /**
     * Add warning about using SVG images.
     */
    public function svg_notice() {

        $html = sprintf( '<p>%1s</p>', esc_html__( 'Use SVG images with caution! Only add support if you trust or examine each SVG file that you upload.', 'controlled-chaos-plugin' ) );

        echo $html;

    }

    /**
     * SVG options.
     * 
     * @since    1.0.0
     */
    public function svg_support( $args ) {

        $html = '<p><input type="checkbox" id="ccp_add_svg_support" name="ccp_add_svg_support" value="1" ' . checked( 1, get_option( 'ccp_add_svg_support' ), false ) . '/>';
        
        $html .= '<label for="ccp_add_svg_support"> '  . $args[0] . '</label></p>';

        echo $html;

    }

    /**
     * Fancybox settings description.
     */
    public function fancybox_description() {

        $url  = 'http://fancyapps.com/fancybox/3/';
        $html = sprintf( '<p>%1s <a href="%2s" target="_blank">%3s</a></p>', esc_html__( 'Documentation on the Fancybox website:', 'controlled-chaos-plugin' ), esc_url( $url ), $url );

        echo $html;

    }

    /**
     * Fancybox script field.
     * 
     * @since    1.0.0
     */
    public function fancybox_script( $args ) {

        $html = '<p><input type="checkbox" id="ccp_enqueue_fancybox_script" name="ccp_enqueue_fancybox_script" value="1" ' . checked( 1, get_option( 'ccp_enqueue_fancybox_script' ), false ) . '/>';
        
        $html .= '<label for="ccp_enqueue_fancybox_script"> '  . $args[0] . '</label></p>';

        echo $html;

    }

    /**
     * Fancybox styles field.
     * 
     * @since    1.0.0
     */
    public function fancybox_styles( $args ) {

        $html = '<p><input type="checkbox" id="ccp_enqueue_fancybox_styles" name="ccp_enqueue_fancybox_styles" value="1" ' . checked( 1, get_option( 'ccp_enqueue_fancybox_styles' ), false ) . '/>';
        
        $html .= '<label for="ccp_enqueue_fancybox_styles"> '  . $args[0] . '</label></p>';

        echo $html;

    }

}

$controlled_chaos_media_options = new Controlled_Chaos_Media_Options;