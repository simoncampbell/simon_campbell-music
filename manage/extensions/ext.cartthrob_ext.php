<?php
/**
 * Cartthrob_ext
 * Cartthrob Extension: Part of the CartThrob cart system for Expression Engine
 * 
 * This file must be placed in the
 * /system/extensions/ folder in your ExpressionEngine installation.
 *
 * This extension allows you to store settings for the Cartthrob plugin.
 * 
 * This is an application that works with ExpressionEngine <a href="http://www.ExpressionEngine.com">http://www.ExpressionEngine.com</a>
 * @link http://www.ExpressionEngine.com
 * @package CartThrob
 * @version 0.9457
 * @since 1.0.0
 * @author Chris Newton <http://barrettnewton.com>, Rob Sanchez, Chris Barrett
 * @see http://cartthrob.com/
 * @copyright Copyright (c) 2010 Chris Newton, Barrett Newton Inc.
 * @license http://cartthrob.com/docs/pages/license_agreement/ All source code commenting and attribution must not be removed. This is a condition of the attribution clause of the license.
**/

if ( ! defined('EXT'))
{
	exit('Invalid file request');
}

class Cartthrob_ext
{
	var $settings = array();
	var $classname = 'Cartthrob_ext';
	var $name = 'CartThrob';
	var $version = '0.9457';
	var $description = 'CartThrob Shopping Cart';
	var $settings_exist = 'y';
	var $docs_url = 'http://cartthrob.com/docs';
	var $required_settings = array();
	var $CART;
	var $template_errors = array();
	var $templates_installed = array();
	var $extension_enabled = 0;
	var $module_enabled = 0;

    // -------------------------------
    //   Constructor
    // -------------------------------
	/**
	* PHP4 Constructor
	*
	* @see __construct()
	*/
    function Cartthrob_ext($settings='')
    {
		$this->__construct($settings);
    }
	/**
	* PHP 5 Constructor
	*
	* @param	array|string $settings Extension settings associative array or an empty string
	*/
	function __construct($settings = "")
	{
		global $IN, $SESS, $LANG;
		$LANG->fetch_language_file('cartthrob_ext');
		$LANG->fetch_language_file('cartthrob_errors');
		$this->settings = $this->_get_settings();
	}
	// END
	
	// --------------------------------
	//  Activate Extension
	// --------------------------------
	/**
	 * Activates Extension
	 *
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function activate_extension()
	{
		global $DB, $EXT, $OUT;
		
		if ( ! isset($EXT->version_numbers['Cp_jquery']))
		{
		    return $OUT->show_user_error('general', 'jQuery for the Control Panel is NOT installed');
		}
		
		$hooks = array(
			array('member_member_logout'),
			array('submit_new_entry_start'),
			array('show_full_control_panel_end'),
			array('publish_admin_edit_field_type_pulldown'),
			array('publish_form_field_unique'),
			array('publish_admin_edit_field_format'),
			array('publish_admin_edit_field_js'),
			array('weblog_entries_tagdata'),
		);
		
		$this->_activate_hooks($hooks);
	}
	// END
	
	// --------------------------------
	//  Activate Hooks
	// --------------------------------
	/**
	 * Activates Hooks
	 * 
	 * Registers an array of hooks in the exp_extensions database 
	 *
	 * @access private
	 * @param array $hooks
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _activate_hooks($hooks)
	{
		global $DB;
		
		foreach ($hooks as $hook)
		{
			$DB->query($DB->insert_string('exp_extensions',
				array(
					'extension_id' => '',
					'class' => $this->classname,
					'method' => $hook[0],
					'hook' => ( ! empty($hook[1]) ? $hook[1] : $hook[0]),
					'settings' => ( ! empty($hook[3]) ? $hook[3] : ''),
					'priority' => ( ! empty($hook[2]) ? $hook[2] : 10),
					'version' => $this->version,
					'enabled' => 'y'
				)
			));
		}
	}
	// END
	
	
	// --------------------------------
	//  Update Extension
	// --------------------------------  
	/**
	 * Updates Extension
	 *
	 * @access public
	 * @param string
	 * @return void|BOOLEAN False if the extension is current
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function update_extension($current='')
	{
		global $DB;
    
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		/* legacy, for old version number system */
		/* i bet there's actually no one with a version this old */
		if (preg_match('/0\.9\.([0-9]+)/', $current, $match))
		{
			$current = '0.9';
			
			$current_revision = $match[1];
			
			if ($current <= '0.9' && $current_revision < '253')
			{
				$DB->query($DB->insert_string('exp_actions', array(
					'class'	=> 'Cartthrob',
					'method' => 'payment_return'
				)));
			}
			if ($current <= '0.9' && $current_revision < '110')
			{
				$DB->query($DB->insert_string('exp_actions', array(
				    'class' => 'Cartthrob',
				    'method' => '_add_to_cart_form_submit'
				)));
			}
			
			if ($current <= '0.9' && $current_revision < '96')
			{
				$DB->query($DB->insert_string('exp_actions', array(
				    'class' => 'Cartthrob',
				    'method' => '_checkout'
				)));
			}
			
			if ($current <= '0.9' && $current_revision < '80')
			{
				$DB->query($DB->update_string(
					'exp_extensions',
					array('method' => 'member_member_logout'),
					array('class' => $this->classname, 'method' => 'clear_cart_on_logout')
				));
				
				$query = $DB->query("DELETE FROM exp_extensions WHERE class = '".$this->classname."' AND method IN ('set_return_entry_id', 'cart_row', 'halt_redirect')");
			}
			
			if ($current <= '0.9' && $current_revision < '75')
			{
				$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '".$this->classname."' LIMIT 1");
				
				if ($query->num_rows)
				{
					$hooks = array(
						array('weblog_entries_tagdata', 'weblog_entries_tagdata', 10, $query->row['settings']),
					);
					
					$this->_activate_hooks($hooks);
				}
			}
			
			if ($current <= '0.9' && $current_revision <= '2')
			{
				$hooks = array(
					array('submit_new_entry_start'),
					array('show_full_control_panel_end'),
					array('publish_admin_edit_field_type_pulldown'),
					array('publish_form_field_unique'),
				);
			    
				$this->_activate_hooks($hooks);
			}
		}
			
