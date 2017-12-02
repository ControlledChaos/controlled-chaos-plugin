<?php
/**
 * Description meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since IntegratePress 1.0.0
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Integrate_Meta_Description {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_description', [ $this, 'description' ] );

	}

	/**
	 * Description meta tag.
	 * 
	 * @since IntegratePress 1.0.0
	 */
	public function description() {

		if ( is_front_page() ) {
			bloginfo( 'description' );
		} elseif ( is_404() ) {
			echo __( 'No results found.' );
		} else { 
			echo wp_trim_words( get_the_content(), 40, '...' );
		}
			
	}

}

// Run the Integrate_Meta_Description class.
$ccp_meta_description = new Integrate_Meta_Description;