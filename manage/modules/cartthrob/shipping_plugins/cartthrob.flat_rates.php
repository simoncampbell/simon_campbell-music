<?php

$plugin_info = array(
	'title' => 'DEFINED Customer Selectable Flat Rates',
	'classname' => 'Cartthrob_flat_rates',
	'note' => 'One option is selected per transaction by customer',
	'settings' => array(
		array(
			'name' => 'Rates',
			'short_name' => 'rates',
			'type' => 'matrix',
			'settings' => array(
				array(
					'name' => 'Default<br />Setting?',
					'short_name' => 'default',
					'type' => 'checkbox',
					'options' => array(
						'extra' => ' onclick="if ($(this).is(\':checked\')) { $(this).parent().parent().parent().find(\'.checkbox\').not(this).attr(\'checked\',\'\'); console.log(\'test\'); }"'
					)
				),
				array(
					'name' => 'Short Name (shipping code, etc.)',
					'short_name' => 'short_name',
					'type' => 'text'
				),
				array(
					'name' => 'Title (descriptive name)',
					'short_name' => 'title',
					'type' => 'text'
				),
				array(
					'name' => 'Cost per transaction',
					'short_name' => 'rate',
					'type' => 'text'
				),
				array(
					'name' => 'Shipping is free at: (optional; ex. 99)',
					'short_name' => 'free_price',
					'type' => 'text'
				),
			)
		)
	)
);
if ( ! class_exists($plugin_info['classname']))
{
	class Cartthrob_flat_rates extends Cartthrob_shipping_plugin
	{
		var $default_shipping_option = '';
	

		function Cartthrob_flat_rates()
		{
			$this->Cartthrob_shipping_plugin();
					
			$this->rates = array();
			$this->free_rates = array();
		
			//backwards compatability
			if ( ! is_array($this->plugin_settings['rates']))
			{
				$rates_input = $this->_textarea_to_array($this->plugin_settings['rates']);
			
				foreach ($rates_input as $rate)
				{
					$rate = explode(':', $rate);
					if (count($rate) > 2)
					{
						$this->rate_titles[$rate[0]] = $rate[1];
						$this->rates[$rate[0]] = $rate[2];
						if (count($rate) > 3)
						{
							$this->free_rates[$rate[0]] = $rate[3];
						}
					}
				}
			}
			else
			{
				foreach ($this->plugin_settings['rates'] as $rate)
				{
					if ( ! empty($rate['default']))
					{
						$this->default_shipping_option = $rate['short_name'];
					}
					$this->rate_titles[$rate['short_name']] = $rate['title'];
					$this->rates[$rate['short_name']] = $rate['rate'];
					if (isset($rate['free_price']) && $rate['free_price'])
					{
						$this->free_rates[$rate['short_name']] = $rate['free_price'];
					}
				}
			}
		}
	
		function get_shipping()
		{
			global $IN;
		
			$this->_session_start();
			
			if ($this->unique_items_count() <= 0 || $this->_calculate_shippable_subtotal() <= 0)
			{
				return 0;
			}
		
			$shipping_option = $IN->GBL('shipping_option', 'POST');
		
			if ( ! $shipping_option)
			{
				if (isset($_SESSION['cartthrob']['shipping']['shipping_option']))
				{
					$shipping_option = $_SESSION['cartthrob']['shipping']['shipping_option'];
				}
				elseif ($this->default_shipping_option)
				{
					$shipping_option = $_SESSION['cartthrob']['shipping']['shipping_option'] = $this->default_shipping_option;
				}
			}
			else
			{
				$this->save_shipping_option();
			}
		
			if ($shipping_option && array_key_exists($shipping_option, $this->rates))
			{
				if (array_key_exists($shipping_option, $this->free_rates) && ($this->_calculate_shippable_subtotal() > $this->free_rates[$shipping_option]))
				{
					return 0;
				}
				else
				{
					return $this->rates[$shipping_option];
				}
			}
			elseif ( ! $shipping_option)
			{
				return 0;
			}
			else
			{
				return max($this->rates);
			}
		}
	
		function plugin_shipping_options()
		{
			global $TMPL;
		
			$this->_session_start();
		
			$output = '';
		
			if (trim($TMPL->tagdata))
			{
				foreach ($this->rates as $rate_short_name => $price)
				{
					$rate_title = $this->rate_titles[$rate_short_name];
				
					$current_rate = ( ! empty($_SESSION['cartthrob']['shipping']['shipping_option'])) ? $_SESSION['cartthrob']['shipping']['shipping_option'] : $this->default_shipping_option;
				
					$selected = ($rate_short_name == $current_rate) ? ' selected="selected"' : '';
				
					$checked = ($rate_short_name == $current_rate) ? ' checked="checked"' : '';
				
					$tagdata = $TMPL->tagdata;
				
					$tagdata = $TMPL->swap_var_single('rate_short_name', $rate_short_name, $tagdata);
				
					$tagdata = $TMPL->swap_var_single('rate_title', $rate_title, $tagdata);
				
					$tagdata = $TMPL->swap_var_single('price', $price, $tagdata);
				
					$tagdata = $TMPL->swap_var_single('selected', $selected, $tagdata);
				
					$tagdata = $TMPL->swap_var_single('checked', $checked, $tagdata);
				
					$output .= $tagdata;
				}
			}
			else
			{
				$id = ($TMPL->fetch_param('id')) ? ' id="'.$TMPL->fetch_param('id').'"' : '';
				$class = ($TMPL->fetch_param('class')) ? ' class="'.$TMPL->fetch_param('class').'"' : '';
				$onchange = ($TMPL->fetch_param('onchange')) ? ' onchange="'.$TMPL->fetch_param('onchange').'"' : '';
				$extra = ($TMPL->fetch_param('extra')) ? ' '.$TMPL->fetch_param('extra') : '';
			
				$output .= '<select name="shipping_option"'.$id.$class.$onchange.$extra.">\n";
			
				foreach ($this->rates as $rate_short_name => $price)
				{
					$rate_title = $this->rate_titles[$rate_short_name];
				
					$selected = ($rate_short_name == @$_SESSION['cartthrob']['shipping']['shipping_option']) ? ' selected="selected"' : '';
				
					$output .= "\t".'<option value="'.$rate_short_name.'"'.$selected.'>'.$rate_title.'</option>'."\n";
				}
			
				$output .= "</select>\n";
			}
		
			return $output;
		}
	
		function get_product_shipping($entry_id)
		{
			return 0;
		}

	}
}
/* End of file cartthrob.flat_rates.php */
/* Location: ./system/modules/shipping_plugins/cartthrob.flat_rates.php */