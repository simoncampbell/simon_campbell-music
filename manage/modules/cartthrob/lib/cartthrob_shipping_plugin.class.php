<?php

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}
class Cartthrob_shipping_plugin extends Cartthrob
{
	var $plugin_settings = array();
	
	function Cartthrob_shipping_plugin()
	{
		$this->Cartthrob();
		$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
		$this->_session_start();
		
	}
	/**
	 * shipping_weight_total
	 *
	 * @return string total weight
	 * @author Chris Newton
	 * @since 1.0
	 * @access public 
	 */
	function shipping_weight_total(){
		$weight = 0; 
		foreach ($this->shipping_items_array() as $item)
		{
			$weight += $item['quantity'] * $this->_get_item_weight($item['entry_id']);
		}
		return $weight;
	}
	// END
	 
	/**
	 * shipping_cart_total
	 *
	 * @return string
	 * @author Chris Newton
	 * @since 1.0
	 * @access public 
	 */
	function shipping_cart_subtotal(){
		return $this->_calculate_shippable_subtotal();
	}
	// END
	
	function shipping_items_array(){
		return $this->_get_shippable_items();
	}
	/**
	 * shipping_settings_array
	 *
	 * @param string $settings serialized settings array
	 * @return array
	 * @author Chris Newton
	 * @since 1.0
	 */
	function shipping_settings_array($settings){
		$data = $this->_textarea_to_array($settings);
		
		foreach ($data as $value)
		{
			$resp = explode(':', $value);
		}
		return $resp; 
	}
	// END
	/**
	 * get_shipping_array
	 *
	 * @return void
	 * @author Chris Newton
	 **/
	function get_shipping_array()
	{
		$this->_session_start();
		
		$data = array(); 
		if (!empty($_SESSION['cartthrob']['shipping']['shipping_methods']))
		{
			$data['option_prices'] = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_prices'];
			$data['option_values'] = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']; 
			$data['option_titles'] = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_titles'];
			return $data; 
		}
		return NULL; 
	}
	/**
	 * undocumented function
	 *
	 * @param array $defaults
	 * @return void
	 * @author Chris Newton
	 **/
	function get_shipping_presets($d_def_length="15", $d_def_width="15", $_def_height="15", $d_delivery_res_com="1", $d_origination_res_com="1", $d_rate_shop= 'rate', $d_product_id=NULL, $d_rate_chart = NULL, $d_container =NULL)
	{
		$this->_session_start();
		$shipping_info = array(
				'price'				=> NULL, 
				'error_message' 	=> NULL,
				'shipping_methods'	=> array(
						'option_values'	=> array(),
						'option_prices'	=> array(),
						'option_titles'	=> array(),
					),
			);
			

		// THIS PULLS THE CUSTOMER INFO FROM THE SESSION
		$customer_info = $this->_get_customer_info(NULL, $return_shipping = FALSE); 

		/* ************************************* DEFAULT VALUES ****************************************/
	
		// ORIGINATION COUNTRY
		// the mess below takes a look at the data from the template. If there's nothing there, it pulls
		// data from the settings. If nothing's there, US is used by default
		$setting_country_code = $this->view_setting("country_code");
		$orig_country_code 	= !empty($_SESSION['cartthrob']['shipping']['origination_country']) ? 	
			$_SESSION['cartthrob']['shipping']['origination_country'] 	: 
			!empty($setting_country_code) ? 
				$setting_country_code : 
				"USA";
		$data['orig_country_code'] = $this->_get_alpha3_country_code($orig_country_code); 
	
		// ORIGINATION ZIP
		// the other mess below also takes a look at the data from the template. If there's nothing there, it pulls
		// data from the settings. If nothing's there, 10001 is used by default
		$setting_zip_code = $this->view_setting("zip"); 
		$data['orig_zip'] 		= !empty($_SESSION['cartthrob']['shipping']['origination_zip']) ? 
			$_SESSION['cartthrob']['shipping']['origination_zip'] : 
			!empty($setting_zip_code) ? 
				$setting_zip_code : 
				"10001"; 
		
		// ORIGINATION STATE
		// the final mess below also takes a look at the data from the template. If there's nothing there, it pulls
		// data from the settings. If nothing's there, MA is used by default
		$setting_state_code = $this->view_setting("state"); 
		$data['orig_state'] 	= !empty($_SESSION['cartthrob']['shipping']['origination_state']) ? 
			$_SESSION['cartthrob']['shipping']['origination_state'] : 
			!empty($setting_state_code) ? 
				$setting_state_code : 
				"MA";
		
		// DESTINATION COUNTRY CODE
		// shipping or billing or settings or US
		if (!empty($customer_info['shipping_country_code']))
		{
			$data['dest_country_code'] = $customer_info['shipping_country_code']; 
		}
		elseif (!empty($customer_info['country_code']))
		{
			$data['dest_country_code'] = $customer_info['country_code']; 
		}
		elseif (!empty($data['orig_country_code']))
		{
			$data['dest_country_code'] = $data['orig_country_code']; 
		}
		else
		{
			$data['dest_country_code'] = "USA";
		}
		$data['dest_country_code'] = $this->_get_alpha3_country_code($data['dest_country_code']); 
	
		// DESTINATION ZIP
		// shipping or billing or settings or 10001
		if (!empty($customer_info['shipping_zip']))
		{
			$data['dest_zip'] = $customer_info['shipping_zip']; 
		}
		elseif (!empty($customer_info['zip']))
		{
			$data['dest_zip'] = $customer_info['zip']; 
		}
		elseif (!empty($data['orig_zip'] ))
		{
			$data['dest_zip'] = $data['orig_zip'] ; 
		}
		else
		{
			$data['dest_zip'] = "10001";
		}
 		
		$data['product_id'] 			= !empty($_SESSION['cartthrob']['shipping']['product']) 			? $_SESSION['cartthrob']['shipping']['product'] 				: $d_product_id;
		$data['rate_chart'] 			= !empty($_SESSION['cartthrob']['shipping']['rate']) 				? $_SESSION['cartthrob']['shipping']['rate'] 					: $d_rate_chart;
		$data['container']  			= !empty($_SESSION['cartthrob']['shipping']['container']) 			? $_SESSION['cartthrob']['shipping']['container'] 				: $d_container;
		$data['delivery_res_com'] 		= !empty($_SESSION['cartthrob']['shipping']['delivery_type']) 		? $_SESSION['cartthrob']['shipping']['delivery_type'] 			: $d_delivery_res_com;
		$data['origination_res_com'] 	= !empty($_SESSION['cartthrob']['shipping']['origination_type']) 	? $_SESSION['cartthrob']['shipping']['origination_type'] 		: $d_origination_res_com;
 		$data['dim_length'] 			= !empty($_SESSION['cartthrob']['shipping']['length']) 				? $_SESSION['cartthrob']['shipping']['length'] 					: $d_def_length;
		$data['dim_width'] 				= !empty($_SESSION['cartthrob']['shipping']['width']) 				? $_SESSION['cartthrob']['shipping']['width'] 					: $d_def_width;
		$data['dim_height'] 			= !empty($_SESSION['cartthrob']['shipping']['height']) 				? $_SESSION['cartthrob']['shipping']['height'] 					: $d_def_height;
 		$data['rate_shop'] 				= !empty($_SESSION['cartthrob']['shipping']['mode']) 				? $_SESSION['cartthrob']['shipping']['mode'] 					: $d_rate_shop;

		$data['shipping_address']  		= !empty($customer_info['shipping_address']) 						? $customer_info['shipping_address']							: $customer_info['address']; 
		$data['shipping_address2'] 		= !empty($customer_info['shipping_address2']) 						? $customer_info['shipping_address2']							: $customer_info['address2']; 
		$data['shipping_city']	   		= !empty($customer_info['shipping_city']) 							? $customer_info['shipping_city']								: $customer_info['city']; 
		$data['shipping_state']    		= !empty($customer_info['shipping_state']) 							? $customer_info['shipping_state']								: ""; //@$customer_info['state']; 

		return $data; 
		
	}//END
	/**
	 * undocumented function
	 *
	 * @return void
	 * @author Chris Newton
	 **/
	function set_shipping_array_key($option, $data)
	{
		$this->_session_start();
		
		$_SESSION['cartthrob']['shipping'][$option] = $data; 
	}
	
