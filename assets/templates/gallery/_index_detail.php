{embed="_layout/_start"
    body_class="gallery"
    body_id="gallery_detail"
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
        
        {exp:weblog:entries
            weblog="gallery"
            disable="{pv_disable_defaults}"
            orderby=""
            limit="1"
            sort="asc"
        }
            <h2>&ldquo;{title}&rdquo;</h2>
            <p class="meta">This gallery was first published <time datetime="{entry_date format='{DATE_ATOM}'}">{entry_date format="{pv_date_journal}"}</time>.</p>
        {/exp:weblog:entries}
        
        <div id="gallery">
            <ul>
                {!-- Default behaviour: load detail gallery --}
                {exp:weblog:entries
                    weblog="gallery"
                    disable="{pv_disable_defaults}"
                    orderby=""
                    limit="1"
                    sort="asc"
                }
            
                    {cf_gallery_images sort="desc"}
                        <li id="image_{row_id}">
                            {if segment_3 == "inline"}
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
                            {if:else}
                                <a href="{ffm_images_image}" rel="gallery" title="{if ffm_images_title}{ffm_images_title} &ndash; {if ffm_images_credit}<em>&copy; {ffm_images_credit}</em>{/if}{/if}">
                                    {exp:ed_imageresizer
                                        image="{ffm_images_image}"
                                        maxWidth="190"
                                        forceWidth="yes"
                                        cropratio="4:3"
                                        alt=""
                                    }
                                </a>
                            {/if}   
                        </li> 
                    {/cf_gallery_images}
             
                {/exp:weblog:entries}
            </ul>
        </div>
        
        <p><a href="{pv_site_url}/gallery/">&laquo; Back to gallery listings</a></p>
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}