{embed="_layout/_start"
    body_class="home"
    body_id=""
    section="home"
    {!-- LG BETTER META OPTIONS BELOW --}
    title=""
    title_suffix=""   
    title_prefix=""   
    description=""
    keywords=""
    robots_index=""
    robots_follow=""
    robots_archive=""
    canonical_url="/"
}

    <div id="promo">
        <ul>
            {exp:weblog:entries
                weblog="homepage_features"
                limit="4"
                disable="{pv_disable_default}"
                dynamic="off"
                fixed_order="{lv_featured_homepage}"
            }
            <li>
                <a href="#tab{count}">
                    {exp:ed_imageresizer 
                        maxWidth="60"
                        forceWidth="yes"
                        cropratio="60:38" 
                        image="{cf_features_image}" 
                        alt=""
                    }
                    {title}
                </a>
            </li>
            {/exp:weblog:entries}
        </ul>
        
        {exp:weblog:entries
            weblog="homepage_features"
            limit="4"
            disable="{pv_disable_default}"
            dynamic="off"
            fixed_order="{lv_featured_homepage}"
        }
        <div id="tab{count}">
            {exp:ed_imageresizer 
                maxWidth="640"
                forceWidth="yes"
                cropratio="640:236" 
                image="{cf_features_image}" 
                alt=""
            }
            <div class="slide_content">
                <h2>{exp:ee_typography formatting="lite"}{cf_features_title}{/exp:ee_typography}</h2>
                <h3>{cf_features_subtitle}</h3>
                {if cf_features_audio_mp3 != "" AND cf_features_audio_ogg != ""}
                    <audio id="audio_player_{entry_id}_{count}" controls>
                        <source src="{cf_features_audio_mp3}" type="audio/mpeg" />
                        <source src="{cf_features_audio_ogg}" type="audio/ogg" />
                    </audio> <!-- // #audio_player -->
                    <script>
                        jwplayer("audio_player_{entry_id}_{count}").setup({
                            players: [
                                { type: "html5" },
                                { type: "flash", src: "{pv_assets_url}/jwplayer/player.swf" }
                            ],
                            provider: "sound",
                            controlbar: "bottom",
                            dock: false,
                            playlist: "none",
                            id: "audio_player_{entry_id}_{count}",
                            width: 195,
                            height: 29,
                            icons: false,
                            skin: "{pv_assets_url}/jwplayer/glow.zip"
                        });
                    </script>
                {if:else}
                    <p>{cf_features_lead}</p>
                {/if}
                <p><a href="{cf_features_link_url}">{cf_features_link_label} &raquo;</a></p>
            </div> <!-- // .slide_content -->
        </div> <!-- // #tab{count} -->
        {/exp:weblog:entries}

    </div> <!-- // #promo -->

    <div id="content_pri">
        
        <div id="posts" class="widget">
            
            {exp:weblog:entries
                weblog="journal_notes|journal_videos|journal_photos|journal_audio"
                limit="{lv_journal_homepage_limit}"
                disable="member_data|trackbacks|categories"
                orderby=""
                sort=""
                dynamic="off"
                }    
                <div class="post">
                    <h2><a href="{pv_site_url}{comment_url_title_auto_path}">{title}</a></h2>
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
                    
                    {!--<p class="comment"><a href="{pv_site_url}{comment_url_title_auto_path}#comments">Add your comments &raquo;</a></p>--}

                </div> <!-- // .post -->
            {/exp:weblog:entries}
            
            <p class="more"><a href="{pv_site_url}/journal/">Read more in the journal &raquo;</a></p>
            
        </div><!-- // #posts -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}