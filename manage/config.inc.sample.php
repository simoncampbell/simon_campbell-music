<?php

if ( ! defined('EXT')){
exit('Invalid file request');
}

/* EDIT THESE TO SUIT YOUR ENVIRONMENT
-----------------------------------------------------------------*/

$conf['db_hostname'] 	= "localhost";
$conf['db_username'] 	= "username";
$conf['db_password'] 	= "password";
$conf['db_name'] 		= "database_name";

$conf['site_url'] 		= "http://en-dev.local"; /* i.e. "http://virtualhost.local" */
$conf['document_root'] 	= $_SERVER['DOCUMENT_ROOT'];  /* This can be hardcoded is necessary */

$global_vars['ev_environment'] = 'local'; /* Can be development, local, or live */


?>