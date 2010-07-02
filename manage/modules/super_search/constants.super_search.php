<?php if ( ! defined('EXT')) exit('No direct script access allowed');

/**
 * Super Search
 *
 * An ExpressionEngine module that enables better search functionality.
 *
 * @package		Super Search module
 * @author		Solspace, Inc. (Mitchell Kimbrough <mitchell@solspace.com>)
 * @copyright	Copyright (c) 2009-2010, Solspace, Inc.
 * @link		http://www.solspace.com/docs/
 * @version		1.1.0.b2
 * @location 	./system/modules/
 * 
 */
 
/**
 * Super Search Class - CONSTANTS
 *
 * Central location for various values we need throughout the module
 */
 
if ( ! defined('SUPER_SEARCH_VERSION'))
{
	define('SUPER_SEARCH_VERSION',	'1.1.0.b2');
	define('SUPER_SEARCH_DOCS_URL',	'http://www.solspace.com/docs/addon/c/Super_Search');
	define('SUPER_SEARCH_ACTIONS',	'save_search');
	define('SUPER_SEARCH_PREFERENCES',	'allow_keyword_search_on_playa_fields|allow_keyword_search_on_relationship_fields');
}

//	End file