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
 * A class that helps with the building of ExpressionEngine Extensions by allowing Hermes enabled extensions' classes
 * to be extensions of this class and thus gain all of the abilities of it and its parents.
 *
 * @package 	Hermes:Expansion
 * @subpackage	Add-On Builder
 * @category	Extensions
 * @author		Paul Burdick <paul@solspace.com>
 * @link		http://solspace.com/docs/
 * @filesource 	./system/hermes/addon_builder/extension_builder.php
 */
 
require_once PATH.'hermes/lib/addon_builder/addon_builder.php';

class Extension_builder extends Addon_builder {
	
	var $language   = array();
    var $cur_used   = array();
    
    // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	null
	 */
    
	function Extension_builder($name='')
	{
		parent::Addon_builder($name);
		
		/** --------------------------------------------
        /**  Set Required Extension Variables
        /** --------------------------------------------*/
        
        $this->fetch_language_file($this->lower_name);
        	
		$this->name			= $this->line($this->lower_name.'_label');
		$this->description	= $this->line($this->lower_name.'_description');
		
		if (defined(strtoupper($this->lower_name).'_VERSION') && defined(strtoupper($this->lower_name).'_DOCS_URL'))
		{
			$this->version		= constant(strtoupper($this->lower_name).'_VERSION');
			$this->docs_url		= constant(strtoupper($this->lower_name).'_DOCS_URL');
		}
	}
	/* END */
	
	
	// --------------------------------------------------------------------

	/**
	 * Activate Extension
	 *
	 * @access	public
	 * @return	null
	 */
    
	function activate_extension()
    {
    	$this->update_extension_hooks(TRUE);
		
		return TRUE;
	}
	/* END activate_extension() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * @access	public
	 * @return	null
	 */
    
	function disable_extension()
    {
    	global $DB;
		
		$this->EE->db->query("DELETE FROM exp_extensions WHERE class='".$this->EE->db->escape_str($this->class_name)."'" );
	}
	/* END disable_extension() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Install/Update Our Extension Hooks for Extension
	 *
	 * Tells ExpressionEngine what extension hooks we wish to use for this extension.  If an extension
	 * is part of a module, then it is the module's class name with the '_extension' suffix added on 
	 * to it.  Stand-alone extensions are just the class name.
	 *
	 * @access	public
	 * @return	null
	 */

