<?php
/**
* English language file for NSM Publish Plus
* 
* This file must be placed in the
* /system/language/english/ folder in your ExpressionEngine installation.
*
* @package NSMPublishPlus
* @version 1.1.0
* @author Leevi Graham <http://newism.com.au>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/nsm-publish-plus/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement/
*/

$L = array(
	"nsm_pp_name"							=> "NSM Publish Plus",
	"nsm_pp_description" 					=> "Improved Publish workflow for ExpressionEngine",
	
	"access_title"							=> "Enable extension",
	"enable_extension_for_this_site_label" 	=> "Enable Publish Plus for this site?",
	
	"publish_form_customisation_title"		=> "Publish form customisation",
	"show_preview"							=> "Show preview when loading drafts and revisions?",

	'url_triggers_title'			=> 'URL triggers',
	'url_triggers_info'				=> '<p style="line-height:18px">URL triggers tell NSM Publish Plus to load a specified draft or revision based on the segment after the trigger. The following url will load the draft, with an ID of 7 for the related entry: <code style="display:inline-block;">http://yoursite.com/blog/entry/18/draft/7/</code> </p>',
	'draft_trigger_label'			=> 'Draft url trigger',
	'revision_trigger_label'		=> 'Revision url trigger',
	'preview_trigger_label'			=> 'Preview url trigger',

	'lg_live_look_integration_title'	=> 'LG Live Look integration',
	'disable_ee_preview_label'			=> 'Disable default preview for previews and revisions?',

	'check_for_updates_title' 	=> 'Check for updates?',
	'check_for_updates_info' 	=> 'NSM Publish Plus can call home (<a href="http://leevigraham.com/">http://leevigraham.com</a>) and check for recent updates if you allow it. <strong>This feature requires <a href="http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/">LG Addon Updater</a> to be installed and activated</strong>.',
	'check_for_updates_label' 	=> 'Would you like this extension to check for updates and display them on your CP homepage?',

	'admin_title'				=> 'Admin options',
	'show_promos_label'			=> 'Show promos at the top of the settings page?',
	'show_donate_label'			=> 'Show donation link at the top of the settings page?',

	"group_settings_title"		=> "Group settings",
	"group_settings_info"		=> "<p>Users are assigned a default publishing role based on their member group. Roles can be assigned on a per user basis in their member preferences.</p>",

	"role_label"				=> "User role",
	"editor"					=> "Editor",
	"publisher" 				=> "Publisher",
	"member_group_defaults"		=> "Member group defaults",
	
	"all_weblogs"				=> "All Weblogs",
	"no_weblogs"				=> "No Weblogs",
	"other_weblogs"				=> "Other Weblogs",
	
	"which_weblogs_can_this_user_access" => "Which weblogs can this user access?",
	
	"notification_settings_title"	=> "Entry Notification Templates",
	"notification_settings_info"	=> "<p>Notifications can be sent when an entry is created, deleted or their status is edited. The following variables can be used in the notification subject and message:</p>
										<ul>
											<li>{site_id}</li>
											<li>{site_title}</li>
											<li>{action}</li>
											<li>{actor_name}</li>
											<li>{status}</li>
											<li>{old_status}</li>
											<li>{state}</li>
											<li>{old_state}</li>
											<li>{entry_id}</li>
											<li>{weblog_id}</li>
											<li>{weblog_title}</li>
											<li>{weblog_url}</li>
											<li>{weblog_description}</li>
											<li>{author_id}</li>
											<li>{author_name}</li>
											<li>{title}</li>
											<li>{url_title}</li>
											<li>{entry_date}</li>
											<li>{edit_date}</li>
											<li>{expiration_date}</li>
											<li>{edit_entry_url}</li>
										</ul>",

	"create_entry"					=> "Create Entry",
	"edit_entry"					=> "Edit Entry",
	"create_revision"				=> "Create Revision",
	"delete_entry"					=> "Delete Entry",
	"create_draft"					=> "Create Draft",
	"create_note"					=> "Create Note",
	"save_revision"					=> "Save Revision",
	"quicksave_revision"			=> "Quicksave Revision",
	"submit_for_approval"			=> "Submit for Approval",
	"save_as_draft"					=> "Save Draft",
	
	"add_template"					=> "Add notification template",
	"remove_template_confirmation"	=> "Are you sure you would like to delete this template?",
	"changes_will_not_take_affect"	=> "Changes will not take affect until you have updated the extension settings",

	"notes"							=> "notes",
	"edit_notes"					=> "edit notes",
	"edit_notes_info"				=> "<p>Enter a note below describing the edits you have made in this draft. Edit notes will be associated with the draft and not the entire entry.</p><p><strong>Edit notes will be added to the draft when a new draft is created.</strong></p>",
	"no_notes_warning"				=> "There are no existing notes for this entry",
	"leave_a_note"					=> "Leave a note",
	"add_this_note"					=> "Add note",
	"add_this_note_and_save_entry" 	=> "Add note",
	"preview_note"					=> "Preview note",
	
	"id"							=> "ID",
	"state"							=> "state",
	"drafts"						=> "drafts",
	"draft_info"					=> "Drafts are just like  <a href='#' onclick='showblock(\"blockrevisions\"); stylereset(\"revisions\"); return false;'>revisions</a> except changes are not made live until they have been published.",
	"draft"							=> "draft",
	"draft_num"						=> "draft #",
	"draft_title"					=> "draft title",
	"draft_date"					=> "draft date",
	"draft_author"					=> "draft author",
	"load_draft"					=> "load draft",
	"no_drafts_exist"				=> "There are currently no drafts for this entry.",
	"no_draft_notes_exist"			=> "There are no notes for this draft.",
	"load_draft"					=> "load draft",
	"draft_notes"					=> "draft notes",
	"draft_warning"					=> "You are about to load a previous draft. Any un-saved content currently in this page will be lost.",
	"unpublished_drafts"			=> "This entry has unpublished <a href='#' onclick='showblock(\"blocknsm_pp_workflow\"); stylereset(\"nsm_pp_workflow\"); return false;'>draft(s)</a>.",
	"viewing_unpublished_draft"		=> "You are currently viewing an unpublished <a href='#' onclick='showblock(\"blocknsm_pp_workflow\"); stylereset(\"nsm_pp_workflow\"); return false;'>draft</a>.",
	"viewing_published_revision"	=> "You are currently viewing the latest <a href='#' onclick='showblock(\"blockrevisions\"); stylereset(\"revisions\"); return false;'>revision</a>.",
	"viewing_revision"				=> "You are currently viewing an old <a href='#' onclick='showblock(\"blockrevisions\"); stylereset(\"revisions\"); return false;'>revision</a>.",
	"viewing_latest_draft"			=> "You are currently viewing an old <a href='#' onclick='showblock(\"blockrevisions\"); stylereset(\"revisions\"); return false;'>revision</a>.",

	"filter_by_state"				=> "Filter by State",
	"filter_by_status"				=> "Filter by Status",
	
	"workflow"						=> "workflow",
	"state"							=> "state",
	"entry_state"					=> "entry state",
	"workflow_state"				=> "workflow state",
	"state"							=> "state",
	"this_entry_is_currently"		=> "This entry is currently",
	"pending"						=> "pending",
	"approved"						=> "approved",
	"denied"						=> "denied",
	"un-assigned"					=> "un-assigned",
	"changed"						=> "changed",
	"workflow_info"					=> "<p>Workflow state will <strong>not</strong> restrict an entry being shown in a <code>{weblog:entries}</code> tag. The entry state is a visual representation of the entries position in your publishing workflow.</p>",
	"authors"						=> "authors",
	
	"action"						=> "action",
	"subject"						=> "subject",
	"message"						=> "message",
	"from"							=> "from",
	"to"							=> "to",
	"when_status_changes"			=> "when status changes",
	"when_state_changes"			=> "when state changes",
	"optional"						=> "optional",
	"weblogs"						=> "weblogs",
	"enable_notification"			=> "enable notification",
	"publish_plus_roles"			=> "Publish Plus roles",
	"ee_member_groups"				=> "ExpressionEngine member groups",
	"publishers"					=> "publishers",
	"editors"						=> "editors",
	"publishers_for"				=> "publishers for",
	"editors_for"					=> "editors for",
	"entry_author"					=> "entry author",
	"draft_authors"					=> "draft authors",
	"additional_recipients"			=> "additonal recipients",
	"comma_seperated_emails"		=> "comma_seperated_emails",

	// errors
	"error_empty_note"					=> "The entry note you submitted was empty.",
	"error_note_submit_db_error"		=> "There was an error saving your note to the database.",
	"error_draft_submit_db_error"		=> "There was an error saving your draft to the database.",
	"error_empty_note_preview"			=> "The entry note you previewed was empty.",
	"error_saving_entry_note_not_saved"	=> "The note has not been saved because the entry contained error(s).",
	"error_note_no_entry"				=> "Entry must be saved before a note can be added.",
	"error_sending_email"				=> "There was an error sending notification emails.",
	"error_invalid_draft_id"			=> "The draft you have tried to load no longer exists.",
	"error_invalid_preview_id"			=> "The draft you have tried to load no longer exists.",
	
	// success
	"success_note_added"			=> "Note added successfully.",
	"success_draft_submit"			=> "Draft created successfully",
	"success_approval_submit"		=> "Draft submitted for approval successfully",
	"success_revision_created"		=> "Revision created successfully",
	
	"no_draft_edit_note"			=> "You have not added an edit note for this draft. Do you want to continue anyway?",
	
	"currently_live"				=> "Currently Live",
	"undefined"						=> "undefined",
	

	"" => ""
);
?>