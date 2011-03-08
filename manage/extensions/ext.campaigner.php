<?php if ( ! defined('EXT')) exit('Invalid file request');

/**
 * Effortlessly subscribe members of your ExpressionEngine site to one or more Campaign Monitor mailing lists.
 *
 * @package		Campaigner
 * @version 	3.0.3
 * @author 		Stephen Lewis <stephen@experienceinternet.co.uk>
 * @copyright 	Copyright (c) Stephen Lewis
 * @link 		http://experienceinternet.co.uk/software/campaigner/
 */

class Campaigner {
	
	/* --------------------------------------------------------------
	 * PUBLIC PROPERTIES
	 * ------------------------------------------------------------ */
	
	/**
	 * The extension name.
	 *
	 * @access	public
	 * @var 	string
	 */
	public $name = 'Campaigner';
	
	/**
	 * Extension description. Set in the constructor, so it can be localised.
	 *
	 * @access	public
	 * @var 	string
	 */
	public $description = 'Effortlessly subscribe members of your ExpressionEngine site to one or more Campaign Monitor mailing lists.';
	
	/**
	 * Extension documentation URL.
	 *
	 * @access	public
	 * @var 	string
	 */
	public $docs_url = 'http://experienceinternet.co.uk/software/campaigner/';
	
	/**
	 * Extension settings.
	 *
	 * @access	public
	 * @var 	array
	 */
	public $settings = array();
	
	/**
	 * Does the extension have a control panel?
	 *
	 * @access	public
	 * @var 	string
	 */
	public $settings_exist = 'y';
	
	/**
	 * The extension version.
	 *
	 * @access	public
	 * @var 	string
	 */
	public $version = '3.0.3';
	
	
	/* --------------------------------------------------------------
	 * PRIVATE PROPERTIES
	 * Initialised in the constructor.
	 * ------------------------------------------------------------ */
	
	/**
	 * Class name. Saves running get_class($this) every time.
	 *
	 * @access	private
	 * @var 	string
	 */
	private $_class_name = '';
	
	/**
	 * Class name, converted to lowercase.
	 *
	 * @access	private
	 * @var 	string
	 */
	private $_lower_class_name = '';
	
	/**
	 * The site ID.
	 *
	 * @access	private
	 * @param 	string
	 */
	private $_site_id = '';
	
	/**
	 * The default and custom member fields.
	 *
	 * @access	private
	 * @var 	array
	 */
	private $_member_fields = array();
	
	/**
	 * A list of all the clients for the current Campaign Monitor account.
	 * Stored separately from the settings, as we don't want to save it to
	 * the database.
	 *
	 * @access	private
	 * @var 	array
	 */
	private $_all_clients = array();
	
	/**
	 * A list of all the mailing lists for the current client. Stored
	 * separately from the settings, as we don't want to save it to the database.
	 *
	 * @access	private
	 * @var 	array
	 */
	private $_all_mailing_lists = array();
	
	/**
	 * Error messages to display.
	 *
	 * @access	private
	 * @var 	array
	 */
	private $_errors = array();
	
	/**
	 * The base for all extension URLs.
	 *
	 * @access	private
	 * @var 	string
	 */
	private $_base_url = '';
	
	/**
	 * The path to the themes folder.
	 *
	 * @access	private
	 * @var 	string
	 */
	private $_themes_path = '';
	
	/**
	 * The URL to the themes folder.
	 *
	 * @access	private
	 * @var 	string
	 */
	private $_themes_url = '';
	
	/**
	 * A direct link to the hotline of help.
	 *
	 * @access	private
	 * @var 	string
	 */
	private $_support_url = 'http://support.experienceinternet.co.uk/discussions/campaigner/';
	
	
	
	/* --------------------------------------------------------------
	 * PUBLIC METHODS
	 * ------------------------------------------------------------ */
	
