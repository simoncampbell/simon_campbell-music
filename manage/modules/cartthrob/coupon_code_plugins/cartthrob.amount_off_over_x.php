<?php

$plugin_info = array(
	'title' => 'Amount Off For Orders Over X',
	'classname' => 'Cartthrob_amount_off_over_x',
	'type' => 'amount_off_over_x',
	'settings' => array(
		array(
			'name' => 'Amount Off',
			'short_name' => 'amount_off',
			'note' => 'Enter the amount to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		),
		array(
			'name' => 'If Order Over',
			'short_name' => 'order_over',
			'note' => 'Enter the required order minimum. NUMERIC VALUES ONLY.',
			'type' => 'text'
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_amount_off_over_x extends Cartthrob_coupon_code_plugin
	{
	
		function Cartthrob_amount_off_over_x()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = FALSE)
		{
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			if ($subtotal >= $this->_sanitize_number($coupon_code_data['order_over']))
			{
				return $this->_sanitize_number($coupon_code_data['amount_off']);
				
			}
			
			return NULL; 
		}
	
	}
}

/* End of file cartthrob.amount_off_over_x.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.amount_off_over_x.php */