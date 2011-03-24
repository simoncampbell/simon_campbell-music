{embed="_layout/_start"
    body_class="centeredwidth"
    body_id=""
    section=""
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Newsletter"
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
        <div class="half">
            {if segment_2 == 'thanks'}
            <h3>Thanks!</h3>
            <p>Thanks for subscribing to the Simon Campbell Music newsletter! You'll receive all the latest news and goodies very soon!</p>
            {/if}
            {if segment_2 == ''}
            <p>
                If you want to keep up with the latest news from Simon, including some free goodies, please sign up to his newsletter.
            </p>
            {/if}
        </div>
        <div class="half">
            {if segment_2 == ''}
            <h3>Newsletter sign up</h3>
            <form class="validate_inline" action="http://erskine.createsend.com/t/r/s/bxdii/" method="post">
                <fieldset>
                    <div>
                        <label for="cm-bxdii-bxdii">Email Address</label>
                        <input type="text" name="cm-bxdii-bxdii" id="bxdii-bxdii" class="required email">
                    </div>
                </fieldset>
                <input type="submit" value="Subscribe" class="submit" />
            </form>
            {/if}
        </div>
    </div> <!-- // #content_pri -->

{embed="_layout/_end"}