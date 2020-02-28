<?php
/**
 * User bio class file
 *
 * Adds a WYSIWYG content editor to the Biographical Info
 * field on the user profile screen.
 *
 * The Twenty Twenty parent theme offers the option to display
 * the author biography on single posts. A content editor is
 * included here to enhance that feature.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 * @category   Users
 * @since      1.0.0
 */

 // Theme file namespace.
namespace CC_Plugin\Classes;

// Restrict direct access.
if ( ! defined( 'ABSPATH' ) ) { exit; }

class User_Bio {

	/**
	 * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

		// Add the WP_Editor.
		add_action( 'show_user_profile', [ $this, 'visual_editor' ] );
		add_action( 'edit_user_profile', [ $this, 'visual_editor' ] );

		// Don't sanitize the data for display in a textarea.
		add_action( 'admin_init', [ $this, 'save_filters' ] );

		// Load required JS
		add_action( 'admin_enqueue_scripts', [ $this, 'load_javascript' ], 10, 1 );

		// Add content filters to the output of the description.
		add_filter( 'get_the_author_description', 'wptexturize' );
		add_filter( 'get_the_author_description', 'convert_chars' );
		add_filter( 'get_the_author_description', 'wpautop' );

	}


	/**
	 *	Create Visual Editor
	 *
	 *	Add TinyMCE editor to replace the "Biographical Info" field in a user profile
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  object $user An object with details about the current logged in user.
	 * @return string Return the editor and container markup.
	 */
	public function visual_editor( $user ) {

		// Contributor level user or higher required
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}
		?>
		<table class="form-table">
			<tr>
				<th><label for="description"><?php _e( 'Biographical Info', 'hindsight' ); ?></label></th>
				<td>
					<?php
					$description = get_user_meta( $user->ID, 'description', true );
					wp_editor( $description, 'description' );
					?>
					<p class="description"><?php _e( 'Share a little biographical information to fill out your profile. This may be shown publicly.', 'hindsight' ); ?></p>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * Editor script
	 *
	 * @since  1.0.0
	 * @access public
	 * @return string Returns the script tag markup.
	 */
	public function load_javascript( $hook ) {

		// Contributor level user or higher required.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		// Load JavaScript only on the profile and user edit pages.
		if ( $hook == 'profile.php' || $hook == 'user-edit.php' ) {
			wp_enqueue_script(
				'visual-editor-biography',
				get_theme_file_uri( '/assets/js/user-bio.min.js' ),
				[ 'jquery' ],
				false,
				true
			);
		}
	}

	/**
	 * Save filters
	 *
	 * Removes textarea filters from description field.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function save_filters() {

		// Contributor level user or higher required.
		if ( ! current_user_can( 'edit_posts' ) ) {
			return;
		}

		remove_all_filters( 'pre_user_description' );
	}
}

new User_Bio;