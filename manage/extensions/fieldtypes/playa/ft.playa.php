<?php

if ( ! defined('EXT')) exit('Invalid file request');


/**
 * Playa Class
 *
 * @package   Playa
 * @author    Brandon Kelly <me@brandon-kelly.com>
 * @copyright Copyright (c) 2009 Brandon Kelly
 */
class Playa extends Fieldframe_Fieldtype {

	var $info = array(
		'name'             => 'Playa',
		'version'          => '2.1.2',
		'desc'             => 'The proverbial multiple relationships field',
		'docs_url'         => 'http://brandon-kelly.com/apps/playa',
		'versions_xml_url' => 'http://brandon-kelly.com/downloads/versions.xml'
	);

	var $hooks = array(
		'sessions_start' => array('priority' => 1),
		'delete_entries_start',
		'delete_entries_loop'
	);

	var $requires = array(
		'ff'        => '1.0.5',
		'cp_jquery' => '1.1'
	);

	var $default_site_settings = array(
		'license_key' => ''
	);

	var $default_field_settings = array(
		'blogs'   => array(),
		'ui_mode' => 'drop_filters'
	);

	var $default_cell_settings = array(
		'blogs'   => array(),
		'ui_mode' => 'select'
	);

	var $default_tag_params = array(
		'author_id'           => '',
		'backspace'           => '0',
		'category'            => '',
		'category_group'      => '',
		'entry_id'            => '',
		'fixed_order'         => '',
		'group_id'            => '',
		'limit'               => '0',
		'offset'              => '0',
		'orderby'             => '',
		'show_expired'        => 'no',
		'show_future_entries' => 'no',
		'sort'                => '',
		'status'              => 'not closed',
		'url_title'           => '',
		'weblog'              => ''
	);

	var $postpone_saves = TRUE;

	var $cache = array();

	var $ui_modes = array(
		'drop_filters' => 'ui_mode_drop_filters',
		'drop'         => 'ui_mode_drop',
		'multi'        => 'ui_mode_multi',
		'select'       => 'ui_mode_select'
	);

	/**
	 * Update Fieldtype
	 *
	 * @param string  $from  The currently installed version
	 */
	function update($from)
	{
		global $DB, $FF;

		if ( ! $from)
		{
			// delete Playa Classic hooks
			$DB->query('DELETE FROM exp_extensions WHERE class = "Playa"');

			// update Playa Classic fields
			$fields_q = $DB->query('SELECT * FROM exp_weblog_fields WHERE field_type = "playa"');
			foreach($fields_q->result as $field_r)
			{
				$field_settings = array(
					'blogs' => explode(',', $field_r['field_list_items'])
				);

				$data = array(
					'field_type'            => 'ftype_id_'.$this->_fieldtype_id,
					'ff_settings'           => addslashes(serialize($field_settings)),
					'field_maxl'            => '',
					'field_ta_rows'         => '',
					'field_list_items'      => '',
					'field_related_orderby' => '',
					'field_related_max'     => ''
				);

				$DB->query($DB->update_string('exp_weblog_fields', $data, 'field_id = "'.$field_r['field_id'].'"'));
			}
		}
	}

	/**
	 * Display Site Settings
	 */
	function display_site_settings()
	{
		global $DB, $PREFS, $DSP;

		$SD = new Fieldframe_SettingsDisplay();

		$r = $SD->block()
		   . $SD->row(array(
		                  $SD->label('license_key_label', 'license_key_desc'),
		                  $SD->text('license_key', $this->site_settings['license_key'])
		              ))
		   . $SD->block_c();

		return $r;
	}

	/**
	 * Update field settings
	 *
	 * @param  array  field settings
	 * @access private
	 */
	function _update_field_settings(&$field_settings)
	{
		if (isset($field_settings['show_filters']))
		{
			if ($field_settings['show_filters'] == 'n') $field_settings['ui_mode'] = 'drop';
			unset($field_settings['show_filters']);
		}
	}

	/**
	 * Update cell settings
	 *
	 * @param  array  field settings
	 * @access private
	 */
	function _update_cell_settings(&$cell_settings)
	{
		if (isset($cell_settings['multi']))
		{
			if ($cell_settings['multi'] == 'y') $cell_settings['ui_mode'] = 'multi';
			unset($cell_settings['multi']);
		}
	}

	/**
	 * Blogs Multi-select
	 *
	 * @return string  multi-select HTML
	 * @access private
	 */
	function _blogs_select($selected_blogs)
	{
		global $PREFS, $LANG, $DSP, $DB;

		// Is MSM enabled?
		$msm = ($PREFS->ini('multiple_sites_enabled') == 'y');

		// Get the current Site ID
		$site_id = $PREFS->ini('site_id');

		$r = $DSP->qdiv('defaultBold', $LANG->line('blogs_label'));

		$blogs = $DB->query('SELECT w.weblog_id, s.site_label, w.blog_title
		                       FROM exp_weblogs w, exp_sites s
		                       WHERE s.site_id = w.site_id '
		                       . ($msm ? '' : 'AND s.site_id = "'.$site_id.'" ')
		                       . 'ORDER BY s.site_label, w.blog_title ASC');

		if ($blogs->num_rows)
		{
			$options = '';
			$row_count = 0;
			if ($msm) $current_site_label = '';

			foreach($blogs->result as $blog)
			{
				if ($msm AND $blog['site_label'] != $current_site_label)
				{
					if ($current_site_label) $options .= '</optgroup>';
					$options .= '<optgroup label="'.$blog['site_label'].'">';
					$current_site_label = $blog['site_label'];
					$row_count++;
				}

				$selected = in_array($blog['weblog_id'], $selected_blogs) ? 1 : 0;
				$options .= $DSP->input_select_option($blog['weblog_id'], $blog['blog_title'], $selected);
				$row_count++;
			}

			if ($msm) $options .= '</optgroup>';

			$r .= $DSP->input_select_header('blogs[]', 'y', ($row_count < 15 ? $row_count : 15), 'auto')
			    . $options
			    . $DSP->input_select_footer();
		}
		else
		{
			$r .= $DSP->qdiv('highlight', $LANG->line('no_weblogs_exist'));
		}

		return $r;
	}

