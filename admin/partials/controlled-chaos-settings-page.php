<?php
/**
 * Site settings page output.
 *
 *
 * @package WordPress
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} ?>

<div class="wrap">
    <h1><?php esc_html_e( 'Controlled Chaos', 'controlled-chaos' ); ?></h1>
    <p class="description"><?php esc_html_e( 'Settings for the Controlled Chaos plugin.', 'controlled-chaos' ); ?></p>
    <hr />

    <form action="options.php" method="post">
        <?php settings_fields( 'controlled-chaos' ); ?>
        <?php do_settings_sections( 'controlled-chaos' ); ?>
        <p><?php submit_button( __( 'Save Settings', 'controlled-chaos' ), 'primary', '', false, [] ); echo ' '; ?></p>
    </form>

    <?php echo sprintf( '<p class="description">%1s <a href="%2s" target="_blank">%3s</a>.</p>', esc_html__( 'The Controlled Chaos Plugin is developed by' ), esc_url( 'http://ccdzine.com/' ),esc_html__( 'Controlled Chaos Design' ) ); ?>
</div>