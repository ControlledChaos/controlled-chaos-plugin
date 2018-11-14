<?php
/**
 * Admin menu functions.
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
 * Admin menu functions.
 *
 * @since  1.0.0
 * @access public
 */
class Admin_Menu {

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

        // Remove menu items.
        add_action( 'admin_menu', [ $this, 'hide' ] );

        // Hide ACF field groups UI.
        if ( ccp_acf_options() ) {

            $options = get_field( 'ccp_admin_hide_links', 'option' );
            if ( $options && in_array( 'fields', $options ) ) {
                add_filter( 'acf/settings/show_admin', '__return_false' );
            }

        }

        /**
         * Show/Hide Links Manager link.
         */

        // Get links option.
        if ( ccp_acf_options() ) {
            $links = get_field( 'ccp_links_manager', 'option' );
        } else {
            $links = get_option( 'ccp_hide_links' );
        }

        // Return links filter.
        if ( $links ) {
            add_filter( 'pre_option_link_manager_enabled', '__return_true' );
        } else {
            add_filter( 'pre_option_link_manager_enabled', '__return_false' );
        }


        // Move the Menus & Widgets menu items.
        add_action( 'admin_menu', [ $this, 'menus_widgets' ] );

        // Set the new parent file URL.
        add_filter( 'parent_file', [ $this, 'set_parent_file' ] );

