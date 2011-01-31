<div id="content_sec">
    
    <ul id="navigation_sec" class="item_listing">
        <li><a href="#">Subpage one</a></li>
        <li><a href="#">Subpage two</a></li>
        <li><a href="#">Subpage three</a></li>
    </ul><!-- // .navigation_sec -->
    
    <div id="promo_block" class="widget">
        <a href="#">
            <img src="/assets/images/content/promo_block.jpg" width="300px" height="205px" alt="ThirtySix album launch">
            <small>Album launch 26 March</small>
        </a>
    </div> <!-- // #promo_block -->
    
    <div id="tour_dates" class="widget">
        <h2>ThirtySix on tour</h2>
        <ul class="item_listing">
        {exp:weblog:entries
            weblog="event"
            limit="5"
            disable="{pv_disable_defaults}"
            orderby="cf_event_date"
            sort="desc"
            }
            <li>
                <a href="{cf_event_fburl}">
                    <h3><strong>{cf_event_venue}</strong>, {cf_event_city}</h3>
                    <p><time datetime="{cf_event_date format='{DATE_ATOM}'}">{cf_event_date format="{pv_date_event}"}</time></p>
                </a>
            </li>
            {/exp:weblog:entries}
        </ul>
        <p class="more"><a href="#">See all events</a></p>
    </div> <!-- // #tour_dates -->
    
    <div id="store_block" class="widget">
        <!-- LOGGED OUT -->
        <h2>From the store</h2>
        <a href="#">
            <img src="/assets/images/content/widget_store.jpg" width="268px" height="230px" alt="ThirtySix album t-shirt">
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
            <li><img src="/assets/images/site/icons/visa.jpg" width="28px" height="18px" alt="Visa"></li>
            <li><img src="/assets/images/site/icons/paypal.jpg" width="28px" height="18px" alt="Paypal"></li>
        </ul>
    </div> <!-- // #payments_block -->
    
    <div id="newsletter_signup" class="widget">
        <h2>Newsletter</h2>
        <p>
            Sign up to receive regular updates on the album and Simon's upcoming events.
        </p>
        <form action="http://erskine.createsend.com/t/r/s/bxdii/" method="post">
            <fieldset>
                <input type="email" name="cm-bxdii-bxdii" id="bxdii-bxdii" value="please enter email address" />
                <!-- NOTE: Height of submit button is messed up in firefox -->
                <input type="submit" value="Subscribe" class="submit" />
            </fieldset>
        </form>
    </div> <!-- // #newsletter_signup -->
    
</div> <!-- // #content_sec -->