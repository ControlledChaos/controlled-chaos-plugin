<?php

/**
 * Register menus for the admin bar.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */

namespace Controlled_Chaos_Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Adminbar_Menus {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

		// Register menus for the admin bar.
		add_action( 'init', [ $this, 'register' ] );

		// Add the menus to the addmin bar.
		add_action( 'admin_bar_menu', [ $this, 'add_menus' ], 35 );

	}

	/**
	 * Register menus for the admin bar.
	 *
	 * @since    1.0.0
	 */
	public function register() {

		register_nav_menus(
			[
			'ccp_admin_menu_site'    => esc_html__( 'Toolbar Menu (Site Name)', 'ccp-plugin' ),
			'ccp_admin_menu_main'    => esc_html__( 'Toolbar Menu (Main)', 'ccp-plugin' ),
			'ccp_admin_menu_account' => esc_html__( 'Toolbar Menu (My Account)', 'ccp-plugin' )
			]
		);

	}

	/**
	 * Add the menus to the addmin bar.
	 * 
	 * @since    1.0.0
	 */
	public function add_menus() {
		
		global $wp_admin_bar;

		/**
		 * Site name menu.
		 */
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_admin_menu_site' ] ) ) {

			$menu_site = wp_get_nav_menu_object( $locations[ 'ccp_admin_menu_site' ] );

			if ( false != $menu_site ) {

				$menu_items = wp_get_nav_menu_items( $menu_site->term_id );

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
		
		/**
		 * Admin bar main menu.
		 */
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_admin_menu_main' ] ) ) {

			$menu_main = wp_get_nav_menu_object( $locations[ 'ccp_admin_menu_main' ] );

			if ( false != $menu_main ) {

				$menu_items = wp_get_nav_menu_items( $menu_main->term_id );

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
		
		/**
		 * Account menu.
		 */
		if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ 'ccp_admin_menu_account' ] ) ) {

			$menu_account = wp_get_nav_menu_object( $locations[ 'ccp_admin_menu_account' ] );

			if ( false != $menu_account ) {

				$menu_items = wp_get_nav_menu_items( $menu_account->term_id );

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