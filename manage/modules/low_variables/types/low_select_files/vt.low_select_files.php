<?php if ( ! defined('EXT')) exit('Invalid file request');

class Low_select_files extends Low_variables_type {

	var $info = array(
		'name'		=> 'Select Files',
		'version'	=> LOW_VAR_VERSION
	);

	var $default_settings = array(
		'multiple'	=> 'n',
		'folders'	=> array(1),
		'separator'	=> 'newline',
		'upload'	=> 0
	);

	var $language_files = array(
		'upload'
	);

	// --------------------------------------------------------------------

	/**
	* Display settings sub-form for this variable type
	*
	* @param	mixed	$var_id			The id of the variable: 'new' or numeric
	* @param	array	$var_settings	The settings of the variable
	* @return	array	
	*/
	function display_settings($var_id, $var_settings)
	{
		global $DSP, $LANG, $DB, $PREFS;

		/** -------------------------------------
		/**  Init return value
		/** -------------------------------------*/

		$r = array();

		/** -------------------------------------
		/**  Check current value from settings
		/** -------------------------------------*/

		$folders = $this->get_setting('folders', $var_settings);

		/** -------------------------------------
		/**  Get all folders
		/** -------------------------------------*/

		$query = $DB->query("SELECT id, name FROM exp_upload_prefs WHERE site_id = '".$DB->escape_str($PREFS->ini('site_id'))."' ORDER BY name ASC");

		// flatten result set in array
		$all_folders = $this->flatten_results($query->result, 'id', 'name');

		/** -------------------------------------
		/**  Build options setting
		/** -------------------------------------*/

		$r[] = array(
			$this->setting_label($LANG->line('file_folders')),
			form_multiselect($this->input_name('folders', TRUE), $all_folders, $folders)
		);

		/** -------------------------------------
		/**  Build setting: Allow uploads?
		/** -------------------------------------*/

		$upload_folders = array('0' => $LANG->line('no_uploads')) + $all_folders;
		$upload = $this->get_setting('upload', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('upload_folder'), $LANG->line('upload_folder_help')),
			form_dropdown($this->input_name('upload'), $upload_folders, $upload)
		);

		/** -------------------------------------
		/**  Build setting: multiple?
		/** -------------------------------------*/

