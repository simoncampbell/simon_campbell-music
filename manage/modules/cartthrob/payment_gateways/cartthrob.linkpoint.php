<?php
global $LANG; 

$gateway_info = array(
	'title' => 'First Data Global Gateway (LinkPoint)',
	
	'classname' => 'Cartthrob_linkpoint',
	
	'overview' => 'You must have port 1129 available for both sending and receiving data on your server to use First Data Global Gateway. You must also generate a keyfile using the First Data Virtual Terminal system and upload it to the root of your website. Once uploaded, add the name and relative url location of the keyfile to the settings. Any time you update your merchant data with First Data, you will need to upload a new keyfile, and add the name and location here. If your keyfile location is incorrect, you will most likely see the SGS-020006 error from FirstData ',
	
	'settings' => array(
		array(
			'name' => 'Store Number',
			'short_name' => 'store_number',
			'type' => 'text'
		),
		array(
			'name' => 'Name/path to your certificate file. Should be stored at publicly accessible location (like web root).',
			'short_name' => 'keyfile',
			'default'	=> 'yourcert_file_name.pem',
			'type' => 'text'
		),
		array(
			'name' => 'Test Mode?',
			'short_name' => 'test_mode',
			'default'	=> 'test',
			'type' => 'radio',
			'options' => array(
				'live' => "Live",
				'test' => "Test"
				)
		),
	),
	
	'required_fields' => array(
		'credit_card_number',
		'expiration_month',
		'expiration_year',
		'card_type',
		'first_name',
		'last_name',
		'address',
		'city',
		'state',
		'zip',
		'country_code',
		'phone',
		'email_address'

	),
	
	'html' => '
	<fieldset class="billing" id="billing_info">
		<legend>Billing info</legend>
		<p>		
			<label for="first_name" class="required" >First Name</label>
			<input type="text" id="first_name" name="first_name" value="" />
		</p>
		<p>		
			<label for="last_name" class="required" >Last Name</label>
			<input type="text" id="last_name" name="last_name" value="" />
		</p>
		<p>
			<label for="address" class="required" >Street Address</label>
			<input type="text" id="address" name="address" value="" />
		</p>
		<p>
			<label for="address2" >Street Address</label>
			<input type="text" id="address2" name="address2" value="" />
		</p>
		<p>
			<label for="city" class="required" >City</label>
			<input type="text" id="city" name="city" value="" />
		</p>
		<p>
			<label for="state">State (US only) </label>
			<select id="state" name="state">
				<option value="AK">Alaska</option>
				<option value="AL">Alabama</option>
				<option value="AR">Arkansas</option>
				<option value="AZ">Arizona</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DC">District of Columbia</option>
				<option value="DE">Delaware</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="IA">Iowa</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="MA">Massachusetts</option>
				<option value="MD">Maryland</option>
				<option value="ME">Maine</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MO">Missouri</option>
				<option value="MS">Mississippi</option>
				<option value="MT">Montana</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="NE">Nebraska</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NV">Nevada</option>
				<option value="NY">New York</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="PR">Puerto Rico</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VA">Virginia</option>
				<option value="VT">Vermont</option>
				<option value="WA">Washington</option>
				<option value="WI">Wisconsin</option>
				<option value="WV">West Virginia</option>
				<option value="WY">Wyoming</option>
			</select>
		</p>
		<p>
			<label for="zip" class="required" >Zip Code</label>
			<input type="text" id="zip" name="zip" value="" />
		</p>
		<p>
			<label for="country_code" class="required" >Country</label>
			<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 -->
			<select name="country_code" id="country_code">
				<option value="CA">Canada</option>
				<option value="GB">United Kingdom</option>
				<option value="US" selected>United States</option>
			</select>
		</p>
	</fieldset>

	<fieldset class="shipping" id="shipping_info">
		<legend>Shipping Details</legend>
		<p>
			<label for="shipping_first_name"  >First Name</label>
			<input id="shipping_first_name" type="text" name="shipping_first_name" value="" />
		</p>
		<p>
			<label for="shipping_last_name"  >Last Name</label>
			<input id="shipping_last_name" type="text" name="shipping_last_name" value="" />
		</p>
		<p>
			<label for="shipping_address"   >Street Address</label>
			<input id="shipping_address"  type="text" name="shipping_address" value="" />
		</p>
		<p>
			<label for="shipping_address2" >Street Address</label>
			<input id="shipping_address2"  type="text" name="shipping_address2" value="" />
		</p>
		<p>
			<label for="shipping_city"  >City</label>
			<input id="shipping_city"  type="text" name="shipping_city" value="" />
		</p>
		<p>
			<label for="shipping_state">State (US only)</label>
			<select id="shipping_state" name="shipping_state">
				<option value="AK">Alaska</option>
				<option value="AL">Alabama</option>
				<option value="AR">Arkansas</option>
				<option value="AZ">Arizona</option>
				<option value="CA">California</option>
				<option value="CO">Colorado</option>
				<option value="CT">Connecticut</option>
				<option value="DC">District of Columbia</option>
				<option value="DE">Delaware</option>
				<option value="FL">Florida</option>
				<option value="GA">Georgia</option>
				<option value="HI">Hawaii</option>
				<option value="IA">Iowa</option>
				<option value="ID">Idaho</option>
				<option value="IL">Illinois</option>
				<option value="IN">Indiana</option>
				<option value="KS">Kansas</option>
				<option value="KY">Kentucky</option>
				<option value="LA">Louisiana</option>
				<option value="MA">Massachusetts</option>
				<option value="MD">Maryland</option>
				<option value="ME">Maine</option>
				<option value="MI">Michigan</option>
				<option value="MN">Minnesota</option>
				<option value="MO">Missouri</option>
				<option value="MS">Mississippi</option>
				<option value="MT">Montana</option>
				<option value="NC">North Carolina</option>
				<option value="ND">North Dakota</option>
				<option value="NE">Nebraska</option>
				<option value="NH">New Hampshire</option>
				<option value="NJ">New Jersey</option>
				<option value="NM">New Mexico</option>
				<option value="NV">Nevada</option>
				<option value="NY">New York</option>
				<option value="OH">Ohio</option>
				<option value="OK">Oklahoma</option>
				<option value="OR">Oregon</option>
				<option value="PA">Pennsylvania</option>
				<option value="PR">Puerto Rico</option>
				<option value="RI">Rhode Island</option>
				<option value="SC">South Carolina</option>
				<option value="SD">South Dakota</option>
				<option value="TN">Tennessee</option>
				<option value="TX">Texas</option>
				<option value="UT">Utah</option>
				<option value="VA">Virginia</option>
				<option value="VT">Vermont</option>
				<option value="WA">Washington</option>
				<option value="WI">Wisconsin</option>
				<option value="WV">West Virginia</option>
				<option value="WY">Wyoming</option>
			</select>
		</p>
		<p>
			<label for="shipping_zip"  >Zip Code</label>
			<input  id="shipping_zip" type="text" name="shipping_zip" value="" />
		</p>
	</fieldset>


	<fieldset class="information" id="additional_info">
		<legend>Additional Information</legend>
		<p>
			<label for="phone" class="required" >Phone</label>
			<input  id="phone" type="text" name="phone" value="" />
		</p>
		<p>
			<label for="email_address" class="required">Email Address</label>
			<input  id="email_address" type="text" name="email_address" value="" />
		</p>
	</fieldset>

	<fieldset class="payment" id="payment_info">
		<legend>Payment Information</legend>
		<p>
		<label for="card_type">Payment Type</label>
		<select name="card_type" id="payment_type">
			<option selected value="Visa">Visa</option>
			<option value="Mastercard">Mastercard</option>
			<option value="American Express">American Express</option>
			<option value="Discover">Discover</option>
		</select>
		</p>
		<p>
			<label for="credit_card_number" class="required">Credit Card Number</label>
			<input type="text" name="credit_card_number" value="" id="credit_card_number" />
		</p>
		<p>Card Expiration Date
			<label for="expiration_month" class="required">Month</label>
			<select  id="expiration_month"  name="expiration_month">
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select>
			<label for="expiration_year" class="required">Year</label>
			<select id="expiration_year"  name="expiration_year">
				<option value="10">2010</option>
				<option value="11">2011</option>
				<option value="12">2012</option>
				<option value="13">2013</option>
				<option value="14">2014</option>
				<option value="15">2015</option>
				<option value="16">2016</option>
				<option value="17">2017</option>
				<option value="18">2018</option>
				<option value="19">2019</option>
				<option value="20">2020</option>
			</select>
		</p>
	</fieldset>	',
);

