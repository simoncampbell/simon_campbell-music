(function($){
 $.fn.clearDefault = function(){
     return this.each(function(){
         var default_value = $(this).val();
         $(this).focus(function(){
             if ($(this).val() == default_value) $(this).val("");
         });
         $(this).blur(function(){
             if ($(this).val() == "") $(this).val(default_value);
         });
     });
 };
})(jQuery);

(function ($) {
$.fn.vAlign = function() {
	return this.each(function(i){
	var h = $(this).height();
	var oh = $(this).outerHeight();
	var mt = (h + (oh - h)) / 2;	
	$(this).css("margin-top", "-" + mt + "px");	
	$(this).css("top", "50%");
	$(this).css("position", "absolute");	
	});	
};
})(jQuery);

(function ($) {
$.fn.hAlign = function() {
	return this.each(function(i){
	var w = $(this).width();
	var ow = $(this).outerWidth();	
	var ml = (w + (ow - w)) / 2;	
	$(this).css("margin-left", "-" + ml + "px");
	$(this).css("left", "50%");
	$(this).css("position", "absolute");
	});
};
})(jQuery);

function draw_carousel() {
    
    // function adjust_height(moodular) {    
    // 
    //     // Function to adjust the height of the gallery container and list
    //     // THIS IS NOT IN USE
    // 
    //     $("ul#gallery_carousel, ul#gallery_carousel li:first-child").animate({
    //         'queue' : false,
    //         'height' : $("ul#gallery_carousel li:first-child img").height()
    //     }, 128, 'swing');
    // 
    //     $("ul#gallery_carousel").closest("div").animate({
    //         'queue' : false,
    //         'height' : $("ul#gallery_carousel li:first-child img").height()
    //     }, 128, 'swing');
    // 
    // }
    
    function update_zoom() {
        $("li#gallery_zoom a").attr("href", $("ul#gallery_carousel li:first-child img").attr("title"));
        $("li#gallery_zoom a").attr("title", $("ul#gallery_carousel li:first-child p").html());
    }
    
    // Carousel: create
	var moodular = $("ul#gallery_carousel").moodular({
        speed: 250,
        dispTimeout: 200,
        auto: false,
        callbacks: [update_zoom],
        api: true
    });
    
   
    // Carousel: create nav
    $("ul#gallery_carousel").closest("div").append("<ul id=\"navigation_gallery\"><li id=\"gallery_zoom\"><a>Zoom</a></li><li id=\"gallery_next\"><a>Next</a></li><li id=\"gallery_previous\"><a>Previous</a></li></ul>");    

    // Carousel: update zoom nav
    update_zoom();
    
    // Carousel: bind nav - next button
    $("ul#navigation_gallery li#gallery_next a, #cboxNext").click(function(event) { 
        event.preventDefault();
        moodular.next();
    });

    // Carousel: bind nav - previous button
    $("ul#navigation_gallery li#gallery_previous a, #cboxPrevious").click(function(event) { 
        event.preventDefault();
        moodular.prev();
    });
    
    // Align images centrally within slideshow
    $("ul#gallery_carousel li img").each(function(index) {
        $(this).vAlign();
        $(this).hAlign();
    });
    
}

$(document).ready(function(){
    
    // Remove no-js class
    if($("body").hasClass("no-js")) {
        $("body").removeClass("no-js");
    }
    
    // Promo tabs
    if($("div#promo").length) {
        $("div#promo").tabs();
    }
     
    // Hide value of newsletter input on focus
    if($("input[name=cm-bxdii-bxdii]").length) {
        $("input[name=cm-bxdii-bxdii]").clearDefault();
    }
    
    // Gallery
    if($("ul#gallery_carousel").length) {
        
        // If not listing page
        if($("body").attr("id") === "carousel") {

            // Draw carousel
            draw_carousel();
            
            // Create colorbox
            var colorbox_slideshow = $("li#gallery_zoom a").colorbox({
                transition: 'elastic',
                speed: 250
            });
        
            // New gallery clicked on grid
            $("ul#gallery_grid li a").click(function(event) {

                event.preventDefault(); // Stop link
                
                colorbox_slideshow.remove(); // Destroy colorbox
        		
                $.scrollTo($("ul#gallery_carousel").offset().top - 20, 400); // Scroll to the gallery element

                $(this).parent().parent().children("li").removeClass("cur"); // Remove cur status from grid itema
                $(this).parent().addClass("cur"); // Add cur status to selected grid items

                // Load in data from entry
                $.get($(this).attr("href") + '/inline/ ul#gallery_carousel li', function(data) { 
            		$("div#gallery").remove(); // Destroy old carousel
            		$("div#content_pri").prepend("<div id=\"gallery\"><ul id=\"gallery_carousel\"></ul></div>"); // Recreate scaffold for carousel
            		$("ul#gallery_carousel").prepend($(data).find("ul#gallery_carousel li")); // Load items into gallery, filtered
            		draw_carousel(); // Recreate carousel
            		
            		// Recreate colorbox
                    var colorbox_slideshow = $("li#gallery_zoom a").colorbox({
                        transition: 'elastic',
                        speed: 250
                    });
                    
                    // Update zoom nav item
                    update_zoom();
                    
                });

            });

        } else if ($("body").attr("id") === "detail") { 
            
            if (window.location.hash) {
                // If on a listings page with a hash
                $("ul#gallery_carousel li" + window.location.hash).addClass("cur"); // Add current class to correct img
            }
            
            // Create colorbox
            $("ul#gallery_carousel li a").colorbox({
                transition: 'elastic',
                speed: 250
            });
              
        }
        
    }

    // Contact Form Validation
    if($("form#freeform").length) {
        $('form#freeform').validate({
            rules: {
                name: {
                    required: true,
                    rangelength: [4, 30]
                },
                email: {
                    required: true,
                    email: true
                },
                message: {
                    required: true,
                    rangelength: [15, 250]
                }
            }
        });
    }
    
    // Campaign Monitor subscribe validation
    $('form.validate_inline').validate();
    $('div#newsletter_signup form').validate();
    
    // Email Encoder: Example: <span class="email">name at domainname dot com</span>
    $(function(){
        
        $('span.email').each(function(){
          var at = / at /;
          var dot = / dot /g;
          var addr = $(this).text().replace(at,"@").replace(dot,".");
          $(this)
            .after('<a href="mailto:'+addr+'" title="Send email">'+ addr +'</a>')
            .hover(function(){window.status="Send emai";}, function(){window.status="";});
          $(this).remove();
        });
        
    });
    
});