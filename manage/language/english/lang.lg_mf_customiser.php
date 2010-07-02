<?php
/**
* Language file for LG Member Form Customiser
* 
* This file must be placed in the
* /system/language/english folder in your ExpressionEngine installation.
*
* @package LgMFCustomiser
* @version 1.1.0
* @author Leevi Graham <http://leevigraham.com>
* @copyright 2008
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-member-profile-customiser/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/
	$L = array(
		'lg_mfc_addon_name'			=> 'LG Member Form Customiser',
		'display_birthday' 			=> 'Display Birthday',
		'display_url' 				=> 'Display URL',
		'display_location' 			=> 'Display Location',
		'display_occupation' 		=> 'Display Occupation',
		'display_interests'		 	=> 'Display Interests',
		'display_aol' 				=> 'Display AOL IM',
		'display_icq' 				=> 'Display ICQ',
		'display_yahoo' 			=> 'Display Yahoo IM',
		'display_msn' 				=> 'Display MSN IM',
		'display_bio' 				=> 'Display Bio',
		'script_url'				=> 'URL to jQuery library file',
		'group_rules'				=> 'Group Rules',
		'group_rules_instructions'	=> 'Group rules <br /><span style=\'display:block; margin-top:9px; font-weight:normal;\'>Different member groups can now hide specific table rows. Each member group must be on a separate row in the following format: <code style=\'display:block; margin:9px 0\'>group_id:row_num|row_num|row_num</code> So to remove table rows 10 & 11 for group 1 and table rows 12 & 13 for group 3 the group rles would be: <code style=\'display:block; margin:9px 0\'>1:10|11<br />3:12|13</code></span>',
		'check_for_updates'			=> 'Would you like this extension to check for updates and display them on your CP homepage?',
		'cache_refresh'				=> 'How long would you like the update check cached for? <small>Number in minutes</small>',
		'default_member_fields' 	=> 'Default Member Fields',
		'global_removal' 			=> 'Selecting any of the fields below globally removes them from the member profile form.',
		'member_group_rules'		=> 'Member group rules',
		'group_rules_instructions'	=> "<p>Different member groups can be restricted to specific profile attributes. This is accomplished by removing unwanted profile attributes from the member profile form.</p>
		<p>To remove profile attributes from a group first declare the group id followed by a pipe delimited list of profile attribute rows separated by a colon.<p>
		<p>Each member group must and target profile attributes must be declared on a separate line. An example of this is:</p>
		<code style='display:block; margin:9px 0'>group_id:row_num|row_num|row_num</code>
		<p>So to remove atrributes 10 & 11 for group 1 and attributes 12 & 13 for group 3 the group rules would be:</p>
		<code style='display:block; margin:9px 0'>1:10|11<br />3:12|13</code>",
		'path_to_jquery'			=> 'Path to the jQuery library',
		'path_to_jquery_instructions'	=> 'This extension requires jQuery to work correctly.',
		'jquery'					=> 'jQuery'
	);
?>