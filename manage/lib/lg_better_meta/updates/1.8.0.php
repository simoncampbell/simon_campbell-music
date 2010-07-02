<?php
/**
* Update script for LG Better Meta
* 
* This file must be placed in the
* /system/extensions/lg_better_meta/updates folder in your ExpressionEngine installation.
*
* Must be called in context of Lg_better_meta (ext.lg_better_meta.php) e.g.
* function update_extension() {
*	if ($version < '1.8.0') {
*		include(...'lg_better_meta/updates/1.8.0.php');
*	}
* }
* @package LgBetterMeta
* @version Version 1.9.1
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement
*/

// get all settings
$settings = $this->_get_settings(TRUE, TRUE);

$show_fields_per_weblog = array(
		'title', 'description', 'keywords', 'author',
		'publisher', 'rights',
		'robots' => 'robots_meta', 'sitemap' => 'sitemap_meta',
		'canonical_url', 'geo_meta',
	);

// for each site
foreach ($settings as $site => $site_settings) 
{
	$settings[$site]['region'] = '';
	$settings[$site]['placename'] = '';
	$settings[$site]['latitude'] = '';
	$settings[$site]['longitude'] = '';
	
	$settings[$site]['enabled'] = $settings[$site]['enable'];
	$settings[$site]['enable'];

	unset($settings[$site]['show_donate']);
	unset($settings[$site]['show_promos']);

	$s_weblogs = array();
	$query = $DB->query("SELECT * FROM exp_weblogs WHERE site_id = '" . $DB->escape_str($site) . "'");
	if ($query->num_rows > 0)
	{
		foreach($query->result as $row)
		{
			$s_weblogs[$row['weblog_id']]['show_tab'] = in_array($row['weblog_id'], $site_settings['weblogs']) ? 'y' : 'n';
			foreach ($show_fields_per_weblog as $old_name => $new_name) {
				if (is_numeric($old_name)) $old_name = $new_name;
				$s_weblogs[$row['weblog_id']]['show_' . $new_name] = isset($site_settings['show_'.$old_name]) ? $site_settings['show_'.$old_name] : 'n';
			}

			$fields = array(
					'include_in_sitemap' => 'y',
					'change_frequency' => 'Weekly',
					'priority' => '0.5',
				);
			foreach ($fields as $field => $default) {
				$val = $default;
				if (isset($site_settings['sitemap_defaults'][$row['weblog_id']][$field]))
					$val = $site_settings['sitemap_defaults'][$row['weblog_id']][$field];
				$s_weblogs[$row['weblog_id']][$field] = $val;
			}
		}
	}
	
	$settings[$site]['weblogs'] = $s_weblogs;
	unset($settings[$site]['sitemap_defaults']);
	
	foreach ($show_fields_per_weblog as $old_name => $new_name) {
		if (is_numeric($old_name)) $old_name = $new_name;
		unset($settings[$site]['show_' . $old_name]);
	}
}

// update the settings
$sql[] = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . get_class($this) . "'";

$sql[] = $DB->insert_string( 'exp_extensions', 
								array('extension_id' 	=> '',
									'class'			=> get_class($this),
									'method'		=> 'publish_form_start',
									'hook'			=> 'publish_form_start',
									'priority'		=> 10,
									'version'		=> $this->version,
									'enabled'		=> "y",
									'settings'		=> addslashes(serialize($settings)),
								)
							);

// add the priority, change frequency and include_in_sitemap cols to the meta table
$sql[] = "ALTER TABLE exp_lg_better_meta
			ADD `canonical_url` VARCHAR( 255 ) NOT NULL,
			ADD `region` VARCHAR( 255 ) NOT NULL ,
			ADD `placename` VARCHAR( 255 ) NOT NULL ,
			ADD `latitude` VARCHAR( 25 ) NOT NULL ,
			ADD `longitude` VARCHAR( 25 ) NOT NULL ,
			ADD `append_default_keywords` TINYINT( 1 ) NOT NULL";


// run all sql queries
foreach ($sql as $query)
{
	$DB->query($query);
}

// set the objects settings to the current site
$this->settings = $settings[$PREFS->ini('site_id')];
