{embed="_layout/_start"
    body_class="gallery"
    body_id=""
    section="gallery"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Gallery"
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
        
        <div id="gallery_photos">
            {exp:weblog:entries
                weblog="gallery"
                disable="{pv_disable_defaults}"
                limit="1"
                orderby=""
                sort="asc"
            }
            {cf_gallery_images limit="6" sort="random"}
            <div class="gallery_photo">
                {exp:ed_imageresizer
                    image="{ffm_images_image}"
                    maxWidth="580"
                    maxHeight="380"
                    cropratio="1.3:0.85"
                    alt=""
                    }
                <p class="photo_meta"><em>{ffm_images_title}</em> &ndash; &copy; {ffm_images_credit}</p>
            </div><!-- // .gallery_photo -->
            {/cf_gallery_images}
            {/exp:weblog:entries}
        </div><!-- // #gallery_photos -->
        
        <p class="more"><a href="http://www.flickr.com/photos/erskinecorp/sets/">Check out Simon&rsquo;s other sets on Flickr</a></p>
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}