<?php
global $LANG; 

$gateway_info = array(
	'title' => $LANG->line('worldpay_redirect_title'),
	'classname' => 'Cartthrob_worldpay_redirect',
	'language_file' => TRUE,
	
	'overview' => $LANG->line('worldpay_redirect_overview'), 
	'settings' => array(
		array(
			'name' =>  $LANG->line('worldpay_redirect_installation_id'), 
			'short_name' => 'installation_id', 
			'type' => 'text', 
			'default' => '', 
		),
		array(
			'name' =>  $LANG->line('test_mode'),
			'short_name' => 'test_mode',
			'type' => 'radio',
			'default' => 'Live',
			'options' => array(
				'Test' => $LANG->line('test'),
				'Live' => $LANG->line('live')
			)
		)
	),
	'required_fields' => array(
		'first_name',
		'last_name',
	),
	'html' => ''
);

if ( ! class_exists($gateway_info['classname']))
{
	class Cartthrob_worldpay_redirect extends Cartthrob_payment_gateway 
	{
		function Cartthrob_worldpay_redirect() 
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[get_class($this).'_settings'];
			
			$this->_submit_url		 	= 'https://secure-test.wp3.rbsworldpay.com/wcc/purchase';
			$this->_test_mode 			= 100;
			
			if($this->plugin_settings['test_mode'] == 'Live') 
			{
				$this->_submit_url 		= 'https://secure.wp3.rbsworldpay.com/wcc/purchase';
				$this->_test_mode 		= 0;
			}
		}
		
		/*
		 * _process_payment function
		 *
		 * @param string $total the total amount of the purchase
		 * @param string $credit_card_number purchaser's credit cart number
		 * @param array $customer_info array containing $_POST fields captured by the checkout form
		 * @access private
		 * @return array $resp an array containing the following keys: 
		 */
		function _process_payment($total, $credit_card_number, $customer_info, $order_id='') {

			$post_array = array(
				'name'				=> $customer_info['first_name'].' '.$customer_info['last_name'],
				'address'			=> $customer_info['address']."\n"
										.$customer_info['address2']
										."\n".$customer_info['city']
										."\n".$customer_info['state'],
				'postcode'			=> $customer_info['zip'],
				'country'			=> $customer_info['country_code'],
				'tel'				=> $customer_info['phone'],
				'email'				=> $customer_info['email_address'],
				'withDelivery'		=> 'true',
				'delvName'			=> $customer_info['shipping_first_name'].' '
										.$customer_info['shipping_last_name'],
				'delvAddress'		=> 	$customer_info['shipping_address']
										."\n".$customer_info['shipping_address_2']
										."\n".$customer_info['shipping_city']
										."\n".$customer_info['shipping_state'],
				'delvPostcode' 		=> $customer_info['shipping_zip'],
				'delvCountry'		=> $customer_info['country_code'],
				
				'instId'			=> $this->plugin_settings('installation_id'),
				'cartId' 			=> $order_id,
				'currency' 			=> !empty($customer_info['currency_code']) ? $customer_info['currency_code'] : "USD" ,
				'amount'			=> $customer_info['total_cart'],
				'desc' 				=> $order_id,
				'testMode' 			=> $this->_test_mode,
				'fixContact'		=> 'true',
				'MC_callback'		=> $this->_get_notify_url(ucfirst(get_class($this)),'worldpay_success')					
			);

			$this->gateway_exit_offsite($post_array, $this->_submit_url); 
			exit;
		}

		/**
		 * worldpay_success
		 * 
		 * @param array $post 
		 * @return void
		 * @author Chris Newton
		 */		
		function worldpay_success($post) 
		{		
			global $OUT, $LANG, $PREFS; 
			
			if (empty($post['transId'])) 
			{
				$data = array('title'   => $LANG->line('transaction_failure'),
							  'heading'	=> $LANG->line('transaction_failure'),
							  'content'	=> $LANG->line('worldpay_transaction_failure'),
							  'link'    => array( $PREFS->core_ini['site_url'], $LANG->line('return_to_home'))
							  );

				return $OUT->show_message($data);
				exit;
			}
						
			if ($post['transStatus'] == 'Y') 
			{
				$auth_array = array(
					'authorized' 	=> TRUE,
					'error_message'	=> NULL,
					'failed'		=> FALSE,
					'declined'		=> FALSE,
					'transaction_id'=> $post['transId'], 
					);
				
				$this->gateway_order_update($auth_array, $post['cartId'] );
				$this->return_processing($auth_array, $return_url= NULL); 
				
			} 
			elseif ($post['transStatus'] == 'C') 
			{

				$auth_array = array(
					'authorized' 	=> FALSE,
					'error_message'	=> 'CANCELLED',
					'failed'		=> FALSE,
					'declined'		=> TRUE,
					'transaction_id'=> $post['transId'], 
					);
				
				$this->gateway_order_update($auth_array, $post['cartId'] );
			}
			exit;
		}
	}
}

/* End of file cartthrob.worldpay_redirect.php */
/* Location: ./system/extensions/payment_gateways/cartthrob.worldpay_redirect.php */