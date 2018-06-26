<?php
/**
 * Dashboard functionality.
 *
 * @package    Controlled_Chaos
 * @subpackage Controlled_Chaos_Plugin\Admin
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
 * Dashboard functionality.
 * 
 * @since  1.0.0
 * @access public
 */
class Dashboard {

    /**
	 * Get an instance of the plugin class.
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
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

        // "At a Glance" dashboard widget.
        add_action( 'dashboard_glance_items', [ $this, 'at_glance' ] );

        // Remove metaboxes.
        add_action( 'wp_dashboard_setup', [ $this, 'metaboxes' ] );

        // Remove contextual help content.
        add_action( 'admin_head', [ $this, 'remove_help' ] );

    }

    /**
     * Add custom post types to "At a Glance" dashboard widget.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function at_glance() {

        // Post type query arguments.
        $args       = [
            'public'   => true,
            '_builtin' => false
        ];

        // The type of output to return, either 'names' or 'objects'.
        $output     = 'object';

        // The operator (and/or) to use with multiple $args.
        $operator   = 'and';

        // Get post types according to above.
        $post_types = get_post_types( $args, $output, $operator );

        // Prepare an entry for each post type mathing the query.
        foreach ( $post_types as $post_type ) {
            
            // Count the number of posts.
            $count  = wp_count_posts( $post_type->name );

            // Get the number of published posts.
            $number = number_format_i18n( $count->publish );

            // Get the plural or single name based on the count.
            $name   = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $count->publish ) );

            // Supply an edit link if the user can edit posts.
            if ( current_user_can( 'edit_posts' ) ) {
                echo sprintf( 
                    '<li class="post-count %1s-count"><a href="edit.php?post_type=%2s">%3s %4s</a></li>', 
                    $post_type->name, 
                    $post_type->name, 
                    $number, 
                    $name
                );

            // Otherwise just the count and post type name.
            } else {
                echo sprintf( 
                    '<li class="post-count %1s-count">%2s %3s</li>', 
                    $post_type->name, 
                    $number, 
                    $name
                );

            }
        }

    }

    /**
     * Remove Dashboard metaboxes.
     * 
     * Check for the Advanced Custom Fields PRO plugin, or the Options Page
	 * addon for free ACF. Use ACF options from the ACF 'Site Settings' page,
     * otherwise use the options from the standard 'Site Settings' page.
     *
     * @since  1.0.0
	 * @access public
     * @global array wp_meta_boxes The metaboxes array holds all the widgets for wp-admin.
	 * @return void
     */
    public function metaboxes() {

        global $wp_meta_boxes;

        // If Advanced Custom Fields Pro is active.
        if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

            // Get the multiple checkbox field.
            $hide = get_field( 'ccp_dashboard_hide_widgets', 'option' );

            // Hide the Welcome panel.
            if ( $hide && in_array( 'welcome', $hide ) ) {
                remove_action( 'welcome_panel', 'wp_welcome_panel' );
            }

            // Hide the WordPress News widget.
            if ( $hide && in_array( 'news', $hide ) ) {
                unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
            }

            // Hide Quick Draft (QuickPress) widget.
            if ( $hide && in_array( 'quick', $hide ) ) {
                unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );
            }

            // Hide At a Glance widget.
            if ( $hide && in_array( 'at_glance', $hide ) ) {
                unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
            }

            // Hide Activity widget.
            if ( $hide && in_array( 'activity', $hide ) ) {
                remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
            }
        
        // If Advanced Custom Fields is not active.
        } else {

            /**
             * Get WordPress fields, not ACF.
             */

            // Get options.
            $welcome    = get_option( 'ccp_hide_welcome' );
            $wp_news    = get_option( 'ccp_hide_wp_news' );
            $quickpress = get_option( 'ccp_hide_quickpress' );
            $at_glance  = get_option( 'ccp_hide_at_glance' );
            $activity   = get_option( 'ccp_hide_activity' );

            // Hide the Welcome panel.
            if ( $welcome ) {
                remove_action( 'welcome_panel', 'wp_welcome_panel' );
            }

            // Hide the WordPress News widget.
            if ( $wp_news ) {
                unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
            }

            // Hide Quick Draft (QuickPress) widget.
            if ( $quickpress ) {
                unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
            }

            // Hide At a Glance widget.
            if ( $at_glance ) {
                unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
            }

            // Hide Activity widget.
            if ( $activity ) {
                remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );
            }

        }

    }

    /**
     * Remove contextual help content.
     * 
     * Much of the default help content does not apply to 
     * the cleaned up Dashboard so we'll remove it.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function remove_help() {

        // Get the screen ID to target the Dashboard.
        $screen = get_current_screen();
        
        // Bail if not on the Dashboard screen.
        if ( $screen->id != 'dashboard' ) {
			return;
		}
        
        // Remove individual content tabs.
        $screen->remove_help_tab( 'overview' );
        $screen->remove_help_tab( 'help-content' );
        $screen->remove_help_tab( 'help-layout' );

        // Remove the help sidebar.
        $screen->set_help_sidebar(
			null
		);

    }

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_dashboard() {

	return Dashboard::instance();

}

// Run an instance of the class.
ccp_dashboard();