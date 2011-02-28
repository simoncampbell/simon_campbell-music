{embed="_layout/_start"
    body_class=""
    body_id="product_detail"
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Product detail"
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
        
        <p class="more"><a href="{path='store'}">Back to store</a></p>
        
        {exp:weblog:entries
            disable="member_data|trackbacks|categories"
            limit="1"
            weblog="products_music"
        }
        
        <h1>{title}</h1>
        <h2>{cf_products_music_subtitle}</h2>
        
        <div id="gallery_photos">
            {cf_products_music_images limit="1"}
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
            {/cf_products_music_images}
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
                        <select name="item_options[cf_products_music_formats]">
                            {cf_products_music_formats}
                                <option value="{option}">{option_name} ({price})</option>
                            {/cf_products_music_formats}
                        </select>
                    </div>
                    <div>
                        <label for="quantity">Quantity</label>
                        <input id="quantity" name="quantity" min="1" max="100" size="5" type="number" value="1">
                    </div>
                    <div id="price">
                        <h3>Price</h3>
                        <p><strong>£{cf_products_music_price}</strong> + shipping</p>
                    </div>
                </fieldset>
                <input class="submit" type="submit" value="Add to basket">
            {/exp:cartthrob:add_to_cart_form}
        </div><!-- // .last -->
        
        {/exp:weblog:entries}
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}