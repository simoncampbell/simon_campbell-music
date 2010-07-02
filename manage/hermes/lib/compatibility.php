<?php if ( ! defined('EXT')) exit('No direct script access allowed');
 
 /**
 * Hermes - Expansion
 *
 * @package		Hermes:Expansion
 * @author		Solspace DevTeam
 * @copyright	Copyright (c) 2008-2009, Solspace, Inc.
 * @link		http://solspace.com/docs/
 * @version		1.4.0.b
 * @filesource 	./system/hermes/
 * 
 */

/*
 * ---------------------------------------------------------
 *	Compatibility Code for the Entire Program
 * ---------------------------------------------------------
 *
 *	Insures that certain PHP functions and abilities are available to us no matter what version
 *	of PHP may be used by the server.  We're aiming for PHP 4.3 and above, yo.
 *
 */
 
 
// --------------------------------------------------------------------

/**
 *	Ctype Digit
 *
 *	Detects if a string is composed entirely of digits
 *
 *	@access		public
 *	@param		string		$str - String of characters to be checked
 *	@return		bool
 */

if ( ! function_exists('ctype_digit'))
{
	function ctype_digit($str)
	{
		if ( ! is_string($str) OR $str == '')
		{
			return FALSE;
		}
		
		return ! preg_match('/[^0-9]/', $str);
	}	
}
/* END ctype_digit() */


// --------------------------------------------------------------------

/**
 *	Ctype Alpha-Numeric String Check
 *
 *	Detects if a string is composed of entirely alpha-numeric characters
 *
 *	NOTE: For the original PHP functions, "when called with an empty string the result will always 
 *	be TRUE in PHP < 5.1 and FALSE since 5.1."  Annoying.  Let's hope that never becomes a problem.
 *
 *	@access		public
 *	@param		string		$str - String to be checked
 *	@return		bool
 */

if ( ! function_exists('ctype_alnum'))
{
	function ctype_alnum($str)
	{
		if ( ! is_string($str) OR $str == '')
		{
			return FALSE;
		}
		
		return ! preg_match('/[^0-9a-z]/i', $str);
	}	
}
/* END ctype_alnum() */


// --------------------------------------------------------------------

/**
 *	Clone
 *
 *	A fix for the missing clone() ability in versions prior to PHP 5
 *
 *	@access		public
 *	@param		object
 *	@return		object
 */

if ( ! function_exists('clone') && version_compare(PHP_VERSION, '5.0') < 0)
{
	eval('
			function clone($object)
			{
				return $object;
			}
		');
}

?>