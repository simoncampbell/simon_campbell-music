<?php
/**
* LG Live Look extension file
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package LgLiveLook
* @version 1.0.4
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-live-look/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license {@link http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported} All source code commenting and attribution must not be removed. This is a condition of the attribution clause of the license.
*/

if ( ! defined('EXT')) exit('Invalid file request');

if ( ! defined('LG_LL_version'))
{
	define("LG_LL_version",			"1.1.0");
	define("LG_LL_docs_url",		"http://leevigraham.com/cms-customisation/expressionengine/addon/lg-live-look/");
	define("LG_LL_addon_id",		"LG Live Look");
	define("LG_LL_extension_class",	"Lg_live_look_ext");
	define("LG_LL_cache_name",		"lg_cache");
}

/**
* This extension adds a image preview to the edit page.
*
* @package LgLiveLook
* @version 1.0.1
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-live-look/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license {@link http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported} All source code commenting and attribution must not be removed. This is a condition of the attribution clause of the license.
*
*/
class Lg_live_look_ext {

	/**
	* Extension settings
	* @var array
	*/
	var $settings			= array();

	/**
	* Extension name
	* @var string
	*/
	var $name				= 'LG Live Look';

	/**
	* Extension version
	* @var string
	*/
	var $version			= LG_LL_version;

	/**
	* Extension description
	* @var string
	*/
	var $description		= 'This extension adds Live Look link to your sites edit pages.';

	/**
	* If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	* @var string
	*/
	var $settings_exist 	= 'y';

	/**
	* Link to extension documentation
	* @var string
	*/
	var $docs_url			= LG_LL_docs_url;
	
	/**
	* Debug?
	* @var boolean
	*/
	var $debug 				= FALSE;

	/**
	* PHP4 Constructor
	*
	* @see __construct()
	*/
	function Lg_live_look_ext( $settings="" )
	{
		$this->__construct($settings);
	}

	/**
	* PHP 5 Constructor
	*
	* @param	array|string $settings Extension settings associative array or an empty string
	* @since	Version 1.0.0
	*/
	function __construct( $settings="" )
	{
		global $IN, $SESS;
		if(isset($SESS->cache['lg']) === FALSE){ $SESS->cache['lg'] = array(); }
		$this->settings = $this->_get_settings();
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
		if($this->debug === TRUE) print("<br />publish_form_start");

		global $DB, $EE, $EXT, $IN, $LANG, $LOC, $REGX, $SESS;

		$weblog_id = $IN->GBL("weblog_id");

		if(empty($entry_id) === TRUE) $entry_id = $IN->GBL("entry_id");

		// action will always be passed
		$SESS->cache['lg'][LG_LL_addon_id]['publish_form_action'] = $which;
		$SESS->cache['lg'][LG_LL_addon_id]['publish_form_entry_id'] = $entry_id;

	}

	/**
	* Adds a table header to the edit entries page.
	* 
	* @return 	string	The new table headers
	* @since 	Version 1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_additional_tableheader/
	**/
	function edit_entries_additional_tableheader()
	{

		if($this->debug === TRUE) print("<br />edit_entries_additional_tableheader");

		global $DSP, $LANG, $EXT, $SESS;
		$extra = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';
		if(
			// enabled?
			$this->settings['enable'] == 'y' &&
			// allowed member group?
			in_array($SESS->userdata['group_id'], $this->settings['allowed_member_groups'])
		)
		{
			$extra .= $DSP->table_qcell('tableHeadingAlt', "Live Look");
		} 
		return $extra;
	}

