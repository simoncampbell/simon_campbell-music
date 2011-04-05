{embed="_layout/_start"
    body_class="checkout"
    body_id=""
    section="store"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Checkout"
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
        
        <h2>Checkout</h2>
        {if logged_out}
        <p>
            Please <a href="{pv_site_url}/account/">log in</a> or <a href="{pv_site_url}/account/">create an account</a> to complete the checkout process.
        </p>
        {/if}
        {exp:cartthrob:checkout_form
            cart_empty_redirect="store/basket/"
            return="account/index/"
            id="checkout_form"
            authorized_redirect=""
            failed_redirect=""
            declined_redirect=""
        }
        {gateway_fields}
        <p class="notice">The rest of the registration process will be handled at PayPal after clicking <strong>checkout</strong>. Once finished, you will be redirected back to Simon Campbell Music.</p>
        <input type="submit" value="Checkout" />
        {/exp:cartthrob:checkout_form}
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}