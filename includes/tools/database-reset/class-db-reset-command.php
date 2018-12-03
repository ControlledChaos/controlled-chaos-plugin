<?php
/**
 * Reset command.
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

/**
 * Reset the database tables.
 */
class DB_Reset_Command extends WP_CLI_Command {

	private $reactivate;
	private $reporting;

	public function __construct() {

		$this->resetter = new DB_Resetter();

	}

	/**
	 * Reset the database tables.
	 *
	 * ## OPTIONS
	 *
	 * <tables>
	 * The list of tables to reset
	 *
	 * <reactivate>
	 * Reactivate current theme and plugins after reset?
	 *
	 * ## EXAMPLES
	 * wp reset database
	 * wp reset database --tables='users,posts,comments'
	 * wp reset database --no-reactivate
	 */
	public function database( $args, $assoc_args ) {

		$this->handle_before_reset();
		$this->reactivate_data( $assoc_args[ 'reactivate' ] );
		$this->reset( $this->sanitize_input( $assoc_args[ 'tables' ] ) );
		$this->handle_after_reset();

	}

	/**
	 * Lists the database tables.
	 *
	 * @subcommand list
	 */
	public function _list() {

	$tables = $this->get_wp_tables();

		foreach( $tables as $key => $value ) {
			WP_CLI::line( $key );
		}

	}

	private function handle_before_reset() {

		$this->disable_error_reporting();

	}

	private function disable_error_reporting() {

		$this->reporting = error_reporting();
		error_reporting( 0 );

	}

	private function sanitize_input( $string = '' ) {

		if ( ! empty ( $string ) ) {
			return explode( ',', preg_replace( '/\s+/', '', $string ) );
		}

		return array_keys( $this->get_wp_tables() );

	}

	private function get_wp_tables() {

		return $this->resetter->get_wp_tables();

	}

	private function reactivate_data( $string = '' ) {

		if ( is_null( $string ) ) {
			$string = 'true';
		}

		$this->reactivate = ( $string ) ? 'true' : 'false';

		$this->resetter->set_reactivate( $this->reactivate );

	}

	private function reset( array $tables ) {

		foreach ( $tables as $key => $value ) {
			WP_CLI::success( $value );
		}

		$this->resetter->reset( $tables );
		$this->output_successful_notice();

	}

	private function output_successful_notice() {

		WP_CLI::line( __( 'The selected tables were reset', 'controlled-chaos-plugin' ) );

		if ( 'true' === $this->reactivate ) {
			WP_CLI::line( __( 'The current theme and plugins were reactivated','controlled-chaos-plugin' ) );
		}

	}

	private function handle_after_reset() {

		error_reporting( $this->reporting );

	}

}

// Run the class.
WP_CLI::add_command( 'reset', 'DB_Reset_Command' );