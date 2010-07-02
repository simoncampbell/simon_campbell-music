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
 * Super Search Module Class
 *
 * Handles template level functions
 *
 * @package		Solspace:Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @see			http://www.solspace.com/docs/
 * @location 	./system/modules/super_search/mod.super_search.php
 */ 

require_once PATH.'hermes/lib/addon_builder/module_builder.php';

class Super_search extends Module_builder
{
    var $TYPE;
    
    var $disable_caching	= FALSE;
    var $disable_history	= FALSE;
	var $cache_overridden	= FALSE;
	var $relevance_count_words_within_words	= FALSE;
	
	var $minlength		= array( 3, 20000 );	// Searches on keywords that are too small return too many results. We force a limit on the DB query in those cases. First element is the minimum keyword length, second element is the limit we impose.
	
	var $wminlength		= array( 3, 500 );	//	Same as above except that the limits when using weblog:entries are much lower.
	
	var $hash			= '';
	
	var $history_id		= 0;
	
	var $ampmarker		= '98lk78543fgd9';
	var $negatemarker	= '87urnegate09u8';
	var $modifier_separator	= '-';
	var $parse_switch	= '';
	var $parser			= '&';
	var $separator		= '=';
	var $slash			= 'SLASH';
	var $spaces			= '+';
	
	var $cur_page		= 0;
	var $current_page	= 0;
	var $limit			= 100;
	var $total_pages	= 0;
	var $page_count		= '';
	var $pager			= '';
	var $paginate		= FALSE;
	var $paginate_data	= '';
	var	$res_page		= '';
	var $urimarker		= 'jhgkjkajkmjksjkrlr3409oiu';

	var $arrays		= array();	// Enables a URI to contain multiple parameters of the same type in an array manner
	var $basic		= array( 'author', 'category', 'categorylike', 'exclude_entry_ids', 'group', 'include_entry_ids', 'keywords', 'limit', 'allow_repeats', 'num', 'order', 'start', 'status', 'tag', 'channel' );	// Tests for simple parameters. Note that some are aliases such as limit as an alias of num.	
	
	var $common		= array( 'a', 'and', 'of', 'or', 'the' );
	var $searchable_wt	= array( 'title' );	// We allow field and exact field searching on some of the columns in exp_weblog_titles.
	var $sess		= array();
	
	var $_buffer = array(); // Cut and Paste Buffer
	var $marker  = '';		// Cut and Paste Marker

    // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	null
	 */
	 
	function Super_search()
	{
		global $DB, $SESS;
		
		parent::Module_builder('super_search');
        
        /** -------------------------------------
		/**  Module Installed and Up to Date?
		/** -------------------------------------*/
			
		if ($this->database_version() == FALSE)
		{
			return;
		}
		elseif($this->version_compare($this->database_version(), '<', SUPER_SEARCH_VERSION))
		{
			//$this->super_search_module_update();
		}
        
        /** -------------------------------------
		/** Prepare for $SESS->cache
		/** -------------------------------------*/
		
		if ( isset( $SESS->cache['modules']['super_search'] ) === FALSE )
		{
			$SESS->cache['modules']['super_search']	= array();
		}
		
		$this->sess	=& $SESS->cache['modules']['super_search'];
	}
	
	/* END Super search constructor */

    // --------------------------------------------------------------------

	/**
	 * Cache
	 *
	 * @access	private
	 * @return	boolean
	 */
	 
	function _cache( $q = array(), $ids = array(), $results = 0, $type = 'q' )
	{
		global $DB, $LOC, $PREFS;

		if ( empty( $q ) === TRUE ) return FALSE;
		if ( $this->disable_caching === TRUE ) return FALSE;
		
		$q	= ( empty( $q['q'] ) ) ? array(): $q['q'];
		
		$this->hash	= ( $this->hash == '' ) ? $this->_hash_it( $q ): $this->hash;
		
		if ( ( $cache = $this->sess( 'searches', $this->hash ) ) !== FALSE ) return $cache;
		
		$ids		= ( empty( $ids ) === TRUE ) ? '': $this->_cerealize( $ids );
		
		$results	= ( $results == 0 ) ? count( $ids ): $results;
		
		$q	= base64_encode( serialize( $q ) );
		
		$cache_id	= 0;
		
		if ( $this->data->caching_is_enabled() === TRUE )
		{			
			$sql	= $DB->insert_string(
				'exp_super_search_cache',
				array(
					'type'		=> $type,
					'hash'		=> $this->hash,
					'date'		=> $LOC->now,
					'results'	=> $results,
					'query'		=> $q,
					'ids'		=> $ids
					)
				);
				
			$sql	.= " /* Super Search mod.super_search.php _cache() */";
			
			$DB->query( $sql );
			
			$cache_id	= $DB->insert_id;
		}
		
		$this->_save_search_to_history( $cache_id, $results, $q );

		$this->sess['searches'][$this->hash]	= $ids;
		
		return TRUE;
	}
	
	/*	End cache */

    // --------------------------------------------------------------------

	/**
	 * Cached?
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _cached( $hash = '', $type = 'q' )
	{
		global $DB;

		if ( $this->disable_caching === TRUE ) return FALSE;
		if ( is_string( $hash ) === FALSE OR $hash == '' ) return FALSE;
		if ( $this->data->caching_is_enabled() === FALSE ) return FALSE;
		
		if ( ( $cache = $this->sess( 'searches', $hash ) ) !== FALSE )
		{
			return $cache;
		}
		
		$this->_clear_cached();
		
		$sql	= "/* Super Search cache check */ SELECT cache_id, query, results, ids FROM exp_super_search_cache WHERE hash = '".$DB->escape_str( $hash )."' LIMIT 1";
		
		$query	= $DB->query( $sql );
		
		if ( $query->num_rows > 0 )
		{
			$cache	= ( $query->row['ids'] == '' ) ? array(): $this->_uncerealize( $query->row['ids'] );

			$this->sess['searches'][$hash]	= $cache;
			$this->sess['results']			= $query->row['results'];
			
			$this->_save_search_to_history( $query->row['cache_id'], $query->row['results'],  $query->row['query'] );
			
			return $cache;
		}
		
