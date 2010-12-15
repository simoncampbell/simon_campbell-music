<?php
if ( ! defined('EXT'))
{
	exit('Invalid file request');
}

/**
 * Cartthrob module: Part of the CartThrob cart system for Expression Engine
 *
 * This file must be placed in the
 * /system/modules/cartthrob/ folder in your ExpressionEngine installation.
 *
 * This plugin is a shopping cart that thoroughly integrates with Expression Engine. 
 * Most cart systems try to manage your content, this plugin assumes you will manage content with EE. 
 * The Cartthrob system takes money & does calculations, and lets EE do what it does best!
 *
 * Requires cartthrob_ext EE extension to manage settings
 * 
 * @package cartthrob
 * @author Barrett Newton Inc, Chris Newton <cnewton@barrettnewton.com>, Rob Sanchez
 * @version 0.9457
 * @uses Expression Engine 1.6.7 or higher
 * @see http://cartthrob.com
 * @copyright Copyright (c) 2009-2010 Chris Newton, Barrett Newton Inc. 
 **/

/* 
 * Naming rules for publicly accessible functions
 * 
 * INFORMATIONAL
 * is_  (has_, was_) functions are booleans
 * selected_ functions refer to information the defaults set in the backed (may be overridden with parameters)
 * get_ functions output stored info (not settings) from weblogs or backend.
 * _info functions output data stored in sessions, generally text or formatted numbers (strings)
 * _count functions output item totals as a number
 * 
 * CART INFO (utility tags... encourages less developer typing)
 * cart_ functions output basic information about various aspects of data stored in the current cart.
 *
 * ACTIONS
 * _redirect functions change the page location
 * verbs (clear, duplicate, delete) permanently alter data stored in the session
 * view_ functions output temporary data alteration
 * 
 * FORMS
 * verbs (add, delete, check out) permanently alter data stored in sessions or weblogs
*/ 
if ( ! class_exists('Cartthrob_payment_gateway')) {
	require_once(PATH_MOD . 'cartthrob/lib/cartthrob_payment_gateway.class.php');
}
if ( ! class_exists('Cartthrob_default_payment_gateway')) {
	require_once(PATH_MOD . 'cartthrob/lib/cartthrob_default_payment_gateway.class.php');
}
if (!class_exists('Cartthrob_shipping_plugin')) {
	require_once(PATH_MOD . 'cartthrob/lib/cartthrob_shipping_plugin.class.php');
}
if ( ! class_exists('Cartthrob_coupon_code_plugin')) {
	require_once(PATH_MOD . 'cartthrob/lib/cartthrob_coupon_code_plugin.class.php');
}
if ( ! class_exists('Encrypt')) {
	require_once(PATH_MOD . 'cartthrob/lib/encrypt.class.php');
}

class Cartthrob
{
	/*
	* Standard EE settings variable
	*/
	var $settings;
	var $default_settings;
	/*
	* Payment gateway object
	*/
	var $PG = NULL; 
	/*
	* Shipping Plugin object
	*/
	var $SHP = NULL;
	/*
	* Coupon Code Plugin object
	*/
	var $CCP = NULL;
	/*
	* Email Template Parser object
	*/
	var $EMAIL = NULL;
	
	// --------------------------------
	//  Constructor
	// --------------------------------
	/**
	 * Constructor
	 *
	 * @param null
	 * @return void
	 * @since 1.0.0 
	 * @author Rob Sanchez, Chris Newton
	 **/
	function Cartthrob($load_coupon_code_plugins = TRUE)
	{
		global $LANG;
		
		$LANG->fetch_language_file('cartthrob');
		
		$LANG->fetch_language_file('cartthrob_errors');

		$this->_extension_classname = 'Cartthrob_ext';

		$this->coupon_code_messages = array();

		// Payment processor API fields 
		// if something isn't in this list, it doesn't get 
		// to the payment gateway
		$this->customer_fields = array(
			'first_name',
			'last_name',
			'address',
			'address2',
			'city',
			'state',
			'zip',
			'country',
			'country_code',
			'company',

			'phone',
			'email_address',
			'ip_address',
			'description',
			'use_billing_info',

			'shipping_first_name',
			'shipping_last_name',
			'shipping_address',
			'shipping_address2',
			'shipping_city',
			'shipping_state',
			'shipping_zip',
			'shipping_country',
			'shipping_country_code',
			'shipping_company',
			'shipping_region',

			'CVV2',
			'card_type',
			'expiration_month',
			'expiration_year',
			'begin_month',
			'begin_year',
			'bday_month',
			'bday_day',
			'bday_year',

			'currency_code',
			'language',

			'shipping_option',
			'weight_unit',

			'region',

			'success_return',
			'cancel_return',

			'po_number',
			'card_code',
			'issue_number',
			'transaction_type',
			'bank_account_number',
			'check_type',
			'account_type',
			'routing_number',

			// MEMBER CREATION
			'username', 
			'screen_name',
			'password',
			'password_confirm', 
			'create_member',
			'group_id',
			
			// RECURRENT BILLING
			'subscription_name',
			'subscription_total_occurrences',
			'subscription_trial_price',
			'subscription_trial_occurrences',
			'subscription_start_date',
			'subscription_end_date',
			'subscription_interval', // pay every X 
			'subscription_interval_units', // D, W, M, Y
			'subscription_allow_modification', // can subscribers change subscription
		);

		$this->default_settings = array(
			'admin_email'=>'',
			'license_number'=>'',
			'send_email'=>0,
			'logged_in'=>1,
			'default_member_id'=>'',
			'clear_cart_on_logout'=>1,
			'session_expire'=>10800,
			'allow_gateway_selection' => 0, 
			'encode_gateway_selection' => 1, 
			'allow_products_more_than_once'=>0,
			'allow_empty_cart_checkout'=>0,
			'product_split_items_by_quantity'=>0,
			'product_weblogs'=>array(),
			'product_weblog_fields'=>array(),
			'save_orders'=>0,
			'orders_weblog'=>'',
			'orders_sequential_order_numbers'=>0,
			'orders_items_field'=>'',
			'orders_subtotal_field'=>'',
			'orders_tax_field'=>'',
			'orders_shipping_field'=>'',
			'orders_discount_field'=>'',
			'orders_total_field'=>'',
			'orders_status_field'=>'',
			'orders_default_status'=>'',
			'orders_processing_status'=>'',
			'orders_declined_status'=>'',
			'orders_failed_status'=>'',
			'orders_transaction_id'=>'',
			'orders_last_four_digits'=>'',
			'orders_convert_country_code'=>1,
			'orders_coupon_codes'=>'',
			'orders_customer_name'=>'',
			'orders_customer_email'=>'',
			'orders_customer_ip_address' => '',
			'orders_customer_phone'=>'',
			'orders_full_billing_address'=>'',
			'orders_billing_first_name'=>'',
			'orders_billing_last_name'=>'',
			'orders_billing_company'=>'',
			'orders_billing_address'=>'',
			'orders_billing_address2'=>'',
			'orders_billing_city'=>'',
			'orders_billing_state'=>'',
			'orders_billing_zip'=>'',
			'orders_billing_country'=>'',
			'orders_country_code'=>'',
			'orders_full_shipping_address'=>'',
			'orders_shipping_first_name'=>'',
			'orders_shipping_last_name'=>'',
			'orders_shipping_company'=>'',
			'orders_shipping_address'=>'',
			'orders_shipping_address2'=>'',
			'orders_shipping_city'=>'',
			'orders_shipping_state'=>'',
			'orders_shipping_zip'=>'',
			'orders_shipping_country'=>'',
			'orders_shipping_country_code'=>'',
			'orders_shipping_option'=>'',
			'orders_license_number_field'=>'',
			'orders_license_number_type'=>'uuid',
			'orders_error_message_field'=>'',
			'orders_language_field'=>'',
			'orders_title_prefix'=>'Order #',
			'orders_title_suffix'=>'',
			'orders_url_title_prefix'=>'order_',
			'orders_url_title_suffix'=>'',
			'save_purchased_items'=>0,
			'purchased_items_weblog'=>'',
			'purchased_items_default_status'=>'',
			'purchased_items_processing_status'=>'',
			'purchased_items_declined_status'=>'',
			'purchased_items_failed_status'=>'',
			'purchased_items_id_field'=>'',
			'purchased_items_quantity_field'=>'',
			'purchased_items_order_id_field'=>'',
			'purchased_items_license_number_field'=>'',
			'purchased_items_price_field'=>'',
			'purchased_items_title_prefix'=>'',
			'purchased_items_license_number_type'=>'uuid',
			'approve_orders'=>FALSE,
			'rounding_default'=>'standard',
			'global_item_limit'=>'0',
			'global_coupon_limit'=>'1',
			'tax_settings'=>'',
			'tax_use_shipping_address'=>'',
			'coupon_code_weblog'=>'',
			'enable_logging' => '',
			'coupon_code_field'=>'',
			'coupon_code_type'=>'',
			'coupon_code_used_by'=>'',
			'coupon_code_per_user_limit'=>0,
			'coupon_valid_msg'=>"Your code is valid and your cart total has been updated.",
			'coupon_invalid_msg'=>"The code you entered is invalid.",
			'coupon_inactive_msg'=>"The code you entered is not yet active.",
			'coupon_expired_msg'=>"The code you entered is expired.",
			'coupon_limit_msg'=>"You are only allowed {limit} coupon code per order.",
			'coupon_user_limit_msg'=>"You have already used this code.",
			'payment_gateway'=>'',
			'send_confirmation_email'=>0,
			'email_order_confirmation'=>'',
			'email_admin_notification'=>'',
			'email_order_confirmation_subject'=>'',
			'email_admin_notification_subject'=>'',
			'email_order_confirmation_from'=>'',
			'email_admin_notification_from'=>'',
			'email_order_confirmation_from_name'=>'',
			'email_admin_notification_from_name'=>'',
			'email_admin_notification_plaintext'=>0,
			'email_order_confirmation_plaintext'=>0,
			'customer_field_labels'=>array('credit_card_number'=>'Credit Card Number'),
			'customer_info_validation_msg'=>'The following required fields are missing:',
			'shipping_plugin'=>'',
			'auto_force_https'=>FALSE,
			'force_https_domain'=>'',
			'number_format_defaults_decimals' => '2',
			'number_format_defaults_dec_point' => '.',
			'number_format_defaults_thousands_sep' => ',',
			'number_format_defaults_prefix' => '$',
			'number_format_defaults_space_after_prefix' => FALSE,
			'number_format_defaults_currency_code' => 'USD',
			'save_member_data' => '0',
			'modulus_10_checking' => '0',
			'member_first_name_field' => '',
			'member_last_name_field' => '',
			'member_address_field' => '',
			'member_address2_field' => '',
			'member_city_field' => '',
			'member_state_field' => '',
			'member_zip_field' => '',
			'member_country_field' => '',
			'member_country_code_field' => '',
			'member_company_field' => '',
			'member_phone_field' => '',
			'member_email_address_field' => '',
			'member_use_billing_info_field' => '',
			'member_shipping_first_name_field' => '',
			'member_shipping_last_name_field' => '',
			'member_shipping_address_field' => '',
			'member_shipping_address2_field' => '',
			'member_shipping_city_field' => '',
			'member_shipping_state_field' => '',
			'member_shipping_zip_field' => '',
			'member_shipping_country_field' => '',
			'member_shipping_country_code_field' => '',
			'member_shipping_company_field' => '',
			'member_language_field' => '',
			'member_shipping_option_field' => '',
			'member_region_field' => '',
			'discount_weblog' => '',
		);
		
		// http://en.wikipedia.org/wiki/List_of_ISO_639-1_codes
		$this->languages = array(
			'aa' => 'afar',
			'ab' => 'abkhazian',
			'af' => 'afrikaans',
			'am' => 'amharic',
			'ar' => 'arabic',
			'as' => 'assamese',
			'ay' => 'aymara',
			'az' => 'azerbaijani',
			'ba' => 'bashkir',
			'be' => 'byelorussian',
			'bg' => 'bulgarian',
			'bh' => 'bihari',
			'bi' => 'bislama',
			'bn' => 'bengali',
			'bo' => 'tibetan',
			'br' => 'breton',
			'ca' => 'catalan',
			'co' => 'corsican',
			'cs' => 'czech',
			'cy' => 'welsh',
			'da' => 'danish',
			'de' => 'german',
			'dz' => 'bhutani',
			'el' => 'greek',
			'en' => 'english',
			'eo' => 'esperanto',
			'es' => 'spanish',
			'et' => 'estonian',
			'eu' => 'basque',
			'fa' => 'persian',
			'fi' => 'finnish',
			'fj' => 'fiji',
			'fo' => 'faeroese',
			'fr' => 'french',
			'fy' => 'frisian',
			'ga' => 'irish',
			'gd' => 'gaelic',
			'gl' => 'galician',
			'gn' => 'guarani',
			'gu' => 'gujarati',
			'ha' => 'hausa',
			'hi' => 'hindi',
			'hr' => 'croatian',
			'hu' => 'hungarian',
			'hy' => 'armenian',
			'ia' => 'interlingua',
			'ie' => 'interlingue',
			'ik' => 'inupiak',
			'in' => 'indonesian',
			'is' => 'icelandic',
			'it' => 'italian',
			'iw' => 'hebrew',
			'ja' => 'japanese',
			'ji' => 'yiddish',
			'jw' => 'javanese',
			'ka' => 'georgian',
			'kk' => 'kazakh',
			'kl' => 'greenlandic',
			'km' => 'cambodian',
			'kn' => 'kannada',
			'ko' => 'korean',
			'ks' => 'kashmiri',
			'ku' => 'kurdish',
			'ky' => 'kirghiz',
			'la' => 'latin',
			'ln' => 'lingala',
			'lo' => 'laothian',
			'lt' => 'lithuanian',
			'lv' => 'latvian',
			'mg' => 'malagasy',
			'mi' => 'maori',
			'mk' => 'macedonian',
			'ml' => 'malayalam',
			'mn' => 'mongolian',
			'mo' => 'moldavian',
			'mr' => 'marathi',
			'ms' => 'malay',
			'mt' => 'maltese',
			'my' => 'burmese',
			'na' => 'nauru',
			'ne' => 'nepali',
			'nl' => 'dutch',
			'no' => 'norwegian',
			'oc' => 'occitan',
			'om' => 'oromo',
			'or' => 'oriya',
			'pa' => 'punjabi',
			'pl' => 'polish',
			'ps' => 'pashto, pushto',
			'pt' => 'portuguese',
			'qu' => 'quechua',
			'rm' => 'rhaeto-romance',
			'rn' => 'kirundi',
			'ro' => 'romanian',
			'ru' => 'russian',
			'rw' => 'kinyarwanda',
			'sa' => 'sanskrit',
			'sd' => 'sindhi',
			'sg' => 'sangro',
			'sh' => 'serbo-croatian',
			'si' => 'singhalese',
			'sk' => 'slovak',
			'sl' => 'slovenian',
			'sm' => 'samoan',
			'sn' => 'shona',
			'so' => 'somali',
			'sp' => 'spanish',
			'sq' => 'albanian',
			'sr' => 'serbian',
			'ss' => 'siswati',
			'st' => 'sesotho',
			'su' => 'sudanese',
			'sv' => 'swedish',
			'sw' => 'swahili',
			'ta' => 'tamil',
			'te' => 'tegulu',
			'tg' => 'tajik',
			'th' => 'thai',
			'ti' => 'tigrinya',
			'tk' => 'turkmen',
			'tl' => 'tagalog',
			'tn' => 'setswana',
			'to' => 'tonga',
			'tr' => 'turkish',
			'ts' => 'tsonga',
			'tt' => 'tatar',
			'tw' => 'twi',
			'uk' => 'ukrainian',
			'ur' => 'urdu',
			'uz' => 'uzbek',
			'vi' => 'vietnamese',
			'vo' => 'volapuk',
			'wo' => 'wolof',
			'xh' => 'xhosa',
			'yo' => 'yoruba',
			'zh' => 'chinese',
			'zu' => 'zulu',
		);
		
		$this->countries = array(
			"USA" => "United States",
			"CAN" => "Canada",
			"GBR" => "United Kingdom", 
			"AFG" => "Afghanistan", 
			"ALA" => "&Aring;land Is.",
			"ALB" => "Albania", 
			"DZA" => "Algeria", 
			"ASM" => "American Samoa", 
			"AND" => "Andorra", 
			"AGO" => "Angola", 
			"AIA" => "Anguilla", 
			"ATA" => "Antarctica", 
			"ATG" => "Antigua/Barbuda", 
			"ARG" => "Argentina", 
			"ARM" => "Armenia", 
			"ABW" => "Aruba", 
			"AUS" => "Australia", 
			"AUT" => "Austria", 
			"AZE" => "Azerbaijan", 
			"BHS" => "Bahamas", 
			"BHR" => "Bahrain", 
			"BGD" => "Bangladesh", 
			"BRB" => "Barbados", 
			"BLR" => "Belarus", 
			"BEL" => "Belgium", 
			"BLZ" => "Belize", 
			"BEN" => "Benin", 
			"BMU" => "Bermuda", 
			"BTN" => "Bhutan", 
			"BOL" => "Bolivia", 
			"BIH" => "Bosnia/Herzegovina", 
			"BWA" => "Botswana", 
			"BVT" => "Bouvet Is.", 
			"BRA" => "Brazil", 
			"IOT" => "British Indian Ocean", 
			"BRN" => "Brunei Darussalam", 
			"BGR" => "Bulgaria", 
			"BFA" => "Burkina Faso", 
			"BDI" => "Burundi", 
			"KHM" => "Cambodia", 
			"CMR" => "Cameroon", 
			"CPV" => "Cape Verde", 
			"CYM" => "Cayman Is.", 
			"CAF" => "Central African Rep.", 
			"TCD" => "Chad", 
			"CHL" => "Chile", 
			"CHN" => "China", 
			"CXR" => "Christmas Is.", 
			"CCK" => "Cocos Is.", 
			"COL" => "Colombia", 
			"COM" => "Comoros", 
			"COG" => "Congo", 
			"COD" => "DR Congo", 
			"COK" => "Cook Is.", 
			"CRI" => "Costa Rica", 
			"CIV" => "Cote d'Ivoire", 
			"HRV" => "Croatia", 
			"CUB" => "Cuba", 
			"CYP" => "Cyprus", 
			"CZE" => "Czech Rep.", 
			"DNK" => "Denmark", 
			"DJI" => "Djibouti", 
			"DMA" => "Dominica", 
			"DOM" => "Dominican Rep.", 
			"ECU" => "Ecuador", 
			"EGY" => "Egypt", 
			"SLV" => "El Salvador", 
			"GNQ" => "Equatorial Guinea", 
			"ERI" => "Eritrea", 
			"EST" => "Estonia", 
			"ETH" => "Ethiopia", 
			"FLK" => "Falkland Is.", 
			"FRO" => "Faroe Is.", 
			"FJI" => "Fiji", 
			"FIN" => "Finland", 
			"FRA" => "France", 
			"GUF" => "French Guiana", 
			"PYF" => "French Polynesia", 
			"GAB" => "Gabon", 
			"GMB" => "Gambia", 
			"GEO" => "Georgia", 
			"DEU" => "Germany", 
			"GHA" => "Ghana", 
			"GIB" => "Gibraltar", 
			"GRC" => "Greece", 
			"GRL" => "Greenland", 
			"GRD" => "Grenada", 
			"GLP" => "Guadeloupe", 
			"GUM" => "Guam", 
			"GTM" => "Guatemala", 
			"GGY" => "Guernsey",
			"GIN" => "Guinea", 
			"GNB" => "Guinea-bissau", 
			"GUY" => "Guyana", 
			"HTI" => "Haiti", 
			"HMD" => "Heard/McDonald Is.", 
			"HND" => "Honduras", 
			"HKG" => "Hong Kong", 
			"HUN" => "Hungary", 
			"ISL" => "Iceland", 
			"IND" => "India", 
			"IDN" => "Indonesia", 
			"IRN" => "Iran", 
			"IRQ" => "Iraq", 
			"IRL" => "Ireland", 
			"IMN" => "Isle of Man",
			"ISR" => "Israel", 
			"ITA" => "Italy", 
			"JAM" => "Jamaica", 
			"JPN" => "Japan", 
			"JEY" => "Jersey",
			"JOR" => "Jordan", 
			"KAZ" => "Kazakhstan", 
			"KEN" => "Kenya", 
			"KIR" => "Kiribati", 
			"PRK" => "Korea(North)", 
			"KOR" => "Korea(South)", 
			"KWT" => "Kuwait", 
			"KGZ" => "Kyrgyzstan", 
			"LAO" => "Laos", 
			"LVA" => "Latvia", 
			"LBN" => "Lebanon", 
			"LSO" => "Lesotho", 
			"LBR" => "Liberia", 
			"LBY" => "Libya", 
			"LIE" => "Liechtenstein", 
			"LTU" => "Lithuania", 
			"LUX" => "Luxembourg", 
			"MAC" => "Macao", 
			"MKD" => "Macedonia", 
			"MDG" => "Madagascar", 
			"MWI" => "Malawi", 
			"MYS" => "Malaysia", 
			"MDV" => "Maldives", 
			"MLI" => "Mali", 
			"MLT" => "Malta", 
			"MHL" => "Marshall Is.", 
			"MTQ" => "Martinique", 
			"MRT" => "Mauritania", 
			"MUS" => "Mauritius", 
			"MYT" => "Mayotte", 
			"MEX" => "Mexico", 
			"FSM" => "Micronesia", 
			"MDA" => "Moldova", 
			"MCO" => "Monaco", 
			"MNG" => "Mongolia",
			"MNE" => "Montenegro", 
			"MSR" => "Montserrat", 
			"MAR" => "Morocco", 
			"MOZ" => "Mozambique", 
			"MMR" => "Myanmar", 
			"NAM" => "Namibia", 
			"NRU" => "Nauru", 
			"NPL" => "Nepal", 
			"NLD" => "Netherlands", 
			"ANT" => "Netherlands Antilles", 
			"NCL" => "New Caledonia", 
			"NZL" => "New Zealand", 
			"NIC" => "Nicaragua", 
			"NER" => "Niger", 
			"NGA" => "Nigeria",
			"NIU" => "Niue", 
			"NFK" => "Norfolk Is.", 
			"MNP" => "Northern Mariana Is.",
			"NOR" => "Norway", 
			"OMN" => "Oman", 
			"PAK" => "Pakistan", 
			"PLW" => "Palau", 
			"PSE" => "Palestinian Terr.", 
			"PAN" => "Panama", 
			"PNG" => "Papua New Guinea", 
			"PRY" => "Paraguay", 
			"PER" => "Peru", 
			"PHL" => "Philippines", 
			"PCN" => "Pitcairn", 
			"POL" => "Poland", 
			"PRT" => "Portugal", 
			"PRI" => "Puerto Rico", 
			"QAT" => "Qatar",
			"REU" => "R&eacute;union", 
			"ROU" => "Romania", 
			"RUS" => "Russian Federation", 
			"RWA" => "Rwanda",
			"BLM" => "Saint Barth&eacute;lemy", 
			"SHN" => "St. Helena", 
			"KNA" => "St. Kitts/Nevis", 
			"LCA" => "St. Lucia", 
			"MAF" => "Saint Martin (French)",
			"SPM" => "St. Pierre/Miquelon", 
			"VCT" => "St. Vincent/Grenadines", 
			"WSM" => "Samoa", 
			"SMR" => "San Marino", 
			"STP" => "Sao Tome/Principe", 
			"SAU" => "Saudi Arabia", 
			"SEN" => "Senegal", 
			"SRB" => "Serbia/Montenegro", 
			"SYC" => "Seychelles", 
			"SLE" => "Sierra Leone", 
			"SGP" => "Singapore", 
			"SVK" => "Slovakia", 
			"SVN" => "Slovenia", 
			"SLB" => "Solomon Is.", 
			"SOM" => "Somalia", 
			"ZAF" => "South Africa", 
			"SGS" => "South Georgia", 
			"ESP" => "Spain", 
			"LKA" => "Sri Lanka", 
			"SDN" => "Sudan", 
			"SUR" => "Suriname", 
			"SJM" => "Svalbard/Jan Mayen", 
			"SWZ" => "Swaziland", 
			"SWE" => "Sweden", 
			"CHE" => "Switzerland", 
			"SYR" => "Syrian Arab Rep.", 
			"TWN" => "Taiwan", 
			"TJK" => "Tajikistan", 
			"TZA" => "Tanzania", 
			"THA" => "Thailand", 
			"TLS" => "Timor-Leste", 
			"TGO" => "Togo", 
			"TKL" => "Tokelau", 
			"TON" => "Tonga", 
			"TTO" => "Trinidad & Tobago", 
			"TUN" => "Tunisia", 
			"TUR" => "Turkey", 
			"TKM" => "Turkmenistan",
			"TCA" => "Turks & Caicos Is.", 
			"TUV" => "Tuvalu", 
			"UGA" => "Uganda", 
			"UKR" => "Ukraine", 
			"ARE" => "United Arab Emirates", 
			"UMI" => "U.S. Minor Out. Is.", 
			"URY" => "Uruguay", 
			"UZB" => "Uzbekistan", 
			"VUT" => "Vanuatu", 
			"VAT" => "Vatican City", 
			"VEN" => "Venezuela", 
			"VNM" => "Vietnam", 
			"VGB" => "Virgin Is., British", 
			"VIR" => "Virgin Is., U.S.", 
			"WLF" => "Wallis/Futuna", 
			"ESH" => "Western Sahara", 
			"YEM" => "Yemen", 
			"ZMB" => "Zambia", 
			"ZWE" => "Zimbabwe",
		);
		
		$this->country_codes = array(
			'AFG' => 'AF',
			'ALA' => 'AX',
			'ALB' => 'AL',
			'DZA' => 'DZ',
			'ASM' => 'AS',
			'AND' => 'AD',
			'AGO' => 'AO',
			'AIA' => 'AI',
			'ATA' => 'AQ',
			'ATG' => 'AG',
			'ARG' => 'AR',
			'ARM' => 'AM',
			'ABW' => 'AW',
			'AUS' => 'AU',
			'AUT' => 'AT',
			'AZE' => 'AZ',
			'BHS' => 'BS',
			'BHR' => 'BH',
			'BGD' => 'BD',
			'BRB' => 'BB',
			'BLR' => 'BY',
			'BEL' => 'BE',
			'BLZ' => 'BZ',
			'BEN' => 'BJ',
			'BMU' => 'BM',
			'BTN' => 'BT',
			'BOL' => 'BO',
			'BIH' => 'BA',
			'BWA' => 'BW',
			'BVT' => 'BV',
			'BRA' => 'BR',
			'IOT' => 'IO',
			'BRN' => 'BN',
			'BGR' => 'BG',
			'BFA' => 'BF',
			'BDI' => 'BI',
			'KHM' => 'KH',
			'CMR' => 'CM',
			'CAN' => 'CA',
			'CPV' => 'CV',
			'CYM' => 'KY',
			'CAF' => 'CF',
			'TCD' => 'TD',
			'CHL' => 'CL',
			'CHN' => 'CN',
			'CXR' => 'CX',
			'CCK' => 'CC',
			'COL' => 'CO',
			'COM' => 'KM',
			'COG' => 'CG',
			'COD' => 'CD',
			'COK' => 'CK',
			'CRI' => 'CR',
			'CIV' => 'CI',
			'HRV' => 'HR',
			'CUB' => 'CU',
			'CYP' => 'CY',
			'CZE' => 'CZ',
			'DNK' => 'DK',
			'DJI' => 'DJ',
			'DMA' => 'DM',
			'DOM' => 'DO',
			'ECU' => 'EC',
			'EGY' => 'EG',
			'SLV' => 'SV',
			'GNQ' => 'GQ',
			'ERI' => 'ER',
			'EST' => 'EE',
			'ETH' => 'ET',
			'FLK' => 'FK',
			'FRO' => 'FO',
			'FJI' => 'FJ',
			'FIN' => 'FI',
			'FRA' => 'FR',
			'GUF' => 'GF',
			'PYF' => 'PF',
			'ATF' => 'TF',
			'GAB' => 'GA',
			'GMB' => 'GM',
			'GEO' => 'GE',
			'DEU' => 'DE',
			'GHA' => 'GH',
			'GIB' => 'GI',
			'GRC' => 'GR',
			'GRL' => 'GL',
			'GRD' => 'GD',
			'GLP' => 'GP',
			'GUM' => 'GU',
			'GTM' => 'GT',
			'GGY' => 'GG',
			'GIN' => 'GN',
			'GNB' => 'GW',
			'GUY' => 'GY',
			'HTI' => 'HT',
			'HMD' => 'HM',
			'VAT' => 'VA',
			'HND' => 'HN',
			'HKG' => 'HK',
			'HUN' => 'HU',
			'ISL' => 'IS',
			'IND' => 'IN',
			'IDN' => 'ID',
			'IRN' => 'IR',
			'IRQ' => 'IQ',
			'IRL' => 'IE',
			'IMN' => 'IM',
			'ISR' => 'IL',
			'ITA' => 'IT',
			'JAM' => 'JM',
			'JPN' => 'JP',
			'JEY' => 'JE',
			'JOR' => 'JO',
			'KAZ' => 'KZ',
			'KEN' => 'KE',
			'KIR' => 'KI',
			'PRK' => 'KP',
			'KOR' => 'KR',
			'KWT' => 'KW',
			'KGZ' => 'KG',
			'LAO' => 'LA',
			'LVA' => 'LV',
			'LBN' => 'LB',
			'LSO' => 'LS',
			'LBR' => 'LR',
			'LBY' => 'LY',
			'LIE' => 'LI',
			'LTU' => 'LT',
			'LUX' => 'LU',
			'MAC' => 'MO',
			'MKD' => 'MK',
			'MDG' => 'MG',
			'MWI' => 'MW',
			'MYS' => 'MY',
			'MDV' => 'MV',
			'MLI' => 'ML',
			'MLT' => 'MT',
			'MHL' => 'MH',
			'MTQ' => 'MQ',
			'MRT' => 'MR',
			'MUS' => 'MU',
			'MYT' => 'YT',
			'MEX' => 'MX',
			'FSM' => 'FM',
			'MDA' => 'MD',
			'MCO' => 'MC',
			'MNG' => 'MN',
			'MNE' => 'ME',
			'MSR' => 'MS',
			'MAR' => 'MA',
			'MOZ' => 'MZ',
			'MMR' => 'MM',
			'NAM' => 'NA',
			'NRU' => 'NR',
			'NPL' => 'NP',
			'NLD' => 'NL',
			'ANT' => 'AN',
			'NCL' => 'NC',
			'NZL' => 'NZ',
			'NIC' => 'NI',
			'NER' => 'NE',
			'NGA' => 'NG',
			'NIU' => 'NU',
			'NFK' => 'NF',
			'MNP' => 'MP',
			'NOR' => 'NO',
			'OMN' => 'OM',
			'PAK' => 'PK',
			'PLW' => 'PW',
			'PSE' => 'PS',
			'PAN' => 'PA',
			'PNG' => 'PG',
			'PRY' => 'PY',
			'PER' => 'PE',
			'PHL' => 'PH',
			'PCN' => 'PN',
			'POL' => 'PL',
			'PRT' => 'PT',
			'PRI' => 'PR',
			'QAT' => 'QA',
			'REU' => 'RE',
			'ROU' => 'RO',
			'RUS' => 'RU',
			'RWA' => 'RW',
			'BLM' => 'BL',
			'SHN' => 'SH',
			'KNA' => 'KN',
			'LCA' => 'LC',
			'MAF' => 'MF',
			'SPM' => 'PM',
			'VCT' => 'VC',
			'WSM' => 'WS',
			'SMR' => 'SM',
			'STP' => 'ST',
			'SAU' => 'SA',
			'SEN' => 'SN',
			'SRB' => 'RS',
			'SYC' => 'SC',
			'SLE' => 'SL',
			'SGP' => 'SG',
			'SVK' => 'SK',
			'SVN' => 'SI',
			'SLB' => 'SB',
			'SOM' => 'SO',
			'ZAF' => 'ZA',
			'SGS' => 'GS',
			'ESP' => 'ES',
			'LKA' => 'LK',
			'SDN' => 'SD',
			'SUR' => 'SR',
			'SJM' => 'SJ',
			'SWZ' => 'SZ',
			'SWE' => 'SE',
			'CHE' => 'CH',
			'SYR' => 'SY',
			'TWN' => 'TW',
			'TJK' => 'TJ',
			'TZA' => 'TZ',
			'THA' => 'TH',
			'TLS' => 'TL',
			'TGO' => 'TG',
			'TKL' => 'TK',
			'TON' => 'TO',
			'TTO' => 'TT',
			'TUN' => 'TN',
			'TUR' => 'TR',
			'TKM' => 'TM',
			'TCA' => 'TC',
			'TUV' => 'TV',
			'UGA' => 'UG',
			'UKR' => 'UA',
			'ARE' => 'AE',
			'GBR' => 'GB',
			'USA' => 'US',
			'UMI' => 'UM',
			'URY' => 'UY',
			'UZB' => 'UZ',
			'VUT' => 'VU',
			'VEN' => 'VE',
			'VNM' => 'VN',
			'VGB' => 'VG',
			'VIR' => 'VI',
			'WLF' => 'WF',
			'ESH' => 'EH',
			'YEM' => 'YE',
			'ZMB' => 'ZM',
			'ZWE' => 'ZW',
			'AFG' => 'AF',
			'ALA' => 'AX',
			'ALB' => 'AL',
			'DZA' => 'DZ',
			'ASM' => 'AS',
			'AND' => 'AD',
			'AGO' => 'AO',
			'AIA' => 'AI',
			'ATA' => 'AQ',
			'ATG' => 'AG',
			'ARG' => 'AR',
			'ARM' => 'AM',
			'ABW' => 'AW',
			'AUS' => 'AU',
			'AUT' => 'AT',
			'AZE' => 'AZ',
			'BHS' => 'BS',
			'BHR' => 'BH',
			'BGD' => 'BD',
			'BRB' => 'BB',
			'BLR' => 'BY',
			'BEL' => 'BE',
			'BLZ' => 'BZ',
			'BEN' => 'BJ',
			'BMU' => 'BM',
			'BTN' => 'BT',
			'BOL' => 'BO',
			'BIH' => 'BA',
			'BWA' => 'BW',
			'BVT' => 'BV',
			'BRA' => 'BR',
			'IOT' => 'IO',
			'BRN' => 'BN',
			'BGR' => 'BG',
			'BFA' => 'BF',
			'BDI' => 'BI',
			'KHM' => 'KH',
			'CMR' => 'CM',
			'CAN' => 'CA',
			'CPV' => 'CV',
			'CYM' => 'KY',
			'CAF' => 'CF',
			'TCD' => 'TD',
			'CHL' => 'CL',
			'CHN' => 'CN',
			'CXR' => 'CX',
			'CCK' => 'CC',
			'COL' => 'CO',
			'COM' => 'KM',
			'COG' => 'CG',
			'COD' => 'CD',
			'COK' => 'CK',
			'CRI' => 'CR',
			'CIV' => 'CI',
			'HRV' => 'HR',
			'CUB' => 'CU',
			'CYP' => 'CY',
			'CZE' => 'CZ',
			'DNK' => 'DK',
			'DJI' => 'DJ',
			'DMA' => 'DM',
			'DOM' => 'DO',
			'ECU' => 'EC',
			'EGY' => 'EG',
			'SLV' => 'SV',
			'GNQ' => 'GQ',
			'ERI' => 'ER',
			'EST' => 'EE',
			'ETH' => 'ET',
			'FLK' => 'FK',
			'FRO' => 'FO',
			'FJI' => 'FJ',
			'FIN' => 'FI',
			'FRA' => 'FR',
			'GUF' => 'GF',
			'PYF' => 'PF',
			'ATF' => 'TF',
			'GAB' => 'GA',
			'GMB' => 'GM',
			'GEO' => 'GE',
			'DEU' => 'DE',
			'GHA' => 'GH',
			'GIB' => 'GI',
			'GRC' => 'GR',
			'GRL' => 'GL',
			'GRD' => 'GD',
			'GLP' => 'GP',
			'GUM' => 'GU',
			'GTM' => 'GT',
			'GGY' => 'GG',
			'GIN' => 'GN',
			'GNB' => 'GW',
			'GUY' => 'GY',
			'HTI' => 'HT',
			'HMD' => 'HM',
			'VAT' => 'VA',
			'HND' => 'HN',
			'HKG' => 'HK',
			'HUN' => 'HU',
			'ISL' => 'IS',
			'IND' => 'IN',
			'IDN' => 'ID',
			'IRN' => 'IR',
			'IRQ' => 'IQ',
			'IRL' => 'IE',
			'IMN' => 'IM',
			'ISR' => 'IL',
			'ITA' => 'IT',
			'JAM' => 'JM',
			'JPN' => 'JP',
			'JEY' => 'JE',
			'JOR' => 'JO',
			'KAZ' => 'KZ',
			'KEN' => 'KE',
			'KIR' => 'KI',
			'PRK' => 'KP',
			'KOR' => 'KR',
			'KWT' => 'KW',
			'KGZ' => 'KG',
			'LAO' => 'LA',
			'LVA' => 'LV',
			'LBN' => 'LB',
			'LSO' => 'LS',
			'LBR' => 'LR',
			'LBY' => 'LY',
			'LIE' => 'LI',
			'LTU' => 'LT',
			'LUX' => 'LU',
			'MAC' => 'MO',
			'MKD' => 'MK',
			'MDG' => 'MG',
			'MWI' => 'MW',
			'MYS' => 'MY',
			'MDV' => 'MV',
			'MLI' => 'ML',
			'MLT' => 'MT',
			'MHL' => 'MH',
			'MTQ' => 'MQ',
			'MRT' => 'MR',
			'MUS' => 'MU',
			'MYT' => 'YT',
			'MEX' => 'MX',
			'FSM' => 'FM',
			'MDA' => 'MD',
			'MCO' => 'MC',
			'MNG' => 'MN',
			'MNE' => 'ME',
			'MSR' => 'MS',
			'MAR' => 'MA',
			'MOZ' => 'MZ',
			'MMR' => 'MM',
			'NAM' => 'NA',
			'NRU' => 'NR',
			'NPL' => 'NP',
			'NLD' => 'NL',
			'ANT' => 'AN',
			'NCL' => 'NC',
			'NZL' => 'NZ',
			'NIC' => 'NI',
			'NER' => 'NE',
			'NGA' => 'NG',
			'NIU' => 'NU',
			'NFK' => 'NF',
			'MNP' => 'MP',
			'NOR' => 'NO',
			'OMN' => 'OM',
			'PAK' => 'PK',
			'PLW' => 'PW',
			'PSE' => 'PS',
			'PAN' => 'PA',
			'PNG' => 'PG',
			'PRY' => 'PY',
			'PER' => 'PE',
			'PHL' => 'PH',
			'PCN' => 'PN',
			'POL' => 'PL',
			'PRT' => 'PT',
			'PRI' => 'PR',
			'QAT' => 'QA',
			'REU' => 'RE',
			'ROU' => 'RO',
			'RUS' => 'RU',
			'RWA' => 'RW',
			'BLM' => 'BL',
			'SHN' => 'SH',
			'KNA' => 'KN',
			'LCA' => 'LC',
			'MAF' => 'MF',
			'SPM' => 'PM',
			'VCT' => 'VC',
			'WSM' => 'WS',
			'SMR' => 'SM',
			'STP' => 'ST',
			'SAU' => 'SA',
			'SEN' => 'SN',
			'SRB' => 'RS',
			'SYC' => 'SC',
			'SLE' => 'SL',
			'SGP' => 'SG',
			'SVK' => 'SK',
			'SVN' => 'SI',
			'SLB' => 'SB',
			'SOM' => 'SO',
			'ZAF' => 'ZA',
			'SGS' => 'GS',
			'ESP' => 'ES',
			'LKA' => 'LK',
			'SDN' => 'SD',
			'SUR' => 'SR',
			'SJM' => 'SJ',
			'SWZ' => 'SZ',
			'SWE' => 'SE',
			'CHE' => 'CH',
			'SYR' => 'SY',
			'TWN' => 'TW',
			'TJK' => 'TJ',
			'TZA' => 'TZ',
			'THA' => 'TH',
			'TLS' => 'TL',
			'TGO' => 'TG',
			'TKL' => 'TK',
			'TON' => 'TO',
			'TTO' => 'TT',
			'TUN' => 'TN',
			'TUR' => 'TR',
			'TKM' => 'TM',
			'TCA' => 'TC',
			'TUV' => 'TV',
			'UGA' => 'UG',
			'UKR' => 'UA',
			'ARE' => 'AE',
			'GBR' => 'GB',
			'USA' => 'US',
			'UMI' => 'UM',
			'URY' => 'UY',
			'UZB' => 'UZ',
			'VUT' => 'VU',
			'VEN' => 'VE',
			'VNM' => 'VN',
			'VGB' => 'VG',
			'VIR' => 'VI',
			'WLF' => 'WF',
			'ESH' => 'EH',
			'YEM' => 'YE',
			'ZMB' => 'ZM',
			'ZWE' => 'ZW',
		);
		
		$this->states = array(
			'AL' => 'Alabama',  
			'AK' => 'Alaska',  
			'AZ' => 'Arizona',  
			'AR' => 'Arkansas',  
			'CA' => 'California',  
			'CO' => 'Colorado',  
			'CT' => 'Connecticut',  
			'DE' => 'Delaware',  
			'DC' => 'District Of Columbia',  
			'FL' => 'Florida',  
			'GA' => 'Georgia',  
			'HI' => 'Hawaii',  
			'ID' => 'Idaho',  
			'IL' => 'Illinois',  
			'IN' => 'Indiana',  
			'IA' => 'Iowa',  
			'KS' => 'Kansas',  
			'KY' => 'Kentucky',  
			'LA' => 'Louisiana',  
			'ME' => 'Maine',  
			'MD' => 'Maryland',  
			'MA' => 'Massachusetts',  
			'MI' => 'Michigan',  
			'MN' => 'Minnesota',  
			'MS' => 'Mississippi',  
			'MO' => 'Missouri',  
			'MT' => 'Montana',
			'NE' => 'Nebraska',
			'NV' => 'Nevada',
			'NH' => 'New Hampshire',
			'NJ' => 'New Jersey',
			'NM' => 'New Mexico',
			'NY' => 'New York',
			'NC' => 'North Carolina',
			'ND' => 'North Dakota',
			'OH' => 'Ohio',  
			'OK' => 'Oklahoma',  
			'OR' => 'Oregon',  
			'PA' => 'Pennsylvania',  
			'RI' => 'Rhode Island',  
			'SC' => 'South Carolina',  
			'SD' => 'South Dakota',
			'TN' => 'Tennessee',  
			'TX' => 'Texas',  
			'UT' => 'Utah',  
			'VT' => 'Vermont',  
			'VA' => 'Virginia',  
			'WA' => 'Washington',  
			'WV' => 'West Virginia',  
			'WI' => 'Wisconsin',  
			'WY' => 'Wyoming'
		);
		$this->_load_locations(); 
		
		foreach ($this->customer_fields as $field)
		{
			$this->default_settings['customer_field_labels'][$field] = ucwords(str_replace('_', ' ', $field));
		}

		/* Retrieve settings from companion extension
			cartthrob_ext.php
		*/
		$this->settings = $this->_get_settings();
		
		$this->_override_settings();

		foreach ($this->settings as $key=>$value)
		{
			$this->{'_'.$key} = $value;
		}

		$this->number_format_defaults = array(
			'decimals' => $this->settings['number_format_defaults_decimals'],
			'dec_point' => $this->settings['number_format_defaults_dec_point'],
			'thousands_sep' => $this->settings['number_format_defaults_thousands_sep'],
			'prefix' => $this->settings['number_format_defaults_prefix'],
			'currency_code' => $this->settings['number_format_defaults_currency_code'],
			'space_after_prefix' => $this->settings['number_format_defaults_space_after_prefix'],
		);

		if ($load_coupon_code_plugins)
		{
			$this->_load_coupon_code_plugins();
		}

		$this->_session_start();
	}
	// END constructor
	function _load_locations()
	{
		$path = PATH_MOD.'cartthrob/lib/locations.php'; 

		if (file_exists($path))
		{
			include($path);
			
			if (isset($my_countries) && is_array($my_countries))
			{
				$this->countries = $my_countries; 
			}
			if (isset($my_states) && is_array($my_states))
			{
				$this->states = $my_states; 
			}
			if (isset($my_languages) && is_array($my_languages))
			{
				$this->languages = $my_languages; 
			}	
		}
	}
	// END
	
	// --------------------------------
	//  Action
	// --------------------------------
	/**
	 * Single template access to add_to_cart, delete_from_cart, change_quantity, clear_cart
	 *
	 * @access public
	 * @param $TMPL->fetch_param('action')
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function action()
	{
		global $TMPL;

		$action = $TMPL->fetch_param('action');

		switch ($action)
		{
			case 'add_to_cart':
				return $this->add_to_cart();
				break;
			case 'delete_from_cart':
				return $this->delete_from_cart();
				break;
			case 'change_quantity':
				return $this->change_quantity();
				break;
			case 'clear_cart':
				return $this->clear_cart();
				break;
			default:
				return '';
		}
	}
	// END

	/**
	 * Prints a coupon code form.
	 *
	 * @access public
	 * @param string $TMPL->fetch_param('action')
	 * @param string $TMPL->fetch_param('id')
	 * @param string $TMPL->fetch_param('class')
	 * @param string $TMPL->fetch_param('name')
	 * @param string $TMPL->fetch_param('onsubmit')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function add_coupon_form()
	{
		global $TMPL, $SESS, $FNS;

		$this->_session_start();
		
		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}
		
		$data = $this->_form_declaration_data('_coupon_code_form_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			switch ($key)
			{
				case 'id':
				case 'name':
				case 'onsubmit':
					$data[$key] = $value;
					break;
				case 'json':
					$data['hidden_fields']['JSN'] = $this->_encode_bool($this->_bool_param('json'));
					break;
				case 'show_errors':
					$data['hidden_fields']['ERR'] = $this->_encode_bool($this->_bool_param('show_errors'));
					break;
				case 'return':
				case 'language':
					$data['hidden_fields'][$key] = $value;
					break;
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		if ($TMPL->fetch_param('language'))
		{
			$this->_set_language($TMPL->fetch_param('language'));
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		$cond = array('allowed' => TRUE);

		if ($this->_global_coupon_limit && count($this->_get_coupon_codes()) >= $this->_global_coupon_limit)
		{
			$cond['allowed'] = FALSE;
		}

		$tagdata = $FNS->prep_conditionals($tagdata, $cond);

		return $tagdata;
	}

	// --------------------------------
	//  Add to Cart
	// --------------------------------
	/**
	 * Adds an item to cart
	 * Can work with both template params (and thus, url segments)
	 * and POSTed values for entry_id and quantity
	 * 
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @access public
	 * @param int $TMPL->fetch_param('entry_id')
	 * @param int $_POST['entry_id']
	 * @param string $TMPL->fetch_param('quantity')
	 * @param string $_POST['quantity']
	 * @return void
	 */
	function add_to_cart()
	{
		global $IN, $TMPL, $FNS, $REGX, $EXT;

		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_add_to_cart_start' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		$this->_session_start();

		if ($EXT->active_hook('cartthrob_add_to_cart_start') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_add_to_cart_start', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}

		$entry_id = $this->_fetch_param('entry_id');

		$quantity = $this->_fetch_param('quantity');

		$price = FALSE;

		$shipping = FALSE;

		$weight = FALSE;
		
		$expiration_date = ($TMPL->fetch_param('expiration_date') !== FALSE) ? $this->_sanitize_number($TMPL->fetch_param('expiration_date')) : FALSE;

		if ($this->_bool_param('on_the_fly') || $this->_bool_param('allow_user_price'))
		{
			$price = $REGX->xss_clean($IN->GBL('price', 'POST'));
		}

		if ($this->_bool_param('on_the_fly') || $this->_bool_param('allow_user_weight'))
		{
			$weight = $REGX->xss_clean($IN->GBL('weight', 'POST'));
		}

		if ($this->_bool_param('on_the_fly') || $this->_bool_param('allow_user_shipping'))
		{
			$shipping = $REGX->xss_clean($IN->GBL('shipping', 'POST'));
		}
		
		if ($TMPL->fetch_param('price'))
		{
			$price = $this->_xss_clean($TMPL->fetch_param('price'));
		}
		
		$item_options = $this->_xss_clean($IN->GBL('item_options', 'POST'));
		
		if ( ! is_array($item_options))
		{
			$item_options = array();
		}
		
		foreach ($TMPL->tagparams as $key => $value)
		{
			if (preg_match('/^item_options?:(.+)$/', $key, $match))
			{
				$item_options[$match[1]] = $this->_xss_clean($value);
			}
		}

		$row_id = $this->_add_to_cart($entry_id,
				    $quantity,
				    $this->_xss_clean($this->_fetch_param('title')),
				    $price,
				    $item_options,
				    $shipping,
				    $weight,
				    $this->_bool_param('no_tax'),
				    $this->_bool_param('no_shipping'),
				    $this->_bool_param('on_the_fly'),
				    $this->_bool_param('show_errors', TRUE),
				    $this->_bool_param('json'),
				    FALSE,
				    $this->_bool_param('license_number'),
				    $expiration_date
		);

		// -------------------------------------------
		// 'cartthrob_add_to_cart_end' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_add_to_cart_end') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_add_to_cart_end', $this, $_SESSION['cartthrob'], $row_id);
			if ($EXT->end_script === TRUE) return;
		}

		$this->_redirect($this->_get_redirect_url());
	}
	// END
	
	// --------------------------------
	//  Add to Cart Form
	// --------------------------------
	/**
	 * add_to_cart_form
	 *
	 * This tag creates a form for adding one or more products to the cart object
	 * 
	 * @return string Tagdata output
	 * @author Rob Sanchez
	 * @since 1.0
	 * @access public
	 * @param string TEMPLATE PARAM id css id
	 * @param string TEMPLATE PARAM name form name
	 * @param string TEMPLATE PARAM onsubmit javascript function to use on submit
	 * @param int TEMPLATE PARAM entry_id on the fly entry id
	 * @param int TEMPLATE PARAM quantity on the fly quantity
	 * @param string TEMPLATE PARAM title on the fly title
	 * @param string TEMPLATE PARAM language validation errors language
	 * @param bool TEMPLATE PARAM license_number flag to suggest that a license should be generated for these products
	 * @param number TEMPLATE PARAM price on the fly price
	 * @param bool TEMPLATE PARAM allow_user_price allows user to write in their own price (donations)
	 * @param number TEMPLATE PARAM shipping on the fly shipping cost
	 * @param number TEMPLATE PARAM weight on the fly shipping weight
	 * @param bool TEMPLATE PARAM no_tax flag to set taxation on this item
	 * @param bool TEMPLATE PARAM no_shipping flag to set taxation on this item
	 * @param bool TEMPLATE PARAM on_the_fly flag to allow addition of hard coded products
	 * @param bool TEMPLATE PARAM show_errors flag to turn off error responses
	 * @param bool TEMPLATE PARAM json flag to set responses as JSON (for ajax)
	 * @param string TEMPLATE PARAM return url to be redirected to on form submit
	 */
	function add_to_cart_form()
	{
		global $TMPL, $FNS;

		$this->_session_start();

		$data = $this->_form_declaration_data('_add_to_cart_form_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'entry_id':
					case 'quantity':
					case 'title':
					case 'language':
						$data['hidden_fields'][$key] = $value;
						break;
					case 'license_number':
						if ($this->_bool_param('license_number'))
						{
							$data['hidden_fields'][$key] = '1';
						}
						break;
					case 'price':
						$data['hidden_fields']['PR'] = $this->_encode_string($this->_sanitize_number($value));
						break;
					case 'allow_user_price':
						$data['hidden_fields']['AUP'] = $this->_encode_bool($this->_bool_param('allow_user_price'));
						break;
					case 'allow_user_weight':
						$data['hidden_fields']['AUW'] = $this->_encode_bool($this->_bool_param('allow_user_weight'));
						break;
					case 'allow_user_shipping':
						$data['hidden_fields']['AUS'] = $this->_encode_bool($this->_bool_param('allow_user_shipping'));
						break;
					case 'shipping':
						$data['hidden_fields']['SHP'] = $this->_encode_string($value);
						break;
					case 'weight':
						$data['hidden_fields']['WGT'] = $this->_encode_string($value);
						break;
					case 'expiration_date':
						$data['hidden_fields']['EXP'] = $this->_encode_string($this->_sanitize_number($value));
						break;
					case 'no_tax':
						$data['hidden_fields']['NTX'] = $this->_encode_bool($this->_bool_param('no_tax'));
						break;
					case 'no_shipping':
						$data['hidden_fields']['NSH'] = $this->_encode_bool($this->_bool_param('no_shipping'));
						break;
					case 'on_the_fly':
						$data['hidden_fields']['OTF'] = $this->_encode_bool($this->_bool_param('on_the_fly'));
						break;
					case 'show_errors':
						$data['hidden_fields']['ERR'] = $this->_encode_bool($this->_bool_param('show_errors'));
						break;
					case 'json':
						$data['hidden_fields']['JSN'] = $this->_encode_bool($this->_bool_param('json'));
						break;
					case 'redirect':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
				}

				if (preg_match('/item_option:(.+)/', $key, $match))
				{
					$data['hidden_fields']['item_options['.$match[1].']'] = $value;
				}
			}
		}

		if (preg_match_all("/".LD."inventory:reduce\s*(.*)".RD."/", $TMPL->tagdata, $matches))
		{
			foreach ($matches[0] as $which => $full_match)
			{
				$output = '';

				$var_string = $matches[1][$which];

				$var_params = array();

				if (preg_match_all("/\s*([^=\047\042]*)\s*=\s*[\047\042]([^\047\042]*)[\047\042]\s*/", $var_string, $var_string_matches))
				{
					foreach ($var_string_matches[1] as $var_string_which => $var_param_key)
					{
						$var_params[$var_param_key] = $var_string_matches[2][$var_string_which];
					}
				}

				if (empty($var_params['quantity']))
				{
					$var_params['quantity'] = 1;
				}
				else
				{
					$var_params['quantity'] = $this->_sanitize_number($var_params['quantity']);
				}

				if ( ! empty($var_params['entry_id']))
				{
					$quantity = ( ! empty($var_params['quantity'])) ? $var_params['quantity'] : 1;

					$data['hidden_fields']['inventory_reduce['.$var_params['entry_id'].']'] = $quantity;
				}

				$TMPL->tagdata = str_replace($full_match, '', $TMPL->tagdata);
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		if ($TMPL->fetch_param('language'))
		{
			$this->_set_language($TMPL->fetch_param('language'));
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		$tagdata = $this->_parse_item_option_inputs($tagdata, NULL, NULL, TRUE);

		return $tagdata;
	}
	//END
	
	
	// --------------------------------
	//  Add Coupon Code
	// --------------------------------
	/**
	 * Apply the specified coupon code.
	 *
	 * @access public
	 * @param int TEMPLATE PARAM | POST PARAM entry_id ID of the coupon code
	 * @param string TEMPLATE PARAM | POST PARAM quantity amount of this code to submit
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function add_coupon_code()
	{
		global $IN, $TMPL, $REGX, $FNS;

		$this->_add_coupon_code(trim($REGX->xss_clean($IN->GBL('coupon_code', 'POST'))));

		$this->_redirect($this->_get_redirect_url());
	}
	// END
	/**
	 * also_purchased
	 *
	 * Tag pair will replace {entry_id} with entry id of related purchased items.
	 * @return string
	 * @param $TMPL entry_id
	 * @param $TMPL limit
	 * @author Chris Newton
	 * @since 1.0
	 **/
	function also_purchased()
	{
		global $DB, $TMPL;
		$tagdata = $TMPL->tagdata;
		
		if ( ! $this->_purchased_items_weblog || ! $this->_purchased_items_id_field)
		{
			return FALSE;
		}
		$entry_ids = array();
		$ids_count = array(); 
		
		$entry_id = explode('|', $TMPL->fetch_param('entry_id'));
		foreach ($entry_id as $id)
		{
			
			$query = $DB->query("SELECT entry_id
						FROM exp_weblog_titles
						WHERE weblog_id = ".$this->_get_weblog_id($this->_purchased_items_weblog)."
						AND author_id IN
						(SELECT t.author_id
							FROM exp_weblog_titles t, exp_weblog_data d
							WHERE d.".$this->_get_field_id($this->_purchased_items_id_field)." = '".$DB->escape_str($id)."'
						)");

			foreach ($query->result as $row)
			{
				$query = $DB->query("SELECT ".$this->_get_field_id($this->_purchased_items_id_field). 
							" AS product_id 
							FROM exp_weblog_data
							WHERE weblog_id = ".$this->_get_weblog_id($this->_purchased_items_weblog)."
							AND entry_id = ".$row['entry_id']); 
				foreach ($query->result as $row)
				{
					if ($row['product_id'] != $id)
					{
						if (!empty($ids_count[$row['product_id']]))
						{
							$ids_count[$row['product_id']] += 1; 
						}
						else
						{
							$ids_count[$row['product_id']] = 1; 
						}
						$entry_ids[] = $row['product_id'];
					}
				}			
			}
		}
		arsort($ids_count);
		$entry_ids = array_unique($entry_ids);
		$limit = (($this->_fetch_param("limit")) ? $this->_fetch_param("limit"): "20"); 
		array_slice($ids_count, 0, $limit, true);
		foreach ($ids_count as $key => $id)
		{
			if (!isset($temp))
			{
				$temp  = str_replace("{entry_id}", $key, $TMPL->tagdata);
			}
			else
			{
				$temp  .= str_replace("{entry_id}", $key, $TMPL->tagdata);
			}
		}

		return $temp; 
	}
	// END

	// --------------------------------
	//  Arithmetic
	// --------------------------------
	/**
	 * arithmetic
	 * 
	 * This function does arithmetic calculations
	 *
	 * @return string
	 * @param string TEMPLATE PARAM operator + / - etc
	 * @author Rob Sanchez
	 * @access public
	 * @since 1.0
	 */
	function arithmetic()
	{
		global $TMPL;

		$operator = $TMPL->fetch_param('operator');
		
		if ($operator == '&#47;')
		{
			$operator = '/';
		}

		$valid_operators = array(
			'+',
			'-',
			'*',
			'/',
			'%',
			'++',
			'--'
		);

		$return = '';

		if ( ! $operator || ! in_array($operator, $valid_operators))
		{
			return $return;
		}

		$num1 = $TMPL->fetch_param('num1');

		$num2 = $TMPL->fetch_param('num2');

		if ($operator == '++')
		{
			$num2 = 1;
			$operator = '+';
		}
		elseif ($operator == '--')
		{
			$num2 = 1;
			$operator = '-';
		}

		if ($num1 == FALSE || $num2 == FALSE)
		{
			return $return;
		}

		$str = '$return = $this->view_formatted_number('.$this->_sanitize_number($num1, TRUE).$operator.$this->_sanitize_number($num2, TRUE).');';

		@eval($str);

		return $return;
	}
	// END

	// --------------------------------
	//  Cart Empty Redirect
	// --------------------------------
	/**
	 * Redirects if cart is empty.
	 * Place on your view cart page.
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	*/
	function cart_empty_redirect()
	{
		global $TMPL, $FNS;

		if ( ! count($this->_get_items()))
		{
			$this->_redirect($this->_get_redirect_url());
		}
	}
	// END

	// --------------------------------
	//  Cart Entry IDs
	// --------------------------------
	/**
	 * Returns pipe delimited list of entry_id's in cart
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_entry_ids()
	{
		$entry_ids = array();

		foreach ($this->_get_items() as $item)
		{
			if (empty($item['on_the_fly']))
			{
				$entry_ids[] = $item['entry_id'];
			}
		}

		return implode('|', $entry_ids);
	}
	// END 

	/**
	 * Tag pair with data from current cart
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_info()
	{
		global $TMPL, $REGX, $FNS;

		$this->_session_start();

		$items = $this->_get_items();

		$tagdata = $TMPL->tagdata;

		$total_results = count($items);

		if ( ! $total_results)
		{
			return $TMPL->no_results;
		}

		$data = array_merge($this->_get_cart_info(), $this->_get_customer_info(TRUE));

		foreach ($TMPL->var_single as $value)
		{
			if (isset($data[$value]))
			{
				$tagdata = $TMPL->swap_var_single($value, $data[$value], $tagdata);
			}
		}

		$cond = array(
			'cart_subtotal'=>(bool) $this->_calculate_subtotal(),
			'cart_shipping'=>(bool) $this->_calculate_shipping(),
			'cart_tax'=>(bool) $this->_calculate_tax(),
			'cart_discount'=>(bool) $this->_calculate_discount(),
			'cart_total'=>(bool) $this->_calculate_total(),
		);

		$tagdata = $FNS->prep_conditionals($tagdata, $cond);

		return $tagdata;
	}

	/**
	 * Prints out cart contents
	 *
	 * @access public
	 * @param string $TMPL->fetch_param('delete_purchased')
	 * @param string $TMPL->fetch_param('show_deleted')
	 * @return string
	 * @since 1.0.
	 * @author Rob Sanchez
	 * 
	*/
	function cart_items_info()
	{
		global $TMPL, $REGX, $FNS;

		$this->_session_start();

		$items = $this->_get_cart_items(FALSE, $TMPL->fetch_param('orderby'), $TMPL->fetch_param('sort'));
		
		$limit = $TMPL->fetch_param('limit');
		
		$offset = $TMPL->fetch_param('offset');

		$return_data = '';

		$total_results = count($items);

		$count = 0;

		$absolute_count = 0;

		$cart_data = array(
			'total_unique_items'=>$this->total_unique_items(),
			'total_items'=>$this->total_items(),
			'cart_total'=>$this->cart_total(),
			'cart_subtotal'=>$this->cart_subtotal(),
			'cart_tax'=>$this->cart_tax(),
			'cart_tax_name'=>$this->_get_tax_name(),
			'cart_discount'=>$this->cart_discount(),
			'cart_tax_rate'=>$this->_get_tax_rate(TRUE,( ! empty($this->settings['tax_use_shipping_address'])) ? 'shipping_' : ''),
			'cart_shipping'=>$this->cart_shipping(),
			'shipping_option'=>$this->_get_shipping_option()
		);
		
		$this->_load_typography();

		foreach ($items as $row_id => $item)
		{
			$absolute_count++;
			
			if ($offset !== FALSE && $absolute_count <= $offset)
			{
				continue;
			}
			
			$count++;

			$tagdata = $TMPL->tagdata;

			$cond = array();

			foreach ($cart_data as $key => $value)
			{
				$cond[$key] = (bool) ((float) $this->_sanitize_number($value));
			}

			// thanks to JamieR
			foreach ($item as $key => $value)
			{
				if ($key == 'item_options') 
			    {
					foreach ($item[$key] as $option => $option_val)
					{
					$cond[$key . ':' . $option] = TRUE;
					}
				}
				else
				{
					$cond[$key] = (bool) ((float) $this->_sanitize_number($value));
				}
			}
				
			$entry_id = $item['entry_id'];

			$data = array_merge($this->_get_item_data($entry_id), $cart_data);

			$data['cart_count'] = $data['count'] = $count;

			$data['quantity'] = $item['quantity'];

			$data['index'] = $data['row_id'] = $row_id;

			$data['item_subtotal'] = $data['product_subtotal'] = $this->view_formatted_number($this->_get_item_price($entry_id, $row_id) * $item['quantity']);

			$data['item_weight'] = $data['product_weight'] = $this->_get_item_weight($entry_id, $row_id);

			$data['item_shipping'] = $data['product_shipping'] = $this->view_formatted_number($this->_calculate_item_shipping($entry_id, $row_id, $item['quantity']));

			$data['item_price'] = $data['product_price'] = $this->view_formatted_number($this->_get_item_price($entry_id, $row_id));

			$price_field = ( ! empty($item['weblog_id'])) ? $this->_get_price_field($item['weblog_id'], 'name') : NULL;

			if ($price_field && isset($data[$price_field]))
			{
				$data[$price_field] = $data['item_price'];
			}

			$price_mods = $this->_get_all_price_modifiers($entry_id);

			foreach ($TMPL->var_single as $key => $val)
			{
				if (isset($data[$val]))
				{
					$tagdata = $TMPL->swap_var_single($val, $data[$val], $tagdata);
				}

				if (preg_match('/^switch/', $key))
				{
					$sparam = $FNS->assign_parameters($key);

					$sw = '';

					if (isset($sparam['switch']))
					{
						$sopt = @explode("|", $sparam['switch']);
						$sw = $sopt[($count + count($sopt)) % count($sopt)];
					}

					$tagdata = $TMPL->swap_var_single($key, $sw, $tagdata);
				}

				if (preg_match('/row_id_path(.*)?/', $key, $match))
				{
					$tagdata = $TMPL->swap_var_single($key, $FNS->create_url($FNS->extract_path($match[1]).'/'.$row_id), $tagdata);
				}

				if (preg_match('/entry_id_path(.*)?/', $key, $match))
				{
					$tagdata = $TMPL->swap_var_single($key, $FNS->create_url($FNS->extract_path($match[1]).'/'.$entry_id), $tagdata);
				}

				if (preg_match('/^item_options?:(.*)/', $key, $match))
				{
					$item_options_key = $match[1];

					if (preg_match('/^(select:|input:)/', $item_options_key))
					{
						continue;
					}

					if (preg_match('/(.+):(option_name|option_label|label|name)/', $item_options_key, $match))
					{
						$item_options_key = $match[1];

						$item_options_value = isset($item['item_options'][$item_options_key]) ? $item['item_options'][$item_options_key] : '';

						$option_name = '';

						if ( ! empty($data[$item_options_key]) && isset($item['item_options'][$item_options_key]))
						{
							foreach ($price_mods as $price_mod)
							{
								if ($item_options_key == $price_mod['option_name'] && $item['item_options'][$item_options_key] == $price_mod['option'])
								{
									$option_name = $price_mod['option_label'];
									break;
								}
							}
						}

						if ($item_options_value && isset($_SESSION['cartthrob']['item_option_names'][$item_options_key][$item_options_value]))
						{
							$option_name = $_SESSION['cartthrob']['item_option_names'][$item_options_key][$item_options_value];
						}

						$tagdata = $TMPL->swap_var_single($key, $option_name, $tagdata);
					}
					else if (preg_match('/(.+):price/', $item_options_key, $match))
					{
						$item_options_key = $match[1];
						
						$price = '';

						if ( ! empty($data[$item_options_key]) && isset($item['item_options'][$item_options_key]))
						{
							foreach ($price_mods as $price_mod)
							{
								if ($item_options_key == $price_mod['option_name'] && $item['item_options'][$item_options_key] == $price_mod['option'])
								{
									$price = $this->view_formatted_number($price_mod['price']);
									break;
								}
							}
						}

						$tagdata = $TMPL->swap_var_single($key, $price, $tagdata);
					}
					else
					{
						$item_options_value = isset($item['item_options'][$item_options_key]) ? $item['item_options'][$item_options_key] : '';

						$tagdata = $TMPL->swap_var_single($key, $item_options_value, $tagdata);
					}
				}
			}

			foreach ($TMPL->var_pair as $key => $val)
			{
				if (preg_match('/^categories/', $key))
				{
					if (preg_match("/".LD."$key".RD."(.*?)".LD.SLASH.'categories'.RD."/s", $tagdata, $matches))
					{
						$temp = $matches[1];

						$output = '';

						foreach ($data['categories'] as $category)
						{
							$output .= $temp;

							foreach ($category as $cat_key => $cat_val)
							{
								$output = str_replace(LD.$cat_key.RD, $cat_val, $output);
							}
						}

						$tagdata = preg_replace("/".LD."$key".RD."(.*?)".LD.SLASH.'categories'.RD."/s", $output, $tagdata);
					}
				}
				elseif (preg_match('/^number_format/', $key))
				{
					$search_key = str_replace('$', '\$', $key);
					$search_key = str_replace('?', '\?', $search_key);

					if (preg_match_all("/".LD.$search_key.RD."(.*?)".LD.SLASH.'number_format'.RD."/s", $tagdata, $matches))
					{
						foreach ($matches[1] as $match)
						{
							$number = trim($match);

							if ($number[0] == LD && preg_match("/".LD."(.*?)".RD."/s", $number, $num_matches) && isset($data[$num_matches[1]]))
							{
								$number = $TMPL->swap_var_single($num_matches[1], $data[$num_matches[1]], $number);
							}

							$number = $this->_sanitize_number($number);

							$decimals = (isset($TMPL->var_pair[$key]['decimals']) && $TMPL->var_pair[$key]['decimals']) ? (int) $TMPL->var_pair[$key]['decimals'] : $this->number_format_defaults['decimals'];
							$dec_point = (isset($TMPL->var_pair[$key]['dec_point']) && $TMPL->var_pair[$key]['dec_point']) ? $TMPL->var_pair[$key]['dec_point'] : $this->number_format_defaults['dec_point'];
							$thousands_sep = (isset($TMPL->var_pair[$key]['thousands_sep']) && $TMPL->var_pair[$key]['thousands_sep']) ? $TMPL->var_pair[$key]['thousands_sep'] : $this->number_format_defaults['thousands_sep'];
							$prefix = (isset($TMPL->var_pair[$key]['prefix']) && $TMPL->var_pair[$key]['prefix']) ? $TMPL->var_pair[$key]['prefix'] : $this->number_format_defaults['prefix'];
							$prefix = (isset($TMPL->var_pair[$key]['space_after_prefix']) && $TMPL->var_pair[$key]['space_after_prefix']) ? $TMPL->var_pair[$key]['space_after_prefix'] : $this->number_format_defaults['space_after_prefix'];

							$output = str_replace('$', '\$', str_replace('?', '\?', $prefix.number_format($number, $decimals, $dec_point, $thousands_sep)));

							$tagdata = preg_replace("/".LD.$search_key.RD.$match.LD.SLASH.'number_format'.RD."/s", $output, $tagdata);
						}
					}
				}
			}

			$tagdata = $TMPL->swap_var_single('total_results', $total_results, $tagdata);

			$cond = array_merge(
				$cond,
				array(
					'first_row'=>($count == 1),
					'last_row'=>($count == $total_results),
					'discounted'=>(bool) $this->_sanitize_number($cart_data['cart_discount']),
					'is_on_the_fly'=>$this->_is_item_on_the_fly($item),
					'has_item_options'=>isset($item['item_options']),
					'no_item_options'=>empty($item['item_options'])
				)
			);

			if ($this->_purchased_items_weblog && $this->_purchased_items_id_field)
			{
				$cond['has_purchased'] = $this->_has_purchased($entry_id);
			}

			$tagdata = $FNS->prep_conditionals($tagdata, $cond);

			$item['row_id'] = $row_id;

			$tagdata = $this->_parse_item_option_inputs($tagdata, $item, $data);
			
			$tagdata = $this->TYPE->parse_file_paths($tagdata);

			$return_data .= $tagdata;
			
			if ($limit !== FALSE && $count >= $limit)
			{
				break;
			}
		}

		if ( ! count($_SESSION['cartthrob']['items']))
		{
			$return_data .= $TMPL->no_results;
		}

		return $return_data;
	}

	/**
	 * Returns discount
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_discount()
	{
		return $this->view_formatted_number($this->_calculate_discount());
	}
	/**
	 * Returns discount percentage of total
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function cart_discount_percent_of_total()
	{
		return $this->view_formatted_number( $this->_cart_discount_percentage("total"));
	}
	/**
	 * Returns discount percentage of subtotal
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function cart_discount_percent_of_subtotal()
	{
		return $this->view_formatted_number( $this->_cart_discount_percentage("subtotal"));
	}
	/**
	 * Returns subtotal
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_subtotal()
	{
		return $this->view_formatted_number($this->_calculate_subtotal());
	}

	/**
	 * Returns subtotal + shipping
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_subtotal_plus_shipping()
	{
		return $this->view_formatted_number($this->_calculate_subtotal() + $this->_calculate_shipping());
	}

	/**
	 * Returns total shipping cost of cart
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_shipping()
	{
		return $this->view_formatted_number($this->_calculate_shipping());
	}

	/**
	 * Returns total tax of cart
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_tax()
	{
		return $this->view_formatted_number($this->_calculate_tax());
	}
	function cart_tax_rate()
	{
		return $this->_get_tax_rate(TRUE, ( ! empty($this->settings['tax_use_shipping_address'])) ? 'shipping_' : ''); 
	}
	/**
	 * Returns total price of all items in cart
	 * The formula is subtotal + tax + shipping - discount
	 * Uses number format params.
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function cart_total()
	{
		return $this->view_formatted_number($this->_calculate_total());
	}

	/**
	 * Changes the quantity of an item in the cart
	 * To change multiple item quantities, submit a $_POST['entry_ids'],
	 * an associative array with entry_id as key, and quantity as value
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('entry_id')
	 * @param int $_POST['entry_id']
	 * @param int $TMPL->fetch_param('quantity')
	 * @param int $_POST['quantity']
	 * @param int $_POST['entry_ids']
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function change_quantity()
	{
		global $IN, $TMPL, $FNS;

		//trigger array mode
		$entry_ids = $this->_xss_clean($IN->GBL('entry_ids', 'POST'));

		$row_ids = $this->_xss_clean(($IN->GBL('row_ids', 'POST')) ? $IN->GBL('row_ids', 'POST') : $IN->GBL('indexes', 'POST'));

		if (is_array($row_ids) && count($row_ids))
		{
			foreach ($row_ids as $row_id => $quantity)
			{
				$this->_change_quantity(FALSE, $quantity, $row_id);
			}
		}
		elseif (is_array($entry_ids) && count($entry_ids))
		{
			foreach ($entry_ids as $entry_id => $quantity)
			{
				$this->_change_quantity($entry_id, $quantity);
			}
		}
		else
		{
			$row_id = $this->_xss_clean(($IN->GBL('row_id', 'POST')) ? $IN->GBL('row_id', 'POST') : $IN->GBL('index', 'POST'));

			$this->_change_quantity($this->_fetch_param('entry_id'), $this->_fetch_param('quantity'), $row_id);
		}

		$this->_redirect($this->_get_redirect_url());
	}
	/**
	 * Check_cc_number_errors
	 * 
	 * Makes sure card number and the type of card match. 
	 * 
	 * @access public
	 * @param string $ccn | $TMPL->fetch_param('credit_card_number') this is the credit card number to verify
	 * @param int $card_type_number | $TMPL->fetch_param('card_type_number')  single digit card type corresponding to the array below. Essentially the first number on the card. 3|4|5|6
	 * @param string $card_type | $TMPL->fetch_param('card_type')  Extra check against a known card type VISA|AMEX|AMERICAN EXPRESS|MC|MASTER CARD|MASTERCARD|DISCOVER
	 * @return mixed Error strings or FALSE. If there are no errors, FALSE is returned
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function check_cc_number_errors($ccn=NULL,$card_type_number = NULL, $card_type=NULL )
	{
		global $TMPL;
		if ($TMPL->fetch_param('credit_card_number'))
		{
			$ccn = $TMPL->fetch_param('credit_card_number');
		}
		if ($TMPL->fetch_param('card_type_number'))
		{
		$card_type_number = $TMPL->fetch_param('card_type_number');	
		}
		if ($TMPL->fetch_param('card_type'))
		{
			$card_type = $TMPL->fetch_param('card_type');
		}
		return $this->_check_cc_number_errors($ccn,$card_type_number,$card_type);
	}
	/**
	 * Check_valid_cc_number
	 *
	 * Runs a  MODULUS 10 CHECK ON CC NUMBER TO MAKE SURE IT'S VALID
	 * @access public
	 * @param string $ccn | $TMPL->fetch_param('credit_card_number') The credit card number. 
	 * @return bool (true if number is good)
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function check_valid_cc_number($ccn=NULL)
	{
		global $TMPL;
		if ($TMPL->fetch_param('credit_card_number'))
		{
			$ccn = $TMPL->fetch_param('credit_card_number');
		}
		return $this->_check_valid_cc_number($ccn);
	}
	
	/**
	 * Prints out checkout <form>
	 *
	 * @access public
	 * @param string $TMPL->fetch_param('logged_out_redirect')
	 * @param string $TMPL->fetch_param('cart_empty_redirect')
	 * @param string $TMPL->fetch_param('return')
	 * @param string $TMPL->fetch_param('id')
	 * @param string $TMPL->fetch_param('class')
	 * @param string $TMPL->fetch_param('name')
	 * @param string $TMPL->fetch_param('onsubmit')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function checkout_form()
	{
		global $TMPL, $SESS, $FNS, $IN;
		
		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}

		if ($this->_is_cart_empty() && $TMPL->fetch_param('cart_empty_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('cart_empty_redirect'));
		}

		if ($SESS->userdata['member_id'] == 0 && $this->_logged_in)
		{
			return $TMPL->no_results;
		}
		else
		{
			$this->_session_start();

			$data = $this->_form_declaration_data('_checkout');

			if ($TMPL->fetch_param('id'))
			{
				$data['id'] = $TMPL->fetch_param('id');
			}
			if ($TMPL->fetch_param('name'))
			{
				$data['name'] = $TMPL->fetch_param('name');
			}
			if ($TMPL->fetch_param('onsubmit'))
			{
				$data['onsubmit'] = $TMPL->fetch_param('onsubmit');
			}
			if ($TMPL->fetch_param('group_id') !== FALSE && $TMPL->fetch_param('group_id') !== '')
			{
				$data['hidden_fields']['GI'] = $this->_encode_string($this->_sanitize_number($TMPL->fetch_param('group_id')));
			}
				
			if ($TMPL->fetch_param('show_errors') !== FALSE && $TMPL->fetch_param('show_errors') !== '')
			{
				$data['hidden_fields']['ERR'] = $this->_encode_bool($this->_bool_param('show_errors'));
			}	
				
			if ($TMPL->fetch_param('price') !== FALSE && $TMPL->fetch_param('price') !== '')
			{
				$data['hidden_fields']['PR'] = $this->_encode_string($this->_sanitize_number($TMPL->fetch_param('price')));
			}
			if ($TMPL->fetch_param('shipping') !== FALSE && $TMPL->fetch_param('shipping') !== '')
			{
				$data['hidden_fields']['SHP'] = $this->_encode_string($this->_sanitize_number($TMPL->fetch_param('shipping')));
			}
			if ($TMPL->fetch_param('tax') !== FALSE && $TMPL->fetch_param('tax') !== '')
			{
				$data['hidden_fields']['TX'] = $this->_encode_string($this->_sanitize_number($TMPL->fetch_param('tax')));
			}
			if ($TMPL->fetch_param('expiration_date') !== FALSE && $TMPL->fetch_param('expiration_date') !== '')
			{
				$data['hidden_fields']['EXP'] = $this->_encode_string($this->_sanitize_number($TMPL->fetch_param('expiration_date')));
			}
			if ($TMPL->fetch_param('allow_user_price'))
			{
				$data['hidden_fields']['AUP'] = $this->_encode_bool($this->_bool_param('allow_user_price'));
			}
			if ($TMPL->fetch_param('required'))
			{
				$data['hidden_fields']['REQ'] = $this->_encode_string($TMPL->fetch_param('required'));
			}
			if ($TMPL->fetch_param('gateway') && $this->settings['allow_gateway_selection'])
			{
				if ($this->settings['encode_gateway_selection'])
				{
					$data['hidden_fields']['gateway'] = $this->_encode_string($TMPL->fetch_param('gateway'));
				}
				else
				{
					$data['hidden_fields']['gateway'] = $TMPL->fetch_param('gateway');
				}
			}
			if ($TMPL->fetch_param('action'))
			{
				$data['hidden_fields']['return'] = $TMPL->fetch_param('action');
			}
			if ($TMPL->fetch_param('return'))
			{
				$data['hidden_fields']['return'] = $TMPL->fetch_param('return');
			}
			if ($TMPL->fetch_param('language'))
			{
				$data['hidden_fields']['language'] = $TMPL->fetch_param('language');
				$this->_set_language($TMPL->fetch_param('language'));
			}
			if ($TMPL->fetch_param('authorized_redirect'))
			{
				$data['hidden_fields']['authorized_redirect'] = $TMPL->fetch_param('authorized_redirect');
			}
			if ($TMPL->fetch_param('failed_redirect'))
			{
				$data['hidden_fields']['failed_redirect'] = $TMPL->fetch_param('failed_redirect');
			}
			if ($TMPL->fetch_param('declined_redirect'))
			{
				$data['hidden_fields']['declined_redirect'] = $TMPL->fetch_param('declined_redirect');
			}
			if ($TMPL->fetch_param('country_code'))
			{
				$data['hidden_fields']['derive_country_code'] = $TMPL->fetch_param('country_code');
			}
			if ($TMPL->fetch_param('create_user'))
			{
				$data['hidden_fields']['create_user'] = $TMPL->fetch_param('create_user');
			}

			$tagdata = $FNS->form_declaration($data);

			if ($TMPL->fetch_param('class'))
			{
				$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
			}
		
			if (strpos($tagdata, '&amp;#47;') !== FALSE)
			{
				$tagdata = str_replace('&amp;#47;', '/', $tagdata);
			}

			$tagdata .= $TMPL->tagdata;

			$tagdata .= '</form>';

			$tagdata = $TMPL->swap_var_single('gateway_fields', $this->gateway_fields(), $tagdata);

			return $tagdata;
		}
	}

	/**
	 * Empties the cart
	 *
	 * @access public
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function clear_cart($redirect = TRUE)
	{
		global $TMPL, $FNS;

		$this->_session_start();

		$_SESSION['cartthrob']['items'] = array();
		$_SESSION['cartthrob']['coupon_codes'] = array();
		$_SESSION['cartthrob']['shipping'] = array();

		if ($this->_bool_param('clear_customer_info'))
		{
			$_SESSION['cartthrob']['customer_info'] = array();
		}

		if ($redirect)
		{
			$this->_redirect($this->_get_redirect_url());
		}
	}

	function clear_coupon_codes()
	{
		$this->_clear_coupon_codes();

		$this->_redirect($this->_get_redirect_url());
	}
	
	/**
	 * convert_response_xml function
	 *
	 * This converts xml nodes to array keys. This is really only useful for very small xml responses and does not return attributes, only nodes and node names.
	 *
	 * @param string $xml xml to be converted to array
	 * @return array
	 * @since 1.0
	 * @access public
	 * @author Chris Newton
	 **/
	function convert_response_xml($xml) {
		$xml_array = array();

		$node_chars = '/<(\w+)\s*([^\/>]*)\s*(?:\/>|>(.*)<\/\s*\\1\s*>)/s';
		$attr_chars = '/(\w+)=(?:"|\')([^"\']*)(:?"|\')/';

		preg_match_all($node_chars, $xml, $elements);

		foreach ($elements[1] as $key => $value) 
		{
			if ($elements[3][$key]) 
			{
				$xml_array[$elements[1][$key]] = $elements[3][$key];
			}
		}
		return $xml_array;
	}
	// END
	
	function countries()
	{
		global $TMPL;
		
		$output = '';
		
		foreach ($this->countries as $country_code => $country)
		{
			$temp = $TMPL->tagdata;
			
			if ($this->_bool_param('alpha2'))
			{
				$country_code = $this->_get_alpha2_country_code($country_code);
			}
		
			$temp = $TMPL->swap_var_single('country_code', $country_code, $temp);
			
			$temp = $TMPL->swap_var_single('country', $country, $temp);
			
			$output .= $temp;
		}
		
		return $output;
	}
	
	function country_select()
	{
		global $TMPL;
		
		$name = $TMPL->fetch_param('name');
		
		$id = ($TMPL->fetch_param('id')) ? ' id="'.$TMPL->fetch_param('id').'"' : '';
		
		$class = ($TMPL->fetch_param('class')) ? ' class="'.$TMPL->fetch_param('class').'"' : '';
		
		$extra = $TMPL->fetch_param('extra');
		
		$selected = $TMPL->fetch_param('selected');
		
		if ($extra && substr($extra, 0, 1) !== ' ')
		{
			$extra = ' '.$extra;
		}

		$country_codes = $this->_bool_param('country_codes', TRUE);
		
		$output = '<select name="'.$name.'"'.$id.$class.$extra.'>'."\n";
		
		foreach ($this->countries as $country_code => $country)
		{
			if ($this->_bool_param('alpha2'))
			{
				$country_code = $this->_get_alpha2_country_code($country_code);
			}
			
			$value = ($country_codes) ? $country_code : $country;
			
			$selected = ($value === $TMPL->fetch_param('selected')) ? ' selected="selected"' : '';
			
			$output .= "\t".'<option value="'.$value.'"'.$selected.'>'.$country.'</option>'."\n";
		}
		
		$output .= '</select>'."\n";
		
		return $output;
	}
	
	function coupon_count()
	{
		$this->_session_start();
		
		return count($_SESSION['cartthrob']['coupon_codes']);
	}
	

	/**
	 * Curl Transaction
	 *
	 * This is a simple curl function for sending data
	 * 
	 * @param string $post_url (url to CURL to)
	 * @param array $data (data to send)
	 * @param string $header (passin the header type if it needs to be specific. I'm looking at YOU Authorize.net ARB!!! )
	 * @return string response from post_url server
	 * @access public
	 * @author Chris Newton
	 * @since 1.0.0
	 **/
	function curl_transaction($post_url,$data=NULL, $header = NULL,$mode="POST", $suppress_errors = FALSE)
	{
		global $OUT, $LANG;

		if ( ! function_exists('curl_exec'))
		{
			return $OUT->show_user_error('general', $LANG->line('curl_not_installed'));
		}
		// CURL Data to institution
		$curl = curl_init($post_url);
		if ($header)
		{
			curl_setopt($curl, CURLOPT_HEADER, 1); 					
			curl_setopt($curl, CURLOPT_HTTPHEADER, Array($header));
		}
		else
		{
			curl_setopt($curl, CURLOPT_HEADER, 0); 						// set to 0 to eliminate header info from response
			
		}
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 				// Returns response data instead of TRUE(1)
		if ($data)
		{
			if ($mode=="POST")
			{
				curl_setopt($curl, CURLOPT_POST,1);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 				// use HTTP POST to send form data
			}
			else
			{
				// check for query  string
				if (strrpos($post_url, "?") === FALSE)
				{
					curl_setopt($curl, CURLOPT_URL, $post_url."?".$data); 
				}
				else
				{
					curl_setopt($curl, CURLOPT_URL, $post_url.$data); 
				}
				curl_setopt($curl, CURLOPT_HTTPGET, 1); 
			}
		}
		else
		{
			// if there's no data passed in, then it's a GET
			curl_setopt($curl, CURLOPT_HTTPGET, 1); 
		}
		// curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
		// Turn off the server and peer verification (PayPal TrustManager Concept).
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

		$response = curl_exec($curl); 								// execute post and get results

		if ( ! $response)
		{
			$error = curl_error($curl).'('.curl_errno($curl).')';
		}

		curl_close($curl);
		
		if ($suppress_errors || empty($error))
		{
			return $response; 
		}
		else	
		{
			return $OUT->show_user_error('general', $error);
		}
		
		// return ($response) ? $response : $OUT->show_user_error('general', $error);	
	}
	/**
	 * customer_info
	 *
	 * returns customer data 
	 *
	 * @see http://cartthrob.com/docs/plugins/cartthrob/customer_info/
	 * @access public
	 * @return string
	 * @author Rob Sanchez
	 * @since 1.0.0
	 */
	function customer_info()
	{
		global $TMPL, $FNS;

		$saved_customer_info = $this->_get_customer_info(TRUE);

		$tagdata = $TMPL->tagdata;

		$cond = array();

		foreach ($this->customer_fields as $field)
		{
			$value = (isset($saved_customer_info['customer_'.$field])) ? $saved_customer_info['customer_'.$field] : '';

			$cond[$field] = ( ! empty($saved_customer_info['customer_'.$field]));

			$tagdata = $TMPL->swap_var_single('customer_'.$field, $value, $tagdata);
		}
		
		foreach ($this->_get_customer_custom_data() as $key => $value)
		{
			$cond['custom_data:'.$key] = (bool) $value;
			
			$tagdata = $TMPL->swap_var_single('custom_data:'.$key, $value, $tagdata);
		}
		
		$tagdata = $FNS->prep_conditionals($tagdata, $cond);

		return $tagdata;
	}
	/**
	 * data_array_to_string
	 *
	 * converts an array to a URLencoded string. This is useful for passing data via curl, or url
	 * 
	 * @access public
	 * @param array $post_array array of data to be converted
	 * @return string
	 * @author Chris Newton
	 * @since 1.0.0
	**/
	function data_array_to_string($post_array)
	{
		if (function_exists('http_build_query'))
		{
			return http_build_query($post_array,'', '&');
		}

		$data='';
		while (list ($key, $val) = each($post_array)) 
		{
			$data .= $key . "=" . urlencode(stripslashes(str_replace("\n", "\r\n", $val))) . "&";
		}
		if ($data !="")
		{
			$data = substr($data,0,-1);
		}
		return $data;

	}
	// END

	// --------------------------------
	//  Debug Info
	// --------------------------------
	/**
	 * debug_info
	 * Outputs all data related to CartThrob
	 *
	 * @access public
	 * @since 1.0.0
	 * @return string
	 * @author Rob Sanchez
	 */
	function debug_info()
	{
		global $TMPL; 
		
		$this->_session_start();
		
		$output = '<pre>'.print_r($_SESSION['cartthrob'], TRUE).'</pre>';

		if ($TMPL->fetch_param('view_all') && $this->_bool_string($TMPL->fetch_param('view_all')))
		{
			$output .= '<pre>'.print_r($this->settings, TRUE).'</pre>';
		}

		return $output;
	}
	// END
	/**
	 * decrypt
	 * 
	 * Encrypts and returns a string. 
	 * @see Encrypt Class encode
	 * @access public
	 * @param string $string | $TMPL->fetch_param('string') the data to be decrypted
	 * @param string $key | $TMPL->fetch_param('key') the key used to encrypt the data
	 * @return string decrypted string
	 * @author Chris Newton
	 * @since 1.0.0
	 **/
	function decrypt($string="", $key="")
	{
		global $TMPL; 
		$enc = new Encrypt; 
		if (!is_object($TMPL))
		{
			return $enc->decode(base64_decode(rawurldecode($string)), $key); 
		}
		if (!$string && $TMPL->fetch_param('string'))
		{
			$string = $TMPL->fetch_param('string'); 
		}
		if (!$key && $TMPL->fetch_param('key'))
		{
			$key = $TMPL->fetch_param('key'); 
		}
		return $enc->decode(base64_decode(rawurldecode($string)), $key); 
	}
	// END
	/**
	 * Deletes an item from cart
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('entry_id')
	 * @param int $_POST['entry_id']
	 * @param string $TMPL->fetch_param('delete_all')
	 * @param string $_POST['delete_all']
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function delete_from_cart()
	{
		$row_id = ($this->_fetch_param('row_id') !== FALSE) ? $this->_fetch_param('row_id') : $this->_fetch_param('index');

		$this->_delete_from_cart($this->_fetch_param('entry_id'), $this->_bool_string($this->_fetch_param('delete_all'), TRUE), $row_id);

		$this->_redirect($this->_get_redirect_url());
	}

	function delete_from_cart_form()
	{
		global $TMPL, $FNS, $SESS;

		$this->_session_start();

		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}

		$data = $this->_form_declaration_data('_delete_from_cart_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'entry_id':
					case 'row_id':
						$data['hidden_fields'][$key] = $value;
						break;
					case 'delete_all':
						$data['hidden_fields'][$key] = (int) $this->_bool_param($key);
						break;
					case 'redirect':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		return $tagdata;
	}
	/**
	 * download_file
	 *
	 * This uses curl for URLs, or fopen for paths to download files. 
	 * 
	 * @param string $TMPL->fetch_param('file')
	 * @param string $TMPL->fetch_param('return')
	 * @access public
	 * @return void
	 * @since 1.0
	 * @param 
	 * @author Chris Newton
	 **/
	function download_file()
	{
		global $TMPL, $OUT, $LANG, $SESS; 

		if ($TMPL->fetch_param('member_id') !== FALSE)
		{
			if ($TMPL->fetch_param('member_id') == "")
			{
				return $OUT->show_user_error('general', $LANG->line('download_file_not_authorized'));
				exit;
			}
			
			
			if ($this->_bool_string($TMPL->fetch_param('encrypted'))==TRUE)
			{
				if ($this->decrypt($TMPL->fetch_param('member_id')) != $SESS->userdata['member_id'])
				{
					return $OUT->show_user_error('general', $LANG->line('download_file_not_authorized'));
					exit;
				}
			}
			else 
			{
				if ($TMPL->fetch_param('member_id') != $SESS->userdata['member_id'])
				{
					return $OUT->show_user_error('general', $LANG->line('download_file_not_authorized'));
					exit;
				}
			}
		}
		if (!$TMPL->fetch_param('file'))
		{
			return $OUT->show_user_error('general', $LANG->line('download_url_not_specified'));
		}
		else
		{
			$post_url = $TMPL->fetch_param('file');
		}
		if ($this->_bool_string($TMPL->fetch_param('encrypted'))==TRUE)
		{
			$post_url = $this->decrypt($post_url);
		}
		$post_url = $this->_parse_path(($post_url));
		if (substr($post_url,-1)=="/")
		{
			$post_url=substr($post_url,0,-1);
		}

		$filename = basename($post_url);

		if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
		{
			$filename = preg_replace('/\./', '%2e', $filename, substr_count($filename, '.') - 1); 
		}
		switch(strtolower(substr(strrchr($filename, "."), 1)))
		{ 
			// Movies
			case "avi":
				$content_type = "video/x-msvideo";
				break; 
			case "mov":
				$content_type = "video/quicktime";
				break;
			case "mpg":
			case "mpeg":
				$content_type = "video/mpeg";
				break;
			case "wmv":
				$content_type = "video/x-ms-wmv";
				break;

			// Documents
			case "doc":
				$content_type = "application/msword"; 
				break;
			case "pdf":
				$content_type = "application/pdf";
				break;
			case "txt":
				$content_type = "text/plain";
				break;
			case "xls":
				$content_type = "application/excel"; 
				break;
			case "ppt":
				$content_type = "application/powerpoint";
				break; 

			// Images
			case "jpg":
			case "jpeg":
				$content_type="image/jpeg";
				break;
			case "psd":
				$content_type = "application/octet-stream";
				break;

			// Audio
			case "m4a":
			case "mp3":
				$content_type = "audio/mpeg";
				break;
			case "wav":
				$content_type = "audio/wav";
				break;

			// Compressed
			case "rar":
				$content_type = "application/x-rar-commpressed";
				break;
			case "zip":
				$content_type = "application/x-zip-compressed";
				break;
			case "7z":
				$content_type = "application/x-7z-compressed"; 
				break;

			// Other
			default: 
				$content_type = "application/force-download"; 
		}

		if (stristr($post_url, 'http://'))
		{
			$data = $this->curl_transaction($post_url); 
			if ($data)
			{
				header("Accept-Ranges: bytes"); 
				header("Expires: 0"); 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
				header("Cache-Control: public", FALSE); 
				header("Content-Description: File Transfer"); 
				header("Content-Disposition: attachment; filename=\"" . $filename . "\";"); 
				header("Content-Transfer-Encoding: binary"); 
				header("Content-Type: " . $content_type); 
				header("Pragma: public"); 
				print($data);
				exit;

			}
			else
			{
				return $OUT->show_user_error('general', $LANG->line('download_file_read_error'));
			}
		}
		else
		{
			if (file_exists($post_url)) 
			{
				header("Accept-Ranges: bytes"); 
				header("Expires: 0"); 
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
				header("Cache-Control: public", FALSE); 
				header("Content-Description: File Transfer"); 
				header("Content-Disposition: attachment; filename=\"" . $filename . "\";"); 
				header("Content-Transfer-Encoding: binary"); 
				header("Content-Type: " . $content_type); 
				header("Pragma: public"); 

				@ob_clean();
				@flush();
				// vs. 315 added @ to suppress PHP errors which were outputting file path as part of error message.
				if (@readfile($post_url) === FALSE)
				{
				}	
				else
				{
					return $OUT->show_user_error('general', $LANG->line('download_file_read_error'));
				}
				exit;
			}
			else
			{
				return $OUT->show_user_error('general', $LANG->line('download_file_read_error'));
			}
		}
	}
	// END

	/**
	 * Duplicates an item in cart
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('entry_id')
	 * @param int $_POST['entry_id']
	 * @param string $_POST['index']
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function duplicate_item()
	{
		global $IN, $TMPL, $FNS;

		$entry_id = $this->_fetch_param('entry_id');

		$row_id = ($this->_fetch_param('row_id') !== FALSE) ? $this->_fetch_param('row_id') : $this->_fetch_param('index');

		$this->_duplicate_item($entry_id, $row_id);

		$this->_redirect($this->_get_redirect_url());
	}
	/**
	 * encrypt
	 * 
	 * Encrypts and returns a string. 
	 * @see Encrypt Class encode
	 * @access public
	 * @param string $string | $TMPL->fetch_param('string') the data to be encrypted
	 * @param string $key | $TMPL->fetch_param('key') the text string key that will be used to encrypt the data
	 * @return string encrypted string
	 * @author Chris Newton
	 * @since 1.0.0
	 **/
	function encrypt($string="", $key="")
	{
		global $TMPL; 
		$enc= new Encrypt; 
		if (!$string && $TMPL->fetch_param('string'))
		{
			$string = $TMPL->fetch_param('string'); 
		}
		if (!$key && $TMPL->fetch_param('key'))
		{
			$key = $TMPL->fetch_param('key'); 
		}
		return rawurlencode(base64_encode($enc->encode($string, $key))); 
	}
	
	// --------------------------------
	//  HTTPS REDIRECT
	// --------------------------------
	/**
	 * Forces redirect to the secure version of this page
	 *
	 * @access public
	 * @param $TMPL->fetch_param('domain')
	 * @param $TMPL->fetch_param('insecure_includes') 
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez, Chris Newton
	 */
	function https_redirect()
	{
		global $TMPL;

		$this->_force_https($TMPL->fetch_param('domain'));
		if (! $TMPL->fetch_param('insecure_includes') || $this->_bool_param($TMPL->fetch_param('insecure_includes'))==TRUE)
		{
			// @TODO is this function written the way it should. Seems like 
			// maybe the parameter should be allow_insecure_includes 
			global $PREFS; 
			$PREFS->core_ini['site_url'] = str_replace("http://", "https://", $PREFS->core_ini['site_url']);
		}
		
		return $TMPL->tagdata;
	}

	// END

	
	/**
	 * get_card_type
	 *
	 * @access public
	 * @param string $ccn | $TMPL->fetch_param('credit_card_number')
	 * @return string credit card type, ex. Amex, Visa, Mc, Discover
	 * @author Chris Newton
	 * @since 1.0.0
	 */
	function get_card_type($ccn=NULL)
	{
		global $TMPL;
		if ($TMPL->fetch_param('credit_card_number'))
		{
			$ccn =$TMPL->fetch_param('credit_card_number');
		}
		return $this->_get_card_type($ccn);
	}
	// END
	/**
	 * Displays the Cartthrob logo and link back to the Cartthrob site
	 *
	 * @access public
	 * @param string class. CSS class. if no class is passed in, a default css style will be used.
	 * @return string
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function get_cartthrob_logo()
	{
		global $LANG;

		return '<a href="javascript:window.open(\'http://www.cartthrob.com\',\'cartthrob\');" title="'.$LANG->line('powered_by_title').'"><img src="http://cartthrob.com/images/powered_by_logos/powered_by_cartthrob.png" alt="'.$LANG->line('powered_by_title').'" /></a> ';
	}
	// END

	/**
	 * Returns string of entry_id's separated by | for use in weblog:entries
	 *
	 * @access public
	 * @param $IN->GBL('price_min')
	 * @param $IN->GBL('price_max')
	 * @return string
	 */
	function get_items_in_range()
	{
		global $TMPL, $IN, $REGX;

		$price_min = ($TMPL->fetch_param('price_min') !== FALSE) ? $TMPL->fetch_param('price_min') : $IN->GBL('price_min');

		$price_max = ($TMPL->fetch_param('price_max') !== FALSE) ? $TMPL->fetch_param('price_max') : $IN->GBL('price_max');

		$price_min = $REGX->xss_clean($price_min);

		$price_max = $REGX->xss_clean($price_max);

		if ( ! is_numeric($price_min))
		{
			$price_min = '';
		}
		if ( ! is_numeric($price_max))
		{
			$price_max = '';
		}

		if ($price_min == '' && $price_max == '')
		{
			return '';
		}

		$entry_ids = $this->_products_in_price_range($price_min, $price_max);

		if (count($entry_ids))
		{
			return implode('|', $entry_ids);
		}
		else
		{
			//hack to trigger no_results
			return 'X';
		}
	}

	/**
	 * Returns the options from the selected shipping plugin
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function get_shipping_options()
	{
		$this->_load_shipping_plugin();

		if (is_object($this->SHP) && $this->_method_exists($this->SHP, 'plugin_shipping_options'))
		{
			return $this->SHP->plugin_shipping_options();
		}
		else
		{
			return '';
		}
	}

	/**
	 * Returns a conditional whether item has been purchased
	 *
	 * @access public
	 * @param string $TMPL->fetch_param('entry_id')
	 * @return string (int)
	 * @since 1.0.0
	 * @author Rob Sanchez, Chris Newton
	 */
	function is_purchased_item()
	{
		global $TMPL; 
		
		$entry_id = $TMPL->fetch_param('entry_id');
		
		$tagdata = $TMPL->tagdata; 
		
		$tagdata = ($this->_has_purchased($entry_id) ? 1 : 0); 
		
		return $tagdata; 
	}
	// END
	
	/**
	 * Returns a conditional whether item is in cart
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('entry_id')
	 * @return string (int)
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function is_in_cart()
	{
		global $TMPL, $FNS;

		$entry_id = $TMPL->fetch_param('entry_id');

		//param item_id is deprecated, this is for backwards compatability
		if ($entry_id === FALSE)
		{
			$entry_id = $TMPL->fetch_param('item_id');
		}

		$tagdata = $TMPL->tagdata;

		if ($tagdata)
		{
			$cond = array(
				'item_in_cart'=>($this->_item_in_cart($entry_id, FALSE, FALSE, FALSE) !== FALSE)
			);
			
			$cond['is_in_cart'] = $cond['item_in_cart'];

			$tagdata = $FNS->prep_conditionals($tagdata, $cond);
		}
		else
		{
			$tagdata = ($this->_item_in_cart($entry_id, FALSE, FALSE, FALSE) !== FALSE) ? 1 : 0;
		}

		return $tagdata;
	}
	// END

	/**
	 * For use in a conditional, returns whether or not customer_info has been saved
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function is_saved()
	{
		foreach ($this->_get_customer_info() as $key => $value)
		{
			if ( ! empty($value))
			{
				return '1';
			}
		}
		
		return '0';
	}
	
	function jquery_plugin()
	{
		return $this->_jquery_plugin();
	}
	
	function jquery_plugin_src()
	{
		global $FNS;
		return $FNS->fetch_site_index(1).'?ACT='.$FNS->fetch_action_id('Cartthrob', '_jquery_plugin_action');
	}
	
	function multi_add_to_cart_form()
	{
		global $TMPL, $FNS, $SESS;

		$this->_session_start();

		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}
		
		$data = $this->_form_declaration_data('_multi_add_to_cart_form_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'language':
						$data['hidden_fields'][$key] = $value;
						break;
					case 'allow_user_price':
						$data['hidden_fields']['AUP'] = $this->_encode_bool($this->_bool_param('allow_user_price'));
						break;
					case 'allow_user_shipping':
						$data['hidden_fields']['AUS'] = $this->_encode_bool($this->_bool_param('allow_user_shipping'));
						break;
					case 'allow_user_weight':
						$data['hidden_fields']['AUW'] = $this->_encode_bool($this->_bool_param('allow_user_weight'));
						break;
					case 'show_errors':
						$data['hidden_fields']['ERR'] = $this->_encode_bool($this->_bool_param('show_errors'));
						break;
					case 'on_the_fly':
						$data['hidden_fields']['OTF'] = $this->_encode_bool($this->_bool_param('on_the_fly'));
						break;
					case 'json':
						$data['hidden_fields']['JSN'] = $this->_encode_bool($this->_bool_param('json'));
						break;
					case 'redirect':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		if ($TMPL->fetch_param('language'))
		{
			$this->_set_language($TMPL->fetch_param('language'));
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		$tagdata = $this->_parse_item_option_inputs($tagdata, NULL, NULL, TRUE);

		return $tagdata;
	}
	
	
	function new_cart()
	{
		$this->_new_cart();

		$this->_redirect($this->_get_redirect_url());
	}
	
	function order_totals()
	{
		global $DB, $TMPL;
		
		$data = array(
			'total' => 0,
			'subtotal' => 0,
			'tax' => 0,
			'shipping' => 0,
			'discount' => 0
		);
		
		$count = 0;
		
		if ( ! empty($this->settings['orders_weblog']))
		{
			if ( ! class_exists('Weblog'))
			{
				require_once(PATH_MOD.'weblog/mod.weblog'.EXT);
			}
			
			$channel = new Weblog();
			
			$tagdata = $TMPL->tagdata;
			
			//$TMPL->tagparams['weblog'] = $this->_get_weblog_name($this->settings['orders_weblog']);
			
			$TMPL->tagparams['weblog_id'] = $this->settings['orders_weblog'];
			
			$TMPL->tagparams['disable'] = 'categories|custom_fields|member_data|pagination|trackbacks';
			
			$channel->entries();
			
			if ($channel->query)
			{
				$count = $channel->query->num_rows;
				
				foreach ($channel->query->result as $row)
				{
					if ( ! empty($this->settings['orders_total_field']) && isset($row['field_id_'.$this->settings['orders_total_field']]))
					{
						$data['total'] += $this->_sanitize_number($row['field_id_'.$this->settings['orders_total_field']]);
					}
					
					if ( ! empty($this->settings['orders_subtotal_field']) && isset($row['field_id_'.$this->settings['orders_subtotal_field']]))
					{
						$data['subtotal'] += $this->_sanitize_number($row['field_id_'.$this->settings['orders_subtotal_field']]);
					}
					
					if ( ! empty($this->settings['orders_tax_field']) && isset($row['field_id_'.$this->settings['orders_tax_field']]))
					{
						$data['tax'] += $this->_sanitize_number($row['field_id_'.$this->settings['orders_tax_field']]);
					}
					
					if ( ! empty($this->settings['orders_shipping_field']) && isset($row['field_id_'.$this->settings['orders_shipping_field']]))
					{
						$data['shipping'] += $this->_sanitize_number($row['field_id_'.$this->settings['orders_shipping_field']]);
					}
					
					if ( ! empty($this->settings['orders_discount_field']) && isset($row['field_id_'.$this->settings['orders_discount_field']]))
					{
						$data['discount'] += $this->_sanitize_number($row['field_id_'.$this->settings['orders_discount_field']]);
					}
				}
			}
		}
		
		if ($tagdata)
		{
			foreach ($data as $key => $value)
			{
				$tagdata = $TMPL->swap_var_single($key, $this->view_formatted_number($value), $tagdata);
			}
			
			$tagdata = $TMPL->swap_var_single('count', $count, $tagdata);
			
			return $tagdata;
		}
		else
		{
			return $this->view_formatted_number($data['total']);
		}
	}

	/**
	 * payment_return
	 *
	 * handles information from PayPal's IPN, offsite gateways, or other payment notification systems. 
	 * @param string $gateway the payment gateway class/file that should called
	 * @param string $method the method in the gateway class that should handle the transaction
	 * @return void
	 * @author Chris Newton
	 * @since 1.0
	 * @access public
	 */
	function payment_return($gateway=NULL, $method=NULL)
	{
		global $IN, $REGX, $FNS, $TMPL, $PREFS, $DB, $LANG;
		
		$this->log("payment return activated");
		
		/*
		if ($IN->GBL('gateway', 'GET'))
		{
			$gateway =  $IN->GBL('gateway', 'GET');
		}
		*/
		if ($this->settings['encode_gateway_selection'])
		{
			$gateway = $this->_xss_clean($this->_decode_string(str_replace(' ', '+', urldecode($IN->GBL('gateway', 'GET')))));
		}
		else
		{
			//remove in ct2
			$gateway = $this->_xss_clean(urldecode($IN->GBL('gateway', 'GET')));
		}
		
		// When offsite payments are returned, they're expected to have a method
		// set to handle processing the payments. 	
		if ($IN->GBL('method', 'GET'))
		{
			$method = urldecode($IN->GBL('method', 'GET'));
		}
		
		$cleaned_post = array(); 

		$this->_load_payment_gateway($gateway);

		$auth = array(
			'authorized' 	=> FALSE,
			'error_message'	=> NULL,
			'failed'		=> TRUE,
			'declined'		=> FALSE,
			'transaction_id'=> NULL, 
			);
			
		if ($method && $this->_method_exists($this->PG, $method))
		{
			foreach($_POST as $key => $value)
			{
				$cleaned_post[$key] = $REGX->xss_clean($value);
			}
			
			// handling get variables.
			if ($_SERVER['QUERY_STRING'])
			{
				// the following was added to convert the query string manually into an array
				// because something like &company=abercrombie&fitch&name=joe+jones was causing the return
				// data to get hosed. Stupid PayPal. You suck. URLencode your goddamned querystrings in your
				// IPN notifications. Fucking bastards. 
				$query = $_SERVER['QUERY_STRING']; 
				$query = '&'.ltrim($query, '&');
				$parts = explode('=', $query);
				
				foreach($parts as $i => $part) 
				{
				    if($i == 0) continue;
				    $key = substr($parts[$i - 1], strrpos($parts[$i - 1], '&') + 1);
				    $value = strpos($part, '&') !== false ? substr($part, 0, strrpos($part, '&')) : $part;
				    
					if (!isset($cleaned_post[$key]))
					{
						$cleaned_post[$key] = $REGX->xss_clean($value);
					}
				}
			}
			
			foreach ($cleaned_post as $key=> $item)
			{
				$this->log($key ." - ". $item);
			}
			$auth = $this->PG->$method($cleaned_post);
		}
		else
		{
			$auth['error_message']	= $LANG->line('gateway_function_does_not_exist');
		}
		$this->_checkout_complete($auth);
	}
	// END

	function process()
	{
		return $this->order_info();
	}
	
	/**
	 * request_shipping_quote_form
	 * Outputs a quote request form
	 * 
	 * @since 1.0
	 * @param $TMPL->shipping_plugin
	 * @return string
	 * @author Chris Newton
	 **/
	function request_shipping_quote_form()
	{
		global $TMPL, $FNS;

		$this->_session_start();

		$data = $this->_form_declaration_data('_request_shipping_quote_form_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'required':
						$data['hidden_fields']['REQ'] = $this->_encode_string($value);
						break;
					case 'redirect':
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'country_code':
						$data['hidden_fields']['derive_country_code'] = $value;
						break;
					case 'shipping_plugin': 
						$data['hidden_fields']['shipping_plugin'] = $value;
						break;
					case 'shipping_mode':
						$data['hidden_fields']['shipping[mode]'] = $value; 
						break;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}

		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		$tagdata .= $TMPL->tagdata;

		$customer_info = $this->_get_customer_info();

		foreach ($this->customer_fields as $field)
		{
			$tagdata = $TMPL->swap_var_single($field, (isset($customer_info[$field]) ? $customer_info[$field] : ''), $tagdata);
			$tagdata = $TMPL->swap_var_single('customer_'.$field, (isset($customer_info[$field]) ? $customer_info[$field] : ''), $tagdata);
		}
		$tagdata = $TMPL->swap_var_single('shipping_fields', $this->selected_shipping_fields(), $tagdata);
		
		$tagdata .= '</form>';

		return $tagdata;
	}

	/**
	 * Stores customer info in SESSION, for use on multi-page checkout
	 *
	 * @access public
	 * @param $TMPL->fetch_param('required');
	 * @param $TMPL->fetch_param('save_shipping')
	 * @param $TMPL->fetch_param('return')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function save_customer_info($redirect = TRUE)
	{
		global $TMPL, $OUT, $FNS, $IN, $REGX;

		$this->_session_start();

		$required = $this->_fetch_param('required');

		$save_shipping = $this->_bool_param('save_shipping', TRUE);

		if ($required == 'all')
		{
			$required = $this->customer_fields;
			if ($save_shipping)
			{
				$required[] = 'shipping_option';
			}
		}
		elseif (preg_match('/^not\s/', $required))
		{
			$not_required = substr($required, 4);
			$not_required = explode('|', $not_required);
			$required = $this->customer_fields;
			if ($save_shipping)
			{
				$required[] = 'shipping_option';
			}
			foreach ($required as $key=>$value)
			{
				if (in_array($value, $not_required))
				{
					unset($required[$key]);
				}
			}
		}
		elseif ($required)
		{
			$required = explode('|', $required);
		}

		if ( ! $required)
		{
			$required = array();
		}

		$validated = $this->_validate_required($required);

		if ($validated)
		{
			$customer_info = array();

			foreach ($this->customer_fields as $field)
			{
				$customer_info[$field] = $this->_fetch_param($field);
			}

			if ($save_shipping)
			{
				$this->_save_shipping_option();
			}

			foreach ($customer_info as $key=>$value)
			{
				if (isset($_POST[$key]) || $value !== FALSE)
				{
					$_SESSION['cartthrob']['customer_info'][$key] = $REGX->xss_clean($value);
				}
			}
		}

		if ($redirect)
		{
			$this->_redirect($this->_get_redirect_url());
		}
	}

	function save_customer_info_form()
	{
		global $TMPL, $FNS, $SESS;

		$this->_session_start();

		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}
		
		$data = $this->_form_declaration_data('_save_customer_info_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'required':
						$data['hidden_fields']['REQ'] = $this->_encode_string($value);
						break;
					case 'redirect':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'country_code':
						$data['hidden_fields']['derive_country_code'] = $value;
						break;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}
		
		$tagdata .= $TMPL->tagdata;

		$customer_info = $this->_get_customer_info();

		foreach ($this->customer_fields as $field)
		{
			$tagdata = $TMPL->swap_var_single($field, (isset($customer_info[$field]) ? $customer_info[$field] : ''), $tagdata);
			$tagdata = $TMPL->swap_var_single('customer_'.$field, (isset($customer_info[$field]) ? $customer_info[$field] : ''), $tagdata);
		}
		
		foreach ($this->_get_customer_custom_data() as $key => $value)
		{
			$tagdata = $TMPL->swap_var_single('custom_data:'.$key, $value, $tagdata);
		}

		$tagdata .= '</form>';

		return $tagdata;
	}

	/**
	 * Saves chosen shipping option to SESSION
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function save_shipping_option()
	{
		global $IN, $TMPL, $FNS;

		$this->_save_shipping_option();

		$this->_redirect($this->_get_redirect_url());

		return $this->cart_shipping();
	}
	/**
	 * selected_gateway_fields
	 *
	 * returns data from the 'html' field of the currently selected gateway
	 * 
	 * @param bool $gateway 
	 * @return string
	 * @since 1.0
	 * @author Chris Newton
	 */
	function selected_gateway_fields($gateway = FALSE)
	{
		global $DB, $TMPL;

		if ( ! $gateway && ! ($gateway = $TMPL->fetch_param('gateway')) && ! ($gateway = $this->settings['payment_gateway']))
		{
			return '';
		}

		if ( ! empty($this->settings[$this->_get_plugin_classname($gateway).'_settings']['gateway_fields_template']))
		{
			return '{embed="'.$this->settings[$this->_get_plugin_classname($gateway).'_settings']['gateway_fields_template'].'"}';
		}

		$this->_load_payment_gateway($this->_get_plugin_classname($gateway));

		return (isset($this->PG->gateway_info['html'])) ? $this->PG->gateway_info['html'] : '';
	}
	// END
	
	/**
	 * selected_shipping_fields
	 *
	 * returns data from the 'html' field of the currently selected shipping plugin
	 * 
	 * @param bool $plugin 
	 * @return string
	 * @since 1.0
	 * @author Chris Newton
	 */
	function selected_shipping_fields($plugin = FALSE)
	{
		global $DB, $TMPL;

		if ( ! $plugin && ! ($plugin = $TMPL->fetch_param('shipping_plugin')) && ! ($plugin = $this->settings['shipping_plugin']))
		{
			return '';
		}

		/*
		if ( ! empty($this->settings[$this->_get_plugin_classname($plugin).'_settings']['shipping_fields_template']))
		{
			return '{embed="'.$this->settings[$this->_get_plugin_classname($plugin).'_settings']['shipping_fields_template'].'"}';
		}
		*/

		$this->_load_shipping_plugin($this->_get_plugin_classname($plugin));

		return (isset($this->SHP->plugin_info['html'])) ? $this->SHP->plugin_info['html'] : '';
	}
	// END

	/**
	 * selected_shipping_option
	 *
	 * outputs the description of the shipping item selected in the backend
	 * 
	 * @return string
	 * @author Rob Sanchez
	 * @since 1.0
	 */
	function selected_shipping_option()
	{
		return $this->_get_shipping_option();

	}
	// END
	//shipping_plugin
	//for front-end, condtional based configuration
	function set_config()
	{
		global $TMPL, $FNS;
		
		//$TMPL->tagdata = str_replace(LD.'&#47;if'.RD, LD.'/if'.RD, $TMPL->tagdata);
		
		$TMPL->tagdata = str_replace('&#47;', '/', $TMPL->tagdata);
		
		$TMPL->tagdata = $FNS->prep_conditionals($TMPL->tagdata, array_merge($this->_get_customer_info(TRUE, TRUE, TRUE)));
		
		$TMPL->tagdata = $TMPL->advanced_conditionals($TMPL->tagdata);
		
		$TMPL->tagdata = str_replace('/', '&#47;', $TMPL->tagdata);
		
		$vars = $FNS->assign_variables($TMPL->tagdata);
		
		foreach ($vars['var_single'] as $var_single)
		{
			$params = $FNS->assign_parameters($var_single);
			
			$method = (preg_match('/(set_)?([^\s]+)\s*.*/', $var_single, $match)) ? $match[2] : FALSE;
			
			if ($method && method_exists($this, '_set_config_'.$method))
			{
				call_user_func(array($this, '_set_config_'.$method), $params);
			}
			else
			{
				$this->_set_config($method, $params);
			}
		}
	}
	
	/**
	 * shipping_quote_request_info
	 *
	 * @return string
	 * @since 1.0
	 * @author Chris Newton
	 **/
	function shipping_quote_info()
	{
		global $TMPL, $FNS;

		$this->_session_start();

		$shipping = @$_SESSION['cartthrob']['shipping'];

		$tagdata = $TMPL->tagdata; 

		$data = array(
			'price'				=> (isset($shipping['price'])) ? $this->view_formatted_number($shipping['price']) : '',
			'error_message'		=> (isset($shipping['error_message'])) ? $shipping['error_message'] : '',
			'quoting_available'	=> (isset($shipping['quoting_available'])) ? $shipping['quoting_available'] : '',
			'failed'			=> (isset($shipping['failed'])) ? $shipping['failed'] : '',
			'shipping_option' 	=> (isset($shipping['shipping_option'])) ? $shipping['shipping_option'] : '',
			'shipping_methods'	=> (isset($shipping['shipping_methods'])) ? $shipping['shipping_methods'] : array(),
			);
		$tagdata = $FNS->prep_conditionals($tagdata, $data);

		$tagdata = $TMPL->swap_var_single('price', @$data['price'], $tagdata);

		$tagdata = $TMPL->swap_var_single('error_message', @$data['error_message'], $tagdata);

		$tagdata = $TMPL->swap_var_single('quoting_available', @$data['quoting_available'], $tagdata);

		$tagdata = $TMPL->swap_var_single('failed', @$data['failed'], $tagdata);

		$tagdata = $TMPL->swap_var_single('shipping_option', @$data['shipping_option'], $tagdata);

		if (preg_match_all('/'.LD.'shipping_methods'.RD.'(.*?)'.LD.SLASH.'shipping_methods'.RD.'/s', $tagdata, $matches))
		{
			$total_results = 0; 
			if (!empty($data['shipping_methods']['option_values']))
			{
				$total_results = count($data['shipping_methods']['option_values']);
				
			}

			for ($i = 0; $i < count($matches[0]); $i++)
			{
				$match = array($matches[0][$i], $matches[1][$i]);

				$count = 1;

				if ( ! $total_results && preg_match('/'.LD.'if item:no_results'.RD.'(.*?)'.LD.SLASH.'if'.RD.'/s', $match[1], $no_results))
				{
					$tagdata = str_replace($match[0], $no_results[1], $tagdata);

					continue;
				}

				$output = '';

				if (!empty($data['shipping_methods']['option_values']))
				{
					foreach ($data['shipping_methods']['option_values'] as $key => $option_values)
					{	

						$item['option_value'] 	 = $option_values; 
						$item['option_price'] 	 = $data['shipping_methods']['option_prices'][$key]; 
						$item['option_title'] 	 = $data['shipping_methods']['option_titles'][$key]; 
						$item['count']			 = $count;
						$item['total_results'] 	 = $total_results;

						$subtagdata = $match[1];

						if (preg_match_all('/'.LD.'item:switch=["\'](.+)["\']'.RD.'/', $subtagdata, $switch_matches))
						{
							foreach ($switch_matches[0] as $i => $v)
							{
								$switch_values = explode('|', $switch_matches[1][$i]);

								$subtagdata = str_replace($switch_matches[0][$i], $switch_values[($count + count($switch_values) - 1) % count($switch_values)], $subtagdata);
							}
						}

						$cond = array();

						foreach ($item as $key => $value)
						{
							unset($item[$key]);

							$new_key = 'item:'.$key;

							$item[$new_key] = $value;
							$cond[$new_key] = (bool) $value;
							$subtagdata = $TMPL->swap_var_single($new_key, $value, $subtagdata);						

						}

						$cond['item:first_item'] = ($count == 1);

						$cond['item:last_item'] = ($count == $total_results);

						$subtagdata = $FNS->prep_conditionals($subtagdata, $cond);

						$count++;

						$output .= $subtagdata;
					}
				}


				$tagdata = str_replace($match[0], $output, $tagdata);
			}
		}
		if (( ! $shipping || ! is_array($shipping)))
		{
			return '';
		}

		return $tagdata;
	}
	// END
	
		
	/**
	 * split_url_string
	 *
	 * converts a urlencoded string into an array. 
	 *  
	 * @access public
	 * @param string $url_string URLencoded string to split
	 * @return array
	 * @author Chris Newton
	 * @since 1.0.0
	 * @author Rob Sanchez
	 **/
	function split_url_string($url_string, $split_character = "&")
	{
		$array = explode($split_character, $url_string);
		$i = 0;
		while ($i < count($array)) {
			$b = split('=', $array[$i]);
			if ( ! isset($b[1]))
			{
				$b[1] = '';
			}
			$no_space_key=rtrim(htmlspecialchars(urldecode($b[0])));
			$new_array[$no_space_key] = htmlspecialchars(urldecode($b[1]));
			$i++;
		}
		return $new_array;
	}
	/**
	 * states
	 *
	 * swaps abbrev, and state from list in templates 
	 * @param $TMPL country_code 3 character country code (Default USA)
	 * @return string 
	 * @author Rob Sanchez, Chris Newton 
	 * @since 1.0
	 */
	function states()
	{
		global $TMPL;
		

		$country_code = ($TMPL->fetch_param('country_code')) ? $TMPL->fetch_param('country_code') : "USA";
		$return_data = '';
		
		if ($country_code == "USA")
		{
			$states_array = $this->states; 
		}
		else
		{
			$states_list = $country_code . "states";
			$states_array = @$this->$states_list; 
		}
		foreach ($states_array as $abbrev => $state)
		{
			$tagdata = $TMPL->tagdata;
			$tagdata = $TMPL->swap_var_single('abbrev', $abbrev, $tagdata);
			$tagdata = $TMPL->swap_var_single('state', $state, $tagdata);
			$return_data .= $tagdata;
		}
		
		return $return_data;
	}
	
	function state_select()
	{
		global $TMPL;
		
		$name = $TMPL->fetch_param('name');
		
		$id = ($TMPL->fetch_param('id')) ? ' id="'.$TMPL->fetch_param('id').'"' : '';
		
		$class = ($TMPL->fetch_param('class')) ? ' class="'.$TMPL->fetch_param('class').'"' : '';
		
		$extra = $TMPL->fetch_param('extra');
		
		$selected = $TMPL->fetch_param('selected');
		
		if ( ! $selected)
		{
			$selected = $TMPL->fetch_param('default');
		}
		
		if ($extra && substr($extra, 0, 1) !== ' ')
		{
			$extra = ' '.$extra;
		}
		
		$abbrev_label = $this->_bool_param('abbrev_label', FALSE);
		
		$abbrev_value = $this->_bool_param('abbrev_value', TRUE);
		
		$output = '<select name="'.$name.'"'.$id.$class.$extra.'>'."\n";
		
		$states = $this->states;
		
		if ($this->_bool_param('add_blank'))
		{
			$states = array_merge(array('' => '---'), $states);
		}
		
		foreach ($states as $abbrev => $state)
		{
			$label = ($abbrev_label) ? $abbrev : $state;
			
			$value = ($abbrev_value) ? $abbrev : $state;
			
			$selected = ($value === $TMPL->fetch_param('selected')) ? ' selected="selected"' : '';
			
			$output .= "\t".'<option value="'.$value.'"'.$selected.'>'.$label.'</option>'."\n";
		}
		
		$output .= '</select>'."\n";
		
		return $output;
	}
	
	//alias for state_select()
	function states_select()
	{
		return $this->state_select();
	}

	/**
	 * Returns information about the order that was just placed
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function submitted_order_info()
	{
		global $TMPL;

		return $this->_order_info($TMPL->tagdata, $TMPL->no_results);
	}
	// END

	// --------------------------------
	//  Total Items Count
	// --------------------------------
	/**
	 * Returns total number of ALL items (including indexes) in cart
	 * If you have 4 of product A, and 5 of product B, this would return 9. 
	 * To get total individual items, use total unique items
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function total_items_count()
	{
		$this->_session_start();

		$count = 0;

		foreach ($this->_get_items() as $item)
		{
			$count += $item['quantity'];
		}

		return $count;
	}
	// END

	// --------------------------------
	//  total_unique_items
	// --------------------------------
	/**
	 * Returns total number of unique items in cart
	 * If you have 4 of product A, and 5 of product B, this would return 2 (A, B, not the total of A and B)
	 *
	 * @access public
	 * @return string
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function unique_items_count()
	{
		$this->_session_start();
		return count($this->_get_items());
	}
	// END
	/**
	 * update_cart_form
	 * 
	 * outputs a form for updating data in the cart
	 * 
	 * @return string
	 * @access public 
	 * @param $TMPL->id
	 * @param $TMPL->name
	 * @param $TMPL->onsubmit
	 * @param $TMPL->show_errors
	 * @param $TMPL->json
	 * @param $TMPL->redirect deprecated
	 * @param $TMPL->return
	 * @param $TMPL->class
	 * @author Rob Sanchez, Chris Newton
	 * @since 1.0
	 */
	function update_cart_form()
	{
		global $TMPL, $FNS, $SESS;

		$this->_session_start();
		
		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}
		
		$data = $this->_form_declaration_data('_update_cart_submit');

		foreach ((array) $TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'allow_user_price':
						$data['hidden_fields']['AUP'] = $this->_encode_bool($this->_bool_param('allow_user_price'));
						break;
					case 'show_errors':
						$data['hidden_fields']['ERR'] = $this->_encode_bool($this->_bool_param('show_errors'));
						break;
					case 'json':
						$data['hidden_fields']['JSN'] = $this->_encode_bool($this->_bool_param('json'));
						break;
					case 'redirect':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		foreach ($TMPL->var_pair as $var_name => $var_params)
		{
			if (preg_match('/^item_options:select:/', $var_name))
			{
				$rowbool = 'row_id="TRUE"';
				if (strstr($var_name, 'row_id="true"'))
				{
					$rowbool = 'row_id="true"';
				}
				elseif (strstr($var_name, 'row_id="yes"'))
				{
					$rowbool = 'row_id="yes"';
					
				}
				elseif (strstr($var_name, 'row_id="ON"'))
				{
					$rowbool = 'row_id="ON"';
					
				}
				elseif (strstr($var_name, 'row_id="1"'))
				{
					$rowbool = 'row_id="1"';
				}
				
				$tagdata = $TMPL->swap_var_single($var_name, LD.$var_name.' '.$rowbool.RD, $tagdata);
			}
		}

		foreach ($TMPL->var_single as $var_name)
		{
			if (preg_match("/^item_options:(select|input):/", $var_name))
			{
				$rowbool = 'row_id="TRUE"';
				if (strstr($var_name, 'row_id="true"'))
				{
					$rowbool = 'row_id="true"';
				}
				elseif (strstr($var_name, 'row_id="yes"'))
				{
					$rowbool = 'row_id="yes"';
					
				}
				elseif (strstr($var_name, 'row_id="ON"'))
				{
					$rowbool = 'row_id="ON"';
					
				}
				elseif (strstr($var_name, 'row_id="1"'))
				{
					$rowbool = 'row_id="1"';
				}
				elseif (strstr($var_name, 'row_id="y"'))
				{
					$rowbool = 'row_id="y"';
				}
				$tagdata = $TMPL->swap_var_single($var_name, LD.$var_name.' '.$rowbool.RD, $tagdata);
			}
		}

		return $tagdata;
	}
	// END 

	/**
	 * Updates an item's quantity and item_options
	 *
	 * @access public
	 * @param string $TMPL->fetch_param('entry_id')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function update_item()
	{
		global $IN, $TMPL;

		$entry_id = $this->_fetch_param('entry_id');

		$row_id = ($this->_fetch_param('row_id') !== FALSE) ? $this->_fetch_param('row_id') : $this->_fetch_param('index');

		if ($row_id !== FALSE || $entry_id !== FALSE)
		{
			if ($IN->GBL('quantity', 'POST'))
			{
				$this->_change_quantity($entry_id, $this->_xss_clean($IN->GBL('quantity', 'POST')), $row_id);
			}

			$item_options = $this->_xss_clean($IN->GBL('item_options', 'POST'));

			if ($item_options && is_array($item_options))
			{
				$item = $this->_get_cart_item($entry_id, $row_id);

				foreach ($item_options as $key => $value)
				{
					$item['item_options'][$key] = $value;
				}

				$this->_session_start();

				if (isset($_SESSION['cartthrob']['items'][$row_id]))
				{
					$_SESSION['cartthrob']['items'][$row_id] = $item;
				}
			}
		}

		$this->_redirect($this->_get_redirect_url());
	}

	function update_item_form()
	{
		global $TMPL, $FNS, $SESS;

		$this->_session_start();
		if ($SESS->userdata['member_id'] == 0 && $TMPL->fetch_param('logged_out_redirect'))
		{
			$this->_redirect($TMPL->fetch_param('logged_out_redirect'));
		}
		
		$data = $this->_form_declaration_data('_update_item_submit');

		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
						$data[$key] = $value;
						break;
					case 'entry_id':
					case 'row_id':
					case 'quantity':
					case 'title':
						$data['hidden_fields'][$key] = $value;
						break;
					case 'delete':
					case 'delete_all':
						$data['hidden_fields'][$key] = $this->_bool_param($key) ? 1 : 0;
					case 'price':
						$data['hidden_fields']['PR'] = $this->_encode_string($TMPL->fetch_param('price'));
						break;
					case 'allow_user_price':
						$data['hidden_fields']['AUP'] = $this->_encode_bool($this->_bool_param('allow_user_price'));
						break;
					case 'shipping':
						$data['hidden_fields']['SHP'] = $this->_encode_string($TMPL->fetch_param('shipping'));
						break;
					case 'weight':
						$data['hidden_fields']['WGT'] = $this->_encode_string($TMPL->fetch_param('weight'));
						break;
					case 'show_errors':
						$data['hidden_fields']['ERR'] = $this->_encode_bool($this->_bool_param('show_errors'));
						break;
					case 'json':
						$data['hidden_fields']['JSN'] = $this->_encode_bool($this->_bool_param('json'));
						break;
					case 'redirect':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
					case 'return':
						$data['hidden_fields']['return'] = $this->_get_redirect_url();
						break;
				}

				if (preg_match('/item_options?:(.+)/', $key, $match))
				{
					$data['hidden_fields']['item_options['.$match[1].']'] = $value;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}
		
		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		$tagdata = $this->_parse_item_option_inputs($tagdata);

		return $tagdata;
	}

	/**
	 * Validate_coupon_code
	 *
	 * Validates coupon code and outputs error messages (if any)
	 *
	 * Totally deprecated and utterly useless.
	 * 
	 * @access public
	 * @return string Json encoded array
	 * @param string $TMPL->fetch_param('decimals') Number of decimals to display (2)
	 * @param string $TMPL->fetch_param('dec_point') Decimal point type . or , is common
	 * @param string $TMPL->fetch_param('thousands_sep') Thousands sep, . or , is common
	 * @param string $TMPL->fetch_param('prefix') ex. $
	 * @param string $TMPL->fetch_param('format') json (any other value is ignored) Whether to return data json formatted
	 * @author Rob Sanchez
	 * @since 1.0.0
	 * @see http://cartthrob.com/docs/plugins/cartthrob/validate_coupon_code
	 */
	function use_coupon()
	{
		return '';
	}
	/**
	 * fix for a previous typo
	 **/
	function view_convert_currency($number = FALSE)
	{
		return $this->view_converted_currency($number);
	}

	/**
	 * view_converted_currency
	 *
	 * @param $number bool
	 * @return string
	 * @author Chris Newton
	 * @param string $TMPL->fetch_param('price')
	 * @param string $TMPL->fetch_param('currency_code')
	 * @param string $TMPL->fetch_param('new_currency_code')
	 * @param string $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @param string $TMPL->fetch_param('new_prefix')
	 **/
	function view_converted_currency($number = FALSE)
	{
		global $TMPL, $EXT;

		// Check to see if this value is being passed in or not. 
		if ($number === FALSE)
		{
			$number = $TMPL->fetch_param('price');
		}
		if ($number === FALSE)
		{
			return '';
		}
		// clean the number
		$number = $this->_sanitize_number($number);
		
		// -------------------------------------------
		// 'cartthrob_view_converted_currency' hook.
		//
		if ($EXT->active_hook('cartthrob_view_converted_currency') === TRUE)
		{
			return $EXT->universal_call_extension('cartthrob_view_converted_currency', $number);
		}

		// set defaults
		$currency = ($TMPL->fetch_param('currency_code') !== FALSE) ? $TMPL->fetch_param('currency_code') : $this->number_format_defaults['currency_code'];
		$new_currency = ($TMPL->fetch_param('new_currency_code') !== FALSE) ? $TMPL->fetch_param('new_currency_code') : $this->number_format_defaults['currency_code'];
		$decimals = ($TMPL->fetch_param('decimals') !== FALSE) ? (int) $TMPL->fetch_param('decimals') : $this->number_format_defaults['decimals'];
		$dec_point = ($TMPL->fetch_param('dec_point') !== FALSE) ? $TMPL->fetch_param('dec_point') : $this->number_format_defaults['dec_point'];
		$thousands_sep = ($TMPL->fetch_param('thousands_sep') !== FALSE) ? $TMPL->fetch_param('thousands_sep') : $this->number_format_defaults['thousands_sep'];

		$currency = strtolower($currency);
		$new_currency = strtolower($new_currency);

		$new_prefix = $this->_bool_param('use_prefix', false); 

		$prefix = ""; 

		if ($new_prefix)
		{
			switch ($new_currency)
			{
				case "eur":
					$prefix = "&#8364;";
					break;
				case "usd":
					$prefix = "$";
					break;
				case "gbp":
					$prefix = "&#163;";
					break;
				case "aud":
					$prefix = "$";
					break;
				case "brl":
					$prefix = "R$";
					break;
				case "nzd":
					$prefix = "$";
					break;
				case "cad":
					$prefix = "$";
					break;
				case "chf":
					$prefix = "CHF";
					break;
				case "cny":
					$prefix = "&#165;";
					break;
				case "dkk":
					$prefix = "kr";
					break;
				case "hkd":
					$prefix = "$";
					break;
				case "inr":
					$prefix = "&#8360;";
					break;
				case "jpy":
					$prefix = "&#165;";
					break;
				case "krw":
					$prefix = "&#8361;";
					break;
				case "mxn":
					$prefix = "$";
					break;
				case "myr":
					$prefix = "RM";
					break;
				case "nok":
					$prefix = "kr";
					break;
				case "sek":
					$prefix = "kr";
					break;
				case "sgd":
					$prefix = "$";
					break;
				case "thb":
					$prefix = "&#3647;";
					break;
				case "zar":
					$prefix = "R";
					break;
				case "bgn":
					$prefix = "&#1083;&#1074;";
					break;
				case "czk":
					$prefix = "&#75;&#269;";
					break;
				case "eek":
					$prefix = "kr";
					break;
				case "huf":
					$prefix = "Ft";
					break;
				case "ltl":
					$prefix = "Lt";
					break;
				case "lvl":
					$prefix = "&#8364;";
					break;
				case "pln":
					$prefix = "z&#322;";
					break;
				case "ron":
					$prefix = "kr";
					break;
				case "hrk":
					$prefix = "kn";
					break;
				case "rub":
					$prefix = "&#1088;&#1091;&#1073;";
					break;
				case "try":
					$prefix = "TL";
					break;
				case "php":
					$prefix = "Php";
					break;
				case "cop":
					$prefix = "$";
					break;
				case "ars":
					$prefix = "$";
					break;
				default: $prefix = "$"; 
			}
		}
		
		require_once(PATH_MOD.'cartthrob/lib/jsonwrapper/jsonwrapper.php');
		
		if (function_exists('json_decode')) 
		{
			$api_key = ($TMPL->fetch_param('api_key')) ? '?key='.$TMPL->fetch_param('api_key') : '';

			$json = $this->curl_transaction("http://xurrency.com/api/".$currency."/".$new_currency."/".$number.$api_key,  $data=NULL, $header = NULL,$mode="POST", $suppress_errors = TRUE);

			if ($json)
			{
				$obj = json_decode($json);

				if (is_object($obj) 
					&& isset($obj->{'result'}) 
					&& isset($obj->{'status'}) 
					&& $obj->{'status'} =="ok" 
					&& isset($obj->{'result'}->{'value'})
					)
				{
					return $prefix.number_format($obj->{'result'}->{'value'}, $decimals, $dec_point, $thousands_sep);
				}
			}
		}
		return $prefix.number_format($number, $decimals, $dec_point, $thousands_sep); 
		
		
	}
	// END
	function view_download_link()
	{
		global $TMPL, $SESS, $OUT, $LANG; 

		$link = ""; 

		if ($TMPL->fetch_param('template'))
		{
			$link .=$TMPL->fetch_param('template');
		}
		if (!$TMPL->fetch_param('file'))
		{
			return $OUT->show_user_error('general', $LANG->line('download_url_not_specified'));
			exit;
		}
		else
		{
			$link .=$this->encrypt($TMPL->fetch_param('file'));
		}

		$member_id = $TMPL->fetch_param('member_id');
		if ($member_id)
		{
			if (stristr($member_id,"{logged_in_member_id}") || stristr($member_id,"{member_id}"))
			{
				$member_id=$SESS->userdata['member_id'];
			}
			$link.="/".$this->encrypt($member_id);
		}
		return $link; 
	}
	
	function get_download_link()
	{
		global $TMPL, $PREFS, $FNS, $SESS, $LANG; 


		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'language':
						$language = $value;
						break;
					case 'file':
						$file = $this->encrypt($value);
						break;
					case 'member_id':
						if (stristr($value,"{logged_in_member_id}") || stristr($value,"{member_id}"))
						{
							$member_id = $this->encrypt($this->_sanitize_number($SESS->userdata['member_id']));
						}
						else
						{
							$member_id = $this->encrypt($this->_sanitize_number($value));
						}
						break;
					case 'group_id':
						if (stristr($value,"{logged_in_group_id}") || stristr($value,"{group_id}"))
						{
							$group_id = $this->encrypt($this->_sanitize_number($SESS->userdata['group_id']));
						}
						else
						{
							$group_id = $this->encrypt($this->_sanitize_number($value));
						}
						break;
				}
			}
		}
		
		if (empty($file))
		{
			return $OUT->show_user_error('general', $LANG->line('download_url_not_specified'));
			exit;
		}
		

		$qs = ($PREFS->ini('force_query_string') == 'y') ? '' : '?';

		$download_url = $FNS->fetch_site_index(0, 0).$qs.'ACT='.$FNS->insert_action_ids($FNS->fetch_action_id('Cartthrob', '_download_file_form_submit')).'&f='. $file; 

		if (isset($member_id))
		{
			$download_url .="&m=". $member_id; 
		}
		if (isset($group_id))
		{
			$download_url .="&g=". $group_id; 
		}
		if (isset($language))
		{
			$download_url .="&l=".$language; 
		}
		
		return $download_url; 

		
	}
	function download_file_form()
	{
		global $TMPL, $FNS, $SESS;

		$this->_session_start();

		$data = $this->_form_declaration_data('_download_file_form_submit');


		foreach ($TMPL->tagparams as $key => $value)
		{
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'id':
					case 'name':
					case 'onsubmit':
					case 'class': 
						$data[$key] = $value;
						break;
					case 'language':
						$data['hidden_fields'][$key] = $value;
						break;	
					case 'file':
						$data['hidden_fields']['FI'] = $this->_encode_string($value);
						break;
					case 'member_id':
						if (stristr($value,"{logged_in_member_id}") || stristr($value,"{member_id}"))
						{
							$data['hidden_fields']['MI'] = $this->_encode_string($this->_sanitize_number($SESS->userdata['member_id']));
						}
						else
						{
							$data['hidden_fields']['MI'] = $this->_encode_string($this->_sanitize_number($value));
						}
						break;
					case 'group_id':
						if (stristr($value,"{logged_in_group_id}") || stristr($value,"{group_id}"))
						{
							$data['hidden_fields']['GI'] = $this->_encode_string($this->_sanitize_number($SESS->userdata['group_id']));
						}
						else
						{
							$data['hidden_fields']['GI'] = $this->_encode_string($this->_sanitize_number($value));
						}
						break;
				}
			}
		}

		$tagdata = $FNS->form_declaration($data);

		if ($TMPL->fetch_param('class'))
		{
			$tagdata = str_replace('<form', '<form class="'.$TMPL->fetch_param('class').'"', $tagdata);
		}

		if (strpos($tagdata, '&amp;#47;') !== FALSE)
		{
			$tagdata = str_replace('&amp;#47;', '/', $tagdata);
		}

		if ($TMPL->fetch_param('language'))
		{
			$this->_set_language($TMPL->fetch_param('language'));
		}

		$tagdata .= $TMPL->tagdata;

		$tagdata .= '</form>';

		return $tagdata;
	}

	function _download_file_form_submit()
	{
		global $IN, $FNS, $TMPL, $OUT, $LANG, $SESS; 
		
		
		// Check member id. 
		if ($IN->GBL('MI', 'POST'))
		{
			$MI = $this->_decode_string($IN->GBL('MI', 'POST'));
			
		}
		elseif ($IN->GBL('m', 'GET'))
		{
			$MI = $this->decrypt($this->_xss_clean($IN->GBL('m', 'GET')));
			
		}
		
		// Check group id. 
		if ($IN->GBL('GI', 'POST'))
		{
			$GI = $this->_decode_string($IN->GBL('GI', 'POST'));
			
		}
		elseif ($IN->GBL('g', 'GET'))
		{
			$GI = $this->decrypt($this->_xss_clean($IN->GBL('g', 'GET')));
			
		}
		
		
		if ($IN->GBL('FI', 'POST'))
		{
			$post_url = $this->_parse_path($this->_decode_string($IN->GBL('FI', 'POST')));
			$this->_check_security_hash();
			
		}
		elseif ($IN->GBL('f', 'GET'))
		{
			$post_url = $this->_parse_path($this->decrypt($this->_xss_clean($IN->GBL('f', 'GET'))));
			if (empty($MI) && empty($GI))
			{
				return $OUT->show_user_error('general', $LANG->line('download_file_not_authorized'));
				exit;
			}
			
		}
		
		if ($IN->GBL('language', 'POST'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}
		elseif ($IN->GBL('l', 'GET'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('l', 'GET')));
		}
		
			
		// Check to see file's set
		if (!empty($post_url))
		{
			// Check member id. 
			if (!empty($MI))
			{
				$member_id = NULL; 
				
				if ($MI == $this->_sanitize_number($MI))
				{
					$member_id = $MI;
					if ($member_id != $SESS->userdata['member_id'])
					{
						return $OUT->show_user_error('general', $LANG->line('download_file_not_authorized'));
						exit;
					}
				}
			}
			
			// Check group id
			if (!empty($GI))
			{
				$group_id = NULL;
				
				if ($GI == $this->_sanitize_number($GI))
				{
					$group_id = $GI;
					
					if ($group_id != $SESS->userdata['group_id'])
					{
						return $OUT->show_user_error('general', $LANG->line('download_file_not_authorized'));
						exit;
					}
				}
			}
			

			if (substr($post_url,-1)=="/")
			{
				$post_url=substr($post_url,0,-1);
			}
			$filename = basename($post_url);

			if (strstr($_SERVER['HTTP_USER_AGENT'], 'MSIE'))
			{
				$filename = preg_replace('/\./', '%2e', $filename, substr_count($filename, '.') - 1); 
			}
			switch(strtolower(substr(strrchr($filename, "."), 1)))
			{ 
				// Movies
				case "avi":
					$content_type = "video/x-msvideo";
					break; 
				case "mov":
					$content_type = "video/quicktime";
					break;
				case "mpg":
				case "mpeg":
					$content_type = "video/mpeg";
					break;
				case "wmv":
					$content_type = "video/x-ms-wmv";
					break;

				// Documents
				case "doc":
					$content_type = "application/msword"; 
					break;
				case "pdf":
					$content_type = "application/pdf";
					break;
				case "txt":
					$content_type = "text/plain";
					break;
				case "xls":
					$content_type = "application/excel"; 
					break;
				case "ppt":
					$content_type = "application/powerpoint";
					break; 

				// Images
				case "jpg":
				case "jpeg":
					$content_type="image/jpeg";
					break;
				case "psd":
					$content_type = "application/octet-stream";
					break;

				// Audio
				case "m4a":
				case "mp3":
					$content_type = "audio/mpeg";
					break;
				case "wav":
					$content_type = "audio/wav";
					break;

				// Compressed
				case "rar":
					$content_type = "application/x-rar-commpressed";
					break;
				case "zip":
					$content_type = "application/x-zip-compressed";
					break;
				case "7z":
					$content_type = "application/x-7z-compressed"; 
					break;

				// Other
				default: 
					$content_type = "application/force-download"; 
			}

			if (stristr($post_url, 'http://'))
			{
				$data = $this->curl_transaction($post_url); 
				if ($data)
				{
					header("Accept-Ranges: bytes"); 
					header("Expires: 0"); 
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
					header("Cache-Control: public", FALSE); 
					header("Content-Description: File Transfer"); 
					header("Content-Disposition: attachment; filename=\"" . $filename . "\";"); 
					header("Content-Transfer-Encoding: binary"); 
					header("Content-Type: " . $content_type); 
					header("Pragma: public"); 
					print($data);
					exit;

				}
				else
				{
					return $OUT->show_user_error('general', $LANG->line('download_file_read_error'));
				}
			}
			else
			{
				if (file_exists($post_url)) 
				{
					header("Accept-Ranges: bytes"); 
					header("Expires: 0"); 
					header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
					header("Cache-Control: public", FALSE); 
					header("Content-Description: File Transfer"); 
					header("Content-Disposition: attachment; filename=\"" . $filename . "\";"); 
					header("Content-Transfer-Encoding: binary"); 
					header("Content-Type: " . $content_type); 
					header("Pragma: public"); 

					@ob_clean();
					@flush();
					// vs. 315 added @ to suppress PHP errors which were outputting file path as part of error message.
					if (@readfile($post_url) === FALSE)
					{
					}	
					else
					{
						return $OUT->show_user_error('general', $LANG->line('download_file_read_error'));
					}
					exit;
				}
				else
				{
					return $OUT->show_user_error('general', $LANG->line('download_file_read_error'));
				}
			}
		}
		else
		{
			return $OUT->show_user_error('general', $LANG->line('download_url_not_specified'));
			exit;
		}
		
		$this->_redirect(($IN->GBL('return')) ? $IN->GBL('return') : $FNS->fetch_site_index(1));
	}
	/**
	 * Formats a number
	 *
	 * @access public
	 * @param int $TMPL->fetch_param('number')
	 * @param int $TMPL->fetch_param('decimals')
	 * @param string $TMPL->fetch_param('dec_point')
	 * @param string $TMPL->fetch_param('thousands_sep')
	 * @param string $TMPL->fetch_param('prefix')
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez, Chris Newton
	 */
	function view_formatted_number($number = FALSE,$decimals=NULL,$dec_point=NULL,$thousands_sep=NULL, $prefix=NULL, $space=NULL)
	{
		global $TMPL;

		if ($number === FALSE && is_object($TMPL))
		{
			$number = $TMPL->fetch_param('number');
		}

		if ($number === FALSE)
		{
			return '';
		}
		
		if ($allow_negative = $this->_bool_param('allow_negative', TRUE))
		{
			
		}

		$number = $this->_sanitize_number($number, $allow_negative);

		if (empty($decimals))
		{
			$decimals = (is_object($TMPL) && $TMPL->fetch_param('decimals') !== FALSE) ? (int) $TMPL->fetch_param('decimals') : $this->number_format_defaults['decimals'];
			
		}
		if (empty($dec_point))
		{
			$dec_point = (is_object($TMPL) && $TMPL->fetch_param('dec_point') !== FALSE) ? $TMPL->fetch_param('dec_point') : $this->number_format_defaults['dec_point'];
			
		}
		if (empty($thousands_sep))
		{
			$thousands_sep = (is_object($TMPL) && $TMPL->fetch_param('thousands_sep') !== FALSE) ? $TMPL->fetch_param('thousands_sep') : $this->number_format_defaults['thousands_sep'];
			
		}
		if (empty($prefix))
		{
			$prefix = (is_object($TMPL) && $TMPL->fetch_param('prefix') !== FALSE) ? $TMPL->fetch_param('prefix') : $this->number_format_defaults['prefix'];
			
		}
		if (empty($space))
		{
			$space = (is_object($TMPL) && $TMPL->fetch_param('add_space_after_prefix') !== FALSE) ? $TMPL->fetch_param('add_space_after_prefix') : $this->number_format_defaults['space_after_prefix'];
			
		}
		
		if ($this->_bool_string($space, FALSE))
		{
			$space =" ";
		}
		else
		{
			$space ="";
		}
		
		if ($number < 0)
		{
			$prefix = '-'.$prefix;
			$number *= -1;
		}

		return $prefix.$space.number_format($number, $decimals, $dec_point, $thousands_sep);
	}
	
	function view_country_name()
	{
		global $TMPL;
		
		return ($TMPL->fetch_param('country_code') && isset($this->countries[$TMPL->fetch_param('country_code')])) ? $this->countries[$TMPL->fetch_param('country_code')] : '';
	}
	
	// alias for decrypt
	function view_decrypted_string($string="",$key="")
	{
		return $this->decrypt($string, $key);
	}

	// alias for encrypt
	function view_encrypted_string($string="",$key="")
	{
		return $this->encrypt($string, $key);
	}
	/**
	 * format_phone
	 *
	 * returns an array of phone parts
	 * @param string $phone 
	 * @return string formatted string | array of number parts
	 * @author Chris Newton
	 * @since 1.0
	 * @access private
	 */
	function view_formatted_phone_number() 
	{
		global $TMPL; 
		$phone = $TMPL->fetch_param('number');

		if (!$phone)
		{
			return NULL; 
		}
		$return = array(); 
		$return = $this->_get_formatted_phone($phone);

		$output ="";
		if ($return['international'])
		{
			$output .=$return['international']."-";
		}
		if ($return['area_code'])
		{
			$output .=$return['area_code']."-";
		}
		if ($return['prefix'])
		{
			$output .=$return['prefix']."-";
		}
		if ($return['suffix'])
		{
			$output .=$return['suffix'];
		}
		return $output; 
		
  	}
	//END

	/**
	 * view_setting
	 *
	 * returns selected settings from the backend. 
	 *
	 * @return string
	 * @author Chris Newton
	 * @since 1.0
	 * @access public
	 **/
	function view_setting($setting = NULL)
	{
		global $TMPL; 
		
		if (!$setting)
		{
			$settings_array = (array) $TMPL->tagparams; 
		}
		else
		{
			$settings_array[$setting] = TRUE;  
		}
	
		foreach ( $settings_array as $key => $value)
		{
			
			if ($value !== '' || $value !== FALSE)
			{
				switch ($key)
				{
					case 'prefix':
					case 'number_prefix':
						return $this->settings['number_format_defaults_prefix']; 
						break; 
					case 'region':
						if (!empty($this->settings['default_location']['region']))
						{
							return $this->settings['default_location']['region']; 
						}
						break;
					case 'country':
					case 'country_code':
						if (!empty($this->settings['default_location']['country_code']))
						{
							return $this->settings['default_location']['country_code']; 
						}
						break;	
					case 'state':
						if (!empty($this->settings['default_location']['state']))
						{
							return $this->settings['default_location']['state']; 
						}
						break;						
					case 'zip':
						if (!empty($this->settings['default_location']['zip']))
						{
							return $this->settings['default_location']['zip']; 
						}	
						break;		
					case 'member_id':
						return $this->settings['default_member_id']; 
						break;										
					case 'thousands_sep':
					case 'thousands_separator':
						return $this->settings['number_format_defaults_thousands_sep']; 
						break;
					case 'decimal':
					case 'decimal_point':
						return $this->settings['number_format_defaults_dec_point']; 
						break;
					case 'decimal_precision':
						return $this->settings['number_format_defaults_decimals']; 
						break;
					case 'currency_code':
						return $this->settings['number_format_defaults_currency_code']; 
						break;
					case 'shipping_option':
					case 'selected_shipping_option':
						return $this->_get_shipping_option(); 
						break;
					default:
						if (array_key_exists($key, $this->settings))
						{
							return $this->settings[$key];
						}
						else
						{
							return NULL; 
						}
				}
			}
		}
		return NULL; 
	}
	/**
	 * Returns total of a certain cart field in cart
	 *
	 * @access public
	 * @param string $TMPL->fetch_param('field_name')
	 * @return int
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function view_summed_field()
	{
		global $TMPL;

		return $this->_calculate_field_total($TMPL->fetch_param('field_name'));
	}
	
	/**
	 * xml_to_array
	 *
	 * This converts xml to an array. The default will only output 
	 * one child node at a time. For our purposes this is generally fine, 
	 * most of the xml returned from gateway processes do not contain 
	 * multiple child nodes at the same level.
	 *
	 * @param string $xml 
	 * @return array
	 * @author Chris Newton
	 * @since 1.0
	 * @access public
	 */
	function xml_to_array($xml, $build_type="basic") 
	{ 
		$values = array(); 

		$index  = array(); 

		$array  = array(); 

		$parser = xml_parser_create(); 

		xml_parser_set_option($parser, XML_OPTION_CASE_FOLDING, 0); 

		xml_parser_set_option($parser, XML_OPTION_SKIP_WHITE, 1); 

		xml_parse_into_struct($parser, $xml, $values, $index); 

		xml_parser_free($parser); 
		$count = 0; 

		$name = $values[$count]['tag']; 


		if (isset($values[$count]['attributes']))
		{
			$array[$name] = $values[$count]['attributes'];

		}
		else
		{
			$array[$name] = "";			
		}
		$array[$name] = $this->_build_array($values, $count, $build_type); 

	    return $array; 
	}
	// END
	
	function years()
	{
		global $TMPL;
		
		$years = ($TMPL->fetch_param('years') && is_numeric($TMPL->fetch_param('years'))) ? $TMPL->fetch_param('years') : 5;
		
		$final_year = date('Y') + $years;
		
		$return_data = '';
		
		for ($year = date('Y'); $year < $final_year; $year++)
		{
			$tagdata = $TMPL->tagdata;
			$tagdata = $TMPL->swap_var_single('year', $year, $tagdata);
			$return_data .= $tagdata;
		}
		
		return $return_data;
	}
	
	function year_select()
	{
		global $TMPL;
		
		$years = ($TMPL->fetch_param('years') && is_numeric($TMPL->fetch_param('years'))) ? $TMPL->fetch_param('years') : 5;
		
		$final_year = date('Y') + $years;
		
		$name = $TMPL->fetch_param('name');
		
		$id = ($TMPL->fetch_param('id')) ? ' id="'.$TMPL->fetch_param('id').'"' : '';
		
		$class = ($TMPL->fetch_param('id')) ? ' class="'.$TMPL->fetch_param('class').'"' : '';
		
		$extra = $TMPL->fetch_param('extra');
		
		$selected = $TMPL->fetch_param('selected');
		
		if ($extra && substr($extra, 0, 1) !== ' ')
		{
			$extra = ' '.$extra;
		}
		
		$output = '<select name="'.$name.'"'.$id.$class.$extra.'>'."\n";
		
		$return_data = '';
		
		for ($year = date('Y'); $year < $final_year; $year++)
		{
			$output .= "\t".'<option value="'.$year.'"'.$selected.'>'.$year.'</option>'."\n";
		}
		
		$output .= '</select>'."\n";
		
		return $output;
	}
	
	//alias for year_select()
	function years_select()
	{
		return $this->year_select();
	}

/* "PRIVATE" METHODS */

	/**
	 * Adds an item to cart
	 *
	 * @access private
	 * @param int $entry_id
	 * @param int $quantity
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _add_to_cart($entry_id, $quantity = 1, $title = FALSE, $price = FALSE, $item_options = FALSE, $shipping = FALSE, $weight = FALSE, $no_tax = FALSE, $no_shipping = FALSE, $on_the_fly = FALSE, $show_errors = TRUE, $json = FALSE, $inventory_reduce = FALSE, $license_number = FALSE, $expiration_date = FALSE)
	{
		global $OUT, $LANG, $REGX;

		if ( ! $entry_id && ! $on_the_fly)
		{
			return;
		}

		$quantity = $this->_sanitize_integer($quantity);

		if ( ! $quantity)
		{
			$quantity = 1;
		}

		if ($this->_global_item_limit && $quantity > $this->_global_item_limit)
		{
			$quantity = $this->_global_item_limit;
		}

		if ($price !== FALSE && ( ! is_numeric($price) || $price < 0))
		{
			$price = FALSE;
		}

		$this->_session_start();

		$row_id = $this->_item_in_cart($entry_id, $item_options);

		$inventory = $this->_get_item_inventory($entry_id, FALSE, $item_options);

		if ($row_id !== FALSE && ! $this->settings['allow_products_more_than_once'])
		{
			if ( ! $this->_item_in_stock($entry_id, $row_id, $inventory) && $show_errors)
			{
				$this->_show_error(sprintf($LANG->line('item_not_in_stock_add_to_cart'), $_SESSION['cartthrob']['items'][$row_id]['title']), $json);
			}

			$final_quantity = $_SESSION['cartthrob']['items'][$row_id]['quantity'] + $quantity;

			if ($this->_global_item_limit && $quantity + $this->_get_item_quantity_all($entry_id) > $this->_global_item_limit)
			{
				$final_quantity = $this->_global_item_limit;
			}

			if ($inventory !== FALSE && $quantity + $this->_get_item_quantity_all($entry_id) > $inventory && $show_errors)
			{
				$msg = ($inventory == 1) ? $LANG->line('item_quantity_greater_than_stock_add_to_cart_one') : $LANG->line('item_quantity_greater_than_stock_add_to_cart');

				$this->_show_error(sprintf($msg, $inventory, $_SESSION['cartthrob']['items'][$row_id]['title'], $inventory), $json);
			}

			if (is_array($inventory_reduce))
			{
				foreach ($inventory_reduce as $ir_id => $ir_q)
				{
					$_SESSION['cartthrob']['items'][$row_id]['inventory_reduce'][$REGX->xss_clean($ir_id)] = $REGX->xss_clean($ir_q);
				}
			}

			$_SESSION['cartthrob']['items'][$row_id]['quantity'] = $final_quantity;
		}
		else
		{
			if ($on_the_fly)
			{
				$item = array(
					'entry_id'=>($entry_id) ? $entry_id : 0,
					'title'=>$title,
					'quantity'=>$quantity,
					'weblog_id'=>0,
					'on_the_fly'=>TRUE,
					'shipping'=>$this->_sanitize_number($shipping),
					'weight'=>$this->_sanitize_number($weight),
					'no_tax'=>$no_tax,
					'no_shipping'=>$no_shipping,
					'license_number'=>$license_number,
					'expiration_date'=>$expiration_date
				);
				
				if ($price !== FALSE)
				{
					$item['price'] = $this->_sanitize_number($price);
				}
				
				if ($item_options && is_array($item_options))
				{
					$item['item_options'] = $item_options;
				}
			}
			else
			{
				$item_data = $this->_get_item_data($entry_id);

				$item = FALSE;

				if (isset($item_data['weblog_id']))
				{
					$item = array(
						'entry_id'=>$entry_id,
						'quantity'=>$quantity,
						'weblog_id'=>$item_data['weblog_id'],
						'price'=>$price,
						'title'=>$item_data['title'],
						'no_tax'=>$no_tax,
						'no_shipping'=>$no_shipping,
						'license_number'=>$license_number,
						'expiration_date'=>$expiration_date
					);
					
					if ($shipping !== FALSE && (string) $this->_sanitize_number($shipping) !== '')
					{
						$item['shipping'] = $this->_sanitize_number($shipping);
					}
					
					if ($weight !== FALSE && (string) $this->_sanitize_number($weight) !== '')
					{
						$item['weight'] = $this->_sanitize_number($weight);
					}

					if ($item_options && is_array($item_options))
					{
						$item['item_options'] = $item_options;
					}

					if ( ! $this->_item_in_stock($entry_id, FALSE, $inventory) && $show_errors)
					{
						$this->_show_error(sprintf($LANG->line('item_not_in_stock_add_to_cart'), $item['title'], $inventory), $json);
					}
				}
			}

			if ($item)
			{
				if ($inventory !== FALSE && $item['quantity'] + $this->_get_item_quantity_all($entry_id) > $inventory)
				{
					if ($show_errors)
					{
						$msg = ($inventory == 1) ? $LANG->line('item_quantity_greater_than_stock_add_to_cart_one') : $LANG->line('item_quantity_greater_than_stock_add_to_cart');

						$this->_show_error(sprintf($msg, $inventory, $item['title'], $inventory), $json);
					}
				}

				if (is_array($inventory_reduce))
				{
					foreach ($inventory_reduce as $ir_id => $ir_q)
					{
						$item['inventory_reduce'][$REGX->xss_clean($ir_id)] = $REGX->xss_clean($ir_q);
					}
				}

				if ($this->settings['product_split_items_by_quantity'] && $item['quantity'] > 1)
				{
					$total = $item['quantity'];

					$item['quantity'] = 1;

					for ($i = 1; $i <= $total; $i++)
					{
						$_SESSION['cartthrob']['items'][] = $item;
					}
				}
				else
				{
					$_SESSION['cartthrob']['items'][] = $item;
				}
			}
		}

		if ($json && function_exists('json_encode'))
		{
			exit(json_encode(array('error' => 0, 'success' => 1)));
		}
		
		end($_SESSION['cartthrob']['items']);
		
		return key($_SESSION['cartthrob']['items']);
	}

	function _add_to_cart_form_submit()
	{
		global $IN, $FNS;

		// -------------------------------------------
		// 'cartthrob_add_to_cart_start' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		global $EXT;

		$this->_session_start();

		if ($EXT->active_hook('cartthrob_add_to_cart_start') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_add_to_cart_start', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}

		$this->_check_security_hash();

		if ($IN->GBL('language', 'POST'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}

		$entry_id = $this->_xss_clean($IN->GBL('entry_id', 'POST'));

		if ( ! $entry_id)
		{
			$entry_id = $this->_xss_clean($IN->GBL('title', 'POST'));
		}

		$price = FALSE;

		if ( ! is_array($entry_id))
		{
			if ($IN->GBL('AUP', 'POST') && $IN->GBL('price', 'POST') !== FALSE && $this->_decode_bool($IN->GBL('AUP', 'POST')))
			{
				$price = $this->_sanitize_number($this->_xss_clean($IN->GBL('price', 'POST')));
			}

			if ($IN->GBL('PR', 'POST'))
			{
				$PR = $this->_decode_string($IN->GBL('PR', 'POST'));

				if ($PR == $this->_sanitize_number($PR))
				{
					$price = $PR;
				}
			}
			
			$expiration_date = FALSE;

			if ($IN->GBL('EXP', 'POST'))
			{
				$EXP = $this->_decode_string($IN->GBL('EXP', 'POST'));

				if ($EXP == $this->_sanitize_number($EXP))
				{
					$expiration_date = $EXP;
				}
			}

			$show_errors = TRUE;

			if ($IN->GBL('ERR', 'POST'))
			{
				$show_errors = $this->_decode_bool($IN->GBL('ERR', 'POST'));
			}

			$on_the_fly = ($IN->GBL('OTF', 'POST') && $this->_decode_bool($IN->GBL('OTF', 'POST')));

			$allow_user_weight = ($IN->GBL('AUW', 'POST') && $this->_decode_bool($IN->GBL('AUW', 'POST')));

			$allow_user_shipping = ($IN->GBL('AUS', 'POST') && $this->_decode_bool($IN->GBL('AUS', 'POST')));

			$json = ($IN->GBL('JSN', 'POST') && $this->_decode_bool($IN->GBL('JSN', 'POST')));

			$weight = FALSE;

			if ($IN->GBL('WGT', 'POST'))
			{
				$WGT = $this->_decode_string($IN->GBL('WGT', 'POST'));

				if ($WGT == $this->_sanitize_number($WGT))
				{
					$weight = $WGT;
				}
			}
			elseif ($allow_user_weight && $IN->GBL('weight', 'POST') !== FALSE)
			{
				$weight = $IN->GBL('weight', 'POST');
			}

			$shipping = FALSE;

			if ($IN->GBL('SHP', 'POST'))
			{
				$SHP = $this->_decode_string($IN->GBL('SHP', 'POST'));

				if ($SHP == $this->_sanitize_number($SHP))
				{
					$shipping = $SHP;
				}
			}
			elseif ($allow_user_shipping && $IN->GBL('shipping', 'POST') !== FALSE)
			{
				$shipping = $IN->GBL('shipping', 'POST');
			}

			$no_shipping = FALSE;

			if ($IN->GBL('NSH', 'POST'))
			{
				$no_shipping = $this->_decode_bool($IN->GBL('NSH', 'POST'));
			}

			$no_tax = FALSE;

			if ($IN->GBL('NTX', 'POST'))
			{
				$no_tax = $this->_decode_bool($IN->GBL('NTX', 'POST'));
			}

			$row_id = $this->_add_to_cart($entry_id,
					    $this->_xss_clean($IN->GBL('quantity', 'POST')),
					    ($on_the_fly) ? $this->_xss_clean($IN->GBL('title', 'POST')) : '',
					    $price,
					    $this->_xss_clean($IN->GBL('item_options', 'POST')),
					    $shipping,
					    $weight,
					    $no_tax,
					    $no_shipping,
					    $on_the_fly,
					    $show_errors,
					    $json,
					    $this->_xss_clean($IN->GBL('inventory_reduce', 'POST')),
					    $this->_xss_clean($IN->GBL('license_number', 'POST')),
					    $expiration_date
			);
		}
		else
		{
			//must deprecate
			//use multi_add_to_cart_form
			unset($_POST['OTF'], $_POST['item_options']);

			foreach ($entry_id as $id)
			{
				$this->_add_to_cart($id);
			}
		}

		// -------------------------------------------
		// 'cartthrob_add_to_cart_end' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_add_to_cart_end') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_add_to_cart_end', $this, $_SESSION['cartthrob'], $row_id);
			if ($EXT->end_script === TRUE) return;
		}

		$this->_redirect(($IN->GBL('return')) ? $IN->GBL('return') : $FNS->fetch_site_index(1));
	}

	function _add_coupon_code($coupon_code = FALSE, $show_errors = TRUE)
	{
		global $IN, $REGX, $LANG;

		if ( ! $coupon_code)
		{
			return FALSE;
		}

		$coupon_code_data = $this->_get_coupon_code_data($coupon_code);

		if ($this->_xss_clean($IN->GBL('language', 'POST')))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}

		if ($IN->GBL('ERR', 'POST'))
		{
				$show_errors = ($IN->GBL('ERR', 'POST') && $this->_decode_bool($IN->GBL('ERR', 'POST'), TRUE));
		}

		$json = ($IN->GBL('JSN', 'POST') && $this->_decode_bool($IN->GBL('JSN', 'POST')));

		if ($coupon_code && $this->_validate_coupon_code($coupon_code, $coupon_code_data))
		{
			//in the case of a coupon limit of 1, we'll overwrite the coupon code
			if ($this->settings['global_coupon_limit'] == 1 && count($this->_get_coupon_codes()) >= 1)
			{
				$_SESSION['cartthrob']['coupon_codes'] = array($coupon_code);
			}
			else
			{
				if ( ! in_array($coupon_code, $_SESSION['cartthrob']['coupon_codes']))
				{
					$_SESSION['cartthrob']['coupon_codes'][] = $coupon_code;
				}
			}

			unset($_POST['coupon_code']);

			if ($json)
			{
				$this->_json(array('error'=>0,'success'=>1,'msg'=>$LANG->line('coupon_valid_msg')));
			}

			return TRUE;
		}
		else
		{
			$msg = $LANG->line('coupon_default_error_msg');

			if ($coupon_code_data['metadata']['invalid'])
			{
				$msg = $LANG->line('coupon_invalid_msg');
			}
			elseif ($coupon_code_data['metadata']['expired'])
			{
				$msg = $LANG->line('coupon_expired_msg');
			}
			elseif ($coupon_code_data['metadata']['user_limit'])
			{
				$msg = $LANG->line('coupon_user_limit_msg');
			}
			elseif ($coupon_code_data['metadata']['coupon_limit'])
			{
				$msg = $LANG->line('coupon_coupon_limit_msg');
			}
			elseif ($coupon_code_data['metadata']['no_access'])
			{
				$msg = $LANG->line('coupon_no_access_msg');
			}
			elseif ($coupon_code_data['metadata']['global_limit'])
			{
				$msg = sprintf($LANG->line('coupon_global_limit_msg'), $this->_global_coupon_limit);
			}
			elseif ($coupon_code_data['metadata']['inactive'])
			{
				$msg = $LANG->line('coupon_inactive_msg');
			}
			elseif (isset($coupon_code_data['metadata']['msg']))
			{
				$msg = $coupon_code_data['metadata']['msg'];
			}

			if ($show_errors)
			{
				$this->_show_error($msg, $json);
			}

			return FALSE;
		}
	}
	
	function _ajax_action()
	{
		global $IN, $FNS;
		
		switch($IN->GBL('action', 'POST'))
		{
			case 'add_to_cart':
				$this->_add_to_cart($IN->GBL('entry_id', 'POST'), $IN->GBL('quantity', 'POST'));
				break;
			case 'delete_from_cart':
				$this->_delete_from_cart($IN->GBL('entry_id', 'POST'), TRUE, $IN->GBL('row_id', 'POST'));
				break;
			case 'duplicate_item':
				$this->_duplicate_item($IN->GBL('entry_id', 'POST'), $IN->GBL('row_id', 'POST'));
				break;
		}
		
		$data = array();
		
		$data['items'] = $this->_get_cart_items();
		
		foreach ($data['items'] as $row_id => $item)
		{
			//$data['items'][$row_id] = array_merge($item, $this->_get_item_data($item['entry_id'], $row_id));
			$data['items'][$row_id]['price'] = $this->_get_item_price($item['entry_id'], $row_id);
		}
		
		$data['cart_info'] = $this->_get_cart_info();
		
		$data['XID'] = $FNS->add_form_security_hash('{XID_HASH}');
		
		$this->_json($data);
	}
	function _apply_discounts()
	{
		
	}
	function _auto_force_https()
	{
		if ($this->settings['auto_force_https'])
		{
			$this->_force_https($this->settings['force_https_domain']);
		}
	}

	/**
	 * Converts text-based template parameter to boolean
	 *
	 * Chris Newton's personal note. Why, oh why EE developers, can't you add a similar function for your parameters
	 * 
	 * @access private
	 * @param string $param
	 * @param string $default
	 * @param string $fetch_param
	 * @return bool
	 * @author Rob Sanchez
	 * @since 1.0.0
	 */
	function _bool_string($string, $default = FALSE)
	{
		if (is_bool($string))
		{
			return $string;
		}

		if (is_int($string))
		{
			return (bool) $string;
		}
		
		switch (strtolower($string))
		{
			case 'true':
			case 't':
			case 'yes':
			case 'y':
			case 'on':
			case '1':
				return TRUE;
				break;
			case 'false':
			case 'f':
			case 'no':
			case 'n':
			case 'off':
			case '0':
				return FALSE;
				break;
			default:
				return $default;
		}
	}
	
	/**
	 * _bool_param
	 *
	 * returns a boolean value based on the contents of a parameter, or the default if no data is available
	 * 
	 * @param string $param_name Name of the Parameter
	 * @param string $default if no data is passed in through the param_name, this is what's returned
	 * @return bool
	 * @author Rob Sanchez
	 * @since 1.0
	 *
	 */
	function _bool_param($param_name, $default = FALSE)
	{
		global $TMPL;

		if (is_bool($param_name))
		{
			return $param_name;
		}

		if (is_int($param_name))
		{
			return (bool) $param_name;
		}

		if ( ! is_object($TMPL) || $TMPL->fetch_param($param_name) === FALSE)
		{
			return $default;
		}

		return $this->_bool_string($TMPL->fetch_param($param_name), $default);
	}
	
	
	/**
	 * build_array
	 *
	 * recursively builds array out of xml
	 * set the build type as "complete" and this will build a complete array
	 * even in cases where there are multiple child nodes at the same level. 
	 * The default will only output one child node at a time. For our purposes
	 * this is generally fine, most of the xml returned from gateway processes
	 * do not contain multiple child nodes at the same level.
	 * 
	 * @param string $xml_data 
	 * @param string $count 
	 * @param string $build_type basic / complete
	 * @return array
	 * @author Chris Newton
	 * @since 1.0
	 * @access private
	 */
	function _build_array($xml_data, &$count, $build_type="basic") 
	{ 
	    $child = array();

	    if (isset($xml_data[$count]['value'])) 
		{
			array_push($child, $xml_data[$count]['value']); 
		}
		if ($count == 0)
		{
			$name = @$xml_data[0]['tag']; 

			if(!empty($xml_data[0]['attributes'])) 
			{                
				foreach ($xml_data[0]['attributes'] as $key=> $value)
				{
					$child[$key] = $value; 
				}    
			}
		}

	    while ($count++ < count($xml_data)) 
		{ 
			switch ($xml_data[$count]['type']) 
			{ 
				case 'cdata': 
					@array_push($child, $xml_data[$count]['value']); 
					break; 
				case 'complete': 
					$name = $xml_data[$count]['tag']; 
					if(!empty($name))
					{ 
						if (isset($xml_data[$count]['value']))
						{
							if ($build_type=="complete")
							{
								$child[$name][]['data'] = $xml_data[$count]['value']; 

							}
							else
							{
								$child[$name]['data'] = $xml_data[$count]['value']; 
							}
						}
						else
						{
							$child[$name] = ""; 	
						}
						if(isset($xml_data[$count]['attributes'])) 
						{                
							foreach ($xml_data[$count]['attributes'] as $key=> $value)
							{
								$curr = count ($child[$name]);
								if ($build_type=="complete")
								{
									$child[$name][$curr-1][$key] = $value; 
								}
								else
								{
									$child[$name][$key] = $value; 
								}
							}    
						}
						if (empty($new_count))
						{
							$new_count = 1; 
						}
						else
						{
							$new_count ++;  
						
						}
					}    
					break; 
				case 'open': 
					$name = $xml_data[$count]['tag']; 
					if (isset($child[$name]))
					{
						$size = count($child[$name]); 
					}
					else
					{
						$size = 0; 
					}
					$child[$name][$size] = $this->_build_array($xml_data, $count); 
					break; 
				case 'close': 
					return $child; 
					break; 
			}
		} 
		return $child; 
	}
	// END

	// gives us a little more obscurity
	// for our encrypted boolean form values
	function _create_bool_string($bool = FALSE)
	{
		switch(rand(1, 6))
		{
			case 1:
				$string = ($bool) ? 'true' : 'false';
				break;
			case 2:
				$string = ($bool) ? 't' : 'f';
				break;
			case 3:
				$string = ($bool) ? 'yes' : 'no';
				break;
			case 4:
				$string = ($bool) ? 'y' : 'n';
				break;
			case 5:
				$string = ($bool) ? 'on' : 'off';
				break;
			case 6:
				$string = ($bool) ? '1' : '0';
				break;
		}

		$output = '';

		foreach (str_split($string) as $char)
		{
			$output .= (rand(0,1)) ? $char : strtoupper($char);
		}

		return $output;
	}
	/**
	 * _create_member
	 *
	 * @param string $username 
	 * @param string $email_address 
	 * @param string $screenname 
	 * @param string $password_1 
	 * @param string $password_2 (must match password_1)
	 * @param string $group_id
	 * @param string $language 
	 * @return boolean 
	 * @author Chris Newton 
	 * @since 1.0
	 */
	function _create_member($username, $email_address,  $screenname=NULL, $password_1=NULL, $password_2=NULL, $group_id=NULL, $language=NULL)
	{
		global $PREFS, $IN, $FNS, $LOC, $DB, $OUT, $LANG, $STAT, $EXT; 
		
		if ($group_id && $group_id <5)
		{
			$group_id = 5; 
		}
		
		// GENERATING A PASSWORD IF NONE IS PROVIDED
		if (empty($password_1))
		{
			$password_1 = $FNS->random('alpha');
			$password_2 = $password_1;
		}

		if (empty($screenname))
		{
			$screenname=$username; 
		}

		$data = array(
			'username'		=>  $username, 
			'password'		=>	$FNS->hash(stripslashes($password_1)),
			'ip_address'	=>	$IN->IP,
			'unique_id'		=>	$FNS->random('encrypt'),
			'email' 		=>	$email_address,
			'screen_name'	=>	$screenname,
			'join_date'		=>	$LOC->now
			);
			
		if ($language)
		{
			$data['language'] = $language; 
		}

		// checking this first, so we can set a default
		if ($PREFS->ini("default_member_group"))
		{
			$default_group	= $PREFS->ini('default_member_group');
		}
		else
		{
			$default_group = 4; 
		}
		
		// checking for the group_id. then checking the validity of that group_id
		if ( $group_id) 
		{
			
			$query = $DB->query("SELECT group_id FROM exp_member_groups WHERE site_id = '".$DB->escape_str($PREFS->ini('site_id'))."' AND group_id = '".$group_id."'");
			if (! $query->num_rows)
			{
				$data['group_id'] = $default_group;
			}
			else
			{
				$data['group_id'] = $group_id; 
			}

		}
		else
		{
			$data['group_id'] = $default_group;
		}


		// VALIDATE
		if (! class_exists("Validate"))
		{
			require PATH_CORE . 'core.validate'. EXT; 
		}

		$VAL = new Validate(
				array(
					'member_id'			=> '',
					'val_type'			=> 'new',
					'fetch_lang' 		=> TRUE, 
					'require_cpw' 		=> FALSE,
				 	'enable_log'		=> FALSE,
					'username'			=> $username,
					'cur_username'		=> '',
					'screen_name'		=> $screenname,
					'cur_screen_name'	=> '',
					'password'			=> $password_1,
				 	'password_confirm'	=> $password_2,
				 	'cur_password'		=> '',
				 	'email'				=> $email_address,
				 	'cur_email'			=> ''
					)
			);

		$VAL->validate_username();
		$VAL->validate_screen_name();
		$VAL->validate_password();
		$VAL->validate_email();	

	    if (count($VAL->errors) > 0)
	    {
			$OUT->show_user_error('submission', $VAL->errors);
	    }

		// INSERT MEMBER
	    $DB->query($DB->insert_string('exp_members', $data)); 
	    $member_id = $DB->insert_id;

		// ADDING ENTRY FOR CUSTOM FIELDS
	    $DB->query($DB->insert_string('exp_member_data', array('member_id' => $member_id)));

		// ADDING FOR MEMBERS IN CASE THEY USE THE CP
		$DB->query($DB->insert_string('exp_member_homepage', array('member_id' => $member_id)));

	    // UPDATE MEMBER STATS
		$STAT->update_member_stats();
		
		// -------------------------------------------
		// 'cartthrob_create_member' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		if ($EXT->active_hook('cartthrob_create_member') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_create_member', array_merge($data, array('member_id' => $member_id)), $this);
			if ($EXT->end_script === TRUE) return;
		}
		
		return $member_id; 
	}
	// END
	function _calculate_shipping()
	{
		global $EXT;
	
		$this->_load_shipping_plugin();

		if ( ! $this->SHP || ! is_object($this->SHP) || ! $this->_method_exists($this->SHP, 'get_shipping'))
		{
			$shipping = 0;

			foreach ($this->_get_items() as $row_id => $item)
			{
				$shipping += $this->_calculate_item_shipping($item['entry_id'], $row_id, $item['quantity']);
			}
		}
		else
		{
			$shipping = $this->_round($this->SHP->get_shipping());
		}
		
		// -------------------------------------------
		// 'cartthrob_calculate_shipping' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		if ($EXT->active_hook('cartthrob_calculate_shipping') === TRUE)
		{
			$shipping = $EXT->universal_call_extension('cartthrob_calculate_shipping', $shipping, $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
		
		return $shipping;
	}

	function _calculate_item_shipping($entry_id, $row_id = FALSE, $quantity = 1)
	{
		global $EXT; 
		// -------------------------------------------
		// 'cartthrob_calculate_item_shipping' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		if ($EXT->active_hook('cartthrob_calculate_item_shipping') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_calculate_item_shipping', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
		
		
		$this->_load_shipping_plugin();

		if ( ! $this->SHP || ! is_object($this->SHP) || ! $this->_method_exists($this->SHP, 'get_item_shipping'))
		{
			return $this->_sanitize_number($this->_get_item_shipping($entry_id, $row_id) * $quantity);
		}
		else
		{
			return $this->_sanitize_number($this->_round($this->SHP->get_item_shipping($entry_id, $row_id)) * $quantity);
		}
	}

	function _calculate_discount($use_shipping = TRUE)
	{
		global $EXT;
		
		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_calculate_discount' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_calculate_discount') === TRUE)
		{
			$discount = $EXT->universal_call_extension('cartthrob_calculate_discount', $this, $_SESSION['cartthrob']);
			
			if ($discount !== FALSE)
			{
				return $discount;
			}
		}
		
		$coupon_codes = $this->_get_coupon_codes();

		$discount = 0;

		$subtotal = $this->_calculate_subtotal();

		$shipping = ($use_shipping) ? $this->_calculate_shipping() : 0;


		//$tax = $this->_calculate_tax(FALSE);

		foreach ($coupon_codes as $coupon_code)
		{
			$discount += $this->_get_coupon_discount($coupon_code, $subtotal, $shipping); //, $tax);
		}

		$discount_codes = $this->_get_discount_values($subtotal, $shipping); 
		foreach ($discount_codes as $key => $value)
		{	
			
			if (!empty($value['metadata']['discount']))
			{
				$discount += $value['metadata']['discount']; 
			}
		}			

		return ($discount > 0) ? $this->_round($discount) : 0;
	}

	function _calculate_field_total($field_name = '')
	{
		global $DB;

		$total = 0;

		if ($field_name)
		{
			$field_id = $this->_get_field_id($field_name);

			foreach ($this->_get_items() as $item)
			{
				$amount = 0;

				if ( ! empty($item['on_the_fly']) && ! empty($item[$field_name]))
				{
					$amount = $this->_sanitize_number($item[$field_name]);
				}
				else
				{
					$query = $DB->query("SELECT `$field_id` FROM exp_weblog_data WHERE `$field_id` != '' AND entry_id = '".$DB->escape_str($item['entry_id'])."' LIMIT 1");

					if ($query->num_rows)
					{
						$amount = $this->_sanitize_number($query->row[$field_id]);
					}
				}

				$total += ($item['quantity'] * $amount);
			}
		}

		return $total;
	}

	/**
	 * Calculate tax
	 *
	 * @access private
	 * @return string
	 */
	function _calculate_tax()
	{
		global $EXT;
		
		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_calculate_tax' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_calculate_tax') === TRUE)
		{
			$tax = $EXT->universal_call_extension('cartthrob_calculate_tax', $this, $_SESSION['cartthrob']);
			
			if ($tax !== FALSE)
			{
				return $tax;
			}
		}
		
		$tax_rate = $this->_get_tax_rate(FALSE, ( ! empty($this->settings['tax_use_shipping_address'])) ? 'shipping_' : '');

		/*
		$tax = $this->_calculate_taxable_subtotal() * $tax_rate;

		$tax -= $this->_calculate_discount() * $tax_rate;

		if ($this->_get_tax_shipping())
		{
			$tax += $this->_calculate_shipping() * $tax_rate;
		}
		*/
		if ($this->_get_tax_shipping())
		{
			$tax = ($this->_calculate_subtotal(TRUE) + $this->_calculate_shipping() - $this->_calculate_discount()) * $tax_rate;
		}
		else
		{
			$tax = ($this->_calculate_subtotal(TRUE) - $this->_calculate_discount(FALSE)) * $tax_rate;
		}

		return $this->_round($tax);
	}

	function _calculate_subtotal($taxable = FALSE, $shippable = FALSE)
	{
		global $EXT;
		
		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_calculate_subtotal' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_calculate_subtotal') === TRUE)
		{
			$subtotal = $EXT->universal_call_extension('cartthrob_calculate_subtotal', $this, $_SESSION['cartthrob']);
			
			if ($subtotal !== FALSE)
			{
				return $subtotal;
			}
		}
		
		$total = 0;

		foreach ($this->_get_cart_items() as $row_id => $item)
		{
			if ( ! empty($item['no_tax']) && $taxable)
			{
				continue;
			}
			elseif ( ! empty($item['no_shipping']) && $shippable)
			{
				continue;
			}
			elseif ( ! empty($item['on_the_fly']) && isset($item['price']))
			{
				$total += $item['quantity'] * $this->_sanitize_number($item['price']);
			}
			elseif (isset($item['weblog_id']))
			{
				if ( ! empty($this->settings['product_weblog_fields'][$item['weblog_id']]['global_price']))
				{
					$total += ($item['quantity'] * $this->_sanitize_number($this->settings['product_weblog_fields'][$item['weblog_id']]['global_price']));
				}
				else
				{
					$total += ($item['quantity'] * $this->_sanitize_number($this->_get_item_price($item['entry_id'], $row_id)));
				}
			}
		}

		return $total;
	}
	
	function _calculate_shippable_subtotal()
	{
		return $this->_calculate_subtotal(FALSE, TRUE);
	}
	
	function _calculate_taxable_subtotal()
	{
		return $this->_calculate_subtotal(TRUE);
	}

	/**
	 * Calculate the final total
	 *
	 * @access private
	 * @return string
	 */
	function _calculate_total()
	{
		global $EXT;
		
		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_calculate_total' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_calculate_total') === TRUE)
		{
			$total = $EXT->universal_call_extension('cartthrob_calculate_total', $this, $_SESSION['cartthrob']);
			
			if ($total !== FALSE)
			{
				return $total;
			}
		}
		
		$total = $this->_calculate_subtotal() + $this->_calculate_shipping() + $this->_calculate_tax() - $this->_calculate_discount();

		return ($total > 0) ? $total : 0;
	}
	/**
	 * Returns discount percentage of total
	 * Uses number format params.
	 *
	 * @access public
	 * @param string $field factor the discount against this cart total: total, subtotal
	 * @return string
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function _cart_discount_percentage($field="total")
	{
		switch ($field)
		{
			case "subtotal":
				$percentage = 100 * ($this->_calculate_discount()/$this->_calculate_subtotal());
			break;
			case "total": 
				$percentage = 100 * ($this->_calculate_discount()/$this->_calculate_total());
			break;
			default:
				$percentage = 100 * ($this->_calculate_discount()/$this->_calculate_total());
		}
		return $percentage;
	}
	
	function _cart_entry_ids()
	{
		$entry_ids = array();
		
		foreach ($this->_get_cart_items() as $row_id => $item)
		{
			if ( ! empty($item['entry_id']))
			{
				$entry_ids[] = $item['entry_id'];
			}
		}
		
		return array_unique($entry_ids);
	}

	/**
	 * Change the quantity of an item in the cart
	 *
	 * @access private
	 * @param string $entry_id
	 * @param int $quantity
	 * @return void
	 * @author Rob Sanchez, CHris Newton
	 * @since 1.0
	 */
	function _change_quantity($entry_id, $quantity = 0, $row_id = FALSE)
	{
		global $IN;
		
		$quantity = $this->_sanitize_integer($quantity);

		$this->_session_start();

		if ($row_id === FALSE)
		{
			$row_id = $this->_item_in_cart($entry_id);
		}

		if ($row_id === FALSE)
		{
			return;
		}

		if ($quantity === 0)
		{
			unset($_SESSION['cartthrob']['items'][$row_id]);
		}
		elseif (is_numeric($quantity) && $quantity > 0)
		{
			if ($this->_global_item_limit && $quantity > $this->_global_item_limit)
			{
				$quantity = $this->_global_item_limit;
			}

			if ($this->settings['product_split_items_by_quantity'] && $quantity > 1)
			{
				for ($i = 2; $i <= $quantity; $i++)
				{
					$this->_duplicate_item($entry_id, $row_id);
				}
			}
			else
			{
				$_SESSION['cartthrob']['items'][$row_id]['quantity'] = $quantity;
			}

			/*
			$item_options = $IN->GBL('item_options', 'POST');

			if (is_array($item_options) && count($item_options))
			{
				foreach ($item_options as $key => $value)
				{
					$_SESSION['cartthrob']['items'][$row_id]['item_options'][$key] = $value;
				}
			}
			*/
		}
	}

	function _check_inventory($json = FALSE, $restore_items = FALSE, $cart_items = FALSE)
	{
		global $LANG;

		$cart_items = ($cart_items === FALSE) ? $this->_get_cart_items(TRUE) : $cart_items;
		
		/* rewrite */

		$errors = array();
		
		$quantities = array();

		foreach ($cart_items as $row_id => $item)
		{
			if (empty($item['entry_id']))
			{
				continue;
			}
			
			$inventory = $this->_get_item_inventory($item['entry_id'], $row_id, $this->_get_item_options($item['entry_id'], $row_id));

			if ($inventory !== FALSE && $item['quantity'] > $inventory)
			{
				if ($inventory == 0)
				{
					$errors[] = sprintf($LANG->line('item_not_in_stock'), $item['title']);
				}
				else
				{
					$msg = ($inventory == 1) ? $LANG->line('item_quantity_greater_than_stock_one') : $LANG->line('item_quantity_greater_than_stock');

					$errors[] = sprintf($msg, $inventory, $item['title'], $item['quantity'] - $inventory);
				}
			}
		}
		
		/*
		
		$items = array();

		$titles = array();
		
		$item_options = array();

		foreach ($cart_items as $item)
		{
			if ( ! empty($item['entry_id']) && $this->_validate_entry_id($item['entry_id']))
			{
				if (isset($items[$item['entry_id']]))
				{
					$items[$item['entry_id']] += $item['quantity'];
				}
				else
				{
					$items[$item['entry_id']] = $item['quantity'];
				}

				$titles[$item['entry_id']] = $item['title'];
			}
		}

		$errors = array();

		foreach ($items as $entry_id => $quantity)
		{
			$inventory = $this->_get_item_inventory($entry_id);

			if ($inventory !== FALSE && $quantity > $inventory)
			{
				if ($inventory == 0)
				{
					$errors[] = sprintf($LANG->line('item_not_in_stock'), $titles[$entry_id]);
				}
				else
				{
					$msg = ($inventory == 1) ? $LANG->line('item_quantity_greater_than_stock_one') : $LANG->line('item_quantity_greater_than_stock');

					$errors[] = sprintf($msg, $inventory, $titles[$entry_id], $quantity - $inventory);
				}
			}
		}
		
		*/

		if (count($errors))
		{
			if ($restore_items !== FALSE)
			{
				$_SESSION['cartthrob']['items'] = $restore_items;
			}
			
			$this->_show_error($errors, $json);
		}
	}
	
	function _coupon_code_form_submit()
	{
		global $IN, $FNS, $REGX;

		$this->_check_security_hash();

		if ($IN->GBL('language', 'POST'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}

		$this->_add_coupon_code(trim($REGX->xss_clean($IN->GBL('coupon_code', 'POST'))));

		$this->_redirect(($this->_get_redirect_url()) ? $this->_get_redirect_url() : $FNS->fetch_site_index(1));
	}
	/**
	 * Processes transaction.
	 *
	 * @access public
	 * @author Barrett Newton Inc, Chris Newton & Rob Sanchez
	 * @since 1.0
	 * @see CartThrob customer_fields variable for list of all payment processor fields
	 * @return void
	 */
	function _checkout($gateway = NULL)
	{
		global $FNS, $TMPL, $IN, $REGX, $PREFS, $DB, $LANG;

		//$this->log("_checkout started");
		
		// Save the current customer info for use after checkout
		// needed for return trip after offsite processing
		$this->_save_customer_info(TRUE);
		
		if ( ! $this->total_unique_items() && ! $this->settings['allow_empty_cart_checkout'])
		{
			$this->_show_error($LANG->line('empty_cart'));
		}
		
		$this->_session_start();

		$this->_check_security_hash();

		$required = array();

		if ($IN->GBL('language', 'POST'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}
		
		$not_required = array();

		if ($IN->GBL('REQ', 'POST'))
		{
			$required_string = $this->_decode_string($IN->GBL('REQ', 'POST'));

			if (preg_match('/^not (.*)/', $required_string, $matches))
			{
				$not_required = explode('|', $matches[1]);
				$required_string = '';
			}
			
			if ($required_string)
			{
				
				$required = explode('|', $required_string);
			}

			unset($required_string);
		}

		// This can override the gateway set in the extension. 
		// useful in instances where the user can select their processor, or for international transactions
		// where more than one gateway has to be used based on originating location
		if ($this->settings['allow_gateway_selection'] && $IN->GBL('gateway', 'POST'))
		{
			if ($this->settings['encode_gateway_selection'])
			{
				$gateway = $this->_xss_clean($this->_decode_string($IN->GBL('gateway', 'POST')));
			}
			else
			{
				//remove in ct2
				$gateway = $this->_xss_clean($IN->GBL('gateway', 'POST'));
			}
		}
		
		// Load the payment processing plugin that's stored in the extension's settings. 
		$this->_load_payment_gateway($gateway);

		$authorized_redirect = $this->_xss_clean($IN->GBL('authorized_redirect', 'POST'));

		$failed_redirect = $this->_xss_clean($IN->GBL('failed_redirect', 'POST'));

		$declined_redirect = $this->_xss_clean($IN->GBL('declined_redirect', 'POST'));

		$credit_card_number = $this->_sanitize_credit_card_number($this->_xss_clean($IN->GBL('credit_card_number', 'POST')));
		
		$this->_add_coupon_code(trim($REGX->xss_clean($IN->GBL('coupon_code', 'POST'))));

		$this->_save_shipping_option();
		
		$show_errors = TRUE; 
		if ($IN->GBL('ERR', 'POST'))
		{
			$show_errors = $this->_decode_bool($IN->GBL('ERR', 'POST'));
		}
		if ($show_errors)
		{
			$this->_check_inventory();
			
			// Credit card number validation
			if ($credit_card_number)
			{
				$json = ($IN->GBL('JSN', 'POST') && $this->_decode_bool($IN->GBL('JSN', 'POST')));

				if ($this->settings['modulus_10_checking'] == 1)
				{
					if (! $this->_check_valid_cc_number($credit_card_number))
					{
						$msg = $LANG->line('validation_card_modulus_10');
						$this->_show_error($msg, $json);
					}

				}
			}
		}

		$tax = 0;
		$shipping = 0;
		$subtotal = 0;
		$total_cart = 0;

		$tax = $this->_calculate_tax();
		$shipping = $this->_calculate_shipping();
		$subtotal = $this->_calculate_subtotal();
		$discount = $this->_calculate_discount();
		$total_cart = $this->_calculate_total();
		
		$expiration_date = FALSE;
		
		if ($IN->GBL('EXP', 'POST'))
		{
			$EXP = $this->_decode_string($IN->GBL('EXP', 'POST'));

			if ($EXP == $this->_sanitize_number($EXP)) // ignore a non-numeric input
			{
				$expiration_date = $EXP;
			}
		}

		if ($IN->GBL('TX', 'POST'))
		{
			$TX = $this->_decode_string($IN->GBL('TX', 'POST'));

			if ($TX == $this->_sanitize_number($TX)) // ignore a non-numeric input
			{
				$total_cart -= $tax;
				$tax = $TX;
				$total_cart += $tax;
			}
		}

		if ($IN->GBL('SHP', 'POST'))
		{
			$SHP = $this->_decode_string($IN->GBL('SHP', 'POST'));

			if ($SHP == $this->_sanitize_number($SHP)) // ignore a non-numeric input
			{
				$total_cart -= $shipping;
				$shipping = $SHP;
				$total_cart += $shipping;
			}
		}
		if ($IN->GBL('GI', 'POST'))
		{
			$group_id = $this->_decode_string($IN->GBL('GI', 'POST'));
			
			if ($group_id <=5)
			{
				$group_id = 5; 
			}
		}
		else
		{
			$group_id = "5";
		}
		
		
		if ($IN->GBL('PR', 'POST'))
		{
			$PR = $this->_decode_string($IN->GBL('PR', 'POST'));

			if ($PR == $this->_sanitize_number($PR)) // ignore a non-numeric input
			{
				$total_cart -= $subtotal;
				$subtotal = $PR;
				$total_cart += $subtotal;
			}
		}
		elseif ($IN->GBL('AUP', 'POST'))
		{
			if ($this->_decode_bool($IN->GBL('AUP', 'POST')))
			{
				$total_cart = $this->_sanitize_number($REGX->xss_clean($IN->GBL('price', 'POST')));
			}
		}

		//fetch payment_gateway's required fields
		//bypass if cart total is zero
		if ($total_cart > 0 && isset($this->PG->gateway_info['required_fields']) && is_array($this->PG->gateway_info['required_fields']))
		{
			$required = array_merge($required, $this->PG->gateway_info['required_fields']);
		}
		
		foreach ($not_required as $key)
		{
			unset($required[array_search($key, $required)]);
		}

		/*
		if ($total_cart <= 0)
		{
			unset($required[array_search('credit_card_number', $required)]);
			unset($required[array_search('card_type', $required)]);
			unset($required[array_search('expiration_month', $required)]);
			unset($required[array_search('expiration_year', $required)]);
		}
		*/

		//do validation
		if ($this->_bool_param('validate', TRUE) && count($required) && ! $this->_validate_required($required, TRUE))
		{
			return '';
		}
		$customer_info = array(
			'tax' => $tax,
			'shipping' => $shipping,
			'subtotal' => $subtotal,
			'discount' => $discount,
			'total_cart' => $total_cart
		);

		$saved_customer_info = $this->_get_customer_info();

		foreach ($this->customer_fields as $field)
		{
			$customer_info[$field] = (isset($saved_customer_info[$field]) && $IN->GBL($field, 'POST') === FALSE) ? $saved_customer_info[$field] : $this->_xss_clean($IN->GBL($field, 'POST'));
		}

		if ( ! empty($customer_info['use_billing_info']))
		{
			$billing_fields = array(
				'first_name',
				'last_name',
				'address',
				'address2',
				'city',
				'state',
				'zip',
				'country',
				'country_code',
				'company'
			);

			foreach ($billing_fields as $field)
			{
				if (isset($customer_info[$field]))
				{
					$customer_info['shipping_'.$field] = $customer_info[$field];
				}
			}

			unset($billing_fields);
		}

		$this->_pre_process();

		$entry_id = '';

		$create_user = $this->_xss_clean($IN->GBL('create_user', 'POST'));
		
		if ($this->_bool_string($create_user) != FALSE)
		{
			if (empty($customer_info['username']))
			{
				$username = $customer_info['first_name']. " ". $customer_info['last_name'];
			}
			else
			{
				$username = $customer_info['username'];
			}
			$create_member_id = $this->_create_member($username,  
												$customer_info['email_address'],  
												$customer_info['screen_name'], 
												$customer_info['password'], 
												$customer_info['password_confirm'], 
												$group_id,
												$customer_info['language'],
												$create_user);
		}
		if (empty($create_member_id))
		{
			$member_id = $this->_get_member_id(); 
		}
		else
		{
			$member_id = $create_member_id;
		}
		
		
		$order_data = array(
			'items'=>$this->_get_cart_items(),
			'transaction_id'=>'',
			'shipping'=>$this->_round($shipping),
			'tax'=>$this->_round($tax),
			'subtotal'=>$this->_round($subtotal),
			'discount'=>$this->_round($discount),
			'total'=>$this->_round($total_cart),
			'customer_name'=>$customer_info['first_name'].' '.$customer_info['last_name'],
			'customer_email'=>$customer_info['email_address'],
			'customer_ip_address'=>$IN->IP,
			'customer_phone'=>$customer_info['phone'],
			'coupon_codes'=>implode(',', $this->_get_coupon_codes()),
			'coupon_codes_array'=>$this->_get_coupon_codes(),
			'last_four_digits'=>substr($credit_card_number,-4,4),
			'full_billing_address'=>$customer_info['address']."\r".( ! empty($customer_info['address2']) ? $customer_info['address2']."\r" : '').$customer_info['city'].', '.$customer_info['state'].' '.$customer_info['zip'],
			'full_shipping_address'=>$customer_info['shipping_address']."\r".( ! empty($customer_info['shipping_address2']) ? $customer_info['shipping_address2']."\r" : '').$customer_info['shipping_city'].', '.$customer_info['shipping_state'].' '.$customer_info['shipping_zip'],
			'billing_first_name'=>$customer_info['first_name'],
			'billing_last_name'=>$customer_info['last_name'],
			'billing_company'=>$customer_info['company'],
			'billing_address'=>$customer_info['address'],
			'billing_address2'=>$customer_info['address2'],
			'billing_city'=>$customer_info['city'],
			'billing_state'=>$customer_info['state'],
			'billing_zip'=>$customer_info['zip'],
			'billing_country'=>$customer_info['country'],
			'billing_country_code'=>$customer_info['country_code'],
			'country_code'=>$customer_info['country_code'],
			'shipping_first_name'=>$customer_info['shipping_first_name'],
			'shipping_last_name'=>$customer_info['shipping_last_name'],
			'shipping_company'=>$customer_info['shipping_company'],
			'shipping_address'=>$customer_info['shipping_address'],
			'shipping_address2'=>$customer_info['shipping_address2'],
			'shipping_city'=>$customer_info['shipping_city'],
			'shipping_state'=>$customer_info['shipping_state'],
			'shipping_zip'=>$customer_info['shipping_zip'],
			'shipping_option'=>$customer_info['shipping_option'],
			'shipping_country'=>$customer_info['shipping_country'],
			'shipping_country_code'=>$customer_info['shipping_country_code'],
			'entry_id'=>'',
			'order_id'=>'',
			'total_cart'=>$this->_round($total_cart),
			'auth'=>array(),
			'purchased_items'=>array(),
			'create_user' =>( ! empty($create_member_id)) ? $create_member_id : FALSE, 
			'authorized_redirect' => $this->_xss_clean($IN->GBL('authorized_redirect', 'POST')),
			'failed_redirect' => $this->_xss_clean($IN->GBL('failed_redirect', 'POST')),
			'declined_redirect' => $this->_xss_clean($IN->GBL('declined_redirect', 'POST')),
			'return' => ($IN->GBL('return', 'POST')) ? $this->_xss_clean($IN->GBL('return', 'POST')) : $FNS->fetch_site_index(1),
		);

		if ($this->_save_orders)
		{
			if ($expiration_date)
			{
				$order_data['expiration_date'] = $expiration_date;
			}
			
			$entry_id = $this->_save_order($order_data);
			
			unset($order_data['expiration_date']);

			$order_data['entry_id'] = $entry_id;
			$order_data['order_id'] = $entry_id;
		}
		


		$this->_save_order_to_session($order_data);
		
		if ($total_cart > 0)
		{
			// IF the payment gateway directs users offsite, we will lose them at this point.
			// so the second half of the process is offloaded. 
			$auth = $this->PG->_process_payment($total_cart, $credit_card_number, $customer_info, $entry_id);
		}
		else
		{
			$auth = $this->_free_auth();
		}

		$this->_checkout_complete($auth);
	}
	// END
	
	/**
	 * _checkout_complete
	 *
	 * This is the second half of the _checkout function
	 * 
	 * @author Rob Sanchez, Chris Newton
	 * @since 1.0
	 * @param array $auth (keys: failed, declined, authorized, transaction_id, error_message)
	 * @see CartThrob customer_fields variable for list of all payment processor fields
	 * @return void
	 * @author Chris Newton
	 */
	function _checkout_complete($auth)
	{
		global $FNS, $TMPL, $IN, $REGX, $PREFS, $DB;

		//$this->log("_chekcout_complete started");

		$saved_customer_info = $this->_get_customer_info();

		foreach ($this->customer_fields as $field)
		{
			$customer_info[$field] = (isset($saved_customer_info[$field])) ? $saved_customer_info[$field] : '';
		}

		$order_data = $this->_get_saved_order();
		
		$order_data['auth'] = $auth;

		$entry_id = $order_data['entry_id'];

		if ($auth['authorized'])
		{
		
			if (!empty($order_data['group_id']) && $order_data['create_user'] )
			{
				$this->_update_member_group($order_data['create_user'], $order_data['group_id']); 
				
				/*
				// can't use this right now, as there's no value set for create_user
				if ($order_data['create_user']== "login")
				{
					// need to get the unique_id before we can do this. 
				//	$this->_login_member($order_data['create_user'], $customer_info['username'], $customer_info['password'], $customer_info['unique_id']); 
				}
				*/ 

			}
			
			$update_data = array(
				'status' => ($this->_orders_default_status) ? $this->_orders_default_status : 'open',
				'transaction_id' => @$auth['transaction_id']
			);

			if ($this->_save_orders)
			{
				$this->_update_order($entry_id, $update_data);
			}

			if ($this->_save_purchased_items)
			{
				foreach ($this->_get_cart_items() as $row_id => $item)
				{
					$item['price'] = $this->_get_item_price($item['entry_id'], $row_id);
					// We don't have multiple status settings for purchased items. 
					$order_data['purchased_items'][] = $this->_save_purchased_item($item, $entry_id, $this->_purchased_items_default_status);
				}
			}

			$this->_save_order_to_session($order_data);

			$this->_on_authorize($order_data);

			if ($this->settings['send_confirmation_email'])
			{
				$this->_send_confirmation_email($customer_info['email_address'], $order_data);
			}

			if ($this->settings['send_email'])
			{
				$this->_send_admin_notification_email($order_data);
			}

			$this->_process_coupon_codes();

			$this->_process_inventory();

			$this->clear_cart(FALSE);

			$this->_clear_security_hash();

			$this->_clear_coupon_codes();
			
			// UPDATE MEMBER
			if (!empty($order_data['create_user']))
			{
			//	$DB->query("UPDATE exp_members SET group_id = '".$DB->escape_str($order_data['group_id'])."' WHERE member_id = '".$DB->escape_str($order_data['create_user'])."'");        
			//$DB->query("UPDATE exp_members SET group_id = '4' WHERE member_id = '".$DB->escape_str($order_data['create_user'])."'");        
			}
			
			//order_data
			$this->_redirect($order_data['authorized_redirect']);
		}
		elseif ($auth['declined'])
		{
			$this->_save_order_to_session($order_data);
			
			if (!empty($order_data['create_user']))
			{
				$DB->query("DELETE FROM exp_members WHERE member_id =".$order_data['create_user']);
			}
			
			
			if ($this->_save_orders)
			{
				$status = ($this->settings['orders_declined_status']) ? $this->settings['orders_declined_status'] : 'closed';
				$this->_update_order($entry_id, array('error_message' => 'DECLINED: '.@$auth['error_message'], 'status' => $status));
			}

			$this->_on_decline();

			$this->_redirect($order_data['declined_redirect']);
		}
		elseif ($auth['failed'])
		{
			$this->_save_order_to_session($order_data);

			if (!empty($order_data['create_user']))
			{
				$DB->query("DELETE FROM exp_members WHERE member_id =".$order_data['create_user']);
			}

			if ($this->_save_orders)
			{
				$status = ($this->settings['orders_failed_status']) ? $this->settings['orders_failed_status'] : 'closed';
				$this->_update_order($entry_id, array('error_message' => 'FAILED: '.@$auth['error_message'], 'status' => $status));
			}

			$this->_on_fail();

			$this->_redirect($order_data['failed_redirect']);
		}

		if (empty($order_data['return']))
		{
			$order_data['return'] = $FNS->fetch_site_index(1);
		}

		$this->_redirect($order_data['return']);
	}
	// END
	

	function _check_security_hash()
	{
		global $PREFS, $DB, $IN, $REGX, $FNS;

		if ($PREFS->ini('secure_forms') == 'y')
		{
			$query = $DB->query("SELECT COUNT(*) AS count
					FROM exp_security_hashes
					WHERE hash = '".$DB->escape_str($REGX->xss_clean($IN->GBL('XID', 'POST')))."'
					AND ip_address = '".$IN->IP."'
					AND date > UNIX_TIMESTAMP()-7200");

			if ($query->row['count'] < 1)
			{
				$FNS->redirect(stripslashes($IN->GBL('RET')));
			}
		}
	}

	function _clear_security_hash()
	{
		global $PREFS, $DB, $IN, $REGX, $FNS;

		if ($PREFS->ini('secure_forms') == 'y' && ! $this->_is_ajax())
		{
			$DB->query("DELETE FROM exp_security_hashes
				   WHERE (
					hash = '".$DB->escape_str($REGX->xss_clean($IN->GBL('XID', 'POST')))."'
					AND ip_address = '".$IN->IP."'
				   )
				   OR date < UNIX_TIMESTAMP()-7200");

			$FNS->clear_caching('all', $FNS->fetch_site_index().$IN->GBL('URI'));
		}
		return NULL; 
	}

	/**
	 * _check_cc_number_errors
	 *
	 * Checks whether the number of characters entered for 
	 * a credit card correspond to the card type. 
	 * 
	 * This is a basic check for card number validity
	 * This only checks for number length & whether
	 * the card type is the same as what's been entered
	 * more detailed checks are done through payment processor.
	 * A false response means there are the correct number of digits. 
	 * 
	 * @param string $ccn this is the credit card number to verify
	 * @param int $card_type single digit card type corresponding to the array below. Essentially the first number on the card. 3|4|5|6
	 * @param string $card_type_text Extra check against a known card type VISA|AMEX|AMERICAN EXPRESS|MC|MASTER CARD|MASTERCARD|DISCOVER
	 * @return mixed Error messages | FALSE
	 */	
	function _check_cc_number_errors($ccn,$card_type=NULL, $card_type_text=NULL)
	{

		// gets the first non-zero number of the CC 
		$credit_card_number=str_replace(' ', '', $ccn);

		$ccno	=	$credit_card_number{0};
		if ($card_type && $ccno != $card_type)
		{
			return 'The credit card number you entered does not match the card type';
		}
		switch ($ccno) {
			// Amex
			case 3:
				if (strlen($credit_card_number)!=15)
				{

					return 'When using AMEX: Please enter 15 digits'.strlen($credit_card_number);
				}
				if ($card_type_text && (strtoupper($card_type_text) !="AMEX" && strtoupper($card_type_text ) !="AMERICAN EXPRESS"))
				{
					return 'The credit card number you entered does not match the card type'; 
				}
				return FALSE;
				break;
			// Visa
			case 4:
				if (strlen($credit_card_number)>16)
				{
					return 'You have entered too many digits';
				}
				if (strlen($credit_card_number)<13)
				{
					return "Please enter all digits";
				}
				if (strlen($credit_card_number)==13)
				{
					if ($card_type_text && strtoupper($card_type_text) !="VISA")
					{
						return 'The credit card number you entered does not match the card type'; 
					}
					return FALSE;
				}
				if (strlen($credit_card_number)==16)
				{
					if ($card_type_text && strtoupper($card_type_text) !="VISA")
					{
						return 'The credit card number you entered does not match the card type'; 
					}
					return FALSE;
				}
				else
				{
					return "Please enter correct digits";
				}
				break;
			// Mastercard
			case 5:
				if (strlen($credit_card_number)!=16)
				{
					return 'Please enter 16 digits';
				}
				if ($card_type_text && (strtoupper($card_type_text) !="MC" && strtoupper($card_type_text ) !="MASTERCARD" && strtoupper($card_type_text)!="MASTER CARD"))
				{
					return 'The credit card number you entered does not match the card type'; 
				}
				return FALSE;
				break;
			// Discover
			case 6:
				if (strlen($credit_card_number)!=16)
				{
					return 'Please enter 16 digits';
				}
				if ($card_type_text && strtoupper($card_type_text) !="DISCOVER")
				{
					return 'The credit card number you entered does not match the card type'; 
				}
				return FALSE;
				break;
			default:
				return 'Unknown Card Type';
		}
		return "Unknown Card Type";
	}
	/**
	 * _check_valid_cc_number
	 *
	 * a modulus 10 checker
	 * @param string $ccn credit card number
	 * @return bool (true if number is good)
	 * @author Chris Newton
	 *
	 **/
	/* This takes each digit, from right to left and multiplies each second
	digit by two. If the multiple is two-digits long (i.e.: 6 * 2 = 12) the two digits of
	the multiple are then added together for a new number (1 + 2 = 3). You then add up the 
	string of numbers, both unaltered and new values and get a total sum. This sum is then
	divided by 10 and the remainder should be zero if it is a valid credit card. 
	*/
	function _check_valid_cc_number($ccn)
	{
		$cc				= str_replace(' ', '', $ccn);
		$char_array 	= str_split($cc); 
		$digit_count	= sizeof ($char_array); 
		$double			= array();

	   $j 				= 0; 
		for ($i=($digit_count-2); $i>=0; $i-=2)
		{ 
			$double[$j] = $char_array[$i] * 2; 
			$j++; 
		}	 
		$size_of_double 	= sizeof($double); 
		$num_for_validation	= 0; 

		for ($i=0;$i<$size_of_double;$i++)
		{ 
			$double_count = str_split($double[$i]); 
			for ($j=0;$j<sizeof($double_count);$j++)
			{ 
				$num_for_validation += $double_count[$j]; 
			} 
			$double_count = ''; 
		} 

		for ($i=($digit_count-1); $i>=0; $i-=2)
		{ 
			$num_for_validation += $char_array[$i]; 
		} 

		if (substr($num_for_validation, -1, 1) == '0') 
		{ 
			return TRUE;  
		}
		else 
		{ 
			return FALSE; 
		}
	}

	function _clear_coupon_codes()
	{
		$this->_session_start();

		$_SESSION['cartthrob']['coupon_codes'] = array();
	}

	/** 
	 * Change a number into an english string
	 * Borrowed from http://www.phpro.org/examples/Convert-Numbers-to-Words.html
	 * 
	 * @access private
	 * @param int $number
	 * @return string
	 */ 
	function _convert_number_to_string($number) 
	{ 
		if (($number < 0) || ($number > 999999999)) 
		{ 
			return $number;
		} 

		$Gn = floor($number / 1000000);  /* Millions (giga) */ 
		$number -= $Gn * 1000000; 
		$kn = floor($number / 1000);	 /* Thousands (kilo) */ 
		$number -= $kn * 1000; 
		$Hn = floor($number / 100);	  /* Hundreds (hecto) */ 
		$number -= $Hn * 100; 
		$Dn = floor($number / 10);	   /* Tens (deca) */ 
		$n = $number % 10;			   /* Ones */ 

		$res = ""; 

		if ($Gn) 
		{ 
			$res .= convert_number($Gn) . " Million"; 
		} 

		if ($kn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				convert_number($kn) . " Thousand"; 
		} 

		if ($Hn) 
		{ 
			$res .= (empty($res) ? "" : " ") . 
				convert_number($Hn) . " Hundred"; 
		} 

		$ones = array("", "One", "Two", "Three", "Four", "Five", "Six", 
			"Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", 
			"Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", 
			"Nineteen"); 
		$tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", 
			"Seventy", "Eigthy", "Ninety"); 

		if ($Dn || $n) 
		{ 
			if (!empty($res)) 
			{ 
				$res .= " and "; 
			} 

			if ($Dn < 2) 
			{ 
				$res .= $ones[$Dn * 10 + $n]; 
			} 
			else 
			{ 
				$res .= $tens[$Dn]; 

				if ($n) 
				{ 
					$res .= "-" . $ones[$n]; 
				} 
			} 
		} 

		if (empty($res)) 
		{ 
			$res = "zero"; 
		} 

		return strtolower($res); 
	}

	function _decode_bool($str, $default = FALSE)
	{
		return $this->_bool_string($this->_decode_string($str), $default);
	}

	function _decode_string($str)
	{
		global $DB;

		if ( function_exists('mcrypt_encrypt') )
		{
			$init_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

			$init_vect = mcrypt_create_iv($init_size, MCRYPT_RAND);

			$str = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($DB->username.$DB->password), base64_decode($str), MCRYPT_MODE_ECB, $init_vect), "\0");
		}
		else
		{
			$raw = base64_decode($str);

			$hash = substr($raw, -32);

			$str = substr($raw, 0, -32);

			if ($hash != md5($DB->username.$DB->password.$str))
			{
				$str = '';
			}
		}

		return $str;
	}

	/**
	 * Deletes an item from cart
	 *
	 * @access private
	 * @param int $entry_id
	 * @param bool $delete_all
	 * @return void
	 */
	function _delete_from_cart($entry_id, $delete_all = TRUE, $row_id = FALSE, $item_options = FALSE)
	{
		global $EXT;
		
		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_delete_from_cart_start' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_delete_from_cart_start') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_delete_from_cart_start', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}

		if ($item_options === FALSE)
		{
			$item_options = $this->_get_item_options($entry_id, $row_id);
		}

		$row_id = $this->_item_in_cart($entry_id, $item_options, $row_id);

		if ($row_id !== FALSE)
		{
			if ($delete_all)
			{
				unset($_SESSION['cartthrob']['items'][$row_id]);
			}
			else
			{
				$item = $this->_get_cart_item($entry_id, $row_id);

				if ($item['quantity'] <= 1)
				{
					unset($_SESSION['cartthrob']['items'][$row_id]);
				}
				else
				{
					if (isset($_SESSION['cartthrob']['items'][$row_id]['quantity']))
					{
						$_SESSION['cartthrob']['items'][$row_id]['quantity']--;
					}
				}
			}
		}
		
		// -------------------------------------------
		// 'cartthrob_delete_from_cart_end' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_delete_from_cart_end') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_delete_from_cart_end', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
	}

	function _delete_from_cart_submit()
	{
		global $IN;

		$this->_check_security_hash();

		$delete_all = isset($_POST['delete_all']) ? $IN->GBL('delete_all', 'POST') : TRUE;

		$this->_delete_from_cart($this->_xss_clean($IN->GBL('entry_id', 'POST')), $delete_all, $this->_xss_clean($IN->GBL('row_id', 'POST')));

		$this->_clear_security_hash();

		$this->_redirect($this->_get_redirect_url());
	}

	function _duplicate_item($entry_id, $row_id = FALSE)
	{
		$this->_session_start();

		if ( ! $entry_id && $row_id === FALSE)
		{
			return;
		}

		$item = $this->_get_cart_item($entry_id, $row_id);

		if ($item)
		{
			$_SESSION['cartthrob']['items'][] = $item;
		}
	}

	function _encode_bool($bool)
	{
		return $this->_encode_string($this->_create_bool_string($bool));
	}

	function _encode_string($str)
	{
		global $DB;

		if ( function_exists('mcrypt_encrypt') )
		{
			$init_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);

			$init_vect = mcrypt_create_iv($init_size, MCRYPT_RAND);

			$str = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($DB->username.$DB->password), $str, MCRYPT_MODE_ECB, $init_vect);
		}
		else
		{
			$str = $str.md5($DB->username.$DB->password.$str);
		}

		return base64_encode($str);
	}

	function _fetch_param($param)
	{
		// gets param from TMPL first, then tries POST
		global $TMPL, $IN;

		if (is_object($TMPL) && $TMPL->fetch_param($param) !== FALSE)
		{
			return $TMPL->fetch_param($param);
		}

		return $this->_xss_clean($IN->GBL($param, 'POST'));
	}

	function _force_https($secure_domain = FALSE)
	{
		$domain = (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : getenv('SERVER_NAME');

		$secure_domain = ($secure_domain) ? $secure_domain : $domain;

		if (isset($_SERVER['REQUEST_URI']))
		{
			$request_uri = $_SERVER['REQUEST_URI'];
		}
		else
		{
			$request_uri = getenv('PATH_INFO');

			$request_uri .= (getenv('QUERY_STRING')) ? '?'.getenv('QUERY_STRING') : '';
		}

		if ( ! isset($_SERVER['HTTPS']) || ! $_SERVER['HTTPS'] || strtolower($_SERVER['HTTPS']) == 'off')
		{
			header('Location: https://'.$secure_domain.$request_uri);

			exit;
		}
	}

	function _form_declaration_data($method)
	{
		global $IN, $FNS;

		return array(
			'method' => 'post',
			'enctype' => 'multi',
			'hidden_fields' => array(
				'ACT' => $FNS->fetch_action_id('Cartthrob', $method),
				'RET' => $FNS->fetch_current_uri(),
				'URI' => ($IN->URI == '') ? 'index' : $IN->URI,
			)
		);
	}

	function _free_auth()
	{	
		return array(
			'authorized' => TRUE,
			'failed' => FALSE,
			'declined' => FALSE,
			'error_message' => '',
			'transaction_id' => time()
		);
	}

	function _generate_license_number($type='uuid')
	{
		if ($type == 'uuid')
		{
			if (function_exists('com_create_guid'))
			{
				return str_replace(array(chr(123), chr(125)), '', com_create_guid());
			}
			else
			{
				return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', rand(0, 0xffff), rand(0, 0xffff), rand(0, 0xffff), rand(0, 0x0fff) | 0x4000, rand(0, 0x3fff) | 0x8000, rand(0, 0xffff), rand(0, 0xffff), rand(0, 0xffff));
			}
		}

		return FALSE;
	}
	
	function _get_alpha2_country_code($country_code)
	{
		return ($country_code && isset($this->country_codes[$country_code])) ? $this->country_codes[$country_code] : $country_code;
	}

	function _get_alpha3_country_code($country_code)
	{
		$key = array_search(strtoupper($country_code), $this->country_codes);
		if ($key)
		{
			return $key;
		}
		else
		{
			return $country_code;
		}
	}
	/**
	 * convert_card_type
	 *
	 * this function attempts to convert a given card type to an expected card type (MC to MasterCard)
	 *
	 * @param string $card_type_value Visa, Amex, etc
	 * @param string $return_type title (Title Case), camel (CamelCase), abbreviate (abbr), single (Singleword)
	 * @return string
	 * @author Chris Newton
	 * @since 1.0
	 */
	function convert_card_type($card_type_value, $return_type)
	{
		switch(strtolower($card_type_value))
		{
			case "mastercard":
			case "mc":
			case "master card":
				if ($return_type == "title" )
				{
					return "Mastercard";
				}
				elseif ($return_type == "camel")
				{
					return "MasterCard";
				}
				elseif ($return_type == "abbreviate")
				{
					return "MC";
				}
				elseif ($return_type == "single")
				{
					return "Mastercard";
				}
			break;
			case "visa":
				return "Visa";
			break;
			case "discover":
				return "Discover";
			break;
			case "diners club":
			case "dc":
			case "diners":
			case "dinersclub":
				if ($return_type == "title" )
				{
					return "Diners Club";
				}
				elseif ($return_type == "camel")
				{
					return "DinersClub";
				}
				elseif ($return_type == "abbreviate")
				{
					return "Diners";
				}
				elseif ($return_type == "single")
				{
					return "Dinersclub";
				}
			break;
			case "american express":
			case "amex":
			case "americanexpress":
				if ($return_type == "title" )
				{
					return "American Express";
				}
				elseif ($return_type == "camel")
				{
					return "AmericanExpress";
				}
				elseif ($return_type == "abbreviate")
				{
					return "amex";
				}
				elseif ($return_type == "single")
				{
					return "Americanexpress";
				}
			break;
			case "switch":
				return "Switch";
			case "laser":
				return "Laser";
			case "maestro":
				return "Maestro";
			case "solo":
				return "Solo";
			case "delta":
				return "Delta";
			default: 
				return $card_type_value; 
		}
		return $card_type_value; 
	}
	// END
	function convert_country_code($country_code=NULL)
	{
		global $TMPL;
		
		if (is_object($TMPL) && $this->_fetch_param('country_code'))
		{
			$country_code= $TMPL->fetch_param('country_code'); 
		}
		
		$code = $this->_get_alpha3_country_code($country_code); 
		
		return (isset($this->countries[$code])) ? $this->countries[$code] : $country_code;
	}
	// END
	/**
	 * _Get_card_type
	 *
	 * Returns a text string describing the card type for Amex, Discover, MC, and Visa
	 * 
	 * @access private
	 * @param string $ccn credit card number
	 * @return string card type
	 * @author Chris Newton
	 * @since 1.0.0
	 **/
	function _get_card_type( $ccn ) 
	{ 
		$cc=str_replace(' ', '', $ccn);

		$cctype = "Unknown Card Type";

		$length = strlen($cc);
		if ($length == 15 && substr($length, 0, 1) == '3' )   
		{ 
			$cctype = "amex"; 
		}
		elseif ( $length == 16 && substr($length, 0, 1) == '6' )			 
	 	{ 
			$cctype = "discover"; 
		}
		elseif ( $length == 16 && substr($length, 0, 1) == '5'  )
		{ 
			$cctype = "mc"; 
		}
		elseif ( ($length == 16 || $length == 13) && substr($cc, 0, 1) == '4' ) 
		{ 
			$cctype = "visa"; 
		}
	   return $cctype;
	}
	
	function _get_cart_info()
	{
		return array(
			'total_unique_items'=>$this->total_unique_items(),
			'cart_tax_name'=>$this->_get_tax_name(),
			'total_items'=>$this->total_items(),
			'cart_total'=>$this->cart_total(),
			'cart_subtotal'=>$this->cart_subtotal(),
			'cart_tax'=>$this->cart_tax(),
			'cart_tax_rate'=>$this->_get_tax_rate(TRUE),
			'cart_shipping'=>$this->cart_shipping(),
			'cart_entry_ids'=>$this->cart_entry_ids(),
			'cart_discount'=>$this->cart_discount(),
			'cart_subtotal_plus_shipping'=>$this->cart_subtotal_plus_shipping(),
			'shipping_option'=>$this->_get_shipping_option()
		);
	}

	function _get_cart_item($entry_id, $row_id = FALSE)
	{
		$items = $this->_get_cart_items();

		if ($row_id !== FALSE && isset($items[$row_id]))
		{
			return $items[$row_id];
		}
		else
		{
			foreach ($items as $item)
			{
				if ($item['entry_id'] == $entry_id)
				{
					return $item;
				}
			}
		}

		return array();
	}

	function _get_cart_items($group_similar = FALSE, $orderby = FALSE, $sort = FALSE)
	{
		global $REGX;

		$this->_session_start();

		$items = (isset($_SESSION['cartthrob']['items'])) ? $_SESSION['cartthrob']['items'] : array();
		
		$group_similar = ($group_similar != FALSE) ? array() : FALSE;
		
		foreach ($items as $row_id => $item)
		{
			if ( ! empty($item['item_options']))
			{
				$items[$row_id]['item_options'] = $REGX->array_stripslashes($item['item_options']);
			}
			
			$items[$row_id]['row_id'] = $row_id;
			
			if ($group_similar !== FALSE)
			{
				$hash = isset($item['entry_id']) ? $item['entry_id'] : '';
				
				$hash .= ( ! empty($item['item_options'])) ? '-'.md5(serialize($item['item_options'])) : '';
				
				if ($hash)
				{
					if (isset($group_similar[$hash]))
					{
						$items[$group_similar[$hash]]['quantity'] += $item['quantity'];
						unset($items[$row_id]);
					}
					else
					{
						$group_similar[$hash] = $row_id;
					}
				}
			}
		}
		
		if ($orderby)
		{
			$orderby = $this->_xss_clean($orderby);
			
			switch($orderby)
			{
				case 'title':
				case 'quantity':
				case 'entry_id':
				case 'weblog_id':
					$callback = create_function('$x,$y', 'return strcmp(@$x["'.$orderby.'"],@$y["'.$orderby.'"]);');
					uasort($items, $callback);
					break;
				case 'price':
					$callback = array($this, '_compare_price');
					uasort($items, $callback);
					break;
				default:
					if (preg_match("/^item_options?:(.+)/", $orderby, $match))
					{
						$callback = create_function('$x,$y', 'return strcmp(@$x["item_options"]["'.$match[1].'"],@$y["item_options"]["'.$match[1].'"]);');
						uasort($items, $callback);
						break;
					}
			}
			
			unset($callback);
		}
		
		if (strtolower($sort) == 'desc')
		{
			$items = array_reverse($items, TRUE);
		}

		return $items;
	}
	
	function _compare_price($x, $y)
	{
		return $this->_get_item_price(@$x["entry_id"],@$x["row_id"]) > $this->_get_item_price(@$y["entry_id"],@$y["row_id"]);
	}

	function _get_coupon_code_data($coupon_code)
	{
		global $DB, $SESS;
		
		$this->_load_coupon_code_plugins();

		$data = array(
			'metadata' => array(
				'valid' => FALSE
			),
			'type' => ''
		);

		if ( ! empty($this->settings['coupon_code_weblog']) && ! empty($this->settings['coupon_code_type']))
		{
			$coupon_field = 't.title';

			if ( ! empty($this->settings['coupon_code_field']) && $this->settings['coupon_code_field'] != 'title')
			{
				$coupon_field = 'd.field_id_'.$this->settings['coupon_code_field'];
			}

			$query = $DB->query("SELECT *
						FROM exp_weblog_titles t
						JOIN exp_weblog_data d
						ON t.entry_id = d.entry_id
						WHERE t.weblog_id = '".$DB->escape_str($this->settings['coupon_code_weblog'])."'
						AND t.status != 'closed'
						AND $coupon_field = '".$DB->escape_str($coupon_code)."'
						LIMIT 1");

			$data['metadata']['entry_id'] = '';
			$data['metadata']['entry_date'] = '';
			$data['metadata']['expiration_date'] = '';
			$data['metadata']['inactive'] = FALSE;
			$data['metadata']['expired'] = FALSE;
			$data['metadata']['user_limit'] = FALSE;
			$data['metadata']['coupon_limit'] = FALSE;
			$data['metadata']['global_limit'] = FALSE;
			$data['metadata']['invalid'] = FALSE;

			if ($query->num_rows)
			{
				$data = $this->_unserialize($query->row['field_id_'.$this->settings['coupon_code_type']]);

				$data['metadata']['entry_id'] = $query->row['entry_id'];
				$data['metadata']['entry_date'] = $query->row['entry_date'];
				$data['metadata']['expiration_date'] = $query->row['expiration_date'];
				$data['metadata']['inactive'] = $this->_is_future($query->row['entry_date']);
				$data['metadata']['expired'] = $this->_is_expired($query->row['expiration_date']);
				$data['metadata']['user_limit'] = FALSE;
				$data['metadata']['coupon_limit'] = FALSE;
				$data['metadata']['invalid'] = FALSE;
				$data['metadata']['no_access'] = FALSE;
				$data['metadata']['invalid'] = FALSE;
				$data['metadata']['global_limit'] = ($this->_global_coupon_limit > 1 && count($this->_get_coupon_codes()) >= $this->_global_coupon_limit);
				$data['metadata']['valid'] = TRUE;

				$used_by = ( ! empty($data['used_by'])) ? preg_split('/,|\|/', $data['used_by']) : array();

				$array_count_values = array_count_values($used_by);

				$member_id = $SESS->userdata['member_id'];

				if ( ! empty($data['per_user_limit']) && isset($array_count_values[$member_id]) && ($array_count_values[$member_id] >= $data['per_user_limit']))
				{
					$data['metadata']['user_limit'] = TRUE;
				}

				if (isset($data['coupon_limit']) && $data['coupon_limit'] !== '' && $data['coupon_limit'] <= 0)
				{
					$data['metadata']['coupon_limit'] = TRUE;
				}
				
				if ( ! empty($data['member_groups']) && ! in_array($SESS->userdata['group_id'], preg_split('/,|\|/', $data['member_groups'])))
				{
						$data['metadata']['no_access'] = TRUE;
				}
				
				if ( ! empty($data['member_ids']) && ! in_array($SESS->userdata['member_id'], preg_split('/,|\|/', $data['member_ids'])))
				{
						$data['metadata']['no_access'] = TRUE;
				}

				unset($used_by, $member_id, $array_count_values);

				foreach ($data['metadata'] as $cond => $value)
				{
					if ( ! in_array($cond, array('entry_id', 'entry_date', 'expiration_date', 'valid')) && $value === TRUE)
					{
						$data['metadata']['valid'] = FALSE;
						break;
					}
				}

				if ($data['metadata']['valid'] && isset($this->CCP[$data['type']]) && $this->_method_exists($this->CCP[$data['type']], 'validate'))
				{
					$data['metadata']['valid'] = $this->CCP[$data['type']]->validate($coupon_code, $data);
					
					if ( ! $data['metadata']['valid'] && $this->_method_exists($this->CCP[$data['type']], 'message'))
					{
						$data['metadata']['msg'] = $this->CCP[$data['type']]->message();
					}
				}
			}
			else
			{
				$data['metadata']['invalid'] = TRUE;
			}
		}

		return $data;
	}

	function _get_coupon_codes()
	{
		$this->_session_start();

		if ( ! isset($_SESSION['cartthrob']['coupon_codes']))
		{
			$_SESSION['cartthrob']['coupon_codes'] = array();
		}

		return $_SESSION['cartthrob']['coupon_codes'];
	}

	function _get_coupon_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = FALSE)
	{
		if ( ! $coupon_code_data)
		{
			$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
		}
		
		$this->_load_coupon_code_plugins();

		$discount = 0;

		if ($this->_validate_coupon_code($coupon_code, $coupon_code_data))
		{
			if (isset($coupon_code_data['type']) && isset($this->CCP[$coupon_code_data['type']]) && $this->_method_exists($this->CCP[$coupon_code_data['type']], 'get_discount'))
			{
				$discount = $this->CCP[$coupon_code_data['type']]->get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data);
			}
		}

		return $discount;
	}

	function _get_coupon_type($coupon_code, $coupon_code_data = FALSE)
	{
		if ( ! $coupon_code_data)
		{
			$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
		}

		return ( ! empty($coupon_code_data['type'])) ? $coupon_code_data['type'] : FALSE;
	}
	/**
	 * _get_discount_values
	 * 
	 * returns 
	 * @return string 
	 * @author Newton
	 */
	function _get_discount_values($subtotal, $shipping)
	{
		global $DB, $SESS; 

		$this->_load_coupon_code_plugins();
		$discount = 0; 

		$discount_array = array(); 

		if ( ! empty($this->settings['discount_weblog']) && ! empty($this->settings['discount_type']))
		{
		
			$query = $DB->query("SELECT *
						FROM exp_weblog_titles t
						JOIN exp_weblog_data d
						ON t.entry_id = d.entry_id
						WHERE t.weblog_id = '".$DB->escape_str($this->settings['discount_weblog'])."'
						AND t.status != 'closed'");
								
								
			if ($query->num_rows)
			{
				foreach ($query->result as $row)
				{
					$data = array(
						'metadata' => array(
							'valid' => FALSE
						),
						'type' => ''
					);
					
					$data = $this->_unserialize($row['field_id_'.$this->settings['discount_type']]);
					
					
					$data['metadata']['entry_id'] 				= $row['entry_id'];
					$data['metadata']['entry_date'] 			= $row['entry_date'];
					$data['metadata']['expiration_date'] 		= $row['expiration_date'];
					$data['metadata']['inactive'] 				= $this->_is_future($row['entry_date']);
					$data['metadata']['expired'] 				= $this->_is_expired($row['expiration_date']);
					$data['metadata']['invalid'] 				= FALSE;
					$data['metadata']['no_access'] 				= FALSE;
					$data['metadata']['invalid'] 				= FALSE;
					$data['metadata']['valid'] 					= TRUE;

					$data['metadata']['user_limit'] = FALSE;
					$data['metadata']['coupon_limit'] = FALSE;

					$used_by = ( ! empty($data['used_by'])) ? preg_split('/,|\|/', $data['used_by']) : array();

					$array_count_values = array_count_values($used_by);

					$member_id = $SESS->userdata['member_id'];
					
					
					if ( ! empty($data['per_user_limit']) && isset($array_count_values[$member_id]) && ($array_count_values[$member_id] >= $data['per_user_limit']))
					{
						$data['metadata']['user_limit'] = TRUE;
						$data['metadata']['valid'] = FALSE;
						
					}

					if (isset($data['coupon_limit']) && $data['coupon_limit'] !== '' && $data['coupon_limit'] <= 0)
					{
						$data['metadata']['coupon_limit'] = TRUE;
						$data['metadata']['valid'] = FALSE;
						
					}


					$member_id = $SESS->userdata['member_id'];

					if ( ! empty($data['member_groups']) && ! in_array($SESS->userdata['group_id'], preg_split('/,|\|/', $data['member_groups'])))
					{
							$data['metadata']['no_access'] = TRUE;
							$data['metadata']['valid'] = FALSE;
							
					}

					if ( ! empty($data['member_ids']) && ! in_array($member_id, preg_split('/,|\|/', $data['member_ids'])))
					{
							$data['metadata']['no_access'] = TRUE;
							$data['metadata']['valid'] = FALSE;
							
					}

					unset($member_id);

					foreach ($data['metadata'] as $cond => $value)
					{
						if ( ! in_array($cond, array('entry_id', 'entry_date', 'expiration_date', 'valid')) && $value === TRUE)
						{
							$data['metadata']['valid'] = FALSE;
							break;
						}
					}

					if ($data['metadata']['valid'] && isset($this->CCP[$data['type']]) && $this->_method_exists($this->CCP[$data['type']], 'validate_discount'))
					{
						$data['metadata']['valid'] = $this->CCP[$data['type']]->validate($data['metadata']['entry_id'] , $data);
					}

					if ($data['metadata']['valid'])
					{
						$data['metadata']['discount'] = $this->CCP[$data['type']]->get_discount("1", $subtotal, $shipping, $data);
						$discount_array[] = $data; 
					}
				}
			}
		}
		return $discount_array; 
	}

	function _get_customer_info($prefix = FALSE, $return_shipping = TRUE, $get_custom_data = FALSE)
	{
		$this->_session_start();

		$customer_info = (isset($_SESSION['cartthrob']['customer_info'])) ? $_SESSION['cartthrob']['customer_info'] : array();
		
		if ($return_shipping)
		{
			$customer_info['shipping_option'] = $this->_get_shipping_option();
		}
		
		if ($prefix)
		{
			$temp = array();
			
			foreach ($customer_info as $key => $value)
			{
				$temp['customer_'.$key] = $value;
			}
			
			$customer_info = $temp;
			
			unset($temp);
		}
		$customer_info['member_id'] = $this->_get_member_id();

		if ($get_custom_data)
		{
			foreach ($this->_get_customer_custom_data() as $key => $value)
			{
				$customer_info['custom_data:'.$key] = $value;
			}
		}
		
		return $customer_info;
	}
	
	function _get_customer_custom_data()
	{
		$this->_session_start();
		
		return (isset($_SESSION['cartthrob']['custom_data'])) ? $_SESSION['cartthrob']['custom_data'] : array();
	}

	function _get_cache_data($cache, $type, $key)
	{
		global $SESS;

		return (isset($SESS->cache['cartthrob'][$cache][$type][$key])) ? $SESS->cache['cartthrob'][$cache][$type][$key] : FALSE;
	}

	function _get_field_data($type, $key)
	{
		$this->_load_field_data();

		return $this->_get_cache_data('fields', $type, $key);
	}

	function _get_field_id($field_name, $string = TRUE)
	{
		global $DB, $SESS;

		if ( ! $field_name)
		{
			return FALSE;
		}

		if (ctype_digit($field_name) || is_int($field_name))
		{
			$field_id = $field_name;
		}
		else
		{
			$this->_load_field_data();

			$field_id = $this->_get_field_data('field_id', $field_name);//$SESS->cache['cartthrob']['fields']['field_id'][$field_name];
		}

		if ($string === 'format' || $string === 'fmt' || $string === 'ft')
		{
			return 'field_ft_'.$field_id;
		}

		return ($string) ? 'field_id_'.$field_id : $field_id;
	}

	function _get_field_name($field_id)
	{
		global $DB, $SESS;

		if ( ! $field_id)
		{
			return FALSE;
		}

		if ( ! ctype_digit($field_id) && ! is_int($field_id))
		{
			return $field_id;
		}
		else
		{	
			$this->_load_field_data();

			return $this->_get_field_data('field_name', $field_id); //$SESS->cache['cartthrob']['fields']['field_name'][$field_id];
		}
	}

	function _get_field_label($field_id)
	{
		global $DB, $SESS;

		if ( ! $field_id)
		{
			return FALSE;
		}

		if ( ! ctype_digit($field_id) && ! is_int($field_id))
		{
			return $field_id;
		}
		else
		{	
			$this->_load_field_data();

			return $this->_get_field_data('field_label', $field_id); //$SESS->cache['cartthrob']['fields']['field_name'][$field_id];
		}
	}

	function _get_field_fmt($field_id)
	{
		global $DB, $SESS;

		$this->_load_field_data();

		return $this->_get_field_data('field_fmt', $field_id); //$SESS->cache['cartthrob']['fields']['field_fmt'][$field_id];
	}

	function _get_field_group($weblog_id)
	{
		global $DB, $SESS;

		$this->_load_field_data();

		return $this->_get_field_data('group_id', $weblog_id);

		/*
		$query = $DB->query("SELECT field_group FROM exp_weblogs WHERE weblog_id='".$DB->escape_str($weblog_id)."' LIMIT 1");

		return ($query->num_rows) ? $query->row['field_group'] : '';
		*/
	}

	function _get_fields_by_group($group_id)
	{
		$this->_load_field_data();

		return $this->_get_field_data('fields_by_group', $group_id);
	}

	function _get_fields_by_weblog($weblog_id)
	{
		$this->_load_field_data();

		return $this->_get_fields_by_group($this->_get_field_group($weblog_id));
	}

	function _get_field_type($field_id)
	{
		global $DB, $SESS;

		$field_id = $this->_get_field_id($field_id, FALSE);

		if ( ! isset($SESS->cache['cartthrob']['fields']['field_type'][$field_id]))
		{
			$this->_load_field_data();
		}

		if ( ! isset($SESS->cache['cartthrob']['fields']['field_type'][$field_id]))
		{
			return FALSE;
		}

		if (preg_match('/^ftype_id_([0-9]+)/', $SESS->cache['cartthrob']['fields']['field_type'][$field_id], $match))
		{
			if (isset($SESS->cache['cartthrob']['fields']['fieldframe'][$field_id]))
			{
				return $SESS->cache['cartthrob']['fields']['fieldframe'][$field_id];
			}

			$query = $DB->query("SELECT class FROM exp_ff_fieldtypes WHERE fieldtype_id = '".$match[1]."' LIMIT 1");

			$SESS->cache['cartthrob']['fields']['fieldframe'][$field_id] = $query->row['class'];

			return $query->row['class'];
		}

		return $SESS->cache['cartthrob']['fields']['field_type'][$field_id];
	}

	function _get_ff_settings($field_id)
	{
		global $DB, $SESS;

		if (isset($SESS->cache['cartthrob']['fields']['ff_settings'][$field_id]))
		{
			return $SESS->cache['cartthrob']['fields']['ff_settings'][$field_id];
		}

		$query = $DB->query("SELECT ff_settings FROM exp_weblog_fields WHERE field_id = '".$DB->escape_str($field_id)."' LIMIT 1");

		if ( ! $query->num_rows)
		{
			return FALSE;
		}

		$SESS->cache['cartthrob']['fields']['ff_settings'][$field_id] = $this->_unserialize($query->row['ff_settings']);

		return $SESS->cache['cartthrob']['fields']['ff_settings'][$field_id];
	}
	
	function _get_formatted_phone($phone)
	{
		$phone = preg_replace("/[^0-9]/", "", $phone);
	    if (strlen($phone) == 7) 
		{
	      $phone =  preg_replace("/([0-9]{3})([0-9]{4})/", "$1$2", $phone);
	    } 
		elseif (strlen($phone) == 10) 
		{
	      $phone = preg_replace("/([0-9]{3})([0-9]{3})([0-9]{4})/", "$1$2$3", $phone);
	    } 
		$return['international']="";	
		$return['area_code'] = ""; 
		$return['prefix'] = "";
		$return['suffix'] = "";
		
		if (strlen($phone)>10)
		{
			$return['international'] = substr($phone, 0, -10);
		}
		if (strlen($phone)>=10)
		{
			$return['area_code'] = substr($phone, -10, 3);
		}
		if (strlen($phone)>=7)
		{
			$return['prefix'] = substr($phone, -7, 3);
		}
		if (strlen($phone)>4)
		{
			$return['suffix'] = substr($phone, -4, 4);
		}
		return $return; 
	}

	function _get_global_price($entry_id, $weblog_id = NULL)
	{
		if ( ! $weblog_id)
		{
			$weblog_id = $this->_get_weblog_id_from_entry_id($entry_id);
		}

		if ( ! empty($this->settings['product_weblog_fields'][$weblog_id]['global_price']))
		{
			return $this->_sanitize_number($this->settings['product_weblog_fields'][$weblog_id]['global_price']);
		}
		else
		{
			return FALSE;
		}
	}

	function _get_inventory_field($weblog_id, $type='id')
	{
		if ( ! $weblog_id || ! isset($this->settings['product_weblog_fields'][$weblog_id]['inventory']))
		{
			return '';
		}

		switch ($type)
		{
			case 'id':
				return $this->settings['product_weblog_fields'][$weblog_id]['inventory'];
				break;
			case 'field_id':
				return 'field_id_'.$this->settings['product_weblog_fields'][$weblog_id]['inventory'];
				break;
			case 'name':
				return $this->_get_field_name($this->settings['product_weblog_fields'][$weblog_id]['inventory']);
				break;
			default:
				return '';
		}
	}
	// END
	
	/**
	 * _get_notify_url
	 * 
	 * returns the url to be used for 3-secure and off-site payment systems. 
	 * 
	 * @access private
	 * @since 1.0
	 * @param string $gateway_class_name
	 * @param string $redirect 
	 * @return string
	 * @author Chris Newton
	 */
	function _get_notify_url($gateway_class_name, $type=NULL)
	{
		global $PREFS, $DB, $LANG, $OUT, $FNS; 

		$qs = ($PREFS->ini('force_query_string') == 'y') ? '' : '?';
		
		$gateway_class_name = str_replace("Cartthrob_","",$gateway_class_name);
		
		if ($this->settings['encode_gateway_selection'])
		{
			// CAN'T use standard encode_string function becaue this function is used in the extensions settings. extension can't correctly reference $this->_encode_string(); 
			if ( function_exists('mcrypt_encrypt') )
			{
				$init_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
				$init_vect = mcrypt_create_iv($init_size, MCRYPT_RAND);
				$gateway_class_name = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($DB->username.$DB->password), $gateway_class_name, MCRYPT_MODE_ECB, $init_vect);
			}
			else
			{
				$gateway_class_name = $gateway_class_name.md5($DB->username.$DB->password.$gateway_class_name);
			}
			$gateway_class_name= base64_encode($gateway_class_name);
		}
		
		$gateway_class_name = urlencode($gateway_class_name);

		$notify_url = $FNS->fetch_site_index(0, 0).$qs.'ACT='.$FNS->insert_action_ids($FNS->fetch_action_id('Cartthrob', 'payment_return')).'&gateway='.$gateway_class_name;

		if ($type)
		{
			$notify_url .= "&method=".trim(urlencode($type));
		}
		return $notify_url; 
	}
	function _get_item($entry_id)
	{
		return $this->_get_item_data($entry_id);
	}

	/**
	 * Returns associative array of an item's data, including custom field data and categories
	 *
	 * @access private
	 * @param int $entry_id
	 * @return array
	 */
	function _get_item_data($entry_id, $row_id = FALSE)
	{
		global $DB, $SESS;

		$cart_item = $this->_get_cart_item($entry_id, $row_id);

		if ($this->_is_item_on_the_fly($cart_item))
		{
			return $cart_item;
		}

		if ( ! $this->_validate_entry_id($entry_id))
		{
			return array();
		}

		if (isset($SESS->cache['cartthrob']['items'][$entry_id]))
		{
			return $SESS->cache['cartthrob']['items'][$entry_id];
		}

		$field_sql = 't.*, d.*';

		$this->_load_field_data();

		if ( ! empty($cart_item['weblog_id']))
		{
			$fields = $this->_get_fields_by_weblog($cart_item['weblog_id']);

			if ($fields !== FALSE)
			{
				foreach ($fields as $field_id)
				{
					$field_sql .= ', d.field_id_'.$field_id.' as `'.$this->_get_field_name($field_id).'`';
				}
			}
		}

		$query = $DB->query("SELECT ".$field_sql."
					FROM exp_weblog_titles t
					LEFT JOIN exp_weblog_data d
					ON d.entry_id = t.entry_id
					WHERE t.entry_id='".$DB->escape_str($entry_id)."'
					LIMIT 1");

		if ( ! $query->num_rows)
		{
			return array();
		}

		/*
		foreach ($query->row as $key => $value)
		{
			if (preg_match('/^field_id_([0-9]+)/', $key, $match) && isset($SESS->cache['cartthrob']['fields']['field_name'][$match[1]]))
			{
				$query->row[$SESS->cache['cartthrob']['fields']['field_name'][$match[1]]] = $value;
			}
		}
		*/

		$query->row['categories'] = array();

		/*
		$cat_query = $DB->query("SELECT c.cat_id as category_id, c.cat_name
						FROM exp_category_posts p
						JOIN exp_categories c
						ON p.cat_id = c.cat_id
						WHERE p.entry_id='".$DB->escape_str($entry_id)."'");

		foreach ($cat_posts_query->result as $row)
		{
			$cat_query = $DB->query("SELECT * FROM exp_categories WHERE cat_id='".$DB->escape_str($row['cat_id'])."' LIMIT 1");

			foreach ($cat_query->result as $cat_row)
			{
				foreach ($cat_row as $key => $value)
				{
					if (preg_match('/^cat_/', $key))
					{
						$cat_row[str_replace('cat_', 'category_', $key)] = $value;
					}
				}

				$query->row['categories'][] = $cat_row;
			}
		}
		*/

		$SESS->cache['cartthrob']['items'][$entry_id] = $query->row;

		return $query->row;
	}

	function _get_item_inventory($entry_id, $row_id = FALSE, $item_options = array())
	{
		$item = $this->_get_item_data($entry_id, $row_id);
		
		$inventory = FALSE;

		if ( ! empty($item['weblog_id']))
		{
			$inventory_field = $this->_get_inventory_field($item['weblog_id'], 'id');
		
			if ($inventory_field)
			{
				$field_type = $this->_get_field_type($inventory_field);
				
				if ($field_type == 'ct_price_mod' || $field_type == 'ff_matrix' || $field_type == 'matrix')
				{
					$field_name = $this->_get_field_name($inventory_field);
					
					if ($field_type == 'ff_matrix')
					{
						$price_modifiers = $this->_parse_ff_matrix_price_modifier($field_name, $item['field_id_'.$inventory_field], $this->_get_ff_settings($inventory_field));
					}
					elseif ($field_type == 'matrix')
					{
						$price_modifiers = $this->_parse_matrix_price_modifier($field_name, $item['field_id_'.$inventory_field], $this->_get_ff_settings($inventory_field), $entry_id);
					}
					else
					{
						$price_modifiers = $this->_unserialize($item['field_id_'.$inventory_field]);
					}
					
					foreach ($price_modifiers as $price_modifier)
					{
						if (isset($price_modifier['inventory']) && $price_modifier['inventory'] !== '' && isset($item_options[$field_name]) && $item_options[$field_name] == $price_modifier['option'])
						{
							$inventory = $this->_sanitize_number($price_modifier['inventory']);
						}
					}
				}
				elseif (isset($item['field_id_'.$inventory_field]) && $item['field_id_'.$inventory_field] !== '')
				{
					$inventory = $this->_sanitize_number($item['field_id_'.$inventory_field]);
				}
			}
		}

		return $inventory;
	}

	function _get_item_options($entry_id, $row_id = FALSE)
	{
		$item = $this->_get_cart_item($entry_id, $row_id);

		return (isset($item['item_options'])) ? $item['item_options'] : FALSE;
	}

	/**
	 * _get_item_price
	 *
	 * @param string $entry_id item entry id
	 * @param string $row_id cart item row id
	 * @return string item price 
	 * @access private
	 * @author Rob Sanchez & Chris Newton
	 * @since 1.0
	 *  
	 * v.384 Added cartthrob_get_item_price hook
	 */
	function _get_item_price($entry_id, $row_id = FALSE)
	{
		global $EXT;
		
		$item = $this->_get_item_data($entry_id, $row_id);

		$cart_item = $this->_get_cart_item($entry_id, $row_id);

		if ( ! empty($item['on_the_fly']) && isset($item['price']))
		{
			return $this->_sanitize_number($item['price']);
		}
		else
		{
			// -------------------------------------------
			// 'cartthrob_get_item_price' hook.
			//  - Developers, if you want to modify the $this object remember
			//	to use a reference on function call.
			// added version 384
			//
			$this->_session_start();

			if ($EXT->active_hook('cartthrob_get_item_price') === TRUE)
			{
				$price = $EXT->universal_call_extension('cartthrob_get_item_price', $this, $_SESSION['cartthrob'], $cart_item, $item, $entry_id, $row_id);
				
				if ($price !== '' && $price !== FALSE)
				{
					return $this->_sanitize_number($price);
				}
			}
			// END hook
			
			$field_id = $this->_get_price_field($item['weblog_id'], 'id');
			$field_type = $this->_get_field_type($field_id);

			if ($field_type == 'ct_matrix_pq')
			{
				$quantity = $this->_get_item_quantity($entry_id, $row_id);

				$data = array_merge($this->_unserialize($item['field_id_'.$field_id]));

				for ($i = 0; $i < count($data); $i++)
				{
					// if quantity is within the thresholds
					// OR if we get to the end of the array
					// the last row will set the price, no matter what
					if (($quantity >= $data[$i]['from_quantity'] && $quantity <= $data[$i]['up_to_quantity']) || $i + 1 == count($data))
					{
						return $data[$i]['price'];
					}
				}

				return 0;
			}
			
			
			if ( ! empty($item['weblog_id']) && ! empty($this->settings['product_weblog_fields'][$item['weblog_id']]['global_price']))
			{
				return $this->_sanitize_number($this->settings['product_weblog_fields'][$item['weblog_id']]['global_price']);
			}
			elseif (isset($cart_item['price']) && $cart_item['price'] !== FALSE && ($cart_item['price'] || $cart_item['price'] === 0))
			{
				$price = $cart_item['price'];
				
				if ( ! empty($item['weblog_id']) && ! empty($item['allow_price_modifiers']))
				{
					foreach ($this->_get_all_price_modifiers($entry_id) as $price_modifier)
					{
						if (isset($cart_item['item_options'][$price_modifier['option_name']]) &&
							$cart_item['item_options'][$price_modifier['option_name']] == $price_modifier['option'])
						{
							$price += $this->_sanitize_number($price_modifier['price'], TRUE);
						}
					}
				}
				
				return $price;
			}
			elseif( ! empty($item['weblog_id']))
			{
				$price_field = $this->_get_price_field($item['weblog_id'], 'field_id');

				$price = ($price_field && isset($item[$price_field])) ? $this->_sanitize_number($item[$price_field]) : 0;

				foreach ($this->_get_all_price_modifiers($entry_id) as $price_modifier)
				{
					if (isset($cart_item['item_options'][$price_modifier['option_name']]) &&
						$cart_item['item_options'][$price_modifier['option_name']] == $price_modifier['option'])
					{
						$price += $this->_sanitize_number($price_modifier['price'], TRUE);
					}
				}

				return $price;
			}
			else
			{
				return 0;
			}
		}
		/*
		$weblog_id = (isset($item['weblog_id'])) ? $item['weblog_id'] : NULL;

		$global_price = $this->_get_global_price($entry_id, $weblog_id);

		if ($global_price !== FALSE)
		{
			return $this->_sanitize_number($global_price);
		}
		else
		{
			$price_field = ($this->_is_item_on_the_fly($item)) ? 'price' : $this->_get_price_field($weblog_id, 'field_id');

			return ($price_field && isset($item[$price_field])) ? $this->_sanitize_number($item[$price_field]) : 0;
		}
		*/
		return 0;
	}

	function _get_item_quantity($entry_id, $row_id = FALSE)
	{
		if ($row_id === FALSE)
		{
			$row_id = $this->_item_in_cart($entry_id);
		}

		if ($row_id === FALSE)
		{
			return 0;
		}

		$items = $this->_get_items();

		return (isset($items[$row_id])) ? $items[$row_id]['quantity'] : 0;
	}

	function _get_item_quantity_all($entry_id)
	{
		$quantity = 0;

		if ($this->_validate_entry_id($entry_id))
		{
			foreach ($this->_get_items() as $item)
			{
				if (isset($item['entry_id']) && $item['entry_id'] == $entry_id)
				{
					$quantity += $item['quantity'];
				}
			}
		}

		return $quantity;
	}

	function _get_item_shipping($entry_id, $row_id = FALSE)
	{
		$item = $this->_get_cart_item($entry_id, $row_id);

		if ( ! empty($item['no_shipping']))
		{
			return 0;
		}
		
		if (isset($item['shipping']))
		{
			return $item['shipping'];
		}
		
		$item = $this->_get_item_data($entry_id, $row_id);
		
		$shipping_field = $this->_get_field_name(@$this->settings['product_weblog_fields'][$this->_get_weblog_id_from_entry_id($entry_id)]['shipping']);

		return ($shipping_field && isset($item[$shipping_field])) ? $item[$shipping_field] : 0;
	}

	function _get_item_subtotal($entry_id, $row_id = FALSE)
	{
		return $this->_get_item_price($entry_id, $row_id) * $this->_get_item_quantity($entry_id, $row_id);
	}

	function _get_item_weight($entry_id, $row_id = FALSE)
	{
		$item = $this->_get_cart_item($entry_id, $row_id);
		
		if (isset($item['weight']))
		{
			return $item['weight'];
		}
		
		$item = $this->_get_item_data($entry_id, $row_id);

		$weight_field = $this->_get_field_name(@$this->settings['product_weblog_fields'][$this->_get_weblog_id_from_entry_id($entry_id)]['weight']);

		return ($weight_field && isset($item[$weight_field])) ? $item[$weight_field] : 0;
	}
	
	function _get_language_abbrev($language)
	{
		foreach ($this->languages as $abbrev => $full)
		{
			if (strtolower($language) === strtolower($full))
			{
				return $abbrev;
			}
		}
	}


	/**
	 * Returns the member id of the current user
	 * If logged out, it will return the member id of the oldest superadmin
	 * 
	 * @access private
	 * @return int
	 */
	function _get_member_id()
	{
		global $DB, $SESS;

		if ($SESS->userdata['member_id'])
		{
			return $SESS->userdata['member_id'];
		}
		elseif ($this->settings['default_member_id'] && (ctype_digit($this->settings['default_member_id']) || is_int($this->settings['default_member_id'])))
		{
			return $this->settings['default_member_id'];
		}
		else
		{
			if (isset($SESS->cache['cartthrob']['member_id']))
			{
				return $SESS->cache['cartthrob']['member_id'];
			}
			else
			{
				//get the lowest numbered superadmin
					$query = $DB->query("SELECT member_id FROM exp_members WHERE group_id = 1 ORDER BY member_id ASC LIMIT 1");

				$SESS->cache['cartthrob']['member_id'] = $query->row['member_id'];

				return $query->row['member_id'];
			}
		}
	}

	/**
	 * get_payment_processor_url
	 *
	 * Gets the payment processor url from 
	 * the gateway_info of the currently loaded payment gateway
	 * @return string
	 * @access private
	 * @since 1.0.0
	 * @author Chris Newton
	 */
	function _get_payment_processor_url()
	{
		global $IN;

		$gateway =  $this->_xss_clean($IN->GBL('gateway', 'POST'));

		$this->_load_payment_gateway($gateway);

		if (isset($this->PG->gateway_info['processor_url']))
		{
			$processor_url = $this->PG->gateway_info['processor_url']; 
		}
		else
		{
			return FALSE;
		}

		return $processor_url; 
	}

	function _get_plugin_classname($filename)
	{
		$filename = str_replace(array('cartthrob.', 'Cartthrob_', '.php', 'cartthrob_'), array('', '', '', ''), $filename);

		return 'Cartthrob_'.$filename;
	}

	function _get_plugin_filename($classname)
	{
		return 'cartthrob.'.str_replace('cartthrob_', '', strtolower($classname)).'.php';
	}

	function _get_plugin_name($filename)
	{
		return str_replace(array('cartthrob.', '.php', 'Cartthrob_'), '', $filename);
	}

	function _get_post_by_row_id($key, $row_id)
	{
		global $REGX;

		if (isset($_POST[$key][$row_id]))
		{
			if (is_array($_POST[$key][$row_id]))
			{
				foreach ($_POST[$key][$row_id] as $k => $v)
				{
					$_POST[$key][$row_id][$k] = $REGX->xss_clean($v);
				}

				return $_POST[$key][$row_id];
			}
			else
			{
				return $REGX->xss_clean($_POST[$key][$row_id]);
			}
		}

		return FALSE;
	}
	
	function _get_price_field($weblog_id, $type='id')
	{
		if ( ! $weblog_id)
		{
			return '';
		}
		
		if ( ! isset($this->settings['product_weblog_fields'][$weblog_id]['price']))
		{
			return '';
		}
		
		$price_field = $this->settings['product_weblog_fields'][$weblog_id]['price'];
		
		/*
		if (($price_field = ($this->_get_price_override_field($weblog_id))) === FALSE)
		{
			if ( ! isset($this->settings['product_weblog_fields'][$weblog_id]['price']))
			{
				return '';
			}
			
			$price_field = $this->settings['product_weblog_fields'][$weblog_id]['price'];
		}
		*/

		switch ($type)
		{
			case 'id':
				return $price_field;
				break;
			case 'field_id':
				return 'field_id_'.$price_field;
				break;
			case 'name':
				return $this->_get_field_name($price_field);
				break;
			default:
				return '';
		}
	}
	/**
	 * get_purchased_items
	 *
	 * Gets purchased items entry ids using the order's entry id
	 * @param string $order_id 
	 * @return array
	 * @author Chris Newton
	 * @since 1.0
	 */
	function _get_purchased_items($order_id)
	{
		global $DB;

		$purchased_items = array(); 
		if (isset($this->settings['orders_items_field']))
		{
			$field_id 		= $this->_get_field_id($this->settings['purchased_items_order_id_field'], "field_id"); 

			$query = $DB->query("SELECT entry_id FROM exp_weblog_data WHERE ".$field_id."='".$DB->escape_str($order_id)."'");
			
			if ($query->result)
			{
				foreach($query->result as $row)
				{
					if (!empty($row['entry_id']))
					{
						$purchased_items[] = $row['entry_id']; 
						
					}
				}
			}
		}
		return $purchased_items;
	}
	function _get_all_price_modifiers($entry_id)
	{
		global $DB;
		
		$price_modifiers = array();

		$item = $this->_get_item_data($entry_id);

		if ( ! isset($this->settings['product_weblog_fields'][$item['weblog_id']]['price_modifiers']))
		{
			return array();
		}

		$price_modifier_fields = $this->settings['product_weblog_fields'][$item['weblog_id']]['price_modifiers'];

		// -------------------------------------------
		// 'cartthrob_add_modifier_fields' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		global $EXT;
		$this->_session_start();

		if ($EXT->active_hook('cartthrob_get_all_price_modifiers') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_get_all_price_modifiers', $this, $_SESSION['cartthrob'], $price_modifier_fields, $item);
			if ($EXT->end_script === TRUE) return;
			if (is_array($edata))
			{
				$price_modifiers = array_merge($edata,$price_modifiers);
			}
		}
		
		foreach ($price_modifier_fields as $field_id)
		{
			$field_name = $this->_get_field_name($field_id);

			if ( ! $field_name || empty($item[$field_name]))
			{
				continue;
			}

			$field_type = $this->_get_field_type($field_id);

			if ($field_type == 'ct_price_mod' && $item[$field_name])
			{
				$field_data = $this->_unserialize($item[$field_name]);

				if (is_array($field_data))
				{
					foreach ($field_data as $key => $options)
					{
						$field_data[$key]['option_label'] = $field_data[$key]['option_name'];
						$field_data[$key]['option_name'] = $field_name;
					}

					$price_modifiers = array_merge($price_modifiers, $field_data);
				}
			}
			elseif ($field_type == 'ff_matrix' && $ff_settings = $this->_get_ff_settings($field_id))
			{
				$field_data = $this->_unserialize($item[$field_name]);

				foreach ($field_data as $index => $row)
				{
					$single_data = array(
						'option_name' => '',
						'option' => '',
						'price' => 0,
						'option_label' => '',
						'inventory' => ''
					);

					foreach ($ff_settings['cols'] as $key => $matrix_field)
					{
						if (array_key_exists($matrix_field['name'], $single_data))
						{
							$single_data[$matrix_field['name']] = $row[$key];
						}

						if ($matrix_field['name'] == 'option_name')
						{
							$single_data['option_label'] = $row[$key];
						}
					}

					$single_data['option_name'] = $field_name;

					$price_modifiers[] = $single_data;
				}
			}
			elseif ($field_type == 'matrix' && $ff_settings = $this->_get_ff_settings($field_id))
			{
				if (empty($item[$field_name]) || empty($ff_settings['col_ids']))
				{
					continue;
				}
				
				$query = $DB->query("SELECT * FROM exp_matrix_data WHERE field_id = '".$DB->escape_str($field_id)."' AND entry_id = '".$DB->escape_str($entry_id)."'");
				
				if ( ! $query->num_rows)
				{
					continue;
				}
				
				$field_data = $query->result;
					
				$query = $DB->query("SELECT * FROM exp_matrix_cols WHERE col_id IN ('".implode("','", $ff_settings['col_ids'])."')");
				
				if ( ! $query->num_rows)
				{
					continue;
				}
				
				$cols = $query->result;

				foreach ($field_data as $index => $row)
				{
					$single_data = array(
						'option_name' => '',
						'option' => '',
						'price' => 0,
						'option_label' => '',
						'inventory' => ''
					);

					foreach ($cols as $col)
					{
						if (array_key_exists($col['col_name'], $single_data))
						{
							$single_data[$col['col_name']] = $row['col_id_'.$col['col_id']];
						}

						if ($col['col_name'] == 'option_name')
						{
							$single_data['option_label'] = $row['col_id_'.$col['col_id']];
						}
					}

					$single_data['option_name'] = $field_name;

					$price_modifiers[] = $single_data;
				}
			}
		}

		return $price_modifiers;
	}
	
	/**
	 * _get_redirect
	 *
	 * Reads the return or redirect param. This was created to handle a parameter change from redirect to return.
	 * The parameter was originally changed to align with similar EE parameter ('return') 
	 * 
	 * @access private
	 * @return string
	 * @since 1.0
	 * @author Chris Newton
	 */
	function _get_redirect_url()
	{
		if ($this->_fetch_param('return'))
		{
			return str_replace(SLASH,'/',$this->_fetch_param('return')); 
		}
		elseif ($this->_fetch_param('redirect'))
		{
			return str_replace(SLASH,'/',$this->_fetch_param('redirect')); 
		}
		return FALSE; 
	}

	function _get_related_id($entry_id)
	{
		global $DB, $SESS;

		$query = $DB->query("SELECT rel_parent_id FROM exp_relationships WHERE rel_child_id='$entry_id'");

		foreach ($query->result as $row)
		{
			$title_query = $DB->query("SELECT author_id FROM exp_weblog_titles WHERE entry_id='".$row['rel_parent_id']."' LIMIT 1");

			foreach ($title_query->result as $title_row)
			{
				if ($SESS->userdata['member_id'] == $title_row['author_id'])
				{
					return $row['rel_parent_id'];
				}
			}
		}

		return 0;
	}

	function _get_saved_order()
	{
		$this->_session_start();

		return (isset($_SESSION['cartthrob']['order'])) ? $_SESSION['cartthrob']['order'] : FALSE;
	}

	/**
	 * Retrieve settings from companion extension
	 *
	 * @access private
	 * @return array
	 */
	function _get_settings()
	{	
		global $DB, $EXT, $REGX, $PREFS, $SESS;
		
		if (isset($SESS->cache['cartthrob']['settings'][$PREFS->ini('site_id')]))
		{
			return $SESS->cache['cartthrob']['settings'][$PREFS->ini('site_id')];
		}

		$settings = array();

		$query = $DB->query("SELECT settings
				    FROM exp_extensions
				    WHERE enabled = 'y'
				    AND class = '".$this->_extension_classname."'
				    LIMIT 1");

		if ($query->num_rows && $query->row['settings'])
		{
			$settings = $REGX->array_stripslashes($this->_unserialize($query->row['settings']));
		}

		if (isset($settings[$PREFS->ini('site_id')]))
		{
			$settings = $settings[$PREFS->ini('site_id')];
		}

		foreach ($this->default_settings as $key => $value)
		{
			if ( ! isset($settings[$key]))
			{
				$settings[$key] = $value;
			}
		}
		
		$SESS->cache['cartthrob']['settings'][$PREFS->ini('site_id')] = $settings;

		return $settings;
	}
	
	function _get_shippable_items()
	{
		$items = array();
		
		foreach ($this->_get_cart_items() as $row_id => $item)
		{
			if (empty($item['no_shipping']))
			{
				$items[$row_id] = $item;
			}
		}
		
		return $items;
	}

	function _get_shipping_option()
	{
		$this->_session_start();

		$this->_calculate_shipping();

		return isset($_SESSION['cartthrob']['shipping']['shipping_option']) ? $_SESSION['cartthrob']['shipping']['shipping_option'] : '';
	}

	function _get_tax_rate($percentage = FALSE, $prefix = '')
	{
		global $IN;

		$tax_settings = $this->_get_tax_settings();

		$customer_info = $this->_get_customer_info();

		$tax_rate = 0;

		if ( ! isset($customer_info[$prefix.'state']))
		{
			$customer_info[$prefix.'state'] = $IN->GBL($prefix.'state');
		}
		if ( ! isset($customer_info[$prefix.'country_code']))
		{
			$customer_info[$prefix.'country_code'] = $IN->GBL($prefix.'country_code');
		}
		if ( ! isset($customer_info[$prefix.'zip']))
		{
			$customer_info[$prefix.'zip'] = $IN->GBL($prefix.'zip');
		}
		if ( ! isset($customer_info[$prefix.'region']))
		{
			$customer_info[$prefix.'region'] = $IN->GBL($prefix.'region');
		}

		//zip code first
		if ( ! empty($customer_info[$prefix.'zip']) && array_key_exists($customer_info[$prefix.'zip'], $tax_settings))
		{
			$tax_rate = $tax_settings[$customer_info[$prefix.'zip']];
		}
		elseif ( ! empty($customer_info[$prefix.'region']) && array_key_exists($customer_info[$prefix.'region'], $tax_settings))
		{
			$tax_rate = $tax_settings[$customer_info[$prefix.'region']];
		}
		elseif ( ! empty($customer_info[$prefix.'state']) && array_key_exists($customer_info[$prefix.'state'], $tax_settings))
		{
			$tax_rate = $tax_settings[$customer_info[$prefix.'state']];
		}
		elseif ( ! empty($customer_info[$prefix.'country_code']) && array_key_exists($customer_info[$prefix.'country_code'], $tax_settings))
		{
			$tax_rate = $tax_settings[$customer_info[$prefix.'country_code']];
		}
		elseif (array_key_exists('global', $tax_settings))
		{
			$tax_rate = $tax_settings['global'];
		}

		return ($percentage) ? $tax_rate : ($tax_rate/100);
	}

	function _get_tax_name()
	{
		global $IN;

		$tax_names = $this->_get_tax_names();

		$customer_info = $this->_get_customer_info();

		$tax_name = '';

		if ( ! isset($customer_info['state']))
		{
			$customer_info['state'] = $IN->GBL('state');
		}
		if ( ! isset($customer_info['country_code']))
		{
			$customer_info['country_code'] = $IN->GBL('country_code');
		}
		if ( ! isset($customer_info['zip']))
		{
			$customer_info['zip'] = $IN->GBL('zip');
		}
		if ( ! isset($customer_info['region']))
		{
			$customer_info['region'] = $IN->GBL('region');
		}

		//zip code first
		if ( ! empty($customer_info['zip']) && array_key_exists($customer_info['zip'], $tax_names))
		{
			$tax_name = $tax_names[$customer_info['zip']];
		}
		elseif ( ! empty($customer_info['region']) && array_key_exists($customer_info['region'], $tax_names))
		{
			$tax_name = $tax_names[$customer_info['region']];
		}
		elseif ( ! empty($customer_info['state']) && array_key_exists($customer_info['state'], $tax_names))
		{
			$tax_name = $tax_names[$customer_info['state']];
		}
		elseif ( ! empty($customer_info['country_code']) && array_key_exists($customer_info['country_code'], $tax_names))
		{
			$tax_name = $tax_names[$customer_info['country_code']];
		}
		elseif (array_key_exists('global', $tax_names))
		{
			$tax_name = $tax_names['global'];
		}

		return $tax_name;
	}

	function _get_tax_shipping()
	{
		global $IN;

		if (empty($this->settings['tax_settings']) || ! is_array($this->settings['tax_settings']))
		{
			return FALSE;
		}

		$customer_info = $this->_get_customer_info();

		$tax_shipping = array();

		foreach ($this->settings['tax_settings'] as $setting)
		{
			if ( ! empty($setting['tax_shipping']))
			{
				$locale = ($setting['state']) ? $setting['state'] : $setting['zip'];

				if ($locale)
				{
					$tax_shipping[] = $locale;
				}
			}
		}

		if ( ! count($tax_shipping))
		{
			return FALSE;
		}

		if (empty($customer_info['state']))
		{
			$customer_info['state'] = $IN->GBL('state');
		}
		if (empty($customer_info['country_code']))
		{
			$customer_info['country_code'] = $IN->GBL('country_code');
		}
		if (empty($customer_info['zip']))
		{
			$customer_info['zip'] = $IN->GBL('zip');
		}
		if (empty($customer_info['region']))
		{
			$customer_info['region'] = $IN->GBL('region');
		}

		//zip code first
		if ($customer_info['zip'] && in_array($customer_info['zip'], $tax_shipping))
		{
			return TRUE;
		}
		elseif ($customer_info['region'] && in_array($customer_info['region'], $tax_shipping))
		{
			return TRUE;
		}
		elseif ($customer_info['state'] && in_array($customer_info['state'], $tax_shipping))
		{
			return TRUE;
		}
		elseif ($customer_info['country_code'] && in_array($customer_info['country_code'], $tax_shipping))
		{
			return TRUE;
		}
		elseif (in_array('global', $tax_shipping))
		{
			return TRUE;
		}

		return FALSE;
	}

	function _get_tax_settings()
	{
		$tax_settings = array();

		if ( ! is_array($this->settings['tax_settings']))
		{
			//$raw_settings = explode("\r", str_replace("\n", "\r", str_replace("\r\n", "\r", $this->_tax_settings)));

			$raw_settings = $this->_textarea_to_array($this->settings['tax_settings']);

			foreach ($raw_settings as $raw_setting)
			{
				if (strpos($raw_setting, ':') !== FALSE)
				{
					$raw_setting = explode(':', $raw_setting);

					$locale = $raw_setting[0];

					$rate = (float) $raw_setting[1];

					//determine whether user put in actual rate, or percentage
					//ie. 8.75 vs. .0875
					$rate = ($rate < 1) ? ($rate*100) : $rate;

					$tax_settings[$locale] = $rate;
				}
			}
		}
		else
		{
			foreach ($this->settings['tax_settings'] as $setting)
			{
				$locale = ($setting['state']) ? $setting['state'] : $setting['zip'];

				if ($locale)
				{
					//determine whether user put in actual rate, or percentage
					//ie. 8.75 vs. .0875
					$setting['rate'] = ($setting['rate'] < 1) ? ($setting['rate']*100) : $setting['rate'];

					$tax_settings[$locale] = $setting['rate'];
				}
			}
		}

		return $tax_settings;
	}

	function _get_tax_names()
	{
		$tax_names = array();

		if (is_array($this->settings['tax_settings']))
		{
			foreach ($this->settings['tax_settings'] as $setting)
			{
				$locale = ($setting['state']) ? $setting['state'] : $setting['zip'];

				if ($locale)
				{
					$tax_names[$locale] = $setting['name'];
				}
			}
		}

		return $tax_names;
	}
	
	function _get_taxable_items()
	{
		$items = array();
		
		foreach ($this->_get_cart_items() as $row_id => $item)
		{
			if (empty($item['no_tax']))
			{
				$items[$row_id] = $item;
			}
		}
		
		return $items;
	}
	
	function _get_templates()
	{
		global $DB, $PREFS, $LANG; 
		
		$template_list = array(''=>$LANG->line('choose_a_template'));
		
		$query = $DB->query("SELECT g.group_name, t.template_name
					FROM exp_template_groups g
					JOIN exp_templates t
					ON g.group_id =  t.group_id
					WHERE g.site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
					ORDER BY g.group_order, t.template_name");
		
		foreach ($query->result as $row)
		{
			$template_list[$row['group_name'].'/'.$row['template_name']] = $row['group_name'].'/'.$row['template_name'];
		}
		
		return $template_list; 
	}
	
	function _get_weblog_id($weblog)
	{
		global $DB;

		if ( ! $weblog)
		{
			return 0;
		}

		if (ctype_digit($weblog) || is_int($weblog))
		{
			return $weblog;
		}
		
		if ( ! isset($SESS->cache['cartthrob']['weblog_id_by_blog_name'][$weblog]))
		{
			$query = $DB->query("SELECT weblog_id FROM exp_weblogs WHERE blog_name='".$DB->escape_str($weblog)."' LIMIT 1");
			
			$SESS->cache['cartthrob']['weblog_id_by_blog_name'][$weblog] = ($query->num_rows) ? $query->row['weblog_id'] : 0;
		}

		return $SESS->cache['cartthrob']['weblog_id_by_blog_name'][$weblog];

	}

	function _get_weblog_id_from_entry_id($entry_id)
	{
		global $DB, $SESS;

		if ( ! $entry_id)
		{
			return '';
		}
		
		if (isset($SESS->cache['cartthrob']['items'][$entry_id]['weblog_id']))
		{
			return $SESS->cache['cartthrob']['items'][$entry_id]['weblog_id'];
		}
		
		if ( ! isset($SESS->cache['cartthrob']['weblog_id_by_entry_id'][$entry_id]))
		{
			$query = $DB->query("SELECT weblog_id FROM exp_weblog_titles WHERE entry_id='".$DB->escape_str($entry_id)."' LIMIT 1");
			
			$SESS->cache['cartthrob']['weblog_id_by_entry_id'][$entry_id] = ($query->num_rows) ? $query->row['weblog_id'] : '';
		}

		return $SESS->cache['cartthrob']['weblog_id_by_entry_id'][$entry_id];
	}

	function _get_weblog_name($weblog_id)
	{
		global $DB, $SESS;

		if ( ! $weblog_id)
		{
			return '';
		}

		if ( ! ctype_digit($weblog_id) && ! is_int($weblog_id))
		{
			return $weblog_id;
		}
		
		
		if ( ! isset($SESS->cache['cartthrob']['blog_name'][$weblog_id]))
		{
			$query = $DB->query("SELECT blog_name FROM exp_weblogs WHERE weblog_id='".$DB->escape_str($weblog_id)."' LIMIT 1");

			$SESS->cache['cartthrob']['blog_name'][$weblog_id] = ($query->num_rows) ? $query->row['blog_name'] : '';
		}

		return $SESS->cache['cartthrob']['blog_name'][$weblog_id];
	}

	/**
	 * Returns true/false whether item has been purchased
	 *
	 * @access private
	 * @param string $weblog
	 * @param string $field_name
	 * @param int $entry_id
	 * @param string $expiration_field_name
	 * @return bool
	 */
	function _has_purchased($entry_id)
	{
		global $DB, $SESS;

		$field_id = $this->_get_field_id($this->_purchased_items_id_field);

		if ( ! $this->_purchased_items_weblog || ! $field_id || ! $entry_id)
		{
			return FALSE;
		}

		$query = $DB->query("SELECT COUNT(*) as count
					FROM exp_weblog_titles t
					JOIN exp_weblog_data d
					ON d.entry_id = t.entry_id
					WHERE t.author_id = '".$SESS->userdata['member_id']."'
					AND d.$field_id = '".$DB->escape_str($entry_id)."'");

		return ($query->row['count'] > 0);
	}
	
	function _is_ajax()
	{
		return (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
	}

	function _is_cart_empty()
	{
		$this->_session_start();

		return ( ! isset($_SESSION['cartthrob']['items']) || count($_SESSION['cartthrob']['items']) < 1);
	}

	function _is_item_on_the_fly($item)
	{
		return ( ! empty($item['on_the_fly']));
	}

	function _is_expired($date)
	{
		global $LOC;

		return ($date && $date < $LOC->now);
	}

	function _is_future($date)
	{
		global $LOC;

		return ($date > $LOC->now);
	}

	/**
	 * Returns true/false whether item is in cart
	 *
	 * @access private
	 * @param int $entry_id
	 * @param string $row_id
	 * @return bool/int/string
	 */
	function _item_in_cart($entry_id, $item_options = FALSE, $row_id = FALSE, $check_item_options = TRUE)
	{
		$this->_session_start();

		$items = $this->_get_items();

		if ($row_id !== FALSE && isset($items[$row_id]))
		{
			return $row_id;
		}

		foreach ($items as $row_id => $item)
		{
			if ($entry_id == $item['entry_id'])
			{
				if ($item_options && is_array($item_options))
				{
					if (isset($item['item_options']) && $item['item_options'] === $item_options)
					{
						if ( ! $item['quantity'])
						{
							unset($_SESSION['cartthrob']['items'][$row_id]);
							return FALSE;
						}

						return $row_id;
					}
				}
				elseif (empty($item['item_options']) || (is_array($item['item_options']) && implode('', $item['item_options']) == ''))
				{
					if ( ! $item['quantity'])
					{
						unset($_SESSION['cartthrob']['items'][$row_id]);
						return FALSE;
					}

					return $row_id;
				}
				elseif ( ! $check_item_options)
				{
					return $row_id;
				}
			}
		}

		return FALSE;
	}

	function _item_in_stock($entry_id, $row_id = FALSE, $inventory = NULL)
	{
		if ($inventory === NULL)
		{
			$inventory = $this->_get_item_inventory($entry_id, $row_id);
		}

		return ($inventory !== FALSE) ? ($inventory > 0) : TRUE;
	}
	
	function _jquery_plugin()
	{
		global $FNS;
		
		ob_start();
?>
/*
 * CartThrob jQuery Plugin v0.9252
 * http://cartthrob.com/
 *
 */
(function($){
	$.cartthrob = new Object;
	
	$.cartthrob.cart_items = {};
	$.cartthrob.cart_info = {};
	$.cartthrob.XID = '<?php echo $FNS->add_form_security_hash('{XID_HASH}'); ?>';
	$.cartthrob.ACT = '<?php echo $FNS->insert_action_ids($FNS->fetch_action_id('Cartthrob', '_ajax_action')); ?>';
	$.cartthrob.url = '<?php echo $FNS->fetch_site_index(1); ?>';
	$.cartthrob.loading = false;
	
	$.cartthrob.do_action = function(action, options, callback, obj) {
		if (typeof(options) !== 'object' && typeof(options) !== 'array')
		{
			options = {};
		}
		
		options.action = action;
		options.XID = $.cartthrob.XID;
		options.ACT = $.cartthrob.ACT;
		
		$.cartthrob.loading = true;
		
		$.ajax({
			type: 'POST',
			url: $.cartthrob.url,
			data: options,
			dataType: 'json',
			success: function(data) {
				$.cartthrob.loading = false;
				$.cartthrob.cart_info = data.cart_info;
				$.cartthrob.cart_items = data.items;
				$.cartthrob.XID = data.XID;
				callback(obj);
			},
			error: function() {
				$.cartthrob.loading = false;
			}
		});
	};
	
	$.fn.delete_from_cart = function(callback) {
		return this.each(function() {
			$(this).click(function(){
				var row_id = $.cartthrob.parse_row_id(this);
				if (row_id !== false)
				{
					$.cartthrob.delete_from_cart(row_id, callback, this);
				}
				return false;
			});
		});
	};
	
	$.fn.duplicate_item = function(callback) {
		return this.each(function() {
			$(this).click(function(){
				var row_id = $.cartthrob.parse_row_id(this);
				if (row_id !== false)
				{
					$.cartthrob.duplicate_item(row_id, callback, this);
				}
				return false;
			});
		});
	};

	$.cartthrob.parse_row_id = function(input) {
		if (typeof(input) == 'string')
		{
			var match = input.match(/([0-9]+)/g);
			if (match)
			{
				return match.pop();
			}
		}
		if (typeof(input) == 'object')
		{
			try
			{
				return $.cartthrob.parse_row_id($(input).attr('href')) || $.cartthrob.parse_row_id($(input).attr('rel')) || $.cartthrob.parse_row_id($(input).attr('id'));
			}
			catch(err)
			{
				return false;
			}
		}
		return false;
	};
	
	$.cartthrob.delete_from_cart = function(row_id, callback, obj) {
		$.cartthrob.do_action('delete_from_cart', {row_id: row_id}, callback, obj);
	};
	
	$.cartthrob.duplicate_item = function(row_id, callback, obj) {
		$.cartthrob.do_action('duplicate_item', {row_id: row_id}, callback, obj);
	};
	
	$.cartthrob.add_to_cart = function(entry_id, callback) {
		var data = {};
		
		if (typeof(entry_id) !== 'object' && typeof(entry_id) !== 'array')
		{
			data.entry_id = entry_id;
		}
		else
		{
			data = entry_id;
		}
		
		$.cartthrob.do_action('add_to_cart', data, callback);
	};
})(jQuery);
<?php
		$buffer = ob_get_contents();
		
		ob_end_clean();
		
		return $buffer;
	}
	
	function _jquery_plugin_action()
	{
		header('Content-Type: text/javascript');
		exit($this->_jquery_plugin());
	}

	function _json($data)
	{		
		require_once(PATH_MOD.'cartthrob/lib/jsonwrapper/jsonwrapper.php');

		exit(json_encode($data));
	}

	/**
	 * _load_coupon_code_plugins
	 *
	 * @return void
	 * @author Rob Sanchez
	 * @since 1.0
	 * @access private
	 */
	function _load_coupon_code_plugins($reload = FALSE)
	{
		if ($this->CCP !== NULL && ! $reload)
		{
			return;
		}
		
		$plugin_path = PATH_MOD.'cartthrob/coupon_code_plugins/';

		if ( ! is_dir($plugin_path))
		{
			return;
		}

		$handle = opendir($plugin_path);

		if ( ! $handle)
		{
			return;
		}

		while ($file = readdir($handle))
		{
			if (preg_match('/^cartthrob/', $file))
			{
				include_once($plugin_path.$file);

				$classname = $this->_get_plugin_classname($file);

				$name = $this->_get_plugin_name($file);

				$this->CCP[$name] = new $classname;

				if ($this->_method_exists($this->CCP[$name], 'error_messages'))
				{
					$this->coupon_code_messages = array_merge($this->coupon_code_messages, $this->CCP[$name]->error_messages());
				}
			}
		}
	}

	function _load_email_template_parser()
	{
		if ( ! is_object($this->EMAIL) || ucfirst(get_class($this->EMAIL)) != 'Email_template_parser')
		{
			$this->EMAIL = new Email_template_parser;
		}
	}

	function _load_field_data()
	{
		global $DB, $SESS, $PREFS;

		if ( ! isset($SESS->cache['cartthrob']['fields']))
		{
			$field_query = $DB->query("SELECT *
						FROM exp_weblog_fields
						WHERE site_id = '".$PREFS->ini('site_id')."'");
			
			$weblog_query = $DB->query("SELECT field_group, weblog_id FROM exp_weblogs WHERE site_id = '".$PREFS->ini('site_id')."'");
			
			$weblogs = array();
			$field_groups = array();
			
			foreach ($weblog_query->result as $row)
			{
				$weblogs[$row['weblog_id']] = $row['field_group'];
				$field_groups[$row['field_group']][] = $row['weblog_id'];
			}

			foreach ($field_query->result as $row)
			{
				$SESS->cache['cartthrob']['fields']['field_id'][$row['field_name']] = $row['field_id'];
				$SESS->cache['cartthrob']['fields']['fields_by_group'][$row['group_id']][] = $row['field_id'];
				$SESS->cache['cartthrob']['fields']['field_name'][$row['field_id']] = $row['field_name'];
				$SESS->cache['cartthrob']['fields']['field_fmt'][$row['field_id']] = $row['field_fmt'];
				$SESS->cache['cartthrob']['fields']['field_type'][$row['field_id']] = $row['field_type'];
				$SESS->cache['cartthrob']['fields']['field_fmt'][$row['field_name']] = $row['field_fmt'];
				$SESS->cache['cartthrob']['fields']['field_label'][$row['field_id']] = $row['field_label'];
				
				if (isset($row['field_is_gypsy']) && $row['field_is_gypsy'] == 'y')
				{
					foreach (explode(' ', $row['gypsy_weblogs']) as $gypsy_weblog)
					{
						if ($gypsy_weblog && isset($weblogs[$gypsy_weblog]))
						{
							$SESS->cache['cartthrob']['fields']['fields_by_group'][$weblogs[$gypsy_weblog]][] = $row['field_id'];
						}
					}
				}
				
				if (isset($field_groups[$row['group_id']]))
				{
					foreach ($field_groups[$row['group_id']] as $weblog_id)
					{
						$SESS->cache['cartthrob']['fields']['group_id'][$weblog_id] = $row['group_id'];
					}
				}
			}
		}
	}

	/**
	 * _load_payment_gateway
	 *
	 * @return void
	 * @author Rob Sanchez, Chris Newton
	 * @since 1.0
	 * @param $gateway FALSE the filename of the gateway. If no parameter is passed, the gateway set in the extension will be used.
	 * @access private
	 */
	function _load_payment_gateway($gateway = NULL )
	{
		global $LANG;
		
		if ( ! $gateway)
		{
			$gateway = $this->settings['payment_gateway'];
		}

		if ($gateway)
		{
			$gateway_path = PATH_MOD.'cartthrob/payment_gateways/'.$this->_get_plugin_filename(strtolower($gateway));
			
			if ( ! file_exists($gateway_path))
			{
				$this->_show_error($LANG->line('invalid_payment_gateway'));
			}
			else
			{
				include($gateway_path);

				if ( ! $this->PG || ucfirst(get_class($this->PG)) != $gateway)
				{
					if (!strstr($gateway,"Cartthrob_"))
					{ 
						$gateway = "Cartthrob_". $gateway; 
					}
					$this->PG = new $gateway;
					$this->PG->gateway_info = (isset($gateway_info)) ? $gateway_info : array();
				}
			}
		}
		else
		{
			$this->PG = new Cartthrob_default_payment_gateway();
		}
		
		if ( ! empty($this->PG->gateway_info['language_file']))
		{
			global $LANG;
			
			$LANG->fetch_language_file(strtolower($this->PG->gateway_info['classname']), 'cartthrob');
		}
	}

	/**
	 * _load_shipping_plugin
	 *
	 * @return void
	 * @author Rob Sanchez
	 * @since 1.0
	 * @param $filename NULL the filename of the shipping plugin. If no parameter is passed, the plugin set in the extension will be used.
	 * @access private
	 */
	function _load_shipping_plugin($plugin = NULL)
	{
		if ( ! $plugin)
		{
			$classname = $this->_shipping_plugin;
			$plugin = $this->_shipping_plugin;
		}
		else
		{
			$classname = $this->_get_plugin_classname($plugin);
		}

		$plugin_path = PATH_MOD.'cartthrob/shipping_plugins/'.$this->_get_plugin_filename(strtolower($plugin));

		if (file_exists($plugin_path) && $classname)
		{
			include($plugin_path);

			if (!$this->SHP || !is_object($this->SHP) || ucfirst(get_class($this->SHP)) != $classname)
			{
				$this->SHP = new $classname;
				$this->SHP->plugin_info = (isset($plugin_info)) ? $plugin_info : array();
			}
		}
	}
	
	function _load_typography()
	{
		if ( ! empty($this->TYPE))
		{
			return;
		}

		if ( ! class_exists('Typography'))
		{
			require PATH_CORE.'core.typography'.EXT;
		}

		$this->TYPE = new Typography;
		
		$this->TYPE->convert_curly = FALSE;
		$this->TYPE->encode_email = FALSE;
		$this->TYPE->smileys = FALSE;
		$this->TYPE->allow_img_url = 'y';
		$this->TYPE->allow_js_img_anchors = 'y';
		$this->TYPE->highlight_code = FALSE;
		$this->TYPE->parse_smileys = FALSE;
		$this->TYPE->text_format = 'none';
	}
	/**
	 * _login_member
	 *
	 * @param string $member_id 
	 * @param string $username 
	 * @param string $password 
	 * @param string $unique_id 
	 * @return void
	 * @author Chris Newton
	 */
	function _login_member($member_id, $username, $password, $unique_id)
	{
		global $FNS, $SESS, $LOC, $DB, $PREFS; 
		
		$expiration = 60*60*24*182; 
		$FNS->set_cookie($SESS->c_expire , time()+$expiration, $expiration);
		$FNS->set_cookie($SESS->c_uniqueid , $unique_id, $expiration);
		$FNS->set_cookie($SESS->c_password , $password, $expiration);

		if ($PREFS->ini('user_session_type') == "cs"  || $PREFS->ini('user_session_type') == "s")
		{
			$SESS->sdata["member_id"]		= $member_id; 
			$SESS->sdata["last_activity"]	= $LOC->now; 
			$FNS->set_cookie($SESS->c_session, $SESS->sdata["session_id"], $SESS->session_length);
			$DB->query($DB->insert_string("exp_sessions", $SESS->sdata));
		}
		$SESS->userdata["username"]			= $username;
		$SESS->userdata["member_id"]		= $member_id;
		
	}
	
	function _method_exists($class, $method)
	{
		return is_callable(array($class, $method));
	}
	
	function _multi_add_to_cart_form_submit()
	{
		global $IN, $FNS;

		$this->_check_security_hash();

		$entry_ids = $this->_xss_clean($IN->GBL('entry_id', 'POST'));

		if (is_array($entry_ids))
		{
			if ($IN->GBL('language', 'POST'))
			{
				$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
			}

			$show_errors = TRUE;

			if ($IN->GBL('ERR', 'POST'))
			{
				$show_errors = $this->_decode_bool($IN->GBL('ERR', 'POST'));
			}

			$on_the_fly = ($IN->GBL('OTF', 'POST') && $this->_decode_bool($IN->GBL('OTF', 'POST')));

			$json = ($IN->GBL('JSN', 'POST') && $this->_decode_bool($IN->GBL('JSN', 'POST')));
		
			$allow_user_price = ($IN->GBL('AUP', 'POST') && $this->_decode_bool($IN->GBL('AUP', 'POST')));
		
			$allow_user_shipping = ($IN->GBL('AUS', 'POST') && $this->_decode_bool($IN->GBL('AUS', 'POST')));
		
			$allow_user_weight = ($IN->GBL('AUW', 'POST') && $this->_decode_bool($IN->GBL('AUW', 'POST')));

			foreach ($entry_ids as $row_id => $entry_id)
			{
				$quantity = $this->_sanitize_integer($this->_xss_clean($this->_get_post_by_row_id('quantity', $row_id)));
				
				if ($quantity > 0)
				{
					$this->_add_to_cart($entry_id,
							    $quantity,
							    ($on_the_fly) ? $this->_xss_clean($this->_get_post_by_row_id('title', $row_id)) : '',
							    ($allow_user_price || $on_the_fly) ? $this->_xss_clean($this->_get_post_by_row_id('price', $row_id)) : FALSE,
							    $this->_xss_clean($this->_get_post_by_row_id('item_options', $row_id)),
							    ($allow_user_shipping || $on_the_fly) ? $this->_xss_clean($this->_get_post_by_row_id('shipping', $row_id)) : FALSE,
							    ($allow_user_weight || $on_the_fly) ? $this->_xss_clean($this->_get_post_by_row_id('weight', $row_id)) : FALSE,
							    FALSE, // no_tax
							    FALSE, // no_shipping
							    $on_the_fly,
							    $show_errors,
							    $json,
							    '', // inventory_reduce
							    $this->_xss_clean($this->_get_post_by_row_id('license_number', $row_id)),
							    FALSE // expiration_date
							);
				}
			}
		}

		$this->_redirect(($IN->GBL('return')) ? $IN->GBL('return') : $FNS->fetch_site_index(1));
	}

	function _new_cart()
	{
		$_SESSION['cartthrob'] = array(
			'items'=>array(),
			'coupon_codes'=>array(),
			'order'=>array(),
			'customer_info'=>array(),
			'shipping'=>array()
		);

		if ( ! empty($this->settings['default_location']) && is_array($this->settings['default_location']))
		{
			foreach ($this->settings['default_location'] as $key => $value)
			{
				$_SESSION['cartthrob']['customer_info'][$key] = $value;
			}
		}
	}

	/**
	 * Fires on process authorization
	 *
	 * @access private
	 * @return void
	 */
	function _on_authorize($data=array())
	{
		$path = PATH_MOD.'cartthrob/process/cartthrob.on_authorize.php';
		if (file_exists($path))
		{
			include($path);
		}

		// -------------------------------------------
		// 'cartthrob_on_authorize' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		global $EXT;

		$this->_session_start();

		if ($EXT->active_hook('cartthrob_on_authorize') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_on_authorize', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
	}

	/**
	 * Fires on process decline
	 *
	 * @access private
	 * @return void
	 */
	function _on_decline($data=array())
	{
		$path = PATH_MOD.'cartthrob/process/cartthrob.on_decline.php';
		if (file_exists($path))
		{
			include($path);
		}

		// -------------------------------------------
		// 'cartthrob_on_decline' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		global $EXT;

		$this->_session_start();

		if ($EXT->active_hook('cartthrob_on_decline') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_on_decline', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
	}

	/**
	 * Fires on process failure
	 *
	 * @access private
	 * @return void
	 */
	function _on_fail($data=array())
	{
		$path = PATH_MOD.'cartthrob/process/cartthrob.on_fail.php';
		if (file_exists($path))
		{
			include($path);
		}

		// -------------------------------------------
		// 'cartthrob_on_fail' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		global $EXT;

		$this->_session_start();

		if ($EXT->active_hook('cartthrob_on_fail') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_on_fail', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
	}

	/**
	 * Returns an array of product id's of products within the specified price range
	 * 
	 * @access private
	 * @param float $price_min
	 * @param float $price_max
	 * @return array
	 */
	function _order_info($tagdata = '', $no_results = '')
	{
		global $TMPL, $FNS;

		$this->_session_start();
		
		$order = $this->_get_saved_order();
		
		$auth = array(
			'authorized' => (isset($order['auth']['authorized'])) ? $order['auth']['authorized'] : '',
			'declined' => (isset($order['auth']['declined'])) ? $order['auth']['declined'] : '',
			'failed' => (isset($order['auth']['failed'])) ? $order['auth']['failed'] : '',
			'error_message' => (isset($order['auth']['error_message'])) ? $order['auth']['error_message'] : '',
			'transaction_id' => (isset($order['auth']['transaction_id'])) ? $order['auth']['transaction_id'] : '',
			'no_order' => ( ! $order || ! is_array($order))
		);

		$tagdata = $FNS->prep_conditionals($tagdata, $auth);

		$tagdata = $TMPL->swap_var_single('error_message', $auth['error_message'], $tagdata);

		$tagdata = $TMPL->swap_var_single('transaction_id', @$auth['transaction_id'], $tagdata);

		$tagdata = $TMPL->swap_var_single('cart_total', @$order['total_cart'], $tagdata);

		$tagdata = $TMPL->swap_var_single('order_id', @$order['order_id'], $tagdata);
		
		if ( ! $order || ! is_array($order))
		{
			return $no_results;
		}

		return $tagdata;
	}
	
	function _override_settings()
	{
		$this->_session_start();
		
		$override_settings = (isset($_SESSION['cartthrob']['override_settings'])) ? $_SESSION['cartthrob']['override_settings'] : array();
		
		$this->settings = $this->_array_merge($this->settings, $override_settings);
	}
	
	function _array_merge($a, $b)
	{
		foreach ($b as $key => $value)
		{
			if (is_array($value))
			{
				$a[$key] = self::_array_merge($a[$key], $value);
			}
			else
			{
				$a[$key] = $value;
			}
		}
		
		return $a;
	}

	function _param_string_to_array($string)
	{
		$values = array();

		if ($string)
		{
			foreach (explode('|', $string) as $value)
			{
				if (strpos($value, ':') !== FALSE)
				{
					$value = explode(':', $value);

					$values[$value[0]] = $value[1];
				}
				else
				{
					$values[$value] = $value;
				}
			}
		}

		return $values;
	}

	function _parse_item_option_inputs($tagdata, $item = NULL, $item_data = NULL, $add = FALSE)
	{
		global $TMPL, $FNS;
		if ( ! is_array($item_data))
		{
			$item_data = array();

			if ($TMPL->fetch_param('entry_id') || $TMPL->fetch_param('row_id') !== FALSE)
			{
				$item_data = $this->_get_item_data($TMPL->fetch_param('entry_id'), $TMPL->fetch_param('row_id'));
			}
		}

		if ( ! is_array($item))
		{
			$item = array();

			if ($TMPL->fetch_param('entry_id') || $TMPL->fetch_param('row_id') !== FALSE)
			{
				$item = $this->_get_cart_item($TMPL->fetch_param('entry_id'), $TMPL->fetch_param('row_id'));
			}
		}

		$entry_id = (isset($item['entry_id'])) ? $item['entry_id'] : $TMPL->fetch_param('entry_id');

		$row_id = (isset($item['row_id'])) ? $item['row_id'] : $TMPL->fetch_param('row_id');

		foreach ($TMPL->var_pair as $var_name => $var_params)
		{
			$var_close_name = (strpos($var_name, ' ') !== FALSE) ? substr($var_name, 0, strpos($var_name, ' ')) : $var_name;
			$option_count = 0; 
			$option_total_results = 0; 
			if (preg_match('/^item_options:select:([^\s]*)\s*?.*?/', $var_name, $match))
			{
				$var_params['name'] = $match[1];

				if (preg_match_all("/".LD.preg_quote($var_name).RD."(.*?)".LD.SLASH.$var_close_name.RD."/s", $tagdata, $matches))
				{
					foreach ($matches[0] as $match_index => $full_match)
					{
						$output = '';

						if ( ! empty($var_params['name']))
						{
							$values = $this->_param_string_to_array(( ! empty($var_params['values'])) ? $var_params['values'] : '');

							if (count($values))
							{
								foreach ($values as $key => $value)
								{
									$_SESSION['cartthrob']['item_option_names'][$var_params['name']][$key] = $value;
								}
							}

							if ($entry_id !== FALSE || $row_id !== FALSE)
							{
								if ( ! empty($item_data[$this->_get_field_id($var_params['name'])]))
								{
									if ($this->_get_field_type($this->_get_field_id($var_params['name'], FALSE)) == 'ff_matrix')
									{
										$option_data = $this->_parse_ff_matrix_price_modifier($var_params['name'], $item_data[$this->_get_field_id($var_params['name'])], $this->_get_ff_settings($this->_get_field_id($var_params['name'], FALSE)));
									}
									elseif ($this->_get_field_type($this->_get_field_id($var_params['name'], FALSE)) == 'matrix')
									{
										$option_data = $this->_parse_matrix_price_modifier($var_params['name'], $item_data[$this->_get_field_id($var_params['name'])], $this->_get_ff_settings($this->_get_field_id($var_params['name'], FALSE)), $entry_id);
									}
									else
									{
										$option_data = $this->_unserialize($item_data[$this->_get_field_id($var_params['name'])]);
									}
									
									if ( ! empty($option_data))
									{
										foreach ($option_data as $option)
										{
											if (isset($option['option']) && isset($option['option']))
											{
												$option_count ++;
												$values[$option['option']] = $option['option_name'];
												$count_array[$option['option']] = $option_count; 
												
												$prices[$option['option']] = (isset($option['price'])) ? $option['price'] : 0;
											}
										}
										$option_total_results = $option_count; 
									}
								}
							}

							$extra = '';

							foreach ($var_params as $param_name => $param_value)
							{
								if (preg_match('/attr:([a-zA-Z0-9_-]+)/', $param_name, $match))
								{
									$extra .= ' '.$match[1].'="'.$param_value.'"';
								}
							}

							$class = ( ! empty($var_params['class'])) ? ' class="'.$var_params['class'].'"' : '';

							$id = ( ! empty($var_params['id'])) ? ' id="'.$var_params['id'].'"' : '';

							$onchange = ( ! empty($var_params['onchange'])) ? ' onchange="'.$var_params['onchange'].'"' : '';

							if ($var_params['name'] === 'quantity')
							{
								if (isset($var_params['row_id']) && $var_params['row_id'] !== '')
								{
									$var_params['row_id'] = ($var_params['row_id'] === 'TRUE' && isset($item['row_id'])) ? $item['row_id'] : $var_params['row_id'];
									
									$input_name = 'quantity['.$var_params['row_id'].']';
								}
								else
								{
									$input_name = 'quantity';
								}
							}
							else
							{
								if (isset($var_params['row_id']) && $var_params['row_id'] !== '')
								{
									$var_params['row_id'] = ($var_params['row_id'] === 'TRUE' && isset($item['row_id'])) ? $item['row_id'] : $var_params['row_id'];
									
									$input_name = 'item_options['.$var_params['row_id'].']['.$var_params['name'].']';
								}
								else
								{
									$input_name = 'item_options['.$var_params['name'].']';
								}
							}

							$var_pair_tagdata = $matches[1][$match_index];

							if (isset($item['item_options'][$var_params['name']]) && ! isset($var_params['selected']) && ! $add)
							{
								$var_params['selected'] = $item['item_options'][$var_params['name']];
							}

							if (count($values))
							{
								$output .= '<select name="'.$input_name.'"'.$class.$id.$onchange.$extra.'>';
								
								foreach ($values as $key => $value)
								{
									$temp = $var_pair_tagdata;
									
									$temp = $TMPL->swap_var_single('option', $key, $temp);

									$temp = $TMPL->swap_var_single('selected', ((isset($var_params['selected']) && $var_params['selected'] == $key) ? ' selected="selected"' : ''), $temp);

									$temp = $TMPL->swap_var_single('option_name', $value, $temp);

									$temp = $TMPL->swap_var_single('price', $this->view_formatted_number(isset($prices[$key]) ? $prices[$key] : ''), $temp);

									$temp = $TMPL->swap_var_single('option_count', $count_array[$key], $temp);
									
									$cond =  array(
											'option_first_row'=> (bool) ($count_array[$key] == 1),
											'option_last_row'=>  (bool) ($count_array[$key] == $option_total_results),
											'option_selected'=>  (bool) ((isset($var_params['selected']) && $var_params['selected'] == $key))
									);

									$temp = $FNS->prep_conditionals($temp, $cond);

									$output .= $temp;
									
								}

								$output .= '</select>';

								$output = $TMPL->swap_var_single('option_total_results', $option_total_results, $output);
					
							}
						}

						
						
						$tagdata = str_replace($matches[0][$match_index], $output, $tagdata);
					}
				}
			}
		}
		
		foreach ($TMPL->var_single as $var_name)
		{
			if (preg_match("/^item_options:select:([^\s]+)\s*?(.*)/", $var_name, $match))
			{
				$var_string = $match[2];

				$var_params = $FNS->assign_parameters($var_string);

				if ( ! is_array($var_params))
				{
					$var_params = array();
				}

				$var_params['name'] = $match[1];

				$values = $this->_param_string_to_array(( ! empty($var_params['values'])) ? $var_params['values'] : '');

				if (count($values))
				{
					foreach ($values as $key => $value)
					{
						$_SESSION['cartthrob']['item_option_names'][$var_params['name']][$key] = $value;
					}
				}

				if ($entry_id !== FALSE || $row_id !== FALSE)
				{
					if ( ! empty($item_data[$this->_get_field_id($var_params['name'])]))
					{
						if ($this->_get_field_type($this->_get_field_id($var_params['name'], FALSE)) == 'ff_matrix')
						{
							$option_data = $this->_parse_ff_matrix_price_modifier($var_params['name'], $item_data[$this->_get_field_id($var_params['name'])], $this->_get_ff_settings($this->_get_field_id($var_params['name'], FALSE)));
						}
						elseif ($this->_get_field_type($this->_get_field_id($var_params['name'], FALSE)) == 'matrix')
						{
							$option_data = $this->_parse_matrix_price_modifier($var_params['name'], $item_data[$this->_get_field_id($var_params['name'])], $this->_get_ff_settings($this->_get_field_id($var_params['name'], FALSE)), $entry_id);
						}
						else
						{
							$option_data = $this->_unserialize($item_data[$this->_get_field_id($var_params['name'])]);
						}

						if ( ! empty($option_data))
						{
							foreach ($option_data as $option)
							{
								$values[$option['option']] = $option['option_name'];
							}
						}
					}
				}

				$output = '';

				if ( ! empty($var_params['name'])  && $values)
				{
					$extra = '';

					foreach ($var_params as $param_name => $param_value)
					{
						if (preg_match('/attr:([a-zA-Z0-9_-]+)/', $param_name, $match))
						{
							$extra .= ' '.$match[1].'="'.$param_value.'"';
						}
					}

					$class = ( ! empty($var_params['class'])) ? ' class="'.$var_params['class'].'"' : '';

					$id = ( ! empty($var_params['id'])) ? ' id="'.$var_params['id'].'"' : '';

					$onchange = ( ! empty($var_params['onchange'])) ? ' onchange="'.$var_params['onchange'].'"' : '';

					if ($var_params['name'] === 'quantity')
					{
						if (isset($var_params['row_id']) && $var_params['row_id'] !== '')
						{
							$var_params['row_id'] = ($var_params['row_id'] === 'TRUE' && isset($item['row_id'])) ? $item['row_id'] : $var_params['row_id'];
							
							$input_name = 'quantity['.$var_params['row_id'].']';
						}
						else
						{
							$input_name = 'quantity';
						}
					}
					else
					{
						if (isset($var_params['row_id']) && $var_params['row_id'] !== '')
						{
							$var_params['row_id'] = ($var_params['row_id'] === 'TRUE' && isset($item['row_id'])) ? $item['row_id'] : $var_params['row_id'];
							
							$input_name = 'item_options['.$var_params['row_id'].']['.$var_params['name'].']';
						}
						else
						{
							$input_name = 'item_options['.$var_params['name'].']';
						}
					}

					$output .= '<select name="'.$input_name.'"'.$class.$id.$onchange.$extra.'>'."\r";

					if (isset($item['item_options'][$var_params['name']]) && ! isset($var_params['selected']) && ! $add)
					{
						$var_params['selected'] = $item['item_options'][$var_params['name']];
					}

					foreach ($values as $key => $value)
					{
						$output .= "\t".'<option value="'.$key.'"'.((isset($var_params['selected']) && $var_params['selected'] == $key) ? ' selected="selected"' : '').'>'.$value.'</option>'."\r";
					}

					$output .= '</select>';
				}
				
				$tagdata = $TMPL->swap_var_single($var_name, $output, $tagdata);
			}
			
			if (preg_match("/item_options:input:([a-zA-Z0-9_-]+)\s*?(.*)/", $var_name, $match))
			{
				$var_string = $match[2];
				
				$var_params = $FNS->assign_parameters($var_string);
				
				if ( ! is_array($var_params))
				{
					$var_params = array();
				}

				$var_params['name'] = $match[1];

				$output = '';

				if ( ! empty($var_params['name']))
				{

					if ($var_params['name'] === 'quantity')
					{
						if (isset($var_params['row_id']) && $var_params['row_id'] !== '')
						{
							$var_params['row_id'] = ($var_params['row_id'] === 'TRUE' && isset($item['row_id'])) ? $item['row_id'] : $var_params['row_id'];
							
							$input_name = 'quantity['.$var_params['row_id'].']';
						}
						else
						{
							$input_name = 'quantity';
						}

						$var_params['value'] = $item['quantity'];
					}
					else
					{
						if (isset($var_params['row_id']) && $var_params['row_id'] !== '')
						{
							$var_params['row_id'] = ($var_params['row_id'] === 'TRUE' && isset($item['row_id'])) ? $item['row_id'] : $var_params['row_id'];
							
							$input_name = 'item_options['.$var_params['row_id'].']['.$var_params['name'].']';
						}
						else
						{
							$input_name = 'item_options['.$var_params['name'].']';
						}
					}

					$extra = '';

					$class = ( ! empty($var_params['class'])) ? ' class="'.$var_params['class'].'"' : '';

					$id = ( ! empty($var_params['id'])) ? ' id="'.$var_params['id'].'"' : '';

					$value = ( ! empty($var_params['value'])) ? ' value="'.$var_params['value'].'"' : '';

					$type = ( ! empty($var_params['type'])) ? $var_params['type'] : 'text';

					if (isset($item['item_options'][$var_params['name']]) && $value == '' && ! $add)
					{
						$value = ' value="'.$item['item_options'][$var_params['name']].'"';
					}

					foreach ($var_params as $param_name => $param_value)
					{
						if (preg_match('/attr:([a-zA-Z0-9_-]+)/', $param_name, $match_attr))
						{
							$extra .= ' '.$match_attr[1].'="'.$param_value.'"';
						}
					}

					$output = '<input type="'.$type.'" name="'.$input_name.'"'.$class.$id.$value.$extra.' />';
				}

				$tagdata = $TMPL->swap_var_single($var_name, $output, $tagdata);
			}
		}

		return $tagdata;
	}
	
	function _parse_ff_matrix_price_modifier($field_name, $field_data, $ff_settings)
	{
		$price_modifier = array();
		
		$field_data = $this->_unserialize($field_data);

		foreach ($field_data as $index => $row)
		{
			$single_data = array(
				'option_name' => '',
				'option' => '',
				'price' => 0,
				'inventory' => ''
			);

			foreach ($ff_settings['cols'] as $key => $matrix_field)
			{
				if (array_key_exists($matrix_field['name'], $single_data) && array_key_exists($key, $row))
				{
					$single_data[$matrix_field['name']] = $row[$key];
				}
			}

			$price_modifier[] = $single_data;
		}
		
		return $price_modifier;
	}
	
	function _parse_matrix_price_modifier($field_name, $field_data, $ff_settings, $entry_id)
	{
		global $DB;
		
		$price_modifiers = array();
		
		if (empty($field_data) || empty($ff_settings['col_ids']))
		{
			return $price_modifiers;
		}
		
		$query = $DB->query("SELECT * FROM exp_matrix_data WHERE field_id = '".$DB->escape_str($this->_get_field_id($field_name, FALSE))."' and entry_id = '".$DB->escape_str($entry_id)."'");
		
		if ( ! $query->num_rows)
		{
			return $price_modifiers;
		}
		
		$field_data = $query->result;
			
		$query = $DB->query("SELECT * FROM exp_matrix_cols WHERE col_id IN ('".implode("','", $ff_settings['col_ids'])."')");
		
		if ( ! $query->num_rows)
		{
			return $price_modifiers;
		}
		
		$cols = $query->result;

		foreach ($field_data as $index => $row)
		{
			$single_data = array(
				'option_name' => '',
				'option' => '',
				'price' => 0,
				'inventory' => ''
			);

			foreach ($cols as $col)
			{
				if (array_key_exists($col['col_name'], $single_data) && array_key_exists('col_id_'.$col['col_id'], $row))
				{
					$single_data[$col['col_name']] = $row['col_id_'.$col['col_id']];
				}
			}

			$price_modifiers[] = $single_data;
		}
		
		return $price_modifiers;
	}
	
	function _parse_path($location = FALSE)
	{
		global $IN, $FNS, $TMPL;

		$location = trim((strpos($location, '&#47;') === FALSE) ? $location : str_replace('&#47;', '/', $location));

		if (preg_match("/".LD."\s*path=[\042\047]?(.*?)[\042\047]?".RD."/", $location, $match))
		{
			$location = $FNS->create_url($match[1]);
		}
		elseif ($location == '{site_url}')
		{
			$location = $FNS->fetch_site_index(1);
		}
		elseif ($location && ! preg_match('/^(\/|http)/', $location))
		{
			$location = $FNS->create_url($location);
		}
		return $location;
	}

	/**
	 * Replace key/value pairs in a string
	 *
	 * @access private
	 * @param string $string
	 * @param array $data
	 * @return string
	 */
	function _parse_template_simple($string, $data, $constants = array())
	{
		global $TMPL;

		if ( ! is_object($TMPL))
		{
			if ( ! class_exists('Template'))
			{
			require_once(PATH_CORE.'core.template'.EXT);
			}

			$TMPL = new Template();
		}

		if ( ! is_array($data))
		{
			return $string;
		}

		foreach ($data as $key => $value)
		{
			if (is_string($value) || is_numeric($value))
			{
				$string = $TMPL->swap_var_single($key, $value, $string);
			}
		}

		foreach ($constants as $key => $value)
		{
			if (is_string($value) || is_numeric($value))
			{
				$string = str_replace($key, $value, $string);
			}
		}

		return $string;
	}
	// END 

	// --------------------------------
	//  Parse Template Full
	// --------------------------------
	/**
	 * Run a string through the EE template parsing engine
	 *
	 * @access private
	 * @param string $string
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _parse_template_full($string)
	{
		global $TMPL, $OUT, $DB, $PREFS, $FNS;
		
		if ( ! $string)
		{
			return '';
		}

		//store global objects temporarily
		$temp_TMPL = $FNS->clone_object($TMPL);

		$temp_OUT = $FNS->clone_object($OUT);

		//overwrite these global objects with new instances
		$OUT = new Output();
		
		require_once(PATH_MOD.'cartthrob/lib/cartthrob.template.php');

		$TMPL = new Cartthrob_template($string);
		
		foreach (get_object_vars($temp_TMPL) as $key => $value)
		{
			$TMPL->$key = $value;
		}
		
		$TMPL->template_type = 'webpage';

		//process this template
		$TMPL->run_template_engine('', '');

		//get the final output of parsed template
		$string = $TMPL->final_template;

		$string = $TMPL->remove_ee_comments($string);
		$string = preg_replace('#&(amp;)?lt;(/?style.*?)&(amp;)?gt;#', '<\\2>', $string);

		//restore the original globals
		$TMPL = $FNS->clone_object($temp_TMPL);

		$OUT = $FNS->clone_object($temp_OUT);
		
		unset($temp_TMPL);

		unset($temp_OUT);

		return $string;
	}
	/*
	function _parse_template_full($string)
	{
		global $TMPL, $OUT, $DB, $PREFS, $FNS;

		$site_id = $PREFS->ini('site_id');

		//store global objects temporarily
		$temp_TMPL = $FNS->clone_object($TMPL);

		$temp_OUT = $FNS->clone_object($OUT);

		//overwrite these global objects with new instances
		$OUT = new Output();

		$TMPL = new Template();

		//get a list of all existing template groups and templates,
		//so we don't ever overwrite or delete them
		$query = $DB->query("SELECT group_id FROM exp_template_groups");

		$existing_template_groups = array();

		foreach ($query->result as $row)
		{
			$existing_template_groups[] = $row['group_id'];
		}

		$existing_template_groups = implode(',', $existing_template_groups);

		$query = $DB->query("SELECT template_id FROM exp_templates");

		$existing_templates = array();

		foreach ($query->result as $row)
		{
			$existing_templates[] = $row['template_id'];
		}

		$existing_templates = implode(',', $existing_templates);

		//create new temporary template group with a unique group_name
		$DB->query("INSERT INTO exp_template_groups (site_id, group_name) VALUES ('$site_id', UUID())");

		$query = $DB->query("SELECT group_id, group_name FROM exp_template_groups WHERE group_id NOT IN ($existing_template_groups) ORDER BY group_id DESC LIMIT 1");

		$group_id = $query->row['group_id'];

		$group_name = $query->row['group_name'];

		//$DB->query($DB->insert_string('exp_templates', array('group_id'=>$group_id, 'site_id'=>$site_id, 'template_name'=>$template_name, 'template_data'=>$message)));

		//create new temporary template  with a unique template_name
		$DB->query("INSERT INTO exp_templates (site_id, group_id, template_name, template_data) VALUES ('$site_id', '$group_id', UUID(), '".$DB->escape_str($string)."')");

		$query = $DB->query("SELECT template_name FROM exp_templates WHERE template_id NOT IN ($existing_templates) ORDER BY template_id DESC LIMIT 1");

		$template_name = $query->row['template_name'];

		//process this template
		$TMPL->run_template_engine($group_name, $template_name);

		//get the final output of parsed template
		$string = $TMPL->final_template;
		
	//	ob_start();

	//	$OUT->display_final_output();

	//	$string = ob_get_contents();

	//	ob_end_clean();

		//restore the original globals
		$TMPL = $FNS->clone_object($temp_TMPL);

		$OUT = $FNS->clone_object($temp_OUT);
		
		//remove our temp template group and template
		$DB->query("DELETE FROM exp_template_groups WHERE group_name = '".$DB->escape_str($group_name)."' AND group_id NOT IN ($existing_template_groups) LIMIT 1");

		$DB->query("DELETE FROM exp_templates WHERE template_name = '".$DB->escape_str($template_name)."' AND template_id NOT IN ($existing_templates) LIMIT 1");

		unset($temp_TMPL);

		unset($temp_OUT);

		return $string;
	}
	// END
	*/

	/**
	 * Loads the pre-process file, which is a php file that is fired before
	 * and order is processed
	 * 
	 * @access private
	 * @param float $price_min
	 * @param float $price_max
	 * @return array
	 */
	function _pre_process()
	{
		$path = PATH_MOD.'cartthrob/process/cartthrob.pre_process.php';

		if (file_exists($path))
		{
			include($path);
		}

		// -------------------------------------------
		// 'cartthrob_pre_process' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//
		global $EXT;

		$this->_session_start();

		if ($EXT->active_hook('cartthrob_pre_process') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_pre_process', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
	}
	function _process_discounts()
	{
		global $DB, $SESS;

 		$discount_array = $this->_get_discount_values($this->_calculate_subtotal(), $this->_calculate_shipping()); 

		foreach ($discount_array as $discount)
		{
			$entry_id = (isset($discount['metadata']['entry_id'])) ? $discount['metadata']['entry_id'] : FALSE;

			// discount_type is a reference to the field that stores the discounts. 
			if ($entry_id && ! empty($this->settings['discount_type']))
			{
				unset($discount['metadata']);

				$discount['used_by'] = ($discount['used_by']) ? $discount['used_by'].'|'.$SESS->userdata['member_id'] : $SESS->userdata['member_id'];

				$discount['coupon_limit'] = (strlen($discount['coupon_limit'])) ? $discount['coupon_limit'] - 1 : '';

				$data = array(
					'field_id_'.$this->settings['discount_type'] => addslashes(serialize($discount))
				);

				$DB->query($DB->update_string('exp_weblog_data', $data, array('entry_id' => $entry_id)));
			}
		}
		
	}
	/**
	 * Processes coupon codes as used by a member
	 * 
	 * @access private
	 * @return void
	 */
	function _process_coupon_codes()
	{
		global $DB, $SESS;

		$this->_process_discounts(); 
		
		$coupon_codes = $this->_get_coupon_codes();

		foreach ($coupon_codes as $coupon_code)
		{
			$coupon_code_data = $this->_get_coupon_code_data($coupon_code);

			$entry_id = (isset($coupon_code_data['metadata']['entry_id'])) ? $coupon_code_data['metadata']['entry_id'] : FALSE;

			if ($entry_id && ! empty($this->settings['coupon_code_type']))
			{
				unset($coupon_code_data['metadata']);

				$coupon_code_data['used_by'] = ($coupon_code_data['used_by']) ? $coupon_code_data['used_by'].'|'.$SESS->userdata['member_id'] : $SESS->userdata['member_id'];

				$coupon_code_data['coupon_limit'] = (strlen($coupon_code_data['coupon_limit'])) ? $coupon_code_data['coupon_limit'] - 1 : '';

				$data = array(
					'field_id_'.$this->settings['coupon_code_type'] => addslashes(serialize($coupon_code_data))
				);

				$DB->query($DB->update_string('exp_weblog_data', $data, array('entry_id' => $entry_id)));
			}
		}
	}

	function _process_inventory()
	{
		$items = array();

		$inventory_reduce = array();

		foreach ($this->_get_cart_items() as $row_id => $item)
		{
			if ( ! empty($item['entry_id']) && $this->_validate_entry_id($item['entry_id']))
			{
				$this->_reduce_inventory($item['entry_id'], $item['quantity'], $row_id, $this->_get_item_options($item['entry_id'], $row_id));
			}

			if ( ! empty($item['inventory_reduce']) && is_array($item['inventory_reduce']))
			{
				foreach ($item['inventory_reduce'] as $entry_id => $quantity)
				{
					$inventory_reduce[] = array(
						'entry_id' => $entry_id,
						'quantity' => $quantity
					);
				}
			}
		}

		foreach ($inventory_reduce as $ir)
		{
			$this->_reduce_inventory($ir['entry_id'], $ir['quantity']);
		}
	}

	/**
	 * Returns an array of product entry_id's of products within the specified price range
	 * In order to get this to work, you need to change the MySQL field type of your price field to INT or FLOAT
	 * 
	 * @access private
	 * @param float $price_min
	 * @param float $price_max
	 * @return array
	 */
	function _products_in_price_range($price_min, $price_max)
	{
		global $DB;

		$entry_ids = array();

		foreach ($this->settings['product_weblogs'] as $weblog_id)
		{
			if (isset($this->settings['product_weblog_fields'][$weblog_id]['price']))
			{
				$price_field = $this->_get_field_id($this->settings['product_weblog_fields'][$weblog_id]['price']);

				$sql = "SELECT entry_id FROM exp_weblog_data WHERE $price_field != ''";
				$sql .= ($price_min != '') ? " AND $price_field >= ".$DB->escape_str($price_min) : '';
				$sql .= ($price_max != '') ? " AND $price_field <= ".$DB->escape_str($price_max) : '';

				$query = $DB->query($sql);

				if ($query->num_rows)
				{
					foreach ($query->result as $row)
					{
						$entry_ids[] = $row['entry_id'];
					}
				}
			}	
		}

		return $entry_ids;
	}
	
	/**
	 * Redirects to the specified location
	 * Can parse {path} and {site_url} tags
	 * If the location doesn't begin with a / or http
	 * this will create a full URL from the path given
	 * using the Function class' create_url method
	 * 
	 * template tag params:
	 * 	redirect
	 * 
	 * @access private
	 * @param string $location
	 * @return void
	 */
	function _redirect($location = FALSE)
	{
		global $FNS; 

		if ($this->_parse_path($location))
		{
				if ( ! headers_sent())
				{
						header('HTTP/1.1 301 Moved Permanently');
				}
				
				$FNS->redirect($this->_parse_path($location));
		}
	}

	function _reduce_inventory($entry_id, $quantity = 1, $row_id = FALSE, $item_options = array())
	{
		global $DB, $SESS;

		$item = $this->_get_item_data($entry_id, $row_id);

		if ( ! empty($item['weblog_id']))
		{
			$inventory_field = $this->_get_inventory_field($item['weblog_id']);
		
			if ($inventory_field)
			{
				$field_type = $this->_get_field_type($inventory_field);
				
				if ($field_type == 'ct_price_mod' || $field_type == 'ff_matrix' || $field_type == 'matrix')
				{
					$field_name = $this->_get_field_name($inventory_field);
					
					if ($field_type == 'ff_matrix')
					{
						$ff_settings = $this->_get_ff_settings($inventory_field);
						
						$price_modifiers = $this->_parse_ff_matrix_price_modifier($field_name, $item['field_id_'.$inventory_field], $ff_settings);
					}
					elseif ($field_type == 'matrix')
					{
						$ff_settings = $this->_get_ff_settings($inventory_field);
						
						$price_modifiers = $this->_parse_matrix_price_modifier($field_name, $item['field_id_'.$inventory_field], $ff_settings, $entry_id);
					}
					else
					{
						$price_modifiers = $this->_unserialize($item['field_id_'.$inventory_field]);
					}
					
					foreach ($price_modifiers as $index => $price_modifier)
					{
						if (isset($price_modifier['inventory']) && $price_modifier['inventory'] !== '' && isset($item_options[$field_name]) && $item_options[$field_name] == $price_modifier['option'])
						{
							$inventory = $this->_sanitize_number($price_modifier['inventory'], TRUE) - $this->_sanitize_number($quantity);
							
							if ($field_type == 'matrix')
							{
								//@TODO matrix reduce inventory
								
								if (empty($item['field_id_'.$inventory_field]))
								{
									continue;
								}
								
								$ff_settings = $this->_get_ff_settings($inventory_field);
								
								if ( ! $ff_settings)
								{
									continue;
								}
								
								$query = $DB->query("SELECT col_id, col_name
										    FROM exp_matrix_cols
										    WHERE col_id IN ('".implode("','", $ff_settings['col_ids'])."')
										    AND col_name IN ('inventory', 'option')");
								
								if ($query->num_rows != 2)
								{
									continue;
								}
								
								foreach ($query->result as $row)
								{
									switch($row['col_name'])
									{
										case 'inventory':
											$inventory_col_id = $row['col_id'];
											break;
										case 'option':
											$option_col_id = $row['col_id'];
											break;
									}
								}
								
								$DB->query(
									$DB->update_string(
										'exp_matrix_data',
										array(
											'col_id_'.$inventory_col_id => $inventory
										),
										array(
											'field_id' => $inventory_field,
											'col_id_'.$option_col_id => $item_options[$field_name],
											'entry_id' => $entry_id
										)
									)
								);
							}
							else
							{
								if ($field_type == 'ff_matrix')
								{
									$field_data = $this->_unserialize($item['field_id_'.$inventory_field]);
									
									$inventory_index = $option_index = FALSE;
									
									foreach ($ff_settings['cols'] as $key => $matrix_field)
									{
										if ($matrix_field['name'] == 'inventory')
										{
											$inventory_index = $key;
										}
										
										if ($matrix_field['name'] == 'option')
										{
											$option_index = $key;
										}
									}
							
									if ($inventory_index !== FALSE && $option_index !== FALSE)
									{
										foreach ($field_data as $index => $row)
										{
											if ($row[$option_index] == $item_options[$field_name])
											{
												$field_data[$index][$inventory_index] = $inventory;
											}
										}
									}
								}
								else
								{
									$price_modifiers[$index]['inventory'] = $inventory;
									
									$field_data = $price_modifiers;
								}
								
								$DB->query($DB->update_string('exp_weblog_data', array('field_id_'.$inventory_field => serialize($field_data)), array('entry_id' => $entry_id)));
							
								if (isset($SESS->cache['cartthrob']['items'][$entry_id]))
								{
									$SESS->cache['cartthrob']['items'][$entry_id]['field_id_'.$inventory_field] = serialize($field_data);
								}
							}
			
							return ($inventory > 0);
						}
					}
				}
				elseif (isset($item['field_id_'.$inventory_field]) && $item['field_id_'.$inventory_field] !== '')
				{
					$inventory = $this->_sanitize_number($item['field_id_'.$inventory_field], TRUE) - $this->_sanitize_number($quantity);
	
					$DB->query($DB->update_string('exp_weblog_data', array('field_id_'.$inventory_field => $inventory), array('entry_id' => $entry_id)));
	
					if (isset($SESS->cache['cartthrob']['items'][$entry_id]))
					{
						$SESS->cache['cartthrob']['items'][$entry_id]['field_id_'.$inventory_field] = $inventory;
					}
	
					return ($this->_sanitize_number($item['field_id_'.$inventory_field]) > 0);
				}
			}
		}
	}

	function _remove_coupon_code($coupon_code)
	{
		$this->_session_start();

		$key = array_search($coupon_code, $_SESSION['cartthrob']['coupon_codes']);

		unset($_SESSION['cartthrob']['coupon_codes'][$key]);
	}
	/**
	 * _request_shipping_quote_form_submit
	 * Gets a quoted shipping value from the default shipping method, and applies that value as the shipping value
	 * 
	 * @since 1.0
	 * @param $TMPL->shipping_plugin
	 * @param $TMPL->validate (checks required fields)
	 * @return string
	 * @author Chris Newton
	 **/
	function _request_shipping_quote_form_submit()
	{
		global $IN, $REGX, $EXT, $FNS;

		$this->_session_start();

		// -------------------------------------------
		// 'cartthrob_get_shipping_quote_start' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_get_shipping_quote_start') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_get_shipping_quote_start', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}

		$this->_check_security_hash();

		if ($IN->GBL('language', 'POST'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}

		$not_required = array();
		$required = array(); 
		
		if ($IN->GBL('REQ', 'POST'))
		{
			$required_string = $this->_decode_string($IN->GBL('REQ', 'POST'));

			if (preg_match('/^not (.*)/', $required_string, $matches))
			{
				$not_required = explode('|', $matches[1]);
				$required_string = '';
			}

			if ($required_string)
			{

				$required = explode('|', $required_string);
			}

			unset($required_string);
		}

		$shipping_plugin = $this->_xss_clean($IN->GBL('shipping_plugin', 'POST'));

		// LOAD IN PASSED IN VALUE, OR DEFAULT 
		
		// for some reason the passed in value is ignored, and the default is being used. 
		if ($shipping_plugin)
		{
			$this->_load_shipping_plugin($shipping_plugin);
			$shipping_name = $this->SHP->plugin_info['title'];
		}
		else
		{
			$this->_load_shipping_plugin();
			$shipping_name = $this->SHP->plugin_info['title'];
		}
		//fetch plugin's required fields
		if ( isset($this->SHP->plugin_info['required_fields']) && is_array($this->SHP->plugin_info['required_fields']))
		{
			$required = array_merge($required, $this->SHP->plugin_info['required_fields']);
		}

		if ($this->_bool_param('validate', TRUE) && count($required) && ! $this->_validate_required($required, TRUE))
		{
			return '';
		}
		$saved_customer_info = $this->_get_customer_info();

		foreach ($this->customer_fields as $field)
		{
			$customer_info[$field] = (isset($saved_customer_info[$field]) && $IN->GBL($field, 'POST') === FALSE) ? $saved_customer_info[$field] : $this->_xss_clean($IN->GBL($field, 'POST'));
		}
		$this->_save_customer_info();


		$data = array(
			'price'				=> 0, 
			'error_message'		=> "", 
			'quoting_available'	=> FALSE, 
			'failed'			=> TRUE, 
			'shipping_option' 	=> $shipping_name,
			'shipping_methods'	=> array(),
			);

		if ( ! $this->SHP || ! is_object($this->SHP) || ! $this->_method_exists($this->SHP, 'get_shipping_quote'))
		{
			$data = array(
				'price'				=> 0, 
				'quoting_available'	=> FALSE,
				'error_message'		=> $data['shipping_option']. " does not provide estimated costs ", 
				'failed'			=> TRUE, 
				);
		}
		else
		{
			if ($this->_method_exists($this->SHP, 'get_shipping_quote'))
			{
				$shipping_info 	 = array(); 
				
				if ($IN->GBL('shipping_mode', 'POST'))
				{
					$rate = $this->_xss_clean($IN->GBL('shipping_mode', 'POST'));
				}
				else
				{
					$rate = "rate";
				}
				$shipping_info	 = $this->SHP->get_shipping_quote($rate);
				$cost 			 = $this->_round($shipping_info['price']); 

				
				if ($shipping_info['price'])
				{
					$data = array(
						'price'				=> $cost, 
						'error_message'		=> "", 
						'failed'			=> FALSE, 
						'quoting_available' => TRUE,
						'shipping_methods'  => $shipping_info['shipping_methods'],
						'shipping_option'  => $shipping_info['shipping_option'],
						);
					
					if ($rate == "rate")
					{
						if ($cost > 0)
						{
							if ($this->_method_exists($this->SHP, 'set_shipping'))
							{
								$this->SHP->set_shipping( $cost ) ; 
							}
						}
					}
				}
				else
				{
					$data = array(
						'price'				=> 0, 
						'error_message'		=> $shipping_info['error_message'], 
						'failed'			=> TRUE, 
						'quoting_available' => TRUE,
						'shipping_methods'  => $shipping_info['shipping_methods'],
						'shipping_option'  => $shipping_info['shipping_option'],
						
						);
				}
			}
			else
			{
				$data = array(
					'price'				=> 0, 
					'error_message'		=> $data['shipping_option']. "does not provide estimated costs ", 
					'failed'			=> TRUE, 
					'quoting_available'	=> FALSE,
					'shipping_methods'  => $shipping_info['shipping_methods'],
					'shipping_option'  => $shipping_info['shipping_option'],
					
					);
			}
		}	

		foreach ($data as $key => $value)
		{
			$_SESSION['cartthrob']['shipping'][$key] = $value; 
		}
		
		
		//var_dump($_SESSION['cartthrob']['shipping']);exit; 
		

		// -------------------------------------------
		// 'cartthrob_get_shipping_quote_end' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_get_shipping_quote_end') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_get_shipping_quote_end', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}

		$this->_clear_security_hash();

		$return = ($IN->GBL('return', 'POST')) ? $this->_xss_clean($IN->GBL('return', 'POST')) : $FNS->fetch_site_index(1);
		
		$this->_redirect($return);

	}
	// END

	function _round($number = FALSE)
	{
		global $TMPL;
		
		if ($number === FALSE)
		{
			return '';
		}

		$number = $this->_sanitize_number($number);

		$decimals = (is_object($TMPL) && $TMPL->fetch_param('decimals') !== FALSE) ? (int) $TMPL->fetch_param('decimals') : $this->number_format_defaults['decimals'];
		
		switch ($this->settings['rounding_default'])
		{
			case "swedish":
				return (round(20*number_format($number, 2, '.', '')))/20;
			break; 
			case "new_zealand": 
				return (round(10*number_format($number, 2, '.', '')))/10;
			break; 
			default: 
				return number_format($number, $decimals, '.', '');
			break; 
		}
		return number_format($number, $decimals, '.', '');
	}

	/**
	 * Strips all non-numeric formatting from a string
	 *
	 * @access private
	 * @param string $credit_card_number
	 * @return int|string
	 */
	function _sanitize_credit_card_number($credit_card_number = NULL)
	{
		if ( ! $credit_card_number)
		{
			return '';
		}

		return (string) preg_replace('/[^0-9]/', '', $credit_card_number);
	}
	
	function _sanitize_integer($number = NULL, $allow_negative = FALSE)
	{
		return (int) $this->_sanitize_number($number, $allow_negative);
	}

	/**
	 * Removes all non-numeric, non-decimal formatting from a string
	 *
	 * @access private
	 * @param string $number
	 * @return float|string|int
	 */
	function _sanitize_number($number = NULL, $allow_negative = FALSE)
	{
		if (is_int($number) || is_float($number) || is_double($number) || ctype_digit($number))
		{
			return $number;
		}

		if ( ! $number)
		{
			return 0;
		}

		$prefix = ($allow_negative && preg_match('/^-/', $number)) ? '-' : '';

		return $prefix.preg_replace('/[^0-9\.]/', '', $number);
		//return (float) preg_replace('/[^0-9\.]/', '', $number);
	}
	
	function _save_customer_info($relaxed = FALSE)
	{
		global $IN, $DB, $SESS;
		
		$customer_info = array();
		
		if ( ! isset($_POST['country_code']))
		{
			if ($IN->GBL('derive_country_code', 'POST') === 'shipping_country' && $IN->GBL('shipping_country', 'POST') && array_key_exists($IN->GBL('shipping_country', 'POST'), $this->countries))
			{
				$_POST['country_code'] = $IN->GBL('shipping_country', 'POST');
			}
			elseif ($IN->GBL('country', 'POST') && array_key_exists($IN->GBL('country', 'POST'), $this->countries))
			{
				$_POST['country_code'] = $IN->GBL('country', 'POST');
			}
		}

		$query = $DB->query("SELECT * FROM exp_member_fields ORDER BY m_field_label ASC"); 
		$member_fields = $query->result; 
		unset($query);
		
		foreach ($this->customer_fields as $field)
		{
			$ready = ($relaxed === FALSE) ? isset($_POST[$field]) : ! empty($_POST[$field]);
			
			if ($ready && ! is_numeric($field) && ! in_array($field, array('shipping_option', 'return')))
			{
				$customer_info[$field] = $this->_xss_clean($IN->GBL($field, 'POST'));
				
				// updating member fields
				if ($SESS->userdata['member_id'] && $this->settings['save_member_data'] == "1" )
				{
					if (!empty($this->settings['member_'.$field.'_field']))
					{
						$member_data['m_field_id_'.$this->settings['member_'.$field.'_field']] = $this->_xss_clean($IN->GBL($field, 'POST')); 
					}
				}
			}
		}
		
		if (!empty($member_data) && $SESS->userdata['member_id'])
		{
			$DB->query($DB->update_string('exp_member_data', $member_data, "member_id = '".$SESS->userdata['member_id']."'")); 
		}

		$_SESSION['cartthrob']['customer_info'] = array_merge($_SESSION['cartthrob']['customer_info'], $customer_info);

		if (isset($_POST['shipping_option']))
		{
			$_SESSION['cartthrob']['shipping']['shipping_option'] = $this->_xss_clean($IN->GBL('shipping_option', 'POST'));
		}

		if (isset($_POST['shipping']) && is_array($IN->GBL('shipping', 'POST')))
		{
			foreach ($IN->GBL('shipping', 'POST') as $key => $value)
			{
				$_SESSION['cartthrob']['shipping'][$key] = $this->_xss_clean($value);
			}
		}

		if ($IN->GBL('language', 'POST'))
		{
			$this->_set_language($this->_xss_clean($IN->GBL('language', 'POST')));
		}
		
		if (is_array($IN->GBL('custom_data', 'POST')))
		{
			if (isset($_SESSION['cartthrob']['custom_data']))
			{
				$_SESSION['cartthrob']['custom_data'] = array_merge($_SESSION['cartthrob']['custom_data'], $this->_xss_clean($IN->GBL('custom_data', 'POST')));
			}
			else
			{
				$_SESSION['cartthrob']['custom_data'] = $this->_xss_clean($IN->GBL('custom_data', 'POST'));
			}
		}
	}

	function _save_customer_info_submit($standalone = TRUE)
	{
		global $FNS, $IN, $REGX;

		$this->_check_security_hash();
		
		$required = ($IN->GBL('REQ', 'POST')) ? explode('|', $this->_decode_string($IN->GBL('REQ', 'POST'))) : array();
		
		$this->_save_customer_info(TRUE);
		
		$this->_validate_required($required);
		
		$this->_save_customer_info();

		$this->_clear_security_hash();

		$this->_redirect($IN->GBL('return', 'POST') ? $IN->GBL('return', 'POST') : $FNS->fetch_site_index());
	}

	/**
	 * Save the contents of an order to orders weblog
	 * 
	 * @access private
	 * @param array $order_data
	 * @return int $entry_id
	 */
	function _save_order($order_data = array())
	{
		global $DB, $SESS, $IN, $LOC, $STAT, $REGX, $PREFS, $FNS;

		$weblog_id = $this->_get_weblog_id($this->_orders_weblog);

		if ( ! $weblog_id)
		{
			return 0;
		}

		$this->_load_field_data();

		$exp_weblog_titles = array(
			'author_id' => (!empty($order_data['create_user']) ? $order_data['create_user'] : $this->_get_member_id() ),
			'site_id' => $PREFS->ini('site_id'),
			'weblog_id' => $weblog_id,
			'ip_address' => $IN->IP,
			'entry_date' => $LOC->convert_human_date_to_gmt($LOC->set_human_time()),
			'edit_date' => date("YmdHis"),
			'versioning_enabled' => 'y',
			'status' => ($this->settings['orders_processing_status']) ? $this->settings['orders_processing_status'] : 'closed',
			'forum_topic_id' => 0,
		);
		
		if ( ! empty($order_data['expiration_date']))
		{
			$exp_weblog_titles['expiration_date'] = $exp_weblog_titles['entry_date'] + ($order_data['expiration_date']*24*60*60);
			unset($order_data['expiration_date']);
		}
		
		$exp_weblog_titles['year'] = date('Y', $exp_weblog_titles['entry_date']);
		$exp_weblog_titles['month'] = date('m', $exp_weblog_titles['entry_date']);
		$exp_weblog_titles['day'] = date('d', $exp_weblog_titles['entry_date']);

		unset($query);
		
		$order_number = 1;
		
		$entry_id = 0;

		if ($this->settings['orders_sequential_order_numbers'])
		{
			$query = $DB->query("SELECT title
						FROM exp_weblog_titles
						WHERE weblog_id = '".$DB->escape_str($weblog_id)."'
						AND site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
						AND title LIKE ('".$DB->escape_str($this->settings['orders_title_prefix']).'%'.$DB->escape_str($this->settings['orders_title_suffix'])."')
						ORDER BY entry_date DESC
						LIMIT 1");
			
			if ($query->num_rows)
			{
				$order_number = (int) str_replace(array($this->settings['orders_title_prefix'], $this->settings['orders_title_suffix']), '', $query->row['title']) + 1;
			}
			
			$exp_weblog_titles['title'] = $this->settings['orders_title_prefix'].$order_number.$this->settings['orders_title_suffix'];
			$exp_weblog_titles['url_title'] = $this->settings['orders_url_title_prefix'].$order_number.$this->settings['orders_url_title_suffix'];
			
			$DB->query($DB->insert_string('exp_weblog_titles', $exp_weblog_titles));

			$entry_id = $DB->insert_id;
		}
		else
		{
			$DB->query($DB->insert_string('exp_weblog_titles', $exp_weblog_titles));

			$order_number = $entry_id = $DB->insert_id;

			$DB->query($DB->update_string(
				'exp_weblog_titles',
				array('title' => $this->settings['orders_title_prefix'].$order_number.$this->settings['orders_title_suffix'], 'url_title' => $this->settings['orders_url_title_prefix'].$order_number.$this->settings['orders_url_title_suffix']),
				array('entry_id' => $entry_id)
			));
		}

		$exp_weblog_data = array(
			'entry_id' => $entry_id,
			'weblog_id' => $weblog_id,
			'site_id' => $PREFS->ini('site_id')
		);

		$orders_items_field_id = $this->_get_field_id($this->_orders_items_field, FALSE);

		if ($orders_items_field_id !== FALSE)
		{
			$field_type = $this->_get_field_type($orders_items_field_id);

			$items = $this->_get_items();

			if ($field_type == 'ff_matrix' && $ff_settings = $this->_get_ff_settings($orders_items_field_id))
			{
				$item_array = array();

				foreach ($items as $row_id => $item)
				{
					$item_data = $this->_get_item_data($item['entry_id']);

					$single_data = array();

					foreach ($ff_settings['cols'] as $key=>$matrix_field)
					{
						if ($matrix_field['name'] == 'quantity')
						{
							//$single_data[$key] = $this->_get_quantity($item['entry_id']);
							$single_data[$key] = $item['quantity'];
						}
						elseif ($matrix_field['name'] == 'product_id' || $matrix_field['name'] == 'entry_id')
						{
							$single_data[$key] = $item_data['entry_id'];
						}
						elseif ($matrix_field['name'] == 'price')
						{
							$single_data[$key] = $this->_get_item_price($item_data['entry_id'], $row_id);
						}
						elseif (isset($item_data[$matrix_field['name']]))
						{
							$single_data[$key] = $item_data[$matrix_field['name']];
						}
						elseif (isset($item['item_options'][$matrix_field['name']]))
						{
							$single_data[$key] = $item['item_options'][$matrix_field['name']];
						}
					}

					$item_array[] = $single_data;
				}

				$exp_weblog_data[$this->_get_field_id($this->_orders_items_field)] = addslashes(serialize($item_array));
				$exp_weblog_data[$this->_get_field_id($this->_orders_items_field, 'fmt')] = $this->_get_field_fmt($this->_orders_items_field);
			}
			elseif ($field_type == 'ct_items')
			{
				$item_array = array();

				foreach ($items as $row_id => $item)
				{
					$item_data = $this->_get_item_data($item['entry_id']);

					$single_data = array(
						'entry_id' => $item_data['entry_id'],
						'title' => @$item_data['title'],
						'quantity' => $item['quantity'],
						'price' => $this->_get_item_price($item_data['entry_id'], $row_id)
					);

					if (isset($item['item_options']) && is_array($item['item_options']))
					{
						$single_data = array_merge($single_data, $item['item_options']);
					}

					$item_array[] = $single_data;
				}

				$exp_weblog_data[$this->_get_field_id($this->_orders_items_field)] = addslashes(serialize($item_array));
				$exp_weblog_data[$this->_get_field_id($this->_orders_items_field, 'fmt')] = $this->_get_field_fmt($this->_orders_items_field);
			}
			else
			{
				$item_string = '';

				for ($i=0; $i<count($items); $i++)
				{
					$item_string .= $items[$i]['entry_id'].'|'.$items[$i]['quantity'];

					if ($i+1 != count($items))
					{
						$item_string .= ',';
					}
				}

				$exp_weblog_data[$this->_get_field_id($this->_orders_items_field)] = $item_string;
				$exp_weblog_data[$this->_get_field_id($this->_orders_items_field, 'fmt')] = $this->_get_field_fmt($this->_orders_items_field);
			}
		}
		
		$custom_data = $this->_get_customer_custom_data();

		foreach ($this->_get_fields_by_weblog($weblog_id) as $field_id)
		{
			if ($IN->GBL($this->_get_field_name($field_id), 'POST') !== FALSE)
			{
				$exp_weblog_data[$this->_get_field_id($field_id)] = $this->_xss_clean($IN->GBL($this->_get_field_name($field_id), 'POST'));
				$exp_weblog_data[$this->_get_field_id($field_id, 'fmt')] = $this->_get_field_fmt($field_id);
			}
			
			if (isset($custom_data[$this->_get_field_name($field_id)]))
			{
				$exp_weblog_data[$this->_get_field_id($field_id)] = $custom_data[$this->_get_field_name($field_id)];
				$exp_weblog_data[$this->_get_field_id($field_id, 'fmt')] = $this->_get_field_fmt($field_id);
			}
		}

		if ($this->settings['orders_subtotal_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_subtotal_field'])] = @$order_data['subtotal'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_subtotal_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_subtotal_field']);
		}
		if ($this->settings['orders_tax_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_tax_field'])] = @$order_data['tax'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_tax_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_tax_field']);
		}
		if ($this->settings['orders_shipping_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_field'])] = @$order_data['shipping'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_field']);
		}
		if ($this->settings['orders_total_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_total_field'])] = @$order_data['total'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_total_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_total_field']);
		}
		if ($this->settings['orders_discount_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_discount_field'])] = @$order_data['discount'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_discount_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_discount_field']);
		}
		if ($this->settings['orders_coupon_codes'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_coupon_codes'])] = @$order_data['coupon_codes'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_coupon_codes'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_coupon_codes']);
		}
		if ($this->settings['orders_last_four_digits'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_last_four_digits'])] = @$order_data['last_four_digits'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_last_four_digits'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_last_four_digits']);
		}
		if ($this->settings['orders_transaction_id'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_transaction_id'])] = @$order_data['transaction_id'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_transaction_id'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_transaction_id']);
		}
		if ($this->settings['orders_customer_name'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_name'])] = @$order_data['customer_name'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_name'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_customer_name']);
		}
		if ($this->settings['orders_customer_email'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_email'])] = @$order_data['customer_email'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_email'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_customer_email']);
		}
		if ($this->settings['orders_customer_ip_address'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_ip_address'])] = @$order_data['customer_ip_address'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_ip_address'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_customer_ip_address']);
		}
		if ($this->settings['orders_customer_phone'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_phone'])] = @$order_data['customer_phone'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_customer_phone'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_customer_phone']);
		}
		if ($this->settings['orders_full_billing_address'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_full_billing_address'])] = @$order_data['full_billing_address'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_full_billing_address'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_full_billing_address']);
		}
		if ($this->settings['orders_billing_first_name'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_first_name'])] = @$order_data['billing_first_name'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_first_name'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_first_name']);
		}
		if ($this->settings['orders_billing_last_name'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_last_name'])] = @$order_data['billing_last_name'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_last_name'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_last_name']);
		}
		if ($this->settings['orders_billing_company'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_company'])] = @$order_data['billing_company'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_company'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_company']);
		}
		if ($this->settings['orders_billing_address'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_address'])] = @$order_data['billing_address'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_address'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_address']);
		}
		if ($this->settings['orders_billing_address2'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_address2'])] = @$order_data['billing_address2'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_address2'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_address2']);
		}
		if ($this->settings['orders_billing_city'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_city'])] = @$order_data['billing_city'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_city'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_city']);
		}
		if ($this->settings['orders_billing_state'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_state'])] = @$order_data['billing_state'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_state'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_state']);
		}
		if ($this->settings['orders_billing_zip'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_zip'])] = @$order_data['billing_zip'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_zip'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_zip']);
		}
		if ($this->settings['orders_billing_country'])
		{
			if ($this->settings['orders_convert_country_code'])
			{
				if (isset($order_data['billing_country_code']))
				{
					$order_data['billing_country'] = $this->convert_country_code($order_data['billing_country_code']);
				}
				
			}
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_country'])] = @$order_data['billing_country'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_billing_country'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_billing_country']);
		}
		if ($this->settings['orders_country_code'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_country_code'])] = @$order_data['country_code'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_country_code'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_country_code']);
		}
		if ($this->settings['orders_full_shipping_address'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_full_shipping_address'])] = @$order_data['full_shipping_address'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_full_shipping_address'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_full_shipping_address']);
		}
		if ($this->settings['orders_shipping_first_name'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_first_name'])] = @$order_data['shipping_first_name'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_first_name'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_first_name']);
		}
		if ($this->settings['orders_shipping_last_name'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_last_name'])] = @$order_data['shipping_last_name'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_last_name'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_last_name']);
		}
		if ($this->settings['orders_shipping_company'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_company'])] = @$order_data['shipping_company'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_company'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_company']);
		}
		if ($this->settings['orders_shipping_address'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_address'])] = @$order_data['shipping_address'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_address'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_address']);
		}
		if ($this->settings['orders_shipping_address2'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_address2'])] = @$order_data['shipping_address2'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_address2'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_address2']);
		}
		if ($this->settings['orders_shipping_city'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_city'])] = @$order_data['shipping_city'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_city'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_city']);
		}
		if ($this->settings['orders_shipping_state'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_state'])] = @$order_data['shipping_state'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_state'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_state']);
		}
		if ($this->settings['orders_shipping_zip'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_zip'])] = @$order_data['shipping_zip'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_zip'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_zip']);
		}
		if ($this->settings['orders_shipping_country'])
		{
			if ($this->settings['orders_convert_country_code'])
			{
				if (isset($order_data['shipping_country_code']) )
				{
					$order_data['shipping_country'] = $this->convert_country_code($order_data['shipping_country_code']);
				}
			}
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_country'])] = @$order_data['shipping_country'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_country'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_country']);

		}
		if ($this->settings['orders_shipping_country_code'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_country_code'])] = @$order_data['shipping_country_code'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_country_code'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_country_code']);
		}
		
		if ($this->settings['orders_shipping_option'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_option'])] = @$order_data['shipping_option'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_shipping_option'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_shipping_option']);
		}
		if ($this->settings['orders_error_message_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_error_message_field'])] = @$order_data['error_message'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_error_message_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_error_message_field']);
		}
		if ($this->settings['orders_language_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_language_field'])] = ($IN->GBL('language', 'COOKIE')) ? $IN->GBL('language', 'COOKIE') : @$SESS->userdata['language'];
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_language_field'], 'fmt')] = $this->_get_field_fmt($this->settings['orders_language_field']);
		}

		$DB->query($DB->insert_string('exp_weblog_data', $exp_weblog_data));

		if (!empty($order_data['create_user']))
		{
			$DB->query($DB->update_string(
				'exp_members',
				array('total_entries' => $SESS->userdata['total_entries'] + 1, 'last_entry_date' => $LOC->now),
				array('member_id' => $order_data['create_user'])
			));	
		}
		elseif ($SESS->userdata['member_id'])
		{
			$DB->query($DB->update_string(
				'exp_members',
				array('total_entries' => $SESS->userdata['total_entries'] + 1, 'last_entry_date' => $LOC->now),
				array('member_id' => $SESS->userdata['member_id'])
			));
		}

		$STAT->update_weblog_stats($weblog_id);

		if ($PREFS->ini('new_posts_clear_caches') == 'y')
		{
			$FNS->clear_caching('all');
		}
		else
		{
			$FNS->clear_caching('sql');
		}

		return $entry_id;
	}

	/**
	 * Save the contents of an order to session
	 * 
	 * @access private
	 * @param float $total_cart
	 * @param array $auth
	 * @param int $order_id
	 * @return void
	 * @author Rob Sanchez
	 * @since 1.0.0
	 */
	function _save_order_to_session($order_data)
	{
		$this->_session_start();

		$_SESSION['cartthrob']['order'] = $order_data;

		/*
		$_SESSION['cartthrob']['order'] = array(
			'items'=>$this->_get_cart_items(),
			'coupon_codes'=>$this->_get_coupon_codes(),
			'total_cart'=>$total_cart,
			'auth'=>$auth,
			'order_id'=>$order_id
		);
		*/
	}
	//END

	// --------------------------------
	//  Save Purchased Item
	// --------------------------------
	/**
	 * Saves purchaed items to the purchased items weblog
	 *
	 * @param string $item 
	 * @param string $order_id 
	 * @return string Entry_id of the purchased item that was created
	 * @author Rob Sanchez
	 * @since 1.0.0
	 */
	function _save_purchased_item($item, $order_id = NULL, $status = '')
	{
		global $DB, $SESS, $IN, $LOC, $STAT, $REGX, $PREFS, $FNS;

		$weblog_id = $this->_get_weblog_id($this->_purchased_items_weblog);

		if ( ! $weblog_id)
		{
			return 0;
		}

		$query = $DB->query("SELECT deft_status, field_group FROM exp_weblogs WHERE weblog_id = '".$weblog_id."'");

		if ( ! $query->num_rows)
		{
			return 0;
		}

		$this->_load_field_data();

		$field_group = $query->row['field_group'];

		$item_data = $this->_get_item_data($item['entry_id']);

		$exp_weblog_titles = array(
			'title' => $this->settings['purchased_items_title_prefix'].$item_data['title'],
			'url_title' => $REGX->create_url_title($item_data['title'], TRUE).uniqid(NULL, TRUE),
			'author_id' => $this->_get_member_id(),
			'weblog_id' => $weblog_id,
			'site_id' => $PREFS->ini('site_id'),
			'ip_address' => $IN->IP,
			'entry_date' => $LOC->convert_human_date_to_gmt($LOC->set_human_time()),
			'edit_date' => date("YmdHis"),
			'versioning_enabled' => 'y',
			'status' => ($status) ? $status : $query->row['deft_status'],
			'forum_topic_id' => 0,
		);
		
		if ( ! empty($item['expiration_date']))
		{
			$exp_weblog_titles['expiration_date'] = $exp_weblog_titles['entry_date'] + ($item['expiration_date']*24*60*60);
		}
		
		$exp_weblog_titles['year'] = date('Y', $exp_weblog_titles['entry_date']);
		$exp_weblog_titles['month'] = date('m', $exp_weblog_titles['entry_date']);
		$exp_weblog_titles['day'] = date('d', $exp_weblog_titles['entry_date']);

		unset($query);

		$DB->query($DB->insert_string('exp_weblog_titles', $exp_weblog_titles));

		$entry_id = $DB->insert_id;

		$exp_weblog_data = array(
			'entry_id' => $entry_id,
			'site_id' => $PREFS->ini('site_id'),
			'weblog_id' => $weblog_id
		);

		if ($this->settings['purchased_items_id_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_id_field'])] = $item['entry_id'];
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_id_field'], 'fmt')] = $this->_get_field_fmt($this->settings['purchased_items_id_field']);
		}
		if ($this->settings['purchased_items_quantity_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_quantity_field'])] = $item['quantity'];
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_quantity_field'], 'fmt')] = $this->_get_field_fmt($this->settings['purchased_items_quantity_field']);
		}
		if (isset($item['price']) && $this->settings['purchased_items_price_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_price_field'])] = $item['price'];
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_price_field'], 'fmt')] = $this->_get_field_fmt($this->settings['purchased_items_price_field']);
		}
		if ($order_id && $this->settings['purchased_items_order_id_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_order_id_field'])] = $order_id;
			$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_order_id_field'], 'fmt')] = $this->_get_field_fmt($this->settings['purchased_items_order_id_field']);
		}
		if ($this->settings['purchased_items_license_number_field'] && ! empty($item['license_number']))
		{
			$field_id = $this->_get_field_id($this->settings['purchased_items_license_number_field']);

			$limit = 25;

			$license_number = '';

			do
			{
				$license_number = $this->_generate_license_number($this->settings['purchased_items_license_number_type']);

				$query = $DB->query("SELECT COUNT(*) as count FROM exp_weblog_data WHERE $field_id = '".$DB->escape_str($license_number)."'");

				$limit --;

			} while($query->row['count'] > 0 && $limit >= 0);

			if ($limit >= 0 && $license_number)
			{
				$exp_weblog_data[$field_id] = $license_number;
				$exp_weblog_data[$this->_get_field_id($this->settings['purchased_items_license_number_field'], 'fmt')] = $this->_get_field_fmt($this->settings['purchased_items_license_number_field']);
			}
		}

		foreach ($this->_get_fields_by_group($field_group) as $field_id)
		{
			if ($IN->GBL($this->_get_field_name($field_id), 'POST') !== FALSE)
			{
				$exp_weblog_data[$this->_get_field_id($field_id)] = $this->_xss_clean($IN->GBL($this->_get_field_name($field_id), 'POST'));
				$exp_weblog_data[$this->_get_field_id($field_id, 'fmt')] = $this->_get_field_fmt($field_id);
			}

			if (isset($item['item_options'][$this->_get_field_name($field_id)]))
			{
				$exp_weblog_data[$this->_get_field_id($field_id)] = $item['item_options'][$this->_get_field_name($field_id)];
				$exp_weblog_data[$this->_get_field_id($field_id, 'fmt')] = $this->_get_field_fmt($field_id);
			}
			
			if (preg_match('/^purchased_(.*)/', $this->_get_field_name($field_id), $match) && isset($item['item_options'][$match[1]]))
			{
				$exp_weblog_data[$this->_get_field_id($field_id)] = $item['item_options'][$match[1]];
				$exp_weblog_data[$this->_get_field_id($field_id, 'fmt')] = $this->_get_field_fmt($field_id);
			}
		}

		$DB->query($DB->insert_string('exp_weblog_data', $exp_weblog_data));

		if ($SESS->userdata['member_id'])
		{
			$DB->query($DB->update_string(
				'exp_members',
				array('total_entries' => $SESS->userdata['total_entries'] + 1, 'last_entry_date' => $LOC->now),
				array('member_id' => $SESS->userdata['member_id'])
			));
		}

		$STAT->update_weblog_stats($weblog_id);

		if ($PREFS->ini('new_posts_clear_caches') == 'y')
		{
			$FNS->clear_caching('all');
		}
		else
		{
			$FNS->clear_caching('sql');
		}

		return $entry_id;
	}
	// END
	/**
	 * Save Purchased Items. 
	 *
	 * Saves purchased items to entries with a closed status. Saves entry ids to session, returns entry ids. 
	 * SESSION must still be valid for this to work, or an old session must be restarted

	 * @return array
	 * @author Chris Newton
	 */
	function _save_purchased_items()
	{
		$order_data = array(); 
		
		if ($this->_save_purchased_items)
		{
			$order_data = $this->_get_saved_order();
			if (isset($order_data['purchased_items']))
			{
				unset($order_data['purchased_items']);
			}
			foreach ($this->_get_cart_items() as $item)
			{
				if (!empty(	$this->_purchased_items_default_status))
				{
					$status =  	$this->_purchased_items_processing_status;
				}
				else
				{
					$status = "closed"; 
				}
				
				$order_data['purchased_items'][] = $this->_save_purchased_item($item, $order_data['entry_id'],$status);
			}
			
			$this->_save_order_to_session($order_data);
		}
		if (!empty($order_data['purchased_items']))
		{
			return $order_data['purchased_items']; 
		}
		else
		{
			return array(); 
		}
	}
	/**
	 * Save the chosen shipping option to session
	 * 
	 * param $_POST['shipping_option']
	 * 
	 * @access private
	 * @return void
	 */
	function _save_shipping_option()
	{
		global $IN;

		$this->_session_start();

		if ($IN->GBL('shipping_option', 'POST') !== FALSE)
		{
			$_SESSION['cartthrob']['shipping']['shipping_option'] = $this->_xss_clean($IN->GBL('shipping_option', 'POST'));
		}
	}

	// --------------------------------
	//  Send Email
	// --------------------------------
	/**
	 * Utility function, sends an email using the EE Core email class.
	 *
	 * @access private
	 * @param string $from
	 * @param string $from_name
	 * @param string $to
	 * @param string $subject
	 * @param string $message
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _send_email($from, $from_name, $to, $subject, $message, $plaintext = FALSE)
	{
		if ( ! class_exists('EEmail'))
		{
			require PATH_CORE.'core.email'.EXT;
		}

		$email = new EEmail;
		$email->validate = TRUE; 
		$email->mailtype = ($plaintext) ? 'text' : 'html';
		$email->charset = 'utf-8';
		$email->from($from, $from_name);
		$email->to($to); 
		$email->subject($subject);
		$email->message($message);
		$email->Send();
		unset($email);
	}

	/**
	 * Send the member order confirmation email
	 *
	 * @access private
	 * @param array $order_data
	 * @return void
	 */
	function _send_confirmation_email($to, $order_data)
	{
		$order_id = $order_data['order_id'] = $order_data['entry_id'];

		unset($order_data['entry_id']);

		$from = addslashes($this->settings['email_order_confirmation_from']); 
		$from_name= addslashes($this->settings['email_order_confirmation_from_name']); 
		$to = addslashes($to); 
		$subject = addslashes($this->settings['email_order_confirmation_subject']); 
		
		
		$this->_send_email(
			$from,
			$from_name,
			$to,
			$this->_parse_template_simple($subject, $order_data, array('ORDER_ID'=>$order_id)),
			$this->_parse_template_full($this->_parse_template_simple($this->settings['email_order_confirmation'], $order_data, array('ORDER_ID'=>$order_id))),
			$this->settings['email_order_confirmation_plaintext']
		);
	}

	/**
	 * Send the admin order notification email
	 *
	 * @access private
	 * @param array $order_data
	 * @return void
	 */
	function _send_admin_notification_email($order_data)
	{
		$order_id = $order_data['order_id'] = $order_data['entry_id'];

		unset($order_data['entry_id']);

		$admin_name = addslashes($this->settings['email_admin_notification_from_name']); 
		$admin_email = addslashes($this->settings['admin_email']);
		$subject = addslashes($this->settings['email_admin_notification_subject']); 
		$from = addslashes($this->settings['email_admin_notification_from']); 
		
		$this->_send_email(
			$this->_parse_template_simple($from, $order_data),
			$this->_parse_template_simple($admin_name, $order_data),
			$admin_email,
			$this->_parse_template_simple($subject, $order_data, array('ORDER_ID'=>$order_id)),
			$this->_parse_template_full($this->_parse_template_simple($this->settings['email_admin_notification'], $order_data, array('ORDER_ID'=>$order_id))),
			$this->settings['email_admin_notification_plaintext']
		);
	}

	// --------------------------------
	//  Session Start
	// --------------------------------	
	/**
	 * Starts session, builds cart array in SESSION
	 *
	 * @access private
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _session_start()
	{
		global $PREFS;

		if ( ! session_id())
		{
			session_set_cookie_params($this->settings['session_expire']);
			ini_set('session.gc_maxlifetime', $this->settings['session_expire']);
			session_start();
		}

		if ( ! isset($_SESSION['cartthrob']))
		{
			$this->_new_cart();
		}
	}
	//END 

	function _set_language($language)
	{
		global $SESS, $FNS, $LANG;
		
		if (is_array($language))
		{
			$language = (isset($language['language'])) ? $language['language'] : '';
		}

		$language = (isset($this->languages[$language])) ? $this->languages[$language] : $language;

		$SESS->userdata['language'] = $language;

		$FNS->set_cookie('language', $language, 60*60*24);

		$language_files = array(
			'cartthrob',
			'cartthrob_ext',
			'cartthrob_errors'
		);

		foreach ($language_files as $file)
		{
			$cur_used = array_search($file, $LANG->cur_used);

			if ($cur_used !== FALSE)
			{
				unset($LANG->cur_used[$cur_used]);
			}

			$LANG->fetch_language_file($file);
		}
	}
	
	function _set_config($key, $params)
	{
		if (array_key_exists($key, $this->default_settings) && isset($params['value']))
		{
			$this->_session_start();
		
			$_SESSION['cartthrob']['override_settings'][$key] = $params['value'];
		}
	}
	
	function _set_config_customer_info($params)
	{
		if ( ! empty($params['field']))
		{
			if (preg_match('/^customer_(.*)/', $params['field'], $match))
			{
				$params['field'] = $match[1];
			}
			
			$this->_session_start();
		
			$_SESSION['cartthrob']['customer_info'][$params['field']] = (isset($params['value'])) ? $params['value'] : '';
		}
	}
	/**
	 * _set_config_shipping_plugin
	 *
	 * sets the selected shipping plugin
	 * 
	 * @param string $params shipping parameter short_name (ie. by_weight_ups_xml)
	 * @return void
	 * @author Chris Newton
	 * @since 1.0
	 */
	function _set_config_shipping_plugin($params)
	{
		$this->_session_start();
	
		$_SESSION['cartthrob']['override_settings']['shipping_plugin'] = 'Cartthrob_'.$params['value'];
	}
	function _set_config_price_field($params)
	{
		$this->_session_start();
		
		if (empty($params['field']))
		{
			if (empty($params['value']))
			{
				return;
			}
			else
			{
				$params['field'] = $params['value'];
			}
		}
		
		if (empty($params['weblog_id']) || ! $this->_validate_id($params['weblog_id']))
		{
			if (empty($params['weblog']))
			{
				return;
			}
			
			$params['weblog_id'] = $this->_get_weblog_id($params['weblog']);
			
			if ( ! $this->_validate_id($params['weblog_id']))
			{
				return;
			}
		}
		
		if ( ! ($field_id = $this->_get_field_id($params['field'], FALSE)))
		{
			return;
		}
		
		/*
		$settings = (isset($this->settings['product_weblog_fields'])) ? $this->settings['product_weblog_fields'] : array();
		
		$settings[$params['weblog_id']]['price'] = $field_id;
		
		$_SESSION['cartthrob']['override_settings']['product_weblog_fields'] = $settings;
		*/
		
		$_SESSION['cartthrob']['override_settings']['product_weblog_fields'][$params['weblog_id']]['price'] = $field_id;
	}

	function _show_error($error, $json = FALSE)
	{
		global $OUT, $IN, $REGX;

		if ($json)
		{
			if ( ! is_array($error) || ! isset($error['error']))
			{
				if ( ! is_array($error))
				{
					$error = array($error);
				}
				
				$error = array('error' => 1, 'success' => 0, 'msg' => implode('<br />', $error), 'msgs' => $error);
			}

			return $this->_json($error);
		}
		else
		{
			return $OUT->show_user_error('general', $error);
		}
	}

	/**
	 * Converts a multi-line string to an array
	 *
	 * @access private
	 * @param string $data textarea content
	 * @return array
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _textarea_to_array($data)
	{
		return preg_split('/[\r\n]+/', $data);

		//return explode("\r", str_replace(array("\r\n", "\n"),array("\r","\r"), $data));
	}
	
	/**
	 * _update_cart_submit
	 * 
	 * handles submissions from the update_cart_form 
	 * redirects on completion
	 * 
	 * @access private
	 * @since 1.0
	 * @return void
	 * @author Rob Sanchez
	 */
	function _update_cart_submit()
	{
		global $IN, $REGX, $EXT;
		
		$this->_session_start();
		
		// -------------------------------------------
		// 'cartthrob_update_cart_start' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_update_cart_start') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_update_cart_start', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
		
		$restore_items = $_SESSION['cartthrob']['items'];

		$this->_save_customer_info();

		if ($IN->GBL('clear_cart','POST'))
		{
			$this->clear_cart(FALSE);
		}
		else
		{
			foreach ($this->_get_cart_items() as $row_id => $item)
			{
				$entry_id = ( ! empty($item['entry_id'])) ? $item['entry_id'] : FALSE;

				$delete_all = ($this->_get_post_by_row_id('delete_all', $row_id) !== FALSE) ? $this->_get_post_by_row_id('delete_all', $row_id) : TRUE;
				
				if ($IN->GBL('AUP', 'POST') && $IN->GBL('price', 'POST') !== FALSE && $this->_decode_bool($IN->GBL('AUP', 'POST')))
				{
					$price = $this->_sanitize_number($this->_xss_clean($IN->GBL('price', 'POST')));
					
					$this->_update_item($entry_id, $row_id, $this->_get_post_by_row_id('quantity', $row_id), $this->_get_post_by_row_id('item_options', $row_id), $delete_all, $this->_get_post_by_row_id('delete', $row_id), $price);
				
				}
				else
				{
					$this->_update_item($entry_id, $row_id, $this->_get_post_by_row_id('quantity', $row_id), $this->_get_post_by_row_id('item_options', $row_id), $delete_all, $this->_get_post_by_row_id('delete', $row_id));
				}
				

			}
		}
		// -------------------------------------------
		// 'cartthrob_update_cart_end' hook.
		//  - Developers, if you want to modify the $this object remember
		//	to use a reference on function call.
		//

		if ($EXT->active_hook('cartthrob_update_cart_end') === TRUE)
		{
			$edata = $EXT->universal_call_extension('cartthrob_update_cart_end', $this, $_SESSION['cartthrob']);
			if ($EXT->end_script === TRUE) return;
		}
		
		$this->_check_inventory(($IN->GBL('JSN', 'POST') && $this->_decode_bool($IN->GBL('JSN', 'POST'))), $restore_items);

		$this->_redirect($this->_get_redirect_url());
	}

	function _update_item($entry_id, $row_id, $quantity, $item_options, $delete_all = TRUE, $delete = FALSE, $price=NULL)
	{
		if ($delete || $quantity === 0 || $quantity === '0' || $quantity === '')
		{
			$this->_delete_from_cart($entry_id, $delete_all, $row_id);
		}
		elseif ($row_id !== FALSE || $entry_id !== FALSE)
		{
			if ($quantity !== FALSE)
			{
				$this->_change_quantity($entry_id, $quantity, $row_id);
			}

			if ($item_options && is_array($item_options))
			{
				$item = $this->_get_cart_item($entry_id, $row_id);

				foreach ($item_options as $key => $value)
				{
					$item['item_options'][$key] = $value;
				}

				$this->_session_start();

				if (isset($_SESSION['cartthrob']['items'][$row_id]))
				{
					$_SESSION['cartthrob']['items'][$row_id]['item_options'] = $item['item_options'];
					
					if ($price)
					{
						$_SESSION['cartthrob']['items'][$row_id]['price'] = $price; 
					}
				}
			}
		}
	}

	function _update_item_submit()
	{
		global $IN, $TMPL;

		$row_id = $this->_xss_clean(($IN->GBL('row_id', 'POST') !== FALSE) ? $IN->GBL('row_id', 'POST') : $IN->GBL('index', 'POST'));

		$delete_all = (isset($_POST['delete_all'])) ? $IN->GBL('delete_all', 'POST') : TRUE;

		if ($IN->GBL('AUP', 'POST') && $IN->GBL('price', 'POST') !== FALSE && $this->_decode_bool($IN->GBL('AUP', 'POST')))
		{
			$price = $this->_sanitize_number($this->_xss_clean($IN->GBL('price', 'POST')));
			
			$this->_update_item(
				$this->_xss_clean($IN->GBL('entry_id', 'POST')),
				$row_id,
				$this->_xss_clean($IN->GBL('quantity', 'POST')),
				$this->_xss_clean($IN->GBL('item_options', 'POST')),
				$delete_all,
				$IN->GBL('delete', 'POST'),
				$price
			);
		}
		else
		{
			$this->_update_item(
				$this->_xss_clean($IN->GBL('entry_id', 'POST')),
				$row_id,
				$this->_xss_clean($IN->GBL('quantity', 'POST')),
				$this->_xss_clean($IN->GBL('item_options', 'POST')),
				$delete_all,
				$IN->GBL('delete', 'POST')
			);
		}
		

		
		$this->_redirect($this->_get_redirect_url());
	}
	/**
	 * _udpate_member_group
	 *
	 * @param string $member_id 
	 * @param string $group_id 
	 * @return void
	 * @author Chris Newton
	 */
	function _update_member_group($member_id, $group_id=4)
	{
		global $DB; 
		if (! is_int($group_id))
		{
			$group_id = 4; 
		}
		if ($group_id != 4)
		{
			$DB->query("UPDATE exp_members SET group_id = '".$DB->escape_str($group_id)."' WHERE member_id = '".$DB->escape_str($member_id)."'");        
		}
	}

	function _update_order($entry_id, $data = array())
	{
		global $DB;

		$exp_weblog_data = array();

		$exp_weblog_titles = array();

		if ( ! empty($data['transaction_id']) && $this->settings['orders_transaction_id'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_transaction_id'], 'field_id')] = $data['transaction_id'];
		}

		if ( ! empty($data['error_message']) && $this->settings['orders_error_message_field'])
		{
			$exp_weblog_data[$this->_get_field_id($this->settings['orders_error_message_field'], 'field_id')] = $data['error_message'];
		}

		if ( ! empty($data['status']))
		{
			$exp_weblog_titles['status'] = $data['status'];
		}

		if (count($exp_weblog_data))
		{
			$DB->query($DB->update_string('exp_weblog_data', $exp_weblog_data, array('entry_id' => $entry_id)));
		}

		if (count($exp_weblog_titles))
		{
			$DB->query($DB->update_string('exp_weblog_titles', $exp_weblog_titles, array('entry_id' => $entry_id)));
		}
	}

	/**
	 * _set_purchased_items_status
	 *
	 * using the order's entry ID, sets the status of the related purchased items.
	 * @param string $order_id 
	 * @param string $status 
	 * @return void
	 * @author Chris Newton
	 * @since 1.0
	 */
	function _update_purchased_items($order_id, $status = NULL )
	{
		global $DB;
		
		if ($status == NULL && !empty($this->_purchased_items_default_status))
		{
			$status = $this->_purchased_items_processing_status;
		}
		else
		{
			$status = "open";
		}
		
		
		$purchased_items = $this->_get_purchased_items($order_id); 

		foreach ($purchased_items as  $entry_id)
		{
			$DB->query($DB->update_string('exp_weblog_titles', array('status' => $status), array('entry_id' => $entry_id)));
		}
	}
	
	function _unserialize($str, $stripslashes = TRUE)
	{
		$data = @unserialize($str);
		
		if ( ! is_array($data))
		{
			$data = array();
		}
		
		if ($stripslashes)
		{
			global $REGX;
			
			return $REGX->array_stripslashes($data);
		}
		
		return $data;
	}

	// --------------------------------
	//  Validate Coupon Code
	// --------------------------------
	/**
	 * Looks for coupon code in db
	 *
	 * @access private
	 * @param string $coupon_code
	 * @param array $coupon_code_data
	 * @return bool
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _validate_coupon_code($coupon_code, $coupon_code_data = FALSE)
	{
		global $DB;

		if ( ! $coupon_code_data)
		{
			$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
		}

		return $coupon_code_data['metadata']['valid'];
	}
	// END

	// --------------------------------
	//  Validate Entry Id
	// --------------------------------
	/**
	 * Checks if the specified entry_id is a positive integer
	 * If $exists is set to true, it also checks whether or not the entry exists
	 *
	 * @access private
	 * @param string $entry_id
	 * @param bool $exists
	 * @return bool
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _validate_entry_id($entry_id, $exists = FALSE)
	{
		$valid = $this->_validate_id($entry_id);

		if ($exists && $valid)
		{
			global $DB;

			$query = $DB->query("SELECT entry_id
					    FROM exp_weblog_titles
					    WHERE entry_id = '".$DB->escape_str($entry_id)."' LIMIT 1");

			return ((bool) $query->num_rows);
		}

		return $valid;
	}
	// END
	
	function _validate_id($id)
	{
		return ($id && (ctype_digit($id) || is_int($id)) && $id > 0);
	}

	// --------------------------------
	//  Validate Required
	// --------------------------------
	/**
	 * Checks if all the specified required fields have been entered
	 * If $check_saved is set to true, it also checks whether the field has been previously
	 * entered and saved in the session
	 *
	 * @access private
	 * @param array $required
	 * @param bool $check_saved
	 * @return bool
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _validate_required($required, $check_saved = FALSE)
	{
		global $OUT, $LANG;

		$errors = array();

		foreach ($required as $field)
		{
			if ($field)
			{
				if ($check_saved)
				{
					$saved_customer_info = $this->_get_customer_info();

					if (( ! isset($_POST[$field]) || $_POST[$field] == '') && ( ! array_key_exists($field, $saved_customer_info)))
					{
						$errors[] = ($LANG->line('validation_'.$field)) ? $LANG->line('validation_'.$field) : $field;
					}
				}
				else
				{
					if ( ! isset($_POST[$field]) || $_POST[$field] == '')
					{
						$errors[] = ($LANG->line('validation_'.$field)) ? $LANG->line('validation_'.$field) : $field;
					}
				}
			}
		}

		if (count($errors))
		{
			$OUT->show_user_error('off', $errors, $LANG->line('validation_missing_fields'));
			return FALSE;
		}

		return TRUE;
	}
	// END

	function _var_pair_tagdata($var_name_full, $tagdata = FALSE)
	{
		global $TMPL;

		$tagdata = ($tagdata !== FALSE) ? $tagdata : $TMPL->tagdata;

		if (strpos($var_name_full, ' ') !== FALSE)
		{
			$var_name = substr($var_name_full, 0, strpos($var_name_full, ' '));
		}
		else
		{
			$var_name = $var_name_full;
		}

		if (preg_match("/".LD.preg_quote($var_name_full).RD."(.*?)".LD.SLASH.$var_name.RD."/s", $tagdata, $match))
		{
			return $match[1];
		}

		return '';
	}
	
	function _xss_clean($obj)
	{
		global $REGX;
		
		if (is_array($obj))
		{
			foreach ($obj as $key => $value)
			{
				$obj[$key] = $this->_xss_clean($value);
				
				return $obj;
			}
		}
		else
		{
			return $REGX->xss_clean($obj);
		}
	}

	// --------------------------------
	//  Log
	// --------------------------------
	/**
	 * log
	 *
	 * writes a string to EE's console log
	 *
	 * @param string $action 
	 * @return void
	 * @author Rob Sanchez
	 * @since 1.0
	 * @access public
	 */
	function log($action)
	{
		
		if ( ! empty($this->js_logging))
		{
			if (is_array($action))
			{
				foreach ($action as $act)
				{
					echo "<script type=\"text/javascript\">if (window.console){ console.log('$act'); }</script>";
				}
			}
			else
			{
				echo "<script type=\"text/javascript\">if (window.console){ console.log('$action'); }</script>";
			}
		}
		
		if ( ! empty($this->logging) || $this->settings['enable_logging'])
		{
			if (empty($this->LOG))
			{
				if ( ! file_exists(PATH_CP.'cp.log'.EXT))
				{
					return;
				}
				
				require_once(PATH_CP.'cp.log'.EXT);
	
				$this->LOG = new Logger;
			}
			
			$this->LOG->log_action($action);
		}
		

	}
	// END
	
	
	/* DEPRECATED METHODS */
	
	
	// deprecated, use total_items_count
	function cart_count()
	{
		return $this->total_items_count(); 
	}
	// deprecated, use total_items_count
	function total_items()
	{
		return $this->total_items_count(); 
	}
	// deprecated, use unique_items_count
	function total_unique_items()
	{
		return $this->unique_items_count(); 
	}
	// deprecated, use debug_info
	function cart_debug()
	{
		return $this->debug_info(); 
	}
	// deprecated, use view_convert_currency
	function convert_currency($number = FALSE)
	{
		return $this->view_convert_currency($number);
	}
	// deprecated, use add_coupon_form
	function coupon_code_form()
	{
		return $this->add_coupon_form();
	}
	// deprecated, use https_redirect
	function force_ssl()
	{
		$this->https_redirect();
	}
	// deprecated, use https_redirect
	function force_https()
	{
		return $this->https_redirect();
	}
	// deprecated, use selected_gateway_fields
	function gateway_fields($gateway = FALSE)
	{
		return $this->selected_gateway_fields($gateway);
	}
	// deprecated, use is_purchased_item
	function has_purchased()
	{
		return $this->is_purchased_item();
	}
	// deprecated, use is_in_cart
	function item_in_cart()
	{
		return $this->is_in_cart();
	}
	// deprecated, use view_formatted_number
	function number_format($number = FALSE)
	{
		return $this->view_formatted_number($number);
	}
	// Deprecated, use submitted_order_info()
	function order_detail()
	{
		return $this->submitted_order_info();
	}

	// deprecated, use submitted_order_info
	function order_info()
	{
		return $this->submitted_order_info();
	}
	// deprecated, use get_cartthrob_logo
	function powered_by()
	{
		return $this->get_cartthrob_logo(); 
	}
	// deprecated, use get_items_in_range; 
	function products_in_price_range()
	{
		return	$this->get_items_in_range();
	}
	// Deprecated, use save_shipping_option()
	function save_shipping_options()
	{
		return $this->save_shipping_option();
	}
	// @deprecated, use is_saved
	function saved_customer_info()
	{
		return $this->is_saved(); 
	}
	// deprecated, see selected_shipping_option
	function shipping_option()
	{
		return $this->selected_shipping_option();
	}

	// deprecated, use get_shipping_options(); 
	function shipping_options()
	{
		return $this->get_shipping_options(); 
	}
	// deprecated, use use_coupon
	function validate_coupon_code()
	{
		return $this->use_coupon(); 
	}
	// deprecated, use view_summed_field
	function total()
	{
		return $this->view_summed_field(); 
	}
	// deprecated, use cart_items_info
	function view_cart()
	{
		return $this->cart_items_info(); 
	}
	//deprecated, user _get_cart_items
	function _get_items()
	{
		return $this->_get_cart_items();
	}
	 // Deprecated, use _get_item_quantity()
	function _get_quantity($entry_id)
	{
		return $this->_get_item_quantity($entry_id);
	}
	//deprecated, use _bool_param()
	function _true_false($str, $default=FALSE)
	{
		return $this->_bool_param($str, $default);
	}
	
}
// END CLASS

/* End of file mod.cartthrob.php */
/* Location: ./system/modules/cartthrob/mod.cartthrob.php */