<?php

/**
 * Frontend image functions.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/public
 */

namespace Controlled_Chaos_Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Frontend image functions.
 */
class Controlled_Chaos_Public_Images {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Add image sizes.
		add_action( 'init', [ $this, 'image_sizes' ] );

		// Add Fancybox data attributes to image links in the content.
		add_filter( 'the_content', [ $this, 'fancybox_single_images' ], 2 );

	}

	/**
	 * Add image sizes.
	 * 
	 * @since    1.0.3
	 */
	public function image_sizes() {

		// For link embedding and sharing on social sites.
		add_image_size( __( 'Meta Image', 'controlled-chaos' ), 1200, 630, true );

	}

	/**
	 * Add Fancybox data attributes to image links in the content.
	 * 
	 * @since    1.0.1
	 */
	public function fancybox_single_images( $content ) {

			// Check the page for link images direct to image (no trailing attributes).
			$string = '/<a href="(.*?).(jpg|jpeg|png|gif|bmp|ico)"><img(.*?)class="(.*?)wp-image-(.*?)" \/><\/a>/i';
			preg_match_all( $string, $content, $matches, PREG_SET_ORDER );

			if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {

				// Check which attachment is referenced.
				foreach ( $matches as $val ) {

					$slimbox_caption = '';

					$post            = get_post( $val[5] );
					$slimbox_caption = esc_attr( $post->post_content );

					// Replace the instance with the lightbox and title(caption) references. Won't fail if caption is empty.
					$string  = '<a href="' . $val[1] . '.' . $val[2] . '"><img' . $val[3] . 'class="' . $val[4] . 'wp-image-' . $val[5] . '" /></a>';
					$replace = '<a href="' . $val[1] . '.' . $val[2] . '" data-fancybox data-type="image" title="' . $slimbox_caption . '"><img' . $val[3] . 'class="' . $val[4] . 'wp-image-' . $val[5] . '" /></a>';
					
					$fancy_content = str_replace( $string, $replace, $content );

					return $fancy_content;

				}

			}

			return $content;
		
	}

}

$controlled_chaos_public_images = new Controlled_Chaos_Public_Images;