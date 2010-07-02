<?php

/*
=====================================================
 ExpressionEngine - by pMachine
-----------------------------------------------------
 http://www.pmachine.com/
-----------------------------------------------------
 Copyright (c) 2003,2004,2005 pMachine, Inc.
=====================================================
 THIS IS COPYRIGHTED SOFTWARE
 PLEASE READ THE LICENSE AGREEMENT
 http://www.pmachine.com/expressionengine/license.html
=====================================================
 File: pi.decode_pmcode.php
-----------------------------------------------------
 Purpose: Decodes pMcode
=====================================================
*/



$plugin_info = array(
						'pi_name'			=> 'EE Typography',
						'pi_version'		=> '1.1',
						'pi_author'			=> 'Chris Curtis',
						'pi_author_url'		=> 'http://www.pmachine.com/',
						'pi_description'	=> 'Invokes EE\'s typography parsing on the content.  You can set the type of formatting for the text, whether HTML is allowed, whether URLs and email addresses are automatically linked, and whether URLs to images are displayed as an image.  The plugin will also process file upload variables such as "{filedir_1}".',
						'pi_usage'			=> Ee_typography::usage()
					);



class Ee_typography {

		var $return_data;
		
		
		// ----------------------------------------
		//  pMcode Decoding
		// ----------------------------------------
		
		function Ee_typography($str = '')
		{
			global $TMPL;
			      
			if ($str == '')
				$str = $TMPL->tagdata;

			if ( ! class_exists('Typography'))
			{
				require PATH_CORE.'core.typography'.EXT;
			}
				
			$TYPE = new Typography;
			$TYPE->convert_curly = FALSE;

			// Retrieve the Text Formatting parameter.
			//   Allowed values: 'xhtml', 'br', 'none', 'lite'
			//   Defaults to 'xhtml' if nothing else specified
			$text_formatting = ( ! $TMPL->fetch_param('formatting')) ? 'xhtml' : $TMPL->fetch_param('formatting');

			// Retrieve the parameter for allowed HTML tags.
			//   Allowed values: 'safe', 'all', 'none'
			//   Defaults to 'safe' if nothing else specified
			$allowed_html = ( ! $TMPL->fetch_param('allowed_html')) ? 'safe' : $TMPL->fetch_param('allowed_html');

			// Retrieve the parameter for auto-linking
			//   Allowed values: 'y', 'n'
			//   Defaults to 'y'
			$auto_link = ( $TMPL->fetch_param('auto_link') != 'n' ) ? 'y' : $TMPL->fetch_param('auto_link');

			// Retrieve the parameter for whether or not image URLs are
			// allowed in the content
			//   Allowed values: 'y', 'n'
			//   Defaults to 'n'
			$allow_img_urls = ( $TMPL->fetch_param('allow_image_urls') != 'y' ) ? 'n' : $TMPL->fetch_param('allow_image_urls');



			$str = str_replace('&#47;', '/', $str);

			$this->return_data = $TYPE->parse_type($str,
				array(
					'text_format'   => $text_formatting,
					'html_format'   => $allowed_html,
					'auto_links'    => $auto_link,
					'allow_img_url' => $allow_img_urls
					)
				);


		}
		// END
        
    
    
    
    
// ----------------------------------------
//  Plugin Usage
// ----------------------------------------

// This function describes how the plugin is used.
//  Make sure and use output buffering

function usage()
{
ob_start(); 
?>
This plugin will run the content inside the tag through EE's typographic parser.  For example, the following EE Tag:

{exp:ee_typography}Here's some [b]sample[/b] text with some pMcode and quotes inside it.{/exp:ee_typography}


Would be rendered as:

<p>Here&#1217;s some <b>sample</b> text with some pMcode and quotes inside it.</p>


PARAMETERS:

formatting=
Set the text formatting to use on the content.  Allowed values are 'xhtml', 'br', 'none', or 'lite'.  Default value is 'xhtml'.  Ex:

  {exp:ee_typography formatting="none"}


allowed_html=
Set what HTML is allowed in the content.  Valid values are 'safe', 'all', or 'none'.  Default value is 'safe'.  Ex:

  {exp:ee_typography allowed_html="none"}


auto_link=
This determines whether or not URLs in the content are automatically turned into links.  Valid values are 'y' or 'n'.  Default value is 'y'.  Ex:

  {exp:ee_typography auto_link="n"}


allow_image_urls=
This determines whether URLs to images will be displayed as an image in the content.  Valid values are 'y' or 'n'.  Default value is 'n'.  Ex:

  {exp:ee_typography allow_image_urls="y"}


<?php
$buffer = ob_get_contents();
	
ob_end_clean(); 

return $buffer;
}
// END
}
// END CLASS
?>