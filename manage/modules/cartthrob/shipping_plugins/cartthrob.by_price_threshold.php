<?php

$plugin_info = array(
	'title' => 'CALCULATED By Price - Threshold',
	'classname' => 'Cartthrob_by_price_threshold',
	'note' => 'Costs are set at price intervals ',
	'settings' => array(
		array(
			'name' => 'Set shipping cost by: ',
			'short_name' => 'mode',
			'type' => 'radio',
			'options' => array(
				'price' => 'Rate amount',
				'rate' => 'Rate amount * cart total'
			)
		),
		array(
			'name' => 'Thresholds',
			'short_name' => 'thresholds',
			'type' => 'matrix',
			'settings' => array(
				array(
					'name' => 'Rate',
					'short_name' => 'rate',
					'note' => '(ex: $10.95 would be entered as: <span class="red">10.95</span>)',
					'type' => 'text'
				),
				array(
					'name' => 'Price Threshold',
					'short_name' => 'threshold',
					'note' => '(ex: $0-$10 would be entered as: <span class="red">10</span>)',
					'type' => 'text'
				)
			)
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_by_price_threshold extends Cartthrob_shipping_plugin
	{

		function Cartthrob_by_price_threshold()
		{
			$this->Cartthrob_shipping_plugin();
		
			$this->thresholds = array();
		
			if ( ! empty($this->plugin_settings['thresholds']) && ! is_array($this->plugin_settings['thresholds']))
			{
				$threshold_input = $this->_textarea_to_array($this->plugin_settings['threshold']);
			
				foreach ($threshold_input as $threshold)
				{
					$threshold = explode(':', $threshold);
				
					if (count($threshold) > 1)
					{
						$this->thresholds[$threshold[0]] = $threshold[1];
					}
				}
			}
			else
			{
				foreach ($this->plugin_settings['thresholds'] as $threshold)
				{
					$this->thresholds[$threshold['threshold']] = $threshold['rate'];
				}
			}
			
			ksort($this->thresholds);
		}
	
		function get_shipping()
		{
			$this->_session_start();
		
			$shipping = 0;
		
			$price = $this->_calculate_shippable_subtotal();
	
			$priced = FALSE;
		
			foreach ($this->thresholds as $threshold => $rate)
			{
				if ($price > $threshold)
				{
					continue;
				}
				else
				{
					$shipping = ($this->plugin_settings['mode'] == 'rate') ? $price * $rate : $rate;
				
					$priced = TRUE;
				
					break;
				}
			}
		
			if ( ! $priced)
			{
				$shipping = ($this->plugin_settings['mode'] == 'rate') ? $price * end($this->thresholds) : end($this->thresholds);
			}
		
			return $shipping;
		}
	
		//invalid for this plugin
		function get_product_shipping($entry_id)
		{
			return 0;
		}

	}
}
/* End of file cartthrob.by_price_threshold.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.by_price_threshold.php */