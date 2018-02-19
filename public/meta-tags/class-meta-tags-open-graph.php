<?php
/**
 * Open Graph meta tags.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.0
 */



// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit; ?>

<!-- Open Graph meta -->
<meta property="og:url" content="<?php do_action( 'ccp_meta_url' ); ?>" />
<meta property="og:locale" content="<?php echo get_locale(); ?>" />
<meta property="og:site_name" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
<meta property="og:title" content="<?php do_action( 'ccp_meta_title' ); ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php do_action( 'ccp_meta_description' ); ?>" />
<meta property="og:image" content="<?php do_action( 'ccp_meta_image' ); ?>" />
