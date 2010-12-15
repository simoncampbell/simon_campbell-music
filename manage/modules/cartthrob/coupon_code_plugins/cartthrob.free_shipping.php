<?php

$plugin_info = array(
	'title' => 'Free Shipping',
	'classname' => 'Cartthrob_free_shipping',
	'type' => 'free_shipping',
	'settings' => array()
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_free_shipping extends Cartthrob_coupon_code_plugin
	{
		function Cartthrob_free_shipping()
		{
			$this->Cartthrob(FALSE);
		}

		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = NULL)
		{
			return $shipping;
		}
	}
}

/* End of file cartthrob.free_shipping.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.free_shipping.php */