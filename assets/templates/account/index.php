{embed="_layout/_start"
    body_class="centeredwidth"
    body_id="account_landing"
    section="account"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="{if logged_in}Your account{if:else}Sign-in or register{/if}"
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
        
        {if logged_in}
        
            LOGGED IN - ACCOUNT OVERVIEW
        
        {/if}
        
        {if logged_out}
        
        <p>To purchase items, please log in or create an account.</p>
        
        <div class="half">
            <h3>Returning customer</h3>
            
            {exp:member:login_form 
                return="account/index"
            }
                <fieldset>
                    <div>
                        <label for="signin_username">Username</label>
                        <input type="text" id="signin_username" size="30" name="username" />
                    </div>
                    <div>
                        <label for="signin_password">Password</label>
                        <input type="password" id="signin_password" size="30" name="password" />
                    </div>
                    <div class="submit">
                        <input class="submit" type="submit" value="Sign In" />
                        {if auto_login}
                        <div class="remember">
                            <input type="checkbox" id="signin_remember" name="auto_login" value="1" />
                            <label for="signin_remember">Remember me</label>
                        </div>
                        {/if}
                    </div>
                    <div>
                        <ul class="forgot_details">
                            <li><a href="{pv_site_url}/account/forgotten/">Forgot password?</a></li>
                        </ul>
                    </div>
                </fieldset>
            {/exp:member:login_form}
            
        </div><!-- // .half -->
        <div class="half">
            <h3>New customer</h3>
            
            {exp:user:register
                form:id="register_form" 
                form:class=""
                admin_register="yes"
                override_return="account/pending"
                return="account/pending"
                required="email|password|password_confirm"
            }
            <fieldset>
                <div>
                    <label for="signin_username">Username</label>
                    <input type="text" id="signin_username" size="30" name="username" />
                </div>
                <div>
                    <label for="register_form_email">Email address</label>
                    <input type="text" id="register_form_email" size="30" name="email" value="" />
                </div>
                <div>
                    <label for="register_form_password">Password</label>
                    <input type="password" id="register_form_password" size="30" name="password" />
                </div>
                <div>
                    <label for="register_form_confpassword">Confirm Password</label>
                    <input type="password" id="register_form_confpassword" size="30" name="password_confirm" />
                </div>
                <div class="agree">
                    <input type="checkbox" name="accept_terms" value="y" id="accept_terms" /> 
                    <label for="accept_terms">I agree to the terms of use</label>
                </div>
                <div class="submit">
                    <input class="submit" type="submit" value="Join us." />
                </div>
            </fieldset>
            {/exp:user:register}
            
        </div><!-- // .half -->
        
        {/if}
        
    </div> <!-- // #content_pri -->
    
{embed="_layout/_end"}