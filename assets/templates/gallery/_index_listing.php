{embed="_layout/_start"
    body_class="gallery"
    body_id="gallery_carousel"
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
        
        <div id="gallery">
            <ul>
                {!-- Default behaviour: load latest gallery --}
                {exp:weblog:entries
                    weblog="gallery"
                    disable="{pv_disable_defaults}"
                    orderby=""
                    limit="1"
                    sort="asc"
                }
                    
                    {cf_gallery_images sort="random"}
                        <li>
                            {exp:ed_imageresizer
                                image="{ffm_images_image}"
                                maxWidth="610"
                                forceWidth="yes"
                                cropratio="4:3"
                                alt=""
                            }
                            <p class="meta">
                                {if ffm_images_title}
                                    {ffm_images_title} &ndash; {if ffm_images_credit}<em>&copy; {ffm_images_credit}</em>{/if}
                                {/if}
                            </p>
                            <a href="{pv_site_url}{comment_url_title_auto_path}#image_{row_id}" class="permalink">
                                Permalink
                            </a>
                        </li> 
                    {/cf_gallery_images}
                     
                {/exp:weblog:entries}
            </ul>
        </div> <!-- // #gallery -->
        
        <ul id="gallery_grid">
            {exp:weblog:entries
                weblog="gallery"
                disable="{pv_disable_defaults}"
                orderby=""
                sort="asc"
            }
                <li {if count == 1}class="cur"{/if}>
                    <a href="{pv_site_url}{comment_url_title_auto_path}">
                        {cf_gallery_images limit="1" sort="random"}
                            {exp:ed_imageresizer
                                image="{ffm_images_image}"
                                maxWidth="190"
                                maxHeight="190"
                                forceWidth="yes"
                                cropratio="4:3"
                                alt=""
                            }
                        {/cf_gallery_images}
                        <p class="meta">
                            {title}
                        </p>
                    </a>
                </li>
            {/exp:weblog:entries}
            
            
        </ul> <!-- // #gallery_grid -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}