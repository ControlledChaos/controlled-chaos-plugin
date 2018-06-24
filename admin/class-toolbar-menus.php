<?php

/**
 * Register menus for the admin bar.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Controlled_Chaos_Plugin\includes
 */

namespace CC_Plugin\Admin_Toolbar;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Adminbar_Menus {

	/**
	 * Constructor method.
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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
	 * @since    1.0.0
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

$ccp_adminbar_menus = new Controlled_Chaos_Adminbar_Menus;