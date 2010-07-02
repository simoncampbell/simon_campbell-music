<?php
if ( ! defined('EXT'))
{
    exit('Invalid file request');
}

/** -----------------------------------
/*   Modifies the Edit Tab page so that any changes
/*   of the search form pulldown fields will automatically
/*   have the results updated via AJAX.  Keywords input will also
/*   update the results but it requires an entry key or 'Search' button click.

/*   Version 1.1 -
		Mark Huot's Edit Remember tab caused a problem with the javascript, as it
		always expected the 'target' field to exist.  Modified javascript to create
		it through the DOM, if it was missing.
		
/*   Version 1.2 -
		Added @header("Content-type: text/html; charset=".$PREFS->ini('charset')); so that
		non-Latin characters might come through correctly via AJAX
		
/*   Version 1.2.1 -
		Exact Match checkbox was always seen as on, due to checkboxes being very moody in JavaScript.  Fixed that.
/** -----------------------------------*/

class Edit_tab_ajax
{
	var $settings = array();
	var $name = 'Edit Tab AJAX';
	var $version = '1.2.2';
	var $description = 'Adds the Ability for Dynamic Sorting in Edit Tab';
	var $settings_exist = 'n';
	var $docs_url = '';
	
	/** ---------------------------------
	/**  Constructor - Settings
	/** ---------------------------------*/
	
	function Edit_tab_ajax($settings='')
	{
		$this->searching_html = '<br /><div class="highlight">Searching...</div>';
	}
	/* END */
	
	
	/** ---------------------------------
	/**  Add JavaScript Call
	/** ---------------------------------*/
	
