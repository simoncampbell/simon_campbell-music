<?php

$plugin_info = array(
	'title' => 'Percentage Off Category',
	'classname' => 'Cartthrob_percentage_off_category',
	'type' => 'percentage_off_category',
	'settings' => array(
		array(
			'name' => 'Percentage Off',
			'short_name' => 'percentage_off',
			'note' => 'Enter the percentage to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		),
		array(
			'name' => 'Category ID',
			'short_name' => 'cat_id',
			'note' => 'Separate multiple category IDs by comma or pipe',
			'type' => 'text'
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_percentage_off_category extends Cartthrob_coupon_code_plugin
	{
		function Cartthrob_percentage_off_category()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = NULL)
		{
			global $DB;
			
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			$percentage_off = $this->_sanitize_number($coupon_code_data['percentage_off']);
			
			$discount = 0;
			
			if (count($this->_get_cart_items()) && ! empty($coupon_code_data['cat_id']) && $cat_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['cat_id'])))
			{
				$query = $DB->query("SELECT *
					   FROM exp_category_posts
					   WHERE entry_id
					   IN (".str_replace('|', ',', $this->cart_entry_ids()).")");
				
				$categories = array();
				
				foreach ($query->result as $row)
				{
					$categories[$row['entry_id']][] = $row['cat_id'];
				}
				
				foreach ($this->_get_cart_items() as $row_id => $item)
				{
					if ( ! empty($item['entry_id']) && isset($categories[$item['entry_id']]) && count(array_intersect($cat_ids, $categories[$item['entry_id']])))
					{
						$discount += $this->_get_item_price($item['entry_id'], $row_id) * $this->_get_item_quantity($item['entry_id'], $row_id) * ($percentage_off / 100);
					}
				}
			}
			
			return $discount;
		}
		
		function validate($coupon_code, $coupon_code_data = NULL)
		{
			global $DB;
			
			if ( ! $coupon_code_data)
			{
				$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
			}
			
			if (count($this->_get_cart_items()) && ! empty($coupon_code_data['cat_id']) && $cat_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['cat_id'])))
			{
				$query = $DB->query("SELECT *
					   FROM exp_category_posts
					   WHERE entry_id
					   IN (".str_replace('|', ',', $this->cart_entry_ids()).")");
				
				$categories = array();
				
				foreach ($query->result as $row)
				{
					$categories[$row['entry_id']][] = $row['cat_id'];
				}
				
				foreach ($this->_get_cart_items() as $row_id => $item)
				{
					if ( ! empty($item['entry_id']) && isset($categories[$item['entry_id']]) && count(array_intersect($cat_ids, $categories[$item['entry_id']])))
					{
						return TRUE;
					}
				}
			}
			
			return FALSE;
		}
		
		function message()
		{
			return 'The coupon code you entered is not valid for any of the items in your cart.';
		}
	
	}
}

/* End of file cartthrob.percentage_off_category.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.percentage_off_category.php */