<?php
/**
 * About page script options output.
 *
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Plugin_Page_About;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>
<h3><?php _e( 'General Options', 'controlled-chaos' ); ?></h3>
<h3><?php _e( 'Included Vendor Scripts', 'controlled-chaos' ); ?></h3>
<p><?php _e( 'UI &amp; UX JS plugins ready to use', 'controlled-chaos' ); ?></p>
<ul>
<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Fancybox 3', 'controlled-chaos' ), esc_attr( 'https://github.com/fancyapps/fancybox' ), esc_url( 'https://github.com/fancyapps/fancybox' ) ); ?>
<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Slick', 'controlled-chaos' ), esc_attr( 'https://github.com/kenwheeler/slick' ), esc_url( 'https://github.com/kenwheeler/slick' ) ); ?>
<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Tabslet', 'controlled-chaos' ), esc_attr( 'https://github.com/vdw/Tabslet' ), esc_url( 'https://github.com/vdw/Tabslet' ) ); ?>
<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Sticky-kit', 'controlled-chaos' ), esc_attr( 'https://github.com/leafo/sticky-kit' ), esc_url( 'https://github.com/leafo/sticky-kit' ) ); ?>
<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'Tooltipster', 'controlled-chaos' ), esc_attr( 'https://github.com/iamceege/tooltipster' ), esc_url( 'https://github.com/iamceege/tooltipster' ) ); ?>
<?php echo sprintf( '<li>%1s - <a href="%2s" target="_blank">%3s</a></li>', _x( 'FitVids', 'controlled-chaos' ), esc_attr( 'https://github.com/davatron5000/FitVids.js' ), esc_url( 'https://github.com/davatron5000/FitVids.js' ) ); ?>
</ul>