	/**
	 * Display Field Settings
	 * 
	 * @param  array  $field_settings  The field's settings
	 * @return array  Settings HTML (cell1, cell2, rows)
	 */
	function display_field_settings($field_settings)
	{
		global $LANG;

		$this->_update_field_settings($field_settings);

		// initialize Fieldframe_SettingsDisplay
		$SD = new Fieldframe_SettingsDisplay();

		return array(
			'cell1' => $SD->label('ui_mode_label')
			         . $SD->select('ui_mode', $field_settings['ui_mode'], $this->ui_modes),
			'cell2' => $this->_blogs_select($field_settings['blogs'])
		);
	}

	/**
	 * Display Cell Settings
	 * 
	 * @param  array  $cell_settings  The cell's settings
	 * @return array  Settings HTML
	 */
	function display_cell_settings($cell_settings)
	{
		global $DSP, $LANG;

		$this->_update_cell_settings($cell_settings);

		// initialize Fieldframe_SettingsDisplay
		$SD = new Fieldframe_SettingsDisplay();

		$r = '<label class="itemWrapper">'
		   .   $this->_blogs_select($cell_settings['blogs'])
		   . '</label>'
		   . '<label class="itemWrapper">'
		   .   $DSP->qdiv('defaultBold', $LANG->line('ui_mode_label'))
		   .   $SD->select('ui_mode', $cell_settings['ui_mode'], $this->ui_modes)
		   . '</label>';
		return $r;
	}

	/**
	 * Assemble Relationship Reference
	 *
	 * @param  int|string   $rel_id   Relationship ID
	 * @param  string       $title    Entry title
	 * @return string                 "[789] Title of Child Entry"
	 */
	function _assemble_rel_reference($rel_id, $title)
	{
		return '['.$rel_id.'] '.str_replace('\'', '', $title);
	}

	/**
	 * Check For Playa Relationship
	 *
	 * @param  string       $data     Playa data
	 * @param  int|string   $rel_id   Relationship ID
	 * @return bool                   TRUE if $rel_id found in $data
	 * @since  version 1.0.0
	 */
	function _check_for_playa_rel($data='', $rel_id)
	{
		return (preg_match('/\[(\!)?'.$rel_id.'\]/', $data));
	}

	/**
	 * Get Relationship IDs
	 *
	 * @param  string   $data            Playa data
	 * @param  bool     $ignore_closed   Only return "open" children if TRUE
	 * @return array                     All relationship IDs found in data (rel, mrel, or playa)
	 * @since  version 1.0.0
	 */
	function _get_rel_ids($data='', $ignore_closed=FALSE)
	{
		$rel_ids = array();

		$lines = array_filter(preg_split("/[\r\n]+/", $data));
		if (count($lines))
		{
			foreach($lines as $line)
			{
				if (preg_match('/\[(\!)?(\d+)\]/', $line, $matches))
				{
					if ( ! $ignore_closed OR ! $matches[1])
					{
						$rel_ids[] = $matches[2];
					}
				}
				else
				{
					$rel_ids[] = $line;
				}
			}
		}

		return $rel_ids;
	}

