<?php
/**
 * Post types and taxonomies.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Includes\Post_Types_Taxes
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccpzine.com>
 * @author     Jeremy Felt <jeremy.felt@gmail.com>
 */

namespace CC_Plugin\Includes\Post_Types_Taxes;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * If the Custom Posts per Page plugin is active then stop here.
 *
 * @since  1.0.0
 * @return void
 */
if ( class_exists( 'Custom_Posts_Per_Page_Foghlaim' ) ) {
	return;
}

/**
 * The core plugin class
 *
 * Defines constants and variables, gets the initialization class file
 * plus the activation and deactivation classes.
 *
 * Originally from a plugin maintained by Jeremy Felt, 2011-2014.
 *
 * @link   https://jeremyfelt.com/wordpress/plugins/posts-per-page/
 * @link   https://wordpress.org/plugins/custom-posts-per-page/
 *
 * @since  1.0.0
 * @access public
 */
class Posts_Per_Page {

	/**
	 * When our first page has a different count than subsequent pages, we need to make
	 * sure the offset value is selected in order for the query to be as aware as us.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var int contains the offset to pass to the query
	 */
	private $page_count_offset = 0;

	/**
	 * We'll want to share some data about the final determinations we've made concerning
	 * the page view amongst methods. This is a good a container as any for it.
	 *
	 * @since     1.0.0
	 * @access    private
	 * @var array containing option data
	 */
	private $final_options = [];

	/**
	 * If we're on page 1, this will always be false. But if we do land on a page 2 or more,
	 * we'll be rocking true and can use that info.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var bool indication of whether a paged view has been requested
	 */
	private $paged_view = false;

	/**
	 * If we're on page 1 of a big view, WordPress will give us 0. But it will report 2 and
	 * above, so we should be aware.
	 *
	 * @since   1.0.0
	 * @access  private
	 * @var int containing the currently viewed page number
	 */
	private $page_number = 1;

	/**
	 * Get an instance of the class.
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
	 * Our pre_get_posts action should only happen on non admin screens
	 * otherwise things get weird.
	 *
	 * @since  1.0.0
	 * @access private
	 * @return self
	 */
	private function __construct() {

		register_activation_hook( __FILE__, [ $this, 'upgrade_check' ] );

		add_action( 'admin_init', [ $this, 'register_settings' ] );

		add_action( 'admin_menu', [ $this, 'add_settings' ] );

		if ( ! is_admin() ) {
			add_action( 'pre_get_posts', [ $this, 'modify_query' ] );
		}

	}

