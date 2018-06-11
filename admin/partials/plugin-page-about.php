<?php
/**
 * About page output.
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

$active_tab = 'introduction';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'introduction';
} ?>
<div class="wrap">
	<?php echo sprintf( '<h1>%1s</h1>', esc_html__( 'Controlled Chaos Plugin', 'controlled-chaos' ) ); ?>
    <p class="description"><?php esc_html_e( 'What it does and how to use it.', 'controlled-chaos' ); ?></p>
	<h2 class="nav-tab-wrapper">
		<a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=introduction" class="nav-tab <?php echo $active_tab == 'introduction' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Introduction', 'controlled-chaos' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=site-settings" class="nav-tab <?php echo $active_tab == 'site-settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Site Settings', 'controlled-chaos' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=script-options" class="nav-tab <?php echo $active_tab == 'script-options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Script Options', 'controlled-chaos' ); ?></a>
		<a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=media-options" class="nav-tab <?php echo $active_tab == 'media-options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Media Options', 'controlled-chaos' ); ?></a>
    </h2>
</div>