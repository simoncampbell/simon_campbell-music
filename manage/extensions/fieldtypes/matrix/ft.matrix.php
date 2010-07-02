<?php if (! defined('EXT')) exit('Invalid file request');


/**
 * Matrix Fieldtype Class for EE1
 *
 * @package   Matrix
 * @author    Brandon Kelly <brandon@pixelandtonic.com>
 * @copyright Copyright (c) 2010 Pixel & Tonic, LLC
 */
class Matrix extends Fieldframe_Fieldtype {

	var $info = array(
		'name'     => 'Matrix',
		'version'  => '2.0.4',
		'desc'     => 'A customizable, expandable, and sortable table field',
		'docs_url' => 'http://pixelandtonic.com/ffmatrix/docs'
	);

	var $requires = array(
		'ff' => '1.4.1'
	);

	var $hooks = array(
		'delete_entries_loop'
	);

	var $default_site_settings = array(
		'license_key' => ''
	);

	var $default_field_settings = array(
		'max_rows' => '',
		'col_ids'  => ''
	);

	var $default_tag_params = array(
		'cellspacing'        => '1',
		'cellpadding'        => '10',
		'dynamic_parameters' => '',
		'row_id'             => '',
		'orderby'            => '',
		'sort'               => 'asc',
		'offset'             => '',
		'limit'              => '',
		'backspace'          => ''
	);

	var $postpone_saves = TRUE;

