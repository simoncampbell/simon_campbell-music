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
 * Super Search Module Class - CP
 *
 * Control panel class
 *
 * @package		Solspace:Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @see			http://www.solspace.com/docs/
 * @location 	./system/modules/super_search/mcp.super_search.php
 */ 

require_once PATH.'hermes/lib/addon_builder/module_builder.php';

class Super_search_CP extends Module_builder
{
	var $row_limit	= 50;
	var $sess		= array();

    // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @param	bool		Enable calling of methods based on URI string
	 * @return	string
	 */
    
	function Super_search_CP ( $switch = TRUE )
    {
        global $IN, $DB, $LANG, $PREFS, $DSP, $OUT, $SESS;
        
        $this->sess	=&	$SESS->cache['modules']['super_search'];
        
        parent::Module_builder('super_search');
        
        if ( (bool) $switch === FALSE ) return;	// We're in install / uninstall mode
        
        /** --------------------------------------------
        /**  Automatically Loaded Class Vars
        /** --------------------------------------------*/
        
        $this->base = BASE.'&C=modules&M=super_search';
		
		/** --------------------------------------------
        /**  Module Menu Items
        /** --------------------------------------------*/
        
        $menu	= array(
        	'module_home'	=> array(
        		'link'  => $this->base,
				'title' => $LANG->line('homepage')
        	),
        														
			'module_fields'	=> array(
				'link'  => $this->base.'&P=fields',
				'title' => $LANG->line('fields')
			)
        );
        
        if ( $this->data->playa_is_installed() === TRUE )
        {
			$menu['module_preferences']		= array(
				'link'  => $this->base.'&P=preferences',
				'title' => $LANG->line('preferences')
			);
        }
        													
		$menu['module_documentation']	= array(
			'link'  => 'http://www.solspace.com/docs/addon/c/Super_Search/',
			'title' => $LANG->line('documentation')
		);
        
        $this->cached_vars['module_menu_highlight'] = 'module_home';
        $this->cached_vars['module_menu'] = $this->equalize_menu($menu);
        
        /** --------------------------------------------
        /**  Sites
        /** --------------------------------------------*/
        
        $this->cached_vars['sites']	= array();
        
        foreach($this->data->get_sites() as $site_id => $site_label)
        {
        	$this->cached_vars['sites'][$site_id] = $site_label;
        }
			
		/** -------------------------------------
		/**  Module Installed and What Version?
		/** -------------------------------------*/
			
		if ($this->database_version() == FALSE)
		{
			return;
		}
		elseif($this->version_compare($this->database_version(), '<', SUPER_SEARCH_VERSION))
		{
			if ($this->super_search_module_update() === FALSE)
			{
				return;
			}
		}
		
		/** -------------------------------------
		/**  Run Our Queue 
		/** -------------------------------------*/
		
		$this->actions();
		
		/** -------------------------------------
		/**  Request and View Builder
		/** -------------------------------------*/
        
        if ($switch)
        {
        	if ($IN->GBL('P') === FALSE)
        	{
        		$output = $this->home();
        	}
        	elseif(! method_exists($this, $IN->GBL('P')))
        	{
        		$this->add_crumb($LANG->line('invalid_request'));
        		$this->cached_vars['error_message'] = $LANG->line('invalid_request');
        		
        		$output = $this->ee_cp_view('error_page.html', array(), TRUE);
        	}
        	else
        	{
        		$output = $this->{$IN->GBL('P')}();
        	}
        }
    }
    /* END */
	
	// --------------------------------------------------------------------

	/**
	 * Clear cache
	 
	 * @access	private
	 * @return	boolean
	 */
    
	function _clear_cache()
    {
    	global $DB, $PREFS;
    	
    	if ( empty( $_POST ) === TRUE ) return FALSE;
    	
    	if ( isset( $_POST['cache'] ) === TRUE AND $_POST['cache'] == 'clear' )
    	{
			do
			{
				$DB->query(
					"DELETE FROM exp_super_search_cache
					WHERE site_id = ".$DB->escape_str( $PREFS->ini('site_id') )."
					LIMIT 1000"
				);
			} 
			while ( $DB->affected_rows > 0 );
			
			do
			{
				$DB->query(
					"DELETE FROM exp_super_search_history
					WHERE saved = 'n'
					AND cache_id NOT IN (
						SELECT cache_id
						FROM exp_super_search_cache
						WHERE site_id = ".$DB->escape_str( $PREFS->ini('site_id') )."
					)
					LIMIT 1000"
				);
			} 
			while ( $DB->affected_rows > 0 );
    	}
    	
    	return TRUE;
    }
    
