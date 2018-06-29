<?php
/**
 * Plugin and site settings.
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
 * Plugin and site settings.
 *
 * @since  1.0.0
 * @access public
 */
class Settings {

	/**
	 * Get an instance of the plugin class.
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

			// Settings dependencies.
			$instance->dependencies();
			
		}

		// Return the instance.
		return $instance;

	}

    /**
	 * Constructor method.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return self
	 */
    public function __construct() {

		// Add scripts settings page.
		add_action( 'admin_menu', [ $this, 'scripts_settings_page' ] );

		// Register settings.
		add_action( 'admin_init', [ $this, 'settings' ] );

        // Add ACF options page.
		add_action( 'admin_menu', [ $this, 'site_settings_page' ] );
		
		// Include jQuery Migrate.
		$migrate = get_option( 'ccp_jquery_migrate' );
		if ( ! $migrate ) {
			add_action( 'wp_default_scripts', [ $this, 'include_jquery_migrate' ] );
		}

	}

	/**
	 * Admin file dependencies.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return void
	 */
	private function dependencies() {

		// Fields for the Site Settings page.
		require plugin_dir_path( __FILE__ ) . 'class-site-settings-fields.php';

	}
	
	/**
	 * Add scripts settings page.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function scripts_settings_page() {

		$this->help_scripts = add_options_page(
			__( 'Script Options', 'controlled-chaos-plugin' ),
			__( 'Script Options', 'controlled-chaos-plugin' ),
			'manage_options',
			CCP_ADMIN_SLUG . '-scripts',
			[ $this, 'settings_scripts_output' ]
		);

		// Add content to the Help tab.
		add_action( 'load-' . $this->help_scripts, [ $this, 'help_scripts' ] );

	}

	/**
	 * Script Options page output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function settings_scripts_output() {
		
		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-scripts.php';

	}

	/**
     * Output for the Script Options page contextual help tab.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function help_scripts() {

		// Add to the plugin settings pages.
		$screen = get_current_screen();
		if ( $screen->id != $this->help_scripts ) {
			return;
		}
		
		// Inline Scripts.
		$screen->add_help_tab( [
			'id'       => 'inline_scripts',
			'title'    => __( 'Inline Scripts', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_inline_scripts' ]
		] );
		
		// Inline Scripts.
		$screen->add_help_tab( [
			'id'       => 'inline_jquery',
			'title'    => __( 'Inline jQuery', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_inline_jquery' ]
		] );
		
		// Remove Emoji Scripts.
		$screen->add_help_tab( [
			'id'       => 'remove_emoji',
			'title'    => __( 'Emoji Script', 'controlled-chaos-plugin' ),
			'content'  => null,
			'callback' => [ $this, 'help_remove_emoji' ]
		] );
		
		// Add a help sidebar.
		$screen->set_help_sidebar(
			$this->help_scripts_sidebar()
		);
		
	}

	/**
     * Get Inline Scripts help content.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_inline_scripts() { 
		
		include_once plugin_dir_path( __FILE__ ) . 'partials/help/help-inline-scripts.php';
	
	}

	/**
     * Get Inline jQuery help content.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_inline_jquery() { 
		
		include_once plugin_dir_path( __FILE__ ) . 'partials/help/help-inline-jquery.php';
	
	}

	/**
     * Get Remove Emoji Script help content.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
	public function help_remove_emoji() { 
		
		include_once plugin_dir_path( __FILE__ ) . 'partials/help/help-remove-emoji.php';
	
	}

	/**
     * Get Script Options page contextual tab sidebar content.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
     */
    public function help_scripts_sidebar() {

		$html = '<ul>
			<li><a href="https://github.com/kenwheeler/slick" target="_blank" style="text-decoration: none;">' . __( 'Slick on GitHub', 'controlled-chaos-plugin' ) . '</a></li>
			<li><a href="https://github.com/vdw/Tabslet" target="_blank" style="text-decoration: none;">' . __( 'Tabslet on GitHub', 'controlled-chaos-plugin' ) . '</a></li>
			<li><a href="https://github.com/leafo/sticky-kit" target="_blank" style="text-decoration: none;">' . __( 'Sticky-kit on GitHub', 'controlled-chaos-plugin' ) . '</a></li>
			<li><a href="https://github.com/iamceege/tooltipster" target="_blank" style="text-decoration: none;">' . __( 'Tooltipster on GitHub', 'controlled-chaos-plugin' ) . '</a></li>
		</ul>';

		return $html;

	}

