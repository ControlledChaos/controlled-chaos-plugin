<?php
/**
 * Post_Types_Front_Page class.
 *
 * Select a custom post type to be displayed in place of latest posts on the front page.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Post_Types_Taxes
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @todo       Move this from the Customizer.
 */

namespace CC_Plugin\Includes\Post_Types_Taxes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Post types query on the blog front page.
 *
 * @since  1.0.0
 * @access public
 */
class Post_Types_Front_Page {

	/**
	 * Get an instance of the class.
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
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

		// If a custom front page post type is selected, and a valid post type.
		add_filter( 'pre_get_posts', [ $this, 'pre_get_posts' ] );

		// Register option in the customizer.
		add_action( 'customize_register', [ $this, 'customizer' ] );

	}

	/**
	 * Front page blog query.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $query
	 * @return void
	 */
	public function pre_get_posts( $query ) {

		// Bail if in the admin.
		if ( is_admin() ) {
			return;
		}

		if ( $query->is_home() && $query->is_front_page() && $query->is_main_query() ) {

			$post_type  = get_option( 'ccp_front_page_post_type', '' );
			$post_types = get_post_types( [
				'has_archive' => true,
				'public'      => true,
			]);

			if ( in_array( $post_type, $post_types ) ) {
				$query->set( 'post_type', $post_type );
			}

		}

	}

	/**
	 * Customizer settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $wp_customize
	 * @return void
	 */
	public function customizer( $wp_customize ) {

		$post_types = get_post_types( [
			'has_archive'       => true,
			'show_in_nav_menus' => true,
			'public'            => true,
			'_builtin'          => false,
		]);

		$post_types['post'] = __( 'post' );

		$wp_customize->add_setting( 'ccp_front_page_post_type', [
			'type'       => 'option',
			'capability' => 'manage_options',
			'default'    => 'post',
		]);

		$wp_customize->add_control( 'ccp_front_page_post_type', [
			'label'           => __( 'Front Page Post Type', 'controlled-chaos-plugin' ),
			'type'            => 'radio',
			'choices'         => $post_types,
			'section'         => 'static_front_page',
			'priority'        => 20,
			'active_callback' => [ $this, 'front_page' ],
		]);

	}

	/**
	 * Front page query callback.
	 *
	 * Only show the options when the front page is
	 * in the preview, and also the posts page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function front_page() {

		return ( is_home() && is_front_page() );

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_types_front_page() {

	return Post_Types_Front_Page::instance();

}

// Run an instance of the class.
ccp_types_front_page();