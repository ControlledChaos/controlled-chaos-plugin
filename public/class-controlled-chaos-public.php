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

namespace Controlled_Chaos;

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

		// Add Fancybox data attributes to image links in the content.
		add_filter( 'the_content', [ $this, 'fancybox_single_images' ], 2 );

	}

	/**
	 * Add Fancybox data attributes to image links in the content.
	 */
	public function fancybox_single_images( $content ) {

		// Check the page for link images direct to image (no trailing attributes).
		$string = '/<a href="(.*?).(jpg|jpeg|png|gif|bmp|ico)"><img(.*?)class="(.*?)wp-image-(.*?)" \/><\/a>/i';
		preg_match_all( $string, $content, $matches, PREG_SET_ORDER );

		// Check which attachment is referenced.
		foreach ( $matches as $val ) {

			$slimbox_caption = '';

			$post            = get_post( $val[5] );
			$slimbox_caption = esc_attr( $post->post_content );

			// Replace the instance with the lightbox and title(caption) references. Won't fail if caption is empty.
			$string  = '<a href="' . $val[1] . '.' . $val[2] . '"><img' . $val[3] . 'class="' . $val[4] . 'wp-image-' . $val[5] . '" /></a>';
			$replace = '<a href="' . $val[1] . '.' . $val[2] . '" data-fancybox data-type="image" title="' . $slimbox_caption . '"><img' . $val[3] . 'class="' . $val[4] . 'wp-image-' . $val[5] . '" /></a>';
			
			$fancy_content = str_replace( $string, $replace, $content );

			return $fancy_content;

		}

		return $content;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		// Non-vendor plugin styles.
		wp_enqueue_style( $this->controlled_chaos . '-plugin', plugin_dir_url( __FILE__ ) . 'css/controlled-chaos-public.css', [], $this->version, 'all' );

		// Fancybox 3.
		wp_enqueue_style( $this->controlled_chaos . '-fancybox', plugin_dir_url( __FILE__ ) . 'css/jquery.fancybox.min.css', [], $this->version, 'all' );

		// Slick.
		wp_enqueue_style( $this->controlled_chaos . '-slick', plugin_dir_url( __FILE__ ) . 'css/slick.min.css', [], $this->version, 'all' );

		// Slick theme.
		wp_enqueue_style( $this->controlled_chaos . '-slick-theme', plugin_dir_url( __FILE__ ) . 'css/slick-theme.css', [], $this->version, 'all' );

		// Tooltipster.
		wp_enqueue_style( $this->controlled_chaos . '-tooltipster', plugin_dir_url( __FILE__ ) . 'css/tooltipster.bundle.min.css', [], $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		// Non-vendor plugin script.
		wp_enqueue_script( $this->controlled_chaos, plugin_dir_url( __FILE__ ) . 'js/controlled-chaos-public.js', [ 'jquery' ], $this->version, true );

		// Fancybox 3.
		wp_enqueue_script( $this->controlled_chaos . '-fancybox', plugin_dir_url( __FILE__ ) . 'js/jquery.fancybox.min.js', [ 'jquery' ], $this->version, true );

		// Slick.
		wp_enqueue_script( $this->controlled_chaos . '-slick', plugin_dir_url( __FILE__ ) . 'js/slick.min.js', [ 'jquery' ], $this->version, true );

		// Tabslet.
		wp_enqueue_script( $this->controlled_chaos . '-tabslet', plugin_dir_url( __FILE__ ) . 'js/jquery.tabslet.min.js', [ 'jquery' ], $this->version, true );

		// Tooltipster.
		wp_enqueue_script( $this->controlled_chaos . '-tooltipster', plugin_dir_url( __FILE__ ) . 'js/tooltipster.bundle.min.js', [ 'jquery' ], $this->version, true );

		// FitVids.
		wp_enqueue_script( $this->controlled_chaos . '-fitvids', plugin_dir_url( __FILE__ ) . 'js/jquery.fitvids.min.js', [ 'jquery' ], $this->version, true );

	}

}
