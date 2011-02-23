{embed="_layout/_start"
    body_class="{if logged_in}fullwidth{if:else}centeredwidth{/if}"
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
        
            <h1>My account</h1>
            
            <div class="half">
                <h2>Your account details</h2>
                <div class="account_details">
                    <p class="more"><a href="#">Edit details</a></p>
                    <div>
                        <strong>Full Name</strong> 
                        James Willock
                    </div>
                    <div>
                        <strong>Email address</strong> 
                        james.willock@gmail.com
                    </div>
                    <div>
                        <strong>Password</strong> 
                        *********
                    </div>
                    <div>
                        <strong>Delivery Address</strong> 
                        2 North Street<br>
                        Barrow Upon Humber<br>
                        North Lincolnshire<br>
                        DN19 7AP
                    </div>
                </div>
                <form class="account_details">
                    <fieldset>
                        <div>
                            <label for="">Full Name</label>
                            <input type="text" id="" size="30" name="" value="" />
                        </div>
                        <div>
                            <label for="register_form_email">Email address</label>
                            <input type="text" id="register_form_email" size="30" name="email" value="" />
                        </div>
                        <div>
                            <label for="">Delivery Address</label>
                            <textarea id="" cols="30" rows="7"></textarea>
                        </div>
                        <div>
                            <label for="register_form_password">New Password</label>
                            <input type="password" id="register_form_password" size="30" name="password" value="" />
                        </div>
                        <div>
                            <label for="register_form_confpassword">Confirm New Password</label>
                            <input type="password" id="register_form_confpassword" size="30" name="" />
                        </div>
                        <div>
                            <label for="register_form_confpassword">Current Password <em>Required to make changes</em></label>
                            <input type="password" id="register_form_confpassword" size="30" name="" />
                        </div>
                    </fieldset>
                </form>
                
                <h2>Account settings</h2>
                <form>
                    <fieldset>
                        <div>
                            <strong>Newsletter</strong>
                            <input type="checkbox" id="" name="" />
                            <label for="">Subscribe to the Newsletter</label>
                        </div>
                        <div>
                            <strong>Special Offers</strong>
                            <input type="checkbox" id="" name="" />
                            <label for="">Remember me</label>
                        </div>
                    </fieldset>
                </form>
            </div><!-- // .half -->
            
            <div class="half">
                <h2>Your order history</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Order no.</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Downloads</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><a href="#">#145</a></td>
                            <td><time datetime="">23-02-2011</time></td>
                            <td>
                                <span class="item"><a href="#">This is the product title.</a></span>
                            </td>
                            <td>
                                <span class="item"><a href="#">mp3</a> ~50mb .zip</span>
                                <span class="item"><a href="#">wav</a> ~275mb .zip</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div><!-- // .half -->
        
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