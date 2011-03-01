{embed="_layout/_start"
    body_class="centeredwidth"
    body_id=""
    section="account"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Forgotten your password?"
    title_suffix="Account"   
    title_prefix=""   
    description=""
    keywords=""
    robots_index=""
    robots_follow=""
    robots_archive=""
    canonical_url="/"
}
    
    <div id="content_pri">
        
        <h3>Forgotten password?</h3>
        <div class="first">
        {exp:user:forgot_password
        }
        <fieldset>
            <div>
                <label for="email">Email Address</label>
                <input type="text" class="input" name="email" id="email" size="25" />
            </div>
            <p class="submit">
                <input class="submit" type="submit" name="submit" value="Reset my password" />
            </p>
        </fieldset>
        {/exp:user:forgot_password}
        </div>
        <div class="last">
            <p>We will send you instructions to reset your password.</p>
        </div>
    </div> <!-- // #content_pri -->

{embed="_layout/_end"}