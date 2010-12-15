<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_select_entries extends Low_variables_type {

	var $info = array(
		'name'		=> 'Select Entries',
		'version'	=> LOW_VAR_VERSION
	);

	var $default_settings = array(
		'weblogs'	=> array(),
		'multiple'	=> 'y',
		'separator'	=> 'pipe',
		'multi_interface' => 'select'
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
		/**  Build setting: weblogs
		/**  First, get all blogs for this site
		/** -------------------------------------*/

		$query = $DB->query("SELECT weblog_id, blog_title FROM exp_weblogs
							WHERE site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
							ORDER BY blog_title ASC");

		$all_blogs = $this->flatten_results($query->result, 'weblog_id', 'blog_title');

		/** -------------------------------------
		/**  Then, get current blogs from settings
		/** -------------------------------------*/

		$current = $this->get_setting('weblogs', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('weblogs')),
			form_multiselect($this->input_name('weblogs', TRUE), $all_blogs, $current)
		);

		/** -------------------------------------
		/**  Build setting: multiple?
		/** -------------------------------------*/

		$multiple = $this->get_setting('multiple', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('allow_multiple_entries')),
			'<label class="low-checkbox">'.str_replace("class='checkbox'", "class='low-allow-multiple'",$DSP->input_checkbox($this->input_name('multiple'), 'y', $multiple)).
			$LANG->line('allow_multiple_files_label').'</label>'
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
			$DSP->qspan('defaultBold', $LANG->line('multi_interface')),
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

		$weblogs = $this->get_setting('weblogs', $var_settings);
		$multiple = $this->get_setting('multiple', $var_settings);
		$separator = $this->get_setting('separator', $var_settings);
		$multi_interface = $this->get_setting('multi_interface', $var_settings);

		/** -------------------------------------
		/**  Prep current data
		/** -------------------------------------*/

		$current = explode($this->separators[$separator], $var_data);

		/** -------------------------------------
		/**  No weblogs? Bail.
		/** -------------------------------------*/

		if (empty($weblogs))
		{
			return $DSP->qspan('alert', $LANG->line('no_weblog_selected'));
		}

		/** -------------------------------------
		/**  Get entries
		/** -------------------------------------*/

		$sql_blogs = implode(',', $DB->escape_str($weblogs));

		$sql = "SELECT
				e.entry_id, e.title, w.blog_title
			FROM
				exp_weblog_titles e, exp_weblogs w
			WHERE
				e.weblog_id = w.weblog_id
			AND
				w.weblog_id IN ({$sql_blogs})
			ORDER BY
				w.blog_title ASC,
				e.title ASC
		";
		$query = $DB->query($sql);

		/** -------------------------------------
		/**  Compose nested category array
		/** -------------------------------------*/

		$entries = array();

		if ($multiple == 'y' && $multi_interface == 'drag-list')
		{
			$entries = $this->flatten_results($query->result, 'entry_id', 'title');
		}
		else
		{
			foreach($query->result AS $row)
			{
				$entries[$row['blog_title']][$row['entry_id']] = $row['title'];
			}
		}

		/** -------------------------------------
		/**  Create interface
		/** -------------------------------------*/

		if ($multiple == 'y' && $multi_interface == 'drag-list')
		{
			// sort entries again
			asort($entries);

			$r = $this->drag_lists($var_id, $entries, $current);
		}
		else
		{
			$r = $this->select_element($var_id, $entries, $current, ($multiple == 'y'));
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