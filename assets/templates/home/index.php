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

    <div id="content_pri">
        
        <div id="intro" class="widget">
            <a href="#"><img src="/assets/images/content/home_intro.jpg" width="205" height="206" alt="ThirtySix album cover"></a>
            <h2><a href="#"><strong>"ThirtySix"</strong> The new album</a></h2>
            <p>
                The debut solo album, ThirtySix, by Simon Campbell will be released on <strong>March 26, 2011</strong>. ThirtySix years in the making, the release will be followed by a UK and mainland European tour.
            </p>
            <small><strong>"Brother"</strong> Lead single preview</small>
            <audio id="audio_player" controls>
                <source src="/assets/audio/brother.mp3" type="audio/mpeg" />
                <source src="/assets/audio/brother.ogg" type="audio/ogg" />
            </audio> <!-- // #audio_player -->
            <script>
                jwplayer("audio_player").setup({
                    players: [
                        { type: "html5" },
                        { type: "flash", src: "/assets/jwplayer/player.swf" }
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
        </div> <!-- // #intro -->
        
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
                            <source src="{cf_journal_audio_file}" type="audio/mpeg" />
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
            {/exp:weblog:entries}
            
        </div><!-- // #posts -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}