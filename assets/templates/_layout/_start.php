<!DOCTYPE html>
<html lang="en">

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
    <link href="{pv_assets_url}/css/screen.css" rel="stylesheet" media="screen" />
    <link href="{pv_assets_url}/css/campbell-nav.css" rel="stylesheet" media="screen" />
    
    <!--[if lte IE 7]><link href="{pv_assets_url}/css/screen_ie.css" rel="stylesheet" media="screen" /><![endif]-->
    <!--[if IE 8]><link href="{pv_assets_url}/css/screen_ie8.css" rel="stylesheet" media="screen" /><![endif]-->
        
    <!-- ICONS -->
    <link rel="shortcut icon" href="{pv_assets_url}/images/site/icons/favicon.png"/>
    <link rel="apple-touch-icon" href="{pv_assets_url}/images/site/icons/apple_touch-icon.png" />
    <link rel="apple-touch-startup-image" href="{pv_assets_url}/images/site/icons/apple_touch-startup.png" />
    
    <!-- JAVASCRIPT -->
    <!--[if !IE 6]>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
    <script src="{pv_assets_url}/js/onload.js"></script>
    <![endif]-->
    <script src="{pv_assets_url}/jwplayer/jwplayer.js"></script>
    
    <!--[if IE 6]>
        <script src="{pv_assets_url}/js/ie6/DD_belatedPNG_0.0.8a.js"></script>
        <script>
            DD_belatedPNG.fix('.title, div#navigation_network ul li a');
        </script>
    <![endif]-->
    
    <!-- iOS -->
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    
    {if ev_environment == "live"}
        <!-- GOOGLE ANALYTICS -->
        {lv_services_google_analytics}
    <script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', 'UA-3386644-6']);
    _gaq.push(['_trackPageview']);

    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

    </script>
    {/if}
    
</head>

<body{if embed:body_class != ""} class="{embed:body_class}"{/if}{if embed:body_id != ""} id="{embed:body_id}"{/if}>

<ul id="nav_access">
    <li><a href="#navigation_pri">Skip to navigation</a></li>
    <li><a href="#content_wrapper">Skip to content</a></li>
</ul>

<div id="navigation_network" class="music">
    <ul>
        <li id="campbell"><a href="http://simoncampbell.com">Simon Campbell</a></li>
        <li id="music" class="cur"><a href="http://music.simoncampbell.com">Music</a></li>
        <li id="blog"><a href="http://blog.simoncampbell.com">Blog</a></li>
        <li id="twitter"><a href="#">Twitter</a></li>
        <li id="facebook"><a href="#">Facebook</a></li>
    </ul>
</div>

<div id="page">
    
    <div id="header">
        
        {if segment_1 == ""}
            <h1 id="branding">
                <img src="{pv_assets_url}/images/site/titles/main_title.png" alt="Simon Campbell Music" width="907px" height="61px" class="title" />
            </h1>
        {if:else}
            <p id="branding">
                <a href="{pv_site_url}/">
                    <img src="{pv_assets_url}/images/site/titles/main_title.png" alt="Simon Campbell Music" width="907px" height="61px" class="title" />
                </a>
            </p>
        {/if}
        
    </div> <!-- // #header -->
    
    <ul id="navigation_pri">
        <li{if embed:section == "home"} class="cur"{/if}><a href="{pv_site_url}/">Home</a></li>
        <li{if embed:section == "thirtysix"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/">ThirtySix</a></li>
        <li{if embed:section == "store"} class="cur"{/if}><a href="{pv_site_url}/store/">Store</a></li>
        <li{if embed:section == "journal"} class="cur"{/if}><a href="{pv_site_url}/journal/">Journal</a></li>
        <li{if embed:section == "bio"} class="cur"{/if}><a href="{pv_site_url}/bio/">Bio</a></li>
        <li{if embed:section == "gallery"} class="cur"{/if}><a href="{pv_site_url}/gallery/">Gallery</a></li>
        <li{if embed:section == "contact"} class="cur"{/if}><a href="{pv_site_url}/contact/">Contact</a></li>
        
        {!-- LOGGED OUT --}
        {if logged_out}
        <li><a href="{pv_site_url}/account/">Store login</a></li>
        <li><a href="{pv_site_url}/account/">Register</a></li>
        {/if}
        
        {!-- LOGGED IN --}
        {if logged_in}
        <li><a href="{pv_site_url}/store/basket/">My basket (3)</a></li>
        <li><a href="{pv_site_url}/account/">Account</a></li>
        <li><a href="{path="LOGOUT"}">Log out</a></li>
        {/if}
        
    </ul> <!-- // #navigation_pri -->









<!DOCTYPE html>

<html lang="en" class="no-js">

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