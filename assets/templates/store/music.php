<?php 

global $IN;

if ($IN->fetch_uri_segment('3') != "" AND "{pv_pagination_page}" == "no") 
{
   	echo '{embed="store/_music_detail"}';
}
else
{
	echo '{embed="store/_music_list"}';
}

?>