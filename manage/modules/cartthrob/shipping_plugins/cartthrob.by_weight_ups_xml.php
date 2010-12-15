<?php
global $PREFS, $LANG; 

$plugin_info = array(
	'title' => 'ESTIMATED By UPS',
	'classname' => 'Cartthrob_by_weight_ups_xml',
	'overview'	=> '
	<h3 style="display:block">The UPS Icon</h3>
	<p>UPS requires that you conspicuously display the following graphic (also included in the sample HTML below) on any page that is used to request a shipping estimate from UPS. </p>
	<p><img src="'. $PREFS->ini('theme_folder_url') .'cp_themes/'.$PREFS->ini('cp_theme').'/cartthrob/images/ups_logo.gif"  alt="" /></p>
	
	<h3 style="display:block">Use of This Plugin</h3>
	
	<p>Unlike other shipping methods, UPS shipping costs are not updated automatically when the cart contents are modified. The UPS shipping plugin requires that you manually request a shipping quote at some point during your checkout process. If you do not use the <a href="http://cartthrob.com/docs/tags_detail/request_shipping_quote_form">{exp:cartthrob:request_shipping_quote_form}</a> tag, your shipping costs will not be set for checkout.</p> 
	
	<h3 style="display:block">Estimate Accuracy Warning</h3>
	<p>If your actual packing and shipping methods differ from the information you use to request the cost estimate from UPS, your shipping costs may vary from the estimated value</p>
	
	<h3 style="display:block">Dimensional Weight Warning</h3><p>Length + Width + Height values are <strong>required</strong> for shipping quotes from UPS any time that the Packaging Type is not <strong><em>Letter, Express Tube, or Express Box</em></strong>. Also, <strong><em>Next-day, 2nd Day and 3 Day shipping methods</em></strong> <strong><em>only</em></strong> calculate costs by box dimensions as all costs for these items are based on dimensional weight, rather than standard weight. </p>', 
	'html' => '
<!-- minimum features -->
	<fieldset class="shipping_location" id="shipping_location">
		<legend>UPS Shipping Estimate Request</legend>
		<!-- UPS logo is REQUIRED by UPS --> 
		<img src="'. $PREFS->ini('theme_folder_url') .'cp_themes/'.$PREFS->ini('cp_theme').'/cartthrob/images/ups_logo.gif"  alt="Estimates by UPS" />
		<p>
			<label for="delivery_zip" class="required" >Delivery Zip Code</label>
			<input type="text" name="zip" id="delivery_zip" value="" />
		</p>
		<p>
			<label for="ups_product" >UPS Product</label>
			{exp:cartthrob:get_shipping_options}
			
		</p>
	</fieldset>

	<!-- full features 
		<fieldset class="shipping_location" id="shipping_location">
		<legend>UPS Shipping Estimate Request</legend>
		<img src="'. $PREFS->ini('theme_folder_url') .'cp_themes/'.$PREFS->ini('cp_theme').'/cartthrob/images/ups_logo.gif"  alt="Estimates by UPS" />
			<input type="hidden" value="10001" name="shipping[origination_zip]" />
			<input type="hidden" value="US" name="shipping[origination_country]" /> 
		<input type="hidden" value="shop" name="shipping[mode]" /> 
		
		<p>
			<label for="delivery_country_code" class="required" >Delivery Country</label>
			<select name="country_code" id="delivery_country_code">
				<option value="CA">Canada</option>
				<option value="GB">United Kingdom</option>
				<option value="US" selected>United States</option>
			</select>
		</p>
		<p>
			<label for="delivery_zip" class="required" >Delivery Zip Code</label>
			<input type="text" name="zip" id="delivery_zip" value="" />
		</p>
		
	</fieldset>

	<fieldset class="shipping_options" id="shipping_options">
		<legend>Shipping Options</legend>
		<p>
			<label for="ups_product" >UPS Product</label>
			<select name="shipping[product]" id="ups_product">
				<option value="14" >Next Day Air Early AM</option>
				<option value="01" >Next Day Air</option>
				<option value="13" >Next Day Air Saver</option>
				<option value="59" >2nd Day Air AM</option>
				<option value="02" >2nd Day Air</option>
				<option value="12" >3 Day Select</option>
				<option value="03" selected >Ground</option>
				<option value="11" >Internatonal Standard</option>
				<option value="07" >Worldwide Express</option>
				<option value="54" >Worldwide Express Plus</option>
				<option value="08" >Worldwide Expidited</option>
				<option value="65" >International Saver</option>
			</select>
		</p>
		<p>
			<label for="ups_rate" >UPS Rate</label>
			<select name="shipping[rate]" id="ups_rate">
				<option value="03" selected>Customer Counter</option>
				<option value="19">Letter Center</option>
				<option value="06">One Time Pickup </option>
				<option value="07">On Call Air </option>
				<option value="01">Regular Daily Pickup</option>
				<option value="11">Suggested Retail Rates</option>
				<option value="20">Air Service Center</option>
			</select>
		</p>
		<p>
			<label for="ups_container" >UPS Container</label>
			<select name="shipping[container]" id="ups_container">
				<option value="00">Unknown</option>
				<option value="01">UPS Letter</option>
				<option value="02" selected>Package</option>
				<option value="03">UPS Tube</option>
				<option value="04">UPS Pak </option>
				<option value="21">Express Box</option>
				<option value="24">25KG Box</option>
				<option value="25">10KG Box</option>
				<option value="30">Pallet</option>
				<option value="2a">Small Express Box</option>
				<option value="2b">Medium Express Box</option>
				<option value="2c">Large Express Box</option>
			</select>
		</p>
		<p>
			<label for="ups_delivery" >UPS Delivery</label>
			<select name="shipping[delivery_type]" id="ups_delivery">
				<option value="1" >Residential</option>
				<option value="2" >Commercial</option>
			</select>
		</p>
	</fieldset>
	-->
	',
	
	'settings' => array(
		array(
			'name' => 'API Access Key',
			'short_name' => 'access_key',
			'type' => 'text',
			'default'	=> ''
		),
		array(
			'name' => 'Username',
			'short_name' => 'username',
			'type' => 'text',
			'default'	=> ''
		),
		array(
			'name' => 'Password',
			'short_name' => 'password',
			'type' => 'text',
			'default'	=> ''
		),
		array(
			'name' => 'Account/Shipper Number (needed for negotiated rates)',
			'short_name' => 'shipper_number',
			'type' => 'text',
			'default'	=> ''
		),
		array(
			'name' => 'Use Negotiated Rates?',
			'short_name' => 'use_negotiated_rates',
			'type' => 'radio',
			'default' => '0',
			'options'	=> array(
					'1'	=> "Yes",
					'0' => "No"
				),
		),
		array(
			'name' => 'Test Mode?',
			'short_name' => 'test_mode',
			'default'	=> '1',
			'type' => 'radio',
			'options'	=> array(
					'1'	=> "Yes",
					'0' => "No"
			),
		),
		array(
			'name' => 'Unit of Length Measurement',
			'short_name' => 'length_code',
			'type' => 'radio',
			'default' => 'IN',
			'options'	=> array(
					'IN' => "Inches",
					'CM' => "Centimeters"
			),
		),
		array(
			'name' => 'Unit of Weight Measurement',
			'short_name' => 'weight_code',
			'type' => 'radio',
			'default' => 'LBS',
			'options'	=> array(
					'LBS' => "Pounds",
					'KGS' => "Kilograms"
			),
		),
		/// DEFAULTS FOR SHIPPING OPTIONS
		array(
			'name' => 'Service Default',
			'short_name' => 'product_id',
			'type' => 'select',
			'default' => '03', 
			'options' => array(
				''		=> '--- Valid Domestic Values ---', 
				'14'	=> 'Next Day Air Early AM',
				'01'	=> 'Next Day Air',
				'13'	=> 'Next Day Air Saver',
				'59'	=> '2nd Day Air AM',
				'02'	=> '2nd Day Air',
				'12'	=> '3 Day Select',
				'03'	=> 'Ground',
				''		=> '--- Valid International Values ---', 
				'11'	=> 'International Standard',
				'07'	=> 'Worldwide Express',
				'54'	=> 'Worldwide Express Plus',
				'08'	=> 'Worldwide Expidited',
				'65'	=> 'International Saver',

			),
		),
		array(
			'name' => 'Pickup Type Default',
			'short_name' => 'rate_chart',
			'type' => 'select',
			'default' => '03', 
			'options' => array(
				'03' 	=> $LANG->line('ups_customer_counter'),
				'19'	=> $LANG->line('ups_letter_center'),
				'06' 	=> $LANG->line('ups_one_time_pickup'),
				'07' 	=> $LANG->line('ups_on_call_air'),
				'01' 	=> $LANG->line('ups_regular_daily_pickup'),
				'11'	=> 'ups_suggested_retail_rates',
				'20'	=> 'ups_air_service_center',
			),
		),
		array(
			'name' => 'Packaging Type Default',
			'short_name' => 'container',
			'type' => 'select',
			'default' => '02',
			'options' => array(
				'00' => 'Unknown',
				'01' => 'UPS Letter',
				'02' => 'Package',
				'03' => 'UPS Tube',
				'04' => 'UPS Pak', 
				'21' => 'Express Box',
				'24' => '25KG Box',
				'25' => '10KG Box',
				'30' => 'Pallet',
				'2a' => 'Small Express Box',
				'2b' => 'Medium Express Box',
				'2c' => 'Large Express Box',
 			),
		),
		// BUSINESS RATES ARE CHEAPER
		array(
			'name' =>  "Origination Type Default", 
			'short_name' => 'origination_res_com',
			'type' => 'radio',
			'default' => '1',
			'options' => array(
				'1' => $LANG->line('ups_res'),
				'2' => $LANG->line('ups_comm'),
			),
		),
		array(
			'name' => "Delivery Type Default" ,
			'short_name' => 'delivery_res_com',
			'type' => 'radio',
			'default' => '1',
			'options' => array(
				'1' => $LANG->line('ups_res'),
				'2' => $LANG->line('ups_comm'),
			),
		),
		array(
			'name' =>  'Default Package Length',
			'short_name' => 'def_length',
			'type' => 'text',
			'default' => '15'
		),
		array(
			'name' =>  'Default Package Width',
			'short_name' => 'def_width',
			'type' => 'text',
			'default' => '15'
		),
		array(
			'name' =>  'Default Package Height',
			'short_name' => 'def_height',
			'type' => 'text',
			'default' => '15'
		),
		// CUSTOMER CHOICES
		array(
			'name' => 'Customer Selectable Rate Options',
			'short_name' => 'selectable_rates',
			'type' => 'header',
		),
		array(
			'name' => 'Next Day Air Early AM',
			'short_name' => 'c_14',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Next Day Air',
			'short_name' => 'c_01',
			'type' => 'radio',
			'default' => 'y',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Next Day Air Saver',
			'short_name' => 'c_13',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => '2nd Day Air AM',
			'short_name' => 'c_59',
			'type' => 'radio',
			'default' => 'y',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => '2nd Day Air',
			'short_name' => 'c_02',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => '3 Day Select',
			'short_name' => 'c_12',
			'type' => 'checkbox',
			'type' => 'radio',
			'default' => 'y',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Ground',
			'short_name' => 'c_03',
			'type' => 'checkbox',
			'type' => 'radio',
			'default' => 'y',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'International Standard',
			'short_name' => 'c_11',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Worldwide Express',
			'short_name' => 'c_07',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Worldwide Express Plus',
			'short_name' => 'c_54',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Worldwide Expidited',
			'short_name' => 'c_08',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
		array(
			'name' => 'Worldwide Saver',
			'short_name' => 'c_65',
			'type' => 'radio',
			'default' => 'n',
			'options' => array(
				'n' => 'No',
				'y' => 'Yes',
				)
		),
	)
);
if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_by_weight_ups_xml extends Cartthrob_shipping_plugin
	{

		function Cartthrob_by_weight_ups_xml()
		{
			$this->Cartthrob();

			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
		
			if ($this->plugin_settings['test_mode'] == "1")
			{
				$this->_host = "https://wwwcie.ups.com/ups.app/xml/Rate";
			
			}
			else
			{
				$this->_host = "https://www.ups.com/ups.app/xml/Rate";
			
			}
			$this->_host = "https://www.ups.com/ups.app/xml/Rate";
		
		
		}
		/**
		 * set_shipping
		 *
		 * this allows the estimator to set the shipping cost on demand, rather than every time costs are requested
		 * the initial shipping costs have to be activated by the manual function "update_shipping"; 
		 * 
		 * @param string $cost 
		 * @return void | string
		 * @author Chris Newton
		 */
		function set_shipping($cost = NULL) 
		{
			$this->_session_start(); 
		
			if ($cost != NULL)
			{
				$_SESSION['cartthrob']['shipping']['quoted_shipping_cost'] = $cost; 
				return $cost; 
			
			}
			elseif (isset($_SESSION['cartthrob']['shipping']['quoted_shipping_cost'] ))
			{
				return $_SESSION['cartthrob']['shipping']['quoted_shipping_cost'];
			}
			else
			{
				return "0";
			}
		}
		function get_shipping()
		{
			return $this->set_shipping(); 
		
		}
		function get_shipping_quote($rate_type = NULL)
		{
			return $this->get_ups_shipping($rate_type); 
		}
		function get_ups_shipping($rate_type=NULL)
		{
		
			/*
				shipping_product
				shipping_rate
				container
				delivery_type

				origination_zip
				origination_country
				shipping_cost
			
				length
				width
				height
				mode
				*/
			$this->_session_start();
			$shipping_info = array(
					'price'				=> NULL, 
					'error_message' 	=> NULL,
					'shipping_methods'	=> array(
							'option_values'	=> array(),
							'option_prices'	=> array(),
							'option_titles'	=> array(),
						),
				);
				
	
			// THIS PULLS THE CUSTOMER INFO FROM THE SESSION
			$customer_info = $this->_get_customer_info(NULL, $return_shipping = FALSE); 

			/* ************************************* DEFAULT VALUES ****************************************/
		
			// ORIGINATION COUNTRY
			// the mess below takes a look at the data from the template. If there's nothing there, it pulls
			// data from the settings. If nothing's there, US is used by default
			$setting_country_code = $this->view_setting("country_code");
			$orig_country_code 	= !empty($_SESSION['cartthrob']['shipping']['origination_country']) ? 	
				$_SESSION['cartthrob']['shipping']['origination_country'] 	: 
				!empty($setting_country_code) ? 
					$setting_country_code : 
					"US";
			$orig_country_code = $this->_get_alpha2_country_code($orig_country_code); 
		
			// ORIGINATION ZIP
			// the other mess below also takes a look at the data from the template. If there's nothing there, it pulls
			// data from the settings. If nothing's there, 10001 is used by default
			$setting_zip_code = $this->view_setting("zip"); 
			$orig_zip 		= !empty($_SESSION['cartthrob']['shipping']['origination_zip']) ? 
				$_SESSION['cartthrob']['shipping']['origination_zip'] : 
				!empty($setting_zip_code) ? 
					$setting_zip_code : 
					"10001"; 
			
			// ORIGINATION STATE
			// the final mess below also takes a look at the data from the template. If there's nothing there, it pulls
			// data from the settings. If nothing's there, MA is used by default
			$setting_state_code = $this->view_setting("state"); 
			$orig_state 	= !empty($_SESSION['cartthrob']['shipping']['origination_state']) ? 
				$_SESSION['cartthrob']['shipping']['origination_state'] : 
				!empty($setting_state_code) ? 
					$setting_state_code : 
					"MA";
			
			// DESTINATION COUNTRY CODE
			// shipping or billing or settings or US
			if (!empty($customer_info['shipping_country_code']))
			{
				$dest_country_code = $customer_info['shipping_country_code']; 
			}
			elseif (!empty($customer_info['country_code']))
			{
				$dest_country_code = $customer_info['country_code']; 
			}
			elseif (!empty($orig_country_code))
			{
				$dest_country_code = $orig_country_code; 
			}
			else
			{
				$dest_country_code = "US";
			}
			$dest_country_code = $this->_get_alpha2_country_code($dest_country_code); 
		
			// DESTINATION ZIP
			// shipping or billing or settings or 10001
			if (!empty($customer_info['shipping_zip']))
			{
				$dest_zip = $customer_info['shipping_zip']; 
			}
			elseif (!empty($customer_info['zip']))
			{
				$dest_zip = $customer_info['zip']; 
			}
			elseif (!empty($orig_zip))
			{
				$dest_zip = $orig_zip; 
			}
			else
			{
				$dest_zip = "10001";
			}
		
			$product_id = !empty($_SESSION['cartthrob']['shipping']['product']) 			? $_SESSION['cartthrob']['shipping']['product'] 	: $this->plugin_settings['product_id'];
			$rate_chart = !empty($_SESSION['cartthrob']['shipping']['rate']) 				? $_SESSION['cartthrob']['shipping']['rate'] 		: $this->plugin_settings['rate_chart'];
			$container  = !empty($_SESSION['cartthrob']['shipping']['container']) 			? $_SESSION['cartthrob']['shipping']['container'] 	: $this->plugin_settings['container'];
			$delivery_res_com 	= !empty($_SESSION['cartthrob']['shipping']['delivery_type']) 		? $_SESSION['cartthrob']['shipping']['delivery_type'] 	: $this->plugin_settings['delivery_res_com'];
			$origination_res_com 	= !empty($_SESSION['cartthrob']['shipping']['origination_type']) 		? $_SESSION['cartthrob']['shipping']['origination_type'] 	: $this->plugin_settings['origination_res_com'];
			
			$dim_length = !empty($_SESSION['cartthrob']['shipping']['length']) 				? $_SESSION['cartthrob']['shipping']['length'] 	: $this->plugin_settings['def_length'];
			$dim_width 	= !empty($_SESSION['cartthrob']['shipping']['width']) 				? $_SESSION['cartthrob']['shipping']['width'] 	: $this->plugin_settings['def_width'];
			$dim_height = !empty($_SESSION['cartthrob']['shipping']['height']) 				? $_SESSION['cartthrob']['shipping']['height'] 	: $this->plugin_settings['def_height'];
			if ( $rate_type == NULL)
			{
				$rate_shop 	= !empty($_SESSION['cartthrob']['shipping']['mode']) 				? $_SESSION['cartthrob']['shipping']['mode'] 	: "Rate";
			}
			elseif ($rate_type == "shop")
			{
				$rate_shop = "Shop";
			}
			else
			{
				$rate_shop = "Rate";
			}

				
			$shipping_address 	= !empty($customer_info['shipping_address']) 				? $customer_info['shipping_address']: @$customer_info['address']; 
			$shipping_address2 	= !empty($customer_info['shipping_address2']) 				? $customer_info['shipping_address2']: @$customer_info['address2']; 
			$shipping_city		= !empty($customer_info['shipping_city']) 					? $customer_info['shipping_city']: @$customer_info['city']; 
			$shipping_state 	= !empty($customer_info['shipping_state']) 					? $customer_info['shipping_state']: ""; //@$customer_info['state']; 

			/* ************************************* END DEFAULT VALUES ****************************************/

			/* ************************************* XML REQUEST  ****************************************/

			$data ="<?xml version=\"1.0\"?>  
<AccessRequest xml:lang=\"en-US\">  
    <AccessLicenseNumber>".$this->plugin_settings['access_key']."</AccessLicenseNumber>  
    <UserId>".$this->plugin_settings['username']."</UserId>  
    <Password>".$this->plugin_settings['password']."</Password>  
</AccessRequest>  
<?xml version=\"1.0\"?>  
<RatingServiceSelectionRequest xml:lang=\"en-US\">  
    <Request>  
		<RequestAction>Rate</RequestAction>  
		<RequestOption>".$rate_shop."</RequestOption>  
		<TransactionReference>  
	    	<CustomerContext>Rating and Service</CustomerContext>  
	    	<XpciVersion>1.0</XpciVersion>  
		</TransactionReference>  
    </Request>  
	<PickupType>  
    	<Code>$rate_chart</Code>  
	</PickupType>  
	<Shipment>  
	    <Shipper>  
	    	<ShipperNumber>".$this->plugin_settings['shipper_number']."</ShipperNumber>  
			<Address> 
				<PostalCode>$orig_zip</PostalCode>  
				<CountryCode>$orig_country_code</CountryCode>".(($this->plugin_settings['use_negotiated_rates']=="1") ? " 
				<StateProvinceCode>$orig_state</StateProvinceCode>" : "")."
				".(($origination_res_com=="1") ? "<ResidentialAddressIndicator/>" : "") ."  
			</Address>  
	    </Shipper>  
	    <ShipTo>  
			<Address>  
				<AddressLine1>$shipping_address</AddressLine1>
				<AddressLine2>$shipping_address2</AddressLine2>
				<City>$shipping_city</City>
				<StateProvinceCode>$shipping_state</StateProvinceCode>
			    <PostalCode>$dest_zip</PostalCode>  
			    <CountryCode>$dest_country_code</CountryCode>
				".(($delivery_res_com=="1") ? "<ResidentialAddressIndicator/>" : "") ."  
			</Address>
	    </ShipTo>  
	    <ShipFrom>  
			<Address>  
			    <PostalCode>$orig_zip</PostalCode>".(($this->plugin_settings['use_negotiated_rates']=="1") ? " 
				<StateProvinceCode>$orig_state</StateProvinceCode>" : "")."  
			    <CountryCode>$orig_country_code</CountryCode>
				".(($origination_res_com=="1") ? "<ResidentialAddressIndicator/>" : "") ."  
			</Address>  
	    </ShipFrom>  
	    <Service>  
			<Code>".$product_id."</Code>  
	    </Service>  
	    <Package>  
			<PackagingType>  
		    	<Code>".$container."</Code>  
			</PackagingType>  
			<Dimensions>  
			    <UnitOfMeasurement>  
					<Code>".$this->plugin_settings['length_code']."</Code>  
			    </UnitOfMeasurement>  
			    <Length>$dim_length</Length>  
			    <Width>$dim_width</Width>  
			    <Height>$dim_height</Height>  
			</Dimensions>  
			<PackageWeight>  
			    <UnitOfMeasurement>  
					<Code>".$this->plugin_settings['weight_code']."</Code>  
			    </UnitOfMeasurement>  
			    <Weight>".$this->shipping_weight_total()."</Weight>  
			</PackageWeight>  
	    </Package>".(($this->plugin_settings['use_negotiated_rates']=="1") ? " 
	 	<RateInformation>
			<NegotiatedRatesIndicator/>
		</RateInformation>" : "" ) ."  
	</Shipment>  
</RatingServiceSelectionRequest>";
				
			$result = $this->curl_transaction($this->_host,$data);
			
			/* DEBUG */ 
			//echo '<!-- '. $result. ' -->';  
			$data = strstr($result, '<?');  
		
			$params = $this->xml_to_array($data,'complete'); 
				
			$shipping_info['error_message']	= NULL;  
			$shipping_info['price'] 		= 0; 
			
			$shipping_info['shipping_option'] = $this->ups_shipping_methods($product_id); 
			$options 	   = array(); 
			$option_prices = array(); 
			$option_values = array(); 
			$option_titles = array();
			
			
			
			if ("rate" == strtolower($rate_shop))
			{
				
				if ($this->plugin_settings['use_negotiated_rates']=="1") 
				{
					if (!empty( $params['RatingServiceSelectionResponse']['RatedShipment'][0]['NegotiatedRates'][0]['NetSummaryCharges'][0]['GrandTotal'][0]['MonetaryValue']['data'] ))
					{
						$shipping_info['price'] =   $params['RatingServiceSelectionResponse']['RatedShipment'][0]['NegotiatedRates'][0]['NetSummaryCharges'][0]['GrandTotal'][0]['MonetaryValue']['data'];  
						$shipping_info['error_message'] = NULL; 
						$_SESSION['cartthrob']['shipping']['shipping_option'] = $this->ups_shipping_methods($product_id);
						
					}
					else
					{
						$shipping_info['price'] = 0; 
						if (!empty($params['RatingServiceSelectionResponse'][0]['Response'][0]['Error'][0]['ErrorDescription']['data']))
						{
							$shipping_info['error_message'] = $params['RatingServiceSelectionResponse'][0]['Response'][0]['Error'][0]['ErrorDescription']['data'];
							
						}
						else
						{
							$shipping_info['error_message'] = "UPS is not configured to provide negotiated rates for this business."; 
							
						}
					}
					
				}
				elseif (!empty( $params['RatingServiceSelectionResponse']['RatedShipment'][0]['TotalCharges'][0]['MonetaryValue']['data'] ))
				{
					$shipping_info['price'] =  $params['RatingServiceSelectionResponse']['RatedShipment'][0]['TotalCharges'][0]['MonetaryValue']['data']; 
					$shipping_info['error_message'] = NULL;  
					$_SESSION['cartthrob']['shipping']['shipping_option'] = $this->ups_shipping_methods($product_id);
					
				}
				elseif (!empty( $params['RatingServiceSelectionResponse']['Response'][0]['Error'][0]['ErrorDescription']['data'] ))
				{
					$shipping_info['price'] = 0; 
					$shipping_info['error_message'] = $params['RatingServiceSelectionResponse']['Response'][0]['Error'][0]['ErrorDescription']['data'];
					unset($_SESSION['cartthrob']['shipping']['shipping_option'] );
					
				}
				else
				{
					$shipping_info['price'] = 0; 
					$shipping_info['error_message'] = "No data was returned by UPS"; 
					unset($_SESSION['cartthrob']['shipping']['shipping_option'] );
					
				}
				$shipping_options = $this->ups_shipping_methods_array(); 
				
				foreach ($shipping_options as $key => $value)
				{
					$option_values[] = $key;
					$option_titles[] = $value; 
					$options["opt_".$key]= $this->ups_shipping_methods($key);
					if ($key !=$product_id)
					{
						$option_prices[] = 0;
					}
					else
					{
						$option_prices[] = $shipping_info['price'];
					}
				}
			}
			elseif ("shop" == strtolower($rate_shop))
			{

				if (empty($params['RatingServiceSelectionResponse']['RatedShipment']))
				{
					$shipping_info['error_message']  = "Shipping quotes were not returned by UPS. ";
				}
				else
				{
					foreach ($params['RatingServiceSelectionResponse']['RatedShipment'] as $item )
					{
						if (!empty($item['Service'][0]['Code']['data']))
						{
							
							$option_name = $this->ups_shipping_methods($item['Service'][0]['Code']['data']); 
							
							if (!empty(	$this->plugin_settings['c_'.$item['Service'][0]['Code']['data']]) &&
							 			$this->plugin_settings['c_'.$item['Service'][0]['Code']['data']] !="n" )
							{
								
								// thanks to Noah for pointing this out. 
								if ($this->plugin_settings['use_negotiated_rates']=="1") 
								{
									if (!empty( $item['NegotiatedRates'][0]['NetSummaryCharges'][0]['GrandTotal'][0]['MonetaryValue']['data']))
									{
										$option_prices[] = $item['NegotiatedRates'][0]['NetSummaryCharges'][0]['GrandTotal'][0]['MonetaryValue']['data'];
									}
									else
									{
										$shipping_info['error_message']  .= "Values for negotiated rates were not returned by UPS. ";
									
									}
								}
								else 
								{
									if (!empty(  $item['TotalCharges'][0]['MonetaryValue']['data'] ))
									{
										$option_prices[] = $item['TotalCharges'][0]['MonetaryValue']['data'];
									}
									else
									{
										$shipping_info['error_message']  .= "Rate values were not returned by UPS. ";
									}
								}
								$option_values[] = $item['Service'][0]['Code']['data'];
								$option_titles[] = $option_name; 
								$options["opt_".$item['Service'][0]['Code']['data']]= $option_name; 
								
								
							}
						}
						else
						{
							$shipping_info['error_message']  .= "Service codes were not returned by UPS. ";
						}
					}
				}
			}
			if (count($options) <= 0)
			{
				if (!empty($_SESSION['cartthrob']['shipping']['shipping_methods']))
				{
					$option_prices = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_prices'];
					$option_values = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']; 
					$option_titles = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_titles'];


					foreach($option_values as $key=>$value)
					{
						$options["opt_".$value] = $option_titles[$key];
					}
				}
				else
				{
					$option_values[]	= "--";
					$option_prices[]	= "0";
					$option_titles[]	= "UPS Shipping is currently unavailable"; 
					$options[]			= "UPS Shipping is currently unavailable";	
				}
			}
			else
			{
				unset($_SESSION['cartthrob']['shipping']['shipping_methods']);
				unset($_SESSION['cartthrob']['shipping']['error_message']);
			}

			$output = "<select>";
			foreach ($options as $key=>$value)
			{
				$output .= "<option value='".$key."'>".$value."</option>";
			}
			$output .= "</select>";

			$shipping_info['shipping_methods']['option_prices'] = $option_prices;
			$shipping_info['shipping_methods']['option_values'] = $option_values; 
			$shipping_info['shipping_methods']['option_titles'] = $option_titles;
			
			return $shipping_info;
		}
		
		function ups_shipping_methods($number)
		{
			switch ($number)
			{
				case '14':	  $option_name = 'Next Day Air Early AM'; 
				break;
				case '01':	  $option_name = 'Next Day Air'; 
				break;
				case '13':	  $option_name = 'Next Day Air Saver'; 
				break;
				case '59':	  $option_name = '2nd Day Air AM'; 
				break;
				case '02':	  $option_name = '2nd Day Air'; 
				break;
				case '12':	  $option_name = '3 Day Select'; 
				break;
				case '03':	  $option_name = 'Ground'; 
				break;
				case '11':	  $option_name = 'International Standard'; 
				break;
				case '07':	  $option_name = 'Worldwide Express'; 
				break;
				case '54':	  $option_name = 'Worldwide Express Plus'; 
				break;
				case '08':	  $option_name = 'Worldwide Expedited'; 
				break;
				case '65':	  $option_name = 'International Saver'; 
				break;
				default:		$option_name = "--";

			}
			return $option_name; 
		}
		function ups_shipping_methods_array()
		{
			$shipping_options = array(); 
			if ($this->plugin_settings['c_14'] !="n")
			{
				$shipping_options['14'] = $this->ups_shipping_methods("14"); 
			}
			if ($this->plugin_settings['c_01'] !="n")
			{
				$shipping_options['01'] = 	$this->ups_shipping_methods("01"); 
			}
			if ($this->plugin_settings['c_13'] !="n")
			{
				$shipping_options['13'] =	$this->ups_shipping_methods("13"); 
			}
			if ($this->plugin_settings['c_59'] !="n")
			{
				$shipping_options['59'] = $this->ups_shipping_methods("59"); 
			}
			if ($this->plugin_settings['c_02'] !="n")
			{
				$shipping_options['02'] = $this->ups_shipping_methods("02"); 
			}
			if ($this->plugin_settings['c_12'] !="n")
			{
				$shipping_options['12'] = $this->ups_shipping_methods("12"); 
			}
			if ($this->plugin_settings['c_03'] !="n")
			{
				$shipping_options['03'] = $this->ups_shipping_methods("03"); ;
			}
			if ($this->plugin_settings['c_11'] !="n")
			{
				$shipping_options['11'] =$this->ups_shipping_methods("11"); ;
			}
			if ($this->plugin_settings['c_07'] !="n")
			{
				$shipping_options['07'] =$this->ups_shipping_methods("07"); ;
			}
			if ($this->plugin_settings['c_54'] !="n")
			{
				$shipping_options['54'] =$this->ups_shipping_methods("54"); ;
			}
			if ($this->plugin_settings['c_08'] !="n")
			{
				$shipping_options['08'] =$this->ups_shipping_methods("08"); ;
			}
			if ($this->plugin_settings['c_65'] !="n")
			{	
				$shipping_options['65'] =$this->ups_shipping_methods("65"); ;
			}
			return $shipping_options; 
		}
		function plugin_shipping_options()
		{
			global $TMPL, $FNS;

			$this->_session_start();

			$output = '';

			$shipping_options = $this->ups_shipping_methods_array(); 

			if (trim($TMPL->tagdata))
			{
				
				foreach ($shipping_options as $key=>$value)
				{
					$rate_title = $value;

					$current_rate = ( ! empty($_SESSION['cartthrob']['shipping']['product'])) ? $_SESSION['cartthrob']['shipping']['product'] : "03";

					$selected = ($key == $current_rate) ? ' selected="selected"' : '';

					$checked = ($key == $current_rate) ? ' checked="checked"' : '';

					$tagdata = $TMPL->tagdata;

					$methodkey =  array_search($key, $_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']);
					
					$tagdata = $TMPL->swap_var_single('rate_short_name', $key, $tagdata);
					$tagdata = $TMPL->swap_var_single('rate_title', $rate_title, $tagdata);
					$tagdata = $TMPL->swap_var_single('selected', $selected, $tagdata);
					$tagdata = $TMPL->swap_var_single('checked', $checked, $tagdata);
					
					if ($methodkey!==FALSE)
					{
						$tagdata = $TMPL->swap_var_single('price',$_SESSION['cartthrob']['shipping']['shipping_methods']['option_prices'][$methodkey] , $tagdata);
						$price = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_prices'][$methodkey]; 
					}
					else
					{
						$tagdata = $TMPL->swap_var_single('price', "0" , $tagdata);
						$price = 0; 
					}
					
					$cond['selected'] = (bool) $selected;
					$cond['checked'] = (bool) $checked;
					$cond['price'] = (bool) $price;
					$cond['rate_title'] = (bool) $rate_title;
					$cond['rate_short_name'] = (bool) $rate_short_name;
					
					$tagdata = $FNS->prep_conditionals($tagdata, $cond);
					
					$output .= $tagdata;
				}
			}
			else
			{
				$id = ($TMPL->fetch_param('id')) ? ' id="'.$TMPL->fetch_param('id').'"' : '';
				$class = ($TMPL->fetch_param('class')) ? ' class="'.$TMPL->fetch_param('class').'"' : '';
				$onchange = ($TMPL->fetch_param('onchange')) ? ' onchange="'.$TMPL->fetch_param('onchange').'"' : '';
				$extra = ($TMPL->fetch_param('extra')) ? ' '.$TMPL->fetch_param('extra') : '';
				$show_all =  ($TMPL->fetch_param('show_all')) ? $TMPL->fetch_param('show_all') : '';
				
				
				$output .= '<select name="shipping[product]"'.$id.$class.$onchange.$extra.">\n";

				foreach ($shipping_options as $key=>$value)
				{
					$rate_title = $value;
					
					if (!empty($_SESSION['cartthrob']['shipping']['product']) && $key == $_SESSION['cartthrob']['shipping']['product'] )
					{
						$selected = ' selected="selected"' ;
						
					}
					else
					{
						$selected= "";
					}
					
					if ($show_all != "yes" && !empty($_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']))
					{
						if (in_array($key,$_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']))
						{
 							$output .= "\t".'<option value="'.$key.'"'.$selected.'>'.$rate_title.'</option>'."\n";
						}
					}
					else
					{
						$output .= "\t".'<option value="'.$key.'"'.$selected.'>'.$rate_title.'</option>'."\n";
						
					}
					
				}

				$output .= "</select>\n";
			}

			return $output;
		}
	}
}
/* End of file cartthrob.by_weight_ups_xml.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.by_weight_ups_xml.php */