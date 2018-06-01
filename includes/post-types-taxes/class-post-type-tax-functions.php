<?php
/**
 * Functions for post types and taxonomies.
 * 
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\Post_Type_Tax_Functions;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The admin-specific functionality of the plugin.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Post_Type_Tax_Functions {

	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
	
		// Replace "Post" in the update messages.
		add_filter( 'post_updated_messages', [ $this, 'update_messages' ], 99 );

		// Replace post type title placeholders.
		add_filter( 'enter_title_here', [ $this, 'title_placeholders' ] );

	}

	/**
	 * Replace "Post" in the update messages for custom post types.
	 *
	 * Example: where the edit screen reads "Post updated" and "View post"
	 * it would read "Project updated" and "View project" for post type Project.
	 * 
	 * @since    1.0.0
	 */
	public function update_messages( $messages ) {

		global $post, $post_ID;

		$post_types = get_post_types(
			[
				'show_ui'  => true,
				'_builtin' => false
			],
			'objects' );
		
		foreach ( $post_types as $post_type => $post_object ) {

			$messages[ $post_type ] = [
				0  => '', /* Unused. Messages start at index 1 */

				1  => sprintf( __( '%1s updated. <a href="%2s">View %3s</a>', 'controlled-chaos' ), $post_object->labels->singular_name, esc_url( get_permalink( $post_ID ) ), $post_object->labels->singular_name ),
				2  => __( 'Custom field updated.', 'controlled-chaos' ),
				3  => __( 'Custom field deleted.', 'controlled-chaos' ),
				4  => sprintf( __( '1%s updated.', 'controlled-chaos' ), $post_object->labels->singular_name ),
				
				5  => isset( $_GET['revision']) ? sprintf( __( '%1s restored to revision from %2s', 'controlled-chaos' ), $post_object->labels->singular_name, wp_post_revision_title( (int) $_GET['revision'], false ) ) : false,

				6  => sprintf( __( '%1s published. <a href="%2s">View %3s</a>', 'controlled-chaos' ), $post_object->labels->singular_name, esc_url( get_permalink( $post_ID ) ), $post_object->labels->singular_name ),

				7  => sprintf( __( '%1s saved.', 'controlled-chaos' ), $post_object->labels->singular_name ),
				
				8  => sprintf( __( '%1s submitted. <a target="_blank" href="%2s">Preview %3s</a>', 'controlled-chaos' ), $post_object->labels->singular_name, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ), $post_object->labels->singular_name ),

				9  => sprintf( __( '%1s scheduled for: <strong>%2s</strong>. <a target="_blank" href="%3s">Preview %4s</a>', 'controlled-chaos'  ), $post_object->labels->singular_name, date_i18n( __( 'M j, Y @ G:i', 'controlled-chaos' ), strtotime( $post->post_date ) ), esc_url( get_permalink( $post_ID ) ), $post_object->labels->singular_name ),

				10 => sprintf( __( '%1s draft updated. <a target="_blank" href="%2s">Preview %3s</a>', 'controlled-chaos'  ), $post_object->labels->singular_name, esc_url( add_query_arg( 'preview', 'true', get_permalink( $post_ID ) ) ), $post_object->labels->singular_name ),
			];

		}

		return $messages;
	}

	/**
	 * Replace post type title placeholders.
	 * 
	 * Included for a head start in development of a site-specific plugin.
	 * 
	 * @since    1.0.0
	 */
	public function title_placeholders( $title ) {

		$screen = get_current_screen();
		
		if ( '' == $screen->post_type ) {
			$title = __( '', 'controlled-chaos' );
		} elseif ( '' == $screen->post_type ) {
			$title = __( '', 'controlled-chaos' );
		}

		return $title;
	}

}

$controlled_chaos_post_type_tax_functions = new Controlled_Chaos_Post_Type_Tax_Functions;