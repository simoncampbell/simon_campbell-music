<?php if ( ! defined('EXT')) exit('Invalid file request');

/**
* Low Variables Module Class - CP
*
* The Low Variables Control Panel master class that handles all of the CP Requests and Displaying
*
* @package		low-variables-ee_addon
* @version		1.2.4
* @author		Lodewijk Schutte <low@loweblog.com>
* @link			http://loweblog.com/freelance/
* @copyright	Copyright (c) 2009, Low
*/ 

class Low_variables_CP {

	/**
	* Module name
	*
	* @var	string
	*/
	var $module_name = 'Low_variables';

	/**
	* Module version
	*
	* @var	string
	*/
	var $version = '1.2.4';

	/**
	* Default variable type
	*
	* @var	string
	*/
	var $default_type = 'low_textarea';

	/**
	* URL to module docs
	*
	* @var	string
	*/
	var $docs_url = 'http://loweblog.com/software/low-variables/';

	/**
	* Data array for views
	*
	* @var	array
	*/
	var $data = array();

	// --------------------------------------------------------------------

	/**
	* PHP4 Constructor
	*
	* @see	__construct()
	*/
	function Low_variables_CP()
    {
		$this->__construct();
	}

	// --------------------------------------------------------------------

	/**
	* PHP5 Constructor
	*
	* @return	void
	*/
	function __construct()
    {
		global $IN, $DSP;

		/** -------------------------------------
		/**  Not from Modules or installing? Bail.
		/** -------------------------------------*/

		if ($IN->GBL('C', 'GET') != 'modules' || $IN->GBL('M', 'GET') == 'INST') return;

		/** -------------------------------------
		/**  Get settings from extension, cache or DB
		/** -------------------------------------*/

		if ( ! $this->_get_settings()) return;

		/** -------------------------------------
		/**  License check.
		/**  Removing this makes baby Jesus cry
		/** -------------------------------------*/

		if ( ! $this->_license()) return;

		/** -------------------------------------
		/**  Define base url for module
		/** -------------------------------------*/

		$this->base_url = $this->data['base_url'] = BASE.AMP.'C=modules'.AMP.'M='.$this->module_name;

		/** -------------------------------------
		/**  Define base path for module
		/** -------------------------------------*/

		$this->base_path = PATH_MOD.'low_variables/';

		/** -------------------------------------
		/**  Include Form Helper file
		/** -------------------------------------*/

		require $this->base_path .'helpers/form_helper.php';

		/** -------------------------------------
		/**  Upgrade if necessary
		/** -------------------------------------*/

		$this->_upgrade();

		/** -------------------------------------
		/**  Include variable types
		/** -------------------------------------*/

		$this->_include_types();

		/** -------------------------------------
		/**  Set $DSP->view_path if not set (play nice with others)
		/** -------------------------------------*/

		if (empty($DSP->view_path)) $DSP->view_path = $this->base_path.'views/';

		/** -------------------------------------
		/**  Get request
		/** -------------------------------------*/

		$request = $IN->GBL('P') ? $IN->GBL('P') : 'home';

		/** -------------------------------------
		/**  Handle request
		/** -------------------------------------*/

		if (method_exists($this, $request))
		{
			@session_start();
			$this->$request();
		}
	}

	// --------------------------------------------------------------------

	/**
	* Home screen
	*
	* @param	string
	* @return	void
	*/
	function home()
	{
		global $DSP, $LANG, $PREFS, $DB, $IN, $SESS;

		/** -------------------------------------
		/**  Retrieve feedback message
		/** -------------------------------------*/

		$this->data['message'] = $this->_get_flashdata('msg');

		/** -------------------------------------
		/**  Check for skipped items
		/** -------------------------------------*/

		$skipped = $this->_get_flashdata('skipped');

		/** -------------------------------------
		/**  Title and Crumbs
		/** -------------------------------------*/

		$DSP->title = $DSP->crumb = $LANG->line('low_variables_module_name');

		/** -------------------------------------
		/**  Right crumb - Manage vars link
		/** -------------------------------------*/

		if ($this->settings['is_manager'])
		{
			// set prefix filter
			$filter = ($this->settings['ignore_prefixes'] == 'n') ? TRUE : FALSE;
		}
		else
		{
			// always filter for non-managers
			$filter = TRUE;
		}

		/** -------------------------------------
		/**  Prep SQL variables
		/** -------------------------------------*/

		$sql_where_prefix	= $filter ? $this->_sql_where_prefix('ee.variable_name') : '';
		$sql_site_id		= $DB->escape_str($PREFS->ini('site_id'));

		/** -------------------------------------
		/**  Get variables
		/** -------------------------------------*/

		$sql = "SELECT
				ee.variable_id AS var_id,
				ee.variable_name AS var_name,
				ee.variable_data AS var_data,
				low.variable_label AS var_label,
				low.variable_notes AS var_notes,
				low.variable_type AS var_type,
				low.variable_settings AS var_settings,
				IFNULL(low.variable_order,0) AS var_order,
				'' AS var_input
			FROM
				exp_global_variables AS ee
			LEFT JOIN
				exp_low_variables AS low
			ON
				ee.variable_id = low.variable_id
			WHERE
				ee.site_id = '{$sql_site_id}'
				{$sql_where_prefix}
			ORDER BY
				var_order ASC,
				var_name ASC
		";
		$query = $DB->query($sql);

		if ($query->num_rows > 0)
		{
			/** -------------------------------------
			/**  Initiate $rows and $all_ids
			/**  all_ids will contain all editable variable ids,
			/**  so we can check if certain ids are missing (unchecked checkboxes, etc)
			/**  and set their value to an empty string
			/** -------------------------------------*/

			$rows = $all_ids = $alert = array();

			/** -------------------------------------
			/**  Loop through vars
			/** -------------------------------------*/

			foreach($query->result AS $i => $row)
			{
				$all_ids[] = $row['var_id'];

				/** -------------------------------------
				/**  Strip prefix from name
				/** -------------------------------------*/

				$row['var_name'] = preg_replace('/^'.$this->settings['prefix'].'/', '', $row['var_name']);

				/** -------------------------------------
				/**  Check if var is grouped
				/** -------------------------------------*/

				$group = $LANG->line('ungrouped');

				if ($this->settings['group'] == 'y')
				{
					$tmp = explode('_', $row['var_name'], 2);

					if (count($tmp) == 2)
					{
						$group = $tmp[0];
						$row['var_name'] = $tmp[1];
					}

					unset($tmp);
				}

				/** -------------------------------------
				/**  Check type and settings
				/** -------------------------------------*/

				if ( !$row['var_type'] || !isset($this->types[$row['var_type']]) )
				{
					$row['var_type'] = $this->default_type;
				}

				if ( ! ($row['var_settings'] = $this->_sql_unserialize($row['var_settings'])) )
				{
					$row['var_settings'] = array();
				}

				/** -------------------------------------
				/**  Check installed variable types
				/**  And show only those settings
				/** -------------------------------------*/

				if (is_object($this->types[$row['var_type']]))
				{
					// Refine settings
					$row['var_settings'] = isset($row['var_settings'][$row['var_type']])
											? $row['var_settings'][$row['var_type']]
											: $this->types[$row['var_type']]->default_settings;

					// Get input from var type
					$row['var_input'] = $this->types[$row['var_type']]->display_input($row['var_id'], $row['var_data'], $row['var_settings']);

					// Load CSS and JS
					$this->types[$row['var_type']]->load_assets();
				}

				/** -------------------------------------
				/**  Do we have a label?
				/** -------------------------------------*/

				$row['var_name'] = ($row['var_label']) ? $row['var_label'] : ucwords($row['var_name']);

				/** -------------------------------------
				/**  Add to alert array if skipped
				/** -------------------------------------*/

				if (is_array($skipped) && isset($skipped[$row['var_id']]))
				{
					$row['error_msg'] = $skipped[$row['var_id']];
					$alert[] = $row;
				}

				/** -------------------------------------
				/**  Add modified row to array
				/** -------------------------------------*/

				$rows[$group][] = $row;
			}

			$this->data['variables'] = $rows;
			$this->data['all_ids'] = implode('|', $all_ids);
			$this->data['skipped'] = $alert;
			$this->data['active'] = 'home';

			/** -------------------------------------
			/**  Display rows
			/** -------------------------------------*/

			$this->_load_assets();

			if ($this->settings['is_manager']) $DSP->body .= $DSP->view('manage_menu', $this->data, TRUE);
			$DSP->body .= $DSP->view('home', $this->data, TRUE);
		}
		else
		{
			// Show No Variables message
			$this->_no_vars();
		}

	}