		$multiple = $this->get_setting('multiple', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('allow_multiple_files')),
			'<label class="low-checkbox">'.str_replace("class='checkbox'", "class='low-allow-multiple'",$DSP->input_checkbox($this->input_name('multiple'), 'y', $multiple)).
			$LANG->line('allow_multiple_files_label').'</label>'
		);

		/** -------------------------------------
		/**  Build setting: separator
		/** -------------------------------------*/

		$separator = $this->get_setting('separator', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('separator_character')),
			$this->separator_select($separator)
		);

		/** -------------------------------------
		/**  Build setting: multi interface
		/** -------------------------------------*/

		$multi_interface = $this->get_setting('multi_interface', $var_settings);

		$r[] = array(
			$this->setting_label($LANG->line('multi_interface')),
			$this->interface_select($multi_interface)
		);

		/** -------------------------------------
		/**  Return output
		/** -------------------------------------*/

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	* Display input field for regular user
	*
	* @param	int		$var_id			The id of the variable
	* @param	string	$var_data		The value of the variable
	* @param	array	$var_settings	The settings of the variable
	* @return	string
	*/
	function display_input($var_id, $var_data, $var_settings)
	{
		global $DSP, $DB, $LANG;

		// get settings
		$multi = $this->get_setting('multiple', $var_settings);
		$multi_interface = $this->get_setting('multi_interface', $var_settings);

		/** -------------------------------------
		/**  Prep current data
		/** -------------------------------------*/

		$current = explode($this->separators[$this->get_setting('separator', $var_settings)], $var_data);

		/** -------------------------------------
		/**  Prep options
		/** -------------------------------------*/

		if ( ! ($folders = $this->get_setting('folders', $var_settings)) )
		{
			// no folder found error message
			return $DSP->qspan('alert', $LANG->line('no_folders_selected'));
		}

		// Get prefs from DB
		$query = $DB->query("SELECT * FROM exp_upload_prefs WHERE id IN (".implode(',', $DB->escape_str($folders)).")");

		/** -------------------------------------
		/**  Get file browser
		/** -------------------------------------*/

		if ( ! class_exists('File_browser'))
		{
			include_once PATH_CP.'cp.filebrowser'.EXT;
		}

		// create file list
		$FB = new File_browser;
		$FB->recursive = FALSE;

		$filelist = array();

		foreach ($query->result AS $dir)
		{
			$FB->filelist = array();
			$FB->set_upload_path($dir['server_path']);
			$FB->create_filelist();

			foreach ($FB->filelist AS $file)
			{
				if ($multi == 'y' && $multi_interface == 'drag-list')
				{
					$filelist[$dir['url'].$file['name']] = $file['name'];
				}
				else
				{
					$filelist[$dir['name']][$dir['url'].$file['name']] = $file['name'];
				}
			}
		}

		/** -------------------------------------
		/**  Create interface
		/** -------------------------------------*/

		if ($multi == 'y' && $multi_interface == 'drag-list')
		{
			// sort cats again
			asort($filelist);

			$r = $this->drag_lists($var_id, $filelist, $current);
		}
		else
		{
			$r = $this->select_element($var_id, $filelist, $current, ($multi == 'y'));
		}

		/** -------------------------------------
		/**  Add upload file thing?
		/** -------------------------------------*/

		if ($upload = $this->get_setting('upload', $var_settings))
		{
			$upload_class = ($multi == 'y' && $multi_interface == 'drag-list') ? ' after-drag' : '';
			$upload_new = $LANG->line('upload_new_file');
			$cancel = $LANG->line('cancel_upload');

			// Shows toggle-link and file upload field
			$r  .=<<<EOUPLOAD
				<a href="#upload" class="low-upload-toggle{$upload_class}"
					onclick="$('#var{$var_id}-file-upload').slideDown(200);return false;">{$upload_new}</a>
				<div style="clear:both"></div>
				<div id="var{$var_id}-file-upload" class="box low-upload-form{$upload_class}" style="display:none;">
					<input type="file" name="newfile[{$var_id}]" />
					<button type="button" onclick="$('#var{$var_id}_file_upload input').replaceWith($('<input type=file name=newfile[{$var_id}] />'));$('#var{$var_id}-file-upload').slideUp(200);">{$cancel}</button>
				</div>
EOUPLOAD;
		}

		/** -------------------------------------
		/**  Return select element
		/** -------------------------------------*/

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	* Prep variable data for saving
	*
	* @param	int		$var_id			The id of the variable
	* @param	mixed	$var_data		The value of the variable, array or string
	* @param	array	$var_settings	The settings of the variable
	* @return	string
	*/
	function save_input($var_id, $var_data, $var_settings)
	{
		global $DB, $SESS;

		// Get upload setting
		$upload = $this->get_setting('upload', $var_settings);

		/** -------------------------------------
		/**  Is there a valid upload for this var id?
		/** -------------------------------------*/

		if ($upload && isset($_FILES['newfile']['name'][$var_id]) && !empty($_FILES['newfile']['name'][$var_id]))
		{
			/** -------------------------------------
			/**  Fetch upload folder from cache or DB
			/** -------------------------------------*/

			if (isset($SESS->cache['low']['variables']['uploads'][$upload]))
			{
				$folder = $SESS->cache['low']['variables']['uploads'][$upload];
			}
			else
			{
				// Fetch record from DB
				$query = $DB->query("SELECT * FROM exp_upload_prefs WHERE id = '".$DB->escape_str($upload)."'");

				if ($query->num_rows)
				{
					// get folder and register to session cache
					$folder = $SESS->cache['low']['variables']['uploads'][$upload] = $query->row;
				}
				else
				{
					/** -------------------------------------
					/**  Bail out if folder wasn't found
					/** -------------------------------------*/

					$this->error_msg = 'folder_not_found';
					return FALSE;
				}
			}

			/** -------------------------------------
			/**  Include and initiate upload class
			/** -------------------------------------*/

			if ( ! class_exists('Upload') )
			{
				require_once PATH_CORE.'core.upload'.EXT;
			}

			if ( ! isset($this->UP) )
			{
				$this->UP = new Upload;
			}
			else
			{
				// reset upload params
				$this->UP->error_msg	= '';
				$this->UP->width		= 0;
				$this->UP->height		= 0;
				$this->UP->is_image		= 0;
				$this->UP->new_name		= '';
			}

			/** -------------------------------------
			/**  Set parameters according to folder prefs
			/** -------------------------------------*/

			$this->UP->set_max_filesize($folder['max_size']);
			$this->UP->set_allowed_types($folder['allowed_types']);
			$this->UP->set_max_width($folder['max_width']);
			$this->UP->set_max_height($folder['max_height']);

			// Set upload path
			$this->UP->upload_path = $folder['server_path'];

			/** -------------------------------------
			/**  Reset and fill $_FILES['userfile']
			/** -------------------------------------*/

			$_FILES['userfile'] = array();

			// Get uploaded files details from $_FILES
			foreach ($_FILES['newfile'] AS $key => $val)
			{
				if (isset($val[$var_id]))
				{
					$_FILES['userfile'][$key] = $val[$var_id];
				}
			}

			/** -------------------------------------
			/**  Upload the file
			/** -------------------------------------*/

			if ( ! $this->UP->upload_file() )
			{
				// Set error msg and bail if unsuccessful
				$this->error_msg = $this->UP->error_msg;
				return FALSE;
			}

			/** -------------------------------------
			/**  Append number if exists
			/**  @todo: make this configurable?
			/** -------------------------------------*/

			if ($this->UP->file_exists)
			{
				$old_name = $this->UP->file_name;	// place original filename in var
				$ext = strrchr($old_name, '.');		// get extension from filename

				$i = 1;
				$existing_file = TRUE;

				while ($existing_file == TRUE)
				{
					// construct new name
					$new_name = str_replace($ext,'-'.$i.$ext,$old_name);

					if (file_exists($this->UP->upload_path.$new_name))
					{
						// if that file exists too, crank up the number and try again
						$i++;
					}
					else
					{
						// or else copy the new filename to its destination and break out of the loop
						$this->UP->file_overwrite($old_name, $new_name);
						$this->UP->file_name = $new_name;
						$existing_file = FALSE;
					}
				}

				// $this->UP->file_overwrite($this->UP->file_name, $this->UP->file_name);
			}

			// get the new file's full path; the data we're going to save
			$newfile = $folder['url'].$this->UP->file_name;

			if (is_array($var_data))
			{
				// add it to the selected files
				$var_data[] = $newfile;
			}
			else
			{
				// or replace single value
				$var_data = $newfile;
			}

		} // END if upload?

		// Return new value
		return is_array($var_data) ? implode($this->separators[$this->get_setting('separator', $var_settings)], $var_data) : $var_data;

	}

}