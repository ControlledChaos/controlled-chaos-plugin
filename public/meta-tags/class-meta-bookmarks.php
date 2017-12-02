<?php
/**
 * Bookmark icons
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/includes
 * @since controlled-chaos 1.0.4
 */

namespace Controlled_Chaos;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

class Controlled_Chaos_Bookmarks {

	/**
	 * Constructor magic method.
	 */
	public function __construct() {

		// Add action to output bookmark icon tags.
		add_action( 'ccp_bookmarks', [ $this, 'bookmarks' ] );

	}

	/**
	 * Bookmark icons HTML.
	 */
	protected function bookmarks_output() {

		echo "\r" . '<!-- General bookmark icons -->' . "\r";
		echo '<link rel="shortcut icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/favicon.png' ) . '" type="image/png" />' . "\r";

		echo "\r" . '<!-- Android bookmark icons -->' . "\r";
		echo '<link rel="icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon-32.png' ) . '" sizes="32x32" type="image/png" />' . "\r";
		echo '<link rel="icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon-64.png' ) . '" sizes="64x64" type="image/png" />' . "\r";
		echo '<link rel="icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon-128.png' ) . '" sizes="128x128" type="image/png" />' . "\r";
		echo '<link rel="icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon-192.png' ) . '" sizes="192x192" type="image/png" />' . "\r";
		echo '<link rel="icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon-192.png' ) . '" sizes="128x128" type="image/png" />' . "\r";

		echo "\r" . '<!-- Apple bookmark icons -->' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/apple-touch-icon.png' ) . '" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon57.png' ) . '" sizes="57x57" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon72.png' ) . '" sizes="72x72" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon76.png' ) . '" sizes="76x76" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon114.png' ) . '" sizes="114x114" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon120.png' ) . '" sizes="120x120" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon144.png' ) . '" sizes="144x144" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon152.png' ) . '" sizes="152x152" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon152.png' ) . '" sizes="167x167" type="image/png" />' . "\r";
		echo '<link rel="apple-touch-icon" href="' . get_theme_file_uri( '/assets/images/bookmarks/icon180.png' ) . '" sizes="180x180" type="image/png" />' . "\r";

		echo "\r" . '<!-- Microsoft bookmark icons -->' . "\r";
		echo '<meta name="msapplication-TileImage" content="' . get_theme_file_uri( '/assets/images/bookmarks/icon144.png' ) . '" type="image/png" />' . "\r";
		echo '<meta name="msapplication-TileColor" content=" "/>' . "\r";
		echo '<meta name="application-name" content="name" />' . "\r";
		echo '<meta name="msapplication-square70x70logo" content="' . get_theme_file_uri( '/assets/images/bookmarks/tile-tiny.png' ) . '" type="image/png" />' . "\r";
		echo '<meta name="msapplication-square150x150logo" content="' . get_theme_file_uri( '/assets/images/bookmarks/tile-square.png' ) . '" type="image/png" />' . "\r";
		echo '<meta name="msapplication-wide310x150logo" content="' . get_theme_file_uri( '/assets/images/bookmarks/tile-wide.png" type="image/png' ) . '" />' . "\r";
		echo '<meta name="msapplication-square310x310logo" content="' . get_theme_file_uri( '/assets/images/bookmarks/tile-large.png" type="image/png' ) . '" />' . "\r";
	}

	/**
	 * Filter bookmark icon tags output.
	 */
	public function bookmarks() {

		$output    = $this::bookmarks_output();
		$bookmarks = apply_filters( 'igp_bookmarks', $output );
		return $bookmarks;
		
	}

}

// Run the Controlled_Chaos_Bookmarks class.
$ccp_bookmarks = new Controlled_Chaos_Bookmarks;