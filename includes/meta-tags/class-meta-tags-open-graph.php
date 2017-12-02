<?php
/**
 * Open Graph meta tags.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since IntegratePress 1.0.0
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit; ?>

<!-- Open Graph meta -->
<meta property="og:url" content="<?php echo get_the_permalink(); ?>" />
<meta property="og:locale" content="<?php echo get_locale(); ?>" />
<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
<meta property="og:title" content="<?php do_action( 'ccp_meta_title' ); ?>" />
<meta property="og:type" content="'; //ccp_type_meta(); echo '" />
<meta property="og:description" content="<?php do_action( 'ccp_meta_description' ); ?>" />
<meta property="og:image" content="<?php do_action( 'ccp_meta_image' ); ?>" />