		return FALSE;
	}
	
	/*	End cached? */

    // --------------------------------------------------------------------

	/**
	 * Cerealize
	 *
	 * serialize() and unserialize() add a bunch of characters that are not needed when storing a one dimensional indexed array. Why not just use a pipe?
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _cerealize( $arr = array() )
	{
		if ( count( $arr ) == 1 ) return array_pop( $arr );
		return implode( '|', $arr );
	}
	
	/* End cerealize */

    // --------------------------------------------------------------------

	/**
	 * Chars decode
	 *
	 * Preps a string from oddball EE character conversions
	 *
	 * @access	private
	 * @return	str
	 */
    
    function _chars_decode( $str = '' )
    {
    	if ( $str == '' ) return;
    	
    	if ( function_exists( 'htmlspecialchars_decode' ) === TRUE )
    	{
    		$str	= htmlspecialchars_decode( $str );
    	}
    	
    	if ( function_exists( 'html_entity_decode' ) === TRUE )
    	{
    		$str	= html_entity_decode( $str );
    	}
    	
    	$str	= str_replace( array( '&amp;', '&#47;', '&#39;', '\'' ), array( '&', '/', '', '' ), $str );
    	
    	$str	= stripslashes( $str );
    	
    	return $str;
    }
    
    /*	End chars decode */

    // --------------------------------------------------------------------

	/**
	 * Check template params
	 *
	 * This method allows people to force params onto and override our query from template params
	 *
	 * @access	private
	 * @return	str
	 */
	 
	function _check_tmpl_params( $key = '', $q = array() )
	{
		global $TMPL;
		
		if ( $key == '' ) return $q;

		/**	----------------------------------------
		/**	We completely skip some template params.
		/**	----------------------------------------*/

		if ( in_array( $key, array( 'order' ) ) === TRUE ) return $q;

		/**	----------------------------------------
		/**	We allow some dynamic params to override template params.
		/**	----------------------------------------*/
		
		if ( in_array( $key, array( 'limit', 'num', 'start' ) ) === TRUE AND empty( $q[$key] ) === FALSE )
		{
			return $q;
		}
		
		if ( $TMPL->fetch_param($key) !== FALSE AND $TMPL->fetch_param($key) != '' )
		{
			$q[$key]	= $TMPL->fetch_param($key);
		}
		
		if ( isset( $q[$key] ) AND strpos( $q[$key], '&&' ) !== FALSE )
		{
			$q[$key]	= str_replace( '&&', $this->ampmarker, $q[$key] );
		}
		
		if ( isset( $q[$key] ) === TRUE AND ( strpos( $q[$key], $this->slash ) !== FALSE OR strpos( $q[$key], SLASH ) !== FALSE ) )
		{
			$q[$key]	= str_replace( array( $this->slash, SLASH ), '/', $q[$key] );
		}

		/**	----------------------------------------
		/**	We convert the negation marker, which is a dash, to something obscure so that regular dashes in words do not create problems.
		/**	----------------------------------------*/
		
		if ( isset( $q[$key] ) AND strpos( $q[$key], '-' ) === 0 )
		{
			$q[$key]	= $this->separator.$this->negatemarker . trim( $q[$key], '-' );
		}
		
		if ( $key == 'order' AND empty( $q['order'] ) === FALSE )
		{
			$q['order']	= $this->_prep_order( $q['order'] );
		}
		
		return $q;
	}
	
	/*	End check template params */

    // --------------------------------------------------------------------

	/**
	 * Clean numeric fields
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _clean_numeric_fields( $arr = array() )
	{
		/**	----------------------------------------
		/**	For each field...
		/**	----------------------------------------*/
		
		foreach ( array_keys( $arr ) as $key )
		{
			/**	----------------------------------------
			/**	For each element
			/**	----------------------------------------*/
		
			foreach ( $arr[$key] as $k => $v )
			{
				/**	----------------------------------------
				/**	If field expects numeric, try to convert punctuation. This is also the place to handle European monetary formats, but later.
				/**	----------------------------------------*/
			
				if ( $this->_get_field_type( $key ) !== FALSE AND $this->_get_field_type( $key ) == 'numeric' )
				{
					$arr[$key][$k]	= str_replace( array( ',', '$' ), '', $v );
				}
			}
		}
		
		return $arr;
	}
	
	/*	End clean numeric fields */

    // --------------------------------------------------------------------

	/**
	 * Clear cached
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _clear_cached()
	{
		global $DB, $LOC, $PREFS;
		
		if ( $this->sess( 'cleared' ) !== FALSE ) return FALSE;
		
		/**	----------------------------------------
		/**	Should we refresh cache? Have we cleared it recently?
		/**	----------------------------------------*/
		
		if ( $this->data->time_to_refresh_cache( $PREFS->ini( 'site_id' ) ) === FALSE )
		{
			$this->sess['cleared']	= TRUE;
			return FALSE;
		}
		
		/**	----------------------------------------
		/**	Clear cache now
		/**	----------------------------------------*/
		
		do
		{
			$DB->query(
				"DELETE FROM exp_super_search_cache
				WHERE date < ".( $LOC->now - ( $this->data->get_refresh_by_site_id( $PREFS->ini( 'site_id' ) ) * 60 ) )."
				LIMIT 1000 /* Super Search delete cache */"
			);
		} 
		while ( $DB->affected_rows == 1000 );
		
		do
		{			
			$DB->query(
				"DELETE FROM exp_super_search_history
				WHERE search_date < ".( $LOC->now - ( 60 * 60 ) )."
				AND saved = 'n'
				AND cache_id NOT IN (
					SELECT cache_id
					FROM exp_super_search_cache
				)
				LIMIT 1000 /* Super Search clear search history */"
			);
		} 
		while ( $DB->affected_rows == 1000 );
		
		$this->data->set_new_refresh_date( $PREFS->ini( 'site_id' ) );        
		$hash	= $this->data->_imploder( array( $PREFS->ini( 'site_id' ) ) );		
		$this->data->cached['time_to_refresh_cache'][ $hash ] = FALSE;
		$this->sess['cleared']	= TRUE;
	}
	
	/*	End clear cached */
	
	// --------------------------------------------------------------------

	/**
	 *	Removes/Cuts A Piece of Content Out of String to Save it From Being Manipulated During a Find/Replace
	 *
	 *  Many thanks to gosha bine ("http://tagarga.com/blok/on/080307") for the code, it is rather brilliantly executed. -Paul
	 *
	 *	@access		public
	 *	@param		string
	 *	@param		bool|string
	 *	@return		string
	 */
    
	function cut($subject, $regex = FALSE)
    {
        if (is_array($subject))
        {
        	$this->_buffer[md5($subject[0])] = $subject[0];
        	return ' '.$this->marker.md5($subject[0]).$this->marker.' ';
       	}
       	
       	return preg_replace_callback($regex, array(&$this, 'cut'), $subject);
    }
    
    /* END cut() */

    // --------------------------------------------------------------------

	/**
	 * Do search
	 *
	 * One of the main principles in Super Search is that MySQL performance is better with a greater number of simpler queries rather than a lesser numbers of queries but of greater complexity.
	 *
	 * Performance note: see notes on new_do_search. Table joins in our current case prevent us from taking good advantage of query caching and they are also generally slower, by half! Nice!
	 *
	 * @access	public
	 * @return	array
	 */
	 
	function do_search_wt_wd( $q = array() )
	{
		global $DB, $EXT, $LOC, $TMPL;
		
		if ( is_array( $q ) === FALSE OR count( $q ) == 0 ) return FALSE;
		
		$t	= microtime(TRUE);
		
		$TMPL->log_item( 'Super Search: Starting do_search()' );
		$TMPL->log_item( 'Super Search: Starting prep query' );
		
        /** -------------------------------------
		/**	Begin SQL
		/** -------------------------------------*/
		
		$select	= '/* Super Search wt/wd search */ SELECT t.entry_id';
		$from	= ' FROM exp_weblog_titles t LEFT JOIN exp_weblog_data wd ON wd.entry_id = t.entry_id';
		$where	= ' WHERE t.entry_id != 0 ';
		$and	= array();
		$not	= array();
		$or		= array();
		$subids	= array();
		
        /** -------------------------------------
		/**	Show future?
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('show_future_entries') === FALSE OR $TMPL->fetch_param('show_future_entries') != 'yes' )
		{
			$where	.= ' AND t.entry_date < '.$LOC->now;
		}
		
        /** -------------------------------------
		/**	Show expired?
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('show_expired') === FALSE OR $TMPL->fetch_param('show_expired') != 'yes' )
		{
			$where	.= ' AND (t.expiration_date = 0 OR t.expiration_date > '.$LOC->now.')';
		}
		
        /** -------------------------------------
		/**	Prep site ids
		/** -------------------------------------*/
		
		$this->sess['search']['q']['site_id']	= $TMPL->site_ids;
		
        /** -------------------------------------
		/**	Prep weblog AKA channel
		/** -------------------------------------*/
		
		$q['channel']	= ( isset( $q['channel'] ) === TRUE ) ? $q['channel']: '';
		$this->sess['search']['q']['channel']	= $this->_prep_keywords( $q['channel'] );
	
		/** -------------------------------------
		/**	If we can't find valid weblogs, we need to fail out.
		/** -------------------------------------*/
		
		if ( ( $this->sess['search']['q']['weblog_ids'] = $this->_prep_weblog( $q['channel'] ) ) === FALSE )
		{
			unset( $weblog_ids );
			return FALSE;
		}
		
        /** -------------------------------------
		/**	Prep status
		/** -------------------------------------*/
		
		if ( isset( $q['status'] ) === TRUE )
		{
			$this->sess['search']['q']['status']	= $this->_prep_keywords( $q['status'] );
		}
		
        /** -------------------------------------
		/**	Prep keywords
		/** -------------------------------------*/
		
		if ( isset( $q['keywords'] ) === TRUE )
		{
			$this->sess['search']['q']['keywords']	= $this->_prep_keywords( $q['keywords'] );
		}
		
        /** -------------------------------------
		/**	Prep fields
		/** -------------------------------------*/
		
		if ( isset( $q['field'] ) === TRUE )
		{
			foreach ( $q['field'] as $field => $val )
			{
				if ( $val == '' ) continue;
				$fields[$field] = $this->_prep_keywords( $val );
			}

			$this->sess['search']['q']['field']	= $fields;
		}
		
        /** -------------------------------------
		/**	Prep exact fields
		/** -------------------------------------*/
		
		if ( isset( $q['exactfield'] ) === TRUE )
		{
			$exactfields	= array();
			$temp			= array();
		
			foreach ( $q['exactfield'] as $field => $val )
			{
				if ( $val == '' ) continue;
				
				if ( is_array( $val ) === TRUE )
				{
					foreach ( $val as $v )
					{
						if ( strpos( $v, $this->negatemarker ) === FALSE )
						{
							$exactfields[$field]['or'][] = $DB->escape_str( trim( $v, "'\"" ) );	// We strip quotes out
						}
						else
						{
							$exactfields[$field]['not'][] = $DB->escape_str( trim( str_replace( $this->negatemarker, '', $v ), "'\"" ) );	// We strip quotes out
						}
					}
				}
				else
				{				
					if ( strpos( $val, $this->ampmarker ) !== FALSE )
					{
						if ( strpos( $val, $this->ampmarker . '-' ) !== FALSE )
						{
							$val	= str_replace( $this->ampmarker . '-', $this->ampmarker . $this->negatemarker, $val );
						}
						
						$temp	= explode( $this->ampmarker, $DB->escape_str( trim( $val, "'\"" ) ) );	// We strip quotes out
					}
					elseif ( strpos( $val, $this->negatemarker ) !== FALSE )
					{
						$exactfields[$field]['not'][] = $DB->escape_str( trim( str_replace( $this->negatemarker, '', $val ), "'\"" ) );	// We strip quotes out
					}
					else
					{
						$exactfields[$field]['or'][] = $DB->escape_str( trim( $val, "'\"" ) );	// We strip quotes out
					}
				}

				/** -------------------------------------
				/**	We don't use the conjoin capability in the module proper, but there are extensions that might like to know when someone is doing a conjoined exact field search. Playa, for example, which is supported in the native Super Search extension.
				/** -------------------------------------*/
				
				if ( ! empty( $temp ) )
				{
					foreach ( $temp as $t )
					{
						if ( strpos( $t, $this->negatemarker ) !== FALSE )
						{
							$exactfields[$field]['not'][] = $DB->escape_str( trim( str_replace( $this->negatemarker, '', $t ), "'\"" ) );	// We strip quotes out
						}
						else
						{
							$exactfields[$field]['and'][] = $DB->escape_str( trim( $t, "'\"" ) );	// We strip quotes out
						}
					}
				}
			}

			$this->sess['search']['q']['exactfield']	= $exactfields;
		}
		
        /** -------------------------------------
		/**	Prep empty fields
        /** -------------------------------------
        /*	People can search for fields whose value is empty.
		/** -------------------------------------*/
		
		if ( isset( $q['empty'] ) === TRUE )
		{
			$emptyfields	= array();
			
			foreach ( $q['empty'] as $field => $val )
			{
				if ( $val == '' OR strpos( $val, $this->spaces ) !== FALSE ) continue;
				$emptyfields[$field]['and'] = $val;
			}
			
			$emptyfields	= $this->_remove_empties( $emptyfields );
			
			asort( $emptyfields );
			$emptyfields	= $this->_clean_numeric_fields( $emptyfields );
			$this->sess['search']['q']['empty']	= $emptyfields;
		}
		
        /** -------------------------------------
		/**	Prep from fields
        /** -------------------------------------
        /*	People can search for fields whose value is greater than or equal to a value.
		/** -------------------------------------*/
		
		if ( isset( $q['from'] ) === TRUE )
		{
			$fromfields	= array();
			
			foreach ( $q['from'] as $field => $val )
			{
				if ( $val == '' OR strpos( $val, $this->spaces ) !== FALSE ) continue;
				$fromfields[$field]['and'] = $val;
			}
			
			$fromfields	= $this->_remove_empties( $fromfields );
			
			asort( $fromfields );
			$fromfields	= $this->_clean_numeric_fields( $fromfields );
			$this->sess['search']['q']['from']	= $fromfields;
		}
		
        /** -------------------------------------
		/**	Prep to fields
        /** -------------------------------------
        /*	People can search for fields whose value is less than or equal to a value.
		/** -------------------------------------*/
		
		if ( isset( $q['to'] ) === TRUE )
		{
			$tofields	= array();
			
			foreach ( $q['to'] as $field => $val )
			{
				if ( $val == '' OR strpos( $val, $this->spaces ) !== FALSE ) continue;
				$tofields[$field]['and'] = $val;
			}
			
			$tofields	= $this->_remove_empties( $tofields );
			
			asort( $tofields );
			$tofields	= $this->_clean_numeric_fields( $tofields );
			$this->sess['search']['q']['to']	= $tofields;
		}
		
        /** -------------------------------------
		/**	Prep 'from date'
        /** -------------------------------------
        /*	People can search for entries from a certain date. 20090601 = June 1, 2009. 20090601053020 = 5:30 am and 20 seconds June 1, 2009.
		/** -------------------------------------*/
		
		if ( isset( $q['datefrom'] ) === TRUE )
		{
			$this->sess['search']['q']['datefrom']	= $q['datefrom'];
		}
		
        /** -------------------------------------
		/**	Prep 'to date'
        /** -------------------------------------
        /*	People can search for entries to a certain date. 20090601 = June 1, 2009. 20090601053020 = 5:30 am and 20 seconds June 1, 2009.
		/** -------------------------------------*/
		
		if ( isset( $q['dateto'] ) === TRUE )
		{
			$this->sess['search']['q']['dateto']	= $q['dateto'];
		}
		
        /** -------------------------------------
		/**	Prep categories
		/** -------------------------------------*/
		
		if ( isset( $q['category'] ) === TRUE )
		{
			$this->sess['search']['q']['category']	= $this->_prep_keywords( $q['category'] );
		}
		
        /** -------------------------------------
		/**	Prep loose categories
		/** -------------------------------------*/
		
		if ( isset( $q['categorylike'] ) === TRUE )
		{
			$this->sess['search']['q']['categorylike']	= $this->_prep_keywords( $q['categorylike'] );
		}
		
        /** -------------------------------------
		/**	Prep author
		/** -------------------------------------*/
		
		if ( isset( $q['author'] ) === TRUE )
		{
			$this->sess['search']['q']['author']	= $this->_prep_keywords( $q['author'] );
		}
		
        /** -------------------------------------
		/**	Prep member group
		/** -------------------------------------*/
		
		if ( isset( $q['group'] ) === TRUE )
		{
			$this->sess['search']['q']['group']	= $this->_prep_keywords( $q['group'] );
		}
		
        /** -------------------------------------
		/**	Prep include entry ids
		/** -------------------------------------*/
		
		if ( isset( $q['include_entry_ids'] ) === TRUE )
		{
			$include_entry_ids	= $this->_only_numeric( explode( '|', $q['include_entry_ids'] ) );
			sort( $include_entry_ids );
			$this->sess['search']['q']['include_entry_ids']	= $include_entry_ids;
		}
		
        /** -------------------------------------
		/**	Prep exclude entry ids
		/** -------------------------------------*/
		
		if ( isset( $q['exclude_entry_ids'] ) === TRUE )
		{
			$exclude_entry_ids	= $this->_only_numeric( explode( '|', $q['exclude_entry_ids'] ) );
			sort( $exclude_entry_ids );
			$this->sess['search']['q']['exclude_entry_ids']	= $exclude_entry_ids;
		}
		
        /** -------------------------------------
		/**	Exclude entries already found in previous calls to Super Search during the same session.
		/** -------------------------------------*/
		
		if ( isset( $q['allow_repeats'] ) === TRUE AND $q['allow_repeats'] == 'no' AND ! empty( $this->sess['previous_entries'] ) )
		{
			$previous_entries	= $this->_only_numeric( $this->sess['previous_entries'] );
			sort( $previous_entries );
			$this->sess['search']['q']['previous_entries']	= $previous_entries;
			
			if ( ! empty( $this->sess['search']['q']['exclude_entry_ids'] ) )
			{
				$this->sess['search']['q']['exclude_entry_ids']	= array_merge( $this->sess['search']['q']['exclude_entry_ids'], $previous_entries );
			}
			else
			{
				$this->sess['search']['q']['exclude_entry_ids']	= $previous_entries;
			}
		}

		/**	----------------------------------------
		/**	'super_search_alter_search' hook.
		/**	----------------------------------------
		/*	All the arguments are saved to the $SESS->cache, read and write to that array.
		/**	----------------------------------------*/
		
		if ($EXT->active_hook('super_search_alter_search') === TRUE)
		{
			$edata = $EXT->call_extension('super_search_alter_search', $this);
			if ($EXT->end_script === TRUE) return FALSE;
		}
		
		$TMPL->log_item( 'Super Search: Ending prep query('.(microtime(TRUE) - $t).')' );
		
        /** -------------------------------------
		/**	Do we have a valid search?
		/** -------------------------------------*/
		
		if ( ( $this->sess( 'search', 'q' ) ) === FALSE )
		{
			return FALSE;
		}
		
        /** -------------------------------------
		/**	Prep order here so that it's part of the cache
		/** -------------------------------------*/
		
		$order	= ' ORDER BY t.sticky DESC, t.entry_date DESC, t.entry_id DESC';
		
		if ( ( $neworder = $this->sess( 'uri', 'order') ) !== FALSE )
		{
			$order	= $this->_prep_order( $neworder );
		}
		elseif ( $TMPL->fetch_param('order') !== FALSE AND $TMPL->fetch_param('order') != '' )
		{
			$order	= $this->_prep_order( $TMPL->fetch_param('order') );
		}
		
		$this->sess['search']['q']['order']	= $order;
		
        /** -------------------------------------
		/**	Prep relevance to be part of cache as well
		/** -------------------------------------*/
		
		$this->sess['search']['q']['relevance'] = $this->_prep_relevance();
		
        /** -------------------------------------
		/**	Cached?
		/** -------------------------------------*/
		
		if ( ( $ids = $this->_cached( $this->_hash_it( $this->sess( 'search' ) ) ) ) !== FALSE )
		{
			$TMPL->log_item( 'Super Search: Ending cached do_search('.(microtime(TRUE) - $t).')' );
		
			if ( empty( $ids ) === TRUE )
			{
				return FALSE;
			}
			
			if ( is_string( $ids ) === TRUE )
			{
				$ids	= explode( "|", $ids );
			}
			
			return $ids;
		}
		
        /** -------------------------------------
		/**	Are we working with categories?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['category'] ) === FALSE )
		{
			if ( ( $tempids = $this->_get_ids_by_category( $this->sess['search']['q']['category'] ) ) !== FALSE )
			{
				$subids	= array_merge( $subids, $tempids );
			}
			
			/** -------------------------------------
			/**	Test category conditions
			/** -------------------------------------
			/**	If we're checking for categories with either 'or' or 'and' and we receive nothing back, we have to fail here.
			/** -------------------------------------*/
			
			if ( empty( $tempids ) === TRUE )
			{
				if ( empty( $this->sess['search']['q']['category']['and'] ) === FALSE OR empty( $this->sess['search']['q']['category']['or'] ) === FALSE )
				{
					$this->_cache( $this->sess( 'search' ), '', 0 );
					return FALSE;
				}
			}
		}
		
        /** -------------------------------------
		/**	Are we working with loose categories?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['categorylike'] ) === FALSE )
		{
			if ( ( $tempids = $this->_get_ids_by_category_like( $this->sess['search']['q']['categorylike'] ) ) !== FALSE )
			{
				$subids	= array_merge( $subids, $tempids );
			}
			
			/** -------------------------------------
			/**	Test category conditions
			/** -------------------------------------
			/**	If we're checking for categories with either 'or' or 'and' and we receive nothing back, we have to fail here.
			/** -------------------------------------*/
			
			if ( empty( $tempids ) === TRUE )
			{
				if ( empty( $this->sess['search']['q']['categorylike']['or'] ) === FALSE )
				{
					$this->_cache( $this->sess( 'search' ), '', 0 );
					return FALSE;
				}
			}
		}
		
        /** -------------------------------------
		/**	Are we looking for authors?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['author'] ) === FALSE )
		{
			/** -------------------------------------
			/**	No authors?
			/** -------------------------------------
			/*	If we were looking for authors and we found none in the DB by the names provided, we have to fail out right here.
			/** -------------------------------------*/
		
			if ( ( $author = $this->_prep_author( $this->sess['search']['q']['author'] ) ) === FALSE )
			{
				$this->_cache( $this->sess( 'search' ), '', 0 );
				return FALSE;
			}
			
			$and[]	= 't.author_id IN ('.implode( ',', $author ).')';
		}
		
        /** -------------------------------------
		/**	Are we looking for member groups?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['group'] ) === FALSE )
		{
			/** -------------------------------------
			/**	No groups?
			/** -------------------------------------
			/*	If we were looking for groups and we found none in the DB by the names provided, we have to fail out right here.
			/** -------------------------------------*/
		
			if ( ( $group = $this->_prep_group( $this->sess['search']['q']['group'] ) ) === FALSE )
			{
				$this->_cache( $this->sess( 'search' ), '', 0 );
				return FALSE;
			}
			
			$and[]	= 't.author_id IN ('.implode( ',', $group ).')';
		}
		
        /** -------------------------------------
		/**	Are we looking to include entry ids?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['include_entry_ids'] ) === FALSE )
		{			
			$and[]	= 't.entry_id IN ('.implode( ',', $this->sess['search']['q']['include_entry_ids'] ).')';
		}
		
        /** -------------------------------------
		/**	Are we looking to exclude entry ids?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['exclude_entry_ids'] ) === FALSE )
		{			
			$and[]	= 't.entry_id NOT IN ('.implode( ',', $this->sess['search']['q']['exclude_entry_ids'] ).')';
		}
		
        /** -------------------------------------
		/**	Prep status
		/** -------------------------------------*/
		
		$force_status	= TRUE;
		
		if ( ! empty( $this->sess['search']['q']['status'] ) )
		{
			if ( ( $temp = $this->_prep_sql( 'not', 't.status', $this->sess['search']['q']['status'], 'exact' ) ) !== FALSE )
			{
				$force_status	= FALSE;
				$not[]	= $temp;
			}
			
			if ( ( $temp = $this->_prep_sql( 'or', 't.status', $this->sess['search']['q']['status'], 'exact' ) ) !== FALSE )
			{
				$force_status	= FALSE;
				$and[]	= $temp;
			}
		}		
		
		if ( $force_status === TRUE )
		{
			$and[]	= 't.status = \'open\'';
		}
		
        /** -------------------------------------
		/**	Prep title for keyword search
		/** -------------------------------------*/
		
		if ( ! empty( $this->sess['search']['q']['keywords'] ) )
		{
			if ( ( $temp = $this->_prep_sql( 'not', 't.title', $this->sess['search']['q']['keywords'] ) ) !== FALSE )
			{
				$not[]	= $temp;
			}
			
			if ( ( $temp = $this->_prep_sql( 'or', 't.title', $this->sess['search']['q']['keywords'] ) ) !== FALSE )
			{
				$or[]	= $temp;
			}
			
			/** -------------------------------------
			/**	Prep custom fields for keyword search
			/** -------------------------------------*/
			
			if ( ( $customfields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE )
			{			
				foreach ( $customfields as $val )
				{
					if ( is_numeric( $val ) === FALSE ) continue;
				
					if ( ( $temp = $this->_prep_sql( 'not', 'wd.field_id_'.$val, $this->sess['search']['q']['keywords'], 'notexact', $val ) ) !== FALSE )
					{
						$not[]	= $temp;
					}
					
					if ( ( $temp = $this->_prep_sql( 'or', 'wd.field_id_'.$val, $this->sess['search']['q']['keywords'], 'notexact', $val ) ) !== FALSE )
					{
						$or[]	= $temp;
					}				
				}
			}
		}
		
        /** -------------------------------------
		/**	Prep fields for per-field search
        /** -------------------------------------
        /*	While in our loop, if we discover that someone is searching on a field that does not exist, we want to return FALSE. We don't want to give them results for bunk searches.
		/** -------------------------------------*/
		
		if ( ( $customfields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE AND empty( $this->sess['search']['q']['field'] ) === FALSE )
		{
			foreach ( $this->sess['search']['q']['field'] as $key => $val )
			{
				if ( empty( $customfields[$key] ) === TRUE ) return FALSE;
		
				/** -------------------------------------
				/**	We expect searching on custom fields, but also allow searching on some exp_weblog_titles fields.
				/** -------------------------------------*/
				
				if ( is_numeric( $customfields[$key] ) !== FALSE )
				{
					if ( ( $temp = $this->_prep_sql( 'not', 'wd.field_id_'.$customfields[$key], $val, 'notexact', $customfields[$key] ) ) !== FALSE )
					{
						$not[]	= $temp;
					}
					
					if ( ( $temp = $this->_prep_sql( 'or', 'wd.field_id_'.$customfields[$key], $val, 'notexact', $customfields[$key] ) ) !== FALSE )
					{
						$and[]	= $temp;
					}
				}
				elseif ( in_array( $customfields[$key], $this->searchable_wt ) === TRUE )
				{
					if ( ( $temp = $this->_prep_sql( 'not', 't.'.$customfields[$key], $val, 'notexact', $customfields[$key] ) ) !== FALSE )
					{
						$not[]	= $temp;
					}
					
					if ( ( $temp = $this->_prep_sql( 'or', 't.'.$customfields[$key], $val, 'notexact', $customfields[$key] ) ) !== FALSE )
					{
						$and[]	= $temp;
					}
				}
			}
			
			unset( $customfields );
		}
		
        /** -------------------------------------
		/**	Prep fields for per-field exact search
        /** -------------------------------------
        /*	While in our loop, if we discover that someone is searching on a field that does not exist, we want to return FALSE. We don't want to give them results for bunk searches.
		/** -------------------------------------*/
		
		if ( ( $customfields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE AND empty( $this->sess['search']['q']['exactfield'] ) === FALSE )
		{		
			foreach ( $this->sess['search']['q']['exactfield'] as $key => $val )
			{
				if ( empty( $customfields[$key] ) === TRUE ) return FALSE;
		
				/** -------------------------------------
				/**	We expect searching on custom fields, but also allow searching on some exp_weblog_titles fields.
				/** -------------------------------------*/
				
				if ( is_numeric( $customfields[$key] ) !== FALSE )
				{
					if ( ( $temp = $this->_prep_sql( 'not', 'wd.field_id_'.$customfields[$key], $val, 'exact', $customfields[$key] ) ) !== FALSE )
					{
						$not[]	= $temp;
					}
					
					if ( ( $temp = $this->_prep_sql( 'or', 'wd.field_id_'.$customfields[$key], $val, 'exact', $customfields[$key] ) ) !== FALSE )
					{
						$and[]	= $temp;
					}
				}
				elseif ( in_array( $customfields[$key], $this->searchable_wt ) === TRUE )
				{
					if ( ( $temp = $this->_prep_sql( 'not', 't.'.$customfields[$key], $val, 'exact', $customfields[$key] ) ) !== FALSE )
					{
						$not[]	= $temp;
					}
					
					if ( ( $temp = $this->_prep_sql( 'or', 't.'.$customfields[$key], $val, 'exact', $customfields[$key] ) ) !== FALSE )
					{
						$and[]	= $temp;
					}
				}
			}
		}
		
        /** -------------------------------------
		/**	Prep fields for empty search
		/** -------------------------------------*/
		
		if ( ( $customfields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE AND empty( $this->sess['search']['q']['empty'] ) === FALSE )
		{		
			foreach ( $this->sess['search']['q']['empty'] as $key => $val )
			{
				if ( empty( $customfields[$key]['and'] ) === TRUE ) return FALSE;
				if ( is_numeric( $customfields[$key] ) === FALSE ) continue;
				if ( isset( $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] ) === FALSE ) return FALSE;
				
				$operator	= ( $val['and'] == 'y' ) ? '=': '!=';
				
				if ( $this->_get_field_type( $key ) == 'numeric' )
				{
					$and[]	= '(wd.field_id_'.$customfields[$key]." ".$operator." 0 " . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ")";
				}
				else
				{
					$and[]	= '(wd.field_id_'.$customfields[$key]." ".$operator." ''" . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ")";
				}
			}
		}
		
        /** -------------------------------------
		/**	Prep fields for greater than search
		/** -------------------------------------*/
		
		if ( ( $customfields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE AND empty( $this->sess['search']['q']['from'] ) === FALSE )
		{		
			foreach ( $this->sess['search']['q']['from'] as $key => $val )
			{
				if ( empty( $customfields[$key]['and'] ) === TRUE ) return FALSE;
				if ( isset( $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] ) === FALSE ) return FALSE;
				
				if ( is_numeric( $customfields[$key] ) !== FALSE )
				{
					if ( $this->_get_field_type( $key ) == 'numeric' )
					{
						$and[]	= '(wd.field_id_'.$customfields[$key]." >= " . $val['and'] . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ')';
					}
					else
					{
						$and[]	= '(wd.field_id_'.$customfields[$key]." >= '" . $val['and'] . "'" . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ")";
						$and[]	= '(wd.field_id_'.$customfields[$key]." != ''" . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ")";
					}
				}
				elseif ( in_array( $customfields[$key], $this->searchable_wt ) === TRUE )
				{
					$and[]	= 't.'.$customfields[$key]." >= '" . $val['and'] . "'";
					$and[]	= 't.'.$customfields[$key]." != ''";
				}
			}
		}
		
        /** -------------------------------------
		/**	Prep fields for less than search
		/** -------------------------------------*/
		
		if ( ( $customfields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE AND empty( $this->sess['search']['q']['to'] ) === FALSE )
		{		
			foreach ( $this->sess['search']['q']['to'] as $key => $val )
			{
				if ( empty( $customfields[$key]['and'] ) === TRUE ) return FALSE;
				if ( isset( $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] ) === FALSE ) return FALSE;
				
				if ( is_numeric( $customfields[$key] ) !== FALSE )
				{				
					if ( $this->_get_field_type( $key ) == 'numeric' )
					{
						$and[]	= '(wd.field_id_'.$customfields[$key]." <= ".$val['and'] . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ')';
					}
					else
					{
						$and[]	= '(wd.field_id_'.$customfields[$key]." <= '" . $val['and'] . "'" . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ")";
						$and[]	= '(wd.field_id_'.$customfields[$key]." != ''" . $this->sess['field_to_weblog_map_sql'][ $customfields[$key] ] . ")";
					}
				}
				elseif ( in_array( $customfields[$key], $this->searchable_wt ) === TRUE )
				{				
					$and[]	= 't.'.$customfields[$key]." <= '" . $val['and'] . "'";
					$and[]	= 't.'.$customfields[$key]." != ''";
				}
			}
		}
		
        /** -------------------------------------
		/**	Prep 'from date' search
        /** -------------------------------------
        /*	We'll allow simple year indicators, year + month, year + month + day, all the way up to full seconds indicators. The string we expect is additive. All values except year are expected in two digits.
		/** -------------------------------------*/
		
		if ( ! empty( $this->sess['search']['q']['datefrom'] ) AND is_numeric( $this->sess['search']['q']['datefrom'] ) === TRUE )
		{
			$thedate	= $this->_split_date( $this->sess['search']['q']['datefrom'] );
			// unset( $this->sess['search']['q']['datefrom'] );
			
			switch ( count( $thedate ) )
			{
				case 2:	// We have year only
					$and[]	= 't.entry_date >= '.$LOC->set_gmt( mktime( 0, 0, 0, 1, 1, $thedate[0].$thedate[1] ) );
					break;
				case 3:	// We have year and month
					$and[]	= 't.entry_date >= '.$LOC->set_gmt( mktime( 0, 0, 0, $thedate[2], 1, $thedate[0].$thedate[1] ) );
					break;
				case 4:	// We have year, month, day
					$and[]	= 't.entry_date >= '.$LOC->set_gmt( mktime( 0, 0, 0, $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
				case 5:	// We have year, month, day and hour
					$and[]	= 't.entry_date >= '.$LOC->set_gmt( mktime( $thedate[4], 0, 0, $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
				case 6:	// We have year, month, day, hour and minute
					$and[]	= 't.entry_date >= '.$LOC->set_gmt( mktime( $thedate[4], $thedate[5], 0, $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
				case 7:	// We have year, month, day, hour, minute and second
					$and[]	= 't.entry_date >= '.$LOC->set_gmt( mktime( $thedate[4], $thedate[5], $thedate[6], $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
			}
		}
		
		unset( $thedate );
		
        /** -------------------------------------
		/**	Prep 'to date' search
        /** -------------------------------------
        /*	We'll allow simple year indicators, year + month, year + month + day, all the way up to full seconds indicators. The string we expect is additive. All values except year are expected in two digits.
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['dateto'] ) === FALSE AND is_numeric( $this->sess['search']['q']['dateto'] ) === TRUE )
		{
			$thedate	= $this->_split_date( $this->sess['search']['q']['dateto'] );
			// unset( $this->sess['search']['q']['dateto'] );
			
			switch ( count( $thedate ) )
			{
				case 2:	// We have year only
					$and[]	= 't.entry_date <= '.$LOC->set_gmt( mktime( 23, 59, 59, 12, 31, $thedate[0].$thedate[1] ) );
					break;
				case 3:	// We have year and month
					$and[]	= 't.entry_date <= '.$LOC->set_gmt( mktime( 23, 59, 59, $thedate[2], $LOC->fetch_days_in_month( $thedate[2], $thedate[0].$thedate[1] ), $thedate[0].$thedate[1] ) );
					break;
				case 4:	// We have year, month, day
					$and[]	= 't.entry_date <= '.$LOC->set_gmt( mktime( 23, 59, 59, $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
				case 5:	// We have year, month, day and hour
					$and[]	= 't.entry_date <= '.$LOC->set_gmt( mktime( $thedate[4], 59, 59, $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
				case 6:	// We have year, month, day, hour and minute
					$and[]	= 't.entry_date <= '.$LOC->set_gmt( mktime( $thedate[4], $thedate[5], 0, $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
				case 7:	// We have year, month, day, hour, minute and second
					$and[]	= 't.entry_date <= '.$LOC->set_gmt( mktime( $thedate[4], $thedate[5], $thedate[6], $thedate[2], $thedate[3], $thedate[0].$thedate[1] ) );
					break;
			}
		}
		
		unset( $thedate );
			
		/** ----------------------------------------
		/**	Add site ids
		/** ----------------------------------------*/
		
		$and[]	= 't.site_id IN (' . implode( ',', $TMPL->site_ids ) . ')';
			
		/** ----------------------------------------
		/**	Manipulate $and, $not, $or
		/** ----------------------------------------*/
		
		if ($EXT->active_hook('super_search_do_search_and_array') === TRUE)
		{
			$arr	= $EXT->universal_call_extension( 'super_search_do_search_and_array', $this, array( 'and' => $and, 'not' => $not, 'or' => $or ) );
			
			$and	= ( empty( $arr['and'] ) ) ? $and: $arr['and'];
			$not	= ( empty( $arr['not'] ) ) ? $not: $arr['not'];
			$or		= ( empty( $arr['or'] ) ) ? $or: $arr['or'];
		}
		
		/*
		echo 'AND';
		print_r( $and );
		echo '<hr />';
		echo 'NOT';
		print_r( $not );
		echo '<hr />';
		echo 'OR';
		print_r( $or );
		echo '<hr />';
		print_r( $where );
		echo '<hr />';
		*/

        /** -------------------------------------
        /**	Anything to query?
		/** -------------------------------------*/
		
		if ( empty( $and ) === TRUE AND empty( $not ) === TRUE AND empty( $or ) === TRUE AND empty( $subids ) === TRUE )
		{
			$this->_cache( $this->sess( 'search' ), '', 0 );
			return FALSE;
		}
		
        /** -------------------------------------
		/**	Ordering by relevance?
        /** -------------------------------------
        /*	Warning: On large sets of data retrieved from the DB, pulling more than just the entry id will result in memory errors on most shared hosting environments. Therefore, warnings should be issued to users about searching with keywords, particularly short ones, that will return large data sets.
        /*	Consider defining a MySQL level function to count and order strings like this: http://forge.mysql.com/tools/tool.php?id=65
		/** -------------------------------------*/
		
		if ( ! empty( $this->sess['search']['q']['keywords']['or'] ) AND ( $relevance = $this->_prep_relevance() ) !== FALSE )
		{
			if ( array_key_exists( 'title', $relevance ) === TRUE )
			{
				$select	.= ', t.title';
				unset( $relevance['title'] );
			}
			
			if ( count( $relevance ) > 0 AND ( $fields = $this->_fields( 'all', $TMPL->site_ids ) ) !== FALSE )
			{
				foreach ( $relevance as $key => $val )
				{
					if ( isset( $fields[$key] ) === TRUE )
					{
						$select	.= ', field_id_'.$fields[$key].' AS `'.$key.'`';
					}
				}
			}
		}

        /** -------------------------------------
        /**	Some assembly required
		/** -------------------------------------*/
		
		$sql	= $select.$from.$where;
		
        /** -------------------------------------
		/**	Continue 'where'
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['weblog_ids'] ) === FALSE )
		{
			$sql	.= ' AND t.weblog_id IN ('.implode( ',', $this->sess['search']['q']['weblog_ids'] ).')';
		}
		
		if ( empty( $and ) === FALSE )
		{
			$sql	.= ' AND '.implode( ' AND ', $and );
		}
		
		if ( empty( $not ) === FALSE )
		{
			$sql	.= ' AND '.implode( ' AND ', $not );
		}
		
		if ( empty( $subids ) === FALSE )
		{
			$sql	.= " /*Begin subids statement*/ AND t.entry_id IN ('".implode( "','", $subids )."') /*End subids statement*/ ";
		}
		
		if ( empty( $or ) === FALSE )
		{
			$sql	.= ' AND (/*Begin OR statement*/'.implode( ' OR ', $or ).'/*End OR statement*/)';
		}
		
        /** -------------------------------------
		/**	Add order
		/** -------------------------------------*/
		
		$sql	.= $order;

        /** -------------------------------------
        /**	Force limits?
		/** -------------------------------------*/
		
		if ( isset( $this->sess['search']['q']['keywords']['or'] ) === TRUE )
		{
			$limit	= '';
			
			foreach ( $this->sess['search']['q']['keywords']['or'] as $k )
			{
				if ( strlen( $k ) < $this->minlength[0] OR in_array( $k, $this->common ) === TRUE )
				{
					$limit = ' LIMIT '.$this->minlength[1];
				}
			}
			
			$sql	.= $limit;
		}
		
        /** -------------------------------------
		/**	Hit the DB
		/** -------------------------------------*/
		
		$query	= $DB->query( $sql );
		
		// print_r( $sql );
		
		$this->sess['results']	= $query->num_rows;
		
		if ( $query->num_rows == 0 )
		{
			$this->_cache( $this->sess( 'search' ), '', 0 );
		
			return FALSE;
		}
		
        /** -------------------------------------
		/**	Ordering by relevance?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['search']['q']['keywords']['or'] ) === FALSE AND ( $relevance = $this->_prep_relevance() ) !== FALSE )
		{		
			foreach ( $query->result as $row )
			{			
				$rel[$row['entry_id']]	= $this->_relevance_count( $relevance, $row );
			}
			
			arsort( $rel, SORT_NUMERIC );
			
			foreach ( $rel as $id => $v )
			{
				$ids[$id]	= $id;
			}
			
			unset( $rel );
		}
		else
		{
			foreach ( $query->result as $row )
			{
				$ids[]	= $row['entry_id'];
			}
		}
		
		// print_r( $sql );
		// print_r( $this->sess );
		
        /** -------------------------------------
		/**	Save to cache
		/** -------------------------------------*/
		
		$this->_cache( $this->sess( 'search' ), $ids, $query->num_rows );
		
        /** -------------------------------------
		/**	Return ids
		/** -------------------------------------*/
		
		$TMPL->log_item( 'Super Search: Ending do_search_wt_wd('.(microtime(TRUE) - $t).' Results '.$query->num_rows.')' );
		
		return $ids;
	}
	
	/*	End do search */

    // --------------------------------------------------------------------

	/**
	 * Entries
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function _entries ( $ids = array(), $params = array() )
	{
		global $DB, $FNS, $IN, $SESS, $TMPL;
		
		$t	= microtime(TRUE);
		
		$TMPL->log_item( 'Super Search: Starting _entries()' );

		/**	----------------------------------------
		/**	Execute?
		/**	----------------------------------------*/

		if ( count( $ids ) == 0 ) return FALSE;
		
		/**	----------------------------------------
		/**	Parse search total
		/**	----------------------------------------*/
		
		$search_total	= count( $ids );	// This is used in pagination as well as a variable in $tagdata parsing.
		
		if ( strpos( $TMPL->template, LD.'super_search_total_results'.RD ) !== FALSE )
		{
			$TMPL->template	= str_replace( LD.'super_search_total_results'.RD, $search_total, $TMPL->template );
		}

		/**	----------------------------------------
		/**	Invoke weblog class
		/**	----------------------------------------*/

		if ( class_exists('Weblog') === FALSE )
        {
        	require PATH_MOD.'/weblog/mod.weblog'.EXT;
        }

        $weblog = new Weblog;
		
		/**	----------------------------------------
		/**	Invoke TYPE class
		/**	----------------------------------------*/
	
		if ( ! class_exists('Typography'))
		{
			require PATH_CORE.'core.typography'.EXT;
		}
				
		$this->TYPE = new Typography;   
		$this->TYPE->convert_curly = FALSE;

        /** -------------------------------------
        /**	Alias tag params. Template params trump URI params
		/** -------------------------------------*/
		
		foreach ( array( 'num' => 'limit' ) as $key => $val )
		{
			/** -------------------------------------
			/**	We prefer to find the array value as a template param
			/** -------------------------------------*/
		
			if ( ! empty( $TMPL->tagparams[ $val ] ) )
			{
				unset( $TMPL->tagparams[ $key ] );
			}
			
			/** -------------------------------------
			/**	We'll accept the array key as a template param next
			/** -------------------------------------*/
			
			elseif ( ! empty( $TMPL->tagparams[ $key ] ) )
			{
				$TMPL->tagparams[ $val ]	= $TMPL->tagparams[ $key ];
			}
			
			/** -------------------------------------
			/**	We'll next accept our array val as a URI param
			/** -------------------------------------*/

			elseif ( ! empty( $this->sess['uri'][ $val ] ) )
			{
				$TMPL->tagparams[ $val ]	= $this->sess['uri'][ $val ];
				unset( $TMPL->tagparams[ $key ] );
			}
			
			/** -------------------------------------
			/**	We'll lastly accept our array key as a URI param
			/** -------------------------------------*/

			elseif ( ! empty( $this->sess['uri'][ $key ] ) )
			{
				$TMPL->tagparams[ $val ]	= $this->sess['uri'][ $key ];
				unset( $TMPL->tagparams[ $key ] );
			}
		}

        /** -------------------------------------
        /**	Force limits?
		/** -------------------------------------*/
		
		if ( ( $keywords = $this->sess( 'search', 'q', 'keywords', 'or' ) ) !== FALSE )
		{
			$limit	= ( ! empty( $TMPL->tagparams['limit'] ) ) ? $TMPL->tagparams['limit']: '';
			
			foreach ( $keywords as $k )
			{
				if ( strlen( $k ) < $this->wminlength[0] )
				{
					if ( $limit > $this->wminlength[1] )
					{
						$limit	= $this->wminlength[1];
					}
				}
			}

			$TMPL->tagparams['limit']	= ( count( $ids ) > $limit ) ? $limit: count( $ids );
		}

		/**	----------------------------------------
		/**	Pass params
		/**	----------------------------------------*/

        $TMPL->tagparams['inclusive']	= '';

		$TMPL->tagparams['show_pages']	= 'all';
		
		$TMPL->tagparams['dynamic']		= 'off';
		
		/**	----------------------------------------
		/**	Force order
		/**	----------------------------------------*/
		
		$TMPL->tagparams['fixed_order']	= $this->_cerealize( $ids );
		
		foreach ( $params as $key => $val )
		{
			$TMPL->tagparams[$key]	= $val;
		}

		/**	----------------------------------------
		/**	Pre-process related data
		/**	----------------------------------------*/

		$TMPL->tagdata		= $TMPL->assign_relationship_data( $TMPL->tagdata );

		$TMPL->var_single	= array_merge( $TMPL->var_single, $TMPL->related_markers );

		/**	----------------------------------------
		/**	Execute needed methods
		/**	----------------------------------------*/

        $weblog->fetch_custom_weblog_fields();

        $weblog->fetch_custom_member_fields();

		$weblog->fetch_pagination_data();

		/**	----------------------------------------
		/**	Prep pagination
		/**	----------------------------------------
		/*	We like to use the 'start' param to tell pagination which page we want. EE uses P20 or the like. Let's allow someone to use our 'start' param in the context of performance off, but only when the standard EE pagination indicator is absent from the QSTR.
		/**	----------------------------------------*/
		
		if ( isset( $this->sess['newuri'] ) === TRUE )
		{
			if ( strpos( $this->sess['newuri'], '/' ) !== FALSE )
			{
				$this->sess['newuri']	= str_replace( '/', $this->slash, $this->sess['newuri'] );
			}
		
			if ( $TMPL->fetch_param('paginate_base') !== FALSE AND $TMPL->fetch_param('paginate_base') != '' )
			{
				$TMPL->tagparams['paginate_base']	= rtrim( $TMPL->fetch_param('paginate_base'), '/' ) . '/' . ltrim( $this->sess['newuri'], '/' );
			}
			else
			{
				/**	----------------------------------------
				/**	If someone is using the template param called 'search' they may not have a full URI saved in sess['olduri'] so we try to fake it. The better approach is for them to use the paginate_base param above.
				/**	----------------------------------------*/
				
				if ( isset( $IN->SEGS[1] ) === TRUE AND strpos( $this->sess['olduri'], $IN->SEGS[1] ) !== 0 )
				{
					$temp[]	= $IN->SEGS[1];
					
					if ( isset( $IN->SEGS[2] ) === TRUE )
					{
						$temp[]	= $IN->SEGS[2];
					}
					
					$temp[]	= $this->sess['olduri'];
					
					$this->sess['olduri']	= implode( '/', $temp );
				}
			
				$TMPL->tagparams['paginate_base']	= str_replace( $this->urimarker, str_replace( '/', $this->slash, $this->sess['newuri'] ), $this->sess['olduri'] );
			}			
		}
		
		$QSTR	= $weblog->QSTR;
		
		if ( ! preg_match("#^P(\d+)|/P(\d+)#", $weblog->QSTR, $match ) AND ( $start = $this->sess( 'uri', 'start' ) ) !== FALSE )
		{
			$weblog->QSTR	= rtrim( $weblog->QSTR, '/' ) . '/P' . $start;
		}

        $weblog->create_pagination();
        
        $weblog->QSTR	= $QSTR;

		/**	----------------------------------------
		/**	Grab entry data
		/**	----------------------------------------*/

        $weblog->build_sql_query();

        if ($weblog->sql == '')
        {
        	return FALSE;
        }

        $weblog->query = $DB->query($weblog->sql);

        if ($weblog->query->num_rows == 0)
        {
			$TMPL->log_item( 'Super Search: Ending _entries('.(microtime(TRUE) - $t).')' );
            return FALSE;
        }
		
		unset( $ids );
		$used_ids	= array();
		
		/**	----------------------------------------
		/**	Prep relevance
		/**	----------------------------------------*/
		
		$relevance	= $this->_prep_relevance();

		/**	----------------------------------------
		/**	Inject additional vars
		/**	----------------------------------------*/
		
		foreach ( $weblog->query->result as $key => $row )
		{
			$used_ids[]							= $row['entry_id'];
			$row['super_search_total_results']	= $search_total;
				
			// Prepare relevance count
			if ( isset( $relevance ) === TRUE AND $relevance !== FALSE )
			{
				$row['relevance_count']	= $this->_relevance_count( $relevance, $row );
			}
			else
			{
				$row['relevance_count']	= '';
			}
			
			/**	----------------------------------------
			/**	Check for excerpt
			/**	----------------------------------------*/
			
			if ( ! empty( $this->sess['search']['weblogs'][$row['weblog_id']]['search_excerpt'] ) )
			{
				if ( $this->sess['search']['weblogs'][$row['weblog_id']]['search_excerpt'] != 0 )
				{
					$field_id		= $this->sess['search']['weblogs'][$row['weblog_id']]['search_excerpt'];
					$field_content = $this->TYPE->parse_type( $row['field_id_' . $field_id ],
						array(
							  'text_format'		=> ( isset( $row[ 'field_ft_' . $field_id ] ) === TRUE ) ? $row[ 'field_ft_' . $field_id ]: 'none',
							  'html_format'		=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_html_formatting']: 'all',
							  'auto_links'		=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_auto_link_urls']: 'n',
							  'allow_img_url'	=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_allow_img_urls']: 'y',
							)
					);
	
					/**	----------------------------------------
					/**	Highlight keywords
					/**	----------------------------------------*/
					
					$field_content	= $this->_highlight_keywords( $field_content );
					
					$row['excerpt']	= $field_content;
				}
			}
			
			$row['excerpt']	= ( isset( $row['excerpt'] ) === FALSE OR is_string( $row['excerpt'] ) === FALSE ) ? '': $row['excerpt'];	// This patches a problem that I could not find in _highlight_keywords() where sometimes a string would not be returned.
			
			$weblog->query->result[ $key ]	= $row;
		}
		
		/** -------------------------------------
		/**	Save ids so that our allow_repeats param will work. This lets is exclude entries from showing again in the same session if we have already retrieved them. This is dependent on the linear parsing order of course. You can't know what a later super search call will retrieve and you don't care. Linear is sufficient.
		/** -------------------------------------*/
		
		if ( empty( $this->sess['previous_entries'] ) )
		{
			$this->sess['previous_entries']	= array();
		}
		
		$this->sess['previous_entries']	= array_merge( $this->sess['previous_entries'], array_unique( $used_ids ) );

		/**	----------------------------------------
		/**	Invoke typography
		/**	----------------------------------------*/

        if ( class_exists('Typography') === FALSE )
        {
            require PATH_CORE.'core.typography'.EXT;
        }

        $weblog->TYPE = new Typography;

        if ( isset( $weblog->TYPE->convert_curly ) )
        {
        	$weblog->TYPE->convert_curly	= FALSE;
        }

        $weblog->fetch_categories();

		/**	----------------------------------------
		/**	Parse and return entry data
		/**	----------------------------------------*/

        $weblog->parse_weblog_entries();

		/**	----------------------------------------
		/**	Add and correct pagination data
		/**	----------------------------------------*/
        
        foreach ( array( 'pagination_links', 'page_previous', 'page_next' ) as $val )
        {
        	$weblog->$val	= str_replace( array( ';=', ';-', ';_' ), array( '=', '-', '_' ), $weblog->$val );
        }

		$weblog->add_pagination_data();

		/**	----------------------------------------
		/**	Related entries
		/**	----------------------------------------*/

		if (count($TMPL->related_data) > 0 AND count($weblog->related_entries) > 0)
		{
			$weblog->parse_related_entries();
		}

		if (count($TMPL->reverse_related_data) > 0 AND count($weblog->reverse_related_entries) > 0)
		{
			$weblog->parse_reverse_related_entries();
		}

		/**	----------------------------------------
		/*	Handle problem with pagination segments
		/*	in the url
		/**	----------------------------------------*/

		if ( preg_match("#(/?P\d+)#", $IN->URI, $match) )
		{
			$weblog->return_data	= str_replace( $match['1'], '', $weblog->return_data );
		}	

        $tagdata = $weblog->return_data;
        
		$TMPL->log_item( 'Super Search: Ending _entries('.(microtime(TRUE) - $t).')' );

        return $tagdata;
	}

	/*	End entries */

    // --------------------------------------------------------------------

	/**
	 * Extract vars from query
	 *
	 * @access	private
	 * @return	array
	 */
	 
	 function _extract_vars_from_query( $q = array() )
	 {
	 	if ( empty( $q ) ) return array();
	 	
	 	$prefix	= 'super_search_';
	 	
	 	if ( function_exists( 'andornot' ) === FALSE )
	 	{
			function andornot( $q = array() )
			{
				$temp		= array();
				
				if ( empty( $q ) OR is_array( $q ) === FALSE ) return '';
					
				foreach ( $q as $key => $arr )
				{
					if ( $key == 'and' AND ! empty( $arr ) )
					{
						if ( is_array( $arr ) === TRUE )
						{
							$temp[]	= implode( ' ', $arr );
						}
						else
						{
							$temp[]	= $arr;
						}
					}
					
					if ( $key == 'not' AND ! empty( $arr ) )
					{
						if ( is_array( $arr ) === TRUE )
						{
							$temp[]	= '-' . implode( ' -', $arr );
						}
						else
						{
							$temp[]	= '-' . $arr;
						}
					}
					
					if ( $key == 'or' AND ! empty( $arr ) )
					{
						if ( is_array( $arr ) === TRUE )
						{
							foreach ($arr as $v )
							{
								$temp[]	=	$v;
							}
						}
						else
						{
							$temp[]	= $arr;
						}
					}
				}
					
				return implode( ' ', $temp );
			}
	 	}	 	
	 	
	 	$vars	= array();
	 	
	 	foreach ( $q as $key => $arr )
	 	{
	 		if ( empty( $arr ) ) continue;
	 	
	 		if ( $key == 'field' )
	 		{
	 			foreach ( $arr as $k => $v )
	 			{
	 				$vars[$prefix.$k]	= andornot( $v );
	 			}
	 		}
	 		elseif ( $key == 'exactfield' )
	 		{
	 			foreach ( $arr as $k => $v )
	 			{
	 				$vars[$prefix.'exact'.$this->modifier_separator.$k]	= andornot( $v );
	 			}
	 		}
	 		elseif ( $key == 'empty' )
	 		{
	 			foreach ( $arr as $k => $v )
	 			{
	 				$vars[$prefix.$k.$this->modifier_separator.'empty']	= andornot( $v );
	 			}
	 		}
	 		elseif ( $key == 'from' )
	 		{
	 			foreach ( $arr as $k => $v )
	 			{
	 				$vars[$prefix.$k.$this->modifier_separator.'from']	= andornot( $v );
	 			}
	 		}
	 		elseif ( $key == 'to' )
	 		{
	 			foreach ( $arr as $k => $v )
	 			{
	 				$vars[$prefix.$k.$this->modifier_separator.'to']	= andornot( $v );
	 			}
	 		}
	 		elseif ( $key == 'datefrom' )
	 		{
	 			$vars[$prefix.'date'.$this->modifier_separator.'from']	= $arr;
	 		}
	 		elseif ( $key == 'dateto' )
	 		{
	 			$vars[$prefix.'date'.$this->modifier_separator.'to']	= $arr;
	 		}
	 		else
	 		{
	 			$vars[$prefix.$key]	= andornot( $arr );
	 		}
	 	}
	 	
	 	// print_r( $vars );
	 	
	 	return $vars;
	 }
	 
	 /*	End extract vars from query */

    // --------------------------------------------------------------------

	/**
	 * Fast entries
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function _fast_entries ( $ids = array(), $params = array() )
	{
		global $DB, $EXT, $FNS, $PREFS, $SESS, $TMPL;
		
		if ( empty( $ids ) === TRUE ) return FALSE;
		
		$t	= microtime(TRUE);
		
		$TMPL->log_item( 'Super Search: Starting _fast_entries()' );
	
		/**	----------------------------------------
		/**	Get lists of fields
		/**	----------------------------------------*/
		
		if ( ( $fields = $this->_table_columns( 'exp_weblog_titles' ) ) === FALSE )
		{
			$fields	= array();
		}
		
		if ( ( $mfields = $this->_table_columns( 'exp_members' ) ) === FALSE )
		{
			$mfields	= array();
		}
		
		if ( ( $customfields = $this->_fields( 'all' ) ) === FALSE )
		{
			$customfields	= array();
		}
		
		$constructedfields	= array(
									'auto_path'						=> 'auto_path',
									'comment_entry_id_auto_path'	=> 'comment_entry_id_auto_path',
									'comment_url_title_auto_path'	=> 'comment_url_title_auto_path',
									'page_uri'						=> 'page_uri',
									'page_url'						=> 'page_url',
									'relevance_count'				=> 'relevance_count',
									'weblog'						=> 'weblog',
									'weblog_short_name'				=> 'weblog_short_name'						
									);
		
		/**	----------------------------------------
		/**	Find out what we need from tagdata
		/**	----------------------------------------*/
		
		$parsefields	= array();
		
		$i	= 0;
		
		foreach ( array_keys( $TMPL->var_single ) as $key )
		{
			$i++;
			
			if ( strpos( $key, ':' ) !== FALSE )
			{
				$key	= array_shift( explode( ':', $key ) );
			}
		
			if ( strpos( $key, 'format=' ) !== FALSE )
			{
				$full	= $key;
				
				if ( preg_match( "/(.*?)\s+format=[\"'](.*?)[\"']/s", $key, $format ) )
				{
					$key						= $format[1];
					$dates[$key][$i]['format']	= $format[2];
					$dates[$key][$i]['full']	= $full;
				}
			}
			
			if ( isset( $fields[$key] ) === TRUE )
			{
				$parsefields['standard'][$key]	= $key;
			}
			
			if ( isset( $mfields[$key] ) === TRUE )
			{
				$parsefields['member'][$key]	= $key;
			}
			
			if ( isset( $customfields[$key] ) === TRUE )
			{
				$parsefields['custom'][$key]	= $customfields[$key];
			}
			
			if ( isset( $constructedfields[$key] ) === TRUE )
			{
				$parsefields['constructed'][$key]	= $constructedfields[$key];
			}
		}
		
		/**	----------------------------------------
		/**	Loop again for var conditionals just in case someone tests a field's value without actually calling the field as a var.
		/**	----------------------------------------*/
		
		foreach ( array_keys( $TMPL->var_cond ) as $key )
		{
			if ( empty( $TMPL->var_cond[$key][3] ) === TRUE )
			{
				continue;
			}
			else
			{
				$cond	= $TMPL->var_cond[$key][3];
			}
		
			if ( isset( $fields[$cond] ) === TRUE )
			{
				$parsefields['standard'][$cond]	= $cond;
			}
			
			if ( isset( $mfields[$cond] ) === TRUE )
			{
				$parsefields['member'][$cond]	= $cond;
			}
			
			if ( isset( $customfields[$cond] ) === TRUE )
			{
				$parsefields['custom'][$cond]	= $customfields[$cond];
			}
			
			if ( isset( $constructedfields[$cond] ) === TRUE )
			{
				$parsefields['constructed'][$cond]	= $constructedfields[$cond];
			}
		}
		
		/**	----------------------------------------
		/**	Loop again for var pairs
		/**	----------------------------------------*/
		
		foreach ( array_keys( $TMPL->var_pair ) as $key )
		{
			if ( in_array( $key, array( 'paginate' ) ) === TRUE )
			{
				continue;
			}
			
			if ( strpos( $key, ' ' ) !== FALSE )
			{
				$key	= array_shift( explode( ' ', $key ) );
			}
		
			if ( isset( $fields[$key] ) === TRUE )
			{
				$parsefields['standard'][$key]	= $key;
			}
			
			if ( isset( $mfields[$key] ) === TRUE )
			{
				$parsefields['member'][$key]	= $key;
			}
			
			if ( isset( $customfields[$key] ) === TRUE )
			{
				$parsefields['custom'][$key]	= $customfields[$key];
			}
			
			if ( isset( $constructedfields[$key] ) === TRUE )
			{
				$parsefields['constructed'][$key]	= $constructedfields[$key];
			}
		}
	
		/**	----------------------------------------
		/**	Localize
		/**	----------------------------------------*/
		
		if ( empty( $dates ) === FALSE )
		{
			setlocale( LC_TIME, $SESS->userdata('time_format') );
		}
		
		/**	----------------------------------------
		/**	Parse search total
		/**	----------------------------------------*/
		
		$search_total	= count( $ids );	// This is used in pagination as well as a variable in $tagdata parsing.
		
		if ( strpos( $TMPL->template, LD.'super_search_total_results'.RD ) !== FALSE )
		{
			$TMPL->template	= str_replace( LD.'super_search_total_results'.RD, $search_total, $TMPL->template );
		}
		
		/**	----------------------------------------
		/**	Start SQL
		/**	----------------------------------------*/
		
		$select		= '/* Super Search final fetch for results */ SELECT';
		$from		= ' FROM exp_weblog_titles t';
		$join		= ' LEFT JOIN exp_weblog_data wd ON wd.entry_id = t.entry_id';
		$groupby	= '';
		$order		= ' ORDER BY FIELD(t.entry_id,'.implode(',', $ids).') ';
		$limit		= '';
		$where		= ' WHERE t.entry_id IN ('.implode( ',', $ids ).')';
        
        /** ----------------------------------------
        /**  Member data join
        /** ----------------------------------------*/
        
        if ( empty( $parsefields['member'] ) === FALSE )
        {
        	$join	.= ' LEFT JOIN exp_members m ON m.member_id = t.author_id';
        }
        
        /** ----------------------------------------
        /**  Prep pagination
        /** ----------------------------------------*/
        
        $limit	= $this->_prep_pagination( $limit, $search_total );
		
		/**	----------------------------------------
		/**	Include standard fields
		/**	----------------------------------------*/
		
		$parsefields['standard']['entry_id']	= 'entry_id';
		$parsefields['standard']['weblog_id']	= 'weblog_id';
		$parsefields['standard']['url_title']	= 'url_title';
		
		/**	----------------------------------------
		/**	Begin to assemble select statement 
		/**	----------------------------------------*/
		
		if ( empty( $parsefields['standard'] ) === FALSE )
		{
			$select	.=	' t.'.implode( ', t.', array_keys( $parsefields['standard'] ) );
		}
		
		/**	----------------------------------------
		/**	Include member fields
		/**	----------------------------------------*/
		
		if ( empty( $parsefields['member'] ) === FALSE )
		{			
			foreach ( $parsefields['member'] as $key => $val )
			{
				$select	.= ', m.'.$val.' AS `'.$key.'`';
			}
		}
		
		/**	----------------------------------------
		/**	Include custom fields
		/**	----------------------------------------*/
		
		if ( empty( $parsefields['custom'] ) === FALSE )
		{
			foreach ( $parsefields['custom'] as $key => $val )
			{
				/**	----------------------------------------
				/**	We call the actual field name and we alias it as well. This allows other devs writing extensions that invoke the weblog_entries_tagdata hook to get what they're expecting.
				/**	----------------------------------------*/
		
				$select	.= ', wd.field_id_'.$val.', wd.field_id_'.$val.' AS `'.$key.'`';
				$select	.= ', wd.field_ft_'.$val.', wd.field_ft_'.$val.' AS `'.$key.'_format`';
			}
			
			// $select	= substr( $select, 0, -1 );
		}
		
		/**	----------------------------------------
		/**	Include excerpt if not already called
		/**	----------------------------------------*/
		
		if ( $this->_fields( 'all', $TMPL->site_ids ) !== FALSE )
		{
			$this->_weblogs();
			
			foreach ( $this->sess['weblogs'] as $row )
			{
				if ( $row['search_excerpt'] == 0 OR ( ! empty( $this->sess['fields']['all'] ) AND in_array( $row['search_excerpt'], $this->sess['fields']['all'] ) === FALSE ) ) continue;
				
				$parsefields['excerpt'][$row['weblog_id']]	= $row['search_excerpt'];
				
				$select	.= ', wd.field_id_'.$row['search_excerpt'].' AS excerpt_'.$row['search_excerpt'];
				$select	.= ', wd.field_ft_'.$row['search_excerpt'].' AS excerpt_format_'.$row['search_excerpt'];
			}
		}
		
		/**	----------------------------------------
		/**	Query the DB
		/**	----------------------------------------*/
		
		$sql	= $select.$from.$join.$where.$groupby.$order.$limit;
		$query	= $DB->query( $sql );
		
		// print_r( $query );
		
		if ( $query->num_rows == 0 ) return FALSE;
		
		unset( $ids );
		
		/**	----------------------------------------
		/**	Prepare for custom field parsing
		/**	----------------------------------------*/
		
		if ( empty( $parsefields['custom'] ) === FALSE OR empty( $parsefields['excerpt'] ) === FALSE )
		{
			if ( ( $fields_fmt = $this->sess( 'fields_fmt' ) ) === FALSE ) return FALSE;
			if ( ( $weblogs = $this->_prep_weblog() ) === FALSE ) return FALSE;
		
			/**	----------------------------------------
			/**	Get TYPE ready
			/**	----------------------------------------*/
		
			if ( ! class_exists('Typography'))
			{
				require PATH_CORE.'core.typography'.EXT;
			}
					
			$this->TYPE = new Typography;   
			$this->TYPE->convert_curly = FALSE;
		}
		
		/**	----------------------------------------
		/**	Prep relevance
		/**	----------------------------------------*/
		
		if ( isset( $parsefields['constructed']['relevance_count'] ) === TRUE )
		{
			$relevance	= $this->_prep_relevance();
		}
		
		/**	----------------------------------------
		/**	Loop and parse
		/**	----------------------------------------*/
		
		$count			= 1;
		$r				= '';
		$used_ids		= array();
        $site_pages		= $PREFS->ini('site_pages');
		
		foreach ( $query->result as $row )
		{
			$used_ids[]	= $row['entry_id'];
		
			$tagdata	= $TMPL->tagdata;

			/**	----------------------------------------
			/**	Forced vars
			/**	----------------------------------------*/
			
			$row['count']						= $count++;
			$row['total_results']				= $query->num_rows;
			$row['absolute_count']				= $search_total;
			$row['search_total']				= $search_total;
			$row['super_search_total_results']	= $search_total;
			
			$parsefields['standard']['count']						= 'count';
			$parsefields['standard']['total_results']				= 'total_results';
			$parsefields['standard']['super_search_total_results']	= 'super_search_total_results';
			$parsefields['standard']['search_total']				= 'search_total';

			/**	----------------------------------------
			/**	Constructed fields
			/**	----------------------------------------*/
			
			if ( ! empty( $parsefields['constructed'] ) AND ( $weblog_ids = $this->_weblog_ids() ) !== FALSE )
			{
				$parsefields['standard']['auto_path']					= 'auto_path';
				$parsefields['standard']['comment_entry_id_auto_path']	= 'comment_entry_id_auto_path';
				$parsefields['standard']['comment_url_title_auto_path']	= 'comment_url_title_auto_path';
				$parsefields['standard']['page_uri']					= 'page_uri';
				$parsefields['standard']['page_url']					= 'page_url';
				$parsefields['standard']['weblog']						= 'weblog';
				$parsefields['standard']['weblog_short_name']			= 'weblog_short_name';
				
				$path = ( empty( $weblog_ids[ $row['weblog_id'] ]['comment_url'] ) === TRUE ) ? $weblog_ids[ $row['weblog_id'] ]['blog_url']: $weblog_ids[ $row['weblog_id'] ]['comment_url'];
				
				//	Comment entry id auto path
				$row['comment_entry_id_auto_path']	= $path.$row['entry_id'].'/';
				
				//	Comment url title auto path
				$row['comment_url_title_auto_path']	= $path.$row['url_title'].'/';
				
				$path = ( empty( $weblog_ids[ $row['weblog_id'] ]['search_results_url'] ) === TRUE ) ? $weblog_ids[ $row['weblog_id'] ]['blog_url']: $weblog_ids[ $row['weblog_id'] ]['search_results_url'];
				
				//	Auto path
				$row['auto_path']					= $path.$row['url_title'].'/';
				
				//	Weblog
				$row['weblog']						= $weblog_ids[ $row['weblog_id'] ]['blog_title'];
				
				//	Weblog short name
				$row['weblog_short_name']			= $weblog_ids[ $row['weblog_id'] ]['blog_name'];

				//	Page URI
				if ( $site_pages !== FALSE AND isset( $site_pages['uris'][$row['entry_id']] ) )
				{
					$row['page_uri'] = $site_pages['uris'][$row['entry_id']];
					$row['page_url'] = $FNS->create_url( $site_pages['uris'][$row['entry_id']] );
				}
				
				// Prepare relevance count
				if ( isset( $parsefields['constructed']['relevance_count'] ) === TRUE AND isset( $relevance ) === TRUE AND $relevance !== FALSE )
				{
					$parsefields['standard']['relevance_count']	= 'relevance_count';
					$row['relevance_count']						= $this->_relevance_count( $relevance, $row );
				}
			}

			/**	----------------------------------------
			/**	'weblog_entries_tagdata' hook.
			/**	----------------------------------------
			/*	What's this doing here? This hook is copied from the Weblog object. Doing this creates instant compatibility with other extensions that work on that hook. Why not?
			/**	----------------------------------------*/
			
			if ($EXT->active_hook('weblog_entries_tagdata') === TRUE)
			{
				$tagdata = $EXT->call_extension('weblog_entries_tagdata', $tagdata, $row, $this);
				if ($EXT->end_script === TRUE) return $tagdata;
			}

			/**	----------------------------------------
			/**	Conditionals
			/**	----------------------------------------*/
			
			$tagdata	= $FNS->prep_conditionals( $tagdata, $row );
			$tagdata	= $this->_parse_switch( $tagdata );

			/**	----------------------------------------
			/**	Loop for dates
			/**	----------------------------------------*/
			
			if ( empty( $dates ) === FALSE )
			{			
				foreach ( $dates as $field => $date )
				{
					foreach ( $date as $key => $val )
					{					
						if ( isset( $row[$field] ) === TRUE AND is_numeric( $row[$field] ) === TRUE )
						{
							$tagdata	= str_replace( LD.$val['full'].RD, $this->_parse_date( $val['format'], $row[$field] ), $tagdata );
						}
					}
				}
			}

			/**	----------------------------------------
			/**	Loop for custom fields
			/**	----------------------------------------*/
			
			if ( empty( $parsefields['custom'] ) === FALSE )
			{
				foreach ( $parsefields['custom'] as $key => $val )
				{
					if ( isset( $row[$key] ) === TRUE )
					{
						$field_content = $this->TYPE->parse_type( $row[$key],
							array(
								  'text_format'		=> ( isset( $row[$key.'_format'] ) === TRUE ) ? $row[$key.'_format']: 'none',
								  'html_format'		=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_html_formatting']: 'all',
								  'auto_links'		=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_auto_link_urls']: 'n',
								  'allow_img_url'	=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_allow_img_urls']: 'y',
								)
						);

						/**	----------------------------------------
						/**	Highlight keywords
						/**	----------------------------------------*/
						
						$field_content	= $this->_highlight_keywords( $field_content );
						
						$tagdata	= str_replace( LD.$key.RD, $field_content, $tagdata );
					}
				}
			}

			/**	----------------------------------------
			/**	Loop for excerpts
			/**	----------------------------------------*/
			
			if ( ! empty( $parsefields['excerpt'][$row['weblog_id']] ) )
			{			
				if ( isset( $row['excerpt_'.$parsefields['excerpt'][$row['weblog_id']]] ) === TRUE )
				{
					$field_content = $this->TYPE->parse_type( $row['excerpt_'.$parsefields['excerpt'][$row['weblog_id']]],
						array(
							  'text_format'		=> ( isset( $row['excerpt_format_'.$parsefields['excerpt'][$row['weblog_id']]] ) === TRUE ) ? $row['excerpt_format_'.$parsefields['excerpt'][$row['weblog_id']]]: 'none',
							  'html_format'		=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_html_formatting']: 'all',
							  'auto_links'		=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_auto_link_urls']: 'n',
							  'allow_img_url'	=> ( isset( $weblogs[$row['weblog_id']] ) === TRUE ) ? $weblogs[$row['weblog_id']]['weblog_allow_img_urls']: 'y',
							)
					);

					/**	----------------------------------------
					/**	Highlight keywords
					/**	----------------------------------------*/
					
					$field_content	= $this->_highlight_keywords( $field_content );
					
					$tagdata	= str_replace( LD.'excerpt'.RD, $field_content, $tagdata );
				}
			}

			/**	----------------------------------------
			/**	Loop for standard fields
			/**	----------------------------------------*/
			
			foreach ( $parsefields['standard'] as $key => $val )
			{
				/**	----------------------------------------
				/**	Simple
				/**	----------------------------------------*/
			
				if ( isset( $row[$key] ) === TRUE )
				{
					/**	----------------------------------------
					/**	Highlight keywords
					/**	----------------------------------------*/
					
					$row[$key]	= $this->_highlight_keywords( $row[$key] );
						
					$tagdata	= str_replace( LD.$key.RD, $row[$key], $tagdata );
				}
			}

			/**	----------------------------------------
			/**	Loop for member fields
			/**	----------------------------------------*/
			
			if ( empty( $parsefields['member'] ) === FALSE )
			{
				foreach ( $parsefields['member'] as $key => $val )
				{
					/**	----------------------------------------
					/**	Simple
					/**	----------------------------------------*/
				
					if ( isset( $row[$key] ) === TRUE )
					{						
						$tagdata	= str_replace( LD.$key.RD, $row[$key], $tagdata );
					}
				}
			}			

			/**	----------------------------------------
			/**	Clean up empties
			/**	----------------------------------------*/
			
			$ignore_vars	= array( 'app_build', 'app_version', 'charset', 'hits', 'homepage', 'ip_address', 'lang' );
			
			foreach ( $TMPL->var_single as $val )
			{
				if ( strpos( $tagdata, LD.$val.RD ) === FALSE OR in_array( $val, $ignore_vars ) === TRUE ) continue;
				$tagdata	= str_replace( LD.$val.RD, '', $tagdata );
			}
		
			/**	----------------------------------------
			/**	Concat
			/**	----------------------------------------*/
			
			$r	.= $tagdata;
		}
		
		/** -------------------------------------
		/**	Save ids so that our allow_repeats param will work. This lets is exclude entries from showing again in the same session if we have already retrieved them. This is dependent on the linear parsing order of course. You can't know what a later super search call will retrieve and you don't care. Linear is sufficient.
		/** -------------------------------------*/
		
		if ( empty( $this->sess['previous_entries'] ) )
		{
			$this->sess['previous_entries']	= array();
		}
		
		$this->sess['previous_entries']	= array_merge( $this->sess['previous_entries'], array_unique( $used_ids ) );

		/** ----------------------------------------
		/**  Add Pagination
		/** ----------------------------------------*/

		if ($this->paginate === FALSE)
		{
			$TMPL->tagdata = preg_replace("/".LD."if paginate".RD.".*?".LD."&#47;if".RD."/s", '', $TMPL->tagdata);
		}
		else
		{
			$TMPL->tagdata = preg_replace("/".LD."if paginate".RD."(.*?)".LD."&#47;if".RD."/s", "\\1", $TMPL->tagdata);
			
			$this->paginate_data	= str_replace( LD.'pagination_links'.RD, $this->pager, $this->paginate_data);
			$this->paginate_data	= str_replace(LD.'current_page'.RD, $this->current_page, $this->paginate_data);
			$this->paginate_data	= str_replace(LD.'total_pages'.RD,	$this->total_pages, $this->paginate_data);
			$this->paginate_data	= str_replace(LD.'page_count'.RD,	$this->page_count, $this->paginate_data);
		}
    	
		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
		
		if ( $TMPL->fetch_param('paginate') == 'both' )
		{
			$r	= $this->paginate_data.$r.$this->paginate_data;
		}
		elseif ( $TMPL->fetch_param('paginate') == 'top' )
		{
			$r	= $this->paginate_data.$r;
		}
		else
		{
			$r	= $r.$this->paginate_data;
		}
        
		$TMPL->log_item( 'Super Search: Ending _fast_entries('.(microtime(TRUE) - $t).')' );
		
		return $r;
	}
	
	/*	End fast entries */

    // --------------------------------------------------------------------

	/**
	 * Fields
	 *
	 * We later wrote a weblog routine that could speed this up by eliminating the JOIN. Revisit.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _fields( $weblog = 'searchable', $site_ids = array() )
	{
		global $DB, $EXT, $PREFS, $TMPL;
		
		if ( ( $fields = $this->sess( 'fields', $weblog ) ) !== FALSE )
		{
			return $fields;
		}
		
		if ( empty( $site_ids ) === TRUE )
		{
			if ( $TMPL )
			{
				$site_ids	= $TMPL->site_ids;
			}
			else
			{
				$site_ids	= array( $PREFS->ini('site_id') );
			}
		}
		
		$columns	= array(
			'wf.field_id',
			'wf.field_name',
			'wf.field_search',
			'wf.field_type',
			'wf.field_text_direction',
			'w.weblog_id',
			'w.blog_name'
		);

		/**	----------------------------------------
		/**	Add Gypsy test
		/**	----------------------------------------
		/*	Gypsy is an extension by Brandon Kelly that allows one weblog field to be used by multiple weblogs regardless of whether the field belongs to the field group assigned a given weblog or not.
		/**	----------------------------------------*/
		
		if ( ! empty( $EXT->OBJ['Gypsy'] ) )
		{
			$columns[]	= 'wf.field_is_gypsy';
			$columns[]	= 'wf.gypsy_weblogs';
		}

		/**	----------------------------------------
		/**	Begin SQL
		/**	----------------------------------------*/
		
		$sql	= "/* Super Search get fields */ SELECT " . implode( ',', $columns ) . "
					FROM exp_weblog_fields wf
					LEFT JOIN exp_weblogs w ON w.field_group = wf.group_id
					WHERE wf.site_id IN (".implode( ",", $site_ids ).")
					AND w.weblog_id != ''";

		/**	----------------------------------------
		/**	Filter out a custom field by the name of keywords? 'keywords' is a reserved word in Super Search. We're going to get into trouble for this one.
		/**	----------------------------------------*/
		
		$sql	.= " AND wf.field_name != 'keywords'";

		/**	----------------------------------------
		/**	Weblog id restriction?
		/**	----------------------------------------*/
		
		if ( ( $weblog_ids = $this->sess( 'search', 'weblog_ids' ) ) !== FALSE )
		{
			/**	----------------------------------------
			/**	Test for Gypsy
			/**	----------------------------------------*/
			
			if ( ! empty( $EXT->OBJ['Gypsy'] ) )
			{
				$sql	.= " AND ( ( wf.field_is_gypsy = 'y' AND wf.gypsy_weblogs != '' ) OR w.weblog_id IN (" . implode( ',', $weblog_ids ) . ") )";
			}
			else
			{
				$sql	.= " AND w.weblog_id IN (" . implode( ',', $weblog_ids ) . ")";
			}
		}

		/**	----------------------------------------
		/**	Run query
		/**	----------------------------------------*/
		
		$query	= $DB->query( $sql );
		
		$arr						= array();
		$fmt						= array();
		$general					= array();
		$field_to_weblog_map		= array();
		$field_to_weblog_map_sql	= array();
		
		if ( $query->num_rows > 0 )
		{
			foreach ( $query->result as $row )
			{
				$arr['all'][$row['field_name']]	= $row['field_id'];
				$general['all'][$row['field_name']]	= $row;
						
				$arr[$row['blog_name']]['title']		= 'title';
				$arr['searchable']['title']			= 'title';
				$general[$row['blog_name']]['title']	= array('title');
				$general['searchable']['title']		= array('title');
				$fmt[$row['field_name']]						= 'ltr';
				$field_to_weblog_map[ 'title' ][ $row['weblog_id'] ]	= $row['weblog_id'];
				
				if ( $row['field_search'] == 'y' )
				{
					/**	----------------------------------------
					/**	When we construct a list of fields, we need to include Gypsy fields, but only if we are filtering by weblog. Otherwise they are included anyway.
					/**	----------------------------------------*/
			
					if ( isset( $row['field_is_gypsy'] ) AND $row['field_is_gypsy'] == 'y' AND isset( $row['gypsy_weblogs'] ) AND $row['gypsy_weblogs'] != '' )
					{
						$gypsy_blogs	= $this->_remove_empties( preg_split( '/\s+|\|/s', $row['gypsy_weblogs'] ) );
					
						if ( in_array( $row['weblog_id'], $gypsy_blogs ) === TRUE )
						{
							$arr[$row['blog_name']][$row['field_name']]		= $row['field_id'];
							$arr['searchable'][$row['field_name']]			= $row['field_id'];
							$general[$row['blog_name']][$row['field_name']]	= $row;
							$general['searchable'][$row['field_name']]		= $row;
							$fmt[$row['field_name']]						= $row['field_text_direction'];
							
							foreach ( $gypsy_blogs as $gblog )
							{
								$field_to_weblog_map[ $row['field_id'] ][ $gblog ]	= $gblog;
							}
						}
					}
					elseif ( empty( $weblog_ids ) OR in_array( $row['weblog_id'], $weblog_ids ) === TRUE )
					{
						$arr[$row['blog_name']][$row['field_name']]		= $row['field_id'];
						$arr['searchable'][$row['field_name']]			= $row['field_id'];
						$general[$row['blog_name']][$row['field_name']]	= $row;
						$general['searchable'][$row['field_name']]		= $row;
						$fmt[$row['field_name']]						= $row['field_text_direction'];
						$field_to_weblog_map[ $row['field_id'] ][ $row['weblog_id'] ]	= $row['weblog_id'];
					}					
				}
			}

			/**	----------------------------------------
			/**	Prepare field to weblog map
			/**	----------------------------------------*/
			
			foreach ( $field_to_weblog_map as $field_id => $temp_weblog_ids )
			{
				if ( count( $temp_weblog_ids ) > 1 )
				{
					$field_to_weblog_map_sql[ $field_id ]	= ' AND wd.weblog_id IN (' . implode( ',', $temp_weblog_ids ) . ')';
				}
				elseif ( count( $temp_weblog_ids ) == 1 )
				{
					$field_to_weblog_map_sql[ $field_id ]	= ' AND wd.weblog_id = ' . implode( '', $temp_weblog_ids );
				}
			}

			$this->sess['fields']				= $arr;
			$this->sess['fields_fmt']			= $fmt;
			$this->sess['general_field_data']	= $general;
			$this->sess['field_to_weblog_map_sql']	= $field_to_weblog_map_sql;
			return ( isset( $arr[$weblog] ) === TRUE ) ? $arr[$weblog]: FALSE;
		}
		
		return FALSE;
	}
	
	/*	End fields */

    // --------------------------------------------------------------------

	/**
	 * Forget last search
	 *
	 * This method deletes the user's last search from the DB if it is found.
	 *
	 * @access	private
	 * @return	string
	 */
    
    function forget_last_search()
    {
    	global $DB, $FNS, $LANG, $PREFS, $SESS, $TMPL;
    	
    	$tagdata	= $TMPL->tagdata;

		/**	----------------------------------------
		/**	Delete
		/**	----------------------------------------*/
		
		$sql	= "DELETE FROM exp_super_search_history
					WHERE site_id = ".$DB->escape_str( $PREFS->ini('site_id') );
					
		$sql	.= " AND saved = 'n'
					AND ( (
							member_id != 0
							AND member_id = ".$DB->escape_str( $SESS->userdata('member_id') )." )";
							
		$sql	.= " OR ( cookie_id = '".$DB->escape_str( $this->_get_users_cookie_id() )."' ) )
					LIMIT 1";
					
		$DB->query( $sql );
		
		if ( $DB->affected_rows == 0 )
		{
			$message	= $LANG->line( 'no_search_history_was_found' );
			
			$tagdata	= $FNS->prep_conditionals( $tagdata, array( 'failure' => TRUE, 'success' => FALSE ) );
			$tagdata	= str_replace( LD.'message'.RD, $message, $tagdata );
			return $tagdata;
		}
		else
		{
			$message	= $LANG->line( 'last_search_cleared' );
			
			$tagdata	= $FNS->prep_conditionals( $tagdata, array( 'failure' => FALSE, 'success' => TRUE ) );
			$tagdata	= str_replace( LD.'message'.RD, $message, $tagdata );
			return $tagdata;
		}
    }
    
    /*	End forget last search */

    // --------------------------------------------------------------------

	/**
	 * Form (sub)
	 *
	 * This method receives form config info and returns a properly formated EE form.
	 *
	 * @access	private
	 * @return	string
	 */
    
    function _form( $data = array() )
    {
    	global $FNS, $TMPL;
    	
    	if ( count( $data ) == 0 ) return '';
    	
    	if ( ! isset( $data['tagdata'] ) OR $data['tagdata'] == '' )
    	{
			$tagdata	=	$TMPL->tagdata;
    	}
    	else
    	{
    		$tagdata	= $data['tagdata'];
    		unset( $data['tagdata'] );
    	}
		
		/** --------------------------------------------
        /**  Special Handling for return="" parameter
        /** --------------------------------------------*/

		foreach( array('return', 'RET') as $val )
		{
			if ( isset( $data[$val] ) AND $data[$val] !== FALSE AND $data[$val] != '' )
			{
				$data[$val] = str_replace(SLASH, '/', $data[$val]);
			
				if ( preg_match( "/".LD."\s*path=(.*?)".RD."/", $data[$val], $match ))
				{
					$data[$val] = $FNS->create_url( $match['1'] );
				}
				elseif ( stristr( $data[$val], "http://" ) === FALSE )
				{
					$data[$val] = $FNS->create_url( $data[$val] );
				}
			}
		}

		/**	----------------------------------------
		/**	Generate form
		/**	----------------------------------------*/
		
		$arr	=	array(
						'action'		=> $FNS->fetch_site_index(),
						'id'			=> $data['form_id'],
						'enctype'		=> '',
						'onsubmit'		=> ( isset( $data['onsubmit'] ) ) ? $data['onsubmit'] : ''
						);
						
		$arr['onsubmit'] = ( $TMPL->fetch_param('onsubmit') ) ? $TMPL->fetch_param('onsubmit') : $arr['onsubmit'];
						
		if ( isset( $data['name'] ) !== FALSE )
		{
			$arr['name']	= $data['name'];
			unset( $data['name'] );
		}
		
		unset( $data['form_id'] );
		unset( $data['onsubmit'] );
		
		$arr['hidden_fields']	= $data;		
		
		/** --------------------------------------------
        /**  HTTPS URLs?
        /** --------------------------------------------*/
		
		if ($TMPL->fetch_param('secure_action') == 'yes')
		{
			if (isset($arr['action']))
			{
				$arr['action'] = str_replace('http://', 'https://', $arr['action']);
			}
		}
		
		if ($TMPL->fetch_param('secure_return') == 'yes')
		{
			foreach(array('return', 'RET') as $return_field)
			{
				if (isset($arr['hidden_fields'][$return_field]))
				{
					if ( preg_match( "/".LD."\s*path=(.*?)".RD."/", $arr['hidden_fields'][$return_field], $match ) > 0 )
					{
						$arr['hidden_fields'][$return_field] = $FNS->create_url( $match['1'] );
					}
					elseif ( stristr( $arr['hidden_fields'][$return_field], "http://" ) === FALSE )
					{
						$arr['hidden_fields'][$return_field] = $FNS->create_url( $arr['hidden_fields'][$return_field] );
					}
				
					$arr['hidden_fields'][$return_field] = str_replace('http://', 'https://', $arr['hidden_fields'][$return_field]);
				}
			}
		}
		
		/** --------------------------------------------
        /**  Override Form Attributes with form:xxx="" parameters
        /** --------------------------------------------*/
        
        $extra_attributes = array();
        
        if (is_object($TMPL) && ! empty($TMPL->tagparams))
		{
			foreach($TMPL->tagparams as $key => $value)
			{
				if (strncmp($key, 'form:', 5) == 0)
				{
					if (isset($arr[substr($key, 5)]))
					{
						$arr[substr($key, 5)] = $value;
					}
					else
					{
						$extra_attributes[substr($key, 5)] = $value;
					}
				}
			}
		}
		
		/** --------------------------------------------
        /**  Create Form
        /** --------------------------------------------*/
				
        $r	= $FNS->form_declaration( $arr );
        
        $r	.= stripslashes($tagdata);
        
        $r	.= "</form>";

		/**	----------------------------------------
		/**	 Add <form> attributes from 
		/**	----------------------------------------*/
		
		$allowed = array('accept', 'accept-charset', 'enctype', 'method', 'action',
						 'name', 'target', 'class', 'dir', 'id', 'lang', 'style',
						 'title', 'onclick', 'ondblclick', 'onmousedown', 'onmousemove',
						 'onmouseout', 'onmouseover', 'onmouseup', 'onkeydown', 
						 'onkeyup', 'onkeypress', 'onreset', 'onsubmit');
		
		foreach($extra_attributes as $key => $value)
		{
			if ( ! in_array($key, $allowed)) continue;
			
			$r = str_replace( "<form", '<form '.$key.'="'.htmlspecialchars($value).'"', $r );
		}

		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
        
		return str_replace('{/exp:', LD.SLASH.'exp:', str_replace(SLASH, '/', $r));
    }
    
    /*	End form */

    // --------------------------------------------------------------------

	/**
	 * Get cat group ids
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _get_cat_group_ids()
	{
		global $DB, $TMPL;
        
        /** -------------------------------------
        /**	Get weblog ids
        /** -------------------------------------
		/**	It helps to have a weblog to make sense of the textual categories provided. By this point we already have determined weblog ids, but we'll be cautious.
		/** -------------------------------------*/
		
		if ( ( $weblog_ids = $this->sess( 'search', 'weblog_ids' ) ) === FALSE )
		{
			return FALSE;
		}
		
        /** -------------------------------------
		/**	Already fetched groups?
		/** -------------------------------------*/
		
		if ( $this->sess( 'cat_group_ids' ) === FALSE )
		{
			$sql	= '/* Super Search fetch group ids */ SELECT group_id FROM exp_category_groups WHERE site_id IN ('.implode( ',', $TMPL->site_ids ).')';
			
			$query	= $DB->query( $sql );
			
			$group_ids	= array();
			
			foreach ( $query->result as $row )
			{
				$group_ids[$row['group_id']]	= $row;
			}

			$this->sess['cat_group_ids']	= $group_ids;
		}
		
        /** -------------------------------------
		/**	Loop and return group ids
		/** -------------------------------------*/
		
		$ids	= array();
		
		foreach ( $weblog_ids as $id )
		{
			if ( ( $gid = $this->_weblogs( $id, 'cat_group' ) ) !== FALSE )
			{
				$ids	= array_merge( $ids, explode( '|', $gid ) );
			}
		}
		
		if ( count( $ids ) == 0 ) return FALSE;
		
		return $ids;
	}
	
	/*	End get cat group ids */

    // --------------------------------------------------------------------

	/**
	 * Get field type
	 *
	 * Sometimes we need to know the actual MySQL field type so that we can format our search strings correctly. For example, when we use range searching on a custom field and that field contains price data, we need to strip the $ from the search string so that the search will run correctly.
	 *
	 * @access		private
	 * @argument	$field	text
	 * @return		string
	 */
	 
	function _get_field_type( $field = '' )
	{
		global $DB;
		
		if ( $field == '' ) return FALSE;
		
        /** -------------------------------------
		/**	Saved in cache?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['field_types'][$field] ) === FALSE )
		{
			return $this->sess['field_types'][$field];
		}
		
        /** -------------------------------------
		/**	Get all fields from DB
		/** -------------------------------------*/
		
		$query	= $DB->query( "/* Super Search mod.super_search.php _get_field_type() */ DESCRIBE exp_weblog_data" );

		$flipfields	= array_flip( $this->_fields() );
		
		foreach ( $query->result as $row )
		{
			if ( strpos( $row['Field'], 'field_id_' ) !== FALSE )
			{
				$num	= str_replace( 'field_id_', '', $row['Field'] );
				
				if ( isset( $flipfields[$num] ) === TRUE )
				{
					if ( strpos( $row['Type'], 'decimal' ) !== FALSE OR strpos( $row['Type'], 'float' ) !== FALSE OR strpos( $row['Type'], 'int' ) !== FALSE )
					{
						$this->sess['field_types'][ $flipfields[$num] ]	= 'numeric';
					}
					else
					{
						$this->sess['field_types'][ $flipfields[$num] ]	= 'textual';
					}
				}
			}
		}
		
        /** -------------------------------------
		/**	How about now?
		/** -------------------------------------*/
		
		if ( empty( $this->sess['field_types'][$field] ) === FALSE )
		{
			return $this->sess['field_types'][$field];
		}
		
		return FALSE;
	}
	
	/*	End get field type */

    // --------------------------------------------------------------------

	/**
	 * Get ids by category
	 *
	 * We don't allow any fudge here. Provided categories must be exact.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _get_ids_by_category( $category = array() )
	{
		global $DB, $TMPL;
		
        /** -------------------------------------
		/**	Anything to work with?
		/** -------------------------------------*/
		
		if ( is_array( $category ) === FALSE OR count( $category ) == 0 ) return FALSE;
		
		$t	= microtime(TRUE);
		$TMPL->log_item( 'Super Search: Beginning _get_ids_by_category()' );
        
        /** -------------------------------------
		/**	Get category group ids
		/** -------------------------------------*/
		
		if ( ( $group_ids = $this->_get_cat_group_ids() ) === FALSE )
		{
			$group_ids = array();
		}
        
        /** -------------------------------------
		/**	Do we have 'and's?
		/** -------------------------------------*/
		
		if ( empty( $category['and'] ) === FALSE )
		{
			foreach ( $category['and'] as $val )
			{
				if ( $val == '' ) continue;
				
				$and[]	= $DB->escape_str( $val );
			}
		}
        
        /** -------------------------------------
		/**	Do we have 'not's?
		/** -------------------------------------*/
		
		if ( empty( $category['not'] ) === FALSE )
		{
			foreach ( $category['not'] as $val )
			{
				if ( $val == '' ) continue;
				
				$not[]	= $DB->escape_str( $val );
			}
		}
        
        /** -------------------------------------
		/**	Do we have 'or's?
		/** -------------------------------------*/
		
		if ( empty( $category['or'] ) === FALSE )
		{
			foreach ( $category['or'] as $val )
			{
				if ( $val == '' ) continue;
				
				$or[]	= $DB->escape_str( $val );
			}
		}
        
        /** -------------------------------------
		/**	Empty?
		/** -------------------------------------*/
		
		if ( empty( $and ) === TRUE AND empty( $not ) === TRUE AND empty( $or ) === TRUE ) return FALSE;
        
        /** -------------------------------------
		/**	Query by cat_url_title or cat_name?
		/** -------------------------------------*/
		
		$cat_name_query	= ( $TMPL->fetch_param('category_indicator') !== FALSE AND $TMPL->fetch_param('category_indicator') != 'category_url_title' ) ? 'c.cat_name': 'c.cat_url_title';
        
        /** -------------------------------------
		/**	Assemble sql
		/** -------------------------------------*/
		
		$select	= '/* Super Search get entries by category for later comparison */ SELECT cp.entry_id';
		$from	= ' FROM exp_category_posts cp';
		$join	= ' LEFT JOIN exp_categories c ON cp.cat_id = c.cat_id';
		$where	= ' WHERE c.site_id IN ('.implode( ',', $TMPL->site_ids ).')';
        
        /** -------------------------------------
		/**	Group ids?
		/** -------------------------------------*/
		
		if ( count( $group_ids ) > 0 )
		{
			$where	.= ' AND c.group_id IN ('.implode( ',', $group_ids ).')';
		}
        
        /** -------------------------------------
		/** And's
        /** -------------------------------------
        /*	This is our gnarly case. We're assembling an array of entry ids that belong to all the 'and'ed categories. Then passing that to our main query as a requirement.
		/** -------------------------------------*/
		
		if ( empty( $and ) === FALSE )
		{
			if ( ( $newand = $this->_separate_numeric_from_textual( $and ) ) !== FALSE )
			{
				$sql	= "/* Super Search fetch gnarly conjoined category entries for later comparison */ SELECT cp.cat_id, cp.entry_id".$from.$join.$where." AND ( c.cat_id IN (".implode( ",", $newand['numeric'] ).")";
				
				if ( empty( $newand['textual'] ) === FALSE )
				{
					$sql	.= " OR ".$cat_name_query." IN ('".implode( "','", $newand['textual'] )."')";
				}
				
				$sql	.= ")";
			}
			else
			{
				$sql	= '/* Super Search fetch entries by category */ SELECT cp.cat_id, cp.entry_id'.$from.$join.$where.' AND '.$cat_name_query." IN ('".implode( "','", $and )."')";
			}
			
			unset( $newand );
			
			$query	= $DB->query( $sql );
			
			if ( $query->num_rows > 0 )
			{
				$ids	= array();
				$chosen	= array();
				
				foreach ( $query->result as $row )
				{
					$ids[ $row['cat_id'] ][]	= $row['entry_id'];
					$chosen[]	= $row['entry_id'];
				}
				
				if ( count( $ids ) > 1 )
				{
					$chosen = call_user_func_array('array_intersect', $ids);
					$chosen	= array_unique( $chosen );
				}
				
				unset( $ids );
        
				/** -------------------------------------
				/**	Get out now?
				/** -------------------------------------
				/*	If we have no $or or $not tests, then we care only about entry ids that belong to ALL our $and categories inclusive. We can escape now since hitting the DB would be redundant.
				/** -------------------------------------*/
				
				if ( empty( $not ) === TRUE AND empty( $or ) === TRUE AND empty( $chosen ) === FALSE )
				{					
					return $chosen;
				}
        
				/** -------------------------------------
				/**	Add $chosen to our eventual query
				/** -------------------------------------*/
				
				if ( empty( $chosen ) === FALSE )
				{
					$where	.= ' AND cp.entry_id IN ('.implode( ',', $chosen ).')';
				}
			}
        
			/** -------------------------------------
			/**	Fail-safe test for $and
			/** -------------------------------------
			/*	If we had an 'and' query, but it returned no entry ids, then we need to fail out, because nothing beyond this point will meet our requirements.
			/** -------------------------------------*/
			
			if ( empty( $chosen ) === TRUE )
			{
				return FALSE;
			}
		}
        
        /** -------------------------------------
		/**	Not's
		/** -------------------------------------*/
		
		if ( empty( $not ) === FALSE )
		{
			if ( ( $newnot = $this->_separate_numeric_from_textual( $not ) ) !== FALSE )
			{
				$where	.= ' AND c.cat_id NOT IN ('.implode( ',', $newnot['numeric'] ).')';
				
				if ( empty( $newnot['textual'] ) === FALSE )
				{
					$where	.= ' AND '.$cat_name_query." NOT IN ('".implode( "','", $newnot['textual'] )."')";
				}
			}
			else
			{
				$where	.= ' AND '.$cat_name_query." NOT IN ('".implode( "','", $not )."')";
			}
			
			unset( $newnot );
		}
        
        /** -------------------------------------
		/**	Or's
		/** -------------------------------------*/
		
		if ( empty( $or ) === FALSE )
		{
			if ( ( $newor = $this->_separate_numeric_from_textual( $or ) ) !== FALSE )
			{
				$where	.= ' AND c.cat_id IN ('.implode( ',', $newor['numeric'] ).')';
				
				if ( empty( $newor['textual'] ) === FALSE )
				{
					$where	.= ' AND '.$cat_name_query." IN ('".implode( "','", $newor['textual'] )."')";
				}
			}
			else
			{
				$where	.= ' AND '.$cat_name_query." IN ('".implode( "','", $or )."')";
			}			
		}
        
        /** -------------------------------------
		/** Run it
		/** -------------------------------------*/
		
		$sql	= $select.$from.$join.$where;
		
		// print_r( $sql );
		
		$query	= $DB->query( $sql );
		
		if ( $query->num_rows == 0 )
		{
			$TMPL->log_item( 'Super Search: Ending _get_ids_by_category() ('.(microtime(TRUE) - $t).')' );
			return FALSE;
		}
		
		$ids	= array();
		
		foreach ( $query->result as $row )
		{
			$ids[]	= $row['entry_id'];
		}

		$TMPL->log_item( 'Super Search: Ending _get_ids_by_category() ('.(microtime(TRUE) - $t).')' );
		
		return $ids;
	}
	
	/*	End get ids by category */

    // --------------------------------------------------------------------

	/**
	 * Get ids by category like
	 *
	 * We don't allow any fudge above, but we do here. This method allows people to supply a category approximation in the search like 'categorylike+bedford'. This will return entries with the category of 'Bedford Stuyvesant' or 'Bedford Place' or 'Bedford'.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _get_ids_by_category_like( $category = array() )
	{
		global $DB, $TMPL;
		
        /** -------------------------------------
		/**	Anything to work with?
		/** -------------------------------------*/
		
		if ( is_array( $category ) === FALSE OR count( $category ) == 0 ) return FALSE;
		
		$t	= microtime(TRUE);
		$TMPL->log_item( 'Super Search: Beginning _get_ids_by_category_like()' );
        
        /** -------------------------------------
		/**	Get category group ids
		/** -------------------------------------*/
		
		if ( ( $group_ids = $this->_get_cat_group_ids() ) === FALSE )
		{
			$group_ids = array();
		}
        
        /** -------------------------------------
		/**	Do we have 'not's?
		/** -------------------------------------*/
		
		if ( empty( $category['not'] ) === FALSE )
		{
			foreach ( $category['not'] as $val )
			{
				if ( $val == '' ) continue;
				
				$not[]	= $DB->escape_str( $val );
			}
		}
        
        /** -------------------------------------
		/**	Do we have 'or's?
		/** -------------------------------------*/
		
		if ( empty( $category['or'] ) === FALSE )
		{
			foreach ( $category['or'] as $val )
			{
				if ( $val == '' ) continue;
				
				$or[]	= $DB->escape_str( $val );
			}
		}
        
        /** -------------------------------------
		/**	Empty?
		/** -------------------------------------*/
		
		if ( empty( $not ) === TRUE AND empty( $or ) === TRUE ) return FALSE;
        
        /** -------------------------------------
		/**	Query by cat_url_title or cat_name?
		/** -------------------------------------*/
		
		$cat_name_query	= ( $TMPL->fetch_param('category_indicator') !== FALSE AND $TMPL->fetch_param('category_indicator') != 'category_url_title' ) ? 'c.cat_name': 'c.cat_url_title';
        
        /** -------------------------------------
		/**	Assemble sql
		/** -------------------------------------*/
		
		$select	= '/* Super Search fetch entries by loose categories */ SELECT cp.entry_id';
		$from	= ' FROM exp_category_posts cp';
		$join	= ' LEFT JOIN exp_categories c ON cp.cat_id = c.cat_id';
		$where	= ' WHERE c.site_id IN ('.implode( ',', $TMPL->site_ids ).')';
        
        /** -------------------------------------
		/**	Group ids?
		/** -------------------------------------*/
		
		if ( count( $group_ids ) > 0 )
		{
			$where	.= ' AND c.group_id IN ('.implode( ',', $group_ids ).')';
		}		
        
        /** -------------------------------------
		/**	Not's
		/** -------------------------------------*/
		
		if ( empty( $not ) === FALSE )
		{
			$where	.= ' AND (';
			foreach ( $not as $val )
			{
				$where	.= $cat_name_query." NOT LIKE '%".$val."%' AND";
			}
			$where	= rtrim( $where, 'AND' );
			$where	.= ')';
		}
        
        /** -------------------------------------
		/**	Or's
		/** -------------------------------------*/
		
		if ( empty( $or ) === FALSE )
		{
			$where	.= ' AND (';
			foreach ( $or as $val )
			{
				$where	.= $cat_name_query." LIKE '%".$val."%' OR";
			}
			$where	= rtrim( $where, 'OR' );
			$where	.= ')';
		}
        
        /** -------------------------------------
		/** Run it
		/** -------------------------------------*/
		
		$sql	= $select.$from.$join.$where;
		
		// print_r( $sql );
		
		$query	= $DB->query( $sql );
		
		if ( $query->num_rows == 0 )
		{
			$TMPL->log_item( 'Super Search: Ending _get_ids_by_category_like() ('.(microtime(TRUE) - $t).')' );
			return FALSE;
		}
		
		$ids	= array();
		
		foreach ( $query->result as $row )
		{
			$ids[]	= $row['entry_id'];
		}

		$TMPL->log_item( 'Super Search: Ending _get_ids_by_category_like() ('.(microtime(TRUE) - $t).')' );
		
		return $ids;
	}
	
	/*	End get ids by category like */

    // --------------------------------------------------------------------

	/**
	 * Get uri
	 *
	 * EE applies some filtering to $IN->URI that prevents us from using quotes and = signs in the uri. It strips those as a security measure just in case someone uses a segment in an EE tag param. We need and want those for our queries and will not be making our $uri available to other parts of EE. This method goes through most of the EE security routines and skips the part where EE strips out what we want.
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _get_uri()
	{
		global $IN, $REGX;
        
        /** -------------------------------------
		/**	Second line of URI defense
		/** -------------------------------------*/
		
		$uri	= $REGX->xss_clean( $IN->sanitize( $REGX->trim_slashes( $GLOBALS['uri'] ) ) );
        
        /** -------------------------------------
		/**	Return
		/** -------------------------------------*/
		
		return rtrim( $uri, '/' ) . '/';
	}
	
	/*	End get uri */

    // --------------------------------------------------------------------

	/**
	 * Get users cookie id
	 *
	 * This method gets a user's cookie id if they have already been cookied. Otherwise a cookie id is created for them and provided.
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _get_users_cookie_id()
	{
		global $FNS, $IN;
        
        /** -------------------------------------
		/**	Have we already done this?
		/** -------------------------------------*/
		
		if ( isset( $this->sess['cookie_id'] ) === TRUE )
		{
			return $this->sess['cookie_id'];
		}
        
        /** -------------------------------------
		/**	Is their cookie already set?
		/** -------------------------------------*/
		
		if ( $IN->GBL( 'super_search_history', 'COOKIE' ) !== FALSE AND $IN->GBL( 'super_search_history', 'COOKIE' ) != '' )
		{
			return $this->sess['cookie_id']	= $IN->GBL( 'super_search_history', 'COOKIE' );
		}
        
        /** -------------------------------------
		/**	Create a cookie, set it and return it
		/** -------------------------------------*/
		
		$cookie	= mt_rand( 10000, 999999 );
		$FNS->set_cookie( 'super_search_history', $cookie, 86500 );
		return $this->sess['cookie_id']	= $cookie;
	}
	
	/*	End get users cookie id */

    // --------------------------------------------------------------------

	/**
	 * Hash it
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _hash_it( $arr = array() )
	{
		if ( is_array( $arr ) === FALSE OR count( $arr ) == 0 ) return FALSE;
		
		ksort( $arr );
		
		$this->hash	= md5( serialize( $arr ) );
		
		return $this->hash;
	}
	
	/*	End hash it */

    // --------------------------------------------------------------------

	/**
	 * Highlight keywords
	 *
	 * I know you probably want me to use regular expressions here. My experiment is to test whether
	 * rand() plus simple str_replace is faster than some complex REGEX that I wouldn't be able to 
	 * write in the first place.
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _highlight_keywords( $str = '' )
	{
		global $FNS, $TMPL;
		
		$t = microtime(TRUE);
		
		if ( $str == '' OR 
			$TMPL->fetch_param('highlight_keywords') == '' OR
			$TMPL->fetch_param('highlight_keywords') == 'no' OR 
			empty( $this->sess['search']['q']['keywords']['or'] ) === TRUE ) return $str;
		
		$tag	= 'em';
		
		if ( $TMPL->fetch_param('highlight_keywords') !== FALSE AND $TMPL->fetch_param('highlight_keywords') != '' )
		{
			switch ( $TMPL->fetch_param('highlight_keywords') )
			{
				case 'b':
					$tag	= 'b';
					break;
				case 'i':
					$tag	= 'i';
					break;
				case 'span':
					$tag	= 'span';
					break;
				case 'strong':
					$tag	= 'strong';
					break;
				default:
					$tag	= 'em';
					break;
			}
		}
		
		/** --------------------------------------------
        /**  Prepare Keywords for Highlighting
        /** --------------------------------------------*/
		
		$main		= $this->sess['search']['q']['keywords']['or']; 
		$phrases	= array();
		$words		= array();
		
		foreach ( $main as $key => $word )
		{
			if ( stripos( $str, ''.$word ) === FALSE ) continue;
		
			if ( strpos( $word, ' ' ) !== FALSE )
			{
				$phrases[]	= $word;
			}
			else
			{
				$words[] = $word;
			}
		}
		
		// Phrases happen *before* words.
		$replace = array_merge($phrases, $words);
		
		/** --------------------------------------------
        /**  No Words or Phrases for Highlighting? Return
        /** --------------------------------------------*/
		
		if ( empty( $replace ) ) return $str;
		
		/** --------------------------------------------
        /**  Cut Out Valid HTML Elements
        /** --------------------------------------------*/
        
        $this->marker = md5(time());
        
		$html_tag = <<<EVIL
								#
									</?\w+
											(
												"[^"]*" |
												'[^']*' |
												[^"'>]+
											)*
									>
								#sx
EVIL;

		$str = $this->cut($str, $html_tag);
		
		/** --------------------------------------------
        /**  Do the Replace Magic
        /** --------------------------------------------*/
        
        foreach($replace as $item)
        {
        	$str = preg_replace("/([^.\/?&]\b|^)(".preg_quote($item).")(\b[^:])/imsU" , "$1<".preg_quote($tag).">$2</".preg_quote($tag).">$3", $str);
			$str = preg_replace("|(<[A-Za-z]* [^>]*)<".preg_quote($tag).">(".preg_quote($item).")</".preg_quote($tag).">([^<]*>)|imsU" , "$1$2$3" , $str);
        }
		
		$TMPL->log_item( 'Super Search: Ending highlight_keywords('.(microtime(TRUE) - $t) );
		
		return $this->paste($str);
	}
	
	/*	End highlight keywords */

    // --------------------------------------------------------------------

	/**
	 * History
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function history()
	{
		global $DB, $FNS, $IN, $SESS, $TMPL;
        
        /** -------------------------------------
		/**	Who is this?
		/** -------------------------------------*/
		
		if ( ( $member_id = $SESS->userdata('member_id') ) === 0 )
		{
			if ( ( $cookie_id = $this->_get_users_cookie_id() ) === FALSE )
			{
				return $this->no_results( 'super_search' );
			}
		}
        
        /** -------------------------------------
		/**	Start the SQL
		/** -------------------------------------*/
		
		$sql	= "/* Super Search fetch history items */ SELECT history_id AS super_search_id, search_date AS super_search_date, search_name AS super_search_name, results AS super_search_results, saved AS super_search_saved, query
					FROM exp_super_search_history
					WHERE site_id IN ( ".implode( ',', $TMPL->site_ids )." )";
					
		if ( empty( $member_id ) === FALSE )
		{
			$sql	.= " AND member_id = ".$DB->escape_str( $member_id );
		}
		elseif ( empty( $cookie_id ) === FALSE )
		{
			$sql	.= " AND cookie_id = ".$DB->escape_str( $cookie_id );
		}
        
        /** -------------------------------------
		/**	Filter on saved?
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('saved') !== FALSE AND $TMPL->fetch_param('saved') != '' )
		{
			if ( $TMPL->fetch_param('saved') == 'yes' )
			{
				$sql	.= " AND saved = 'y'";
			}
			elseif ( $TMPL->fetch_param('saved') == 'no' )
			{
				$sql	.= " AND saved = 'n'";
			}
		}
		else
		{
			$sql	.= " AND saved = 'y'";
		}
        
        /** -------------------------------------
		/**	Order
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('order') !== FALSE AND in_array( $TMPL->fetch_param('order'), array( 'results', 'saved', 'search_date' ) ) === TRUE )
		{
			$sql	= " ORDER BY ".$TMPL->fetch_param('order');
			
			if ( $TMPL->fetch_param('sort') !== FALSE AND in_array( $TMPL->fetch_param('sort'), array( 'asc', 'desc' ) ) === TRUE )
			{
				$sql	.= " ".$TMPL->fetch_param('sort');
			}
		}
		else
		{
			$sql	.= " ORDER BY search_date DESC";
		}
        
        /** -------------------------------------
		/**	Limit
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('limit') !== FALSE AND is_numeric( $TMPL->fetch_param('limit') ) === TRUE )
		{
			$sql	.= " LIMIT ".$TMPL->fetch_param('limit');
		}
        
        /** -------------------------------------
		/**	Run query
		/** -------------------------------------*/
		
		$query	= $DB->query( $sql );
		
		if ($query->num_rows === 0 )
		{
			return $this->no_results( 'super_search' );
		}
		
		/**	----------------------------------------
		/**	Find out what we need from tagdata
		/**	----------------------------------------*/
		
		$i	= 0;
		
		foreach ( $TMPL->var_single as $key => $val )
		{
			$i++;
		
			if ( strpos( $key, 'format=' ) !== FALSE )
			{
				$full	= $key;
				$key	= preg_replace( "/(.*?)\s+format=[\"'](.*?)[\"']/s", '\1', $key );
				$dates[$key][$i]['format']	= $val;
				$dates[$key][$i]['full']	= $full;
			}
		}
	
		/**	----------------------------------------
		/**	Localize
		/**	----------------------------------------*/
		
		if ( empty( $dates ) === FALSE )
		{
			setlocale( LC_TIME, $SESS->userdata('time_format') );
		}
        
        /** -------------------------------------
		/**	Parse
		/** -------------------------------------*/
		
		$prefix	= 'super_search_';
		$r		= '';
		$vars	= array();
		
		foreach ( $query->result as $row )
		{
			$tagdata	= $TMPL->tagdata;

			/**	----------------------------------------
			/**	Prep query into row
			/**	----------------------------------------*/
			
			if ( $row['query'] != '' )
			{
				$vars	= $this->_extract_vars_from_query( unserialize( base64_decode( $row['query'] ) ) );
			}

			/**	----------------------------------------
			/**	Conditionals and switch
			/**	----------------------------------------*/
			
			$tagdata	= $FNS->prep_conditionals( $tagdata, $row );
			$tagdata	= $FNS->prep_conditionals( $tagdata, $vars );
			$tagdata	= $this->_parse_switch( $tagdata );

			/**	----------------------------------------
			/**	Loop for dates
			/**	----------------------------------------*/
			
			if ( empty( $dates ) === FALSE )
			{
				foreach ( $dates as $field => $date )
				{
					foreach ( $date as $key => $val )
					{					
						if ( isset( $row[$field] ) === TRUE AND is_numeric( $row[$field] ) === TRUE )
						{
							$tagdata	= str_replace( LD.$val['full'].RD, $this->_parse_date( $val['format'], $row[$field] ), $tagdata );
						}
					}
				}
			}
			
			unset( $row['super_search_date'] );

			/**	----------------------------------------
			/**	Regular parse
			/**	----------------------------------------*/
			
			foreach ( $row as $key => $val )
			{
				$key	= $key;
				
				if ( strpos( LD.$key, $tagdata ) !== FALSE ) continue;
				
				$tagdata	= str_replace( LD.$key.RD, $val, $tagdata );
			}

			/**	----------------------------------------
			/**	Variable parse
			/**	----------------------------------------*/
			
			foreach ( $vars as $key => $val )
			{
				$key	= $key;
				
				if ( strpos( LD.$key, $tagdata ) !== FALSE ) continue;
				
				$tagdata	= str_replace( LD.$key.RD, $val, $tagdata );
			}

			/**	----------------------------------------
			/**	Parse empties
			/**	----------------------------------------*/
			
			$tagdata	= $this->_strip_variables( $tagdata );
			
			$r	.= $tagdata;
		}
		
		return $r;
	}
	
	/*	End history */

    // --------------------------------------------------------------------

	/**
	 * Homogenize var name
	 *
	 * This methods adds the appropriate prefix of 'super_search' to the front of strings.
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _homogenize_var_name( $str = '' )
	{
		if ( strncmp( 'super_', $str, 6 ) == 0 )
		{
			$str	= str_replace( 'super_', '', $str );
		}
		
		if ( strncmp( 'search_', $str, 7 ) == 0 )
		{
			$str	= str_replace( 'search_', '', $str );
		}
		
		return 'super_search_' . $str;
	}
	
	/*	End homogenize var name */

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
	 * Parse array fields
	 *
	 * Super Search allows people to submit fields as array through POST. When they do, we need a special trick for allowing admins to manage those variables and parse them into a template. We use var pairs. The var pair is the field name with the 'super_search_ prefix' and the suffix of '_array'. When we detect a var pair of that format, we kick into parse mode. Quoted strings are replaced with underscored equivalents. Variables are available in conditionals like this, where our field name is 'kitchen_ready': {if super_search_kitchen_ready_Yes}checked="checked"{/if}
	 *
	 * @access	private
	 * @return	str
	 */
	 
	function _parse_array_fields( $tagdata = '', $vars = array() )
	{
		global $FNS, $TMPL;

		/**	----------------------------------------
		/**	Do we have funky var pairs?
		/**	----------------------------------------*/
		
		if ( preg_match_all( "/".LD."super_search_(.*?)_array".RD."(.*?)".LD.SLASH."super_search_\\1_array".RD."/s", $tagdata, $matches ) )
		{
			/**	----------------------------------------
			/**	Prep var pairs
			/**	----------------------------------------*/
			
			foreach ( array_keys( $matches[0] ) as $k )
			{
				$key	= 'super_search_' . $matches[1][$k];
				
				if ( isset( $vars[$key] ) === TRUE )
				{
					$vars[$key]	= str_replace( $this->spaces, ' ', $vars[$key] );
				
					/**	----------------------------------------
					/**	We convert the spaces in quoted strings into underscores.
					/**	----------------------------------------*/
			
					If ( preg_match_all( "/[\"|'](.*?)[\"|']/s", $vars[$key], $match ) )
					{					
						foreach ( $match[1] as $val )
						{
							$suffix	= str_replace( array( '"', "'", ' ' ), array( '', '', '_' ), $val );
							$vars[$key.'_'.$suffix]	= TRUE;
						}
						
						$vars[$key]	= preg_replace( "/[\"|'](.*?)[\"|']/s", '', $vars[$key] );
					}
					
					/**	----------------------------------------
					/**	Regular vars
					/**	----------------------------------------*/
					
					$temp	= explode( ' ', trim( $vars[$key] ) );
				
					foreach ( $temp as $val )
					{
						$vars[$key.'_'.$val]	= TRUE;
					}
				}
	
				/**	----------------------------------------
				/**	Conditionals
				/**	----------------------------------------*/
				
				$matches[2][$k]	= $FNS->prep_conditionals( $matches[2][$k], $vars );
				
				$tagdata	= str_replace( $matches[0][$k], $matches[2][$k], $tagdata );
			}
		}
		
		return $tagdata;
	}
	
	/*	End parse array fields */

    // --------------------------------------------------------------------

	/**
	 * Parse date
	 *
	 * Parses an EE date string.
	 *
	 * @access	private
	 * @return	str
	 */
	 
	function _parse_date( $format = '', $date = 0 )
	{
		global $FNS, $LOC;
	
		if ( $format == '' OR $date == 0 ) return '';
        
        /** -------------------------------------
		/**	strftime is much faster, but we have to convert date codes from what EE users expect to use
		/** -------------------------------------*/
		
		// return strftime( $format, $date );
        
        /** -------------------------------------
		/**	EE's built in date parser is slow, but for now we'll use it
		/** -------------------------------------*/		
				
		$codes	= $LOC->fetch_date_params( $format );
		
		if ( empty( $codes ) ) return '';
		
		foreach ( $codes as $code )
		{
			$format	= str_replace( $code, $LOC->convert_timestamp( $code, $date, TRUE ), $format );
		}
		
		return $format;
	}
	
	/*	End parse date */

    // --------------------------------------------------------------------

	/**
	 * Parse from template params
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _parse_from_tmpl_params()
	{
		global $IN, $TMPL;
		
		/** -------------------------------------
		/**	Parse basic parameters
		/** -------------------------------------
		/*	We are looking for a parameter that we expect to occur only once. Its argument can contain multiple terms following the Google syntax for 'and' 'or' and 'not'. 
		/** -------------------------------------*/
	
		foreach ( $this->basic as $key )
		{		
			if ( $TMPL->fetch_param($key) !== FALSE AND $TMPL->fetch_param($key) != '' )
			{
				$param	= $TMPL->fetch_param($key);
				
				/** -------------------------------------
				/**	Convert protected strings
				/** -------------------------------------*/
				
				//	Double ampersands are allowed and indicate inclusive searching
				
				if ( strpos( $param, '&&' ) !== FALSE )
				{
					$param	= str_replace( '&&', $this->ampmarker, $param );
				}
				
				//	Protect dashes for negation so that we don't have conflicts with dash in url titles
				
				if ( strpos( $param, $this->separator.'-' ) !== FALSE )
				{
					$param	= str_replace( $this->separator.'-', $this->negatemarker, $param );
				}
				
				if ( strpos( $param, '-' ) === 0 )
				{
					$param	= str_replace( '-', $this->negatemarker, $param );
				}
				
				if ( strpos( $param, SLASH ) !== FALSE OR strpos( $param, $this->slash ) !== FALSE )
				{
					$param	= str_replace( array( SLASH, $this->slash ), '/', $param );
				}
				
				$q[$key]	= $param;
			}
		}
		
		if ( empty( $q ) === TRUE ) return FALSE;
				
		ksort( $q );		
		$this->sess['uri']	= $q;
		return $q;
	}
	
	/*	End parse from template params */

    // --------------------------------------------------------------------

	/**
	 * Parse no results condition
	 *
	 * @access	private
	 * @return	boolean
	 */
	 
	function _parse_no_results_condition()
	{
		global $TMPL;
	
		if ( strpos( $TMPL->template, LD.'super_search_total_results'.RD ) !== FALSE )
		{
			$TMPL->template	= str_replace( LD.'super_search_total_results'.RD, '0', $TMPL->template );
		}
		
		return TRUE;
	}
	
	/*	End parse no results condition */

    // --------------------------------------------------------------------

	/**
	 * Parse template vars
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _parse_template_vars()
	{
		global $FNS, $TMPL;
		
		$p		= 'super_search_';
		$parse	= array();
		
		if ( ( $sess = $this->sess( 'uri' ) ) === FALSE )
		{
			$sess	= array();
		}
		
		foreach ( $this->basic as $key )
		{
			if ( strpos( $TMPL->template, LD.$p.$key.RD ) === FALSE ) continue;
			
			$parse[ $p.$key ]	= '';
		
			if ( isset( $sess[$key] ) === TRUE )
			{
				$parse[ $p.$key ]	= ( strpos( $sess[$key], $this->ampmarker ) === FALSE ) ? $sess[$key]: str_replace( $this->ampmarker, '&&', $sess[$key] );
			}
		}
		
		/** -------------------------------------
		/**	Prepare date from and date to
		/** -------------------------------------*/
		
		$parse[ $p.'date'.$this->modifier_separator.'from' ]	= '';
		$parse[ $p.'date'.$this->modifier_separator.'to' ]		= '';
			
		if ( isset( $sess['datefrom'] ) === TRUE )
		{
			$parse[ $p.'date'.$this->modifier_separator.'from' ]	= $sess['datefrom'];
		}
			
		if ( isset( $sess['dateto'] ) === TRUE )
		{
			$parse[ $p.'date'.$this->modifier_separator.'to' ]	= $sess['dateto'];
		}
		
		/** -------------------------------------
		/**	Prepare custom fields
		/** -------------------------------------*/
		
		if ( ( $fields = $this->_fields( 'searchable', $TMPL->site_ids ) ) !== FALSE )
		{
			foreach ( $fields as $key => $val )
			{
				if ( strpos( $TMPL->template, $p.$key ) === FALSE AND strpos( $TMPL->template, $p.'exact'.$this->modifier_separator.$key ) === FALSE AND strpos( $TMPL->template, $p.$key.$this->modifier_separator.'empty' ) === FALSE AND strpos( $TMPL->template, $p.$key.$this->modifier_separator.'from' ) === FALSE AND strpos( $TMPL->template, $p.$key.$this->modifier_separator.'to' ) === FALSE ) continue;
			
				$parse[ $p.$key ]			= '';
				$parse[ $p.'exact'.$this->modifier_separator.$key ]	= '';
				$parse[ $p.$key.$this->modifier_separator.'empty' ]	= '';
				$parse[ $p.$key.$this->modifier_separator.'from' ]	= '';
				$parse[ $p.$key.$this->modifier_separator.'to' ]	= '';
			
				if ( isset( $sess['field'][$key] ) === TRUE )
				{
					$parse[ $p.$key ]	= ( strpos( $sess['field'][$key], $this->ampmarker ) === FALSE ) ? $sess['field'][$key]: str_replace( $this->ampmarker, '&&', $sess['field'][$key] );
				}
				
				if ( isset( $sess['exactfield'][$key] ) === TRUE )
				{
					$parse[ $p.'exact'.$this->modifier_separator.$key ]	= ( strpos( $sess['exactfield'][$key], $this->ampmarker ) === FALSE ) ? $sess['exactfield'][$key]: str_replace( $this->ampmarker, '&&', $sess['exactfield'][$key] );
				}
				
				if ( isset( $sess['empty'][$key] ) === TRUE )
				{
					$parse[ $p.$key.$this->modifier_separator.'empty' ]	= $sess['empty'][$key];
				}
				
				if ( isset( $sess['from'][$key] ) === TRUE )
				{
					$parse[ $p.$key.$this->modifier_separator.'from' ]	= $sess['from'][$key];
				}
				
				if ( isset( $sess['to'][$key] ) === TRUE )
				{
					$parse[ $p.$key.$this->modifier_separator.'to' ]	= $sess['to'][$key];
				}
			}
		}
		
		$TMPL->template	= $this->_parse_array_fields( $TMPL->template, $parse );
		
		$TMPL->template	= $FNS->prep_conditionals( $TMPL->template, $parse );
		
		foreach ( $parse as $key => $val )
		{
			$val	= ( strpos( $val, '"' ) === FALSE AND strpos( $val, "'" ) === FALSE ) ? $val: str_replace( array( '"', "'" ), array( '&quot;', '&#039;' ), stripslashes( $val ) );
			$TMPL->template	= str_replace( LD.$key.RD, str_replace( $this->spaces, ' ', $val ), $TMPL->template );
		}
	}
	
	/*	End parse template vars */

    // --------------------------------------------------------------------

	/**
	 * Parse URI
	 *
	 * Tests for a URI segment with prefix of 'search&'. When found, explodes and parses that segment into search parameters. We remember to construct and save a URI appropriate query for use in pagination later.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _parse_uri( $str = '' )
	{
		global $EXT, $IN;
        
        /** -------------------------------------
		/**	Parse URI into search array
		/** -------------------------------------*/
		
		$q		= array();
		
		$str	= ( $str == '' ) ? $this->_get_uri(): $str;
		
		if ( strpos( $str, 'search'.$this->parser ) !== FALSE )
		{
			if ( preg_match( "/search".$this->parser."(.*?)\//s", $str, $match ) )
			{		
				$olduri	= str_replace( rtrim( $match[0], '/' ), $this->urimarker, $str );
				$this->sess['olduri']	= $olduri;
				
				/** -------------------------------------
				/**	Convert protected entities
				/** -------------------------------------*/
				
				if ( strpos( $match[1], '&#36;' ) !== FALSE )
				{
					$match[1]	= str_replace( array( '&#36;' ), array( '$' ), $match[1] );
				}
				
				if ( strpos( $match[1], $this->slash ) !== FALSE OR strpos( $match[1], SLASH ) !== FALSE )
				{
					$match[1]	= str_replace( array( SLASH, $this->slash ), '/', $match[1] );
				}
				
				$match[1]	= str_replace( ';', '', $match[1] );
			
				$newuri[]	= 'search';
				
				/** -------------------------------------
				/**	Convert protected strings
				/** -------------------------------------*/
				
				//	Double ampersands are allowed and indicate inclusive searching
				
				if ( strpos( $match[1], '&&' ) !== FALSE )
				{
					$match[1]	= str_replace( '&&', $this->ampmarker, $match[1] );
				}
				
				//	Protect dashes for negation so that we don't have conflicts with dash in url titles. Note that we only care about dashes preceded by a separator or spacer character, any other dash could be part of a valid word.
				
				if ( strpos( $match[1], $this->separator.'-' ) !== FALSE )
				{
					$match[1]	= str_replace( $this->separator.'-', $this->separator.$this->negatemarker, $match[1] );
				}
				
				if ( strpos( $match[1], $this->spaces.'-' ) !== FALSE )
				{
					$match[1]	= str_replace( $this->spaces.'-', $this->spaces.$this->negatemarker, $match[1] );
				}
				
				/** -------------------------------------
				/**	Explode the query into an array and prep it
				/** -------------------------------------*/
				
				$tmp	= explode( $this->parser, $match[1] );
				
				foreach ( $tmp as $val )
				{
					/** -------------------------------------
					/**	Parse custom fields
					/** -------------------------------------
					/*	We loop through our searchable custom fields, see if they are in the URI, log them and move on. 
					/** -------------------------------------*/
					
					if ( $this->_fields( 'searchable' ) !== FALSE )
					{
						foreach ( $this->_fields() as $key => $v )
						{
							if ( strpos( $val, $key.$this->separator ) === 0 )
							{
								$newuri[]	= $val;
								$q['field'][$key]	= str_replace( $key.$this->separator, '', $val );
							}
	
							/** -------------------------------------
							/**	We're looking for custom fields with the prefix of 'exact'. They indicate that we want an exact match on the value of that field.
							/** -------------------------------------*/
							
							if ( strpos( $val, 'exact'.$this->modifier_separator.$key.$this->separator ) === 0 )
							{
								$newuri[]	= $val;
								$q['exactfield'][$key]	= str_replace( 'exact'.$this->modifier_separator.$key.$this->separator, '', $val );
							}
	
							/** -------------------------------------
							/**	We're looking for custom fields with the prefix of 'exact' that are sent through the query string as an array. They indicate that we want an exact match on the value of that field where several values are acceptable exact matches.
							/** -------------------------------------*/
							
							if ( strpos( $val, 'exact'.$this->modifier_separator.$key ) === 0 AND preg_match( '/exact'.$this->modifier_separator.$key.'\_\d+/s', $val, $match ) )
							{
								$newuri[]	= $val;
								$temp = explode( $this->separator, $val );
								if ( isset( $temp[1] ) === FALSE ) continue;
								$q['exactfield'][$key][]	= $temp[1];
							}
							
							if ( strpos( $val, $key.$this->modifier_separator.'empty'.$this->separator ) === 0 )
							{							
								$newuri[]	= $val;
								$q['empty'][$key]	= str_replace( $key.$this->modifier_separator.'empty'.$this->separator, '', $val );
							}
							
							if ( strpos( $val, $key.$this->modifier_separator.'from'.$this->separator ) === 0 )
							{							
								$newuri[]	= $val;
								$q['from'][$key]	= str_replace( $key.$this->modifier_separator.'from'.$this->separator, '', $val );
							}
							
							if ( strpos( $val, $key.$this->modifier_separator.'to'.$this->separator ) === 0 )
							{
								$newuri[]	= $val;
								$q['to'][$key]	= str_replace( $key.$this->modifier_separator.'to'.$this->separator, '', $val );
							}
						}
					}

					if ( isset( $q['exactfield'] ) === TRUE ) ksort( $q['exactfield'] );
					if ( isset( $q['field'] ) === TRUE ) ksort( $q['field'] );
					
					/** -------------------------------------
					/**	Parse date ranges
					/** -------------------------------------
					/*	datefrom and dateto can be provided in order to find ranges of entries by date. 20090601 = June 1, 2009. 2009 = 2009. 200906 = June 2009. 2009060105 = 5 am June 1, 2009. 20090601053020 = 5:30 am and 20 seconds June 1, 2009. 2009060123 = 11 pm June 1, 2009.
					/** -------------------------------------*/
					
					if ( strpos( $val, 'date'.$this->modifier_separator.'from' ) !== FALSE )
					{
						$newuri[]	= $val;
						$q['datefrom']	= str_replace( 'date'.$this->modifier_separator.'from'.$this->separator, '', $val );
					}
					
					if ( strpos( $val, 'date'.$this->modifier_separator.'to' ) !== FALSE )
					{
						$newuri[]	= $val;
						$q['dateto']	= str_replace( 'date'.$this->modifier_separator.'to'.$this->separator, '', $val );
					}
					
					/** -------------------------------------
					/**	Parse basic parameters
					/** -------------------------------------
					/*	We are looking for a parameter that we expect to occur only once. Its argument can contain multiple terms following the Google syntax for 'and' 'or' and 'not'. 
					/** -------------------------------------*/
				
					foreach ( $this->basic as $key )
					{					
						if ( strpos( $val, $key.$this->separator ) === 0 )
						{
							if ( $key != 'start' )
							{
								$newuri[]	= $val;
							}
							
							$q[$key]	= str_replace( array( $key.$this->separator ), '', $val );
						}
							
						$q	= $this->_check_tmpl_params( $key, $q );
					}
					
					/** -------------------------------------
					/**	Parse array parameters
					/** -------------------------------------
					/*	We are looking for a parameter that we expect to occur once or more. Each of these will have an argument which will in turn serve as a parameter / argument set.
					/** -------------------------------------*/
					
					foreach ( $this->arrays as $key )
					{
						if ( strpos( $val, $key.$this->separator ) === 0 )
						{
							$newuri[]	= $val;
							$argument	= str_replace( $key.$this->separator, '', $val );
							
							if ( strpos( $argument, $this->spaces ) !== FALSE )
							{
								$temp	= explode( $this->spaces, $argument );
							
								$q[$key][ array_shift( $temp ) ]	= implode( $this->spaces, $temp );
							}
						}
						
						if ( isset( $q[$key] ) === TRUE ) ksort( $q[$key] );
					}
				}
				
				ksort( $q );
				$this->sess['uri']	= $q;
					
				/** -------------------------------------
				/**	Save new uri
				/** -------------------------------------
				/*	We will very likely be paginating later. We will need a coherent search string for each pagination link. And at the very end of the string we place the 'start' parameter. Our pagination routine then appends the start number to that string.
				/** -------------------------------------*/
				
				if ( empty( $newuri ) === FALSE )
				{
					$newuri	= str_replace( array( $this->ampmarker, '"', '\'' ), array( '&&', '%22', '%22' ), implode( $this->parser, $newuri ) );
					
					$newuri	.= $this->parser.'start'.$this->separator;

					$this->sess['newuri']	= $newuri;
				}
					
				/** -------------------------------------
				/**	Parse search vars in template
				/** -------------------------------------*/
				
				$this->_parse_template_vars();
			
				/** ----------------------------------------
				/**	Manipulate $q
				/** ----------------------------------------*/
				
				if ($EXT->active_hook('super_search_parse_uri_end') === TRUE)
				{
					$q	= $EXT->universal_call_extension( 'super_search_parse_uri_end', $this, $q );
				}
				
				// print_r( $q );
				
				return $q;
			}
		}
					
		/** -------------------------------------
		/**	Parse search vars in template
		/** -------------------------------------*/
		
		$this->_parse_template_vars();
		
		return FALSE;
	}
	
	/*	End parse URI */

    // --------------------------------------------------------------------

	/**
	 * Parse param
	 *
	 * Tests for a URI segment with prefix of 'search&'. When found, explodes and parses that segment into search parameters.
	 *
	 * @access	private
	 * @return	boolean
	 */
	 
	function _parse_param()
	{
		global $TMPL;
		
		if ( $TMPL->fetch_param('query') !== FALSE AND $TMPL->fetch_param('query') != '' )
		{
			if ( strpos( $TMPL->fetch_param('query'), 'search&' ) === FALSE )
			{
				return $this->_parse_uri( 'search&' . $TMPL->fetch_param('query') );
			}
			else
			{
				return $this->_parse_uri( $TMPL->fetch_param('query') );
			}
		}
		
		return FALSE;
	}
	
	/*	End parse param */

    // --------------------------------------------------------------------

	/**
	 * Parse post
	 *
	 * We remember to construct and save a URI appropriate query for use in pagination later.
	 *
	 * @access	private
	 * @return	boolean
	 */
	 
	function _parse_post()
	{
		global $FNS, $IN, $REGX, $TMPL;
		
        /** -------------------------------------
		/**	Prep
		/** -------------------------------------*/
		
		if ( empty( $_POST ) === TRUE ) return FALSE;
		
		$_POST	= $REGX->xss_clean( $_POST );
		
		unset( $_POST['submit'] );
        
        /** -------------------------------------
		/**	Parse POST into search array
		/** -------------------------------------*/
		
		$str	= '';
		$parsed	= array();
		
		foreach ( $_POST as $key => $val )
		{
			if ( $val == '' OR in_array( $key, $parsed ) === TRUE ) continue;
			
			if ( is_array( $val ) === TRUE )
			{
				foreach ( $val as $k => $v )
				{
					if ( is_string( $v ) === TRUE AND strpos( $v, '/' ) !== FALSE )
					{
						$val[$k]	= str_replace( '/', SLASH, $v );
					}
				}
			}
			
			if ( is_string( $val ) === TRUE )
			{
				$val	= str_replace( array( '/', ';' ), array( SLASH, '' ), $val );
			}
        
			/** -------------------------------------
			/**	Exact field arrays get special treatment
			/** -------------------------------------*/
			
			if ( is_array( $val ) === TRUE AND strpos( $key, 'exact' ) === 0 )
			{
				$temp	= '';
				
				foreach ( $val as $k => $v )
				{
					if ( strpos( $v, '&&' ) !== FALSE )
					{
						$parsed[]	= $key.'_'.$k;
						$temp	.= $v;
					}
					else
					{
						$parsed[]	= $key.'_'.$k;
						$str	.= $key.'_'.$k.$this->separator.$v.$this->parser;
					}
				}
				
				if ( ! empty( $temp ) )
				{
					$str	.= $key . $this->separator . rtrim( $temp, '&' ) . $this->parser;
				}
			}
        
			/** -------------------------------------
			/**	Order field as an array gets special handling
			/** -------------------------------------*/
			
			elseif ( $key == 'order' AND is_array( $val ) === TRUE )
			{
				$str	.= $key.$this->spaces;
				
				foreach ( $val as $v )
				{
					if ( $v == '' ) continue;
					$str	.= $v.$this->spaces;
				}
				
				$str	.= $this->parser;
			}
        
			/** -------------------------------------
			/**	Handle post arrays
			/** -------------------------------------*/
			
			elseif ( is_array( $val ) === TRUE )
			{			
				$str	.= $key.$this->separator;
				$temp	= '';
				
				foreach ( $val as $k => $v )
				{
					if ( strpos( $v, '&&' ) !== FALSE )
					{
						$parsed[]	= $key.'_'.$k;
						$temp	.= $v;
					}
					else
					{
						$v		= stripslashes( $v );
						$parsed[]	= $key.'_'.$k;
			
						/** -------------------------------------
						/**	Spaces in an array POST value indicate that someone wants to do an exact phrase search, so we should put those in quotes for later parsing.
						/** -------------------------------------*/
						
						if ( strpos( $v, ' ' ) !== FALSE )
						{
							$v	= "'".$v."'";
						}
				
						$str	.= $v.$this->spaces;
					}				
				}
				
				if ( ! empty( $temp ) )
				{
					$str	.= rtrim( $temp, '&' ) . $this->parser;
				}
				
				$str	= rtrim( $str, $this->spaces );
				
				$str	.= $this->parser;
			}
			else
			{
				$str	.= $key.$this->separator.$val.$this->parser;
			}			
		}
		
		$str	= rtrim( $str, $this->parser );
		
		if ( $str == '' ) return FALSE;
        
        /** -------------------------------------
		/**	Are we redirecting POST searches to the query string method?
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('redirect_post') !== FALSE AND $TMPL->fetch_param('redirect_post') != '' )
		{
			$str	= str_replace( SLASH, $this->slash, $str );
		
			$return	= $TMPL->fetch_param('redirect_post');
		
			$return	= $this->_chars_decode( $this->_prep_return( $return ) ) . 'search'.$this->parser.$str.'/';
			
			if ( $return != '' )
			{
				$FNS->redirect( $return );
				exit();
			}
		}
        
        /** -------------------------------------
		/**	Send it to _parse_uri()
		/** -------------------------------------*/
			
		if ( ( $q = $this->_parse_uri( $IN->URI . 'search'.$this->parser.$str.'/' ) ) === FALSE )
		{
			return FALSE;
		}
		
		// print_r( $q );
		
		return $q;
	}
	
	/*	End parse post */

    // --------------------------------------------------------------------

	/**
	 * Parse switch
	 *
	 * Parses the friends_switch variable so that admins can create zebra stripe UI's.
	 *
	 * @access	private
	 * @return	str
	 */
	 
	function _parse_switch( $tagdata = '' )
	{	
		if ( $tagdata == '' ) return '';

		/**	----------------------------------------
		/**	Parse Switch
		/**	----------------------------------------*/
		
		if ( $this->parse_switch != '' OR preg_match( "/".LD."(switch\s*=(.+?))".RD."/is", $tagdata, $match ) > 0 )
		{
			$this->parse_switch	= ( $this->parse_switch != '' ) ? $this->parse_switch: $match;
			
			$val	= $this->cycle( explode( '|', str_replace( array( '"', "'" ), '', $this->parse_switch['2'] ) ) );
			
			$tagdata = str_replace( $this->parse_switch['0'], $val, $tagdata );
		}
		
		return $tagdata;		
	}
	
	/*	End parse date */
    
    // --------------------------------------------------------------------

	/**
	 *	Paste Removed Data Back into a String
	 *
	 *	@access		public
	 *	@param		string
	 *	@return		string
	 */
    
	function paste($subject)
    {
        foreach($this->_buffer as $key => $val)
        {
        	$subject = str_replace(' '.$this->marker.$key.$this->marker.' ', $val, $subject);
        }
        
        return $subject;
    }
    /* END paste() */

    // --------------------------------------------------------------------

	/**
	 * Prep author
	 *
	 * Important: If weblog entries have gotten into EE in some atypical way and the total_entries count is 0 for a valid author, the search will fail for that author.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _prep_author( $author = array() )
	{
		global $DB, $TMPL;
		
		if ( empty( $author['not'] ) === TRUE AND empty( $author['or'] ) === TRUE ) return FALSE;
		
		$indicator	= ( $TMPL->fetch_param('author_indicator') === FALSE OR $TMPL->fetch_param('author_indicator') != 'screen_name' ) ? 'username': 'screen_name';
		
		$sql	= '/* Super Search fetch members for author test */ SELECT member_id FROM exp_members WHERE total_entries > 0';
		
		if ( empty( $author['not'] ) === FALSE )
		{		
			foreach ( $author['not'] as $key => $val )
			{
				$author['not'][$key]	= $DB->escape_str( $val );
			}
			
			$sql	.= ' AND '.$indicator.' NOT IN (\''.implode( "','", $author['not'] ).'\')';
		}
		
		if ( empty( $author['or'] ) === FALSE )
		{		
			foreach ( $author['or'] as $key => $val )
			{
				$author['or'][$key]	= $DB->escape_str( $val );
			}
			
			$sql	.= ' AND '.$indicator.' IN (\''.implode( "','", $author['or'] ).'\')';
		}
		
		unset( $author );
		
		$query	= $DB->query( $sql );
		
		if ( $query->num_rows == 0 ) return FALSE;
		
		foreach ( $query->result as $row )
		{
			$author[]	= $row['member_id'];
		}
		
		return $author;
	}
	
	/*	End prep author */

    // --------------------------------------------------------------------

	/**
	 * Prep group
	 *
	 * Important: If weblog entries have gotten into EE in some atypical way and the total_entries count is 0 for a valid author, the search will fail for that author.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _prep_group( $group = array() )
	{
		global $DB, $PREFS;
		
		if ( empty( $group['not'] ) === TRUE AND empty( $group['or'] ) === TRUE ) return FALSE;
		
		$sql	= '/* Super Search fetch allowed groups */ SELECT m.member_id FROM exp_members m LEFT JOIN exp_member_groups mg ON mg.group_id = m.group_id WHERE mg.site_id = '.$DB->escape_str( $PREFS->ini('site_id') ).' AND m.total_entries > 0';
		
		if ( empty( $group['not'] ) === FALSE )
		{		
			foreach ( $group['not'] as $key => $val )
			{
				$group['not'][$key]	= $DB->escape_str( $val );
			}
			
			$sql	.= ' AND mg.group_title NOT IN (\''.implode( "','", $group['not'] ).'\')';
		}
		
		if ( empty( $group['or'] ) === FALSE )
		{		
			foreach ( $group['or'] as $key => $val )
			{
				$group['or'][$key]	= $DB->escape_str( $val );
			}
			
			$sql	.= ' AND mg.group_title IN (\''.implode( "','", $group['or'] ).'\')';
		}
		
		unset( $group );
		
		$query	= $DB->query( $sql );
		
		if ( $query->num_rows == 0 ) return FALSE;
		
		foreach ( $query->result as $row )
		{
			$group[]	= $row['member_id'];
		}
		
		return $group;
	}
	
	/*	End prep group */

    // --------------------------------------------------------------------

	/**
	 * Prep keywords
	 *
	 * REGEX is expensive stuff. We could rewrite this method to explode into individual characters, loop through the resulting array, flag our identifiers like negation, quotes and such, and assemble keywords again as we go. Might be much faster. But as it stands, the method, on most keyword strings, executes silly fast.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _prep_keywords( $keywords = '' )
	{
		global $DB;
		
		if ( is_string( $keywords ) === FALSE OR $keywords == '' ) return FALSE;
		
		$arr	= array( 'and' => array(), 'not' => array(), 'or' => array() );
        
        /** -------------------------------------
		/**	Are we using standard EE status syntax?
		/** -------------------------------------*/
		
		if ( strpos( $keywords, '|' ) !== FALSE OR strpos( $keywords, 'not ' ) === 0 )
		{
			/** -------------------------------------
			/**	Are we negating?
			/** -------------------------------------*/
			
			if ( strpos( $keywords, 'not ' ) === 0 )
			{
				$arr['not']	= explode( '|', str_replace( 'not ' , '', $keywords ) );
			}
			else
			{
				$arr['or']	= explode( '|', $keywords );
			}
        
			/** -------------------------------------
			/**	Save
			/** -------------------------------------*/
			
			$arr['not']	= $this->_remove_empties( $arr['not'] );
			$arr['or']	= $this->_remove_empties( $arr['or'] );
			
			sort( $arr['not'] );
			sort( $arr['or'] );
			ksort( $arr );
	
			return $arr;
		}
        
        /** -------------------------------------
		/**	Convert spaces
		/** -------------------------------------*/
		
		if ( strpos( $keywords, $this->spaces ) !== FALSE )
		{
			$keywords	= str_replace( $this->spaces, ' ', $keywords );
		}
        
        /** -------------------------------------
		/**	Parse out negated but quoted strings
		/** -------------------------------------*/
		
		If ( preg_match_all( "/".$this->negatemarker."[\"|'](.*?)[\"|']/s", $keywords, $match ) )
		{
			foreach ( $match[1] as $val )
			{
				$arr['not'][]	= $DB->escape_str( $val );
			}
			
			$keywords	= preg_replace( "/".$this->negatemarker."[\"|'](.*?)[\"|']/s", '', $keywords );
		}
        
        /** -------------------------------------
		/**	Parse out inclusive strings
        /** -------------------------------------
        /*	This is a special case, not too common
        /*	People can do inclusive category
        /*	searching which means they can require
        /*	that an entry belong to all of a given
        /*	set of categories.
		/** -------------------------------------*/
		
		$and	= 'or';
		
		if ( strpos( $keywords, $this->ampmarker ) !== FALSE )
		{
			$and		= 'and';
			$keywords	= explode( $this->ampmarker, $keywords );
		}
		else
		{
			$keywords	= array( $keywords );
		}
		
		/** -------------------------------------
		/**	Let's loop and parse our strings
		/** -------------------------------------*/
		
		foreach ( $keywords as $phrase )
		{
			/** -------------------------------------
			/**	Parse out quoted strings
			/** -------------------------------------*/
			
			If ( preg_match_all( "/[\"|'](.*?)[\"|']/s", $phrase, $match ) )
			{
				foreach ( $match[1] as $val )
				{
					/** -------------------------------------
					/**	Filter and / or depending on inclusion
					/** -------------------------------------
					/*	This is deceptively simple and may just	plain not work. If we're in the context	of inclusion, quoted phrases go to the 'and' array, otherwise the 'or' array.
					/** -------------------------------------*/
			
					$arr[$and][]	= $DB->escape_str( $val );
				}
				
				$phrase	= preg_replace( "/[\"|'](.*?)[\"|']/s", '', $phrase );
			}
			
			/** -------------------------------------
			/**	Parse out negated strings
			/** -------------------------------------*/
			
			If ( preg_match_all( "/".$this->negatemarker."([a-zA-Z0-9_]+)/s", $phrase, $match ) )
			{
				foreach ( $match[1] as $val )
				{
					$arr['not'][]	= $DB->escape_str( $val );
				}
				
				$phrase	= preg_replace( "/".$this->negatemarker."([a-zA-Z0-9_]+)/s", '', $phrase );
			}
			
			/** -------------------------------------
			/**	Load remaining OR keywords
			/** -------------------------------------
			/*	If we're in the context of inclusion, the first word in the phrase is added to the 'and' array while the others are given to the 'or' array. This means when I can ask for 'apples&&oranges bananas' I will end up retrieving entries that have both 'apples' and 'oranges' or 'bananas'.
			/** -------------------------------------*/
			
			$temp	= explode( ' ', trim( $DB->escape_str( $phrase ) ) );
			
			if ( empty( $temp ) === FALSE AND $and == 'and' )	// That was fun to type :-)
			{
				$arr['and'][]	= array_shift( $temp );
			}
			
			if ( empty( $temp ) === FALSE )
			{
				$arr['or']	= array_merge( $arr['or'], $temp );
			}
		}
        
        /** -------------------------------------
		/**	Save
		/** -------------------------------------*/
		
		$arr['and']	= $this->_remove_empties( $arr['and'] );
		$arr['not']	= $this->_remove_empties( $arr['not'] );
		$arr['or']	= $this->_remove_empties( $arr['or'] );
		
		sort( $arr['and'] );
		sort( $arr['not'] );
		sort( $arr['or'] );
		ksort( $arr );
		
		// print_r( $arr['or'] );

		return $arr;
	}
	
	/*	End prep keywords */

    // --------------------------------------------------------------------

	/**
	 * Prep order
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _prep_order( $order = '' )
	{
		global $EXT, $TMPL;
		
        /** -------------------------------------
		/**	Sticky test
		/** -------------------------------------*/
		
		$arr[]	= ( $TMPL->fetch_param('sticky') === FALSE OR $TMPL->fetch_param('sticky') != 'off' ) ? 't.sticky DESC': '';
		
        /** -------------------------------------
		/**	Graceful fail
		/** -------------------------------------*/
		
		if ( $order == '' )
		{
			$arr[]	= 't.entry_date DESC';
			$arr[]	= 't.entry_id DESC';
			return ' ORDER BY '.implode( ',', $arr );
		}
        
        /** -------------------------------------
		/**	Convert order string to array
		/** -------------------------------------*/
		
		if ( strpos( $order, $this->spaces ) === FALSE AND strpos( $order, ' ' ) === FALSE )
		{
			$order	= $order . "|asc";
		}
		else
		{
			$order	= str_replace( array( $this->spaces.$this->spaces.$this->spaces, $this->spaces.$this->spaces, $this->spaces ), ' ', strtolower( $order ) );
			
			if ( strpos( $order, ' desc' ) !== FALSE )
			{
				$order	= str_replace( ' desc', '|desc', $order );
			}
			
			if ( strpos( $order, ' asc' ) !== FALSE )
			{
				$order	= str_replace( ' asc', '|asc', $order );
			}
		}
		
		$order	= explode( ' ', $order );
        
        /** -------------------------------------
		/**	Process orders
		/** -------------------------------------*/
		
		if ( is_array( $order ) === TRUE )
		{
			$customfields	= $this->_fields();
			$fields			= $this->_table_columns( 'exp_weblog_titles' );
		
			foreach ( $order as $str )
			{
				$ord	= explode( '|', $str );
			
				if ( isset( $fields[ $ord[0] ] ) === TRUE )
				{
					$arr[]	= ( isset( $ord[1] ) === TRUE ) ? 't.'.$fields[ $ord[0] ].' '.strtoupper( $ord[1] ): 't.'.$fields[ $ord[0] ].' ASC';
				}
				
				if ( isset( $customfields[ $ord[0] ] ) === TRUE AND is_numeric( $customfields[ $ord[0] ] ) === TRUE )
				{					
					$arr[]	= ( isset( $ord[1] ) === TRUE ) ? 'wd.field_id_'.$customfields[ $ord[0] ].' '.strtoupper( $ord[1] ): 'wd.field_id_'.$customfields[ $ord[0] ].' ASC';
				}
			}
		}
			
		/** ----------------------------------------
		/**	Manipulate order
		/** ----------------------------------------*/
		
		if ( $EXT->active_hook('super_search_prep_order') === TRUE )
		{
			$arr	= $EXT->universal_call_extension( 'super_search_prep_order', $this, $arr );
		}
        
        /** -------------------------------------
		/**	Remove empties
		/** -------------------------------------*/
		
		$arr	= $this->_remove_empties( $arr );
		
		return ' ORDER BY '.implode( ', ', $arr );
	}
	
	/*	End prep order */

    // --------------------------------------------------------------------

	/**
	 * Prep pagination
	 *
	 * This is a temporary routine. We'll replace with pagination from FT E when it's ready.
	 *
	 * @access	private
	 * @return	string
	 */

	function _prep_pagination( $sql, $total_results, $url_suffix = '' )
	{
		global $FNS, $IN, $LANG, $TMPL;
		
		$this->cur_page = 0;

		/** ----------------------------------------
		/**	Alter limit if necessary
		/** ----------------------------------------
		*	'num' is an alias of 'limit'. 'limit' dominates.
		/** ----------------------------------------*/
		
		/** -------------------------------------
		/**	We prefer to find the array value as a template param
		/** -------------------------------------*/
	
		if ( ! empty( $TMPL->tagparams[ 'limit' ] ) )
		{
			$this->limit	= $TMPL->tagparams[ 'limit' ];
		}
		
		/** -------------------------------------
		/**	We'll accept the array key as a template param next
		/** -------------------------------------*/
		
		elseif ( ! empty( $TMPL->tagparams[ 'num' ] ) )
		{
			$this->limit	= $TMPL->tagparams[ 'num' ];
		}
		
		/** -------------------------------------
		/**	We'll next accept our array val as a URI param
		/** -------------------------------------*/

		elseif ( ! empty( $this->sess['uri'][ 'limit' ] ) )
		{
			$this->limit	= $this->sess['uri'][ 'limit' ];
		}
		
		/** -------------------------------------
		/**	We'll lastly accept our array key as a URI param
		/** -------------------------------------*/

		elseif ( ! empty( $this->sess['uri'][ 'num' ] ) )
		{
			$this->limit	= $this->sess['uri'][ 'num' ];
		}
		
		// $this->limit	= ( ( $limit = $this->sess( 'uri', 'limit' ) ) === FALSE ) ? $this->limit: $limit;
		
		// $this->limit	= ( ( $num = $this->sess( 'uri', 'num' ) ) === FALSE ) ? $this->limit: $num;

        /** -------------------------------------
        /**	Begin pagination check
		/** -------------------------------------*/
		
		if ( strpos( $TMPL->tagdata, 'paginate' ) !== FALSE )
		{
			if (preg_match("/".LD."paginate".RD."(.+?)".LD.SLASH."paginate".RD."/s", $TMPL->tagdata, $match))
			{
				$this->paginate			= TRUE;
				$this->paginate_data	= $match[1];
				
				$TMPL->tagdata = str_replace( $match['0'], '', $TMPL->tagdata );
				
				/** ----------------------------------------
				/**  Calculate total number of pages
				/** ----------------------------------------*/
				
				$this->cur_page	= ( ( $cur = $this->sess( 'uri', 'start' ) ) === FALSE ) ? 0: $cur;
					
				$this->current_page =  ($this->cur_page / $this->limit) + 1;
					
				$this->total_pages = intval($total_results / $this->limit);
				
				if ($total_results % $this->limit) 
				{
					$this->total_pages++;
				}		
				
				$this->page_count = $LANG->line('page').' '.$this->current_page.' '.$LANG->line('of').' '.$this->total_pages;
				
				/** ----------------------------------------
				/**  Do we need pagination?
				/** ----------------------------------------*/
						
				$this->pager	= '';
				
				if ( $total_results > $this->limit AND $TMPL->fetch_param('paginate') !== FALSE AND $TMPL->fetch_param('paginate') != '' )
				{	
					if ( ! class_exists('Paginate'))
					{
						require PATH_CORE.'core.paginate'.EXT;
					}
		
					$PGR = new Paginate();
					
					$page_number	= ( ( $start = $this->sess( 'uri', 'start' ) ) === FALSE ) ? $start: '';
					
					if ( $this->cur_page == '' AND $page_number != '' )
					{
						$this->cur_page	= $page_number;
					}
				
					/** ----------------------------------------
					/**	Set initial new uri
					/** ----------------------------------------*/
					
					if ( ( $newuri = $this->sess( 'newuri' ) ) === FALSE )
					{
						$newuri	= 'search'.$this->parser.'start'.$this->separator;
					}
				
					/** ----------------------------------------
					/**	Handle stupid slashes
					/** ----------------------------------------*/
					
					if ( strpos( $newuri, '/' ) !== FALSE )
					{
						$newuri	= str_replace( '/', $this->slash, $newuri );
					}

					/**	----------------------------------------
					/**	Prep basepath
					/**	----------------------------------------
					/*	We need to negotiate different possible ways of assembling the pagination basepath.
					/**	----------------------------------------*/
					
					if ( $TMPL->fetch_param('paginate_base') !== FALSE AND $TMPL->fetch_param('paginate_base') != '' )
					{
						$newuri	= rtrim( $TMPL->fetch_param('paginate_base'), '/' ) . '/' . ltrim( $newuri, '/' );
					}
					elseif ( ! empty( $this->sess['olduri'] ) AND strpos( $this->sess['olduri'], $this->urimarker ) !== FALSE )
					{
						$newuri	= str_replace( $this->urimarker, $this->sess['olduri'], $newuri );
					}					
					
					/**	----------------------------------------
					/**	If someone is using the template param called 'search' they may not have a full URI saved in sess['olduri'] so we try to fake it. The better approach is for them to use the paginate_base param above.
					/**	----------------------------------------*/
					
					if ( isset( $IN->SEGS[1] ) === TRUE AND strpos( $newuri, $IN->SEGS[1] . '/' ) !== 0 AND ( $TMPL->fetch_param('paginate_base') === FALSE OR $TMPL->fetch_param('paginate_base') == '' ) )
					{						
						$temp[]	= $IN->SEGS[1];
						
						if ( isset( $IN->SEGS[2] ) === TRUE )
						{
							$temp[]	= $IN->SEGS[2];
						}
						
						$temp[]	= $newuri;
						
						$newuri	= implode( '/', $temp );
					}
								
					$PGR->path			= $FNS->create_url($newuri, 0, 0);
					$PGR->total_count 	= $total_results;
					$PGR->prefix		= ( isset( $total_results ) === TRUE ) ? '': '';
					$PGR->per_page		= $this->limit;
					$PGR->cur_page		= $this->cur_page;
					
					$this->pager		= $PGR->show_links();
				}
			}
		}
		
		$offset = ( ! $TMPL->fetch_param('offset') OR ! is_numeric($TMPL->fetch_param('offset'))) ? '0' : $TMPL->fetch_param('offset');
		
		$this->cur_page += $offset;
		
		return $sql .= ' LIMIT '.$this->cur_page.', '.$this->limit;
	}
	
	/**	End prep pagination	*/

    // --------------------------------------------------------------------

	/**
	 * Prep relevance
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _prep_relevance()
	{
		global $TMPL;
		
        /** -------------------------------------
		/**	Check params
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('relevance') === FALSE OR $TMPL->fetch_param('relevance') == '' )
		{
			return FALSE;
		}
        
        /** -------------------------------------
		/**	Convert spaces
		/** -------------------------------------*/
		
		$relevance	= str_replace( ' ', $this->spaces, $TMPL->fetch_param('relevance') );
        
        /** -------------------------------------
		/**	Count words within words?
		/** -------------------------------------*/
		
		if ( strpos( $relevance, 'count_words_within_words' ) !== FALSE )
		{
			$this->relevance_count_words_within_words	= TRUE;
			
			$relevance	= trim( str_replace( 'count_words_within_words', '', $relevance ), $this->spaces );
		}
        
        /** -------------------------------------
		/**	Simple argument?
		/** -------------------------------------*/
		
		if ( strpos( $relevance, $this->spaces ) === FALSE )
		{
			$temp	= explode( $this->separator, $relevance );
			
			if ( count( $temp ) > 1 )
			{
				$arr[$temp[0]]		= $temp[1];
			}
			else
			{
				$arr[$relevance]	= 1;
			}
			
			return $arr;
		}
        
        /** -------------------------------------
		/**	Compound argument?
		/** -------------------------------------*/
		
		$arr	= array();
		
		foreach ( explode( $this->spaces, strtolower( $relevance ) ) as $val )
		{
			$temp	= explode( $this->separator, $val );
			
			if ( count( $temp ) > 1 )
			{
				$arr[ $temp[0] ]	= $temp[1];
			}
			else
			{
				$arr[ $temp[0] ]	= 1;
			}
		}
			
		if ( empty( $arr ) === TRUE ) return FALSE;
		
		return $arr;
	}
	
	/*	End prep relevance */

    // --------------------------------------------------------------------

	/**
	 * Prep return
	 *
	 * @access	private
	 * @return	string
	 */
    
    function _prep_return( $return = '' )
    {
    	global $FNS, $IN;
        
        if ( $IN->GBL('return') !== FALSE AND $IN->GBL('return') != '' )
        {
        	$return	= $IN->GBL('return');
        }
        elseif ( $IN->GBL('RET') !== FALSE AND $IN->GBL('RET') != '' )
        {
        	$return	= $IN->GBL('RET');
        }
        else
        {
        	$return = $FNS->fetch_current_uri();
        }
		
		if ( preg_match( "/".LD."\s*path=(.*?)".RD."/", $return, $match ) )
		{
			$return	= $FNS->create_url( $match['1'] );
		}
		elseif ( stristr( $return, "http://" ) === FALSE && stristr( $return, "https://" ) === FALSE )
		{
			$return	= $FNS->create_url( $return );
		}
		
		return $return;
    }
    
    /*	End prep return */

    // --------------------------------------------------------------------

	/**
	 * Prep sql
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _prep_sql( $type = 'or', $field = '', $keywords = array(), $exact = 'notexact', $field_id = '' )
	{
		global $DB;
        
        /** -------------------------------------
		/**	Basic validity test
		/** -------------------------------------*/
		
		if ( $field == '' OR is_array( $keywords ) === FALSE OR count( $keywords ) == 0 ) return FALSE;
        
        /** -------------------------------------
		/**	EE stores custom field data in columns of a single DB table. These columns can contain data for a blog entry even when the custom field no longer belongs to that weblog. Janky architecture. We have to correct against that by forcing a weblog test attached to any custom field test we run. This might even speed things up.
		/** -------------------------------------*/
		
		$exceptions	= array( 't.title', 't.status' );
		
		if ( isset( $this->sess['field_to_weblog_map_sql'][$field_id] ) === FALSE AND in_array( $field, $exceptions ) === FALSE ) return FALSE;
        
        /** -------------------------------------
		/**	Go!
		/** -------------------------------------*/
		
		$arr	= array();
        
        /** -------------------------------------
		/**	Prep conjunction
		/** -------------------------------------*/
		
		if ( $type == 'and' AND empty( $keywords['or'] ) === FALSE )
		{
			$temp	= array();
			
			foreach ( $keywords['or'] as $val )
			{
				if ( $val == '' ) continue;
				
				if ( strpos( $val, $this->spaces ) !== FALSE )
				{
					$val	= str_replace( $this->spaces, ' ', $val );
				}
			
				if ( $exact != 'exact' )
				{
					$temp[]	= $field." LIKE '%".$DB->escape_str( $val )."%'";
					// $temp[]	= $field." REGEXP '[[:<:]]".$DB->escape_str( $val )."'";
				}
				else
				{
					$temp[]	= $field." = '".$DB->escape_str( $val )."'";
				}
			}
			
			if ( count( $temp ) > 0 )
			{
				$arr[]	= '('.implode( ' AND ', $temp ).')';
			}
		}
        
        /** -------------------------------------
		/**	Prep exclusion
		/** -------------------------------------*/
		
		if ( $type == 'not' AND empty( $keywords['not'] ) === FALSE )
		{
			$temp	= array();
			
			foreach ( $keywords['not'] as $val )
			{
				if ( $val == '' ) continue;
				
				if ( strpos( $val, $this->spaces ) !== FALSE )
				{
					$val	= str_replace( $this->spaces, ' ', $val );
				}
				
				if ( $exact != 'exact' )
				{
					$temp[]	= $field." NOT LIKE '%".$DB->escape_str( $val )."%'";
					// $temp[]	= $field." NOT REGEXP '[[:<:]]".$DB->escape_str( $val )."'";
				}
				else
				{
					$temp[]	= $field." != '".$DB->escape_str( $val )."'";
				}
			}
			
			if ( count( $temp ) > 0 )
			{
				$arr[]	= '('.implode( ' AND ', $temp ).')';
			}
		}
        
        /** -------------------------------------
		/**	Prep inclusion
		/** -------------------------------------*/
		
		if ( $type == 'or' AND empty( $keywords['or'] ) === FALSE )
		{
			$temp	= array();
			
			foreach ( $keywords['or'] as $val )
			{
				if ( $val == '' ) continue;
				
				if ( strpos( $val, $this->spaces ) !== FALSE )
				{
					$val	= str_replace( $this->spaces, ' ', $val );
				}
				
				if ( $exact != 'exact' )
				{
					$temp[]	= $field." LIKE '%".$DB->escape_str( $val )."%'";
					// $temp[]	= $field." REGEXP '[[:<:]]".$DB->escape_str( $val )."'";
				}
				else
				{
					$temp[]	= $field." = '".$DB->escape_str( $val )."'";
				}
			}
			
			if ( count( $temp ) > 0 )
			{
				$arr[]	= '('.implode( ' OR ', $temp ).')';
			}			
		}
        
        /** -------------------------------------
		/**	Glue
		/** -------------------------------------*/
		
		if ( empty( $arr ) === TRUE ) return FALSE;
		
		if ( in_array( $field, $exceptions ) === TRUE OR empty( $this->sess['field_to_weblog_map_sql'][$field_id] ) )
		{
			return '(' . implode( ' AND ', $arr ) . ')';
		}
		else
		{
			return '(' . implode( ' AND ', $arr ) . $this->sess['field_to_weblog_map_sql'][$field_id] . ')';
		}			
	}
	
	/*	End prep sql */

    // --------------------------------------------------------------------

	/**
	 * Prep weblog
	 *
	 * Returns an array of weblog ids. This method has a wide ranging effect on behavior. It looks for hard coded weblog ids in a template param. As well, it looks for weblog names provided in either a template param called 'channel' or in the URI preceded by the marker 'channel'. In either of these last two cases, regular search syntax can be used to include or exclude weblogs for search.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _prep_weblog( $weblog_string = '' )
	{
		global $DB, $TMPL;		
		
        /** -------------------------------------
		/**	Have we already done all this?
		/** -------------------------------------*/
		
		// if ( ( $weblog_ids = $this->sess( 'search', 'weblog_ids' ) ) !== FALSE ) return $weblog_ids;
		
        /** -------------------------------------
		/**	Do we have hardcoded weblog ids?
		/** -------------------------------------*/
		
		$weblog_ids	= array();
		
		if ( $TMPL->fetch_param('weblog_id') !== FALSE AND $TMPL->fetch_param('weblog_id') != '' )
		{
			$weblog_ids	= explode( '|', $TMPL->fetch_param('weblog_id') );
		}
		
        /** -------------------------------------
		/**	Weblog names in a param or in the URI.
        /** -------------------------------------
        /*	Remember, these can come through the 'channel' template param or through the 'channel' marker in the URI. Search syntax applies such that negated weblogs have their entries excluded from search.
		/** -------------------------------------*/
		
		if ( ! empty( $weblog_string ) )
		{
			$weblog_names = $this->_prep_keywords( $weblog_string );
		}
		
        /** -------------------------------------
		/**	Loop and filter
		/** -------------------------------------*/
		
		$ids	= array();
		$blogs	= array();
		
		foreach ( $this->data->get_weblogs_by_site_id_and_weblog_id( $TMPL->site_ids, $weblog_ids ) as $row )
		{		
			/** -------------------------------------
			/**	We don't want excluded blogs in our arrays
			/** -------------------------------------*/
		
			if ( ! empty( $weblog_names['not'] ) AND in_array( $row['blog_name'], $weblog_names['not'] ) === TRUE ) continue;
			
			/** -------------------------------------
			/**	And if we only want certain blogs, then filter as well.
			/** -------------------------------------*/			
			
			if ( ! empty( $weblog_names['or'] ) AND in_array( $row['blog_name'], $weblog_names['or'] ) === FALSE ) continue;
			
			/** -------------------------------------
			/**	Populate arrays.
			/** -------------------------------------*/	
			
			$ids[]						= $row['weblog_id'];
			$blogs[$row['weblog_id']]	= $row;
		}		
		
        /** -------------------------------------
		/**	Empty after filtering? Fail out
		/** -------------------------------------*/
		
		if ( count( $ids ) == 0 ) return FALSE;
		
        /** -------------------------------------
		/**	Add results to cache and return
		/** -------------------------------------*/
		
		sort( $ids );
		$this->sess['search']['weblog_ids']	= $ids;
		$this->sess['search']['weblogs']	= $blogs;
		return $ids;		
	}
	
	/*	End prep weblog */

    // --------------------------------------------------------------------

	/**
	 * Relevance count
	 *
	 * @access	private
	 * @return	integer
	 */
	 
	function _relevance_count( $relevance = array(), $row = array() )
	{
		$boundary	= ( $this->relevance_count_words_within_words == TRUE ) ? '': '\b';	// This additional flag goes into our regular expression below and controls whether we count our keywords if they appear within other words.
			
		$n		= 0;
		$hash	= md5( serialize( $relevance ) );
		
		if ( isset( $row['entry_id'] ) === TRUE AND isset( $this->sess['search']['relevance_count'][$hash][ $row['entry_id'] ] ) === TRUE )
		{
			return $this->sess['search']['relevance_count'][$hash][ $row['entry_id'] ];
		}
		
		foreach ( $relevance as $key => $val )
		{
			if ( empty( $row[$key] ) === TRUE ) continue;
			
			foreach ( $this->sess['search']['q']['keywords']['or'] as $w )
			{
				if ( function_exists( 'stripos' ) === FALSE OR stripos( $row[$key], $w ) !== FALSE )
				{
					/** -------------------------------------
					/**	This is still a boneheaded relevance algorithm. But at least with preg_match the counts can be a bit more accurate.
					/** -------------------------------------*/
					
					$match	= '/' . $boundary . $w . $boundary . '/is';
	
					if ( preg_match_all( $match, $row[$key], $matches ) )
					{					
						if ( isset( $matches[0] ) === TRUE )
						{
							$n	= $n + ( count( $matches[0] ) * $val );
						}
					}
				}
			
				// $n	= $n + ( substr_count( strtolower( strip_tags( $row[$key] ) ), $w.' ' ) * $val );	// Keyword of 'long' would match against 'long', 'oblong', 'longjohn', etc. Maybe not the best, but I don't want to use preg_match_all if I can help it.
			}					
		}
		
		$this->sess['search']['relevance_count'][$hash][ $row['entry_id'] ]	= $n;
		
		return $n;
	}
	
	/*	End relevance count */

    // --------------------------------------------------------------------

	/**
	 * Remove empties
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _remove_empties( $arr = array() )
	{
		$a	= array();
	
		foreach ( $arr as $key => $val )
		{
			if ( $val == '' ) continue;
			
			$a[$key]	= $val;
		}
		
		return $a;
	}
	
	/*	End remove empties */

    // --------------------------------------------------------------------

	/**
	 * Results
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function results()
	{
		global $IN, $TMPL;
		
		$t	= microtime(TRUE);
		
		$TMPL->log_item( 'Super Search: Starting results()' );
        
        /** -------------------------------------
		/**	Are they allowed here?
		/** -------------------------------------*/
		
		if ( $this->_security() === FALSE )
		{
			$this->_parse_no_results_condition();
			$this->save_search_form( $TMPL->template, 'just_replace' );
			return $this->no_results( 'super_search' );
		}
        
        /** -------------------------------------
		/**	Hardcoded query
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('search') !== FALSE AND $TMPL->fetch_param('search') != '' )
		{
			$str	= ( strpos( $TMPL->fetch_param('search'), 'search&' ) === FALSE ) ? 'search&' . $TMPL->fetch_param('search'): $TMPL->fetch_param('search');
        
			/** -------------------------------------
			/**	Handle special case of start param for pagination. When users say they want pagination but they are using the 'search' param, we need to reach into the URI and try to find the 'start' param and work from there. Kind of duct tape like.
			/** -------------------------------------*/
			
			if ( $TMPL->fetch_param( 'paginate' ) !== FALSE AND $TMPL->fetch_param( 'paginate' ) != '' )
			{
				if ( preg_match( '/' . $this->parser . 'start' . $this->separator . '(\d+)' . '/s', $IN->URI, $match ) )
				{
					if ( preg_match( '/' . $this->parser . 'start' . $this->separator . '(\d+)' . '/s', $str, $secondmatch ) )
					{
						$str	= str_replace( $secondmatch[0], $match[0], $str );
					}
					else
					{
						$str	= str_replace( 'search' . $this->parser, 'search' . $this->parser . $match[0], $str );
					}
				}
			}
			
			if ( ( $q = $this->_parse_uri( $str.'/' ) ) === FALSE )
			{
				$this->_parse_no_results_condition();
				$this->save_search_form( $TMPL->template, 'just_replace' );
				return $this->no_results( 'super_search' );
			}
		}
        
        /** -------------------------------------
		/**	Otherwise we accept search queries
		/**	from either	URI or POST. See if either
		/**	is present, defaulting to POST.
		/** -------------------------------------*/
		
		else
		{
			if ( ( $q = $this->_parse_post() ) === FALSE )
			{
				if ( ( $q = $this->_parse_uri() ) === FALSE )
				{				
					if ( ( $q = $this->_parse_from_tmpl_params() ) === FALSE )
					{
						$this->_parse_no_results_condition();
						$this->save_search_form( $TMPL->template, 'just_replace' );
						return $this->no_results( 'super_search' );
					}
				}
			}
		}
		
		/** -------------------------------------
		/**	Do weblog title and weblog data search
		/** -------------------------------------*/
	
		if ( ( $ids = $this->do_search_wt_wd( $q ) ) === FALSE )
		{
			$this->_parse_no_results_condition();
			$this->save_search_form( $TMPL->template, 'just_replace' );
			return $this->no_results( 'super_search' );
		}
		
		/** -------------------------------------
		/**	Performance parsing?
		/** -------------------------------------*/
		
		$params	= array();
		
		if ( $TMPL->fetch_param('performance') === FALSE OR $TMPL->fetch_param('performance') != 'off' )
		{
			if ( ( $tagdata = $this->_fast_entries( $ids, $params ) ) === FALSE )
			{
				$this->_parse_no_results_condition();
				$this->save_search_form( $TMPL->template, 'just_replace' );
				return $this->no_results( 'super_search' );
			}
		}
		else
		{
			if ( ( $tagdata = $this->_entries( $ids, $params ) ) === FALSE )
			{			
				$this->_parse_no_results_condition();
				$this->save_search_form( $TMPL->template, 'just_replace' );
				return $this->no_results( 'super_search' );
			}
		}
		
		$TMPL->log_item( 'Super Search: Ending results() '.(microtime(TRUE) - $t) );

		$this->save_search_form( $TMPL->template, 'just_replace' );
        return $tagdata;
	}
	
	/*	End results */

    // --------------------------------------------------------------------

	/**
	 * Return message
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function _return_message( $post = FALSE, $tagdata = '', $cond = array() )
	{
		global $FNS, $LANG, $OUT, $TMPL;
		
		if ( empty( $cond['message'] ) ) return FALSE;
		
		if ( $post === TRUE )
		{
			return $OUT->show_user_error( 'general', $cond['message'] );
		}
		
		$tagdata	= $FNS->prep_conditionals( $tagdata, $cond );
		$tagdata	= str_replace( LD.'message'.RD, $cond['message'], $tagdata );
		
		return $tagdata;
	}
	
	/*	End return message */

    // --------------------------------------------------------------------

	/**
	 * Save search
	 *
	 * This method allows people to save a search that has been cached in order to prevent it from being uncached.
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function save_search()
	{
		global $DB, $IN, $LANG, $OUT, $FNS, $SESS, $TMPL;
		
		$post	= ( empty( $_POST ) ) ? FALSE: TRUE;
		
		$search_name	= $IN->GBL('super_search_name');
        	
		$return	= ( ! empty( $_POST['return'] ) ) ? $IN->GBL('return'): $IN->GBL('RET');
		
        $return	= str_replace( array( '&amp;', ';' ), array( '&', '' ), $return );
		
        /** ----------------------------------------
        /**	Get search id
        /** ----------------------------------------*/
        
        if ( is_object( $TMPL ) AND $TMPL->fetch_param('search_id') !== FALSE AND $TMPL->fetch_param('search_id') != '' )
        {
        	$search_id	= $TMPL->fetch_param('search_id');
        }
        elseif ( $IN->GBL('super_search_id') !== FALSE AND is_numeric( $IN->GBL('super_search_id') ) === TRUE )
        {
        	$search_id	= $IN->GBL('super_search_id');
        }
        elseif ( preg_match( '/\/(\d+)/s', $IN->URI, $match ) )
        {
        	$search_id	= $match['1'];
        }
        else
        {
        	return $this->_return_message( $post, '', array( 'message' => $LANG->line('search_not_found') ) );
        }
		
        /** ----------------------------------------
        /**	Delete mode?
        /** ----------------------------------------*/
        
        if ( ( is_object( $TMPL ) AND $TMPL->fetch_param('delete') !== FALSE AND $TMPL->fetch_param('delete') == 'yes' ) OR strpos( $IN->URI, '/delete' ) !== FALSE OR $IN->GBL('delete_mode') == 'yes' )
        {
        	$sql	= "DELETE FROM exp_super_search_history
        				WHERE history_id = ".$DB->escape_str( $search_id )
        				." AND
        				(
							( member_id != 0
							AND member_id = ".$DB->escape_str( $SESS->userdata('member_id') ).")
							OR
							( cookie_id = ".$DB->escape_str( $this->_get_users_cookie_id() )." )
						)
						LIMIT 1";
        
        	$DB->query( $sql );
        	
        	if ( $post === FALSE )
        	{
				return $this->_return_message( $post, $TMPL->tagdata, array( 'failure' => FALSE, 'success' => TRUE, 'message' => $LANG->line('search_successfully_deleted') ) );
        	}
        	else
        	{
				$FNS->redirect( $return );
        	}
        }
		
        /** ----------------------------------------
        /**	Search name?
        /** ----------------------------------------*/
        
        if ( empty( $search_name ) )
        {
        	return $this->_return_message( $post, '', array( 'message' => $LANG->line('missing_name') ) );
        }
        elseif ( preg_match("/[^a-zA-Z0-9\_\-\.\s]/", $search_name ) )
        {
        	return $this->_return_message( $post, '', array( 'message' => $LANG->line('invalid_name') ) );
        }
		
        /** ----------------------------------------
        /**	Get all of this user's history for testing
        /** ----------------------------------------*/
        
        $sql	= "/* Super Search get user's search history for validation */ SELECT *
					FROM exp_super_search_history
					WHERE 
					(
						member_id != 0
						AND member_id = ".$DB->escape_str( $SESS->userdata('member_id') ).")
						OR
						( cookie_id = ".$DB->escape_str( $this->_get_users_cookie_id() )." )";
		
		$query	= $DB->query( $sql );
		
        /** ----------------------------------------
        /**	No history at all?
        /** ----------------------------------------*/
		
        if ( $query->num_rows == 0 )
        {
        	return $this->_return_message( $post, '', array( 'message' => $LANG->line('search_not_found') ) );
        }
		
        /** ----------------------------------------
        /**	Prepare helper arrays
        /** ----------------------------------------*/
        
        foreach ( $query->result as $row )
        {
        	$cache_ids[ $row['cache_id'] ]		= $row;
        	$history_ids[ $row['history_id'] ]	= $row;
        	$names[ $row['search_name'] ]		= $row;
        }
		
        /** ----------------------------------------
        /**	Is our search found?
        /** ----------------------------------------*/
		
        if ( isset( $history_ids[ $search_id ] ) === FALSE )
        {
        	return $this->_return_message( $post, '', array( 'message' => $LANG->line('search_not_found') ) );
        }
		
        /** ----------------------------------------
        /**	Are we changing a name? Is it unique?
        /** ----------------------------------------*/
        
        if (
        	$history_ids[ $row['history_id'] ]['search_name'] != $search_name
        	AND isset( $names[ $search_name ] ) === TRUE
        	AND $names[ $search_name ]['history_id'] != $search_id
        	)
        {
        	return $this->_return_message( $post, '', array( 'message' => $LANG->line('duplicate_name') ) );
        }
		
        /** ----------------------------------------
        /**	Update DB
        /** ----------------------------------------*/
        
		$sql	= $DB->update_string(
			'exp_super_search_history',
			array(
				'search_name'	=> $search_name,
				'saved'			=> 'y'
				),
			array(
				'history_id'	=> $search_id
				)
			);
			
		// $sql	.= " ON DUPLICATE KEY UPDATE search_name = VALUES(search_name), saved = VALUES(saved)";
		
		if ( $history_ids[ $row['history_id'] ]['search_name'] != $search_name )
		{
			$DB->query( $sql );
		}			
		
        /** ----------------------------------------
        /**	Return
        /** ----------------------------------------*/
        
        if ( $post === FALSE )
        {
			return $this->_return_message( $post, $TMPL->tagdata, array( 'failure' => FALSE, 'success' => TRUE, 'message' => $LANG->line('search_successfully_saved') ) );
        }
        else
        {
			$FNS->redirect( $return );
        }        	
	}
	
	/* End save search */

    // --------------------------------------------------------------------

	/**
	 * Save search form
	 *
	 * This method creates a form that users can submit to save searches to their histories.
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function save_search_form( $tagdata = '', $just_replace = '' )
	{
		global $DB, $FNS, $PREFS, $SESS, $TMPL;
		
		/** -------------------------------------
		/**	Just return save search form?
		/** -------------------------------------*/
		
		if ( $just_replace != '' AND preg_match( "/".LD.'super_search_save_search_form'.RD."(.*?)".LD.SLASH.'super_search_save_search_form'.RD."/s", $TMPL->template, $match ) )
		{		
			/** -------------------------------------
			/**	If there were no search results, don't show the save_search_form.
			/** -------------------------------------*/
		
			$replace	= ( $this->sess('results') === FALSE OR $this->sess('results') == 0 ) ? '': $this->save_search_form( $match[1] );
		
			$TMPL->template	= str_replace( $match[0], $replace, $TMPL->template );
			
			return TRUE;
		}
    	
		/**	----------------------------------------
		/**	Do we have a search by id?
		/**	----------------------------------------*/
		
		if ( $TMPL->fetch_param('search_id') !== FALSE AND is_numeric( $TMPL->fetch_param('search_id') ) === TRUE )
		{
			$search_id	= $TMPL->fetch_param('search_id');
		}
    	
		/**	----------------------------------------
		/**	We may already know the history id and cache ids
		/**	----------------------------------------*/
		
		if ( ! empty( $this->sess['search_history'] ) )
		{
			$results	= $this->sess['search_history'];
		}
		else
		{
			/**	----------------------------------------
			/**	Check the DB for a search history
			/**	----------------------------------------*/
			
			$sql	= "/* Super Search find user's last search */ SELECT history_id, cache_id, results AS super_search_results, search_name AS super_search_name, search_date AS super_search_date
						FROM exp_super_search_history
						WHERE site_id = '".$PREFS->ini('site_id')."'";
			
			if ( ! empty( $search_id ) )
			{
				$sql	.= " AND history_id = ".$DB->escape_str( $search_id );
			}
			else
			{
				$sql	.= " AND saved = 'n'";	// We're looking for the single search history entry that captures the very last search they conducted.
			
				if ( $SESS->userdata('member_id') != 0 )
				{
					$sql	.= " AND ( member_id = ".$DB->escape_str( $SESS->userdata('member_id') );
					$sql	.= " OR cookie_id = ".$DB->escape_str( $this->_get_users_cookie_id() )." )";
				}
				else
				{
					$sql	.= " AND cookie_id = ".$DB->escape_str( $this->_get_users_cookie_id() );
				}
			}
			
			$sql	.= " LIMIT 1";
			
			$query	= $DB->query( $sql );
			
			// print_r( $query );
			
			if ( $query->num_rows == 0 )
			{
				return $this->no_results( 'super_search' );
			}
			
			$results	= $query->row;
		}    	
    	
		/**	----------------------------------------
		/**	Prep tagdata
		/**	----------------------------------------*/
		
		$tagdata	= ( $tagdata != '' ) ? $tagdata: $TMPL->tagdata;
		
		foreach ( $results as $key => $val )
		{
			$key	= $this->_homogenize_var_name( $key );
		
			if ( strpos( $tagdata, LD.$key ) === FALSE ) continue;
			
			if ( $key == 'super_search_date' AND preg_match_all( "/".$key."\s+format=[\"'](.*?)[\"']/s", $tagdata, $matches ) )
			{			
				foreach ( $matches[0] as $k => $v )
				{
					$tagdata	= str_replace( LD.$v.RD, $this->_parse_date( $matches[1][$k], $val ), $tagdata );
				}
			}
			
			$tagdata	= str_replace( LD.$key.RD, $val, $tagdata );
		}
    	
		/**	----------------------------------------
		/**	Prep data
		/**	----------------------------------------*/
		
		$config['ACT']				= $FNS->fetch_action_id('Super_search', 'save_search');
		
        $config['RET']				= (isset($_POST['RET'])) ? $_POST['RET'] : $FNS->fetch_current_uri();
        $config['RET']				= str_replace( array( '&amp;', ';' ), array( '&', '' ), $config['RET'] );
        
        $config['tagdata']			= $tagdata;
        
        $config['super_search_id']	= $results['history_id'];
        
        $config['cache_id']			= $results['cache_id'];
		
		$config['delete_mode']		= ( $TMPL->fetch_param('delete_mode') == 'yes' ) ? 'yes': '';
		
		$config['form_id']			= ( $TMPL->fetch_param('form_id') ) ? $TMPL->fetch_param('form_id'): 'save_search_form';
		
		$config['form_name']		= ( $TMPL->fetch_param('form_name') ) ? $TMPL->fetch_param('form_name'): 'save_search_form';
		
		$config['return']			= ( $TMPL->fetch_param('return') ) ? $TMPL->fetch_param('return'): '';
		
		/**	----------------------------------------
		/**	Declare form
		/**	----------------------------------------*/
		
		return $this->_form( $config );
	}
	
	/*	End save search form */

    // --------------------------------------------------------------------

	/**
	 * Save search to history
	 *
	 * @access	private
	 * @return	boolean
	 */
	 
	function _save_search_to_history( $cache_id = 0, $results = 0, $q = '' )
	{
		global $DB, $IN, $LANG, $LOC, $PREFS, $SESS;
		
		if ( $this->disable_history === TRUE ) return FALSE;
		if ( empty( $this->sess['uri'] ) === TRUE ) return FALSE;
		
        /** ----------------------------------------
        /**	Let's set a history cookie for them
        /** ----------------------------------------*/
        
        if ( ( $cookie_id = $this->_get_users_cookie_id() ) === FALSE )
        {
        	return FALSE;
        }
		
        /** ----------------------------------------
        /**	Save to DB
        /** ----------------------------------------*/
        
        $newuri	= ( empty( $this->sess['newuri'] ) === FALSE ) ? $this->sess['newuri']: '';
        
        $arr	= array(
        		'cache_id'		=> $cache_id,
        		'member_id'		=> $SESS->userdata('member_id'),
        		'cookie_id'		=> $cookie_id,
        		'ip_address'	=> $IN->IP,
        		'site_id'		=> $PREFS->ini('site_id'),
        		'search_date'	=> $LOC->now,
        		'search_name'	=> $LANG->line('search'),
        		'results'		=> $results,
        		'hash'			=> $this->hash,
        		'query'			=> $q
			);
			
		$sql	= $DB->insert_string( 'exp_super_search_history', $arr );
		
		$sql	.= " ON DUPLICATE KEY UPDATE cache_id = VALUES(cache_id), member_id = VALUES(member_id), cookie_id = VALUES(cookie_id), search_date = VALUES(search_date), saved = 'n', results = VALUES(results), hash = VALUES(hash), query = VALUES(query) /* Super Search save search to history */";
			
		$DB->query( $sql );
		
		$arr['history_id']				= $DB->insert_id;
		$this->sess['search_history']	= $arr;
		
		return TRUE;
	}
	
	/*	End save search to history */

    // --------------------------------------------------------------------

	/**
	 * Search
	 *
	 * This method is really not as dramatic as it sounds. It just lets people parse search variables from $tagdata so that they can let people come back to a remembered search and execute it again.
	 *
	 * @access	public
	 * @return	string
	 */
	 
	function search()
	{
		global $DB, $FNS, $IN, $SESS, $TMPL;
        
        /** -------------------------------------
		/**	Who is this?
		/** -------------------------------------*/
		
		if ( ( $member_id = $SESS->userdata('member_id') ) === 0 )
		{
			if ( ( $cookie_id = $this->_get_users_cookie_id() ) === FALSE )
			{
				return $this->_strip_variables( $TMPL->tagdata );
			}
		}
        
        /** -------------------------------------
		/**	Start the SQL
		/** -------------------------------------*/
		
		$sql	= "/* Super Search grab last search for vars */ SELECT history_id AS search_id, search_date AS super_search_date, search_name AS name, results, saved, query
					FROM exp_super_search_history
					WHERE site_id IN ( ".implode( ',', $TMPL->site_ids )." )";
					
		if ( empty( $member_id ) === FALSE )
		{
			$sql	.= " AND member_id = ".$DB->escape_str( $member_id );
		}
		elseif ( empty( $cookie_id ) === FALSE )
		{
			$sql	.= " AND cookie_id = ".$DB->escape_str( $cookie_id );
		}
        
        /** -------------------------------------
		/**	Do we have a search id?
        /** -------------------------------------
        /*	If we have a search id, we pull that search. If we do not have an id then we will pull the user's last search which we know if the only search in their history that has not yet been saved by them. We save the last search for each user who touches the system.
		/** -------------------------------------*/
		
		if ( $TMPL->fetch_param('search_id') !== FALSE AND is_numeric( $TMPL->fetch_param('search_id') ) === TRUE )
		{
			$sql	.= " AND history_id = ".$DB->escape_str( $TMPL->fetch_param('search_id') );
		}
		else
		{
			$sql	.= " AND saved = 'n'";
		}
        
        /** -------------------------------------
		/**	Order
		/** -------------------------------------*/
		
		$sql	.= " ORDER BY search_date DESC";
        
        /** -------------------------------------
		/**	Limit
		/** -------------------------------------*/
		
		$sql	.= " LIMIT 1";
        
        /** -------------------------------------
		/**	Run query
		/** -------------------------------------*/
		
		$query	= $DB->query( $sql );
		
		if ($query->num_rows === 0 )
		{
			return $this->_strip_variables( $TMPL->tagdata );
		}
		
		/**	----------------------------------------
		/**	Find out what we need from tagdata
		/**	----------------------------------------*/
		
		$i	= 0;
		
		foreach ( $TMPL->var_single as $key => $val )
		{
			$i++;
		
			if ( strpos( $key, 'format=' ) !== FALSE )
			{
				$full	= $key;
				$key	= preg_replace( "/(.*?)\s+format=[\"'](.*?)[\"']/s", '\1', $key );
				$dates[$key][$i]['format']	= $val;
				$dates[$key][$i]['full']	= $full;
			}
		}
	
		/**	----------------------------------------
		/**	Localize
		/**	----------------------------------------*/
		
		if ( empty( $dates ) === FALSE )
		{
			setlocale( LC_TIME, $SESS->userdata('time_format') );
		}
        
        /** -------------------------------------
		/**	Parse
		/** -------------------------------------*/
		
		$prefix	= 'super_search_';
		$r		= '';
		$vars	= array();
		
		foreach ( $query->result as $row )
		{
			$tagdata	= $TMPL->tagdata;

			/**	----------------------------------------
			/**	Prep query into row
			/**	----------------------------------------*/
			
			if ( $row['query'] != '' )
			{
				$vars	= $this->_extract_vars_from_query( unserialize( base64_decode( $row['query'] ) ) );
			}
			
			$tagdata	= $this->_parse_array_fields( $tagdata, $vars );

			/**	----------------------------------------
			/**	Conditionals and switch
			/**	----------------------------------------*/
			
			$tagdata	= $FNS->prep_conditionals( $tagdata, array_merge( $row, $vars ) );

			/**	----------------------------------------
			/**	Loop for dates
			/**	----------------------------------------*/
			
			if ( empty( $dates ) === FALSE )
			{
				foreach ( $dates as $field => $date )
				{
					foreach ( $date as $key => $val )
					{					
						if ( isset( $row[$field] ) === TRUE AND is_numeric( $row[$field] ) === TRUE )
						{
							$tagdata	= str_replace( LD.$val['full'].RD, $this->_parse_date( $val['format'], $row[$field] ), $tagdata );
						}
					}
				}
			}
			
			unset( $row['super_search_date'] );

			/**	----------------------------------------
			/**	Regular parse
			/**	----------------------------------------*/
			
			foreach ( $row as $key => $val )
			{
				$key	= $prefix.$key;
				
				if ( strpos( LD.$key, $tagdata ) !== FALSE ) continue;
				
				$tagdata	= str_replace( LD.$key.RD, $val, $tagdata );
			}

			/**	----------------------------------------
			/**	Variable parse
			/**	----------------------------------------*/
			
			foreach ( $vars as $key => $val )
			{				
				if ( strpos( LD.$key, $tagdata ) !== FALSE ) continue;
				
				$tagdata	= str_replace( LD.$key.RD, $val, $tagdata );
			}

			/**	----------------------------------------
			/**	Parse empties
			/**	----------------------------------------*/
			
			$tagdata	= $this->_strip_variables( $tagdata );
			
			$r	.= $tagdata;
		}
		
		return $r;
	}
	
	/*	End search */

    // --------------------------------------------------------------------

	/**
	 * Security
	 *
	 * @access	private
	 * @return	boolean
	 */
	 
	function _security()
	{
		global $DB, $IN, $LANG, $OUT, $PREFS, $SESS, $TMPL;
		
        /** ----------------------------------------
        /**  Is the current user allowed to search?
        /** ----------------------------------------*/

        if ($SESS->userdata['can_search'] == 'n' AND $SESS->userdata['group_id'] != 1)
        {
            return $OUT->show_user_error('general', array($LANG->line('search_not_allowed')));
        	return FALSE;
        }
        
        /** ----------------------------------------
        /**	Is the user banned?
        /** ----------------------------------------*/
        
        if ( $SESS->userdata['is_banned'] === TRUE )
        {
            return $OUT->show_user_error('general', array($LANG->line('search_not_allowed')));
        	return FALSE;
        }
                
        /** ----------------------------------------
        /**	Is the IP address and User Agent required?
        /** ----------------------------------------*/
                
        if ( $PREFS->ini('require_ip_for_posting') == 'y' )
        {
        	if ( ( $IN->IP == '0.0.0.0' OR $SESS->userdata['user_agent'] == '' ) AND $SESS->userdata['group_id'] != 1 )
        	{
				return $OUT->show_user_error('general', array($LANG->line('search_not_allowed')));
				return FALSE;
        	}        	
        }
        
        /** ----------------------------------------
		/**	Is the nation of the user bannend?
		/** ----------------------------------------*/
		
		if ( isset($TMPL->module_data['Ip_to_nation']))
		{
			$SESS->nation_ban_check();
        }
        
        /** ----------------------------------------
        /**	Blacklist / Whitelist Check
        /** ----------------------------------------*/
        
        if ( $IN->blacklisted == 'y' && $IN->whitelisted == 'n' )
        {
            return $OUT->show_user_error('general', array($LANG->line('search_not_allowed')));
        	return FALSE;
        }
        
        /** ----------------------------------------
        /**	Return
        /** ----------------------------------------*/
        
        return TRUE;
	}
	
	/*	End security */

    // --------------------------------------------------------------------

	/**
	 * Separate numeric from textual
	 *
	 * We want two arrays derived from one. One array will contain the numeric values in a given array and the other will contain all other values. We use this when we are searching by categories and we might receive some cat ids as well as some cat names or cat urls in an array of search terms.
	 * If no numeric values are found, we return FALSE.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _separate_numeric_from_textual( $arr = array() )
	{
		if ( empty( $arr ) === TRUE ) return FALSE;
		
		$new['textual']	= array(); $new['numeric'] = array();
		
		foreach ( $arr as $val )
		{
			if ( is_numeric( $val ) === TRUE )
			{
				$new['numeric'][]	= $val;
			}
			else
			{
				$new['textual'][]	= $val;
			}
		}
		
		if ( empty( $new['numeric'] ) === TRUE ) return FALSE;
		
		return $new;
 	}
	
	/* End separate numeric from textual */

    // --------------------------------------------------------------------

	/**
	 * Sess
	 *
	 * This is a really convenient utility, but it takes up extra fractions of milliseconds. We should phase it out.
	 *
	 * @access	public
	 * @return	null
	 */
	 
	function sess()
	{
		$s = func_num_args();
		
		if ($s == 0)
		{
			return FALSE;
		}
		
		/** --------------------------------------------
        /**  Find Our Value, If It Exists
        /** --------------------------------------------*/
        
        $value = (isset($this->sess[func_get_arg(0)])) ? $this->sess[func_get_arg(0)] : FALSE;
		
		for($i = 1; $i < $s; ++$i)
		{
			if ( ! isset($value[func_get_arg($i)]))
			{
				return FALSE;
			}
			
			$value = $value[func_get_arg($i)];
		}
		
		return $value;
	}
	
	/*	End sess */

    // --------------------------------------------------------------------

	/**
	 * Split date
	 *
	 * Break a date string into chunks of 2 chars each.
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _split_date( $str = '' )
	{	
		if ( $str == '' ) return array();
		
		if ( function_exists( 'str_split' ) )
		{
			$thedate	= str_split( $str, 2 ); unset( $str );
			return $thedate;
		}
		
		$temp	= preg_split( '//', $str, -1, PREG_SPLIT_NO_EMPTY );
		
		do
		{
			$t = array();
		
			for ( $i=0; $i<2; $i++ )
			{
				$t[]	= array_shift( $temp );
			}
			
			$thedate[]	= implode( '', $t );
		}
		while ( count( $temp ) > 0 );
		
		return $thedate;
	}
	
	/*	End split date */

    // --------------------------------------------------------------------

	/**
	 * Strip variables
	 *
	 * This quick method strips variables like this {super_search_some_value} and like this {/super_search_some_value} from a string.
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _strip_variables( $tagdata = '' )
	{
		if ( $tagdata == '' ) return '';
		
		$tagdata	= preg_replace( "/".LD."super_search_(.*?)".RD."/s", "", $tagdata );
		$tagdata	= preg_replace( "/".LD.SLASH."super_search_(.*?)".RD."/s", "", $tagdata );
		
		return $tagdata;
	}
	
	/*	End strip variables */

    // --------------------------------------------------------------------

	/**
	 * Table columns
	 *
	 * Retrieves, stores and returns an array of the columns in a table
	 * At the moment, I've decided it's all stupid. We'll just go static
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _table_columns( $table = '' )
	{
		global $DB, $EXT, $LOC, $TMPL;
		
		if ( $table == '' ) return FALSE;
        
        /** -------------------------------------
        /**	Make it static, make it fast
		/** -------------------------------------*/
		
		$fields['exp_weblog_titles']	= array(
			'entry_id' => 'entry_id',
			'site_id' => 'site_id',
			'weblog_id' => 'weblog_id',
			'author_id' => 'author_id',
			'pentry_id' => 'pentry_id',
			'forum_topic_id' => 'forum_topic_id',
			'ip_address' => 'ip_address',
			'title' => 'title',
			'url_title' => 'url_title',
			'status' => 'status',
			'versioning_enabled' => 'versioning_enabled',
			'view_count_one' => 'view_count_one',
			'view_count_two' => 'view_count_two',
			'view_count_three' => 'view_count_three',
			'view_count_four' => 'view_count_four',
			'allow_comments' => 'allow_comments',
			'allow_trackbacks' => 'allow_trackbacks',
			'sticky' => 'sticky',
			'date' => 'entry_date',
			'entry_date' => 'entry_date',
			'dst_enabled' => 'dst_enabled',
			'year' => 'year',
			'month' => 'month',
			'day' => 'day',
			'expiration_date' => 'expiration_date',
			'comment_expiration_date' => 'comment_expiration_date',
			'edit_date' => 'edit_date',
			'recent_comment_date' => 'recent_comment_date',
			'comment_total' => 'comment_total',
			'trackback_total' => 'trackback_total',
			'sent_trackbacks' => 'sent_trackbacks',
			'recent_trackback_date' => 'recent_trackback_date'
		);
		
		$fields['exp_members']	= array(
			'member_id' => 'member_id',
			'username' => 'username',
			'screen_name' => 'screen_name',
			'email' => 'email',
			'url' => 'url',
			'location' => 'location',
			'occupation' => 'occupation',
			'interests' => 'interests',
			'bday_d' => 'bday_d',
			'bday_m' => 'bday_m',
			'bday_y' => 'bday_y',
			'bio' => 'bio',
			'signature' => 'signature',
			'avatar_filename' => 'avatar_filename',
			'avatar_width' => 'avatar_width',
			'avatar_height' => 'avatar_height',
			'photo_filename' => 'photo_filename',
			'photo_width' => 'photo_width',
			'photo_height' => 'photo_height',
			'sig_img_filename' => 'sig_img_filename',
			'sig_img_width' => 'sig_img_width',
			'sig_img_height' => 'sig_img_height',
			'join_date' => 'join_date',
			'last_visit' => 'last_visit',
			'last_activity' => 'last_activity',
			'total_entries' => 'total_entries',
			'total_comments' => 'total_comments',
			'total_forum_topics' => 'total_forum_topics',
			'total_forum_posts' => 'total_forum_posts',
			'last_entry_date' => 'last_entry_date',
			'last_comment_date' => 'last_comment_date',
			'language' => 'language',
			'timezone' => 'timezone',
			'daylight_savings' => 'daylight_savings',
			'time_format' => 'time_format'
			);
        
        /** -------------------------------------
        /**	And slow it down with custom shat
		/** -------------------------------------*/
		
		if ( isset($TMPL->module_data['Rating']) && ! isset( $this->sess['fields']['searchable']['rating'] ) )
		{
			$fields['exp_weblog_titles']['rating']	= 'rating_avg';
		}
			
		/** ----------------------------------------
		/**	Manipulate $fields
		/** ----------------------------------------*/
		
		if ($EXT->active_hook('super_search_table_columns') === TRUE)
		{
			$fields	= $EXT->universal_call_extension( 'super_search_table_columns', $this, $fields );
		}

		if ( isset( $fields[$table] ) === FALSE ) return FALSE;
		
		return $fields[$table];
	}
	
	/* End table columns */

    // --------------------------------------------------------------------

	/**
	 * Translator for Cut/Paste
	 *
	 * @access	public
	 * @return	string
	 */
    
	function _translator($n)
    {
        static $dc = "0123456789";
        static $sc = "\x10\x11\x12\x13\x14\x15\x16\x17\x18\x19";
        
        return (intval($n)) ? strtr($n, $dc, $sc) : intval(strtr($n, $sc, $dc));
    }
    
    /* END _translator() */

    // --------------------------------------------------------------------

	/**
	 * Uncerealize
	 *
	 * serialize() and unserialize() add a bunch of characters that are not needed when storing a one dimensional indexed array. Why not just use a pipe?
	 *
	 * @access	private
	 * @return	string
	 */
	 
	function _uncerealize( $str = '' )
	{
		return explode( '|', $str );
	}
	
	/* End uncerealize */

    // --------------------------------------------------------------------

	/**
	 * Weblog ids
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _weblog_ids( $id = '', $param = '' )
	{
		global $DB, $TMPL;
        
        /** -------------------------------------
        /**	Already done?
		/** -------------------------------------*/
		
		if ( ( $weblog_ids = $this->sess( 'weblog_ids' ) ) === FALSE )
		{
			/** -------------------------------------
			/**	Fetch
			/** -------------------------------------*/
			
			$weblogs	= $this->data->get_weblogs_by_site_id_keyed_to_name( $TMPL->site_ids );
			$weblog_ids	= $this->data->get_weblogs_by_site_id( $TMPL->site_ids );

			$this->sess['weblogs']		= $weblogs;
			$this->sess['weblog_ids']	= $weblog_ids;
		}
		
		if ( $id == '' )
		{
			return $weblog_ids;
		}
		
		if ( $id != '' AND $param != '' AND isset( $weblog_ids[$id][$param] ) === TRUE )
		{
			return $weblog_ids[$id][$param];
		}
		
		if ( isset( $weblog_ids[$id] ) === TRUE )
		{
			return $id;
		}
		
		return FALSE;
	}
	
	/*	End weblog ids */

    // --------------------------------------------------------------------

	/**
	 * Weblogs
	 *
	 * @access	private
	 * @return	array
	 */
	 
	function _weblogs( $blog = '', $param = '' )
	{
		global $DB, $TMPL;
        
        /** -------------------------------------
        /**	Already done?
		/** -------------------------------------*/
		
		if ( ( $weblog_ids = $this->sess( 'weblog_ids' ) ) === FALSE )
		{
			/** -------------------------------------
			/**	Fetch
			/** -------------------------------------*/
			
			$weblogs	= $this->data->get_weblogs_by_site_id_keyed_to_name( $TMPL->site_ids );
			$weblog_ids	= $this->data->get_weblogs_by_site_id( $TMPL->site_ids );

			$this->sess['weblogs']		= $weblogs;
			$this->sess['weblog_ids']	= $weblog_ids;
		}
		
		if ( $blog == '' )
		{
			return FALSE;
		}
		
		if ( $blog != '' AND $param != '' AND isset( $weblogs[$blog][$param] ) === TRUE )
		{
			return $weblogs[$blog][$param];
		}
		
		if ( isset( $weblogs[$blog] ) === TRUE )
		{
			return $blog;
		}
		
		return FALSE;
	}
	
	/*	End weblogs */
}

