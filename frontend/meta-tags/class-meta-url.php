<?php
/**
 * URL meta tag.
 *
 * Conditionally gets the URL of the current page.
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
 * URL meta tag.
 *
 * @since  1.0.0
 * @access public
 */
class Meta_URL {

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

		// Get the page number of paged URLs.
		add_action( 'template_redirect', [ $this, 'page' ] );

		// Add the URL to the meta tags.
		add_action( 'ccp_meta_url_tag', [ $this, 'content' ] );

	}

	/**
	 * Get the page number of paged URLs and combine with
	 * the "page" segment of the URL.
	 *
	 * Using the `template_redirect` hook to avoid errors
	 * thrown for trying to get objects before the query.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return mixed Returns the ID integer of queried objects.
	 *               Returns the ID in a string.
	 */
	public static function page() {

		// Get the page of paginated permalinks with a trailing slash.
		$page_number = trailingslashit( get_query_var( 'paged' ) );

		// Add "page" to the path with a trailing slash.
		$page_before = trailingslashit( 'page' );

		// Combine the two above.
		$page_path   = $page_before . $page_number;

		// Return the page path.
		return $page_path;

	}

	/**
	 * Conditional content for the URL meta tag.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the appropriate URL.
	 */
	public function content() {

		// Set a variable for archive IDs.
		$id = get_queried_object_id();

		// Use the site URL for the front page and error page.
		if ( is_front_page() || is_404() ) {
			$url = esc_url( get_site_url() );

		// If in the blog index and not on the first page.
        } elseif ( is_home() && is_paged() ) {
			$url = esc_url( get_permalink( get_option( 'page_for_posts' ) ) . $this->page() );

		// If in the blog index and on the first page.
		} elseif ( is_home() ) {
			$url = esc_url( get_permalink( get_option( 'page_for_posts' ) ) );

		// If in a category archive and not on the first page.
		} elseif ( is_category() && is_paged() ) {
			$url = esc_url( get_category_link( $id ) . $this->page() );

		// If in a category archive and on the first page.
		} elseif ( is_category() ) {
			$url = esc_url( get_category_link( $id ) );

		// If in a tag archive and not on the first page.
		} elseif ( is_tag() && is_paged() ) {
			$url = esc_url( get_tag_link( $id ) . $this->page() );

		// If in a tag archive and on the first page.
		} elseif ( is_tag() ) {
			$url = esc_url( get_tag_link( $id ) );

		// If in a taxonomy archive and not on the first page.
		} elseif ( is_tax() && is_paged() ) {
			$url = esc_url( get_term_link( $id ) . $this->page() );

		// If in a taxonomy archive and on the first page.
		} elseif ( is_tax() ) {
			$url = esc_url( get_term_link( $id ) );

		// If in an author archive and not on the first page.
		} elseif ( is_author() && is_paged() ) {
			$url = esc_url( get_author_posts_url( $id ) . $this->page() );

		// If in an author archive and on the first page.
		} elseif ( is_author() ) {
			$url = esc_url( get_author_posts_url( $id ) );

		// If in a day archive and not on the first page.
		} elseif ( is_day() && is_paged() ) {
			$url = esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) . $this->page() );

		// If in a day archive and on the first page.
		} elseif ( is_day() ) {
			$url = esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ), get_the_time( 'd' ) ) );

		// If in a month archive and not on the first page.
		} elseif ( is_month() && is_paged() ) {
			$url = esc_url( get_day_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) . $this->page() );

		// If in a month archive and on the first page.
		} elseif ( is_month() ) {
			$url = esc_url( get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ) );

		// If in a year archive and not on the first page.
		} elseif ( is_year() && is_paged() ) {
			$url = esc_url( get_day_link( get_the_time( 'Y' ) ) . $this->page() );

		// If in a year archive and on the first page.
		} elseif ( is_year() ) {
			$url = esc_url( get_year_link( get_the_time( 'Y' ) ) );

		// For search pages, get the permalink for current terms of the query.
		} elseif ( is_search() ) {
			$url = esc_url( get_search_link() );

		// For everything else (singular) get the permalink.
		} else {
			$url = esc_url( get_the_permalink() );
		}

		// Echo the appropriate URL in the content of the tag.
		echo $url;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_meta_url() {

	return Meta_URL::instance();

}

// Run an instance of the class.
ccp_meta_url();