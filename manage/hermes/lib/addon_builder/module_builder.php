<?php if ( ! defined('EXT')) exit('No direct script access allowed');
 
 /**
 * Hermes - Expansion
 *
 * @package		Hermes:Expansion
 * @author		Solspace DevTeam
 * @copyright	Copyright (c) 2008-2009, Solspace, Inc.
 * @link		http://solspace.com/docs/
 * @version		1.4.0.b
 * @filesource 	./system/hermes/
 * 
 */
 
 /**
 * Module Builder
 *
 * A class that helps with the building of ExpressionEngine Modules by allowing Hermes enabled modules
 * to be extensions of this class and thus gain all of the abilities of it and its parents.
 *
 * @package 	Hermes:Expansion
 * @subpackage	Add-On Builder
 * @category	Modules
 * @author		Paul Burdick <paul@solspace.com>
 * @link		http://solspace.com/docs/
 * @filesource 	./system/hermes/addon_builder/module_builder.php
 */

require_once PATH.'hermes/lib/addon_builder/addon_builder.php';

class Module_builder extends Addon_builder {

	var $module_actions	= array();
	var $hooks			= array();
	
	var $base			= '';
    
    // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	null
	 */
    
	function Module_builder($name='')
	{
		global $LANG, $PREFS, $DB;
		
		parent::Addon_builder($name);

		/** --------------------------------------------
		/**  Default CP Variables
		/** --------------------------------------------*/

		if (REQ == 'CP')
		{
			$this->base							= BASE.'&C=modules&M='.$this->lower_name;
			
			$this->cached_vars['page_crumb']	= '';
			$this->cached_vars['page_title']	= '';
			$this->cached_vars['base_uri']		= BASE.'&C=modules&M='.$this->lower_name;
			
			$this->cached_vars['onload_events']  = '';
			
			/** --------------------------------------------
			/**  Default Crumbs for Module
			/** --------------------------------------------*/
			
			$this->add_crumb($this->EE->config->ini('site_name'), BASE);
			
			$this->cached_vars['module_menu'] = array();
			$this->cached_vars['module_menu_highlight'] = '';
				
			$this->add_crumbs(array(
									 array($this->EE->lang->line('modules'),  BASE.AMP.'C=modules'),
									 array($this->EE->lang->line($this->lower_name.'_module_name'), $this->cached_vars['base_uri'])
									 )
							   );
		}
	}
	/* END Module_builder() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Module Installer
	 *
	 * @access	public
	 * @return	bool
	 */

    function default_module_install()
    {
        global $DB, $PREFS;
        
        /** --------------------------------------------
        /**  Our Install Queries
        /** --------------------------------------------*/
        
        if (file_exists($this->addon_path.strtolower($this->lower_name).'.sql'))
        {  
			$sql = preg_split("/;;\s*(\n+|$)/", file_get_contents($this->addon_path.strtolower($this->lower_name).'.sql'), -1, PREG_SPLIT_NO_EMPTY);
			
			foreach($sql as $i => $query)
			{
				$sql[$i] = trim($query);
			}
		}
		
		/** --------------------------------------------
        /**  Module Install
        /** --------------------------------------------*/
		
        foreach ($sql as $query)
        {
            $this->EE->db->query($query);
        }
        
        $this->update_module_actions();
       	$this->update_extension_hooks();
        
        return TRUE;
    }
	/* END default_module_install() */
    
	// --------------------------------------------------------------------

	/**
	 * Module Uninstaller
	 *
	 * @access	public
	 * @return	bool
	 */

    function default_module_uninstall()
    {
        global $DB;
        
        $query = $this->EE->db->query("SELECT module_id FROM exp_modules WHERE module_name = '".$this->EE->db->escape_str($this->class_name)."'");
        
        if (file_exists($this->addon_path.$this->lower_name.'.sql'))
        {
        	if (preg_match_all("/CREATE\s+TABLE\s+IF\s+NOT\s+EXISTS\s+`([^`]+)`/", file_get_contents($this->addon_path.$this->lower_name.'.sql'), $matches))
			{
				foreach($matches[1] as $table)
				{
					$sql[] = "DROP TABLE IF EXISTS `".$this->EE->db->escape_str($table)."`";
				}
			}
		}

		$sql[] = "DELETE FROM exp_module_member_groups WHERE module_id = '".$query->row['module_id']."'";
        $sql[] = "DELETE FROM exp_modules WHERE module_name = '".$this->EE->db->escape_str($this->class_name)."'";
        $sql[] = "DELETE FROM exp_actions WHERE class = '".$this->EE->db->escape_str($this->class_name)."'";
    
        foreach ($sql as $query)
        {
            $this->EE->db->query($query);
        }
        
        $this->remove_extension_hooks();

        return TRUE;
    }
    /* END default_module_uninstall() */
    
	// --------------------------------------------------------------------

	/**
	 * Module Update
	 *
	 * @access	public
	 * @return	bool
	 */

    function default_module_update()
    {
        global $DB;
        
        $this->update_module_actions();
    	$this->update_extension_hooks();

        return TRUE;
    }
    /* END default_module_update() */

	    
	// --------------------------------------------------------------------

	/**
	 * Module Actions
	 *
	 * Insures that we have all of the correct actions in the database for this module
	 *
	 * @access	public
	 * @return	array
	 */