    /*	End clear cache */
	
	// --------------------------------------------------------------------

	/**
	 * Edit field
	 
	 * @access	public
	 * @param	message
	 * @return	string
	 */
    
    function edit_field()
    {
    	global $DB, $FNS, $IN, $LANG;

		/**	----------------------------------------
		/**	Field id
		/**	----------------------------------------*/

		$field_id	= $IN->GBL('field_id');

		/**	----------------------------------------
		/**	SQL
		/**	----------------------------------------*/
		
		if ( empty( $_POST['sql'] ) === FALSE )
		{
			$sql	= base64_decode( $_POST['sql'] );
			
			$DB->query( $sql );
		}

		/**	----------------------------------------
		/**	Load fields page
		/**	----------------------------------------*/
		
		$FNS->redirect( $this->base.AMP.'P=fields'.AMP.'msg=field_edited_successfully' );
    }
    
    /*	End edit field */
	
	// --------------------------------------------------------------------

	/**
	 * Edit field confirm
	 
	 * @access	public
	 * @param	message
	 * @return	string
	 */
    
    function edit_field_confirm()
    {
    	global $DB, $IN, $LANG, $OUT;
    	
    	if (empty($_POST['type'])) return FALSE;

		/**	----------------------------------------
		/**	Field id
		/**	----------------------------------------*/

		$field_id	= $IN->GBL('field_id');

		/**	----------------------------------------
		/**	Field length tests
		/**	----------------------------------------*/
		
		$error	= array();
		$sql	= "";
		
		switch ( $_POST['type'] )
		{
			case 'character':
			
				if ( empty( $_POST['length'] ) OR ! is_numeric($_POST['length']) )
				{
					$error[]	= $LANG->line('field_length_required');
				}
				elseif ( $_POST['length'] < 1 OR $_POST['length'] > 255 )
				{
					$error[]	= $LANG->line('char_length_incorrect');
				}
				
				$check_truncation	= TRUE;
				$sql	.= " CHAR(".round($_POST['length']).") NOT NULL";

			break;
			case 'varchar':
			
				if ( empty( $_POST['length'] ) OR ! is_numeric($_POST['length']) )
				{
					$error[]	= $LANG->line('field_length_required');
				}
				elseif ( $_POST['length'] < 1 OR $_POST['length'] > 255 )
				{
					$error[]	= $LANG->line('varchar_length_incorrect');
				}
				
				$check_truncation	= TRUE;
				$sql	.= " VARCHAR(".round($_POST['length']).") NOT NULL";
			
			break;
			case 'decimal':
			
				if ( empty( $_POST['length'] ) OR ! is_numeric($_POST['length']) )
				{
					$error[]	= $LANG->line('field_length_required');
				}
				elseif ( $_POST['length'] < 1 )
				{
					$error[]	= $LANG->line('float_length_incorrect');
				}
				elseif ( $_POST['length'] < $_POST['precision'] )
				{
					$error[]	= $LANG->line('precision_length_incorrect');
				}
				
				$check_truncation	= TRUE;
				$sql	.= " DECIMAL(".round($_POST['length']).",".round($_POST['precision']).") NOT NULL";
			
			break;
			case 'integer':
			
				$_POST['length']	= 10;
				
				$check_truncation	= TRUE;
				$sql	.= " INT(".round($_POST['length']).") unsigned NOT NULL";
			break;
			case 'small integer':
			
				$_POST['length']	= 5;
				
				$check_truncation	= TRUE;
				$sql	.= " SMALLINT(".round($_POST['length']).") unsigned NOT NULL";
			
			break;
			case 'tiny integer':
			
				$_POST['length']	= 3;
				
				$check_truncation	= TRUE;
				$sql	.= " TINYINT(".round($_POST['length']).") unsigned NOT NULL";
			
			break;
			default:
				$sql	.= " TEXT NOT NULL";
			break;
		}
		
		$sql	= "ALTER TABLE `%table%` CHANGE `%field%` `%field%`".$sql;
		
		$sql	= str_replace( array( '%table%', '%field%' ), array( 'exp_weblog_data', 'field_id_'.$field_id ), $sql );

		/**	----------------------------------------
		/**	Any errors?
		/**	----------------------------------------*/

		if ( count( $error ) > 0 )
		{
			return $OUT->show_user_error('submission', $error);
		}

		/**	----------------------------------------
		/**	Prep vars
		/**	----------------------------------------*/
		
		$this->cached_vars['field_id']	= $field_id;
		$this->cached_vars['sql']		= base64_encode( $sql );
		$this->cached_vars['method']	= 'edit_field';

		/**	----------------------------------------
		/**	Will this change truncate data?
		/**	----------------------------------------*/
		
		$this->cached_vars['question']	= $LANG->line('edit_field_question');
		
		if ( isset( $check_truncation ) === TRUE )
		{
			$sql	= "SELECT COUNT(*) AS count FROM exp_weblog_data WHERE CHAR_LENGTH( field_id_".$DB->escape_str( $field_id )." ) > ".$DB->escape_str( $_POST['length'] );
			
			$query	= $DB->query( $sql );
			
			if ( $query->num_rows > 0 AND $query->row['count'] > 0 )
			{
				$this->cached_vars['question']	= str_replace( array( '%field_label%', '%count%' ), array( $_POST['field_label'], $query->row['count'] ), $LANG->line('edit_field_question_truncate') );
			}
		}

		/**	----------------------------------------
		/**	Prep message
		/**	----------------------------------------*/
		
		$this->_prep_message();

		/**	----------------------------------------
		/**	Title and Crumbs
		/**	----------------------------------------*/
		
		$this->add_crumb( $LANG->line( 'edit_field' ) );
		$this->cached_vars['module_menu_highlight'] = 'module_fields';

		/**	----------------------------------------
		/**	Load Homepage
		/**	----------------------------------------*/
        
		$this->ee_cp_view('edit_field_confirm.html');
    }
    
