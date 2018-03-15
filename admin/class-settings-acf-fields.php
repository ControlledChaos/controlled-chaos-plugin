<?php
/**
 * Site settings page field groups.
 *
 * @package    controlled-chaos
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace CCPlugin\ACF_Settings;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Site settings page field groups.
 */
class Controlled_Chaos_Settings_Fields {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
    public function __construct() {

        // Register settings page fields.
    	$this->settings_fields();

	}

	public function settings_fields() {

		if ( function_exists( 'acf_add_local_field_group' ) ) :

			acf_add_local_field_group( [
				'key' => 'group_5a0c7ff7764ca',
				'title' => 'Settings Page',
				'fields' => [
					[
						'key' => 'field_5a0c8d7232b94',
						'label' => 'Dashboard',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'placement' => 'top',
						'endpoint' => 0,
					],
					[
						'key' => 'field_5a0c8f393edd6',
						'label' => 'Hide Widgets',
						'name' => 'ccp_dashboard_hide_widgets',
						'type' => 'checkbox',
						'instructions' => 'Select the Dashboard widgets to hide.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'choices' => [
							'welcome' => 'Welcome',
							'news' => 'WordPress News',
							'quick' => 'Quick Press',
							'at_glance' => 'At a Glance',
							'activity' => 'Activity',
						],
						'allow_custom' => 0,
						'save_custom' => 0,
						'default_value' => [
						],
						'layout' => 'horizontal',
						'toggle' => 1,
						'return_format' => 'value',
					],
					[
						'key' => 'field_5a0c800f57d56',
						'label' => 'Admin Menu',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'placement' => 'top',
						'endpoint' => 0,
					],
					[
						'key' => 'field_5a0c802257d57',
						'label' => 'Menus Link',
						'name' => 'ccp_menus_link_position',
						'type' => 'button_group',
						'instructions' => 'Select the position of the Menus page link.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'choices' => [
							'top' => 'Top Level',
							'default' => 'Default',
						],
						'allow_null' => 0,
						'default_value' => 'top',
						'layout' => 'horizontal',
						'return_format' => 'value',
					],
					[
						'key' => 'field_5a0c808757d58',
						'label' => 'Widgets Link',
						'name' => 'ccp_widgets_link_position',
						'type' => 'button_group',
						'instructions' => 'Select the position of the Widgets page link.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'choices' => [
							'top' => 'Top Level',
							'default' => 'Default',
						],
						'allow_null' => 0,
						'default_value' => 'top',
						'layout' => 'horizontal',
						'return_format' => 'value',
					],
					[
						'key' => 'field_5a0c80ab57d59',
						'label' => 'Settings Page',
						'name' => 'ccp_settings_link_position',
						'type' => 'button_group',
						'instructions' => 'Select the position of this Settings page link, and whether to show or hide the other settings links.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'choices' => [
							'default' => 'Default/Show',
							'top' => 'Top Level/Hide',
						],
						'allow_null' => 0,
						'default_value' => 'default',
						'layout' => 'horizontal',
						'return_format' => 'value',
					],
					[
						'key' => 'field_5a0c8d8a32b95',
						'label' => 'Hide Links',
						'name' => 'ccp_admin_hide_links',
						'type' => 'checkbox',
						'instructions' => 'Select which menu items to hide.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'choices' => [
							'themes' => 'Appearance',
							'plugins' => 'Plugins',
							'users' => 'Users',
							'tools' => 'Tools',
							'fields' => 'Custom Fields',
						],
						'allow_custom' => 0,
						'save_custom' => 0,
						'default_value' => [
						],
						'layout' => 'horizontal',
						'toggle' => 1,
						'return_format' => 'value',
					],
					[
						'key' => 'field_5aaa73e38deb3',
						'label' => 'Links Manager',
						'name' => 'ccp_links_manager',
						'type' => 'true_false',
						'instructions' => 'The old Links Manager is hidden by default in newer WordPress installations.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'message' => '',
						'default_value' => 0,
						'ui' => 1,
						'ui_on_text' => 'Enabled',
						'ui_off_text' => 'Disabled',
					],
					[
						'key' => 'field_5a0cbb3873e55',
						'label' => 'Admin Pages',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'placement' => 'top',
						'endpoint' => 0,
					],
					[
						'key' => 'field_5a0cbb5e73e56',
						'label' => 'Admin Footer Credit',
						'name' => 'ccp_admin_footer_credit',
						'type' => 'text',
						'instructions' => 'The "developed by" credit.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					],
					[
						'key' => 'field_5a0cbba573e57',
						'label' => 'Admin Footer Link',
						'name' => 'ccp_admin_footer_link',
						'type' => 'url',
						'instructions' => 'Link to the website devoloper.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'default_value' => '',
						'placeholder' => '',
					],
					[
						'key' => 'field_5a1989a036067',
						'label' => 'Meta/SEO',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'placement' => 'top',
						'endpoint' => 0,
					],
					[
						'key' => 'field_5a237090744c4',
						'label' => 'Meta Tags',
						'name' => 'ccp_disable_meta_tags',
						'type' => 'true_false',
						'instructions' => 'Disable if you plan on using Yoast SEO or a similarly awful plugin.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'message' => 'Check to disable',
						'default_value' => 0,
						'ui' => 0,
						'ui_on_text' => 'Disabled',
						'ui_off_text' => 'Enabled',
					],
					[
						'key' => 'field_5a198d601b523',
						'label' => 'Blog Pages Title',
						'name' => 'ccp_meta_blog_title',
						'type' => 'text',
						'instructions' => 'Will use the site title if left empty.',
						'required' => 0,
						'conditional_logic' => [
							[
								[
									'field' => 'field_5a237090744c4',
									'operator' => '!=',
									'value' => '1',
								],
							],
						],
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					],
					[
						'key' => 'field_5a198bd736068',
						'label' => 'Blog Pages Description',
						'name' => 'ccp_meta_blog_description',
						'type' => 'textarea',
						'instructions' => 'Will use the site tagline if left empty and if a tagline is set.',
						'required' => 0,
						'conditional_logic' => [
							[
								[
									'field' => 'field_5a237090744c4',
									'operator' => '!=',
									'value' => '1',
								],
							],
						],
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'default_value' => '',
						'placeholder' => '',
						'maxlength' => '',
						'rows' => 4,
						'new_lines' => '',
					],
					[
						'key' => 'field_5a198c1836069',
						'label' => 'Blog Pages Image',
						'name' => 'ccp_meta_blog_image',
						'type' => 'image',
						'instructions' => 'A minimum of 1230px by 600px is recommended for retina display devices.',
						'required' => 0,
						'conditional_logic' => [
							[
								[
									'field' => 'field_5a237090744c4',
									'operator' => '!=',
									'value' => '1',
								],
							],
						],
						'wrapper' => [
							'width' => '',
							'class' => '',
							'id' => '',
						],
						'return_format' => 'array',
						'preview_size' => 'medium',
						'library' => 'all',
						'min_width' => '',
						'min_height' => '',
						'min_size' => '',
						'max_width' => '',
						'max_height' => '',
						'max_size' => '',
						'mime_types' => '',
					],
				],
				'location' => [
					[
						[
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'site-settings',
						],
					],
				],
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			 ] );

		endif;

	}

}

$controlled_chaos_settings_fields = new Controlled_Chaos_Settings_Fields;