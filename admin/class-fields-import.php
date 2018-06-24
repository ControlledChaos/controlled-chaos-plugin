<?php
/**
 * Import custom fields.
 *
 * Hat tip: ACF PHP Recovery Tool plugin, https://github.com/BeAPI/ACF-PHP-Recovery.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Controlled_Chaos_Plugin\admin
 */

namespace CC_Plugin\Fields_Import;

// Restrict direct access
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Import custom fields.
 * 
 * @since controlled-chaos 1.0.0
 */
class Controlled_Chaos_Fields_Import {

	/**
     * Constructor method.
	 * 
	 * @since      1.0.0
     */
    public function __construct() {

		add_action( 'admin_menu', [ $this, 'import_page' ], 100 );

	}

	/**
	 * Add admin page.
	 * 
	 * @since controlled-chaos 1.0.0
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
	 * @since controlled-chaos 1.0.0
	 */
	public function page_output() {

		global $wpdb;

		$acf_local = acf_local();

		// Process the form.
		if ( isset( $_POST['acf_php_recovery_action'] ) && $_POST['acf_php_recovery_action'] == 'import' && isset( $_POST['fieldsets']) && check_admin_referer( 'acf_php_recovery' ) ) {
			$import_fieldsets = $_POST['fieldsets'];

			// Keep track of the imported.
			$imported = array();

			// Group or field key to post id.
			$key_to_post_id = array();

			// Now we can import the groups
			foreach ( $acf_local->groups as $key => $group ) {
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
				foreach ( $acf_local->fields as $key => $field ) {
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

		include_once plugin_dir_path( __FILE__ ) . 'partials/fields-import-page.php';
		
	}

}

$ccp_fields_import = new Controlled_Chaos_Fields_Import;