    /*	End edit field confirm */
	
	// --------------------------------------------------------------------

	/**
	 * Edit field form
	 
	 * @access	public
	 * @param	message
	 * @return	string
	 */
    
    function edit_field_form( $message = '' )
    {
        global $IN, $DSP, $DB, $LANG;
        
        $this->cached_vars['field_id']			= $IN->GBL('field_id');
        $this->cached_vars['field_name']		= '';
        $this->cached_vars['field_label']		= '';
        $this->cached_vars['type']				= '';
        $this->cached_vars['length']			= '';
        $this->cached_vars['precision']			= '';
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		if ( $IN->GBL('field_id') !== FALSE )
		{
			$sql	= "SELECT field_id, field_name, field_label FROM exp_weblog_fields WHERE field_id = '".$DB->escape_str( $IN->GBL('field_id') )."' LIMIT 1";
			
			$query				= $DB->query($sql);
			
			$this->cached_vars['field_id']			= $query->row['field_id'];
			$this->cached_vars['field_name']		= $query->row['field_name'];
			$this->cached_vars['field_label']		= $query->row['field_label'];
			$this->cached_vars	= array_merge( $this->cached_vars, $this->_get_field_attributes( $query->row['field_id'] ) );
		}
        
		/** -------------------------------------
		/**	Prep message
		/** -------------------------------------*/
		
		$this->_prep_message( $message );		
        
		/** -------------------------------------
		/**	Title and Crumbs
		/** -------------------------------------*/
		
		$this->add_crumb( $LANG->line( 'edit_field' ) );
		$this->cached_vars['module_menu_highlight'] = 'module_fields';
		
		/** --------------------------------------------
        /**	Load Homepage
        /** --------------------------------------------*/
        
		$this->ee_cp_view('field.html');
	}
	
    /*	End edit field form */
	
	// --------------------------------------------------------------------

