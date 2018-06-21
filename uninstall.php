<?php
/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 * 
 * @package   Controlled_Chaos
 * @since     1.0.0
 * @author    Greg Sweet <greg@ccdzine.com>
 * @copyright Copyright © 2018, Greg Sweet
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

/**
 * During uninstallation, remove the custom field from the users
 * and delete the local avatars.
 *
 * @since  1.0.0
 * @return void
 */
function ccp_user_avatars_uninstall() {

	$ccp_user_avatars = new ccp_user_avatars;
	$users            = get_users_of_blog();

	foreach ( $users as $user ) {
		$ccp_user_avatars->avatar_delete( $user->user_id );
	}

	delete_option( 'ccp_user_avatars_caps' );

}
register_uninstall_hook( __FILE__, 'ccp_user_avatars_uninstall' );