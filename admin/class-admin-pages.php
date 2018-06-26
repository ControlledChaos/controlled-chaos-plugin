<?php
/**
 * New admin pages and admin screen modification.
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
 * New admin pages and admin screen modification.
 *
 * @since  1.0.0
 * @access public
 */
class Admin_Pages {

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

        // Add an about page for the plugin.
        add_action( 'admin_menu', [ $this, 'about_plugin' ] );

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
            add_action( 'manage_pages_custom_column', [ $this, 'image_column_content' ], 10, 2 );
        }

    }

    /**
     * Add an about page for the plugin.
     * 
     * Uses the universal slug partial for admin pages. Set this
     * slug in the core plugin file.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function about_plugin() {

        add_submenu_page(
            'plugins.php', 
            __( 'Site Plugin', 'controlled-chaos-plugin' ),
            __( 'Site Plugin', 'controlled-chaos-plugin' ),
            'manage_options', 
            CCP_ADMIN_SLUG . '-page', 
            [ $this, 'about_plugin_output' ]
        );

    }

    /**
     * Get output of the about page for the plugin.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function about_plugin_output() {

        require plugin_dir_path( __FILE__ ) . 'partials/plugin-page-about.php';

    }

    /**
     * Replace default post title placeholders.
     *
     * @since  1.0.0
	 * @access public
     * @param  object $title Stores the 'Enter title here" placeholder.
	 * @return object Returns the title placeholder.
     * @throws Non-Object Throws an error on attachment edit screens since
     *         there is no placeholder, so that post type is nullified.
     * 
     * @todo   Review this if or when a check becomes available for the
     *         new WordPress block editor (Gutenberg).
     */
    public function title_placeholders( $title ) {

        // Get the current screen as a variable.
        $screen = get_current_screen();

        // Post type: post.
        if ( 'post' == $screen->post_type ) {
            $post_title = esc_html__( 'Post Title', 'controlled-chaos-plugin' );
        
        // Post type: page.
        } elseif ( 'page' == $screen->post_type ) {
            $post_title = esc_html__( 'Page Title', 'controlled-chaos-plugin' );
        
        // Post type: attachment.
        } elseif ( $screen->post_type == 'attachment' ) {
            $post_title = null;
        
        // Post type: custom, unidentified.
        } else {
            $post_title = esc_html__( 'Enter Title', 'controlled-chaos-plugin' );
        }

        // Apply a filter conditional modification.
        $title = apply_filters( 'ccp_post_title_placeholders', $post_title );
        
        // Return the new placeholder.
        return $title;
    }

    /**
     * Add excerpts to pages for use in meta data.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function add_page_excerpts() {

        add_post_type_support( 'page', 'excerpt' );

    }

    /**
     * Make excerpts visible by default if used as meta descriptions.
     * 
     * Add your post types as necessary.
     *
     * @since  1.0.0
	 * @access public
     * @param  array $hidden
     * @param  object $screen
	 * @return array Unsets the hidden value in the screen base array.
     * 
     * @todo   Programmatically apply to all registered post types.
     * @todo   Review this if or when a check becomes available for the
     *         new WordPress block editor (Gutenberg) as the classic
     *         Excerpt metabox will not be displayed.
     */
    public function show_excerpt_metabox( $hidden, $screen ) {

        // Post type screens to show excerpt.
        if ( 'post' == $screen->base || 'page' == $screen->base ) {

            // Look for hidden stuff.
            foreach( $hidden as $key=>$value ) {

                // If the excerpt is hidden, show it.
                if ( 'postexcerpt' == $value ) {
                    unset( $hidden[$key] );
                    break;
                }

            }

        }

        // Return the default for other post types.
        return $hidden;

    }

    /**
	 * Add page break button to visual editor.
     * 
	 * Used for creating a "Read More" link on your blog page and archive pages.
     *
     * @since  1.0.0
	 * @access public
     * @param  array $buttons
     * @param  string $id
     * @return array Returns the TinyMCE buttons array.
     * 
     * @todo   Review this if or when a check becomes available for the
     *         new WordPress block editor (Gutenberg) since page breaks
     *         will be included.
	 */
	public function add_page_break_button( $buttons, $id ) {

		if ( $id !== 'content' ) {
            return $buttons;
        }

        array_splice( $buttons, 13, 0, 'wp_page' );
        
        return $buttons;

	}

    /**
     * Get post thumbnail for use in admin columns.
     *
     * @since  1.0.0
	 * @access private
     * @param int $post_ID Returns the post ID.
     * @return string Returns the path to the featured image.
     */

    // Get featured image.
    private function get_column_image( $post_ID ) {

        // Get the post thumbnail ID as a variable.
        $post_thumbnail_id = get_post_thumbnail_id( $post_ID );

        /**
         * Column thumbnail size.
         * 
         * @see includes/media/class-media.php
         */
        $size  = 'Column Thumbnail';

        // Apply a filter for conditional modification.
        $thumb = apply_filters( 'ccp_column_thumbnail_size', $size );

        // If there is an ID (if the post has a featured image).
        if ( $post_thumbnail_id ) {

            // Get the src for the Thumbnail size.
            $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, $thumb );

            // Return the image src for use below.
            return $post_thumbnail_img[0];

        }

    }

    /**
     * Add a new post admin column for the featured image.
     * 
     * @since  1.0.0
	 * @access public
     * @param  array $defaults Gets the array of default admin columns.
     * @return string Returns the name of the new column head.
     */
    public function image_column_head( $defaults ) {

        // The column heading name.
        $name    = __( 'Featured Image', 'controlled-chaos-plugin' );

        // Apply a filter for conditional modification.
        $heading = apply_filters( 'ccp_image_column_head', $name );

        // The column heading name to new `featured_image` column.
        $defaults['featured_image'] = esc_html__( $heading );

        // Return the heading name.
        return $defaults;

    }

    /**
     * Add the featured image to post admin columns
     * 
     * @since  1.0.0
	 * @access public
     * @param  string $column_name
     * @param  int $post_ID
     * @return string Returns the image tag for the featured image.
     */
    public function image_column_content( $column_name, $post_ID ) {

        // If the column is the `featured_image` column established above.
        if ( 'featured_image' == $column_name ) {

            // Get the image src established above.
            $post_featured_image = $this->get_column_image( $post_ID );

            /**
             * The image tag to be added to the column/post row.
             * 
             * The tag uses a style attribute for the width, and no width
             * or height attributes are used, because the image size may
             * be filtered externally to use a different aspect ratio.
             */

            // If the post has a featured image.
            if ( $post_featured_image ) {
                echo '<img src="' . $post_featured_image . '" style="width: 48px;" />';
            
            // If the post doen't have a featured image then use the fallback image.
            } else {
                echo '<img src="' . plugins_url( 'images/featured-image-placeholder.png', __FILE__ ) . '" style="width: 48px;" />';
            }
            
        }

    }

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_admin_pages() {

	return Admin_Pages::instance();

}

// Run an instance of the class.
ccp_admin_pages();