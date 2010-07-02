<?php

/*
================================================================
	Freeform
	for EllisLab ExpressionEngine - by Solspace
----------------------------------------------------------------
	Credits: Mitchell Kimbrough, Chris Ruzin, Paul Burdick
----------------------------------------------------------------
	Copyright (c) 2008 - 2009 Solspace, Inc.
	http://www.solspace.com/
================================================================
	THIS IS COPYRIGHTED SOFTWARE. PLEASE READ THE
	LICENSE AGREEMENT.
	http://www.solspace.com/license/
----------------------------------------------------------------
	This software is based upon and derived from
	Ellislab ExpressionEngine software protected under
	copyright dated 2005 - 2009. Please see
	http://www.expressionengine.com/docs/license.html
----------------------------------------------------------------
	USE THIS SOFTWARE AT YOUR OWN RISK. SOLSPACE ASSUMES
	NO WARRANTY OR LIABILITY FOR THIS SOFTWARE AS DETAILED
	IN THE SOLSPACE LICENSE AGREEMENT.
================================================================
	File:			mod.freeform.php
----------------------------------------------------------------
	Version:		2.7.2
----------------------------------------------------------------
	Purpose:		Flexible entry form module
----------------------------------------------------------------
	Compatibility:	EE 1.6.7
----------------------------------------------------------------
	Updated:		2009-05-08
================================================================
*/


if ( ! defined('EXT'))
{
    exit('Invalid file request');
}
    
/**	----------------------------------------
/**	Begin class
/**	----------------------------------------*/

class Freeform
{
	var $UP;
	
	var $dynamic		= TRUE;
	var $multipart		= FALSE;
	
	var $params_id		= 0;
	var $entry_id		= 0;
	var $upload_limit	= 3;
	
	var $params_tbl		= 'exp_freeform_params';
	
	var $params			= array();
	var $data			= array();
	var $upload			= array();
	var $attachments	= array();
    
    /**	----------------------------------------
    /**	Constructor
    /**	----------------------------------------*/
	
	function Freeform()
	{
	}
	
	/**	End constructor */

	
    /**	----------------------------------------
    /**	Submission Form
    /**	----------------------------------------*/
    
    function form()
    {
        global $DB, $EXT, $FNS, $IN, $PREFS, $REGX, $SESS, $TMPL;
        
        $this->params['require_captcha']	= 'no';
    
		/**	----------------------------------------
        /**	Grab our tag data
		/**	----------------------------------------*/
        
        $tagdata						= $TMPL->tagdata;
        		
		/**	----------------------------------------
		/**	Set form name
		/**	----------------------------------------*/
		
		$this->params['form_name']		= ( $TMPL->fetch_param('form_name') !== FALSE && $TMPL->fetch_param('form_name') != '' ) ? $TMPL->fetch_param('form_name') : 'freeform_form';
        		
		/**	----------------------------------------
		/**	Do we require IP address?
		/**	----------------------------------------*/
		
		$this->params['require_ip']		= ($TMPL->fetch_param('require_ip')) ? $TMPL->fetch_param('require_ip') : '';
        		
		/**	----------------------------------------
		/**	Are we establishing any required fields?
		/**	----------------------------------------*/
		
		$this->params['ee_required']	= ($TMPL->fetch_param('required')) ? $TMPL->fetch_param('required') : '' ;
        		
		/**	----------------------------------------
		/**	Are we notifying anyone?
		/**	----------------------------------------*/
		
		$this->params['ee_notify']		= ($TMPL->fetch_param('notify')) ? $TMPL->fetch_param('notify') : '' ;
        		
		/**	----------------------------------------
		/**	Send attachments?
		/**	----------------------------------------*/
		
		$this->params['send_attachment']	= ($TMPL->fetch_param('send_attachment')) ? $TMPL->fetch_param('send_attachment') : '' ;
        		
		/**	----------------------------------------
		/**	Send user email?
		/**	----------------------------------------*/
		
		$this->params['send_user_email']	= ($TMPL->fetch_param('send_user_email')) ? $TMPL->fetch_param('send_user_email') : '' ;
        		
		/**	----------------------------------------
		/**	Send user attachments?
		/**	----------------------------------------*/
		
		$this->params['send_user_attachment']	= ($TMPL->fetch_param('send_user_attachment')) ? $TMPL->fetch_param('send_user_attachment') : '' ;
        		
		/**	----------------------------------------
		/**	User email template
		/**	----------------------------------------*/
		
		$this->params['user_email_template']	= ($TMPL->fetch_param('user_email_template')) ? $TMPL->fetch_param('user_email_template') : 'default' ;
        		
		/**	----------------------------------------
		/**	Are we using a notification template?
		/**	----------------------------------------*/
		
		$this->params['template']		= ($TMPL->fetch_param('template')) ? str_replace(SLASH, '/', $TMPL->fetch_param('template')) : 'default_template' ;
        		
		/**	----------------------------------------
		/**	Mailing lists?
		/**	----------------------------------------*/
		$mailinglist					= ( $TMPL->fetch_param('mailinglist') AND $TMPL->fetch_param('mailinglist') != '' ) ? $TMPL->fetch_param('mailinglist'): FALSE;
        		
		/**	----------------------------------------
		/**	Mailing list opt in?
		/**	----------------------------------------*/
		
		$mailinglist_opt_in				= ( $TMPL->fetch_param('mailinglist_opt_in') AND $TMPL->fetch_param('mailinglist_opt_in') == 'no' ) ? TRUE: FALSE;
        		
		/**	----------------------------------------
		/**	Are we redirecting on duplicate?
		/**	----------------------------------------*/
		
		$redirect_on_duplicate			= ($TMPL->fetch_param('redirect_on_duplicate')) ? str_replace(SLASH, '/', $TMPL->fetch_param('redirect_on_duplicate')) : FALSE;
        		
		/**	----------------------------------------
		/**	Prevent duplicates on something specific
		/**	----------------------------------------*/
		
		$this->params['prevent_duplicate_on']	= ($TMPL->fetch_param('prevent_duplicate_on')) ? $TMPL->fetch_param('prevent_duplicate_on') : '';
        		
		/**	----------------------------------------
		/**	File upload directory
		/**	----------------------------------------*/
		
		$this->params['file_upload']	= ($TMPL->fetch_param('file_upload')) ? $TMPL->fetch_param('file_upload') : '';
    	
		/**	----------------------------------------
		/**	Sniff for fields of type 'file'
		/**	----------------------------------------*/
		
		if ( preg_match_all( "/type=['|\"]?file['|\"]?/", $tagdata, $match ) )
		{
			$this->multipart	= TRUE;
			$this->params['upload_limit']	= count( $match['0'] );
		}
    
        /**	----------------------------------------
        /**	Grab custom member profile fields
        /**	----------------------------------------*/
        
        $query		= $DB->query("SELECT m_field_id, m_field_name FROM exp_member_fields");

		if ( $query->num_rows > 0 )
		{
			foreach ($query->result as $row)
			{ 
				$mfields[$row['m_field_name']] = $row['m_field_id'];
			}
		}
		
        /**	End custom member fields */
        
    
        /**	----------------------------------------
        /**	Grab standard member profile fields
        /**	----------------------------------------*/
        
        $mdata		= array();
        
        if ( $SESS->userdata['member_id'] != '0' )
        {        
			$query		= $DB->query("SELECT * FROM exp_members WHERE member_id = '".$DB->escape_str($SESS->userdata['member_id'])."' LIMIT 1");
	
			if ( $query->num_rows > 0 )
			{
				foreach ($query->result as $row)
				{
					foreach ( $row as $key => $val )
					{
						$mdata[$key] = $val;
					}
				}
			}
		}
		
        /**	End standard member fields */
        
    
        /**	----------------------------------------
        /**	Grab custom member data
        /**	----------------------------------------*/
        
        if ( $SESS->userdata['member_id'] != '0' )
        {
			$query		= $DB->query("SELECT * FROM exp_member_data WHERE member_id = '".$DB->escape_str($SESS->userdata['member_id'])."' LIMIT 1");

			if ($query->num_rows > 0)
			{					
				foreach ($query->result[0] as $key => $val)
				{ 
					$mdata[$key] = $val;
				}
			}
		}
		
        /**	End custom member data */
        
        
		/**	----------------------------------------
		/**	Check for duplicate
		/**	----------------------------------------*/
		
		if ( $SESS->userdata['member_id'] == '0' AND $IN->IP == '0.0.0.0' )
		{
			$duplicate	= FALSE;
		}
		else
		{
			//	Begin the query
			$sql	= "SELECT count(*) AS count FROM exp_freeform_entries WHERE status != 'closed'";
			
			//	Handle form_name
			if ( $this->params['form_name'] != '' )
			{
				$sql	.= " AND form_name = '".$DB->escape_str($this->params['form_name'])."'";
			}
			
			//	Identify them
			if ( $SESS->userdata['member_id'] != '0' )
			{
				$sql	.= " AND author_id = '".$DB->escape_str($SESS->userdata['member_id'])."'";
			}
			elseif ( $IN->IP )
			{
				$sql	.= " AND ip_address = '".$DB->escape_str($IN->IP)."'";
			}
			
			//	Query
			$query	= $DB->query( $sql );
			
			$duplicate	= ( $query->row['count'] > 0 ) ? TRUE: FALSE;
		}
		
		
		/**	----------------------------------------
		/**	Redirect on duplicate
		/**	----------------------------------------*/
		
		if ( $redirect_on_duplicate AND $duplicate )
		{
			$FNS->redirect( $FNS->create_url( $redirect_on_duplicate ) );
			exit;
		}
		
    
        /**	----------------------------------------
        /**	Parse conditional pairs
        /**	----------------------------------------*/
        
        $cond['duplicate']		= ( $duplicate ) ? TRUE: FALSE;
        $cond['not_duplicate']	= ( ! $duplicate ) ? TRUE: FALSE;
        $cond['captcha']		= ( $PREFS->ini('captcha_require_members') == 'y'  ||  ($PREFS->ini('captcha_require_members') == 'n' AND $SESS->userdata('member_id') == 0) ) ? TRUE: FALSE;
        
		$tagdata	= $FNS->prep_conditionals( $tagdata, $cond );
        
    
        /**	----------------------------------------
        /**	Parse variable pairs
        /**	----------------------------------------*/
        
		$output	= '';
        
		if ( preg_match( "/".LD."mailinglists.*?(backspace=[\"|'](\d+?)[\"|'])?".RD."(.*?)".LD.SLASH."mailinglists".RD."/s", $tagdata, $match ) )
		{			
			if ( $DB->table_exists('exp_mailing_lists') )
			{
				$query	= $DB->query( "SELECT * FROM exp_mailing_lists" );
				
				if ( $query->num_rows > 0 )
				{				
					foreach ( $query->result as $row )
					{
						$chunk	= $match['3'];
						
						foreach ( $row as $key => $val )
						{
							$chunk	= str_replace( LD.$key.RD, $val, $chunk );
						}
						
						$output	.= trim( $chunk )."\n";
					}
						
					$tagdata	= str_replace( $match['0'], $output, $tagdata );
				}
				else
				{
					$tagdata	= str_replace( $match['0'], '', $tagdata );
				}
			}
			else
			{
				$tagdata	= str_replace( $match['0'], '', $tagdata );
			}
        }
        elseif ( $mailinglist )
        {
        	unset( $TMPL->tagparams['mailinglist'] );
			
			if ( $DB->table_exists('exp_mailing_lists') )
			{        	
				$lists	= $DB->escape_str(implode( "','", preg_split( "/,|\|/" , $mailinglist ) ));
				
				$query	= $DB->query( "SELECT list_id FROM exp_mailing_lists WHERE list_id IN ('".$lists."') OR list_name IN ('".$lists."')" );
				
				if ( $query->num_rows > 0 )
				{
					foreach ( $query->result as $row )
					{
						$output	.= '<input type="hidden" name="mailinglist[]" value="'.$row['list_id'].'" />'."\n";
					}
				}
				
				$tagdata	.= '<div>'.$output.'</div>';
			}
        }
    
        /**	----------------------------------------
        /**	Parse single variables
        /**	----------------------------------------*/
                
        foreach ($TMPL->var_single as $key => $val)
        {
            /**	----------------------------------------
            /**	parse {name}
            /**	----------------------------------------*/
            
            if ($key == 'name')
            {
                $name		= ($SESS->userdata['screen_name'] != '') ? $SESS->userdata['screen_name'] : $SESS->userdata['username'];
            
                $tagdata	= $TMPL->swap_var_single($key, $REGX->form_prep($name), $tagdata);
            }
                    
            /**	----------------------------------------
            /**	parse {email}
            /**	----------------------------------------*/
            
            if ($key == 'email')
            {
                $email		= ( ! isset($_POST['email'])) ? $SESS->userdata['email'] : $_POST['email'];
              
                $tagdata	= $TMPL->swap_var_single($key, $REGX->form_prep($email), $tagdata);
            }

            /**	----------------------------------------
            /**	parse {url}
            /**	----------------------------------------*/
            
            if ($key == 'url')
            {
                $url	= ( ! isset($_POST['url'])) ? $SESS->userdata['url'] : $_POST['url'];
                
                if ($url == '')
                {
                    $url = 'http://';
				}

                $tagdata = $TMPL->swap_var_single($key, $REGX->form_prep($url), $tagdata);
            }

            /**	----------------------------------------
            /**	parse {location}
            /**	----------------------------------------*/
            
            if ($key == 'location')
            {
                $location	= ( ! isset($_POST['location'])) ? $SESS->userdata['location'] : $_POST['location'];

                $tagdata	= $TMPL->swap_var_single($key, $REGX->form_prep($location), $tagdata);
            }
            
            /**	----------------------------------------
            /**	parse {captcha}
            /**	----------------------------------------*/

			if ( preg_match("/({captcha})/", $tagdata) )
			{
				$tagdata	= preg_replace("/{captcha}/", $FNS->create_captcha(), $tagdata);
				$this->params['require_captcha']	= 'yes';
			}
                
			/**	----------------------------------------
			/**	parse custom member fields
			/**	----------------------------------------*/
			
			if ( isset( $mfields[$key] ) )
			{
				if ( isset( $mdata[$key] ) )
				{
					$tagdata = $TMPL->swap_var_single($key, $mdata[$key], $tagdata);
				}
				//	If a custom member field is set
				elseif ( isset( $mdata['m_field_id_'.$mfields[$key]] ) )
				{
					$tagdata = $TMPL->swap_var_single( $key,  $mdata['m_field_id_'.$mfields[$key]], $tagdata );
				}
				else
				{
					$tagdata = $TMPL->swap_var_single($key, '', $tagdata);
				}
			}
        }
        		
		/**	----------------------------------------
		/**	Do we have a return parameter?
		/**	----------------------------------------*/
		
		$return	= ( $TMPL->fetch_param('return') ) ? $TMPL->fetch_param('return'): '';
        
        /**	----------------------------------------
        /**	Create form
        /**	----------------------------------------*/
               
        $hidden = array(
						'ACT'					=> $FNS->fetch_action_id('Freeform', 'insert_new_entry'),
						'URI'					=> ($IN->URI == '') ? 'index' : $IN->URI,
						'XID'					=> ( ! isset($_POST['XID'])) ? '' : $_POST['XID'],
						'status'				=> ( $TMPL->fetch_param('status') !== FALSE AND $TMPL->fetch_param('status') == 'closed' ) ? 'closed' : 'open',
						'return'				=> $this->_chars_decode(str_replace(SLASH, '/', $return)),
						'redirect_on_duplicate'	=> $redirect_on_duplicate
					  );
                           
        // unset( $TMPL->tagparams['notify'] );
                              
		// $hidden	= array_merge( $hidden, $TMPL->tagparams );
		
		if ( $mailinglist_opt_in )
		{
			$hidden['mailinglist_opt_in'] = 'no';
		}
    	
		/**	----------------------------------------
		/**	Create form
		/**	----------------------------------------*/
		
		$this->data					= $hidden;
		
		$this->data['RET']			= (isset($_POST['RET'])) ? $_POST['RET'] : $FNS->fetch_current_uri();;
		
		$this->data['form_name']	= $this->params['form_name'];
		
		$this->data['id']			= ( $TMPL->fetch_param('form_id') ) ? $TMPL->fetch_param('form_id'): 'freeform';
		
		$this->data['tagdata']		= $tagdata;
    	
		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
		
		$r	= $this->_form();
		
		/**	----------------------------------------
		/**	Add class
		/**	----------------------------------------*/
		
		if ( $class = $TMPL->fetch_param('form_class') )
		{
			$r	= str_replace( "<form", "<form class=\"".$class."\"", $r );
		}
		
		/**	----------------------------------------
		/**	Add title
		/**	----------------------------------------*/
		
		if ( $form_title = $TMPL->fetch_param('form_title') )
		{
			$r	= str_replace( "<form", "<form title=\"".htmlspecialchars($form_title)."\"", $r );
		}
		
		/**	----------------------------------------
		/**	'freeform_module_form_end' hook.
		/**	----------------------------------------
		/*	This allows developers to change the
		/*	form before output.
        /**	----------------------------------------*/
        
		//if (isset($EXT->extensions['freeform_module_form_end']))
		if ($EXT->active_hook('freeform_module_form_end') === TRUE)
		{
			$r = $EXT->call_extension('freeform_module_form_end', $r);
			if ($EXT->end_script === TRUE) return;
		}
		
        /**	----------------------------------------*/
        
		//return str_replace('&#47;', '/', $r);
		//return $this->_chars_decode($r);
		return $r;
    }
    
