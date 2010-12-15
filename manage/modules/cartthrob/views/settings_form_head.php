<?php global $PREFS; ?>
<link href="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/css/cartthrob.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/lib/jquery.hoverIntent.js" ></script> 
<!-- optional -->
<script type="text/javascript" src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/scripts/jquery.cluetip.js" ></script>
<script type="text/javascript">

	var current_section = (location.href.indexOf('#') != -1 && location.href.split('#')[1].length > 0) ? location.href.split('#')[1] : 'get_started';
	jQuery(document).ready(function($){
		
		
		// BEGIN HIDE/SHOW SETTINGS AFTER APPROPRIATE SETTINGS HAVE BEEN CHOSEN
			function check_selected_weblog(selector, section)
			{
				if ($(selector).val() !="")
				{
					$(section).css("display","inline");
				}
				else
				{
					$(section).css("display","none");
				
				}
			}
			check_selected_weblog('#select_orders', ".requires_orders_blog"); 
			check_selected_weblog('#select_purchased_items', ".requires_purchased_items_blog"); 
			check_selected_weblog('#select_coupon_code', ".requires_coupons_blog"); 
			check_selected_weblog('#select_discount', ".requires_discounts_blog"); 
		
			$('#select_orders').change(function(){
				check_selected_weblog('#select_orders', ".requires_orders_blog"); 
			});
			$('#select_purchased_items').change(function(){
				check_selected_weblog('#select_purchased_items', ".requires_purchased_items_blog"); 
			});
			$('#select_coupon_code').change(function(){
				check_selected_weblog('#select_coupon_code', ".requires_coupons_blog"); 
			});
			$('#select_discount').change(function(){
				check_selected_weblog('#select_discount', ".requires_discounts_blog"); 
			});
		// END HIDE/SHOW SETTINGS. 
		
		
		$('#submit_install_templates').click(function(){
			$('input.templates:checked').each(function(){
				$('#install_templates').append('<input type="hidden" name="templates[]" value="'+$(this).val()+'" />');
			});
			$('#install_templates').submit();
			return false;
		});
		$('#ct_navigation').accordion({
			active: $('a[href=#'+current_section+']').parent().parent().prev(),
			header: '.head',
			navigation: true,
			//clearStyle: true,
			//animated: 'bounceslide',
			autoheight: false,
			collapsible: true
		});
		$('a.ct_question_bttn').cluetip({
			local: true, 
			sticky: true,
			cursor: 'pointer'
		});
		$('.ct_show_section').click(function(){
			var id = $(this).attr('href').split('#')[1];
			$('#ct_right_column .current').removeClass('current').slideUp();
			$('#'+id).addClass('current').slideDown('normal', function(){
				$('#'+id).effect("bounce", { times: 1, distance: 8 }, 300);
			});
			$('#cartthrob_tab').val(id);
			current_section = id;
			/*
			$('#ct_right_column .current').removeClass('current').fadeOut('normal', function(){
				$('#'+id).addClass('current').fadeIn();
				$('#cartthrob_tab').val(id);
				current_section = id;
			});
			*/
		});
		$('.ct_section').not('#'+current_section).hide();
		$('#'+current_section).addClass('current');
		$('#cartthrob_tab').val(current_section);
		$('select.weblogs').change(function(){
			var weblog_id = Number($(this).val());
			var section = $(this).attr('id').replace('select_', '');
			$('select.field_'+section).children().not('.blank').remove();
			$('select.status_'+section).children().not('.blank').remove();
			if ($(this).val() != "")
			{
				for (var i=0;i<weblog_fields[weblog_id].length;i++)
				{
					$('select.field_'+section).append('<option value="'+weblog_fields[weblog_id][i][0]+'">'+weblog_fields[weblog_id][i][2]+'</option>');
				}
				for (var i=0;i<weblog_statuses[weblog_id].length;i++)
				{
					$('select.status_'+section).append('<option value="'+weblog_statuses[weblog_id][i][1]+'">'+weblog_statuses[weblog_id][i][2]+'</option>');
				}
			}
		});
		/*.each(function() {
			if ($(this).val() != '' && $(this).parent().next().find('select:first').children().not('.blank').length < 1)
			{
				$(this).change();
			}
		});*/
		$('select.plugins').change(function(){
			var type = $(this).attr('id').replace('select_', '');
			var classname = $(this).val();
			$('.'+type+'_settings').hide();
			$('#'+classname).show();
		}).each(function() {
			if ($(this).val() != '')
			{
				$(this).change();
			}
		});
		$('fieldset.plugin_add_new_setting a').click(function(){
			var name = $(this).attr('id').replace('add_new_', '');
			var count = ($('tr.'+name+'_setting:last').length > 0) ? Number($('tr.'+name+'_setting:last').attr('id').replace(name+'_setting_','')) + 1 : 0;
			var plugin_classname = $('#'+name+'_blank').parent().parent().attr('class');
			var setting_short_name = $('#'+name+'_blank').attr('class');
			var clone = $('#'+name+'_blank').clone();
			clone.attr({'id':name+'_setting_'+count});
			clone.attr({'class':name+'_setting'});
			clone.find(':input').each(function(){
				var matrix_setting_short_name = $(this).parent().attr('class');
				$(this).attr('name', plugin_classname+'_settings['+setting_short_name+']['+count+']['+matrix_setting_short_name+']');	
			});
			clone.children('td').attr('class','');
			$(this).parent().prev().find('tbody').append(clone);
			if ( ! has_live())
			{
				activate_remove_matrix_row_buttons();
			}
			return false;
		});
		$('fieldset#add_product_weblog a').click(function(){
			var clone = $('div#product_weblog_blank').clone();
			clone.insertBefore('fieldset#add_product_weblog').attr({id: ''}).show().find('select.product_weblog').attr({name: 'product_weblogs[]'});
			$(this).parent().prev().find('tbody').append(clone);
			if ( ! has_live())
			{
				setup_product_weblogs();
				activate_remove_matrix_row_buttons();
			}
			return false;
		});
		$('fieldset#add_tax_setting a').click(function(){
			var count = ($('fieldset.tax_setting:last').length > 0) ? Number($('fieldset.tax_setting:last').attr('id').replace('tax_setting_','')) + 1 : 0;
			var clone = $('fieldset#tax_setting_blank').clone();
			clone.insertBefore('fieldset#add_tax_setting').attr('id','tax_setting_'+count).addClass('tax_setting').show();
			clone.find('select.state_dropdown').attr('name', 'tax_settings['+count+'][state]');
			clone.find('input.zip_code_box').attr('name', 'tax_settings['+count+'][zip]');
			clone.find('input.tax_rate').attr('name', 'tax_settings['+count+'][rate]');
			if ( ! has_live())
			{
				activate_remove_matrix_row_buttons();
			}
			return false;
		});
		$('fieldset#add_int_tax_setting a').click(function(){
			var count = ($('fieldset.int_tax_setting:last').length > 0) ? Number($('fieldset.int_tax_setting:last').attr('id').replace('int_tax_setting_','')) + 1 : 0;
			var clone = $('fieldset#int_tax_setting_blank').clone();    
			clone.insertBefore('fieldset#add_int_tax_setting').attr('id','int_tax_setting_'+count).addClass('int_tax_setting').show();
			clone.find('input.int_name').attr('name', 'tax_settings['+count+'][name]');
			clone.find('select.int_state_dropdown').attr('name', 'tax_settings['+count+'][state]');
			clone.find('input.int_zip_code_box').attr('name', 'tax_settings['+count+'][zip]');
			clone.find('input.int_tax_rate').attr('name', 'tax_settings['+count+'][rate]');
			clone.find('input.int_tax_shipping').attr('name', 'tax_settings['+count+'][tax_shipping]');
			if ( ! has_live())
			{
				activate_remove_matrix_row_buttons();
			}
			return false;
		});
		$('.add_matrix_row').click(function(){
			var name = $(this).attr('id').replace('_button', '');
			var index = ($('.'+name+'_row:last').length > 0) ? Number($('.'+name+'_row:last').attr('id').replace(name+'_row_','')) + 1 : 0;
			var clone = $('#'+name+'_row_blank').clone(); 
			clone.attr('id', name+'_row_'+index).addClass(name+'_row').show();
			clone.find(':input').each(function(){
				$(this).attr('name', $(this).attr('rel').replace('INDEX', index));
			});
			$(this).parent().before(clone)
			if ( ! has_live())
			{
				activate_remove_matrix_row_buttons();
			}
			return false;
		});
		
		
		
		
		if (has_live())
		{
			$('select.product_weblog').live('change', function(){
				var weblog_id = Number($(this).val());
				if (weblog_id != '')
				{
					$(this).parent().find('select').not('.product_weblog').children().not('.blank').remove();
					for (var i=0;i<weblog_fields[weblog_id].length;i++)
					{
						$(this).parent().find('select').not('.product_weblog').append('<option value="'+weblog_fields[weblog_id][i][0]+'">'+weblog_fields[weblog_id][i][2]+'</option>');
					}
					$(this).parent().find('.product_price').attr('name', 'product_weblog_fields['+weblog_id+'][price]');
					$(this).parent().find('.product_shipping').attr('name', 'product_weblog_fields['+weblog_id+'][shipping]');
					$(this).parent().find('.product_weight').attr('name', 'product_weblog_fields['+weblog_id+'][weight]');
					$(this).parent().find('.product_global_price').attr('name', 'product_weblog_fields['+weblog_id+'][global_price]');
				}
			});
			$('a.remove_matrix_row').live('click', function(){
				if (confirm('Are you sure you want to delete this row?'))
				{
					if ($(this).parent().get(0).tagName.toLowerCase() == 'td')
					{
						$(this).parent().parent().remove();
					}
					else
					{
						$(this).parent().remove();
					}
				}
				return false;
			}).live('mouseover', function(){
				$(this).find('img').animate({opacity:1});
				console.log('in');
			}).live('mouseout', function(){
				console.log('out');
				$(this).find('img').animate({opacity:.2});
			}).find('img').css({opacity:.2});
		}
		else
		{
			setup_product_weblogs();
			activate_remove_matrix_row_buttons();
		}
	});
	
	function has_live()
	{
		return ($().jquery >= '1.3');
	}
	
	/* 	for jquery < 1.3 */
	function setup_product_weblogs()
	{
		$('select.product_weblog').change(function(){
			var weblog_id = Number($(this).val());
			if (weblog_id != '')
			{
				$(this).parent().find('select').not('.product_weblog').children().not('.blank').remove();
				for (var i=0;i<weblog_fields[weblog_id].length;i++)
				{
					$(this).parent().find('select').not('.product_weblog').append('<option value="'+weblog_fields[weblog_id][i][0]+'">'+weblog_fields[weblog_id][i][2]+'</option>');
				}
				$(this).parent().find('.product_price').attr('name', 'product_weblog_fields['+weblog_id+'][price]');
				$(this).parent().find('.product_shipping').attr('name', 'product_weblog_fields['+weblog_id+'][shipping]');
				$(this).parent().find('.product_weight').attr('name', 'product_weblog_fields['+weblog_id+'][weight]');
				$(this).parent().find('.product_price_modifiers').attr('name', 'product_weblog_fields['+weblog_id+'][price_modifiers][]');
				$(this).parent().find('.product_global_price').attr('name', 'product_weblog_fields['+weblog_id+'][global_price]');
			}
		});
	}
	
	function activate_remove_matrix_row_buttons()
	{
		$('a.remove_matrix_row').bind('click', function(){
			if (confirm('Are you sure you want to delete this row?'))
			{
				if ($(this).parent().get(0).tagName.toLowerCase() == 'td')
				{
					$(this).parent().parent().remove();
				}
				else
				{
					$(this).parent().remove();
				}
			}
			return false;
		}).bind('mouseover', function(){
			$(this).find('img').animate({opacity:1});
			console.log('in');
		}).bind('mouseout', function(){
			console.log('out');
			$(this).find('img').animate({opacity:.2});
		}).find('img').css({opacity:.2});
	}
	
	var weblogs = new Array();
	var weblog_fields = new Array();
	var weblog_statuses = new Array();
	
