<?php 
// Prevent content to be cached 
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Content was generated on past 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Content is always modified 

// Inform user agent that content is XML and is UTF-8 encoded 
header('Content-type: text/xml; charset=UTF-8'); 

// Read content from template and show it 
@readfile ('http://'.$_SERVER['HTTP_HOST'].'/feeds/google_sitemap_xml/'); 
?>