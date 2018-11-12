<?php
/**
 * About page introduction output.
 *
 * Since you are going to change this content it may have been a
 * waste of my time to put the text here into translation functions.
 * However, I like to do things properly and I want this to serve as
 * an example of how it should be done for your project.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin\Partials
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin\Partials;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>
<!-- Tabbed content heading -->
<h2><?php _e( 'Plugin Overview', 'controlled-chaos-plugin' ); ?></h2>

<p><?php _e( 'This is a tool — a means to an end. But it can be used as is without further development.', 'controlled-chaos-plugin' ); ?></p>
<p><?php esc_html_e( 'This page is provided for reference and as a framework for building your own informational page. If you do not use this page then it is recommended that you delete it and all associated files.', 'controlled-chaos-plugin' ); ?></p>

<!-- Section heading -->
<h3><?php _e( 'Introduction', 'controlled-chaos-plugin' ); ?></h3>

<?php echo sprintf(
	'<p>%1s <a href="%2s" target="_blank">Controlled Chaos Design</a>.</p>',
	__( 'Howdy, folks. My name is Greg Sweet. I am sole proprietor, chief cook and bottle washer at', 'controlled-chaos-plugin' ),
	esc_url( 'http://ccdzine.com/' )
); ?>
<?php echo sprintf(
	'<p>%1s <a href="%2s" target="_blank">%3s</a>%4s</p>',
	__( 'I built this plugin as a starter for client sites, including features that I use often, the code for which I repeatedly copied from my', 'controlled-chaos-plugin' ),
	esc_url( 'https://gist.github.com/ControlledChaos' ),
	__( 'gist library', 'controlled-chaos-plugin' ),
	__( '. It is not intended to be a plug-and-play type of thing, although it can be used as such. This is more of a developer\'s tool. I have commented thouroughly on the code and documentec the files to the best of my ability. I have learned by looking at the code of others so I have kept this in mind when writing the code for this plugin.', 'controlled-chaos-plugin' )
 ) ?>

<!-- Section heading -->
<h3><?php _e( 'Approach', 'controlled-chaos-plugin' ); ?></h3>

<p><?php _e( 'Although this plugin comes with my business name incorporated into it, I am not trying to put my branding stink all over your project. It has to have a name so I used my own. However, since I need to rename the plugin for my clients\' websites, I have made every effort to use a simple, uniform naming system that can be quicky renamed for your project.', 'controlled-chaos-plugin' ); ?></p>
<p><?php _e( 'Not every feature included with this plugin will be needed for my projects or yours. And one big reason for writing a site-specific plugin is to include only what the site needs and eliminate the overhead of plugins and themes that offer things that you don\'t need. So why have I packed so much into this plugin? Well, I find it to be much quicker and easier to remove unnecessary code that it is to write, or even copy & paste, new code into a project. And being that you will rename this plugin and that it will update to overwrite your changes, modifications can be made ad libidum.', 'controlled-chaos-plugin' ); ?></p>

<!-- Section heading -->
<h3><?php _e( 'Compatibility', 'controlled-chaos-plugin' ); ?></h3>

<ul class="ccp_bullet-list">
	<li><?php _e( 'This plugin was written in a WordPress 4.9+ environment with no concern for backwards compatitbility.', 'controlled-chaos-plugin' ); ?></li>
	<li><?php _e( 'This plugin was written on a local server running PHP 7.0', 'controlled-chaos-plugin' ); ?></li>
	<li><?php _e( 'The short array syntax ( "[]" rather than "array()" ) requires PHP 5.4+', 'controlled-chaos-plugin' ); ?></li>
	<li><?php _e( 'Run a modern setup and you\'ll be fine.', 'controlled-chaos-plugin' ); ?></li>
</ul>
<?php echo sprintf(
	'<p>%1s</p>',
	__( 'Sample editor blocks are included in preparation for WordPress 5.0 with it\'s new user interface. Until that release, the <a href="%2s" target="_blank">Gutenberg</a> plugin is required to use the blocks.', 'controlled-chaos-plugin' ),
	esc_url( 'https://wordpress.org/plugins/gutenberg/' )
 ); ?>
<?php echo sprintf(
	'<p>%1s <a href="%2s" target="_blank">%3s</a> %4s <a href="%5s" target="_blank">%6s</a> %7s <a href="%8s" target="_blank">%9s</a> %10s <a href="%11s" target="_blank">%12s</a> %13s</p>',
	__( 'For a nicer user experience, this plugin is recommended for use with', 'controlled-chaos-plugin' ),
	esc_url( 'https://www.advancedcustomfields.com/pro/' ),
	'Advanced Custom Fields PRO',
	__( 'or the', 'controlled-chaos-plugin' ),
	esc_url( 'https://wordpress.org/plugins/advanced-custom-fields/' ),
	__( 'free version of ACF', 'controlled-chaos-plugin' ),
	__( 'plus the', 'controlled-chaos-plugin' ),
	esc_url( 'https://www.advancedcustomfields.com/add-ons/options-page/' ),
	__( 'Options Page', 'controlled-chaos-plugin' ),
	__( 'addon. However, most of the ACF features are duplicated using the', 'controlled-chaos-plugin' ),
	esc_url( 'https://developer.wordpress.org/plugins/settings/settings-api/' ),
	__( 'WordPress settings API', 'controlled-chaos-plugin' ),
	__( 'to reduce third-party dependencies.', 'controlled-chaos-plugin' )
 ); ?>

<!-- Section heading -->
<h3><?php _e( 'Additional Information', 'controlled-chaos-plugin' ); ?></h3>

<p><?php _e( 'You can find more information, including instructions for renaming this plugin, in the help tab at the top of this page.' ); ?></p>