	// --------------------------------------------------------------------

	/**
	* Manage variables, either _show_all() or _edit_var()
	*
	* @param	string	$message
	* @return	void
	*/
    function manage()
	{
		global $IN, $SESS, $FNS;

		/** -------------------------------------
		/**  Check permissions
		/** -------------------------------------*/

		if ( ! $this->settings['is_manager'] )
		{
			$FNS->redirect($this->base_url);
			exit;
		}

		/** -------------------------------------
		/**  Sync EE vars and Low Vars
		/** -------------------------------------*/

		$this->_sync();

		/** -------------------------------------
		/**  Retrieve feedback message
		/** -------------------------------------*/

		$this->data['message'] = $this->_get_flashdata('msg');

		/** -------------------------------------
		/**  Check if there's an ID to edit
		/** -------------------------------------*/

		$method = $IN->GBL('id', 'GET') ? '_edit_var' : '_show_all';

		$this->$method();
	}

	// --------------------------------------------------------------------

	/**
	* Show table of all variables
	*
	* @access	private
	* @return	void
	*/
    function _show_all()
	{
		global $DSP, $LANG, $PREFS, $DB;

		/** -------------------------------------
		/**  Title and Crumbs
		/** -------------------------------------*/

		$DSP->title = $LANG->line('manage_variables');

		$DSP->crumb = $DSP->anchor($this->base_url, $LANG->line('low_variables_module_name'))
					. $DSP->crumb_item($DSP->title);

		/** -------------------------------------
		/**  Get variables
		/** -------------------------------------*/

		$sql_where_prefix = ($this->settings['ignore_prefixes'] == 'n') ? $this->_sql_where_prefix('ee.variable_name') : '';
		$sql_site_id = $DB->escape_str($PREFS->ini('site_id'));
		$sql_default_type = $DB->escape_str($this->default_type);

		/** -------------------------------------
		/**  Compose query and execute
		/** -------------------------------------*/

		$sql = "SELECT
				ee.variable_id, ee.variable_name,
				low.variable_label,
				IF(low.variable_type != '',low.variable_type,'{$sql_default_type}') AS variable_type,
				IF(low.variable_order != '',low.variable_order,0) AS variable_order,
				IF(IFNULL(low.early_parsing,'n')='y','yes','no') AS early_parsing
			FROM
				exp_global_variables AS ee
			LEFT JOIN
				exp_low_variables AS low
			ON
				ee.variable_id = low.variable_id
			WHERE
				ee.site_id = '{$sql_site_id}'
				{$sql_where_prefix}
			ORDER BY
				variable_order ASC,
				ee.variable_name ASC
		";
		$query = $DB->query($sql);

		if ($query->num_rows)
		{
			/** -------------------------------------
			/**  Initiate rows
			/** -------------------------------------*/

			$this->data['variables'] = $query->result;
			$this->data['types'] = $this->types;
			$this->data['active'] = 'manage';

			/** -------------------------------------
			/**  Load JavaScript
			/** -------------------------------------*/

			$this->_load_assets();
			$DSP->body .= $DSP->toggle();
			$DSP->body .= $DSP->magic_checkboxes();
			$DSP->body_props = ' onload="magic_check()"';

			/** -------------------------------------
			/**  Load view
			/** -------------------------------------*/

			$DSP->body .= $DSP->view('manage_menu', $this->data, TRUE);
			$DSP->body .= $DSP->view('manage_list', $this->data, TRUE);
		}
		else
		{
			// Show No Variables message
			$this->_no_vars();
		}

	}

	// --------------------------------------------------------------------

	/**
	* Show No Variables found message, with optional Create New link
	*
	* @access	private
	* @return	null
	*/

	function _no_vars()
	{
		global $DSP, $LANG;

		/** -------------------------------------
		/**  Display alert message
		/** -------------------------------------*/

		$msg = $LANG->line('no_variables_found');

		if ($this->settings['is_manager'])
		{
			$msg .= ' &rarr; '.$DSP->anchor($this->base_url.AMP.'P=manage'.AMP.'id=new', $LANG->line('create_new'));
		}

		$DSP->body .= $DSP->qdiv('box alert', $msg);
	}

	// --------------------------------------------------------------------

