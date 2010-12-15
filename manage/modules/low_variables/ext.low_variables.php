<?php if ( ! defined('EXT')) exit('Invalid file request');

// Include config.php
include(PATH_MOD.'low_variables/config.php');

/**
* Low Variables Extension class
*
* Saves settings for the Low Variables module
*
* @package		low-variables-ee_addon
* @version		1.3.4
* @author		Lodewijk Schutte <low@loweblog.com>
* @link			http://loweblog.com/software/low-variables/
* @copyright	Copyright (c) 2009, Low
*/

class Low_variables_ext
{
	/**
	* Extension name
	*
	* @var	string
	*/
	var $name = LOW_VAR_NAME;

	/**
	* Extension version
	*
	* @var	string
	*/
	var $version = LOW_VAR_VERSION;

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
	var $docs_url = LOW_VAR_DOCS;

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
		'license_key'          => '',
		'can_manage'           => array(1),
		'register_globals'     => 'n',
		'register_member_data' => 'n',
		'enabled_types'        => array(LOW_VAR_DEFAULT_TYPE)
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
		$settings['variable_types'] = $this->get_types();

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

		// Make sure it's always an array
		if ( ! is_array($settings['enabled_types']) )
		{
			$settings['enabled_types'] = array();
		}

		// Always make sure the default type is enabled, too
		if ( ! in_array(LOW_VAR_DEFAULT_TYPE, $settings['enabled_types']) )
		{
			$settings['enabled_types'][] = LOW_VAR_DEFAULT_TYPE;
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
		/** -------------------------------------*/

		if (REQ != 'PAGE') return;

		/** -------------------------------------
		/**  Initiate data array
		/** -------------------------------------*/

		$early = array();

		/** -------------------------------------
		/**  Register member data?
		/** -------------------------------------*/

		if ($this->settings['register_member_data'] == 'y')
		{
			// Variables to set
			$keys = array('member_id', 'group_id', 'group_description', 'username', 'screen_name',
			              'email', 'ip_address', 'location', 'total_entries', 'total_comments',
			              'private_messages', 'total_forum_posts', 'total_forum_topics');

			// Add logged_in_... vars to early parsing arrat
			foreach ($keys AS $key)
			{
				$early['logged_in_'.$key] = @$SESS->userdata[$key];
			}
		}

		if ($this->settings['register_globals'] == 'y')
		{
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
		}

		/** -------------------------------------
		/**  Add variables to early parsed global vars
		/**  Option: make it a setting to switch order around?
		/** -------------------------------------*/

		if ($early)
		{
			//$IN->global_vars = array_merge($IN->global_vars, $early);
			$IN->global_vars = array_merge($early, $IN->global_vars);
		}
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

		// Enable all available types with this update
		if (version_compare($current, '1.2.5', '<'))
		{
			$this->settings['enabled_types'] = array_keys($this->get_types());
			$DB->query("UPDATE exp_extensions SET settings = '".$DB->escape_str(serialize($this->settings))."' WHERE class = '".ucfirst(get_class($this))."'");
		}

		// Update settings
		if (version_compare($current, '1.3.4', '<'))
		{
			$this->settings['register_member_data'] = 'n';
			$DB->query("UPDATE exp_extensions SET settings = '".$DB->escape_str(serialize($this->settings))."' WHERE class = '".ucfirst(get_class($this))."'");
		}

		// Sync version number
		$DB->query("UPDATE exp_extensions SET version = '".$DB->escape_str($this->version)."' WHERE class = '".ucfirst(get_class($this))."'");
	}

	// --------------------------------------------------------------------

