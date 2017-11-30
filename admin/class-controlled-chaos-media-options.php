<?php
/**
 * Media options.
 *
 * @package WordPress
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
	 * @param      string    $controlled-chaos
	 * @param      string    $version
	 */
    public function __construct() {

        // Media settings.
		add_action( 'admin_init', [ $this, 'settings' ] );

    }

    /**
	 * Media settings.
	 * 
	 * @since    1.0.2
	 */
	public function settings() {

        add_settings_section( 'ccp-media-settings', __( 'Fancybox', 'controlled-chaos' ), [], 'media' );

        add_settings_field( 'ccp_enqueue_fancybox', __( 'Enqueue Fancybox', 'controlled-chaos' ), [ $this, 'fancybox' ], 'media', 'ccp-media-settings', [ __( 'Add modal windows to image links.', 'controlled-chaos' ) ] );

        register_setting(
            'media',
            'ccp_enqueue_fancybox' 
        );

    }

    public function fancybox( $args ) {

        $html = '<p><input type="checkbox" id="ccp_enqueue_fancybox" name="ccp_enqueue_fancybox" value="1" ' . checked( 1, get_option( 'ccp_enqueue_fancybox' ), false ) . '/>';
        
        // Here, we will take the first argument of the array and add it to a label next to the checkbox
        $html .= '<label for="ccp_enqueue_fancybox"> '  . $args[0] . '</label></p>';

        echo $html;

    }

}

$controlled_chaos_media_options = new Controlled_Chaos_Media_Options;