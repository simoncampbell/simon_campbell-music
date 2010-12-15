<?php
global $LANG, $PREFS;

$gateway_info = array(
	'title' => "Realex Remote",
	
	'classname' => 'Cartthrob_realex_remote',
	
	'language_file' => FALSE,
	
	'overview' => 	"Realex Payments is a leading European payment service provider, with offices in Dublin, London and Paris. 
	Realex provides a broad range of payment services for over 3,000 clients domestically and internationally.",
	
	'affiliate'	=> '<p><A HREF="https://realexpayments.com" target="_blank"><img src="'. $PREFS->ini('theme_folder_url') .'cp_themes/'.$PREFS->ini('cp_theme').'/cartthrob/images/payment_gateways/realex_logo.jpg"  alt="Realex Payments" /></A></p><p><a href="https://realexpayments.com">Click here to sign up now!</a></p>',
	
	
	'settings' => array(

		array(
			'name' => "Merchant ID",
			'short_name' => 'your_merchant_id',
			'type' => 'text'
		),
		array(
			'name' => "Your Secret",
			'short_name' => 'your_secret',
			'type' => 'text'
		),
	),

	'required_fields' => array(
		'currency_code'
	),

	'html' => '
	<fieldset class="billing" id="billing_info">
		<legend>Billing info</legend>
			<p>
				<label for="first_name" class="required" >First Name</label>
				<input type="text" name="first_name" id="first_name" value="" />
			</p>
			<p>
				<label for="last_name" class="required"  >Last Name</label>
				<input type="text" name="last_name" id="last_name" value="" />
			</p>
			<p>
				<label for="address">Street Address</label>
				<input type="text" name="address" id="address" value="" />
			</p>
			<p>
				<label for="address2" >Street Address</label>
				<input type="text" name="address2" id="address2" value="" />
			</p>
			<p>
				<label for="city"  >Town/City</label>
				<input type="text" name="city" id="city" value="" />
			</p>

			<p>
				<label for="zip"  >Post Code</label>
				<input type="text" name="zip" id="zip" value="" />
			</p>
				<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 -->
				<input type="hidden" name="country_code" value="IE" />
		</fieldset>

		<fieldset class="shipping" id="shipping_info">
			<legend>Shipping info</legend>
				<p>
					<label for="shipping_first_name" >First Name</label>
					<input type="text" name="shipping_first_name" id="shipping_first_name" value="" />
				</p>
				<p>
					<label for="shipping_last_name"   >Last Name</label>
					<input type="text" name="shipping_last_name" id="shipping_last_name" value="" />
				</p>
				<p>
					<label for="shipping_address">Street Address</label>
					<input type="text" name="shipping_address" id="shipping_address" value="" />
				</p>
				<p>
					<label for="shipping_address2" >Street Address</label>
					<input type="text" name="shipping_address2" id="shipping_address2" value="" />
				</p>
				<p>
					<label for="shipping_city"  >Town/City</label>
					<input type="text" name="shipping_city" id="shipping_city" value="" />
				</p>

				<p>
					<label for="shipping_zip"  >Post Code</label>
					<input type="text" name="shipping_zip" id="shipping_zip" value="" />
				</p>
			</fieldset>


		<fieldset class="information" id="additional_info">
			<legend>Additional Information</legend>
			<p>
				<label for="phone" class="required" >Phone</label>
				<input type="text" name="phone" id="phone" value="" />
			</p>
			<p>
				<label for="email_address" class="required">Email Address</label>
				<input type="text" name="email_address" id="email_address" value="" />
			</p>
		</fieldset>

		<fieldset class="payment" id="payment_info">
			<legend>Payment Details</legend>
			<input type="hidden" name="currency_code" id="currency_code" value="EUR" /><!--Must be a 3 character ISO 4217 currency_code http://en.wikipedia.org/wiki/ISO_4217 -->
			<p>
				<label for="card_type">Payment Type</label>
				<select name="card_type" id="card_type">
					<option value="MC">Master Card</option>
					<option value="VISA">Visa</option>
					<option value="AMEX">American Express</option>
					<option value="SWITCH">Switch</option>
					<option value="LASER">Laser</option>
					<option value="DINERS">Diners</option>
				</select>
			</p>
			<p>
				<label for="credit_card_number" class="required">Credit Card Number</label>
				<input type="text" name="credit_card_number" id="credit_card_number" value="" />
			</p>
			<p>
				<label for="CVV2">CVV2 Number</label>
				<input type="text" size="4" name="CVV2" id="CVV2" value="" />
			</p>
			<p>
				<label for="issue_number">Issue Number <span class="note">(for Switch and Laser cards only)</span></label>
				<input type="text" name="issue_number" id="issue_number" value="" />
			</p>
			<p>Card Expiration Date
				<label for="expiration_month" class="required">Month</label>
				<select name="expiration_month" id="expiration_month">
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
				<select name="expiration_year" id="expiration_year">
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
	
	class Cartthrob_realex_remote extends Cartthrob_payment_gateway
	{
		
		function Cartthrob_realex_remote()
		{
			
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[get_class($this).'_settings'];
			
			$this->_host = "https://epage.payandshop.com/epage-remote.cgi"; 
			
		}
		/**
		 * _process_payment function
		 *
		 * @param string $total the total amount of the purchase
		 * @param string $credit_card_number purchaser's credit cart number
		 * @param array $customer_info array containing $_POST fields captured by the checkout form
		 * @param string $order_id
		 * @access private
		 * @return array $resp an array containing the following keys: authorized, declined, failed, error_message, and transaction_id 
		 * the returned fields can be displayed in the templates using template tags. 
		 **/
		function _process_payment($total, $credit_card_number=NULL, $customer_info, $order_id='')
		{
			global $SESS; 
			
			$timestamp = strftime("%Y%m%d%H%M%S");
			mt_srand((double)microtime()*1000000);
			
			$orderid = $order_id."-".$timestamp;
			
			$rounded_total = round($total*100);

			$tmp = $timestamp.".".$this->plugin_settings['your_merchant_id'].".".$orderid.".".$rounded_total.".".$customer_info['currency_code'].".".$credit_card_number;

			$md5hash = md5($tmp);

			$tmp = $md5hash.".".$this->plugin_settings['your_secret'];

			$md5hash = md5($tmp);

$xml = "<request type='auth' timestamp='$timestamp'>
	<merchantid>".$this->plugin_settings['your_merchant_id']."</merchantid>
	<orderid>".$orderid."</orderid>
	<amount currency='".$customer_info['currency_code']."'>".$rounded_total."</amount>
	<card> 
		<number>".$credit_card_number."</number>
		<expdate>".$customer_info['expiration_month'].$customer_info['expiration_year']."</expdate>
		<type>".$customer_info['card_type']."</type>";
	
	if ($customer_info['member_id'])
	{
	$xml .="	<issueno>".$customer_info['issue_number']."</issueno>";	
	}	

	$xml.="		<chname>".$customer_info['first_name']." ".$customer_info['last_name']."</chname> 
		<cvn>
			<number>".$customer_info['CVV2']."</number>
			<presind>1</presind>
		</cvn>
	</card> 
	<autosettle flag='1'/>
	<md5hash>".$md5hash."</md5hash>
	<tssinfo>";
	if ($customer_info['member_id'])
	{
		$xml .="	<custnum>".$customer_info['member_id']."</custnmum>";	
	}

	$xml .="	<address type='billing'>
			<code>".$customer_info['zip']."</code>
			<country>".$customer_info['country_code']."</country>
		</address>
	</tssinfo>
</request>";

		
			$connect = 	$this->curl_transaction($this->_host,$xml); 
			if (!$connect)
			{
				$resp['failed']	  		= 	TRUE; 
				$resp['authorized']		=	FALSE;
				$resp['declined']		=	FALSE;
				$resp['error_message']	=	'Failed to Connect';
				
				return $resp; 
			}
			
			$data_array = $this->xml_to_array($connect); 

			if ($data_array['response']['result']['data'] == "00")
			{
				$resp['authorized']	 	= TRUE; 
				$resp['declined'] 		= FALSE; 
				$resp['transaction_id']	= $data_array['response']['authcode']['data']; 
				$resp['failed']			= FALSE; 
				$resp['error_message']	= '';
			}
			elseif($data_array['response']['result']['data'] == "101" || $data_array['response']['result']['data'] == "102" || $data_array['response']['result']['data'] == "103")
			{
				$resp['authorized']	 	= FALSE; 
				$resp['declined'] 		= TRUE; 
				$resp['transaction_id']	= "";
				$resp['failed']			= FALSE; 
				$resp['error_message']	= $data_array['response']['message']['data'];
			}
			elseif($data_array['response']['result']['data'] == "108")
			{
				$resp['authorized']	 	= FALSE; 
				$resp['declined'] 		= FALSE; 
				$resp['transaction_id']	= "";
				$resp['failed']			= TRUE; 
				$resp['error_message']	= $data_array['response']['message']['data'];
			}
			else
			{
				$resp['authorized']	 	= FALSE; 
				$resp['declined'] 		= FALSE; 
				$resp['transaction_id']	= NULL;
				$resp['failed']			= TRUE; 
				$resp['error_message']	= $data_array['response']['message']['data'];
			}

			//var_dump($data_array);
			//var_dump($resp);
			return $resp; 
		}
		// END
	}// END CLASS
}

/* End of file cartthrob.realex_remote.php */
/* Location: ./system/modules/payment_gateways/cartthrob.realex_remote.php */