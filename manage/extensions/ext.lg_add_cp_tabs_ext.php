<?php
/**
* Class file for LG Add CP Tabs
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package LgAddCPTabs
* @version 1.1.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-cp-tabs/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/

if ( ! defined('EXT')) exit('Invalid file request');

if ( ! defined('LG_ACPT_version')){
	define("LG_ACPT_version",			"1.1.0");
	define("LG_ACPT_docs_url",			"http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-cp-tabs/");
	define("LG_ACPT_addon_id",			"LG Add CP Tabs");
	define("LG_ACPT_extension_class",	"Lg_add_cp_tabs_ext");
	define("LG_ACPT_cache_name",		"lg_cache");
}

/**
* This extension allows you to remove the default fields in the create new member form of the ExpressionEngine control panel
*
* @package LgAddCPTabs
* @version 1.1.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-cp-tabs/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/
class Lg_add_cp_tabs_ext {

	/**
	* Extension settings
	* @var array
	*/
	var $settings			= array();

	/**
	* Extension name
	* @var string
	*/
	var $name				= 'LG Add CP Tabs';

	/**
	* Extension version
	* @var string
	*/
	var $version			= LG_ACPT_version;

	/**
	* Extension description
	* @var string
	*/
	var $description		= 'Automatically add CP Tabs for new members';

	/**
	* If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	* @var string
	*/
	var $settings_exist		= 'y';

	/**
	* Link to extension documentation
	* @var string
	*/
	var $docs_url			= LG_ACPT_docs_url;



	/**
	* PHP4 Constructor
	*
	* @see __construct
	* @since version 1.0.0
	*/
	function Lg_add_cp_tabs_ext($settings='')
	{
		$this->__construct($settings);
	}



	/**
	* PHP 5 Constructor
	*
	* @param	array|string $settings Extension settings associative array or an empty string
	* @since version 1.0.0
	*/
	function __construct($settings='')
	{
		global $IN, $SESS;

		if(isset($SESS->cache['lg']) === FALSE){ $SESS->cache['lg'] = array();}

		$this->settings = $this->_get_settings();
		$this->debug = $IN->GBL('debug');
	}



	/**
	* Updates the new member with the default tabs
	*
	* @see http://expressionengine.com/developers/extension_hooks/cp_members_member_create/
	* @since version 1.0.0
	* @param $member_id		integer		The Member ID of the newly created member
	* @param $data			array		Array of data for new member like username, screen_name, and email
	*/
	function cp_members_member_create($member_id, $data)
	{
		global $DB;
		$settings = $this->_get_settings();
		$DB->query($DB->update_string('exp_members',
											array(
												'quick_tabs' => $settings['tabs_' . $data['group_id']],
												'quick_links' => $settings['links_' . $data['group_id']]
											),
											"member_id = {$member_id}")
					);
	}



	/**
	* Get the site specific settings from the extensions table
	*
	* @param $force_refresh		bool	Get the settings from the DB even if they are in the $SESS global
	* @param $return_all		bool	Return the full array of settings for the installation rather than just this site
	* @return array 					If settings are found otherwise false. Site settings are returned by default. Installation settings can be returned is $return_all is set to true
	* @since version 1.0.0
	*/
	function _get_settings($force_refresh = FALSE, $return_all = FALSE)
	{

		global $SESS, $DB, $REGX, $LANG, $PREFS;

		// assume there are no settings
		$settings = FALSE;
		
		// Get the settings for the extension
		if(isset($SESS->cache['lg'][LG_ACPT_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . LG_ACPT_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache['lg'][LG_ACPT_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}
		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache['lg'][LG_ACPT_addon_id]['settings']) !== TRUE)
		{
			$settings = ($return_all === TRUE) ?  $SESS->cache['lg'][LG_ACPT_addon_id]['settings'] : $SESS->cache['lg'][LG_ACPT_addon_id]['settings'][$PREFS->ini('site_id')];
		}

		return $settings;
	}



	/**
	* Configuration for the extension settings page
	* 
	* @param $current	array 		The current settings for this extension. We don't worry about those because we get the site specific settings
	* @since version 1.0.0
	**/
	function settings_form($current)
	{
		global $DB, $DSP, $LANG, $IN, $PREFS, $SESS;

		// create a local variable for the site settings
		$settings = $this->_get_settings();

		$DSP->crumbline = TRUE;

		$DSP->title  = $LANG->line('extension_settings');
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));

		$DSP->crumb .= $DSP->crumb_item($LANG->line('lg_add_cp_tabs_title') . " {$this->version}");

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		$DSP->body = '';

		if(isset($settings['show_promos']) === FALSE) {$settings['show_promos'] = 'y';}
		if($settings['show_promos'] == 'y')
		{
			$DSP->body .= "<script src='http://leevigraham.com/promos/ee.php?id=" . rawurlencode(LG_ACPT_addon_id) ."&v=".$this->version."' type='text/javascript' charset='utf-8'></script>";
		}

		if(isset($settings['show_donate']) === FALSE) {$settings['show_donate'] = 'y';}
		if($settings['show_donate'] == 'y')
		{
			$DSP->body .= "<style type='text/css' media='screen'>
				#donate{float:right; margin-top:0; padding-left:190px; position:relative; top:-2px}
				#donate .button{background:transparent url(http://leevigraham.com/themes/site_themes/default/img/btn_paypal-donation.png) no-repeat scroll left bottom; display:block; height:0; overflow:hidden; position:absolute; top:0; left:0; padding-top:27px; text-decoration:none; width:175px}
				#donate .button:hover{background-position:top right;}
			</style>";
			$DSP->body .= "<p id='donate'>
							" . $LANG->line('donation') ."
							<a rel='external' href='https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=sales%40leevigraham%2ecom&amp;item_name=LG%20Expression%20Engine%20Development&amp;amount=%2e00&amp;no_shipping=1&amp;return=http%3a%2f%2fleevigraham%2ecom%2fdonate%2fthanks&amp;cancel_return=http%3a%2f%2fleevigraham%2ecom%2fdonate%2fno%2dthanks&amp;no_note=1&amp;tax=0&amp;currency_code=USD&amp;lc=US&amp;bn=PP%2dDonationsBF&amp;charset=UTF%2d8' class='button' target='_blank'>Donate</a>
						</p>";
		}

		$DSP->body .= $DSP->heading($LANG->line('lg_add_cp_tabs_title') . " <small>{$this->version}</small>");

		$DSP->body .= $DSP->form_open(
								array(
									'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings'
								),
								// WHAT A M*THERF!@KING B!TCH THIS WAS
								// REMEMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
								// BUG??
								array('name' => strtolower(LG_ACPT_extension_class))
		);
	
		// EXTENSION ACCESS
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $LANG->line("access_rights")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableCellOne', '30%')
			. $DSP->qdiv('defaultBold', $LANG->line('enable_extension_for_this_site'))
			. $DSP->td_c();

		$DSP->body .= $DSP->td('tableCellOne')
			. "<select name='enable'>"
						. $DSP->input_select_option('y', "Yes", (($settings['enable'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['enable'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->table_c();

		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $LANG->line("member_groups_default_tabs")
			. $DSP->td_c()
			. $DSP->tr_c();


		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '2')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . $LANG->line('member_groups_tab_info'). "</div>"
			. $DSP->td_c()
			. $DSP->tr_c();

		// query the db for the member groups
		$query = $DB->query("SELECT group_id, group_title FROM exp_member_groups WHERE site_id = " . $PREFS->core_ini['site_id'] . " ORDER BY group_id");

		$count = 1;
		foreach($query->result as $row)
		{
			$row_class = ($count % 2) ? 'One' : 'Two';
			++$count;
			$DSP->body .= $DSP->tr()
				. $DSP->td('tableCell' . $row_class, '30%')
				. $DSP->qdiv('defaultBold', $row['group_title'])
				. $DSP->td_c();

			$DSP->body .= $DSP->td('tableCell' . $row_class)
				. $DSP->input_textarea('tabs_'.$row['group_id'].'', (isset($this->settings['tabs_' . $row['group_id']]) === FALSE) ? '' : $this->settings['tabs_' . $row['group_id']], '3')
				. $DSP->td_c()
				. $DSP->tr_c();
		}

		$DSP->body .= $DSP->td_c()
			. $DSP->tr_c();
		$DSP->body .= $DSP->table_c();


		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $LANG->line("member_groups_default_links")
			. $DSP->td_c()
			. $DSP->tr_c();


		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '2')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . $LANG->line('member_groups_link_info'). "</div>"
			. $DSP->td_c()
			. $DSP->tr_c();

		$count = 1;
		foreach($query->result as $row)
		{
			$row_class = ($count % 2) ? 'One' : 'Two';
			++$count;
			$DSP->body .= $DSP->tr()
				. $DSP->td('tableCell' . $row_class, '30%')
				. $DSP->qdiv('defaultBold', $row['group_title'])
				. $DSP->td_c();

			$DSP->body .= $DSP->td('tableCell' . $row_class)
				. $DSP->input_textarea('links_'.$row['group_id'].'', (isset($this->settings['links_' . $row['group_id']]) === FALSE) ? '' : $this->settings['links_' . $row['group_id']], '3')
				. $DSP->td_c()
				. $DSP->tr_c();
		}

		$DSP->body .= $DSP->td_c()
			. $DSP->tr_c();
		$DSP->body .= $DSP->table_c();


		// UPDATE SETTINGS
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $LANG->line("check_for_updates_title")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '2')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('check_for_updates_info'). "</p><p class='highlight'>" . $LANG->line('check_for_updates_warning'). "</p></div>"
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableCellOne', '30%')
			. $DSP->qdiv('defaultBold', $LANG->line("check_for_updates_label"))
			. $DSP->td_c();

		$DSP->body .= $DSP->td('tableCellOne')
			. "<select name='check_for_updates'>"
					. $DSP->input_select_option('y', "Yes", (($settings['check_for_updates'] == 'y') ? 'y' : '' ))
					. $DSP->input_select_option('n', "No", (($settings['check_for_updates'] == 'n') ? 'y' : '' ))
					. $DSP->input_select_footer()
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->table_c();

		if($IN->GBL('lg_admin') != 'y')
		{
			$DSP->body .= $DSP->table_c();
			$DSP->body .= "<input type='hidden' value='".$settings['show_donate']."' name='show_donate' />";
			$DSP->body .= "<input type='hidden' value='".$settings['show_promos']."' name='show_promos' />";
		}
		else
		{
			$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));
			$DSP->body .= $DSP->tr()
				. $DSP->td('tableHeading', '', '2')
				. $LANG->line("lg_admin_title")
				. $DSP->td_c()
				. $DSP->tr_c();

			$DSP->body .= $DSP->tr()
				. $DSP->td('tableCellOne', '30%')
				. $DSP->qdiv('defaultBold', $LANG->line("show_donate_label"))
				. $DSP->td_c();

			$DSP->body .= $DSP->td('tableCellOne')
				. "<select name='show_donate'>"
						. $DSP->input_select_option('y', "Yes", (($settings['show_donate'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['show_donate'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
				. $DSP->td_c()
				. $DSP->tr_c();

			$DSP->body .= $DSP->tr()
				. $DSP->td('tableCellTwo', '30%')
				. $DSP->qdiv('defaultBold', $LANG->line("show_promos_label"))
				. $DSP->td_c();

			$DSP->body .= $DSP->td('tableCellTwo')
				. "<select name='show_promos'>"
						. $DSP->input_select_option('y', "Yes", (($settings['show_promos'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($settings['show_promos'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
				. $DSP->td_c()
				. $DSP->tr_c();

			$DSP->body .= $DSP->table_c();
		}		

		$DSP->body .= $DSP->qdiv('itemWrapperTop', $DSP->input_submit())
					. $DSP->form_c();
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
		$settings = $this->_get_settings(TRUE, TRUE);

		// add the posted values to the settings
		$settings[$PREFS->ini('site_id')] = $_POST;

		// update the settings
		$query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . LG_ACPT_extension_class . "'");
	}



	/**
	* Activates the extension
	* 
	* @return	bool Always TRUE
	* @since version 1.0.0
	*/
	function activate_extension ()
	{
		global $DB, $LANG, $PREFS;
		
		$default_settings = array(
			'enable' 				=> 'y',
			'check_for_updates' 	=> 'y',
			'show_donate'			=> 'y',
			'show_promos'			=> 'y'
		);

		// grab the members but not the banned and pending group
		$members = $DB->query("SELECT
			group_id,
			group_title
		FROM
			exp_member_groups
		WHERE
			site_id = {$PREFS->core_ini['site_id']} 
		AND group_id <> 2
		AND group_id <> 4
		ORDER BY group_id");

		foreach ($members->result as $member_group)
		{
			$default_settings['tabs_' . $member_group['group_id']] = '';
			$default_settings['links_' . $member_group['group_id']] = 'My Site|' . $PREFS->ini('site_url') . '|1';
		}

		// Give all super admins pages and extensions
		$default_settings['tabs_1'] = 	'Pages|C=modules&M=Pages|1' . NL .
										'Extensions|C=admin&M=utilities&P=extensions_manager|2';

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
			'cp_members_member_create'			=> 'cp_members_member_create',
			'lg_addon_update_register_source'	=> 'lg_addon_update_register_source',
			'lg_addon_update_register_addon'	=> 'lg_addon_update_register_addon'
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
	* @since version 1.0.0
	*/
	function update_extension($current = '')
	{
		global $DB;

		if ($current == '' OR $current == $this->version)
			return FALSE;

		$settings = $this->_get_settings(TRUE, TRUE);

		// Integrated LG Addon Updater
		// Removed control_panel_homepage hook
		// Added lg_addon_update_register_source hook + method
		// Added lg_addon_update_register_addon hook + method
		if($current < '1.1.0')
		{
			$sql[] = "DELETE FROM `exp_extensions` WHERE `class` = '".get_class($this)."' AND `hook` = 'control_panel_home_page'";
			$hooks = array(
				'lg_addon_update_register_source'	=> 'lg_addon_update_register_source',
				'lg_addon_update_register_addon'	=> 'lg_addon_update_register_addon'
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
		}

		$sql[] = "UPDATE exp_extensions SET version = '" . $DB->escape_str($this->version) . "' WHERE class = '" . get_class($this) . "'";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
		return TRUE;
	}



	/**
	* Disables the extension the extension and deletes settings from DB
	* 
	* @since version 1.0.0
	*/
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM `exp_extensions` WHERE class = '" . get_class($this) . "'");
	}


	/**
	* Register a new Addon Source
	*
	* @param array $sources The existing sources
	* @return array The new source list
	* @since version 1.1.0
	*/
	function lg_addon_update_register_source($sources)
	{
		global $EXT;
		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$sources = $EXT->last_call;

		// add a new source
		// must be in the following format:
		/*
		<versions>
			<addon id='LG Addon Updater' version='2.0.0' last_updated="1218852797" docs_url="http://leevigraham.com/" />
		</versions>
		*/
		if($this->settings['check_for_updates'] == 'y')
		{
			$sources[] = 'http://leevigraham.com/version-check/versions.xml';
		}

		return $sources;

	}


	/**
	* Register a new Addon
	*
	* @param array $addons The existing sources
	* @return array The new addon list
	* @since version 1.1.0
	*/
	function lg_addon_update_register_addon($addons)
	{
		global $EXT;
		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$addons = $EXT->last_call;

		// add a new addon
		// the key must match the id attribute in the source xml
		// the value must be the addons current version
		if($this->settings['check_for_updates'] == 'y')
		{
			$addons[LG_ACPT_addon_id] = $this->version;
		}

		return $addons;
	}



}

?>