		if ($current < '0.9192')
		{
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_coupon_code_form_submit'
			)));
		}
			
		if ($current < '0.9206')
		{
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_update_item_submit'
			)));
		}
			
		if ($current < '0.9208')
		{
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_delete_from_cart_submit'
			)));
		}
			
		if ($current < '0.9209')
		{
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_save_customer_info_submit'
			)));
			
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_update_cart_submit'
			)));
		}
			
		if ($current < '0.9238')
		{
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '".$this->classname."' LIMIT 1");
			
			if ($query->num_rows)
			{
				$hooks = array(
					array('publish_admin_edit_field_format', 'publish_admin_edit_field_format', 10, $query->row['settings']),
					array('publish_admin_edit_field_js', 'publish_admin_edit_field_js', 10, $query->row['settings'])
				);
				
				$this->_activate_hooks($hooks);
			}
		}
			
		if ($current < '0.9252')
		{
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_ajax_action'
			)));
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_jquery_plugin_action'
			)));
		}
        
		if ($current < '0.9266')
		{
			$DB->query($DB->insert_string('exp_actions', array(
			    'class' => 'Cartthrob',
			    'method' => '_multi_add_to_cart_form_submit'
			)));
		}
		
		if ($current < '0.9303')
		{
			$DB->query($DB->insert_string('exp_actions', array(
				'class'	=> 'Cartthrob',
				'method' => '_request_shipping_quote_form_submit'
			)));
		}
		
		if ($current <= '0.9408')
		{
			$DB->query($DB->insert_string('exp_actions', array(
				'class'	=> 'Cartthrob',
				'method' => '_download_file_form_submit'
			)));
		}
		
		
		$DB->query($DB->update_string('exp_extensions', array('version' => $this->version), array('class' => $this->classname)));
		
		$DB->query($DB->update_string('exp_modules', array('module_version' => $this->version), array('module_name' => 'Cartthrob')));
	}
	// END
	
	// --------------------------------
	//  Disable Extension
	// --------------------------------
	/**
	 * Disables Extension
	 * 
	 * Deletes mention of this extension from the exp_extensions database table
	 *
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function disable_extension()
	{
	    global $DB;
	    $DB->query("DELETE FROM exp_extensions WHERE class = '".$this->classname."'");
	}
	// END
	
	// --------------------------------
	//  Settings Function
	// --------------------------------
	/**
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function settings()
	{
	}
	// END 
	
	// --------------------------------
	//  Load Settings
	// --------------------------------
	/**
	 * Load Settings
	 * 
	 * Checks to see if settings variable is set. If not, it accesses _get_settings function
	 *
	 * @access private
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _load_settings()
	{
		if ( ! $this->settings)
		{
			$this->settings = $this->_get_settings();
		}
	}
	// END
	
	function sort_order_items($data, $orderby = FALSE, $sort = FALSE)
	{
		if ($orderby)
		{
			switch($orderby)
			{
				case 'entry_id':
					usort($data, array('Cartthrob_ext', 'compare_order_items_by_entry_id'));
					break;
				case 'title':
					usort($data, array('Cartthrob_ext', 'compare_order_items_by_title'));
					break;
				case 'price':
					usort($data, array('Cartthrob_ext', 'compare_order_items_by_price'));
					break;
				case 'quantity':
					usort($data, array('Cartthrob_ext', 'compare_order_items_by_quantity'));
					break;
			}
		}
		
		if ($sort == 'desc')
		{
			$data = array_reverse($data);
		}
		
		return $data;
	}
    
	function compare_order_items_by_entry_id($a, $b)
	{
		if ($a['entry_id'] == $b['entry_id'])
		{
			return 0;
		}
		elseif ($a['entry_id'] < $b['entry_id'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
    
	function compare_order_items_by_title($a, $b)
	{
		if ($a['title'] == $b['title'])
		{
			return 0;
		}
		elseif ($a['title'] < $b['title'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
    
	function compare_order_items_by_price($a, $b)
	{
		if ($a['price'] == $b['price'])
		{
			return 0;
		}
		elseif ($a['price'] < $b['price'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
    
	function compare_order_items_by_quantity($a, $b)
	{
		if ($a['quantity'] == $b['quantity'])
		{
			return 0;
		}
		elseif ($a['quantity'] < $b['quantity'])
		{
			return -1;
		}
		else
		{
			return 1;
		}
	}
	
	// --------------------------------
	//  Weblog Entries Tagdata Hook Acess
	// --------------------------------
	/**
	 * Modify the tagdata for the weblog entries before anything else is parsed
	 *
	 * @access public
	 * @param string $tagdata The Weblog Entries tag data
	 * @param array $row Array of data for the current entry
	 * @param object $WEBLOG The current Weblog object including all data relating to categories and custom fields
	 * @return string All of the tag data is returned.
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @see http://expressionengine.com/developers/extension_hooks/weblog_entries_tagdata/
	 */
	function weblog_entries_tagdata($tagdata, $row, $WEBLOG)
	{
		global $TMPL, $FNS, $EXT, $DB, $SESS, $EXT;
		
		if ($EXT->last_call !== FALSE)
		{
			$tagdata = $EXT->last_call;
		}
		
		if ( ! $row['weblog_id'])
		{
			return $tagdata;
		}
		
		if ( ! in_array($row['weblog_id'], $this->settings['product_weblogs']) && $row['weblog_id'] != $this->settings['orders_weblog'])
		{
			return $tagdata;
		}
		
		if (isset($SESS->cache['cartthrob']['ct_fields'][$row['weblog_id']]))
		{
			$fields = $SESS->cache['cartthrob']['ct_fields'][$row['weblog_id']];
		}
		else
		{
			$sql = "SELECT field_name, field_id, field_type, field_label
				FROM exp_weblog_fields
				WHERE (field_type IN ('ct_items','ct_matrix','ct_price_mod') OR field_type LIKE 'ct_matrix%')
				AND (group_id = (SELECT field_group FROM exp_weblogs WHERE weblog_id = '".$DB->escape_str($row['weblog_id'])."')";
			
			if (isset($EXT->OBJ['Gypsy']))
			{
				$sql .= " OR (field_is_gypsy = 'y' AND gypsy_weblogs LIKE '% ".$DB->escape_str($row['weblog_id'])." %'))";
			}
			else
			{
				$sql .= ')';
			}
			
			$query = $DB->query($sql);
			
			$fields = $SESS->cache['cartthrob']['ct_fields'][$row['weblog_id']] = $query->result;
		}
		
		if ( ! count($fields))
		{
			return $tagdata;
		}
		
		if ($this->settings['orders_items_field'] && $row['weblog_id'] == $this->settings['orders_weblog'])
		{
			$this->_load_cart();
			
			$field_type = $this->CART->_get_field_type($this->settings['orders_items_field']);
			
			if ($field_type !== FALSE && $field_type == 'ct_items')
			{
				
				$field_name = $this->CART->_get_field_name($this->settings['orders_items_field']);
				
				$data = array();
				
				if (isset($row['field_id_'.$this->settings['orders_items_field']]) && $row['field_id_'.$this->settings['orders_items_field']])
				{
					$data = $this->_unserialize($row['field_id_'.$this->settings['orders_items_field']]);
				}
				
				foreach ($TMPL->var_pair as $var_pair => $params)
				{
					if ( ! preg_match('/^'.$field_name.'/', $var_pair))
					{
						continue;
					}
					
					if (preg_match_all('/'.LD.preg_quote($var_pair).RD.'(.*?)'.LD.SLASH.$field_name.RD.'/s', $tagdata, $matches))
					{
						$total_results = count($data);
						
						$data = $this->sort_order_items($data, (isset($params['orderby'])) ? $params['orderby'] : FALSE, (isset($params['sort'])) ? $params['sort'] : FALSE);
						
						for ($i = 0; $i < count($matches[0]); $i++)
						{
							$match = array($matches[0][$i], $matches[1][$i]);
							
							$count = 1;
							
							if ( ! $total_results && preg_match('/'.LD.'if item:no_results'.RD.'(.*?)'.LD.SLASH.'if'.RD.'/s', $match[1], $no_results))
							{
								$tagdata = str_replace($match[0], $no_results[1], $tagdata);
								
								continue;
							}
							
							$output = '';
							
							foreach ($data as $item)
							{	
								$item['count'] = $count;
								
								$item['total_results'] = $total_results;
								
								$subtagdata = $match[1];
							
								if (preg_match_all('/'.LD.'item:switch=["\'](.+)["\']'.RD.'/', $subtagdata, $switch_matches))
								{
									foreach ($switch_matches[0] as $i => $v)
									{
										$switch_values = explode('|', $switch_matches[1][$i]);
										
										$subtagdata = str_replace($switch_matches[0][$i], $switch_values[($count + count($switch_values) - 1) % count($switch_values)], $subtagdata);
									}
								}
								
								$cond = array();
								
								foreach ($item as $key => $value)
								{
									unset($item[$key]);
									
									$key = 'item:'.$key;
									
									$item[$key] = $value;
									
									$cond[$key] = (bool) $value;
									
									$subtagdata = $TMPL->swap_var_single($key, $value, $subtagdata);
								}
								
								$cond['item:first_item'] = ($count == 1);
								
								$cond['item:last_item'] = ($count == $total_results);
							
								$subtagdata = $FNS->prep_conditionals($subtagdata, $cond);
								
								$count++;
								
								$output .= $subtagdata;
							}
							
							$tagdata = str_replace($match[0], $output, $tagdata);
						}
					}
				}
		
				if (preg_match('/'.LD.$field_name.':table'.RD.'/s', $tagdata))
				{
					
					global $DSP;
					
					if ( ! is_object($DSP))
					{
						if ( ! class_exists('Display'))
						{
							require PATH_CP.'cp.display'.EXT;
						}
						
						$DSP = new Display();
					}
					
					$tagdata = $TMPL->swap_var_single($field_name.':table', $this->_field_matrix(NULL, $data, $field_type, FALSE), $tagdata);
				}
				
				if (preg_match('/'.LD.$field_name.':total_results'.RD.'/s', $tagdata))
				{	
					$tagdata = $TMPL->swap_var_single($field_name.':total_results', count($data), $tagdata);
				}
			}
		}
		
		if ( ! empty($this->settings['product_weblog_fields'][$row['weblog_id']]['price']) && ! empty($row['field_id_'.$this->settings['product_weblog_fields'][$row['weblog_id']]['price']]))
		{
			$this->_load_cart();
			
			if ( ! preg_match('/^ct_matrix/', $this->CART->_get_field_type($this->settings['product_weblog_fields'][$row['weblog_id']]['price'])))
			{
				$tagdata = $TMPL->swap_var_single($this->CART->_get_field_name($this->settings['product_weblog_fields'][$row['weblog_id']]['price']), $this->CART->view_formatted_number($row['field_id_'.$this->settings['product_weblog_fields'][$row['weblog_id']]['price']]), $tagdata);
			}
		}
		
		foreach ($fields as $field)
		{
			
			if ($field['field_type'] == 'ct_price_mod' && isset($row['field_id_'.$field['field_id']]))
			{
				$this->_load_cart();
				
				$data = $this->_unserialize($row['field_id_'.$field['field_id']]);
				
				if ( ! is_array($data))
				{
					$data = array();
				}
			
				if (preg_match_all('/'.LD.$field['field_name'].RD.'(.*?)'.LD.SLASH.$field['field_name'].RD.'/s', $tagdata, $matches))
				{
					for ($i = 0; $i < count($matches[0]); $i++)
					{
						$match = array($matches[0][$i], $matches[1][$i]);
						
						$count = 1;
						
						$output = '';
						
						foreach ($data as $option)
						{	
							$subtagdata = $match[1];
							
							$option['row_count'] = $count;
							
							$option['input_name'] = 'item_option['.$field['field_name'].']';
							
							$option['total_rows'] = count($data);
						
							if (preg_match_all('/'.LD.'row_switch=["\'](.+)["\']'.RD.'/', $subtagdata, $switch_matches))
							{
								foreach ($switch_matches[0] as $i => $v)
								{
									$switch_values = explode('|', $switch_matches[1][$i]);
									
									$subtagdata = str_replace($switch_matches[0][$i], $switch_values[($count + count($switch_values) - 1) % count($switch_values)], $subtagdata);
								}
							}
							
							foreach ($option as $key => $value)
							{
								$subtagdata = $TMPL->swap_var_single($key, $value, $subtagdata);
							}
							
							$count++;
							
							$output .= $subtagdata;
						}
						
						$tagdata = str_replace($match[0], $output, $tagdata);
					}
				}
	
				if (preg_match('/'.LD.$field['field_name'].':label'.RD.'/s', $tagdata))
				{
					$tagdata = $TMPL->swap_var_single($field['field_name'].':label', $field['field_label'], $tagdata);
				}
	
				if (preg_match('/'.LD.$field['field_name'].':input_name'.RD.'/s', $tagdata))
				{
					$tagdata = $TMPL->swap_var_single($field['field_name'].':input_name', 'item_option['.$field['field_name'].']', $tagdata);
				}
	
				if (preg_match('/'.LD.$field['field_name'].':option_count'.RD.'/s', $tagdata))
				{
					$tagdata = $TMPL->swap_var_single($field['field_name'].':option_count', count($data), $tagdata);
				}
				
				$tagdata = $FNS->prep_conditionals($tagdata, array($field['field_name'].':option_count' => count($data) > 0));
			}
			elseif ($field['field_type'] == 'ct_matrix_pq' && isset($row['field_id_'.$field['field_id']]))
			{
				$this->_load_cart();
				
				$data = $this->_unserialize($row['field_id_'.$field['field_id']]);
				
				if ( ! is_array($data))
				{
					$data = array();
				}
			
				if (preg_match_all('/'.LD.$field['field_name'].RD.'(.*?)'.LD.SLASH.$field['field_name'].RD.'/s', $tagdata, $matches))
				{
					for ($i = 0; $i < count($matches[0]); $i++)
					{
						$match = array($matches[0][$i], $matches[1][$i]);
						
						$count = 1;
						
						$output = '';
						
						foreach ($data as $option)
						{	
							$subtagdata = $match[1];
							
							$option['row_count'] = $count;
							
							$option['input_name'] = 'item_option['.$field['field_name'].']';
							
							$option['total_rows'] = count($data);
						
							if (preg_match_all('/'.LD.'row_switch=["\'](.+)["\']'.RD.'/', $subtagdata, $switch_matches))
							{
								foreach ($switch_matches[0] as $i => $v)
								{
									$switch_values = explode('|', $switch_matches[1][$i]);
									
									$subtagdata = str_replace($switch_matches[0][$i], $switch_values[($count + count($switch_values) - 1) % count($switch_values)], $subtagdata);
								}
							}
							
							foreach ($option as $key => $value)
							{
								$subtagdata = $TMPL->swap_var_single($key, $value, $subtagdata);
							}
							
							$count++;
							
							$output .= $subtagdata;
						}
						
						$tagdata = str_replace($match[0], $output, $tagdata);
					}
				}
			}
			
		}
		
		return $tagdata;
	}
	// END
	
	// --------------------------------
	//  Submit New Entry Start Hook Access
	// --------------------------------
	/**
	 * Add More Stuff to do when you first submit an entry
	 *
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @see http://expressionengine.com/developers/extension_hooks/submit_new_entry_start/
	 */
	function submit_new_entry_start()
	{
		global $IN;
		
		if (is_array($IN->GBL('ct_coupon', 'POST')))
		{
			foreach ($IN->GBL('ct_coupon', 'POST') as $ct_coupon)
			{
				$_POST[$ct_coupon] = addslashes(serialize($IN->GBL($ct_coupon, 'POST')));
				
				foreach ($_POST as $key => $value)
				{
					if (preg_match('/^'.$ct_coupon.'_/', $key))
					{
						unset($_POST[$key]);
					}
				}
			}
		}
		
		if (is_array($IN->GBL('ct_items', 'POST')))
		{
			foreach ($IN->GBL('ct_items', 'POST') as $ct_items)
			{
				$items = $IN->GBL($ct_items, 'POST');
				
				if ($items && is_array($items))
				{
					$items = array_merge($items);
					
					$_POST[$ct_items] = addslashes(serialize($items));
					
					foreach ($_POST as $key => $value)
					{
						if (preg_match('/^'.$ct_items.'_/', $key))
						{
							unset($_POST[$key]);
						}
					}
				}
			}
		}
		
		if (is_array($IN->GBL('ct_price_mod', 'POST')))
		{
			foreach ($IN->GBL('ct_price_mod', 'POST') as $ct_price_mod)
			{
				$items = $IN->GBL($ct_price_mod, 'POST');
				
				if ($items && is_array($items))
				{
					$items = array_merge($items);
					
					$temp = '';
					
					foreach ($items as $item)
					{
						$temp .= implode('', $item);
					}
					
					if ($temp)
					{
						$_POST[$ct_price_mod] = addslashes(serialize($items));
					}
					else
					{
						$_POST[$ct_price_mod] = '';
					}
					
					foreach ($_POST as $key => $value)
					{
						if (preg_match('/^'.$ct_price_mod.'_/', $key))
						{
							unset($_POST[$key]);
						}
					}
				}
			}
		}
		if (is_array($IN->GBL('ct_matrix_pq', 'POST')))
		{
			foreach ($IN->GBL('ct_matrix_pq', 'POST') as $ct_price_mod)
			{
				$items = $IN->GBL($ct_price_mod, 'POST');
				
				if ($items && is_array($items))
				{
					$items = array_merge($items);
					
					$temp = '';
					
					foreach ($items as $item)
					{
						$temp .= implode('', $item);
					}
					
					if ($temp)
					{
						$_POST[$ct_price_mod] = addslashes(serialize($items));
					}
					else
					{
						$_POST[$ct_price_mod] = '';
					}
					
					foreach ($_POST as $key => $value)
					{
						if (preg_match('/^'.$ct_price_mod.'_/', $key))
						{
							unset($_POST[$key]);
						}
					}
				}
			}
		}
	}
	// END
	
	// --------------------------------
	//  Clear Cart On Logout
	// --------------------------------
	/**
	 * Doesn't do anything other than call the member_member_logout hook access function.
	 *
	 * @todo Should probably be deprecated unless other functionality is assigned to it. 
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function clear_cart_on_logout()
	{
		$this->member_member_logout();
	}
	// END
	
	// --------------------------------
	//  Member Logout Hook Access
	// --------------------------------
	/**
	 * Perform additional actions after logout
	 *
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @see http://expressionengine.com/developers/extension_hooks/member_member_logout/
	 */
	function member_member_logout()
	{
		if ($this->settings['clear_cart_on_logout'])
		{
			$this->_load_cart();
			
			$this->CART->clear_cart();
		}
	}
	// END

	// --------------------------------
	//  Show Full Control Panel End Hook Access
	// --------------------------------
	/**
	 * Rewrite CP's HTML, Find/Replace Stuff, etc.
	 *
	 * @access public
	 * @param string $out the content of the admin page to be outputted
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez 
	 * @see http://expressionengine.com/developers/extension_hooks/show_full_control_panel_end/
	 */
	function show_full_control_panel_end($out)
	{
		global $DB, $EXT;
		
		if ($EXT->last_call !== FALSE)
		{
			$out = $EXT->last_call;
		}
		if (preg_match_all('/C=admin&amp;M=blog_admin&amp;P=edit_field&amp;field_id=(\d*).*?<\/td>.*?<td.*?>.*?<\/td>.*?<\/td>/is', $out, $matches))
		{
			foreach($matches[1] as $key => $value)
			{
				$query = $DB->query("SELECT field_type
							FROM exp_weblog_fields
							WHERE field_id='".$value."'
							LIMIT 1");
				
				if ($query->row['field_type'] == 'ct_coupon')
				{
					$replace = preg_replace("/(<td.*?<td.*?>).*?<\/td>/si", "$1CartThrob Coupon/Discount Settings</td>", $matches[0][$key]);
					$out = str_replace($matches[0][$key], $replace, $out);
				}
				elseif ($query->row['field_type'] == 'ct_items')
				{
					$replace = preg_replace("/(<td.*?<td.*?>).*?<\/td>/si", "$1CartThrob Order Items</td>", $matches[0][$key]);
					$out = str_replace($matches[0][$key], $replace, $out);
				}
				elseif ($query->row['field_type'] == 'ct_price_mod')
				{
					$replace = preg_replace("/(<td.*?<td.*?>).*?<\/td>/si", "$1CartThrob Price Modifiers</td>", $matches[0][$key]);
					$out = str_replace($matches[0][$key], $replace, $out);
				}
				elseif (preg_match('/^ct_matrix_?(.*)/', $query->row['field_type'], $match))
				{
					$suffix = ( ! empty($match[1])) ? ' '. strtoupper($match[1]) : '';
					$replace = preg_replace("/(<td.*?<td.*?>).*?<\/td>/si", "$1CartThrob Matrix$suffix</td>", $matches[0][$key]);
					$out = str_replace($matches[0][$key], $replace, $out);
				}
			}
		}
		return $out;
	}
	// END
	
	// --------------------------------
	//  Publish Admin Edit Field Type Pulldown Hook Access
	// --------------------------------
	/**
	 * Allows modifying or adding onto Custom Weblog Field Type Pulldown
	 * @access public
	 * @param array $data The data about this field from the database
	 * @param string $typemenu  The current contents of the type menu
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez 
	 * @see http://expressionengine.com/developers/extension_hooks/publish_admin_edit_field_type_pulldown/
	 */
	function publish_admin_edit_field_type_pulldown($data, $typemenu)
	{
		global $EXT, $DSP;
		
		$typemenu = ($EXT->last_call !== FALSE) ? $EXT->last_call : $typemenu;
		
		$typemenu .= $DSP->input_select_option('ct_coupon', 'CartThrob Coupon/Discount Settings', ($data['field_type'] == 'ct_coupon') ? 1 : 0);
		$typemenu .= $DSP->input_select_option('ct_items', 'CartThrob Order Items', ($data['field_type'] == 'ct_items') ? 1 : 0);
		$typemenu .= $DSP->input_select_option('ct_price_mod', 'CartThrob Price Modifiers', ($data['field_type'] == 'ct_price_mod') ? 1 : 0);
		$typemenu .= $DSP->input_select_option('ct_matrix_pq', 'CartThrob Price Quantity Thresholds', ($data['field_type'] == 'ct_matrix_pq') ? 1 : 0);
		
		//$typemenu .= $DSP->input_select_option('ct_matrix', 'CartThrob Matrix', ($data['field_type'] == 'ct_matrix') ? 1 : 0);
		
		return $typemenu;
	}
	// END
	
	function publish_admin_edit_field_format($data, $y)
	{
		global $EXT, $DSP, $LANG;
		
		if ($EXT->last_call !== FALSE)
		{
			$y = $EXT->last_call;
		}
		
		if (in_array($data['field_type'], array('ct_coupon','ct_items','ct_price_mod')) || preg_match('/^ct_matrix/', $data['field_type']))
		{
			$y = $DSP->input_hidden('field_fmt', 'none');
			$y .= '<div id="formatting_unavailable" style="padding:0; margin:0 0 0 0;">';
			$y .= $DSP->qdiv('highlight', $LANG->line('formatting_no_available'));
			$y .= $DSP->div_c();
		}

		return $y;
	}
	
	function publish_admin_edit_field_js($data, $js)
	{
		$extra_js = '
			if (id.match(/^ct_/))
			{
				document.getElementById(\'formatting_block\').style.display = "none";		
				document.getElementById(\'formatting_unavailable\').style.display = "block";
				document.getElementById(\'direction_available\').style.display = "none";
				document.getElementById(\'direction_unavailable\').style.display = "block";
			}
		';
		
		return preg_replace("/function showhide_element\(id\)\s*\{/", '\0'.$extra_js, $js);
	}
	
	// --------------------------------
	//  Publish Form Field Unique Hook Access
	// --------------------------------
	/**
	 * Allows adding of unique custom fields via extensions
	 * 
	 * @todo document text_direction parameter. document the format of field_data (not sure if it's correct)
	 * @access public
	 * @param array $row Parameters for the field from the database
	 * @param array $field_data If entry is not new, this will have field's current value
	 * @param 
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez 
	 * @see http://expressionengine.com/developers/extension_hooks/publish_form_field_unique/
	 */
	function publish_form_field_unique($row, $field_data, $text_direction)
	{
		global $EXT, $DSP, $IN;
		
		$output = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';
		
		if ($row['field_type'] == 'ct_coupon')
		{
			$output .= $this->_field_coupon_code($row, $field_data);
		}
		elseif ($row['field_type'] == 'ct_items')
		{
			$output .= $this->_field_matrix($row, $field_data, $row['field_type']);
		}
		elseif ($row['field_type'] == 'ct_price_mod')
		{
			$field_data = ($field_data) ? $this->_unserialize($field_data) : array();
			/*
			$output .= $DSP->qdiv('tableHeading', 'Option Name (lowercase a-z and underscore only), ie. size, color, personal_message, etc.');
			$output .= $DSP->qdiv('box', $DSP->input_text('field_id_'.$row['field_id'].'[option_name]', isset($field_data['option_name']) ? $field_data['option_name'] : ''));
			$output .= $DSP->qdiv('tableHeading', 'Option Label (optional)');
			$output .= $DSP->qdiv('box', $DSP->input_text('field_id_'.$row['field_id'].'[option_label]', isset($field_data['option_label']) ? $field_data['option_label'] : ''));
			*/
			$default_fields = array(array('option'=>'','option_name'=>'','price'=>''));
			
			if ($IN->GBL('weblog_id') && isset($this->settings['product_weblog_fields'][$IN->GBL('weblog_id')]['inventory']) && $this->settings['product_weblog_fields'][$IN->GBL('weblog_id')]['inventory'] == $row['field_id'])
			{
				$default_fields[0]['inventory'] = '';
			}
			
			if ($IN->GBL('weblog_id') && ! empty($this->settings['product_weblog_fields'][$IN->GBL('weblog_id')]['inventory']) && $this->settings['product_weblog_fields'][$IN->GBL('weblog_id')]['inventory'] != $row['field_id'])
			{
				foreach ($field_data as $index => $price_mod)
				{
					unset($field_data[$index]['inventory']);
				}
			}
			
			if ($IN->GBL('weblog_id') && ! empty($this->settings['product_weblog_fields'][$IN->GBL('weblog_id')]['inventory']) && $this->settings['product_weblog_fields'][$IN->GBL('weblog_id')]['inventory'] == $row['field_id'])
			{
				foreach ($field_data as $index => $price_mod)
				{
					if ( ! isset($field_data[$index]['inventory']))
					{
						$field_data[$index]['inventory'] = '';
					}
				}
			}
			
			$output .= $this->_field_matrix($row, ! empty($field_data) ? $field_data : NULL, $row['field_type'], TRUE, $default_fields);
		}
		elseif ($row['field_type'] == 'ct_matrix')
		{
			$output .= $this->_field_matrix($row, $field_data, $row['field_type']);
		}
		elseif ($row['field_type'] == 'ct_matrix_pq')
		{

			$default_fields = array(array('from_quantity'=>'','up_to_quantity'=>'','price'=>''));
			
			$output .= $this->_field_matrix($row, ! empty($field_data) ? $field_data : NULL, $row['field_type'], TRUE, $default_fields);
		}
		
		return $output;
	}
	// END 
	
	// --------------------------------
	//  Field Coupon Code
	// --------------------------------
	/**
	 * Creates a coupon code field. Adds jquery to the page to control the dropdown menu
	 * 
	 * @access private
	 * @param array $row Parameters for the field from the database
	 * @param array $field_data If entry is not new, this will have field's current value
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez 
	 * @version jQuery document ready changed at 0.9.80
	 */	
	function _field_coupon_code($row, $field_data)
	{
		global $DSP;
		
		$plugin_path = PATH_MOD.'cartthrob/coupon_code_plugins/';
		
		$field_name = 'field_id_'.$row['field_id'];
		
		$settings = $this->_get_settings();
		$is_coupon = TRUE; 
		
		if (!empty($settings['discount_type']) && $row['field_id'] == $settings['discount_type'])
		{
			$is_coupon = FALSE; 
		}
		
		$field_data = $this->_unserialize($field_data);
		
		$handle = opendir($plugin_path);
		
		while ($file = readdir($handle))
		{
			if (preg_match('/^cartthrob/', $file))
			{
				$plugin_info = FALSE;
				
				include($plugin_path.$file);
				
				if (is_array($plugin_info))
				{ 
					$plugins[$plugin_info['type']] = $plugin_info['title'];
					
					$fields[$plugin_info['type']] = $plugin_info['settings'];
				}
			}
		}
		
		$current_type = (isset($field_data['type'])) ? $field_data['type'] : '';
		asort($plugins); 
		
		$output = '<div class="cartthrob_coupon_code_plugin_select">';
		$output .= $DSP->input_hidden('ct_coupon[]', $field_name);
		$output .= $DSP->input_select_header($field_name.'[type]');
		foreach ($plugins as $key => $value)
		{
			$output .= $DSP->input_select_option($key, $value, ($key == $current_type) ? 1 : 0);
		}
		$output .= $DSP->input_select_footer();
		
		foreach ($fields as $type => $settings)
		{
			$settings[] = array(
				'type' => 'textarea',
				'short_name' => 'used_by',
				'name' => 'Redeemed By',
				'note' => 'A pipe delimited list of member_id\'s of users who have used this coupon code/discount.',
				'hidden' => TRUE
			);

			$settings[] = array(
				'type' => 'text',
				'short_name' => 'per_user_limit',
				'name' => 'Per User Limit',
				'note' => 'How many times can this be used per customer? Leave blank for no limit.',
				'size' => '50px',
				'hidden' => TRUE
			);
			$settings[] = array(
				'type' => 'text',
				'short_name' => 'coupon_limit',
				'name' => 'Global Coupon Limit',
				'note' => 'How many times can this be used overall? Leave blank for no limit.',
				'size' => '50px',
				'hidden' => TRUE
			);
			$settings[] = array(
				'type' => 'text',
				'short_name' => 'member_groups',
				'name' => 'Limit By Member Group',
				'note' => 'Which member groups can use this? Enter a list of list of group_id\'s, separated by comma. Leave blank for no limit.',
				'hidden' => TRUE
			);
			
			$settings[] = array(
				'type' => 'text',
				'short_name' => 'member_ids',
				'name' => 'Limit By Member ID',
				'note' => 'Which members can use this? Enter a list of member_id\'s, separated by comma. Leave blank for no limit.',
				'hidden' => TRUE
			);
			
			$output .= '<input type="hidden" class="cartthrob_coupon_code_settings_has_settings_'.$type.'" value="'.count($settings).'" />';
			//$output .= '<div class="cartthrob_coupon_code_plugin_settings cartthrob_coupon_code_plugin_settings_'.$type.'" style="padding: 5px 0 3px; border-top: 1px solid #fff;';
			
			$i = 0;
			
			$style = ($current_type !== $type) ? 'display:none;' : '';
			
			//$output .= $DSP->table('tableBorder cartthrob_coupon_code_plugin_settings cartthrob_coupon_code_plugin_settings_'.$type, '0', '10', '100%');
			
			$output .= '<table border="0" cellspacing="0" cellpadding="10" style="width:500px;margin-top:10px;'.$style.'" class="tableBorder cartthrob_coupon_code_plugin_settings cartthrob_coupon_code_plugin_settings_'.$type.'">';
			
			$output .= $DSP->tr().$DSP->td('tableHeading', '', '1').'Coupon/Discount Settings'.$DSP->td_c().$DSP->tr_c();
			
			foreach ($settings as $setting)
			{
				$style = ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo';
				
				$image = ( ! empty($setting['hidden'])) ? 'expand' : 'collapse';
				
				if ($setting['type'] != 'hidden')
				{
					$output .= $DSP->tr();
					
					$output .= $DSP->td($style, '30%', '', '', 'top');
					$output .= $DSP->qdiv('subSettingInstructions', $DSP->qspan('defaultBold', $DSP->anchor('#', '<img src="'.PATH_CP_IMG.$image.'.gif" border="0" width="10" height="10" />&nbsp;'.$setting['name'], ' class="ct_colexp ct_'.$image.'"')).$DSP->qspan('default', ' '.@$setting['note']));
					
					$output .= (empty($setting['hidden'])) ? $DSP->div() : '<div style="display:none;">';
					
					/*
					$output .= $DSP->div('itemWrapper');
					$output .= '<img src="'.PATH_CP_IMG.'collapse.gif" border="0" width="10" height="10" /><label><a href="javascript:void(0);"><b>'.NBS.NBS.$setting['name'].'</b></a></label>';
					$output .= (isset($setting['note'])) ? $DSP->qdiv('paddedWrapper', $DSP->qspan('defaultBold', 'Instructions: ').$setting['note']) : '';
					$output .= $DSP->div_c();
					*/
				}
				else
				{
					$output .= '<tr style="display:none;">';
					$output .= $DSP->td();
					$output .= $DSP->div();
				}
				
				//retrieve the current set value of the field
				$current_value = (isset($field_data[$setting['short_name']])) ? $field_data[$setting['short_name']] : NULL;
				
				//set the value to the default value if there is no set value and the default value is defined
				$current_value = ($current_value === NULL && isset($setting['default'])) ? $setting['default'] : $current_value;
				
				$size = (isset($setting['size'])) ? $setting['size'] : '100%';
				
				switch ($setting['type'])
				{
					case 'text':
						$output .= $DSP->input_text($field_name.'['.$setting['short_name'].']', $current_value, '20', '255', 'input', $size, '', TRUE);
						break;
					case 'textarea':
						$output .= $DSP->input_textarea($field_name.'['.$setting['short_name'].']', $current_value, '3', 'input textarea', $size, '', TRUE);
						break;
					case 'hidden':
						$output .= $DSP->input_hidden($field_name.'['.$setting['short_name'].']', $current_value);
						break;
					case 'select':
						$output .= $DSP->input_select_header($field_name.'['.$setting['short_name'].']');
						if (array_values($setting['options']) === $setting['options'])
						{
							foreach($setting['options'] as $value)
							{
								$output .= $DSP->input_select_option($value, $value, ($current_value == $value) ? 1 : 0);
							}
						}
						//if associative array
						else
						{
							foreach($setting['options'] as $key => $value)
							{
								$output .= $DSP->input_select_option($key, $value, ($current_value == $key) ? 1 : 0);
							}
						}
						$output .= $DSP->input_select_footer();
						break;
					case 'radio':
						if (!isset($setting['options']) || !is_array($setting['options']))
						{
							$output .= '<label>'.$DSP->input_radio($field_name.'['.$setting['short_name'].']', 1, $current_value).'Yes</label>';
							$output .= '<label>'.$DSP->input_radio($field_name.'['.$setting['short_name'].']', 0, ! $current_value).'No</label>';
						}
						else
						{
							//if is index array
							if (array_values($setting['options']) === $setting['options'])
							{
								foreach($setting['options'] as $value)
								{
									$output .= '<label>'.$DSP->input_radio($field_name.'['.$setting['short_name'].']', $value, ($current_value == $value)).$value.'</label>';
								}
							}
							//if associative array
							else
							{
								foreach($setting['options'] as $key=>$value)
								{
									$output .= '<label>'.$DSP->input_radio($field_name.'['.$setting['short_name'].']', $key, ($current_value == $value)).$value.'</label>';
								}
							}
						}
						break;
					default:
				}
				
				$output .= $DSP->div_c();
				$output .= $DSP->td_c();
				$output .= $DSP->tr_c();
			}
			
			//$output .= $DSP->div_c();
			
			$output .= $DSP->table_c();
		}
		
		$output .= '
		<script type="text/javascript">
		//<![CDATA[
		jQuery(document).ready(function($){
			$(".cartthrob_coupon_code_plugin_select").find("select").bind("change", function() {
				$(".cartthrob_coupon_code_plugin_settings").hide().find(":input").attr("disabled","disabled");
				if ($(".cartthrob_coupon_code_settings_has_settings_"+$(this).val()).val() != "0")
				{
					$(".cartthrob_coupon_code_plugin_settings_"+$(this).val()).show().find(":input").attr("disabled","");
				}
			}).change();
			$(".ct_colexp").click(function(){
				if ($(this).hasClass("ct_collapse"))
				{
					$(this).removeClass("ct_collapse").addClass("ct_expand");
					$(this).find("img").attr("src", "'.PATH_CP_IMG.'expand.gif");
					$(this).parent().parent().next().slideUp();
				}
				else
				{
					$(this).removeClass("ct_expand").addClass("ct_collapse");
					$(this).find("img").attr("src", "'.PATH_CP_IMG.'collapse.gif");
					$(this).parent().parent().next().slideDown();
				}
				return false;
			});
		});
		//]]>
		</script>
		<style type="text/css">
		a.ct_colexp:hover {
			text-decoration: none;
		}
		.subSettingInstructions {
			margin-bottom: 6px;
		}
		</style>
		';

		return $output;
	}
	// END
	
	// --------------------------------
	//  Field Items
	// --------------------------------
	/**
	 * Unserializes item configuration data, and outputs a table formatted with custom keys & product data
	 * Used on the Ordered items field in the Orders weblog
	 * 
	 * @todo make editable
	 * @todo what makes something a cp_call?!?!?
	 * @access private
	 * @param array $row Parameters for the field from the database
	 * @param array $field_data If entry is not new, this will have field's current value
	 * @param 		$field_type
	 * @param bool $cp_call
	 * @return string
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _field_matrix($row, $field_data, $field_type, $cp_call = TRUE, $default_data = array(), $field_name_suffix = '')
	{
		global $DSP, $PREFS, $SESS;
		
		$output = '';
		
		if ( ! $field_data && $default_data)
		{
			$field_data = $default_data;
		}
		
		if ( ! $field_data)
		{
			return ($cp_call) ? '<p>No items.</p>' : '';
		}
		
		if ( ! is_array($field_data))
		{
			$field_data = $this->_unserialize($field_data);
		}
		
		if ( ! count($field_data))
		{
			return ($cp_call) ? '<p>No items.</p>' : '';
		}
		
		reset($field_data);
		
		$headers = array();
		
		$header_row = array();
		
		foreach ($field_data as $field_row)
		{
			foreach ($field_row as $key => $value)
			{
				if ( ! in_array($key, $headers))
				{
					$headers[] = $key;
					
					if ($cp_call)
					{
						$header_row[] = array(
							'text' => $key,
							'class' => 'tableHeading'
						);
					}
					else
					{
						$header_row[] = array('text' => $key);
					}
				}
			}
		}
		
		if (count($header_row) && $cp_call)
		{
			end($header_row);
			$header_row[key($header_row)]['colspan'] = '2';
		}
		
		if (isset($row['field_id']))
		{
			$output .= $DSP->input_hidden($field_type.'[]', 'field_id_'.$row['field_id']);
		}
		
		if ($cp_call)
		{
			$output .= $DSP->table_open(
				array(
					'border' => '0',
					'cellspacing' => '0',
					'cellpadding' => '0',
					'style' => 'width:100%;',
					'class' => 'tableBorder'
				)
			);
		}
		else
		{
			$output .= $DSP->table_open(
				array(
					'border' => '1',
					'cellspacing' => '1',
					'cellpadding' => '1',
				)
			);
		}
		
		$output .= "<thead>\n";
		
		$output .= $DSP->table_row($header_row);
		
		$output .= "</thead>\n<tbody>\n";
		
		$switch = 1;
		
		foreach ($field_data as $index => $field_row)
		{
			$table_row = array();
			
			foreach ($headers as $header)
			{
				$field_row_data = (isset($field_row[$header])) ? $field_row[$header] : '';
				
				if ($cp_call)
				{
					if ( ! preg_match('/[\r\n]/', $field_row_data))
					{
						$table_row[] = array(
							'text' => $DSP->input_text('field_id_'.$row['field_id'].$field_name_suffix.'['.$index.']['.$header.']', $field_row_data),
							'class' => ($switch) ? 'tableCellOne' : 'tableCellTwo'
						);
					}
					else
					{
						$table_row[] = array(
							'text' => $DSP->input_textarea('field_id_'.$row['field_id'].$field_name_suffix.'['.$index.']['.$header.']', $field_row_data, 3),
							'class' => ($switch) ? 'tableCellOne' : 'tableCellTwo'
						);
					}
				}
				else
				{
					$table_row[] = array('text' => $field_row_data);
				}
			}
			
			if ($cp_call)
			{
				$table_row[] = array(
					'text' => '<a href="#" onclick="ct_matrix_remove_row(this); return false;"><img border="0" src="'.$PREFS->ini('theme_folder_url').'cp_themes/'.$PREFS->ini('cp_theme').'/cartthrob/images/ct_help_close_x.gif" /></a>',
					'class' => ($switch) ? 'tableCellOne' : 'tableCellTwo'
				);
			}
			
			$switch = ($switch) ? 0 : 1;
			
			$output .= str_replace('<tr>', '<tr id="row_index_'.$index.'">', $DSP->table_row($table_row));
		}
		
		$output .= "</tbody>\n";
		
		$output .= $DSP->table_close();
		
		if ($cp_call)
		{
			$output .= '<p><a href="#" onclick="ct_matrix_add_row(this, \'field_id_'.$row['field_id'].$field_name_suffix.'\'); return false;">Add Row</a></p>';
			
			if (empty($SESS->cache['cartthrob']['ct_matrix_js']))
			{
				$output .= '
				<script type="text/javascript">
				var ct_matrix_blank_row = {};
				function ct_matrix_remove_row(obj)
				{
					if (confirm(\'Are you sure you want to remove this row?\'))
					{
						$(obj).parent().parent().remove();
					}
				}
				function ct_matrix_add_row(obj, field_id)
				{
					var last_row = $(obj).parent().prev("table").children("tbody").children("tr:last");
					var index = (last_row.length > 0) ? parseInt(last_row.attr("id").replace("row_index_","")) + 1 : 0;
					var blank_row = ct_matrix_blank_row[field_id];
					$(obj).parent().prev("table").children("tbody").append(blank_row.replace(/INDEX/g, index));
					$(obj).parent().prev("table").children("tbody").children("tr:last").attr("id", "row_index_"+index).find("input").attr("disabled","");
					if (last_row.length > 0)
					{
						$(obj).parent().prev("table").children("tbody").children("tr:last").children("td").attr("class", (last_row.children("td").attr("class") == "tableCellOne") ? "tableCellTwo" : "tableCellOne");
					}
				}
				</script>
				';
				
				$SESS->cache['cartthrob']['ct_matrix_js'] = TRUE;
			}
			
			$table_row = array();
			
			foreach ($headers as $header)
			{
				$table_row[] = array(
					'text' => $DSP->input_text('field_id_'.$row['field_id'].$field_name_suffix.'[INDEX]['.$header.']', '', '90', '100', 'input', '100%', 'disabled="disabled"'),
					'class' => ($switch) ? 'tableCellOne' : 'tableCellTwo'
				);
			}
			
			$table_row[] = array(
				'text' => '<a href="#" onclick="ct_matrix_remove_row(this); return false;"><img border="0" src="'.$PREFS->ini('theme_folder_url').'cp_themes/'.$PREFS->ini('cp_theme').'/cartthrob/images/ct_help_close_x.gif" /></a>',
				'class' => ($switch) ? 'tableCellOne' : 'tableCellTwo'
			);
			
			$blank_row = preg_replace('/[\r\n]/', '', str_replace("'", '"', $DSP->table_row($table_row)));
			
			$output .= '
			<script type="text/javascript">
			ct_matrix_blank_row[\'field_id_'.$row['field_id'].$field_name_suffix.'\'] = \''.$blank_row.'\';
			</script>
			';
		}
		
		return $output;
	}
	// END
	
	// --------------------------------
	//  Load Cart
	// --------------------------------
	/**
	 * Creates a new cart object. Requires module to be installed
	 * 
	 * @access private
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _load_cart()
	{
		global $OUT, $LANG;
		
		if ( ! is_object($this->CART) || ucfirst(get_class($this->CART)) != 'Cartthrob')
		{
			if (!class_exists('Cartthrob'))
			{
				if (file_exists(PATH_MOD.'cartthrob/mod.cartthrob'.EXT))
				{
					require PATH_MOD.'cartthrob/mod.cartthrob'.EXT;
				}
				else
				{
					exit($OUT->show_user_error('general', $LANG->line('no_cartthrob_plugin')));
				}
			}
	
			$this->CART = new Cartthrob();
		}
	}
	// END
	
	// --------------------------------
	//  Plugin Settings
	// --------------------------------
	/**
	 * Creates setting controls
	 * 
	 * @access private
	 * @param string $type text|textarea|radio The type of control that is being output
	 * @param string $name input name of the control option
	 * @param string $current_value the current value stored for this input option
	 * @param array|bool $options array of options that will be output (for radio, else ignored) 
	 * @return string the control's HTML 
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _plugin_setting($type, $name, $current_value, $options = array(), $width = FALSE)
	{
		global $DSP, $LANG;

		$output = '';
		
		if ( ! is_array($options))
		{
			$options = array();
		}

		switch ($type)
		{
			case 'select':
				$output .= $DSP->input_select_header($name, FALSE, FALSE, $width);
				foreach ($options as $option => $option_name)
				{
					$output .= $DSP->input_select_option($option, $option_name, ($option == $current_value) ? 1 : 0);
				}
				$output .= $DSP->input_select_footer();
				break;
			case 'multiselect':
				$output .= $DSP->input_select_header($name, 1, (count($options) > 5) ? 5 : count($options));
				foreach ($options as $option => $option_name)
				{
					$output .= $DSP->input_select_option($option, $option_name, ($current_value == $option) ? 1 : 0);
				}
				$output .= $DSP->input_select_footer();
				break;
			case 'checkbox':
				if ( ! empty($options['label']))
				{
					$output .= '<label>'.$DSP->input_checkbox($name, 1, $current_value, isset($options['extra']) ? $options['extra'] : '').'&nbsp;'.$options['label'].'</label>';
				}
				else
				{
					$output .= $DSP->input_checkbox($name, 1, $current_value, isset($options['extra']) ? $options['extra'] : '');
				}
				break;
			case 'text':
				$output .= $DSP->input_text($name, $current_value, '', '', 'input', $width, '', TRUE);
				break;
			case 'textarea':
				$output .= $DSP->input_textarea($name, $current_value, '6', 'input textarea', $width, '', TRUE);
				break;
			case 'radio':
				if (empty($options))
				{
					$output .= '<label class="radio">'.$DSP->input_radio($name, 1, ($current_value) ? 1 : 0).$LANG->line('yes').'</label>';
					$output .= '<label class="radio">'.$DSP->input_radio($name, 0, ( ! $current_value) ? 1 : 0).$LANG->line('no').'</label>';
				}
				else
				{
					//if is index array
					if (array_values($options) === $options)
					{
						foreach($options as $option)
						{
							$output .= '<label class="radio">'.$DSP->input_radio($name, $option, ($current_value == $option) ? 1 : 0).$option.'</label>';
						}
					}
					//if associative array
					else
					{
						foreach($options as $option => $option_name)
						{
							$output .= '<label class="radio">'.$DSP->input_radio($name, $option, ($current_value == $option) ? 1 : 0).$option_name.'</label>';
						}
					}
				}
				break;
			default:
		}
		return $output;
	}
	// END 
	
	// --------------------------------
	//  Settings Form
	// --------------------------------
	/**
	 * Extension Settings Page Form creator, hook access
	 *
	 * Sets up all menus and views for the extension settings page. Sets some basic settings. Stores the countries / states array list.
	 * 
	 * @todo What is content of "CURRENT" param
	 * @access public
	 * @param string $current
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez, Chris Newton
	 */
	function settings_form($current)
	{
		global $DSP, $IN, $REGX, $LANG, $PREFS, $DB, $OUT, $EXT;
		
		$vars = array();
		
		$settings = $this->_get_settings();
		
		if ($IN->GBL('install_templates'))
		{
			$this->_parse_xml($this->_template_xml(), $IN->GBL('templates', 'POST'));
			
			$query = $DB->query("SELECT * FROM exp_weblogs WHERE blog_name IN ('products','orders','purchased_items')");
			
			$weblogs = $query->result;
			
			unset($query);

			foreach ($weblogs as $weblog)
			{
				$sql = "SELECT *
					FROM exp_weblog_fields
					WHERE group_id = '".$DB->escape_str($weblog['field_group'])."'";
				
				if (isset($EXT->OBJ['Gypsy']))
				{
					$sql .= " OR (field_is_gypsy = 'y'
						AND gypsy_weblogs LIKE '% ".$weblog['weblog_id']." %')";
				}
				
				$query = $DB->query($sql);
				
				if ($weblog['blog_name'] == 'products')
				{
					$settings['product_weblogs'] = array($weblog['weblog_id']);
				
					foreach ($query->result as $field)
					{
						switch($field['field_name'])
						{
							case 'product_price':
								$settings['product_weblog_fields'][$weblog['weblog_id']]['price'] = $field['field_id'];
								break;
							case 'product_shipping':
								$settings['product_weblog_fields'][$weblog['weblog_id']]['shipping'] = $field['field_id'];
								break;
							case 'product_weight':
								$settings['product_weblog_fields'][$weblog['weblog_id']]['weight'] = $field['field_id'];
								break;
							case 'product_size':
								$settings['product_weblog_fields'][$weblog['weblog_id']]['price_modifiers'] = array($field['field_id']);
								break;
						}
					}
				}
				
				if ($weblog['blog_name'] == 'orders')
				{
					$settings['orders_weblog'] = $weblog['weblog_id'];
				
					foreach ($query->result as $field)
					{
						switch($field['field_name'])
						{
							case 'order_items':
								$settings['orders_items_field'] = $field['field_id'];
								break;
							case 'order_subtotal':
								$settings['orders_subtotal_field'] = $field['field_id'];
								break;
							case 'order_tax':
								$settings['orders_tax_field'] = $field['field_id'];
								break;
							case 'order_shipping':
								$settings['orders_shipping_field'] = $field['field_id'];
								break;
							case 'order_total':
								$settings['orders_total_field'] = $field['field_id'];
								break;
							case 'order_transaction_id':
								$settings['orders_transaction_id'] = $field['field_id'];
								break;
							case 'order_last_four':
								$settings['orders_last_four_digits'] = $field['field_id'];
								break;
							case 'order_coupons':
								$settings['orders_coupon_codes'] = $field['field_id'];
								break;
							case 'order_customer_email':
								$settings['orders_customer_email'] = $field['field_id'];
								break;
							case 'order_customer_phone':
								$settings['orders_customer_phone'] = $field['field_id'];
								break;
							case 'order_billing_first_name':
								$settings['orders_billing_first_name'] = $field['field_id'];
								break;
							case 'order_billing_last_name':
								$settings['orders_billing_last_name'] = $field['field_id'];
								break;
							case 'order_billing_address':
								$settings['orders_billing_address'] = $field['field_id'];
								break;
							case 'order_billing_address2':
								$settings['orders_billing_address2'] = $field['field_id'];
								break;
							case 'order_billing_city':
								$settings['orders_billing_city'] = $field['field_id'];
								break;
							case 'order_billing_state':
								$settings['orders_billing_state'] = $field['field_id'];
								break;
							case 'order_billing_zip':
								$settings['orders_billing_zip'] = $field['field_id'];
								break;
							case 'order_shipping_first_name':
								$settings['orders_shipping_first_name'] = $field['field_id'];
								break;
							case 'order_shipping_last_name':
								$settings['orders_shipping_last_name'] = $field['field_id'];
								break;
							case 'order_shipping_address':
								$settings['orders_shipping_address'] = $field['field_id'];
								break;
							case 'order_shipping_address2':
								$settings['orders_shipping_address2'] = $field['field_id'];
								break;
							case 'order_shipping_city':
								$settings['orders_shipping_city'] = $field['field_id'];
								break;
							case 'order_shipping_state':
								$settings['orders_shipping_state'] = $field['field_id'];
								break;
							case 'order_shipping_zip':
								$settings['orders_shipping_zip'] = $field['field_id'];
								break;
							case 'order_shipping_option':
								$settings['orders_shipping_option'] = $field['field_id'];
								break;
							case 'order_error_message':
								$settings['orders_error_message_field'] = $field['field_id'];
								break;
						}
					}
				}
				
				if ($weblog['blog_name'] == 'purchased_items')
				{
					$settings['purchased_items_weblog'] = $weblog['weblog_id'];
				
					foreach ($query->result as $field)
					{
						switch($field['field_name'])
						{
							case 'purchased_id':
								$settings['purchased_items_id_field'] = $field['field_id'];
								break;
							case 'purchased_quantity':
								$settings['purchased_items_quantity_field'] = $field['field_id'];
								break;
							case 'purchased_price':
								$settings['purchased_items_price_field'] = $field['field_id'];
								break;
							case 'purchased_order_id':
								$settings['purchased_items_order_id_field'] = $field['field_id'];
								break;
						}
					}
				}
			}
			
			$all_settings = $this->_get_settings(TRUE);
			
			$all_settings[$PREFS->ini('site_id')] = $settings;
			
			$query = $DB->query($DB->update_string('exp_extensions', array('settings' => addslashes(serialize($all_settings))), array('class' => $this->classname)));
		}
		
		if ($IN->GBL('export_settings'))
		{
			$this->_export_settings();
		}

		if ( ! class_exists('Cartthrob'))
		{
			if (file_exists(PATH_MOD.'cartthrob/mod.cartthrob'.EXT))
			{
				require_once(PATH_MOD.'cartthrob/mod.cartthrob'.EXT);
			}
			else
			{
				return $OUT->show_user_error('general', $LANG->line('no_cartthrob_plugin'));
			}
		}
		
		$query = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = '".$PREFS->ini('site_id')."' ORDER BY blog_title ASC");
		
		$weblogs = $query->result;
		
		unset($query);
		
		$fields = array();
		
		$weblog_titles = array();
		
		$statuses = array();
		
		foreach ($weblogs as $weblog)
		{
			$weblog_titles[$weblog['weblog_id']] = $weblog['blog_title'];
			$sql = "SELECT *
				FROM exp_weblog_fields
				WHERE group_id = '".$DB->escape_str($weblog['field_group'])."'";
			
			if (isset($EXT->OBJ['Gypsy']))
			{
				$sql .= " OR (field_is_gypsy = 'y'
					AND gypsy_weblogs LIKE '% ".$weblog['weblog_id']." %')";
			}
			
			$sql .= " ORDER BY field_label ASC";
			
			$query = $DB->query($sql);
			//$query = $DB->query("SELECT * FROM exp_weblog_fields WHERE group_id='".$weblog['field_group']."' ORDER BY field_label ASC");
			$fields[$weblog['weblog_id']] = $query->result;
			$query = $DB->query("SELECT * FROM exp_statuses WHERE group_id = '".$weblog['status_group']."'");
			$statuses[$weblog['weblog_id']] = $query->result;
		}
		
		$query = $DB->query("SELECT * FROM exp_member_fields ORDER BY m_field_label ASC"); 
		$member_fields = $query->result; 
		unset($query); 
		
		$nav = array(
			'Global Settings' => array(
				'get_started' => $LANG->line('nav_get_started'),
				'license_number' => $LANG->line('nav_license_number'),
				'install_blogs' => $LANG->line('nav_install_blogs'),
				'import_export_settings' => $LANG->line('nav_import_export_settings'),
				'general_settings' => $LANG->line('nav_general_settings'),
				'number_format_defaults' => $LANG->line('nav_number_format_defaults'),
			),
			'Product Settings' => array(
				'product_weblogs' => $LANG->line('nav_product_weblogs'),
				'product_options' => $LANG->line('nav_product_options'),
			),
			'Order Settings' => array(
				'order_weblog_configuration' => $LANG->line('nav_order_weblog_configuration'),
				'purchased_items' => $LANG->line('nav_purchased_items')
			),
			'Member Settings' => array(
				'member_configuration' => $LANG->line('nav_member_settings'),
			),
			'Shipping & Taxes' => array(
				'shipping' => $LANG->line('nav_shipping'),
				'tax' => $LANG->line('nav_tax'),
				'default_location' => $LANG->line('nav_default_location'),
			),
			'Coupons and Discounts' => array(
				'coupon_options' => $LANG->line('nav_coupon_options'),
				'discount_options' => $LANG->line('nav_discount_options'),

			),
			'Email Notifications' => array(
				'email_admin' => $LANG->line('nav_email_admin'),
				'email_customer' => $LANG->line('nav_email_customer')
			),
			'Payment Gateways' => array(
				'payment_gateways' => $LANG->line('nav_payment_gateways'),
			),
			'Support' => array(
				'http://cartthrob.com/docs' => $LANG->line('nav_http://cartthrob.com/docs'),
				'http://cartthrob.com/bug_tracker' => $LANG->line('nav_http://cartthrob.com/bug_tracker'),
				'http://cartthrob.com/forums' => $LANG->line('nav_http://cartthrob.com/contact'),
				'http://cartthrob.com/site/contact_us' => $LANG->line('nav_http://cartthrob.com/sales'),
				'http://cartthrob.com/docs/sub_pages/shipping/' => $LANG->line('nav_http://cartthrob.com/shipping_plugins'),
				'http://cartthrob.com/docs/sub_pages/payments/' => $LANG->line('nav_http://cartthrob.com/payment_gateways'),
				'http://cartthrob.com/docs/sub_pages/coupons_overview/' => $LANG->line('nav_http://cartthrob.com/coupon_plugins')
			),
		);
		
		$settings_views = array();
		
		$view_paths = array();
		
		// -------------------------------------------
		// 'cartthrob_add_settings_views' hook.
		//
		if ($EXT->active_hook('cartthrob_add_settings_views') === TRUE)
		{
			$settings_views = $EXT->universal_call_extension('cartthrob_add_settings_views', $settings_views);
		}
		
		if (is_array($settings_views) && count($settings_views))
		{
			$more_settings = array();
			
			foreach ($settings_views as $key => $value)
			{
				if (is_array($value))
				{
					if (isset($value['path']))
					{
						$view_paths[$key] = $value['path'];
					}
					
					if (isset($value['title']))
					{
						$nav['More Settings'][$key] = $value['title'];
					}
				}
				else
				{
					$nav['More Settings'][$key] = $value;
				}
			}
			
			if (count($more_settings))
			{
				$nav['More Settings'] = $more_settings;
			}
		}
		
		$sections = array();
		
		foreach ($nav as $subnav)
		{
			foreach ($subnav as $url_title => $section)
			{
				if ( ! preg_match('/^http/', $url_title))
				{
					$sections[] = $url_title;
				}
			}
		}
		
		$query = $DB->query("SELECT * FROM exp_modules WHERE module_name = 'Cartthrob'");
		
		$this->module_enabled = $query->num_rows;
		
		unset($query);
		
		$data = array(
			'nav' => $nav,
			'sections' => $sections,
			'weblogs' => $weblogs,
			'weblog_titles' => $weblog_titles,
			'fields' => $fields,
			'current' => $current,
			'statuses' => $statuses,
			'payment_gateways' => $this->_get_payment_gateways(),
			'shipping_plugins' => $this->_get_shipping_plugins(),
			'form_open' => $DSP->form_open(
				array(
				      'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings',
				      'enctype' => 'multipart/form-data'
				),
				array('name' => ucfirst(get_class($this)))
			),
			'template_form_open' => $DSP->form_open(
				array(
				      'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=extension_settings'.AMP.'name=cartthrob_ext'.AMP.'install_templates=1#install_blogs',
				      'id' => 'install_templates'
				)
			),
			'extension_enabled' => $this->extension_enabled,
			'module_enabled' => $this->module_enabled,
			'settings' => $settings,
			'save_settings' => $IN->GBL('save_settings'),
			'templates' => $this->_load_xml($this->_template_xml()),
			'states_and_countries' => $this->get_states_and_countries(),
			'states' => $this->get_states(),
			'countries' => $this->get_countries(),
			'view_paths' => $view_paths,
			'member_fields' => $member_fields
		);
		
		$DSP->crumbline = TRUE;
		
		$DSP->title  = $LANG->line('extension_settings');
		
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
		
		$DSP->crumb .= $DSP->crumb_item($this->name);
		
		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));
		
		$DSP->extra_header .= $this->load_view('settings_form_head', $data);
				
		$DSP->body .= $this->load_view('settings_form', $data);
	}
	// END
	function get_fields()
	{
		global $DB; 
		
		$sql = "SELECT field_id, field_label
			FROM exp_weblog_fields";
					
		$query = $DB->query($sql);
		
		$array[] = "----";
		foreach ($query->result as $item)
		{
			$array[$item['field_id']] = $item['field_label'];
			
		}
	 	asort($array, SORT_REGULAR);
		
		return $array;
		
	}
	function get_states()
	{
		$states = array(
		'AL' => 'Alabama',
		'AK' => 'Alaska',
		'AZ' => 'Arizona',
		'AR' => 'Arkansas',
		'CA' => 'California',
		'CO' => 'Colorado',
		'CT' => 'Connecticut',
		'DE' => 'Delaware',
		'DC' => 'Dist of Columbia',
		'FL' => 'Florida',
		'GA' => 'Georgia',
		'HI' => 'Hawaii',
		'ID' => 'Idaho',
		'IL' => 'Illinois',
		'IN' => 'Indiana',
		'IA' => 'Iowa',
		'KS' => 'Kansas',
		'KY' => 'Kentucky',
		'LA' => 'Louisiana',
		'ME' => 'Maine',
		'MD' => 'Maryland',
		'MA' => 'Massachusetts',
		'MI' => 'Michigan',
		'MN' => 'Minnesota',
		'MS' => 'Mississippi',
		'MO' => 'Missouri',
		'MT' => 'Montana',
		'NE' => 'Nebraska',
		'NV' => 'Nevada',
		'NH' => 'New Hampshire',
		'NJ' => 'New Jersey',
		'NM' => 'New Mexico',
		'NY' => 'New York',
		'NC' => 'North Carolina',
		'ND' => 'North Dakota',
		'OH' => 'Ohio',
		'OK' => 'Oklahoma',
		'OR' => 'Oregon',
		'PA' => 'Pennsylvania',
		'RI' => 'Rhode Island',
		'SC' => 'South Carolina',
		'SD' => 'South Dakota',
		'TN' => 'Tennessee',
		'TX' => 'Texas',
		'UT' => 'Utah',
		'VT' => 'Vermont',
		'VA' => 'Virginia',
		'WA' => 'Washington',
		'WV' => 'West Virginia',
		'WI' => 'Wisconsin',
		'WY' => 'Wyoming'
		); 
		
		return $states; 
	}
	function get_countries()
	{
		$countries = array(
		"USA" => "United States",
		"CAN" => "Canada",
		"GBR" => "United Kingdom", 
		"AFG" => "Afghanistan", 
		"ALA" => "&Aring;land Is.",
		"ALB" => "Albania", 
		"DZA" => "Algeria", 
		"ASM" => "American Samoa", 
		"AND" => "Andorra", 
		"AGO" => "Angola", 
		"AIA" => "Anguilla", 
		"ATA" => "Antarctica", 
		"ATG" => "Antigua/Barbuda", 
		"ARG" => "Argentina", 
		"ARM" => "Armenia", 
		"ABW" => "Aruba", 
		"AUS" => "Australia", 
		"AUT" => "Austria", 
		"AZE" => "Azerbaijan", 
		"BHS" => "Bahamas", 
		"BHR" => "Bahrain", 
		"BGD" => "Bangladesh", 
		"BRB" => "Barbados", 
		"BLR" => "Belarus", 
		"BEL" => "Belgium", 
		"BLZ" => "Belize", 
		"BEN" => "Benin", 
		"BMU" => "Bermuda", 
		"BTN" => "Bhutan", 
		"BOL" => "Bolivia", 
		"BIH" => "Bosnia/Herzegovina", 
		"BWA" => "Botswana", 
		"BVT" => "Bouvet Is.", 
		"BRA" => "Brazil", 
		"IOT" => "British Indian Ocean", 
		"BRN" => "Brunei Darussalam", 
		"BGR" => "Bulgaria", 
		"BFA" => "Burkina Faso", 
		"BDI" => "Burundi", 
		"KHM" => "Cambodia", 
		"CMR" => "Cameroon", 
		"CPV" => "Cape Verde", 
		"CYM" => "Cayman Is.", 
		"CAF" => "Central African Rep.", 
		"TCD" => "Chad", 
		"CHL" => "Chile", 
		"CHN" => "China", 
		"CXR" => "Christmas Is.", 
		"CCK" => "Cocos Is.", 
		"COL" => "Colombia", 
		"COM" => "Comoros", 
		"COG" => "Congo", 
		"COD" => "DR Congo", 
		"COK" => "Cook Is.", 
		"CRI" => "Costa Rica", 
		"CIV" => "Cote d'Ivoire", 
		"HRV" => "Croatia", 
		"CUB" => "Cuba", 
		"CYP" => "Cyprus", 
		"CZE" => "Czech Rep.", 
		"DNK" => "Denmark", 
		"DJI" => "Djibouti", 
		"DMA" => "Dominica", 
		"DOM" => "Dominican Rep.", 
		"ECU" => "Ecuador", 
		"EGY" => "Egypt", 
		"SLV" => "El Salvador", 
		"GNQ" => "Equatorial Guinea", 
		"ERI" => "Eritrea", 
		"EST" => "Estonia", 
		"ETH" => "Ethiopia", 
		"FLK" => "Falkland Is.", 
		"FRO" => "Faroe Is.", 
		"FJI" => "Fiji", 
		"FIN" => "Finland", 
		"FRA" => "France", 
		"GUF" => "French Guiana", 
		"PYF" => "French Polynesia", 
		"GAB" => "Gabon", 
		"GMB" => "Gambia", 
		"GEO" => "Georgia", 
		"DEU" => "Germany", 
		"GHA" => "Ghana", 
		"GIB" => "Gibraltar", 
		"GRC" => "Greece", 
		"GRL" => "Greenland", 
		"GRD" => "Grenada", 
		"GLP" => "Guadeloupe", 
		"GUM" => "Guam", 
		"GTM" => "Guatemala", 
		"GGY" => "Guernsey",
		"GIN" => "Guinea", 
		"GNB" => "Guinea-bissau", 
		"GUY" => "Guyana", 
		"HTI" => "Haiti", 
		"HMD" => "Heard/McDonald Is.", 
		"HND" => "Honduras", 
		"HKG" => "Hong Kong", 
		"HUN" => "Hungary", 
		"ISL" => "Iceland", 
		"IND" => "India", 
		"IDN" => "Indonesia", 
		"IRN" => "Iran", 
		"IRQ" => "Iraq", 
		"IRL" => "Ireland", 
		"IMN" => "Isle of Man",
		"ISR" => "Israel", 
		"ITA" => "Italy", 
		"JAM" => "Jamaica", 
		"JPN" => "Japan", 
		"JEY" => "Jersey",
		"JOR" => "Jordan", 
		"KAZ" => "Kazakhstan", 
		"KEN" => "Kenya", 
		"KIR" => "Kiribati", 
		"PRK" => "Korea(North)", 
		"KOR" => "Korea(South)", 
		"KWT" => "Kuwait", 
		"KGZ" => "Kyrgyzstan", 
		"LAO" => "Laos", 
		"LVA" => "Latvia", 
		"LBN" => "Lebanon", 
		"LSO" => "Lesotho", 
		"LBR" => "Liberia", 
		"LBY" => "Libya", 
		"LIE" => "Liechtenstein", 
		"LTU" => "Lithuania", 
		"LUX" => "Luxembourg", 
		"MAC" => "Macao", 
		"MKD" => "Macedonia", 
		"MDG" => "Madagascar", 
		"MWI" => "Malawi", 
		"MYS" => "Malaysia", 
		"MDV" => "Maldives", 
		"MLI" => "Mali", 
		"MLT" => "Malta", 
		"MHL" => "Marshall Is.", 
		"MTQ" => "Martinique", 
		"MRT" => "Mauritania", 
		"MUS" => "Mauritius", 
		"MYT" => "Mayotte", 
		"MEX" => "Mexico", 
		"FSM" => "Micronesia", 
		"MDA" => "Moldova", 
		"MCO" => "Monaco", 
		"MNG" => "Mongolia",
		"MNE" => "Montenegro", 
		"MSR" => "Montserrat", 
		"MAR" => "Morocco", 
		"MOZ" => "Mozambique", 
		"MMR" => "Myanmar", 
		"NAM" => "Namibia", 
		"NRU" => "Nauru", 
		"NPL" => "Nepal", 
		"NLD" => "Netherlands", 
		"ANT" => "Netherlands Antilles", 
		"NCL" => "New Caledonia", 
		"NZL" => "New Zealand", 
		"NIC" => "Nicaragua", 
		"NER" => "Niger", 
		"NGA" => "Nigeria",
		"NIU" => "Niue", 
		"NFK" => "Norfolk Is.", 
		"MNP" => "Northern Mariana Is.",
		"NOR" => "Norway", 
		"OMN" => "Oman", 
		"PAK" => "Pakistan", 
		"PLW" => "Palau", 
		"PSE" => "Palestinian Terr.", 
		"PAN" => "Panama", 
		"PNG" => "Papua New Guinea", 
		"PRY" => "Paraguay", 
		"PER" => "Peru", 
		"PHL" => "Philippines", 
		"PCN" => "Pitcairn", 
		"POL" => "Poland", 
		"PRT" => "Portugal", 
		"PRI" => "Puerto Rico", 
		"QAT" => "Qatar",
		"REU" => "R&eacute;union", 
		"ROU" => "Romania", 
		"RUS" => "Russian Federation", 
		"RWA" => "Rwanda",
		"BLM" => "Saint Barth&eacute;lemy", 
		"SHN" => "St. Helena", 
		"KNA" => "St. Kitts/Nevis", 
		"LCA" => "St. Lucia", 
		"MAF" => "Saint Martin (French)",
		"SPM" => "St. Pierre/Miquelon", 
		"VCT" => "St. Vincent/Grenadines", 
		"WSM" => "Samoa", 
		"SMR" => "San Marino", 
		"STP" => "Sao Tome/Principe", 
		"SAU" => "Saudi Arabia", 
		"SEN" => "Senegal", 
		"SRB" => "Serbia/Montenegro", 
		"SYC" => "Seychelles", 
		"SLE" => "Sierra Leone", 
		"SGP" => "Singapore", 
		"SVK" => "Slovakia", 
		"SVN" => "Slovenia", 
		"SLB" => "Solomon Is.", 
		"SOM" => "Somalia", 
		"ZAF" => "South Africa", 
		"SGS" => "South Georgia", 
		"ESP" => "Spain", 
		"LKA" => "Sri Lanka", 
		"SDN" => "Sudan", 
		"SUR" => "Suriname", 
		"SJM" => "Svalbard/Jan Mayen", 
		"SWZ" => "Swaziland", 
		"SWE" => "Sweden", 
		"CHE" => "Switzerland", 
		"SYR" => "Syrian Arab Rep.", 
		"TWN" => "Taiwan", 
		"TJK" => "Tajikistan", 
		"TZA" => "Tanzania", 
		"THA" => "Thailand", 
		"TLS" => "Timor-Leste", 
		"TGO" => "Togo", 
		"TKL" => "Tokelau", 
		"TON" => "Tonga", 
		"TTO" => "Trinidad & Tobago", 
		"TUN" => "Tunisia", 
		"TUR" => "Turkey", 
		"TKM" => "Turkmenistan",
		"TCA" => "Turks & Caicos Is.", 
		"TUV" => "Tuvalu", 
		"UGA" => "Uganda", 
		"UKR" => "Ukraine", 
		"ARE" => "United Arab Emirates", 
		"UMI" => "U.S. Minor Out. Is.", 
		"URY" => "Uruguay", 
		"UZB" => "Uzbekistan", 
		"VUT" => "Vanuatu", 
		"VAT" => "Vatican City", 
		"VEN" => "Venezuela", 
		"VNM" => "Vietnam", 
		"VGB" => "Virgin Is., British", 
		"VIR" => "Virgin Is., U.S.", 
		"WLF" => "Wallis/Futuna", 
		"ESH" => "Western Sahara", 
		"YEM" => "Yemen", 
		"ZMB" => "Zambia", 
		"ZWE" => "Zimbabwe"
		); 
		$path = PATH_MOD.'cartthrob/lib/locations.php'; 
		if (file_exists($path))
		{
			include($path);
			if (isset($my_countries) && is_array($my_countries))
			{
				$countries = $my_countries; 
			}
		}
		
		return $countries; 
	}
	function get_states_and_countries(){
		$both['global'] = "Global"; 
		$both['----']	= "----"; 
			
		foreach ($this->get_states() as $key=> $item)
		{
			$both[$key] = $item; 
		} 
		$both['-----']	= "----"; 
			
		foreach ($this->get_countries() as $key=> $item)
		{
			$both[$key] = $item; 
		}
			
		return $both; 
	}
	// --------------------------------
	//  Save Settings
	// --------------------------------
	/**
	 * Validates, cleans, saves data, reports errors if fields were not filled in, saves and updates CartThrob settings in the database
	 * 
	 * @access public
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function save_settings()
	{
		global $OUT, $DB, $FNS, $PREFS, $IN, $REGX, $DSP;
			
		$cartthrob_tab = ($IN->GBL('cartthrob_tab')) ? $IN->GBL('cartthrob_tab') : 'get_started';
		
		$settings = $this->_get_settings(TRUE);//print_r($settings);
		
		if (count($settings) && ! is_int(key($settings)) && ! ctype_digit(key($settings)))
		{
		//	$settings = array();
		}
		
		unset($_POST['cartthrob_tab']);

		if (isset($_FILES['settings']) && $_FILES['settings']['error'] == 0)
		{
			$new_settings = $DSP->file_open($_FILES['settings']['tmp_name']);
			
			if ($new_settings)
			{
				$settings[$PREFS->ini('site_id')] = $this->_unserialize($new_settings);
				
				//exit(print_r($settings, TRUE));
				
				$DB->query($DB->update_string('exp_extensions', array('settings' => addslashes(serialize($settings))), array('class' => $this->classname)));
			}
		}
		else
		{
			$validation = $this->_validate_settings();
			
			if ( ! $validation['valid'])
			{
				$error_message = 'The following fields are required: ';
				$error_message .= '<ul>';
				foreach ($validation['missing'] as $missing)
				{
					$error_message .= '<li>'.$missing.'</li>';
				}
				$error_message .= '</ul>';
				return $OUT->show_user_error('general', $error_message);
			}
			
			unset($_POST['name']);
			
			$this->_settings_backward_compatability($_POST);
			
			$data = array();
			
			$remove_keys = array(
				'name',
				'Submit_x',
				'Submit_y',
				'Submit'
			);
			
			foreach ($_POST as $key => $value)
			{
				//get rid of plugin settings - non-array values (which are just repeats)
				if (in_array($key, $remove_keys) || preg_match('/^(Cartthrob_.*?_settings|product_weblogs|product_weblog_fields|default_location|tax_settings)_.*/', $key))
				{
					continue;
				}
				
				$data[$key] = $REGX->xss_clean($value);
			}
			
			$settings[$PREFS->ini('site_id')] = $data;
			
			$query = $DB->query($DB->update_string('exp_extensions', array('settings' => addslashes(serialize($settings))), array('class' => $this->classname)));
		}
		
		$FNS->redirect(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extension_settings'.AMP.'name=cartthrob_ext'.AMP.'save_settings=1#'.$cartthrob_tab);
	}
	// END
	
	// --------------------------------
	//  Backwards Compatability Settings
	// --------------------------------
	/**
	 * This function is used to maintain backwards compatability with old settings, 
	 * including tax_settings, and weight thresholds settings
	 * 
	 * @access private
	 * @param array $settings
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _settings_backward_compatability(&$settings)
	{
		//tax settings
		if (isset($settings['tax_settings']) && ! is_array($settings['tax_settings']))
		{
			$raw_settings = explode("\r", str_replace("\n", "\r", str_replace("\r\n", "\r", $settings['tax_settings'])));
			
			$tax_settings = array();
			
			foreach ($raw_settings as $raw_setting)
			{
				if (strpos($raw_setting, ':') !== FALSE)
				{
					$raw_setting = explode(':', $raw_setting);
				
					$locale = $raw_setting[0];
				
					$rate = (float) $raw_setting[1];
					
					//determine whether user put in actual rate, or percentage
					//ie. 8.75 vs. .0875
					$rate = ($rate < 1) ? ($rate*100) : $rate;
					
					$tax_settings[] = array(
						'state' => (! is_numeric($locale) ? $locale : ''),
						'zip' => (is_numeric($locale) ? $locale : ''),
						'rate' => $rate
					);
				}
			}
			
			$settings['tax_settings'] = $tax_settings;
		}
		
		if (isset($settings['Cartthrob_by_weight_thresholds_settings']['thresholds']) && ! is_array($settings['Cartthrob_by_weight_thresholds_settings']['thresholds']))
		{
			$raw_settings = explode("\r", str_replace("\n", "\r", str_replace("\r\n", "\r", $settings['Cartthrob_by_weight_thresholds_settings']['thresholds'])));
			
			$new_settings = array();
			
			foreach ($raw_settings as $raw_setting)
			{
				if (strpos($raw_setting, ':') !== FALSE)
				{
					$raw_setting = explode(':', $raw_setting);
				
					$threshold = $raw_setting[0];
				
					$rate = $raw_setting[1];
					
					$rate = ($rate < 1) ? ($rate*100) : $rate;
					
					$new_settings[] = array(
						'threshold' => $threshold,
						'rate' => $rate
					);
				}
			}
			
			$settings['Cartthrob_by_weight_thresholds_settings'] = $new_settings;
		}
	}
	// END
	
	// --------------------------------
	//  Validate Settings
	// --------------------------------
	/**
	 * Checks to see if any fields are missing. If the fields are missing, The "missing" array is returned, and 'valid' boolean is false. 
	 * 
	 * @access private
	 * @param NULL
	 * @return array
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _validate_settings()
	{
		global $IN;
		
		$valid = TRUE;
		
		$missing = array();
		
		foreach ($this->required_settings as $required)
		{
			if ( ! $IN->GBL($required, 'POST'))
			{
				$missing[] = $required;
				
				$valid = FALSE;
			}
		}
		
		return array('valid'=>$valid, 'missing'=>$missing);
	}
	//END 
	
	// --------------------------------
	//  Export Settings
	// --------------------------------
	/**
	 * Generates & downloads a file called "cartthrob_settings.txt" that contains current settings for CartThrob 
	 * Useful for backup and transfer. 
	 *
	 * @access private
	 * @param NULL
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _export_settings()
	{
		global $DB;
		
		$filename = 'cartthrob_settings.txt';
		
		header('Content-Type: application/force-download');

		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
		{
			header('Content-Disposition: inline; filename="'.$filename.'"');
			header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		}
		else
		{
			header('Content-Disposition: attachment; filename="'.$filename.'"');
			header('Expires: '.gmdate('D, d M Y H:i:s').' GMT');
			header('Pragma: no-cache');
		}
		
		//$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '".$this->classname."' LIMIT 1");
		
		exit(serialize($this->_get_settings()));
		
		//exit($query->row['settings']);
	}
	//END
	
	function _unserialize($str, $stripslashes = TRUE)
	{
		$data = @unserialize($str);
		
		if ( ! is_array($data))
		{
			$data = array();
		}
		
		if ($stripslashes)
		{
			global $REGX;
			
			return $REGX->array_stripslashes($data);
		}
		
		return $data;
	}
	
	// --------------------------------
	//  GET Settings
	// --------------------------------
	/**
	 * Loads cart, and gets default settings, then gets saved settings
	 *
	 * @access private
	 * @param NULL
	 * @return array $settings
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _get_settings($all = FALSE)
	{	
		global $DB, $EXT, $REGX, $PREFS, $SESS;
		
		if ( ! $all && isset($SESS->cache['cartthrob']['settings'][$PREFS->ini('site_id')]))
		{
			return $SESS->cache['cartthrob']['settings'][$PREFS->ini('site_id')];
		}
		
		$this->_load_cart();
		
		$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '".$this->classname."' LIMIT 1");
		
		$this->extension_enabled = $query->num_rows;
		
		$settings = array();
		
		if ($query->num_rows && $query->row['settings'])
		{
			$settings = $REGX->array_stripslashes($this->_unserialize($query->row['settings']));
		}
		
		if ( ! $all)
		{
			$settings = (isset($settings[$PREFS->ini('site_id')])) ? $settings[$PREFS->ini('site_id')] : array();
		
			foreach ($this->CART->default_settings as $key => $value)
			{
				if ( ! isset($settings[$key]))
				{
					$settings[$key] = $value;
				}
			}
		
			$this->_settings_backward_compatability($settings);
		
			$SESS->cache['cartthrob']['settings'][$PREFS->ini('site_id')] = $settings;
		}
		
		return $settings;
	}
	// END 
	
	// --------------------------------
	//  Get Payment Gateways
	// --------------------------------
	/**
	 * Loads payment gateway files
	 *
	 * @access private
	 * @param NULL
	 * @return array $gateways Array containing settings and information about the gateway
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _get_payment_gateways()
	{
		global $DB, $PREFS, $LANG;
		
		$gateways = array();
		
		$gateway_path = PATH_MOD.'cartthrob/payment_gateways/';
		
		if (is_dir($gateway_path))
		{
			$dir_handle = opendir($gateway_path);

			if ($dir_handle)
			{
				$template_list = array(''=>$LANG->line('gateways_default_template'));
				
				$query = $DB->query("SELECT g.group_name, t.template_name
							FROM exp_template_groups g
							JOIN exp_templates t
							ON g.group_id =  t.group_id
							WHERE g.site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
							ORDER BY g.group_order, t.template_name");
				
				foreach ($query->result as $row)
				{
					$template_list[$row['group_name'].'/'.$row['template_name']] = $row['group_name'].'/'.$row['template_name'];
				}
				
				unset($query);
				
				while (($file = readdir($dir_handle)) !== FALSE)
				{
					if (preg_match('/^cartthrob\./', $file))
					{
						$gateway_info = $this->_validate_payment_gateway($gateway_path.$file);
					
						if ($gateway_info)
						{
							if ( ! empty($gateway_info['language_file']))
							{
								$LANG->fetch_language_file(strtolower($gateway_info['classname']), 'cartthrob');
							
								$gateway_info = $this->_validate_payment_gateway($gateway_path.$file);
							}
							
							if (isset($gateway_info['settings']))
							{
								$gateway_info['settings'][] = array(
									'name'=>$LANG->line('template_settings_name'),
									'note'=>$LANG->line('template_settings_note'),
									'type'=>'select',
									'short_name'=>'gateway_fields_template',
									'options'=>$template_list
								);
							}
							
							$gateways[] = $gateway_info;
						}
					}
				}
			}
		}
		
		return $gateways;
	}
	// END
	
	// --------------------------------
	//  Validate Payment Gateway
	// --------------------------------
	/**
	 * Makes sure file exists, and that settings exist within payment gateway file.
	 *
	 * @access private
	 * @param string $file location of a file on the server
	 * @return bool|array $gateway_info false|Array containing settings and information about the gateway
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _validate_payment_gateway($file)
	{
		if (!file_exists($file))
		{
			return FALSE;
		}
		
		$gateway_info = array('error'=>1);
		
		include($file);
		
		if ( ! is_array($gateway_info) || ! isset($gateway_info['title']) || ! isset($gateway_info['settings']) || ! isset($gateway_info['classname']) || ! is_callable(array($gateway_info['classname'], '_process_payment')))
		{
			return FALSE;
		}
		
		return $gateway_info;
	}
	// END
	
	// --------------------------------
	//  Get Shipping Plugins
	// --------------------------------
	/**
	 * Loads shipping plugin files
	 *
	 * @access private
	 * @param NULL
	 * @return array $plugins Array containing settings and information about the plugin
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _get_shipping_plugins()
	{
		$plugins = array();
		
		$plugins_path = PATH_MOD.'cartthrob/shipping_plugins/';
		
		if (is_dir($plugins_path))
		{
			$dir_handle = opendir($plugins_path);

			if ($dir_handle)
			{
				while (($file = readdir($dir_handle)) !== FALSE)
				{
					if (preg_match('/^cartthrob\./', $file))
					{
						$plugin_info = $this->_validate_shipping_plugin($plugins_path.$file);
					
						if ($plugin_info)
						{
							$plugins[] = $plugin_info;
						}
					}
				}
			}
		}
		asort($plugins);
		return $plugins;
	}
	// END
	
	// --------------------------------
	//  Validate Shipping Plugin
	// --------------------------------
	/**
	 * Makes sure file exists, and that settings exist within shipping file.
	 *
	 * @access private
	 * @param string $file location of a file on the server
	 * @return bool|array $plugin_info false|Array containing settings and information about the plugin
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function _validate_shipping_plugin($file)
	{
		if (!file_exists($file))
		{
			return FALSE;
		}
		
		$plugin_info = array('error'=>1);
		
		include($file);
		
		if (!is_array($plugin_info) || !array_key_exists('title', $plugin_info) || !array_key_exists('settings', $plugin_info) || !array_key_exists('classname', $plugin_info))
		{
			return FALSE;
		}
		
		return $plugin_info;
	}
	// END
	
	// --------------------------------
	//  Load View
	// --------------------------------
	/**
	 * Loads requested view file
	 *
	 * @access public
	 * @param string $file location of a file on the server
	 * @param array $data variables passed to the view file
	 * @return string $output the rendered contents of the view file
	 * @since 1.0.0
	 * @author Rob Sanchez
	 */
	function load_view($file, $data, $path = '')
	{
		$output = '';
		
		if ( ! $path)
		{
			$path = PATH_MOD.'cartthrob/views/';
		}
		
		$file = $path.$file.EXT;
		
		if (file_exists($file))
		{
			extract($data);
			
			ob_start();
			
			include($file);
			
			$output = ob_get_contents();
			
			ob_end_clean();
		}
			
		return $output;
	}
	// END

