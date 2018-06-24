<?php
/**
 * Development subpage output.
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
} ?>
<div class="wrap">
	<?php echo sprintf( '<h1>%1s %2s</h1>', get_bloginfo( 'name' ), esc_html__( 'Development', 'controlled-chaos-plugin' ) ); ?>
	<p class="description"><?php _e( 'A few tools that come in handy during the development of your website.', 'controlled-chaos-plugin' ); ?></p>
	<form action="options.php" method="post">
		<?php settings_fields( 'layout-testing' );
		do_settings_sections( 'layout-testing' ); ?>
		<p class="submit"><?php submit_button( __( 'Save Settings', 'controlled-chaos-plugin' ), 'primary', '', false, [] ); echo ' '; ?></p>
    </form>
</div>