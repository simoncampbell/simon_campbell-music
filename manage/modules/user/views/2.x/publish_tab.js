
(function(global){

	global.AddOnBuilder = global.AddOnBuilder || {};
	var AddOnBuilder = global.AddOnBuilder;

	global.Solspace = global.Solspace || {};
	global.Solspace.prototype = AddOnBuilder;
	var Solspace = global.Solspace;
	
})(window);

Solspace.user = Solspace.user || function(global) 
{
	var utils = {};
	var version = '3.0.0';
	var cleanupPrimaryAuthorTimer = null;
	
	utils.version = function()
	{
		return version;
	};
	
	utils.cleanupPrimaryAuthor = function()
	{
		possibleAuthors = jQuery.trim(jQuery("#user__solspace_user_browse_authors").val()).replace(/,\s*$/g, '').replace(/,\s*/g, ',').split(',');
		
		jQuery('#user__solspace_user_primary_author option').each(function()
		{
			authorFound = false;
			
			optionText = jQuery(this).text();
			
			for (i = 1, s = possibleAuthors.length ; i < s; i++)
			{
				alert(jQuery(this).text());
				
				if (jQuery(this).text().indexOf(possibleAuthors[i]) != -1)
				{
					authorFound = true;
				}
			}
			
			if (authorFound == false)
			{
				jQuery(this).remove();
			}
		});
	};
	
	utils.cleanupPrimaryAuthorStart = function()
	{
		// Handles multiple calls
		if ( cleanupPrimaryAuthorTimer == null )
		{
			clearTimeout(cleanupPrimaryAuthorTimer);
			
			cleanupPrimaryAuthorTimer = setTimeout(function()
			{
				cleanupPrimaryAuthorTimer = null;
				Solspace.user.cleanupPrimaryAuthor();
			},
			400);
		}
	};
	
	return utils;
}(window);


jQuery(document).ready(function()
{
	jQuery("#menu_user a").html("<?php echo $tag_name;?>"); // Change Tab Name to Our Custom One in Preferences
	jQuery('#id_user__solspace_user_browse_authors').hide(); // Hide the WriteMode image for our Tag Field
	//jQuery('label[for=tag__solspace_tag_suggest]').hide();
	
	jQuery("#user__solspace_user_browse_authors").autocomplete("<?php echo $base_uri;?>&method=browse_authors_autocomplete",
	{
		multiple: true,
		mustMatch: false,
		autoFill: false,
		cacheLength: 0,
		delay: 250,
		multipleSeparator: ', ',
		extraParams: { current_authors: function() { return jQuery("#user__solspace_user_browse_authors").val(); } }
	});
	
	jQuery("#user__solspace_user_browse_authors").result(function(event, data, formatted)
	{
		jQuery('#user__solspace_user_primary_author').append(jQuery('<option />').text(formatted));
	});
	
	jQuery("#user__solspace_user_browse_authors").keyup(function(event)
	{
		if (event.keyCode == 46 || event.keyCode == 8)
		{
			Solspace.user.cleanupPrimaryAuthorStart();
		}
	});
	
});