	/**
	 * Edit refresh rule
	 
	 * @access	public
	 * @return	string
	 */

    function edit_refresh_rule()
    {
        global $DB, $DSP, $FNS, $IN, $LANG, $LOC, $PREFS, $SESS;
        
        $update			= FALSE;
        
		/** -------------------------------------
		/**	Clear cache
		/** -------------------------------------*/
		
		$this->_clear_cache();
				
		/**	----------------------------------------
		/**	Validate
		/**	----------------------------------------*/
		
		$errors	= array();
        
        if ( is_numeric( $IN->GBL('refresh') ) === FALSE )
        {
			$errors[]	= $LANG->line('numeric_refresh');
        }
        
        if ( count( $errors ) > 0 )
        {
			return $DSP->error_message( $errors );
        }

		/**	----------------------------------------
		/**	Update or Create
		/**	----------------------------------------*/
		
		$query		= $DB->query( "SELECT COUNT(*) AS count FROM exp_super_search_refresh_rules WHERE site_id = ".$PREFS->ini('site_id') );
		
		if ( $query->num_rows > 0 AND $query->row['count'] > 0 )
		{
			$update	= TRUE;
		}
		
		$refresh	= ( $IN->GBL('refresh') != '' ) ? $IN->GBL('refresh'): 0;
		$date		= ( $refresh == 0 ) ? 0: ( $LOC->now + ( $refresh * 60 ) );
		
		if ( $update === TRUE )
		{
			$DB->query(
				$DB->update_string(
					'exp_super_search_refresh_rules',
					array(
						'refresh'		=> $refresh,
						'date'			=> $date,
						'member_id'		=> $SESS->userdata('member_id')
						),
					array(
						'site_id'		=> $PREFS->ini('site_id')
						)
					)
				);

			$message	= 'refresh_rule_updated';
		}
		else
		{
			$DB->query(
				$DB->insert_string(
					'exp_super_search_refresh_rules',
					array(
						'refresh'		=> $refresh,
						'date'			=> $date,
						'site_id'		=> $PREFS->ini('site_id'),
						'member_id'		=> $SESS->userdata('member_id')
						)
					)
				);

			$message	= 'refresh_rule_updated';
		}
        
		/**	----------------------------------------
		/**	Category group ids?
		/**	----------------------------------------*/
		
		$category_group_ids	= array();
		
		if ( empty( $_POST['category_group_id'] ) === FALSE )
		{
			foreach ( $_POST['category_group_id'] as $val )
			{
				$category_group_ids[]	= $val;
			}
		}
        
		/**	----------------------------------------
		/**	Template ids?
		/**	----------------------------------------*/
		
		$template_ids	= array();
		
		if ( empty( $_POST['template_id'] ) === FALSE )
		{
			foreach ( $_POST['template_id'] as $val )
			{
				$template_ids[]	= $val;
			}
		}
        
		/**	----------------------------------------
		/**	Weblog ids?
		/**	----------------------------------------*/
		
		$weblog_ids	= array();
		
		if ( empty( $_POST['weblog_id'] ) === FALSE )
		{
			foreach ( $_POST['weblog_id'] as $val )
			{
				$weblog_ids[]	= $val;
			}
		}

		/**	----------------------------------------
		/**	Update refresh rules
		/**	----------------------------------------*/
		
		$sql	= array();
		
		$sql[]	= "DELETE FROM exp_super_search_refresh_rules
					WHERE category_group_id != 0
					AND site_id = ".$DB->escape_str( $PREFS->ini('site_id') );
		
		$sql[]	= "DELETE FROM exp_super_search_refresh_rules
					WHERE weblog_id != 0
					AND site_id = ".$DB->escape_str( $PREFS->ini('site_id') );
		
		$sql[]	= "DELETE FROM exp_super_search_refresh_rules
					WHERE template_id != 0
					AND site_id = ".$DB->escape_str( $PREFS->ini('site_id') );
					
		foreach ( $sql as $q )
		{					
			$DB->query( $q );
		}

		foreach ( $category_group_ids as $val )
		{
			$sql	= $DB->insert_string('exp_super_search_refresh_rules',
										array(
											'site_id'			=> $PREFS->ini('site_id'),
											'refresh'			=> $refresh,
											'date'				=> $date,
											'category_group_id'	=> $val
										)
			);
					
			$DB->query( $sql );
		}

		foreach ( $weblog_ids as $val )
		{
			$sql	= $DB->insert_string('exp_super_search_refresh_rules',
										array(
											'site_id'			=> $PREFS->ini('site_id'),
											'refresh'			=> $refresh,
											'date'				=> $date,
											'weblog_id'	=> $val
										)
			);
					
			$DB->query( $sql );
		}
		
		foreach ( $template_ids as $val )
		{
			$sql	= $DB->insert_string('exp_super_search_refresh_rules',
										array(
											'site_id'			=> $PREFS->ini('site_id'),
											'refresh'			=> $refresh,
											'date'				=> $date,
											'template_id'	=> $val
										)
			);
					
			$DB->query( $sql );
		}
        
		/**	----------------------------------------
		/**	Return
		/**	----------------------------------------*/
		
		$FNS->redirect( $this->base.AMP.'msg='.$message );
    }
    
