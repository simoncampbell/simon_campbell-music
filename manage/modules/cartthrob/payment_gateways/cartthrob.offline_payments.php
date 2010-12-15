<?php
global $LANG;

$gateway_info = array(
	'title' => $LANG->line('offline_title'),
	'classname' => 'Cartthrob_offline_payments',
	'overview' => $LANG->line('offline_overview'),
	'required_fields' => array(
		'first_name',
		'last_name',
	),
	'settings' => array(),

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
			<label for="zip" class="required" >Zip Code</label>
			<input type="text" id="zip" name="zip" value="" />
		</p>
	</fieldset>
	
	<fieldset class="information"  id="additional_info">
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
	</fieldset>',
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_offline_payments extends Cartthrob_payment_gateway
	{
		/**
		 * Cartthrob_offline_payments class 
		 *
		 * @package default
		 * @author Chris Newton
		 * @since 1.0.0
		 **/
		function Cartthrob_offline_payments()
		{
			$this->Cartthrob();

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
		function _process_payment($total=NULL, $credit_card_number=NULL, $customer_info, $order_id='')
		{		
			global $LANG;
			
			$resp['authorized']		=	TRUE;
			$resp['error_message']	=	"";
			$resp['failed']			=	FALSE;
			$resp['declined']		=	FALSE;
			$resp['transaction_id'] =	$LANG->line('offline_transaction_id');
			
			return $resp; 
		}
		// END
		
	}
	// END CLASS
}
/* End of file cartthrob.offline_payments.php */
/* Location: ./system/modules/payment_gateways/cartthrob.offline_payments.php */