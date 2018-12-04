<?php
/**
 * Description meta tag.
 *
 * Conditionally gets information or content from the current page.
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
 * Description meta tag.
 *
 * @since  1.0.0
 * @access public
 */
class Meta_Description {

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

		// Add description to the meta tag.
		add_action( 'ccp_meta_description_tag', [ $this, 'description' ] );

	}

	/**
	 * Description meta tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function description() {

		// Bail on 404 error pages because of non-object errors.
		if ( is_404() ) {
			return;
		}

		// Get the tagline from Setting > General.
		$tagline = get_bloginfo( 'description' );

		// Check if a tagline has been entered else return an empty string.
		if ( ! empty( $tagline ) ) {
			$tagline_desc = wp_strip_all_tags( $tagline );
		} else {
			$tagline_desc = '';
		}

		/**
		 * Check for the Advanced Custom Fields PRO plugin or the Options Page
		 * addon for free ACF. If there is a blog page description from the ACF
		 * 'Site Settings' page the we'll use that, otherwise we'll look for a
		 * description on the standard 'Site Settings' page.
		 */
		if ( ccp_acf_options() ) {

			/**
			 * Check for content in the ACF blog description field.
			 *
			 * An additional parameter of 'option' must be included to target the options page.
			 */
			$acf_blog_desc = get_field( 'ccp_meta_blog_description', 'option' );

			// If the ACF field is empty use the tagline.
			if ( $acf_blog_desc ) {
				$blog_desc = $acf_blog_desc;
			} else {
				$blog_desc = $tagline_desc;
			}

		} else {

			// Check for content in the blog description standard field.
			$wp_blog_desc = get_option( 'ccp_meta_blog_description' );

			// If the settings field is empty use the tagline.
			if ( $wp_blog_desc ) {
				$blog_desc = $wp_blog_desc;
			} else {
				$blog_desc = $tagline_desc;
			}

		}

		// For search pages, get the terms of the search query.
		$search_query     = get_search_query();

		// Default search description: "Searching for $search_query".
		$search_desc      = wp_strip_all_tags(
			sprintf(
				'%1s \'%2s\'',
				__( 'Showing results for', 'controlled-chaos-plugin' ),
				$search_query
			)
		);

		// Apply a filter to hard-coded text.
		$search_meta_desc = apply_filters( 'ccp_meta_description_search', $search_desc );

		// Look for a manual excerpt.
		$manual_excerpt   = wp_strip_all_tags( get_the_excerpt() );

		// Auto excerpt from content as a fallback.
		$auto_excerpt     = wp_strip_all_tags( wp_trim_words( get_the_content(), 40, '&hellp;' ) );

		// Use the tagline for the front page.
		if ( is_front_page() ) {
			$description = $tagline_desc;
		// Use the blog description established above for blog pages.
		} elseif ( is_home() ) {
			$description = $blog_desc;
		// Use the search text above of the filtered text on search pages.
		} elseif ( is_search() ) {
			$description = $search_meta_desc;
		// For post type pages check for a manual excerpt.
		} elseif ( has_excerpt() ) {
			$description = $manual_excerpt;
		// Otherwise use the auto excerpt if no manual excerpt is found.
		} else {
			$description = $auto_excerpt;
		}

		// Apply a filter for other use cases.
		$meta_description = apply_filters( 'ccp_meta_description', $description );

		// Echo the conditional description in the meta tag.
		echo $meta_description;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_meta_description() {

	return Meta_Description::instance();

}

// Run an instance of the class.
ccp_meta_description();