    /*	End edit refresh rule */
	
	// --------------------------------------------------------------------

	/**
	 * Fields
	 
	 * @access	public
	 * @param	message
	 * @return	string
	 */
    
    function fields($message = '')
    {
    	global $DB, $DSP, $IN, $LANG, $PREFS;

        $paginate		= '';
        $row_count		= 0;
        
        /** -------------------------------------
		/**	 Custom Field Groups by Site ID
		/** -------------------------------------*/
		
		$sql	= "SELECT group_id, group_name FROM exp_field_groups 
				   WHERE site_id = ".$DB->escape_str( $PREFS->ini('site_id') )." ORDER BY group_name";
				   
		$query = $DB->query($sql);
		
		$this->cached_vars['field_groups']	= array();
		
		foreach ( $query->result as $row )
		{
			$this->cached_vars['field_groups'][$row['group_id']] = $row['group_name'];
		}
		
		if ($query->num_rows > 0)
		{
			$this->cached_vars['default_group_id'] = $query->row['group_id'];
		}
		
		/** -------------------------------------
		/**	 Custom Fields by Group ID
		/** -------------------------------------*/
		
		$sql	= "SELECT field_id, field_label, group_id FROM exp_weblog_fields 
				   WHERE site_id = ".$DB->escape_str( $PREFS->ini('site_id') )." ORDER BY group_id, field_label";
				   
		$query = $DB->query($sql);
		
		$this->cached_vars['fields']	= array();
		
		foreach ( $query->result as $row )
		{
			$row	= array_merge( $row, $this->_get_field_attributes( $row['field_id'] ) );
			$this->cached_vars['fields'][$row['group_id']][$row['field_id']]	= $row;
		}
        
		/** -------------------------------------
		/**	Prep message
		/** -------------------------------------*/
		
		$this->_prep_message( $message );
        
		/** -------------------------------------
		/**	Title and Crumbs
		/** -------------------------------------*/
		
		$this->add_crumb( $LANG->line('fields') );
		$this->cached_vars['module_menu_highlight'] = 'module_fields';
		
		/** --------------------------------------------
        /**	Load page
        /** --------------------------------------------*/
        
		$this->ee_cp_view('fields.html');
    }
    
    /**	End fields */
	
	// --------------------------------------------------------------------

	/**
	 * Get field attributes
	 
	 * @access	private
	 * @param	message
	 * @return	array
	 */
	
