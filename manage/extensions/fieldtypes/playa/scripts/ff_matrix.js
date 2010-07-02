$.fn.ffMatrix.playaConfs = {};

$.fn.ffMatrix.onDisplayCell.playa = function(cell, FFM) {
	var div = $('div.playa-droppane', cell);

	if (div.length) {
		var inputName = $('input:first', cell).attr('name'),
			inputName = inputName.substr(0, inputName.length-5),
			id = div.attr('id');
		var conf = $.fn.ffMatrix.playaConfs[id] || $.fn.ffMatrix.playaConfs[id+'_new'];
		div.playa(conf[0], conf[1], inputName);
	}
};
