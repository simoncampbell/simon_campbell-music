<?php
global $LANG; 

/*

To use the PayPal API, you must have API credentials that identify you as a PayPal business account holder authorized to perform various API operations. PayPal recommends you use a signature.

@see https://www.x.com/docs/DOC-1316#id084E30I30RO for information on setting up your account to have API access.
*/
$gateway_info = array(
	'title' => $LANG->line('paypal_pro_title'),
	'classname' => 'Cartthrob_paypal_pro',
	'affiliate' => $LANG->line('paypal_pro_affiliate'),
	'overview' => $LANG->line('paypal_pro_overview'),
	'settings' => array(
		array(
			'name' => $LANG->line('paypal_pro_api_username'),
			'short_name' => 'api_username', 
			'type' => 'text', 
			'default' => '', 
		),
		array(
			'name' => $LANG->line('paypal_pro_api_password'),
			'short_name' => 'api_password', 
			'type' => 'text', 
			'default' => '', 
		),
		array(
			'name' => $LANG->line('paypal_pro_signature'),
			'short_name' => 'api_signature', 
			'type' => 'text', 
			'default' => '', 
		),
		
		array(
			'name' => "Sandbox Username",
			'short_name' => 'test_username', 
			'type' => 'text', 
			'default' => '', 
		),
		array(
			'name' => "Sandbox Password",
			'short_name' => 'test_password', 
			'type' => 'text', 
			'default' => '', 
		),
		array(
			'name' => "Sandbox Signature",
			'short_name' => 'test_signature', 
			'type' => 'text', 
			'default' => '', 
		),
		array(
			'name' => "Payment Action Type",
			'short_name' => 'payment_action', 
			'type' => 'radio', 
			'default' => 'Sale',
			'options'	=> array(
				'Sale' => 'Sale',
				'Authorization' => 'Authorization'
				) 
		),
		
		array(
			'name' => $LANG->line('paypal_pro_sandbox_mode'),
			'short_name' => 'test_mode', 
			'type' => 'radio', 
			'default' => 'live',
			'options' => array(
					'test'=> "Test",
					'live'=> "Live"
				),
		),
		array(
			'name'	=> 'PayPal Pro Country',
			'short_name'	=> 'country',
			'type'	=> 'radio',
			'default'	=> 'us',
			'options'	=> array(
				'us'=> 'United States',
				'ca'=> 'Canada',
				'uk'=> 'Great Britain'
				)
		),
		
		array(
			'name' => "PayPal API Version",
			'short_name' => 'api_version', 
			'type' => 'radio',
			'options' => array(
				'57.0'	=> '57.0',
				'60.0'	=> '60.0'
				), 
			'default' => '60.0', 
		),
	),
	'required_fields' => array(
		'credit_card_number',
		'expiration_month',
		'expiration_year',
		'card_type',
		'first_name',
		'last_name',
		'address',
		'city',
		'zip',
		'country_code',
		'currency_code',
		'phone',
		'email_address',
	),
	
	'html' => '
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
			<select  id="country_code" name="country_code">
				<option selected value="US">United States</option>
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
		<legend>Shipping Information</legend>
		<p>
			<label for="shipping_first_name"  >First Name</label>
			<input type="text" id="shipping_first_name" name="shipping_first_name" value="" />
		</p>
		<p>
			<label for="shipping_last_name"  >Last Name</label>
			<input type="text" id="shipping_last_name" name="shipping_last_name" value="" />
		</p>
		<p>
			<label for="shipping_address"   >Street Address</label>
			<input type="text" id="shipping_address" name="shipping_address" value="" />
		</p>
		<p>
			<label for="shipping_address2" >Street Address</label>
			<input type="text" id="shipping_address2" name="shipping_address2" value="" />
		</p>
		<p>
			<label for="shipping_city"  >City</label>
			<input type="text" id="shipping_city" name="shipping_city" value="" />
		</p>
		<p>
			<label for="shipping_state"  >State (US Only)</label>
			<select id="shipping_state" name="shipping_state">
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
			<label for="shipping_zip"  >Zip Code</label>
			<input type="text" id="shipping_zip" name="shipping_zip" value="" />
		</p>	
	</fieldset>

	<fieldset class="additional" id="additional_info">
		<legend>Additional Information</legend>
		<p>
			<label for="phone" class="required" >Phone</label>
			<input type="text" id="phone" name="phone" value="" />
		</p>
		<p>
			<label for="email_address" class="required">Email Address</label>
			<input type="text" id="email_address" name="email_address" value="" />
		</p>
	</fieldset>


	<fieldset class="payment" id="payment_info">
		<legend>Payment Information</legend>
		<p>
			<label for="currency_code">Currency</label>
			<select id="currency_code" name="currency_code">
				<option selected value="USD">Dollars</option>
				<option value="GBP">Pounds</option>
				<option value="EUR">Euro</option>
			</select>		
		</p>
		<p>
			<label for="card_type">Payment Type</label>
			
			<select id="card_type" name="card_type">
				<option selected value="Visa">Visa</option>
				<option value="MasterCard">Mastercard</option>
				<option value="Amex">American Express</option>
				<option value="Discover">Discover</option>
			</select>
			<!-- USE IN UK
			<select name="card_type" id="card_type">
				<option value="MasterCard">Master Card</option>
				<option value="Visa">Visa</option>
				<option value="Amex">American Express</option>
				<option value="Discover">Discover</option>
				<option value="Maestro">Maestro</option>
				<option value="Solo">Solo</option>
			</select>
 			-->
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
		<!-- UK FIELDS
		<p>
			<label for="issue_number">Issue Number <span class="note">(for Maestro and Solo cards only)</span></label>
			<input type="text" name="issue_number" id="issue_number" value="" />
		</p>
		<p>Card Start Date  (required for some Maestro and Solo cards)
			<label for="begin_month"  >Month</label>
			<select name="begin_month" id="begin_month">
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
			<label for="begin_year"  >Year</label>
			<select name="begin_year" id="begin_year">
				<option value="00">2000</option>
				<option value="01">2001</option>
				<option value="02">2002</option>
				<option value="03">2003</option>
				<option value="04">2004</option>
				<option value="05">2005</option>
				<option value="06">2006</option>
				<option value="07">2007</option>
				<option value="08">2008</option>
				<option value="09">2009</option>
				<option value="10">2010</option>
				<option value="11">2011</option>
				<option value="12">2012</option>
			</select>
			</p>
			-->
	</fieldset>	',
);