	function _get_field_attributes( $field )
	{
		global $DB;
		
		if ( $field == '' ) return FALSE;
		
		if ( isset( $this->sess['fields'][$field] ) === FALSE )
		{
			$sql	= "DESCRIBE `exp_weblog_data`";
			
			$query	= $DB->query( $sql );
			
			$fields	= array();
			
			foreach ( $query->result as $row )
			{
				if ( strpos( $row['Field'], 'field_id_' ) === FALSE ) continue;
				$id	= str_replace( 'field_id_', '', $row['Field'] );
				$fields[ $id ]['type']		= $row['Type'];
				$fields[ $id ]['length']	= '';
				$fields[ $id ]['precision']	= '';
				$fields[ $id ]['default']	= $row['Default'];
			
				/** -------------------------------------
				/**  Char
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'char' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'character';				
					$arr	= explode( ",", str_replace( array( 'char(', ')' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= $arr[0];
				}
			
				/** -------------------------------------
				/**  Decimal
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'decimal' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'decimal';				
					$arr	= explode( ",", str_replace( array( 'decimal(', ')' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= $arr[0];
					$fields[ $id ]['precision']	= $arr[1];
				}
			
				/** -------------------------------------
				/**  Float
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'float' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'float';				
					$arr	= explode( ",", str_replace( array( 'float(', ')' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= $arr[0];
					$fields[ $id ]['precision']	= $arr[1];
				}
			
				/** -------------------------------------
				/**  Integer
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'int' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'integer';				
					$arr	= explode( ",", str_replace( array( 'int(', ')', 'unsigned' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= trim( $arr[0] );
				}
			
				/** -------------------------------------
				/**  Small integer
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'smallint' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'small integer';				
					$arr	= explode( ",", str_replace( array( 'smallint(', ')', 'unsigned' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= trim( $arr[0] );
				}
			
				/** -------------------------------------
				/**  Tiny integer
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'tinyint' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'tiny integer';				
					$arr	= explode( ",", str_replace( array( 'tinyint(', ')', 'unsigned' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= trim( $arr[0] );
				}
			
				/** -------------------------------------
				/**  Var char
				/** -------------------------------------*/
				
				if ( strpos( $row['Type'], 'varchar' ) !== FALSE )
				{
					$fields[ $id ]['type']	= 'varchar';				
					$arr	= explode( ",", str_replace( array( 'varchar(', ')' ), '', $row['Type'] ) );
					$fields[ $id ]['length']	= $arr[0];
				}
			}
			
			$this->sess['fields']	= $fields;
		}
		
		if ( isset( $this->sess['fields'][$field] ) === TRUE )
		{
			return $this->sess['fields'][$field];
		}
		else
		{
			return FALSE;
		}
	}
	
	/*	End get field attributes */
	
	// --------------------------------------------------------------------

	/**
	 * Module's Main Homepage
	 
	 * @access	public
	 * @param	string
	 * @return	null
	 */
    
