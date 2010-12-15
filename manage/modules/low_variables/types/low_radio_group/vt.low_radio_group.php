<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_radio_group extends Low_variables_type {

	var $info = array(
		'name'		=> 'Radio Group',
		'version'	=> LOW_VAR_VERSION
	);

	var $default_settings = array(
		'options' => ''
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

		$options = $this->get_setting('options', $var_settings);

		/** -------------------------------------
		/**  Build options setting
		/** -------------------------------------*/

		$r[] = array(
			$this->setting_label($LANG->line('variable_options'), $LANG->line('variable_options_help')),
			$DSP->input_textarea($this->input_name('options'), $options, '7', 'textarea', '75%')
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
		/**  Init return value
		/** -------------------------------------*/

		$r = '';

		/** -------------------------------------
		/**  Check current value from settings
		/** -------------------------------------*/

		$options = $this->get_setting('options', $var_settings);
		$options = $this->explode_options($options);

		/** -------------------------------------
		/**  Build checkboxes
		/** -------------------------------------*/

		foreach ($options AS $key => $val)
		{
			$r .= '<label class="low-radio">'
				.	$DSP->input_radio("var[{$var_id}]", $key, ($key == $var_data))
				.	htmlspecialchars($val)
				. '</label>';
		}

		/** -------------------------------------
		/**  Return checkboxes
		/** -------------------------------------*/

		return $r;
	}

}