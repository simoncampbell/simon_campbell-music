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
 * Add-On Builder - Base Class
 *
 * A class that helps with the building of ExpressionEngine Add-Ons by allowing the automating of certain
 * tasks.  Also, connects with the documentDOM class to use View files like CI to build CP pages.
 *
 * @package 	Hermes:Expansion
 * @subpackage	Solspace:Add-On Builder
 * @category	None
 * @author		Paul Burdick <paul@solspace.com>
 * @link		http://solspace.com/docs/
 * @filesource 	./system/hermes/addon_builder/addon_builder.php
 */
 
require_once PATH.'hermes/constants.hermes.php';

class Addon_builder {
	
	var $cache				= array(); // Internal cache
	
	var $ob_level			= 0;
	var $cached_vars		= array();
	var $switches			= array();
	
	var $class_name			= '';		// The general class name (ucfirst with underscores), used in database and class instantiation
	var $lower_name			= '';		// The lowercased class name, used for referencing module files and in URLs
	var $disabled			= FALSE;	// Module disabled? Typically used when an update is in progress. 
	
	var $addon_path			= '';
	var $theme				= 'default';
	
	var $crumbs				= array();
	
	var $document			= FALSE;
	var $data				= FALSE;
	var $actions			= FALSE;
	
	var $module_preferences	= array();
	var $remote_data		= '';	// For remote file retrieving and storage
    
    // --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	null
	 */
    
	function Addon_builder($name='')
	{
		global $LANG, $PREFS, $DB, $FNS, $SESS;
		
		/** --------------------------------------------
        /**  Globals to Class Objects
        /** --------------------------------------------*/
        
        if (HERMES_EE_BRANCH == '2.x')
        {
        	$this->EE =& get_instance();
        }
        else
        {
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
				$this->EE->$object =& $GLOBALS[$global];
			}
		}
		
		/** --------------------------------------------
        /**  Auto-Detect Name
        /** --------------------------------------------*/
        
        if ($name == '')
        {
        	$name = get_class($this);
        }
		
		/** --------------------------------------------
        /**  Important Class Vars
        /** --------------------------------------------*/
        
		$this->lower_name	= strtolower($this->EE->functions->filename_security($name));
    	$this->class_name	= ucfirst($this->lower_name);
		
		/** --------------------------------------------
		/**  Query Marker and New Line CONSTANTs
		/** --------------------------------------------*/
		
		if ( ! defined('QUERY_MARKER'))
		{
			define('QUERY_MARKER', ($this->EE->config->ini('force_query_string') == 'y') ? '' : '?');
		}
		
		if ( ! defined('SLASH'))
		{
			define('SLASH', (HERMES_EE_BRANCH == '2.x') ? '/' : '&#47;');
		}
		
		if ( ! defined('NL'))
		{
			define('NL', "\n");
		}
	
		/** --------------------------------------------
        /**  Prepare Caching
        /** --------------------------------------------*/
    	
    	if ( ! is_object($SESS))
    	{
    		if ( ! isset($GLOBALS['hermes']['cache']['addon_builder']['addon'][$this->lower_name]))
    		{
    			$GLOBALS['hermes']['cache']['addon_builder']['addon'][$this->lower_name] = array();
    		}
    		
    		$this->cache =& $GLOBALS['hermes']['cache']['addon_builder']['addon'][$this->lower_name];
    	}
    	else
    	{
    		if ( ! isset($this->EE->session->cache['hermes']['addon_builder']['addon'][$this->lower_name]))
 			{
 				if( isset($GLOBALS['hermes']['cache']['addon_builder']['addon'][$this->lower_name]))
				{
					$this->EE->session->cache['hermes']['addon_builder']['addon'][$this->lower_name] = $GLOBALS['hermes']['cache']['addon_builder']['addon'][$this->lower_name];
				}
 				else
 				{
 					$this->EE->session->cache['hermes']['addon_builder']['addon'][$this->lower_name] = array();
 				}
 			}
 		
 			$this->cache =& $this->EE->session->cache['hermes']['addon_builder']['addon'][$this->lower_name];
 		}
		
		/** --------------------------------------------
        /**  Add-On Path
        /** --------------------------------------------*/
        
        if (get_parent_class($this) == 'Extension_builder' && is_dir(PATH_EXT.$this->lower_name.'/'))
        {
        	$this->addon_path = PATH_EXT.$this->lower_name.'/';
        }
        else
        {
        	$this->addon_path = PATH_MOD.$this->lower_name.'/';
        }
		
		/** --------------------------------------------
		/**  Language Override
		/** --------------------------------------------*/
		
		if ( is_object($LANG))
		{
			$this->EE->lang->fetch_language_file($this->lower_name);
		}
		
		/** --------------------------------------------
        /**  Module Constants
        /** --------------------------------------------*/
        
