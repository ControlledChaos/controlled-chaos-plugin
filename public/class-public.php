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

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The public-facing functionality of the plugin.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/public
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Public {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Frontend dependencies.
		$this->dependencies();

		// Register the stylesheets for the public-facing side of the site.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		
		// Register the JavaScript for the public-facing side of the site.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		// Add meta tags to <head> if not disabled.
		add_action( 'wp_head', [ $this, 'meta_tags' ] );

		// Add Fancybox attributes to attachment page image link.
		add_action( 'wp_footer', [ $this, 'attachment_fancybox' ] );

	}

	/**
	 * Frontend dependencies.
	 * 
	 * @since    1.0.0
	 */
	public function dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'class-head-scripts.php';
		require_once plugin_dir_path( __FILE__ ) . 'class-public-images.php';

		/**
		 * Meta tags.
		 * 
		 * @since    1.0.0
		 */
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-url.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-name.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-type.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-title.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-description.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-image.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-author.php';

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Non-vendor plugin styles.
		wp_enqueue_style( 'controlled-chaos-plugin', plugin_dir_url( __FILE__ ) . 'assets/css/public.css', [], CCP_VERSION, 'all' );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_styles' ) ) {
			wp_enqueue_style( 'controlled-chaos-fancybox', plugin_dir_url( __FILE__ ) . 'assets/css/jquery.fancybox.min.css', [], CCP_VERSION, 'all' );
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_style( 'controlled-chaos-slick', plugin_dir_url( __FILE__ ) . 'assets/css/slick.min.css', [], CCP_VERSION, 'all' );
		}

		// Slick theme.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_style( 'controlled-chaos-slick-theme', plugin_dir_url( __FILE__ ) . 'assets/css/slick-theme.css', [], CCP_VERSION, 'all' );
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			wp_enqueue_style( 'controlled-chaos-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/css/tooltipster.bundle.min.css', [], CCP_VERSION, 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Non-vendor plugin script.
		wp_enqueue_script( 'controlled-chaos-plugin', plugin_dir_url( __FILE__ ) . 'assets/js/public.js', [ 'jquery' ], CCP_VERSION, true );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {
			wp_enqueue_script( 'controlled-chaos-fancybox', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.fancybox.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_script( 'controlled-chaos-slick', plugin_dir_url( __FILE__ ) . 'assets/js/slick.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// Tabslet.
		if ( get_option( 'ccp_enqueue_tabslet' ) ) {
			wp_enqueue_script( 'controlled-chaos-tabslet', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.tabslet.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			wp_enqueue_script( 'controlled-chaos-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/js/tooltipster.bundle.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// FitVids.
		wp_enqueue_script( 'controlled-chaos-fitvids', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.fitvids.min.js', [ 'jquery' ], CCP_VERSION, true );

	}

	/**
	 * Meta tags for SEO and embedded links.
	 * 
	 * @since    1.0.0
	 */
	public function meta_tags() {

		if ( class_exists( 'ACF_Pro' ) ) {

			$disable_tags = get_field( 'ccp_disable_meta_tags', 'option' );

			if ( false == $disable_tags ) {
				
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-tags-standard.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-tags-open-graph.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-tags-twitter.php';

			}

		}

	}

	/**
	 * Add Fancybox attributes to attachment page image link.
	 * 
	 * @since    1.0.0
	 */
	public function attachment_fancybox() {

		if ( is_attachment() && get_option( 'ccp_enqueue_fancybox_script' ) ) { ?>

			<script>
			jQuery(document).ready(function() {
				jQuery('p.attachment > a').attr('data-fancybox', '');
			});
			</script>

		<?php }

	}

}

$ccp_public = new Controlled_Chaos_Public();