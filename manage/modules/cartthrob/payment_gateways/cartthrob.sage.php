<?php
global $LANG; 

$gateway_info = array(
	'title' => $LANG->line('sage_title'),
	'classname' => 'Cartthrob_sage',
	'affiliate' => $LANG->line('sage_affiliate'),
	'overview' => $LANG->line('sage_overview'),
	'settings' => array(
		array(
			'name' => $LANG->line('sage_mode'),
			'short_name' => 'mode', 
			'type' => 'radio',
			'default' => "test",
			'options' => array(
				"simulator" => 'Simulator', 
				"test" =>'Test', 
				"live" => 'Live'
				)
		),
		array(
			'name' => $LANG->line('sage_vendor_name'),
			'short_name' => 'vendor_name', 
			'type' => 'text',
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
		'currency_code',
		'email_address',
	),
	
	'html' => '<fieldset class="billing" id="billing_info">
		<legend>Billing info</legend>
			<p>
				<label for="first_name" class="required" >First Name</label>
				<input type="text" name="first_name" id="first_name" value="" />
			</p>
			<p>
				<label for="last_name" class="required" >Last Name</label>
				<input type="text" name="last_name" id="last_name" value="" />
			</p>
			<p>
				<label for="address" class="required" >Street Address</label>
				<input type="text" name="address" id="address" value="" />
			</p>
			<p>
				<label for="address2" >Street Address</label>
				<input type="text" name="address2" id="address2" value="" />
			</p>
			<p>
				<label for="city" class="required" >Town/City</label>
				<input type="text" name="city" id="city" value="" />
			</p>
			<p>	
				<label for="state" class="required" >County</label>
				<select name="state" id="state" id="state">
					<optgroup label="England">
						<option>Bedfordshire</option>
						<option>Berkshire</option>
						<option>Bristol</option>
						<option>Buckinghamshire</option>
						<option>Cambridgeshire</option>
						<option>Cheshire</option>
						<option>City of London</option>
						<option>Cornwall</option>
						<option>Cumbria</option>
						<option>Derbyshire</option>
						<option>Devon</option>
						<option>Dorset</option>
						<option>Durham</option>
						<option>East Riding of Yorkshire</option>
						<option>East Sussex</option>
						<option>Essex</option>
						<option>Gloucestershire</option>
						<option>Greater London</option>
						<option>Greater Manchester</option>
						<option>Hampshire</option>
						<option>Herefordshire</option>
						<option>Hertfordshire</option>
						<option>Isle of Wight</option>
						<option>Kent</option>
						<option>Lancashire</option>
						<option>Leicestershire</option>
						<option>Lincolnshire</option>
						<option>Merseyside</option>
						<option>Norfolk</option>
						<option>North Yorkshire</option>
						<option>Northamptonshire</option>
						<option>Northumberland</option>
						<option>Nottinghamshire</option>
						<option>Oxfordshire</option>
						<option>Rutland</option>
						<option>Shropshire</option>
						<option>Somerset</option>
						<option>South Yorkshire</option>
						<option>Staffordshire</option>
						<option>Suffolk</option>
						<option>Surrey</option>
						<option>Tyne and Wear</option>
						<option>Warwickshire</option>
						<option>West Midlands</option>
						<option>West Sussex</option>
						<option>West Yorkshire</option>
						<option>Wiltshire</option>
						<option>Worcestershire</option>
					</optgroup>
					<optgroup label="Wales">
						<option>Anglesey</option>
						<option>Brecknockshire</option>
						<option>Caernarfonshire</option>
						<option>Carmarthenshire</option>
						<option>Cardiganshire</option>
						<option>Denbighshire</option>
						<option>Flintshire</option>
						<option>Glamorgan</option>
						<option>Merioneth</option>
						<option>Monmouthshire</option>
						<option>Montgomeryshire</option>
						<option>Pembrokeshire</option>
						<option>Radnorshire</option>
					</optgroup>
					<optgroup label="Scotland">
						<option>Aberdeenshire</option>
						<option>Angus</option>
						<option>Argyllshire</option>
						<option>Ayrshire</option>
						<option>Banffshire</option>
						<option>Berwickshire</option>
						<option>Buteshire</option>
						<option>Cromartyshire</option>
						<option>Caithness</option>
						<option>Clackmannanshire</option>
						<option>Dumfriesshire</option>
						<option>Dunbartonshire</option>
						<option>East Lothian</option>
						<option>Fife</option>
						<option>Inverness-shire</option>
						<option>Kincardineshire</option>
						<option>Kinross</option>
						<option>Kirkcudbrightshire</option>
						<option>Lanarkshire</option>
						<option>Midlothian</option>
						<option>Morayshire</option>
						<option>Nairnshire</option>
						<option>Orkney</option>
						<option>Peeblesshire</option>
						<option>Perthshire</option>
						<option>Renfrewshire</option>
						<option>Ross-shire</option>
						<option>Roxburghshire</option>
						<option>Selkirkshire</option>
						<option>Shetland</option>
						<option>Stirlingshire</option>
						<option>Sutherland</option>
						<option>West Lothian</option>
						<option>Wigtownshire</option>
					</optgroup>
					<optgroup label="Northern Ireland">
						<option>Antrim</option>
						<option>Armagh</option>
						<option>Down</option>
						<option>Fermanagh</option>
						<option>Londonderry</option>
						<option>Tyrone</option>
					</optgroup>
				</select>
			</p>
			<p>
				<label for="zip" class="required" >Post Code</label>
				<input type="text" name="zip" id="zip" value="" />
			</p>
			<p>
				<label for="country_code" class="required" >Country</label>
				<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 -->
				<select name="country_code" id="country_code">
						<option value="GB">United Kingdom</option>
				</select>
			</p>
		</fieldset>

		<fieldset class="shipping" id="shipping_info">
			<legend>Shipping Details</legend>
			<p>
				<label for="shipping_first_name">First Name</label>
				<input type="text" name="shipping_first_name" id="shipping_first_name" value="" />
			</p>
			<p>
				<label for="shipping_last_name">Last Name</label>
				<input type="text" name="shipping_last_name" id="shipping_last_name" value="" />
			</p>
			<p>
				<label for="shipping_address" >Street Address</label>
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
				<label for="shipping_state"  >County</label>
				<select name="shipping_state" id="shipping_state" id="shipping_state">
					<optgroup label="England">
							<option>Bedfordshire</option>
							<option>Berkshire</option>
							<option>Bristol</option>
							<option>Buckinghamshire</option>
							<option>Cambridgeshire</option>
							<option>Cheshire</option>
							<option>City of London</option>
							<option>Cornwall</option>
							<option>Cumbria</option>
							<option>Derbyshire</option>
							<option>Devon</option>
							<option>Dorset</option>
							<option>Durham</option>
							<option>East Riding of Yorkshire</option>
							<option>East Sussex</option>
							<option>Essex</option>
							<option>Gloucestershire</option>
							<option>Greater London</option>
							<option>Greater Manchester</option>
							<option>Hampshire</option>
							<option>Herefordshire</option>
							<option>Hertfordshire</option>
							<option>Isle of Wight</option>
							<option>Kent</option>
							<option>Lancashire</option>
							<option>Leicestershire</option>
							<option>Lincolnshire</option>
							<option>Merseyside</option>
							<option>Norfolk</option>
							<option>North Yorkshire</option>
							<option>Northamptonshire</option>
							<option>Northumberland</option>
							<option>Nottinghamshire</option>
							<option>Oxfordshire</option>
							<option>Rutland</option>
							<option>Shropshire</option>
							<option>Somerset</option>
							<option>South Yorkshire</option>
							<option>Staffordshire</option>
							<option>Suffolk</option>
							<option>Surrey</option>
							<option>Tyne and Wear</option>
							<option>Warwickshire</option>
							<option>West Midlands</option>
							<option>West Sussex</option>
							<option>West Yorkshire</option>
							<option>Wiltshire</option>
							<option>Worcestershire</option>
						</optgroup> 
						<optgroup label="Wales">
							<option>Anglesey</option>
							<option>Brecknockshire</option>
							<option>Caernarfonshire</option>
							<option>Carmarthenshire</option>
							<option>Cardiganshire</option>
							<option>Denbighshire</option>
							<option>Flintshire</option>
							<option>Glamorgan</option>
							<option>Merioneth</option>
							<option>Monmouthshire</option>
							<option>Montgomeryshire</option>
							<option>Pembrokeshire</option>
							<option>Radnorshire</option>
						</optgroup>
						<optgroup label="Scotland">
							<option>Aberdeenshire</option>
							<option>Angus</option>
							<option>Argyllshire</option>
							<option>Ayrshire</option>
							<option>Banffshire</option>
							<option>Berwickshire</option>
							<option>Buteshire</option>
							<option>Cromartyshire</option>
							<option>Caithness</option>
							<option>Clackmannanshire</option>
							<option>Dumfriesshire</option>
							<option>Dunbartonshire</option>
							<option>East Lothian</option>
							<option>Fife</option>
							<option>Inverness-shire</option>
							<option>Kincardineshire</option>
							<option>Kinross</option>
							<option>Kirkcudbrightshire</option>
							<option>Lanarkshire</option>
							<option>Midlothian</option>
							<option>Morayshire</option>
							<option>Nairnshire</option>
							<option>Orkney</option>
							<option>Peeblesshire</option>
							<option>Perthshire</option>
							<option>Renfrewshire</option>
							<option>Ross-shire</option>
							<option>Roxburghshire</option>
							<option>Selkirkshire</option>
							<option>Shetland</option>
							<option>Stirlingshire</option>
							<option>Sutherland</option>
							<option>West Lothian</option>
							<option>Wigtownshire</option>
						</optgroup> 
						<optgroup label="Northern Ireland">
							<option>Antrim</option>
							<option>Armagh</option>
							<option>Down</option>
							<option>Fermanagh</option>
							<option>Londonderry</option>
							<option>Tyrone</option>
						</optgroup>
					</select>
			</p>
			<p>
				<label for="shipping_zip"  >Post Code</label>
				<input type="text" name="shipping_zip" id="shipping_zip" value="" />
			</p>
			<p>
				<label for="shipping_country_code" class="" >Country</label>
				<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 -->
				<select name="shipping_country_code" id="shipping_country_code">
						<option value="GB">United Kingdom</option>
				</select>
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
			<p>	
				<label for="description">Description of Your Purchase (for your records)</label>
				<input type="text" name="description" id="description" maxlength="100"/>
			</p>	
		</fieldset>

		<fieldset class="payment" id="payment_info">
			<legend>Payment Details</legend>
			<input type="hidden" name="currency_code" id="currency_code" value="GBP" /><!--Must be a 3 character ISO 4217 currency_code http://en.wikipedia.org/wiki/ISO_4217 -->
			<p>
				<label for="card_type">Payment Type</label>
				<select name="card_type" id="card_type">
					<option value="MC">Master Card</option>
					<option value="VISA">Visa</option>
					<option value="AMEX">American Express</option>
					<option value="MAESTRO">Maestro</option>
					<option value="SOLO">Solo</option>
					<option value="DELTA">Delta</option>
				</select>
			</p>

			<p>
				<label for="issue_number">Issue Number <span class="note">(for Maestro and Solo cards only)</span></label>
				<input type="text" name="issue_number" id="issue_number" value="" />
			</p>
			<p>
				<label for="credit_card_number" class="required">Credit Card Number</label>
				<input type="text" name="credit_card_number" id="credit_card_number" value="" />
			</p>
			<p>
				<label for="CVV2">CVV2 Number</label>
				<input type="text" size="4" name="CVV2" id="CVV2" value="" />
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
			<p>Card Start Date  (required for some Maestro, Solo and Amex)
				<label for="begin_month" class="required">Month</label>
				<select name="begin_month" id="begin_month">
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
				<label for="begin_year" class="required">Year</label>
				<select name="begin_year" id="begin_year">
					<option value="00">2000</option>
					<option value="01">2001</option>
					<option value="02">2002</option>
					<option value="03">2003</option>
					<option value="04">2004</option>
					<option value="05">2005</option>
					<option value="06">2006</option>
					<option value="07">2007</option>
					<option value="08">2008</option>
					<option value="09">2009</option>
					<option value="10">2010</option>
					<option value="11">2011</option>
					<option value="12">2012</option>
				</select>
				</p>
		</fieldset>',
);

if ( ! class_exists($gateway_info['classname']))
{
	/* // test numbers
		Visa 4929000000006
		Visa Delta 4462000000000003
		Visa Electron UK Debit 4917300000000008
		Mastercard 5404000000000001
		UK Maestro 5641820000000005
		International Maestro 300000000000000004  
		Solo 6334900000000005
		American Express 374200000000004

	*/
	
	class Cartthrob_sage extends Cartthrob_payment_gateway
	{
		function Cartthrob_sage()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
			if ($this->plugin_settings['mode'] == "simulator")
			{
				$this->_host = 'https://test.sagepay.com/Simulator/VSPDirectGateway.asp'; 
			}
			elseif ($this->plugin_settings['mode'] == "live")
			{
				$this->_host = 'https://live.sagepay.com/gateway/service/vspdirect-register.vsp'; 
			}
			else
			{
				$this->_host = 'https://test.sagepay.com/gateway/service/vspdirect-register.vsp'; 
			}
			
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
			global $LANG, $PREFS; 
			
			$basket = (count($this->_get_cart_items())+1).":"; 
			
			foreach ($this->_get_cart_items() as $row_id=>$item)
			{
				if (!isset($count))
				{
					$count=0;
				}
				$count++;
				$basket .=$item['title'] .":";
				$basket .=$item['quantity'] .":";
				$basket .=$this->_get_item_price($item['entry_id'], $row_id).":";
				$basket .=":";
				$basket .=$this->_get_item_price($item['entry_id'], $row_id).":";
				$basket .= ($this->_get_item_price($item['entry_id'], $row_id))*$item['quantity'].":";
			}
			$basket .= 'Shipping:----:----:----:----:';
			$basket .= $this->_calculate_shipping();
						
			
			$post_array = array(
				'VPSProtocol' 				=> "2.23",
				'TxType'					=> 'PAYMENT',
				'Vendor'					=> $this->plugin_settings['vendor_name'],
				'VendorTXCode'				=> str_replace(".","",uniqid(rand(),true)), // needs a unique ID for this transaction. 
				'Amount'					=> number_format($total,2,'.',''),
				'Currency'					=> $customer_info['currency_code'],
				'Description'				=> !empty($customer_info['description'])? $customer_info['description'] : "Purchase from ".$PREFS->core_ini['site_name'],
				'CardHolder'				=> $customer_info['first_name'] . " ". $customer_info['last_name'], 
				'CardNumber'				=> $credit_card_number,
				'StartDate'					=> !empty($customer_info['begin_month']) ? str_pad($customer_info['begin_month'], 2, '0', STR_PAD_LEFT) . $customer_info['begin_year']: "",
				'ExpiryDate'				=> str_pad($customer_info['expiration_month'], 2, '0', STR_PAD_LEFT) . $customer_info['expiration_year'],
				'IssueNumber'				=> $customer_info['issue_number'],
				'CV2'						=> $customer_info['CVV2'],
				'CardType'					=> $customer_info['card_type'],
				'BillingSurname'			=> $customer_info['last_name'],
				'BillingFirstnames'			=> $customer_info['first_name'],
				'BillingAddress1'			=> $customer_info['address'],
				'BillingAddress2'			=> $customer_info['address2'],
				'BillingCity'				=> $customer_info['city'],
				'BillingPostCode'			=> $customer_info['zip'],
				'BillingCountry'			=> $this->_get_alpha2_country_code(@$customer_info['country_code']),
				'BillingPhone'				=> preg_replace('/[^0-9-]/', '', $customer_info['phone']),
				'DeliverySurname'			=> !empty($customer_info['shipping_last_name']) ? $customer_info['shipping_last_name'] : $customer_info['last_name'],
				'DeliveryFirstnames'		=> !empty($customer_info['shipping_first_name']) ? $customer_info['shipping_first_name'] : $customer_info['first_name'],
				'DeliveryAddress1'			=> !empty($customer_info['shipping_address']) ? $customer_info['shipping_address'] : $customer_info['address'],
				'DeliveryAddress2'			=> !empty($customer_info['shipping_address2']) ? $customer_info['shipping_address2'] : $customer_info['address2'],
				'DeliveryCity'				=> !empty($customer_info['shipping_city']) ? $customer_info['shipping_city'] : $customer_info['city'],
				'DeliveryPostCode'			=> !empty($customer_info['shipping_zip']) ? $customer_info['shipping_zip'] : $customer_info['zip'],
				'DeliveryCountry'			=> !empty($customer_info['shipping_country_code']) ? $this->_get_alpha2_country_code(@$customer_info['shipping_country_code']) : $this->_get_alpha2_country_code(@$customer_info['country_code']),
				'CustomerEMail'				=> $customer_info['email_address'],
				'Basket'					=> $basket,

			); 
			
			// We don't want to pass the state data to eWay unless it has 2 characters and is a us state. They don't accept any non-us state values
			if ("US" != $post_array['DeliveryCountry'])
			{
			    $post_array['DeliveryState']  = "";
			}
			else
			{
			    $post_array['DeliveryState'] = strtoupper($customer_info['shipping_state']);
			}
			if ("US" != $post_array['BillingCountry'])
			{
			    $post_array['BillingState']  = ""; 
			}
			else
			{
			    $post_array['BillingState'] = strtoupper($customer_info['state']); 
			}
			
			$data = 	$this->data_array_to_string($post_array);
			$connect = 	$this->curl_transaction($this->_host,$data); 
			
			if (!$connect)
			{
				$resp['failed']			= TRUE;
				$resp['authorized']		= FALSE;
				$resp['declined']		= FALSE;
				$resp['error_message']	= $LANG->line('sage_failed');
				
				return $resp; 
			}
			$transaction =  $this->split_url_string($connect, "\r\n");
			
	
			$declined = FALSE;
			$failed = FALSE;
			$error_message = "";
			
			if (is_array($transaction))
			{
				if ("OK" == strtoupper($transaction['Status']))
				{
					$authorized = TRUE; 
					$declined = FALSE; 
					$transaction_id = trim($transaction['VPSTxId'], "{}"); 
					$error_message = '';
				}
				else
				{
					switch(strtoupper($transaction['Status']))
					{
						case "MALFORMED":
						$error_message = $LANG->line('sage_malformed'); 
						$error_message .= $transaction['StatusDetail']; 
						
						break; 
						case "INVALID":
						$error_message = $LANG->line('sage_invalid');
						$error_message .= $transaction['StatusDetail']; 
						break;
						case "NOTAUTHED":
						$error_message = $LANG->line('sage_notauthed');
						break; 
						case "REJECTED": 
						$error_message = $LANG->line('sage_rejected'); 
						break; 
						case "3DAUTH":
						$error_message = $LANG->line('sage_3dauth');
						break;
						case "PPREDIRECT":
						$error_message = $LANG->line('sage_ppredirect');
						break;
						case "AUTHENTICATED":
						$error_message = $LANG->line('sage_authenticated');
						break;
						case "REGISTERED":
						$error_message = $LANG->line('sage_registered');
						break;
						case "ERROR":
						$error_message = $LANG->line('sage_error');
						break;
						default:
						$error_message = $LANG->line('sage_default');
					}
					if (array_key_exists('3DSecureStatus',$transaction) && "NOTCHECKED" !=  strtoupper($transaction['3DSecureStatus']))
					{
						$error_message .= $LANG->line('sage_3dsecure'); 
					}
					$authorized = FALSE; 
					$declined = TRUE; 
					$transaction_id = 0;
				}
				$resp['authorized']		=	$authorized;
				$resp['error_message']	=	$error_message;
				$resp['failed']			=	$failed;
				$resp['declined']		=	$declined;
				$resp['transaction_id'] =	$transaction_id;
			}
			else
			{
				$resp['authorized']		=	FALSE;
				$resp['error_message']	=	$LANG->line('sage_contact_admin');
				$resp['failed']			=	TRUE;
			}
			return $resp;
		}
	}
}
/* End of file cartthrob.sage.php */
/* Location: ./system/modules/payment_gateways/cartthrob.sage.php */