<?php

$plugin_info = array(
	'title' => 'CALCULATED By Location - Quantity Threshold',
	'classname' => 'Cartthrob_by_location_quantity_threshold',
	'note' => 'Costs are set at quantity intervals for each location.',
	'settings' => array(
		array(
			'name' => 'Set shipping cost by: ',
			'short_name' => 'mode',
			'default' => 'rate',
			'type' => 'radio',
			'options' => array(
				'price' => 'Rate amount',
				'rate' => 'Rate amount * cart total'
			)
		),
		array(
			'name'	=> 'Shipping is free at: ',
			'short_name'	=> 'free_shipping',
			'type'			=> 'text'
		),
		array(
			'name' => 'Location Field: ',
			'short_name' => 'location_field',
			'type' => 'select',
			'default'	=> 'shipping_country_code',
			'options' => array(
				'zip' => 'Zip',
				'state'	=> 'State', 
				'region' => 'Region',
				'country_code' => 'Country Code',
				'shipping_zip' => 'Shipping Zip',
				'shipping_state' => 'Shipping State',
				'shipping_region' => 'Shipping Region', 
				'shipping_country_code' => 'Shipping Country Code'
			)
		),
		array(
			'name' => 'Backup Location Field: ',
			'short_name' => 'backup_location_field',
			'type' => 'select',
			'default'	=> 'country_code',
			'options' => array(
				'zip' => 'Zip',
				'state'	=> 'State', 
				'region' => 'Region',
				'country_code' => 'Country Code',
				'shipping_zip' => 'Shipping Zip',
				'shipping_state' => 'Shipping State',
				'shipping_region' => 'Shipping Region', 
				'shipping_country_code' => 'Shipping Country Code'
			)
		),
		array(
			'name' => 'Thresholds',
			'short_name' => 'thresholds',
			'type' => 'matrix',
			'settings' => array(
				array(
					'name'			=>	'Location: (separate multiple locations with a comma)<br />Use GLOBAL to set defaults',
					'short_name'	=>	'location',
					'type'			=>	'text',	
				),
				array(
					'name' => 'Rate',
					'short_name' => 'rate',
					'note' => '(ex: $10.95 would be entered as: <span class="red">10.95</span>)',
					'type' => 'text'
				),
				array(
					'name' => 'Quantity Threshold',
					'short_name' => 'threshold',
					'note' => '(ex: 0-10 items would be entered as: <span class="red">10</span>)',
					'type' => 'text'
				)
			)
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_by_location_quantity_threshold extends Cartthrob_shipping_plugin
	{

		function Cartthrob_by_location_quantity_threshold()
		{
			$this->Cartthrob_shipping_plugin();
		}
	
		function get_shipping()
		{
			if (count($this->_get_shippable_items()) == 0)
			{
				return 0;
			}
			
			if (isset($this->plugin_settings['free_shipping']) && $this->plugin_settings['free_shipping'] !== '' && $subtotal > $this->plugin_settings['free_shipping'])
			{
				return 0; 
			}
			
			return $this->_get_shipping_from_location_thresholds($this->total_items_count(), $this->_calculate_shippable_subtotal());
		}
		
		function _get_shipping_from_location_thresholds($compare, $multiplier = FALSE)
		{
			if ($multiplier === FALSE)
			{
				$multiplier = $compare;
			}
			
			$priced = FALSE;
			
			$default_rate = FALSE;
			
			$max_threshold = 0;
			
			$global = array();
			
			$shipping = 0;
		
			$customer_info 	= $this->_get_customer_info(NULL, FALSE);
			
			$location = '';
			
			$location_field = ( ! empty($this->plugin_settings['location_field'])) ? $this->plugin_settings['location_field'] : 'country_code';
			
			if ( ! empty($customer_info[$location_field]))
			{
				$location = $customer_info[$location_field];
			}
			else if ( ! empty($this->plugin_settings['backup_location_field']) && ! empty($customer_info[$this->plugin_settings['backup_location_field']]))
			{
				$location = $customer_info[$this->plugin_settings['backup_location_field']];
			}
			
			foreach ($this->plugin_settings['thresholds'] as $threshold_setting)
			{
				$location_array	= preg_split('/\s*,\s*/', trim($threshold_setting['location']));

				array_walk($location_array, array($this, 'trim_value'));
				
				if (in_array('GLOBAL', $location_array)) 
				{
					$global[$threshold_setting['threshold']] = $threshold_setting['rate'];
				}

				if (in_array($location, $location_array))
				{
					if ($priced === TRUE)
					{
						if ($compare <= $threshold_setting['threshold'] && $threshold_setting['threshold'] < $max_threshold)
						{
							$shipping = ($this->plugin_settings['mode'] == 'rate') ? $multiplier * $threshold_setting['rate'] : $threshold_setting['rate'];
							$max_threshold = $threshold_setting['threshold'];
						}
						continue;
					}
					
					if ($compare <= $threshold_setting['threshold'])
					{
						$shipping = ($this->plugin_settings['mode'] == 'rate') ? $multiplier * $threshold_setting['rate'] : $threshold_setting['rate'];
						$max_threshold = $threshold_setting['threshold'];
						$priced = TRUE;
					}
					
					if ($threshold_setting['threshold'] > $max_threshold)
					{
						$max_threshold = $threshold_setting['threshold'];
						$default_rate = $threshold_setting['rate'];
					}
				}
			}

			if ( ! $priced && $default_rate === FALSE)
			{
				foreach ($global as $threshold => $rate)
				{
					if ($priced === TRUE)
					{
						if ($threshold < $max_threshold)
						{
							$shipping = ($this->plugin_settings['mode'] == 'rate') ? $multiplier * $rate : $rate;
							$max_threshold = $threshold;
						}
						continue;
					}
					
					if ($compare <= $threshold)
					{
						$shipping = ($this->plugin_settings['mode'] == 'rate') ? $multiplier * $rate : $rate;
						$max_threshold = $threshold;
						$priced = TRUE;
					}
					
					if ($threshold > $max_threshold)
					{
						$max_threshold = $threshold;
						$default_rate = $rate;
					}
				}
			}

			if ( ! $priced)
			{
				$shipping = ($this->plugin_settings['mode'] == 'rate') ? $multiplier * $default_rate : $default_rate;
			}
			
			return $shipping;
		}
		
		function trim_value(&$value) 
		{ 
		    $value = trim($value); 
		}
		
		//invalid for this plugin
		function get_product_shipping($entry_id)
		{
			return 0;
		}

	}
}
/* End of file cartthrob.by_location_quantity_threshold.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.by_location_quantity_threshold.php */