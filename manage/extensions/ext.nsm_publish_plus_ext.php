<?php
/**
* Class file for NSM Publish Plus
* ===============================
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
* 
* Requirements
* ------------
* 
* NSM Publish Plus has been tested on EE 1.6.4+
* CP jQuery must be installed and activated
* 
* Installation
* ------------
*
* 1. Copy /system/extensions/ext.nsm_publish_plus_ext.php to /system/extensions
* 2. Copy /system/languages/english/lang.nsm_publish_plus_ext.php to /system/languages/english
* 3. Copy /themes/cp_themes/default/nsm_publish_plus to /themes/cp_themes/default/
* 4. Copy the contents of /themes/cp_global_images/ to /themes/cp_global_images
* 
* Activation
* ------------
* 
* 1. Enable Extensions
* 2. Enable NSM Publish Plus
* 3. Open the extension settings
* 4. Modify settings as required
* 5. Save even if no modifications have been required
* 
* Changelog
* ---------
* 
* ### 1.0.0
* 
* - Initial Release
* 
* ### 1.0.1
* 
* - Changed references from "dirty" to "changed"
* 
* ### 1.0.2
* 
* - Added draft edit note functionality
* 
* ### 1.0.3
* 
* - Fixed notification bug regarding members who had not had roles specifically assigned
* 
* ### 1.0.4
* 
* - Drafts are now automatically created for every revision
* - Edit entry action changed to Create Revision
* 
* ### 1.0.5
* 
* - Added Live Look integration for drafts and revisions
* 
* ### 1.1.0
* 
* - LG Live Look integration!
* - Added preview saving for LG Live Look integration
* - Added revision id to revisions table
* - Fixed localisation bug
* - Rewrote way latest revision was handled
* 
* 
* Important CORE HACK Required
* ----------------------------
*
* This extension requires a single core hack.
* 
* In /system/cp/cp.publish.php search for:
* 	
* 	if (is_numeric($version_id))
* 	{
* 	  $entry_id = $IN->GBL('entry_id');
* 	  $revquery = $DB->query("SELECT version_data FROM exp_entry_versioning WHERE entry_id = '{$entry_id}' AND version_id = '{$version_id}'");
* 	
* 	  if ($revquery->num_rows == 1)
* 	  {
* 		$_POST = $REGX->array_stripslashes(@unserialize($revquery->row['version_data']));
* 	    $_POST['entry_id'] = $entry_id;
* 	    $which = 'preview';
* 	  }
* 	  unset($revquery);
* 	}
* 
* and append:
* 
*	if (is_numeric($IN->GBL("draft_id")))
*	{
*	  $which = 'preview';
*	}
* 
* More Documentation
* ------------------
* 
* More documentation is available in the /docs folder of the official download
*
* @package NSMPublishPlus
* @version 1.1.0
* @author Leevi Graham <http://newism.com.au>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/nsm-publish-plus/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement/
*/

if ( ! defined('EXT')) exit('Invalid file request');

if ( ! defined('NSM_PP_version')){
	define("NSM_PP_version",			"1.1.1");
	define("NSM_PP_docs_url",			"http://leevigraham.com/cms-customisation/expressionengine/addon/nsm-publish-plus/");
	define("NSM_PP_addon_id",			"NSM Publish Plus");
	define("NSM_PP_extension_class",	"nsm_publish_plus_ext");
	define("NSM_PP_cache_name",			"nsm_cache");
}

/**
* This extension allows you to remove the default fields in the create new member form of the ExpressionEngine control panel
*
* @package NSMPublishPlus
* @version 1.0.0
* @author Leevi Graham <http://newism.com.au>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-multi-language-pro/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement/
*/
class Nsm_publish_plus_ext {

	/**
	* Extension name
	* @var		string
	* @since	Version 1.0.0
	*/
	var $name				= 'NSM Publish Plus';

	/**
	* Extension version
	* @var		string
	* @since	Version 1.0.0
	*/
	var $version			= NSM_PP_version;

	/**
	* Extension description
	* @var		string
	* @since	Version 1.0.0
	*/
	var $description		= 'Improved publishing workflow for ExpressionEngine';

	/**
	* If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	* @var		string
	* @since	Version 1.0.0
	*/
	var $settings_exist		= 'y';

	/**
	* Link to extension documentation
	* @var		string
	* @since	Version 1.0.0
	*/
	var $docs_url			= NSM_PP_docs_url;

	/**
	* cache folder
	* @var		string
	* @since	Version 1.0.0
	*/
	var $cache_name 		= NSM_PP_cache_name;

	/**
	* debug?
	* @var		string
	* @since	Version 1.0.0
	*/
	var $debug 				= FALSE;

	/**
	* PHP4 Constructor
	* @since	Version 1.0.0
	* @see		__construct()
	*/
	function Nsm_publish_plus_ext( $settings = "" )
	{
		$this->__construct($settings);
	}

	/**
	* PHP5 Constructor
	* 
	* The constructor seems to get called every time a hook is executed
	*
	* @since	Version 1.0.0
	* @param	array|string $settings Extension settings associative array or an empty string
	*/
	function __construct( $settings = "" )
	{
		global $IN, $SESS;
		$this->settings = $this->_get_extension_settings();
	}

	/**
	* Method for the sessions_end hook
	*
	* @param	object		$obj		EE SESSION object
	* @see		http://expressionengine.com/developers/extension_hooks/sessions_end/
	* @since	Version 1.0.0
	*/
	function sessions_start( &$obj )
	{

		if($this->settings['enable'] != "y") return;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." sessions_start: start");

		global $DB, $IN, $REGX;

		if(isset($obj->cache['nsm'][NSM_PP_addon_id]) === FALSE)
		{
			$obj->cache['nsm'][NSM_PP_addon_id] = array();
		}

		$obj->cache['nsm'][NSM_PP_addon_id]["preview_data"] = FALSE;

		if(REQ == "PAGE")
		{
			foreach ($IN->SEGS as $seg_key => $value)
			{
				if(
					(
						$value == $this->settings['draft_trigger']
						|| $value == $this->settings['revision_trigger']
						|| $value == $this->settings['preview_trigger']
					)
					&& !empty($IN->SEGS[$seg_key + 1])
				)
				{
					$id = $IN->SEGS[$seg_key + 1];

					unset($IN->SEGS[$seg_key]);
					unset($IN->SEGS[$seg_key + 1]);

					$IN->URI = preg_replace("/(\/?".$value."\/".$id.")/", "", $IN->URI);
					$IN->QSTR = preg_replace("/(\/?".$value."\/".$id.")/", "", $IN->QSTR);

					// load draft
					if(
						$value == $this->settings['draft_trigger']
						|| $value == $this->settings['preview_trigger']
					)
					{
						$type = "draft";
						$sql = "SELECT 
									draft_id as id,
									entry_id,
									site_id,
									weblog_id,
									author_id,
									created_at as created_at,
									draft_data as data
								FROM `exp_nsm_entry_drafts`
								WHERE draft_id = " . $id . " LIMIT 1";
					}
					// load revision
					elseif($value == $this->settings['revision_trigger'])
					{
						$type = "revision";
						$sql = "SELECT 
									version_id as id,
									entry_id,
									weblog_id,
									author_id,
									version_date as created_at,
									version_data as data
								FROM `exp_entry_versioning`
								WHERE version_id = " . $id . " LIMIT 1";
					}

					$data_query = $DB->query($sql);
					if($data_query->num_rows > 0)
					{
						$data_query->row["type"] = $type;
						$data_query->row["data"] = $REGX->array_stripslashes(unserialize($data_query->row["data"]));
						$obj->cache['nsm'][NSM_PP_addon_id]["preview_data"] = $data_query->row;
					}
				}
			}
		}

