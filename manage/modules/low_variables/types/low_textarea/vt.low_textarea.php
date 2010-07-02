<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_textarea extends Low_variables_type {

	var $info = array(
		'name'		=> 'Textarea',
		'version'	=> '1.2.4'
	);

	var $default_settings = array(
		'rows' => '3'
	);

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
		global $DSP, $LANG;

		/** -------------------------------------
		/**  Init return value
		/** -------------------------------------*/

		$r = array();

		/** -------------------------------------
		/**  Check current value from settings
		/** -------------------------------------*/

		$rows = $this->get_setting('rows', $var_settings);

		/** -------------------------------------
		/**  Build settings for rows
		/** -------------------------------------*/

		$r[] = array(
			$this->setting_label($LANG->line('variable_rows')),
			$DSP->input_text($this->input_name('rows'), $rows, '4', '4', '', '30px')
		);

		/** -------------------------------------
		/**  Return output
		/** -------------------------------------*/

		return $r;
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
		global $DSP;

		/** -------------------------------------
		/**  Check current value from settings
		/** -------------------------------------*/

		$rows = isset($var_settings['rows']) ? $var_settings['rows'] : $this->default_settings['rows'];

		/** -------------------------------------
		/**  Return input field
		/** -------------------------------------*/

		return $DSP->input_textarea("var[{$var_id}]", $var_data, $rows, '', '99%');

	}

	// --------------------------------------------------------------------

	/**
	* Display output, possible formatting
	*
	* @param	string	$tagdata	Current tagdata
	* @param	array	$var		Variable row
	* @return	string
	*/
	function display_output($tagdata, $var)
	{
		global $TMPL;

		$var_data = $var['variable_data'];

		/** -------------------------------------
		/**  Is there a format parameter?
		/**  If so, apply the given format
		/** -------------------------------------*/

		if ($format = $TMPL->fetch_param('format'))
		{
			if ( ! class_exists('Typography'))
			{
				require PATH_CORE.'core.typography'.EXT;
			}

			$TYPE = new Typography;   
			$var_data = $TYPE->parse_type($var_data, array('text_format' => $format));
		}

		// return (formatted) data
		return (empty($tagdata) ? $var_data : str_replace(LD.$var['variable_name'].RD, $var_data, $tagdata));
	}

}