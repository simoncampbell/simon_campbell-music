<?php
// BASIC SAMPLE TEMPLATE FOR GENERATING PAYMENT PLUGINS.
global $LANG;

$gateway_info = array(
	'title' => $LANG->line('dev_template_title'),
	'classname' => 'Cartthrob_dev_template',
	'affiliate' => $LANG->line('dev_template_affiliate'), 
	'overview' => $LANG->line('dev_template_overview'),
	// THESE SETTINGS WILL GENERATE THE INPUT FIELDS ON THE PAYMENT CONFIGURE SCREEN
	'settings' => array(
		array(
			'name' => $LANG->line('dev_template_settings_example'), // descriptive name
			'short_name' => 'settings_example', // you will use this to access this setting your code.
			'type' => 'text', // or radio
			'default' => 'Whatevs', // optional
		),
	),
	// These fields will be required in the checkout form when a payment is submitted to this gateway
	'required_fields' => array(
		'first_name',
		'last_name',
	),
	// This is your suggested sample HTML to be used for the checkout form fields
	// We suggest using fieldsets to separate groups (billing, shipping, info, payment_info, etc)
	// We suggest adding "class='required'" for required fields
	// Keep these forms as simple as possible, and semantically correct
	'html' => '
		<h1>Developer Testing Gateway. Do not use on live site</h1>
		<p>Checkout will randomly succeed and fail for testing purposes.</p>
		<fieldset class="billing" id="billing">
		<legend>Billing info</legend>
			<p>
				<label for="first_name" class="required" >First Name</label>
				<input type="text" id="first_name" name="first_name" value="" />
			</p>
			<p>
				<label for="last_name" class="required" >Last Name</label>
				<input type="text" id="last_name" name="last_name" value="" />
			</p>
		</fieldset>
	',
);
/* AVAILABLE CUSTOMER FIELDS
 * If your required customer field is not in this list, it will not be processed. 
 * Please contact the CartThrob development team at http://cartthrob.com, to have additional fields added. 

'first_name',
'last_name',
'address',
'address2',
'city',
'state',
'zip',
'description',
'company',
'phone',
'email_address',
'shipping_first_name',
'shipping_last_name',
'shipping_address',
'shipping_address2',
'shipping_city',
'shipping_state',
'shipping_zip',
'expiration_month',
'expiration_year',
'begin_month',
'begin_year',
'bday_month',
'bday_day',
'bday_year',
'CVV2',
'card_code',
'issue_number',
'card_type',
'currency_code',
'country_code',
'shipping_option',
'credit_card_number'

*/
if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_dev_template extends Cartthrob_payment_gateway
	{
		// INITIALIZATION FUNCTION IS REQUIRED
		function Cartthrob_dev_template()
		{
			// MINIMUM REQUIRED CODE
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
			// access your settings like this: 
			$this->_settings_example = $this->plugin_settings('settings_example'); 
			
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
			// DO PAYMENT STUFF
			/* 
			helper functions
			// converts an array to a urlencoded string of name / value pairs.
			$data = 	$this->data_array_to_string($array);
			* 
			// connects to curl. pass in the curl server url, and a url encoded data string... whatever data is required by whoever you're sending it to
			$connect = 	$this->curl_transaction($curl_server,$data);
			* 
			// Splits a URL encoded string of name / value pairs into an array.
			$transaction =  $this->split_url_string($connect);
			* 
			// converts XML to an array. 
			$transaction = $this->convert_response_xml($connect);
			* 
			// for 3-d secure and other offsite payment gateways, you'll want to use this. 
			$redirect_url = $this->_get_notify_url(ucfirst(get_class($this)), 'my_return_processing_method_name' );
			*/
			
			// THESE ARRAY KEYS WILL USE DEFAULTS IF NOT SET. THEY ARE USED TO DISPLAY MESSAGING IN TEMPLATES & TO PASS DATA TO THE ORDERS BLOG
			// IF THIS IS NOT BLANK, TRANS IS GOOD; DECLINED & FAILED BELOW ARE IGNORED

			$random_responses = $this->_random_response(); 
			$resp['authorized'] = $random_responses['bool1'];

			// OTHERWISE THE PLUGIN WILL REDIRECT BASED ON THE FOLLOWING CONDITIONS (in this order)
			$resp['declined']		=	 $random_responses['bool2'];
			// A FAILED RESPONSE MEANS THAT THE REASON USUALLY HAS TO DO WITH THE GATEWAY EXPERIENCING A PROBLEM
			$resp['failed']			=	 $random_responses['bool3'];
			// THIS ERROR MESSAGE CAN BE DISPLAYED IN THE TEMPLATE AS NECESSARY
			$resp['error_message']	=	$random_responses['error_message'];
			
			// THE TRANS ID (if available) IF NO TRANSID IS RETURNED A TIME STAMP IS USED. 
			$resp['transaction_id']	=	$random_responses['transaction_id'];
			//var_dump($random_responses);var_dump($resp); exit();
			
			return $resp;
		}
		/**
		 * _random_response
		 *
		 * this generates random booleans, error_messages, and transaction ids for testing purposes. 
		 * do not use this function with a real payment gateway.
		 * 
		 * @return array
		 * @since 1.0.0
		 * @author Chris Newton
		 */
		function _random_response()
		{
			global $LANG;
			
			$return_data=array();

			$bools_array = array(TRUE,FALSE);
			$errors_array= array(
				$LANG->line('dev_template_error_1'),
				$LANG->line('dev_template_error_2'),
				$LANG->line('dev_template_error_3'),
				$LANG->line('dev_template_error_4'),
			);
			
			$ids_array = array(rand(10000000,99999999),rand(10000000,99999999));
			
			$return_data['bool1'] = $bools_array[array_rand($bools_array)];
			$return_data['bool2'] = $bools_array[array_rand($bools_array)];
			
			if ($return_data['bool1'])
			{
				$return_data['bool3'] = FALSE;
			}
			else
			{
				$return_data['bool3'] = TRUE;
				
			}
			
			$return_data['transaction_id'] =$ids_array[array_rand($ids_array)];
			$return_data['error_message'] = $errors_array[array_rand($errors_array)];
			return $return_data; 
		}
		// END 
	}// END CLASS
}

/* End of file cartthrob.dev_template.php */
/* Location: ./system/modules/payment_gateways/cartthrob.dev_template.php */