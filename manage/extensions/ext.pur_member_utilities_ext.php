<?php if ( ! defined('EXT')) exit('No direct script access allowed');

/**
 * Pur Member Utilities
 *
 * An ExpressionEngine Extension & Module package that enables extra member functions
 *
 * @package		Pur_member_utilities
 * @author		Greg Salt <greg@purple-dogfish.co.uk>
 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
 * @license		http://www.purple-dogfish.co.uk/licence/commercial
 * @link		http://www.purple-dogfish.co.uk/buy-stuff/
 * @since		Version 1.0
 * 
 */

/**
 * Changelog
 * Version 1.0.3 20100521
 * Bug fix: changed storage of email templates to allow for quotes
 * Bug fix: fixed image paths
 * Enhancement: added ability auto empty profile when banning a member
 * Enhancement: allow member group change/banning from member search results
 * Enhancement: CP logging of profile updates
 * Enhancement: module component to show all members with populated bio fields
 * Enhancement: check protocol to allow use in SSL'd CP
 * Enhancement: MU features available after CP member searches
 *
 * Version 1.0.2 20100330
 * Bug fix: display of member groups in MSM environment
 * Bug fix: removed erroneous message about member data when banning
 * Enhancement: module component now allows groups other than Super Admin to use features
 * Enhancement: module component now allows templated email notifications on profile updates
 * 
 * Version 1.0.1 20091230
 * Changed method of calling public profile to account for renamed index.php files
 *
 * Version 1.0 20091222
 * Initial public release of package
 */

class Pur_member_utilities_ext {
	
	var $settings 		= array();
	var $name 			= 'Member Utilities';
	var $version 		= '1.0.3';
	var $description	= 'Additional member functions within the CP';
	var $settings_exist	= 'n';
	var $docs_url		= 'http://www.purple-dogfish.co.uk';

	var $debug			= FALSE; // If TRUE all POST variables will be added to email
	
	/**
	 * Constructor
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function Pur_member_utilities_ext($settings = 'n')
	{
		$this->settings = $settings;
		$protocol = (isset($_SERVER['HTTPS']) AND $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
		defined("PROTOCOL")  or define("PROTOCOL", $protocol);
	}
	/* End pur_member_utilities_ext */
	
	/**
	 * Rewrite Member Functions
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		string		$out		Modified control panel
	 */
	function rewrite_member_functions($out)
	{
		global $DSP, $DB, $IN, $EXT, $PREFS, $FNS;
		
		$EXT->end_script = FALSE;
		
		if ($EXT->last_call != FALSE)
		{
			$out = $EXT->last_call;
		}
		
		if (
				(
					(
						$IN->GBL('C', 'GET') == 'admin' AND
						$IN->GBL('M', 'GET') == 'members'
					)
					OR
					(
						$IN->GBL('C', 'GET') == 'modules' AND
						$IN->GBL('M', 'GET') == 'Pur_member_utilities'
					)
				)
				AND
				(
					$IN->GBL('P', 'GET') == 'view_members' OR
					$IN->GBL('P', 'GET') == 'mbr_delete' OR
					$IN->GBL('P', 'GET') == 'register_member' OR
					$IN->GBL('P', 'GET') == 'do_member_search' OR
					$IN->GBL('P', 'GET') == 'all'
				)
			)
		{
			$search = '/(<tr>.<td\s+class=[\'\"]tableCell[a-zA-Z]{3}[\'\"]\s*>.+C=myaccount&amp;id=(\d+)[\'\"].+\/a>)(.+<\/tr>)/xsU';

			$replace = '
\1&nbsp;<img class="show_details" rel="\2" src="'.PROTOCOL.$_SERVER['HTTP_HOST'].'/themes/pur_member_utilities_images/bullet_toggle_plus.png" style="vertical-align: middle;"/>\3
<tr id="details_\2" style="display: none;">
	<td colspan="7" class="box" style="border: 0; border-bottom: 1px solid #cad0d5; border-top: 1px solid #cad0d5; width: 100%;">
		<div>
		</div>
	</td>
</tr>';

			$out = preg_replace($search, $replace, $out);
			
			$search = '/(<form.+)C=admin&amp;M=members&amp;P=mbr_conf(.+>)/sU';
			$replace = '\1'.'C=modules&M=Pur_member_utilities'.'\2';
			$out = preg_replace($search, $replace, $out);
			
			$search = '/(<option value=["\']delete["\']>.*?<\/option>)/';
			$replace = '\1'."\n".'<option value="move">Change Member Group</option>';
			$out = preg_replace($search, $replace, $out);
			
			// For the member search results page
			if ($IN->GBL('P', 'GET') == 'do_member_search')
			{
				$search = '/(<form.+)C=admin&amp;M=members&amp;P=(mbr_del_conf)(.+>)/sU';
				$replace = '\1'.'C=modules&M=Pur_member_utilities&amp;P=mbr_conf'.'\3';
				$out = preg_replace($search, $replace, $out);
				
				$search = '/(<input.*submit.+Delete.*)/';
				$replace = '<input type="submit" class="submit" value="Submit" />&nbsp;&nbsp;<select name="action" class="select"><option value="delete">Delete Selected Members</option><option value="move">Change Member Group</option></select>';
				$out = preg_replace($search, $replace, $out);
			}
			
			$search = '/(<td\s+class=["\']defaultRight["\']\s+colspan=[\'"]2[\'"].+<\/h5>)/sU';
			$replace = '\1'."\n".'<a href="'.BASE.AMP.'C=modules&M=Pur_member_utilities&P=all">Show members with populated biographies</a>'.$DSP->nbs(4);
			$out = preg_replace($search, $replace, $out);
		}

		// Get ACT for get_member_data()
		$query  = $DB->query("SELECT action_id FROM exp_actions WHERE class = 'Pur_member_utilities_CP' AND method = 'get_member_data'");
		$action_id = (isset($query->row['action_id']) AND $query->row['action_id'] != '') ? $query->row['action_id'] : '';
		
		$js = '<script type="text/javascript">
			$(document).ready(function() {
				$(".show_details").css("cursor", "pointer").click(function() {
					
					var memberID = $(this).attr("rel");
					var detailsVisible = $("#details_" + memberID).css("display");
					
					if (detailsVisible == "none")
					{
						$(this).attr("src", "'.PROTOCOL.$_SERVER['HTTP_HOST'].'/themes/pur_member_utilities_images/bullet_toggle_minus.png'.'");
						
						$.get("'.PROTOCOL.$_SERVER['HTTP_HOST'].$PREFS->core_ini['site_index'].'?ACT='.$action_id.'", {member_id: memberID}, function(data) {
							$("#details_" + memberID + " td div").html(data);
						});
					}
					
					if (detailsVisible != "none")
					{
						$(this).attr("src", "'.PROTOCOL.$_SERVER['HTTP_HOST'].'/themes/pur_member_utilities_images/bullet_toggle_plus.png'.'");
					}
					
					// Would have loved to use toggle() here
					// Unfortunately IE8 does not work properly so therefore...
					var elem = $("#details_" + memberID)[0];
					if (elem.style.display == "none") {
						$("#details_" + memberID).show();
					} else {
						$("#details_" + memberID).hide();
					}
				});
			});
		</script>
		</head>';
		
		$out = str_replace('</head>', $js, $out);
		
		return $out;
	}
	/* End rewrite_member_functions */

