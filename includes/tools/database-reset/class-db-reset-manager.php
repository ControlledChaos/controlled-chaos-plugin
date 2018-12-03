<?php
/**
 * Reset manager.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Tools\Database_Reset
 *
 * @since      1.0.0
 * @author     Chris Berthe <chris.berthe@shopify.com>
 * @author     Greg Sweet <greg@ccdzine.com>
 */

// namespace CC_Plugin\Includes\Tools\Database_Reset;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( ! class_exists( 'DB_Reset_Manager' ) ) :

	class DB_Reset_Manager {

		private $version;

		public function __construct( $version ) {

			$this->version = $version;

		}

		public function run() {

			if ( is_admin() ) {
				$this->load_admin();
			}

		}

		private function load_admin() {

			$admin = new DB_Reset_Admin( $this->get_version() );
			$admin->run();

		}

		private function get_version() {

			return $this->version;

		}

	}

endif;