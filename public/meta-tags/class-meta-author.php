<?php
/**
 * Author meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.0
 */



// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Controlled_Chaos_Meta_Author {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_author', [ $this, 'author' ] );

	}

	/**
	 * Author meta tag.
	 * 
	 * @since controlled-chaos 1.0.0
	 */
	public function author() {

		global $post;

		echo get_the_author_meta( 'display_name' );
			
	}

}

// Run the Controlled_Chaos_Meta_Author class.
$ccp_meta_author = new Controlled_Chaos_Meta_Author;