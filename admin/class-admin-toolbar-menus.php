<?php
/**
 * Register admin toolbar menus.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register menus for the admin toolbar.
 *
 * @since  1.0.0
 * @access public
 */
class Admin_Toolbar_Menus {

	/**
	 * Instance of the class
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the instance.
	 */
	public static function instance() {

		// Varialbe for the instance to be used outside the class.
		static $instance = null;

		if ( is_null( $instance ) ) {

			// Set variable for new instance.
			$instance = new self;

		}

		// Return the instance.
		return $instance;

	}

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

		// Register menus for the admin bar.
		add_action( 'init', [ $this, 'register' ] );

		// Add the menus to the admin toolbar.
		add_action( 'admin_bar_menu', [ $this, 'admin_menu_main' ], 35 );
		add_action( 'admin_bar_menu', [ $this, 'admin_menu_site' ], 35 );
		add_action( 'admin_bar_menu', [ $this, 'admin_menu_account' ], 35 );

		// Add the menus to the frontend toolbar.
		add_action( 'admin_bar_menu', [ $this, 'frontend_menu_main' ], 35 );
		add_action( 'admin_bar_menu', [ $this, 'frontend_menu_site' ], 35 );
		add_action( 'admin_bar_menu', [ $this, 'frontend_menu_account' ], 35 );

	}

	/**
	 * Register menus for the admin bar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {

		register_nav_menus(
			[
			'ccp_admin_toolbar_site'       => esc_html__( 'Admin Toolbar: Site Name', 'controlled-chaos-plugin' ),
			'ccp_admin_toolbar_main'       => esc_html__( 'Admin Toolbar: Main', 'controlled-chaos-plugin' ),
			'ccp_admin_toolbar_account'    => esc_html__( 'Admin Toolbar: My Account', 'controlled-chaos-plugin' ),
			'ccp_frontend_toolbar_site'    => esc_html__( 'Frontend Toolbar: Site Name', 'controlled-chaos-plugin' ),
			'ccp_frontend_toolbar_main'    => esc_html__( 'Frontend Toolbar: Main', 'controlled-chaos-plugin' ),
			'ccp_frontend_toolbar_account' => esc_html__( 'Frontend Toolbar: My Account', 'controlled-chaos-plugin' )
			]
		);

	}

	/**
	 * Menu in the main part of the admin toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu_main( $wp_admin_bar ) {

		if ( is_admin() && is_user_logged_in() && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_admin_toolbar_main' ] ) ) {

			$menu = wp_get_nav_menu_object( $locations[ 'ccp_admin_toolbar_main' ] );

			if ( false != $menu ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {

					if ( $menu_item->classes ) {
						$classes = implode( ' ', $menu_item->classes );
					} else {
						$classes = '';
					}

					$meta = [
						'class'   => $classes,
						'onclick' => '',
						'target'  => $menu_item->target,
						'title'   => $menu_item->attr_title
					];

					if ( $menu_item->menu_item_parent ) {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => $menu_item->menu_item_parent,
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					} else {
						$wp_admin_bar->add_menu(
							[
								'id'    => $menu_item->ID,
								'title' => $menu_item->title,
								'href'  => $menu_item->url,
								'meta'  => $meta
							]
						);
					}
				}
			}
		}

	}

	/**
	 * Menu under the site name in the admin toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu_site( $wp_admin_bar ) {

		if ( is_admin() && is_user_logged_in() && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_admin_toolbar_site' ] ) ) {

			$menu = wp_get_nav_menu_object( $locations[ 'ccp_admin_toolbar_site' ] );

			if ( false != $menu ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {

					if ( $menu_item->classes ) {
						$classes = implode( ' ', $menu_item->classes );
					} else {
						$classes = '';
					}

					$meta = [
						'class'   => $classes,
						'onclick' => '',
						'target'  => $menu_item->target,
						'title'   => $menu_item->attr_title
					];

					if ( $menu_item->menu_item_parent ) {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => $menu_item->menu_item_parent,
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					} else {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => 'site-name',
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					}
				}
			}
		}

	}

	/**
	 * Menu under the account name in the admin toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menu_account( $wp_admin_bar ) {

		if ( is_admin() && is_user_logged_in() && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_admin_toolbar_account' ] ) ) {

			$menu = wp_get_nav_menu_object( $locations[ 'ccp_admin_toolbar_account' ] );

			if ( false != $menu ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {

					if ( $menu_item->classes ) {
						$classes = implode( ' ', $menu_item->classes );
					} else {
						$classes = '';
					}

					$meta = [
						'class'   => $classes,
						'onclick' => '',
						'target'  => $menu_item->target,
						'title'   => $menu_item->attr_title
					];

					if ( $menu_item->menu_item_parent ) {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => $menu_item->menu_item_parent,
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					} else {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => 'my-account',
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					}
				}
			}
		}

	}

	/**
	 * Menu in the main part of the frontend toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_menu_main( $wp_admin_bar ) {

		if ( ! is_admin() && is_user_logged_in() && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_frontend_toolbar_main' ] ) ) {

			$menu = wp_get_nav_menu_object( $locations[ 'ccp_frontend_toolbar_main' ] );

			if ( false != $menu ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {

					if ( $menu_item->classes ) {
						$classes = implode( ' ', $menu_item->classes );
					} else {
						$classes = '';
					}

					$meta = [
						'class'   => $classes,
						'onclick' => '',
						'target'  => $menu_item->target,
						'title'   => $menu_item->attr_title
					];

					if ( $menu_item->menu_item_parent ) {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => $menu_item->menu_item_parent,
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					} else {
						$wp_admin_bar->add_menu(
							[
								'id'    => $menu_item->ID,
								'title' => $menu_item->title,
								'href'  => $menu_item->url,
								'meta'  => $meta
							]
						);
					}
				}
			}
		}


	}

	/**
	 * Menu under the site name in the frontend toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_menu_site( $wp_admin_bar ) {

		if ( ! is_admin() && is_user_logged_in() && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_frontend_toolbar_site' ] ) ) {

			$menu = wp_get_nav_menu_object( $locations[ 'ccp_frontend_toolbar_site' ] );

			if ( false != $menu ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {

					if ( $menu_item->classes ) {
						$classes = implode( ' ', $menu_item->classes );
					} else {
						$classes = '';
					}

					$meta = [
						'class'   => $classes,
						'onclick' => '',
						'target'  => $menu_item->target,
						'title'   => $menu_item->attr_title
					];

					if ( $menu_item->menu_item_parent ) {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => $menu_item->menu_item_parent,
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					} else {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => 'site-name',
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					}
				}
			}
		}

	}

	/**
	 * Menu under the account name in the frontend toolbar.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function frontend_menu_account( $wp_admin_bar ) {

		if ( ! is_admin() && is_user_logged_in() && ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_frontend_toolbar_account' ] ) ) {

			$menu = wp_get_nav_menu_object( $locations[ 'ccp_frontend_toolbar_account' ] );

			if ( false != $menu ) {

				$menu_items = wp_get_nav_menu_items( $menu->term_id );

				foreach ( (array) $menu_items as $key => $menu_item ) {

					if ( $menu_item->classes ) {
						$classes = implode( ' ', $menu_item->classes );
					} else {
						$classes = '';
					}

					$meta = [
						'class'   => $classes,
						'onclick' => '',
						'target'  => $menu_item->target,
						'title'   => $menu_item->attr_title
					];

					if ( $menu_item->menu_item_parent ) {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => $menu_item->menu_item_parent,
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					} else {
						$wp_admin_bar->add_menu(
							[
								'id'     => $menu_item->ID,
								'parent' => 'my-account',
								'title'  => $menu_item->title,
								'href'   => $menu_item->url,
								'meta'   => $meta
							]
						);
					}
				}
			}
		}

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_admin_toolbar_menus() {

	return Admin_Toolbar_Menus::instance();

}

// Run an instance of the class.
ccp_admin_toolbar_menus();