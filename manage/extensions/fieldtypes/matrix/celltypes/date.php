<?php if (! defined('EXT')) exit('Invalid file request');


/**
 * Date Celltype Class for EE1
 * 
 * @package   Matrix
 * @author    Brandon Kelly <brandon@pixelandtonic.com>
 * @copyright Copyright (c) 2010 Pixel & Tonic, LLC
 */
class Matrix_date extends Fieldframe_Fieldtype {

	var $info = array(
		'name' => 'Date',
		'no_lang' => TRUE
	);

	// --------------------------------------------------------------------

	/**
	 * Display Cell
	 */
	function display_cell($cell_name, $cell_data, $cell_settings)
	{
		global $FFM, $LOC;

		if (! isset($this->displayed))
		{
			// include matrix_text.js
			$this->insert('body', '<script type="text/javascript" src="'.$FFM->_theme_url.'scripts/matrix_date.js" charset="utf-8"></script>');
			$this->insert('head', '<style type="text/css" charset="utf-8">'.NL.'.ui-widget-content { background: #fff; }'.NL.'</style>');

			$this->displayed = TRUE;
		}

		$r['class'] = 'matrix-date matrix-text';

		// pass the default date to the JS
		$r['settings']['defaultDate'] = ($cell_data ? $LOC->set_localized_time($cell_data) : $LOC->set_localized_time()) * 1000;

		// get the initial input value
		$formatted_date = $cell_data ? $LOC->set_human_time($cell_data) : '';

		$r['data'] = '<input type="text" class="matrix-textarea" name="'.$cell_name.'" value="'.$formatted_date.'" />';

		return $r;
	}

	// --------------------------------------------------------------------

	/**
	 * Save Cell
	 */
	function save_cell($cell_data, $cell_settings, $entry_id)
	{
		global $LOC;

		// convert the formatted date to a Unix timestamp
		return $LOC->convert_human_date_to_gmt($cell_data);
	}

	// --------------------------------------------------------------------

	/**
	 * Display Tag
	 */
	function display_tag($params, $tagdata, $field_data, $field_settings)
	{
		global $LOC;

		if (! $field_data) return '';

		if (isset($params['format']))
		{
			$field_data = $LOC->decode_date($params['format'], $field_data);
		}
		else
		{
			$field_data = $LOC->set_human_time($field_data);
		}

		return $field_data;
	}

}
