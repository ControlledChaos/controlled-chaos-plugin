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

namespace CCPlugin\Register_Post_Types;

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
         * 
         * Renaming:
         * Search case "Custom Post" and replace with your post type name.
         * Search case "custom post" and replace with your post type name.
         */

        $labels = [
            'name'                  => __( 'Custom Posts', 'controlled-chaos' ),
            'singular_name'         => __( 'Custom Post', 'controlled-chaos' ),
            'menu_name'             => __( 'Custom Posts', 'controlled-chaos' ),
            'all_items'             => __( 'All Custom Posts', 'controlled-chaos' ),
            'add_new'               => __( 'Add New', 'controlled-chaos' ),
            'add_new_item'          => __( 'Add New Custom Post', 'controlled-chaos' ),
            'edit_item'             => __( 'Edit Custom Post', 'controlled-chaos' ),
            'new_item'              => __( 'New Custom Post', 'controlled-chaos' ),
            'view_item'             => __( 'View Custom Post', 'controlled-chaos' ),
            'view_items'            => __( 'View Custom Posts', 'controlled-chaos' ),
            'search_items'          => __( 'Search Custom Posts', 'controlled-chaos' ),
            'not_found'             => __( 'No Custom Posts Found', 'controlled-chaos' ),
            'not_found_in_trash'    => __( 'No Custom Posts Found in Trash', 'controlled-chaos' ),
            'parent_item_colon'     => __( 'Parent Custom Post', 'controlled-chaos' ),
            'featured_image'        => __( 'Featured image for this custom post', 'controlled-chaos' ),
            'set_featured_image'    => __( 'Set featured image for this custom post', 'controlled-chaos' ),
            'remove_featured_image' => __( 'Remove featured image for this custom post', 'controlled-chaos' ),
            'use_featured_image'    => __( 'Use as featured image for this custom post', 'controlled-chaos' ),
            'archives'              => __( 'Custom Post archives', 'controlled-chaos' ),
            'insert_into_item'      => __( 'Insert into Custom Post', 'controlled-chaos' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Custom Post', 'controlled-chaos' ),
            'filter_items_list'     => __( 'Filter Custom Posts', 'controlled-chaos' ),
            'items_list_navigation' => __( 'Custom Posts list navigation', 'controlled-chaos' ),
            'items_list'            => __( 'Custom Posts List', 'controlled-chaos' ),
            'attributes'            => __( 'Custom Post Attributes', 'controlled-chaos' ),
            'parent_item_colon'     => __( 'Parent Custom Post', 'controlled-chaos' ),
        ];

        $args = [
            'label'               => __( 'Custom Posts', 'controlled-chaos' ),
            'labels'              => $labels,
            'description'         => __( 'Custom post type description.', 'controlled-chaos' ),
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

        /**
         * Uncomment to register.
         * 
         * register_post_type( 'ccp_post_type', $args );
         */
        
    }

}

$ccp_post_types = new Controlled_Chaos_Post_Types_Register;