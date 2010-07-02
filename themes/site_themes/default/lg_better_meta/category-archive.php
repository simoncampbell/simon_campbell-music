{assign_variable:this_index_weblog="example"}

{exp:weblog:category_heading weblog="{this_index_weblog}"}
	{if no_results}{redirect="404"}{/if}
	{embed="lg_better_meta/.head"
		title="{category_name}"
		title_suffix="lg_better_meta/category-archive"
		description="{category_description}"
	}
	<h1>{category_name} <small> &mdash; Category archive</small></h1>
{/exp:weblog:category_heading}

<ol>
	{exp:weblog:entries weblog="{this_index_weblog}"}
	{if no_results}<li class='alert error'>No entries have been created in this category</li>{/if}
	<li>
		<h2><a href="{if page_uri}{page_uri}{if:else}{entry_id_path='lg_better_meta/entry'}{/if}">{title}</a></h2>
		<div class="entry-published">
			<strong>Published:</strong>
			<abbr title="{entry_date format="{DATE_ISO8601}"}">
				<a href="{path=lg_better_meta/monthly-archive}{entry_date format="%Y/%m"}/" title="View monthly archive for: {entry_date format="%M %Y"}">{entry_date format="%D, %F %d, %Y - %g:%i:%s"}</a>
				({relative_date})
			</abbr>
		</div>
		<div>
			<strong>Comments:</strong>
			<a href="{if page_uri}{page_uri}{if:else}{entry_id_path='lg_better_meta/entry'}{url_title}/{/if}#comments" title="">{comment_total} comment{if "{comment_total}" != "1" }s{/if}</a>
		</div>
		<div>
			<strong>Categories:</strong>
			<a href="{if page_uri}{page_uri}{if:else}{entry_id_path='lg_better_meta/entry'}{url_title}/{/if}#comments" title="">{comment_total} comment{if "{comment_total}" != "1" }s{/if}</a>
		</div>
	</li>
	{/exp:weblog:entries}
</ol>

{embed="lg_better_meta/.foot"}