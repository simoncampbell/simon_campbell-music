$(document).ready(function(){
    
    // FORMS
    $("input[type='button']").addClass('button');
    $("input[type='checkbox']").addClass('checkbox');
    $("input[type='file']").addClass('file');
    $("input[type='image']").addClass('image');
    $("input[type='password']").addClass('password');
    $("input[type='radio']").addClass('radio');
    $("input[type='submit']").addClass('submit');
    $("input[type='text']").addClass('text');

    
    // RSS ICON
    $("img[alt='Feed Icon']").addClass('rss_icon');
    
    
    // NAVIGATION HOVER
    $('ul#navigation_pri li')
        .hover(function(){
            $(this).addClass('hover'); 
        },
        function(){
            $(this).removeClass('hover');
        }
    );
    
    
    // FIRST, Nths & LAST CHILDS
    $('ul#navigation_pri li ul li:first-child').addClass('first');
    $('div#homepage_informational_pri p:first-child').addClass('first');
    
    
});


// BELATED PNG IMAGE FIXING
DD_belatedPNG.fix('p.cta_button a');