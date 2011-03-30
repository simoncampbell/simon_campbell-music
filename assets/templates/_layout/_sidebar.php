<div id="content_sec">
    
    {if segment_1 == "biography"}
    <ul id="navigation_sec" class="item_listing">
        <li{if segment_2 == ""} class="cur"{/if}><a href="{pv_site_url}/biography/">Biography &ndash; the man behind the music</a></li>
        <li{if segment_2 == "gear"} class="cur"{/if}><a href="{pv_site_url}/biography/gear/">Gear list &ndash; the collection</a></li>
    </ul><!-- // .navigation_sec -->
    {/if}
    
    {if segment_1 == "thirtysix"}
    <ul id="navigation_sec" class="item_listing">
        <li{if segment_2 == ""} class="cur"{/if}><a href="{pv_site_url}/thirtysix/">The album &ndash; peruse, preview, purchase</a></li>
        <li{if segment_2 == "history"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/history/">ThirtySix &ndash; who, what and where</a></li>
        <li{if segment_2 == "lyrics"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/lyrics/">Album lyrics &ndash; the words behind the music</a></li>
        <li{if segment_2 == "lyrics-ep"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/lyrics-ep/">EP lyrics &ndash; further words of wisdom</a></li>
        
    </ul><!-- // .navigation_sec -->
    {/if}
    
    {if segment_1 != "thirtysix"}
    <div id="newsletter_signup" class="widget">
        <h2>Newsletter</h2>
        <p>
            Sign up to receive regular updates on the new album and Simon&rsquo;s shows &amp; events.
        </p>
        <form action="http://erskine.createsend.com/t/r/s/bxdii/" method="post">
            <fieldset>
                <label class="hide" for="cm-bxdii-bxdii">Email Address</label>
                <input type="text" name="cm-bxdii-bxdii" id="bxdii-bxdii" class="required email" value="please enter email address" />
                <!-- NOTE: Height of submit button is messed up in firefox -->
                <input type="submit" value="Subscribe" class="submit" />
            </fieldset>
        </form>
    </div> <!-- // #newsletter_signup -->
    {/if}

    {if segment_1 != "home" && lv_featured_sidebar != ""}
    <div class="promo_block widget">
        {exp:weblog:entries
            weblog="homepage_features"
            limit="1"
            entry_id="{lv_featured_sidebar}"
            disable="member_data|trackbacks|categories"
            orderby=""
            sort=""
            dynamic="off"
        }
        <a href="{cf_features_link_url}">
            {exp:ed_imageresizer 
                maxWidth="300"
                forceWidth="yes"
                image="{cf_features_sidebar_image}" 
                alt="{cf_features_title}"
            }
            <small>{title}</small>
        </a>
        {/exp:weblog:entries}
    </div> <!-- // #promo_block -->
    {/if}
    
    {exp:weblog:entries
        weblog="events"
        limit="5"
        disable="{pv_disable_defaults}"
        dynamic="off"
        orderby="cf_events_date"
        sort="asc"
        show_expired="false"
        }
        {if count == 1}
        <div id="tour_dates" class="widget">
            <h2>Live shows</h2>
            <ul class="item_listing">
        {/if}
                <li>
                    <a href="{cf_events_fburl}">
                        <h3><em>{title}</em> at <strong>{cf_events_venue}, {cf_events_city}</strong></h3>
                        <p><time datetime="{cf_events_date format='{DATE_ATOM}'}">{cf_events_date format="{pv_date_event}"}</time></p>
                    </a>
                </li>
        {if count == total_results}        
            </ul>
            <p class="more"><a href="http://www.facebook.com/SimonCampbellBand?v=app_2344061033">See all events on Facebook</a></p>
        </div> <!-- // #tour_dates -->
        {/if}
    {/exp:weblog:entries}
    
    {if lv_featured_sidebar_store != ""}    
    {exp:weblog:entries
        weblog="products_music|products_posters|products_tshirts"
        limit="1"
        entry_id="{lv_featured_sidebar_store}"
        disable="member_data|trackbacks|categories"
        orderby=""
        sort=""
        dynamic="off"
    }
    {if segment_3 != url_title}
    <div id="store_block" class="widget">
        <h2>From the store</h2>
        {if weblog_short_name == 'products_music'}  
        <a href="{pv_site_url}/store/music/{url_title}/">
            {cf_products_music_images limit="1"}
            {exp:ed_imageresizer 
                maxWidth="268"
                forceWidth="yes"
                image="{ffm_images_image}"
                alt=""
            }
            {/cf_products_music_images}
            <small>{title}</small>
        </a>
        {/if}   
        {if weblog_short_name == 'products_posters'}    
        <a href="{pv_site_url}/store/posters/{url_title}/">
            {cf_products_posters_images limit="1"}
            {exp:ed_imageresizer 
                maxWidth="268"
                forceWidth="yes"
                image="{ffm_images_image}"
                alt=""
            }
            {/cf_products_posters_images}
            <small>{title}</small>
        </a>
        {/if}   
        {if weblog_short_name == 'products_tshirts'}    
        <a href="{pv_site_url}/store/tshirts/{url_title}/">
            {cf_products_tshirts_images limit="1"}
            {exp:ed_imageresizer 
                maxWidth="268"
                forceWidth="yes"
                image="{ffm_images_image}"
                alt=""
            }
            {/cf_products_tshirts_images}
            <small>{title}</small>
        </a>
        {/if}   
    </div> <!-- // #store_block -->
    {/if}
    {/exp:weblog:entries}
    {/if}   
    
    <div id="payments_block" class="widget">
        <h2>Payments</h2>
        <p>
            The Simon Campbell Music store currently accepts the following payment options:
        </p>
        <ul class="horizontal">
            <li><img src="{pv_assets_url}/images/site/icons/visa.jpg" width="28" height="18" alt="Visa"></li>
            <li><img src="{pv_assets_url}/images/site/icons/paypal.jpg" width="28" height="18" alt="Paypal"></li>
        </ul>
    </div> <!-- // #payments_block -->
    
</div> <!-- // #content_sec -->