	function home( $message='' )
    {
        global $IN, $DSP, $DB, $LANG, $LOC, $PREFS;
        
        $this->data->set_default_cache_prefs();
					  
		/**	----------------------------------------
		/**	Clear cache?
		/**	----------------------------------------*/
		
		if ( $IN->GBL('msg') == 'cache_cleared' )
		{
			$this->_clear_cache();
		}
        
		/** -------------------------------------
		/**	Prep vars
		/** -------------------------------------*/
        
		$edit_mode							= 'new';
        $this->cached_vars['refresh']		= '0';
        $this->cached_vars['date']			= '';
        $this->cached_vars['next_refresh']	= '&nbsp;';
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$sql	=  "SELECT date, refresh FROM exp_super_search_refresh_rules
					WHERE site_id = '".$DB->escape_str( $PREFS->ini('site_id') )."'
					LIMIT 1";
		
		$query	= $DB->query($sql);
		
		if ( $query->num_rows > 0 )
		{
			$edit_mode	= 'edit';
			$this->cached_vars['refresh']			= $query->row['refresh'];
			$this->cached_vars['date']				= $query->row['date'];
			
			if ( $query->row['refresh'] > 0 )
			{
				$this->cached_vars['next_refresh']		= str_replace( '%n%', $LOC->set_human_time( $query->row['date'] ), $LANG->line('next_refresh') );
			}			
		}		
		
		/** --------------------------------------------
		/**  Template Refresh
		/** --------------------------------------------*/
		
		$attributes = array('class'		=> 'select',
							'name'		=> 'template_id[]',
							'id'		=> 'template_id',
							'multiple'	=> 'multiple',
							'size'		=> 10);
		
		$select = $this->document->createElement('select', $attributes);
		
		foreach($this->data->get_template_groups() AS $group_id => $group_name)
		{
			$optgroup  =& $this->document->createElement('optgroup', array('label' => $group_name));
			
			foreach($this->data->get_templates_by_group_id( $group_id ) AS $value => $text)
			{	
				$option  =& $this->document->createElement('option', array('value' => $value));
				$option->innerHTML = $this->output($text);
				$optgroup->appendChild($option);
				
				if ($edit_mode == 'edit' && in_array( $value, $this->data->get_selected_templates_by_site_id( $PREFS->ini('site_id') ) ) )
				{
					$option->setAttribute('selected', "selected");
				}
			}
			
			$select->appendChild($optgroup);
		}
		
		$this->cached_vars['template_id_field'] = $select;
		 
		/** --------------------------------------------
		/**  Weblog Refresh
		/** --------------------------------------------*/
		
		$attributes = array('class'		=> 'select',
							'name'		=> 'weblog_id[]',
							'id'		=> 'weblog_id',
							'multiple'	=> 'multiple',
							'size'		=> 5);
		
		$select = $this->document->createElement('select', $attributes);
		
		foreach($this->data->get_weblog_titles( $PREFS->ini('site_id') ) AS $value => $text)
		{
			$option  =& $this->document->createElement('option', array('value' => $value));
			$option->innerHTML = $this->output($text);
			
			if ($edit_mode == 'edit' && in_array( $value, $this->data->get_selected_weblogs_by_site_id( $PREFS->ini('site_id') ) ) )
			{
				$option->setAttribute('selected', "selected");
			}
			
			$select->appendChild($option);
		}
		
		$this->cached_vars['weblog_id_field'] = $select;
		
		/** --------------------------------------------
		/**  Category Refresh
		/** --------------------------------------------*/
		
		$attributes = array('class'		=> 'select',
							'name'		=> 'category_group_id[]',
							'id'		=> 'category_group_id',
							'multiple'	=> 'multiple',
							'size'		=> 5);
		
		$select = $this->document->createElement('select', $attributes);
		
		foreach($this->data->get_category_groups() AS $value => $text)
		{
			$option  =& $this->document->createElement('option', array('value' => $value));
			$option->innerHTML = $this->output($text);
			
			if ($edit_mode == 'edit' && in_array( $value, $this->data->get_selected_category_groups_by_site_id( $PREFS->ini('site_id') ) ) )
			{
				$option->setAttribute('selected', "selected");
			}
			
			$select->appendChild($option);
		}
		
		$this->cached_vars['category_group_id_field'] = $select;
        
		/** -------------------------------------
		/**	Title and Crumbs
		/** -------------------------------------*/
		
		$crumb	= $LANG->line( 'manage_caching_rules' );
		
		$this->add_crumb( $crumb );
		
		$this->cached_vars['module_menu_highlight'] = 'module_home';
        
		/** -------------------------------------
		/**	Prep message
		/** -------------------------------------*/
		
		$this->_prep_message( $message );
		
		/** --------------------------------------------
        /**  Load Homepage
        /** --------------------------------------------*/
        
		$this->ee_cp_view('index.html');
	}
	
	/* End home */	
	
	// --------------------------------------------------------------------

	/**
	 * Preferences for This Module
	 
	 * @access	public
	 * @param	string
	 * @return	null
	 */
    
