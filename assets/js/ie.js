$(document).ready(function(){
    
    $('ul#navigation_pri li:first').addClass('first');
    $('ul.item_listing li:odd').addClass('odd');
    $('ul#gallery_grid li:odd').addClass('odd');
    $('ul#navigation_pri li.account ul li:last').addClass('last');
    $('div#posts div.post:last').addClass('last');
    $('div#posts div.post ul.post_meta li:first').addClass('first');
    $('body.newsletter div#content_pri div:first').addClass('first');
    
    // IE6 PNG FIX CLASS
    $('#branding img, div#navigation_network ul li#nn_rss a, div#navigation_network ul li#nn_twitter a, div#navigation_network ul li#nn_facebook a, div#posts div.post ul.post_meta li.pm_twitter a, div#posts div.post ul.post_meta li.pm_facebook a').addClass('png');
});