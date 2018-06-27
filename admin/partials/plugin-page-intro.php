<?php
/**
 * About page introduction output.
 *
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Plugin_Page_About;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>
<h3><?php _e( 'Plugin Overview', 'controlled-chaos-plugin' ); ?></h3>
<p><?php _e( 'This plugin is a head start for building a plugin specific to your website. However, it can be used as is without further development.', 'controlled-chaos-plugin' ); ?></p>
<h3><?php _e( 'Dependencies', 'controlled-chaos-plugin' ); ?></h3>
<p><?php _e( 'Short array syntax requires PHP 5.4+', 'controlled-chaos-plugin' ); ?></p>
<p><?php _e( 'To take advantage of all of its features, this plugin is recommended for use with Advanced Custom Fields PRO.', 'controlled-chaos-plugin' ); ?></p>
<h3><?php _e( 'Starter Settings Pages', 'controlled-chaos-plugin' ); ?></h3>
<p><?php _e( 'One settings page via the default WordPress method and one settings page using the Advanced Custom Fields Options Page method (if ACF is active).', 'controlled-chaos-plugin' ); ?></p>
<h3><?php _e( 'Sample Custom Post Type', 'controlled-chaos-plugin' ); ?></h3>
<p><?php _e( 'Rename and duplicate as needed.', 'controlled-chaos-plugin' ); ?></p>
<h3><?php _e( 'Sample Editor (Gutenberg) Block', 'controlled-chaos-plugin' ); ?></h3>
<p><?php _e( 'Supplied as reference. More to come.', 'controlled-chaos-plugin' ); ?></p>