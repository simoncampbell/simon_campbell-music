<?php 

global $IN;

if ($IN->fetch_uri_segment('2') != "" AND "{pv_pagination_page}" == "no") 
{
   	echo '{embed="gallery/_index_detail"}';
}
else
{
	echo '{embed="gallery/_index_listing"}';
}

?>