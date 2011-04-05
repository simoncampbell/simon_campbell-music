<?php 

error_reporting(E_ALL ^ E_NOTICE);

/**
 * Digital_Shipping
 * 
 * @author      Some dude at CartThrob
 * @version     1.0
 * 
 */
class Digital_Shipping
{
    var $settings = array();
    
    var $name = 'CT Digital Shipping';
    var $version = '1.0';
    var $description = 'CartThrob Helper Extension for Digital Shipping';
    var $settings_exist = 'n';
    var $docs_url = '';  
    
    // -------------------------------
    //   Constructor 
    // -------------------------------
    
    function Digital_Shipping($settings='') {
        $this->settings = $settings;
    }
    
    // --------------------------------
    //  Activate Extension
    // --------------------------------

    function activate_extension() {
        global $DB;

        $DB->query($DB->insert_string('exp_extensions',
            array(
                'extension_id' => '',
                'class'        => "Digital_Shipping",
                'method'       => "cartthrob_add_to_cart_end",
                'hook'         => "cartthrob_add_to_cart_end",
                'settings'     => "",
                'priority'     => 10,
                'version'      => $this->version,
                'enabled'      => "y"
              )
            ) 
        );
    }

    // --------------------------------
    //  Update Extension  
    // --------------------------------  

    function update_extension($current='') {      // Skeleton method
        global $DB;

        if ($current == '' OR $current == $this->version) {
            return FALSE;
        }

    }

    // --------------------------------
    //  Disable Extension
    // --------------------------------

    function disable_extension() {
        global $DB;

        $DB->query("DELETE FROM exp_extensions WHERE class = 'Digital_Shipping'");
    }
    
    // --------------------------------
    //  Main Method
    // --------------------------------
    
    function cartthrob_add_to_cart_end($cartthrob, $data, $row_id)
    {
        if (isset($_SESSION['cartthrob']['items'][$row_id]['item_options']['cf_products_music_formats']) && 
            in_array($_SESSION['cartthrob']['items'][$row_id]['item_options']['cf_products_music_formats'], array('mp3_format', 'wav_format'))
        ) {
            $_SESSION['cartthrob']['items'][$row_id]['no_shipping'] = 1;
        }
    }

}

?>