	function modify_form($form_data)
	{	
		global $DSP, $LANG, $EXT;
		
		if ($EXT->last_call !== FALSE)
		{
			$form_data = $EXT->last_call;
		}
		
		$editform_url = BASE.'&C=multiedit';
		$searchform_url = BASE.'&C=edit';
		
		$js = <<<EOT
<script type="text/javascript">

var XMLHttp=false;

function ajax_edit_tab()
{
	var serverPage = '{$searchform_url}';
	
	data = "XID={XID_SECURE_HASH}&edit_ajax=y";
	
	var editFormElements = document.getElementById('filterform').elements;
	
	for (var i = 0; i < editFormElements.length; i++)
	{
		if (editFormElements[i].type == 'checkbox')
		{
			if (editFormElements[i].checked == true)
			{
				data += "&" + editFormElements[i].name + "=" + encodeURIComponent(editFormElements[i].value);
			}
		}
		else
		{
			data += "&" + editFormElements[i].name + "=" + encodeURIComponent(editFormElements[i].value);
		}
	}
	
	//alert(data);
	
	// Mark Huot's Edit Remember extension adds the possibility that there will be no second form,
	// so we will have to create it in the DOM *and* remove the no results message.  Whee!
	
	if ( ! document.getElementById('target'))
	{
		var newObj = document.createElement('form');
		newObj.setAttribute("name", "target");
		newObj.setAttribute("id", "target");
		newObj.setAttribute("method", "post");
		newObj.setAttribute('action', "{$editform_url}");
		
		document.getElementById('filterform').parentNode.appendChild(newObj);
		
		var pageDivs = document.getElementsByTagName('div');
		
		for(var i=0; i < pageDivs.length; i++)
		{
			if (pageDivs[i].className == 'highlight')
			{
				pageDivs[i].parentNode.removeChild(pageDivs[i]);
				break;
			}
		}
	}
	
	document.getElementById('target').innerHTML = '{$this->searching_html}';

	if (window.XMLHttpRequest)
	{
		XMLHttp = new XMLHttpRequest();
		XMLHttp.onreadystatechange = processAjaxResult
		XMLHttp.open("POST", serverPage, true);
		XMLHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
		XMLHttp.send(data);
		// branch for IE/Windows ActiveX version
	} 
	else if (window.ActiveXObject)
	{
		try
		{
			XMLHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		catch(g){ var unSupported = 'y'; }
		
		if (XMLHttp)
		{
			XMLHttp.onreadystatechange = processResult
			XMLHttp.open("POST", serverPage, true);
			XMLHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded;');
			XMLHttp.send(data);
		}
	}
}

function processAjaxResult()
{
	if (XMLHttp.readyState == 4 && XMLHttp.status == 200)
	{
		var newEditPage = XMLHttp.responseText;
		
		if (document.getElementById('target'))
		{
			document.getElementById('target').innerHTML = newEditPage;
		}
	}
}

// Add an onchange to all select fields
var formSelects = document.getElementById('filterform').getElementsByTagName('select');

for(var i = 0; i < formSelects.length; i++)
{
	if (formSelects[i].name == 'weblog_id')
	{
		formSelects[i].setAttribute('onchange', 'changemenu(this.selectedIndex);ajax_edit_tab();');
	}
	else
	{
		formSelects[i].setAttribute('onchange', 'ajax_edit_tab();');
	}
}

// Add an onchange to all checkbox fields
var formInputs = document.getElementById('filterform').getElementsByTagName('input');

for(var i = 0; i < formInputs.length; i++)
{
	if (formInputs[i].type == 'checkbox')
	{
		formInputs[i].setAttribute('onchange', 'ajax_edit_tab();');
	}
}

document.getElementById('filterform').setAttribute('onsubmit', 'ajax_edit_tab(); return false;');

</script>
EOT;
	
		return $form_data.$js;

	}
	/* END */
	
	
	
	/** ---------------------------------
	/**  Accept Form Data and Return Form
	/** ---------------------------------*/
	
	function process_search()
	{
		global $DB, $LANG, $DSP, $PREFS;
		
		if (isset($_POST['edit_ajax']))
		{
			/** ---------------------------------
			/*   Unset the POST variable to make sure that calling view_entries() again does
			/*   does not create a loop when there are other extensions running.
			/*  ---------------------------------*/
			
			unset($_POST['edit_ajax']);
			
			if ( ! class_exists('Publish')) require PATH_CP.'cp.publish'.EXT;
		
			$PUB = new Publish();
			
			$query = $DB->query("SELECT LOWER(module_name) as name FROM exp_modules");
		
			foreach($query->result as $row)
			{
				$PUB->installed_modules[$row['name']] = $row['name'];
			}
			
			$edit_forms = $DSP->secure_hash($PUB->view_entries());

			if (strpos($edit_forms, "<form ") !== FALSE)
			{
				@header("HTTP/1.0 200 OK");
            	@header("HTTP/1.1 200 OK");
            	@header("Content-type: text/html; charset=".$PREFS->ini('charset'));
				
				// a preg_match_all used to be used here, but with PHP 5.2+ there's a 100k limit on matches
				// artificially enforced, not enough for a large edit page's markup.
				
				// get rid of filtering form
				$edit_forms = substr($edit_forms, strpos($edit_forms, '</form>') + 7);
				
				// cut the string to start from the next form, the main edit table
				$edit_forms = substr($edit_forms, strpos($edit_forms, '<form '));
				
				// get rid of the opening form tag
				$edit_forms = preg_replace("|<form[^>]+>|i", '', $edit_forms);
				
				// get everything up until the closing form tag
				$edit_forms = substr($edit_forms, 0, strpos($edit_forms, '</form>'));
				
				// output!
				exit($edit_forms);
			}
			else
			{
				unset($edit_forms);
				@header("Content-type: text/html; charset=".$PREFS->ini('charset'));
				exit($DSP->qdiv('highlight', BR.$LANG->line('no_entries_matching_that_criteria')));
			}
		}  
	}
	/* END */
	
	
	/** ---------------------------------
	/**  Mr. Worf! Activate the Extension!
	/** ---------------------------------*/
	
	function activate_extension()
	{
		global $DB;
		
		$DB->query($DB->insert_string('exp_extensions',
				array(
				'extension_id'	=> '',
				'class'			=> "Edit_tab_ajax",
				'method'		=> "modify_form",
				'hook'			=> "edit_entries_search_form",
				'settings'		=> "",
				'priority'		=> 10,
				'version'		=> $this->version,
				'enabled'		=> "y"
				)
			)
		);
		
		$DB->query($DB->insert_string('exp_extensions',
				array(
				'extension_id'	=> '',
				'class'			=> "Edit_tab_ajax",
				'method'		=> "process_search",
				'hook'			=> "edit_entries_start",
				'settings'		=> "",
				'priority'		=> 10,
				'version'		=> $this->version,
				'enabled'		=> "y"
				)
			)
		);
	}
	/* END */
	
	
	/** ---------------------------------
	/**  Clear Out Old Enabling of Extension
	/** ---------------------------------*/
	
	function disable_extension()
	{
		global $DB;
		
		$DB->query("DELETE FROM exp_extensions WHERE class = 'Edit_tab_ajax'");
	}
	/* END */
	
}
?>