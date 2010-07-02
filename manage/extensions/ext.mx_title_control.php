<?php
/**
* Class file for Title Conrol
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package Title Conrol
* @version 0.0.3
* @author Max Lazar <http://wiseupstudio.com>
* @see 
* @copyright Copyright (c) 2007-2009 Max Lazar
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/

if ( ! defined('EXT')) exit('Invalid file request');
if ( ! defined('mx_tc_version')){
define("mx_tc_version",			"0.0.3");
define("mx_tc_docs_url",			"");
define("mx_tc_addon_id",			"MX_Title_Control");
define("mx_tc_extension_class",	"mx_title_control");
define("mx_tc_cache_name",			"mx_cache");
}
// -----------------------------------------
//  Begin class
// -----------------------------------------
class mx_title_control
{
	/**
	* Extension settings
	* @var array
	*/
	var $settings   = array();

	/**
	* Extension name
	* @var string
	*/
	var $name	 = 'MX Title Conrol';

	/**
	* Extension version
	* @var string
	*/
	var $version	 = mx_tc_version;

	/**
	* Extension description
	* @var string
	*/
	var $description   = 'Allows you to change the *Title field label';

	/**
	* If $settings_exist = 'y' then a settings page will be shown in the ExpressionEngine admin
	* @var string
	*/  
	var $settings_exist  = 'y';

	/**
	* Link to extension documentation
	* @var string
	*/
	var $docs_url   = mx_tc_docs_url;


	
	function mx_title_control($settings='')
	{
		$this->__construct($settings);
	}
  
  	/**
	* PHP 5 Constructor
	*
	* @param	array|string $settings Extension settings associative array or an empty string
	*/
	function __construct($settings='')
	{
		global $IN, $SESS;

		// get the settings from our helper class
		// this returns all the sites settings
		$this->settings = $this->_get_settings();

		if(isset($SESS->cache['mx']) === FALSE){
			$SESS->cache['mx'] = array();
		}
		$this->debug = $IN->GBL('debug');
	}
	
	/**
	* Configuration for the extension settings page (Thanks2Leevi!)
	**/
	function settings_form($current)
	{
		global $DB, $DSP, $LANG, $IN, $PREFS, $SESS;
		
		// create a local variable for the site settings
		$settings = $this->_get_settings();
	
		$DSP->crumbline = TRUE;

		$DSP->title  = $LANG->line('extension_settings');
		$DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
		$DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));

		$DSP->crumb .= $DSP->crumb_item($LANG->line('linkcenter_title') . " {$this->version}");

		$DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

		$DSP->body = '';	
		$DSP->body .= $DSP->heading($LANG->line('mx_title_changer') . " <small>{$this->version}</small>");
		
		$DSP->body .= $DSP->form_open(
			array(
				'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings',
				'name'   => 'settings_example',
				'id'     => 'settings_example'
			),
			// WHAT A M*THERF!@KING B!TCH THIS WAS
			// REMBER THE NAME ATTRIBUTE MUST ALWAYS MATCH THE FILENAME AND ITS CASE SENSITIVE
			// BUG??
			array('name' => strtolower(get_class($this)))
		);

		$DSP->body .=   $DSP->table_open(array('class' => 'tableBorder', 'border' => '0', 'style' => 'margin-top:18px; width:100%'));

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   $LANG->line("extension_settings_title");
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();

		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('extension_settings_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();


		$site_id	= $PREFS->ini('site_id');

		$query	= $DB->query( "SELECT weblog_id, blog_title
							   FROM exp_weblogs 							  
							   WHERE site_id = " . $site_id . "
								ORDER BY blog_title" );
		

	     
		 if  ($settings['multilanguage'] != 'y') {
			$language[] = 'english';
		 }
		 else {
			$language =  $this->language_names();
		 }

		foreach ( $language as $lang )
		{
		if  ($settings['multilanguage'] != 'n')  {
		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableHeading', '', '2');
		$DSP->body .=   "<p style='text-transform: capitalize;color:#fff'>" . $lang. "</p>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();
		}
		$i	= 1;
			foreach ( $query->result as $row )
			{
				$switch	= ( $i == 0 ) ? 'tableCellOne': 'tableCellTwo';

				$DSP->body .=   $DSP->tr();
				$DSP->body .=   $DSP->td($switch, '45%');
				$DSP->body .=   $DSP->qdiv('default', $row['blog_title']);
				$DSP->body .=   $DSP->td_c();

				$DSP->body .=   $DSP->td($switch);
				$DSP->body .=   $DSP->input_text( 'title_'.$lang.'_'.$row['weblog_id'], ( ( isset( $settings['title_'.$lang.'_'.$row['weblog_id']] ) ) ? $settings['title_'.$lang.'_'.$row['weblog_id']] : ''), '', '', '', '30%' );
				$DSP->body .=   $DSP->td_c();
				$DSP->body .=   $DSP->tr_c();

				$i		= ( $i == 1 ) ? 0: 1;
			}			
		}
		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('', '', '2');
		$DSP->body .=   "<div class='box' style='border-width:0 0 1px 0; margin:0; padding:10px 5px'><p>" . $LANG->line('multilanguage_settings_info'). "</p></div>";
		$DSP->body .=   $DSP->td_c();
		$DSP->body .=   $DSP->tr_c();
		
		$DSP->body .=   $DSP->tr();
		$DSP->body .=   $DSP->td('tableCellOne', '30%');
		$DSP->body .=   $DSP->qdiv('defaultBold', $LANG->line('multilanguage'));
		$DSP->body .=   $DSP->td_c();
		$val = (isset($settings['multilanguage']) === FALSE) ? 'n' : $settings['multilanguage'];
		$DSP->body .= $DSP->td('tableCellOne')
			. '<select name="multilanguage">'
					. $DSP->input_select_option('y', $LANG->line('enable'), (($val == 'y') ? 'y' : '' ))
					. $DSP->input_select_option('n', $LANG->line('disable'), (($val == 'n') ? 'y' : '' ))
					. $DSP->input_select_footer()
			. $DSP->td_c()
			. $DSP->tr_c();
		
		
		//$DSP->body .= $FNS->language_pack_names
		$DSP->body .=   $DSP->table_c();
		
		$DSP->body .=   $DSP->qdiv('itemWrapperTop', $DSP->input_submit());
		$DSP->body .=   $DSP->form_c();
	}	
	
	function _get_settings($force_refresh = FALSE, $return_all = FALSE)
	{
		global $SESS, $DB, $REGX, $LANG, $PREFS;

	// assume there are no settings
		$settings = FALSE;

		// Get the settings for the extension
		if(isset($SESS->cache['mx'][mx_tc_addon_id]['settings']) === FALSE || $force_refresh === TRUE)
		{
			// check the db for extension settings
			$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . mx_tc_extension_class . "' LIMIT 1");

			// if there is a row and the row has settings
			if ($query->num_rows > 0 && $query->row['settings'] != '')
			{
				// save them to the cache
				$SESS->cache['mx'][mx_tc_addon_id]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
			}
		}
		// check to see if the session has been set
		// if it has return the session
		// if not return false
		if(empty($SESS->cache['mx'][mx_tc_addon_id]['settings']) !== TRUE)
		{
			$settings = ($return_all === TRUE) ?  $SESS->cache['mx'][mx_tc_addon_id]['settings'] : 
			$SESS->cache['mx'][mx_tc_addon_id]['settings'][$PREFS->ini('site_id')];
		}

		return $settings;

	}	
	
		/**
	* Saves the settings from the config form
	*
	* @since	Version 1.3.0
	**/
	function save_settings()
	{
		// make somethings global
		global $DB, $IN, $PREFS, $REGX, $SESS;
		
		// load the settings from cache or DB
		$this->settings = $this->_get_settings(TRUE, TRUE);

		// unset the name
		unset($_POST['name']);
		
		// add the posted values to the settings
		$this->settings[$PREFS->ini('site_id')] = $_POST;

		/*if(isset($_POST['title[]']) === FALSE)
		{ 
			$this->settings[$PREFS->ini('site_id')]['title'] = array();
		}*/
		
		// update the settings
		$DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($this->settings)) . "' WHERE class = '" . get_class($this) . "'");

	}
	
	function activate_extension()
	{
		global $DB;

		$default_settings = array(
			'multilanguage' 	=> 'n'
			);

		$hooks = array(
						'show_full_control_panel_end'				=> 'show_full_control_panel_end'
				);
		
		$query = $DB->query("SELECT * FROM exp_sites");

		if ($query->num_rows > 0)
		{
			foreach($query->result as $row)
			{
				$settings[$row['site_id']] = $default_settings;
			}
		}
		
		foreach ($hooks as $hook => $method)
		{
			$sql[] = $DB->insert_string('exp_extensions',
						array(
						'extension_id' => '',
						'class'   => get_class($this),
						'method'  => $method,
						'hook'	 =>$hook,
						'settings'  => addslashes(serialize($settings)),
						'priority'  => 10,
						'version' => $this->version,
						'enabled' => "y"
						)
				  	);
		}
    	
    

		foreach ($sql as $query)
		{
			$DB->query($query);
		}
		
	

		return TRUE;

	}

	function 	show_full_control_panel_end ($out)		
	{
		global $IN,$DB, $PREFS,  $SESS, $EXT;
		
		if($EXT->last_call !== FALSE)
			$out = $EXT->last_call;
		
		if($IN->GBL('C', 'GET') == 'publish'  or $IN->GBL('M', 'GET') == 'edit_entry') {		
		
				$settings = $this->_get_settings();
				if  ($IN->GBL('weblog_id', 'GET') !== FALSE) {
					$weblog_id =  $IN->GBL('weblog_id', 'GET');
				}
				else
				{
						$query	= $DB->query( "SELECT weblog_id
							   FROM exp_weblogs 							  
							   WHERE site_id = " . $PREFS->ini('site_id') );
						$weblog_id = 	$query->row['weblog_id'];
				}

				$lang  = ($settings['multilanguage']  == 'y') ?  $SESS->userdata('language') : 'english';					
				$title = (isset ($settings['title_'.$lang.'_'.$weblog_id])) ? $settings['title_'.$lang.'_'.$weblog_id]  : '' ;
				if   ($title  !='') {
					$r= preg_replace('|<label for="title">(.*?)</label>|is', '<label for="title">'.$title.'</label>' , $out);
					if ($r != NULL)
					{
					$out = $r;
					} 
				}
			}
			
			return $out;
	}

	// --------------------------------
	//  Laguange_names
	// --------------------------------	
	    function language_names()
    {
        global $PREFS;
            
		$source_dir = PATH_LANG;

    	$dirs = array();

		if ($fp = @opendir($source_dir))
		{
			while (FALSE !== ($file = readdir($fp)))
			{
				if (is_dir($source_dir.$file) && substr($file, 0, 1) != ".")
				{
					$dirs[] = $file;
				}
			}
			closedir($fp);
		}

		sort($dirs);
		return $dirs;
	}
	// --------------------------------
	//  Update Extension
	// --------------------------------

	function update_extension($current='')
	{
		global $DB;

		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}

		if ($current > '1.0')
		{
			// Update to next version
		}

		$DB->query("UPDATE exp_extensions 
					SET version = '".$DB->escape_str($this->version)."' 
					WHERE class = '" . get_class($this) . "'");
	}

	// --------------------------------
	//  Disable Extension
	// --------------------------------
	function disable_extension()
	{
		global $DB;
		$DB->query("DELETE FROM `exp_extensions` WHERE class = '" . get_class($this) . "'");
	}

}

/* End of file ext.mx_title_control.php */
/* Location: ./system/extensions/ext.mx_title_control.php */
?>