        if ( file_exists($this->addon_path.'constants.'.$this->lower_name.'.php'))
        {
        	require_once $this->addon_path.'constants.'.$this->lower_name.'.php';
        }
        
        /** --------------------------------------------
        /**  Data Object
        /** --------------------------------------------*/
        
		if ( file_exists($this->addon_path.'data.'.$this->lower_name.'.php'))
        {
        	require_once $this->addon_path.'data.'.$this->lower_name.'.php';
        	
        	$name = $this->class_name.'_data';
        	
        	$this->data = new $name();
        }
        else
        {
        	require_once PATH_HERMES.'lib/addon_builder/data.addon_builder.php';
        	
        	$this->data = new Addon_builder_data();
        }
        
        /** --------------------------------------------
		/**  documentDOM instantiated, might move this.
		/** --------------------------------------------*/
    	
    	if (REQ == 'CP')
    	{
    		require_once PATH_HERMES.'lib/documentDOM/documentDOM.php';
    	
    		$this->document = new documentDOM();
        }
        
        /** --------------------------------------------
        /**  Important Cached Vars - Used in Both Extensions and Modules
        /** --------------------------------------------*/
		
		$this->cached_vars['page_crumb']	 = '';
		$this->cached_vars['page_title']	 = '';
		$this->cached_vars['text_direction'] = 'ltr';
		$this->cached_vars['onload_events']  = '';
		
		/** --------------------------------------------
		/**  View Path for Add-On
		/** --------------------------------------------*/
		
		if ( $this->theme != 'default' && ! is_dir($this->addon_path.'views/'.$this->EE->functions->filename_security($this->theme)))
		{
			$this->theme = 'default';
		}
		
		if ( $this->theme == 'default' && ! is_dir($this->view_path = $this->addon_path.'views/default'))
		{
			$this->theme = '';
		}
		
		$this->view_path = rtrim($this->addon_path.'views/'.$this->EE->functions->filename_security($this->theme), '/').'/';
		
		/** --------------------------------------------
        /**  Module Installed and Up to Date?
        /** --------------------------------------------*/
        
