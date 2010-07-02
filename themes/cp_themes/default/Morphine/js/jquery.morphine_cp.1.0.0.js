(function($) {
	$('table.col-sortable').tablesorter(
		{
			cssHeader: 'order-trigger',
			cssDesc: 'order-trigger-desc',
			cssAsc: 'order-trigger-asc',
			widgets: ['zebra'],
			debug: false
		}
	);
})(jQuery);