	/**
	 * Get Playa Field Names
	 *
	 * @return array   All field_id_XXX's with the Playa field type
	 * @since  version 1.0.0
	 */
	function _get_fields()
	{
		global $DB;
	
		if ( ! isset($this->cache['fields']))
		{
			$this->cache['fields'] = array();

			$query = $DB->query('SELECT field_id FROM exp_weblog_fields
			                       WHERE field_type = "ftype_id_'.$this->_fieldtype_id.'"');
			if ($query->num_rows)
			{
				foreach($query->result as $row)
				{
					$this->cache['fields'][] = 'field_id_'.$row['field_id'];
				}
			}
		}

		return $this->cache['fields'];
	}

	/**
	 * Get Entry's Parents
	 *
	 * @param  int|string   $child_id   Child entry ID
	 * @return array                    Array of associative arrays holding 'rel_id', 'parent_id', 'field_name', and 'field_data' for each parent
	 * @since  version 1.0.0
	 */
	function _get_parents($child_id)
	{
		global $DB;

		$parents = array();


		// Get all rels (rel, mrel, or playa)
		$rels = $DB->query('SELECT rel_id, rel_parent_id
		                      FROM exp_relationships
		                      WHERE rel_child_id = "'.$child_id.'"');

		if ($rels->num_rows)
		{
			// filter out non-Playa rels

			if ($playa_fields = $this->_get_fields())
			{
				foreach($rels->result as $rel)
				{
					$rel_id = $rel['rel_id'];
					$rel_parent_id = $rel['rel_parent_id'];

					$query = $DB->query('SELECT '.implode(', ', $playa_fields).'
					                       FROM exp_weblog_data
					                       WHERE entry_id = '.$rel_parent_id.'
					                         AND '.implode(' LIKE "%['.$rel_id.']%" OR ', $playa_fields).' LIKE "%['.$rel_id.']%" OR '.
					                               implode(' LIKE "%[!'.$rel_id.']%" OR ', $playa_fields).' LIKE "%[!'.$rel_id.']%"
					                       LIMIT 1');
					if ($query->num_rows)
					{
						foreach($query->row as $field_name => $field_data)
						{
							$rel_ids = $this->_get_rel_ids($field_data);
							if (in_array($rel_id, $rel_ids))
							{
								$parents[] = array(
									'rel_id'     => $rel_id,
									'parent_id'  => $rel_parent_id,
									'field_name' => $field_name,
									'field_data' => $field_data
								);

								break;
							}
						}
					}
				}
			}
		}

		return $parents;
	}

	/**
	 * Sessions Start
	 */
	function sessions_start()
	{
		global $IN, $REGX, $DB;

		// Does the world revolve around Playa?
		if ($IN->GBL('C') != 'playa') return;

		if ($IN->GBL('M') == 'search')
		{
			// import the Search module
			if ( ! class_exists('Search'))
			{
	        	require PATH_MOD.'search/mod.search'.EXT;
			}

			$entry_ids = array();
			$M = new Search();
			$_POST['weblog_id'] = explode('|', $_GET['weblogs']);
			$_POST['search_in'] = 'everywhere';
			$_POST['where'] = 'all';
			$_POST['show_future_entries'] = 'yes';
			$_POST['show_expired'] = 'yes';
			$M->keywords = $REGX->keyword_clean($_GET['keywords']);
			if ($sql = $M->build_standard_query())
			{
				$query = $DB->query($sql);
				foreach($query->result as $row)
				{
					$entry_ids[] = '"'.$row['entry_id'].'"';
				}
			}

			header('Cache-Control: no-cache, must-revalidate');
			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
			header('Content-type: application/json');
			exit('({"entries":[' . implode(',', $entry_ids) . ']})');
		}
	}

	/**
	 * Get Selected Entry IDs
	 *
	 * @param  string  $playa_data  The Playa data from exp_weblog_data
	 * @return array   selected entry IDs
	 */
	function _get_selected_entry_ids($playa_data)
	{
		global $DB;

		$selected_entry_ids = array();

		$rel_ids = $this->_get_rel_ids($playa_data);
		if (count($rel_ids))
		{
			$rels = $DB->query('SELECT rel_id, rel_child_id
			                      FROM exp_relationships
			                      WHERE rel_id IN ('.implode(',', $rel_ids).')');

			if ($rels->num_rows)
			{
				$selected_entry_ids_by_rel_id = array();

				foreach($rels->result as $rel)
				{
					$selected_entry_ids_by_rel_id[$rel['rel_id']] = $rel['rel_child_id'];
				}

				foreach($rel_ids as $rel_id)
				{
					if (array_key_exists($rel_id, $selected_entry_ids_by_rel_id))
					{
						$selected_entry_ids[] = $selected_entry_ids_by_rel_id[$rel_id];
					}
				}
			}
		}

		return $selected_entry_ids;
	}

	/**
	 * Category Filter Snippet
	 *
	 * @param  array   &$cats            options array to be added to
	 * @param  array   &$cats_by_parent  array of all categories, grouped by parent_id
	 * @param  string  $parent_id        parent_id to check
	 * @param  string  $indent           option prefix of non-breaking spaces
	 * @access private
	 */
	function _cats_f(&$cats=array(), &$cats_by_parent, $parent_id='0', $indent='')
	{
		foreach($cats_by_parent[$parent_id] as $cat_id => $cat)
		{
			$cats[$cat_id] = $indent.$cat['cat_name'];
			if (isset($cats_by_parent[$cat_id]))
			{
				$this->_cats_f($cats, $cats_by_parent, "$cat_id", $indent.'    ');
			}
		}
	}

	/**
	 * Status CSS Snippet
	 *
	 * @param  string  $id         Status ID
	 * @param  string  $highlight  highlight color
	 * @return string  CSS snippet
	 * @access private
	 */
	function _status_css($id, $highlight)
	{
		return '  .playa .status.'.$id.' { background-color: #'.$highlight.'; }' . NL;
	}

	/**
	 * Display Field
	 * 
	 * @param  string  $field_name      The field's name
	 * @param  mixed   $field_data      The field's current value
	 * @param  array   $field_settings  The field's settings
	 * @return string  The field's HTML
	 */
	function display_field($field_name, $field_data, $field_settings, $cell=FALSE)
	{
		global $DB, $DSP, $LANG, $PREFS;

		$this->_update_field_settings($field_settings);

		if ( ! isset($this->no_related_entries))
		{
			$LANG->fetch_language_file('publish');
			$this->no_related_entries = $DSP->qdiv('highlight_alt', $LANG->line('no_related_entries'));
		}

		if (is_array($field_data))
		{
			$selected_entry_ids = $field_data['selections'];
			$old_field_data = $field_data['old'];
		}
		else
		{
			$selected_entry_ids = $this->_get_selected_entry_ids($field_data);
			$old_field_data = $field_data;
		}

		// are there any assigned weblogs?
		if ( ! count($field_settings['blogs'])) return $this->no_related_entries;

		switch($field_settings['ui_mode'])
		{
			case 'drop_filters': case 'drop': return $this->display_field_droppanes($field_name, $field_data, $field_settings, $old_field_data, $selected_entry_ids, $cell);
			case 'multi': case 'select':      return $this->display_field_select($field_name, $field_data, $field_settings, $old_field_data, $selected_entry_ids);
		}
	}

	/**
	 * Display Field - Drop panes
	 */
	function display_field_droppanes($field_name, $field_data, $field_settings, $old_field_data, $selected_entry_ids, $cell)
	{
		global $DB, $LANG, $PREFS;

		// get the weblog info
		$blogs_q = $DB->query('SELECT weblog_id, blog_title, cat_group, status_group
		                         FROM exp_weblogs
		                         WHERE weblog_id IN ('.implode(',', $field_settings['blogs']).')
		                         ORDER BY blog_title');

		// do any of the assigned weblogs still exist?
		if ( ! $blogs_q->num_rows) return $this->no_related_entries;

		/** ----------------------------------------
		/**  Get filter options
		/** ----------------------------------------*/

		$filters = array(
			'weblog'   => array(),
			'category' => array(),
			'author'   => array(),
			'status'   => array(
				'open'   => $LANG->line('open'),
				'closed' => $LANG->line('closed')
			)
		);

		$cat_groups = array();
		$status_groups = array();

		foreach($blogs_q->result as $blog_r)
		{
			$filters['weblog'][$blog_r['weblog_id']] = $blog_r['blog_title'];
			if ($blog_r['cat_group'])    $cat_groups    = array_merge($cat_groups,    explode('|', $blog_r['cat_group']));
			if ($blog_r['status_group']) $status_groups = array_merge($status_groups, array($blog_r['status_group']));
		}

			/** ----------------------------------------
			/**  Categories
			/** ----------------------------------------*/

			if ($cat_groups)
			{
				$cats_q = $DB->query('SELECT c.cat_id, c.cat_name, c.parent_id, g.group_name
				                        FROM exp_categories c, exp_category_groups g
				                        WHERE c.group_id = g.group_id
				                          AND g.group_id IN ('.implode(',', array_filter($cat_groups)).')
				                        ORDER BY g.group_name, c.parent_id, c.cat_name');
				$cats_by_parent = array();
				foreach($cats_q->result as $cat)
				{
					if ( ! isset($cats_by_parent[$cat['group_name']]))
					{
						$cats_by_parent[$cat['group_name']] = array();
					}
					if ( ! isset($cats_by_parent[$cat['group_name']][$cat['parent_id']]))
					{
						$cats_by_parent[$cat['group_name']][$cat['parent_id']] = array();
					}

					$cats_by_parent[$cat['group_name']][$cat['parent_id']][$cat['cat_id']] = $cat;
				}

				foreach($cats_by_parent as $group_name => $cats)
				{
					$this->_cats_f($filters['category'][$group_name], $cats);
				}
			}

			/** ----------------------------------------
			/**  Authors
			/** ----------------------------------------*/

			$author_groups = array('1');
			$author_groups_q = $DB->query('SELECT group_id FROM exp_weblog_member_groups
			                                 WHERE weblog_id IN ('.implode(',', $field_settings['blogs']).')');
			foreach($author_groups_q->result as $author_group_r)
			{
				array_push($author_groups, $author_group_r['group_id']);
			}
			$authors_q = $DB->query('SELECT m.member_id, m.screen_name, g.group_title
			                           FROM exp_members m, exp_member_groups g
			                           WHERE m.group_id = g.group_id
			                             AND g.group_id IN ('.implode(',', $author_groups).')
			                           ORDER BY g.group_title, m.screen_name');
			foreach($authors_q->result as $author_r)
			{
				if ( ! isset($filters['author'][$author_r['group_title']]))
				{
					$filters['author'][$author_r['group_title']] = array();
				}
				$filters['author'][$author_r['group_title']][$author_r['member_id']] = $author_r['screen_name'];
			}

			/** ----------------------------------------
			/**  Statuses
			/** ----------------------------------------*/

			$search_statuses = 'open|closed';
			if ($status_groups)
			{
				$statuses_q = $DB->query('SELECT s.status_id, s.status, g.group_name
				                           FROM exp_statuses s, exp_status_groups g
				                           WHERE s.status NOT IN ("open", "closed")
				                             AND s.group_id = g.group_id
				                             AND g.group_id IN ('.implode(',', array_filter($status_groups)).')
				                           ORDER BY g.group_name, s.status_order');
				foreach($statuses_q->result as $status_r)
				{
					$search_statuses .= '|'.$status_r['status'];
					if ( ! isset($filters['status'][$status_r['group_name']]))
					{
						$filters['status'][$status_r['group_name']] = array();
					}
					$filters['status'][$status_r['group_name']]['custom'.$status_r['status_id']] = $status_r['status'];
				}
			}

		/** ----------------------------------------
		/**  Get entries
		/** ----------------------------------------*/

		$entries_q = $DB->query('SELECT t.entry_id, t.weblog_id, t.author_id, t.title, t.status, t.entry_date, w.status_group, s.status_id
		                           FROM exp_weblog_titles t, exp_weblogs w, exp_statuses s
		                           WHERE t.weblog_id IN ('.implode(',', $field_settings['blogs']).')
		                             AND t.weblog_id = w.weblog_id
		                             AND ( w.status_group = 0 OR ( w.status_group = s.group_id AND s.status = t.status ))
		                           GROUP BY t.entry_id
		                           ORDER BY t.title ASC');

		// are there any entries?
		if ( ! $entries_q->num_rows) return $this->no_related_entries;

		// create an array of each entry ID
		$all_entry_ids = array();
		foreach($entries_q->result as $entry)
		{
			$all_entry_ids[] = $entry['entry_id'];
		}

		// Create entry/category mapping
		$cats_by_entry_id = array();
		$cats_q = $DB->query('SELECT entry_id, cat_id FROM exp_category_posts WHERE entry_id IN ('.implode(',',$all_entry_ids).')');
		foreach($cats_q->result as $cat)
		{
			$cats_by_entry_id[$cat['entry_id']][] = $cat['cat_id'];
		}

		/** ----------------------------------------
		/**  Assemble JS
		/** ----------------------------------------*/

		$field_id = str_replace(array('[', ']'), array('_', ''), $field_name);

		if ($cell)
		{
			if ( ! isset($this->cell_ids)) $this->cell_ids = array();
			else if (array_search($field_id, $this->cell_ids) !== FALSE)
			{
				$field_id .= '_new';
			}
			$this->cell_ids[] = $field_id;
		}

		$js_entries = array();
		$items_html = '';
		$selections_html = '';

		foreach($entries_q->result as $i => $entry)
		{
			$cats = isset($cats_by_entry_id[$entry['entry_id']]) ? $cats_by_entry_id[$entry['entry_id']] : NULL;

			$status = ($entry['status_group'] AND ( ! in_array($entry['status'], array('open', 'closed'))))
			  ?  ('custom'.$entry['status_id'])
			  :  $entry['status'];

			$js_entries[$entry['entry_id']] = array(
				'title'    => $entry['title'],
				'weblog'   => $entry['weblog_id'],
				'author'   => $entry['author_id'],
				'date'     => $entry['entry_date'],
				'category' => $cats,
				'status'   => $status
			);

			$items_html .= '<li id="playa-option-'.$entry['entry_id'].'"><a>'
			             .   '<span class="status '.$status.'"></span>'
			             .   $entry['title']
			             . '</a></li>';
		}

		foreach($selected_entry_ids as $entry_id)
		{
			if (isset($js_entries[$entry_id]))
			{
				$items_html = str_replace('<li id="playa-option-'.$entry_id.'">', '<li id="playa-option-'.$entry_id.'" class="selected">', $items_html);

				$js_entries[$entry_id]['selected'] = TRUE;

				$selections_html .= '<li id="playa-option-'.$entry_id.'-selected">'
				                  .   '<a>'
				                  .     '<span class="status '.$js_entries[$entry_id]['status'].'"></span>'
				                  .     $js_entries[$entry_id]['title']
				                  .   '</a>'
				                  .   '<input type="hidden" name="'.$field_name.'[selections][]" value="'.$entry_id.'" />'
				                  . '</li>';
			}
		}

		$js_options = array(
			'showFilters' => ($field_settings['ui_mode'] == 'drop_filters'),
			'keywordResultsURL' => $PREFS->core_ini['cp_url'].'?C=playa&M=search&weblogs='.implode('|', $field_settings['blogs']).'&status='.urlencode($search_statuses),
			'orderBy' => array(
			                 'title' => 'Title',
			                 'date'  => 'Date'
			             ),
			'filters' => array()
		);

		$filter_strings = array();
		foreach($filters as $filter_name => $filter)
		{
			if ($filter)
			{
				$js_options['filters'][$filter_name] = array(
					'label' => $LANG->line($filter_name),
					'options' => $filter
				);
			}
		}

		// add json lib if < PHP 5.2
		include_once 'includes/jsonwrapper/jsonwrapper.php';
		$js = json_encode($js_entries).', '.json_encode($js_options);

		if ( ! $cell)
		{
			$this->insert_js('jQuery(window).bind("load",function(){ jQuery("#'.$field_id.'").playa('.$js.'); });');
		}
		else
		{
			$this->insert_js('jQuery(window).bind("load",function(){ jQuery.fn.ffMatrix.playaConfs.'.$field_id.'=['.$js.']; });');
		}

		/** ----------------------------------------
		/**  Include Dependencies
		/** ----------------------------------------*/

		if ( ! isset($this->included_dependencies))
		{
			$css = $this->_status_css('open', '093')
			     . $this->_status_css('closed', '900');

			$statuses_q = $DB->query('SELECT status_id, highlight FROM exp_statuses
			                            WHERE status NOT IN ("open", "closed")');
			foreach ($statuses_q->result as $status_r)
			{
				$css .= $this->_status_css('custom'.$status_r['status_id'], $status_r['highlight']);
			}

			$this->insert_css($css);
			$this->include_css('styles/playa.css');
			$this->include_js('scripts/jquery.playa.js');

			$this->included_dependencies = TRUE;
		}

		$r = '<input type="hidden" name="'.$field_name.'[old]" value="'.addslashes($old_field_data).'"/>' . NL
		   . '<input type="hidden" name="'.$field_name.'[selections][]" value=""/>' . NL
		   . '<div id="'.$field_id.'" class="playa playa-droppane">'
		   .   '<table class="field"><tbody><tr>'
		   .     '<td><div class="items wrapper"><div class="outerGlow"><div class="innerShadow"><div class="scrollPane">'
		   .       '<div class="readyGlow top"></div><div class="readyGlow bottom"></div>'
		   .       '<ul>'.$items_html.'</ul>'
		   .     '</div></div></div></div></td>'

		   .     '<td class="gutter"><div class="ui-resizable-handle"></div></td>'

		   .     '<td><div class="selections wrapper"><div class="outerGlow"><div class="innerShadow"><div class="scrollPane">'
		   .       '<div class="readyGlow top"></div><div class="readyGlow bottom"></div>'
		   .       '<ul>'.$selections_html.'</ul>'
		   .     '</div></div></div></div></td>'
		   .   '</tr></tbody></table>'
		   . '</div>';

		return $r;
	}

	/**
	 * Display Field - Select
	 */
	function display_field_select($field_name, $field_data, $field_settings, $old_field_data, $selected_entry_ids)
	{
		global $DB, $DSP;

		$r = '';
		$current_weblog_title = '';
		$multi_row_count = 0;

		if ($field_settings['blogs'])
		{
			$entries_q = $DB->query('SELECT t.entry_id, t.title, w.blog_title
			                           FROM exp_weblog_titles t, exp_weblogs w
			                           WHERE t.weblog_id IN ('.implode(',', $field_settings['blogs']).')
			                             AND t.weblog_id = w.weblog_id
			                           ORDER BY w.blog_title, t.title ASC');

			foreach($entries_q->result as $i => $entry)
			{
				if ($entry['blog_title'] != $current_weblog_title)
				{
					if ($current_weblog_title) $r .= '</optgroup>' . NL;
					$r .= '<optgroup label="'.$entry['blog_title'].'">' . NL;
					$current_weblog_title = $entry['blog_title'];
					$multi_row_count++;
				}

				$selected = in_array($entry['entry_id'], $selected_entry_ids) ? 1 : 0;
				$r .= $DSP->input_select_option($entry['entry_id'], $entry['title'], $selected) . NL;
				$multi_row_count++;
			}

			$r = '<input type="hidden" name="'.$field_name.'[old]" value="'.addslashes($old_field_data).'"/>' . NL
			   . $DSP->input_select_header($field_name.'[selections][]', ($field_settings['ui_mode'] == 'multi' ? 1 : 0), ($multi_row_count < 15 ? $multi_row_count : 15), 'auto') . NL
			   . ($field_settings['ui_mode'] == 'multi' ? '' : $DSP->input_select_option('', '--') . NL)
			   . $r
			   . '</optgroup>' . NL
			   . $DSP->input_select_footer();
		}

		return $r;
	}

	/**
	 * Display Cell
	 * 
	 * @param  string  $cell_name      The cell's name
	 * @param  mixed   $cell_data      The cell's current value
	 * @param  array   $cell_settings  The cell's settings
	 * @return string  The field's HTML
	 */
	function display_cell($cell_name, $cell_data, $cell_settings)
	{
		$this->_update_cell_settings($cell_settings);
		$this->include_js('scripts/ff_matrix.js');
		return $this->display_field($cell_name, $cell_data, $cell_settings, TRUE);
	}

	/**
	 * Save Field
	 *
	 * @param  mixed   $field_data       The field's current value
	 * @param  array   $field_settings   The field's settings
	 * @param  string  $entry_id         The entry ID
	 * @return mixed   Modified $field_data
	 */
	function save_field($field_data, $field_settings, $entry_id)
	{
		global $DB, $FNS, $FF;

		$this->_update_field_settings($field_settings);

		if ( ! $entry_id)
		{
			// this is a new entry preview
			return $field_data;
		}

		if ( ! isset($field_data['selections']))
		{
			$field_data['selections'] = array();
		}

		// remove empty elements
		$selections = array_filter($field_data['selections']);

		$r = '';

		/** ----------------------------------------
		/**  Get existing rel IDs
		/** ----------------------------------------*/

		$existing_rels_to_stay = array();

		if ($existing_rel_ids = $this->_get_rel_ids($field_data['old']))
		{
			$rels = $DB->query('SELECT rel_id, rel_child_id
			                      FROM exp_relationships
			                      WHERE rel_id IN ('.implode(',', $existing_rel_ids).')');

			$existing_rels_to_delete = array();

			foreach($rels->result as $rel)
			{
				if (in_array($rel['rel_child_id'], $selections))
				{
					$existing_rels_to_stay[$rel['rel_child_id']] = $rel['rel_id'];
				}
				else
				{
					$existing_rels_to_delete[$rel['rel_child_id']] = $rel['rel_id'];
				}
			}

			// delete deselected rels
			if ($existing_rels_to_delete)
			{
				$DB->query('DELETE FROM exp_relationships
				              WHERE rel_id IN ('.implode(',',$existing_rels_to_delete).')');
			}
		}

		if ($selections)
		{
			/** ----------------------------------------
			/**  Get child titles
			/** ----------------------------------------*/

			$child_titles = array();

			$query = $DB->query('SELECT entry_id, title
			                       FROM exp_weblog_titles
			                       WHERE entry_id IN ('.implode(',', $selections).')');
			foreach($query->result as $row)
			{
				$child_titles[$row['entry_id']] = $row['title'];
			}

			/** ----------------------------------------
			/**  Build new Playa data
			/** ----------------------------------------*/

			foreach($selections as $child_id)
			{
				if (array_key_exists($child_id, $existing_rels_to_stay))
				{
					// just grab the rel_id
					$rel_id = $existing_rels_to_stay[$child_id];
				}
				else
				{
					// Compile the new relationship
					$rel = array(
						'type'       => 'blog',
						'parent_id'  => $entry_id,
						'child_id'   => $child_id,
						'related_id' => $_POST['weblog_id']
					);
					$rel_id = $FNS->compile_relationship($rel, TRUE);
				}

				// Add the rel_id to $r
				$r .= ($r ? "\r" : '')
				    . $this->_assemble_rel_reference($rel_id, $child_titles[$child_id]);
			}
		} // end if $selections

		//  Clear relationship caches where appropriate
		$DB->query('UPDATE exp_relationships SET rel_data = "", reverse_rel_data = "" WHERE rel_parent_id = "'.$entry_id.'" OR rel_child_id = "'.$entry_id.'"');

		// return the new playa data
		return $r;
	}

	/**
	 * Save Cell
	 *
	 * @param  mixed   $cell_data      The cell's current value
	 * @param  array   $cell_settings  The cell's settings
	 * @param  string  $entry_id       The entry ID
	 * @return mixed   Modified $cell_data
	 */
	function save_cell($cell_data, $cell_settings, $entry_id)
	{
		return $this->save_field($cell_data, $cell_settings, $entry_id);
	}

	/**
	 * Delete Entries - Start
	 *
	 * Gather all Playa relationships whose children are about to be deleted, and save them in the global variable $this->cache['mourning_parents'] for later use
	 *
	 * @see   http://expressionengine.com/developers/extension_hooks/delete_entries_start/
	 * @since version 1.0.0
	 */
	function delete_entries_start()
	{
		global $DB, $FF;

		$playa_fields = $this->_get_fields();
		$this->cache['mourning_parents'] = array();

		if (count($playa_fields))
		{
			foreach($_POST['delete'] as $child_id)
			{
				if ($parents = $this->_get_parents($child_id))
				{
					$this->cache['mourning_parents'][$child_id] = $parents;
				}
			}
		}
	}

	/**
	 * Delete Entries - Loop
	 *
	 * After an entry and its relationships have been deleted, delete any references to the now non-existent Playa relationships
	 *
	 * @param int|string   $child_id    Entry ID for entry being deleted during this loop
	 * @param int|string   $weblog_id   Weblog ID for entry being deleted
	 * @see   http://expressionengine.com/developers/extension_hooks/delete_entries_loop/
	 * @since version 1.0.0
	 */
	function delete_entries_loop($child_id, $weblog_id)
	{
		global $DB;

		if (isset($this->cache['mourning_parents'][$child_id]))
		{
			$playa_fields = $this->_get_fields();

			foreach($this->cache['mourning_parents'][$child_id] as $parent)
			{
				$lines = array_filter(preg_split("/[\r\n]+/", $parent['field_data']));
				$new_lines = array();
				foreach($lines as $line)
				{
					if ( ! $this->_check_for_playa_rel($line, $parent['rel_id']))
					{
						$new_lines[] = $line;
					}
				}

				$DB->query('UPDATE exp_weblog_data
				              SET '.$parent['field_name'].' = "'.implode('\r', $new_lines).'"
				              WHERE entry_id = '.$parent['parent_id']);
			}
		}
	}

	/**
	 * Parse Parameter
	 * @access private
	 */
	function _parse_param(&$param, &$not)
	{
		if (strlen($param) > 4 AND strtolower(substr($param, 0, 4)) == 'not ')
		{
			$param = substr($param, 4);
			$not = 'NOT ';
		}
		else
		{
			$not = '';
		}
	}

	/**
	 * Entries Query
	 * @access private
	 */
	function _entries_query($params, $field_data, &$rel_ids=NULL)
	{
		global $DB, $TMPL, $LOC;

		if ( ! ($rel_ids = $this->_get_rel_ids($field_data, TRUE)))
		{
			return FALSE;
		}

		$sql = 'SELECT r.rel_id, r.rel_child_id, wt.title
		          FROM exp_relationships r, exp_weblog_titles wt, exp_weblogs w
                  WHERE r.rel_id IN ('.implode(',', $rel_ids).')
                    AND wt.entry_id = r.rel_child_id
                    AND w.weblog_id = wt.weblog_id';

		// param name mapping
		$param_mapping = array('author' => 'author_id', 'category_id' => 'category');
		foreach($param_mapping as $old_name => $new_name)
		{
			if (isset($params[$old_name]) AND ! $params[$new_name])
			{
				$params[$new_name] = $params[$old_name];
				unset($params[$old_name]);
			}
		}

		/** ----------------------------------------
		/**  Author
		/** ----------------------------------------*/

		if ($params['author_id'])
		{
			$this->_parse_param($params['author_id'], $not);

			$sql .= ' AND wt.author_id '.$not.'IN ('.str_replace('|', ',', $params['author_id']).')';
		}

		/** ----------------------------------------
		/**  Author Group
		/** ----------------------------------------*/

		if ($params['group_id'])
		{
			$this->_parse_param($params['group_id'], $not);

			// get filtered list of author ids
			$query = $DB->query('SELECT member_id FROM exp_members
			                        WHERE group_id IN ('.str_replace('|', ',', $params['group_id']).')');

			if ( ! $query->num_rows)
			{
				if ( ! $not) return FALSE;
			}
			else
			{
				foreach($query->result as $row)
				{
					$author_ids[] = $row['member_id'];
				}

				$sql .= ' AND wt.author_id '.$not.'IN ('.implode(',', $author_ids).')';
			}
		}

		/** ----------------------------------------
		/**  Category
		/** ----------------------------------------*/

		if ($params['category'])
		{
			$this->_parse_param($params['category'], $not);

			// get filtered list of entry ids
			$query = $DB->query('SELECT entry_id FROM exp_category_posts
			                        WHERE cat_id IN ('.str_replace('|', ',', $params['category']).')
			                        GROUP BY entry_id');

			if ( ! $query->num_rows)
			{
				if ( ! $not) return FALSE;
			}
			else
			{
				foreach($query->result as $row)
				{
					$entry_ids[] = $row['entry_id'];
				}

				$sql .= ' AND wt.entry_id '.$not.'IN ('.implode(',', $entry_ids).')';
			}
		}

		/** ----------------------------------------
		/**  Category Group
		/** ----------------------------------------*/

		if ($params['category_group'])
		{
			$this->_parse_param($params['category_group'], $not);

			// get filtered list of entry ids
			$query = $DB->query('SELECT cp.entry_id FROM exp_category_posts cp, exp_categories c
			                        WHERE cp.cat_id = c.cat_id
			                          AND c.group_id IN ('.str_replace('|', ',', $params['category_group']).')
			                        GROUP BY entry_id');

			if ( ! $query->num_rows)
			{
				if ( ! $not) return FALSE;
			}
			else
			{
				foreach($query->result as $row)
				{
					$entry_ids[] = $row['entry_id'];
				}

				$sql .= ' AND wt.entry_id '.$not.'IN ('.implode(',', $entry_ids).')';
			}
		}

		/** ----------------------------------------
		/**  Dates
		/** ----------------------------------------*/

		$timestamp = $TMPL->cache_timestamp ? $LOC->set_gmt($TMPL->cache_timestamp) : $LOC->now;

		if ($params['show_future_entries'] != 'yes')
		{
			$sql .= ' AND wt.entry_date < '.$timestamp;
		}

		if ($params['show_expired'] != 'yes')
		{
			$sql .= ' AND (wt.expiration_date = 0 OR wt.expiration_date > '.$timestamp.')';
		}

		/** ----------------------------------------
		/**  Entry ID
		/** ----------------------------------------*/

		if ($params['entry_id'])
		{
			$this->_parse_param($params['entry_id'], $not);

			$sql .= ' AND wt.entry_id '.$not.'IN ("'.str_replace('|', '","', $params['entry_id']).'")';
		}

		/** ----------------------------------------
		/**  Status
		/** ----------------------------------------*/

		if ($params['status'])
		{
			$this->_parse_param($params['status'], $not);

			$sql .= ' AND wt.status '.$not.'IN ("'.str_replace('|', '","', $params['status']).'")';
		}

		/** ----------------------------------------
		/**  URL Title
		/** ----------------------------------------*/

		if ($params['url_title'])
		{
			$this->_parse_param($params['url_title'], $not);

			$sql .= ' AND wt.url_title '.$not.'IN ("'.str_replace('|', '","', $params['url_title']).'")';
		}

		/** ----------------------------------------
		/**  Weblog
		/** ----------------------------------------*/

		if ($params['weblog'])
		{
			$this->_parse_param($params['weblog'], $not);

			$sql .= ' AND w.blog_name '.$not.'IN ("'.str_replace('|', '","', $params['weblog']).'")';
		}

		/** ----------------------------------------
		/**  Orberby + Sort
		/** ----------------------------------------*/

		if ($params['orderby'])
		{
			$orderby = array();
			$sorts = explode('|', $params['sort']);
			foreach(explode('|', $params['orderby']) as $i => $attr)
			{
				$sort = (isset($sorts[$i]) AND strtoupper($sorts[$i]) == 'DESC') ? 'DESC' : 'ASC';
				$orderby[] = $attr.' '.$sort;
			}

			$sql .=  ' ORDER BY '.implode(', ', $orderby);
		}

		/** ----------------------------------------
		/**  Run and return
		/** ----------------------------------------*/

		return $DB->query($sql);
	}

	/**
	 * Display Tag
	 *
	 * Turns {my_playa_field} tag pairs into relationship references
	 *
	 * @param  array   $params          Name/value pairs from the opening tag
	 * @param  string  $tagdata         Chunk of tagdata between field tag pairs
	 * @param  string  $field_data      Currently saved field value
	 * @param  array   $field_settings  The field's settings
	 * @return string  relationship references
	 */
	function display_tag($params, $tagdata, $field_data, $field_settings)
	{
		global $FF, $TMPL, $DB;

		$this->_update_field_settings($field_settings);

		// return :ul if single tag
		if ( ! $tagdata)
		{
			return $this->ul($params, $tagdata, $field_data, $field_settings);
		}

		$r = '';

		if ($query = $this->_entries_query($params, $field_data, $rel_ids))
		{
			$FF->weblog->rfields[$FF->field_name] = $FF->field_id;

			$mod_rel_ids = array();

			if ($params['orderby'])
			{
				// ordering and sorting was already done within _entries_query
				// so just flatten $query->result
				foreach($query->result as $row)
				{
					$mod_rel_ids[] = $row['rel_id'];
				}
			}
			else
			{
				if ($params['fixed_order'])
				{
					// use template-defined order
					foreach($query->result as $row)
					{
						$fixed_entry_ids = explode('|', $params['fixed_order']);
						if (($key = array_search($row['rel_child_id'], $fixed_entry_ids)) !== FALSE)
						{
							$mod_rel_ids[$key] = $row['rel_id'];
						}
					}
				}
				else
				{
					// retain original order
					foreach($query->result as $row)
					{
						$key = array_search($row['rel_id'], $rel_ids);
						$mod_rel_ids[$key] = $row['rel_id'];
					}
				}

				// remove gaps and sort by key
				$mod_rel_ids = array_filter($mod_rel_ids);
				if (strtolower($params['sort']) == 'desc')
				{
					krsort($mod_rel_ids);
				}
				else
				{
					ksort($mod_rel_ids);
				}
			}

			// randomize?
			if ($params['sort'] == 'random')
			{
				shuffle($mod_rel_ids);
			}

			// offset and limit
			if ($params['offset'] OR $params['limit'])
			{
				$limit = $params['limit'] ? $params['limit'] : count($mod_rel_ids);
				$mod_rel_ids = array_splice($mod_rel_ids, $params['offset'], $limit);
			}

			// prepare for {switch} and {count} tags
			$this->prep_iterators($tagdata);

			$total_related_entries = count($mod_rel_ids);

			foreach($mod_rel_ids as $i => $rel_id)
			{
				// copy $tagdata
				$entry_tagdata = $tagdata;

				// var swaps
				$entry_tagdata = $TMPL->swap_var_single('total_related_entries', $total_related_entries, $entry_tagdata);

				// parse {switch} and {count} tags
				$this->parse_iterators($entry_tagdata);

				// wrap $tagdata with a {related_entries} tag pair
				$entry_tagdata = LD.'related_entries id="'.$FF->field_name.'"'.RD
				               . $entry_tagdata
				               . LD.SLASH.'related_entries'.RD;

				// convert tagdata into {REL[field_name]abcdefghREL}
				$TMPL->assign_relationship_data($entry_tagdata);

				// get the random marker
				$marker = array_pop(array_keys($TMPL->related_data));

				// tell the Weblog object about the new relationship
				$FF->weblog->related_entries[] = $rel_id.'_'.$marker;

				// add {REL[rel_id][field_name]abcdefghREL} to $r
				$r .= LD.'REL['.$rel_id.']['.$FF->field_name.']'.$marker.'REL'.RD;
			}

			if ($params['backspace'])
			{
				$TMPL->related_data[$marker]['tagdata'] = substr($TMPL->related_data[$marker]['tagdata'], 0, -$params['backspace']);
			}

		}
		return $r;
	}

	/**
	 * Unordered List
	 *
	 * @param  array   $params          Name/value pairs from the opening tag
	 * @param  string  $tagdata         Chunk of tagdata between field tag pairs
	 * @param  string  $field_data      Currently saved field value
	 * @param  array   $field_settings  The field's settings
	 * @return string  relationship references
	 */
	function ul($params, $tagdata, $field_data, $field_settings)
	{
		return "<ul>\n"
		     .   $this->display_tag($params, "  <li>{title}</li>\n", $field_data, $field_settings)
		     . '</ul>';
	}

	/**
	 * Ordered List
	 *
	 * @param  array   $params          Name/value pairs from the opening tag
	 * @param  string  $tagdata         Chunk of tagdata between field tag pairs
	 * @param  string  $field_data      Currently saved field value
	 * @param  array   $field_settings  The field's settings
	 * @return string  relationship references
	 */
	function ol($params, $tagdata, $field_data, $field_settings)
	{
		return "<ol>\n"
		     .   $this->display_tag($params, "  <li>{title}</li>\n", $field_data, $field_settings)
		     . '</ol>';
	}

	/**
	 * Total Related Entries
	 *
	 * @param  array   $params          Name/value pairs from the opening tag
	 * @param  string  $tagdata         Chunk of tagdata between field tag pairs
	 * @param  string  $field_data      Currently saved field value
	 * @param  array   $field_settings  The field's settings
	 * @return string  relationship references
	 */
	function total_related_entries($params, $tagdata, $field_data, $field_settings)
	{
		global $DB;

		if ($query = $this->_entries_query($params, $field_data))
		{
			return $query->num_rows;
		}

		return 0;
	}
}