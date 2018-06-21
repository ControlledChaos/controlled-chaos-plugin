<?php

/**
 * Register custom editor blocks.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage Controlled_Chaos\includes/editor-blocks
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register custom editor blocks.
 *
 * @since      1.0.0
 * @package    controlled-chaos
 * @subpackage Controlled_Chaos\includes/editor-blocks
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Register_Blocks {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		// Enqueue sample block backend assets.
		add_action( 'enqueue_block_editor_assets', [ $this, 'sample_block_editor_assets' ] );

		// Enqueue sample block frontend assets.
		add_action( 'enqueue_block_assets', [ $this, 'sample_block_frontend_assets' ] );

	}

	/**
	 * Enqueue sample block backend assets.
	 * 
	 * `wp-blocks`: includes block type registration and related functions.
	 * `wp-element`: includes the WordPress Element abstraction for describing the structure of your blocks.
	 * `wp-i18n`: To internationalize the block's text.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function sample_block_editor_assets() {

		// Sample block scripts.
		wp_enqueue_script(
			'ccp-sample-block-script', // Handle.
			plugins_url( 'assets/js/sample-block.min.js', __FILE__ ), // Block.js: We register the block here.
			[ 'wp-blocks', 'wp-i18n', 'wp-element' ], // Dependencies, defined above.
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/js/sample-block.min.js' ) // filemtime — Gets file modification time.
		);

		// Sample block styles.
		wp_enqueue_style(
			'ccp-sample-block', // Handle.
			plugins_url( 'assets/css/sample-block.min.css', __FILE__ ), // Block editor CSS.
			[ 'wp-edit-blocks' ], // Dependency to include the CSS after it.
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/sample-block.min.css' ) // filemtime — Gets file modification time.
		);

	}

	/**
	 * Enqueue sample block frontend assets.
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function sample_block_frontend_assets() {

		wp_enqueue_style(
			'ccp-sample-block',
			plugins_url( 'assets/css/sample-block.css', __FILE__ ),
			[ 'wp-blocks' ],
			filemtime( plugin_dir_path( __FILE__ ) . 'assets/css/sample-block.css' )
		);

	}

}

$ccp_register_blocks = new Controlled_Chaos_Register_Blocks();