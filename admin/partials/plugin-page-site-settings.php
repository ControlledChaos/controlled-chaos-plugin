<?php
/**
 * About page site settings output.
 *
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Plugin_Page_About;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>
<h3><?php _e( 'Clean Up the Admin', 'controlled-chaos-plugin' ); ?></h3>
<ul>
<li><?php _e( 'Remove dashboard widgets: WordPress news, quick press', 'controlled-chaos-plugin' ); ?></li>
<li><?php _e( 'Make Menus and Widgets top level menu items', 'controlled-chaos-plugin' ); ?></li>
<li><?php _e( 'Remove select admin menu items', 'controlled-chaos-plugin' ); ?></li>
<li><?php _e( 'Remove WordPress logo from admin bar', 'controlled-chaos-plugin' ); ?></li>
<li><?php _e( 'Remove access to theme and plugin editors', 'controlled-chaos-plugin' ); ?></li>
</ul>
<h3><?php _e( 'Enchance the Admin', 'controlled-chaos-plugin' ); ?></h3>
<ul>
<li><?php _e( 'Add three admin bar menus', 'controlled-chaos-plugin' ); ?></li>
<li><?php _e( 'Add custom post types to the At a Glance widget', 'controlled-chaos-plugin' ); ?></li>
<li><?php _e( 'Custom admin footer message', 'controlled-chaos-plugin' ); ?></li>
</ul>