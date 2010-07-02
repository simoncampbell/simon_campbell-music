<?php

/**
* Class File for LG Better Meta
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package LgBetterMeta
* @version Version 1.9.1
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement
*/

if ( ! defined('EXT')) exit('Invalid file request');

if ( ! defined('LG_BM_version')){
	define("LG_BM_version",			"1.9.1");
	define("LG_BM_docs_url",		"http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/");
	define("LG_BM_addon_id",		"LG Better Meta Commercial");
	define("LG_BM_extension_class",	"Lg_better_meta");
	define("LG_BM_cache_name",		"lg_cache");
}
/**
* Manages extension activation, deactivation and upgrading, links class 
* methods to ExpressionEngine hooks and implements the administration interface.
* 
* @package LgBetterMeta
* @version Version 1.9.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/
* @see http://expressionengine.com/developers/extension_hooks/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement
*/
class Lg_better_meta {
  
	/**
	 * Extension settings
	 * @var array
	 */
	var $settings			= array();

	/**
	 * Extension name
	 * @var string
	 */
	var $name				= 'LG Better Meta';

	/**
	 * Extension version
	 * @var string
	 */
	var $version			= LG_BM_version;

	/**
	 * Extension description
	 * @var string
	 */
	var $description		= 'Implements an interface to add meta data to ExpressionEngine weblog entries';

	/**
	 * If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	 * @var string
	 */
	var $settings_exist		= 'y';

	/**
	 * Link to extension documentation
	 * @var string
	 */
	var $docs_url			= 'http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/';

	/**
	 * Debug?
	 * @var string
	 */
	var $debug 				= FALSE;

	/**
	 * PHP4 Constructor
	 *
	 * @see __construct()
	 */
	function Lg_better_meta( $settings='' )
	{
		$this->__construct($settings);
	}

	/**
	 * PHP 5 Constructor
	 *
	 * @param	array|string $settings Extension settings associative array or an empty string
	 * @since	Version 1.4.0
	 */
	function __construct( $settings='' )
	{
		global $FNS, $IN, $SESS;

		// get the settings from our helper class
		// this returns all the sites settings
		$this->settings = $this->_get_settings();

		if(isset($SESS->cache['lg']) === FALSE) $SESS->cache['lg'] = array();
		if(isset($SESS->cache['Morphine']) === FALSE) $SESS->cache['Morphine'] = array();
		$this->debug = $IN->GBL('debug');
	}

	/**
	 * Configuration for the extension settings page
	 *
	 * @since	Version 1.5.0	
	 */
	function settings_form( $current )
	{
		global $DB, $DSP, $LANG, $IN, $PREFS, $REGX, $SESS;

		$DSP->title  = $this->name . " " . $this->version . " | " . $LANG->line('extension_settings');

		$DSP->crumbline = TRUE;
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
		$DSP->crumb .= $DSP->crumb_item($LANG->line('lg_better_meta_title') . " {$this->version}");

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		// meta title

		$DSP->body = '';
		$DSP->body .= "<div class='mor settings-form'>";

		$DSP->body .= $DSP->heading($LANG->line('lg_better_meta_title') . " <small>{$this->version}</small>");
		
		$DSP->body .= $DSP->form_open(
								array(
									'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings',
									'id'     => 'Lg_better_meta_settings'
								),
								// WHAT A M*THERF!@KING B!TCH THIS WAS
								// REMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
								// BUG??
								array('name' => strtolower(get_class($this)))
		);

		$settings = $this->_get_settings();
		$default_settings =  $this->_build_default_settings();
		$settings = $this->array_merge_recursive_flat($default_settings, $settings);

		if(isset($_POST["Lg_better_meta_ext"]))
		{
			$settings = $this->array_merge_recursive_flat($settings, $_POST['Lg_better_meta_ext']);
		}

		$addon_name = $this->name;
		$member_group_query = $DB->query("SELECT group_id, group_title FROM exp_member_groups WHERE site_id = ".$PREFS->ini('site_id')." ORDER BY group_title");
		$weblog_query = $DB->query("SELECT blog_name, blog_title, weblog_id FROM `exp_weblogs` WHERE `site_id` = ".$PREFS->ini('site_id')." ORDER BY `blog_name`");

		$DSP->body .= "\n<link rel='stylesheet' type='text/css' media='screen' href='" . $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/lg_better_meta/css/admin.css' />";

		ob_start(); include(PATH_LIB.'lg_better_meta/views/lg_better_meta_ext/form_settings.php'); $DSP->body .= ob_get_clean();
		
		$DSP->body .= $DSP->form_c();
		$DSP->body .= "</div>";
	}

