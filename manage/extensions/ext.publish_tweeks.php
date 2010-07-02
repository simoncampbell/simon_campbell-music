<?php

//ini_set('display_errors', true);

class Publish_tweeks {

var $settings       = array();
var $name           = 'Publish Tweeks';
var $class_name		= 'publish_tweeks';
var $version        = '0.8';
var $description    = 'Alters the publish/edit page to streamline it for your users';
var $settings_exist = 'y';
var $docs_url       = '';

/**
 * Constructor
 */
function Publish_tweeks($settings = '') {
		global $SESS;

		if(isset($SESS->cache['ngen']) === FALSE){ $SESS->cache['ngen'] = array(); }

		$this->settings = $this->_get_settings();
}

/**
 * Register hooks by adding them to the database
 */
function activate_extension() {
    global $DB;

    $hooks[] = array(
		'extension_id' => '',
		'class'        => __CLASS__,
		'method'       => 'pt_init',
		'hook'         => 'show_full_control_panel_end',
		'settings'     => '',
		'priority'     => 1,
		'version'      => $this->version,
		'enabled'      => 'y'
	);
	$hooks[] = array(
		'extension_id' => '',
		'class'        => __CLASS__,
		'method'       => 'submit_redirect',
		'hook'         => 'submit_new_entry_absolute_end',
		'settings'     => '',
		'priority'     => 50,
		'version'      => $this->version,
		'enabled'      => 'y'
	);

	// LG Addon Updater
	$hooks[] = array(
		'extension_id' => '',
		'class'        => __CLASS__,
		'method'       => 'register_my_addon_source',
		'hook'         => 'lg_addon_update_register_source',
		'settings'     => '',
		'priority'     => 50,
		'version'      => $this->version,
		'enabled'      => 'y'
	);

	$hooks[] = array(
		'extension_id' => '',
		'class'        => __CLASS__,
		'method'       => 'register_my_addon_id',
		'hook'         => 'lg_addon_update_register_addon',
		'settings'     => '',
		'priority'     => 50,
		'version'      => $this->version,
		'enabled'      => 'y'
	);

  foreach ($hooks as $hook) {
  	$DB->query($DB->insert_string('exp_extensions',	$hook));
	}
}

/**
 * No updates yet.
 * Manual says this function is required.
 * @param string $current currently installed version
 */
function update_extension($current = '') {}

/**
 * Uninstalls extension
 */
function disable_extension() {
    global $DB;
    $DB->query("DELETE FROM exp_extensions WHERE class = 'Publish_tweeks'");
}



/* ***********************  Hook functions  ***********************************/


function pt_init($html) {
	global $EXT, $IN;

	if($EXT->last_call !== false) {
	  $html = $EXT->last_call;
	}

	$C = $IN->GBL('C');
	$M = $IN->GBL('M');

	$classes = array(
		'publish',
		'edit'
	);

	$methods = array(
		'edit_entry',
		'entry_form',
		'new_entry'
	);

	// if this is not an entry form return
	if ( ! (in_array($C, $classes) && in_array($M, $methods))) {
		return $html;
	}

	$html = $this->change_submit_buttons($html, $C, $M);
	$html = $this->add_message($html, $C, $M);

	return $html;
}


function change_submit_buttons($html, $C, $M) {
	global $LANG;
	
	$LANG->fetch_language_file('publish_tweeks');

	// set button text value
	//$value = $C === 'publish' ? 'Submit' : 'Update';
	$value = ($C === 'publish') ? $LANG->line('save_button') : $LANG->line('update_button');

	$new = 'div class="submitBox">
		<input class="submit" type="submit" value="' . $value . '" name="submit" /></div>';

	$find = "#div class='submitBox'.+?</div>#is";

    $html = preg_replace($find, $new, $html);

    // Remove upload box?
    if( isset( $this->settings['other_settings_remove_upload_box'] ) AND ( $this->settings['other_settings_remove_upload_box'] === 'y' ) )
    {
        $new = '';
        $find = "#<div class='uploadBox'.+?</div>#is";
        $html = preg_replace($find, $new, $html);
    }

	return $html;
}


function add_message($html, $C, $M) {
	global $DSP, $SESS;

	@session_start();
	if( isset($_SESSION['publish_tweeks_submit_msg']) ) {
		$sdata = $_SESSION['publish_tweeks_submit_msg'];
	} else {
		$sdata = '';
	}

	if ($sdata != '') {
		// build message html
		//$msg = $DSP->qdiv('success', $sdata);
		$msg = "<div id='message-publish-tweeks' style='background-color: #fffac3; color: #333; font-size: 110%; font-weight: bold; margin-bottom: 10px; padding: 12px 15px;'>$sdata</div>\n";

		// add message to page html
		$find = "#div id='contentNB'\>#";
		$new  = 'div id="contentNB">' . $msg;
		$html = preg_replace($find, $new, $html);

		// delete message so it does not show again
		$_SESSION['publish_tweeks_submit_msg'] = '';
	}

	return $html;
}


function submit_redirect($entry_id, $data) {
	global $IN, $LANG, $SESS;
	
	$LANG->fetch_language_file('publish_tweeks');

	// redirect back to edit page if from control panel
	// Checks ACT post value to detect SAEF and ignore redirect
	if( !$IN->GBL('ACT', 'POST') ) {
		// set submit message in session data
		@session_start();
		$_SESSION['publish_tweeks_submit_msg'] = $LANG->line('saved_message');

		// create edit url and redirect
		$url  = BASE . '&C=edit&M=edit_entry&weblog_id=' . $data['weblog_id'];
		$url .= '&entry_id=' . $entry_id;
		header('Location: ' . $url);
		die;
	}
}

/**
* Get the site specific settings from the extensions table
*
* @param $force_refresh		bool	Get the settings from the DB even if they are in the $SESS global
* @param $return_all		bool	Return the full array of settings for the installation rather than just this site
* @return array 					If settings are found otherwise false. Site settings are returned by default. Installation settings can be returned is $return_all is set to true
* @since version 1.0.0
*/
function _get_settings($force_refresh = FALSE, $return_all = FALSE)
{

	global $SESS, $DB, $REGX, $LANG, $PREFS;

	// assume there are no settings
	$settings = FALSE;

	// Get the settings for the extension
	if(isset($SESS->cache['ngen'][$this->name]['settings']) === FALSE || $force_refresh === TRUE)
	{
		// check the db for extension settings
		$query = $DB->query("SELECT settings FROM exp_extensions WHERE enabled = 'y' AND class = '" . get_class($this) . "' LIMIT 1");

		// if there is a row and the row has settings
		if ($query->num_rows > 0 && $query->row['settings'] != '')
		{
			// save them to the cache
			$SESS->cache['ngen'][$this->name]['settings'] = $REGX->array_stripslashes(unserialize($query->row['settings']));
		}
	}
	// check to see if the session has been set
	// if it has return the session
	// if not return false
	if(empty($SESS->cache['ngen'][$this->name]['settings']) !== TRUE)
	{
		$settings = ($return_all === TRUE) ?  $SESS->cache['ngen'][$this->name]['settings'] : $SESS->cache['ngen'][$this->name]['settings'][$PREFS->ini('site_id')];
	}

	return $settings;
}

/**
 * Settings Form
 *
 * Construct the custom settings form.
 *
 * Look and feel based on LG Addon Updater's settings form.
 *
 * @param  array   $current   Current extension settings (not site-specific)
 * @see    http://expressionengine.com/docs/development/extensions.html#settings
 * @author Leevi Graham <http://leevigraham.com>
 * @since  version 1.0.0
 */
function settings_form($current)
{
    global $DB, $DSP, $LANG, $IN, $PREFS;

    $current = $this->_get_settings();

    // Form Header

    $DSP->crumbline = TRUE;

    $DSP->title  = $LANG->line('extension_settings');
    $DSP->crumb  = $DSP->anchor(BASE.AMP.'C=admin'.AMP.'area=utilities', $LANG->line('utilities')).
                               $DSP->crumb_item($DSP->anchor(BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager', $LANG->line('extensions_manager')));
    $DSP->crumb .= $DSP->crumb_item($this->name);

    $DSP->right_crumb($LANG->line('disable_extension'), BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=toggle_extension_confirm'.AMP.'which=disable'.AMP.'name='.$IN->GBL('name'));

    $DSP->body = '';

    //$DSP->body .= "<h1>{$this->name} <small>{$this->version}</small></h1>";
		$DSP->body .= $DSP->heading("{$this->name} <small>{$this->version}</small>");

    $DSP->body .= $DSP->form_open(
                                array(
                                        'action' => 'C=admin'.AMP.'M=utilities'.AMP.'P=save_extension_settings',
																				'name' => 'settings_publish_tweeks',
																				'id' => 'settings_publish_tweeks'
																),
                                array('name' => 'publish_tweeks')
                            );

	$DSP->body .= $DSP->table_open(
	                                   array(
	                                       'class'  => 'tableBorder',
	                                       'border' => '0',
	                                       'style' => 'margin-top:18px; width:100%'
	                                   )
	                               );

	$DSP->body .= $DSP->tr()
	            . $DSP->td('tableHeading', '', '2')
	            . $LANG->line("check_for_extension_updates_title")
	            . $DSP->td_c()
	            . $DSP->tr_c();

	$DSP->body .= $DSP->tr()
	            . $DSP->td('', '', '2')
	            . '<div class="box" style="border-width:0 0 1px 0; margin:0; padding:10px 5px"><p>'.$LANG->line('check_for_extension_updates_info').'</p></div>'
	            . $DSP->td_c()
	            . $DSP->tr_c();

	$DSP->body .= $DSP->tr()
	            . $DSP->td('tableCellOne', '60%')
	            . $DSP->qdiv('defaultBold', $LANG->line("check_for_extension_updates_label"))
	            . $DSP->td_c();

	$DSP->body .= $DSP->td('tableCellOne')
	            . '<select name="check_for_extension_updates">'
	            . $DSP->input_select_option('y', $LANG->line('yes'), ($current['check_for_extension_updates'] == 'y' ? 'y' : ''))
	            . $DSP->input_select_option('n', $LANG->line('no'),  ($current['check_for_extension_updates'] != 'y' ? 'y' : ''))
	            . $DSP->input_select_footer()
	            . $DSP->td_c()
	            . $DSP->tr_c();

	$DSP->body .= $DSP->table_c();

    // Other Settings

    $DSP->body .= $DSP->table_open(
                                       array(
                                           'class'  => 'tableBorder',
                                           'border' => '0',
                                           'style' => 'margin-top:18px; width:100%'
                                       )
                                   );

    $DSP->body .= $DSP->tr()
                . $DSP->td('tableHeading', '', '2')
                . $LANG->line("other_settings_title")
                . $DSP->td_c()
                . $DSP->tr_c();

    $DSP->body .= $DSP->tr()
                . $DSP->td('tableCellOne', '60%')
                . $DSP->qdiv('defaultBold', $LANG->line("other_settings_remove_upload_box_label"))
                . $DSP->td_c();

    $DSP->body .= $DSP->td('tableCellOne')
                . '<select name="other_settings_remove_upload_box">'
                . $DSP->input_select_option('y', $LANG->line('yes'), ($current['other_settings_remove_upload_box'] == 'y' ? 'y' : ''))
                . $DSP->input_select_option('n', $LANG->line('no'),  ($current['other_settings_remove_upload_box'] != 'y' ? 'y' : ''))
                . $DSP->input_select_footer()
                . $DSP->td_c()
                . $DSP->tr_c();

    $DSP->body .= $DSP->table_c();

    // Close Form

    $DSP->body .= $DSP->qdiv('itemWrapperTop', $DSP->input_submit())
				. $DSP->form_c();
}


/**
* Save Settings
*
* @since version 1.0.0
**/
function save_settings()
{
	// make somethings global
	global $DB, $IN, $PREFS, $REGX, $SESS;

	$default_settings = array();

	// merge the defaults with our $_POST vars
	$_POST = array_merge($default_settings, $_POST);

	// unset the name
	unset($_POST['name']);

	// load the settings from cache or DB
	// force a refresh and return the full site settings
	$settings = $this->_get_settings(TRUE, TRUE);

	// add the posted values to the settings
	$settings[$PREFS->ini('site_id')] = $_POST;

	// update the settings
	$query = $DB->query($sql = "UPDATE exp_extensions SET settings = '" . addslashes(serialize($settings)) . "' WHERE class = '" . get_class($this) . "'");
}

/**
 * Register a New Addon Source
 *
 * @param  array   $sources   The existing sources
 * @return array              The new source list
 * @see    http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/
 * @author Leevi Graham <http://leevigraham.com>
 * @since  version 1.0.0
 */
function register_my_addon_source($sources)
{
	global $EXT;

    // Check if we're not the only one using this hook
    if($EXT->last_call !== FALSE)
        $sources = $EXT->last_call;

    // add a new source
    // must be in the following format:
    /*
    <versions>
        <addon id='LG Addon Updater' version='2.0.0' last_updated="1218852797" docs_url="http://leevigraham.com/" />
    </versions>
    */
    if(( ! isset($this->settings['check_for_extension_updates'])) OR $this->settings['check_for_extension_updates'] == 'y')
    {
        $sources[] = 'http://www.ngenworks.com/software/version-check/versions.xml';
    }
    return $sources;

}



/**
 * Register a New Addon
 *
 * @param  array   $addons   The existing sources
 * @return array             The new addon list
 * @see    http://leevigraham.com/cms-customisation/expressionengine/lg-addon-updater/
 * @author Leevi Graham <http://leevigraham.com>
 * @since  version 1.0.0
 */
function register_my_addon_id($addons)
{
	global $EXT;

    // Check if we're not the only one using this hook
    if($EXT->last_call !== FALSE)
        $addons = $EXT->last_call;

    // add a new addon
    // the key must match the id attribute in the source xml
    // the value must be the addons current version
    if(( ! isset($this->settings['check_for_extension_updates'])) OR $this->settings['check_for_extension_updates'] == 'y')
    {
        $addons[$this->name] = $this->version;
    }
    return $addons;
}


}