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

function create_carousel1() {
    
    // Add navigation to carousel
    $("div#gallery").append("<ul id=\"navigation_gallery\"><li id=\"gallery_next\"><a>Next</a></li><li id=\"gallery_previous\"><a>Previous</a></li></ul>");

    // Function to adjust gallery height based on img height
    function adjust_gallery_height(moodular) {
        var img_height = $("div#gallery ul#gallery_carousel li:first-child img").height();
        $("div#gallery ul#gallery_carousel, div#gallery div").animate({
            'height' : img_height
        }, 250, 'swing');
    }

    // Create carousel            
    var moodular = $("div#gallery ul#gallery_carousel").moodular({
        speed: 500,
        effects: 'fade',
        dispTimeout: 1000,
        auto: false,
        callbacks: [adjust_gallery_height]
    });
    
    // Bind next button
    $('li#gallery_next a').click(function(event) { 
        event.preventDefault();
        moodular.next();
    });
    
    // Bind previous button
    $('li#gallery_previous a').click(function(event) { 
        event.preventDefault();
        moodular.prev();
    });
    
    // Adjust height of the gallety
    adjust_gallery_height();

}

function draw_carousel() {
    
    function adjust_height(moodular) {    

        // Function to adjust the height of the gallery container and list

        $("ul#gallery_carousel, ul#gallery_carousel li:first-child").animate({
            'queue' : false,
            'height' : $("ul#gallery_carousel li:first-child img").height()
        }, 128, 'swing');

        $("ul#gallery_carousel").closest("div").animate({
            'queue' : false,
            'height' : $("ul#gallery_carousel li:first-child img").height()
        }, 128, 'swing');

    }

    // Carousel: create
	var moodular = $("ul#gallery_carousel").moodular({
        speed: 250,
        dispTimeout: 200,
        auto: false,
        callbacks: [adjust_height],
        api: true
    });

    // Carousel: adjust container height
    adjust_height();

    // Carousel: create nav
    $("ul#gallery_carousel").closest("div").append("<ul id=\"navigation_gallery\"><li id=\"gallery_next\"><a>Next</a></li><li id=\"gallery_previous\"><a>Previous</a></li></ul>");    

    // Carousel: bind nav - next button
    $("ul#navigation_gallery li#gallery_next a").click(function(event) { 
        event.preventDefault();
        moodular.next();
    });

    // Carousel: bind nav - previous button
    $("ul#navigation_gallery li#gallery_previous a").click(function(event) { 
        event.preventDefault();
        moodular.prev();
    });
}

$(document).ready(function(){
    
    
    // Carousel page
    if($("ul#gallery_carousel").length) {
        
        
        
        if($("body").attr("id") === "carousel") {

            draw_carousel();
            
            // New gallery clicked
            $("ul#gallery_grid li a").click(function(event) {

                event.preventDefault(); // Stop link

                $.scrollTo($("ul#gallery_carousel").offset().top - 20, 400); // Scroll to the gallery element

                $(this).parent().parent().children("li").removeClass("cur"); // Remove cur status from grid itema
                $(this).parent().addClass("cur"); // Add cur status to selected grid items

                $.get($(this).attr("href") + '/inline/ ul#gallery_carousel li', function(data) { // Load in data from entry
            		$("div#gallery").remove(); // Destroy old carousel
            		$("div#content_pri").prepend("<div id=\"gallery\"><ul id=\"gallery_carousel\"></ul></div>"); // Recreate scaffold for carousel
            		$("ul#gallery_carousel").prepend($(data).find("ul#gallery_carousel li")); // Load items into gallery, filtered
            		draw_carousel(); // Recreate carousel
                });

            });

        } else if ($("body").attr("id") === "detail") { 

            if (window.location.hash) { // Check URL for hash
              $("ul#gallery_carousel li" + window.location.hash).addClass("cur"); // Add current class to correct img
            }
        }
        
        $("ul#gallery_carousel li a[rel='gallery']").colorbox({ // Create colorbox if we're on detail
            transition: 'fade',
            speed: 500
        });

        
    }
    
    
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
    if($("div#gallery1").length) {
        
        if ($("body").attr("id") === "gallery_carousel") {
            
            $("div#gallery ul#gallery_carousel").moodular()
            
            //create_carousel(); // Create carousel if we're on the gallery
            
        } else if ($("body").attr("id") === "gallery_detail") { 
            
            $("div#gallery ul li a").colorbox({ // Create colorbox if we're on detail
                transition: 'fade',
                speed: 500
            }); 
        
            if (window.location.hash) { // Check URL for hash
              $("div#gallery ul li" + window.location.hash).addClass("cur"); // Add current class to correct img
            }
        }
        
        $("ul#gallery_grid li a").click(function(event) {
            
            event.preventDefault(); // Stop link
            
            $.scrollTo($('div#gallery').offset().top - 20, 400); // Scroll to the gallery element
            
            $(this).parent().parent().children("li").removeClass("cur"); // Remove cur status from grid itema
            $(this).parent().addClass("cur"); // Add cur status to selected grid items
            
            $.get($(this).attr("href") + '/inline/ ul#gallery li', function(data) { // Load in data from entry
        		$("div#gallery").remove(); // Destroy old carousel
        		$("div#content_pri").prepend("<div id=\"gallery\"></div>"); // Recreate scaffold for carousel
        		$("div#gallery").prepend($(data).find("div#gallery ul#gallery_carousel")); // Load items into gallery, filtered
        		create_carousel(); // Recreate carousel
            });
            
        });

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