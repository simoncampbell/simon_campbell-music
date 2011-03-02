{embed="_layout/_start"
    body_class=""
    body_id=""
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Store"
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
        
        <h1 class="hide">Store</h1>
        
        <dl id="definition_links" class="horizontal">
            <dt>Categories</dt>
            <dd{if segment_2 =="music"} class="cur"{/if}><a href="{pv_site_url}/store/music/">Music</a></dd>
            <dd{if segment_2 =="posters"} class="cur"{/if}><a href="{pv_site_url}/store/posters/">Posters</a></dd>
            <dd{if segment_2 =="tshirts"} class="cur"{/if}><a href="{pv_site_url}/store/tshirts/">T-shirts</a></dd>
        </dl><!-- // #categories_list -->
        
        <ul class="horizontal gallery_grid">
            {exp:weblog:entries
                disable="member_data|trackbacks"
                limit="1"
                pagination="bottom"
                weblog="products_music|products_posters|products_tshirts"
            }
            <li>
                {if weblog_short_name == "products_music"}
                <a href="{pv_site_url}{comment_url_title_auto_path}">
                    <p>{title}</p>
                    {cf_products_music_images limit="1"}
                    {exp:ed_imageresizer
                        alt=""
                        cropratio="1:1"
                        forceWidth="yes"
                        image="{ffm_images_image}"
                        maxHeight="180"
                        maxWidth="180"
                    }
                    {/cf_products_music_images}
                </a>
                {/if}
                
                {if weblog_short_name == "products_posters"}
                <a href="{pv_site_url}{comment_url_title_auto_path}">
                    <p>{title}</p>
                    {cf_products_posters_images limit="1"}
                    {exp:ed_imageresizer
                        alt=""
                        cropratio="1:1"
                        forceWidth="yes"
                        image="{ffm_images_image}"
                        maxHeight="180"
                        maxWidth="180"
                    }
                    {/cf_products_posters_images}
                </a>
                {/if}
                
                {if weblog_short_name == "products_tshirts"}
                <a href="{pv_site_url}{comment_url_title_auto_path}">
                    <p>{title}</p>
                    {cf_products_tshirts_images limit="1"}
                    {exp:ed_imageresizer
                        alt=""
                        cropratio="1:1"
                        forceWidth="yes"
                        image="{ffm_images_image}"
                        maxHeight="180"
                        maxWidth="180"
                    }
                    {/cf_products_tshirts_images}
                </a>
                {/if}
            </li>
            {paginate}
            {if "{total_pages}" > "1"}
            </ul><!-- // .gallery_grid -->
            <p class="pagination">
                Go to page: 
                {pagination_links}
            </p><!-- // .pagination -->
            {/if}
            {if "{total_pages}" == "1"}
            </ul><!-- // .gallery_grid -->
            {/if}
            {/paginate}
            {/exp:weblog:entries}
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}