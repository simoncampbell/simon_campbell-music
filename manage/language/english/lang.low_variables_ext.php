<?php if ( ! defined('EXT')) exit('Invalid file request');

/**
* Low Variables Extension language file
*
* Includes the main language file, with backup to default language if $LANG is not set
*
* @package		low-variables-ee_addon
* @version		1.3.4
* @author		Lodewijk Schutte <low@loweblog.com>
* @link			http://loweblog.com/software/low-variables/
* @copyright	Copyright (c) 2009, Low
*/

isset($LANG) ? $LANG->fetch_language_file('low_variables') : include(PATH_MOD.'low_variables/language/english/lang.low_variables'.EXT);