<?php
/**
* Plugin File for LG Better Meta
*
* This file must be placed in the
* /system/plugins/ folder in your ExpressionEngine installation.
* 
* @package LgBetterMeta
* @version 1.9.1
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement
*/


if ( ! defined('LG_BM_version')){
	define("LG_BM_version",			"1.9.1");
	define("LG_BM_docs_url",		"http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/");
	define("LG_BM_addon_id",		"LG Better Meta Commercial");
	define("LG_BM_extension_class",	"Lg_better_meta");
	define("LG_BM_cache_name",		"lg_cache");
}


/**
* Plugin information used by ExpressionEngine
* @global array $plugin_info
*/
$plugin_info = array(
	'pi_name' 			=> 'LG Better Meta',
	'pi_version' 		=> LG_BM_version,
	'pi_author' 		=> 'Leevi Graham',
	'pi_author_url' 	=> 'http://leevigraham.com/',
	'pi_description'	=> 'Renders entry meta information to your templates.',
	'pi_usage' 			=> 'For usage visit: http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/'
);



/**
* Converts ExpressionEngine template tags into meta tags based on a weblog
* entries meta information.
* 
* @package LgBetterMeta
* @version 1.9.1
* @author Leevi Graham <http://leevigraham.com>
* @see http://leevigraham.com/cms-customisation/expressionengine/addon/lg-better-meta/
* @copyright Copyright (c) 2007-2009 Leevi Graham
* @license http://leevigraham.com/cms-customisation/commercial-license-agreement
*/
class Lg_better_meta_pl{

	/**
	 * Returned string
	 * @var array
	 */
	var $return_data = "";

	/**
	 * Plugin version
	 * @var array
	 */
	var $version = "1.9.1";


	/**
	 * PHP4 Constructor
	 *
	 * @see __construct()
	 */
	function Lg_better_meta_pl()
	{
		$this->__construct();
	}

	/**
	 * PHP 5 Constructor
	 *
	 * @param	array|string $settings Extension settings associative array or an empty string
	 * @since	Version 1.7.0
	 */
	function __construct()
	{
		if ( ! class_exists('Lg_better_meta'))
		{
			include(PATH_EXT. 'ext.lg_better_meta.php');
		}
		$LGBM = new Lg_better_meta;
		$this->settings = $LGBM->settings;
	}

