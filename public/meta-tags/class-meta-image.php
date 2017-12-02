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

		if ( class_exists( 'ACF_Pro' ) ) {

			$blog_image = get_field( 'ccp_meta_blog_image', 'option' );

			if ( $blog_image && is_home() ) {
				$url  = $blog_image['url'];
				$size = 'Meta Image';
				$src  = $blog_image['sizes'][ $size ];
			} elseif ( ! is_404() ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'Meta Image', [ 1200, 630 ], true, '' );
				$src   = $image[0];
			} else {
				$src = '';
			}

			echo $src;

		} else {

			if ( ! is_404() ) {
				$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'Meta Image', [ 1200, 630 ], true, '' );
			}

			if ( has_post_thumbnail() ) {
				$src = $image[0];
			} else {
				$src = '';
			}

			echo $src;

		}
		
	}

}

// Run the Controlled_Chaos_Meta_Image class.
$ccp_meta_image = new Controlled_Chaos_Meta_Image;