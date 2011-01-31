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
            form:id="contact_form"
            notify="mail@simoncampbell.com"
            return="contact/thanks"
            template="contact_form"
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
            <p>
                <strong>Simon would love to hear from you.</strong> If you’d like to drop him a line, either use the form on this page or drop him a line at <a href="#">mail@simoncampbell.com</a>.
            </p>
            <p>If you want to get in touch with Simon’s agent for booking details, contact Suzy:</p>
            <address>
                <strong>Suzy Starlit</strong><br>
                Starlite Events &amp; Project Management<br>
                <a href="#">suzy@starlite-events.net</a><br>
                +44 7658 734 456<br>
            </address>
        </div><!-- // #form_aside -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}