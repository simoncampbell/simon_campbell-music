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
 * Super Search Extension Class - Actions
 *
 * Placeholder for now
 *
 * @package		Solspace:Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @see			http://www.solspace.com/docs/
 * @location 	./system/modules/super_search/ext.super_search.php
 */ 

require_once PATH.'hermes/lib/addon_builder/extension_builder.php';
 
class Super_search_extension extends Extension_builder
{
	var $settings		= array();
	
	var $name			= '';
	var $version		= '';
	var $description	= '';
	var $settings_exist	= 'n';
	var $docs_url		= '';
	
	var $sess			= FALSE;
	    
	// --------------------------------------------------------------------

	/**
	 * Constructor
	 
	 * @access	public
	 * @return	null
	 */
    
	function Super_search_extension ($settings = array())
    {
    	global $LANG, $LOC, $DB, $REGX, $SESS;
    	
    	parent::Extension_builder('super_search');
    	
    	/** --------------------------------------------
        /**  Settings
        /** --------------------------------------------*/
    	
    	$this->settings = $settings;
        
        /** --------------------------------------------
        /**  Set Required Extension Variables
        /** --------------------------------------------*/
        
        if ( is_object($LANG))
        {
        	$LANG->fetch_language_file('super_search');
        
        	$this->name			= $LANG->line('super_search_module_name');
        	$this->description	= $LANG->line('super_search_module_description');
        }
        
        $this->docs_url		= SUPER_SEARCH_DOCS_URL;
        $this->version		= SUPER_SEARCH_VERSION;
        
        /** -------------------------------------
		/** Prepare for $SESS->cache
		/** -------------------------------------*/
		
		if ( isset( $SESS->cache['extensions']['super_search'] ) === FALSE )
		{
			$SESS->cache['extensions']['super_search']	= array();
		}
		
		$this->sess	=& $SESS->cache['extensions']['super_search'];
	}
	/* END Super_search_extension() */
	
	// --------------------------------------------------------------------

	/**
	 * Field Frame exists
	 *
	 * Quick test to make sure that the Field Frame extension even exists.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function _field_frame_exists()
    {
    	global $DB;
    	
    	if ( ! empty( $this->sess['ff_exists'] ) ) return TRUE;
    	
    	if ( $DB->table_exists( 'exp_ff_fieldtypes' ) === TRUE )
    	{
    		$this->sess['ff_exists']	= TRUE;
    		return TRUE;
    	}
    	
    	return FALSE;
    }
    
    /*	End field frame exists */
	
	// --------------------------------------------------------------------

	/**
	 * Field frame multi field helper
	 *
	 * Checkbox group and multiselect fields behave pretty much the same, so we homogenize the code.
	 *
	 * @access	private
	 * @return	null
	 */
    
	function _field_frame_multi_field_helper($ths, $type)
    {
    	global $SESS;
    	
    	/** --------------------------------------------
        /**	Access the Super Search session cache for convenience
        /** --------------------------------------------*/
    	
    	$sess	=& $SESS->cache['modules']['super_search'];
    	
    	/** --------------------------------------------
        /**	Get field data
        /** --------------------------------------------*/
        
        if ( ( $fields = $this->_get_additional_ff_field_data( $type ) ) === FALSE )
        {
        	return FALSE;
        }
    	
    	/** --------------------------------------------
        /**	Handle exact field searching
        /** --------------------------------------------*/
        
        if ( ! empty( $sess['search']['q']['exactfield'] ) )
        {
        	$handy	=& $sess['search']['q']['exactfield'];
        
			/** --------------------------------------------
			/**	For each correct FF field type, let's change the query to be a serialized array so that we can get a perfect DB match.
			/** --------------------------------------------*/
        
        	foreach ( $fields as $key => $val )
        	{
				/** --------------------------------------------
				/**	If we're searching a single value, we can serialize and be ready for FF. If the 'or' array has more than one term, we can't bother trying to test all of the serialized permutations of the terms. We skip that case.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['or'] ) AND count( $handy[$key]['or'] ) == 1 )
				{
					$handy[$key]['or'][0]	= serialize( array( $handy[$key]['or'][0] ) );
				}
				
				/** --------------------------------------------
				/**	Conjoined / inclusive searching
				/** --------------------------------------------*/
				
				if ( ! empty( $handy[$key]['and'] ) )
				{
					$handy[$key]['or']	= array( serialize( $handy[$key]['and'] ) );
				}
        	}
        }
    }
    
    /* End field frame multi field helper */
	
	// --------------------------------------------------------------------

	/**
	 * Get additional ff field data
	 *
	 * FieldFrame fields have additional data stored in the column ff_settings in exp_weblog_fields. We'll need this data to work with FF fields.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function _get_additional_ff_field_data( $type = '' )
    {
    	global $DB;
    	
    	/** --------------------------------------------
        /**	Validate
        /** --------------------------------------------*/
        
        if ( $type == '' ) return FALSE;
    	
    	/** --------------------------------------------
        /**	Data already available?
        /** --------------------------------------------*/
        
