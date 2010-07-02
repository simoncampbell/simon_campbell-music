{assign_variable:this_index_weblog="example"}

{exp:weblog:info weblog="{this_index_weblog}"}
	{embed="lg_better_meta/.head" title="{blog_title}" title_suffix="lg_better_meta/index" description="{blog_description}" }
	<h1>{blog_title} <small> &mdash; Index</small></h1>
{/exp:weblog:info}

<h2>Published entries</h2>

<ol>
	{exp:weblog:entries weblog="{this_index_weblog}"}
	{if no_results}<li class='alert error'>No entries have been created</li>{/if}
	<li>
		<h2><a href="{if page_uri}{page_uri}{if:else}{entry_id_path='lg_better_meta/entry'}{/if}">{title}</a></h2>
		<div class="entry-published">
			<strong>Published:</strong>
			<abbr title="{entry_date format="{DATE_ISO8601}"}">
				<a href="{path=lg_better_meta/monthly-archive}{entry_date format="%Y/%m"}/" title="View monthly archive for: {entry_date format="%M %Y"}">{entry_date format="%D, %F %d, %Y - %g:%i:%s"}</a>
				({relative_date})
			</abbr>
		</div>
		<div class="comments">
			<strong>Comments:</strong>
			<a href="{if page_uri}{page_uri}{if:else}{entry_id_path='lg_better_meta/entry'}{/if}#comments" title="">{comment_total} comment{if "{comment_total}" != "1" }s{/if}</a>
		</div>
	</li>
	{/exp:weblog:entries}
</ol>

{embed="lg_better_meta/.foot"}