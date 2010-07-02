;(function($){

if (typeof calendar == 'undefined') return;

$.fn.ffMatrix.onDisplayCell.ff_matrix_date = function(cell, FFM){
	var $cell = $(cell),
		$input = $('input', $cell),
		id = $input.attr('id');

	if (! id) {
		id = 'cal_' + $input.attr('name').replace(/\[/g, '_').replace(/\]/g, '');
		$input.attr('id', id);
		window[id] = new calendar(id, new Date(), false);
	}

	var cal = window[id],
		$div = $('<div />').appendTo($cell).css({ position: 'relative', zIndex: '1'}),
		$cal = $(cal.write()).appendTo($div).css('position', 'absolute').hide(),
		inputHasFocus = false, calHasFocus = false;

	var fadeoutCal = function(){
		setTimeout(function(){
			if (! inputHasFocus && ! calHasFocus) {
				$cal.fadeOut('fast');
				$cal.removeAttr('tabindex');
			}
		}, 1);
	};

	$input.focus(function(){
		inputHasFocus = true;
		$cal.fadeIn('fast');
		$cal.attr('tabindex', '0');
	})
	.blur(function(){
		inputHasFocus = false;
		fadeoutCal();
	});

	$cal.focus(function(){
		calHasFocus = true;
	})
	.blur(function(){
		calHasFocus = false;
		fadeoutCal();
	})
	.click(function(event){
		if (event.target.className == 'caldayselected') {
			$cal.blur();
		}
	});

	$('img', $cell).click(function(){
		$input.focus();
	});
};

})(jQuery);
