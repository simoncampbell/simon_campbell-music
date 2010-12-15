<?php
global $LANG;

$plugin_info = array(
	'title' => 'CALCULATED Per location rates',
	'classname' => 'Cartthrob_per_location_rates',
	'overview'	=> '<p>Per location rates allows you to set rates on an item by item, category, or custom field basis. </p>
					<p>At least one value must be set for COST, LOCATION and PRODUCT.</p>
					<p>If customer location is set and matches any location found in the Zip, State, and Country_code, or "GLOBAL" is
						set in any of these fields, products in the customers cart will be compared to entries set in the Entry_id, Category_id or Custom field.  
						You can separate multiple codes with a comma. For instance, "1,2,3" could be set in the entry_ids field, or "cd,vinyl" 
						could be set to match weblog content found in a "Package Type" weblog custom field. You must have a value set in one of the product fields for rates
						to be calculated. Use "GLOBAL" to make the setting apply to all entries</p>
					<p>If the "Default Cost Per Item" is set, even products not found in one of these settings will have this base shipping price applied.</p>',
	'settings' => array(
		array(
			'name'	=> 'Default Cost per Item',
			'short_name'	=> 'default_rate',
			'type'			=> 'text',
		),
		array(
			'name'	=> 'Shipping is free at',
			'short_name'	=> 'free_shipping',
			'type'			=> 'text',
		),
		array(
			'name'	=> 'Charge Default By',
			'short_name'	=> 'default_type',
			'type'			=> 'select',
			'options'		=> array(
				'flat'	=> "Flat Rate",
				'weight' => "Weight"
				),
		),
		array(
			'name' => 'Charge By: ',
			'short_name' => 'location_field',
			'type' => 'select',
			'default'	=> 'billing',
			'options' => array(
				'billing' => 'Billing Address',
				'shipping' => 'Shipping Address'
 			)
		),
 		array(
			'name'	=> 'Rates',
			'short_name'	=> 'rates',
			'type'			=> 'matrix',
			'settings'		=> array(
				array(
					'name' 			=> 'Cost',
					'short_name' 	=> 'rate',
					'type' 			=> 'text'
				),
				array(
					'name'			=> 'Type',
					'short_name'	=> 'type',
					'type'			=> 'select',
					'options'		=> array(
						'flat'	=> "Flat",
						'weight' => "By Weight"
						),
				),
				array(
					'name'			=>	'Location: <br />Zip/Regions',
					'short_name'	=>	'zip',
					'type'			=>	'text',	
				),
				array(	
					'name'			=> 'Location: <br />States', 
					'short_name'	=> 'state',
					'type'			=> 'text',
					//'type'			=> 'select',
					//'options'		=>  Cartthrob_ext::get_states()
				),
				array(	
					'name'			=> 'Location: <br />Countries', 
					'short_name'	=> 'country',
					'type'			=> 'text',
					//'type'			=> 'select',
					//'options'		=>  Cartthrob_ext::get_countries()
				),
				array(
					'name' 			=> 'Product: <br />Entry IDs',
					'short_name' 	=> 'entry_ids',
					'type' 			=> 'text'
				),
				array(
					'name' 			=> 'Product: <br />Cat IDs',
					'short_name' 	=> 'cat_ids',
					'type' 			=> 'text'
				),
				
				array(
					'name'			=> 'Product: <br />Weblog Content',
					'short_name'	=> 'field_value',
					'type'			=> 'text',
				),
				array(
					'name' 			=> '<br />In weblog field',
					'short_name' 	=> 'field_id',
					'type' 			=> 'select',
					'options'		=> class_exists('Cartthrob_ext') ? Cartthrob_ext::get_fields() : ""
				),
			),
		),
	)
);
if ( ! class_exists($plugin_info['classname']))
{

	class Cartthrob_per_location_rates extends Cartthrob_shipping_plugin
	{
		function Cartthrob_per_location_rates()
		{
			$this->Cartthrob();
		
			$this->plugin_settings = $this->settings[get_class($this).'_settings'];

			if (empty($this->plugin_settings['default_rate'] ))
			{
				$this->_default_rate = 0; 
			}
			else
			{
				$this->_default_rate = $this->plugin_settings['default_rate']; 
			}
		}
		// END
	
		function get_shipping()
		{
			$subtotal = $this->_calculate_shippable_subtotal();
			
			if (isset($this->plugin_settings['free_shipping']) && $this->plugin_settings['free_shipping'] !== '' && $subtotal > $this->plugin_settings['free_shipping'])
			{
				return 0; 
			}
			
			global $DB; 
			
			$customer_info 		= $this->_get_customer_info(NULL, $return_shipping = FALSE); 
			
			if ($this->plugin_settings['location_field'] == 'billing')
			{
				$primary_loc 	= "";
				$backup_loc		= "shipping_"; 
			}
			else
			{
				$primary_loc 	= "shipping_";
				$backup_loc		= "";	
			}

			$country 			=  (!empty($customer_info[$primary_loc.'country_code'])	? $customer_info[$primary_loc.'country_code'] : $customer_info[$backup_loc.'country_code']);
			$state	 			=  (!empty($customer_info[$primary_loc.'state'])		? $customer_info[$primary_loc.'state'] : $customer_info[$backup_loc.'state']);
			$zip				=  (!empty($customer_info[$primary_loc.'zip'])			? $customer_info[$primary_loc.'zip'] : $customer_info[$backup_loc.'zip']);
			
			$shipping = 0;
		
			// Get all items in cart
			foreach ($this->_get_items() as $row_id => $item)
			{
				if (empty($item['entry_id']))
				{
					break; 
				}
				// Get all settings
				$location_shipping = 0; 
				
				foreach ($this->plugin_settings['rates'] as $rate)
				{
					$locations['zip']		= explode(',',$rate['zip']);
					$locations['state']		= explode(',',$rate['state']);
					$locations['country']	= explode(',',$rate['country']);

					if ($rate['type'] == "weight")
					{
						$shipping_amount = $rate['rate'] * ($item['quantity'] * $this->_get_item_weight($item['entry_id']));
					}
					else
					{
						$shipping_amount = $rate['rate'] * $item['quantity']; 
					}
					
					if ($this->plugin_settings['default_type'] == "weight")
					{
						$default_amount = $this->_default_rate  * ($item['quantity'] * $this->_get_item_weight($item['entry_id']));
					}
					else
					{
						$default_amount = $this->_default_rate * $item['quantity']; 
					}
					
					// Make sure entry ids have been entered
					if (!empty($rate['entry_ids']))
					{
						// get list of entry ids
						$entry_ids = explode(',', $rate['entry_ids']);
					
						// check if item in cart is in this rate
						if (in_array('GLOBAL', $entry_ids) || in_array($item['entry_id'], $entry_ids) )
						{	
							$location_shipping += $this->_location_shipping($locations, $zip, $state, $country, $shipping_amount); 
							
							if ($location_shipping >0)
							{
								break; 
							}
							else
							{
								continue; 
							}
						}
						// if item isnt in this rate line, skip it
						else
						{
							continue;
						}
					}
					// Check Categories
					elseif (!empty($rate['cat_ids']))
					{
						$cats = explode(",",$rate['cat_ids']);
						$sql = "SELECT `cat_id`  FROM  `exp_category_posts` WHERE entry_id =  '".$item['entry_id']."'";
						
						$query = $DB->query($sql);

						if ($query->num_rows)
						{
							foreach ($query->result as $row)
							{
								if (in_array('GLOBAL', $entry_ids) || in_array($row['cat_id'],$cats))
								{
									$location_shipping += $this->_location_shipping($locations, $zip, $state, $country, $shipping_amount); 
									if ($location_shipping >0)
									{
										break; 
									}
									else
									{
										continue; 
									}									
								}
							}
						}
						else
						{
							continue;
						}
					}
					elseif (!empty($rate['field_value']) && !empty($rate['field_id']) && $rate['field_id'] != "0")
					{
						$content = explode(",",$rate['field_value']);
						
						$sql = "SELECT `entry_id`  
								FROM  `exp_weblog_data` 
								WHERE field_id_".$rate['field_id']." = '".$rate['field_value']."' 
								AND entry_id =  '".$item['entry_id']."'";
					
						$query = $DB->query($sql);

						if ($query->num_rows)
						{
							foreach ($query->result as $row)
							{
								if ($row['entry_id'] == $item['entry_id'])
								{
									$location_shipping += $this->_location_shipping($locations, $zip, $state, $country, $shipping_amount); 
									if ($location_shipping > 0)
									{
										break; 
									}
									else
									{
										continue; 
									}
								}
							}
						}
						elseif (in_array('GLOBAL', $content))
						{
							$location_shipping += $this->_location_shipping($locations, $zip, $state, $country, $shipping_amount); 
							if ($location_shipping >0)
							{
								break; 
							}
							else
							{
								continue; 
							}							
						}
						else
						{
							continue;
						}
					}
					else
					{
						continue;
					}


				}
				if ($location_shipping > 0)
				{
					$shipping +=$location_shipping; 
				}
				else
				{
					$shipping += $default_amount;
				}
			}// END checking cart items

			return $shipping; 
		}
		// END get_shipping
		
		/**
		 * _location_shipping
		 *
		 * checks location, and returns shipping cost
		 * @param array $locations 
		 * @param string $shipping_amount
		 * @return string 
		 * @author Chris Newton
		 */
		function _location_shipping($locations, $zip, $state, $country, $shipping_amount, $default=0)
		{
			if (in_array('GLOBAL', $locations['zip']))
			{
				return $shipping_amount;
			}
			elseif ( ! empty($zip))
			{
				return (in_array($zip, $locations['zip'])) ? $shipping_amount : 0;
			}
			elseif (in_array('GLOBAL', $locations['state']))
			{
				return $shipping_amount;
			}
			elseif ( ! empty($state))
			{
				return (in_array($state, $locations['state'])) ? $shipping_amount : 0;
			}
			elseif (in_array('GLOBAL', $locations['country']))
			{
				return $shipping_amount;
			}
			elseif ( ! empty($country))
			{
				return (in_array($country, $locations['country'])) ? $shipping_amount : 0;
			}
			else
			{
				return $default;
			}
			/*
			if (in_array('GLOBAL', $locations['zip']) || (!empty($zip) && in_array( $zip, $locations['zip'])))
			{
				return $shipping_amount; 
			}
			elseif (in_array('GLOBAL', $locations['state']) || (!empty($state) && in_array( $state, $locations['state'])))
			{
				return $shipping_amount; 
			}
			elseif (in_array('GLOBAL', $locations['country']) || (!empty($country) && in_array( $country, $locations['country'])))
			{
				return $shipping_amount; 
			}
			else
			{
				return $default;
			}
			*/
		}
		// END 
	}
	// END Class
}
/* End of file cartthrob.per_location_rates.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.per_location_rates.php */