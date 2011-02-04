{embed="_layout/_start"
    body_class="thirtysix"
    body_id=""
    section="thirtysix"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="ThirtySix"
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
        
        <div class="widget">
            <h1>Thirtysix</h1>
            <h2>The solo album by Simon Campbell</h2>
        </div><!-- // .widget -->
        
        <blockquote class="widget">
            <p>
                There are very few records in the last 32 years that I have worked on that I am proud of both musically and technically. Simon Campbell’s forthcoming release is one of them and joins an elite team which can now be counted on one hand!
            </p>
            <cite>&ndash; Steve Boyce-Buckley</cite>
        </blockquote>
        
        <div class="widget" id="album_promo_inline">
            <h3>Preview the lead single, <strong>&ldquo;Brother&rdquo;</strong></h3>
            <audio id="audio_player" controls>
                <source src="{pv_assets_url}/audio/brother.mp3" type="audio/mpeg" />
                <source src="{pv_assets_url}/audio/brother.ogg" type="audio/ogg" />
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
                    id: "audio_player",
                    width: 460,
                    height: 29,
                    icons: false,
                    skin: "{pv_assets_url}/jwplayer/glow.zip"
                });
            </script>
            <div>
                <h3>Buy the album</h3>
                <a class="button" href="{pv_site_url}/store/">Go to the store &rsaquo;&rsaquo;</a>
            </div>
        </div><!-- // #album_promo_inline -->
        
        <div class="widget">
            <p>
                Well this is it, my first solo album in thirty six years of spanking the plank. It’s not blues, it’s not rock, it’s not folk; it is an eclectic mix that will take you on my very personal musical journey. Each song is written about real people, with real lives.
            </p>
            <p>You can read my incredible tale of how this all came to be on the journey. Thank you for listening, and most importantly—enjoy.</p>
            <p>
                Love,<br>
                Simon x
            </p>
        </div><!-- // .widget -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}