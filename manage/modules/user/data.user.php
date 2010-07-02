<?php if ( ! defined('EXT') ) exit('No direct script access allowed');
 
 /**
 * Solspace - User
 *
 * @package		Solspace:User
 * @author		Solspace DevTeam
 * @copyright	Copyright (c) 2008-2010, Solspace, Inc.
 * @link		http://solspace.com/docs/addon/c/User/
 * @version		3.1.0
 * @filesource 	./system/modules/user/
 * 
 */
 
 /**
 * User Module Class - Data Models
 *
 * Data Models for the User Module
 *
 * @package 	Solspace:User module
 * @author		Paul Burdick <paul.burdick@solspace.com>
 * @filesource 	./system/modules/user/data.user.php
 */
 
if (APP_VER < 2.0)
{
	require_once PATH.'bridge/lib/addon_builder/data.addon_builder.php';
}
else
{
	require_once BASEPATH.'expressionengine/third_party/bridge/lib/addon_builder/data.addon_builder.php';
}

class User_data extends Addon_builder_data_bridge {

	// --------------------------------------------------------------------
	
	/**
	 * Get the Preference for the Module for the Current Site
	 *
	 * @access	public
	 * @param	array	Array of Channel/Weblog IDs
	 * @return	array
	 */
    
	public function get_channel_data_by_channel_array( $channels = array() )
    {
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder(func_get_args());
 		
 		if (isset($this->cached[$cache_name][$cache_hash][ee()->config->item('site_id')]))
 		{
 			return $this->cached[$cache_name][$cache_hash][ee()->config->item('site_id')];
 		}
 		
 		$this->cached[$cache_name][$cache_hash][ee()->config->item('site_id')] = array();
 		
 		/** --------------------------------------------
        /**  Perform the Actual Work
        /** --------------------------------------------*/
        
        $extra = '';
        
        if (APP_VER < 2.0)
        {
			if (is_array($channels) && sizeof($channels) > 0)
			{
				$extra = " AND w.weblog_id IN ('".implode("','", ee()->db->escape_str($channels))."')";
			}
			
			$query = ee()->db->query("SELECT w.blog_title, w.weblog_id, s.site_id, s.site_label
										   FROM exp_weblogs AS w, exp_sites AS s
										   WHERE s.site_id = w.site_id
										   {$extra}");
										   
			foreach($query->result_array() as $row)
			{
				$this->cached[$cache_name][$cache_hash][ee()->config->item('site_id')][$row['weblog_id']] = $this->translate_keys($row);	
			}
		}
		else
		{
			if (is_array($channels) && sizeof($channels) > 0)
			{
				$extra = " AND c.channel_id IN ('".implode("','", ee()->db->escape_str($channels))."')";
			}
			
			$query = ee()->db->query("SELECT c.channel_title, c.channel_id, s.site_id, s.site_label
										   FROM exp_channels AS c, exp_sites AS s
										   WHERE s.site_id = c.site_id
										   {$extra}");
										   
			foreach($query->result_array() as $row)
			{
				$this->cached[$cache_name][$cache_hash][ee()->config->item('site_id')][$row['channel_id']] = $row;	
			}
		}
       
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash][ee()->config->item('site_id')];	
    }
    /* END get_module_preferences() */

	// --------------------------------------------------------------------

	
}
// END CLASS User_data