	/**
	 * Fieldtype Constructor
	 */
	function Matrix()
	{
		global $FFM;
		$FFM = $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Theme URL
	 */
	private function _theme_url()
	{
		if (! isset($this->_theme_url))
		{
			global $PREFS;
			$theme_folder_url = $PREFS->ini('theme_folder_url', 1);
			$this->_theme_url = $theme_folder_url.'matrix/';
		}

		return $this->_theme_url;
	}

	/**
	 * Include Theme CSS
	 */
	private function _include_theme_css($file)
	{
		$this->insert('head', '<link rel="stylesheet" type="text/css" href="'.$this->_theme_url().$file.'" />');
	}

	/**
	 * Include Theme JS
	 */
	private function _include_theme_js($file)
	{
		$this->insert('body', '<script type="text/javascript" src="'.$this->_theme_url().$file.'"></script>');
	}

	// --------------------------------------------------------------------

	/**
	 * Add column
	 */
	private function _add_col($data)
	{
		global $DB;

		// add the row to exp_matrix_cols
		$DB->query($DB->insert_string('exp_matrix_cols', $data));

		// get the col_id
		$query = $DB->query('SELECT MAX(col_id) as col_id FROM exp_matrix_cols');
		$col_id = $query->row['col_id'];

		// add the column to exp_matrix_data
		$DB->query('ALTER TABLE exp_matrix_data ADD col_id_'.$col_id.' TEXT');

		return $col_id;
	}

	// --------------------------------------------------------------------

	/**
	 * Update
	 */
	function update($from)
	{
		global $DB, $FF;

		if ($from === FALSE)
		{
			// -------------------------------------------
			//  Create the exp_matrix_cols table
			// -------------------------------------------

			if ( ! $DB->table_exists('exp_matrix_cols'))
			{
				$DB->query("CREATE TABLE exp_matrix_cols (
				              `col_id`           int(6) unsigned auto_increment,
				              `site_id`          int(4) unsigned default '1',
				              `field_id`         int(6) unsigned NULL,
				              `col_name`         varchar(32) NULL,
				              `col_label`        varchar(50) NULL,
				              `col_instructions` text NULL,
				              `col_type`         varchar(50) default 'text',
				              `col_required`     char(1) default 'n',
				              `col_search`       char(1) default 'n',
				              `col_order`        int(3) unsigned NULL,
				              `col_width`        varchar(4) NULL,
				              `col_settings`     text NULL,

				              PRIMARY KEY (`col_id`),
				              KEY (`site_id`),
				              KEY (`field_id`)
				            )");
			}

			// -------------------------------------------
			//  Create the exp_matrix_data table
			// -------------------------------------------

			if ( ! $DB->table_exists('exp_matrix_data'))
			{
				$DB->query("CREATE TABLE exp_matrix_data (
				              `row_id`           int(10) unsigned auto_increment,
				              `site_id`          int(4) unsigned default '1',
				              `entry_id`         int(10) unsigned NULL,
				              `field_id`         int(6) unsigned NULL,
				              `row_order`        int(4) unsigned NULL,

				              PRIMARY KEY (`row_id`),
				              KEY (`site_id`),
				              KEY (`entry_id`),
				              KEY (`row_order`)
				            )");
			}

			// -------------------------------------------
			//  FF Matrix Conversion
			// -------------------------------------------

			$ff_matrix = $DB->query('SELECT fieldtype_id, version FROM exp_ff_fieldtypes WHERE class = "ff_matrix"');

			if ($ff_matrix->num_rows)
			{
				// uninstall the old fieldtype
				$DB->query('DELETE FROM exp_ff_fieldtypes WHERE class = "ff_matrix"');

				// were there any FF Matrix fields?
				$fields = $DB->query('SELECT field_id, site_id, field_search, ff_settings FROM exp_weblog_fields WHERE field_type = "ftype_id_'.$ff_matrix->row['fieldtype_id'].'"');

				foreach ($fields->result as $field)
				{
					$settings = $FF->_unserialize($field['ff_settings']);

					$settings['col_ids'] = array();

					if (isset($settings['cols']))
					{
						if ($settings['cols'])
						{
							// -------------------------------------------
							//  Add the rows to exp_matrix_cols
							// -------------------------------------------

							$col_ids_by_key = array();

							foreach($settings['cols'] as $col_key => $col)
							{
								$col_type = $col['type'];
								$col_settings = $col['settings'];

								switch ($col_type)
								{
									//case 'ff_checkbox':
									//case 'ff_checkbox_group':
									//	if ($col_type == 'ff_checkbox')
									//	{
									//		$col_settings = array('options' => array('y' => $col_settings['label']));
									//	}
                                    //
									//	$col_type = 'pt_checkboxes';
									//	break;

									//case 'ff_select':
									//	$col_type = 'pt_dropdown';
									//	break;

									//case 'ff_multiselect':
									//	$col_type = 'pt_multiselect';
									//	break;

									//case 'ff_radio_group':
									//	$col_type = 'pt_radio_buttons';
									//	break;

									case 'ff_matrix_select':
										$col_type = 'ff_select';
										break;

									case 'ff_matrix_text':
									case 'ff_matrix_textarea':
										$col_settings['multiline'] = ($col_type == 'ff_matrix_text' ? 'n' : 'y');
										$col_type = 'text';
										break;

									case 'ff_matrix_date':
										$col_type = 'date';
										break;
								}

								$col_id = $this->_add_col(array(
									'site_id'      => $field['site_id'],
									'field_id'     => $field['field_id'],
									'col_name'     => $col['name'],
									'col_label'    => $col['label'],
									'col_type'     => $col_type,
									'col_search'   => $field['field_search'],
									'col_order'    => $col_key,
									'col_settings' => base64_encode(serialize($col_settings))
								));

								$settings['col_ids'][] = $col_id;

								// map the col_id to the col_key for later
								$col_ids_by_key[$col_key] = $col_id;
							}

							// -------------------------------------------
							//  Move the field data into exp_matrix_data
							// -------------------------------------------

							$field_id = 'field_id_'.$field['field_id'];

							$entries = $DB->query('SELECT entry_id, '.$field_id.' FROM exp_weblog_data WHERE '.$field_id.' != ""');

							foreach($entries->result as $entry)
							{
								// unserialize the data
								$old_data = $FF->_unserialize($entry[$field_id]);

								foreach ($old_data as $row_count => $row)
								{
									$data = array(
										'site_id'   => $field['site_id'],
										'entry_id'  => $entry['entry_id'],
										'field_id'  => $field['field_id'],
										'row_order' => $row_count+1
									);

									foreach ($row as $col_key => $cell_data)
									{
										// does this col exist?
										if (! isset($col_ids_by_key[$col_key])) continue;

										// get the col_id
										$col_id = $col_ids_by_key[$col_key];

										// serialize the cell data if necessary
										if (is_array($cell_data))
										{
											$cell_data = $FF->_serialize($cell_data);
										}

										// queue it up
										$data['col_id_'.$col_id] = $cell_data;
									}

									// add the row to exp_matrix_data
									$DB->query($DB->insert_string('exp_matrix_data', $data));
								}

								// clear out the old field data from exp_weblog_data
								$new_data = $this->_flatten_data($old_data);
								$DB->query($DB->update_string('exp_weblog_data', array($field_id => $new_data), 'entry_id = '.$entry['entry_id']));
							}
						}

						// remove 'cols' from field settings
						unset($settings['cols']);
					}

					// -------------------------------------------
					//  Update the field
					// -------------------------------------------

					$settings = $FF->_serialize($settings);

					// save them back to the DB
					$DB->query($DB->update_string('exp_weblog_fields', array(
						'field_type' => 'ftype_id_'.$this->_fieldtype_id,
						'ff_settings' => $settings
					), 'field_id = '.$field['field_id']));
				}
			}
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Display Site Settings
	 */
	function display_site_settings()
	{
		global $DB, $DSP;

		$SD = new Fieldframe_SettingsDisplay();

		$r = $SD->block()
		   . $SD->row(array(
		                $SD->label('license_key'),
		                $SD->text('license_key', $this->site_settings['license_key'])
			          ));

		$fields_q = $DB->query('SELECT f.field_id, f.field_label, g.group_name
		                          FROM exp_weblog_fields AS f, exp_field_groups AS g
		                          WHERE f.field_type = "data_matrix"
		                            AND f.group_id = g.group_id
		                          ORDER BY g.group_name, f.field_order, f.field_label');
		if ($fields_q->num_rows)
		{
			$convert_r = '';
			$last_group_name = '';
			foreach($fields_q->result as $row)
			{
				if ($row['group_name'] != $last_group_name)
				{
					$convert_r .= $DSP->qdiv('defaultBold', $row['group_name']);
					$last_group_name = $row['group_name'];
				}
				$convert_r .= '<label>'
				            . $DSP->input_checkbox('convert[]', $row['field_id'])
				            . $row['field_label']
				            . '</label>'
				            . '<br>';
			}
			$r .= $SD->row(array(
				$SD->label('convert_label', 'convert_desc'),
				$convert_r
			));
		}

		$r .= $SD->block_c();
		return $r;
	}

	// --------------------------------------------------------------------

	/**
	 * Save Site Settings
	 */
	function save_site_settings($site_settings)
	{
		global $DB, $FF, $LANG, $REGX;

		if (isset($site_settings['convert']))
		{
			$setting_name_maps = array(
				'short_name' => 'col_name',
				'title'      => 'col_label'
			);
			$cell_type_maps = array(
				'text'     => 'ff_matrix_text',
				'textarea' => 'ff_matrix_textarea',
				'select'   => 'ff_matrix_select',
				'date'     => 'ff_matrix_date',
				'checkbox' => 'ff_checkbox'
			);

			$fields = $DB->query('SELECT field_id, site_id, field_search, lg_field_conf FROM exp_weblog_fields WHERE field_id IN ('.implode(',', $site_settings['convert']).')');

			$sql = array();

			foreach($fields->result as $field)
			{
				$field_data = array(
					'field_type' => 'ftype_id_'.$this->_fieldtype_id
				);

				// get the conf string
				if (($old_conf = @unserialize($field['lg_field_conf'])) !== FALSE)
				{
					$conf = (is_array($old_conf) && isset($old_conf['string'])) ? $old_conf['string'] : '';
				}
				else
				{
					$conf = $field['lg_field_conf'];
				}

				// parse the conf string

				$field_settings = array(
					'col_ids' => array()
				);

				$col_ids_by_name = array();

				foreach(preg_split('/[\r\n]{2,}/', trim($conf)) as $col_key => $col)
				{
					// default col settings
					$col_settings = array(
						'col_name'  => strtolower($LANG->line('cell')).'_'.($col_key+1),
						'col_label' => $LANG->line('cell').' '.($col_key+1),
						'col_type'  => 'text'
					);

					$old = array();

					foreach (preg_split('/[\r\n]/', $col) as $line)
					{
						$parts = explode('=', $line);
						$old[$parts[0]] = $parts[1];
					}

					if (! $old['short_name']) continue;

					$col_type = 'text';
					$col_settings = array();

					if (isset($old['options']))
					{
						$options = explode('|', $old['options']);
						$col_settings['options'] = array();
						foreach ($options as $option)
						{
							$col_settings['options'][$option] = $option;
						}
					}

					if (isset($old['type']))
					{
						switch ($old['type'])
						{
							case 'text':
								$col_settings = array('multiline' => 'n');
								break;

							case 'textarea':
								$col_settings = array('multiline' => 'y');
								break;

							case 'select':
								$col_type = 'ff_select';
								break;

							case 'date':
								$col_type = 'date';
								break;

							case 'checkbox':
								$col_type = 'checkbox';
								break;
						}
					}

					$col_id = $this->_add_col(array(
						'site_id'      => $field['site_id'],
						'field_id'     => $field['field_id'],
						'col_name'     => $old['short_name'],
						'col_label'    => (isset($old['title']) ? $old['title'] : $LANG->line('cell').' '.($col_key+1)),
						'col_type'     => $col_type,
						'col_search'   => $field['field_search'],
						'col_order'    => $col_key,
						'col_settings' => $FF->_serialize($col_settings)
					));

					$field_settings['col_ids'][] = $col_id;

					// map the col_id to the short_name for later
					$col_ids_by_name[$old['short_name']] = $col_id;
				}

				// -------------------------------------------
				//  Move the field data into exp_matrix_data
				// -------------------------------------------

				$field_id = 'field_id_'.$field['field_id'];

				$entries = $DB->query('SELECT entry_id, '.$field_id.' FROM exp_weblog_data WHERE '.$field_id.' != ""');

				foreach($entries->result as $entry)
				{
					// unserialize the data
					$old_data = @unserialize($entry[$field_id]);

					if ($old_data !== FALSE)
					{
						foreach($REGX->array_stripslashes($old_data) as $row_count => $row)
						{
							$data = array(
								'site_id'   => $field['site_id'],
								'entry_id'  => $entry['entry_id'],
								'field_id'  => $field['field_id'],
								'row_order' => $row_count+1
							);

							$include_row = FALSE;

							foreach($row as $name => $cell_data)
							{
								// does this col exist?
								if (! isset($col_ids_by_name[$name])) continue;

								// get the col_id
								$col_id = $col_ids_by_name[$name];

								// serialize the cell data if necessary
								if (is_array($cell_data))
								{
									$cell_data = $FF->_serialize($cell_data);
								}

								// queue it up
								$data['col_id_'.$col_id] = $cell_data;

								if ($cell_data) $include_row = TRUE;
							}

							if ($include_row)
							{
								// add the row to exp_matrix_data
								$DB->query($DB->insert_string('exp_matrix_data', $data));
							}


							if ($include_row) $entry_rows[] = $entry_row;
						}

						// clear out the old field data from exp_weblog_data
						$new_data = $this->_flatten_data($old_data);
						$DB->query($DB->update_string('exp_weblog_data', array($field_id => $new_data), 'entry_id = '.$entry['entry_id']));
					}
				}

				// -------------------------------------------
				//  Update the field
				// -------------------------------------------

				$field_settings = $FF->_serialize($field_settings);

				// save them back to the DB
				$DB->query($DB->update_string('exp_weblog_fields', array(
					'field_type' => 'ftype_id_'.$this->_fieldtype_id,
					'ff_settings' => $settings
				), 'field_id = '.$field['field_id']));
			}

			unset($site_settings['convert']);
		}

		return $site_settings;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Field Cols
	 */
	private function _get_field_cols($col_ids)
	{
		global $PREFS, $DB;

		if (! $col_ids) return FALSE;

		$query = $DB->query('SELECT col_id, col_type, col_label, col_name, col_instructions, col_width, col_required, col_search, col_settings
		                     FROM exp_matrix_cols
		                     WHERE col_id IN ('.implode(',', $col_ids).')
		                     ORDER BY col_order');

		$cols = $query->result;

		// unserialize the settings
		foreach ($cols as &$col)
		{
			$col['col_settings'] = unserialize(base64_decode($col['col_settings']));
		}

		return $cols;
	}

	// --------------------------------------------------------------------

	/**
	 * Get Fieldtypes
	 *
	 * @access private
	 */
	function _get_celltypes()
	{
		global $FF;

		if ( ! isset($this->ftypes))
		{
			// Add the included celltypes
			require_once 'celltypes/text.php';
			require_once 'celltypes/date.php';

			$this->ftypes = array(
				'text' => new Matrix_text(),
				'date' => new Matrix_date()
			);

			// Get the FF fieldtyes with display_cell
			$ftypes = array();
			if ( ! isset($FF->ftypes)) $FF->_get_ftypes();
			foreach($FF->ftypes as $class_name => $ftype)
			{
				if (method_exists($ftype, 'display_cell'))
				{
					$ftypes[$class_name] = $ftype;
				}
			}
			$FF->_sort_ftypes($ftypes);

			// Combine with the included celltypes
			$this->ftypes = array_merge($this->ftypes, $ftypes);
		}

		return $this->ftypes;
	}

	// --------------------------------------------------------------------

	/**
	 * Namespace Settings
	 */
	function _namespace_settings(&$settings, $namespace)
	{
		$settings = preg_replace('/(name=([\'\"]))([^\'"\[\]]+)([^\'"]*)(\2)/i', '$1'.$namespace.'[$3]$4$5', $settings);
	}

	// --------------------------------------------------------------------

	/**
	 * Celltype Settings HTML
	 */
	private function _celltype_settings_html($name, $namespace, $celltype, $cell_settings = array())
	{
		global $LANG;

		if (method_exists($celltype, 'display_cell_settings'))
		{
			if ( ! $celltype->info['no_lang']) $LANG->fetch_language_file($name);

			$cell_settings = array_merge((isset($celltype->default_cell_settings) ? $celltype->default_cell_settings : array()), $cell_settings);

			$returned = $celltype->display_cell_settings($cell_settings);

			// should we create the html for them?
			if (is_array($returned))
			{
				$r = '<table class="matrix-col-settings" cellspacing="0" cellpadding="0" border="0">';

				$total_cell_settings = count($returned);

				foreach($returned as $cs_key => $cell_setting)
				{
					$tr_class = '';
					if ($cs_key == 0) $tr_class .= ' matrix-first';
					if ($cs_key == $total_cell_settings-1) $tr_class .= ' matrix-last';

					$r .= '<tr class="'.$tr_class.'">'
					    .   '<th class="matrix-first">'.$cell_setting[0].'</th>'
					    .   '<td class="matrix-last">'.$cell_setting[1].'</td>'
					    . '</tr>';
				}

				$r .= '</table>';
			}
			else
			{
				$r = $returned;
			}

			$this->_namespace_settings($r, $namespace);
		}
		else
		{
			$r = '';
		}

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	 * Display Field Settings
	 */
	function display_field_settings($field_settings)
	{
		global $FF, $DSP, $LANG;

		// include css and js
		$this->_include_theme_css('styles/matrix.css');
		$this->_include_theme_js('scripts/matrix.js');
		$this->_include_theme_js('scripts/matrix_text.js');
		$this->_include_theme_js('scripts/matrix_conf.js');

		// -------------------------------------------
		//  Get the celltypes
		// -------------------------------------------

		$celltypes = $this->_get_celltypes();
		$celltypes_select_options = array();
		$celltypes_js = array();

		foreach ($celltypes as $name => $celltype)
		{
			$celltypes_select_options[$name] = $celltype->info['name'];

			// default cell settings
			$celltypes_js[$name] = $this->_celltype_settings_html($name, 'ftype[ftype_id_'.$this->_fieldtype_id.'][cols][{COL_ID}][settings]', $celltype, array());
		}

		// -------------------------------------------
		//  Get the columns
		// -------------------------------------------

		// is this an existing field?
		if ($FF->data['field_id'] && $field_settings['col_ids'])
		{
			$cols = $this->_get_field_cols($field_settings['col_ids']);

			$new = FALSE;
		}

		if (! isset($cols) || ! $cols)
		{
			$new = TRUE;

			// start off with a couple text cells
			$cols = array(
				array('col_id' => '0', 'col_label' => 'Cell 1', 'col_instructions' => '', 'col_name' => 'cell_1', 'col_type' => 'text', 'col_width' => '33%', 'col_required' => 'n', 'col_search' => 'n', 'col_settings' => array('maxl' => '',    'multiline' => 'n')),
				array('col_id' => '1', 'col_label' => 'Cell 2', 'col_instructions' => '', 'col_name' => 'cell_2', 'col_type' => 'text', 'col_width' => '',    'col_required' => 'n', 'col_search' => 'n', 'col_settings' => array('maxl' => '140', 'multiline' => 'y'))
			);
		}

		$cols_js = array();

		foreach ($cols as $col)
		{
			$cols_js[] = array(
				'id' => ($new ? 'col_new_' : 'col_id_') . $col['col_id'],
				'type' => $col['col_type']
			);
		}

		$SD = new Fieldframe_SettingsDisplay();

		// -------------------------------------------
		//  Max Rows
		// -------------------------------------------

			$r[] = array(
				$SD->label('max_rows'),
				$SD->text('max_rows', $field_settings['max_rows'], array('width' => '3em'))
			);

		// -------------------------------------------
		//  Matrix Configuration
		// -------------------------------------------

			$total_cols = count($cols);

			$table = '<div id="matrix-conf-container" style="margin-left: -6px;"><div id="matrix-conf">'
			       .   '<table class="matrix matrix-conf" cellspacing="0" cellpadding="0" border="0" style="background: #ecf1f4;">'
			       .     '<thead class="matrix">'
			       .       '<tr class="matrix matrix-first">'
			       .         '<td class="matrix-breakleft"></td>';

			// -------------------------------------------
			//  Labels
			// -------------------------------------------

			foreach ($cols as $col_index => $col)
			{
				$col_id = $new ? 'col_new_'.$col_index : 'col_id_'.$col['col_id'];

				$class = 'matrix';
				if ($col_index == 0) $class .= ' matrix-first';
				if ($col_index == $total_cols - 1) $class .= ' matrix-last';

				$table .= '<th class="'.$class.'" scope="col">'
				        .   '<input type="hidden" name="col_order[]" value="'.$col_id.'" />'
				        .   '<span>'.$col['col_label'].'</span>'
				        . '</th>';
			}

			$table .= '</tr>'
			        . '<tr class="matrix matrix-last">'
			        .   '<td class="matrix-breakleft"></td>';

			// -------------------------------------------
			//  Instructions
			// -------------------------------------------

			foreach ($cols as $col_index => $col)
			{
				$class = 'matrix';
				if ($col_index == 0) $class .= ' matrix-first';
				if ($col_index == $total_cols - 1) $class .= ' matrix-last';

				$table .= '<td class="'.$class.'">'.($col['col_instructions'] ? nl2br($col['col_instructions']) : '&nbsp;').'</td>';
			}

			$table .=   '</tr>'
			        . '</thead>'
			        . '<tbody class="matrix">';

			// -------------------------------------------
			//  Col Settings
			// -------------------------------------------

			$col_settings = array('type', 'label', 'name', 'instructions', 'width', 'search', 'settings');
			$total_settings = count($col_settings);

			foreach ($col_settings as $row_index => $col_setting)
			{
				$tr_class = 'matrix';
				if ($row_index == 0) $tr_class .= ' matrix-first';
				if ($row_index == $total_settings - 1) $tr_class .= ' matrix-last';

				$table .= '<tr class="'.$tr_class.'">'
				        .   '<th class="matrix-breakleft" scope="row">'.$LANG->line('col_'.$col_setting).'</th>';

				foreach ($cols as $col_index => $col)
				{
					$col_id = $new ? 'col_new_'.$col_index : 'col_id_'.$col['col_id'];
					$setting_name = 'cols['.$col_id.']['.$col_setting.']';

					$td_class = 'matrix';
					if ($col_index == 0) $td_class .= ' matrix-first';
					if ($col_index == $total_cols - 1) $td_class .= ' matrix-last';

					switch ($col_setting)
					{
						case 'type':
							$shtml = $SD->select($setting_name, $col['col_'.$col_setting], $celltypes_select_options);
							break;

						case 'name':
						case 'width':
							$td_class .= ' matrix-text';
							$shtml = '<input type="text" class="matrix-textarea" name="'.$setting_name.'" value="'.$col['col_'.$col_setting].'" />';
							break;

						case 'required':
						case 'search':
							$shtml = '<input type="checkbox" name="'.$setting_name.'" value="y"'.($col['col_'.$col_setting] == 'y' ? ' checked="checked"' : '').' />';
							break;

						case 'settings':
							$cell_data = is_array($col['col_'.$col_setting]) ? $col['col_'.$col_setting] : array();
							if (! ($shtml = $this->_celltype_settings_html($col['col_type'], $setting_name, $celltypes[$col['col_type']], $cell_data)))
							{
								$td_class .= ' matrix-disabled';
								$shtml = '&nbsp;';
							}
							break;

						default:
							$td_class .= ' matrix-text';
							$shtml = '<textarea class="matrix-textarea" name="'.$setting_name.'" rows="1">'.$col['col_'.$col_setting].'</textarea>';
					}

					$table .= '<td class="'.$td_class.'">'.$shtml.'</td>';
				}

				$table .= '</tr>';
			}

			// -------------------------------------------
			//  Delete Row buttons
			// -------------------------------------------

			$table .=     '<tr>'
			        .       '<td class="matrix-breakleft"></td>';

			foreach ($cols as $col)
			{
				$table .=   '<td class="matrix-breakdown"><a class="matrix-btn" title="'.$LANG->line('remove_column').'"></a></td>';
			}

			$table .=       '</tr>'
			        .     '</tbody>'
			        .   '</table>'
			        .   '<a class="matrix-btn matrix-add" title="'.$LANG->line('add_column').'"></a>'
			        . '</div></div>';

			$r[] = array(
				$SD->label('matrix_configuration')
				. $table
			);

		// -------------------------------------------
		//  Initialize the configurator js
		// -------------------------------------------

		$namespace = 'ftype[ftype_id_'.$this->_fieldtype_id.']';

		// add json lib if < PHP 5.2
		include_once 'includes/jsonwrapper/jsonwrapper.php';

		$js = 'MatrixConf.EE1 = true;' . NL
		    . 'var m = new MatrixConf("'.$namespace.'", '.json_encode($celltypes_js).', '.json_encode($cols_js).', '.json_encode($col_settings).');';

		if ($new) $js .= NL.'m.totalNewCols = 2;';

		$this->insert_js($js);

		return array('rows' => $r);
	}

	// --------------------------------------------------------------------

	/**
	 * Save Field Settings
	 */
	function save_field_settings($post)
	{
		global $DB, $PREFS;

		$celltypes = $this->_get_celltypes();

		// -------------------------------------------
		//  Delete any removed columns
		// -------------------------------------------

		if (isset($post['deleted_cols']))
		{
			foreach($post['deleted_cols'] as $col_id)
			{
				$col_id = substr($col_id, 7);

				// delete the rows from exp_matrix_cols
				$DB->query('DELETE FROM exp_matrix_cols WHERE col_id = '.$col_id);

				// delete the actual column from exp_matrix_data
				$DB->query('ALTER TABLE exp_matrix_data DROP COLUMN `col_id_'.$col_id.'`');
			}
		}

		// -------------------------------------------
		//  Add/update columns
		// -------------------------------------------

		$settings = array(
			'max_rows' => (isset($post['max_rows']) && $post['max_rows'] ? $post['max_rows'] : ''),
			'col_ids' => array()
		);

		$matrix_data_columns = array();

		foreach ($post['col_order'] as $col_order => $col_id)
		{
			$col = $post['cols'][$col_id];

			$cell_settings = isset($col['settings']) ? $col['settings'] : array();

			// give the celltype a chance to override
			$celltype = $celltypes[$col['type']];
			if (method_exists($celltype, 'save_cell_settings'))
			{
				$cell_settings = $celltype->save_cell_settings($cell_settings);
			}

			$col_data = array(
				'col_name'         => $col['name'],
				'col_label'        => $col['label'],
				'col_instructions' => $col['instructions'],
				'col_type'         => $col['type'],
				'col_required'     => (isset($col['required']) && $col['required'] ? 'y' : 'n'),
				'col_search'       => (isset($col['search']) && $col['search'] ? 'y' : 'n'),
				'col_width'        => $col['width'],
				'col_order'        => $col_order,
				'col_settings'     => base64_encode(serialize($cell_settings))
			);

			$new = (substr($col_id, 0, 8) == 'col_new_');

			if ($new)
			{
				$col_data['site_id'] = $PREFS->ini('site_id');

				// insert the column
				$col_id = $this->_add_col($col_data);
			}
			else
			{
				$col_id = substr($col_id, 7);

				// just update the existing row
				$DB->query($DB->update_string('exp_matrix_cols', $col_data, 'col_id = '.$col_id));
			}

			// add the col_id to the field settings
			//  - it's unfortunate that we can't just place the field_id in the matrix_cols
			//    data, but alas, the future field_id is unknowable on new fields
			$settings['col_ids'][] = $col_id;
		}

		return $settings;
	}

	// --------------------------------------------------------------------

	/**
	 * Display Field
	 */
	function display_field($field_name, $field_data, $field_settings)
	{
		global $DB, $PREFS, $FF, $IN, $LANG;

		$celltypes = $this->_get_celltypes();

		$max_rows = isset($field_settings['max_rows']) ? $field_settings['max_rows'] : FALSE;
		$col_ids = isset($field_settings['col_ids']) ? $field_settings['col_ids'] : FALSE;

		if (! $col_ids) return;

		// -------------------------------------------
		//  Include dependencies
		//   - this needs to happen *before* we load the celltypes,
		//     in case the celltypes are loading their own JS
		// -------------------------------------------

		if (! isset($this->included_dependencies))
		{
			// load the language file
			$LANG->fetch_language_file('matrix');

			// include css and js
			$this->_include_theme_css('styles/matrix.css');
			$this->_include_theme_js('scripts/matrix.js');

			// menu language
			$this->insert_js('Matrix.lang = { '
				. 'add_row_above: "'.$LANG->line('add_row_above').'", '
				. 'add_row_below: "'.$LANG->line('add_row_below').'", '
				. 'remove_row: "'.$LANG->line('remove_row').'" };');

			$this->included_dependencies = TRUE;
		}

		// -------------------------------------------
		//  Get the columns
		// -------------------------------------------

		$cols = $this->_get_field_cols($col_ids);

		$total_cols = count($cols);

		if (! $total_cols) return;

		$col_settings = array();

		$select_col_ids = '';
		$show_instructions = FALSE;

		$cols_js = array();

		foreach($cols as $col)
		{
			// index the col by ID
			$select_col_ids .= ', col_id_'.$col['col_id'];

			// show instructions?
			if ($col['col_instructions']) $show_instructions = TRUE;

			$celltype = $celltypes[$col['col_type']];

			// include this->settings in col settings
			$col_settings[$col['col_id']] = array_merge(
				(isset($celltype->default_cell_settings) ? $celltype->default_cell_settings : array()),
				(is_array($col['col_settings']) ? $col['col_settings'] : array())
			);
		
			$new_cell_html = $celltype->display_cell('{DEFAULT}', '', $col_settings[$col['col_id']]);

			$new_cell_settings = FALSE;
			$new_cell_class = FALSE;

			if (is_array($new_cell_html))
			{
				if (isset($new_cell_html['settings']))
				{
					$new_cell_settings = $new_cell_html['settings'];
				}

				if (isset($new_cell_html['class']))
				{
					$new_cell_class = $new_cell_html['class'];
				}

				$new_cell_html = $new_cell_html['data'];
			}

			// store the js-relevant stuff in $cols_js
			$col_js = array(
				'id' => 'col_id_'.$col['col_id'],
				'name' => $col['col_name'],
				'required' => ($col['col_required'] == 'y' ? TRUE : FALSE),
				'settings' => $col['col_settings'],
				'type' => $col['col_type'],
				'newCellHtml' => $new_cell_html,
				'newCellSettings' => $new_cell_settings,
				'newCellClass' => $new_cell_class
			);

			$cols_js[] = $col_js;
		}

		// -------------------------------------------
		//  Get the data
		// -------------------------------------------

		// is this an existing entry?
		$entry_id = isset($FF->row['entry_id']) ? $FF->row['entry_id'] : $IN->GBL('entry_id');
		$field_id = isset($FF->field_id) ? $FF->field_id : $FF->row['field_id'];

		if ($entry_id)
		{
			$site_id = $PREFS->ini('site_id');

			$query = $DB->query('SELECT row_id'.$select_col_ids.' FROM exp_matrix_data
			                     WHERE site_id = '.$site_id.' AND field_id = '.$field_id.' AND entry_id = '.$entry_id.'
			                     ORDER BY row_order');

			$data = $query->result;
		}

		// default to one blank row
		if (! $entry_id || ! $data)
		{
			$data = array();

			foreach($cols as $col)
			{
				$data[0]['col_id_'.$col['col_id']] = '';
			}

			$new = TRUE;
		}
		else
		{
			$new = FALSE;
		}

		$total_rows = count($data);

		// -------------------------------------------
		//  Table Head
		// -------------------------------------------

		$thead = '<thead class="matrix">';

		$headings = '';
		$instructions = '';

		// add left gutters if there can be more than one row
		if ($max_rows != '1')
		{
			$headings .= '<th class="matrix matrix-first"></th>';

			if ($show_instructions)
			{
				$instructions .= '<td class="matrix matrix-first"></td>';
			}
		}

		// add the labels and instructions
		foreach ($cols as $col_index => $col)
		{
			$count = $col_index + 1;

			$class = 'matrix';
			if ($max_rows == '1' && $count == 1) $class .= ' matrix-first';
			if ($count == $total_cols) $class .= ' matrix-last';

			$width = $col['col_width'] ? ' width="'.$col['col_width'].'"' : '';

			$headings .= '<th class="'.$class.'" scope="col"'.$width.'>'.$col['col_label'].'</th>';

			if ($show_instructions)
			{
				$instructions .= '<td class="'.$class.'">'.nl2br($col['col_instructions']).'</td>';
			}
		}

		$thead = '<thead class="matrix">'
		       .   '<tr class="matrix matrix-first'.($show_instructions ? '' : ' matrix-last').'">' . $headings . '</tr>'
		       .   ($show_instructions ? '<tr class="matrix matrix-last">' . $instructions . '</tr>' : '')
		       . '</thead>';

		// -------------------------------------------
		//  Table Body
		// -------------------------------------------

		$rows_js = array();

		$tbody = '<tbody class="matrix">';

		foreach ($data as $row_index => $row)
		{
			$row_id = $new ? 'row_new_'.$row_index : 'row_id_'.$row['row_id'];
			$row_js = array('id' => $row_id, 'cellSettings' => array());

			$row_count = $row_index + 1;

			$tr_class = 'matrix';
			if ($row_count == 1) $tr_class .= ' matrix-first';
			if ($row_count == $total_rows) $tr_class .= ' matrix-last';

			$tbody .= '<tr class="'.$tr_class.'">';

			// add left heading if there can be more than one row
			if ($max_rows != '1')
			{
				$tbody .= '<th class="matrix matrix-first">'
				        .   '<div><span>'.$row_count.'</span><a title="'.$LANG->line('options').'"></a></div>'
				        .   '<input type="hidden" name="'.$field_name.'[row_order][]" value="'.$row_id.'" />'
				        . '</th>';
			}

			// add the cell data
			foreach ($cols as $col_index => $col)
			{
				$col_id = 'col_id_'.$col['col_id'];

				$col_count = $col_index + 1;

				$td_class = 'matrix';

				// is this the first data cell?
				if ($col_count == 1)
				{
					// is this also the first cell in the <tr>?
					if ($max_rows == '1') $td_class .= ' matrix-first';

					// use .matrix-firstcell for active state
					$td_class .= ' matrix-firstcell';
				}

				if ($col_count == $total_cols) $td_class .= ' matrix-last';

				// get new instance of this celltype
				$celltype = $celltypes[$col['col_type']];

				$cell_name = $field_name.'['.$row_id.']['.$col_id.']';
				$cell_data = $row['col_id_'.$col['col_id']];

				// get the cell html
				$cell_html = $celltype->display_cell($cell_name, $cell_data, $col_settings[$col['col_id']]);

				// is the celltype sending settings too?
				if (is_array($cell_html))
				{
					if (isset($cell_html['settings']))
					{
						$row_js['cellSettings'][$col_id] = $cell_html['settings'];
					}

					if (isset($cell_html['class']))
					{
						$td_class .= ' '.$cell_html['class'];
					}

					$cell_html = $cell_html['data'];
				}

				$tbody .= '<td class="'.$td_class.'">'.$cell_html.'</td>';
			}

			$tbody .= '</tr>';

			$rows_js[] = $row_js;
		}

		$tbody .= '</tbody>';

		// -------------------------------------------
		//  Plug it all together
		// -------------------------------------------

		$r = '<div id="'.$field_name.'" class="matrix" style="margin: 5px 8px 12px 0">'
		   .   '<table class="matrix" cellspacing="0" cellpadding="0" border="0">'
		   .     $thead
		   .     $tbody
		   .   '</table>';

		if ($max_rows == 1)
		{
			$r .= '<input type="hidden" name="'.$field_name.'[row_order][]" value="'.$rows_js[0]['id'].'" />';
		}
		else
		{
			$r .= '<a class="matrix-btn matrix-add'.($max_rows == count($data) ? ' matrix-btn-disabled' :  '').'" title="'.$LANG->line('add_row').'"></a>';
		}

		$r .= '</div>';

		// add json lib if < PHP 5.2
		include_once 'includes/jsonwrapper/jsonwrapper.php';

		// initialize the field js
		$js = 'var m = new Matrix("'.$field_name.'", '.json_encode($cols_js).', '.json_encode($rows_js).($max_rows ? ', '.$max_rows : '').');';
		if ($new) $js .= NL.'m.totalNewRows = 1;';
		$this->insert_js($js);

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	 * Flatten Data
	 */
	private function _flatten_data($data)
	{
		$r = array();

		if (is_array($data))
		{
			foreach ($data as $val)
			{
				$r[] = $this->_flatten_data($val);
			}
		}
		else
		{
			$r[] = $data;
		}

		return implode(NL, array_filter($r));
	}

	// --------------------------------------------------------------------

	/**
	 * Save Field
	 */
	function save_field($field_data, $field_settings, $entry_id)
	{
		global $DB, $PREFS, $FF;

		// -------------------------------------------
		//  Get the cols
		// -------------------------------------------

		$col_ids = isset($field_settings['col_ids']) ? $field_settings['col_ids'] : FALSE;
		$cols = $this->_get_field_cols($col_ids);
		if (! $cols) return;

		$r = array();
		$data_exists = FALSE;

		$celltypes = $this->_get_celltypes();

		$col_settings = array();

		foreach ($cols as $col)
		{
			$celltype = $celltypes[$col['col_type']];
			$col_settings[$col['col_id']] = array_merge((isset($celltype->default_cell_settings) ? $celltype->default_cell_settings : array()), $col['col_settings']);
		}

		$delete_rows = isset($field_data['deleted_rows']) ? $field_data['deleted_rows'] : array();

		// -------------------------------------------
		//  Add/update rows
		// -------------------------------------------

		foreach ($field_data['row_order'] as $row_order => $row_id)
		{
			$row = $field_data[$row_id];

			$new = (substr($row_id, 0, 8) == 'row_new_');

			$save_row = FALSE;

			$row_data = array(
				'row_order' => $row_order
			);

			foreach ($cols as $col)
			{
				$celltype = $celltypes[$col['col_type']];

				$cell_data = isset($row['col_id_'.$col['col_id']]) ? $row['col_id_'.$col['col_id']] : '';

				// give the celltype a chance to do what it wants with it
				if (method_exists($celltype, 'save_cell'))
				{
					// put these vars in place as to not break nGen File Field
					$this->row_count = $row_id;
					$this->col_id = 'col_id_'.$col['col_id'];

					$cell_data = $celltype->save_cell($cell_data, $col_settings[$col['col_id']], $entry_id);

					unset($this->row_count);
					unset($this->col_id);
				}

				if ($cell_data)
				{
					$data_exists = TRUE;
					$save_row = TRUE;

					// searchable?
					if ($col['col_search'] == 'y')
					{
						$r[] = $cell_data;
					}
				}

				$row_data['col_id_'.$col['col_id']] = $cell_data;
			}

			// does the row have any data to save?
			if ($save_row)
			{
				if ($new)
				{
					$row_data['site_id'] = $PREFS->ini('site_id');
					$row_data['entry_id'] = $entry_id;
					$row_data['field_id'] = $FF->field_id;

					// insert the row
					$DB->query($DB->insert_string('exp_matrix_data', $row_data));
				}
				else
				{
					$row_id = substr($row_id, 7);

					// just update the existing row
					$DB->query($DB->update_string('exp_matrix_data', $row_data, 'row_id = '.$row_id));
				}
			}
			else
			{
				if (! $new)
				{
					// mark the row for deletion
					$delete_rows[] = $row_id;
				}
			}
		}

		// -------------------------------------------
		//  Delete any removed rows
		// -------------------------------------------

		foreach($delete_rows as $row_id)
		{
			$row_id = substr($row_id, 7);

			// delete the rows from exp_matrix_cols
			$DB->query('DELETE FROM exp_matrix_data WHERE row_id = '.$row_id);
		}

		// return a flattened string of all the searchable
		// columns' rows for searchability's sake
		$r = $this->_flatten_data($r);
		return $data_exists ? ($r ? $r : '1') : '';
	}

	// --------------------------------------------------------------------

	/**
	 * Delete Entries - Loop
	 */
	function delete_entries_loop($entry_id, $weblog_id)
	{
		global $DB;

		$DB->query('DELETE FROM exp_matrix_data WHERE entry_id = '.$entry_id);
	}

	// --------------------------------------------------------------------

	/**
	 * Data Query
	 */
	private function _data_query($params, $cols)
	{
		global $PREFS, $DB, $FF, $FNS;

		if (! $cols) return FALSE;

		// -------------------------------------------
		//  What's and Where's
		// -------------------------------------------

		$select = 'row_id';
		$where = '';
		$use_where = FALSE;

		$col_ids_by_name = array();

		foreach ($cols as $col)
		{
			$col_id = 'col_id_'.$col['col_id'];
			$select .= ', '.$col_id;
			$col_ids_by_name[$col['col_name']] = $col['col_id'];

			if (isset($params['search:'.$col['col_name']]))
			{
				$use_where = TRUE;
				$terms = $params['search:'.$col['col_name']];

				if (strncmp($terms, '=', 1) == 0)
				{
					// -------------------------------------------
					//  Exact Match e.g.: search:body="=pickle"
					// -------------------------------------------

					$terms = substr($terms, 1);

					// special handling for IS_EMPTY
					if (strpos($terms, 'IS_EMPTY') !== FALSE)
					{
						$terms = str_replace('IS_EMPTY', '', $terms);

						$add_search = $FNS->sql_andor_string($terms, $col_id);

						// remove the first AND output by $FNS->sql_andor_string() so we can parenthesize this clause
						$add_search = substr($add_search, 3);

						$not = (strncmp($terms, 'not ', 4) == 0);
						$conj = ($add_search != '' && ! $not) ? 'OR' : 'AND';

						if ($not)
						{
							$where .= 'AND ('.$add_search.' '.$conj.' '.$col_id.' != "") ';
						}
						else
						{
							$where .= 'AND ('.$add_search.' '.$conj.' '.$col_id.' = "") ';
						}
					}
					else
					{
						$where .= $FNS->sql_andor_string($terms, $col_id).' ';
					}
				}
				else
				{
					// -------------------------------------------
					//  "Contains" e.g.: search:body="pickle"
					// -------------------------------------------

					if (strncmp($terms, 'not ', 4) == 0)
					{
						$terms = substr($terms, 4);
						$like = 'NOT LIKE';
					}
					else
					{
						$like = 'LIKE';
					}

					if (strpos($terms, '&&') !== FALSE)
					{
						$terms = explode('&&', $terms);
						$andor = (strncmp($like, 'NOT', 3) == 0) ? 'OR' : 'AND';
					}
					else
					{
						$terms = explode('|', $terms);
						$andor = (strncmp($like, 'NOT', 3) == 0) ? 'AND' : 'OR';
					}

					$where .= ' AND (';

					foreach ($terms as $term)
					{
						if ($term == 'IS_EMPTY')
						{
							$where .= ' '.$col_id.' '.$like.' "" '.$andor;
						}
						elseif (strpos($term, '\W') !== FALSE) // full word only, no partial matches
						{
							$not = ($like == 'LIKE') ? ' ' : ' NOT ';

							// Note: MySQL's nutty POSIX regex word boundary is [[:>:]]
							$term = '([[:<:]]|^)'.preg_quote(str_replace('\W', '', $term)).'([[:>:]]|$)';

							$where .= ' '.$col_id.$not.'REGEXP "'.$DB->escape_str($term).'" '.$andor;
						}
						else
						{
							$where .= ' '.$col_id.' '.$like.' "%'.$DB->escape_like_str($term).'%" '.$andor;
						}
					}

					$where = substr($where, 0, -strlen($andor)).') ';
				}
			}
		}

		// -------------------------------------------
		//  Row IDs
		// -------------------------------------------

		if ($params['row_id'])
		{
			$use_where = TRUE;

			if (strncmp($params['row_id'], 'not ', 4) == 0)
			{
				$not = 'NOT ';
				$params['row_id'] = substr($params['row_id'], 4);
			}
			else
			{
				$not = '';
			}

			$where .= ' AND row_id '.$not.'IN (' . str_replace('|', ',', $params['row_id']) . ')';
		}

		$sql = 'SELECT '.(isset($params['count']) ? 'COUNT(row_id) count' : $select).'
		        FROM   exp_matrix_data
		        WHERE  field_id = '.$FF->field_id.'
		               AND entry_id = '.$FF->row['entry_id'].'
		               '.($use_where ? $where : '');

		// -------------------------------------------
		//  Orberby + Sort
		// -------------------------------------------

		$orderbys = ($params['orderby']) ? explode('|', $params['orderby']) : array('row_order');
		$sorts    = ($params['sort']) ? explode('|', $params['sort']) : array();

		$all_orderbys = array();
		foreach($orderbys as $i => $name)
		{
			$name = (isset($col_ids_by_name[$name])) ? 'col_id_'.$col_ids_by_name[$name] : $name;
			$sort = (isset($sorts[$i]) && strtoupper($sorts[$i]) == 'DESC') ? 'DESC' : 'ASC';
			$all_orderbys[] = $name.' '.$sort;
		}

		$sql .=  ' ORDER BY '.implode(', ', $all_orderbys);

		// -------------------------------------------
		//  Offset and Limit
		// -------------------------------------------

		if ((! $params['sort'] || $params['sort'] != 'random') && ($params['limit'] || $params['offset']))
		{
			$offset = ($params['offset']) ? $params['offset'] . ', ' : '';
			$limit  = ($params['limit']) ? $params['limit'] : 100;

			$sql .= ' LIMIT ' . $offset . $limit;
		}

		// -------------------------------------------
		//  Run and return
		// -------------------------------------------

		$query = $DB->query($sql);

		return isset($params['count']) ? $query->row['count'] : ($query->num_rows ? $query->result : FALSE);
	}

	// --------------------------------------------------------------------

	/**
	 * Display Tag
	 */
	function display_tag($params, $tagdata, $field_data, $field_settings)
	{
		global $IN, $FF, $TMPL, $FNS;

		// return table if single tag
		if ( ! $tagdata)
		{
			return $this->table($params, $tagdata, $field_data, $field_settings);
		}

		// dynamic params
		if ($params['dynamic_parameters'])
		{
			$dynamic_parameters = explode('|', $params['dynamic_parameters']);
			foreach ($dynamic_parameters as $param)
			{
				if (isset($_POST[$param]))
				{
					$params[$param] = $val;
				}
			}
		}

		$r = '';

		// -------------------------------------------
		//  Get the columns
		// -------------------------------------------

		$col_ids = isset($field_settings['col_ids']) ? $field_settings['col_ids'] : array();
		$cols = $this->_get_field_cols($col_ids);
		if (! $cols) return $r;

		// -------------------------------------------
		//  Get the data
		// -------------------------------------------

		$data = $this->_data_query($params, $cols);

		if (! $data) return $r;

		// -------------------------------------------
		//  Randomize
		// -------------------------------------------

		if ($params['sort'] == 'random')
		{
			shuffle($data);

			// apply the limit now, since we didn't do it in the original query
			if ($params['limit'])
			{
				$data = array_splice($data, 0, $params['limit']);
			}
		}

		// -------------------------------------------
		//  Prep Iterators
		// -------------------------------------------

		$this->prep_iterators($tagdata);
		$this->_count_tag = 'row_count';

		// -------------------------------------------
		//  Tagdata
		// -------------------------------------------

		$celltypes = $this->_get_celltypes();
		$total_rows = count($data);

		foreach($data as $row_count => $row)
		{
			$row_tagdata = $tagdata;

			$tags = array();

			foreach($cols as $col)
			{
				$col_id = 'col_id_'.$col['col_id'];

				$celltype = isset($celltypes[$col['col_type']]) ? $celltypes[$col['col_type']] : $celltypes['text'];
				$tags[$col['col_name']] = array(
					'data'     => $row[$col_id],
					'settings' => array_merge(
					                  (isset($celltype->default_cell_settings) ? $celltype->default_cell_settings : array()),
					                  (isset($col['col_settings']) ? $col['col_settings'] : array())
					              ),
					'ftype'    => $celltype,
					'helpers'  => array()
				);
			}

			$vars = array(
				'total_rows' => $total_rows,
				'row_id'     => $row['row_id']
			);

			$row_tagdata = $FNS->prep_conditionals($row_tagdata, $vars);
			$row_tagdata = $FNS->var_swap($row_tagdata, $vars);

			$FF->_parse_tagdata($row_tagdata, $tags);

			// parse {switch} and {row_count} tags
			$this->parse_iterators($row_tagdata);

			$r .= $row_tagdata;
		}

		if (isset($params['backspace']) && $params['backspace'])
		{
			$r = substr($r, 0, -$params['backspace']);
		}

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	 * Table
	 */
	function table($params, $tagdata, $field_data, $field_settings)
	{
		$thead = '';
		$tagdata = '    <tr>' . "\n";

		// get the cols
		$col_ids = isset($field_settings['col_ids']) ? $field_settings['col_ids'] : array();
		$cols = $this->_get_field_cols($col_ids);
		if (! $cols) return '';

		foreach($cols as $col)
		{
			$thead .= '      <th scope="col">'.$col['col_label'].'</th>' . "\n";
			$tagdata .= '      <td>'.LD.$col['col_name'].RD.'</td>' . "\n";
		}

		$tagdata .= '    </tr>' . "\n";

		$cellspacing = $params['cellspacing'] ? ' cellspacing="'.$params['cellspacing'].'"' : '';
		$cellpadding = $params['cellpadding'] ? ' cellpadding="'.$params['cellpadding'].'"' : '';

		return '<table' . $cellspacing . $cellpadding . '>' . "\n"
		     . '  <thead>' . "\n"
		     . '    <tr>' . "\n"
		     .        $thead
		     . '    </tr>' . "\n"
		     . '  </thead>' . "\n"
		     . '  <tbody>' . "\n"
		     .      $this->display_tag($params, $tagdata, $field_data, $field_settings)
		     . '  </tbody>' . "\n"
		     . '</table>';
	}

	/**
	 * Total Rows
	 */
	function total_rows($params, $tagdata, $field_data, $field_settings)
	{
		$params['count'] = TRUE;

		$col_ids = isset($field_settings['col_ids']) ? $field_settings['col_ids'] : array();
		$cols = $this->_get_field_cols($col_ids);
		if (! $cols) return 0;

		$total_rows = $this->_data_query($params, $cols);

		return $total_rows;
	}

}
