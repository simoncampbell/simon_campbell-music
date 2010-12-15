<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_text_input extends Low_variables_type {

	var $info = array(
		'name'		=> 'Text Input',
		'version'	=> LOW_VAR_VERSION
	);

	var $default_settings = array(
		'maxlength' => '',
		'size'		=> 'medium',
		'pattern'	=> ''
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

		$maxlength = $this->get_setting('maxlength', $var_settings);
		$size = $this->get_setting('size', $var_settings);
		$pattern = $this->get_setting('pattern', $var_settings);

		/** -------------------------------------
		/**  Build rows for values
		/** -------------------------------------*/

		$r[] = array(
			$this->setting_label($LANG->line('variable_maxlength')),
			$DSP->input_text($this->input_name('maxlength'), $maxlength, '4', '4', '', '30px')
		);

		$r[] = array(
			$this->setting_label($LANG->line('variable_size')),
			form_dropdown($this->input_name('size'), array(
				'large' => $LANG->line('large'),
				'medium' => $LANG->line('medium'),
				'small' => $LANG->line('small'),
				'x-small' => $LANG->line('x-small')
			), $size)
		);

		$r[] = array(
			$this->setting_label($LANG->line('variable_pattern'), $LANG->line('variable_pattern_help')),
			$DSP->input_text($this->input_name('pattern'), $pattern, '', '', '', '260px')
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

		$maxlength = $this->get_setting('maxlength', $var_settings);
		$size = $this->get_setting('size', $var_settings);

		/** -------------------------------------
		/**  Return input field
		/** -------------------------------------*/

		return $DSP->input_text("var[{$var_id}]", $var_data, '20', $maxlength, $size, '');

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
		/** -------------------------------------
		/**  Check if pattern is defined
		/** -------------------------------------*/

		if (($pattern = $this->get_setting('pattern', $var_settings)) && !preg_match($pattern, $var_data, $match))
		{
			$this->error_msg = 'invalid_value';
			$var_data = FALSE;
		}

		return $var_data;
	}

}