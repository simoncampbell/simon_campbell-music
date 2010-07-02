<?php

$L = array(

//----------------------------------------
// Required for MODULES page
//----------------------------------------

"super_search_module_name"				=>
"Super Search",

"super_search_module_description"		=>
"Enables better searching behaviors",

//----------------------------------------
//  Main Menu
//----------------------------------------

'homepage'								=>
"Homepage",

'fields'								=>
"Fields",

'documentation'							=>
"Documentation",

//----------------------------------------
//  Buttons
//----------------------------------------

'save'									=>
"Save",

//----------------------------------------
//  Homepage & Global
//----------------------------------------

'success'								=>
"Success!",

//----------------------------------------
//  Clear cache
//----------------------------------------

'cache'									=>
"Cache",

'clear_search_cache'					=>
"Clear cached searches",

'cache_cleared'							=>
"The search cache was successfully cleared.",

//----------------------------------------
//	Fields
//----------------------------------------

'custom_field_group' =>
"Custom Field Group",

'no_fields'								=>
"There are no custom fields for this site.",

'id'									=>
"ID",

'name'									=>
"Name",

'label'									=>
"Label",

'type'									=>
"Type",

'length'								=>
"Length",

'precision'								=>
"Precision",

'edit_field'							=>
"Edit Field",

'field_explanation'						=>
"This tool allows you to control the MySQL data types of the custom fields in your site. You can improve site performance by changing MySQL field types to use only the amount of space necessary for your data. As well, if one of your fields will contain only numbers, choose a MySQL field type that supports sorting data numerically instead of alphabetically.",

'character_explanation'					=>
"A character or char field contains small alphanumeric strings. Use a character field to store fields with simple values like 'yes', 'no', 'y', 'n'",

'integer_explanation'					=>
"An integer field can contain whole numbers. They are larger than small integer or tiny integer field types and takes up more memory.",

'float_explanation'						=>
"A float field is the best field to use if you will be storing decimal values. You can specify the total length of the field as well as the decimal precision. Fields of this type are intended for storing prices that can be sorted numerically.",

'decimal_explanation'						=>
"A decimal field is a good field to use if you will be storing decimal values, for example monetary amounts. You can specify the total length of the field as well as the decimal precision.",

'precision_explanation'					=>
"The precision value indicates the number of decimal places to reserve for a floating point number.",

'small_integer_explanation'				=>
"A small integer field is smaller than an integer field and larger than a tiny integer field. Most numbers can be stored in this type of field.",

'text_explanation'						=>
"A text field is one of the largest MySQL field types. They can contain large amounts of text or numeric data. Only if you will be storing large blocks of text should you use this field type.",

'tiny_integer_explanation'				=>
"A tiny integer field is the smallest field type. Store only very small numbers in tiny integer fields.",

'varchar_explanation'					=>
"A varchar field is one of the most commonly used types of MySQL fields. It can contain fairly long strings but not take up the large amount of space that a text field will.",

'field_length_required'					=>
"Please indicate a length for your field.",

'char_length_incorrect'					=>
"A character field length must be between 1 and 255.",

'float_length_incorrect'				=>
"A float field length must not be less than 1.",

'precision_length_incorrect'			=>
"A float field length must be larger than its decimal precision.",

'integer_length_incorrect'				=>
"An integer field length must be between 1 and 4294967295.",

'small_integer_length_incorrect'		=>
"A small integer field length must be between 1 and 65535.",

'tiny_integer_length_incorrect'			=>
"A tiny integer field length must be between 1 and 255.",

'varchar_length_incorrect'				=>
"A varchar field length must be between 1 and 255.",

'edit_confirm'							=>
"Confirm changes to field.",

'edit_field_question'					=>
"You are about to edit a field. Are you sure you want to proceed?",

'edit_field_question_truncate'			=>
"Because of the field type that you are converting to, there will be truncation and removal of data in the '%field_label%' field of %count% records. The changes cannot be undone. Are you sure you want to proceed?",

'field_edited_successfully'				=>
"Your field was successfully edited.",

//----------------------------------------
//	Preferences
//----------------------------------------

'preferences'	=>
"Preferences",

'preferences_exp'	=>
"Preferences for Super Search can be controlled on this page.",

'preferences_not_available'	=>
"Preferences are not yet available for this module.",

'preferences_updated'	=>
"Preferences Updated",

'allow_keyword_search_on_playa_fields'	=>
"Allow keyword searching on Playa fields?",

'allow_keyword_search_on_playa_fields_exp'	=>
"Keyword searching on Playa fields can lead to confusing search results. Only if you want to keyword search the titles of entries related to a given entry should you enable this setting.",

'allow_keyword_search_on_relationship_fields'	=>
"Allow keyword searching on Relationship fields?",

'allow_keyword_search_on_relationship_fields_exp'	=>
"Keyword searching on native EE relationship fields can lead to confusing search results. Only if you want to keyword search the titles of entries related to a given entry should you enable this setting.",

'yes'	=>
"Yes",

'no'	=>
"No",

//----------------------------------------
//	Caching rules
//----------------------------------------

'manage_caching_rules' =>
"Manage Caching Rules",

'current_cache' =>
"Current Cache",

'refresh' =>
"Refresh",

'refresh_rules' =>
"Refresh Rules",

'refresh_explanation' =>
"Leaving this value at 0 will cause the search cache to only be refreshed by the weblog or template update rules below.",

'template_refresh' =>
"Template Refresh",

'template_refresh_explanation' =>
"When one of these chosen templates is edited, the search cache will be refreshed.",

'weblog_refresh' =>
"Weblog Refresh",

'weblog_refresh_explanation' =>
"When an entry is published or edited in one of these weblogs, the search cache will be refreshed.",

'category_refresh' =>
"Category Refresh",

'category_refresh_explanation' =>
"When a category is created or edited in one of these category groups, the search cache will be refreshed.",

'rows' =>
"rows",

'refresh_now' =>
"Refresh now",

'next_refresh' =>
"(Next refresh: %n%)",

'in_minutes' =>
"(in minutes)",

'name_required' =>
"A name is required for all morsels.",

'name_invalid' =>
"The name you provided is invalid.",

'numeric_refresh' =>
"The morsel refresh interval must be numeric.",

'refresh_rule_updated' =>
"Your Caching rules have been updated and your cache has been refreshed.",

//----------------------------------------
//  Update Page
//----------------------------------------

'update_super_search'					=>
"Update Super Search",

'super_search_update_message'	=>
"You have recently uploaded a new version of Super Search, please click here to run the update script.",

'update_successful'						=>
"Update Successful!",

//----------------------------------------
//	Front-end search
//----------------------------------------

'search_not_allowed'					=>
"You are not allowed to search.",

//----------------------------------------
//	Front-end search saving
//----------------------------------------

'search'	=>
"Search",

'search_not_found'	=>
"Your search could not be found.",

'missing_name'	=>
"Please provide a name for your search.",

'duplicate_name'	=>
"That name has already been used for a saved search.",

'invalid_name'	=>
"The search name you have provided is not valid.",

'duplicate_search'	=>
"You have already saved this search.",

'search_already_saved'					=>
"You have already saved the indicated search.",

'search_successfully_saved'				=>
"Your search has been successfully saved.",

'search_successfully_unsaved'			=>
"Your search has been successfully un-saved.",

'search_already_unsaved'				=>
"You have already un-saved the indicated search.",

'search_successfully_deleted'			=>
"Your search has been successfully deleted.",

'no_search_history_was_found'	=>
"No search history was found for you.",

'last_search_cleared'	=>
"Your last search has been cleared.",

/* END */
''=>''
);
?>