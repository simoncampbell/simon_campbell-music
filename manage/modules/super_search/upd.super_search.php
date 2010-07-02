<?php if ( ! defined('EXT')) exit('No direct script access allowed');

/**
 * Super Search
 *
 * An ExpressionEngine module that enables better search functionality.
 *
 * @package		Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @copyright	Copyright (c) 2009-2010, Solspace, Inc.
 * @link		http://www.solspace.com/docs/
 * @version		1.1.0.b2
 * @location 	./system/modules/
 * 
 */
 
/**
 * Super Search Module Class - Updater
 *
 * Installs, deinstalls, updates
 *
 * @package		Solspace:Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @see			http://www.solspace.com/docs/
 * @location 	./system/modules/super_search/upd.super_search.php
 */ 

require_once PATH.'hermes/lib/addon_builder/module_builder.php';

class Super_search_updater extends Module_builder {
    
    var $actions			= array();
    var $hooks				= array();
    
	// --------------------------------------------------------------------

	/**
	 * Contructor
	 
	 * @access	public
	 * @return	null
	 */
    
	function Super_search_updater()
    {
    	global $DB;
    	
    	parent::Module_builder('super_search');
    	
		/** --------------------------------------------
        /**  Module Actions
        /** --------------------------------------------*/
        
        $this->module_actions = explode('|', SUPER_SEARCH_ACTIONS);
    	
		/** --------------------------------------------
        /**  Extension Hooks
        /** --------------------------------------------*/
        
        $this->default_settings = array();
        
        $default = array(	
						'class'        => $this->class_name.'_extension',
						'settings'     => '', 								// NEVER!
						'priority'     => 10,
						'version'      => SUPER_SEARCH_VERSION,
						'enabled'      => 'y'
					);
        
        $this->hooks = array(
							'refresh_cache_from_template'		=> array_merge(
								$default,
								array(
										'method'	=> 'refresh_cache_from_template',
										'hook'		=> 'edit_template_end'
									  )
								),
							'refresh_cache_from_weblog'	=> array_merge(
								$default,
								array(
										'method'	=> 'refresh_cache_from_weblog',
										'hook'		=> 'submit_new_entry_end'
									  )
								),
							'refresh_cache_from_category'	=> array_merge(
								$default,
								array(
										'method'	=> 'refresh_cache_from_category',
										'hook'		=> 'publish_admin_update_category'
									  )
								),
							'super_search_alter_search_check_group'	=> array_merge(
								$default,
								array(
										'method'	=> 'super_search_alter_search_check_group',
										'hook'		=> 'super_search_alter_search',
										'priority'	=> 5
									  )
								),
							'super_search_alter_search_multiselect'	=> array_merge(
								$default,
								array(
										'method'	=> 'super_search_alter_search_multiselect',
										'hook'		=> 'super_search_alter_search',
										'priority'	=> 6
									  )
								),
							'super_search_alter_search_playa'	=> array_merge(
								$default,
								array(
										'method'	=> 'super_search_alter_search_playa',
										'hook'		=> 'super_search_alter_search',
										'priority'	=> 7
									  )
								),
							'super_search_alter_search_relationship'	=> array_merge(
								$default,
								array(
										'method'	=> 'super_search_alter_search_relationship',
										'hook'		=> 'super_search_alter_search',
										'priority'	=> 4
									  )
								),
							'super_search_do_search_and_array_playa'	=> array_merge(
								$default,
								array(
										'method'	=> 'super_search_do_search_and_array_playa',
										'hook'		=> 'super_search_do_search_and_array',
										'priority'	=> 5
									  )
								),
						);
    }
    
    /* END*/
	
	// --------------------------------------------------------------------

	/**
	 * Module Installer
	 
	 * @access	public
	 * @return	bool
	 */

