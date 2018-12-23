<?php
/**
 * New admin pages and admin screen modification.
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
 * New admin pages and admin screen modification.
 *
 * @since  1.0.0
 * @access public
 */
class Admin_Pages {

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

        // Add an about page for the plugin.
        add_action( 'admin_menu', [ $this, 'about_plugin' ] );

        // Add admin header.
        if ( ccp_acf_options() ) {

            // If the ACF free plus the Options Page addon or Pro plugin is active.
            $admin_header = get_field( 'ccp_use_admin_header', 'option' );
        } else {

            // Otherwise look for the WP API setting.
            $admin_header = get_option( 'ccp_use_admin_header' );
        }

        // If admin header option s selected.
		if ( $admin_header ) {

            // Register admin menu.
            add_action( 'after_setup_theme', [ $this, 'admin_menus' ] );

            // Include the admin header template.
            add_action( 'in_admin_header', [ $this, 'admin_header' ] );

            // Include the admin header template.
            add_action( 'admin_head', [ $this, 'admin_header_layout' ] );
        }

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
         *
         * @link https://wordpress.org/plugins/codepress-admin-columns/
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
     * Adds a contextual help section.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     *
     * @todo   Sync up the ACF and WP menu position settings.
     */
    public function about_plugin() {

        /**
         * Get the menu position of the plugin page.
         *
         * @since  1.0.0
         * @return bool Returns true or false for both ACF field and WP field.
         */

        // If ACF is active, get the field from the ACF options page.
        if ( ccp_acf_options() ) {

            // Get the field.
            $acf_position = get_field( 'ccp_site_plugin_link_position', 'option' );

            // Return true if the field is set to `top`.
            if ( 'top' == $acf_position ) {
                $position = true;

            // Otherwise return `false`.
            } else {
                $position = false;
            }

        // If ACF is not active, get the field from the WordPress/ClassicPress options page.
        } else {

            // Get the field.
            $position = get_option( 'ccp_site_plugin_link_position' );
        }

        /**
         * Get the menu label for the plugin page.
         *
         * @since  1.0.0
         * @return string Returns the text of the label.
         */

        // If ACF is active, get the field from the ACF options page.
        if ( ccp_acf_options() ) {

            // Get the field.
            $link_label = get_field( 'ccp_site_plugin_link_label', 'option' );

        // If ACF is not active, get the field from the WordPress/ClassicPress options page.
        } else {

            // Get the field.
            $link_label = sanitize_text_field( get_option( 'ccp_site_plugin_link_label' ) );
        }

        // If one of the label fields above is not empty the use that label.
        if ( $link_label ) {
            $label = $link_label;

        // Otherwise use Site Plugin as the label.
        }  else {
            $label = __( 'Site Plugin', 'controlled-chaos-plugin' );
        }

        /**
         * Get the menu icon for the plugin page.
         *
         * Applies only if menu position is set to top level.
         *
         * @since  1.0.0
         * @return string Returns a CSS class of Dashicons icon.
         */

        // If ACF is active, get the field from the ACF options page.
        if ( ccp_acf_options() ) {

            // Get the field.
            $link_icon  = get_field( 'ccp_site_plugin_link_icon', 'option' );

        // If ACF is not active, get the field from the WordPress/ClassicPress options page.
        } else {

            // Get the field.
            $link_icon  = sanitize_text_field( get_option( 'ccp_site_plugin_link_icon' ) );
        }

        // If one of the icon fields above is not empty the use that CSS class.
        if ( $link_icon ) {
            $icon = $link_icon;

        // Otherwise use the scholar's cap icon to imply instruction.
        }  else {
            $icon = __( 'dashicons-welcome-learn-more', 'controlled-chaos-plugin' );
        }

        if ( true == $position ) {
            $this->help_about_plugin = add_menu_page(
                $label,
                $label,
                'manage_options',
                CCP_ADMIN_SLUG . '-page',
                [ $this, 'about_plugin_output' ],
                $icon,
                3
            );
        } else {
            $this->help_about_plugin = add_submenu_page(
                'plugins.php',
                $label,
                $label,
                'manage_options',
                CCP_ADMIN_SLUG . '-page',
                [ $this, 'about_plugin_output' ]
            );
        }

        // Add content to the Help tab.
		add_action( 'load-' . $this->help_about_plugin, [ $this, 'help_about_plugin' ] );

    }

