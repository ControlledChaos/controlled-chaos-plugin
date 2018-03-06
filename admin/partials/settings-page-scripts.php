<?php
/**
 * Script options page output.
 *
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Settings_Page_Scripts;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$active_tab = 'ccp-scripts-general';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'ccp-scripts-general';
} ?>

<div class="wrap">
    <h1><?php esc_html_e( 'Script Options', 'controlled-chaos' ); ?></h1>
    <p class="description"><?php esc_html_e( 'Script settings from the Controlled Chaos plugin.', 'controlled-chaos' ); ?></p>
    <h2 class="nav-tab-wrapper">
        <a href="?page=controlled-chaos-scripts&tab=ccp-scripts-general" class="nav-tab <?php echo $active_tab == 'ccp-scripts-general' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'controlled-chaos' ); ?></a>
        <a href="?page=controlled-chaos-scripts&tab=ccp-scripts-vendor" class="nav-tab <?php echo $active_tab == 'ccp-scripts-vendor' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Vendor', 'controlled-chaos' ); ?></a>
    </h2>
    <form action="options.php" method="post">
        <?php if ( $active_tab == 'ccp-scripts-general' ) {
            settings_fields( 'ccp-scripts-general' );
            do_settings_sections( 'ccp-scripts-general' );
            $save = __( 'Save General', 'controlled-chaos' );
        } elseif ( $active_tab == 'ccp-scripts-vendor' ) {
            settings_fields( 'ccp-scripts-vendor' );
            do_settings_sections( 'ccp-scripts-vendor' );
            $save = __( 'Save Vendor', 'controlled-chaos' );
        } ?>
        <?php if ( $active_tab == 'ccp-scripts-general' || $active_tab == 'ccp-scripts-vendor' ) : ?>
        <p class="submit"><?php submit_button( $save, 'primary', '', false, [] ); echo ' '; ?></p>
    <?php endif; ?>
    </form>
    <?php echo sprintf( '<p class="description">%1s <a href="%2s" target="_blank">%3s</a>.</p>', esc_html__( 'The Controlled Chaos plugin is developed by' ), esc_url( 'http://ccdzine.com/' ),esc_html__( 'Controlled Chaos Design' ) ); ?>
</div>