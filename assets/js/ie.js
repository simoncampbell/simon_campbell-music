$(document).ready(function(){
    
    $('ul.item_listing li:odd').addClass('odd');
    $('ul#gallery_grid li:odd').addClass('odd');
    $('ul#navigation_pri li.account ul li:last').addClass('last');
    $('div#posts div.post:last').addClass('last');
    $('div#posts div.post ul.post_meta li:first').addClass('first');
    
});