	function preferences($message = '')
    {
        global $IN, $LANG, $PREFS;
        
		/** -------------------------------------
		/**	Default vars
		/** -------------------------------------*/
		
		$this->cached_vars['prefs']	= array(
			'allow_keyword_search_on_relationship_fields'	=> 'n',
			'allow_keyword_search_on_playa_fields'			=> 'n',
		);
        
		/** -------------------------------------
		/**	Set vars
		/** -------------------------------------*/
		
		foreach ( $this->cached_vars['prefs'] as $key => $val )
		{				
			if ( $PREFS->ini( $key ) !== FALSE )
			{
				$this->cached_vars['prefs'][$key]	= $PREFS->ini( $key );
			}
		}
        
		/** -------------------------------------
		/**	Are we updating / inserting?
		/** -------------------------------------*/
		
		if ( $IN->GBL( 'allow_keyword_search_on_relationship_fields', 'POST' ) !== FALSE OR $IN->GBL( 'allow_keyword_search_on_playa_fields', 'POST' ) !== FALSE )
		{
			/** -------------------------------------
			/**	Prep vars
			/** -------------------------------------*/
			
			foreach ( $this->cached_vars['prefs'] as $key => $val )
			{
				if ( $IN->GBL( $key, 'POST' ) !== FALSE )
				{
					$this->cached_vars['prefs'][$key]	= $IN->GBL( $key, 'POST' );
				}
			}
			
			/** -------------------------------------
			/**	Check DB for insert / update
			/** -------------------------------------*/
			
			$message	= '';
			
			if ( $this->data->set_preference( $this->cached_vars['prefs'] ) !== FALSE )
			{
				$message	= $LANG->line( 'preferences_updated' );
			}			
		}
        
		/** -------------------------------------
		/**	Prep message
		/** -------------------------------------*/
		
		$this->_prep_message( $message );
        
		/** -------------------------------------
		/**  Title and Crumbs
		/** -------------------------------------*/
		
		$this->add_crumb($LANG->line('preferences'));
		$this->build_crumbs();
		
		/** --------------------------------------------
        /**  Load Homepage
        /** --------------------------------------------*/
        
		$this->cached_vars['module_menu_highlight'] = 'module_preferences';
		$this->ee_cp_view('preferences.html');
	}
	
	/* END preferences() */
	
	// --------------------------------------------------------------------

	/**
	 * Prep message
	 
	 * @access	private
	 * @param	message
	 * @return	boolean
	 */
	
	function _prep_message( $message = '' )
	{
		global $LANG;
		
        if ( $message == '' AND isset( $_GET['msg'] ) )
        {
        	$message = $LANG->line( $_GET['msg'] );
        }
		
		$this->cached_vars['message']	= $message;
		
		return TRUE;
	}
	
	/*	End prep message */

	// --------------------------------------------------------------------

	/**
	 * Module Installation
	 *
	 * Due to the nature of the 1.x branch of ExpressionEngine, this function is always required.
	 * However, because of the large size of the module the actual code for installing, uninstalling,
	 * and upgrading is located in a separate file to make coding easier
	 *
	 * @access	public
	 * @return	bool
	 */

    function super_search_module_install()
    {
        require_once PATH_MOD.'super_search/upd.super_search.php';
    	
    	$U = new Super_search_updater();
    	return $U->install();
    }
	/* END super_search_module_install() */    
    
	// --------------------------------------------------------------------

	/**
	 * Module Uninstallation
	 *
	 * Due to the nature of the 1.x branch of ExpressionEngine, this function is always required.
	 * However, because of the large size of the module the actual code for installing, uninstalling,
	 * and upgrading is located in a separate file to make coding easier
	 *
	 * @access	public
	 * @return	bool
	 */

    function super_search_module_deinstall()
    {
        require_once PATH_MOD.'super_search/upd.super_search.php';
    	
    	$U = new Super_search_updater();
    	return $U->uninstall();
    }
    /* END super_search_module_deinstall() */


	// --------------------------------------------------------------------

	/**
	 * Module Upgrading
	 *
	 * This function is not required by the 1.x branch of ExpressionEngine by default.  However,
	 * as the install and deinstall ones are, we are just going to keep the habit and include it
	 * anyhow.
	 *		- Originally, the $current variable was going to be passed via parameter, but as there might
	 *		  be a further use for such a variable throughout the module at a later date we made it
	 *		  a class variable.
	 *		
	 *
	 * @access	public
	 * @return	bool
	 */
    
    function super_search_module_update()
    {
    	global $LANG;
    	
    	if ( ! isset($_POST['run_update']) OR $_POST['run_update'] != 'y' )
    	{
    		$this->add_crumb($LANG->line('update_super_search'));
			$this->cached_vars['form_url'] = $this->base.'&msg=update_successful';
			$this->ee_cp_view('update_module.html');
			
			return FALSE;
		}
		
    	require_once PATH_MOD.'super_search/upd.super_search.php';
    	
    	$U = new Super_search_updater();
    	return $U->update();
    }
    /* END super_search_module_update() */

	// --------------------------------------------------------------------
	
}
// END CLASS Super Search