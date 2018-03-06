<?php
/**
 * Site name meta.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Meta_Tags\Name;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! function_exists( 'ccp_name_meta' ) ) :

	function ccp_name_meta() {
		bloginfo( 'name' );
	}

endif;