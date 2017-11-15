<?php
/**
 * Site settings page.
 *
 * @package WordPress
 * @subpackage controlled-chaos
 * @since controlled-chaos 1.0.0
 */

namespace Controlled_Chaos;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Controlled_Chaos_Settings_Fields {

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $controlled-chaos
	 * @param      string    $version
	 */
    public function __construct() {

        // Register settings page fields.
    	$this->settings_fields();

	}
	
	public function settings_fields() {

		if( function_exists('acf_add_local_field_group') ):

			acf_add_local_field_group(array(
				'key' => 'group_5a0c7ff7764ca',
				'title' => 'Settings Page',
				'fields' => array(
					array(
						'key' => 'field_5a0c800f57d56',
						'label' => 'Admin Menu',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_5a0c802257d57',
						'label' => 'Menus Link',
						'name' => 'ccp_menus_link_position',
						'type' => 'button_group',
						'instructions' => 'Select the position of the Menus page link.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'top' => 'Top Level',
							'default' => 'Default',
						),
						'allow_null' => 0,
						'default_value' => 'top',
						'layout' => 'horizontal',
						'return_format' => 'value',
					),
					array(
						'key' => 'field_5a0c808757d58',
						'label' => 'Widgets Link',
						'name' => 'ccp_widgets_link_position',
						'type' => 'button_group',
						'instructions' => 'Select the position of the Widgets page link.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'top' => 'Top Level',
							'default' => 'Default',
						),
						'allow_null' => 0,
						'default_value' => 'top',
						'layout' => 'horizontal',
						'return_format' => 'value',
					),
					array(
						'key' => 'field_5a0c80ab57d59',
						'label' => 'Settings Page',
						'name' => 'ccp_settings_link_position',
						'type' => 'button_group',
						'instructions' => 'Select the position of this Settings page link, and whether to show or hide the other settings links.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'default' => 'Default/Show',
							'top' => 'Top Level/Hide',
						),
						'allow_null' => 0,
						'default_value' => 'default',
						'layout' => 'horizontal',
						'return_format' => 'value',
					),
					array(
						'key' => 'field_5a0c8d8a32b95',
						'label' => 'Hide Links',
						'name' => 'ccp_admin_hide_links',
						'type' => 'checkbox',
						'instructions' => 'Select which menu items to hide.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'themes' => 'Appearance',
							'plugins' => 'Plugins',
							'users' => 'Users',
							'tools' => 'Tools',
							'fields' => 'Custom Fields',
						),
						'allow_custom' => 0,
						'save_custom' => 0,
						'default_value' => array(
						),
						'layout' => 'horizontal',
						'toggle' => 1,
						'return_format' => 'value',
					),
					array(
						'key' => 'field_5a0c8d7232b94',
						'label' => 'Dashboard',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_5a0c8f393edd6',
						'label' => 'Hide Widgets',
						'name' => 'ccp_dashboard_hide_widgets',
						'type' => 'checkbox',
						'instructions' => 'Select the Dashboard widgets to hide.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'choices' => array(
							'welcome' => 'Welcome',
							'news' => 'WordPress News',
							'quick' => 'Quick Press',
							'at_glance' => 'At a Glance',
							'activity' => 'Activity',
						),
						'allow_custom' => 0,
						'save_custom' => 0,
						'default_value' => array(
						),
						'layout' => 'horizontal',
						'toggle' => 1,
						'return_format' => 'value',
					),
					array(
						'key' => 'field_5a0cbb3873e55',
						'label' => 'Admin Pages',
						'name' => '',
						'type' => 'tab',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'placement' => 'top',
						'endpoint' => 0,
					),
					array(
						'key' => 'field_5a0cbb5e73e56',
						'label' => 'Admin Footer Credit',
						'name' => 'ccp_admin_footer_credit',
						'type' => 'text',
						'instructions' => 'The "developed by" credit.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'maxlength' => '',
					),
					array(
						'key' => 'field_5a0cbba573e57',
						'label' => 'Admin Footer Link',
						'name' => 'ccp_admin_footer_link',
						'type' => 'url',
						'instructions' => 'Link to the website devoloper.',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array(
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'default_value' => '',
						'placeholder' => '',
					),
				),
				'location' => array(
					array(
						array(
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'site-settings',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'acf_after_title',
				'style' => 'seamless',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));

		endif;

	}

}

$controlled_chaos_settings_fields = new Controlled_Chaos_Settings_Fields;