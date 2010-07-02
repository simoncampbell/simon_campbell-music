<?php if ( ! defined('EXT') ) exit('No direct script access allowed');
 
 /**
 * Solspace - User Module
 *
 * Brings EE member template functionality outside of those restricted templates, and into regular 
 * EE templates.
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
 * User Module Class - Control Panel
 *
 * The handler class for all control panel requests
 *
 * @package 	Solspace:User module
 * @author		Paul Burdick <paul.burdick@solspace.com>
 * @filesource 	./system/modules/user/mcp.user.php
 */
 
require_once 'mcp.user.base.php';

if (APP_VER < 2.0)
{
	eval('class User_CP extends User_cp_base { }');
}
else
{
	eval('class User_mcp extends User_cp_base { }');
}
?>