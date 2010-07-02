<?php
/**
* Class file for LG Member Form Customiser
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package LgMFCustomiser
* @version 1.1.0
* @author Leevi Graham <http://leevigraham.com>
* @copyright 2007
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-member-form-customiser/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/

if ( ! defined('EXT')) exit('Invalid file request');

define("LG_MFC_version",			"1.1.0");
define("LG_MFC_docs_url",			"http://leevigraham.com/cms-customisation/expressionengine/addon/lg-member-form-customiser/");
define("LG_MFC_addon_id",			"LG Member Form Customiser");
define("LG_MFC_extension_class",	"Lg_mf_customiser");
define("LG_MFC_cache_name",			"lg_cache");

/**
* This extension allows you to remove the default fields in the create new member form of the ExpressionEngine control panel
*
* @package LgMFCustomiser
* @version 1.1.0
* @author Leevi Graham <http://leevigraham.com>
* @copyright 2008
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-member-form-customiser/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/
class Lg_mf_customiser {

	/**
	* Extension settings
	* @var array
	*/
	var $settings			= array();

	/**
	* Extension name
	* @var string
	*/
	var $name				= 'LG Member Form Customiser';

	/**
	* Extension version
	* @var string
	*/
	var $version			= LG_MFC_version;

	/**
	* Extension description
	* @var string
	*/
	var $description		= 'Allows you to remove the default fields in the create new member form of the ExpressionEngine control panel';

	/**
	* If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	* @var string
	*/
	var $settings_exist		= 'y';

	/**
	* Link to extension documentation
	* @var string
	*/
	var $docs_url			= LG_MFC_docs_url;



	/**
	* PHP4 Constructor
	*
	* @see __construct
	*/
	function Lg_mf_customiser($settings='')
	{
		$this->__construct($settings);
	}



	/**
	* PHP 5 Constructor
	*
	* @param	array|string $settings Extension settings associative array or an empty string
	*/
	function __construct($settings='')
	{
		global $IN, $SESS;

		if(isset($SESS->cache['lg']) === FALSE){ $SESS->cache['lg'] = array();}

		$this->settings = $this->get_settings();
		$this->debug = $IN->GBL('debug');
	}


	/**
	* Get the site specific settings from the extensions table
	*
	* @return array if settings are found otherwise false
	*/
	function get_settings($force_refresh = FALSE, $return_all = FALSE)
	{

		global $SESS, $DB, $REGX, $LANG, $PREFS;

		// assume there are no settings
		$settings = FALSE;
		
		// Get the settings for the extension
		if(isset($SESS->cache['lg'][LG_MFC_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . LG_MFC_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache[LG_MFC_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}
		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache[LG_MFC_addon_id]['settings']) !== TRUE)
		{
			$settings = ($return_all === TRUE) ?  $SESS->cache[LG_MFC_addon_id]['settings'] : $SESS->cache[LG_MFC_addon_id]['settings'][$PREFS->ini('site_id')];
		}

		return $settings;

	}



	/**
	* Configuration for the extension settings page
	**/
	function settings_form($current)
	{
		global $DB, $DSP, $LANG, $IN, $PREFS, $SESS;

		// create a local variable for the site settings
		$settings = $this->get_settings();

		$DSP->crumbline = TRUE;

		$DSP->title  = $LANG->line('extension_settings');
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));

		$DSP->crumb .= $DSP->crumb_item($LANG->line('lg_mfc_addon_name'));

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		$DSP->body = $DSP->heading($LANG->line('lg_mfc_addon_name'));
		
		$DSP->body .= $DSP->form_open(
								array(
									'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings'
								),
								// WHAT A M*THERF!@KING B!TCH THIS WAS
								// REMEMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
								// BUG??
								array('name' => strtolower(LG_MFC_extension_class))
		);
	
		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line('default_member_fields');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . $LANG->line('global_removal') . "</div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('display_birthday') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_select_header('display_birthday', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_birthday'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_birthday'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_url') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_select_header('display_url', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_url'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_url'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_location') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_select_header('display_location', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_location'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_location'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_occupation') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_select_header('display_occupation', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_occupation'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_occupation'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_interests') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_select_header('display_interests', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_interests'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_interests'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_aol') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_select_header('display_aol', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_aol'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_aol'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_icq') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_select_header('display_icq', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_icq'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_icq'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_yahoo') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_select_header('display_yahoo', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_yahoo'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_yahoo'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_msn') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_select_header('display_msn', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_msn'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_msn'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('display_bio') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_select_header('display_bio', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['display_bio'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['display_bio'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();



		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line('group_rules');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . $LANG->line('group_rules_instructions') . "</div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold',  $LANG->line('member_group_rules') );
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_textarea('group_rules', $settings['group_rules'], 4, '', '99%');
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   "Check for updates";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p> LG Member Form customiser can call home and check for recent updates if you allow it.</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		// check for updates
		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line("check_for_updates"));
		$DSP->body .=   $DSP->td_c();


		$DSP->body .=   $DSP->td('tableCellOne');
		$DSP->body .=   $DSP->input_select_header('check_for_updates', 0, 1)
						. $DSP->input_select_option('y', "Yes", (($settings['check_for_updates'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['check_for_updates'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer();
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();


		// cache refresh
		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellTwo', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line("cache_refresh"));
		$DSP->body .=   $DSP->td_c();

		$DSP->body .=   $DSP->td('tableCellTwo');
		$DSP->body .=   $DSP->input_text('cache_refresh', ( ! isset($settings['cache_refresh'])) ? '3200' : $settings['cache_refresh']);
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->table_c();

		$DSP->body .=   $DSP->table_c();


		$DSP->body .=   $DSP->qdiv('itemWrapperTop', $DSP->input_submit());
		$DSP->body .=   $DSP->form_c();
	}
	
	
	/**
	* Save Settings
	**/
	function save_settings()
	{
		// make somethings global
		global $DB, $IN, $PREFS, $REGX, $SESS;

		// unset the name
		unset($_POST['name']);
		
		// load the settings from cache or DB
		// force a refresh and return the full site settings
		$settings = $this->get_settings(TRUE, TRUE);

		// add the posted values to the settings
		$settings[$PREFS->ini('site_id')] = $_POST;

		// update the settings
		$query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . LG_MFC_extension_class . "'");
	}



	/**
	* Activates the extension
	* @return	bool Always TRUE
	*/
	function activate_extension ()
	{
		global $DB, $PREFS;

		$default_settings = array(
			'display_birthday'	=> 'y',
			'display_url'		=> 'y',
			'display_location'	=> 'y',
			'display_occupation'=> 'y',
			'display_interests'	=> 'y',
			'display_aol'		=> 'y',
			'display_icq'		=> 'y',
			'display_yahoo'		=> 'y',
			'display_msn'		=> 'y',
			'display_bio'		=> 'y',
			'group_rules'		=> '',
			'check_for_updates'	=> 'y',
			'cache_refresh'		=> 3200
		);

		// get the list of installed sites
		$query = $DB->query("SELECT * FROM exp_sites");

		// if there are sites - we know there will be at least one but do it anyway
		if ($query->num_rows > 0)
		{
			// for each of the sites
			foreach($query->result as $row)
			{
				// build a multi dimensional array for the settings
				$settings[$row['site_id']] = $default_settings;
			}
		}

		$hooks = array(
			'control_panel_home_page' 				=> 'control_panel_home_page',
			'show_full_control_panel_end' 			=> 'show_full_control_panel_end'
		);

		foreach ($hooks as $hook => $method)
		{
			$sql[] = $DB->insert_string( 'exp_extensions', 
											array('extension_id' 	=> '',
												'class'			=> get_class($this),
												'method'		=> $method,
												'hook'			=> $hook,
												'settings'		=> addslashes(serialize($settings)),
												'priority'		=> 10,
												'version'		=> $this->version,
												'enabled'		=> "y"
											)
										);
		}
		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
		return TRUE;
	}


	/**
	* Updates the extension
	*
	* @param	string $current If installed the current version of the extension otherwise an empty string
	* @return	bool FALSE if the extension is not installed or is the current version
	*/
	function update_extension($current = '')
	{
		global $DB;

		if ($current == '' OR $current == $this->version)
			return FALSE;

		$sql[] = "UPDATE exp_extensions SET version = '" . $DB->escape_str($this->version) . "' WHERE class = '" . get_class($this) . "'";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
	}



	/**
	* Disables the extension the extension and deletes settings from DB
	*/
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM `exp_extensions` WHERE class = '" . get_class($this) . "'");
	}



	/**
	* Takes the control panel home page and adds an update method if needed
	*
	* @param	string $out The control panel html
	* @return	string The modified control panel html
	* @since 	Version 1.0.1
	*/
	function control_panel_home_page($home)
	{
		global $EXT;

		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$home = $EXT->last_call;

		// check if updates for this extension are available
		if($updates = $this->_check_for_updates())
		{
			// add them to the message
			$home->messages = array_merge($home->messages, $updates);
		}
		// return home object
		return $home;
	}


	/**
	* Takes the control panel html
	*
	* @param	string $out The control panel html
	* @return	string The modified control panel html
	*/
	function show_full_control_panel_end( $out )
	{
		global $DB, $EXT, $IN, $PREFS;

		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$out = $EXT->last_call;

		if($this->debug === TRUE)
		{
			print("<pre>" + print_r($this->settings, TRUE) + "</pre>");
		}

		// if we are displaying the custom field list
		if($IN->GBL('M', 'GET') == 'edit_profile' && $IN->GBL('C', 'GET') == 'myaccount')
		{
			// get member group
			$query = $DB->query($sql = "SELECT group_id FROM `exp_members` WHERE member_id = " . $IN->GBL('id', 'GET') . " LIMIT 1");

			$group_id = $query->row['group_id'];

			$r = "<script type='text/javascript' charset='utf-8' src='http://ajax.googleapis.com/ajax/libs/jquery/1.2.6/jquery.min.js'> </script>";

			$r .="
			<script type='text/javascript' charset='utf-8'>
				$(document).ready(function() {
					table_rows = $('form table tbody tr');\n";
					if($this->settings['display_birthday'] == 'n'){ $r .= "$(table_rows[1]).hide();\n"; }
					if($this->settings['display_url'] == 'n'){ $r .= "$(table_rows[2]).hide();\n"; }
					if($this->settings['display_location'] == 'n'){ $r .= "$(table_rows[3]).hide();\n"; }
					if($this->settings['display_occupation'] == 'n'){ $r .= "$(table_rows[4]).hide();\n"; }
					if($this->settings['display_interests'] == 'n'){ $r .= "$(table_rows[5]).hide();\n"; }
					if($this->settings['display_aol'] == 'n'){ $r .= "$(table_rows[6]).hide();\n"; }
					if($this->settings['display_icq'] == 'n'){ $r .= "$(table_rows[7]).hide();\n"; }
					if($this->settings['display_yahoo'] == 'n'){ $r .= "$(table_rows[8]).hide();\n"; }
					if($this->settings['display_msn'] == 'n'){ $r .= "$(table_rows[9]).hide();\n"; }
					if($this->settings['display_bio'] == 'n'){ $r .= "$(table_rows[10]).hide();\n"; }

					/* 
						group rules come in the following format
						group_id:row_num|row_num|row_num
						group_id:row_num|row_num|row_nuw
					*/
					if(empty($this->settings['group_rules']) === FALSE)
					{
						$lines = explode("\n", $this->settings['group_rules']);

						foreach ($lines as $line)
						{
							$pieces = explode(":", $line);
						    $option = trim($pieces[0]);
							if($option == $group_id)
							{
							    $rows = explode('|', trim($pieces[1]));
								foreach ($rows as $row)
								{
									if($row != 0)
									{
										$r .= "$(table_rows[{$row}]).hide();\n";
									}
								}
								continue;
							}
						}
					}

					// if we are debugging show the row number
					if($this->debug !== FALSE){
						$r .= '$("form table tbody tr > td:first-child .defaultBold").each(function(index) { console.log("#" + (index + 1) + " " + $(this).text()); });';
					}

			$r .= "
				count = 0;
				$('form table tbody tr:visible td[class!=tableHeading]').each(function(index) {
					if(count == 0 || count == 1){
						$(this).attr('class', 'tableCellOne');
					}
					else{
						$(this).attr('class', 'tableCellTwo');
					}
					if(count == 3){
						count = 0;
					}
					else{
						count++;
					}
				});
			});
			</script>
			";
			// add the script string before the closing head tag
			$out = str_replace("</head>", $r . "</head>", $out);
		}
		return $out;
	}



	/**
	* Checks leevigraham.com for updates
	*
	* @return	mixed array|bool Array if updates exist FALSE if no updates are available
	*/
	function _check_for_updates()
	{

		global $IN, $LANG, $SESS;

		$page_url 		= "http://leevigraham.com/version-check/versions.txt";
		$updates 		= FALSE;
		$versions 		= FALSE;
		$cache_expired 	= FALSE;
		
		$this->log[] = LG_MFC_addon_id . ' Checking $SESS';
		
		// check the $SESS for this version
		if(isset($SESS->cache['lg'][LG_MFC_addon_id]['latest_version']) === FALSE)
		{
			$this->log[] = LG_MFC_addon_id . ' Checking $SESS: FAIL';
			$this->log[] = LG_MFC_addon_id . ' Checking cache';
			// if there is nothing in the cache
			if(($versions = $this->_check_cache($page_url)) === FALSE)
			{
				// cache has expired
				$cache_expired = TRUE;

				$this->log[] = LG_MFC_addon_id . ' Checking cache: FAIL';
				$this->log[] = LG_MFC_addon_id . ' Checking Site';

				$temp = error_reporting(0);

				// try and open the webpage for reading
				if(($fp = fopen( $page_url, "r" )) !== FALSE)
				{
					// while not the end of the file
					// loop through every line
					while ( ($current_line = fgets($fp)) !== FALSE )
					{
						// get the file contents
						$versions = stream_get_contents($fp);
					}
					$this->log[] = LG_MFC_addon_id . ' Checking Site: SUCCESS';
				}
				else
				{
					$this->log[] = LG_MFC_addon_id . ' Checking Site: FAIL';
				}
				// turn back on error reporting
				error_reporting($temp);
			}
			else
			{
				$this->log[] = LG_MFC_addon_id . ' Checking cache: SUCCESS';
			}

			// if everything failed: $SESS, file cache and site
			if($versions === FALSE)
			{
				// send an error
				$updates[] = "<div class='alert'>Addon update check failed for " . LG_MFC_addon_id .".</div>";
				return $updates;
			}

			// explode the string at its eof
			$addons = explode("\n", $versions);

			// for each of the exploded parts
			foreach ($addons as $addon)
			{
				// explode the delimiter
				$tmp = explode(":", $addon);
				// set the cache
				$SESS->cache['lg'][trim($tmp[0])]['latest_version'] = trim($tmp[1]);
			}
		}
		else
		{
			$this->log[] = LG_MFC_addon_id . ' Checking $SESS: SUCCESS';
		}


		// YAY now we have the latest versions for all LG addons!

		// if the most recent version is larger than this version
		if ($SESS->cache['lg'][LG_MFC_addon_id]['latest_version'] > $this->version)
		{
			if(isset($SESS->cache['lg']['updates_available']) === FALSE)
			{
				$SESS->cache['lg']['updates_available'] = TRUE;
				$updates[] = "<div class='alert'>Module / extension / plugin updates available:</div>";
			}
			$updates[] = "<p><a href='" . LG_MFC_docs_url . "'>" . LG_MFC_addon_id . " v" . $SESS->cache['lg'][LG_MFC_addon_id]['latest_version'] . "</a></p>";
		}

		if ($cache_expired === TRUE)
		{
			$this->_write_cache($versions, $page_url);	
		}

		if($this->debug !== FALSE)
		{
			print("<pre>" . print_r($this->log, TRUE) . "</pre>");
		}

		return $updates;

	}



	/**
	* Check Cache
	*
	* Check for cached data
	*
	* @access	public
	* @param	string
	* @return	mixed - string if pulling from cache, FALSE if not
	*/
	function _check_cache($url)
	{	
		global $TMPL;

		// build the cache directory path
		$dir = PATH_CACHE.LG_MFC_cache_name.'/';

		// check for the cache directory
		if ( ! @is_dir($dir))
		{
			mkdir($dir);
			@chmod($dir, 0777);
			return FALSE;
		}

		// set the filename
	    $file = $dir.md5($url);

		// does the file doesn't exist or we can't open it
		if ( ! file_exists($file) OR ! ($fp = @fopen($file, 'rb')))
		{
			return FALSE;
		}

		// lock the file
		flock($fp, LOCK_SH);

		// read the contents
		$cache = @fread($fp, filesize($file));

		// unlock te file
		flock($fp, LOCK_UN);

		// close the file
		fclose($fp);

		// end of line
		$eol = strpos($cache, "\n");

		// get the timestamp
		$timestamp = substr($cache, 0, $eol);

		// get the cache
		$cache = trim((substr($cache, $eol)));

		// if the current time is greater than the timestamp plus the refresh amount
		if (time() > ($timestamp + ($this->settings['cache_refresh'] * 60)))
		{
			// return false
			return FALSE;
		}

	    return $cache;
	}



	/**
	* Write Cache
	*
	* Write the cached data
	*
	* @access	public
	* @param	string
	* @return	void
	*/
	function _write_cache($data, $url)
	{

		// check for cache
		$dir = PATH_CACHE.LG_MFC_cache_name.'/';

		if ( ! @is_dir($dir))
		{
			if ( ! @mkdir($dir, 0777))
			{
				return FALSE;
			}

			@chmod($dir, 0777);
		}

		// add a timestamp to the top of the file
		$data = time()."\n".$data;

		// create the file path
		$file = $dir.md5($url);

		// open the file if we can
		if ( ! $fp = @fopen($file, 'wb'))
		{
			return FALSE;
		}
		// lock, write, unlock, close
		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);
		// change the file perms
		@chmod($file, 0777);
	}
}

?>