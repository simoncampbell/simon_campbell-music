<?php

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}
class Cartthrob_default_payment_gateway extends Cartthrob_payment_gateway
{
	var $plugin_settings = array();
	
	function _process_payment($total, $credit_card_number, $customer_info, $order_id)
	{
		return array(
			'authorized' => TRUE,
			'failed' => FALSE,
			'declined' => FALSE,
			'error_message' => '',
			'transaction_id' => time()
		);
	}
}

/* End of file cartthrob_default_payment_gateway.class.php */
/* Location: ./system/modules/cartthrob/cartthrob_default_payment_gateway.class.php */