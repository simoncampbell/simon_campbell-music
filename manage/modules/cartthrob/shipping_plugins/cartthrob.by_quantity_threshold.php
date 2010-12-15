<?php

$plugin_info = array(
	'title' => 'CALCULATED By Quantity - Threshold',
	'classname' => 'Cartthrob_by_quantity_threshold',
	'note' => 'Costs are set at quantity intervals of ',
	'settings' => array(
		array(
			'name' => 'Calculate costs',
			'short_name' => 'mode',
			'type' => 'radio',
			'options' => array(
				'price' => 'Use rate as shipping cost',
				'rate' => 'Multiply rate by quantity'
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
					'name' => 'Quantity Threshold',
					'short_name' => 'threshold',
					'type' => 'text'
				)
			)
		)
	)
);
if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_by_quantity_threshold extends Cartthrob_shipping_plugin
	{

		function Cartthrob_by_quantity_threshold()
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

			$total_items = $this->total_items_count(); 
			
			$priced = FALSE;
		
			foreach ($this->thresholds as $threshold => $rate)
			{
				if ($total_items > $threshold)
				{
					continue;
				}
				else
				{
					$shipping = ($this->plugin_settings['mode'] == 'rate') ? $total_items * $rate : $rate;
				
					$priced = TRUE;
				
					break;
				}
			}
		
			if ( ! $priced)
			{
				$shipping = ($this->plugin_settings['mode'] == 'rate') ? $total_items * end($this->thresholds) : end($this->thresholds);
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
/* End of file cartthrob.by_quantity_threshold.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.by_quantity_threshold.php */