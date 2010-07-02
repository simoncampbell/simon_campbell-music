<?php

/*
================================================================
	Freeform
	for EllisLab ExpressionEngine - by Solspace
----------------------------------------------------------------
	Credits: Mitchell Kimbrough, Chris Ruzin, Paul Burdick
----------------------------------------------------------------
	Copyright (c) 2008 - 2009 Solspace, Inc.
	http://www.solspace.com/
================================================================
	THIS IS COPYRIGHTED SOFTWARE. PLEASE READ THE
	LICENSE AGREEMENT.
	http://www.solspace.com/license/
----------------------------------------------------------------
	This software is based upon and derived from
	Ellislab ExpressionEngine software protected under
	copyright dated 2005 - 2009. Please see
	http://www.expressionengine.com/docs/license.html
----------------------------------------------------------------
	USE THIS SOFTWARE AT YOUR OWN RISK. SOLSPACE ASSUMES
	NO WARRANTY OR LIABILITY FOR THIS SOFTWARE AS DETAILED
	IN THE SOLSPACE LICENSE AGREEMENT.
================================================================
	File:			mcp.freeform.php
----------------------------------------------------------------
	Version:		2.7.2
----------------------------------------------------------------
	Purpose:		Flexible entry form module
----------------------------------------------------------------
	Compatibility:	EE 1.6.7
----------------------------------------------------------------
	Updated:		2009-02-18
================================================================
*/


if ( ! defined('EXT'))
{
    exit('Invalid file request');
}


class Freeform_CP {

    var $version		= '2.7.2';
    var $old_version	= '';
    var $module_name	= 'Freeform';
    var $base			= '';
    var $show_nav		= TRUE;
    
    /**	----------------------------------------
    /**	Constructor
    /**	----------------------------------------*/
    
    function Freeform_CP( $switch = TRUE )
    {
        global $DB, $IN;
        
        $this->base	= 'C=modules'.AMP.'M=Freeform';

		/**	----------------------------------------
		/**	Get old version
		/**	----------------------------------------*/
		
		$query	= $DB->query("SELECT module_version FROM exp_modules WHERE module_name = '".$this->module_name."' LIMIT 1");

		if ( $query->num_rows == 0 )
		{
			$this->old_version	= '0';
		}
		else
		{
			$this->old_version	= $query->row['module_version'];
		}
        
		/**	----------------------------------------
		/**	Execute called function
		/**	----------------------------------------*/
		
        if ($switch)
        {
            switch($IN->GBL('P'))
            {
                case 'documentation'				:  $this->documentation();
                    break;
                case 'manage_entries'				:  $this->manage_entries();
                    break;
                case 'delete_entry_confirm'			:  $this->delete_entry_confirm();
                    break;
                case 'delete_entry'					:  $this->delete_entry();
                    break;
                case 'edit_entry_form'				:  $this->edit_entry_form();
                    break;
                case 'edit_entry'					:  $this->edit_entry();
                    break;
                case 'attachments'					:  $this->attachments();
                    break;
                case 'delete_attachments_confirm'	:  $this->delete_attachments_confirm();
                    break;
                case 'delete_attachments'			:  $this->delete_attachments();
                    break;
                case 'delete_attachment'			:  $this->delete_attachment();
                    break;
                case 'export_entries'				:  $this->export_entries();
                    break;
                case 'manage_fields'				:  $this->manage_fields();
                    break;
                case 'delete_field_confirm'			:  $this->delete_field_confirm();
                    break;
                case 'delete_field'					:  $this->delete_field();
                    break;
                case 'edit_field_form'				:  $this->edit_field_form();
                    break;
                case 'edit_field'					:  $this->edit_field();
                    break;
                case 'field_order_form'				:  $this->field_order_form();
                    break;
                case 'field_order'					:  $this->field_order();
                    break;
                case 'manage_templates'				:  $this->manage_templates();
                    break;
                case 'edit_template_form'			:  $this->edit_template_form();
                    break;
                case 'edit_template'				:  $this->edit_template();
                    break;
                case 'delete_template_confirm'		:  $this->delete_template_confirm();
                    break;
                case 'delete_template'				:  $this->delete_template();
                    break;
                case 'module_upgrade'				:  $this->module_upgrade();
                    break;
                default       						:  $this->home();
                    break;
            }
        }
    }
    
    /**	End */
    

    /**	----------------------------------------
    /**	Content Wrapper
    /**	----------------------------------------
    /*	This is a helper function that builds
    /*	the control panel output. Each function
    /*	that generates a UI will call this
    /*	function.
    /**	----------------------------------------*/

    function content_wrapper($title = '', $crumb = '', $content = '')
    {
        global $DSP, $DB, $IN, $FNS, $LANG, $PREFS, $REGX;
                        		
        $DSP->title  = $title;
        
        $DSP->crumb = $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform', $LANG->line('freeform_module_name'));

		$DSP->crumb	.= $DSP->build_crumb($crumb);
		
		$nav = $this->nav(	array(
									'entries'			=> array('P' => 'manage_entries'),
									'fields'			=> array('P' => 'manage_fields'),
									'templates'			=> array('P' => 'manage_templates'),
									'documentation'		=> 'http://www.solspace.com/docs/c/Freeform',
								)
						);

		if ($nav != '')
		{
			$DSP->body .= $nav;
		}
		
		if ($IN->GBL('msg') == FALSE)
		{
			if ($this->show_nav == TRUE)
				$DSP->body .= $DSP->qdiv('', NBS);
			
			$DSP->body .= $DSP->qdiv('itemWrapper', $content);
		}
		else
		{
			$DSP->body .= $content;
		}
						
    }
    
    /**	End */
    
    
	/**	----------------------------------------
    /**	Navigation Tabs
    /**	----------------------------------------
	/*	Takes an array as input and creates the
	/*	navigation tabs from it. This function
	/*	is called by the one above.
    /**	----------------------------------------*/

    function nav($nav_array)
    {
        global $IN, $DSP, $LANG;
        
        if ($this->show_nav == FALSE)
        {
        	return '';
        }
                
		/**	----------------------------------------
		/**	Build the menus
		/**	----------------------------------------
		/*	Equalize the text length. We do this so
		/*	that the tabs will all be the same length.
		/*	God is in the details, ya know?
		/**	----------------------------------------*/
		
		$temp = array();
		
		foreach ($nav_array as $k => $v)
		{
			$temp[$k] = $LANG->line($k);
		}
		
		$temp = $DSP->equalize_text($temp);

		/**	----------------------------------------*/

        $page = $IN->GBL('P');
        
        $highlight = array(
        					'documentation'					=> 'documentation',
        					'manage_entries'				=> 'entries',
        					'delete_entry_confirm'			=> 'entries',
        					'delete_entry'					=> 'entries',
        					'edit_entry_form'				=> 'entries',
        					'edit_entry'					=> 'entries',
        					'attachments'					=> 'entries',
        					'delete_attachments_confirm'	=> 'entries',
        					'delete_attachments'			=> 'entries',
        					'manage_fields'					=> 'fields',
        					'delete_field_confirm'			=> 'fields',
        					'delete_field'					=> 'fields',
        					'edit_field_form'				=> 'fields',
        					'edit_field'					=> 'fields',
        					'field_order_form'				=> 'fields',
        					'field_order'					=> 'fields',
        					'manage_templates'				=> 'templates',
        					'edit_template_form'			=> 'templates',
        					'edit_template'					=> 'templates',
        					'delete_template_confirm'		=> 'templates',
        					'delete_template'				=> 'templates'
        					);
       

        if (isset($highlight[$page]))
        {
        	$page = $highlight[$page];
        }
        
            
        $r = <<<EOT
        
        <script type="text/javascript"> 
        <!--

		function styleswitch(link)
		{                 
			if (document.getElementById(link).className == 'altTabs')
			{
				document.getElementById(link).className = 'altTabsHover';
			}
		}
	
		function stylereset(link)
		{                 
			if (document.getElementById(link).className == 'altTabsHover')
			{
				document.getElementById(link).className = 'altTabs';
			}
		}
		
		-->
		</script>
		
		
EOT;
    
		$r .= $DSP->table_open(array('width' => '100%'));

		$nav = array();
		
		foreach ($nav_array as $key => $val)
		{
			$url = '';
		
			if (is_array($val))
			{
				$url = BASE.AMP.'C=modules'.AMP.'M=Freeform';		
			
				foreach ($val as $k => $v)
				{
					$url .= AMP.$k.'='.$v;
				}					
			}

			$url = ($url == '') ? $val : $url;

			$div = ((( ! $page) ? 'freeform_home' : $page) == $key) ? 'altTabSelected' : 'altTabs';
			$linko = '<div class="'.$div.'" id="'.$key.'"  onClick="navjump(\''.$url.'\');" onmouseover="styleswitch(\''.$key.'\');" onmouseout="stylereset(\''.$key.'\');">'.$temp[$key].'</div>';
					
			$nav[] = array('text' => $DSP->anchor($url, $linko));
		}

		$r .= $DSP->table_row($nav);		
		$r .= $DSP->table_close();

		return $r;          
    }
    
    /**	End Nav */
    
    
    /**	----------------------------------------
    /**	Top Toolbar in Manager Area
    /**	----------------------------------------*/

	function entries_overview()
	{
		global $IN, $PREFS, $DB, $DSP, $LANG;

		$r = $DSP->table_open(array('class' => 'tableBorder', 'width'	=> '100%'));
				 		
		$r .= $DSP->table_row(array(
									array(
											'text'	=> $LANG->line('form_name'),
											'class'	=> 'tableHeading'
										),
									array(
											'text'	=> $LANG->line('count'),
											'class'	=> 'tableHeading'
										)
									)
							);
							
		// Grab logs
		$query	= $DB->query("SELECT *, COUNT(*) AS count FROM exp_freeform_entries GROUP BY form_name DESC");
		
		If ( $query->num_rows == 0 )
		{			 						 		
			$r .= $DSP->table_row(array(
										array(
												'text'	=> $LANG->line('no_entries'),
												'class'	=> 'tableCellOne',
												'width'	=> '25%',
												'align'	=> 'left',
												'name'	=> 'no_entries',
												'id'	=> 'no_entries',
												'colspan' => 2
											)
										)
								);
		}
		else
		{
			foreach ( $query->result as $row )
			{				
				$r .= $DSP->table_row(array(
											array(
													'text'	=> $DSP->anchor(BASE.AMP.$this->base.AMP.'P=manage_entries&form_name='.$row['form_name'], $row['form_name']),
													'class'	=> 'tableCellOne',
													'width'	=> '25%',
													'align'	=> 'left'
												),
											array(
													'text'	=> $row['count'],
													'class'	=>  'tableCellOne',
													'width'	=> '25%',
													'align'	=> 'left'
												)
											)
									);
			}
		}
				              
		$r .= $DSP->table_close();
		
		$r .= $DSP->qdiv('', NBS);
		
		return $r;
	}
	
	/**	End manager toolbar */


    /**	----------------------------------------
    /**	Upgrade check
    /**	----------------------------------------
    /*	We need to make sure that our version is
    /*	current, if not, prompt upgrade.
    /**	----------------------------------------*/
	
	function upgrade_check($upgraded = FALSE)
	{
		global $DSP, $IN, $LANG;
		
		$r		= "";
		
		$link	= ' <a href="'.BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=module_upgrade'.AMP.'msg=upgrade_successful">Upgrade now</a>';
		
		$msg	= $DSP->qdiv(
							'itemWrapperTop',
							$DSP->qdiv(
										'successBox',
										$DSP->qdiv(
													'success',
													$LANG->line('upgrade_message').$link
													)
										)
							);
		

		/**	----------------------------------------
		/**	Do we need to upgrade?
		/**	----------------------------------------*/

		if ( $this->old_version < $this->version AND ! $upgraded )
		{
			$r = $msg;
		}
	
		return $r;
	}
	
	/**	End upgrade check */
	