        if ( ! empty( $this->sess['ff_fields'][$type] ) )
        {
        	return $this->sess['ff_fields'][$type];
        }
    	
    	/** --------------------------------------------
        /**	Get data
        /** --------------------------------------------*/
        
        if ( empty( $this->sess['ff_fields_query'] ) )
        {
			$sql	= "/* Super Search Extension FieldFrame code */ SELECT wf.field_id, wf.field_name, wf.ff_settings, wf.site_id, wf.group_id, ff.class
				FROM exp_weblog_fields wf
				LEFT JOIN exp_ff_fieldtypes ff ON CONCAT( 'ftype_id_', ff.fieldtype_id ) = wf.field_type
				WHERE ff.enabled = 'y'";
			
			$query	= $DB->query( $sql );
			
			$this->sess['ff_fields_query']	= $query;
        }
        else
        {
			$query	= $this->sess['ff_fields_query'];
        }
        
        foreach ( $query->result as $row )
        {
        	$this->sess['ff_fields'][$row['class']][$row['field_name']]	= $row;
        	
        	if ( ! empty( $row['ff_settings'] ) AND strpos( $row['ff_settings'], '{s:' ) !== FALSE )
        	{
				$this->sess['ff_fields'][$row['class']][$row['field_name']]['ff_settings']	= unserialize( $row['ff_settings'] );
        	}
        }
    	
    	/** --------------------------------------------
        /**	Return
        /** --------------------------------------------*/
        
        if ( ! empty( $this->sess['ff_fields'][$type] ) )
        {
        	return $this->sess['ff_fields'][$type];
        }
        