	function update_extension_hooks($install = FALSE)
    {
    	global $DB, $EXT;
    	
    	if ( ! is_array($this->hooks) OR sizeof($this->hooks) == 0)
    	{
    		return TRUE;
    	}
    	
    	/** --------------------------------------------
        /**  Determine Existing Methods
        /** --------------------------------------------*/
    	
    	$exists	= array();
    	
    	$query	= $this->EE->db->query( "SELECT method FROM exp_extensions 
    						   WHERE class = '".$this->EE->db->escape_str($this->class_name)."'");
    	
    	foreach ( $query->result as $row )
    	{
    		$exists[] = $row['method'];
    	}
    	
    	/** --------------------------------------------
        /**  Compare and Insert Missing Methods
        /** --------------------------------------------*/
    	
    	foreach($this->hooks as $method => $data)
    	{
    		if ($install === TRUE)
    		{
    			$data['settings'] = serialize($this->default_settings);
    		}
    		
    		if ( ! in_array($method, $exists))
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
    	
    	foreach(array_diff($exists, array_keys($this->hooks)) as $method)
    	{
    		$this->EE->db->query("DELETE FROM exp_extensions 
    					WHERE class = '".$this->EE->db->escape_str($this->class_name)."' 
    					AND method = '".$this->EE->db->escape_str($method)."'");
    	}
    	
    	/** --------------------------------------------
        /**  Update Version in Extension Class - Prevents repeats
        /** --------------------------------------------*/
    	
    	$this->EE->extensions->version_numbers[$this->class_name] = $this->version;
    }
    /* END update_extension_hooks() */
    
    // --------------------------------------------------------------------

	/**
	 *	Last Extension Call Variable
	 *
	 *	You know that annoying $this->EE->extensions->last_call class variable that some moron put into the Extensions
	 *	class for when multiple extensions call the same hook?  This will take the possible default
	 *	parameter and a default value and return whichever is valid.  Examples:
	 *
	 *	$argument = $this->last_call($argument);		// Default argument or Last Call?
	 *	$argument = $this->last_call(NULL, array());	// No default argument.  If no Last Call, empty array is default.
	 *
	 *	@access		public
	 *	@param		string|array|null	The default argument sent by the Extensions class, if any.
	 *	@param		string|array|null	If no default argument and no $this->EE->extensions->last_call, the default value to return.
	 *	@return		string|array
	 */
	 
	function get_last_call($argument, $default = NULL)
	{
		global $EXT;
	
		if ($this->EE->extensions->last_call !== FALSE)
		{
			return $this->EE->extensions->last_call;
		}
		elseif ($argument !== NULL)
		{
			return $argument;
		}
		else
		{
			return $default;
		}
	}
	/* END get_last_call() */
	
	
/*
=====================================================
 Language Class
-----------------------------------------------------
Two known extensions sessions_end and sessions_start are called prior to Language being instantiated,
so we wrote our own little method here that removes the $this->EE->session->userdata check and still loads the
language file for the extension, if required...
=====================================================
*/

	/** -------------------------------------
    /**  Fetch a language file
    /** -------------------------------------*/

    function fetch_language_file($which = '', $object = FALSE)
    {
        global $IN, $OUT, $LANG, $PREFS, $FNS;
        
        if ($which == '')
        {
            return;
        }
        
        if (is_object($object) && strtolower(get_class($object)) == 'session' && $object->userdata['language'] != '')
        {
            $user_lang = $object->userdata['language'];
        }
        else
        {
			if ($this->EE->input->GBL('language', 'COOKIE'))
			{
				$user_lang = $this->EE->input->GBL('language', 'COOKIE');
			}
			elseif ($this->EE->config->ini('deft_lang') != '')
            {
                $user_lang = $this->EE->config->ini('deft_lang');
            }
            else
            {
                $user_lang = 'english';
            }
        }
        
        // Sec.ur.ity code.  ::sigh::
        
        $user_lang = $this->EE->functions->filename_security($user_lang);
            
        if ( ! in_array($which, $this->cur_used))
        {
			$options = array($this->addon_path.'language/'.$user_lang.'/lang.'.$which.EXT,
							 $this->addon_path.'language/english/lang.'.$which.EXT);
        					 
        	$success = FALSE;
        	
        	foreach($options as $path)
        	{
        		if ( file_exists($path) && include $path)
        		{
        			$success = TRUE;
        			break;
        		}
        	}
        
        	if ($success === FALSE)
        	{
				return;
            }
            
            $this->cur_used[] = $which;
            
            if (isset($L))
            {
            	$this->language = array_merge($this->language, $L);
            	
            	if (is_object($LANG))
            	{
            		$this->EE->lang->language = array_merge($this->EE->lang->language, $L);
            		$this->EE->lang->cur_used[] = $which;
            	}
            	
            	unset($L);
            }
        }
    }
    /* END */
    
    /** -------------------------------------
    /**  Fetch a specific line of text
    /** -------------------------------------*/

    function line($which = '', $label = '')
    {
    	global $PREFS;
    
        if ($which != '')
        {
        	if ( ! isset($this->language[$which]))
        	{
        		$line = $which;
        	}
        	else
			{
				$line = ( ! isset($this->language[$which])) ? FALSE : $this->language[$which];
							
				$word_sub = ($this->EE->config->ini('weblog_nomenclature') != '' AND $this->EE->config->ini('weblog_nomenclature') != "weblog") ? $this->EE->config->ini('weblog_nomenclature') : '';
				
				if ($word_sub != '')
				{
					$line = preg_replace("/metaweblog/i", "Tr8Vc345s0lmsO", $line);
					$line = str_replace('"weblog"', 'Ghr77deCdje012', $line);
					$line = str_replace('weblog', strtolower($word_sub), $line);
					$line = str_replace('Weblog', ucfirst($word_sub),    $line);
					$line = str_replace("Tr8Vc345s0lmsO", 'Metaweblog', $line);
					$line = str_replace("Ghr77deCdje012", '"weblog"', $line);
				}
			}
            
            if ($label != '')
            {
                $line = '<label for="'.$label.'">'.$line."</label>";
            }
            
            return stripslashes($line);
        }
    }
    /* END */
    
    
}
/* END Extension_builder Class */

?>