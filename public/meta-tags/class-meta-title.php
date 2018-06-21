<?php
/**
 * Title meta tag.
 *
 * @package    controlled-chaos
 * @subpackage Controlled_Chaos\includes
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Meta_Tags\Title;

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
			$title = esc_html( get_bloginfo( 'name' ) );
		} elseif ( is_home() ) {
			$title = esc_html( get_the_title( get_option( 'page_for_posts' ) ) );
		} else {
			$title = esc_html( get_the_title() );
		}

		echo esc_attr( esc_html( $title ) );

	}

}

// Run the Controlled_Chaos_Meta_Title class.
$ccp_meta_title = new Controlled_Chaos_Meta_Title;