	function update_module_actions()
    {
    	global $DB;
    	
    	$exists	= array();
    	
    	$query	= $this->EE->db->query( "SELECT method FROM exp_actions 
    						   WHERE class = '".$this->EE->db->escape_str($this->class_name)."'" );
    	
    	foreach ( $query->result as $row )
    	{
    		$exists[] = $row['method'];
    	}
    	
    	/** --------------------------------------------
        /**  Actions of Module Actions - Bug Fix
        /** --------------------------------------------*/
        
        $actions = (is_array($this->actions) && sizeof($this->actions) > 0) ? $this->actions : $this->module_actions;
    	
    	/** --------------------------------------------
        /**  Add Missing Actions
        /** --------------------------------------------*/
    	
    	foreach(array_diff($actions, $exists) as $method)
    	{
    		$this->EE->db->query($this->EE->db->insert_string('exp_actions', array(	'class'		=> $this->class_name,
    															'method'	=> $method)));
    	}
    	
    	/** --------------------------------------------
        /**  Delete No Longer Existing Actions
        /** --------------------------------------------*/
    	
    	foreach(array_diff($exists, $actions) as $method)
    	{
    		$this->EE->db->query("DELETE FROM exp_actions 
    					WHERE class = '".$this->EE->db->escape_str($this->class_name)."' 
    					AND method = '".$this->EE->db->escape_str($method)."'");
    	}
    }
    /* END update_module_actions() */
    
	
	// --------------------------------------------------------------------

	/**
	 * Install/Update Our Extension for Module
	 *
	 * Tells ExpressionEngine what extension hooks we wish to use for this module.  If an extension
	 * is part of a module, then it is the module's class name with the '_extension' suffix added on 
	 * to it.  Stand-alone extensions are just the class name.
	 *
	 * @access	public
	 * @return	null
	 */

	function update_extension_hooks()
    {
    	global $DB;
    	
    	if ( ! is_array($this->hooks) OR sizeof($this->hooks) == 0)
    	{
    		return TRUE;
    	}
    	
    	/** --------------------------------------------
        /**  Determine Existing Methods
        /** --------------------------------------------*/
    	
    	$exists	= array();
    	
    	$query	= $this->EE->db->query( "SELECT method FROM exp_extensions 
    						   WHERE class = '".$this->EE->db->escape_str($this->class_name.'_extension')."'");
    	
    	foreach ( $query->result as $row )
    	{
    		$exists[] = $row['method'];
    	}
    	
    	/** --------------------------------------------
        /**  Find Missing and Insert
        /** --------------------------------------------*/
        
        $current_methods = array();
    	
    	foreach($this->hooks as $data)
    	{
    		$current_methods[] = $data['method'];
    	
    		if ( ! in_array($data['method'], $exists))
    		{
				$this->EE->db->query($this->EE->db->insert_string('exp_extensions', $data));
    		}
    		else
    		{
    			unset($data['settings']);
    			
    			$this->EE->db->query( $this->EE->db->update_string( 'exp_extensions', 
												$data, 
												array(	'class' => $data['class'], 
														'method' => $data['method'])));
    		
    		}
    	}
    	
    	/** --------------------------------------------
        /**  Remove Old Hooks
        /** --------------------------------------------*/
    	
    	foreach(array_diff($exists, $current_methods) as $method)
    	{
    		$this->EE->db->query("DELETE FROM exp_extensions 
    					WHERE class = '".$this->EE->db->escape_str($this->class_name.'_extension')."' 
    					AND method = '".$this->EE->db->escape_str($method)."'");
    	}
    }
    /* END update_extension_hooks() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Remove Extension Hooks
	 *
	 * Removes all of the extension hooks that will be called for this module
	 *
	 * @access	public
	 * @return	null
	 */

	function remove_extension_hooks()
    {
    	global $DB, $EXT;
    	
    	$this->EE->db->query("DELETE FROM exp_extensions 
    				WHERE class = '".$this->EE->db->escape_str($this->class_name)."'");
    				
    	$this->EE->db->query("DELETE FROM exp_extensions 
    				WHERE class = '".$this->EE->db->escape_str($this->class_name.'_extension')."'");
    				
    	/** --------------------------------------------
        /**  Remove from $this->EE->extensions->extensions array
        /** --------------------------------------------*/
        
        foreach($this->EE->extensions->extensions as $hook => $calls)
        {
        	foreach($calls as $priority => $class_data)
        	{
        		foreach($class_data as $class => $data)
        		{
					if ($class == $this->class_name OR $class == $this->class_name.'_extension')
					{
						unset($this->EE->extensions->extensions[$hook][$priority][$class]);
					}
				}
        	}
        }
    }
    /* END remove_extension_hooks() */
    	
	
	// --------------------------------------------------------------------
		
	/**
	 * Equalize Menu Text
	 *
	 * Goes through an array of Main Menu links and text so that we can equalize the width of the tabs.
	 * 
	 * @access	public
	 * @param	array
	 * @return	array
	 */
	
	function equalize_menu($array = array())
	{
		$length = 1;
		
		foreach($array as $key => $data)
		{
			$length = (strlen(strip_tags($data['title'])) > $length) ? strlen(strip_tags($data['title'])) : $length;
		}
		
		foreach ($array as $key => $data)
		{
			$i = ceil(($length - strlen(strip_tags($data['title'])))/2);
						
			$array[$key]['title'] = str_repeat("&nbsp;", $i).$data['title'].str_repeat("&nbsp;", $i);
		}
		
		return $array;
	}
	/* END equalize_menu() */
	
	
	// --------------------------------------------------------------------

	/**
	 *	Module Specific No Results Parsing
	 *
	 *	Looks for (your_module)_no_results and uses that, otherwise it returns the default no_results conditional
	 *
	 *	@access		public
	 *	@return		string
	 */

    function no_results()
    {
		global $TMPL;
		
		if ( preg_match( "/".LD."if ".preg_quote($this->lower_name)."_no_results".RD."(.*?)".LD.SLASH."if".RD."/s", $TMPL->tagdata, $match ) )
		{
			return $match[1];
		}
		else
		{
			return $TMPL->no_results();
		}
    }
    /* END no_results() */
    
}
/* END Module_builder Class */

?>