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
 * @link		http://www.purple-dogfish.co.uk/buy-stuff/member-utilities
 * @since		Version 1.0
 * 
 */

/**
 * Changelog
 *
 * See ext.pur_member_utilities.php
 */

class Pur_member_utilities_CP {
	
	var $version 	= '1.0.3';
	var $perpage	= 50;
	
	/**
	 * Constructor
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return 		void
	 */
	function Pur_member_utilities_CP($switch = TRUE)
	{
		global $IN, $PMU, $PREFS, $SESS;

		$s = ($PREFS->ini('admin_session_type') != 'c') ? $SESS->userdata('session_id') : 0;

		defined("AMP") OR define("AMP", "&amp;");
		defined("BASE") OR define("BASE", SELF.'?S='.$s);
		
		if ( ! class_exists('Pur_member_utilities_ext'))
		{
			require_once PATH_EXT.'ext.pur_member_utilities_ext'.EXT;
		}
		
		$PMU = new Pur_member_utilities_ext;

		$ajax = (isset($_SERVER['X_REQUESTED_WITH']) AND $_SERVER['X_REQUESTED_WITH'] == 'XMLHttpRequest') ? TRUE : FALSE;
		
		if (! $ajax)
		{
			defined("MOD_CP_URL") OR define("MOD_CP_URL", BASE.AMP.'C=modules'.AMP.'M=pur_member_utilities');

			if ($switch)
			{
				switch($IN->GBL('action'))
				{
					case 	'delete'		: $this->delete_mbr_conf();
						break;
					
					case 	'move'			: $this->move_mbr_conf();
						break;
				}
			
				switch($IN->GBL('P'))
				{
					case 	'mbr_move'		: $this->member_move();
						break;

					case	'save_settings'	: $this->save_settings();
						break;
						
					case	'home'			: $this->home_page();
						break;

					case	'all'			: $this->all_populated_bios();
						break;
				}

				if ( ! $IN->GBL('action') AND ! $IN->GBL('P'))
				{
					$this->home_page();
				}
			}
		}
		else
		{
			switch($IN->GBL('P', 'GET'))
			{
				case 	'bios'		: $this->get_members_with_bios();
						break;
			}
		}
	}
	/* End constructor */
	
	/**
	 * Home Page
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) Purple Dogfish Ltd
	 * @access		Public
	 * @return 		void
	 */
	function home_page($msg = '')
	{
		global $DB, $DSP, $LANG, $PREFS, $REGX, $SESS;

		$site_id = $PREFS->core_ini['site_id'];

		$settings = array(
			'notify' => 'n',
			'recipients' => '',
			'subject' => '',
			'template' => ''
		);
		
		$query = $DB->query("SELECT settings FROM exp_pur_member_utilities_settings WHERE id = '1'");

		$all_settings = $REGX->array_stripslashes(unserialize($query->row['settings']));
		$settings = $all_settings[$site_id];

		if ($query->num_rows == 1)
		{
			$subject = $settings['subject'];
			$template = $settings['template'];
		}
		else
		{
			$subject = '';
			$template = '';
		}

		$notify = $settings['notify'];
		
		if ( ! empty($settings['recipients']))
		{
			$recipients = implode(',', $settings['recipients']);
		}
		else
		{
			$recipients = '';
		}

		if ($notify == 'y')
		{
			$notify_on = '1';
			$notify_off = '0';
		}
		else
		{
			$notify_on = '0';
			$notify_off = '1';
		}

		$DSP->title = $LANG->line('pur_member_utilities_module_name');
		$DSP->crumb = $DSP->anchor(BASE.
									AMP.'C=modules'.
									AMP.'M=Pur_member_utilities',
									$LANG->line('pur_member_utilities_module_name'));
									
		$DSP->right_crumb($LANG->line('pur_member_utilities_bio_members'), BASE.AMP.'C=modules'.AMP.'M=Pur_member_utilities'.AMP.'P=all');
									
		$DSP->body .= $DSP->qdiv('tableHeading', $LANG->line('pur_member_utilities_module_name'));

        $DSP->body .= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Pur_member_utilities'.AMP.'P=save_settings'));

        $DSP->body .= $DSP->table('tableBorder', '0', '0', '100%').
						$DSP->tr().
						$DSP->table_qcell('tableHeadingAlt', array($DSP->qdiv('success', $msg), '&nbsp;')).
						$DSP->tr_c();

		$style = array();
		$style[0] = 'tableCellOne';
		$style[1] = 'tableCellTwo';

		$DSP->body .= $DSP->tr();
		$DSP->body .= $DSP->table_qcell($style[1], $DSP->qdiv('default', $LANG->line('pur_member_utilities_notifications')), '50%');
		$DSP->body .= $DSP->table_qcell($style[1], $DSP->qdiv('default', $LANG->line('pur_member_utilities_yes').NBS.$DSP->input_radio('mu_notify', 'y', $notify_on).$DSP->nbs(4).$LANG->line('pur_member_utilities_no').NBS.$DSP->input_radio('mu_notify', 'n', $notify_off)), '50%');
		$DSP->body .= $DSP->tr_c();

		$DSP->body .= $DSP->tr();
		$DSP->body .= $DSP->table_qcell($style[0], $DSP->qdiv('default', $LANG->line('pur_member_utilities_notification_recipients')));
		$DSP->body .= $DSP->table_qcell($style[1], $DSP->qdiv('default', $DSP->qdiv('itemWrapper', $DSP->input_text('mu_recipients', $recipients, '35', '100', 'input', '100%'))));
		$DSP->body .= $DSP->tr_c();

		$DSP->body .= $DSP->tr();
		$DSP->body .= $DSP->table_qcell($style[1], $DSP->qdiv('default', $LANG->line('pur_member_utilities_subject')));
		$DSP->body .= $DSP->table_qcell($style[1], $DSP->qdiv('default', $DSP->qdiv('itemWrapper', $DSP->input_text('mu_subject', $subject, '35', '100', 'input', '100%'))));
		$DSP->body .= $DSP->tr_c();

		$DSP->body .= $DSP->tr();
		$DSP->body .= $DSP->table_qcell($style[0], $DSP->qdiv('default', $LANG->line('pur_member_utilities_template')));
		$DSP->body .= $DSP->table_qcell($style[0], $DSP->qdiv('default', $LANG->line('pur_member_utilities_variables')));
		$DSP->body .= $DSP->tr_c();

		$DSP->body .= $DSP->tr();
		$DSP->body .= $DSP->table_qcell($style[0], $DSP->qdiv('default', ''));
		$DSP->body .= $DSP->table_qcell($style[0], $DSP->qdiv('default', $DSP->input_textarea('mu_template', $template, 15, 'font-size: 11px;')));
		$DSP->body .= $DSP->tr_c();
		
        $DSP->body .= $DSP->table_c();

		$DSP->body .= $DSP->qdiv('itemWrapperTop', $DSP->input_submit("Submit"));

        $DSP->body .= $DSP->form_close();
	}
	/* End home_page */

