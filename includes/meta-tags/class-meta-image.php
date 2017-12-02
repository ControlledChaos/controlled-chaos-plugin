<?php
/**
 * Image meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.4
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Controlled_Chaos_Meta_Image {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_image', [ $this, 'image' ] );

	}

	/**
	 * Image meta tag.
	 * 
	 * @since controlled-chaos 1.0.4
	 */
	public function image() {

		global $post;

        if ( ! is_404() ) {
            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'Meta Image', [ 1200, 630 ], true, '' );
        }
        if ( has_post_thumbnail() ) {
            $src = $image[0];
        } else {
            $src = get_template_directory_uri() . '/assets/images/default-meta-image.jpg';
        }

        echo $src;
		
	}

}

// Run the Controlled_Chaos_Meta_Image class.
$ccp_meta_image = new Controlled_Chaos_Meta_Image;