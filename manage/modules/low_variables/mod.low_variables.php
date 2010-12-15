<?php if ( ! defined('EXT')) exit('Invalid file request');

// Include config.php
include(PATH_MOD.'low_variables/config.php');

/**
* Low Variables Module Class
*
* Class to be used in templates
*
* @package		low-variables-ee_addon
* @version		1.3.4
* @author		Lodewijk Schutte <low@loweblog.com>
* @link			http://loweblog.com/software/low-variables/
* @copyright	Copyright (c) 2009, Low
*/

class Low_variables {

	/**
	*	Return data
	*
	*	@var	string
	*/
	var $return_data = '';

	// --------------------------------------------------------------------

	/**
	*	PHP4 Constructor
	*
	*	@see	__construct()
	*	@since	1.1.4
	*/
	function Low_variables()
	{
		$this->__construct();
	}

	// --------------------------------------------------------------------

	/**
	*	PHP5 constructor
	*
	*	@return	void
	*	@since	1.1.4
	*/
	function __construct()
	{
		// Nuthin...
	}

	// --------------------------------------------------------------------

	/**
	*	Parse global template variables, call type class if necessary
	*
	*	@return	string
	*/
	function parse()
	{
		global $TMPL, $DB, $PREFS, $SESS, $REGX, $FNS;

		/** -------------------------------------
		/**  Get parameter
		/** -------------------------------------*/

		$var = $TMPL->fetch_param('var');

		/** -------------------------------------
		/**  Site specific var?
		/** -------------------------------------*/

		if (strpos($var, ':') !== FALSE)
		{
			$tmp = explode(':', $var, 2);
			$site_id = $this->_get_site_id($tmp[0]);
			$var = $tmp[1];
		}
		else
		{
			$site_id = $PREFS->ini('site_id');
		}

		/** -------------------------------------
		/**  Set returndata
		/** -------------------------------------*/

		$tagdata = $TMPL->tagdata;

		/** -------------------------------------
		/**  Get variable data from cache or DB
		/** -------------------------------------*/

		if (isset($SESS->cache['low']['variables']['data'][$site_id]))
		{
			$TMPL->log_item('Low Variables: Getting variable data from Session Cache');

			$data = $SESS->cache['low']['variables']['data'][$site_id];
		}
		else
		{
			$TMPL->log_item('Low Variables: Getting variable data from Database');

			/** -------------------------------------
			/**  Init data array
			/** -------------------------------------*/

			$data = array();

			/** -------------------------------------
			/**  Query DB
			/** -------------------------------------*/

			$rows = $this->_get_variables(array("ee.site_id = '".$DB->escape_str($site_id)."'"));

			/** -------------------------------------
			/**  Get results
			/** -------------------------------------*/

			foreach ($rows AS $row)
			{
				// Prep settings
				$row['variable_settings'] = $this->_get_type_settings($row['variable_type'], $row['variable_settings']);

				// Add prep'd row to data array
				$data[$row['variable_name']] = $row;
			}

			/** -------------------------------------
			/**  Register to cache
			/** -------------------------------------*/

			$SESS->cache['low']['variables']['data'][$site_id] = $data;
		}

		/** -------------------------------------
		/**  Get variable types from cache or db
		/** -------------------------------------*/

		if (isset($SESS->cache['low']['variables']['types']))
		{
			$types = $SESS->cache['low']['variables']['types'];
		}
		else
		{
			$types = $SESS->cache['low']['variables']['types'] = Low_variables_ext::get_types($SESS->cache['low']['variables']['settings']['enabled_types']);
		}

		/** -------------------------------------
		/**  Replace variables
		/** -------------------------------------*/

		if ( ! empty($var) && isset($data[$var]))
		{
			/** -------------------------------------
			/**  Single variable defined: try to call its class
			/** -------------------------------------*/

			// Get variable type for easy reference
			$type = $data[$var]['variable_type'];

			// If class doesn't exist, include its file
			if ( ! class_exists($types[$type]['class']) )
			{
				$TMPL->log_item('Low Variables: Including type class '.$types[$type]['class']);

				if (isset($types[$type]) && file_exists($types[$type]['path'].$types[$type]['file']))
				{
					include_once $types[$type]['path'].$types[$type]['file'];
				}
				else
				{
					$TMPL->log_item("Low Variables: Variable type {$type} is not installed or enabled");
					return;
				}
			}

			/** -------------------------------------
			/**  Check if correct method exists; if so, call it
			/** -------------------------------------*/

			// Create object
			$OBJ = ($types[$type]['is_fieldtype'] === TRUE) ? new Low_fieldtype_bridge($types[$type]) : new $types[$type]['class'];

			if (method_exists($OBJ, 'display_output'))
			{
				$TMPL->log_item('Low Variables: Calling '.get_class($OBJ).'::display_output()');

				// Call function
				$output = $OBJ->display_output($tagdata, $data[$var]);
			}
			else
			{
				$output = FALSE;
			}

			// Assign output to tagdata if valid
			if ($output !== FALSE)
			{
				$tagdata = $output;
			}
			else
			{
				$TMPL->log_item('Low Variables: '.get_class($OBJ).'::display_output() was not valid, default parsing now');

				// Check for multiple values
				if ($TMPL->fetch_param('multiple') == 'yes' && (($sep = $OBJ->get_setting('separator', $data[$var]['variable_settings'])) !== FALSE) )
				{
					if (strlen($data[$var]['variable_data']))
					{
						// Convert variable data to array
						$value_array = explode($OBJ->separators[$sep], $data[$var]['variable_data']);

						// Get labels, if present
						if ( ($value_labels = $OBJ->get_setting('options', $data[$var]['variable_settings'])) )
						{
							$value_labels = $OBJ->explode_options($value_labels);
						}

						// Initiate loopdata and counter
						$loopdata = '';
						$total_results = count($value_array);
						$count = 0;

						// Limit results?
						if (($limit = $TMPL->fetch_param('limit')) && is_numeric($limit) && $total_results > $limit)
						{
							$value_array = array_slice($value_array, 0, $limit);
							$total_results = $limit;
						}

						// Loop through values
						foreach ($value_array AS $value)
						{
							// Template variables and their replacements
							$tmpl_vars = array(
								'count'			=> ++$count,
								'total_results'	=> $total_results,
								'value'			=> $value,
								$var			=> $value,
								'label'			=> ( isset($value_labels[$value]) ? $value_labels[$value] : '' )
							);

							// Process conditionals and get template chunk
							$chunk = $FNS->prep_conditionals($tagdata, $tmpl_vars);

							// Replace single variables
							foreach ($tmpl_vars AS $k => $v)
							{
								$chunk = $TMPL->swap_var_single($k, $v, $chunk);
							}

							// Add chunk to loopdata
							$loopdata .= $chunk;
						}

						$tagdata = $loopdata;
					}
					else
					{
						// No values -- show No Results
						$tagdata = $TMPL->no_results();
					}
				}
				else
				{
					// replace tagdata normally
					$tagdata = (empty($tagdata)) ? $data[$var]['variable_data'] : str_replace(LD.$var.RD, $data[$var]['variable_data'], $tagdata); 
				}
			}

			// Clean up
			unset($OBJ);

		}
		else
		{
			/** -------------------------------------
			/**  No single var was given, so just replace all vars with their values
			/** -------------------------------------*/

			$TMPL->log_item('Low Variables: Replacing all variables inside tag pair with their data');

			// Initiate variables array
			$variables = array();

			// Add regular variable
			foreach ($data AS $key => $row)
			{
				$variables[$key] = $row['variable_data'];
			}

			// Process conditionals
			$tagdata = $FNS->prep_conditionals($tagdata, $variables);

			// Replace single variables
			foreach ($variables AS $k => $v)
			{
				$tagdata = $TMPL->swap_var_single($k, $v, $tagdata);
			}
		}

		// Assign tagdata to return data
		$this->return_data = $tagdata;

		/** -------------------------------------
		/**  Return parsed data
		/** -------------------------------------*/

		return $this->return_data;
	}

