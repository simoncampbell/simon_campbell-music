<?php if ( ! defined('EXT')) exit('Invalid file request');

/**
* Low Variables Extension class
*
* Saves settings for the Low Variables module
*
* @package		low-variables-ee_addon
* @version		1.2.4
* @author		Lodewijk Schutte <low@loweblog.com>
* @link			http://loweblog.com/freelance/
* @copyright	Copyright (c) 2009, Low
*/

class Low_variables_ext
{
	/**
	* Extension name
	*
	* @var	string
	*/
	var $name = 'Low Variables';

	/**
	* Extension version
	*
	* @var	string
	*/
	var $version = '1.2.4';

	/**
	* Extenstion description
	*
	* @var	string
	*/
	var $description = 'Low Variables module settings';

	/**
	* Do settings exist?
	*
	* @var	string	y|n
	*/
	var $settings_exist = 'y';

	/**
	* Documentation URL
	*
	* @var	string
	*/
	var $docs_url = 'http://loweblog.com/software/low-variables/';

	/**
	* Settings array
	*
	* @var	array
	*/
	var $settings = array();

	/**
	* Default settings array
	*
	* @var	array
	*/
	var $default_settings = array(
			'license_key'      => '',
			'prefix'           => '',
			'with_prefixed'    => 'show',
			'can_manage'       => array(1),
			'ignore_prefixes'  => 'y',
			'group'            => 'y',
			'register_globals' => 'n'
		);

	// --------------------------------------------------------------------

	/**
	* PHP4 Constructor
	*
	* @see	__construct()
	*/
	function Low_variables_ext($settings = '')
    {
		$this->__construct($settings);
	}

	// --------------------------------------------------------------------

	/**
	* PHP5 Constructor
	*
	* @return	void
	*/
	function __construct($settings = '')
	{
		$this->settings = $settings;
	}

	// --------------------------------------------------------------------

