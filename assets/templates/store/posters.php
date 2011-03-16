<?php 

global $IN;

if ($IN->fetch_uri_segment('3') != "" AND "{pv_pagination_page}" == "no") 
{
   	echo '{embed="store/_posters_detail"}';
}
else
{
	echo '{embed="store/_posters_list"}';
}

?>