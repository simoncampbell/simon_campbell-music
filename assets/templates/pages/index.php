{exp:weblog:entries
    weblog="pages"
    limit="1"
    url_title="{segment_2}"
    disable="{pv_disable_default}"
    require_entry="yes"
}
{if no_results}    
    {redirect="404"}
{/if}
{embed="_layout/_start"
    body_class=""
    body_id=""
    section=""
    {!-- LG BETTER META OPTIONS BELOW --}
    title="{title}"
    title_suffix=""   
    title_prefix=""   
    description=""
    keywords=""
    robots_index=""
    robots_follow=""
    robots_archive=""
    canonical_url="/"
}
    
    <div id="content_pri">
        
        <h2>{title}</h2>
        
        {cf_pages_body}

    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}
{/exp:weblog:entries}