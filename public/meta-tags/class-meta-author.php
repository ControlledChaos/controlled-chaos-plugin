<?php
/**
 * Author meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since IntegratePress 1.0.0
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Integrate_Meta_Author {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_author', [ $this, 'author' ] );

	}

	/**
	 * Author meta tag.
	 * 
	 * @since IntegratePress 1.0.0
	 */
	public function author() {

		global $post;

		echo get_the_author_meta( 'display_name' );
			
	}

}

// Run the Integrate_Meta_Author class.
$ccp_meta_author = new Integrate_Meta_Author;