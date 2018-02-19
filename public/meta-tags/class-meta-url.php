<?php
/**
 * URL meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.0
 */

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Controlled_Chaos_Meta_URL {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_url', [ $this, 'url' ] );

	}

	/**
	 * URL meta tag.
	 * 
	 * @since controlled-chaos 1.0.0
	 */
	public function url() {

		if ( is_front_page() ) {
            $url = get_site_url();
        } elseif ( is_home() ) {
            $url = get_permalink( get_option( 'page_for_posts' ) );
		} else {
			$url = get_the_permalink();
		}

		echo $url;

	}

}

// Run the Controlled_Chaos_Meta_URL class.
$ccp_meta_url = new Controlled_Chaos_Meta_URL;