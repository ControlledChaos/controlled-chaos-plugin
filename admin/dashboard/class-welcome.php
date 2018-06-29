<?php
/**
 * Welcome panel functionality.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin\Dashboard
 * 
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin\Dashboard;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Welcome panel functionality.
 * 
 * @since  1.0.0
 * @access public
 */
class Welcome {

	/**
	 * Get an instance of the plugin class.
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
	 * @return void // Constructor method is empty.
	 */
    public function __construct() {

		// Remove the welcome panel dismiss button.
		$dismiss = get_option( 'ccp_remove_welcome_dismiss' );
		if ( $dismiss ) {
			add_action( 'admin_head', [ $this, 'dismiss' ] );
		}

	}

	/**
	 * Remove the welcome panel dismiss button if option selected.
	 */
	public function dismiss() {

		$dismiss = '
			<style>
				/*
				* Welcome panel user dismiss option
				* is disabled in the Customizer
				*/
				a.welcome-panel-close, #wp_welcome_panel-hide, .metabox-prefs label[for="wp_welcome_panel-hide"] {
					display: none !important;
				}
				.welcome-panel {
					display: block !important;
				}
			</style>
			';

		echo $dismiss;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_welcome() {

	return Welcome::instance();

}

// Run an instance of the class.
ccp_welcome();