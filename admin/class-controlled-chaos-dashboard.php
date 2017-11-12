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

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Dashboard {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled-chaos
	 * @param      string    $version
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

        // remove_action( 'welcome_panel', 'wp_welcome_panel' );

        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
        // unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
        unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
        unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);

        remove_meta_box( 'dashboard_activity', 'dashboard', 'normal' );

    }

}

$controlled_chaos_bashboard = new Controlled_Chaos_Dashboard;