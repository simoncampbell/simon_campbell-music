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
    if($("body").hasClass("gallery")) {
        // Add gallery nav links
        $("div#content_pri").prepend("<p id=\"gallery_nav\">");
        $("p#gallery_nav").html("<a href=\"#\" class=\"gallery_skip prev\">Previous image</a> <a href=\"#\" class=\"gallery_skip next\">Next image</a>");
        
        // Gallery jQuery Cycle
        $('#gallery_photos').after('<ul class="horizontal gallery_grid">').cycle({
            fx: 'fade',
            speed: 'fast',
            timeout: 0,
            prev: '.prev',
            next: '.next',
            pager: '.gallery_grid',
            pagerAnchorBuilder: function(idx, slide) {
                var img = $(slide).children().eq(0).attr("src");
                return '<li><a href="#"><img src="' + img + '" width="180" height="118"></a></li>';
            }
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
    
    // Registration Form Validation
    $('form#register_form').validate({
        rules: {
            username: {
                required: true,
                rangelength: [4, 32]
            },
            email: {
                required: true,
                email: true
            },
            password: {
                required:true,
                rangelength: [5, 32]
            },
            password_confirm: {
                equalTo: "#register_form_password"
            }
        }
    });
    
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