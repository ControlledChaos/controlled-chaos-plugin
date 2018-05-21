<?php

/**
 * The file that defines the core plugin class.
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

/**
 * Define the core functionality of the plugin.
 *
 * @since      1.0.0
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Plugin {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
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

		// Admin actions and filters.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-admin.php';

		// Public actions and filters.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-public.php';

		// Post types and taxonomies.
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/post-types-taxes/class-post-type-tax.php';

		// Minify HTML source code.
		$minify = get_option( 'ccp_html_minify' );

		if ( $minify ) {
			require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-minify-process.php';
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

		$size = apply_filters( 'ccp_rss_featured_image_size', 'medium' );

		if ( has_post_thumbnail( $post->ID ) ) {
			$content = sprintf( '<div>%1s</div><div>%2s</div>', get_the_post_thumbnail( $post->ID, $size, [] ), $content );
		}

		return $content;
	}

}

// Run the core plugin class.
$ccp_run = new Controlled_Chaos_Plugin();