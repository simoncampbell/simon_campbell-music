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
            {exp:weblog:categories style="linear"}
            <dd{if segment_3 =="{category_url_title}"} class="cur"{/if}><a href="{path='store/index'}">{category_name}</dd>
            {/exp:weblog:categories}
        </dl><!-- // #categories_list -->
        
        <ul class="horizontal gallery_grid">
            {exp:weblog:entries
                disable="member_data|trackbacks|categories"
                limit="9"
                pagination="bottom"
                weblog="products_music|products_posters|products_tshirts"
            }
            <li>
                <a href="{url_title_path='product'}">
                    <p>{title}</p>
                    {if weblog_short_name == "products_music"}
                        {exp:ed_imageresizer
                            alt=""
                            cropratio="1:1"
                            forceWidth="yes"
                            image="{cf_products_music_images}{ffm_images_image}{/cf_products_music_images}"
                            maxHeight="180"
                            maxWidth="180"
                        }
                    {/if}
                    {if weblog_short_name == "products_posters"}
                        {exp:ed_imageresizer
                            alt=""
                            cropratio="1:1"
                            forceWidth="yes"
                            image="{cf_products_posters_images}{ffm_images_image}{/cf_products_posters_images}"
                            maxHeight="180"
                            maxWidth="180"
                        }
                    {/if}
                    {if weblog_short_name == "products_tshirts"}
                        {exp:ed_imageresizer
                            alt=""
                            cropratio="1:1"
                            forceWidth="yes"
                            image="{cf_products_tshirts_images}{ffm_images_image}{/cf_products_tshirts_images}"
                            maxHeight="180"
                            maxWidth="180"
                        }
                    {/if}
                </a>
            </li>
            {/exp:weblog:entries}
        </ul><!-- // .gallery_grid -->
        
        <p class="pagination">
            Go to page: 
            <a href="#">1</a> 
            <a class="cur" href="#">2</a> 
            <a href="#">3</a> 
            <a href="#">4</a> 
            <a href="#">5</a>
        </p><!-- // .pagination -->
        
        {!--
        VERSION 1: STORE LANDING
        <img src="{pv_assets_url}/images/content/store_landing.jpg" width="250" height="251" alt="ThirtySix out 26 March.">
        <div class="widget">
            <h2>Sorry, we're not open yet!</h2>
            <p>
                <strong>The Simon Campbell Music store is being readied for the ThirtySix album launch on the 26th of March.</strong> 
                On this date, you'll be able to order and download the full album, alongside some other merchandise and apparel.
            </p>
            <p>
                If you'd like to be notified the moment the store opens, please subscribe to the Simon Campbell Music newsletter.
            </p>
            <form class="validate_inline" action="http://erskine.createsend.com/t/r/s/bxdii/" method="post">
                <fieldset>
                    <div>
                        <label for="cm-bxdii-bxdii">Email Address</label>
                        <input type="text" name="cm-bxdii-bxdii" id="bxdii-bxdii" class="required email">
                    </div>
                </fieldset>
                <input type="submit" value="Subscribe" class="submit" />
            </form>
        </div>
        --}
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}