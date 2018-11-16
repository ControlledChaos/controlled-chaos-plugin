<?php
/**
 * Dashboard functionality.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin\Dashboard
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin\Dashboard;

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

            // Require the class files.
			$instance->dependencies();

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

        // "At a Glance" dashboard widget.
        add_action( 'dashboard_glance_items', [ $this, 'at_glance' ] );

        // Remove metaboxes.
        add_action( 'wp_dashboard_setup', [ $this, 'metaboxes' ] );

        // Remove contextual help content.
        add_action( 'admin_head', [ $this, 'remove_help' ] );

        // Add contextual help content.
        add_action( 'admin_head', [ $this, 'add_help' ] );

        // Enqueue dashboard stylesheet.
        add_action( 'admin_enqueue_scripts', [ $this, 'styles' ] );

    }

    /**
	 * Class dependency files.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

        // Get the dashboard widget class.
        require CCP_PATH . 'admin/dashboard/class-dashboard-widget.php';

        // Get the welcome panel class.
        require CCP_PATH . 'admin/dashboard/class-welcome.php';

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
        if ( ccp_acf_options() ) {

            // Get the multiple checkbox field.
            $hide = get_field( 'ccp_dashboard_hide_widgets', 'option' );

            // Hide the Welcome panel.
            if ( $hide && in_array( 'welcome', $hide ) ) {
                remove_action( 'welcome_panel', 'wp_welcome_panel' );
            }

            // Hide the try Gutenberg panel.
            $editor = get_field( 'ccp_classic_editor', 'option' );
            if ( ( $hide && in_array( 'gutenberg', $hide ) ) || $editor ) {
                remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
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
            $gutenberg  = get_option( 'ccp_hide_try_gutenberg' );
            $editor     = get_option( 'ccp_classic_editor' );
            $wp_news    = get_option( 'ccp_hide_wp_news' );
            $quickpress = get_option( 'ccp_hide_quickpress' );
            $at_glance  = get_option( 'ccp_hide_at_glance' );
            $activity   = get_option( 'ccp_hide_activity' );

            // Hide the Welcome panel.
            if ( $welcome ) {
                remove_action( 'welcome_panel', 'wp_welcome_panel' );
            }

            // Hide the try Gutenberg panel.
            if ( $gutenberg || $editor ) {
                remove_action( 'try_gutenberg_panel', 'wp_try_gutenberg_panel' );
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
        $screen->remove_help_tab( 'help-navigation' );

        // Remove the help sidebar.
        $screen->set_help_sidebar(
			null
		);

    }

    /**
     * Add contextual help content.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function add_help() {

        // Get the screen ID to target the Dashboard.
        $screen = get_current_screen();

        // Bail if not on the Dashboard screen.
        if ( $screen->id != 'dashboard' ) {
			return;
        }

        // Dashboard widget tab.
		$screen->add_help_tab( [
			'id'       => 'help_welcome_panel',
			'title'    => __( 'Welcome Panel', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_welcome_panel' ]
        ] );

        // Dashboard widget tab.
		$screen->add_help_tab( [
			'id'       => 'help_dashboard_widgets',
			'title'    => __( 'Dashboard Widgets', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_dashboard_widgets' ]
		] );

        // Add a new sidebar.
		$screen->set_help_sidebar(
			$this->help_dashboard_sidebar()
		);

    }

    /**
     * Get welcome panel help tab content.
	 *
	 * @since      1.0.0
     */
	public function help_welcome_panel() {

        include_once CCP_PATH . 'admin/dashboard/partials/help/help-welcome-panel.php';

    }

    /**
     * Get dashboard widget help tab content.
	 *
	 * @since      1.0.0
     */
	public function help_dashboard_widgets() {

        include_once CCP_PATH . 'admin/dashboard/partials/help/help-dashboard-widgets.php';

    }

    /**
     * The dashboard widget contextual tab sidebar content.
     *
     * Uses the universal slug partial for admin pages. Set this
     * slug in the core plugin file.
	 *
	 * @since      1.0.0
     */
    public function help_dashboard_sidebar() {

        $html  = sprintf(
            '<h4>%1s %2s</h4>',
            __( 'Custom Dashboard for', 'controlled-chaos-plugin' ),
             get_bloginfo( 'name' )
        );

        $html .= '<hr />';

        $html .= sprintf(
            '<p>%1s <a href="%2s">%3s</a></p>',
            __( 'Customize your' ),
            esc_url( 'http://localhost/controlledchaos/wp-admin/index.php?page=' . CCP_ADMIN_SLUG . '-settings' ),
            __( 'Dashboard Settings' )
        );

		return $html;

	}

    /**
	 * Enqueue dashboard stylesheet.
     *
     * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function styles() {

        // Get the screen ID to target the Dashboard.
        $screen = get_current_screen();

        // Enqueue only on the Dashboard screen.
        if ( $screen->id == 'dashboard' ) {
            wp_enqueue_style( CCP_ADMIN_SLUG . '-dashboard', CCP_URL .  'admin/dashboard/assets/css/dashboard.min.css', [], null, 'screen' );
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
function ccp_dashboard() {

	return Dashboard::instance();

}

// Run an instance of the class.
ccp_dashboard();