{!-- DEFAULT GATEWAY FIELDS --}
{exp:member:custom_profile_data}
<fieldset class="billing" id="billing_info">
    <legend>Billing info</legend>
    <div>
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" class="required" name="first_name" value="{mcf_first_name}" />
    </div>
    <div>
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" class="required" name="last_name" value="{mcf_last_name}" />
    </div>
    <div>
        <label for="address">Street Address</label>
        <input type="text" id="address" class="required" name="address" value="{mcf_address}" />
    </div>
    <div>
        <label for="address2">Street Address</label>
        <input type="text" id="address2" name="address2" value="{mcf_address2}" />
    </div>
    <div>
        <label for="city">City</label>
        <input type="text" id="city" class="required" name="city" value="{mcf_city}" />
    </div>
    <div>
        <label for="state">State (US only) </label>
        <select id="state" name="state">
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
        <label for="zip">Zip Code</label>
        <input type="text" id="zip" class="required" name="zip" value="" />
    </div>
    <div>
        <label for="country_code">Country</label>
        {!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 --}
        <select name="country_code" id="country_code">
            <option value="GB">United Kingdom</option>
            <option value="US" selected>United States</option>
            <option value="CA">Canada</option>
        </select>
    </div>
</fieldset>
{/exp:member:custom_profile_data}
<fieldset class="information" id="additional_info">
    <legend>Additional Information</legend>
    <div>
        <label for="email_address">Email Address</label>
        <input  id="email_address" class="required email" type="text" name="email_address" value="{email}" />
    </div>
    <input type="hidden" name="transaction_type" value="_cart" />
    <input type="hidden" name="weight_unit" value="lbs">
    <input type="hidden" name="currency_code" value="USD">
</fieldset>