(function($) {

	// plugin definition
	$.fn.MOR_Togglable = function(options) {
		var opts = $.extend({}, $.fn.MOR_Togglable.defaults, options);
		return this.each(function() {
			var $self = $(this);
			$self
				.unbind('toggle.MOR_Togglable')
				.bind('toggle.MOR_Togglable', opts, $.MOR_Togglable._toggle)
 				.data('open.MOR_Togglable', true);
			var $trigger = ($.isFunction(opts.trigger)) ? opts.trigger.call($self) : $(opts.trigger, $self);

			// console.log("Creating togglable", $self);
			// console.log("Binding triggers", $trigger);

			$trigger
				.unbind(opts.event + ".MOR_Togglable")
				.bind(opts.event + ".MOR_Togglable", opts, function(){
					$self.trigger('toggle.MOR_Togglable');
					return false;
				});
			if($self.hasClass(opts.closedClass) == true){
				$self.data('open.MOR_Togglable', true);
				$self.trigger('toggle.MOR_Togglable');
			}
		});
	};

	$.MOR_Togglable = {
		_toggle: function(e){
			e.stopPropagation();
			$container = $(this);
			open = $container.data('open.MOR_Togglable');
			if(!e.data.startToggle.apply($container)) return;
			$targets = $(e.data.targets, $container);
			$triggers = $(e.data.trigger, $container);
			// console.log("toggling: ", $targets);
			if(open == true){
				$triggers
					.removeClass(e.data.openTriggerClass)
					.addClass(e.data.closedTriggerClass);
				$targets.hide();
				$container
					.removeClass(e.data.openClass)
					.addClass(e.data.closedClass)
					.data('open.MOR_Togglable', false);
			} else {
				$container
					.removeClass(e.data.closedClass)
					.addClass(e.data.openClass)
					.data('open.MOR_Togglable', true);
				$targets.fadeIn("fast");
				$triggers
					.removeClass(e.data.closedTriggerClass)
					.addClass(e.data.openTriggerClass);
			}
			e.data.endToggle.apply($container);
		}
	};

	$.fn.MOR_Togglable.defaults = {
		event: 'click',
		effect: '',
		trigger: '.btn.toggle',
		targets: '> *:gt(0)',
		openClass: 'open',
		closedClass: 'closed',
		openTriggerClass: 'collapse',
		closedTriggerClass: '',
		startToggle: function(){  /* console.log("starting toggle: ", this); */ return true; },
		endToggle: function(){  /* console.log("ending toggle", this); */ },
	};

// end of closure
})(jQuery);