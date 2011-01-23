{embed="_layout/_start"
    body_class=""
    body_id=""
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
        
            <div id="register">
            
                <h3>Create an account</h3>
        
                {exp:user:register
                    form:id="register_form" 
                    form:class=""
                    admin_register="yes"
                    override_return="account/pending"
                    return="account/pending"
                    required="email|password|password_confirm" 
                }
                <fieldset>
                    <p class="note">All fields are required unless stated otherwise.</p>
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
                        <input type="submit" value="Join us." />
                    </div>
        	    </fieldset>
                {/exp:user:register}
        
            </div>
        
            <div id="signin">
            
                <h3>Sign-in to your account</h3>
        
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
                            <input type="submit" value="Sign In" />
                            {if auto_login}
                            <div>
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
	        
    	    </div>
        
        {/if}

    </div> <!-- // #content_pri -->
    
    {embed="_layout/_sidebar"}

{embed="_layout/_end"}