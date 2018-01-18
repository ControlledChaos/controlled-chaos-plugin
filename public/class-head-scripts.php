<?php
/**
 * Script options.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.3
 */

namespace Controlled_Chaos_Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Script options.
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Head_Scripts {

    /**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        // Remove WP versions from stylesheets and scripts.
        add_filter( 'style_loader_src', [ $this, 'remove_ver_css_js' ], 999 );
		add_filter( 'script_loader_src', [ $this, 'remove_ver_css_js' ], 999 );

		// Disable emoji script.
		add_action( 'init', [ $this, 'disable_emojis' ] );

    }

    /**
     * Remove WP versions from stylesheets and scripts.
     */
	public function remove_ver_css_js( $src ) {
        
		if ( get_option( 'ccp_remove_script_verion' ) && strpos( $src, 'ver=' ) ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}

	/**
	 * Disable emoji script.
	 *
	 * @since    1.0.0
	 */
	public function disable_emojis() {

		if ( get_option( 'ccp_remove_emoji_script' ) ) {

			remove_action( 'admin_print_styles', 'print_emoji_styles' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
			remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
			remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
			remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		}

	}

}

$controlled_chaos_head_scripts = new Controlled_Chaos_Head_Scripts;