	/**
	 * Constructor.
	 *
	 * @access  public
	 * @param   array|string    $settings   Extension settings; associative array or empty string.
	 * @return 	void
	 */
	public function __construct($settings='')
	{
		$this->_initialize($settings);
	}
	
	
	/**
	 * Activate the extension.
	 *
	 * @access	public
	 * @return 	void
	 */
	public function activate_extension()
	{
		global $DB, $PREFS;
		
		/**
		 * Create the 'error log' table.
		 */
		
		if (version_compare(mysql_get_server_info(), '5.0.0', '<'))
		{
			// We take a punt.
			$engine = 'MyISAM';
		}
		else
		{
			$db_engine = $DB->query("SELECT `ENGINE` AS `engine`
				FROM information_schema.TABLES
				WHERE TABLE_SCHEMA =  '" .$PREFS->ini('db_name') ."'
				AND TABLE_NAME = 'exp_sites'
				LIMIT 1");

			if ($db_engine->num_rows !== 1)
			{
				exit('Unable to determine your database engine.');
			}

			$engine = $db_engine->row['engine'];
		}
		
		$DB->query("CREATE TABLE IF NOT EXISTS exp_campaigner_error_log (
				error_log_id int(10) unsigned NOT NULL auto_increment,
				site_id int(5) unsigned NOT NULL default 1,
				error_date int(10) unsigned NOT NULL,
				api_method varchar(255) NOT NULL,
				member_id int(10) unsigned NOT NULL,
				list_id varchar(255) NOT NULL,
				api_error_code int(3),
				api_error_message varchar(255),
				CONSTRAINT pk_error_log PRIMARY KEY(error_log_id),
				CONSTRAINT fk_error_log_site_id FOREIGN KEY(site_id) REFERENCES exp_sites(site_id))
			ENGINE = {$engine}");
			
		// Add the new 'Campaigner' extension hooks to the database.
		$this->_register_hooks();
	}
	
	
	/**
	 * Updates the extension.
	 *
	 * @access	public
	 * @param 	string 		$current 	The current extension version.
	 * @return 	bool
	 */
	public function update_extension($current='')
	{
		global $DB, $REGX;
		
		if ( ! $current OR $current == $this->version)
		{
			return FALSE;
		}
		
		// Update the version number.
		if ($current < $this->version)
		{
			$DB->query("UPDATE exp_extensions SET version = '{$this->version}' WHERE class = '{$this->_class_name}'");
		}
		
		return TRUE;
	}


	/**
	 * Disables the extension, and deletes settings from the database.
	 *
	 * @access	public
	 * @return 	void
	 */
	public function disable_extension()
	{
		global $DB;
		
		$DB->query("DELETE FROM exp_extensions WHERE class = '{$this->_class_name}'");
		$DB->query('DROP TABLE IF EXISTS exp_campaigner_error_log');
	}
	
	
	/**
	 * Outputs the extension settings form.
	 *
	 * @access	public
	 * @return 	void
	 */
	public function settings_form()
	{	
		global $DB, $DSP, $LANG, $IN;
		
		// AJAX requests are dealt with separately, by show_full_control_panel_start.
		if ($IN->GBL('ajax_request') == 'y')
		{
			return FALSE;
		}
		
		// Initialise the member fields.
		$this->_member_fields = $this->_ini_member_fields();
		
		// Update the 'all clients' list.
		if ($this->settings['api_key'])
		{
			$this->_load_clients_from_api();
		}
		
		// Update the 'all mailing lists' list.
		if ($this->settings['api_key'] && $this->settings['client_id'])
		{
			$this->_load_mailing_lists_from_api();
		}
		
		// Load the error log.
		$db_error_log = $DB->query("SELECT * FROM exp_campaigner_error_log
			WHERE site_id = '{$this->_site_id}'
			ORDER BY error_date DESC");
		
		/**
		 * Build an array of JavaScript variables that need to be written out
		 * dynamically.
		 */
		
		$js_vars = array(
			'addonId' => $this->_lower_class_name,
			'ajaxUrl' => str_replace('&amp;', '&', $this->_base_url),
			'languageStrings' => array(
				'missingApiKey'		=> addslashes($LANG->line('js_missing_api_key')),
				'missingClientId'	=> addslashes($LANG->line('js_missing_client_id')),
			),
			'memberFields' => $this->_member_fields
		);
		
		// Create the 'view data' array.
		$view_data = array(
			'all_clients'		=> $this->_all_clients,
			'all_mailing_lists'	=> $this->_all_mailing_lists,
			'docs_url'			=> $this->docs_url,
			'errors'			=> $this->_errors,
			'db_error_log'		=> $db_error_log,
			'form_open'			=> $DSP->form_open(
				array(
					'action'	=> 'C=admin' .AMP .'M=utilities' .AMP .'P=save_extension_settings',
					'id'		=> 'extension_settings',
					'name'		=> 'extension_settings'
				),
				array(
					'action'	=> 'save_settings',
					'name' 		=> $this->_lower_class_name
				)
			),
			'js_vars'		=> $js_vars,
			'js_include'	=> $this->_themes_path .'js/admin.php',
			'member_fields'	=> $this->_member_fields,
			'settings'		=> $this->settings,
			'support_url'	=> $this->_support_url,
			'themes_path'	=> $this->_themes_path,
			'themes_url'	=> $this->_themes_url,
			'version'		=> $this->version
		);
		
		// Output everything.
		$DSP->extra_header	.= $this->_build_ui_headers();
		$DSP->title 		= $LANG->line('extension_name') .' ' .$LANG->line('extension_settings');
		$DSP->crumbline 	= TRUE;
		$DSP->crumb 		= $this->_build_ui_breadcrumbs();
		$DSP->body 			= $this->_load_view('settings', $view_data);

		// 'Disable extension' button. Completely different syntax for some reason.
		$DSP->right_crumb($LANG->line('disable_extension'),
			BASE .AMP .'C=admin' .AMP. 'M=utilities' .AMP. 'P=toggle_extension' .AMP. 'which=disable' .AMP. 'name=' .$IN->GBL('name')
		);
	}
	
	
	/**
	 * Saves the Extension settings.
	 *
	 * @access	public
	 * @return 	void
	 */
	public function save_settings()
	{
		global $DB, $REGX;
		
		/**
		 * We need to be careful not to overwrite the settings for other MSM sites.
		 * First we load the existing settings, then we replace the settings for
		 * the current site with our new settings, then we save everything back to
		 * the database.
		 */
		
		$db_settings = $DB->query("SELECT settings
			FROM exp_extensions
			WHERE class = '{$this->_class_name}'
			LIMIT 1");
			
		$settings = $db_settings->row['settings']
			? $REGX->array_stripslashes(unserialize($db_settings->row['settings']))
			: array();
			
		$settings[$this->_site_id] = $this->settings;
		
		// Serialise the settings, and save them to the database.
		$DB->query("UPDATE exp_extensions
			SET settings = '" .addslashes(serialize($settings)) ."'
			WHERE class = '{$this->_class_name}'");
	}
	
	
	
	/* --------------------------------------------------------------
	 * HOOK HANDLERS
	 * ------------------------------------------------------------ */

	/**
	 * Handlers to cp_members_member_create hook.
	 *
	 * @see		http://expressionengine.com/developers/extension_hooks/cp_members_member_create/
	 * @access	public
	 * @param	string		$member_id		The ID of the newly-created member.
	 * @param	array 		$member_data	Information about the newly-created member.
	 * @return	void
	 */
	public function cp_members_member_create($member_id = '', $member_data = array())
	{
		if ($member_id)
		{
			$this->_subscribe($member_id);
		}
	}
	
	
	/**
	 * Handlers to cp_members_validate_members hook.
	 *
	 * @see		http://expressionengine.com/developers/extension_hooks/cp_members_validate_members/
	 * @access	public
	 * @return	void
	 */
	public function cp_members_validate_members()
	{
		if ( ! isset($_POST['action']) OR $_POST['action'] != 'activate')
		{
			return;
		}
		
		$member_ids = array();
		foreach ($_POST AS $key => $val)
		{
			if (strpos($key, 'toggle') === 0 && ! is_array($val))
			{
				$member_ids[] = $val;
			}
		}
		
		if ($member_ids)
		{
			foreach ($member_ids AS $member_id)
			{
				$this->_subscribe($member_id);
			}
		}
	}
	
	
	/**
	 * Handles the AJAX requests. These were originally handled via sessions_start, but
	 * there were so many problems with the Language class that I just gave up.
	 *
	 * Now the work is split between sessions_start, which checks whether we should be
	 * processing this page, and show_control_panel_start, which handles all the AJAX stuff.
	 *
	 * The split is necessary because the query string variables passed via AJAX disappear
	 * by the time we get to show_control_panel_start. They're even unset in the $_GET array.
	 *
	 * I'm not making this shit up.
	 *
	 * @access	public
	 * @return	void
	 */
	public function show_full_control_panel_start()
	{
		global $IN;
		
		if ( ! $this->_is_my_house())
		{
			return;
		}
		
		// We're only interested in AJAX requests for this add-on.
		if ($IN->GBL('ajax_request', 'GET') == 'y' && $IN->GBL('addon_id', 'GET') == $this->_lower_class_name)
		{
			$action = $IN->GBL('action', 'GET');
			switch ($action)
			{
				case 'get_clients':
					$this->_output_ajax_response($this->_build_ui_clients());
					break;
					
				case 'get_lists':
					$this->_member_fields = $this->_ini_member_fields();
					$this->_output_ajax_response($this->_build_ui_lists());
					break;
					
				default:
					// No idea.
					break;
			}
		}
	}
	
	
	/**
	 * Handles the member_member_register hook.
	 *
	 * @access	public
	 * @param 	array 	$data 	An array of data about the new member.
	 * @return 	void
	 */	
	public function member_member_register($data = array())
	{
		global $PREFS, $DB;
		
		if ((strtolower($PREFS->ini('req_mbr_activation')) !== 'none') OR
			( ! isset($data['username'])) OR
			( ! isset($data['email'])) OR
			( ! isset($data['join_date'])))
		{
			return FALSE;
		}
		
		$member = $DB->query("SELECT member_id
			FROM exp_members
			WHERE username = '{$data['username']}'
			AND email = '{$data['email']}'
			AND join_date = '{$data['join_date']}'");
			
		if ($member->num_rows === 1)
		{
			$this->_subscribe($member->row['member_id']);
		}
	}
	
	
	/**
	 * Handles the member_register_validate_members hook.
	 *
	 * @access	public
	 * @param	string		$member_id		The ID of the member that has just confirmed his registration.
	 * @return 	void
	 */
	public function member_register_validate_members($member_id = '')
	{
		global $PREFS;
		
		if ($member_id && strtolower($PREFS->ini('req_mbr_activation')) === 'email')
		{
			$this->_subscribe($member_id);
		}
	}
	
	
	/**
	 * Handles the User module user_edit_end hook.
	 *
	 * @access	public
	 * @param 	string		$member_id			The member ID.
	 * @param 	array 		$member_data		Information about the member.
	 * @param 	array 		$custom_fields		Custom member fields.
	 * @return 	bool
	 */
	public function user_edit_end($member_id = '', $member_data = array(), $custom_fields = array())
	{
		return $this->_subscribe($member_id, TRUE, TRUE);
	}
	
	
	/**
	 * Handles the User module user_register_end hook.
	 *
	 * @access  public
	 * @param   array   $userdata   An array of data about the new member.
	 * @param   int     $member_id  The ID of the new member.
	 * @return  array
	 */
	public function user_register_end($userdata = array(), $member_id = '')
	{
		global $PREFS;
		
		if ($member_id && strtolower($PREFS->ini('req_mbr_activation')) === 'none')
		{
			$this->_subscribe($member_id);
		}
	  
		return $userdata;
	}
	
	
	
	/* --------------------------------------------------------------
	 * PRIVATE METHODS
	 * ------------------------------------------------------------ */
	
	/**
	 * Checks for an API error, and if found writes it to the error log.
	 *
	 * @access	private
	 * @param	string		$api_method		The API method that was called.
	 * @param	object		$api_result		The API result object.
	 * @return	bool
	 */
	private function _check_for_api_error($api_method = '', $api_result = array(), $member_data, $list_data)
	{
		global $DB;
		
		if ( ! $api_method
			OR ! is_array($member_data)
			OR ! is_array($list_data)
			OR ! isset($member_data['member_id'])
			OR ! isset($list_data['list_id']))
		{
			return TRUE;
		}
		
		if ( ! array_key_exists('Code', $api_result) OR $api_result['Code'] != '0')
		{
			if (array_key_exists('Code', $api_result))
			{
				$api_error_code = $api_result['Code'];
				$api_error_message = $api_result['Message'];
			}
			else
			{
				$api_error_code = -1;
				$api_error_message = 'Unknown error.';
			}
			
			$DB->query($DB->insert_string(
				'exp_campaigner_error_log',
				array(
					'api_method'		=> $api_method,
					'api_error_code'	=> $api_error_code,
					'api_error_message'	=> $api_error_message,
					'error_date'		=> time(),
					'list_id'			=> $list_data['list_id'],
					'member_id'			=> $member_data['member_id'],
					'site_id'			=> $this->_site_id,
				)
			));
			
			return TRUE;
		}
		
		return FALSE;
	}
	
	
	/**
	 * Returns the default site settings.
	 *
	 * @access	private
	 * @return	array
	 */
	private function _get_default_site_settings()
	{
		return array(
			'site_id'		=> $this->_site_id,
			'api_key'		=> '',
			'client_id'		=> '',
			'mailing_lists'	=> array()
		);
	}
	
	
	/**
	 * Initialises the site settings.
	 *
	 * @access	private
	 * @param 	array 		$saved_settings		Saved settings, passed from the constructor, sometimes.
	 * @return	array
	 */
	private function _ini_site_settings($saved_settings = array())
	{
		global $DB, $REGX;
		
		/**
		 * Most of the time, the __construct method will pass us the saved settings.
		 * However, if it's run as a result of the sessions_start method being called,
		 * it doesn't, and we're left to fend for ourselves.
		 *
		 * If this all sounds like a stupid ball-ache, and you're wondering why the
		 * Sessions class has to be such a dick, don't ask me, ask EllisLab.
		 */
		
		if ( ! $saved_settings OR ! is_array($saved_settings))
		{
			// Load the settings from the database.
			$db_settings = $DB->query("SELECT settings
				FROM exp_extensions
				WHERE class = '{$this->_class_name}'
				LIMIT 1");

			$saved_settings = $db_settings->row['settings']
				? $REGX->array_stripslashes(unserialize($db_settings->row['settings']))
				: array();
		}
		
		// Extract the site settings from the $saved_settings array.
		if (array_key_exists($this->_site_id, $saved_settings))
		{
			$saved_settings = $saved_settings[$this->_site_id];
		}
		
		return array_merge($this->_get_default_site_settings(), $saved_settings);
	}
	
	
	/**
	 * Initialises the member fields.
	 *
	 * @access  private
	 * @return 	array
	 */
	private function _ini_member_fields()
	{
		global $DB, $LANG;
		
		/**
  		 * The default member fields are hard-coded in EE, so we have to do the same.
  		 * Note that we deliberately don't include "email" in this list.
  		 */
		
		$LANG->fetch_language_file($this->_lower_class_name);

		$member_fields = array(
			'group_id' => array(
				'id'		=> 'group_id',
				'label'		=> $LANG->line('member_group_id'),
				'options'	=> array(),
				'type'		=> 'text'
			),
			'location' => array(
				'id'		=> 'location',
				'label'		=> $LANG->line('member_location'),
				'options'	=> array(),
				'type'		=> 'text'
			),
			'screen_name' => array(
				'id'		=> 'screen_name',
				'label'		=> $LANG->line('member_screen_name'),
				'options'	=> array(),
				'type'		=> 'text'
			),
			'url' => array(
				'id'		=> 'url',
				'label'		=> $LANG->line('member_url'),
				'options'	=> array(),
				'type'		=> 'text'
			),
			'username' => array(
				'id'		=> 'username',
				'label'		=> $LANG->line('member_username'),
				'options'	=> array(),
				'type'		=> 'text'
			)
		);

		// Custom member fields are loaded from the database.
		$db_fields = $DB->query('SELECT
			m_field_id AS `id`,
			m_field_label AS `label`,
			m_field_type AS `type`,
			m_field_list_items AS `options`
			FROM exp_member_fields');

		foreach ($db_fields->result AS $db_field)
		{
			$member_fields['m_field_id_' .$db_field['id']] = array(
				'id'		=> 'm_field_id_' .$db_field['id'],
				'label'		=> $db_field['label'],
				'options'	=> $db_field['type'] == 'select' ? explode("\n", $db_field['options']) : array(),
				'type'		=> $db_field['type'] == 'select' ? 'select' : 'text'
			);
		}
		
		return $member_fields;
	}
	
	
	/**
	 * Initialise the class.
	 *
	 * @access	private
	 * @param	mixed		$settings		Saved extension settings.
	 * @param	bool		$force			Forces the initialisation code to run, even if the 'my house' criteria are not met.
	 * @return	void
	 */
	private function _initialize($settings = '', $force = FALSE)
	{
		global $DB, $PREFS;
		
		$this->_class_name			= get_class($this);
		$this->_lower_class_name	= strtolower($this->_class_name);
		
		if ($force !== TRUE && ! $this->_is_my_house())
		{
			return;
		}
		
		$this->_site_id		= $DB->escape_str($PREFS->ini('site_id'));
		
		$this->_themes_url	= $PREFS->ini('theme_folder_url');
		$this->_themes_url .= (substr($PREFS->ini('theme_folder_url'), -1) == '/') ? '' : '/';
		$this->_themes_url .= 'cp_themes/' .$PREFS->ini('cp_theme') .'/' .$this->_lower_class_name .'/';
		
		$this->_themes_path = $PREFS->ini('theme_folder_path');
		$this->_themes_path .= (substr($PREFS->ini('theme_folder_path'), -1) == '/') ? '' : '/';
		$this->_themes_path .= 'cp_themes/' .$PREFS->ini('cp_theme') .'/' .$this->_lower_class_name .'/';
		
		// Initialise the site settings, and update them with any POST data.
		$this->settings = $this->_ini_site_settings($settings);
		$this->_update_settings_from_input();
		
		$this->_base_url = (defined('BASE') && defined('AMP'))
			? BASE .AMP .'C=admin' .AMP .'M=utilities' .AMP .'P=extension_settings' .AMP .'name=' .$this->_lower_class_name
			: '';
		
		// Load the Campaign Monitor PHP helper class.
		if ( ! class_exists('CampaignMonitor'))
		{
			require_once PATH_EXT .$this->_lower_class_name .'/CMBase.php';
		}
	}
	
	
	/**
	 * Checks whether the 'my_house' Session variable has been set, and if so,
	 * if it's 'true'.
	 *
	 * @access	private
	 * @return	bool
	 */
	private function _is_my_house()
	{
		global $IN;
		
		return (($IN->GBL('P', 'GET') == 'extension_settings'
		 	&& $IN->GBL('name', 'GET') == $this->_lower_class_name)
			OR $IN->GBL('P', 'GET') == 'save_extension_settings');
	}
	
	
	/**
	 * Logs the specified message.
	 *
	 * @access	private
	 * @param	string		$message		The message to log.
	 * @return	void
	 */
	private function _log($message = '')
	{
		//echo (is_array($message) ? print_r($message, TRUE) : $message) .'<br>';
	}
	
	
	/**
	 * Outputs an AJAX response with the correct headers.
	 *
	 * @access	private
	 * @param 	string		$body		The body of the AJAX response.
	 * @return	void
	 */
	private function _output_ajax_response($body = '')
	{
		global $PREFS;
		
		if ($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1' OR $_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.0')
		{
			header($_SERVER['SERVER_PROTOCOL'] .' 200 OK', TRUE, 200);
		}
		else
		{
			header('HTTP/1.1 200 OK', TRUE, 200);
		}
		
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Last-Modified: ' .gmdate('D, d M Y H:i:s') .' GMT');
		header('Pragma: no-cache');
		header('Cache-Control: no-cache, must-revalidate');
		header('Content-Type: text/html; charset=' .$PREFS->ini('charset'));
		
		exit($body);
	}
	
	
	/**
	 * Loads a view file and returns the results.
	 *
	 * @see		$DSP->view() method in cp.display.php
	 * @access	private
	 * @param 	string 		$view_file		The view file to load.
	 * @param 	array 		$view_data 		Array of variables to be made available to the view.
	 * @return 	string
	 */
	private function _load_view($view_file = '', $view_data = array())
	{
		global $DSP, $LANG;
		
		if ( ! $view_file)
		{
			return '';
		}
		
		// Determine whether we've been passed the view name, or the full filename.
		$view_file = pathinfo($view_file, PATHINFO_EXTENSION) ? $view_file : $view_file .EXT;
		
		$view_file_path = $this->_themes_path .'views/' .$view_file;
		
		// Does the view file exist?
		if ( ! file_exists($view_file_path))
		{
			return '';
		}
		
		// Make the view data variables available.
		$LANG->fetch_language_file($this->_lower_class_name);
		$view_data = array_merge(array('lang' => $LANG), $view_data);
		
		extract($view_data);
		
		// Load the view.
		ob_start();
		
		/**
		 * Be nice to those poor souls whose PHP installation does not
		 * support short tags.
		 */
		
		if ((bool) @ini_get('short_open_tag') === FALSE)
		{
			echo eval('?>' .preg_replace("/;*\s*\?>/", "; ?>", str_replace('<?=', '<?php echo ', file_get_contents($view_file_path))));
		}
		else
		{
			include($view_file_path);
		}

		$buffer = ob_get_contents();
		ob_end_clean();
		return $buffer;
	}
	
	
	/**
	 * Adds the extension hooks to the database. Doesn't do anything clever,
	 * deletes any existing extension hooks before adding the new ones. Accepts
	 * 'settings' and 'enabled' for use in upgrades.
	 *
	 * @access	private
	 * @param	array		$settings		The extension settings.
	 * @param	string		$enabled		Is the extension enabled by default?
	 * @return	void
	 */
	private function _register_hooks($settings = array(), $enabled = 'y')
	{
		global $DB;
		
		// Delete all the existing extension hooks.
		$DB->query("DELETE FROM exp_extensions WHERE class = '{$this->_class_name}'");
		
		// Create the required extension hooks.
		$settings 	= is_array($settings) ? addslashes(serialize($settings)) : '';
		$enabled	= in_array($enabled, array('y', 'n')) ? $enabled : 'y';
		$sql 		= array();
		
		$hooks = array(
			array(
				'hook'		=> 'cp_members_member_create',
				'method'	=> 'cp_members_member_create',
				'priority'	=> 10
			),
			array(
				'hook'		=> 'cp_members_validate_members',
				'method'	=> 'cp_members_validate_members',
				'priority'	=> 10
			),
			array(
				'hook'		=> 'member_member_register',
				'method'	=> 'member_member_register',
				'priority'	=> 10
			),
			array(
				'hook'		=> 'member_register_validate_members',
				'method'	=> 'member_register_validate_members',
				'priority'	=> 10
			),
			array(
				'hook'		=> 'show_full_control_panel_start',
				'method'	=> 'show_full_control_panel_start',
				'priority'	=> 10
			),
			array(
				'hook'		=> 'user_edit_end',
				'method'	=> 'user_edit_end',
				'priority'	=> 10
			),
			array(
				'hook'		=> 'user_register_end',
				'method'	=> 'user_register_end',
				'priority'	=> 10
			)
		);
		
		foreach ($hooks AS $hook)
		{
			$sql[] = $DB->insert_string(
				'exp_extensions',
				array(
					'class'			=> $this->_class_name,
					'enabled'		=> $enabled,
					'extension_id'	=> '',
					'hook'			=> $hook['hook'],
					'method'		=> $hook['method'],
					'priority'		=> $hook['priority'],
					'settings'		=> $settings,
					'version'		=> $this->version
				));
		}
		
		// Run the queries.
		foreach ($sql AS $query)
		{
			$DB->query($query);
		}
	}
	
	
	/**
	 * Loads clients for the current account from Campaign Monitor.
	 *
	 * @access	private
	 * @return	bool
	 */
	private function _load_clients_from_api()
	{
		global $LANG;
		
		if ( ! $this->settings['api_key'])
		{
			return FALSE;
		}
		
		$cm = new CampaignMonitor($this->settings['api_key']);
		$cm_clients = $cm->userGetClients();
		
		// Reset the 'all clients' and 'error messages' arrays.
		$this->_all_clients = array();
		$this->_errors 		= array();
		
		// Parse the results.
		if ( ! isset($cm_clients['anyType']))
		{
			$this->_errors[] = array(
				'error_id'		=> '0',
				'error_message'	=> $LANG->line('unknown_error')
			);
			
			return FALSE;
		}
		
		if (isset($cm_clients['anyType']['Code']))
		{
			$this->_errors[] = array(
				'error_id'		=> $cm_clients['anyType']['Code'],
				'error_message'	=> $LANG->line('error_preamble') .$cm_clients['anyType']['Message']
			);
			
			return FALSE;
		}
		
		/**
		 * TRICKY:
		 * The CM API does something very irritating. If only one client exists, the structure
		 * of the returned data changes, meaning we can't happily use the same code.
		 *
		 * Instead, we need to check for the existence of a ClientID in the Client array (as opposed
		 * to in one of the clients _within_ the Client array), and modify our behaviour accordingly.
		 */
		
		$clients = isset($cm_clients['anyType']['Client']['ClientID'])
			? array('Client' => $cm_clients['anyType']['Client'])
			: $cm_clients['anyType']['Client'];
			
		foreach ($clients AS $client)
		{
			$this->_all_clients[] = array(
				'client_id'		=> $client['ClientID'],
				'client_name'	=> $client['Name']
			);
		}
		
		return TRUE;
	}
	
	
	/**
	 * Parses the supplied mailing list fields.
	 *
	 * @access	private
	 * @param	array 	$cm_fields		The fields returned from the Campaign Monitor API.
	 * @param	string	$list_id		The mailing list ID.
	 * @return	array|bool
	 */
	private function _parse_mailing_list_fields($cm_fields = array(), $list_id = '')
	{
		global $LANG;
		
		$return = array();
		
		if (is_array($cm_fields) && count($cm_fields) == 0)
		{
			return $return;
		}
		
		if (isset($cm_fields['anyType']['Code']))
		{
			$this->_errors[] = array(
				'error_id'		=> $cm_fields['anyType']['Code'],
				'error_message'	=> $LANG->line('error_preamble') .$cm_fields['anyType']['Message']
			);
			
			return FALSE;
		}
		
		/**
		 * Tricky:
		 * See _load_clients_from_api for details.
		 */
		
		$fields = isset($cm_fields['anyType']['ListCustomField']['FieldName'])
			? array('ListCustomField' => $cm_fields['anyType']['ListCustomField'])
			: $cm_fields['anyType']['ListCustomField'];
			
		foreach ($fields AS $field)
		{
			$return[] = array(
				'field_id'		=> trim($field['Key'], '[]'),
				'field_name'	=> $field['FieldName'],
				'field_type'	=> $field['DataType'],
				'safe_field_id'	=> $this->_sanitize_string(trim($field['Key'], '[]'))
			);
		}
		
		return $return;
	}
	
	
	/**
	 * Loads mailing lists for the current client from Campaign Monitor.
	 *
	 * @access	private
	 * @return	bool
	 */
	private function _load_mailing_lists_from_api()
	{
		global $LANG;
		
		if ( ! $this->settings['api_key'] OR ! $this->settings['client_id'])
		{
			return FALSE;
		}
		
		$cm = new CampaignMonitor($this->settings['api_key']);
		$cm_lists = $cm->clientGetLists($this->settings['client_id']);
		
		// Reset the 'all mailing lists' and 'error messages' arrays.
		$this->_all_mailing_lists	= array();
		$this->_errors				= array();
		
		// Parse the results.
		if ( ! isset($cm_lists['anyType']))
		{
			$this->_errors[] = array(
				'error_id'		=> '0',
				'error_message'	=> $LANG->line('unknown_error')
			);
			
			return FALSE;
		}
		
		if (isset($cm_lists['anyType']['Code']))
		{
			$this->_errors[] = array(
				'error_id'		=> $cm_lists['anyType']['Code'],
				'error_message'	=> $LANG->line('error_preamble') .$cm_lists['anyType']['Message']
			);
			
			return FALSE;
		}
		
		/**
		 * Tricky:
		 * See _load_clients_from_api for details.
		 */
		
		$lists = isset($cm_lists['anyType']['List']['ListID'])
			? array('List' => $cm_lists['anyType']['List'])
			: $cm_lists['anyType']['List'];
			
		foreach ($lists AS $list)
		{
			// Retrieve the custom fields for this list.
			$cm_fields = $cm->listGetCustomFields($list['ListID']);
			
			// Parse the custom fields.
			if (($list_fields = $this->_parse_mailing_list_fields($cm_fields, $list['ListID'])) === FALSE)
			{
				continue;
			}
			
			$this->_all_mailing_lists[] = array(
				'custom_fields'	=> $list_fields,
				'list_id'		=> $list['ListID'],
				'list_name'		=> $list['Name']
			);
		}
		
		return TRUE;
	}
	
	
	/**
	 * Sanitises a string so that it doesn't trigger EE's "Disallowed characters" error.
	 *
	 * @access	private
	 * @param	string		$source		The string to sanitise.
	 * @return	string
	 */
	private function _sanitize_string($source = '')
	{
		return strtr(base64_encode(addslashes(gzcompress(serialize($source), 9))), '+=', '-_');
	}
	
	
	/**
	 * "De-sanitises" a string that was previously sanitised using the _sanitize_string method.
	 *
	 * @access	private
	 * @param	string		$encoded	The string to de-sanitise.
	 * @return	string
	 */
	private function _desanitize_string($encoded = '')
	{
		return unserialize(gzuncompress(stripslashes(base64_decode(strtr($encoded, '-_', '+=')))));
	}
	
	
	/**
	 * Updates the settings array with any relevant GET or POST data.
	 *
	 * @access	private
	 * @return	void
	 */
	private function _update_settings_from_input()
	{
		global $IN;
		
		/**
		 * Update the 'simple' settings with any POST data. Anything that is
		 * a string can be automatically parsed. The mailing lists require a
		 * bit more work.
		 */
		
		foreach ($this->settings AS $key => $val)
		{
			if (is_string($val) && $IN->GBL($key) !== FALSE)
			{
				$this->settings[$key] = $IN->GBL($key);
			}
		}
		
		if (is_array($mailing_lists = $IN->GBL('mailing_lists')))
		{
			$this->settings['mailing_lists'] = array();
			
			foreach ($mailing_lists AS $list_id => $list_settings)
			{
				if ( ! isset($list_settings['checked']))
				{
					continue;
				}
				
				$new_list = array(
					'list_id'		=> $list_id,
					'trigger_field'	=> $list_settings['trigger_field'],
					'trigger_value'	=> $list_settings['trigger_value'],
					'custom_fields'	=> array()
				);
				
				// Custom fields.
				if (isset($list_settings['custom_fields']) && is_array($list_settings['custom_fields']))
				{
					foreach ($list_settings['custom_fields'] AS $cm_field_id => $member_field_id)
					{
						$cm_field_id = $this->_desanitize_string($cm_field_id);
						
						$new_list['custom_fields'][$cm_field_id] = array(
							'cm_field_id'		=> $cm_field_id,
							'member_field_id'	=> $member_field_id
						);
					}
				}
				
				$this->settings['mailing_lists'][$list_id] = $new_list;
			}
		}
	}
	
	
	/**
	 * Subscribes a member to the Campaign Monitor mailing list(s).
	 *
	 * @param 	string 		$member_id					The member ID.
	 * @param 	bool		$force_subscribe			Forcibly subscribe the member, even if he has previously unsubscribed from the list?
	 * @param	bool		$include_unsubscribe		Unsubscribe members where required?
	 * @return 	bool
	 */	
	private function _subscribe($member_id, $force_subscribe = FALSE, $include_unsubscribe = FALSE)
	{
		global $DB;
		
		// Force the class initialisation.
		$this->_initialize('', TRUE);
		
		// Check we have the required information.
		if ( ! $this->settings['api_key']
			OR ! $this->settings['client_id']
			OR ! $this->settings['mailing_lists']
			OR ! is_array($this->settings['mailing_lists']))
		{
			return FALSE;
		}
		
		// Retrieve the lists.
		$mailing_lists 	= $this->settings['mailing_lists'];
		$subscribe 		= array();
		$unsubscribe	= array();
		
		// Retrieve all the information for this member.
		$db_member_data = $DB->query("SELECT m.*, d.*
			FROM exp_members AS m
			INNER JOIN exp_member_data AS d
			ON d.member_id = m.member_id
			WHERE m.member_id = '{$member_id}'
			LIMIT 1");
		
		// We're not interested in 'Banned' or 'Pending' members.
		if ($db_member_data->num_rows != 1
			OR in_array($db_member_data->row['group_id'], array('2', '4')))
		{
			return FALSE;
		}
		
		// Loop through the mailing lists.
		foreach ($mailing_lists AS $list)
		{
			/**
			 * Is there a "trigger field" for this mailing list?
			 * If so, we need to check that the member has opted-in,
			 * otherwise we can just add the list to our "to process" array.
			 */
			
			if ( ! $list['trigger_field'])
			{
				$subscribe[] = $list;
			}
			else
			{
				if (isset($db_member_data->row[$list['trigger_field']])
					&& $db_member_data->row[$list['trigger_field']] === $list['trigger_value'])
				{
					$subscribe[] = $list;
				}
				else
				{
					$unsubscribe[] = $list;
				}
			}
		}

		// Are there any mailing lists to process?
		if (count($subscribe) == 0 && count($unsubscribe) == 0)
		{
			return TRUE;
		}
		
		// Instantiate the CM helper class.
		$cm = new CampaignMonitor($this->settings['api_key'], $this->settings['client_id']);
		
		// Subscribe.
		foreach ($subscribe AS $list)
		{
			// Generate an array of custom fields.
			$custom_fields = array();
			
			if (array_key_exists('custom_fields', $list))
			{
				foreach ($list['custom_fields'] AS $id => $val)
				{
					if (array_key_exists('cm_field_id', $val)
						&& array_key_exists('member_field_id', $val)
						&& isset($db_member_data->row[$val['member_field_id']]))
					{
						$custom_fields[$val['cm_field_id']] = utf8_decode($db_member_data->row[$val['member_field_id']]);
					}
				}
			}
			
			// Make the API call.
			$api_method = $force_subscribe === TRUE
				? 'subscriberAddAndResubscribeWithCustomFields'
				: 'subscriberAddWithCustomFields';
				
			$api_result = $cm->$api_method(
        		$db_member_data->row['email'],
        		utf8_decode($db_member_data->row['screen_name']),
        		$custom_fields,
        		$list['list_id']
      		);
      
      		// Check for an error code.
			$this->_check_for_api_error($api_method, $api_result, $db_member_data->row, $list);
		}
		
		// Unsubscribe.
		if ($include_unsubscribe)
		{
			foreach ($unsubscribe AS $list)
			{
				/**
				 * We need to check that the member is subscribed to the mailing list before attempting
				 * to unsubscribe him, otherwise Campaign Monitor reports an API error.
				 */
				
				$is_subscribed_api_result = $cm->subscribersGetIsSubscribed($db_member_data->row['email'], $list['list_id']);

				if ((is_string($is_subscribed_api_result) && strtolower($is_subscribed_api_result) == 'true')
					OR (is_array($is_subscribed_api_result) && array_key_exists('anyType', $is_subscribed_api_result) && strtolower($is_subscribed_api_result['anyType']) == 'true'))
				{
					// The member is subscribed. Unsubscribe him.
					$unsubscribe_api_result = $cm->subscriberUnsubscribe($db_member_data->row['email'], $list['list_id']);
					$this->_check_for_api_error('subscriberUnsubscribe', $unsubscribe_api_result, $db_member_data->row, $list);
				}
			}
		}
		
		return TRUE;
	}
	
	
	/**
	 * Builds the custom page headers part of the UI.
	 *
	 * @access	private
	 * @return 	string
	 */
	private function _build_ui_headers()
	{
		$output = '<link rel="stylesheet" type="text/css" media="screen,projection" href="' .$this->_themes_url .'css/admin.css" />';
		return $output;
	}
	
	
	/**
	 * Builds the breadcrumbs part of the UI.
	 *
	 * @access	private
	 * @return 	string
	 */
	private function _build_ui_breadcrumbs()
	{
		global $DSP, $LANG;
		
		$output = '';
		
		$output .= $DSP->anchor(BASE .AMP .'C=admin' .AMP. 'area=utilities', $LANG->line('utilities'));
		$output .= $DSP->crumb_item(
			$DSP->anchor(BASE .AMP .'C=admin' .AMP .'M=utilities' .AMP .'P=extensions_manager', $LANG->line('extensions_manager'))
		);
			
		$output .= $DSP->crumb_item($LANG->line('extension_name'));
		
		return $output;
	}
	
	
	/**
	 * Builds the 'clients' UI.
	 *
	 * @access	private
	 * @return	string
	 */
	private function _build_ui_clients()
	{
		$this->_load_clients_from_api();
		
		$view_vars = array(
			'all_clients'	=> $this->_all_clients,
			'errors'		=> $this->_errors,
			'settings'		=> $this->settings
		);
		
		return $this->_load_view('_clients', $view_vars);
	}
	
	
	/**
	 * Builds the "Mailing Lists" part of the UI.
	 *
	 * @access	private
	 * @return 	string
	 */
	private function _build_ui_lists()
	{
		$this->_load_mailing_lists_from_api();
		
		$view_vars = array(
			'all_mailing_lists' => $this->_all_mailing_lists,
			'errors'			=> $this->_errors,
			'member_fields'		=> $this->_member_fields,
			'settings'			=> $this->settings
		);
		
		return $this->_load_view('_lists', $view_vars);
	}
	
}

/* End of file 		: ext.campaigner.php */
/* File location	: /system/extensions/ext.campaigner.php */
