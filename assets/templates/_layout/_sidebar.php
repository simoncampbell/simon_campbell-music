<div id="content_sec">
    
    {if segment_1 == "bio"}
    <ul id="navigation_sec" class="item_listing">
        <li{if segment_2 == ""} class="cur"{/if}><a href="{pv_site_url}/bio/">Biography &ndash; the man behind the music</a></li>
        <li{if segment_2 == "gear"} class="cur"{/if}><a href="{pv_site_url}/bio/gear/">Gear list &ndash; the collection</a></li>
    </ul><!-- // .navigation_sec -->
    {/if}
    
    {if segment_1 == "thirtysix"}
    <ul id="navigation_sec" class="item_listing">
        <li{if segment_2 == ""} class="cur"{/if}><a href="{pv_site_url}/thirtysix/">ThirtySix &ndash; peruse, preview, purchase</a></li>
        <li{if segment_2 == "history"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/history/">History &ndash; how ThirtySix came to be</a></li>
        <li{if segment_2 == "lyrics"} class="cur"{/if}><a href="{pv_site_url}/thirtysix/lyrics/">Lyrics &ndash; the words behind the music</a></li>
    </ul><!-- // .navigation_sec -->
    {/if}

    <div id="promo_block" class="widget">
        <a href="http://www.facebook.com/event.php?eid=127886567271836&amp;index=1">
            <img src="{pv_assets_url}/images/content/promo_block.jpg" width="300px" height="205px" alt="ThirtySix album launch">
            <small>Album launch 26 March</small>
        </a>
    </div> <!-- // #promo_block -->
    
    {exp:weblog:entries
        weblog="events"
        limit="5"
        disable="{pv_disable_defaults}"
        dynamic="off"
        orderby="cf_events_date"
        sort="asc"
        }
        {if count == 1}
        <div id="tour_dates" class="widget">
            <h2>ThirtySix on tour</h2>
            <ul class="item_listing">
        {/if}
                <li>
                    <a href="{cf_events_fburl}">
                        <h3><strong>{cf_events_venue}</strong>, {cf_events_city}</h3>
                        <p><time datetime="{cf_events_date format='{DATE_ATOM}'}">{cf_events_date format="{pv_date_event}"}</time></p>
                    </a>
                </li>
        {if count == total_results}        
            </ul>
            <p class="more"><a href="http://www.facebook.com/SimonCampbellBand?v=app_2344061033">See all events on Facebook</a></p>
        </div> <!-- // #tour_dates -->
        {/if}
    {/exp:weblog:entries}
    
    {!-- hiding until the next release
    
    <div id="store_block" class="widget">
        <!-- LOGGED OUT -->
        <h2>From the store</h2>
        <a href="#">
            <img src="{pv_assets_url}/images/content/widget_store.jpg" width="268px" height="230px" alt="ThirtySix album t-shirt">
        </a>
        <!-- LOGGED IN -->
        <ul class="item_listing">
            <li>
                <a href="#">
                    <h3>ThirtySix digital download</h3>
                    <p><strong>£8.00</strong></p>
                </a>
            </li>
            <li>
                <a href="#">
                    <h3>Album art t-shirt</h3>
                    <p><strong>£12.00</strong></p>
                </a>
            </li>
            <li>
                <a href="#">
                    <h3>Poster</h3>
                    <p><strong>£9.99</strong></p>
                </a>
            </li>
            <li>
                <a href="#">
                    <h3>Sub-total</h3>
                    <p><strong>£39.99</strong> + shipping</p>
                </a>
            </li>
        </ul>
        <p class="more">
            <span class="hide">View </span><a href="#">Your basket</a> <span class="hide">or </span><a class="button" href="#">Go to checkout &rsaquo;&rsaquo;</a>
        </p>
    </div> <!-- // #store_block -->
    
    <div id="payments_block" class="widget">
        <h2>Payments</h2>
        <p>
            The Simon Campbell Music store currently accepts the following payment options:
        </p>
        <ul>
            <li><img src="{pv_assets_url}/images/site/icons/visa.jpg" width="28px" height="18px" alt="Visa"></li>
            <li><img src="{pv_assets_url}/images/site/icons/paypal.jpg" width="28px" height="18px" alt="Paypal"></li>
        </ul>
    </div> <!-- // #payments_block -->
    
    --}
    
    <div id="newsletter_signup" class="widget">
        <h2>Newsletter</h2>
        <p>
            Sign up to receive regular updates on the album and Simon's upcoming events.
        </p>
        <form action="http://erskine.createsend.com/t/r/s/bxdii/" method="post">
            <fieldset>
                <input type="text" name="cm-bxdii-bxdii" id="bxdii-bxdii" class="required email" value="please enter email address" />
                <!-- NOTE: Height of submit button is messed up in firefox -->
                <input type="submit" value="Subscribe" class="submit" />
            </fieldset>
        </form>
    </div> <!-- // #newsletter_signup -->
    
</div> <!-- // #content_sec -->