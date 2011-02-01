{embed="_layout/_start"
    body_class=""
    body_id=""
    section="journal"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Journal"
    title_suffix=""   
    title_prefix=""   
    description=""
    keywords=""
    robots_index=""
    robots_follow=""
    robots_archive=""
    canonical_url="/"
}
    
    <div id="content_pri">
        
        <div id="posts">
        {exp:weblog:entries
            weblog="journal"
            limit="5"
            disable="member_data|trackbacks|categories"
            orderby=""
            sort=""
            }    
            <div class="post">
                <h2><a href="{pv_site_url}{comment_url_title_auto_path}">{title}</a></h2>
                <ul class="post_meta">
                    <li><time datetime="{entry_date format='{DATE_ATOM}'}">{entry_date format="{pv_date_journal}"}</time></li>
                    <li id="pm_twitter"><a href="#">Share</a></li>
                    <li id="pm_facebook"><a href="#">Share</a></li>
                </ul>
                
                {cf_journal_image}
                    {exp:ed_imageresizer 
                        maxWidth="{ffm_image_position}"
                        image="{ffm_image_file}" 
                        alt=""
                        class="img_right"
                        }
                {/cf_journal_image}

                {cf_journal_body}
                
                <iframe src="http://player.vimeo.com/video/14029274" width="580" height="325" frameborder="0"></iframe>
            </div> <!-- // .post -->
            {paginate}
			{if "{total_pages}" > "1"}
			<p id="pagination">
			    Go to page: 
				{pagination_links}
	        </p><!-- // #pagination -->
			{/if}
			{/paginate}
        {/exp:weblog:entries}
            

            
        </div><!-- // #posts -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}