	/**
	 * Save the settings
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function save_settings()
	{
		global $DB, $IN, $LANG, $PREFS, $SESS;

		$site_id = $PREFS->core_ini['site_id'];
		$notify = $IN->GBL('mu_notify', 'POST');
		$recipients = $IN->GBL('mu_recipients', 'POST');
		$subject = $IN->GBL('mu_subject', 'POST');
		$template = $IN->GBL('mu_template', 'POST');

		$settings = array();

		$settings[$site_id] = array(
			'notify' => $notify,
			'recipients' => explode(',', $recipients),
			'subject' => $subject,
			'template' => $template
		);

		$query = $DB->update_string('exp_pur_member_utilities_settings', array('settings' => addslashes(serialize($settings))), "id = '1'");

		$DB->query($query);

		$this->home_page($msg = $LANG->line('pur_member_utilities_saved'));

	}
	/* End save_settings */
	
	/**
	 * All Populated Bios
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) Purple Dogfish Ltd
	 * @access		Public
	 * @since 		1.0.3
	 * @return		void
	 */
	function all_populated_bios($message = '')
    {
        global $IN, $LANG, $DSP, $LOC, $DB, $PREFS;

        // These variables are only set when one of the pull-down menus is used
        // We use it to construct the SQL query with

        $group_id   = $IN->GBL('group_id', 'GP');
        $order      = $IN->GBL('order', 'GP');

        $query = $DB->query("SELECT COUNT(*) AS count FROM exp_members");

        $total_members = $query->row['count'];

        // Begin building the page output
		$DSP->title = $LANG->line('pur_member_utilities_module_name');
		$DSP->crumb = $DSP->anchor(BASE.
									AMP.'C=modules'.
									AMP.'M=Pur_member_utilities',
									$LANG->line('pur_member_utilities_module_name'));
									
		$DSP->crumb .= $DSP->crumb_item($LANG->line('pur_member_utilities_bio_members'));
									
		$DSP->right_crumb($LANG->line('pur_member_utilities_view_all_members'), BASE.AMP.'C=admin'.AMP.'M=members'.AMP.'P=view_members');

        $r = $DSP->qdiv('tableHeading', $LANG->line('pur_member_utilities_bio_members'));

        if ($message != '')
        {
            $r .= $DSP->qdiv('box', $message);
        }

        // Build the SQL query as well as the query string for the paginate links

        $pageurl = BASE.AMP.'C=modules'.AMP.'M=Pur_member_utilities'.AMP.'P=all';

        $sql = "SELECT member_id FROM exp_members WHERE group_id NOT IN (1,2,3,4) AND bio != '' ORDER BY join_date DESC";

        $query = $DB->query($sql);

        // No result?  Show the "no results" message

        $total_count = $query->num_rows;

        if ($total_count == 0)
        {
            $r .= $DSP->qdiv('', BR.$LANG->line('pur_member_utilities_no_members'));

            return $DSP->set_return_data(   $LANG->line('pur_member_utilities_view_all_members'),
                                            $r,
                                            $LANG->line('pur_member_utilities_view_all_members')
                                        );
        }

        // Get the current row number and add the LIMIT clause to the SQL query

        if ( ! $rownum = $IN->GBL('rownum', 'GP'))
        {
            $rownum = 0;
        }

        $sql .= " LIMIT ".$rownum.", ".$this->perpage;

        // Run the query

        $query = $DB->query($sql);

        $sql = "SELECT exp_members.username,
                       exp_members.member_id,
                       exp_members.email,
					   exp_members.bio,
                       exp_members.last_visit,
                       exp_member_groups.group_title
                FROM   exp_members, exp_member_groups
                WHERE  exp_members.group_id = exp_member_groups.group_id
                AND    exp_member_groups.site_id = '".$DB->escape_str($PREFS->ini('site_id'))."'
				AND	   exp_members.bio != ''
                AND    exp_members.member_id NOT IN (1,2,3,4)
				AND    exp_members.member_id IN (";

		foreach ($query->result as $row)
		{
			$sql .= $row['member_id'].',';
		}

		$sql = substr($sql, 0, -1).')';

        $query = $DB->query($sql);

		// "select all" checkbox

        $r .= $DSP->toggle();

        $DSP->body_props .= ' onload="magic_check()" ';

        $r .= $DSP->magic_checkboxes();

        // Declare the "delete" form

        $r .= $DSP->form_open(
        						array(
        								'action'	=> 'C=modules'.AMP.'M=Pur_member_utilities',
        								'name'		=> 'target',
        								'id'		=> 'target'

        							)
        					);

        // Build the table heading
        $r .= $DSP->table('tableBorder', '0', '', '100%').
              $DSP->tr().
              $DSP->table_qcell('tableHeadingAlt', $LANG->line('pur_member_utilities_username'), '150px').
              $DSP->table_qcell('tableHeadingAlt', $LANG->line('pur_member_utilities_email')).
              $DSP->table_qcell('tableHeadingAlt', $LANG->line('pur_member_utilities_bio')).
              $DSP->table_qcell('tableHeadingAlt', $LANG->line('pur_member_utilities_last_visit'), '150px').
              $DSP->table_qcell('tableHeadingAlt', $LANG->line('pur_member_utilities_member_group')).
              $DSP->table_qcell('tableHeadingAlt', $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"")).
              $DSP->tr_c();

        // Loop through the query result and write each table row

        $i = 0;

        foreach($query->result as $row)
        {
            $style = ($i % 2) ? 'tableCellOne' : 'tableCellTwo'; $i++;

            $r .= $DSP->tr();

            // Username
            $r .= $DSP->table_qcell($style,
                                    $DSP->anchor(
                                                  BASE.AMP.'C=myaccount'.AMP.'id='.$row['member_id'],
                                                  '<b>'.$row['username'].'</b>'
                                                )
                                    );

			// Email
			$r .= $DSP->table_qcell($style, $DSP->mailto($row['email'], $row['email']));
					
            // Bio
            $r .= $DSP->table_qcell($style, $row['bio']);

            // Last visit date
            $r .= $DSP->td($style);

                if ($row['last_visit'] != 0)
                {
                    $r .= $LOC->set_human_time($row['last_visit']);
                }
                else
                {
                    $r .= "--";
                }

            $r .= $DSP->td_c();

            // Member group
            $r .= $DSP->td($style);

			$group_name = $row['group_title'];

            $r .= $group_name;

            $r .= $DSP->td_c();

            // Delete checkbox

            $r .= $DSP->table_qcell($style, $DSP->input_checkbox('toggle[]', $row['member_id'], '', ' id="delete_box_'.$row['member_id'].'"'));

            $r .= $DSP->tr_c();

        } // End foreach


        $r .= $DSP->table_c();

        $r .= $DSP->table('', '0', '', '98%');
        $r .= $DSP->tr().
              $DSP->td();

        // Pass the relevant data to the paginate class so it can display the "next page" links

        $r .=  $DSP->div('crumblinks').
               $DSP->pager(
                            $pageurl,
                            $total_count,
                            $this->perpage,
                            $rownum,
                            'rownum'
                          ).
              $DSP->div_c().
              $DSP->td_c().
              $DSP->td('defaultRight');

        // Delete button

        $r .= $DSP->input_submit($LANG->line('submit'));

        $r .= NBS.$DSP->input_select_header('action');

        $r .= $DSP->input_select_option('delete', $LANG->line('pur_member_utilities_delete_selected')).
        	  $DSP->input_select_footer().
        	  $DSP->td_c().
              $DSP->tr_c();

        // Table end

        $r .= $DSP->table_c().
              $DSP->form_close();

        $DSP->body  = $r;
    }
	/* End all_populated_bios */
	
