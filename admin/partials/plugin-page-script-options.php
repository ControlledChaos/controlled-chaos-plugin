<?php
/**
 * About page script options output.
 *
 * Uses the universal slug partial for admin pages. Set this
 * slug in the core plugin file.
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
<h3><?php _e( 'Script Inclusion and Loading', 'controlled-chaos-plugin' ); ?></h3>
<?php echo sprintf(
	'<p>%1s <a href="%2s">%3s</a> %4s</p>',
	__( 'This plugin is equipped with', 'controlled-chaos-plugin' ),
	esc_url( admin_url( 'options-general.php?page=' . CCP_ADMIN_SLUG . '-scripts' ) ),
	__( 'an admin page', 'controlled-chaos-plugin' ),
	__( 'for enqueueing third-party scripts included in the plugin, as well as for script loading options.', 'controlled-chaos-plugin' )
 ); ?>
<h3><?php _e( 'Included Vendor Scripts', 'controlled-chaos-plugin' ); ?></h3>
<p><?php _e( 'UI &amp; UX JS plugins ready to use', 'controlled-chaos-plugin' ); ?></p>
<ul>
	<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Fancybox 3', 'controlled-chaos-plugin' ), esc_attr( 'https://github.com/fancyapps/fancybox' ), esc_url( 'https://github.com/fancyapps/fancybox' ) ); ?>
	<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Slick', 'controlled-chaos-plugin' ), esc_attr( 'https://github.com/kenwheeler/slick' ), esc_url( 'https://github.com/kenwheeler/slick' ) ); ?>
	<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Tabslet', 'controlled-chaos-plugin' ), esc_attr( 'https://github.com/vdw/Tabslet' ), esc_url( 'https://github.com/vdw/Tabslet' ) ); ?>
	<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Sticky-kit', 'controlled-chaos-plugin' ), esc_attr( 'https://github.com/leafo/sticky-kit' ), esc_url( 'https://github.com/leafo/sticky-kit' ) ); ?>
	<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Tooltipster', 'controlled-chaos-plugin' ), esc_attr( 'https://github.com/iamceege/tooltipster' ), esc_url( 'https://github.com/iamceege/tooltipster' ) ); ?>
	<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'FitVids', 'controlled-chaos-plugin' ), esc_attr( 'https://github.com/davatron5000/FitVids.js' ), esc_url( 'https://github.com/davatron5000/FitVids.js' ) ); ?>
</ul>