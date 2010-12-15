<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_checkbox_group extends Low_variables_type {

	var $info = array(
		'name'		=> 'Checkbox Group',
		'version'	=> LOW_VAR_VERSION
	);

	var $default_settings = array(
		'options' => '',
		'separator' => 'newline'
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
		/**  Build setting: options
		/** -------------------------------------*/

		$options = $this->get_setting('options', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('variable_options'), $LANG->line('variable_options_help')),
			$DSP->input_textarea($this->input_name('options'), $options, '7', 'textarea', '75%')
		);

		/** -------------------------------------
		/**  Build setting: separator
		/** -------------------------------------*/

		$separator = $this->get_setting('separator', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('separator_character')),
			$this->separator_select($separator)
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

		$options = $this->get_setting('options', $var_settings);
		$options = $this->explode_options($options);

		/** -------------------------------------
		/**  Prep current data
		/** -------------------------------------*/

		$current = explode($this->separators[$this->get_setting('separator', $var_settings)], $var_data);

		/** -------------------------------------
		/**  Init return value
		/** -------------------------------------*/

		$r = '';

		/** -------------------------------------
		/**  Build checkboxes
		/** -------------------------------------*/

		foreach ($options AS $key => $val)
		{
			$checked = in_array($key, $current) ? 1 : 0;
			$r .= '<label class="low-checkbox">'
				.	$DSP->input_checkbox("var[{$var_id}][]", $key, $checked)
				.	htmlspecialchars($val)
				. '</label>';
		}

		/** -------------------------------------
		/**  Return checkboxes
		/** -------------------------------------*/

		return $r;
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
		return is_array($var_data) ? implode($this->separators[$this->get_setting('separator', $var_settings)], $var_data) : '';
	}

}