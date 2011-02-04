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
        
        <!-- <blockquote class="widget">
            <p>
                There are very few records in the last 32 years that I have worked on that I am proud of both musically and technically. Simon Campbell’s forthcoming release is one of them and joins an elite team which can now be counted on one hand!
            </p>
            <cite>&ndash; Steve Boyce-Buckley</cite>
        </blockquote> -->
        
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
                    width: 430,
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
        
        <div class="widget" id="free_download">
            <div class="first">
                <h3>Get <strong>&ldquo;Brother&rdquo;</strong> as a free download</h3>
                <p>Enter your email below and we&rsquo;ll send you a link to download the MP3. You&rsquo;ll also receive regular updates on the album and Simon&rsquo;s upcoming events.</p>
            </div>
            <div class="last">
                <form class="validate_inline" action="http://erskine.createsend.com/t/r/s/bxdii/" method="post">
                    <fieldset>
                        <div>
                            <label for="cm-bxdii-bxdii">Your email address</label>
                            <input type="text" name="cm-bxdii-bxdii" id="bxdii-bxdii" class="required email">
                            <input type="submit" value="Subscribe" class="submit" />
                        </div>
                    </fieldset>
                </form>
            </div>
        </div><!-- // .widget -->
        
        <div class="widget" id="journey">
            <div class="first">
                <h3>The journey</h3>
                <p>
                    Well this is it, Simon&rsquo;s first solo album in thirty six years of spanking the plank. It&rsquo;s not blues, it&rsquo;s not rock, it&rsquo;s not folk; it is an eclectic mix that will take you on his very personal musical journey. Each song is written about real people, with real lives. Read all about <a href="/{segment_1}/history/">how ThirtySix came to be</a>.
                </p>
            </div>
            <div class="last">
                <ul class="social">
                    <li class="twitter"><a href="http://twitter.com/share?url={site_url}{pv_all_segments}&amp;text=Simon%20Campbell's%20%22ThirtySix%22">Share on Twitter</a></li>
                    <li class="facebook">
                        <a href="http://www.facebook.com/sharer.php?u={site_url}{pv_all_segments}">Share on Facebook</a>
                    </li>
                </ul><!-- // .social -->
            </div>
        </div><!-- // .widget -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}