	/**
	* Adds a table cell to the edit entries page.
	* 
	* @return 	string	The new table cells
	* @since 	Version 1.0.0
	* @see		http://expressionengine.com/developers/extension_hooks/edit_entries_additional_celldata/
	**/
	function edit_entries_additional_celldata( $row )
	{
		if($this->debug === TRUE) print("<br />edit_entries_additional_celldata");

		global $DB, $DSP, $EXT, $PREFS, $LANG, $SESS, $row_i;

		if (empty($row_i)){ $row_i = 0; }

		$extra = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';

		if(
			$this->settings['enable'] == 'y' &&
			in_array($SESS->userdata['group_id'], $this->settings['allowed_member_groups'])
		)
		{
			if(
				isset($this->settings['weblogs'][$row['weblog_id']]) &&
				$this->settings['weblogs'][$row['weblog_id']]['display_link'] == "y" &&
				empty($this->settings['weblogs'][$row['weblog_id']]['live_look_path']) === FALSE
			)
			{
				if(isset($PREFS->core_ini['site_pages'][$row['entry_id']]) === TRUE)
				{
					$ret = $PREFS->ini('site_url') . $PREFS->core_ini['site_pages'][$row['entry_id']];
				}
				else
				{
					$ret = $this->_parse_url($row['entry_id']);
				}
			}

			$ret = (isset($ret) === TRUE) ? "<a href='". $ret."' target='_blank'>".$LANG->line("live_look")."</a>" : "&nbsp;";
			$style = ($row_i % 2) ? 'tableCellOne' : 'tableCellTwo'; $row_i++;
			return $extra . "<td class='" . $style . "'>" . $ret . "</td>";
		}

		return $extra;
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
		if($this->debug === TRUE) print("<br />publish_form_new_tabs");

		global $EXT, $PREFS, $SESS;

		if($EXT->last_call !== FALSE)
		{
			$publish_tabs = $EXT->last_call;
		}

		if(
			// enabled?
			$this->settings['enable'] == 'y' &&
			// allowed member group?
			in_array($SESS->userdata['group_id'], $this->settings['allowed_member_groups']) &&
			// show tab for this weblog
			( isset($this->settings['weblogs'][$weblog_id]) && $this->settings['weblogs'][$weblog_id]['display_tab'] == "y" )
		)
		{
			$publish_tabs['llp'] = 'Live Look';
		}

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
		if($this->debug === TRUE) print("<br />publish_form_new_tabs_block");

		global $DB, $EXT, $PREFS, $SESS, $LANG, $REGX, $IN, $DSP;

		$LANG->fetch_language_file('lg_live_look_ext');

		$ret = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';

		if(
			// enabled?
			$this->settings['enable'] == 'y' &&
			// allowed member group?
			in_array($SESS->userdata['group_id'], $this->settings['allowed_member_groups']) &&
			// show tab for this weblog
			( isset($this->settings['weblogs'][$weblog_id]) && $this->settings['weblogs'][$weblog_id]['display_tab'] == "y" )
		)
		{
			$entry_id = $SESS->cache['lg'][LG_LL_addon_id]['publish_form_entry_id'];
			$ret .= "<!-- Start LG Live Look Tab -->";
			$ret .= "<div id='blockllp' style='display:none'>";
			$ret .= $DSP->div('publishTabWrapper');
			$ret .= $DSP->div('publishBox');

			// if there is an entry (edit page)
			if($entry_id != FALSE)
			{
				if(($draft_id = $IN->GBL("draft_id")) !== FALSE)
				{
					$ret .= "<p style='float:left; margin:6px 0 0 0'><strong>Draft #" . $draft_id . "</strong></p>";
				}
				elseif(($version_id = $IN->GBL("version_id")) !== FALSE)
				{
					$ret .= "<p style='float:left; margin:6px 0 0 0'><strong>Version #" . $version_id . "</strong></p>";
				}
				elseif(($preview_id = $IN->GBL("preview_id")) !== FALSE)
				{
					$ret .= "<p style='float:left; margin:6px 0 0 0'><strong>Preview #" . $preview_id . "</strong></p>";
				}
				
				$ret .= "<p style='text-align:right; margin-bottom:9px'><a href='#' onclick='return enlarge_iframe();' style='outline:none'><img src='".PATH_CP_IMG."expand.gif' border='0' /> ".$LANG->line('enlarge_iframe')."</a>&nbsp;&nbsp;&nbsp;<a href='#' onclick='return shrink_iframe();' style='outline:none'><img src='".PATH_CP_IMG."collapse.gif' border='0' /> ".$LANG->line('shrink_iframe')."</a></p>";
				$ret .= "<div style='border:1px solid #C5CFDA; margin:0 0 9px 0;'><iframe id='llp_frame' src='' style='background:#fff; border:none; padding:0; margin:0; width:100%;'></iframe></div>";
				$ret .= "<p style='text-align:right; margin-bottom:9px'><a href='#' onclick='return enlarge_iframe();' style='outline:none'><img src='".PATH_CP_IMG."expand.gif' border='0' /> ".$LANG->line('enlarge_iframe')."</a>&nbsp;&nbsp;&nbsp;<a href='#' onclick='return shrink_iframe();' style='outline:none'><img src='".PATH_CP_IMG."collapse.gif' border='0' /> ".$LANG->line('shrink_iframe')."</a></p>";
			}
			else
			{
				$ret .= '<div class="publishInnerPad">
					<table cellspacing="0" cellpadding="0" border="0" style="width: 99%;" class="clusterBox"><tbody>
										<tr>
											<td valign="top" class="publishItemWrapper"><br/>
												<div class="highlight">'.$LANG->line('save_entry_msg').'</div>
											</td>
										</tr></tbody></table>
				</div>';
			}
			$ret .= '<script type="text/javascript" charset="utf-8">var lg_live_look_url = "'.$this->_parse_url($entry_id).'";</script>';
			$SESS->cache['lg'][LG_LL_addon_id]['require_scripts'] = TRUE;
			$ret .= $DSP->div_c();
			$ret .= $DSP->div_c();
			$ret .= $DSP->div_c();
			$ret .= "<!-- End LG Live Look Tab -->";
		}
		return $ret;
	}

