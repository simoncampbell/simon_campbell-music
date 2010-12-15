<?php

$plugin_info = array(
	'title' => 'Amount Off',
	'classname' => 'Cartthrob_amount_off',
	'type' => 'amount_off',
	'settings' => array(
		array(
			'name' => 'Amount Off',
			'short_name' => 'amount_off',
			'note' => 'Enter the amount to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_amount_off extends Cartthrob_coupon_code_plugin
	{
	
		function Cartthrob_amount_off()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = FALSE)
		{
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
		
			return $this->_sanitize_number($coupon_code_data['amount_off']);
		}
	
	}
}

/* End of file cartthrob.amount_off.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.amount_off.php */