    /**
     * Notify Profile Updates
     *
     * @author      Greg Salt <greg@purple-dogfish.co.uk>
     * @copyright   Copyright (c) 2010 Purple Dogfish Ltd
     * @access      Public
     * @return      void
     */
    function notify_profile_updates($SESS)
    {
		// Let's not bother with bots
		if ($SESS->userdata['member_id'] == '0')
		{
			return;
		}
		
		global $IN, $PREFS;

		$site_id = $PREFS->core_ini['site_id'];
		$bio = $IN->GBL('bio', 'POST');
		$url = $IN->GBL('url', 'POST');

		$url = (strtolower($url) == 'http://') ? '' : $url;

		if ($bio != '' OR $url != '')
		{
			global $DB, $EXT, $PREFS, $REGX;

			if ($EXT->last_call != '')
			{
				$SESS = $EXT->last_call;
			}

			$EXT->end_script = FALSE;

			$query = $DB->query("SELECT bio, url FROM exp_members
								WHERE member_id = '".$SESS->userdata['member_id']."'
								AND bio = '".$DB->escape_str($bio)."'
								AND url = '".$DB->escape_str($url)."'");

			if ($query->num_rows == 0)
			{
				// This is an update so let's notify someone..

				$query = $DB->query("SELECT settings FROM exp_pur_member_utilities_settings WHERE id = '".$site_id."'");
				
				if ($query->num_rows == 0)
				{
					return;
				}

				$all_settings = $REGX->array_stripslashes(unserialize($query->row['settings']));
				$settings = $all_settings[$PREFS->core_ini['site_id']];
				if ($settings['notify'] == 'n')
				{
					return;
				}

				// Get values for template replacement
				$member_id = $SESS->userdata['member_id'];
				$username = $SESS->userdata['username'];
				$email = $SESS->userdata['email'];
				$ip_address = $SESS->userdata['ip_address'];


				$recipients = implode(',', $settings['recipients']);
				$subject = $settings['subject'];
				$template = $settings['template'];

				// Replacement template variables
				$vars = array('{member_id}', '{username}', '{email}', '{ip_address}', '{bio}', '{url}');
				$reps = array($member_id, $username, $email, $ip_address, $bio, $url);
				$template = str_replace($vars, $reps, $template);

				if ($this->debug)
				{
					$template .= "\r\n\r\nDebug\r\n---------------------\r\n";
					foreach($_POST AS $key => $val)
					{
						$clean_key = trim(var_export($REGX->xss_clean($key), TRUE), ')');
						$clean_val = trim(var_export($REGX->xss_clean($val), TRUE), ')');
						$template .= "$clean_key => $clean_val)\r\n\r\n";
					}
				}
				
				if ( ! class_exists('EEmail'))
				{
					require PATH_CORE.'core.email'.EXT;
				}

				$email = new EEmail;
				
				$email->wordwrap = TRUE;
				$email->mailtype = 'plain';
				$email->priority = '3';
				$email->initialize();
				$email->to($recipients);
				$email->from($PREFS->ini('webmaster_email'), $PREFS->ini('webmaster_name'));
				$email->reply_to($PREFS->ini('webmaster_email'), $PREFS->ini('webmaster_name'));
				$email->subject($subject);
				$email->message($template);
				$email->send();

				// Now log it
				require_once PATH_MOD.'pur_member_utilities/language/pmul.php';
				$L = new Pmul();
				$L->fetch_language_file('pur_member_utilities');
				$action = sprintf($L->line('pur_member_utilities_log'), $username);
				$this->_log_action($action);
				
			}
		}

		return;
    }
    /* End notify_profile_updates */

	/**
	 * Log Action
	 * This is a modified copy of the ExpressionEngine function
	 * 
	 * @since	1.0.3
	 * @access	private
	 * @param	string	$action	Data to be logged in the CP log
	 * @return 	void
	 */
	function _log_action($action = '')
	{
		global $DB, $IN, $LOC, $PREFS;

		if ($action == '')
		{
			return;
		}

        if (is_array($action))
        {
        	if (count($action) == 0)
        	{
        		return;
        	}

            $msg = '';

            foreach ($action as $val)
            {
                $msg .= $val."\n";
            }

            $action = $msg;
        }

        $DB->query(
                     $DB->insert_string(
                                           'exp_cp_log',

                                            array(
                                                    'id'         => '',
                                                    'member_id'  => 1,
                                                    'username'   => 'Member Utilities',
                                                    'ip_address' => '127.0.0.1',
                                                    'act_date'   => $LOC->now,
                                                    'action'     => $action,
                                                    'site_id'	 => $PREFS->ini('site_id')
                                                 )
                                            )
                    );
	}
	/* End _log_action */
	
	/**
	 * Activate Extension
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function activate_extension($from_module = FALSE)
	{
		if ( ! $from_module)
		{
			global $LANG, $OUT;
			
			$LANG->fetch_language_file('pur_member_utilities');
			
			return $OUT->fatal_error($LANG->line('pur_member_utilities_install_from_module'));
		}
		
		global $DB;
		
		$DB->query($DB->insert_string('exp_extensions',
										array(
											'extension_id' 	=> '',
											'class'			=> get_class($this),
											'method'		=> 'rewrite_member_functions',
											'hook'			=> 'show_full_control_panel_end',
											'settings'		=> '',
											'priority'		=> 10,
											'version'		=> $this->version,
											'enabled'		=> 'y'
											)
										)
					);
					
		$DB->query($DB->insert_string('exp_extensions',
										array(
											'extension_id' 	=> '',
											'class'			=> get_class($this),
											'method'		=> 'notify_profile_updates',
											'hook'			=> 'sessions_end',
											'settings'		=> '',
											'priority'		=> 10,
											'version'		=> $this->version,
											'enabled'		=> 'y'
											)
										)
					);
	}
	/* End activate_extension */
	
	/**
	 * Update Extension
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		bool		Returns TRUE if updated successfully
	 */
	function update_extension($current = '')
	{
		global $DB;

		if ($current < '1.0.2')
		{	
			// Make sure that the sessions_start method is correct
			$this->disable_extension(TRUE);
			$this->activate_extension(TRUE);
		}

		if ($current < '1.0.3')
		{
			$sql[] = $DB->update_string('exp_modules', array('module_version' => '1.0.3'), "module_name = 'Pur_member_utilities'");
			$sql[] = $DB->update_string('exp_extensions', array('version' => '1.0.3'), "class = 'Pur_member_utilities_ext'");
			foreach($sql AS $query)
			{
				$DB->query($query);
			}
		}
		
		return TRUE;
	}
	/* End update_extension */
	
	/**
	 * Disable Extension
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function disable_extension($from_module = FALSE)
	{
		global $DB, $LANG, $OUT;
		
		if ($from_module === FALSE)
		{
			$DB->query("UPDATE exp_extensions SET enabled = 'y' WHERE class = '".get_class($this)."'");

			$LANG->fetch_language_file('pur_member_utilities');
			
			return $OUT->fatal_error($LANG->line('pur_member_utilities_disable_from_module'));			
		}
		
		$DB->query("DELETE FROM exp_extensions WHERE class = '".get_class($this)."'");
	}
	/* End disable_extension */
}
/* End of file ext.pur_member_utilities_ext.php */
/* Location: ./system/modules/ext.pur_member_utilities_ext.php */