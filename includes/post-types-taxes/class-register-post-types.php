<?php
/**
 * Register post types.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Post_Types_Taxes
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://codex.wordpress.org/Function_Reference/register_post_type
 */

namespace CC_Plugin\Includes\Post_Types_Taxes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register post types.
 *
 * @since  1.0.0
 * @access public
 */
final class Post_Types_Register {

    /**
	 * Constructor magic method.
     *
     * @since  1.0.0
	 * @access public
	 * @return self
	 */
	public function __construct() {

        // Register custom post types.
		add_action( 'init', [ $this, 'register' ] );

	}

    /**
     * Register custom post types.
     *
     * Note for WordPress 5.0 or greater:
     * If you want your post type to adopt the block edit_form_image_editor
     * rather than using the classic editor then set `show_in_rest` to `true`.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function register() {

        /**
         * Post Type: Sample custom post (Custom Posts).
         *
         * Renaming:
         * Search case "Custom Post" and replace with your post type capitalized name.
         * Search case "custom post" and replace with your post type lowercase name.
         * Search case "ccp_post_type" and replace with your post type database name.
         * Search case "custom-posts" and replace with your post type archive permalink slug.
         */

        $labels = [
            'name'                  => __( 'Custom Posts', 'controlled-chaos-plugin' ),
            'singular_name'         => __( 'Custom Post', 'controlled-chaos-plugin' ),
            'menu_name'             => __( 'Custom Posts', 'controlled-chaos-plugin' ),
            'all_items'             => __( 'All Custom Posts', 'controlled-chaos-plugin' ),
            'add_new'               => __( 'Add New', 'controlled-chaos-plugin' ),
            'add_new_item'          => __( 'Add New Custom Post', 'controlled-chaos-plugin' ),
            'edit_item'             => __( 'Edit Custom Post', 'controlled-chaos-plugin' ),
            'new_item'              => __( 'New Custom Post', 'controlled-chaos-plugin' ),
            'view_item'             => __( 'View Custom Post', 'controlled-chaos-plugin' ),
            'view_items'            => __( 'View Custom Posts', 'controlled-chaos-plugin' ),
            'search_items'          => __( 'Search Custom Posts', 'controlled-chaos-plugin' ),
            'not_found'             => __( 'No Custom Posts Found', 'controlled-chaos-plugin' ),
            'not_found_in_trash'    => __( 'No Custom Posts Found in Trash', 'controlled-chaos-plugin' ),
            'parent_item_colon'     => __( 'Parent Custom Post', 'controlled-chaos-plugin' ),
            'featured_image'        => __( 'Featured image for this custom post', 'controlled-chaos-plugin' ),
            'set_featured_image'    => __( 'Set featured image for this custom post', 'controlled-chaos-plugin' ),
            'remove_featured_image' => __( 'Remove featured image for this custom post', 'controlled-chaos-plugin' ),
            'use_featured_image'    => __( 'Use as featured image for this custom post', 'controlled-chaos-plugin' ),
            'archives'              => __( 'Custom Post archives', 'controlled-chaos-plugin' ),
            'insert_into_item'      => __( 'Insert into Custom Post', 'controlled-chaos-plugin' ),
            'uploaded_to_this_item' => __( 'Uploaded to this Custom Post', 'controlled-chaos-plugin' ),
            'filter_items_list'     => __( 'Filter Custom Posts', 'controlled-chaos-plugin' ),
            'items_list_navigation' => __( 'Custom Posts list navigation', 'controlled-chaos-plugin' ),
            'items_list'            => __( 'Custom Posts List', 'controlled-chaos-plugin' ),
            'attributes'            => __( 'Custom Post Attributes', 'controlled-chaos-plugin' ),
            'parent_item_colon'     => __( 'Parent Custom Post', 'controlled-chaos-plugin' ),
        ];

        // Apply a filter to labels for customization.
        $labels = apply_filters( 'ccp_post_type_labels', $labels );

        $options = [
            'label'               => __( 'Custom Posts', 'controlled-chaos-plugin' ),
            'labels'              => $labels,
            'description'         => __( 'Custom post type description.', 'controlled-chaos-plugin' ),
            'public'              => true,
            'publicly_queryable'  => true,
            'show_ui'             => true,
            'show_in_rest'        => false,
            'rest_base'           => 'ccp_post_type_rest_api',
            'has_archive'         => true,
            'show_in_menu'        => true,
			'exclude_from_search' => false,
			// Sets user role levels, accepts array: 'capabilities'        => [],
            'capability_type'     => 'post',
            'map_meta_cap'        => true,
            'hierarchical'        => false,
            'rewrite'             => [
                'slug'       => 'custom-posts',
                'with_front' => true
            ],
            'query_var'           => 'ccp_post_type',
            'menu_position'       => 5,
            'menu_icon'           => 'dashicons-admin-post',
            'supports'            => [
                'title',
                'editor',
                'thumbnail',
                'excerpt',
                'trackbacks',
                'custom-fields',
                'comments',
                'revisions',
                'author',
                'page-attributes',
                'post-formats'
            ],
            'taxonomies'          => [
                'category',
                'post_tag',
                'ccp_taxonomy' // Change to your custom taxonomy name.
            ],
        ];

        // Apply a filter to arguments for customization.
        $options = apply_filters( 'ccp_post_type_args', $options );

        /**
         * Register the post type
         *
         * Maximum 20 characters, cannot contain capital letters or spaces.
         */
        register_post_type(
            'ccp_post_type',
            $options
        );

    }

}

// Run the class.
$ccp_post_types = new Post_Types_Register;