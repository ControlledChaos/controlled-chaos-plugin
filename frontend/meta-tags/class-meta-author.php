<?php
/**
 * Author meta tag.
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
 * Author meta tag.
 *
 * @since  1.0.0
 * @access public
 */
class Meta_Author {

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
	 * @return self
	 */
	public function __construct() {

		// Add author to the meta tag.
		add_action( 'ccp_meta_author_tag', [ $this, 'author' ] );

	}

	/**
	 * Author meta tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object post The post object for the current post.
	 * @return string
	 */
	public function author() {

		// Bail on error pages.
		if ( is_404() ) {
			return;
		}

		// Get the current post.
		global $post;

		// Get the author ID.
		$author_id = $post->post_author;

		// For posts, get the author's display name from the ID.
		if ( is_single() ) {
			$author = get_the_author_meta( 'display_name', $author_id );

		// Otherwise use the website name.
		} else {
			$author = get_bloginfo( 'name' );
		}

		// Apply a filter for conditional modification.
		$author_tag = apply_filters( 'ccp_author_name', $author );

		// Echo the author display name in the meta tag.
		echo $author_tag;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_meta_author() {

	return Meta_Author::instance();

}

// Run an instance of the class.
ccp_meta_author();