	/**
	* Show edit form to edit single variable
	*
	* @access	private
	* @return	null
	*/
    function _edit_var()
	{
		global $DSP, $LANG, $PREFS, $DB, $IN, $FNS, $SESS;

		/** -------------------------------------
		/**  Title and Crumbs
		/** -------------------------------------*/

		$DSP->title = $LANG->line('edit_variable');

		$DSP->crumb = $DSP->anchor($this->base_url, $LANG->line('low_variables_module_name'))
					. $DSP->crumb_item($DSP->anchor($this->base_url.AMP.'P=manage', $LANG->line('manage_variables')))
					. $DSP->crumb_item($DSP->title);

		/** -------------------------------------
		/**  Create new, clone or edit?
		/** -------------------------------------*/

		$var_id   = $IN->GBL('id', 'GET');
		$clone_id = $IN->GBL('clone', 'GET');

		if ($var_id == 'new')
		{
			$this->data['active'] = 'create_new';

			/** -------------------------------------
			/**  Get default value for new sort order
			/** -------------------------------------*/

			$query = $DB->query("SELECT MAX(variable_order) AS max FROM exp_low_variables");
			$order = ($query->num_rows ? $query->row['max'] : 0) + 1;

			/** -------------------------------------
			/**  Init new array if var is new
			/** -------------------------------------*/

			$this->data = array_merge($this->data, array(
				'variable_id'	=> 'new',
				'variable_name'	=> '',
				'variable_label'=> '',
				'variable_notes'=> '',
				'variable_type'	=> $this->default_type,
				'variable_settings' => array(),
				'variable_order'=> $order,
				'early_parsing'	=> 'n'
			));
		}
		else
		{
			$this->data['active'] = 'manage';
		}

		/** -------------------------------------
		/**  Get var to edit or clone
		/** -------------------------------------*/

		if ( ($var_id != 'new') || is_numeric($clone_id) )
		{
			/** -------------------------------------
			/**  Default selection
			/** -------------------------------------*/

			$select = array(
				"IF(low.variable_type != '',low.variable_type,'".$DB->escape_str($this->default_type)."') AS variable_type",
				'low.variable_label',
				'low.variable_notes',
				'low.variable_settings',
				'low.early_parsing'
			);

			/** -------------------------------------
			/**  Select more when editing variable
			/** -------------------------------------*/

			if ($var_id != 'new')
			{
				$select = array_merge($select, array(
					'low.variable_order',
					'ee.variable_id',
					'ee.variable_name'
				));

				$sql_var_id = $DB->escape_str($var_id);
			}
			else
			{
				$sql_var_id = $DB->escape_str($clone_id);
			}

			/** -------------------------------------
			/**  Get existing var: compose query and execute
			/** -------------------------------------*/

			$sql_select = implode(', ', $select);
			$sql_site_id = $DB->escape_str($PREFS->ini('site_id'));

			$sql = "SELECT
					{$sql_select}
				FROM
					exp_global_variables AS ee
				LEFT JOIN
					exp_low_variables AS low
				ON
					ee.variable_id = low.variable_id
				WHERE
					ee.site_id = '{$sql_site_id}'
				AND
					ee.variable_id = '{$sql_var_id}'
				LIMIT 1
			";
			$query = $DB->query($sql);

			/** -------------------------------------
			/**  Exit if no var was found
			/** -------------------------------------*/

			if ($query->num_rows == 0)
			{
				$FNS->redirect($this->base_url.AMP.'P=manage'.AMP.'message=var_not_found');
				exit;
			}

			$this->data = array_merge($this->data, $query->row);
			$this->data['variable_settings'] = $this->data['variable_settings'] ? $this->_sql_unserialize($this->data['variable_settings']) : array();
		}

		/** -------------------------------------
		/**  Create types
		/** -------------------------------------*/

		foreach ($this->types AS $type => $obj)
		{
			$settings = isset($this->data['variable_settings'][$type]) ? $this->data['variable_settings'][$type] : $obj->default_settings;
			$display = method_exists($obj, 'display_settings') ? $obj->display_settings($this->data['variable_id'], $settings) : array();
			$this->data['types'][$type] = array(
				'name' => $obj->info['name'],
				'settings' => $display
			);
		}

		/** -------------------------------------
		/**  Load view
		/** -------------------------------------*/

		$this->_load_assets();
		$DSP->body .= $DSP->view('manage_menu', $this->data, TRUE);
		$DSP->body .= $DSP->view('manage_var', $this->data, TRUE);
	}

	// --------------------------------------------------------------------

	/**
	* Show sort order change form
	*
	* @return	null
	*/
    function sort_order()
	{
		global $DSP, $LANG, $IN, $SESS, $DB, $PREFS;

		/** -------------------------------------
		/**  Check permissions
		/** -------------------------------------*/

		if (!in_array($SESS->userdata['group_id'], $this->settings['can_manage']))
		{
			$FNS->redirect($this->base_url);
			exit;
		}

		/** -------------------------------------
		/**  Title and Crumbs
		/** -------------------------------------*/

		$DSP->title = $LANG->line('change_sort_order');

		$DSP->crumb = $DSP->anchor($this->base_url, $LANG->line('low_variables_module_name'))
					. $DSP->crumb_item($DSP->anchor($this->base_url.AMP.'P=manage', $LANG->line('manage_variables')))
					. $DSP->crumb_item($DSP->title);

		/** -------------------------------------
		/**  Get sql variables
		/** -------------------------------------*/

		$sql_where_prefix = ($this->settings['ignore_prefixes'] == 'n') ? $this->_sql_where_prefix('ee.variable_name') : '';
		$sql_site_id = $DB->escape_str($PREFS->ini('site_id'));

		/** -------------------------------------
		/**  Compose query and execute
		/** -------------------------------------*/

		$sql = "SELECT
				ee.variable_id, ee.variable_name,
				low.variable_type, low.variable_label,
				IFNULL(low.variable_order,0) AS variable_order
			FROM
				exp_global_variables AS ee
			LEFT JOIN
				exp_low_variables AS low
			ON
				ee.variable_id = low.variable_id
			WHERE
				ee.site_id = '{$sql_site_id}'
				{$sql_where_prefix}
			ORDER BY
				variable_order ASC,
				ee.variable_name ASC
		";
		$query = $DB->query($sql);

		/** -------------------------------------
		/**  Add results to data array
		/** -------------------------------------*/

		$this->data['variables'] = $query->result;
		$this->data['active'] = 'manage';

		$this->_load_assets();

		// Extra IE CSS and JS
		$DSP->extra_header .= <<<EOH
			<!--[if lte IE 7]>
				<style type="text/css">
					#low-variables-list {zoom:1}
					#low-variables-list li {margin:-4px 0 0 0}
				</style>
			<![endif]-->
EOH;

		$DSP->body .= $DSP->view('manage_menu', $this->data, TRUE);
		$DSP->body .= $DSP->view('manage_sort_order', $this->data, TRUE);

	}