	// --------------------------------------------------------------------

	/**
	*	Fetch and return options from var settings
	*
	*	Usage: {exp:low_variables:options var="my_variable_name"} {option:value}, {option:label} {/exp:low_variables:options}
	*
	*	@return	string
	*/
	function options()
	{
		global $TMPL, $DB, $PREFS, $SESS, $REGX;

		/** -------------------------------------
		/**  Initiate return data
		/** -------------------------------------*/

		$this->return_data = $TMPL->tagdata;

		/** -------------------------------------
		/**  Get parameter
		/** -------------------------------------*/

		if ( ! ($var = $TMPL->fetch_param('var')) )
		{
			$TMPL->log_item('Low Variables: No var-parameter found, returning raw data');

			return $this->return_data;
		}

		/** -------------------------------------
		/**  Site specific var?
		/** -------------------------------------*/

		if (strpos($var, ':') !== FALSE)
		{
			$tmp = explode(':', $var, 2);
			$site_id = $this->_get_site_id($tmp[0]);
			$var = $tmp[1];
		}
		else
		{
			$site_id = $PREFS->ini('site_id');
		}

		/** -------------------------------------
		/**  Include helper class
		/** -------------------------------------*/

		if ( ! class_exists('Low_variables_type'))
		{
			require PATH_MOD.'low_variables/libraries/Low_variables_type'.EXT;
		}

		$TYPE = new Low_variables_type(FALSE);

		/** -------------------------------------
		/**  Get variable data from cache or DB
		/** -------------------------------------*/

		if (isset($SESS->cache['low']['variables']['data'][$site_id][$var]))
		{
			$TMPL->log_item("Low Variables: Getting variable data for {$var} from Session Cache");

			$row = $SESS->cache['low']['variables']['data'][$site_id][$var];
		}
		else
		{
			$TMPL->log_item("Low Variables: Getting variable data for {$var} from Database");

			$where = array(
				"ee.variable_name = '".$DB->escape_str($var)."'",
				"ee.site_id = '".$DB->escape_str($site_id)."'"
			);

			$rows = $this->_get_variables($where, 1);

			if (count($rows) == 1)
			{
				$row = $rows[0];

				// Prep settings
				$row['variable_settings'] = $this->_get_type_settings($row['variable_type'], $row['variable_settings']);

				// add row to cache
				$SESS->cache['low']['variables']['data'][$site_id][$var] = $row;
			}
			else
			{
				$TMPL->log_item("Low Variables: Variable '{$var}' not found, returning raw data");

				return $this->return_data;
			}
		}

		/** -------------------------------------
		/**  Get variable options and parse 'em
		/** -------------------------------------*/

		$options = isset($row['variable_settings']['options']) ? $TYPE->explode_options($row['variable_settings']['options']) : FALSE;

		if ($options)
		{
			// Check if separator exists for multi-values variable data
			if (isset($row['variable_settings']['separator']) && isset($TYPE->separators[$row['variable_settings']['separator']]))
			{
				// get separator
				$sep = $TYPE->separators[$row['variable_settings']['separator']];

				// get current values
				$current = explode($sep, $row['variable_data']);
			}
			else
			{
				// single value, put in single array
				$current = array($row['variable_data']);
			}

			// empty return data
			$this->return_data = '';

			// init count
			$count = 0;

			// loop through options
			foreach($options AS $key => $val)
			{
				// create data array
				$data = array(
					'value' => $key,
					'label' => $val,
					'active' => (in_array($key, $current)?'y':''),
					'checked' => (in_array($key, $current)?' checked="checked"':''),
					'selected' => (in_array($key, $current)?' selected="selected"':''),
					'total_results' => count($options),
					'count' => ++$count
				);

				// get template data chunk
				$chunk = $TMPL->tagdata;

				// replace stuff in chunk
				foreach ($data AS $k => $v)
				{
					$chunk = str_replace(LD.$k.RD, $v, $chunk);
				}

				// append chunk to return data
				$this->return_data .= $chunk;
			}
		}
		else
		{
			$TMPL->log_item('Low Variables: No options found');
		}

		// return parsed data
		return $this->return_data;

	}

