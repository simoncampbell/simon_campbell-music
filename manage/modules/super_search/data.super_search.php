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
 * Data modeler
 *
 * @package		Solspace:Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @see			http://www.solspace.com/docs/
 * @location 	./system/modules/super_search/data.super_search.php
 */

require_once PATH.'hermes/lib/addon_builder/data.addon_builder.php';

class Super_search_data extends Addon_builder_data
{
	// --------------------------------------------------------------------
	
	/**
	 * Caching is enabled
	 *
	 * @access	public
	 * @return	boolean
	 */
    
	function caching_is_enabled( $site_id = '' )
    {
 		global $DB, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder( array( $site_id ) );
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = FALSE;
 		
 		/** --------------------------------------------
        /**  Caching info
        /** --------------------------------------------*/
		
		$sql = "/* Super Search data.super_search.php caching_is_enabled() */ SELECT date, refresh
				FROM exp_super_search_refresh_rules
				WHERE ( refresh != 0 OR template_id != 0 OR weblog_id != 0 OR category_group_id != 0 ) AND site_id = ".$DB->escape_str( $site_id );
		
		$query = $DB->query( $sql );
        
        if ( $query->num_rows == 0 )
        {
			$this->cached['get_refresh_by_site_id'][$cache_hash]		= 0;
			$this->cached['get_refresh_date_by_site_id'][$cache_hash]	= 0;
        	return FALSE;
        }
 		
 		/** --------------------------------------------
        /**  Set refresh for later just in case. Any of the returned rows will work since date and refresh are the same for all rows in a site.
        /** --------------------------------------------*/
        
        $this->cached['get_refresh_by_site_id'][$cache_hash]		= $query->row['refresh'];
        $this->cached['get_refresh_date_by_site_id'][$cache_hash]	= $query->row['date'];
 		
 		/** --------------------------------------------
        /**	If we made it this far, caching is enabled.
        /** --------------------------------------------*/
        
		$this->cached[$cache_name][$cache_hash] = TRUE;
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End caching is enabled */
    
	// --------------------------------------------------------------------
	
	/**
	 * Get category groups
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_category_groups()
    {
 		global $DB, $PREFS;
 		
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
        /**  Grab category groups
        /** --------------------------------------------*/
		
		$sql = "/* Super Search data.super_search.php get_category_groups() */ SELECT group_id, group_name
				FROM exp_category_groups
				WHERE site_id = ".$DB->escape_str( $PREFS->ini('site_id') )."
				ORDER BY group_name ASC";
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][$row['group_id']] = $row['group_name'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get category groups */

	// --------------------------------------------------------------------
	
	/**
	 * Get refresh rule by template id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_refresh_rule_by_template_id( $template_id = 0 )
    {
 		global $DB;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder(func_get_args());
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = FALSE;
 		
 		/** --------------------------------------------
        /**  Grab cache ids
        /** --------------------------------------------*/
        
        if ( $template_id === 0 OR is_numeric( $template_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_refresh_rule_by_template_id() */ SELECT COUNT(*) AS count
				FROM exp_super_search_refresh_rules
				WHERE template_id = ".$DB->escape_str( $template_id );
		
		$query = $DB->query( $sql );
		
		if ( $query->num_rows > 0 AND $query->row['count'] > 0 )
		{
			$this->cached[$cache_name][$cache_hash] = TRUE;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get refresh rule by template id */

	// --------------------------------------------------------------------
	
	/**
	 * Get refresh rule by weblog id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_refresh_rule_by_weblog_id( $weblog_id = 0 )
    {
 		global $DB;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder(func_get_args());
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = FALSE;
 		
 		/** --------------------------------------------
        /**  Grab cache ids
        /** --------------------------------------------*/
        
        if ( $weblog_id === 0 OR is_numeric( $weblog_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_refresh_rule_by_weblog_id() */ SELECT COUNT(*) AS count
				FROM exp_super_search_refresh_rules
				WHERE weblog_id = ".$DB->escape_str( $weblog_id );
		
		$query = $DB->query( $sql );
		
		if ( $query->num_rows > 0 AND $query->row['count'] > 0 )
		{
			$this->cached[$cache_name][$cache_hash] = TRUE;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get refresh rule by weblog id */

	// --------------------------------------------------------------------
	
	/**
	 * Get refresh rule by category group id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_refresh_rule_by_category_group_id( $group_id = 0 )
    {
 		global $DB;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder(func_get_args());
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = FALSE;
 		
 		/** --------------------------------------------
        /**  Grab cache ids
        /** --------------------------------------------*/
        
        if ( $group_id === 0 OR is_numeric( $group_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_refresh_rule_by_category_group_id() */ SELECT COUNT(*) AS count
				FROM exp_super_search_refresh_rules
				WHERE category_group_id = ".$DB->escape_str( $group_id );
		
		$query = $DB->query( $sql );
		
		if ( $query->num_rows > 0 AND $query->row['count'] > 0 )
		{
			$this->cached[$cache_name][$cache_hash] = TRUE;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get refresh rule by category group id */

	// --------------------------------------------------------------------
	
	/**
	 * Get refresh by site id
	 *
	 * @access	public
	 * @return	integer
	 */
    
	function get_refresh_by_site_id( $site_id = '' )
    {
 		global $DB, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder( array( $site_id ) );
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = 0;
 		
 		/** --------------------------------------------
        /**  Grab refresh rule
        /** --------------------------------------------*/
		
		$sql = "/* Super Search data.super_search.php get_refresh_by_site_id() */ SELECT date, refresh
				FROM exp_super_search_refresh_rules
				WHERE site_id = ".$DB->escape_str( $site_id )."
				LIMIT 1";
		
		$query = $DB->query( $sql );
		
		if ( $query->num_rows == 0 OR isset( $query->row['refresh'] ) === FALSE )
		{
			$this->cached['get_refresh_date_by_site_id'][$cache_hash]	= 0;
			return $this->cached[$cache_name][$cache_hash];
		}
		
		$this->cached['get_refresh_date_by_site_id'][$cache_hash]	= $query->row['date'];
		$this->cached[$cache_name][$cache_hash] 					= $query->row['refresh'];
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];
    }
    
    /*	End get refresh by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get refresh date by site id
	 *
	 * @access	public
	 * @return	integer
	 */
    
	function get_refresh_date_by_site_id( $site_id = '' )
    {
 		global $DB, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder( array( $site_id ) );
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = 0;
 		
 		/** --------------------------------------------
        /**  Grab refresh rule
        /** --------------------------------------------*/
		
		$sql = "/* Super Search data.super_search.php get_refresh_date_by_site_id() */ SELECT date, refresh
				FROM exp_super_search_refresh_rules
				WHERE site_id = ".$DB->escape_str( $site_id )."
				LIMIT 1";
		
		$query = $DB->query( $sql );
		
		if ( $query->num_rows == 0 OR isset( $query->row['date'] ) === FALSE )
		{
			$this->cached['get_refresh_by_site_id'][$cache_hash]	= 0;
			return $this->cached[$cache_name][$cache_hash];
		}
		
		$this->cached['get_refresh_by_site_id'][$cache_hash]	= $query->row['refresh'];
		$this->cached[$cache_name][$cache_hash] 				= $query->row['date'];
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];
    }
    
    /*	End get refresh date by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get selected category groups by site id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_selected_category_groups_by_site_id( $site_id = '' )
    {
 		global $DB, $PREFS;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
        
        if ( $site_id === 0 OR is_numeric( $site_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_selected_category_groups_by_site_id() */ SELECT category_group_id
				FROM exp_super_search_refresh_rules
				WHERE category_group_id != 0
				AND site_id = ".$DB->escape_str( $site_id );
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][] = $row['category_group_id'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End selected category groups by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get selected template groups by site id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_selected_template_groups_by_site_id( $site_id = 0 )
    {
 		global $DB;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
        
        if ( $site_id === 0 OR is_numeric( $site_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_selected_template_groups_by_site_id() */ SELECT group_id
				FROM exp_templates
				WHERE template_id IN (
				SELECT template_id
				FROM exp_super_search_refresh_rules
				WHERE template_id != 0
				AND site_id = ".$DB->escape_str( $site_id ).")";
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][] = $row['group_id'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End selected template groups by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get selected templates by site id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_selected_templates_by_site_id( $site_id = 0 )
    {
 		global $DB;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
        
        if ( $site_id === 0 OR is_numeric( $site_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_selected_templates_by_site_id() */ SELECT template_id
				FROM exp_super_search_refresh_rules
				WHERE template_id != 0
				AND site_id = ".$DB->escape_str( $site_id );
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][] = $row['template_id'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End selected templates by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get selected weblogs by site id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_selected_weblogs_by_site_id( $site_id = 0 )
    {
 		global $DB;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
        
        if ( $site_id === 0 OR is_numeric( $site_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_selected_weblogs_by_site_id() */ SELECT weblog_id
				FROM exp_super_search_refresh_rules
				WHERE weblog_id != 0
				AND site_id = ".$DB->escape_str( $site_id );
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][] = $row['weblog_id'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End selected weblogs by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get template groups
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_template_groups()
    {
 		global $DB, $PREFS;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
		
		$sql = "/* Super Search data.super_search.php get_template_groups() */ SELECT tg.group_id, tg.group_name, t.template_id, t.template_name
				FROM exp_template_groups tg
				LEFT JOIN exp_templates t ON t.group_id = tg.group_id
				WHERE tg.site_id = ".$DB->escape_str( $PREFS->ini('site_id') )."
				AND is_user_blog = 'n'
				ORDER BY tg.group_order, t.template_name ASC";
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[ $cache_name ][ $cache_hash ][ $row['group_id'] ]	= $row['group_name'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get template groups */

	// --------------------------------------------------------------------
	
	/**
	 * Get templates by group id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_templates_by_group_id( $group_id = 0 )
    {
 		global $DB, $PREFS;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
        
        if ( $group_id === 0 OR is_numeric( $group_id ) === FALSE ) return $this->cached[$cache_name][$cache_hash];
		
		$sql = "/* Super Search data.super_search.php get_templates_by_group_id() */ SELECT t.template_id, t.template_name
				FROM exp_templates t
				WHERE t.group_id = ".$DB->escape_str( $group_id )."
				ORDER BY t.template_name ASC";
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{			
			$this->cached[ $cache_name ][ $cache_hash ][ $row['template_id'] ]	= $row['template_name'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get templates by group id */

	// --------------------------------------------------------------------
	
	/**
	 * Get weblogs
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_weblogs()
    {
 		global $DB;
 		
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
        /**  Grab weblogs
        /** --------------------------------------------*/
		
		$sql = "/* Super Search data.super_search.php get_weblogs() */ SELECT site_id, weblog_id, blog_name, blog_title, cat_group, field_group, weblog_html_formatting, weblog_allow_img_urls, weblog_auto_link_urls, comment_url, blog_url, search_results_url, search_excerpt
				FROM exp_weblogs
				ORDER BY blog_title ASC";
		
		$query = $DB->query( $sql );
		
		foreach($query->result as $row)
		{
			$this->cached[$cache_name][$cache_hash][$row['weblog_id']] = $row;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get weblogs */

	// --------------------------------------------------------------------
	
	/**
	 * Get weblogs by site id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_weblogs_by_site_id( $site_id = '' )
    {
 		global $DB, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( is_string( $site_id ) === TRUE AND $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
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
        /**  Site ids
        /** --------------------------------------------*/
        
        $site_ids	= array();
        
        if ( is_array( $site_id ) === TRUE AND ! empty( $site_id ) )
        {
        	$site_ids	= $site_id;
        }
        elseif ( is_string( $site_id ) === TRUE AND $site_id != '' )
        {
        	$site_ids[]	= $site_id;
        }
 		
 		/** --------------------------------------------
        /**  Grab weblogs
        /** --------------------------------------------*/
		
		foreach ( $this->get_weblogs() as $row )
		{
			if ( ! count( $site_ids ) AND in_array( $row['site_id'], $site_ids ) === FALSE ) continue;
		
			$this->cached[$cache_name][$cache_hash][$row['weblog_id']] = $row;			
			$this->cached['get_weblogs_by_site_id_keyed_to_name'][$cache_hash][$row['blog_name']] = $row;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get weblogs by site id */

	// --------------------------------------------------------------------
	
	/**
	 * Get weblogs by site id and weblog id
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_weblogs_by_site_id_and_weblog_id( $site_id = '', $weblog_id = '' )
    {
 		global $DB;
 		
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
        /**  Site ids
        /** --------------------------------------------*/
        
        $site_ids	= array();
        
        if ( is_array( $site_id ) === TRUE AND ! empty( $site_id ) )
        {
        	$site_ids	= $site_id;
        }
        elseif ( is_string( $site_id ) === TRUE AND $site_id != '' )
        {
        	$site_ids[]	= $site_id;
        }
 		
 		/** --------------------------------------------
        /**  Weblog ids
        /** --------------------------------------------*/
        
        $weblog_ids	= array();
        
        if ( is_array( $weblog_id ) === TRUE AND ! empty( $weblog_id ) )
        {
        	$weblog_ids		= $weblog_id;
        }
        elseif ( is_string( $weblog_id ) === TRUE AND $weblog_id != '' )
        {
        	$weblog_ids[]	= $weblog_id;
        }
 		
 		/** --------------------------------------------
        /**  Grab weblogs
        /** --------------------------------------------*/
		
		foreach ( $this->get_weblogs() as $row )
		{
			if ( ! empty( $site_ids ) AND in_array( $row['site_id'], $site_ids ) === FALSE ) continue;
			
			if ( ! empty( $weblog_ids ) AND in_array( $row['weblog_id'], $weblog_ids ) === FALSE ) continue;
		
			$this->cached[$cache_name][$cache_hash][$row['weblog_id']] = $row;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get weblogs by site id and weblog id */

	// --------------------------------------------------------------------
	
	/**
	 * Get weblogs by site id keyed to name
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_weblogs_by_site_id_keyed_to_name( $site_id = '' )
    {
 		global $DB, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( is_string( $site_id ) === TRUE AND $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
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
        /**  Site ids
        /** --------------------------------------------*/
        
        $site_ids	= array();
        
        if ( is_array( $site_id ) === TRUE AND ! empty( $site_id ) )
        {
        	$site_ids	= $site_id;
        }
        elseif ( is_string( $site_id ) === TRUE AND $site_id != '' )
        {
        	$site_ids[]	= $site_id;
        }
 		
 		/** --------------------------------------------
        /**  Grab weblogs
        /** --------------------------------------------*/
		
		foreach ( $this->get_weblogs() as $row )
		{
			if ( ! empty( $site_ids ) AND in_array( $row['site_id'], $site_ids ) === FALSE ) continue;
		
			$this->cached[$cache_name][$cache_hash][$row['blog_name']] = $row;
			$this->cached['get_weblogs_by_site_id'][$cache_hash][$row['weblog_id']] = $row;
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get weblogs by site id keyed to name */

	// --------------------------------------------------------------------
	
	/**
	 * Get weblog titles
	 *
	 * @access	public
	 * @return	array
	 */
    
	function get_weblog_titles( $site_id = '' )
    {
 		global $DB;
 		
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
        /**  Site ids
        /** --------------------------------------------*/
        
        $site_ids	= array();
        
        if ( is_array( $site_id ) === TRUE AND ! empty( $site_id ) )
        {
        	$site_ids	= $site_id;
        }
        else
        {
        	$site_ids[]	= $site_id;
        }
 		
 		/** --------------------------------------------
        /**  Grab weblogs
        /** --------------------------------------------*/
		
		foreach ( $this->get_weblogs() as $row )
		{
			if ( ! empty( $site_ids ) AND in_array( $row['site_id'], $site_ids ) === FALSE ) continue;
		
			$this->cached[$cache_name][$cache_hash][$row['weblog_id']] = $row['blog_title'];
		}
        
 		/** --------------------------------------------
        /**  Return Data
        /** --------------------------------------------*/
 		
 		return $this->cached[$cache_name][$cache_hash];	
    }
    
    /*	End get weblog titles */
	
	// --------------------------------------------------------------------
	
	/**
	 * Playa is installed
	 *
	 * @access	public
	 * @return	boolean
	 */
    
	function playa_is_installed()
    {
    	global $DB;
    
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder(func_get_args());
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = FALSE;
    
 		/** --------------------------------------------
        /**	FieldFrame installed?
        /** --------------------------------------------*/
        
        if ( $DB->table_exists( 'exp_ff_fieldtypes' ) === FALSE )
        {
        	return FALSE;
        }
    
 		/** --------------------------------------------
        /**	Check DB
        /** --------------------------------------------*/
        
        $query	= $DB->query( "SELECT COUNT(*) AS count FROM exp_ff_fieldtypes WHERE class = 'playa' AND enabled = 'y'" );
        
        if ( $query->row['count'] > 0 )
        {
        	return $this->cached[$cache_name][$cache_hash] = TRUE;
        }
        
        return FALSE;
 	}
 	
 	/*	End playa is installed */

	// --------------------------------------------------------------------
	
	/**
	 * Set default cache prefs
	 *
	 * @access	public
	 * @return	null
	 */
    
	function set_default_cache_prefs()
    {
 		global $DB, $LOC, $PREFS, $SESS;
 		
 		$sites	= $this->get_sites();
        
 		/** --------------------------------------------
        /**	Get existing prefs
        /** --------------------------------------------*/
        
        $sql	= "SELECT site_id FROM exp_super_search_refresh_rules";
        
        $query	= $DB->query( $sql );
        
        $prefs	= array();
        
        foreach ( $query->result as $row )
        {
        	$prefs[]	= $row['site_id'];
        }
        
 		/** --------------------------------------------
        /**	Loop and load
        /** --------------------------------------------*/
        
        $refresh		= 10;
        $next_refresh	= $LOC->now + ( $refresh * 60 );
        
        foreach ( array_keys( $sites ) as $site )
        {
        	if ( in_array( $site, $prefs ) === TRUE ) continue;
        	
        	$sql	= $DB->insert_string( 'exp_super_search_refresh_rules', array( 'site_id' => $site, 'refresh' => $refresh, 'date' => $next_refresh, 'member_id' => $SESS->userdata('member_id') ) );
        	
        	$DB->query( $sql );
        }
 	}
 	
 	/*	End set default cache prefs */

	// --------------------------------------------------------------------
	
	/**
	 * Set new refresh date
	 *
	 * @access	public
	 * @return	boolean
	 */
    
	function set_new_refresh_date( $site_id = '' )
    {
 		global $DB, $LOC, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
 		/** --------------------------------------------
        /**  Update
        /** --------------------------------------------*/
        
        $refresh	= $this->get_refresh_by_site_id( $site_id );
        
        $sql	= $DB->update_string( 'exp_super_search_refresh_rules', array( 'date' => $LOC->now + ( $refresh * 60 ) ), array( 'site_id' => $site_id ) );
        
        $DB->query( $sql );
 	}
 	
 	/*	End set new refresh date */
	
	// --------------------------------------------------------------------
	
	/**
	 * Set preference
	 *
	 * @access	public
	 * @return	array
	 */
    
	function set_preference( $preferences = array() )
    {
    	global $DB, $PREFS, $REGX;
    
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
        /**	Grab prefs from DB
        /** --------------------------------------------*/
        
        $sql	= "SELECT site_system_preferences
					FROM exp_sites
					WHERE site_id = " . $DB->escape_str( $PREFS->ini('site_id') );
        	
        $query	= $DB->query( $sql );
        
        if ( $query->num_rows == 0 ) return FALSE;
 		
 		$this->cached[$cache_name][$cache_hash] = $REGX->array_stripslashes( unserialize( $query->row['site_system_preferences'] ) );
    
 		/** --------------------------------------------
        /**	Add our prefs
        /** --------------------------------------------*/
        
        $prefs	= array();
        
        foreach ( explode( "|", SUPER_SEARCH_PREFERENCES ) as $val )
        {
        	if ( isset( $preferences[$val] ) === TRUE )
        	{
        		$this->cached[$cache_name][$cache_hash][$val]	= $preferences[$val];
        	}
        }
			
		$DB->query(
			$DB->update_string(
				'exp_sites',
				array(
					'site_system_preferences' => addslashes( serialize( $this->cached[$cache_name][$cache_hash] ) )
				),
				array(
					'site_id'	=> $PREFS->ini('site_id')
				)
			)
		);
		
		return TRUE;
	}
	
	/* End set preference */

	// --------------------------------------------------------------------
	
	/**
	 * Time to refresh cache
	 *
	 * @access	public
	 * @return	boolean
	 */
    
	function time_to_refresh_cache( $site_id = '' )
    {
 		global $DB, $LOC, $PREFS;
 		
 		/** --------------------------------------------
        /**  Set site id
        /** --------------------------------------------*/
        
        $site_id	= ( $site_id == '' ) ? $PREFS->ini('site_id'): $site_id;
 		
 		/** --------------------------------------------
        /**  Prep Cache, Return if Set
        /** --------------------------------------------*/
 		
 		$cache_name = __FUNCTION__;
 		$cache_hash = $this->_imploder( array( $site_id ) );
 		
 		if (isset($this->cached[$cache_name][$cache_hash]))
 		{
 			return $this->cached[$cache_name][$cache_hash];
 		}
 		
 		$this->cached[$cache_name][$cache_hash] = FALSE;
 		
 		/** --------------------------------------------
        /**  Should we refresh?
        /** --------------------------------------------*/
        
        if ( $this->get_refresh_date_by_site_id( $site_id ) > 0 AND $this->get_refresh_date_by_site_id( $site_id ) <= $LOC->now )
        {
			$this->cached[$cache_name][$cache_hash] = TRUE;
        }
        
        return $this->cached[$cache_name][$cache_hash];
 	}
 	
 	/*	End time to refresh cache */
}

// END CLASS Super search data