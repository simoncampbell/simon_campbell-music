<?php if ( ! defined('EXT')) exit('Invalid file request');

/**
* Low Fieldtype Bridge Class
*
* Acts as bridge between variable types and fieldtypes
*
* @package		low-variables-ee_addon
* @version		1.3.4
* @author		Lodewijk Schutte <low@loweblog.com>
* @link			http://loweblog.com/software/low-variables/
* @copyright	Copyright (c) 2010, Low
*/

class Low_fieldtype_bridge {

	/**
	* Default settings fallback
	*
	* @var array
	*/
	var $default_settings = array();

	// --------------------------------------------------------------------

	/**
	* PHP4 Constructor
	*
	* @see	__construct()
	*/
	function Low_fieldtype_bridge($info = array())
	{
		$this->__construct($info);
	}

	// --------------------------------------------------------------------

	/**
	* PHP5 Constructor
	*
	* @param	array	$info
	* @return	void
	*/
	function __construct($info = array())
	{
		if ($info)
		{
			global $DB, $FF, $LANG;

			$this->info = $info;
			$this->ftype = $FF->_init_ftype($info['class']);

			// Set default settings
			if (isset($this->ftype->default_field_settings))
			{
				$this->default_settings = $this->ftype->default_field_settings;
			}

			// Get language file if necessary
			if ( ! $this->ftype->info['no_lang'])
			{
				$LANG->fetch_language_file(strtolower($info['class']));
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	* Display settings sub-form for this variable type
	*
	* @param	mixed	$var_id			The id of the variable: 'new' or numeric
	* @param	array	$var_settings	The settings of the variable
	* @return	array	
	*/
	function display_settings($var_id, $var_settings)
	{
		if (isset($this->ftype->default_field_settings))
		{
			$var_settings = array_merge($this->default_settings, $var_settings);
		}

		return method_exists($this->ftype, 'display_var_settings') ? $this->ftype->display_var_settings($var_settings) : array();
	}

	// --------------------------------------------------------------------

	/**
	* Display settings sub-form for this variable type
	*
	* @param	mixed	$var_id			The id of the variable: 'new' or numeric
	* @param	array	$var_settings	The settings of the variable
	* @return	array	
	*/
	function save_settings($var_id, $var_settings)
	{
		if (method_exists($this->ftype, 'save_var_settings'))
		{
			$var_settings = $this->ftype->save_var_settings($var_settings);
		}

		return $var_settings;
	}

	// --------------------------------------------------------------------

	/**
	* Display input field for regular user
	*
	* @param	int		$var_id			The id of the variable
	* @param	string	$var_data		The value of the variable
	* @param	array	$var_settings	The settings of the variable
	* @return	string
	*/
	function display_input($var_id, $var_data, $var_settings)
	{
		return $this->ftype->display_var_field("var[{$var_id}]", $var_data, $var_settings);
	}

	// --------------------------------------------------------------------

	/**
	* Prep variable data for saving
	*
	* @param	int		$var_id			The id of the variable
	* @param	mixed	$var_data		The value of the variable, array or string
	* @param	array	$var_settings	The settings of the variable
	* @return	string
	*/
	function save_input($var_id, $var_data, $var_settings)
	{
		if (method_exists($this->ftype, 'save_var_field'))
		{
			$var_data = $this->ftype->save_var_field($var_data, $var_settings);
		}

		return $var_data;
	}

	// --------------------------------------------------------------------

	/**
	* Display template tag output
	*
	* @param	string	$tagdata	Tagdata of template tag
	* @param	array	$data		Data of the variable, containing id, data, settings...
	* @return	mixed				String if successful, FALSE if not
	*/
	function display_output($tagdata, $data)
	{
		if (method_exists($this->ftype, 'display_var_tag'))
		{
			global $TMPL;
			return $this->ftype->display_var_tag($TMPL->tagparams, $tagdata, $data['variable_data'], $data['variable_settings']);
		}
		else
		{
			return FALSE;
		}
	}

	// --------------------------------------------------------------------

	function load_assets()
	{
		return FALSE;
	}
}