    /**	End form */
    
    
    /**	----------------------------------------
    /**	Insert new entry
    /**	----------------------------------------*/

    function insert_new_entry()
    {
        global $DB, $EXT, $FNS, $IN, $LANG, $LOC, $OUT, $PREFS, $REGX, $SESS;
    
        $default	= array('name', 'email');
        
        $all_fields	= '';
        
        $fields		= array();
        
        $entry_id	= '';
        
        foreach ($default as $val)
        {
			if ( ! isset($_POST[$val]))
			{
				$_POST[$val] = '';
			}
        }        
               
        /**	----------------------------------------
        /**	Fetch the freeform language pack
        /**	----------------------------------------*/
        
        $LANG->fetch_language_file('freeform');        
                
        /**	----------------------------------------
        /**	Is the user banned?
        /**	----------------------------------------*/
        
        if ($SESS->userdata['is_banned'] == TRUE)
        {
        	return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
        }
                
        /**	----------------------------------------
        /**	Is the IP address and User Agent required?
        /**	----------------------------------------*/
                
        if ($this->_param('require_ip') == 'yes')
        {
        	if ($IN->IP == '0.0.0.0')
        	{            
            	return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
        	}        	
        }
        
        /**	----------------------------------------
		/**	Is the nation of the user banned?
        /**	----------------------------------------*/
        
		$SESS->nation_ban_check();
        
        /**	----------------------------------------
        /**	Blacklist/Whitelist Check
        /**	----------------------------------------*/
        
        if ($IN->blacklisted == 'y' && $IN->whitelisted == 'n')
        {
        	return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
        }
        
        /**	----------------------------------------
        /**	Check duplicates
        /**	----------------------------------------*/
        
        if ( $this->_param('prevent_duplicate_on') AND $this->_param('prevent_duplicate_on') != '' AND ( $SESS->userdata['member_id'] != '0' OR $IN->IP != '0.0.0.0' OR $IN->GBL('email') != '' ) )
        {
        	$sql	= "SELECT COUNT(*) AS count FROM exp_freeform_entries WHERE status != 'closed'";

			if ( $this->_param('form_name') )
			{
				$sql	.= " AND form_name = '".$DB->escape_str($this->_param('form_name'))."'";
			}

			if ( $this->_param('prevent_duplicate_on') == 'member_id' AND $SESS->userdata['member_id'] != '0' )
			{
				$sql	.= " AND author_id = '".$DB->escape_str($SESS->userdata['member_id'])."'";
			}
			elseif ( $this->_param('prevent_duplicate_on') == 'ip_address' AND $IN->IP != '0.0.0.0' )
			{
				$sql	.= " AND ip_address = '".$DB->escape_str($IN->IP)."'";
			}
			else
			{
				$sql	.= " AND email = '".$DB->escape_str($IN->GBL('email'))."'";
			}
        	
        	$dup	= $DB->query( $sql );
        	
        	if ( $dup->row['count'] > 0 )
        	{
				return $OUT->show_user_error('general', array($LANG->line('no_duplicates')));
        	}
        }        
        
        /**	----------------------------------------
        /**	Start error trapping on required fields
        /**	----------------------------------------*/
        
        $errors	= array();
        
        // Are there any required fields?
        
        if ( $this->_param('ee_required') != '' )
        {
        	$required_fields	= preg_split("/,|\|/" ,$this->_param('ee_required'));
        	
			/**	----------------------------------------
			/**	Let's get labels from the DB
			/**	----------------------------------------*/
			
        	$query	= $DB->query("SELECT * FROM exp_freeform_fields");
        	
        	$labels	= array();
        	
        	if ( $query->num_rows > 0 )
        	{        	
				foreach ($query->result as $row)
				{
					$labels[$row['name']]	= $row['label'];
				}        	
        	
				// Check for empty fields
				
				foreach ( $required_fields as $val )
				{
					if ( ! isset($_POST[$val]) OR $_POST[$val] == '' )
					{
						$errors[] = $LANG->line('field_required').'&nbsp;'.$labels[$val];  
					}
				}
				
				/**	End empty check */
			}
			
        	/**	End labels from DB */
        
			/**	----------------------------------------
			/**	Do we require an email address?
			/**	----------------------------------------*/
			
			if ( isset( $labels['email'] ) AND $IN->GBL('email') )
			{
				/**	----------------------------------------
				/**	Valid email address?
				/**	----------------------------------------*/
		
				if ( ! class_exists('Validate'))
				{
					require PATH_CORE.'core.validate'.EXT;
				}
				
				$VAL = new Validate( array( 'email' => $IN->GBL('email') ) );
									
				$VAL->validate_email();
		
				/**	----------------------------------------
				/**	Display errors if there are any
				/**	----------------------------------------*/
		
				if (count($VAL->errors) > 0)
				{
					return $OUT->show_user_error('general', $VAL->errors );
				}
			}
        }
        
		/**	----------------------------------------
		//	Are we trying to accept file uploads?
		/**	----------------------------------------*/
        
        if ( $this->_param('file_upload') != '' AND $this->upload_limit = $this->_param('upload_limit') )
        {
        	$this->_upload_files( TRUE );
        }
		
		/**	----------------------------------------
		/**	'freeform_module_validate_end' hook.
		/**	----------------------------------------
		/*	This allows developers to do more
		/*	form validation.
		/**	----------------------------------------*/
		
		//if (isset($EXT->extensions['freeform_module_validate_end']))
		if ($EXT->active_hook('freeform_module_validate_end') === TRUE)
		{
			$errors = $EXT->call_extension('freeform_module_validate_end', $errors);
			if ($EXT->end_script === TRUE) return;
		}
		
        /**	----------------------------------------*/
        
        /**	----------------------------------------
        /**	Do we have errors to display?
        /**	----------------------------------------*/
        
        if (count($errors) > 0)
        {
           return $OUT->show_user_error('submission', $errors);
        }
        
        /**	----------------------------------------
        /**	Do we require captcha?
        /**	----------------------------------------*/
		
		if ( $this->_param('require_captcha') AND $this->_param('require_captcha') == 'yes')
		{
			if ($PREFS->ini('captcha_require_members') == 'y'  ||  ($PREFS->ini('captcha_require_members') == 'n' AND $SESS->userdata('member_id') == 0))
			{
				if ( ! isset($_POST['captcha']) || $_POST['captcha'] == '')
				{
					return $OUT->show_user_error('submission', $LANG->line('captcha_required'));
				}
				else
				{
					$res = $DB->query("SELECT COUNT(*) AS count FROM exp_captcha WHERE word='".$DB->escape_str($_POST['captcha'])."' AND ip_address = '".$DB->escape_str($IN->IP)."' AND date > UNIX_TIMESTAMP()-7200");
				
					if ($res->row['count'] == 0)
					{
						return $OUT->show_user_error('submission', $LANG->line('captcha_incorrect'));
					}
				
					// Moved because of file uploading errors
					//$DB->query("DELETE FROM exp_captcha WHERE (word='".$DB->escape_str($_POST['captcha'])."' AND ip_address = '".$DB->escape_str($IN->IP)."') OR date < UNIX_TIMESTAMP()-7200");
				}
			}
		}        
        
        /**	----------------------------------------
        /**	Check Form Hash
        /**	----------------------------------------*/
        
        if ( $PREFS->ini('secure_forms') == 'y' )
        {        	
            $query = $DB->query("SELECT COUNT(*) AS count FROM exp_security_hashes WHERE hash='".$DB->escape_str($_POST['XID'])."' AND ip_address = '".$DB->escape_str($IN->IP)."' AND date > UNIX_TIMESTAMP()-7200");
        
            if ($query->row['count'] == 0)
            {
				return $OUT->show_user_error('general', array($LANG->line('not_authorized')));
            }
            
            // Moved because of file uploading errors                    
			// $DB->query("DELETE FROM exp_security_hashes WHERE (hash='".$DB->escape_str($_POST['XID'])."' AND ip_address = '".$DB->escape_str($IN->IP)."') OR date < UNIX_TIMESTAMP()-7200");
        }
                        
        /**	----------------------------------------
        /**	Let's get all of the fields from the
        /**	database for testing purposes
        /**	----------------------------------------*/
        
        $fields['form_name']	= "Form Name";
        $fields['subject']		= "Subject";
        
        $query		= $DB->query("SELECT name, label FROM exp_freeform_fields ORDER BY field_order ASC");
        
        if ($query->num_rows > 0)
        {
        	foreach($query->result as $row)
        	{
        		$fields[$row['name']]	= $row['label'];
        	}
        }
        else
        {
        	return false;
        }        
        
        /**	----------------------------------------
        /**	Build the data array
        /**	----------------------------------------*/
        
        $exclude	= array(
							'ACT', 'RET', 'URI', 'PRV', 'XID', 'return', 'ee_notify', 'ee_required', 'submit'
							);
							
		$include	= array('status');
        
        $data		= array(
                        'author_id'				=> $SESS->userdata['member_id'],
                        'group_id'				=> $SESS->userdata['group_id'],
                        'ip_address'			=> $IN->IP,
                        'entry_date'			=> $LOC->now,
                        'edit_date'				=> $LOC->now
        			);
        			
        foreach ( $_POST as $key => $val )
        {
			/**	----------------------------------------
        	/**	If the given field is not a FreeForm
        	/**	field or not in our include list, then
        	/**	skip it.
			/**	----------------------------------------*/
        	
        	if ( ! array_key_exists( $key, $fields ) AND ! in_array( $key, $include ) )
        		continue;
        	
			/**	----------------------------------------
        	/**	If the given field is in our exclude
        	/**	list, then skip it.
			/**	----------------------------------------*/
			
        	if ( in_array( $key, $exclude ) )
        		continue;
        	
        	if ( $key == 'website' )
        	{
        		$REGX->xss_clean( $REGX->prep_url( $_POST['website'] ) );
        		
        		$data[$key]	= $_POST[$key];
        	}
        	
			// If the field is a multi-select field, then handle it as such.
			if ( is_array( $val ) )
			{
				$val = implode( "\n", $val );
				
				$data[$key] = $REGX->xss_clean($val);
			}
			else
			{
				$data[$key] = $REGX->xss_clean($val);
			}
        }
		
		/**	----------------------------------------
		/**	'freeform_module_insert_begin' hook.
		/**	----------------------------------------
		/*	This allows developers to do one last
		/*	thing before Freeform submit is ended.
		/**	----------------------------------------*/
		
		// if (isset($EXT->extensions['freeform_module_insert_begin']))
		if ($EXT->active_hook('freeform_module_insert_begin') === TRUE)
		{
			$data = $EXT->call_extension('freeform_module_insert_begin', $data);
			if ($EXT->end_script === TRUE) return;
		}
		
        /**	----------------------------------------*/
      
        /**	----------------------------------------
        /**	Submit data into DB
        /**	----------------------------------------*/

		$sql			= $DB->insert_string( 'exp_freeform_entries', $data );
		
		$query			= $DB->query( $sql );
		
		$this->entry_id	= $DB->insert_id;
        
        /**	----------------------------------------
        /**	Process file uploads
        /**	----------------------------------------*/
        
        if ( count( $this->upload ) > 0 )
        {
        	$this->_upload_files();
        }	
        
		/**----------------------------------------
		/**	 Delete CAPTCHA and Form Hash - Moved here because of File Upload Error possibilities
		/**	----------------------------------------*/
		
		if ( $this->_param('require_captcha') == 'yes' && isset($_POST['captcha']))
		{
			$DB->query("DELETE FROM exp_captcha WHERE (word='".$DB->escape_str($_POST['captcha'])."' AND ip_address = '".$DB->escape_str($IN->IP)."') OR date < UNIX_TIMESTAMP()-7200");
		}
        
        if ( $PREFS->ini('secure_forms') == 'y' && isset($_POST['XID']))
        {        	
            $DB->query("DELETE FROM exp_security_hashes WHERE (hash='".$DB->escape_str($_POST['XID'])."' AND ip_address = '".$DB->escape_str($IN->IP)."') OR date < UNIX_TIMESTAMP()-7200");
        }
		
        /**	----------------------------------------
        /**	Send notifications
        /**	----------------------------------------*/
        
        if ( $this->_param('ee_notify') != '' )
        {
        	$recipients	= preg_split("/,|\|/" , $this->_param('ee_notify') );
        	
        	$template	= ( $this->_param('template') AND $this->_param('template') != '' ) ? $this->_param('template'): 'default';
		
			/**	----------------------------------------
			/**	Generate message
			/**	----------------------------------------*/
			
			$msg		= array();
			
			$query		= $DB->query("SELECT * FROM exp_freeform_templates 
									  WHERE template_name = '".$DB->escape_str($template)."' 
									  AND enable_template = 'y' LIMIT 1");

			if ( $query->num_rows == 0 )
			{
				return $OUT->show_user_error('general', array($LANG->line('template_not_available')));
			}
			
			$msg['from_name']	= ( isset( $query->row['data_from_name'] ) AND $query->row['data_from_name'] != '' ) ? $query->row['data_from_name']: $PREFS->ini('webmaster_name');

			$msg['from_email']	= ( isset( $query->row['data_from_email'] ) AND $query->row['data_from_email'] != '' ) ? $query->row['data_from_email']: $PREFS->ini('webmaster_email');

			$msg['subject']		= $query->row['data_title'];

			$msg['msg']			= $query->row['template_data'];

			$wordwrap			= ( isset( $query->row['wordwrap'] ) AND $query->row['wordwrap'] == 'y') ? TRUE: FALSE;
			
			$msg['subject']		= str_replace( LD.'entry_date'.RD, $LOC->set_human_time($LOC->now), $msg['subject'] );
			
			$msg['msg']			= str_replace( LD.'entry_date'.RD, $LOC->set_human_time($LOC->now), $msg['msg'] );
			
			$msg['subject']		= str_replace( LD.'freeform_entry_id'.RD, $this->entry_id, $msg['subject'] );
			$msg['msg']			= str_replace( LD.'freeform_entry_id'.RD, $this->entry_id, $msg['msg'] );
			
			if (preg_match_all("/".LD."(entry_date)\s+format=([\"'])(.*?)\\2".RD."/is", $msg['subject'].$msg['msg'], $matches))
			{
				for ($j = 0; $j < count($matches[0]); $j++)
				{	
					$val = $matches[3][$j];
					
					foreach ($LOC->fetch_date_params($matches[3][$j]) AS $dvar)
					{
						$val = str_replace($dvar, $LOC->convert_timestamp($dvar, $LOC->now, TRUE), $val);					
					}
					
					$msg['subject']		= str_replace( $matches[0][$j], $val, $msg['subject'] );
			
					$msg['msg']			= str_replace( $matches[0][$j], $val, $msg['msg'] );
				}
			}
			
			/**	----------------------------------------
			/**	Parse conditionals
			/**	----------------------------------------*/
		
			if ( ! class_exists('Template'))
			{
				require PATH_CORE.'core.template'.EXT;
			}
			
			$TMPL		= new Template();
			
			$data['attachment_count']		= count( $this->attachments );
			
			$cond		= $data;
			
			foreach( $msg as $key => $val )
			{
				$msg[$key]	= $TMPL->advanced_conditionals( $FNS->prep_conditionals( $msg[$key], $cond ) );
			}

			unset( $cond );

			/**	----------------------------------------
			/**	Parse individual fields
			/**	----------------------------------------*/
			
			$exclude	= array('submit');
			
			foreach ( $msg as $key => $val )
			{
				/**	----------------------------------------
				/**	Handle attachments
				/**	----------------------------------------*/
				
				$msg[$key]	= str_replace( LD."attachment_count".RD, $data['attachment_count'], $msg[$key] );
						
				if ( $key == 'msg' )
				{
					$all_fields	.= "Attachments: ".$data['attachment_count']."\n";
					
					$n		= 0;
					
					foreach ( $this->attachments as $file )
					{
						$n++;						
						$all_fields	.= "Attachment $n: ".$file['filename']." ".$this->upload['url'].$file['filename']."\n";
					}
				}
				
				if ( preg_match( "/".LD."attachments".RD."(.*?)".LD."\/attachments".RD."/s", $msg[$key], $match ) )
				{
					if ( count( $this->attachments ) > 0 )
					{
						$str	= '';
						
						foreach ( $this->attachments as $file )
						{
							$tagdata	= $match['1'];
							$tagdata	= str_replace( LD."fileurl".RD, $this->upload['url'].$file['filename'], $tagdata );
							$tagdata	= str_replace( LD."filename".RD, $file['filename'], $tagdata );
							$str		.= $tagdata;
						}
						
						$msg[$key]	= str_replace( $match['0'], $str, $msg[$key] );
					}
					else
					{
						$msg[$key]	= str_replace( $match['0'], "", $msg[$key] );
					}
				}
				
				/**	----------------------------------------
				/**	Loop
				/**	----------------------------------------*/
				
				foreach ( $fields as $name => $label )
				{
					if ( isset( $data[$name] ) AND ! in_array( $name, $exclude ) )
					{
						$msg[$key]	= str_replace( LD.$name.RD, $data[$name], $msg[$key] );
						
						/**	----------------------------------------
						/**	We don't want to concatenate for every
						/**	time through the main loop.
						/**	----------------------------------------*/
						
						if ( $key == 'msg' )
						{
							$all_fields	.= $label.": ".$data[$name]."\n";
						}
					}
					else
					{
						$msg[$key]	= str_replace( LD.$name.RD, '', $msg[$key] );
					}
				}
			}
			
			
			/**	----------------------------------------
			/**	Parse all fields variable
			/**	----------------------------------------*/
			
			if ( stristr( $msg['msg'], LD.'all_custom_fields'.RD ) )
			{
				$msg['msg']	= str_replace( LD.'all_custom_fields'.RD, $all_fields, $msg['msg'] );
			}
			
			
			/**	----------------------------------------
			/**	'freeform_module_admin_notification' hook.
			/**	----------------------------------------
			/*	This allows developers to alter the $msg
			/*	array before admin notification is sent.
			/**	----------------------------------------*/
			
			if ($EXT->active_hook('freeform_module_admin_notification') === TRUE)
			{
				$msg = $EXT->call_extension('freeform_module_admin_notification', $fields, $this->entry_id, $msg);
				if ($EXT->end_script === TRUE) return;
			}
			
			/**	----------------------------------------*/
			
			/**	----------------------------------------
			/**	Send email
			/**	----------------------------------------*/
			
			if ( ! class_exists('EEmail'))
			{
				require PATH_CORE.'core.email'.EXT;
			}
			
			$email				= new EEmail;
			$email->wordwrap	= $wordwrap;
			$email->mailtype	= ( $query->row['html'] == 'y' ) ? 'html': 'text';
			
			if ( count( $this->attachments ) > 0 AND $this->_param('send_attachment') != 'no' )
			{
				foreach ( $this->attachments as $file_name )
				{
					$email->attach( $file_name['filepath'] );
				}
				
				$DB->query( $DB->update_string( 'exp_freeform_attachments', array( 'emailed' => 'y' ), array( 'entry_id' => $this->entry_id ) ) );
			}
			
			foreach ($recipients as $val)
			{								
				$email->initialize();
				$email->from($msg['from_email'], $msg['from_name']);	
				$email->to($val); 
				$email->subject($msg['subject']);	
				$email->message($REGX->entities_to_ascii($msg['msg']));		
				$email->Send();
			}
			
			unset($msg);
		
			/**	----------------------------------------
			/**	Register the template used
			/**	----------------------------------------*/
			
			$DB->query( $DB->update_string( 'exp_freeform_entries', array('template' => $template), array( 'entry_id' => $this->entry_id ) ) );
		}
		
		/**	End send notifications */
		
		
        /**	----------------------------------------
        /**	Send user email
        /**	----------------------------------------*/
        
        if ( $this->_param('send_user_email') == 'yes' AND $IN->GBL('email') )
        {
        	$all_fields		= '';
        	
        	$recipients		= array();
        	
        	$recipients[]	= $IN->GBL('email');
        	
        	$template	= ( $this->_param('user_email_template') AND $this->_param('user_email_template') != '' ) ? $this->_param('user_email_template'): 'default';
		
			/**	----------------------------------------
			/**	Generate message
			/**	----------------------------------------*/
			
			$msg		= array();
			
			$query		= $DB->query("SELECT * FROM exp_freeform_templates WHERE template_name = '".$DB->escape_str($template)."' AND enable_template = 'y' LIMIT 1");

			if ( $query->num_rows == 0 )
			{
				return $OUT->show_user_error('general', array($LANG->line('template_not_available')));
			}
			
			$msg['from_name']	= ( isset( $query->row['data_from_name'] ) AND $query->row['data_from_name'] != '' ) ? $query->row['data_from_name']: $PREFS->ini('webmaster_name');

			$msg['from_email']	= ( isset( $query->row['data_from_email'] ) AND $query->row['data_from_email'] != '' ) ? $query->row['data_from_email']: $PREFS->ini('webmaster_email');

			$msg['subject']		= $query->row['data_title'];

			$msg['msg']			= $query->row['template_data'];

			$wordwrap			= ( isset( $query->row['wordwrap'] ) AND $query->row['wordwrap'] == 'y') ? TRUE: FALSE;
			
			$msg['subject']		= str_replace( LD.'entry_date'.RD, $LOC->set_human_time($LOC->now), $msg['subject'] );
			
			$msg['msg']			= str_replace( LD.'entry_date'.RD, $LOC->set_human_time($LOC->now), $msg['msg'] );
			
			$msg['subject']		= str_replace( LD.'freeform_entry_id'.RD, $this->entry_id, $msg['subject'] );
			$msg['msg']			= str_replace( LD.'freeform_entry_id'.RD, $this->entry_id, $msg['msg'] );
			
			/**	----------------------------------------
			/**	Parse conditionals
			/**	----------------------------------------*/
		
			if ( ! class_exists('Template'))
			{
				require PATH_CORE.'core.template'.EXT;
			}
			
			$TMPL		= new Template();
			
			$data['attachment_count']		= count( $this->attachments );
			
			$cond		= $data;
			
			foreach( $msg as $key => $val )
			{
				$msg[$key]	= $TMPL->advanced_conditionals( $FNS->prep_conditionals( $msg[$key], $cond ) );
			}

			unset( $cond );

			/**	----------------------------------------
			/**	Parse individual fields
			/**	----------------------------------------*/
			
			$exclude	= array('submit');
			
			foreach ( $msg as $key => $val )
			{
				/**	----------------------------------------
				/**	Handle attachments
				/**	----------------------------------------*/
				
				$msg[$key]	= str_replace( LD."attachment_count".RD, $data['attachment_count'], $msg[$key] );
						
				if ( $key == 'msg' )
				{
					$all_fields	.= "Attachments: ".$data['attachment_count']."\n";
					
					$n		= 0;
					
					foreach ( $this->attachments as $file )
					{
						$n++;						
						$all_fields	.= "Attachment $n: ".$file['filename']." ".$this->upload['url'].$file['filename']."\n";
					}
				}
				
				if ( preg_match( "/".LD."attachments".RD."(.*?)".LD."\/attachments".RD."/s", $msg[$key], $match ) )
				{
					if ( count( $this->attachments ) > 0 )
					{
						$str	= '';
						
						foreach ( $this->attachments as $file )
						{
							$tagdata	= $match['1'];
							$tagdata	= str_replace( LD."fileurl".RD, $this->upload['url'].$file['filename'], $tagdata );
							$tagdata	= str_replace( LD."filename".RD, $file['filename'], $tagdata );
							$str		.= $tagdata;
						}
						
						$msg[$key]	= str_replace( $match['0'], $str, $msg[$key] );
					}
					else
					{
						$msg[$key]	= str_replace( $match['0'], "", $msg[$key] );
					}
				}
				
				/**	----------------------------------------
				/**	Loop
				/**	----------------------------------------*/
				
				foreach ( $fields as $name => $label )
				{
					if ( isset( $data[$name] ) AND ! in_array( $name, $exclude ) )
					{
						$msg[$key]	= str_replace( LD.$name.RD, $data[$name], $msg[$key] );
						
						/**	----------------------------------------
						/**	We don't want to concatenate for every
						/**	time through the main loop.
						/**	----------------------------------------*/
						
						if ( $key == 'msg' )
						{
							$all_fields	.= $label.": ".$data[$name]."\n";
						}
					}
					else
					{
						$msg[$key]	= str_replace( LD.$name.RD, '', $msg[$key] );
					}
				}
			}
			
			
			/**	----------------------------------------
			/**	Parse all fields variable
			/**	----------------------------------------*/
			
			if ( stristr( $msg['msg'], LD.'all_custom_fields'.RD ) )
			{
				$msg['msg']	= str_replace( LD.'all_custom_fields'.RD, $all_fields, $msg['msg'] );
			}
			
			/**	----------------------------------------
			/**	'freeform_module_user_notification' hook.
			/**	----------------------------------------
			/*	This allows developers to alter the $msg
			/*	array before user notification is sent.
			/**	----------------------------------------*/
			
			if ($EXT->active_hook('freeform_module_user_notification') === TRUE)
			{
				$msg = $EXT->call_extension('freeform_module_user_notification', $fields, $this->entry_id, $msg);
				if ($EXT->end_script === TRUE) return;
			}
			
			/**	----------------------------------------*/
		
			/**	----------------------------------------
			/**	Send email
			/**	----------------------------------------*/
			
			if ( ! class_exists('EEmail'))
			{
				require PATH_CORE.'core.email'.EXT;
			}
			
			$email				= new EEmail;
			$email->wordwrap	= $wordwrap;
			$email->mailtype	= ( $query->row['html'] == 'y' ) ? 'html': 'text';
			
			if ( count( $this->attachments ) > 0 AND $this->_param('send_user_attachment') != 'no' )
			{
				foreach ( $this->attachments as $file_name )
				{
					$email->attach( $file_name['filepath'] );
				}
				
				$DB->query( $DB->update_string( 'exp_freeform_attachments', array( 'emailed' => 'y' ), array( 'entry_id' => $this->entry_id ) ) );
			}
			
			foreach ($recipients as $val)
			{								
				$email->initialize();
				$email->from($msg['from_email'], $msg['from_name']);	
				$email->to($val); 
				$email->subject($msg['subject']);	
				$email->message($REGX->entities_to_ascii($msg['msg']));		
				$email->Send();
			}
			
			// unset($msg);
		}
		
		/**	End send user email */
		
		
		/**	----------------------------------------
		/**	Subscribe to mailing lists
		/**	----------------------------------------*/
		
		if ( $IN->GBL('mailinglist') )
		{			
			if ( $DB->table_exists('exp_mailing_lists') )
			{
				/**	----------------------------------------
				/**	Do we have an email?
				/**	----------------------------------------*/
				
				if ( $email = $IN->GBL('email') )
				{
					/**	----------------------------------------
					/**	Explode mailinglist parameter
					/**	----------------------------------------*/
					
					if ( is_array( $_POST['mailinglist'] ) )
					{
						$lists	= implode( "','", $DB->escape_str($_POST['mailinglist']));
					}
					else
					{
						$lists	= $DB->escape_str($_POST['mailinglist']);
					}
					
					/**	----------------------------------------
					/**	Get lists
					/**	----------------------------------------*/
					
					$subscribed	= '';
					
					$sub	= $DB->query( "SELECT list_id FROM exp_mailing_list WHERE email = '".$DB->escape_str($email)."' GROUP BY list_id" );

					if ( $sub->num_rows > 0 )
					{
						foreach( $sub->result as $row )
						{
							$subscribed[] = $row['list_id'];
						}
						
						$subscribed	= " AND list_id NOT IN (".implode(',', $subscribed).") ";
					}
					
					$query	= $DB->query( "SELECT DISTINCT list_id, list_title FROM exp_mailing_lists 
										   WHERE ( list_id IN ('".$lists."') OR list_name IN ('".$lists."') ) ".
										   $subscribed);
					
					if ( $query->num_rows > 0 AND $query->num_rows < 50 )
					{				
						// Kill duplicate emails from authorization queue.  This prevents an error if a user
						// signs up but never activates their email, then signs up again.
						
						$DB->query("DELETE FROM exp_mailing_list_queue WHERE email = '".$DB->escape_str($email)."'");
					
						foreach ( $query->result as $row )
						{
							/**	----------------------------------------
							/**	Insert email
							/**	----------------------------------------*/
									
							$code	= $FNS->random('alpha', 10);
							
							if (  $IN->GBL('mailinglist_opt_in') == 'no' )
							{
								$DB->query($DB->insert_string(	'exp_mailing_list',
																array(	'user_id'		=> '',
																		'list_id'		=> $row['list_id'],
																		'authcode'		=> $code,
																		'email'			=> $email,
																		'ip_address'	=> $IN->IP)
															));
														
								/** ----------------------------------------
								/**  Is there an admin notification to send?
								/** ----------------------------------------*/
						
								if ($PREFS->ini('mailinglist_notify') == 'y' AND $PREFS->ini('mailinglist_notify_emails') != '')
								{
									$query = $DB->query("SELECT list_title FROM exp_mailing_lists WHERE list_id = '".$DB->escape_str($row['list_id'])."'");
								
									$swap = array(
													'email'			=> $email,
													'mailing_list'	=> $query->row['list_title']
												 );
									
									$template = $FNS->fetch_email_template('admin_notify_mailinglist');
									$email_tit = $FNS->var_swap($template['title'], $swap);
									$email_msg = $FNS->var_swap($template['data'], $swap);
																		
									/** ----------------------------
									/**  Send email
									/** ----------------------------*/
						
									$notify_address = $REGX->remove_extra_commas($PREFS->ini('mailinglist_notify_emails'));
									
									if ($notify_address != '')
									{				
										/** ----------------------------
										/**  Send email
										/** ----------------------------*/
										
										if ( ! class_exists('EEmail'))
										{
											require PATH_CORE.'core.email'.EXT;
										}
										
										$email = new EEmail;
										//$email->debug = TRUE;
										
										foreach (explode(',', $notify_address) as $addy)
										{
											$email->initialize();
											$email->wordwrap = true;
											$email->from($PREFS->ini('webmaster_email'), $PREFS->ini('webmaster_name'));	
											$email->to($addy); 
											$email->reply_to($PREFS->ini('webmaster_email'));
											$email->subject($email_tit);	
											$email->message($REGX->entities_to_ascii($email_msg));		
											$email->Send();
										}
									}
								}
							}        
							else
							{        	
								$DB->query("INSERT INTO exp_mailing_list_queue (email, list_id, authcode, date) 
											VALUES ('".$DB->escape_str($email)."', '".$DB->escape_str($row['list_id'])."', '".$DB->escape_str($code)."', '".time()."')");
								
								$this->send_email_confirmation($email, $row, $code);
							}
						}
					}
				}
			}
		}
		
		/**	End subscribe to mailinglists */
		
		/**	----------------------------------------
		/**	'freeform_module_insert_end' hook.
		/**	----------------------------------------
		/*	This allows developers to do one last
		/*	thing before Freeform submit is ended.
		/**	----------------------------------------*/
		
		// if (isset($EXT->extensions['freeform_module_insert_end']))
		if ($EXT->active_hook('freeform_module_insert_end') === TRUE)
		{
			$edata = $EXT->call_extension('freeform_module_insert_end', $fields, $this->entry_id, $msg);
			if ($EXT->end_script === TRUE) return;
		}
			
        /**	----------------------------------------*/
		
		/**	----------------------------------------
		/**	Set return
		/**	----------------------------------------*/
        
        if ( ! $return = $IN->GBL('return') )
        {
        	$return	= $IN->GBL('RET');
        }
		
		if ( preg_match( "/".LD."\s*path=(.*?)".RD."/", $return, $match ) > 0 )
		{
			$return	= $FNS->create_url( $match['1'] );
		}
		elseif ( stristr( $return, "http://" ) === FALSE && stristr( $return, "https://" ) === FALSE )
		{
			$return	= $FNS->create_url( $return );
		}
		
		$return	= str_replace( "%%entry_id%%", $this->entry_id, $return );
		
		$return	= $this->_chars_decode( $return );
				
        /**	----------------------------------------
        /**	Return the user
        /**	----------------------------------------*/
        
        if ( $return != '' )
        {
			$FNS->redirect( $return );
        }
        else
        {
        	$FNS->redirect( $FNS->fetch_site_index() );
        }
		
		exit;
    }
    
    /**	End insert */
    
	
	/**	----------------------------------------
	/**	Send confirmation email
	/**	----------------------------------------*/

	function send_email_confirmation($email, $row, $code)
	{
		global $LANG, $PREFS, $FNS;
		
		if ( ! is_array($row) OR ! isset($row['list_title']))
		{
			return FALSE;
		}
        
        $qs			= ($PREFS->ini('force_query_string') == 'y') ? '' : '?';        
		$action_id  = $FNS->fetch_action_id('Mailinglist', 'authorize_email');

		$swap		= array(
						'activation_url'	=> $FNS->fetch_site_index(0, 0).$qs.'ACT='.$action_id.'&id='.$code,
						'site_name'			=> stripslashes($PREFS->ini('site_name')),
						'site_url'			=> $PREFS->ini('site_url'),
						'mailing_list'		=> $row['list_title']
					 );
		
		foreach ( $row as $key => $val )
		{
			$swap[$key]	= $val;
		}
		
		$template	= $FNS->fetch_email_template('mailinglist_activation_instructions');
		$email_tit	= $FNS->var_swap($template['title'], $swap);
		$email_msg	= $FNS->var_swap($template['data'], $swap);
		
		/**	----------------------------------------
		/**	Send email
		/**	----------------------------------------*/
		
		if ( ! class_exists('EEmail'))
		{			
			require PATH_CORE.'core.email'.EXT;
		}
					
		$E = new EEmail;        
		$E->wordwrap = true;
		$E->mailtype = 'plain';
		$E->priority = '3';
		
		$E->from($PREFS->ini('webmaster_email'), $PREFS->ini('webmaster_name'));	
		$E->to($email); 
		$E->subject($email_tit);	
		$E->message($email_msg);	
		$E->Send();
	}
	
	/**	End confirmation email */
    
    
    /**	----------------------------------------
    /**	Entries
    /**	----------------------------------------*/

    function entries()
    {
    	global $DB, $FNS, $IN, $LOC, $TMPL;
    	
		/**	----------------------------------------
		/**	Trigger benchmarking for performance
		/**	tracking
		/**	----------------------------------------*/
		
		$TMPL->log_item('Freeform Module: Prep Query');
		
		/**	----------------------------------------
		/**	Dynamic
		/**	----------------------------------------*/
		
		$this->dynamic	= ( $TMPL->fetch_param('dynamic') != 'off' ) ? TRUE: FALSE;
    	
		/**	----------------------------------------
		/**	Get entries
		/**	----------------------------------------*/
		
		$sql	= "SELECT * FROM exp_freeform_entries WHERE entry_date != ''";
		
		/**	----------------------------------------
		/**	Entry id
		/**	----------------------------------------*/
		
		if ( $this->_entry_id() === TRUE )
		{
			$sql	.= " AND entry_id = '".$DB->escape_str($this->entry_id)."'";
		}
		
		if ( $TMPL->fetch_param('form_name') !== FALSE )
		{
			$sql	.= " AND form_name = '".$DB->escape_str($TMPL->fetch_param('form_name'))."'";
		}
		
		if ( $TMPL->fetch_param('status') !== FALSE )
		{
			$stats	= preg_split( "/,|\|/", $TMPL->fetch_param('status') );
			
			$arr	= array_intersect( array('open','closed'), $stats );
			
			if ( count($arr) > 0 )
			{
				$sql	.= " AND status IN ('".implode( "','", $arr )."')";
			}
			else
			{
				$sql	.= " AND status = 'open'";
			}
		}
		else
		{
			$sql	.= " AND status = 'open'";
		}
		
		if ( $TMPL->fetch_param('orderby') !== FALSE )
		{
			$sql	.= " ORDER BY ".$TMPL->fetch_param('orderby');
		}
		else
		{
			$sql	.= " ORDER BY entry_date";
		}		
		
		if ( $TMPL->fetch_param('sort') !== FALSE )
		{
			$sql	.= ( $TMPL->fetch_param('sort') == 'asc' ) ? ' ASC': ' DESC';
		}
		
		if ( $TMPL->fetch_param('limit') !== FALSE )
		{
			$sql	.= " LIMIT ".$TMPL->fetch_param('limit');
		}
		else
		{
			$sql	.= " LIMIT 100";
		}
		
		/**	----------------------------------------
		/**	Run query
		/**	----------------------------------------*/
		
		$TMPL->log_item('Freeform Module: Run Query');
		
		$query	= $DB->query($sql);
    	
		/**	----------------------------------------
		/**	Results?
		/**	----------------------------------------*/
		
		if ( $query->num_rows == 0 )
		{
			return $TMPL->no_results();
		}
    	
		/**	----------------------------------------
		/**	Grab attachments
		/**	----------------------------------------*/
		
		$TMPL->log_item('Freeform Module: Loop Query');
		
		$entry_ids	= array();
		
		foreach ( $query->result as $row )
		{
			$entry_ids[]	= $row['entry_id'];
		}
		
		$attachmentsq	= $DB->query( "SELECT a.*, CONCAT( p.url, a.filename, a.extension ) AS fileurl FROM exp_freeform_attachments a LEFT JOIN exp_upload_prefs p ON p.id = a.pref_id WHERE a.entry_id IN ('".implode( "','", $entry_ids )."')" );
		
		$attachments	= array();
		
		foreach( $attachmentsq->result as $row )
		{
			$attachments[ $row['entry_id'] ][]	= $row;
		}
		
        /**	----------------------------------------
        /**	Fetch all the date-related variables
        /**	----------------------------------------*/
        
        $entry_date 		= array();
        $gmt_entry_date		= array();
        $edit_date 			= array();
        $gmt_edit_date		= array();
        
        // We do this here to avoid processing cycles in the foreach loop
        
        $date_vars = array('entry_date', 'gmt_entry_date', 'edit_date', 'gmt_edit_date');
                
		foreach ($date_vars as $val)
		{
			if (preg_match_all("/".LD.$val."\s+format=[\"'](.*?)[\"']".RD."/s", $TMPL->tagdata, $matches))
			{
				for ($j = 0; $j < count($matches['0']); $j++)
				{
					$matches['0'][$j] = str_replace(array(LD,RD), '', $matches['0'][$j]);
					
					switch ($val)
					{
						case 'entry_date' 			: $entry_date[$matches['0'][$j]] = $LOC->fetch_date_params($matches['1'][$j]);
							break;
						case 'gmt_entry_date'		: $gmt_entry_date[$matches['0'][$j]] = $LOC->fetch_date_params($matches['1'][$j]);
							break;
						case 'edit_date' 			: $edit_date[$matches['0'][$j]] = $LOC->fetch_date_params($matches['1'][$j]);
							break;
						case 'gmt_edit_date'		: $gmt_edit_date[$matches['0'][$j]] = $LOC->fetch_date_params($matches['1'][$j]);
							break;
					}
				}
			}
		}
    	
		/**	----------------------------------------
		/**	Parse
		/**	----------------------------------------*/
		
		$return			= '';
		
		$count			= 1;
		
		$reverse_count	= $query->num_rows;
		
		foreach ( $query->result as $row )
		{
			$row['count']			= $count++;
			
			$row['reverse_count']	= $reverse_count--;
			
			$row['total_entries']	= $query->num_rows;

			$tagdata				= $TMPL->tagdata;
			
			/**	----------------------------------------
			/**	Conditionals
			/**	----------------------------------------*/
			
			$cond			= $row;
			
			$tagdata		= $FNS->prep_conditionals( $tagdata, $cond );
			
			/**	----------------------------------------
			/**	Var pairs
			/**	----------------------------------------*/
			
			foreach ( $TMPL->var_pair as $key => $val )
			{				
				$out		= '';
				
				if ( $key == 'attachments' )
				{
					if ( isset( $attachments[ $row['entry_id'] ] ) )
					{
						preg_match( "/".LD.$key.RD."(.*?)".LD.SLASH.$key.RD."/s", $tagdata, $match );
						
						$r	=	'';
						
						foreach ( $attachments[ $row['entry_id'] ] as $att )
						{
							$str	= $match['1'];
							
							foreach ( $att as $k => $v )
							{
								$str	= str_replace( LD.$k.RD, $v, $str );
							}
							
							$r	.= $str;
						}
						
						$tagdata	= str_replace( $match['0'], $r, $tagdata );
					}
					else
					{
						$tagdata	= $TMPL->delete_var_pairs( $key, $key, $tagdata );
					}
				}
			}
			
			/**	----------------------------------------
			/**	Single Vars
			/**	----------------------------------------*/
			
			foreach ( $TMPL->var_single as $key => $val )
			{
				/**	----------------------------------------
				/**	parse {attachment_count} variable
				/**	----------------------------------------*/
				
				if ( $key == 'attachment_count' )
				{
					if ( isset( $attachments[ $row['entry_id'] ] ) )
					{
						$tagdata = $TMPL->swap_var_single($key, count( $attachments[ $row['entry_id'] ] ), $tagdata);
					}
					else
					{
						$tagdata = $TMPL->swap_var_single($key, '0', $tagdata);
					}
				}
				
				/**	----------------------------------------
				/**	parse {switch} variable
				/**	----------------------------------------*/
				
				if (preg_match("/^switch\s*=.+/i", $key))
				{
					$sparam = $FNS->assign_parameters($key);
					
					$sw = '';
	
					if (isset($sparam['switch']))
					{
						$sopt = explode("|", $sparam['switch']);
						
						if (count($sopt) == 2)
						{
							if (isset($switch[$sparam['switch']]) AND $switch[$sparam['switch']] == $sopt['0'])
							{
								$switch[$sparam['switch']] = $sopt['1'];
								
								$sw = $sopt['1'];									
							}
							else
							{
								$switch[$sparam['switch']] = $sopt['0'];
								
								$sw = $sopt['0'];									
							}
						}
					}
					
					$tagdata = $TMPL->swap_var_single($key, $sw, $tagdata);
				}
                                
                /**	----------------------------------------
                /**	parse entry date
                /**	----------------------------------------*/
                
                if (isset($entry_date[$key]))
                {
					foreach ($entry_date[$key] as $dvar)
						$val = str_replace($dvar, $LOC->convert_timestamp($dvar, $row['entry_date'], TRUE), $val);					

					$tagdata = $TMPL->swap_var_single($key, $val, $tagdata);					
                }
            
                /**	----------------------------------------
                /**	GMT date - entry date in GMT
                /**	----------------------------------------*/
                
                if (isset($gmt_entry_date[$key]))
                {
					foreach ($gmt_entry_date[$key] as $dvar)
						$val = str_replace($dvar, $LOC->convert_timestamp($dvar, $row['entry_date'], FALSE), $val);					

					$tagdata = $TMPL->swap_var_single($key, $val, $tagdata);					
                }
                
                if (isset($gmt_date[$key]))
                {
					foreach ($gmt_date[$key] as $dvar)
						$val = str_replace($dvar, $LOC->convert_timestamp($dvar, $row['entry_date'], FALSE), $val);					

					$tagdata = $TMPL->swap_var_single($key, $val, $tagdata);					
                }
                                
                /**	----------------------------------------
                /**	parse edit date
                /**	----------------------------------------*/
                
                if (isset($edit_date[$key]))
                {
					foreach ($edit_date[$key] as $dvar)
						$val = str_replace($dvar, $LOC->convert_timestamp($dvar, $LOC->timestamp_to_gmt($row['edit_date']), TRUE), $val);					

					$tagdata = $TMPL->swap_var_single($key, $val, $tagdata);					
                }
                
                /**	----------------------------------------
                /**	Edit date as GMT
                /**	----------------------------------------*/
                
                if (isset($gmt_edit_date[$key]))
                {
					foreach ($gmt_edit_date[$key] as $dvar)
						$val = str_replace($dvar, $LOC->convert_timestamp($dvar, $LOC->timestamp_to_gmt($row['edit_date']), FALSE), $val);					

					$tagdata = $TMPL->swap_var_single($key, $val, $tagdata);					
                }
                
                /**	----------------------------------------
                /**	Remaining variables
                /**	----------------------------------------*/
			
				if ( isset( $row[$key] ) )
				{
					$tagdata	= $TMPL->swap_var_single( $key, $row[$key], $tagdata );
				}
			}
			
			/**	----------------------------------------
			/**	Concat
			/**	----------------------------------------*/
			
			$return	.=	$tagdata;			
		}
			
		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
		
		$TMPL->log_item('Freeform Module: Return Data');
		
		return $return;
    }
    
    /**	End entries */
    
    
    /**	----------------------------------------
    /**	Count
    /**	----------------------------------------
    /*	Get counts of total submissions to
    /*	Freeform.
    /**	----------------------------------------*/

    function count()
    {
    	global $DB, $LOC, $TMPL;
    	
		/**	----------------------------------------
		/**	Date fields
		/**	----------------------------------------*/
		
		$date		= array('entry_date', 'edit_date');
    	
		/**	----------------------------------------
		/**	Primary fields
		/**	----------------------------------------*/
		
		$primary	= array('entry_id', 'group_id', 'weblog_id', 'author_id', 'ip_address', 'form_name', 'template', 'status' );
    	
		/**	----------------------------------------
		/**	Custom fields
		/**	----------------------------------------*/
		
		$custom		= array();
		
		$query		= $DB->query("SELECT name FROM exp_freeform_fields");
		
		if ( $query->num_rows > 0 )
		{
			foreach( $query->result as $row )
			{
				$custom[]	= $row['name'];
			}
		}
		
		/**	----------------------------------------
		/**	Merge
		/**	----------------------------------------*/
		
		$fields	= array_merge( $primary, $custom );
    	
		/**	----------------------------------------
		/**	Assemble
		/**	----------------------------------------*/
    	
    	$sql	= "SELECT COUNT(*) AS count FROM exp_freeform_entries WHERE entry_id != ''";
    	
		/**	----------------------------------------
		/**	Date fields
		/**	----------------------------------------*/
		
		foreach ( $date as $key )
		{
			if ( $val = $TMPL->fetch_param($key) )
			{
				if ( is_numeric( $val ) )
				{
					$sql	.= " AND ".$key." >= ".($LOC->now - ($val * 60 * 60));
				}
			}
		}
    	
		/**	----------------------------------------
		/**	Fields
		/**	----------------------------------------*/
		
		foreach ( $fields as $key )
		{
			if ( $val = $TMPL->fetch_param($key) )
			{
				$sql	.= " AND ".$key." = '".$DB->escape_str($val)."'";
			}
		}
    	
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$query	= $DB->query( $sql );
		
		/**	----------------------------------------
		/**	Output
		/**	----------------------------------------*/
		
		return str_replace( LD.'count'.RD, $query->row['count'], $TMPL->tagdata );
    }
    
    /**	End count */
	
	
	/**	----------------------------------------
    /**	Entry id
	/**	----------------------------------------*/
    
    function _entry_id( $id = 'entry_id' )
    {
    	global $DB, $IN, $PREFS, $REGX, $TMPL;
    	
		$cat_segment	= $PREFS->ini("reserved_category_word");
		
		if ( $this->entry_id != '' )
		{
			return TRUE;
		}    	
		elseif ( $TMPL AND is_numeric( trim( $TMPL->fetch_param($id) ) ) )
		{
			$this->entry_id	= trim( $TMPL->fetch_param($id) );
			
			return TRUE;
		}
		elseif ( $IN->GBL($id) )
		{
			$this->entry_id	= $IN->GBL($id);
			
			return TRUE;
		}
		elseif ( $IN->QSTR != '' AND $this->dynamic )
		{
			$qstring	= $IN->QSTR;
			
			/**	----------------------------------------
			/**	Do we have a pure ID number?
			/**	----------------------------------------*/
		
			if ( is_numeric( $qstring) )
			{
				$this->entry_id	= $qstring;
				
				return TRUE;
			}
			else
			{
				/**	----------------------------------------
				/**	Parse day
				/**	----------------------------------------*/
				
				if (preg_match("#\d{4}/\d{2}/(\d{2})#", $qstring, $match))
				{											
					$partial	= substr($match['0'], 0, -3);
										
					$qstring	= $REGX->trim_slashes(str_replace($match['0'], $partial, $qstring));
				}
				
				/**	----------------------------------------
				/**	Parse /year/month/
				/**	----------------------------------------*/
										
				if (preg_match("#(\d{4}/\d{2})#", $qstring, $match))
				{					
					$qstring	= $REGX->trim_slashes(str_replace($match['1'], '', $qstring));
				}				

				/**	----------------------------------------
				/**	Parse page number
				/**	----------------------------------------*/
				
				if (preg_match("#^P(\d+)|/P(\d+)#", $qstring, $match))
				{					
					$qstring	= $REGX->trim_slashes(str_replace($match['0'], '', $qstring));
				}

				/**	----------------------------------------
				/**	Parse category indicator
				/**	----------------------------------------*/
				
				// Text version of the category
				
				if (preg_match("#^".$cat_segment."/#", $qstring, $match) AND $TMPL->fetch_param('weblog'))
				{		
					$qstring	= str_replace($cat_segment.'/', '', $qstring);
						
					$sql		= "SELECT DISTINCT cat_group FROM exp_weblogs WHERE ";
					
					if (USER_BLOG !== FALSE)
					{
						$sql	.= " weblog_id='".UB_BLOG_ID."'";
					}
					else
					{
						$xsql	= $FNS->sql_andor_string($TMPL->fetch_param('weblog'), 'blog_name');
						
						if (substr($xsql, 0, 3) == 'AND') $xsql = substr($xsql, 3);
						
						$sql	.= ' '.$xsql;
					}
						
					$query	= $DB->query($sql);
					
					if ($query->num_rows == 1)
					{
						$result	= $DB->query("SELECT cat_id FROM exp_categories WHERE cat_name='".$DB->escape_str($qstring)."' AND group_id='{$query->row['cat_group']}'");
					
						if ($result->num_rows == 1)
						{
							$qstring	= 'C'.$result->row['cat_id'];
						}
					}
				}

				/**	----------------------------------------
				/**	Numeric version of the category
				/**	----------------------------------------*/

				if (preg_match("#^C(\d+)#", $qstring, $match))
				{														
					$qstring	= $REGX->trim_slashes(str_replace($match['0'], '', $qstring));
				}
				
				/**	----------------------------------------
				/**	Remove "N"
				/**	----------------------------------------
				/*	The recent comments feature uses "N" as
				/*	the URL indicator
				/*	It needs to be removed if present
				/**	----------------------------------------*/

				if (preg_match("#^N(\d+)|/N(\d+)#", $qstring, $match))
				{					
					$qstring	= $REGX->trim_slashes(str_replace($match['0'], '', $qstring));
				}
				
				/**	----------------------------------------
				/**	Try numeric id again
				/**	----------------------------------------*/
				
				if ( preg_match( "/(\d+)/", $qstring, $match ) )
				{
					$this->entry_id	= $match['1'];
					
					return TRUE;
				}

				/**	----------------------------------------
				/**	Parse URL title
				/**	----------------------------------------*/
				
				if (strstr($qstring, '/'))
				{
					$xe			= explode('/', $qstring);
					$qstring	= current($xe);
				}
				
				$sql	= "SELECT exp_weblog_titles.entry_id FROM  exp_weblog_titles, exp_weblogs WHERE exp_weblog_titles.weblog_id = exp_weblogs.weblog_id AND   exp_weblog_titles.url_title = '".$DB->escape_str($qstring)."'";
				
				if (USER_BLOG !== FALSE)
				{
					$sql	.= " AND exp_weblogs.weblog_id = '".UB_BLOG_ID."'";
				}
				else
				{
					$sql	.= " AND exp_weblogs.is_user_blog = 'n'";
				}
								
				$query	= $DB->query($sql);
				
				if ( $query->num_rows > 0 )
				{
					$this->entry_id = $query->row['entry_id'];
					
					return TRUE;
				}
			}
		}
		
		return FALSE;
	}
	
	/**	End entry id */
	
	
    /**	----------------------------------------
    /**	Form
    /**	----------------------------------------*/
    
    function _form( $data = array() )
    {
    	global $FNS, $TMPL;
    	
    	if ( count( $data ) == 0 AND ! isset( $this->data ) ) return '';
    	
    	if ( ! isset( $this->data['tagdata'] ) OR $this->data['tagdata'] == '' )
    	{
			$tagdata	=	$TMPL->tagdata;
    	}
    	else
    	{
    		$tagdata	= $this->data['tagdata'];
    		unset( $this->data['tagdata'] );
    	}

		/**	----------------------------------------
		/**	Insert params
		/**	----------------------------------------*/
		
		if ( ! $this->params_id = $this->_insert_params() )
		{
			$this->params_id	= 0;
		}
		
		$this->data['params_id']	= $this->params_id;

		/**	----------------------------------------
		/**	Generate form
		/**	----------------------------------------*/
		
		$arr	= array(
						'hidden_fields'	=> $this->data,
						'action'		=> $FNS->fetch_site_index(),
						'id'			=> $this->data['id'],
						'enctype'		=> ( $this->multipart ) ? 'multi': '',
						'onsubmit'		=> ( $TMPL->fetch_param('onsubmit') ) ? $TMPL->fetch_param('onsubmit'): ''
						);
						
		if ( $TMPL->fetch_param('name') !== FALSE )
		{
			$arr['name']	= $TMPL->fetch_param('name');
		}
		
		/** --------------------------------------------
        /**  HTTPS URLs?
        /** --------------------------------------------*/
		
		if ($TMPL->fetch_param('secure_action') == 'yes')
		{
			if (isset($arr['action']))
			{
				$arr['action'] = str_replace('http://', 'https://', $arr['action']);
			}
		}
		
		if ($TMPL->fetch_param('secure_return') == 'yes')
		{
			foreach(array('return', 'RET') as $return_field)
			{
				if (isset($arr['hidden_fields'][$return_field]))
				{
					if ( preg_match( "/".LD."\s*path=(.*?)".RD."/", $arr['hidden_fields'][$return_field], $match ) > 0 )
					{
						$arr['hidden_fields'][$return_field] = $FNS->create_url( $match['1'] );
					}
					elseif ( stristr( $arr['hidden_fields'][$return_field], "http://" ) === FALSE )
					{
						$arr['hidden_fields'][$return_field] = $FNS->create_url( $arr['hidden_fields'][$return_field] );
					}
				
					$arr['hidden_fields'][$return_field] = str_replace('http://', 'https://', $arr['hidden_fields'][$return_field]);
				}
			}
		}
		
		/** --------------------------------------------
        /**  Create and Return Form
        /** --------------------------------------------*/
				
        $r		= $FNS->form_declaration( $arr );
        
        $r	.= stripslashes($tagdata);
        
        $r	.= "</form>";
        
		//return $this->_chars_decode($r);
		return $r;
    }
    
    /**	End form */
	
	
    /**	----------------------------------------
    /**	Chars decode
    /**	----------------------------------------*/
    
    function _chars_decode( $str = '' )
    {
		global $PREFS;
		
		if ( $str == '' ) return;
		
		$charset = $PREFS->ini('charset');
		
		if ( version_compare('5.0.0', PHP_VERSION, '>') )
		{
			$valid_sets = array (	'ISO-8859-1','ISO8859-1',
									'ISO-8859-15','ISO8859-15',
									'UTF-8',
									'cp866','ibm866','866',
									'cp1251','Windows-1251','win-1251','1251',
									'cp1252','Windows-1252','1252',
									'KOI8-R','koi8-ru','koi8r',
									'BIG5','950',
									'GB2312','936',
									'BIG5-HKSCS',
									'Shift_JIS','SJIS','932',
									'EUC-JP'
								);
			
			if ( ! in_array($charset, $valid_sets) ) $charset = 'ISO-8859-1';
		}
    	
    	if ( function_exists( 'html_entity_decode' ) === TRUE )
    	{
    		$str	= $this->_html_entity_decode_full( $str, ENT_COMPAT, $charset );
    	}

		//$str	= str_replace( array( '&amp;', '&#47;', '&#39;' ), array( '&', '/', '' ), $str );
    	
    	$str	= stripslashes( $str );
    	
    	return $str;
    }

	function _html_entity_decode_full($string, $quotes = ENT_COMPAT, $charset = 'ISO-8859-1')
	{
		return html_entity_decode(preg_replace_callback('/&([a-zA-Z][a-zA-Z0-9]+);/', array($this, '_convert_entity'), $string), $quotes, $charset);
	}
	
	function _convert_entity($matches, $destroy = true)
	{
		$table = array('quot' => '&#34;','amp' => '&#38;','lt' => '&#60;','gt' => '&#62;','OElig' => '&#338;','oelig' => '&#339;','Scaron' => '&#352;','scaron' => '&#353;','Yuml' => '&#376;','circ' => '&#710;','tilde' => '&#732;','ensp' => '&#8194;','emsp' => '&#8195;','thinsp' => '&#8201;','zwnj' => '&#8204;','zwj' => '&#8205;','lrm' => '&#8206;','rlm' => '&#8207;','ndash' => '&#8211;','mdash' => '&#8212;','lsquo' => '&#8216;','rsquo' => '&#8217;','sbquo' => '&#8218;','ldquo' => '&#8220;','rdquo' => '&#8221;','bdquo' => '&#8222;','dagger' => '&#8224;','Dagger' => '&#8225;','permil' => '&#8240;','lsaquo' => '&#8249;','rsaquo' => '&#8250;','euro' => '&#8364;','fnof' => '&#402;','Alpha' => '&#913;','Beta' => '&#914;','Gamma' => '&#915;','Delta' => '&#916;','Epsilon' => '&#917;','Zeta' => '&#918;','Eta' => '&#919;','Theta' => '&#920;','Iota' => '&#921;','Kappa' => '&#922;','Lambda' => '&#923;','Mu' => '&#924;','Nu' => '&#925;','Xi' => '&#926;','Omicron' => '&#927;','Pi' => '&#928;','Rho' => '&#929;','Sigma' => '&#931;','Tau' => '&#932;','Upsilon' => '&#933;','Phi' => '&#934;','Chi' => '&#935;','Psi' => '&#936;','Omega' => '&#937;','alpha' => '&#945;','beta' => '&#946;','gamma' => '&#947;','delta' => '&#948;','epsilon' => '&#949;','zeta' => '&#950;','eta' => '&#951;','theta' => '&#952;','iota' => '&#953;','kappa' => '&#954;','lambda' => '&#955;','mu' => '&#956;','nu' => '&#957;','xi' => '&#958;','omicron' => '&#959;','pi' => '&#960;','rho' => '&#961;','sigmaf' => '&#962;','sigma' => '&#963;','tau' => '&#964;','upsilon' => '&#965;','phi' => '&#966;','chi' => '&#967;','psi' => '&#968;','omega' => '&#969;','thetasym' => '&#977;','upsih' => '&#978;','piv' => '&#982;','bull' => '&#8226;','hellip' => '&#8230;','prime' => '&#8242;','Prime' => '&#8243;','oline' => '&#8254;','frasl' => '&#8260;','weierp' => '&#8472;','image' => '&#8465;','real' => '&#8476;','trade' => '&#8482;','alefsym' => '&#8501;','larr' => '&#8592;','uarr' => '&#8593;','rarr' => '&#8594;','darr' => '&#8595;','harr' => '&#8596;','crarr' => '&#8629;','lArr' => '&#8656;','uArr' => '&#8657;','rArr' => '&#8658;','dArr' => '&#8659;','hArr' => '&#8660;','forall' => '&#8704;','part' => '&#8706;','exist' => '&#8707;','empty' => '&#8709;','nabla' => '&#8711;','isin' => '&#8712;','notin' => '&#8713;','ni' => '&#8715;','prod' => '&#8719;','sum' => '&#8721;','minus' => '&#8722;','lowast' => '&#8727;','radic' => '&#8730;','prop' => '&#8733;','infin' => '&#8734;','ang' => '&#8736;','and' => '&#8743;','or' => '&#8744;','cap' => '&#8745;','cup' => '&#8746;','int' => '&#8747;','there4' => '&#8756;','sim' => '&#8764;','cong' => '&#8773;','asymp' => '&#8776;','ne' => '&#8800;','equiv' => '&#8801;','le' => '&#8804;','ge' => '&#8805;','sub' => '&#8834;','sup' => '&#8835;','nsub' => '&#8836;','sube' => '&#8838;','supe' => '&#8839;','oplus' => '&#8853;','otimes' => '&#8855;','perp' => '&#8869;','sdot' => '&#8901;','lceil' => '&#8968;','rceil' => '&#8969;','lfloor' => '&#8970;','rfloor' => '&#8971;','lang' => '&#9001;','rang' => '&#9002;','loz' => '&#9674;','spades' => '&#9824;','clubs' => '&#9827;','hearts' => '&#9829;','diams' => '&#9830;','nbsp' => '&#160;','iexcl' => '&#161;','cent' => '&#162;','pound' => '&#163;','curren' => '&#164;','yen' => '&#165;','brvbar' => '&#166;','sect' => '&#167;','uml' => '&#168;','copy' => '&#169;','ordf' => '&#170;','laquo' => '&#171;','not' => '&#172;','shy' => '&#173;','reg' => '&#174;','macr' => '&#175;','deg' => '&#176;','plusmn' => '&#177;','sup2' => '&#178;','sup3' => '&#179;','acute' => '&#180;','micro' => '&#181;','para' => '&#182;','middot' => '&#183;','cedil' => '&#184;','sup1' => '&#185;','ordm' => '&#186;','raquo' => '&#187;','frac14' => '&#188;','frac12' => '&#189;','frac34' => '&#190;','iquest' => '&#191;','Agrave' => '&#192;','Aacute' => '&#193;','Acirc' => '&#194;','Atilde' => '&#195;','Auml' => '&#196;','Aring' => '&#197;','AElig' => '&#198;','Ccedil' => '&#199;','Egrave' => '&#200;','Eacute' => '&#201;','Ecirc' => '&#202;','Euml' => '&#203;','Igrave' => '&#204;','Iacute' => '&#205;','Icirc' => '&#206;','Iuml' => '&#207;','ETH' => '&#208;','Ntilde' => '&#209;','Ograve' => '&#210;','Oacute' => '&#211;','Ocirc' => '&#212;','Otilde' => '&#213;','Ouml' => '&#214;','times' => '&#215;','Oslash' => '&#216;','Ugrave' => '&#217;','Uacute' => '&#218;','Ucirc' => '&#219;','Uuml' => '&#220;','Yacute' => '&#221;','THORN' => '&#222;','szlig' => '&#223;','agrave' => '&#224;','aacute' => '&#225;','acirc' => '&#226;','atilde' => '&#227;','auml' => '&#228;','aring' => '&#229;','aelig' => '&#230;','ccedil' => '&#231;','egrave' => '&#232;','eacute' => '&#233;','ecirc' => '&#234;','euml' => '&#235;','igrave' => '&#236;','iacute' => '&#237;','icirc' => '&#238;','iuml' => '&#239;','eth' => '&#240;','ntilde' => '&#241;','ograve' => '&#242;','oacute' => '&#243;','ocirc' => '&#244;','otilde' => '&#245;','ouml' => '&#246;','divide' => '&#247;','oslash' => '&#248;','ugrave' => '&#249;','uacute' => '&#250;','ucirc' => '&#251;','uuml' => '&#252;','yacute' => '&#253;','thorn' => '&#254;','yuml' => '&#255;');
		
		if (isset($table[$matches[1]])) return $table[$matches[1]];
	  	// else 
	  	return $destroy ? '' : $matches[0];
	}
	
    /**	----------------------------------------
    /**	Params
    /**	----------------------------------------*/
    
    function _param( $which = '', $type = 'all' )
    {
    	global $DB, $IN, $LOC, $TMPL;
    	
		/**	----------------------------------------
		/**	Which?
		/**	----------------------------------------*/
		
		if ( $which == '' ) return FALSE;
    	
		/**	----------------------------------------
		/**	Params set?
		/**	----------------------------------------*/
		
		if ( count( $this->params ) == 0 )
		{
			/**	----------------------------------------
			/**	Empty id?
			/**	----------------------------------------*/
			
			if ( ! $this->params_id = $IN->GBL('params_id') )
			{
				return FALSE;
			}
			
			/**	----------------------------------------
			/**	Select from DB
			/**	----------------------------------------*/
			
			$query	= $DB->query( "SELECT data FROM $this->params_tbl WHERE params_id = '".$DB->escape_str( $this->params_id )."'" );
			
			/**	----------------------------------------
			/**	Empty?
			/**	----------------------------------------*/
			
			if ( $query->num_rows == 0 ) return FALSE;
			
			/**	----------------------------------------
			/**	Unserialize
			/**	----------------------------------------*/
			
			$this->params			= unserialize( $query->row['data'] );
			$this->params['set']	= TRUE;
			
			/**	----------------------------------------
			/**	Delete
			/**	----------------------------------------*/
			
			$DB->query( "DELETE FROM $this->params_tbl WHERE entry_date < ".$DB->escape_str( ($LOC->now - 7200) )."" );
		}
		
		/**	----------------------------------------
		/**	Fetch from params array
		/**	----------------------------------------*/
		
		if ( isset( $this->params[$which] ) )
		{
			$return	= str_replace( "&#47;", "/", $this->params[$which] );
			
			return $return;
		}
		
		/**	----------------------------------------
		/**	Fetch TMPL
		/**	----------------------------------------*/
		
		if ( $TMPL AND $TMPL->fetch_param($which) )
		{
			return $TMPL->fetch_param($which);
		}
    	
		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
		
		return TRUE;
    }
    
    /**	End params */
	
	
    /**	----------------------------------------
    /**	Insert params
    /**	----------------------------------------*/
    
    function _insert_params( $params = array() )
    {
    	global $DB, $LOC;
    	
		/**	----------------------------------------
		/**	Empty?
		/**	----------------------------------------*/
    	
    	if ( count( $params ) > 0 )
    	{
    		$this->params	= $params;
    	}
    	elseif ( ! isset( $this->params ) OR count( $this->params ) == 0 )
    	{
    		return FALSE;
    	}
    	
		/**	----------------------------------------
		/**	Serialize
		/**	----------------------------------------*/
		
		$this->params	= serialize( $this->params );
    	
		/**	----------------------------------------
		/**	Delete excess when older than 2 hours
		/**	----------------------------------------*/
			
		$DB->query( "DELETE FROM $this->params_tbl WHERE entry_date < ".$DB->escape_str( ($LOC->now - 7200) )."" );
    	
		/**	----------------------------------------
		/**	Insert
		/**	----------------------------------------*/
		
		$DB->query( $DB->insert_string( $this->params_tbl, array( 'entry_date' => $LOC->now, 'data' => $this->params ) ) );
    	
		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
		
		return $DB->insert_id;
    }
    
    /**	End insert params */
    
    
    /**	----------------------------------------
    /**	Upload files
    /**	----------------------------------------*/
    
    function _upload_files ( $errors_only = FALSE )
    {
        global $DB, $IN, $LANG, $LOC, $OUT, $SESS;
        
        $LANG->fetch_language_file('upload');
        
		/**	----------------------------------------
		/**	Invoke upload class
		/**	----------------------------------------*/
		
		if ( ! class_exists( 'Upload' ) )
		{
			require PATH_CORE.'core.upload'.EXT;
			
			$this->UP = new Upload();
		}            
        
		/**	----------------------------------------
        /**	Handle files from submission
		/**	----------------------------------------
		/*	Note that if you have trouble getting
		/*	files to submit, if the FILES array is
		/*	empty, make sure that you are not
		/*	submitting the gallery upload form inside
		/*	of another form. If the forms are nested,
		/*	the FILES array can be wiped out.
		/**	----------------------------------------*/
        
        if ( ! isset($_FILES) OR count( $_FILES ) == 0 OR count( $_FILES ) > $this->upload_limit )
        {
        	return FALSE;
        }
        
        $full	= FALSE;
        
        foreach ( $_FILES as $key => $val )
        {
        	if ( $val['name'] != '' )
        	{
        		$full	= TRUE;
        	}
        }
        
        if ( ! $full )
        {
        	return FALSE;
        }
        
		/**	----------------------------------------
		/**	Check destination
		/**	----------------------------------------*/
		
		$query	= $DB->query( "SELECT * FROM exp_upload_prefs WHERE name = '".$DB->escape_str($this->_param('file_upload'))."'" );
		
		if ( $query->num_rows == 0 )
		{
			return $OUT->show_user_error( 'general', $LANG->line( 'upload_destination_not_exists' ) );
		}
		else
		{
			$this->upload	= $query->row;
		}
        
		/**	----------------------------------------
		/**	Check path
		/**	----------------------------------------*/
       
        if ( $this->UP->set_upload_path( $this->upload['server_path'] ) !== TRUE )
        {
        	$this->upload['server_path']	= str_replace( "..", ".", $this->upload['server_path'] );
        	
			if ( $this->UP->set_upload_path( $this->upload['server_path'] ) !== TRUE )
			{
				return $OUT->show_user_error( 'general', $LANG->line( $this->UP->error_msg ) );
			}
        }
        
		/**	----------------------------------------
		/**	Only checking errors?
		/**	----------------------------------------*/
		
		if ( $errors_only ) return;
        
		/**	----------------------------------------
		/**	Set attributes
		/**	----------------------------------------*/
        
        $this->UP->set_max_width($this->upload['max_width']);
        $this->UP->set_max_height($this->upload['max_height']);
        $this->UP->set_max_filesize($this->upload['max_size']);
        $this->UP->set_allowed_types( ($SESS->userdata['group_id'] == 1) ? 'all' : $this->upload['allowed_types']);
        
		/**	----------------------------------------
		/**	Loop
		/**	----------------------------------------*/
		
		$data	= array();
        
        foreach ( $_FILES as $key => $val )
        {
        	if ( preg_match( "/file(\d+)/s", $key, $match ) )
        	{
        		if ( $_FILES[ $match['0'] ]['name'] == '' ) continue;
        		
        		$n	= ( $match['1'] != '' ) ? $match['1']: 0;
        	
				/**	----------------------------------------
				/**	Set data
				/**	----------------------------------------*/
			
				$data[$n]['userfile']	= $val;
			}
		}
        
		/**	----------------------------------------
		/**	Loop and insert
		/**	----------------------------------------*/
		
		foreach ( $data as $key => $val )
		{
			$this->_upload_file( $val );
		}
    }
    
    /**	End upload files */
    
    
    /**	----------------------------------------
    /**	Upload file
    /**	----------------------------------------*/
    
    function _upload_file ( $val )
    {
        global $IN, $DSP, $DB, $LANG, $LOC, $OUT, $SESS;
        
        $LANG->fetch_language_file('upload');
		
		/**	----------------------------------------
        /**	Unset some globals
		/**	----------------------------------------
		/*	If we leave this set through every loop,
		/*	all successive uploads will fail after
		/*	the first on account of Paul and his
		/*	silly concatenation.
		/**	----------------------------------------*/
		
		$this->UP->new_name	= '';
		
		/**	----------------------------------------
        /**	Force the userfile in post
		/**	----------------------------------------*/
		
		$_FILES['userfile']	= $val['userfile'];

		/**	----------------------------------------
        /**	Perform the upload
		/**	----------------------------------------*/
	
		if ( ! $this->UP->upload_file())
		{
        	return $OUT->show_user_error( 'general', $LANG->line( $this->UP->error_msg ) );
		}
		
		$file_name = $this->UP->file_name;
		
		if ($this->UP->file_exists == TRUE)
		{        
			$file_name = $this->_rename_file($this->UP->upload_path, $this->UP->file_name);
			  
			if ( ! $this->UP->file_overwrite($this->UP->file_name, $file_name))
			{
				// return $this->_fetch_error( $LANG->line('file_overwrite'), $IN->GBL('template') );
			}
		}

		/**	----------------------------------------
        /**	Set filename
		/**	----------------------------------------*/
        
        $x = explode(".", $file_name);
		$extension	= '.'.end($x);
		$name		= str_replace($extension, '', $file_name);

		/**	----------------------------------------
        /**	Log in DB
		/**	----------------------------------------*/
		
		$data	= array(
						'entry_id'		=> $this->entry_id,
						'pref_id'		=> $this->upload['id'],
						'server_path'	=> $this->UP->upload_path,
						'filename'		=> $name,
						'extension'		=> $extension,
						'filesize'		=> $this->UP->file_size,
						'entry_date'	=> $LOC->now
						);
						
		$DB->query( $DB->insert_string( 'exp_freeform_attachments', $data ) );
		
		$this->attachments[ $DB->insert_id ]['filepath']	= $this->UP->upload_path.$file_name;
		$this->attachments[ $DB->insert_id ]['filename']	= $file_name;
    }
    
    /**	End upload file */
  	
  	
	/**	----------------------------------------
    /**	Auto-Rename File
	/**	----------------------------------------
    /*	This function determines if a file
    /*	exists. If so, it'll append a number to
    /*	the filename and call itself again. It
    /*	does this as many times as necessary
    /*	until a filename is clear.
	/**	----------------------------------------*/
    
	function _rename_file($path, $name, $i = 0)
	{
		if (file_exists($path.$name))
		{	
			$xy = explode(".", $name);
			$ext = end($xy);
			
			$name = str_replace('.'.$ext, '', $name);
					
			if (eregi($i."$", $name))
			{
				$name = substr($name, 0, -strlen($i));
			}	
			
			$i = $i+1;

			$name .= $i.'.'.$ext;

			return $this->_rename_file($path, $name, $i);
		}
		
		return $name;
	}
	
	/**	End rename file     */
}

/**	End class */

?>