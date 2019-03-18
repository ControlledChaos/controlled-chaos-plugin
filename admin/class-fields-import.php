<?php
/**
 * Import custom fields.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 *
 * @link       https://github.com/BeAPI/ACF-PHP-Recovery
 */

namespace CC_Plugin\Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Import custom fields.
 *
 * @since  1.0.0
 * @access public
 */
final class Fields_Import {

	/**
	 * Instance of the class
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

		}

		// Return the instance.
		return $instance;

	}

	/**
     * Constructor method
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
     */
    public function __construct() {

		// Add the user interface for fields import.
		add_action( 'admin_menu', [ $this, 'import_page' ], 100 );

	}

	/**
	 * Add admin page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function import_page() {

		add_submenu_page(
			'edit.php?post_type=acf-field-group',
			__( 'Registered Fields', 'controlled-chaos-plugin' ),
			__( 'Registered Fields', 'controlled-chaos-plugin' ),
			'manage_options', 'acf-theme-fields',
			[ $this, 'page_output' ]
		);

	}

	/**
	 * Page output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @global object wpdb provide an interface with the WordPress/ClassicPress database.
	 * @return void
	 */
	public function page_output() {

		global $wpdb;

		// Process the form.
		if ( isset( $_POST['acf_php_recovery_action'] ) && $_POST['acf_php_recovery_action'] == 'import' && isset( $_POST['fieldsets']) && check_admin_referer( 'acf_php_recovery' ) ) {
			$import_fieldsets = $_POST['fieldsets'];

			// Keep track of the imported.
			$imported = array();

			// Group or field key to post id.
			$key_to_post_id = array();

			// Now we can import the groups
			foreach ( acf()->local->groups as $key => $group ) {
				$group['title'] = $group['title'] . __( ' (Imported)', 'controlled-chaos-plugin' );

				// Only import those that were selected.
				if ( in_array( $key, $import_fieldsets ) ) {
					$saved_group = acf_update_field_group( $group );

					$key_to_post_id[$key] = $saved_group['ID'];

					// For displaying the success message.
					$imported[] = array(
						'title' => $group['title'],
						'id'    => $saved_group['ID'],
					);
				}
			}

			/**
			 * This requires multipile runs to handle sub-fields that have
			 * their parent set to the parent field instead of the group.
			 */

			// The groups and fields.
			$field_parents = $import_fieldsets;

			// Keep track of the already imported.
			$imported_fields = array();
			do {
				$num_import = 0;
				foreach ( acf()->local->fields as $key => $field ) {
					if ( ! in_array( $key, $imported_fields ) && in_array( $field['parent'], $field_parents ) ) {
						$num_import           = $num_import + 1;
						$field_parents[]      = $key;
						$imported_fields[]    = $key;
						$field['parent']      = $key_to_post_id[$field['parent']];
						// Convert the key into the post_parent.
						$saved_field          = acf_update_field( $field );
						$key_to_post_id[$key] = $saved_field['ID'];
					}
				}
			}
			while ( $num_import > 0 );
		}

		include_once CCP_PATH . 'admin/partials/fields-import-page.php';

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_fields_import() {

	return Fields_Import::instance();

}

// Run an instance of the class.
ccp_fields_import();