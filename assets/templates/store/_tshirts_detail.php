{exp:weblog:entries
    disable="{pv_disable_default}"
    limit="1"
    require_entry="yes"
    url_title="{segment_3}"
    weblog="products_tshirts"
}
{if no_results}
    {redirect="404"}
{/if}
{embed="_layout/_start"
    body_class=""
    body_id="product_detail"
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="{title}"
    title_suffix="T-shirts | Store"   
    title_prefix=""   
    description=""
    keywords=""
    robots_index=""
    robots_follow=""
    robots_archive=""
    canonical_url="/"
}
    
    <div id="content_pri">
        
        <p class="more"><a href="{pv_site_url}/store/">Back to store</a></p>
        
        <h1>{title}</h1>
        <h2>{cf_products_tshirts_subtitle}</h2>
        
        {cf_products_tshirts_images}
            {if "{total_rows}" == "1"}
            <div id="gallery_photos" class="{row_id}">
                <div class="gallery_photo">
                    {exp:ed_imageresizer
                        image="{ffm_images_image}"
                        forceWidth="yes"
                        maxWidth="580"
                        alt=""
                    }
                </div><!-- // .gallery_photo -->
            </div><!-- // #gallery_photos -->
            {/if}
            {if "{total_rows}" > "1"}
                {if "{row_count}" == "1"}
                <div id="gallery_photos" class="{row_id}">
                    <div class="gallery_photo">
                        {exp:ed_imageresizer
                            image="{ffm_images_image}"
                            forceWidth="yes"
                            maxWidth="280"
                            maxHeight="280"
                            cropratio="1:1"
                            alt=""
                        }
                    </div><!-- // .gallery_photo -->
                </div><!-- // #gallery_photos -->
                {/if}
                {if "{row_count}" == "2"}
                <ul class="horizontal gallery_grid">
                {/if}
                {if "{row_count}" > "1"}
                    <li>
                        <a href="#">
                            {exp:ed_imageresizer
                                image="{ffm_images_image}"
                                forceWidth="yes"
                                maxWidth="130"
                                maxHeight="130"
                                cropratio="1:1"
                                alt=""
                            }
                        </a>
                    </li>
                {/if}
                {if "{row_count}" == "{total_rows}"}
                </ul>
                {/if}
            {/if}
        {/cf_products_tshirts_images}
        
        <div class="first">
            {cf_products_tshirts_description}
        </div><!-- // .first -->
        <div class="last">
            {exp:cartthrob:add_to_cart_form
                entry_id="{entry_id}"
                return="store/basket"
                }
                <fieldset>
                    <div>
                        <label for="type">T-Shirt Size</label>
                        <select name="item_options[cf_products_tshirts_sizes]">
                            {cf_products_tshirts_sizes}
                                <option value="{ffm_sizes_short}">{ffm_sizes_full}</option>
                            {/cf_products_tshirts_sizes}
                        </select>
                    </div>
                    <div>
                        <label for="quantity">Quantity</label>
                        <input id="quantity" name="quantity" min="1" max="100" size="5" type="number" value="1">
                    </div>
                    <div id="price">
                        <h3>Price</h3>
                        <p><strong>£{cf_products_tshirts_price}</strong> + shipping</p>
                    </div>
                </fieldset>
                <input type="hidden" name="item_options[segment_2]" value="{segment_2}" />
                <input type="hidden" name="item_options[url_title]" value="{url_title}" />
                <input class="submit" type="submit" value="Add to basket">
            {/exp:cartthrob:add_to_cart_form}
        </div><!-- // .last -->
        
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}
{/exp:weblog:entries}