	/**
	* Takes the control panel html and replaces the drop down
	*
	* @param	string $out The control panel html
	* @return	string The modified control panel html
	* @since 	Version 0.0.1
	*/
	function show_full_control_panel_end( $out )
	{
		if($this->debug === TRUE) print("<br />show_full_control_panel_end");

		global $DB, $EXT, $IN, $PREFS, $REGX, $SESS;

		// -- Check if we're not the only one using this hook
		if($EXT->last_call !== FALSE)
			$out = $EXT->last_call;

		if(
			$this->settings['enable'] == 'y'
			&& in_array($SESS->userdata['group_id'], $this->settings['allowed_member_groups'])
			&& isset($SESS->cache['lg'][LG_LL_addon_id]['require_scripts']) === TRUE
			&& ($IN->GBL('C', 'GET') == 'publish' || $IN->GBL('C', 'GET') == 'edit')
		)
		{
			$js = "";
			if(empty($SESS->cache['scripts']['jquery']['cookie']) === TRUE)
			{
				$js .= NL."<script type='text/javascript' charset='utf-8' src='". $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/lg_live_look/js/jquery.cookie.min.js'></script>";
				$SESS->cache['scripts']['jquery']['cookie'] = TRUE;
			}

			$js .= NL."<script type='text/javascript' charset='utf-8' src='". $PREFS->ini('theme_folder_url', 1) . "cp_themes/".$PREFS->ini('cp_theme')."/lg_live_look/js/admin_publish.js'></script>";

			if(@$SESS->cache['nsm']['show_live_look_tab'] === TRUE || @$SESS->cache['lg']['show_live_look_tab'] === TRUE)
			{
				$js .= NL . '<script type="text/javascript" charset="utf-8">
	$iframe.attr({"src": lg_live_look_url});
	showblock("blockllp");
	stylereset("llp");
</script>';
			}

			if(
				$this->settings["weblogs"][$IN->GBL("weblog_id")]["disable_preview"] == "y"
				&& !preg_match("/fieldset.*?Error/mis", $out)
			)
			{
				$css = '<style type="text/css" media="screen">fieldset.previewBox{display:none}</style>';
				$out = str_replace("</head>", $css . "</head>", $out);
			}
			$out = str_replace("</body>", $js . "</body>", $out);
		}

		return $out;
	}