<?php foreach ($weblog_titles as $weblog_id => $blog_title) : ?>
	weblogs[<?php echo $weblog_id; ?>] = '<?php echo str_replace("'", '&#39;', $blog_title); ?>';
<?php endforeach; ?>

<?php foreach ($fields as $key => $value) : ?>
	weblog_fields[<?php echo $key; ?>] = new Array();
	
	<?php foreach ($value as $count => $field_data) : ?>
	weblog_fields[<?php echo $key; ?>][<?php echo $count; ?>] = ['<?php echo $field_data['field_id']; ?>', '<?php echo $field_data['field_name']; ?>', '<?php echo str_replace("'", '&#39;', $field_data['field_label']); ?>'];
	<?php endforeach; ?>
	
<?php endforeach; ?>

<?php foreach ($statuses as $key => $value) : ?>
	weblog_statuses[<?php echo $key; ?>] = new Array();
	
	<?php foreach ($value as $count => $status) : ?>
	weblog_statuses[<?php echo $key; ?>][<?php echo $count; ?>] = ['<?php echo $status['status_id']; ?>', '<?php echo $status['status']; ?>', '<?php echo ucwords(str_replace(array("'", '_'), array('&#39;', ' '), $status['status'])); ?>'];
	<?php endforeach; ?>
	
<?php endforeach; ?>
</script>
