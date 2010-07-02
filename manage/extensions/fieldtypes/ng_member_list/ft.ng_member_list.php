<?php
if ( ! defined('EXT')) exit('Invalid file request');

/**
 * NG! Member List Class
 *
 * @author    David Chien <david@nakedgremlin.com>
 * @copyright Copyright (c) 2009 David Chien
 * @license   http://creativecommons.org/licenses/by-sa/3.0/ Attribution-Share Alike 3.0 Unported
 */

class Ng_member_list extends Fieldframe_Fieldtype {
    var $info = array(
        'name'             => 'NG! Member List',
        'version'          => '1.1.2',
        'desc'             => 'Provides select drop down for single member association.',
        'docs_url'         => 'http://labs.nakedgremlin.com/ee/ng_member_list/',
        'versions_xml_url' => 'http://labs.nakedgremlin.com/ee/versions.xml'
    );
	var $default_site_settings = array(
		'option_template' => ''
	);
	var $default_field_settings = array(
		'options' => ''
	);
	var $default_cell_settings = array(
		'options' => ''
	);
	var $default_tag_params = array(
		'sort' => '',
		'backspace' => '0'
	);

	/**
	 * Class constructor
	 */
	function __construct() {
		global $PREFS;
		$this->db_prefix 	= $PREFS->ini('db_prefix');
	}

	/**
	 * Display Field
	 *
	 * @param  string  $field_name      The field's name
	 * @param  mixed   $field_data      The field's current value
	 * @param  array   $field_settings  The field's settings
	 * @return string  The field's HTML
	 */
 	function display_field($field_name, $field_data, $field_settings) {
		return $this->_display_field($field_name, $field_data, $field_settings);
	}

	/**
	 * Display Cell
	 *
	 * @param  string  $cell_name      The cell's name
	 * @param  mixed   $cell_data      The cell's current value
	 * @param  array   $cell_settings  The cell's settings
	 * @return string  HTML of cell
	 */
	function display_cell($cell_name, $cell_data, $cell_settings) {
		return $this->_display_field($cell_name, $cell_data, $cell_settings);
	}

	/**
	 * Display Field Settings
	 *
	 * @param  array  $field_settings  The field's settings
	 * @return array  Settings HTML (cell1, cell2, rows)
	 */
	function display_field_settings($field_settings) {
		global $DSP, $LANG;
		$member_select =	$DSP->qdiv('defaultBold', $LANG->line('member_group')).
							$this->_multiselect_member_group($field_settings['options']);
		return array('cell2' => $member_select);
	}

	/**
	 * Display Cell Settings
	 *
	 * @param  array  $field_settings  The field's settings
	 * @return array  Settings HTML (cell1, cell2, rows)
	 */
	function display_cell_settings($cell_settings) {
		global $DSP, $LANG;
		$member_select =	'<label class="itemWrapper">'.
							$DSP->qdiv('defaultBold', $LANG->line('member_group')).
							$this->_multiselect_member_group($cell_settings['options']).
							'</label>';
		return $member_select;
	}
	
	/**
	 * Builds optgroup header code
	 *
	 * @param  string 	$label  The optgroup's label
	 * @return string	optgroup HTML
	 */
	function _optgroup_header($label) {
		return '<optgroup label="'.$label.'">';
	}
	
	/**
	 * Builds optgroup footer code
	 *
	 * @return string	optgroup HTML
	 */
	function _optgroup_footer() {
		return '</optgroup>';
	}

