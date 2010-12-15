<?php
global $LANG; 

$gateway_info = array(
	'title' => $LANG->line('paypal_title'),
	'classname' => 'Cartthrob_paypal_standard',
	'affiliate' => $LANG->line('paypal_affiliate'),
	'overview' => $LANG->line('paypal_standard_overview'),
	'settings' => array(
		array(
			'name' => $LANG->line('paypal_settings_id'), 
			'short_name' => 'paypal_id', 
			'type' => 'text', 
		),
		array(
			'name' => $LANG->line('paypal_sandbox_settings_id'), 
			'short_name' => 'paypal_sandbox_id', 
			'type' => 'text', 
		),
		array(
			'name' => $LANG->line('mode'), 
			'short_name' => 'test_mode', 
			'type' => 'radio',
			'default' => 'Live',
			'options' => array(
				'Test' => $LANG->line('sandbox'),
				'Live' => $LANG->line('live'),
			),
		),
		array(
			'name' => "Allow address editing at PayPal?", 
			'short_name' => 'address_override', 
			'type' => 'radio',
			'default' => '0',
			'options' => array(
				'1' => $LANG->line('no'), // setting this to 1 because we don't want our customers to change it while at paypal
				'0' => $LANG->line('yes'),
			),
		),
		/*array(
			'name' => $LANG->line('paypal_send_notification_emails'), 
			'short_name' => 'send_emails_when', 
			'type' => 'radio',
			'default' => 'transaction_complete',
			'options' => array(
				'transaction_complete' => $LANG->line('paypal_transaction_complete'),
				'payment_confirmed'	=> $LANG->line('paypal_payment_confirmed'), 
				'both'		=> $LANG->line('paypal_both')
			),
		),*/
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
	<fieldset class="information" id="additional_info">
		<legend>Additional Information</legend>
		<p>
			<label for="email_address" class="required">Email Address</label>
			<input  id="email_address" type="text" name="email_address" value="" />
		</p>
		<input type="hidden" name="transaction_type" value="_cart" /> 
		<input type="hidden" name="weight_unit" value="lbs">
		<input type="hidden" name="currency_code" value="USD">
	</fieldset>',

);
if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_paypal_standard extends Cartthrob_payment_gateway
	{
		function Cartthrob_paypal_standard()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
			if ($this->plugin_settings['test_mode'] == 'Live')
			{
				$this->_paypal_server = 'https://www.paypal.com/cgi-bin/webscr';
				$this->_id = $this->plugin_settings('paypal_id'); 
			}
			else
			{
				$this->_paypal_server = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
				$this->_id = $this->plugin_settings('paypal_sandbox_id');
			}
			
		}
		// END
		
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
			global $PREFS, $FNS, $DB, $OUT, $SESS, $LANG;
			
			// ****************** DEFAULTS **************************** // 
			
			if (! $customer_info['success_return'])
			{
				$customer_info['success_return'] = 	$PREFS->core_ini['site_url']; 
			}
			if (! $customer_info['cancel_return'])
			{
				$customer_info['cancel_return'] = 	$PREFS->core_ini['site_url']; 
			}
			if (! $customer_info['transaction_type'])
			{
				$customer_info['transaction_type'] = '_cart'; // _xclick, _donations, _xclick-subscriptions, _oe-gift-certificate
			}
			if (! $customer_info['country_code'])
			{
				$customer_info['country_code'] = 'US'; 
			}
			// ******************************************************* // 
			
			// Formats phone number into chunks. 
			$phone = $this->_get_formatted_phone($customer_info['phone']);
			
			$currency_code = ( ! empty($customer_info['currency_code'])) ? $customer_info['currency_code'] : @$this->settings['number_format_defaults_currency_code'];
			
			$post_array = array(
				'cmd'					=> (!empty($customer_info['transaction_type'])) ? $customer_info['transaction_type'] : '_cart',
				'address_override'		=> $this->plugin_settings('address_override'), // setting this to 1 because we don't want our customers to change it while at paypal
				'upload'				=> '1', // so we can send all items at once.
				'business'				=> $this->_id,
				'weight_unit'			=> (!empty($customer_info['weight_unit'])) ? $customer_info['weight_unit'] : "lbs", 
				'currency_code'			=> $currency_code, //PAYPAL's default is USD.  
				'tax_cart'				=> $this->_calculate_tax(),
				'discount_amount_cart'	=> $this->_calculate_discount(),
				'address1'				=> $customer_info['address'],
				'address2'				=> $customer_info['address2'],
				'city'					=> $customer_info['city'],
				'country'				=> $this->_get_alpha2_country_code($customer_info['country_code']),
				'email'					=> $customer_info['email_address'],
				'first_name'			=> $customer_info['first_name'],
				'last_name'				=> $customer_info['last_name'],
				'lc'					=> $this->_get_language_abbrev($SESS->userdata['language']),
				'night_phone_a'			=> $phone['area_code'],
				'night_phone_b'			=> $phone['prefix'],
				'night_phone_c'			=> $phone['suffix'],
				'state'					=> $customer_info['state'],
				'zip'					=> $customer_info['zip'],


				'rm'					=> '2',
				//'cbt'					=> 'Return to Merchant', // changes the return to merchant message on paypals page
				//'custom'				=> "",
				//'no_note'				=> '1',
				//'cn'					=> 'Leave a note', // custom message above notes field.

				'shipping_1'			=> $this->_calculate_shipping(),
				'invoice'				=> $order_id."_".uniqid(rand(),true),
				);
			
			foreach ($post_array as $key=>$item)
			{
				if (strstr($item, '&'))
				{
					$post_array[$key] = str_replace("&" , "and", $item);
				}
			}
			// setting these separately because they need to maintain their ampersands.
 			$post_array['notify_url'] = $this->_get_notify_url(ucfirst(get_class($this)),'paypal_incoming_payment'); 
			$post_array['cancel_return'] = $customer_info['cancel_return']; 
			$post_array['return'] =   $this->_get_notify_url(ucfirst(get_class($this)),'paypal_success'); 
			
			foreach ($post_array as $key=>$item)
			{
				if ($item=="")
				{
					unset ($post_array[$key]);
				}




			}

			$cart_total = $this->_calculate_total(); 
			/*
				// ************************** SENDING ALL ITEM DATA **************************** // 
				foreach ($this->_get_cart_items() as $row_id=>$item)
				{
					if (!isset($count))
					{
						$count=0;
					}
					$count++;
					$post_array["weight_".$count] 		= $this->_get_item_weight($item['entry_id'], $row_id); 
					$post_array["item_name_".$count]	= $item['title']; 
					$post_array["quantity_".$count]	 	= $item['quantity']; 
					$post_array["amount_".$count]		= $this->_get_item_price($item['entry_id'], $row_id); 
				}
			*/
			if ($total > $cart_total)
			{
				$post_array['handling_cart'] = $total - $cart_total; 
			}
			
			$post_array["item_name_1"]	= $LANG->line('paypal_cart_default_title'); 
			$post_array["amount_1"]		= $this->_calculate_subtotal();
			
			// **************************************************************************************** // 
			$data	= 	$this->data_array_to_string($post_array);
			$url	= 	$this->_paypal_server;
			$url	.= 	'?'.$data;
									
			$this->_save_purchased_items(); 						
			
			header("Location: $url");

			exit;
		}
		// END
		
		/**
		 * paypal_success
		 *
		 * This is a maintenance and redirection function for paypal
		 * Order status is not updated until the process_incoming_payment function is fired 
		 * This function primarily does temporary cleanup in anticipation for a successful 
		 * response from the Payapl IPN. 
		 * 
		 * @param array $post 
		 * @return void
		 * @author Chris Newton
		 */
		function paypal_success($post)
		{
			global $IN; 
			
			$this->log("paypal success ");
			
			$this->_process_coupon_codes();

			$this->_process_inventory();
			
			$order_data = $this->_get_saved_order();

			$entry_id = $order_data['entry_id'];
			
			$transaction_id = (!empty($post['tx']) ? $post['tx'] : "");
			
			$order_data['auth'] = array(
				'authorized' 	=> TRUE,
				'error_message'	=> NULL,
				'failed'		=> FALSE,
				'declined'		=> FALSE,
				'transaction_id'=> $transaction_id, 
				);
				
			$this->_save_order_to_session($order_data);

			$this->_on_authorize($order_data);

			/*if ($this->plugin_settings['send_emails_when'] == "transaction_complete" || $this->plugin_settings['send_emails_when'] == "both")
			{
				if ($this->settings['send_confirmation_email'])
				{
					$customer_info = $this->_get_customer_info();
					$this->_send_confirmation_email($customer_info['email_address'], $order_data);
				}
				if ($this->settings['send_email'])
				{
					$this->_send_admin_notification_email($order_data);
				}
			}*/
			if ($this->settings['send_confirmation_email'])
			{
				$customer_info = $this->_get_customer_info();
				$this->_send_confirmation_email($customer_info['email_address'], $order_data);
			}
			if ($this->settings['send_email'])
			{
				$this->_send_admin_notification_email($order_data);
			}
	
			$this->clear_cart(FALSE);

			$this->_clear_security_hash();

			$this->_clear_coupon_codes();

			$this->_redirect($order_data['return']);
			
			// we don't want to go through the normal checkout_complete function, so we exit here. 
			exit; 
		}
		function paypal_incoming_payment($post)
		{
			global $LANG; 
			$this->log("paypal incoming payment activated ");
			
			if (empty($post))
			{
				@header("HTTP/1.0 404 Not Found");
		        @header("HTTP/1.1 404 Not Found");
		        exit('No Data Sent');
			}

			if ($this->_save_orders)
			{	
				$this->log("paypal: save_orders");
							
				// need to get the order id out of the return data
				if (!array_key_exists('invoice', $post) OR !$post['invoice'])
				{
					$this->log("information was not successfully transmitted from paypal ");
					exit; 
				}
				else
				{
					$entry_id = $post['invoice'];
				}
			}

			$auth = array(
				'authorized' 	=> FALSE,
				'error_message'	=> NULL,
				'failed'		=> TRUE,
				'declined'		=> FALSE,
				'transaction_id'=> NULL, 
				); 
			
			// The return response to Paypal must contain all of the data of the original
			// with the addition of the notify-validate command
			$post['cmd'] = '_notify-validate';
			
			// Fix for multi-line data
			foreach ($post as $key => $value)
			{
				// Thanks to Dom.S for finding a cure for this multi-line issue.  
				$cleaned = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i','${1}%0D%0A${3}',  urldecode($value));
				
				$post[$key] = $cleaned;
			}
			
			$data = $this->data_array_to_string($post);
			
			// RESULT will either contain VERIFIED or INVALID
    		$result = $this->curl_transaction($this->_paypal_server,$data);
			
			foreach ($post as $key => $item)
			{
				$this->log("paypal post-$key: $item");
			}
						
			$this->log("paypal server: $this->_paypal_server");
			
			$this->log("paypal result: $result");
			
			if (stristr($result, 'VERIFIED'))
	    	{
				$this->log("paypal: verified");
				
				// we don't want paypal info for ID's that we're not using, and we don't want information about unfinished transactions
				if ($this->plugin_settings['paypal_id'] != trim($post['receiver_email']))
	    		{
					$auth['error_message']	.= $LANG->line('paypal_incorrect_id'); 
				//	$this->log("paypal: incorrect_id");
					
	    		}
				if ( strtolower(trim($post['payment_status'])) != 'completed' )
				{
					$auth['error_message']	.= $LANG->line('paypal_status_incomplete'); 
					$this->log("paypal: status incomplete");
					
				}
				else
				{
					$auth = array(
						'authorized' 	=> TRUE,
						'error_message'	=> NULL,
						'failed'		=> FALSE,
						'declined'		=> FALSE,
						'transaction_id'=> $post['txn_id'], 
						);
				}
				
			}
			elseif (stristr($result, 'INVALID'))
			{
				
				$auth = array(
					'authorized' 	=> FALSE,
					'error_message'	=> $LANG->line('paypal_not_verified'),
					'failed'		=> TRUE,
					'declined'		=> FALSE,
					'transaction_id'=> NULL, 
					);
					
					$this->log("paypal: invalid");
					
			}
			else
			{
				$this->log("paypal: unknown response");
				
				$auth = array(
					'authorized' 	=> FALSE,
					'error_message'	=> $LANG->line('paypal_unknown_response'),
					'failed'		=> TRUE,
					'declined'		=> FALSE,
					'transaction_id'=> NULL, 
					);
			}
			
			if ($auth['authorized'])
			{
				$this->log("paypal: authorized");
				
				$update_data = array(
					'status' => ($this->_orders_default_status) ? $this->_orders_default_status : 'open',
					'transaction_id' => @$auth['transaction_id']
				);
				foreach ($update_data as $key=> $item)
				{
					$this->log("paypal: order data $key = $item");
					
				}
				if ($this->_save_orders)
				{
					$this->log("paypal: update order $entry_id");
					
					$this->_update_order($entry_id, $update_data);
				}
				else
				{
					$this->log("paypal: save orders not enabled");
				}
				
				$this->_update_purchased_items($entry_id); 
			}
			elseif ($auth['declined'])
			{
				$this->log("paypal: declined");
				
				if ($this->_save_orders)
				{
					$update_data = array(
						'status'	=> ($this->settings['orders_declined_status']) ? $this->settings['orders_declined_status'] : 'closed',
						'error_message' => 'DECLINED: '.@$auth['error_message'],
						);
					$this->_update_order($entry_id, $update_data);
				}

				$this->_on_decline();
			}
			elseif ($auth['failed'])
			{

				$this->log("paypal: failed");

				if ($this->_save_orders)
				{
					$update_data = array(
						'status'	=> ($this->settings['orders_failed_status']) ? $this->settings['orders_failed_status'] : 'closed',
						'error_message' => 'FAILED: '.@$auth['error_message'],
						);
					$this->_update_order($entry_id, array('error_message' => 'FAILED: '.@$auth['error_message']));
				}
				$this->_on_fail();
			}
			$this->log("paypal: exit");
			
			// we don't want to go through the normal checkout_complete function, so we exit here. 
			exit;
		}
	}// END CLASS
}

/* End of file cartthrob.cartthrob_paypal_standard.php */
/* Location: ./system/modules/payment_gateways/cartthrob.cartthrob_paypal_standard.php */