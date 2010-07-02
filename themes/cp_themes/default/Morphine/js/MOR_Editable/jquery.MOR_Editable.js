(function($) {

	// plugin definition
	$.fn.MOR_Editable = function(options) {
		var opts = $.extend({}, $.fn.MOR_Editable.defaults, options);
		this.each(function() {
			var dom = {}
				dom.$container = $(this).data('editing.MOR_Editable', false);
				dom.$placeholder = $('.placeholder', dom.$container);
				dom.$edit_area = $('.edit_area', dom.$container);
				dom.$input = $('input, textarea', dom.$edit_area)
					.keydown(function(event){
						// save on enter
						if(event.keyCode == 13 && $(this).is("textarea") == false){
							dom.$container.trigger("save.MOR_Editable");
							return false;
						}
						// cancel on escape
						if(event.keyCode == 27){
							dom.$container.trigger("cancel.MOR_Editable");
						}
					});
			var data = {opts: opts, 'dom': dom}
			dom.$container
				.bind(opts.event + ".MOR_Editable", data, $.MOR_Editable._edit)
				.bind('edit.MOR_Editable', data, $.MOR_Editable._edit)
				.bind('save.MOR_Editable', data, $.MOR_Editable._save)
				.bind('cancel.MOR_Editable', data, $.MOR_Editable._cancel)
				.bind('cleanup.MOR_Editable', data, $.MOR_Editable._cleanup)
				.bind('destroy.MOR_Editable', data, $.MOR_Editable._destroy)
				.trigger("save.MOR_Editable");

		});
		return this;
	};

	$.MOR_Editable = {
		_edit: function(e){
			e.stopPropagation();
			$target = $(this);
			if ($target.data('editing.MOR_Editable')) { return; };
			// console.log("editing:", $target);
			e.data.dom.$placeholder.hide();
			e.data.dom.$edit_area.fadeIn().focus();
			$.MOR_Editable.triggers.apply(e.data.dom.$edit_area);
			$target
				.addClass("editing")
				.data('editing.MOR_Editable', true);
		},
		_save: function(e){
			//console.log("saving edit", $(this));
			old_val = $.trim(e.data.dom.$input.val());
			new_val = (old_val) ? old_val : e.data.opts.placeholder_text;
			new_val = new_val.replace(/<\s*script\s*.*>.*<\/\s*script\s*.*>/gi, "");
			e.data.dom.$placeholder.text(new_val);
			$(this).trigger("cleanup.MOR_Editable");
		},
		_cancel: function(e){
			//console.log("cancelling edit", $(this));
			$(this).trigger("cleanup.MOR_Editable");
			if(e.data.dom.$placeholder.text() != e.data.opts.placeholder_text){
				e.data.dom.$input.val($.trim(e.data.dom.$placeholder.text()));
			}
		},
		_cleanup: function(e){
			$target = $(this);
			//console.log("cleaning up post edit", $target);
			e.data.dom.$placeholder.fadeIn();
			e.data.dom.$edit_area.hide();
			$target
				.removeClass("editing")
				.data('editing.MOR_Editable', false);
			if(e.data.dom.$placeholder.text() == e.data.opts.placeholder_text){
				console.log(e.data.dom.$input.val(""));
			}
			$("div", e.data.dom.$edit_area).remove();
		},
		_destroy: function(e){
			$target = $(this);
			// console.log("destroying editable", $target);
			$target
				.trigger("cancel.MOR_Editable")
				.unbind(".MOR_Editable");
		},
		triggers: function(){
			var $target = $(this);
			var submit = $("<input type='submit' value='Update' />").click(function(e) {
				$target.trigger("save.MOR_Editable");
				return false;
			});
			var cancel = $("<a/>")
							.attr({'href': '#', 'class': 'cancel'})
							.text("cancel")
							.click(function(e) {
				$target.trigger("cancel.MOR_Editable");
				return false;
			});
			var div = $("<div>").append(submit, " or ", cancel);
			$target.append(div);
		}
	}

	$.fn.MOR_Editable.defaults = {
		event: 'click',
		placeholder_text: 'Click to edit'
	}

// end of closure
})(jQuery);