	/**
	 * Display Field helper function to centralize logic used across
	 * both field and cell implementations
	 */
	function _display_field($field_name, $field_data, $field_settings) {
        global $IN, $DSP, $LANG, $DB, $FNS;
		
		$LANG->fetch_language_file('ng_member_list');
		$this->field_settings = $field_settings;

		$edit_field = false;

		// Checks and see if this appears in the blog_admin section of the administration
		if($IN->GBL('M', 'GET') == 'blog_admin' AND $IN->GBL('P', 'GET') == 'edit_field') {
			$edit_field = true;
		}
		$field = '';
		$is_single = false;

		if(!$edit_field) {
			if (is_array($field_settings['options'])) {
				if (count($field_settings['options']) == 1) {
					$is_single = true;
				}
				$ids = implode("|", $field_settings['options']);
			}
			else {
				$is_single = true;
				$ids = $field_settings['options'];
			}
			
			$people = array();
			$sql = '	SELECT member_id, screen_name, username, occupation, '.$this->db_prefix.'_members.group_id, group_title
						FROM '.$this->db_prefix.'_members';
			$sql .= ' 	JOIN '.$this->db_prefix.'_member_groups';
			$sql .= '	ON ('.$this->db_prefix.'_members.group_id = '.$this->db_prefix.'_member_groups.group_id) ';
			$sql .= '	WHERE '.$this->db_prefix.'_members.member_id ';
			$sql .= $FNS->sql_andor_string($ids, 'group_id', $this->db_prefix.'_members');
			$sql .= '	ORDER BY '.$this->db_prefix.'_members.group_id, screen_name ASC ';
			
			$query = $DB->query($sql);
			
			$field	= $DSP->input_select_header($field_name);
			$field .= $DSP->input_select_option('', '--');
			
			$current_group_id = 0;
			foreach($query->result as $row) {
				if (!$is_single) {
					if (!$current_group_id) {
						$field	.= $this->_optgroup_header($row['group_title']);
						$current_group_id = $row['group_id'];
					}
					elseif ($current_group_id != $row['group_id']) {
						$field .= $this->_optgroup_footer();
						$field	.= $this->_optgroup_header($row['group_title']);
						$current_group_id = $row['group_id'];
					}
				}
				$field .= $DSP->input_select_option($row['member_id'], $row['screen_name'], $field_data == $row['member_id']);
			}
			$field .= $DSP->input_select_footer();
		}
		else {
			$field	= $DSP->input_select_header($field_name);
			$field .= $DSP->input_select_option('', '--');
			$field .= $DSP->input_select_option('', $LANG->line('sample_member_content'));
			$field .= $DSP->input_select_footer();
		}
		return $field;
	}

	/**
	 * Builds multi-select for member group list in settings
	 *
	 * @param  array  $field_settings  The field's settings
	 * @return array  Settings HTML
	 */
	function _multiselect_member_group($current_option) {
		global $PREFS, $DB, $DSP;
		
		$SD = new Fieldframe_SettingsDisplay();
		$query = $DB->query("	SELECT group_id, group_title
								FROM ".$this->db_prefix."_member_groups
								WHERE site_id = ".$PREFS->ini('site_id')."
								ORDER BY group_id ASC");
		$member_group = array();
		foreach($query->result as $row) {
			$member_group[$row['group_id']] = $row['group_title'];
		}
					
		$block  = '<div class="itemWrapper">';
		$block .= $SD->multiselect('options[]', $current_option, $member_group, array('width' => '75%;'));
		$block .= '</div>';				
		return $block;
	}

	/**
	 * Builds select for member group list in settings: Deprecated
	 *
	 * @param  array  $field_settings  The field's settings
	 * @return array  Settings HTML
	 */
	function _select_member_group($current_option) {
		global $DB, $PREFS, $DSP;
		
		$block  = '<div class="itemWrapper">';
		$block .= $DSP->input_select_header('options');		
		$query = $DB->query("	SELECT group_id, group_title
								FROM ".$this->db_prefix."_member_groups
								WHERE site_id = ".$PREFS->ini('site_id')."
								ORDER BY group_id ASC");
		foreach($query->result as $row) {
			$selected = 0;
			if ($row['group_id'] == $current_option) {
				$selected = 1;
			}
			$block .= $DSP->input_select_option($row['group_id'], $row['group_title'], $selected);
		}
		$block .= $DSP->input_select_footer();
		$block .= '</div>';
		return $block;
	}
}
?>