    function install()
    {
        global $DB, $PREFS;
        
        // Already installed, let's not install again.
        if ($this->database_version() !== FALSE)
        {
        	return FALSE;
        }
        
        /** --------------------------------------------
        /**  Our Default Install
        /** --------------------------------------------*/
        
        if ($this->default_module_install() == FALSE)
        {
        	return FALSE;
        }
        
        /** --------------------------------------------
        /**  Set default cache prefs
        /** --------------------------------------------*/
        
        $this->data->set_default_cache_prefs();
		
		/** --------------------------------------------
        /**  Module Install
        /** --------------------------------------------*/
        
        $sql[] = $DB->insert_string('exp_modules', array(	'module_name'		=> $this->class_name,
        													'module_version'	=> SUPER_SEARCH_VERSION,
        													'has_cp_backend'	=> 'y'));
		
        foreach ($sql as $query)
        {
            $DB->query($query);
        }
        
        return TRUE;
    }
	/* END install() */
    
	// --------------------------------------------------------------------

	/**
	 * Module Uninstaller
	 
	 * @access	public
	 * @return	bool
	 */

    function uninstall()
    {
        global $DB;   
        
        // Cannot uninstall what does not exist, right?
        if ($this->database_version() === FALSE)
        {
        	return FALSE;
        }
        
		/** --------------------------------------------
        /**  Default Module Uninstall
        /** --------------------------------------------*/
        
        if ($this->default_module_uninstall() == FALSE)
        {
        	return FALSE;
        }
        
        return TRUE;
    }
    /* END */


	// --------------------------------------------------------------------

	/**
	 * Module Updater
	 
	 * @access	public
	 * @return	bool
	 */
    
    function update()
    {
    	global $DB;
    	
    	/** --------------------------------------------
        /**  Default Module Update
        /** --------------------------------------------*/
    
    	$this->default_module_update();
        
        /** --------------------------------------------
        /**  Do DB work
        /** --------------------------------------------*/
        
        if ( ! file_exists($this->addon_path.strtolower($this->lower_name).'.sql'))
        {
        	return FALSE;
        }
        
 		$sql = preg_split("/;;\s*(\n+|$)/", file_get_contents($this->addon_path.strtolower($this->lower_name).'.sql'), -1, PREG_SPLIT_NO_EMPTY);
        
		if (sizeof($sql) == 0)
		{
			return FALSE;
		}
		
		foreach($sql as $i => $query)
		{
			$sql[$i] = trim($query);
		}
        
        /** --------------------------------------------
        /**  Super Search History needs a query field
        /** --------------------------------------------*/
        
        if ( $this->column_exists( 'query', 'exp_super_search_history' ) === FALSE )
        {
        	$sql[]	= "ALTER TABLE exp_super_search_history ADD `query` mediumtext NOT NULL";
        }
        
        /** --------------------------------------------
        /**  Super Search History needs a query field
        /** --------------------------------------------*/
        
        if ( $this->column_exists( 'hash', 'exp_super_search_history' ) === FALSE )
        {
        	$sql[]	= "ALTER TABLE exp_super_search_history ADD `hash` varchar(32) NOT NULL";
        }
        
        /** --------------------------------------------
        /**  Super Search History needs a unique key for some insert magic
        /** --------------------------------------------*/
        
        if ( $DB->table_exists('exp_super_search_history') === TRUE )
        {
        	$query	= $DB->query( "SHOW indexes FROM exp_super_search_history WHERE Key_name = 'search_key'" );
        	
        	if ( $query->num_rows == 0 )
        	{
        		$sql[]	= "ALTER TABLE `exp_super_search_history` ADD UNIQUE KEY `search_key` (`member_id`,`cookie_id`,`site_id`,`search_name`,`saved`)";
        	}
        }
		
		/** --------------------------------------------
        /**  Run module SQL - dependent on CREATE TABLE IF NOT EXISTS syntax
        /** --------------------------------------------*/
		
        foreach ($sql as $query)
        {
            $DB->query($query);
        }
        
        /** --------------------------------------------
        /**  Set default cache prefs
        /** --------------------------------------------*/
        
        $this->data->set_default_cache_prefs();
        
        /** --------------------------------------------
        /**  Version Number Update - LAST!
        /** --------------------------------------------*/
    	
    	$DB->query($DB->update_string(	'exp_modules',
    									array('module_version'	=> SUPER_SEARCH_VERSION), 
    									array('module_name'		=> $this->class_name)));

    }
    /* END update() */
}
/* END Class */