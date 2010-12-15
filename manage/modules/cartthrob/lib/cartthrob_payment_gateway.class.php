<?php

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}
class Cartthrob_payment_gateway extends Cartthrob
{
	var $plugin_settings = array();
	
	function plugin_settings($key, $default = FALSE)
	{
		return (isset($this->plugin_settings[$key])) ? $this->plugin_settings[$key] : $default;
	}
	/**
	 * gateway_order_update
	 *
	 * @param array $auth_array 
	 * @param string $order_id 
	 * @return void
	 * @author Chris Newton
	 * @since 1.0.0
	 */
	function gateway_order_update($auth_array,$order_id )
	{
		global $LANG;
		// setting defaults
		$default = array(
			'authorized' 	=> FALSE,
			'error_message'	=> NULL,
			'failed'		=> TRUE,
			'declined'		=> FALSE,
			'transaction_id'=> NULL, 
			);
		$auth = array_merge($default, $auth_array);
		
		$order_data = $this->_get_saved_order();
		$order_data['auth'] = $auth;
		$this->_save_order_to_session($order_data);
		
		
		if ($auth['authorized'])
		{
			$update_data = array(
				'status' => $this->get_default_order_status(),
				'transaction_id' => $auth['transaction_id']
			);
			if ($this->_save_orders)
			{
				$this->_update_order($order_id, $update_data);
			}
			
			$this->_update_purchased_items($order_id,  $this->settings['purchased_items_default_status'] ); 
		}
		elseif($auth['declined'])
		{
			if ($this->_save_orders)
			{
				$status = ($this->settings['orders_declined_status']) ? $this->settings['orders_declined_status'] : 'closed';
				$this->_update_order($order_id, array('error_message' => 'DECLINED: '.@$auth['error_message'], 'status' => $status));
			}
			$this->_update_purchased_items($order_id, $this->settings['purchased_items_declined_status']  ); 
			
			$this->_on_decline();
		}
		elseif ($auth['failed'])
		{
			if ($this->_save_orders)
			{
				$status = ($this->settings['orders_failed_status']) ? $this->settings['orders_failed_status'] : 'closed';
				$this->_update_order($order_id, array('error_message' => 'FAILED: '.@$auth['error_message'], 'status' => $status ));
			}
			$this->_update_purchased_items($order_id, $this->settings['purchased_items_failed_status']  ); 
			
			$this->_on_fail();
		}
		else
		{
			if ($this->_save_orders)
			{
				$this->_update_order($order_id, array('error_message' => 'FAILED: Unknown failure'));
			}
			
			$this->_update_purchased_items($order_id, $this->settings['purchased_items_failed_status']  ); 
			
			$this->_on_fail();
		}

	}
	
	function get_default_order_status()
	{
		
		if (!empty(	$this->_orders_default_status))
		{
			return 	$this->_orders_default_status;
		}
		else
		{
			return "open";
		}
		
	}
	function get_default_purchased_items_status()
	{
		if (!empty(	$this->_purchased_items_default_status))
		{
			return 	$this->_purchased_items_default_status;
		}
		else
		{
			return "open";
		}
	}
	// END
	/**
	 * gateway_cleanup_after_redirect
	 *
	 * processes inventory and coupons, updates session order data and sends emails. 
	 * @param string $auth_array 
	 * @param string $return_url 
	 * @return void
	 * @author Chris Newton
	 */
	function return_processing($auth_array, $return_url = NULL)
	{
		global $IN, $LANG; 
		// setting defaults
		$default = array(
			'authorized' 	=> FALSE,
			'error_message'	=> NULL,
			'failed'		=> TRUE,
			'declined'		=> FALSE,
			'transaction_id'=> NULL, 
			);
		$auth = array_merge($default, $auth_array);
		
		$this->_process_coupon_codes();

		$this->_process_inventory();

		// update order data in session
		$order_data = $this->_get_saved_order();
		$order_data['auth'] = $auth;
		$this->_save_order_to_session($order_data);
		$this->_on_authorize($order_data);

		// send emails
		if ($this->settings['send_confirmation_email'])
		{
			if($auth['authorized'])
			{
				$customer_info = $this->_get_customer_info();
				$this->_send_confirmation_email($customer_info['email_address'], $order_data);
			}
		}
		if ($this->settings['send_email'])
		{
			if($auth['authorized'])
			{
				$this->_send_admin_notification_email($order_data);
			}
		}

		$this->clear_cart(FALSE);

		$this->_clear_security_hash();

		$this->_clear_coupon_codes();
		
		if ($return_url)
		{
			$this->_redirect($return_url);
			exit; 
		}
		else
		{
			return NULL; 
			exit; 
		}
	}
	/**
	 * gateway_exit_offsite
	 *
	 * sends a customer offsite to finish a payment transaction
	 * 
	 * @param array $post_array 
	 * @param string $url 
	 * @return void
	 * @author Chris Newton 
	 * @since 1.0
	 * @access public 
	 */
	function gateway_exit_offsite($post_array=NULL, $url)
	{
		$this->_save_purchased_items(); 
		
		if ($post_array)
		{
			$data	= 	$this->data_array_to_string($post_array);
			$url	.= 	'?'.$data;	
		}
								
		header("Location: $url");

		exit;
	}
	
	/**
	 * update_customer_info
	 *
	 * send an array with keys that correspond to CT standard fields, and the update data as the values, and this will update the database 
	 * @param array $data_array 
	 * @return void
	 * @author Chris Newton
	 */
	function update_customer_info($data_array, $order_id)
	{
		global $DB; 
		
		$exp_weblog_data = array(); 
		
		foreach ($data_array as $key=> $item)
		{
			if ($item !="" && !empty($this->settings[$key]))
			{
				$exp_weblog_data[$this->_get_field_id($this->settings[$key], 'field_id')] = $item;
			}
		}
		
		if (count($exp_weblog_data))
		{
			$DB->query($DB->update_string('exp_weblog_data', $exp_weblog_data, array('entry_id' => $order_id)));
		}
		
		return NULL; 
		
	}
	// END
}
// END CLASS
/* End of file cartthrob_payment_gateway.class.php */
/* Location: ./system/modules/cartthrob/cartthrob_payment_gateway.class.php */