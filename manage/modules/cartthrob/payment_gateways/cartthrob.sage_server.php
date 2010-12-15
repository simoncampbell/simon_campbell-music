<?php
global $LANG; 


$gateway_info = array(
	'title' => 'SagePay Server',
	'classname' => 'Cartthrob_sage_server',
	'affiliate' => $LANG->line('sage_affiliate'),
	'overview' => $LANG->line('sage_overview'),
	'settings' => array(
		array(
			'name' => 'Payment page style', 
			'short_name' => 'profile', 
			'type' => 'radio',  
			'default' => 'NORMAL', 
			'options' => array(
				'NORMAL' => 'Normal',
				'LOW' => 'Minimal formatting for use in iFrames'
				),
		),
		array(
			'name' => $LANG->line('sage_mode'),
			'short_name' => 'mode', 
			'type' => 'radio',  
			'default' => 'test', 
			'options' => array(
				'simulator' => 'Simulator',
				'test' => 'Test',
				'live' => 'Live'
				),
		),
		array(
			'name' => $LANG->line('sage_vendor_name'),
			'short_name' => 'vendor_name', 
			'type' => 'text',
		),
	),
	'required_fields' => array(
		'first_name',
		'last_name',
		'address',
		'city',
		'zip',
		'country_code'
	),
 
	'html' => '
		<fieldset class="billing" id="billing_info">
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
				<input type="hidden" name="currency_code" id="currency_code" value="GBP" /><!--Must be a 3 character ISO 4217 currency_code http://en.wikipedia.org/wiki/ISO_4217 -->
			</fieldset>
	',
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_sage_server extends Cartthrob_payment_gateway
	{
		function Cartthrob_sage_server()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
			if ($this->plugin_settings['mode'] == "test")
			{
				$this->_host = "https://test.sagepay.com/gateway/service/vspserver-register.vsp";
			}
			elseif ($this->plugin_settings['mode'] == "simulator")
			{
				$this->_host = "https://test.sagepay.com/Simulator/VSPServerGateway.asp?Service=VendorRegisterTx"; 
				
			}
			else
			{
				$this->_host = "https://live.sagepay.com/gateway/service/vspserver-register.vsp"; 
				
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
			$this->_session_start();

			$auth['authorized'] 	=	FALSE; 
			$auth['declined']		=	FALSE; 
			$auth['failed']			=	TRUE; 
			$auth['error_message']	= 	NULL; 
			$auth['transaction_id']	=	NULL;
			
			
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
				'VendorTxCode'				=> $order_id."_".session_id(),
				'Amount'					=> number_format($total,2,'.',''),
				'Currency'					=> (!empty($customer_info['currency_code'])?$customer_info['currency_code']:"GBP"),
				'Description'				=> (!empty($customer_info['description'])? $customer_info['description'] : "Purchase from ".$PREFS->core_ini['site_name']),
				'NotificationURL'			=> $this->_get_notify_url(ucfirst(get_class($this)),'payment_notification'),
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
			if ( "US" != $post_array['BillingCountry']) 
			{
				$post_array['BillingState']  = ""; 
				$post_array['DeliveryState']  = "";
			}
			else
			{
				$post_array['BillingState'] = !empty($customer_info['state']) ? strtoupper($customer_info['state']) : "NY"; 
				$post_array['DeliveryState'] = !empty($customer_info['shipping_state']) ? strtoupper($customer_info['shipping_state']) : $post_array['BillingState']; 

			}
			
			$post_array['Profile']  = $this->plugin_settings['profile']; 


			$data = 	$this->data_array_to_string($post_array);
			
			$connect = 	$this->curl_transaction($this->_host,$data); 
			
			if (!$connect)
			{
				$auth['failed']			= TRUE;
				$auth['authorized']		= FALSE;
				$auth['declined']		= FALSE;
				$auth['error_message']	= $LANG->line('sage_failed');
				
				return $auth; 
			}
			
			$transaction =  $this->split_url_string($connect, "\r\n");
			$next_url = explode("NextURL=", $connect);
			
			if (!empty($next_url[1]))
			{
				$next_url = str_replace("\r\n","",$next_url[1]);
			}

			if (!is_array($transaction))
			{
				$auth['failed']			= TRUE;
				$auth['authorized']		= FALSE;
				$auth['declined']		= FALSE;
				$auth['error_message']	= $LANG->line('sage_failed');
				
				return $auth;
			}
			
			if ("OK" != strtoupper($transaction['Status']))
			{
				switch(strtoupper($transaction['Status']))
				{
					case "MALFORMED":
						$auth['error_message'] = $LANG->line('sage_malformed'); 
						$auth['error_message'] .= $transaction['StatusDetail']; 
						break; 
					case "INVALID":
						$auth['error_message'] = $LANG->line('sage_invalid');
						$auth['error_message'] .= $transaction['StatusDetail']; 
						break;
					case "ERROR":
						$auth['error_message'] = $LANG->line('sage_error');
						break;
					default:
						$auth['error_message'] = $LANG->line('sage_default');
				}
				
				$auth['failed']			= TRUE;
				$auth['authorized']		= FALSE;
				$auth['declined']		= FALSE;
				$auth['transaction_id']	= NULL; 
				return $auth; 
			}
			
			$_SESSION['cartthrob']['sage_key'] = $transaction['SecurityKey']; 
			$this->gateway_exit_offsite(NULL, $next_url); exit; 
		} // END 
		
		/**
		 * payment_notification
		 *
		 * @return void
		 * @author Chris Newton
		 * @since 1.0
		 **/
		function payment_notification($post)
		{
			global $FNS; 

			$auth['authorized'] 	=	FALSE; 
			$auth['declined']		=	FALSE; 
			$auth['failed']			=	TRUE; 
			$auth['error_message']	= 	NULL; 
			$auth['transaction_id']	=	NULL;
			
			$order_id = NULL; 
			if (!empty($post['VendorTxCode']))
			{
				$order_info = explode("_",$post['VendorTxCode']); 
				$order_id = $order_info[0]; 
			}
			if ($order_info[1] != session_id())
			{
				session_destroy(); 
				session_id($order_info[1]);
				session_start();
			}
			
			$order_data = $this->_get_saved_order();
			
			if (strpos($order_data['return'], 'http') === 0)
			{
				$return_url = $order_data['return']; 
 			}
			else
			{
				$return_url = $FNS->create_url($order_data['return']);
 			}
			
			if ("OK" == strtoupper($post['Status']))
			{
				$auth['authorized'] 	=	TRUE; 
				$auth['declined']		=	FALSE; 
				$auth['failed']			=	FALSE; 
				$auth['error_message']	= 	NULL; 
				$auth['transaction_id']	=	trim($post['VPSTxId'], "{}"); // "Auth:".$post['TxAuthNo']."_Tx:".$post['VPSTxId']."_Vnd:".$post['VendorTxCode']."_Sec:".$_SESSION['cartthrob']['sage_key'];
				
				$tmp = array(
					'VPSTxId'			=>	$post['VPSTxId'],
					'VendorTxCode'		=>	$post['VendorTxCode'],
					'Status'  			=>	$post['Status'],
					'TxAuthNo'			=>	$post['TxAuthNo'],
					'VendorName' 		=>	$this->plugin_settings['vendor_name'],
					'AVSCV2'			=>	$post['AVSCV2'],
					'sage_key'			=>	$_SESSION['cartthrob']['sage_key'],
					'AddressResult'		=>	$post['AddressResult'],
					'PostCodeResult'	=>	$post['PostCodeResult'],
					'CV2Result'			=>	$post['CV2Result'],
					'GiftAid'			=>	$post['GiftAid'],
					'3DSecureStatus'	=>	$post['3DSecureStatus'],
					'CAVV'				=>	$post['CAVV'],
					'AddressStatus'		=>	$post['AddressStatus'],
					'PayerStatus'		=>	$post['PayerStatus'],
					'CardType'			=>	$post['CardType'],
					'Last4Digits'		=>	$post['Last4Digits']
					); 
				$md5 = implode("",$tmp);
				
				$md5hash = strtoupper(md5($md5));
				
				if ($md5hash != strtoupper($post['VPSSignature']))
				{
					$auth['authorized'] 	=	FALSE; 
					$auth['declined']		=	FALSE; 
					$auth['failed']			=	TRUE; 
					$auth['error_message']	= 	"Security Signature is not valid"; 
					$auth['transaction_id']	=	NULL;
					
					$this->gateway_order_update($auth,$order_id);
					
					// SAGE requires that we output this stuff. 
					echo "Status=INVALID\r\n";
					echo "RedirectURL=".$return_url."\r\n";
					exit; 
				}
				
				$this->gateway_order_update($auth,$order_id);
				$this->return_processing($auth, NULL);
				
				// SAGE requires that we output this stuff. 
				echo "Status=OK\r\n";
				echo "RedirectURL=".$return_url."\r\n";
				exit; 
			}
			else
			{
				switch(strtoupper($post['Status']))
				{
					case "NOTAUTHED":
						$auth['error_message'] = $LANG->line('sage_notauthed');
						echo "Status=OK\r\n";
						
						break; 
					case "ABORT":
						$auth['error_message'] = "Transaction Cancelled";
						echo "Status=OK\r\n";
						
						break; 
					case "REJECTED": 
						$auth['error_message'] =  $LANG->line('sage_rejected'); 
						$auth['declined']		=	TRUE; 
						echo "Status=INVALID\r\n";
						
						break; 
					case "AUTHENTICATED":
						$auth['error_message'] = $LANG->line('sage_authenticated');
						echo "Status=OK\r\n";
						
						break;
					case "REGISTERED":
						$auth['error_message'] =  $LANG->line('sage_registered');
						echo "Status=OK\r\n";
						
						break;
					case "ERROR":
						$auth['error_message'] = $LANG->line('sage_error');
						echo "Status=INVALID\r\n";
						
						break;
					default:
						$auth['error_message'] =  $LANG->line('sage_default');
				}
				$auth['authorized'] 	=	FALSE; 
				$auth['transaction_id']	=	NULL;
				
				$this->gateway_order_update($auth,$order_id);
				
				// SAGE requires that we output this stuff. 
				echo "RedirectURL=".$return_url."\r\n";
			}
		}
		// END
	}// END CLASS
}

/* End of file cartthrob.sage_server.php */
/* Location: ./system/modules/payment_gateways/cartthrob.sage_server.php */