        // Set the user capability for the pages.
        add_filter( 'user_has_cap', [ $this, 'set_capability' ], 20, 4 );

    }

    /**
     * Remove menu items.
     *
     * Check for the Advanced Custom Fields PRO plugin, or the Options Page
	 * addon for free ACF. Use ACF options from the ACF 'Site Settings' page,
     * otherwise use the options from the standard 'Site Settings' page.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function hide() {

        /**
         * If Advanced Custom Fields is active.
         */
        if ( ccp_acf_options() ) {

            // Get the multiple checkbox field.
            $options = get_field( 'ccp_admin_hide_links', 'option' );

            // Hide Appearance link.
            if ( $options && in_array( 'themes', $options ) ) {
                remove_menu_page( 'themes.php' );
            }

            // Hide Plugins link.
            if ( $options && in_array( 'plugins', $options ) ) {
                remove_menu_page( 'plugins.php' );
            }

            // Hide Users link.
            if ( $options && in_array( 'users', $options ) ) {
                remove_menu_page( 'users.php' );
            }

            // Hide Tools link.
            if ( $options && in_array( 'tools', $options ) ) {
                remove_menu_page( 'tools.php' );
            }

        } else {

            /**
             * If Advanced Custom Fields is not active.
             */

            // Get options.
            $appearance = get_option( 'ccp_hide_appearance' );
            $plugins    = get_option( 'ccp_hide_plugins' );
            $users      = get_option( 'ccp_hide_users' );
            $tools      = get_option( 'ccp_hide_tools' );

            // Hide Appearance link.
            if ( $appearance ) {
                remove_menu_page( 'themes.php' );
            }

            // Hide Plugins link.
            if ( $plugins ) {
                remove_menu_page( 'plugins.php' );
            }

            // Hide Users link.
            if ( $users ) {
                remove_menu_page( 'users.php' );
            }

            // Hide Tools link.
            if ( $tools ) {
                remove_menu_page( 'tools.php' );
            }

        }

    }

    /**
     * Menus and Widgets menu position.
     *
     * Check for the Advanced Custom Fields PRO plugin, or the Options Page
	 * addon for free ACF. Use ACF options from the ACF 'Site Settings' page,
     * otherwise use the options from the standard 'Site Settings' page.
     *
     * @since  1.0.0
	 * @access public
     * @global array menu The admin menu array.
     * @global array submenu The admin submenu array.
	 * @return void
     */
    public function menus_widgets() {

        global $menu, $submenu;

        // If ACF is active.
        if ( ccp_acf_options() ) {

            // Get the ACF field registered by this plugin.
            $menus_link   = get_field( 'ccp_menus_position', 'option' );
            $widgets_link = get_field( 'ccp_widgets_position', 'option' );

            // Remove Menus and Widgets as submenu items of Appearances.
            if ( isset( $submenu['themes.php'] ) ) {

                // Look for menu items under Appearances.
                foreach ( $submenu['themes.php'] as $key => $item ) {

                    // Unset Menus if it is found.
                    if ( $item[2] === 'nav-menus.php' && 'default' != $menus_link ) {
                        unset($submenu['themes.php'][$key] );
                    }

                    // Unset Widgets if it is found.
                    if ( $item[2] === 'widgets.php' && 'default' != $widgets_link ) {
                        unset( $submenu['themes.php'][$key] );
                    }

                }

            }

            // Get the current user info.
            $user = wp_get_current_user();

            // If the user can access the theme editor, remove that page.
            if ( in_array( 'editor', $user->roles ) ) {
                unset( $menu[60] );
            }

            // Add a new top-level Menus page.
            if ( 'default' != $menus_link ) {
                add_menu_page(
                    __( 'Menus', 'controlled-chaos-plugin' ),
                    __( 'Menus', 'controlled-chaos-plugin' ),
                    'delete_others_pages',
                    'nav-menus.php',
                    '',
                    'dashicons-list-view',
                    61
                );
            }

            // Add a new top-level Widgets page.
            if ( 'default' != $widgets_link ) {
                add_menu_page(
                    __( 'Widgets', 'controlled-chaos-plugin' ),
                    __( 'Widgets', 'controlled-chaos-plugin' ),
                    'delete_others_pages',
                    'widgets.php',
                    '',
                    'dashicons-welcome-widgets-menus',
                    62
                );
            }

        // If ACF is not active.
        } else {

            // Get the options from the standard fields.
            $menus_link   = get_option( 'ccp_menus_position' );
            $widgets_link = get_option( 'ccp_widgets_position' );

            // Remove Menus and Widgets as submenu items of Appearances.
            if ( isset( $submenu['themes.php'] ) ) {

                // Look for menu items under Appearances.
                foreach ( $submenu['themes.php'] as $key => $item ) {

                    // Unset Menus if it is found.
                    if ( $item[2] === 'nav-menus.php' && $menus_link ) {
                        unset($submenu['themes.php'][$key] );
                    }

                    // Unset Widgets if it is found.
                    if ( $item[2] === 'widgets.php' && $widgets_link ) {
                        unset( $submenu['themes.php'][$key] );
                    }

                }

            }

            // Get the current user info.
            $user = wp_get_current_user();

            // If the user can access the theme editor, remove that page.
            if ( in_array( 'editor', $user->roles ) ) {
                unset( $menu[60] );
            }

            // Add a new top-level Menus page.
            if ( $menus_link ) {
                add_menu_page(
                    __( 'Menus', 'controlled-chaos-plugin' ),
                    __( 'Menus', 'controlled-chaos-plugin' ),
                    'delete_others_pages',
                    'nav-menus.php',
                    '',
                    'dashicons-list-view',
                    61
                );
            }

            // Add a new top-level Widgets page.
            if ( $widgets_link ) {
                add_menu_page(
                    __( 'Widgets', 'controlled-chaos-plugin' ),
                    __( 'Widgets', 'controlled-chaos-plugin' ),
                    'delete_others_pages',
                    'widgets.php',
                    '',
                    'dashicons-welcome-widgets-menus',
                    62
                );
            }

        }
    }

    /**
     * Set the new Menus and Widgets parent file URL.
     *
     * Check for the Advanced Custom Fields PRO plugin, or the Options Page
	 * addon for free ACF. Use ACF options from the ACF 'Site Settings' page,
     * otherwise use the options from the standard 'Site Settings' page.
     *
     * @since  1.0.0
	 * @access public
     * @param  object $parent_file Looks for a parent of the current screen.
     * @global object current_screen Holds the result of WP_Screen.
	 * @return array Returns the parent page in admin page array (appearances or self).
     */
    public function set_parent_file( $parent_file ) {

        // Get the current screen to check for parent.
        global $current_screen;

        // If ACF is active.
        if ( ccp_acf_options() ) {

            // Get the ACF field registered by this plugin.
            $menus_link   = get_field( 'ccp_menus_position', 'option' );
            $widgets_link = get_field( 'ccp_widgets_position', 'option' );

            // Set Menus parent as self.
            if ( $current_screen->base == 'nav-menus' && 'default' != $menus_link ) {
                $parent_file = 'nav-menus.php';
            }

            // Set Widgets parent as self.
            if ( $current_screen->base == 'widgets' && 'default' != $widgets_link ) {
                $parent_file = 'widgets.php';
            }

            // Return the new parent URL.
            return $parent_file;

        // If ACF is not active.
        } else {

            // Get the options from the standard fields.
            $menus_link   = get_option( 'ccp_menus_position' );
            $widgets_link = get_option( 'ccp_widgets_position' );

            // Set Menus parent as self.
            if ( $current_screen->base == 'nav-menus' && $menus_link ) {
                $parent_file = 'nav-menus.php';
            }

            // Set Widgets parent as self.
            if ( $current_screen->base == 'widgets' && $widgets_link ) {
                $parent_file = 'widgets.php';
            }

            // Return the new parent URL.
            return $parent_file;

        }

    }

    /**
     * Set the user capability for the new Menus and Widgets pages.
     *
     * @since  1.0.0
	 * @access public
     * @param  array $caps Current user capabilities.
     * @param  mixed $cap Allowed user role.
     * @param  array $args Arguments for admin menu entries.
     * @param  object $user Current user info.
	 * @return array Returns the new capabilities.
     */
    public function set_capability( $caps, $cap, $args, $user ) {

        // Get the URL requented by the user.
        $url = $_SERVER['REQUEST_URI'];

        // Allow Editors access to the Menus page.
        if ( strpos( $url, 'nav-menus.php' ) !== false && in_array( 'edit_theme_options', $cap ) && in_array( 'editor', $user->roles ) ) {
            $caps['edit_theme_options'] = true;
        }

        // Allow Editors access to the Widgets page.
        if ( strpos( $url, 'widgets.php' ) !== false && in_array( 'edit_theme_options', $cap ) && in_array( 'editor', $user->roles ) ) {
            $caps['edit_theme_options'] = true;
        }

        // Return the new capabilities.
        return $caps;

    }

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_admin_menu() {

	return Admin_Menu::instance();

}

// Run an instance of the class.
ccp_admin_menu();