	// --------------------------------------------------------------------

	/**
	* Saves variable data
	*
	* @return	null
	*/
    function save()
	{
		global $IN, $DB, $FNS;

		/** -------------------------------------
		/**  Return url
		/** -------------------------------------*/

		$return_url = $this->base_url;

		/** -------------------------------------
		/**  Get POST variables
		/** -------------------------------------*/

		if ( ! ($vars = $IN->GBL('var', 'POST')) )
		{
			$vars = array();
		}

		if ($all_ids = $IN->GBL('all_ids', 'POST'))
		{
			$all_ids = explode('|', $all_ids);
		}

		/** -------------------------------------
		/**  Loop through vars and update
		/** -------------------------------------*/

		if ($all_ids)
		{
			/** -------------------------------------
			/**  Get existing ids and their type
			/** -------------------------------------*/

			// init types array
			$types = array();

			// get types and settings from DB
			$query = $DB->query("SELECT `variable_id`, `variable_type`, `variable_settings` FROM `exp_low_variables`");

			/** -------------------------------------
			/**  Loop thru results
			/** -------------------------------------*/

			foreach ($query->result AS $row)
			{
				// Set type to default id not found
				if ( ! $row['variable_type'] )
				{
					$row['variable_type'] = $this->default_type;
				}

				// populate the types + settings array
				$types[$row['variable_id']] = array(
					'type' => $row['variable_type'],
					'settings' => $this->_get_type_settings($row['variable_type'], $row['variable_settings'])
				);
			}

			/** -------------------------------------
			/**  Get ids that weren't posted, set to empty
			/** -------------------------------------*/

			foreach (array_diff($all_ids, array_keys($vars)) AS $missing_id)
			{
				$vars[$missing_id] = '';
			}

			$skipped = array();

			foreach ($vars AS $var_id => $var_data)
			{
				// Check if type is known
				if ( ! isset($types[$var_id]) )
				{
					$types[$var_id]= array(
						'type' => $this->default_type,
						'settings' => $this->_get_type_settings($this->default_type)
					);
				}

				/** -------------------------------------
				/**  Does type require action?
				/** -------------------------------------*/

				$var_type     = $types[$var_id]['type'];
				$var_settings = $types[$var_id]['settings'];

				if (method_exists($this->types[$var_type], 'save_input'))
				{
					// Set error message to empty string
					$this->types[$var_type]->error_msg = '';

					// if FALSE is returned, skip this var
					if (($var_data = $this->types[$var_type]->save_input($var_id, $var_data, $var_settings)) === FALSE)
					{
						$skipped[$var_id] = $this->types[$var_type]->error_msg;
						continue;
					}
				}

				/** -------------------------------------
				/**  Escape variables
				/** -------------------------------------*/

				$sql_var_id = $DB->escape_str($var_id);
				$sql_var_data = $DB->escape_str($var_data);

				/** -------------------------------------
				/**  Update record
				/** -------------------------------------*/

				$DB->query("UPDATE `exp_global_variables` SET `variable_data` = '{$sql_var_data}' WHERE `variable_id` = '{$sql_var_id}'");
			}

			/** -------------------------------------
			/**  Add feedback to return  url
			/** -------------------------------------*/

			$this->_set_flashdata('msg', 'low_variables_saved');

			if ( ! empty($skipped))
			{
				$this->_set_flashdata('skipped', $skipped);
			}
		}

		/** -------------------------------------
		/**  Go home
		/** -------------------------------------*/

		$FNS->redirect($return_url);
		exit;
	}

	// --------------------------------------------------------------------

	/**
	* Saves variable list
	*
	* @return	null
	*/
    function save_list()
	{
		global $IN, $FNS, $DSP;

		/** -------------------------------------
		/**  Return url
		/** -------------------------------------*/

		$return_url = $this->base_url.AMP.'P=manage';

		/** -------------------------------------
		/**  Get vars from POST
		/** -------------------------------------*/

		$vars = $IN->GBL('toggle', 'POST');

		/** -------------------------------------
		/**  Get action to perform with list
		/** -------------------------------------*/

		$action = $IN->GBL('action', 'POST');

		if ($vars && $action == 'delete')
		{
			// Show delete confirmation
			$this->_delete_confirmation($vars);
		}
		elseif ($vars && in_array($action, array_keys($this->types)))
		{
			// Change variable type of given items
			$this->_change_type($vars, $action);
		}
		elseif ($vars && $action == 'enable_early_parsing')
		{
			// Turn on early parsing for these ids
			$this->_set_early_parsing($vars, TRUE);
		}
		elseif ($vars && $action == 'disable_early_parsing')
		{
			// Turn off early parsing for these ids
			$this->_set_early_parsing($vars, FALSE);
		}
		else
		{
			$FNS->redirect($return_url);
			exit;
		}

	}

	// --------------------------------------------------------------------

	/**
	* Asks for deletion confirmation
	*
	* @access	private
	* @param	array	$vars
	* @return	null
	*/
	function _delete_confirmation($vars = array())
	{
		global $DSP, $LANG, $DB;

		/** -------------------------------------
		/**  Title and Crumbs
		/** -------------------------------------*/

		$DSP->title = $LANG->line('low_variables_delete_confirmation');

		$DSP->crumb = $DSP->anchor($this->base_url, $LANG->line('low_variables_module_name'))
					. $DSP->crumb_item($DSP->anchor($this->base_url.AMP.'P=manage', $LANG->line('manage_variables')))
					. $DSP->crumb_item($DSP->title);

		/** -------------------------------------
		/**  Get var names
		/** -------------------------------------*/

		$sql_vars = $this->_sql_in_array($vars);
		$var_names = array();

		$query = $DB->query("SELECT `variable_name` FROM `exp_global_variables` WHERE `variable_id` IN ({$sql_vars}) ORDER BY `variable_name` ASC");

		foreach ($query->result AS $row)
		{
			$var_names[] = LD.$row['variable_name'].RD;
		}

		/** -------------------------------------
		/**  Show confirm message
		/** -------------------------------------*/

		$DSP->body = $DSP->delete_confirmation(array(
			'url'		=> 'C=modules'.AMP.'M='.$this->module_name.AMP.'P=delete',
			'heading'	=> 'low_variables_delete_confirmation',
			'message'	=> 'low_variables_delete_confirmation_'.(count($vars)==1?'one':'many'),
			'item'		=> implode('<br />', $var_names),
			'extra'		=> '',
			'hidden'	=> array('variable_id' => implode('|', $vars))
		));
	}

