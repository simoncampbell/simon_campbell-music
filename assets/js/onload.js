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

    $("input[name=cm-bxdii-bxdii]").clearDefault(); // Hide value of newsletter input on focus
    
    // Gallery
    $('#gallery_photos').after('<ul id="gallery_grid">').cycle({
        fx: 'fade',
        speed: 'fast',
        timeout: 0,
        prev: '.prev',
        next: '.next',
        pager: '#gallery_grid',
        pagerAnchorBuilder: function(idx, slide) {
            return '<li><a href="#"><img src="' + slide.src + '" width="180" height="180" /></a></li>';
        }
    });
    
});