	/**
	 * Register settings via the WordPress Settings API.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function settings() {

		/**
		 * Generl script options.
		 */
		add_settings_section( 'ccp-scripts-general', __( 'General Options', 'controlled-chaos-plugin' ), [ $this, 'scripts_general_section_callback' ], 'ccp-scripts-general' );

		// Inline scripts.
		add_settings_field( 'ccp_inline_scripts', __( 'Inline Scripts', 'controlled-chaos-plugin' ), [ $this, 'ccp_inline_scripts_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Add script contents to footer', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_inline_scripts'
		);

		// Inline styles.
		add_settings_field( 'ccp_inline_styles', __( 'Inline Styles', 'controlled-chaos-plugin' ), [ $this, 'ccp_inline_styles_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Add script-related CSS contents to head', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_inline_styles'
		);

		// Inline jQuery.
		add_settings_field( 'ccp_inline_jquery', __( 'Inline jQuery', 'controlled-chaos-plugin' ), [ $this, 'ccp_inline_jquery_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Deregister jQuery and add its contents to footer', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_inline_jquery'
		);

		// Include jQuery Migrate.
		add_settings_field( 'ccp_jquery_migrate', __( 'jQuery Migrate', 'controlled-chaos-plugin' ), [ $this, 'ccp_jquery_migrate_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Use jQuery Migrate for backwards compatibility', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_jquery_migrate'
		);

		// Remove emoji script.
		add_settings_field( 'ccp_remove_emoji_script', __( 'Emoji Script', 'controlled-chaos-plugin' ), [ $this, 'remove_emoji_script_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Remove emoji script from <head>', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_remove_emoji_script'
		);
		
		// Remove WordPress version appended to script links.
		add_settings_field( 'ccp_remove_script_version', __( 'Script Versions', 'controlled-chaos-plugin' ), [ $this, 'remove_script_version_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Remove WordPress version from script and stylesheet links in <head>', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_remove_script_version'
		);

		// Minify HTML.
		add_settings_field( 'ccp_html_minify', __( 'Minify HTML', 'controlled-chaos-plugin' ), [ $this, 'html_minify_callback' ], 'ccp-scripts-general', 'ccp-scripts-general', [ esc_html__( 'Minify HTML source code to increase load speed', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-general',
			'ccp_html_minify'
		);

		/**
		 * Use included vendor scripts & options.
		 */
		add_settings_section( 'ccp-scripts-vendor', __( 'Included Vendor Scripts', 'controlled-chaos-plugin' ), [ $this, 'scripts_vendor_section_callback' ], 'ccp-scripts-vendor' );

		// Use Slick.
		add_settings_field( 'ccp_enqueue_slick', __( 'Slick', 'controlled-chaos-plugin' ), [ $this, 'enqueue_slick_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Slick script and stylesheets', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_slick'
		);

		// Use Tabslet.
		add_settings_field( 'ccp_enqueue_tabslet', __( 'Tabslet', 'controlled-chaos-plugin' ), [ $this, 'enqueue_tabslet_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Tabslet script', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_tabslet'
		);

		// Use Sticky-kit.
		add_settings_field( 'ccp_enqueue_stickykit', __( 'Sticky-kit', 'controlled-chaos-plugin' ), [ $this, 'enqueue_stickykit_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Sticky-kit script', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_stickykit'
		);

		// Use Tooltipster.
		add_settings_field( 'ccp_enqueue_tooltipster', __( 'Tooltipster', 'controlled-chaos-plugin' ), [ $this, 'enqueue_tooltipster_callback' ], 'ccp-scripts-vendor', 'ccp-scripts-vendor', [ esc_html__( 'Use Tooltipster script and stylesheet', 'controlled-chaos-plugin' ) ] );

		register_setting(
			'ccp-scripts-vendor',
			'ccp_enqueue_tooltipster'
		);
	
		// Site Settings section.
		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			add_settings_section( 'ccp-registered-fields-activate', __( 'Registered Fields Activation', 'controlled-chaos-plugin' ), [ $this, 'registered_fields_activate' ], 'ccp-registered-fields-activate' );
			
			add_settings_field( 'ccp_acf_activate_settings_page', __( 'Site Settings Page', 'controlled-chaos-plugin' ), [ $this, 'registered_fields_page_callback' ], 'ccp-registered-fields-activate', 'ccp-registered-fields-activate', [ __( 'Deactive the field group for the "Site Settings" options page.', 'controlled-chaos-plugin' ) ] );

			register_setting(
				'ccp-registered-fields-activate',
				'ccp_acf_activate_settings_page'
			);

		}

	}

	/**
	 * General section callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function scripts_general_section_callback( $args ) {

		$html = sprintf( '<p>%1s</p>', esc_html__( 'Inline settings only apply to scripts and styles included with the plugin.' ) );

		echo $html;

	}

	/**
	 * Inline jQuery.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function ccp_inline_jquery_callback( $args ) {

		$option = get_option( 'ccp_inline_jquery' );

		$html = '<p><input type="checkbox" id="ccp_inline_jquery" name="ccp_inline_jquery" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_inline_jquery"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Include jQuery Migrate.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function ccp_jquery_migrate_callback( $args ) {

		$option = get_option( 'ccp_jquery_migrate' );

		$html = '<p><input type="checkbox" id="ccp_jquery_migrate" name="ccp_jquery_migrate" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_jquery_migrate"> '  . $args[0] . '</label><br />';

		$html .= '<small><em>Some outdated plugins and themes may be dependent on an old version of jQuery</em></small></p>';

		echo $html;

	}

	/**
	 * Inline scripts.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function ccp_inline_scripts_callback( $args ) {

		$option = get_option( 'ccp_inline_scripts' );

		$html = '<p><input type="checkbox" id="ccp_inline_scripts" name="ccp_inline_scripts" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_inline_scripts"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Inline styles.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function ccp_inline_styles_callback( $args ) {

		$option = get_option( 'ccp_inline_styles' );

		$html = '<p><input type="checkbox" id="ccp_inline_styles" name="ccp_inline_styles" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_inline_styles"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Remove emoji script.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function remove_emoji_script_callback( $args ) {

		$option = get_option( 'ccp_remove_emoji_script' );

		$html = '<p><input type="checkbox" id="ccp_remove_emoji_script" name="ccp_remove_emoji_script" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_remove_emoji_script"> '  . $args[0] . '</label><br />';

		$html .= '<small><em>Emojis will still work in modern browsers</em></small></p>';

		echo $html;

	}

	/**
	 * Script options and enqueue settings.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function remove_script_version_callback( $args ) {

		$option = get_option( 'ccp_remove_script_version' );

		$html = '<p><input type="checkbox" id="ccp_remove_script_version" name="ccp_remove_script_version" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_remove_script_version"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Minify HTML source code.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function html_minify_callback( $args ) {

		$option = get_option( 'ccp_html_minify' );

		$html = '<p><input type="checkbox" id="ccp_html_minify" name="ccp_html_minify" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_html_minify"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Vendor section callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function scripts_vendor_section_callback( $args ) {

		$html = sprintf( '<p>%1s</p>', esc_html__( 'Look for Fancybox options on the Media Settings page.' ) );

		echo $html;

	}

	/**
	 * Use Slick.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enqueue_slick_callback( $args ) {

		$option = get_option( 'ccp_enqueue_slick' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_slick" name="ccp_enqueue_slick" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_slick"> '  . $args[0] . '</label>';

		echo $html;

	}

	/**
	 * Use Tabslet.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enqueue_tabslet_callback( $args ) {

		$option = get_option( 'ccp_enqueue_tabslet' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_tabslet" name="ccp_enqueue_tabslet" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_tabslet"> '  . $args[0] . '</label>';

		echo $html;

	}

	/**
	 * Use Sticky-kit.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enqueue_stickykit_callback( $args ) {

		$option = get_option( 'ccp_enqueue_stickykit' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_stickykit" name="ccp_enqueue_stickykit" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_stickykit"> '  . $args[0] . '</label>';

		echo $html;

	}

	/**
	 * Use Tooltipster.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function enqueue_tooltipster_callback( $args ) {

		$option = get_option( 'ccp_enqueue_tooltipster' );

		$html = '<p><input type="checkbox" id="ccp_enqueue_tooltipster" name="ccp_enqueue_tooltipster" value="1" ' . checked( 1, $option, false ) . '/>';
		
		$html .= '<label for="ccp_enqueue_tooltipster"> '  . $args[0] . '</label>';

		echo $html;

	}

	/**
	 * Site Settings section.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function registered_fields_activate() {

		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			echo sprintf( '<p>%1s</p>', esc_html( 'The Controlled Chaos plugin registers custom fields for Advanced Custom Fields Pro that can be imported for editing. These built-in field goups must be deactivated for the imported field groups to take effect.', 'controlled-chaos-plugin' ) );

		}

	}

	/**
	 * Site Settings section callback.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return string
	 */
	public function registered_fields_page_callback( $args ) {
		
		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			$html = '<p><input type="checkbox" id="ccp_acf_activate_settings_page" name="ccp_acf_activate_settings_page" value="1" ' . checked( 1, get_option( 'ccp_acf_activate_settings_page' ), false ) . '/>';
			
			$html .= '<label for="ccp_acf_activate_settings_page"> '  . $args[0] . '</label></p>';
			
			echo $html;
			
		}

	}

    /**
	 * Add a page for site settings.
	 * 
	 * If the Advanced Custom Fields Pro plugin is active then
	 * an ACF options page and ACF fields will be used. If not
	 * then a default WordPress admin page and the WP Settings
	 * API will be used.
	 * 
	 * @since  1.0.0
	 * @access public
	 * @return void
	 * 
	 * @todo  Think about whether this is a good idea. Maybe it's
	 *        better to simply provide a sample ACF page. ACF is
	 *        certainly faster for further development but do we
	 *        want the dependency?
	 */
    public function site_settings_page() {

		if ( class_exists( 'acf_pro' ) || ( class_exists( 'acf' ) && class_exists( 'acf_options_page' ) ) ) {

			$title      = apply_filters( 'site_settings_page_name', get_bloginfo( 'name' ) );
			$position   = get_field( 'ccp_settings_link_position', 'option' );
			$link_label = get_field( 'ccp_settings_page_link_label', 'option' );

			if ( $link_label ) {
				$label = $link_label;
			}  else {
				$label = __( 'Site Settings', 'controlled-chaos-plugin' );
			}

			if ( 'top' == $position ) {
					
				$settings = apply_filters( 'controlled_chaos_site_settings_page_top', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos-plugin' ),
					'menu_title' => $label,
					'menu_slug'  => CCP_ADMIN_SLUG . '-settings',
					'icon_url'   => 'dashicons-admin-settings',
					'position'   => 59,
					'capability' => 'manage_options',
					'redirect'   => false
				] );
				acf_add_options_page( $settings );
				remove_menu_page( 'options-general.php' );

			} else {

				$settings = apply_filters( 'controlled_chaos_site_settings_page_default', [
					'page_title' => $title . __( ' Settings', 'controlled-chaos-plugin' ),
					'menu_title' => $label,
					'menu_slug'  => CCP_ADMIN_SLUG . '-settings',
					'parent'     => 'index.php',
					'capability' => 'manage_options'
				] );
				acf_add_options_page( $settings );

			}

		} else {

			$link_label = get_option( 'ccp_settings_page_link_label' );
			$position   = get_option( 'ccp_settings_position' );
			$link_icon  = get_option( 'ccp_settings_page_link_icon' );

			if ( $link_label ) {
				$label = $link_label;
			}  else {
				$label = __( 'Site Settings', 'controlled-chaos-plugin' );
			}

			if ( $link_icon ) {
				$icon = $link_icon;
			}  else {
				$icon = __( 'dashicons-admin-settings', 'controlled-chaos-plugin' );
			}

			if ( $position ) {
				add_menu_page(
					$label,
					$label,
					'manage_options',
					CCP_ADMIN_SLUG . '-settings',
					[ $this, 'settings_site_output' ],
					$icon,
					3
				);
			} else {
				add_submenu_page(
					'index.php',
					$label,
					$label,
					'manage_options',
					CCP_ADMIN_SLUG . '-settings',
					[ $this, 'settings_site_output' ]
				);
			}

		}

	}

	/**
	 * Site Settings page output.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function settings_site_output() {
		
		require plugin_dir_path( __FILE__ ) . 'partials/settings-page-site.php';

	}

	/**
	 * Include jQuery Migrate.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
    public function include_jquery_migrate( $scripts ) {
		
		if ( ! empty( $scripts->registered['jquery'] ) ) {

			$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, [ 'jquery-migrate' ] );

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
function ccp_settings() {

	return Settings::instance();

}

// Run an instance of the class.
ccp_settings();