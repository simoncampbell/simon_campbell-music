$(document).ready(function(){
    
    nav_access();
    stream_paginate();
	slide_switch();
	//brightcove_players();

    $('div#homepage_banners:not(.rotate)').tabs();
	$('div#homepage_banners.rotate').tabs().tabs("rotate", 9000, false);
    	
}); // end document.ready

    

/* Accessibility navigation enhancements
--------------------------------------------------------------------------------- */
function nav_access(){
    $('ul#nav_access li a')
        .focus(function(){ $(this).addClass('focus'); })
        .blur(function(){ $(this).removeClass('focus'); });
}


/* TODO

* Smoothe it up? Maybe add some animation
* Add a 'no more items' to the list?

--------------------------------------------------- */
function stream_paginate() {
    $('ul.media_listing li.pagination a').click(function(event){
        // Don't reload the page
        event.preventDefault();
        // Where's the page we need?
        var url = $(this).attr('href');
        // Set these as a var so we don't have to use another selector
        var $pagination = $(this);
        var $media_list = $pagination.parents().find('ul.media_listing');
        // Show the loading indicator
        $media_list.append('<li class="loading">Loading</li>');
        $.get(url,function(data){
            // Loading is done
            $media_list.find('li.loading').remove();
            // Find the listing on the new page
            var $new_items = $('div#content_pri ul.media_listing',data);
            // Find the pagination so we can check where we are, and where the next page is
            var $new_pagination = $new_items.find('li.pagination');
            // Last item will always be 'next page' (unless it's the last page)
            $pagination.attr( 'href',$new_pagination.find('a:last-child').attr('href') );
            // If we're at the end, lose the pagination and quit
            if( $new_items.find('li.pagination').hasClass('end') ) { $pagination.remove(); }
            // We don't need the new pagination
            $new_items.find('li.pagination').remove();
            // Prepend the entry list (without the pagination)
            $media_list.find('li.pagination').before($new_items.html());
            brightcove_players();
        });
        
    });
}

/* TODO

* Comment up

--------------------------------------------------- */
function slide_switch(){
    
    var duration = 350,
        animating = false;

    $('ul.navigation_media li a').click(function(event){
        
        event.preventDefault();
        
        var $container = $('div.media_tabs', $(this).parents('li.entry:first')),
            $oldSlide = $('div.slide.cur',$container),
            $newSlide = $('div'+$(this).attr('href')),
            $oldLink = $($(this).parent('li').siblings('li.cur:first'))
            $newLink = $(this).parent('li');
                                        
        // ignore if already active
		if (animating || $newLink.hasClass('cur')) return;
        
        animating = true;        
        
        $newLink.addClass('cur');
        $oldLink.removeClass('cur');
        
        // Explicitly set the height so it doesn't budge
        $container.height($container.height());
        
        // Find the new height we want to animate to
        var newHeight = $newSlide.outerHeight();
        
        $newSlide.addClass('cur');
        if ($newLink.index() > $oldLink.index()) {
            $newSlide
                .css('marginTop', -newHeight)
                .animate({ marginTop: 0 }, duration);
        } else {
            $oldSlide.animate({ marginTop: -$oldSlide.outerHeight() }, duration);
        }

        $container
            .animate({ height: newHeight }, duration, function(){
                $newSlide.css('marginTop',0);
                $oldSlide
                    .removeClass('cur')
                    .css('marginTop',0);
                $(this).height('auto');
                animating = false;
            });
        
        
        
    });
        
}

/*
Add all the brightcove players
--------------------------------------------------- */
function brightcove_players () {
    brightcove.createExperiences();
}
