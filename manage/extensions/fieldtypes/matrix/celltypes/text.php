<?php if (! defined('EXT')) exit('Invalid file request');


/**
 * Text Celltype Class for EE1
 * 
 * @package   Matrix
 * @author    Brandon Kelly <brandon@pixelandtonic.com>
 * @copyright Copyright (c) 2010 Pixel & Tonic, LLC
 */
class Matrix_text extends Fieldframe_Fieldtype {

	var $info = array(
		'name' => 'Text',
		'no_lang' => TRUE
	);

	var $default_cell_settings = array(
		'maxl' => '',
		'multiline' => 'n'
	);

	// --------------------------------------------------------------------

	/**
	 * Display Cell Settings
	 */
	function display_cell_settings($cell_settings)
	{
		global $LANG;

		return array(
			array($LANG->line('maxl'), '<input type="text" class="matrix-textarea" name="maxl" value="'.$cell_settings['maxl'].'" />'),
			array($LANG->line('multiline'), '<input type="checkbox" name="multiline" value="y"'.($cell_settings['multiline'] == 'y' ? ' checked="checked"' : '').' />')
		);
	}

	// --------------------------------------------------------------------

	/**
	 * Display Cell
	 */
	function display_cell($cell_name, $cell_data, $cell_settings)
	{
		global $FFM;

		if (! isset($this->displayed))
		{
			// include matrix_text.js
			$this->insert('body', '<script type="text/javascript" src="'.$FFM->_theme_url.'scripts/matrix_text.js" charset="utf-8"></script>');

			$this->displayed = TRUE;
		}

		$r['class'] = 'matrix-text';
		$r['data'] = '<textarea class="matrix-textarea" name="'.$cell_name.'" rows="1">'.$cell_data.'</textarea>';

		if (isset($cell_settings['maxl']) && $cell_settings['maxl'])
		{
			$chars_left = $cell_settings['maxl'] - strlen($cell_data);
			$r['data'] .= '<div><div>'.$chars_left.'</div></div>';
		}

		return $r;
	}

}
