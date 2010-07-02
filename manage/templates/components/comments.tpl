<div id="comments">
    
    <h2>{if embed:comment_total == "0"}Start a discussion...{if:else}Discussion{/if}</h2>
    
	{exp:comment:entries sort="asc" limit="20" entry_id="{embed:entry_id}"}
    <ol id="comment_listing">
        <li id="comment-{comment_id}">
            <p class="comment_author"><strong>{url_as_author}</strong> {comment_date format="{pv_date_full}"}</p>
            {comment}
 		</li>
    </ol>
	{/exp:comment:entries}
	
    <h3>Add your comment</h3>

	{exp:comment:form entry_id="{embed:entry_id}"}
	<fieldset>

    	<div>
        	<label for="comment_name">Your name:</label>
        	<input type="text" id="comment_name" name="name" value="{name}" />
    	</div>
    	<div>
        	<label for="comment_email">Email address:</label>
        	<input type="text" id="comment_email" name="email" value="{email}" />
    	</div>
    	<div>
        	<label for="comment_url">URL:</label>
        	<input type="text" id="comment_url" name="url" value="{url}" />
    	</div>

    	<div>
        	<label for="comment_comment">Message:</label>
        	<textarea id="comment_comment" rows="10" cols="15" name="comment">{comment}</textarea>
    	</div>
    	<div>
			<input type="hidden" name="save_info" value="yes" {save_info} />
			<input type="hidden" name="notify_me" value="yes" {notify_me} />
        	<input type="image" src="{pv_site_url}/assets/images/site/comment_form_submit.gif" />
    	</div>

	</fieldset>
	{/exp:comment:form} 
    
</div>