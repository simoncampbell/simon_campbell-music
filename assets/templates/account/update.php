{embed="_layout/_start"
    body_class="centeredwidth profile_edit"
    body_id=""
    section="account"
    {!-- LG BETTER META OPTIONS BELOW --}
    title="Update your details"
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
        <h3>Edit Profile</h3>
        {!-- Need to fix the layout --}
        {exp:user:edit
            allowed_groups="1|5|6"
            dynamic="off"
            error_page=""
            form:id="profile_edit"
            return="account"
            required="username|mcf_first_name|mcf_last_name|email"
            screen_name_password_required="no"
        }
            <fieldset>
                <div>
                    <label for="profile_username">Username</label>
                    <input type="text" id="profile_username" name="username" value="{username}" />
                </div>
                <div>
                    <label for="profile_firstname">First Name</label>
                    <input type="text" id="profile_firstname" name="mcf_first_name" value="{mcf_first_name}" />
                </div>
                <div>
                    <label for="profile_lastname">Last Name</label>
                    <input type="text" id="profile_lastname" name="mcf_last_name" value="{mcf_last_name}" />
                </div>
                <div>
                    <label for="profile_email">Email address</label>
                    <input type="text" id="profile_email" name="email" value="{email}" />
                </div>
                
                <div>
                    <label for="profile_address">Address</label>
                    <input type="text" id="profile_address" name="mcf_address" value="{mcf_address}" />
                </div>
                <div>
                    <label for="profile_address2">Address 2</label>
                    <input type="text" id="profile_address2" name="mcf_address2" value="{mcf_address2}" />
                </div>
                <div>
                    <label for="profile_city">Town/City</label>
                    <input type="text" id="profile_city" name="mcf_city" value="{mcf_city}" />
                </div>
                <div>
                    <label for="profile_state">State (US only)</label>
                    <select id="profile_state" name="mcf_state" value="{mcf_state}">
                        <option value="AK">Alaska</option>
                        <option value="AL">Alabama</option>
                        <option value="AR">Arkansas</option>
                        <option value="AZ">Arizona</option>
                        <option value="CA">California</option>
                        <option value="CO">Colorado</option>
                        <option value="CT">Connecticut</option>
                        <option value="DC">District of Columbia</option>
                        <option value="DE">Delaware</option>
                        <option value="FL">Florida</option>
                        <option value="GA">Georgia</option>
                        <option value="HI">Hawaii</option>
                        <option value="IA">Iowa</option>
                        <option value="ID">Idaho</option>
                        <option value="IL">Illinois</option>
                        <option value="IN">Indiana</option>
                        <option value="KS">Kansas</option>
                        <option value="KY">Kentucky</option>
                        <option value="LA">Louisiana</option>
                        <option value="MA">Massachusetts</option>
                        <option value="MD">Maryland</option>
                        <option value="ME">Maine</option>
                        <option value="MI">Michigan</option>
                        <option value="MN">Minnesota</option>
                        <option value="MO">Missouri</option>
                        <option value="MS">Mississippi</option>
                        <option value="MT">Montana</option>
                        <option value="NC">North Carolina</option>
                        <option value="ND">North Dakota</option>
                        <option value="NE">Nebraska</option>
                        <option value="NH">New Hampshire</option>
                        <option value="NJ">New Jersey</option>
                        <option value="NM">New Mexico</option>
                        <option value="NV">Nevada</option>
                        <option value="NY">New York</option>
                        <option value="OH">Ohio</option>
                        <option value="OK">Oklahoma</option>
                        <option value="OR">Oregon</option>
                        <option value="PA">Pennsylvania</option>
                        <option value="PR">Puerto Rico</option>
                        <option value="RI">Rhode Island</option>
                        <option value="SC">South Carolina</option>
                        <option value="SD">South Dakota</option>
                        <option value="TN">Tennessee</option>
                        <option value="TX">Texas</option>
                        <option value="UT">Utah</option>
                        <option value="VA">Virginia</option>
                        <option value="VT">Vermont</option>
                        <option value="WA">Washington</option>
                        <option value="WI">Wisconsin</option>
                        <option value="WV">West Virginia</option>
                        <option value="WY">Wyoming</option>
                    </select>
                </div>
                <div>
                    <label for="profile_zip">Postcode/Zip</label>
                    <input type="text" id="profile_zip" name="mcf_zip" value="{mcf_zip}" />
                </div>
                <fieldset class="password">
                    <legend>Change Password <em>(Optional)</em></legend>
                    <div>
                        <label for="profile-new-password">New Password</label>
                        <input type="password" id="profile-new-password" name="password" value="" />
                    </div>
                    <div>
                        <label for="profile-new-password-confirm">Password Confirm</label>
                        <input type="password" id="profile-new-password-confirm" name="password_confirm" value="" />
                    </div>
                    <div>
                        <label for="profile-existing-password">Existing Password</label>
                        <input type="password" id="profile-existing-password" name="current_password" value="" />
                    </div>
                </fieldset>
                <input class="submit" type="submit" value="Update" id="profile-action" />
                
            </fieldset>
            {/exp:user:edit}
        
    </div> <!-- // #content_pri -->

{embed="_layout/_end"}