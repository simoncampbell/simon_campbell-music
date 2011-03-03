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
            required="username|email"
            screen_name_password_required="no"
        }
            <fieldset>
                <fieldset>
                    <legend>Basic Information</legend>
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
                </fieldset>
                <fieldset>
                    <legend>Billing Information</legend>
                    <div>
                        <label for="profile_address">Street Address</label>
                        <input type="text" id="profile_address" name="mcf_address" value="{mcf_address}" />
                    </div>
                    <div>
                        <label for="profile_address2">Street Address 2</label>
                        <input type="text" id="profile_address2" name="mcf_address2" value="{mcf_address2}" />
                    </div>
                    <div>
                        <label for="profile_city">Town/City</label>
                        <input type="text" id="profile_city" name="mcf_city" value="{mcf_city}" />
                    </div>
                    <div>
                        <label for="profile_state">State (US only)</label>
                        <select id="profile_state" name="mcf_state">
                            <option value="">Select a State</option>
                            {select_mcf_state}
                            <option value="{value}" {selected}>{value}</option>
                            {/select_mcf_state}
                        </select>
                    </div>
                    <div>
                        <label for="profile_zip">Postcode/Zip</label>
                        <input type="text" id="profile_zip" name="mcf_zip" value="{mcf_zip}" />
                    </div>
                    <div>
                        <label for="profile_country_code">Country</label>
                        <select id="profile_country_code" name="mcf_country_code">
                            <option value="">Select a Country</option>
                            {select_mcf_country_code}
                            <option value="{value}" {selected}>{value}</option>
                            {/select_mcf_country_code}
                        </select>
                    </div>
                </fieldset>
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