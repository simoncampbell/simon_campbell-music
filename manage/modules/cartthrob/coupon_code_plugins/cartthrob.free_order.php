<?php

$plugin_info = array(
	'title' => 'Free Order',
	'classname' => 'Cartthrob_free_order',
	'type' => 'free_order',
	'settings' => array()
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_free_order extends Cartthrob_coupon_code_plugin
	{
		function Cartthrob_free_order()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = NULL)
		{
			return $subtotal + $shipping;
		}
	
	}
}

/* End of file cartthrob.free_order.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.free_order.php */