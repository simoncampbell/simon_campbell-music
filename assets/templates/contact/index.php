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
        
        <div id="contact">
            
            <h2>Get in touch!</h2>
        
            {if segment_2 == 'thanks'}
                {lv_contact_form_thanks}
            {if:elseif segment_2 == 'subscribed'}
                {lv_contact_newsletter_thanks}
            {if:else}
                {lv_contact_aside}    
            {/if}
        
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
                        <label for="name">Your name</label>
                        <input id="name" name="name" type="text" />
                    </div>
                    <div>
                        <label for="email">Email address</label>
                        <input id="email" name="email" type="text" />
                    </div>
                    <div>
                        <label for="message">Your message</label>
                        <textarea id="message" name="message"></textarea>
                    </div>
                </fieldset>
                <input class="submit" type="submit" value="Send message" />
            {/exp:freeform:form}<!-- // #contact_form -->
    

        
        </div> <!-- // #contact -->
        
        <div class="contact_block">
            
            <h2>Bookings</h2>
            
            {lv_contact_booking}
        </div> <!-- // #media -->
        
        <div class="contact_block">
            
            <h2>Media</h2>
            <p>Check these Simon Campbell Music goodies!</p>
            {!--
            <ul class="media">
                <li class="pdf">{lv_contact_presskit_text}</li>
            </li>
            --}
            <ul class="media">
                {exp:weblog:entries
                    weblog="media"
                    disable="{pv_disable_default}"
                    dynamic="off"
                    limit="100"
                }
                <li class="{cf_media_file_extension}">
                    <a href="{cf_media_file}">{title}</a> &mdash; {cf_media_file_desc} {if cf_media_file_size != "" && cf_media_file_extension != ""}<span>{cf_media_file_size} .{cf_media_file_extension} download</span>{/if}
                </li>
                {/exp:weblog:entries}
            </ul> <!-- // .media -->
        </div> <!-- // #media -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}