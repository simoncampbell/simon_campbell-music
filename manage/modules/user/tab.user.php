<?php if ( ! defined('EXT') ) exit('No direct script access allowed');
 
 /**
 * Solspace - User Module
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
 * User Module Class - Tabs!
 *
 * Handles the adding of Tabs to the Publish Page in EE 2.x
 *
 * @package 	Solspace:User
 * @author		Paul Burdick <paul.burdick@solspace.com>
 * @filesource 	./system/expressionengine/third_party/modules/user/tab.user.php
 */

if (APP_VER < 2.0)
{
	require_once PATH.'bridge/lib/addon_builder/module_builder.php';
}
else
{
	require_once BASEPATH.'expressionengine/third_party/bridge/lib/addon_builder/module_builder.php';
}

class User_tab extends Module_builder_bridge
{
	// --------------------------------------------------------------------

	/**
	 *	Constructor
	 *
	 *	@access		public
	 *	@return		null
	 */
	
	public function __construct()
	{
		parent::Module_builder_bridge('user');
	}
	/* END constructor */
	
	// --------------------------------------------------------------------

	/**
	 *	Publish Tabs
	 *
	 *	Creates the fields that will be displayed on the Publish page for EE 2.x
	 *
	 *	@access		public
	 *	@param		integer
	 *	@param		integer
	 *	@return		array
	 */

	public function publish_tabs($channel_id, $entry_id = '')
	{	
		// @bugfix - EE 2.x on submit of an entry calls this method with incorrect arguments
		if (is_array($channel_id))
		{
			$entry_id	= $channel_id[1];
			$channel_id	= $channel_id[0];
		}
		
		/** --------------------------------------------
        /**  Publish Tab Name
        /** --------------------------------------------*/
		
		$query	= ee()->db->query( "SELECT settings FROM exp_extensions WHERE class = 'User_authors_ext'" );
									
		if ($query->num_rows == 0)
		{
			return array();
		}
		
		// Load the string helper
		ee()->load->helper('string');

		$extension_settings = strip_slashes(unserialize($query->row('settings')));
		
		/** --------------------------------------------
        /**  Do we have a Publish Tab for this Channel?
        /** --------------------------------------------*/
        
        if ( empty($extension_settings[$channel_id]))
        {
        	return array();
        }
        
		/** --------------------------------------------
        /**  Add in our JavaScript/CSS
        /** --------------------------------------------*/
        
		ee()->cp->add_js_script(array( '<script type="text/javascript" charset="utf-8" src="'.$this->base.'&method=publish_tab_javascript&channel_id='.$channel_id.'"></script>'), FALSE);

		/** --------------------------------------------
        /**  User Authors Language File
        /** --------------------------------------------*/

		ee()->lang->loadfile('user_authors');
		
		/** --------------------------------------------
        /**  Determine Current User Authors
        /** --------------------------------------------*/
        
        $user_authors	= array('0' => ee()->lang->line('choose_a_primary_author'));
        $primary_author	= '';

		if ( ! empty($entry_id))
		{
			$query	= ee()->db->query("SELECT ua.author_id, ua.principal, m.screen_name  
									   FROM exp_user_authors ua, exp_members m
									   WHERE ua.author_id != '0' 
									   AND ua.entry_id = '".ee()->db->escape_str($entry_id)."' 
									   AND ua.author_id = m.member_id
									   ORDER BY m.screen_name" );
									   
			foreach($query->result_array() as $row)
			{
				if ($row['principal'] == '')
				{
					$primary_author = $row['author_id'];
				}
				
				$user_authors[$row['author_id']] = $row['screen_name'];
			}
		}

		/** --------------------------------------------
        /**  Build Fields
        /** --------------------------------------------*/
        
		$settings[] = array(
				'field_id'				=> 'solspace_user_browse_authors',
				'field_label'			=> ee()->lang->line('assigned_authors'),
				'field_required' 		=> 'n',
				'field_data'			=> '',
				'field_ta_rows'			=> 5,
				'field_fmt'				=> '',
				'field_instructions' 	=> '',
				'field_fmt_options'		=> array(),
				'field_text_direction'	=> 'ltr',
				'field_type' 			=> 'textarea',
				'field_show_writemode'	=> 'n'
			);
			
		$settings[] = array(
				'field_id'				=> 'solspace_user_primary_author',
				'field_label'			=> ee()->lang->line('primary_author'),
				'field_required' 		=> 'n',
				'field_data'			=> $primary_author,
				'field_list_items'		=> $user_authors,
				'field_ta_rows'			=> 5,
				'field_fmt'				=> '',
				'field_instructions' 	=> '',
				'field_pre_populate'	=> 'n',
				'field_fmt_options'		=> array(),
				'field_text_direction'	=> 'ltr',
				'field_type' 			=> 'select',
				'field_show_writemode'	=> 'n'
			);

		return $settings;
	}
	/* END publish_tabs() */
	
	// --------------------------------------------------------------------

	/**
	 *	Validate Submitted Publish data
	 *
	 *	Allows you to validate the data after the publish form has been submitted but before any 
	 *	additions to the database. Returns FALSE if there are no errors, an array of errors otherwise.
	 *
	 *	@access		public
	 *	@param		array
	 *	@return		bool|array
	 */

	public function validate_publish($params)
	{
		return FALSE;
	}
	/* END validate_publish() */
	
	// --------------------------------------------------------------------

	/**
	 *	Insert Publish Form Data
	 *
	 *	Allows the insertion of data after the core insert/update has been done, thus making 
	 *	available the current $entry_id. Returns nothing.
	 *
	 *	@access		public
	 *	@param		array
	 *	@return		null
	 */
	
	public function publish_data_db($params)
	{
		if ( ! isset($params['mod_data']['solspace_user_submit']))
		{
			return;
		}
		
		require_once $this->addon_path.'mod.user'.EXT;
		
		$TAG = new User();
		
		$TAG->channel_id	= $params['meta']['channel_id'];
		$TAG->site_id		= $params['meta']['site_id'];
		$TAG->entry_id		= $params['entry_id'];
		$TAG->str			= $params['mod_data']['solspace_user_submit'];
		$TAG->type			= 'channel';
		
		var_dump($TAG->parse());
	}
	/* END publish_data_db() */
	
	// --------------------------------------------------------------------

	/**
	 *	Entry Delete
	 *
	 *	Called near the end of the entry delete function, this allows you to sync your records if 
	 *	any are tied to channel entry_ids.
	 *
	 *	@access		public
	 *	@param		array
	 *	@return		null
	 */

	public function publish_data_delete_db($params)
	{
		require_once $this->addon_path.'mod.user'.EXT;
		
		$TAG = new User();
							
		return $TAG->delete( $params['entry_ids'] );
	}
	/* publish_data_delete_db() */

}
/* END User_tab CLASS */

/* End of file tab.user.php */
/* Location: ./system/expressionengine/third_party/modules/user/tab.user.php */