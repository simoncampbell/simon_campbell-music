<?php

$plugin_info = array(
	'title' => 'Percentage Off',
	'classname' => 'Cartthrob_percentage_off',
	'type' => 'percentage_off',
	'settings' => array(
		array(
			'name' => 'Percentage Off',
			'short_name' => 'percentage_off',
			'note' => 'Enter the percentage to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_percentage_off extends Cartthrob_coupon_code_plugin
	{
		function Cartthrob_percentage_off()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount_label($coupon_code, $coupon_code_data = NULL)
		{
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			return $this->_sanitize_number($coupon_code_data['percentage_off']).'%';
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = NULL)
		{
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			$percentage_off = $this->_sanitize_number($coupon_code_data['percentage_off']);
			
			return $subtotal * ($percentage_off / 100);
		}
	}
}

/* End of file cartthrob.percentage_off.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.percentage_off.php */