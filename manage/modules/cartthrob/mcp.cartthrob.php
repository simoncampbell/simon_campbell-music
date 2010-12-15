<?php 
/**
 * Cartthrob_CP
 * Cartthrob Module Control Panel: Part of the CartThrob cart system for Expression Engine
 *
 * This file must be placed in the
 * /system/modules/ folder in your ExpressionEngine installation.
 *
 * This Module provides ExpressionEngine with shopping cart functions
 * 
 * This is an application that works with ExpressionEngine <a href="http://www.ExpressionEngine.com">http://www.ExpressionEngine.com</a>
 * @link http://www.ExpressionEngine.com
 * @package CartThrob
 * @version 0.9457
 * @author Chris Newton <http://barrettnewton.com>, Rob Sanchez, Chris Barrett
 * @see http://cartthrob.com/
 * @copyright Copyright (c) 2010 Chris Newton, Barrett Newton Inc.
 * @license http://cartthrob.com/docs/pages/license_agreement/ All source code commenting and attribution must not be removed. This is a condition of the attribution clause of the license.
**/
class Cartthrob_CP { 

    var $version = '0.9457';
    
    function Cartthrob_CP( $switch = TRUE ) 
    {
        global $IN;
        
        if ($switch)
        {
            switch($IN->GBL('P')) 
            {
                default:
                    $this->_home();
                    break;
            }
        }
    }
	/**
	 * _home
	 *
	 * redirects to the extension settings for CartThrob
	 *  
	 * @return void
	 * @author Rob Sanchez
	 * @access private
	 * @since 1.0.0
	 */
    function _home()
    {
        global $FNS;
        
        $FNS->redirect(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extension_settings'.AMP.'name=cartthrob_ext');
    }
	/**
	* cartthrob_module_install
	*
	* adds data to the database during install 
	* 
	* @return bool true 
	* @author Rob Sanchez
	* @access public
	* @since 1.0.0
	*/
    function cartthrob_module_install() 
    { 
        global $DB;
        
        $sql[] = $DB->insert_string('exp_modules', array(
            'module_name' => 'Cartthrob',
            'module_version' => $this->version,
            'has_cp_backend' => 'y'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_checkout'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_add_to_cart_form_submit'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_coupon_code_form_submit'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_update_item_submit'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_delete_from_cart_submit'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_save_customer_info_submit'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_update_cart_submit'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_ajax_action'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_jquery_plugin_action'
        ));
        
        $sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_multi_add_to_cart_form_submit'
        ));
     
		$sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => 'payment_return'
        ));

		$sql[] = $DB->insert_string('exp_actions', array(
            'class' => 'Cartthrob',
            'method' => '_download_file_form_submit'
        ));

        foreach ($sql as $query) 
        { 
            $DB->query($query); 
        } 
         
        return true; 
    }
	/**
	* cartthrob_module_deinstall
	*
	* removes information about this module from the database during deinstallation
	*
	* @access public
	* @return bool true
	* @author Rob Sanchez
	* @since 1.0.0
	*/
    function cartthrob_module_deinstall() 
    { 
        global $DB;     

        $query = $DB->query("SELECT module_id 
                             FROM exp_modules 
                             WHERE module_name = 'Cartthrob'"); 
                 
        $sql[] = "DELETE FROM exp_module_member_groups 
                  WHERE module_id = '".$query->row['module_id']."'";       
                   
        $sql[] = "DELETE FROM exp_modules 
                  WHERE module_name = 'Cartthrob'"; 
                   
        $sql[] = "DELETE FROM exp_actions 
                  WHERE class = 'Cartthrob'"; 
                   
        $sql[] = "DELETE FROM exp_actions 
                  WHERE class = 'Cartthrob_CP'";

        foreach ($sql as $query) 
        { 
            $DB->query($query); 
        } 

        return true; 
    }



}
/* End of file mcp.cartthrob.php */
/* Location: ./system/modules/cartthrob/mcp.cartthrob.php */