	// --------------------------------------------------------------------

	/**
	*	Get settings for given type from serialized settings
	*
	*	@param	string	$type
	*	@param	string	$settings	Serialized array of settings
	*	@return	array
	*	@since	1.1.4
	*/
	function _get_type_settings($type, $settings)
	{
		global $REGX;

		// Prep settings
		$settings = $REGX->array_stripslashes(unserialize($settings));

		// Focus on type's settings
		return (isset($settings[$type])) ? $settings[$type] : array();
	}

	// --------------------------------------------------------------------

	/**
	*	Get settings for given type from serialized settings
	*
	*	@param	string	$type
	*	@param	string	$settings	Serialized array of settings
	*	@return	array
	*	@since	1.1.4
	*/
	function _get_variables($where = array(), $limit = 0)
	{
		global $DB;

		$sql = "SELECT
				ee.variable_id, ee.variable_name, ee.variable_data, ee.site_id,
				low.variable_label, low.variable_type, low.variable_settings
			FROM
				exp_global_variables AS ee
			LEFT JOIN
				exp_low_variables AS low
			ON
				ee.variable_id = low.variable_id
			WHERE 1
		";

		if ($where)
		{
			$sql .= 'AND ('. implode(' AND ', $where) .') ';
		}

		if ($limit)
		{
			$sql .= 'LIMIT '.$limit;
		}

		$query = $DB->query($sql);

		return $query->result;
	}

	// --------------------------------------------------------------------

	/**
	*	Get site id for given site name from cache or DB
	*
	*	@param	string	$site_name
	*	@return	int
	*	@since	1.3.3
	*/
	function _get_site_id($site_name)
	{
		global $SESS, $DB, $PREFS;

		if (isset($SESS->cache['low']['variables']['sites']))
		{
			// Return site id from cache
			$sites = $SESS->cache['low']['variables']['sites'];
		}
		else
		{
			$query = $DB->query("SELECT site_id, site_name FROM exp_sites");
			$SESS->cache['low']['variables']['sites'] = $sites = Low_variables_ext::flatten_results($query->result, 'site_id', 'site_name');
		}

		// Return site id, fallback to current site
		return array_key_exists($site_name, $sites) ? $sites[$site_name] : $PREFS->ini('site_id');
	}

}