	// --------------------------------------------------------------------

	/**
	* Deletes variables
	*
	* @return	null
	*/
	function delete()
	{
		global $IN, $DB, $FNS;

		/** -------------------------------------
		/**  Get var ids
		/** -------------------------------------*/

		if ($vars = explode('|', $IN->GBL('variable_id', 'POST')))
		{
			$sql_vars = $this->_sql_in_array($vars);

			/** -------------------------------------
			/**  Delete from both tables
			/** -------------------------------------*/

			$DB->query("DELETE FROM `exp_global_variables` WHERE `variable_id` IN ({$sql_vars})");
			$DB->query("DELETE FROM `exp_low_variables` WHERE `variable_id` IN ({$sql_vars})");
		}

		/** -------------------------------------
		/**  Go to manage screen and show message
		/** -------------------------------------*/

		$this->_set_flashdata('msg', 'low_variables_deleted');
		$FNS->redirect($this->base_url.AMP.'P=manage');
		exit;
	}

	// --------------------------------------------------------------------

	/**
	* Changes given variables to given type
	*
	* @access	private
	* @param	array	$vars
	* @param	string	$type
	* @return	null
	*/
	function _change_type($vars = array(), $type = '')
	{
		global $IN, $DB, $FNS;

		/** -------------------------------------
		/**  Return url
		/** -------------------------------------*/

		$return_url = $this->base_url.AMP.'P=manage';

		/** -------------------------------------
		/**  Loop through vars and update
		/** -------------------------------------*/

		if ($vars && $type && in_array($type, array_keys($this->types)))
		{
			/** -------------------------------------
			/**  Get ids to update, insert others
			/** -------------------------------------*/

			$update = $this->_get_existing_ids();

			foreach ($vars AS $var_id)
			{
				/** -------------------------------------
				/**  Escape variables
				/** -------------------------------------*/

				$sql_var_id = $DB->escape_str($var_id);
				$sql_var_type = $DB->escape_str($type);

				/** -------------------------------------
				/**  Update/Insert record
				/** -------------------------------------*/

				if (in_array($var_id, $update))
				{
					$sql = "UPDATE `exp_low_variables` SET `variable_type` = '{$sql_var_type}' WHERE `variable_id` = '{$sql_var_id}'";
				}
				else
				{
					$sql = "INSERT INTO `exp_low_variables` (`variable_id`, `variable_type`) VALUES ('{$sql_var_id}', '{$sql_var_type}')";
				}

				$DB->query($sql);
			}

			/** -------------------------------------
			/**  Add feedback
			/** -------------------------------------*/

			$this->_set_flashdata('msg', 'low_variables_saved');
		}

		/** -------------------------------------
		/**  Go home
		/** -------------------------------------*/

		$FNS->redirect($return_url);
		exit;
	}

	// --------------------------------------------------------------------

	/**
	* Enables or disables early parsing for given vars
	*
	* @access	private
	* @param	array	$vars
	* @param	bool	$enable
	* @return	null
	*/
	function _set_early_parsing($vars = array(), $enable = FALSE)
	{
		global $IN, $DB, $FNS;

		/** -------------------------------------
		/**  Return url
		/** -------------------------------------*/

		$return_url = $this->base_url.AMP.'P=manage';

		/** -------------------------------------
		/**  Loop through vars and update
		/** -------------------------------------*/

		if ($vars)
		{
			/** -------------------------------------
			/**  Get ids to update, insert others
			/** -------------------------------------*/

			$update = $this->_get_existing_ids();

			foreach ($vars AS $var_id)
			{
				/** -------------------------------------
				/**  Escape variables
				/** -------------------------------------*/

				$sql_var_id = $DB->escape_str($var_id);
				$sql_var_ep = $enable ? 'y' : 'n';

				/** -------------------------------------
				/**  Update/Insert record
				/** -------------------------------------*/

				if (in_array($var_id, $update))
				{
					$sql = "UPDATE `exp_low_variables` SET `early_parsing` = '{$sql_var_ep}' WHERE `variable_id` = '{$sql_var_id}'";
				}
				else
				{
					$sql = "INSERT INTO `exp_low_variables` (`variable_id`, `early_parsing`) VALUES ('{$sql_var_id}', '{$sql_var_ep}')";
				}

				$DB->query($sql);
			}

			/** -------------------------------------
			/**  Add feedback
			/** -------------------------------------*/

			$this->_set_flashdata('msg', 'low_variables_saved');
		}

		/** -------------------------------------
		/**  Go home
		/** -------------------------------------*/

		$FNS->redirect($return_url);
		exit;
	}

	// --------------------------------------------------------------------

