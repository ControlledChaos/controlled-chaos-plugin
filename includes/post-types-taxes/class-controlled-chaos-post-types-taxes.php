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

namespace Controlled_Chaos_Plugin;

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

	public function dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'post-types-taxes/class-controlled-chaos-taxonomy-templates.php';

	}

}

$controlled_chaos_post_types_taxes = new Controlled_Chaos_Post_Types_Taxes;