    /**	----------------------------------------
    /**	Header and Message Handler
    /**	----------------------------------------
    /*	The content wrapper function above
    /*	automatically positions the page heading
    /*	on the top right-hand side, and any
    /*	"success" messages on the left side.
    /*	This function lets us override that
    /*	behavior in case we want to show
    /*	something else on the left side of the
    /*	page.  We use this in two or three
    /*	instances.
    /**	----------------------------------------*/
	
	function header_and_msg($msg = '')
	{
		global $IN, $DSP, $LANG;
		
		$r	= '';
		
		if ($msg == '' AND $IN->GBL('msg') == FALSE)
		{
			return '';
		}
        
		/**	----------------------------------------
		/**	Page Header and Message Handler
		/**	----------------------------------------*/  
        
        if ($msg != '')
        {
			$r .= $DSP->qdiv('successBox', $DSP->qdiv('success', $msg));
        }
	
		return $r;
	}
	
	/**	End header and message handler */

    
    /**	----------------------------------------
    /**	Home
    /**	----------------------------------------*/
    
    function home( $message = '', $upgraded = FALSE )
    {
    	global $DB, $DSP, $LANG, $LOC;
    	
        $r  = $this->header_and_msg($message);
    	
		$title	= $LANG->line('home');
	
		$crumb	= array(
						$title => ''
					  );
					  
		$r	.= $this->upgrade_check($upgraded);
    	
        $r  .= $this->entries_overview();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
    }

    
	/**	----------------------------------------
    /**	Freeform Header
    /**	----------------------------------------*/
    
    function head()
    {
        global $DSP, $LANG;
                        
        $DSP->title = $LANG->line('freeform');
        $DSP->crumb = $LANG->line('freeform');          

        $DSP->body .= $DSP->heading($LANG->line('freeform'));
    }
    
	/**	End */
    
    
	/**	----------------------------------------
    /**	Documentation Page
	/**	----------------------------------------*/
	
    function documentation($message='')
    {
        global $DSP, $LANG;
    	
        $r  = $this->header_and_msg();
    	
		$title	= $LANG->line('documentation');
	
		$crumb	= array(
						$title => ''
					  );
        
		/**	----------------------------------------
		/**	Documentation Matrix
		/**	----------------------------------------*/
		
        $r		= $LANG->line('docs_link');
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
    }    
    // END
    
    
	/**	----------------------------------------
    /**	Manage entries
	/**	----------------------------------------*/
    
    function manage_entries($message = '')
    {
        global $IN, $DSP, $DB, $LANG, $LOC;
                
        $row_limit		= 100;
        $paginate		= '';
        $row_count		= 0;
        
        $form_name		= ( $IN->GBL('form_name') ) ? AMP.'form_name='.$IN->GBL('form_name'): '';
        
        $status			= ( $IN->GBL('status') ) ? AMP.'status='.$IN->GBL('status'): '';
        
        $show_empties	= ( $IN->GBL('show_empties') ) ? AMP.'show_empties='.$IN->GBL('show_empties'): '';
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/
                        
        $title	= $LANG->line('manage_entries');

		$crumb	= $LANG->line('manage_entries');
		
        $r		= $this->header_and_msg($message);
        
		$r		.= $DSP->right_crumb( $LANG->line('export'), BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=export_entries'.AMP.'type=txt'.$form_name.$status.$show_empties );

        $r		.= $DSP->qdiv('tableHeading', $LANG->line('manage_entries'));
    	
		/**	----------------------------------------
		/**	Start filter form
		/**	----------------------------------------*/
        
        $form_url	= $this->base.AMP.'P=manage_entries';
        
        $r			.= $DSP->form_open(array('action' => $form_url, 'name' => 'search', 'id' => 'search'));

		/**	----------------------------------------
		/**	Form content
		/**	----------------------------------------*/

		//	Filter by
		$content	= $LANG->line('filter_by');
		
		$content	.= $DSP->input_select_header('form_name');
		
		$content	.= $DSP->input_select_option( '', $LANG->line('form_name'), '' );
		
		$content	.= $DSP->input_select_option( '', $LANG->line('all_entries'), '' );
		
		$forms		= $DB->query("SELECT DISTINCT form_name FROM exp_freeform_entries ORDER BY form_name ASC");

		if ( $forms->num_rows > 0 )
		{
			foreach ( $forms->result as $row )
			{
				$selected	= ( $row['form_name'] == $IN->GBL('form_name') ) ? 'selected': '';
				
				$content	.= $DSP->input_select_option( $row['form_name'], $row['form_name'], $selected );
			}
		}
		
		$content		.= $DSP->input_select_footer();

		//	Status
		$content		.= $LANG->line('status').":";
		
		$content		.= $DSP->input_select_header('status');
		
		$content		.= $DSP->input_select_option( '', $LANG->line('status'), '' );
		
		$open			= ( $IN->GBL('status') == 'open' ) ? 'selected': '';
		
		$closed			= ( $IN->GBL('status') == 'closed' ) ? 'selected': '';
		
		$content		.= $DSP->input_select_option( 'open', $LANG->line('open'), $open );
		
		$content		.= $DSP->input_select_option( 'closed', $LANG->line('closed'), $closed );		
		
		$content		.= $DSP->input_select_footer();
		
		$checked_y		= ( $IN->GBL('show_empties') == 'yes' ) ? 1: 0;
		
		$checked_n		= ( $IN->GBL('show_empties') != 'yes' ) ? 1: 0;
		
		$content		.= $LANG->line('show_empties');
		
		$content		.= $DSP->input_radio( 'show_empties', 'yes', $checked_y );
		
		$content		.= $LANG->line('yes');
		
		$content		.= $DSP->input_radio( 'show_empties', 'no', $checked_n );
		
		$content		.= $LANG->line('no');
		
		$content		.= $DSP->input_submit( $LANG->line('search') );

		$r				.= $DSP->qdiv('itemWrapper', $content);

		$r				.= $DSP->form_close();
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$sql	= "FROM exp_freeform_entries WHERE entry_id != '' ";
		
		if ( $IN->GBL('form_name') != '' )
		{
			$sql	.= "AND form_name = '".$IN->GBL('form_name')."' ";
		}
		
		if ( $IN->GBL('status') != '' )
		{
			$sql	.= "AND status = '".$IN->GBL('status')."' ";
		}
		
		$cquery	= $DB->query("SELECT COUNT(*) AS count ".$sql);
		
		if ( $cquery->row['count'] == 0 )
		{
			$r	.=	$DSP->qdiv('tableCellOne', $DSP->qdiv('highlight', $LANG->line('no_entries')));
				
			/**	----------------------------------------
			/**	Return the finalized output
			/**	----------------------------------------*/ 
			
			return $this->content_wrapper($title, $crumb, $r);
		}
		
		$sql  = "SELECT * ".$sql;
		$sql .= "ORDER BY entry_date DESC";
		
		/** --------------------------------------------
        /**  Pagination
        /** --------------------------------------------*/
		
		if ( $cquery->row['count'] > $row_limit )
		{
			$row_count		= ( ! $IN->GBL('row')) ? 0 : $IN->GBL('row');
						
			$url			= BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=manage_entries';
			
			if ( $IN->GBL('form_name') )
			{
				$url		.= AMP.'form_name='.$IN->GBL('form_name');
			}
			
			$paginate		= $DSP->pager(
											$url,
											$cquery->row['count'], 
											$row_limit,
											$row_count,
											'row'
										);
		}

		$sql .= " LIMIT ".$row_count.", ".$row_limit;
		$query = $DB->query($sql);
					  
		/**	----------------------------------------
		/**	Attachments
		/**	----------------------------------------*/
		
		$attachments_q	= $DB->query( "SELECT entry_id FROM exp_freeform_attachments" );
		
		$attachments	= array();
		
		foreach ( $attachments_q->result as $row )
		{
			$attachments[]	= $row['entry_id'];
		}
					  
		/**	----------------------------------------
		/**	Determine empties
		/**	----------------------------------------*/
		
		if ( $IN->GBL('show_empties') != 'yes' )
		{
			foreach ( $query->result as $row )
			{
				foreach ( $row as $key => $val )
				{
					if ( $val != '' )
					{
						$filled[$key]	= $val;
					}
				}
			}
		}
    
        $r					.=	$DSP->toggle();
        
        $DSP->body_props	.= ' onload="magic_check()" ';
        
        $r					.= $DSP->magic_checkboxes();
        
        $form_url			= 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_entry_confirm';
        
        $r					.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r					.= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));

		/**	----------------------------------------
		/**	Create header
		/**	----------------------------------------*/
		
		$fields	= $DB->query("SELECT name, label FROM exp_freeform_fields ORDER BY field_order ASC");
		
