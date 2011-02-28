# Sequel Pro dump
# Version 2492
# http://code.google.com/p/sequel-pro
#
# Host: 127.0.0.1 (MySQL 5.1.41-3ubuntu12.8)
# Database: simoncampbell_music
# Generation Time: 2011-02-28 12:05:08 -0600
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
) ENGINE=MyISAM AUTO_INCREMENT=1041 DEFAULT CHARSET=latin1;

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
	(1039,'Cartthrob','payment_return'),
	(1038,'Cartthrob','_multi_add_to_cart_form_submit'),
	(1036,'Cartthrob','_ajax_action'),
	(1037,'Cartthrob','_jquery_plugin_action'),
	(1035,'Cartthrob','_update_cart_submit'),
	(1034,'Cartthrob','_save_customer_info_submit'),
	(1032,'Cartthrob','_update_item_submit'),
	(1033,'Cartthrob','_delete_from_cart_submit'),
	(1031,'Cartthrob','_coupon_code_form_submit'),
	(1013,'Freeform','insert_new_entry'),
	(1014,'Freeform','retrieve_entries'),
	(1015,'Freeform_CP','delete_freeform_notification'),
	(1016,'Freeform','delete_freeform_notification'),
	(1030,'Cartthrob','_add_to_cart_form_submit'),
	(1029,'Cartthrob','_checkout'),
	(1040,'Cartthrob','_download_file_form_submit');

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
) ENGINE=MyISAM AUTO_INCREMENT=377 DEFAULT CHARSET=latin1;

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
	(301,1,18,'garrett.winder','75.89.69.119',1296674132,'Logged in'),
	(302,1,1,'jamiepittock','88.97.41.226',1296727040,'Field group Deleted:&nbsp;&nbsp;Journal'),
	(303,1,7,'gregwood','88.97.41.224',1296731203,'Logged in'),
	(304,1,1,'jamiepittock','88.97.41.226',1296731703,'Logged in'),
	(305,1,1,'jamiepittock','88.97.41.226',1296746279,'Logged in'),
	(306,1,18,'garrett.winder','173.185.20.98',1296747750,'Logged in'),
	(307,1,1,'jamiepittock','88.97.41.226',1296749177,'Logged out'),
	(308,1,19,'simoncampbell','88.97.41.226',1296749187,'Logged in'),
	(309,1,19,'simoncampbell','88.97.41.226',1296750409,'Logged in'),
	(310,1,19,'simoncampbell','88.97.41.226',1296750473,'Logged out'),
	(311,1,1,'jamiepittock','88.97.41.226',1296750480,'Logged in'),
	(312,1,7,'gregwood','82.10.223.13',1296751120,'Logged in'),
	(313,1,7,'gregwood','88.97.41.224',1296753162,'Logged in'),
	(314,1,18,'garrett.winder','173.185.20.98',1296764576,'Logged in'),
	(315,1,19,'simoncampbell','92.39.196.149',1296813824,'Logged in'),
	(316,1,7,'gregwood','88.97.41.224',1296820036,'Logged in'),
	(317,1,18,'garrett.winder','173.185.20.98',1296830005,'Logged in'),
	(318,1,18,'garrett.winder','173.185.20.98',1296830706,'Logged out'),
	(319,1,18,'garrett.winder','173.185.20.98',1296830794,'Logged in'),
	(320,1,18,'garrett.winder','173.185.20.98',1296831045,'Logged out'),
	(321,1,18,'garrett.winder','173.185.20.98',1296831074,'Logged in'),
	(322,1,18,'garrett.winder','173.185.20.98',1296831184,'Logged out'),
	(323,1,19,'simoncampbell','92.39.196.149',1296846088,'Logged in'),
	(324,1,18,'garrett.winder','173.185.20.98',1297099703,'Logged in'),
	(325,1,19,'simoncampbell','92.39.196.149',1297155895,'Logged in'),
	(326,1,19,'simoncampbell','92.39.196.149',1297266718,'Logged in'),
	(327,1,18,'garrett.winder','71.30.180.219',1297352021,'Logged in'),
	(328,1,18,'garrett.winder','71.30.180.219',1297352368,'Field Group Created:&nbsp;&nbsp;Products - T-Shirts'),
	(329,1,18,'garrett.winder','71.30.180.219',1297354024,'Channel Created:&nbsp;&nbsp;Products: T-shirts'),
	(330,1,1,'Member Utilities','127.0.0.1',1297354489,'User garrett.winder has updated their profile'),
	(331,1,1,'Member Utilities','127.0.0.1',1297354521,'User garrett.winder has updated their profile'),
	(332,1,1,'Member Utilities','127.0.0.1',1297354546,'User garrett.winder has updated their profile'),
	(333,1,1,'Member Utilities','127.0.0.1',1297355086,'User garrett.winder has updated their profile'),
	(334,1,18,'garrett.winder','71.30.180.219',1297355152,'Field Group Created:&nbsp;&nbsp;Products - Music'),
	(335,1,1,'Member Utilities','127.0.0.1',1297356421,'User garrett.winder has updated their profile'),
	(336,1,18,'garrett.winder','71.30.180.219',1297356486,'Channel Created:&nbsp;&nbsp;Products: Music'),
	(337,1,18,'garrett.winder','71.30.180.219',1297356559,'Field Group Created:&nbsp;&nbsp;Products - Posters'),
	(338,1,18,'garrett.winder','71.30.180.219',1297357178,'Channel Created:&nbsp;&nbsp;Products: Posters'),
	(339,1,18,'garrett.winder','71.30.180.219',1297358298,'Logged in'),
	(340,1,18,'garrett.winder','71.30.180.219',1297390693,'Logged in'),
	(341,1,18,'garrett.winder','88.97.41.224',1297424903,'Logged in'),
	(342,1,18,'garrett.winder','71.30.180.219',1297439914,'Logged in'),
	(343,1,18,'garrett.winder','71.30.180.219',1297443134,'Status Group Created:&nbsp;&nbsp;Orders Status Group'),
	(344,1,18,'garrett.winder','71.30.180.219',1297445265,'Logged in'),
	(345,1,18,'garrett.winder','71.30.180.219',1297445606,'Logged in'),
	(346,1,18,'garrett.winder','71.30.180.219',1297445997,'Logged in'),
	(347,1,18,'garrett.winder','71.30.177.29',1297808271,'Logged in'),
	(348,1,18,'garrett.winder','71.30.177.29',1297808306,'Logged in'),
	(349,1,1,'jamiepittock','88.97.41.226',1297858264,'Logged in'),
	(350,1,1,'jamiepittock','88.97.41.226',1297858279,'Logged in'),
	(351,1,19,'simoncampbell','109.249.230.96',1297865604,'Logged in'),
	(352,1,1,'jamiepittock','88.97.41.226',1297869517,'Logged in'),
	(353,1,1,'jamiepittock','88.97.41.226',1297938972,'Logged in'),
	(354,1,1,'jamiepittock','88.97.41.226',1297938993,'Field Group Created:&nbsp;&nbsp;Homepage features'),
	(355,1,1,'Member Utilities','127.0.0.1',1297939423,'User jamiepittock has updated their profile'),
	(356,1,1,'jamiepittock','88.97.41.226',1297939669,'Channel Created:&nbsp;&nbsp;Homepage features'),
	(357,1,1,'jamiepittock','88.97.41.226',1297944707,'Logged in'),
	(358,1,19,'simoncampbell','92.39.196.149',1298023017,'Logged in'),
	(359,1,19,'simoncampbell','92.39.196.149',1298023018,'Logged in'),
	(360,1,1,'jamiepittock','88.97.41.226',1298376531,'Logged in'),
	(361,1,1,'jamiepittock','88.97.41.226',1298388489,'Logged in'),
	(362,1,1,'jamiepittock','88.97.41.226',1298388497,'Logged in'),
	(363,1,19,'simoncampbell','92.39.196.149',1298389588,'Logged in'),
	(364,1,19,'simoncampbell','92.39.196.149',1298394432,'Logged in'),
	(365,1,7,'gregwood','88.97.41.224',1298466611,'Logged in'),
	(366,1,1,'jamiepittock','88.97.41.226',1298472678,'Logged in'),
	(367,1,1,'jamiepittock','88.97.41.226',1298472690,'Custom Field Deleted:&nbsp;&nbsp;Overlay position'),
	(368,1,18,'garrett.winder','64.134.144.223',1298497609,'Logged in'),
	(369,1,7,'gregwood','88.97.41.224',1298541261,'Logged in'),
	(370,1,19,'simoncampbell','92.39.196.149',1298545172,'Logged in'),
	(371,1,18,'garrett.winder','98.20.79.244',1298565725,'Logged in'),
	(372,1,7,'gregwood','88.97.41.224',1298635393,'Logged in'),
	(373,1,7,'gregwood','88.97.41.224',1298646637,'Member Group Updated:&nbsp;&nbsp;Admin'),
	(374,1,19,'simoncampbell','92.39.196.149',1298647174,'Logged in'),
	(375,1,7,'gregwood','88.97.41.224',1298900906,'Logged in'),
	(376,1,18,'garrett.winder','98.20.79.244',1298914874,'Logged in');

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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=latin1;

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
	(20,23,0,0,0),
	(21,24,0,0,0),
	(22,27,0,0,0),
	(23,28,0,0,0),
	(24,29,0,0,0);

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
	(71,'Lg_better_meta','publish_form_new_tabs','publish_form_new_tabs','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(72,'Lg_better_meta','publish_form_new_tabs_block','publish_form_new_tabs_block','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(73,'Lg_better_meta','publish_form_start','publish_form_start','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(74,'Lg_better_meta','submit_new_entry_end','submit_new_entry_end','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(75,'Lg_better_meta','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(76,'Lg_better_meta','lg_addon_update_register_source','lg_addon_update_register_source','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
	(77,'Lg_better_meta','lg_addon_update_register_addon','lg_addon_update_register_addon','a:1:{i:1;a:19:{s:7:\"enabled\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"6\";i:1;s:1:\"1\";}s:7:\"weblogs\";a:12:{i:17;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:18;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"n\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:20;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:22;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:21;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:19;a:14:{s:8:\"show_tab\";s:1:\"y\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"n\";s:11:\"show_author\";s:1:\"n\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"n\";s:16:\"show_robots_meta\";s:1:\"n\";s:17:\"show_sitemap_meta\";s:1:\"n\";s:13:\"show_geo_meta\";s:1:\"n\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:27;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:23;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:25;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:26;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:24;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}i:28;a:14:{s:8:\"show_tab\";s:1:\"n\";s:10:\"show_title\";s:1:\"y\";s:16:\"show_description\";s:1:\"y\";s:13:\"show_keywords\";s:1:\"y\";s:11:\"show_author\";s:1:\"y\";s:14:\"show_publisher\";s:1:\"y\";s:11:\"show_rights\";s:1:\"y\";s:18:\"show_canonical_url\";s:1:\"y\";s:16:\"show_robots_meta\";s:1:\"y\";s:17:\"show_sitemap_meta\";s:1:\"y\";s:13:\"show_geo_meta\";s:1:\"y\";s:18:\"include_in_sitemap\";s:1:\"y\";s:16:\"change_frequency\";s:6:\"Weekly\";s:8:\"priority\";s:3:\"0.5\";}}s:5:\"title\";s:20:\"Simon Campbell Music\";s:7:\"divider\";s:1:\"1\";s:11:\"description\";s:126:\"Simon Campbell is a singer, songwriter and session guitar player. His first solo album, ThirtySix is released on 26 March 2011\";s:8:\"keywords\";s:0:\"\";s:6:\"author\";s:14:\"Simon Campbell\";s:9:\"publisher\";s:0:\"\";s:6:\"rights\";s:0:\"\";s:6:\"region\";s:0:\"\";s:9:\"placename\";s:0:\"\";s:8:\"latitude\";s:0:\"\";s:9:\"longitude\";s:0:\"\";s:12:\"robots_index\";s:1:\"y\";s:14:\"robots_archive\";s:1:\"y\";s:13:\"robots_follow\";s:1:\"y\";s:8:\"template\";s:1266:\"<title>{title}</title>\n\n<meta charset=\\\"UTF-8\\\" />\n<meta name=\\\"description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"author\\\" content=\\\"{author}\\\" />\n<meta name=\\\"Copyright\\\" content=\\\"Simon Campbell 2011\\\" />\n<meta name=\\\"robots\\\" content=\\\"{robots}\\\" />\n\n{if canonical_url}<link rel=\\\"canonical\\\" href=\\\"{canonical_url}\\\" />{/if}\n\n<link rel=\\\"schema.DC\\\" href=\\\"http://purl.org/dc/elements/1.1/\\\" />\n<link rel=\\\"schema.DCTERMS\\\" href=\\\"http://purl.org/dc/terms/\\\" />\n<meta name=\\\"DC.title\\\" content=\\\"{title}\\\" />\n<meta name=\\\"DC.creator\\\" content=\\\"{author}\\\" />\n<meta name=\\\"DC.subject\\\" content=\\\"{keywords}\\\" />\n<meta name=\\\"DC.description\\\" content=\\\"{description}\\\" />\n<meta name=\\\"DC.publisher\\\" content=\\\"{publisher}\\\" />\n<meta name=\\\"DC.date.created\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_created}\\\" />\n<meta name=\\\"DC.date.modified\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_modified}\\\" />\n<meta name=\\\"DC.date.valid\\\" scheme=\\\"DCTERMS.W3CDTF\\\" content=\\\"{date_valid}\\\" />\n<meta name=\\\"DC.type\\\" scheme=\\\"DCTERMS.DCMIType\\\" content=\\\"Text\\\" />\n<meta name=\\\"DC.rights\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{rights}\\\" />\n<meta name=\\\"DC.format\\\" content=\\\"text/html\\\" />\n<meta name=\\\"DC.identifier\\\" scheme=\\\"DCTERMS.URI\\\" content=\\\"{identifier}\\\" />\";s:17:\"check_for_updates\";s:1:\"n\";}}',10,'1.9.1','y'),
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
	(117,'mx_title_control','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:14:{s:16:\"title_english_17\";s:11:\"Event title\";s:16:\"title_english_18\";s:16:\"Gallery set name\";s:16:\"title_english_29\";s:9:\"Tab label\";s:16:\"title_english_20\";s:0:\"\";s:16:\"title_english_22\";s:0:\"\";s:16:\"title_english_21\";s:0:\"\";s:16:\"title_english_19\";s:0:\"\";s:16:\"title_english_27\";s:0:\"\";s:16:\"title_english_25\";s:0:\"\";s:16:\"title_english_26\";s:0:\"\";s:16:\"title_english_24\";s:0:\"\";s:16:\"title_english_28\";s:0:\"\";s:16:\"title_english_23\";s:12:\"Page heading\";s:13:\"multilanguage\";s:1:\"n\";}}',10,'0.0.3','y'),
	(118,'Lg_live_look_ext','publish_form_start','publish_form_start','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(119,'Lg_live_look_ext','publish_form_new_tabs','publish_form_new_tabs','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(120,'Lg_live_look_ext','publish_form_new_tabs_block','publish_form_new_tabs_block','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(121,'Lg_live_look_ext','edit_entries_additional_tableheader','edit_entries_additional_tableheader','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(122,'Lg_live_look_ext','edit_entries_additional_celldata','edit_entries_additional_celldata','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(123,'Lg_live_look_ext','lg_addon_update_register_source','lg_addon_update_register_source','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(124,'Lg_live_look_ext','lg_addon_update_register_addon','lg_addon_update_register_addon','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(125,'Lg_live_look_ext','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:9:{s:6:\"enable\";s:1:\"y\";s:11:\"show_donate\";s:1:\"y\";s:11:\"show_promos\";s:1:\"y\";s:21:\"allowed_member_groups\";a:2:{i:0;s:1:\"1\";i:1;s:1:\"6\";}s:7:\"weblogs\";a:11:{i:3;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/banner/{entry_id}/\";}i:4;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:5;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/issue/{entry_id}/\";}i:7;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}i:8;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:9;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:10;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:28:\"/_preview/stream/{entry_id}/\";}i:11;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:35:\"/_preview/press-release/{entry_id}/\";}i:12;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:37:\"/_preview/e-communication/{entry_id}/\";}i:13;a:4:{s:11:\"display_tab\";s:1:\"y\";s:12:\"display_link\";s:1:\"y\";s:15:\"disable_preview\";s:1:\"y\";s:14:\"live_look_path\";s:27:\"/_preview/about/{entry_id}/\";}i:14;a:4:{s:11:\"display_tab\";s:1:\"n\";s:12:\"display_link\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:14:\"live_look_path\";s:12:\"/{entry_id}/\";}}s:17:\"check_for_updates\";s:1:\"n\";s:15:\"disable_preview\";s:1:\"n\";s:23:\"allowed_member_groups_0\";s:1:\"1\";s:23:\"allowed_member_groups_1\";s:1:\"6\";}}',10,'1.1.0','y'),
	(127,'Cartthrob_ext','member_member_logout','member_member_logout','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(128,'Cartthrob_ext','submit_new_entry_start','submit_new_entry_start','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(129,'Cartthrob_ext','show_full_control_panel_end','show_full_control_panel_end','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(130,'Cartthrob_ext','publish_admin_edit_field_type_pulldown','publish_admin_edit_field_type_pulldown','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(131,'Cartthrob_ext','publish_form_field_unique','publish_form_field_unique','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(132,'Cartthrob_ext','publish_admin_edit_field_format','publish_admin_edit_field_format','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(133,'Cartthrob_ext','publish_admin_edit_field_js','publish_admin_edit_field_js','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y'),
	(134,'Cartthrob_ext','weblog_entries_tagdata','weblog_entries_tagdata','a:1:{i:1;a:160:{s:14:\"license_number\";s:36:\"cf425d05-badb-91c0-7f67-68b2e39f05ee\";s:9:\"logged_in\";s:1:\"1\";s:17:\"default_member_id\";s:0:\"\";s:14:\"session_expire\";s:5:\"10800\";s:20:\"clear_cart_on_logout\";s:1:\"1\";s:25:\"allow_empty_cart_checkout\";s:1:\"0\";s:23:\"allow_gateway_selection\";s:1:\"0\";s:24:\"encode_gateway_selection\";s:1:\"1\";s:17:\"global_item_limit\";s:1:\"0\";s:19:\"modulus_10_checking\";s:1:\"0\";s:14:\"enable_logging\";s:1:\"0\";s:31:\"number_format_defaults_decimals\";s:1:\"2\";s:32:\"number_format_defaults_dec_point\";s:1:\".\";s:36:\"number_format_defaults_thousands_sep\";s:1:\",\";s:29:\"number_format_defaults_prefix\";s:2:\"Â£\";s:36:\"number_format_defaults_currency_code\";s:3:\"GBP\";s:16:\"rounding_default\";s:8:\"standard\";s:15:\"product_weblogs\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}s:21:\"product_weblog_fields\";a:3:{i:24;a:5:{s:5:\"price\";s:2:\"91\";s:8:\"shipping\";s:2:\"92\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}i:25;a:6:{s:5:\"price\";s:0:\"\";s:8:\"shipping\";s:0:\"\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:15:\"price_modifiers\";a:1:{i:0;s:2:\"97\";}s:12:\"global_price\";s:0:\"\";}i:26;a:5:{s:5:\"price\";s:3:\"101\";s:8:\"shipping\";s:3:\"102\";s:6:\"weight\";s:0:\"\";s:9:\"inventory\";s:0:\"\";s:12:\"global_price\";s:0:\"\";}}s:29:\"allow_products_more_than_once\";s:1:\"0\";s:31:\"product_split_items_by_quantity\";s:1:\"0\";s:13:\"orders_weblog\";s:2:\"27\";s:11:\"save_orders\";s:1:\"1\";s:31:\"orders_sequential_order_numbers\";s:1:\"1\";s:19:\"orders_title_prefix\";s:7:\"Order #\";s:19:\"orders_title_suffix\";s:0:\"\";s:23:\"orders_url_title_prefix\";s:6:\"order_\";s:23:\"orders_url_title_suffix\";s:0:\"\";s:27:\"orders_convert_country_code\";s:1:\"1\";s:21:\"orders_default_status\";s:4:\"Paid\";s:24:\"orders_processing_status\";s:10:\"Processing\";s:20:\"orders_failed_status\";s:6:\"Failed\";s:22:\"orders_declined_status\";s:8:\"Declined\";s:18:\"orders_items_field\";s:3:\"126\";s:21:\"orders_subtotal_field\";s:3:\"122\";s:16:\"orders_tax_field\";s:3:\"123\";s:21:\"orders_shipping_field\";s:3:\"124\";s:21:\"orders_discount_field\";s:0:\"\";s:18:\"orders_total_field\";s:3:\"125\";s:21:\"orders_transaction_id\";s:3:\"117\";s:23:\"orders_last_four_digits\";s:3:\"128\";s:19:\"orders_coupon_codes\";s:3:\"127\";s:22:\"orders_shipping_option\";s:3:\"106\";s:26:\"orders_error_message_field\";s:3:\"129\";s:21:\"orders_language_field\";s:0:\"\";s:20:\"orders_customer_name\";s:0:\"\";s:21:\"orders_customer_email\";s:3:\"118\";s:26:\"orders_customer_ip_address\";s:0:\"\";s:21:\"orders_customer_phone\";s:3:\"119\";s:27:\"orders_full_billing_address\";s:0:\"\";s:25:\"orders_billing_first_name\";s:3:\"116\";s:24:\"orders_billing_last_name\";s:3:\"115\";s:22:\"orders_billing_company\";s:0:\"\";s:22:\"orders_billing_address\";s:3:\"112\";s:23:\"orders_billing_address2\";s:3:\"114\";s:19:\"orders_billing_city\";s:3:\"113\";s:20:\"orders_billing_state\";s:3:\"111\";s:18:\"orders_billing_zip\";s:3:\"108\";s:22:\"orders_billing_country\";s:3:\"135\";s:19:\"orders_country_code\";s:3:\"136\";s:28:\"orders_full_shipping_address\";s:0:\"\";s:26:\"orders_shipping_first_name\";s:3:\"109\";s:25:\"orders_shipping_last_name\";s:3:\"110\";s:23:\"orders_shipping_company\";s:0:\"\";s:23:\"orders_shipping_address\";s:3:\"104\";s:24:\"orders_shipping_address2\";s:3:\"105\";s:20:\"orders_shipping_city\";s:3:\"107\";s:21:\"orders_shipping_state\";s:3:\"120\";s:19:\"orders_shipping_zip\";s:3:\"121\";s:23:\"orders_shipping_country\";s:3:\"137\";s:28:\"orders_shipping_country_code\";s:3:\"138\";s:20:\"save_purchased_items\";s:1:\"0\";s:22:\"purchased_items_weblog\";s:2:\"28\";s:30:\"purchased_items_default_status\";s:0:\"\";s:33:\"purchased_items_processing_status\";s:0:\"\";s:29:\"purchased_items_failed_status\";s:0:\"\";s:31:\"purchased_items_declined_status\";s:0:\"\";s:28:\"purchased_items_title_prefix\";s:0:\"\";s:24:\"purchased_items_id_field\";s:3:\"130\";s:30:\"purchased_items_quantity_field\";s:3:\"131\";s:27:\"purchased_items_price_field\";s:3:\"132\";s:30:\"purchased_items_order_id_field\";s:3:\"133\";s:36:\"purchased_items_license_number_field\";s:0:\"\";s:35:\"purchased_items_license_number_type\";s:4:\"uuid\";s:16:\"save_member_data\";s:1:\"0\";s:23:\"member_first_name_field\";s:0:\"\";s:22:\"member_last_name_field\";s:0:\"\";s:20:\"member_address_field\";s:0:\"\";s:21:\"member_address2_field\";s:0:\"\";s:17:\"member_city_field\";s:0:\"\";s:18:\"member_state_field\";s:0:\"\";s:16:\"member_zip_field\";s:0:\"\";s:20:\"member_country_field\";s:0:\"\";s:25:\"member_country_code_field\";s:0:\"\";s:20:\"member_company_field\";s:0:\"\";s:18:\"member_phone_field\";s:0:\"\";s:26:\"member_email_address_field\";s:0:\"\";s:29:\"member_use_billing_info_field\";s:0:\"\";s:32:\"member_shipping_first_name_field\";s:0:\"\";s:31:\"member_shipping_last_name_field\";s:0:\"\";s:29:\"member_shipping_address_field\";s:0:\"\";s:30:\"member_shipping_address2_field\";s:0:\"\";s:26:\"member_shipping_city_field\";s:0:\"\";s:27:\"member_shipping_state_field\";s:0:\"\";s:25:\"member_shipping_zip_field\";s:0:\"\";s:29:\"member_shipping_country_field\";s:0:\"\";s:34:\"member_shipping_country_code_field\";s:0:\"\";s:29:\"member_shipping_company_field\";s:0:\"\";s:21:\"member_language_field\";s:0:\"\";s:28:\"member_shipping_option_field\";s:0:\"\";s:19:\"member_region_field\";s:0:\"\";s:15:\"shipping_plugin\";s:0:\"\";s:46:\"Cartthrob_by_location_price_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:49:\"Cartthrob_by_location_quantity_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:47:\"Cartthrob_by_location_weight_threshold_settings\";a:5:{s:4:\"mode\";s:4:\"rate\";s:13:\"free_shipping\";s:0:\"\";s:14:\"location_field\";s:21:\"shipping_country_code\";s:21:\"backup_location_field\";s:12:\"country_code\";s:10:\"thresholds\";a:1:{i:0;a:3:{s:8:\"location\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_by_price_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_quantity_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:40:\"Cartthrob_by_weight_global_rate_settings\";a:1:{s:4:\"rate\";s:0:\"\";}s:38:\"Cartthrob_by_weight_threshold_settings\";a:1:{s:10:\"thresholds\";a:1:{i:0;a:2:{s:4:\"rate\";s:0:\"\";s:9:\"threshold\";s:0:\"\";}}}s:37:\"Cartthrob_per_location_rates_settings\";a:5:{s:12:\"default_rate\";s:0:\"\";s:13:\"free_shipping\";s:0:\"\";s:12:\"default_type\";s:4:\"flat\";s:14:\"location_field\";s:7:\"billing\";s:5:\"rates\";a:1:{i:0;a:9:{s:4:\"rate\";s:0:\"\";s:4:\"type\";s:4:\"flat\";s:3:\"zip\";s:0:\"\";s:5:\"state\";s:0:\"\";s:7:\"country\";s:0:\"\";s:9:\"entry_ids\";s:0:\"\";s:7:\"cat_ids\";s:0:\"\";s:11:\"field_value\";s:0:\"\";s:8:\"field_id\";s:1:\"0\";}}}s:29:\"Cartthrob_flat_rates_settings\";a:1:{s:5:\"rates\";a:1:{i:0;a:4:{s:10:\"short_name\";s:0:\"\";s:5:\"title\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:10:\"free_price\";s:0:\"\";}}}s:36:\"Cartthrob_by_weight_ups_xml_settings\";a:28:{s:10:\"access_key\";s:0:\"\";s:8:\"username\";s:0:\"\";s:8:\"password\";s:0:\"\";s:14:\"shipper_number\";s:0:\"\";s:20:\"use_negotiated_rates\";s:1:\"0\";s:9:\"test_mode\";s:1:\"1\";s:11:\"length_code\";s:2:\"IN\";s:11:\"weight_code\";s:3:\"LBS\";s:10:\"product_id\";s:2:\"03\";s:10:\"rate_chart\";s:2:\"03\";s:9:\"container\";s:2:\"02\";s:19:\"origination_res_com\";s:1:\"1\";s:16:\"delivery_res_com\";s:1:\"1\";s:10:\"def_length\";s:2:\"15\";s:9:\"def_width\";s:2:\"15\";s:10:\"def_height\";s:2:\"15\";s:4:\"c_14\";s:1:\"n\";s:4:\"c_01\";s:1:\"y\";s:4:\"c_13\";s:1:\"n\";s:4:\"c_59\";s:1:\"y\";s:4:\"c_02\";s:1:\"n\";s:4:\"c_12\";s:1:\"y\";s:4:\"c_03\";s:1:\"y\";s:4:\"c_11\";s:1:\"n\";s:4:\"c_07\";s:1:\"n\";s:4:\"c_54\";s:1:\"n\";s:4:\"c_08\";s:1:\"n\";s:4:\"c_65\";s:1:\"n\";}s:12:\"tax_settings\";a:1:{i:0;a:4:{s:4:\"name\";s:0:\"\";s:4:\"rate\";s:0:\"\";s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";}}s:16:\"default_location\";a:7:{s:5:\"state\";s:0:\"\";s:3:\"zip\";s:0:\"\";s:12:\"country_code\";s:0:\"\";s:6:\"region\";s:0:\"\";s:14:\"shipping_state\";s:0:\"\";s:12:\"shipping_zip\";s:0:\"\";s:21:\"shipping_country_code\";s:0:\"\";}s:18:\"coupon_code_weblog\";s:0:\"\";s:17:\"coupon_code_field\";s:0:\"\";s:16:\"coupon_code_type\";s:0:\"\";s:15:\"discount_weblog\";s:0:\"\";s:13:\"discount_type\";s:0:\"\";s:10:\"send_email\";s:1:\"0\";s:11:\"admin_email\";s:0:\"\";s:29:\"email_admin_notification_from\";s:0:\"\";s:34:\"email_admin_notification_from_name\";s:0:\"\";s:32:\"email_admin_notification_subject\";s:0:\"\";s:34:\"email_admin_notification_plaintext\";s:1:\"0\";s:24:\"email_admin_notification\";s:0:\"\";s:23:\"send_confirmation_email\";s:1:\"0\";s:29:\"email_order_confirmation_from\";s:0:\"\";s:34:\"email_order_confirmation_from_name\";s:0:\"\";s:32:\"email_order_confirmation_subject\";s:0:\"\";s:34:\"email_order_confirmation_plaintext\";s:1:\"0\";s:24:\"email_order_confirmation\";s:0:\"\";s:15:\"payment_gateway\";s:0:\"\";s:23:\"Cartthrob_sage_settings\";a:3:{s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:23:\"Cartthrob_eway_settings\";a:4:{s:11:\"customer_id\";s:8:\"87654321\";s:14:\"payment_method\";s:9:\"REAL-TIME\";s:9:\"test_mode\";s:3:\"Yes\";s:23:\"gateway_fields_template\";s:0:\"\";}s:29:\"Cartthrob_paypal_pro_settings\";a:11:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:14:\"payment_action\";s:4:\"Sale\";s:9:\"test_mode\";s:4:\"live\";s:7:\"country\";s:2:\"us\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_realex_remote_settings\";a:3:{s:16:\"your_merchant_id\";s:0:\"\";s:11:\"your_secret\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_sage_us_settings\";a:6:{s:9:\"test_mode\";s:3:\"yes\";s:4:\"m_id\";s:0:\"\";s:5:\"m_key\";s:0:\"\";s:9:\"m_test_id\";s:0:\"\";s:10:\"m_test_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:38:\"Cartthrob_transaction_central_settings\";a:5:{s:11:\"merchant_id\";s:0:\"\";s:7:\"reg_key\";s:0:\"\";s:9:\"test_mode\";s:1:\"0\";s:10:\"charge_url\";s:60:\"https://webservices.primerchants.com/creditcard.asmx/CCSale?\";s:23:\"gateway_fields_template\";s:0:\"\";}s:30:\"Cartthrob_sage_server_settings\";a:4:{s:7:\"profile\";s:6:\"NORMAL\";s:4:\"mode\";s:4:\"test\";s:11:\"vendor_name\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_worldpay_redirect_settings\";a:3:{s:15:\"installation_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:23:\"gateway_fields_template\";s:0:\"\";}s:36:\"Cartthrob_beanstream_direct_settings\";a:2:{s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_anz_egate_settings\";a:3:{s:11:\"access_code\";s:0:\"\";s:11:\"merchant_id\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_paypal_pro_uk_settings\";a:9:{s:12:\"api_username\";s:0:\"\";s:12:\"api_password\";s:0:\"\";s:13:\"api_signature\";s:0:\"\";s:13:\"test_username\";s:0:\"\";s:13:\"test_password\";s:0:\"\";s:14:\"test_signature\";s:0:\"\";s:9:\"test_mode\";s:4:\"live\";s:11:\"api_version\";s:4:\"60.0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:32:\"Cartthrob_authorize_net_settings\";a:7:{s:9:\"api_login\";s:0:\"\";s:15:\"transaction_key\";s:0:\"\";s:14:\"email_customer\";s:2:\"no\";s:4:\"mode\";s:4:\"test\";s:13:\"dev_api_login\";s:0:\"\";s:19:\"dev_transaction_key\";s:0:\"\";s:23:\"gateway_fields_template\";s:0:\"\";}s:31:\"Cartthrob_dev_template_settings\";a:2:{s:16:\"settings_example\";s:7:\"Whatevs\";s:23:\"gateway_fields_template\";s:0:\"\";}s:28:\"Cartthrob_linkpoint_settings\";a:4:{s:12:\"store_number\";s:0:\"\";s:7:\"keyfile\";s:22:\"yourcert_file_name.pem\";s:9:\"test_mode\";s:4:\"test\";s:23:\"gateway_fields_template\";s:0:\"\";}s:35:\"Cartthrob_offline_payments_settings\";a:1:{s:23:\"gateway_fields_template\";s:0:\"\";}s:34:\"Cartthrob_paypal_standard_settings\";a:5:{s:9:\"paypal_id\";s:0:\"\";s:17:\"paypal_sandbox_id\";s:0:\"\";s:9:\"test_mode\";s:4:\"Live\";s:16:\"address_override\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}s:26:\"Cartthrob_quantum_settings\";a:4:{s:13:\"gateway_login\";s:0:\"\";s:12:\"restrict_key\";s:0:\"\";s:14:\"email_customer\";s:1:\"0\";s:23:\"gateway_fields_template\";s:0:\"\";}}}',10,'0.9457','y');

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
	(85,'none'),
	(86,'textile'),
	(86,'xhtml'),
	(86,'none'),
	(87,'textile'),
	(87,'xhtml'),
	(87,'none'),
	(88,'textile'),
	(88,'xhtml'),
	(88,'none'),
	(89,'textile'),
	(89,'xhtml'),
	(89,'none'),
	(90,'textile'),
	(90,'xhtml'),
	(90,'none'),
	(91,'textile'),
	(91,'xhtml'),
	(91,'none'),
	(92,'textile'),
	(92,'xhtml'),
	(92,'none'),
	(93,'textile'),
	(93,'xhtml'),
	(93,'none'),
	(94,'textile'),
	(94,'xhtml'),
	(94,'none'),
	(95,'textile'),
	(95,'xhtml'),
	(95,'none'),
	(96,'textile'),
	(96,'xhtml'),
	(96,'none'),
	(97,'textile'),
	(97,'xhtml'),
	(97,'none'),
	(98,'textile'),
	(98,'xhtml'),
	(98,'none'),
	(99,'textile'),
	(99,'xhtml'),
	(99,'none'),
	(100,'textile'),
	(100,'xhtml'),
	(100,'none'),
	(101,'textile'),
	(101,'xhtml'),
	(101,'none'),
	(102,'textile'),
	(102,'xhtml'),
	(102,'none'),
	(103,'textile'),
	(103,'xhtml'),
	(103,'none'),
	(135,'textile'),
	(135,'xhtml'),
	(135,'none'),
	(136,'textile'),
	(136,'xhtml'),
	(136,'none'),
	(137,'textile'),
	(137,'xhtml'),
	(137,'none'),
	(138,'textile'),
	(138,'xhtml'),
	(138,'none'),
	(139,'textile'),
	(139,'xhtml'),
	(139,'none'),
	(140,'textile'),
	(140,'xhtml'),
	(140,'none'),
	(141,'textile'),
	(141,'xhtml'),
	(141,'none'),
	(142,'textile'),
	(142,'xhtml'),
	(142,'none'),
	(143,'textile'),
	(143,'xhtml'),
	(143,'none'),
	(144,'textile'),
	(144,'xhtml'),
	(144,'none'),
	(145,'textile'),
	(145,'xhtml'),
	(145,'none'),
	(146,'textile'),
	(146,'xhtml'),
	(146,'none'),
	(151,'textile'),
	(151,'xhtml'),
	(151,'none'),
	(148,'textile'),
	(148,'xhtml'),
	(148,'none'),
	(149,'textile'),
	(149,'xhtml'),
	(149,'none'),
	(150,'textile'),
	(150,'xhtml'),
	(150,'none');

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
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_field_groups` WRITE;
/*!40000 ALTER TABLE `exp_field_groups` DISABLE KEYS */;
INSERT INTO `exp_field_groups` (`group_id`,`site_id`,`group_name`)
VALUES
	(16,1,'Events'),
	(17,1,'Gallery'),
	(18,1,'Journal - Audio'),
	(19,1,'Journal - Videos'),
	(20,1,'Journal - Photos'),
	(21,1,'Journal - Notes'),
	(22,1,'Site pages'),
	(23,1,'Products - T-Shirts'),
	(24,1,'Products - Music'),
	(25,1,'Products - Posters'),
	(26,1,'Orders'),
	(27,1,'Purchased Items'),
	(28,1,'Homepage features');

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_freeform_entries` WRITE;
/*!40000 ALTER TABLE `exp_freeform_entries` DISABLE KEYS */;
INSERT INTO `exp_freeform_entries` (`entry_id`,`group_id`,`weblog_id`,`author_id`,`ip_address`,`form_name`,`template`,`entry_date`,`edit_date`,`status`,`name`,`email`,`message`)
VALUES
	(1,1,0,1,'88.97.41.226','freeform_form','contact_form',1296663505,1296663505,'open','Jamie Pittock','jamie@erskinedesign.com','Just testing the contact form.'),
	(2,1,0,1,'88.97.41.226','freeform_form','contact_form',1296664721,1296664721,'open','Jamie Pittock','jamie@erskinedesign.com','Any underscores this time?'),
	(3,3,0,0,'82.10.223.13','freeform_form','contact_form',1296752125,1296752125,'open','Greg','hello@gregorywood.co.uk','Testing the form. Simon let me know if you receive this. Greg.');

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
) ENGINE=MyISAM AUTO_INCREMENT=334 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_freeform_params` WRITE;
/*!40000 ALTER TABLE `exp_freeform_params` DISABLE KEYS */;
INSERT INTO `exp_freeform_params` (`params_id`,`entry_date`,`data`)
VALUES
	(332,1298915013,'a:18:{s:15:\"require_captcha\";s:2:\"no\";s:9:\"form_name\";s:13:\"freeform_form\";s:10:\"require_ip\";s:0:\"\";s:11:\"ee_required\";s:18:\"name|email|message\";s:9:\"ee_notify\";s:22:\"mail@simoncampbell.com\";s:10:\"recipients\";s:1:\"n\";s:15:\"recipient_limit\";s:2:\"10\";s:17:\"static_recipients\";b:0;s:22:\"static_recipients_list\";a:0:{}s:18:\"recipient_template\";s:16:\"default_template\";s:13:\"discard_field\";s:0:\"\";s:15:\"send_attachment\";s:0:\"\";s:15:\"send_user_email\";s:3:\"yes\";s:20:\"send_user_attachment\";s:0:\"\";s:19:\"user_email_template\";s:17:\"contact_form_user\";s:8:\"template\";s:12:\"contact_form\";s:20:\"prevent_duplicate_on\";s:0:\"\";s:11:\"file_upload\";s:0:\"\";}'),
	(333,1298916266,'a:18:{s:15:\"require_captcha\";s:2:\"no\";s:9:\"form_name\";s:13:\"freeform_form\";s:10:\"require_ip\";s:0:\"\";s:11:\"ee_required\";s:18:\"name|email|message\";s:9:\"ee_notify\";s:22:\"mail@simoncampbell.com\";s:10:\"recipients\";s:1:\"n\";s:15:\"recipient_limit\";s:2:\"10\";s:17:\"static_recipients\";b:0;s:22:\"static_recipients_list\";a:0:{}s:18:\"recipient_template\";s:16:\"default_template\";s:13:\"discard_field\";s:0:\"\";s:15:\"send_attachment\";s:0:\"\";s:15:\"send_user_email\";s:3:\"yes\";s:20:\"send_user_attachment\";s:0:\"\";s:19:\"user_email_template\";s:17:\"contact_form_user\";s:8:\"template\";s:12:\"contact_form\";s:20:\"prevent_duplicate_on\";s:0:\"\";s:11:\"file_upload\";s:0:\"\";}'),
	(331,1298914405,'a:18:{s:15:\"require_captcha\";s:2:\"no\";s:9:\"form_name\";s:13:\"freeform_form\";s:10:\"require_ip\";s:0:\"\";s:11:\"ee_required\";s:18:\"name|email|message\";s:9:\"ee_notify\";s:22:\"mail@simoncampbell.com\";s:10:\"recipients\";s:1:\"n\";s:15:\"recipient_limit\";s:2:\"10\";s:17:\"static_recipients\";b:0;s:22:\"static_recipients_list\";a:0:{}s:18:\"recipient_template\";s:16:\"default_template\";s:13:\"discard_field\";s:0:\"\";s:15:\"send_attachment\";s:0:\"\";s:15:\"send_user_email\";s:3:\"yes\";s:20:\"send_user_attachment\";s:0:\"\";s:19:\"user_email_template\";s:17:\"contact_form_user\";s:8:\"template\";s:12:\"contact_form\";s:20:\"prevent_duplicate_on\";s:0:\"\";s:11:\"file_upload\";s:0:\"\";}');

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
) ENGINE=MyISAM AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_global_variables` WRITE;
/*!40000 ALTER TABLE `exp_global_variables` DISABLE KEYS */;
INSERT INTO `exp_global_variables` (`variable_id`,`site_id`,`variable_name`,`variable_data`,`user_blog_id`)
VALUES
	(2,1,'lv_services_google_analytics','<script type=\"text/javascript\">\n\n    var _gaq = _gaq || [];\n    _gaq.push([\'_setAccount\', \'UA-3386644-6\']);\n    _gaq.push([\'_trackPageview\']);\n\n    (function() {\n        var ga = document.createElement(\'script\'); ga.type = \'text/javascript\'; ga.async = true;\n        ga.src = (\'https:\' == document.location.protocol ? \'https://ssl\' : \'http://www\') + \'.google-analytics.com/ga.js\';\n        var s = document.getElementsByTagName(\'script\')[0]; s.parentNode.insertBefore(ga, s);\n    })();\n\n</script>',0),
	(14,1,'lv_services_google_analytics_toggle','On',0),
	(26,1,'lv_contact_aside','<p><strong>Simon would love to hear from you.</strong> If you&rsquo;d like to drop him a line, either use the form on this page or hit <span class=\"email\">mail at simoncampbell dot com</span>.</p>',0),
	(27,1,'lv_contact_form_thanks','<p><strong>Thanks for contacting us. If your message requires a response we&rsquo;ll be back to you very shortly.</strong></p>',0),
	(28,1,'lv_contact_newsletter_thanks','<p><strong>Thanks for subscribing to the Simon Campbell Music newsletter!</strong></p>\n<p>You&rsquo;ll soon be receiving updates about his musical adventures &ndash; and maybe some free goodies!</p>',0),
	(29,1,'lv_journal_homepage_limit','2',0),
	(30,1,'lv_services_facebook_url','http://www.facebook.com/SimonCampbellBand',0),
	(31,1,'lv_services_twitter_url','http://twitter.com/simoncampbell',0),
	(32,1,'lv_services_master_rss','http://feeds.feedburner.com/SimonCampbellMusic',0),
	(33,1,'lv_contact_presskit_pdf','/uploads/files/documents/Simon-Campbell-Press-Kit.pdf',0),
	(34,1,'lv_contact_presskit_text','<a href=\"/uploads/files/documents/Simon-Campbell-Press-Kit.pdf\">Media kit</a> <em>&mdash; media &amp; press info (5mb PDF)</em>',0),
	(35,1,'lv_featured_homepage','88|92|87|73',0),
	(36,1,'lv_comments_toggle','On',0),
	(37,1,'lv_contact_booking','<p>If you want to get in touch with Simon&rsquo;s record company for booking details, contact Suzy:</p>\n<address>\n<strong>Suzy Starlite</strong><br />\nSupertone Records<br />\n<a href=\"mailto:suzy@supertonerecords.com\">suzy@supertonerecords.com</a><br />\n+44 7624 245881<br />\n</address>',0),
	(38,1,'lv_featured_sidebar','73',0);

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
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=utf8;

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
	(30,1,41,8,'shale-gas-will-rock-the-world','','','',NULL,NULL,'','','','','','','','','','','','',0),
	(31,1,51,20,'bruce-is-the-bomb','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(32,1,52,21,'sdfgsdfg','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(33,1,53,22,'ok-simon-what-do-you-think','Simon Campbell British Blues Awards Nottingham Blues Society',NULL,'','Simon Campbell','Nottingham Blues Society',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(34,1,54,22,'rock-n-roll-is-back','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(35,1,55,21,'search-for-the-ultimate-tone-part-one','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(36,1,56,22,'search-for-the-ultimate-tone-part-one','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(37,1,57,22,'search-for-the-ultimate-tone-part-two','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(38,1,58,22,'search-for-the-ultimate-tone-part-three','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(39,1,59,22,'making-thirtysix-part-one','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(40,1,60,22,'making-thirtysix-part-two','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(41,1,61,22,'we-love-the-manx-independent','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(42,1,62,22,'tickets-on-sale-now','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(43,1,63,22,'new-session-for-truman-falls','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(44,1,64,22,'the-delta-sisters-confirm-gig','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(45,1,49,19,'making-the-album-thirtysix-edition-1','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(46,1,68,21,'more-musicians-confirmed-for-thirtysix-launch','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(47,1,69,22,'anna-goldsmith-band-plays-for-craigs-heartstrong-foundation','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(48,1,70,19,'making-the-album-thirtysix-edition-2','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(49,1,74,22,'best-radio-you-have-never-heard','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(50,1,75,22,'hobson-and-holtz-report','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(51,1,76,22,'tone-workshop','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(52,1,77,21,'sessions-with-david-tyrrell','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(53,1,78,19,'making-the-album-thirtysix-edition-3','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(54,1,79,22,'stu-peters-plays-thirtysix-on-manx-radio','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(55,1,81,22,'interview-with-bob-harrison-on-manx-radio','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(56,1,82,22,'sessions-with-david-tyrrell','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(57,1,83,22,'more-musicians-confirmed-for-thirtysix-launch','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(58,1,84,22,'christian-madden-king-kreosote-and-the-earlies-on-6music','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(59,1,85,21,'gentleman-prepare-to-tour','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(60,1,86,22,'gentleman-prepare-to-tour','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(61,1,89,22,'interview-with-ben-sowrey-at-3fm','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(62,1,90,22,'nominations-for-the-british-blues-awards-2011','Simon Campbell British Blues Awards Nottingham Blues Society',NULL,'Nominations are out for the British Blues Awards and will close on 31st March 2011. Why not nominate Simon Campbell in the singer and guitar category.','Suzy Starlite','Nottingham Blues Society',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(63,1,91,22,'thirtysix-t-shirts-have-arrived','',NULL,'','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0),
	(64,1,93,22,'raven-n-blues','Simon Campbell on the Raven \'n Blues show',NULL,'The Raven\'n\'Blues Podcast is is a weekly 60 minute show featuring the best in blues. Hot as Hell from the album ThirtySix will be played tonight.','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','','','','',0);

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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_low_variable_groups` WRITE;
/*!40000 ALTER TABLE `exp_low_variable_groups` DISABLE KEYS */;
INSERT INTO `exp_low_variable_groups` (`group_id`,`site_id`,`group_label`,`group_notes`,`group_order`)
VALUES
	(1,1,'Services','',0),
	(2,1,'Contact','Miscellaneous page content on the Contact page.',0),
	(3,1,'Journal','',0),
	(4,1,'Homepage','',0),
	(5,1,'Comments','',0),
	(6,1,'Featured','',0);

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
	(32,1,'Master RSS feed','','low_text_input','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(33,2,'Press kit PDF','','low_select_files','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:5:{s:7:\"folders\";a:1:{i:0;s:1:\"4\";}s:6:\"upload\";s:1:\"4\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";s:8:\"multiple\";s:0:\"\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(34,2,'Press kit text','','low_text_input','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(35,6,'Homepage featured content','Choose the 4 entries you want to promote on the homepage by dragging them to the right. They will be displayed in the order you select.','low_select_entries','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:4:{s:7:\"weblogs\";a:1:{i:0;s:2:\"29\";}s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:9:\"drag-list\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(36,5,'Turn Disqus on/off','','low_select','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:4:{s:7:\"options\";s:6:\"On\nOff\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";s:8:\"multiple\";s:0:\"\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(37,2,'Booking information','','low_textarea','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n'),
	(38,6,'Sidebar featured content','Choose the entry you want to display in the sidebar of internal pages,','low_select_entries','a:10:{s:12:\"low_checkbox\";a:1:{s:5:\"label\";s:0:\"\";}s:18:\"low_checkbox_group\";a:2:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";}s:15:\"low_radio_group\";a:1:{s:7:\"options\";s:0:\"\";}s:10:\"low_select\";a:3:{s:7:\"options\";s:0:\"\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:21:\"low_select_categories\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_entries\";a:4:{s:7:\"weblogs\";a:1:{i:0;s:2:\"29\";}s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";s:8:\"multiple\";s:0:\"\";}s:16:\"low_select_files\";a:3:{s:6:\"upload\";s:1:\"0\";s:9:\"separator\";s:7:\"newline\";s:15:\"multi_interface\";s:6:\"select\";}s:18:\"low_select_weblogs\";a:3:{s:8:\"multiple\";s:1:\"y\";s:9:\"separator\";s:4:\"pipe\";s:15:\"multi_interface\";s:6:\"select\";}s:14:\"low_text_input\";a:3:{s:9:\"maxlength\";s:0:\"\";s:4:\"size\";s:6:\"medium\";s:7:\"pattern\";s:0:\"\";}s:12:\"low_textarea\";a:1:{s:4:\"rows\";s:1:\"3\";}}',0,'y','n');

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
) ENGINE=MyISAM AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

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
	(26,1,NULL,'ffm_images_credit','Image credit','Example: 2010 Phil Keen','text','n','n',2,'33%','YToxOntzOjQ6Im1heGwiO3M6MjoiNDAiO30='),
	(27,1,NULL,'ffm_sizes_short','Short Name','','ff_select','n','n',0,'50%','YToxOntzOjc6Im9wdGlvbnMiO2E6Njp7czoyNToiLS0tIENob29zZSBzaG9ydCBuYW1lIC0tLSI7czoyNToiLS0tIENob29zZSBzaG9ydCBuYW1lIC0tLSI7czozOiJYWEwiO3M6MzoiWFhMIjtzOjI6IlhMIjtzOjI6IlhMIjtzOjE6IkwiO3M6MToiTCI7czoxOiJNIjtzOjE6Ik0iO3M6MToiUyI7czoxOiJTIjt9fQ=='),
	(28,1,NULL,'ffm_sizes_full','Full Name','Make sure it matches the short name: M = Medium, etc.','ff_select','n','n',1,'50%','YToxOntzOjc6Im9wdGlvbnMiO2E6Njp7czoyNDoiLS0tIENob29zZSBmdWxsIG5hbWUgLS0tIjtzOjI0OiItLS0gQ2hvb3NlIGZ1bGwgbmFtZSAtLS0iO3M6ODoiWFgtTGFyZ2UiO3M6ODoiWFgtTGFyZ2UiO3M6NzoiWC1MYXJnZSI7czo3OiJYLUxhcmdlIjtzOjU6IkxhcmdlIjtzOjU6IkxhcmdlIjtzOjY6Ik1lZGl1bSI7czo2OiJNZWRpdW0iO3M6NToiU21hbGwiO3M6NToiU21hbGwiO319'),
	(29,1,NULL,'ffm_images_image','Image','','ngen_file_field','n','n',0,'50%','YToxOntzOjc6Im9wdGlvbnMiO3M6MjoiMTgiO30='),
	(30,1,NULL,'ffm_images_description','Image description','Short description used for the images alt text.','text','n','n',1,'50%','YToyOntzOjQ6Im1heGwiO3M6MjoiNDAiO3M6OToibXVsdGlsaW5lIjtzOjE6InkiO30='),
	(31,1,NULL,'option','Option','Single word, no spaces. Example: mp3_format','text','n','n',0,'','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(32,1,NULL,'option_name','Option Name','Human readable. Example: MP3 Format','text','n','n',1,'','YToyOntzOjQ6Im1heGwiO3M6MjoiMjUiO3M6OToibXVsdGlsaW5lIjtzOjE6InkiO30='),
	(33,1,NULL,'price','Price','Without the currency symbol.','text','n','n',2,'','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(34,1,NULL,'ffm_formats_shipping','Shipping','Without the currency symbol.','text','n','n',3,'','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(35,1,NULL,'ffm_formats_file','File','Optional file upload.','ngen_file_field','n','n',4,'','YToxOntzOjc6Im9wdGlvbnMiO3M6MjoiMjEiO30='),
	(36,1,NULL,'ffm_formats_itunes','iTunes URL','Optional iTunes URL.','text','n','n',5,'','YToxOntzOjQ6Im1heGwiO3M6MDoiIjt9'),
	(37,1,NULL,'ffm_images_image','Image','','ngen_file_field','n','n',0,'50%','YToxOntzOjc6Im9wdGlvbnMiO3M6MjoiMTkiO30='),
	(38,1,NULL,'ffm_images_description','Image Description','Short description used for the images alt text.','text','n','n',1,'50%','YToyOntzOjQ6Im1heGwiO3M6MjoiNDAiO3M6OToibXVsdGlsaW5lIjtzOjE6InkiO30='),
	(39,1,NULL,'ffm_images_image','Image','','ngen_file_field','n','n',0,'50%','YToxOntzOjc6Im9wdGlvbnMiO3M6MjoiMjAiO30='),
	(40,1,NULL,'ffm_images_description','Image Description','Short description used for the images alt text.','text','n','n',1,'50%','YToyOntzOjQ6Im1heGwiO3M6MjoiNDAiO3M6OToibXVsdGlsaW5lIjtzOjE6InkiO30=');

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
  `col_id_27` text,
  `col_id_28` text,
  `col_id_29` text,
  `col_id_30` text,
  `col_id_31` text,
  `col_id_32` text,
  `col_id_33` text,
  `col_id_34` text,
  `col_id_35` text,
  `col_id_36` text,
  `col_id_37` text,
  `col_id_38` text,
  `col_id_39` text,
  `col_id_40` text,
  PRIMARY KEY (`row_id`),
  KEY `site_id` (`site_id`),
  KEY `entry_id` (`entry_id`),
  KEY `row_order` (`row_order`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_matrix_data` WRITE;
/*!40000 ALTER TABLE `exp_matrix_data` DISABLE KEYS */;
INSERT INTO `exp_matrix_data` (`row_id`,`site_id`,`entry_id`,`field_id`,`row_order`,`col_id_1`,`col_id_2`,`col_id_3`,`col_id_4`,`col_id_5`,`col_id_6`,`col_id_8`,`col_id_9`,`col_id_10`,`col_id_11`,`col_id_12`,`col_id_13`,`col_id_14`,`col_id_15`,`col_id_16`,`col_id_17`,`col_id_18`,`col_id_19`,`col_id_20`,`col_id_21`,`col_id_22`,`col_id_23`,`col_id_24`,`col_id_25`,`col_id_26`,`col_id_27`,`col_id_28`,`col_id_29`,`col_id_30`,`col_id_31`,`col_id_32`,`col_id_33`,`col_id_34`,`col_id_35`,`col_id_36`,`col_id_37`,`col_id_38`,`col_id_39`,`col_id_40`)
VALUES
	(3,1,27,16,0,'55,000 Pennsylvanians have jobs related to energy production','','http://www.post-gazette.com/pg/10077/1043672-28.stm#ixzz0iWy53TEs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(4,1,27,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Is hydraulic fracturing growing local economies while supplying clean-burning natural gas?','<p>\n	Across the country, we are unlocking vast amounts of clean-burning natural gas through hydraulic fracturing. This proven, safe technology has allowed us to expand America&rsquo;s energy reserves by more than 7 billion barrels of oil and 600 trillion cubic feet of natural gas. Hydraulic fracturing not only helps us bring clean, affordable natural gas to people who need it, it also creates thousands of jobs throughout Appalachia, Texas and the West, as well as revenue for local, state and federal governments.</p>\n<p>\n	It seems some outside our industry, including politicians in Washington, do not understand what we do and are seeking ways to limit hydraulic fracturing. Washington must not be permitted to enact measures that would add needless regulation to an industry-standard practice we know very well.</p>\n<p>\n	We know hydraulic fracturing is safe and effective&mdash;that&rsquo;s why we&rsquo;ve used it for more than 60 years. And we&rsquo;re ready to use it for many more to deliver reliable supplies of clean natural gas.</p>\n','55,000 Pennsylvanians have jobs related to energy production','Pittsburgh Post-Gazette','http://http://www.post-gazette.com/pg/10077/1043672-28.stm#ixzz0iWy53TEs',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(5,1,27,55,0,NULL,NULL,NULL,'This is the video heading','','<p>\n	This is a transcript</p>\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,'<p>\n	<object height=\"385\" width=\"480\"><param name=\"movie\" value=\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\" /><param name=\"allowFullScreen\" value=\"true\" /><param name=\"allowscriptaccess\" value=\"always\" /><embed allowfullscreen=\"true\" allowscriptaccess=\"always\" height=\"385\" src=\"http://www.youtube.com/v/Eu8VqiiJq1M&amp;hl=en_US&amp;fs=1&amp;rel=0\" type=\"application/x-shockwave-flash\" width=\"480\"></embed></object></p>\n',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(7,1,29,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'What do the oil sands mean to you and your job?','<p>\n	Beneath the sands of Alberta lie 173 billion barrels of oil, reserves second only to those in Saudi Arabia. We are ready to deliver this important source of energy to the American people.</p>\n<p>\n	By responsibly developing these resources in Canada, we can create jobs here in America through refinery expansion and pipeline construction. By some accounts, this activity could support 600,000 new jobs by 2025, as well as add nearly $130 billion to the economy. Access to oil sands in Canada could provide a reliable supply of energy to more consumers in more parts of the country.</p>\n<p>\n	The refinery projects we are undertaking and the development of new technologies to better process oil from Canada will allow us to provide an important, affordable and reliable source of energy America needs.</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(8,1,0,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'How does offshore drilling provide America the energy it needs?','<p>\n	We know perhaps better than anyone else the immense opportunity in exploring the waters along the Outer Continental Shelf for oil and natural gas. We also know it can be done in a responsible way that takes the environment into consideration.</p>\n<p>\n	By some estimates, the Outer Continental Shelf contains more than 14 billion barrels of oil and 55 trillion cubic feet of natural gas. Tapping these resources could generate $1.7 trillion in revenue for governments and 160,000 new jobs.</p>\n<p>\n	Above anyone, we remain committed to the responsible development of offshore resources of oil and natural gas. It&rsquo;s an opportunity to produce domestic oil and natural gas while providing well-paying jobs and strengthening America&rsquo;s economy.</p>\n','â€œ30% of the oil and 25% of the natural gas we produce in the United States comes from thousands of wells in the Gulf of Mexico.â€','The Hill','http://thehill.com/blogs/congress-blog/energy-a-environment/103299-clean-energy-and-oil-spill-response-sen-lamar-alexander  ',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(9,1,31,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Will a ban on deepwater drilling affect future energy supply?','<p>\n	Following the tragic Deepwater Horizon accident, we are mobilizing a tremendous amount of resources to aid in responding to the spill. Our industry understands the need to respond in a coordinated manner and we are&mdash;swiftly creating a task force to examine the spill&rsquo;s cause and working hard to assess and address its impact.</p>\n<p>\n	Unfortunately, Members of Congress, as well as the President and his Administration, have halted new deepwater drilling for at least six months. This move places our jobs and communities in economic peril.</p>\n<p>\n	According to one study, a ban on new deepwater drilling, when combined with tighter regulations and longer permitting timeframes, could result in the equivalent of 340,000 barrels of oil per day in lost production by 2015. This means nearly 50,000 jobs idled in the short term and potentially more than 120,000 if restrictions are extended. In this economy, we can&rsquo;t afford to lose more jobs and deprive Americans of the reliable and affordable energy they need.</p>\n','â€œA moratorium on deepwater drilling could jeopardize 100,000 jobs.â€ ','Rep. Pete Olson, quoted in The Hill','http://thehill.com/blogs/e2-wire/677-e2-wire/102885-texas-lawmaker-to-introduce-bill-lifting-drilling-pause',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(10,1,32,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'What does climate change legislation mean for you and your family?','<p>\n	As an industry, we&rsquo;re committed to reducing greenhouse gas emissions and lower our environmental footprint. We&rsquo;re constantly enhancing efficiency and investing in new technologies that are changing the environmental effects of our work as we bring energy to consumers.</p>\n<p>\n	Congress continues to propose and debate well-intentioned measures that require companies to reduce their impact on the environment. We support this goal and are committed to finding solutions that promote environmental responsibility. However, many of the proposed measures would have unintended negative consequences, potentially putting millions of jobs at risk and raising costs for companies in our industry and others. Our elected officials must understand the need to balance the positive intent of legislation against the negative implications for consumers, jobs and the economy.</p>\n<p>\n	We are committed to protecting the environment. In fact, we&rsquo;re already working to reduce our carbon footprint. But we must be careful of proposals that could take away jobs from the hardworking people in our industry, make our industry less competitive or raise costs for the people that rely on us for affordable energy.</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(11,1,33,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Could additional regulations stifle economic growth?','<p>\n	We recognize that we must be careful about our impact on the environment. Our companies are taking steps every day to reduce that impact, knowing that we must be able to provide affordable, responsibly produced energy to Americans for decades to come.</p>\n<p>\n	We are concerned, however, that heavy regulations, while well-intentioned, could have unintended but severe negative effects on the economy, the job market and on American businesses&mdash;without significantly improving our nation&rsquo;s carbon footprint. While we support the goal of taking measures to reduce emissions, we want to ensure that doing so will not be at the expense of jobs and the economy.</p>\n<p>\n	We&rsquo;re constantly taking steps to produce energy responsibly. One such example is our commitment to expand production and use of ultra-low sulfur diesel and other technologies, which would lead to a reduction of six common emissions by 60 percent. We remain committed to working with Congress and the administration to make positive changes that lower our environmental impact.&nbsp;&nbsp;</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(12,1,34,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Will new taxes threaten jobs and weaken energy independence?','<p>\n	Producing America&rsquo;s resources of oil and natural gas isn&rsquo;t cheap. Our industry spends hundreds of billions of dollars every year on wages, technology and investment in research and development of energy resources.</p>\n<p>\n	What&rsquo;s more, the energy industry is one of the most heavily taxed industries in America. Industry taxes provide billions of dollars that support schools, first responders and our transportation system, among other vital public services. Yet Congress and the administration continue to propose new taxes on the industry. The latest proposal would mean at least $80 billion in new taxes.</p>\n<p>\n	We oppose new taxes not just because of their impact directly on our businesses, but of the far-reaching negative effects that they could bring to industry workers, consumers and the businesses and organizations that depend on our industry for reliable, affordable energy.</p>\n<p>\n	Instead of passing new taxes, we can show Congress and the administration that we are ready to lead an economic recovery by producing more oil and natural gas right here at home.&nbsp;</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(13,1,35,57,0,NULL,NULL,NULL,NULL,NULL,NULL,'Just exactly how important is our industry to the American economy?','<p>\n	We know how important our work is. More than 9.2 million people are directly or indirectly employed by America&rsquo;s oil and natural gas industry. That&rsquo;s 9.2 million people working hard to deliver the energy our country needs.</p>\n<p>\n	Whether it&rsquo;s passing new laws, regulations or taxes, Washington has a profound impact on our industry and jobs. New laws and regulations that raise the cost of energy or restrict access to resources of oil and natural gas could put thousands of jobs at risk and increase the costs of everything from food and transportation to heating a home.</p>\n<p>\n	We are part of the solution. Our 9.2 million jobs and more than a trillion dollars in value added to the economy play a major role in providing this country the energy it needs and driving the economy.</p>\n','','','',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(16,1,42,67,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'','content_pri_post1.jpg','Full',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(17,1,46,75,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon.png','Simon Campbell','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(18,1,46,75,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-scream.png','Mannifest, 2010. Perhaps getting a little carried away','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(20,1,46,75,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-beach_1.png','At Gansey Beach, Isle of Man','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(21,1,46,75,3,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-gracilands.png','Recording at \'GracieLand Studio\', Rochdale','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(22,1,46,75,4,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-peel-beach.png','At Peel Beach','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(23,1,46,75,5,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-gracieland2.png','Recording at \'GracieLand Studio\', Rochdale','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(25,1,46,75,6,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'simon-gracieland3.png','Recording at \'GracieLand Studio\', Rochdale','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(26,1,94,75,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'4492593035_328667ce97_z.jpg','Drums!','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(27,1,94,75,1,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'4493228572_439efbeb5f_z.jpg','Equipment!','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),
	(28,1,94,75,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'4493235968_f0a5cf8ed9_z.jpg','Board!','2010 Phil Kneen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);

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
	(1,1,0,0,0,'jamiepittock','Jamie Pittock','c6960548ec9a52fbd201591b5745da2e3f22b254','b77b70550c67daa6fd01469bebb4a5fc1da8142a','','jamie@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.226',1246621579,1298460459,1298474051,10,0,0,0,1298473174,0,0,0,'n','y','y','y','y','y','y','y','english','UTC','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(15,1,0,0,0,'mattsmith','Matt Smith','3f5005aab17d0ac4ac1327237c53ad461fb34e8a','8490cf5bc2d236a7b8964bf48c3124f959302078','','matt@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1278090769,1278091001,1292416546,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|2\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|3',0,0),
	(8,1,0,0,0,'philswan','Phil Swan','0b008451e769666699eeb7823ee6c11a69c4ffe9','a7d3f69e59651eebf2c20f3b1324e3d0fdc10875','','phil@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.224',1246873664,1265134003,1278090879,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(7,1,0,0,0,'gregwood','Greg Wood','f62facfb886a502eeb4183136fcb56225ce1a852','7a87cf17375270d378ae21e48d2c284769a5d4ac','','greg@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.224',1246873640,1298656831,1298907324,2,0,0,0,1298901068,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(10,1,0,0,0,'wil.linssen','Wil Linssen','431f3be4311312d8f6797650aa6b68dee3400e0f','2672d99660bfd02f706205db7408f38ebc4fd625','','wil@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1265121233,1276523330,1278090933,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(16,1,0,0,0,'jameswillock','James Willock','45a94bd18a0f1473c227f0a9005d22ea0164e344','3662e62db7aa6661e450aa939796204b70e20828','','james@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1278090813,1278091072,1278091072,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4',0,0),
	(17,1,0,0,0,'philhowell','Phil Howell','51b945d3ba3c297c10c16f25fa1c04eaa66302c7','282ff1f0c069d5e3ee77946e297c5fbfaa4f2a54','','phil.howell@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'127.0.0.1',1292409816,0,0,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5',0,0),
	(18,1,0,0,0,'garrett.winder','Garrett Winder','09b427cf5f4db125f294bf49ea0cdcc8ba9ff8c7','4540bd829211b44f0d8ea3c824d61012ac38423c','','garrett@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.226',1296232888,1298567199,1298916624,0,0,0,0,0,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1\nExtensions|C=admin&M=utilities&P=extensions_manager|3\nFieldtypes|C=admin&M=utilities&P=fieldtypes_manager|4\nSearch Log|C=admin&M=utilities&P=view_search_log|5',0,0),
	(19,6,0,0,0,'simoncampbell','Simon Campbell','f1818d8a9fdfe11e67602d39667f33571fa5ad0f','8e0d2a4c85e783648727c20d9d148bf43937e280','','simon@erskinedesign.com','','','','',0,0,0,'','','','','','','',0,0,'',0,0,'',0,0,'',0,'y',0,0,'88.97.41.226',1296657072,1298805067,1298894748,29,0,0,0,1298635631,0,0,0,'n','y','y','y','y','y','y','y','','','n','n','us','','','','','28','','18','','Snippets|C=modules&M=Low_variables|1',0,0);

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
	(6,23);

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
) ENGINE=MyISAM AUTO_INCREMENT=27 DEFAULT CHARSET=latin1;

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
	(26,'Cartthrob','0.9457','y'),
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
	(1298796613,'92.39.196.149','c85297d9c1999924d1419aa99756007f1e85198a'),
	(1297328420,'204.236.235.245','75410b8eff17d3041eee491bb8e51f389fae6bf3'),
	(1297278933,'84.246.205.199','ffcf30bda9c87ca0fd3a9d5eab3a589ea30de741'),
	(1297444528,'71.30.180.219','6bd6b61e8ab77c0b38d99e743d079f05da2d8df0'),
	(1297443767,'71.30.180.219','08ffdd3e2031b94fb85a4ec6f8490c2f9c7c84d0'),
	(1297443767,'71.30.180.219','40a3427625bb5a5d4e8f9fda4c96813f9c039812'),
	(1298473332,'88.97.41.226','b78bddfa76c826d6d100c19a9755fb52c7ce1eaa'),
	(1298473331,'88.97.41.226','370464802b53a9a5dfdffd8a7902c63ea7cee125'),
	(1297265942,'84.246.205.199','c2825d4ae5c7517c1031c4423e23cf11eaa56b6d'),
	(1297265920,'84.246.205.199','8f088c1426fdb4e8c47339793ee14e6322f697c5'),
	(1298473326,'88.97.41.226','a54ddd2b263ff5f9e1f71706abc26ef007335313'),
	(1296830716,'173.185.20.98','42b5ea47418a5d5c224bcc9e149ea8d346e89bbf'),
	(1296830716,'173.185.20.98','7f188020d51011a0be07259970e7e113c6df7aa8'),
	(1296830706,'173.185.20.98','c3597e1c278ce4c272eb7d335da42a3a51c17da6'),
	(1296757369,'128.30.52.65','5415ea773243cabab81f348b1c71ed116806afbd'),
	(1298473323,'88.97.41.226','1b598f19770cf15b36669d700fbab49e4399ea06'),
	(1298473321,'88.97.41.226','418ac305c3695545a016e35fa4b2d336249fd497'),
	(1297253448,'84.246.205.199','dc09c35bc7ab2a3c182253da36b43db551744776'),
	(1297253395,'84.246.205.199','7484feab6959b1e78759639ce8171190b39260d4'),
	(1297252718,'84.246.205.199','b0caf24d1d88673ba8dbbb43e84bd93861f00111'),
	(1297252629,'84.246.205.199','23a5271227cfd9fa67f6704b08525b1e175d88c5'),
	(1297443586,'71.30.180.219','14f3efabc2e8c2c1ea4754bdac1f915e0b7eb03d'),
	(1296754757,'82.10.223.13','86e98332f2022b92b255de7e618565f5900f209c'),
	(1296754749,'82.10.223.13','63cabe0abf8a9356909c6e0c91affab6b38f8575'),
	(1296754746,'82.10.223.13','d5e0c7e6377f5e75d7b0aa6a03c71955a082073a'),
	(1296754617,'82.10.223.13','289316e17242fe35b53dae3dcf13e8c32c3ac675'),
	(1296754612,'82.10.223.13','32e0d673f0241f7e1b234fb564cc11253a59e404'),
	(1297221052,'207.46.195.242','dc7726dde6955d72f4510d3163ad36cf15541fae'),
	(1296754594,'82.10.223.13','a7c0df674f9929325d7fb750436df94d3608a623'),
	(1296754583,'82.10.223.13','1759dde5ac6f54c7a242ea456567281de42ce620'),
	(1296754581,'82.10.223.13','71b714454ce2409fd0a46a218556de13b28fcd78'),
	(1296754428,'82.10.223.13','d2c3b91d94154b6e6c04c1bdd295f16b0f4a3815'),
	(1296754420,'82.10.223.13','bfd333417ce62a1698b0305f960c044e7922be53'),
	(1296754413,'82.10.223.13','f891f0a43dd0826cb2e046cbf74a66919a256f60'),
	(1296754410,'82.10.223.13','0e65c8496fc800ff7df377e4541745fe2c354dff'),
	(1296754408,'82.10.223.13','242e6d96637e2c32e99957c4b47ea4bbdebd77b6'),
	(1296754405,'82.10.223.13','9f8c8dddd2e105b9a8ff19c1ba08289be5a744e9'),
	(1296754401,'82.10.223.13','93eb9fb683e1979eda80b92f1b2b58709b7c57ee'),
	(1296754312,'82.10.223.13','559658907dabf3fb3142cbc25562fff7fdd549de'),
	(1296754033,'82.10.223.13','441704afd00e10a2517b4cbec9d8646102907cc9'),
	(1296753673,'82.10.223.13','83a98f1c438c1738de35278d90ea647baf259fea'),
	(1296753425,'82.10.223.13','741bd50f8c535f78a8f02cf4023402ade1098888'),
	(1296831187,'173.185.20.98','d0ee3468d067f225ce610478f291931cb77639f4'),
	(1296753343,'82.10.223.13','db7de23b71b8ca93dd8339d4226b898682d352bc'),
	(1296831187,'173.185.20.98','5986b5113e29149227a7470f998b39cdc920e044'),
	(1296831184,'173.185.20.98','398dd45178f1c2b2f037fed2df7861f050f3e716'),
	(1296831157,'173.185.20.98','8a29d335df37c388cb828e236f816276a216c801'),
	(1296831075,'173.185.20.98','e9da44a3e250a07bbd40115968ba99afc363959f'),
	(1296831078,'173.185.20.98','acb047d1ee98a68a366a86d6b073357686683c4c'),
	(1296831082,'173.185.20.98','4879d0ac616b1bae0201cc2d8cac66b5f60eaca2'),
	(1296831068,'173.185.20.98','39ef9df19cd1eb630a395fae88ed8943a041263f'),
	(1296831050,'173.185.20.98','e72d0f73f715b52a5e1b4968dc3f05d4bd625042'),
	(1296831050,'173.185.20.98','7f15b401b6f57841eb81089f446d37f0b775ab0a'),
	(1296831045,'173.185.20.98','b74eb9febc1629957d16645d958eaa9a4603366f'),
	(1296831042,'173.185.20.98','7a2fd0042f6dccd17806bc173dedc5e2687f42e5'),
	(1296830931,'173.185.20.98','3293357d97ff3a8e64bcbbf36f54bb0540428014'),
	(1296753030,'82.10.223.13','7b2ff48f496ceec52071fed44ee5732cc13a02ae'),
	(1296830927,'173.185.20.98','a137fbb0f52b79d45dc93633cbb17b7d4cca159f'),
	(1296830926,'173.185.20.98','86819deefd2f0457bbcaf0727f86ab6026bb1f60'),
	(1296752782,'82.10.223.13','3ce23478d98517656fffb670146243dacae35b52'),
	(1298473312,'88.97.41.226','6226d88cfe107e72950f283a3420849d9bc6e192'),
	(1298473317,'88.97.41.226','0f11c76a6f46f2441175167cdd6db52313ed9565'),
	(1298473308,'88.97.41.226','6481fea3eb2939d84dc60cd3460b318321c3ef21'),
	(1297214123,'217.137.170.76','ebd62444ba89b4c640133bbc6e36309c8623ff91'),
	(1297443586,'71.30.180.219','9d5461f6b74492ff21d64115269334399267e037'),
	(1297443203,'71.30.180.219','526d7f82b6e9f64b34a1a5b59c4aef6a1a5ee17a'),
	(1298034827,'218.213.130.151','18c524262424ee94e3d25158f292790674624e65'),
	(1298473305,'88.97.41.226','b0d79d5248615901aea715118e83a2680204d51f'),
	(1298473265,'88.97.41.226','ba43824d2a1d82063ae8a9064c78202cea84b9b0'),
	(1297443203,'71.30.180.219','2a693acff121838ef6183c9fa5cbc9851e72a380'),
	(1298914910,'98.20.79.244','7f7903783e2285973e7f90ea14866438bbedff92'),
	(1298914927,'98.20.79.244','e17eaf62360db5446059eda7f511c5afb1712a71'),
	(1298914927,'98.20.79.244','7dcf4bb2f95effe60295f25d68449b0420dc74d9'),
	(1296830805,'173.185.20.98','d31de8111dc6115a1fa83117d12fee350d86d648'),
	(1298389458,'212.219.3.8','7611865bcdc2fc7dd022257e76c73f15900d3b78'),
	(1298389422,'212.219.3.8','21d190d1b6fa43c03b2d0ed649161b29e18dd65b'),
	(1296830798,'173.185.20.98','ff4eb72afec252acb974af4c88f17dec0e1dc4a4'),
	(1296830795,'173.185.20.98','6168ecbba1116fdff7a855e0de5f01611fac1c35'),
	(1298540710,'130.88.123.167','b5909177772a39cdd357e4a131daf8eaca50eddc'),
	(1296749931,'82.10.223.13','2c1c146252ce420e428723257156f9f0ec427fd8'),
	(1298473197,'88.97.41.226','69544be82f5351b3e931891468fac803a097b854'),
	(1298473262,'88.97.41.226','14ba7d36c03fd4ef9eeec158dfd765cd249555f2'),
	(1297443191,'71.30.180.219','6a6b4c9ac81f667926d434067c4fd2823294dcac'),
	(1298540694,'130.88.123.167','3828d7896036064a6ba09ad17e0faaa3e13c2705'),
	(1298540680,'130.88.123.167','980b20c14b6e3c243f723beacf82395384b8c7fd'),
	(1298497629,'64.134.144.223','6655a66c32abc8c70bd024950e21f4d922360686'),
	(1298497641,'64.134.144.223','6e75a99cb2c7138f6dffae81e879faf8dea92cdb'),
	(1296830667,'173.185.20.98','1fe4f26a18a719a0641cc748bc97eedfa9e2b99c'),
	(1298497625,'64.134.144.223','71af6f288e6d2c2089c11784b482b4dbeb05ae10'),
	(1296830645,'173.185.20.98','efde513626eb201f531a0d600fbb2ce6db5abe02'),
	(1296830639,'173.185.20.98','71004d6c322b98ad588b0c965b1e02e2eccebc79'),
	(1296830558,'173.185.20.98','caf68a2d60c63c133204d240bed08984accc0835'),
	(1296830555,'173.185.20.98','9cbdf93041092ad1a97f681f3434e58191b4cfc4'),
	(1296830549,'173.185.20.98','2c5c09de7a72215948c8502671cfb120f6f2f053'),
	(1298497613,'64.134.144.223','6161991553a39486344d5930acd34d88971bfc91'),
	(1298497619,'64.134.144.223','41cf0f7df826e240ebdd1fa5f47bb8e56fb06fa5'),
	(1298497619,'64.134.144.223','a591f59a55b691441908ee1aee03787e89e68840'),
	(1298497610,'64.134.144.223','64f2981a667fd114504acb62f2f42ce233568a02'),
	(1298497607,'64.134.144.223','92de513feff2fb2056345ce34da9f4e632bed350'),
	(1296830756,'173.185.20.98','b705fbae262e3bd2289f8ba6ac196fb25e274b97'),
	(1298485443,'62.24.252.133','1965a1d56a2fbee5bd96acc003b7e5a6c88898c4'),
	(1296991924,'178.16.4.96','e2dc87732e90cd560288931d9074ba07bab5940c'),
	(1296830044,'173.185.20.98','d622f75eb768f6bc9933066e1c1966fbab6bc02b'),
	(1296750746,'82.10.223.13','ea54c175823bdc18700ce73d37ea5f81c7907978'),
	(1296830038,'173.185.20.98','2926dfb0c720e60b0d4a16c0e05b9fd1a18b736a'),
	(1296830010,'173.185.20.98','36d8ccdee38e4bb97b2596467bfd5ffa3a76020a'),
	(1296750826,'128.30.52.90','459a4c1925d8447be0e3e0b444ead1f69f60fed3'),
	(1298794835,'92.39.196.149','699136522c2731ef78fdd13fbafc4d8270d5f193'),
	(1298786789,'72.199.253.95','c638f5d9510319551d7574b6efacbeeacdc40b91'),
	(1296830007,'173.185.20.98','e783a297ba9b64d8584ed47332388e8a3490731e'),
	(1298785429,'72.199.253.95','f61091d6b24fe1c50b4dd46b5ffee9bbbf772c52'),
	(1296751109,'82.10.223.13','07237e386c00540e323d58ce3505a0508edb7025'),
	(1296751116,'82.10.223.13','56459b08fa1edfae91557e5643dcc271'),
	(1296751121,'82.10.223.13','fb8df2e4597e7a8ce29f06da40aec4ab46c763df'),
	(1296751123,'82.10.223.13','9e202a8f3c8cfe13d3aaa0dad3f73613fdb827fb'),
	(1296751125,'82.10.223.13','c8eef4943876c71096478d3a3c3380e92b3bc9f0'),
	(1296751125,'82.10.223.13','9a20e3f202d7e6ab81537286ec72f348cbba1cf7'),
	(1296751129,'82.10.223.13','91876735649d9f743f976509854a05bc86316b77'),
	(1296751129,'82.10.223.13','c20da081acd1eec35caf7716ac494fd71ffab9bf'),
	(1296829562,'173.185.20.98','ff285ea2589f3970d23060c55632f5699549b486'),
	(1296751131,'82.10.223.13','411523265e951b2e70bac25f60bd5903577d5a87'),
	(1296751137,'82.10.223.13','efa0aa202bb755b7761fe480840df7df20b29b7e'),
	(1296751140,'82.10.223.13','47d7d263381b2007c7bde33a07d754dc4db0f21b'),
	(1296751144,'82.10.223.13','e8b26b544b83f9a33474de9245564f7151b99322'),
	(1296751148,'82.10.223.13','335caa2d67a50e7518c152e81e246c099a54887c'),
	(1296751150,'82.10.223.13','1c18d77d7f8ce650513a4f69f22a9e5fc8f28b19'),
	(1296751150,'82.10.223.13','ca4481747dbcac1458eb5a38459c3b8260437331'),
	(1296751159,'82.10.223.13','3a4d1210c5cdda80068a358af81eb131e8747c8d'),
	(1296751161,'82.10.223.13','232cb43f776d28a3a963c93b9382c7faccc0dd85'),
	(1296751182,'82.10.223.13','a2ce32d9309bf440b14e33cf3267668f9db9385f'),
	(1296751189,'82.10.223.13','889cbdbb54d0f01c91788c66a23d68bed877c105'),
	(1296751191,'82.10.223.13','d5507cd8672bf32a5e4018ea80570053052031c6'),
	(1296751191,'82.10.223.13','478eb9b2e3e2cc9a7387052bedfceb53bc63eb21'),
	(1296751207,'82.10.223.13','e74931ad54670cbf2fe774e4d8449bde586b9495'),
	(1296751207,'82.10.223.13','6e49ec6847427f45fe98c3d59f45047b8b5c6207'),
	(1298473115,'88.97.41.226','ac8f20cc4bea59dd1c63d2361f3ea29ebf2021a2'),
	(1298473174,'88.97.41.226','af0edecc06656b32b310b571e373f8f22cf7812a'),
	(1298473179,'88.97.41.226','bd2b598cd3820b19c034c2b0ed2216ff28138389'),
	(1296752126,'82.10.223.13','c55f38cf0ddbbe4ff6aae8cdf0851330c5c5552f'),
	(1298477412,'78.148.150.183','8bb75e49fc96d548528c891eeb7c9256db3ef496'),
	(1296991896,'178.16.4.96','db5bb89f913e63512073e8af8667b727835c01fd'),
	(1297139484,'66.249.72.198','27f6550f6b247678b4a87eb6d127421e3e31bc21'),
	(1296990014,'83.218.5.51','29fe46880afceac8c442e4c0a09de9e7557f970c'),
	(1296988568,'82.95.252.179','d8adffbbd626a660a75f6946d228d362f5f6adf3'),
	(1297443185,'71.30.180.219','281cc75bcd64ca1910026ad9b76a407eb0fcaf9d'),
	(1298473094,'88.97.41.226','bf4c5ce12ac9fda827153d900249d085ef08ab86'),
	(1297443178,'71.30.180.219','a8a1b24b829f60636f801331a22b013cec0af34c'),
	(1297443168,'71.30.180.219','3542655454ac0733ded74260506b150aee20f9a7'),
	(1297443175,'71.30.180.219','bd5b14b244538c1917eb3cbbd4fc434c3f2e6960'),
	(1298473086,'88.97.41.226','cb351c71e0e35451a56deb19e5776f68d64c1fbd'),
	(1298473082,'88.97.41.226','068ae84002db37faecb8c2ac3643b589e2428ea6'),
	(1297024611,'173.185.20.98','f5438d42ef9807635a76992f29f50a4561a362a3'),
	(1296944419,'66.249.72.198','513c34f2a9808b7179691dd79e148c94452c942b'),
	(1296937935,'173.185.20.98','00b346b805f3ff3a138793f6333bf8e69c919f26'),
	(1296937366,'173.185.20.98','b40e09e3c906af58d0f28ea384aec405bda1988d'),
	(1296936446,'173.185.20.98','09b6e3bc704034e373ba393d07fc03ed36521922'),
	(1296936433,'173.185.20.98','4a0579c697ff99a6478f4eb935145dcae8288ffe'),
	(1296936353,'74.197.19.206','88f9ec347c869d8a4356c3cf42462cedead13ec8'),
	(1296934452,'74.197.19.206','7d15e6d54e06f42acdf12885424417fb542adc3f'),
	(1296934393,'173.185.20.98','8b1164d280143b52d0a07c906b74f83b019f69a3'),
	(1297207171,'87.250.252.241','3473d3833de4a815821fae11e93c64de42cda343'),
	(1296928819,'82.20.38.138','2a93dace2a874aada1e93cea81faa5de7b92342e'),
	(1298473004,'88.97.41.226','c766d6ae07fda7ee238c0a093468db8342542aa0'),
	(1297198606,'67.195.115.251','9cc31fda6326c4fb6a554828968579e05ca6fb32'),
	(1298474058,'88.97.41.226','4366ba3057d4b05258032f7b4b1d4c9363d1a6a6'),
	(1297191887,'82.10.218.59','5919ed09c20304363b0310038bee8ec62cfcafc4'),
	(1297191885,'82.10.218.59','35023a73b315003d9c87667be64961eff6efdbdc'),
	(1298472980,'88.97.41.226','93d66bee155b9d421ca54f7d0231898399ac08e1'),
	(1298472913,'88.97.41.226','4eef6fb73b381e7df01013e959fa725f55abe89a'),
	(1298472915,'88.97.41.226','a4073b40323a23d86d5c44ffd21ac07bd3e7c5dc'),
	(1298371381,'218.213.130.151','825ea7d063a65a06e6e3f6e83cea405f1a691bf0'),
	(1298357843,'207.46.13.143','223b7c748f6eb28a4c449b2bca03b4c28666be01'),
	(1298334439,'208.115.111.74','18534e027ed2cd25913bbc916e5ff8548af1c761'),
	(1296907447,'82.10.218.59','392f9861036fb011f2bd0332402957de6ddb71a6'),
	(1297443160,'71.30.180.219','6c3f4f096fa41b3cf6143722d32549fd5ed28b5b'),
	(1297443152,'71.30.180.219','2dd790ab71d32e1fc803858bff802cd32e882b34'),
	(1297443138,'71.30.180.219','dbc780b474209f0ceb6d4ab63c4361eebba04ba0'),
	(1298328385,'67.195.115.251','0aa10bf2761a6d0ada895041609532ad9da42b2c'),
	(1298305146,'46.31.201.70','e895d52edb0530722c51e9761a9c5bc03ba45767'),
	(1298758734,'207.46.204.229','ec70aca6494c9a2ca1036a277880648975e540e1'),
	(1298747362,'67.195.115.251','e6b52837494453772067fe1375642076c1f5d3f6'),
	(1298459583,'207.46.204.179','e9c86e25438a47f0f6c9515ab7f0140100bed222'),
	(1298746329,'88.97.41.226','7f3fba4e80c3c53b2d70e28e96147a2ce21ff48a'),
	(1298727943,'88.97.41.226','727f7f08bc687baf4ccbefed3546ab7b45e44aec'),
	(1298722862,'86.136.221.42','e7360c870dc7799aeedd599e9ce21282faea91d2'),
	(1298417792,'67.195.115.251','5cde0f27649199e78714600ed238debec4fd47a7'),
	(1297932406,'66.249.71.149','7af48e1904371ab808763c59f26fe30d9760434f'),
	(1297927434,'67.195.115.251','fc9714e3f17efb2c039cb9b80bfda0aed08535e9'),
	(1297909394,'157.55.17.105','7355ff8e183f66f570c48a6273b3eace6f1d352c'),
	(1297905776,'157.55.116.38','867a127e956c500d170f6c6f59e9f3a6cbdf71c3'),
	(1297443126,'71.30.180.219','77abe33b61bbd703f0ddf524dc9a81ee87c77827'),
	(1297443117,'71.30.180.219','76de431ddf2d86af22916d4023529d3cbbad0ea2'),
	(1297443112,'71.30.180.219','a8bffe79e8bd854bd7ced9b52cc75b19a7a3da7f'),
	(1297443112,'71.30.180.219','6680acb28aaa3449f9ee7f609086ad7b664c3f5a'),
	(1297099724,'173.185.20.98','aa96aa4c9f68d9131bf17ad9719f49ed5803f42d'),
	(1297099724,'173.185.20.98','b46eb002d353e2d9979dd84602f882ccc2b8ff35'),
	(1298472913,'88.97.41.226','5ea38f51d150469808c8d0f4365bc70c875ef788'),
	(1298278942,'90.206.105.18','03a4893bb3da6a92b5d0dec08a5d6d141afec2fc'),
	(1296852454,'12.234.22.2','75ec80d039790c5ab524583d42051f164facc593'),
	(1296852548,'12.234.22.2','9704a4fc93f9543ca99eaeaa0987e402cd8c80eb'),
	(1296852548,'12.234.22.2','424c4d8419b8147d557ea828620f15a059b7d3f3'),
	(1296852548,'12.234.22.2','a30abc666a0abf3c64d382ca668fc54f5020a58a'),
	(1296852548,'12.234.22.2','969ba149925996bc4d5c91b915f865dc1cda61ac'),
	(1298245784,'65.52.110.51','1edaf8bd53b709129495132625b95f4514523ba0'),
	(1297006705,'109.70.40.203','885281a9394ca1814e797e94f381b4f5b934fcf3'),
	(1298236815,'67.195.115.251','2f8f725d994153566db1c9cdb15488d99c097b98'),
	(1298722769,'86.136.221.42','a00916dc54f211c9e6d5a19671a5e77f713bc974'),
	(1298206811,'38.99.82.249','148193c2cc9c8087238cc58bb94fe07e6702e7f6'),
	(1297865605,'109.249.230.96','1c695731deccad09c715378b53837277980f9f86'),
	(1297099714,'173.185.20.98','e2bc7119f9ef7b5a2536403e9b760aa2f71b37a5'),
	(1297099695,'173.185.20.98','44f52fa3c60925c7b82038695f76532ae87b5d81'),
	(1298474055,'88.97.41.226','4de981d2662714324ace92b24304f688934224de'),
	(1297160644,'220.181.108.115','a45fed58041e48282e3ad894841a749ab64b4bed'),
	(1297864601,'109.249.230.96','5dbe94f3e41fbcda60b29da2380e7df2ebdc1534'),
	(1298206808,'38.99.82.249','6ce669b2e603ea62c2c542c167cccf2926d3a0e0'),
	(1296994644,'82.10.218.59','f493138c1335d937449d592875058a8f7bcb3029'),
	(1297339844,'207.46.199.42','1723f483f453efab27a99d66682f6ec61edfdc41'),
	(1298472902,'88.97.41.226','2aac75c94a0bdaab7e954867be2afe2f606bae96'),
	(1298722676,'86.136.221.42','b63f17c87417c7ae560974c48dba08feb06f8546'),
	(1298019473,'207.46.13.101','acc70eed094cf1e0efbef1006af73872aed84512'),
	(1297442925,'71.30.180.219','bf97e646e3b773439191d79d907351ada44ae6a3'),
	(1297442925,'71.30.180.219','f2b44be57415fb3c41143fef3fdb73b397d14c4f'),
	(1297442908,'71.30.180.219','bb427aeaa5ada9e8aed3df7c2bba0c68939eb5be'),
	(1297442908,'71.30.180.219','f2873045b24fd9b01d0d2728e3544b35f9008ee8'),
	(1297442556,'71.30.180.219','c4fb132a462f1254e724f7b9a8ae76bbd6b10d17'),
	(1297442556,'71.30.180.219','2254868819e56ed181fe8f49c53fe441833aa7aa'),
	(1297442480,'71.30.180.219','66f0b87e4fe3d05de0794b244511ad2882e5a7d3'),
	(1297442424,'71.30.180.219','cff39b1928656cc92526f1aefc35e1d5503b7b73'),
	(1297442423,'71.30.180.219','c93b7ee965dd3da393203a90e440f67dec4f6f99'),
	(1297442422,'71.30.180.219','1704150d15d5a0c720418429477d0e6d099547a5'),
	(1297442421,'71.30.180.219','2bec07570f3aa539d2fa4c281f1a5f28939c7404'),
	(1297442420,'71.30.180.219','25e332a7d83300cf1af3b9c18a82ea2f2351d722'),
	(1297442408,'71.30.180.219','23e12b7929215c75859156633003c462cfe19d7c'),
	(1297442398,'71.30.180.219','1f0454a07396ccbd971cedde6db4f8b7e0a29643'),
	(1297442386,'71.30.180.219','b23645ab037e1ed8083736807175a987d1d08050'),
	(1297442000,'71.30.180.219','d8c984a6e502ed8a3f0eca9e9478c8661f7ad5b2'),
	(1297441981,'71.30.180.219','bee40ab284aa546d5d050305b38a51505e73bff1'),
	(1297441906,'71.30.180.219','5f1c820c96293e92109d154ce5cdba2d9a16e3f2'),
	(1297441905,'71.30.180.219','02bc2c3e51f8c6e6bafd2e9d2065b1ffecba2811'),
	(1297441904,'71.30.180.219','8fa3d3f8fef7665d83df824c8fb9d0ac9f71b2f8'),
	(1297441902,'71.30.180.219','4e1f30afb74e25f99941120e412ae443c5085934'),
	(1297441901,'71.30.180.219','5bf3c43afdc8304cc6641fd18fa262bc04092272'),
	(1297441900,'71.30.180.219','430bd2ae5b5f7f39edbabfba710e8a82fce16e63'),
	(1297441899,'71.30.180.219','13accf5667e556fa01fc900ad82caa9822d1e90c'),
	(1297441863,'71.30.180.219','57fdd3a6a32eaafc697f8b7e81ed718d28cfac7c'),
	(1297441862,'71.30.180.219','ab8ea99e40f5f5dabd6c8a8e006d24e5a3ecb514'),
	(1297441861,'71.30.180.219','80a63b0a52f5bc4d754dee375462feb4a0cc8e51'),
	(1297441859,'71.30.180.219','bc96cabb1e4570dcc3f81c3e226ed8c20dcea5e9'),
	(1297441764,'71.30.180.219','debb2fc4a240e50788e387282186f3b5d7142463'),
	(1297441763,'71.30.180.219','b732b4200927f4e9e8101207b23eb381bb588753'),
	(1297441762,'71.30.180.219','adbdd7992b9d487f1c076eed9c40cd20e6342ec1'),
	(1297441762,'71.30.180.219','68b2b4d5136fc6a05ea866bc5fb45860784da5a2'),
	(1297441761,'71.30.180.219','6d841e36175b986c798a2a103c29f28751f80a98'),
	(1297441760,'71.30.180.219','747fc37919b2b98b8814d7b3ac1668a586350667'),
	(1297441759,'71.30.180.219','3c8757ad5f0646fa0e8b6f4929cfdd3c7db339ce'),
	(1297441758,'71.30.180.219','e58a39f2b5fc7ab4cc98209028db8ac22e4036bb'),
	(1297441757,'71.30.180.219','68c130e5d8d12e5310c7f4f3dc02ac36730d99ac'),
	(1297441756,'71.30.180.219','e44c66dc9a6bb08e9af30db741faba0c5cd4e094'),
	(1297441688,'71.30.180.219','cb8f2b2080f89ce76f5be4448c3447a69fe0211c'),
	(1297441687,'71.30.180.219','ed7d45c09b97e8d4838f2b3a6a3be3df88a39af6'),
	(1297441686,'71.30.180.219','f756bcb53f8b3ca972304dbdf6e251fa04c5880a'),
	(1297441685,'71.30.180.219','0269ac98a042204591e3194355b044282abbe532'),
	(1297441684,'71.30.180.219','5f1fb0b1e0a9ddcac7cb228807611537b1d58c79'),
	(1297441683,'71.30.180.219','5343360e3fe50e2f8f1feafa566a734ccef67717'),
	(1297441682,'71.30.180.219','a1e2c4a6e254b6eaaa2ecc613a098dc4240989f8'),
	(1297441616,'71.30.180.219','196f45b5e1a152f619010c6a23f5b5e9752641c8'),
	(1297441615,'71.30.180.219','5ced7c2861dd4c83e4bbf60717ecced47ad91cf2'),
	(1297441614,'71.30.180.219','3f22699539c431cd56727936674214aa516e97ea'),
	(1297441613,'71.30.180.219','c7ae08fbb7704956eff5e72bc37af8621932990c'),
	(1297441613,'71.30.180.219','ca5d1b0629e8a94d2e5fe7503e242059734581a0'),
	(1297441612,'71.30.180.219','33ca37594e7ba2fdef332500f8825b5d4701bd9b'),
	(1297441611,'71.30.180.219','b99f33d2f77cf5bc4577631a9d87688bd3a9ba58'),
	(1297440056,'71.30.180.219','54f4da895106e713c68b70cc0541c948f9be434d'),
	(1297440056,'71.30.180.219','d08084c9bf2cba4f0f41377fc92edb3e73abaa46'),
	(1297440047,'71.30.180.219','e4e4d9d01ab40320fe53c17e7a6b402fdac748c5'),
	(1297439915,'71.30.180.219','65a793e15ef2405cf2edb19425e06f562c2847f0'),
	(1297439912,'71.30.180.219','828e305dd3259773f68e2559dcc1c47e2dc46617'),
	(1298474055,'88.97.41.226','9c145964cdb464d64aa9f99c51bb16407ea4361e'),
	(1298473347,'88.97.41.226','f9a21750627b04be5c4d41ea8cee68cccdd1027a'),
	(1298472689,'88.97.41.226','a9554be50bf8afb0a06e8f803b453b3e49453f7c'),
	(1298472682,'88.97.41.226','2473a9ee611ba40d843b832c6d2658ef95f97efd'),
	(1298472673,'88.97.41.226','5ddb84b46b118462305ef5654df4c45360149419'),
	(1298914904,'98.20.79.244','0a200a81f9b0c1ba08539b7f87f6d134b1519b5c'),
	(1297976822,'81.141.198.205','bfa172ae63febca809562c56af5a98f81846f76c'),
	(1297966077,'109.157.204.251','b8e132333c8d8986d0d80249bf6a33afd24b08ff'),
	(1298032953,'217.44.191.36','2f582064f4394123036de20ad3b3cbba842cb177'),
	(1298295088,'195.10.114.211','597b31414ea7ec42831cd03640e260c7116f75ef'),
	(1297406247,'66.249.66.56','5abc9a1139ae281fa157a66f000bb17f3da13264'),
	(1298174351,'66.249.72.198','eb066eeccc0306b4d348f10768ac5e886fa1cf58'),
	(1298134684,'207.46.13.132','88b4c3584dc76a0c3f5c0fb7f4930f3995c6e10c'),
	(1298686223,'207.46.199.44','3d003c09b6a1eabbd93468612c38dfd1a9646652'),
	(1297441575,'71.30.180.219','28639049f6781236cec3a90396207aa5075e94ff'),
	(1297441546,'71.30.180.219','6a71328f0e5ff983032262c9fd4058d53ed9eedc'),
	(1297441545,'71.30.180.219','2df5b088504a6bad825cec59a8b99919596f9549'),
	(1297441544,'71.30.180.219','a65ac2e7cbf309d29acc4de0bb9077e84329def4'),
	(1297441543,'71.30.180.219','9ad8812dcbb111f21f1fb57c8c3d333e0ada01e3'),
	(1297441541,'71.30.180.219','e4fe73b7581563b3f191663299986c3f4b26c1ff'),
	(1297441494,'71.30.180.219','433c21309d350decb603d79706e3ee957d70d1f9'),
	(1297440362,'71.30.180.219','8ea1b9ae60264b490ea05436e8c66adc1193e24a'),
	(1297363174,'82.2.139.6','64feb8da004cc3b268ebc49d6d87a1908a79e513'),
	(1297440346,'71.30.180.219','9eb2aea21b07dbe29d47cfe639158aa26e9915e0'),
	(1297440280,'71.30.180.219','9f6b11ed1ec9915ad26fd7b27d349e5e0016ae59'),
	(1297440247,'71.30.180.219','f13120e3f4efe0d1de14263226758f61ee71c67a'),
	(1297440206,'71.30.180.219','aecc9c1666d665e116ad540b2d4326ea7ddaf0d8'),
	(1297440206,'71.30.180.219','5c212863aec66bc8a300d172389ee19767f67d9e'),
	(1297444672,'71.30.180.219','13df4fcf2b36b1fdc9f54b9547d3357357e408ca'),
	(1297444679,'71.30.180.219','a3239ef50a14f9a5a41652caf51285a846ae9332'),
	(1297444693,'71.30.180.219','084e92218b0d060a2150b789217ec5945771b79e'),
	(1297444719,'71.30.180.219','840b87b98680b532209860bc254f221ef6343de5'),
	(1297444735,'71.30.180.219','7796ae9f9f46911835c345695f3ca74d5d0a423f'),
	(1297444765,'71.30.180.219','b3704b99e6989fdba77e2b99660c85fa7f523a22'),
	(1297444782,'71.30.180.219','5b8414a42768953e69d213be7c8980286277b456'),
	(1297444789,'71.30.180.219','0232c209c282667e1baab48502bdfc43c039f947'),
	(1297444789,'71.30.180.219','704dd6704a1d79bc9d206454ab1a77b237be83ea'),
	(1297444822,'71.30.180.219','730dd203e699d39324a9ca3719c9ef25ea7e643f'),
	(1297444822,'71.30.180.219','af0b53d4a957c6a101604797b908ab5708c85ebc'),
	(1297445263,'71.30.180.219','33094de42a0a86c114bc96a8e980722b1769da35'),
	(1297445995,'71.30.180.219','933066983fcb7b2215dda6b1c9359810633d7623'),
	(1297446001,'71.30.180.219','c447e65ce132acfe07c20a642132d92eb673325c'),
	(1297446007,'71.30.180.219','a2f91268a56972455a06a48b969c197d05c8eaa7'),
	(1297446007,'71.30.180.219','05263ebbe08d1a37d74825cba95d56afcf3584f5'),
	(1297446295,'71.30.180.219','75ed83c950acc4c3e8d5c0f4091d1e9a7e94ed5b'),
	(1297446545,'71.30.180.219','4ab3621718cb5d35b6862927fdc4884f71096a96'),
	(1297446635,'71.30.180.219','4cd1d81fe673ab66f10ecbcbd1e0982b22e26817'),
	(1297446639,'71.30.180.219','3e9f970a90bbe7207528f60cb4ec8cb5bbf5aa7a'),
	(1297446709,'71.30.180.219','afd873f5f24b962ca6fa24472d2bc74f7d62a9f0'),
	(1297473892,'66.249.72.198','1b817f12604b5b52b730c7eecaf01aecf427f6b9'),
	(1297496532,'208.115.111.74','eb2bae7404705d64a8fcecad093a145d143b3de9'),
	(1298472853,'88.97.41.226','d0ffe037c5d90247532d0e75f5799a295ce05721'),
	(1298685524,'82.10.218.59','d6e11059a4f9e6c92ff5916707081fb529277a46'),
	(1297559678,'184.73.30.110','ab6bb3e6de57bd8c8c157a1d504fb5f35d0d8908'),
	(1297560233,'184.73.30.110','9a1687b545822779ea6491ddfd9441f0085cb5da'),
	(1297564851,'64.34.218.179','3bd42114e3d01aa0c9f01299cdcd545facfefa00'),
	(1297570198,'65.52.110.29','4944ea8795d35f1bac8b5e97dd14da01933cecec'),
	(1297572515,'69.28.58.25','62b64a1ed8c28ab87cfe2f7544e9a4f6c1daaa27'),
	(1297585436,'67.195.115.251','9b818b7883d366589d4aaf78ebf57844579e6f88'),
	(1297599714,'109.249.119.44','022b335b2874fe8890be5d082190f919f5146726'),
	(1297600179,'109.249.119.44','1c5a2d1b8b74af125ef9bf6197b9c808717cf759'),
	(1297611127,'208.115.111.74','6fe192e44b7d549cfd9de226d05c0a378c90667f'),
	(1297638012,'64.34.219.55','a62ad49e63b2183b53bfbdef2de91d5f3768f417'),
	(1297658289,'69.28.58.23','5fb4fefb55ef01a83345338ae63b13ed7aa3a9f2'),
	(1297671961,'67.195.115.251','1ca7c4a2ded57f79490baf3cc7973600f159bfe3'),
	(1297676527,'89.178.133.178','a4a19b99ca44c59bc1f2a73564852a9f616f7ff1'),
	(1297682806,'207.46.13.133','346683febf7379ce7f56c9097f4d377b0297ad86'),
	(1297688279,'217.43.159.210','7f985f93ee75a759ac4881fc71739078b64b0938'),
	(1297764727,'217.43.159.210','ddc741b3ffcd32e26b2fdb6f58375730feeafa2f'),
	(1297771940,'217.43.159.210','b018c4468606d12102fb3ce837947fdee0500b14'),
	(1297786783,'92.39.195.174','7e910cd2b384a11f5761730f8a328aef2dddd7f5'),
	(1297786829,'92.39.195.174','1ec326fab63386051c6f26bc908c5a5cc5e5a1ad'),
	(1297808269,'71.30.177.29','c2f5ce0825efcfb6b315528afe35df5cd494edf0'),
	(1297808314,'71.30.177.29','7561012851cca7219b7cd30ade0232936808eb0c'),
	(1297808340,'71.30.177.29','ac79318529de56bc810511009764368168b3d66c'),
	(1297808340,'71.30.177.29','b86fd3c7c509a3f5c04dc8b428e2ec00703589bd'),
	(1297809301,'71.30.177.29','3a59fdacd644595889b556981d4f30409123384f'),
	(1297856580,'80.65.246.154','3446fdc0f0162a0d55e03b82692d05b8018c2439'),
	(1298685494,'82.10.218.59','f6b89484fab978e90a0bbb9394bcc3bd730a65cc'),
	(1298472851,'88.97.41.226','24bae88dc51e7dadf7e5390ed529ec1e18daac18'),
	(1298472851,'88.97.41.226','eee5a43562ebba2adde9994c8e78b4f3662c6f5f'),
	(1298685491,'82.10.218.59','619776a4ca0cbbed1ec1d3e8ee5c38f5890fa462'),
	(1298472814,'88.97.41.226','da043e0befad7c1180733425754bcba7ff4378d8'),
	(1298472801,'88.97.41.226','094b4241e911153e8e0e3bcbbf695a3fd01ac70c'),
	(1298472748,'88.97.41.226','79072d3d35a7a69c527c6e182ad86981adeb49f9'),
	(1298472738,'88.97.41.226','576685c3a0468bafdeb2f7fbb9b066b273acb8d9'),
	(1298472723,'88.97.41.226','bf055d0b161dcd6849eb9bb0a9ccc6009564a91e'),
	(1298472714,'88.97.41.226','23f307d9eeff3f28027ce73aa1835e7979bdfab4'),
	(1298472693,'88.97.41.226','1277c7f232d2701e630f64a6667954b8c62c8bd4'),
	(1298914899,'98.20.79.244','7f32a19a1c3ae1682625c19ff953e46bdc629905'),
	(1298914893,'98.20.79.244','59c87c24cea67cebde5ffea94fbefb4fbd450e8b'),
	(1298914890,'98.20.79.244','5a2cdbe3ec0ad6ceed8b79be7d08d9e721e1220c'),
	(1298795220,'207.46.195.227','359870d1721e61b1f102e4831a272a497a500f36'),
	(1298900918,'88.97.41.224','5eba45360b81f52e9b3a3559b4c6cdb0914e3f9f'),
	(1298900907,'88.97.41.224','811af55efbe87cbae62cf79da8e768f6ce98b944'),
	(1298900902,'88.97.41.224','8a1a837d1fe4d253147db53f6fd15c08472d3539'),
	(1298900188,'157.55.116.38','d67940ce03bcc2e5a010f50df72c2f2df6a1e85b'),
	(1298916656,'98.20.79.244','40b08e7998a7f09f50c771bbc24169fdeaf24ed2'),
	(1298916653,'98.20.79.244','27194cbc51a1993e4f6a3bc300dff7b70a47aa3f'),
	(1298916640,'98.20.79.244','a648258a9ba049b3bf780f282d213f816f71f5e0'),
	(1298916638,'98.20.79.244','00008869a4164fc695b84250378fc8f64e53bdb9'),
	(1298916634,'98.20.79.244','82dd0f6013e38bf635a113c7c5edd5ab52f9d72b'),
	(1298916632,'98.20.79.244','827b15b81f3bf56cc7ca056706c33fe6a8a75547'),
	(1298916632,'98.20.79.244','c7c1ba90fb7c98867c83f700975810539ef48a41'),
	(1298916632,'98.20.79.244','03ee8fb3134d06e9ab968c96b5b9b19f231044ec'),
	(1298916627,'98.20.79.244','b5f022749f2b1d645fe706eecee63c6cd8d90d0f'),
	(1298638687,'84.246.205.199','6b603d7a80948e8c06a2e07da34efbe8d0c07484'),
	(1298669803,'187.116.174.194','245cc4d1b381d464e1383913fd76a9ac4f503d18'),
	(1298669773,'187.116.174.194','cf986b926071f8241ccaf176829859559ac1e078'),
	(1298659369,'66.249.72.131','c4e21a34890c0df68e05918ba58ed783bf6c1bfd'),
	(1298659369,'66.249.72.131','80763d7ab008232d603b577a188350f107742107'),
	(1298659367,'66.249.72.131','a1b3b770d2c45a55d9ea4b11d3ddfe82105b782e'),
	(1298894753,'92.39.196.149','d34a616a0e0298e3fe86466dbb6d3e6685a3bbaf'),
	(1298658262,'88.97.41.226','e233fec8d8afedcd88b5f7d1bf0b313290a1c585'),
	(1298658277,'88.97.41.226','dd3847008cd8ed98719be3e5d539b52482f7f43f'),
	(1298893434,'88.97.41.226','882da905aa4c1e79bf8ca9634b8e6d57ab250066'),
	(1298877153,'72.199.253.95','31b79a998bc0460d237f6b694c7a52c676324938'),
	(1298851900,'84.246.205.199','0853f547197248b9d3eead72cf6fc6d81bcae33f'),
	(1298828189,'67.195.115.251','89ae7215a2992b1ce0513d04d6d8848730794777'),
	(1298916624,'98.20.79.244','81217104735879cdd13b3135cc7909d2d30ff4e0'),
	(1298916266,'67.195.115.251','0e684fae6f4d4e01208bb728b2a3bdfee4fa5c9c'),
	(1298552570,'195.10.99.109','a229882ff2ed453210be983e00fefa1bdc5ea4ed'),
	(1298552599,'195.10.99.108','85561e70d1910ef0336b261e9bfab21c3a46521d'),
	(1298915013,'217.122.216.133','74d422f324dd18d6813bd650aab2a0ffaa5d695b'),
	(1298914932,'98.20.79.244','dc29ad1f43ddd544abaf1723d4957a0dbe48a1ab'),
	(1298914927,'98.20.79.244','24142aca94c1ddeed7aa10e37cfda46fec2457e5'),
	(1298914886,'98.20.79.244','4bc23bcdc47cf66ad256e0283bddfc61e129144e'),
	(1298914880,'98.20.79.244','748b4e4fbe684c898ba2f7a810a02698908d6270'),
	(1298914875,'98.20.79.244','bd4cddfe6684cf96a1c1c042cd590bfae2a71e2d'),
	(1298914872,'98.20.79.244','eaa073ca8dfdfdcf6c1d317c2020c12984aa8dfc'),
	(1298904979,'86.28.203.145','47833576c1d612d0dc0ab3a72fb07153b3dff7df'),
	(1298906874,'98.20.79.244','b63320dab2cce39f34131d1ed4716b18a1496857'),
	(1298914405,'88.97.41.226','a65afcf73f0c7da9f33299e4712dd2a5cac4a228'),
	(1298796635,'92.39.196.149','5f0819a08844e357aca739d92b1b78df8e2bafef'),
	(1298824974,'88.97.41.226','57cb8e5abd0788ee2d5d9c642ddd26d41375ccf7'),
	(1298568343,'88.97.41.226','f6656ae8803b395f50a4b348c25deeabd46e337f'),
	(1298568349,'88.97.41.226','d76667b2be64da701fc8b1e10fe67e21563c0dca'),
	(1298797169,'92.39.196.149','ad784cf35aa4510d537bf1079593726b621545bd'),
	(1298797169,'92.39.196.149','e2b63f6101b2d8cb385ba55898a8097c01ccf60f'),
	(1298623022,'67.195.115.251','c49086cde381e8f26c70007bf251bf457e85a7ec'),
	(1298796625,'92.39.196.149','6d975ff75207642664e95ea1889be48fd0a14986'),
	(1298904876,'207.46.13.45','ae6aa7e2b2137e5d7eb3790c9ffb7c2ff128578c'),
	(1298901075,'88.97.41.224','9187401e715cef2c5d3906dc61f6dd68d85de2a2'),
	(1298901075,'88.97.41.224','61494fc83f046ee6a4c38a1ca230a648c7dcd523'),
	(1298901069,'88.97.41.224','2fa5c0b95ce3ef7e0afc8b7c4fe01f38d4aa1feb'),
	(1298797157,'92.39.196.149','75659fe2d9ac6970b9371e2802816b36dc071957'),
	(1298797150,'92.39.196.149','4331110a7d909fe260162e3557dc4827f138b58e'),
	(1298574009,'207.46.13.51','a6f7f67bacc736cfcebba6eb66d8e74bb2a1faa7'),
	(1298632908,'130.88.123.167','8edb1a674ccb50a1e999fbd4c40a49a9993fc6c0'),
	(1298632884,'130.88.123.167','cd7b324a39ef021ae88a34d9bd76d6669682e07d'),
	(1298797099,'92.39.196.149','55a1a0f45834122b33318fcd6f31780d83319b43'),
	(1298629217,'92.11.222.197','e77a8e406570840de3190eea2d0c145e2db43fe1'),
	(1298797091,'92.39.196.149','c54afe4f686ba11b2ad6264bfa109ce5303f7ab4'),
	(1298796732,'92.39.196.149','46dbdd677d18751f17b64319de32e485a4b9651c');

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
	('7628268127a0926066c1175737173d94d5f83e00',1,18,1,'98.20.79.244','Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10_6_6; ',1298916658);

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
	(1,'Simon Campbell Music','default_site','','a:98:{s:15:\"encryption_type\";s:4:\"sha1\";s:10:\"site_index\";s:0:\"\";s:9:\"site_name\";s:10:\"EE Sandbox\";s:8:\"site_url\";s:42:\"http://simoncampbellmusic.erskinestage.com\";s:16:\"theme_folder_url\";s:50:\"http://simoncampbellmusic.erskinestage.com/themes/\";s:15:\"webmaster_email\";s:23:\"jamie@erskinedesign.com\";s:14:\"webmaster_name\";s:0:\"\";s:19:\"weblog_nomenclature\";s:7:\"channel\";s:10:\"max_caches\";s:3:\"150\";s:11:\"captcha_url\";s:49:\"http://sandbox.ee.erskinedev.com/images/captchas/\";s:12:\"captcha_path\";s:52:\"/var/www/html/subdomains/sandbox/ee/images/captchas/\";s:12:\"captcha_font\";s:1:\"y\";s:12:\"captcha_rand\";s:1:\"y\";s:23:\"captcha_require_members\";s:1:\"n\";s:17:\"enable_db_caching\";s:1:\"n\";s:18:\"enable_sql_caching\";s:1:\"n\";s:18:\"force_query_string\";s:1:\"n\";s:12:\"show_queries\";s:1:\"n\";s:18:\"template_debugging\";s:1:\"n\";s:15:\"include_seconds\";s:1:\"n\";s:13:\"cookie_domain\";s:0:\"\";s:11:\"cookie_path\";s:0:\"\";s:17:\"user_session_type\";s:1:\"c\";s:18:\"admin_session_type\";s:2:\"cs\";s:21:\"allow_username_change\";s:1:\"y\";s:18:\"allow_multi_logins\";s:1:\"y\";s:16:\"password_lockout\";s:1:\"y\";s:25:\"password_lockout_interval\";s:1:\"1\";s:20:\"require_ip_for_login\";s:1:\"y\";s:22:\"require_ip_for_posting\";s:1:\"y\";s:18:\"allow_multi_emails\";s:1:\"n\";s:24:\"require_secure_passwords\";s:1:\"n\";s:19:\"allow_dictionary_pw\";s:1:\"y\";s:23:\"name_of_dictionary_file\";s:0:\"\";s:17:\"xss_clean_uploads\";s:1:\"y\";s:15:\"redirect_method\";s:8:\"redirect\";s:9:\"deft_lang\";s:7:\"english\";s:8:\"xml_lang\";s:2:\"en\";s:7:\"charset\";s:5:\"utf-8\";s:12:\"send_headers\";s:1:\"y\";s:11:\"gzip_output\";s:1:\"n\";s:13:\"log_referrers\";s:1:\"y\";s:13:\"max_referrers\";s:3:\"500\";s:11:\"time_format\";s:2:\"us\";s:15:\"server_timezone\";s:3:\"UTC\";s:13:\"server_offset\";s:0:\"\";s:16:\"daylight_savings\";s:1:\"n\";s:21:\"default_site_timezone\";s:0:\"\";s:16:\"default_site_dst\";s:1:\"n\";s:15:\"honor_entry_dst\";s:1:\"y\";s:13:\"mail_protocol\";s:4:\"mail\";s:11:\"smtp_server\";s:0:\"\";s:13:\"smtp_username\";s:0:\"\";s:13:\"smtp_password\";s:0:\"\";s:11:\"email_debug\";s:1:\"n\";s:13:\"email_charset\";s:5:\"utf-8\";s:15:\"email_batchmode\";s:1:\"n\";s:16:\"email_batch_size\";s:0:\"\";s:11:\"mail_format\";s:5:\"plain\";s:9:\"word_wrap\";s:1:\"y\";s:22:\"email_console_timelock\";s:1:\"5\";s:22:\"log_email_console_msgs\";s:1:\"y\";s:8:\"cp_theme\";s:7:\"default\";s:21:\"email_module_captchas\";s:1:\"n\";s:16:\"log_search_terms\";s:1:\"y\";s:12:\"secure_forms\";s:1:\"y\";s:19:\"deny_duplicate_data\";s:1:\"y\";s:24:\"redirect_submitted_links\";s:1:\"n\";s:16:\"enable_censoring\";s:1:\"n\";s:14:\"censored_words\";s:0:\"\";s:18:\"censor_replacement\";s:0:\"\";s:10:\"banned_ips\";s:0:\"\";s:13:\"banned_emails\";s:0:\"\";s:16:\"banned_usernames\";s:0:\"\";s:19:\"banned_screen_names\";s:0:\"\";s:10:\"ban_action\";s:8:\"restrict\";s:11:\"ban_message\";s:34:\"This site is currently unavailable\";s:15:\"ban_destination\";s:21:\"http://www.yahoo.com/\";s:16:\"enable_emoticons\";s:1:\"y\";s:13:\"emoticon_path\";s:48:\"http://sandbox.ee.erskinedev.com/images/smileys/\";s:19:\"recount_batch_total\";s:4:\"1000\";s:13:\"remap_pm_urls\";s:1:\"n\";s:13:\"remap_pm_dest\";s:0:\"\";s:17:\"new_version_check\";s:1:\"y\";s:20:\"publish_tab_behavior\";s:5:\"hover\";s:18:\"sites_tab_behavior\";s:5:\"hover\";s:17:\"enable_throttling\";s:1:\"n\";s:17:\"banish_masked_ips\";s:1:\"y\";s:14:\"max_page_loads\";s:2:\"10\";s:13:\"time_interval\";s:1:\"8\";s:12:\"lockout_time\";s:2:\"30\";s:15:\"banishment_type\";s:7:\"message\";s:14:\"banishment_url\";s:0:\"\";s:18:\"banishment_message\";s:50:\"You have exceeded the allowed page load frequency.\";s:17:\"enable_search_log\";s:1:\"y\";s:19:\"max_logged_searches\";s:3:\"500\";s:17:\"theme_folder_path\";s:52:\"/var/www/simoncampbellmusic.erskinestage.com/themes/\";s:10:\"is_site_on\";s:1:\"y\";}','a:3:{s:19:\"mailinglist_enabled\";s:1:\"y\";s:18:\"mailinglist_notify\";s:1:\"n\";s:25:\"mailinglist_notify_emails\";s:0:\"\";}','a:44:{s:10:\"un_min_len\";s:1:\"4\";s:10:\"pw_min_len\";s:1:\"5\";s:25:\"allow_member_registration\";s:1:\"y\";s:25:\"allow_member_localization\";s:1:\"y\";s:18:\"req_mbr_activation\";s:5:\"email\";s:23:\"new_member_notification\";s:1:\"n\";s:23:\"mbr_notification_emails\";s:0:\"\";s:24:\"require_terms_of_service\";s:1:\"y\";s:22:\"use_membership_captcha\";s:1:\"n\";s:20:\"default_member_group\";s:1:\"5\";s:15:\"profile_trigger\";s:19:\"asdgasrtq42rafasfdg\";s:12:\"member_theme\";s:7:\"default\";s:14:\"enable_avatars\";s:1:\"y\";s:20:\"allow_avatar_uploads\";s:1:\"n\";s:10:\"avatar_url\";s:43:\"http://en-dev.local/uploads/system/avatars/\";s:11:\"avatar_path\";s:73:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/avatars/\";s:16:\"avatar_max_width\";s:3:\"100\";s:17:\"avatar_max_height\";s:3:\"100\";s:13:\"avatar_max_kb\";s:2:\"50\";s:13:\"enable_photos\";s:1:\"y\";s:9:\"photo_url\";s:49:\"http://en-dev.local/uploads/system/member_photos/\";s:10:\"photo_path\";s:79:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/member_photos/\";s:15:\"photo_max_width\";s:3:\"100\";s:16:\"photo_max_height\";s:3:\"100\";s:12:\"photo_max_kb\";s:2:\"50\";s:16:\"allow_signatures\";s:1:\"y\";s:13:\"sig_maxlength\";s:3:\"500\";s:21:\"sig_allow_img_hotlink\";s:1:\"n\";s:20:\"sig_allow_img_upload\";s:1:\"n\";s:11:\"sig_img_url\";s:57:\"http://en-dev.local/uploads/system/signature_attachments/\";s:12:\"sig_img_path\";s:87:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/signature_attachments/\";s:17:\"sig_img_max_width\";s:3:\"480\";s:18:\"sig_img_max_height\";s:2:\"80\";s:14:\"sig_img_max_kb\";s:2:\"30\";s:19:\"prv_msg_upload_path\";s:80:\"/users/jamiepittock/Sites/energynation.org/public/uploads/system/pm_attachments/\";s:23:\"prv_msg_max_attachments\";s:1:\"3\";s:22:\"prv_msg_attach_maxsize\";s:3:\"250\";s:20:\"prv_msg_attach_total\";s:3:\"100\";s:19:\"prv_msg_html_format\";s:4:\"safe\";s:18:\"prv_msg_auto_links\";s:1:\"y\";s:17:\"prv_msg_max_chars\";s:4:\"6000\";s:19:\"memberlist_order_by\";s:11:\"total_posts\";s:21:\"memberlist_sort_order\";s:4:\"desc\";s:20:\"memberlist_row_limit\";s:2:\"20\";}','a:6:{s:11:\"strict_urls\";s:1:\"n\";s:8:\"site_404\";s:0:\"\";s:19:\"save_tmpl_revisions\";s:1:\"n\";s:18:\"max_tmpl_revisions\";s:1:\"5\";s:15:\"save_tmpl_files\";s:1:\"y\";s:18:\"tmpl_file_basepath\";s:67:\"/users/jamiepittock/Sites/energynation.org/public/assets/templates/\";}','a:10:{s:21:\"enable_image_resizing\";s:1:\"y\";s:21:\"image_resize_protocol\";s:3:\"gd2\";s:18:\"image_library_path\";s:0:\"\";s:16:\"thumbnail_prefix\";s:5:\"thumb\";s:14:\"word_separator\";s:10:\"underscore\";s:17:\"use_category_name\";s:1:\"n\";s:22:\"reserved_category_word\";s:8:\"category\";s:23:\"auto_convert_high_ascii\";s:1:\"n\";s:22:\"new_posts_clear_caches\";s:1:\"y\";s:23:\"auto_assign_cat_parents\";s:1:\"y\";}');

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
	(1,1,'y','offline_template','','<!DOCTYPE html>\n<html lang=\"en\">\n\n<head>\n    \n    <!-- TITLE and META -->\n    <title>System Offline</title>\n    \n    <meta name=\'robots\' content=\'noindex,nofollow,noarchive\' />\n    \n    <!-- CSS -->\n    <link href=\"/assets/css/screen.css\" rel=\"stylesheet\" media=\"screen\" />\n    <link href=\"/assets/css/campbell-nav.css\" rel=\"stylesheet\" media=\"screen\" />\n    \n    <!--[if lte IE 8]><link href=\"/assets//css/screen_ie.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 8]><link href=\"/assets/css/screen_ie8.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 7]><link href=\"/assets/css/screen_ie7.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 6]><link href=\"/assets/css/screen_ie6.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    \n    <!-- JAVASCRIPT -->\n    <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js\"></script>\n    \n    <!-- WEBFONTS -->\n    <script type=\"text/javascript\" src=\"http://fast.fonts.com/jsapi/d8bd6128-b18f-4a44-a9cc-7175e6b50fa2.js\"></script>\n    \n    <!--[if lt IE 9]><script src=\"/assets/js/ie.js\"></script><![endif]-->\n    \n    <!--[if IE 6]>\n        <script src=\"/assets/js/ie6/DD_belatedPNG_0.0.8a.js\"></script>\n        <script>\n            DD_belatedPNG.fix(\'.png\');\n        </script>\n    <![endif]-->\n    \n</head>\n\n<body class=\"newsletter\">\n\n<ul id=\"nav_access\">\n    <li><a href=\"#navigation_pri\">Skip to navigation</a></li>\n    <li><a href=\"#content_pri\">Skip to content</a></li>\n</ul>\n\n<div id=\"navigation_network\" class=\"clearfix music\">\n    <ul>\n        <li id=\"nn_simon\"><a href=\"http://simoncampbell.com\">Simon Campbell</a></li>\n        <li id=\"nn_music\" class=\"cur\"><a href=\"http://music.simoncampbell.com\">Music</a></li>\n        <li id=\"nn_blog\"><a href=\"http://blog.simoncampbell.com\">Blog</a></li>\n        <li id=\"nn_social\"><span class=\"hide\">Follow me</span>\n            <ul>\n                <li id=\"nn_rss\"><a href=\"/feeds/master_rss/\">RSS</a></li> \n                <li id=\"nn_twitter\"><a href=\"http://twitter.com/simoncampbell\">Twitter</a></li> \n                <li id=\"nn_facebook\"><a href=\"http://www.facebook.com/SimonCampbellBand\">Facebook</a></li>\n            </ul>\n        </li>\n    </ul>\n</div><!-- // #navigation_network -->\n\n<div id=\"page\" class=\"clearfix\">\n    \n    <div id=\"header\">\n        <h1 id=\"branding\">\n            <img src=\"/assets/images/site/titles/main_title.png\" alt=\"Simon Campbell Music\" width=\"907\" height=\"61\" class=\"title\" />\n        </h1>\n    </div> <!-- // #header -->\n    \n    <div id=\"content_pri\">\n        \n        <p>The site is currently offline, please check back later.</p>\n        \n    </div> <!-- // #content_pri -->\n    \n</body>\n</html>'),
	(2,1,'y','message_template','','<!DOCTYPE html>\n<html lang=\"en\">\n\n<head>\n    \n    <!-- TITLE and META -->\n    <title>{title}</title>\n    \n    {meta_refresh}\n    <meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />\n    <meta http-equiv=\"Content-Language\" content=\"en-us\" />\n    <meta name=\'description\' content=\'\' />\n    <meta name=\'keywords\' content=\'\' />\n    <meta name=\'robots\' content=\'noindex,nofollow,noarchive\' />\n    \n    <!-- CSS -->\n    <link href=\"/assets/css/screen.css\" rel=\"stylesheet\" media=\"screen\" />\n    <link href=\"/assets/css/campbell-nav.css\" rel=\"stylesheet\" media=\"screen\" />\n    \n    <!--[if lte IE 8]><link href=\"/assets/css/screen_ie.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 8]><link href=\"/assets/css/screen_ie8.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 7]><link href=\"/assets/css/screen_ie7.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    <!--[if IE 6]><link href=\"/assets/css/screen_ie6.css\" rel=\"stylesheet\" media=\"screen\" /><![endif]-->\n    \n    <!-- JAVASCRIPT -->\n    <script src=\"http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js\"></script>\n    \n    <!-- WEBFONTS -->\n    <script type=\"text/javascript\" src=\"http://fast.fonts.com/jsapi/d8bd6128-b18f-4a44-a9cc-7175e6b50fa2.js\"></script>\n    \n    <!--[if lt IE 9]><script src=\"/assets/js/ie.js\"></script><![endif]-->\n    \n    <!--[if IE 6]>\n        <script src=\"/assets/js/ie6/DD_belatedPNG_0.0.8a.js\"></script>\n        <script>\n            DD_belatedPNG.fix(\'.png\');\n        </script>\n    <![endif]-->\n    \n</head>\n\n<body class=\"newsletter\">\n\n<ul id=\"nav_access\">\n    <li><a href=\"#navigation_pri\">Skip to navigation</a></li>\n    <li><a href=\"#content_pri\">Skip to content</a></li>\n</ul>\n\n<div id=\"navigation_network\" class=\"clearfix music\">\n    <ul>\n        <li id=\"nn_simon\"><a href=\"http://simoncampbell.com\">Simon Campbell</a></li>\n        <li id=\"nn_music\" class=\"cur\"><a href=\"http://music.simoncampbell.com\">Music</a></li>\n        <li id=\"nn_blog\"><a href=\"http://blog.simoncampbell.com\">Blog</a></li>\n        <li id=\"nn_social\"><span class=\"hide\">Follow me</span>\n            <ul>\n                <li id=\"nn_rss\"><a href=\"/feeds/master_rss/\">RSS</a></li> \n                <li id=\"nn_twitter\"><a href=\"http://twitter.com/simoncampbell\">Twitter</a></li> \n                <li id=\"nn_facebook\"><a href=\"http://www.facebook.com/SimonCampbellBand\">Facebook</a></li>\n            </ul>\n        </li>\n    </ul>\n</div><!-- // #navigation_network -->\n\n<div id=\"page\" class=\"clearfix\">\n    \n    <div id=\"header\">\n        <h1 id=\"branding\">\n            <img src=\"/assets//images/site/titles/main_title.png\" alt=\"Simon Campbell Music\" width=\"907\" height=\"61\" class=\"title\" />\n        </h1>\n    </div> <!-- // #header -->\n    \n    <div id=\"content_pri\">\n        \n        <h2>{heading}</h2>\n        {content}\n        <p>{link}</p>\n        \n    </div> <!-- // #content_pri -->\n    \n</body>\n</html>'),
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
	(0,1,9,19,'Simon Campbell',39,0,0,0,0,1298900887,0,0,0,1265120889,4,1249281451,1297265301);

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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_status_groups` WRITE;
/*!40000 ALTER TABLE `exp_status_groups` DISABLE KEYS */;
INSERT INTO `exp_status_groups` (`group_id`,`site_id`,`group_name`)
VALUES
	(1,1,'Default Status Group'),
	(2,1,'Orders Status Group');

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
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_statuses` WRITE;
/*!40000 ALTER TABLE `exp_statuses` DISABLE KEYS */;
INSERT INTO `exp_statuses` (`status_id`,`site_id`,`group_id`,`status`,`status_order`,`highlight`)
VALUES
	(1,1,1,'open',1,'009933'),
	(2,1,1,'closed',2,'990000'),
	(6,1,2,'open',1,'009933'),
	(7,1,2,'closed',2,'990000'),
	(8,1,2,'Paid',3,''),
	(9,1,2,'Processing',4,''),
	(10,1,2,'Failed',5,''),
	(11,1,2,'Declined',6,'');

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
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_template_groups` WRITE;
/*!40000 ALTER TABLE `exp_template_groups` DISABLE KEYS */;
INSERT INTO `exp_template_groups` (`group_id`,`site_id`,`group_name`,`group_order`,`is_site_default`,`is_user_blog`)
VALUES
	(4,1,'_layout',1,'n','n'),
	(3,1,'home',6,'y','n'),
	(6,1,'feeds',5,'n','n'),
	(7,1,'_components',2,'n','n'),
	(19,1,'404',4,'n','n'),
	(17,1,'previews',3,'n','n'),
	(24,1,'thirtysix',7,'n','n'),
	(25,1,'store',8,'n','n'),
	(26,1,'journal',9,'n','n'),
	(27,1,'biography',10,'n','n'),
	(28,1,'gallery',11,'n','n'),
	(29,1,'contact',12,'n','n'),
	(30,1,'account',13,'n','n'),
	(31,1,'pages',14,'n','n'),
	(32,1,'newsletter',15,'n','n');

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
) ENGINE=MyISAM AUTO_INCREMENT=124 DEFAULT CHARSET=latin1;

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
	(114,1,24,'history','y','webpage','','',1296674197,0,'n',0,'','n','n','o',0),
	(116,1,24,'lyrics-ep','y','webpage','{embed=\"_layout/_start\"\n    body_class=\"editorial\"\n    body_id=\"lyrics\"\n    section=\"thirtysix\"\n    {!-- LG BETTER META OPTIONS BELOW --}\n    title=\"Lyrics | ThirtySix\"\n    title_suffix=\"\"   \n    title_prefix=\"\"   \n    description=\"\"\n    keywords=\"\"\n    robots_index=\"\"\n    robots_follow=\"\"\n    robots_archive=\"\"\n    canonical_url=\"/\"\n}\n    \n    <div id=\"content_pri\">\n        <h2 class=\"hide\">ThirtySix Lyrics</h2>\n        <div class=\"half\">\n            <div class=\"widget\">\n                <h3>I like it like that</h3>\n                <p>\n                    A golden dream, a child so fair,<br>\n                    A fine wine drank in my favourite chair,<br>\n                    A love for life â€“ a love for truth,<br>\n                    A signal back to my frantic youth.\n                </p>\n                <p>\n                    I got the power, I got the speed,<br>\n                    I got every little thing I need,<br>\n                    Life is for real, no second chance,<br>\n                    I take it all, I take my stance,<br>\n                    So I donâ€™t care if you donâ€™t know where Iâ€™m at,<br>\n                    â€™Cause babe I like it like that.\n                </p>\n                <p>\n                    A thousand wishes, a thousand dreams,<br>\n                    A thousand lives, a thousand schemes,<br>\n                    A thousand ways to show my affection,<br>\n                    All leading in the same direction.\n                </p>\n                <p>\n                    Five hundred years of war and peace,<br>\n                    I see it all but have no release,<br>\n                    Five hundred victims, five hundred screams,<br>\n                    I hear them nightly in my dreams&hellip;\n                </p>\n            </div><!-- // .widget -->\n            <div class=\"widget opacity_02\">\n                <h3>Hot as hell</h3>\n                <p>\n                    I aint got no sense of humour\n                    I aint got no time for you\n                    You would need another life to do the things Iâ€™m gonâ€™ to do\n                    I can see right through you woman\n                    youâ€™re a vixen I can tell\n                    Goinâ€™ to eat your pretty heart out woman\n                    Iâ€™m as hot as hell.\n                </p>\n                <p>\n                    Tell your momma Iâ€™m a cominâ€™\n                    Goinâ€™ to steal your heart away\n                    You can fill a million novels with the things Iâ€™m goin to say\n                    Got you round my little finger\n                    Got you caught up in my spell\n                    Goinâ€™ to burn your pretty fingers babe\n                    Iâ€™m as hot as hell.\n                </p>\n                <p>\n                    Well your daddyâ€™s out a boozin\n                    and your mommas on the game\n                    Got me layinâ€™ on your pillow\n                    You donâ€™t even know my name\n                    Goin a hawkin and a talkin\n                    Aint got nothinâ€™ left to sell, oh no\n                    Goinâ€™ to work your skinny ass off babe\n                </p>\n            </div><!-- // .widget -->\n        </div><!-- // .half -->\n        <div class=\"half\">\n            <div class=\"widget opacity_02\">\n                <h3>Preacher (of love)</h3>\n                <p>\n                    Iâ€™ve got to prove that my intentions are good\n                    Iâ€™m a living legend but I donâ€™t carve in wood\n                    I shut the pitstops called reality\n                    I am so blind; that I cannot see\n                    Listen to me now who am I? Iâ€™m the preacher man\n                </p>\n                <p>\n                    I look quite young of that Iâ€™m always told\n                    I know the points without even being told\n                    that limitations are a fact of life\n                    an indiscretion with another mans wife\n                    Listen to me now who am I? Iâ€™m the preacher man yeah\n                </p>\n                <p>\n                    Iâ€™m the Preacher, the Preacher of love\n                    Iâ€™m the Preacher, sent from God above\n                    and if you show me your sin,\n                    you come right on in kneel before, the Preacher of love\n                </p>\n                <p>\n                    My caring wife itâ€™s everything that we share\n                    My loving flock made me a millionaire\n                    We say the words but they donâ€™t mean much\n                    My famous lifestyle keeps me nicely out of touch\n                    Listen to me now who am I? Iâ€™m the preacher man\n                <p>\n            </div><!-- // .widget -->\n            <div class=\"widget\">\n                <h3>Misgivings</h3>\n                <p>\n                    Leavinâ€™ home for the first time, must have been a quarter past ten\n                    The sun still kept shininâ€™, before the rain moved in\n                    It was late in September, just before the fall\n                    My mom had packed me a suitcase, and left it out in the hall\n                    I didnâ€™t know what was coming.\n                </p>\n                <p>\n                    Got the car all started and turned the radio on\n                    Bob Dylan was singinâ€™ something about Maggieâ€™s farm\n                    I pulled out of the driveway straight into the oncoming car\n                    Thatâ€™s when I met you babe; I didnâ€™t get very far\n                    I didnâ€™t know what was coming.\n                </p>\n                <p>\n                We were rockinâ€™ and rollinâ€™ all over the place\n                Standinâ€™ around with that look on your face\n                It started in Blacko and ended in love\n                Still, I have had my misgivings&hellip;\n                </p>\n                <p>\n                    Since that day that I met you life has been a turbulent thing\n                    Its gone straight from my moms place into a relationship thing\n                    Every day is a circus I really give you credit for that\n                    Complimentary they call us but Iâ€™m not sure about that\n                </p>\n            </div><!-- // .widget -->\n        </div><!-- // .half -->\n    </div> <!-- // #content_pri -->\n    \n    {embed=\"_layout/_sidebar\"}\n\n{embed=\"_layout/_end\"}','',1296732049,7,'n',0,'','n','n','o',0),
	(117,1,32,'index','y','webpage','','',1296747766,0,'n',0,'','n','n','o',0),
	(118,1,17,'journal','y','webpage','','',1297940204,0,'n',0,'','n','n','o',0),
	(119,1,17,'homepage-features','y','webpage','','',1297940216,0,'n',0,'','n','n','o',0),
	(120,1,25,'music','y','webpage','','',1298914890,0,'n',0,'','n','n','o',0),
	(121,1,25,'tshirts','y','webpage','','',1298914898,0,'n',0,'','n','n','o',0),
	(123,1,25,'posters','y','webpage','','',1298916656,0,'n',0,'','n','n','o',0);

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
	(17,'cp',5),
	(18,'cp',5),
	(19,'cp',5),
	(20,'cp',5),
	(21,'cp',5),
	(22,'cp',5);

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_upload_prefs` WRITE;
/*!40000 ALTER TABLE `exp_upload_prefs` DISABLE KEYS */;
INSERT INTO `exp_upload_prefs` (`id`,`site_id`,`is_user_blog`,`name`,`server_path`,`url`,`allowed_types`,`max_size`,`max_height`,`max_width`,`properties`,`pre_format`,`post_format`,`file_properties`,`file_pre_format`,`file_post_format`)
VALUES
	(4,1,'n','Files: Documents','../uploads/files/documents/','/uploads/files/documents/','all','','','','','','','','',''),
	(11,1,'n','Images: General','../uploads/images/general/','/uploads/images/general/','img','','','','alt=\"\"','','','','',''),
	(14,1,'n','Images: Journal','../uploads/images/journal/','/uploads/images/journal/','img','','','','alt=\"\"','','','','',''),
	(15,1,'n','Videos','../uploads/videos/','/uploads/videos/','all','','','','','','','','',''),
	(16,1,'n','Audio','../uploads/audio/','/uploads/audio/','all','','','','','','','','',''),
	(17,1,'n','Images: Galleries','../uploads/images/galleries/','/uploads/images/galleries/','img','','','','alt=\"\"','','','','',''),
	(18,1,'n','Images: Products: T-Shirts','../uploads/images/products/tshirts/','/uploads/images/products/tshirts/','img','','','','','','','','',''),
	(19,1,'n','Images: Products: Music','../uploads/images/products/music/','/uploads/images/products/music/','img','','','','','','','','',''),
	(20,1,'n','Images: Products: Posters','../uploads/images/products/posters/','/uploads/images/products/posters/','img','','','','','','','','',''),
	(21,1,'n','Files: Products: Music','../uploads/files/products/music/','../uploads/files/products/music/','all','','','','','','','','',''),
	(22,1,'n','Images: Homepage features','../uploads/images/features/','/uploads/images/features/','img','','','','alt=\"\"','','','','','');

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
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;

LOCK TABLES `exp_user_params` WRITE;
/*!40000 ALTER TABLE `exp_user_params` DISABLE KEYS */;
INSERT INTO `exp_user_params` (`params_id`,`hash`,`entry_date`,`data`)
VALUES
	(18,'iIobfm9QJ8lUT3gKCp1EOQrLE',1296830729,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}'),
	(17,'gfHPgyiFIJXCc2aiRNCph40JC',1296830716,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}'),
	(19,'qvVnPjj5IUhwy4zqN7NOsJLkz',1296831050,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}'),
	(20,'FqNBi3giFzFnRCKUGrEZAPTjo',1296831060,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}'),
	(21,'j1Kg6TuRFM330eLNLcyk59Rzt',1296831187,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}'),
	(22,'x2aAxw090rXDZXhFPSTMJQoBG',1296831197,'a:11:{s:8:\"group_id\";s:0:\"\";s:6:\"notify\";s:0:\"\";s:20:\"screen_name_override\";s:0:\"\";s:16:\"exclude_username\";s:0:\"\";s:11:\"require_key\";s:0:\"\";s:15:\"key_email_match\";s:0:\"\";s:3:\"key\";s:0:\"\";s:13:\"secure_action\";s:2:\"no\";s:14:\"admin_register\";s:3:\"yes\";s:8:\"required\";s:31:\"email|password|password_confirm\";s:15:\"override_return\";s:19:\"account&#47;pending\";}');

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
  `field_id_86` text NOT NULL,
  `field_ft_86` tinytext,
  `field_id_87` text NOT NULL,
  `field_ft_87` tinytext,
  `field_id_88` text NOT NULL,
  `field_ft_88` tinytext,
  `field_id_89` text NOT NULL,
  `field_ft_89` tinytext,
  `field_id_90` text NOT NULL,
  `field_ft_90` tinytext,
  `field_id_91` text NOT NULL,
  `field_ft_91` tinytext,
  `field_id_92` text NOT NULL,
  `field_ft_92` tinytext,
  `field_id_93` text NOT NULL,
  `field_ft_93` tinytext,
  `field_id_94` text NOT NULL,
  `field_ft_94` tinytext,
  `field_id_95` text NOT NULL,
  `field_ft_95` tinytext,
  `field_id_96` text NOT NULL,
  `field_ft_96` tinytext,
  `field_id_97` text NOT NULL,
  `field_ft_97` tinytext,
  `field_id_98` text NOT NULL,
  `field_ft_98` tinytext,
  `field_id_99` text NOT NULL,
  `field_ft_99` tinytext,
  `field_id_100` text NOT NULL,
  `field_ft_100` tinytext,
  `field_id_101` text NOT NULL,
  `field_ft_101` tinytext,
  `field_id_102` text NOT NULL,
  `field_ft_102` tinytext,
  `field_id_103` text NOT NULL,
  `field_ft_103` tinytext,
  `field_id_104` text NOT NULL,
  `field_ft_104` tinytext,
  `field_id_105` text NOT NULL,
  `field_ft_105` tinytext,
  `field_id_106` text NOT NULL,
  `field_ft_106` tinytext,
  `field_id_107` text NOT NULL,
  `field_ft_107` tinytext,
  `field_id_108` text NOT NULL,
  `field_ft_108` tinytext,
  `field_id_109` text NOT NULL,
  `field_ft_109` tinytext,
  `field_id_110` text NOT NULL,
  `field_ft_110` tinytext,
  `field_id_111` text NOT NULL,
  `field_ft_111` tinytext,
  `field_id_112` text NOT NULL,
  `field_ft_112` tinytext,
  `field_id_113` text NOT NULL,
  `field_ft_113` tinytext,
  `field_id_114` text NOT NULL,
  `field_ft_114` tinytext,
  `field_id_115` text NOT NULL,
  `field_ft_115` tinytext,
  `field_id_116` text NOT NULL,
  `field_ft_116` tinytext,
  `field_id_117` text NOT NULL,
  `field_ft_117` tinytext,
  `field_id_118` text NOT NULL,
  `field_ft_118` tinytext,
  `field_id_119` text NOT NULL,
  `field_ft_119` tinytext,
  `field_id_120` text NOT NULL,
  `field_ft_120` tinytext,
  `field_id_121` text NOT NULL,
  `field_ft_121` tinytext,
  `field_id_122` text NOT NULL,
  `field_ft_122` tinytext,
  `field_id_123` text NOT NULL,
  `field_ft_123` tinytext,
  `field_id_124` text NOT NULL,
  `field_ft_124` tinytext,
  `field_id_125` text NOT NULL,
  `field_ft_125` tinytext,
  `field_id_126` text NOT NULL,
  `field_ft_126` tinytext,
  `field_id_127` text NOT NULL,
  `field_ft_127` tinytext,
  `field_id_128` text NOT NULL,
  `field_ft_128` tinytext,
  `field_id_129` text NOT NULL,
  `field_ft_129` tinytext,
  `field_id_130` text NOT NULL,
  `field_ft_130` tinytext,
  `field_id_131` text NOT NULL,
  `field_ft_131` tinytext,
  `field_id_132` text NOT NULL,
  `field_ft_132` tinytext,
  `field_id_133` text NOT NULL,
  `field_ft_133` tinytext,
  `field_id_134` text NOT NULL,
  `field_ft_134` tinytext,
  `field_id_135` text NOT NULL,
  `field_ft_135` tinytext,
  `field_id_136` text NOT NULL,
  `field_ft_136` tinytext,
  `field_id_137` text NOT NULL,
  `field_ft_137` tinytext,
  `field_id_138` text NOT NULL,
  `field_ft_138` tinytext,
  `field_id_139` text NOT NULL,
  `field_ft_139` tinytext,
  `field_id_140` text NOT NULL,
  `field_ft_140` tinytext,
  `field_id_141` text NOT NULL,
  `field_ft_141` tinytext,
  `field_id_142` text NOT NULL,
  `field_ft_142` tinytext,
  `field_id_143` text NOT NULL,
  `field_ft_143` tinytext,
  `field_id_144` text NOT NULL,
  `field_ft_144` tinytext,
  `field_id_145` text NOT NULL,
  `field_ft_145` tinytext,
  `field_id_146` text NOT NULL,
  `field_ft_146` tinytext,
  `field_id_148` text NOT NULL,
  `field_ft_148` tinytext,
  `field_id_149` text NOT NULL,
  `field_ft_149` tinytext,
  `field_id_150` text NOT NULL,
  `field_ft_150` tinytext,
  `field_id_151` text NOT NULL,
  `field_ft_151` tinytext,
  KEY `entry_id` (`entry_id`),
  KEY `weblog_id` (`weblog_id`),
  KEY `site_id` (`site_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_data` WRITE;
/*!40000 ALTER TABLE `exp_weblog_data` DISABLE KEYS */;
INSERT INTO `exp_weblog_data` (`entry_id`,`site_id`,`weblog_id`,`field_id_71`,`field_ft_71`,`field_id_72`,`field_ft_72`,`field_id_73`,`field_ft_73`,`field_id_74`,`field_ft_74`,`field_id_75`,`field_ft_75`,`field_id_76`,`field_ft_76`,`field_id_77`,`field_ft_77`,`field_id_78`,`field_ft_78`,`field_id_79`,`field_ft_79`,`field_id_81`,`field_ft_81`,`field_id_82`,`field_ft_82`,`field_id_83`,`field_ft_83`,`field_id_84`,`field_ft_84`,`field_id_85`,`field_ft_85`,`field_id_86`,`field_ft_86`,`field_id_87`,`field_ft_87`,`field_id_88`,`field_ft_88`,`field_id_89`,`field_ft_89`,`field_id_90`,`field_ft_90`,`field_id_91`,`field_ft_91`,`field_id_92`,`field_ft_92`,`field_id_93`,`field_ft_93`,`field_id_94`,`field_ft_94`,`field_id_95`,`field_ft_95`,`field_id_96`,`field_ft_96`,`field_id_97`,`field_ft_97`,`field_id_98`,`field_ft_98`,`field_id_99`,`field_ft_99`,`field_id_100`,`field_ft_100`,`field_id_101`,`field_ft_101`,`field_id_102`,`field_ft_102`,`field_id_103`,`field_ft_103`,`field_id_104`,`field_ft_104`,`field_id_105`,`field_ft_105`,`field_id_106`,`field_ft_106`,`field_id_107`,`field_ft_107`,`field_id_108`,`field_ft_108`,`field_id_109`,`field_ft_109`,`field_id_110`,`field_ft_110`,`field_id_111`,`field_ft_111`,`field_id_112`,`field_ft_112`,`field_id_113`,`field_ft_113`,`field_id_114`,`field_ft_114`,`field_id_115`,`field_ft_115`,`field_id_116`,`field_ft_116`,`field_id_117`,`field_ft_117`,`field_id_118`,`field_ft_118`,`field_id_119`,`field_ft_119`,`field_id_120`,`field_ft_120`,`field_id_121`,`field_ft_121`,`field_id_122`,`field_ft_122`,`field_id_123`,`field_ft_123`,`field_id_124`,`field_ft_124`,`field_id_125`,`field_ft_125`,`field_id_126`,`field_ft_126`,`field_id_127`,`field_ft_127`,`field_id_128`,`field_ft_128`,`field_id_129`,`field_ft_129`,`field_id_130`,`field_ft_130`,`field_id_131`,`field_ft_131`,`field_id_132`,`field_ft_132`,`field_id_133`,`field_ft_133`,`field_id_134`,`field_ft_134`,`field_id_135`,`field_ft_135`,`field_id_136`,`field_ft_136`,`field_id_137`,`field_ft_137`,`field_id_138`,`field_ft_138`,`field_id_139`,`field_ft_139`,`field_id_140`,`field_ft_140`,`field_id_141`,`field_ft_141`,`field_id_142`,`field_ft_142`,`field_id_143`,`field_ft_143`,`field_id_144`,`field_ft_144`,`field_id_145`,`field_ft_145`,`field_id_146`,`field_ft_146`,`field_id_148`,`field_ft_148`,`field_id_149`,`field_ft_149`,`field_id_150`,`field_ft_150`,`field_id_151`,`field_ft_151`)
VALUES
	(46,1,18,'',NULL,'',NULL,'',NULL,'',NULL,'1','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(49,1,19,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'19387854','none','This is number one in a series of five videos about the making of the album \"Thirty Six\". Why not take five minutes out of your day and read the article \"The Album ThirtySix: Part One\":http://blog.simoncampbell.com/blog/perma/making_the_album_thirtysix_part_one/ on Simon\'s personal blog.','textile','',NULL,'',NULL,'',NULL,'',NULL,'','textile','','none','','none','','none','','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(48,1,17,'Centenary Centre','none','Peel','none','1301097601','none','http://www.facebook.com/event.php?eid=127886567271836&index=1','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','textile','','none','','none','','none','','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(50,1,23,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'h3. Information collection and use\n\nThis site is owned and run by Supertone Records (hereinafter referred as Supertone) is a trading style of Erskine Corporation; full details can be found on the \"Company details page\":http://erskinedesign.com/docs/company-details/.\n\nSupertone is the sole owner of the information collected on this site. We will not sell, share, or rent this information to others in ways different from what is disclosed in this policy. Supertone collects information from our users at several different points on our website.\n\nh3. Cookies, IP addresses and statistics\n\nA cookie is a piece of data stored on the userâ€™s hard drive containing information about the user. We do not require any form of login or user account for this website. If a user rejects the cookie, they may still use our site.\n\nAn Internet Protocol (IP) address is a numerical identification that your computer or other browsing device sends out. We use cookies and IP addresses to analyse trends, administer the site, track userâ€™s movement, and gather broad demographic information for aggregate use. Cookies and IP addresses are not linked to personally identifiable information.\n\nh3. Your email and contact details\n\nIf you plan to use our Contact form to get in touch with us, be aware that your personal email address will be revealed in our email applications. Your email address will only be used for communication between ourselves and you. Email addresses will not be passed to any third parties. Your email address and any associated contact details delivered by email may be stored on our secure Customer Relations Management system for our internal use. We manage our own web servers too, so your information never passes through a third-party system.\n\nThis website takes every precaution to protect our usersâ€™ information. When users submit sensitive information via the website, your information is protected both online and off-line.\n\nAll of our usersâ€™ information, not just the sensitive information mentioned above, is restricted in our offices. Only employees who need the information to perform a specific job are granted access to personally identifiable information.\n\nAll of our employees are kept up-to-date on our security and privacy practices. Every quarter, as well as any time new policies are added, our employees are notified and/or reminded about the importance we place on privacy, and what they can do to ensure our customersâ€™ information is protected.\n\nFinally, the servers that we store personally identifiable information on are kept in a secure environment, behind a locked cage.\n\nAny personal information entrusted to us will never be entrusted to carriers or the Royal Mail unless agreed, and a signature would always be required from the recipient. Under no circumstances will your private data ever be found on a train and handed to the BBC.\n\nIf you have any questions about the security at our website, you can send an email to [email=artists@supertonerecords.com]artists@supertonerecords.com[/email].\n\nh3. Sharing\n\nSupertone will, under no circumstances, share with any third party individual IP addresses, email addresses, personal contact details or other information collected through this website or related statistic tracking systems. If information sharing is required, such as to bring in a third party in a project for example, you will be given immediate notice.\nExternal links\n\nThis web site contains links to other sites. Please be aware that we at Supertone are not responsible for the privacy practices of such other sites. We encourage our users to be aware when they leave our site and to read the privacy statements of each and every web site that collects personally identifiable information. This privacy policy applies solely to information collected by this web site.\n\nh3. Notification of changes\n\nIf we decide to change our privacy policy, we will post those changes on this page immediately so our users are always aware of what information we collect, how we use it, and what circumstances, if any, we disclose it.\n\nh3. Data Protection\n\nSupertone are registered with the Data Protection Supervisor.','textile','','none','','none','','none','','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(53,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Following a performance at the \"Big Wheel Blues Festival\":http://www.bigwheelblues.com/, Sue Hickling of the \"Nottingham Blues Society\":http://www.nottinghambluessociety.com/, home to the \"British Blues Awards\":http://britishbluesawards.com/, kindly asked my for an interview. Why not \"take a look\":http://www.nottinghambluessociety.com/#/simon-campbell-interview/4541351821/!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(54,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Over the last few years my whole attention has been focussed upon developing my diving skills. I realised about a month ago that I hadnâ€™t played guitar seriously for a few years, missed it and decided to get back to Rock â€˜n Roll! Why not get a cup of tea and \"read of the article\":http://blog.simoncampbell.com/blog/perma/rock_n_roll_is_back/!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(57,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'I have spent 35 years in search of the perfect guitar tone. This is the second in a series of three articles describing the journey to date and how I reached the conclusions about the gear and techniques I now employ. Grab a stiff whisky and \"letâ€™s examine the signal chain from the amplifier to recording console and/or PA\":http://blog.simoncampbell.com/blog/perma/search_for_the_ultimate_tone_part_two/â€¦','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(56,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'I have spent 35 years in search of the perfect guitar tone. This is part one of a series of three articles describing the journey to date and how I reached the conclusions about the gear and techniques I now employ. Grab a beer and \"letâ€™s examine the humble guitar string to just before the amplifier\":http://blog.simoncampbell.com/blog/perma/search_for_the_ultimate_tone_part_one/â€¦','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(58,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'I have spent 35 years in search of the perfect guitar tone. This is the third, and final, in a series of articles describing the journey to date, and how I reached the conclusions about the gear and techniques I now employ. Grab a large brandy and letâ€™s \"reel through the years\":http://blog.simoncampbell.com/blog/perma/search_for_the_ultimate_tone_part_three/â€¦','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(84,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'The very talented, but highly unstable Christian Madden, is live on \"6music tonight\":http://www.bbc.co.uk/programmes/b00ym84d moonlighting with \"King Creosote\":http://www.kingcreosote.com/ and \"The Earlies\":http://en.wikipedia.org/wiki/The_Earlies. Be sure to listen!!! He also played keyboards on the album, is in Simon\'s touring band, and playing at the \"ThirtySix Album Launch\":https://simoncampbell.eventwax.com/thirtysix-launch-event/register/!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Christian-Madden-Mellotron-600.jpg','none','100','none','','none','','none'),
	(60,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'This is the second part documenting the recording of my new album â€˜ThirtySixâ€™. I suggest you grab a take out curry, open an large premium Czech beer and \"read the article\":http://blog.simoncampbell.com/blog/perma/the-album-thirtysix-part-two/. And try not to drop vindaloo in your keyboard.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(61,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Loving the work of Lottie Ray for a really nice piece in the \"Manx Independent\":http://www.iomtoday.co.im/lifestyle/manx-entertainment-news/very_very_bad_man_1_3041618. Thanks to my ace photographer and social documentarian \"Phil Kneen\":http://www.philkneen.com for the pictures.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(62,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Physical tickets are now on sale for the \"ThirtySix launch event\":http://www.facebook.com/SimonCampbellBand#!/event.php?eid=127886567271836&index=1 from Celtic Gold: Peel, Peter Norris Music: Douglas, Shakti Man: Ramsey, Thompson Travel: Port Erin. They are also available \"on-line\":http://simoncampbell.eventwax.com/thirtysix-launch-event/register.\n\nRemember, tickets can be used to obtain Â£1 discount off the purchase of the album ThirtySix and all related merchandise at the launch event. Please note: cash sales only available / Â£1 discount per item.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(63,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Just been asked to do a session with Simon Rae from the lovely \"Truman Falls\":http://www.trumanfalls.co.uk/ the brief being: \"rich tremolo - think Glen Campbell Witchita Lineman solo.\" Fuck yeah...','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(64,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Confirmed: The very wonderful Jacqueline Reid Gilbert and Yvonne Shelton who between them have worked with Oleta Adams, The Beautiful South, Simply Red, George Michael, Heather Small and Gorillaz, will be providing backing vocals for the \"ThirtySix launch\":http://www.facebook.com/SimonCampbellBand#!/event.php?eid=127886567271836 show.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(65,1,17,'The Top Lock','none','Heapy','none','1299715201','none','http://www.facebook.com/event.php?eid=139908746072881','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(66,1,17,'The Bridge Bier Huis','none','Burnley','none','1299801601','none','http://www.facebook.com/event.php?eid=180239972013360','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(67,1,17,'Whittles','none','Oldham','none','1299888001','none','http://www.facebook.com/event.php?eid=154035207983587','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(69,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Simon will be playing guitar in the \"Anna Goldsmith\":http://www.annagoldsmith.com/ Band on Friday February 11th at Paramount City, Douglas. The Charity Band Night is raising funds for the very excellent \"Craig\'s Heartstrong Foundation\":http://www.craigsheartstrongfoundation.co.uk/.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(70,1,19,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'19600437','none','This is number two in a series of five videos about the making of the album \"Thirty Six\". Why not take five minutes out of your day and read the article \"The Album ThirtySix: Part Two\":http://blog.simoncampbell.com/blog/perma/the-album-thirtysix-part-two/ on Simon\'s personal blog. Enjoy!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(71,1,17,'Paramount City','none','Douglas','none','1297382401','none','http://www.facebook.com/event.php?eid=154202141299823','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','textile','','none','','none','','none','','none','','none','','textile','','none','','none','','none','','textile','','none','','none','','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none','','none'),
	(72,1,29,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'&ldquo;ThirtySix&rdquo;','none','Album lands March 26','none','Simon\'s first solo album, ThirtySix, will be released on March 26, 2011.','none','Check out \"ThirtySix\"','none','/thirtysix/','none','thirtysix_release.jpg','none','','none','','none','','none','','none','','none','thirtysix.jpg','none'),
	(73,1,29,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'The making of','none','How ThirtySix came to be','none','Simonâ€™s video interviews about how the album came to be.','none','The Making of ThirtySix','none','http://vimeo.com/19387854','none','thirtysix_making_of.jpg','none','','none','','none','','none','','none','','none','making_of.jpg','none'),
	(74,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Thanks to podcaster Perry Bax for featuring Brother on his \"show\":http://bestradioyouhaveneverheard.com/2011/02/charlies-book-club.html!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none'),
	(75,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Thanks to Neville Hobson for playing \'Brother\' on his \"podcast\":http://www.nevillehobson.com/2011/01/31/the-hobson-and-holtz-report-podcast-584-january-31-2011/!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none'),
	(76,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Thanks to John Gregory for \"the article\":http://www.iomtoday.co.im/lifestyle/manx-entertainment-news/simon_s_search_for_perfect_guitar_tone_1_1745919 in Isle of Man Today about the tone workshop Simon is holding at \"Peter Norris Music\":http://www.peternorrismusic.co.im/','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','','none','','none','','none'),
	(83,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Delighted to announce \"Kevin Whitehead\":http://www.barclayjamesharvest.com/biog.htm#kev (Drums with Barclay James Harvest and Lisa Stansfield), the Islands very own \"Steve Rowe\":http://www.flickr.com/photos/erskinecorp/4875369605/in/set-72157624149401627/ (Bass) and \"Christian Madden\":http://www.flickr.com/photos/erskinecorp/4588740608/in/set-72157623649584217/#/photos/erskinecorp/4588740608/in/set-72157623649584217/lightbox/ (Keyboards with Paul Heaton, The Earlies) of Simon\'s regular touring band will be playing at the \"ThirtySix launch event\":http://www.facebook.com/SimonCampbellBand?v=app_2344061033#!/event.php?eid=127886567271836&index=1. \n\nThey are joined by Nicky Madden (The Earlies and I Am Kloot) on Saxophone, \"Yvonne Shelton\":http://music.simoncampbell.com/journal/the-delta-sisters-confirm-gig/ and \"Jackie Gilbert\":http://music.simoncampbell.com/journal/the-delta-sisters-confirm-gig/. More details to follow. ','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Kevin-Whitehead.png','none','260','none','Kevin Whitehead on drums','none','','none'),
	(82,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Simon has been asked to play guitar on \"David Tyrrell\'s\":http://www.myspace.com/davidtyrrellmusic new solo material. \n\nDavid, who is known for his excellent song writing and rapid vocals, is a well known face on the northern music scene and will be recording the album at Abbey Road Studios with \"Brian Nash\":http://en.wikipedia.org/wiki/Brian_Nash (Frankie Goes to Hollywood) and \"Geoff Pesche\":http://www.discogs.com/artist/Geoff+Pesche (Radiohead, Snoopdog, Kylie).','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'David-Tyrrell-585.jpg','none','260','none','','none','','none'),
	(78,1,19,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'20014332','none','This is a number three in a series of five videos about the making of the album \"Thirty Six\". Here I talk about technology, guitar tone and how I selected the studio to record. Why not take five minutes out of your day, brew some tea and read the article The Album \"ThirtySix: Part Two\":http://blog.simoncampbell.com/blog/perma/the-album-thirtysix-part-two/ on Simonâ€™s personal blog. Enjoy!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none'),
	(79,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Thanks to Stu for playing \'I like it like that\' and \'Preacher\' on his \"Saturday Rock Show\":http://www.manxradio.com/blog.aspx?blog. The tracks were interspersed in his three hour show which features a blend of mix of classic and progressive rock. Good work! \n ','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Stu-Peters.jpg','none','100','none','','none','','none'),
	(80,1,17,'The Albert','none','Douglas','none','1298592001','none','http://www.facebook.com/SimonCampbellBand#!/event.php?eid=153729968016119','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none'),
	(81,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'On Wednesday 23 February at around 8:20pm (GMT), the \"Evening Extra with Bob Harrison\":http://www.manxradio.com/blog.aspx?blogid=23896 will be playing an interview with Simon, plus three tracks from the new album, \"\'ThirtySix\'\":http://music.simoncampbell.com/thirtysix/. Bob\'s show starts at 1830 so tune in or \"listen later\":http://www.manxradio.com/listen.aspx!\n\n','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none','100','none','','none','','none'),
	(85,1,21,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'flight-cases.jpg','none','It always looks arsey when you see names on cases, but in the after gig confusion with multiple bands, it is so easy for your prize amp ending up in the wrong van...','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'','none'),
	(87,1,29,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'&ldquo;Brother&rdquo;','none','Preview the lead single','none','','none','Read more about ThirtySix','none','/thirtysix/','none','thirtysix_brother.jpg','none','/assets/audio/brother.mp3','none','/assets/audio/brother.ogg','none','',NULL,'',NULL,'',NULL,'brother.jpg','none'),
	(88,1,29,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Let&rsquo;s party!','none','Album launch event','none','March 26 will see Simon launch ThirtySix at the Centenary Centre, Peel.','none','Join the event on Facebook','none','http://www.facebook.com/event.php?eid=127886567271836','none','thirtysix_launch.jpg','none','','none','','none','',NULL,'',NULL,'',NULL,'event_promo.jpg','none'),
	(89,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'\"Ben\":http://www.three.fm/ben-sowrey-bio-108231 will be interviewing Simon today \"live\":http://www.three.fm/player on \"3FM\":http://www.three.fm/ at 1230 today. Why not tune in!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Ben-Sowrey.jpg','none','100','none','','none','',NULL),
	(90,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'The \"nominations\":http://www.britishbluesawards.co.uk/nominations.htm are out for the British Blues Awards. This is the first stage in the process and nominations will close on 31st March 2011. The \"Very Very Bad Men\":http://music.simoncampbell.com/journal/more-musicians-confirmed-for-thirtysix-launch/ are: Kevin Whitehead (Drums), Steve Rowe (Bass) and Christian Madden (Keyboards). \"Simon\":http://music.simoncampbell.com/biography/ of course, sings and plays a very mean guitar indeed and is one of the most exciting live performers to be seen anywhere!\n\nNot wishing to influence your decision, but why don\'t you nominate \"Davy Knowles\":http://www.davyknowles.com/ as best overseas artist - he is a cool guy!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'bbalogo8.jpg','none','260','none','','none','',NULL),
	(91,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Designed by Barry Kinder of our favourite design agency, \"Funnel Creative\":http://www.funnelcreative.co.uk/, these beautiful quality shirts have been produced by \"tshirt and sons\":http://www.tshirtandsons.co.uk/, Europe\'s only certified organic textile printer.\n\nThey will be available, along with the album \"ThirtySix\":http://music.simoncampbell.com/thirtysix/, at the \"launch event\":http://www.facebook.com/event.php?eid=127886567271836 and \"online store\":http://music.simoncampbell.com/store/ from March 26th.','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'ThirtySix-tshirt.jpg','none','100','none','','none','',NULL),
	(92,1,29,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'British Blues Awards 2011','none','Nominations for awards','none','Simon has been suggested for the singer and guitarist category.','none','Why not nominate right now!','none','http://music.simoncampbell.com/journal/nominations-for-the-british-blues-awards-2011/','none','blues-awards.jpg','none','','none','','none','',NULL,'',NULL,'',NULL,'blues-sidebar.jpg','none'),
	(93,1,22,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'The \"Raven\'n\'Blues Podcast\":http://www.raven.dj/rnb/ is is a weekly 60 minute show featuring the best in blues. \'Hot as Hell\' from the album \"\'ThirtySix\'\":http://music.simoncampbell.com/thirtysix/ will be played tonight.\n\nThe hugely popular show, which is featured on \"Kansas City Online Radio\":http://www.kconlineradio.com/, \"Talk Radio Europe\":http://www.rodlucas.com/ (FM), the Spanish Costas, Balearics and Tenerife, will be published around 1800 GMT this evening. If you miss it, why not \"download it later\":http://traffic.libsyn.com/raven/rnb0911.mp3!','textile','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'Raven-n-Blues.jpg','none','100','none','','none','',NULL),
	(94,1,18,'',NULL,'',NULL,'',NULL,'',NULL,'1','none','',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL,'',NULL);

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
) ENGINE=MyISAM AUTO_INCREMENT=152 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_fields` WRITE;
/*!40000 ALTER TABLE `exp_weblog_fields` DISABLE KEYS */;
INSERT INTO `exp_weblog_fields` (`field_id`,`site_id`,`group_id`,`field_name`,`field_label`,`field_instructions`,`field_type`,`field_list_items`,`field_pre_populate`,`field_pre_blog_id`,`field_pre_field_id`,`field_related_to`,`field_related_id`,`field_related_orderby`,`field_related_sort`,`field_related_max`,`field_ta_rows`,`field_maxl`,`field_required`,`field_text_direction`,`field_search`,`field_is_hidden`,`field_fmt`,`field_show_fmt`,`field_order`,`ff_settings`)
VALUES
	(71,1,16,'cf_events_venue','Venue','The name of the venue. <strong>Example</strong>: <em>Rock City</em>','text','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',6,''),
	(72,1,16,'cf_events_city','City','','text','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',7,''),
	(73,1,16,'cf_events_date','Date','','ftype_id_13','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',8,'a:2:{s:11:\"date_format\";s:4:\"unix\";s:10:\"year_range\";s:9:\"2011-2020\";}'),
	(74,1,16,'cf_events_fburl','Facebook URL','Copy/paste the Facebook Event URL here.','text','','n',0,0,'blog',16,'title','desc',0,6,128,'y','ltr','n','n','none','n',9,''),
	(75,1,17,'cf_gallery_images','Images','Add images/image data below. To add multiple images, click the <strong>+</strong> button.','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',10,'a:2:{s:8:\"max_rows\";s:0:\"\";s:7:\"col_ids\";a:3:{i:0;s:2:\"24\";i:1;s:2:\"25\";i:2;s:2:\"26\";}}'),
	(76,1,18,'cf_journal_audio_mp3','Audio file (mp3)','Please use an absolute URL rather than relative.','text','','n',0,0,'blog',17,'title','desc',0,6,255,'y','ltr','n','n','none','n',2,''),
	(77,1,18,'cf_journal_audio_lead','Lead text','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','y','n','textile','n',1,''),
	(78,1,19,'cf_journal_videos_vimeo','Vimeo ID','This should just be the 8 digit ID from the Vimeo URL','text','','n',0,0,'blog',17,'title','desc',0,6,8,'y','ltr','n','n','none','n',2,''),
	(79,1,19,'cf_journal_videos_lead','Lead text','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','y','n','textile','n',1,''),
	(81,1,20,'cf_journal_photos_image','Uploaded image','Ideally the photo should be landscape and suitable to be displayed at 585px wide. We\'ll resize it as best we can.','ftype_id_6','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',2,'a:1:{s:7:\"options\";s:2:\"14\";}'),
	(82,1,20,'cf_journal_photos_lead','Lead text','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','y','n','textile','n',1,''),
	(83,1,21,'cf_journal_notes_note','Note','','textarea','','n',0,0,'blog',17,'title','desc',0,10,128,'y','ltr','y','n','textile','n',17,''),
	(84,1,18,'cf_journal_audio_ogg','Audio file (ogg)','Please use an absolute URL rather than relative.','text','','n',0,0,'blog',17,'title','desc',0,6,255,'y','ltr','n','n','none','n',3,''),
	(85,1,22,'cf_pages_body','Page content','','textarea','','n',0,0,'blog',17,'title','desc',0,40,128,'y','ltr','y','n','textile','n',19,''),
	(86,1,18,'cf_journal_audio_fbtitle','Audio title (for Facebook)','This field is required for Facebook sharing.','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',15,''),
	(87,1,18,'cf_journal_audio_fbartist','Audio artist (for Facebook)','This field is required for Facebook sharing.','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',16,''),
	(88,1,18,'cf_journal_audio_fbalbum','Audio album (for Facebook)','This field is required for Facebook sharing.','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',17,''),
	(89,1,23,'cf_products_tshirts_subtitle','Subtitle','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',18,''),
	(90,1,23,'cf_products_tshirts_description','Description','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','textile','n',19,''),
	(91,1,23,'cf_products_tshirts_price','Price','The price without the currency symbol. <em>Example - 9.00</em>','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',20,''),
	(92,1,23,'cf_products_tshirts_shipping','Shipping','The price without the currency symbol. <em>Example - 1.95</em>','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',21,''),
	(93,1,23,'cf_products_tshirts_sizes','Sizes','','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',22,'a:2:{s:8:\"max_rows\";s:1:\"5\";s:7:\"col_ids\";a:2:{i:0;s:2:\"27\";i:1;s:2:\"28\";}}'),
	(94,1,23,'cf_products_tshirts_images','Images','','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',23,'a:2:{s:8:\"max_rows\";s:1:\"5\";s:7:\"col_ids\";a:2:{i:0;s:2:\"29\";i:1;s:2:\"30\";}}'),
	(95,1,24,'cf_products_music_subtitle','Subtitle','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',24,''),
	(96,1,24,'cf_products_music_description','Description','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','textile','n',25,''),
	(97,1,24,'cf_products_music_formats','Format details','Fill in the applicable fields below for each format.','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',26,'a:2:{s:8:\"max_rows\";s:0:\"\";s:7:\"col_ids\";a:6:{i:0;s:2:\"31\";i:1;s:2:\"32\";i:2;s:2:\"33\";i:3;s:2:\"34\";i:4;s:2:\"35\";i:5;s:2:\"36\";}}'),
	(98,1,24,'cf_products_music_images','Images','','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',27,'a:2:{s:8:\"max_rows\";s:1:\"5\";s:7:\"col_ids\";a:2:{i:0;s:2:\"37\";i:1;s:2:\"38\";}}'),
	(99,1,25,'cf_products_posters_subtitle','Subtitle','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',28,''),
	(100,1,25,'cf_products_posters_description','Description','','textarea','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','textile','n',29,''),
	(101,1,25,'cf_products_posters_price','Price','The price without the currency symbol. <em>Example - 9.00</em>','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',30,''),
	(102,1,25,'cf_products_posters_shipping','Shipping','The price without the currency symbol. <em>Example - 1.95</em>','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',31,''),
	(103,1,25,'cf_products_posters_images','Images','','ftype_id_10','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',32,'a:2:{s:8:\"max_rows\";s:1:\"5\";s:7:\"col_ids\";a:2:{i:0;s:2:\"39\";i:1;s:2:\"40\";}}'),
	(104,1,26,'cf_orders_shipping_address','Shipping Address','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',1,''),
	(105,1,26,'cf_orders_shipping_address2','Shipping Address 2','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',2,''),
	(106,1,26,'cf_orders_shipping_option','Shipping Method','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',3,''),
	(107,1,26,'cf_orders_shipping_city','Shipping City','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',4,''),
	(108,1,26,'cf_orders_billing_zip','Billing Zip','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',5,''),
	(109,1,26,'cf_orders_shipping_first_name','Shipping First Name','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',6,''),
	(110,1,26,'cf_orders_shipping_last_name','Shipping Last Name','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',7,''),
	(111,1,26,'cf_orders_billing_state','Billing State','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',8,''),
	(112,1,26,'cf_orders_billing_address','Billing Address','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',9,''),
	(113,1,26,'cf_orders_billing_city','Billing City','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',10,''),
	(114,1,26,'cf_orders_billing_address2','Billing Address 2','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',11,''),
	(115,1,26,'cf_orders_billing_last_name','Billing Last Name','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',12,''),
	(116,1,26,'cf_orders_billing_first_name','Billing First Name','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',13,''),
	(117,1,26,'cf_orders_transaction_id','Transaction ID','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',14,''),
	(118,1,26,'cf_orders_customer_email','Customer Email','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',15,''),
	(119,1,26,'cf_orders_customer_phone','Customer Phone','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',16,''),
	(120,1,26,'cf_orders_shipping_state','Shipping State','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',17,''),
	(121,1,26,'cf_orders_shipping_zip','Shipping Zip','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',18,''),
	(122,1,26,'cf_orders_subtotal','Subtotal','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',19,''),
	(123,1,26,'cf_orders_tax','Tax','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',20,''),
	(124,1,26,'cf_orders_shipping','Shipping Cost','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',21,''),
	(125,1,26,'cf_orders_total','Total','','text','','n',0,0,'blog',17,'date','desc',0,8,128,'n','ltr','n','n','none','n',22,''),
	(126,1,26,'cf_orders_items','Items','','ct_items','','n',0,0,'blog',26,'date','desc',0,8,0,'n','ltr','n','n','none','n',23,''),
	(127,1,26,'cf_orders_coupons','Coupons','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',24,''),
	(128,1,26,'cf_orders_last_four','CC Last Four Digits','','text','','n',0,0,'blog',17,'title','desc',0,6,4,'n','ltr','n','n','none','n',25,''),
	(129,1,26,'cf_orders_error_message','Error Message','','text','','n',0,0,'blog',17,'title','desc',0,6,255,'n','ltr','n','n','none','n',26,''),
	(130,1,27,'cf_purchased_id','ID','','text','','n',0,0,'blog',26,'title','desc',0,6,128,'n','ltr','n','n','none','n',1,''),
	(131,1,27,'cf_purchased_quantity','Quantity','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',2,''),
	(132,1,27,'cf_purchased_price','Price','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',3,''),
	(133,1,27,'cf_purchased_order_id','Order Id','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',4,''),
	(134,1,27,'cf_purchased_product_download','Product Download URL','This is the filename of the downloadable product. ','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',5,''),
	(135,1,26,'cf_orders_billing_country','Billing Country','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',64,''),
	(136,1,26,'cf_orders_billing_countrycode','Billing Country Code','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',65,''),
	(137,1,26,'cf_orders_shipping_country','Shipping Country','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',66,''),
	(138,1,26,'cf_orders_shipping_countrycode','Shipping Country Code','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',67,''),
	(139,1,28,'cf_features_title','Title','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',2,''),
	(140,1,28,'cf_features_subtitle','Sub-title','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',3,''),
	(141,1,28,'cf_features_lead','Lead-in text','This isn\'t used or displayed for audio entries.','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',4,''),
	(142,1,28,'cf_features_link_label','Link label','i.e. Check out \"ThirtySix\"','text','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',5,''),
	(143,1,28,'cf_features_link_url','Link URL','i.e. /thirtysix/','text','','n',0,0,'blog',17,'title','desc',0,6,255,'y','ltr','n','n','none','n',6,''),
	(144,1,28,'cf_features_image','Background image','This image will be resized to 640x236 and 60x38.','ftype_id_6','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',7,'a:1:{s:7:\"options\";s:2:\"22\";}'),
	(145,1,28,'cf_features_audio_mp3','Audio: MP3 file','Paste the URL to the file.','text','','n',0,0,'blog',17,'title','desc',0,6,255,'n','ltr','n','n','none','n',10,''),
	(146,1,28,'cf_features_audio_ogg','Audio: Ogg file','Paste the URL to the file.','text','','n',0,0,'blog',17,'title','desc',0,6,255,'n','ltr','n','n','none','n',9,''),
	(148,1,21,'cf_journal_notes_image','Supporting image','','ftype_id_6','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',77,'a:1:{s:7:\"options\";s:2:\"14\";}'),
	(149,1,21,'cf_journal_notes_image_size','Supporting image: size','','ftype_id_7','','n',0,0,'blog',17,'title','desc',0,6,128,'y','ltr','n','n','none','n',78,'a:1:{s:7:\"options\";a:2:{i:100;s:5:\"Small\";i:260;s:6:\"Medium\";}}'),
	(150,1,21,'cf_journal_notes_image_caption','Supporting image: caption','','text','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',79,''),
	(151,1,28,'cf_features_sidebar_image','Sidebar image','This image will be resized to 300px wide and displayed in the sidebar if the content is featured.','ftype_id_6','','n',0,0,'blog',17,'title','desc',0,6,128,'n','ltr','n','n','none','n',8,'a:1:{s:7:\"options\";s:2:\"22\";}');

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
	(6,19),
	(6,21),
	(6,22),
	(6,20),
	(6,29),
	(6,18),
	(6,17),
	(6,23);

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
) ENGINE=MyISAM AUTO_INCREMENT=95 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblog_titles` WRITE;
/*!40000 ALTER TABLE `exp_weblog_titles` DISABLE KEYS */;
INSERT INTO `exp_weblog_titles` (`entry_id`,`site_id`,`weblog_id`,`author_id`,`pentry_id`,`forum_topic_id`,`ip_address`,`title`,`url_title`,`status`,`versioning_enabled`,`view_count_one`,`view_count_two`,`view_count_three`,`view_count_four`,`allow_comments`,`allow_trackbacks`,`sticky`,`entry_date`,`dst_enabled`,`year`,`month`,`day`,`expiration_date`,`comment_expiration_date`,`edit_date`,`recent_comment_date`,`comment_total`,`trackback_total`,`sent_trackbacks`,`recent_trackback_date`)
VALUES
	(49,1,19,1,0,0,'92.39.196.149','Making the album ThirtySix: edition #1','making-the-album-thirtysix-edition-1','open','y',0,0,0,0,'y','n','n',1296656232,'n','2011','02','02',0,0,20110205115213,0,0,0,'',0),
	(46,1,18,1,0,0,'88.97.41.226','General set','gallery','open','y',0,0,0,0,'y','n','n',1296646767,'n','2011','02','02',0,0,20110203095928,0,0,0,'',0),
	(48,1,17,1,0,0,'88.97.41.224','ThirtySix Album Launch','thirtysix-album-launch','open','y',0,0,0,0,'y','n','n',1296655672,'n','2011','02','02',1301138092,0,20110224111453,0,0,0,'',0),
	(50,1,23,1,0,0,'88.97.41.226','Privacy policy','privacy-policy','open','y',0,0,0,0,'y','n','n',1296658583,'n','2011','02','02',0,0,20110202164724,0,0,0,'',0),
	(53,1,22,19,0,0,'92.39.196.149','OK Simon, what do you think?','ok-simon-what-do-you-think','open','y',0,0,0,0,'y','n','n',1274977497,'n','2010','05','27',0,0,20110204164558,0,0,0,'',0),
	(54,1,22,19,0,0,'92.39.196.149','Rock â€˜n roll is back','rock-n-roll-is-back','open','y',0,0,0,0,'y','n','n',1246466778,'n','2009','07','01',0,0,20110204165119,0,0,0,'',0),
	(57,1,22,19,0,0,'92.39.196.149','Search for the ultimate tone: part two','search-for-the-ultimate-tone-part-two','open','y',0,0,0,0,'y','n','n',1259600514,'n','2009','11','30',0,0,20110204170256,0,0,0,'',0),
	(56,1,22,19,0,0,'92.39.196.149','Search for the ultimate tone: part one','search-for-the-ultimate-tone-part-one','open','y',0,0,0,0,'y','n','n',1257008353,'n','2009','10','31',0,0,20110204170015,0,0,0,'',0),
	(58,1,22,19,0,0,'92.39.196.149','Search for the ultimate tone: part three','search-for-the-ultimate-tone-part-three','open','y',0,0,0,0,'y','n','n',1264957465,'n','2010','01','31',0,0,20110204170526,0,0,0,'',0),
	(60,1,22,19,0,0,'92.39.196.149','Making ThirtySix: part two','making-thirtysix-part-two','open','y',0,0,0,0,'y','n','n',1277917787,'n','2010','06','30',0,0,20110204171348,0,0,0,'',0),
	(61,1,22,19,0,0,'92.39.196.149','We love the Manx Independent','we-love-the-manx-independent','open','y',0,0,0,0,'y','n','n',1296839660,'n','2011','02','04',0,0,20110204172321,0,0,0,'',0),
	(62,1,22,19,0,0,'92.39.196.149','Tickets on sale now!','tickets-on-sale-now','open','y',0,0,0,0,'y','n','n',1296840433,'n','2011','02','04',0,0,20110205140914,0,0,0,'',0),
	(63,1,22,19,0,0,'92.39.196.149','New session for Truman Falls','new-session-for-truman-falls','open','y',0,0,0,0,'y','n','n',1295199010,'n','2011','01','16',0,0,20110204173411,0,0,0,'',0),
	(64,1,22,19,0,0,'92.39.196.149','The Delta Sisters confirm gig','the-delta-sisters-confirm-gig','open','y',0,0,0,0,'y','n','n',1294940152,'n','2011','01','13',0,0,20110204174253,0,0,0,'',0),
	(65,1,17,19,0,0,'88.97.41.224','Pre launch warm up','pre-launch-warm-up','open','y',0,0,0,0,'y','n','n',1296842922,'n','2011','02','04',1299755682,0,20110224111443,0,0,0,'',0),
	(66,1,17,19,0,0,'88.97.41.224','Pre launch warm up','p','open','y',0,0,0,0,'y','n','n',1296844592,'n','2011','02','04',1299842072,0,20110224111433,0,0,0,'',0),
	(67,1,17,19,0,0,'88.97.41.224','Pre launch warm up','p1','open','y',0,0,0,0,'y','n','n',1296846066,'n','2011','02','04',1299928386,0,20110224111407,0,0,0,'',0),
	(83,1,22,1,0,0,'88.97.41.226','More musicians confirmed for ThirtySix launch','more-musicians-confirmed-for-thirtysix-launch','open','y',0,0,0,0,'y','n','n',1297007216,'n','2011','02','06',0,0,20110222154757,0,0,0,'',0),
	(69,1,22,19,0,0,'92.39.196.149','Anna Goldsmith Band plays for Craig\'s Heartstrong Foundation','anna-goldsmith-band-plays-for-craigs-heartstrong-foundation','open','y',0,0,0,0,'y','n','n',1297034505,'n','2011','02','06',0,0,20110206233546,0,0,0,'',0),
	(70,1,19,19,0,0,'92.39.196.149','Making the album ThirtySix: edition #2','making-the-album-thirtysix-edition-2','open','y',0,0,0,0,'y','n','n',1297416646,'n','2011','02','11',0,0,20110208094547,0,0,0,'',0),
	(71,1,17,19,0,0,'88.97.41.224','Acoustic set for Craigs Heartstrong Foundation','acoustic-set-for-craigs-heartstrong-foundation','open','y',0,0,0,0,'y','n','n',1297329234,'n','2011','02','10',1297422834,0,20110224111356,0,0,0,'',0),
	(72,1,29,1,0,0,'88.97.41.224','ThirtySix release','thirtysix-album-launch','open','y',0,0,0,0,'n','n','n',1297939702,'n','2011','02','17',0,0,20110224142023,0,0,0,'',0),
	(73,1,29,1,0,0,'88.97.41.224','The making of ThirtySix','the-making-of-thirtysix','open','y',0,0,0,0,'n','n','n',1297939881,'n','2011','02','17',0,0,20110224103122,0,0,0,'',0),
	(74,1,22,19,0,0,'92.39.196.149','Best Radio You Have Never Heard','best-radio-you-have-never-heard','open','y',0,0,0,0,'y','n','n',1297767766,'n','2011','02','15',0,0,20110217111647,0,0,0,'',0),
	(75,1,22,19,0,0,'92.39.196.149','Hobson and Holtz Report','hobson-and-holtz-report','open','y',0,0,0,0,'y','n','n',1296472368,'n','2011','01','31',0,0,20110217111549,0,0,0,'',0),
	(76,1,22,19,0,0,'92.39.196.149','Tone Workshop','tone-workshop','open','y',0,0,0,0,'y','n','n',1269006482,'n','2010','03','19',0,0,20110217135203,0,0,0,'',0),
	(82,1,22,1,0,0,'88.97.41.226','Sessions with David Tyrrell','sessions-with-david-tyrrell','open','y',0,0,0,0,'y','n','n',1297957512,'n','2011','02','17',0,0,20110222154613,0,0,0,'',0),
	(78,1,19,19,0,0,'92.39.196.149','Making the album ThirtySix: edition #3','making-the-album-thirtysix-edition-3','open','y',0,0,0,0,'y','n','n',1298285110,'n','2011','02','21',0,0,20110221105011,0,0,0,'',0),
	(79,1,22,19,0,0,'92.39.196.149','Stu Peters plays \'ThirtySix\' on Manx Radio','stu-peters-plays-thirtysix-on-manx-radio','open','y',0,0,0,0,'y','n','n',1298127079,'n','2011','02','19',0,0,20110222134620,0,0,0,'',0),
	(80,1,17,19,0,0,'88.97.41.224','Acoustic set for the Live Lounge','acoustic-set-for-the-live-lounge','open','y',0,0,0,0,'y','n','n',1298302664,'n','2011','02','21',1298632424,0,20110224111346,0,0,0,'',0),
	(81,1,22,19,0,0,'92.39.196.149','Interview with Bob Harrison on Manx Radio','interview-with-bob-harrison-on-manx-radio','open','y',0,0,0,0,'y','n','n',1298380236,'n','2011','02','22',0,0,20110222134737,0,0,0,'',0),
	(84,1,22,19,0,0,'92.39.196.149','Christian Madden of King Creosote and The Earlies on 6Music','christian-madden-king-kreosote-and-the-earlies-on-6music','open','y',0,0,0,0,'y','n','n',1298394477,'n','2011','02','22',0,0,20110222182758,0,0,0,'',0),
	(85,1,21,19,0,0,'92.39.196.149','Gentleman, prepare to tour','gentleman-prepare-to-tour','open','y',0,0,0,0,'y','n','n',1298460974,'n','2011','02','23',0,0,20110223114815,0,0,0,'',0),
	(87,1,29,1,0,0,'88.97.41.224','Preview &ldquo;Brother&rdquo;','preview-brother','open','y',0,0,0,0,'n','n','n',1298472970,'n','2011','02','23',0,0,20110224103111,0,0,0,'',0),
	(88,1,29,1,0,0,'88.97.41.224','Album launch event','album-launch-event','open','y',0,0,0,0,'n','n','n',1298473138,'n','2011','02','23',0,0,20110224142059,0,0,0,'',0),
	(89,1,22,19,0,0,'92.39.196.149','Interview with Ben Sowrey at 3FM','interview-with-ben-sowrey-at-3fm','open','y',0,0,0,0,'y','n','n',1298545172,'n','2011','02','24',0,0,20110224113034,0,0,0,'',0),
	(90,1,22,19,0,0,'92.39.196.149','Nominations for the British Blues Awards 2011','nominations-for-the-british-blues-awards-2011','open','y',0,0,0,0,'y','n','n',1298564823,'n','2011','02','24',0,0,20110225092304,0,0,0,'',0),
	(91,1,22,19,0,0,'92.39.196.149','ThirtySix t-shirts have arrived!','thirtysix-t-shirts-have-arrived','open','y',0,0,0,0,'y','n','n',1298595625,'n','2011','02','25',0,0,20110225020126,0,0,0,'',0),
	(92,1,29,7,0,0,'92.39.196.149','British Blues Awards','british-blues-awards','open','y',0,0,0,0,'n','n','n',1298635379,'n','2011','02','25',0,0,20110225162200,0,0,0,'',0),
	(93,1,22,19,0,0,'92.39.196.149','Raven \'n Blues','raven-n-blues','open','y',0,0,0,0,'y','n','n',1298602811,'n','2011','02','25',0,0,20110227085212,0,0,0,'',0),
	(94,1,18,7,0,0,'88.97.41.224','Recording ThirtySix','recording-thirtysix','open','y',0,0,0,0,'y','n','n',1298900887,'n','2011','02','28',0,0,20110228135108,0,0,0,'',0);

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
) ENGINE=MyISAM AUTO_INCREMENT=30 DEFAULT CHARSET=latin1;

LOCK TABLES `exp_weblogs` WRITE;
/*!40000 ALTER TABLE `exp_weblogs` DISABLE KEYS */;
INSERT INTO `exp_weblogs` (`weblog_id`,`site_id`,`is_user_blog`,`blog_name`,`blog_title`,`blog_url`,`blog_description`,`blog_lang`,`blog_encoding`,`total_entries`,`total_comments`,`total_trackbacks`,`last_entry_date`,`last_comment_date`,`last_trackback_date`,`cat_group`,`status_group`,`deft_status`,`field_group`,`search_excerpt`,`enable_trackbacks`,`trackback_use_url_title`,`trackback_max_hits`,`trackback_field`,`deft_category`,`deft_comments`,`deft_trackbacks`,`weblog_require_membership`,`weblog_max_chars`,`weblog_html_formatting`,`weblog_allow_img_urls`,`weblog_auto_link_urls`,`weblog_notify`,`weblog_notify_emails`,`comment_url`,`comment_system_enabled`,`comment_require_membership`,`comment_use_captcha`,`comment_moderate`,`comment_max_chars`,`comment_timelock`,`comment_require_email`,`comment_text_formatting`,`comment_html_formatting`,`comment_allow_img_urls`,`comment_auto_link_urls`,`comment_notify`,`comment_notify_authors`,`comment_notify_emails`,`comment_expiration`,`search_results_url`,`tb_return_url`,`ping_return_url`,`show_url_title`,`trackback_system_enabled`,`show_trackback_field`,`trackback_use_captcha`,`show_ping_cluster`,`show_options_cluster`,`show_button_cluster`,`show_forum_cluster`,`show_pages_cluster`,`show_show_all_cluster`,`show_author_menu`,`show_status_menu`,`show_categories_menu`,`show_date_menu`,`rss_url`,`enable_versioning`,`enable_qucksave_versioning`,`max_revisions`,`default_entry_title`,`url_title_prefix`,`live_look_template`)
VALUES
	(17,1,'n','events','Events','/events/','','en','utf-8',5,0,0,1298302664,0,0,'',1,'open',16,0,'n','n',5,71,'','y','n','y',0,'all','y','n','n','','/events/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','n','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',0),
	(18,1,'n','gallery','Gallery','/gallery/','','en','utf-8',2,0,0,1298900887,0,0,'',1,'open',17,0,'n','n',5,75,'','y','n','y',0,'all','y','n','n','','/gallery/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','n','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',0),
	(19,1,'n','journal_videos','Journal: Videos','/journal/','','en','utf-8',3,0,0,1298285110,0,0,'',1,'open',19,79,'n','n',5,78,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(20,1,'n','journal_audio','Journal: Audio','/journal/','','en','utf-8',0,0,0,0,0,0,'',1,'open',18,77,'n','n',5,76,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(21,1,'n','journal_photos','Journal: Photos','/journal/','','en','utf-8',1,0,0,1298460974,0,0,'',1,'open',20,82,'n','n',5,81,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(22,1,'n','journal_notes','Journal: Notes','/journal/','','en','utf-8',23,0,0,1298602811,0,0,'',1,'open',21,83,'n','n',5,83,'','y','n','y',0,'all','y','n','n','','/journal/','y','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','y','','n','n',10,'','',111),
	(23,1,'n','pages','Site pages (privacy policy, etc)','/pages/','','en','utf-8',1,0,0,1296658583,0,0,'',1,'open',22,77,'n','n',5,76,'','y','n','y',0,'all','y','n','n','','/pages/','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','n','y','n','n','','n','n',10,'','',111),
	(24,1,'n','products_tshirts','Products: T-shirts','/store/','','en','utf-8',0,0,0,0,0,0,'',1,'open',23,0,'n','n',5,89,'','y','y','y',0,'all','y','y','n','','','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','y','y','n','y','','n','n',10,'','',0),
	(25,1,'n','products_music','Products: Music','/store/','','en','utf-8',0,0,0,0,0,0,'',1,'open',24,0,'n','n',5,89,'','y','y','y',0,'all','y','y','n','','','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','y','y','n','y','','n','n',10,'','',0),
	(26,1,'n','products_posters','Products: Posters','/store/','','en','utf-8',0,0,0,0,0,0,'',1,'open',25,0,'n','n',5,89,'','y','y','y',0,'all','y','y','n','','','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','n','n','y','y','n','y','y','n','y','','n','n',10,'','',0),
	(27,1,'n','orders','Orders','','','en','utf-8',0,0,0,0,0,0,'',2,'open',26,0,'n','n',5,104,'','y','y','y',0,'all','y','n','n','','','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','n','n','n','n','n','n','n','n','n','n','y','y','n','y','','n','n',10,'','',0),
	(28,1,'n','purchased_items','Purchased Items','','','en','utf-8',0,0,0,0,0,0,'1',1,'open',27,0,'n','n',5,130,'','y','y','y',0,'all','y','n','n','','','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','y','n','n','n','n','y','n','n','n','n','y','y','n','y','','n','n',10,'','',0),
	(29,1,'n','homepage_features','Homepage features','','','en','utf-8',5,0,0,1298635379,0,0,'',1,'open',28,0,'n','n',5,139,'','n','n','y',0,'all','y','n','n','','','n','n','n','n',0,0,'y','xhtml','safe','n','y','n','n','',0,'','','','n','n','n','n','n','n','n','y','y','n','n','y','n','n','','n','n',10,'','',119);

/*!40000 ALTER TABLE `exp_weblogs` ENABLE KEYS */;
UNLOCK TABLES;





/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
