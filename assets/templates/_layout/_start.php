<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

<!-- TITLE and META -->
{exp:lg_better_meta_pl:template
    entry_id="{embed:entry_id}"
    weblog_id="{embed:weblog_id}"
    url_title="{embed:url_title}"
    title="{embed:title}"
    title_suffix="{embed:title_suffix}"
    title_prefix="{embed:title_prefix}"
    hide_site_title="{embed:hide_site_title}"
    description="{embed:description}"
    keywords="{embed:keywords}"
    author="{embed:author}"
    publisher="{embed:publisher}"
    rights="{embed:rights}"
    date_created="{embed:date_created}"
    date_modified="{embed:date_modified}"
    date_valid="{embed:date_valid}"
    identifier="{embed:identifier}"
    robots_index="{embed:robots_index}"
    robots_follow="{embed:robots_follow}"
    robots_archive="{embed:robots_archive}"
    canonical_url="{embed:canonical_url}"
    region="{embed:region}"
    placename="{embed:placename}"
    latitude="{embed:latitude}"
    longitude="{embed:longitude}"
}

<!-- CSS -->
<link href="{pv_assets_url}/css/screen.css" type="text/css" rel="stylesheet" media="screen" />
<!--[if lt IE 7]><link href="{pv_assets_url}/css/min/screen_ie-lt7.min.css" rel="stylesheet" media="screen" /><![endif]-->
<!--[if lt IE 8]><link href="{pv_assets_url}/css/min/screen_ie-lt8.min.css" rel="stylesheet" media="screen" /><![endif]-->
<!--[if lt IE 9]><link href="{pv_assets_url}/css/min/screen_ie-lt9.min.css" rel="stylesheet" media="screen" /><![endif]-->
<link href="{pv_assets_url}/css/print.css" type="text/css" rel="stylesheet" media="print" />

<!-- JS -->
<!-- include jQuery from Google, fallback to local -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<script>!window.jQuery && document.write('<script src="{pv_assets_url}/js/min/jquery-1.4.4.min.js"><\/script>')</script>


<!--[if IE 6]>
<script type="text/javascript" src="{pv_assets_url}/js/ie6/ie6.js"></script>
<script type="text/javascript" src="{pv_assets_url}/js/ie6/_0_DD_belatedPNG_0.0.8a.js"></script>
<![endif]-->

<!-- RSS -->

<!-- FAVICON -->
<link rel="shortcut icon" href="{pv_assets_url}/images/site/favicon.ico" type="image/ico" />
<link rel="apple-touch-icon" href="{pv_assets_url}/images/site/apple_touch-icon.png" />
<link rel="apple-touch-startup-image" href="{pv_assets_url}/images/site/apple_touch-startup.png" />

</head>	

<body{if embed:body_class != ""} class="{embed:body_class}"{/if}{if embed:body_id != ""} id="{embed:body_id}"{/if}>

<ul id="nav_access">
    <li><a href="#navigation_pri">Skip to navigation</a></li>
    <li><a href="#content_wrapper">Skip to content</a></li>
</ul>

<!-- PAGE -->
<div id="page">