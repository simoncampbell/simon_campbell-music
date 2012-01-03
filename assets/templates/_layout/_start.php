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
    {if embed:og_title != ""}
    <meta property="og:title" content="{embed:og_title}" /> 
    {/if}
    {if embed:og_url != ""}
    <meta property="og:url" content="{embed:og_url}" /> 
    {/if}
    {if embed:og_description != ""}
    <meta property="og:description" content="{embed:og_description}" />
    {/if}
    {if embed:og_image != ""}
    <meta property="og:image" content="{embed:og_image}" />
    {/if}
    {if embed:og_audio != ""}
    <meta property="og:audio" content="{embed:og_audio}" /> 
    {/if}
    {if embed:og_audio_type != ""}
    <meta property="og:audio:type" content="{embed:og_audio_type}" />
    {/if}
    {if embed:og_audio_title != ""}
    <meta property="og:audio:title" content="{embed:og_audio_title}" /> 
    {/if}
    {if embed:og_audio_artist != ""}
    <meta property="og:audio:artist" content="{embed:og_audio_artist}" /> 
    {/if}
    {if embed:og_audio_album != ""}
    <meta property="og:audio:album" content="{embed:og_audio_album}" /> 
    {/if}
    
    {!-- Facebook metadata for ThirtySix page --}
    {if segment_1 == "thirtysix"}
    <!-- FB METADATA -->
    <meta property="og:title" content="ThirtySix at Simon Campbell Music" /> 
    <meta property="og:description" content="Simon Campbell's debut solo album, ThirtySix, launches 26 March 2011." />
    <meta property="og:image" content="http://music.simoncampbell.com/assets/images/content/thirtysix_album_art_small.jpg" />
    <meta property="og:audio" content="http://music.simoncampbell.com/assets/audio/brother.mp3" /> 
    <meta property="og:audio:type" content="application/mp3" />
    <meta property="og:audio:title" content="Brother" /> 
    <meta property="og:audio:artist" content="Simon Campbell" /> 
    <meta property="og:audio:album" content="ThirtySix" />
    {/if}
    
    <!-- CSS -->
    <link href="{pv_assets_url}/css/screen.css" rel="stylesheet" media="screen" />
    <link href="{pv_assets_url}/css/campbell-nav.css" rel="stylesheet" media="screen" />
    {if segment_1 == "gallery" OR segment_1 == "store"}
    <link rel="stylesheet" href="{pv_assets_url}/css/colorbox.css" type="text/css" media="screen" />
    {/if}
    
    
    <!--[if lte IE 8]><link href="{pv_assets_url}/css/screen_ie.css" rel="stylesheet" media="screen" /><![endif]-->
    <!--[if IE 8]><link href="{pv_assets_url}/css/screen_ie8.css" rel="stylesheet" media="screen" /><![endif]-->
    <!--[if IE 7]><link href="{pv_assets_url}/css/screen_ie7.css" rel="stylesheet" media="screen" /><![endif]-->
    <!--[if IE 6]><link href="{pv_assets_url}/css/screen_ie6.css" rel="stylesheet" media="screen" /><![endif]-->
        
    <!-- ICONS -->
    <link rel="shortcut icon" href="{pv_assets_url}/images/site/icons/favicon.ico" />
    <link rel="apple-touch-icon" href="{pv_assets_url}/images/site/icons/apple_touch-icon.png" />
    <link rel="apple-touch-startup-image" href="{pv_assets_url}/images/site/icons/apple_touch-startup.png" />
    
    <!-- JAVASCRIPT -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.9/jquery-ui.min.js"></script>
    <script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    {if segment_1 == "gallery"}
    <script src="{pv_assets_url}/js/jquery.scrollto.min.js"></script>
    <script src="{pv_assets_url}/js/jquery.moodular.js"></script>
    {/if}
    {if segment_1 == "gallery" OR segment_1 == "store"}
    <script src="{pv_assets_url}/js/jquery.colorbox.min.js"></script>
    {/if}
    <script src="{pv_assets_url}/js/onload.js"></script>
    
    <!-- WEBFONTS -->
    <script type="text/javascript" src="http://fast.fonts.com/jsapi/d8bd6128-b18f-4a44-a9cc-7175e6b50fa2.js"></script>
    
    <!-- JW PLAYER -->
    <script src="{pv_assets_url}/jwplayer/jwplayer.js"></script>
    
    <!--[if lt IE 9]><script src="{pv_assets_url}/js/ie.js"></script><![endif]-->
    
    <!--[if IE 6]>
        <script src="{pv_assets_url}/js/ie6/DD_belatedPNG_0.0.8a.js"></script>
        <script>
            DD_belatedPNG.fix('.png, body#gear div#gear_guitars, body#bio #beginnings, body#bio #tribute, body.history #thejourney, ul#navigation_gallery li a');
        </script>
    <![endif]-->
    
    {if ev_environment == "live" AND lv_services_google_analytics_toggle == "On"}
        <!-- GOOGLE ANALYTICS -->
        {lv_services_google_analytics}
    {/if}
    
    <!-- RSS -->
    <link rel="alternate" type="application/rss+xml" title="RSS" href="{lv_services_master_rss}" />
    
