(function($) {

	// plugin definition
	$.fn.MOR_MagicCheckboxes = function(options) {
		var opts = $.extend({}, $.fn.MOR_MagicCheckboxes.defaults, options);
		return this.each(function() {
			var $self = $(this);
			var dom = {
					container: $self,
					parentTrigger: ($.isFunction(opts.parentTrigger)) ? opts.parentTrigger.call($self) : $(opts.parentTrigger, $self),
					childTriggers: ($.isFunction(opts.childTriggers)) ? opts.childTriggers.call($self) : $(opts.childTriggers, $self)
				};
			dom.parentTrigger
				.unbind(opts.event + ".MOR_MagicCheckboxes")
				.bind(opts.event + ".MOR_MagicCheckboxes", {opts:opts, dom:dom}, $.MOR_MagicCheckboxes._check_all);
			dom.childTriggers
				.unbind(opts.event + ".MOR_MagicCheckboxes")
				.bind(opts.event + ".MOR_MagicCheckboxes", {opts:opts, dom:dom}, $.MOR_MagicCheckboxes._check_row);
		});
	};

	$.MOR_MagicCheckboxes = {
		_check_all: function(e){
			e.stopPropagation();
			var $trs = $("tbody tr", e.data.dom.container);
			var $checkboxes = $(e.data.dom.childTriggers);
			if($(this).is(':checked'))
			{
				$trs.addClass('selected');
				$checkboxes.attr('checked', 'checked');
			} else {
				$trs.removeClass('selected');
				$checkboxes.removeAttr('checked');
			}
		},
		_check_row: function(e){
			e.stopPropagation();
			var $tr = $(this).parents('tr:eq(0)');
			if($(this).is(':checked'))
			{
				$tr.addClass('selected');
				$(this).attr('checked', 'checked');
			} else {
				$tr.removeClass('selected');
				e.data.dom.parentTrigger.removeAttr('checked');
				$(this).removeAttr('checked');
			}
		}
	};

	$.fn.MOR_MagicCheckboxes.defaults = {
		event: 'click',
		parentTrigger: ':checkbox[name=toggleTrigger]',
		childTriggers: 'tbody :checkbox[name^=toggle]'
	};

	$(".mor table").MOR_MagicCheckboxes();

})(jQuery);