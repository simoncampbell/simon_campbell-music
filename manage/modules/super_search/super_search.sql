CREATE TABLE IF NOT EXISTS `exp_super_search_cache` (
`cache_id` int(15) unsigned NOT NULL AUTO_INCREMENT,
`site_id` int(10) unsigned NOT NULL DEFAULT '1',
`type` char(1) NOT NULL DEFAULT 'q',
`date` int(10) unsigned NOT NULL,
`results` smallint(7) unsigned NOT NULL DEFAULT '0',
`hash` varchar(32) NOT NULL,
`ids` mediumtext NOT NULL,
`query` mediumtext NOT NULL,
PRIMARY KEY (`cache_id`),
KEY `site_id` (`site_id`),
KEY `type` (`type`),
KEY `hash` (`hash`)) ;;

CREATE TABLE IF NOT EXISTS `exp_super_search_history` (
`history_id` int(15) unsigned NOT NULL AUTO_INCREMENT,
`cache_id` int(10) unsigned NOT NULL,
`member_id` int(10) unsigned NOT NULL,
`cookie_id` int(10) unsigned NOT NULL,
`ip_address` varchar(16) NOT NULL,
`site_id` int(10) unsigned NOT NULL DEFAULT '1',
`results` smallint(7) unsigned NOT NULL DEFAULT '0',
`search_name` varchar(250) NOT NULL,
`search_date` int(10) unsigned NOT NULL,
`saved` char(1) NOT NULL DEFAULT 'n',
`hash` varchar(32) NOT NULL,
`query` mediumtext NOT NULL,
PRIMARY KEY (`history_id`),
UNIQUE KEY `search_key` (`member_id`,`cookie_id`,`site_id`,`search_name`,`saved`),
KEY `cache_id` (`cache_id`),
KEY `member_id` (`member_id`),
KEY `site_id` (`site_id`));;

CREATE TABLE IF NOT EXISTS `exp_super_search_refresh_rules` (
`rule_id` int(10) unsigned NOT NULL auto_increment,
`site_id` int(10) unsigned NOT NULL default '1',
`date` int(10) unsigned NOT NULL,
`refresh` smallint(5) unsigned NOT NULL,
`template_id` int(10) unsigned NOT NULL default '0',
`weblog_id` int(10) unsigned NOT NULL default '0',
`category_group_id` int(10) unsigned NOT NULL default '0',
`member_id` int(10) unsigned NOT NULL,
PRIMARY KEY (rule_id),
KEY `site_id` (site_id),
KEY `template_id` (template_id),
KEY `weblog_id` (weblog_id),
KEY `category_group_id` (category_group_id)
) ;;