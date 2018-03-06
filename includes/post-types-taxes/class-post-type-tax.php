<?php

/**
 * Post types and taxonomies.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */

namespace CCPlugin\Post_Type_Tax;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Post_Types_Taxes {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		$this->dependencies();

	}

	/**
     * Get post type & taxonomy dependencies.
     */
	public function dependencies() {

		// Resister cutsom post types.
		require_once plugin_dir_path( __FILE__ ) . 'class-register-post-types.php';

		// Functions related to post types and taxonomies.
		require_once plugin_dir_path( __FILE__ ) . 'class-post-type-tax-functions.php';

		// Capability to add custom taxonomy templates.
		require_once plugin_dir_path( __FILE__ ) . 'class-taxonomy-templates.php';

	}

}

$controlled_chaos_post_types_taxes = new Controlled_Chaos_Post_Types_Taxes;