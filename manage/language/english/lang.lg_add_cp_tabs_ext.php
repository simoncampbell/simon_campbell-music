<?php
/**
* Class file for LG Add CP Tabs
* 
* This file must be placed in the
* /system/extensions/ folder in your ExpressionEngine installation.
*
* @package LgAddCPTabs
* @version 1.0.0
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-add-cp-tabs/
* @copyright Copyright (c) 2007-2008 Leevi Graham
* @license http://creativecommons.org/licenses/by-sa/3.0/ Creative Commons Attribution-Share Alike 3.0 Unported
*/

$L = array(

	"lg_add_cp_tabs_title" => "LG Add CP Tabs",

	'access_rights' => 'Extension Access',
	'enable_extension_for_this_site' => 'Enable LG Add CP Tabs extension for this site?',
	
	'member_groups_default_tabs' => 'Member groups default tabs',
	'member_groups_tab_info' 	=> "<p>Default tabs can be assigned to a member group. Each time a new member for the group is created new CP tabs will be created.</p>
									<p style='margin-top:18px'>Tabs must be declared in the following format: Example: 
									<p style='margin-top:18px'><code>tab_name|cp_url|sort_order</code></p>
									<p style='margin-top:18px'><code>Extensions|C=admin&M=utilities&P=extensions_manager|1</code></p>
									<p style='margin-top:18px'>Multiple tabs must be separated by a line break. Example:</p>
									<p style='margin-top:18px'><code>Extensions|C=admin&M=utilities&P=extensions_manager|1<br />LG Quarantine|C=modules&M=Lg_quarantine|2</code></p>",

	'member_groups_default_links' => 'Member groups default links',
	'member_groups_link_info' 	=> "<p>Default links can be assigned to a member group. Each time a new member for the group is created new CP quick links will be created.</p>
									<p style='margin-top:18px'>Links must be declared in the following format: Example: 
									<p style='margin-top:18px'><code>link_text|url|sort_order</code></p>
									<p style='margin-top:18px'><code>My Site|http://ee.sandbox/index.php|1</code></p>
									<p style='margin-top:18px'>Multiple links must be separated by a line break. Example:</p>
									<p style='margin-top:18px'><code>My Site|http://site1.com/index.php|1<br />My Other Site|http://site2.com/index.php|2</code></p>",

	'check_for_updates_title' 	=> 'Check for updates?',
	'check_for_updates_info' 	=> 'LG Add CP Tabs can call home (<a href="http://leevigraham.com/">http://leevigraham.com</a>) and check for recent updates.',
	'check_for_updates_warning'	=> 'This feature requires <a href="http://leevigraham.com/cms-customisation/lg-addon-updater/">LG Addon Updater</a> to be installed and activated.',
	'check_for_updates_label' 	=> 'Would you like this extension to check for updates and display them on your CP homepage?',
	'cache_refresh_label' 		=> 'How many minutes you like the update check cached for?',

	'donation'					=> 'This extension was developed by <a href="http://leevigraham.com">Leevi Graham</a>. <br />Support its development by donating.',
	'lg_admin_title'			=> 'LG Admin Options',
	'show_donate_label'			=> 'Show the donation link at the top of the settings page?',
	'show_promos_label'			=> 'Show promos at the top of the settings page?',

	// END
	''=>''
);
?>