// ****************************************** TEMPLATE INSTALLER ********************************************** //
	
	// --------------------------------
	//  Template XML
	// --------------------------------
	/**
	 * Stores and outputs Template XML
	 *
	 * @access private
	 * @param NULL
	 * @return string $output XML content containing settings & template data
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _template_xml()
	{
		ob_start();
?><create>
	<weblog is_user_blog='n' blog_name='products' blog_title='Products' blog_url='' blog_description='' blog_lang='en' blog_encoding='utf-8' total_entries='0' total_comments='0' total_trackbacks='0' last_entry_date='0' last_comment_date='0' last_trackback_date='0' cat_group='' status_group='0' deft_status='open' search_excerpt='0' enable_trackbacks='n' trackback_use_url_title='n' trackback_max_hits='5' trackback_field='44' deft_category='' deft_comments='y' deft_trackbacks='y' weblog_require_membership='y' weblog_max_chars='0' weblog_html_formatting='all' weblog_allow_img_urls='y' weblog_auto_link_urls='n' weblog_notify='n' weblog_notify_emails='' comment_url='' comment_system_enabled='y' comment_require_membership='n' comment_use_captcha='n' comment_moderate='n' comment_max_chars='0' comment_timelock='0' comment_require_email='y' comment_text_formatting='xhtml' comment_html_formatting='safe' comment_allow_img_urls='n' comment_auto_link_urls='y' comment_notify='n' comment_notify_authors='n' comment_notify_emails='' comment_expiration='0' search_results_url='' tb_return_url='' ping_return_url='' show_url_title='y' trackback_system_enabled='n' show_trackback_field='y' trackback_use_captcha='n' show_ping_cluster='y' show_options_cluster='y' show_button_cluster='y' show_forum_cluster='n' show_pages_cluster='n' show_show_all_cluster='y' show_author_menu='y' show_status_menu='y' show_categories_menu='y' show_date_menu='y' rss_url='' enable_versioning='n' enable_qucksave_versioning='n' max_revisions='10' default_entry_title='' url_title_prefix='' live_look_template='0'>
		<field_group group_name='Products'>
			<field field_name='product_price' field_label='Price' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='2' />
			<field field_name='product_shipping' field_label='Shipping' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='3' />
			<field field_name='product_weight' field_label='Weight' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='4' />
			<field field_name='product_size' field_label='Size' field_instructions='' field_type='ct_price_mod' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='5' />
			<field field_name='product_download_url' field_label='Download URL' field_instructions='If the product has an associated download URL, add it here. ' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='300' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='34' />
		</field_group>
	</weblog>
	<weblog is_user_blog='n' blog_name='coupon_codes' blog_title='Coupon Codes' blog_url='' blog_description='' blog_lang='en' blog_encoding='utf-8' total_entries='0' total_comments='0' total_trackbacks='0' last_entry_date='0' last_comment_date='0' last_trackback_date='0' cat_group='' status_group='0' deft_status='open' search_excerpt='0' enable_trackbacks='n' trackback_use_url_title='n' trackback_max_hits='5' trackback_field='0' deft_category='' deft_comments='y' deft_trackbacks='y' weblog_require_membership='y' weblog_max_chars='0' weblog_html_formatting='all' weblog_allow_img_urls='y' weblog_auto_link_urls='y' weblog_notify='n' weblog_notify_emails='' comment_url='' comment_system_enabled='y' comment_require_membership='n' comment_use_captcha='n' comment_moderate='n' comment_max_chars='0' comment_timelock='0' comment_require_email='y' comment_text_formatting='xhtml' comment_html_formatting='safe' comment_allow_img_urls='n' comment_auto_link_urls='y' comment_notify='n' comment_notify_authors='n' comment_notify_emails='' comment_expiration='0' search_results_url='' tb_return_url='' ping_return_url='' show_url_title='y' trackback_system_enabled='n' show_trackback_field='y' trackback_use_captcha='n' show_ping_cluster='y' show_options_cluster='y' show_button_cluster='y' show_forum_cluster='n' show_pages_cluster='n' show_show_all_cluster='y' show_author_menu='y' show_status_menu='y' show_categories_menu='y' show_date_menu='y' rss_url='' enable_versioning='n' enable_qucksave_versioning='n' max_revisions='10' default_entry_title='' url_title_prefix='' live_look_template='0'>
		<field_group group_name='Coupon Codes'>
			<field field_name='coupon_code_type' field_label='Coupon Type' field_instructions='' field_type='ct_coupon' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='26' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='xhtml' field_show_fmt='y' field_order='3' />
		</field_group>
	</weblog>
	<weblog is_user_blog='n' blog_name='orders' blog_title='Orders' blog_url='' blog_description='' blog_lang='en' blog_encoding='utf-8' total_entries='0' total_comments='0' total_trackbacks='0' last_entry_date='0' last_comment_date='0' last_trackback_date='0' cat_group='' status_group='1' deft_status='open' search_excerpt='0' enable_trackbacks='n' trackback_use_url_title='n' trackback_max_hits='5' trackback_field='50' deft_category='' deft_comments='y' deft_trackbacks='y' weblog_require_membership='y' weblog_max_chars='0' weblog_html_formatting='all' weblog_allow_img_urls='y' weblog_auto_link_urls='n' weblog_notify='n' weblog_notify_emails='' comment_url='' comment_system_enabled='y' comment_require_membership='n' comment_use_captcha='n' comment_moderate='n' comment_max_chars='0' comment_timelock='0' comment_require_email='y' comment_text_formatting='xhtml' comment_html_formatting='safe' comment_allow_img_urls='n' comment_auto_link_urls='y' comment_notify='n' comment_notify_authors='n' comment_notify_emails='' comment_expiration='0' search_results_url='' tb_return_url='' ping_return_url='' show_url_title='y' trackback_system_enabled='n' show_trackback_field='y' trackback_use_captcha='n' show_ping_cluster='y' show_options_cluster='y' show_button_cluster='y' show_forum_cluster='n' show_pages_cluster='n' show_show_all_cluster='y' show_author_menu='y' show_status_menu='y' show_categories_menu='y' show_date_menu='y' rss_url='' enable_versioning='n' enable_qucksave_versioning='n' max_revisions='10' default_entry_title='' url_title_prefix='' live_look_template='0'>
		<field_group group_name='Orders'>
			<field field_name='order_shipping_address' field_label='Shipping Address' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='12' />
			<field field_name='order_shipping_address2' field_label='Shipping Address 2' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='13' />
			<field field_name='order_shipping_option' field_label='Shipping Method' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='30' />
			<field field_name='order_shipping_city' field_label='Shipping City' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='14' />
			<field field_name='order_billing_zip' field_label='Billing Zip' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='7' />
			<field field_name='order_shipping_first_name' field_label='Shipping First Name' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='10' />
			<field field_name='order_shipping_last_name' field_label='Shipping Last Name' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='11' />
			<field field_name='order_billing_state' field_label='Billing State' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='6' />
			<field field_name='order_billing_address' field_label='Billing Address' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='3' />
			<field field_name='order_billing_city' field_label='Billing City' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='5' />
			<field field_name='order_billing_address2' field_label='Billing Address 2' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='4' />
			<field field_name='order_billing_last_name' field_label='Billing Last Name' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='2' />
			<field field_name='order_billing_first_name' field_label='Billing First Name' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='1' />
			<field field_name='order_transaction_id' field_label='Transaction ID' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='31' />
			<field field_name='order_customer_email' field_label='Customer Email' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='18' />
			<field field_name='order_customer_phone' field_label='Customer Phone' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='19' />
			<field field_name='order_shipping_state' field_label='Shipping State' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='15' />
			<field field_name='order_shipping_zip' field_label='Shipping Zip' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='16' />
			<field field_name='order_subtotal' field_label='Subtotal' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='23' />
			<field field_name='order_tax' field_label='Tax' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='24' />
			<field field_name='order_shipping' field_label='Shipping Cost' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='25' />
			<field field_name='order_total' field_label='Total' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='0' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='26' />
			<field field_name='order_items' field_label='Items' field_instructions='' field_type='ct_items' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='26' field_related_orderby='date' field_related_sort='desc' field_related_max='0' field_ta_rows='8' field_maxl='0' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='27' />
			<field field_name='order_coupons' field_label='Coupons' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='34' />
			<field field_name='order_last_four' field_label='CC Last Four Digits' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='4' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='34' />
			<field field_name='order_error_message' field_label='Error Message' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='255' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='36' />
		</field_group>
	</weblog>
	<weblog is_user_blog='n' blog_name='purchased_items' blog_title='Purchased Items' blog_url='' blog_description='' blog_lang='en' blog_encoding='utf-8' total_entries='0' total_comments='0' total_trackbacks='0' last_entry_date='0' last_comment_date='0' last_trackback_date='0' cat_group='1' status_group='1' deft_status='open' search_excerpt='0' enable_trackbacks='n' trackback_use_url_title='n' trackback_max_hits='5' trackback_field='77' deft_category='' deft_comments='y' deft_trackbacks='y' weblog_require_membership='y' weblog_max_chars='0' weblog_html_formatting='all' weblog_allow_img_urls='y' weblog_auto_link_urls='n' weblog_notify='n' weblog_notify_emails='' comment_url='' comment_system_enabled='y' comment_require_membership='n' comment_use_captcha='n' comment_moderate='n' comment_max_chars='0' comment_timelock='0' comment_require_email='y' comment_text_formatting='xhtml' comment_html_formatting='safe' comment_allow_img_urls='n' comment_auto_link_urls='y' comment_notify='n' comment_notify_authors='n' comment_notify_emails='' comment_expiration='0' search_results_url='' tb_return_url='' ping_return_url='' show_url_title='y' trackback_system_enabled='n' show_trackback_field='y' trackback_use_captcha='n' show_ping_cluster='y' show_options_cluster='y' show_button_cluster='y' show_forum_cluster='n' show_pages_cluster='n' show_show_all_cluster='y' show_author_menu='y' show_status_menu='y' show_categories_menu='y' show_date_menu='y' rss_url='' enable_versioning='n' enable_qucksave_versioning='n' max_revisions='10' default_entry_title='' url_title_prefix='' live_look_template='0'>
		<field_group group_name='Purchased Items'>
			<field field_name='purchased_id' field_label='ID' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='26' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='1' />
			<field field_name='purchased_quantity' field_label='Quantity' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='2' />
			<field field_name='purchased_price' field_label='Price' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='3' />
			<field field_name='purchased_order_id' field_label='Order Id' field_instructions='' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='35' />
			<field field_name='purchased_product_download_url' field_label='Product Download URL' field_instructions='This is the filename of the downloadable product. ' field_type='text' field_list_items='' field_pre_populate='n' field_pre_blog_id='0' field_pre_field_id='0' field_related_to='blog' field_related_id='8' field_related_orderby='title' field_related_sort='desc' field_related_max='0' field_ta_rows='6' field_maxl='128' field_required='n' field_text_direction='ltr' field_search='n' field_is_hidden='n' field_fmt='none' field_show_fmt='n' field_order='35' />
		</field_group>
	</weblog>
	<template_group group_name='reports' group_order='5' is_site_default='n' is_user_blog='n'>
		<template template_name='index' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
{assign_variable:template="cart_single_page_checkout"}
{embed=includes/.header title="Reports" }
<style type="text/css">
	.store_block table td{
		padding: 6px;
	}
</style>
</head>
<body>
	<h1>Reports</h1>
	<p>You can create reports in any way you'd like with CartThrob using standard EE templates.</p>
	<p>Note: CartThrob currently uses standard templates to output report information. Some business owners may want to see these reports within the context of their backend. Take a look at the following article: <a href="http://cartthrob.com/docs/tags_detail/order_items/">Site Owner’s Completed Order Report</a></p>


	{!-- ORDERS REPORT --}
    <div class="store_block">
	<h2>Sales Report</h2>
	{!-- outputting products stored in orders weblog. Like typical weblogs, 
		the name of the weblog may vary based on your system configuration --}
		{exp:weblog:entries weblog="orders"}
			<h3>{title}  Purchased: {entry_date format="%m/%d/%Y"}</h3>
			{!-- The "order_items" is a custom field within the weblog. 
				The order_items is a very powerful field type. It can dynamically 
				 add and store configured product information. Each new configuration 
				option will be stored in this field, regardless of the name or 
				number of configuration options. This means that you can store 
				sizes, colors, finishes, or other option data without pre-configuring 
				the field. See the article entry here on setting this up: 
				http://cartthrob.com/docs/sub_pages/orders_overview/
				and the article about outputting this data here: 
				http://cartthrob.com/docs/tags_detail/order_items/
			  --}
			{!-- :table is a pseudo tag available for the order_items custom field. it
				outputs a table of the content stored in the order_items field. You can 
				also use the {order_items}{/order_items} variable pair for more flexibility --}
			{order_items:table}<br />
		
			{!-- The variables below all reference standard EE weblog custom field variables --}
<pre>
Subtotal: 			{order_subtotal}
Tax: 				{order_tax}
Shipping:			{order_shipping}
-------------------------------------------------------------
Total:				{order_total}
</pre>
			<br />
			Transaction ID: {order_transaction_id}<br /><br />

			Customer Info: <br />
			{order_billing_first_name} {order_billing_last_name}<br />
			{order_customer_email}<br />

			<hr>
		{/exp:weblog:entries}
	</div>
	
	{!-- PURCHASED ITEMS --}
    <div class="store_block">
	<h2>PURCHASED ITEMS</h2>
	{!-- Purchased items is a standard EE weblog. There are no advanced custom fields associated
		with the Purchased items weblog --}
		{exp:weblog:entries weblog="purchased_items" limit="20"}
			<h3>{title}</h3>
			Customer Info: {author}
			Item ID: {purchased_id}
			Quantity Purchased: {purchased_quantity}
			Order ID: {purchased_order_id}
			<hr>
		{/exp:weblog:entries}
	</div>
	<div class="store_block">
		<h2>Tags used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/tags_detail/order_items/">CartThrob Order Items Custom Field Type</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/order_items/#var_item:table">CartThrob Order Items:Table</a></li>

		</ul>
	</div>
	<div class="store_block">
		<h2>Concepts used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/sub_pages/orders_overview/">Orders Weblog</a></li>
			<li><a href="http://cartthrob.com/docs/sub_pages/purchased_items_overview">Purchased Items Weblog</a></li>
		</ul>
	</div>
	<div class="store_block">
		{embed=includes/.footer}
	</div>
</body>
</html>		]]>
		</template>
	</template_group>
	<template_group group_name='cart_single_page_checkout' group_order='1' is_site_default='y' is_user_blog='n'>
		<template template_name='index' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
{assign_variable:template="cart_single_page_checkout"}
{embed=includes/.header title="Single Page Store" }
</head>
<body>
	<h1>Single Page Store</h1>
	<p>This single page is an example of how you can use one page to add, update, and delete items, as well as checkout</p>

	{!-- ORDER COMPLETE MESSAGES --}
	{!-- The "return" paramater of the checkout form below is set back to this page with "order_complete" in the URL. 
		This saves creating a template specifically to handle order info. --}
	{if segment_2=="order_complete"}
		{!-- the submitted_order_info tag returns information from the last attempted order. --}
		{exp:cartthrob:submitted_order_info}
		    <div class="store_block">
				{if authorized}
					Your transaction is complete!<br />
			        Transaction ID: {transaction_id}<br />
			        Your total: {cart_total}<br />
			        Your order ID: {order_id}
			    {if:elseif declined}
			        Your credit card was declined: {error_message}
			    {if:elseif failed}
			        Your payment failed: {error_message}
			    {if:else}
			        Your payment failed: {error_message}
			    {/if}
			</div>
		{/exp:cartthrob:submitted_order_info}
	{/if}

	{!-- ADD A PRODUCT --}
    <div class="store_block">
	<h2>Add Products</h2>
	{!-- outputting products stored in one of the "products" weblogs. These are exactly the same as normal 
		product weblogs, so the weblog names may be different from what is listed below --}
	{exp:weblog:entries weblog="products" limit="10"}
		{!-- The add_to_cart_form adds 1 or more of a product to the cart --}
		{exp:cartthrob:add_to_cart_form 
			entry_id="{entry_id}" 
			return="{template}/index"}
				<p>Product name: {title} <br />
				Quantity: <input type="text" name="quantity" size="5" value="" /> <input type="submit" value="Add to Cart">
				<br />
				Price: ${product_price}<br />
				
				</p>
		{/exp:cartthrob:add_to_cart_form}
	{/exp:weblog:entries}
	</div>

	{!-- VIEW CART CONTENTS / UPDATE QUANTITIES --}

	<div class="store_block">
	<h2>Cart Contents</h2>
	{!-- cart_items_info outputs information about your current cart, including products in the cart, weight, and prices. --}
		{exp:cartthrob:cart_items_info}
		{if no_results}
		    <p>There is nothing in your cart</p>
		{/if}
		{!-- outputting data that's only applicable for the first item. --}
		{if first_row}
			{exp:cartthrob:update_cart_form 
				return="{template}/index"}
		
			<h3>Customer Info</h3>
				{exp:cartthrob:customer_info}
					First Name: <input type="text" name="first_name" value="{customer_first_name}" /><br />
					Last Name: <input type="text" name="last_name" value="{customer_last_name}" /><br />
					Email Address:	<input type="text" name="email_address" value="{customer_email_address}" /><br />
					State: <input type="text" name="state" value="{customer_state}" /><br />
					Zip: <input type="text" name="zip" value="{customer_zip}" /><br />
				{/exp:cartthrob:customer_info}

			{!-- update_cart_form allows you to edit the information of one or more items in the cart at the same time
				as well as save customer information, and shipping options. --}


				
			    <table>
			        <thead>
			            <tr>
			                <td>Item</td>
			                <td colspan="2">Quantity</td>
			            </tr>
			        </thead>
			        <tbody>
		{/if}
			        <tr>
		                <td>{title}</td>
		                <td>
								{!-- you can reference products by entry_id and row_id. If you sell configurable 
									items (like t-shirts with multiple sizes) you should use row_id to edit and 
									delete items, otherwise, all items with that entry id
									are affected, regardless of configuration --}

	                        	<input type="text" name="quantity[{row_id}]" size="2" value="{quantity}" />
		                </td>
		                <td>
							{!-- This deletes one item (row_id) at a time--}
								<input type="checkbox" name="delete[{row_id}]"> Delete this item
		                </td>
		            </tr>
		{if last_row}
		{!-- outputting data that's only applicable for the last item. --}
			            <tr>
			                <td>
								{!-- these are just some of the variables available within the cart_items_info tag --}
			                    <p>Subtotal: {cart_subtotal}<br />
			                    Shipping: {cart_shipping}<br />
			                    Tax: {cart_tax}<br /> 
								{!--tax is updated based on user's location. To create a default tax price, set a default tax region in the backend --}

								Shipping Option: {shipping_option}<br />
								Tax Name: {cart_tax_name}<br />
								Tax %: {cart_tax_rate}<br />
								Discounted Subtotal: {exp:cartthrob:arithmetic operator="-" num1="{cart_subtotal}" num2="{cart_discount}"}<br />
								Discount: {cart_discount}<br />
			
			                    <strong>Total: {cart_total}</strong></p>
								<p>
								{!-- total quantity of all items in cart --}
								Total Items: {exp:cartthrob:total_items_count}<br />
								{!-- total items in cart --}
								Total Unique Items: {exp:cartthrob:unique_items_count}</p>

			                </td>
			                <td colspan="2">&nbsp;</td>
			
			            </tr>
			        </tbody>
			    </table>
	<input type="submit" value="Update Cart" />

				{/exp:cartthrob:update_cart_form}
			
			
		{/if}
	{/exp:cartthrob:cart_items_info}
    
	
	</div>

	{!-- ADD COUPON --}
	<div class="store_block">
	<h2>Add Coupon</h2>
	{!--  add_coupon_form tag outputs an add_coupon form--}
	{exp:cartthrob:add_coupon_form 
		return="{template}/index"}
		<input type="text" name="coupon_code" /> use code 5_off if you're demoing this on CartThrob.net<br />
		<input type="submit" value="Add" />
	{/exp:cartthrob:add_coupon_form}
	</div>

	{!-- SAVE CUSTOMER INFO --}
	<div class="store_block">
	<h2>Save Customer Info</h2>
	
	{exp:cartthrob:save_customer_info_form 
		id="myform_id" 
		name="myform_name" 
		class="myform_class" 
		return="{template}/index" 
		}
			{exp:cartthrob:customer_info}
		
				First Name: <input type="text" name="first_name" value="{customer_first_name}" /><br />
				Last Name: <input type="text" name="last_name" value="{customer_last_name}" /><br />
				Email Address:	<input type="text" name="email_address" value="{customer_email_address}" /><br />
				State: <input type="text" name="state" value="{customer_state}" /><br />
				Zip: <input type="text" name="zip" value="{customer_zip}" /><br />
			{/exp:cartthrob:customer_info}
		
		{exp:cartthrob:shipping_options}
		<br />
		<input type="submit" value="Save" />
	{/exp:cartthrob:save_customer_info_form}
	
	</div>

	
	{!-- CHECKOUT --}
	<div class="store_block">
	<h2>Checkout</h2>
	{!--  checkout_form tag outputs a checkout form--}
	{!--- There are many parameters available for the checkout form. You may want to note: cart_empty_redirect 
		this parameter will redirect customer if there are no products in their cart.  --}
	{exp:cartthrob:checkout_form 
		gateway="dev_template"
		return="{template}/order_complete"}
		{!-- The gateway_fields template variable to output fields required by your currently selected gateway 
			what you see on the front end changes based on the gateway's requirements.--}
		{gateway_fields}
		<br />
		{!-- you can add a coupon code using the "add_coupon_form" or you can add a code right here in the checkout_form --}
		Add a coupon code: <input type="text" name="coupon_code" /> <br />
		<input type="submit" value="Checkout" />
	{/exp:cartthrob:checkout_form}
	</div>
	<div class="store_block">
		<h2>Tags used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/tags_detail/add_to_cart_form">add_to_cart_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/add_coupon_form">add_coupon_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/cart_items_info">cart_items_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/checkout_form">checkout_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/customer_info">customer_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/save_customer_info_form">save_customer_info_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/submitted_order_info">submitted_order_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/update_cart_form">update_cart_form</a></li>
		</ul>
	</div>
	<div class="store_block">
		{embed=includes/.footer}
	</div>
</body>
</html>		]]>
		</template>
	</template_group>
	<template_group group_name='cart_tshirt' group_order='2' is_site_default='n' is_user_blog='n'>
		<template template_name='index' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
{assign_variable:template="cart_tshirt"}
{embed=includes/.header title="T-Shirt Store" }
</head>
<body>
	<h1>T-Shirt Store</h1>
	<p>This example shows how you can add options that your customers can select, some options affect the price, and some do not.</p>

	{!-- ORDER COMPLETE MESSAGES --}
	{!-- The "return" paramater of the checkout form below is set back to this page with "order_complete" in the URL. 
		This saves creating a template specifically to handle order info. --}
	{if segment_2=="order_complete"}
		{!-- the submitted_order_info tag returns information from the last attempted order. --}
		{exp:cartthrob:submitted_order_info}
		    <div class="store_block">
				{if authorized}
					Your transaction is complete!<br />
			        Transaction ID: {transaction_id}<br />
			        Your total: {cart_total}<br />
			        Your order ID: {order_id}
			    {if:elseif declined}
			        Your credit card was declined: {error_message}
			    {if:elseif failed}
			        Your payment failed: {error_message}
			    {if:else}
			        Your payment failed: {error_message}
			    {/if}
			</div>
		{/exp:cartthrob:submitted_order_info}
	{/if}

	{!-- ADD A PRODUCT --}
    <div class="store_block">
		<h2>Add T-Shirts</h2>
		{!-- outputting products stored in one of the "products" weblogs. These are exactly the same as normal 
			product weblogs, so the weblog names may be different from what is listed below --}
		{exp:weblog:entries weblog="products" limit="10"}
			{!-- The add_to_cart_form adds 1 or more of a product to the cart --}
			{exp:cartthrob:add_to_cart_form 
				entry_id="{entry_id}" 
				return="{template}/index"}
					<p>
						T-Shirt name: {title} Tee<br />
						Quantity: <input type="text" name="quantity" size="5" value="" /> 
						<input type="submit" value="Add to Cart">
						<br />
						Price: ${product_price}<br />
						{!-- Some major magic happens here. This is the item_options variable.
							It can be used in conjunction with a "Cartthrob Price Modifiers" field from your weblog, 
							and can automatically create and populate input and select fields with the data from that custom field. 
							
							A. 
							It can be used singly like this: 
							{item_options:select:YOUR_FIELD_NAME}
							and a select dropdown with your values will be output

							B. 
							You can use it as a variable pair like this: 
							 {item_options:select:YOUR_FIELD_NAME}
								<option value="{option}">{option_name} $ {price}</option>
							{/item_options:select:YOUR_FIELD_NAME}
							option, option_name, and price are variables associated with the Cartthrob Price Modifiers custom field type.
							Associated prices are automatically figured. 
							
							C.
							OR, you can add optoions on the fly like this: 
							<select name="item_options[whatevs]">
								<option value="S">Small</option>
								<option value="M">Medium</option>
								<option value="L">Large</option>
							</select>
							
							D. 
							OR This:  
							{item_options:select:size class="size_box" values="S:Small|M:Medium|L:Large" attr:rel="external"}
							In both option C and D above, prices aren't modified dynamically. 
							
							There are lots of ways to use the item_options variable. It's one of the most powerful features of CartThrob, 
							but possibly a bit complicated to grasp at first. Please feel free to post questions in the CartThrob forums
							--}
						{item_options:select:product_size}
							<option value="{option}">{option_name} {price}</option>
						{/item_options:select:product_size}
					</p>
			{/exp:cartthrob:add_to_cart_form}
		{/exp:weblog:entries}
	</div>

	{!-- VIEW CART CONTENTS / UPDATE QUANTITIES --}
	<div class="store_block">
	<h2>Cart Contents</h2>
	{!-- cart_items_info outputs information about your current cart, including products in the cart, weight, and prices. --}
	{exp:cartthrob:cart_items_info}
		{if no_results}
		    <p>There is nothing in your cart</p>
		{/if}
		{!-- outputting data that's only applicable for the first item. --}
		{if first_row}
			{!-- update_cart_form allows you to edit the information of one or more items in the cart at the same time
				as well as save customer information, and shipping options. --}
    		{exp:cartthrob:update_cart_form 
				return="{template}/index"
				}
			    <table>
			        <thead>
			            <tr>
			                <td>Item</td>
			                <td colspan="2">Quantity</td>
			            </tr>
			        </thead>
			        <tbody>
		{/if}
			        <tr>
						{!-- The item_options field outputs information about a configured item option 
							any option input with the add_to_cart_form can be output using the item_options variable
							{item_options:YOUR_FIELD_NAME} will output the option value. 
							{item_options:YOUR_FIELD_NAME:option_name} will output the option text. 
							--}
		                <td><strong>{title}</strong>:  {item_options:select:product_size row_id="yes"}
						{!-- These variables are just some of the cart_items_info variables --}
						<br />Price with options: {item_price} x {quantity} = {item_subtotal}
						</td>
		                <td>
								{!-- you can reference products by entry_id and row_id. If you sell configurable 
									items (like t-shirts with multiple sizes) you should use row_id to edit and 
									delete items, otherwise, all items with that entry id
									are affected, regardless of configuration --}
	                        	<input type="text" name="quantity[{row_id}]" size="2" value="{quantity}" />
		                </td>
		                <td>
							{!-- This deletes one item (row_id) at a time--}
								<input type="checkbox" name="delete[{row_id}]"> Delete this item
		                </td>
		            </tr>
		{!-- outputting data that's only applicable for the last item. --}
		{if last_row}
			            <tr>
			                <td>
								{!-- these are just some of the variables available within the cart_items_info tag --}
			                    <p>Subtotal: {cart_subtotal}<br />
			                    Shipping: {cart_shipping}<br />
			                    Tax: {cart_tax}<br /> 
								{!--tax is updated based on user's location. To create a default tax price, set a default tax region in the backend --}
			                    <strong>Total: {cart_total}</strong></p>
								<p>
								{!-- total quantity of all items in cart --}
								Total Items: {exp:cartthrob:total_items_count}<br />
								{!-- total items in cart --}
								Total Unique Items: {exp:cartthrob:unique_items_count}</p>
			                </td>
			                <td colspan="2">&nbsp;</td>
			
			            </tr>
			        </tbody>
			    </table>
				{!-- a clear_cart input can be used to remove all items in the cart --}
			    <input type="submit" name="clear_cart" value="Empty Cart" />
			
			    <input type="submit" value="Update Cart" />
				{/exp:cartthrob:update_cart_form}
			
		{/if}
	{/exp:cartthrob:cart_items_info}
	</div>

	{!-- CHECKOUT --}
	<div class="store_block">
		<h2>Checkout</h2>
		{!--  checkout_form tag outputs a checkout form--}
		{exp:cartthrob:checkout_form 
			gateway="dev_template"
			return="{template}/order_complete"}
			{!-- The gateway_fields template variable to output fields required by your currently selected gateway 
				what you see on the front end changes based on the gateway's requirements.--}
			{gateway_fields}
			<input type="submit" value="Checkout" />
		{/exp:cartthrob:checkout_form}
	</div>
	<div class="store_block">
		<h2>Tags used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/tags_detail/add_to_cart_form">add_to_cart_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/add_to_cart_form/#var_item_options:select:your_option_name">add_to_cart_form: item_options</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/cart_items_info">cart_items_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/cart_items_info/#var_item_options:your_option">cart_items_info: item_options</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/checkout_form">checkout_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/submitted_order_info">submitted_order_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/update_cart_form">update_cart_form</a></li>
		</ul>
		<h2>Concepts used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/sub_pages/price_modifiers/">Price Modifiers</a></li>
		</ul>
	</div>
	<div class="store_block">
		{embed=includes/.footer}
	</div>

</body>
</html>		]]>
		</template>
	</template_group>
	<template_group group_name='cart_donations' group_order='3' is_site_default='n' is_user_blog='n'>
		<template template_name='index' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='4' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
{assign_variable:template="cart_donations"}
{!-- DELETE A PRODUCT --}
{if segment_2=="delete"}
{!-- The delete_from_cart tag deletes items. 
	In this case it is only called if segment_2 is "delete"
	if used on a page with other tags, place it towards the top of the page. 
	 --}
	{exp:cartthrob:delete_from_cart delete_all="yes" row_id="{segment_3}"}
{/if}
{embed=includes/.header title="Taking Donations" }

</head>
<body>
	
	<h1>Taking Donations</h1>
	<p>This page shows an example of how to take donations of any amount</p>
	{!-- ORDER COMPLETE MESSAGES --}
	{!-- The "return" paramater of the checkout form below is set back to this page with "order_complete" in the URL. 
		This saves creating a template specifically to handle order info. --}
	{if segment_2=="order_complete"}
		{!-- the submitted_order_info tag returns information from the last attempted order. --}
		{exp:cartthrob:submitted_order_info}
		    <div class="store_block">
				{if authorized}
					Your transaction is complete!<br />
			        Transaction ID: {transaction_id}<br />
			        Your total: {cart_total}<br />
			        Your order ID: {order_id}
			    {if:elseif declined}
			        Your credit card was declined: {error_message}
			    {if:elseif failed}
			        Your payment failed: {error_message}
			    {/if}
			</div>
		{/exp:cartthrob:submitted_order_info}
	{/if}

	{!-- ADD A PRODUCT --}

    <div class="store_block">
	<h2>Make a Donation</h2>
	{exp:cartthrob:add_to_cart_form 
	    return="{template}/index" 
		allow_user_price="yes"
		title="Donation"
		no_shipping="yes"
		no_tax="yes"
	    on_the_fly="true"  
		}
		<p>
			
			Donation Amount:  $<input type="text" maxlength="7" size="5" name="price"> 
			{!-- Adding a personal_message to the donation. No field called personal_message exists,
				but if you are using the "Cartthrob Order Items" custom field type in your Orders Weblog... 
				this message will still be dynamically added to the order data. 
				See the add_to_cart_form for more details
				 --}
			Donation Note: {item_options:input:personal_message value="" }<br />
		</p>
	    <input type="submit" value="Submit" />
	{/exp:cartthrob:add_to_cart_form}
	</div>


	{!-- VIEW CART CONTENTS / UPDATE QUANTITIES --}
	<div class="store_block">
		<h2>Cart Contents</h2>
		
	{!-- cart_items_info outputs information about your current cart, including products in the cart, weight, and prices. --}
	{exp:cartthrob:cart_items_info}
		{if no_results}
		<p>Your cart is empty</p>
		{/if}
		{!-- outputting data that's only applicable for the first item. --}
		{if first_row}
			<h2>Thank You.</h2>
			<p>Thank you for your donation commitment, please pay for your donation now.</p>
		{/if}
		<p>Title: {title} <br />

			Personal Message: {item_options:personal_message}<br />
			{!-- The delete URL links back to this page. 
			The segments activate the delete_from_cart tag at the top of this template.--}
			<a href="{path={template}/delete/{row_id}}">Delete</a><br />
			</p>
		
		{if last_row}
			{!-- these are just some of the variables available within the cart_items_info tag --}
			<p><strong>Total: {cart_total}</strong></p>
		{/if}
	{/exp:cartthrob:cart_items_info}
	</div>

	{!-- CHECKOUT --}
	<div class="store_block">
	<h2>Checkout</h2>
	{!-- the checkout_form  outputs a checkout form--}
	{!-- overriding the chosen gateway with the the dev_template gateway here --}
	{exp:cartthrob:checkout_form gateway="dev_template" return="{template}/order_complete"}
		{!-- The gateway_fields template variable to output fields required by your currently selected gateway 
			what you see on the front end changes based on the gateway's requirements.--}
		{gateway_fields}
		<input type="submit" value="Checkout" />
	{/exp:cartthrob:checkout_form}
	</div>
	
	<div class="store_block">
		<h2>Tags used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/tags_detail/add_to_cart_form">add_to_cart_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/cart_items_info">cart_items_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/checkout_form">checkout_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/delete_from_cart">delete_from_cart</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/submitted_order_info">submitted_order_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/update_cart_form">update_cart_form</a></li>
		</ul>
		
		<h2>Concepts used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/sub_pages/purchased_items_overview">Purchased Items Weblog</a></li>
			<li><a href="http://cartthrob.com/docs/sub_pages/orders_overview">Orders Weblog</a></li>
		</ul>
	</div>
	<div class="store_block">
		{embed=includes/.footer}
	</div>

</body>
</html>		]]>
		</template>
	</template_group>
	<template_group group_name='cart_software' group_order='4' is_site_default='n' is_user_blog='n'>
		<template template_name='index' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='4' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
{if segment_2=="download_file"}{exp:cartthrob:download_file encrypted="yes" file="{segment_3}" member_id="{segment_4}" }{/if}
{!-- it's usually a good idea to put a download_file link on its own page at the very top because nothing else is output when a download link is activated. 
	for this demo everything we need is placed on the same template to make it easier to see everything at once. 
	The view_download_link tag automatically encrypts content, so if you use that to generate your download links, you should always set encrypted to true/yes/1.  
--}{assign_variable:template="cart_software"}
{embed=includes/.header title="Software Store" }

</head>
<body>
	{!-- DELETE A PRODUCT --}
	{if segment_2=="delete"}
	{!-- The delete_from_cart tag deletes a product. 
		In this case it is only called if segment_2 is "delete"
		if used on a page with other tags, place it towards the top of the page. 
		 --}
		{exp:cartthrob:delete_from_cart delete_all="yes" row_id="{segment_3}"}
	{/if}
	
	<h1>Software Store</h1>
	<p>This page shows an example of how you can sell & protect your downloadable products</p>
	{!-- ORDER COMPLETE MESSAGES --}
	{!-- The "return" paramater of the checkout form below is set back to this page with "order_complete" in the URL. 
		This saves creating a template specifically to handle order info. --}
	{if segment_2=="order_complete"}
		{!-- the submitted_order_info tag returns information from the last attempted order. --}
		{exp:cartthrob:submitted_order_info}
		    <div class="store_block">
				{if authorized}
					Your transaction is complete!<br />
			        Transaction ID: {transaction_id}<br />
			        Your total: {cart_total}<br />
			        Your order ID: {order_id}
			    {if:elseif declined}
			        Your credit card was declined: {error_message}
			    {if:elseif failed}
			        Your payment failed: {error_message}
			    {/if}
			</div>
		{/exp:cartthrob:submitted_order_info}
	{/if}

	<div class="store_block">
		<h2>Your Previous Software Purchases</h2>
		{exp:weblog:entries weblog="purchased_items" author="CURRENT_USER" search:purchased_product_download_url="not IS_EMPTY"}
			{if no_results}
				<h3>You have not purchased any software, but here's a link anyway</h3>
				{!-- this is where you would add a link to the file the customer just purchased 
				to keep things simple, i've just added a link to a file that ships with CartThrob so you can test the download & encryption. 
				You can save information about individual items in a purchased_items weblog, or complete orders in an orders weblog.
				--}
				<a href="{exp:cartthrob:view_download_link 
					template='{path={template}/download_file}' 
					file ='{path=themes/cp_themes/default/cartthrob/images/cartthrob_logo_bg.jpg}' 
					member_id='{logged_in_member_id}'}">Download</a>
				<br />
			{/if}
			
			<a href="{exp:cartthrob:view_download_link 
				template='{path={template}/download_file}' 
				file ='{path=images/uploads/{purchased_product_download_url}}' 
				member_id='{logged_in_member_id}'}"><strong>Download</strong> <em>{title}</em> </a><br />
		{/exp:weblog:entries}
	</div>	
	{!-- ADD A PRODUCT --}
    <div class="store_block">
	<h2>Add Products</h2>
	{!-- outputting products stored in one of the "products" weblogs. These are exactly the same as normal 
		product weblogs, so the weblog names may be different from what is listed below --}
	{exp:weblog:entries weblog="products" limit="10"}
		{!-- The add_to_cart_form adds 1 or more of a product to the cart --}
		{!-- checking to see if this product has any content in the product_download_url custom field --}
		{if product_download_url}
			{exp:cartthrob:add_to_cart_form 
				entry_id="{entry_id}" 
				return="{template}/index"}
					<p>Product name: {title}<br />
					Price: ${product_price}<br />
					Quantity: <input type="text" name="quantity" size="5" value="" /><br />
					<input type="hidden" name="item_options[purchased_product_download_url]" value="{product_download_url}" />
					{!-- this field gathers information for the purchased items weblog's custom field call purchased_product_download_url 
						If you do something similar, you can name the field anything you want, 
						as long as you add the field name as a key to the item options input field  --}
				
					<input type="submit" value="Add to Cart">
					</p>
			{/exp:cartthrob:add_to_cart_form}
		{/if}
	{/exp:weblog:entries}
	</div>

	{!-- VIEW CART CONTENTS / UPDATE QUANTITIES --}
	<div class="store_block">
	<h2>Cart Contents</h2>
	{!-- cart_items_info outputs information about your current cart, including products in the cart, weight, and prices. --}
	{exp:cartthrob:cart_items_info}
		{if no_results}
		    <p>There is nothing in your cart</p>
		{/if}
		{!-- outputting data that's only applicable for the first item. --}
		{if first_row}
			    <table>
			        <thead>
			            <tr>
			                <td>Item</td>
			                <td colspan="2">Quantity</td>
			            </tr>
			        </thead>
			        <tbody>
		{/if}
			        <tr>
		                <td>{title}</td>
		                <td>
		                </td>
		                <td>
							{!-- This URL links back to this page. 
								The segments activate the delete_from_cart tag at the top of this template.--}
							<a href="{path={template}/delete/{row_id}}">Delete</a>
		                </td>
		            </tr>
		{if last_row}
		{!-- outputting data that's only applicable for the last item. --}
			            <tr>
			                <td>
								{!-- these are just some of the variables available within the cart_items_info tag --}
			                    <p>Subtotal: {cart_subtotal}<br />
			                    Shipping: {cart_shipping}<br />
			                    Tax: {cart_tax}<br /> 
								{!--tax is updated based on user's location. To create a default tax price, set a default tax region in the backend --}
			                    <strong>Total: {cart_total}</strong></p>
								<p>
								{!-- total quantity of all items in cart --}
								Total Items: {exp:cartthrob:total_items_count}<br />
								{!-- total items in cart --}
								Total Unique Items: {exp:cartthrob:unique_items_count}</p>
			                </td>
			                <td colspan="2">&nbsp;</td>
			
			            </tr>
			        </tbody>
			    </table>
			    <input type="submit" value="Update Cart" />
		{/if}
	{/exp:cartthrob:cart_items_info}
	</div>

	{!-- CHECKOUT --}
	<div class="store_block">
	<h2>Checkout</h2>
	{!-- the checkout_form  outputs a checkout form--}
	{!-- overriding the chosen gateway with the the dev_template gateway here --}
	{exp:cartthrob:checkout_form gateway="dev_template" return="{template}/order_complete"}
		{!-- The gateway_fields template variable to output fields required by your currently selected gateway 
			what you see on the front end changes based on the gateway's requirements.--}
		{gateway_fields}
		<input type="submit" value="Checkout" />
	{/exp:cartthrob:checkout_form}
	</div>
	
	<div class="store_block">
		<h2>Tags used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/tags_detail/add_to_cart_form">add_to_cart_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/cart_items_info">cart_items_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/checkout_form">checkout_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/delete_from_cart">delete_from_cart</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/download_file">download_file</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/submitted_order_info">submitted_order_info</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/update_cart_form">update_cart_form</a></li>
			<li><a href="http://cartthrob.com/docs/tags_detail/view_download_link">view_download_link</a></li>
		</ul>
		<h2>Concepts used in this template</h2>
		<ul>
			<li><a href="http://cartthrob.com/docs/sub_pages/purchased_items_overview">Purchased Items Weblog</a></li>
		</ul>
	</div>
	<div class="store_block">
		{embed=includes/.footer}
	</div>

</body>
</html>		]]>
		</template>
	</template_group>
	<template_group group_name='includes' group_order='6' is_site_default='n' is_user_blog='n'>
		<template template_name='index' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='0' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits='' />
		<template template_name='.header' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<head>
	<title>{embed:title}</title>
	<style type="text/css">
	body{
			font: 11px "Lucida Grande", Lucida, Verdana, sans-serif;
		}
		h1{
			font-size: 18px;
			font-weight: bold;
		}
		h2{
			font-size: 16px;
			font-weight: bold;
		}
		h3{
			font-size: 13px;
			font-weight: bold;
		}
		h4{
			font-size: 12px;
			font-weight: bold;
		}
		.store_block{
			padding:12px;
			margin-top: 12px;
			margin-bottom:12px;
		background-color: #e1fefd;
	}
	</style>		]]>
		</template>
		<template template_name='.footer' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
<h2>Other Store Examples</h2>
<ul>
<li><a href="{path=cart_donations}">Taking Donations</a></li>
<li><a href="{path=cart_single_page_checkout}">Single Page Checkout</a></li>
<li><a href="{path=cart_software}">Selling Software</a></li>
<li><a href="{path=cart_tshirt}">Selling Configurable Products (t-shirts)</a></li>
</ul>
<h2>Admin</h2>
<ul>
<li><a href="{path=reports}">Admin Reports</a></li>
</ul>		]]>
		</template>
		<template template_name='payment_code_override' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
<h1>Paypal Standard</h1>
	<fieldset class="billing" >
		<label for="first_name" class="required">
			First Name
		</label><input type="text" name="first_name" />
		
		<label for="last_name">
			Last Name
		</label><input type="text" name="last_name" />
		
		<label for="email_address">
			Email Address
		</label><input type="text" name="email_address" />
		
		<label for="address">
			Address
		</label><input type="text" name="address" />
		
		<label for="address2">
			Address 2
		</label><input type="text" name="address2" />
		
		<label for="city">
			City
		</label><input type="text" name="city" />
		
		<label for="state">
			State
		</label><input type="text" name="state" />
		
		<label for="zip">
			Zip
		</label><input type="text" name="zip" />
		
		<label for="country_code">
			Country Code
		</label><input type="text" name="country_code" />

<label><input type="checkbox" value="1" name="use_billing_info" /> Use Billing Info?</label>
		
		<label for="description">
			Description
		</label><input type="text" name="description" />
	</fieldset>
			]]>
		</template>
		<template template_name='debug' save_template_file='n' template_type='webpage' template_notes='' edit_date='' last_author_id='1' cache='n' refresh='0' no_auth_bounce='61' enable_http_auth='n' allow_php='n' php_parse_location='o' hits=''>
		<![CDATA[
{!-- uncomment to activate--}{!--{exp:cartthrob:debug_info}--}		]]>
		</template>
	</template_group>
</create>
<?php
		$content = ob_get_contents();
		
		ob_end_clean();
		
		return $content;
	}
	// END 
	
	// --------------------------------
	//  Clean Attributes
	// --------------------------------
	/**
	 * Clean up XML attributes before parsing
	 *
	 * @access private
	 * @param obj $xml XML object
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */	
	function _clean_attributes(&$xml)
	{
		if ( ! is_object($xml) || ! isset($xml->attributes) || ! is_array($xml->attributes))
		{
			return;
		}
		
		foreach ($xml->attributes as $key => $value)
		{
			$xml->attributes[$key] = str_replace(
				array(
				      '\n',
				      '\r'
				),
				array(
				      "\n",
				      "\r"
				),
				$value
			);
		}
		
		if (isset($xml->children) && count($xml->children))
		{
			foreach ($xml->children as $key => $value)
			{
				$this->_clean_attributes($xml->children[$key]);
			}
		}
	}
	// END

	// --------------------------------
	//  Clean Fields
	// --------------------------------	
	/**
	 * Remove data from array if the key is not a field in the specified table
	 *
	 * @access private
	 * @param string $table Database table name
	 * @param array $data data to be cleaned
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _clean_fields($table, &$data)
	{
		global $DB;
		
		$query = $DB->query("SHOW COLUMNS FROM ".$DB->escape_str($table));
		
		$fields = array();
		
		foreach ($query->result as $row)
		{
			$fields[] = $row['Field'];
		}
		
		foreach ($data as $key => $value)
		{
			if ( ! in_array($key, $fields))
			{
				unset($data[$key]);
			}
		}
	}
	// END 

	// --------------------------------
	//  Create Category
	// --------------------------------
	/**
	 * Create a category from an XML object
	 *
	 * @access private
	 * @param obj $category XML object
	 * @param int $group_id category group id
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_category($category, $group_id)
	{
		global $DB, $PREFS;

		$category_data = $category->attributes;
		
		$category_data['site_id'] = $PREFS->ini('site_id');

		$category_data['group_id'] = $group_id;
		
		$original_name = $category_data['category_name'];

		$category_data['category_name'] = $this->_rename('exp_categories', $original_name, 'category_name', array('group_id'=>$group_id));

		if ($category_data['category_name'] === FALSE)
		{
			return $this->_log_error('category_exists', $original_name);
		}
		
		$this->_insert('exp_categories', $category_data);
		
		$this->_log_install('category', $category_data['category_name']);
	}

	// --------------------------------
	//  Create Category Group
	// --------------------------------	
	/**
	 * Create a category group from an XML object
	 *
	 * @access private
	 * @param obj $category_group XML object
	 * @return int $group_id
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_category_group($category_group)
	{
		global $DB, $PREFS;

		$category_group_data = $category_group->attributes;

		$category_group_data['site_id'] = $PREFS->ini('site_id');
		
		$group_id = $this->_exists('exp_category_groups', array('group_name'=>$category_group_data['group_name']), 'group_id', TRUE);
		
		if ( ! $group_id)
		{
			$group_id = $this->_insert('exp_category_groups', $category_group_data);
		
			$this->_log_install('category_group', $category_group_data['group_name']);
		}

		foreach ($category_group->children as $category_group_child)
		{
			switch ($category_group_child->tag)
			{
				case 'category':
					$this->_create_category($category_group_child, $group_id);
					break;
			}
		}
		
		return $group_id;
	}
	// END

	// --------------------------------
	//  Create Field
	// --------------------------------
	/**
	 * Create a custom field from an XML object
	 *
	 * @access private
	 * @param obj $field XML object
	 * @param int $group_id custom field group id
	 * @param int $field_order custom field order
	 * @param bool $fieldframe set true if field is a FieldFrame field
	 * @param bool $ff_matrix set true if field is an FF Matrix field
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_field($field, $group_id, $field_order, $fieldframe = FALSE, $ff_matrix = FALSE)
	{
		global $DB, $PREFS;

		$field_data = $field->attributes;
		
		$original_name = $field_data['field_name'];
		
		$field_data['site_id'] = $PREFS->ini('site_id');
		
		$field_data['field_name'] = $this->_rename('exp_weblog_fields', $original_name, 'field_name');

		if ($field_data['field_name'] === FALSE)
		{
			return $this->_log_error('field_exists', $original_name);
		}

		$field_data['group_id'] = $group_id;

		$field_data['field_order'] = $field_order;

		if ($fieldframe)
		{
			$field_type = ( ! $ff_matrix) ? $field_data['field_type'] : 'ff_matrix';

			$query = $DB->query("SELECT fieldtype_id
								FROM exp_ff_fieldtypes
								WHERE class = '$field_type'
								LIMIT 1");

			if ( ! $query->num_rows)
			{
				return $this->_log_error('nonexistent_ftype', $field_type, $original_name);
			}

			$field_data['field_type'] = 'ftype_id_'.$query->row['fieldtype_id'];

			if ($ff_matrix)
			{
				$max_rows = (isset($field_data['max_rows'])) ? $field_data['max_rows'] : '';

				unset($field_data['max_rows']);

				$ff_settings = array(
					'max_rows' => $max_rows,
					'cols' => array()
				);

				foreach ($field->children as $col)
				{
					$col_data = $col->attributes;

					if (isset($col->children) && count($col->children))
					{
						$col_data['settings'] = $col->children[0]->attributes;
					}

					$ff_settings['cols'][] = $col_data;
				}

				$field_data['ff_settings'] = (isset($field_data['ff_settings'])) ? $field_data['ff_settings'] : serialize($ff_settings);
			}
		}

		$field_id = $this->_insert('exp_weblog_fields', $field_data);

		$this->_query("ALTER TABLE exp_weblog_data ADD COLUMN field_id_".$field_id." text NOT NULL");

		$this->_query("ALTER TABLE exp_weblog_data ADD COLUMN field_ft_".$field_id." tinytext NULL");
		
		$this->_log_install('field', $field_data['field_name']);
	}
	// END
	
	// --------------------------------
	//  Create Field Group
	// --------------------------------
	/**
	 * Create a custom field group from an XML object
	 *
	 * @access private
	 * @param obj $field_group XML object
	 * @return int $group_id
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_field_group($field_group)
	{
		global $DB, $PREFS;

		$field_group_data = $field_group->attributes;
		
		$original_name = $field_group_data['group_name'];
		
		$field_group_data['site_id'] = $PREFS->ini('site_id');
		
		$field_group_data['group_name'] = $this->_rename('exp_field_groups', $original_name, 'group_name');

		if ($field_group_data['group_name'] === FALSE)
		{
			return $this->_log_error('field_group_exists', $original_name);
		}
		
		$group_id = $this->_insert('exp_field_groups', $field_group_data);
		
		$this->_log_install('field_group', $field_group_data['group_name']);

		$field_order = 1;

		foreach ($field_group->children as $field_group_child)
		{
			switch ($field_group_child->tag)
			{
				case 'field':
					$this->_create_field($field_group_child, $group_id, $field_order);
					break;

				case 'fieldframe':
					$this->_create_field($field_group_child, $group_id, $field_order, TRUE);
					break;

				case 'ff_matrix':
					$this->_create_field($field_group_child, $group_id, $field_order, TRUE, TRUE);
					break;
			}

			$field_order++;
		}

		return $group_id;
	}
	// END

	// --------------------------------
	//  Create Member Group
	// --------------------------------
	/**
	 * Create a member group from an XML object
	 *
	 * @access private
	 * @param obj $template_group XML object
	 * @return int $group_id
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_member_group($member_group)
	{
		global $DB, $PREFS;

		$member_group_data = $member_group->attributes;

		$member_group_data['site_id'] = $PREFS->ini('site_id');
		
		$group_id = $this->_exists('exp_member_groups', array('group_title'=>$member_group_data['group_title']), 'group_id', TRUE);
		
		if ( ! $group_id)
		{
			$group_id = $this->_insert('exp_member_groups', $member_group_data);
		
			$this->_log_install('member_group', $member_group_data['group_title']);
		}
		else
		{
			$this->_log_error('member_group_exists', $member_group_data['group_title']);
		}
	}
	// END 

	// --------------------------------
	//  Create Template
	// --------------------------------
	/**
	 * Create a template from an XML object
	 *
	 * @access private
	 * @param obj $template XML object
	 * @param int $group_id custom field group id
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_template($template, $group_id)
	{
		global $DB, $PREFS;

		$template_data = $template->attributes;
		
		$template_data['site_id'] = $PREFS->ini('site_id');

		$template_data['group_id'] = $group_id;

		$template_data['template_data'] = $template->value;

		if ($this->_exists('exp_templates', array('group_id' => $group_id, 'template_name' => $template_data['template_name']), FALSE, TRUE))
		{
			return $this->_log_error('template_exists', $template_data['template_name']);
		}
		
		/*
		$original_name = $template_data['template_name'];

		$template_data['template_name'] = $this->_rename('exp_templates', $original_name, 'template_name', array('group_id'=>$group_id));
		*/

		if ($template_data['template_name'] === FALSE)
		{
			return $this->_log_error('template_exists', $original_name);
		}
		
		$this->_insert('exp_templates', $template_data);
		
		$this->_log_install('template', $template_data['template_name']);
	}
	// END
	
	// --------------------------------
	//  Create Template Group
	// --------------------------------
	/**
	 * Create a template group from an XML object
	 *
	 * @access private
	 * @param obj $template_group XML object
	 * @return int $group_id
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_template_group($template_group)
	{
		global $DB, $PREFS;

		$template_group_data = $template_group->attributes;

		$template_group_data['site_id'] = $PREFS->ini('site_id');
		
		if ($template_group_data['is_site_default'] == 'y')
		{
			$query = $DB->query("SELECT *
					    FROM exp_template_groups
					    WHERE is_site_default = 'y'");
			
			if ($query->num_rows)
			{
				$template_group_data['is_site_default'] = 'n';
			}
		}
		
		$group_id = $this->_exists('exp_template_groups', array('group_name'=>$template_group_data['group_name']), 'group_id', TRUE);
		
		if ( ! $group_id)
		{
			$group_id = $this->_insert('exp_template_groups', $template_group_data);
		
			$this->_log_install('template_group', $template_group_data['group_name']);
		}

		foreach ($template_group->children as $template_group_child)
		{
			switch ($template_group_child->tag)
			{
				case 'template':
					$this->_create_template($template_group_child, $group_id);
					break;
			}
		}
	}
	// END
	
	// --------------------------------
	//  Create Weblog
	// --------------------------------
	/**
	 * Create a weblog from an XML object
	 *
	 * @access private
	 * @param obj $weblog XML object
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _create_weblog($weblog)
	{
		global $DB, $PREFS;

		$weblog_data = $weblog->attributes;

		if ($this->_exists('exp_weblogs', array('blog_name'=>$weblog_data['blog_name']), FALSE, TRUE))//@TODO
		{
			return $this->_log_error('blog_exists', $weblog_data['blog_name']);
		}
		
		$cat_group = array();

		foreach ($weblog->children as $weblog_child)
		{
			switch ($weblog_child->tag)
			{
				case 'field_group':
					$weblog_data['field_group'] = $this->_create_field_group($weblog_child);
					break;
				case 'categories':
					$cat_group[] = $this->_create_category_group($weblog_child);
					break;
			}
		}
		
		$weblog_data['cat_group'] = (isset($weblog_data['cat_group']) && ! count($cat_group)) ? $weblog_data['cat_group'] : implode('|', $cat_group);

		$weblog_data['site_id'] = $PREFS->ini('site_id');

		$weblog_data['blog_lang'] = $PREFS->ini('xml_lang');

		$weblog_data['blog_encoding'] = $PREFS->ini('charset');

		$this->_insert('exp_weblogs', $weblog_data);
		
		$this->_log_install('weblog', $weblog_data['blog_name']);
	}
	// END

	// --------------------------------
	//  Exists
	// --------------------------------	
	/**
	 * Check to see if a database record exists in the specified table
	 * Will return the id if $id_field is specified
	 *
	 * @access private
	 * @param string $table name of table to check
	 * @param array $data key=>value pairs of which columns to check for match
	 * @param string $id_field name of id column
	 * @return bool|int $id_field
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _exists($table, $data, $id_field = FALSE, $check_site_id = FALSE)
	{
		global $DB, $PREFS;
		
		$count = 0;
		
		$sql = 'SELECT ';
		
		$sql .= ($id_field) ? '`'.$DB->escape_str($id_field).'`' : '*';
		
		$sql .= ' FROM `'.$DB->escape_str($table).'`';
		
		if ($check_site_id)
		{
			$data['site_id'] = $PREFS->ini('site_id');
		}
		
		foreach ($data as $key => $value)
		{
			$sql .= ( ! $count) ? ' WHERE' : ' AND';
			
			$sql .= ' `'.$DB->escape_str($key)."` = '".$DB->escape_str($value)."'";
			
			$count++;
		}
		
		$query = $DB->query($sql);
		
		return ($id_field && $query->num_rows) ? $query->row[$id_field] : $query->num_rows;
	}
	// END

	// --------------------------------
	//  Insert
	// --------------------------------	
	/**
	 * Insert a record into the database
	 * 
	 * @access private
	 * @param string $table the database table name
	 * @param array $data a keyed array of the data to insert
	 * @return int $DB->insert_id
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _insert($table, $data)
	{
		global $DB;
		
		$this->_clean_fields($table, $data);
	
		$DB->query($DB->insert_string($table, $data));

		return $DB->insert_id;
	}
	// END 
	
	// --------------------------------
	//  Load XML
	// --------------------------------	
	/**
	 * Loads & parses Template XML and returns relevant template content
	 * 
	 * @access private
	 * @param string $xml 
	 * @return string|array error | weblog, template_group, and member_group XML
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _load_xml($xml)
	{
		if ( ! class_exists('EE_XMLparser'))
		{
			require PATH_CORE.'core.xmlparser'.EXT;
		}

		$XMLparser = new EE_XMLparser;

		$xml = $XMLparser->parse_xml($xml);
		
		if ($xml === FALSE)
		{
			return $this->_log_error('xml_error');
		}
		
		$node_index = 0;
		
		$nodes = array();

		foreach ($xml->children as $node)
		{
			switch ($node->tag)
			{
				case 'weblog':
					$nodes[$node_index] = array('name'=>$node->attributes['blog_name'], 'type'=>'weblog');
					break;

				case 'template_group':
					$nodes[$node_index] = array('name'=>$node->attributes['group_name'], 'type'=>'template_group');
					break;
				
				case 'member_group':
					$nodes[$node_index] = array('name'=>$node->attributes['group_name'], 'type'=>'member_group');
					break;
			}
			
			$node_index++;
		}
		
		return $nodes;
	}
	// END 
	
	// --------------------------------
	//  Load XML
	// --------------------------------
	/**
	 * Log an error to be displayed on process
	 * 
	 * @access private
	 * @param string $error the error code
	 * @param string $data first string of data for error msg
	 * @param string $second_data second string of data for error msg
	 * @return string $xml
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _log_error($error, $data = FALSE, $second_data = FALSE)
	{
		if ($data !== FALSE)
		{
			if ($second_data !== FALSE)
			{
				$error = array($error, $data, $second_data);
			}
			else
			{
				$error = array($error, $data);	
			}
		}
		$this->template_errors[] = $error;
	}
	// END 
	
	// --------------------------------
	//  Log Install
	// --------------------------------
	/**
	 * Logs a successful "Auto-Install" action 
	 * 
	 * @access private
	 * @param string $type the type (weblog, template, etc) installed
	 * @param string $name the name of the type installed
	 * @return void
	 * @author Rob Sanchez
	 * @since 1.0.0
	 * @subpackage CT Template Installer
	 */
	function _log_install($type, $name)
	{
		$this->templates_installed[] = array($type, $name);
	}
	// END
	
	// --------------------------------
	//  PARSE XML
	// --------------------------------
	/**
	 * Parse through and install the submitted XML
	 * 
	 * @access private
	 * @return void
	 * @since 1.0.0
	 * @author Rob Sanchez
	 * @subpackage CT Template Installer
	 */
	function _parse_xml($xml, $nodes = array())
	{
		global $DB, $DSP;

		if ( ! class_exists('EE_XMLparser'))
		{
			require PATH_CORE.'core.xmlparser'.EXT;
		}

		$XMLparser = new EE_XMLparser;

		$xml = $XMLparser->parse_xml($xml);
		
		if ($xml === FALSE)
		{
			return $this->_log_error('xml_error');
		}
		
		$node_index = 0;
		
		if ( ! is_array($nodes))
		{
			$nodes = array();
		}
		
		$this->_clean_attributes($xml);

		foreach ($xml->children as $node)
		{
			if (in_array($node_index, $nodes))
			{
				switch ($node->tag)
				{
					case 'weblog':
						$this->_create_weblog($node);
						break;
	
					case 'template_group':
						$this->_create_template_group($node);
						break;
					
					case 'member_group':
						$this->_create_member_group($node);
						break;
				}
			}
			
			$node_index++;
		}
	}
	// END
	
	// --------------------------------
	//  QUERY
	// --------------------------------
	/**
	 * Run a database query
	 * 
	 * Utility function, useful for running database queries 
	 * without having to remember to call global $DB at the 
	 * start of every function that might use queries. 
	 * 
	 * @access private
	 * @param string $sql the query to run
	 * @return int $DB->insert_id
	 * @author Rob Sanchez
	 * @since 1.0.0
	 * @subpackage CT Template Installer
	 */
	function _query($sql)
	{
		global $DB;

		$DB->query($sql);

		return $DB->insert_id;
	}
	// END
	
	// --------------------------------
	//  RENAME
	// --------------------------------
	/**
	 * Checks to see if a record exists for a certain name,
	 * and if so, it will append an integer to the end of the
	 * name in an attempt to generate a unique name.
	 * If the set limit $this->rename_limit is reached it will
	 * return FALSE.
	 * 
	 * @access private
	 * @param string $table the database table to check
	 * @param string $name the name to check
	 * @param string $field the name of the name database column
	 * @param array $data additional data to check against
	 * @return string|bool
	 * @author Rob Sanchez
	 * @since 1.0.0
	 * @subpackage CT Template Installer
	 */
	function _rename($table, $name, $field, $data = array())
	{
		$rename_limit = 25;

		$original_name = $name;

		$count = '';

		do
		{
			$name = $original_name.$count;

			$count++;

			$exists = $this->_exists($table, array_merge(array($field=>$name), $data));

		} while ($count < $rename_limit && $exists);

		return ($count == $rename_limit && $exists) ? FALSE : $name;
	}
	// END

	function log($action)
	{
		if (empty($this->LOG))
		{
			if ( ! class_exists('Logger'))
			{
				require PATH_CP.'cp.log'.EXT;
			}
			
			$this->LOG = new Logger;
		}
		
		$this->LOG->log_action($action);
	}
	// END
	/**
	 * get_news
	 *
	 * @return string
	 * @author Newton
	 **/
	function get_news()
	{
		global $LANG; 
		$data = $this->curl_transaction("http://cartthrob.com/site/versions/cartthrob_ecommerce_system", NULL, TRUE); 
		$return_data['version_update'] = NULL; 
		$return_data['news'] = NULL; 
		
		if (empty($data))
		{
			return $return_data; 
		}
		$content = $this->split_url_string($data);

		if ($content['version'] > $this->version)
		{
			$return_data['version_update'] = "<a href='http://cartthrob.com/cart/purchased_items/'>CartThrob has been updated to version ". $content['version']. "</a>";
		}
		else
		{
			$return_data['version_update'] 	= $LANG->line('there_are_no_updates'); 
		}
		if (!empty($content['news']))
		{
			$return_data['news'] = stripslashes(urldecode($content['news']));
		}
		return $return_data; 
	}
	/**
	 * split_url_string
	 *
	 * converts a urlencoded string into an array. 
	 *  
	 * @access public
	 * @param string $url_string URLencoded string to split
	 * @return array
	 * @author Chris Newton
	 * @since 1.0.0
	 * @author Rob Sanchez
	 **/
	function split_url_string($url_string, $split_character = "&")
	{
		$array = explode($split_character, $url_string);
		$i = 0;
		while ($i < count($array)) {
			$b = explode('=', $array[$i]);
			if ( ! isset($b[1]))
			{
				$b[1] = '';
			}
			$no_space_key=rtrim(htmlspecialchars(urldecode($b[0])));
			$new_array[$no_space_key] = htmlspecialchars(urldecode($b[1]));
			$i++;
		}
		return $new_array;
	}
	
	/**
	 * Curl Transaction
	 *
	 * This is a simple curl function for sending data
	 * 
	 * @param string $post_url (url to CURL to)
	 * @param array $data (data to send)
	 * @return string response from post_url server
	 * @access public
	 * @author Chris Newton
	 * @since 1.0.0
	 **/
	function curl_transaction($post_url,$data=NULL, $suppress_errors = FALSE)
	{
		global $OUT, $LANG;

		if ( ! function_exists('curl_exec'))
		{
			// @TODO add to language file
			return $OUT->show_user_error('general', $LANG->line('curl_not_installed'));
		}
		// CURL Data to institution
		$curl = curl_init($post_url);
		curl_setopt($curl, CURLOPT_HEADER, 0); 						// set to 0 to eliminate header info from response
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 				// Returns response data instead of TRUE(1)
		if ($data)
		{
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data); 				// use HTTP POST to send form data
		}
		// curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.5) Gecko/20041107 Firefox/1.0');
		// Turn off the server and peer verification (PayPal TrustManager Concept).
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);

		$response = curl_exec($curl); 								// execute post and get results

		if ( ! $response)
		{
			$error = curl_error($curl).'('.curl_errno($curl).')';
		}

		curl_close($curl);

		if ($suppress_errors || !$error)
		{
			return $response; 
		}
		else	
		{
			return $OUT->show_user_error('general', $error);
		}
	}
	// END
	/**
	 * data_array_to_string
	 *
	 * converts an array to a URLencoded string. This is useful for passing data via curl, or url
	 * 
	 * @access public
	 * @param array $post_array array of data to be converted
	 * @return string
	 * @author Chris Newton
	 * @since 1.0.0
	**/
	function data_array_to_string($post_array)
	{
		if (function_exists('http_build_query'))
		{
			return http_build_query($post_array,'', '&');
		}

		$data='';
		while (list ($key, $val) = each($post_array)) 
		{
			$data .= $key . "=" . urlencode(stripslashes(str_replace("\n", "\r\n", $val))) . "&";
		}
		if ($data !="")
		{
			$data = substr($data,0,-1);
		}
		return $data;

	} 
	// END
}
// END CLASS
/* End of file ext.cartthrob_ext.php */
/* Location: ./system/extension/ext.cartthrob_ext.php */