<?php

$plugin_info = array(
	'title' => 'Percentage Off A Single Product',
	'classname' => 'Cartthrob_percentage_off_product',
	'type' => 'percentage_off_product',
	'settings' => array(
		array(
			'name' => 'Percentage Off',
			'short_name' => 'percentage_off',
			'note' => 'Enter the percentage to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		),
		array(
			'name' => 'Included Product entry_id',
			'short_name' => 'entry_id',
			'note' => 'Separate multiple entry_ids by comma',
			'type' => 'text'
		),
		array(
			'name' => 'Excluded Product entry_id',
			'short_name' => 'excluded_entry_id',
			'note' => 'Separate multiple entry_ids by comma',
			'type' => 'text'
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_percentage_off_product extends Cartthrob_coupon_code_plugin
	{
		var $entry_ids = array();
		
		function Cartthrob_percentage_off_product()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = NULL)
		{
			global $DB, $IN;
			
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			$percentage_off = $this->_sanitize_number($coupon_code_data['percentage_off']);
			
			$discount = 0;
			
			if ( ! empty($coupon_code_data['entry_id']) && $entry_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['entry_id'])))
			{
				foreach ($this->_get_cart_items() as $row_id => $item)
				{
					if ( ! empty($item['entry_id']) && in_array($item['entry_id'], $entry_ids))
					{
						$discount += $this->_get_item_price($item['entry_id'], $row_id) * $this->_get_item_quantity($item['entry_id'], $row_id) * ($percentage_off / 100);
					}
				}
			}
			elseif  ( ! empty($coupon_code_data['excluded_entry_id']) && $entry_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['excluded_entry_id'])))
			{
				foreach ($this->_get_cart_items() as $row_id => $item)
				{
					if ( ! empty($item['entry_id']) && !in_array($item['entry_id'], $entry_ids))
					{
						$discount += $this->_get_item_price($item['entry_id'], $row_id) * $this->_get_item_quantity($item['entry_id'], $row_id) * ($percentage_off / 100);
					}
				}
			}
			
			return $discount;
		}
		
		function get_discount_label($coupon_code, $coupon_code_data = NULL)
		{
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			return $coupon_code_data['field_id_'.$this->_coupon_code_field_one].'%';
		}
		
		function validate($coupon_code, $coupon_code_data = NULL)
		{
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			if ( ! empty($coupon_code_data['entry_id']) && $entry_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['entry_id'])))
			{
				return (count(array_intersect($this->_cart_entry_ids(), $entry_ids)) > 0);
			}
			elseif  ( ! empty($coupon_code_data['excluded_entry_id']) && $entry_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['excluded_entry_id'])))
			{
				return (count(array_diff($this->_cart_entry_ids(), $entry_ids)) > 0);
			}
			
			return FALSE;
		}
		
		function message()
		{
			return 'The coupon code you entered is not valid for any of the items in your cart.';
		}
	
	}
}

/* End of file cartthrob.percentage_off.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.percentage_off.php */