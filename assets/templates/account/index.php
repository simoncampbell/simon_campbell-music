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
            <div class="first">
                <h2>Your account details</h2>
                <div class="account_details clearfix">
                    <p class="more"><a class="button" href="{path='account/update'}">Edit details</a></p>
                    {exp:user:users
                        dynamic="off"
                        group_id="1|5|6"
                        limit="1"
                        member_id="{member_id}"
                    }
                    {!-- not working?????? --}
                    <p>
                        <strong>Name</strong> 
                        {mcf_first_name} {mcf_last_name}
                    </p>
                    <p>
                        <strong>Email address</strong> 
                        {email}
                    </p>
                    <p>
                        <strong>Password</strong> 
                        *********
                    </p>
                    <p>
                        <strong>Delivery Address</strong> 
                        {!--
                        UK ADDRESS
                        - WHAT ARE THESE IN COMPARISON TO US ADDRESS FORMAT?
                        <span>
                            2 North Street<br>
                            Barrow Upon Humber<br>
                            North Lincolnshire<br>
                            DN19 7AP
                        </span>
                        --}
                        {!-- US ADDRESS/CARTHROB DEFAULT --}
                        {if mcf_address}
                        <span>
                            {mcf_address}<br>
                            {if mcf_address2}{mcf_address2}<br>{/if}
                            {mcf_city}, {mcf_state}<br>
                            {mcf_zip}
                        </span>
                        {/if}
                    </p>
                    {/exp:user:users}
                </div>
                <h2>Account settings</h2>
                <form id="account_settings">
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
                        <div class="submit">
                            <input class="submit" type="submit" value="Submit new settings" />
                        </div>
                    </fieldset>
                </form>
            </div><!-- // .first -->
            <div class="last">
                <h2>Your order history</h2>
                <table>
                    <colgroup>
                        <col style="width:20%;"/>
                        <col style="width:20%;"/>
                        <col style="width:30%;"/>
                        <col style="width:30%"/>
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope="col">Order no.</th>
                            <th scope="col">Date</th>
                            <th scope="col">Items</th>
                            <th scope="col">Downloads</th>
                        </tr>
                    </thead>
                    <tbody>
                        {exp:weblog:entries
                            author_id="CURRENT_USER"
                            disable="categories|trackbacks|pagination"
                            limit=""
                            weblog="purchased_items"
                        }
                        <tr>
                            <td><a href="#">#{cf_purchased_order_id}</a></td>
                            <td><time datetime="{entry_date format='{DATE_ATOM}'}">{entry_date format="{pv_date_event}"}</time></td>
                            <td>
                                <span class="item"><a href="#">ThirtySix LP</a></span>, 
                                <span class="item"><a href="#">T-shirt</a></span>
                            </td>
                            <td></td>
                        </tr>
                        {/exp:weblog:entries}
                        {!--
                        <tr>
                            <td><a href="#">#121</a></td>
                            <td><time datetime="">19-02-2011</time></td>
                            <td>
                                <span class="item"><a href="#">ThirtySix digital download</a> WAV &amp; MP3</span>
                            </td>
                            <td>
                                <span class="item music_file"><a href="">mp3</a> ~50mb .zip</span>
                                <span class="item music_file"><a href="">wav</a> ~275mb .zip</span>
                            </td>
                        </tr>
                        --}
                    </tbody>
                </table>
            </div><!-- // .last -->
        {/if}
        
        {if logged_out}
        <p>To purchase items, please log in or create an account.</p>
        <div class="first">
            <h3>Returning customer</h3>
            {exp:member:login_form 
                return="account/index"
            }
                <fieldset>
                    <div>
                        <label for="signin_username">Username</label>
                        <input type="text" id="signin_username" size="30" name="username" value="" />
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
        </div><!-- // .first -->
        <div class="last">
            <h3>New customer</h3>
            {exp:user:register
                admin_register="yes"
                form:class=""
                form:id="register_form"
                group_id="5"
                override_return="account"
                return="account"
                required="username|email|password|password_confirm"
            }
            <fieldset>
                <div>
                    <label for="register_form_username">Username</label>
                    <input type="text" id="register_form_username" size="30" name="username" value="" />
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
        </div><!-- // .last -->
        {/if}
        
    </div> <!-- // #content_pri -->
    
{embed="_layout/_end"}