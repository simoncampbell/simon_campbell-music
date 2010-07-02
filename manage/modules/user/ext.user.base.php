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
 * User Module Class - Extension Class
 *
 * Main extension calss for all functionality`
 *
 * @package 	Solspace:User module
 * @author		Paul Burdick <paul.burdick@solspace.com>
 * @filesource 	./system/modules/user/ext.user.base.php
 */
 
if (APP_VER < 2.0)
{
	require_once PATH.'bridge/lib/addon_builder/extension_builder.php';
}
else
{
	require_once BASEPATH.'expressionengine/third_party/bridge/lib/addon_builder/extension_builder.php';
}

class User_extension_base extends Extension_builder_bridge
{
	public $name				= "User";
	public $version				= "";
	public $description			= "";
	public $settings_exist		= "n";
	public $docs_url			= "http://solspace.com/docs/";
	
	public $settings			= array();
	
	// --------------------------------------------------------------------

	/**
	 *	Constructor
	 *
	 *	@access		public
	 *	@param		array
	 *	@return		null
	 */
	 
    public function User_extension_base( $settings = '' )
    {
    	/** --------------------------------------------
        /**  Load Parent Constructor
        /** --------------------------------------------*/
        
        parent::Extension_builder_bridge();
        
        /** --------------------------------------------
        /**  Settings!
        /** --------------------------------------------*/
        
		$this->settings = $settings;
		
		/** --------------------------------------------
        /**  Set Required Extension Variables
        /** --------------------------------------------*/
        
        if ( is_object(ee()->lang))
        {
        	ee()->lang->loadfile('user');
        
        	$this->name			= ee()->lang->line('user_module_name');
        	$this->description	= ee()->lang->line('user_module_description');
        }
        
        $this->docs_url		= USER_DOCS_URL;
        $this->version		= USER_VERSION;
	}
	
	/**	End constructor */
	
	// --------------------------------------------------------------------

	/**
	 * Activate Extension
	 *
	 * A required method that we actually ignore because this extension is installed by its module
	 * and no other place.  If they want the extension enabled, they have to install the module.
	 *
	 * In EE 2.x, all Add-Ons are "packages", so they will be prompted to try and install the extension
	 * and module at the same time.  So, we only output a message for them in EE 1.x and in EE 2.x 
	 * we just ignore the request.
	 *
	 * @access	public
	 * @return	null
	 */
    
	public function activate_extension()
    {
    	if (APP_VER < 2.0)
    	{
    		return ee()->output->show_user_error('general', str_replace('%url%', 
    															BASE.AMP.'C=modules',
    															ee()->lang->line('enable_module_to_enable_extension')));
		}
	}
	/* END activate_extension() */
	
	// --------------------------------------------------------------------

	/**
	 * Disable Extension
	 *
	 * A required method that we actually ignore because this extension is installed by its module
	 * and no other place.  If they want the extension disabled, they have to uninstall the module.
	 *
	 * In EE 2.x, all Add-Ons are "packages", so they will be prompted to try and install the extension
	 * and module at the same time.  So, we only output a message for them in EE 1.x and in EE 2.x 
	 * we just ignore the request.
	 *
	 * @access	public
	 * @return	null
	 */
    
	public function disable_extension()
    {
    	if (APP_VER < 2.0)
    	{
    		return ee()->output->show_user_error('general', str_replace('%url%', 
    															BASE.AMP.'C=modules',
    															ee()->lang->line('disable_module_to_disable_extension')));
		}					
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
	 *	Login/Registration During Form Submission
	 *
	 *	@access		public
	 *	@param		array
	 *	@return		array
	 */

    public function loginreg( $data = array() )
	{
		if ( is_array( ee()->extensions->last_call ) && count( ee()->extensions->last_call ) > 0 )
		{
			$data = ee()->extensions->last_call;
		}
		
		if ( ee()->input->post('type') === FALSE OR ee()->input->post('type') == '')
		{
			return $data;
		}
		
		ee()->extensions->end_script = FALSE;
		
		/** ----------------------------------------
		/**	Instantiate class
		/** ----------------------------------------*/
		
		if ( class_exists('User') === FALSE )
		{
			require $this->addon_path.'mod.user'.EXT;
		}
		
		$User = new User();
		
		if ( ee()->input->post('type') != 'register' )
		{
			$User->_remote_login();
		}
		else
		{
			$User->_remote_register();
		}
		
		return $data;
	}
	
	/**	End loginreg */
	
	
	// --------------------------------------------------------------------

	/**
	 *	Validate Members
	 *
	 *	@access		public
	 *	@return		null
	 */

    public function cp_validate_members()
	{
		if ( ! ee()->input->post('toggle') OR $_POST['action'] != 'activate')
        {
            return;
        }
        
        $member_ids = array();
        
        foreach ($_POST['toggle'] as $key => $val)
        {        
            if ( ! is_array($val))
            {
            	$member_ids[] = $val;
            }
		}

		if (sizeof($member_ids) == 0)
		{
			return;
		}
		
		/** ----------------------------------------
		/**	Instantiate class
		/** ----------------------------------------*/
		
		if ( class_exists('User') === FALSE )
		{
			require $this->addon_path.'mod.user'.EXT;
		}
		
		$User = new User();

		$User->cp_validate_members($member_ids);
	}
	
	/* END cp_validate_members() */
}

/**	END User_extension_base CLASS */
?>