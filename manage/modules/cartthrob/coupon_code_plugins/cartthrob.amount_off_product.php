<?php

$plugin_info = array(
	'title' => 'Amount Off Product',
	'classname' => 'Cartthrob_amount_off_product',
	'type' => 'amount_off_product',
	'settings' => array(
		array(
			'name' => 'Amount Off',
			'short_name' => 'amount_off',
			'note' => 'Enter the amount to subtract from the subtotal. NUMERIC VALUES ONLY.',
			'type' => 'text'
		),
		array(
			'name' => 'Product entry_id',
			'short_name' => 'entry_id',
			'note' => 'Separate multiple entry_ids by comma',
			'type' => 'text'
		)
	)
);

if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_amount_off_product extends Cartthrob_coupon_code_plugin
	{
	
		function Cartthrob_amount_off_product()
		{
			$this->Cartthrob(FALSE);
		}
		
		function get_discount($coupon_code, $subtotal, $shipping, $coupon_code_data = FALSE)
		{
				global $DB, $IN;

				if ( ! $coupon_code_data)
				{
					$coupon_code_data = $this->_get_coupon_code_data($coupon_code);
				}

				$amount_off = $this->_sanitize_number($coupon_code_data['amount_off']);

				$discount = 0;

				if ( ! empty($coupon_code_data['entry_id']) && $entry_ids = preg_split('/\s*(,|\|)\s*/', trim($coupon_code_data['entry_id'])))
				{
					foreach ($this->_get_cart_items() as $row_id => $item)
					{
						if ( ! empty($item['entry_id']) && in_array($item['entry_id'], $entry_ids))
						{
							$discount += ($this->_get_item_quantity($item['entry_id'], $row_id) * ($amount_off));
						}
					}
				}

				return $discount;
			}
	}
}

/* End of file cartthrob.amount_off_product.php */
/* Location: ./system/modules/coupon_code_plugins/cartthrob.amount_off_product.php */