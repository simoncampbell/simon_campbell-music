{exp:weblog:entries
    weblog="journal_notes|journal_videos|journal_photos|journal_audio"
    limit="1"
    url_title="{segment_2}"
    disable="{pv_disable_default}"
}
{if no_results}    
    {redirect="404"}
{/if}
{embed="_layout/_start"
    body_class=""
    body_id=""
    section="journal"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="{title}"
    title_suffix="Journal"   
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
            
            <div class="post">
                <h2>{title}</h2>
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
                    
                    {if cf_journal_audio_mp3 != "" AND cf_journal_audio_ogg != ""}
                    <audio class="audio_player" id="audio_player_{entry_id}" controls>
                        <source src="{cf_journal_audio_mp3}" type="audio/mpeg" />
                        <source src="{cf_journal_audio_ogg}" type="audio/ogg" />
                    </audio> <!-- // #audio_player -->
                    <script>
                        jwplayer("audio_player").setup({
                            players: [
                                { type: "html5" },
                                { type: "flash", src: "{pv_assets_url}/jwplayer/player.swf" }
                            ],
                            provider: "sound",
                            controlbar: "bottom",
                            dock: false,
                            playlist: "none",
                            id: "audio_player_{entry_id}",
                            width: 460,
                            height: 29,
                            icons: false,
                            skin: "{pv_assets_url}/jwplayer/glow.zip"
                        });
                    </script>
                    {/if}
                    
                {/if}
                
            </div> <!-- // .post -->
            
        </div><!-- // #posts -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}
{/exp:weblog:entries}