	/**
	* Saves variable data
	*
	* @return	null
	*/
    function save_var()
	{
		global $IN, $DB, $FNS, $DSP, $LANG, $PREFS;

		/** -------------------------------------
		/**  Return url
		/** -------------------------------------*/

		$return_url = $this->base_url.AMP.'P=manage';

		/** -------------------------------------
		/**  Get variable_id
		/** -------------------------------------*/

		if ( ! ($variable_id = $IN->GBL('variable_id', 'POST')) )
		{
			// No id found, exit!
			$FNS->redirect($return_url);
			exit;
		}
		else
		{
			$variable_id = $DB->escape_str($variable_id);
		}

		/** -------------------------------------
		/**  Get data from POST
		/** -------------------------------------*/

		$ee_vars = $low_vars = $errors = array();

		/** -------------------------------------
		/**  Check variable name
		/** -------------------------------------*/

		if (($var_name = $IN->GBL('variable_name', 'POST')) && preg_match('/^[a-zA-Z0-9\-_]+$/', $var_name))
		{
			$ee_vars['variable_name'] = $var_name;
		}
		else
		{
			$errors[] = 'invalid_variable_name';
		}

		/** -------------------------------------
		/**  Check variable data
		/** -------------------------------------*/

		if ($variable_id == 'new' && ($var_data = $IN->GBL('variable_data', 'POST')))
		{
			$ee_vars['variable_data'] = $var_data;
		}

		/** -------------------------------------
		/**  Check boolean values
		/** -------------------------------------*/

		foreach (array('early_parsing') AS $var)
		{
			$low_vars[$var] = ($value = $IN->GBL($var, 'POST')) ? 'y' : 'n';
		}

		/** -------------------------------------
		/**  Check other regular vars
		/** -------------------------------------*/

		foreach (array('variable_label', 'variable_notes', 'variable_type', 'variable_order') AS $var)
		{
			$low_vars[$var] = ($value = $IN->GBL($var, 'POST')) ? $value : '';
		}

		/** -------------------------------------
		/**  Check Settings for missing values (silly checkboxes eh?)
		/** -------------------------------------*/

		if (is_array($var_settings = $IN->GBL('variable_settings', 'POST')) && is_object($this->types[$low_vars['variable_type']]))
		{
			foreach (array_keys($this->types[$low_vars['variable_type']]->default_settings) AS $setting)
			{
				if (!isset($var_settings[$low_vars['variable_type']][$setting]))
				{
					$var_settings[$low_vars['variable_type']][$setting] = '';
				}
			}
		}

		$low_vars['variable_settings'] = $this->_sql_serialize($var_settings);

		/** -------------------------------------
		/**  Check for errors
		/** -------------------------------------*/

		if (!empty($errors))
		{
			$msg = array();

			foreach ($errors AS $line)
			{
				$msg[] = $LANG->line($line);
			}

			$this->body .= $DSP->error_message(implode('<br />', $msg));
			return;
		}

		/** -------------------------------------
		/**  Update EE table
		/** -------------------------------------*/

		if (!empty($ee_vars))
		{
			if ($variable_id == 'new')
			{
				/** -------------------------------------
				/**  Add site id to array, INSERT new var
				/**  Get inserted id
				/** -------------------------------------*/

				$ee_vars['site_id'] = $PREFS->ini('site_id');

				$DB->query($DB->insert_string('exp_global_variables', $ee_vars));

				$variable_id = $DB->insert_id;
			}
			else
			{
				$DB->query($DB->update_string('exp_global_variables', $ee_vars, "variable_id = '{$variable_id}'"));	
			}
		}

		/** -------------------------------------
		/**  Update low_variables table
		/** -------------------------------------*/

		if (!empty($low_vars))
		{
			$update = $this->_get_existing_ids();

			/** -------------------------------------
			/**  INSERT/UPDATE row
			/** -------------------------------------*/

			if (in_array($variable_id, $update))
			{
				$sql = $DB->update_string('exp_low_variables', $low_vars, "variable_id = '{$variable_id}'");
			}
			else
			{
				$low_vars['variable_id'] = $variable_id;

				$sql = $DB->insert_string('exp_low_variables', $low_vars);
			}

			$DB->query($sql);
		}
		else
		{
			/** -------------------------------------
			/**  Delete reference if no low_vars were found
			/** -------------------------------------*/

			$DB->query("DELETE FROM `exp_low_variables` WHERE `variable_id` = '{$variable_id}'");
		}

		/** -------------------------------------
		/**  Return with message
		/** -------------------------------------*/

		$this->_set_flashdata('msg', 'low_variables_saved');
		$FNS->redirect($return_url);
	}

	// --------------------------------------------------------------------

	/**
	* Saves variable sort order
	*
	* @return	null
	*/
    function save_order()
	{
		global $IN, $DB, $FNS;

		/** -------------------------------------
		/**  Return url
		/** -------------------------------------*/

		$return_url = $this->base_url;

		/** -------------------------------------
		/**  Get POST variable
		/** -------------------------------------*/

		if ($vars = $IN->GBL('vars', 'POST'))
		{
			/** -------------------------------------
			/**  Get ids to update, insert others
			/** -------------------------------------*/

			$update = $this->_get_existing_ids();

			/** -------------------------------------
			/**  Loop through vars and update DB
			/** -------------------------------------*/

			foreach ($vars AS $var_order => $var_id)
			{
				/** -------------------------------------
				/**  Escape variables
				/** -------------------------------------*/

				$sql_var_id = $DB->escape_str($var_id);
				$sql_var_order = $DB->escape_str($var_order + 1);

				/** -------------------------------------
				/**  Update/Insert record
				/** -------------------------------------*/

				if (in_array($var_id, $update))
				{
					$sql = "UPDATE `exp_low_variables` SET `variable_order` = '{$sql_var_order}' WHERE `variable_id` = '{$sql_var_id}'";
				}
				else
				{
					$sql = "INSERT INTO `exp_low_variables` (`variable_id`, `variable_order`) VALUES ('{$sql_var_id}', '{$sql_var_order}')";
				}

				$DB->query($sql);
			}

			/** -------------------------------------
			/**  Add feedback to return  url
			/** -------------------------------------*/

			$this->_set_flashdata('msg', 'low_variables_saved');
			$return_url .= AMP.'P=manage';

		}

		/** -------------------------------------
		/**  Go home
		/** -------------------------------------*/

		$FNS->redirect($return_url);
		exit;
	}

	// --------------------------------------------------------------------

	/**
	* Gets settings
	*
	* @access	private
	* @return	null
	*/
	function _get_settings()
	{
		global $SESS, $DB, $DSP, $LANG;

		/** -------------------------------------
		/**  Get settings from extension, cache or DB
		/** -------------------------------------*/

		if (isset($SESS->cache['low']['variables']['settings']))
		{
			$this->settings = $SESS->cache['low']['variables']['settings'];
		}
		else
		{
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE class = 'Low_variables_ext' LIMIT 1");
			$this->settings = ($query->num_rows == 1) ? unserialize($query->row['settings']) : array();
		}

		if ( ! empty($this->settings))
		{
			/** -------------------------------------
			/**  We have settings? Fix prefix
			/** -------------------------------------*/

			if ($this->settings['prefix'] && substr($this->settings['prefix'], -1) != '_')
			{
				$this->settings['prefix'] .= '_';
			}

			/** -------------------------------------
			/**  Is current user a Variable Manager?
			/** -------------------------------------*/

			$this->settings['is_manager'] = in_array($SESS->userdata['group_id'], $this->settings['can_manage']);

			/** -------------------------------------
			/**  Add settings to data array for views
			/** -------------------------------------*/

			$this->data['settings'] = $this->settings;

			return TRUE;
		}
		else
		{
			/** -------------------------------------
			/**  No settings? Show error and bail
			/** -------------------------------------*/

			$DSP->title = $DSP->crumb = $LANG->line('low_variables_module_name');
			$DSP->body = $DSP->qdiv('box alert', $LANG->line('settings_not_found'));

			return FALSE;
		}

	}

