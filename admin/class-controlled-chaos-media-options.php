<?php
/**
 * Media options.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Media options.
 */
class Controlled_Chaos_Media_Options {

    /**
	 * Initialize the class and set its properties.
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
	 * @since    1.0.2
	 */
	public function settings() {

        /**
         * Image crop settings.
         */
        add_settings_field( 'ccp_hard_crop_medium', __( 'Medium size crop', 'controlled-chaos' ), [ $this, 'medium_crop' ], 'media', 'default', [ __( 'Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'controlled-chaos' ) ] );

        add_settings_field( 'ccp_hard_crop_large', __( 'Large size crop', 'controlled-chaos' ), [ $this, 'large_crop' ], 'media', 'default', [ __( 'Crop thumbnail to exact dimensions (normally thumbnails are proportional)', 'controlled-chaos' ) ] );

        register_setting(
            'media',
            'ccp_hard_crop_medium'
        );

        register_setting(
            'media',
            'ccp_hard_crop_large'
        );

        /**
         * Fancybox settings.
         */
        add_settings_section( 'ccp-media-settings', __( 'Fancybox', 'controlled-chaos' ), [], 'media' );

        add_settings_field( 'ccp_enqueue_fancybox', __( 'Enqueue Fancybox', 'controlled-chaos' ), [ $this, 'fancybox' ], 'media', 'ccp-media-settings', [ __( 'Add modal windows to image links.', 'controlled-chaos' ) ] );

        register_setting(
            'media',
            'ccp_enqueue_fancybox'
        );

    }

    /**
     * Medium crop field.
     * 
     * @since    1.0.2
     */
    public function medium_crop( $args ) {

        $html = '<p><input type="checkbox" id="ccp_hard_crop_medium" name="ccp_hard_crop_medium" value="1" ' . checked( 1, get_option( 'ccp_hard_crop_medium' ), false ) . '/>';
        
        $html .= '<label for="ccp_hard_crop_medium"> '  . $args[0] . '</label></p>';

        echo $html;

    }

    /**
     * Large crop field.
     * 
     * @since    1.0.2
     */
    public function large_crop( $args ) {

        $html = '<p><input type="checkbox" id="ccp_hard_crop_large" name="ccp_hard_crop_large" value="1" ' . checked( 1, get_option( 'ccp_hard_crop_large' ), false ) . '/>';
        
        $html .= '<label for="ccp_hard_crop_large"> '  . $args[0] . '</label></p>';

        echo $html;
        
    }

    /**
     * Update crop options.
     * 
     * @since    1.0.2
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
     * Add Fancybox field.
     * 
     * @since    1.0.2
     */
    public function fancybox( $args ) {

        $html = '<p><input type="checkbox" id="ccp_enqueue_fancybox" name="ccp_enqueue_fancybox" value="1" ' . checked( 1, get_option( 'ccp_enqueue_fancybox' ), false ) . '/>';
        
        $html .= '<label for="ccp_enqueue_fancybox"> '  . $args[0] . '</label></p>';

        echo $html;

    }

}

$controlled_chaos_media_options = new Controlled_Chaos_Media_Options;