		$top[]	= array(
						'text'	=> $LANG->line('count'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '2%'
					);
		
		$top[]	= array(
						'text'	=> $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"").NBS.NBS.$LANG->line('delete'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '10%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('edit'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '3%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('attachments'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '5%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('status'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '3%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('date'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '5%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('form_name'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '5%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('template'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '5%'
					);
		
		if ( $fields->num_rows > 0 )
		{
			foreach ( $fields->result as $field )
			{
				if ( $IN->GBL('show_empties') == 'yes' OR isset( $filled[ $field['name'] ] ) )
				{
					$top[]	= array(
									'text'	=> $field['label'],
									'class'	=> 'tableHeadingAlt'
								);
				}
			}
		}

		$r		.= $DSP->table_row( $top );
		
		$row_count++;
		
		$i = 0;
		
		foreach ( $query->result as $row )
		{
			unset($rows);
			
			$rows[]		= $row_count;
			
			$rows[]		= $DSP->input_checkbox('toggle[]', $row['entry_id'], '', "id='delete_box_".$row['entry_id']."'");

			$show_empties	= ( $IN->GBL('show_empties') != 'yes' ) ? "&show_empties=no": "&show_empties=yes";
			
			$rows[]		= $DSP->anchor( BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_entry_form'.AMP.'entry_id='.$row['entry_id'].$show_empties, $LANG->line('edit') );
			
			if ( in_array( $row['entry_id'], $attachments ) )
			{
				$rows[]		= $DSP->anchor( BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=attachments'.AMP.'entry_id='.$row['entry_id'].$show_empties, $LANG->line('attachments') );
			}
			else
			{
				$rows[]		= $LANG->line('attachments');
			}				
			
			$rows[]		= ucfirst( $row['status'] );
			
			$rows[]		= "<nobr>".$LOC->set_human_time( $row['entry_date'] )."</nobr>";
			
			$rows[]		= $row['form_name'];
			
			$rows[]		= $row['template'];
		
			if ( $fields->num_rows > 0 )
			{
				foreach ( $fields->result as $field )
				{
					if ( $IN->GBL('show_empties') == 'yes' OR isset( $filled[ $field['name'] ] ) )
					{
						$rows[]	= $row[ $field['name'] ];
					}
				}
			}
			
			$r			 .= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $rows);
			$row_count++;
		}
		
		
		$foot[] = NBS;
		
		$foot[] = "<nobr>".$DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"").NBS.NBS.'<b>'.$LANG->line('delete').'</b></nobr>';

		$foot[] = NBS;

		$foot[] = NBS;

		$foot[] = NBS;

		$foot[] = NBS;

		$foot[] = NBS;

		$foot[] = NBS;
		
		if ( $fields->num_rows > 0 )
		{
			foreach ( $fields->result as $field )
			{
				if ( $IN->GBL('show_empties') == 'yes' OR isset( $filled[ $field['name'] ] ) )
				{
					$foot[] = NBS;
				}
			}
		}
				
		$r		.= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $foot);

        $r		.=	$DSP->table_c(); 

    	if ($paginate != '')
    	{
    		$r .= $DSP->qdiv('itemWrapper', $paginate.BR.BR);
    	}
    	
		$r		.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit($LANG->line('delete')));             
        
        $r		.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/ 
		
		return $this->content_wrapper($title, $crumb, $r);
	}
	
    /**	End entries */
  
    
    /**	----------------------------------------
    /**	Delete entry - confirm
    /**	----------------------------------------*/    

    function delete_entry_confirm()
    {
        global $IN, $DSP, $LANG;
        
        if ( ! $IN->GBL('toggle', 'POST'))
        { 
            return $this->manage_entries();
        }
        
        $title	= $LANG->line('entry_delete_confirm');
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform', $LANG->line('manage_entries'));

		$crumb	.= $DSP->crumb_item($LANG->line('entry_delete_confirm'));

        $r		= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_entry'));
        
        $i		= 0;
        
        foreach ( $_POST as $key => $val )
        {        
            if ( strstr( $key, 'toggle' ) AND ! is_array( $val ) AND is_numeric( $val ) )
            {
                $r	.=	$DSP->input_hidden('delete[]', $val);
                
                $i++;
            }        
        }
        
		$r		.= $DSP->qdiv('alertHeading', $LANG->line('entry_delete_confirm'));
		
		$r		.= $DSP->div('box');
		
		if ( $i == 1 )
		{
			$replace[]	= $i; $replace[]	= 'entry';
		}
		else
		{
			$replace[]	= $i; $replace[]	= 'entries';
		}
		
		$search	= array( '%i%', '%entry%' );
		
		$r		.= $DSP->qdiv('defaultBold', str_replace( $search, $replace, $LANG->line('entry_delete_question') ) );
		
		$r		.= $DSP->qdiv('alert', BR.$LANG->line('action_can_not_be_undone'));
		
		$r		.= $DSP->qdiv('', BR.$DSP->input_submit($LANG->line('delete')));
		
		$r		.= $DSP->qdiv('alert',$DSP->div_c());
		
		$r		.= $DSP->div_c();
		
		$r		.= $DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
    }
    
    /**	End delete entry confirm */
  
    
    /**	----------------------------------------
    /**	Delete entry
    /**	----------------------------------------*/    

    function delete_entry()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;        
        
        if ( ! $IN->GBL('delete', 'POST'))
        {
            return $this->home();
        }

        $ids	= array();
                
        foreach ($_POST as $key => $val)
        {        
            if (strstr($key, 'delete') AND ! is_array($val) AND is_numeric($val))
            {
                $ids[] = $val;
            }        
        }
        
		/**	----------------------------------------
		/**	Get files
		/**	----------------------------------------*/
		
		$filesq	= $DB->query( "SELECT * FROM exp_freeform_attachments WHERE entry_id IN ('".implode( "','", $ids )."')" );
		
		$files	= array();
		
		if ( $filesq->num_rows > 0 )
		{
			foreach ( $filesq->result as $row )
			{
				$files[ $row['entry_id'] ][]	= $row;
			}
		}
        
		/**	----------------------------------------
		/**	Delete loop
		/**	----------------------------------------*/
        
        foreach ( $ids as $id )
        {
			$DB->query("DELETE FROM exp_freeform_entries WHERE entry_id = '".$id."'");
			$DB->query("DELETE FROM exp_freeform_attachments WHERE entry_id = '".$id."'");
			
			/**	----------------------------------------
			/**	Delete files
			/**	----------------------------------------*/
			
			if ( isset( $files[ $id ] ) )
			{
				foreach ( $files[ $id ] as $row )
				{
					@unlink( $row['server_path'].$row['filename'].$row['extension'] );
				}
			}
        }
    
        $message = (count($ids) == 1) ? str_replace( '%i%', count($ids), $LANG->line('entry_deleted') ) : str_replace( '%i%', count($ids), $LANG->line('entries_deleted') );

        return $this->manage_entries($message);
    }
    
    /**	End delete entry */
    
    
    /**	----------------------------------------
    /**	Edit entry form
    /**	----------------------------------------*/
    
