<?php
/**
 * Development subpage output.
 * 
 *
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CC_Plugin\Settings_Page_Site;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
} 

// Settings saved notice.
if ( isset( $_GET['settings-updated'] ) ) { ?>
<div id="setting-error-settings_updated" class="notice notice-success is-dismissible">
	<p><strong><?php _e( 'Settings saved.', 'controlled-chaos-plugin' ); ?></strong></p>
</div>
<?php } ?>
<div class="wrap">
	<?php echo sprintf( '<h1 class="wp-heading-inline">%1s %2s</h1>', get_bloginfo( 'name' ), esc_html__( 'Development', 'controlled-chaos-plugin' ) ); ?>
	<p class="description"><?php _e( 'A few tools that come in handy during the development of your website.', 'controlled-chaos-plugin' ); ?></p>
	<hr class="wp-header-end">
	<form action="options.php" method="post">
		<?php settings_fields( 'site-development' );
		do_settings_sections( 'site-development' ); ?>
		<p class="submit"><?php submit_button( __( 'Save Settings', 'controlled-chaos-plugin' ), 'primary', '', false, [] ); ?></p>
    </form>
</div>