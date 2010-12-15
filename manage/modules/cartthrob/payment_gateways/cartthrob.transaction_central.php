<?php
global $LANG; 

$gateway_info = array(
	'title' => $LANG->line('trans_central_title'),
	
	'classname' => 'Cartthrob_transaction_central',
	
	'overview' => $LANG->line('trans_central_overview'),
	
	'settings' => array(
		array(
			'name' => $LANG->line('trans_central_merchant_id'),
			'short_name' => 'merchant_id',
			'type' => 'text'
		),
		array(
			'name' =>  $LANG->line('trans_central_reg_key'),
			'short_name' => 'reg_key',
			'type' => 'text'
		),
		array(
			'name' => $LANG->line('test_mode'),
			'short_name' => 'test_mode',
			'type' => 'radio'
		),
		array(
			'name' => $LANG->line('trans_central_tax_type'),
			'short_name' => 'tax_type',
			'type' => 'radio',
			
			'options' => array(
				'Non Taxable' 	=> $LANG->line('non_taxable'), 
				'Taxable' 		=> $LANG->line('taxable'),
				'Tax Exempt' 	=> $LANG->line('tax_exempt'),
			),
			
		),
		array(
			'name' => $LANG->line('trans_central_charge_url'),
			'short_name' => 'charge_url',
			'type' => 'text',
			'default' => 'https://webservices.primerchants.com/creditcard.asmx/CCSale?',
		),
	), 
	
	'required_fields' => array(
		'first_name',
		'last_name',
		'address',
		'city',
		'state',
		'zip',
		'CVV2',
		'credit_card_number',
		'expiration_year',
		'expiration_month',
	),
	
	'html' => '
		<fieldset class="billing" id="billing_info">
			<legend>Billing Info</legend>
			<p>
				<label for="first_name" class="required" >First Name</label>
				<input type="text" id="first_name" name="first_name" value="" />
			</p>
			<p>
				<label for="last_name" class="required" >Last Name</label>
				<input type="text" name="last_name" value="" id="last_name" />
			</p>
			<p>
				<label for="address" class="required" >Street Address</label>
				<input type="text" name="address" value="" id="address"/>
			</p>
			<p>
				<label for="address2" >Street Address</label>
				<input type="text" name="address2" value="" id="address2"/>
			</p>
			<p>
				<label for="city" class="required" >City</label>
				<input type="text" name="city" value="" id="city"/>
			</p>
			<p>
				<label for="state" class="required" >State</label>
				<input type="text" name="state" value="" id="state"/>
			</p>
			<p>
				<label for="zip" class="required" >Zip Code</label>
				<input type="text" name="zip" value="" id="zip"/>
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
			<p>
				<label for="po_number">PO Number (required for some corporate card transactions)</label>
				<input type="text" id="po_number" name="po_number" value="" />
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
		</fieldset>',
	
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_transaction_central extends Cartthrob_payment_gateway
	{
	
		function Cartthrob_transaction_central()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
		}
		
		function _process_payment($total, $credit_card_number, $customer_info, $order_id='')
		{
			global $LANG;
			global $SESS, $PREFS;
			// *************** CONFIG (Config this if you don't want to use values set above)******************
			$MerchantID		= $this->plugin_settings['merchant_id'];		// * Number (8): 			Merchant Number assigned by TransFirst
			$RegKey			= $this->plugin_settings['reg_key']; 			// * Text (16): 			TransFirst Security Key
			
			switch ($this->plugin_settings['tax_type'])
			{
				case "Non Taxable": 
					$TaxIndicator ="0";
					break;
				case "Taxable": 
					$TaxIndicator ="1";
					break; 
				case "Tax Exempt":
					$TaxIndicator ="2";
					break;
				default:
					$TaxIndicator ="0";
			}
		
			$post_array = array(
				'MerchantID'	=> $MerchantID,
				'RegKey'		=> $RegKey,
				'Amount'		=> $total,
				'CardNumber'	=> $credit_card_number,
				'CardHolderName'=> $customer_info['first_name'] . " ". $customer_info['last_name'], 
				'Expiration'	=> str_pad($customer_info['expiration_month'], 2, '0', STR_PAD_LEFT) .  str_pad($customer_info['expiration_year'], 2, '0', STR_PAD_LEFT),
				'CVV2'			=> $customer_info['CVV2'],
				'Address'		=> $customer_info['address'] ." ". $customer_info['address2'] .' '. $customer_info['city'] .' '.$customer_info['state'],
				'ZipCode'		=> $customer_info['zip'],
				'RefID'			=> $SESS->userdata['member_id'],
				'SaleTaxAmount'	=> $this->cart_tax(),
				'PONumber'		=> $customer_info['po_number'],
				'TaxIndicator'	=> $TaxIndicator,
			);
			reset($post_array);
			
			$data 		= 	$this->data_array_to_string($post_array);
			$connect 	= 	$this->curl_transaction($this->plugin_settings['charge_url'],$data);
			$parsed		=	$this->convert_response_xml($connect);
			
			if (!empty($parsed['Status']))
			{
				switch (strtolower($parsed['Status']))
				{
					case "authorized":
						$resp['authorized']	= TRUE;
						$resp['transaction_id']	=	$parsed["TransactionIdentifier"];
						break;
					case "declined": 
					case "canceled": 
						$resp['authorized'] 	= FALSE;
						$resp['declined']		= TRUE;
						$resp['failed']			= FALSE;
						$resp['error_message'] = @$parsed["Message"];
						break;
					default:
						$resp['authorized'] 	= FALSE;
						$resp['declined']		= TRUE;
						$resp['failed']			= FALSE;
						$resp['error_message'] 	= $LANG->line('trans_central_unexpected');
						break;
				}
			}
			else
			{
				$resp['authorized'] 	= FALSE;
				$resp['declined']		= FALSE;
				$resp['failed']			= TRUE;
				$resp['error_message'] 	= $LANG->line('trans_central_no_response');
			}
			return $resp;
		} 
		// END
	} // END CLASS
}
/* End of file cartthrob.transaction_central.php */
/* Location: ./system/modules/payment_gateways/cartthrob.transaction_central.php */