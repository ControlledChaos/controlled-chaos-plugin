<?php
/**
 * Media functionality.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Media
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Includes\Media;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Media functionality.
 *
 * @since  1.0.0
 * @access public
 */
class Media {

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

			// Get class dependencies
			$instance->dependencies();

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

		// Add categories and tags to media library items.
		add_action( 'init' , [ $this, 'media_taxonomies' ] );

		// Add image sizes.
		add_action( 'init', [ $this, 'image_sizes' ] );

		// Add image sizes to insert media UI.
		add_filter( 'image_size_names_choose', [ $this, 'insert_custom_image_sizes' ] );

		// Add Fancybox data attributes to image links in the content.
		add_filter( 'the_content', [ $this, 'fancybox_single_images' ], 2 );

		// Default add single image link.
        add_action( 'admin_init', [ $this, 'image_link' ], 10 );

        // Default add gallery images link.
        add_filter( 'media_view_settings', [ $this, 'gallery_link' ], 10 );

		// Add featured images to RSS feeds.
		add_filter( 'the_excerpt_rss', [ $this, 'rss_featured_images' ] );
		add_filter( 'the_content_feed', [ $this, 'rss_featured_images' ] );

	}

	/**
	 * Get class dependencies
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Add SVG media upload support.
		include_once CCP_PATH . 'includes/media/class-svg-support.php';

		// Replace WP gallery shortcode if Fancybox option is used.
		$fancybox = get_option( 'ccp_enqueue_fancybox_script' );

		if ( $fancybox ) {
			require_once CCP_PATH . 'includes/media/class-gallery-shortcode.php';
		}

	}

	/**
	 * Add taxonomies to media library
	 *
	 * Includes categories and tags for attachment post type.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function media_taxonomies() {

		// Add standard categories.
		register_taxonomy_for_object_type( 'category', 'attachment' );

		// Add standard tags.
		register_taxonomy_for_object_type( 'post_tag', 'attachment' );

	}

	/**
	 * Add image sizes.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function image_sizes() {

		// For link embedding and sharing on social sites.
		add_image_size( __( 'meta-image', 'controlled-chaos-plugin' ), 1200, 630, true );

		/**
		 * For use as featured image in admin columns.
		 *
		 * @see admin/class-admin-pages.php
		 */
		add_image_size( __( 'column-thumbnail', 'controlled-chaos-plugin' ), 48, 48, true );

	}

	/**
	 * Add image sizes to media UI
	 *
	 * Adds custom image sizes to "Insert Media" user interface
	 * and adds custom class to the `<img>` tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $sizes Gets the array of image size names.
	 * @global array $_wp_additional_image_sizes Gets the array of custom image size names.
	 * @return array $sizes Returns an array of image size names.
	 */
	function insert_custom_image_sizes( $sizes ) {

		// Access global variables.
		global $_wp_additional_image_sizes;

		// Return default sizes if no custom sizes.
		if ( empty( $_wp_additional_image_sizes ) ) {
			return $sizes;
		}

		// Capitalize custom image size names and remove hyphens.
		foreach ( $_wp_additional_image_sizes as $id => $data ) {

			if ( ! isset( $sizes[$id] ) ) {
				$sizes[$id] = ucwords( str_replace( '-', ' ', $id ) );
			}
		}

		// Return the modified array of sizes.
		return $sizes;

	}

	/**
	 * Add Fancybox data attributes to image links in the content.
	 *
	 * Note: As of this comment on June 22, 2018 this function only works with
	 * images in the classic editor, not with the new block editor images.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param string $content
	 * @return string
	 *
	 * @todo Review this after WordPress 5.0 is released or if/when the new block
	 *       editor adds the option to link to the full size image.
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

	/**
     * Default link when adding an image.
	 *
	 * Note: As of this comment on June 21, 2018 the `image_default_link_type`
	 * option only works with the classic editor, not with the new block editor.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
	 *
	 * @todo Review this after WordPress 5.0 is released or if/when the new block
	 *       editor adds the option to link to the full size image.
     */
    public function image_link() {

        $image_set = get_option( 'image_default_link_type' );

        if ( $image_set !== 'file' ) { // Could be 'none'
            update_option( 'image_default_link_type', 'file' );
        }

    }

    /**
     * Default gallery images link.
	 *
	 * Note: As of this comment on June 21, 2018 this function only works with
	 * galleries in the classic editor, not with the new block editor galleries.
     *
     * @since  1.0.0
	 * @access public
	 * @return mixed[] Modifies the WordPress gallery shortcode.
	 *
	 * @todo Review this after WordPress 5.0 is released or if/when the new block
	 *       editor adds the option to link to the full size images.
     */
    public function gallery_link( $settings ) {

        $settings['galleryDefaults']['link'] = 'file';

        return $settings;
    }

	/**
	 * Add featured images to RSS feeds.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object post The post object for the current post.
	 * @param  string $content Gets the current post content.
	 * @return string $content Returns the filered current post content.
	 */
	public function rss_featured_images( $content ) {

		// Get the post object.
		global $post;

		// Apply a filter for conditional image sizes.
		$size = apply_filters( 'ccp_rss_featured_image_size', 'medium' );

		/**
		 * Use this layout only if the post has a featured image.
		 *
		 * The image and the content/excerpt are in separate <div> tags
		 * to get the content below the image.
		 */
		if ( has_post_thumbnail( $post->ID ) ) {
			$content = sprintf( '<div>%1s</div><div>%2s</div>', get_the_post_thumbnail( $post->ID, $size, [] ), $content );
		}

		// Return the filered post content.
		return $content;
	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_media() {

	return Media::instance();

}

// Run an instance of the class.
ccp_media();