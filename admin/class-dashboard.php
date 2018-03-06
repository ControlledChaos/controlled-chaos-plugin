<?php

/**
 * Dashboard functions.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 */

namespace CCPlugin\Dashboard;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Dashboard {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        // "At a Glance" dashboard widget.
        add_action( 'dashboard_glance_items', [ $this, 'at_glance' ] );

        // Remove metaboxes.
        add_action( 'wp_dashboard_setup', [ $this, 'metaboxes' ] );

    }

    /**
     * Add custom post types to "At a Glance" dashboard widget.
     *
     * @since    1.0.0
     */
    public function at_glance() {

        $args = [
            'public'   => true,
            '_builtin' => false
        ];
        $output     = 'object';
        $operator   = 'and';
        $post_types = get_post_types( $args, $output, $operator );

        foreach ( $post_types as $post_type ) {

            $num_posts = wp_count_posts( $post_type->name );
            $num       = number_format_i18n( $num_posts->publish );
            $text      = _n( $post_type->labels->singular_name, $post_type->labels->name, intval( $num_posts->publish ) );

            if ( current_user_can( 'edit_posts' ) ) {
                $output = '<a href="edit.php?post_type=' . $post_type->name . '">' . $num . ' ' . $text . '</a>';
                    echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
                } else {
                $output = '<span>' . $num . ' ' . $text . '</span>';
                    echo '<li class="post-count ' . $post_type->name . '-count">' . $output . '</li>';
                }
        }

    }

    /**
     * Remove Dashboard metaboxes.
     *
     * @since    1.0.0
     */
    public function metaboxes() {

        global $wp_meta_boxes;

        /**
         * If Advanced Custom Fields Pro is active.
         */
        if ( class_exists( 'ACF_Pro' ) ) {

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

}

$controlled_chaos_bashboard = new Controlled_Chaos_Dashboard;