	/**
	* Get array of Variable Types
	*
	* This method can be called directly thoughout the package with Low_variables_ext::get_types()
	* because the extension file will always be loaded
	*
	* @param	mixed	$which		FALSE for complete list or array containing which types to get
	* @return	array
	*/
	function get_types($which = FALSE)
	{
		/** -------------------------------------
		/**  Initiate return value
		/** -------------------------------------*/

		$types = array();

		/** -------------------------------------
		/**  Get libraries
		/** -------------------------------------*/

		if ( ! class_exists('Low_variables_type'))
		{
			require_once PATH_MOD.'low_variables/libraries/Low_variables_type'.EXT;
		}

		if ( ! class_exists('Low_fieldtype_bridge'))
		{
			require_once PATH_MOD.'low_variables/libraries/Low_fieldtype_bridge'.EXT;
		}

		/** -------------------------------------
		/**  Set variable types path
		/** -------------------------------------*/

		$types_path = PATH_MOD.'low_variables/types/';

		/** -------------------------------------
		/**  If path is not valid, bail
		/** -------------------------------------*/

		if ( ! is_dir($types_path) ) return;

		/** -------------------------------------
		/**  Read dir, create instances
		/** -------------------------------------*/

		$dir = opendir($types_path);
		while (($type = readdir($dir)) !== FALSE)
		{
			// skip these
			if ($type == '.' || $type == '..' || !is_dir($types_path.$type)) continue;

			// if given, only get the given ones
			if (is_array($which) && ! in_array($type, $which)) continue;

			// determine file name
			$file = 'vt.'.$type.EXT;
			$path = $types_path.$type.'/';

			if ( ! class_exists($type) && file_exists($path.$file) )
			{
				include($path.$file);
			}

			// Got class? Get its details without instantiating it
			if (class_exists($type))
			{
				$vars = get_class_vars($type);

				$types[$type] = array(
					'path'			=> $path,
					'file'			=> $file,
					'name'			=> (isset($vars['info']['name']) ? $vars['info']['name'] : $type),
					'class'			=> ucfirst($type),
					'version'		=> (isset($vars['info']['version']) ? $vars['info']['version'] : ''),
					'is_default'	=> ($type == LOW_VAR_DEFAULT_TYPE),
					'is_fieldtype'	=> FALSE
				);
			}
		}

		// clean up
		closedir($dir);
		unset($dir);

		/** -------------------------------------
		/**  Get fieldtypes
		/** -------------------------------------*/

		global $FF;

		if ($FF)
		{
			foreach ($FF->_get_ftypes() AS $ft_class => $ftype)
			{
				// if given, only get the given ones
				if (is_array($which) && ! in_array($ft_class, $which)) continue;

				// Check if fieldtype is compatible
				if (method_exists($ftype, 'display_var_field'))
				{
					$types[$ft_class] = array(
						'path'			=> defined('FT_PATH') ? FT_PATH.$ft_class.'/' : FALSE,
						'file'			=> 'ft.'.$ft_class.EXT,
						'name'			=> $ftype->info['name'],
						'class'			=> $ft_class,
						'version'		=> $ftype->info['version'],
						'is_default'	=> ($ft_class == LOW_VAR_DEFAULT_TYPE),
						'is_fieldtype'	=> TRUE
					);
				}
			}
		}

		// Sort types by alpha
		ksort($types);

		return $types;
	}

	// --------------------------------------------------------------------

	/**
	* Utility function - flatten results
	*
	* @param	array	Result set
	* @param	string	Key to use as value
	* @param	string	Optional key to use as key
	* @return	array
	*/
	function flatten_results($array, $val, $key = FALSE)
	{
		$flat = array();

		foreach ($array AS $row)
		{
			if ($key !== FALSE)
			{
				$flat[$row[$key]] = $row[$val];
			}
			else
			{
				$flat[] = $row[$val];
			}
		}

		return $flat;
	}

	// --------------------------------------------------------------------

	/**
	* Utility function - associate results
	*
	* @param	array	Result set
	* @param	string	Key to use as key
	* @return	array
	*/
	function associate_results($array, $key)
	{
		$assoc = array();

		foreach ($array AS $row)
		{
			$assoc[$row[$key]] = $row;
		}

		return $assoc;
	}

	// --------------------------------------------------------------------

}