        if (REQ == 'PAGE' && constant(strtoupper($this->lower_name).'_VERSION') !== NULL && ($this->database_version() == FALSE OR $this->version_compare($this->database_version(), '<', constant(strtoupper($this->lower_name).'_VERSION'))))
		{
			$this->disabled = TRUE;
			
			if (empty($this->cache['disabled_message']) && !empty($this->EE->lang->language[$this->lower_name.'_module_disabled']))
			{
				trigger_error($this->EE->lang->line($this->lower_name.'_module_disabled'), E_USER_NOTICE);
				
				$this->cache['disabled_message'] = TRUE;
			}
		}
		
	}
	/* END Addon_builder() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Instantiates an Object and Returns It
	 *
	 * Tired of having the same code duplicate everywhere for calling Typography, Email, Et Cetera.
	 *
	 * @access	public
	 * @return	object|NULL
	 */
    
	function instantiate( $name , $variables = array())
    {
    	$lower_name = strtolower($name);
    	$class_name = ucfirst($lower_name);
    	
    	// I am embarrassed by this exception -Paul
    	if ($lower_name == 'email')
    	{
    		$class_name == 'EEmail';
    	}
    	
    	if ( ! class_exists($class_name))
		{
			// We only load classes from the CP or CORE directories
			
			if (file_exists(PATH_CP.'core.'.$lower_name.EXT))
			{
				$location = PATH_CP.'core.'.$lower_name.EXT;
			}
			elseif (file_exists(PATH_CORE.'cp.'.$lower_name.EXT))
			{
				$location = PATH_CORE.'cp.'.$lower_name.EXT;
			}
			elseif (file_exists(PATH_HERMES_THIRD.$name.EXT))
			{
				$class_name = $name;
				$location = PATH_HERMES_THIRD.$name.EXT;
			}
			else
			{
				// Perhaps return an error? Nah...
				return NULL;
			}
			
			require_once $location;
		}
		
		$NEW = new $class_name();
		
		foreach($variables AS $key => $value)
		{
			$NEW->$key = $value;
		}
		
		return $NEW;
    }
    /* END instantiate() */
    
    
	// --------------------------------------------------------------------

	/**
	 * Module's Action Object
	 
	 * @access	public
	 * @return	object
	 */
	 
	function actions()
	{
		if ( ! is_object($this->actions))
		{
			require_once $this->addon_path.'act.'.$this->lower_name.'.php';
			
			$name = $this->class_name.'_actions';
			
			$this->actions = new $name();
			$this->actions->data =& $this->data;
		}
	}
	/* END actions() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Database Version
	 *
	 * Returns the version of the module in the database
	 *
	 * @access	public
	 * @return	string
	 */
    
	function database_version( )
    {
    	global $DB;
    	
    	if (isset($this->cache['database_version'])) return $this->cache['database_version'];
    	
    	/**	----------------------------------------
		/**	 Use Template object variable, if available
		/** ----------------------------------------*/
    	
    	if ( isset($GLOBALS['TMPL']) && is_object($GLOBALS['TMPL']) && sizeof($GLOBALS['TMPL']->module_data) > 0)
    	{
    		if ( ! isset($GLOBALS['TMPL']->module_data[$this->class_name]))
    		{
				$this->cache['database_version'] = FALSE;
			}
			else
			{
				$this->cache['database_version'] = $GLOBALS['TMPL']->module_data[$this->class_name]['version'];
			}
			
			return $this->cache['database_version'];
    	}
    	
    	/**	----------------------------------------
		/**	 Direct from the DB
		/** ----------------------------------------*/
    	
    	$query = $this->EE->db->query("SELECT module_version FROM exp_modules WHERE module_name = '".$this->EE->db->escape_str($this->class_name)."'");
			
		if ($query->num_rows == 0)
		{
			$this->cache['database_version'] = FALSE;
		}
		else
		{
			$this->cache['database_version'] = $query->row['module_version'];
		}
		
		return $this->cache['database_version'];
	}
	/* END database_version() */
	
	
	// --------------------------------------------------------------------
		
	/**
	 * Find and return preference
	 *
	 * Any number of possible arguments, although typically I expect there will be only one or two
	 * 
	 * @access	public
	 * @param	string			Preference to retrieve
	 * @return	null|string		If preference does not exist, NULL is returned, else the value
	 */
	 
	function preference()
	{
		$s = func_num_args();
		
		if ($s == 0)
		{
			return NULL;
		}
		
		/** --------------------------------------------
        /**  Fetch Module Preferences
        /** --------------------------------------------*/
		
		if (sizeof($this->module_preferences) == 0 && $this->database_version() !== FALSE)
		{
			if ( ! method_exists($this->data, 'get_module_preferences'))
			{
				return NULL;
			}
		
			$this->module_preferences = $this->data->get_module_preferences();
		}
		
		/** --------------------------------------------
        /**  Find Our Value, If It Exists
        /** --------------------------------------------*/
        
        $value = (isset($this->module_preferences[func_get_arg(0)])) ? $this->module_preferences[func_get_arg(0)] : NULL;
		
		for($i = 1; $i < $s; ++$i)
		{
			if ( ! isset($value[func_get_arg($i)]))
			{
				return NULL;
			}
			
			$value = $value[func_get_arg($i)];
		}
		
		return $value;
	}
	/* END preference() */
	
	// --------------------------------------------------------------------
		
	/**
	 * Homegrown Version of Version Compare
	 *
	 * Compared two versions in the form of 1.1.1.d12 <= 1.2.3.f0
	 * 
	 * @access	public
	 * @param	string	First Version
	 * @param	string	Operator for Comparison
	 * @param	string	Second Version
	 * @return	bool	Whether the comparison is TRUE or FALSE
	 */
	 
	function version_compare($v1, $operator, $v2)
	{
		// Allowed operators
		if ( ! in_array($operator, array('>', '<', '>=', '<=', '==', '!=')))
		{
			trigger_error("Invalid Operator in Add-On Library - Version Compare", E_USER_WARNING);
			return FALSE;
		}
	
		// Normalize and Fix Invalid Values
		foreach(array('v1', 'v2') as $var)
		{
			$x = array_slice(preg_split("/\./", trim($$var), -1, PREG_SPLIT_NO_EMPTY), 0, 4);
			
			for($i=0; $i < 4; $i++)
			{
				if ( ! isset($x[$i]))
				{
					$x[$i] = ($i == 3) ? 'f0' : '0';
				}
				elseif ($i < 3 && ctype_digit($x[$i]) == FALSE)
				{
					$x[$i] = '0';
				}
				elseif($i == 3 && ! preg_match("/^[abdf]{1}[0-9]+$/", $x[$i]))
				{
					$x[$i] = 'f0';
				}
				
				// Set up for PHP's version_compare
				if ($i == 3)
				{
					$letter 	 = substr($x[3], 0, 1);
					$sans_letter = substr($x[3], 1);
					
					if ($letter == 'd')
					{
						$letter = 'dev';
					}
					elseif($letter == 'f')
					{
						$letter = 'RC';
					}
					
					$x[3] = $letter.'.'.$sans_letter;
				}
			}
			
			$$var = implode('.', $x);
		}
		
		// echo $v1.' - '.$v2;
		
		return version_compare($v1, $v2, $operator);
	}
	/* END version_compare() */

	
	// --------------------------------------------------------------------
		
	/**
	 * ExpressionEngine CP View Request
	 *
	 * Just like a typical view request but we do a few EE CP related things too
	 * 
	 * @access	private
	 * @param	array
	 * @return	void
	 */
	function ee_cp_view($view)
	{
		global $DSP, $EXT, $OUT, $FNS;
		
		/** --------------------------------------------
        /**  Build Crumbs!
        /** --------------------------------------------*/
        
        $this->build_crumbs();
		
		// We need this because there are certain extensions that will still need to modify our pages.
		
		// -------------------------------------------
		// 'show_full_control_panel_start' hook.
		//  - Full Control over CP
		//  - Modify any $DSP class variable (JS, headers, etc.)
		//  - Override any $DSP method and use their own
		//
			$edata = $this->EE->extensions->call_extension('show_full_control_panel_start');
			if ($this->EE->extensions->end_script === TRUE) return;
		//
		// -------------------------------------------
	
		$output = $this->view($view, array(), TRUE);
		
		// We need this because there are certain extensions that will still need to modify our pages.
		
		// -------------------------------------------
		// 'show_full_control_panel_end' hook.
		//  - Rewrite CP's HTML
		//	- Find/Replace Stuff, etc.
		//
			if ($this->EE->extensions->active_hook('show_full_control_panel_end') === TRUE)
			{
				$output = $this->EE->extensions->call_extension('show_full_control_panel_end', $output);
				if ($this->EE->extensions->end_script === TRUE) return;
			}
		//
		// -------------------------------------------
		
		if (stristr($output, '{XID_HASH}'))
		{
			$output = $this->EE->functions->add_form_security_hash($output);
		}
		
		$this->EE->output->display_final_output($DSP->secure_hash($output));
		exit;
	}
	/* END ee_cp_view() */
	 
	// --------------------------------------------------------------------

	/**
	 *	View File Loader
	 *
	 *	Takes a file from the filesystem and loads it so that we can parse PHP within it just
	 *
	 *
	 *	@access		public
	 *	@param		string		$view - The view file to be located
	 *	@param		array		$vars - Array of data variables to be parsed in the file system
	 *	@param		bool		$return - Return file as string or put into buffer
	 *	@param		string		$path - Override path for the file rather than using $this->view_path
	 *	@return		string
	 */
	 
	function view($view, $vars = array(), $return = FALSE, $path='')
	{
		global $LANG, $FNS, $PREFS, $DSP, $LOC, $SESS;
		
		/** --------------------------------------------
        /**  Determine File Name and Extension for Requested File
        /** --------------------------------------------*/
        
		if ($path == '')
		{
			$ext = pathinfo($view, PATHINFO_EXTENSION);
			$file = ($ext == '') ? $view.EXT : $view;
			$path = $this->view_path.$file;
		}
		else
		{
			$x = explode('/', $path);
			$file = end($x);
		}
		
		/** --------------------------------------------
        /**  Make Sure the File Actually Exists
        /** --------------------------------------------*/
		
		if ( ! file_exists($path))
		{
			trigger_error("Invalid View File Request of '".$path."'");
			return FALSE;
		}
		 
		// All variables sent to the function are cached, which allows us to use them
		// within embedded view files within this file.
		 
		if (is_array($vars))
		{
			$this->cached_vars = array_merge($this->cached_vars, $vars);
		}
		extract($this->cached_vars);
		
		//print_r($this->cached_vars);
		 
		/** --------------------------------------------
        /**  Buffer Output
        /**  - Increases Speed
        /**  - Allows Views to be Nested Within Views
        /** --------------------------------------------*/
        
		ob_start();

		/** --------------------------------------------
        /**  Load File and Rewrite Short Tags
        /** --------------------------------------------*/
		
		$rewrite_short_tags = TRUE; // Hard coded setting for now...
		
		if ((bool) @ini_get('short_open_tag') === FALSE AND $rewrite_short_tags == TRUE)
		{
			echo eval('?'.'>'.preg_replace("/;*\s*\?".">/", "; ?".">", str_replace('<'.'?=', '<?php echo ', file_get_contents($path))).'<'.'?php ');
		}
		else
		{
			include($path);
		}
		
		/** --------------------------------------------
        /**  Return Parsed File as String
        /** --------------------------------------------*/
		
		if ($return === TRUE)
		{		
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}
		 
		/** --------------------------------------------
        /**  Flush Buffer
        /** --------------------------------------------*/
        
		if (ob_get_level() > $this->ob_level + 1)
		{
			ob_end_flush();
		}
		else
		{
			$buffer = ob_get_contents();
			@ob_end_clean();
			return $buffer;
		}
	}
	/* END view() */
	
	// --------------------------------------------------------------------

	/**
	 * Fetch the CP Stylesheet
	 *
	 * Had to build this because it was not abstracted well enough for us to simply call EE methods
	 *
	 * @access	public
	 * @param	array		An array of find/replace values to perform in the stylesheet
	 * @return	string
	 */
	 
	function fetch_stylesheet()
	{
	 	global $DSP, $PREFS;
	 	
	 	// Change CSS on the click so it works like the hover until they unclick?  
        
		$tab_behaviors = array(
								'publish_tab_selector'		=> ($this->EE->config->ini('publish_tab_behavior') == 'hover') ? 'hover' : 'active',
								'publish_tab_display'		=> ($this->EE->config->ini('publish_tab_behavior') == 'none') ? '' : 'display:block; visibility: visible;',
								'publish_tab_ul_display'	=> ($this->EE->config->ini('publish_tab_behavior') == 'none') ? '' : 'display:none;',
								'sites_tab_selector'		=> ($this->EE->config->ini('sites_tab_behavior') == 'hover') ? 'hover' : 'active',
								'sites_tab_display'			=> ($this->EE->config->ini('sites_tab_behavior') == 'none') ? '' : 'display:block; visibility: visible;',
								'sites_tab_ul_display'		=> ($this->EE->config->ini('sites_tab_behavior') == 'none') ? '' : 'display:none;'
							);
		
		$stylesheet = $DSP->fetch_stylesheet();
	
		foreach ($tab_behaviors as $key => $val)
		{
			$stylesheet = str_replace(LD.$key.RD, $val, $stylesheet);
		}
	 	
	 	return $stylesheet;
	}
	 /* END fetch_stylesheet() */
	 
	 
	// --------------------------------------------------------------------
	
	/**
	 * Add Array of Breadcrumbs for a Page
	 *
	 * @access	public
	 * @param	array
	 * @return	null
	 */
	 
	function add_crumbs($array)
	{
		if ( is_array($array))
		{
			foreach($array as $value)
			{
				if ( is_array($value))
				{
					$this->add_crumb($value[0], $value[1]);
				}
				else
				{
					$this->add_crumb($value);
				}
			}
		}
	}
	/* END add_crumbs */
	
	// --------------------------------------------------------------------
	
	/**
	 * Add Single Crumb to List of Breadcrumbs
	 *
	 * @access	public
	 * @param	string		Text of breacrumb
	 * @param	string		Link, if any for breadcrumb
	 * @return	null
	 */
	
	function add_crumb($text, $link='')
	{
		$this->crumbs[] = ($link == '') ? array($text) : array($text, $link);
	}
	/* END add_crumb() */	
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Takes Our Crumbs and Builds them into the Breadcrumb List
	 *
	 * @access	public
	 * @return	null
	 */
	
	function build_crumbs()
	{
		global $DSP, $OUT;
		
		if ( ! is_array($this->crumbs) OR count($this->crumbs) == 0)
		{
			$DSP->title			= $this->crumbs;
			$this->cached_vars['page_crumb'] = $this->crumbs;
			$this->cached_vars['page_title'] = $this->crumbs;
			return;
		}
		
		$DSP->crumb = '';
		$this->cached_vars['page_crumb'] = '';
		
		$item = (count($this->crumbs) == 1) ? TRUE : FALSE;
		
		foreach($this->crumbs as $key => $value)
		{
			if (is_array($value))
			{
				$name = (isset($value[1])) ? $DSP->anchor($value[1], $value[0]) : $value[0];
				$this->cached_vars['page_title'] = $value[0];
			}
			else
			{
				$name = $value;
				$this->cached_vars['page_title'] = $value;
			}
			
			if ($item === FALSE)
			{
				$this->cached_vars['page_crumb'] .= $name;
				$item = TRUE;
			}
			else
			{
				$this->cached_vars['page_crumb'] .= $DSP->crumb_item($name); 
			}
		}
		
		$DSP->crumb = $this->cached_vars['page_crumb'];
	}
	/* END build_crumbs() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Field Output Prep for arrays and strings
	 *		
	 *
	 * @access	public
	 * @param	string|array	The item that needs to be prepped for output
	 * @return	string|array
	 */
    
    function output($item)
    {
    	if (is_array($item))
    	{
    		$array = array();
    		
    		foreach($item as $key => $value)
    		{
    			$array[$this->output($key)] = $this->output($value);
    		}
    		
    		return $array;
    	}
    	elseif(is_string($item))
    	{
			return htmlspecialchars($item, ENT_QUOTES);
		}
		else
		{
			return $item;
		}
    }
    /* END output() */
    
	// --------------------------------------------------------------------

	/**
	 * Cycles Between Values
	 *
	 * Takes a list of arguments and cycles through them on each call
	 *
	 * @access	public
	 * @param	string|array	The items that need to be cycled through
	 * @return	string|array
	 */
    
    function cycle($items)
    {	
    	if ( ! is_array($items))
    	{
    		$items = func_get_args();
    	}
    	
    	$hash = md5(implode('|', $items));
    	
    	if ( ! isset($this->switches[$hash]) OR ! isset($items[$this->switches[$hash] + 1]))
    	{
    		$this->switches[$hash] = 0;
    	}
    	else
    	{
    		$this->switches[$hash]++;
    	}
    	
    	return $items[$this->switches[$hash]];
    }
    /* END cycle() */
    
    
	// --------------------------------------------------------------------

	/**
	 * Order Array
	 *
	 * Takes an array and reorders it based on the value of a key
	 *
	 * @access	public
	 * @param	array	$array		The array needing to be reordered
	 * @param	string	$key		The key being used to reorder
	 * @param	string	$order		The order for the values asc/desc
	 * @return	array
	 */
    
    function order_array($array, $key, $order = 'desc')
    {	
    	// http://us2.php.net/manual/en/function.array-multisort.php
    }
    /* END order_array() */
    
	// --------------------------------------------------------------------

	/**
	 * Column Exists in DB Table
	 *
	 * @access	public
	 * @param	string	$column		The column whose existence we are looking for
	 * @param	string	$table		In which table?
	 * @return	array
	 */
    
	function column_exists( $column, $table )
	{
		global $DB;
		
		if ( isset($this->cache['column_exists'][$table][$column]))
		{
			return $this->cache['column_exists'][$table][$column];
		}
		
		/**	----------------------------------------
		/**	Check for columns in tags table
		/** ----------------------------------------*/
		
		$query	= $this->EE->db->query( "DESCRIBE `".$this->EE->db->escape_str( $table )."` `".$this->EE->db->escape_str( $column )."`" );
		
		if ( $query->num_rows > 0 )
		{
			return $this->cache['column_exists'][$table][$column] = TRUE;
		}
		
		return $this->cache['column_exists'][$table][$column] = FALSE;
	}
	/* END column_exists() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Retrieve Remote File and Cache It
	 *
	 * @access	public
	 * @param	string		$url - URL to be retrieved
	 * @param	integer		$cache_length - How long to cache the result, if successful retrieval
	 * @return	bool		Success or failure.  Data result stored in $this->remote_data
	 */
	
	function retrieve_remote_file($url, $cache_length = 24, $path='', $file='')
	{
		global $FNS;
	
		$path		= ($path == '') ? PATH_CACHE.'addon_builder/' : rtrim($path, '/').'/';
		$file		= ($file == '') ? md5($url).'.txt' : $file;
		$file_path	= $path.$file;
	
		/** --------------------------------------------
        /**  Check for Cached File
        /** --------------------------------------------*/
	
		if ( ! file_exists($file_path) OR (time() - filemtime($file_path)) > (60 * 60 * round($cache_length))) 
		{
			@unlink($file_path);
		}
		elseif (($this->remote_data = file_get_contents($file_path)) === FALSE)
		{
			@unlink($file_path);
		}
		else
		{
			return TRUE;
		}
	
		/** --------------------------------------------
        /**  Validate and Create Cache Directory
        /** --------------------------------------------*/
	
		if ( ! is_dir($path))
		{
			$dirs = explode('/', trim($this->EE->functions->remove_double_slashes($path), '/'));
			
			$path = '/';
			
			foreach ($dirs as $dir)
			{       
				if ( ! @is_dir($path.$dir))
				{
					if ( ! @mkdir($path.$dir, 0777))
					{
						$this->errors[] = 'Unable to Create Directory: '.$path.$dir;
						return;
					}
					
					@chmod($path.$dir, 0777);            
				}
				
				$path .= $dir.'/';
			}
		}
		
		if ($this->is_really_writable($path) === FALSE)
		{
			$this->errors[] = 'Cache Directory is Not Writable: '.$path;
			return FALSE;
		}
		
		/** --------------------------------------------
        /**  Retrieve Our URL
        /** --------------------------------------------*/
        
        $this->remote_data = $this->fetch_url($url);
        
        if ($this->remote_data == '')
        {
        	$this->errors[] = 'Unable to Retrieve URL: '.$url;
        	return FALSE;
        }
        
        /** --------------------------------------------
        /**  Write Cache File
        /** --------------------------------------------*/
        
        if ( ! $this->write_file($file_path, $this->remote_data))
		{
			$this->errors[] = 'Unable to Write File to Cache';
			return FALSE;
		}
		
		return TRUE;
	}
	/* END retrieve_remote_file() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Fetch the Data for a URL
	 
	 * @access	public
	 * @param	string		$url - The URI that we are fetching
	 * @return	string
	 */
    
	function fetch_url($url)
    {
    	$data = '';
    	
    	/** --------------------------------------------
        /**  file_get_contents()
        /** --------------------------------------------*/
    	
    	if ((bool) @ini_get('allow_url_fopen') !== FALSE)
		{
			if ($data = @file_get_contents($url))
			{
				return trim($data);
			}
		}
		
		/** --------------------------------------------
        /**  cURL
        /** --------------------------------------------*/

		if (function_exists('curl_init') === TRUE && ($ch = @curl_init()) !== FALSE)
		{
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			// prevent a PHP warning on certain servers
			if (! ini_get('safe_mode') && ! ini_get('open_basedir'))
			{
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			}
			
			curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($ch, CURLOPT_TIMEOUT, 15);
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			$data = curl_exec($ch);
			curl_close($ch);

			if ($data !== FALSE)
			{
				return trim($data);
			}
		}
		
		/** --------------------------------------------
        /**  fsockopen() - Last but only slightly least...
        /** --------------------------------------------*/
		
		$parts	= parse_url($url);
		$host	= $parts['host'];
		$path	= (!isset($parts['path'])) ? '/' : $parts['path'];
		$port	= ($parts['scheme'] == "https") ? '443' : '80';
		$ssl	= ($parts['scheme'] == "https") ? 'ssl://' : '';
		
		if (isset($parts['query']) && $parts['query'] != '')
		{
			$path .= '?'.$parts['query'];
		}
		
		$data = '';

		$fp = @fsockopen($ssl.$host, $port, $error_num, $error_str, 7); 

		if (is_resource($fp))
		{
			fputs ($fp, "GET ".$path." HTTP/1.0\r\n" ); 
			fputs ($fp, "Host: ".$host . "\r\n" ); 
			fputs ($fp, "User-Agent: Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.2.1)\r\n");
			fputs ($fp, "Connection: close\r\n\r\n");
			
			/* ------------------------------
			/*  This error suppression has to do with a PHP bug involving
			/*  SSL connections: http://bugs.php.net/bug.php?id=23220
			/* ------------------------------*/
			
			$old_level = error_reporting(0);
			
			while ( ! feof($fp))
			{
				$data .= trim(fgets($fp, 128));
			}
			
			error_reporting($old_level);

			fclose($fp); 
		}
		
		return trim($data); 
	}
	/* END fetch_url() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Write File
	 *
	 * @access	public
	 * @param	$file	Full location of final file
	 * @param	$data	Data to put into file
	 * @return	bool
	 */
    
    function write_file($file, $data)
    {
    	global $IN, $DB, $DSP, $LANG, $SESS, $PREFS, $EXT;
    	
    	$temp_file = $file.'.tmp';
        
        if ( ! file_exists($temp_file))
        {
        	// Remove old cache file, prevents rename problem on Windows
        	// http://bugs.php.net/bug.php?id=44805
        	
			@unlink($file);
        	
			if (file_exists($file))
			{
				$this->errors[] = "Unable to Delete Old Cache File: ".$file;
				return FALSE;
			}
        
			if ( ! $fp = @fopen($temp_file, 'wb'))
			{
				$this->errors[] = "Unable to Write Temporary Cache File: ".$temp_file;
				return FALSE;
			}
			
			if ( ! flock($fp, LOCK_EX | LOCK_NB))
			{
				$this->errors[] = "Locking Error when Writing Cache File";
				return FALSE;
			}
			
			fwrite($fp, $data);
			flock($fp, LOCK_UN);
			fclose($fp);
			
			// Write, then rename...
			@rename($temp_file, $file);
			
			// Double check permissions
			@chmod($file, 0777); 
			
			// Just in case the rename did not work
			@unlink($temp_file);
		}
		
        return TRUE;
	}
	/* END write_file() */
	
	
	// --------------------------------------------------------------------

	/**
	 * Check that File is Really Writable, Even on Windows
	 *
	 * is_writable() returns TRUE on Windows servers when you really cannot write to the file
	 * as the OS reports to PHP as FALSE only if the read-only attribute is marked.  Ugh!
	 *
	 * Oh, and there is some silly thing with 
	 *
	 * @access	public
	 * @param	string		$path	- Path to be written to.
	 * @param	bool		$remove	- If writing a file, remove it after testing?
	 * @return	bool
	 */
    
	
	function is_really_writable($file, $remove = FALSE)
	{
		// is_writable() returns TRUE on Windows servers
		// when you really can't write to the file
		// as the OS reports to PHP as FALSE only if the
		// read-only attribute is marked.  Ugh?
		
		if (substr($file, -1) == '/' OR is_dir($file))
		{
			return $this->is_really_writable(rtrim($file, '/').'/'.uniqid(mt_rand()), TRUE);
		}
		
		if (($fp = @fopen($file, 'ab')) === FALSE)
		{
			return FALSE;
		}
		else
		{
			if ($remove === TRUE)
			{
				@unlink($file);
			}
			
			fclose($fp);
			return TRUE;
		}
	}
	/* END is_really_writable() */
	
	
	// --------------------------------------------------------------------

	/**
	 *	Check Secure Forms
	 *
	 *	Checks to see if Secure Forms is enabled, and if so sees if the submitted hash is valid
	 *
	 *	@access		public
	 *	@return		bool
	 */
	
	function check_secure_forms()
    {
        global $DB, $IN, $PREFS;
        
		/**	----------------------------------------
		/**	 Secure forms?
		/**	----------------------------------------*/
      
        if ( $this->EE->config->ini('secure_forms') == 'y' )
        {
        	if ( ! isset($_POST['XID']) && ! isset($_GET['XID']))
        	{
        		return FALSE;
        	}
        	
        	$hash = (isset($_POST['XID'])) ? $_POST['XID'] : $_GET['XID'];
        	
            $query	= $this->EE->db->query("SELECT COUNT(*) AS count FROM exp_security_hashes 
            					  WHERE hash = '".$this->EE->db->escape_str($hash)."' 
            					  AND ip_address = '".$this->EE->db->escape_str($this->EE->input->IP)."'
            					  AND date > UNIX_TIMESTAMP()-7200");
        
            if ($query->row['count'] == 0)
            {
				return FALSE;
			}
                                
			$this->EE->db->query("DELETE FROM exp_security_hashes WHERE (hash='".$this->EE->db->escape_str($hash)."' AND ip_address = '".$this->EE->db->escape_str($this->EE->input->IP)."') OR date < UNIX_TIMESTAMP()-7200");
        }
        
		/**	----------------------------------------
		/**	 Return
		/**	----------------------------------------*/
		
		return TRUE;
    }
    /* END check_secure_forms() */
	
	
	// --------------------------------------------------------------------

	/**
	 * A Slightly More Flexible Magic Checkbox
	 *
	 * Toggles the checkbox based on clicking anywhere in the table row that contains the checkbox
	 * Also allows multiple master toggle checkboxes at the top and bottom of a table to de/select all checkboxes
	 *		- give them a name="toggle_all_checkboxes" attribute
	 *		- No longer need to add onclick="toggle(this);" attribute
	 * No longer do you have to give your <form> tag an id="target" attrbiute, you can specify your own ID:
	 *		- <script type="text/javascript">create_magic_checkboxes('delete_cached_uris_form');</script>
	 *		- Or, if you specify no ID, it will find every <table> in the document with a class of 
	 		'magic_checkbox_table' and create the magic checkboxes automatically
	 * Also, it fixes that annoying problem where it was very difficult to easily select text in a row.
	 *
	 *
	 * @access	public
	 * @return	string
	 */
    
    function js_magic_checkboxes()
	{
		return file_get_contents(PATH_HERMES.'lib/addon_builder/magic_checkboxes.js');
	}
    /* END js_magic_checkboxes() */
    
	
	
	// --------------------------------------------------------------------

	/**
	 * Balance a URI
	 *
	 * @access	public
	 * @param	string	$uri
	 * @return	array
	 */
    
	function balance_uri( $uri )
	{
		$uri = '/'.trim($uri, '/').'/';
		
		if ($uri == '//' OR $uri == '')
		{
			$uri = '/';
		}
		
		return $uri;
	}
	/* END balance_uri() */
	
	// --------------------------------------------------------------------

	/**
	 * Fetch Themes for a path
	 *
	 * @access	public
	 * @param	string		$path - Absolute server path to theme directory
	 * @return	array
	 */    
    
	function fetch_themes($path)
	{
		$themes = array();
		
		if ($fp = @opendir($path))
		{ 
			while (false !== ($file = readdir($fp)))
			{			
				if (is_dir($path.$file) AND substr($file, 0, 1) != '.') 
				{				
					$themes[] = $file;
				}
			}		 
			
			closedir($fp); 
		}
	
		sort($themes);
		
		return $themes;
	}
	/* END fetch_themes() */
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Allowed Group
	 *
	 * Member access validation
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function allowed_group($which = '')
	{
		if ( is_object($this->EE->cp))
		{
			return $this->EE->cp->allowed_group($which);
		}
		else
		{
			return $this->EE->display->allowed_group($which);
		}
	}
	/* END allowed_group() */
	
	
	// --------------------------------------------------------------------
	
	/**
	 * Global Error Message Routine
	 *
	 * @access	public
	 * @param	string
	 * @return	bool
	 */	
	function show_error($which = '')
	{
		if ( function_exists('show_error'))
		{
			show_error($which);
		}
		else
		{
			$this->EE->display->error_message($which);
		}
	}
	/* END error_message() */
    
}
/* END Addon_builder Class */

?>