	/**
	* Extension settings form
	*
	* @return	array
	*/
	function settings_form($current)
	{
		global $DB, $SESS, $IN, $PREFS, $LANG, $DSP;

		/** -------------------------------------
		/**  Get member groups; exclude guests, pending and banned
		/** -------------------------------------*/

		$query = $DB->query("SELECT group_id, group_title FROM exp_member_groups
							WHERE group_id NOT IN (2,3,4)
							AND site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
							ORDER BY group_title ASC");

		/** -------------------------------------
		/**  Initiate member groups array
		/** -------------------------------------*/

		$groups = array();

		/** -------------------------------------
		/**  Populate member groups array
		/** -------------------------------------*/

		foreach ($query->result AS $row)
		{
			$groups[$row['group_id']] = $row['group_title'];
		}

		/** -------------------------------------
		/**  Define settings array for display
		/** -------------------------------------*/

		$settings = array_merge($this->default_settings, $current);
		$settings['member_groups'] = $groups;
		$settings['version'] = $this->version;
		$settings['name'] = ucfirst(get_class($this));

		/** -------------------------------------
		/**  Build output
		/** -------------------------------------*/

		$DSP->crumbline = TRUE;
		$DSP->title = $LANG->line('extension_settings');
		$DSP->crumb = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities'))
					. $DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')))
					. $DSP->crumb_item($this->name);

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		/** -------------------------------------
		/**  Load view
		/** -------------------------------------*/

		if (empty($DSP->view_path)) $DSP->view_path = PATH_MOD.'low_variables/views/';
		$DSP->body .= $DSP->view('ext_settings', $settings, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	* Save extension settings
	*
	* @return	null
	*/
	function save_settings()
	{
		global $IN, $DB;

		// Initiate settings array
		$settings = array();

		// Loop through default settings, check for POST values
		foreach ($this->default_settings AS $key => $val)
		{
			$settings[$key] = $IN->GBL($key, 'POST') ? $IN->GBL($key, 'POST') : $val;
		}

		// Save serialized settings
		$DB->query($DB->update_string('exp_extensions', array('settings' => serialize($settings)), "class = '".ucfirst(get_class($this))."'"));
	}

	// --------------------------------------------------------------------

	/**
	* Optionally adds variables to Global Vars for early parsing
	*
	* @param	object	&$SESS	Current session object
	* @return	null
	*/
	function sessions_end(&$SESS)
	{
		global $IN, $DB, $PREFS;

		/** -------------------------------------
		/**  Add extension settings to session cache
		/** -------------------------------------*/

		$SESS->cache['low']['variables']['settings'] = $this->settings;

		/** -------------------------------------
		/**  Bail if it's not a page request
		/**  or if we needn't register the vars
		/** -------------------------------------*/

		if (REQ != 'PAGE' || $this->settings['register_globals'] == 'n') return;

		/** -------------------------------------
		/**  Initiate data array
		/** -------------------------------------*/

		$early = array();

		/** -------------------------------------
		/**  Get global variables to parse early
		/** -------------------------------------*/

		$query = $DB->query("SELECT ee.variable_name, ee.variable_data
							FROM exp_global_variables AS ee
							LEFT JOIN exp_low_variables AS low ON ee.variable_id = low.variable_id
							WHERE low.early_parsing = 'y'
							AND ee.site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'");

		/** -------------------------------------
		/**  Put results into data array
		/** -------------------------------------*/

		foreach ($query->result AS $row)
		{
			$early[$row['variable_name']] = $row['variable_data'];
		}

		/** -------------------------------------
		/**  Add variables to early parsed global vars
		/**  Option: make it a setting to switch order around?
		/** -------------------------------------*/

		//$IN->global_vars = array_merge($IN->global_vars, $early);
		$IN->global_vars = array_merge($early, $IN->global_vars);
	}

	// --------------------------------------------------------------------

	/**
	* Activate Extension
	*
	* @param	bool	$install_mod
	* @return	null
	*/	
	function activate_extension($install_mod = TRUE)
	{
		global $DB;

		$DB->query(
			$DB->insert_string(
				'exp_extensions',
				array(
					'class'    => ucfirst(get_class($this)),
					'method'   => 'sessions_end',
					'hook'     => 'sessions_end',
					'settings' => serialize($this->default_settings),
					'priority' => 2,
					'version'  => $this->version,
					'enabled'  => 'y'
				)
			)
		); // end db->query

		if ($install_mod === TRUE)
		{
			if ( ! class_exists('Low_variables_CP') )
			{
				require_once(PATH_MOD.'low_variables/mcp.low_variables'.EXT);
			}

			$MOD = new Low_variables_CP;
			$MOD->low_variables_module_install(FALSE);
		}

	}

	// --------------------------------------------------------------------

	/**
	* Disable Extension
	*
	* @param	bool	$uninstall_mod
	* @return	null
	*/
	function disable_extension($uninstall_mod = TRUE)
	{
		global $DB;

		$DB->query("DELETE FROM exp_extensions WHERE class = '".ucfirst(get_class($this))."'");

		if ($uninstall_mod === TRUE)
		{
			if ( ! class_exists('Low_variables_CP') )
			{
				require_once(PATH_MOD.'low_variables/mcp.low_variables'.EXT);
			}

			$MOD = new Low_variables_CP;
			$MOD->low_variables_module_deinstall(FALSE);
		}
	}

	// --------------------------------------------------------------------

	/**
	* Update Extension
	*
	* @param	string	$current
	* @return	null
	*/
	function update_extension($current = '')
	{
		global $DB;

		if ($current == '' OR (version_compare($current, $this->version) === 0) )
		{
			return FALSE;
		}

		$DB->query("UPDATE exp_extensions SET version = '".$DB->escape_str($this->version)."' WHERE class = '".ucfirst(get_class($this))."'");
	}

	// --------------------------------------------------------------------

}