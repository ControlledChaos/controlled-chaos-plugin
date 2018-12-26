<?php
/**
 * Provided to extend Advanced Custom Fields.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\ACF
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get plugins path to check for active plugins.
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Define the core functionality of the plugin.
 *
 * @since  1.0.0
 * @access public
 */
class Extend_ACF {

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
	 * @access private
	 * @return void Constructor is empty.
	 *              Change to `self` if used.
	 */
	private function __construct() {

		// Enqueue stylesheet for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );

		// Enqueue JavaScript for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

	}

	/**
	 * Enqueue ACF stylesheets for the admin area.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		wp_enqueue_style( CCP_ADMIN_SLUG . '-acf-admin', CCP_URL . 'includes/acf/assets/css/admin.min.css', [], CCP_VERSION, 'screen' );

	}

	/**
	 * Enqueue ACF JavaScript for the admin area.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {

		wp_enqueue_script( CCP_ADMIN_SLUG . '-acf-admin', CCP_URL . 'includes/acf/assets/js/admin.min.js', [ 'jquery' ], CCP_VERSION, true );

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_extend_acf() {

	return Extend_ACF::instance();

}

// Run an instance of the class.
ccp_extend_acf();