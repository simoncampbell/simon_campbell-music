<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 4.3.2 or newer
 *
 * @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2009, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

// ------------------------------------------------------------------------

/**
 * CodeIgniter Config Class - Subclass
 *
 * This class contains functions that enable config files to be managed
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		Solspace Dev Team
 * @filesource	/system/bridge/codeigniter/system/application/libraries/MY_URI.php
 */
 
class MY_URI extends CI_URI {

	/**
	* Constructor
	*
	* gets proper linkage to URI items for 1.6.x
	*
	* @access	public
	*/
	function MY_URI()
	{
		parent::CI_URI();
	
		log_message('debug', "URI Class Initialized");
		
		//query_string isn't in CI_URI

		if ( isset($GLOBALS['IN']) )
		{
			$this->query_string		 =& $GLOBALS['IN']->QSTR;
			$this->page_query_string =& $GLOBALS['IN']->PAGE_QSTR;
		}
	}
}

/* END MY_URI class */

/* End of file MY_URI.php */
/* Location: ./system/bridge/codeigniter/system/application/libraries/MY_URI.php */
