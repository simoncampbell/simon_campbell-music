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
 * Super Search Module Class - Actions
 *
 * Handles All Form Submissions and Action Requests
 *
 * @package		Solspace:Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @see			http://www.solspace.com/docs/
 * @location 	./system/modules/super_search/act.super_search.php
 */ 

require_once PATH.'hermes/lib/addon_builder/addon_builder.php';

class Super_search_actions extends Addon_builder {
	
	var $errors				= array();
	
	var $module_preferences = array();
    
	// --------------------------------------------------------------------

	/**
	 * Constructor
	 
	 * @access	public
	 * @return	null
	 */
    
	function Super_search_actions()
    {
    	global $LANG, $LOC, $DB;
    	
    	if ( is_object($LANG))
    	{
    		$LANG->fetch_language_file('super_search');
    	}
	}
	
	/* END */
	
	// --------------------------------------------------------------------

	/**
	 * Clear cache
	 *
	 * Clear cache for a given site
	 *
	 * @access	public
	 * @return	bool
	 */
    
    function clear_cache ()
    {
    	global $DB, $PREFS;
		
		do
		{
			$DB->query(
				"DELETE FROM exp_super_search_cache
				WHERE site_id = ".$PREFS->ini( 'site_id' )."
				LIMIT 1000 /* Super Search act.super_search.php clear_cache() */"
			);
		} 
		while ( $DB->affected_rows == 1000 );
		
		do
		{			
			$DB->query(
				"DELETE FROM exp_super_search_history
				WHERE site_id = ".$PREFS->ini( 'site_id' )."
				AND saved = 'n'
				AND cache_id NOT IN (
					SELECT cache_id
					FROM exp_super_search_cache
				)
				LIMIT 1000 /* Super Search act.super_search.php clear_cache() clear history */"
			);
		} 
		while ( $DB->affected_rows == 1000 );
		
		return TRUE;
    }
    
	/* End clear cache */	

	// --------------------------------------------------------------------

	/**
	 *  Get the Preferences for This Module
	 *
	 * @access	public
	 * @return	array
	 */
	
	function module_preferences()
	{
	}
	
	/* END module_preferences() */
}

/* END Class */