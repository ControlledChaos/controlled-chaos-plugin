<?php
/**
 * Functions for post types and taxonomies.
 *
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace Controlled_Chaos_Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Admin_Pages {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        // Replace default post title placeholders.
        add_filter( 'enter_title_here', [ $this, 'title_placeholders' ] );

        // Add excerpts to pages for use in meta data.
        add_action( 'init', [ $this, 'add_page_excerpts' ] );

        // Show excerpt metabox by default.
        add_filter( 'default_hidden_meta_boxes', [ $this, 'show_excerpt_metabox' ], 10, 2 );

        // Add page break button to visual editor.
		add_filter( 'mce_buttons', [ $this, 'add_page_break_button' ], 1, 2 );

        /**
         * Add featured image to admin post columns only if
         * Admin Columns free or pro plugin not activated.
         */
        if ( ! class_exists( 'CPAC' ) || ! class_exists( 'ACP_Full' ) ) {
            add_filter( 'manage_posts_columns', [ $this, 'image_column_head' ] );
            add_filter( 'manage_pages_columns', [ $this, 'image_column_head' ] );
            add_action( 'manage_posts_custom_column', [ $this, 'image_column_content' ], 10, 2 );
        }

        add_action( 'admin_head', [ $this, 'remove_help_tabs' ] );

    }

    /**
     * Replace default post title placeholders.
     *
     * @since    1.0.0
     */
    public function title_placeholders( $title ) {

        $screen = get_current_screen();

        // Post type edit screens.
        if ( 'post' == $screen->post_type ) {
            $post_title = esc_html__( 'Post Title', 'controlled-chaos' );
        } elseif ( 'page' == $screen->post_type ) {
            $post_title = esc_html__( 'Page Title', 'controlled-chaos' );
        } else {
            $post_title = esc_html__( 'Enter Title', 'controlled-chaos' );
        }

        // Apply a filter.
        $title = apply_filters( 'ccp_post_title_placeholders', $post_title );
        return $title;
    }

    /**
     * Add excerpts to pages for use in meta data.
     *
     * @since    1.0.0
     */
    public function add_page_excerpts() {

        add_post_type_support( 'page', 'excerpt' );

    }

    /**
     * Make excerpts visible by default if used as meta descriptions.
     *
     * @since    1.0.0
     */
    public function show_excerpt_metabox( $hidden, $screen ) {

        if ( 'post' == $screen->base || 'page' == $screen->base ) {
            foreach( $hidden as $key=>$value ) {
                if ( 'postexcerpt' == $value ) {
                    unset( $hidden[$key] );
                    break;
                }
            }
        }

        return $hidden;

    }

    /**
	 * Add page break button to visual editor.
	 * Used for creating a "Read More" link on your blog page and archive pages.
     *
     * @since    1.0.0
	 */
	public function add_page_break_button( $buttons, $id ) {

		if ( $id !== 'content' ) {
            return $buttons;
        }

		array_splice( $buttons, 13, 0, 'wp_page' );
        return $buttons;

	}

    /**
     * Add featured image to admin post columns.
     *
     * @since    1.0.0
     */

    // Get featured image.
    private function get_column_image( $post_ID ) {

        $post_thumbnail_id = get_post_thumbnail_id( $post_ID );

        if ( $post_thumbnail_id ) {
            $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );

            return $post_thumbnail_img[0];
        }

    }

    // Add new column.
    public function image_column_head( $defaults ) {

        $defaults['featured_image'] = esc_html__( 'Featured Image', 'controlled-chaos' );
        return $defaults;
    }

    // Show featured image
    public function image_column_content( $column_name, $post_ID ) {

        if ( 'featured_image' == $column_name ) {
            $post_featured_image = $this::get_column_image( $post_ID );

            if ( $post_featured_image ) {
                echo '<img src="' . $post_featured_image . '" style="width: 48px;" />';
            } else {
                echo '<img src="' . plugins_url( 'images/featured-image-placeholder.png', __FILE__ ) . '" style="width: 48px;" />';
            }
        }

    }

    public function remove_help_tabs() {

        if ( class_exists( 'ACF_Pro' ) ) {

            if ( true == get_field( 'ccp_remove_help_tabs', 'option' ) ) {

                $screen = get_current_screen();
                $screen->remove_help_tabs();

            }

        }

    }

}

$controlled_chaos_admin_pages = new Controlled_Chaos_Admin_Pages;