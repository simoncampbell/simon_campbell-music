{!-- DEFAULT GATEWAY FIELDS
    (For the future, we could make this a shared embed w/ the account edit form)
--}
{exp:user:stats
    dynamic="off"
    log_views="off"
    member_id="CURRENT_USER"
}
<fieldset class="billing" id="billing_info">
    <legend>Billing info</legend>
    <div>
        <label for="first_name">First Name</label>
        <input type="text" id="first_name" name="mcf_first_name" value="{mcf_first_name}" />
    </div>
    <div>
        <label for="last_name">Last Name</label>
        <input type="text" id="last_name" name="mcf_last_name" value="{mcf_last_name}" />
    </div>
    <div>
        <label for="address">Street Address</label>
        <input type="text" id="address" name="mcf_address" value="{mcf_address}" />
    </div>
    <div>
        <label for="address2">Street Address</label>
        <input type="text" id="address2" name="mcf_address2" value="{mcf_address2}" />
    </div>
    <div>
        <label for="city">Town/City</label>
        <input type="text" id="city" name="mcf_city" value="{mcf_city}" />
    </div>
    <div>
        
        <label for="state">State (US only)</label>
        <select id="state" name="mcf_state">
            <option value="">Select a State</option>
            {select_mcf_state}
            <option value="{value}" {selected}>{value}</option>
            {/select_mcf_state}
        </select>
    </div>
    <div>
        <label for="zip">Postcode/Zip</label>
        <input type="text" id="zip" name="mcf_zip" value="{mcf_zip}" />
    </div>
    <div>
        <label for="country_code">Country</label>
        {!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 --}
        <select id="country_code" name="mcf_country_code">
            <option value="">Select a Country</option>
            {select_mcf_country_code}
            <option value="{value}" {selected}>{value}</option>
            {/select_mcf_country_code}
        </select>
    </div>
</fieldset>
<fieldset class="information" id="additional_info">
    <legend>Additional Information</legend>
    <div>
        <label for="email_address">Email Address</label>
        <input  id="email_address" type="text" name="email" value="{email}" />
    </div>
    <input type="hidden" name="transaction_type" value="_cart" />
    <input type="hidden" name="weight_unit" value="lbs">
    <input type="hidden" name="currency_code" value="GBP">
</fieldset>
{/exp:user:stats}