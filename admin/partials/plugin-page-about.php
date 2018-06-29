<?php
/**
 * About page output.
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

$active_tab = 'introduction';
if ( isset( $_GET[ 'tab' ] ) ) {
    $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'introduction';
} ?>
<div class="wrap">
	<?php echo sprintf( '<h1 class="wp-heading-inline">%1s %2s</h1>', get_bloginfo( 'name' ), esc_html__( 'Plugin', 'controlled-chaos-plugin' ) ); ?>
    <p class="description"><?php esc_html_e( 'What it does and how to use it.', 'controlled-chaos-plugin' ); ?></p>
	<hr class="wp-header-end">
	<h2 class="nav-tab-wrapper">
		<a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=introduction" class="nav-tab <?php echo $active_tab == 'introduction' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Introduction', 'controlled-chaos-plugin' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=site-settings" class="nav-tab <?php echo $active_tab == 'site-settings' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Site Settings', 'controlled-chaos-plugin' ); ?></a>
        <a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=script-options" class="nav-tab <?php echo $active_tab == 'script-options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Script Options', 'controlled-chaos-plugin' ); ?></a>
		<a href="?page=<?php echo CCP_ADMIN_SLUG; ?>-page&tab=media-options" class="nav-tab <?php echo $active_tab == 'media-options' ? 'nav-tab-active' : ''; ?>"><?php esc_html_e( 'Media Options', 'controlled-chaos-plugin' ); ?></a>
    </h2>
	<?php 

	// If on the Introduction tab then get the page info file.
	if ( $active_tab == 'introduction' ) {
		include_once plugin_dir_path( __FILE__ ) . 'plugin-page-intro.php';

	// If on the Site Settings tab then get the page info file.
	} elseif ( $active_tab == 'site-settings' ) {
		include_once plugin_dir_path( __FILE__ ) . 'plugin-page-site-settings.php';

	// If on the Script Options tab then get the page info file.
	} elseif ( $active_tab == 'script-options' ) {
		include_once plugin_dir_path( __FILE__ ) . 'plugin-page-script-options.php';

	// If on the Media Options tab then get the page info file.
	} elseif ( $active_tab == 'media-options' ) {
		include_once plugin_dir_path( __FILE__ ) . 'plugin-page-media-options.php';
	} ?>
</div>