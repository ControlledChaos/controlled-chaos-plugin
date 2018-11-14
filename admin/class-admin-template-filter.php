<?php
/**
 * Filter post types by page template.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Filter post types by page template.
 *
 * @since  1.0.0
 * @access public
 *
 * @todo   Make this feature optional.
 */
class Filter_By_Template {

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

		// Dropdown select box.
		add_action( 'restrict_manage_posts', [ $this, 'filter_dropdown' ] );

		// Perform the filtering.
		add_filter( 'request', [ $this, 'filter_post_list' ] );

		// Add new column to post list.
		add_filter( 'manage_posts_columns', [ $this, 'template_columns_head' ], 9 );
		add_filter( 'manage_pages_columns', [ $this, 'template_columns_head' ], 9 );

		// Template column content.
		add_action( 'manage_posts_custom_column', [ $this, 'template_columns_content' ], 9, 2 );
		add_action( 'manage_pages_custom_column', [ $this, 'template_columns_content' ], 9, 2 );

	}

	/**
	 * The filter dropdown select box.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function filter_dropdown() {

		// Exclude the Media Library screen.
		if ( $GLOBALS['pagenow'] === 'upload.php' ) {
			return;
		}

		// If a page template has been selected show posts using that template.
		if ( isset( $_GET['page_template_filter'] ) ) {
			$template = $_GET['page_template_filter'];

		// Otherwise show all posts.
		} else {
			$template = 'all';
		}

		// The HTML of the dropdown select box abave the table.
		?>
		<select name="page_template_filter" id="page_template_filter">
			<option value="all"><?php _e( 'All Page Templates', 'controlled-chaos-plugin' ); ?></option>
			<option value="default" <?php echo ( $template == 'default' ) ? ' selected="selected" ' : ''; ?>><?php echo _e( 'Default Template', 'controlled-chaos-plugin' ); ?></option>
			<?php page_template_dropdown( $template ); ?>
		</select>
		<?php

	}

	/**
	 * Perform the filtering.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $vars
	 * @return array
	 */
	public function filter_post_list( $vars ) {

		if ( ! isset( $_GET['page_template_filter'] ) ) {
			return $vars;
		}

		$template = trim( $_GET['page_template_filter'] );

		if ( $template == '' || $template == 'all' ) {
			return $vars;
		}

		$vars = array_merge(
			$vars,
			[
				'meta_query' => [
					[
						'key'     => '_wp_page_template',
						'value'   => $template,
						'compare' => '=',
					],
				],
			]
		);

		return $vars;

	}

	/**
	 * Add new Template column to post list.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $columns
	 * @return array
	 */
	public function template_columns_head( $columns ) {

		// The column heading name to new `template` column.
		$columns['template'] = __( 'Template', 'controlled-chaos-plugin' );

		// Return the heading name.
		return $columns;

	}

	/**
	 * Template column content.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $column_name
	 * @param  int $post_id
	 * @return void
	 */
	public function template_columns_content( $column_name, $post_id ) {

		// If the column is the `template` column established above.
	    if ( $column_name == 'template' ) {

			// Get the post template by post ID.
			$template = get_post_meta( $post_id, '_wp_page_template' , true );

			// If a template has been applied to the post.
	        if ( $template ) {

				// If it's the default template.
	        	if ( $template == 'default' ) {

					echo sprintf(
						'<span title="%1s">%2s</span>',
						__( 'Default Template', 'controlled-chaos-plugin' ),
						__( 'Default Template', 'controlled-chaos-plugin' )
					);

				// If it's not the default template.
	        	} else {

					// Get theme templates as a variable.
	        		$templates = wp_get_theme()->get_page_templates();

					// If the template is found.
	        		if ( isset( $templates[ $template ] ) ) {
	        			echo sprintf(
							'<span title="%1s %2s">%3s</span>',
							__( 'Template file:', 'controlled-chaos-plugin' ),
							$template,
							$templates[ $template ]
						);

					// If the template cannot be found.
	        		} else {
	        			echo sprintf(
							'<span title="%1s">%2s</span>',
							__( 'This template file does not exist', 'controlled-chaos-plugin' ),
							$template
						);
					}

	        	}

			}

		}

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_filter_by_template() {

	return Filter_By_Template::instance();

}

// Run an instance of the class.
ccp_filter_by_template();