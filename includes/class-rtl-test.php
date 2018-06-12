<?php
/**
 * From the RTL-Tester plugin.
 *
 * Adds a button to the admin bar that allow super admins to switch the text direction of the site.
 * 
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 *
 * @package RTL_Tester
 * @author Automattic
 * @author Yoav Farhi
 * @link http://wordpress.org/extend/plugins/rtl-tester/
 */

/**
 * RTL Test class.
 * 
 * Throws an error if namespaced.
 *
 * @since      1.0.0
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */
class Controlled_Chaos_RTL_Test {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		add_action( 'init', [ $this, 'set_direction' ] );
		add_action( 'admin_bar_menu', [ $this, 'admin_bar_rtl_switcher' ], 999 );

	}

	/**
	 * Add a switcher button to the admin toolbar.
	 * 
	 * @since    1.0.0
	 * @global object $wp_admin_bar Most likely instance of WP_Admin_Bar but this is filterable.
	 * @return null Returns early if capability check isn't matched, or admin bar should not be showing.
	 */
	public function admin_bar_rtl_switcher() {

		global $wp_admin_bar;

		$required_cap = apply_filters( 'rtl_tester_capability_check', 'activate_plugins' );

		if ( ! current_user_can( $required_cap ) || ! is_admin_bar_showing() )
	      return;

		// Get opposite direction for button text.
		if ( is_rtl() ) {
			$direction = 'ltr';
		} else {
			$direction = 'rtl';
		}

		// Add the link in the toolbar.
		$wp_admin_bar->add_menu(
			[
				'id'    => 'RTL',
		 		'title' => sprintf( __( 'Switch to %s', 'controlled-chaos' ), strtoupper( $direction ) ),
		 		'href'  => add_query_arg( [ 'd' => $direction ] )
			]
		);

	}

	/**
	 * Save the currently chosen direction on a per-user basis.
	 *
	 * @global WP_Locale $wp_locale Locale object.
	 * @global WP_Styles $wp_styles Styles object.
	 */
	public function set_direction() {

		global $wp_locale, $wp_styles;

		$_user_id = get_current_user_id();

		if ( isset( $_GET['d'] ) ) {
			$direction = $_GET['d'] == 'rtl' ? 'rtl' : 'ltr';

			update_user_meta( $_user_id, 'rtladminbar', $direction );
		} else {
			$direction = get_user_meta( $_user_id, 'rtladminbar', true );

			if ( false === $direction ) {
				$direction = isset( $wp_locale->text_direction ) ? $wp_locale->text_direction : 'ltr';
			}
		}

		$wp_locale->text_direction = $direction;

		if ( ! is_a( $wp_styles, 'WP_Styles' ) ) {
			$wp_styles = new WP_Styles();
		}

		$wp_styles->text_direction = $direction;

	}

}

// Run the class.
$ccp_rtl_test = new Controlled_Chaos_RTL_Test;