	function array_merge_recursive_flat($array1, $array2)
	{
		$merged = $array1;

		if (is_array($array2)) {
			foreach ($array2 as $key => $val) {
				if (is_array($array2[$key]))
					$merged[$key] = is_array($merged[$key]) ? $this->array_merge_recursive_flat($merged[$key], $array2[$key]) : $array2[$key];
				else
					$merged[$key] = $val;
			}
		}

		return $merged;
	}

	/**
	 * Saves the settings from the config form
	 *
	 * @since	Version 1.5.0
	 */
	function save_settings()
	{
		// make somethings global
		global $DB, $IN, $PREFS, $REGX, $SESS;

		// load the settings from cache or DB
		$this->settings = $this->_get_settings(TRUE, TRUE);

		$default_settings = $this->_build_default_settings();

		if(!isset($_POST['Lg_better_meta_ext']['weblogs']))
		{
			$_POST['Lg_better_meta_ext']['weblogs'] = $default_settings['weblogs'];
		}

		if(!isset($_POST['Lg_better_meta_ext']['allowed_member_groups']))
		{
			$_POST['Lg_better_meta_ext']['allowed_member_groups'] = array();
		}

		// add the posted values to the settings
		$this->settings[$PREFS->ini('site_id')] = $_POST['Lg_better_meta_ext'];

		// update the settings
		$DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($this->settings)) . "' WHERE class = '" . get_class($this) . "'");

	}

	/**
	 * Returns the extension settings from the DB
	 *
	 * @access	private
	 * @param	bool	$force_refresh	Force a refresh
	 * @param	bool	$return_all		Set the full array of settings rather than just the current site
	 * @return	array					The settings array
	 * @since 	Version 1.5.0
	 */
	function _get_settings( $force_refresh = FALSE, $return_all = FALSE )
	{
		global $SESS, $DB, $REGX, $LANG, $PREFS;

		// assume there are no settings
		$settings = FALSE;

		// Get the settings for the extension
		if(isset($SESS->cache['lg'][LG_BM_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . LG_BM_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache['lg'][LG_BM_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}

		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache['lg'][LG_BM_addon_id]['settings']) !== TRUE)
		{
			if($return_all === TRUE)
			{
				$settings = $SESS->cache['lg'][LG_BM_addon_id]['settings'];
			}
			else
			{
				if(isset($SESS->cache['lg'][LG_BM_addon_id]['settings'][$PREFS->ini('site_id')]) === TRUE)
				{
					$settings = $SESS->cache['lg'][LG_BM_addon_id]['settings'][$PREFS->ini('site_id')];
				}
				else
				{
					$settings = $this->_build_default_settings();
				}
			}
		}
		return $settings;
	}

	/**
	 * Returns the default settings for this extension
	 * This is used when the extension is activated or when a new site is installed
	 * It returns the default settings for the CURRENT site only.
	 */
	function _build_default_settings()
	{

		global $DB, $PREFS;

		$default_settings = array(
								'enabled' 		=> 'y',
								'divider'		=> 0,
								'author'		=> $PREFS->core_ini['webmaster_name'],
								'title'			=> $PREFS->core_ini['site_name'],
								'description'	=> '',
								'keywords'		=> '',
								'publisher'		=> '',
								'rights'		=> '',
								'weblogs'		=> array(),
								'allowed_member_groups' => array(1),
								'template'		=> "<title>{title}</title>

<meta name='description' content='{description}' />
<meta name='keywords' content='{keywords}' />
<meta name='robots' content='{robots}' />

<meta name='geo.position' content='{latitude},{longitude}' />
<meta name='geo.placename' content='{placename}' />
<meta name='geo.region' content='{region}' />

{if canonical_url}<link rel='canonical' href='{canonical_url}' />{/if}

<link rel='schema.DC' href='http://purl.org/dc/elements/1.1/' />
<link rel='schema.DCTERMS' href='http://purl.org/dc/terms/' />
<meta name='DC.title' content='{title}' />
<meta name='DC.creator' content='{author}' />
<meta name='DC.subject' content='{keywords}' />
<meta name='DC.description' content='{description}' />
<meta name='DC.publisher' content='{publisher}' />
<meta name='DC.date.created' scheme='DCTERMS.W3CDTF' content='{date_created}' />
<meta name='DC.date.modified' scheme='DCTERMS.W3CDTF' content='{date_modified}' />
<meta name='DC.date.valid' scheme='DCTERMS.W3CDTF' content='{date_valid}' />
<meta name='DC.type' scheme='DCTERMS.DCMIType' content='Text' />
<meta name='DC.rights' scheme='DCTERMS.URI' content='{rights}' />
<meta name='DC.format' content='text/html' />
<meta name='DC.identifier' scheme='DCTERMS.URI' content='{identifier}' />",

								'robots_index'			=> 'y',
								'robots_follow'			=> 'y',
								'robots_archive'		=> 'y',
								'region'				=> '',
								'placename'				=> '',
								'latitude'				=> '',
								'longitude'				=> '',
								'google_maps_api_key'	=> '',
								'check_for_updates'		=> 'y',
							  );

		// get all the sites
		$query = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = '" . $PREFS->core_ini['site_id'] . "'");

		// if there are weblogs
		if ($query->num_rows > 0)
		{
			// for each of the sweblogs
			foreach($query->result as $row)
			{
				$default_settings['weblogs'][$row['weblog_id']]['show_tab'] = 'n';
				$fields = array('title', 'description', 'keywords', 'author', 'publisher', 'rights',
						'canonical_url', 'robots_meta', 'sitemap_meta', 'geo_meta',
					);
				foreach ($fields as $field) {
					$default_settings['weblogs'][$row['weblog_id']]['show_' . $field] = 'y';
				}
				$default_settings['weblogs'][$row['weblog_id']]['include_in_sitemap'] = 'y';
				$default_settings['weblogs'][$row['weblog_id']]['change_frequency'] = 'Weekly';
				$default_settings['weblogs'][$row['weblog_id']]['priority'] = '0.5';
			}
		}
		return $default_settings;

	}

	/**
	 * Activates the extension
	 *
	 * @return	bool Always TRUE
	 * @todo		Add some error checking just incase the extension doesn't activate properly
	 */
	function activate_extension()
	{
		global $DB, $PREFS;

		$default_settings = $this->_build_default_settings();

		$query = $DB->query("SELECT * FROM exp_sites");

		if ($query->num_rows > 0)
		{
			foreach($query->result as $row)
			{
				$settings[$row['site_id']] = $default_settings;
				$settings[$row['site_id']]['title'] = $row['site_label'];
			}
		}

		$hooks = array(
			'publish_form_new_tabs'				=> 'publish_form_new_tabs',
			'publish_form_new_tabs_block'		=> 'publish_form_new_tabs_block',
			'publish_form_start'				=> 'publish_form_start',
			'submit_new_entry_end'				=> 'submit_new_entry_end',
			'show_full_control_panel_end' 		=> 'show_full_control_panel_end',
			'lg_addon_update_register_source'	=> 'lg_addon_update_register_source',
			'lg_addon_update_register_addon'	=> 'lg_addon_update_register_addon'
		);

		foreach ($hooks as $hook => $method)
		{
			$sql[] = $DB->insert_string( 'exp_extensions', 
											array('extension_id' 	=> '',
												'class'				=> get_class($this),
												'method'			=> $method,
												'hook'				=> $hook,
												'settings'			=> addslashes(serialize($settings)),
												'priority'			=> 10,
												'version'			=> $this->version,
												'enabled'			=> "y"
											)
										);
		}

		$sql[] ="CREATE TABLE IF NOT EXISTS `exp_lg_better_meta` (
						`id` INT( 8 ) NOT NULL AUTO_INCREMENT ,
						`site_id` INT( 8 ) NOT NULL DEFAULT '1',
						`entry_id` INT( 8 ) NULL ,
						`weblog_id` INT( 8 ) NULL ,
						`url_title` VARCHAR( 255 ) NULL ,
						`title` VARCHAR( 255 ) NULL ,
						`keywords` VARCHAR( 255 ) NULL ,
						`description` VARCHAR( 255 ) NULL ,
						`publisher` VARCHAR( 255 ) NULL ,
						`rights` VARCHAR( 255 ) NULL ,
						`author` VARCHAR( 255 ) NULL ,
						`index` VARCHAR( 1 ) NULL ,
						`follow` VARCHAR( 1 ) NULL ,
						`archive` VARCHAR( 1 ) NULL ,
						`priority` VARCHAR( 5 ) NULL ,
						`change_frequency` VARCHAR( 50 ) NULL ,
						`include_in_sitemap` VARCHAR( 1 ) NULL ,
						`canonical_url` VARCHAR( 255 ) NOT NULL ,
						`region` VARCHAR( 255 ) NOT NULL ,
						`placename` VARCHAR( 255 ) NOT NULL ,
						`latitude` VARCHAR( 25 ) NOT NULL ,
						`longitude` VARCHAR( 25 ) NOT NULL ,
						`append_default_keywords` TINYINT( 1 ) NOT NULL ,
						PRIMARY KEY ( `id` ) ,
						UNIQUE (`entry_id`)
					)";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
	}

	/**
	 * Updates the extension
	 *
	 * If the existing version is below 1.4.0 then the update process changes some
	 * method names. This may cause an error which can be resolved by reloading
	 * the page.
	 *
	 * @param	string $current If installed the current version of the extension otherwise an empty string
	 * @return	bool FALSE if the extension is not installed or is the current version
	 */
	function update_extension( $current = '' )
	{
		global $DB, $SESS, $PREFS;

		if ($current == '' OR $current == $this->version) return FALSE;

		// add our new robots options
		if ($current < '1.0.1')
		{
			$DB->query("ALTER TABLE exp_lg_better_meta
				ADD `index` TINYINT NULL,
				ADD `follow` TINYINT NULL,
				ADD `archive` TINYINT NULL
			");
		}
		
		// add our new hide / show options
		if ($current < '1.3.0')
		{

			// load the settings from cache or DB
			$this->settings = $this->_get_settings(TRUE, TRUE);

			$this->settings['show_title'] = 1;
			$this->settings['show_description'] = 1;
			$this->settings['show_keywords'] = 1;
			$this->settings['show_author'] = 1;
			$this->settings['show_publisher'] = 1;
			$this->settings['show_rights'] = 1;
			$this->settings['show_robots'] = 1;

			$DB->query($DB->insert_string( 'exp_extensions', 
											array(
												'extension_id' 	=> '',
												'class'			=> get_class($this),
												'method'		=> "add_header",
												'hook'			=> "publish_form_headers",
												'settings'		=> $this->settings,
												'priority'		=> 10,
												'version'		=> $this->version,
												'enabled'		=> "y"
											)
										));
		}

		// change the method names
		if ($current < '1.4.0')
		{
			// rename the methods
			$sql[] = "UPDATE `exp_extensions`
						SET
							`method` = 'publish_form_new_tabs',
							`class` = 'Lg_better_meta'
						WHERE
							`method` = 'add_meta_tab'
						AND
							`class` =  'lg_better_meta'
						LIMIT 1";

			$sql[] = "UPDATE `exp_extensions`
						SET
							`method` = 'publish_form_new_tabs_block',
							`class` = 'Lg_better_meta'
						WHERE
							`method` = 'add_meta_tab_block'
						AND
							`class` =  'lg_better_meta'
						LIMIT 1";

			$sql[] = "UPDATE `exp_extensions`
						SET
							`method` = 'submit_new_entry_end',
							`class` = 'Lg_better_meta'
						WHERE
							`method` = 'insert_meta'
						AND
							`class` =  'lg_better_meta'
						LIMIT 1";

			$sql[] = "UPDATE `exp_extensions`
						SET
							`method` = 'show_full_control_panel_end',
							`hook` = 'show_full_control_panel_end',
							`class` = 'Lg_better_meta'
						WHERE
							`method` = 'add_header'
						AND
							`class` =  'lg_better_meta'
						LIMIT 1";

			// run all sql queries
			foreach ($sql as $query)
			{
				$DB->query($query);
			}

		}

		if ($current < '1.4.2')
		{
			// load the settings from cache or DB
			$this->settings = $this->_get_settings(TRUE, TRUE);

			$DB->query($DB->insert_string( 'exp_extensions', 
											array('extension_id' 	=> '',
												'class'			=> get_class($this),
												'method'		=> 'control_panel_home_page',
												'hook'			=> 'control_panel_home_page',
												'priority'		=> 10,
												'version'		=> $this->version,
												'enabled'		=> "y",
												'settings'		=> array_merge($this->settings, array('check_for_updates' => 1, 'cache_refresh' => 3200))
											)
										));
		}

		/*
		Version 1.5 introduces MSM compatibility
		It also does away with integers for select boxes and replaces them with 'y' & 'n'
		Adds check boxes for weblogs rather than a comma delimited list
		*/
		if ($current < '1.5.0')
		{
			// load the settings from cache or DB
			$this->settings = $this->_get_settings(TRUE, TRUE);

			// loop through the keys
			foreach ($this->settings as $key => $value)
			{
				// if its not the weblogs
				if($key != 'weblogs' && $key != 'divider')
				{
					// check the value
					switch ($value)
					{
						case '0':
							$this->settings[$key] = 'n';
							break;

						case '1':
							$this->settings[$key] = 'y';
							break;
					}
				}
				// weblog string
				elseif($key == 'weblogs')
				{
					// explode the weblog string into an array
					$this->settings[$key] = explode(",", $value);
				}
			}

			// check to see if there are weblogs
			if(isset($this->settings['weblogs']) === FALSE || empty($this->settings['weblogs']) === TRUE)
			{
				$this->settings['weblogs'] = array();
			}

			// get all the sites
			$query = $DB->query("SELECT * FROM exp_sites");

			// if there are sites (there should be at least 1)
			if ($query->num_rows > 0)
			{
				// for each of the sites
				foreach($query->result as $row)
				{
					// duplicate the default settings for this site
					// that way nothing will break unexpectedly
					$settings[$row['site_id']] = $this->settings;
				}
			}

			// need to loop through each of the meta entries and update the robots settings
			$sql[] = "ALTER TABLE `exp_lg_better_meta`
					CHANGE `index`  `index` VARCHAR( 1 ) NOT NULL,
					CHANGE `follow`  `follow` VARCHAR( 1 ) NOT NULL,
					CHANGE `archive`  `archive` VARCHAR( 1 ) NOT NULL";

			// update the robots index
			$sql[] = "UPDATE `exp_lg_better_meta` SET `index` = '' WHERE `index` = '0'";
			$sql[] = "UPDATE `exp_lg_better_meta` SET `index` = 'y' WHERE `index` = '1'";
			$sql[] = "UPDATE `exp_lg_better_meta` SET `index` = 'n' WHERE `index` = '2'";

			// updates the robots follow
			$sql[] = "UPDATE `exp_lg_better_meta` SET `follow` = '' WHERE `follow` = '0'";
			$sql[] = "UPDATE `exp_lg_better_meta` SET `follow` = 'y' WHERE `follow` = '1'";
			$sql[] = "UPDATE `exp_lg_better_meta` SET `follow` = 'n' WHERE `follow` = '2'";

			// update robots archive
			$sql[] = "UPDATE `exp_lg_better_meta` SET `archive` = '' WHERE `archive` = '0'";
			$sql[] = "UPDATE `exp_lg_better_meta` SET `archive` = 'y' WHERE `archive` = '1'";
			$sql[] = "UPDATE `exp_lg_better_meta` SET `archive` = 'n' WHERE `archive` = '2'";

			// create the update string
			// with serialised array
			$sql[] = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . get_class($this) . "'";

			// run all sql queries
			foreach ($sql as $query)
			{
				$DB->query($query);
			}
		}

		// added per site enabling
		// I missed this in version 1.6.0
		if ($current < '1.6.0')
		{
			// load the settings from cache or DB
			$this->settings = $this->_get_settings(TRUE, TRUE);

			foreach ($settings as $site => $site_settings) {
				$this->settings[$site]['enabled'] = 'y';
			}

			$DB->query("UPDATE exp_extensions SET settings = '" . addslashes(serialize($this->settings)) . "' WHERE class = '" . get_class($this) . "'");
		}

		// Integrated LG Addon Updater
		// Removed control_panel_homepage hook
		// Added lg_addon_update_register_source hook + method
		// Added lg_addon_update_register_addon hook + method
		// Set show donate to false
		// Set show promos to true
		if($current < '1.6.1')
		{
			// get all settings
			$settings = $this->_get_settings(TRUE, TRUE);

			// for each site
			foreach ($settings as $site => $site_settings) {
				// add allowed member groups
				$settings[$site]['allowed_member_groups'] = array(1);
				$settings[$site]['show_donate'] = 'n';
				$settings[$site]['show_promos'] = 'y';
			}
			// delete the control_panel_home_page hook
			$sql[] = "DELETE FROM `exp_extensions` WHERE `class` = '".get_class($this)."' AND `hook` = 'control_panel_home_page'";
			// update the existing extensions will the new settings
			$sql[] = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . get_class($this) . "'";
			// create two new hooks
			$hooks = array(
				'lg_addon_update_register_source'	=> 'lg_addon_update_register_source',
				'lg_addon_update_register_addon'	=> 'lg_addon_update_register_addon'
			);
			// for each of the new hooks
			foreach ($hooks as $hook => $method)
			{
				// build the sql
				$sql[] = $DB->insert_string( 'exp_extensions', 
												array('extension_id' 	=> '',
													'class'				=> get_class($this),
													'method'			=> $method,
													'hook'				=> $hook,
													'settings'			=> addslashes(serialize($settings)),
													'priority'			=> 10,
													'version'			=> $this->version,
													'enabled'			=> "y"
												)
											);
			}

			// run all sql queries
			foreach ($sql as $query)
			{
				$DB->query($query);
			}
			$this->settings = $settings[$PREFS->ini('site_id')];
		}


		// Added Sitemap meta
		if($current < '1.7.0')
		{
			// get all settings
			$settings = $this->_get_settings(TRUE, TRUE);
			// for each site
			foreach ($settings as $site => $site_settings) {
				// add allowed member groups
				$settings[$site]['show_sitemap'] = 'y';
			}

			// get all the sites
			$query = $DB->query("SELECT * FROM exp_weblogs");

			// if there are weblogs
			if ($query->num_rows > 0)
			{
				// for each of the sweblogs
				foreach($query->result as $row)
				{
					// duplicate the default settings for this site
					// that way nothing will break unexpectedly
					$settings[$row['site_id']]['sitemap_defaults'][$row['weblog_id']] = array(
						'include_in_sitemap'=> 'y',
						'change_frequency' 	=> 'Weekly',
						'priority' 			=> '0.5'
					);
				}
			}
			// update the settings
			$sql[] = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . get_class($this) . "'";
			
			// add the priority, change frequency and include_in_sitemap cols to the meta table
			$sql[] = "ALTER TABLE exp_lg_better_meta
						ADD `priority` VARCHAR( 5 ) NOT NULL ,
						ADD `change_frequency` VARCHAR( 50 ) NOT NULL ,
						ADD `include_in_sitemap` VARCHAR( 1 ) NOT NULL";

			// run all sql queries
			foreach ($sql as $query)
			{
				$DB->query($query);
			}

			// set the objects settings to the current site
			$this->settings = $settings[$PREFS->ini('site_id')];

		}

		// Added Canonical url
		if($current < '1.8.0')
		{
			include(PATH_LIB.'lg_better_meta/updates/1.8.0.php');
		}

		// update the version
		$DB->query("UPDATE exp_extensions SET version = '" . $DB->escape_str($this->version) . "' WHERE class = '" . get_class($this) . "'");

		return TRUE;
	}

	/**
	 * Disables the extension the extension and deletes settings from DB
	 */
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM exp_extensions WHERE class = '" . get_class($this) . "'");
	}

	/**
	 * Method for the publish_form_start hook
	 *
	 * - Runs before any data is processed
	 *
	 * @param  string $which The current action (new, preview, edit, or save)
	 * @param  string $submission_error A submission error if any
	 * @param  string $entry_id The current entries id
	 * @see    http://expressionengine.com/developers/extension_hooks/publish_form_start/
	 * @since  Version 1.8.0
	 */
	function publish_form_start( $which, $submission_error, $entry_id, $hidden )
	{
		global $IN, $SESS;

		if(empty($entry_id)) $entry_id = $IN->GBL("entry_id");

		// Quicksave
		if($which == "save" && !empty($entry_id))
		{
			$weblog_id = $IN->GBL('weblog_id');
			if (!$this->check_display_publish_tab($weblog_id))
			{
				return FALSE;
			}

			$this->submit_new_entry_end($entry_id, null, null);
		}

	}

	/**
	 * Adds a new tab to the publish / edit form
	 *
	 * Method name was changed in version Version 1.4.0
	 *
	 * @param	array $publish_tabs Array of existing tabs
	 * @param	int $weblog_id Current weblog id
	 * @param	int $entry_id Current entry id
	 * @param	array $hidden Hidden form fields
	 * @return	array Modified tab list
	 * @since 	Version 1.4.0
	 */
	function publish_form_new_tabs( $publish_tabs, $weblog_id, $entry_id, $hidden )
	{
		global $EXT, $PREFS, $SESS;

		if($EXT->last_call !== FALSE)
		{
			$publish_tabs = $EXT->last_call;
		}

		if (!$this->check_display_publish_tab($weblog_id))
		{
			return $publish_tabs;
		}

		$publish_tabs['bm'] = 'Meta';

		return $publish_tabs;
	}

	/**
	 * Adds the tab content containing all Better Meta fields
	 *
	 * Allows adding of new tabs' blocks to the submission form. Method name was changed in version Version 1.4.0
	 *
	 * @param	int $weblog_id The weblog ID for this Publish form
	 * @return	string Content of the new tab
	 * @since 	Version 1.4.0
	 */
	function publish_form_new_tabs_block( $weblog_id )
	{
		global $DB, $EXT, $PREFS, $SESS, $LANG, $REGX, $IN, $DSP;


		
		$LANG->fetch_language_file('lg_better_meta');

		$ret = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';

		if (!$this->check_display_publish_tab($weblog_id))
		{
			return $ret;
		}

		$settings = array_merge($this->settings, $this->settings['weblogs'][$weblog_id]);

		$entry = $IN->GBL('Lg_better_meta_ext');
		$entry_id = $IN->GBL('entry_id', 'GET');

		// if there is an entry (edit page)
		if($entry_id !== FALSE && $entry === FALSE)
		{
			$query = $DB->query($sql = "SELECT * FROM `exp_lg_better_meta` WHERE `entry_id` = " . $entry_id . " LIMIT 1");	

			if($query->num_rows > 0)
				$entry = $query->row;
		}

		ob_start(); include(PATH_LIB.'lg_better_meta/views/lg_better_meta_ext/tab_meta.php'); $ret .= ob_get_clean();
		return $ret;
	}

	/**
	 * Submits the new meta value into the DB
	 *
	 * Method name was changed in version Version 1.4.0
	 *
	 * @param	int $entry_id Entry's ID
	 * @param	int $data Array of data about entry (title, url_title)
	 * @param	string $ping_message Error message if trackbacks or pings have failed to be sent
	 * @since 	Version 1.4.0
	 */
	function submit_new_entry_end( $entry_id, $data, $ping_message )
	{
		global $DB, $PREFS, $SESS, $IN;

		$sql = FALSE;

		// if some meta data stuff is passed through
		if(isset($_POST['Lg_better_meta_ext']))
		{
			$data = $_POST['Lg_better_meta_ext'];

			$data['entry_id'] = $entry_id;
			$data['url_title'] = $IN->GBL('url_title', 'POST');
			$data['weblog_id'] = $IN->GBL('weblog_id', 'POST');
			
			// checkboxes
			$data['append_default_keywords'] = !empty($data['append_default_keywords']);

			// see if the entry exists (an edit)
			$query = $DB->query("SELECT * FROM	exp_lg_better_meta WHERE entry_id = " . $entry_id . " LIMIT 1");

			// if there are no rows returned
			if ($query->num_rows == 0)
			{
				// create insert sql
				$sql = $DB->insert_string( 'exp_lg_better_meta', $data);
			}
			else
			{
				// create update sql
				$sql = $DB->update_string( 'exp_lg_better_meta', $data, "entry_id = " . $entry_id );
			}
		}

		// execute sql
		$DB->query($sql);
	}

	/**
	 * Takes the control panel and adds the Better Meta scripts and styles
	 *
	 * @param	string $out The control panel html
	 * @return	string The modified control panel html
	 * @since 	Version 1.4.0
	 */
	function show_full_control_panel_end( $out )
	{
		global $DB, $EXT, $IN, $PREFS, $REGX, $SESS;

		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$out = $EXT->last_call;

		if(
			$IN->GBL('C', 'GET') == 'publish'
			|| $IN->GBL('C', 'GET') == 'edit'
			|| $IN->GBL('P', 'GET') == 'extension_settings'
		)
		{
			$settings = $this->_get_settings();

			$css = $js = "";

			if(isset($SESS->cache['Morphine']['cp_styles_included']) === FALSE)
			{
				$css .= "\n<link rel='stylesheet' type='text/css' media='screen' href='" . $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/Morphine/css/MOR_screen.css' />";
				$SESS->cache['Morphine']['cp_styles_included'] = TRUE;
			}

			$css .= "\n<link rel='stylesheet' type='text/css' media='screen' href='" . $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/lg_better_meta/css/admin.css' />";

			$js .= "<script type='text/javascript' charset='utf-8'>
				var lg_better_meta_lat = " . (float)$this->settings['latitude'] . ";
				var lg_better_meta_long = " . (float)$this->settings['longitude'] . "; 
				var lg_better_meta_keywords = '".$this->settings["keywords"]."';
			</script>";
			$js .= "\n<script type='text/javascript' lang='javascript' src='" . $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/lg_better_meta/js/admin.js'></script>";

			$out = str_replace("</head>", $css . "</head>", $out);
			$out = str_replace("</body>", $js . "</body>", $out);
			// make sure we don't add it again
		}
		return $out;
	}

	/**
	 * Register a new Addon Source
	 *
	 * @param	array $sources The existing sources
	 * @return	array The new source list
	 * @since 	Version 1.6.2
	 */
	function lg_addon_update_register_source( $sources )
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
	 * @param	array $addons The existing sources
	 * @return	array The new addon list
	 * @since 	Version 1.6.2
	 */
	function lg_addon_update_register_addon( $addons )
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
			$addons[LG_BM_addon_id] = $this->version;
		}

		return $addons;
	}

	/**
	 * Debug
	 *
	 * @access	private 
	 * @param	mixed 	$obj 	The data
	 * @param	bool	$exit	Exit after the method has been called
	 * @param	bool	$ret	Return the text from the method rather than print it
	 * @param	string	$msg	A message outputted added to the output
	 * @return	void
	 * @since 	Version 1.4.2
	 * 
	 * 1.6.0 - Added constants in the method 
	 * A nice little debugging feature
	 */
	function _debug($obj, $exit = TRUE, $ret = FALSE, $msg = '')
	{
		$r = "<h2>" . $msg . "</h2>\n<pre>" . ((is_string($obj) === FALSE) ? $REGX->form_prep(print_r($obj, TRUE)) : $REGX->form_prep($obj)) . "</pre>\n";
		if($ret !== FALSE)
		{
			return $r;
		}
		else
		{
			print $r;
		}
		if($exit === TRUE) exit;
	}

	/**
	 * Creates a select box
	 *
	 * @access public
	 * @param mixed $selected The selected value
	 * @param array $options The select box options in a multi-dimensional array. Array keys are used as the option value, array values are used as the option label
	 * @param string $input_name The name of the input eg: Lg_polls_ext[log_ip]
	 * @param string $input_id A unique ID for this select. If no id is given the id will be created from the $input_name
	 * @param boolean $use_lanng Pass the option label through the $LANG->line() method or display in a raw state
	 * @param array $attributes Any other attributes for the select box such as class, multiple, size etc
	 * @return string Select box html
	 */
	function select_box($selected, $options, $input_name, $input_id = FALSE, $use_lang = TRUE, $key_is_value = TRUE, $attributes = array())
	{
		global $LANG;

		$input_id = ($input_id === FALSE) ? str_replace(array("[", "]"), array("_", ""), $input_name) : $input_id;

		$attributes = array_merge(array(
			"name" => $input_name,
			"id" => strtolower($input_id)
		), $attributes);

		$attributes_str = "";
		foreach ($attributes as $key => $value)
		{
			$attributes_str .= " {$key}='{$value}' ";
		}

		$ret = "<select{$attributes_str}>";

		foreach($options as $option_value => $option_label)
		{
			if (!is_int($option_value))
				$option_value = $option_value;
			else
				$option_value = ($key_is_value === TRUE) ? $option_value : $option_label;

			$option_label = ($use_lang === TRUE) ? $LANG->line($option_label) : $option_label;
			$checked = ($selected == $option_value) ? " selected='selected' " : "";
			$ret .= "<option value='{$option_value}'{$checked}>{$option_label}</option>";
		}

		$ret .= "</select>";
		return $ret;
	}

	function check_display_publish_tab($weblog_id)
	{
		global $SESS;
		
		// this shouldn't actually happen - because of default values, but eh
		if ( $weblog_id === FALSE || !isset($this->settings['weblogs'][$weblog_id]) )
			return false;

		$show = $this->settings['weblogs'][$weblog_id]['show_tab'];
		if ($show != 'y')
			return false;

		// check group creds
		$my_group = $SESS->userdata['group_id'];
		if (!in_array($my_group, $this->settings['allowed_member_groups']))
			return false;
			
		return true;
	}
}

?>