    /**
     * Get output of the about page for the plugin.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function about_plugin_output() {

        require CCP_PATH . 'admin/partials/plugin-page-about.php';

    }

    /**
     * Add tabs to the about page contextual help section.
	 *
	 * @since      1.0.0
     */
    public function help_about_plugin() {

		// Add to the about page.
		$screen = get_current_screen();
		if ( $screen->id != $this->help_about_plugin ) {
			return;
		}

		// More information tab.
		$screen->add_help_tab( [
			'id'       => 'help_plugin_info',
			'title'    => __( 'More Information', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_plugin_info' ]
		] );

        // Convert plugin tab.
		$screen->add_help_tab( [
			'id'       => 'help_convert_plugin',
			'title'    => __( 'Convert Plugin', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_convert_plugin' ]
		] );

        // Add a help sidebar.
		$screen->set_help_sidebar(
			$this->help_about_page_sidebar()
		);

    }

    /**
     * Get more information help tab content.
	 *
	 * @since      1.0.0
     */
	public function help_plugin_info() {

		include_once CCP_PATH . 'admin/partials/help/help-plugin-info.php';

    }

    /**
     * Get convert plugin help tab content.
	 *
	 * @since      1.0.0
     */
	public function help_convert_plugin() {

		include_once CCP_PATH . 'admin/partials/help/help-plugin-convert.php';

    }

    /**
     * The about page contextual tab sidebar content.
	 *
	 * @since      1.0.0
     */
    public function help_about_page_sidebar() {

        $html  = sprintf( '<h4>%1s</h4>', __( 'Author Credits', 'controlled-chaos-plugin' ) );
        $html .= sprintf(
            '<p>%1s %2s.</p>',
            __( 'This plugin was originally written by', 'controlled-chaos-plugin' ),
            'Greg Sweet'
        );
        $html .= sprintf(
            '<p>%1s <br /><a href="%2s" target="_blank">%3s</a> <br />%4s</p>',
            __( 'Visit:', 'controlled-chaos-plugin' ),
            'http://ccdzine.com/',
            'Controlled Chaos Design',
            __( 'for more free downloads.', 'controlled-chaos-plugin' )
        );
        $html .= sprintf(
            '<p>%1s</p>',
            __( 'Change this sidebar to give yourself credit for the hard work you did customizing this plugin.', 'controlled-chaos-plugin' )
         );

		return $html;

    }

    /**
	 * Register admin menu if the admin header option is selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function admin_menus() {

		register_nav_menus( [
			'admin-header' => __( 'Admin Header Menu', 'controlled-chaos-plugin' )
		] );

	}

    /**
	 * Adds a header to admin pages if the option is selected.
     *
     * First looks in the active theme for a template:
     * template-parts/admin/admin-header.php
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the HTML for the admin header.
	 */
	public function admin_header() {

        $admin_header = locate_template( 'template-parts/admin/admin-header.php' );

		if ( ! empty( $admin_header ) ) {
			get_template_part( 'template-parts/admin/admin-header' );
		} else {
			include_once CCP_PATH . 'admin/partials/admin-header.php';
		}

    }

    /**
	 * Add layout CSS if admin header is used.
     *
     * Repositions the screen options and help tabs to top
     * of the page, above the header.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the HTML for the admin header.
	 */
	public function admin_header_layout() {

        // Begin the style block.
        $style = '<style>';

        // Make relative for putting screen options and help tabs at top.
        $style .= '#wpcontent { position: relative }';

        // Reset relative position.
        $style .= '#wpbody { position: static }';

        // Position screen meta content at top.
        $style .= '#screen-meta { position: absolute; top: 0; left: 0; width: 100%; padding-top: 30px; z-index: 1000 }';

        // Screen meta links position for RTL languages.
        $style .= '.rtl #screen-meta { left: auto; right: 0; }';

        // Position screen meta links at top, z-index above screen meta content.
        $style .= '#screen-meta-links { position: absolute; top: 0; right: 0; z-index: 1001 }';

        // Screen meta links position for RTL languages.
        $style .= '.rtl #screen-meta-links { left: 0; right: auto; }';

        // Add a top border to help because of top padding.
        $style .= '#contextual-help-back { border-top: 1px solid #e1e1e1 }';

        /**
         * Block editor styles.
         */
        $style .= '.block-editor__container { position: static }';
        // $style .= '.edit-post-header { position: sticky }';
        // $style .= '.edit-post-layout { padding-top: 0; }';
        // $style .= '.edit-post-sidebar { top: 32px; }';
        $style .= '.gutenberg-editor-page .ccp-admin-header { padding-left: 20px; }';
        $style .= '.gutenberg-editor-page .ccp-admin-header:before { content: ""; display: block; width: 100%; height: 56px; }';

        // End the style block.
        $style .= '</style>';

        // Apply a filter for custom admin themeing.
        $style = apply_filters( 'ccp_admin_header_layout', $style );

        // Render all styles.
        echo $style;

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
                echo '<img src="' . esc_url( $post_featured_image ) . '" style="width: 48px;" />';

            // If the post doen't have a featured image then use the fallback image.
            } else {
                echo '<img src="' . esc_url( plugins_url( 'assets/images/featured-image-placeholder.png', __FILE__ ) ) . '" style="width: 48px;" />';
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