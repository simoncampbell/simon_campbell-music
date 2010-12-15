<?php
global $LANG;

$plugin_info = array(
	'title' => 'CALCULATED By Weight - Global Rate',
	'classname' => 'Cartthrob_by_weight_global_rate',
	'note' => 'Costs are charged by weight, so products must be assigned a weight.',
	'settings' => array(
		array(
			'name' => 'Rate (ex: $10.95/lb. would be entered as: <span class="red">10.95</span>)',
			'short_name' => 'rate',
			'type' => 'text'
		)
	)
);
if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_by_weight_global_rate extends Cartthrob_shipping_plugin
	{

		function Cartthrob_by_weight_global_rate()
		{
			$this->Cartthrob();
		
			$this->plugin_settings = $this->settings[get_class($this).'_settings'];
		}
	
		function get_shipping()
		{
			$this->_session_start();
		
			$shipping = 0;
		
			$weight = $this->shipping_weight_total();
	
			$shipping = $weight * $this->plugin_settings['rate'];
		
			return $shipping;
		}
	
		//only works in factor mode
		function get_product_shipping($entry_id)
		{
		
			return $this->_get_item_weight($entry_id) * $this->plugin_settings['rate'];
		}

	}
}
/* End of file cartthrob.by_weight_global_rate.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.by_weight_global_rate.php */