// END CLASS Super search

// --------------------------------------------------------------------

/**
 * Query structure
 *
 * Here are some notes on query structure
 
Requirements
a. A search segment must always begin with search&
b. Separate multiple vectors with &
c. Separate multiple terms using + 

I. Keywords
1. Single keyword
http://www.domain.com/index.php/search/search&keywords+pickles
You can simply pass a keyword. Super Search will find entries with 'pickles' somewhere in the title or searchable custom fields. 'bigpickles' would return true. 'picklespants' would return true.

2. Multiple keywords
http://www.domain.com/index.php/search/search&keywords+pickles+burgers
This query will find entries with either 'pickles' or 'burgers' in the title or searchable custom fields.

3. Negated keywords
http://www.domain.com/index.php/search/search&keywords+pickles+-burgers
This query will find entries with 'pickles' but not 'burgers' in the title or searchable custom fields.

II. Categories
1. Filter by single category
http://www.domain.com/index.php/search/search&keywords+pickles&category+"fast+food"
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries are assigned to the 'fast food' category.

2. Filter by negated category
http://www.domain.com/index.php/search/search&keywords+pickles&category+-"fast+food"
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries are NOT assigned to the 'fast food' category.

3. Filter by conjoined categories
http://www.domain.com/index.php/search/search&keywords+pickles&category+"fast+food"&&healthy
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries are assigned to both the 'fast food' and 'healthy' categories.

4. Filter by loose negated category
http://www.domain.com/index.php/search/search&keywords+pickles&categorylike+-fast
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries are NOT assigned to any categories with 'fast' in the name.

5. Filter by loose category
http://www.domain.com/index.php/search/search&keywords+pickles&categorylike+fast
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries are assigned to any categories with 'fast' in the name.

III. Blogs
1. Filter by weblog (We're already using the term channel instead of weblog since EE 2.0 will be adopting that.)
http://www.domain.com/index.php/search/search&keywords+pickles&channel+bubba_blog
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries belong to the 'bubba_blog' weblog. The weblog name should be designated using the weblog short name.

IV. Status
1. Filter by status
http://www.domain.com/index.php/search/search&keywords+pickles&status+open
This query will find entries with 'pickles' in the title or searchable custom fields as long as those entries have a status of 'open'.

V. Fields
1. Filter by a value in a specific field, loosely
http://www.domain.com/index.php/search/search&summary+pickles
This query will find entries where the summary field contains the word 'pickles'.

2. Filter by values in specific fields, loosely
http://www.domain.com/index.php/search/search&summary+pickles+mustard&body+cake
This query will find entries where the summary field contains either 'pickles' or 'mustard' AND the body field contains the word 'cake'.

3. Filter by negated values in a specific field
http://www.domain.com/index.php/search/search&summary+-pickles
This query will find entries where the summary field does NOT contain the word 'pickles'.

VI. Exact Fields
1. Filter by a value in a specific field, exactly
http://www.domain.com/index.php/search/search&exact-summary
This query will find entries where the summary field equals 'pickles'.

2. Filter by values in specific fields, exactly
http://www.domain.com/index.php/search/search&exact-summary+pickles&exact-body+cake
This query will find entries where the summary field equals 'pickles' AND the body equals 'cake'.

VII. From / To Fields
Note: Requires that MySQL field types be changed manually so that numeric searches, where desired, perform correctly.
1. Filter where a field is less than or equal to a given value.
http://www.domain.com/index.php/search/search&price-to+50
This query will find entries where the price field is less than or equal to '50'.

2. Filter where a field is greater than or equal to a given value.
http://www.domain.com/index.php/search/search&price-from+20
This query will find entries where the price field is greater than or equal to '20'.

3. Filter where a field is within a range, inclusive.
http://www.domain.com/index.php/search/search&price-from+20&price-to+50
This query will find entries where the price field is between 20 and 50 inclusive.

VIII. Empty Fields
1. Filter where a field is empty.
http://www.domain.com/index.php/search/search&region-empty=y
This query will find entries where the region field is empty.

2. Filter where a field is not empty.
http://www.domain.com/index.php/search/search&region-empty=n
This query will find entries where the region field is not empty.

IX. Forcing queries
1. Template admins can force parameters onto queries through template parameters. category, num, start, keywords, status, channel and tag may all be forced. Use standard syntax. status="-pending" would prevent entries of status 'pending' from being returned as results.

X. Order
1. Order can be controlled by URI or parameter.
http://www.domain.com/index.php/search/search&keywords+a&order+title+desc+entry_date+summary+desc
This query will find entries where the title or searchable custom fields contain 'a'. The entries will be ordered by title in descending order, then by entry_date in ascending order, then by summary in descending order. Note that if a 'desc' or 'asc' flag does not follow a field name, sort is ascending.

2. Order can be controlled by template parameter. Just supply the 'order' parameter and give it a string of order rules just as you would in the URI. The above search would be controlled in the 'order' parameter like this order="title desc entry_date summary desc"

3. You can send the order command through POST as well. You can offer an order field in your form and populate it through Javascript with an appropriate order string as above. You can also create more complicated order behavior by sending the 'order' command as a POST array. Name your fields 'order[]'. You can offer as many as you like. The values provided in these fields will concatenate an order string in Super Search. So you can have 4 'order[]' fields. The first would indicate a a list of custom fields or standard fields to order by. The second would indicate the sort, either asc or desc for ascending or descending. The third field would contain another list of custom or standard fields. And the fourth field would contain a choice of asc or desc just as the second field did.

*/