        return FALSE;
    }
    
    /* End get additional ff field data */

    // --------------------------------------------------------------------

	/**
	 * Only numeric
	 *
	 * Returns an array containing only numeric values
	 *
	 * @access		private
	 * @return		array
	 */
	
	function _only_numeric( $array )
	{
		if ( empty( $array ) === TRUE ) return array();
		
		if ( is_array( $array ) === FALSE )
		{
			$array	= array( $array );
		}
	
    	foreach ( $array as $key => $val )
    	{
    		if ( preg_match( '/[^0-9]/', $val ) != 0 ) unset( $array[$key] );
    	}
    	
    	if ( empty( $array ) === TRUE ) return array();
    	
    	return $array;
	}
	
	/*	End only numeric */
	
	// --------------------------------------------------------------------

	/**
	 * Refresh cache from category
	 *
	 * Refresh caches when a category is edited
	 *
	 * @access	public
	 * @return	null
	 */
    
	function refresh_cache_from_category()
    {
    	global $DB;
    	
    	if ( ! empty( $_POST['group_id'] ) )
    	{
    		$group_id = $_POST['group_id'];
    	}
    	else
    	{
    		return FALSE;
    	}
    	
    	/** --------------------------------------------
        /**  Should we refresh?
        /** --------------------------------------------*/
    	
    	if ( $this->data->get_refresh_rule_by_category_group_id( $group_id ) === FALSE ) return FALSE;
    	
    	/** --------------------------------------------
        /**  Refresh
        /** --------------------------------------------*/
        
        $this->actions();
        
        $this->actions->clear_cache();
    }
    
    /* End refresh cache from category */
	
	// --------------------------------------------------------------------

	/**
	 * Refresh cache from template
	 *
	 * Refresh caches when a template is edited
	 *
	 * @access	public
	 * @return	null
	 */
    
	function refresh_cache_from_template( $query, $template_id )
    {
    	global $DB, $EXT;
    	
    	$output = ($EXT->last_call !== FALSE) ? $EXT->last_call : '';
    	
    	/** --------------------------------------------
        /**  Get morsels to be refreshed
        /** --------------------------------------------*/
    	
    	if ( $this->data->get_refresh_rule_by_template_id( $template_id ) === FALSE ) return $output;
    	
    	/** --------------------------------------------
        /**  Refresh
        /** --------------------------------------------*/
        
        $this->actions();
        
        $this->actions->clear_cache();
        
        return $output;
    }
    
    /* End refresh cache from template */
	
	// --------------------------------------------------------------------

	/**
	 * Refresh cache from weblog
	 *
	 * Refresh caches when a weblog entry is edited or published
	 *
	 * @access	public
	 * @return	null
	 */
    
	function refresh_cache_from_weblog( $entry_id, $data, $ping_message )
    {
    	global $DB;
    	
    	if ( empty( $data['weblog_id'] ) === TRUE )
    	{
    		return FALSE;
    	}
    	else
    	{
    		$weblog_id	= $data['weblog_id'];
    	}
    	
    	/** --------------------------------------------
        /**  Get morsels to be refreshed
        /** --------------------------------------------*/
    	
    	if ( $this->data->get_refresh_rule_by_weblog_id( $weblog_id ) === FALSE ) return FALSE;
    	
    	/** --------------------------------------------
        /**  Refresh
        /** --------------------------------------------*/
        
        $this->actions();
        
        $this->actions->clear_cache();
    }
    
    /* End refresh cache from weblog */
	
	// --------------------------------------------------------------------

	/**
	 * Do search and array playa
	 *
	 * We will not permit playa fields to be keyword searched.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function super_search_do_search_and_array_playa( &$ths, $arr = array() )
    {
    	global $DB, $EXT, $PREFS, $SESS;
    	
    	$arr	= ( is_array( $EXT->last_call ) === TRUE ) ? $EXT->last_call: $arr;
    	
    	if ( $this->_field_frame_exists() === FALSE ) return $arr;
    	
    	/** --------------------------------------------
        /**	Get field data
        /** --------------------------------------------*/
        
        if ( ( $fields = $this->_get_additional_ff_field_data( 'playa' ) ) === FALSE )
        {
        	return $arr;
        }
    	
    	/** --------------------------------------------
        /**	Access the Super Search session cache for convenience
        /** --------------------------------------------*/
    	
    	$sess	=& $SESS->cache['modules']['super_search'];
    	
    	/** --------------------------------------------
        /**	Kill Playa fields when we can detect keyword or simple field searching
        /** --------------------------------------------*/
        
        if ( empty( $sess['search']['q']['keywords'] ) AND empty( $sess['search']['q']['field'] ) ) return $arr;
        
        if ( ! empty( $sess['search']['q']['keywords'] ) AND $PREFS->ini( 'allow_keyword_search_on_playa_fields' ) !== FALSE AND $PREFS->ini( 'allow_keyword_search_on_playa_fields' ) == 'y' )
        {
        	return $arr;
        }
    	
    	/** --------------------------------------------
        /**	Loop and slay fields
        /** --------------------------------------------*/
        
        foreach ( $fields as $field_name => $field_data )
        {
        	if ( isset( $sess['search']['q']['field'][$field_name] ) === TRUE ) continue;
        
        	$test	= 'wd.field_id_' . $field_data['field_id'];
        
        	if ( isset( $arr['and'] ) === TRUE )
        	{
        		foreach ( $arr['and'] as $k => $v )
        		{
        			if ( strpos( $v, $test . ' LIKE' ) !== FALSE )
        			{
        				unset( $arr['and'][$k] );
        			}
        		}
        	}
        
        	if ( isset( $arr['or'] ) === TRUE )
        	{
        		foreach ( $arr['or'] as $k => $v )
        		{
        			if ( strpos( $v, $test . ' LIKE' ) !== FALSE )
        			{
        				unset( $arr['or'][$k] );
        			}
        		}
        	}
        
        	if ( isset( $arr['not'] ) === TRUE )
        	{
        		foreach ( $arr['not'] as $k => $v )
        		{
        			if ( strpos( $v, $test . ' NOT LIKE' ) !== FALSE )
        			{
        				unset( $arr['not'][$k] );
        			}
        		}
        	}
        }
    	
    	/** --------------------------------------------
        /**	Return
        /** --------------------------------------------*/
        
        return $arr;
    }
    
    /* End do search and array playa */
	
	// --------------------------------------------------------------------

	/**
	 * Alter Search for FF check groups
	 *
	 * We want Super Search to be compatible with Brandon Kelly's FieldFrame, but we don't want to make the support totally native. We'll use extension methods so that we can eventually let people turn support on and off per field type.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function super_search_alter_search_check_group(&$ths)
    {
    	if ( $this->_field_frame_exists() === FALSE ) return FALSE;
    	
    	/** --------------------------------------------
        /**	Just use the multi field helper
        /** --------------------------------------------*/
        
        if ( $this->_field_frame_multi_field_helper( $ths, 'ff_checkbox_group' ) )
        {
        	return FALSE;
        }        
    }
    
    /* End alter search for FF check groups */
	
	// --------------------------------------------------------------------

	/**
	 * Alter Search for FF multiselect
	 *
	 * We want Super Search to be compatible with Brandon Kelly's FieldFrame, but we don't want to make the support totally native. We'll use extension methods so that we can eventually let people turn support on and off per field type.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function super_search_alter_search_multiselect(&$ths)
    {
    	if ( $this->_field_frame_exists() === FALSE ) return FALSE;
    	
    	/** --------------------------------------------
        /**	Just use the multi field helper
        /** --------------------------------------------*/
        
        if ( $this->_field_frame_multi_field_helper( $ths, 'ff_multiselect' ) )
        {
        	return FALSE;
        }        
    }
    
    /* End alter search for FF multiselect */
	
	// --------------------------------------------------------------------

	/**
	 * Alter Search for FF playa
	 *
	 * We want Super Search to be compatible with Brandon Kelly's FieldFrame, but we don't want to make the support totally native. We'll use extension methods so that we can eventually let people turn support on and off per field type.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function super_search_alter_search_playa(&$ths)
    {
    	global $DB, $EXT, $SESS;
    	
    	if ( $this->_field_frame_exists() === FALSE ) return FALSE;
    	
    	/** --------------------------------------------
        /**	Access the Super Search session cache for convenience
        /** --------------------------------------------*/
    	
    	$sess	=& $SESS->cache['modules']['super_search'];
    	
    	/** --------------------------------------------
        /**	Get field data
        /** --------------------------------------------*/
        
        if ( ( $fields = $this->_get_additional_ff_field_data( 'playa' ) ) === FALSE )
        {
        	return FALSE;
        }
    	
    	/** --------------------------------------------
        /**	Handle field searching
        /** --------------------------------------------*/
        
        if ( ! empty( $sess['search']['q']['field'] ) )
        {
        	$handy	=& $sess['search']['q']['field'];
        
			/** --------------------------------------------
			/**	For each correct Playa field type, let's determine how the relationship is being provided to us. We accept entry id's, titles or url_titles.
			/** --------------------------------------------*/
        
        	foreach ( $fields as $key => $val )
        	{
        		$related			= array();
        		$conjoined_related	= array();
        	
				/** --------------------------------------------
				/**	Super Search stores the exact field queries in the 'or' array, just to follow the overall data model. If 'or' is not empty and it's element count is = 1 we'll search for that value.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['or'] ) )
				{
					if ( count( $handy[$key]['or'] ) == 1 )
					{
						$related	= array( $handy[$key]['or'][0] );
					}						
					else
					{
						$related	= $handy[$key]['or'];
					}
					
					unset( $handy[$key]['or'] );
				}
				
				/** --------------------------------------------
				/**	Super Search also stores conjoined exact searches in the 'and' array. We have to do a more complex search on those.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['and'] ) )
				{
					$conjoined_related	= $handy[$key]['and'];
					
					unset( $handy[$key]['and'] );
				}
        	}
			
			/** --------------------------------------------
			/**	Are Playa fields even being invoked?
			/** --------------------------------------------*/
			
			if ( empty( $related ) AND empty( $conjoined_related ) )
			{
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	Prepare arrays
			/** --------------------------------------------*/
			
			$entry_ids	= array();
			$titles		= array();
			
			foreach ( $related as $val )
			{
				if ( is_numeric( $val ) === TRUE )
				{
					$entry_ids[]	= $val;
				}
				elseif ( strpos( $val, ' ' ) === FALSE )
				{
					$titles[]	= $val;
				}
			}
			
			foreach ( $conjoined_related as $val )
			{
				if ( is_numeric( $val ) === TRUE )
				{
					$entry_ids[]	= $val;
				}
				elseif ( strpos( $val, ' ' ) === FALSE )
				{
					$titles[]	= $val;
				}
			}
			
			/** --------------------------------------------
			/**	We need to fail if the supplied related entries are bunk
			/** --------------------------------------------*/
			
			if ( empty( $entry_ids ) AND empty( $titles ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
			
			/** --------------------------------------------
			/**	Get pure entry ids
			/** --------------------------------------------*/
			
			$sql	= "SELECT entry_id, title, url_title
				FROM exp_weblog_titles
				WHERE weblog_id != ''
				AND (";
				
			if ( ! empty( $entry_ids ) )
			{
				$sql	.= "entry_id IN (" . implode( ',', $entry_ids ) . ")";
				
				if ( ! empty( $titles ) )
				{
					$sql	.= " OR (";
				}
			}
				
			if ( ! empty( $titles ) )
			{
				foreach ( $titles as $t )
				{
					$sql	.= " url_title LIKE '%" . $DB->escape_str( $t ) . "%'";
					$sql	.= " OR title LIKE '%" . $DB->escape_str( $t ) . "%' OR";
				}
				
				$sql	= rtrim( $sql, 'OR' );
			}
			
			$sql	.= ")";
			
			$query	= $DB->query( $sql );
			
			$related_entry_ids	= array();
			
			foreach ( $query->result as $row )
			{
				$related_entry_ids[]	= $row['entry_id'];
				$related_entry_titles[]	= $row['title'];
				$related_entry_titles[]	= $row['url_title'];
			}
        
			/** --------------------------------------------
			/**	If we are testing for related , we need to fail if the supplied related entries are not valid
			/** --------------------------------------------*/
			
			if ( ( ! empty( $related ) OR ! empty( $conjoined_related ) ) AND empty( $related_entry_ids ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	Here's a quick validity test to help us skip nonsense.
			/** --------------------------------------------*/
			
			if ( ! empty( $conjoined_related ) AND ! empty( $related_entry_ids ) AND count( $conjoined_related ) > count( $related_entry_ids ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	If we are testing for conjoined related entries, we need to make sure that all of our terms are represented in the search results.
			/** --------------------------------------------*/
			
			if ( ! empty( $conjoined_related ) )
			{
				$test_string	= implode( '||', $related_entry_titles );
			
				foreach ( $conjoined_related as $r )
				{
					if ( is_numeric( $r ) === TRUE )
					{
						if ( in_array( $r, $related_entry_ids ) === FALSE )
						{
							$EXT->end_script	= TRUE;
							return FALSE;
						}
					}
					else
					{
						if ( strpos( $test_string, $r ) === FALSE )
						{
							$EXT->end_script	= TRUE;
							return FALSE;
						}
					}
				}
			}
        
			/** --------------------------------------------
			/**	After validation, do we still have related entries?
			/** --------------------------------------------*/
			
			if ( ! empty( $related_entry_ids ) )
			{
				/** --------------------------------------------
				/**	Get parent entries
				/** --------------------------------------------*/
				
				$sql	= "SELECT r.rel_parent_id, r.rel_child_id
					FROM exp_relationships r
					LEFT JOIN exp_weblog_data wd ON wd.entry_id = r.rel_parent_id
					WHERE r.rel_child_id IN (" . implode( ',', $related_entry_ids ) . ")
					AND r.rel_id != wd.field_id_" . $sess['fields']['searchable'][$key];	// We need a way to know that this record in exp_relationships is being used by a playa field and not a regular EE relationship field since Brandon thought it was such a good idea to piggy back and pollute the data.
					
				$query	= $DB->query( $sql );
        
				/** --------------------------------------------
				/**	We need to fail if no related parents were found
				/** --------------------------------------------*/
				
				if ( $query->num_rows == 0 )
				{
					$EXT->end_script	= TRUE;
					return FALSE;
				}
        
				/** --------------------------------------------
				/**	Are we doing a conjoined test?
				/** --------------------------------------------*/
				
				if ( ! empty( $conjoined_related ) )
				{
					foreach ( $query->result as $row )
					{
						$entry_array[ $row['rel_child_id'] ][]	= $row['rel_parent_id'];
					}
				
					if ( count( $entry_array ) < 2 )
					{
						$EXT->end_script	= TRUE;
						return FALSE;
					}
					
					$chosen = call_user_func_array('array_intersect', $entry_array);
					
					$sess['search']['q']['include_entry_ids']	= $chosen;
				}
				else
				{
					foreach ( $query->result as $row )
					{
						$sess['search']['q']['include_entry_ids'][$row['rel_parent_id']]	= $row['rel_parent_id'];
					}
				}
				
			}
        }
    	
    	/** --------------------------------------------
        /**	Handle exact field searching
        /** --------------------------------------------*/
        
        if ( ! empty( $sess['search']['q']['exactfield'] ) )
        {
        	$handy	=& $sess['search']['q']['exactfield'];
        
			/** --------------------------------------------
			/**	For each correct Playa field type, let's determine how the relationship is being provided to us. We accept entry id's, titles or url_titles.
			/** --------------------------------------------*/
        
        	foreach ( $fields as $key => $val )
        	{
        		$related			= array();
        		$conjoined_related	= array();
        	
				/** --------------------------------------------
				/**	Super Search stores the exact field queries in the 'or' array, just to follow the overall data model. If 'or' is not empty and it's element count is = 1 we'll search for that value.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['or'] ) )
				{
					if ( count( $handy[$key]['or'] ) == 1 )
					{
						$related	= array( $handy[$key]['or'][0] );
					}						
					else
					{
						$related	= $handy[$key]['or'];
					}
					
					unset( $handy[$key]['or'] );
				}
				
				/** --------------------------------------------
				/**	Super Search also stores conjoined exact searches in the 'and' array. We have to do a more complex search on those.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['and'] ) )
				{
					$conjoined_related	= $handy[$key]['and'];
					
					unset( $handy[$key]['and'] );
				}
        	}
			
			/** --------------------------------------------
			/**	Are Playa fields even being invoked?
			/** --------------------------------------------*/
			
			if ( empty( $related ) AND empty( $conjoined_related ) )
			{
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	Prepare arrays
			/** --------------------------------------------*/
			
			$entry_ids	= array();
			$titles		= array();
			
			foreach ( $related as $val )
			{
				if ( is_numeric( $val ) === TRUE )
				{
					$entry_ids[]	= $val;
				}
				elseif ( strpos( $val, ' ' ) === FALSE )
				{
					$titles[]	= $val;
				}
			}
			
			foreach ( $conjoined_related as $val )
			{
				if ( is_numeric( $val ) === TRUE )
				{
					$entry_ids[]	= $val;
				}
				elseif ( strpos( $val, ' ' ) === FALSE )
				{
					$titles[]	= $val;
				}
			}
			
			/** --------------------------------------------
			/**	We need to fail if the supplied related entries are bunk
			/** --------------------------------------------*/
			
			if ( empty( $entry_ids ) AND empty( $titles ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
			
			/** --------------------------------------------
			/**	Get pure entry ids
			/** --------------------------------------------*/
			
			$sql	= "SELECT entry_id
				FROM exp_weblog_titles
				WHERE weblog_id != ''
				AND (";
				
			if ( ! empty( $entry_ids ) )
			{
				$sql	.= "entry_id IN (" . implode( ',', $entry_ids ) . ")";
				
				if ( ! empty( $titles ) )
				{
					$sql	.= " OR (";
				}
			}
				
			if ( ! empty( $titles ) )
			{
				$sql	.= "url_title IN ('" . implode( "','", $titles ) . "')";
				$sql	.= " OR title IN ('" . implode( "','", $titles ) . "')";
				// $sql	.= ")";
			}
			
			$sql	.= ")";
			
			$query	= $DB->query( $sql );
			
			$related_entry_ids	= array();
			
			foreach ( $query->result as $row )
			{
				$related_entry_ids[]	= $row['entry_id'];
			}
        
			/** --------------------------------------------
			/**	If we are testing for related , we need to fail if the supplied related entries are not valid
			/** --------------------------------------------*/
			
			if ( ( ! empty( $related ) OR ! empty( $conjoined_related ) ) AND empty( $related_entry_ids ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	If we are testing for conjoined related entries, we need to fail if the number of valid entries is != the number of tested terms.
			/** --------------------------------------------*/
			
			if ( ! empty( $conjoined_related ) AND ! empty( $related_entry_ids ) AND count( $conjoined_related ) != count( $related_entry_ids ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	After validation, do we still have related entries?
			/** --------------------------------------------*/
			
			if ( ! empty( $related_entry_ids ) )
			{
				/** --------------------------------------------
				/**	Get parent entries
				/** --------------------------------------------*/
				
				$sql	= "SELECT r.rel_parent_id, r.rel_child_id
					FROM exp_relationships r
					LEFT JOIN exp_weblog_data wd ON wd.entry_id = r.rel_parent_id
					WHERE r.rel_child_id IN (" . implode( ',', $related_entry_ids ) . ")
					AND r.rel_id != wd.field_id_" . $sess['fields']['searchable'][$key];	// We need a way to know that this record in exp_relationships is being used by a playa field and not a regular EE relationship field since Brandon thought it was such a good idea to piggy back and pollute the data.
					
				$query	= $DB->query( $sql );
        
				/** --------------------------------------------
				/**	We need to fail if no related parents were found
				/** --------------------------------------------*/
				
				if ( $query->num_rows == 0 )
				{
					$EXT->end_script	= TRUE;
					return FALSE;
				}
        
				/** --------------------------------------------
				/**	Are we doing a conjoined test?
				/** --------------------------------------------*/
				
				if ( ! empty( $conjoined_related ) )
				{
					foreach ( $query->result as $row )
					{
						$entry_array[ $row['rel_child_id'] ][]	= $row['rel_parent_id'];
					}
					
					$chosen = call_user_func_array('array_intersect', $entry_array);
					
					$sess['search']['q']['include_entry_ids']	= $chosen;
				}
				else
				{
					foreach ( $query->result as $row )
					{
						$sess['search']['q']['include_entry_ids'][$row['rel_parent_id']]	= $row['rel_parent_id'];
					}
				}
				
			}
        }
    	
    	/** --------------------------------------------
        /**	We want to kill keyword searching on Playa related fields somehow.
        /** --------------------------------------------*/
        
        if ( ! empty( $sess['search']['q']['keywords'] ) )
        {
        	$handy	=& $sess['search']['q']['keywords'];
        }
    }
    
    /* End alter search for FF playa */
	
	// --------------------------------------------------------------------

	/**
	 * Alter Search for EE relationship fields
	 *
	 * @access	public
	 * @return	null
	 */
    
	function super_search_alter_search_relationship(&$ths)
    {
    	global $DB, $EXT, $SESS;
    	
    	/** --------------------------------------------
        /**	Access the Super Search session cache for convenience
        /** --------------------------------------------*/
    	
    	$sess	=& $SESS->cache['modules']['super_search'];
        	
		if ( empty( $sess['general_field_data']['searchable'] ) )
		{
			return FALSE;
		}
    	
    	/** --------------------------------------------
        /**	Handle exact field searching
        /** --------------------------------------------*/
        
        if ( ! empty( $sess['search']['q']['field'] ) )
        {
        	$handy	=& $sess['search']['q']['field'];
        	
        	$fields	= array();
        	
        	foreach ( $sess['general_field_data']['searchable'] as $field_name => $field_data )
        	{
        		if ( isset( $handy[$field_name] ) === TRUE AND ! empty( $field_data['field_type'] ) AND $field_data['field_type'] == 'rel' )
        		{
        			$fields[$field_name]	= $handy[$field_name];
        		}
        	}
        
			/** --------------------------------------------
			/**	For each correct field type, let's determine how the relationship is being provided to us. We accept entry id's or url_titles.
			/** --------------------------------------------*/
        
        	foreach ( $fields as $key => $val )
        	{
        		$related			= array();
        	
				/** --------------------------------------------
				/**	Super Search stores the exact field queries in the 'or' array, just to follow the overall data model. If 'or' is not empty and it's element count is = 1 we'll search for that value.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['or'] ) )
				{
					if ( count( $handy[$key]['or'] ) == 1 )
					{
						$related	= array( $handy[$key]['or'][0] );
					}						
					else
					{
						$related	= $handy[$key]['or'];
					}
					
					unset( $handy[$key]['or'] );
				}
        	}
			
			/** --------------------------------------------
			/**	Are Playa fields even being invoked?
			/** --------------------------------------------*/
			
			if ( empty( $related ) )
			{
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	Prepare arrays
			/** --------------------------------------------*/
			
			$entry_ids	= array();
			$titles		= array();
			
			foreach ( $related as $val )
			{
				if ( is_numeric( $val ) === TRUE )
				{
					$entry_ids[]	= $val;
				}
				else
				{
					$titles[]	= $val;
				}
			}
			
			/** --------------------------------------------
			/**	We need to fail if the supplied related entries are bunk
			/** --------------------------------------------*/
			
			if ( empty( $entry_ids ) AND empty( $titles ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
			
			/** --------------------------------------------
			/**	Get pure entry ids
			/** --------------------------------------------*/
			
			$sql	= "SELECT entry_id
				FROM exp_weblog_titles
				WHERE weblog_id != ''
				AND (";
				
			if ( ! empty( $entry_ids ) )
			{
				$sql	.= "entry_id IN (" . implode( ',', $entry_ids ) . ")";
				
				if ( ! empty( $titles ) )
				{
					$sql	.= " OR (";
				}
			}
				
			if ( ! empty( $titles ) )
			{
				foreach ( $titles as $t )
				{
					$sql	.= " url_title LIKE '%" . $DB->escape_str( str_replace( $ths->spaces, ' ', $t ) ) . "%'";
					$sql	.= " OR title LIKE '%" . $DB->escape_str( str_replace( $ths->spaces, ' ', $t ) ) . "%' OR";
				}
				
				$sql	= rtrim( $sql, 'OR' );
			}
			
			$sql	.= ")";
			
			$query	= $DB->query( $sql );
			
			$related_entry_ids	= array();
			
			foreach ( $query->result as $row )
			{
				$related_entry_ids[]	= $row['entry_id'];
			}
        
			/** --------------------------------------------
			/**	If we are testing for related , we need to fail if the supplied related entries are not valid
			/** --------------------------------------------*/
			
			if ( ! empty( $related ) AND empty( $related_entry_ids ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	After validation, do we still have related entries?
			/** --------------------------------------------*/
			
			if ( ! empty( $related_entry_ids ) AND ! empty( $sess['fields']['searchable'][$key] ) )
			{
				/** --------------------------------------------
				/**	Get parent entries 
				/** --------------------------------------------*/
				
				$sql	= "SELECT r.rel_parent_id, r.rel_child_id
					FROM exp_relationships r
					LEFT JOIN exp_weblog_data wd ON wd.entry_id = r.rel_parent_id
					WHERE r.rel_child_id IN (" . implode( ',', $related_entry_ids ) . ")
					AND r.rel_id = wd.field_id_" . $sess['fields']['searchable'][$key];
					
				$query	= $DB->query( $sql );
        
				/** --------------------------------------------
				/**	We need to fail if no related parents were found
				/** --------------------------------------------*/
				
				if ( $query->num_rows == 0 )
				{
					$EXT->end_script	= TRUE;
					return FALSE;
				}
				
				foreach ( $query->result as $row )
				{
					$sess['search']['q']['include_entry_ids'][$row['rel_parent_id']]	= $row['rel_parent_id'];
				}				
			}
        }
    	
    	/** --------------------------------------------
        /**	Handle exact field searching
        /** --------------------------------------------*/
        
        if ( ! empty( $sess['search']['q']['exactfield'] ) )
        {
        	$handy	=& $sess['search']['q']['exactfield'];
        	
        	$fields	= array();
        	
        	foreach ( $sess['general_field_data']['searchable'] as $field_name => $field_data )
        	{
        		if ( isset( $handy[$field_name] ) === TRUE AND ! empty( $field_data['field_type'] ) AND $field_data['field_type'] == 'rel' )
        		{
        			$fields[$field_name]	= $handy[$field_name];
        		}
        	}
        
			/** --------------------------------------------
			/**	For each correct Playa field type, let's determine how the relationship is being provided to us. We accept entry id's or url_titles.
			/** --------------------------------------------*/
        
        	foreach ( $fields as $key => $val )
        	{
        		$related			= array();
        	
				/** --------------------------------------------
				/**	Super Search stores the exact field queries in the 'or' array, just to follow the overall data model. If 'or' is not empty and it's element count is = 1 we'll search for that value.
				/** --------------------------------------------*/
			
				if ( ! empty( $handy[$key]['or'] ) )
				{
					if ( count( $handy[$key]['or'] ) == 1 )
					{
						$related	= array( $handy[$key]['or'][0] );
					}						
					else
					{
						$related	= $handy[$key]['or'];
					}
					
					unset( $handy[$key]['or'] );
				}
        	}
			
			/** --------------------------------------------
			/**	Are Playa fields even being invoked?
			/** --------------------------------------------*/
			
			if ( empty( $related ) )
			{
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	Prepare arrays
			/** --------------------------------------------*/
			
			$entry_ids	= array();
			$titles		= array();
			
			foreach ( $related as $val )
			{
				if ( is_numeric( $val ) === TRUE )
				{
					$entry_ids[]	= $val;
				}
				else
				{
					$titles[]	= $val;
				}
			}
			
			/** --------------------------------------------
			/**	We need to fail if the supplied related entries are bunk
			/** --------------------------------------------*/
			
			if ( empty( $entry_ids ) AND empty( $titles ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
			
			/** --------------------------------------------
			/**	Get pure entry ids
			/** --------------------------------------------*/
			
			$sql	= "SELECT entry_id
				FROM exp_weblog_titles
				WHERE weblog_id != ''
				AND (";
				
			if ( ! empty( $entry_ids ) )
			{
				$sql	.= "entry_id IN (" . implode( ',', $entry_ids ) . ")";
				
				if ( ! empty( $titles ) )
				{
					$sql	.= " OR (";
				}
			}
				
			if ( ! empty( $titles ) )
			{
				$sql	.= "url_title IN ('" . str_replace( $ths->spaces, ' ', implode( "','", $titles ) ) . "')";
				$sql	.= " OR title IN ('" . str_replace( $ths->spaces, ' ', implode( "','", $titles ) ) . "')";
				// $sql	.= ")";
			}
			
			$sql	.= ")";
			
			$query	= $DB->query( $sql );
			
			$related_entry_ids	= array();
			
			foreach ( $query->result as $row )
			{
				$related_entry_ids[]	= $row['entry_id'];
			}
        
			/** --------------------------------------------
			/**	If we are testing for related , we need to fail if the supplied related entries are not valid
			/** --------------------------------------------*/
			
			if ( ! empty( $related ) AND empty( $related_entry_ids ) )
			{
				$EXT->end_script	= TRUE;
				return FALSE;
			}
        
			/** --------------------------------------------
			/**	After validation, do we still have related entries?
			/** --------------------------------------------*/
			
			if ( ! empty( $related_entry_ids ) AND ! empty( $sess['fields']['searchable'][$key] ) )
			{
				/** --------------------------------------------
				/**	Get parent entries 
				/** --------------------------------------------*/
				
				$sql	= "SELECT r.rel_parent_id, r.rel_child_id
					FROM exp_relationships r
					LEFT JOIN exp_weblog_data wd ON wd.entry_id = r.rel_parent_id
					WHERE r.rel_child_id IN (" . implode( ',', $related_entry_ids ) . ")
					AND r.rel_id = wd.field_id_" . $sess['fields']['searchable'][$key];
					
				$query	= $DB->query( $sql );
        
				/** --------------------------------------------
				/**	We need to fail if no related parents were found
				/** --------------------------------------------*/
				
				if ( $query->num_rows == 0 )
				{
					$EXT->end_script	= TRUE;
					return FALSE;
				}
				
				foreach ( $query->result as $row )
				{
					$sess['search']['q']['include_entry_ids'][$row['rel_parent_id']]	= $row['rel_parent_id'];
				}				
			}
        }
    }
    
    /* End alter search for EE relationship fields */
		
	// --------------------------------------------------------------------

	/**
	 * Activate Extension
	 *
	 * A required method that we actually ignore because this extension is installed by its module
	 * and no other place.  If they want the extension enabled, they have to install the module.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function activate_extension()
    {
		global $OUT, $LANG;
    	
    	return $OUT->show_user_error('general', str_replace('%url%', 
    														BASE.AMP.'C=modules',
    														$LANG->line('enable_module_to_enable_extension')));
	}
	/* END activate_extension() */
	
	// --------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * A required method that we actually ignore because this extension is installed by its module
	 * and no other place.  If they want the extension disabled, they have to uninstall the module.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function disable_extension()
    {
    	global $OUT, $LANG;
    	
    	return $OUT->show_user_error('general', str_replace('%url%', 
    														BASE.AMP.'C=modules',
    														$LANG->line('disable_module_to_disable_extension')));
	}
	/* END disable_extension() */
	
	// --------------------------------------------------------------------

	/**
	 * Update Extension
	 *
	 * A required method that we actually ignore because this extension is updated by its module
	 * and no other place.  We cannot redirect to the module upgrade script because we require a 
	 * confirmation dialog, whereas extensions were designed to update automatically as they will try
	 * to call the update script on both the User and CP side.
	 *
	 * @access	public
	 * @return	null
	 */
    
	function update_extension()
    {
    
	}
	/* END update_extension() */
	
	// --------------------------------------------------------------------
	

	/**
	 * Error Page
	 *
	 * @access	public
	 * @param	string	$error	Error message to display
	 * @return	null
	 */
	
	function error_page($error = '')
	{
		global $EXT, $OUT, $DSP, $FNS, $LANG;
		
		$this->cached_vars['error_message'] = $error;
		
		$this->cached_vars['page_title'] = $LANG->line('error');
		
		/** -------------------------------------
		/**  Output
		/** -------------------------------------*/
		
		$this->ee_cp_view('error_page.html');
	}
	/* END error_page() */
	
	
	// --------------------------------------------------------------------
	

	/**
	 * Allowed Ability for Group
	 *
	 * @access	public
	 * @param	string	$which	Name of permission
	 * @return	bool
	 */
	
	function allowed_group($which = '')
	{
		if ($which == '')
		{
			return FALSE;
		}   
        // Super Admins always have access
                    
		if ($this->sess->userdata['group_id'] == 1)
		{
			return TRUE;
		}
		
		if ( !isset($this->sess->userdata[$which]) OR $this->sess->userdata[$which] !== 'y')
			return FALSE;
		else
			return TRUE;
	}
	/* END allowed_group() */
	
}
/* END Class Super_search_extension */