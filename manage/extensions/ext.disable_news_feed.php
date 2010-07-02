<?php

//------------------------------------
// Disable pMachine News Feed Extension
// using 'member_member_register' hook
// 'mod.member_register.php' (EE 1.5.1)
// using 'cp_members_member_create' hook
// 'cp.members.php' (EE 1.5.1)
//------------------------------------

if ( ! defined('EXT'))
{
	exit('Invalid file request');
}

class Disable_News_Feed
{
	var $settings		= array();
	
	var $name			= 'Disable pMachine News Feed';
	var $version		= '0.5';
	var $description	= 'Disables the pMachine News Feed for new members';
	var $settings_exist = 'n';
	// var $docs_url		= 'http://docs.elwinzuiderveld.nl/';
		
	// -------------------------------
	//	 Constructor - Extensions use this for settings
	// -------------------------------
	
	function Disable_News_Feed($settings='')
	{
		$this->settings = $settings;
	}
	// END
		
	// --------------------------------
	//	Settings
	// --------------------------------	 
	
	function settings()
	{
		return $settings;
	}
	// END
	
	// --------------------------------
	//	Activate Extension
	// --------------------------------
	
	function activate_extension()
	{
		global $DB;
		
		$DB->query($DB->insert_string('exp_extensions',
									  array('extension_id'	=> '',
											'class'			=> "Disable_News_Feed",
											'method'		=> "disable_pmachine_news_feed",
											'hook'			=> "member_member_register",
											'priority'		=> 10,
											'version'		=> $this->version,
											'enabled'		=> "y")
									 )
				   );
				
		$DB->query($DB->insert_string('exp_extensions',
									  array('extension_id'	=> '',
											'class'			=> "Disable_News_Feed",
											'method'		=> "cp_disable_pmachine_news_feed",
											'hook'			=> "cp_members_member_create",
											'priority'		=> 10,
											'version'		=> $this->version,
											'enabled'		=> "y")
									 )
				   );
		
	}
	// END
	
	// --------------------------------
	//	Update Extension
	// --------------------------------	 
	
	function update_extension($current='')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		if ($current > '1.0')
		{
			// Update to next version
		}
		
		$DB->query("UPDATE exp_extensions 
					SET version = '".$DB->escape_str($this->version)."' 
					WHERE class = 'Disable_News_Feed'");
	}
	// END
	
	// --------------------------------
	//	Disable Extension
	// --------------------------------
	
	function disable_extension()
	{
		global $DB;
		
		$DB->query("DELETE FROM exp_extensions 
					WHERE class = 'Disable_News_Feed'");
	}
	// END
	
	// START Custom functions
	function disable_pmachine_news_feed($data)
	{
		global $DB;
		
		$query = $DB->query("SELECT member_id FROM exp_members WHERE username = '".$data['username']."'");
		$member_id = $query->row['member_id'];
		
		$m_data = array('pmachine_news_feed' => 'n');
		$DB->query($DB->update_string('exp_member_homepage', $m_data, "member_id = '$member_id'"));
	}
	
	function cp_disable_pmachine_news_feed($member_id)
	{
		global $DB;
		
		$m_data = array('pmachine_news_feed' => 'n');
		$DB->query($DB->update_string('exp_member_homepage', $m_data, "member_id = '$member_id'"));
	}
	// END
	
}
// END Class

?>