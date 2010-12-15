<?php
global $LANG; 

$gateway_info = array(
	'title' => $LANG->line('anz_egate_title'),
	'classname' => 'Cartthrob_anz_egate',
	'affiliate' => '', 
	'overview' => $LANG->line('anz_egate_overview'),
	'settings' => array(
		array(
			'name' => $LANG->line('anz_egate_access_code'),
			'short_name' => 'access_code',
			'type' => 'text'
		),
		array(
			'name' => $LANG->line('anz_egate_merchant_id'),
			'short_name' => 'merchant_id',
			'type' => 'text'
		),
	),
	'required_fields' => array(
		'first_name',
		'last_name',
		'address',
		'city',
		'state',
		'zip',
		'phone',
		'email_address',
		'credit_card_number',
		'expiration_year',
		'expiration_month',
	),
	'html' => '<fieldset class="billing" id="billing_info">
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
			<label for="city" class="required" >Town/City</label>
			<input type="text" id="city" name="city" value="" />
		</p>
		<p>
			<label for="zip" class="required" >Post Code</label>
			<input type="text" id="zip" name="zip" value="" />
		</p>
		<p>
			<label for="country_code" class="required" >Country</label>
			<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes http://en.wikipedia.org/wiki/ISO_3166-1 -->
			<select  id="country_code" name="country_code">
				<option selected value="AU">Australia</option>
				<option value="NZ">New Zealand</option>
				<option value="GB">Great Britain</option>
				<option value="US">United States</option>
				<option value="CA">Canada</option>
				<option value="">----------</option>
				<option value="AF">Afghanistan</option>
				<option value="AL">Albania</option>
				<option value="DZ">Algeria</option>
				<option value="AS">American Samoa</option>
				<option value="AD">Andorra</option>
				<option value="AO">Angola</option>
				<option value="AI">Anguilla</option>
				<option value="AQ">Antarctica</option>
				<option value="AG">Antigua and Barbuda</option>
				<option value="AR">Argentina</option>
				<option value="AM">Armenia</option>
				<option value="AW">Aruba</option>
				<option value="AU">Australia</option>
				<option value="AT">Austria</option>
				<option value="AZ">Azerbaidjan</option>
				<option value="BS">Bahamas</option>
				<option value="BH">Bahrain</option>
				<option value="BD">Bangladesh</option>
				<option value="BB">Barbados</option>
				<option value="BY">Belarus</option>
				<option value="BE">Belgium</option>
				<option value="BZ">Belize</option>
				<option value="BJ">Benin</option>
				<option value="BM">Bermuda</option>
				<option value="BT">Bhutan</option>
				<option value="BO">Bolivia</option>
				<option value="BA">Bosnia-Herzegovina</option>
				<option value="BW">Botswana</option>
				<option value="BV">Bouvet Island</option>
				<option value="BR">Brazil</option>
				<option value="IO">British Indian Ocean Territory</option>
				<option value="BN">Brunei Darussalam</option>
				<option value="BG">Bulgaria</option>
				<option value="BF">Burkina Faso</option>
				<option value="BI">Burundi</option>
				<option value="KH">Cambodia</option>
				<option value="CM">Cameroon</option>
				<option value="CV">Cape Verde</option>
				<option value="KY">Cayman Islands</option>
				<option value="CF">Central African Republic</option>
				<option value="TD">Chad</option>
				<option value="CL">Chile</option>
				<option value="CN">China</option>
				<option value="CX">Christmas Island</option>
				<option value="CC">Cocos (Keeling) Islands</option>
				<option value="CO">Colombia</option>
				<option value="KM">Comoros</option>
				<option value="CG">Congo</option>
				<option value="CK">Cook Islands</option>
				<option value="CR">Costa Rica</option>
				<option value="HR">Croatia</option>
				<option value="CU">Cuba</option>
				<option value="CY">Cyprus</option>
				<option value="CZ">Czech Republic</option>
				<option value="DK">Denmark</option>
				<option value="DJ">Djibouti</option>
				<option value="DM">Dominica</option>
				<option value="DO">Dominican Republic</option>
				<option value="TP">East Timor</option>
				<option value="EC">Ecuador</option>
				<option value="EG">Egypt</option>
				<option value="SV">El Salvador</option>
				<option value="GQ">Equatorial Guinea</option>
				<option value="ER">Eritrea</option>
				<option value="EE">Estonia</option>
				<option value="ET">Ethiopia</option>
				<option value="FK">Falkland Islands</option>
				<option value="FO">Faroe Islands</option>
				<option value="FJ">Fiji</option>
				<option value="FI">Finland</option>
				<option value="CS">Former Czechoslovakia</option>
				<option value="SU">Former USSR</option>
				<option value="FR">France</option>
				<option value="FX">France (European Territory)</option>
				<option value="GF">French Guyana</option>
				<option value="TF">French Southern Territories</option>
				<option value="GA">Gabon</option>
				<option value="GM">Gambia</option>
				<option value="GE">Georgia</option>
				<option value="DE">Germany</option>
				<option value="GH">Ghana</option>
				<option value="GI">Gibraltar</option>
				<option value="GB">Great Britain</option>
				<option value="GR">Greece</option>
				<option value="GL">Greenland</option>
				<option value="GD">Grenada</option>
				<option value="GP">Guadeloupe (French)</option>
				<option value="GU">Guam (USA)</option>
				<option value="GT">Guatemala</option>
				<option value="GN">Guinea</option>
				<option value="GW">Guinea Bissau</option>
				<option value="GY">Guyana</option>
				<option value="HT">Haiti</option>
				<option value="HM">Heard and McDonald Islands</option>
				<option value="HN">Honduras</option>
				<option value="HK">Hong Kong</option>
				<option value="HU">Hungary</option>
				<option value="IS">Iceland</option>
				<option value="IN">India</option>
				<option value="ID">Indonesia</option>
				<option value="INT">International</option>
				<option value="IR">Iran</option>
				<option value="IQ">Iraq</option>
				<option value="IE">Ireland</option>
				<option value="IL">Israel</option>
				<option value="IT">Italy</option>
				<option value="CI">Ivory Coast (Cote D&#39;Ivoire)</option>
				<option value="JM">Jamaica</option>
				<option value="JP">Japan</option>
				<option value="JO">Jordan</option>
				<option value="KZ">Kazakhstan</option>
				<option value="KE">Kenya</option>
				<option value="KI">Kiribati</option>
				<option value="KW">Kuwait</option>
				<option value="KG">Kyrgyzstan</option>
				<option value="LA">Laos</option>
				<option value="LV">Latvia</option>
				<option value="LB">Lebanon</option>
				<option value="LS">Lesotho</option>
				<option value="LR">Liberia</option>
				<option value="LY">Libya</option>
				<option value="LI">Liechtenstein</option>
				<option value="LT">Lithuania</option>
				<option value="LU">Luxembourg</option>
				<option value="MO">Macau</option>
				<option value="MK">Macedonia</option>
				<option value="MG">Madagascar</option>
				<option value="MW">Malawi</option>
				<option value="MY">Malaysia</option>
				<option value="MV">Maldives</option>
				<option value="ML">Mali</option>
				<option value="MT">Malta</option>
				<option value="MH">Marshall Islands</option>
				<option value="MQ">Martinique (French)</option>
				<option value="MR">Mauritania</option>
				<option value="MU">Mauritius</option>
				<option value="YT">Mayotte</option>
				<option value="MX">Mexico</option>
				<option value="FM">Micronesia</option>
				<option value="MD">Moldavia</option>
				<option value="MC">Monaco</option>
				<option value="MN">Mongolia</option>
				<option value="MS">Montserrat</option>
				<option value="MA">Morocco</option>
				<option value="MZ">Mozambique</option>
				<option value="MM">Myanmar</option>
				<option value="NA">Namibia</option>
				<option value="NR">Nauru</option>
				<option value="NP">Nepal</option>
				<option value="NL">Netherlands</option>
				<option value="AN">Netherlands Antilles</option>
				<option value="NT">Neutral Zone</option>
				<option value="NC">New Caledonia (French)</option>
				<option value="NZ">New Zealand</option>
				<option value="NI">Nicaragua</option>
				<option value="NE">Niger</option>
				<option value="NG">Nigeria</option>
				<option value="NU">Niue</option>
				<option value="NF">Norfolk Island</option>
				<option value="KP">North Korea</option>
				<option value="MP">Northern Mariana Islands</option>
				<option value="NO">Norway</option>
				<option value="OM">Oman</option>
				<option value="PK">Pakistan</option>
				<option value="PW">Palau</option>
				<option value="PA">Panama</option>
				<option value="PG">Papua New Guinea</option>
				<option value="PY">Paraguay</option>
				<option value="PE">Peru</option>
				<option value="PH">Philippines</option>
				<option value="PN">Pitcairn Island</option>
				<option value="PL">Poland</option>
				<option value="PF">Polynesia (French)</option>
				<option value="PT">Portugal</option>
				<option value="PR">Puerto Rico</option>
				<option value="QA">Qatar</option>
				<option value="RE">Reunion (French)</option>
				<option value="RO">Romania</option>
				<option value="RU">Russian Federation</option>
				<option value="RW">Rwanda</option>
				<option value="GS">S. Georgia & S. Sandwich Isls.</option>
				<option value="SH">Saint Helena</option>
				<option value="KN">Saint Kitts & Nevis Anguilla</option>
				<option value="LC">Saint Lucia</option>
				<option value="PM">Saint Pierre and Miquelon</option>
				<option value="ST">Saint Tome (Sao Tome) and Principe</option>
				<option value="VC">Saint Vincent & Grenadines</option>
				<option value="WS">Samoa</option>
				<option value="SM">San Marino</option>
				<option value="SA">Saudi Arabia</option>
				<option value="SN">Senegal</option>
				<option value="SC">Seychelles</option>
				<option value="SL">Sierra Leone</option>
				<option value="SG">Singapore</option>
				<option value="SK">Slovak Republic</option>
				<option value="SI">Slovenia</option>
				<option value="SB">Solomon Islands</option>
				<option value="SO">Somalia</option>
				<option value="ZA">South Africa</option>
				<option value="KR">South Korea</option>
				<option value="ES">Spain</option>
				<option value="LK">Sri Lanka</option>
				<option value="SD">Sudan</option>
				<option value="SR">Suriname</option>
				<option value="SJ">Svalbard and Jan Mayen Islands</option>
				<option value="SZ">Swaziland</option>
				<option value="SE">Sweden</option>
				<option value="CH">Switzerland</option>
				<option value="SY">Syria</option>
				<option value="TJ">Tadjikistan</option>
				<option value="TW">Taiwan</option>
				<option value="TZ">Tanzania</option>
				<option value="TH">Thailand</option>
				<option value="TG">Togo</option>
				<option value="TK">Tokelau</option>
				<option value="TO">Tonga</option>
				<option value="TT">Trinidad and Tobago</option>
				<option value="TN">Tunisia</option>
				<option value="TR">Turkey</option>
				<option value="TM">Turkmenistan</option>
				<option value="TC">Turks and Caicos Islands</option>
				<option value="TV">Tuvalu</option>
				<option value="UG">Uganda</option>
				<option value="UA">Ukraine</option>
				<option value="AE">United Arab Emirates</option>
				<option value="GB">United Kingdom</option>
				<option value="UY">Uruguay</option>
				<option value="MIL">USA Military</option>
				<option value="UM">USA Minor Outlying Islands</option>
				<option value="UZ">Uzbekistan</option>
				<option value="VU">Vanuatu</option>
				<option value="VA">Vatican City State</option>
				<option value="VE">Venezuela</option>
				<option value="VN">Vietnam</option>
				<option value="VG">Virgin Islands (British)</option>
				<option value="VI">Virgin Islands (USA)</option>
				<option value="WF">Wallis and Futuna Islands</option>
				<option value="EH">Western Sahara</option>
				<option value="YE">Yemen</option>
				<option value="YU">Yugoslavia</option>
				<option value="ZR">Zaire</option>
				<option value="ZM">Zambia</option>
				<option value="ZW">Zimbabwe</option>
			</select>
		</p>
	</fieldset>

	<fieldset class="shipping" id="shipping_info">
		<legend>Shipping Details</legend>
		<p>
			<label for="shipping_first_name"  >First Name</label>
			<input id="shipping_first_name" type="text" name="shipping_first_name" value="" />
		</p>
		<p>
			<label for="shipping_last_name"  >Last Name</label>
			<input id="shipping_last_name" type="text" name="shipping_last_name" value="" />
		</p>
		<p>
			<label for="shipping_address"   >Street Address</label>
			<input id="shipping_address"  type="text" name="shipping_address" value="" />
		</p>
		<p>
			<label for="shipping_address2" >Street Address</label>
			<input id="shipping_address2"  type="text" name="shipping_address2" value="" />
		</p>
		<p>
			<label for="shipping_city"  >Town/City</label>
			<input id="shipping_city"  type="text" name="shipping_city" value="" />
		</p>

		<p>
			<label for="shipping_zip"  >Post Code</label>
			<input type="text" name="shipping_zip" id="shipping_zip" value="" />
		</p>
		<p>
			<label for="shipping_country_code" class="required" >Country</label>
			<!-- the values added here MUST be valid Alpha-2 (2 character) ISO_3166 codes http://en.wikipedia.org/wiki/ISO_3166-1 -->
			<select  id="shipping_country_code" name="shipping_country_code">
				<option selected value="AU">Australia</option>
				<option value="NZ">New Zealand</option>
				<option value="GB">Great Britain</option>
				<option value="US">United States</option>
				<option value="CA">Canada</option>
				<option value="">----------</option>
				<option value="AF">Afghanistan</option>
				<option value="AL">Albania</option>
				<option value="DZ">Algeria</option>
				<option value="AS">American Samoa</option>
				<option value="AD">Andorra</option>
				<option value="AO">Angola</option>
				<option value="AI">Anguilla</option>
				<option value="AQ">Antarctica</option>
				<option value="AG">Antigua and Barbuda</option>
				<option value="AR">Argentina</option>
				<option value="AM">Armenia</option>
				<option value="AW">Aruba</option>
				<option value="AU">Australia</option>
				<option value="AT">Austria</option>
				<option value="AZ">Azerbaidjan</option>
				<option value="BS">Bahamas</option>
				<option value="BH">Bahrain</option>
				<option value="BD">Bangladesh</option>
				<option value="BB">Barbados</option>
				<option value="BY">Belarus</option>
				<option value="BE">Belgium</option>
				<option value="BZ">Belize</option>
				<option value="BJ">Benin</option>
				<option value="BM">Bermuda</option>
				<option value="BT">Bhutan</option>
				<option value="BO">Bolivia</option>
				<option value="BA">Bosnia-Herzegovina</option>
				<option value="BW">Botswana</option>
				<option value="BV">Bouvet Island</option>
				<option value="BR">Brazil</option>
				<option value="IO">British Indian Ocean Territory</option>
				<option value="BN">Brunei Darussalam</option>
				<option value="BG">Bulgaria</option>
				<option value="BF">Burkina Faso</option>
				<option value="BI">Burundi</option>
				<option value="KH">Cambodia</option>
				<option value="CM">Cameroon</option>
				<option value="CV">Cape Verde</option>
				<option value="KY">Cayman Islands</option>
				<option value="CF">Central African Republic</option>
				<option value="TD">Chad</option>
				<option value="CL">Chile</option>
				<option value="CN">China</option>
				<option value="CX">Christmas Island</option>
				<option value="CC">Cocos (Keeling) Islands</option>
				<option value="CO">Colombia</option>
				<option value="KM">Comoros</option>
				<option value="CG">Congo</option>
				<option value="CK">Cook Islands</option>
				<option value="CR">Costa Rica</option>
				<option value="HR">Croatia</option>
				<option value="CU">Cuba</option>
				<option value="CY">Cyprus</option>
				<option value="CZ">Czech Republic</option>
				<option value="DK">Denmark</option>
				<option value="DJ">Djibouti</option>
				<option value="DM">Dominica</option>
				<option value="DO">Dominican Republic</option>
				<option value="TP">East Timor</option>
				<option value="EC">Ecuador</option>
				<option value="EG">Egypt</option>
				<option value="SV">El Salvador</option>
				<option value="GQ">Equatorial Guinea</option>
				<option value="ER">Eritrea</option>
				<option value="EE">Estonia</option>
				<option value="ET">Ethiopia</option>
				<option value="FK">Falkland Islands</option>
				<option value="FO">Faroe Islands</option>
				<option value="FJ">Fiji</option>
				<option value="FI">Finland</option>
				<option value="CS">Former Czechoslovakia</option>
				<option value="SU">Former USSR</option>
				<option value="FR">France</option>
				<option value="FX">France (European Territory)</option>
				<option value="GF">French Guyana</option>
				<option value="TF">French Southern Territories</option>
				<option value="GA">Gabon</option>
				<option value="GM">Gambia</option>
				<option value="GE">Georgia</option>
				<option value="DE">Germany</option>
				<option value="GH">Ghana</option>
				<option value="GI">Gibraltar</option>
				<option value="GB">Great Britain</option>
				<option value="GR">Greece</option>
				<option value="GL">Greenland</option>
				<option value="GD">Grenada</option>
				<option value="GP">Guadeloupe (French)</option>
				<option value="GU">Guam (USA)</option>
				<option value="GT">Guatemala</option>
				<option value="GN">Guinea</option>
				<option value="GW">Guinea Bissau</option>
				<option value="GY">Guyana</option>
				<option value="HT">Haiti</option>
				<option value="HM">Heard and McDonald Islands</option>
				<option value="HN">Honduras</option>
				<option value="HK">Hong Kong</option>
				<option value="HU">Hungary</option>
				<option value="IS">Iceland</option>
				<option value="IN">India</option>
				<option value="ID">Indonesia</option>
				<option value="INT">International</option>
				<option value="IR">Iran</option>
				<option value="IQ">Iraq</option>
				<option value="IE">Ireland</option>
				<option value="IL">Israel</option>
				<option value="IT">Italy</option>
				<option value="CI">Ivory Coast (Cote D&#39;Ivoire)</option>
				<option value="JM">Jamaica</option>
				<option value="JP">Japan</option>
				<option value="JO">Jordan</option>
				<option value="KZ">Kazakhstan</option>
				<option value="KE">Kenya</option>
				<option value="KI">Kiribati</option>
				<option value="KW">Kuwait</option>
				<option value="KG">Kyrgyzstan</option>
				<option value="LA">Laos</option>
				<option value="LV">Latvia</option>
				<option value="LB">Lebanon</option>
				<option value="LS">Lesotho</option>
				<option value="LR">Liberia</option>
				<option value="LY">Libya</option>
				<option value="LI">Liechtenstein</option>
				<option value="LT">Lithuania</option>
				<option value="LU">Luxembourg</option>
				<option value="MO">Macau</option>
				<option value="MK">Macedonia</option>
				<option value="MG">Madagascar</option>
				<option value="MW">Malawi</option>
				<option value="MY">Malaysia</option>
				<option value="MV">Maldives</option>
				<option value="ML">Mali</option>
				<option value="MT">Malta</option>
				<option value="MH">Marshall Islands</option>
				<option value="MQ">Martinique (French)</option>
				<option value="MR">Mauritania</option>
				<option value="MU">Mauritius</option>
				<option value="YT">Mayotte</option>
				<option value="MX">Mexico</option>
				<option value="FM">Micronesia</option>
				<option value="MD">Moldavia</option>
				<option value="MC">Monaco</option>
				<option value="MN">Mongolia</option>
				<option value="MS">Montserrat</option>
				<option value="MA">Morocco</option>
				<option value="MZ">Mozambique</option>
				<option value="MM">Myanmar</option>
				<option value="NA">Namibia</option>
				<option value="NR">Nauru</option>
				<option value="NP">Nepal</option>
				<option value="NL">Netherlands</option>
				<option value="AN">Netherlands Antilles</option>
				<option value="NT">Neutral Zone</option>
				<option value="NC">New Caledonia (French)</option>
				<option value="NZ">New Zealand</option>
				<option value="NI">Nicaragua</option>
				<option value="NE">Niger</option>
				<option value="NG">Nigeria</option>
				<option value="NU">Niue</option>
				<option value="NF">Norfolk Island</option>
				<option value="KP">North Korea</option>
				<option value="MP">Northern Mariana Islands</option>
				<option value="NO">Norway</option>
				<option value="OM">Oman</option>
				<option value="PK">Pakistan</option>
				<option value="PW">Palau</option>
				<option value="PA">Panama</option>
				<option value="PG">Papua New Guinea</option>
				<option value="PY">Paraguay</option>
				<option value="PE">Peru</option>
				<option value="PH">Philippines</option>
				<option value="PN">Pitcairn Island</option>
				<option value="PL">Poland</option>
				<option value="PF">Polynesia (French)</option>
				<option value="PT">Portugal</option>
				<option value="PR">Puerto Rico</option>
				<option value="QA">Qatar</option>
				<option value="RE">Reunion (French)</option>
				<option value="RO">Romania</option>
				<option value="RU">Russian Federation</option>
				<option value="RW">Rwanda</option>
				<option value="GS">S. Georgia & S. Sandwich Isls.</option>
				<option value="SH">Saint Helena</option>
				<option value="KN">Saint Kitts & Nevis Anguilla</option>
				<option value="LC">Saint Lucia</option>
				<option value="PM">Saint Pierre and Miquelon</option>
				<option value="ST">Saint Tome (Sao Tome) and Principe</option>
				<option value="VC">Saint Vincent & Grenadines</option>
				<option value="WS">Samoa</option>
				<option value="SM">San Marino</option>
				<option value="SA">Saudi Arabia</option>
				<option value="SN">Senegal</option>
				<option value="SC">Seychelles</option>
				<option value="SL">Sierra Leone</option>
				<option value="SG">Singapore</option>
				<option value="SK">Slovak Republic</option>
				<option value="SI">Slovenia</option>
				<option value="SB">Solomon Islands</option>
				<option value="SO">Somalia</option>
				<option value="ZA">South Africa</option>
				<option value="KR">South Korea</option>
				<option value="ES">Spain</option>
				<option value="LK">Sri Lanka</option>
				<option value="SD">Sudan</option>
				<option value="SR">Suriname</option>
				<option value="SJ">Svalbard and Jan Mayen Islands</option>
				<option value="SZ">Swaziland</option>
				<option value="SE">Sweden</option>
				<option value="CH">Switzerland</option>
				<option value="SY">Syria</option>
				<option value="TJ">Tadjikistan</option>
				<option value="TW">Taiwan</option>
				<option value="TZ">Tanzania</option>
				<option value="TH">Thailand</option>
				<option value="TG">Togo</option>
				<option value="TK">Tokelau</option>
				<option value="TO">Tonga</option>
				<option value="TT">Trinidad and Tobago</option>
				<option value="TN">Tunisia</option>
				<option value="TR">Turkey</option>
				<option value="TM">Turkmenistan</option>
				<option value="TC">Turks and Caicos Islands</option>
				<option value="TV">Tuvalu</option>
				<option value="UG">Uganda</option>
				<option value="UA">Ukraine</option>
				<option value="AE">United Arab Emirates</option>
				<option value="GB">United Kingdom</option>
				<option value="UY">Uruguay</option>
				<option value="MIL">USA Military</option>
				<option value="UM">USA Minor Outlying Islands</option>
				<option value="UZ">Uzbekistan</option>
				<option value="VU">Vanuatu</option>
				<option value="VA">Vatican City State</option>
				<option value="VE">Venezuela</option>
				<option value="VN">Vietnam</option>
				<option value="VG">Virgin Islands (British)</option>
				<option value="VI">Virgin Islands (USA)</option>
				<option value="WF">Wallis and Futuna Islands</option>
				<option value="EH">Western Sahara</option>
				<option value="YE">Yemen</option>
				<option value="YU">Yugoslavia</option>
				<option value="ZR">Zaire</option>
				<option value="ZM">Zambia</option>
				<option value="ZW">Zimbabwe</option>
			</select>
		</p>
	</fieldset>

	<fieldset class="information" id="additional_info">
		<legend>Additional Information</legend>
		<input type="hidden" id="description" name="description" value="" maxlength="15"/><!-- This field adds a second line on a credit card statement-->
		<p>
			<label for="company">Company</label>
			<input id="company"  type="text" name="company" value="" />
		</p>
		<p>
			<label for="phone" class="required" >Phone</label>
			<input  id="phone" type="text" name="phone" value="" />
		</p>
		<p>
			<label for="email_address" class="required">Email Address</label>
			<input  id="email_address" type="text" name="email_address" value="" />
		</p>
	</fieldset>

	<fieldset class="payment" id="payment_info">
		<legend>Payment Information</legend>
		<p>
			<label for="card_type">Payment Type</label>
			<select name="card_type" id="payment_type">
				<option selected value="Visa">Visa</option>
				<option value="Mastercard">Mastercard</option>
				<option value="American Express">AMEX</option>
				<option value="Diners Club">Diners Club</option>
			</select>
		</p>
		<p>
			<label for="credit_card_number" class="required">Credit Card Number</label>
			<input type="text" name="credit_card_number" value="" id="credit_card_number" />
		</p>
		<p>
			<label for="CVV2" class="required">CVV2 Number</label>
			<input type="text" size="4" name="CVV2" id="CVV2" value="" />
		</p>
		<p>Card Expiration Date
			<label for="expiration_month" class="required">Month</label>
			<select  id="expiration_month"  name="expiration_month">
				<option value="01">01</option>
				<option value="02">02</option>
				<option value="03">03</option>
				<option value="04">04</option>
				<option value="05">05</option>
				<option value="06">06</option>
				<option value="07">07</option>
				<option value="08">08</option>
				<option value="09">09</option>
				<option value="10">10</option>
				<option value="11">11</option>
				<option value="12">12</option>
			</select>
			<label for="expiration_year" class="required">Year</label>
			<select id="expiration_year"  name="expiration_year">
				<option value="10">2010</option>
				<option value="11">2011</option>
				<option value="12">2012</option>
				<option value="13">2013</option>
				<option value="14">2014</option>
				<option value="15">2015</option>
				<option value="16">2016</option>
				<option value="17">2017</option>
				<option value="18">2018</option>
				<option value="19">2019</option>
				<option value="20">2020</option>
			</select>
		</p>
	</fieldset>',
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_anz_egate extends Cartthrob_payment_gateway
	{
	
		function Cartthrob_anz_egate()
		{
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			$this->_host			= "https://migs.mastercard.com.au/vpcdps";
		}
		/**
		 * _process_payment function
		 *
		 * @param string $total the total amount of the purchase
		 * @param string $credit_card_number purchaser's credit cart number
		 * @param array $customer_info array containing $_POST fields captured by the checkout form
		 * @access private
		 * @return array $resp an array containing the following keys: authorized, declined, failed, error_message, and transaction_id 
		 * the returned fields can be displayed in the templates using template tags. 
		 **/
		function _process_payment($total, $credit_card_number, $customer_info, $order_id='')
		{
			global $LANG;
			$total = round($total*100);
			$post_array = array(
				'vpc_Version'				=> '1',
				'vpc_Command'				=> 'pay',
				'vpc_MerchTxnRef'			=> $order_id."-". strftime("%Y%m%d%H%M%S"),
				'vpc_AccessCode'			=> $this->plugin_settings['access_code'],
				'vpc_Merchant'				=> $this->plugin_settings['merchant_id'],
				'vpc_OrderInfo'				=> $order_id,
				'vpc_Amount'				=> $total,
				'vpc_CardNum'				=> $credit_card_number,
				'vpc_CardExp'				=> $customer_info['expiration_year'].$customer_info['expiration_month'],
				'vpc_CardSecurityCode'		=> $customer_info['CVV2'],
		     );
			
			$data = 	$this->data_array_to_string($post_array);
			// var_dump($post_array);
			$connect = 	$this->curl_transaction($this->_host,$data); 

			$resp['authorized']	 	= FALSE; 
			$resp['declined'] 		= FALSE; 
			$resp['transaction_id']	= NULL;
			$resp['failed']			= TRUE; 
			$resp['error_message']	= $LANG->line('anz_egate_error_7'). " ". $LANG->line('anz_egate_cant_connect');
			
			if (!$connect)
			{
				return $resp; 
			}
			elseif(strchr($connect,"<html>"))
			{
				$resp['error_message'] = $connect;
				return $resp;
			}
			$transaction =  $this->split_url_string($connect);
			
			// var_dump($transaction); 
			if ($transaction['vpc_TxnResponseCode'] !="0")
			{
				$resp['error_message'] = $this->getResponseDescription($transaction['vpc_TxnResponseCode']) . " " . @$transaction['vpc_Message'];
				return $resp; 
			}
			else
			{
				$resp['authorized']	 	= TRUE; 
				$resp['declined'] 		= FALSE; 
				$resp['transaction_id']	= $transaction['vpc_TransactionNo'];
				$resp['failed']			= FALSE; 
				$resp['error_message']	= NULL;
				
				return $resp; 
			}
			
			
		}
		// END _process_payment
		//  ----------------------------------------------------------------------------

		// This function uses the Transaction Response code retrieved from the Digital
		// Receipt and returns an appropriate description for the vpc_TxnResponseCode

		// @param $responseCode String containing the vpc_TxnResponseCode

		// @return String containing the appropriate description

		function getResponseDescription($responseCode) {
			global $LANG; 
			
		    switch ($responseCode) {
		        case "0" : $result = $LANG->line('anz_egate_error_0'); break;
		        case "?" : $result = $LANG->line('anz_egate_error_question'); break;
		        case "1" : $result = $LANG->line('anz_egate_error_1'); break;
		        case "2" : $result = $LANG->line('anz_egate_error_2'); break;
		        case "3" : $result = $LANG->line('anz_egate_error_3'); break;
		        case "4" : $result = $LANG->line('anz_egate_error_4'); break;
		        case "5" : $result = $LANG->line('anz_egate_error_5'); break;
		        case "6" : $result = $LANG->line('anz_egate_error_6'); break;
		        case "7" : $result = $LANG->line('anz_egate_error_7'); break;
		        case "8" : $result = $LANG->line('anz_egate_error_8'); break;
		        case "9" : $result = $LANG->line('anz_egate_error_9'); break;
		        case "A" : $result = $LANG->line('anz_egate_error_A'); break;
		        case "C" : $result = $LANG->line('anz_egate_error_C'); break;
		        case "D" : $result = $LANG->line('anz_egate_error_D'); break;
		        case "F" : $result = $LANG->line('anz_egate_error_F'); break;
		        case "I" : $result = $LANG->line('anz_egate_error_I'); break;
		        case "L" : $result = $LANG->line('anz_egate_error_L'); break;
		        case "N" : $result = $LANG->line('anz_egate_error_N'); break;
		        case "P" : $result = $LANG->line('anz_egate_error_P'); break;
		        case "R" : $result = $LANG->line('anz_egate_error_R'); break;
		        case "S" : $result = $LANG->line('anz_egate_error_S'); break;
		        case "T" : $result = $LANG->line('anz_egate_error_T'); break;
		        case "U" : $result = $LANG->line('anz_egate_error_U'); break;
		        case "V" : $result = $LANG->line('anz_egate_error_V'); break;
		        default  : $result = $LANG->line('anz_egate_response_code'). ": ". @$responseCode.". ";
		    }
		    return $result;
		}
	}
	// END Class
}
/* End of file cartthrob.anz_egate.php */
/* Location: ./system/modules/payment_gateways/cartthrob.anz_egate.php */