</head>

<body class="no-js {if embed:body_class != ""}{embed:body_class}{/if}"{if embed:body_id != ""} id="{embed:body_id}"{/if}>

<ul id="nav_access">
    <li><a href="#navigation_pri">Skip to navigation</a></li>
    <li><a href="#content_pri">Skip to content</a></li>
</ul>

<div id="navigation_network" class="clearfix music">
    <ul>
        <li id="nn_simon"><a href="http://simoncampbell.com">Simon Campbell</a></li>
        <li id="nn_music" class="cur"><a href="http://music.simoncampbell.com">Music</a></li>
        <li id="nn_blog"><a href="http://blog.simoncampbell.com">Blog</a></li>
        <li id="nn_social"><span class="hide">Follow me</span>
            <ul>
                <li id="nn_rss"><a href="{lv_services_master_rss}">RSS</a></li>
                <li id="nn_twitter"><a href="{lv_services_twitter_url}">Twitter</a></li>
                <li id="nn_facebook"><a href="{lv_services_facebook_url}">Facebook</a></li>
            </ul>
        </li>
    </ul>
</div><!-- // #navigation_network -->

<div id="page" class="clearfix">
    
    <div id="header">
        
        {if segment_1 == ""}        
            <h1 id="branding">
                <img src="{pv_assets_url}/images/site/titles/main_title.png" alt="Simon Campbell Music" width="907" height="61" class="title" />
            </h1>
        {if:else}       
            <p id="branding">
                <a href="{pv_site_url}/">
                    <img src="{pv_assets_url}/images/site/titles/main_title.png" alt="Simon Campbell Music" width="907" height="61" class="title" />
                </a>
            </p>
        {/if}       
        
    </div> <!-- // #header -->
    
    <ul id="navigation_pri" class="horizontal">
        <li{if embed:section == "home"} class="cur"{/if}><a href="{pv_site_url}/">Home</a></li>
        <li{if embed:section == "thirtysix"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/">ThirtySix</a></li>
        <li{if embed:section == "store"} class="cur"{/if}><a href="{pv_site_url}/store/">Store</a></li>
        <li{if embed:section == "journal"} class="cur"{/if}><a href="{pv_site_url}/journal/">Journal</a></li>
        <li{if embed:section == "bio"} class="cur"{/if}><a href="{pv_site_url}/biography/">Bio</a></li>
        <li{if embed:section == "gallery"} class="cur"{/if}><a href="{pv_site_url}/gallery/">Gallery</a></li>
        <li{if embed:section == "contact"} class="cur"{/if}><a href="{pv_site_url}/contact/">Contact</a></li>
        <li class="account"><span class="hide">Account</span>
            <ul>
                {if logged_out}     
                <li><a href="{pv_site_url}/account/">Store login</a></li>
                <li><a href="{pv_site_url}/account/">Register</a></li>
                {/if}       
                {if logged_in}      
                <li><a href="{pv_site_url}/store/basket/">My basket ({exp:cartthrob:total_items_count})</a></li>
                <li><a href="{pv_site_url}/account/">Account</a></li>
                <li><a href="{path="LOGOUT"}">Log out</a></li>
                {/if}       
            </ul>
        </li>
    </ul> <!-- // #navigation_pri -->
