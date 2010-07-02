{assign_variable:this_index_weblog="example"}

{exp:query sql="SELECT
	DATE_FORMAT('{segment_3}-{segment_4}-01', '%M') as q_archive_month_title,
	DATE_FORMAT('{segment_3}-{segment_4}-01', '%m') as q_archive_month,
	DATE_FORMAT('{segment_3}-{segment_4}-01', '%Y') as q_archive_year
"}

{if q_archive_month == "" || q_archive_year == ""} {redirect="404"} {/if}

{exp:weblog:info weblog="{this_index_weblog}"}
{embed="lg_better_meta/.head"
	title = "{q_archive_month_title} {q_archive_year}"
	title_suffix = "{blog_title} Archives | lg_better_meta/monthly-archive"
	description = "{q_archive_month_title} {q_archive_year} {blog_title} Archives | {blog_description}"
	robots_index="n"
}
{/exp:weblog:info}

<h1>{q_archive_month_title} {q_archive_year} <small>- Monthly archive</small></h1>
<ol>
	{exp:weblog:entries
		cache="yes"
		disable="category_fields|custom_fields|member_data|pagination|trackbacks"
		dynamic="off"
		limit="200"
		refresh="10"
		rdf="off"
		status="not closed|Pending"
		weblog="{this_index_weblog}"
		year="{q_archive_year}"
		month="{q_archive_month}"
	}
	{if no_results}
	<li class="no-results">There were no posts published in {q_archive_month_title} {q_archive_year}.</li>
	{/if}
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
{/exp:query}
