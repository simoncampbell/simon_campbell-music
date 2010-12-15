<?php

$plugin_info = array(
	'title' => 'Item specific discount limited by quantity',
	'classname' => 'Cartthrob_limit_by_quantity',
	'type' => 'limit_by_quantity',
	'settings' => array(
		array(
			'name' => 'Percentage Off',
			'short_name' => 'percentage_off',
			'note' => 'Enter the percentage to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		),	
		array(
			'name' => 'Qualifying entry_ids',
			'short_name' => 'entry_id',
			'note' => 'If this applies only to certain items add entry IDs here. Separate multiple entry_ids by comma',
			'type' => 'text'
		),
		array(
			'name' => 'Per Item Limit',
			'short_name' => 'item_limit',
			'note' => 'If there is a limit to the number of items that can be discounted, add that limit here.',
			'type' => 'text'
		),
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_limit_by_quantity extends Cartthrob_coupon_code_plugin
	{
		function Cartthrob_limit_by_quantity()
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
		
			if ( ! empty($coupon_code_data['entry_id']))
			{
				$entry_ids = preg_split('/([\s]+)?,([\s]+)?/', trim($coupon_code_data['entry_id']));
			}
			
			if (!empty($entry_ids))
			{
				foreach ($entry_ids as $entry_id)
				{
					$row_id = $this->_item_in_cart($entry_id);
									
					if ($row_id !== FALSE)
					{
						$quantity_in_cart 	= $this->_get_item_quantity($entry_id, $row_id); 
						$item_limit 		= $this->_sanitize_number($coupon_code_data['item_limit']); 
						$percentage_off		= $this->_sanitize_number($coupon_code_data['percentage_off']) / 100; 
						
						if ($quantity_in_cart <= $item_limit)
						{
							return $this->_get_item_subtotal($entry_id, $row_id) * $percentage_off;
						}
						elseif ($quantity_in_cart > $item_limit)
						{
							return	$this->_sanitize_number($item_limit) * $percentage_off;
							
						}
						else
						{
							return 0; 
						}
					}
				}
			}
			return 0; 
		}
		// END
		function messages()
		{
			return array(
				'item_not_in_cart' => 'The coupon code you entered is not valid for any of the items in your cart.',
				'too_many_items' => 'You are limited to only two items discounted'
			);
		} // END
	}// END CLASS
}

/* End of file cartthrob.limit_by_quantity.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.limit_by_quantity.php */