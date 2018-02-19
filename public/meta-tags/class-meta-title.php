<?php
/**
 * Title meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.0
 */



// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Controlled_Chaos_Meta_Title {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_title', [ $this, 'title' ] );

	}

	/**
	 * Title meta tag.
	 * 
	 * @since controlled-chaos 1.0.0
	 */
	public function title() {

		if ( is_front_page() ) {
			$title = get_bloginfo( 'name' );
		} elseif ( is_home() ) {
			$title = get_the_title( get_option( 'page_for_posts' ) );
		} else {
			$title = the_title();
		}

		echo $title;

	}

}

// Run the Controlled_Chaos_Meta_Title class.
$ccp_meta_title = new Controlled_Chaos_Meta_Title;