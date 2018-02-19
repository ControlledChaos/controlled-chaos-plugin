<?php

/**
 * Register post types.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 */



// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Post_Types_Register {

    /**
	 * Constructor magic method.
	 */
	public function __construct() {

        // Register custom post types.
		add_action( 'init', [ $this, 'register' ] );

	}

    /**
     * Register custom post types.
     */
    public function register() {

        /**
         * Post Type: Sample custom post (Custom Posts).
         * 
         * See reference page:
         * https://codex.wordpress.org/Function_Reference/register_post_type
         */

        $labels = [
            'name'                  => __( 'Custom Posts', 'ccp-plugin' ),
            'singular_name'         => __( 'Custom Post', 'ccp-plugin' ),
            'menu_name'             => __( 'Custom Posts', 'ccp-plugin' ),
            'all_items'             => __( 'All Custom Posts', 'ccp-plugin' ),
            'add_new'               => __( 'Add New', 'ccp-plugin' ),
            'add_new_item'          => __( 'Add New Custom Post', 'ccp-plugin' ),
            'edit_item'             => __( 'Edit Custom Post', 'ccp-plugin' ),
            'new_item'              => __( 'New Custom Post', 'ccp-plugin' ),
            'view_item'             => __( 'View Custom Post', 'ccp-plugin' ),
            'view_items'            => __( 'View Custom Posts', 'ccp-plugin' ),
            'search_items'          => __( 'Search Custom Posts', 'ccp-plugin' ),
            'not_found'             => __( 'No Custom Posts Found', 'ccp-plugin' ),
            'not_found_in_trash'    => __( 'No Custom Posts Found in Trash', 'ccp-plugin' ),
            'parent_item_colon'     => __( 'Parent Custom Post', 'ccp-plugin' ),
            'featured_image'        => __( 'Featured image for this custom post', 'ccp-plugin' ),
            'set_featured_image'    => __( 'Set featured image for this custom post', 'ccp-plugin' ),
            'remove_featured_image' => __( 'Remove featured image for this custom post', 'ccp-plugin' ),
            'use_featured_image'    => __( 'Use as featured image for this custom post', 'ccp-plugin' ),
            'archives'              => __( 'Custom Post archives', 'ccp-plugin' ),
            'insert_into_item'      => __( 'Insert into Custom Post', 'ccp-plugin' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Custom Post', 'ccp-plugin' ),
            'filter_items_list'     => __( 'Filter Custom Posts', 'ccp-plugin' ),
            'items_list_navigation' => __( 'Custom Posts list navigation', 'ccp-plugin' ),
            'items_list'            => __( 'Custom Posts List', 'ccp-plugin' ),
            'attributes'            => __( 'Custom Post Attributes', 'ccp-plugin' ),
            'parent_item_colon'     => __( 'Parent Custom Post', 'ccp-plugin' ),
        ];

        $args = [
            'label'               => __( 'Custom Posts', 'ccp-plugin' ),
            'labels'              => $labels,
            'description'         => __( 'Custom post type description.', 'ccp-plugin' ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_rest'        => false,
            'rest_base'           => 'ccp_post_type_rest_api',
            'has_archive'         => true,
            'show_in_menu'        => true,
            'exclude_from_search' => false,
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical'        => false,
            'rewrite'             => [
                'slug'       => 'custom-posts',
                'with_front' => true
            ],
            'query_var'           => 'ccp_post_type',
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-lightbulb',
            'supports'            => false,
            'taxonomies'          => [
                'category',
                'post_tag'
            ],
        ];

        register_post_type( 'ccp_post_type', $args );
    }

}

$ccp_post_types = new Controlled_Chaos_Post_Types_Register;