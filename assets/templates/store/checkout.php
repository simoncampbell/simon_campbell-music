{embed="_layout/_start"
    body_class=""
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
        {exp:cartthrob:checkout_form 
            {!-- NOT SURE ON THESE YET --}
            gateway=""
            return=""
        }
        {gateway_fields}
        <input type="submit" value="Checkout" />
        {/exp:cartthrob:checkout_form}
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}