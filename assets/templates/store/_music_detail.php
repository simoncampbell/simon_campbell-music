{exp:weblog:entries
    disable="{pv_disable_default}"
    limit="1"
    require_entry="yes"
    url_title="{segment_3}"
    weblog="products_music"
}
{if no_results}
    {redirect="404"}
{/if}
{embed="_layout/_start"
    body_class="music_detail"
    body_id="product_detail"
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="{title}"
    title_suffix="Music | Store"   
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
        <h2>{cf_products_music_subtitle}</h2>
        
        {cf_products_music_images}
        {if "{total_rows}" == "1"}      
        <div id="gallery_photos" class="{row_id}">
            <div class="gallery_photo">
                {exp:ed_imageresizer
                    image="{ffm_images_image}"
                    forceWidth="yes"
                    maxWidth="580"
                    alt="{ffm_images_description}"
                }
            </div><!-- // .gallery_photo -->
        </div><!-- // #gallery_photos -->
        {/if}   
        {if "{total_rows}" > "1"}   
            {if "{row_count}" == "1"}   
            <div id="gallery_photos">
                <div class="gallery_photo">
                    {exp:ed_imageresizer
                        image="{ffm_images_image}"
                        forceWidth="yes"
                        maxWidth="280"
                        maxHeight="280"
                        cropratio="1:1"
                        alt="{ffm_images_description}"
                    }
                </div><!-- // .gallery_photo -->
            </div><!-- // #gallery_photos -->
            {/if}
            {if "{row_count}" == "1"}   
            <ul class="horizontal gallery_grid">
            {/if}   
                <li>
                    <a href="{ffm_images_image}">
                        {exp:ed_imageresizer
                            image="{ffm_images_image}"
                            forceWidth="yes"
                            maxWidth="130"
                            maxHeight="130"
                            cropratio="1:1"
                            alt="{ffm_images_description}"
                        }
                    </a>
                </li>
            {if "{row_count}" == "{total_rows}"}    
            </ul>
            {/if}
        {/if}
        {/cf_products_music_images}
        
        <div class="first">
            {cf_products_music_description}
        </div><!-- // .first -->
        <div class="last">
            {exp:cartthrob:add_to_cart_form
                entry_id="{entry_id}"
                return="store/basket"
                }
                <fieldset>
                    <div>
                        <label for="type">Select Format</label>
                        <select id="music_formats" name="item_options[cf_products_music_formats]">
                            <option value="{cf_products_music_price}" title="{cf_products_music_price}">Physical Copy</option>
                            {cf_products_music_formats}
                            <option value="{option}" title="{exp:simple_math calculate='{cf_products_music_price} + {price}'}">{option_name} - £{exp:simple_math calculate='{cf_products_music_price} + {price}'}</option>
                            {/cf_products_music_formats}
                        </select>
                    </div>
                    <div id="price">
                        <h3>Price</h3>
                        <p><strong>£{cf_products_music_price}</strong> + shipping</p>
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