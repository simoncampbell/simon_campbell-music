$(document).ready(function(){
    
    nav_access();
        
}); // end document.ready



/* Accessibility navigation enhancements
--------------------------------------------------------------------------------- */
function nav_access(){
    $('ul#nav_access li a')
        .focus(function(){ $(this).addClass('focus'); })
        .blur(function(){ $(this).removeClass('focus'); });
}