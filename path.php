<?php

// ------------------------------------------------------
// DO NOT ALTER THIS FILE UNLESS YOU HAVE A REASON TO

// ------------------------------------------------------
// Path to the directory containing your backend files

$system_path = "./manage/";

// ------------------------------------------------------
// MANUALLY CONFIGURABLE VARIABLES
// See user guide for more information
// ------------------------------------------------------

$template_group = "";
$template = "";
$site_url = "";
$site_index = "";
$site_404 = "";

/* GLOBAL PATH.PHP VARIABLES
-------------------------------------------------*/

$global_vars = array();

/* PATHS */
$global_vars['pv_site_url'] 	    = "";
$global_vars['pv_assets_url'] 	    = "/assets";

/* GENERAL */
$global_vars['pv_last_segment'] 	= getLastSegment($uri);
$global_vars['pv_all_segments'] 	= $uri;


/* DISABLE PARAMETER */
$global_vars['pv_disable_default']  = 'categories|trackbacks|pagination|member_data';
$global_vars['pv_disable_titles']   = 'categories|custom_fields|member_data|pagination|trackbacks';


/* DATE FORMATTING */
$global_vars['pv_date_event'] 		= '%j %M, %Y';
$global_vars['pv_date_journal'] 	= '%d-%m-%y';


/* PAGE TYPES */
$global_vars['pv_pagination_page'] 	= (preg_match("#^P(\d+)|/P(\d+)#", $uri)) ? 'yes' : 'no';


/* DATES IN URLS */
$global_vars['pv_day_segment'] 		= getDateFromURI($uri, 'day');
$global_vars['pv_month_segment'] 	= getDateFromURI($uri, 'month');
$global_vars['pv_year_segment'] 	= getDateFromURI($uri, 'year');


/* FUNCTIONS */
function getDateFromURI($uri, $get = 'year')
{
	$year	= "";
	$month	= "";
	$day	= "";
	
	// do we match year/month/date (2009/04/27)
	if (preg_match("#(^|\/)(\d{4}/\d{2}/\d{2})(\/|$)#", $uri, $match))
	{
		$ex = explode('/', $match[2]);

		$year	= $ex[0];
		$month	= $ex[1];
		$day	= $ex[2];

	} // or do we match year/month (2009/04)
	elseif (preg_match("#(^|\/)(\d{4}/\d{2})(\/|$)#", $uri, $match))
	{
		$ex = explode('/', $match[2]);

		$year	= $ex[0];
		$month	= $ex[1];

	} // or do we match just year (2009)
	elseif (preg_match("#(^|\/)(\d{4})(\/|$)#", $uri, $match))
	{
		$ex = explode('/', $match[2]);

		$year	= $ex[0];

	}

    switch($get) { 
        case "day": 
            return $day;
            break; 
        case "month": 
            return $month;
            break; 
        default: 
            return $year;
    }
}

/*
 * http://loweblog.com/freelance/article/last-segment-a-global-variable/
 */
function getLastSegment($uri)
{
 	if (!strlen($uri)) return '';

 	if (substr($uri,-1,1) == '/')
 	{
  		$uri = substr($uri,0,-1);
 	}

 	return substr($uri,(strrpos($uri, '/')+1));
}

?>