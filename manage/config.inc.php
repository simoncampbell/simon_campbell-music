<?php

if ( ! defined('EXT')){
exit('Invalid file request');
}

/* EDIT THESE TO SUIT YOUR ENVIRONMENT
-----------------------------------------------------------------*/

$conf['db_hostname'] 	= "localhost";
$conf['db_username'] 	= "root";
$conf['db_password'] 	= "";
$conf['db_name'] 		= "erskine_simoncampbell_music";

$conf['site_url'] 		= "http://sc-music.local"; /* i.e. "http://virtualhost.local" */
$conf['document_root'] 	= $_SERVER['DOCUMENT_ROOT'];  /* This can be hardcoded is necessary */

$global_vars['ev_environment'] = 'local'; /* Can be development, local, or live */


?>