	/**
	* Parses the weblog live look url based on the entry id and returns the new string
	* 
	* @param integer $entry_id
	* @param array $row Data from the exp_weblog_titles table
	* @return string the new url with {ee} variables replaced
	**/
	function _parse_url( $entry_id = FALSE, $row = FALSE )
	{
		if($this->debug === TRUE) print("<br />_parse_url");

		global $DB, $EXT, $FNS, $IN, $PREFS, $REGX, $SESS;

		$ret = '';
		
		if(empty($entry_id) === TRUE) return FALSE;

		if(isset($PREFS->core_ini["site_pages"]["uris"][$entry_id]))
		{
			$ret = $FNS->create_url($PREFS->core_ini["site_pages"]["uris"][$entry_id]);
		}
		elseif($row === FALSE)
		{
			$query = $DB->query("SELECT * FROM `exp_weblog_titles` 
								LEFT JOIN `exp_weblog_data` 
								ON `exp_weblog_titles`.`entry_id` = `exp_weblog_data`.`entry_id`
								WHERE `exp_weblog_titles`.`entry_id` = " . $entry_id . " LIMIT 1");

			if($query->num_rows > 0)
			{
				$query->row['entry_date_day'] = date('d', $query->row['entry_date']);
				$query->row['entry_date_month'] = date('m', $query->row['entry_date']);
				$query->row['entry_date_year'] = date('Y', $query->row['entry_date']);
				$ret = $this->settings['weblogs'][$query->row['weblog_id']]['live_look_path'];

				foreach ($query->row as $key => $value)
				{
					if(strpos($ret, LD.$key.RD) !== FALSE)
					{
						$ret = str_replace(LD.$key.RD, $value, $ret);
					}
				}
			}
		}

		$nsm_pp_query = $DB->query("SELECT class, settings FROM exp_extensions WHERE class = 'Nsm_publish_plus_ext' AND enabled = 'y' LIMIT 1");
		if($nsm_pp_query->num_rows == 1)
		{
			$NSM_PP = new Nsm_publish_plus_ext;
			if(($draft_id = $IN->GBL("draft_id")) !== FALSE)
			{
				$ret .= "/".$NSM_PP->settings["draft_trigger"] . "/" . $draft_id . "/";
			}
			elseif(($version_id = $IN->GBL("version_id")) !== FALSE)
			{
				$ret .= "/".$NSM_PP->settings["revision_trigger"] . "/" . $version_id . "/";
			}
			elseif(($preview_id = $IN->GBL("preview_id")) !== FALSE)
			{
				$ret .= "/".$NSM_PP->settings["preview_trigger"] . "/" . $preview_id . "/";
			}
		}

		return $FNS->remove_double_slashes($ret);
	}

	/**
	* Get the site specific settings from the extensions table
	*
	* @param 	$force_refresh		bool	Get the settings from the DB even if they are in the $SESS global
	* @param 	$return_all			bool	Return the full array of settings for the installation rather than just this site
	* @return 	array 						If settings are found otherwise false. Site settings are returned by default. Installation settings can be returned is $return_all is set to true
	* @since 	Version 2.0.0
	*/
	function _get_settings( $force_refresh = FALSE, $return_all = FALSE )
	{
		if($this->debug === TRUE) print("<br />_get_settings");

		global $SESS, $DB, $REGX, $LANG, $PREFS;

		// assume there are no settings
		$settings = FALSE;

		// Get the settings for the extension
		if(isset($SESS->cache['lg'][LG_LL_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . LG_LL_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache['lg'][LG_LL_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}

		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache['lg'][LG_LL_addon_id]['settings']) !== TRUE)
		{
			if($return_all === TRUE)
			{
				$settings = $SESS->cache['lg'][LG_LL_addon_id]['settings'];
			}
			else
			{
				if(isset($SESS->cache['lg'][LG_LL_addon_id]['settings'][$PREFS->ini('site_id')]) === TRUE)
				{
					$settings = $SESS->cache['lg'][LG_LL_addon_id]['settings'][$PREFS->ini('site_id')];
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
	* Configuration for the extension settings page
	* 
	* @param $current array  The current settings for this extension. We don't worry about those because we get the site specific settings
	* @since Version 2.0.0
	**/
	function settings_form( $current )
	{
		global $DB, $DSP, $LANG, $IN, $PREFS, $SESS;

		// create a local variable for the site settings
		$settings = $this->_get_settings();

		$DSP->crumbline = TRUE;

		$DSP->title  = $LANG->line('extension_settings');
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));

		$DSP->crumb .= $DSP->crumb_item($LANG->line('lg_image_preview_title') . " {$this->version}");

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		$DSP->body = '';

		if(isset($settings['show_promos']) === FALSE) {$settings['show_promos'] = 'y';}
		if($settings['show_promos'] == 'y')
		{
			$DSP->body .= "<script src='http://leevigraham.com/promos/ee.php?id=" . rawurlencode(LG_LL_addon_id) ."&v=".$this->version."' type='text/javascript' charset='utf-8'></script>";
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
							<a rel='external' href='https://www.paypal.com/cgi-bin/webscr?cmd=_donations&amp;business=sales@newism%2ecom%2eau&amp;item_name=LG%20Expression%20Engine%20Development&amp;amount=10%2e00&amp;no_shipping=1&amp;return=http%3a%2f%2fleevigraham%2ecom%2fdonate%2fthanks&amp;cancel_return=http%3a%2f%2fleevigraham%2ecom%2fdonate%2fno%2dthanks&amp;no_note=1&amp;tax=0&amp;currency_code=USD&amp;lc=US&amp;bn=PP%2dDonationsBF&amp;charset=UTF%2d8' class='button' target='_blank'>Donate</a>
						</p>";
		}

		$DSP->body .= $DSP->heading($LANG->line('lg_image_preview_title') . " <small>{$this->version}</small>");
		
		$DSP->body .= $DSP->form_open(
								array(
									'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings'
								),
								// WHAT A M*THERF!@KING B!TCH THIS WAS
								// REMEMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
								// BUG??
								array('name' => strtolower(LG_LL_extension_class))
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


		// query the db for the member groups
		$query = $DB->query("SELECT group_id, group_title FROM exp_member_groups WHERE site_id = " . $PREFS->core_ini['site_id'] . " ORDER BY group_id");

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableCellTwo', '30%')
			. $DSP->qdiv('defaultBold', $LANG->line('which_groups_label'))
			. $DSP->td_c();

		$DSP->body .= $DSP->td('tableCellTwo');

		foreach($query->result as $row)
		{
			$DSP->body .=  $DSP->qdiv('', "<div><label>"
											. $DSP->input_checkbox(
												'allowed_member_groups[]',
												$row['group_id'],
												((in_array($row['group_id'], $settings['allowed_member_groups'])) ? 'y' : 'n')
											) . $row['group_title'] . "</label></div>"
										);
		}

		$DSP->body .= $DSP->td_c()
			. $DSP->tr_c()
			. $DSP->table_c();

		// Weblog Settings
		$DSP->body .= $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .= $DSP->tr()
			. $DSP->td('tableHeading', '', '3')
			. $LANG->line("weblog_settings")
			. $DSP->td_c()
			. $DSP->tr_c();

		$DSP->body .= $DSP->tr()
			. $DSP->td('', '', '3')
			. "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'>" . $LANG->line('weblog_settings_info') . "</div>"
			. $DSP->td_c()
			. $DSP->tr_c();

		$weblogs = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = " . $PREFS->ini('site_id'));

		if ($weblogs->num_rows > 0)
		{
			$i = 0;
			foreach($weblogs->result as $row)
			{

				$class = ($i % 2) ? 'tableCellTwo':'tableCellOne';
				$weblog_settings = $this->settings['weblogs'][$row['weblog_id']];

				$DSP->body .= $DSP->tr()
					. "<td class='{$class}' rowspan='4' width='150px'>"
					. $DSP->qdiv('defaultBold', $row['blog_title']);
					
				$DSP->body .= $DSP->td($class)
					. "<small>".$LANG->line('display_tab_label').":</small>"
					. $DSP->td_c()
					. $DSP->td($class)
					. "<select name='weblogs[{$row['weblog_id']}][display_tab]'>"
						. $DSP->input_select_option('y', "Yes", (($weblog_settings['display_tab'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($weblog_settings['display_tab'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
					. $DSP->td_c()
					. $DSP->tr_c();

				$DSP->body .= $DSP->td($class)
					. "<small>".$LANG->line('display_link_label').":</small>"
					. $DSP->td_c()
					. $DSP->td($class)
					. "<select name='weblogs[{$row['weblog_id']}][display_link]'>"
						. $DSP->input_select_option('y', "Yes", (($weblog_settings['display_link'] == 'y') ? 'y' : '' ))
						. $DSP->input_select_option('n', "No", (($weblog_settings['display_link'] == 'n') ? 'y' : '' ))
						. $DSP->input_select_footer()
					. $DSP->td_c()
					. $DSP->tr_c();

				$DSP->body .= $DSP->tr()
							. $DSP->td($class, '250px')
							. "<small>".$LANG->line('disable_preview_label').":</small>"
							. $DSP->td_c()
							. $DSP->td($class)
							. "<select name='weblogs[".$row['weblog_id']."][disable_preview]'>"
								. $DSP->input_select_option('y', "Yes", ((@$weblog_settings['disable_preview'] == 'y') ? 'y' : '' ))
								. $DSP->input_select_option('n', "No", ((@$weblog_settings['disable_preview'] == 'n') ? 'y' : '' ))
								. $DSP->input_select_footer()
							. $DSP->td_c()
							. $DSP->tr_c();

				$DSP->body .= $DSP->tr()
							. $DSP->td($class, '')
							. "<small>".$LANG->line('live_look_path_label').":</small>"
							. $DSP->td_c()
							. $DSP->td($class)
							. $DSP->input_text("weblogs[{$row['weblog_id']}][live_look_path]", $weblog_settings['live_look_path'], '', '')
							. $DSP->td_c()
							. $DSP->tr_c();
				$i++;
			}
		}
		else
		{
			$DSP->body .= "<tr><td colspan='2' class='tableCellOne'><p class='highlight'>" . $LANG->line('no_weblogs_msg') . "</p></td></tr>";
		}

		$DSP->body .= $DSP->table_c();

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
	* 
	* @since	Version 2.0.0
	**/
	function save_settings()
	{
		// make somethings global
		global $DB, $IN, $PREFS, $REGX, $SESS;

		$default_settings = $this->_build_default_settings();

		// merge the defaults with our $_POST vars
		$_POST = $REGX->xss_clean(array_merge($default_settings, $_POST));

		// unset the name
		unset($_POST['name']);

		foreach ($_POST['weblogs'] as $key => $value)
		{
			unset($_POST['weblogs_' . $key]);
		}

		// load the settings from cache or DB
		// force a refresh and return the full site settings
		$settings = $this->_get_settings(TRUE, TRUE);

		// add the posted values to the settings
		$settings[$PREFS->ini('site_id')] = $_POST;

		// update the settings
		$query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . LG_LL_extension_class . "'");
	}

	/**
	* Returns the default settings for this extension
	* This is used when the extension is activated or when a new site is installed
	*/
	function _build_default_settings()
	{
		if($this->debug === TRUE) print("<br />_build_default_settings");

		global $DB, $PREFS;

		$default_settings = array(
								'enable' 					=> 'y',
								'show_donate'				=> 'y',
								'show_promos'				=> 'y',
								'allowed_member_groups'		=> array(1),
								'weblogs'					=> array(),
								'check_for_updates'			=> 'y',
								'disable_preview' 			=> 'n'
							);

		// get all the sites
		$query = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = '".$PREFS->core_ini['site_id']."'");

		// if there are weblogs
		if ($query->num_rows > 0)
		{
			// for each of the sweblogs
			foreach($query->result as $row)
			{
				// duplicate the default settings for this site
				// that way nothing will break unexpectedly
				$default_settings['weblogs'][$row['weblog_id']] = array(
					'display_link' 		=> 'n',
					'display_tab' 		=> 'n',
					'live_look_path' 	=> ''
				);
			}
		}

		return $default_settings;

	}

	/**
	* Activates the extension
	*
	* @return	bool Always TRUE
	* @since	Version 2.0.0
	*/
	function activate_extension()
	{
		global $DB, $FNS, $PREFS;

		$default_settings = $this->_build_default_settings();

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
				$settings[$row['site_id']]['weblogs'][$row['weblog_id']] = array(
					'display_link' 		=> 'n',
					'display_tab'		=> 'n',
					'live_look_path' 	=> $FNS->remove_double_slashes($row["comment_url"]."/{entry_id}/"),
					'disable_preview' 	=> 'n'
				);
			}
		}

		$hooks = array(
			'publish_form_start'					=> 'publish_form_start',
			'publish_form_new_tabs'					=> 'publish_form_new_tabs',
			'publish_form_new_tabs_block'			=> 'publish_form_new_tabs_block',
			'edit_entries_additional_tableheader'	=> 'edit_entries_additional_tableheader',
			'edit_entries_additional_celldata'		=> 'edit_entries_additional_celldata',
			'lg_addon_update_register_source'		=> 'lg_addon_update_register_source',
			'lg_addon_update_register_addon'		=> 'lg_addon_update_register_addon',
			'show_full_control_panel_end'			=> 'show_full_control_panel_end'
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
	* @since	Version 2.0.0
	*/
	function update_extension( $current = "" )
	{
		global $DB;

		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		$sql = array();

		// add our new robots options
		if ($current < '1.0.2')
		{

			// load the settings from cache or DB
			$this->settings = $this->_get_settings(TRUE, TRUE);

			$DB->query($DB->insert_string( 'exp_extensions', 
											array('extension_id' 	=> '',
												'class'			=> get_class($this),
												'method'		=> 'publish_form_start',
												'hook'			=> 'publish_form_start',
												'priority'		=> 10,
												'version'		=> $this->version,
												'enabled'		=> "y",
												'settings'		=> addslashes(serialize($this->settings))
											)
										));
		}

		if ($current < '1.0.4')
		{
			$this->settings = $this->_get_settings(TRUE, TRUE);

			// add our new default settings
			foreach ($this->settings as $site_id => $settings)
			{
				foreach ($settings['weblogs'] as $weblog_id => $weblog_settings)
				{
					$this->settings[$site_id]['weblogs'][$weblog_id]["disable_preview"] = "n";
				}
			}

			$update_string = "UPDATE `exp_extensions` SET `settings` = '".addslashes(serialize($this->settings))."' WHERE `exp_extensions`.`class` = '".get_class($this)."';";
			$DB->query($update_string);
		}

		$sql[] = "UPDATE `exp_extensions` SET `version` = '" . $DB->escape_str($this->version) . "' WHERE `class` = '" . get_class($this) . "'";

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
	* @since	Version 2.0.0
	*/
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM exp_extensions WHERE class = '" . get_class($this) . "'");
	}

	/**
	* Register a new Addon Source
	*
	* @param	array $sources The existing sources
	* @return	array The new source list
	* @since 	Version 2.0.0
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
	* @since 	Version 2.0.0
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
			$addons[LG_LL_addon_id] = $this->version;
		}

		return $addons;
	}
}
?>