	/**
	 * Activate the plugin when it is activated through the admin screen, or if it is upgraded
	 * and we find that things are out of date in upgrade_check.
	 *
	 * When first activated, we set some default values in an options array. The default value
	 * is pulled from the current 'posts_per_page' option so that nothing changes unexpectedly.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function activate() {

		$default_count     = get_option( 'posts_per_page' );
		$current_options   = get_option( 'ccp_ppp_options' );
		$default_options   = [];
		$option_type_array = [ 'front', 'category', 'tag', 'author', 'archive', 'search', 'default' ];

		foreach ( $option_type_array as $option_type ) {

			$default_options[ $option_type . '_count' ] = absint( $default_count );

			/* For some users that are upgrading from a past version, we want to make sure the paged count
			 * is filled in with something appropriate. This looks for each option in order. */
			if ( ! empty( $cppc_options[ $option_type . '_count_paged' ] ) ) {
				$default_options[ $option_type . '_count_paged' ] = absint( $current_options[ $option_type . '_count_paged' ] );
			} elseif ( ! empty( $ccp_ppp_options[ $option_type . '_count' ] ) ) {
				$default_options[ $option_type . '_count_paged' ] = absint( $current_options[ $option_type . '_count' ] );
			} else {
				$default_options[ $option_type . '_count_paged' ] = absint( $default_count );
			}

		}

		/*  We'll also get all of the currently registered custom post types and give them a default value
		 *  of 0 if one has not previously been set. Custom post types are a special breed and we don't
		 *  necessarily want them to match the default posts_per_page value without a conscious decision
		 *  by the user. */
		$all_post_types = get_post_types( [ '_builtin' => false ] );

		foreach ( $all_post_types as $p => $k ) {

			if ( isset( $current_options[ $p . '_count' ] ) ) {
				$default_options[ $p . '_count' ] = absint( $current_options[ $p . '_count' ] );
			} else {
				$default_options[ $p . '_count' ] = 0;
			}

			if ( isset( $current_options[ $p . '_count_paged' ] ) ) {
				$default_options[ $p . '_count_paged' ] = absint( $current_options[ $p . '_count_paged' ] );
			} else {
				$default_options[ $p . '_count_paged' ] = 0;
			}
		}

		update_option( 'ccp_ppp_options', $default_options );

	}

	/**
	 * Add the settings page for Posts Per Page under the settings menu.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function add_settings() {
		add_options_page( __( 'Posts Per Page', 'controlled-chaos-plugin' ), __( 'Posts Per Page', 'controlled-chaos-plugin' ), 'manage_options', 'posts-per-page', [ $this, 'view_settings' ] );
	}

	/**
	 * Display the main settings view for the plugin.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function view_settings() {

		?>
		<div class="wrap posts-per-page">
			<div class="icon32" id="icon-options-general"></div>
			<h1><?php _e( 'Posts Per Page', 'controlled-chaos-plugin' ); ?></h1>
			<h2><?php _e( 'Overview', 'controlled-chaos-plugin' ); ?></h2>
			<p><?php _e( 'The settings below allow you to specify how many posts per page are displayed to readers depending on the which type of page is being viewed.' ); ?></p>
			<p><?php _e( 'Different values can be set for your your main view, category views, tag views, author views, archive views, search views, and
			views for custom post types. For each of these views, a different setting is available for the first page and subsequent pages. In addition to these, a default value is available that
			can be set for any other pages not covered by this.', 'controlled-chaos-plugin' ); ?></p>
			<p><?php _e( 'The initial value used on activation was pulled from the setting <em>Blog Pages show at most</em> found in the', 'controlled-chaos-plugin' ); ?> <a href="<?php echo site_url( '/wp-admin/options-reading.php' ); ?>" title="Reading Settings"><?php _e( 'Reading Settings', 'controlled-chaos-plugin' ); ?></a></p>
			<form method="post" action="options.php">
				<?php
					settings_fields( 'ccp_ppp_options' );
					do_settings_sections( 'ccp_ppp' );
					do_settings_sections( 'ccp_ppp_custom' );
				?>
			<p class="submit"><input type="submit" class="button-primary" value="<?php _e( 'Save Changes', 'controlled-chaos-plugin' ); ?>" /></p></form>
		</div>
		<?php
	}

	/**
	 * Register all of the settings we'll be using.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function register_settings() {

		register_setting( 'ccp_ppp_options', 'ccp_ppp_options', [ $this, 'validate_options'] );

		add_settings_section( 'ccp_ppp_section_main', '', [ $this, 'output_main_section_text' ], 'ccp_ppp' );
		add_settings_section( 'ccp_ppp_section_custom', '', [ $this, 'output_custom_section_text' ], 'ccp_ppp_custom' );

		add_settings_field( 'ccp_ppp_index_count',     __( 'Main Index posts per page', 'controlled-chaos-plugin' ), [ $this, 'output_index_count_text' ],    'ccp_ppp', 'ccp_ppp_section_main' );
		add_settings_field( 'ccp_ppp_category_count',  __( 'Category posts per page', 'controlled-chaos-plugin' ),   [ $this, 'output_category_count_text' ], 'ccp_ppp', 'ccp_ppp_section_main' );
		add_settings_field( 'ccp_ppp_archive_count',   __( 'Archive posts per page', 'controlled-chaos-plugin' ),    [ $this, 'output_archive_count_text' ],  'ccp_ppp', 'ccp_ppp_section_main' );
		add_settings_field( 'ccp_ppp_tag_count',       __( 'Tag posts per page', 'controlled-chaos-plugin' ),        [ $this, 'output_tag_count_text' ],      'ccp_ppp', 'ccp_ppp_section_main' );
		add_settings_field( 'ccp_ppp_author_count',    __( 'Author posts per page', 'controlled-chaos-plugin' ),     [ $this, 'output_author_count_text' ],   'ccp_ppp', 'ccp_ppp_section_main' );
		add_settings_field( 'ccp_ppp_search_count',    __( 'Search posts per page', 'controlled-chaos-plugin' ),     [ $this, 'output_search_count_text' ],   'ccp_ppp', 'ccp_ppp_section_main' );
		add_settings_field( 'ccp_ppp_default_count',   __( 'Default posts per page', 'controlled-chaos-plugin' ),    [ $this, 'output_default_count_text' ],  'ccp_ppp', 'ccp_ppp_section_main' );

		add_settings_field( 'ccp_ppp_post_type_count', '', [ $this, 'output_post_type_count_text' ], 'ccp_ppp_custom', 'ccp_ppp_section_custom' );

	}

	/**
	 * Validate the values entered by the user.
	 *
	 * We aren't doing heavy validation yet, more like a passive aggressive failure.
	 * If you enter anything other than an integer, the value will be set to 0 by
	 * default and if a negative value is inputted, it will be corrected to positive.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $input array of counts destined to be used as posts_per_page options
	 * @return array the same array with absint run on each
	 */
	public function validate_options( $input ) {
		return array_map( 'absint', $input );
	}

	/**
	 * Output the main section of text.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_main_section_text() {
		?>
		<h2><?php _e( 'Main Settings', 'controlled-chaos-plugin' ); ?></h2>
		<p><?php _e( 'This section allows you to modify page view types that are
		associated with WordPress by default. When an option is set to 0, it will not modify any page requests for
		that view and will instead allow default values to pass through.', 'controlled-chaos-plugin' ); ?></p>
		<p><?php _e( 'Please Note', 'controlled-chaos-plugin' ); ?>:
		<em><?php _e( 'For each setting, the box on the LEFT controls the the number of posts displayed on	the first page of that view while
		the box on the RIGHT controls the number of posts seen on pages 2, 3, 4, etc... of that view.', 'controlled-chaos-plugin' ); ?></em></p>
		<?php
	}

	/**
	 * Output the custom post type section of text.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_custom_section_text() {

		?>
		<h2><?php _e( 'Custom Post Type Specific Settings', 'controlled-chaos-plugin' ); ?></h2>
		<p><?php _e( 'This section contains a list of all of your registered custom post
		types. In order to not conflict with other plugins or themes, these are set to 0 by default. When an option is
		set to 0, it will not modify any page requests for that custom post type archive. For Custom Posts Per Page to
		control the number of posts to display, these will need to be changed.', 'custom-post-per-page' ); ?></p>
		<?php

	}

	/**
	 * Output the individual options for each custom post type registered in WordPress.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_post_type_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options' );

		// Arguments for post types displayed on the settings page.
		$args = [
			'public'   => true,
			'_builtin' => false
		];
		$args            = apply_filters( 'ccp_output_post_type_count_text', $args );
		$all_post_types  = get_post_types( $args );

		/* Quirky little workaround for displaying the settings in our table */
		echo '</td><td></td></tr>';

		foreach ( $all_post_types as $p => $k ) {

			/*	Default values are assigned for custom post types that are available
			 *  to us when our plugin is registered. If a custom post type becomes
			 *  available after our plugin is installed, we'll want to catch it and
			 *  assign a good value. */
			if ( empty( $ccp_ppp_options[ $p . '_count' ] ) ) {
				$ccp_ppp_options[ $p . '_count' ] = 0;
			}

			if ( empty( $ccp_ppp_options[ $p . '_count_paged' ] ) ) {
				$ccp_ppp_options[ $p . '_count_paged' ] = 0;
			}

			$this_post_data = get_post_type_object( $p );

			?>
			<tr>
				<th><?php echo $this_post_data->labels->name; ?></th>
				<td>
					<label for="ccp_ppp_post_type_count[<?php echo esc_attr( $p ); ?>]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_post_type_count[<?php echo esc_attr( $p ); ?>]" name="ccp_ppp_options[<?php echo esc_attr( $p ); ?>_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ $p . '_count' ] ); ?>" />
					&nbsp;
					<label for="ccp_ppp_post_type_count[<?php echo esc_attr( $p ); ?>]"><?php _e( 'Subsequent Pages:', 'tims' ); ?></label> <input id="ccp_ppp_post_type_count[<?php echo esc_attr( $p ); ?>]" name="ccp_ppp_options[<?php echo esc_attr( $p ); ?>_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ $p . '_count_paged' ] ); ?>" />
				</td>
			</tr>
			<?php
		}

	}

	/**
	 * Display the input field for the index page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_index_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'front_count' => 0, 'front_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_index_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_index_count[0]" name="ccp_ppp_options[front_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'front_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_index_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_index_count[1]" name="ccp_ppp_options[front_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'front_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * Display the input field for the category page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_category_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'category_count' => 0, 'category_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_category_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_category_count[0]" name="ccp_ppp_options[category_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'category_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_category_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_category_count[1]" name="ccp_ppp_options[category_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'category_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * Display the input field for the archive page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_archive_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'archive_count' => 0, 'archive_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_archive_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_archive_count[0]" name="ccp_ppp_options[archive_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'archive_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_archive_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_archive_count[1]" name="ccp_ppp_options[archive_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'archive_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * Display the input field for the tag page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_tag_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'tag_count' => 0, 'tag_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_tag_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_tag_count[0]" name="ccp_ppp_options[tag_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'tag_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_tag_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_tag_count[1]" name="ccp_ppp_options[tag_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'tag_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * Display the input field for the author page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_author_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'author_count' => 0, 'author_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_author_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_author_count[0]" name="ccp_ppp_options[author_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'author_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_author_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_author_count[1]" name="ccp_ppp_options[author_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'author_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * Display the input field for the search page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_search_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'search_count' => 0, 'search_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_search_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_search_count[0]" name="ccp_ppp_options[search_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'search_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_search_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_search_count[1]" name="ccp_ppp_options[search_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'search_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * Display the input field for the default page post count option.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 */
	public function output_default_count_text() {

		$ccp_ppp_options = get_option( 'ccp_ppp_options', [ 'default_count' => 0, 'default_count_paged' => 0 ] );

		?>
		<label for="ccp_ppp_default_count[0]"><?php _e( 'First Page:', 'tims' ); ?> </label> <input id="ccp_ppp_default_count[0]" name="ccp_ppp_options[default_count]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'default_count' ] ); ?>" />
		&nbsp;
		<label for="ccp_ppp_default_count[1]"><?php _e( 'Subsequent Pages:', 'tims' ); ?> </label> <input id="ccp_ppp_default_count[1]" name="ccp_ppp_options[default_count_paged]" size="3" type="text" value="<?php echo esc_attr( $ccp_ppp_options[ 'default_count_paged' ] ); ?>" />
		<?php
	}

	/**
	 * This is the important part of the plugin that actually modifies the query before anything
	 * is displayed.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $query WP Query object
	 * @return mixed
	 */
	public function modify_query( $query ) {

		/*  If this isn't the main query, we'll avoid altering the results. */
		if ( ! $query->is_main_query() || is_admin() ) {
			return;
		}

		$ccp_ppp_options = get_option( 'ccp_ppp_options' );
		$all_post_types  = get_post_types( [ '_builtin' => false ] );
		$post_type_array = [];

		foreach ( $all_post_types as $p=> $k ) {
			$post_type_array[] = $p;
		}

		$this->paged_view = ( $query->get( 'paged' ) && 2 <= $query->get( 'paged' ) ) ? true : false;
		$this->page_number = $query->get( 'paged' );

		if ( $query->is_home() ) {
			$this->process_options( 'front', $ccp_ppp_options );
		} elseif ( $query->is_post_type_archive( $post_type_array ) ) {
			$current_post_type_object = $query->get_queried_object();
			$this->process_options( $current_post_type_object->name, $ccp_ppp_options );
		} elseif ( $query->is_category() ) {
			$this->process_options( 'category', $ccp_ppp_options );
		} elseif ( $query->is_tag() ) {
			$this->process_options( 'tag', $ccp_ppp_options );
		} elseif ( $query->is_author() ) {
			$this->process_options( 'author', $ccp_ppp_options );
		} elseif ( $query->is_search() ) {
			$this->process_options( 'search', $ccp_ppp_options );
		} elseif ( $query->is_archive() ) {
			/*  Note that the check for is_archive needs to be below anything else that WordPress may consider an
			 *  archive. This includes is_tag, is_category, is_author and probably some others.	*/
			$this->process_options( 'archive', $ccp_ppp_options );
		} else {
			$this->process_options( 'default', $ccp_ppp_options );
		}

		if ( isset( $this->final_options['posts'] ) ) {
			$query->set( 'posts_per_page', absint( $this->final_options['posts'] ) );
			$query->set( 'offset', absint( $this->final_options['offset'] ) );
		}

		add_filter( 'found_posts', [ $this, 'correct_found_posts' ] );

	}

	/**
	 * The offset and post count deal gets a bit confused when the first page and subsequent pages stop matching.
	 * This function helps realign things once we've screwed with them by doing some math to determine how many
	 * posts we need to return to the query in order for core to calculate the correct number of pages required.
	 *
	 * It should be noted here that found_posts is modified if the value of posts per page is different for page 1
	 * than subsequent pages. This is intended to resolve pagination issues in popular WordPress plugins, but can
	 * possibly cause related issues for other things that are depending on an exact found posts value.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $found_posts int The number of found posts
	 * @return mixed The number of posts to report as found for real
	 */
	public function correct_found_posts( $found_posts ) {

		if ( empty( $this->final_options['set_count'] ) || empty( $this->final_options['set_count_paged'] ) ) {
			return $found_posts;
		}

		// We don't have the same issues if our first page and paged counts are the same as the math is easy then
		if ( $this->final_options['set_count'] === $this->final_options['set_count_paged'] ) {
			return $found_posts;
		}

		// Do the true calculation for pages required based on both
		// values: page 1 posts count and subsequent page post counts
		$pages_required = ( ( ( $found_posts - $this->final_options['set_count'] ) / $this->final_options['set_count_paged'] ) + 1 );

		if ( 0 === $this->page_number ) {
			return $pages_required * $this->final_options['set_count'];
		}

		if ( 1 < $this->page_number ) {
			return $pages_required * $this->final_options['set_count_paged'];
		}

		return $found_posts;

	}

	/**
	 * We use this function to abstract the processing of options while we determine what
	 * type of view we're working with and what to use for the count on the initial page
	 * and subsequent pages. The options are stored in a private property that allows us
	 * access throughout the class after this.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  $option_prefix string prefix of the count and count_paged options in the database.
	 * @param  $ccp_ppp_options array of options from the database for custom posts per page.
	 * @return void
	 */
	public function process_options( $option_prefix, $ccp_ppp_options ) {

		if ( ! $this->paged_view && ! empty( $ccp_ppp_options[ $option_prefix . '_count' ] ) ) {

			$this->final_options['posts']  = $ccp_ppp_options[ $option_prefix . '_count' ];
			$this->final_options['offset'] = 0;
			$this->final_options['set_count'] = $ccp_ppp_options[ $option_prefix . '_count' ];
			$this->final_options['set_count_paged'] = $ccp_ppp_options[ $option_prefix . '_count_paged' ];

		} elseif ( $this->paged_view & ! empty( $ccp_ppp_options[ $option_prefix . '_count_paged' ] ) ) {

			$this->page_count_offset = ( $ccp_ppp_options[ $option_prefix . '_count_paged' ] - $ccp_ppp_options[ $option_prefix . '_count' ] );
			$this->final_options['offset']  = ( ( $this->page_number - 2 ) * $ccp_ppp_options[ $option_prefix . '_count_paged' ] + $ccp_ppp_options[ $option_prefix . '_count' ] );
			$this->final_options['posts']   = $ccp_ppp_options[ $option_prefix . '_count_paged' ];
			$this->final_options['set_count'] = $ccp_ppp_options[ $option_prefix . '_count' ];
			$this->final_options['set_count_paged'] = $ccp_ppp_options[ $option_prefix . '_count_paged' ];

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
function ccp_posts_per_page() {

	return Posts_Per_Page::instance();

}

// Run an instance of the class.
ccp_posts_per_page();