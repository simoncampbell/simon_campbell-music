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
            
            <p>If you want to get in touch with Simon&rsquo;s record company for booking details, contact Suzy:</p>
            <address>
                <strong>Suzy Starlite</strong><br />
                Supertone Records<br />
                <a href="mailto:suzy@supertonerecords.com">suzy@supertonerecords.com</a><br />
                +44 7624 245881<br />
            </address>
        </div> <!-- // #media -->
        
        <div class="contact_block">
            
            <h2>Media</h2>
            <p>You press and media types may be interested in the following:</p>
            <ul>
                <li>
                    <a href="#">Media kit</a> <span class="pdf">5mb PDF</span>
                </li>
            </ul>
            
            {!--
            {if lv_contact_presskit_text != ""}
                <p>{lv_contact_presskit_text}</p>
            {/if}
            --}
        </div> <!-- // #media -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}