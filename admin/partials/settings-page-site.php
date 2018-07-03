<?php
/**
 * Site settings page output.
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
}

$active_tab = 'dashboard';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'dashboard';
} ?>

<div class="wrap">
	<?php echo sprintf( '<h1 class="wp-heading-inline">%1s %2s</h1>', get_bloginfo( 'name' ), esc_html__( 'Settings', 'controlled-chaos-plugin' ) ); ?>
    <p class="description"><?php esc_html_e( 'Customize the way WordPress is used.', 'controlled-chaos-plugin' ); ?></p>
    <hr class="wp-header-end">
    <h2 class="nav-tab-wrapper">
		<a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-settings&tab=dashboard" class="nav-tab <?php echo $active_tab == 'dashboard' ? 'nav-tab-active' : ''; ?>"><span class="dashicons dashicons-dashboard"></span> <?php esc_html_e( 'Dashboard', 'controlled-chaos-plugin' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-settings&tab=admin-menu" class="nav-tab <?php echo $active_tab == 'admin-menu' ? 'nav-tab-active' : ''; ?>"><span class="dashicons dashicons-menu"></span> <?php esc_html_e( 'Admin Menu', 'controlled-chaos-plugin' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-settings&tab=admin-pages" class="nav-tab <?php echo $active_tab == 'admin-pages' ? 'nav-tab-active' : ''; ?>"><span class="dashicons dashicons-admin-page"></span> <?php esc_html_e( 'Admin Pages', 'controlled-chaos-plugin' ); ?></a>
		<a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-settings&tab=meta-seo" class="nav-tab <?php echo $active_tab == 'meta-seo' ? 'nav-tab-active' : ''; ?>"><span class="dashicons dashicons-tag"></span> <?php esc_html_e( 'Meta/SEO', 'controlled-chaos-plugin' ); ?></a>
    </h2>
	<form method="post" action="options.php">
        <?php if ( $active_tab == 'dashboard' ) {
            settings_fields( 'ccp_dashboard' );
            do_settings_sections( 'ccp-site-dashboard' );
			$save = __( 'Save Dashboard', 'controlled-chaos-plugin' );
		} elseif ( $active_tab == 'admin-menu' ) {
            settings_fields( 'ccp-site-admin-menu' );
            do_settings_sections( 'ccp-site-admin-menu' );
            $save = __( 'Save Menu', 'controlled-chaos-plugin' );
        } elseif ( $active_tab == 'admin-pages' ) {
            settings_fields( 'ccp-site-admin-pages' );
            do_settings_sections( 'ccp-site-admin-pages' );
            $save = __( 'Save Pages', 'controlled-chaos-plugin' );
        } elseif ( $active_tab == 'meta-seo' ) {
            settings_fields( 'ccp-site-meta-seo' );
            do_settings_sections( 'ccp-site-meta-seo' );
            $save = __( 'Save Meta', 'controlled-chaos-plugin' );
        } ?>
        <p class="submit"><?php submit_button( $save, 'primary', '', false, [] ); ?></p>
    </form>
</div>