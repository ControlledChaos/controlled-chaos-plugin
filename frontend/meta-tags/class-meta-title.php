<?php
/**
 * Title meta tag.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Frontend\Meta_Tags
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Frontend\Meta_Tags;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Title meta tag.
 *
 * @since  1.0.0
 * @access public
 */
class Meta_Title {

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
	 * Constructor magic method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// Add the title to meta tag.
		add_action( 'ccp_meta_title_tag', [ $this, 'title' ] );

	}

	/**
	 * Conditionally get the title to use in meta tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object post The post object for the current post.
	 * @return string
	 */
	public function title() {

		// Get the current posts for author archives.
		global $post;

		// Get the author ID.
		if ( is_404() ) {
			$author_id = '';
		} else {
			$author_id = $post->post_author;
		}

		// Custom author title.
		$author_title = sprintf(
			'%1s %2s',
			__( 'Posts by', 'controlled-chaos-plugin' ),
			get_the_author_meta( 'display_name', $author_id )
		);

		// Apply a filter to author archive title.
		$author_meta = apply_filters( 'ccp_author_meta_title', $author_title );

		// Custom search title.
		$search_title = sprintf(
			'%1s %2s',
			__( 'Searching', 'controlled-chaos-plugin' ),
			get_bloginfo( 'name' )
		);

		// Apply a filter to search title.
		$search_meta = apply_filters( 'ccp_search_meta_title', $search_title );

		// Use the website name on the front page and 404 error page.
		if ( is_front_page() || is_404() ) {
			$title = esc_html( get_bloginfo( 'name' ) );

		// Use the Posts Page title for the blog index.
		} elseif ( is_home() ) {
			$title = esc_html( get_the_title( get_option( 'page_for_posts' ) ) );

		// Use custom text for author pages.
		} elseif ( is_author() ) {
			$title = esc_html( $author_meta );

		// Use the acrhive title for the acrhive pages.
		} elseif ( is_archive() ) {
			$title = esc_html( the_archive_title() );

		// Use custom text for search pages.
		} elseif ( is_search() ) {
			$title = esc_html( $search_meta );

		// For all else, singular, use the post title.
		} else {
			$title = esc_html( get_the_title() );
		}

		// Echo the conditional title in the meta tag.
		echo esc_attr( esc_html( $title ) );

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_meta_title() {

	return Meta_Title::instance();

}

// Run an instance of the class.
ccp_meta_title();