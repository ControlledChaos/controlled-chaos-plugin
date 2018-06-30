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
	<div class="ccp_tabbed-content">
		<ul>
			<li>
				<h2><a href="#into"><?php esc_html_e( 'Introduction', 'controlled-chaos-plugin' ); ?></a></h2>
			</li>
			<li>
				<h2><a href="#settings"><?php esc_html_e( 'Site Settings', 'controlled-chaos-plugin' ); ?></a></h2>
			</li>
			<li>
				<h2><a href="#scripts"><?php esc_html_e( 'Script Options', 'controlled-chaos-plugin' ); ?></a></h2>
			</li>
			<li>
				<h2><a href="#media"><?php esc_html_e( 'Media Options', 'controlled-chaos-plugin' ); ?></a></h2>
			</li>
		</ul>
		<div id="into">
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-intro.php'; ?>
		</div>
		<div id="settings">
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-site-settings.php'; ?>
		</div>
		<div id="scripts">
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-script-options.php'; ?>
		</div>
		<div id="media">
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-media-options.php'; ?>
		</div>
	</div>
</div>