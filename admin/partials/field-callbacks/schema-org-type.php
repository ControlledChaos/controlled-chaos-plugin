<?php
/**
 * SCallback for the Schema organization type field.
 *
 * @package    Controlled_Chaos_Plugin
 * @subpackage Admin\Partials\Field_Callbacks
 *
 * @since      1.0.0
 * @author     Greg Sweet <greg@ccdzine.com>
 */

namespace CC_Plugin\Admin\Partials\Field_Callbacks;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

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

$options = get_option( 'schema_org_type' );

$html = '<p><select id="schema_org_type" name="schema_org_type">';

foreach( $types as $type => $value ) {

	$selected = ( $options == $type ) ? 'selected="' . esc_attr( 'selected' ) . '"' : '';

	$html .= '<option value="' . esc_attr( $type ) . '" ' . $selected . '>' . esc_html( $value ) . '</option>';

}

$html .= '</select>';
$html .= sprintf(
	'<label for="schema_org_type"> %1s</label> <a href="%2s" target="_blank" class="tooltip" title="%3s"><span class="dashicons dashicons-editor-help"></span></a>',
	$args[0],
	esc_attr( esc_url( 'https://schema.org/docs/full.html#C.Organization' ) ),
	esc_attr( __( 'Read documentation for organization types', 'controlled-chaos-plugin' ) )
);
$html .= '</p>';

echo $html;