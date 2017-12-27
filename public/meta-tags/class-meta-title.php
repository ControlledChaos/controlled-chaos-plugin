<?php
/**
 * Title meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.4
 */

namespace Controlled_Chaos_Plugin;

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
	 * @since controlled-chaos 1.0.4
	 */
	public function title() {

		if ( is_front_page() ) {
			$title = get_bloginfo( 'name' );
		} else {
			$title = the_title();
		}

		echo $title;

	}

}

// Run the Controlled_Chaos_Meta_Title class.
$ccp_meta_title = new Controlled_Chaos_Meta_Title;