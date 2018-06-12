<?php

/**
 * The core plugin class.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */

namespace CCPlugin\Includes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the core functionality of the plugin.
 *
 * @since      1.0.0
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */
class Controlled_Chaos_Plugin {

	/**
	 * Initialize the class.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {

		// Load dependencies.
		$this->dependencies();

		// Remove the capital P filter.
		remove_filter( 'the_title', 'capital_P_dangit', 11 );
		remove_filter( 'the_content', 'capital_P_dangit', 11 );
		remove_filter( 'comment_text', 'capital_P_dangit', 31 );

		// Add featured images to RSS feeds.
		add_filter( 'the_excerpt_rss', [ $this, 'rss_featured_images' ] );
		add_filter( 'the_content_feed', [ $this, 'rss_featured_images' ] );

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function dependencies() {

		// Translation functionality.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-i18n.php';

		// Admin/backend functionality, scripts and styles.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		// Public/frontend functionality, scripts and styles.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-public.php';

		/**
		 * Register custom editor blocks.
		 * 
		 * Remove conditional statement when Gutenberg is in core?
		 */
		if ( is_plugin_active( 'gutenberg/gutenberg.php' ) ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/editor-blocks/class-register-block-types.php';
		}

		// Post types and taxonomies.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/post-types-taxes/class-post-type-tax.php';

		// User avatars.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/users/class-user-avatars.php';

		// Minify HTML source code.
		$minify = get_option( 'ccp_html_minify' );

		if ( $minify ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-minify-process.php';
		}

		// Include the RTL (right to left) test if option selected.
		$rtl = get_option( 'ccp_rtl_test' );

		if ( $rtl ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-rtl-test.php';
		}

	}

	/**
	 * Add featured images to RSS feeds.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function rss_featured_images( $content ) {

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

		return $content;
	}

}

// Run the core plugin class.
$ccp_run = new Controlled_Chaos_Plugin();