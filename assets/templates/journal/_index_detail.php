{assign_variable:dav_all_journal_channels="journal_notes|journal_videos|journal_photos|journal_audio"}
{exp:weblog:entries
    weblog="{dav_all_journal_channels}"
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
    {!-- FACEBOOK META OPTIONS BELOW --}
    og_title="{title} | Simon Campbell Music"
    og_description="{exp:html_strip}{cf_journal_videos_lead}{cf_journal_photos_lead}{cf_journal_audio_lead}{cf_journal_notes_note}{/exp:html_strip}"
    {if weblog_short_name == "journal_photos"}
    og_image="{site_url}{cf_journal_photos_image}"
    {/if}
    {if weblog_short_name == "journal_audio"}
    og_audio="{cf_journal_audio_mp3}"
    og_audio_type="application/mp3"
    og_audio_title="{cf_journal_audio_fbtitle}"
    og_audio_artist="{cf_journal_audio_fbartist}"
    og_audio_album="{cf_journal_audio_fbalbum}"
    {/if}
}
    
    <div id="content_pri">
        
        <div id="posts">
            
            <div class="post">
                <h2>{title}</h2>
                <ul class="post_meta horizontal">
                    <li><time datetime="{entry_date format='{DATE_ATOM}'}">{entry_date format="{pv_date_journal}"}</time></li>
                    <li class="pm_twitter"><a href="http://twitter.com/share?url={site_url}{comment_url_title_auto_path}&amp;text={exp:tools:url_encode}"{title}"{/exp:tools:url_encode}&amp;via=simoncampbell&amp;related=simoncampbell">Share on Twitter</a></li>
                    <li class="pm_facebook"><a href="http://www.facebook.com/sharer.php?u={site_url}{comment_url_title_auto_path}">Share on Facebook</a></li>
                </ul>
                
                {if weblog_short_name == "journal_notes"}
                
                    {if cf_journal_notes_image != ""}
                        <div class="post_image note_image size{cf_journal_notes_image_size}">
                            {exp:ed_imageresizer 
                                maxWidth="{cf_journal_notes_image_size}"
                                forceWidth="yes"
                                image="{cf_journal_notes_image}" 
                                alt=""
                                }
                            {if cf_journal_notes_image_caption != ""}
                                <span>{cf_journal_notes_image_caption}</span>
                            {/if}
                        </div>
                    {/if}
                
                    {cf_journal_notes_note}
                
                {/if}
                
                {if weblog_short_name == "journal_photos"}
                
                    {cf_journal_photos_lead}
                    
                    {exp:ed_imageresizer 
                        maxWidth="580"
                        forceWidth="yes"
                        image="{cf_journal_photos_image}" 
                        alt=""
                        }
                
                {/if}
                
                {if weblog_short_name == "journal_videos"}
                
                    {cf_journal_videos_lead}
                    
                    <iframe 
                        src="http://player.vimeo.com/video/{cf_journal_videos_vimeo}?portrait=0&amp;color=f69b55" 
                        width="580" 
                        height="325">
                    </iframe>
                
                {/if}
                
                {if weblog_short_name == "journal_audio"}
                    
                    {cf_journal_audio_lead}
                    
                    {if cf_journal_audio_mp3 != "" AND cf_journal_audio_ogg != ""}
                    <audio id="audio_player_{entry_id}" controls>
                        <source src="{cf_journal_audio_mp3}" type="audio/mpeg" />
                        <source src="{cf_journal_audio_ogg}" type="audio/ogg" />
                    </audio> <!-- // #audio_player -->
                    <script>
                        jwplayer("audio_player_{entry_id}").setup({
                            players: [
                                { type: "html5" },
                                { type: "flash", src: "{pv_assets_url}/jwplayer/player.swf" }
                            ],
                            provider: "sound",
                            controlbar: "bottom",
                            dock: false,
                            playlist: "none",
                            id: "audio_player_{entry_id}",
                            width: "100%",
                            height: 29,
                            icons: false,
                            skin: "{pv_assets_url}/jwplayer/glow.zip"
                        });
                    </script>
                    {/if}
                    
                {/if}
                
            </div> <!-- // .post -->
            
            <div id="post_links"{if lv_comments_toggle == "On"} class="alt1"{/if}>
            
                <p class="more"><a href="{pv_site_url}/journal/">&lsaquo;&lsaquo; Back to the journal</a></p>
                
                <ul id="navigation_prevnext">
                    {exp:weblog:next_entry weblog="{dav_all_journal_channels}"}
                    <li class="next"><a href="{path='journal/index'}">Next post &rsaquo;&rsaquo;</a></li>
                    {/exp:weblog:next_entry}
                    {exp:weblog:prev_entry weblog="{dav_all_journal_channels}"}
                    <li class="prev"><a href="{path='journal/index'}">&lsaquo;&lsaquo; Previous post</a></li>
                    {/exp:weblog:prev_entry}
                </ul>
                
            </div><!-- // #post_links -->
            
        </div><!-- // #posts -->
        
        {if lv_comments_toggle == "On"}
        {embed="_components/_comments" entry_id="{entry_id}"}
        {/if}
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}
{/exp:weblog:entries}