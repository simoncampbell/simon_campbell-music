<?php

$gateway_info = array(
	'title' => 'Beanstream Direct',
	'classname' => 'Cartthrob_beanstream_direct',
	'settings' => array(
		array(
			'name' => 'Merchant ID', 
			'short_name' => 'merchant_id', 
			'type' => 'text',  
		),
	),
	'required_fields' => array(
		'first_name',
		'last_name',
		'expiration_month',
		'expiration_year',
		'email_address',
		'address',
		'city',
		'state',
		'zip',
		'country_code'
		
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
			<label for="state">State/Province</label>
			<select id="state" name="state">
				<option value="">--Canada--</option>
				<option value="AB">Alberta</option>
				<option value="BC">British Columbia</option>
				<option value="MB">Manitoba</option>
				<option value="NB">New Brunswick</option>
				<option value="NL">Newfoundland/Labrador</option>
				<option value="NT">Northwest Territories</option>
				<option value="NS">Nova Scotia</option>
				<option value="NU">Nunavut</option>
				<option value="ON">Ontario</option>
				<option value="PE">Prince Edward Island</option>
				<option value="QC">Quebec</option>
				<option value="SK">Saskatchewan</option>
				<option value="YT">Yukon</option>
				<option value="">--United States--</option>
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
			<label for="zip" class="required" >Zip/Postal Code</label>
			<input type="text" id="zip" name="zip" value="" />
		</p>
		<p>
			<label for="country_code" class="required" >Country</label>
			<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 -->
			<select name="country_code" id="country_code">
				<option value="CA">Canada</option>
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
			<label for="shipping_state">State/Province</label>
			<select id="state" name="state">
				<option value="">--Canada--</option>
				<option value="AB">Alberta</option>
				<option value="BC">British Columbia</option>
				<option value="MB">Manitoba</option>
				<option value="NB">New Brunswick</option>
				<option value="NL">Newfoundland/Labrador</option>
				<option value="NT">Northwest Territories</option>
				<option value="NS">Nova Scotia</option>
				<option value="NU">Nunavut</option>
				<option value="ON">Ontario</option>
				<option value="PE">Prince Edward Island</option>
				<option value="QC">Quebec</option>
				<option value="SK">Saskatchewan</option>
				<option value="YT">Yukon</option>
				<option value="">--United States--</option>
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
			<label for="shipping_zip"  >Zip/Postal Code</label>
			<input  id="shipping_zip" type="text" name="shipping_zip" value="" />
		</p>
	</fieldset>

	<fieldset class="information" id="additional_info">
		<legend>Additional Information</legend>
		<p>
			<label for="company">Company</label>
			<input id="company"  type="text" name="company" value="" />
		</p>
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
				
				<option value="Diners">Diners</option>
				<option value="JCB">JCB</option>
				<option value="Sears">Sears</option>
			</select>
		</p>
		<p>
			<label for="credit_card_number" class="required">Credit Card Number</label>
			<input type="text" name="credit_card_number" value="" id="credit_card_number" />
		</p>
		<p>
			<label for="CVV2" class="required">CVV2 Number</label>
			<input type="text" size="4" name="CVV2" id="CVV2" value="" />
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
	</fieldset>
	',
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_beanstream_direct extends Cartthrob_payment_gateway
	{
		function Cartthrob_beanstream_direct()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
		}
		/**
		 * _process_payment function
		 *
		 * @param string $total the total amount of the purchase
		 * @param string $credit_card_number purchaser's credit cart number
		 * @param array $customer_info array containing $_POST fields captured by the checkout form
		 * @access private
		 * @return array $resp an array containing the following keys: authorized, declined, failed, error_message, and transaction_id 
		 * the returned fields can be displayed in the templates using template tags. 
		 **/
		function _process_payment($total, $credit_card_number, $customer_info, $order_id='')
		{
			$auth['authorized'] 	= 	FALSE; 
			$auth['declined']		=	FALSE; 
			$auth['failed']			=	FALSE; 
			$auth['error_message']	= 	NULL; 
			$auth['transaction_id']	=	NULL;
			
			$post_array = array(
				'requestType'			=> 'BACKEND', 
				'merchant_id'			=> $this->plugin_settings['merchant_id'],
				'trnOrderNumber'		=> $order_id,
				'trnAmount'				=> $total,
				'trnCardOwner'			=> $customer_info['first_name']. " " . $customer_info['last_name'],
				'trnCardNumber'			=> $credit_card_number,
				'trnExpMonth'			=> $customer_info['expiration_month'],
				'trnExpYear'			=> $customer_info['expiration_year'],
				'trnCardCvd'			=> $customer_info['CVV2'],
				'ordName'				=> $customer_info['first_name']. " " . $customer_info['last_name'],
				'ordEmailAddress'		=> $customer_info['email_address'],
				'ordPhoneNumber'		=> $customer_info['phone'],
				'ordAddress1'			=> $customer_info['address'],
				'ordAddress2'			=> $customer_info['address2'],
				'ordCity'				=> $customer_info['city'],
				'ordProvince'			=> $customer_info['state'],
				'ordPostalCode'			=> $customer_info['zip'],
				//'termURL'				=> "",
				'ordCountry'			=> $this->_get_alpha2_country_code($customer_info['country_code']),
				);
							
			$data = $this->data_array_to_string($post_array);
			$connect = $this->curl_transaction('https://www.beanstream.com/scripts/process_transaction.asp', $data);
			
			if (!$connect)
			{
				$auth['failed'] 		= TRUE;
				$auth['error_message']	= "A connection with Beanstream could not be established";	
				return $auth; 
			}
			
			$response = $this->split_url_string($connect);
			
			$error_text = str_replace(array("&lt;LI&gt;","&lt;br&gt;"), " ", $response['messageText']);
				
			switch ($response['messageId'])
			{
				case "16": 
					// duplicate transaction
					$auth['authorized'] 	= 	FALSE; 
					$auth['declined']		=	FALSE; 
					$auth['failed']			=	TRUE; 
					$auth['error_message']	= 	$error_text; 
					$auth['transaction_id']	=	NULL;
					return $auth;
					break;
				case "1": 
					$auth['authorized'] 	= 	TRUE; 
					$auth['declined']		=	FALSE; 
					$auth['failed']			=	FALSE; 
					$auth['error_message']	= 	""; 
					$auth['transaction_id']	=	$response['trnId'];
					return $auth;
					break;
					
			}

			switch($response['errorType']){
				case "U": 
					// validation errors
					$auth['authorized'] 	= 	FALSE; 
					$auth['declined']		=	FALSE; 
					$auth['failed']			=	TRUE; 
					$auth['error_message']	= 	$error_text;
					$auth['transaction_id']	=	NULL;
					return $auth; 
					break;
				case "S":
					// system errors (missing merchant id, etc)
					$auth['authorized'] 	= 	FALSE; 
					$auth['declined']		=	FALSE; 
					$auth['failed']			=	TRUE; 
					$auth['error_message']	= 	$error_text;
					$auth['transaction_id']	=	NULL;
					return $auth; 
					break;
				
				default: 
					$auth['authorized'] 	= 	FALSE; 
					$auth['declined']		=	FALSE; 
					$auth['failed']			=	TRUE; 
					$auth['error_message']	= 	NULL; 
					$auth['transaction_id']	=	NULL;
					return $auth; 
			}
			return $auth;
			
		} // END 
	}// END CLASS
}

/* End of file cartthrob.beanstream_direct.php */
/* Location: ./system/modules/payment_gateways/cartthrob.beanstream_direct.php */