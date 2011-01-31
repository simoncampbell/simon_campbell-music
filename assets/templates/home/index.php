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
            
            <div class="post">
                <h2><a href="#">Album launch party on March 26</a></h2>
                <ul class="post_meta">
                    <li><time datetime="">10 March 2011</time></li>
                    <li id="pm_twitter"><a href="#">Share</a></li>
                    <li id="pm_facebook"><a href="#">Share</a></li>
                </ul>
                <img class="img_right" src="/assets/images/content/content_pri_post1.jpg" width="253" height="164" alt="">
                <p>
                    <strong>The ThirtySix album launch event will take place on the 26th March 2011, at the Centenary Centre, Peel.</strong> Vivamus id mollis quam. Morbi ac iklisese commodo nulla.
                </p>
                <p>
                    In condimentum orci id nisl volutpat bibendum. Quisque commodo hendrerit lorem quis egestas. Maecenas quis tortor arcu.
                </p>
            </div> <!-- // .post -->
            
            <div class="post">
                <h2><a href="#">My thoughts on fame &amp; fortune</a></h2>
                <ul class="post_meta">
                    <li><time datetime="">10 March 2011</time></li>
                    <li id="pm_twitter"><a href="#">Share</a></li>
                    <li id="pm_facebook"><a href="#">Share</a></li>
                </ul>
                <!-- <iframe src="http://player.vimeo.com/video/14029274" width="580" height="325" frameborder="0"></iframe> -->
            </div> <!-- // .post -->
            
        </div><!-- // #posts -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}