# Sequel Pro dump
# Version 2210
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.41-3ubuntu12.8)
# Database: simoncampbell_music
# Generation Time: 2011-02-03 09:07:33 +0000
# ************************************************************

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table exp_actions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_actions`;

CREATE TABLE `exp_actions` (
  `action_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) NOT NULL,
  `method` varchar(50) NOT NULL,
  PRIMARY KEY (`action_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1017 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_actions` WRITE;
/*!40000 ALTER TABLE `exp_actions` DISABLE KEYS */;
INSERT INTO `exp_actions` (`action_id`,`class`,`method`)
VALUES
	(1,'Comment','insert_new_comment'),
	(2,'Comment_CP','delete_comment_notification'),
	(6,'Member','registration_form'),
	(7,'Member','register_member'),
	(8,'Member','activate_member'),
	(9,'Member','member_login'),
	(10,'Member','member_logout'),
	(11,'Member','retrieve_password'),
	(12,'Member','reset_password'),
	(13,'Member','send_member_email'),
	(14,'Member','update_un_pw'),
	(15,'Member','member_search'),
	(16,'Member','member_delete'),
	(18,'Weblog','insert_new_entry'),
	(19,'Search','do_search'),
	(23,'Email','send_email'),
	(24,'Super_search','save_search'),
	(25,'User','group_edit'),
	(26,'User','edit_profile'),
	(27,'User','reg'),
	(28,'User','reassign_jump'),
	(29,'User','retrieve_password'),
	(30,'User','do_search'),
	(31,'User','delete_account'),
	(32,'User','activate_member'),
	(33,'User','retrieve_username'),
	(34,'User','create_key'),
	(35,'Pur_member_utilities_CP','get_member_data'),
	(1001,'Cartthrob','_checkout'),
	(1002,'Cartthrob','_add_to_cart_form_submit'),
	(1003,'Cartthrob','_coupon_code_form_submit'),
	(1004,'Cartthrob','_update_item_submit'),
	(1005,'Cartthrob','_delete_from_cart_submit'),
	(1006,'Cartthrob','_save_customer_info_submit'),
	(1007,'Cartthrob','_update_cart_submit'),
	(1008,'Cartthrob','_ajax_action'),
	(1009,'Cartthrob','_jquery_plugin_action'),
	(1010,'Cartthrob','_multi_add_to_cart_form_submit'),
	(1011,'Cartthrob','payment_return'),
	(1012,'Cartthrob','_download_file_form_submit'),
	(1013,'Freeform','insert_new_entry'),
	(1014,'Freeform','retrieve_entries'),
	(1015,'Freeform_CP','delete_freeform_notification'),
	(1016,'Freeform','delete_freeform_notification');

/*!40000 ALTER TABLE `exp_actions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_captcha
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_captcha`;

CREATE TABLE `exp_captcha` (
  `captcha_id` bigint(13) unsigned NOT NULL AUTO_INCREMENT,
  `date` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `word` varchar(20) NOT NULL,
  PRIMARY KEY (`captcha_id`),
  KEY `word` (`word`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_categories
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_categories`;

CREATE TABLE `exp_categories` (
  `cat_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(6) unsigned NOT NULL,
  `parent_id` int(4) unsigned NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `cat_url_title` varchar(75) NOT NULL,
  `cat_description` text NOT NULL,
  `cat_image` varchar(120) NOT NULL,
  `cat_order` int(4) unsigned NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `group_id` (`group_id`),
  KEY `cat_name` (`cat_name`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=56 DEFAULT CHARSET=latin1;



# Dump of table exp_category_field_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_category_field_data`;

CREATE TABLE `exp_category_field_data` (
  `cat_id` int(4) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(4) unsigned NOT NULL,
  PRIMARY KEY (`cat_id`),
  KEY `site_id` (`site_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_category_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_category_fields`;

CREATE TABLE `exp_category_fields` (
  `field_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(4) unsigned NOT NULL,
  `field_name` varchar(32) NOT NULL DEFAULT '',
  `field_label` varchar(50) NOT NULL DEFAULT '',
  `field_type` varchar(12) NOT NULL DEFAULT 'text',
  `field_list_items` text NOT NULL,
  `field_maxl` smallint(3) NOT NULL DEFAULT '128',
  `field_ta_rows` tinyint(2) NOT NULL DEFAULT '8',
  `field_default_fmt` varchar(40) NOT NULL DEFAULT 'none',
  `field_show_fmt` char(1) NOT NULL DEFAULT 'y',
  `field_text_direction` char(3) NOT NULL DEFAULT 'ltr',
  `field_required` char(1) NOT NULL DEFAULT 'n',
  `field_order` int(3) unsigned NOT NULL,
  PRIMARY KEY (`field_id`),
  KEY `site_id` (`site_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_category_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_category_groups`;

CREATE TABLE `exp_category_groups` (
  `group_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) NOT NULL,
  `sort_order` char(1) NOT NULL DEFAULT 'a',
  `field_html_formatting` char(4) NOT NULL DEFAULT 'all',
  `can_edit_categories` text NOT NULL,
  `can_delete_categories` text NOT NULL,
  `is_user_blog` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;



# Dump of table exp_category_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_category_posts`;

CREATE TABLE `exp_category_posts` (
  `entry_id` int(10) unsigned NOT NULL,
  `cat_id` int(10) unsigned NOT NULL,
  KEY `entry_id` (`entry_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_comments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_comments`;

CREATE TABLE `exp_comments` (
  `comment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `entry_id` int(10) unsigned NOT NULL DEFAULT '0',
  `weblog_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `status` char(1) NOT NULL DEFAULT 'o',
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `url` varchar(75) NOT NULL,
  `location` varchar(50) NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `comment_date` int(10) NOT NULL,
  `edit_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `comment` text NOT NULL,
  `notify` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`comment_id`),
  KEY `entry_id` (`entry_id`),
  KEY `weblog_id` (`weblog_id`),
  KEY `author_id` (`author_id`),
  KEY `status` (`status`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_cp_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_cp_log`;

CREATE TABLE `exp_cp_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) unsigned NOT NULL,
  `username` varchar(32) NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `act_date` int(10) NOT NULL,
  `action` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=302 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_cp_log` WRITE;
/*!40000 ALTER TABLE `exp_cp_log` DISABLE KEYS */;
INSERT INTO `exp_cp_log` (`id`,`site_id`,`member_id`,`username`,`ip_address`,`act_date`,`action`)
VALUES
	(1,1,1,'jamiepittock','88.97.41.226',1246624426,'Logged in'),
	(2,1,1,'jamiepittock','88.97.41.226',1246626030,'Channel Deleted:&nbsp;&nbsp;Default Site Weblog'),
	(3,1,1,'jamiepittock','88.97.41.226',1246626056,'Category Group Deleted:&nbsp;&nbsp;Default Category Group'),
	(4,1,1,'jamiepittock','88.97.41.226',1246626069,'Field group Deleted:&nbsp;&nbsp;Default Field Group'),
	(5,1,1,'jamiepittock','88.97.41.226',1246626095,'Upload Preference Deleted:&nbsp;&nbsp;Main Upload Directory'),
	(6,1,1,'jamiepittock','88.97.41.226',1246807660,'Logged in'),
	(7,1,1,'jamiepittock','88.97.41.226',1246819334,'Logged in'),
	(8,1,1,'jamiepittock','88.97.41.226',1246821151,'Field Group Created:&nbsp;&nbsp;News'),
	(9,1,1,'jamiepittock','88.97.41.226',1246821202,'Channel Created:&nbsp;&nbsp;News'),
	(10,1,1,'jamiepittock','88.97.41.226',1246821252,'Channel Deleted:&nbsp;&nbsp;News'),
	(11,1,1,'jamiepittock','88.97.41.226',1246821405,'Field group Deleted:&nbsp;&nbsp;News'),
	(12,1,1,'jamiepittock','88.97.41.224',1246872098,'Logged in'),
	(13,1,1,'jamiepittock','88.97.41.224',1246872194,'Member profile created:&nbsp;&nbsp;glenswinfield'),
	(14,1,1,'jamiepittock','88.97.41.224',1246872223,'Member profile created:&nbsp;&nbsp;gregwood'),
	(15,1,1,'jamiepittock','88.97.41.224',1246872266,'Member profile created:&nbsp;&nbsp;simoncollison'),
	(16,1,1,'jamiepittock','88.97.41.224',1246872292,'Member profile created:&nbsp;&nbsp;philswan'),
	(17,1,1,'jamiepittock','88.97.41.224',1246873591,'Member profile created:&nbsp;&nbsp;glenswinfield'),
	(18,1,1,'jamiepittock','88.97.41.224',1246873601,'SuperAdmin Logging In as User:&nbsp;glenswinfield'),
	(19,1,6,'glenswinfield','88.97.41.224',1246873640,'Member profile created:&nbsp;&nbsp;gregwood'),
	(20,1,6,'glenswinfield','88.97.41.224',1246873664,'Member profile created:&nbsp;&nbsp;philswan'),
	(21,1,6,'glenswinfield','88.97.41.224',1246873690,'Member profile created:&nbsp;&nbsp;simoncollison'),
	(22,1,6,'glenswinfield','88.97.41.224',1246876441,'Logged out'),
	(23,1,1,'jamiepittock','88.97.41.224',1246876449,'Logged in'),
	(24,1,1,'jamiepittock','88.97.41.224',1246894108,'Logged in'),
	(25,1,1,'jamiepittock','88.97.41.226',1246974613,'Logged in'),
	(26,1,1,'jamiepittock','127.0.0.1',1248023252,'Logged in'),
	(27,1,1,'jamiepittock','127.0.0.1',1248031260,'Logged in'),
	(28,1,1,'jamiepittock','127.0.0.1',1249281318,'Logged in'),
	(29,1,1,'jamiepittock','127.0.0.1',1249282300,'Logged in'),
	(30,1,1,'jamiepittock','127.0.0.1',1251810294,'Logged in'),
	(31,1,1,'jamiepittock','127.0.0.1',1251810341,'Member Group Created:&nbsp;&nbsp;Admin'),
	(32,1,1,'jamiepittock','127.0.0.1',1265120968,'Logged in'),
	(33,1,1,'jamiepittock','127.0.0.1',1265121233,'Member profile created:&nbsp;&nbsp;willinssen'),
	(34,1,1,'jamiepittock','127.0.0.1',1265133836,'SuperAdmin Logging In as User:&nbsp;willinssen'),
	(35,1,10,'willinssen','127.0.0.1',1265133929,'SuperAdmin Logging In as User:&nbsp;simoncollison'),
	(36,1,9,'simoncollison','127.0.0.1',1265133977,'Logged out'),
	(37,1,1,'jamiepittock','127.0.0.1',1265133983,'Logged in'),
	(38,1,1,'jamiepittock','127.0.0.1',1265134003,'SuperAdmin Logging In as User:&nbsp;philswan'),
	(39,1,8,'philswan','127.0.0.1',1265134044,'SuperAdmin Logging In as User:&nbsp;gregwood'),
	(40,1,7,'gregwood','127.0.0.1',1265134082,'SuperAdmin Logging In as User:&nbsp;glenswinfield'),
	(41,1,6,'glenswinfield','127.0.0.1',1265134117,'Logged out'),
	(42,1,6,'glenswinfield','0.0.0.0',1266063863,'Logged in'),
	(43,1,6,'glenswinfield','0.0.0.0',1272364961,'Logged in'),
	(44,1,6,'glenswinfield','0.0.0.0',1272365753,'Username was changed to:&nbsp;&nbsp;wil.linssen\n'),
	(45,1,6,'glenswinfield','0.0.0.0',1272449782,'Logged in'),
	(46,1,1,'jamiepittock','127.0.0.1',1276451271,'Logged in'),
	(47,1,1,'jamiepittock','127.0.0.1',1276451842,'Logged in'),
	(48,1,1,'jamiepittock','127.0.0.1',1276454053,'Field Group Created:&nbsp;&nbsp;Homepage banners'),
	(49,1,1,'jamiepittock','127.0.0.1',1276454180,'Field Group Created:&nbsp;&nbsp;Homepage intros'),
	(50,1,1,'jamiepittock','127.0.0.1',1276454463,'Channel Created:&nbsp;&nbsp;Homepage banners'),
	(51,1,1,'jamiepittock','127.0.0.1',1276454536,'Channel Created:&nbsp;&nbsp;Homepage intros'),
	(52,1,1,'jamiepittock','127.0.0.1',1276454708,'Field Group Created:&nbsp;&nbsp;Issues'),
	(53,1,1,'jamiepittock','127.0.0.1',1276455685,'Upload Preference Deleted:&nbsp;&nbsp;Audio Files'),
	(54,1,1,'jamiepittock','127.0.0.1',1276455690,'Upload Preference Deleted:&nbsp;&nbsp;Video Files'),
	(55,1,1,'jamiepittock','127.0.0.1',1276455692,'Upload Preference Deleted:&nbsp;&nbsp;Images'),
	(56,1,1,'jamiepittock','127.0.0.1',1276455959,'Field Group Created:&nbsp;&nbsp;Author profiles'),
	(57,1,1,'jamiepittock','127.0.0.1',1276456208,'Channel Created:&nbsp;&nbsp;Issues'),
	(58,1,1,'jamiepittock','127.0.0.1',1276456279,'Channel Created:&nbsp;&nbsp;Author profiles'),
	(59,1,1,'jamiepittock','127.0.0.1',1276456375,'Field Group Created:&nbsp;&nbsp;Sources'),
	(60,1,1,'jamiepittock','127.0.0.1',1276456671,'Channel Created:&nbsp;&nbsp;Sources'),
	(61,1,1,'jamiepittock','127.0.0.1',1276457013,'Field Group Created:&nbsp;&nbsp;Media - News'),
	(62,1,1,'jamiepittock','127.0.0.1',1276457308,'Channel Created:&nbsp;&nbsp;Media: News'),
	(63,1,1,'jamiepittock','127.0.0.1',1276457432,'Field Group Created:&nbsp;&nbsp;Media - Documents'),
	(64,1,1,'jamiepittock','127.0.0.1',1276457599,'Channel Created:&nbsp;&nbsp;Media: Documents'),
	(65,1,1,'jamiepittock','127.0.0.1',1276457637,'Field Group Created:&nbsp;&nbsp;Media - Videos'),
	(66,1,1,'jamiepittock','127.0.0.1',1276457869,'Channel Created:&nbsp;&nbsp;Media: Videos'),
	(67,1,1,'jamiepittock','127.0.0.1',1276459070,'Category Group Created:&nbsp;&nbsp;US states'),
	(68,1,1,'jamiepittock','127.0.0.1',1276459187,'Field Group Created:&nbsp;&nbsp;Ecommunications'),
	(69,1,1,'jamiepittock','127.0.0.1',1276459196,'Field Group Created:&nbsp;&nbsp;Press releases'),
	(70,1,1,'jamiepittock','127.0.0.1',1276459207,'Field Group Created:&nbsp;&nbsp;Pages'),
	(71,1,1,'jamiepittock','127.0.0.1',1276459308,'Channel Created:&nbsp;&nbsp;Press releases'),
	(72,1,1,'jamiepittock','127.0.0.1',1276459380,'Channel Created:&nbsp;&nbsp;Ecommunications'),
	(73,1,1,'jamiepittock','127.0.0.1',1276460515,'Channel Created:&nbsp;&nbsp;About Pages'),
	(74,1,1,'jamiepittock','127.0.0.1',1276462464,'Member profile created:&nbsp;&nbsp;admin'),
	(75,1,1,'jamiepittock','127.0.0.1',1276463118,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(76,1,11,'admin','88.97.41.226',1276464634,'Logged in'),
	(77,1,1,'jamiepittock','89.194.100.70',1276522604,'Logged in'),
	(78,1,10,'wil.linssen','88.97.41.224',1276522698,'Logged in'),
	(79,1,6,'glenswinfield','88.97.41.224',1276525403,'Logged in'),
	(80,1,1,'jamiepittock','89.194.98.159',1276525854,'Logged in'),
	(81,1,1,'jamiepittock','127.0.0.1',1276678609,'Logged in'),
	(82,1,1,'jamiepittock','127.0.0.1',1276685111,'Member Group Created:&nbsp;&nbsp;Experts'),
	(83,1,1,'jamiepittock','127.0.0.1',1276685464,'Channel Deleted:&nbsp;&nbsp;Profiles: Authors/experts'),
	(84,1,1,'jamiepittock','127.0.0.1',1276685483,'Field group Deleted:&nbsp;&nbsp;Author profiles'),
	(85,1,1,'jamiepittock','127.0.0.1',1276689501,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(86,1,1,'jamiepittock','127.0.0.1',1276694107,'Logged in'),
	(87,1,1,'jamiepittock','88.97.41.226',1276695729,'Logged in'),
	(88,1,1,'jamiepittock','88.97.41.226',1276695841,'SuperAdmin Logging In as User:&nbsp;admin'),
	(89,1,11,'admin','76.99.35.250',1276696817,'Logged in'),
	(90,1,1,'jamiepittock','88.97.41.226',1276705470,'Logged in'),
	(91,1,1,'jamiepittock','127.0.0.1',1276712853,'Logged in'),
	(92,1,1,'Member Utilities','127.0.0.1',1276713178,'User jamiepittock has updated their profile'),
	(93,1,1,'jamiepittock','127.0.0.1',1276713268,'Custom Field Deleted:&nbsp;&nbsp;PDF'),
	(94,1,1,'jamiepittock','127.0.0.1',1276751194,'Logged in'),
	(95,1,1,'Member Utilities','127.0.0.1',1276752093,'User jamiepittock has updated their profile'),
	(96,1,1,'Member Utilities','127.0.0.1',1276752541,'User jamiepittock has updated their profile'),
	(97,1,1,'jamiepittock','127.0.0.1',1276752952,'Logged out'),
	(98,1,1,'jamiepittock','127.0.0.1',1276752978,'Logged in'),
	(99,1,1,'Member Utilities','127.0.0.1',1276754921,'User jamiepittock has updated their profile'),
	(100,1,1,'jamiepittock','127.0.0.1',1276756337,'Logged out'),
	(101,1,1,'jamiepittock','127.0.0.1',1276756342,'Logged in'),
	(102,1,1,'jamiepittock','127.0.0.1',1276756431,'Logged in'),
	(103,1,1,'jamiepittock','127.0.0.1',1276760981,'Logged in'),
	(104,1,1,'jamiepittock','88.97.41.224',1276764438,'Logged in'),
	(105,1,1,'jamiepittock','88.97.41.224',1276769247,'SuperAdmin Logging In as User:&nbsp;admin'),
	(106,1,11,'admin','88.97.41.224',1276769747,'Logged out'),
	(107,1,1,'jamiepittock','88.97.41.224',1276769754,'Logged in'),
	(108,1,1,'jamiepittock','127.0.0.1',1276785004,'Member profile created:&nbsp;&nbsp;test-expert'),
	(109,1,1,'Member Utilities','127.0.0.1',1276785091,'User jamiepittock has updated their profile'),
	(110,1,1,'jamiepittock','127.0.0.1',1276787912,'Logged in'),
	(111,1,1,'Member Utilities','127.0.0.1',1276790938,'User jamiepittock has updated their profile'),
	(112,1,1,'jamiepittock','127.0.0.1',1277099733,'Logged in'),
	(113,1,1,'jamiepittock','127.0.0.1',1277101042,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(114,1,1,'jamiepittock','127.0.0.1',1277101048,'Member Group Updated:&nbsp;&nbsp;Banned'),
	(115,1,1,'jamiepittock','127.0.0.1',1277101066,'Member Group Updated:&nbsp;&nbsp;Experts'),
	(116,1,1,'jamiepittock','127.0.0.1',1277101087,'Member Group Updated:&nbsp;&nbsp;Members'),
	(117,1,1,'jamiepittock','127.0.0.1',1277101102,'Member Group Updated:&nbsp;&nbsp;Banned'),
	(118,1,1,'jamiepittock','127.0.0.1',1277133121,'Logged in'),
	(119,1,1,'jamiepittock','127.0.0.1',1277133431,'Member profile created:&nbsp;&nbsp;anne-expert'),
	(120,1,1,'Member Utilities','127.0.0.1',1277134045,'User jamiepittock has updated their profile'),
	(121,1,1,'jamiepittock','127.0.0.1',1277183429,'Logged in'),
	(122,1,1,'Member Utilities','127.0.0.1',1277183647,'User jamiepittock has updated their profile'),
	(123,1,1,'jamiepittock','127.0.0.1',1277200735,'Logged in'),
	(124,1,1,'jamiepittock','127.0.0.1',1277207836,'Logged in'),
	(125,1,1,'jamiepittock','127.0.0.1',1277207875,'Field Group Created:&nbsp;&nbsp;Companies'),
	(126,1,1,'jamiepittock','127.0.0.1',1277208436,'Channel Created:&nbsp;&nbsp;11 - Companies'),
	(127,1,1,'jamiepittock','127.0.0.1',1277208657,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(128,1,1,'jamiepittock','127.0.0.1',1277208745,'Category Group Created:&nbsp;&nbsp;Companies'),
	(129,1,1,'jamiepittock','127.0.0.1',1277221800,'Custom Field Deleted:&nbsp;&nbsp;Brightcove video ID'),
	(130,1,1,'jamiepittock','127.0.0.1',1277221803,'Custom Field Deleted:&nbsp;&nbsp;Video heading'),
	(131,1,1,'jamiepittock','127.0.0.1',1277221808,'Custom Field Deleted:&nbsp;&nbsp;Videos transcript'),
	(132,1,1,'jamiepittock','127.0.0.1',1277221811,'Custom Field Deleted:&nbsp;&nbsp;Video expert'),
	(133,1,1,'jamiepittock','127.0.0.1',1277225376,'Logged in'),
	(134,1,1,'jamiepittock','127.0.0.1',1277225689,'Custom Field Deleted:&nbsp;&nbsp;Personal impact heading'),
	(135,1,1,'jamiepittock','127.0.0.1',1277225693,'Custom Field Deleted:&nbsp;&nbsp;Personal impact statistic'),
	(136,1,1,'jamiepittock','127.0.0.1',1277225696,'Custom Field Deleted:&nbsp;&nbsp;Personal impact statement'),
	(137,1,1,'jamiepittock','127.0.0.1',1277227381,'Custom Field Deleted:&nbsp;&nbsp;Brightcove video ID'),
	(138,1,1,'jamiepittock','127.0.0.1',1277227385,'Custom Field Deleted:&nbsp;&nbsp;Video transcript'),
	(139,1,1,'jamiepittock','88.97.41.226',1277237927,'Logged in'),
	(140,1,1,'jamiepittock','89.194.97.99',1277276985,'Logged in'),
	(141,1,12,'amacdowell','12.170.156.2',1277324359,'Logged in'),
	(142,1,1,'jamiepittock','89.194.0.180',1277331588,'Logged in'),
	(143,1,1,'jamiepittock','127.0.0.1',1277452140,'Logged in'),
	(144,1,1,'jamiepittock','127.0.0.1',1277475292,'Logged in'),
	(145,1,1,'jamiepittock','127.0.0.1',1277477718,'Logged in'),
	(146,1,1,'jamiepittock','127.0.0.1',1277480017,'Logged out'),
	(147,1,1,'jamiepittock','127.0.0.1',1277480022,'Logged in'),
	(148,1,1,'jamiepittock','127.0.0.1',1277480209,'Logged in'),
	(149,1,1,'jamiepittock','127.0.0.1',1277717807,'Logged in'),
	(150,1,1,'jamiepittock','127.0.0.1',1277718028,'Logged in'),
	(151,1,1,'jamiepittock','127.0.0.1',1277718123,'Logged in'),
	(152,1,12,'amacdowell','12.170.156.2',1277721358,'Logged in'),
	(153,1,1,'jamiepittock','88.97.41.224',1277721796,'Logged in'),
	(154,1,1,'jamiepittock','88.97.41.224',1277723680,'Logged in'),
	(155,1,12,'amacdowell','12.170.156.2',1277727983,'Logged in'),
	(156,1,11,'admin','71.206.168.11',1277730847,'Logged in'),
	(157,1,1,'jamiepittock','127.0.0.1',1277788687,'Logged in'),
	(158,1,1,'jamiepittock','127.0.0.1',1277789138,'Custom Field Deleted:&nbsp;&nbsp;Video alternative'),
	(159,1,1,'Member Utilities','127.0.0.1',1277793635,'User jamiepittock has updated their profile'),
	(160,1,1,'jamiepittock','127.0.0.1',1277794814,'Logged out'),
	(161,1,1,'jamiepittock','127.0.0.1',1277794842,'Logged in'),
	(162,1,1,'jamiepittock','88.97.41.224',1277800632,'Logged in'),
	(163,1,1,'jamiepittock','88.97.41.224',1277800646,'Logged out'),
	(164,1,1,'jamiepittock','88.97.41.224',1277800688,'Logged in'),
	(165,1,12,'amacdowell','68.48.105.10',1277804883,'Logged in'),
	(166,1,1,'jamiepittock','88.97.41.224',1277818926,'Logged in'),
	(167,1,12,'amacdowell','12.170.156.2',1277821100,'Logged in'),
	(168,1,11,'admin','71.206.168.11',1277822628,'Logged in'),
	(169,1,1,'jamiepittock','88.97.41.226',1277900167,'Logged in'),
	(170,1,1,'jamiepittock','88.97.41.226',1277928038,'Logged in'),
	(171,1,12,'amacdowell','12.170.156.2',1277928619,'Logged in'),
	(172,1,1,'jamiepittock','88.97.41.226',1277929619,'Custom Field Deleted:&nbsp;&nbsp;Confirmation text'),
	(173,1,1,'jamiepittock','88.97.41.226',1277929624,'Custom Field Deleted:&nbsp;&nbsp;Thankyou text'),
	(174,1,1,'jamiepittock','88.97.41.226',1277933663,'Logged in'),
	(175,1,1,'jamiepittock','127.0.0.1',1277962882,'Logged in'),
	(176,1,1,'jamiepittock','127.0.0.1',1277964313,'Logged out'),
	(177,1,1,'jamiepittock','127.0.0.1',1277964562,'Logged in'),
	(178,1,1,'jamiepittock','127.0.0.1',1277964647,'Logged in'),
	(179,1,1,'jamiepittock','127.0.0.1',1277965154,'Logged in'),
	(180,1,1,'jamiepittock','127.0.0.1',1277970512,'Member profile created:&nbsp;&nbsp;energynation-team'),
	(181,1,1,'jamiepittock','127.0.0.1',1277977959,'Logged out'),
	(182,1,1,'jamiepittock','127.0.0.1',1277977992,'Logged in'),
	(183,1,1,'jamiepittock','127.0.0.1',1278085999,'Logged in'),
	(184,1,1,'jamiepittock','127.0.0.1',1278086014,'Channel Deleted:&nbsp;&nbsp;01 - Homepage: Banners'),
	(185,1,1,'jamiepittock','127.0.0.1',1278086017,'Channel Deleted:&nbsp;&nbsp;02 - Homepage: Intros'),
	(186,1,1,'jamiepittock','127.0.0.1',1278086020,'Channel Deleted:&nbsp;&nbsp;03 - Issues'),
	(187,1,1,'jamiepittock','127.0.0.1',1278086023,'Channel Deleted:&nbsp;&nbsp;04 - Media: News'),
	(188,1,1,'jamiepittock','127.0.0.1',1278086026,'Channel Deleted:&nbsp;&nbsp;05 - Media: Documents'),
	(189,1,1,'jamiepittock','127.0.0.1',1278086028,'Channel Deleted:&nbsp;&nbsp;06 - Media: Stories'),
	(190,1,1,'jamiepittock','127.0.0.1',1278086031,'Channel Deleted:&nbsp;&nbsp;07 - Sources'),
	(191,1,1,'jamiepittock','127.0.0.1',1278086034,'Channel Deleted:&nbsp;&nbsp;08 - About Pages'),
	(192,1,1,'jamiepittock','127.0.0.1',1278086037,'Channel Deleted:&nbsp;&nbsp;09 - E-communications'),
	(193,1,1,'jamiepittock','127.0.0.1',1278086040,'Channel Deleted:&nbsp;&nbsp;10 - Press releases'),
	(194,1,1,'jamiepittock','127.0.0.1',1278086043,'Channel Deleted:&nbsp;&nbsp;11 - Companies'),
	(195,1,1,'jamiepittock','127.0.0.1',1278086053,'Category Group Deleted:&nbsp;&nbsp;US states'),
	(196,1,1,'jamiepittock','127.0.0.1',1278086056,'Category Group Deleted:&nbsp;&nbsp;Companies'),
	(197,1,1,'jamiepittock','127.0.0.1',1278086062,'Field group Deleted:&nbsp;&nbsp;Companies'),
	(198,1,1,'jamiepittock','127.0.0.1',1278086065,'Field group Deleted:&nbsp;&nbsp;Ecommunications'),
	(199,1,1,'jamiepittock','127.0.0.1',1278086068,'Field group Deleted:&nbsp;&nbsp;Homepage banners'),
	(200,1,1,'jamiepittock','127.0.0.1',1278086071,'Field group Deleted:&nbsp;&nbsp;Homepage intros'),
	(201,1,1,'jamiepittock','127.0.0.1',1278086074,'Field group Deleted:&nbsp;&nbsp;Issues'),
	(202,1,1,'jamiepittock','127.0.0.1',1278086077,'Field group Deleted:&nbsp;&nbsp;Media - Documents'),
	(203,1,1,'jamiepittock','127.0.0.1',1278086081,'Field group Deleted:&nbsp;&nbsp;Media - News'),
	(204,1,1,'jamiepittock','127.0.0.1',1278086084,'Field group Deleted:&nbsp;&nbsp;Media - Stories'),
	(205,1,1,'jamiepittock','127.0.0.1',1278086088,'Field group Deleted:&nbsp;&nbsp;Pages'),
	(206,1,1,'jamiepittock','127.0.0.1',1278086091,'Field group Deleted:&nbsp;&nbsp;Press releases'),
	(207,1,1,'jamiepittock','127.0.0.1',1278086094,'Field group Deleted:&nbsp;&nbsp;Sources'),
	(208,1,1,'jamiepittock','127.0.0.1',1278086113,'Upload Preference Deleted:&nbsp;&nbsp;Files: Press releases (PDFs)'),
	(209,1,1,'jamiepittock','127.0.0.1',1278086117,'Upload Preference Deleted:&nbsp;&nbsp;Images: Banner backgrounds'),
	(210,1,1,'jamiepittock','127.0.0.1',1278086120,'Upload Preference Deleted:&nbsp;&nbsp;Images: Company logos'),
	(211,1,1,'jamiepittock','127.0.0.1',1278086123,'Upload Preference Deleted:&nbsp;&nbsp;Images: Masthead backgrounds'),
	(212,1,1,'jamiepittock','127.0.0.1',1278086127,'Upload Preference Deleted:&nbsp;&nbsp;Images: Source logos'),
	(213,1,1,'jamiepittock','127.0.0.1',1278086130,'Upload Preference Deleted:&nbsp;&nbsp;Images: Story photos'),
	(214,1,1,'jamiepittock','127.0.0.1',1278086133,'Upload Preference Deleted:&nbsp;&nbsp;Images: Thumbnails'),
	(215,1,1,'jamiepittock','127.0.0.1',1278090769,'Member profile created:&nbsp;&nbsp;mattsmith'),
	(216,1,1,'jamiepittock','127.0.0.1',1278090813,'Member profile created:&nbsp;&nbsp;jameswillock'),
	(217,1,1,'jamiepittock','127.0.0.1',1278090832,'SuperAdmin Logging In as User:&nbsp;gregwood'),
	(218,1,7,'gregwood','127.0.0.1',1278090879,'SuperAdmin Logging In as User:&nbsp;philswan'),
	(219,1,8,'philswan','127.0.0.1',1278090932,'SuperAdmin Logging In as User:&nbsp;wil.linssen'),
	(220,1,10,'wil.linssen','127.0.0.1',1278091001,'SuperAdmin Logging In as User:&nbsp;mattsmith'),
	(221,1,15,'mattsmith','127.0.0.1',1278091072,'SuperAdmin Logging In as User:&nbsp;jameswillock'),
	(222,1,16,'jameswillock','127.0.0.1',1278091105,'Logged out'),
	(223,1,1,'jamiepittock','127.0.0.1',1278224899,'Logged in'),
	(224,1,1,'jamiepittock','127.0.0.1',1278245518,'Logged in'),
	(225,1,1,'jamiepittock','127.0.0.1',1278245536,'Logged out'),
	(226,1,1,'jamiepittock','127.0.0.1',1278245554,'Logged in'),
	(227,1,1,'jamiepittock','127.0.0.1',1278245587,'Logged out'),
	(228,1,1,'jamiepittock','127.0.0.1',1278245629,'Logged in'),
	(229,1,1,'jamiepittock','127.0.0.1',1278245644,'Logged out'),
	(230,1,1,'jamiepittock','127.0.0.1',1278245653,'Logged in'),
	(231,1,1,'jamiepittock','127.0.0.1',1278254063,'Logged in'),
	(232,1,1,'jamiepittock','127.0.0.1',1278307223,'Logged in'),
	(233,1,1,'jamiepittock','127.0.0.1',1278339411,'Logged in'),
	(234,1,1,'jamiepittock','127.0.0.1',1278347366,'Logged in'),
	(235,1,7,'gregwood','127.0.0.1',1292409756,'Logged in'),
	(236,1,7,'gregwood','127.0.0.1',1292409816,'Member profile created:&nbsp;&nbsp;philhowell'),
	(237,1,7,'gregwood','127.0.0.1',1292409859,'Channel Created:&nbsp;&nbsp;rofl'),
	(238,1,7,'gregwood','127.0.0.1',1292409871,'Channel Deleted:&nbsp;&nbsp;rofl'),
	(239,1,7,'gregwood','127.0.0.1',1292410001,'Logged out'),
	(240,1,15,'mattsmith','127.0.0.1',1292410013,'Logged in'),
	(241,1,7,'gregwood','127.0.0.1',1292422434,'Logged in'),
	(242,1,1,'jamiepittock','127.0.0.1',1295449043,'Logged in'),
	(243,1,1,'jamiepittock','127.0.0.1',1295720194,'Logged in'),
	(244,1,1,'jamiepittock','127.0.0.1',1295804335,'Logged in'),
	(245,1,1,'jamiepittock','127.0.0.1',1296045969,'Logged in'),
	(246,1,1,'jamiepittock','127.0.0.1',1296045982,'Field Group Created:&nbsp;&nbsp;Journal'),
	(247,1,1,'Member Utilities','127.0.0.1',1296046069,'User jamiepittock has updated their profile'),
	(248,1,1,'Member Utilities','127.0.0.1',1296046096,'User jamiepittock has updated their profile'),
	(249,1,1,'Member Utilities','127.0.0.1',1296046116,'User jamiepittock has updated their profile'),
	(250,1,1,'jamiepittock','127.0.0.1',1296046917,'Channel Created:&nbsp;&nbsp;Journal'),
	(251,1,1,'jamiepittock','88.97.41.226',1296232839,'Logged in'),
	(252,1,1,'jamiepittock','88.97.41.226',1296232888,'Member profile created:&nbsp;&nbsp;garrett.winder'),
	(253,1,18,'garrett.winder','76.238.177.203',1296233661,'Logged in'),
	(254,1,18,'garrett.winder','76.238.177.203',1296234511,'Field Group Created:&nbsp;&nbsp;Event'),
	(255,1,1,'Member Utilities','127.0.0.1',1296235665,'User garrett.winder has updated their profile'),
	(256,1,18,'garrett.winder','76.238.177.203',1296235858,'Field Group Created:&nbsp;&nbsp;Gallery'),
	(257,1,18,'garrett.winder','76.238.177.203',1296236262,'Channel Created:&nbsp;&nbsp;Events'),
	(258,1,18,'garrett.winder','76.238.177.203',1296236342,'Channel Created:&nbsp;&nbsp;Gallery'),
	(259,1,18,'garrett.winder','173.185.20.98',1296253032,'Logged in'),
	(260,1,18,'garrett.winder','173.185.20.98',1296501529,'Logged in'),
	(261,1,18,'garrett.winder','173.185.20.98',1296513747,'Logged in'),
	(262,1,1,'jamiepittock','127.0.0.1',1296550605,'Profile Field Deleted:&nbsp;&nbsp;Official bio'),
	(263,1,1,'jamiepittock','127.0.0.1',1296550608,'Profile Field Deleted:&nbsp;&nbsp;Contact email'),
	(264,1,1,'jamiepittock','127.0.0.1',1296550611,'Profile Field Deleted:&nbsp;&nbsp;Twitter username'),
	(265,1,1,'jamiepittock','127.0.0.1',1296550614,'Profile Field Deleted:&nbsp;&nbsp;Linkedin URL'),
	(266,1,1,'jamiepittock','127.0.0.1',1296550617,'Profile Field Deleted:&nbsp;&nbsp;Location'),
	(267,1,1,'jamiepittock','127.0.0.1',1296550620,'Profile Field Deleted:&nbsp;&nbsp;Related Company'),
	(268,1,1,'jamiepittock','127.0.0.1',1296550835,'SuperAdmin Logging In as User:&nbsp;garrett.winder'),
	(269,1,18,'garrett.winder','127.0.0.1',1296550854,'Logged out'),
	(270,1,1,'jamiepittock','127.0.0.1',1296553073,'Logged in'),
	(271,1,1,'jamiepittock','88.97.41.224',1296553370,'Logged in'),
	(272,1,18,'garrett.winder','173.185.20.98',1296576513,'Logged in'),
	(273,1,1,'jamiepittock','88.97.41.226',1296641835,'Logged in'),
	(274,1,1,'jamiepittock','88.97.41.226',1296641869,'Field Group Created:&nbsp;&nbsp;Journal - Audio'),
	(275,1,1,'jamiepittock','88.97.41.226',1296641961,'Field Group Created:&nbsp;&nbsp;Journal - Videos'),
	(276,1,1,'jamiepittock','88.97.41.226',1296642128,'Custom Field Deleted:&nbsp;&nbsp;Uploaded image'),
	(277,1,1,'jamiepittock','88.97.41.226',1296642140,'Field Group Created:&nbsp;&nbsp;Journal - Photos'),
	(278,1,1,'jamiepittock','88.97.41.226',1296642276,'Field Group Created:&nbsp;&nbsp;Journal - Notes'),
	(279,1,1,'jamiepittock','88.97.41.226',1296642376,'Channel Created:&nbsp;&nbsp;Journal: Videos'),
	(280,1,1,'jamiepittock','88.97.41.226',1296642405,'Channel Created:&nbsp;&nbsp;Journal: Audio'),
	(281,1,1,'jamiepittock','88.97.41.226',1296642431,'Channel Created:&nbsp;&nbsp;Journal: Photos'),
	(282,1,1,'jamiepittock','88.97.41.226',1296642458,'Channel Created:&nbsp;&nbsp;Journal: Notes'),
	(283,1,1,'jamiepittock','88.97.41.226',1296642467,'Channel Deleted:&nbsp;&nbsp;Journal'),
	(284,1,7,'gregwood','88.97.41.224',1296655004,'Logged in'),
	(285,1,1,'jamiepittock','88.97.41.226',1296657072,'Member profile created:&nbsp;&nbsp;simoncampbell'),
	(286,1,1,'jamiepittock','88.97.41.226',1296657131,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(287,1,1,'jamiepittock','88.97.41.226',1296657167,'SuperAdmin Logging In as User:&nbsp;simoncampbell'),
	(288,1,19,'simoncampbell','88.97.41.226',1296657215,'Logged out'),
	(289,1,1,'jamiepittock','88.97.41.226',1296657226,'Logged in'),
	(290,1,1,'jamiepittock','88.97.41.226',1296657256,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(291,1,1,'jamiepittock','88.97.41.226',1296657269,'SuperAdmin Logging In as User:&nbsp;simoncampbell'),
	(292,1,19,'simoncampbell','88.97.41.226',1296657275,'Logged out'),
	(293,1,1,'jamiepittock','88.97.41.226',1296657281,'Logged in'),
	(294,1,1,'jamiepittock','88.97.41.226',1296657299,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(295,1,1,'jamiepittock','88.97.41.226',1296657318,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(296,1,1,'jamiepittock','88.97.41.226',1296657734,'Channel Created:&nbsp;&nbsp;Site pages (privacy policy, etc)'),
	(297,1,1,'jamiepittock','88.97.41.226',1296658527,'Field Group Created:&nbsp;&nbsp;Site pages'),
	(298,1,1,'jamiepittock','88.97.41.226',1296658574,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(299,1,1,'jamiepittock','88.97.41.226',1296663385,'Logged in'),
	(300,1,7,'gregwood','88.97.41.224',1296667491,'Logged in'),
	(301,1,18,'garrett.winder','75.89.69.119',1296674132,'Logged in');

/*!40000 ALTER TABLE `exp_cp_log` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_dc_required_cat
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_dc_required_cat`;

CREATE TABLE `exp_dc_required_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `weblog_id` int(11) NOT NULL,
  `require_cat` int(11) NOT NULL DEFAULT '0',
  `cat_limit` int(11) NOT NULL DEFAULT '0',
  `exact_cat` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `WEBLOG_ID` (`weblog_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_dc_required_cat` WRITE;
/*!40000 ALTER TABLE `exp_dc_required_cat` DISABLE KEYS */;
INSERT INTO `exp_dc_required_cat` (`id`,`weblog_id`,`require_cat`,`cat_limit`,`exact_cat`)
VALUES
	(1,3,0,0,0),
	(2,5,0,0,0),
	(3,6,0,0,0),
	(4,7,0,0,0),
	(5,4,0,0,0),
	(6,8,0,0,0),
	(7,9,0,0,0),
	(8,10,0,0,0),
	(9,11,0,0,0),
	(10,12,0,0,0),
	(11,13,0,0,0),
	(12,14,0,0,0),
	(13,16,0,0,0),
	(14,17,0,0,0),
	(15,18,0,0,0),
	(16,20,0,0,0),
	(17,22,0,0,0),
	(18,21,0,0,0),
	(19,19,0,0,0),
	(20,23,0,0,0);

/*!40000 ALTER TABLE `exp_dc_required_cat` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_email_cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_email_cache`;

CREATE TABLE `exp_email_cache` (
  `cache_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cache_date` int(10) unsigned NOT NULL DEFAULT '0',
  `total_sent` int(6) unsigned NOT NULL,
  `from_name` varchar(70) NOT NULL,
  `from_email` varchar(70) NOT NULL,
  `recipient` text NOT NULL,
  `cc` text NOT NULL,
  `bcc` text NOT NULL,
  `recipient_array` mediumtext NOT NULL,
  `subject` varchar(120) NOT NULL,
  `message` mediumtext NOT NULL,
  `plaintext_alt` mediumtext NOT NULL,
  `mailinglist` char(1) NOT NULL DEFAULT 'n',
  `mailtype` varchar(6) NOT NULL,
  `text_fmt` varchar(40) NOT NULL,
  `wordwrap` char(1) NOT NULL DEFAULT 'y',
  `priority` char(1) NOT NULL DEFAULT '3',
  PRIMARY KEY (`cache_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_email_cache_mg
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_email_cache_mg`;

CREATE TABLE `exp_email_cache_mg` (
  `cache_id` int(6) unsigned NOT NULL,
  `group_id` smallint(4) NOT NULL,
  KEY `cache_id` (`cache_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_email_cache_ml
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_email_cache_ml`;

CREATE TABLE `exp_email_cache_ml` (
  `cache_id` int(6) unsigned NOT NULL,
  `list_id` smallint(4) NOT NULL,
  KEY `cache_id` (`cache_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_email_console_cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_email_console_cache`;

CREATE TABLE `exp_email_console_cache` (
  `cache_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `cache_date` int(10) unsigned NOT NULL DEFAULT '0',
  `member_id` int(10) unsigned NOT NULL,
  `member_name` varchar(50) NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `recipient` varchar(70) NOT NULL,
  `recipient_name` varchar(50) NOT NULL,
  `subject` varchar(120) NOT NULL,
  `message` mediumtext NOT NULL,
  PRIMARY KEY (`cache_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_email_tracker
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_email_tracker`;

CREATE TABLE `exp_email_tracker` (
  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_date` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_ip` varchar(16) NOT NULL,
  `sender_email` varchar(75) NOT NULL,
  `sender_username` varchar(50) NOT NULL,
  `number_recipients` int(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_entry_ping_status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_entry_ping_status`;

CREATE TABLE `exp_entry_ping_status` (
  `entry_id` int(10) unsigned NOT NULL,
  `ping_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_entry_versioning
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_entry_versioning`;

CREATE TABLE `exp_entry_versioning` (
  `version_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `weblog_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `version_date` int(10) NOT NULL,
  `version_data` mediumtext NOT NULL,
  PRIMARY KEY (`version_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_extensions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_extensions`;

CREATE TABLE `exp_extensions` (
  `extension_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) NOT NULL DEFAULT '',
  `method` varchar(50) NOT NULL DEFAULT '',
  `hook` varchar(50) NOT NULL DEFAULT '',
  `settings` text NOT NULL,
  `priority` int(2) NOT NULL DEFAULT '10',
  `version` varchar(10) NOT NULL DEFAULT '',
  `enabled` char(1) NOT NULL DEFAULT 'y',
  PRIMARY KEY (`extension_id`)
) ENGINE=MyISAM AUTO_INCREMENT=140 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_extensions` WRITE;
/*!40000 ALTER TABLE `exp_extensions` DISABLE KEYS */;
INSERT INTO `exp_extensions` (`extension_id`,`class`,`method`,`hook`,`settings`,`priority`,`version`,`enabled`)
VALUES
	(1,'Sl_field_formatting','lg_addon_update_register_source','lg_addon_update_register_source','a:2:{s:12:\"update_check\";s:1:\"y\";s:7:\"plugins\";a:3:{s:4:\"none\";b:1;s:5:\"xhtml\";b:1;s:7:\"textile\";b:1;}}',10,'1.0.2','y'),
	(2,'Sl_field_formatting','lg_addon_update_register_addon','lg_addon_update_register_addon','a:2:{s:12:\"update_check\";s:1:\"y\";s:7:\"plugins\";a:3:{s:4:\"none\";b:1;s:5:\"xhtml\";b:1;s:7:\"textile\";b:1;}}',10,'1.0.2','y'),
	(3,'Sl_field_formatting','publish_admin_edit_field_format','publish_admin_edit_field_format','a:2:{s:12:\"update_check\";s:1:\"y\";s:7:\"plugins\";a:3:{s:4:\"none\";b:1;s:5:\"xhtml\";b:1;s:7:\"textile\";b:1;}}',10,'1.0.2','y'),
	(4,'Sl_field_formatting','show_full_control_panel_start','show_full_control_panel_start','a:2:{s:12:\"update_check\";s:1:\"y\";s:7:\"plugins\";a:3:{s:4:\"none\";b:1;s:5:\"xhtml\";b:1;s:7:\"textile\";b:1;}}',10,'1.0.2','y'),
	(5,'Disable_News_Feed','disable_pmachine_news_feed','member_member_register','',10,'0.5','y'),
	(6,'Disable_News_Feed','cp_disable_pmachine_news_feed','cp_members_member_create','',10,'0.5','y'),
	(7,'Lg_add_cp_tabs_ext','cp_members_member_create','cp_members_member_create','a:1:{i:1;a:18:{s:6:\"enable\";s:1:\"y\";s:6:\"tabs_1\";s:195:\"Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5\";s:6:\"tabs_2\";s:0:\"\";s:6:\"tabs_3\";s:0:\"\";s:6:\"tabs_4\";s:0:\"\";s:6:\"tabs_5\";s:0:\"\";s:6:\"tabs_6\";s:36:\"Snippets|C=modules&M=Low_variables|1\";s:6:\"tabs_7\";s:0:\"\";s:7:\"links_1\";s:0:\"\";s:7:\"links_2\";s:0:\"\";s:7:\"links_3\";s:0:\"\";s:7:\"links_4\";s:0:\"\";s:7:\"links_5\";s:0:\"\";s:7:\"links_6\";s:0:\"\";s:7:\"links_7\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";}}',10,'1.1.0','y'),
	(8,'Lg_add_cp_tabs_ext','lg_addon_update_register_source','lg_addon_update_register_source','a:1:{i:1;a:18:{s:6:\"enable\";s:1:\"y\";s:6:\"tabs_1\";s:195:\"Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5\";s:6:\"tabs_2\";s:0:\"\";s:6:\"tabs_3\";s:0:\"\";s:6:\"tabs_4\";s:0:\"\";s:6:\"tabs_5\";s:0:\"\";s:6:\"tabs_6\";s:36:\"Snippets|C=modules&M=Low_variables|1\";s:6:\"tabs_7\";s:0:\"\";s:7:\"links_1\";s:0:\"\";s:7:\"links_2\";s:0:\"\";s:7:\"links_3\";s:0:\"\";s:7:\"links_4\";s:0:\"\";s:7:\"links_5\";s:0:\"\";s:7:\"links_6\";s:0:\"\";s:7:\"links_7\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";}}',10,'1.1.0','y'),
	(9,'Lg_add_cp_tabs_ext','lg_addon_update_register_addon','lg_addon_update_register_addon','a:1:{i:1;a:18:{s:6:\"enable\";s:1:\"y\";s:6:\"tabs_1\";s:195:\"Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5\";s:6:\"tabs_2\";s:0:\"\";s:6:\"tabs_3\";s:0:\"\";s:6:\"tabs_4\";s:0:\"\";s:6:\"tabs_5\";s:0:\"\";s:6:\"tabs_6\";s:36:\"Snippets|C=modules&M=Low_variables|1\";s:6:\"tabs_7\";s:0:\"\";s:7:\"links_1\";s:0:\"\";s:7:\"links_2\";s:0:\"\";s:7:\"links_3\";s:0:\"\";s:7:\"links_4\";s:0:\"\";s:7:\"links_5\";s:0:\"\";s:7:\"links_6\";s:0:\"\";s:7:\"links_7\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";}}',10,'1.1.0','y'),
	(10,'Fieldframe','sessions_start','sessions_start','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',1,'1.4.3','y'),
	(11,'Fieldframe','publish_admin_edit_field_type_pulldown','publish_admin_edit_field_type_pulldown','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(12,'Fieldframe','publish_admin_edit_field_type_cellone','publish_admin_edit_field_type_cellone','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(13,'Fieldframe','publish_admin_edit_field_type_celltwo','publish_admin_edit_field_type_celltwo','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(14,'Fieldframe','publish_admin_edit_field_extra_row','publish_admin_edit_field_extra_row','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(15,'Fieldframe','publish_admin_edit_field_format','publish_admin_edit_field_format','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(16,'Fieldframe','publish_admin_edit_field_js','publish_admin_edit_field_js','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(17,'Fieldframe','show_full_control_panel_start','show_full_control_panel_start','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(18,'Fieldframe','show_full_control_panel_end','show_full_control_panel_end','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(19,'Fieldframe','publish_form_field_unique','publish_form_field_unique','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(20,'Fieldframe','submit_new_entry_start','submit_new_entry_start','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(21,'Fieldframe','submit_new_entry_end','submit_new_entry_end','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(22,'Fieldframe','publish_form_start','publish_form_start','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(23,'Fieldframe','weblog_standalone_form_start','weblog_standalone_form_start','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(24,'Fieldframe','weblog_standalone_form_end','weblog_standalone_form_end','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(25,'Fieldframe','weblog_entries_tagdata','weblog_entries_tagdata','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',1,'1.4.3','y'),
	(26,'Fieldframe','lg_addon_update_register_source','lg_addon_update_register_source','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(27,'Fieldframe','lg_addon_update_register_addon','lg_addon_update_register_addon','a:3:{s:14:\"fieldtypes_url\";s:0:\"\";s:15:\"fieldtypes_path\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";}',10,'1.4.3','y'),
	(68,'Fieldframe','forward_hook:delete_entries_start:10','delete_entries_start','',10,'1.4.3','y'),
	(69,'Fieldframe','forward_hook:delete_entries_loop:10','delete_entries_loop','',10,'1.4.3','y'),
	(64,'Lg_add_sitename','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:10:{s:6:\"enable\";s:1:\"y\";s:3:\"css\";s:313:\"#cp_sitename{\n  border-right:1px solid #3D525F;\n  color:#dadada;\n  font-size:14px;\n  float:left;\n  padding:2px 10px 2px 0;\n  margin:2px 10px 0 0;\n}\n#server-time{padding-bottom:9px}\n/* Float the EE link left */\ndiv.helpLinksLeft p{color:#fff;}\ndiv.helpLinksLeft a { padding-top: 7px; display: block; float: left; }\";s:5:\"xhtml\";s:41:\"<div id=\\\'cp_sitename\\\'>{site_name}</div>\";s:25:\"enable_super_replacements\";s:1:\"n\";s:9:\"show_time\";s:1:\"n\";s:29:\"enable_page_title_replacement\";s:1:\"y\";s:28:\"page_title_replacement_value\";s:11:\"{site_name}\";s:17:\"check_for_updates\";s:1:\"n\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";}}',10,'1.2.0','y'),
	(66,'Lg_add_sitename','lg_addon_update_register_addon','lg_addon_update_register_addon','a:1:{i:1;a:10:{s:6:\"enable\";s:1:\"y\";s:3:\"css\";s:313:\"#cp_sitename{\n  border-right:1px solid #3D525F;\n  color:#dadada;\n  font-size:14px;\n  float:left;\n  padding:2px 10px 2px 0;\n  margin:2px 10px 0 0;\n}\n#server-time{padding-bottom:9px}\n/* Float the EE link left */\ndiv.helpLinksLeft p{color:#fff;}\ndiv.helpLinksLeft a { padding-top: 7px; display: block; float: left; }\";s:5:\"xhtml\";s:41:\"<div id=\\\'cp_sitename\\\'>{site_name}</div>\";s:25:\"enable_super_replacements\";s:1:\"n\";s:9:\"show_time\";s:1:\"n\";s:29:\"enable_page_title_replacement\";s:1:\"y\";s:28:\"page_title_replacement_value\";s:11:\"{site_name}\";s:17:\"check_for_updates\";s:1:\"n\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";}}',10,'1.2.0','y'),
	(28,'Cp_jquery','add_js','show_full_control_panel_end','a:2:{s:10:\"jquery_src\";s:63:\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js\";s:13:\"jquery_ui_src\";s:69:\"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.7/jquery-ui.min.js\";}',1,'1.1.1','y'),
	(65,'Lg_add_sitename','lg_addon_update_register_source','lg_addon_update_register_source','a:1:{i:1;a:10:{s:6:\"enable\";s:1:\"y\";s:3:\"css\";s:313:\"#cp_sitename{\n  border-right:1px solid #3D525F;\n  color:#dadada;\n  font-size:14px;\n  float:left;\n  padding:2px 10px 2px 0;\n  margin:2px 10px 0 0;\n}\n#server-time{padding-bottom:9px}\n/* Float the EE link left */\ndiv.helpLinksLeft p{color:#fff;}\ndiv.helpLinksLeft a { padding-top: 7px; display: block; float: left; }\";s:5:\"xhtml\";s:41:\"<div id=\\\'cp_sitename\\\'>{site_name}</div>\";s:25:\"enable_super_replacements\";s:1:\"n\";s:9:\"show_time\";s:1:\"n\";s:29:\"enable_page_title_replacement\";s:1:\"y\";s:28:\"page_title_replacement_value\";s:11:\"{site_name}\";s:17:\"check_for_updates\";s:1:\"n\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";}}',10,'1.2.0','y'),
	(36,'edit_remember','modify_edit_post','edit_entries_start','',1,'1.1.0','y'),
	(37,'edit_remember','edit_statuses','edit_entries_search_form','',1,'1.1.0','y'),
	(38,'Ez_category_checkboxes','fetch_group_name','publish_form_weblog_preferences','a:1:{s:15:\"show_group_name\";s:3:\"yes\";}',10,'1.1.5','y'),
	(40,'DC_Required_Category','save_weblog_settings','sessions_start','',10,'1.0.5','y'),
	(39,'Ez_category_checkboxes','create_category_table','show_full_control_panel_end','a:1:{s:15:\"show_group_name\";s:3:\"yes\";}',10,'1.1.5','y'),
	(41,'DC_Required_Category','check_post_for_category','submit_new_entry_start','',10,'1.0.5','y'),
	(42,'DC_Required_Category','edit_weblog_prefs','show_full_control_panel_end','',10,'1.0.5','y'),
	(43,'DC_Required_Category','check_saef_for_category','weblog_standalone_insert_entry','',10,'1.0.5','y'),
	(48,'Edit_tab_ajax','modify_form','edit_entries_search_form','',10,'1.2.2','y'),
	(49,'Edit_tab_ajax','process_search','edit_entries_start','',10,'1.2.2','y'),
	(50,'Ez_edit_menu','add_menu','show_full_control_panel_end','',8,'1.0.2','y'),
	(51,'Ih_textile_editor','add_header','publish_form_headers','a:4:{s:10:\"jquery_url\";s:63:\"http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js\";s:8:\"teh_path\";s:15:\"extensions/teh/\";s:8:\"help_url\";s:25:\"http://hobix.com/textile/\";s:12:\"encode_email\";s:3:\"yes\";}',10,'1.1.0','y'),
	(67,'REEOrder','hide_field','show_full_control_panel_end','',10,'1.0','y'),
	(54,'Comment_spam_prevention','prevent_spam','insert_comment_start','a:5:{s:11:\"number_urls\";s:1:\"2\";s:13:\"min_load_time\";s:1:\"8\";s:10:\"cblacklist\";s:0:\"\";s:27:\"download_pmachine_blacklist\";s:1:\"n\";s:23:\"pmachine_blacklist_next\";s:0:\"\";}',10,'1.1','y'),
	(139,'Low_variables_ext','sessions_end','sessions_end','a:5:{s:11:\"license_key\";s:25:\"0000100138001571276173084\";s:10:\"can_manage\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:16:\"register_globals\";s:1:\"y\";s:20:\"register_member_data\";s:1:\"y\";s:13:\"enabled_types\";a:10:{i:0;s:12:\"low_checkbox\";i:1;s:18:\"low_checkbox_group\";i:2;s:15:\"low_radio_group\";i:3;s:10:\"low_select\";i:4;s:21:\"low_select_categories\";i:5;s:18:\"low_select_entries\";i:6;s:16:\"low_select_files\";i:7;s:18:\"low_select_weblogs\";i:8;s:14:\"low_text_input\";i:9;s:12:\"low_textarea\";}}',2,'1.3.4','y'),
	(58,'Fieldframe','forward_hook:weblog_standalone_insert_entry:10','weblog_standalone_insert_entry','',10,'1.4.3','y'),
	(59,'DC_Required_Category','dc_required_category_register_source','lg_addon_update_register_source','',10,'1.0.5','y'),
	(60,'DC_Required_Category','dc_required_category_register_addon','lg_addon_update_register_addon','',10,'1.0.5','y'),
	(70,'Ed_entry_count','entry_count','sessions_end','',1,'1.0.1','y'),
	(71,'Lg_better_meta','publish_form_new_tabs','publish_form_new_tabs','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(72,'Lg_better_meta','publish_form_new_tabs_block','publish_form_new_tabs_block','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(73,'Lg_better_meta','publish_form_start','publish_form_start','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(74,'Lg_better_meta','submit_new_entry_end','submit_new_entry_end','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(75,'Lg_better_meta','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(76,'Lg_better_meta','lg_addon_update_register_source','lg_addon_update_register_source','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(77,'Lg_better_meta','lg_addon_update_register_addon','lg_addon_update_register_addon','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:7:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:209:\"ThirtySix is Simon\\\'s first solo album in thirty six years of spanking the plank. It\\\'s not blues, it\\\'s not rock, it\\\'s not folk; it is an eclectic mix that will take you on my very personal musical journey. \";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(135,'Publish_tweeks','pt_init','show_full_control_panel_end','a:1:{i:1;a:2:{s:27:\"check_for_extension_updates\";s:1:\"n\";s:32:\"other_settings_remove_upload_box\";s:1:\"y\";}}',1,'0.8','y'),
	(136,'Publish_tweeks','submit_redirect','submit_new_entry_absolute_end','a:1:{i:1;a:2:{s:27:\"check_for_extension_updates\";s:1:\"n\";s:32:\"other_settings_remove_upload_box\";s:1:\"y\";}}',50,'0.8','y'),
	(137,'Publish_tweeks','register_my_addon_source','lg_addon_update_register_source','a:1:{i:1;a:2:{s:27:\"check_for_extension_updates\";s:1:\"n\";s:32:\"other_settings_remove_upload_box\";s:1:\"y\";}}',50,'0.8','y'),
	(138,'Publish_tweeks','register_my_addon_id','lg_addon_update_register_addon','a:1:{i:1;a:2:{s:27:\"check_for_extension_updates\";s:1:\"n\";s:32:\"other_settings_remove_upload_box\";s:1:\"y\";}}',50,'0.8','y'),
	(100,'Super_search_extension','refresh_cache_from_template','edit_template_end','',10,'1.1.0.b2','y'),
	(101,'Super_search_extension','refresh_cache_from_weblog','submit_new_entry_end','',10,'1.1.0.b2','y'),
	(102,'Super_search_extension','refresh_cache_from_category','publish_admin_update_category','',10,'1.1.0.b2','y'),
	(103,'Super_search_extension','super_search_alter_search_check_group','super_search_alter_search','',5,'1.1.0.b2','y'),
	(104,'Super_search_extension','super_search_alter_search_multiselect','super_search_alter_search','',6,'1.1.0.b2','y'),
	(105,'Super_search_extension','super_search_alter_search_playa','super_search_alter_search','',7,'1.1.0.b2','y'),
	(106,'Super_search_extension','super_search_alter_search_relationship','super_search_alter_search','',4,'1.1.0.b2','y'),
	(107,'Super_search_extension','super_search_do_search_and_array_playa','super_search_do_search_and_array','',5,'1.1.0.b2','y'),
	(108,'User_extension','loginreg','insert_comment_start','',5,'3.1.0','y'),
	(109,'User_extension','loginreg','insert_rating_start','',5,'3.1.0','y'),
	(110,'User_extension','loginreg','paypalpro_payment_start','',5,'3.1.0','y'),
	(111,'User_extension','loginreg','freeform_module_insert_begin','',5,'3.1.0','y'),
	(112,'User_extension','cp_validate_members','cp_members_validate_members','',1,'3.1.0','y'),
	(113,'Lg_mf_customiser','control_panel_home_page','control_panel_home_page','a:1:{i:1;a:13:{s:16:\"display_birthday\";s:1:\"n\";s:11:\"display_url\";s:1:\"y\";s:16:\"display_location\";s:1:\"n\";s:18:\"display_occupation\";s:1:\"n\";s:17:\"display_interests\";s:1:\"n\";s:11:\"display_aol\";s:1:\"n\";s:11:\"display_icq\";s:1:\"n\";s:13:\"display_yahoo\";s:1:\"n\";s:11:\"display_msn\";s:1:\"n\";s:11:\"display_bio\";s:1:\"y\";s:11:\"group_rules\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";s:13:\"cache_refresh\";s:4:\"3200\";}}',10,'1.1.0','y'),
	(114,'Lg_mf_customiser','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:13:{s:16:\"display_birthday\";s:1:\"n\";s:11:\"display_url\";s:1:\"y\";s:16:\"display_location\";s:1:\"n\";s:18:\"display_occupation\";s:1:\"n\";s:17:\"display_interests\";s:1:\"n\";s:11:\"display_aol\";s:1:\"n\";s:11:\"display_icq\";s:1:\"n\";s:13:\"display_yahoo\";s:1:\"n\";s:11:\"display_msn\";s:1:\"n\";s:11:\"display_bio\";s:1:\"y\";s:11:\"group_rules\";s:0:\"\";s:17:\"check_for_updates\";s:1:\"n\";s:13:\"cache_refresh\";s:4:\"3200\";}}',10,'1.1.0','y'),
	(115,'Pur_member_utilities_ext','rewrite_member_functions','show_full_control_panel_end','',10,'1.0.3','y'),
	(116,'Pur_member_utilities_ext','notify_profile_updates','sessions_end','',10,'1.0.3','y'),
	(117,'mx_title_control','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:11:{s:15:\"title_english_3\";s:9:\"Tab label\";s:15:\"title_english_4\";s:50:\"Unique description (not displayed on the frontend)\";s:15:\"title_english_5\";s:11:\"Issue title\";s:15:\"title_english_8\";s:13:\"News headline\";s:15:\"title_english_9\";s:14:\"Document title\";s:16:\"title_english_10\";s:11:\"Story title\";s:15:\"title_english_7\";s:11:\"Source name\";s:16:\"title_english_13\";s:12:\"Page heading\";s:16:\"title_english_12\";s:21:\"E-communication title\";s:16:\"title_english_11\";s:19:\"Press release title\";s:13:\"multilanguage\";s:1:\"n\";}}',10,'0.0.3','y'),
	(118,'Lg_live_look_ext','publish_form_start','publish_form_start','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(119,'Lg_live_look_ext','publish_form_new_tabs','publish_form_new_tabs','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(120,'Lg_live_look_ext','publish_form_new_tabs_block','publish_form_new_tabs_block','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(121,'Lg_live_look_ext','edit_entries_additional_tableheader','edit_entries_additional_tableheader','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(122,'Lg_live_look_ext','edit_entries_additional_celldata','edit_entries_additional_celldata','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(123,'Lg_live_look_ext','lg_addon_update_register_source','lg_addon_update_register_source','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(124,'Lg_live_look_ext','lg_addon_update_register_addon','lg_addon_update_register_addon','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(125,'Lg_live_look_ext','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(127,'Cartthrob_ext','member_member_logout','member_member_logout','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(128,'Cartthrob_ext','submit_new_entry_start','submit_new_entry_start','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(129,'Cartthrob_ext','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(130,'Cartthrob_ext','publish_admin_edit_field_type_pulldown','publish_admin_edit_field_type_pulldown','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(131,'Cartthrob_ext','publish_form_field_unique','publish_form_field_unique','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(132,'Cartthrob_ext','publish_admin_edit_field_format','publish_admin_edit_field_format','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(133,'Cartthrob_ext','publish_admin_edit_field_js','publish_admin_edit_field_js','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(134,'Cartthrob_ext','weblog_entries_tagdata','weblog_entries_tagdata','a:1:{i:1;a:159:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:1:\"$\";s:36:\"number_format_defaults_currency_code\";s:3:\"USD\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:1:{i:0;s:0:\"\";}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:0:\"\";s:11:\"save_orders\";s:1:\"0\";s:31:\"orders_sequential_order_numbers\";s:1:\"0\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:0:\"\";s:24:\"orders_processing_status\";s:0:\"\";s:20:\"orders_failed_status\";s:0:\"\";s:22:\"orders_declined_status\";s:0:\"\";s:18:\"orders_items_field\";s:0:\"\";s:21:\"orders_subtotal_field\";s:0:\"\";s:16:\"orders_tax_field\";s:0:\"\";s:21:\"orders_shipping_field\";s:0:\"\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:0:\"\";s:21:\"orders_transaction_id\";s:0:\"\";s:23:\"orders_last_four_digits\";s:0:\"\";s:19:\"orders_coupon_codes\";s:0:\"\";s:22:\"orders_shipping_option\";s:0:\"\";s:26:\"orders_error_message_field\";s:0:\"\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:0:\"\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:0:\"\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:0:\"\";s:24:\"orders_billing_last_name\";s:0:\"\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:0:\"\";s:23:\"orders_billing_address2\";s:0:\"\";s:19:\"orders_billing_city\";s:0:\"\";s:20:\"orders_billing_state\";s:0:\"\";s:18:\"orders_billing_zip\";s:0:\"\";s:22:\"orders_billing_country\";s:0:\"\";s:19:\"orders_country_code\";s:0:\"\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:0:\"\";s:25:\"orders_shipping_last_name\";s:0:\"\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:0:\"\";s:24:\"orders_shipping_address2\";s:0:\"\";s:20:\"orders_shipping_city\";s:0:\"\";s:21:\"orders_shipping_state\";s:0:\"\";s:19:\"orders_shipping_zip\";s:0:\"\";s:23:\"orders_shipping_country\";s:0:\"\";s:28:\"orders_shipping_country_code\";s:0:\"\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:0:\"\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:0:\"\";s:30:\"purchased_items_quantity_field\";s:0:\"\";s:27:\"purchased_items_price_field\";s:0:\"\";s:30:\"purchased_items_order_id_field\";s:0:\"\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y');

/*!40000 ALTER TABLE `exp_extensions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_ff_fieldtype_hooks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_ff_fieldtype_hooks`;

CREATE TABLE `exp_ff_fieldtype_hooks` (
  `hook_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) NOT NULL DEFAULT '',
  `hook` varchar(50) NOT NULL DEFAULT '',
  `method` varchar(50) NOT NULL DEFAULT '',
  `priority` int(2) NOT NULL DEFAULT '10',
  PRIMARY KEY (`hook_id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_ff_fieldtype_hooks` WRITE;
/*!40000 ALTER TABLE `exp_ff_fieldtype_hooks` DISABLE KEYS */;
INSERT INTO `exp_ff_fieldtype_hooks` (`hook_id`,`class`,`hook`,`method`,`priority`)
VALUES
	(8,'ngen_file_field','weblog_standalone_insert_entry','weblog_standalone_insert_entry',10),
	(7,'ngen_file_field','show_full_control_panel_end','show_full_control_panel_end',10),
	(4,'playa','sessions_start','sessions_start',1),
	(5,'playa','delete_entries_start','delete_entries_start',10),
	(6,'playa','delete_entries_loop','delete_entries_loop',10),
	(9,'matrix','delete_entries_loop','delete_entries_loop',10);

/*!40000 ALTER TABLE `exp_ff_fieldtype_hooks` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_ff_fieldtypes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_ff_fieldtypes`;

CREATE TABLE `exp_ff_fieldtypes` (
  `fieldtype_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `class` varchar(50) NOT NULL DEFAULT '',
  `version` varchar(10) NOT NULL DEFAULT '',
  `settings` text NOT NULL,
  `enabled` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`fieldtype_id`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_ff_fieldtypes` WRITE;
/*!40000 ALTER TABLE `exp_ff_fieldtypes` DISABLE KEYS */;
INSERT INTO `exp_ff_fieldtypes` (`fieldtype_id`,`class`,`version`,`settings`,`enabled`)
VALUES
	(1,'ff_checkbox','1.4.3','a:0:{}','y'),
	(2,'ff_checkbox_group','1.4.3','a:0:{}','y'),
	(11,'wygwam','2.0.3','a:2:{s:8:\"toolbars\";a:3:{s:5:\"Basic\";a:5:{i:0;s:4:\"Bold\";i:1;s:6:\"Italic\";i:2;s:4:\"Link\";i:3;s:6:\"Unlink\";i:4;s:6:\"Source\";}s:12:\"Intermediate\";a:7:{i:0;s:4:\"Bold\";i:1;s:6:\"Italic\";i:2;s:12:\"NumberedList\";i:3;s:12:\"BulletedList\";i:4;s:4:\"Link\";i:5;s:6:\"Unlink\";i:6;s:6:\"Source\";}s:8:\"Advanced\";a:11:{i:0;s:4:\"Bold\";i:1;s:6:\"Italic\";i:2;s:12:\"NumberedList\";i:3;s:12:\"BulletedList\";i:4;s:10:\"Blockquote\";i:5;s:4:\"Link\";i:6;s:6:\"Unlink\";i:7;s:6:\"Format\";i:8;s:5:\"Image\";i:9;s:13:\"PasteFromWord\";i:10;s:6:\"Source\";}}s:11:\"license_key\";s:25:\"0020103803605001276179857\";}','y'),
	(4,'ff_radio_group','1.4.3','a:0:{}','y'),
	(5,'ff_vz_url','1.1.4','a:1:{s:17:\"vz_url_error_text\";s:29:\"That url seems to be invalid.\";}','y'),
	(6,'ngen_file_field','1.0.1','a:1:{s:15:\"quality_setting\";s:1:\"n\";}','y'),
	(7,'ff_select','1.4.3','a:0:{}','y'),
	(8,'playa','2.1.2','a:1:{s:11:\"license_key\";s:0:\"\";}','y'),
	(9,'sl_google_map','1.1.2','a:4:{s:7:\"api_key\";s:0:\"\";s:7:\"map_lat\";s:6:\"39.368\";s:7:\"map_lng\";s:6:\"-1.406\";s:8:\"map_zoom\";s:1:\"1\";}','y'),
	(10,'matrix','2.0.4','a:1:{s:11:\"license_key\";s:25:\"0040103803604001276179673\";}','y'),
	(12,'ng_member_list','1.1.2','a:0:{}','y'),
	(13,'dropdate','1.0.1','a:0:{}','y');

/*!40000 ALTER TABLE `exp_ff_fieldtypes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_field_formatting
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_field_formatting`;

CREATE TABLE `exp_field_formatting` (
  `field_id` int(10) unsigned NOT NULL,
  `field_fmt` varchar(40) NOT NULL,
  KEY `field_id` (`field_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_field_formatting` WRITE;
/*!40000 ALTER TABLE `exp_field_formatting` DISABLE KEYS */;
INSERT INTO `exp_field_formatting` (`field_id`,`field_fmt`)
VALUES
	(1,'none'),
	(1,'br'),
	(1,'xhtml'),
	(2,'none'),
	(2,'br'),
	(2,'xhtml'),
	(3,'none'),
	(3,'br'),
	(3,'xhtml'),
	(4,'textile'),
	(4,'xhtml'),
	(4,'none'),
	(66,'textile'),
	(66,'xhtml'),
	(66,'none'),
	(67,'textile'),
	(67,'xhtml'),
	(67,'none'),
	(68,'textile'),
	(68,'xhtml'),
	(68,'none'),
	(69,'textile'),
	(69,'xhtml'),
	(69,'none'),
	(70,'textile'),
	(70,'xhtml'),
	(70,'none'),
	(71,'textile'),
	(71,'xhtml'),
	(71,'none'),
	(72,'textile'),
	(72,'xhtml'),
	(72,'none'),
	(73,'textile'),
	(73,'xhtml'),
	(73,'none'),
	(74,'textile'),
	(74,'xhtml'),
	(74,'none'),
	(75,'textile'),
	(75,'xhtml'),
	(75,'none'),
	(76,'textile'),
	(76,'xhtml'),
	(76,'none'),
	(77,'textile'),
	(77,'xhtml'),
	(77,'none'),
	(78,'textile'),
	(78,'xhtml'),
	(78,'none'),
	(79,'textile'),
	(79,'xhtml'),
	(79,'none'),
	(81,'textile'),
	(81,'xhtml'),
	(81,'none'),
	(82,'textile'),
	(82,'xhtml'),
	(82,'none'),
	(83,'textile'),
	(83,'xhtml'),
	(83,'none'),
	(84,'textile'),
	(84,'xhtml'),
	(84,'none'),
	(85,'textile'),
	(85,'xhtml'),
	(85,'none');

/*!40000 ALTER TABLE `exp_field_formatting` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_field_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_field_groups`;

CREATE TABLE `exp_field_groups` (
  `group_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_field_groups` WRITE;
/*!40000 ALTER TABLE `exp_field_groups` DISABLE KEYS */;
INSERT INTO `exp_field_groups` (`group_id`,`site_id`,`group_name`)
VALUES
	(15,1,'Journal'),
	(16,1,'Events'),
	(17,1,'Gallery'),
	(18,1,'Journal - Audio'),
	(19,1,'Journal - Videos'),
	(20,1,'Journal - Photos'),
	(21,1,'Journal - Notes'),
	(22,1,'Site pages');

/*!40000 ALTER TABLE `exp_field_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_freeform_attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_attachments`;

CREATE TABLE `exp_freeform_attachments` (
  `attachment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `pref_id` int(10) unsigned NOT NULL,
  `entry_date` int(10) NOT NULL,
  `server_path` varchar(150) NOT NULL,
  `filename` varchar(150) NOT NULL,
  `extension` varchar(7) NOT NULL,
  `filesize` int(10) NOT NULL,
  `emailed` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`attachment_id`),
  KEY `entry_id` (`entry_id`),
  KEY `pref_id` (`pref_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_freeform_entries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_entries`;

CREATE TABLE `exp_freeform_entries` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `weblog_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `form_name` varchar(50) NOT NULL,
  `template` varchar(150) NOT NULL,
  `entry_date` int(10) NOT NULL,
  `edit_date` int(10) NOT NULL,
  `status` char(10) NOT NULL DEFAULT 'open',
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `message` text NOT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_freeform_entries` WRITE;
/*!40000 ALTER TABLE `exp_freeform_entries` DISABLE KEYS */;
INSERT INTO `exp_freeform_entries` (`entry_id`,`group_id`,`weblog_id`,`author_id`,`ip_address`,`form_name`,`template`,`entry_date`,`edit_date`,`status`,`name`,`email`,`message`)
VALUES
	(1,1,0,1,'88.97.41.226','freeform_form','contact_form',1296663505,1296663505,'open','Jamie Pittock','jamie@erskinedesign.com','Just testing the contact form.'),
	(2,1,0,1,'88.97.41.226','freeform_form','contact_form',1296664721,1296664721,'open','Jamie Pittock','jamie@erskinedesign.com','Any underscores this time?');

/*!40000 ALTER TABLE `exp_freeform_entries` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_freeform_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_fields`;

CREATE TABLE `exp_freeform_fields` (
  `field_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `field_order` int(10) NOT NULL DEFAULT '0',
  `field_type` varchar(50) NOT NULL DEFAULT 'text',
  `field_length` int(3) NOT NULL DEFAULT '150',
  `form_name` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `name_old` varchar(50) NOT NULL,
  `label` varchar(100) NOT NULL,
  `weblog_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `entry_date` int(10) NOT NULL,
  `edit_date` int(10) NOT NULL,
  `editable` char(1) NOT NULL DEFAULT 'y',
  `status` char(10) NOT NULL DEFAULT 'open',
  PRIMARY KEY (`field_id`),
  KEY `name` (`name`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_freeform_fields` WRITE;
/*!40000 ALTER TABLE `exp_freeform_fields` DISABLE KEYS */;
INSERT INTO `exp_freeform_fields` (`field_id`,`field_order`,`field_type`,`field_length`,`form_name`,`name`,`name_old`,`label`,`weblog_id`,`author_id`,`entry_date`,`edit_date`,`editable`,`status`)
VALUES
	(1,1,'text',150,'','name','','Name',0,0,0,0,'n',''),
	(2,2,'text',150,'','email','','Email',0,0,0,0,'n',''),
	(14,3,'textarea',150,'','message','','Message',0,0,0,0,'y','open');

/*!40000 ALTER TABLE `exp_freeform_fields` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_freeform_params
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_params`;

CREATE TABLE `exp_freeform_params` (
  `params_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_date` int(10) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`params_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_freeform_params` WRITE;
/*!40000 ALTER TABLE `exp_freeform_params` DISABLE KEYS */;
INSERT INTO `exp_freeform_params` (`params_id`,`entry_date`,`data`)
VALUES
	(27,1296683031,'a:18:{s:15:\"require_captcha\";s:2:\"no\";s:9:\"form_name\";s:13:\"freeform_form\";s:10:\"require_ip\";s:0:\"\";s:11:\"ee_required\";s:18:\"name|email|message\";s:9:\"ee_notify\";s:22:\"mail@simoncampbell.com\";s:10:\"recipients\";s:1:\"n\";s:15:\"recipient_limit\";s:2:\"10\";s:17:\"static_recipients\";b:0;s:22:\"static_recipients_list\";a:0:{}s:18:\"recipient_template\";s:16:\"default_template\";s:13:\"discard_field\";s:0:\"\";s:15:\"send_attachment\";s:0:\"\";s:15:\"send_user_email\";s:3:\"yes\";s:20:\"send_user_attachment\";s:0:\"\";s:19:\"user_email_template\";s:17:\"contact_form_user\";s:8:\"template\";s:12:\"contact_form\";s:20:\"prevent_duplicate_on\";s:0:\"\";s:11:\"file_upload\";s:0:\"\";}');

/*!40000 ALTER TABLE `exp_freeform_params` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_freeform_preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_preferences`;

CREATE TABLE `exp_freeform_preferences` (
  `preference_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `preference_name` varchar(80) NOT NULL,
  `preference_value` text NOT NULL,
  PRIMARY KEY (`preference_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_freeform_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_templates`;

CREATE TABLE `exp_freeform_templates` (
  `template_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `enable_template` char(1) NOT NULL DEFAULT 'y',
  `wordwrap` char(1) NOT NULL DEFAULT 'y',
  `html` char(1) NOT NULL DEFAULT 'n',
  `template_name` varchar(150) NOT NULL,
  `template_label` varchar(150) NOT NULL,
  `data_from_name` varchar(150) NOT NULL,
  `data_from_email` varchar(200) NOT NULL,
  `data_title` varchar(80) NOT NULL,
  `template_data` text NOT NULL,
  PRIMARY KEY (`template_id`),
  KEY `template_name` (`template_name`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_freeform_templates` WRITE;
/*!40000 ALTER TABLE `exp_freeform_templates` DISABLE KEYS */;
INSERT INTO `exp_freeform_templates` (`template_id`,`enable_template`,`wordwrap`,`html`,`template_name`,`template_label`,`data_from_name`,`data_from_email`,`data_title`,`template_data`)
VALUES
	(1,'y','y','n','default_template','Default Template','','','Someone has posted to Freeform','\r\nSomeone has posted to Freeform. Here are the details:  \r\n			 		\r\nEntry Date: {entry_date}\r\n{all_custom_fields}'),
	(2,'y','n','n','contact_form','Contact Form','{name}','{email}','Form Submission: Simon Campbell Music','Someone has posted to Freeform. Here are the details:\n\nEntry Date: {entry_date}\n{all_custom_fields}'),
	(3,'y','n','n','contact_form_user','Contact Form - User Confirmation','Simon Campbell Music','mail@simoncampbell.com','Thank you for contacting Simon Campbell Music','Hey!\n\nThank you for contacting us; we will be back to you very shortly.\n\nCheers\n\nSimon');

/*!40000 ALTER TABLE `exp_freeform_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_freeform_user_email
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_freeform_user_email`;

CREATE TABLE `exp_freeform_user_email` (
  `email_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) unsigned NOT NULL,
  `email_count` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`email_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_global_variables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_global_variables`;

CREATE TABLE `exp_global_variables` (
  `variable_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `variable_name` varchar(50) NOT NULL,
  `variable_data` text NOT NULL,
  `user_blog_id` int(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`variable_id`),
  KEY `variable_name` (`variable_name`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_global_variables` WRITE;
/*!40000 ALTER TABLE `exp_global_variables` DISABLE KEYS */;
INSERT INTO `exp_global_variables` (`variable_id`,`site_id`,`variable_name`,`variable_data`,`user_blog_id`)
VALUES
	(2,1,'lv_services_google_analytics','<script type=\"text/javascript\">\n\n    var _gaq = _gaq || [];\n    _gaq.push([\'_setAccount\', \'UA-3386644-6\']);\n    _gaq.push([\'_trackPageview\']);\n\n    (function() {\n        var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;\n        ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';\n        var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);\n    })();\n\n</script>',0),
	(14,1,'lv_services_google_analytics_toggle','On',0),
	(26,1,'lv_contact_aside','<p><strong>Simon would love to hear from you.</strong> If youâ€™d like to drop him a line, either use the form on this page or drop him a line <a href=\"mailto:mail@simoncampbell.com\">via email</a>.</p>\n<p>If you want to get in touch with Simonâ€™s agent for booking details, contact Suzy:</p>\n<address>\n<strong>Suzy Starlite</strong><br>\nSupertone Recoards<br>\n<a href=\"mailto:suzy@supertonerecords.com\">suzy@supertonerecords.com</a><br>\n+44 7624 245881<br>\n</address>',0),
	(27,1,'lv_contact_form_thanks','<p><strong>Thanks for contacting us. If your message requires a response we will be back to you very shortly.</strong></p>',0),
	(28,1,'lv_contact_newsletter_thanks','<p><strong>Thanks for subscribing to the Simon Campbell Music newsletter!</strong></p>\n<p>Youâ€™ll soon be receiving updates about Simon\'s musical adventures - and maybe some free goodies!</p>',0),
	(29,1,'lv_journal_homepage_limit','2',0),
	(30,1,'lv_services_facebook_url','http://www.facebook.com/SimonCampbellBand',0),
	(31,1,'lv_services_twitter_url','http://twitter.com/simoncampbell',0),
	(32,1,'lv_services_master_rss','/feeds/master_rss/',0);

/*!40000 ALTER TABLE `exp_global_variables` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_grforms
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_grforms`;

CREATE TABLE `exp_grforms` (
  `id` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `page` varchar(128) NOT NULL,
  `redirect` text NOT NULL,
  `fields` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_grforms` WRITE;
/*!40000 ALTER TABLE `exp_grforms` DISABLE KEYS */;
INSERT INTO `exp_grforms` (`id`,`name`,`page`,`redirect`,`fields`)
VALUES
	(1,'Signup','signup','thank-you','a:9:{i:0;O:9:\"FieldText\":9:{s:16:\"local_attributes\";a:2:{i:0;s:10:\"max_length\";i:1;s:10:\"min_length\";}s:10:\"max_length\";s:10:\"9999999999\";s:10:\"min_length\";s:1:\"0\";s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:16:\"member.firstName\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:10:\"First Name\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:5:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";i:3;s:10:\"max_length\";i:4;s:10:\"min_length\";}}i:1;O:9:\"FieldText\":9:{s:16:\"local_attributes\";a:2:{i:0;s:10:\"max_length\";i:1;s:10:\"min_length\";}s:10:\"max_length\";s:10:\"9999999999\";s:10:\"min_length\";s:1:\"0\";s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:15:\"member.lastName\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:9:\"Last Name\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:5:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";i:3;s:10:\"max_length\";i:4;s:10:\"min_length\";}}i:2;O:10:\"FieldEmail\":7:{s:19:\"\0*\0local_attributes\";a:0:{}s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:19:\"member.emailAddress\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:5:\"Email\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}}i:3;O:9:\"FieldText\":9:{s:16:\"local_attributes\";a:2:{i:0;s:10:\"max_length\";i:1;s:10:\"min_length\";}s:10:\"max_length\";s:10:\"9999999999\";s:10:\"min_length\";s:1:\"0\";s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:15:\"member.address1\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:14:\"Street Address\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:5:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";i:3;s:10:\"max_length\";i:4;s:10:\"min_length\";}}i:4;O:9:\"FieldText\":9:{s:16:\"local_attributes\";a:2:{i:0;s:10:\"max_length\";i:1;s:10:\"min_length\";}s:10:\"max_length\";s:10:\"9999999999\";s:10:\"min_length\";s:1:\"0\";s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:11:\"member.city\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:4:\"City\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:5:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";i:3;s:10:\"max_length\";i:4;s:10:\"min_length\";}}i:5;O:16:\"FieldStateSelect\":9:{s:10:\"\0*\0options\";a:52:{s:0:\"\";s:9:\"Select...\";s:2:\"AL\";s:7:\"Alabama\";s:2:\"AK\";s:6:\"Alaska\";s:2:\"AZ\";s:7:\"Arizona\";s:2:\"AR\";s:8:\"Arkansas\";s:2:\"CA\";s:10:\"California\";s:2:\"CO\";s:8:\"Colorado\";s:2:\"CT\";s:11:\"Connecticut\";s:2:\"DE\";s:8:\"Delaware\";s:2:\"DC\";s:20:\"District of Columbia\";s:2:\"FL\";s:7:\"Florida\";s:2:\"GA\";s:7:\"Georgia\";s:2:\"HI\";s:6:\"Hawaii\";s:2:\"ID\";s:5:\"Idaho\";s:2:\"IL\";s:8:\"Illinois\";s:2:\"IN\";s:7:\"Indiana\";s:2:\"IA\";s:4:\"Iowa\";s:2:\"KS\";s:6:\"Kansas\";s:2:\"KY\";s:8:\"Kentucky\";s:2:\"LA\";s:9:\"Louisiana\";s:2:\"ME\";s:5:\"Maine\";s:2:\"MD\";s:8:\"Maryland\";s:2:\"MA\";s:13:\"Massachusetts\";s:2:\"MI\";s:8:\"Michigan\";s:2:\"MN\";s:9:\"Minnesota\";s:2:\"MS\";s:11:\"Mississippi\";s:2:\"MO\";s:8:\"Missouri\";s:2:\"MT\";s:7:\"Montana\";s:2:\"NE\";s:8:\"Nebraska\";s:2:\"NV\";s:6:\"Nevada\";s:2:\"NH\";s:13:\"New Hampshire\";s:2:\"NJ\";s:10:\"New Jersey\";s:2:\"NM\";s:10:\"New Mexico\";s:2:\"NY\";s:8:\"New York\";s:2:\"NC\";s:14:\"North Carolina\";s:2:\"ND\";s:12:\"North Dakota\";s:2:\"OH\";s:4:\"Ohio\";s:2:\"OK\";s:8:\"Oklahoma\";s:2:\"OR\";s:6:\"Oregon\";s:2:\"PA\";s:12:\"Pennsylvania\";s:2:\"RI\";s:12:\"Rhode Island\";s:2:\"SC\";s:14:\"South Carolina\";s:2:\"SD\";s:12:\"South Dakota\";s:2:\"TN\";s:9:\"Tennessee\";s:2:\"TX\";s:5:\"Texas\";s:2:\"UT\";s:4:\"Utah\";s:2:\"VT\";s:7:\"Vermont\";s:2:\"VA\";s:8:\"Virginia\";s:2:\"WA\";s:10:\"Washington\";s:2:\"WV\";s:13:\"West Virginia\";s:2:\"WI\";s:9:\"Wisconsin\";s:2:\"WY\";s:7:\"Wyoming\";}s:19:\"\0*\0local_attributes\";a:1:{i:0;s:8:\"multiple\";}s:11:\"\0*\0multiple\";s:2:\"no\";s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:12:\"member.state\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:5:\"State\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:4:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";i:3;s:8:\"multiple\";}}i:6;O:9:\"FieldText\":9:{s:16:\"local_attributes\";a:2:{i:0;s:10:\"max_length\";i:1;s:10:\"min_length\";}s:10:\"max_length\";s:10:\"9999999999\";s:10:\"min_length\";s:1:\"0\";s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:17:\"member.postalCode\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:8:\"Zip Code\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:5:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";i:3;s:10:\"max_length\";i:4;s:10:\"min_length\";}}i:7;O:14:\"FieldIpAddress\":7:{s:16:\"local_attributes\";a:0:{}s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:22:\"member.signUpIPAddress\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:9:\"IP Adress\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}}i:8;O:14:\"FieldTimestamp\":7:{s:16:\"local_attributes\";a:0:{}s:18:\"\0*\0base_attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}s:7:\"\0*\0name\";s:22:\"member.signUpTimestamp\";s:11:\"\0*\0required\";s:3:\"yes\";s:8:\"\0*\0label\";s:9:\"Timestamp\";s:8:\"\0*\0value\";s:0:\"\";s:10:\"attributes\";a:3:{i:0;s:5:\"label\";i:1;s:8:\"required\";i:2;s:4:\"name\";}}}');

/*!40000 ALTER TABLE `exp_grforms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_html_buttons
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_html_buttons`;

CREATE TABLE `exp_html_buttons` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `tag_name` varchar(32) NOT NULL,
  `tag_open` varchar(120) NOT NULL,
  `tag_close` varchar(120) NOT NULL,
  `accesskey` varchar(32) NOT NULL,
  `tag_order` int(3) unsigned NOT NULL,
  `tag_row` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_html_buttons` WRITE;
/*!40000 ALTER TABLE `exp_html_buttons` DISABLE KEYS */;
INSERT INTO `exp_html_buttons` (`id`,`site_id`,`member_id`,`tag_name`,`tag_open`,`tag_close`,`accesskey`,`tag_order`,`tag_row`)
VALUES
	(1,1,0,'<b>','<b>','</b>','b',1,'1'),
	(2,1,0,'<bq>','<blockquote>','</blockquote>','q',2,'1'),
	(3,1,0,'<del>','<del>','</del>','d',3,'1'),
	(4,1,0,'<i>','<i>','</i>','i',4,'1');

/*!40000 ALTER TABLE `exp_html_buttons` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_lg_better_meta
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_lg_better_meta`;

CREATE TABLE `exp_lg_better_meta` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `site_id` int(8) NOT NULL DEFAULT '1',
  `entry_id` int(8) DEFAULT NULL,
  `weblog_id` int(8) DEFAULT NULL,
  `url_title` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `publisher` varchar(255) DEFAULT NULL,
  `rights` varchar(255) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `index` varchar(1) DEFAULT NULL,
  `follow` varchar(1) DEFAULT NULL,
  `archive` varchar(1) DEFAULT NULL,
  `priority` varchar(5) DEFAULT NULL,
  `change_frequency` varchar(50) DEFAULT NULL,
  `include_in_sitemap` varchar(1) DEFAULT NULL,
  `canonical_url` varchar(255) NOT NULL,
  `region` varchar(255) NOT NULL,
  `placename` varchar(255) NOT NULL,
  `latitude` varchar(25) NOT NULL,
  `longitude` varchar(25) NOT NULL,
  `append_default_keywords` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `entry_id` (`entry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_lg_better_meta` WRITE;
/*!40000 ALTER TABLE `exp_lg_better_meta` DISABLE KEYS */;
INSERT INTO `exp_lg_better_meta` (`id`,`site_id`,`entry_id`,`weblog_id`,`url_title`,`title`,`keywords`,`description`,`publisher`,`rights`,`author`,`index`,`follow`,`archive`,`priority`,`change_frequency`,`include_in_sitemap`,`canonical_url`,`region`,`placename`,`latitude`,`longitude`,`append_default_keywords`)
VALUES
	(1,1,2,12,'adsfasdf','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(2,1,3,5,'climate-change','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(3,1,5,13,'about-energy-nation','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(4,1,6,13,'privacy-policy','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(5,1,7,13,'terms-of-use','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(6,1,13,8,'the-new-socialism','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(7,1,14,10,'this-is-just-a-photo','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(8,1,15,10,'this-is-just-a-story-text','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(9,1,16,10,'this-is-a-photo-and-text','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(10,1,17,10,'this-is-just-a-video','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(11,1,18,10,'this-is-a-video-and-text','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(12,1,19,10,'this-is-a-video-photo-and-text','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(13,1,20,10,'this-is-a-photo-and-a-video','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(14,1,21,11,'this-is-a-press-release','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(15,1,22,10,'this-is-another-photo','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(16,1,23,12,'this-is-an-e-communication','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(17,1,24,12,'this-is-another-ecommunication','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(18,1,25,12,'one-more-ecommunication','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(19,1,26,11,'this-is-the-title-of-a-press-release','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(20,1,27,5,'hydraulic-fracturing','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(21,1,29,5,'oil-sands','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(22,1,30,5,'ocs-the-outer-continental-shelf','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(23,1,31,5,'deepwater-moratorium','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(24,1,32,5,'climate-change','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(25,1,33,5,'regulations','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(26,1,34,5,'taxes','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(27,1,35,5,'jobs','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(28,1,36,9,'this-is-a-document','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(29,1,38,8,'its-up-to-yo','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(30,1,41,8,'shale-gas-will-rock-the-world','','','',NULL,NULL,'','','','','','','','','','','','',0);

/*!40000 ALTER TABLE `exp_lg_better_meta` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_low_variable_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_low_variable_groups`;

CREATE TABLE `exp_low_variable_groups` (
  `group_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(6) unsigned NOT NULL,
  `group_label` varchar(100) NOT NULL,
  `group_notes` text NOT NULL,
  `group_order` int(4) unsigned NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_low_variable_groups` WRITE;
/*!40000 ALTER TABLE `exp_low_variable_groups` DISABLE KEYS */;
INSERT INTO `exp_low_variable_groups` (`group_id`,`site_id`,`group_label`,`group_notes`,`group_order`)
VALUES
	(1,1,'Services','',0),
	(2,1,'Contact','Miscellaneous page content on the Contact page.',0),
	(3,1,'Journal','',0);

/*!40000 ALTER TABLE `exp_low_variable_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_low_variables
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_low_variables`;

CREATE TABLE `exp_low_variables` (
  `variable_id` int(6) unsigned NOT NULL,
  `group_id` int(6) unsigned NOT NULL,
  `variable_label` varchar(100) NOT NULL,
  `variable_notes` text NOT NULL,
  `variable_type` varchar(50) NOT NULL,
  `variable_settings` text NOT NULL,
  `variable_order` int(4) unsigned NOT NULL,
  `early_parsing` char(1) NOT NULL DEFAULT 'n',
  `is_hidden` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`variable_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `exp_low_variables` WRITE;
/*!40000 ALTER TABLE `exp_low_variables` DISABLE KEYS */;
INSERT INTO `exp_low_variables` (`variable_id`,`group_id`,`variable_label`,`variable_notes`,`variable_type`,`variable_settings`,`variable_order`,`early_parsing`,`is_hidden`)
VALUES
	(2,1,'Google Analytics code','','low_textarea','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:2:\"10\";}}',0,'n','n'),
	(14,1,'Toggle google analytics on/off','','low_select','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:4:{s:7:\"options\";s:6:\"On\nOff\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";s:8:\"multiple\";s:0:\"\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(26,2,'Basic sidebar','','low_textarea','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:2:\"10\";}}',0,'n','n'),
	(27,2,'Form submitted sidebar','The sidebar that the user will see once successfully submitting the contact form.','low_textarea','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:2:\"10\";}}',0,'n','n'),
	(28,2,'Newsletter subscribed sidebar','The sidebar that the user will see once successfully subscribing to the newsletter.','low_textarea','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:2:\"10\";}}',0,'n','n'),
	(29,3,'Homepage limit','Select how many items to show on the stream on the homepage. this can be useful if the number sidebar blocks increases/decreases','low_select','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:4:{s:7:\"options\";s:7:\"2\n3\n4\n5\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";s:8:\"multiple\";s:0:\"\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(30,1,'Facebook URL','','low_text_input','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(31,1,'Twitter URL','','low_text_input','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(32,1,'Master RSS feed','','low_text_input','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n');

/*!40000 ALTER TABLE `exp_low_variables` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_matrix_cols
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_matrix_cols`;

CREATE TABLE `exp_matrix_cols` (
  `col_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned DEFAULT '1',
  `field_id` int(6) unsigned DEFAULT NULL,
  `col_name` varchar(32) DEFAULT NULL,
  `col_label` varchar(50) DEFAULT NULL,
  `col_instructions` text,
  `col_type` varchar(50) DEFAULT 'text',
  `col_required` char(1) DEFAULT 'n',
  `col_search` char(1) DEFAULT 'n',
  `col_order` int(3) unsigned DEFAULT NULL,
  `col_width` varchar(4) DEFAULT NULL,
  `col_settings` text,
  PRIMARY KEY (`col_id`),
  KEY `site_id` (`site_id`),
  KEY `field_id` (`field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_matrix_cols` WRITE;
/*!40000 ALTER TABLE `exp_matrix_cols` DISABLE KEYS */;
INSERT INTO `exp_matrix_cols` (`col_id`,`site_id`,`field_id`,`col_name`,`col_label`,`col_instructions`,`col_type`,`col_required`,`col_search`,`col_order`,`col_width`,`col_settings`)
VALUES
	(1,1,NULL,'ffm_pistat_stat','Statistic','The statistic should be a short paragraph with no text formatting.','text','n','n',0,'50%','YToyOntzOjQ6Im1heGwiO3M6MDoiIjtzOjk6Im11bHRpbGluZSI7czoxOiJ5Ijt9'),
	(2,1,NULL,'ffm_pistat_source','Source','i.e. \"Financial Times\"','text','n','n',1,'25%','YToxOntzOjQ6Im1heGwiO3M6MzoiMTQwIjt9'),
	(3,1,NULL,'ffm_pistat_sourceurl','Source URL','i.e. \"http://www.ft.com\"','ff_vz_url','n','n',2,'25%','YTowOnt9'),
	(4,1,NULL,'ffm_video_heading','Heading','This heading will appear above the video if added','text','n','y',0,'15%','YToxOntzOjQ6Im1heGwiO3M6MzoiMjU1Ijt9'),
	(5,1,NULL,'ffm_video_id','Brightcove video ID','Add the video ID from Brightcove','text','n','n',1,'15%','YToxOntzOjQ6Im1heGwiO3M6MjoiMTAiO30='),
	(6,1,NULL,'ffm_video_transcript','Transcript','The transcript will appear in an overlay if clicked','wygwam','n','n',3,'35%','YToyOntzOjc6InRvb2xiYXIiO3M6NToiQmFzaWMiO3M6MTA6InVwbG9hZF9kaXIiO3M6MDoiIjt9'),
	(8,1,NULL,'ffm_impact_heading','Heading','This heading will appear above the personal impact statement','text','n','y',0,'20%','YToxOntzOjQ6Im1heGwiO3M6MzoiMjU1Ijt9'),
	(9,1,NULL,'ffm_impact_statement','Statement','','wygwam','n','y',1,'40','YToyOntzOjc6InRvb2xiYXIiO3M6NToiQmFzaWMiO3M6MTA6InVwbG9hZF9kaXIiO3M6MDoiIjt9'),
	(10,1,NULL,'ffm_impact_statistic','Statistic','Add an optional statistic that will appear along side the statement','text','n','y',2,'15','YToyOntzOjQ6Im1heGwiO3M6MDoiIjtzOjk6Im11bHRpbGluZSI7czoxOiJ5Ijt9'),
	(11,1,NULL,'ffm_impact_source_label','Statistic source','i.e. \"Financial Times\"','text','n','n',3,'10','YToxOntzOjQ6Im1heGwiO3M6MzoiMTUwIjt9'),
	(12,1,NULL,'ffm_impact_source_url','Source URL','i.e. \"http://www.ft.com\"','ff_vz_url','n','n',4,'15','YTowOnt9'),
	(13,1,NULL,'ffm_video_id','Brightcove video ID','Add the video ID from Brightcove','text','n','n',0,'20%','YToxOntzOjQ6Im1heGwiO3M6MjoiMTAiO30='),
	(14,1,NULL,'ffm_video_transcript','Transcript','The transcript will appear in an overlay if clicked','wygwam','n','n',2,'40%','YToyOntzOjc6InRvb2xiYXIiO3M6MTI6IkludGVybWVkaWF0ZSI7czoxMDoidXBsb2FkX2RpciI7czowOiIiO30='),
	(15,1,NULL,'ffm_video_alt','Video alternative','If there is no video available you can add some alternative content here','wygwam','n','n',2,'35%','YToyOntzOjc6InRvb2xiYXIiO3M6NToiQmFzaWMiO3M6MTA6InVwbG9hZF9kaXIiO3M6MDoiIjt9'),
	(16,1,NULL,'ffm_video_alt','Video alternative','If there is no video available you can add some alternative content here','wygwam','n','n',1,'40%','YToyOntzOjc6InRvb2xiYXIiO3M6MTI6IkludGVybWVkaWF0ZSI7czoxMDoidXBsb2FkX2RpciI7czowOiIiO30='),
	(17,1,NULL,'ffm_image_caption','Caption','','text','n','n',0,'33%','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(18,1,NULL,'ffm_image_file','File','','ngen_file_field','n','n',1,'','YToxOntzOjc6Im9wdGlvbnMiO3M6MjoiMTQiO30='),
	(19,1,NULL,'ffm_image_position','Position','','ff_select','n','n',2,'','YToxOntzOjc6Im9wdGlvbnMiO2E6Mjp7aTo0MDA7czo0OiJGdWxsIjtpOjIwMDtzOjU6IlJpZ2h0Ijt9fQ=='),
	(20,1,NULL,'ffm_audio_caption','Caption','','text','n','n',0,'50%','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(21,1,NULL,'ffm_audio_file','File','','text','n','n',1,'50%','YToxOntzOjQ6Im1heGwiO3M6MzoiMjU1Ijt9'),
	(22,1,NULL,'ffm_video_caption','Caption','','text','n','n',0,'50%','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(23,1,NULL,'ffm_video_code','Video code','','text','n','n',1,'50%','YToyOntzOjQ6Im1heGwiO3M6MDoiIjtzOjk6Im11bHRpbGluZSI7czoxOiJ5Ijt9'),
	(24,1,NULL,'ffm_images_image','Image','Will be cropped to 580x380 pixels.','ngen_file_field','n','n',0,'33%','YToxOntzOjc6Im9wdGlvbnMiO3M6MjoiMTciO30='),
	(25,1,NULL,'ffm_images_title','Image title','Short title/description of the image.','text','n','n',1,'33%','YToyOntzOjQ6Im1heGwiO3M6MjoiNTYiO3M6OToibXVsdGlsaW5lIjtzOjE6InkiO30='),
	(26,1,NULL,'ffm_images_credit','Image credit','Example: 2010 Phil Keen','text','n','n',2,'33%','YToxOntzOjQ6Im1heGwiO3M6MjoiNDAiO30=');

/*!40000 ALTER TABLE `exp_matrix_cols` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_matrix_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_matrix_data`;

CREATE TABLE `exp_matrix_data` (
  `row_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned DEFAULT '1',
  `entry_id` int(10) unsigned DEFAULT NULL,
  `field_id` int(6) unsigned DEFAULT NULL,
  `row_order` int(4) unsigned DEFAULT NULL,
  `col_id_1` text,
  `col_id_2` text,
  `col_id_3` text,
  `col_id_4` text,
  `col_id_5` text,
  `col_id_6` text,
  `col_id_8` text,
  `col_id_9` text,
  `col_id_10` text,
  `col_id_11` text,
  `col_id_12` text,
  `col_id_13` text,
  `col_id_14` text,
  `col_id_15` text,
  `col_id_16` text,
  `col_id_17` text,
  `col_id_18` text,
  `col_id_19` text,
  `col_id_20` text,
  `col_id_21` text,
  `col_id_22` text,
  `col_id_23` text,
  `col_id_24` text,
  `col_id_25` text,
  `col_id_26` text,
  PRIMARY KEY (`row_id`),
  KEY `site_id` (`site_id`),
  KEY `entry_id` (`entry_id`),
  KEY `row_order` (`row_order`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_matrix_data` WRITE;
/*!40000 ALTER TABLE `exp_matrix_data` DISABLE KEYS */;
INSERT INTO `exp_matrix_data` (`row_id`,`site_id`,`entry_id`,`field_id`,`row_order`,`col_id_1`,`col_id_2`,`col_id_3`,`col_id_4`,`col_id_5`,`col_id_6`,`col_id_8`,`col_id_9`,`col_id_10`,`col_id_11`,`col_id_12`,`col_id_13`,`col_id_14`,`col_id_15`,`col_id_16`,`col_id_17`,`col_id_18`,`col_id_19`,`col_id_20`,`col_id_21`,`col_id_22`,`col_id_23`,`col_id_24`,`col_id_25`,`col_id_26`)
VALUES
	(3,1,27,16,0,'55,000 Pennsylvanians have jobs related to energy production','','http://www.post-gazette.com/pg/10077/1043672-28.stm#ixzz0iWy53TEs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(4,1,27,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?','<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n','55,000 Pennsylvanians have jobs related to energy production','Pittsburgh Post-Gazette','http://http://www.post-gazette.com/pg/10077/1043672-28.stm#ixzz0iWy53TEs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(5,1,27,55,0,NULL,NULL,NULL,'This is the video heading','','<p>\n	This is a transcript</p>\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'<p>\n	<object height=\"385\" width=\"480\"><param name=\"movie\" value=\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\" /><param name=\"allowFullScreen\" value=\"true\" /><param name=\"allowscriptaccess\" value=\"always\" /><embed allowfullscreen=\"true\" allowscriptaccess=\"always\" height=\"385\" src=\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\" type=\"application/x-shockwave-flash\" width=\"480\"></embed></object></p>\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(7,1,29,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'What do the oil sands mean to you and your job?','<p>\n	Beneath the sands of Alberta lie 173 billion barrels of oil, reserves second only to those in Saudi Arabia. We are ready to deliver this important source of energy to the American people.</p>\n<p>\n	By responsibly developing these resources in Canada, we can create jobs here in America through refinery expansion and pipeline construction. By some accounts, this activity could support 600,000 new jobs by 2025, as well as add nearly $130 billion to the economy. Access to oil sands in Canada could provide a reliable supply of energy to more consumers in more parts of the country.</p>\n<p>\n	The refinery projects we are undertaking and the development of new technologies to better process oil from Canada will allow us to provide an important, affordable and reliable source of energy America needs.</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(8,1,0,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'How does offshore drilling provide America the energy it needs?','<p>\n	We know perhaps better than anyone else the immense opportunity in exploring the waters along the Outer Continental Shelf for oil and natural gas. We also know it can be done in a responsible way that takes the environment into consideration.</p>\n<p>\n	By some estimates, the Outer Continental Shelf contains more than 14 billion barrels of oil and 55 trillion cubic feet of natural gas. Tapping these resources could generate $1.7 trillion in revenue for governments and 160,000 new jobs.</p>\n<p>\n	Above anyone, we remain committed to the responsible development of offshore resources of oil and natural gas. It&rsquo;s an opportunity to produce domestic oil and natural gas while providing well-paying jobs and strengthening America&rsquo;s economy.</p>\n','â€œ30% of the oil and 25% of the natural gas we produce in the United States comes from thousands of wells in the Gulf of Mexico.â€','The Hill','http://thehill.com/blogs/congress-blog/energy-a-environment/103299-clean-energy-and-oil-spill-response-sen-lamar-alexander  ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(9,1,31,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Will a ban on deepwater drilling affect future energy supply?','<p>\n	Following the tragic Deepwater Horizon accident, we are mobilizing a tremendous amount of resources to aid in responding to the spill. Our industry understands the need to respond in a coordinated manner and we are&mdash;swiftly creating a task force to examine the spill&rsquo;s cause and working hard to assess and address its impact.</p>\n<p>\n	Unfortunately, Members of Congress, as well as the President and his Administration, have halted new deepwater drilling for at least six months. This move places our jobs and communities in economic peril.</p>\n<p>\n	According to one study, a ban on new deepwater drilling, when combined with tighter regulations and longer permitting timeframes, could result in the equivalent of 340,000 barrels of oil per day in lost production by 2015. This means nearly 50,000 jobs idled in the short term and potentially more than 120,000 if restrictions are extended. In this economy, we can&rsquo;t afford to lose more jobs and deprive Americans of the reliable and affordable energy they need.</p>\n','â€œA moratorium on deepwater drilling could jeopardize 100,000 jobs.â€ ','Rep. Pete Olson, quoted in The Hill','http://thehill.com/blogs/e2-wire/677-e2-wire/102885-texas-lawmaker-to-introduce-bill-lifting-drilling-pause',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(10,1,32,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'What does climate change legislation mean for you and your family?','<p>\n	As an industry, we&rsquo;re committed to reducing greenhouse gas emissions and lower our environmental footprint. We&rsquo;re constantly enhancing efficiency and investing in new technologies that are changing the environmental effects of our work as we bring energy to consumers.</p>\n<p>\n	Congress continues to propose and debate well-intentioned measures that require companies to reduce their impact on the environment. We support this goal and are committed to finding solutions that promote environmental responsibility. However, many of the proposed measures would have unintended negative consequences, potentially putting millions of jobs at risk and raising costs for companies in our industry and others. Our elected officials must understand the need to balance the positive intent of legislation against the negative implications for consumers, jobs and the economy.</p>\n<p>\n	We are committed to protecting the environment. In fact, we&rsquo;re already working to reduce our carbon footprint. But we must be careful of proposals that could take away jobs from the hardworking people in our industry, make our industry less competitive or raise costs for the people that rely on us for affordable energy.</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(11,1,33,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Could additional regulations stifle economic growth?','<p>\n	We recognize that we must be careful about our impact on the environment. Our companies are taking steps every day to reduce that impact, knowing that we must be able to provide affordable, responsibly produced energy to Americans for decades to come.</p>\n<p>\n	We are concerned, however, that heavy regulations, while well-intentioned, could have unintended but severe negative effects on the economy, the job market and on American businesses&mdash;without significantly improving our nation&rsquo;s carbon footprint. While we support the goal of taking measures to reduce emissions, we want to ensure that doing so will not be at the expense of jobs and the economy.</p>\n<p>\n	We&rsquo;re constantly taking steps to produce energy responsibly. One such example is our commitment to expand production and use of ultra-low sulfur diesel and other technologies, which would lead to a reduction of six common emissions by 60 percent. We remain committed to working with Congress and the administration to make positive changes that lower our environmental impact.&nbsp;&nbsp;</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(12,1,34,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Will new taxes threaten jobs and weaken energy independence?','<p>\n	Producing America&rsquo;s resources of oil and natural gas isn&rsquo;t cheap. Our industry spends hundreds of billions of dollars every year on wages, technology and investment in research and development of energy resources.</p>\n<p>\n	What&rsquo;s more, the energy industry is one of the most heavily taxed industries in America. Industry taxes provide billions of dollars that support schools, first responders and our transportation system, among other vital public services. Yet Congress and the administration continue to propose new taxes on the industry. The latest proposal would mean at least $80 billion in new taxes.</p>\n<p>\n	We oppose new taxes not just because of their impact directly on our businesses, but of the far-reaching negative effects that they could bring to industry workers, consumers and the businesses and organizations that depend on our industry for reliable, affordable energy.</p>\n<p>\n	Instead of passing new taxes, we can show Congress and the administration that we are ready to lead an economic recovery by producing more oil and natural gas right here at home.&nbsp;</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(13,1,35,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Just exactly how important is our industry to the American economy?','<p>\n	We know how important our work is. More than 9.2 million people are directly or indirectly employed by America&rsquo;s oil and natural gas industry. That&rsquo;s 9.2 million people working hard to deliver the energy our country needs.</p>\n<p>\n	Whether it&rsquo;s passing new laws, regulations or taxes, Washington has a profound impact on our industry and jobs. New laws and regulations that raise the cost of energy or restrict access to resources of oil and natural gas could put thousands of jobs at risk and increase the costs of everything from food and transportation to heating a home.</p>\n<p>\n	We are part of the solution. Our 9.2 million jobs and more than a trillion dollars in value added to the economy play a major role in providing this country the energy it needs and driving the economy.</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(16,1,42,67,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','content_pri_post1.jpg','Full',NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(17,1,46,75,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon.png','Simon Campbell','2010 Phil Kneen'),
	(18,1,46,75,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-scream.png','Mannifest, 2010. Perhaps getting a little carried away','2010 Phil Kneen'),
	(20,1,46,75,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-beach_1.png','At Gansey Beach, Isle of Man','2010 Phil Kneen'),
	(21,1,46,75,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-gracilands.png','Recording at \'GracieLand Studio\', Rochdale','2010 Phil Kneen'),
	(22,1,46,75,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-peel-beach.png','At Peel Beach','2010 Phil Kneen'),
	(23,1,46,75,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-gracieland2.png','Recording at \'GracieLand Studio\', Rochdale','2010 Phil Kneen'),
	(25,1,46,75,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-gracieland3.png','Recording at \'GracieLand Studio\', Rochdale','2010 Phil Kneen');

/*!40000 ALTER TABLE `exp_matrix_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_member_bulletin_board
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_member_bulletin_board`;

CREATE TABLE `exp_member_bulletin_board` (
  `bulletin_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `bulletin_group` int(8) unsigned NOT NULL,
  `bulletin_date` int(10) unsigned NOT NULL,
  `hash` varchar(10) NOT NULL DEFAULT '',
  `bulletin_expires` int(10) unsigned NOT NULL DEFAULT '0',
  `bulletin_message` text NOT NULL,
  PRIMARY KEY (`bulletin_id`),
  KEY `sender_id` (`sender_id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_member_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_member_data`;

CREATE TABLE `exp_member_data` (
  `member_id` int(10) unsigned NOT NULL,
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_member_data` WRITE;
/*!40000 ALTER TABLE `exp_member_data` DISABLE KEYS */;
INSERT INTO `exp_member_data` (`member_id`)
VALUES
	(1),
	(7),
	(8),
	(10),
	(15),
	(16),
	(17),
	(18),
	(19);

/*!40000 ALTER TABLE `exp_member_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_member_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_member_fields`;

CREATE TABLE `exp_member_fields` (
  `m_field_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `m_field_name` varchar(32) NOT NULL,
  `m_field_label` varchar(50) NOT NULL,
  `m_field_description` text NOT NULL,
  `m_field_type` varchar(12) NOT NULL DEFAULT 'text',
  `m_field_list_items` text NOT NULL,
  `m_field_ta_rows` tinyint(2) DEFAULT '8',
  `m_field_maxl` smallint(3) NOT NULL,
  `m_field_width` varchar(6) NOT NULL,
  `m_field_search` char(1) NOT NULL DEFAULT 'y',
  `m_field_required` char(1) NOT NULL DEFAULT 'n',
  `m_field_public` char(1) NOT NULL DEFAULT 'y',
  `m_field_reg` char(1) NOT NULL DEFAULT 'n',
  `m_field_fmt` char(5) NOT NULL DEFAULT 'none',
  `m_field_order` int(3) unsigned NOT NULL,
  PRIMARY KEY (`m_field_id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;



# Dump of table exp_member_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_member_groups`;

CREATE TABLE `exp_member_groups` (
  `group_id` smallint(4) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_title` varchar(100) NOT NULL,
  `group_description` text NOT NULL,
  `is_locked` char(1) NOT NULL DEFAULT 'y',
  `can_view_offline_system` char(1) NOT NULL DEFAULT 'n',
  `can_view_online_system` char(1) NOT NULL DEFAULT 'y',
  `can_access_cp` char(1) NOT NULL DEFAULT 'y',
  `can_access_publish` char(1) NOT NULL DEFAULT 'n',
  `can_access_edit` char(1) NOT NULL DEFAULT 'n',
  `can_access_design` char(1) NOT NULL DEFAULT 'n',
  `can_access_comm` char(1) NOT NULL DEFAULT 'n',
  `can_access_modules` char(1) NOT NULL DEFAULT 'n',
  `can_access_admin` char(1) NOT NULL DEFAULT 'n',
  `can_admin_weblogs` char(1) NOT NULL DEFAULT 'n',
  `can_admin_members` char(1) NOT NULL DEFAULT 'n',
  `can_delete_members` char(1) NOT NULL DEFAULT 'n',
  `can_admin_mbr_groups` char(1) NOT NULL DEFAULT 'n',
  `can_admin_mbr_templates` char(1) NOT NULL DEFAULT 'n',
  `can_ban_users` char(1) NOT NULL DEFAULT 'n',
  `can_admin_utilities` char(1) NOT NULL DEFAULT 'n',
  `can_admin_preferences` char(1) NOT NULL DEFAULT 'n',
  `can_admin_modules` char(1) NOT NULL DEFAULT 'n',
  `can_admin_templates` char(1) NOT NULL DEFAULT 'n',
  `can_edit_categories` char(1) NOT NULL DEFAULT 'n',
  `can_delete_categories` char(1) NOT NULL DEFAULT 'n',
  `can_view_other_entries` char(1) NOT NULL DEFAULT 'n',
  `can_edit_other_entries` char(1) NOT NULL DEFAULT 'n',
  `can_assign_post_authors` char(1) NOT NULL DEFAULT 'n',
  `can_delete_self_entries` char(1) NOT NULL DEFAULT 'n',
  `can_delete_all_entries` char(1) NOT NULL DEFAULT 'n',
  `can_view_other_comments` char(1) NOT NULL DEFAULT 'n',
  `can_edit_own_comments` char(1) NOT NULL DEFAULT 'n',
  `can_delete_own_comments` char(1) NOT NULL DEFAULT 'n',
  `can_edit_all_comments` char(1) NOT NULL DEFAULT 'n',
  `can_delete_all_comments` char(1) NOT NULL DEFAULT 'n',
  `can_moderate_comments` char(1) NOT NULL DEFAULT 'n',
  `can_send_email` char(1) NOT NULL DEFAULT 'n',
  `can_send_cached_email` char(1) NOT NULL DEFAULT 'n',
  `can_email_member_groups` char(1) NOT NULL DEFAULT 'n',
  `can_email_mailinglist` char(1) NOT NULL DEFAULT 'n',
  `can_email_from_profile` char(1) NOT NULL DEFAULT 'n',
  `can_view_profiles` char(1) NOT NULL DEFAULT 'n',
  `can_delete_self` char(1) NOT NULL DEFAULT 'n',
  `mbr_delete_notify_emails` varchar(255) NOT NULL,
  `can_post_comments` char(1) NOT NULL DEFAULT 'n',
  `exclude_from_moderation` char(1) NOT NULL DEFAULT 'n',
  `can_search` char(1) NOT NULL DEFAULT 'n',
  `search_flood_control` mediumint(5) unsigned NOT NULL,
  `can_send_private_messages` char(1) NOT NULL DEFAULT 'n',
  `prv_msg_send_limit` smallint(5) unsigned NOT NULL DEFAULT '20',
  `prv_msg_storage_limit` smallint(5) unsigned NOT NULL DEFAULT '60',
  `can_attach_in_private_messages` char(1) NOT NULL DEFAULT 'n',
  `can_send_bulletins` char(1) NOT NULL DEFAULT 'n',
  `include_in_authorlist` char(1) NOT NULL DEFAULT 'n',
  `include_in_memberlist` char(1) NOT NULL DEFAULT 'y',
  `include_in_mailinglists` char(1) NOT NULL DEFAULT 'y',
  KEY `group_id` (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_member_groups` WRITE;
/*!40000 ALTER TABLE `exp_member_groups` DISABLE KEYS */;
INSERT INTO `exp_member_groups` (`group_id`,`site_id`,`group_title`,`group_description`,`is_locked`,`can_view_offline_system`,`can_view_online_system`,`can_access_cp`,`can_access_publish`,`can_access_edit`,`can_access_design`,`can_access_comm`,`can_access_modules`,`can_access_admin`,`can_admin_weblogs`,`can_admin_members`,`can_delete_members`,`can_admin_mbr_groups`,`can_admin_mbr_templates`,`can_ban_users`,`can_admin_utilities`,`can_admin_preferences`,`can_admin_modules`,`can_admin_templates`,`can_edit_categories`,`can_delete_categories`,`can_view_other_entries`,`can_edit_other_entries`,`can_assign_post_authors`,`can_delete_self_entries`,`can_delete_all_entries`,`can_view_other_comments`,`can_edit_own_comments`,`can_delete_own_comments`,`can_edit_all_comments`,`can_delete_all_comments`,`can_moderate_comments`,`can_send_email`,`can_send_cached_email`,`can_email_member_groups`,`can_email_mailinglist`,`can_email_from_profile`,`can_view_profiles`,`can_delete_self`,`mbr_delete_notify_emails`,`can_post_comments`,`exclude_from_moderation`,`can_search`,`search_flood_control`,`can_send_private_messages`,`prv_msg_send_limit`,`prv_msg_storage_limit`,`can_attach_in_private_messages`,`can_send_bulletins`,`include_in_authorlist`,`include_in_memberlist`,`include_in_mailinglists`)
VALUES
	(1,1,'Super Admins','','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','','y','y','y',0,'y',20,60,'y','y','y','y','y'),
	(2,1,'Banned','','y','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','','n','n','n',60,'n',20,60,'n','n','n','n','n'),
	(3,1,'Guests','','y','n','y','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','y','n','','y','n','y',15,'n',20,60,'n','n','n','n','n'),
	(4,1,'Pending','','y','n','y','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','y','n','','y','n','y',15,'n',20,60,'n','n','n','n','n'),
	(5,1,'Members','','n','n','y','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','n','y','y','n','','y','n','y',10,'y',20,60,'y','n','n','y','y'),
	(6,1,'Admin','','n','y','y','y','y','y','n','n','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','y','','y','y','y',0,'y',20,60,'y','y','y','y','y');

/*!40000 ALTER TABLE `exp_member_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_member_homepage
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_member_homepage`;

CREATE TABLE `exp_member_homepage` (
  `member_id` int(10) unsigned NOT NULL,
  `recent_entries` char(1) NOT NULL DEFAULT 'l',
  `recent_entries_order` int(3) unsigned NOT NULL DEFAULT '0',
  `recent_comments` char(1) NOT NULL DEFAULT 'l',
  `recent_comments_order` int(3) unsigned NOT NULL DEFAULT '0',
  `recent_members` char(1) NOT NULL DEFAULT 'n',
  `recent_members_order` int(3) unsigned NOT NULL DEFAULT '0',
  `site_statistics` char(1) NOT NULL DEFAULT 'r',
  `site_statistics_order` int(3) unsigned NOT NULL DEFAULT '0',
  `member_search_form` char(1) NOT NULL DEFAULT 'n',
  `member_search_form_order` int(3) unsigned NOT NULL DEFAULT '0',
  `notepad` char(1) NOT NULL DEFAULT 'r',
  `notepad_order` int(3) unsigned NOT NULL DEFAULT '0',
  `bulletin_board` char(1) NOT NULL DEFAULT 'r',
  `bulletin_board_order` int(3) unsigned NOT NULL DEFAULT '0',
  `pmachine_news_feed` char(1) NOT NULL DEFAULT 'n',
  `pmachine_news_feed_order` int(3) unsigned NOT NULL DEFAULT '0',
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_member_homepage` WRITE;
/*!40000 ALTER TABLE `exp_member_homepage` DISABLE KEYS */;
INSERT INTO `exp_member_homepage` (`member_id`,`recent_entries`,`recent_entries_order`,`recent_comments`,`recent_comments_order`,`recent_members`,`recent_members_order`,`site_statistics`,`site_statistics_order`,`member_search_form`,`member_search_form_order`,`notepad`,`notepad_order`,`bulletin_board`,`bulletin_board_order`,`pmachine_news_feed`,`pmachine_news_feed_order`)
VALUES
	(1,'l',1,'l',2,'n',0,'r',1,'n',0,'n',2,'n',0,'n',0),
	(8,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(7,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(10,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(15,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(16,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(17,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(18,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0),
	(19,'l',0,'l',0,'n',0,'r',0,'n',0,'r',0,'r',0,'n',0);

/*!40000 ALTER TABLE `exp_member_homepage` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_member_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_member_search`;

CREATE TABLE `exp_member_search` (
  `search_id` varchar(32) NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `search_date` int(10) unsigned NOT NULL,
  `keywords` varchar(200) NOT NULL,
  `fields` varchar(200) NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `total_results` int(8) unsigned NOT NULL,
  `query` text NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `member_id` (`member_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_members
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_members`;

CREATE TABLE `exp_members` (
  `member_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` smallint(4) NOT NULL DEFAULT '0',
  `weblog_id` int(6) unsigned NOT NULL DEFAULT '0',
  `tmpl_group_id` int(6) unsigned NOT NULL DEFAULT '0',
  `upload_id` int(6) unsigned NOT NULL DEFAULT '0',
  `username` varchar(50) NOT NULL,
  `screen_name` varchar(50) NOT NULL,
  `password` varchar(40) NOT NULL,
  `unique_id` varchar(40) NOT NULL,
  `authcode` varchar(10) NOT NULL,
  `email` varchar(50) NOT NULL,
  `url` varchar(75) NOT NULL,
  `location` varchar(50) NOT NULL,
  `occupation` varchar(80) NOT NULL,
  `interests` varchar(120) NOT NULL,
  `bday_d` int(2) NOT NULL,
  `bday_m` int(2) NOT NULL,
  `bday_y` int(4) NOT NULL,
  `aol_im` varchar(50) NOT NULL,
  `yahoo_im` varchar(50) NOT NULL,
  `msn_im` varchar(50) NOT NULL,
  `icq` varchar(50) NOT NULL,
  `bio` text NOT NULL,
  `signature` text NOT NULL,
  `avatar_filename` varchar(120) NOT NULL,
  `avatar_width` int(4) unsigned NOT NULL,
  `avatar_height` int(4) unsigned NOT NULL,
  `photo_filename` varchar(120) NOT NULL,
  `photo_width` int(4) unsigned NOT NULL,
  `photo_height` int(4) unsigned NOT NULL,
  `sig_img_filename` varchar(120) NOT NULL,
  `sig_img_width` int(4) unsigned NOT NULL,
  `sig_img_height` int(4) unsigned NOT NULL,
  `ignore_list` text NOT NULL,
  `private_messages` int(4) unsigned NOT NULL DEFAULT '0',
  `accept_messages` char(1) NOT NULL DEFAULT 'y',
  `last_view_bulletins` int(10) NOT NULL DEFAULT '0',
  `last_bulletin_date` int(10) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `join_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_visit` int(10) unsigned NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `total_entries` smallint(5) unsigned NOT NULL DEFAULT '0',
  `total_comments` smallint(5) unsigned NOT NULL DEFAULT '0',
  `total_forum_topics` mediumint(8) NOT NULL DEFAULT '0',
  `total_forum_posts` mediumint(8) NOT NULL DEFAULT '0',
  `last_entry_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_comment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_forum_post_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_email_date` int(10) unsigned NOT NULL DEFAULT '0',
  `in_authorlist` char(1) NOT NULL DEFAULT 'n',
  `accept_admin_email` char(1) NOT NULL DEFAULT 'y',
  `accept_user_email` char(1) NOT NULL DEFAULT 'y',
  `notify_by_default` char(1) NOT NULL DEFAULT 'y',
  `notify_of_pm` char(1) NOT NULL DEFAULT 'y',
  `display_avatars` char(1) NOT NULL DEFAULT 'y',
  `display_signatures` char(1) NOT NULL DEFAULT 'y',
  `smart_notifications` char(1) NOT NULL DEFAULT 'y',
  `language` varchar(50) NOT NULL,
  `timezone` varchar(8) NOT NULL,
  `daylight_savings` char(1) NOT NULL DEFAULT 'n',
  `localization_is_site_default` char(1) NOT NULL DEFAULT 'n',
  `time_format` char(2) NOT NULL DEFAULT 'us',
  `cp_theme` varchar(32) NOT NULL,
  `profile_theme` varchar(32) NOT NULL,
  `forum_theme` varchar(32) NOT NULL,
  `tracker` text NOT NULL,
  `template_size` varchar(2) NOT NULL DEFAULT '28',
  `notepad` text NOT NULL,
  `notepad_size` varchar(2) NOT NULL DEFAULT '18',
  `quick_links` text NOT NULL,
  `quick_tabs` text NOT NULL,
  `pmember_id` int(10) NOT NULL DEFAULT '0',
  `profile_views` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`member_id`),
  KEY `group_id` (`group_id`),
  KEY `unique_id` (`unique_id`),
  KEY `password` (`password`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_members` WRITE;
/*!40000 ALTER TABLE `exp_members` DISABLE KEYS */;
INSERT INTO `exp_members` (`member_id`,`group_id`,`weblog_id`,`tmpl_group_id`,`upload_id`,`username`,`screen_name`,`password`,`unique_id`,`authcode`,`email`,`url`,`location`,`occupation`,`interests`,`bday_d`,`bday_m`,`bday_y`,`aol_im`,`yahoo_im`,`msn_im`,`icq`,`bio`,`signature`,`avatar_filename`,`avatar_width`,`avatar_height`,`photo_filename`,`photo_width`,`photo_height`,`sig_img_filename`,`sig_img_width`,`sig_img_height`,`ignore_list`,`private_messages`,`accept_messages`,`last_view_bulletins`,`last_bulletin_date`,`ip_address`,`join_date`,`last_visit`,`last_activity`,`total_entries`,`total_comments`,`total_forum_topics`,`total_forum_posts`,`last_entry_date`,`last_comment_date`,`last_forum_post_date`,`last_email_date`,`in_authorlist`,`accept_admin_email`,`accept_user_email`,`notify_by_default`,`notify_of_pm`,`display_avatars`,`display_signatures`,`smart_notifications`,`language`,`timezone`,`daylight_savings`,`localization_is_site_default`,`time_format`,`cp_theme`,`profile_theme`,`forum_theme`,`tracker`,`template_size`,`notepad`,`notepad_size`,`quick_links`,`quick_tabs`,`pmember_id`,`profile_views`)
VALUES
	(1,1,0,0,0,'jamiepittock','Jamie Pittock','c6960548ec9a52fbd201591b5745da2e3f22b254','b77b70550c67daa6fd01469bebb4a5fc1da8142a','','jamie@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.226',1246621579,1296683651,1296724179,7,0,0,0,1296658590,0,0,0,'n','y','y','y','y','y','y','y','english','UTC','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(15,1,0,0,0,'mattsmith','Matt Smith','3f5005aab17d0ac4ac1327237c53ad461fb34e8a','8490cf5bc2d236a7b8964bf48c3124f959302078','','matt@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1278090769,1278091001,1292416546,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|2\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|3',0,0),
	(8,1,0,0,0,'philswan','Phil Swan','0b008451e769666699eeb7823ee6c11a69c4ffe9','a7d3f69e59651eebf2c20f3b1324e3d0fdc10875','','phil@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.224',1246873664,1265134003,1278090879,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(7,1,0,0,0,'gregwood','Greg Wood','f62facfb886a502eeb4183136fcb56225ce1a852','7a87cf17375270d378ae21e48d2c284769a5d4ac','','greg@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.224',1246873640,1296655004,1296667492,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(10,1,0,0,0,'wil.linssen','Wil Linssen','431f3be4311312d8f6797650aa6b68dee3400e0f','2672d99660bfd02f706205db7408f38ebc4fd625','','wil@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1265121233,1276523330,1278090933,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(16,1,0,0,0,'jameswillock','James Willock','45a94bd18a0f1473c227f0a9005d22ea0164e344','3662e62db7aa6661e450aa939796204b70e20828','','james@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1278090813,1278091072,1278091072,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(17,1,0,0,0,'philhowell','Phil Howell','51b945d3ba3c297c10c16f25fa1c04eaa66302c7','282ff1f0c069d5e3ee77946e297c5fbfaa4f2a54','','phil.howell@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1292409816,0,0,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5',0,0),
	(18,1,0,0,0,'garrett.winder','Garrett Winder','09b427cf5f4db125f294bf49ea0cdcc8ba9ff8c7','4540bd829211b44f0d8ea3c824d61012ac38423c','','garrett@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.226',1296232888,1296577437,1296674132,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5',0,0),
	(19,6,0,0,0,'simoncampbell','Simon Campbell','f1818d8a9fdfe11e67602d39667f33571fa5ad0f','8e0d2a4c85e783648727c20d9d148bf43937e280','','simon@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.226',1296657072,1296657167,1296657167,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1',0,0);

/*!40000 ALTER TABLE `exp_members` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_message_attachments
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_message_attachments`;

CREATE TABLE `exp_message_attachments` (
  `attachment_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment_name` varchar(50) NOT NULL DEFAULT '',
  `attachment_hash` varchar(40) NOT NULL DEFAULT '',
  `attachment_extension` varchar(20) NOT NULL DEFAULT '',
  `attachment_location` varchar(125) NOT NULL DEFAULT '',
  `attachment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment_size` int(10) unsigned NOT NULL DEFAULT '0',
  `is_temp` char(1) NOT NULL DEFAULT 'y',
  PRIMARY KEY (`attachment_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_message_copies
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_message_copies`;

CREATE TABLE `exp_message_copies` (
  `copy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `message_id` int(10) unsigned NOT NULL DEFAULT '0',
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `recipient_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_received` char(1) NOT NULL DEFAULT 'n',
  `message_read` char(1) NOT NULL DEFAULT 'n',
  `message_time_read` int(10) unsigned NOT NULL DEFAULT '0',
  `attachment_downloaded` char(1) NOT NULL DEFAULT 'n',
  `message_folder` int(10) unsigned NOT NULL DEFAULT '1',
  `message_authcode` varchar(10) NOT NULL DEFAULT '',
  `message_deleted` char(1) NOT NULL DEFAULT 'n',
  `message_status` varchar(10) NOT NULL DEFAULT '',
  PRIMARY KEY (`copy_id`),
  KEY `message_id` (`message_id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_message_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_message_data`;

CREATE TABLE `exp_message_data` (
  `message_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL DEFAULT '0',
  `message_date` int(10) unsigned NOT NULL DEFAULT '0',
  `message_subject` varchar(255) NOT NULL DEFAULT '',
  `message_body` text NOT NULL,
  `message_tracking` char(1) NOT NULL DEFAULT 'y',
  `message_attachments` char(1) NOT NULL DEFAULT 'n',
  `message_recipients` varchar(200) NOT NULL DEFAULT '',
  `message_cc` varchar(200) NOT NULL DEFAULT '',
  `message_hide_cc` char(1) NOT NULL DEFAULT 'n',
  `message_sent_copy` char(1) NOT NULL DEFAULT 'n',
  `total_recipients` int(5) unsigned NOT NULL DEFAULT '0',
  `message_status` varchar(25) NOT NULL DEFAULT '',
  PRIMARY KEY (`message_id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_message_folders
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_message_folders`;

CREATE TABLE `exp_message_folders` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `folder1_name` varchar(50) NOT NULL DEFAULT 'InBox',
  `folder2_name` varchar(50) NOT NULL DEFAULT 'Sent',
  `folder3_name` varchar(50) NOT NULL DEFAULT '',
  `folder4_name` varchar(50) NOT NULL DEFAULT '',
  `folder5_name` varchar(50) NOT NULL DEFAULT '',
  `folder6_name` varchar(50) NOT NULL DEFAULT '',
  `folder7_name` varchar(50) NOT NULL DEFAULT '',
  `folder8_name` varchar(50) NOT NULL DEFAULT '',
  `folder9_name` varchar(50) NOT NULL DEFAULT '',
  `folder10_name` varchar(50) NOT NULL DEFAULT '',
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_message_folders` WRITE;
/*!40000 ALTER TABLE `exp_message_folders` DISABLE KEYS */;
INSERT INTO `exp_message_folders` (`member_id`,`folder1_name`,`folder2_name`,`folder3_name`,`folder4_name`,`folder5_name`,`folder6_name`,`folder7_name`,`folder8_name`,`folder9_name`,`folder10_name`)
VALUES
	(1,'InBox','Sent','','','','','','','',''),
	(10,'InBox','Sent','','','','','','','',''),
	(8,'InBox','Sent','','','','','','','',''),
	(7,'InBox','Sent','','','','','','','',''),
	(15,'InBox','Sent','','','','','','','',''),
	(16,'InBox','Sent','','','','','','','','');

/*!40000 ALTER TABLE `exp_message_folders` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_message_listed
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_message_listed`;

CREATE TABLE `exp_message_listed` (
  `listed_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `listed_member` int(10) unsigned NOT NULL DEFAULT '0',
  `listed_description` varchar(100) NOT NULL DEFAULT '',
  `listed_type` varchar(10) NOT NULL DEFAULT 'blocked',
  PRIMARY KEY (`listed_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_module_member_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_module_member_groups`;

CREATE TABLE `exp_module_member_groups` (
  `group_id` smallint(4) unsigned NOT NULL,
  `module_id` mediumint(5) unsigned NOT NULL,
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_module_member_groups` WRITE;
/*!40000 ALTER TABLE `exp_module_member_groups` DISABLE KEYS */;
INSERT INTO `exp_module_member_groups` (`group_id`,`module_id`)
VALUES
	(6,19),
	(6,24),
	(6,23),
	(6,22);

/*!40000 ALTER TABLE `exp_module_member_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_modules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_modules`;

CREATE TABLE `exp_modules` (
  `module_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `module_name` varchar(50) NOT NULL,
  `module_version` varchar(12) NOT NULL,
  `has_cp_backend` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`module_id`)
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_modules` WRITE;
/*!40000 ALTER TABLE `exp_modules` DISABLE KEYS */;
INSERT INTO `exp_modules` (`module_id`,`module_name`,`module_version`,`has_cp_backend`)
VALUES
	(1,'Comment','1.2','n'),
	(4,'Member','1.3','n'),
	(5,'Query','1.0','n'),
	(7,'Rss','1.0','n'),
	(8,'Stats','1.0','n'),
	(10,'Weblog','1.2','n'),
	(11,'Search','1.2','n'),
	(16,'Reeorder','1.2','y'),
	(24,'Low_variables','1.3.4','y'),
	(17,'Email','1.1','n'),
	(18,'Super_search','1.1.0.b2','y'),
	(19,'User','3.1.0','y'),
	(20,'Pur_member_utilities','1.0.3','y'),
	(22,'Cartthrob','0.9457','y'),
	(23,'Freeform','3.0.5','y');

/*!40000 ALTER TABLE `exp_modules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_mx_action_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_mx_action_data`;

CREATE TABLE `exp_mx_action_data` (
  `id` int(255) unsigned NOT NULL AUTO_INCREMENT,
  `action` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `data` text NOT NULL,
  `created_at` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_mx_action_data` WRITE;
/*!40000 ALTER TABLE `exp_mx_action_data` DISABLE KEYS */;
INSERT INTO `exp_mx_action_data` (`id`,`action`,`email_address`,`data`,`created_at`)
VALUES
	(1,'signup','jamiepittock@me.com','a:5:{s:10:\"sessionKey\";s:40:\"675a1ce4a6238b97f5a10a1ff51bbe1fc976554b\";s:6:\"action\";a:1:{s:2:\"id\";i:9699670;}s:10:\"actionPage\";a:10:{s:2:\"id\";i:55330;s:4:\"name\";s:7:\"Sign-up\";s:5:\"title\";s:7:\"Sign-up\";s:11:\"description\";N;s:3:\"url\";s:45:\"http://energynation.od.grassroots.com/signup/\";s:13:\"isIssueAction\";b:0;s:14:\"expirationDate\";N;s:11:\"publishDate\";s:19:\"2010-04-14T10:12:03\";s:12:\"assignedDate\";N;s:22:\"authenticationRequired\";b:0;}s:6:\"status\";a:2:{s:4:\"code\";i:200;s:7:\"message\";s:2:\"OK\";}s:6:\"member\";a:16:{s:12:\"emailAddress\";s:19:\"jamiepittock@me.com\";s:9:\"firstName\";s:5:\"Jamie\";s:8:\"lastName\";s:7:\"Pittock\";s:8:\"address1\";s:17:\"4 Walker\'s Place\";s:4:\"city\";s:7:\"Silsden\";s:5:\"state\";s:2:\"AK\";s:10:\"postalCode\";s:5:\"12345\";s:14:\"optInIpAddress\";N;s:14:\"optInTimestamp\";N;s:27:\"industryRelationshipExplain\";N;s:15:\"signUpTimestamp\";s:19:\"2010-06-30T02:45:10\";s:15:\"signUpIPAddress\";s:12:\"88.97.41.226\";s:11:\"unsubscribe\";b:1;s:5:\"isNew\";b:0;s:2:\"id\";i:8911901;s:14:\"postalCodeExt4\";s:0:\"\";}}','1277905513');

/*!40000 ALTER TABLE `exp_mx_action_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_nsm_acl_roles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_nsm_acl_roles`;

CREATE TABLE `exp_nsm_acl_roles` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `member_id` int(10) NOT NULL,
  `site_id` int(10) NOT NULL,
  `weblog_id` int(10) NOT NULL,
  `class_name` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL,
  PRIMARY KEY (`id`,`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_nsm_entry_drafts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_nsm_entry_drafts`;

CREATE TABLE `exp_nsm_entry_drafts` (
  `draft_id` int(10) NOT NULL AUTO_INCREMENT,
  `entry_id` int(10) NOT NULL,
  `site_id` int(4) NOT NULL,
  `weblog_id` int(4) NOT NULL,
  `author_id` int(4) NOT NULL,
  `created_at` int(10) NOT NULL,
  `draft_data` text NOT NULL,
  `preview` varchar(1) NOT NULL,
  PRIMARY KEY (`draft_id`,`entry_id`)
) ENGINE=MyISAM AUTO_INCREMENT=135 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_nsm_entry_drafts` WRITE;
/*!40000 ALTER TABLE `exp_nsm_entry_drafts` DISABLE KEYS */;
INSERT INTO `exp_nsm_entry_drafts` (`draft_id`,`entry_id`,`site_id`,`weblog_id`,`author_id`,`created_at`,`draft_data`,`preview`)
VALUES
	(10,4,0,3,1,1276705494,'a:22:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";i:4;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:22:\"Say no to energy taxes\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:6:\"asdfsd\";s:10:\"field_ft_5\";s:4:\"none\";}',''),
	(11,4,0,3,1,1276705535,'a:23:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"4\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:22:\"Say no to energy taxes\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:7:\"preview\";s:19:\"nsm_pp_draft_submit\";s:10:\"field_id_5\";s:6:\"asdfsd\";s:10:\"field_ft_5\";s:4:\"none\";}',''),
	(12,5,0,13,1,1276714189,'a:33:{s:9:\"weblog_id\";s:2:\"13\";s:8:\"entry_id\";i:5;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 07:49 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:19:\"About Energy Nation\";s:9:\"url_title\";s:19:\"about-energy-nation\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_41\";s:4:\"none\";s:11:\"field_id_41\";s:17:\"<p>\n	Content</p>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(13,6,0,13,1,1276714202,'a:33:{s:9:\"weblog_id\";s:2:\"13\";s:8:\"entry_id\";i:6;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 07:49 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:14:\"Privacy Policy\";s:9:\"url_title\";s:14:\"privacy-policy\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_41\";s:4:\"none\";s:11:\"field_id_41\";s:18:\"<p>\n	Content.</p>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(14,7,0,13,1,1276714214,'a:33:{s:9:\"weblog_id\";s:2:\"13\";s:8:\"entry_id\";i:7;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 07:50 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:12:\"Terms of Use\";s:9:\"url_title\";s:12:\"terms-of-use\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_41\";s:4:\"none\";s:11:\"field_id_41\";s:18:\"<p>\n	Content.</p>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(15,7,0,13,1,1276714744,'a:34:{s:9:\"weblog_id\";s:2:\"13\";s:8:\"entry_id\";s:1:\"7\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 07:50 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"13\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:12:\"Terms of Use\";s:9:\"url_title\";s:12:\"terms-of-use\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_41\";s:4:\"none\";s:11:\"field_id_41\";s:18:\"<p>\n	Content.</p>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(16,8,0,3,1,1276715656,'a:22:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";i:8;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:13 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:22:\"This is another banner\";s:9:\"url_title\";s:22:\"this-is-another-banner\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:6:\"Conte.\";s:10:\"field_ft_5\";s:4:\"none\";}',''),
	(17,9,0,3,1,1276715674,'a:23:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";i:9;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:26:\"One more banner label here\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:8:\"Content.\";s:10:\"field_ft_5\";s:4:\"none\";}',''),
	(18,10,0,3,1,1276715689,'a:22:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";i:10;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"A final banner label goes here\";s:9:\"url_title\";s:30:\"a-final-banner-label-goes-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:8:\"Content.\";s:10:\"field_ft_5\";s:4:\"none\";}',''),
	(19,11,0,4,1,1276751355,'a:29:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";i:11;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:95:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actually-be-used-on-the-frontend\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:10:\"field_id_7\";s:3:\"234\";s:10:\"field_ft_7\";s:4:\"none\";s:10:\"field_id_8\";s:0:\"\";s:10:\"field_ft_8\";s:5:\"xhtml\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";}',''),
	(20,12,0,7,1,1276752419,'a:23:{s:9:\"weblog_id\";s:1:\"7\";s:8:\"entry_id\";i:12;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:25 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:19:\"The Washington Post\";s:9:\"url_title\";s:19:\"the-washington-post\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_24\";s:4:\"none\";s:11:\"field_id_24\";s:29:\"http://www.washingtonpost.com\";s:11:\"field_ft_25\";s:4:\"none\";}',''),
	(21,12,0,7,1,1276752992,'a:25:{s:9:\"weblog_id\";s:1:\"7\";s:8:\"entry_id\";s:2:\"12\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:25 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"7\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:19:\"The Washington Post\";s:9:\"url_title\";s:19:\"the-washington-post\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_24\";s:4:\"none\";s:11:\"field_id_24\";s:29:\"http://www.washingtonpost.com\";s:11:\"field_ft_25\";s:4:\"none\";s:11:\"field_id_25\";s:18:\"washingtonpost.gif\";}',''),
	(22,13,0,8,1,1276753073,'a:39:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";i:13;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"The New Socialism\";s:9:\"url_title\";s:17:\"the-new-socialism\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:406:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:21:\"http://www.google.com\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:18:\"[1] Climate change\";s:11:\"field_id_28\";s:23:\"[2] The Washington Post\";}',''),
	(23,14,0,10,1,1276755088,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:14;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"This is just a photo\";s:9:\"url_title\";s:20:\"this-is-just-a-photo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:6:\"photos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:11:\"field_id_36\";s:18:\"[3] Climate change\";}',''),
	(24,14,0,10,1,1276755290,'a:44:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"14\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"This is just a photo\";s:9:\"url_title\";s:20:\"this-is-just-a-photo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"photos\nstories\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_36\";s:18:\"[3] Climate change\";}',''),
	(25,14,0,10,1,1276755311,'a:44:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"14\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"This is just a photo\";s:9:\"url_title\";s:20:\"this-is-just-a-photo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:6:\"photos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_36\";s:18:\"[3] Climate change\";}',''),
	(26,15,0,10,1,1276756212,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:15;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:29 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:27:\"This is just a story (text)\";s:9:\"url_title\";s:25:\"this-is-just-a-story-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:7:\"stories\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:18:\"[4] Climate change\";}',''),
	(27,16,0,10,1,1276756334,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:16;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:31 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"This is a photo and text\";s:9:\"url_title\";s:24:\"this-is-a-photo-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"photos\nstories\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:18:\"[5] Climate change\";}',''),
	(28,16,0,10,1,1276756444,'a:44:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"16\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:31 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"This is a photo and text\";s:9:\"url_title\";s:24:\"this-is-a-photo-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"photos\nstories\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:11:\"field_id_36\";s:18:\"[5] Climate change\";}',''),
	(29,17,0,10,1,1276756510,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:17;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:34 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"This is just a video\";s:9:\"url_title\";s:20:\"this-is-just-a-video\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:6:\"videos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:18:\"[6] Climate change\";}',''),
	(30,18,0,10,1,1276756593,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:18;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:36 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"This is a video and text\";s:9:\"url_title\";s:24:\"this-is-a-video-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"stories\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:18:\"[7] Climate change\";}',''),
	(31,19,0,10,1,1276756635,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:19;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:36 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:31:\"This is a video, photo and text\";s:9:\"url_title\";s:30:\"this-is-a-video-photo-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:21:\"photos\nstories\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:11:\"field_id_36\";s:18:\"[8] Climate change\";}',''),
	(32,20,0,10,1,1276756666,'a:43:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";i:20;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:27:\"This is a photo and a video\";s:9:\"url_title\";s:27:\"this-is-a-photo-and-a-video\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:13:\"photos\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:11:\"field_id_36\";s:18:\"[9] Climate change\";}',''),
	(36,20,0,10,1,1276776277,'a:53:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"20\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:42:\"This is a photo and a video blah blah blah\";s:9:\"url_title\";s:27:\"this-is-a-photo-and-a-video\";s:7:\"preview\";s:19:\"nsm_pp_draft_submit\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_id_36\";a:2:{s:3:\"old\";s:18:\"[9] Climate change\";s:10:\"selections\";a:2:{i:0;s:0:\"\";i:1;s:1:\"3\";}}s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";a:2:{i:0;s:6:\"photos\";i:1;s:6:\"videos\";}s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";a:2:{s:3:\"old\";s:0:\"\";s:3:\"new\";s:0:\"\";}s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";a:3:{s:9:\"file_name\";s:16:\"sarah_millie.jpg\";s:6:\"delete\";s:0:\"\";s:8:\"existing\";s:0:\"\";}s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:15:\"field_id_36_old\";s:18:\"[9] Climate change\";s:22:\"field_id_36_selections\";a:2:{i:0;s:0:\"\";i:1;s:1:\"3\";}s:13:\"field_id_43_0\";s:6:\"photos\";s:13:\"field_id_43_1\";s:6:\"videos\";s:15:\"field_id_33_old\";s:0:\"\";s:15:\"field_id_33_new\";s:0:\"\";s:21:\"field_id_42_file_name\";s:16:\"sarah_millie.jpg\";s:18:\"field_id_42_delete\";s:0:\"\";s:20:\"field_id_42_existing\";s:0:\"\";}',''),
	(38,11,0,4,1,1276785187,'a:29:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:75:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actually-be-\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:10:\"field_id_7\";s:3:\"234\";s:10:\"field_ft_7\";s:4:\"none\";s:10:\"field_id_8\";s:0:\"\";s:10:\"field_ft_8\";s:5:\"xhtml\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:2:\"12\";}',''),
	(40,23,0,12,1,1277138247,'a:37:{s:9:\"weblog_id\";s:2:\"12\";s:8:\"entry_id\";i:23;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-21 05:35 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:26:\"This is an e-communication\";s:9:\"url_title\";s:26:\"this-is-an-e-communication\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_44\";s:4:\"none\";s:11:\"field_id_44\";i:1273014001;s:11:\"field_ft_39\";s:4:\"none\";s:11:\"field_id_39\";s:474:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n\";s:11:\"field_ft_45\";s:4:\"none\";s:11:\"field_id_45\";s:0:\"\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(41,4,0,3,1,1277184322,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"4\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:26:\"This is a banner tab label\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:64:\"Energy Nation:  9.2 million jobs across a wide range of sectors.\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"Learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:11:\"/blah/blah/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:11:\"banner1.jpg\";}',''),
	(42,10,0,3,1,1277184510,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:2:\"10\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"This is a banner tab label (2)\";s:9:\"url_title\";s:30:\"a-final-banner-label-goes-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:67:\"How many lost jobs could result from the ban on deepwater drilling?\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"Learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:11:\"/blah/blah/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";N;}',''),
	(43,4,0,3,1,1277184520,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"4\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"This is a banner tab label (1)\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:64:\"Energy Nation:  9.2 million jobs across a wide range of sectors.\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"Learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:11:\"/blah/blah/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:11:\"banner1.jpg\";}',''),
	(44,8,0,3,1,1277184547,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"8\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:13 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"This is a banner tab label (3)\";s:9:\"url_title\";s:22:\"this-is-another-banner\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:22:\"Make your voice heard.\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:11:\"Take action\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:11:\"/blah/blah/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";N;}',''),
	(45,9,0,3,1,1277184574,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"9\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"This is a banner tab label (4)\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:68:\"How does offshore drilling provide America with the energy it needs?\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"Learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:11:\"/blah/blah/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";N;}',''),
	(46,24,0,12,1,1277185201,'a:37:{s:9:\"weblog_id\";s:2:\"12\";s:8:\"entry_id\";i:24;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 06:39 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"This is another ecommunication\";s:9:\"url_title\";s:30:\"this-is-another-ecommunication\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_44\";s:4:\"none\";s:11:\"field_id_44\";i:1277074801;s:11:\"field_ft_39\";s:4:\"none\";s:11:\"field_id_39\";s:315:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n\";s:11:\"field_ft_45\";s:4:\"none\";s:11:\"field_id_45\";s:0:\"\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(47,25,0,12,1,1277185311,'a:37:{s:9:\"weblog_id\";s:2:\"12\";s:8:\"entry_id\";i:25;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 06:41 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:23:\"One more ecommunication\";s:9:\"url_title\";s:23:\"one-more-ecommunication\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_44\";s:4:\"none\";s:11:\"field_id_44\";i:1276815601;s:11:\"field_ft_39\";s:4:\"none\";s:11:\"field_id_39\";s:315:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n\";s:11:\"field_ft_45\";s:4:\"none\";s:11:\"field_id_45\";s:0:\"\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(48,26,0,11,1,1277186099,'a:37:{s:9:\"weblog_id\";s:2:\"11\";s:8:\"entry_id\";i:26;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 06:54 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:36:\"This is the title of a press release\";s:9:\"url_title\";s:36:\"this-is-the-title-of-a-press-release\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_46\";s:4:\"none\";s:11:\"field_id_46\";s:315:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n\";s:11:\"field_ft_47\";s:4:\"none\";s:11:\"field_ft_38\";s:4:\"none\";s:11:\"field_id_38\";s:1272:\"<p>\n	&nbsp;</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n	<p>\n		&nbsp;</p>\n	<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n		<p>\n			Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n	</div>\n</div>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_47\";N;}',''),
	(49,26,0,11,1,1277186436,'a:38:{s:9:\"weblog_id\";s:2:\"11\";s:8:\"entry_id\";s:2:\"26\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 06:54 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"11\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:36:\"This is the title of a press release\";s:9:\"url_title\";s:36:\"this-is-the-title-of-a-press-release\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_46\";s:4:\"none\";s:11:\"field_id_46\";s:315:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n\";s:11:\"field_ft_47\";s:4:\"none\";s:11:\"field_ft_38\";s:4:\"none\";s:11:\"field_id_38\";s:1088:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n</div>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_47\";N;}',''),
	(50,26,0,11,1,1277186539,'a:38:{s:9:\"weblog_id\";s:2:\"11\";s:8:\"entry_id\";s:2:\"26\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 06:54 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"11\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:36:\"This is the title of a press release\";s:9:\"url_title\";s:36:\"this-is-the-title-of-a-press-release\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_46\";s:4:\"none\";s:11:\"field_id_46\";s:315:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n\";s:11:\"field_ft_47\";s:4:\"none\";s:11:\"field_ft_38\";s:4:\"none\";s:11:\"field_id_38\";s:1088:\"<p>\n	Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum. &nbsp;Ut volutpat pulvinar rutrum. Pellentesque velit magna, mollis ut tincidunt at, cursus quis augue. Suspendisse nec diam ac neque tristique vestibulum.</p>\n</div>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_47\";s:18:\"en-fields-plan.pdf\";}',''),
	(51,27,0,5,1,1277187168,'a:51:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:27;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_id_11\";s:0:\"\";s:11:\"field_ft_11\";s:4:\"none\";s:11:\"field_id_12\";s:0:\"\";s:11:\"field_ft_12\";s:4:\"none\";s:11:\"field_id_13\";s:0:\"\";s:11:\"field_ft_13\";s:5:\"xhtml\";s:11:\"field_ft_14\";s:4:\"none\";s:11:\"field_id_14\";s:0:\"\";s:11:\"field_id_15\";s:90:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\";s:11:\"field_ft_15\";s:4:\"none\";s:11:\"field_ft_16\";s:4:\"none\";s:11:\"field_ft_17\";s:4:\"none\";s:11:\"field_id_17\";s:1213:\"<p>\n	&nbsp;</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n	<p>\n		It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n	<p>\n		We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n</div>\n\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_16\";s:1:\"1\";}',''),
	(52,27,0,5,1,1277187182,'a:52:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_id_11\";s:0:\"\";s:11:\"field_ft_11\";s:4:\"none\";s:11:\"field_id_12\";s:0:\"\";s:11:\"field_ft_12\";s:4:\"none\";s:11:\"field_id_13\";s:0:\"\";s:11:\"field_ft_13\";s:5:\"xhtml\";s:11:\"field_ft_14\";s:4:\"none\";s:11:\"field_id_14\";s:0:\"\";s:11:\"field_id_15\";s:90:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\";s:11:\"field_ft_15\";s:4:\"none\";s:11:\"field_ft_16\";s:4:\"none\";s:11:\"field_ft_17\";s:4:\"none\";s:11:\"field_id_17\";s:1195:\"<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n	<p>\n		We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n</div>\n\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_16\";s:1:\"1\";}',''),
	(55,27,0,5,1,1277189593,'a:52:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_id_11\";s:0:\"\";s:11:\"field_ft_11\";s:4:\"none\";s:11:\"field_id_12\";s:0:\"\";s:11:\"field_ft_12\";s:4:\"none\";s:11:\"field_id_13\";s:0:\"\";s:11:\"field_ft_13\";s:5:\"xhtml\";s:11:\"field_ft_14\";s:4:\"none\";s:11:\"field_id_14\";s:0:\"\";s:11:\"field_id_15\";s:90:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\";s:11:\"field_ft_15\";s:4:\"none\";s:11:\"field_ft_16\";s:4:\"none\";s:11:\"field_ft_17\";s:4:\"none\";s:11:\"field_id_17\";s:1195:\"<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n	<p>\n		We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n</div>\n\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_16\";s:1:\"1\";}',''),
	(56,28,0,14,1,1277208778,'a:28:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";i:28;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:0:\"\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:0:\"\";s:11:\"field_id_51\";N;}',''),
	(57,27,0,5,1,1277225660,'a:52:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:11:\"field_id_15\";s:0:\"\";s:11:\"field_ft_15\";s:4:\"none\";s:11:\"field_ft_16\";s:4:\"none\";s:11:\"field_ft_17\";s:4:\"none\";s:11:\"field_id_17\";s:1195:\"<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n	<p>\n		We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n</div>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_16\";s:1:\"1\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1515:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	&nbsp;</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n	<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n		<p>\n			It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n		<p>\n			We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n	</div>\n</div>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(58,27,0,5,1,1277225674,'a:52:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:11:\"field_id_15\";s:0:\"\";s:11:\"field_ft_15\";s:4:\"none\";s:11:\"field_ft_16\";s:4:\"none\";s:11:\"field_ft_17\";s:4:\"none\";s:11:\"field_id_17\";s:1195:\"<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<p>\n		It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n	<p>\n		We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n</div>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_16\";s:1:\"1\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1497:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n	<div style=\\\"font-family: Arial, Verdana, sans-serif; font-size: 12px; color: rgb(34, 34, 34); background-color: rgb(255, 255, 255); \\\">\n		<p>\n			It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n		<p>\n			We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n	</div>\n</div>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(59,27,0,5,1,1277226184,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(60,27,0,5,1,1277226230,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(61,27,0,5,1,1277226402,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(67,5,0,13,1,1277227765,'a:34:{s:9:\"weblog_id\";s:2:\"13\";s:8:\"entry_id\";s:1:\"5\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 07:49 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"13\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:19:\"About Energy Nation\";s:9:\"url_title\";s:19:\"about-energy-nation\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_41\";s:4:\"none\";s:11:\"field_id_41\";s:2376:\"<p>\n	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean dictum est vitae ante vehicula dignissim. Phasellus adipiscing pulvinar mattis. Donec et mi mauris. Etiam at turpis et enim fringilla rhoncus adipiscing non mi. Praesent non nibh lectus. Donec <a href=\\\"http://www.google.com\\\">ipsum velit</a>, sagittis nec blandit quis, tempor a enim. Duis tincidunt adipiscing libero, eu convallis metus porta at. Fusce sapien magna, laoreet eu aliquet at, sagittis sit amet urna. Mauris quis quam et purus aliquet mollis.</p>\n<ul>\n	<li>\n		Line item 1</li>\n	<li>\n		Line item 2</li>\n	<li>\n		Line item 3</li>\n</ul>\n<h3>\n	This is a heading 3</h3>\n<p>\n	Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec posuere leo vel felis ullamcorper id pellentesque ante adipiscing. <a href=\\\"http://www.google.com\\\">Mauris placerat aliquet velit, ac aliquam</a> dui venenatis et. Praesent sed diam in eros vehicula consequat. Nam placerat ornare dui, a tincidunt nulla mollis eu. Proin non risus a dolor viverra aliquam. Aenean volutpat urna quis nunc vestibulum vel laoreet ante rutrum. Fusce posuere sollicitudin sem, quis accumsan metus dictum ut.</p>\n<ol>\n	<li>\n		Ordered list 1</li>\n	<li>\n		Ordered list 2</li>\n	<li>\n		Ordered list 3</li>\n</ol>\n<p>\n	Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. &nbsp;Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\n<blockquote>\n	<p>\n		Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. &nbsp;Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\n</blockquote>\n<p>\n	Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. &nbsp;Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\n<h4>\n	This is a heading 4</h4>\n<p>\n	Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit. &nbsp;Aliquam sed dui quis augue lobortis rhoncus nec eget tortor. Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>\n\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";}',''),
	(68,29,0,5,12,1277324482,'a:45:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:29;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:19 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:9:\"Oil Sands\";s:9:\"url_title\";s:9:\"oil-sands\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:49:\"Producing energy from our neighbors to the north.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:858:\"What do the oil sands mean to you and your job?\n<p>\n	Beneath the sands of Alberta lie 173 billion barrels of oil, reserves second only to those in Saudi Arabia. We are ready to deliver this important source of energy to the American people.</p>\n<p>\n	By responsibly developing these resources in Canada, we can create jobs here in America through refinery expansion and pipeline construction. By some accounts, this activity could support 600,000 new jobs by 2025, as well as add nearly $130 billion to the economy. Access to oil sands in Canada could provide a reliable supply of energy to more consumers in more parts of the country.</p>\n<p>\n	The refinery projects we are undertaking and the development of new technologies to better process oil from Canada will allow us to provide an important, affordable and reliable source of energy America needs.</p>\n\";}',''),
	(69,30,0,5,12,1277324639,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:30;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:21 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:33:\"OCS - The Outer Continental Shelf\";s:9:\"url_title\";s:31:\"ocs-the-outer-continental-shelf\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:40:\"The next great American energy frontier.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:0:\"\";}',''),
	(70,31,0,5,12,1277324817,'a:45:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:31;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Deepwater Moratorium\";s:9:\"url_title\";s:20:\"deepwater-moratorium\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:32:\"A ban on new deepwater drilling.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:1174:\"Will a ban on deepwater drilling affect future energy supply?\n<p>\n	Following the tragic Deepwater Horizon accident, we are mobilizing a tremendous amount of resources to aid in responding to the spill. Our industry understands the need to respond in a coordinated manner and we are&mdash;swiftly creating a task force to examine the spill&rsquo;s cause and working hard to assess and address its impact.</p>\n<p>\n	Unfortunately, Members of Congress, as well as the President and his Administration, have halted new deepwater drilling for at least six months. This move places our jobs and communities in economic peril.</p>\n<p>\n	According to one study, a ban on new deepwater drilling, when combined with tighter regulations and longer permitting timeframes, could result in the equivalent of 340,000 barrels of oil per day in lost production by 2015. This means nearly 50,000 jobs idled in the short term and potentially more than 120,000 if restrictions are extended. In this economy, we can&rsquo;t afford to lose more jobs and deprive Americans of the reliable and affordable energy they need.</p>\n\nâ€œA moratorium on deepwater drilling could jeopardize 100,000 jobs.â€ \";}',''),
	(71,32,0,5,12,1277324893,'a:45:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:32;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:27 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:14:\"Climate Change\";s:9:\"url_title\";s:14:\"climate-change\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:11:\"environment\";s:11:\"field_id_10\";s:58:\"Seeking a balanced approach to climate change legislation.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:1292:\"What does climate change legislation mean for you and your family?\n<p>\n	As an industry, we&rsquo;re committed to reducing greenhouse gas emissions and lower our environmental footprint. We&rsquo;re constantly enhancing efficiency and investing in new technologies that are changing the environmental effects of our work as we bring energy to consumers.</p>\n<p>\n	Congress continues to propose and debate well-intentioned measures that require companies to reduce their impact on the environment. We support this goal and are committed to finding solutions that promote environmental responsibility. However, many of the proposed measures would have unintended negative consequences, potentially putting millions of jobs at risk and raising costs for companies in our industry and others. Our elected officials must understand the need to balance the positive intent of legislation against the negative implications for consumers, jobs and the economy.</p>\n<p>\n	We are committed to protecting the environment. In fact, we&rsquo;re already working to reduce our carbon footprint. But we must be careful of proposals that could take away jobs from the hardworking people in our industry, make our industry less competitive or raise costs for the people that rely on us for affordable energy.</p>\n\";}',''),
	(72,33,0,5,12,1277324957,'a:45:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:33;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:28 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:11:\"Regulations\";s:9:\"url_title\";s:11:\"regulations\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:11:\"environment\";s:11:\"field_id_10\";s:44:\"A burden for an already -struggling economy.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:1135:\"Could additional regulations stifle economic growth?\n<p>\n	We recognize that we must be careful about our impact on the environment. Our companies are taking steps every day to reduce that impact, knowing that we must be able to provide affordable, responsibly produced energy to Americans for decades to come.</p>\n<p>\n	We are concerned, however, that heavy regulations, while well-intentioned, could have unintended but severe negative effects on the economy, the job market and on American businesses&mdash;without significantly improving our nation&rsquo;s carbon footprint. While we support the goal of taking measures to reduce emissions, we want to ensure that doing so will not be at the expense of jobs and the economy.</p>\n<p>\n	We&rsquo;re constantly taking steps to produce energy responsibly. One such example is our commitment to expand production and use of ultra-low sulfur diesel and other technologies, which would lead to a reduction of six common emissions by 60 percent. We remain committed to working with Congress and the administration to make positive changes that lower our environmental impact.&nbsp;&nbsp;</p>\n\";}',''),
	(73,34,0,5,12,1277325088,'a:45:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:34;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:29 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Taxes\";s:9:\"url_title\";s:5:\"taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:5:\"taxes\";s:11:\"field_id_10\";s:52:\"New taxes could hurt the economy and the job market.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:1173:\"Will new taxes threaten jobs and weaken energy independence?\n<p>\n	Producing America&rsquo;s resources of oil and natural gas isn&rsquo;t cheap. Our industry spends hundreds of billions of dollars every year on wages, technology and investment in research and development of energy resources.</p>\n<p>\n	What&rsquo;s more, the energy industry is one of the most heavily taxed industries in America. Industry taxes provide billions of dollars that support schools, first responders and our transportation system, among other vital public services. Yet Congress and the administration continue to propose new taxes on the industry. The latest proposal would mean at least $80 billion in new taxes.</p>\n<p>\n	We oppose new taxes not just because of their impact directly on our businesses, but of the far-reaching negative effects that they could bring to industry workers, consumers and the businesses and organizations that depend on our industry for reliable, affordable energy.</p>\n<p>\n	Instead of passing new taxes, we can show Congress and the administration that we are ready to lead an economic recovery by producing more oil and natural gas right here at home.&nbsp;</p>\n\";}',''),
	(74,35,0,5,12,1277325138,'a:45:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";i:35;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:31 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:4:\"Jobs\";s:9:\"url_title\";s:4:\"jobs\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:61:\"We represent 9.2 million jobs across a wide range of sectors.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:881:\"Just exactly how important is our industry to the American economy?\n<p>\n	We know how important our work is. More than 9.2 million people are directly or indirectly employed by America&rsquo;s oil and natural gas industry. That&rsquo;s 9.2 million people working hard to deliver the energy our country needs.</p>\n<p>\n	Whether it&rsquo;s passing new laws, regulations or taxes, Washington has a profound impact on our industry and jobs. New laws and regulations that raise the cost of energy or restrict access to resources of oil and natural gas could put thousands of jobs at risk and increase the costs of everything from food and transportation to heating a home.</p>\n<p>\n	We are part of the solution. Our 9.2 million jobs and more than a trillion dollars in value added to the economy play a major role in providing this country the energy it needs and driving the economy.</p>\n\";}',''),
	(100,35,0,5,1,1277724594,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"35\";s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:31 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:4:\"Jobs\";s:9:\"url_title\";s:4:\"jobs\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:7:\"economy\";s:11:\"field_id_10\";s:61:\"We represent 9.2 million jobs across a wide range of sectors.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:881:\"Just exactly how important is our industry to the American economy?\n<p>\n	We know how important our work is. More than 9.2 million people are directly or indirectly employed by America&rsquo;s oil and natural gas industry. That&rsquo;s 9.2 million people working hard to deliver the energy our country needs.</p>\n<p>\n	Whether it&rsquo;s passing new laws, regulations or taxes, Washington has a profound impact on our industry and jobs. New laws and regulations that raise the cost of energy or restrict access to resources of oil and natural gas could put thousands of jobs at risk and increase the costs of everything from food and transportation to heating a home.</p>\n<p>\n	We are part of the solution. Our 9.2 million jobs and more than a trillion dollars in value added to the economy play a major role in providing this country the energy it needs and driving the economy.</p>\n\";}',''),
	(76,27,0,5,1,1277460439,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:2:\"13\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(78,28,0,14,1,1277476091,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:0:\"\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:550:\"<p>\n	&nbsp;</p>\n<p style=\\\"zoom: 1; margin-top: 0px; margin-right: 0px; margin-bottom: 15px; margin-left: 0px; line-height: 22px; font-weight: normal; \\\">\n	Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation.<br />\n	The expanded Energy Nation network is still under construction, but it won&rsquo;t be long before we&rsquo;re up and running. Check your inbox for an email from us letting you know when we&rsquo;re ready to go!</p>\n\";s:11:\"field_id_51\";N;}',''),
	(79,28,0,14,1,1277476116,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:0:\"\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:251:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px; \\\">Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation</span>.</p>\n\";s:11:\"field_id_51\";N;}',''),
	(80,28,0,14,1,1277476129,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:0:\"\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:471:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px; \\\">Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation</span>.</p>\n<p>\n	The expanded Energy Nation network is still under construction, but it won&rsquo;t be long before we&rsquo;re up and running. Check your inbox for an email from us letting you know when we&rsquo;re ready to go!</p>\n\";s:11:\"field_id_51\";N;}',''),
	(81,28,0,14,1,1277476227,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:697:\"<p>\n	&nbsp;</p>\n<div id=\\\"cke_pastebin\\\">\n	You&rsquo;re just one step away from becoming a member of Energy Nation, a community where you can join the conversation about energy policy, share your thoughts about the oil and natural gas industry and take action on issues that affect our nation&rsquo;s energy future.</div>\n<div id=\\\"cke_pastebin\\\">\n	&nbsp;</div>\n<div id=\\\"cke_pastebin\\\">\n	In a few minutes, you will receive an email from Energy Nation at the email address you provided.</div>\n<div id=\\\"cke_pastebin\\\">\n	&nbsp;</div>\n<div id=\\\"cke_pastebin\\\">\n	Just click the link in the email to confirm that we have your correct information, and your registration process will be complete.</div>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:471:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px; \\\">Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation</span>.</p>\n<p>\n	The expanded Energy Nation network is still under construction, but it won&rsquo;t be long before we&rsquo;re up and running. Check your inbox for an email from us letting you know when we&rsquo;re ready to go!</p>\n\";s:11:\"field_id_51\";N;}',''),
	(82,28,0,14,1,1277476243,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:617:\"<p>\n	You&rsquo;re just one step away from becoming a member of Energy Nation, a community where you can join the conversation about energy policy, share your thoughts about the oil and natural gas industry and take action on issues that affect our nation&rsquo;s energy future.</p>\n<div id=\\\"cke_pastebin\\\">\n	In a few minutes, you will receive an email from Energy Nation at the email address you provided.</div>\n<div id=\\\"cke_pastebin\\\">\n	&nbsp;</div>\n<div id=\\\"cke_pastebin\\\">\n	Just click the link in the email to confirm that we have your correct information, and your registration process will be complete.</div>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:471:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px; \\\">Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation</span>.</p>\n<p>\n	The expanded Energy Nation network is still under construction, but it won&rsquo;t be long before we&rsquo;re up and running. Check your inbox for an email from us letting you know when we&rsquo;re ready to go!</p>\n\";s:11:\"field_id_51\";N;}',''),
	(83,28,0,14,1,1277476311,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:529:\"<p>\n	You&rsquo;re just one step away from becoming a member of Energy Nation, a community where you can join the conversation about energy policy, share your thoughts about the oil and natural gas industry and take action on issues that affect our nation&rsquo;s energy future.</p>\n<p>\n	In a few minutes, you will receive an email from Energy Nation at the email address you provided.</p>\n<p>\n	Just click the link in the email to confirm that we have your correct information, and your registration process will be complete.</p>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:471:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px; \\\">Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation</span>.</p>\n<p>\n	The expanded Energy Nation network is still under construction, but it won&rsquo;t be long before we&rsquo;re up and running. Check your inbox for an email from us letting you know when we&rsquo;re ready to go!</p>\n\";s:11:\"field_id_51\";N;}',''),
	(84,28,0,14,1,1277477115,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:545:\"<p>\n	Since 1845, we have gone to work every day to ensure that Americans have the energy we need when we need it. To get to work and school. To heat our homes. To feed our children.</p>\n<p>\n	We power the American way of life. We drive the American economy. And now, as a community, we come together to protect America&#39;s energy future.</p>\n<p>\n	We are geologists, engineers, refinery workers and retail managers, but first, we are parents, community leaders and volunteers. Individually we are citizens, and together we make up a nation.</p>\n\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:529:\"<p>\n	You&rsquo;re just one step away from becoming a member of Energy Nation, a community where you can join the conversation about energy policy, share your thoughts about the oil and natural gas industry and take action on issues that affect our nation&rsquo;s energy future.</p>\n<p>\n	In a few minutes, you will receive an email from Energy Nation at the email address you provided.</p>\n<p>\n	Just click the link in the email to confirm that we have your correct information, and your registration process will be complete.</p>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:471:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px; \\\">Thank you for confirming your email address. Your registration with Energy Nation is now complete! Stay tuned for issue alerts, news, and other updates from Energy Nation</span>.</p>\n<p>\n	The expanded Energy Nation network is still under construction, but it won&rsquo;t be long before we&rsquo;re up and running. Check your inbox for an email from us letting you know when we&rsquo;re ready to go!</p>\n\";s:11:\"field_id_51\";N;}',''),
	(85,28,0,14,1,1277478283,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:45:\"<p>\n	This will override the signup text.</p>\n\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:48:\"<p>\n	This will override the thank you text.</p>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:125:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px;\\\">This will override the confirmation page text.</span></p>\n\";s:11:\"field_id_51\";N;}',''),
	(86,37,0,14,1,1277478429,'a:28:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";i:37;s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-25 04:06 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:12:\"Total Safety\";s:9:\"url_title\";s:12:\"total-safety\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:0:\"\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:0:\"\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:0:\"\";s:11:\"field_id_51\";N;}',''),
	(87,28,0,14,1,1277478516,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:45:\"<p>\n	This will override the signup text.</p>\n\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:48:\"<p>\n	This will override the thank you text.</p>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:125:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px;\\\">This will override the confirmation page text.</span></p>\n\";s:11:\"field_id_51\";N;}',''),
	(88,28,0,14,1,1277480227,'a:29:{s:9:\"weblog_id\";s:2:\"14\";s:8:\"entry_id\";s:2:\"28\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 01:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:2:\"14\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:5:\"Noble\";s:9:\"url_title\";s:5:\"noble\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_51\";s:4:\"none\";s:11:\"field_ft_52\";s:4:\"none\";s:11:\"field_id_52\";s:45:\"<p>\n	This will override the signup text.</p>\n\";s:11:\"field_ft_53\";s:4:\"none\";s:11:\"field_id_53\";s:48:\"<p>\n	This will override the thank you text.</p>\n\";s:11:\"field_ft_54\";s:4:\"none\";s:11:\"field_id_54\";s:125:\"<p>\n	<span class=\\\"Apple-style-span\\\" style=\\\"line-height: 22px;\\\">This will override the confirmation page text.</span></p>\n\";s:11:\"field_id_51\";s:12:\"en_noble.gif\";}',''),
	(89,38,0,8,12,1277721534,'a:39:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";i:38;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"It\\\'s Up To You New York\";s:9:\"url_title\";s:12:\"its-up-to-yo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:1830:\"<pre id=\\\"line1\\\">\nThe economic benefits associated with the responsible and environmentally sound development of the Marcellus Shale&rsquo;s abundant, clean-burning natural gas reserves are overwhelming. &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;Tens of thousands of good-paying jobs&lt;/<span class=\\\"end-tag\\\">a</span>&gt; are &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;being created&lt;/<span class=\\\"end-tag\\\">a</span>&gt; across the Commonweal of Pennsylvania, where Marcellus development has been underway for several years. &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;Hundreds of millions of dollars in tax revenues&lt;/<span class=\\\"end-tag\\\">a</span>&gt; are being generated to local and state government.</pre>\n<br />\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:62:\"http://www.northcentralpa.com/news/2010-06-27_its-you-new-york\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:52:\"[16] Jobs\r[17] Hydraulic Fracturing\r[18] Regulations\";s:11:\"field_id_28\";s:0:\"\";}',''),
	(90,39,0,7,12,1277721561,'a:24:{s:9:\"weblog_id\";s:1:\"7\";s:8:\"entry_id\";i:39;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:39 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:18:\"NorthCentralPA.com\";s:9:\"url_title\";s:5:\"north\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_24\";s:4:\"none\";s:11:\"field_id_24\";s:29:\"http://www.northcentralpa.com\";s:11:\"field_ft_25\";s:4:\"none\";s:11:\"field_id_25\";s:20:\"northcentralpa_1.png\";}',''),
	(91,38,0,8,12,1277721589,'a:40:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"38\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"It\\\'s Up To You New York\";s:9:\"url_title\";s:12:\"its-up-to-yo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:1812:\"<pre id=\\\"line1\\\">\nThe economic benefits associated with the responsible and environmentally sound development of the Marcellus Shale&rsquo;s abundant, clean-burning natural gas reserves are overwhelming. &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;Tens of thousands of good-paying jobs<!--<span class=\\\"end-tag\\\"-->a&gt; are &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;being created<!--<span class=\\\"end-tag\\\"-->a&gt; across the Commonweal of Pennsylvania, where Marcellus development has been underway for several years. &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;Hundreds of millions of dollars in tax revenues<!--<span class=\\\"end-tag\\\"-->a&gt; are being generated to local and state government.</pre>\n<br />\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:62:\"http://www.northcentralpa.com/news/2010-06-27_its-you-new-york\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:52:\"[16] Jobs\r[17] Hydraulic Fracturing\r[18] Regulations\";s:11:\"field_id_28\";s:23:\"[19] NorthCentralPA.com\";}',''),
	(92,27,0,5,12,1277721645,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:2:\"13\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:665:\"<p>\n	&lt;object width=&quot;480&quot; height=&quot;385&quot;&gt;&lt;param name=&quot;movie&quot; value=&quot;http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0&quot;&gt;&lt;/param&gt;&lt;param name=&quot;allowFullScreen&quot; value=&quot;true&quot;&gt;&lt;/param&gt;&lt;param name=&quot;allowscriptaccess&quot; value=&quot;always&quot;&gt;&lt;/param&gt;&lt;embed src=&quot;http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0&quot; type=&quot;application/x-shockwave-flash&quot; allowscriptaccess=&quot;always&quot; allowfullscreen=&quot;true&quot; width=&quot;480&quot; height=&quot;385&quot;&gt;&lt;/embed&gt;&lt;/object&gt;</p>\n\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:62:\"[13] This is a video, photo and text\r[14] This is just a video\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(93,27,0,5,12,1277721736,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:2:\"13\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:475:\"<p>\n	<object height=\\\"385\\\" width=\\\"480\\\"><param name=\\\"movie\\\" value=\\\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\\\" /><param name=\\\"allowFullScreen\\\" value=\\\"true\\\" /><param name=\\\"allowscriptaccess\\\" value=\\\"always\\\" /><embed allowfullscreen=\\\"true\\\" allowscriptaccess=\\\"always\\\" height=\\\"385\\\" src=\\\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\\\" type=\\\"application/x-shockwave-flash\\\" width=\\\"480\\\"></embed></object></p>\n\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:27:\"[20] Its Up To You New York\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(94,38,0,8,12,1277722279,'a:40:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"38\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"It\\\'s Up To You New York\";s:9:\"url_title\";s:12:\"its-up-to-yo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:1787:\"The economic benefits associated with the responsible and environmentally sound development of the Marcellus Shale&rsquo;s abundant, clean-burning natural gas reserves are overwhelming. &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;Tens of thousands of good-paying jobs<!--<span class=\\\"end-tag\\\"-->a&gt; are &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;being created<!--<span class=\\\"end-tag\\\"-->a&gt; across the Commonweal of Pennsylvania, where Marcellus development has been underway for several years. &lt;<span class=\\\"start-tag\\\">a</span><span class=\\\"attribute-name\\\"> href</span><span>=&quot;</span><a href=\\\"view-source:http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445\\\">http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445</a><span>&quot; </span><span class=\\\"attribute-name\\\">target</span>=<span class=\\\"attribute-value\\\">&quot;_blank&quot;</span>&gt;Hundreds of millions of dollars in tax revenues<!--<span class=\\\"end-tag\\\"-->a&gt; are being generated to local and state government.\n<br />\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:62:\"http://www.northcentralpa.com/news/2010-06-27_its-you-new-york\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:52:\"[16] Jobs\r[17] Hydraulic Fracturing\r[18] Regulations\";s:11:\"field_id_28\";s:23:\"[19] NorthCentralPA.com\";}',''),
	(95,38,0,8,12,1277722355,'a:40:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"38\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"It\\\'s Up To You New York\";s:9:\"url_title\";s:12:\"its-up-to-yo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:790:\"<p>\n	The economic benefits associated with the responsible and environmentally sound development of the Marcellus Shale&rsquo;s abundant, clean-burning natural gas reserves are overwhelming. <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46\\\" target=\\\"_blank\\\">Tens of thousands of good-paying jobs</a> are <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785\\\" target=\\\"_blank\\\">being created</a> across the Commonweal of Pennsylvania, where Marcellus development has been underway for several years. <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445\\\" target=\\\"_blank\\\">Hundreds of millions of dollars in tax revenues</a> are being generated to local and state government.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:62:\"http://www.northcentralpa.com/news/2010-06-27_its-you-new-york\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:52:\"[16] Jobs\r[17] Hydraulic Fracturing\r[18] Regulations\";s:11:\"field_id_28\";s:23:\"[19] NorthCentralPA.com\";}',''),
	(96,40,0,7,12,1277723059,'a:24:{s:9:\"weblog_id\";s:1:\"7\";s:8:\"entry_id\";i:40;s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 12:00 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:19:\"Wall Street Journal\";s:9:\"url_title\";s:19:\"wall-street-journal\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_24\";s:4:\"none\";s:11:\"field_id_24\";s:21:\"http://online.wsj.com\";s:11:\"field_ft_25\";s:4:\"none\";s:11:\"field_id_25\";s:21:\"WallStreetJournal.gif\";}',''),
	(97,41,0,8,12,1277723202,'a:39:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";i:41;s:6:\"sticky\";s:0:\"\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 12:04 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:0:\"\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:30:\"Shale Gas Will Rock the World \";s:9:\"url_title\";s:29:\"shale-gas-will-rock-the-world\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:371:\"<p>\n	There&#39;s an energy revolution brewing right under our feet.</p>\n<p>\n	Over the past decade, a wave of drilling around the world has uncovered giant supplies of natural gas in shale rock. By some estimates, there&#39;s 1,000 trillion cubic feet recoverable in North America alone&mdash;enough to supply the nation&#39;s natural-gas needs for the next 45 years.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:78:\"http://online.wsj.com/article/SB10001424052702303491304575187880596301668.html\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:92:\"[21] Hydraulic Fracturing\r[22] Jobs\r[23] Climate Change\r[24] Climate change\r[25] Regulations\";s:11:\"field_id_28\";s:24:\"[26] Wall Street Journal\";}',''),
	(98,27,0,5,12,1277723260,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:2:\"13\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:475:\"<p>\n	<object height=\\\"385\\\" width=\\\"480\\\"><param name=\\\"movie\\\" value=\\\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\\\" /><param name=\\\"allowFullScreen\\\" value=\\\"true\\\" /><param name=\\\"allowscriptaccess\\\" value=\\\"always\\\" /><embed allowfullscreen=\\\"true\\\" allowscriptaccess=\\\"always\\\" height=\\\"385\\\" src=\\\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\\\" type=\\\"application/x-shockwave-flash\\\" width=\\\"480\\\"></embed></object></p>\n\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:62:\"[27] Shale Gas Will Rock the World\r[20] Its Up To You New York\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(99,38,0,8,12,1277723836,'a:40:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"38\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:25:\"It\\\'s Up To You, New York\";s:9:\"url_title\";s:12:\"its-up-to-yo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:790:\"<p>\n	The economic benefits associated with the responsible and environmentally sound development of the Marcellus Shale&rsquo;s abundant, clean-burning natural gas reserves are overwhelming. <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46\\\" target=\\\"_blank\\\">Tens of thousands of good-paying jobs</a> are <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785\\\" target=\\\"_blank\\\">being created</a> across the Commonweal of Pennsylvania, where Marcellus development has been underway for several years. <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445\\\" target=\\\"_blank\\\">Hundreds of millions of dollars in tax revenues</a> are being generated to local and state government.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:62:\"http://www.northcentralpa.com/news/2010-06-27_its-you-new-york\";s:11:\"field_ft_28\";s:4:\"none\";s:11:\"field_ft_29\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_29\";s:52:\"[16] Jobs\r[17] Hydraulic Fracturing\r[18] Regulations\";s:11:\"field_id_28\";s:23:\"[19] NorthCentralPA.com\";}',''),
	(101,27,0,5,1,1277788921,'a:46:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"27\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-22 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:20:\"hydraulic-fracturing\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:6:\"access\";s:11:\"field_id_10\";s:72:\"Todayâ€™s technology is unlocking vast resources of oil and natural gas.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:2:\"13\";s:11:\"field_ft_58\";s:4:\"none\";s:11:\"field_id_58\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:25:\"This is the video heading\";s:11:\"field_id_18\";s:63:\"[27] Shale Gas Will Rock the World\r[20] Its Up To You, New York\";s:11:\"field_id_57\";s:1199:\"Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?\n<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n\n55,000 Pennsylvanians have jobs related to energy production\";}',''),
	(102,32,0,5,1,1277789529,'a:44:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"32\";s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:27 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:14:\"Climate Change\";s:9:\"url_title\";s:14:\"climate-change\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:11:\"environment\";s:11:\"field_id_10\";s:58:\"Seeking a balanced approach to climate change legislation.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:1292:\"What does climate change legislation mean for you and your family?\n<p>\n	As an industry, we&rsquo;re committed to reducing greenhouse gas emissions and lower our environmental footprint. We&rsquo;re constantly enhancing efficiency and investing in new technologies that are changing the environmental effects of our work as we bring energy to consumers.</p>\n<p>\n	Congress continues to propose and debate well-intentioned measures that require companies to reduce their impact on the environment. We support this goal and are committed to finding solutions that promote environmental responsibility. However, many of the proposed measures would have unintended negative consequences, potentially putting millions of jobs at risk and raising costs for companies in our industry and others. Our elected officials must understand the need to balance the positive intent of legislation against the negative implications for consumers, jobs and the economy.</p>\n<p>\n	We are committed to protecting the environment. In fact, we&rsquo;re already working to reduce our carbon footprint. But we must be careful of proposals that could take away jobs from the hardworking people in our industry, make our industry less competitive or raise costs for the people that rely on us for affordable energy.</p>\n\";}',''),
	(103,11,0,4,1,1277790107,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";s:11:\"field_id_59\";s:1:\"1\";}',''),
	(104,11,0,4,1,1277790123,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";s:11:\"field_id_59\";s:1:\"1\";}',''),
	(105,11,0,4,1,1277790144,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";s:11:\"field_id_59\";s:1:\"1\";}',''),
	(106,11,0,4,1,1277790158,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:2:\"13\";s:11:\"field_id_59\";s:1:\"1\";}',''),
	(107,11,0,4,1,1277790241,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";s:11:\"field_id_59\";s:0:\"\";}',''),
	(108,11,0,4,1,1277790269,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:6:\"closed\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";s:11:\"field_id_59\";s:0:\"\";}',''),
	(109,11,0,4,1,1277790402,'a:27:{s:9:\"weblog_id\";s:1:\"4\";s:8:\"entry_id\";s:2:\"11\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:07 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"4\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:6:\"closed\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:99:\"This is an intro.  The title should just be descriptive, it won\\\'t actually be used on the frontend\";s:9:\"url_title\";s:70:\"this-is-an-intro.-the-title-should-just-be-descriptive-it-wont-actuall\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_ft_6\";s:4:\"none\";s:10:\"field_id_6\";s:646:\"<p>\n	Energy Nation brings together current and former American energy workers together to fight for the survival of the industry.</p>\n<p>\n	Lorem ipsum dolor sit amet, consectetaur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Et harumd und, dereud facilis est er expedit distinct.</p>\n\";s:11:\"field_ft_59\";s:4:\"none\";s:10:\"field_ft_9\";s:4:\"none\";s:10:\"field_id_9\";s:0:\"\";s:11:\"field_id_59\";s:0:\"\";}',''),
	(110,4,0,3,12,1277822038,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"4\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:4:\"Jobs\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:64:\"Energy Nation:  9.2 million jobs across a wide range of sectors.\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"Learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:13:\"/economy/jobs\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:12:\"a_Jobs_2.JPG\";}',''),
	(111,8,0,3,12,1277822160,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"8\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:13 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:22:\"this-is-another-banner\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:67:\"A revolutionary new way to tap Americaâ€™s Natural Gas resources.  \";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:29:\"/access/hydraulic-fracturing/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:12:\"a_NatGas.JPG\";}',''),
	(112,4,0,3,12,1277822187,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"4\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:4:\"Jobs\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:64:\"Energy Nation:  9.2 million jobs across a wide range of sectors.\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:13:\"/economy/jobs\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:12:\"a_Jobs_2.JPG\";}',''),
	(113,10,0,3,12,1277822247,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:2:\"10\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Deepwater Moratorium\";s:9:\"url_title\";s:30:\"a-final-banner-label-goes-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:67:\"How many lost jobs could result from the ban on deepwater drilling?\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:29:\"/access/deepwater-moratorium/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:18:\"a_Morat_Jobs_1.JPG\";}',''),
	(114,9,0,3,12,1277822314,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"9\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"Offshore Drilling\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:68:\"How does offshore drilling provide America with the energy it needs?\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:40:\"/access/ocs-the-outer-continental-shelf/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:24:\"a_OffshoreDrilling_4.JPG\";}',''),
	(115,32,0,5,1,1277905364,'a:44:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"32\";s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:27 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:14:\"Climate Change\";s:9:\"url_title\";s:14:\"climate-change\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:11:\"environment\";s:11:\"field_id_10\";s:58:\"Seeking a balanced approach to climate change legislation.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:13:\"Video heading\";s:11:\"field_id_18\";s:29:\"[28] This is a video and text\";s:11:\"field_id_57\";s:1292:\"What does climate change legislation mean for you and your family?\n<p>\n	As an industry, we&rsquo;re committed to reducing greenhouse gas emissions and lower our environmental footprint. We&rsquo;re constantly enhancing efficiency and investing in new technologies that are changing the environmental effects of our work as we bring energy to consumers.</p>\n<p>\n	Congress continues to propose and debate well-intentioned measures that require companies to reduce their impact on the environment. We support this goal and are committed to finding solutions that promote environmental responsibility. However, many of the proposed measures would have unintended negative consequences, potentially putting millions of jobs at risk and raising costs for companies in our industry and others. Our elected officials must understand the need to balance the positive intent of legislation against the negative implications for consumers, jobs and the economy.</p>\n<p>\n	We are committed to protecting the environment. In fact, we&rsquo;re already working to reduce our carbon footprint. But we must be careful of proposals that could take away jobs from the hardworking people in our industry, make our industry less competitive or raise costs for the people that rely on us for affordable energy.</p>\n\";}',''),
	(116,32,0,5,1,1277905536,'a:44:{s:9:\"weblog_id\";s:1:\"5\";s:8:\"entry_id\";s:2:\"32\";s:9:\"author_id\";s:2:\"12\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-23 09:27 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"5\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:14:\"Climate Change\";s:9:\"url_title\";s:14:\"climate-change\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_37\";s:4:\"none\";s:11:\"field_id_37\";s:11:\"environment\";s:11:\"field_id_10\";s:58:\"Seeking a balanced approach to climate change legislation.\";s:11:\"field_ft_10\";s:4:\"none\";s:11:\"field_ft_55\";s:4:\"none\";s:11:\"field_ft_56\";s:4:\"none\";s:11:\"field_id_56\";s:0:\"\";s:11:\"field_ft_57\";s:4:\"none\";s:11:\"field_ft_18\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_55\";s:0:\"\";s:11:\"field_id_18\";s:0:\"\";s:11:\"field_id_57\";s:1292:\"What does climate change legislation mean for you and your family?\n<p>\n	As an industry, we&rsquo;re committed to reducing greenhouse gas emissions and lower our environmental footprint. We&rsquo;re constantly enhancing efficiency and investing in new technologies that are changing the environmental effects of our work as we bring energy to consumers.</p>\n<p>\n	Congress continues to propose and debate well-intentioned measures that require companies to reduce their impact on the environment. We support this goal and are committed to finding solutions that promote environmental responsibility. However, many of the proposed measures would have unintended negative consequences, potentially putting millions of jobs at risk and raising costs for companies in our industry and others. Our elected officials must understand the need to balance the positive intent of legislation against the negative implications for consumers, jobs and the economy.</p>\n<p>\n	We are committed to protecting the environment. In fact, we&rsquo;re already working to reduce our carbon footprint. But we must be careful of proposals that could take away jobs from the hardworking people in our industry, make our industry less competitive or raise costs for the people that rely on us for affordable energy.</p>\n\";}',''),
	(117,9,0,3,12,1277931302,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"9\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"Offshore Drilling\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:68:\"How does offshore drilling provide America with the energy it needs?\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:40:\"/access/ocs-the-outer-continental-shelf/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_2.jpg\";}',''),
	(118,9,0,3,12,1277931341,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"9\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"Offshore Drilling\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:1:\" \";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:40:\"/access/ocs-the-outer-continental-shelf/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_2.jpg\";}',''),
	(119,9,0,3,12,1277931390,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"9\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"Offshore Drilling\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:12:\" \\\\n \\\\n \\\\n\";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:40:\"/access/ocs-the-outer-continental-shelf/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_2.jpg\";}',''),
	(120,9,0,3,12,1277931425,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"9\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"Offshore Drilling\";s:9:\"url_title\";s:26:\"one-more-banner-label-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:1:\" \";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:40:\"/access/ocs-the-outer-continental-shelf/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_2.jpg\";}',''),
	(121,10,0,3,12,1277931653,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:2:\"10\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:14 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Deepwater Moratorium\";s:9:\"url_title\";s:30:\"a-final-banner-label-goes-here\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:1:\" \";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:29:\"/access/deepwater-moratorium/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_1.jpg\";}',''),
	(122,8,0,3,12,1277931683,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"8\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 08:12 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"Hydraulic Fracturing\";s:9:\"url_title\";s:22:\"this-is-another-banner\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:1:\" \";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:29:\"/access/hydraulic-fracturing/\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_3.jpg\";}',''),
	(123,4,0,3,12,1277931712,'a:29:{s:9:\"weblog_id\";s:1:\"3\";s:8:\"entry_id\";s:1:\"4\";s:9:\"author_id\";s:1:\"1\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"n\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-16 05:24 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:10:\"new_weblog\";s:1:\"3\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:4:\"Jobs\";s:9:\"url_title\";s:22:\"say-no-to-energy-taxes\";s:6:\"submit\";s:13:\"Save Revision\";s:10:\"field_id_5\";s:1:\" \";s:10:\"field_ft_5\";s:4:\"none\";s:11:\"field_id_48\";s:10:\"learn more\";s:11:\"field_ft_48\";s:4:\"none\";s:11:\"field_ft_49\";s:4:\"none\";s:11:\"field_id_49\";s:13:\"/economy/jobs\";s:11:\"field_ft_50\";s:4:\"none\";s:11:\"field_id_50\";s:15:\"billboard_4.jpg\";}',''),
	(124,41,0,8,1,1277970526,'a:42:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"41\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 12:04 PM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:29:\"Shale Gas Will Rock the World\";s:9:\"url_title\";s:29:\"shale-gas-will-rock-the-world\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_61\";s:4:\"none\";s:11:\"field_id_61\";s:2:\"14\";s:11:\"field_ft_29\";s:4:\"none\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:371:\"<p>\n	There&#39;s an energy revolution brewing right under our feet.</p>\n<p>\n	Over the past decade, a wave of drilling around the world has uncovered giant supplies of natural gas in shale rock. By some estimates, there&#39;s 1,000 trillion cubic feet recoverable in North America alone&mdash;enough to supply the nation&#39;s natural-gas needs for the next 45 years.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:78:\"http://online.wsj.com/article/SB10001424052702303491304575187880596301668.html\";s:11:\"field_ft_28\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_28\";s:24:\"[26] Wall Street Journal\";s:11:\"field_id_29\";s:72:\"[21] Hydraulic Fracturing\r[22] Jobs\r[23] Climate Change\r[25] Regulations\";}',''),
	(125,38,0,8,1,1277970536,'a:42:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"38\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-28 11:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:2:\"12\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:25:\"It\\\'s Up To You, New York\";s:9:\"url_title\";s:12:\"its-up-to-yo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_61\";s:4:\"none\";s:11:\"field_id_61\";s:2:\"14\";s:11:\"field_ft_29\";s:4:\"none\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:790:\"<p>\n	The economic benefits associated with the responsible and environmentally sound development of the Marcellus Shale&rsquo;s abundant, clean-burning natural gas reserves are overwhelming. <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/77af799a46\\\" target=\\\"_blank\\\">Tens of thousands of good-paying jobs</a> are <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/6f6f5ef785\\\" target=\\\"_blank\\\">being created</a> across the Commonweal of Pennsylvania, where Marcellus development has been underway for several years. <a href=\\\"http://cts.vresp.com/c/?MarcellusShaleCoalit/9d71ee0ce4/d7b92bf54b/73e52a5445\\\" target=\\\"_blank\\\">Hundreds of millions of dollars in tax revenues</a> are being generated to local and state government.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:62:\"http://www.northcentralpa.com/news/2010-06-27_its-you-new-york\";s:11:\"field_ft_28\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_28\";s:23:\"[19] NorthCentralPA.com\";s:11:\"field_id_29\";s:52:\"[16] Jobs\r[17] Hydraulic Fracturing\r[18] Regulations\";}',''),
	(126,13,0,8,1,1277970546,'a:42:{s:9:\"weblog_id\";s:1:\"8\";s:8:\"entry_id\";s:2:\"13\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 06:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:1:\"8\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:17:\"The New Socialism\";s:9:\"url_title\";s:17:\"the-new-socialism\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_61\";s:4:\"none\";s:11:\"field_id_61\";s:2:\"14\";s:11:\"field_ft_29\";s:4:\"none\";s:11:\"field_ft_26\";s:4:\"none\";s:11:\"field_id_26\";s:406:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_ft_27\";s:4:\"none\";s:11:\"field_id_27\";s:21:\"http://www.google.com\";s:11:\"field_ft_28\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_28\";s:23:\"[2] The Washington Post\";s:11:\"field_id_29\";s:0:\"\";}',''),
	(127,20,0,10,1,1277970564,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"20\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:37 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:27:\"This is a photo and a video\";s:9:\"url_title\";s:27:\"this-is-a-photo-and-a-video\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:13:\"photos\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:15:\"<p>\n	Array</p>\n\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_36\";s:0:\"\";}',''),
	(128,18,0,10,1,1277970574,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"18\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:36 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"This is a video and text\";s:9:\"url_title\";s:24:\"this-is-a-video-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"stories\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:0:\"\";}',''),
	(129,19,0,10,1,1277970582,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"19\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:36 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:31:\"This is a video, photo and text\";s:9:\"url_title\";s:30:\"this-is-a-video-photo-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:21:\"photos\nstories\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_36\";s:0:\"\";}',''),
	(130,18,0,10,1,1277970589,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"18\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:36 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"This is a video and text\";s:9:\"url_title\";s:24:\"this-is-a-video-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"stories\nvideos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:0:\"\";}',''),
	(131,17,0,10,1,1277970596,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"17\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:34 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"This is just a video\";s:9:\"url_title\";s:20:\"this-is-just-a-video\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:6:\"videos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:4:\"1234\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:0:\"\";}',''),
	(132,16,0,10,1,1277970606,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"16\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:31 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:24:\"This is a photo and text\";s:9:\"url_title\";s:24:\"this-is-a-photo-and-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:14:\"photos\nstories\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_36\";s:0:\"\";}',''),
	(133,15,0,10,1,1277970618,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"15\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:29 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:27:\"This is just a story (text)\";s:9:\"url_title\";s:25:\"this-is-just-a-story-text\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:7:\"stories\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:812:\"<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n<p>\n	With the Senate blocking President Obama&rsquo;s cap-and-trade carbon legislation, the EPA coup d&rsquo;&eacute;tat served as the administration&rsquo;s loud response to Webb: The hell we can&rsquo;t. With this EPA &lsquo;endangerment&rsquo; finding, we can do as we wish with carbon. Either the Senate passes cap-and-trade, or the EPA will impose even more draconian measures: all cap, no trade.</p>\n\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_42\";N;s:11:\"field_id_36\";s:0:\"\";}',''),
	(134,14,0,10,1,1277970627,'a:46:{s:9:\"weblog_id\";s:2:\"10\";s:8:\"entry_id\";s:2:\"14\";s:6:\"sticky\";s:1:\"n\";s:14:\"allow_comments\";s:1:\"y\";s:16:\"allow_trackbacks\";s:1:\"n\";s:11:\"dst_enabled\";s:1:\"n\";s:10:\"entry_date\";s:19:\"2010-06-17 07:11 AM\";s:15:\"expiration_date\";s:0:\"\";s:23:\"comment_expiration_date\";s:0:\"\";s:9:\"author_id\";s:1:\"1\";s:10:\"new_weblog\";s:2:\"10\";s:6:\"status\";s:4:\"open\";s:14:\"trackback_urls\";s:0:\"\";s:18:\"Lg_better_meta_ext\";a:10:{s:5:\"title\";s:0:\"\";s:11:\"description\";s:0:\"\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:0:\"\";s:5:\"index\";s:0:\"\";s:6:\"follow\";s:0:\"\";s:7:\"archive\";s:0:\"\";s:18:\"include_in_sitemap\";s:0:\"\";s:16:\"change_frequency\";s:0:\"\";s:8:\"priority\";s:0:\"\";}s:10:\"old_status\";s:4:\"open\";s:9:\"old_state\";s:0:\"\";s:12:\"nsm_pp_state\";s:0:\"\";s:10:\"draft_note\";s:0:\"\";s:11:\"nsm_pp_note\";s:0:\"\";s:5:\"title\";s:20:\"This is just a photo\";s:9:\"url_title\";s:20:\"this-is-just-a-photo\";s:6:\"submit\";s:13:\"Save Revision\";s:11:\"field_ft_60\";s:4:\"none\";s:11:\"field_id_60\";s:2:\"14\";s:11:\"field_ft_36\";s:4:\"none\";s:11:\"field_ft_43\";s:4:\"none\";s:11:\"field_id_43\";s:6:\"photos\";s:11:\"field_ft_33\";s:4:\"none\";s:11:\"field_id_33\";s:0:\"\";s:11:\"field_id_34\";s:0:\"\";s:11:\"field_ft_34\";s:4:\"none\";s:11:\"field_id_35\";s:0:\"\";s:11:\"field_ft_35\";s:5:\"xhtml\";s:11:\"field_ft_42\";s:4:\"none\";s:11:\"field_id_42\";s:16:\"sarah_millie.jpg\";s:24:\"Lg_better_meta_ext_title\";s:0:\"\";s:30:\"Lg_better_meta_ext_description\";s:0:\"\";s:27:\"Lg_better_meta_ext_keywords\";s:0:\"\";s:25:\"Lg_better_meta_ext_author\";s:0:\"\";s:24:\"Lg_better_meta_ext_index\";s:0:\"\";s:25:\"Lg_better_meta_ext_follow\";s:0:\"\";s:26:\"Lg_better_meta_ext_archive\";s:0:\"\";s:37:\"Lg_better_meta_ext_include_in_sitemap\";s:0:\"\";s:35:\"Lg_better_meta_ext_change_frequency\";s:0:\"\";s:27:\"Lg_better_meta_ext_priority\";s:0:\"\";s:11:\"field_id_36\";s:0:\"\";}','');

/*!40000 ALTER TABLE `exp_nsm_entry_drafts` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_nsm_notes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_nsm_notes`;

CREATE TABLE `exp_nsm_notes` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `lang` varchar(5) NOT NULL,
  `class_name` varchar(50) NOT NULL,
  `entry_id` int(10) NOT NULL,
  `site_id` int(4) NOT NULL,
  `weblog_id` int(4) NOT NULL,
  `author_id` int(4) NOT NULL,
  `created_at` int(10) NOT NULL,
  `note` text NOT NULL,
  PRIMARY KEY (`id`,`entry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_nsm_pp_notification_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_nsm_pp_notification_templates`;

CREATE TABLE `exp_nsm_pp_notification_templates` (
  `template_id` int(11) NOT NULL AUTO_INCREMENT,
  `site_id` int(2) NOT NULL,
  `weblogs` varchar(100) NOT NULL,
  `enabled` varchar(1) NOT NULL,
  `action` varchar(50) NOT NULL,
  `old_status` varchar(50) NOT NULL,
  `new_status` varchar(50) NOT NULL,
  `old_state` varchar(50) NOT NULL,
  `new_state` varchar(50) NOT NULL,
  `subject` varchar(120) NOT NULL,
  `message` mediumtext NOT NULL,
  `recipients` text NOT NULL,
  PRIMARY KEY (`template_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_nsm_pp_notification_templates` WRITE;
/*!40000 ALTER TABLE `exp_nsm_pp_notification_templates` DISABLE KEYS */;
INSERT INTO `exp_nsm_pp_notification_templates` (`template_id`,`site_id`,`weblogs`,`enabled`,`action`,`old_status`,`new_status`,`old_state`,`new_state`,`subject`,`message`,`recipients`)
VALUES
	(1,1,'','n','create_entry','','','','','','','a:6:{s:12:\"entry_author\";b:0;s:12:\"draft_author\";b:0;s:17:\"nsm_pp_publishers\";a:0:{}s:14:\"nsm_pp_editors\";a:0:{}s:13:\"member_groups\";a:0:{}s:10:\"additional\";s:0:\"\";}');

/*!40000 ALTER TABLE `exp_nsm_pp_notification_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_online_users
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_online_users`;

CREATE TABLE `exp_online_users` (
  `weblog_id` int(6) unsigned NOT NULL DEFAULT '0',
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `in_forum` char(1) NOT NULL DEFAULT 'n',
  `name` varchar(50) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `date` int(10) unsigned NOT NULL DEFAULT '0',
  `anon` char(1) NOT NULL,
  KEY `date` (`date`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_online_users` WRITE;
/*!40000 ALTER TABLE `exp_online_users` DISABLE KEYS */;
INSERT INTO `exp_online_users` (`weblog_id`,`site_id`,`member_id`,`in_forum`,`name`,`ip_address`,`date`,`anon`)
VALUES
	(0,1,0,'n','','127.0.0.1',1251810289,''),
	(0,1,0,'n','','127.0.0.1',1251810289,''),
	(0,1,0,'n','','127.0.0.1',1251810289,''),
	(0,1,0,'n','','127.0.0.1',1265120889,'');

/*!40000 ALTER TABLE `exp_online_users` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_password_lockout
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_password_lockout`;

CREATE TABLE `exp_password_lockout` (
  `login_date` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  KEY `login_date` (`login_date`),
  KEY `ip_address` (`ip_address`),
  KEY `user_agent` (`user_agent`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_ping_servers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_ping_servers`;

CREATE TABLE `exp_ping_servers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `server_name` varchar(32) NOT NULL,
  `server_url` varchar(150) NOT NULL,
  `port` varchar(4) NOT NULL DEFAULT '80',
  `ping_protocol` varchar(12) NOT NULL DEFAULT 'xmlrpc',
  `is_default` char(1) NOT NULL DEFAULT 'y',
  `server_order` int(3) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_pur_member_utilities_settings
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_pur_member_utilities_settings`;

CREATE TABLE `exp_pur_member_utilities_settings` (
  `id` int(6) unsigned NOT NULL,
  `settings` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

LOCK TABLES `exp_pur_member_utilities_settings` WRITE;
/*!40000 ALTER TABLE `exp_pur_member_utilities_settings` DISABLE KEYS */;
INSERT INTO `exp_pur_member_utilities_settings` (`id`,`settings`)
VALUES
	(1,'{}');

/*!40000 ALTER TABLE `exp_pur_member_utilities_settings` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_reeorder_prefs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_reeorder_prefs`;

CREATE TABLE `exp_reeorder_prefs` (
  `weblog_id` int(4) unsigned NOT NULL,
  `field_id` int(4) unsigned NOT NULL,
  `status` text,
  `sort_order` varchar(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_referrers
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_referrers`;

CREATE TABLE `exp_referrers` (
  `ref_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `ref_from` varchar(120) NOT NULL,
  `ref_to` varchar(120) NOT NULL,
  `ref_ip` varchar(16) NOT NULL DEFAULT '0',
  `ref_date` int(10) unsigned NOT NULL DEFAULT '0',
  `ref_agent` varchar(100) NOT NULL,
  `user_blog` varchar(40) NOT NULL,
  PRIMARY KEY (`ref_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_referrers` WRITE;
/*!40000 ALTER TABLE `exp_referrers` DISABLE KEYS */;
INSERT INTO `exp_referrers` (`ref_id`,`site_id`,`ref_from`,`ref_to`,`ref_ip`,`ref_date`,`ref_agent`,`user_blog`)
VALUES
	(1,1,'http://eesandbox.dev/manage/index.php?S=dadbb325b70282b13bb324008f2c7a2ea8a33b11','http://eesandbox.dev/dev/','127.0.0.1',1248031252,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(2,1,'http://eesandbox.dev/manage/index.php?S=dadbb325b70282b13bb324008f2c7a2ea8a33b11','http://eesandbox.dev/dev/','127.0.0.1',1248031252,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(3,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d','http://eesandbox.dev/dev/','127.0.0.1',1248031262,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(4,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d','http://eesandbox.dev/dev/','127.0.0.1',1248031262,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(5,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=templates','http://eesandbox.dev/dev/','127.0.0.1',1248031264,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(6,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=templates','http://eesandbox.dev/dev/','127.0.0.1',1248031264,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(7,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=templates','http://eesandbox.dev/dev/','127.0.0.1',1248031264,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(8,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=templates','http://eesandbox.dev/dev/','127.0.0.1',1248031264,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(9,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=templates','http://eesandbox.dev/dev/','127.0.0.1',1248031264,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(10,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=templates','http://eesandbox.dev/dev/','127.0.0.1',1248031264,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(11,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=template_cfg&cla','http://eesandbox.dev/dev/','127.0.0.1',1248031267,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(12,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=template_cfg&cla','http://eesandbox.dev/dev/','127.0.0.1',1248031267,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(13,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031320,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(14,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031320,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(15,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031323,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(16,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031324,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(17,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031333,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(18,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031333,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(19,1,'http://eesandbox.dev/manage/index.php?S=8c1ffc4de8034f7fef24d2ebaa9c9bf47d5b241d&C=admin&M=config_mgr&P=general_cfg','http://eesandbox.dev/dev/','127.0.0.1',1248031333,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers',''),
	(20,1,'http://ee-baseline.dev/','http://ee-baseline.dev/dev/','127.0.0.1',1251809498,'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_5_7; en-us) AppleWebKit/530.18 (KHTML, like Gecko) Vers','');

/*!40000 ALTER TABLE `exp_referrers` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_relationships
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_relationships`;

CREATE TABLE `exp_relationships` (
  `rel_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `rel_parent_id` int(10) NOT NULL DEFAULT '0',
  `rel_child_id` int(10) NOT NULL DEFAULT '0',
  `rel_type` varchar(12) NOT NULL,
  `rel_data` mediumtext NOT NULL,
  `reverse_rel_data` mediumtext NOT NULL,
  PRIMARY KEY (`rel_id`),
  KEY `rel_parent_id` (`rel_parent_id`),
  KEY `rel_child_id` (`rel_child_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;



# Dump of table exp_reset_password
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_reset_password`;

CREATE TABLE `exp_reset_password` (
  `member_id` int(10) unsigned NOT NULL,
  `resetcode` varchar(12) NOT NULL,
  `date` int(10) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_revision_tracker
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_revision_tracker`;

CREATE TABLE `exp_revision_tracker` (
  `tracker_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `item_id` int(10) unsigned NOT NULL,
  `item_table` varchar(20) NOT NULL,
  `item_field` varchar(20) NOT NULL,
  `item_date` int(10) NOT NULL,
  `item_author_id` int(10) unsigned NOT NULL,
  `item_data` mediumtext NOT NULL,
  PRIMARY KEY (`tracker_id`),
  KEY `item_id` (`item_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_search`;

CREATE TABLE `exp_search` (
  `search_id` varchar(32) NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `search_date` int(10) NOT NULL,
  `keywords` varchar(60) NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `total_results` int(6) NOT NULL,
  `per_page` smallint(3) unsigned NOT NULL,
  `query` mediumtext,
  `custom_fields` mediumtext,
  `result_page` varchar(70) NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_search_log
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_search_log`;

CREATE TABLE `exp_search_log` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) unsigned NOT NULL,
  `screen_name` varchar(50) NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `search_date` int(10) NOT NULL,
  `search_type` varchar(32) NOT NULL,
  `search_terms` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_security_hashes
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_security_hashes`;

CREATE TABLE `exp_security_hashes` (
  `date` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `hash` varchar(40) NOT NULL,
  KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_security_hashes` WRITE;
/*!40000 ALTER TABLE `exp_security_hashes` DISABLE KEYS */;
INSERT INTO `exp_security_hashes` (`date`,`ip_address`,`hash`)
VALUES
	(1296682908,'88.97.41.226','68785dc5c8d7ccd03add57aebd0e82ba9299bb51'),
	(1296682915,'88.97.41.226','a66b4eb8a3a0aa002e2abebc988a9d508f591ec7'),
	(1296682915,'88.97.41.226','dd5a8b0bffba1509413a45631dc5b6a542a5ec80'),
	(1296682915,'88.97.41.226','dbec407143fb52072ccd794100ed48e72c03954d'),
	(1296682917,'88.97.41.226','1f984ec8d24796e3206a8c06f75f846034ebd4bd'),
	(1296683031,'88.97.41.226','409da7be6dc73e4d6fa85175731f72b6790d8c3a'),
	(1296674198,'75.89.69.119','7f4f15161c0dc3f71065ad30192fad4f1d7e3a3d'),
	(1296674192,'75.89.69.119','098ee2d0a2d030dba15a418ad529aaaeacb1cd90'),
	(1296674183,'75.89.69.119','5f5485e060976ea4387e59550a0c352d0a40fad7'),
	(1296674177,'75.89.69.119','7f7efab2b5621ebf5a2572f001e72717b0208dbc'),
	(1296674177,'75.89.69.119','1238e7f7a180c7fe0182beec87013f449b4f1e7f'),
	(1296674177,'75.89.69.119','49ab4ca53f06aa27eeb43c34e81c5f0c9ed29b60'),
	(1296674175,'75.89.69.119','5c36262fda9b1220edfcc80abc472a7d6b93e850'),
	(1296674175,'75.89.69.119','82e1184154586231cbd39d76e24bb0793f0710b0'),
	(1296674175,'75.89.69.119','95309e9e8f4d6dd2b6419d060e1c16ca214d9b1a'),
	(1296674161,'75.89.69.119','396af66a5c6d9d98ff843d5c2051f2ef484fb5c0'),
	(1296674169,'75.89.69.119','af037b1bd92e6f1adb180eda9fddc305282b199f'),
	(1296674173,'75.89.69.119','0a889bd05f473a8f481d5aee799078efbfdf6cca'),
	(1296674154,'75.89.69.119','54481622a47676c4e780b037c435a30066c28891'),
	(1296674151,'75.89.69.119','6cf3501449247884f72aea0318a9aa8241b69e86'),
	(1296674151,'75.89.69.119','f4de10c0a247db94933aa93e7de7d4dfc11aeded'),
	(1296674151,'75.89.69.119','dcd651130844e6409daeb4e2e538c96aeae1d815'),
	(1296674149,'75.89.69.119','22a75f65a939973bb935a4adcd5279f77ec5dc95'),
	(1296674144,'75.89.69.119','64b630db95dad7ce3f3c6e25bd46aca01921e7a3'),
	(1296674139,'75.89.69.119','a82be19eb6c3e9bd32d272eb9b12162d4ba5b248'),
	(1296674134,'75.89.69.119','af408daced43abdf0c0ae1016c89f8960fa5a483'),
	(1296674130,'75.89.69.119','ee167d4d2d5c4e926dd5bddbbc254ba815b96e32'),
	(1296670366,'88.97.41.226','83d4055e15df274e7fcaa4e3e581396170f5af36'),
	(1296670191,'88.97.41.226','704424b3d501fb3c5e39d7f7f62911b4bc358f2c'),
	(1296670326,'88.97.41.226','73c8269cb015434f8cdecca451c42349429c3e08'),
	(1296670332,'88.97.41.226','d4c2612028cca749018bf23b92931cd730b1161b'),
	(1296663475,'88.97.41.226','c5021b1556b05313342a40a3fa62feb70f7f4a35'),
	(1296663433,'88.97.41.226','e08a1613c9ae252e360c35634e0f8d36df43d9f6'),
	(1296663431,'88.97.41.226','c6efb36c5c65de3c3816886cc60586e0f5243c51'),
	(1296663416,'88.97.41.226','ea2d84221af56807c1e720ba62766b168b77b306'),
	(1296663403,'88.97.41.226','aa4c956037daa65303ad3ce3b56094d6056ad0f3'),
	(1296663379,'88.97.41.226','8acfe59d8e7deccb7788502a427403bfd1be7395'),
	(1296663223,'88.97.41.226','22d1ad0daf63826c4354a3e2681b3806b732c5fa'),
	(1296663092,'88.97.41.226','879b53c7abf0667a4fcdddbccfafcc466b47b75f'),
	(1296660788,'75.89.69.119','8d4bc418eaa5746d9ef2fc7ebeb2af9502b098fe'),
	(1296660758,'75.89.69.119','601b10a508773a22359dd81d45369c7b2b532db6'),
	(1296667510,'88.97.41.224','cf01760b9e07b5d14f0ce5845b046e70afe2eec3'),
	(1296664693,'88.97.41.226','612dd8937ddf8f23aa9ca21e7d8007e2e6b001e2'),
	(1296664691,'88.97.41.226','1b02679be3728b3fa904c655444568b44530a77e'),
	(1296664686,'88.97.41.226','a163fb89d0e15b0af42bfe5251952e06922e92f8'),
	(1296664686,'88.97.41.226','88819665a9072cf3ff5867ffed4a0f5de06e83bf'),
	(1296664684,'88.97.41.226','65b21e73c986f8f13b991082b3a1d35c954b2aaf'),
	(1296663654,'88.97.41.226','36087ea0764c6589e43b84b1b4541d8bdd74362d'),
	(1296663651,'88.97.41.226','439ff25bc90ef10b35810ab53a755d0964e72414'),
	(1296663641,'88.97.41.226','20ebb3a720c3e9088731200ec3c8d64c218db75b'),
	(1296663639,'88.97.41.226','1beacbb197a9aa49a4546de11f1a3b6d829c250d'),
	(1296663568,'88.97.41.226','1aff2dad85c1b28465992215dc1fc412a22ca8d7'),
	(1296663506,'88.97.41.226','84a48efcc7a3de1c4b0f88c611f4e4c55740364f'),
	(1296667499,'88.97.41.224','8670b19069470265fb155b2c779bc67e521832d1'),
	(1296667496,'88.97.41.224','c3f817c7d179a22a0464b5c7075646b2b79d534f'),
	(1296667489,'88.97.41.224','2addac205300aaf431e57fdc34f8cffd3016d279'),
	(1296665990,'88.97.41.226','4ea3679218d22572497f40fa1c08837ba8fdfd76'),
	(1296665748,'88.97.41.226','7a20768dd047af72e1397533fed7d7a0353f5a34'),
	(1296665733,'88.97.41.226','17dbbfde02137e39e3ca1f593eee7a601191dc7e'),
	(1296665731,'88.97.41.226','597e37dcfcdd386b238a3841aa0da290e1f4fed7'),
	(1296665731,'88.97.41.226','8c9cab9935e36423493564e04ffe5d0c4246e0bb'),
	(1296665505,'88.97.41.226','95ce3105a943219669c34bc0f051ad117b8e4d18'),
	(1296665245,'88.97.41.226','3114560ae250df8ba54ee091246f71517c2d0187'),
	(1296665135,'88.97.41.226','9fbc77d23fb66ba644f372451c2908d171e9438d'),
	(1296665134,'88.97.41.226','aabf6b477082029b49ad24a7840e003168724131'),
	(1296665134,'88.97.41.226','622fcdca34da393af967e961b9b13204e8542e50'),
	(1296664722,'88.97.41.226','93c9ba09bff23c80359e1f4492253c29a84cbc05'),
	(1296657654,'88.97.41.226','a729dcc015bda0dcf8bf35d99762ce92d4d9a5b2'),
	(1296657654,'88.97.41.226','e53d3b332044ab692ddd82dc1ddfcae82ad90a06'),
	(1296657681,'88.97.41.226','f0332c87af4c5870d434f04a5afe5f33afedce8b'),
	(1296657694,'88.97.41.226','32260bdf3e1f8b7ecc49aea26f589ad78522b19d'),
	(1296657699,'88.97.41.226','1f417d1e5056ea5774617c7c80db3c94afa7ca9f'),
	(1296657737,'88.97.41.226','4bc899bd68a43d1348acf68fe29a50a2f7880a7a'),
	(1296658505,'88.97.41.226','322d31035d162ae60436513e2a9110fdeaccea01'),
	(1296658518,'88.97.41.226','6c1b0774c8adabfdc54a87ffd893bbcdcf50773e'),
	(1296658523,'88.97.41.226','bfb2aa79e5a9467e77e5abd0209b30da502185f7'),
	(1296658531,'88.97.41.226','86234dfb5d70827d7434bfee549f17c3d10b8518'),
	(1296658553,'88.97.41.226','08ebdf4964812b301aec3cc9b0db129082de87bd'),
	(1296658557,'88.97.41.226','111389558e871c9b24c9172b5624ea2d9e6f84ca'),
	(1296658564,'88.97.41.226','336ce69e0439544a1c026d993954298b5e3305b6'),
	(1296658567,'88.97.41.226','a08e1a0eb3456023dccfa796d12dc65c81ef9314'),
	(1296658569,'88.97.41.226','f9d37a7dc102de53c79fe2b75ce6b2d883802d3c'),
	(1296658574,'88.97.41.226','0ab7042690b90d58e138ddde6a097fc1e91350ce'),
	(1296658576,'88.97.41.226','eebc9ffc70c9116f0aa3fd0548b7a05de70d8787'),
	(1296658590,'88.97.41.226','9b9dc5a11500091ddcd6738889ec5b5ef62e85b1'),
	(1296658895,'88.97.41.226','67e180c01e190b119ac301d0e21e0cdf0d1da699'),
	(1296659492,'88.97.41.226','535a7a9e6bd84be818c9ea07efd483c43935d01f'),
	(1296659515,'88.97.41.226','4cebec695439f570de8f891a0d05cd06af7f02d5'),
	(1296659520,'88.97.41.226','cac12ac86c81cb6c8b32cd886c37f4b32a215b0d');

/*!40000 ALTER TABLE `exp_security_hashes` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_sessions
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_sessions`;

CREATE TABLE `exp_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `member_id` int(10) NOT NULL DEFAULT '0',
  `admin_sess` tinyint(1) NOT NULL DEFAULT '0',
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `user_agent` varchar(50) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`),
  KEY `member_id` (`member_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_sessions` WRITE;
/*!40000 ALTER TABLE `exp_sessions` DISABLE KEYS */;
INSERT INTO `exp_sessions` (`session_id`,`site_id`,`member_id`,`admin_sess`,`ip_address`,`user_agent`,`last_activity`)
VALUES
	('5c8b12bfa94e66f56f8b7898944aed3c5ee9e3eb',1,1,1,'88.97.41.226','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; ',1296683651),
	('9e62016d4c0e9681900e677c9537a6497b1d08eb',1,1,1,'88.97.41.226','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; ',1296724182);

/*!40000 ALTER TABLE `exp_sessions` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_sites
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_sites`;

CREATE TABLE `exp_sites` (
  `site_id` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `site_label` varchar(100) NOT NULL DEFAULT '',
  `site_name` varchar(50) NOT NULL DEFAULT '',
  `site_description` text NOT NULL,
  `site_system_preferences` text NOT NULL,
  `site_mailinglist_preferences` text NOT NULL,
  `site_member_preferences` text NOT NULL,
  `site_template_preferences` text NOT NULL,
  `site_weblog_preferences` text NOT NULL,
  PRIMARY KEY (`site_id`),
  KEY `site_name` (`site_name`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_sites` WRITE;
/*!40000 ALTER TABLE `exp_sites` DISABLE KEYS */;
INSERT INTO `exp_sites` (`site_id`,`site_label`,`site_name`,`site_description`,`site_system_preferences`,`site_mailinglist_preferences`,`site_member_preferences`,`site_template_preferences`,`site_weblog_preferences`)
VALUES
	(1,'Simon Campbell Music','default_site','','a:98:{s:15:\"encryption_type\";s:4:\"sha1\";s:10:\"site_index\";s:0:\"\";s:9:\"site_name\";s:10:\"EE Sandbox\";s:8:\"site_url\";s:21:\"http://sc-music.local\";s:16:\"theme_folder_url\";s:29:\"http://sc-music.local/themes/\";s:15:\"webmaster_email\";s:23:\"jamie@erskinedesign.com\";s:14:\"webmaster_name\";s:0:\"\";s:19:\"weblog_nomenclature\";s:7:\"channel\";s:10:\"max_caches\";s:3:\"150\";s:11:\"captcha_url\";s:49:\"http://sandbox.ee.erskinedev.com/images/captchas/\";s:12:\"captcha_path\";s:52:\"/var/www/html/subdomains/sandbox/ee/images/captchas/\";s:12:\"captcha_font\";s:1:\"y\";s:12:\"captcha_rand\";s:1:\"y\";s:23:\"captcha_require_members\";s:1:\"n\";s:17:\"enable_db_caching\";s:1:\"n\";s:18:\"enable_sql_caching\";s:1:\"n\";s:18:\"force_query_string\";s:1:\"n\";s:12:\"show_queries\";s:1:\"n\";s:18:\"template_debugging\";s:1:\"n\";s:15:\"include_seconds\";s:1:\"n\";s:13:\"cookie_domain\";s:0:\"\";s:11:\"cookie_path\";s:0:\"\";s:17:\"user_session_type\";s:1:\"c\";s:18:\"admin_session_type\";s:2:\"cs\";s:21:\"allow_username_change\";s:1:\"y\";s:18:\"allow_multi_logins\";s:1:\"y\";s:16:\"password_lockout\";s:1:\"y\";s:25:\"password_lockout_interval\";s:1:\"1\";s:20:\"require_ip_for_login\";s:1:\"y\";s:22:\"require_ip_for_posting\";s:1:\"y\";s:18:\"allow_multi_emails\";s:1:\"n\";s:24:\"require_secure_passwords\";s:1:\"n\";s:19:\"allow_dictionary_pw\";s:1:\"y\";s:23:\"name_of_dictionary_file\";s:0:\"\";s:17:\"xss_clean_uploads\";s:1:\"y\";s:15:\"redirect_method\";s:8:\"redirect\";s:9:\"deft_lang\";s:7:\"english\";s:8:\"xml_lang\";s:2:\"en\";s:7:\"charset\";s:5:\"utf-8\";s:12:\"send_headers\";s:1:\"y\";s:11:\"gzip_output\";s:1:\"n\";s:13:\"log_referrers\";s:1:\"y\";s:13:\"max_referrers\";s:3:\"500\";s:11:\"time_format\";s:2:\"us\";s:15:\"server_timezone\";s:3:\"UTC\";s:13:\"server_offset\";s:0:\"\";s:16:\"daylight_savings\";s:1:\"n\";s:21:\"default_site_timezone\";s:0:\"\";s:16:\"default_site_dst\";s:1:\"n\";s:15:\"honor_entry_dst\";s:1:\"y\";s:13:\"mail_protocol\";s:4:\"mail\";s:11:\"smtp_server\";s:0:\"\";s:13:\"smtp_username\";s:0:\"\";s:13:\"smtp_password\";s:0:\"\";s:11:\"email_debug\";s:1:\"n\";s:13:\"email_charset\";s:5:\"utf-8\";s:15:\"email_batchmode\";s:1:\"n\";s:16:\"email_batch_size\";s:0:\"\";s:11:\"mail_format\";s:5:\"plain\";s:9:\"word_wrap\";s:1:\"y\";s:22:\"email_console_timelock\";s:1:\"5\";s:22:\"log_email_console_msgs\";s:1:\"y\";s:8:\"cp_theme\";s:7:\"default\";s:21:\"email_module_captchas\";s:1:\"n\";s:16:\"log_search_terms\";s:1:\"y\";s:12:\"secure_forms\";s:1:\"y\";s:19:\"deny_duplicate_data\";s:1:\"y\";s:24:\"redirect_submitted_links\";s:1:\"n\";s:16:\"enable_censoring\";s:1:\"n\";s:14:\"censored_words\";s:0:\"\";s:18:\"censor_replacement\";s:0:\"\";s:10:\"banned_ips\";s:0:\"\";s:13:\"banned_emails\";s:0:\"\";s:16:\"banned_usernames\";s:0:\"\";s:19:\"banned_screen_names\";s:0:\"\";s:10:\"ban_action\";s:8:\"restrict\";s:11:\"ban_message\";s:34:\"This site is currently unavailable\";s:15:\"ban_destination\";s:21:\"http://www.yahoo.com/\";s:16:\"enable_emoticons\";s:1:\"y\";s:13:\"emoticon_path\";s:48:\"http://sandbox.ee.erskinedev.com/images/smileys/\";s:19:\"recount_batch_total\";s:4:\"1000\";s:13:\"remap_pm_urls\";s:1:\"n\";s:13:\"remap_pm_dest\";s:0:\"\";s:17:\"new_version_check\";s:1:\"y\";s:20:\"publish_tab_behavior\";s:5:\"hover\";s:18:\"sites_tab_behavior\";s:5:\"hover\";s:17:\"enable_throttling\";s:1:\"n\";s:17:\"banish_masked_ips\";s:1:\"y\";s:14:\"max_page_loads\";s:2:\"10\";s:13:\"time_interval\";s:1:\"8\";s:12:\"lockout_time\";s:2:\"30\";s:15:\"banishment_type\";s:7:\"message\";s:14:\"banishment_url\";s:0:\"\";s:18:\"banishment_message\";s:50:\"You have exceeded the allowed page load frequency.\";s:17:\"enable_search_log\";s:1:\"y\";s:19:\"max_logged_searches\";s:3:\"500\";s:17:\"theme_folder_path\";s:68:\"/users/jamiepittock/Sites/erskine/simoncampbell-music/public/themes/\";s:10:\"is_site_on\";s:1:\"y\";}','a:3:{s:19:\"mailinglist_enabled\";s:1:\"y\";s:18:\"mailinglist_notify\";s:1:\"n\";s:25:\"mailinglist_notify_emails\";s:0:\"\";}','a:44:{s:10:\"un_min_len\";s:1:\"4\";s:10:\"pw_min_len\";s:1:\"5\";s:25:\"allow_member_registration\";s:1:\"y\";s:25:\"allow_member_localization\";s:1:\"y\";s:18:\"req_mbr_activation\";s:5:\"email\";s:23:\"new_member_notification\";s:1:\"n\";s:23:\"mbr_notification_emails\";s:0:\"\";s:24:\"require_terms_of_service\";s:1:\"y\";s:22:\"use_membership_captcha\";s:1:\"n\";s:20:\"default_member_group\";s:1:\"5\";s:15:\"profile_trigger\";s:19:\"asdgasrtq42rafasfdg\";s:12:\"member_theme\";s:7:\"default\";s:14:\"enable_avatars\";s:1:\"y\";s:20:\"allow_avatar_uploads\";s:1:\"n\";s:10:\"avatar_url\";s:43:\"http://en-dev.local/uploads/system/avatars/\";s:11:\"avatar_path\";s:73:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/avatars/\";s:16:\"avatar_max_width\";s:3:\"100\";s:17:\"avatar_max_height\";s:3:\"100\";s:13:\"avatar_max_kb\";s:2:\"50\";s:13:\"enable_photos\";s:1:\"y\";s:9:\"photo_url\";s:49:\"http://en-dev.local/uploads/system/member_photos/\";s:10:\"photo_path\";s:79:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/member_photos/\";s:15:\"photo_max_width\";s:3:\"100\";s:16:\"photo_max_height\";s:3:\"100\";s:12:\"photo_max_kb\";s:2:\"50\";s:16:\"allow_signatures\";s:1:\"y\";s:13:\"sig_maxlength\";s:3:\"500\";s:21:\"sig_allow_img_hotlink\";s:1:\"n\";s:20:\"sig_allow_img_upload\";s:1:\"n\";s:11:\"sig_img_url\";s:57:\"http://en-dev.local/uploads/system/signature_attachments/\";s:12:\"sig_img_path\";s:87:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/signature_attachments/\";s:17:\"sig_img_max_width\";s:3:\"480\";s:18:\"sig_img_max_height\";s:2:\"80\";s:14:\"sig_img_max_kb\";s:2:\"30\";s:19:\"prv_msg_upload_path\";s:80:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/pm_attachments/\";s:23:\"prv_msg_max_attachments\";s:1:\"3\";s:22:\"prv_msg_attach_maxsize\";s:3:\"250\";s:20:\"prv_msg_attach_total\";s:3:\"100\";s:19:\"prv_msg_html_format\";s:4:\"safe\";s:18:\"prv_msg_auto_links\";s:1:\"y\";s:17:\"prv_msg_max_chars\";s:4:\"6000\";s:19:\"memberlist_order_by\";s:11:\"total_posts\";s:21:\"memberlist_sort_order\";s:4:\"desc\";s:20:\"memberlist_row_limit\";s:2:\"20\";}','a:6:{s:11:\"strict_urls\";s:1:\"n\";s:8:\"site_404\";s:0:\"\";s:19:\"save_tmpl_revisions\";s:1:\"n\";s:18:\"max_tmpl_revisions\";s:1:\"5\";s:15:\"save_tmpl_files\";s:1:\"y\";s:18:\"tmpl_file_basepath\";s:67:\"/users/jamiepittock/Sites/energynation.org/public/assets/templates/\";}','a:10:{s:21:\"enable_image_resizing\";s:1:\"y\";s:21:\"image_resize_protocol\";s:3:\"gd2\";s:18:\"image_library_path\";s:0:\"\";s:16:\"thumbnail_prefix\";s:5:\"thumb\";s:14:\"word_separator\";s:10:\"underscore\";s:17:\"use_category_name\";s:1:\"n\";s:22:\"reserved_category_word\";s:8:\"category\";s:23:\"auto_convert_high_ascii\";s:1:\"n\";s:22:\"new_posts_clear_caches\";s:1:\"y\";s:23:\"auto_assign_cat_parents\";s:1:\"y\";}');

/*!40000 ALTER TABLE `exp_sites` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_specialty_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_specialty_templates`;

CREATE TABLE `exp_specialty_templates` (
  `template_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `enable_template` char(1) NOT NULL DEFAULT 'y',
  `template_name` varchar(50) NOT NULL,
  `data_title` varchar(80) NOT NULL,
  `template_data` text NOT NULL,
  PRIMARY KEY (`template_id`),
  KEY `template_name` (`template_name`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_specialty_templates` WRITE;
/*!40000 ALTER TABLE `exp_specialty_templates` DISABLE KEYS */;
INSERT INTO `exp_specialty_templates` (`template_id`,`site_id`,`enable_template`,`template_name`,`data_title`,`template_data`)
VALUES
	(1,1,'y','offline_template','','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n    \n<!-- TITLE and META -->\n<title>System offline</title>\n\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<meta http-equiv=\"Content-Language\" content=\"en-us\" />\n<meta name=\'description\' content=\'\' />\n<meta name=\'keywords\' content=\'\' />\n<meta name=\'robots\' content=\'noindex,nofollow,noarchive\' />\n\n<!-- CSS -->\n<link href=\"/assets/css/screen.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" />\n\n</head>\n\n<body class=\"user_message\">\n    \n    <div id=\"user_message\">\n        \n        <div id=\"branding\">\n            <h1>Title</h1>\n        </div>\n\n		<div id=\"content_pri\">\n\n                    <p>The site is currently offline.  Please check back later.</p>\n	\n		</div> <!-- // #content_pri -->\n\n		<div id=\"content_sec\">\n\n		</div> <!-- // #content_sec -->\n\n	</div> <!-- // #user_message -->\n\n</body>\n</html>'),
	(2,1,'y','message_template','','<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">\n<html xmlns=\"http://www.w3.org/1999/xhtml\">\n<head>\n    \n<!-- TITLE and META -->\n<title>{title}</title>\n\n{meta_refresh}\n<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n<meta http-equiv=\"Content-Language\" content=\"en-us\" />\n<meta name=\'description\' content=\'\' />\n<meta name=\'keywords\' content=\'\' />\n<meta name=\'robots\' content=\'noindex,nofollow,noarchive\' />\n\n<!-- CSS -->\n<link href=\"/assets/css/screen.css\" type=\"text/css\" rel=\"stylesheet\" media=\"screen\" />\n\n</head>\n\n<body class=\"user_message\">\n    \n    <div id=\"user_message\">\n        \n        <div id=\"branding\">\n            <h1>Title</h1>\n        </div>\n\n		<div id=\"content_pri\">\n\n                    <h2>{heading}</h2>\n\n                    {content}\n\n                    <p class=\"back\">{link}</p>\n	\n		</div> <!-- // #content_pri -->\n\n		<div id=\"content_sec\">\n\n		</div> <!-- // #content_sec -->\n\n	</div> <!-- // #user_message -->\n\n</body>\n</html>'),
	(3,1,'y','admin_notify_reg','Notification of new member registration','The following person has submitted a new member registration: {name}\n\nAt: {site_name}\n\nYour control panel URL: {control_panel_url}'),
	(4,1,'y','admin_notify_entry','A new weblog entry has been posted','A new entry has been posted in the following weblog:\n{weblog_name}\n\nThe title of the entry is:\n{entry_title}\n\nPosted by: {name}\nEmail: {email}\n\nTo read the entry please visit: \n{entry_url}\n'),
	(5,1,'y','admin_notify_mailinglist','Someone has subscribed to your mailing list','A new mailing list subscription has been accepted.\n\nEmail Address: {email}\nMailing List: {mailing_list}'),
	(6,1,'y','admin_notify_comment','You have just received a comment','You have just received a comment for the following weblog:\n{weblog_name}\n\nThe title of the entry is:\n{entry_title}\n\nLocated at: \n{comment_url}\n\nPosted by: {name}\nEmail: {email}\nURL: {url}\nLocation: {location}\n\n{comment}'),
	(7,1,'y','admin_notify_gallery_comment','You have just received a comment','You have just received a comment for the following photo gallery:\n{gallery_name}\n\nThe title of the entry is:\n{entry_title}\n\nLocated at: \n{comment_url}\n\n{comment}'),
	(8,1,'y','admin_notify_trackback','You have just received a trackback','You have just received a trackback for the following entry:\n{entry_title}\n\nLocated at: \n{comment_url}\n\nThe trackback was sent from the following weblog:\n{sending_weblog_name}\n\nEntry Title:\n{sending_entry_title}\n\nWeblog URL:\n{sending_weblog_url}'),
	(9,1,'y','mbr_activation_instructions','Enclosed is your activation code','Thank you for your new member registration.\n\nTo activate your new account, please visit the following URL:\n\n{unwrap}{activation_url}{/unwrap}\n\nThank You!\n\n{site_name}\n\n{site_url}'),
	(10,1,'y','forgot_password_instructions','Login information','{name},\n\nTo reset your password, please go to the following page:\n\n{reset_url}\n\nYour password will be automatically reset, and a new password will be emailed to you.\n\nIf you do not wish to reset your password, ignore this message. It will expire in 24 hours.\n\n{site_name}\n{site_url}'),
	(11,1,'y','reset_password_notification','New Login Information','{name},\n\nHere is your new login information:\n\nUsername: {username}\nPassword: {password}\n\n{site_name}\n{site_url}'),
	(12,1,'y','validated_member_notify','Your membership account has been activated','{name},\n\nYour membership account has been activated and is ready for use.\n\nThank You!\n\n{site_name}\n{site_url}'),
	(13,1,'y','decline_member_validation','Your membership account has been declined','{name},\n\nWe\'re sorry but our staff has decided not to validate your membership.\n\n{site_name}\n{site_url}'),
	(14,1,'y','mailinglist_activation_instructions','Email Confirmation','Thank you for joining the \"{mailing_list}\" mailing list!\n\nPlease click the link below to confirm your email.\n\nIf you do not want to be added to our list, ignore this email.\n\n{unwrap}{activation_url}{/unwrap}\n\nThank You!\n\n{site_name}'),
	(15,1,'y','comment_notification','Someone just responded to your comment','Someone just responded to the entry you subscribed to at:\n{weblog_name}\n\nThe title of the entry is:\n{entry_title}\n\nYou can see the comment at the following URL:\n{comment_url}\n\n{comment}\n\nTo stop receiving notifications for this comment, click here:\n{notification_removal_url}'),
	(16,1,'y','gallery_comment_notification','Someone just responded to your comment','Someone just responded to the photo entry you subscribed to at:\n{gallery_name}\n\nYou can see the comment at the following URL:\n{comment_url}\n\n{comment}\n\nTo stop receiving notifications for this comment, click here:\n{notification_removal_url}'),
	(17,1,'y','private_message_notification','Someone has sent you a Private Message','\n{recipient_name},\n\n{sender_name} has just sent you a Private Message titled \'{message_subject}\'.\n\nYou can see the Private Message by logging in and viewing your InBox at:\n{site_url}\n\nTo stop receiving notifications of Private Messages, turn the option off in your Email Settings.'),
	(18,1,'y','pm_inbox_full','Your private message mailbox is full','{recipient_name},\n\n{sender_name} has just attempted to send you a Private Message,\nbut your InBox is full, exceeding the maximum of {pm_storage_limit}.\n\nPlease log in and remove unwanted messages from your InBox at:\n{site_url}');

/*!40000 ALTER TABLE `exp_specialty_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_stats
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_stats`;

CREATE TABLE `exp_stats` (
  `weblog_id` int(6) unsigned NOT NULL DEFAULT '0',
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `total_members` mediumint(7) NOT NULL DEFAULT '0',
  `recent_member_id` int(10) NOT NULL DEFAULT '0',
  `recent_member` varchar(50) NOT NULL,
  `total_entries` mediumint(8) NOT NULL DEFAULT '0',
  `total_forum_topics` mediumint(8) NOT NULL DEFAULT '0',
  `total_forum_posts` mediumint(8) NOT NULL DEFAULT '0',
  `total_comments` mediumint(8) NOT NULL DEFAULT '0',
  `total_trackbacks` mediumint(8) NOT NULL DEFAULT '0',
  `last_entry_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_forum_post_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_comment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_trackback_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_visitor_date` int(10) unsigned NOT NULL DEFAULT '0',
  `most_visitors` mediumint(7) NOT NULL DEFAULT '0',
  `most_visitor_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_cache_clear` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `weblog_id` (`weblog_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_stats` WRITE;
/*!40000 ALTER TABLE `exp_stats` DISABLE KEYS */;
INSERT INTO `exp_stats` (`weblog_id`,`site_id`,`total_members`,`recent_member_id`,`recent_member`,`total_entries`,`total_forum_topics`,`total_forum_posts`,`total_comments`,`total_trackbacks`,`last_entry_date`,`last_forum_post_date`,`last_comment_date`,`last_trackback_date`,`last_visitor_date`,`most_visitors`,`most_visitor_date`,`last_cache_clear`)
VALUES
	(0,1,9,19,'Simon Campbell',7,0,0,0,0,1296658583,0,0,0,1265120889,4,1249281451,1297265301);

/*!40000 ALTER TABLE `exp_stats` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_status_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_status_groups`;

CREATE TABLE `exp_status_groups` (
  `group_id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) NOT NULL,
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_status_groups` WRITE;
/*!40000 ALTER TABLE `exp_status_groups` DISABLE KEYS */;
INSERT INTO `exp_status_groups` (`group_id`,`site_id`,`group_name`)
VALUES
	(1,1,'Default Status Group');

/*!40000 ALTER TABLE `exp_status_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_status_no_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_status_no_access`;

CREATE TABLE `exp_status_no_access` (
  `status_id` int(6) unsigned NOT NULL,
  `member_group` smallint(4) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_statuses
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_statuses`;

CREATE TABLE `exp_statuses` (
  `status_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(4) unsigned NOT NULL,
  `status` varchar(50) NOT NULL,
  `status_order` int(3) unsigned NOT NULL,
  `highlight` varchar(30) NOT NULL,
  PRIMARY KEY (`status_id`),
  KEY `group_id` (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_statuses` WRITE;
/*!40000 ALTER TABLE `exp_statuses` DISABLE KEYS */;
INSERT INTO `exp_statuses` (`status_id`,`site_id`,`group_id`,`status`,`status_order`,`highlight`)
VALUES
	(1,1,1,'open',1,'009933'),
	(2,1,1,'closed',2,'990000'),
	(3,1,1,'Pending',3,''),
	(4,1,1,'Preview',4,''),
	(5,1,1,'Review',5,'');

/*!40000 ALTER TABLE `exp_statuses` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_super_search_cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_super_search_cache`;

CREATE TABLE `exp_super_search_cache` (
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
  KEY `hash` (`hash`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_super_search_history
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_super_search_history`;

CREATE TABLE `exp_super_search_history` (
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
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_super_search_refresh_rules
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_super_search_refresh_rules`;

CREATE TABLE `exp_super_search_refresh_rules` (
  `rule_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(10) unsigned NOT NULL DEFAULT '1',
  `date` int(10) unsigned NOT NULL,
  `refresh` smallint(5) unsigned NOT NULL,
  `template_id` int(10) unsigned NOT NULL DEFAULT '0',
  `weblog_id` int(10) unsigned NOT NULL DEFAULT '0',
  `category_group_id` int(10) unsigned NOT NULL DEFAULT '0',
  `member_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`rule_id`),
  KEY `site_id` (`site_id`),
  KEY `template_id` (`template_id`),
  KEY `weblog_id` (`weblog_id`),
  KEY `category_group_id` (`category_group_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_super_search_refresh_rules` WRITE;
/*!40000 ALTER TABLE `exp_super_search_refresh_rules` DISABLE KEYS */;
INSERT INTO `exp_super_search_refresh_rules` (`rule_id`,`site_id`,`date`,`refresh`,`template_id`,`weblog_id`,`category_group_id`,`member_id`)
VALUES
	(1,1,1276453995,10,0,0,0,1);

/*!40000 ALTER TABLE `exp_super_search_refresh_rules` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_template_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_template_groups`;

CREATE TABLE `exp_template_groups` (
  `group_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_name` varchar(50) NOT NULL,
  `group_order` int(3) unsigned NOT NULL,
  `is_site_default` char(1) NOT NULL DEFAULT 'n',
  `is_user_blog` char(1) NOT NULL DEFAULT 'n',
  PRIMARY KEY (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_template_groups` WRITE;
/*!40000 ALTER TABLE `exp_template_groups` DISABLE KEYS */;
INSERT INTO `exp_template_groups` (`group_id`,`site_id`,`group_name`,`group_order`,`is_site_default`,`is_user_blog`)
VALUES
	(4,1,'_layout',1,'n','n'),
	(3,1,'home',6,'y','n'),
	(6,1,'feeds',5,'n','n'),
	(7,1,'_components',2,'n','n'),
	(19,1,'404',4,'n','n'),
	(17,1,'_preview',3,'n','n'),
	(24,1,'thirtysix',7,'n','n'),
	(25,1,'store',8,'n','n'),
	(26,1,'journal',9,'n','n'),
	(27,1,'bio',10,'n','n'),
	(28,1,'gallery',11,'n','n'),
	(29,1,'contact',12,'n','n'),
	(30,1,'account',13,'n','n'),
	(31,1,'pages',14,'n','n');

/*!40000 ALTER TABLE `exp_template_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_template_member_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_template_member_groups`;

CREATE TABLE `exp_template_member_groups` (
  `group_id` smallint(4) unsigned NOT NULL,
  `template_group_id` mediumint(5) unsigned NOT NULL,
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_template_member_groups` WRITE;
/*!40000 ALTER TABLE `exp_template_member_groups` DISABLE KEYS */;
INSERT INTO `exp_template_member_groups` (`group_id`,`template_group_id`)
VALUES
	(6,4),
	(6,7),
	(6,3),
	(6,6);

/*!40000 ALTER TABLE `exp_template_member_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_template_no_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_template_no_access`;

CREATE TABLE `exp_template_no_access` (
  `template_id` int(6) unsigned NOT NULL,
  `member_group` smallint(4) unsigned NOT NULL,
  KEY `template_id` (`template_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_templates
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_templates`;

CREATE TABLE `exp_templates` (
  `template_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(6) unsigned NOT NULL,
  `template_name` varchar(50) NOT NULL,
  `save_template_file` char(1) NOT NULL DEFAULT 'y',
  `template_type` varchar(16) NOT NULL DEFAULT 'webpage',
  `template_data` mediumtext NOT NULL,
  `template_notes` text NOT NULL,
  `edit_date` int(10) NOT NULL DEFAULT '0',
  `last_author_id` int(10) unsigned NOT NULL,
  `cache` char(1) NOT NULL DEFAULT 'n',
  `refresh` int(6) unsigned NOT NULL,
  `no_auth_bounce` varchar(50) NOT NULL,
  `enable_http_auth` char(1) NOT NULL DEFAULT 'n',
  `allow_php` char(1) NOT NULL DEFAULT 'n',
  `php_parse_location` char(1) NOT NULL DEFAULT 'o',
  `hits` int(10) unsigned NOT NULL,
  PRIMARY KEY (`template_id`),
  KEY `group_id` (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=115 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_templates` WRITE;
/*!40000 ALTER TABLE `exp_templates` DISABLE KEYS */;
INSERT INTO `exp_templates` (`template_id`,`site_id`,`group_id`,`template_name`,`save_template_file`,`template_type`,`template_data`,`template_notes`,`edit_date`,`last_author_id`,`cache`,`refresh`,`no_auth_bounce`,`enable_http_auth`,`allow_php`,`php_parse_location`,`hits`)
VALUES
	(17,1,4,'index','n','webpage','','',1246626718,0,'n',0,'','n','n','o',0),
	(18,1,4,'_start','y','webpage','','',1246626772,1,'n',0,'','n','y','i',0),
	(19,1,4,'_end','y','webpage','','',1246626766,1,'n',0,'','n','n','o',0),
	(21,1,6,'index','n','webpage','','',1246626802,0,'n',0,'','n','n','o',0),
	(25,1,6,'google_sitemap_xml','y','xml','','',1246626876,1,'n',0,'','n','n','o',0),
	(26,1,7,'index','n','webpage','','',1246626899,0,'n',0,'','n','n','o',0),
	(29,1,7,'_comments','y','webpage','<div id=\"comments\">\n    \n    <h2>{if embed:comment_total == \"0\"}Start a discussion...{if:else}Discussion{/if}</h2>\n    \n	{exp:comment:entries sort=\"asc\" limit=\"20\" entry_id=\"{embed:entry_id}\"}\n    <ol id=\"comment_listing\">\n        <li id=\"comment-{comment_id}\">\n            <p class=\"comment_author\"><strong>{url_as_author}</strong> {comment_date format=\"{pv_date_full}\"}</p>\n            {comment}\n 		</li>\n    </ol>\n	{/exp:comment:entries}\n	\n    <h3>Add your comment</h3>\n\n	{exp:comment:form entry_id=\"{embed:entry_id}\"}\n	<fieldset>\n\n    	<div>\n        	<label for=\"comment_name\">Your name:</label>\n        	<input type=\"text\" id=\"comment_name\" name=\"name\" value=\"{name}\" />\n    	</div>\n    	<div>\n        	<label for=\"comment_email\">Email address:</label>\n        	<input type=\"text\" id=\"comment_email\" name=\"email\" value=\"{email}\" />\n    	</div>\n    	<div>\n        	<label for=\"comment_url\">URL:</label>\n        	<input type=\"text\" id=\"comment_url\" name=\"url\" value=\"{url}\" />\n    	</div>\n\n    	<div>\n        	<label for=\"comment_comment\">Message:</label>\n        	<textarea id=\"comment_comment\" rows=\"10\" cols=\"15\" name=\"comment\">{comment}</textarea>\n    	</div>\n    	<div>\n			<input type=\"hidden\" name=\"save_info\" value=\"yes\" {save_info} />\n			<input type=\"hidden\" name=\"notify_me\" value=\"yes\" {notify_me} />\n        	<input type=\"image\" src=\"{pv_site_url}/assets/images/site/comment_form_submit.gif\" />\n    	</div>\n\n	</fieldset>\n	{/exp:comment:form} \n    \n</div>','',1249282320,1,'n',0,'','n','n','o',0),
	(16,1,3,'index','y','webpage','{embed=\"_layout/_start\"\n    body_class=\"home\"\n    body_id=\"\"\n    section=\"\"\n    {!-- LG BETTER META OPTIONS BELOW --}\n    title=\"\"\n    title_suffix=\"\"   \n    title_prefix=\"\"   \n    description=\"\"\n    keywords=\"\"\n    robots_index=\"\"\n    robots_follow=\"\"\n    robots_archive=\"\"\n    canonical_url=\"/\"\n}\n\n\n    \n{embed=\"_layout/_end\"}','',1292410330,15,'n',0,'','n','y','i',53),
	(70,1,19,'index','y','webpage','','',1277463666,0,'n',0,'','n','n','o',0),
	(58,1,17,'index','y','webpage','','',1277452171,0,'n',0,'','n','n','o',0),
	(83,1,4,'_user_message_end','y','webpage','','',1278311051,0,'n',0,'','n','n','o',0),
	(82,1,4,'_user_message_start','y','webpage','','',1278311042,0,'n',0,'','n','n','o',0),
	(84,1,24,'index','y','webpage','','',1295720795,1,'n',0,'','n','n','o',0),
	(85,1,25,'index','y','webpage','','',1295720526,1,'n',0,'','n','n','o',0),
	(86,1,26,'index','y','webpage','','',1295720800,1,'n',0,'','n','y','o',0),
	(87,1,27,'index','y','webpage','','',1295720805,1,'n',0,'','n','n','o',0),
	(88,1,28,'index','y','webpage','','',1295720809,1,'n',0,'','n','y','o',0),
	(89,1,29,'index','y','webpage','','',1295720813,1,'n',0,'','n','n','o',0),
	(90,1,30,'index','y','webpage','','',1295720817,1,'n',0,'','n','n','o',0),
	(91,1,24,'_navigation','y','webpage','','',1295720856,0,'n',0,'','n','n','o',0),
	(92,1,25,'basket','y','webpage','','',1295720879,0,'n',0,'','n','n','o',0),
	(93,1,25,'checkout','y','webpage','','',1295720922,0,'n',0,'','n','n','o',0),
	(94,1,30,'forgotten','y','webpage','','',1295721012,0,'n',0,'','n','n','o',0),
	(95,1,27,'_navigation','y','webpage','','',1295721123,0,'n',0,'','n','n','o',0),
	(96,1,4,'_sidebar','y','webpage','','',1295799561,0,'n',0,'','n','n','o',0),
	(97,1,26,'_index_listing','y','webpage','','',1295801007,0,'n',0,'','n','n','o',0),
	(98,1,26,'_index_detail','y','webpage','','',1295801025,0,'n',0,'','n','n','o',0),
	(99,1,26,'archives','y','webpage','','',1295801246,0,'n',0,'','n','n','o',0),
	(100,1,28,'_index_listing','y','webpage','','',1295801373,0,'n',0,'','n','n','o',0),
	(101,1,28,'_index_detail','y','webpage','','',1295801381,0,'n',0,'','n','n','o',0),
	(102,1,30,'update','y','webpage','','',1295801585,0,'n',0,'','n','n','o',0),
	(103,1,30,'orders','y','webpage','','',1295801591,0,'n',0,'','n','n','o',0),
	(104,1,30,'_navigation','y','webpage','','',1295801750,0,'n',0,'','n','n','o',0),
	(105,1,25,'product','y','webpage','','',1295802346,0,'n',0,'','n','n','o',0),
	(106,1,31,'index','y','webpage','','',1295802500,0,'n',0,'','n','n','o',0),
	(107,1,31,'_navigation','y','webpage','','',1295802510,0,'n',0,'','n','n','o',0),
	(108,1,30,'pending','y','webpage','','',1295804365,0,'n',0,'','n','n','o',0),
	(109,1,30,'activated','y','webpage','','',1295804383,0,'n',0,'','n','n','o',0),
	(110,1,6,'master_rss','y','rss','','',1296654568,0,'n',0,'','n','n','o',0),
	(111,1,26,'preview','y','webpage','','',1296657369,0,'n',0,'','n','n','o',0),
	(112,1,27,'gear','y','webpage','','',1296674154,18,'n',0,'','n','n','o',0),
	(113,1,24,'lyrics','y','webpage','','',1296674177,18,'n',0,'','n','n','o',0),
	(114,1,24,'history','y','webpage','','',1296674197,0,'n',0,'','n','n','o',0);

/*!40000 ALTER TABLE `exp_templates` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_throttle
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_throttle`;

CREATE TABLE `exp_throttle` (
  `ip_address` varchar(16) NOT NULL DEFAULT '0',
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `hits` int(10) unsigned NOT NULL,
  `locked_out` char(1) NOT NULL DEFAULT 'n',
  KEY `ip_address` (`ip_address`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_trackbacks
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_trackbacks`;

CREATE TABLE `exp_trackbacks` (
  `trackback_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `entry_id` int(10) unsigned NOT NULL DEFAULT '0',
  `weblog_id` int(4) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `weblog_name` varchar(100) NOT NULL,
  `trackback_url` varchar(200) NOT NULL,
  `trackback_date` int(10) NOT NULL,
  `trackback_ip` varchar(16) NOT NULL,
  PRIMARY KEY (`trackback_id`),
  KEY `entry_id` (`entry_id`),
  KEY `weblog_id` (`weblog_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;



# Dump of table exp_upload_no_access
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_upload_no_access`;

CREATE TABLE `exp_upload_no_access` (
  `upload_id` int(6) unsigned NOT NULL,
  `upload_loc` varchar(3) NOT NULL,
  `member_group` smallint(4) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_upload_no_access` WRITE;
/*!40000 ALTER TABLE `exp_upload_no_access` DISABLE KEYS */;
INSERT INTO `exp_upload_no_access` (`upload_id`,`upload_loc`,`member_group`)
VALUES
	(11,'cp',5),
	(4,'cp',7),
	(11,'cp',7),
	(14,'cp',7),
	(14,'cp',5),
	(15,'cp',7),
	(15,'cp',5),
	(16,'cp',7),
	(16,'cp',5),
	(17,'cp',7),
	(17,'cp',5);

/*!40000 ALTER TABLE `exp_upload_no_access` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_upload_prefs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_upload_prefs`;

CREATE TABLE `exp_upload_prefs` (
  `id` int(4) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `is_user_blog` char(1) NOT NULL DEFAULT 'n',
  `name` varchar(50) NOT NULL,
  `server_path` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `allowed_types` varchar(3) NOT NULL DEFAULT 'img',
  `max_size` varchar(16) NOT NULL,
  `max_height` varchar(6) NOT NULL,
  `max_width` varchar(6) NOT NULL,
  `properties` varchar(120) NOT NULL,
  `pre_format` varchar(120) NOT NULL,
  `post_format` varchar(120) NOT NULL,
  `file_properties` varchar(120) NOT NULL,
  `file_pre_format` varchar(120) NOT NULL,
  `file_post_format` varchar(120) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_upload_prefs` WRITE;
/*!40000 ALTER TABLE `exp_upload_prefs` DISABLE KEYS */;
INSERT INTO `exp_upload_prefs` (`id`,`site_id`,`is_user_blog`,`name`,`server_path`,`url`,`allowed_types`,`max_size`,`max_height`,`max_width`,`properties`,`pre_format`,`post_format`,`file_properties`,`file_pre_format`,`file_post_format`)
VALUES
	(4,1,'n','Files: Documents','../uploads/files/documents/','/uploads/files/documents/','all','','','','','','','','',''),
	(11,1,'n','Images: General','../uploads/images/general/','/uploads/images/general/','img','','','','alt=\"\"','','','','',''),
	(14,1,'n','Images: Journal','../uploads/images/journal/','/uploads/images/journal/','img','','','','alt=\"\"','','','','',''),
	(15,1,'n','Videos','../uploads/videos/','/uploads/videos/','all','','','','','','','','',''),
	(16,1,'n','Audio','../uploads/audio/','/uploads/audio/','all','','','','','','','','',''),
	(17,1,'n','Images: Galleries','../uploads/images/galleries/','/uploads/images/galleries/','img','','','','alt=\"\"','','','','','');

/*!40000 ALTER TABLE `exp_upload_prefs` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_user_activation_group
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_activation_group`;

CREATE TABLE `exp_user_activation_group` (
  `member_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  KEY `member_id` (`member_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_user_authors
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_authors`;

CREATE TABLE `exp_user_authors` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `entry_id` int(10) unsigned NOT NULL DEFAULT '0',
  `principal` char(1) NOT NULL DEFAULT 'n',
  `entry_date` int(10) NOT NULL DEFAULT '0',
  `hash` varchar(40) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `entry_id` (`entry_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_user_cache
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_cache`;

CREATE TABLE `exp_user_cache` (
  `cache_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(150) NOT NULL,
  `entry_date` int(10) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`cache_id`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_user_category_posts
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_category_posts`;

CREATE TABLE `exp_user_category_posts` (
  `member_id` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_id` int(10) unsigned NOT NULL DEFAULT '0',
  KEY `member_id` (`member_id`),
  KEY `cat_id` (`cat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_user_keys
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_keys`;

CREATE TABLE `exp_user_keys` (
  `key_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `date` int(10) NOT NULL,
  `email` varchar(150) NOT NULL,
  `hash` varchar(8) NOT NULL,
  PRIMARY KEY (`key_id`),
  KEY `email` (`email`),
  KEY `hash` (`hash`),
  KEY `author_id` (`author_id`),
  KEY `member_id` (`member_id`),
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_user_params
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_params`;

CREATE TABLE `exp_user_params` (
  `params_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `hash` varchar(25) NOT NULL,
  `entry_date` int(10) NOT NULL,
  `data` text NOT NULL,
  PRIMARY KEY (`params_id`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_user_params` WRITE;
/*!40000 ALTER TABLE `exp_user_params` DISABLE KEYS */;
INSERT INTO `exp_user_params` (`params_id`,`hash`,`entry_date`,`data`)
VALUES
	(15,'qUn8nQfbMLHFs7bJiuA4x0W1o',1296223847,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}'),
	(16,'3e0Jd4ZghX8LlwNufK0VBwyae',1296230288,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}');

/*!40000 ALTER TABLE `exp_user_params` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_user_preferences
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_preferences`;

CREATE TABLE `exp_user_preferences` (
  `preference_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `preference_name` varchar(50) NOT NULL,
  `preference_value` text NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  PRIMARY KEY (`preference_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_user_preferences` WRITE;
/*!40000 ALTER TABLE `exp_user_preferences` DISABLE KEYS */;
INSERT INTO `exp_user_preferences` (`preference_id`,`preference_name`,`preference_value`,`site_id`)
VALUES
	(21,'email_is_username','n',1),
	(22,'screen_name_override','',1),
	(23,'category_groups','3',1),
	(24,'welcome_email_subject','Welcome Email',1),
	(25,'welcome_email_content','',1),
	(26,'user_forgot_username_message','{screen_name},\n\nPer your request, we have emailed you your username for {site_name} located at {site_url}.\n\nUsername: {username}',1),
	(27,'member_update_admin_notification_template','',1),
	(28,'member_update_admin_notification_emails','',1),
	(29,'key_expiration','7',1);

/*!40000 ALTER TABLE `exp_user_preferences` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_user_search
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_search`;

CREATE TABLE `exp_user_search` (
  `search_id` varchar(32) NOT NULL,
  `member_id` int(10) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `ip_address` varchar(16) NOT NULL,
  `search_date` int(10) unsigned NOT NULL,
  `total_results` int(8) unsigned NOT NULL,
  `keywords` varchar(200) NOT NULL,
  `categories` text NOT NULL,
  `member_ids` text NOT NULL,
  `fields` text NOT NULL,
  `cfields` text NOT NULL,
  `query` text NOT NULL,
  PRIMARY KEY (`search_id`),
  KEY `member_id` (`member_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_user_welcome_email_list
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_user_welcome_email_list`;

CREATE TABLE `exp_user_welcome_email_list` (
  `member_id` int(10) unsigned NOT NULL,
  `group_id` int(10) unsigned NOT NULL,
  `email_sent` char(1) NOT NULL DEFAULT 'n',
  KEY `member_id` (`member_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;



# Dump of table exp_weblog_data
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_weblog_data`;

CREATE TABLE `exp_weblog_data` (
  `entry_id` int(10) unsigned NOT NULL,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `weblog_id` int(4) unsigned NOT NULL,
  `field_id_66` text NOT NULL,
  `field_ft_66` tinytext,
  `field_id_67` text NOT NULL,
  `field_ft_67` tinytext,
  `field_id_68` text NOT NULL,
  `field_ft_68` tinytext,
  `field_id_69` text NOT NULL,
  `field_ft_69` tinytext,
  `field_id_70` text NOT NULL,
  `field_ft_70` tinytext,
  `field_id_71` text NOT NULL,
  `field_ft_71` tinytext,
  `field_id_72` text NOT NULL,
  `field_ft_72` tinytext,
  `field_id_73` text NOT NULL,
  `field_ft_73` tinytext,
  `field_id_74` text NOT NULL,
  `field_ft_74` tinytext,
  `field_id_75` text NOT NULL,
  `field_ft_75` tinytext,
  `field_id_76` text NOT NULL,
  `field_ft_76` tinytext,
  `field_id_77` text NOT NULL,
  `field_ft_77` tinytext,
  `field_id_78` text NOT NULL,
  `field_ft_78` tinytext,
  `field_id_79` text NOT NULL,
  `field_ft_79` tinytext,
  `field_id_81` text NOT NULL,
  `field_ft_81` tinytext,
  `field_id_82` text NOT NULL,
  `field_ft_82` tinytext,
  `field_id_83` text NOT NULL,
  `field_ft_83` tinytext,
  `field_id_84` text NOT NULL,
  `field_ft_84` tinytext,
  `field_id_85` text NOT NULL,
  `field_ft_85` tinytext,
  KEY `entry_id` (`entry_id`),
  KEY `weblog_id` (`weblog_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_data` WRITE;
/*!40000 ALTER TABLE `exp_weblog_data` DISABLE KEYS */;
INSERT INTO `exp_weblog_data` (`entry_id`,`site_id`,`weblog_id`,`field_id_66`,`field_ft_66`,`field_id_67`,`field_ft_67`,`field_id_68`,`field_ft_68`,`field_id_69`,`field_ft_69`,`field_id_70`,`field_ft_70`,`field_id_71`,`field_ft_71`,`field_id_72`,`field_ft_72`,`field_id_73`,`field_ft_73`,`field_id_74`,`field_ft_74`,`field_id_75`,`field_ft_75`,`field_id_76`,`field_ft_76`,`field_id_77`,`field_ft_77`,`field_id_78`,`field_ft_78`,`field_id_79`,`field_ft_79`,`field_id_81`,`field_ft_81`,`field_id_82`,`field_ft_82`,`field_id_83`,`field_ft_83`,`field_id_84`,`field_ft_84`,`field_id_85`,`field_ft_85`)
VALUES
	(43,1,21,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'content_pri_post1.jpg','none','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget augue est, sit amet lacinia nisl. Integer purus turpis, tristique sed ornare at, bibendum at augue. Vivamus commodo lobortis urna, ac posuere mauris malesuada ut. \n\nCras non nisl ut diam ornare pulvinar et nec nisi. In tincidunt nunc lacinia neque imperdiet iaculis et quis dolor. ','textile','',NULL,'','none','','textile'),
	(45,1,20,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'/assets/audio/brother.mp3','none','Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget augue est, sit amet lacinia nisl. Integer purus turpis, tristique sed ornare at, bibendum at augue.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'/assets/audio/brother.ogg','none','','textile'),
	(46,1,18,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'1','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile'),
	(49,1,19,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'19387854','none','This is number one in a series of five videos about the making of the album \"Thirty Six\". To read about the making of the album, see the article \"The Album ThirtySix: Part One\":http://blog.simoncampbell.com/blog/perma/making_the_album_thirtysix_part_one/ on my personal blog.','textile','',NULL,'',NULL,'',NULL,'',NULL,'','textile'),
	(47,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Lorem ipsum dolor sit amet, consectetur adipiscing elit. \"Ut eget augue est, sit\":http://google.com amet lacinia nisl. Integer purus turpis, tristique sed ornare at, bibendum at augue. Vivamus commodo lobortis urna, ac posuere mauris malesuada ut. \n\nh3. Heading 3\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget augue est, *sit amet lacinia* nisl. Integer purus turpis, _tristique sed ornare_ at, bibendum at augue. Vivamus commodo lobortis urna, ac posuere mauris malesuada ut. \n\nh4. Heading 4\n\nLorem ipsum dolor sit amet, consectetur adipiscing elit. Ut eget augue est, sit amet lacinia nisl. Integer purus turpis, tristique sed ornare at, bibendum at augue. Vivamus commodo lobortis urna, ac posuere mauris malesuada ut. \n\nbq. This is a block quote.  Ut eget augue est, sit amet lacinia nisl. Integer purus turpis, tristique sed ornare at, bibendum at augue. Vivamus commodo lobortis urna, ac posuere mauris malesuada ut. \n\n# List item 1\n# List item 2\n# List item 3\n\n* List item 1\n* List item 2\n* List item 3','textile','',NULL,'','textile'),
	(48,1,17,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Centenary Centre','none','Peel','none','1301097601','none','http://www.facebook.com/event.php?eid=127886567271836&index=1','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','textile'),
	(50,1,23,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'h3. Information collection and use\n\nThis site is owned and run by Supertone Records (hereinafter referred as Supertone) is a trading style of Erskine Corporation; full details can be found on the \"Company details page\":http://erskinedesign.com/docs/company-details/.\n\nSupertone is the sole owner of the information collected on this site. We will not sell, share, or rent this information to others in ways different from what is disclosed in this policy. Supertone collects information from our users at several different points on our website.\n\nh3. Cookies, IP addresses and statistics\n\nA cookie is a piece of data stored on the userâ€™s hard drive containing information about the user. We do not require any form of login or user account for this website. If a user rejects the cookie, they may still use our site.\n\nAn Internet Protocol (IP) address is a numerical identification that your computer or other browsing device sends out. We use cookies and IP addresses to analyse trends, administer the site, track userâ€™s movement, and gather broad demographic information for aggregate use. Cookies and IP addresses are not linked to personally identifiable information.\n\nh3. Your email and contact details\n\nIf you plan to use our Contact form to get in touch with us, be aware that your personal email address will be revealed in our email applications. Your email address will only be used for communication between ourselves and you. Email addresses will not be passed to any third parties. Your email address and any associated contact details delivered by email may be stored on our secure Customer Relations Management system for our internal use. We manage our own web servers too, so your information never passes through a third-party system.\n\nThis website takes every precaution to protect our usersâ€™ information. When users submit sensitive information via the website, your information is protected both online and off-line.\n\nAll of our usersâ€™ information, not just the sensitive information mentioned above, is restricted in our offices. Only employees who need the information to perform a specific job are granted access to personally identifiable information.\n\nAll of our employees are kept up-to-date on our security and privacy practices. Every quarter, as well as any time new policies are added, our employees are notified and/or reminded about the importance we place on privacy, and what they can do to ensure our customersâ€™ information is protected.\n\nFinally, the servers that we store personally identifiable information on are kept in a secure environment, behind a locked cage.\n\nAny personal information entrusted to us will never be entrusted to carriers or the Royal Mail unless agreed, and a signature would always be required from the recipient. Under no circumstances will your private data ever be found on a train and handed to the BBC.\n\nIf you have any questions about the security at our website, you can send an email to [email=artists@supertonerecords.com]artists@supertonerecords.com[/email].\n\nh3. Sharing\n\nSupertone will, under no circumstances, share with any third party individual IP addresses, email addresses, personal contact details or other information collected through this website or related statistic tracking systems. If information sharing is required, such as to bring in a third party in a project for example, you will be given immediate notice.\nExternal links\n\nThis web site contains links to other sites. Please be aware that we at Supertone are not responsible for the privacy practices of such other sites. We encourage our users to be aware when they leave our site and to read the privacy statements of each and every web site that collects personally identifiable information. This privacy policy applies solely to information collected by this web site.\n\nh3. Notification of changes\n\nIf we decide to change our privacy policy, we will post those changes on this page immediately so our users are always aware of what information we collect, how we use it, and what circumstances, if any, we disclose it.\n\nh3. Data Protection\n\nSupertone are registered with the Data Protection Supervisor.','textile');

/*!40000 ALTER TABLE `exp_weblog_data` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_weblog_fields
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_weblog_fields`;

CREATE TABLE `exp_weblog_fields` (
  `field_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `group_id` int(4) unsigned NOT NULL,
  `field_name` varchar(32) NOT NULL,
  `field_label` varchar(50) NOT NULL,
  `field_instructions` text NOT NULL,
  `field_type` varchar(12) NOT NULL DEFAULT 'text',
  `field_list_items` text NOT NULL,
  `field_pre_populate` char(1) NOT NULL DEFAULT 'n',
  `field_pre_blog_id` int(6) unsigned NOT NULL,
  `field_pre_field_id` int(6) unsigned NOT NULL,
  `field_related_to` varchar(12) NOT NULL DEFAULT 'blog',
  `field_related_id` int(6) unsigned NOT NULL,
  `field_related_orderby` varchar(12) NOT NULL DEFAULT 'date',
  `field_related_sort` varchar(4) NOT NULL DEFAULT 'desc',
  `field_related_max` smallint(4) NOT NULL,
  `field_ta_rows` tinyint(2) DEFAULT '8',
  `field_maxl` smallint(3) NOT NULL,
  `field_required` char(1) NOT NULL DEFAULT 'n',
  `field_text_direction` char(3) NOT NULL DEFAULT 'ltr',
  `field_search` char(1) NOT NULL DEFAULT 'n',
  `field_is_hidden` char(1) NOT NULL DEFAULT 'n',
  `field_fmt` varchar(40) NOT NULL DEFAULT 'xhtml',
  `field_show_fmt` char(1) NOT NULL DEFAULT 'y',
  `field_order` int(3) unsigned NOT NULL,
  `ff_settings` text NOT NULL,
  PRIMARY KEY (`field_id`),
  KEY `group_id` (`group_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_fields` WRITE;
/*!40000 ALTER TABLE `exp_weblog_fields` DISABLE KEYS */;
INSERT INTO `exp_weblog_fields` (`field_id`,`site_id`,`group_id`,`field_name`,`field_label`,`field_instructions`,`field_type`,`field_list_items`,`field_pre_populate`,`field_pre_blog_id`,`field_pre_field_id`,`field_related_to`,`field_related_id`,`field_related_orderby`,`field_related_sort`,`field_related_max`,`field_ta_rows`,`field_maxl`,`field_required`,`field_text_direction`,`field_search`,`field_is_hidden`,`field_fmt`,`field_show_fmt`,`field_order`,`ff_settings`)
VALUES
	(66,1,15,'cf_journal_body','Body content','','textarea','','n',0,0,'blog',0,'title','desc',0,10,128,'n','ltr','y','n','textile','n',1,''),
	(67,1,15,'cf_journal_image','Photo','','ftype_id_10','','n',0,0,'blog',16,'title','desc',0,6,128,'n','ltr','n','n','none','n',2,'a:2:{s:8:\"max_rows\";s:1:\"1\";s:7:\"col_ids\";a:3:{i:0;s:2:\"17\";i:1;s:2:\"18\";i:2;s:2:\"19\";}}'),
	(68,1,15,'cf_journal_audio','Audio','','ftype_id_10','','n',0,0,'blog',0,'title','desc',0,6,128,'n','ltr','n','n','none','n',3,'a:2:{s:8:\"max_rows\";s:1:\"1\";s:7:\"col_ids\";a:2:{i:0;s:2:\"20\";i:1;s:2:\"21\";}}'),
	(69,1,15,'cf_journal_video','Video','','ftype_id_10','','n',0,0,'blog',0,'title','desc',0,6,128,'n','ltr','n','n','none','n',4,'a:2:{s:8:\"max_rows\";s:1:\"1\";s:7:\"col_ids\";a:2:{i:0;s:2:\"22\";i:1;s:2:\"23\";}}'),
	(70,1,15,'cf_journal_extended','Extended content','','textarea','','n',0,0,'blog',0,'title','desc',0,20,128,'n','ltr','y','n','textile','n',5,''),
	(71,1,16,'cf_events_venue','Venue','The name of the venue. <strong>Example</strong>: <em>Rock City</em>','text','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',6,''),
	(72,1,16,'cf_events_city','City','','text','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',7,''),
	(73,1,16,'cf_events_date','Date','','ftype_id_13','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',8,'a:2:{s:11:\"date_format\";s:4:\"unix\";s:10:\"year_range\";s:9:\"2011-2020\";}'),
	(74,1,16,'cf_events_fburl','Facebook URL','Copy/paste the Facebook Event URL here.','text','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',9,''),
	(75,1,17,'cf_gallery_images','Images','Add images/image data below. To add multiple images, click the <strong>+</strong> button.','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',10,'a:2:{s:8:\"max_rows\";s:0:\"\";s:7:\"col_ids\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}}'),
	(76,1,18,'cf_journal_audio_mp3','Audio file (mp3)','','text','','n',0,0,'blog',17,'title','desc',0,6,255,'y','ltr','n','n','none','n',1,''),
	(77,1,18,'cf_journal_audio_lead','Lead text','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','y','n','textile','n',3,''),
	(78,1,19,'cf_journal_videos_vimeo','Vimeo ID','This should just be the 8 digit ID from the vimeo url','text','','n',0,0,'blog',17,'title','desc',0,6,8,'y','ltr','n','n','none','n',13,''),
	(79,1,19,'cf_journal_videos_lead','Lead text','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','y','n','textile','n',14,''),
	(81,1,20,'cf_journal_photos_image','Uploaded image','Ideally the photo should be landscape and suitable to be displayed at 585px wide. We\'ll resize it as best we can.','ftype_id_6','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',15,'a:1:{s:7:\"options\";s:2:\"14\";}'),
	(82,1,20,'cf_journal_photos_lead','Lead text','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','y','n','textile','n',16,''),
	(83,1,21,'cf_journal_notes_note','Note','','textarea','','n',0,0,'blog',17,'title','desc',0,10,128,'y','ltr','y','n','textile','n',17,''),
	(84,1,18,'cf_journal_audio_ogg','Audio file (ogg)','','text','','n',0,0,'blog',17,'title','desc',0,6,255,'y','ltr','n','n','none','n',2,''),
	(85,1,22,'cf_pages_body','Page content','','textarea','','n',0,0,'blog',17,'title','desc',0,40,128,'y','ltr','y','n','textile','n',19,'');

/*!40000 ALTER TABLE `exp_weblog_fields` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_weblog_member_groups
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_weblog_member_groups`;

CREATE TABLE `exp_weblog_member_groups` (
  `group_id` smallint(4) unsigned NOT NULL,
  `weblog_id` int(6) unsigned NOT NULL,
  KEY `group_id` (`group_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_member_groups` WRITE;
/*!40000 ALTER TABLE `exp_weblog_member_groups` DISABLE KEYS */;
INSERT INTO `exp_weblog_member_groups` (`group_id`,`weblog_id`)
VALUES
	(6,23),
	(6,19),
	(6,21),
	(6,22),
	(6,20),
	(6,18),
	(6,17);

/*!40000 ALTER TABLE `exp_weblog_member_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_weblog_titles
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_weblog_titles`;

CREATE TABLE `exp_weblog_titles` (
  `entry_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `weblog_id` int(4) unsigned NOT NULL,
  `author_id` int(10) unsigned NOT NULL DEFAULT '0',
  `pentry_id` int(10) NOT NULL DEFAULT '0',
  `forum_topic_id` int(10) unsigned NOT NULL,
  `ip_address` varchar(16) NOT NULL,
  `title` varchar(100) NOT NULL,
  `url_title` varchar(75) NOT NULL,
  `status` varchar(50) NOT NULL,
  `versioning_enabled` char(1) NOT NULL DEFAULT 'n',
  `view_count_one` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_two` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_three` int(10) unsigned NOT NULL DEFAULT '0',
  `view_count_four` int(10) unsigned NOT NULL DEFAULT '0',
  `allow_comments` varchar(1) NOT NULL DEFAULT 'y',
  `allow_trackbacks` varchar(1) NOT NULL DEFAULT 'n',
  `sticky` varchar(1) NOT NULL DEFAULT 'n',
  `entry_date` int(10) NOT NULL,
  `dst_enabled` varchar(1) NOT NULL DEFAULT 'n',
  `year` char(4) NOT NULL,
  `month` char(2) NOT NULL,
  `day` char(3) NOT NULL,
  `expiration_date` int(10) NOT NULL DEFAULT '0',
  `comment_expiration_date` int(10) NOT NULL DEFAULT '0',
  `edit_date` bigint(14) DEFAULT NULL,
  `recent_comment_date` int(10) NOT NULL,
  `comment_total` int(4) unsigned NOT NULL DEFAULT '0',
  `trackback_total` int(4) unsigned NOT NULL DEFAULT '0',
  `sent_trackbacks` text NOT NULL,
  `recent_trackback_date` int(10) NOT NULL,
  PRIMARY KEY (`entry_id`),
  KEY `weblog_id` (`weblog_id`),
  KEY `author_id` (`author_id`),
  KEY `url_title` (`url_title`),
  KEY `status` (`status`),
  KEY `entry_date` (`entry_date`),
  KEY `expiration_date` (`expiration_date`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=51 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_titles` WRITE;
/*!40000 ALTER TABLE `exp_weblog_titles` DISABLE KEYS */;
INSERT INTO `exp_weblog_titles` (`entry_id`,`site_id`,`weblog_id`,`author_id`,`pentry_id`,`forum_topic_id`,`ip_address`,`title`,`url_title`,`status`,`versioning_enabled`,`view_count_one`,`view_count_two`,`view_count_three`,`view_count_four`,`allow_comments`,`allow_trackbacks`,`sticky`,`entry_date`,`dst_enabled`,`year`,`month`,`day`,`expiration_date`,`comment_expiration_date`,`edit_date`,`recent_comment_date`,`comment_total`,`trackback_total`,`sent_trackbacks`,`recent_trackback_date`)
VALUES
	(43,1,21,1,0,0,'127.0.0.1','This is an example photo','this-is-an-example-photo','open','y',0,0,0,0,'y','n','n',1296642773,'n','2011','02','02',0,0,20110202103354,0,0,0,'',0),
	(49,1,19,1,0,0,'88.97.41.226','Making the album ThirtySix: edition #1','making-the-album-thirtysix-edition-1','open','y',0,0,0,0,'y','n','n',1296656268,'n','2011','02','02',0,0,20110202142749,0,0,0,'',0),
	(45,1,20,1,0,0,'88.97.41.226','This is some badass audio','this-is-some-badass-audio','open','y',0,0,0,0,'y','n','n',1296642998,'n','2011','02','02',0,0,20110202123939,0,0,0,'',0),
	(46,1,18,1,0,0,'88.97.41.226','Gallery','gallery','open','y',0,0,0,0,'y','n','n',1296646788,'n','2011','02','02',0,0,20110202165949,0,0,0,'',0),
	(47,1,22,1,0,0,'88.97.41.226','An example note','an-example-note','open','y',0,0,0,0,'y','n','n',1296654283,'n','2011','02','02',0,0,20110202134644,0,0,0,'',0),
	(48,1,17,1,0,0,'88.97.41.226','ThirtySix Album Launch','thirtysix-album-launch','open','y',0,0,0,0,'y','n','n',1296655657,'n','2011','02','02',0,0,20110202140838,0,0,0,'',0),
	(50,1,23,1,0,0,'88.97.41.226','Privacy policy','privacy-policy','open','y',0,0,0,0,'y','n','n',1296658583,'n','2011','02','02',0,0,20110202164724,0,0,0,'',0);

/*!40000 ALTER TABLE `exp_weblog_titles` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table exp_weblogs
# ------------------------------------------------------------

DROP TABLE IF EXISTS `exp_weblogs`;

CREATE TABLE `exp_weblogs` (
  `weblog_id` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `site_id` int(4) unsigned NOT NULL DEFAULT '1',
  `is_user_blog` char(1) NOT NULL DEFAULT 'n',
  `blog_name` varchar(40) NOT NULL,
  `blog_title` varchar(100) NOT NULL,
  `blog_url` varchar(100) NOT NULL,
  `blog_description` varchar(225) NOT NULL,
  `blog_lang` varchar(12) NOT NULL,
  `blog_encoding` varchar(12) NOT NULL,
  `total_entries` mediumint(8) NOT NULL DEFAULT '0',
  `total_comments` mediumint(8) NOT NULL DEFAULT '0',
  `total_trackbacks` mediumint(8) NOT NULL DEFAULT '0',
  `last_entry_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_comment_date` int(10) unsigned NOT NULL DEFAULT '0',
  `last_trackback_date` int(10) unsigned NOT NULL DEFAULT '0',
  `cat_group` varchar(255) NOT NULL,
  `status_group` int(4) unsigned NOT NULL,
  `deft_status` varchar(50) NOT NULL DEFAULT 'open',
  `field_group` int(4) unsigned NOT NULL,
  `search_excerpt` int(4) unsigned NOT NULL,
  `enable_trackbacks` char(1) NOT NULL DEFAULT 'n',
  `trackback_use_url_title` char(1) NOT NULL DEFAULT 'n',
  `trackback_max_hits` int(2) unsigned NOT NULL DEFAULT '5',
  `trackback_field` int(4) unsigned NOT NULL,
  `deft_category` varchar(60) NOT NULL,
  `deft_comments` char(1) NOT NULL DEFAULT 'y',
  `deft_trackbacks` char(1) NOT NULL DEFAULT 'y',
  `weblog_require_membership` char(1) NOT NULL DEFAULT 'y',
  `weblog_max_chars` int(5) unsigned NOT NULL,
  `weblog_html_formatting` char(4) NOT NULL DEFAULT 'all',
  `weblog_allow_img_urls` char(1) NOT NULL DEFAULT 'y',
  `weblog_auto_link_urls` char(1) NOT NULL DEFAULT 'y',
  `weblog_notify` char(1) NOT NULL DEFAULT 'n',
  `weblog_notify_emails` varchar(255) NOT NULL,
  `comment_url` varchar(80) NOT NULL,
  `comment_system_enabled` char(1) NOT NULL DEFAULT 'y',
  `comment_require_membership` char(1) NOT NULL DEFAULT 'n',
  `comment_use_captcha` char(1) NOT NULL DEFAULT 'n',
  `comment_moderate` char(1) NOT NULL DEFAULT 'n',
  `comment_max_chars` int(5) unsigned NOT NULL,
  `comment_timelock` int(5) unsigned NOT NULL DEFAULT '0',
  `comment_require_email` char(1) NOT NULL DEFAULT 'y',
  `comment_text_formatting` char(5) NOT NULL DEFAULT 'xhtml',
  `comment_html_formatting` char(4) NOT NULL DEFAULT 'safe',
  `comment_allow_img_urls` char(1) NOT NULL DEFAULT 'n',
  `comment_auto_link_urls` char(1) NOT NULL DEFAULT 'y',
  `comment_notify` char(1) NOT NULL DEFAULT 'n',
  `comment_notify_authors` char(1) NOT NULL DEFAULT 'n',
  `comment_notify_emails` varchar(255) NOT NULL,
  `comment_expiration` int(4) unsigned NOT NULL DEFAULT '0',
  `search_results_url` varchar(80) NOT NULL,
  `tb_return_url` varchar(80) NOT NULL,
  `ping_return_url` varchar(80) NOT NULL,
  `show_url_title` char(1) NOT NULL DEFAULT 'y',
  `trackback_system_enabled` char(1) NOT NULL DEFAULT 'n',
  `show_trackback_field` char(1) NOT NULL DEFAULT 'y',
  `trackback_use_captcha` char(1) NOT NULL DEFAULT 'n',
  `show_ping_cluster` char(1) NOT NULL DEFAULT 'y',
  `show_options_cluster` char(1) NOT NULL DEFAULT 'y',
  `show_button_cluster` char(1) NOT NULL DEFAULT 'y',
  `show_forum_cluster` char(1) NOT NULL DEFAULT 'y',
  `show_pages_cluster` char(1) NOT NULL DEFAULT 'y',
  `show_show_all_cluster` char(1) NOT NULL DEFAULT 'y',
  `show_author_menu` char(1) NOT NULL DEFAULT 'y',
  `show_status_menu` char(1) NOT NULL DEFAULT 'y',
  `show_categories_menu` char(1) NOT NULL DEFAULT 'y',
  `show_date_menu` char(1) NOT NULL DEFAULT 'y',
  `rss_url` varchar(80) NOT NULL,
  `enable_versioning` char(1) NOT NULL DEFAULT 'n',
  `enable_qucksave_versioning` char(1) NOT NULL DEFAULT 'n',
  `max_revisions` smallint(4) unsigned NOT NULL DEFAULT '10',
  `default_entry_title` varchar(100) NOT NULL,
  `url_title_prefix` varchar(80) NOT NULL,
  `live_look_template` int(10) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`weblog_id`),
  KEY `cat_group` (`cat_group`),
  KEY `status_group` (`status_group`),
  KEY `field_group` (`field_group`),
  KEY `is_user_blog` (`is_user_blog`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblogs` WRITE;
/*!40000 ALTER TABLE `exp_weblogs` DISABLE KEYS */;
INSERT INTO `exp_weblogs` (`weblog_id`,`site_id`,`is_user_blog`,`blog_name`,`blog_title`,`blog_url`,`blog_description`,`blog_lang`,`blog_encoding`,`total_entries`,`total_comments`,`total_trackbacks`,`last_entry_date`,`last_comment_date`,`last_trackback_date`,`cat_group`,`status_group`,`deft_status`,`field_group`,`search_excerpt`,`enable_trackbacks`,`trackback_use_url_title`,`trackback_max_hits`,`trackback_field`,`deft_category`,`deft_comments`,`deft_trackbacks`,`weblog_require_membership`,`weblog_max_chars`,`weblog_html_formatting`,`weblog_allow_img_urls`,`weblog_auto_link_urls`,`weblog_notify`,`weblog_notify_emails`,`comment_url`,`comment_system_enabled`,`comment_require_membership`,`comment_use_captcha`,`comment_moderate`,`comment_max_chars`,`comment_timelock`,`comment_require_email`,`comment_text_formatting`,`comment_html_formatting`,`comment_allow_img_urls`,`comment_auto_link_urls`,`comment_notify`,`comment_notify_authors`,`comment_notify_emails`,`comment_expiration`,`search_results_url`,`tb_return_url`,`ping_return_url`,`show_url_title`,`trackback_system_enabled`,`show_trackback_field`,`trackback_use_captcha`,`show_ping_cluster`,`show_options_cluster`,`show_button_cluster`,`show_forum_cluster`,`show_pages_cluster`,`show_show_all_cluster`,`show_author_menu`,`show_status_menu`,`show_categories_menu`,`show_date_menu`,`rss_url`,`enable_versioning`,`enable_qucksave_versioning`,`max_revisions`,`default_entry_title`,`url_title_prefix`,`live_look_template`)
VALUES
	(17,1,'n','events','Events','/events/','','en','utf-8',1,0,0,1296655657,0,0,'',1,'open',16,0,'n','n',5,71,'','y','n','y',0,'all','y','n','n','','/events/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',0),
	(18,1,'n','gallery','Gallery','/gallery/','','en','utf-8',1,0,0,1296646788,0,0,'',1,'open',17,0,'n','n',5,75,'','y','n','y',0,'all','y','n','n','','/gallery/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',0),
	(19,1,'n','journal_videos','Journal: Videos','/journal/','','en','utf-8',1,0,0,1296656268,0,0,'',1,'open',19,79,'n','n',5,78,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(20,1,'n','journal_audio','Journal: Audio','/journal/','','en','utf-8',1,0,0,1296642998,0,0,'',1,'open',18,77,'n','n',5,76,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(21,1,'n','journal_photos','Journal: Photos','/journal/','','en','utf-8',1,0,0,1296642773,0,0,'',1,'open',20,82,'n','n',5,81,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(22,1,'n','journal_notes','Journal: Notes','/journal/','','en','utf-8',1,0,0,1296654283,0,0,'',1,'open',21,83,'n','n',5,83,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(23,1,'n','pages','Site pages (privacy policy, etc)','/pages/','','en','utf-8',1,0,0,1296658583,0,0,'',1,'open',22,77,'n','n',5,76,'','y','n','y',0,'all','y','n','n','','/pages/','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','n','','n','n',10,'','',111);

/*!40000 ALTER TABLE `exp_weblogs` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
