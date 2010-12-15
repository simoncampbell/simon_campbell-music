<?php
global $LANG;

$gateway_info = array(
	'title' => $LANG->line('eway_title'),
	'classname' => 'Cartthrob_eway',
	'overview' => $LANG->line('eway_overview'),
	'settings' => array(
		array(
			'name' => $LANG->line('eway_customer_id'),
			'short_name' => 'customer_id', 
			'type' => 'text', 
			'default' => '87654321', 
		),
		array(
			'name' => $LANG->line('eway_payment_method'),
			'short_name' => 'payment_method', 
			'type' => 'radio', 
			'default' => 'REAL-TIME', 
			'options' => array('REAL-TIME', 'REAL-TIME-CVN', 'GEO-IP-ANTI-FRAUD'),
			
		),
		array(
			'name' => $LANG->line('test_mode'),
			'short_name' => 'test_mode', 
			'type' => 'radio', 
			'default' => 'Yes',
			'options' => array(
				'Yes' => $LANG->line('yes'),
				'No' => $LANG->line('no')
			)
		),
	),
	'required_fields' => array(
		'first_name',
		'last_name',
		'address',
		'city',
		'zip',
		'credit_card_number',
		'expiration_year',
		'expiration_month',
	),
	
	'html' => '<fieldset class="billing_info" id="billing_info">
		<legend>Billing Info</legend>
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
			<label for="zip" class="required" >Postal Code</label>
			<input type="text" id="zip" name="zip" value="" />
		</p>
	</fieldset>
	<fieldset class="shipping_info" id="shipping_info">
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
			<label for="shipping_zip"  >Postal Code</label>
			<input  id="shipping_zip" type="text" name="shipping_zip" value="" />
		</p>
	</fieldset>

	<fieldset class="information"  id="additional_info">
		<legend>Additional Information</legend>
		<input type="hidden" id="description" name="description" value="" maxlength="15"/><!-- This field adds a second line on a credit card statement-->
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
			<select name="card_type" id="card_type">
				<option selected value="Visa">Visa</option>
				<option value="Mastercard">Mastercard</option>
				<option value="American Express">American Express</option>
				<option value="Discover">Discover</option>
			</select>
		</p>
		<p>
			<label for="credit_card_number" class="required">
				Credit Card Number
			</label>
			<input id="credit_card_number"  type="text" name="credit_card_number" value="" />
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
	</fieldset>',
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_eway extends Cartthrob_payment_gateway
	{
		/**
		 * Cartthrob_eway class
		 *
		 * @package default
		 * @author Chris Newton
		 * @since 1.0.0
		 **/
		function Cartthrob_eway()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];

			if ($this->plugin_settings('test_mode') == 'Yes')
			{
				$this->_customer_id = "87654321";
			}
			else
			{
				$this->_customer_id = $this->plugin_settings['customer_id']; 
				
			}
			switch ($this->plugin_settings('payment_method'))
			{
				case "REAL-TIME":
					(($this->plugin_settings('test_mode') == 'Yes')? 
						$this->_host='https://www.eway.com.au/gateway/xmltest/testpage.asp': 
						$this->_host='https://www.eway.com.au/gateway/xmlpayment.asp');
						break;
				case "REAL-TIME-CVN":
					(($this->plugin_settings('test_mode') == 'Yes')? 
						$this->_host='https://www.eway.com.au/gateway_cvn/xmltest/testpage.asp': 
						$this->_host='https://www.eway.com.au/gateway_cvn/xmlpayment.asp');
						break;
				case "GEO-IP-ANTI-FRAUD":
					(($this->plugin_settings('test_mode') == 'Yes')? 
						$this->_host='https://www.eway.com.au/gateway_beagle/test/xmlbeagle_test.asp':
						$this->_host='https://www.eway.com.au/gateway_beagle/xmlbeagle.asp');
						break;
				default: 
					$this->_host = 'https://www.eway.com.au/gateway/xmltest/testpage.asp';
					break;
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
			global $LANG;

			if ($this->plugin_settings['test_mode']== "Yes")
			{
				$credit_card_number = "4444333322221111";
				$total = 10; 
			}
			// eWay processes with no decimal values. 
			$total = round($total*100); 

			$post_array = array(
				'ewayTotalAmount'					=> $total,
				'ewayCustomerLastName'				=> $customer_info['last_name'],	
				'ewayCustomerFirstName'				=> $customer_info['first_name'],
				'ewayCustomerEmail'					=> $customer_info['email_address'],
				'ewayCustomerAddress'				=> $customer_info['address']." ".$customer_info['address2'] ." ". $customer_info['city'],	
				'ewayCustomerPostcode'				=> $customer_info['zip'],	
				'ewayCustomerInvoiceDescription'	=> $customer_info['description'],				
				'ewayCustomerInvoiceRef'			=> uniqid(rand(),true), 		
				'ewayCardHoldersName'				=> $customer_info['first_name']." ".$customer_info['last_name'],	
				'ewayCardNumber'					=> $credit_card_number,
				'ewayCardExpiryMonth'				=> str_pad($customer_info['expiration_month'], 2, '0', STR_PAD_LEFT), 
				'ewayCardExpiryYear'				=> $customer_info['expiration_year'], 	
				'ewayTrxnNumber'					=> "",
				'ewayOption1'					    => "",
				'ewayOption2'					    => "",
				'ewayOption3'					    => "",
			);
			$data = "<ewaygateway><ewayCustomerID>" . $this->_customer_id  . "</ewayCustomerID>";
			foreach($post_array as $key=>$value)
			{
				$data .= "<{$key}>{$value}</{$key}>";
			}
			$data .= "</ewaygateway>";

			$resp['authorized']					=	FALSE;
			$resp['error_message']				=	NULL;
			$resp['failed']						=	TRUE;
			$resp['declined']					=	FALSE;
			$resp['transaction_id'] 			=	NULL;

			$connect = 	$this->curl_transaction($this->_host,$data); 

			if (!$connect)
			{
				$resp['failed']	 				= 	TRUE; 
				$resp['authorized']				=	FALSE;
				$resp['declined']				=	FALSE;
				$resp['error_message']			=	$LANG->line('eway_cant_connect');
				return $resp; 
			}
			$transaction = $this->xml_to_array($connect,'basic'); 
			
			$error = NULL; 
			if (!empty($transaction['ewayResponse']['ewayTrxnStatus']['data']))
			{
				if(strtolower($transaction['ewayResponse']['ewayTrxnStatus']['data'])=="false")
			  	{
					if (!empty($transaction['ewayResponse']['ewayTrxnStatus']['data']))
					{
						$error = $transaction['ewayResponse']['ewayTrxnError']['data'];
					}
					$resp['declined'] 				= TRUE;
					$resp['failed']					= FALSE;
					$resp['error_message'] 			= $LANG->line('eway_transaction_error'). " ". $error;

				}
				elseif(strtolower($transaction['ewayResponse']['ewayTrxnStatus']['data'])=="true")
				{
					$resp['declined']		   		 = FALSE;
					$resp['failed']			   		 = FALSE; 
					$resp['authorized']		   		 = TRUE;
					$resp['error_message']	   		 = NULL;
					$resp['transaction_id']    		 = (!empty($transaction['ewayResponse']['ewayTrxnNumber']['data']) ? $transaction['ewayResponse']['ewayTrxnNumber']['data'] : NULL);
				}
				else
				{
					$resp['authorized']				= FALSE;
					$resp['declined']				= FALSE;
					$resp['failed']					= TRUE;
					$resp['error_message'] 			= $LANG->line('eway_invalid_response');
				}
			}			

			return $resp; 
		}
		// END
	}
	// END CLASS
}
/* End of file cartthrob.eway.php */
/* Location: ./system/modules/payment_gateways/cartthrob.eway.php */