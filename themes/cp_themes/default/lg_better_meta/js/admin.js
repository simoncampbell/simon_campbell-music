(function($){

	// Plugin for tab and form functionality
	$.fn.LG_BetterMetaExt = function(opts) {

		return this.each(function() {

			var obj = {
				id: this.id,
				dom: {
					$container: $(this),
					$restricted_els: $("[recommended_length]", this)
				},
				options : $.meta ? $.extend({}, opts, $this.data()) : opts
			}
			toggleShowTabSettings(obj);
			initRecommendedLength(obj);
		});

		function toggleShowTabSettings(obj){
			$show_triggers = $("select[name$='show_tab]']").change(function() {
				weblog_id = this.name.match(/\d+/)[0];
				$th_cell = $(this).parent().prev().prev();
				$trs = $(".lg_better_meta_ext_weblogs_"+weblog_id+"_target");
				if(this.value == "y"){
					$th_cell.attr({'rowspan': $trs.length + 1});
					$trs.show();
				}
				else{
					$th_cell.attr({'rowspan': '1'});
					$trs.hide();
				}
			}).change();
		}
		
		function initRecommendedLength(obj){
			obj.dom.$restricted_els.each(function(index)
			{
				var rec_len = this.getAttribute('recommended_length');
				var $counter = $('<div>').addClass("counter");
				$counter.html('Recommended length ' + rec_len +
							' characters | Current characters: <span>0</span>/' +
							rec_len
					);
				
				var checkMax = 	function() {
					var cur_len = this.value.length;
					if (cur_len > rec_len)
						$counter.addClass("toomuch");
					else
						$counter.removeClass("toomuch");
					$("span", $counter).text(cur_len);
				};

				$(this).after($counter);

				$(this).keyup(checkMax);
				$(this).change(checkMax);
				checkMax.apply(this);
			});
		}

		// private function for debugging
		function debug($obj) {
			if (window.console && window.console.log)
			window.console.log($obj);
		};

	};

	$.fn.LG_BetterMetaExt.defaults = {};

	$('#Lg_better_meta_settings, #blockbm').LG_BetterMetaExt();

})(jQuery);