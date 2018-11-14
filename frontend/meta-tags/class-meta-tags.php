<?php
/**
 * Meta tags in the head.
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
 * Meta tags in the head.
 *
 * @since  1.0.0
 * @access public
 */
class Meta_Tags {

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

			// Frontend dependencies
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

		// Add meta tags to <head> if not disabled.
		add_action( 'wp_head', [ $this, 'meta_tags' ] );

	}

		/**
	 * Frontend dependencies
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dependencies() {

		// Get classes that create the output.
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-url.php';
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-title.php';
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-description.php';
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-author.php';
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-date-published.php';
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-date-modified.php';
		include_once CCP_PATH . 'frontend/meta-tags/class-meta-image.php';

	}

	/**
	 * Meta tags for SEO and embedded links.
	 *
	 * Check for the Advanced Custom Fields PRO plugin, or the Options Page
	 * addon for free ACF, then check if meta tags have been disabled from
	 * the ACF 'Site Settings' page. Otherwise check if meta tags have been
	 * disabled from the standard 'Site Settings' page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tags() {

		if ( ccp_acf_options() ) {
			$disable_tags = get_field( 'ccp_meta_disable_tags', 'option' );
		} else {
			$disable_tags = get_option( 'ccp_meta_disable' );
		}

		if ( ! $disable_tags || false == $disable_tags ) {

			include_once CCP_PATH . 'frontend/meta-tags/meta-tags-standard.php';
			include_once CCP_PATH . 'frontend/meta-tags/meta-tags-schema.php';
			include_once CCP_PATH . 'frontend/meta-tags/meta-tags-open-graph.php';
			include_once CCP_PATH . 'frontend/meta-tags/meta-tags-twitter.php';
			include_once CCP_PATH . 'frontend/meta-tags/meta-tags-dublin-core.php';

		}

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_meta_tags() {

	return Meta_Tags::instance();

}

// Run an instance of the class.
ccp_meta_tags();