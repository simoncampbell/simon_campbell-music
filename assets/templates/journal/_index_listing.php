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
            weblog="journal_notes|journal_videos|journal_photos|journal_audio"
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
                
                {if weblog_short_name == "journal_notes"}
                
                    {cf_journal_notes_note}
                
                {/if}
                
                {if weblog_short_name == "journal_photos"}
                
                    {cf_journal_photos_lead}
                    
                    {exp:ed_imageresizer 
                        maxWidth="585"
                        forceWidth="yes"
                        image="{cf_journal_photos_image}" 
                        alt=""
                        }
                
                {/if}
                
                {if weblog_short_name == "journal_videos"}
                
                    {cf_journal_videos_lead}
                    
                    <iframe 
                        src="http://player.vimeo.com/video/{cf_journal_videos_vimeo}" 
                        width="580" 
                        height="325" 
                        frameborder="0">
                    </iframe>
                
                {/if}
                
                {if weblog_short_name == "journal_audio"}
                    
                    {cf_journal_audio_lead}
                    
                    <audio id="audio_player" controls>
                        <source src="" type="audio/mpeg" />
                    </audio> <!-- // #audio_player -->
                    <script>
                        jwplayer("audio_player").setup({
                            players: [
                                { type: "html5" },
                                { type: "flash", src: "{cf_journal_audio_file}" }
                            ],
                            provider: "sound",
                            controlbar: "bottom",
                            dock: false,
                            playlist: "none",
                            id: "audio_player",
                            width: 460,
                            height: 29,
                            icons: false,
                            skin: "/assets/jwplayer/glow.zip"
                        });
                    </script>
                    
                {/if}
                
                
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