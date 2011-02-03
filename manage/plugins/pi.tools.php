<?php

/*
=====================================================
 File: pi.tools.php
-----------------------------------------------------
 Purpose: This class contains a number of useful tool
 like functions
=====================================================

*/



$plugin_info = array(
						'pi_name'			=> 'Tools',
						'pi_version'		=> '0.1',
						'pi_author'			=> 'Erskine Design',
						'pi_author_url'		=> 'http://erskinelabs.com/',
						'pi_description'	=> 'Helpful functions.',
						'pi_usage'			=> Tools::usage()
					);



class Tools {

    /** ----------------------------------------
    /**  Constructor
    /** ----------------------------------------*/

    function Tools()
    {
		
    }
    /* END */
    
    /** ----------------------------------------
    /**  URL Encoding function
    /** ----------------------------------------*/

    function Url_encode($str = '')
    {
        global $TMPL, $REGX;
        
        return urlencode($TMPL->tagdata);
		
    }
    /* END */
    
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>

<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
/* END */
}
// END CLASS
?>