<?php

/***************************************************************************************************
****  EDIT REMEMBER  *******************************************************************************
        Remembers past edit views
            
        INFO
            Developed by: Mark Huot
            Date: 2006-09-16
..................................................................................................*/

class edit_remember {
	var $settings		= array();
	
	var $name			= 'Edit Remember';
	var $version		= '1.1.0';
	var $description	= 'Remembers past edit views';
	var $settings_exist	= 'n';
	var $docs_url		= 'http://docs.markhuot.com';
	
	//
	// Constructor
	//
	function edit_remember($settings='')
	{
		$this->settings = $settings;
	}
	
	
	//
	// Add to Database
	//
	function activate_extension ()
	{
		global $DB;
		
		// -- Add edit_field_groups
		$DB->query(
			$DB->insert_string('exp_extensions',
				array(
						'extension_id' => '',
						'class'        => get_class($this),
						'method'       => 'modify_edit_post',
						'hook'         => 'edit_entries_start',
						'settings'     => '',
						'priority'     => 1,
						'version'      => $this->version,
						'enabled'      => 'y'
				)
			)
		);
		
		// -- Add edit_statuses
		$DB->query(
			$DB->insert_string('exp_extensions',
				array(
						'extension_id' => '',
						'class'        => get_class($this),
						'method'       => 'edit_statuses',
						'hook'         => 'edit_entries_search_form',
						'settings'     => '',
						'priority'     => 1,
						'version'      => $this->version,
						'enabled'      => 'y'
				)
			)
		);
		
	}
	
	//
	// Change Settings
	//
	function settings()
	{
		$settings = array();
		
		// Complex:
		// [variable_name] => array(type, values, default value)
		// variable_name => short name for setting and used as the key for language file variable
		// type:  t - textarea, r - radio buttons, s - select, ms - multiselect, f - function calls
		// values:  can be array (r, s, ms), string (t), function name (f)
		// default:  name of array member, string, nothing
		//
		// Simple:
		// [variable_name] => 'Butter'
		// Text input, with 'Butter' as the default.

		return $settings;
	}
    
    //
    // Update Extension (by FTP)
    //
    function update_extension($current = '')
    {
        global $DB;
        
        if ($current == '' OR $current == $this->version)
        {
            return FALSE;
        }
        if ($current < '1.0.7' )
		{
			$DB->query("DELETE FROM exp_extensions WHERE class='".get_class($this)."'");
			$this->activate_extension();
		}
        
        $DB->query("UPDATE exp_extensions SET version = '".$DB->escape_str($this->version)."' WHERE class = '".get_class($this)."'");
    }
    
	/** ---------------------------------
	/*  Disables Extension and Removes from exp_extensions
	/* ---------------------------------*/
	
	function disable_extension()
	{
		global $DB;
		
		$DB->query("DELETE FROM exp_extensions WHERE class = '".$DB->escape_str(get_class($this))."'");
	}
	/* END */
	
    
    //
    // Modify Entry Id
    //
    function modify_edit_post()
	{
		global $DB, $EXT;
		
		if($EXT->last_call !== false)
		{
			$out = $EXT->last_call;
		}
		
		if(isset($_GET['C']) && $_GET['C'] == "edit")
		{
			if(session_id() == "")
			{
				@session_start();
			}
			
			if(isset($_POST) && count($_POST) > 0)
			{
				if(isset($_POST['search_in']) && $_POST['search_in'] != 'comments')
				{
					$_SESSION['edit_remember'] = $_POST;
				}
				else
				{
					unset($_SESSION['edit_remember']);
				}
			}
			if(isset($_SESSION['edit_remember']))
			{
				$_POST = $_SESSION['edit_remember'];
			}
			
			foreach($_POST as $k=>$v)
			{
				if(isset($_GET[$k]))
				{
					$_POST[$k] = $_GET[$k];
				}
				else if($v == 'null' || $v == '')
				{
					unset($_POST[$k]);
				}
			}
		}
	}
	
	//
	//	Add all statuses to the list
	//
	function edit_statuses( $out )
	{
		global $DB, $DSP, $EXT;
		
		if($EXT->last_call !== false)
		{
			$out = $EXT->last_call;
		}
		
		if(preg_match("/<select\s*name=.status.*?>(.*?)<\/select/s", $out, $matches))
		{
			$new_options = $DSP->input_select_option("", "Filter by Status");
			$new_options.= $DSP->input_select_option("", "All");
			$statuses = $DB->query("SELECT status FROM exp_statuses ORDER BY group_id ASC, status_order ASC");
			foreach($statuses->result as $s)
			{
				if($s['status'] == 'open' || $s['status'] == 'closed') $s['status'] = strtoupper(substr($s['status'], 0, 1)).substr($s['status'], 1);
				$new_options.= $DSP->input_select_option($s['status'], $s['status'], (isset($_POST['status']) && $_POST['status']==$s['status']));
			}
			$out = str_replace($matches[1], $new_options, $out);
		}
		
		return $out;
	}
}

?>