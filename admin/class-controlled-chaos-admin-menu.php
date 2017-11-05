<?php

/**
 * Admin menu functions.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 */

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Admin menu functions.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Admin_Menu {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled-chaos
	 * @param      string    $version
	 */
    public function __construct() {

        // Move the menu items.
        add_action( 'admin_menu', [ $this, 'move_menu_items' ] );

        // Set the new parent file URL.
        add_filter( 'parent_file', [ $this, 'set_parent_file' ] );

        // Set the user capability for the pages.
        add_filter( 'user_has_cap', [ $this, 'set_capability' ], 20, 4 );

    }

    /**
     * Move the menu items.
     * 
     * @since    1.0.0
     */
    public function move_menu_items() {
    
        global $submenu, $menu;
        
        if ( isset( $submenu['themes.php'] ) ) {
    
            foreach ( $submenu['themes.php'] as $key => $item ) {
                if ( $item[2] === 'nav-menus.php' ) {
                    unset($submenu['themes.php'][$key] );
                }
                if ( $item[2] === 'widgets.php' ) {
                    unset( $submenu['themes.php'][$key] );
                }
            }
        }

        $user = wp_get_current_user();

        if ( in_array( 'editor', $user->roles ) ) {
            unset( $menu[60] );
        }

        add_menu_page( __( 'Menus', 'controlled-chaos' ), __( 'Menus', 'controlled-chaos' ), 'delete_others_pages', 'nav-menus.php', '', 'dashicons-list-view', 61 );
        add_menu_page( __( 'Widgets', 'controlled-chaos' ), __( 'Widgets', 'controlled-chaos' ), 'delete_others_pages', 'widgets.php', '', 'dashicons-welcome-widgets-menus', 62 );
    }
    
    /**
     * Set the new parent file URL.
     * 
     * @since    1.0.0
     */
    public function set_parent_file( $parent_file ) {

        global $current_screen;
    
        if ( $current_screen->base == 'nav-menus' ) {
            $parent_file = 'nav-menus.php';
        }

        if ( $current_screen->base == 'widgets' ) {
            $parent_file = 'widgets.php';
        }
        return $parent_file;

    }
    
    /**
     * Set the user capability for the pages.
     * 
     * @since    1.0.0
     */
    public function set_capability( $caps, $cap, $args, $user ) {

        $url = $_SERVER['REQUEST_URI'];
    
        if ( strpos( $url, 'nav-menus.php' ) !== false && in_array( 'edit_theme_options', $cap ) && in_array( 'editor', $user->roles ) ) {
            $caps['edit_theme_options'] = true;
        }

        if ( strpos( $url, 'widgets.php' ) !== false && in_array( 'edit_theme_options', $cap ) && in_array( 'editor', $user->roles ) ) {
            $caps['edit_theme_options'] = true;
        }

        return $caps;

    }

}

$controlled_chaos_admin_menu = new Controlled_Chaos_Admin_Menu;