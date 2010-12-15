<?php
require_once(PATH_CORE.'core.template'.EXT);

class Cartthrob_template extends Template
{
	var $template_override;
	
	function Cartthrob_template($string = '')
	{
		parent::Template();
		
		$this->template_override = $string;
	}
	
	function parse_template_uri()
	{
		$template_override = $this->template_override;
		
		unset($this->template_override);
		
		return $template_override;
	}
}