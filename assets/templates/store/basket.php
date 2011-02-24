{embed="_layout/_start"
    body_class="fullwidth"
    body_id="basket"
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Your basket"
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
        
        <div class="first">
            <h2>Your basket</h2>
            <table>
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Quantity</th>
                        <th>Cost</th>
                    </tr>
                </thead>
                <tbody>
                    {exp:cartthrob:cart_items_info}
                    <tr>
                        <td><a href="#">{title}</a></td>
                        <td>Apparel</td>
                        <td>{quantity}x</td>
                        <td>£{item_subtotal}</td>
                    </tr>
                    {/exp:cartthrob:cart_items_info}
                </tbody>
            </table>
            <p class="more">
                Subtotal: <strong>{exp:cartthrob:cart_items_info}£{cart_subtotal}{/exp:cartthrob:cart_items_info}</strong> + shipping <a class="button" href="#">Go to checkout &rsaquo;&rsaquo;</a>
            </p>
        </div><!-- // .first -->
        
        <div id="payments_block" class="last">
            <h3>Payments</h3>
            <p>
                The Simon Campbell Music store currently accepts the following payment options. Please ensure you are able to pay using one of these methods.
            </p>
            <ul class="horizontal">
                <li><img src="{pv_assets_url}/images/site/icons/visa.jpg" width="28" height="18" alt="Visa"></li>
                <li><img src="{pv_assets_url}/images/site/icons/paypal.jpg" width="28" height="18" alt="Paypal"></li>
            </ul>
        </div><!-- // #payments_block -->
        
    </div> <!-- // #content_pri -->

{embed="_layout/_end"}