	/**
	 * This is an exact copy of member_delete_confirm() in cp.members.php
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) Ellislab Inc.
	 * @access		Public
	 * @return		void
	 */
	function delete_mbr_conf()
	{
		global $IN, $DSP, $LANG, $DB, $SESS, $FNS;
        
		$LANG->fetch_language_file('members');
		$LANG->fetch_language_file('admin');
		
        if ( ! $DSP->allowed_group('can_delete_members'))
        {
            return $DSP->no_access_message();
        }
        
        $from_myaccount = FALSE;
        
        if ($IN->GBL('mid', 'GET') !== FALSE)
        {
        	$from_myaccount = TRUE;
        	$_POST['toggle'] = $IN->GBL('mid', 'GET');
        }
         
        if ( ! $IN->GBL('toggle', 'POST'))
        {
            $FNS->redirect(BASE.AMP.'C=admin'.AMP.'M=members'.AMP.'P=view_members');
        }
		
        $r  = $DSP->form_open(array('action' => 'C=admin'.AMP.'M=members'.AMP.'P=mbr_delete'));
        
        $i = 0;
        $damned = array();
        
        foreach ($_POST as $key => $val)
        {        
            if (strstr($key, 'toggle') AND ! is_array($val))
            {
                $r .= $DSP->input_hidden('delete[]', $val);
                
                // Is the user trying to delete himself?
                
                if ($SESS->userdata('member_id') == $val)
                {
                	return $DSP->error_message($LANG->line('can_not_delete_self'));
                }
                
                $damned[] = $DB->escape_str($val);
                $i++;
            }        
        }
        
        $r .= $DSP->qdiv('alertHeading', $LANG->line('delete_member'));
        $r .= $DSP->div('box');
        
        if ($i == 1)
        {
			$r .= $DSP->qdiv('itemWrapper', '<b>'.$LANG->line('delete_member_confirm').'</b>');
			
			$query = $DB->query("SELECT screen_name FROM exp_members WHERE member_id = '".$DB->escape_str($damned['0'])."'");
			
			$r .= $DSP->qdiv('itemWrapper', $DSP->qdiv('highlight', $query->row['screen_name']));
		}
		else
        {
			$r .= '<b>'.$LANG->line('delete_members_confirm').'</b>';
		}
		
        $r .= $DSP->qdiv('itemWrapper', $DSP->qdiv('alert', $LANG->line('action_can_not_be_undone')));
        
        /** ----------------------------------------------------------        
        /**  Do the users being deleted have entries assigned to them?
        /** ----------------------------------------------------------*/
        
        $sql = "SELECT COUNT(entry_id) AS count FROM exp_weblog_titles WHERE author_id ";
        
        if ($i == 1)
        {
			$sql .=  "= '".$DB->escape_str($damned['0'])."'";
		}
		else
		{
			$sql .= " IN ('".implode("','",$damned)."')";
		}
		
		$query = $DB->query($sql);
		
        /** ----------------------------------------------------------        
        /**  If so, fetch the member names for reassigment
        /** ----------------------------------------------------------*/
        
		if ($query->row['count'] > 0)
		{
			// Fetch the member_group of each user being deleted
			$sql = "SELECT group_id FROM exp_members WHERE member_id ";
        
        	if ($i == 1)
        	{
        		$sql .= " = '".$DB->escape_str($damned['0'])."'";
        	}
        	else
        	{
        		$sql .= " IN ('".implode("','",$damned)."')";
        	}
        	
			$query = $DB->query($sql);
			
			$group_ids[] = 1;

			if ($query->num_rows > 0)
			{
				foreach($query->result as $row)
				{
					$group_ids[] = $row['group_id'];
				}
			}
			
			$group_ids = array_unique($group_ids);
			
			// Find Valid Member Replacements
			$query = $DB->query("SELECT member_id, username, screen_name 
								FROM exp_members
								WHERE group_id IN (".implode(",",$group_ids).")
								AND member_id NOT IN ('".implode("','",$damned)."')
								ORDER BY screen_name");

			$r .= $DSP->div('itemWrapper');
			$r .= $DSP->div('defaultBold');
			$r .= ($i == 1) ? $LANG->line('heir_to_member_entries') : $LANG->line('heir_to_members_entries');
			$r .= $DSP->div_c();
			
			$r .= $DSP->div('itemWrapper');
			$r .= $DSP->input_select_header('heir');
			
			foreach($query->result as $row)
			{
				$r .= $DSP->input_select_option($row['member_id'], ($row['screen_name'] != '') ? $row['screen_name'] : $row['username']);
			}
			
			$r .= $DSP->input_select_footer();
			$r .= $DSP->div_c();
			$r .= $DSP->div_c();
		}        
                      
        $r .= $DSP->qdiv('itemWrapper', $DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=members'.AMP.'P=view_members', $LANG->line('pur_member_utilities_cancel')).NBS.NBS.$DSP->input_submit($LANG->line('delete'))).
              $DSP->div_c().
              $DSP->form_close();


        $DSP->title = $LANG->line('delete_member');
        $DSP->crumb = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=members_and_groups', $LANG->line('members_and_groups')).
        			  $DSP->crumb_item($LANG->line('delete_member'));         
        $DSP->body  = $r;
	}
	/* End delete_mbr_conf */
	
	/**
	 * Move Member Confirmation
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function move_mbr_conf()
	{
		global $IN, $DSP, $LANG, $DB, $SESS, $FNS;

		if (empty($_POST['toggle']))
		{
			$FNS->redirect(BASE.AMP.'C=admin'.AMP.'M=members'.AMP.'P=view_members');
		}

        if ( ! $DSP->allowed_group('can_delete_members'))
        {
            return $DSP->no_access_message();
        }
        
        $from_myaccount = FALSE;
        
        if ($IN->GBL('mid', 'GET') !== FALSE)
        {
        	$from_myaccount = TRUE;
        	$_POST['toggle'] = $IN->GBL('mid', 'GET');
        }
         
        if ( ! $IN->GBL('toggle', 'POST'))
        {
            $FNS->redirect(BASE.AMP.'C=admin'.AMP.'M=members'.AMP.'P=view_members');
        }
		
		$LANG->fetch_language_file('members');
		$LANG->fetch_language_file('admin');
		
        $r  = $DSP->form_open(array('action' => 'C=modules'.AMP.'M=pur_member_utilities'.AMP.'P=mbr_move'));
        
        $i = 0;
        $damned = array();
        
        foreach ($_POST as $key => $val)
        {        
            if (strstr($key, 'toggle') AND ! is_array($val))
            {
                $r .= $DSP->input_hidden('move[]', $val);
                
                // Is the user trying to move himself?
                
                if ($SESS->userdata('member_id') == $val)
                {
                	return $DSP->error_message($LANG->line('pur_member_utilities_can_not_move_self'));
                }
                
                $damned[] = $DB->escape_str($val);
                $i++;
            }        
        }
        
		if ($i > 1)
		{
			$r .= $DSP->qdiv('tableHeadingAlt', $LANG->line('pur_member_utilities_move_member'));
		}
		else
		{
			$r .= $DSP->qdiv('tableHeadingAlt', $LANG->line('pur_member_utilities_move_members'));
		}
		
        $r .= $DSP->div('box');
        
        if ($i == 1)
        {
			$query = $DB->query("SELECT screen_name FROM exp_members WHERE member_id = '".$DB->escape_str($damned['0'])."'");
			
			$r .= $DSP->qdiv('itemWrapper', $LANG->line('pur_member_utilities_member_screenname').NBS.$DSP->qspan('highlight', $query->row['screen_name']));
	
			$r .= $DSP->qdiv('itemWrapper', '<b>'.$LANG->line('pur_member_utilities_move_member_confirm_group').'</b>');
		}
		else
        {
			$r .= $LANG->line('pur_member_utilities_move_members_confirm_group').NBS.NBS;
		}
		
        $r .= $DSP->input_select_header('new_group', '', '', '', 'id="choose_new_group"');
		
		$query = $DB->query("SELECT group_id, group_title FROM exp_member_groups WHERE group_id != '1' AND site_id = '".$SESS->userdata['site_id']."'");

		foreach($query->result AS $row)
		{
			$r .= $DSP->input_select_option($row['group_id'], $row['group_title']);
		}
		
		$r .= $DSP->input_select_footer();
		
		$r .= $DSP->span('ban_ip');
		
		if ($i == 1)
		{
			$r .= NBS.$LANG->line('pur_member_utilities_ban_ip');
		}
		else
		{
			$r .= NBS.$LANG->line('pur_member_utilities_ban_ips');
		}
		
		$r .= NBS.$DSP->input_checkbox('ban_ip', 'y', 0);
		
		$r .= $DSP->span_c();
		
		$r .= $DSP->span('ban_email');
		
		if ($i == 1)
		{
			$r .= NBS.$LANG->line('pur_member_utilities_ban_email');
		}
		else
		{
			$r .= NBS.$LANG->line('pur_member_utilities_ban_emails');
		}
		
		$r .= NBS.$DSP->input_checkbox('ban_email', 'y', 0);
		
		$r .= $DSP->span_c();
		
		$r .= $DSP->span('delete_posts');
		
		$r .= NBS.$LANG->line('pur_member_utilities_delete_posts');
		
		$r .= NBS.$DSP->input_checkbox('delete_posts', 'y', 0);
		
		$r .= $DSP->span_c();

		$r .= $DSP->span('empty_profile');

		if ($i == 1)
		{

			$r .= NBS.$LANG->line('pur_member_utilities_empty_profile');
		}
		else
		{
			$r .= NBS.$LANG->line('pur_member_utilities_empty_profiles');
		}

		$r .= NBS.$DSP->input_checkbox('empty_profile', 'y', 0);

		$r .= $DSP->span_c();

		
        /** ----------------------------------------------------------        
        /**  Do the users being deleted have entries assigned to them?
        /** ----------------------------------------------------------*/
        
        $sql = "SELECT COUNT(entry_id) AS count FROM exp_weblog_titles WHERE author_id ";
        
        if ($i == 1)
        {
			$sql .=  "= '".$DB->escape_str($damned['0'])."'";
		}
		else
		{
			$sql .= " IN ('".implode("','",$damned)."')";
		}
		
		$query = $DB->query($sql);
		
        /** ----------------------------------------------------------        
        /**  If so, fetch the member names for reassigment
        /** ----------------------------------------------------------*/
        
		if ($query->row['count'] > 0)
		{
			// Fetch the member_group of each user being deleted
			$sql = "SELECT group_id FROM exp_members WHERE member_id ";
        
        	if ($i == 1)
        	{
        		$sql .= " = '".$DB->escape_str($damned['0'])."'";
        	}
        	else
        	{
        		$sql .= " IN ('".implode("','",$damned)."')";
        	}
        	
			$query = $DB->query($sql);
			
			$group_ids[] = 1;

			if ($query->num_rows > 0)
			{
				foreach($query->result as $row)
				{
					$group_ids[] = $row['group_id'];
				}
			}
			
			$group_ids = array_unique($group_ids);
			
			// Find Valid Member Replacements
			$query = $DB->query("SELECT member_id, username, screen_name 
								FROM exp_members
								WHERE group_id IN (".implode(",",$group_ids).")
								AND member_id NOT IN ('".implode("','",$damned)."')
								ORDER BY screen_name");
			
			$r .= '<div id="entry_reassignment">';
			$r .= $DSP->div('itemWrapper');
			$r .= $DSP->div('defaultBold');
			$r .= ($i == 1) ? $LANG->line('heir_to_member_entries') : $LANG->line('heir_to_members_entries');
			$r .= $DSP->div_c();
			
			$r .= $DSP->div('itemWrapper');
			$r .= $DSP->input_select_header('heir');
			
			$r .= $DSP->input_select_option('', $LANG->line('pur_member_utilities_none_leave_as_is'));
			foreach($query->result as $row)
			{
				$r .= $DSP->input_select_option($row['member_id'], ($row['screen_name'] != '') ? $row['screen_name'] : $row['username']);
			}
			
			$r .= $DSP->input_select_footer();
			$r .= $DSP->div_c();
			$r .= $DSP->div_c();
			$r .= '</div>';
		}        
                      
        $r .= $DSP->qdiv('itemWrapper', $DSP->input_submit($LANG->line('pur_member_utilities_move'))).
              $DSP->div_c().
              $DSP->form_close();


        $DSP->title = $LANG->line('pur_member_utilities_move_member');
        $DSP->crumb = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=members_and_groups', $LANG->line('members_and_groups')).
        			  $DSP->crumb_item($LANG->line('pur_member_utilities_move_member'));

		$DSP->extra_header = '
		<script type="text/javascript">
			// Thanks to Gareth Davies for this no conflict solution.
			var $mu = jQuery.noConflict();
			$mu(function() {
				$mu(".ban_ip").hide();
				$mu(".ban_email").hide();
				$mu(".delete_posts").hide();
				$mu("#entry_reassignment").hide();
				
				var selectedOptionNow = $mu("#choose_new_group :selected").val();

				if (selectedOptionNow == 2) {
					$mu(".ban_ip").show();
					$mu(".ban_email").show();
					$mu(".delete_posts").show();
					$mu("#entry_reassignment").show();
				}
								
				$mu("#choose_new_group").change(function() {
					var selectedOption = $mu(this).val();
					
					if (selectedOption == 2) {
						$mu(".ban_ip").show();
						$mu(".ban_email").show();
						$mu(".delete_posts").show();
						$mu(".empty_profile").show();
						$mu("#entry_reassignment").show();
					} else {
						$mu(".ban_ip").hide();
						$mu(".ban_email").hide();
						$mu(".delete_posts").hide();
						$mu(".empty_profile").hide();
						$mu("#entry_reassignment").hide();
					}
				});
			});
		</script>';
  
        $DSP->body  = $r;
	}
	/* End move_mbr_conf */
	
	/**
	 * Member Move
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function member_move()
	{
		global $IN, $DB, $FNS, $REGX, $PREFS;

		$new_group = $IN->GBL('new_group', 'POST');
		$ban_ip = $IN->GBL('ban_ip', 'POST');
		$ban_email = $IN->GBL('ban_email', 'POST');
		$delete_posts = $IN->GBL('delete_posts', 'POST');
		$empty_profile = $IN->GBL('empty_profile', 'POST');
		$heir = $IN->GBL('heir', 'POST');
		
		$members = array();
		
		foreach($_POST['move'] AS $key => $member_id)
		{
			$members[] = $member_id;
		}
		
		if ($delete_posts == 'y')
		{
			$this->_delete_posts($members);
		}
		
		$sql = array();
		
		foreach($members AS $row => $val)
		{
			$sql[] = $DB->update_string('exp_members', array('group_id' => $new_group), "member_id = '".$val."'");
			if ($heir != '')
			{
				$sql[] = $DB->update_string('exp_weblog_titles', array('author_id' => $heir), "author_id = '".$val."'");
			}
		}
		
		foreach($sql AS $query)
		{
			$DB->query($query);
		}
		
		$member_list = trim(implode(',', $members), ',');

		$query = $DB->query("SELECT email, ip_address FROM exp_members WHERE member_id IN (".$member_list.")");

		$data['banned_ips'] = $PREFS->core_ini['banned_ips'];
		$data['banned_emails'] = $PREFS->core_ini['banned_emails'];

		if ($ban_ip == 'y')
		{
			foreach($query->result AS $row)
			{
				$data['banned_ips'] .= $row['ip_address'].'|';
			}
		}
		
		if ($ban_email == 'y')
		{
			foreach($query->result AS $row)
			{
				$data['banned_emails'] .= $row['email'].'|';
			}
		}

		if ($empty_profile == 'y')
		{
			$DB->query($DB->update_string('exp_members', array('bio' => '', 'url' => ''), "member_id IN (".$member_list.")"));
		}
		
		if ($DB->table_exists('exp_sites'))
		{
			$query = $DB->query("SELECT site_id, site_system_preferences FROM exp_sites");

			foreach($query->result AS $row)
			{
				$prefs = array_merge($REGX->array_stripslashes(unserialize($row['site_system_preferences'])), $data);

				$query = $DB->query($DB->update_string('exp_sites', 
													   array('site_system_preferences' => addslashes(serialize($prefs))),
													   "site_id = '".$DB->escape_str($row['site_id'])."'"));
			}
		}
		$override = ($IN->GBL('class_override', 'GET') != '') ? AMP.'class_override='.$IN->GBL('class_override', 'GET') : '';

		$FNS->redirect(BASE.AMP.'C=admin'.AMP.'M=members'.AMP.'P=view_members'.AMP.'U=1'.$override);
	}
	/* End member_move */
	
	/**
	 * Get Member Data
	 * 
	 * Method that responds to AJAX GET request and builds copy of the member public profile
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		string		$r		Member profile
	 */
	function get_member_data()
	{
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')
		{
			global $IN, $LANG, $DB, $PREFS;

			// Is the requested member banned, a guest or pending? If so, we'll bail with a suitable
			// message since a banned member would generate an error message
			// We'll also use this query if the request is valid
			$query = $DB->query("SELECT * FROM exp_members WHERE member_id = '".$DB->escape_str($IN->GBL('member_id', 'GET'))."'");
			
			if ($query->num_rows <> 1 OR $query->row['group_id'] == 2 OR $query->row['group_id'] == 3 OR $query->row['group_id'] == 4)
			{
				$LANG->fetch_language_file('member');
				$LANG->fetch_language_file('pur_member_utilities');
				echo $LANG->line('profile_not_available').'. '.$LANG->line('pur_member_utilities_use_profile_link');
				exit;
			}
			
			if ( ! class_exists('Member'))
	    	{
	    		require PATH_MOD.'member/mod.member.php';
	    	}
	
			if ( ! class_exists('Member_settings'))
	    	{
	    		require PATH_MOD.'member/mod.member_settings.php';
	    	}

	    	$MS = new Member_settings();

	    	foreach(get_object_vars($this) as $key => $value)
			{
				$MS->{$key} = $value;
			}
			
			$MS->cur_id = $IN->GBL('member_id', 'GET');
			$MS->theme_path = PATH_MBR_THEMES.'default/profile_theme.php';

	    	$r = $MS->public_profile();

			// So now we need to sort out the non-parsed language
			preg_match_all("/{lang:(.+)}/sU", $r, $matches);
			
			$search = $matches[0];
			$replace = array();

			$LANG->fetch_language_file('member');
			$LANG->fetch_language_file('myaccount');
			
			foreach($matches[1] AS $key => $val)
			{
				$replace[] = ($LANG->line($val) != '') ? $LANG->line($val) : $LANG->line('mbr_'.$val);
			}

			$r = str_replace($search, $replace, $r);

			// Now let's parse the image stuff
			if ($PREFS->ini('enable_photos') == 'y' AND $query->row['photo_filename'] != '')
			{
				$photo_path		= $PREFS->ini('photo_url', 1).$query->row['photo_filename'];
				$photo_width	= $query->row['photo_width'];
				$photo_height	= $query->row['photo_height'];
			}
			else
			{
				$photo_path	= $PREFS->ini('theme_folder_url').'profile_themes/'.$PREFS->ini('profile_themes', 1).$PREFS->ini('member_theme').'/images/';
				$photo_width	= '';
				$photo_height	= '';
			}
			
			$image_path	= $PREFS->ini('theme_folder_url').'profile_themes/'.$PREFS->ini('profile_themes', 1).$PREFS->ini('member_theme').'/images/';
			
			$r = str_replace('{path:photo_url}', $photo_path, $r);
			
			$r = str_replace('{path:image_url}', $image_path, $r);

			// Okay, lastly let's sort out the link for viewing all posts if forum module installed
			$query = $DB->query("SELECT * FROM exp_modules WHERE module_name = 'Forum'");
			if ($query->num_rows == 1)
			{
				$separator = '';
				
				if ($PREFS->ini('site_index'))
				{
					$separator = '/';
				}
				// Okay, the forum is installed, let's get its search path
				$r = str_replace('?ACT={AID:Search:do_search}&amp;mbr=', $separator.'forums/member_search/', $r);
			}
			else
			{
				// We remove the link entirely
				$r = preg_replace('/<a\s+.*{AID:Search:do_search}.*<\/a>/U', '', $r);
			}
			
			// Remove Edit Ignore List - that should be done in My Account
			$r = preg_replace('/<a\s+.*\/member\/edit_ignore_list\/.*<\/a>/U', '', $r);

			$css = '<style type="text/css">'.$this->_profile_css().'</style>';
			
			$r = $css . $r;
			
			echo $r;
		}
	}
	/* End get_member_data */
	
	/**
	 * Delete Posts
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Private
	 * @return		void
	 */
	function _delete_posts($members)
	{
		global $DB, $PREFS;
		
		$ids = array();
		
		foreach($members AS $member)
		{
			$ids[] = "member_id = '".$DB->escape_str($member)."'";
		}
		
		$IDS = implode(" OR ", $ids);
		
		if ($PREFS->ini('forum_is_installed') == "y")
		{
			$DB->query("DELETE FROM exp_forum_subscriptions  WHERE ".$IDS); 
			$DB->query("DELETE FROM exp_forum_pollvotes  WHERE ".$IDS); 

			$IDS = str_replace('member_id', 'admin_member_id', $IDS);
			$DB->query("DELETE FROM exp_forum_administrators WHERE ".$IDS); 
			
			$IDS = str_replace('admin_member_id', 'mod_member_id', $IDS);			
			$DB->query("DELETE FROM exp_forum_moderators WHERE ".$IDS); 

			$IDS = str_replace('mod_member_id', 'author_id', $IDS);
			$DB->query("DELETE FROM exp_forum_topics WHERE ".$IDS);
			
			// Snag the affected topic id's before deleting the members for the update afterwards
			$query = $DB->query("SELECT topic_id FROM exp_forum_posts WHERE ".$IDS);
			
			if ($query->num_rows > 0)
			{
				$topic_ids = array();
				
				foreach ($query->result as $row)
				{
					$topic_ids[] = $row['topic_id'];
				}
				
				$topic_ids = array_unique($topic_ids);
			}
			
			$DB->query("DELETE FROM exp_forum_posts  WHERE ".$IDS); 
			$DB->query("DELETE FROM exp_forum_polls  WHERE ".$IDS); 

			// Kill any attachments
			$query = $DB->query("SELECT attachment_id, filehash, extension, board_id FROM exp_forum_attachments WHERE ".str_replace('author_id', 'member_id', $IDS));
			
			if ($query->num_rows > 0)
			{
				// Grab the upload path
				$res = $DB->query('SELECT board_id, board_upload_path FROM exp_forum_boards');
			
				$paths = array();
				foreach ($res->result as $row)
				{
					$paths[$row['board_id']] = $row['board_upload_path'];
				}
			
				foreach ($query->result as $row)
				{
					if ( ! isset($paths[$row['board_id']]))
					{
						continue;
					}
					
					$file  = $paths[$row['board_id']].$row['filehash'].$row['extension'];
					$thumb = $paths[$row['board_id']].$row['filehash'].'_t'.$row['extension'];
				
					@unlink($file);
					@unlink($thumb);					
			
					$DB->query("DELETE FROM exp_forum_attachments WHERE attachment_id = '{$row['attachment_id']}'");
				}				
			}		
			
			// Update the forum stats			
			$query = $DB->query("SELECT forum_id FROM exp_forums WHERE forum_is_cat = 'n'");
			
		
			if ( ! class_exists('Forum'))
			{
				require PATH_MOD.'forum/mod.forum'.EXT;
				require PATH_MOD.'forum/mod.forum_core'.EXT;
			}
			
			$FRM = new Forum_Core;
			
			foreach ($query->result as $row)
			{
				$FRM->_update_post_stats($row['forum_id']);
			}
			
			if (isset($topic_ids))
			{
				foreach ($topic_ids as $topic_id)
				{
					$FRM->_update_topic_stats($topic_id);
				}
			}
		}
	}
	/* End _delete_posts */
	
	/**
	 * Profile CSS
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Private
	 * @return		string		heredoc		CSS for profile
	 */
	function _profile_css()
	{
		return <<< EOF

		.defaultBold {
		 font-weight: bold;
		}

		.defaultRight {
		 text-align: right;
		}

		.defaultCenter {
		text-align: center;
		}

		.lighttext {
		 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
		 font-size:         10px;
		 color:             #73769D;
		 padding:           4px 0 2px 0;
		 background-color:  transparent;  
		}

		.success {
		 font-family:		Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
		 font-size:			11px;
		 color:				#009933;
		 font-weight:		bold;
		 padding:			3px 0 3px 0;
		 background-color:	transparent; 
		}

		/*
		    Misc. Formatting Items
		------------------------------------------------------ */ 

		.spacer {
		 margin-bottom:     12px;
		}

		.itempad {
		padding: 2px 0 2px 0;
		}

		.itempadbig {
		padding: 5px 0 5px 0;
		}

		.bottompad {
		padding: 0 0 2px 0;
		}
		.marginpad {
		 margin: 12px 0 10px 3px;
		 background: transparent;
		}

		.leftpad {
		padding: 0 0 0 4px;
		}

		/*
		    Member Profile Page
		------------------------------------------------------ */ 

		.profileHeadingBG {
		 background-color: 		#74779D;
		 color:             #fff;
		 padding:           6px 6px 6px 6px;
		 border-bottom:     #585C9C 1px solid;
		}

		.profileAlertHeadingBG {
		 background-color:		#6e0001;
		 color:				#fff;
		 padding:			6px 6px 6px 6px;
		 border-bottom:		#585C9C 1px solid;
		}

		.profileTitle {
		 font-family:		Tahoma, Verdana, Geneva, Trebuchet MS, Arial, Sans-serif;
		 font-size:			14px;
		 font-weight:		bold;
		 color:				#000;
		 padding: 			3px 5px 3px 0;
		 margin:			0;
		 background-color: transparent;  
		}

		.profilePhoto {
		 background-color:		#F0F0F2;
		 border-left:       1px solid #B2B3CE;
		 padding:			1px;
		 margin-top:        1px;
		 margin-bottom:     3px;
		}

		.avatar {
		 background:	transparent;
		 margin:		3px 14px 0 3px;
		}

		.photo {
		 background:	transparent;
		 margin:		6px 14px 0 3px;
		}

		.profileHead {
		 font-family:		Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
		 font-size:			10px;
		 font-weight:		bold;
		 text-transform:	uppercase;
		 color:				#fff;
		 padding:			3px 4px 3px 10px;
		 background-color:	#4C5286;  
		 border-top:		1px solid #fff;
		 border-bottom:		1px solid #fff;
		 margin:			0 0 0 0;
		}

		.borderTopBot {
		 border-top:	1px solid #585C9C;
		 border-bottom:	1px solid #585C9C;
		}

		.borderBot {
		 border-bottom:	1px solid #585C9C;
		}

		.altLinks { 
		 color:             #fff;
		 background:        transparent;
		 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
		 font-size:         11px;
		}
		.altLinks a:link { 
		 color:             #fff;
		 background:        none;
		 text-decoration:   underline;
		}
		.altLinks a:visited { 
		 color:             #fff;
		 background:        transparent;
		 text-decoration:   none;
		}
		.altLinks a:hover { 
		 color:             #B8BDED;    
		 background:        transparent;
		 text-decoration:   underline;
		}

		.innerShade {
		 background-color:	#DDE1E7;
		 border:      	 	1px solid #74779D;
		 margin:			0;
		 padding:			10px;
		}

		/*
		    Table Formatting
		------------------------------------------------------ */ 

		.tablePad {
		 padding:  0 2px 4px 2px;
		}

		.tableborder {
		 border:            1px solid #7B81A9;
		 padding:			1px;
		 margin-top:        1px;
		 margin-bottom:     3px;
		}
		.tableBorderTopRight {
		 border-top:     	1px solid #B2B3CE;
		 border-right:     	1px solid #B2B3CE;
		 padding:			0;
		 margin-top:        1px;
		 margin-bottom:     3px;
		}
		.tableBorderRight {
		 border-right:      1px solid #B2B3CE;
		 padding:			0;
		 margin-top:        1px;
		 margin-bottom:     3px;
		}

		.tableBG {
		 background-color: #F0F0F0;
		}

		.tableRowHeading, .tableRowHeadingBold {
		 background-color: #C9CAE2;
		 font-family:       Verdana, Geneva, Tahoma, Trebuchet MS, Arial, Sans-serif;
		 font-size:         11px;
		 color:             #404055;
		 padding:           8px 10px 8px 6px;
		 border-top:        1px solid #A7A9C7;
		 border-bottom:     1px solid #A7A9C7;
		 border-left:       1px solid #A7A9C7;
		 border-right:      1px solid #fff;
		}
		.tableRowHeadingBold {
		font-weight: bold;
		}
EOF;
	}
	/* End _profile_css */
	
	/**
	 * Installer
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function pur_member_utilities_module_install()
	{
		global $DB, $PMU;
		
		$sql[] = "INSERT INTO exp_modules (
												module_id,
												module_name,
												module_version,
												has_cp_backend
											)
											VALUES
											(
												'',
												'Pur_member_utilities',
												'$this->version',
												'y'
											)";
											
		$sql[] = "INSERT INTO exp_actions (action_id, class, method) VALUES ('', 'Pur_member_utilities_CP', 'get_member_data')";
		
		$sql[] = "CREATE TABLE IF NOT EXISTS `exp_pur_member_utilities_settings` (
			`id` INT(6) UNSIGNED NOT NULL,
			`settings` TEXT NOT NULL,
			PRIMARY KEY(`id`));";

		$sql[] = "INSERT INTO exp_pur_member_utilities_settings (id, settings) VALUES (1, '{}')";
											
		foreach($sql AS $query)
		{
			$DB->query($query);
		}
		
		$query = $DB->query("SELECT COUNT(*) AS count FROM exp_extensions WHERE class = 'Pur_member_utilities_ext'");
		
		if ($query->row['count'] == 0)
		{
			$PMU->activate_extension(TRUE);
		}
		
		return TRUE;
	}
	/* End pur_member_utilities_module_install */
	
	/**
	 * Deinstaller
	 *
	 * @author		Greg Salt <greg@purple-dogfish.co.uk>
	 * @copyright	Copyright (c) 2009 Purple Dogfish Ltd
	 * @access		Public
	 * @return		void
	 */
	function pur_member_utilities_module_deinstall()
	{
		global $DB, $PMU;
		
		$query = $DB->query("SELECT module_id
									FROM exp_modules
									WHERE module_name = 'Pur_member_utilities'");
									
		$sql[] = "DELETE FROM exp_module_member_groups
						 WHERE module_id = '".$query->row['module_id']."'";
						
		$sql[] = "DELETE FROM exp_modules
				 		 WHERE module_name = 'Pur_member_utilities'";
				
		$sql[] = "DELETE FROM exp_actions
						WHERE class = 'Pur_member_utilities_CP'";

		$sql[] = "DROP TABLE IF EXISTS exp_pur_member_utilities_settings";
				
		foreach($sql AS $query)
		{
			$DB->query($query);
		}
		
		$PMU->disable_extension(TRUE);
		
		return TRUE;
	}
}
/* End of file mcp.pur_member_utilities.php */
/* Location: ./system/modules/mcp.pur_member_utilities.php */