if ( ! class_exists($gateway_info['classname']))
{

	class Cartthrob_linkpoint extends Cartthrob_payment_gateway
	{
	
		function Cartthrob_linkpoint()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
			if ($this->plugin_settings['test_mode'] == "live")
			{
				$this->_host = "secure.linkpt.net"; 				
			}
			else
			{
				$this->_host = "staging.linkpt.net"; 
				
			}
			$this->_port = "1129"; 
			$this->_path = "/LSGSXML";
		}
		
		function _process_payment($total, $credit_card_number, $customer_info, $order_id='')
		{
			global $LANG, $PREFS;
			
			if ($this->plugin_settings['test_mode'] == "live") 
			{
				$live="live";
			}
			else
			{
				// other values useful for testing listed below. 
				$live="good";
				//$live="decline";
				//$live="decline";
				//$live="duplicate";

			}
			$xml="<order>"; 
			
			$xml.="<merchantinfo>";
				$xml.="<configfile>".$this->plugin_settings['store_number']."</configfile>";
				$xml.="<keyfile>".$this->plugin_settings['keyfile']."</keyfile>";
				$xml.="<host>".$this->_host."</host><port>".$this->_port."</port>";
			$xml.="</merchantinfo>";
			
			$xml.="<orderoptions>";
				$xml.="<ordertype>Sale</ordertype>";
				$xml.="<result>".$live."</result>";
			$xml.="</orderoptions>";
			
			$xml.="<payment>";
				$xml.="<chargetotal>".$total."</chargetotal>";
			$xml.="</payment>";

			$xml.="<creditcard>";
				$xml.="<cardnumber>".$credit_card_number."</cardnumber>";
				$xml.="<cardexpmonth>".str_pad($customer_info['expiration_month'], 2, '0', STR_PAD_LEFT)."</cardexpmonth>";
				$xml.="<cardexpyear>".str_pad($customer_info['expiration_year'], 2, '0', STR_PAD_LEFT)."</cardexpyear>";
			if (!empty($customer_info['CVV2']))
			{
				$xml.="<cvmvalue>".$customer_info['CVV2']."</cvmvalue>";
				$xml.="<cvmindicator>provided</cvmindicator>";
			}
			else
			{
				$xml.="<cvmindicator>not_provided</cvmindicator>";
			}

			$xml.="</creditcard>";
			
			$xml.="<billing>";
				$xml.="<name>".$customer_info['first_name']." ".$customer_info['last_name']."</name>";
				$xml.="<address1>".$customer_info['address']." ".$customer_info['address2']."</address1>";
				$xml.="<company>".$customer_info['company']."</company>";
				$xml.="<address2>".$customer_info['address2']."</address2>";
				$xml.="<city>".$customer_info['city']."</city>";
				$xml.="<state>".$customer_info['state']."</state>";
				$xml.="<zip>".$customer_info['zip']."</zip>";
				$xml.="<country>".$this->_get_alpha2_country_code($customer_info['country_code'])."</country>";
				$xml.="<phone>".$customer_info['phone']."</phone>";
				$xml.="<email>".$customer_info['email_address']."</email>";
			$xml.="</billing>";
			
			$xml.="<shipping>";
				$xml.="<name>".$customer_info['shipping_first_name']." ".$customer_info['shipping_last_name']."</name>";
				$xml.="<address1>".$customer_info['shipping_address']." ".$customer_info['shipping_address2']."</address1>";
				$xml.="<city>".$customer_info['shipping_city']."</city>";
				$xml.="<state>".$customer_info['shipping_state']."</state>";
				$xml.="<zip>".$customer_info['shipping_zip']."</zip>";
				$xml.="<country>".$this->_get_alpha2_country_code($customer_info['shipping_country_code'])."</country>";
			$xml.="</shipping>";

			$xml.="<transactiondetails>";
				$xml.="<oid>".$order_id."</oid>";
			$xml.="</transactiondetails>";

			$xml .="</order>";
			
			
			$resp=array(
				'error_message'		=> NULL,
				'authorized'		=> FALSE,
				'failed'			=> TRUE,
				'declined'			=> FALSE,
				'transaction_id'	=> NULL
				); 

			// Using a custom cURL script here, because the standard CT one doesn't handle sending SSLCERT info
			$ch = curl_init ();
			curl_setopt ($ch, CURLOPT_URL,"https://". $this->_host.":".$this->_port.$this->_path);
			curl_setopt ($ch, CURLOPT_POST, 1); 
			curl_setopt ($ch, CURLOPT_POSTFIELDS, $xml);  
			curl_setopt ($ch, CURLOPT_SSLCERT, $this->plugin_settings['keyfile']);
			curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
			curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);

			$connect = curl_exec ($ch);
 
			if (!$connect || strlen($connect)<2)
			{
				$resp['error_message'] = $LANG->line('linkpoint_cant_connect'); 
				return $resp; 
			}
			
			// Not using CT's standard xml_to_array because the data that's returned isn't properly formatted XML
			preg_match_all ("/<(.*?)>(.*?)\</", $connect, $outarr, PREG_SET_ORDER);
			$count = 0;
			while (isset($outarr[$count]))
			{
				$transaction[$outarr[$count][1]] = strip_tags($outarr[$count][0]);
				$count++; 
			}
				
			if (!$transaction['r_error'] && $transaction["r_approved"] == "APPROVED") 
			{
				$resp = array(
					'error_message'		=> NULL,
					'authorized'		=> TRUE,
					'failed'			=> FALSE,
					'declined'			=> FALSE,
					'transaction_id'	=> @$transaction["r_ref"]
					);
			}
			else
			{
				$resp = array(
					'error_message'		=> @$transaction["r_error"]  ,
					'authorized'		=> FALSE,
					'failed'			=> FALSE,
					'declined'			=> TRUE,
					'transaction_id'	=> NULL
					);
			}

			return $resp;
		}
	}
}

/* End of file cartthrob.linkpoint.php */
/* Location: ./system/modules/payment_gateways/cartthrob.linkpoint.php */