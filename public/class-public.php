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

namespace CCPlugin\Plugin_Public;

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

		// Get inline options.
		$jquery  = get_option( 'ccp_inline_jquery' );
		$scripts = get_option( 'ccp_inline_scripts' );
		$styles  = get_option( 'ccp_inline_styles' );

		// Enqueue styles or add them inline.
		if ( $styles ) {
			add_action( 'wp_head', [ $this, 'get_styles' ] );
		} else {
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_styles' ] );
		}

		/**
		 * Enqueue scripts or add them inline.
		 */

		// Inline jQuery.
		if ( $jquery ) {
			add_action( 'wp_enqueue_scripts', [ $this, 'deregister_jquery' ] );
			add_action( 'wp_footer', [ $this, 'get_jquery' ], 1 );
		}

		if ( $scripts ) {
			add_action( 'wp_footer', [ $this, 'get_scripts' ], 11 );
		} else {
			add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		}		

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

			/**
			 * Bail if the current theme supports ccd-fancybox by
			 * including its own copy of the Fancybox stylesheet.
			 */
			if ( current_theme_supports( 'ccd-fancybox' ) ) {
				return;
			} else {
				wp_enqueue_style( 'controlled-chaos-fancybox', plugin_dir_url( __FILE__ ) . 'assets/css/jquery.fancybox.min.css', [], CCP_VERSION, 'all' );
			}
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
	 * Add styles inline if option selected.
	 *
	 * @since    1.0.0
	 */
	public function get_styles() {

		$fancybox    = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/css/jquery.fancybox.min.css' ) );
		$slick       = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/css/slick.min.css' ) );
		$slick_theme = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/css/slick-theme.min.css' ) );
		$tooltipster = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/css/tooltipster.bundle.min.css' ) );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_styles' ) ) {

			/**
			 * Bail if the current theme supports ccd-fancybox by
			 * including its own copy of the Fancybox stylesheet.
			 */
			if ( current_theme_supports( 'ccd-fancybox' ) ) {
				return;
			} else {
				echo '<!-- Fancybox 3 Scripts --><style>' . $fancybox . '</style>';
			}
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			echo '<!-- Slick Scripts --><style>' . $slick . '</style>';
		}

		// Slick theme.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			echo '<!-- Tabslet Scripts --><style>' . $slick_theme . '</style>';
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			echo '<!-- Tooltipster Scripts --><style>' . $tooltipster . '</style>';
		}

	}

	/**
	 * Enqueue scripts traditionally by default.
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
	 * Deregister jQuery if inline is option selected.
	 *
	 * @since    1.0.0
	 */
	public function deregister_jquery() {

		if ( ! is_customize_preview() ) {

			wp_deregister_script( 'jquery' );

		}

	}

	/**
	 * Add jQuery inline if option selected.
	 *
	 * @since    1.0.0
	 */
	public function get_jquery() {

		if ( ! is_customize_preview() ) {

			$jquery = file_get_contents( plugin_dir_path( __FILE__ ) . '/assets/js/jquery.min.js' );

			echo '<!-- jQuery --><script>' . $jquery . '</script>';

		}

	}

	/**
	 * Add scripts inline if option selected.
	 *
	 * @since    1.0.0
	 */
	public function get_scripts() {

		$fancybox    = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/js/jquery.fancybox.min.js' ) );
		$slick       = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/js/slick.min.js' ) );
		$tabslet     = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/js/jquery.tabslet.min.js' ) );
		$tooltipster = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/js/tooltipster.bundle.min.js' ) );
		$stickykit   = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/js/sticky-kit.min.js' ) );
		$fitvids     = file_get_contents( esc_html( plugin_dir_path( __FILE__ ) . 'assets/js/jquery.fitvids.min.js' ) );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {
			echo '<!-- Fancybox 3 Scripts --><script>' . $fancybox . '</script>';
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			echo '<!-- Slick Scripts --><script>' . $slick . '</script>';
		}

		// Tabslet.
		if ( get_option( 'ccp_enqueue_tabslet' ) ) {
			echo '<!-- Tabslet Scripts --><script>' . $tabslet . '</script>';
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			echo '<!-- Tooltipster Scripts --><script>' . $tooltipster . '</script>';
		}

		// Sticky-kit.
		if ( get_option( 'ccp_enqueue_stickykit' ) ) {
			echo '<!-- Sticky-kit Scripts --><script>' . $stickykit . '</script>';
		}

		// FitVids.
		if ( ! is_front_page() ) {
			echo '<!-- FitVids Scripts --><script>' . $fitvids . '</script>';
		}

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

		} else {

			$disable_tags = get_option( 'ccp_disable_meta' );

			if ( ! $disable_tags ) {
				
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

// Run the public class.
$ccp_public = new Controlled_Chaos_Public();