{embed="_layout/_start"
    body_class="contact"
    body_id=""
    section="contact"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Contact"
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
        
        {exp:freeform:form
            notify="mail@simoncampbell.com"
            required="name|email|message"
            return="contact/thanks"
            send_user_email="yes"
            template="contact_form"
            user_email_template="contact_form_user"
        }
            <fieldset>
                <div>
                    <label for="name">Name</label>
                    <input id="name" name="name" type="text">
                </div>
                <div>
                    <label for="email">Email Address</label>
                    <input id="email" name="email" type="text">
                </div>
                <div>
                    <label for="message">Message</label>
                    <textarea id="message" name="message"></textarea>
                </div>
            </fieldset>
            <input class="submit" type="submit" value="Send message">
        {/exp:freeform:form}<!-- // #contact_form -->
        
        <div id="form_aside">
        {if segment_2 == 'thanks'}
            {lv_contact_form_thanks}
        {if:elseif segment_2 == 'subscribed'}
            {lv_contact_newsletter_thanks}
        {if:else}
            {lv_contact_aside}
        {/if}
        </div><!-- // #form_aside -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}