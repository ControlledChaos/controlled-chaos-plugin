<?php
/**
 * Dublin Core meta tags.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Frontend\Meta_Tags
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       http://dublincore.org/documents/dcmi-terms/
 *
 * @todo       Make these tags optional from the Site Settings page.
 */

namespace CC_Plugin\Frontend\Meta_Tags;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>

<!-- Dublin Core meta -->
<meta name="DC.Title" content="<?php esc_attr( do_action( 'ccp_meta_title_tag' ) ); ?>" />
<meta name="DC.Format" content="text/html" />
<meta name="DC.Identifier" content="<?php esc_attr( esc_url( do_action( 'ccp_meta_url_tag' ) ) ); ?>"/>
<meta name="DC.Source" content="<?php echo esc_attr( esc_url( site_url() ) ); ?>" />
<meta name="DC.Relation" content="<?php echo esc_attr( esc_url( site_url() ) ); ?>" scheme="IsPartOf" />
<?php if ( is_404() ) : ?>
<meta name="DC.Description" content="404 <?php esc_attr( _e( 'Not Found', 'controlled-chaos-plugin' ) ); ?>" />
<?php else : ?>
<meta name="DC.Description" content="<?php esc_attr( do_action( 'ccp_meta_description_tag' ) ); ?>" />
<?php endif; ?>
<meta name="DC.Creator" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
<meta name="DC.Subject" content="<?php echo esc_attr( get_bloginfo( 'description' ) ); ?>" />
<?php if ( is_singular() ) : ?>
<meta name="DC.Contributor" content="<?php esc_attr( do_action( 'ccp_meta_author_tag' ) ); ?>" />
<?php endif; ?>
<?php if ( is_single() ) : ?>
<meta name="DC.Date" content="<?php echo esc_attr( get_the_date() ); ?>" />
<?php endif; ?>
<meta name="DC.Publisher" content="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>" />
<meta name="DC.Rights" content="<?php echo esc_attr( sprintf( '© Copyright %1s %2s. %3s.', get_the_time( 'Y' ), get_bloginfo( 'name' ), esc_attr__( 'All rights reserved', 'controlled-chaos-plugin' ) ) ); ?>" />
<meta name="DC.Language" content="<?php echo esc_attr( get_locale() ); ?>" />

