<?php
/**
 * Title meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since IntegratePress 1.0.0
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Integrate_Meta_Title {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_title', [ $this, 'title' ] );

	}

	/**
	 * Title meta tag.
	 * 
	 * @since IntegratePress 1.0.0
	 */
	public function title() {

		if ( is_front_page() ) {
			$title = bloginfo( 'name' );
		} else {
			$title = the_title();
		}

		echo $title;

	}

}

// Run the Integrate_Meta_Title class.
$ccp_meta_title = new Integrate_Meta_Title;