<?php
/**
 * Script options page output.
 *
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Settings_Page_Scripts;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Settings saved notice.
if ( isset( $_GET['settings-updated'] ) ) { ?>
<div id="setting-error-settings_updated" class="updated settings-error notice is-dismissible">
	<p><strong><?php _e( 'Script settings saved.', 'controlled-chaos-plugin' ); ?></strong></p>
</div>
<?php }

$active_tab = 'general';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
} ?>

<div class="wrap">
    <h1 class="wp-heading-inline"><?php esc_html_e( 'Script Options', 'controlled-chaos-plugin' ); ?></h1>
    <?php if ( is_rtl() ) : ?>
    <p class="description"><?php esc_html_e( 'Script settings from the Controlled Chaos plugin. More information in the Help tab at upper left.', 'controlled-chaos-plugin' ); ?></p>
    <?php else : ?>
    <p class="description"><?php esc_html_e( 'Script settings from the Controlled Chaos plugin. More information in the Help tab at upper right.', 'controlled-chaos-plugin' ); ?></p>
    <?php endif; ?>
    <hr class="wp-header-end">
    <h2 class="nav-tab-wrapper">
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-scripts&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'General', 'controlled-chaos-plugin' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-scripts&tab=vendor" class="nav-tab <?php echo $active_tab == 'vendor' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Vendor', 'controlled-chaos-plugin' ); ?></a>
    </h2>
    <form action="options.php" method="post">
        <?php if ( $active_tab == 'general' ) {
            settings_fields( 'ccp-scripts-general' );
            do_settings_sections( 'ccp-scripts-general' );
            $save = __( 'Save General', 'controlled-chaos-plugin' );
        } elseif ( $active_tab == 'vendor' ) {
            settings_fields( 'ccp-scripts-vendor' );
            do_settings_sections( 'ccp-scripts-vendor' );
            $save = __( 'Save Vendor', 'controlled-chaos-plugin' );
        } ?>
        <?php if ( $active_tab == 'general' || $active_tab == 'vendor' ) : ?>
        <p class="submit"><?php submit_button( $save, 'primary', '', false, [] ); ?></p>
    <?php endif; ?>
    </form>
    <?php echo sprintf( '<p class="description">%1s <a href="%2s" target="_blank">%3s</a>.</p>', esc_html__( 'The Controlled Chaos plugin is developed by' ), esc_url( 'http://ccdzine.com/' ),esc_html__( 'Controlled Chaos Design' ) ); ?>
</div>