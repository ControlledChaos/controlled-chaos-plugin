<?php
/**
 * SVG image upload support.
 *
 * The funtionality is taken from the SVG Support plugin.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Media
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://wordpress.org/plugins/svg-support/
 */

namespace CC_Plugin\Includes\Media;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * SVG image upload support.
 *
 * @since  1.0.0
 * @access public
 */
class SVG_Support {

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
	 * @global string wp_version Check for the installed version of WordPress.
	 * @return self
	 */
	public function __construct() {

		global $wp_version;

		// Add SVG upload support if option selected.
		$add_svg = get_option( 'ccp_add_svg_support' );
		if ( $add_svg ) {
			add_action( 'admin_init', [ $this, 'svg_support' ] );
			add_filter( 'wp_check_filetype_and_ext', [ $this, 'svg_filetype' ], 100, 4 );
			add_filter( 'wp_get_attachment_image_src', [ $this, 'image_src' ], 90 );

			if ( $wp_version == '4.7.1' || $wp_version == '4.7.2' ) {
				add_filter( 'wp_check_filetype_and_ext', [ $this, 'svgs_disable_real_mime_check' ], 10, 4 );
			}
		}

	}

	/**
     * Add SVG image upload support to the media library.
	 *
	 * The option to add SVG support is in Setting > Media.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $image
	 * @return object
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

	/**
     * Add SVG image upload support to the media library.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param object $filetype_ext_data
	 * @param object $file
	 * @param string $filename
	 * @param object $mimes
	 * @return mixed[]
     */
	public function svg_filetype( $filetype_ext_data, $file, $filename, $mimes ) {

		if ( substr( $filename, -4 ) === '.svg' ) {
			$filetype_ext_data['ext']  = 'svg';
			$filetype_ext_data['type'] = 'image/svg+xml';
		}

		return $filetype_ext_data;

	}

	/**
	 * Begin SVG support upon upload activation.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function svg_support() {

		ob_start();
		add_action( 'admin_head', [ $this, 'svg_css_fix' ] );
		add_filter( 'upload_mimes', [ $this, 'svg_mime' ] );
		add_action( 'shutdown', [ $this, 'on_shutdown' ], 0 );
		add_filter( 'final_output', [ $this, 'fix_template' ] );

	}

	/**
	 * Adjust the image preview.
	 *
	 * Targets SVG image thumbnails in the media library.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function svg_css_fix() {

		echo '<style>img[src$=".svg"]{width:90%;height:auto;}</style>';

	}

	/**
	 * Add SVG file types to the accepted library file types.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param array $mimes Default file types.
	 * @return array SVG file types.
	 */
	public function svg_mime( $mimes = [] ) {

		if ( current_user_can( 'administrator' ) ) {

			$mimes['svg'] = 'image/svg+xml';
			$mimes['svgz'] = 'image/svg+xml';

			return $mimes;

		} else {

			return $mimes;

		}

	}

	/**
	 * Output the SVG image instance after upload.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed
	 */
	public function on_shutdown() {

		$final     = '';
		$ob_levels = count( ob_get_level() );

		for ( $i = 0; $i < $ob_levels; $i++ ) {
			$final .= ob_get_clean();
		}

		echo apply_filters( 'final_output', $final );

	}

	/**
	 * Undocumented function
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $content
	 * @return string
	 */
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

	/**
	 * Mime Check fix for WP 4.7.1 / 4.7.2
	 *
	 * Fixes uploads for these 2 version of WordPress.
	 * Issue was fixed in 4.7.3 core.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $content
	 * @return mixed
	 */
	public function svgs_disable_real_mime_check( $data, $file, $filename, $mimes ) {

			$wp_filetype = wp_check_filetype( $filename, $mimes );

			$ext = $wp_filetype['ext'];
			$type = $wp_filetype['type'];
			$proper_filename = $data['proper_filename'];

			return compact( 'ext', 'type', 'proper_filename' );

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function svg_support() {

	return SVG_Support::instance();

}

// Run an instance of the class.
svg_support();