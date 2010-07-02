(function($) {

	$.fn.MOR_AttributeAssigner = function(options) {
		var options = options;
		return this.each(function () {
		    var $container = $(this).parents(".tg:eq(0)");
			var obj = {
					dom: {
						$container: $container,
						$trigger : $(this),
						$targets : $("select[id^='"+options.prefix+"_']:not(#"+this.id+")", $container)
					},
					cf_data: options.cf_data
				};
			// console.log(obj.dom.$trigger);
			// console.log("select[id^='"+options.prefix+"_']:not(#"+this.id+")");
			obj.dom.$trigger.change(function() {
				MOR_AttributeAssigner.update(obj);
			}).trigger("change");

		});
	}

	var MOR_AttributeAssigner = {

		update: function(obj) {

			var weblog_id = obj.dom.$trigger.val();
			var options = [];

			obj.dom.$targets.empty().hide();

			options[0] = document.createElement("OPTION");
			options[0].value = "";
			options[0].text = "Entry title";

			// console.log(obj.dom.$container);

			obj.dom.$targets.html(options);

			$(".no-custom-field-group-error", obj.dom.$container).remove();

			if(obj.cf_data[weblog_id])
			{
				$(obj.cf_data[weblog_id]).each(function(index) {
					options[index + 1] = document.createElement("OPTION");
					options[index + 1].value = obj.cf_data[weblog_id][index]['field_id'];
					options[index + 1].text = obj.cf_data[weblog_id][index]['field_label'] + " - (Field ID: " + obj.cf_data[weblog_id][index]['field_id'] + ")";
				});
				obj.dom.$targets.html(options).fadeIn();
			}
			else
			{
				obj.dom.$targets.after($("<p class='highlight no-custom-field-group-error' style='margin:0'>Custom fields have not been assigned to this weblog</p>"));
			}
		}
	}

})(jQuery);