<?php

if ( ! defined('EXT')){
exit('Invalid file request');
}

$conf['app_version'] = "169";
$conf['license_number'] = "";
$conf['debug'] = "1";
$conf['install_lock'] = "1";
$conf['db_hostname'] = "127.0.0.1";
$conf['db_username'] = "username";
$conf['db_password'] = "password";
$conf['db_name'] = "database-name";
$conf['db_type'] = "mysql";
$conf['db_prefix'] = "exp";
$conf['db_conntype'] = "0";
$conf['system_folder'] = "manage";
$conf['doc_url'] = "http://expressionengine.com/docs/";
$conf['cookie_prefix'] = "";
$conf['is_system_on'] = "y";
$conf['allow_extensions'] = "y";
$conf['multiple_sites_enabled'] = "n";

/* General
-------------------------------------------------------------------*/
$conf['site_index'] = "";
$conf['site_url'] = "";
$conf['document_root'] = "";
$conf['server_path'] = $conf['document_root'];
$conf['cp_url'] = $conf['site_url']."/".$conf['system_folder'];


/* Member directory paths and urls
-------------------------------------------------------------------*/
$conf['avatar_url'] = $conf['site_url']."/uploads/system/avatars/";
$conf['avatar_path'] = $conf['server_path']."/uploads/system/avatars/";
$conf['photo_url'] = $conf['site_url']."/uploads/system/member_photos/";
$conf['photo_path'] = $conf['server_path']."/uploads/system/member_photos/";
$conf['sig_img_url'] = $conf['site_url']."/uploads/system/signature_attachments/";
$conf['sig_img_path'] = $conf['server_path']."/uploads/system/signature_attachments/";
$conf['prv_msg_upload_path'] = $conf['server_path']."/uploads/system/pm_attachments/";


/* Misc directory paths and urls
-------------------------------------------------------------------*/
$conf['theme_folder_path'] = $conf['server_path']."/themes/";
$conf['theme_folder_url'] = $conf['site_url']."/themes/";
$conf['captcha_path'] = $conf['server_path']."/images/captchas/";
$conf['captcha_url'] = $conf['site_url']."/images/captchas/";
$conf['emoticon_path'] = $conf['site_url']."/uploads/system/smileys/";
$conf['enable_emoticons'] = "n";


/* Extreme traffic options - http://expressionengine.com/docs/general/handling_extreme_traffic.html
-------------------------------------------------------------------*/

$conf['enable_online_user_tracking'] = "n";	// (y/n) - Corresponds to Enable Online User Tracking
$conf['enable_hit_tracking'] = "n";	// (y/n) - Corresponds to Enable Template Hit Tracking
$conf['enable_entry_view_tracking']	= "n"; // (y/n) - Corresponds to Enable Weblog Entry View Tracking
$conf['log_referrers']	= "n"; // (y/n) - Corresponds to Enable Referrer Logging?
$conf['dynamic_tracking_disabling']	=""; // (numeric) - Corresponds to Suspend ALL tracking when number of online visitors exceeds:
$conf['disable_all_tracking'] = "n";  // (y/n) - Emergency preference which when set to 'y' will disable all of the above. 


/* Templates Preferences
-------------------------------------------------------------------*/
$conf['save_tmpl_files'] = "y";
$conf['tmpl_file_basepath'] = $conf['server_path']."/assets/templates/";
$conf['site_404'] = "404/index";
$conf['strict_urls'] = "n";


/* Global Channel Preferences
-------------------------------------------------------------------*/
$conf['use_category_name'] = "y";
$conf['reserved_category_word'] = "category";
$conf['word_separator'] = "dash";
$conf['enable_image_resizing'] = "n";
$conf['auto_convert_high_ascii'] = "n";


/* Member Preferences
-------------------------------------------------------------------*/
$conf['profile_trigger'] = "asdgasrtq42rafasfdg";


/* Cookie settings
-------------------------------------------------------------------*/
$conf['cookie_path'] = "";
$conf['cookie_domain'] = "";
$conf['cookie_prefix'] = "";
$conf['user_session_type'] = "c";
$conf['admin_session_type'] = "cs";


/* Enable some hidden variables - http://expressionengine.com/wiki/Hidden_Configuration_Variables/
-------------------------------------------------------------------*/
$conf['weblog_nomenclature'] = "channel";
$conf['hidden_template_indicator'] = "_";
$conf['protect_javascript'] = "y";


/* Fieldframe settings
--------------------------------------------------------------------*/
$conf['ft_path'] = $conf['server_path']."/".$conf['system_folder']."/extensions/fieldtypes/";
$conf['ft_url'] = $conf['cp_url']."/extensions/fieldtypes/";


/* Image Resizer Settings
--------------------------------------------------------------------*/
$conf['ed_server_path'] = $conf['server_path'];
$conf['ed_cache_path'] = $conf['server_path'].'/uploads/images/resizer_cache/';


/* User Module settings
--------------------------------------------------------------------*/
$conf['user_module_key_expiration'] = "30";
?>