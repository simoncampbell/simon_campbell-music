{embed="_layout/_start"
    body_class=""
    body_id=""
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Posters"
    title_suffix="Store"   
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
            <dd><a href="{pv_site_url}/store/music/">Music</a></dd>
            <dd class="cur"><a href="{pv_site_url}/store/posters/">Posters</a></dd>
            <dd><a href="{pv_site_url}/store/tshirts/">T-shirts</a></dd>
        </dl><!-- // #categories_list -->
        
        <ul class="horizontal gallery_grid">
            {exp:weblog:entries
                disable="member_data|trackbacks|categories"
                limit="9"
                pagination="bottom"
                weblog="products_posters"
            }
            <li>
                <a href="{pv_site_url}{comment_url_title_auto_path}">
                    <p>{title}</p>
                    {cf_products_posters_images limit="1"}
                    {exp:ed_imageresizer
                        image="{ffm_images_image}"
                        default="/assets/images/site/bgs/placeholder.gif"
                        maxWidth="180"
                        maxHeight="180"
                        cropratio="1:1"
                        alt=""
                    }
                    {/cf_products_posters_images}
                </a>
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