	function delete_shipping_array_key($option)
	{
		$this->_session_start(); 
		unset($_SESSION['cartthrob']['shipping'][$option] );
		
	}
	function build_shipping_methods_select()
	{
		
	}
	/**
	 * quoted_shipping_options
	 *
	 * @param array $shipping_methods key/value pair of options & labels.
	 * @return void
	 * @author Chris Newton
	 */
	function quoted_shipping_options($shipping_options,$default_product_id)
	{
		global $TMPL, $FNS;

		$this->_session_start();

		$output = '';

		if (trim($TMPL->tagdata))
		{
 			foreach ($shipping_options as $key=>$value)
			{
				$rate_title = $value;

				$current_rate = ( ! empty($_SESSION['cartthrob']['shipping']['product'])) ? $_SESSION['cartthrob']['shipping']['product'] : $default_product_id;

				$selected = ($key == $current_rate) ? ' selected="selected"' : '';

				$checked = ($key == $current_rate) ? ' checked="checked"' : '';

				$tagdata = $TMPL->tagdata;

				$methodkey =  array_search($key, $_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']);
				
				$tagdata = $TMPL->swap_var_single('rate_short_name', $key, $tagdata);
				$tagdata = $TMPL->swap_var_single('rate_title', $rate_title, $tagdata);
				$tagdata = $TMPL->swap_var_single('selected', $selected, $tagdata);
				$tagdata = $TMPL->swap_var_single('checked', $checked, $tagdata);
				
				if ($methodkey!==FALSE)
				{
					$tagdata = $TMPL->swap_var_single('price',$_SESSION['cartthrob']['shipping']['shipping_methods']['option_prices'][$methodkey] , $tagdata);
					$price = $_SESSION['cartthrob']['shipping']['shipping_methods']['option_prices'][$methodkey]; 
				}
				else
				{
					$tagdata = $TMPL->swap_var_single('price', "0" , $tagdata);
					$price = 0; 
				}
				
				$cond['selected'] = (bool) $selected;
				$cond['checked'] = (bool) $checked;
				$cond['price'] = (bool) $price;
				$cond['rate_title'] = (bool) $rate_title;
				$cond['rate_short_name'] = (bool) $rate_short_name;
				
				$tagdata = $FNS->prep_conditionals($tagdata, $cond);
				
				$output .= $tagdata;
			}
		}
		else
		{
			$id = ($TMPL->fetch_param('id')) ? ' id="'.$TMPL->fetch_param('id').'"' : '';
			$class = ($TMPL->fetch_param('class')) ? ' class="'.$TMPL->fetch_param('class').'"' : '';
			$onchange = ($TMPL->fetch_param('onchange')) ? ' onchange="'.$TMPL->fetch_param('onchange').'"' : '';
			$extra = ($TMPL->fetch_param('extra')) ? ' '.$TMPL->fetch_param('extra') : '';
			$show_all =  ($TMPL->fetch_param('show_all')) ? $TMPL->fetch_param('show_all') : '';
			
			
			$output .= '<select name="shipping[product]"'.$id.$class.$onchange.$extra.">\n";

			foreach ($shipping_options as $key=>$value)
			{
				$rate_title = $value;
				
				if (!empty($_SESSION['cartthrob']['shipping']['product']) && $key == $_SESSION['cartthrob']['shipping']['product'] )
				{
					$selected = ' selected="selected"' ;
					
				}
				else
				{
					$selected= "";
				}
				
				if ($show_all != "yes" && !empty($_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']))
				{
					if (in_array($key,$_SESSION['cartthrob']['shipping']['shipping_methods']['option_values']))
					{
						$output .= "\t".'<option value="'.$key.'"'.$selected.'>'.$rate_title.'</option>'."\n";
					}
				}
				else
				{
					$output .= "\t".'<option value="'.$key.'"'.$selected.'>'.$rate_title.'</option>'."\n";
					
				}
				
			}

			$output .= "</select>\n";
		}

		return $output;
	} 
}

/* End of file cartthrob_shipping_plugin.class.php */
/* Location: ./system/modules/cartthrob/cartthrob_shipping_plugin.class.php */