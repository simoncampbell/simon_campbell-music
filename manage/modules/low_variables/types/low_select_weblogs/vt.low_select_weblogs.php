<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_select_weblogs extends Low_variables_type {

	var $info = array(
		'name'		=> 'Select Weblogs',
		'version'	=> '1.2.4'
	);

	var $default_settings = array(
		'multiple'			=> 'y',
		'weblog_ids'		=> array(),
		'separator'			=> 'pipe'
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
		global $DSP, $LANG, $DB, $PREFS;

		/** -------------------------------------
		/**  Init return value
		/** -------------------------------------*/

		$r = array();

		/** -------------------------------------
		/**  Build setting: Channel ids
		/**  First, get all weblogs for this site
		/** -------------------------------------*/

		$query = $DB->query("SELECT weblog_id, blog_title FROM exp_weblogs
							WHERE site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
							ORDER BY blog_title ASC");

		$all_weblogs = $this->flatten_results($query->result, 'weblog_id', 'blog_title');

		/** -------------------------------------
		/**  Then, get current weblog ids from settings
		/** -------------------------------------*/

		$current = $this->get_setting('weblog_ids', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('weblog_ids')),
			form_multiselect($this->input_name('weblog_ids', TRUE), $all_weblogs, $current)
		);

		/** -------------------------------------
		/**  Build setting: multiple?
		/** -------------------------------------*/

		$multiple = $this->get_setting('multiple', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('allow_multiple_weblogs')),
			'<label class="low-checkbox">'.str_replace("class='checkbox'", "class='low-allow-multiple'",$DSP->input_checkbox($this->input_name('multiple'), 'y', $multiple)).
			$LANG->line('allow_multiple_weblogs_label').'</label>'
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
		/**  Build setting: multi interface
		/** -------------------------------------*/

		$multi_interface = $this->get_setting('multi_interface', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('multi_interface')),
			$this->interface_select($multi_interface)
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
		global $DSP, $DB, $PREFS, $LANG;

		/** -------------------------------------
		/**  Prep options
		/** -------------------------------------*/

		$weblog_ids = $this->get_setting('weblog_ids', $var_settings);
		$multiple = $this->get_setting('multiple', $var_settings);
		$separator = $this->get_setting('separator', $var_settings);
		$multi_interface = $this->get_setting('multi_interface', $var_settings);

		/** -------------------------------------
		/**  Prep current data
		/** -------------------------------------*/

		$current = explode($this->separators[$separator], $var_data);

		/** -------------------------------------
		/**  No weblog ids? Bail.
		/** -------------------------------------*/

		if (empty($weblog_ids))
		{
			return $DSP->qspan('alert', $LANG->line('no_weblogs_selected'));
		}

		/** -------------------------------------
		/**  Get categories
		/** -------------------------------------*/

		$sql_ids = implode(',', $DB->escape_str($weblog_ids));
		$sql_site = $DB->escape_str($PREFS->ini('site_id'));

		$sql = "SELECT
				blog_name, blog_title
			FROM
				exp_weblogs
			WHERE
				weblog_id IN ({$sql_ids})
			AND
				site_id = '{$sql_site}'
			ORDER BY
				blog_title ASC
		";
		$query = $DB->query($sql);

		/** -------------------------------------
		/**  Compose nested category array
		/** -------------------------------------*/

		$weblogs = $this->flatten_results($query->result, 'blog_name', 'blog_title');

		/** -------------------------------------
		/**  Create select element
		/** -------------------------------------*/

		// Set correct name
		$name = "var[{$var_id}]" . (($multiple == 'y') ? '[]' : '');

		// Create select element
		if ($multiple && $multi_interface == 'drag-list')
		{
			$r = $this->drag_lists($var_id, $weblogs, $current);
		}
		else
		{
			$r = $this->select_element($var_id, $weblogs, $current, ($multiple == 'y'));
		}

		/** -------------------------------------
		/**  Return select element
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
		return is_array($var_data) ? implode($this->separators[$this->get_setting('separator', $var_settings)], $var_data) : $var_data;
	}
}