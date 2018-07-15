<?php
/**
 * Settings for site customization.
 *
 * Uses the CCA_PARENT_PREFIX constant to get the options prefix
 * used in the parent plugin.
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
 * Settings for site customization.
 *
 * @since  1.0.0
 * @access public
 */
class Settings_Fields_Site {

	/**
	 * Holds the values to be used in the fields callbacks.
	 *
	 * @var array
	 */
	private $options;

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

		// Register settings sections and fields.
		add_action( 'admin_init', [ $this, 'settings' ] );

	}

	/**
	 * Plugin site settings.
	 *
	 * @since  1.0.0
	 * @access public
	 * @return void
	 *
	 * @link  https://codex.wordpress.org/Settings_API
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

		// Use the custom welcome panel.
		add_settings_field(
			'ccp_custom_welcome',
			__( 'Custom Welcome', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_custom_welcome_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Use the custom Welcome panel on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_custom_welcome'
		);

		// Hide the welcome panel.
		add_settings_field(
			'ccp_hide_welcome',
			__( 'Hide Welcome', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_hide_welcome_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Hide the Welcome panel on the Dashboard', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_hide_welcome'
		);

		// Hide the welcome panel dismiss button.
		add_settings_field(
			'ccp_remove_welcome_dismiss',
			__( 'Remove Welcome Dismiss', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_remove_welcome_dismiss_callback' ],
			'ccp-site-dashboard',
			'ccp-site-dashboard',
			[ esc_html__( 'Remove the Welcome panel dismiss button', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-dashboard',
			'ccp_remove_welcome_dismiss'
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
			'ccp-site-dashboard',
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
			'ccp-site-dashboard',
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
			'ccp-site-dashboard',
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
			'ccp-site-dashboard',
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

		// Site Settings page position.
		add_settings_field(
			'ccp_site_settings_position',
			__( 'Site Settings Position', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_site_settings_position_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make this settings page a top-level link.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_settings_position'
		);

		// Site Settings page link label.
		add_settings_field(
			'ccp_site_settings_link_label',
			__( 'Site Settings Label', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_site_settings_link_label_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Change the label of the link to this page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_settings_link_label'
		);

		// Site Settings page link icon if set to top level.
		add_settings_field(
			'ccp_site_settings_link_icon',
			__( 'Site Settings Icon', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_site_settings_link_icon_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Enter a Dashicons CSS class for the icon of the link to this page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_settings_link_icon'
		);

		// Site Plugin page position.
		add_settings_field(
			'ccp_site_plugin_position',
			__( 'Site Plugin Position', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_site_plugin_position_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Make the site-specific plugin admin page a top-level link.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_plugin_position'
		);

		// Site Plugin page link label.
		add_settings_field(
			'ccp_site_plugin_link_label',
			__( 'Site Plugin Label', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_site_plugin_link_label_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Change the label of the link to the site-specific plugin page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_plugin_link_label'
		);

		// Site Plugin page link icon if set to top level.
		add_settings_field(
			'ccp_site_plugin_link_icon',
			__( 'Site Plugin Icon', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_site_plugin_link_icon_callback' ],
			'ccp-site-admin-menu',
			'ccp-site-admin-menu',
			[ esc_html__( 'Enter a Dashicons CSS class for the icon of the link to the site-specific plugin page', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-admin-menu',
			'ccp_site_plugin_link_icon'
		);

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
			'ccp_meta_disable',
			__( 'Meta Tags', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_meta_disable_callback' ],
			'ccp-site-meta-seo',
			'ccp-site-meta-seo',
			[ esc_html__( 'Disable if your theme includes SEO meta tags or if you plan on using an SEO plugin.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-meta-seo',
			'ccp_meta_disable'
		);

		// Organization Schema type.
		add_settings_field(
			'ccp_meta_type',
			__( 'Organization Type', 'controlled-chaos-plugin' ),
			[ $this, 'ccp_meta_type_callback' ],
			'ccp-site-meta-seo',
			'ccp-site-meta-seo',
			[ esc_html__( 'Select a category that generally applies to this website.', 'controlled-chaos-plugin' ) ]
		);

		register_setting(
			'ccp-site-meta-seo',
			'ccp_meta_type'
		);

	}

	/**
	 * Organization Schema type callback.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args
	 * @return string Returns the select box of options.
	 */
	public function  ccp_meta_type_callback( $args ) {

		$types = [
			
			// First option save null.
			null          => __( 'Select one&hellip;', 'controlled-chaos-plugin' ),
			'Airline'     => __( 'Airline', 'controlled-chaos-plugin' ),
			'Corporation' => __( 'Corporation', 'controlled-chaos-plugin' ),

			// Educational Organizations.
			'EducationalOrganization' => __( 'Educational Organization', 'controlled-chaos-plugin' ),
				'CollegeOrUniversity' => __( '— College or University', 'controlled-chaos-plugin' ),
				'ElementarySchool'    => __( '— Elementary School', 'controlled-chaos-plugin' ),
				'HighSchool'          => __( '— High School', 'controlled-chaos-plugin' ),
				'MiddleSchool'        => __( '— Middle School', 'controlled-chaos-plugin' ),
				'Preschool'           => __( '— Preschool', 'controlled-chaos-plugin' ),
				'School'              => __( '— School', 'controlled-chaos-plugin' ),

			'GovernmentOrganization'  => __( 'Government Organization', 'controlled-chaos-plugin' ),

			// Local Businesses.
			'LocalBusiness' => __( 'Local Business', 'controlled-chaos-plugin' ),
				'AnimalShelter' => __( '— Animal Shelter', 'controlled-chaos-plugin' ),

				// Automotive Businesses.
				'AutomotiveBusiness' => __( '— Automotive Business', 'controlled-chaos-plugin' ),
					'AutoBodyShop'     => __( '—— Auto Body Shop', 'controlled-chaos-plugin' ),
					'AutoDealer'       => __( '—— Auto Dealer', 'controlled-chaos-plugin' ),
					'AutoPartsStore'   => __( '—— Auto Parts Store', 'controlled-chaos-plugin' ),
					'AutoRental'       => __( '—— Auto Rental', 'controlled-chaos-plugin' ),
					'AutoRepair'       => __( '—— Auto Repair', 'controlled-chaos-plugin' ),
					'AutoWash'         => __( '—— Auto Wash', 'controlled-chaos-plugin' ),
					'GasStation'       => __( '—— Gas Station', 'controlled-chaos-plugin' ),
					'MotorcycleDealer' => __( '—— Motorcycle Dealer', 'controlled-chaos-plugin' ),
					'MotorcycleRepair' => __( '—— Motorcycle Repair', 'controlled-chaos-plugin' ),

				'ChildCare'            => __( '— Child Care', 'controlled-chaos-plugin' ),
				'Dentist'              => __( '— Dentist', 'controlled-chaos-plugin' ),
				'DryCleaningOrLaundry' => __( '— Dry Cleaning or Laundry', 'controlled-chaos-plugin' ),

				// Emergency Services.
				'EmergencyService' => __( '— Emergency Service', 'controlled-chaos-plugin' ),
					'FireStation'   => __( '—— Fire Station', 'controlled-chaos-plugin' ),
					'Hospital'      => __( '—— Hospital', 'controlled-chaos-plugin' ),
					'PoliceStation' => __( '—— Police Station', 'controlled-chaos-plugin' ),

				'EmploymentAgency' => __( '— Employment Agency', 'controlled-chaos-plugin' ),

				// Entertainment Businesses.
				'EntertainmentBusiness' => __( '— Entertainment Business', 'controlled-chaos-plugin' ),
					'AdultEntertainment' => __( '—— Adult Entertainment', 'controlled-chaos-plugin' ),
					'AmusementPark'      => __( '—— Amusement Park', 'controlled-chaos-plugin' ),
					'ArtGallery'         => __( '—— Art Gallery', 'controlled-chaos-plugin' ),
					'Casino'             => __( '—— Casino', 'controlled-chaos-plugin' ),
					'ComedyClub'         => __( '—— Comedy Club', 'controlled-chaos-plugin' ),
					'MovieTheater'       => __( '—— Movie Theater', 'controlled-chaos-plugin' ),
					'NightClub'          => __( '—— Night Club', 'controlled-chaos-plugin' ),

				// Financial Services.
				'FinancialService' => __( '— Financial Service', 'controlled-chaos-plugin' ),
					'AccountingService' => __( '—— Accounting Service', 'controlled-chaos-plugin' ),
					'AutomatedTeller'   => __( '—— Automated Teller', 'controlled-chaos-plugin' ),
					'BankOrCreditUnion' => __( '—— Bank or Credit Union', 'controlled-chaos-plugin' ),
					'InsuranceAgency'   => __( '—— Insurance Agency', 'controlled-chaos-plugin' ),

				// Food Establishments.
				'FoodEstablishment' => __( '— Food Establishment', 'controlled-chaos-plugin' ),
					'Bakery'             => __( '—— Bakery', 'controlled-chaos-plugin' ),
					'BarOrPub'           => __( '—— Bar or Pub', 'controlled-chaos-plugin' ),
					'Brewery'            => __( '—— Brewery', 'controlled-chaos-plugin' ),
					'CafeOrCoffeeShop'   => __( '—— Cafe or Coffee Shop', 'controlled-chaos-plugin' ),
					'FastFoodRestaurant' => __( '—— Fast Food Restaurant', 'controlled-chaos-plugin' ),
					'IceCreamShop'       => __( '—— Ice Cream Shop', 'controlled-chaos-plugin' ),
					'Restaurant'         => __( '—— Restaurant', 'controlled-chaos-plugin' ),
					'Winery'             => __( '—— Winery', 'controlled-chaos-plugin' ),

				// Government Offices.
				'GovernmentOffice' => __( '— Government Office', 'controlled-chaos-plugin' ),
					'PostOffice' => __( '—— Post Office', 'controlled-chaos-plugin' ),

				// Health and Beauty Businesses.
				'HealthAndBeautyBusiness' => __( '— Health and Beauty Business', 'controlled-chaos-plugin' ),
					'BeautySalon'  => __( '—— Beauty Salon', 'controlled-chaos-plugin' ),
					'DaySpa'       => __( '—— Day Spa', 'controlled-chaos-plugin' ),
					'HairSalon'    => __( '—— Hair Salon', 'controlled-chaos-plugin' ),
					'HealthClub'   => __( '—— Health Club', 'controlled-chaos-plugin' ),
					'NailSalon'    => __( '—— Nail Salon', 'controlled-chaos-plugin' ),
					'TattooParlor' => __( '—— Tattoo Parlor', 'controlled-chaos-plugin' ),

				// Home and Construction Businesses.
				'HomeAndConstructionBusiness' => __( '— Home and Construction Business', 'controlled-chaos-plugin' ),
					'Electrician'       => __( '—— Electrician', 'controlled-chaos-plugin' ),
					'GeneralContractor' => __( '—— General Contractor', 'controlled-chaos-plugin' ),
					'HVACBusiness'      => __( '—— HVAC Business', 'controlled-chaos-plugin' ),
					'HousePainter'      => __( '—— House Painter', 'controlled-chaos-plugin' ),
					'Locksmith'         => __( '—— Locksmith', 'controlled-chaos-plugin' ),
					'MovingCompany'     => __( '—— MovingCompany', 'controlled-chaos-plugin' ),
					'Plumber'           => __( '—— Plumber', 'controlled-chaos-plugin' ),
					'RoofingContractor' => __( '—— Roofing Contractor', 'controlled-chaos-plugin' ),

				'InternetCafe' => __( '— Internet Cafe', 'controlled-chaos-plugin' ),

				// Legal Services.
				'LegalService' => __( '— Legal Service', 'controlled-chaos-plugin' ),
					'Attorney' => __( '—— Attorney', 'controlled-chaos-plugin' ),
					'Notary'   => __( '—— Notary', 'controlled-chaos-plugin' ),

				'Library' => __( '— Library', 'controlled-chaos-plugin' ),

				// Lodging Businesses.
				'LodgingBusiness' => __( '— Lodging Business', 'controlled-chaos-plugin' ),
					'BedAndBreakfast' => __( '—— Bed and Breakfast', 'controlled-chaos-plugin' ),
					'Campground'      => __( '—— Campground', 'controlled-chaos-plugin' ),
					'Hostel'          => __( '—— Hostel', 'controlled-chaos-plugin' ),
					'Hotel'           => __( '—— Hotel', 'controlled-chaos-plugin' ),
					'Motel'           => __( '—— Motel', 'controlled-chaos-plugin' ),
					'Resort'          => __( '—— Resort', 'controlled-chaos-plugin' ),

				'ProfessionalService' => __( '— Professional Service', 'controlled-chaos-plugin' ),
				'RadioStation'        => __( '— Radio Station', 'controlled-chaos-plugin' ),
				'RealEstateAgent'     => __( '— Real Estate Agent', 'controlled-chaos-plugin' ),
				'RecyclingCenter'     => __( '— Recycling Center', 'controlled-chaos-plugin' ),
				'SelfStorage'         => __( '— Self Storage', 'controlled-chaos-plugin' ),
				'ShoppingCenter'      => __( '— Shopping Center', 'controlled-chaos-plugin' ),

				// Sports Activity Locations.
				'SportsActivityLocation' => __( '— Sports Activity Location', 'controlled-chaos-plugin' ),
					'BowlingAlley'       => __( '—— Bowling Alley', 'controlled-chaos-plugin' ),
					'ExerciseGym'        => __( '—— Exercise Gym', 'controlled-chaos-plugin' ),
					'GolfCourse'         => __( '—— Golf Course', 'controlled-chaos-plugin' ),
					'HealthClub'         => __( '—— Health Club', 'controlled-chaos-plugin' ),
					'PublicSwimmingPool' => __( '—— Public Swimming Pool', 'controlled-chaos-plugin' ),
					'SkiResort'          => __( '—— Ski Resort', 'controlled-chaos-plugin' ),
					'SportsClub'         => __( '—— Sports Club', 'controlled-chaos-plugin' ),
					'StadiumOrArena'     => __( '—— Stadium or Arena', 'controlled-chaos-plugin' ),
					'TennisComplex'      => __( '—— Tennis Complex', 'controlled-chaos-plugin' ),

				// Store types.
				'Store' => __( '— Store', 'controlled-chaos-plugin' ),
					'AutoPartsStore'      => __( '—— Auto Parts Store', 'controlled-chaos-plugin' ),
					'BikeStore'           => __( '—— Bike Store', 'controlled-chaos-plugin' ),
					'BookStore'           => __( '—— Book Store', 'controlled-chaos-plugin' ),
					'ClothingStore'       => __( '—— Clothing Store', 'controlled-chaos-plugin' ),
					'ComputerStore'       => __( '—— Computer Store', 'controlled-chaos-plugin' ),
					'ConvenienceStore'    => __( '—— Convenience Store', 'controlled-chaos-plugin' ),
					'DepartmentStore'     => __( '—— Department Store', 'controlled-chaos-plugin' ),
					'ElectronicsStore'    => __( '—— Electronics Store', 'controlled-chaos-plugin' ),
					'Florist'             => __( '—— Florist', 'controlled-chaos-plugin' ),
					'FurnitureStore'      => __( '—— Furniture Store', 'controlled-chaos-plugin' ),
					'GardenStore'         => __( '—— Garden Store', 'controlled-chaos-plugin' ),
					'GroceryStore'        => __( '—— Grocery Store', 'controlled-chaos-plugin' ),
					'HardwareStore'       => __( '—— Hardware Store', 'controlled-chaos-plugin' ),
					'HobbyShop'           => __( '—— Hobby Shop', 'controlled-chaos-plugin' ),
					'HomeGoodsStore'      => __( '—— Home Goods Store', 'controlled-chaos-plugin' ),
					'JewelryStore'        => __( '—— Jewelry Store', 'controlled-chaos-plugin' ),
					'LiquorStore'         => __( '—— Liquor Store', 'controlled-chaos-plugin' ),
					'MensClothingStore'   => __( '—— Mens Clothing Store', 'controlled-chaos-plugin' ),
					'MobilePhoneStore'    => __( '—— Mobile Phone Store', 'controlled-chaos-plugin' ),
					'MovieRentalStore'    => __( '—— Movie Rental Store', 'controlled-chaos-plugin' ),
					'MusicStore'          => __( '—— Music Store', 'controlled-chaos-plugin' ),
					'OfficeEquipmentStore'=> __( '—— Office Equipment Store', 'controlled-chaos-plugin' ),
					'OutletStore'         => __( '—— Outlet Store', 'controlled-chaos-plugin' ),
					'PawnShop'            => __( '—— Pawn Shop', 'controlled-chaos-plugin' ),
					'PetStore'            => __( '—— Pet Store', 'controlled-chaos-plugin' ),
					'ShoeStore'           => __( '—— Shoe Store', 'controlled-chaos-plugin' ),
					'SportingGoodsStore'  => __( '—— Sporting Goods Store', 'controlled-chaos-plugin' ),
					'TireShop'            => __( '—— Tire Shop', 'controlled-chaos-plugin' ),
					'ToyStore'            => __( '—— Toy Store', 'controlled-chaos-plugin' ),
					'WholesaleStore'      => __( '—— Wholesale Store', 'controlled-chaos-plugin' ),

				'TelevisionStation'        => __( '— Television Station', 'controlled-chaos-plugin' ),
				'TouristInformationCenter' => __( '— Tourist Information Center', 'controlled-chaos-plugin' ),
				'TravelAgency'             => __( '— Travel Agency', 'controlled-chaos-plugin' ),

			'MedicalOrganization' => __( 'Medical Organization', 'controlled-chaos-plugin' ),
			'NGO'                 => __( 'NGO (Non-Governmental Organization', 'controlled-chaos-plugin' ),
			'PerformingGroup'     => __( 'Performing Group', 'controlled-chaos-plugin' ),
			'SportsOrganization'  => __( 'Sports Organization', 'controlled-chaos-plugin' )
		];

		$options = get_option( 'ccp_meta_type' );

		$html = '<p><select id="ccp_meta_type" name="ccp_meta_type">';

		foreach( $types as $type => $value ) {

			$selected = ( $options == $type ) ? 'selected="' . esc_attr( 'selected' ) . '"' : '';

			$html .= '<option value="' . esc_attr( $type ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';

		}

		$html .= '</select>';
		$html .= '<label for="ccp_meta_type"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Site Settings page position.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_site_settings_position_callback( $args ) {

		$option = get_option( 'ccp_site_settings_position' );

		$html = '<p><input type="checkbox" id="ccp_site_settings_position" name="ccp_site_settings_position" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_site_settings_position"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Site Settings page link label.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_site_settings_link_label_callback( $args ) {

		$option = get_option( 'ccp_site_settings_link_label' );

		$html = '<p><input type="text" size="50" id="ccp_site_settings_link_label" name="ccp_site_settings_link_label" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'Site Settings', 'controlled-chaos-plugin' ) ) . '" /><br />';

		$html .= '<label for="ccp_site_settings_link_label"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Site Settings page link icon.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_site_settings_link_icon_callback( $args ) {

		$option = get_option( 'ccp_site_settings_link_icon' );

		$html = '<p><input type="text" size="50" id="ccp_site_settings_link_icon" name="ccp_site_settings_link_icon" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'dashicons-admin-settings', 'controlled-chaos-plugin' ) ) . '" /><br />';

		$html .= '<label for="ccp_site_settings_link_icon"> ' . $args[0] . '</label>';

		$html .= '<br /><span class="description">' . esc_html( 'Takes affect in the admin menu only if the page is top level. Always takes affect on the plugin page tab for Site Settings.' ) . '</span></p>';

		echo $html;

	}

	/**
	 * Site Plugin page position.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_site_plugin_position_callback( $args ) {

		$option = get_option( 'ccp_site_plugin_position' );

		$html = '<p><input type="checkbox" id="ccp_site_plugin_position" name="ccp_site_plugin_position" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_site_plugin_position"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Site Plugin page link label.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_site_plugin_link_label_callback( $args ) {

		$option = get_option( 'ccp_site_plugin_link_label' );

		$html = '<p><input type="text" size="50" id="ccp_site_plugin_link_label" name="ccp_site_plugin_link_label" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'Site Plugin', 'controlled-chaos-plugin' ) ) . '" /><br />';

		$html .= '<label for="ccp_site_plugin_link_label"> ' . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Site Plugin page link icon.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_site_plugin_link_icon_callback( $args ) {

		$option = get_option( 'ccp_site_plugin_link_icon' );

		$html = '<p><input type="text" size="50" id="ccp_site_settings_link_icon" name="ccp_site_plugin_link_icon" value="' . esc_attr( $option ) . '" placeholder="' . esc_attr( __( 'dashicons-welcome-learn-more', 'controlled-chaos-plugin' ) ) . '" /><br />';

		$html .= '<label for="ccp_site_plugin_link_icon"> ' . $args[0] . '</label>';

		$html .= '<br /><span class="description">' . esc_html( 'Takes affect in the admin menu only if the page is top level. Always takes affect on the plugin page tab for Site Settings.' ) . '</span></p>';

		echo $html;

	}

	/**
	 * Menus link position.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_widgets_position_callback( $args ) {

		$option = get_option( 'ccp_widgets_position' );

		$html = '<p><input type="checkbox" id="ccp_widgets_position" name="ccp_widgets_position" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_widgets_position"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Use custom welcome panel.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_custom_welcome_callback( $args ) {

		$option = get_option( 'ccp_custom_welcome' );

		$html = '<p><input type="checkbox" id="ccp_custom_welcome" name="ccp_custom_welcome" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_custom_welcome"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide welcome panel.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_hide_welcome_callback( $args ) {

		$option = get_option( 'ccp_hide_welcome' );

		$html = '<p><input type="checkbox" id="ccp_hide_welcome" name="ccp_hide_welcome" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_hide_welcome"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Remove welcome dismiss.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_remove_welcome_dismiss_callback( $args ) {

		$option = get_option( 'ccp_remove_welcome_dismiss' );

		$html = '<p><input type="checkbox" id="ccp_remove_welcome_dismiss" name="ccp_remove_welcome_dismiss" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_remove_welcome_dismiss"> '  . $args[0] . '</label></p>';

		echo $html;

	}

	/**
	 * Hide WordPress News widget.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
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
	 * @since  1.0.0
	 * @access public
	 * @param  array $args Extra arguments passed into the callback function.
	 * @return string
	 */
	public function ccp_meta_disable_callback( $args ) {

		$option = get_option( 'ccp_meta_disable' );

		$html = '<p><input type="checkbox" id="ccp_meta_disable" name="ccp_meta_disable" value="1" ' . checked( 1, $option, false ) . '/>';

		$html .= '<label for="ccp_meta_disable"> '  . $args[0] . '</label></p>';

		echo $html;

	}

}

/**
 * Put an instance of the class into a function.
 *
 * @since  1.0.0
 * @access public
 * @return object Returns an instance of the class.
 */
function ccp_settings_fields_site() {

	return Settings_Fields_Site::instance();

}

// Run an instance of the class.
ccp_settings_fields_site();