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
 * Data Models
 *
 * The parent class for all of the Data Model classes in Hermes enabled Add-Ons.  Helps with caching
 * of common queries.
 *
 * @package 	Hermes:Expansion
 * @subpackage	Add-On Builder
 * @category	Data
 * @author		Paul Burdick <paul@solspace.com>
 * @link		http://solspace.com/docs/
 * @filesource 	./system/hermes/addon_builder/data.addon_builder.php
 */

class Addon_builder_data {

	var $cached = array();
    
    // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	null
	 */
    
	function Addon_builder_data()
    {	
    	/** --------------------------------------------
        /**  Globals to Class Objects
        /** --------------------------------------------*/
        
        $this->EE = new stdClass();
        
        $magical = array('BM'	=> 'benchmark',
        				 'DB'	=> 'db',
        				 'EXT'	=> 'extensions',
        				 'FNS'	=> 'functions',
        				 'IN'	=> 'input',
        				 'LANG'	=> 'lang',
        				 'LOC'	=> 'localize',
        				 'OUT'	=> 'output',
        				 'PREFS'=> 'config',
        				 'SESS'	=> 'session',
        				 'STAT'	=> 'stats');
        				 
        foreach($magical as $global => $object)
        {
        	if ( ! isset($GLOBALS[$global])) continue;
        	
        	$this->EE->$object =& $GLOBALS[$global];
        }
    	
    	/** --------------------------------------------
        /**  Prepare the Cache
        /** --------------------------------------------*/
    	
    	$class = get_class($this);
    	
    	if ( ! isset($this->EE->session) OR ! is_object($this->EE->session))
    	{
    		if ( ! isset($GLOBALS['hermes']['cache']['addon_builder']['data'][$class]))
    		{
    			$GLOBALS['hermes']['cache']['addon_builder']['data'][$class] = array();
    		}
    		
    		$this->cached =& $GLOBALS['hermes']['cache']['addon_builder']['data'][$class];
    	}
    	else
    	{
    		if ( ! isset($this->EE->session->cache['hermes']['addon_builder']['data'][$class]))
 			{
 				if( isset($GLOBALS['hermes']['cache']['addon_builder']['data'][$class]))
				{
					$this->EE->session->cache['hermes']['addon_builder']['data'][$class] = $GLOBALS['hermes']['cache']['addon_builder']['data'][$class];
				}
 				else
 				{
 					$this->EE->session->cache['hermes']['addon_builder']['data'][$class] = array();
 				}
 			}
 		
 			$this->cached =& $this->EE->session->cache['hermes']['addon_builder']['data'][$class];
 		}
    }
    /* END Addon_builder_data() */
    
    // --------------------------------------------------------------------

	/**
	 * Implodes an Array and Hashes It
	 *
	 * @access	public
	 * @return	string
	 */
    
	function _imploder($arguments)
    {
    	return md5(serialize($arguments));
    }
    /* END */

	// --------------------------------------------------------------------
	
	/**
	 * List of Installations Sites
	 *
	 * @access	public
	 * @param	params	MySQL clauses, if necessary
	 * @return	array
	 */
    
	function get_sites()
    {
 		global $DB, $PREFS, $SESS;
 		
 		/** --------------------------------------------
        /**  SuperAdmins Alredy Have All Sites
        /** --------------------------------------------*/
        
        if (is_object($SESS) && isset($this->EE->session->userdata['group_id']) && $this->EE->session->userdata['group_id'] == 1 && isset($this->EE->session->userdata['assigned_sites']) && is_array($this->EE->session->userdata['assigned_sites']))
        {
        	return $this->EE->session->userdata['assigned_sites'];
        }
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder(func_get_args());
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = array();
 		
 		/** --------------------------------------------
        /**  Perform the Actual Work
        /** --------------------------------------------*/
        
        if ($this->EE->config->ini('multiple_sites_enabled') == 'y')
        {
        	$sites_query = $this->EE->db->query("SELECT site_id, site_label FROM exp_sites ORDER BY site_label");
		}
		else
		{
			$sites_query = $this->EE->db->query("SELECT site_id, site_label FROM exp_sites WHERE site_id = '1'");
		}
		
		foreach($sites_query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][$row['site_id']] = $row['site_label'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    /* END get_sites() */

	// --------------------------------------------------------------------

	
}
// END CLASS Addon_builder_data