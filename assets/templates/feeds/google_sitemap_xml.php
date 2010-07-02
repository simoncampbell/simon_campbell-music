<?xml version="1.0" encoding="UTF-8"?> 
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"> 
    {!-- EXAMPLE FOR STATIC PAGES --}
    <url> 
        <loc>{homepage}</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.5</priority> 
    </url> 
    <url> 
        <loc>{site_url}news/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>daily</changefreq> 
        <priority>1.0</priority> 
    </url>
    {!-- EXAMPLE FOR DYNAMIC PAGES --}
	{exp:weblog:entries 
	    weblog="" 
	    limit="50" 
	    disable="{pv_disable_titles}" 
	    rdf="off" 
	    dynamic="off" 
	    status="not Closed|Pending"
	} 
	<url> 
	    <loc>{title_permalink="news/story"}</loc> 
	    <lastmod>{gmt_edit_date format="{DATE_W3C}"}</lastmod> 
	    <changefreq>weekly</changefreq> 
	    <priority>0.8</priority> 
	</url> 
	{/exp:weblog:entries}
</urlset>