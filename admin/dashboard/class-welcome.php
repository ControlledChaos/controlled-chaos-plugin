<?php
/**
 * Welcome panel functionality.
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
 * Welcome panel functionality.
 *
 * @since  1.0.0
 * @access public
 */
class Welcome {

	/**
	 * Get an instance of the plugin class.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return object Returns the instance.
	 */
	public static function instance() {

		// Variable for the instance to be used outside the class.
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
	 * @return void // Constructor method is empty.
	 */
    public function __construct() {

		// Remove the welcome panel dismiss button.
		$dismiss = get_option( 'ccp_remove_welcome_dismiss' );
		if ( $dismiss ) {
			add_action( 'admin_head', [ $this, 'dismiss' ] );
		}

		// Register the welcome panel areas.
		add_action( 'widgets_init', [ $this, 'widget_areas' ], 25 );

		// Use the custom Welcome panel if option selected.
		$welcome = get_option( 'ccp_custom_welcome' );
		if ( $welcome ) {
			remove_action( 'welcome_panel', 'wp_welcome_panel' );
			add_action( 'welcome_panel', [ $this, 'welcome_panel' ], 25 );
		}

	}

	/**
	 * Remove the welcome panel dismiss button if option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dismiss() {

		$dismiss = '
			<style>
				/*
				* Welcome panel user dismiss option
				* is disabled in the Customizer
				*/
				a.welcome-panel-close, #wp_welcome_panel-hide, .metabox-prefs label[for="wp_welcome_panel-hide"] {
					display: none !important;
				}
				.welcome-panel {
					display: block !important;
				}
			</style>
			';

		echo $dismiss;

	}

	/**
	 * Register the welcome panel areas.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function widget_areas() {

		register_sidebar( [
			'name'          => __( 'Welcome Panel - First Area', 'controlled-chaos-plugin' ),
			'id'            => 'ccp_welcome_widget_first',
			'description'   => __( '', 'controlled-chaos-plugin' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		] );

		register_sidebar( [
			'name'          => __( 'Welcome Panel - Second Area', 'controlled-chaos-plugin' ),
			'id'            => 'ccp_welcome_widget_second',
			'description'   => __( '', 'controlled-chaos-plugin' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		] );

		register_sidebar( [
			'name'          => __( 'Welcome Panel - Third Area', 'controlled-chaos-plugin' ),
			'id'            => 'ccp_welcome_widget_last',
			'description'   => __( '', 'controlled-chaos-plugin' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3>',
			'after_title'   => '</h3>',
		] );

	}

	/**
	 * Remove the welcome panel dismiss button if option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function welcome_panel() {

		include_once plugin_dir_path( __FILE__ ) . 'partials/welcome-panel.php';

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_welcome() {

	return Welcome::instance();

}

// Run an instance of the class.
ccp_welcome();