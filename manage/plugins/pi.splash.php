<?php

$plugin_info = array(
						'pi_name'			=> 'Splash',
						'pi_version'		=> '1.0',
						'pi_author'			=> 'Matthew Krivanek',
						'pi_author_url'		=> 'http://www.sherpawebstudios.com',
						'pi_description'	=> 'Partying like it\'s 2000. Setup splash pages in Expression Engine.',
						'pi_usage'			=> Splash::usage()
					);

/**
 * Splash Class
 *
 * @package			ExpressionEngine
 * @category		Plugin
 * @author			Matthew Krivanek
 * @copyright		Copyright (c) 2010, Matthew Krivanek
 * @link			http://www.sherpawebstudios.com
 */

class Splash {
	
	var $return_data;			 						// Data sent back to Template parser

	var $location			= '';						// Splash page location
	var $show_again_after	= '';						// Show splash page after (in seconds)
	var $return_to			= '';						// Optional parameter if a redirect to a page other than the site's index is desired
	var $redirect_in		= '';						// Period between display of splash page and redirect (in seconds)
	
	
	/**
	 * Constructor
	 *
	 * @access	public
	 * @return	void
	 */
	
    function Splash() 
	{
		global $IN, $FNS, $TMPL;

		$location			= ( ! $TMPL->fetch_param('location'))			? '' : $TMPL->fetch_param('location');
		$show_again_after 	= ( ! $TMPL->fetch_param('show_again_after'))	? '' : $TMPL->fetch_param('show_again_after');
		$return_to 			= ( ! $TMPL->fetch_param('return_to')) 			? $FNS->fetch_site_index(0, 0) : $TMPL->fetch_param('return_to');		
		$redirect_in 		= ( ! $TMPL->fetch_param('redirect_in')) 		? '' : $TMPL->fetch_param('redirect_in');
		
		$cookie_prefix = "exp_";
		$cookie_name = 'splash_viewed';					// Name of cookie
		$cookie_value = TRUE;							// Value of cookie
		
		// Determine if this is the index page and check if the cookie has not been set
		if($location != '' && empty($_COOKIE[$cookie_prefix.$cookie_name]))
		{
			//Redirect to the splash page
			$FNS->redirect($FNS->fetch_site_index(1, 0).$location);
		}

		// If splash page has cookie expiration and redirect period assigned
		if($show_again_after != '' && $redirect_in != '')
		{
			// Store cookie with user-defined expiration
			$FNS->set_cookie($cookie_name, $cookie_value, $show_again_after);

			// Setup meta-redirect to return from splash page
			$this->return_data = '<meta http-equiv="refresh" content="'.$redirect_in.';url='.$return_to.'">';	
		}
    }


// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
This plugin will allow you to define a splash page and have it redirect to the page of your choosing. (By default, this page is the site's index page.)

STEP 1: Tell Splash where your splash page is located.

{exp:splash location="template_group/template"}

STEP 2: On your splash page, set parameters for Splash.

{exp:splash show_again_after="3600" redirect_in="5"}

show_again_after: How long (in seconds) till the splash page is displayed again to the user. 3600 = an hour. This value is stored in a cookie.
redirect_in: How long (in seconds) till the splash page redirects. 
* redirect_to: This is an optional field if you wish to have the splash page redirected to a page other than the site's index page.

* Optional parameters.
<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
/* END */


}
// END CLASS
?>