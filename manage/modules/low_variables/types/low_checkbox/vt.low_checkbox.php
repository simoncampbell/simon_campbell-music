<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_checkbox extends Low_variables_type {

	var $info = array(
		'name'		=> 'Checkbox',
		'version'	=> LOW_VAR_VERSION
	);

	var $default_settings = array(
		'label' => ''
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

		$label = $this->get_setting('label', $var_settings);

		/** -------------------------------------
		/**  Build label setting
		/** -------------------------------------*/

		$r[] = array(
			$this->setting_label($LANG->line('variable_checkbox_label')),
			$DSP->input_text($this->input_name('label'), $label, '', '', '', '260px')
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

		$label = $this->get_setting('label', $var_settings);

		/** -------------------------------------
		/**  Build checkbox
		/** -------------------------------------*/

		$r .= '<label class="low-checkbox">'
			.	$DSP->input_checkbox("var[{$var_id}]", 'y', ($var_data == 'y' ? 1 : 0))
			.	htmlspecialchars($label)
			. '</label>';

		/** -------------------------------------
		/**  Return checkbox
		/** -------------------------------------*/

		return $r;
	}

}