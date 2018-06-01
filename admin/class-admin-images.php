<?php

/**
 * Admin image functions.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 */

namespace CCPlugin\Admin_Images;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Admin image functions.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Admin_Images {

    /**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        // Default add single image link.
        add_action( 'admin_init', [ $this, 'image_link' ], 10 );

        // Default add gallery images link.
        add_filter( 'media_view_settings', [ $this, 'gallery_link' ], 10 );

		// Add SVG support.
		$add_svg = get_option( 'ccp_add_svg_support' );
		if ( $add_svg ) {
			add_action( 'admin_init', [ $this, 'svg_support' ] );
			add_filter( 'wp_check_filetype_and_ext', [ $this, 'svg_filetype' ], 100, 4 );
			add_filter( 'wp_get_attachment_image_src', [ $this, 'image_src' ], 90 );
		}

    }

    /**
     * Default add single image link.
     *
     * @since    1.0.0
     */
    public function image_link() {

        $image_set = get_option( 'image_default_link_type' );

        if ( $image_set !== 'file' ) { // Could be 'none'
            update_option( 'image_default_link_type', 'file' );
        }

    }

    /**
     * Default add gallery images link.
     *
     * @since    1.0.0
     */
    public function gallery_link( $settings ) {

        $settings['galleryDefaults']['link'] = 'file';

        return $settings;
    }

    /**
     * Add SVG image support.
     */
    public function image_src( $image ) {

		$extension = explode( '.', $image[0] );
		$extension = array_pop( $extension );

		if ( $extension == 'svg' ) {
			$xml  = simplexml_load_file( $image[0] );
			$attr = $xml->attributes();

			if ( ! isset( $attr->width ) || ! isset( $attr->height ) ) {
				$sizes = explode( ' ', $attr->viewBox );
				$attr->width  = $sizes[2];
				$attr->height = $sizes[3];
			}

			$image[1] = $attr->width;
			$image[2] = $attr->height;
		}

		return $image;
	}

	public function svg_filetype( $filetype_ext_data, $file, $filename, $mimes ) {

		if ( substr( $filename, -4 ) === '.svg' ) {
			$filetype_ext_data['ext']  = 'svg';
			$filetype_ext_data['type'] = 'image/svg+xml';
		}

		return $filetype_ext_data;

	}

	public function svg_support() {

		ob_start();
		add_action( 'admin_head', [ $this, 'svg_css_fix' ] );
		add_filter( 'upload_mimes', [ $this, 'svg_mime' ] );
		add_action( 'shutdown', [ $this, 'on_shutdown' ], 0 );
		add_filter( 'final_output', [ $this, 'fix_template' ] );

	}

	public function svg_css_fix() {

		echo '<style>img[src$=".svg"]{width:90%;height:auto;}</style>';

	}

	public function svg_mime( $mimes = [] ) {

		$user    = wp_get_current_user();
		$allowed = [ 'administrator' ];

		if ( array_intersect( $allowed, $user->roles ) ) {
			$mimes['svg']  = 'image/svg+xml';
			$mimes['svgz'] = 'image/svg+xml';

			return $mimes;
		}

		return $mimes;

	}

	public function on_shutdown() {

		$final     = '';
		$ob_levels = count( ob_get_level() );

		for ( $i = 0; $i < $ob_levels; $i++ ) {
			$final .= ob_get_clean();
		}

		echo apply_filters( 'final_output', $final );

	}

	public function fix_template( $content = '' ) {

		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
				<img class="details-image" src="{{ data.url }}" draggable="false" />
			<# } else if ( \'image\' === data.type && data.sizes && data.sizes.full ) { #>',
			$content
		);

		$content = str_replace(
			'<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			'<# } else if ( \'svg+xml\' === data.subtype ) { #>
				<div class="centered">
					<img src="{{ data.url }}" class="thumbnail" draggable="false" />
				</div>
			<# } else if ( \'image\' === data.type && data.sizes ) { #>',
			$content
		);
		return $content;

	}

}

$controlled_chaos_admin_images = new Controlled_Chaos_Admin_Images;