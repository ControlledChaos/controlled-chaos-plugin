<?php
/**
 * Provided to extend Advanced Custom Fields.
 *
 * ACF version 4 or earlier is not supported.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\ACF
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Includes\ACF;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Bail if ACF version 4 or earlier.
if ( ! defined( 'ACF_VERSION' ) ) {
	return;
}

/**
 * Extend Advanced Custom Fields.
 *
 * @since  1.0.0
 * @access public
 */
class Extend_ACF {

	// Settings variable.
	var $settings;

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

			// Get field classes.
			$instance->include_fields();

		}

		// Return the instance.
		return $instance;

	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access private
	 * @return self
	 */
	private function __construct() {

		// Enqueue stylesheet for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_styles' ] );

		// Enqueue JavaScript for the admin area.
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts' ] );

	}

	/**
	 * Include the fields
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function include_fields() {

		// Get the sample field class.
		include_once CCP_PATH . 'includes/acf/fields/acf-sample-field/class-acf-sample-field.php';

		include_once CCP_PATH . 'includes/acf/acf-field-name/acf-field-name.php';

	}

	/**
	 * Enqueue general ACF stylesheets for the admin area.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_styles() {

		// Uncomment to enqueue.
		// wp_enqueue_style( CCP_ADMIN_SLUG . '-acf-admin', CCP_URL . 'includes/acf/assets/css/admin.min.css', [], CCP_VERSION, 'screen' );

	}

	/**
	 * Enqueue general ACF JavaScript for the admin area.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_scripts() {

		// Uncomment to enqueue.
		// wp_enqueue_script( CCP_ADMIN_SLUG . '-acf-admin', CCP_URL . 'includes/acf/assets/js/admin.min.js', [ 'jquery' ], CCP_VERSION, true );

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