	// --------------------------------------------------------------------

	/**
	* Include Variable Types
	*
	* @access	private
	* @return	null
	*/
	function _include_types()
	{
		/** -------------------------------------
		/**  Get Low_variables_types.php library
		/** -------------------------------------*/

		if ( ! class_exists('Low_variables_type') )
		{
			require_once $this->base_path.'libraries/Low_variables_type'.EXT;
		}

		/** -------------------------------------
		/**  Set variable types path
		/** -------------------------------------*/

		$types_path = $this->base_path.'types/';

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

			// determine file name
			$file = $types_path.$type.'/vt.'.$type.EXT;

			if (!class_exists($type) && file_exists($file))
			{
				include($file);

				if (class_exists($type))
				{
					$this->types[$type] = new $type();
				}
			}

		}
		// clean up
		closedir($dir);
		unset($dir);

		// Sort types by alpha
		ksort($this->types);
	}

	// --------------------------------------------------------------------

	/**
	* Get existing ids from exp_low_variables table
	*
	* @access	private
	* @return	array
	*/
	function _get_existing_ids()
	{
		global $DB;

		/** -------------------------------------
		/**  Initiate ids array
		/** -------------------------------------*/

		$ids = array();

		/** -------------------------------------
		/**  Execute query
		/** -------------------------------------*/

		$query = $DB->query("SELECT variable_id FROM exp_low_variables");

		/** -------------------------------------
		/**  Loop thru results
		/** -------------------------------------*/

		foreach ($query->result AS $row)
		{
			$ids[] = $row['variable_id'];
		}

		/** -------------------------------------
		/**  Return array of ids
		/** -------------------------------------*/

		return $ids;
	}

	// --------------------------------------------------------------------

	/**
	* Get settings array for given type
	*
	* @access	private
	* @param	string		$type
	* @param	mixed		$settings	(serialized) array	
	* @return	mixed		Either array of settings or FALSE
	*/
	function _get_type_settings($type, $settings = '')
	{
		// Set type to default type if not defined
		if (!$type)
		{
			$type = $this->default_type;
		}

		// unserialize if necessary
		if (is_string($settings))
		{
			$settings = $this->_sql_unserialize($settings);
		}

		// Get type settings
		if (isset($settings[$type]))
		{
			$set = $settings[$type];
		}
		// fallback to default settings
		elseif (isset($this->types[$type]->default_settings))
		{
			$set = $this->types[$type]->default_settings;
		}
		else
		{
			$set = FALSE;
		}

		return $set;
	}

	// --------------------------------------------------------------------

	/**
	* Returns SUBSTRING statement to use in WHERE clause
	*
	* @access	private
	* @param	string	$attr	attribute to check
	* @return	string
	*/
	function _sql_where_prefix($attr = 'variable_name')
	{
		global $DB, $SESS;

		// init return value
		$r = '';

		// Only add prefix-where if there is a prefix
		if ($this->settings['prefix'] != '')
		{
			$sql_attr = $DB->escape_str($attr);
			$sql_prefix = $DB->escape_str($this->settings['prefix']);
			$sql_prefix_length = strlen($this->settings['prefix']);
			$sql_operator = $this->settings['with_prefixed'] == 'show' ? '=' : '!=';

			$r = "AND SUBSTRING({$sql_attr}, 1, {$sql_prefix_length}) {$sql_operator} '{$sql_prefix}'";
		}

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	* Returns escaped comma-separated array for SQL
	*
	* @access	private
	* @param	array	$array
	* @return	string
	*/
	function _sql_in_array($array = array())
	{
		global $DB;

		$sql_array = array();

		foreach ($array AS $row)
		{
			$sql_array[] = "'".$DB->escape_str($row)."'";
		}

		return implode(',', $sql_array);
	}

	// --------------------------------------------------------------------

	/**
	* Returns escaped serialized array for SQL. Backslashes, anyone?
	*
	* @access	private
	* @param	array	$array
	* @return	string
	*/
	function _sql_serialize($array = array())
	{
		return preg_replace('/\\\("|\'|\\\)/', '\\\\\\\\\\\$1', serialize($array));
	}

	// --------------------------------------------------------------------

	/**
	* Returns stripslashed unserialized string from SQL
	*
	* @access	private
	* @param	string	$str
	* @return	string
	*/
	function _sql_unserialize($str = '')
	{
		global $REGX;

		return (is_string($str)) ? $REGX->array_stripslashes(unserialize($str)) : $str;
	}

	// --------------------------------------------------------------------

	/**
	* License check
	*
	* @access	private
	* @return	bool
	*/
	function _license()
	{
		global $LANG, $DSP;

 		if ( ! ($this->settings['license_key'] && is_numeric($this->settings['license_key']) && (strlen($this->settings['license_key']) == 25))
				&&
			 ! ($this->settings['license_key'] && preg_match('/^[0-9a-f]{8}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{4}\-[0-9a-f]{12}$/', $this->settings['license_key']))
			)
		{
			$DSP->title = $DSP->crumb = $LANG->line('low_variables_module_name');
			$DSP->body = $DSP->qdiv('box alert', 
				'Your license key appears to be invalid. You can get a valid one here: '.
				'<a href="'.$this->docs_url.'">'. $LANG->line('low_variables_module_name').'</a>. '.
				'Enter your key here: '.
				'<a href="'.BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extension_settings'.AMP.'name=low_variables_ext">'.$DSP->title.' Extension settings</a>.'
			);

			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}

	// --------------------------------------------------------------------

	/**
	* Sync EE vars and Low vars
	*
	* Deletes Low Variables that reference to non-existing EE Variables
	*
	* @access	private
	* @return	null
	*/
	function _sync()
	{
		global $DB;

		/** -------------------------------------
		/**  Initiate ids array
		/** -------------------------------------*/

		$ids = array();

		/** -------------------------------------
		/**  Execute query
		/** -------------------------------------*/

		$query = $DB->query("SELECT variable_id FROM exp_global_variables");

		/** -------------------------------------
		/**  Loop thru results
		/** -------------------------------------*/

		foreach ($query->result AS $row)
		{
			$ids[] = $row['variable_id'];
		}

		/** -------------------------------------
		/**  Delete non-existing rows in exp_low_variables
		/** -------------------------------------*/

		if (!empty($ids))
		{
			$DB->query("DELETE FROM exp_low_variables WHERE variable_id NOT IN (".implode(',', $ids).")");	
		}

	}

	// --------------------------------------------------------------------

	/**
	* Assign variable to $_SESSION object
	*
	* @access	private
	* @param	string	$key	Name of the variable to get
	* @param	mixed	$val	Fallback value if variable isn't set
	* @return	bool	TRUE if successful
	*/
	function _set_flashdata($key, $val)
	{
		if (isset($_SESSION))
		{
			$_SESSION['low']['variables'][$key] = $val;
			$ok = TRUE;
		}
		else
		{
			$ok = FALSE;
		}
		return $ok;
	}

	// --------------------------------------------------------------------

	/**
	* Get variable from $_SESSION and unset afterwards
	*
	* @access	private
	* @param	string	$key	Name of the variable to get
	* @param	mixed	$val	Fallback value if variable isn't set
	* @return	mixed
	*/
	function _get_flashdata($key, $val = FALSE)
	{
		if (isset($_SESSION['low']['variables'][$key]))
		{
			$val = $_SESSION['low']['variables'][$key];
			unset($_SESSION['low']['variables'][$key]);
		}

		return $val;
	}

	// --------------------------------------------------------------------

	/**
	* Load assets: extra JS and CSS
	*
	* @access	private
	* @return	void
	* @since	1.1.5
	*/
	function _load_assets()
	{
		global $DSP, $PREFS;

		/** -------------------------------------
		/**  Assets to load
		/** -------------------------------------*/

		$assets = array(
			'styles/low_variables.css',
			'scripts/jquery.cookie.js',
			'scripts/low_variables.js'
		);

		/** -------------------------------------
		/**  Define placeholder
		/** -------------------------------------*/

		$header = array();

		/** -------------------------------------
		/**  Loop through assets
		/** -------------------------------------*/

		$asset_url = $PREFS->ini('theme_folder_url') . 'low_variables/';

		foreach ($assets AS $file)
		{
			// location on server
			$file_url = $asset_url.$file;

			if (substr($file, -3) == 'css')
			{
				$header[] = '<link rel="stylesheet" href="'.$file_url.'" type="text/css" media="screen" />';
			}
			elseif (substr($file, -2) == 'js')
			{
				$header[] = '<script type="text/javascript" src="'.$file_url.'"></script>';
			}
		}

		/** -------------------------------------
		/**  Add combined assets to header
		/** -------------------------------------*/

		if ($header)
		{
			$DSP->extra_header .= NL.'<!-- Low Variables Assets -->'.NL.implode(NL, $header).NL.'<!-- / Low Variables Assets -->'.NL;
		}
	}

	// --------------------------------------------------------------------

	/**
	* Module Upgrade
	*
	* @access	private
	* @return	null
	*/
	function _upgrade()
	{
		global $DB;

		/** -------------------------------------
		/**  Check version in DB
		/** -------------------------------------*/

		$query = $DB->query("SELECT module_version FROM exp_modules WHERE module_name = '".$DB->escape_str($this->module_name)."' LIMIT 1");

		/** -------------------------------------
		/**  Same version? A-okay, daddy-o!
		/** -------------------------------------*/

		if (version_compare($query->row['module_version'], $this->version) === 0)
		{
			return;
		}

		/** -------------------------------------
		/**  Upgrade to 1.1.0
		/** -------------------------------------*/

		if (version_compare($query->row['module_version'], '1.1.0', '<'))
		{
			$DB->query("ALTER TABLE `exp_low_variables` ADD `variable_notes` TEXT NOT NULL AFTER `variable_label`");
		}

		/** -------------------------------------
		/**  Update version number in DB
		/** -------------------------------------*/

		$DB->query("UPDATE exp_modules SET module_version = '".$DB->escape_str($this->version)."' WHERE module_name = '".$DB->escape_str($this->module_name)."'");

	}

	// --------------------------------------------------------------------

	/**
	* Module Installation
	*
	* @param	bool	$enable_ext
	* @return	null
	*/
	function low_variables_module_install($enable_ext = TRUE)
	{
		global $DB;

		/** -------------------------------------
		/**  Define queries
		/** -------------------------------------*/

		$sql[] = "CREATE TABLE IF NOT EXISTS `exp_low_variables` (
					`variable_id` int(6) unsigned NOT NULL,
					`variable_label` varchar(100) NOT NULL,
					`variable_notes` text NOT NULL,
					`variable_type` varchar(50) NOT NULL,
					`variable_settings` text NOT NULL,
					`variable_order` int(4) unsigned NOT NULL,
					`early_parsing` char(1) default 'n' NOT NULL,
					PRIMARY KEY (`variable_id`))";

		$sql[] = $DB->insert_string('exp_modules', array(
					'module_name'		=> $this->module_name,
					'module_version'	=> $this->version,
					'has_cp_backend'	=> 'y'));

		/** -------------------------------------
		/**  Execute queries
		/** -------------------------------------*/

		foreach ($sql as $query)
		{
			$DB->query($query);
		}

		/** -------------------------------------
		/**  Enable extension
		/** -------------------------------------*/

		if ($enable_ext === TRUE)
		{
			if ( ! class_exists('Low_variables_ext') )
			{
				@require_once(PATH_EXT.'ext.low_variables_ext.php');
			}

			$EXT = new Low_variables_ext;
			$EXT->activate_extension(FALSE);
		}
	}

	// --------------------------------------------------------------------

	/**
	* Module Uninstallation
	*
	* @param	bool	$disable_ext
	* @return	null
	*/
	function low_variables_module_deinstall($disable_ext = TRUE)
	{
		global $DB;

		/** -------------------------------------
		/**  Define queries
		/** -------------------------------------*/

		$sql[] = "DROP TABLE IF EXISTS `exp_low_variables`";
		$sql[] = "DELETE FROM exp_modules WHERE module_name = '".$DB->escape_str($this->module_name)."'";

		/** -------------------------------------
		/**  Execute queries
		/** -------------------------------------*/

		foreach ($sql as $query)
		{
			$DB->query($query);
		}

		/** -------------------------------------
		/**  Disable extension
		/** -------------------------------------*/

		if ($disable_ext === TRUE)
		{
			if ( ! class_exists('Low_variables_ext') )
			{
				@require_once(PATH_EXT.'ext.low_variables_ext.php');
			}

			$EXT = new Low_variables_ext;
			$EXT->disable_extension(FALSE);
		}
	}

} // End Class
