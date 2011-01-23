<?php 

global $IN;

if ($IN->fetch_uri_segment('2') != "" AND "{pv_pagination_page}" == "no") 
{
   	echo '{embed="journal/_index_detail"}';
}
else
{
	echo '{embed="journal/_index_listing"}';
}

?>