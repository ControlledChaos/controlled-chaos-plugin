<?php

/**
 * Filter post types by page template.
 *
 * @link       http://ccdzine.com
 * @since      1.0.0
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 */

namespace CCPlugin\Admin_List_Filters;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Filter post types by page template.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos/admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Filter_By_Template {
	
	/**
	 * Initialize the class.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		
		// Dropdown select box.
		add_action( 'restrict_manage_posts', [ $this, 'filter_dropdown' ] );

		// Perform the filtering.
		add_filter( 'request', [ $this, 'filter_post_list' ] );
		
		// Add new column to post list.
		add_filter( 'manage_pages_columns', [ $this, 'post_list_columns_head' ], 9 );

		// Post list column content.
		add_action( 'manage_pages_custom_column', [ $this, 'post_list_columns_content' ], 9, 2 );

	}
	
	/**
	 * Output the dropdown select box.
	 * 
	 * @since    1.0.0
	 */
	public function filter_dropdown() {

		if ( $GLOBALS['pagenow'] === 'upload.php' ) {
			return;
		}
	
		$template      = isset( $_GET['page_template_filter'] ) ? $_GET['page_template_filter'] : "all"; 
		$default_title = apply_filters( 'default_page_template_title',  __( 'Default Template', 'controlled-chaos' ), 'meta-box' );
		?>
		<select name="page_template_filter" id="page_template_filter">
			<option value="all">All Page Templates</option>
			<option value="default" <?php echo ( $template == 'default' ) ? ' selected="selected" ' : ''; ?>><?php echo esc_html( $default_title ); ?></option>
			<?php page_template_dropdown( $template ); ?>
		</select>
		<?php
	}
	
	/**
	 * Perform the filtering.
	 * 
	 * @since    1.0.0
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
	 * Add new column to post list.
	 * 
	 * @since    1.0.0
	 */
	public function post_list_columns_head( $columns ) {

	    $columns['template'] = 'Template';
		return $columns;
		
	}
	
	/**
	 * Post list column content.
	 * 
	 * @since    1.0.0
	 */
	public function post_list_columns_content( $column_name, $post_id ) {

	    if ( $column_name == 'template' ) {

			$template = get_post_meta( $post_id, '_wp_page_template' , true );
			
	        if ( $template ) {

	        	if ( $template == 'default' ) {

	        		$template_name = apply_filters( 'default_page_template_title',  __( 'Default Template', 'controlled-chaos' ), 'meta-box' );
					echo sprintf( '<span title="Template file : page.php">%1s</span>', $template_name );
					
	        	} else {

	        		$templates = wp_get_theme()->get_page_templates();

	        		if ( isset( $templates[ $template ] ) ) {
	        			echo sprintf( '<span title="Template file : %1s">%2s</span>', $template, $templates[ $template ] );
	        		} else {	        			
	        			echo sprintf( '<span title="This template file does not exist">%1s</span>', $template );
					}
					
	        	}
	            
			}
			
		}
		
	}
	
}

$controlled_chaos_template_filter = new Controlled_Chaos_Filter_By_Template();