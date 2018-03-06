<?php
/**
 * Site settings page output.
 *
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Settings_Page_Site;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$active_tab = 'ccp-site-general';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'ccp-site-general';
} ?>

<div class="wrap">
	<?php echo sprintf( '<h1>%1s %2s</h1>', get_bloginfo( 'name' ), esc_html__( 'Settings', 'controlled-chaos' ) ); ?>
    <p class="description"><?php esc_html_e( 'Site settings from the Controlled Chaos plugin.', 'controlled-chaos' ); ?></p>
    <h2 class="nav-tab-wrapper">
        <a href="?page=controlled-chaos-settings&tab=ccp-site-general" class="nav-tab <?php echo $active_tab == 'ccp-site-general' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'controlled-chaos' ); ?></a>
        <a href="?page=controlled-chaos-settings&tab=ccp-site-dashboard" class="nav-tab <?php echo $active_tab == 'ccp-site-dashboard' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Dashboard', 'controlled-chaos' ); ?></a>
    </h2>
	<?php echo sprintf( '<p class="description">%1s <a href="%2s" target="_blank">%3s</a>.</p>', esc_html__( 'The Controlled Chaos plugin is developed by' ), esc_url( 'http://ccdzine.com/' ),esc_html__( 'Controlled Chaos Design' ) ); ?>
</div>