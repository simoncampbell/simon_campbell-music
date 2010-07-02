<?php

if ( ! defined('EXT')){
exit('Invalid file request');
}

/**
* Auto include the correct config file when local or on an Erskine server.
* For client servers, open terminal and type ping domain.com to get the
* IP of the server you are using for live, or dev if developing on a client stage
*/

switch ( $_SERVER['SERVER_ADDR'] ) {
    
    // localhost
    case '127.0.0.1': //most likely 127.0.0.1 on your machine
    require 'config.local.php'; // can be .local .dev or .live
    $global_vars['ev_environment'] = 'local';
    break;
    
    // Arnold
    case '89.145.77.67' :
    require 'config.dev.php'; // can be .local .dev or .live
    $global_vars['ev_environment'] = 'development';
    break;
    
    // Charles
    case '89.145.78.68' :
    require 'config.live.php'; // can be .local .dev or .live
    $global_vars['ev_environment'] = 'live';
    break;
    
}

?>