<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/public
 */

namespace Controlled_Chaos_Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/public
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $controlled-chaos    The ID of this plugin.
	 */
	private $controlled_chaos;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled-chaos       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $controlled_chaos, $version ) {

		$this->controlled_chaos = $controlled_chaos;
		$this->version = $version;

		// Frontend dependencies.
		$this->dependencies();

		// Add meta tags to <head> if not disabled.
		if ( class_exists( 'ACF_Pro' ) ) {
			$disable_tags = get_field( 'ccp_disable_meta_tags', 'option' );

			if ( ! $disable_tags ) {
				add_action( 'wp_head', [ $this, 'meta_tags' ] );
			}
		} else {
			add_action( 'wp_head', [ $this, 'meta_tags' ] );
		}

	}

	/**
	 * Frontend dependencies.
	 */
	public function dependencies() {

		require plugin_dir_path( __FILE__ ) . 'class-head-scripts.php';
		require plugin_dir_path( __FILE__ ) . 'class-public-images.php';

		/**
		 * Meta tags.
		 * 
		 * @since    1.0.4
		 */
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-url.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-name.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-type.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-title.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-description.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-image.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-author.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-bookmarks.php';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Non-vendor plugin styles.
		wp_enqueue_style( $this->controlled_chaos . '-plugin', plugin_dir_url( __FILE__ ) . 'assets/css/public.css', [], $this->version, 'all' );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_styles' ) ) {
			wp_enqueue_style( $this->controlled_chaos . '-fancybox', plugin_dir_url( __FILE__ ) . 'assets/css/jquery.fancybox.min.css', [], $this->version, 'all' );
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_style( $this->controlled_chaos . '-slick', plugin_dir_url( __FILE__ ) . 'assets/css/slick.min.css', [], $this->version, 'all' );
		}

		// Slick theme.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_style( $this->controlled_chaos . '-slick-theme', plugin_dir_url( __FILE__ ) . 'assets/css/slick-theme.css', [], $this->version, 'all' );
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			wp_enqueue_style( $this->controlled_chaos . '-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/css/tooltipster.bundle.min.css', [], $this->version, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Non-vendor plugin script.
		wp_enqueue_script( $this->controlled_chaos, plugin_dir_url( __FILE__ ) . 'assets/js/public.js', [ 'jquery' ], $this->version, true );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {
			wp_enqueue_script( $this->controlled_chaos . '-fancybox', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.fancybox.min.js', [ 'jquery' ], $this->version, true );
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_script( $this->controlled_chaos . '-slick', plugin_dir_url( __FILE__ ) . 'assets/js/slick.min.js', [ 'jquery' ], $this->version, true );
		}

		// Tabslet.
		if ( get_option( 'ccp_enqueue_tabslet' ) ) {
			wp_enqueue_script( $this->controlled_chaos . '-tabslet', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.tabslet.min.js', [ 'jquery' ], $this->version, true );
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			wp_enqueue_script( $this->controlled_chaos . '-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/js/tooltipster.bundle.min.js', [ 'jquery' ], $this->version, true );
		}

		// FitVids.
		wp_enqueue_script( $this->controlled_chaos . '-fitvids', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.fitvids.min.js', [ 'jquery' ], $this->version, true );

	}

	/**
	 * Meta tags for SEO and embedded links.
	 */
	public function meta_tags() {
		
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-tags-standard.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-tags-open-graph.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-tags-twitter.php';

	}

}