    function edit_entry_form()
    {
        global $IN, $DSP, $DB, $LANG, $LOC;
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/
                        
        $title	= $LANG->line('edit_entry');
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=manage_entries', $LANG->line('manage_entries'));

		$crumb	.= $DSP->crumb_item($LANG->line('edit_entry'));
		
        $r		= $this->header_and_msg();
					  
		/**	----------------------------------------
		/**	Main query
		/**	----------------------------------------*/
		
		if ( $IN->GBL('entry_id') )
		{
			$sql	= "SELECT * FROM exp_freeform_entries WHERE entry_id = '".$IN->GBL('entry_id')."' LIMIT 1";
			
			$query	= $DB->query($sql);
		}
		else
		{
			return $DSP->error_message($LANG->line('entry_not_found'));
		}
					  
		/**	----------------------------------------
		/**	Group query
		/**	----------------------------------------*/
					
		$group			= $DB->query("SELECT group_title FROM exp_member_groups WHERE group_id = '".$query->row['group_id']."'");

		$group_title	= $group->row['group_title'];
					  
		/**	----------------------------------------
		/**	Author query
		/**	----------------------------------------*/
		
		if ( $query->row['author_id'] != '0' )
		{					
			$author			= $DB->query("SELECT screen_name FROM exp_members WHERE member_id = '".$query->row['author_id']."'");
	
			$screen_name	= $author->row['screen_name'];
		}
		else
		{
			$screen_name	= $LANG->line('guest');
		}
					  
		/**	----------------------------------------
		/**	Fields query
		/**	----------------------------------------*/
		
		$fields_q			= $DB->query("SELECT * FROM exp_freeform_fields ORDER BY field_order");
		
		if ( $fields_q->num_rows > 0 )
		{
			foreach ( $fields_q->result as $row )
			{
				$fields[ $row['name'] ]['label']	= $row['label'];
				$fields[ $row['name'] ]['type']		= $row['field_type'];
				$fields[ $row['name'] ]['length']	= $row['field_length'];
			}
		}
		else
		{
			$fields	= array();
		}
		
		/**	----------------------------------------
		/**	Start table
		/**	----------------------------------------*/

        $r		.= $DSP->qdiv('tableHeading', $LANG->line('edit_entry'));
				
		/**	----------------------------------------
		/**	Start form
		/**	----------------------------------------*/
        
        $form_url	= 'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_entry';
        
        $r			.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r			.=	$DSP->input_hidden('entry_id', $query->row['entry_id'], '', '', 'input', '');

        $r			.=	$DSP->table('tableBorder', '0', '0', '100%').
						$DSP->tr().
						$DSP->table_qcell('tableHeadingAlt', array($LANG->line('field'), $LANG->line('value'))).
						$DSP->tr_c();
		
		$style		='tableCellOne';
		
		/**	----------------------------------------
		/**	Start entry id
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('entry_id')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('', $query->row['entry_id']), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start group title
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('group_title')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('', $group_title), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start screen name
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('screen_name')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('', $screen_name), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start IP address
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('ip_address')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('', $query->row['ip_address']), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start entry date
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('entry_date')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('', $LOC->set_human_time( $query->row['entry_date'] )), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start edit date
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('edit_date')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('', $LOC->set_human_time( $query->row['edit_date'] )), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start status
		/**	----------------------------------------*/
		
		$status_field	= $DSP->input_select_header('status');
		
		$open			= ( $query->row['status'] == 'open' ) ? 'selected': '';
		
		$closed			= ( $query->row['status'] == 'closed' ) ? 'selected': '';
		
		$status_field	.= $DSP->input_select_option( 'open', $LANG->line('open'), $open );
		
		$status_field	.= $DSP->input_select_option( 'closed', $LANG->line('closed'), $closed );
		
		$status_field	.= $DSP->input_select_footer();
				  
		$r				.= $DSP->tr();
		
		$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('status')), '30%');
			
		$r				.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $status_field )), '70%');

		$r				.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start fields
		/**	----------------------------------------*/
		
		$filled	= array();
		
		if ( $IN->GBL('show_empties') != 'yes' )
		{
			$sql	= "SELECT * FROM exp_freeform_entries WHERE status = 'open'";
			
			if ( isset( $query->row['form_name'] ) AND $query->row['form_name'] != '' )
			{
				$sql	.= " AND form_name = '".$query->row['form_name']."'";
			}
			
			$sub	= $DB->query( $sql );
			
			foreach ( $sub->result as $s )
			{
				foreach ( $s as $k => $v )
				{
					if ( $v != '' )
					{
						$filled[$k]	= $v;
					}
				}
			}
		}
		
		foreach ( $fields as $key => $val )
		{
			if (  $IN->GBL('show_empties') != 'yes' )
			{
				if ( isset( $filled[ $key ] ) )
				{
					$r			.= $DSP->tr();
					
					$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $val['label']), '30%');
		
					if ( $fields[$key]['type'] == 'text' )
					{
						$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text($key, $query->row[ $key ], '35', $fields[$key]['length'], 'input', '75%'))), '70%');
					}
					else
					{
						$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea($key, $query->row[ $key ], '6', 'textarea', '75%', '', TRUE))), '70%');
					}			
			
					$r			.= $DSP->tr_c();
				}
			}
			else
			{
				$r			.= $DSP->tr();
				
				$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $val['label']), '30%');
	
				if ( $fields[$key]['type'] == 'text' )
				{
					$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text($key, $query->row[ $key ], '35', $fields[$key]['length'], 'input', '75%'))), '70%');
				}
				else
				{
					$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea($key, $query->row[ $key ], '6', 'textarea', '75%', '', TRUE))), '70%');
				}			
		
				$r			.= $DSP->tr_c();
			}
		}
		
		/**	----------------------------------------
		/**	End table
		/**	----------------------------------------*/
		
        $r			.=	$DSP->table_c();
    	
		$r			.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit( $LANG->line('update') ));             
        
        $r			.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
	}

    /**	End edit field form */
  
    
    /**	----------------------------------------
    /**	Edit entry
    /**	----------------------------------------*/    

    function edit_entry()
    {
        global $DB, $IN, $LANG, $LOC;
        
		/**	----------------------------------------
		/**	Filter
		/**	----------------------------------------*/
		
		$_POST['edit_date']	= $LOC->now;
		
		unset( $_POST['submit'] );
        
		/**	----------------------------------------
		/**	Update
		/**	----------------------------------------*/
					
		$DB->query( $DB->update_string('exp_freeform_entries', $_POST, 'entry_id='.$IN->GBL('entry_id')) );

		$message	= $LANG->line('entry_updated');

        return $this->manage_entries($message);
    }
    
    /**	End edit entry */
    
    
	/**	----------------------------------------
    /**	Attachments
	/**	----------------------------------------*/
    
    function attachments()
    {
        global $IN, $DSP, $DB, $LANG, $LOC;
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/
		
		$row_count	= 0;
                        
        $title	= $LANG->line('attachments');
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=manage_entries', $LANG->line('manage_entries'));

		$crumb	.= $DSP->crumb_item($LANG->line('attachments'));
		
        $r		= $this->header_and_msg();
					  
		/**	----------------------------------------
		/**	Main query
		/**	----------------------------------------*/
		
		if ( $IN->GBL('entry_id') )
		{
			$sql	= "SELECT * FROM exp_freeform_attachments WHERE entry_id = '".$IN->GBL('entry_id')."'";
			
			$query	= $DB->query($sql);
		}
		else
		{
			return $DSP->error_message($LANG->line('entry_not_found'));
		}
					  
		/**	----------------------------------------
		/**	Prefs query
		/**	----------------------------------------*/
		
		$prefs			= $DB->query( "SELECT p.* FROM exp_upload_prefs p LEFT JOIN exp_freeform_attachments a ON p.id = a.pref_id WHERE a.entry_id = '".$IN->GBL('entry_id')."'" );
		
		$pref_id	= '';
		
		if ( $prefs->num_rows > 0 )
		{
			$this->upload	= $prefs->row;
			$pref_id		= $prefs->row['id'];
		}
		
		/**	----------------------------------------
		/**	Start table
		/**	----------------------------------------*/

        $r		.= $DSP->qdiv('tableHeading', $LANG->line('attachments'));
    
        $r					.=	$DSP->toggle();
        
        $DSP->body_props	.= ' onload="magic_check()" ';
        
        $r					.= $DSP->magic_checkboxes();
        
        $form_url			= 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_attachments_confirm';
        
        $r					.= $DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));
        
        $r					.= $DSP->input_hidden( 'pref_id', $pref_id );

		$r					.= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));
		
		$top[] = array(
						'text'	=> NBS,
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '3%'
					);
		
		$top[]	= array(
						'text'	=> $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"").NBS.NBS.$LANG->line('delete'),
						'class'	=> 'tableHeadingAlt',
						'width'	=> '15%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('filename'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '15%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('filesize'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '5%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('date'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '20%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('emailed'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '47%'
					);

		$r		.= $DSP->table_row( $top );
		
		$row_count++;
		
		$i = 0;
		
		foreach ( $query->result as $row )
		{
			unset($rows);
			
			$rows[]		= $row_count;
			
			$rows[]		= $DSP->input_checkbox('toggle[]', $row['attachment_id'], '', "id='delete_box_".$row['attachment_id']."'");
			
			if ( count( $this->upload ) > 0 )
			{
				$rows[]		= $DSP->anchor( $this->upload['url'].$row['filename'].$row['extension'], $row['filename'].$row['extension'] );
			}
			else
			{
				$rows[]	= $row['filename'].$row['extension'];
			}
			
			$rows[]		= ceil($row['filesize'] / 1024)."KB";
			
			$rows[]		= $LOC->set_human_time( $row['entry_date'] );
			
			$rows[]		= $LANG->line( $row['emailed'] );
			
			$r			 .= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $rows);
			
			$row_count++;
		}
		
		
		$foot[] = NBS;
		
		$foot[] = $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"").NBS.NBS.'<b>'.$LANG->line('delete').'</b>';

		$foot[] = NBS;

		$foot[] = NBS;

		$foot[] = NBS;

		$foot[] = NBS;
				
		$r		.= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $foot);

        $r		.=	$DSP->table_c();
    	
		$r		.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit($LANG->line('delete')));             
        
        $r		.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
	}
	
    /**	End attachments */
  
    
    /**	----------------------------------------
    /**	Delete Attachments - Confirm
    /**	----------------------------------------*/    

    function delete_attachments_confirm()
    {
        global $IN, $DSP, $LANG;
        
        if ( ! $IN->GBL('toggle', 'POST'))
        { 
            return $this->manage_entries();
        }
        
        $title	= $LANG->line('attachment_delete_confirm');
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform', $LANG->line('manage_entries'));

		$crumb	.= $DSP->crumb_item($LANG->line('attachment_delete_confirm'));

        $r		= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_attachments'));
        
        $i		= 0;
        
        foreach ( $_POST as $key => $val )
        {        
            if ( strstr( $key, 'toggle' ) AND ! is_array( $val ) AND is_numeric( $val ) )
            {
                $r	.=	$DSP->input_hidden('delete[]', $val);
                
                $i++;
            }        
        }
        
		$r		.= $DSP->qdiv('alertHeading', $LANG->line('attachment_delete_confirm'));
		
		$r		.= $DSP->div('box');
		
		if ( $i == 1 )
		{
			$replace[]	= $i; $replace[]	= 'attachment';
		}
		else
		{
			$replace[]	= $i; $replace[]	= 'attachments';
		}
		
		$search	= array( '%i%', '%attachments%' );
		
		$r		.= $DSP->qdiv('defaultBold', str_replace( $search, $replace, $LANG->line('attachment_delete_question') ) );
		
		$r		.= $DSP->qdiv('alert', BR.$LANG->line('action_can_not_be_undone'));
		
		$r		.= $DSP->qdiv('', BR.$DSP->input_submit($LANG->line('delete')));
		
		$r		.= $DSP->qdiv('alert',$DSP->div_c());
		
		$r		.= $DSP->div_c();
		
		$r		.= $DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
    }
    
    /**	End delete attachments confirm */
  
    
    /**	----------------------------------------
    /**	Delete Attachments
    /**	----------------------------------------*/    

    function delete_attachments()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;        
        
        if ( ! $IN->GBL('delete', 'POST'))
        {
            return $this->manage_entries();
        }

        $ids	= array();
                
        foreach ($_POST as $key => $val)
        {        
            if (strstr($key, 'delete') AND ! is_array($val) AND is_numeric($val))
            {
                $ids[] = "attachment_id = '".$val."'";
            }        
        }
        
        $IDS	= implode(" OR ", $ids);
        
        $query	= $DB->query("SELECT attachment_id, server_path, filename, extension FROM exp_freeform_attachments WHERE ".$IDS);
        
        foreach ( $query->result as $row )
        {
			$DB->query("DELETE FROM exp_freeform_attachments WHERE attachment_id = '".$row['attachment_id']."'");
			
			@unlink( $row['server_path'].$row['filename'].$row['extension'] );
        }
    
        $message = ($query->num_rows == 1) ? str_replace( '%i%', $query->num_rows, $LANG->line('attachment_deleted') ) : str_replace( '%i%', $query->num_rows, $LANG->line('attachments_deleted') );

        return $this->manage_entries($message);
    }
    
    /**	End delete attachments */
    
    
    /**	----------------------------------------
    /**	Export entries
    /**	----------------------------------------*/  
    
    function export_entries($message = '')
    {
    	global $DB, $DSP, $IN, $LANG, $LOC;
    	
    	$row_count	= 0;
    	
        /**	----------------------------------------
        /**	Build the output header
        /**	----------------------------------------*/
        
        ob_start();
        
		// Assign the name of the file
		
		$now		= $LOC->set_localized_time();
		
		$name		= ( $IN->GBL('form_name') ) ? $IN->GBL('form_name'): 'Freeform_Export';
		
		$filename	= str_replace(" ","_",$name).'_'.date('Y', $now).date('m', $now).date('d', $now)."_".date('G', $now)."-".date('i', $now);
        
		// Determine file type
		
		switch ( $IN->GBL('type') )
		{
			case 'zip' :
			
						if ( ! @function_exists('gzcompress')) 
						{
							return $DSP->error_message($LANG->line('unsupported_compression'));
						}
			
						$ext  = 'txt.zip';
						$mime = 'application/x-zip';
								
				break;
			case 'gzip' :
			
						if ( ! @function_exists('gzencode')) 
						{
							return $DSP->error_message($LANG->line('unsupported_compression'));
						}
			
						$ext  = 'txt.gz';
						$mime = 'application/x-gzip';
				break;
			default     :
			
						$ext = 'txt';
						
						if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE") || strstr($_SERVER['HTTP_USER_AGENT'], "OPERA")) 
						{
							$mime = 'application/octetstream';
						}
						else
						{
							$mime = 'application/octet-stream';
						}
			
				break;
		}
		
		if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
		{
			header('Content-Type: '.$mime);
			header('Content-Disposition: inline; filename="'.$filename.'.'.$ext.'"');
			header('Expires: 0');
			header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
			header('Pragma: public');
		} 
		else 
		{
			header('Content-Type: '.$mime);
			header('Content-Disposition: attachment; filename="'.$filename.'.'.$ext.'"');
			header('Expires: 0');
			header('Pragma: no-cache');
		}
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$sql	= "SELECT * FROM exp_freeform_entries WHERE entry_id != ''";
		
		if ( $IN->GBL('form_name') != '' )
		{
			$sql	.= " AND form_name = '".$IN->GBL('form_name')."'";
		}
		
		if ( $IN->GBL('status') != '' )
		{
			$sql	.= " AND status = '".$IN->GBL('status')."'";
		}
		
		$sql	.= " ORDER BY entry_date ASC";
		
		$query	= $DB->query($sql);
		
		if ( $query->num_rows == 0 )
		{
			echo $LANG->line('no_entries');
		}
					  
		/**	----------------------------------------
		/**	Determine empties
		/**	----------------------------------------*/
		
		if ( $IN->GBL('show_empties') != 'yes' )
		{
			foreach ( $query->result as $row )
			{
				foreach ( $row as $key => $val )
				{
					if ( $val != '' )
					{
						$filled[$key]	= $val;
					}
				}
			}
		}

		/**	----------------------------------------
		/**	Create header
		/**	----------------------------------------*/
		
		$fields	= $DB->query("SELECT name, label FROM exp_freeform_fields ORDER BY field_order ASC");

		echo $LANG->line('count')."\t";
		
		echo $LANG->line('status')."\t";
		
		echo $LANG->line('date')."\t";
		
		echo $LANG->line('form_name')."\t";
		
		if ( $fields->num_rows > 0 )
		{
			foreach ( $fields->result as $field )
			{
				if ( $IN->GBL('show_empties') == 'yes' OR isset( $filled[ $field['name'] ] ) )
				{
					echo $field['label']."\t";
				}
			}
		}
		
		/**	----------------------------------------
		/**	Create body         
		/**	----------------------------------------*/
		
		foreach ( $query->result as $row )
		{			
			echo "\n";
			
			echo $row_count."\t";
			
			echo ucfirst( $row['status'] )."\t";
			
			echo $LOC->set_human_time( $row['entry_date'] )."\t";
			
			echo $row['form_name']."\t";
		
			if ( $fields->num_rows > 0 )
			{
				foreach ( $fields->result as $field )
				{
					if ( $IN->GBL('show_empties') == 'yes' OR isset( $filled[ $field['name'] ] ) )
					{
						echo $row[ $field['name'] ]."\t";
					}
				}
			}
			
			$row_count++;
		}
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
        $buffer = ob_get_contents();
        
        ob_end_clean();
        
        echo $buffer;
        
        exit;
	}

	/**	End export entries */
	
    
    /**	----------------------------------------
    /**	Field list
    /**	----------------------------------------*/
    
    function manage_fields($message = '')
    {
        global $IN, $DSP, $DB, $LANG;
                
        $row_limit		= 50;
        $paginate		= '';
        $row_count		= 0;
    	
    	$exclude_fields	= array();
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/    	
                        
        $title	= $LANG->line('manage_fields');

		$crumb	= $LANG->line('manage_fields');
		
        $r		= $this->header_and_msg($message);
        
		$r		.= $DSP->right_crumb($LANG->line('create_new_field'), BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_field_form');

        $r		.= $DSP->qdiv('tableHeading', $LANG->line('manage_fields'));        
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$sql	= "SELECT * FROM exp_freeform_fields ORDER BY field_order ASC";
		
		$query	= $DB->query($sql);
		
		if ( $query->num_rows == 0 )
		{
			$r	.=	$DSP->qdiv('tableCellOne', $DSP->qdiv('highlight', $LANG->line('no_fields')));
				
			/**	----------------------------------------
			/**	Return the finalized output
			/**	----------------------------------------*/ 
			
			return $this->content_wrapper($title, $crumb, $r);
		}		
    
		if ( $query->num_rows > $row_limit )
		{
			$row_count		= ( ! $IN->GBL('row')) ? 0 : $IN->GBL('row');
						
			$url			= BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=manage_fields';
			
			$paginate		= $DSP->pager(
											$url,
											$query->num_rows, 
											$row_limit,
											$row_count,
											'row'
										);
			 
			$sql			.= " LIMIT ".$row_count.", ".$row_limit;
			
			$query			= $DB->query($sql);    
		}
    
        $r					.=	$DSP->toggle();
        
        $DSP->body_props	.= ' onload="magic_check()" ';
        
        $r					.= $DSP->magic_checkboxes();
        
        $form_url			= 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_field_confirm';
        
        $r					.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r					.= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));
		
		$top[] = array(
						'text'	=> NBS,
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '3%'
					);
		
		$top[]	= array(
						'text'	=> $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"").NBS.NBS.$LANG->line('delete'),
						'class'	=> 'tableHeadingAlt',
						'width'	=> '15%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('name'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '15%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('label'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '72%'
					);

		$r		.= $DSP->table_row( $top );
		
		$row_count++;
		
		$i = 0;
		
		foreach ( $query->result as $row )
		{
			unset($rows);
			
			$rows[]		= $row_count;
			
			if ( in_array( $row['name'], $exclude_fields ) )
			{
				$rows[]		= $LANG->line('locked');
				
				$rows[]		= $row['name'];
				
				$rows[]		= $row['label'];
			}
			else
			{
				$rows[]		= $DSP->input_checkbox('toggle[]', $row['field_id'], '', "id='delete_box_".$row['field_id']."'");
				
				$rows[]		= $DSP->anchor( BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_field_form'.AMP.'field_id='.$row['field_id'], $row['name'] );
				
				$rows[]		= $row['label'];
			}
			
			$r			 .= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $rows);
			$row_count++;
		}
		
		
		$foot[] = NBS;
		
		$foot[] = $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"").NBS.NBS.'<b>'.$LANG->line('delete').'</b>';

		$foot[] = NBS;

		$foot[] = NBS;
				
		$r		.= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $foot);

        $r		.=	$DSP->table_c();
    	
		$r		.=	$DSP->qdiv('itemWrapper',  $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=field_order_form', $LANG->line('edit_field_order')));

    	if ($paginate != '')
    	{
    		$r .= $DSP->qdiv('itemWrapper', $paginate.BR.BR);
    	}
    	
		$r		.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit($LANG->line('delete')));             
        
        $r		.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/ 
		
		return $this->content_wrapper($title, $crumb, $r);
	}

    /**	End fields */
  
    
    /**	----------------------------------------
    /**	Delete Fields - Confirm
    /**	----------------------------------------*/    

    function delete_field_confirm()
    {
        global $IN, $DSP, $LANG;
        
        if ( ! $IN->GBL('toggle', 'POST'))
        { 
            return $this->manage_fields();
        }
        
        $title	= $LANG->line('field_delete_confirm');
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform', $LANG->line('manage_fields'));

		$crumb	.= $DSP->crumb_item($LANG->line('field_delete_confirm'));

        $r		= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_field'));
        
        $i		= 0;
        
        foreach ( $_POST as $key => $val )
        {        
            if ( strstr( $key, 'toggle' ) AND ! is_array( $val ) AND is_numeric( $val ) )
            {
                $r	.=	$DSP->input_hidden('delete[]', $val);
                
                $i++;
            }        
        }
        
		$r		.= $DSP->qdiv('alertHeading', $LANG->line('field_delete_confirm'));
		
		$r		.= $DSP->div('box');
		
		if ( $i == 1 )
		{
			$replace[]	= $i; $replace[]	= 'field';
		}
		else
		{
			$replace[]	= $i; $replace[]	= 'fields';
		}
		
		$search	= array( '%i%', '%fields%' );
		
		$r		.= $DSP->qdiv('defaultBold', str_replace( $search, $replace, $LANG->line('field_delete_question') ) );
		
		$r		.= $DSP->qdiv('alert', BR.$LANG->line('action_can_not_be_undone'));
		
		$r		.= $DSP->qdiv('', BR.$DSP->input_submit($LANG->line('delete')));
		
		$r		.= $DSP->qdiv('alert',$DSP->div_c());
		
		$r		.= $DSP->div_c();
		
		$r		.= $DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
    }
    
    /**	End delete field confirm */
  
    
    /**	----------------------------------------
    /**	Delete Field
    /**	----------------------------------------*/    

    function delete_field()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;        
        
        if ( ! $IN->GBL('delete', 'POST'))
        {
            return $this->home();
        }

        $ids	= array();
                
        foreach ($_POST as $key => $val)
        {        
            if (strstr($key, 'delete') AND ! is_array($val) AND is_numeric($val))
            {
                $ids[] = "field_id = '".$val."'";
            }        
        }
        
        $IDS	= implode(" OR ", $ids);
        
        $query	= $DB->query("SELECT field_id, name FROM exp_freeform_fields WHERE ".$IDS);
        
        foreach ( $query->result as $row )
        {
			$DB->query("DELETE FROM exp_freeform_fields WHERE field_id = '".$row['field_id']."'");

			$DB->query("ALTER TABLE exp_freeform_entries DROP `".$row['name']."`");
        }
    
        $message = ($query->num_rows == 1) ? str_replace( '%i%', $query->num_rows, $LANG->line('field_deleted') ) : str_replace( '%i%', $query->num_rows, $LANG->line('fields_deleted') );

        return $this->manage_fields($message);
    }
    
    /**	End delete field */
    
    
    /**	----------------------------------------
    /**	Edit field form
    /**	----------------------------------------*/
    
    function edit_field_form()
    {
        global $IN, $DSP, $DB, $LANG;
        
        $field_id			= '';
        $name				= '';
        $label				= '';
        $field_order		= '';
        $field_type			= '';
        $field_length		= '';
		$selected_text		= '';
		$selected_textarea	= '';
        
        $edit_field_mode	= ( $IN->GBL('field_id') ) ? 'edit_field': 'create_field';
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/    	
                        
        $title	= $LANG->line( $edit_field_mode );
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=manage_fields', $LANG->line('manage_fields'));

		$crumb	.= $DSP->crumb_item($LANG->line( $edit_field_mode ));
		
        $r		= $this->header_and_msg();
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		if ( $IN->GBL('field_id') )
		{
			$sql	= "SELECT * FROM exp_freeform_fields WHERE field_id = '".$IN->GBL('field_id')."'";
			
			$query			= $DB->query($sql);
			
			$field_id		= $query->row['field_id'];
			
			$name			= $query->row['name'];
			
			$label			= $query->row['label'];
			
			$field_order	= $query->row['field_order'];
			
			$field_type		= $query->row['field_type'];
			
			$field_length	= $query->row['field_length'];
		}
		else
		{
			$query	= $DB->query( "SELECT field_order, field_type FROM exp_freeform_fields ORDER BY field_order DESC LIMIT 1" );

			if ( $query->num_rows > 0 )
			{
				$field_order	= $query->row['field_order'] + 1;
			}
			else
			{
				$field_order	= '1';
			}
			
			$field_type		= $query->row['field_type'];
			
			$field_length	= '150';
		}
		
		/**	----------------------------------------
		/**	Start table
		/**	----------------------------------------*/

        $r		.= $DSP->qdiv('tableHeading', $LANG->line( $edit_field_mode ));
				
		/**	----------------------------------------
		/**	Start form
		/**	----------------------------------------*/
        
        $form_url	= 'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_field';
        
        $r			.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r			.=	$DSP->input_hidden('field_id', $field_id, '', '', 'input', '');

        $r			.=	$DSP->table('tableBorder', '0', '0', '100%').
						$DSP->tr().
						$DSP->table_qcell('tableHeadingAlt', array('&nbsp;', '&nbsp;')).
						$DSP->tr_c();
		
		$style		='tableCellOne';
		
		/**	----------------------------------------
		/**	Start field name
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('field_name')).$DSP->qdiv('default', $LANG->line('field_name_info')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('name', $name, '35', '40', 'input', '50%'))), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start field label
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('field_label')).$DSP->qdiv('default', $LANG->line('field_label_info')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('label', $label, '35', '40', 'input', '50%'))), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start field type
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('field_type')), '30%');

		$pulldown	= $DSP->input_select_header('field_type');
		
		if ( $field_type == 'text' )
		{
			$selected_text		= 'selected';
		}
		else
		{
			$selected_textarea	= 'selected';
		}
		
		$pulldown	.= $DSP->input_select_option('text', $LANG->line('text'), $selected_text);
		
		$pulldown	.= $DSP->input_select_option('textarea', $LANG->line('textarea'), $selected_textarea);

		$pulldown	.= $DSP->input_select_footer();
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $pulldown)), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start field order
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('field_order')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('field_order', $field_order, '35', '40', 'input', '5%'))), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start field length
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('field_length')), '30%');
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('field_length', $field_length, '35', '40', 'input', '5%'))), '70%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	End table
		/**	----------------------------------------*/
		
        $r			.= $DSP->table_c();        
    	
    	$button		= ( $name == '' ) ? $LANG->line('create') : $LANG->line('update');
    	
		$r			.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit($button));             
        
        $r			.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
	}

    /**	End edit field form */
  
    
    /**	----------------------------------------
    /**	Edit Field
    /**	----------------------------------------*/    

    function edit_field()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;
        
        $update	= FALSE;
				
		/**	----------------------------------------
		/**	Validate
		/**	----------------------------------------*/
        
        if ( ! $IN->GBL('name', 'POST') )
        {
			return $DSP->error_message($LANG->line('field_name_required'));
        }
        
        if ( stristr( $IN->GBL('name', 'POST'), " " ) )
        {
			return $DSP->error_message($LANG->line('no_spaces_allowed'));
        }
        
        if ( stristr( $IN->GBL('name', 'POST'), "-" ) )
        {
			return $DSP->error_message($LANG->line('no_dashes_allowed'));
        }
        
        if ( ! $IN->GBL('label', 'POST') )
        {
			return $DSP->error_message($LANG->line('field_label_required'));
        }
        
        //	Check for duplicate
        if ( ! $IN->GBL('field_id') )
        {
			$query	= $DB->query("SELECT COUNT(*) AS count FROM exp_freeform_fields WHERE name = '".$IN->GBL('name', 'POST')."'");

			if ( $query->row['count'] > 0 )
			{
				return $DSP->error_message( str_replace( '%name%', $IN->GBL('name', 'POST'), $LANG->line('field_name_exists') ) );
			}
		}
		
		//	Check for prohibited names
		$exclude	= array('entry_id', 'group_id', 'weblog_id', 'author_id', 'ip_address', 'form_name', 'template', 'entry_date', 'edit_date', 'status');

		if ( in_array( strtolower( $IN->GBL('name', 'POST') ), $exclude ) )
		{
			return $DSP->error_message( str_replace( '%name%', $IN->GBL('name', 'POST'), $LANG->line('reserved_field_name') ) );
		}
        
        if ( ! is_numeric( $IN->GBL('field_length', 'POST') ) )
        {
			return $DSP->error_message($LANG->line('numeric_field_length_required'));
        }
        
        if ( ! is_numeric( $IN->GBL('field_order', 'POST') ) )
        {
			return $DSP->error_message($LANG->line('numeric_field_order_required'));
        }
				
		/**	----------------------------------------
		/**	Set field type
		/**	----------------------------------------*/
        
        if ( $IN->GBL('field_type') == 'text' )
        {
			$field_type	= "varchar(".$IN->GBL('field_length').")";
        }
        else
        {
			$field_type	= "text";
        }
				
		/**	----------------------------------------
		/**	Filter post
		/**	----------------------------------------*/
		
				
		/**	----------------------------------------
		/**	Update or Create?
		/**	----------------------------------------*/
		
		if ( $IN->GBL('field_id', 'POST') != '' )
		{
			//	Get old name
			$query	= $DB->query("SELECT name FROM exp_freeform_fields WHERE field_id = '".$IN->GBL('field_id')."'");
			
			$DB->query( $DB->update_string('exp_freeform_fields', $_POST, 'field_id='.$IN->GBL('field_id')) );

			$DB->query( "ALTER TABLE exp_freeform_entries CHANGE `".$query->row['name']."` `".$DB->escape_str( $IN->GBL('name') )."` ".$field_type." NOT NULL" );

			$message	= $LANG->line('field_updated');
		}
		else
		{			
			$DB->query( $DB->insert_string('exp_freeform_fields', $_POST) );

			$DB->query( "ALTER TABLE exp_freeform_entries ADD `".$DB->escape_str( $IN->GBL('name') )."` ".$field_type." NOT NULL" );

			$message	= $LANG->line('field_created');
		}		

        return $this->manage_fields($message);
    }
    
    /**	End edit field */
    
    
    /**	----------------------------------------
    /**	Edit field order form
    /**	----------------------------------------*/
    
    function field_order_form($message = '')
    {
        global $IN, $DSP, $DB, $LANG;
        
        $row_count		= 1;
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/    	
                        
        $title	= $LANG->line('edit_field_order');

		$crumb	= $LANG->line('edit_field_order');
		
        $r		= $this->header_and_msg($message);

        $r		.= $DSP->qdiv('tableHeading', $LANG->line('edit_field_order'));        
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$sql	= "SELECT * FROM exp_freeform_fields ORDER BY field_order ASC";
		
		$query	= $DB->query($sql);
		
		if ( $query->num_rows == 0 )
		{
			$r	.=	$DSP->qdiv('tableCellOne', $DSP->qdiv('highlight', $LANG->line('no_fields')));
				
			/**	----------------------------------------
			/**	Return the finalized output
			/**	----------------------------------------*/ 
			
			return $this->content_wrapper($title, $crumb, $r);
		}
        
        $form_url			= 'C=modules'.AMP.'M=Freeform'.AMP.'P=field_order';
        
        $r					.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r					.= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));
		
		$top[] = array(
						'text'	=> NBS,
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '3%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('name'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '15%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('order'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '72%'
					);

		$r		.= $DSP->table_row( $top );
		
		$i = 0;
		
		foreach ( $query->result as $row )
		{
			unset($rows);
			
			$rows[]		= $row_count;
			
			$rows[]		= $row['name'];
			
			$rows[]		= $DSP->input_text('field_id['.$row['field_id'].']', $row['field_order'], '35', '10', 'input', '5%');
			
			$r			 .= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $rows);
			$row_count++;
		}

        $r		.=	$DSP->table_c();
    	
		$r		.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit($LANG->line('submit')));             
        
        $r		.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/ 
		
		return $this->content_wrapper($title, $crumb, $r);
	}
    
    /**	End field order form */
    
    
    /**	----------------------------------------
    /**	Field order
    /**	----------------------------------------*/    

    function field_order()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;        
        
        if ( ! $IN->GBL('field_id', 'POST'))
        {
            return $this->home();
        }

        $ids	= array();
                
        foreach ($_POST['field_id'] as $key => $val)
        {
			$ids[$key] = $val;
        }
        
        foreach ( $ids as $key => $val )
        {
        	$DB->query( $DB->update_string( 'exp_freeform_fields', array('field_order' => $val), array( 'field_id' => $key ) ) );
        }
    
        $message = $LANG->line('fields_updated');

        return $this->field_order_form($message);
    }
    
    /**	End field order */
    
    
    /**	----------------------------------------
    /**	Manage templates
    /**	----------------------------------------*/
    
    function manage_templates($message = '')
    {
        global $DB, $DSP, $LANG;
                
        $row_limit			= 50;
        $paginate			= '';
        $row_count			= 0;
    	
    	$exclude_templates	= array('default_template');
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/    	
                        
        $title	= $LANG->line('manage_templates');

		$crumb	= $LANG->line('manage_templates');
		
        $r		= $this->header_and_msg($message);
        
		$r		.= $DSP->right_crumb($LANG->line('create_new_template'), BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_template_form');

        $r		.= $DSP->qdiv('tableHeading', $LANG->line('manage_templates'));        
					  
		/**	----------------------------------------
		/**	Query
		/**	----------------------------------------*/
		
		$sql	= "SELECT * FROM exp_freeform_templates ORDER BY template_name ASC";
		
		$query	= $DB->query($sql);
		
		if ( $query->num_rows == 0 )
		{
			$r	.=	$DSP->qdiv('itemWrapper', $DSP->qdiv('highlight', $LANG->line('no_templates')));
				
			/**	----------------------------------------
			/**	Return the finalized output
			/**	----------------------------------------*/ 
			
			return $this->content_wrapper($title, $crumb, $r);
		}		
    
		if ( $query->num_rows > $row_limit )
		{
			$row_count		= ( ! $IN->GBL('row')) ? 0 : $IN->GBL('row');
						
			$url			= BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=manage_templates';
			
			$paginate		= $DSP->pager(
											$url,
											$query->num_rows, 
											$row_limit,
											$row_count,
											'row'
										);
			 
			$sql			.= " LIMIT ".$row_count.", ".$row_limit;
			
			$query			= $DB->query($sql);    
		}
    
        $r					.=	$DSP->toggle();
        
        $DSP->body_props	.= ' onload="magic_check()" ';
        
        $r					.= $DSP->magic_checkboxes();
        
        $form_url			= 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_template_confirm';
        
        $r					.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r					.= $DSP->table_open(array('class' => 'tableBorder', 'width' => '100%'));
		
		$top[] = array(
						'text'	=> NBS,
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '3%'
					);
					
		if ( $query->num_rows == 1 )
		{
			$top[]	= array(
							'text'	=> '',
							'class'	=> 'tableHeadingAlt',
							'width'	=> '1%'
						);
		
			$top[]	= array(
							'text'	=> '',
							'class'	=> 'tableHeadingAlt',
							'width'	=>  '10%'
						);
		}
		else
		{
			$top[]	= array(
							'text'	=> $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\""),
							'class'	=> 'tableHeadingAlt',
							'width'	=> '1%'
						);
		
			$top[]	= array(
							'text'	=> $LANG->line('delete'),
							'class'	=> 'tableHeadingAlt',
							'width'	=>  '10%'
						);
		}
		
		$top[]	= array(
						'text'	=> $LANG->line('name'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '35%'
					);
		
		$top[]	= array(
						'text'	=> $LANG->line('label'),
						'class'	=> 'tableHeadingAlt',
						'width'	=>  '67%'
					);

		$r		.= $DSP->table_row( $top );
		
		$row_count++;
		
		$i = 0;
		
		foreach ( $query->result as $row )
		{
			unset($rows);
			
			$rows[]		= $row_count;
			
			if ( in_array( $row['template_name'], $exclude_templates ) )
			{
				$rows[]		= '';
				
				$rows[]		= $LANG->line('locked');
				
				$rows[]		= $row['template_name'];
				
				$rows[]		= $row['template_label'];
			}
			else
			{
				$rows[]		= $DSP->input_checkbox('toggle[]', $row['template_id'], '', "id='delete_box_".$row['template_id']."'");

				$rows[]		= '';
				
				$rows[]		= $DSP->anchor( BASE.AMP.'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_template_form'.AMP.'template_id='.$row['template_id'], $row['template_name'] );
				
				$rows[]		= $row['template_label'];
			}
			
			$r			 .= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $rows);
			$row_count++;
		}		
		
		if ( $query->num_rows > 1 )
		{
			$foot[] = NBS;
			
			$foot[] = $DSP->input_checkbox('toggleflag', '', '', "onclick=\"toggle(this);\"");
	
			$foot[] = '<b>'.$LANG->line('delete').'</b>';
		
			$foot[] = NBS;
	
			$foot[] = NBS;
			
			$r		.= $DSP->table_qrow( ($i++ % 2) ? 'tableCellOne' : 'tableCellTwo', $foot);
		}				

        $r		.=	$DSP->table_c(); 

    	if ($paginate != '')
    	{
    		$r .= $DSP->qdiv('itemWrapper', $paginate.BR.BR);
    	}
    	
		if ( $query->num_rows > 1 )
		{
			$r		.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit($LANG->line('delete')));
		}
        
        $r		.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/ 
		
		return $this->content_wrapper($title, $crumb, $r);
	}
    
    /**	End manage templates */

    
    /**	----------------------------------------
    /**	Edit email template form
    /**	----------------------------------------*/
    
    function edit_template_form($message = '')
    {
        global $DB, $DSP, $IN, $LANG;
        
        $edit				= FALSE;
        
        $template_id		= '';
		$data_from_name		= '';
		$data_from_email	= '';
		$data_title			= '';
        $template_data		= '';
        $template_name		= '';
        $template_label		= '';
        $wordwrap			= '';
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/    	
                        
        $title	= $LANG->line('templates');

		$crumb	= $LANG->line('templates');
		
        $r		= $this->header_and_msg($message);
					  
		/**	----------------------------------------
		/**	New or Edit?
		/**	----------------------------------------*/
		
		if ( $IN->GBL('template_id') )
		{
			$edit	= TRUE;
			
			$query = $DB->query("SELECT template_id, wordwrap, html, template_name, template_label, data_from_name, data_from_email, data_title, template_data, enable_template FROM exp_freeform_templates WHERE template_id = '".$IN->GBL('template_id')."' LIMIT 1");
			
			if ($query->num_rows == 0)
			{
				return;
			}
			
			$template_id	= $query->row['template_id'];
		}
		
		/**	----------------------------------------
		/**	Variables to highlight
		/**	----------------------------------------*/
		
		$vars = array('entry_date', 'all_custom_fields', 'your_custom_field', 'attachment_count', 'freeform_entry_id');
		
		$vstr = '';
		
		foreach ($vars as $val)
		{			
			$vstr .= $DSP->qdiv('highlight', '{'.$val.'}');
		}
		
		$vstr	.= $DSP->qdiv('highlight', $LANG->line('attachments_pair'));
		
		$vstr = trim($vstr);
					
		$vstr = $DSP->qdiv('itemWrapper', $DSP->qspan('defaultBold', $LANG->line('available_variables')). $DSP->qdiv('itemWrapper', $vstr));
		
		/**	----------------------------------------
		/**	Start table
		/**	----------------------------------------*/

        $r			.= $DSP->qdiv('tableHeading', $LANG->line('templates'));
        
        $r			.= $DSP->qdiv('tableHeadingAlt', $LANG->line('template_desc'));
        
        // Available Vars
        $r			.= $DSP->qdiv('box', $vstr);
				
		/**	----------------------------------------
		/**	Start form
		/**	----------------------------------------*/
        
        $form_url	= 'C=modules'.AMP.'M=Freeform'.AMP.'P=edit_template';
        
        $r			.=	$DSP->form_open(array('action' => $form_url, 'name' => 'target', 'id' => 'target'));

		$r			.=	$DSP->input_hidden('template_id', $template_id, '', '', 'input', '');

        $r			.=	$DSP->table('tableBorder', '0', '0', '100%');
		
		$style		='tableCellOne';
		
		/**	----------------------------------------
		/**	Start template name
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('template_name')).$DSP->qdiv('default', $LANG->line('template_name_info')), '20%');

		if ( $edit )
		{
			$template_name	= $query->row['template_name'];
		}
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('template_name', $template_name, '100', '100', 'input', '75%'))), '80%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start template label
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('template_label')).$DSP->qdiv('default', $LANG->line('template_label_info')), '20%');

		if ( $edit )
		{
			$template_label	= $query->row['template_label'];
		}
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('template_label', $template_label, '100', '100', 'input', '75%'))), '80%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start from name
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('email_from_name')), '20%');

		if ( $edit )
		{
			$data_from_name	= $query->row['data_from_name'];
		}
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('data_from_name', $data_from_name, '100', '100', 'input', '75%'))), '80%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start from email
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('email_from_email')), '20%');

		if ( $edit )
		{
			$data_from_email	= $query->row['data_from_email'];
		}
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('data_from_email', $data_from_email, '100', '100', 'input', '75%'))), '80%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start email subject
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('email_subject')), '20%');

		if ( $edit )
		{
			$data_title	= $query->row['data_title'];
		}
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_text('data_title', $data_title, '100', '100', 'input', '75%'))), '80%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start wordwrap
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('wordwrap')), '20%');

		$checked_y		= 0;
		$checked_n		= 1;

		if ( $edit )
		{
			if ( isset( $query->row['wordwrap'] ) AND $query->row['wordwrap'] == 'y' )
			{
				$checked_y		= 1;
				$checked_n		= 0;
			}
		}
			
		$r			.= $DSP->table_qcell(
						$style, $DSP->qdiv(
						'defaultBold', $DSP->qdiv(
						'itemWrapper', $DSP->input_radio('wordwrap', 'y', $checked_y)." ".$LANG->line('yes')." ".$DSP->input_radio('wordwrap', 'n', $checked_n)." ".$LANG->line('no')
						)
						), '80%'
						);

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start html
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('html')), '20%');

		$checked_y		= 0;
		$checked_n		= 1;

		if ( $edit )
		{
			if ( isset( $query->row['html'] ) AND $query->row['html'] == 'y' )
			{
				$checked_y		= 1;
				$checked_n		= 0;
			}
		}
			
		$r			.= $DSP->table_qcell(
						$style, $DSP->qdiv(
						'defaultBold', $DSP->qdiv(
						'itemWrapper', $DSP->input_radio('html', 'y', $checked_y)." ".$LANG->line('yes')." ".$DSP->input_radio('html', 'n', $checked_n)." ".$LANG->line('no')
						)
						), '80%'
						);

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	Start email data
		/**	----------------------------------------*/
				  
		$r			.= $DSP->tr();
		
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $LANG->line('email_message')), '20%', 'top');

		if ( $edit )
		{
			$template_data	= $query->row['template_data'];
		}
		else
		{
			$template_data	= freeform_notification();
		}
			
		$r			.= $DSP->table_qcell($style, $DSP->qdiv('defaultBold', $DSP->qdiv('itemWrapper', $DSP->input_textarea('template_data', $template_data, '20', '10', 'input', '50%'))), '80%');

		$r			.= $DSP->tr_c();
		
		/**	----------------------------------------
		/**	End table
		/**	----------------------------------------*/
		
        $r			.=	$DSP->table_c();
        
        $submit		= ( $edit ) ? $LANG->line('update'): $LANG->line('submit');
    	
		$r			.=	$DSP->qdiv('itemWrapperTop', $DSP->input_submit( $submit ));             
        
        $r			.=	$DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
	}
    
    /**	End edit template form */

    
    /**	----------------------------------------
    /**	Edit Template
    /**	----------------------------------------*/    

    function edit_template()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;
    
		/**	----------------------------------------
		/**	Update Template
		/**	----------------------------------------*/
			
		if ( ! isset( $_POST['template_data']) || ! isset($_POST['template_id']) || ! isset($_POST['template_name']) || ! isset($_POST['template_label']) )
		{
			return FALSE;
		}
		
		/**	----------------------------------------
		/**	New or Edit?
		/**	----------------------------------------*/
			
		$data['wordwrap']			= $_POST['wordwrap'];
		$data['html']				= $_POST['html'];
		$data['template_name']		= $_POST['template_name'];
		$data['template_label']		= $_POST['template_label'];
		$data['data_from_name']		= $_POST['data_from_name'];
		$data['data_from_email']	= $_POST['data_from_email'];
		$data['data_title']			= $_POST['data_title'];
		$data['template_data']		= $_POST['template_data'];
		
		if ( $_POST['template_id'] == '' )
		{
			/**	----------------------------------------
			/**	Test for unique template name
			/**	----------------------------------------*/
			
			$query	= $DB->query("SELECT COUNT(*) AS count FROM exp_freeform_templates WHERE template_name = '".$_POST['template_name']."' LIMIT 1");

			if ( $query->row['count'] > 0 )
			{
				return $DSP->error_message($LANG->line('template_name_exists'));
			}
			
			$DB->query( $DB->insert_string('exp_freeform_templates', $data ) );

			$success	= $LANG->line('template_created_successfully');
		}
		else
		{
			$DB->query( $DB->update_string( 'exp_freeform_templates', $data, array( 'template_id' => $IN->GBL('template_id') ) ) );

			$success	= $LANG->line('template_update_successful');
		}

        return $this->manage_templates( $success );
    }
    
    /**	End edit template */
    
    /**	----------------------------------------
    /**	Delete Templates - Confirm
    /**	----------------------------------------*/    

    function delete_template_confirm()
    {
        global $IN, $DSP, $LANG;
        
        if ( ! $IN->GBL('toggle', 'POST'))
        { 
            return $this->manage_templates();
        }
        
        $title	= $LANG->line('template_delete_confirm');
        
		$crumb 	= $DSP->anchor(BASE.AMP.'C=modules'.AMP.'M=Freeform', $LANG->line('manage_templates'));

		$crumb	.= $DSP->crumb_item($LANG->line('template_delete_confirm'));

        $r		= $DSP->form_open(array('action' => 'C=modules'.AMP.'M=Freeform'.AMP.'P=delete_template'));
        
        $i		= 0;
        
        foreach ( $_POST as $key => $val )
        {        
            if ( strstr( $key, 'toggle' ) AND ! is_array( $val ) AND is_numeric( $val ) )
            {
                $r	.=	$DSP->input_hidden('delete[]', $val);
                
                $i++;
            }        
        }
        
		$r		.= $DSP->qdiv('alertHeading', $LANG->line('template_delete_confirm'));
		
		$r		.= $DSP->div('box');
		
		if ( $i == 1 )
		{
			$replace[]	= $i; $replace[]	= 'template';
		}
		else
		{
			$replace[]	= $i; $replace[]	= 'templates';
		}
		
		$search	= array( '%i%', '%templates%' );
		
		$r		.= $DSP->qdiv('defaultBold', str_replace( $search, $replace, $LANG->line('template_delete_question') ) );
		
		$r		.= $DSP->qdiv('alert', BR.$LANG->line('action_can_not_be_undone'));
		
		$r		.= $DSP->qdiv('', BR.$DSP->input_submit($LANG->line('delete')));
		
		$r		.= $DSP->qdiv('alert',$DSP->div_c());
		
		$r		.= $DSP->div_c();
		
		$r		.= $DSP->form_close();
				
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->content_wrapper($title, $crumb, $r);
    }
    
    /**	End delete template confirm */

    
    /**	----------------------------------------
    /**	Delete Template
    /**	----------------------------------------*/

    function delete_template()
    {
        global $DB, $DSP, $IN, $LANG, $SESS;        
        
        if ( ! $IN->GBL('delete', 'POST'))
        {
            return $this->home();
        }

        $ids	= array();
                
        foreach ($_POST as $key => $val)
        {        
            if (strstr($key, 'delete') AND ! is_array($val) AND is_numeric($val))
            {
                $ids[] = "template_id = '".$val."'";
            }        
        }
        
        $IDS	= implode(" OR ", $ids);
        
        $query	= $DB->query("SELECT template_id FROM exp_freeform_templates WHERE ".$IDS);
        
        foreach ( $query->result as $row )
        {
			$DB->query("DELETE FROM exp_freeform_templates WHERE template_id = '".$row['template_id']."'");
        }
    
        $message = ($query->num_rows == 1) ? str_replace( '%i%', $query->num_rows, $LANG->line('template_deleted') ) : str_replace( '%i%', $query->num_rows, $LANG->line('templates_deleted') );

        return $this->manage_templates($message);
    }
    
    /**	End delete field */
    

    /**	----------------------------------------
    /**	Module upgrade
    /**	----------------------------------------*/

    function module_upgrade()
    {
    	global $DB, $DSP, $IN, $LANG, $LOC;
    	
    	$sql	= array();
    	
		/**	----------------------------------------
		/**	Start page
		/**	----------------------------------------*/
                        
        $title	= $LANG->line('upgrade');

		$crumb	= $LANG->line('upgrade');
    	
		/**	----------------------------------------
		/**	Should we proceed?
		/**	----------------------------------------*/

		if ( $this->old_version >= $this->version )
		{
			return $this->home();
		}
    	
		/**	----------------------------------------
		/**	Populate SQL array
		/**	----------------------------------------*/

		$sql	=	array_merge( $sql, $this->_sql_attachments(), $this->_sql_entries(), $this->_sql_fields(), $this->_sql_params(), $this->_sql_templates() );
		
		/**	----------------------------------------
		/**	Execute inserts
		/**	----------------------------------------*/

        foreach ($sql as $query)
        {
            $DB->query($query);
        }
        
		/**	----------------------------------------
		/**	Update entries table
		/**	----------------------------------------*/
		
		$query		= $DB->query("DESCRIBE exp_freeform_entries");
		
		$ip_address	= FALSE;
		$template	= FALSE;
		
		foreach( $query->result as $row )
		{		
			//	Change ip_address to varchar
			if ( $row['Field'] == 'ip_address' )
			{
				if ( $row['Type'] != 'varchar(16)' )
				{
					$DB->query( "ALTER TABLE exp_freeform_entries MODIFY ip_address varchar(16) NOT NULL default '0'" );
				}

				$ip_address	= TRUE;
			}
			
			//	Check for template column
			if ( $row['Field'] == 'template' )
			{
				$template	= TRUE;
			}
		}
		
		//	Add in missing columns
		if ( ! $ip_address )
		{
			$DB->query( "ALTER TABLE exp_freeform_entries ADD ip_address varchar(16) NOT NULL default '0' AFTER author_id" );
		}
		
		if ( ! $template )
		{
			$DB->query( "ALTER TABLE exp_freeform_entries ADD template varchar(150) NOT NULL  AFTER form_name" );		
		}
        
		/**	----------------------------------------
		/**	Update fields table
		/**	----------------------------------------*/
		
		$query			= $DB->query("DESCRIBE exp_freeform_fields");
		
		$field_order	= FALSE;
		$field_type		= FALSE;
		$field_length	= FALSE;
		
		foreach( $query->result as $row )
		{
			//	Check for field type
			if ( $row['Field'] == 'field_order' )
			{
				$field_order	= TRUE;
			}
			
			//	Check for field type
			if ( $row['Field'] == 'field_type' )
			{
				$field_type		= TRUE;
			}
			
			//	Check for field length
			if ( $row['Field'] == 'field_length' )
			{
				$field_length	= TRUE;
			}
		}
		
		//	Add in missing columns
		if ( ! $field_length )
		{
			$DB->query( "ALTER TABLE exp_freeform_fields ADD field_length int(3) NOT NULL default '150' AFTER field_id" );
		}
		
		if ( ! $field_type )
		{
			$DB->query( "ALTER TABLE exp_freeform_fields ADD field_type varchar(50) NOT NULL default 'text' AFTER field_id" );
		}
		
		if ( ! $field_order )
		{
			$DB->query( "ALTER TABLE exp_freeform_fields ADD field_order int(10) unsigned NOT NULL default '0' AFTER field_id" );
		}
        
		/**	----------------------------------------
		/**	Update templates table
		/**	----------------------------------------*/
		
		$query			= $DB->query("DESCRIBE exp_freeform_templates");
		
		$template_label		= FALSE;
		$data_from_name		= FALSE;
		$data_from_email	= FALSE;
		$wordwrap			= FALSE;
		
		foreach( $query->result as $row )
		{
			//	Validate template_name
			if ( $row['Field'] == 'template_name' AND $row['Type'] != 'varchar(150)' )
			{
				$DB->query( "ALTER TABLE exp_freeform_templates MODIFY template_name varchar(150) NOT NULL default '0'" );
			}
			
			//	Check for from name field
			if ( $row['Field'] == 'data_from_name' )
			{
				$data_from_name		= TRUE;
			}
			
			//	Check for from email field
			if ( $row['Field'] == 'data_from_email' )
			{
				$data_from_email	= TRUE;
			}
			
			//	Check for template label
			if ( $row['Field'] == 'template_label' )
			{
				$template_label	= TRUE;
			}
			
			//	Check for wordwrap
			if ( $row['Field'] == 'wordwrap' )
			{
				$wordwrap		= TRUE;
			}
		}
		
		//	Add in missing columns
		
		if ( ! $template_label )
		{
			$DB->query( "ALTER TABLE exp_freeform_templates ADD template_label varchar(150) NOT NULL AFTER template_name" );

			$DB->query( $DB->update_string( 'exp_freeform_templates', array('template_label' => 'Default Template'), array('template_name' => 'default') ) );
		}
		
		if ( ! $data_from_email )
		{
			$DB->query( "ALTER TABLE exp_freeform_templates ADD data_from_email varchar(200) NOT NULL AFTER template_label" );
		}
		
		if ( ! $data_from_name )
		{
			$DB->query( "ALTER TABLE exp_freeform_templates ADD data_from_name varchar(150) NOT NULL AFTER template_label" );
		}
		
		if ( ! $wordwrap )
		{
			$DB->query( "ALTER TABLE exp_freeform_templates ADD wordwrap char(1) NOT NULL default 'y' AFTER enable_template" );
		}
		
		//	Update default template if necessary
		$DB->query( $DB->update_string( 'exp_freeform_templates', array('template_name' => 'default_template', 'template_label' => 'Default Template'), array('template_id' => '1') ) );

		//	Refresh default_template
		$data['template_name']	= 'default_template';
		$data['template_label']	= 'Default Template';
		$data['data_title']		= 'Someone has posted to Freeform';
		$data['template_data']	= addslashes( trim( freeform_notification() ) );
		
		$DB->query( $DB->update_string( 'exp_freeform_templates', $data, array('template_id' => '1') ) );
				
		/**	----------------------------------------
		/**	Update version in DB
		/**	----------------------------------------*/
		
		$DB->query( $DB->update_string('exp_modules', array('module_version' => $this->version), array('module_name' => $this->module_name)) );
		
		
		/**	----------------------------------------
		/**	Return the finalized output
		/**	----------------------------------------*/
		
		return $this->home( $LANG->line( $IN->GBL('msg') ), TRUE );
    }
    // END
    

    /**	----------------------------------------
    /**	SQL for entries table creation
    /**	----------------------------------------*/
    
    function _sql_entries()
    {
    	global $DB;
    	
    	$sql	= array();
    	
		/**	----------------------------------------
		/**	Table exists?
		/**	----------------------------------------*/
    	
    	if ( $DB->table_exists('exp_freeform_entries') )
    	{
    		if ($this->old_version < '2.7.1')
    		{
    			$sql[] = "ALTER TABLE `exp_freeform_entries` ADD INDEX (`group_id`)";
    			$sql[] = "ALTER TABLE `exp_freeform_entries` ADD INDEX (`weblog_id`)";
    		}
    	
    		return $sql;
    	}
    	
        $sql[]	=	"CREATE TABLE exp_freeform_entries (
					entry_id int(10) unsigned NOT NULL auto_increment,
					group_id int(10) unsigned NOT NULL default '0',
					weblog_id int(4) unsigned NOT NULL,
					author_id int(10) unsigned NOT NULL default '0',
					ip_address varchar(16) NOT NULL default '0',
					form_name varchar(50) NOT NULL,
					template varchar(150) NOT NULL,
					entry_date int(10) NOT NULL,
					edit_date int(10) NOT NULL,
					status char(10) NOT NULL default 'open',
					name varchar(50) NOT NULL,
					email varchar(50) NOT NULL,
					website varchar(50) NOT NULL,
					street1 varchar(50) NOT NULL,
					street2 varchar(50) NOT NULL,
					street3 varchar(50) NOT NULL,
					city varchar(50) NOT NULL,
					state varchar(50) NOT NULL,
					country varchar(50) NOT NULL,
					postalcode varchar(50) NOT NULL,
					phone1 varchar(50) NOT NULL,
					phone2 varchar(50) NOT NULL,
					fax varchar(50) NOT NULL,
					PRIMARY KEY (entry_id),
					KEY (author_id)
					)";
					
		return $sql;
    }
    
    /**	End SQL for entries table creation */
    

    /**	-------------------------------------------
    /**	SQL for fields table creation
    /**	-------------------------------------------*/
    
    function _sql_fields()
    {
    	global $DB;
    	
    	$sql	= array();
    	
		/**	----------------------------------------
		/**	Table exists?
		/**	----------------------------------------*/
    	
    	if ( $DB->table_exists('exp_freeform_fields') )
    	{
    		return $sql;
    	}
    	
        $sql[]	=	"CREATE TABLE exp_freeform_fields (
					field_id int(10) unsigned NOT NULL auto_increment,
					field_order int(10) NOT NULL default '0',
					field_type varchar(50) NOT NULL default 'text',
					field_length int(3) NOT NULL default '150',
					form_name varchar(50) NOT NULL,
					name varchar(50) NOT NULL,
					name_old varchar(50) NOT NULL,
					label varchar(100) NOT NULL,
					weblog_id int(4) unsigned NOT NULL,
					author_id int(10) unsigned NOT NULL default '0',
					entry_date int(10) NOT NULL,
					edit_date int(10) NOT NULL,
					editable char(1) NOT NULL default 'y',
					status char(10) NOT NULL default 'open',
					PRIMARY KEY (field_id),
					KEY (name),
					KEY (author_id)
					)";
					
        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '1', '', 'name', '', 'Name', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '2', '', 'email', '', 'Email', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '3', '', 'website', '', 'Website', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '4', '', 'street1', '', 'Street 1', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '5', '', 'street2', '', 'Street 2', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '6', '', 'street3', '', 'Street 3', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '7', '', 'city', '', 'City', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '8', '', 'state', '', 'State', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '9', '', 'country', '', 'Country', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '10', '', 'postalcode', '', 'Postal Code', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '11', '', 'phone1', '', 'Phone 1', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '12', '', 'phone2', '', 'Phone 2', '', '', '', '', 'n', '')";

        $sql[]	=	"INSERT INTO exp_freeform_fields (field_id, field_order, form_name, name, name_old, label, weblog_id, author_id, entry_date, edit_date, editable, status) VALUES ('', '13', '', 'fax', '', 'Fax', '', '', '', '', 'n', '')";
					
		return $sql;
    }
    
    /**	End SQL for fields table creation */
    

    /**	-------------------------------------------
    /**	SQL for templates table creation
    /**	-------------------------------------------*/
    
    function _sql_templates()
    {
    	global $DB;
    	
    	$sql	= array();
    	
		/**	----------------------------------------
		/**	Table exists?
		/**	----------------------------------------*/
    	
    	if ( $DB->table_exists('exp_freeform_templates') )
    	{
			/**	----------------------------------------
			/**	Update templates table
			/**	----------------------------------------*/
			
			$query		= $DB->query("DESCRIBE exp_freeform_templates");
			
			$html		= FALSE;
			
			foreach( $query->result as $row )
			{		
				//	HTML
				if ( $row['Field'] == 'html' )
				{	
					$html	= TRUE;
				}
			}
			
			//	Add in missing columns
			if ( ! $html )
			{
				$sql[]	= "ALTER TABLE exp_freeform_templates ADD html char(1) NOT NULL default 'n' AFTER wordwrap";
			}
			
			if ($this->old_version < '2.7.1')
    		{
    			$sql[] = "ALTER TABLE `exp_freeform_templates` ADD INDEX (`enable_template`)";
    		}
    	
    		return $sql;
    	}
    	
        $sql[]	=	"CREATE TABLE exp_freeform_templates (
					 template_id int(6) unsigned NOT NULL auto_increment,
					 enable_template char(1) NOT NULL default 'y',
					 wordwrap char(1) NOT NULL default 'y',
					 html char(1) NOT NULL default 'n',
					 template_name varchar(150) NOT NULL,
					 template_label varchar(150) NOT NULL,
					 data_from_name varchar(150) NOT NULL,
					 data_from_email varchar(200) NOT NULL,
					 data_title varchar(80) NOT NULL,
					 template_data text NOT NULL,
					 PRIMARY KEY (template_id),
					 KEY (template_name)
					)";

		$sql[]	= "INSERT INTO exp_freeform_templates (template_id, template_name, template_label, data_from_name, data_from_email, data_title, template_data) VALUES ('', 'default_template', 'Default Template', '', '', 'Someone has posted to Freeform', '".addslashes( trim( freeform_notification() ) )."')";
					
		return $sql;
    }
    
    /**	End SQL for templates table creation */
    
    
	/**	----------------------------------------
    /**	SQL for params table creation
	/**	----------------------------------------*/
    
    function _sql_params()
    {
    	global $DB;
    	
    	$sql	= array();
    	
		/**	----------------------------------------
		/**	Table exists?
		/**	----------------------------------------*/
    	
    	if ( $DB->table_exists('exp_freeform_params') )
    	{
    		return $sql;
    	}
    	
		/**	----------------------------------------
		/**	Create
		/**	----------------------------------------*/

        $sql[]	=	"CREATE TABLE exp_freeform_params (
					params_id int(10) unsigned NOT NULL auto_increment,
					entry_date int(10) NOT NULL,
					data text NOT NULL,
					PRIMARY KEY (params_id)
					)";
					
		return $sql;
    }
    
    /**	End SQL for params table creation */
    
    
	/**	----------------------------------------
    /**	SQL for attachments table creation
	/**	----------------------------------------*/
    
    function _sql_attachments()
    {
    	global $DB;
    	
    	$sql	= array();
    	
		/**	----------------------------------------
		/**	Table exists?
		/**	----------------------------------------*/
    	
    	if ( $DB->table_exists('exp_freeform_attachments') )
    	{
    		return $sql;
    	}
    	
		/**	----------------------------------------
		/**	Create
		/**	----------------------------------------*/

        $sql[]	=	"CREATE TABLE exp_freeform_attachments (
					attachment_id int(10) unsigned NOT NULL auto_increment,
					entry_id int(10) unsigned NOT NULL,
					pref_id int(10) unsigned NOT NULL,
					entry_date int(10) NOT NULL,
					server_path varchar(150) NOT NULL,
					filename varchar(150) NOT NULL,
					extension varchar(7) NOT NULL,
					filesize int(10) NOT NULL,
					emailed char(1) NOT NULL default 'n',
					PRIMARY KEY (attachment_id),
					KEY (entry_id),
					KEY (pref_id)
					)";
					
		return $sql;
    }
    
    /**	End SQL for attachments table creation */
    

    /**	-------------------------------------------
    /**	Module installer
    /**	-------------------------------------------*/

    function freeform_module_install()
    {
        global $DB;
        
        $sql	= array();
        
        $sql[]	=	"INSERT INTO exp_modules (module_id, module_name, module_version, has_cp_backend) VALUES ('', 'Freeform', '$this->version', 'y')";
        $sql[]	=	"INSERT INTO exp_actions (action_id, class, method) VALUES ('', 'Freeform', 'insert_new_entry')";
        $sql[]	=	"INSERT INTO exp_actions (action_id, class, method) VALUES ('', 'Freeform', 'retrieve_entries')";
        $sql[]	=	"INSERT INTO exp_actions (action_id, class, method) VALUES ('', 'Freeform_CP', 'delete_freeform_notification')";

		$sql	=	array_merge( $sql, $this->_sql_attachments(), $this->_sql_entries(), $this->_sql_fields(), $this->_sql_params(), $this->_sql_templates() );

        foreach ($sql as $query)
        {
            $DB->query($query);
        }
        
        return true;
    }
    // END
    
    
    /**	----------------------------------------
    /**	Module de-installer
    /**	----------------------------------------*/

    function freeform_module_deinstall()
    {
        global $DB;   
        
        $query = $DB->query("SELECT module_id FROM exp_modules WHERE module_name = 'Freeform'"); 
                
        $sql[] =	"DELETE FROM exp_module_member_groups WHERE module_id = '".$query->row['module_id']."'";
        $sql[] =	"DELETE FROM exp_modules WHERE module_name = 'Freeform'";
        $sql[] =	"DELETE FROM exp_actions WHERE class = 'Freeform'";
        $sql[] =	"DELETE FROM exp_actions WHERE class = 'Freeform_CP'";
        
        $sql[] =	"DROP TABLE IF EXISTS exp_freeform_attachments";
        $sql[] =	"DROP TABLE IF EXISTS exp_freeform_entries";
        $sql[] =	"DROP TABLE IF EXISTS exp_freeform_fields";
        $sql[] =	"DROP TABLE IF EXISTS exp_freeform_params";
        $sql[] =	"DROP TABLE IF EXISTS exp_freeform_templates";
                    
        foreach ($sql as $query)
        {
            $DB->query($query);
        }

        return true;
    }
    // END


}

/**	End class */
    
    
/**	-------------------------------------------
/**	Notification template helper
/**	-------------------------------------------*/
    
function freeform_notification()
{
return <<<EOF
Someone has posted to Freeform. Here are the details:

Entry Date: {entry_date}
{all_custom_fields}
EOF;
}

/**	End notification template helper */
?>