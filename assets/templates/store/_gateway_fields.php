{!-- DEFAULT GATEWAY FIELDS --}
<fieldset class="billing" id="billing_info">
	<legend>Billing info</legend>
	<p>		
		<label for="first_name" class="required" >First Name</label>
		<input type="text" id="first_name" name="first_name" value="" />
	</p>
	<p>		
		<label for="last_name" class="required" >Last Name</label>
		<input type="text" id="last_name" name="last_name" value="" />
	</p>
	<p>
		<label for="address" class="required" >Street Address</label>
		<input type="text" id="address" name="address" value="" />
	</p>
	<p>
		<label for="address2" >Street Address</label>
		<input type="text" id="address2" name="address2" value="" />
	</p>
	<p>
		<label for="city" class="required" >City</label>
		<input type="text" id="city" name="city" value="" />
	</p>
	<p>
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
	</p>
	<p>
		<label for="zip" class="required" >Zip Code</label>
		<input type="text" id="zip" name="zip" value="" />
	</p>
	<p>
		<label for="country_code" class="required" >Country</label>
		<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes, or the script WILL fail. http://en.wikipedia.org/wiki/ISO_3166-1 -->
		<select name="country_code" id="country_code">
			<option value="CA">Canada</option>
			<option value="GB">United Kingdom</option>
			<option value="US" selected>United States</option>
		</select>
	</p>
</fieldset>
<fieldset class="information" id="additional_info">
	<legend>Additional Information</legend>
	<p>
		<label for="email_address" class="required">Email Address</label>
		<input  id="email_address" type="text" name="email_address" value="" />
	</p>
	<input type="hidden" name="transaction_type" value="_cart" /> 
	<input type="hidden" name="weight_unit" value="lbs">
	<input type="hidden" name="currency_code" value="USD">
</fieldset>