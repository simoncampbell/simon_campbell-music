{embed="_layout/_start"
    body_class=""
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
        
        <form id="contact_form" action="" autocomplete="">
            <fieldset>
                <ol>
                    <li>
                        <label for="name">Text Field <em>*</em></label><br>
                        <input id="name" name="name" type="text">
                    </li>
                    <li>
                        <label for="email">Email Address <em>*</em></label><br>
                        <input id="email" name="email" type="text">
                    </li>
                    <li>
                        <label for="message">Message <em>*</em></label><br>
                        <textarea id="message" name="message"></textarea>
                        <div>Total characters left: <span id="counter"></span></div>
                    </li>
                </ol>
            </fieldset>
            <input type="submit" value="Send message">
        </form><!-- // #contact_form -->
        <div id="form_aside">
            <p>
                Simon would love to hear from you. If you’d like to drop him a line, either use the form on this page or drop him a line at me@simoncampbell.com.
            </p>
            <p>If you want to get in touch with Simon’s agent for booking details, contact Suzy:</p>
            <address>
                Suzy Starlit<br>
                Starlite Events &amp; Project Management<br>
                suzy@starlite-events.net<br>
                +44 7658 734 456<br>
            </address>
        </div><!-- // #form_aside -->
        
    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}