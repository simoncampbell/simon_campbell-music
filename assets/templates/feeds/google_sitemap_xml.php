<?xml version="1.0" encoding="UTF-8"?> 
<urlset xmlns="http://www.google.com/schemas/sitemap/0.84"> 
    {!-- STATIC PAGES --}
    <url> 
        <loc>{homepage}</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.5</priority> 
    </url> 
    <url> 
        <loc>{site_url}/thirtysix/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.7</priority> 
    </url>
    <url> 
        <loc>{site_url}/thirtysix/history/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.7</priority> 
    </url>
    <url> 
        <loc>{site_url}/thirtysix/lyrics/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.7</priority> 
    </url>
    <url> 
        <loc>{site_url}/thirtysix/lyrics-ep/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.7</priority> 
    </url>
    <url> 
        <loc>{site_url}/bio/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.6</priority> 
    </url>
    <url> 
        <loc>{site_url}/bio/gear</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.6</priority> 
    </url>
    <url> 
        <loc>{site_url}/gallery/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>weekly</changefreq> 
        <priority>0.6</priority> 
    </url>
    <url> 
        <loc>{site_url}/contact/</loc> 
        <lastmod>{exp:stats}{last_entry_date format="{DATE_W3C}"}{/exp:stats}</lastmod> 
        <changefreq>monthly</changefreq> 
        <priority>0.4</priority> 
    </url>
    {!-- DYNAMIC PAGES --}
	{exp:weblog:entries 
	    weblog="journal_notes|journal_videos|journal_photos|journal_audio" 
	    limit="50" 
	    disable="{pv_disable_titles}" 
	    rdf="off" 
	    dynamic="off" 
	    status="not Closed"
	} 
	<url> 
	    <loc>{title_permalink="journal/index"}</loc> 
	    <lastmod>{gmt_edit_date format="{DATE_W3C}"}</lastmod> 
	    <changefreq>daily</changefreq> 
	    <priority>1.0</priority> 
	</url> 
	{/exp:weblog:entries}
</urlset>