		if($this->debug === TRUE) print("<br />".memory_get_usage()." sessions_start: end");
	}

	/**
	* Method for the sessions_end hook
	*
	* @param	object		$obj		EE SESSION object
	* @see		http://expressionengine.com/developers/extension_hooks/sessions_end/
	* @since	Version 1.0.0
	*/
	function sessions_end( &$obj )
	{
		global $DB, $IN, $LANG, $LOC, $PREFS, $REGX;
		//print("<pre>".print_r($_POST, TRUE)."</pre>");

		if($this->settings['enable'] != "y") return;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." sessions_end: start");

		// create new cache objects for to hold basic nsm variables
		if(isset($obj->cache['nsm']) === FALSE) $obj->cache['nsm'] = array();
		// create a messages array
		if(isset($obj->cache['nsm']['msgs']) === FALSE) $obj->cache['nsm']['msgs'] = array();

		$obj->cache['nsm'][NSM_PP_addon_id]["stage"] = FALSE;
		$obj->cache['nsm']['kill_preview'] = FALSE;

		// remove all the users assigned weblogs
		$obj->userdata['assigned_weblogs'] = array();

		// create a placeholder for the member roles.
		$member_roles = array();
		$group_id = $obj->userdata['group_id'];

		$weblog_query = $DB->query("SELECT * FROM `exp_weblogs` WHERE `site_id` = " . $PREFS->ini("site_id") . " ORDER BY blog_title");

		// GROUP ROLES
		// does this group have settings
		if(isset($this->settings["nsm_pp_group_weblog_role"][$group_id]) === TRUE)
		{
			$member_roles = $this->settings["nsm_pp_group_weblog_role"][$group_id];
		}
		// no settings for group
		else
		{
			// set no_acces as a default for each weblog
			foreach ($weblog_query->result as $weblog)
			{
				$member_roles[$weblog['weblog_id']] = "no_access";
			}
		}

		// does this user have roles
		// if this is a member, not a guest
		// overwrite the group defaults
		if($obj->userdata['member_id'] != FALSE)
		{
			$member_roles_query = $DB->query("SELECT r.*, w.blog_title FROM `exp_nsm_acl_roles` as r
									JOIN exp_weblogs as w ON r.weblog_id = w.weblog_id
									WHERE `r`.`site_id` = " . $PREFS->ini("site_id") . "
									AND `member_id` = ".$obj->userdata['member_id']."
									AND `class_name` = '".__CLASS__."'
									AND `role` <> ''");
			foreach ($member_roles_query->result as $role)
			{
				// overwrite our default roles with the members roles
				$member_roles[$role['weblog_id']] = $role["role"];
			}
		}

		foreach($weblog_query->result as $weblog)
		{
			if($member_roles[$weblog['weblog_id']] == "editor" || $member_roles[$weblog['weblog_id']] == "publisher")
			{
				$obj->userdata['assigned_weblogs'][$weblog["weblog_id"]] = $weblog['blog_title'];
			}
		}

		// save the roles in the SESSION
		$obj->userdata['nsm_pp_roles'] = $member_roles;

		unset($member_roles_query);
		unset($weblog_query);

		if($this->debug === TRUE) print("<br />".memory_get_usage()." sessions_end: end");
		
	}

	/**
	* Add additional parts to the FIELDS part of search query in Edit section
	*
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_search_fields/
	* @since	Version 1.0.0
	*/
	function edit_entries_search_fields()
	{
		global $EXT, $SESS;
		$out = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';
		// if not enabled return
		if($this->settings['enable'] != 'y') return $out;
		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." edit_entries_search_fields: start");
		$SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_styles'] = TRUE;
		if($this->debug === TRUE) print("<br />".memory_get_usage()." edit_entries_search_fields: end");
		return $out . ", exp_weblog_titles.nsm_pp_state";
	}

	/**
	* Allows complete rewrite of Edit Entries Search form
	*
	* @param	string 		$out 	The form html
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_search_form/
	*/
	function edit_entries_search_form( $out )
	{
		global $EXT, $LANG, $REGX;

		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $out = $EXT->last_call;

		// if not enabled return
		if($this->settings['enable'] != 'y') return $out;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." edit_entries_search_form: start");

		$LANG->fetch_language_file('nsm_publish_plus_ext');

		// get system languages
		$state = (isset($_POST['nsm_pp_state']) === TRUE) ? $REGX->form_prep($_POST['nsm_pp_state']) : "";

		$r = "<select name='nsm_pp_state'><option value=''>".$LANG->line("filter_by_state")."</option>
			<option value='pending'" . (($state == "pending") ? " selected='selected'" : "" ) . ">". ucfirst($LANG->line("pending")) . "</option>
			<option value='approved'" . (($state == "approved") ? " selected='selected'" : "" ) . ">". ucfirst($LANG->line("approved")) . "</option>
			<option value='denied'" . (($state == "denied") ? " selected='selected'" : "" ) . ">". ucfirst($LANG->line("denied")) . "</option>
			<option value='changed'" . (($state == "changed") ? " selected='selected'" : "" ) . ">". ucfirst($LANG->line("changed")) . "</option>";

		$r .= "</select>&nbsp;&nbsp;&nbsp;&nbsp;";
		$out = str_replace(array(
					"<select name='date_range'",
					"class='select"
					),
					array(
						$r . "<select name='date_range'",
						"class='"
					),
					$out
				);

		if($this->debug === TRUE) print("<br />".memory_get_usage()." edit_entries_search_form: end");

		return $out;
	}

	/**
	* Add additional parts to the WHERE part of query for search in Edit Entries
	*
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_search_where/
	* @since	Version 1.0.0
	*/
	function edit_entries_search_where()
	{
		global $EXT, $REGX;

		$out = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';

		if($this->settings['enable'] != 'y') return $out;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." edit_entries_search_where: start");

		if(isset($_POST['nsm_pp_state']) === TRUE && empty($_POST['nsm_pp_state']) === FALSE)
		{
			$out .= " AND nsm_pp_state = '" . $_POST['nsm_pp_state'] . "' ";
		}

		if($this->debug === TRUE) print("<br />".memory_get_usage()." edit_entries_search_where: end");

		return $out;
	}

	/**
	* Adds a table header to the edit entries page.
	* 
	* @return	string	The new table headers
	* @since	Version 1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_additional_tableheader/
	**/
	function edit_entries_additional_tableheader()
	{

		global $EXT, $LANG, $SESS;

		// Check if we're not the only one using this hook
		$out = ($EXT->last_call !== FALSE) ? $EXT->last_call : "";

		// if not enabled return
		if($this->settings['enable'] != 'y') return $out;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." edit_entries_additional_tableheader: start");

		$LANG->fetch_language_file('nsm_publish_plus_ext');

		$out .= "<td class='tableHeadingAlt'>".ucwords($LANG->line("state"))."</td>";

		if($this->debug === TRUE) print("<br />".memory_get_usage()." edit_entries_additional_tableheader: end");

		return $out;
	}

	/**
	* Adds a table cell to the edit entries page.
	* 
	* @param 	array	$row	The data for this row
	* @return	string	The new table cells
	* @since	Version 1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_additional_celldata/
	**/
	function edit_entries_additional_celldata( $row )
	{

		global $EXT, $LANG, $SESS, $nsm_pp_row_i;

		// Check if we're not the only one using this hook
		$out = ($EXT->last_call !== FALSE) ? $EXT->last_call : "";

		// if not enabled return
		if($this->settings['enable'] != 'y') return $out;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." edit_entries_additional_celldata: start");

		// fetch language
		$LANG->fetch_language_file('nsm_publish_plus_ext');

		// set row class
		$class = ($nsm_pp_row_i % 2) ? 'tableCellOne' : 'tableCellTwo'; $nsm_pp_row_i++;
		
		if(empty($row['nsm_pp_state'])) $row['nsm_pp_state'] = "un-assigned";

		$out .= "<td class='" . $class . "'><span class='work-state work-state-" . $row['nsm_pp_state'] . "' title='".ucwords($LANG->line($row['nsm_pp_state']))."'>".ucwords($LANG->line($row['nsm_pp_state']))."</span></td>";

		// style those bad boys
		$SESS->cache['lg'][NSM_PP_addon_id]['require_admin_styles'] = TRUE;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." edit_entries_additional_celldata: end");

		return $out;
	}

	/**
	* Method for the publish_form_start hook
	* 
	* - Runs before any data id processed
	* - Sets local $SESS->cache[] array element to store the action
	* - Sets local $SESS->cache[] array element to store the entry_id
	*
	* @param	string $which The current action (new, preview, edit, or save)
	* @param	string $submission_error A submission error if any
	* @param	string $entry_id The current entries id
	* @see		http://expressionengine.com/developers/extension_hooks/publish_form_start/
	* @since	Version 1.0.0
	*/
	function publish_form_start( $which, $submission_error, $entry_id, $hidden )
	{
		if($this->settings['enable'] != 'y') return;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." publish_form_start: start");

		global $DB, $EE, $EXT, $IN, $LANG, $LOC, $REGX, $SESS;

		// fetch language
		$LANG->fetch_language_file('nsm_publish_plus_ext');

		if(empty($entry_id) === TRUE) $entry_id = $IN->GBL("entry_id");

		// save these here... there is no doubt we will need them again.
		$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form'] = TRUE;
		$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_action'] = $which;
		$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry_id'] = $entry_id;
		$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_weblog_id'] = $IN->GBL('weblog_id');

		/**
		* PROCESS THE ACTION
		*/

		// Quicksave
		if($which == "save")
		{
			$this->submit_new_entry_end($entry_id);
			// submitting new entries as drafts is actually a save
			// but we create a draft at the same time
			// so if there is a draft id we don't show the revision message
			if(isset($_GET['draft_id']) === FALSE)
			{
				$SESS->cache['nsm']['msgs']['box'][] = $LANG->line("viewing_published_revision");
			}
			$SESS->cache['nsm']['show_live_look_tab'] = TRUE;
		}
		// Save draft
		elseif($IN->GBL("preview", "POST") == "nsm_pp_draft_submit")
		{
			if($SESS->userdata['nsm_pp_roles'][$_POST['weblog_id']] == "editor")
				$_POST['nsm_pp_state'] = "changed";

			$_GET['draft_id'] = $this->_create_entry_draft($_POST, $entry_id);
		}
		// Submit for approval
		elseif($IN->GBL("preview", "POST") == "nsm_pp_submit_for_approval")
		{
			if($SESS->userdata['nsm_pp_roles'][$_POST['weblog_id']] == "editor")
				$_POST['nsm_pp_state'] = "pending";

			$this->_submit_for_approval($_POST, $entry_id);
			$SESS->cache['nsm']['kill_preview'] = TRUE;
		}
		// Submit note
		elseif($IN->GBL("preview", "POST") =="nsm_pp_note_submit")
		{
			$note = $IN->GBL('nsm_pp_note');
			$this->_create_entry_note($note, $entry_id);
			$_GET["preview_id"] = $this->_create_preview($_POST, $entry_id);
			$SESS->cache['nsm']['kill_preview'] = TRUE;
		}
		// Preview note
		elseif($IN->GBL("preview", "POST") == "nsm_pp_note_preview")
		{
			$note = $IN->GBL('nsm_pp_note');
			$_GET["preview_id"] = $this->_create_preview($_POST, $entry_id);
			$SESS->cache['nsm']['kill_preview'] = TRUE;
		}
		// Standard preview
		elseif($IN->GBL("preview", "POST") == $LANG->line('preview'))
		{
			$SESS->cache['nsm']['show_live_look_tab'] = TRUE;
			if(empty($entry_id) === FALSE)
			{
				$_GET["preview_id"] = $this->_create_preview($_POST, $entry_id);
			}
		}

		/**
		* PROCESS THE ENTRY STATE
		*/
		// if there is an entry id
		if($entry_id != FALSE)
		{
			$draft_id = $IN->GBL("draft_id");
			$version_id = $IN->GBL("version_id");
			$preview_id = $IN->GBL("preview_id");
			$unpublished_draft = FALSE;

			$draft_query = $this->_get_entry_drafts($entry_id);

			// Check for unpublished drafts
			if(
				// if there are drafts
				$draft_query->num_rows > 0
				// and the first draft is later than the last edit
				&& $draft_query->row['created_at'] > $LOC->timestamp_to_gmt($draft_query->row['ee_edit_timestamp'])
			)
			{
				// set a message
				$SESS->cache['nsm']['msgs']['info'][] = $LANG->line("unpublished_drafts");
				$unpublished_draft = TRUE;
			}

			// load draft id
			if($draft_id != FALSE)
			{
				if (isset($draft_query->result[$draft_id]) === TRUE)
				{	
					$_POST['entry_id'] = $entry_id;
					$_POST = $REGX->array_stripslashes(@unserialize($draft_query->result[$draft_id]['draft_data']));
					$SESS->cache['nsm']['msgs']['box'][] = $LANG->line("viewing_unpublished_draft");
					$SESS->cache['nsm']['show_live_look_tab'] = TRUE;
				}
				else
				{
					$SESS->cache['nsm']['msgs']['error'][] = $LANG->line("error_invalid_draft_id");
				}
			}
			// load preview
			elseif($preview_id !== FALSE)
			{
				$preview_query = $this->_get_entry_drafts($entry_id, TRUE);
				if (isset($preview_query->result[$preview_id]) === TRUE)
				{	
					$_POST['entry_id'] = $entry_id;
					$_POST = $REGX->array_stripslashes(@unserialize($preview_query->result[$preview_id]['draft_data']));
					$SESS->cache['nsm']['show_live_look_tab'] = TRUE;
				}
				else
				{
					$SESS->cache['nsm']['msgs']['error'][] = $LANG->line("error_invalid_preview_id");
				}
			}
			// revision messages
			elseif($version_id != FALSE)
			{
				$revision_query = $DB->query("SELECT version_id FROM exp_entry_versioning WHERE entry_id = '" . $entry_id . "' ORDER BY version_date DESC LIMIT 1");

				if($version_id == $revision_query->row['version_id'])
				{
					$SESS->cache['nsm']['msgs']['box'][] = $LANG->line("viewing_published_revision");
				}
				else
				{
					$SESS->cache['nsm']['msgs']['box'][] = $LANG->line("viewing_revision");
				}
				$SESS->cache['nsm']['show_live_look_tab'] = TRUE;
			}
			// load the latest draft unless we are told not to
			elseif($unpublished_draft === TRUE && empty($_POST) === TRUE && $IN->GBL('load_draft') != 'n')
			{
				$_POST['entry_id'] = $entry_id;
				$_GET['draft_id'] = $draft_query->row["draft_id"];
				$_POST = $REGX->array_stripslashes(@unserialize($draft_query->row['draft_data']));
				$SESS->cache['nsm']['msgs']['box'][] = $LANG->line("viewing_unpublished_draft");
				$SESS->cache['nsm']['show_live_look_tab'] = TRUE;
			}
			// else we must be viewing the latest revision
			elseif(empty($_POST) === TRUE)
			{
				$SESS->cache['nsm']['msgs']['box'][] = $LANG->line("viewing_published_revision");
			}
		}

		if($this->debug === TRUE) print("<br />".memory_get_usage()." publish_form_start: end");

	}

	/**
	* Method for the publish_form_headers hook
	* 
	* - Adds content to headers for Publish page
	*
	* @param	string $which The current action (new, preview, edit, or save)
	* @param	string $submission_error A submission error if any
	* @param	string $entry_id The current entries id
	* @param	string $weblog_id The Weblog ID being sent to the form
	* @see		http://expressionengine.com/developers/extension_hooks/publish_form_start/
	* @since	Version 1.0.0
	*/
	function publish_form_headers( $which, $submission_error, $entry_id, $weblog_id )
	{
		global $EXT, $SESS;

		// Check if we're not the only one using this hook
		$out = ($EXT->last_call !== FALSE) ? $EXT->last_call : "";

		if($this->settings['enable'] != "y") return $out;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." publish_form_headers: start");

		$SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_styles'] = TRUE;
		$SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_scripts'] = TRUE;
		
		$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_weblog_id'] = $weblog_id;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." publish_form_headers: end");

		return $out;
	}

	/**
	* Modify the entries data before it reaches the form
	* only fired on edits when the entry content is pulled from the db
	* not fired for quicksaves or previews
	* 
	* @param 	array		$row	The field data
	* @return	array				Manipulated field data
	* @see		http://expressionengine.com/developers/extension_hooks/publish_form_entry_data/
	* @since	Version 1.0.0
	**/
	function publish_form_entry_data( $row )
	{
		global $EXT, $SESS;
		if($EXT->last_call !== FALSE) $row = $EXT->last_call;
		if($this->settings['enable'] != "y") return $row;
		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." publish_form_entry_data: start");
		$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry'] = $row;
		if($this->debug === TRUE) print("<br />".memory_get_usage()." publish_form_entry_data: end");
		return $row;
	}

	/**
	* Adds a new tab to the publish / edit form
	*
	* @param	array $publish_tabs Array of existing tabs
	* @param	int $weblog_id Current weblog id
	* @param	int $entry_id Current entry id
	* @param	array $hidden Hidden form fields
	* @return	array Modified tab list
	* @since 	Version 1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/publish_form_new_tabs/
	*/
	function publish_form_new_tabs( $publish_tabs, $weblog_id, $entry_id, $hidden )
	{
		global $EXT, $LANG, $SESS;

		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $publish_tabs = $EXT->last_call;
		if($this->settings["enable"] != "y") return $publish_tabs;
		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." publish_form_new_tabs: start");

		// fetch language
		$LANG->fetch_language_file('nsm_publish_plus_ext');

		// make the entry_id and which action more manageable
		$entry_id = $SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry_id'];
		$which = $SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_action'];

		if(empty($entry_id) == FALSE)
		{
			$note_query = $this->_get_entry_notes($entry_id);
			$note_count = $note_query->num_rows;
			$draft_query = $this->_get_entry_drafts($entry_id);
			$draft_count = $draft_query->num_rows;
		}
		else
		{
			$note_count = $draft_count = 0;
		}

		$publish_tabs["nsm_pp_notes"] = ucfirst($LANG->line("notes") . " (" . $note_count . ")");
		$publish_tabs["nsm_pp_workflow"] = ucwords($LANG->line("workflow") . " + " . ucfirst($LANG->line("drafts")) . " (".$draft_count.")");

		if($this->debug === TRUE) print("<br />".memory_get_usage()." publish_form_new_tabs: end");

		return $publish_tabs;
	}

	/**
	* Adds the tab content containing all LG Multi Language Pro fields
	*
	* Allows adding of new tabs' blocks to the submission form.
	*
	* @param	int 		$weblog_id The weblog ID for this Publish form
	* @return	string 		Content of the new tab
	* @since 	Version 	1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/publish_form_new_tabs_block/
	*/
	function publish_form_new_tabs_block( $weblog_id )
	{

		global $DB, $DSP, $EXT, $IN, $LANG, $LOC, $REGX, $SESS, $TYPE;

		// Check if we're not the only one using this hook
		$out = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';

		if($this->settings["enable"] != "y") return $out;
		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." publish_form_new_tabs_block: start");

		$LANG->fetch_language_file('nsm_publish_plus_ext');

		// load the Typograhy class for our comments
		if ( ! class_exists('Typography')) require PATH_CORE.'core.typography'.EXT;
		$TYPE = new Typography;

		$note_prefs = array(
			'text_format' 	=> 'xhtml',
			'html_format' 	=> 'safe',
			'auto_links' 	=> 'y',
			'allow_img_url' => 'y'
		);

		// make the entry_id and which action more manageable
		$entry_id = $SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry_id'];
		$which = $SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_action'];

		// if this is an edit and there is no post
		// post will not be empty if we are loading a draft
		if($SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_action'] == "edit" && empty($_POST) === TRUE)
		{
			$status = $SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry']['status'];
			$state = $SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry']['nsm_pp_state'];
		}
		// we are either loading a draft, this is a save or a new entry
		// either way test for a post or set the var to blank
		// now we are covered in all cases
		else
		{
			$status = (isset($_POST['status']) === TRUE) ? $REGX->form_prep($_POST['status']) : "";
			$state = (isset($_POST['nsm_pp_state']) === TRUE) ? $REGX->form_prep($_POST['nsm_pp_state']) : "";
		}

		// start the tab
		//$out .= "<!-- START NSM Publish Plus Workflow + Drafts Tab -->";
		$out .= '<div id="blocknsm_pp_workflow" class="nsm-tab-block">';
		$out .= '<div class="publishTabWrapper">';	
		$out .= '<div class="publishBox">';
		$out .= '<div class="publishInnerPad">';
		$out .= "<div class='clusterBox'>";

		$out .= "<h5>".ucfirst($LANG->line("entry_state"))."</h5>";
		$out .= "<p>".$LANG->line("workflow_info")."</p>";
		$out .= "<p>".ucfirst($LANG->line("entry_state")).": ";

		// create a couple of hidden vars to track the old status and state
		// we use these when we send out notifications
		$out .= NL."<input type='hidden' name='old_status' value='".$status."' />";
		$out .= NL."<input type='hidden' name='old_state' value='".$state."' />";

		if($SESS->userdata["nsm_pp_roles"][$weblog_id] == "publisher")
		{
			$out .= "<select name='nsm_pp_state'>";
			$out .= "<option></option>";
			$out .= "<option value='pending'".(($state == 'pending') ? " selected='selected'" : '').">".ucfirst($LANG->line('pending'))."</option>";
			$out .= "<option value='approved'".(($state == 'approved') ? " selected='selected'" : '').">".ucfirst($LANG->line('approved'))."</option>";
			$out .= "<option value='denied'".(($state == 'denied') ? " selected='selected'" : '').">".ucfirst($LANG->line('denied'))."</option>";
			$out .= "<option value='changed'".(($state == 'changed') ? " selected='selected'" : '').">".ucfirst($LANG->line('changed'))."</option>";
			$out .= "</select>";
		}
		else
		{
			$out .= "<span class='".$state."'>".(($state == FALSE) ?  "<strong class='box'>Workflow state will be automatically set when the entry is saved as a draft or submitted for approval</strong>" : ucwords($LANG->line($state)))."</span>";
		}
		$out .= "</p>";

		$out .= "<h5>".ucfirst($LANG->line("drafts"))."</h5>";
		$out .= "<p>".$LANG->line("draft_info")."</p>";
		
		$drafts_exist 	= FALSE;
		$draft_num		= $IN->GBL('draft_num');
		$draft_id		= $IN->GBL('draft_id');

		if (is_numeric($entry_id))
		{
			$draft_query = $this->_get_entry_drafts($entry_id);

			if ($draft_query->num_rows > 0)
			{
				$drafts_exist = TRUE;

				$out .= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));
				$out .= $DSP->table_row(array(
										array('text' => ucwords($LANG->line('state')), 'class' => 'tableHeading'),
											array('text' => $LANG->line('id'), 'class' => 'tableHeading'),
											array('text' => ucwords($LANG->line('title')), 'class' => 'tableHeading'),
											array('text' => ucwords($LANG->line('date')), 'class' => 'tableHeading'),
											array('text' => ucwords($LANG->line('author')), 'class' => 'tableHeading'),
											array('text' => ucwords($LANG->line('load_draft')), 'class' => 'tableHeading'),
											array('text' => ucwords($LANG->line('edit_notes')), 'class' => 'tableHeading')
											)
									);

				$i = 0;
				$j = $draft_query->num_rows;

				$count = 1;
				foreach($draft_query->result as $row)
				{
					$revlink = $DSP->anchor(BASE.AMP.'C=edit'.AMP.'M=edit_entry'.AMP.'weblog_id='.$weblog_id.AMP.'entry_id='.$entry_id.AMP.'draft_id='.$row['draft_id'].AMP.'draft_num='.$j, ucwords($LANG->line('load_draft')));

					if ($row['draft_id'] == $draft_id)
					{
						$revlink .= " &nbsp; <span class='highlight'>" .  $LANG->line('current_rev') . "</span>";
					}

					$class = ($i % 2) ? 'tableCellOne' : 'tableCellTwo'; $i++;

					$draft_data = $REGX->array_stripslashes(unserialize($row['draft_data']));

					if(isset($draft_data["nsm_pp_state"]) === FALSE)
					{
						$draft_data["nsm_pp_state"] = "";
					}

					// quick fix for old drafts that used "dirty" instead of changed
					if($draft_data["nsm_pp_state"] == "dirty")
					{
						$draft_data["nsm_pp_state"] = "changed";
					}

					$note_link = (empty($draft_data["draft_note"]) === FALSE) ? "<a href='#'>".ucwords($LANG->line("edit_notes"))."</a>" : "&nbsp;";

					$out .= "<tr class='draft'>"
						. NL . "<td class='".$class."'><span class='work-state work-state-" . $draft_data['nsm_pp_state'] . "' title='".ucwords($LANG->line($draft_data['nsm_pp_state']))."'>".ucwords($LANG->line($draft_data['nsm_pp_state']))."</span></td>" 
						. NL . "<td class='".$class."'>".$row['draft_id']."</td>" 
						. NL . "<td class='".$class."'>".$draft_data['title'] . "&nbsp;"."</td>" 
						. NL . "<td class='".$class."'>".$LOC->set_human_time($row['created_at'])."</td>" 
						. NL . "<td class='".$class."'><a href='".BASE."&C=myaccount&id=".$row["author_id"]."'>" . ((empty($row['screen_name']) === FALSE) ? $row['screen_name'] : $row['username']) . "</a></td>" 
						. NL . "<td class='".$class."'>".$revlink."</td>" 
						. NL . "<td class='".$class." note-trigger'>".$note_link."</td>" 
					 . NL . "</tr>";
					$out .= NL . "<tr class='notes'><td colspan='7' style='border-top:1px dotted #ccc; margin-top:-1px;' class='".$class."'>".((empty($draft_data["draft_note"]) === FALSE) ? "<p><strong>".ucfirst($LANG->line("edit_notes")).":</strong></p>" . $TYPE->parse_type( $draft_data['draft_note'], $note_prefs) : "<p class='highlight'>" . $LANG->line("no_draft_notes_exist") . "</p>" )."</td></tr>";
					$j--;
				} // End foreach
	
				$out .= $DSP->table_close();
			}
		}
		
		if ($drafts_exist == FALSE)
		{
			$out .= "<p class='highlight'>". $LANG->line('no_drafts_exist') . "</p>";
		}

		$out .= NL."<h5>".ucfirst($LANG->line("edit_notes"))."</h5>";
		$out .= NL."<p>".$LANG->line("edit_notes_info")."</p>";
		
		if(isset($_POST["draft_note"]) === FALSE || ($IN->GBL("preview", "POST") == "nsm_pp_submit_for_approval" || $IN->GBL("preview", "POST") == "nsm_pp_draft_submit"))
		{
			$draft_note = "";
		}
		else
		{
			 $draft_note = $REGX->form_prep($_POST["draft_note"]);
		}

		$out .= NL."<textarea class='textarea' style='width:99%' rows='10' name='draft_note'>".$draft_note."</textarea>";

		$out .= $DSP->div_c();
		$out .= $DSP->div_c();
		$out .= $DSP->div_c();
		$out .= $DSP->div_c();  
		$out .= $DSP->div_c();

		$out .= NL."<!-- END NSM Publish Plus Workflow + Drafts Tab -->";
		$out .= NL."<!-- Start NSM Publish Plus Notes Tab -->";

		$out .= NL.'<div id="blocknsm_pp_notes" class="nsm-tab-block">';
		$out .= NL.'<div class="publishTabWrapper">';	
		$out .= NL.'<div class="publishBox">';
		$out .= NL.'<div class="publishInnerPad">';
		$out .= NL."<div class='clusterBox'>";

		if(empty($entry_id) === FALSE)
		{
			$note_query = $this->_get_entry_notes($entry_id);
			$notes = $note_query->result;
			$note_count = $note_query->num_rows;
		}
		else
		{
			$notes = array();
			$note_count = 0;
		}

		$out .= "<h5>Notes</h5>
				<div class='comments'>
					<div class='comments-wrapper'>";

		$note_prefs = array(
			'text_format' 	=> 'xhtml',
			'html_format' 	=> 'safe',
			'auto_links' 	=> 'y',
			'allow_img_url' => 'y'
		);

		if(empty($notes) === FALSE)
		{
			$out .= NL."<ol>";
			foreach ($notes as $note)
			{
				$out .= "<li class='comment'>
							<p class='author'><strong><a href='".BASE."&C=myaccount&id=".$note["author_id"]."'>" . ((empty($note['screen_name']) === FALSE) ? $note['screen_name'] : $note['username']) . "</a> <small>" . $LOC->set_human_time($note['created_at']) . "</small></strong></p>
							<div>" . $TYPE->parse_type( $note['note'], $note_prefs) . "</div>
						</li>";
			}
			$out .= NL."</ol>";
		}
		else
		{
			$out .= "<p class='highlight'>".$LANG->line("no_notes_warning").".</p>";
		}

		// note preview?
		$note = $IN->GBL('nsm_pp_note');
		if($IN->GBL("preview", "POST") == "nsm_pp_note_preview")
		{
			$out .= "<ol><li class='comment preview'>
						<p class='preview'><strong>".$LANG->line("preview").":</strong></p>
						<p class='author'><strong><a href='".BASE."&C=myaccount&id=".$SESS->userdata['member_id']."'>" . ((empty($SESS->userdata['screen_name']) === FALSE) ? $SESS->userdata['screen_name'] : $SESS->userdata['username']) . "</a> <small>" . $LOC->set_human_time($LOC->now) . "</small></strong></p>
						<div>".$TYPE->parse_type($note, $note_prefs)."</div>
					</li></ol>";
		}

		// note form
		$out .= "<div class='new-comment'>
					<label for='nsm_pp_note'><strong>".ucfirst($LANG->line("leave_a_note")).":</strong></label>
					<div><textarea class='textarea' id='nsm_pp_note' name='nsm_pp_note'>".$REGX->form_prep($note)."</textarea></div>
				</div>";

		// note buttons
		$out .= "<p class='submitBox'>
					<button type='submit' name='preview' value='nsm_pp_note_submit'>".$LANG->line('add_this_note')."</button>
					<button type='submit' name='preview' value='nsm_pp_note_preview'>".$LANG->line('preview_note')."</button>
				</p>";

		$out .= $DSP->div_c();
		$out .= $DSP->div_c();
		$out .= $DSP->div_c();
		$out .= $DSP->div_c();
		$out .= $DSP->div_c();  
		$out .= $DSP->div_c();  
		$out .= $DSP->div_c();

		$out .= "<!-- END NSM Publish Plus Tab -->";

		if($this->debug === TRUE) print("<br />".memory_get_usage()." publish_form_new_tabs_block: end");

		return $out;
	}

	/**
	* Method for the submit_new_entry_start hook
	* 
	* Runs before a new entry is submitted to the DB. We check to see if the user is trying to update the xml or preview.
	*
	* @since 	Version 	1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/submit_new_entry_start/
	*/
	function submit_new_entry_start()
	{
		if($this->settings['enable'] != "y") return;
		if($this->debug === TRUE) print("<br />".memory_get_usage()." submit_new_entry_start");

		global $DB, $EE, $EXT, $IN, $LANG, $LOC, $OUT, $PREFS, $SESS;
		
		$LANG->fetch_language_file("nsm_publish_plus_ext");

		$show_publish_form = FALSE;

		$entry_id = $_GET['entry_id'] = $IN->GBL('entry_id');
		$weblog_id = $IN->GBL('weblog_id');

		$SESS->cache['nsm'][NSM_PP_addon_id]['new_entry'] = FALSE;

		// New entry
		if(empty($entry_id) === TRUE)
		{
			$SESS->cache['nsm'][NSM_PP_addon_id]['new_entry'] = TRUE;
			if($SESS->userdata["nsm_pp_roles"][$_POST["weblog_id"]] == "editor")
			{
				$weblog_query = $DB->query("SELECT deft_status FROM exp_weblogs WHERE weblog_id = " . $weblog_id);
				if($weblog_query->row["deft_status"] == "open") $weblog_query->row["deft_status"] = "closed";
				$_POST["draft_status"] = $_POST["status"];
				$_POST["status"] = $weblog_query->row["deft_status"];
			}
		}
	}

	/**
	* Method for the submit_new_entry_end hook
	* 
	* - Runs after a new entry has been validated and created in the database
	* - Manipulates data from the posted custom field ready for DB insert
	* - Checks to see if the record was created properly
	*
	* @param	int		$entry_id 		The saved entry id
	* @param	array	$data 			Array of data about entry (title, url_title)
	* @param	string	$ping_message	Error message if trackbacks or pings have failed to be sent
	* @see		http://expressionengine.com/developers/extension_hooks/submit_new_entry_end/
	* @since	Version 1.0.0
	*/
	function submit_new_entry_end( $entry_id, $data = array(), $ping_message = "" )
	{
		if($this->settings['enable'] != "y") return;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." submit_new_entry_end: start");

		global $DB, $EE, $EXT, $IN, $LANG, $PREFS, $SESS;

		$LANG->fetch_language_file("nsm_publish_plus_ext");

		if(isset($_POST["draft_status"]) === TRUE)
		{
			$_POST["status"] = $_POST["draft_status"];
		}

		if($IN->GBL("save", "POST") == "nsm_pp_draft_submit")
		{
			if($SESS->userdata['nsm_pp_roles'][$_POST['weblog_id']] == "editor") $_POST['nsm_pp_state'] = "changed";
			$_GET['draft_id'] = $this->_create_entry_draft($_POST, $entry_id);
		}
		elseif($IN->GBL("save", "POST") == "nsm_pp_submit_for_approval")
		{
			if($SESS->userdata['nsm_pp_roles'][$_POST['weblog_id']] == "editor") $_POST['nsm_pp_state'] = "pending";
			$this->_submit_for_approval($_POST, $entry_id);
		}
		else
		{
			$this->_create_entry_draft($_POST, $entry_id, FALSE);
			$SESS->cache['nsm']['msgs']['success'][] = $LANG->line("success_revision_created");
			$DB->query($DB->update_string("exp_weblog_titles", array("nsm_pp_state" => $_POST['nsm_pp_state']), array("entry_id" => $entry_id)));
		}

		if($SESS->cache['nsm'][NSM_PP_addon_id]['new_entry'] == TRUE)
		{
			$this->_send_notifications("create_entry", $entry_id);
		}
		else
		{
			$this->_send_notifications("create_revision", $entry_id);
		}

		if($this->debug === TRUE) print("<br />".memory_get_usage()." submit_new_entry_end: end");

	}

	/** 
	* Runs after an entry is deleted
	*
	* @see		http://expressionengine.com/developers/extension_hooks/delete_entries_start/
	* @since	Version 1.0.0
	*/
	function delete_entries_start()
	{
		global $DB, $SESS;

		$entry_ids = FALSE;

		$SESS->cache['nsm'][NSM_PP_addon_id]['delete_entries_start'] = array();

		foreach ($_POST as $key => $val)
		{        
			if (strstr($key, 'delete') AND ! is_array($val) AND is_numeric($val))
			{                    
				$entry_ids[] = $DB->escape_str($val);
			}
		}

		// if we have entry ids
		if($entry_ids != FALSE)
		{
			// go get em tiger...
			$query = $DB->query("SELECT t.*, w.*, m.email, m.username, m.screen_name, s.site_label, s.site_description
				FROM `exp_weblog_titles` as t 
				INNER JOIN `exp_weblogs` as w ON t.weblog_id = w.weblog_id
				INNER JOIN `exp_members` as m ON t.author_id = m.member_id
				INNER JOIN `exp_sites`	as s ON t.site_id = s.site_id
				WHERE entry_id IN (".implode(',',$entry_ids).")"
			);
			foreach ($query->result as $row)
			{
				$SESS->cache['nsm'][NSM_PP_addon_id]['delete_entries_start'][$row['entry_id']] = $row;
			}
		}
	}

	/** 
	* Runs after an entry is deleted
	*
	* @param	integer			$entry_id		Entry ID for entry being deleted during this loop
	* @param	integer			$weblog_id		Weblog ID for entry being deleted
	* @see		http://expressionengine.com/developers/extension_hooks/delete_entries_loop/
	* @since	Version 1.0.0
	*/
	function delete_entries_loop( $entry_id, $weblog_id )
	{
		// for each of the entry_ids
		global $DB, $SESS;
		$DB->query("DELETE from exp_nsm_entry_drafts WHERE entry_id = '".$entry_id."'");
		$DB->query("DELETE from exp_nsm_notes WHERE entry_id = '".$entry_id."'");
		$this->_send_notifications("delete_entry", $SESS->cache['nsm'][NSM_PP_addon_id]['delete_entries_start'][$entry_id]);
	}

	/**
	* Takes the control panel html before it is sent to the browser
	*
	* @param	string $out The control panel html
	* @return	string The modified control panel html
	* @see		http://expressionengine.com/developers/extension_hooks/show_full_control_panel_end/
	* @since	Version 1.0.0
	*/
	function show_full_control_panel_end( $out )
	{
		global $DB, $EXT, $IN, $LANG, $PREFS, $REGX, $SESS;

		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $out = $EXT->last_call;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." show_full_control_panel_end: start");

		$js = $css = '';

		// grab the lanugage files
		$LANG->fetch_language_file("nsm_publish_plus_ext");
		$LANG->fetch_language_file("publish");

		$entry_id = @$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_entry_id'];
		$weblog_id = @$SESS->cache['nsm'][NSM_PP_addon_id]['publish_form_weblog_id'];

		// finally add the admin styles
		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_styles']))
		{
			$css .= "\n<link rel='stylesheet' type='text/css' media='screen' href='" . $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/nsm_publish_plus/css/admin.css' />";
		}

		if($SESS->cache['nsm']['kill_preview'] === TRUE)
		{
			$css .= '<style type="text/css" media="screen">fieldset.previewBox{display:none}</style>';
		}

		// finally add the admin styles
		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_scripts']) === TRUE)
		{

			$sql = "SELECT v.author_id, v.version_id, v.version_date, m.screen_name
					FROM exp_entry_versioning AS v, exp_members AS m
					WHERE v.entry_id = '{$entry_id}' 
					AND v.author_id = m.member_id
					ORDER BY v.version_id desc";
					
			$revquery = $DB->query($sql);
			$revision_ids = array();
			if ($revquery->num_rows > 0)
			{
				foreach($revquery->result as $row)
				{
					$revision_ids[] = $row["version_id"];
				}
			}

			$js .= "<script type='text/javascript' charset='utf-8'>
	if(lg == undefined) var lg = {lang: {}};
	lg.lang.remove_template_confirmation = '" . $LANG->line("remove_template_confirmation")."'+\"\\n\\n\"+'".$LANG->line("changes_wil_not_take_affect") . "';
	lg.lang.currently_loaded = '".$LANG->line('current_rev')."';
	lg.lang.currently_live = '".$LANG->line("currently_live")."';
	lg.lang.revision_warning = '".$LANG->line('revision_warning')."';
	lg.lang.draft_warning = '".$LANG->line('draft_warning')."';
	lg.lang.no_draft_edit_note = '".$LANG->line('no_draft_edit_note')."';
	var entry_id = '".$entry_id."';
	var weblog_id = '".$weblog_id."';
	draft_id = '".$IN->GBL('draft_id')."';
	var revision_ids = [".implode(",", $revision_ids)."];
	var rev_link_url = '" . BASE."&C=edit&M=edit_entry&weblog_id=".$weblog_id."&entry_id=".$entry_id."&version_id='+revision_ids[0]+'&version_num='+revision_ids.length;
	var preview_val = '".$IN->GBL("preview")."';
</script>";

			$js .= "\n".'<script type="text/javascript" charset="utf-8" src="'. $PREFS->ini("theme_folder_url", 1) . "cp_themes/".$PREFS->ini("cp_theme").'/nsm_publish_plus/js/admin.js"></script>';
		}

		$out = str_replace("</head>", $css . "\n</head>", $out);
		$out = str_replace("</body>", $js . "\n</body>", $out);

		$out = str_replace("id='contentNB'>", "id='contentNB'>".$this->_render_nsm_messages(), $out);

		// update buttons
		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['publish_form']) === TRUE)
		{
			$preview_btn = "<input name='preview' type='submit' class='submit' value='".$LANG->line("preview")."'  />";
			$quicksave_btn = "<input name='save' type='submit' class='submit' value='".$LANG->line("quick_save")."'  />";
			$submit_btn = "<input name='submit' type='submit' class='submit' value='".$LANG->line("submit")."'  />";
			$update_btn = "<input name='submit' type='submit' class='submit' value='".$LANG->line("update")."'  />";
			$save_revision_btn = "<input name='submit' type='submit' class='submit' value='".$LANG->line("save_revision")."'  />";
			$quick_save_revision_btn = "<input name='save' type='submit' class='submit' value='".$LANG->line("quicksave_revision")."'  />";
			$save_as_draft_btn = "<button name='".($entry_id ? "preview" : "save")."' value='nsm_pp_draft_submit' type='submit' class='submit'>".$LANG->line("save_as_draft")."</button>";
			$submit_for_approval_btn = "<button name='".($entry_id ? "preview" : "save")."' value='nsm_pp_submit_for_approval' type='submit' class='submit'>".$LANG->line("submit_for_approval")."</button>";

			if($SESS->userdata['nsm_pp_roles'][$weblog_id] == "publisher")
			{
				$out = str_replace($preview_btn, $preview_btn . " ". $save_as_draft_btn, $out);
				$out = str_replace(array($submit_btn, $update_btn), $save_revision_btn, $out);
				$out = str_replace($quicksave_btn, $quick_save_revision_btn, $out);
			}
			elseif($SESS->userdata['nsm_pp_roles'][$weblog_id] == "editor")
			{
				$out = str_replace($preview_btn, $preview_btn . " ". $save_as_draft_btn, $out);
				$out = str_replace(array($submit_btn, $update_btn), $submit_for_approval_btn, $out);
				$out = str_replace($quicksave_btn, "", $out);
			}

			$out = str_replace('<td style="width:350px;padding-top: 4px;"', '<td id="action-buttons" style="padding-top: 4px;"', $out);

			if(preg_match("/<div class='submitBox' >(.*?)<\/div>/mis", $out, $matches))
			{
				$out = str_replace($matches[0], str_replace("&nbsp;", "", $matches[0]), $out);
			}
		}

		if($this->debug === TRUE) print("<br />".memory_get_usage()." show_full_control_panel_end: end");

		return $out;

	}

	/**
	* Allows adding of preferences to CP side preferences form
	*
	* @see		http://expressionengine.com/developers/extension_hooks/myaccount_edit_preferences/
	* @since	Version 1.0.0
	*/
	function myaccount_edit_preferences( $out )
	{
		global $DB, $DSP, $EXT, $IN, $PREFS, $LANG, $SESS;

		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $out = $EXT->last_call;

		// if not enabled return
		if($this->settings['enable'] != 'y' || $SESS->userdata["group_id"] != 1) return $out;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." myaccount_edit_preferences");

		$LANG->fetch_language_file('nsm_publish_plus_ext');

		$settings = $this->settings;

		$query = $DB->query("SELECT * FROM `exp_members` WHERE `member_id` = " . $IN->GBL('id', 'GET') . " LIMIT 1");

		$out .= $DSP->table_c();

		$out .= $DSP->table('tableBorder', '0', '10', '100%; margin-top:9px');

		$out .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $this->name
			. $DSP->td_c()
			. $DSP->tr_c();

		$roles_query = $DB->query("SELECT * FROM exp_nsm_acl_roles
								WHERE `site_id` = " . $PREFS->ini("site_id") . "
								AND `member_id` = ".$IN->GBL('id', 'GET')."
								AND `class_name` = '".__CLASS__."'");

		$sorted_roles = array();
		foreach ($roles_query->result as $role)
		{
			$sorted_roles[$role['weblog_id']] = $role;
		}

		$weblogs_query = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = " . $PREFS->ini('site_id'));

		$i = 0;

		foreach ($weblogs_query->result as $weblog)
		{
			$role = @$sorted_roles[$weblog["weblog_id"]]['role'];

			$class = ($i % 2) ? 'tableCellTwo':'tableCellOne';
			
			$out .= "<tr>\n<td class='".$class."'>".$weblog["blog_title"]."</td>";

			$out .= "\n<td class='".$class."'>\n<select name='nsm_pp_weblog_roles[".$weblog['weblog_id']."]'>"
				. $DSP->input_select_option('', ucfirst($LANG->line("member_group_defaults")), ($role == "") ? "y" : "" )
				. $DSP->input_select_option('no_access', 'No Access', ($role == "no_access") ? "y" : "" )
				. $DSP->input_select_option('publisher', 'Publisher', ($role == "publisher") ? "y" : "" )
				. $DSP->input_select_option('editor', 'Editor', ($role == "editor") ? "y" : "" )
				. $DSP->input_select_footer();

			$out .= "\n</td>\n</tr>";
			$i++;
		}

		$out .= $DSP->table_c();

		$out .= $DSP->table('tableBorder', '0', '10', '100%; margin-top:9px; border-top:1px solid #CAD0D5');

		return $out;
	}

	/**
	* Allows updating of added preferences via CP side preferences form
	*
	* @param	string	$data	Array of data from data insert
	* @see		http://expressionengine.com/developers/extension_hooks/myaccount_update_preferences/
	* @since	Version 1.0.0
	*/
	function myaccount_update_preferences( $data )
	{
		global $DB, $IN, $EXT, $PREFS, $SESS;

		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $data = $EXT->last_call;

		if($this->settings['enable'] != 'y' || $SESS->userdata["group_id"] != 1) return $data;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." myaccount_update_preferences");

		$DB->query("DELETE FROM `exp_nsm_acl_roles`
						WHERE `site_id` = " . $PREFS->ini("site_id") . "
						AND `member_id` = ".$_POST['id']."
						AND `class_name` = '".__CLASS__."'");

		foreach ($_POST["nsm_pp_weblog_roles"] as $weblog_id => $role)
		{
			$ins_data = array(
				"member_id" => $_POST['id'],
				"class_name" => __CLASS__,
				"site_id" => $PREFS->ini("site_id"),
				"weblog_id" => $weblog_id,
				"role" => $role
			);
			$DB->query($DB->insert_string("exp_nsm_acl_roles", $ins_data));
		}
		return $data;
	}

	/**
	* Take the entry data, do what you wish
	* 
	* @param	$weblog		Weblog object
	* @param	$row		Row data
	* @since 	Version 1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/weblog_entries_query_result/
	*/
	function weblog_entries_query_result($weblog, $weblog_query)
	{
		global $DB, $EXT, $LOC, $SESS;
		if($EXT->last_call !== FALSE) $query = $EXT->last_call;
		if($SESS->cache['nsm'][NSM_PP_addon_id]["preview_data"] != FALSE)
		{
			foreach ($weblog_query->result as $key => $row)
			{
				if($row["entry_id"] == $SESS->cache['nsm'][NSM_PP_addon_id]["preview_data"]["entry_id"])
				{
					$data = $SESS->cache['nsm'][NSM_PP_addon_id]["preview_data"]["data"];

					if($data["author_id"] != $weblog_query->result[$key]["author_id"])
					{
						$author_query = $DB->query("SELECT * FROM exp_members WHERE member_id = ".$data["author_id"]." LIMIT 1");
						if($author_query->num_rows > 0)
						{
							$data = array_merge($data, $author_query->row);
						}
					}

					$data["entry_date"] = $LOC->convert_human_date_to_gmt($data["entry_date"]);
					$data["expiration_date"] = $LOC->convert_human_date_to_gmt($data["expiration_date"]);
					$data["comment_expiration_date"] = $LOC->convert_human_date_to_gmt($data["comment_expiration_date"]);
					$data["year"] = date('Y', $data["entry_date"]);
					$data["month"] = date('m', $data["entry_date"]);
					$data["day"] =  date('d', $data["entry_date"]);

					unset($data["category"]);
					unset($data["lg_bm"]);

					/*
					print("<pre style='font-size:10px; float:left; width:50%'>");
					print_r($weblog_query->result[$key]);
					print("</pre>");
					print("<pre style='font-size:10px; float:left; width:50%'>");
					print_r($data);
					print("</pre><br style='clear:both' />");
					*/

					$weblog_query->result[$key] = array_merge($row, $data);
					
				}
			}
		}
		return $weblog_query;
	}

	/**
	* Builds the settings form
	* 
	* @since	Version 1.0.0
	* @see		http://ee.docs/development/extensions.html#settings
	**/
	function settings_form( $install_settings )
	{

		global $DB, $DSP, $IN, $LANG, $PREFS, $REGX, $SESS;

		if($this->debug === TRUE) print("<br /><br />".memory_get_usage()." settings_form: start");

		$LANG->fetch_language_file('nsm_publish_plus_ext');

		$default_settings = $this->_get_default_extension_settings();
		$settings = (isset($install_settings[$PREFS->ini('site_id')]) === TRUE) ? array_merge($default_settings, $install_settings[$PREFS->ini('site_id')]) : $default_settings;

		// breadcrumb
		$DSP->crumbline = TRUE;
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
		$DSP->crumb .= $DSP->crumb_item($this->name . " v" . $this->version);

		// button
		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		// meta title
		$DSP->title  = $LANG->line('extension_settings') . " | " . $this->name . " v" . $this->version;

		$DSP->body = '';

		// PAGE TITLE
		$DSP->body .= $DSP->heading($this->name . " <small>v".$this->version."</small>");

		$DSP->body .= $DSP->form_open(
								array(
									'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings'
								),
								// WHAT A M*THERF!@KING B!TCH THIS WAS
								// REMEMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
								// BUG??
								array('name' => strtolower(get_class($this)))
		);

		// EXTENSION ACCESS
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $LANG->line("access_title")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableCellOne', '30%')
			. $DSP->qdiv('defaultBold', $LANG->line('enable_extension_for_this_site_label'))
			. $DSP->td_c();

		$DSP->body .= $DSP->td('tableCellOne')
			. "<select name='enable'>"
				. $DSP->input_select_option('y', "Yes", (($settings['enable'] == 'y') ? 'y' : '' ))
				. $DSP->input_select_option('n', "No", (($settings['enable'] == 'n') ? 'y' : '' ))
				. $DSP->input_select_footer()
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->table_c();

		// GROUP SETTINGS
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '3')
			. $LANG->line("group_settings_title")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '3')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . str_replace("weblog", $PREFS->ini("weblog_nomenclature"), $LANG->line('group_settings_info')) . "</div>"
			. $DSP->td_c()
			. $DSP->tr_c();

		$groups = $DB->query("SELECT * FROM exp_member_groups WHERE `site_id` = " . $PREFS->ini("site_id"));

		$i = 0;

		$weblogs_query = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = " . $PREFS->ini('site_id') . " ORDER by blog_title");

		foreach($groups->result as $group)
		{
			$class = ($i % 2) ? 'tableCellTwo':'tableCellOne';

			$group_settings = isset($this->settings['nsm_pp_group_weblog_role'][$group['group_id']]) ? $this->settings['nsm_pp_group_weblog_role'][$group['group_id']] : array();

			$DSP->body .= $DSP->tr()
				. "<td class='".$class."' rowspan='".$weblogs_query->num_rows."' width='30%'>"
				. $DSP->qdiv('defaultBold', $group['group_title']);
				
			$j = 0;
			foreach ($weblogs_query->result as $weblog)
			{
				if($j != 0)
				{
					$DSP->body .= "<tr>";
				}
				$DSP->body .= "\n<td class='".$class."'><div>".$weblog["blog_title"]."</div></td>";

				$DSP->body .= "\n<td class='".$class."'>\n<select name='nsm_pp_group_weblog_role[".$group['group_id']."][".$weblog['weblog_id']."]'>"
					. $DSP->input_select_option('no_access', 'No Access', (@$group_settings[$weblog['weblog_id']] == "") ? "y" : "" )
					. $DSP->input_select_option('publisher', 'Publisher', (@$group_settings[$weblog['weblog_id']] == "publisher") ? "y" : "" )
					. $DSP->input_select_option('editor', 'Editor', (@$group_settings[$weblog['weblog_id']] == "editor") ? "y" : "" )
					. $DSP->input_select_footer();

				$DSP->body .= "\n</td>\n</tr>";
				$j++;
			}
			$i++;
		}

		$DSP->body .= $DSP->table_c();

		$weblogs_query = $DB->query($sql = "SELECT w.blog_title, w.weblog_id, s.status, s.status_id
								FROM exp_weblogs AS w
								LEFT JOIN exp_statuses AS s ON w.status_group = s.group_id
								WHERE w.site_id = ".$PREFS->ini('site_id')."
								ORDER BY w.blog_title, s.status_order"
							);
		$i = 0;

		foreach($weblogs_query->result as $row)
		{
			$sorted_weblogs[$row['weblog_id']]['weblog_id'] = $row['weblog_id'];
			$sorted_weblogs[$row['weblog_id']]['blog_title'] = $row['blog_title'];
			$sorted_weblogs[$row['weblog_id']]['statuses'][$row['status_id']] = $row['status'];
		}

		// NOTIFICATION SETTINGS
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%', 'id' => 'notification_templates'));

		$DSP->body .= "<thead>";
		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '4')
			. $LANG->line("notification_settings_title")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '4')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . str_replace("weblog", $PREFS->ini("weblog_nomenclature"), $LANG->line('notification_settings_info')) . "</div>"
			. $DSP->td_c()
			. $DSP->tr_c();
		$DSP->body .= '<tr>
			<th class="tableHeadingAlt">Filter</th>
			<th class="tableHeadingAlt" style="width:350px">Email Notification</th>
			<th class="tableHeadingAlt">Recipients</th>
			<th class="tableHeadingAlt" style="width:20px">&nbsp;</th>
		</tr>';
		$DSP->body .= "</thead>";
		$DSP->body .= "<tbody id='templates'>";

		$templates = $DB->query("SELECT * FROM `exp_nsm_pp_notification_templates` WHERE `site_id` = " . $PREFS->ini("site_id"));
		$i = 0;

		foreach($templates->result as $row)
		{
			$class = ($i % 2) ? 'tableCellTwo':'tableCellOne';
			$DSP->body .= $this->_build_notification_form_row($i, $class, $sorted_weblogs, $groups, $row);
			$i++;
		}

		if($templates->num_rows == 0)
		{
			$DSP->body .= $this->_build_notification_form_row($i, $class, $sorted_weblogs, $groups);
		}

		$DSP->body .= "</tbody>";
		$DSP->body .= $DSP->table_c();
		$DSP->body .= "<p><a href='#' id='add-template'>".$LANG->line("add_template")."</a></p>";

		// Triggers
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'))
			. $DSP->tr()
			. $DSP->td('tableHeading', '', '2') . $LANG->line("url_triggers_title") . $DSP->td_c()
			. $DSP->tr_c()
			. $DSP->tr()
			. $DSP->td('', '', '2') . "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('url_triggers_info') . "</p></div>" . $DSP->td_c()
			. $DSP->tr_c()
			. $DSP->tr()
			. $DSP->td('tableCellOne', '30%') . $DSP->qdiv('defaultBold', $LANG->line("draft_trigger_label")) . $DSP->td_c()
			. $DSP->td('tableCellOne') . $DSP->input_text("draft_trigger", $settings['draft_trigger'], '', '') . $DSP->td_c()
			. $DSP->tr_c()
			. $DSP->tr()
			. $DSP->td('tableCellTwo', '30%') . $DSP->qdiv('defaultBold', $LANG->line("revision_trigger_label")) . $DSP->td_c()
			. $DSP->td('tableCellTwo') . $DSP->input_text("revision_trigger", $settings['revision_trigger'], '', '') . $DSP->td_c()
			. $DSP->tr_c()
			. $DSP->tr()
			. $DSP->td('tableCellOne', '30%') . $DSP->qdiv('defaultBold', $LANG->line("preview_trigger_label")) . $DSP->td_c()
			. $DSP->td('tableCellOne') . $DSP->input_text("preview_trigger", $settings['preview_trigger'], '', '') . $DSP->td_c()
			. $DSP->tr_c()
			. $DSP->table_c();

		// UPDATES
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '2')
			. $LANG->line("check_for_updates_title")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '2')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('check_for_updates_info') . "</p></div>"
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableCellOne', '30%')
			. $DSP->qdiv('defaultBold', $LANG->line("check_for_updates_label"))
			. $DSP->td_c()
			. $DSP->td('tableCellOne')
			. "<select name='check_for_updates'>"
				. $DSP->input_select_option('y', "Yes", (($settings['check_for_updates'] == 'y') ? 'y' : '' ))
				. $DSP->input_select_option('n', "No", (($settings['check_for_updates'] == 'n') ? 'y' : '' ))
				. $DSP->input_select_footer()
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->table_c();

		$DSP->body .= $DSP->qdiv('itemWrapperTop', $DSP->input_submit())
					. $DSP->form_c();

				$SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_styles'] = TRUE;
				$SESS->cache['nsm'][NSM_PP_addon_id]['require_admin_scripts'] = TRUE;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." settings_form: end");

	}

	/**
	* Saves the settings
	* 
	* @since	Version 1.0.0
	* @see		http://ee.docs/development/extensions.html#settings
	**/
	function save_settings()
	{
		global $DB, $IN, $PREFS, $REGX, $SESS;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." save_settings");

		// unset the name
		unset($_POST['name']);

		// remove some extra member group $_POST vars
		if(isset($_POST['groups']) === TRUE)
		{
			foreach($_POST['groups'] as $key => $value)
			{
				unset($_POST['groups_' . $key]);
			}
		}
		else
		{
			$_POST['groups'] = array();
		}

		// remove some extra member group $_POST vars
		if(isset($_POST['nsm_pp_group_weblog_role']) === TRUE)
		{
			foreach($_POST['nsm_pp_group_weblog_role'] as $key => $value)
			{
				unset($_POST['nsm_pp_group_weblog_role_' . $key]);
			}
		}
		else
		{
			$_POST['nsm_pp_group_weblog_role'] = array();
		}

		// remove some extra member group $_POST vars
		if(isset($_POST['notifications']) === TRUE)
		{
			$delete_array = FALSE;
			foreach($_POST['notifications'] as $key => $notification)
			{
				unset($_POST['notifications_' . $key]);

				$notification['site_id'] = $SESS->userdata['site_id'];
				$notification['weblogs'] = (isset($notification['weblogs']) === TRUE) ? implode("|", $notification['weblogs']) : "";
				$notification['old_status'] = strtolower($notification['old_status']);
				$notification['new_status'] = strtolower($notification['new_status']);

				if(isset($notification["enabled"]) === FALSE)
				{
					$notification["enabled"] = "n";
				}

				// delete
				if($notification['delete'] == 'y')
				{
					if(empty($notification['template_id']) == FALSE)
					{
						$delete_array[] = $notification['template_id'];
					}
					unset($_POST['notifications'][$key]);
				}
				else
				{
					unset($notification['delete']);

					$notification['recipients'] = array_merge(array(
						"entry_author" 			=> FALSE,
						"draft_author"			=> FALSE,
						"nsm_pp_publishers"		=> array(),
						"nsm_pp_editors"		=> array(),
						"member_groups"			=> array(),
						"nsm_pp_publishers"		=> array(),
						"nsm_pp_editors"		=> array()
					), $notification['recipients']);

					$notification['recipients'] = addslashes(serialize($notification['recipients']));

					// insert
					if(empty($notification['template_id']) == TRUE)
					{
						$sql = $DB->insert_string('exp_nsm_pp_notification_templates', $notification);
					}
					// edit
					else
					{
						$sql = $DB->update_string('exp_nsm_pp_notification_templates', $notification, "template_id = '".$notification['template_id']."'");
					}

					$DB->query($sql);

				}
			}

			if($delete_array !== FALSE)
			{
				$DB->query($sql = "DELETE FROM `exp_nsm_pp_notification_templates` WHERE `template_id` IN (".implode(",", $delete_array).")");
			}
		}

		unset($_POST['notifications']);

		// merge the defaults with our $_POST vars
		$site_settings = $REGX->xss_clean(array_merge($this->_get_default_extension_settings(), $_POST));

		// load the settings from cache or DB
		// force a refresh and return the full site settings
		$settings = $this->_get_extension_settings(TRUE, TRUE);

		// add the posted values to the settings
		$settings[$PREFS->ini('site_id')] = $site_settings;

		// update the settings
		$query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . __CLASS__ . "'");
	}

	/**
	* Activates the extension
	* 
	* @since	Version 1.0.0
	* @see		http://ee.docs/development/extensions.html#enable
	*/
	function activate_extension()
	{
		global $DB;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." activate_extension");

		// get the list of installed sites
		$query = $DB->query("SELECT * FROM exp_sites");

		// for each of the sites
		foreach($query->result as $row)
		{
			// build a multi dimensional array for the settings
			$settings[$row['site_id']] = $this->_get_default_extension_settings();
		}

		// our list of hooks
		$hooks = array(
			'sessions_start'							=> 'sessions_start',									// 1.4.0
			'sessions_end'								=> 'sessions_end',										// 1.4.0
			'weblog_entries_query_result'				=> 'weblog_entries_query_result',						// 1.6.7
			'delete_entries_start'						=> 'delete_entries_start',								// 1.4.0
			'delete_entries_loop'						=> 'delete_entries_loop',								// 1.4.1
			'edit_entries_search_form'					=> 'edit_entries_search_form',							// 1.4.0
			'edit_entries_search_fields'				=> 'edit_entries_search_fields',						// 1.4.0
			'edit_entries_search_where'					=> 'edit_entries_search_where',							// 1.4.0
			'edit_entries_additional_tableheader'		=> array('edit_entries_additional_tableheader', 1),		// 1.4.0
			'edit_entries_additional_celldata'			=> array('edit_entries_additional_celldata', 1),		// 1.4.0
			'publish_form_start'						=> array('publish_form_start', 1),						// 1.4.0
			'publish_form_headers'						=> 'publish_form_headers',								// 1.6.0
			'publish_form_new_tabs'						=> array('publish_form_new_tabs', 1),					// 1.4.1
			'publish_form_new_tabs_block'				=> 'publish_form_new_tabs_block',						// 1.4.0
			'publish_form_entry_data'					=> 'publish_form_entry_data',							// 1.4.1
			'submit_new_entry_start'					=> 'submit_new_entry_start',							// 1.4.2
			'submit_new_entry_end'						=> 'submit_new_entry_end',								// 1.4
			'myaccount_edit_preferences'				=> 'myaccount_edit_preferences',						// 1.4.0
			'myaccount_update_preferences'				=> 'myaccount_update_preferences',						// 1.4.0
			'show_full_control_panel_end' 				=> 'show_full_control_panel_end',						// 1.4.0
			'lg_addon_update_register_source'			=> 'lg_addon_update_register_source',					// requires LG Addon Updater
			'lg_addon_update_register_addon'			=> 'lg_addon_update_register_addon'						// requires LG Addon Updater
		);

		foreach ($hooks as $hook => $method)
		{
			if(is_array($method))
			{
				$function = $method[0];
				$priority = $method[1];
			}
			else
			{
				$function = $method;
				$priority = 10;
			}

			// build the sql
			$sql[] = $DB->insert_string( 'exp_extensions', 
											array('extension_id' 	=> '',
												'class'				=> get_class($this),
												'method'			=> $function,
												'hook'				=> $hook,
												'settings'			=> addslashes(serialize($settings)),
												'priority'			=> $priority,
												'version'			=> $this->version,
												'enabled'			=> "y"
											)
										);
		}

		$sql[] = "ALTER TABLE `exp_weblog_titles` ADD `nsm_pp_state` VARCHAR( 50 ) NOT NULL;";

		// ADD NOTES TABLE
		$sql[] = "CREATE TABLE IF NOT EXISTS `exp_nsm_notes` (
					`id` INT( 10 ) NOT NULL AUTO_INCREMENT,
					`lang` varchar( 5 ) NOT NULL,
					`class_name` varchar( 50 ) NOT NULL,
					`entry_id` INT( 10 ) NOT NULL,
					`site_id` INT( 4 ) NOT NULL,
					`weblog_id` INT( 4 ) NOT NULL,
					`author_id` INT( 4 ) NOT NULL,
					`created_at` INT( 10 ) NOT NULL,
					`note` TEXT NOT NULL,
					PRIMARY KEY ( `id` , `entry_id` )
				)";

		$sql[] = "CREATE TABLE IF NOT EXISTS `exp_nsm_entry_drafts` (
					`draft_id` INT( 10 ) NOT NULL AUTO_INCREMENT,
					`entry_id` INT( 10 ) NOT NULL,
					`site_id` INT( 4 ) NOT NULL,
					`weblog_id` INT( 4 ) NOT NULL,
					`author_id` INT( 4 ) NOT NULL,
					`created_at` INT( 10 ) NOT NULL,
					`draft_data` TEXT NOT NULL,
					`preview` VARCHAR( 1 ) NOT NULL,
					PRIMARY KEY ( `draft_id` , `entry_id` )
				)";

		$sql[] = "CREATE TABLE IF NOT EXISTS `exp_nsm_pp_notification_templates` (
				`template_id` INT NOT NULL AUTO_INCREMENT,
				`site_id` INT( 2 ) NOT NULL,
				`weblogs` varchar( 100 ) NOT NULL,
				`enabled` VARCHAR( 1 ) NOT NULL,
				`action` VARCHAR( 50 ) NOT NULL,
				`old_status` VARCHAR( 50 ) NOT NULL,
				`new_status` VARCHAR( 50 ) NOT NULL,
				`old_state` VARCHAR( 50 ) NOT NULL,
				`new_state` VARCHAR( 50 ) NOT NULL,
				`subject` VARCHAR( 120 ) NOT NULL,
				`message` MEDIUMTEXT NOT NULL,
				`recipients` TEXT NOT NULL,
				PRIMARY KEY ( `template_id` )
			)";
			
		$sql[] = "CREATE TABLE IF NOT EXISTS `exp_nsm_acl_roles` (
					`id` INT( 10 ) NOT NULL AUTO_INCREMENT,
					`member_id` INT( 10 ) NOT NULL ,
					`site_id` INT( 10 ) NOT NULL ,
					`weblog_id` INT( 10 ) NOT NULL ,
					`class_name` VARCHAR( 100 ) NOT NULL ,
					`role` VARCHAR( 100 ) NOT NULL ,
					PRIMARY KEY ( `id` , `member_id` )
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
	* @param 	string  $current The current installed version of the extension
	* @since	Version 1.0.0
	* @see		http://ee.docs/development/extensions.html#enable
	*/
	function update_extension( $current = "" )
	{
		global $DB;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." update_extension");

		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		if ($current < '1.0.1')
		{
			$DB->query($DB->update_string("exp_weblog_titles", array("nsm_pp_state" => "changed"), "nsm_pp_state = 'dirty'"));
		}

		if ($current < '1.0.4')
		{
			$DB->query($DB->update_string("exp_nsm_pp_notification_templates", array("action" => "create_revision"), "action = 'edit_entry'"));
		}

		if ($current < '1.0.5')
		{
			$settings = $this->_get_extension_settings(TRUE, TRUE);

			// add our new default settings
			foreach ($settings as $site_id => $settings)
			{
				$settings[$site_id]["disable_ee_preview"] 	= "y";
				$settings[$site_id]["draft_trigger"] 		= "draft";
				$settings[$site_id]["revision_trigger"] 	= "revision";
			}
			
			$hooks = array(
				'sessions_start'				=> 'sessions_start',
				'weblog_entries_query_result'	=> 'weblog_entries_query_result'
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
		}

		if ($current < '1.0.6')
		{
			$DB->query("ALTER TABLE `exp_nsm_entry_drafts` ADD `preview` VARCHAR( 1 ) NOT NULL");
		}

		$sql[] = "UPDATE `exp_extensions` SET `version` = '" . $DB->escape_str($this->version) . "' WHERE `class` = '" . get_class($this) . "'";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
	}

	/**
	* Disabled the extension
	* 
	* @since	Version 1.0.0
	* @see		http://ee.docs/development/extensions.html#disable
	*/
	function disable_extension()
	{
		global $DB;

		if($this->debug === TRUE) print("<br />".memory_get_usage()." disable_extension");

		$sql[] = "DELETE FROM `exp_extensions` WHERE class = '" . get_class($this) . "'";
		$sql[] = "ALTER TABLE `exp_weblog_titles` DROP `nsm_pp_state`";
		//$sql[] = "DELETE FROM `exp_nsm_pp_notification_templates` WHERE class_name = '" . get_class($this) . "'";
		$sql[] = "DELETE FROM `exp_nsm_acl_roles` WHERE class_name = '" . get_class($this) . "'";

		// run all sql queries
		foreach ($sql as $query)
		{
			$DB->query($query);
		}
	}

	/**
	* Get the default extension settings
	* 
	* @access	private
	* @return	array					The default extensions settings array
	* @since	Version 1.0.0
	* @since 	Version 1.0.0
	*/
	function _get_default_extension_settings( $site_id = FALSE )
	{
		global $DB, $PREFS;

		$nsm_pp_group_weblog_role = array();

		if($site_id === FALSE)
		{
			$site_id = $PREFS->ini("site_id");
		}

		$group_query = $DB->query("SELECT group_id FROM exp_member_groups WHERE `site_id` = " . $site_id);
		$weblog_query = $DB->query("SELECT weblog_id FROM exp_weblogs WHERE `site_id` = " . $site_id);

		foreach ($group_query->result as $group)
		{
			foreach ($weblog_query->result as $weblog)
			{
				$nsm_pp_group_weblog_role[$group["group_id"]][$weblog["weblog_id"]] = "no_access";
			}
		}

		$settings =  array(
			"enable"					=> "y",
			"nsm_pp_group_weblog_role"	=> $nsm_pp_group_weblog_role,
			"check_for_updates"			=> "y",
			"show_promos"				=> "n",
			"show_donate"				=> "n",
			"show_preview"				=> "n",
			"draft_trigger"				=> "draft",
			"revision_trigger"			=> "revision",
			"preview_trigger"			=> "preview",
			"disable_ee_preview"		=> "y"
		);
		return $settings;

	}

	/**
	* Returns the extension settings from the DB
	*
	* @access	private
	* @param	bool	$force_refresh	Force a refresh
	* @param	bool	$return_all		Set the full array of settings rather than just the current site
	* @return	array					The settings array
	* @since 	Version 1.0.0
	*/
	function _get_extension_settings( $force_refresh = FALSE, $return_all = FALSE )
	{
		global $SESS, $DB, $REGX, $PREFS;

		// assume there are no settings
		$settings = FALSE;
		// Get the settings for the extension
		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . NSM_PP_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache['nsm'][NSM_PP_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}

		// if we are returning all the settings
		if($return_all === TRUE)
		{
			$settings = $SESS->cache['nsm'][NSM_PP_addon_id]['settings'];
		}
		else
		{
			// do setting exist for this site?
			if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['settings'][$PREFS->ini('site_id')]) === TRUE)
			{
				$settings = $SESS->cache['nsm'][NSM_PP_addon_id]['settings'][$PREFS->ini('site_id')];
			}
			else
			{
				// grab the site defaults
				$settings = $this->_get_default_extension_settings();
			}
		}

		return $settings;
	}

	/**
	* Register a new Addon Source
	*
	* @param	array $sources The existing sources
	* @return	array The new source list
	* @since	Version 1.0.0
	* @see		http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/#usage-register-addon
	*/
	function lg_addon_update_register_source( $sources )
	{
		global $EXT;

		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $sources = $EXT->last_call;

		// add a new source
		// must be in the following format:
		/*
		<versions>
			<addon id='LG Addon Updater' version='2.0.0' last_updated="1218852797" docs_url="http://leevigraham.com/" />
		</versions>
		*/
		if($this->settings['check_for_updates'] == 'y' && $this->settings['enable'] == 'y')
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
	* @since	Version 1.0.0
	* @see		http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/#usage-register-addon
	*/
	function lg_addon_update_register_addon( $addons )
	{
		global $EXT;
		// Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE) $addons = $EXT->last_call;

		// add a new addon
		// the key must match the id attribute in the source xml
		// the value must be the addons current version
		if($this->settings['check_for_updates'] == 'y' && $this->settings['enable'] == 'y')
		{
			$addons[NSM_PP_addon_id] = $this->version;
		}

		return $addons;
	}

	/**
	* Renders all the current NSM Cached Notifications
	*
	* @access	private
	* @return	string					Notifications
	* @since 	Version 1.0.0
	*/
	function _render_nsm_messages()
	{
		global $SESS;
		$r = '';
		// if there are message groups
		if(empty($SESS->cache['nsm']['msgs']) === FALSE)
		{
			krsort($SESS->cache['nsm']['msgs']);
			// foreach message group
			foreach ($SESS->cache['nsm']['msgs'] as $group => $messages)
			{
				// if there are messages
				if(empty($messages) === FALSE)
				{
					// create a new box
					switch ($group) {
						case 'box':
							$class = "box";
							break;
						
						case 'success':
							$class = "success box";
							break;
						
						default:
							$class = $group."-box";
							break;
					}
					$r .= "<ul class='msg-box ".$class."'>";
					// loop through each message

					foreach (array_unique($messages) as $message)
					{
						// create a list item
						$r .= "<li>".$message."</li>";
					}

					// close box
					$r .= "</ul>";
				}
				// clear the group so other extensions won't display the same messages
				$SESS->cache['nsm']['msgs'][$group] = array();
			}
			// return the string
			return $r;
		}
	}

	/**
	* Builds a multiple select form element
	*
	* @access	private
	* @param	array	$options				"name", "size", "selected_values"
	* @return	string							The select box html
	* @since 	Version 1.0.0
	*/
	function _build_weblog_select_box( $options = FALSE )
	{
		global $DB, $SESS;

		if($options === FALSE || empty($options) === TRUE)
		{
			die("Pass options to _build_language_select_box");
		}

		$options = array_merge(array(
			"size" 				=> 5,
			"id" 				=> "",
			"name"				=> "",
			"selected_values" 	=> array(),
			"show_all"			=> TRUE,
			"style"				=> "",
			"multiple"			=> TRUE
		), $options);

		if(is_array($options["selected_values"]) === FALSE) $options["selected_values"] = explode("\n", $options["selected_values"]);

		// this $SESS->cache query gets set in the sessions_end method
		$weblog_query = $SESS->cache['nsm']['assigned_sites_weblog_query'];

		if($weblog_query->num_rows > 0)
		{
			$options["size"] = count($weblog_query->result);
			$weblogs = "";
			$site_id = FALSE;
			foreach ($weblog_query->result as $row)
			{
				if($row['site_id'] != $site_id)
				{
					$site_id = $row['site_id'];
					if($site_id != FALSE)
					{
						$weblogs .= "</optgroup>";
					}
					$weblogs .= "<optgroup label='".$row['site_label']."'>";
					++$options["size"];
				}
				$weblogs .= "<option value='".$row['weblog_id']."'" . (in_array($row['weblog_id'], $options["selected_values"]) ? " selected='selected'" : "" ) . ">".$row['blog_title']."</option>";
			}

			$select = "<select id='".$options["id"]."' name='".$options["name"]."' style='".$options["style"]."' ".(($options["multiple"] === TRUE) ? "multiple='multiple'" : "")."' size='".$options["size"]."'>"
				. (($options["show_all"] === TRUE) ? 
					"<option value='all'" . (in_array('all', $options["selected_values"]) ? " selected='selected'" : "" ) . ">All</option>
					<option value='' disabled='disabled'>-------------------</option>"
					: ""
				)
			. $weblogs
			. "</optgroup>"
			. "</select>";
		}
		else
		{
			$select = "<p class='highlight'>You can not be assigned any weblogs.</p>";
		}

		return $select;
	}

	/**
	* Gets the notes for a certain entry
	*
	* @access	private
	* @param	integer		$entry_id	The entry id
	* @return	object					DB query object
	* @since 	Version 1.0.0
	*/
	function _get_entry_notes( $entry_id = FALSE )
	{
		global $DB, $SESS;
		
		if(empty($entry_id) === TRUE) die("No entry id parameter for Nsm_publish_plus_ext->_get_entry_notes");

		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['notes'][$entry_id]) === FALSE)
		{
			$SESS->cache['nsm'][NSM_PP_addon_id]['notes'][$entry_id] = $DB->query($sql ="
				SELECT * FROM `exp_nsm_notes`
				INNER JOIN `exp_members`
				ON `exp_nsm_notes`.`author_id` = `exp_members`.`member_id`
				WHERE `class_name` = '".__CLASS__."'
				AND `entry_id` = " . $entry_id . "
				ORDER BY `created_at` ASC");
		}
		return $SESS->cache['nsm'][NSM_PP_addon_id]['notes'][$entry_id];
	}

	/**
	* Saves the note for an entry
	*
	* @access	private
	* @param	array		$data	The note_data which must include entry_id and note keys
	* @return	bool					TRUE|FALSE
	* @since 	Version 1.0.0
	*/
	function _create_entry_note( $note, $entry_id )
	{
		global $DB, $LANG, $LOC, $SESS;

		$SESS->cache['nsm']['kill_preview'] = TRUE;
		$note_id = FALSE;

		// if the note is empty
		if(empty($note) === TRUE)
		{
			// render the preview and send an error
			$SESS->cache['nsm']['msgs']['error'][] = $LANG->line("error_empty_note");
		}
		// if there is an entry id the entry has already been saved and we can just add the note
		else
		{
			// try save note
			// merge some default values, create an insert string, save it to a variable, execute the sql
			$DB->query( $sql = $DB->insert_string('exp_nsm_notes', array(
				"class_name" 	=> __CLASS__,
				"site_id" 		=> $SESS->userdata['site_id'],
				"author_id"		=> $SESS->userdata['member_id'],
				"created_at"	=> $LOC->now,
				"entry_id"		=> $entry_id,
				"note"			=> $note
			)));

			if($note_id = $DB->insert_id)
			{
				// note saved
				unset($_POST['nsm_pp_note']);
				$SESS->cache['nsm']['msgs']['success'][] = $LANG->line("success_note_added");
				$this->_send_notifications("create_note", $entry_id);
			}
			else
			{
				// render the preview and send an error
				$SESS->cache['nsm']['msgs']['error'][] = $LANG->line("error_note_submit_db_error");
			}
		}

		// return the insert_id
		return $note_id;
	}

	/**
	* Gets the drafts for a certain entry
	*
	* @access	private
	* @param	integer		$entry_id	The entry id
	* @return	object					DB query object
	* @since 	Version 1.0.0
	*/
	function _get_entry_drafts( $entry_id = FALSE, $previews = FALSE )
	{
		global $DB, $LOC, $SESS;
		
		if(empty($entry_id) === TRUE) die("No entry id parameter for Nsm_publish_plus_ext->_get_entry_drafts");

		if($previews === TRUE)
		{
			$sess_key	= "previews";
			$where		= " AND d.preview = 'y' ";
		}
		else
		{
			$sess_key	= "drafts";
			$where		= "AND d.preview <> 'y'";
		}

		if(isset($SESS->cache['nsm'][NSM_PP_addon_id][$sess_key][$entry_id]) === FALSE)
		{
			$query = $DB->query("
				SELECT
					d.*,
					m.screen_name,
					m.username,
					m.member_id,
					UNIX_TIMESTAMP(t.edit_date) as entry_edit_timestamp,
					t.edit_date as ee_edit_timestamp,
					t.entry_date as entry_published_timestamp,
					t.nsm_pp_state
				FROM exp_nsm_entry_drafts AS d, exp_members AS m, exp_weblog_titles as t
				WHERE d.entry_id = '{$entry_id}'
				AND t.entry_id = '{$entry_id}'
				AND d.author_id = m.member_id
				" . $where . "
				ORDER BY d.draft_id DESC"
			);
			if($query->num_rows > 0)
			{
				foreach ($query->result as $row)
				{
					$sorted_results[$row['draft_id']] = $row;
				}
				$query->result = $sorted_results;
			}
			$SESS->cache['nsm'][NSM_PP_addon_id][$sess_key][$entry_id] = $query;
		}
		return $SESS->cache['nsm'][NSM_PP_addon_id][$sess_key][$entry_id];
	}
 
	/**
	* Saves a draft for an entry
	*
	* @access	private
	* @param	array		$data		The draft data which must include entry_id and draft keys
	* @return	int					The insert id
	* @since 	Version 1.0.0
	*/
	function _create_entry_draft( $data, $entry_id, $notify = TRUE )
	{

		global $DB, $LANG, $LOC, $SESS;

		$SESS->cache['nsm']['kill_preview'] = TRUE;
		$draft_id = FALSE;

		// add the entry_id to the data
		$data['entry_id'] = $entry_id;

		// unset the save if it exists
		// the save exists if the user saves an entry as a draft for the first time
		unset($data['save']);

		$data["status"] = (isset($_POST["draft_status"]) === TRUE) ? $_POST["draft_status"] : $_POST["status"];

		// build insert data
		$ins_data = array(
			'entry_id' => $entry_id,
			'weblog_id' => $data['weblog_id'],
			'author_id' => $SESS->userdata['member_id'],
			'created_at' => $LOC->now, // cheating a little bit
			'draft_data' => addslashes(serialize($data))
		);

		// execute insert
		$DB->query($DB->insert_string('exp_nsm_entry_drafts', $ins_data));

		// if we inserted with no issues
		if($draft_id = $DB->insert_id)
		{
			// update the entry state
			$DB->query($DB->update_string("exp_weblog_titles", array("nsm_pp_state" => $_POST['nsm_pp_state']), array("entry_id" => $entry_id)));

			if($notify === TRUE)
			{
				$SESS->cache['nsm']['msgs']['success'][] = $LANG->line("success_draft_submit");
				$this->_send_notifications("create_draft", $entry_id);
			}
		}
		else
		{
			$SESS->cache['nsm']['msgs']['error'][] = $LANG->line("error_draft_submit_db_error");
		};

		return $draft_id;
	}

	/**
	* Saves a preview for an entry
	*
	* @access	private
	* @param	array		$data		The preview data which must include entry_id and draft keys
	* @return	int						The insert id
	* @since 	Version 1.0.5
	*/
	function _create_preview( $data, $entry_id )
	{
		global $DB, $LOC, $SESS;
		// unset the save if it exists
		// the save exists if the user saves an entry as a draft for the first time
		unset($data['save']);

		// clean up old previews after 24hrs
		$DB->query("DELETE FROM `exp_nsm_entry_drafts` WHERE `exp_nsm_entry_drafts`.`created_at` < " . ($LOC->now - 86400) . " AND preview = 'y'");

		// build insert data
		$ins_data = array(
			'entry_id' => $entry_id,
			'weblog_id' => $data['weblog_id'],
			'author_id' => $SESS->userdata['member_id'],
			'created_at' => $LOC->now,
			'draft_data' => addslashes(serialize($data)),
			'preview' => 'y'
		);

		// execute insert
		$DB->query($DB->insert_string('exp_nsm_entry_drafts', $ins_data));

		// if we inserted with no issues
		if(($preview_id = $DB->insert_id) == FALSE)
		{
			$SESS->cache['nsm']['msgs']['error'][] = $LANG->line("error_preview_submit_db_error");
		}

		return $preview_id;
	}

	/*
	* Submits an entry for approval but saves a draft first
	*
	* @access	private
	* @param	array		$data		Post data
	* @param	int			$entry_id	The entry id we are submitting for approval
	* @since 	Version 1.0.0
	*/
	function _submit_for_approval($data, $entry_id)
	{
		global $LANG, $SESS;
		if($this->_create_entry_draft($data, $entry_id))
		{
			$this->_send_notifications("submit_for_approval", $entry_id);
			$SESS->cache['nsm']['msgs']['success'][] = $LANG->line("success_approval_submit");
		}
	}

	/**
	* Sends a notification template out to members when an entry changes status
	*
	* @access	private
	* @param	string		$action			The users action [create|edit|delete]
	* @param	array|int	$entry			Either the entry_id or the entry data
	* @param	array		$filter			Filtering params including status and state
	* @since 	Version 1.0.0
	*/
	function _send_notifications( $action, $entry = FALSE )
	{
		global $DB, $DSP, $FNS, $IN, $LANG, $LOC, $PREFS, $REGX, $SESS;

		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['entries']) == FALSE)
		{
			$SESS->cache['nsm'][NSM_PP_addon_id]['entries'] = array();
		}

		if(is_numeric($entry))
		{
			// get the entry data
			if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry]) === FALSE)
			{
				$query = $DB->query($sql = "SELECT t.*, w.*, m.email, m.username, m.screen_name, s.site_label, s.site_description
					FROM `exp_weblog_titles` as t 
					INNER JOIN `exp_weblogs` as w ON t.weblog_id = w.weblog_id
					INNER JOIN `exp_members` as m ON t.author_id = m.member_id
					INNER JOIN `exp_sites`	as s ON t.site_id = s.site_id
					WHERE entry_id = " . $entry
				);
				$SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry] = $query->row;
			}
			$entry_data = $SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry];
			
		}
		elseif(is_array($entry))
		{
			// entry is an array
			$SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry["entry_id"]] = $entry;
			$entry_data = $SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry["entry_id"]];
		}
		else
		{
			print("invalid entry data");
			exit;
		}

		$where = "";

		// set the default filter
		$filter = array(
					"old_status" => $IN->GBL("old_status"),
					"new_status" => $IN->GBL("status"),
					"old_state" => $IN->GBL("old_state"),
					"new_state" => $IN->GBL("nsm_pp_state"),
				);

		// sql for notifications
		// the crazy regexp matches weblog ids in a pipe delimited list: 1|2|10|34|109
		$sql = "SELECT * FROM `exp_nsm_pp_notification_templates` as n
				WHERE weblogs REGEXP '(^|\\\|)".$entry_data['weblog_id']."(\\\||$)'
				AND n.enabled = 'y'
				AND n.site_id = " . $PREFS->ini('site_id') ."
				AND n.action='".$action."'";

		// execute the query to return the notifications
		$notification_query = $DB->query($sql);

		if($PREFS->ini("email_debug") == "y")
		{
			print("<pre>\n\n<strong>SQL:</strong> " . $sql . "</pre>");
			print("<pre>\n\n<strong>Notifications (".$notification_query->num_rows."):</strong>\n" . print_r($notification_query->result, TRUE) . "</pre>");
		}

		// loop over the notifications
		foreach ($notification_query->result as $notification)
		{

			if($PREFS->ini("email_debug") == "y")
			{
				print("<pre>\n\n<strong>Filtering Notifications:</strong></pre>");
			}

			// for each of our filters
			foreach (array_keys($filter) as $key)
			{
				// if the notification has a set filter for this key
				// and the notification filter key value does not equal the passed filter value
				if($notification[$key] != "" && strtolower($notification[$key]) != strtolower($filter[$key]) )
				{
					// skip this notification becuase it doesn't match
					continue(2);
				}
			}

			if($PREFS->ini("email_debug") == "y")
			{
				print("<pre>\n\n<strong>Matched:</strong>\n" . print_r($notification, TRUE) . "</pre>");
			}

			// build recipients list
			$recipients = unserialize($notification['recipients']);

			if($PREFS->ini("email_debug") == "y")
			{
				print("<pre>\n\n<strong>Recipients:</strong>\n" . print_r($recipients, TRUE) . "</pre>");
			}

			// empty emails array
			$emails = array();

			// additional emails
			if(empty($recipients['additional']) === FALSE)
			{
				$emails = explode(",", $recipients['additional']);
			}

			// entry author email
			if($recipients['entry_author'] == "y")
			{
				$emails[] = $entry_data['email'];
			}

			// draft author emails
			if($recipients['draft_author'] == "y")
			{
				// get draft authors emails
				if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry_data['entry_id']]['draft_author_query']) === FALSE)
				{
					$sql = "SELECT m.email FROM `exp_nsm_entry_drafts` as d INNER JOIN `exp_members` as m ON d.author_id = m.member_id WHERE d.entry_id = '".$entry_data['entry_id']."'";
					$SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry_data['entry_id']]['draft_author_query'] = $DB->query($sql);
				}
				
				$draft_author_query = $SESS->cache['nsm'][NSM_PP_addon_id]['entries'][$entry_data['entry_id']]['draft_author_query'];
				foreach ($draft_author_query->result as $member)
				{
					$emails[] = $member['email'];
				}
			}

			// publishers assigned to this weblog
			foreach ($recipients['nsm_pp_publishers'] as $weblog_id)
			{
				$weblog_publishers_query = $this->_fetch_members_for_role_in_weblog("publisher", $weblog_id);
				foreach ($weblog_publishers_query->result as $member)
				{
					$emails[] = $member['email'];
				}
			}

			// editors assigned to this weblog
			foreach ($recipients['nsm_pp_editors'] as $weblog_id)
			{
				$weblog_editors_query = $this->_fetch_members_for_role_in_weblog("editor", $weblog_id);
				foreach ($weblog_editors_query->result as $member)
				{
					$emails[] = $member['email'];
				}
			}

			// EE member groups
			if(empty($recipients['member_groups']) === FALSE)
			{
				foreach ($recipients['member_groups'] as $group_id)
				{
					if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['groups'][$group_id]['members']) === FALSE)
					{
						$SESS->cache['nsm'][NSM_PP_addon_id]['groups'][$group_id]['members'] = $DB->query($sql = "SELECT * FROM `exp_members` WHERE `group_id` = '".$group_id."'");
					}
					foreach ($SESS->cache['nsm'][NSM_PP_addon_id]['groups'][$group_id]['members']->result as $member)
					{
						$emails[] = $member['email'];
					}
				}
			}

			// no emails? no need to build the template
			if(empty($emails) === TRUE)
			{
				continue;
			}

			// these are the tempate variables that will be replaced
			$replacements = array(
				'site_id'											=> $entry_data['site_id'],
				'site_title'										=> $entry_data['site_label'],
				'site_description'									=> $entry_data['site_description'],
				'action'											=> $LANG->line($notification['action']),
				'status'											=> $filter['new_status'],
				'old_status'										=> $filter['old_status'],
				'state'												=> $filter['new_state'],
				'old_state'											=> $filter['old_state'],
				'entry_id'											=> $entry_data['entry_id'],
				$PREFS->ini("weblog_nomenclature") . '_id'				=> $entry_data['weblog_id'],
				$PREFS->ini("weblog_nomenclature") . '_title'			=> $entry_data['blog_title'],
				$PREFS->ini("weblog_nomenclature") . '_url'			=> $entry_data['blog_url'],
				$PREFS->ini("weblog_nomenclature") . '_description'	=> $entry_data['blog_description'],
				'author_id'				=> $entry_data['author_id'],
				'author_name'			=> (isset($entry_data['screen_name']) === TRUE) ? $entry_data['screen_name'] : $entry_data['username'],
				'actor_name'			=> (isset($SESS->userdata['screen_name']) === TRUE) ? $SESS->userdata['screen_name'] : $SESS->userdata['username'],
				'title'					=> $entry_data['title'],
				'url_title'				=> $entry_data['url_title'],
				'status'				=> $entry_data['status'],
				'entry_date'			=> $LOC->set_human_time($entry_data['entry_date'], 1),
				'edit_date'				=> $LOC->set_human_time($LOC->timestamp_to_gmt($entry_data['edit_date'], 1)),
				'expiration_date'		=> ($entry_data['expiration_date'] == 0) ? "" : $LOC->set_human_time($entry_data['expiration_date'], 1),
				'edit_entry_url'		=> $PREFS->ini('cp_url') . "?C=edit".AMP."M=edit_entry".AMP."weblog_id=".$entry_data['weblog_id'].AMP."entry_id=".$entry_data['entry_id']
			);

			// set some email basics
			$message = $FNS->var_swap($notification['message'], $replacements);
			$subject = $FNS->var_swap($notification['subject'], $replacements);

			// get the email class
			if ( ! class_exists('EEmail'))
			{
				require PATH_CORE.'core.email'.EXT;
			}

			// create a new email object
			$E = new EEmail;    
			$E->initialize();
			$E->wordwrap = $PREFS->ini('word_wrap');
			$E->priority = 3;

			// set the prefs
			// im sending it to myself
			$E->from($PREFS->ini('webmaster_email'), $PREFS->ini('webmaster_name'));
			$unique_emails = array_unique($emails);
			$E->to(array_values($unique_emails));
			$E->reply_to($PREFS->ini('webmaster_email'));

			// create a subject line
			$E->subject($REGX->entities_to_ascii($subject));

			// add the message to the email object
			$E->message($REGX->entities_to_ascii($message));

			if ($E->Send() === FALSE)
			{
				return $DSP->error_message($LANG->line('error_sending_email'), 0);
			}
			elseif($PREFS->ini("email_debug") == "y")
			{
				print("<pre>\n\n<strong>Email sent to</strong>: " . implode(", ", $unique_emails) . " with subject: " . $subject . "</pre>");
			}
		}
	}

	/**
	* Builds the notification form row for the extension settings
	*
	* @access	private
	* @param	int			$i				The current row number
	* @param	string		$class			The row class
	* @param	DB object	$weblogs		DB Object containing this sites weblogs
	* @param	DB object	$gourps			DB Object containing this sites groups
	* @return	string						The form html
	* @since 	Version 1.0.0
	*/
	function _build_notification_form_row( $i, $class, $weblogs, $groups, $data = array() )
	{
		global $DSP, $LANG;
		
		$data = array_merge(array(
			"template_id"	=> "",
			"weblogs"		=> array(),
			"action"		=> "",
			"subject"		=> "",
			"message"		=> "",
			"recipients"	=> array(),
			"enabled"		=> FALSE,
			"old_status"	=> "",
			"new_status"	=> "",
			"old_state"		=> "",
			"new_state"		=> "",
			"recipients"	=> array()
		), $data);

		if(empty($data['template_id']) == FALSE)
		{
			$data['weblogs'] = explode("|", $data['weblogs']);
			$data['recipients'] = unserialize($data['recipients']);
		}
		else
		{
			$data['recipients']["entry_author"]			= "n";
			$data['recipients']["draft_author"] 		= "n";
			$data['recipients']["nsm_pp_publishers"]	= array();
			$data['recipients']["nsm_pp_editors"]		= array();
		}

		$actions = array(
			"create_entry",
			"create_draft",
			"submit_for_approval",
			"create_revision",
			"delete_entry",
			"create_note"
		);
		
		$states = array('', 'approved', 'pending', 'denied', 'changed');

		$form_row = $DSP->tr(). $DSP->td($class);
		$form_row .= "<input name='notifications[".$i."][template_id]' type='hidden' value='".$data['template_id']."' />";
		$form_row .= "<input name='notifications[".$i."][delete]' type='hidden' value='' />";
		$form_row .= "<label class='checkbox'><span>".ucfirst($LANG->line('enable_notification'))."</span> <input" . (($data['enabled'] == "y") ? " checked='checked'" : "") . " type='checkbox' value='y' name='notifications[".$i."][enabled]' /></label>";
		$form_row .= "<label><span>".ucfirst($LANG->line('weblogs')).":</span>";
		$form_row .= "<select name='notifications[".$i."][weblogs][]' multiple='multiple' size='7'>";

		foreach ($weblogs as $row)
		{
			$selected = (in_array($row['weblog_id'], $data['weblogs']) === TRUE) ? " selected='selected'" : "";
			$form_row .= "<option value='".$row['weblog_id']."'".$selected.">" . $row['blog_title'] . "</option>";
		}

		$form_row .= "</select></label>";

		$form_row .= "<label><span>".ucfirst($LANG->line('action')).":</span>
						<select name='notifications[".$i."][action]' class='notification_action'>";

		foreach ($actions as $action)
		{
			$selected = ($action == $data['action']) ? " selected='selected'" : "";
			$form_row .= "<option value='".$action."'".$selected.">".$LANG->line($action)."</option>";
		}

		$form_row .= "</select></label>
				<fieldset class='statuses' style='display:none'>
					<h6>".ucfirst($LANG->line('when_status_changes'))." <small>(optional)</small> :</h6>
					<label><span>".ucfirst($LANG->line('from')).":</span> <input type='text' value='".$data['old_status']."' name='notifications[".$i."][old_status]' /></label>
					<label><span>".ucfirst($LANG->line('to')).":</span> <input type='text' value='".$data['new_status']."' name='notifications[".$i."][new_status]' /></label>
				</fieldset>
				<fieldset class='states' style='display:".(($data['action'] == "edit_entry") ? "block" : "none")."'>
					<h6>".ucfirst($LANG->line('when_state_changes'))." <small>(optional)</small>:</h6>
					<label><span>".ucfirst($LANG->line('from')).":</span>
						<select name='notifications[".$i."][old_state]'>";

		foreach ($states as $state)
		{
			$selected = ($state == $data['old_state']) ? " selected='selected'" : "";
			$form_row .= "\n<option value='".$state."'".$selected.">" . ucwords($LANG->line($state)) . "</option>";
		}

		$form_row .= "	</select>
					</label>
					<label><span>".ucfirst($LANG->line('to')).":</span>
					<select name='notifications[".$i."][new_state]'>";
					foreach ($states as $state)
					{
						$selected = ($state == $data['new_state']) ? " selected='selected'" : "";
						$form_row .= "\n<option value='".$state."'".$selected.">" . ucwords($LANG->line($state)) . "</option>";
					}
					$form_row .= "	</select>
					</label>
				</fieldset>"
			. $DSP->td_c()
			. $DSP->td($class)
			. "<label><span>".ucfirst($LANG->line('subject')).":</span> <input type='text' value='".$data['subject']."' name='notifications[".$i."][subject]' /></label>"
			. "<label><span>".ucfirst($LANG->line('message')).":</span> <textarea name='notifications[".$i."][message]' class='textarea'>".$data['message']."</textarea></label>"
			. $DSP->td_c()
			. $DSP->td($class)
			. "<fieldset class='checkbox'>
				<h6>".ucfirst($LANG->line('authors')).":</h6>
				<label><span>".ucfirst($LANG->line('entry_author'))."</span> <input" . (($data['recipients']['entry_author'] == "y") ?" checked='checked'":'') . " type='checkbox' value='y' name='notifications[".$i."][recipients][entry_author]' /></label>
				<label><span>".ucfirst($LANG->line('draft_authors'))."</span> <input" . (($data['recipients']['draft_author'] == "y") ?" checked='checked'":'') . " type='checkbox' value='y' name='notifications[".$i."][recipients][draft_author]' /></label>
			</fieldset>";
			$form_row .= "<fieldset class='nsm_pp_roles'>";
			$form_row .= "<h6>".ucfirst($LANG->line('publish_plus_roles')).":</h6>";
			$form_row .= "<label><span>".ucfirst($LANG->line('publishers_for')).":</span>";
			$form_row .= "<select name='notifications[".$i."][recipients][nsm_pp_publishers][]' multiple='multiple' size='7'>";

			foreach ($weblogs as $row)
			{
				$selected = (in_array($row['weblog_id'], $data['recipients']['nsm_pp_publishers']) === TRUE) ? " selected='selected'" : "";
				$form_row .= "<option value='".$row['weblog_id']."'".$selected.">" . $row['blog_title'] . "</option>";
			}

			$form_row .= "</select></label>";

			$form_row .= "<label><span>".ucfirst($LANG->line('editors_for')).":</span>";
			$form_row .= "<select name='notifications[".$i."][recipients][nsm_pp_editors][]' multiple='multiple' size='7'>";

			foreach ($weblogs as $row)
			{
				$selected = (in_array($row['weblog_id'], $data['recipients']['nsm_pp_editors']) === TRUE) ? " selected='selected'" : "";
				$form_row .= "<option value='".$row['weblog_id']."'".$selected.">" . $row['blog_title'] . "</option>";
			}

			$form_row .= "</select></label>
				</fieldset>";


		$form_row .= "<fieldset class='checkbox'>
				<h6>".ucfirst($LANG->line('ee_member_groups')).":</h6>";

		foreach($groups->result as $row)
		{
			$checked = FALSE;
			if(isset($data['recipients']['member_groups']) === TRUE && in_array($row['group_id'], $data['recipients']['member_groups']) === TRUE)
			{
				$checked = " checked='checked'";
			}
			$form_row .= "<label><span>".$row['group_title']."</span> <input" . $checked . " type='checkbox' value='".$row['group_id']."' name='notifications[".$i."][recipients][member_groups][]' /></label>";
		}

		$form_row .= "</fieldset>
						<h6>".ucfirst($LANG->line('additional_recipients')).": <small>(".ucfirst($LANG->line('comma_seperated_emails')).")</small></h6>
						<input style='width:95%' type='text' value='".((isset($data['recipients']['additional'])) ? $data['recipients']['additional'] : '')."' name='notifications[".$i."][recipients][additional]' />";

		$form_row .= $DSP->td_c();

		$form_row .= $DSP->td($class)
			. "<a href='#' class='delete'>Delete</a>"
			. $DSP->td_c()
			. $DSP->tr_c();

		return $form_row;
	}

	/**
	* Fetches the nsm pp publishers for a weblog
	*
	* @access	private
	* @param	int			$weblog_id		The weblog id
	* @return	DB Object					DB query object
	* @since 	Version 1.0.0
	*/
	function _fetch_members_for_role_in_weblog( $role, $weblog_id )
	{
		global $DB, $SESS;

		if(isset($SESS->cache['nsm'][NSM_PP_addon_id]['weblogs'][$weblog_id]['nsm_pp_'.$role.'_query']) === FALSE)
		{
			$role_groups = array();
			foreach ($this->settings['nsm_pp_group_weblog_role'] as $group_id => $weblogs)
			{
				if($weblogs[$weblog_id] == $role)
				{
					$role_groups[] = $group_id;
				}
			}

			$groups_sql = "";
			if(empty($role_groups) === FALSE)
			{
				// user has not been assigned explicit roles or user has been assigned a role explitly and that role is the member group default
				// and the member is in one of the allowed groups
				$groups_sql = "((r.role IS NULL || r.role = '') AND m.group_id IN (".implode(",", $role_groups)."))  OR ";
			}

			$sql = "SELECT 
						m.username,
						m.screen_name,
						m.email,
						m.group_id,
						r.*
			 		FROM `exp_members` as m 
					LEFT JOIN `exp_nsm_acl_roles` AS r ON r.member_id = m.member_id
					WHERE
						{$groups_sql} 
						(
							r.role = '{$role}' AND
							r.weblog_id = {$weblog_id} AND
							r.class_name = '".__CLASS__."'
						)";

			//print($sql);
			//print("\n" . $role);
			//print_r($role_groups);

			$role_query = $DB->query($sql);

			$SESS->cache['nsm'][NSM_PP_addon_id]['weblogs'][$weblog_id]['nsm_pp_'.$role.'_query'] = $role_query;
		}

		return($SESS->cache['nsm'][NSM_PP_addon_id]['weblogs'][$weblog_id]['nsm_pp_'.$role.'_query']);
		
	}

}
?>