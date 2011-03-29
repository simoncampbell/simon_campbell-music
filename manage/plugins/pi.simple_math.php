<?php

/*
=====================================================
 This ExpressionEngine plugin was created by Laisvunas
 - http://expressionengine.com/forums/member/38398/
=====================================================
 Licensed under Creative Commons Attribution-Share Alike 3.0 Unported licence
 - http://creativecommons.org/licenses/by-sa/3.0/
=====================================================
 File: pi.simple_math.php
-----------------------------------------------------
 Purpose: provides support for mathematical operations 
 in templates.
=====================================================
*/


$plugin_info = array(
						'pi_name'			=> 'Simple Math',
						'pi_version'		=> '1.0.1',
						'pi_author'			=> 'Laisvunas Sopauskas',
						'pi_author_url'		=> 'http://www.classicsunlocked.net/',
						'pi_description'	=> 'Provides support for mathematical operations 
 in templates',
						'pi_usage'			=> Simple_math::usage()
					);


class Simple_math {

 	var $return_data;
 
 	function Simple_math()
 	{
  		global $TMPL, $DB;
  		
  		// Fetch parameters
  		$calculate = $TMPL->fetch_param('calculate');
  		$invalid_input = $TMPL->fetch_param('invalid_input');
  		
  		// Define variables
  		$found_invalid = FALSE;
  		$result = '';
  		
  		// "calculate" parameter is required
  		if ($calculate === FALSE)
  		{
      if ($invalid_input === 'alert')
      {
        echo 'ERROR! Parameter "calculate" of exp:simple_math tag not defined!<br><br>';
      }
      $found_invalid = TRUE;
    }
  		
  		if ($found_invalid === FALSE)
  		{
      $calculate = $DB->escape_str($calculate);
      //echo '1 $calculate: '.$calculate.'<br><br>';
    		$calculate = str_replace('&#47;', "/", $calculate);
    		//echo '2 $calculate: '.$calculate.'<br><br>';
    		$evalstring = '$result = '.$calculate.';';
    		@eval($evalstring);
    		//echo '$result: '.$result.'<br><br>';
    		$this->return_data = $result;
    }
    else
    {
      $this->return_data = '';
    }		
	}
	// END FUNCTION
	
	
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
PARAMETERS

1) calculate - Required. Alows you to input a string consisting of numbers,
symbols of mathematical operations and round brackets, e.g
calculate = "(10 + 5) / 3". Symbols of supported mathematical operations are:
+ (addition), - (subtraction), * (multiplication), / (division), 
% (division remainder), ++ (increment), -- (decrement).

2) invalid_input - Optional. Accepts two values: “alert” and “silence”.
Default value is “silence”. If the value is “alert”, then in cases when 
the plugin has some problem with parameters,  PHP alert is being shown;
if the value is “silence”, then in cases when the plugin has 
some problem with parameters, it finishes its work without any alert being shown. 
Set this parameter to “alert” for development, and to “silence” - for deployment.

USAGE

Use this plugin as folllows:

{exp:simple_math calculate="(10 + 5) / 3"}

<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
// END USAGE
}
// END CLASS
?>