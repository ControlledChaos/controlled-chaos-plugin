<?php
/**
 * Site settings page output.
 *
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

$active_tab = 'ccp-script-options';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'ccp-script-options';
} ?>

<div class="wrap">
    <h1><?php esc_html_e( 'Controlled Chaos', 'controlled-chaos' ); ?></h1>
    <p class="description"><?php esc_html_e( 'Settings for the Controlled Chaos plugin.', 'controlled-chaos' ); ?></p>
    <h2 class="nav-tab-wrapper">
        <a href="?page=controlled-chaos&tab=ccp-script-options" class="nav-tab <?php echo $active_tab == 'ccp-script-options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Script Options', 'controlled-chaos' ); ?></a>
        <a href="?page=controlled-chaos&tab=ccp-site-settings" class="nav-tab <?php echo $active_tab == 'ccp-site-settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Custom Fields', 'controlled-chaos' ); ?></a>
    </h2>
    <form action="options.php" method="post">
        <?php if ( $active_tab == 'ccp-script-options' ) {
            settings_fields( 'ccp-script-options' );
            do_settings_sections( 'ccp-script-options' );
        } elseif ( $active_tab == 'ccp-site-settings' && class_exists( 'ACF_Pro' ) ) {
            settings_fields( 'ccp-site-settings' );
            do_settings_sections( 'ccp-site-settings' );
        } elseif ( $active_tab == 'ccp-site-settings' && ! class_exists( 'ACF_Pro' ) ) {
            echo sprintf( '<h3>%1s <a href="%2s" target="_blank">%3s</a>.</h3>', esc_html__( 'Acitve Advanced Custom Fields PRO for site settings options.', 'ccp-plugin' ), esc_url( 'https://www.advancedcustomfields.com/pro/' ), esc_html( 'Learn more', 'ccp-plugin' ) );
        } ?>
        <?php if ( $active_tab == 'ccp-script-options' || ( $active_tab == 'ccp-site-settings' && class_exists( 'ACF_Pro' ) ) ) : ?>
        <p class="submit"><?php submit_button( __( 'Save Settings', 'controlled-chaos' ), 'primary', '', false, [] ); echo ' '; ?></p>
    <?php endif; ?>
    </form>
    <?php echo sprintf( '<p class="description">%1s <a href="%2s" target="_blank">%3s</a>.</p>', esc_html__( 'The Controlled Chaos plugin is developed by' ), esc_url( 'http://ccdzine.com/' ),esc_html__( 'Controlled Chaos Design' ) ); ?>
</div>