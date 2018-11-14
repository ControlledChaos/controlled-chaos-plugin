<?php
/**
 * Date published meta tag.
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
 * Date published meta tag.
 *
 * @since  1.0.0
 * @access public
 */
class Meta_Date_Published {

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

		// Add published date to the meta tag.
		add_action( 'ccp_meta_date_pub_tag', [ $this, 'date' ] );

	}

	/**
	 * Published date meta tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object post The post object for the current post.
	 * @return string
	 */
	public function date() {

		// Bail on error pages.
		if ( is_404() ) {
			return;
		}

		// Get the current post.
		global $post;

		$date_tag = get_the_date( 'Y-m-d' );

		// Echo the date in the meta tag.
		echo $date_tag;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_meta_date_pub() {

	return Meta_Date_Published::instance();

}

// Run an instance of the class.
ccp_meta_date_pub();