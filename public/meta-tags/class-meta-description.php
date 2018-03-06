<?php
/**
 * Description meta tag.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Meta_Tags\Description;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Controlled_Chaos_Meta_Description {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		add_action( 'ccp_meta_description', [ $this, 'description' ] );

	}

	/**
	 * Description meta tag.
	 * 
	 * @since controlled-chaos 1.0.0
	 */
	public function description() {

		if ( is_front_page() ) {
			$description = esc_html( get_bloginfo( 'description' ) );
		} elseif ( is_404() ) {
			$description = esc_html( __( 'No results found.' ) );
		} elseif ( has_excerpt() ) {
			$description = esc_html( get_the_excerpt() );
		} else { 
			$description = esc_html( wp_trim_words( get_the_content(), 40, '...' ) );
		}

		echo $description;
			
	}

}

// Run the Controlled_Chaos_Meta_Description class.
$ccp_meta_description = new Controlled_Chaos_Meta_Description;