<?php
/**
 * The frontend functionality of the plugin.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Frontend
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       Slick       https://github.com/kenwheeler/slick
 * @link       Tabslet     https://github.com/vdw/Tabslet
 * @link       Sticky-kit  https://github.com/leafo/sticky-kit
 * @link       Tooltipster https://github.com/iamceege/tooltipster
 * @link       Fancybox    http://fancyapps.com/fancybox/3/
 */

namespace CC_Plugin\Frontend;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Bail if in the admin.
if ( is_admin() ) {
	return;
}

/**
 * The frontend functionality of the plugin.
 *
 * @since  1.0.0
 * @access public
 */
class Frontend {

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

			// Frontend dependencies.
			$instance->dependencies();

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
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function dependencies() {

		require_once plugin_dir_path( __FILE__ ) . 'class-head-scripts.php';

		// Meta tags for SEO.
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-url.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-title.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-description.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-author.php';
		include_once plugin_dir_path( __FILE__ ) . 'meta-tags/class-meta-image.php';

	}

	/**
	 * Enqueue the stylesheets for the frontend of the site.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_styles() {

		// Non-vendor plugin styles.
		wp_enqueue_style( CCP_ADMIN_SLUG, plugin_dir_url( __FILE__ ) . 'assets/css/frontend.css', [], CCP_VERSION, 'all' );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_styles' ) ) {

			/**
			 * Bail if the current theme supports ccd-fancybox by
			 * including its own copy of the Fancybox stylesheet.
			 */
			if ( current_theme_supports( 'ccd-fancybox' ) ) {
				return;
			} else {
				wp_enqueue_style( CCP_ADMIN_SLUG . '-fancybox', plugin_dir_url( __FILE__ ) . 'assets/css/jquery.fancybox.min.css', [], CCP_VERSION, 'all' );
			}
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_style( CCP_ADMIN_SLUG . '-slick', plugin_dir_url( __FILE__ ) . 'assets/css/slick.min.css', [], CCP_VERSION, 'all' );
		}

		// Slick theme.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_style( CCP_ADMIN_SLUG . '-slick-theme', plugin_dir_url( __FILE__ ) . 'assets/css/slick-theme.css', [], CCP_VERSION, 'all' );
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			wp_enqueue_style( CCP_ADMIN_SLUG . '-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/css/tooltipster.bundle.min.css', [], CCP_VERSION, 'all' );
		}

	}

	/**
	 * Add styles inline if option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
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
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function enqueue_scripts() {

		// Non-vendor plugin script. Uncomment to use.
		// wp_enqueue_script( CCP_ADMIN_SLUG, plugin_dir_url( __FILE__ ) . 'assets/js/frontend.js', [ 'jquery' ], CCP_VERSION, true );

		// Fancybox 3.
		if ( get_option( 'ccp_enqueue_fancybox_script' ) ) {
			wp_enqueue_script( CCP_ADMIN_SLUG . '-fancybox', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.fancybox.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// Slick.
		if ( get_option( 'ccp_enqueue_slick' ) ) {
			wp_enqueue_script( CCP_ADMIN_SLUG . '-slick', plugin_dir_url( __FILE__ ) . 'assets/js/slick.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// Tabslet.
		if ( get_option( 'ccp_enqueue_tabslet' ) ) {
			wp_enqueue_script( CCP_ADMIN_SLUG . '-tabslet', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.tabslet.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// Tooltipster.
		if ( get_option( 'ccp_enqueue_tooltipster' ) ) {
			wp_enqueue_script( CCP_ADMIN_SLUG . '-tooltipster', plugin_dir_url( __FILE__ ) . 'assets/js/tooltipster.bundle.min.js', [ 'jquery' ], CCP_VERSION, true );
		}

		// FitVids.
		wp_enqueue_script( CCP_ADMIN_SLUG . '-fitvids', plugin_dir_url( __FILE__ ) . 'assets/js/jquery.fitvids.min.js', [ 'jquery' ], CCP_VERSION, true );

	}

	/**
	 * Deregister jQuery if inline is option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function deregister_jquery() {

		if ( ! is_customize_preview() ) {

			wp_deregister_script( 'jquery' );

		}

	}

	/**
	 * Add jQuery inline if option selected.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @return void
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
	 * Check for the Advanced Custom Fields PRO plugin, or the Options Page
	 * addon for free ACF, then check if meta tags have been disabled from
	 * the ACF 'Site Settings' page. Otherwise check if meta tags have been
	 * disabled from the standard 'Site Settings' page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function meta_tags() {

		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			$disable_tags = get_field( 'ccp_disable_meta_tags', 'option' );

			if ( false == $disable_tags ) {

				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-standard.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-open-graph.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-twitter.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-dublin-core.php';

			}

		} else {

			$disable_tags = get_option( 'ccp_disable_meta' );

			if ( ! $disable_tags ) {

				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-standard.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-open-graph.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-twitter.php';
				include_once plugin_dir_path( __FILE__ ) . 'meta-tags/meta-tags-dublin-core.php';

			}

		}

	}

	/**
	 * Add Fancybox attributes to attachment page image link.
	 *
	 * You may want to minimize the script for production sites.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function attachment_fancybox() {

		if ( is_attachment() && get_option( 'ccp_enqueue_fancybox_script' ) ) { ?>

			<script>
			jQuery(document).ready(function() {
				jQuery( 'p.attachment > a' ).attr( 'data-fancybox', '' );
			});
			</script>

		<?php }

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_frontend() {

	return Frontend::instance();

}

// Run an instance of the class.
ccp_frontend();