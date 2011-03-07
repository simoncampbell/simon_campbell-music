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
            
            {exp:cartthrob:cart_items_info}
            
                {if no_results}
                    <p>There is nothing in your cart</p>
                {/if}
                
                {if first_row}
                    {exp:cartthrob:update_cart_form
                        return="store/basket"
                    }
                    <table>
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th colspan="2">Cost</th>
                            </tr>
                        </thead>
                        <tbody>
                {/if}{!-- // IF FIRST ROW --}
                            <tr>
                                {if "{weblog_id}" == "24"}
                                <td><a href="{pv_site_url}/store/tshirts/{url_title}/">{title}</a></td>
                                {/if}
                                {if "{weblog_id}" == "25"}
                                <td><a href="{pv_site_url}/store/music/{url_title}/">{title}</a></td>
                                {/if}
                                {if "{weblog_id}" == "26"}
                                <td><a href="{pv_site_url}/store/posters/{url_title}/">{title}</a></td>
                                {/if}
                                <td>type</td>
                                <td><input name="quantity[{row_id}]" min="0" max="100" size="5" type="number" value="{quantity}" /></td>
                                <td>{item_subtotal}</td>
                                <td><input type="checkbox" name="delete[{row_id}]"> Delete this item</td>
                            </tr>
                {if last_row}
                            <tr>
                                <td colspan="5">
                                    <input type="submit" value="Update Cart">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p class="more">
                        Subtotal: &nbsp;<strong>{cart_subtotal}</strong> + shipping <a class="button" href="{pv_site_url}/{segment_1}/checkout/">Go to checkout &rsaquo;&rsaquo;</a>
                    </p>
                    {/exp:cartthrob:update_cart_form}
                {/if}{!-- // IF LAST ROW --}
            {/exp:cartthrob:cart_items_info}
            
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