<?php
/**
 * Welcome panel functionality.
 *
 * @package    Controlled_Chaos
 * @subpackage Controlled_Chaos_Plugin\Admin\Dashboard
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
    public function __construct() {}

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