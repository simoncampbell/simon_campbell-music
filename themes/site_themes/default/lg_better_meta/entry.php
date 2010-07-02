{assign_variable:this_index_weblog="example"}
{exp:weblog:entries
	weblog="{this_index_weblog}"
	limit="1"
	require_entry="yes"
	status="not closed"
}
{if no_results}{redirect="404"}{/if}

{embed="lg_better_meta/.head" entry_id="{entry_id}" title_suffix="lg_better_meta/entry"}

<h1>{title} <small> &mdash; Entry details</small></h1>

<div class="entry-meta">
	<div class="entry-published">
		<strong>Published:</strong>
		<abbr title="{entry_date format="{DATE_ISO8601}"}" class="published">
			<a href="{path=lg_better_meta/monthly-archive}{entry_date format="%Y/%m"}/" title="View monthly archive for: {entry_date format="%M %Y"}">{entry_date format="%D, %F %d, %Y - %g:%i:%s"}</a>
			({relative_date})
		</abbr>
	</div>

	<div class="comments">
		<strong>Comments:</strong>
		<a href="{if page_uri}{page_uri}{if:else}{entry_id_path='lg_better_meta/entry'}{/if}#comments" title="">{comment_total} comment{if "{comment_total}" != "1" }s{/if}</a>
	</div>

	{if edit_date}
	<div class="entry-updated">
		<strong>Last Modified:</strong>
		<abbr title="{edit_date format="{DATE_ISO8601}"}" class="updated pretty-date">{edit_date format="%D, %F %d, %Y - %g:%i:%s"} ({relative_date})</abbr>
	</div>
	{/if}

	{if expiration_date}
	<div class="entry-expires">
		<strong>Expires:</strong>
		<abbr title="{expiration_date format="{DATE_ISO8601}"}" class="expires pretty-date">{expiration_date format="%D, %F %d, %Y - %g:%i:%s"} ({relative_date})</abbr>
	</div>
	{/if}

	{if "{categories}{category_id}{/categories}"}
	<div class="categories">
		<strong>Categories:</strong>
		<ul>
			{categories}
			<li><a href="{path=lg_better_meta/category-archive}" title="Browse {category_name}" rel="tag">{category_name}</a></li>
			{/categories}
		</ul>
	</div>
	{/if}
</div>
{embed="lg_better_meta/.foot"}
{/exp:weblog:entries}