if ( ! class_exists($gateway_info['classname']))
{
	
	class Cartthrob_paypal_pro extends Cartthrob_payment_gateway
	{
	
		function Cartthrob_paypal_pro()
		{
			$this->Cartthrob();
	
	
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
			
			if ($this->plugin_settings['test_mode'] == "test") 
			{
				// Sandbox server for use with API signatures;use for testing your API
				//$this->_paypal_server = "https://api-3t.sandbox.paypal.com/nvp"; 
				$this->_paypal_server = "https://api.sandbox.paypal.com/nvp"; 
				$this->_API_UserName = urlencode($this->plugin_settings['test_username']);
				$this->_API_Password = urlencode($this->plugin_settings['test_password']);
				$this->_API_Signature = urlencode($this->plugin_settings['test_signature']);
			}
			else
			{
				// PayPal “live” production server for usewith API signatures
				$this->_paypal_server = "https://api-3t.paypal.com/nvp"; 
				$this->_API_UserName = urlencode($this->plugin_settings['api_username']);
				$this->_API_Password = urlencode($this->plugin_settings['api_password']);
				$this->_API_Signature = urlencode($this->plugin_settings['api_signature']);
			}	
			

			
		}
		function _process_payment($total, $credit_card_number, $customer_info)
		{
			return $this->_charge_sale($total,$credit_card_number, $customer_info);
	
	
			// THESE ARRAY KEYS WILL USE DEFAULTS IF NOT SET. 
			// IF THIS IS NOT BLANK, TRANS IS GOOD DECLINED & FAILED BELOW ARE IGNORED
			$resp['authorized']		=	"";
			
			// OTHERWISE THE PLUGIN WILL REDIRECT BASED ON THE FOLLOWING CONDITIONS (in this order)
			$resp['declined']		=	"";
			$resp['failed']			=	"";
			// THIS ERROR MESSAGE CAN BE DISPLAYED IN THE TEMPLATE AS NECESSARY
			$resp['error_message']	=	"";
			
			// THE TRANS ID (if available) IF NO TRANSID IS RETURNED A TIME STAMP IS USED. 
			$resp['transaction_id']	=	"";
			
			return $resp;
		}
		function _charge_sale($total,$credit_card_number, $customer_info, $order_id='')
		{
			global $LANG, $IN;
			
			$post_array = array(
			'METHOD' 			=> 'DoDirectPayment', 
			'VERSION'			=> urlencode($this->plugin_settings['api_version']),
			'PWD'				=> $this->_API_Password,
			'USER'				=> $this->_API_UserName,
			'SIGNATURE'			=> $this->_API_Signature,
			'PAYMENTACTION' 		=> $this->plugin_settings['payment_action'],
			'EMAIL'				=> $customer_info['email_address'],
			'AMT' 				=> $total,
			'ACCT' 				=> $credit_card_number,
			'EXPDATE' 			=> str_pad($customer_info['expiration_month'], 2, '0', STR_PAD_LEFT).str_pad($customer_info['expiration_year'], 4, '20', STR_PAD_LEFT),
			'FIRSTNAME' 		=> $customer_info['first_name'],
			'LASTNAME' 			=> $customer_info['last_name'],
			'STREET' 			=> $customer_info['address'],
			'STREET2'			=> $customer_info['address2'],
			'CITY' 				=> $customer_info['city'],
			'STATE' 			=> strtoupper($customer_info['state']),
			'ZIP' 				=> $customer_info['zip'],
			'CVV2' 				=> $customer_info['CVV2'],
			'COUNTRYCODE' 		=> !empty($customer_info['country_code']) ? $this->_get_alpha2_country_code($customer_info['country_code']) : "GB",
			'CURRENCYCODE' 		=> !empty($customer_info['currency_code']) ? $customer_info['currency_code'] : "USD",
			'CREDITCARDTYPE'	=> $customer_info['card_type'],
			'SHIPTONAME'		=> !empty($customer_info['shipping_first_name']) 		? $customer_info['shipping_first_name'] . " ". $customer_info['shipping_last_name'] : $customer_info['first_name'] ." ". $customer_info['last_name'],
			'SHIPTOSTREET'		=> !empty($customer_info['shipping_address']) 			? $customer_info['shipping_address'] : $customer_info['address'],
			'SHIPTOSTREET2'		=> !empty($customer_info['shipping_address2']) 			? $customer_info['shipping_address2'] : $customer_info['address2'],
			'SHIPTOCITY'		=> !empty($customer_info['shipping_city']) 				? $customer_info['shipping_city'] : $customer_info['city'],
			'SHIPTOSTATE'		=> !empty($customer_info['shipping_state'])				? strtoupper($customer_info['shipping_state']) : strtoupper($customer_info['state']),
			'SHIPTOZIP'			=> !empty($customer_info['shipping_zip']) 				? $customer_info['shipping_zip'] : $customer_info['zip'],
			'SHIPTOCOUNTRY'		=> !empty($customer_info['shipping_country_code']) 		? $this->_get_alpha2_country_code($customer_info['shipping_country_code']) : $this->_get_alpha2_country_code($customer_info['country_code']),
			'RETURNFMFDETAILS' 	=> '0',
			'IPADDRESS' 		=> $IN->IP
			
			); 
			if (!empty($post_array['SHIPTONAME']) && empty($post_array['SHIPTOSTATE']))
			{
				$post_array['SHIPTOSTATE'] = "--"; 
			}
			
			if ($this->plugin_settings=="uk" )
			{
				$post_array['STARTDATE']	= !empty($customer_info['begin_month']) ? str_pad($customer_info['begin_month'], 2, '0', STR_PAD_LEFT) . $customer_info['begin_year']: ""; 
				$post_array['ISSUENUMBER']	= $customer_info['issue_number'];
				
			}
 
			$data = 	$this->data_array_to_string($post_array);
			$connect = 	$this->curl_transaction($this->_paypal_server,$data); 
			if (!$connect)
			{
				exit($LANG->line('paypal_pro_cant_connect'));
			}
			$transaction =  $this->split_url_string($connect);
			//var_dump($transaction);exit;
			$declined = FALSE;
			$failed = FALSE;
			if (is_array($transaction))
			{
				if ("SUCCESS" == strtoupper($transaction['ACK']) || "SUCCESSWITHWARNING" == strtoupper($transaction["ACK"])) 
				{
					$authorized = TRUE; 
					$declined = FALSE; 
					$transaction_id = $transaction['TRANSACTIONID']; 
					$error_message = '';
					
				} 
				else  
				{
					$authorized = FALSE; 
					$declined = TRUE; 
					$transaction_id = 0;
					$error_message = ($transaction['L_LONGMESSAGE0']) ? $transaction['L_LONGMESSAGE0'] : $LANG->line('unknown_error');
				}
					
				$resp['authorized']		=	$authorized;
				$resp['error_message']	=	$error_message;
				$resp['failed']			=	$failed;
				$resp['declined']		=	$declined;
				$resp['transaction_id'] =	$transaction_id;
			}
			else
			{
				$resp['authorized']		=	FALSE;
				$resp['error_message']	=	$LANG->line('paypal_pro_contact_admin');
				$resp['failed']			=	TRUE;
			}
			return $resp;
		}
	
	}
}
/* End of file cartthrob.paypal_pro.php */
/* Location: ./system/modules/payment_gateways/cartthrob.paypal_pro.php */