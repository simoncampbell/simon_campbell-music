(function($){

/**
 * Playa jQuery plugin
 *
 * @package Playa
 * @author    Brandon Kelly <me@brandon-kelly.com
 * @author    Karl Swedberg (for Fusionary Media)
 * @copyright Copyright (c) 2009 Brandon Kelly
 * @license   http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 */
$.fn.playa = function(itemAttr, options, id) {
	return this.each(function() {

		// Initialize obj
		var obj = {
			id: id || this.id,
			dom: { $container: $(this) },

			items: {},
			itemIds: [],
			options: $.extend({}, $.fn.playa.defaults, options),
			defaultAttr: {},
			reverseSort: false,

			hoveringOverItems: false,
			hoveringOverSelections: false
		};

		// get the remainder of the DOM skeleton
		obj.dom.$field = obj.dom.$container.children('table');
		obj.dom.$field.$tr = $(obj.dom.$field[0].firstChild.firstChild);
		obj.dom.$itemWrapper = $(obj.dom.$field.$tr[0].firstChild.firstChild);
		obj.dom.$resizeHandle = $(obj.dom.$field.$tr[0].childNodes[1].firstChild)
		obj.dom.$selectionWrapper = $(obj.dom.$field.$tr[0].childNodes[2].firstChild);
		obj.dom.$itemList = $('ul:first', obj.dom.$itemWrapper);
		obj.dom.$selectionList = $('ul:first', obj.dom.$selectionWrapper);

		// resizing
		obj.dom.$field.resizable({
			handles: ['.ui-resizable-handle'],
			preserveCursor: false,
			alsoResize: '#'+obj.id+' .scrollPane',
			containment: 'parent',
			resize: function() {
				$(this).width('100%');
				$('.scrollPane', this).width('100%');
			}
		});

		// Add the filters
		if (obj.options.showFilters) {
			obj.dom.$filters = $('<div>').appendTo($('<div>').prependTo(obj.dom.$container).addClass('filters')).addClass('box');

			$.each(obj.options.filters, function(f) {
				var filter = this,
					numOptions = 0;
				obj.defaultAttr[f] = false;
				filter.$label = $('<label>').text(unescape(filter.label)).append($('<br>')).appendTo(obj.dom.$filters);
				filter.$select = $('<select>').append($('<option>').attr('value', '').text('-- any --')).appendTo(filter.$label);
				filter._options = {};
				for (var o in filter.options) {
					if (typeof(filter.options[o]) == 'object') {
						var optgroup = $('<optgroup>').attr('label', o).appendTo(filter.$select);
						for (var o1 in filter.options[o]) {
							optgroup.append($('<option>').attr('value', o1).text(filter.options[o][o1]));
							filter._options[o1] = filter.options[o][o1];
							numOptions++;
						}
					}
					else {
						filter.$select.append($('<option>').attr('value', o).text(filter.options[o]));
						filter._options[o] = filter.options[o];
						numOptions++;
					}
				};
				if (numOptions) {
					filter.$select.change(function(e) {
						playa.filterItems(obj);
					});
				}
				else {
					playa.disableFilter(obj, f);
				}
			});

			// Add the Keyword filter
			if (obj.options.keywordResultsURL) {
				var $label = $('<label>').text('Keywords').append($('<br>')).appendTo(obj.dom.$filters);
				var $input = $('<input type="text">').appendTo($label).addClass('keywords');
				var timeout;
				$input.keydown(function(e) {
					clearTimeout(timeout);
					setTimeout(function() {
						val = $input.val();
						if (!val) {
							delete obj.options.filters._keywordResults;
							playa.filterItems(obj);
						} else {
							timeout = setTimeout(function() {
								playa.keywordSearch(obj, $input, val);
							}, obj.options.keywordResultsIntervalDuration);
						}
					}, 1);
				});
			}

			// Add ordering & sorting selects
			if (obj.options.orderBy) {
				// ordering
				var $label = $('<label>').text('Order by').append($('<br>')).appendTo(obj.dom.$filters);
				var $select = $('<select>').appendTo($label);
				$.each(obj.options.orderBy, function(i) {
					$select.append($('<option>').val(i).text(obj.options.orderBy[i]));
				});
				$select.change(function(e) {
						var attr = $(this).val();
						obj.itemIds.sort(function(a, b) {
							return (obj.items[a].attr[attr] < obj.items[b].attr[attr] ? -1 : 1);
						});
						if (obj.reverseSort) obj.itemIds.reverse();
						playa.reorderItems(obj);
					});

				// sorting
				var $label = $('<label>').text('Sort').append($('<br>')).appendTo(obj.dom.$filters);
				var $select = $('<select>').appendTo($label)
					.append($('<option>').text('Ascending'))
					.append($('<option>').text('Descending'))
					.change(function(e) {
						obj.reverseSort = !obj.reverseSort;
						obj.itemIds.reverse();
						playa.reorderItems(obj);
					});
			}

			// Clear!
			$('<div>').appendTo(obj.dom.$filters)
				.css('clear', 'left');
		}

		// Add the items

		var disabledFilters = $.extend({}, obj.defaultAttr),
			selections = [];

		obj.dom.$itemList.children().each(function(){
			var li = this,
				id = li.id.substr(13),
				attr = itemAttr[id];
			if (!attr) return true;

			var item = {
				id: id,
				attr: attr,
				visible: true,
				$li: $(li)
			};
			obj.items[id] = item;
			obj.itemIds.push(id);

			for (var a in obj.defaultAttr) {
				if (typeof item.attr[a] == 'undefined') {
					item.attr[a] = obj.defaultAttr[a];
				}
			}

			for (a in disabledFilters) {
				if (disabledFilters[a] === false) {
					disabledFilters[a] = item.attr[a];
				}
				else if (disabledFilters[a] != item.attr[a]) {
					delete disabledFilters[a];
				}
			};

			// Selected?
			if (item.attr.selected) {
				item.$selected = $('> #playa-option-'+id+'-selected:first', obj.dom.$selectionList);
			}
		});

		// Disable pointless filters
		for (a in disabledFilters) {
			var filter = obj.options.filters[a];
			if (filter && filter._options[disabledFilters[a]]) {
				filter.$select.val(disabledFilters[a]);
				playa.disableFilter(obj, a);
			}
		}

		// Dragging + sorting
		obj.draggableOptions = {
			cancel: 'li:not(.active)',
			helper: function() {
				$ul = $('<ul>').appendTo(obj.dom.$container)
				        .addClass('draghelper')
				        .css('width', obj.dom.$itemList.width());
				obj.dom.$draggees = obj.dom.$field.find('li.active');
				obj.dom.$draggees.clone(true).appendTo($ul);
				obj.dom.$draggees.addClass('draggee');
				return $ul;
			},
			appendTo: obj.dom.$field,
			start: function(event, ui) {
				obj.dragging = true;
				obj.$closestSelection = null;
				obj.selectionPlacement = null;
				obj.dom.$selectionList.find('li.draggee').addClass('hidden');

				// get collapsed positions & heights of all selected items
				obj.$selections = obj.dom.$selectionList.find('li:not(.draggee)');
				obj.selectionPositions = {};
				obj.$selections.each(function(i) {
					var $selection = $(this);
					obj.selectionPositions[i] = {
						offsetTop: (i == 0 ? obj.dom.$selectionList.offset().top : obj.selectionPositions[i-1].offsetTop + obj.selectionPositions[i-1].height),
						height:    $selection.height()
					};
				});
			},
			drag: function(event, ui) {
				if (playa.cursorOver(event, obj.dom.$itemWrapper)) {
					if (!obj.hoveringOverItems) {
						obj.hoveringOverItems = true;
						obj.dom.$itemWrapper.addClass('ready');
					}
				}
				else {
					if (obj.hoveringOverItems) {
						obj.hoveringOverItems = false;
						obj.dom.$itemWrapper.removeClass('ready');
					}

					if (playa.cursorOver(event, obj.dom.$selectionWrapper)) {
						if (!obj.hoveringOverSelections)
							obj.hoveringOverSelections = true;

						if ( ! obj.$selections.length) {
							obj.dom.$selectionWrapper.addClass('ready');
						}
						else {
							// draw a line where the items would be inserted
							var smallestOffset,
								$selection,
								$closestSelection,
								selectionPlacement = 'Top',
								lastIndex;

							obj.$selections.each(function(i) {
								$selection = $(this);
								var offset = Math.abs(event.pageY - obj.selectionPositions[i].offsetTop);
								if (!$closestSelection || offset < smallestOffset) {
									smallestOffset = offset;
									$closestSelection = $selection;
								}
								lastIndex = i;
							});
							var offset = event.pageY - (obj.selectionPositions[lastIndex].offsetTop + obj.selectionPositions[lastIndex].height);
							if (offset > 0 || Math.abs(offset) < smallestOffset) {
								$closestSelection = $selection;
								selectionPlacement = 'Bottom';
							}
							if ($closestSelection != obj.$closestSelection) {
								if (obj.$closestSelection) {
									obj.$closestSelection.css({marginTop:0, marginBottom:0});
								}
								obj.$closestSelection = $closestSelection;
								obj.selectionPlacement = selectionPlacement;
								obj.$closestSelection.css('margin'+obj.selectionPlacement, ui.helper.height());
							}
						}
					}
					else {
						if (obj.hoveringOverSelections) {
							obj.hoveringOverSelections = false;
							obj.dom.$selectionWrapper.removeClass('ready');
						}
						if (obj.$closestSelection) {
							obj.$closestSelection.css({marginTop:0, marginBottom:0});
							obj.$closestSelection = null;
						}
					}
				}
			},
			stop: function(event, ui) {
				obj.dragging = false;

				if (obj.hoveringOverItems || obj.hoveringOverSelections) {
					// get the items
					var itemIds = [];
					ui.helper.find('li').each(function() {
						itemIds.push(this.id.match(/-option-(\d+)/)[1]);
					});

					if (obj.hoveringOverItems) {
						for (var i=0; i<itemIds.length; i++) {
							var item = obj.items[itemIds[i]];
							item.$li.removeClass('selected');
							item.$selected.remove();
						}

						obj.hoveringOverItems = false;
						obj.dom.$itemWrapper.removeClass('ready');
					}
					else {
						if (obj.$closestSelection) {
							var place = (obj.selectionPlacement == 'Top') ? 'insertBefore' : 'insertAfter',
								rel = obj.$closestSelection;
						}
						else {
							var place = 'appendTo',
								rel = obj.dom.$selectionList;
						}
						for (var i=0; i<itemIds.length; i++) {
							var item = obj.items[itemIds[i]];
							item.$li.addClass('selected');

							// create the selected li?
							if (!item.$selected) {
								item.$selected = item.$li.clone(true).attr({ id: item.$li.attr('id')+'-selected', className: '' })
									.append($('<input type="hidden">').attr({ 'name': obj.id+'[selections][]', 'value': item.id }));
							}
							item.$selected[place](rel);
						};
					}

					obj.dom.$draggees.removeClass('active');
				}

				if (obj.hoveringOverSelections) {
					obj.hoveringOverSelections = false;
					obj.dom.$selectionWrapper.removeClass('ready');
				}
				if (obj.$closestSelection) {
					obj.$closestSelection.css({marginTop:0, marginBottom:0});
					obj.$closestSelection = null;
				}

				obj.dom.$draggees.removeClass('draggee').removeClass('hidden');
				obj.dom.$draggees = null;

				playa.resetDraggables(obj);
			}
		};

		playa.resetDraggables(obj);

		obj.dom.$field.click(function(event) {
			$(this).find('li').removeClass('active');
		});
	});
};


/**
 * Default options
 */
$.fn.playa.defaults = {
	showKeywordFilter: false,
	keywordResultsURL: './',
	keywordResultsIntervalDuration: 500,
	filterAnimationDuration: 250
};


/**
 * Private methods
 */
var playa = {

	disableFilter: function(obj, i) {
		var filter = obj.options.filters[i];
		filter.$label.addClass('disabled');
		filter.$select.attr('disabled', 'disabled');
		delete(obj.options.filters[i]);
	},

	filterItems: function(obj) {
		$.each(obj.items, function(i) {
			var item = this;
			var show = true;
			$.each(obj.options.filters, function(f) {
				var filter = this;
				var attr = item.attr[f];
				if (f == '_keywordResults') {
					if (filter && (filter === true || $.inArray(i, filter) == -1)) {
						show = false;
						return false;
					}
				}
				else {
					var val = filter.$select.val();
					if (val !== '') {
						if (attr instanceof Array) {
							if ($.inArray(val, attr) == -1) {
								show = false;
								return false;
							}
						}
						else if (attr != val) {
							show = false;
							return false;
						}
					}
				}
			});
			if (show) {
				playa.showItem(obj, item);
			}
			else {
				playa.hideItem(obj, item);
			}
		});
	},

	hideItem: function(obj, item) {
		if ( ! item.visible) return false;
		item.visible = false;
		item.$li.css('zIndex', 0);
		item.$li.animate({
			opacity: 0,
			marginTop: -item.$li.height()
		},
		{
			duration: obj.options.filterAnimationDuration,
			complete: function() {
				$(this).addClass('hidden');
			}
		});
	},

	showItem: function(obj, item) {
		if ( item.visible) return false;
		item.visible = true;
		item.$li.removeClass('hidden');
		item.$li.animate({ opacity:1, marginTop:0 }, obj.options.filterAnimationDuration, 'linear',
			function() {
				$(this).css('zIndex', 1);
			}
		);
	},

	keywordSearch: function(obj, $input, val) {
		var url = obj.options.keywordResultsURL+'&keywords='+encodeURIComponent(val);
		$.getJSON(url, function(data) {
			obj.options.filters._keywordResults = data.entries ? data.entries : true;
			playa.filterItems(obj);
		});
	},

	reorderItems: function(obj) {
		// get old tops
		$.each(obj.items, function(i) {
			this.oldTop = this.$li.offset().top;
		});

		// reposition and animate
		$.each(obj.itemIds, function(i) {
			var item = obj.items[obj.itemIds[i]];

			if (i == 0) {
				item.$li.prependTo(obj.dom.$itemList);
			}
			else {
				item.$li.insertAfter(obj.items[obj.itemIds[i-1]].$li);
			}

			var newTop = item.$li.offset().top;
			item.$li.css('top', (item.oldTop-newTop));
			item.$li.animate({ top: 0 }, {
				duration: obj.options.filterAnimationDuration
			});
		});
	},

	resetDraggables: function(obj) {
		obj.dom.$items = obj.dom.$field.find('li:not(.selected)').filter(':not(.hidden)')
			.draggable('destroy')
			.unbind()
			.playaSelect()
			.draggable(obj.draggableOptions);
	},

	cursorOver: function(event, $element) {
		var offset = $element.offset(),
			x1 = offset.left,
			y1 = offset.top,
			x2 = x1 + $element.width(),
			y2 = y1 + $element.height();
		return (event.pageX >= x1 && event.pageX < x2 && event.pageY >= y1 && event.pageY < y2);
	}

};

/**
 * Playa Select jQuery plugin
 *
 * Allows selection of multiple items
 * using shift- and command/ctrl-click
 *
 * @author Karl Swedberg (for Fusionary Media)
 */
$.fn.playaSelect = function() {
	var $list = $(this),
		prevIndex = -1;
	return $list.each(function() {
		var $li = $(this),
			thisIndex = $list.index(this);
			posX = 0, posY = 0,
			shiftKey = false;
		$li.bind('mousedown', function(event) {
			// store the cursor position for later
			posX = event.pageX;
			posY = event.pageY;

			if (event.shiftKey && prevIndex > -1) {
				shiftKey = true;
				var startIndex = prevIndex < thisIndex ? prevIndex+1 : thisIndex+1,
					endIndex = prevIndex < thisIndex ? thisIndex : prevIndex;

				$list.slice(startIndex, endIndex).addClass('active');
			}
			else {
				shiftKey = false;
			}
			prevIndex = thisIndex;
			$li.addClass('active');

			// be greedy
			return false;
		})
		.bind('click', function(event) {
			// was this really just a click?
			if (Math.abs(event.pageX-posX) < 3 && Math.abs(event.pageY-posY) < 3) {
				if (!shiftKey && !event.metaKey) {
					$li.siblings().removeClass('active');
				}
			}

			// be greedy
			return false;
		});
	});
};

})(jQuery);