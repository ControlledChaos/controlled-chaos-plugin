<?php
/**
 * About page output.
 *
 * This page uses the jQuery tabs from the jQuery UI suite that is included
 * with WordPress. Tabs are activated by targeting the `backend-tabbed-content`
 * in this plugin's admin.js file.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin\Partials
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @see        Tabs admin/assets/js/admin.js
 * @link       Dashicons https://developer.wordpress.org/resource/dashicons/
 */

namespace CC_Plugin\Admin\Partials;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Get the settings page menu icon option from Site Settings.
$settings_icon = sanitize_text_field( get_option( 'ccp_site_settings_link_icon' ) );

// If it's not empty, use the icon class from the option.
if ( $settings_icon ) {
	$settings = $settings_icon;

// Otherwise use the admin settings icon.
} else {
	$settings = 'dashicons-admin-settings';
}

?>
<!-- Default WordPress page wrapper -->
<div class="wrap">

	<!-- Page heading -->
	<?php echo sprintf( '<h1 class="wp-heading-inline">%1s %2s</h1>', get_bloginfo( 'name' ), esc_html__( 'Plugin', 'controlled-chaos-plugin' ) ); ?>

	<!-- Page description -->
    <p class="description"><?php esc_html_e( 'A feature-packed WordPress starter plugin for building custom-tailored websites.', 'controlled-chaos-plugin' ); ?></p>

	<!-- Ornamental divider -->
	<hr class="wp-header-end">

	<!-- Begin jQuery tabbed content -->
	<div class="backend-tabbed-content">

		<!-- Begin tabs -->
		<ul>
			<li><!-- Introduction tabs -->
				<a href="#into"><span class="dashicons dashicons-welcome-learn-more"></span> <?php esc_html_e( 'Introduction', 'controlled-chaos-plugin' ); ?></a>
			</li>
			<li><!-- Site Settings tabs -->
				<a href="#settings"><span class="dashicons <?php echo esc_attr( $settings ) ?>"></span> <?php esc_html_e( 'Site Settings', 'controlled-chaos-plugin' ); ?></a>
			</li>
			<li><!-- Script Options tabs -->
				<a href="#scripts"><span class="dashicons dashicons-editor-code"></span> <?php esc_html_e( 'Script Options', 'controlled-chaos-plugin' ); ?></a>
			</li>
			<li><!-- Media Options tabs -->
				<a href="#media"><span class="dashicons dashicons-admin-media"></span> <?php esc_html_e( 'Media Options', 'controlled-chaos-plugin' ); ?></a>
			</li>
			<li><!-- Dev Tools tabs -->
				<a href="#tools"><span class="dashicons dashicons-admin-tools"></span> <?php esc_html_e( 'Development Tools', 'controlled-chaos-plugin' ); ?></a>
			</li>
		</ul><!-- End tabs -->

		<!-- Begin content -->
		<div id="into"><!-- Introduction content -->
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-intro.php'; ?>
		</div>
		<div id="settings"><!-- Site Settings content -->
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-site-settings.php'; ?>
		</div>
		<div id="scripts"><!-- Script Options content -->
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-script-options.php'; ?>
		</div>
		<div id="media"><!-- Media Options content -->
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-media-options.php'; ?>
		</div>
		<div id="tools"><!-- Dev Tools content -->
			<?php include_once plugin_dir_path( __FILE__ ) . 'plugin-page-dev-tools.php'; ?>
		</div><!-- End content -->

	</div><!-- End jQuery tabbed content -->
</div><!-- End WordPress page wrapper -->