<?php
/**
 * Standard meta tags.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since IntegratePress 1.0.0
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

global $post; ?>

<meta name="title" content="<?php do_action( 'ccp_meta_title' ); ?>" />
<meta name="description" content="<?php do_action( 'ccp_meta_description' ); ?>" />
<meta name="author" content="<?php do_action( 'ccp_meta_author' ); ?>" />
