<?php

//--------------------------------------------
//   Edit Menu Extension
//   using the following hooks:
//   - show_full_control_panel_end
//   build: 20080704
//   author: Elwin Zuiderveld (aka Cocoaholic)
//--------------------------------------------

if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

class Ez_edit_menu {
	
	var $dev_mode 		= 0; // 1
	
	// extension vars
	var $settings 		= array();
	var $name 			= 'Edit Menu';
	var $class_name		= 'Ez_edit_menu';
	var $version 		= '1.0.2';
	var $description 	= 'Adds a weblog menu to the Edit tab';
	var $settings_exist = 'n';
	var $docs_url 		= '';
	
	/**
	 * Constructor
	 *
	 * @access public
	 * @param array
	 * @return void
	 */
	function Ez_edit_menu($settings='')
	{
		$this->settings = $settings;
	}
	// END
	
	/**
	 * Settings
	 *
	 * @access public
	 * @return array
	 */
	function settings()
	{
		$settings = array();
		
		return $settings;
	}
	// END
	
	/**
	 * Activate Extension
	 *
	 * Installs the extension
	 *
	 * @access	public
	 * @return	void
	 */
	function activate_extension()
	{
		global $DB;
		
		$DB->query($DB->insert_string('exp_extensions',
				array(
				'extension_id'	=> '',
				'class'			=> $this->class_name,
				'method'		=> "add_menu",
				'hook'			=> "show_full_control_panel_end",
				'settings'		=> '',
				'priority'		=> 8,
				'version'		=> $this->version,
				'enabled'		=> "y"
				)
			)
		);
		
	}
	// END
	
	/**
	 * Update Extension
	 *
	 * Updates the extension
	 *
	 * @access	public
	 * @param	string
	 * @return	void
	 */
	function update_extension($current='')
	{
		global $DB;
		
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
		
		if ($current < '1.0')
		{
			// Update to 1.0
		}
		
		$data = array('version' => $this->version, 'priority' => 8);
		$DB->query($DB->update_string('exp_extensions', $data, "class = '".$this->class_name."'"));
	}
	// END
	
	/**
	 * Disable Extension
	 *
	 * Uninstalls the extension
	 *
	 * @access	public
	 * @return	void
	 */
	function disable_extension()
	{
		global $DB;
		if ($this->dev_mode) $DB->query("DELETE FROM exp_extensions WHERE class = '".$DB->escape_str($this->class_name)."'");
	}
	// END
	
	/**
	 * Add Menu
	 *
	 * Adds a weblog menu to the Edit tab
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function add_menu($out='')
	{
		global $EXT, $SESS, $DSP, $LANG;
		
		// This variable will return whatever the last extension returned to this hook
		if($EXT->last_call !== false)
		{
			$out = $EXT->last_call;
		}
		
		// create menu list
		if (sizeof($SESS->userdata['assigned_sites']) > 0)
		{
			$menu = '<ul id="publishdropmenu">';
			
			foreach($SESS->userdata['assigned_weblogs'] as $weblog_id => $weblog_label)
			{
				$menu .= "<li class='publishdropmenuinner'><a href='".BASE.AMP."C=edit".AMP."weblog_id=".$weblog_id."' title='".$DSP->html_attribute_prep($weblog_label)."' onclick='location.href=this.href;'>".$DSP->html_attribute_prep($weblog_label)."</a></li>";
			}
			
			$menu .= '</ul>';
		}
		
		$out = str_replace($LANG->line('edit')."</div>", $LANG->line('edit')."</div>".$menu, $out);
		$out = str_replace($LANG->line('edit')."\n</div>", $LANG->line('edit')."</div>".$menu, $out);
		
		return $out;
	}
	// END
}
?>