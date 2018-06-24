<?php
/**
 * Plugin and site settings.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage controlled-chaos
 * @since	   controlled-chaos 1.0.0
 */

namespace CC_Plugin\Site_Settings;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Plugin and site settings.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Controlled_Chaos_Plugin\admin
 * @author     Greg Sweet <greg@ccdzine.com>
 */
class Controlled_Chaos_Site_Settings {

	/**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

	/**
	 * Constructor method.
	 * 
	 * @return self
	 * @since 1.0.0
	 */
    public function __construct() {

		// Register settings sections and fields.
		if ( is_admin() ) {
			add_action( 'admin_init', [ $this, 'settings' ] );
		}

	}

	/**
	 * Plugin site settings.
	 * 
	 * @return void
	 * @link  https://codex.wordpress.org/Settings_API
	 * @since 1.0.0
	 */
	public function settings() {

		/**
		 * Dashboard settings.
		 * 
		 * @since 1.0.0
		 */
		
		// Dashboard settings section.
		add_settings_section(
			'ccp-site-dashboard',
			__( 'Dashboard Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-dashboard'
		);

		// Hide Welcome panel.
		add_settings_field(
			'ccp_hide_welcome',
			__( 'Hide Welcome', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_welcome_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Welcome panel on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp_dashboard',
			'ccp_hide_welcome'
		);

		// Hide WordPress News widget.
		add_settings_field(
			'ccp_hide_wp_news',
			__( 'Hide WordPress News', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_wp_news_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the WordPress News widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp_dashboard',
			'ccp_hide_wp_news'
		);

		// Hide Quick Draft (QuickPress) widget.
		add_settings_field(
			'ccp_hide_quickpress',
			__( 'Hide Quick Draft', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_quickpress_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Quick Draft widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp_dashboard',
			'ccp_hide_quickpress'
		);

		// Hide At a Glance widget.
		add_settings_field(
			'ccp_hide_at_glance',
			__( 'Hide At a Glance', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_at_glance_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the At a Glance widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp_dashboard',
			'ccp_hide_at_glance'
		);

		// Hide Activity widget.
		add_settings_field(
			'ccp_hide_activity',
			__( 'Hide Activity', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_activity_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Activity widget on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp_dashboard',
			'ccp_hide_activity'
		);

		/**
		 * Admin menu settings.
		 * 
		 * @since 1.0.0
		 */

		// Admin menu settings section.
		add_settings_section(
			'ccp-site-admin-menu',
			__( 'Admin Menu Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-admin-menu'
		);

		// Settings page position.
		add_settings_field(
			'ccp_settings_position',
			__( 'Settings Page Position', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_settings_position_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make this settings page a top-level link.', 'controlled-chaos-plugin' ) ]
		);

		// Settings page link label.
		add_settings_field(
			'ccp_settings_page_link_label',
			__( 'Settings Page Label', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_settings_page_link_label_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Change the label of the link to this page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_settings_page_link_label'
		);

		/**
		 * Settings page link icon if set to top level.
		 * 
		 * @todo Show or hide the field with JavaScript on the position option checkbox
		 *       rather than checking if the position option is set.
		 */
		$position = get_option( 'ccp_settings_position' );
		if ( $position ) :
			add_settings_field(
				'ccp_settings_page_link_icon',
				__( 'Settings Page Icon', 'controlled-chaos-plugin' ),
				[ $this, 'ccp_settings_page_link_icon_callback' ],
				'ccp-site-admin-menu',
				'ccp-site-admin-menu',
				[ esc_html__( 'Enter a Dashicons class for the icon of the link to this page', 'controlled-chaos-plugin' ) ]
			);
			
			register_setting(
				'ccp-site-admin-menu',
				'ccp_settings_page_link_icon'
			);
		endif;

		// Menus link position.
		add_settings_field(
			'ccp_menus_position',
			__( 'Menus Position', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_menus_position_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make Menus a top-level link', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_menus_position'
		);

		// Widgets link position.
		add_settings_field(
			'ccp_widgets_position',
			__( 'Widgets Position', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_widgets_position_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make Widgets a top-level link', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_widgets_position'
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_settings_position'
		);

		// Hide Appearance link.
		add_settings_field(
			'ccp_hide_appearance',
			__( 'Hide Appearance', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_appearance_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Appearance link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_appearance'
		);

		// Hide Plugins link.
		add_settings_field(
			'ccp_hide_plugins',
			__( 'Hide Plugins', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_plugins_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Plugins link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_plugins'
		);

		// Hide Users link.
		add_settings_field(
			'ccp_hide_users',
			__( 'Hide Users', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_users_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Users link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_users'
		);

		// Hide Tools link.
		add_settings_field(
			'ccp_hide_tools',
			__( 'Hide Tools', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_tools_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Hide the Tools link in the admin menu', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_tools'
		);

		// Show/Hide Links Manager link.
		add_settings_field(
			'ccp_hide_links',
			__( 'Restore Links Manager', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_links_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'The old Links Manager is hidden by default in newer WordPress installations', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_hide_links'
		);

		/**
		 * Admin pages settings.
		 * 
		 * @since 1.0.0
		 */

		// Admin pages settings section.
		add_settings_section(
			'ccp-site-admin-pages',
			__( 'Admin Pages Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-admin-pages'
		);

		// Admin footer credit.
		add_settings_field(
			'ccp_footer_credit',
			__( 'Admin Footer Credit', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_footer_credit_callback' ],
			'ccp-site-admin-pages',
			'ccp-site-admin-pages',
			[ esc_html__( 'The "developed by" credit.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-pages',
			'ccp_footer_credit'
		);

		// Admin footer link.
		add_settings_field(
			'ccp_footer_link',
			__( 'Admin Footer Link', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_footer_link_callback' ],
			'ccp-site-admin-pages',
			'ccp-site-admin-pages',
			[ esc_html__( 'Link to the website devoloper.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-pages',
			'ccp_footer_link'
		);

		/**
		 * Meta & SEO settings.
		 * 
		 * @since 1.0.0
		 */

		// Meta/SEO settings section.
		add_settings_section(
			'ccp-site-meta-seo',
			__( 'Meta & SEO Settings', 'controlled-chaos-plugin' ),
			[],
			'ccp-site-meta-seo'
		);

		// Disable meta tags.
		add_settings_field(
			'ccp_disable_meta',
			__( 'Meta Tags', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_disable_meta_callback' ],
			'ccp-site-meta-seo',
			'ccp-site-meta-seo',
			[ esc_html__( 'Disable if your theme includes SEO meta tags or if you plan on using an SEO plugin.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-meta-seo',
			'ccp_disable_meta'
		);

	}

	/**
	 * Settings page position.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_settings_position_callback( $args ) {

		$option = get_option( 'ccp_settings_position' );

		$html = '<p><input type="checkbox" id="ccp_settings_position" name="ccp_settings_position" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_settings_position"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Settings page link label.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return mixed 
	 * @since  1.0.0
	 */
	public function ccp_settings_page_link_label_callback( $args ) {

		$option = get_option( 'ccp_settings_page_link_label' );

		$html = '<p><input type="text" size="50" id="ccp_settings_page_link_label" name="ccp_settings_page_link_label" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'Site Settings', 'controlled-chaos-plugin' ) ) . '" /><br />';
		
		$html .= '<label for="ccp_settings_page_link_label"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Settings page link icon.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return mixed 
	 * @since  1.0.0
	 */
	public function ccp_settings_page_link_icon_callback( $args ) {

		$option = get_option( 'ccp_settings_page_link_icon' );

		$html = '<p><input type="text" size="50" id="ccp_settings_page_link_icon" name="ccp_settings_page_link_icon" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'dashicons-admin-generic', 'controlled-chaos-plugin' ) ) . '" /><br />';
		
		$html .= '<label for="ccp_settings_page_link_icon"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Menus link position.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_menus_position_callback( $args ) {

		$option = get_option( 'ccp_menus_position' );

		$html = '<p><input type="checkbox" id="ccp_menus_position" name="ccp_menus_position" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_menus_position"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Widgets link position.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_widgets_position_callback( $args ) {

		$option = get_option( 'ccp_widgets_position' );

		$html = '<p><input type="checkbox" id="ccp_widgets_position" name="ccp_widgets_position" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_widgets_position"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Welcome panel.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_welcome_callback( $args ) {

		$option = get_option( 'ccp_hide_welcome' );

		$html = '<p><input type="checkbox" id="ccp_hide_welcome" name="ccp_hide_welcome" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_welcome"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide WordPress News widget.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_wp_news_callback( $args ) {

		$option = get_option( 'ccp_hide_wp_news' );

		$html = '<p><input type="checkbox" id="ccp_hide_wp_news" name="ccp_hide_wp_news" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_wp_news"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Quick Draft (QuickPress) widget.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_quickpress_callback( $args ) {

		$option = get_option( 'ccp_hide_quickpress' );

		$html = '<p><input type="checkbox" id="ccp_hide_quickpress" name="ccp_hide_quickpress" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_quickpress"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide At a Glance widget.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_at_glance_callback( $args ) {

		$option = get_option( 'ccp_hide_at_glance' );

		$html = '<p><input type="checkbox" id="ccp_hide_at_glance" name="ccp_hide_at_glance" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_at_glance"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Activity widget.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_activity_callback( $args ) {

		$option = get_option( 'ccp_hide_activity' );

		$html = '<p><input type="checkbox" id="ccp_hide_activity" name="ccp_hide_activity" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_activity"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Appearance link.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_appearance_callback( $args ) {

		$option = get_option( 'ccp_hide_appearance' );

		$html = '<p><input type="checkbox" id="ccp_hide_appearance" name="ccp_hide_appearance" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_appearance"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Plugins link.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_plugins_callback( $args ) {

		$option = get_option( 'ccp_hide_plugins' );

		$html = '<p><input type="checkbox" id="ccp_hide_plugins" name="ccp_hide_plugins" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_plugins"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Users link.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_users_callback( $args ) {

		$option = get_option( 'ccp_hide_users' );

		$html = '<p><input type="checkbox" id="ccp_hide_users" name="ccp_hide_users" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_users"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide Tools link.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_tools_callback( $args ) {

		$option = get_option( 'ccp_hide_tools' );

		$html = '<p><input type="checkbox" id="ccp_hide_tools" name="ccp_hide_tools" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_tools"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Show/Hide Links Manager link.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_hide_links_callback( $args ) {

		$option = get_option( 'ccp_hide_links' );

		$html = '<p><input type="checkbox" id="ccp_hide_links" name="ccp_hide_links" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_hide_links"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Admin footer credit.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_footer_credit_callback( $args ) {

		$option = get_option( 'ccp_footer_credit' );

		$html = '<p><input type="text" size="50" id="ccp_footer_credit" name="ccp_footer_credit" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'Your name/agency', 'controlled-chaos-plugin' ) ) . '" /><br />';
		
		$html .= '<label for="ccp_footer_credit"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Admin footer link.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_footer_link_callback( $args ) {

		$option = get_option( 'ccp_footer_link' );

		$html = '<p><input type="text" size="50" id="ccp_footer_link" name="ccp_footer_link" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( 'http://example.com/' ) . '" /><br />';
		
		$html .= '<label for="ccp_footer_link"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Disable meta tags.
	 * 
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 * @since  1.0.0
	 */
	public function ccp_disable_meta_callback( $args ) {

		$option = get_option( 'ccp_disable_meta' );

		$html = '<p><input type="checkbox" id="ccp_disable_meta" name="ccp_disable_meta" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_disable_meta"> '  . $args[0] . '</label></p>';

		echo $html;

	}

}

$ccp_site_settings = new Controlled_Chaos_Site_Settings;