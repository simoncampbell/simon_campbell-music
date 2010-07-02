/**
* JS file for NSM Publish Plus
* 
* This file must be placed in the
* /themes/cp_themes/default/nsm_publish_plus/js/ folder in your ExpressionEngine installation.
*
* @package NSMPublishPlus
* @version 1.1.0
* @author Leevi Graham <http://newism.com.au>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/nsm-publish-plus/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement/
*/

(function($) {

	$.fn.NSM_publishPlus = function(items, options) {

		return this.each(function() {

			var obj = {
				dom: {
					$container: $(this),
					$revision_tab_content: $("#blockrevisions"),
					$workflow_tab_content: $("#blocknsm_pp_workflow"),
					$edit_note: $("#blocknsm_pp_workflow textarea[name=draft_note]"),
					$buttons: $('button'),
					$note_triggers: $("#blocknsm_pp_workflow .note-trigger a")
				}
			}

			// note preview or submit?
			if(preview_val == "nsm_pp_note_preview" || preview_val == "nsm_pp_note_submit"){
				showblock('blocknsm_pp_notes');
				styleswitch('nsm_pp_notes');
			}

			obj.dom.$note_triggers.toggle(
				function () {
					$(this).parent().parent().next().show();
				},
				function () {
					$(this).parent().parent().next().hide();
				}
			);

			NSM_publishPlus.modifyRevisionTab(obj);
			NSM_publishPlus.setupButtons(obj);

		});
	}

	// some methods ... 
	var NSM_publishPlus = {
		modifyRevisionTab: function(obj){
			var $rev_link = $("<a />")
				.text("Load Revision")
				.attr("href", rev_link_url)
				.click(function() {
					if(!confirm(lg.lang.revision_warning)){
						return false;
					}
				});

			// set the width of all revision table td's to auto
			$("tbody tr td", obj.dom.$revision_tab_content).width("auto");
			
			// get the first table cell
			var $revision_table_cell = $("tbody tr:eq(2) td:eq(3)", obj.dom.$revision_tab_content);
			var table_cell_text = $.trim($revision_table_cell.text());

			// if the revision currently loaded or no text
			if( table_cell_text == lg.lang.currently_loaded || table_cell_text == "")
			{
				// add the revision link
				$revision_table_cell.prepend($rev_link);
			};

			// if the revision is currently loaded and there is a draft
			if(table_cell_text == lg.lang.currently_loaded && draft_id != '')
			{
				// remove the html
				 $table_cell.html("");
			}

			// add currently live message
			$revision_table_cell.append($("<span />").text(lg.lang.currently_live).attr("class", "success"));
			
			$("table.tableBorder tr", obj.dom.$revision_tab_content).each(function(index) {
				$tr = $(this);
				if(index == 0)
				{
					$tr.prepend("<td class='tableHeading'>ID</td>");
				}
				else
				{
					klass = (index % 2) ? "tableCellTwo" : "tableCellOne";
					$tr.prepend("<td class='"+klass+"'>"+revision_ids[index - 1]+"</td>");
				}

			});
			
			

		},
		setupButtons: function(obj){
			// button love
			obj.dom.$buttons.click(function(){
				$el = $(this);
				value = this.attributes.getNamedItem("value").nodeValue;
				// if submitting a draft
				if(value == "nsm_pp_draft_submit" || value == "nsm_pp_submit_for_approval")
				{
					// if there is no edit note
					if(obj.dom.$edit_note.val() == "")
					{
						// prompt the user
						if(confirm(lg.lang.no_draft_edit_note) == false)
						{
							showblock('blocknsm_pp_workflow');
							styleswitch('nsm_pp_workflow');
							obj.dom.$edit_note.focus();
							return false;
						}
					}
				}
				// fuck you IE6 and your stupid button support.
				if($.browser.msie && /6.0/.test(navigator.userAgent)){
					obj.dom.$buttons.each(function(index) {
						$(this).attr('disabled', 'disabled').html(this.attributes.getNamedItem("value").nodeValue);
					});
					$el.removeAttr('disabled');
				}
			});
		}
	};

	$.fn.NSM_publishPlusNotificationTemplates = function(items, options) {
		return this.each(function() {
			var obj = {
				dom: {
					$container: $(this),
					$tbody: $("tbody#templates"),
					$add_template_trigger: $("#add-template"),
					$delete_template_trigger: $("tbody#templates .delete"),
					$notification_action_selects: $("select.notification_action")
				}
			}

			obj.notification_count = $("tr", obj.dom.$tbody).length - 1;
			
			obj.dom.$add_template_trigger.click(function(){
				++obj.notification_count;
				clone = obj.dom.$tbody.find("> tr:eq(0)").clone(true);
				$("input[type=checkbox]", clone).attr("checked", "");
				$("input[type=text], input[type=hidden], textarea", clone).val("");
				$("select", clone).val("");
				$(".statuses", clone).hide();
				$("[name^=notification]", clone).each(function(index) {
					this.name = this.name.replace(/notifications\[\d+\]/i, "notifications["+obj.notification_count+"]");
				});
				obj.dom.$tbody.append(clone);
				clone.show();
				$("> tr:visible:even td", obj.dom.$tbody).attr("class", "tableCellOne");
				$("> tr:visible:odd td", obj.dom.$tbody).attr("class", "tableCellTwo");
				return false;
			});

			obj.dom.$delete_template_trigger.click(function() {
				if(confirm(lg.lang.remove_template_confirmation))
				{
					$tr = $(this).parent().parent();
					$tr.hide();
					$("input:hidden[name*=delete]", $tr).val("y");
					$("> tr:visible:even td", obj.dom.$tbody).attr("class", "tableCellOne");
					$("> tr:visible:odd td", obj.dom.$tbody).attr("class", "tableCellTwo");
				}
				return false;
			});

			obj.dom.$notification_action_selects.each(function(i){
				$(this).change(function(){
					$.NSM_publishPlusNotificationTemplates.showStatus(this);
				});
				$.NSM_publishPlusNotificationTemplates.showStatus(this);
			});

		})
	}
	
	$.NSM_publishPlusNotificationTemplates = {
		showStatus: function(el){
			$el = $(el);
			val = $el.val();
			$fieldset = $("fieldset.statuses, fieldset.states", $el.parent().parent());
			if(val == "create_entry" || val == "create_draft" || val == "submit_for_approval" || val == "create_revision")
			{
				$fieldset.fadeIn();
			}
			else
			{
				$fieldset.hide();
			}
		}
	};

})(jQuery);

jQuery("body").NSM_publishPlus();
jQuery("body").NSM_publishPlusNotificationTemplates();