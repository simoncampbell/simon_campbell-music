{exp:weblog:entries
    disable="{pv_disable_default}"
    limit="1"
    require_entry="yes"
    url_title="{segment_3}"
    weblog="products_posters"
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
    title_suffix="Posters | Store"   
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
        <h2>{cf_products_posters_subtitle}</h2>
        
        <div id="gallery_photos">
            {cf_products_posters_images limit="1"}
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
            {/cf_products_posters_images}
        </div><!-- // #gallery_photos -->
        <ul class="horizontal gallery_grid">
            <li class="activeSlide">
                <a href="#">
                    <img src="/assets/images/site/dev/temp_gallery.gif" width="130" height="130" alt="">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/assets/images/site/dev/temp_gallery.gif" width="130" height="130" alt="">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/assets/images/site/dev/temp_gallery.gif" width="130" height="130" alt="">
                </a>
            </li>
            <li>
                <a href="#">
                    <img src="/assets/images/site/dev/temp_gallery.gif" width="130" height="130" alt="">
                </a>
            </li>
        </ul>
        <div class="first">
            {cf_products_posters_description}
        </div><!-- // .first -->
        <div class="last">
            {exp:cartthrob:add_to_cart_form
                entry_id="{entry_id}"
                return="store/basket"
                }
                <fieldset>
                    <div>
                        <label for="quantity">Quantity</label>
                        <input id="quantity" name="quantity" min="1" max="100" size="5" type="number" value="1">
                    </div>
                    <div id="price">
                        <h3>Price</h3>
                        <p><strong>£{cf_products_posters_price}</strong> + shipping</p>
                    </div>
                </fieldset>
                <input class="submit" type="submit" value="Add to basket">
            {/exp:cartthrob:add_to_cart_form}
        </div><!-- // .last -->

    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}
{/exp:weblog:entries}