	/**
	 * Outputs a weblog entries meta information to your template through the {exp:lg_better_meta} tag.
	 *
	 * @return	string Meta template in html with values
	 */
	function template()
	{
		global $DB, $TMPL, $PREFS, $FNS, $LANG, $LOC, $OUT, $REGX, $SESS;

		if(is_object($TMPL) === FALSE) return;

		$settings = $this->settings;

    // the valid params for the tag
    $valid_params = array(
        'entry_id',
        'weblog_id',
        'url_title',
        'title',
        'title_suffix',
        'title_prefix',
        'hide_site_title',
        'description',
        'keywords',
        'author',
        'publisher',
        'rights',
        'date_created',
        'date_modified',
        'date_valid',
        'identifier',
        'robots_index',
        'robots_follow',
        'robots_archive',
        'canonical_url',
        'region',
        'placename',
        'latitude',
        'longitude'
    );

    // for each of the embedded params
    foreach ($TMPL->embed_vars as $key => $value)
    {
        // parse the param key
        $real_key = substr($key, 6);
        if(
            // is the tag param actually set?
            isset($TMPL->tagparams[$real_key]) === FALSE
            // is the embbed param in the valid params array?
            && in_array($real_key, $valid_params)
        )
        {
            // add the embed param to the tag param
            $TMPL->tagparams[$real_key] = $value;
        }
    }

		if(empty($TMPL->tagparams) === FALSE)
		{
			// clear the deadwood before we get excited
			// for each of the passed params
			foreach ($TMPL->tagparams as $key => $value)
			{
				// if its an {embed}
				if(preg_match('/(^\{embed:)|(^\s*$)/', $value))
				{
					// set the value to false
					unset($TMPL->tagparams[$key]);
				}
			}
		}
		else
		{
			$TMPL->tagparams = array();
		}

		$site_id = $TMPL->fetch_param('site_id') ? $TMPL->fetch_param('site_id') : $PREFS->ini('site_id');

		// the very basics
		// this is nearly everyone of our meta values in their weakest form
		$params = array(
			'entry_id'			=> $TMPL->fetch_param('entry_id'),
			'url_title'			=> $TMPL->fetch_param('url_title'),
			'weblog_id'			=> $TMPL->fetch_param('weblog_id'),
			'title'				=> FALSE,
			'site_title'		=> $settings['title'],
			'title_prefix'		=> $TMPL->fetch_param('title_prefix'),
			'title_suffix'		=> $TMPL->fetch_param('title_suffix'),
			'hide_site_title' 	=> 'n',
			'description' 		=> $settings['description'],
			'keywords'			=> $settings['keywords'],
			'author'			=> $settings['author'],
			'publisher'			=> $settings['publisher'],
			'rights'			=> $settings['rights'],
			'date_created'		=> $LOC->now,
			'date_modified' 	=> $LOC->now,
			'date_valid'		=> $LOC->now + 525600,
			'identifier'		=> $FNS->fetch_current_uri(),
			'robots_index'		=> $settings['robots_index'],
			'robots_follow' 	=> $settings['robots_follow'],
			'robots_archive'	=> $settings['robots_archive'],
			'template'			=> (empty($TMPL->tagdata) === TRUE) ? $settings['template'] : $TMPL->tagdata,
			'divider'			=> $settings['divider'],
			'include_in_sitemap'=> 'y',
			'priority'			=> FALSE,
			'change_frequency'	=> FALSE,
			'canonical_url'		=> $TMPL->fetch_param('canonical_url'),
			'region'			=> $settings['region'],
			'placename'		 	=> $settings['placename'],
			'latitude'			=> $settings['latitude'],
			'longitude'			=> $settings['longitude'],

			// for the entry specific data w/ no defaults
			'entry_title'				=> FALSE,
			'entry_url_title'			=> FALSE,
			'entry_meta_title'			=> FALSE,
			'entry_description'			=> FALSE,
			'entry_keywords'			=> FALSE,
			'entry_publisher'			=> FALSE,
			'entry_meta_author'			=> FALSE,
			'entry_rights'				=> FALSE,
			'entry_robots_index'		=> FALSE,
			'entry_robots_follow'		=> FALSE,
			'entry_robots_archive'		=> FALSE,
			'entry_include_in_sitemap'	=> FALSE,
			'entry_change_frequency'	=> FALSE,
			'entry_priority'			=> FALSE,
			'entry_canonical_url'		=> FALSE,
			'entry_region'				=> FALSE,
			'entry_placename'			=> FALSE,
			'entry_latitude'			=> FALSE,
			'entry_longitude'			=> FALSE,
		);

		$entry_params = array();

		// now we are going to try and override them with values entered by the user
		// and or values derived from the entry
		// Create the WHERE clause
		// if there is an entry_id or url_title param
		if($params['entry_id'] !== FALSE || $params['url_title'] !== FALSE )
		{
			// if an entry_id has been provided
			if($params['entry_id'] !== FALSE)
			{
				$where = " WHERE exp_weblog_titles.entry_id = '" . $params['entry_id'] . "' ";
			} 
			// if a url_title has been provided
			elseif($params['url_title'] !== FALSE)
			{
				$where = " WHERE exp_weblog_titles.url_title = '" . $params['url_title'] ."' ";

				// if a weblog_id has been provided
				if($params['weblog_id'] !== FALSE)
				{
					$where .= " AND exp_weblog_titles.weblog_id = '" . $params['weblog_id'] ."' ";
				}
			}

			$where .= " AND `exp_weblog_titles`.`site_id` = " . $site_id;

			// Query the db to get the entry and better meta details
			$query = $DB->query("
				SELECT
					exp_members.screen_name						as author,
					exp_weblog_titles.entry_id					as entry_id,
					exp_weblog_titles.weblog_id					as weblog_id,
					exp_weblog_titles.title						as title,
					exp_weblog_titles.url_title					as url_title,
					exp_weblog_titles.entry_date				as date_created,
					exp_weblog_titles.edit_date					as date_modified,
					exp_weblog_titles.expiration_date			as date_valid,
					exp_weblog_titles.author_id					as author_id,
					exp_weblog_titles.day						as day,
					exp_weblog_titles.month						as month,
					exp_weblog_titles.year						as year,
					exp_lg_better_meta.title					as meta_title,
					exp_lg_better_meta.description				as description,
					exp_lg_better_meta.keywords					as keywords,
					exp_lg_better_meta.publisher				as publisher,
					exp_lg_better_meta.author					as meta_author,
					exp_lg_better_meta.rights					as rights,
					exp_lg_better_meta.index					as robots_index,
					exp_lg_better_meta.follow					as robots_follow,
					exp_lg_better_meta.archive					as robots_archive,
					exp_lg_better_meta.include_in_sitemap		as include_in_sitemap,
					exp_lg_better_meta.change_frequency			as change_frequency,
					exp_lg_better_meta.priority					as priority,
					exp_lg_better_meta.canonical_url			as canonical_url,
					exp_lg_better_meta.region					as region,
					exp_lg_better_meta.placename				as placename,
					exp_lg_better_meta.latitude					as latitude,
					exp_lg_better_meta.longitude				as longitude,
					exp_lg_better_meta.append_default_keywords	as append_default_keywords
				FROM
					exp_weblog_titles
				INNER JOIN 
					exp_members ON exp_weblog_titles.author_id = exp_members.member_id
				LEFT JOIN
					exp_lg_better_meta ON exp_weblog_titles.entry_id = exp_lg_better_meta.entry_id
				" . $where . "
				LIMIT 1
			");

			// if there is a result
			if ($query->num_rows > 0)
			{
				// the entry params will override the basic params
				$entry_params = array_merge($query->row, array(
					'title' => (empty($query->row['meta_title']) === FALSE) ? $query->row['meta_title'] : $query->row['title'],
					'description' => $this->_encode($query->row['description']),
					'keywords' => $this->_encode($query->row['keywords']),
					'author' => (empty($query->row['meta_author']) === FALSE) ? $query->row['meta_author'] : $query->row['author'],
				));
				
				// loop through each of the entry params
				// and remove any empties
				foreach ($entry_params as $key => $value)
				{
					if(empty($value) === TRUE)
					{
						unset($entry_params[$key]);
					}
				}

				// store entry-specific parameters; e.g. entry_description - mainly for conditionals... so that templates can go {if entry_description}
				foreach ($entry_params as $key => $value)
				{
					$entry_params['entry_' . $key] = $value;
				}

				if(isset($entry_params['include_in_sitemap']) === FALSE)
				{
					$entry_params['include_in_sitemap'] = $settings['weblogs'][$query->row['weblog_id']]['include_in_sitemap'];
				}

				if(isset($entry_params['change_frequency']) === FALSE)
				{
					$entry_params['change_frequency'] = $settings['weblogs'][$query->row['weblog_id']]['change_frequency'];
				}

				if(isset($entry_params['priority']) === FALSE)
				{
					$entry_params['priority'] = $settings['weblogs'][$query->row['weblog_id']]['priority'];
				}

				if($entry_params['date_modified'] != "")
				{
					$entry_params['date_modified'] = $LOC->timestamp_to_gmt($entry_params['date_modified']);
				}
				
				if(isset($entry_params['append_default_keywords']) && isset($entry_params['keywords']))
				{
					$entry_params['keywords'] .= ", " . $params['keywords'];
				}
			}
		}

		$params = array_merge($params, $entry_params, $TMPL->tagparams);

		// find out what the divider character is
		switch ($params['divider'])
		{
			case "0":
				$params['divider'] = " - ";
				break;
			case "1":
				$params['divider'] = " | ";
				break;
			case "2" :
				$params['divider'] = " » ";
				break;
			case "3":
				$params['divider'] = " . ";
				break;
			case "4":
				$params['divider'] = " → ";
				break;
		}

		// change our robots value
		$params['robots_index'] = ($params['robots_index'] == 'y') ? 'index' : 'noindex';
		$params['robots_follow'] = ($params['robots_follow'] == 'y') ? 'follow' : 'nofollow';
		$params['robots_archive'] = ($params['robots_archive'] == 'y') ? 'archive' : 'noarchive';
		$params['robots'] = $params['robots_index'] . "," . $params['robots_follow'] . "," . $params['robots_archive']; 

		// date trickery
		$params['date_created']   = ($params['date_created'] != 0) ? date("Y-m-d\TH:i:sO", $params['date_created']) : '';
		$params['date_modified']  = ($params['date_modified'] != 0) ? date("Y-m-d\TH:i:sO", $params['date_modified']) : '';
		$params['date_valid']     = ($params['date_valid'] != 0) ? date("Y-m-d\TH:i:sO", $params['date_valid']) : '';

		// page title
		if(empty($params['title_prefix']) === FALSE)
		{
			$params['title_prefix'] .= $params['divider'];
		}

		if(empty($params['title_suffix']) === FALSE)
		{
			$params['title_suffix'] = $params['divider'] . $params['title_suffix'];
		}

		$params['site_title'] = ($params['hide_site_title'] == 'yes' || $params['hide_site_title'] == 'y') ? '' : $params['site_title'];
		
		if($params['title'] != '' && $params['site_title'] != '' )
		{
			$params['site_title'] = $params['divider'] . $params['site_title'];
		}
		
		$params['title'] = $this->_encode(str_replace("|", $params['divider'], $params['title_prefix'] . $params['title'] . $params['title_suffix'] . $params['site_title']));
		
		$params['description'] = $this->_encode($params['description']);

		$params['entry_title'] = $this->_encode($params['entry_title']);
		$params['entry_description'] = $this->_encode($params['entry_description']);

		// Canonical URLS
		foreach ($params as $key => $value)
		{
			if(strpos($params["canonical_url"], LD.$key.RD) !== FALSE)
			{
				$params["canonical_url"] = str_replace(LD.$key.RD, $value, $params["canonical_url"]);
			}
		}

		// Replace variables in template
		foreach ($params as $key => $value)
		{
			if(strpos($params['template'], LD.$key.RD) !== FALSE)
			{
				$params['template'] = str_replace(LD.$key.RD, $value, $params['template']);
			}
		}

		// prep conditionals
		$params['template'] = $FNS->prep_conditionals($params['template'], $params);

		// return the template
		return $params['template'];
	}

	/**
	 * Mirrors the weblog:entries tag but is a little modified to include the meta variables.
	 * 
	 * @return string Returns the template tag data with all our tags replaced
	 **/
	function entries()
	{
		global $TMPL;

		$W = $this->_get_entries_with_meta();

		// is the Typography class loaded?
		// The Weblog class needs this
		if ( ! class_exists('Typography'))
		{
			// No, require it
			require PATH_CORE.'core.typography'.EXT;
		}
		// Creata a new Typography object
		$W->TYPE = new Typography;   
		// Just set a settng
		$W->TYPE->convert_curly = FALSE;

		// run the weblog entry parser
		$W->parse_weblog_entries();

		// return the tag data
		return $W->return_data;
    }

	/**
	 * Builds a concatenated string of <url> sitemap elements.
	 * 
	 * @return string Returns a concatenated string of <url> elements.
	 **/
	function entries_xml()
	{
		global $FNS, $LOC, $PREFS, $TMPL;

		// Make a couple of suggestions
		$TMPL->tagparams["disable"] = $TMPL->fetch_param('disable') ? $TMPL->fetch_param('disable') : "categories|custom_fields|category_fields|member_data|pagination|trackbacks";
		$TMPL->tagparams["dynamic"] = $TMPL->fetch_param('dynamic') ? $TMPL->fetch_param('dynamic') : "off";
		$TMPL->tagparams["rdf"] = $TMPL->fetch_param('rdf') ? $TMPL->fetch_param('rdf') : "off";
		$TMPL->tagparams["limit"] = $TMPL->fetch_param('limit') ? $TMPL->fetch_param('limit') : "500";

		$use_page_url 	= $TMPL->fetch_param('use_page_url') ? $TMPL->fetch_param('use_page_url') : "yes";
		$loc 			= $TMPL->fetch_param('loc') ? $TMPL->fetch_param('loc') : FALSE;

		// get any entries that match template params
		// return if none found
		if(($W = $this->_get_entries_with_meta()) === FALSE || $loc === FALSE) return FALSE;

		// prepare string
		$r = "";
		// get the string for the entry location before replacements

		// these are the variables we are going to try and replace
		$search = array("{url_title}", "{entry_id}", "{weblog_id}", "{site_id}");

		$pages = $PREFS->ini('site_pages');
		if($PREFS->ini("app_version") > 168) 
			$pages = $pages[$PREFS->ini("site_id")];

		// loop over the results
		foreach ($W->query->result as $key => $entry)
		{
			if(
				$use_page_url == "yes"
				&& isset($pages['uris'][$entry['entry_id']]) === TRUE)
			{
				$entry_loc = $FNS->create_url($pages['uris'][$entry['entry_id']]);
			}
			else
			{
				// replace the variables
				$entry_loc = str_replace($search, array($entry['url_title'], $entry['entry_id'], $entry['weblog_id']), $loc);
			}
			// build the string
			$r .= "<url>";
			$r .= "<loc>".$entry_loc."</loc>";
			$r .= "<lastmod>".date('Y-m-d', $LOC->timestamp_to_gmt($entry['edit_date']))."</lastmod>";
			$r .= "<changefreq>".$entry["change_frequency"]."</changefreq>";
			$r .= "<priority>".$entry["priority"]."</priority>";
			$r .= "</url>\n";
		}
		return $r;
	}

	/**
	 * Gets the entries using the Weblog class
	 *
	 * @return mixed FALSE if no results are found otherwise the Weblog object populated with the query results
	 **/
	function _get_entries_with_meta()
	{
		global $DB, $TMPL, $LOC, $PREFS, $EXT, $SESS;

		// if no weblog class exists
		if(!class_exists('Weblog'))
		{
			// require the file
			require PATH_MOD.'weblog/mod.weblog'.EXT;
		}
		// create a new weblog object
		$W = new Weblog;
		// initialise it
		$W->initialize();

		if ($W->enable['custom_fields'] == TRUE)
		{
			$W->fetch_custom_weblog_fields();
		}

		// build the sql query based on our tag params
		$W->build_sql_query();

		// if there was no sql
		if ($W->sql == '')
		{
			// return the template no results tag
			return FALSE;
		}
		// now the fun starts
		// create my select sql
		$select_sql = ", lg_bm.priority as priority, lg_bm.change_frequency as change_frequency, lg_bm.include_in_sitemap as include_in_sitemap FROM";
		// create the join sql
		$join_sql = "AS t LEFT JOIN exp_lg_better_meta AS lg_bm ON t.entry_id = lg_bm.entry_id";
		// Where sql
		// we are looking for explict values set in the meta tab
		// saved meta tab with default values which will produce a blank string
		// or NULL which will occur when no meta is saved but the tables are joined
		$where_sql = "WHERE (lg_bm.include_in_sitemap = 'y' || lg_bm.include_in_sitemap = '' || lg_bm.include_in_sitemap IS NULL) AND";
		// add it to the Weblog sql
		$sql = str_replace(array("FROM", "AS t", "WHERE"), array($select_sql, $join_sql, $where_sql), $W->sql);

		// fire the query
		$W->query = $DB->query($sql);

		// get the extension settings
		$settings = $this->settings;

		// loop through each of the entries
		foreach ($W->query->result as $key => $entry)
		{
			// add default include in sitemap if not set
			if(empty($entry['include_in_sitemap']) === TRUE)
			{
				$W->query->result[$key]['include_in_sitemap'] = $settings['weblogs'][$entry['weblog_id']]['include_in_sitemap'];
			}

			if($W->query->result[$key]['include_in_sitemap'] == 'y')
			{
				// add default priority if not set
				if(empty($entry['priority']) === TRUE)
					$W->query->result[$key]['priority'] = $settings['weblogs'][$entry['weblog_id']]['priority'];
				// add default change frequency if not set
				if(empty($entry['change_frequency']) === TRUE)
					$W->query->result[$key]['change_frequency'] = $settings['weblogs'][$entry['weblog_id']]['change_frequency'];
			}
			else
			{
				unset($W->query->result[$key]);
			}

			$W->query->result[$key]['change_frequency'] = strtolower($W->query->result[$key]['change_frequency']);

		}

		// if no rows
		if ($W->query->num_rows == 0)
		{
			// return the no templates url
			return FALSE;
		}

		return $W;
	}

	/**
	 * Encodes a string
	 * 
	 * @param $str string The unencoded or partially encoded string
	 * @return string A html encoded string
	 **/
	function _encode($str)
	{
		global $PREFS, $REGX;
		return str_replace(array("'","\""), array("&#39;","&quot;"), $REGX->ascii_to_entities($REGX->_html_entity_decode($str, "UTF-8")));
	}

}