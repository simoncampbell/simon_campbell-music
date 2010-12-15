<?php
global $LANG; 

$gateway_info = array(
	'title' => 'Authorize.net',
	'classname' => 'Cartthrob_authorize_net',
	'affiliate' => $LANG->line('authorize_net_affiliate'), 
	'overview' => $LANG->line('authorize_net_overview'),
	'language_file' => TRUE,
	'settings' => array(
		array(
			'name' => $LANG->line('authorize_net_settings_api_login'),
			'short_name' => 'api_login',
			'type' => 'text'
		),
		array(
			'name' => $LANG->line('authorize_net_settings_trans_key'),
			'short_name' => 'transaction_key',
			'type' => 'text'
		),
		array(
			'name' => $LANG->line('authorize_net_settings_email_customer'),
			'short_name' => 'email_customer',
			'type' => 'radio',
			'default' => "no",
			'options' => array(
				"no"	=> "No",
				"yes"	=> "Yes"
				)
		),
		array(
			'name' => "Mode",
			'short_name' => 'mode',
			'type' => 'radio',
			'default' => "test",
			'options' => array(
				"test"	=> "Test",
				"live"	=> "Live",
				"developer" => "Developer"
			)
		),
		array(
			'name' => $LANG->line('authorize_net_settings_dev_api_login'),
			'short_name' => 'dev_api_login',
			'type' => 'text'
		),
		array(
			'name' => $LANG->line('authorize_net_settings_dev_trans_key'),
			'short_name' => 'dev_transaction_key',
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
		<legend>Billing Info</legend>
		<p>
			<label for="first_name" class="required" >First Name</label>
			<input type="text" id="first_name" name="first_name" value="" />
		</p>
		<p>
			<label for="last_name" class="required" >Last Name</label>
			<input type="text" name="last_name" value="" id="last_name" />
		</p>
		<p>
			<label for="address" class="required" >Street Address</label>
			<input type="text" name="address" value="" id="address"/>
		</p>
		<p>
			<label for="address2" >Street Address</label>
			<input type="text" name="address2" value="" id="address2"/>
		</p>
		<p>
			<label for="city" class="required" >City</label>
			<input type="text" name="city" value="" id="city"/>
		</p>
		<p>
			<label for="state">State (US only)</label>
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
			<input type="text" name="zip" value="" id="zip"/>
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

	<fieldset class="information"  id="additional_info">
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
				<option value="American Express">American Express</option>
				<option value="Discover">Discover</option>
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
	
	class Cartthrob_authorize_net extends Cartthrob_payment_gateway
	{
	
		function Cartthrob_authorize_net()
		{
			$this->_x_test_request	=	"FALSE";//leave in quotes, this value is sent as a string. 
			$this->_host			=	"secure.authorize.net";
			$this->_port			=	"443";
			$this->_path			=	"/gateway/transact.dll";
			$this->Cartthrob();
			$this->plugin_settings = $this->settings[ucfirst(get_class($this)).'_settings'];
		}
		
		/**
		 * process_payment
		 *
		 * @param string $total amount of the purchase 
		 * @param string $credit_card_number 
		 * @param array $customer_info Fields from the checkout form. The keys are preset, additional items can not be added on the form. 
		 * @return mixed | array | bool An array of error / success messages  is returned, or FALSE if all fails.
		 * @author Chris Newton
		 * @access private
		 * @since 1.0.0
		 */
		function _process_payment($total, $credit_card_number, $customer_info, $order_id='')
		{
			return $this->_auth('AUTH_CAPTURE', $total, $credit_card_number, $customer_info);
		}
		
		/**
		 * Auth
		 *
		 * @param string $x_type AUTH_CAPTURE for money, AUTH_ONLY to authorize a card for later transaction
		 * @param string $credit_card_number credit card number
		 * @param array $customer_info an array of customer data with following fields:
		 * first_name
		 * last_name
		 * address
		 * city
		 * state 
		 * description
		 * zip
		 * phone
		 * email_address 
		 * shipping_first_name
		 * shipping_last_name
		 * shipping_address 
		 * shipping_city 
		 * shipping_state 
		 * shipping_zip, 
		 * use_shipping_address 
		 * total_cart
		 * card_type
		 * expiration_month
		 * expiration_year
		 * country_code
		 * 
		 * @access private
		 * @return mixed | array | bool An array of error / success messages  is returned, or FALSE if all fails.
		 * @author Chris Newton
		 * @since 1.0.0
		 */
		function _auth($x_type,$total_cost,$credit_card_number,$customer_info)
		{
			global $SESS,$PREFS, $LANG, $FNS;
			
			$authorize_net_response				= 	NULL;
			
			if ($this->plugin_settings['mode'] == 'developer') 
			{
				$this->_host					= "test.authorize.net";
				$this->plugin_settings['api_login'] = $this->plugin_settings['dev_api_login'];
				$this->plugin_settings['transaction_key'] = $this->plugin_settings['dev_transaction_key'];
			}
			elseif ($this->plugin_settings['mode'] == "test") 
			{
				$this->_host					= "secure.authorize.net";
				$this->_x_test_request         	= "TRUE";
			}
			else
			{
				$this->_host					= "secure.authorize.net"; 
			}
	
		if ( ! $x_type)
		{
		    $x_type = 'AUTH_CAPTURE';
		}
	
			$post_array = array(
				"x_login"         				=> $this->plugin_settings['api_login'],
				"x_tran_key"           			=> $this->plugin_settings['transaction_key'],
				"x_version"           	 		=> "3.1",
				"x_test_request"    		   	=> $this->_x_test_request,
				"x_delim_data"    	    	 	=> "TRUE",
				"x_relay_response" 		 	   	=> "FALSE",
				"x_first_name"       	     	=> $customer_info['first_name'],
				"x_last_name"       	     	=> $customer_info['last_name'],
				"x_address"      		      	=> $customer_info['address']." ". @$customer_info['address2'],
				"x_city"            	    	=> $customer_info['city'],
				"x_state"              		  	=> $customer_info['state'],
				"x_description"					=> (!empty($customer_info['description']) ? $customer_info['description'] : $PREFS->ini('site_url')),
				"x_zip"            		    	=> $customer_info['zip'],
				"x_country"            		   	=> $this->_get_alpha2_country_code((!empty($customer_info['country_code']) ? $customer_info['country_code'] : 'US')),
				'x_ship_to_first_name'			=> !empty($customer_info['shipping_first_name']) ? $customer_info['shipping_first_name'] : $customer_info['first_name'],
				'x_ship_to_last_name'			=> !empty($customer_info['shipping_last_name']) ? $customer_info['shipping_last_name'] : $customer_info['last_name'],
				'x_ship_to_address'				=> !empty($customer_info['shipping_address']) ? $customer_info['shipping_address']." ".$customer_info['shipping_address2'] : $customer_info['address']." ".$customer_info['address2'],
				'x_ship_to_city'				=> !empty($customer_info['shipping_city']) ? $customer_info['shipping_city'] : $customer_info['city'],
				'x_ship_to_state'				=> !empty($customer_info['shipping_state']) ? $customer_info['shipping_state'] : $customer_info['state'],
				'x_ship_to_zip'					=> !empty($customer_info['shipping_zip']) ? $customer_info['shipping_zip'] : $customer_info['zip'],
				"x_phone"          		      	=> $customer_info['phone'],
				"x_email"          		      	=> $customer_info['email_address'],
				"x_cust_id"          		   	=> $SESS->userdata['member_id'],
				"x_invoice_num"					=> time().strtoupper(substr($customer_info['last_name'], 0, 3)),
				"x_company"						=> @$customer_info['company'],
				"x_email_customer"    		 	=> ($this->plugin_settings['email_customer'] == "yes") ? "TRUE" : "FALSE",
				"x_amount"               	 	=> $total_cost,
				"x_method"               	 	=> "CC",
				"x_type"                 		=> $x_type,  // set to AUTH_CAPTURE for money capturing transactions
				"x_card_num"             		=> $credit_card_number,
				"x_card_code"             		=> @$customer_info['CVV2'],
				"x_exp_date"             		=> $customer_info['expiration_month'].'/'.$customer_info['expiration_year'],
				"x_tax"							=> $this->_calculate_tax(),
				"x_freight"						=> $this->_calculate_shipping()
			);
		
			reset($post_array);
			$data='';
			while (list ($key, $val) = each($post_array)) 
			{
				$data .= $key . "=" . urlencode($val) . "&";
			}
			
			
			// SENDING ORDER DATA TO AUTHORIZE.NET
			$line_item = array(); 
			
			foreach ($this->_get_cart_items() as $row_id=>$item)
			{
				$basket = ""; 
				
				if (!isset($count))
				{
					$count=1;
				}
				$count++;
				if ($count > 30)
				{
					continue; 
				}

				$title = substr($item['title'], 0, 30); 
				
				while (strlen(urlencode($title)) > 30)
				{
					$title = substr($title, 0, -1); 
				}
				
				$basket .= $item['entry_id']."<|>"; 
				$basket .= urlencode($title)."<|>";
				$basket .= $item['entry_id']."<|>";
				$basket .= abs($item['quantity'])."<|>";
				$basket .= abs($this->_get_item_price($item['entry_id'], $row_id))."<|>"; 
				$basket .="Y";
				$line_item[] = $basket; 
			}
			// ADDING TO EXISTING DATA STRING. 
			while (list ($key, $val) = each($line_item)) 
			{
				$data .= "x_line_item=" . $val . "&";
			}
			$data .= "x_duty=0"; 
	
			$connect				=	$this->_check_method($this->_host,$this->_port,$this->_path);
			if (!$connect)
			{
				echo $LANG->line('authorize_net_cant_connect');
			}    	
		
			$transaction	=	$this->_parse_connect($connect,$data);
			
			//var_dump($transaction);
		
			$declined = FALSE;
			$failed = FALSE;
			
			if ($transaction['authorized']) 
			{
				$authorize_net_response		=	'';
				$authorized					=	TRUE;
				$resp['transaction_id']	=	$transaction['transaction_id'];
			}
			elseif (!$transaction['authorized'] && $transaction['declined']) 
			{
				$authorize_net_response		=	$transaction['error_message'];
				$authorized					=	FALSE;
				$declined 			=	TRUE;
	
			}
			elseif (!$transaction['authorized'] && !$transaction['declined']) 
			{	
				$authorize_net_response		=	$transaction['error_message'];
				$authorized					=	FALSE;
				$failed				=	TRUE;
			}		
	
			$resp['error_message']	=	$authorize_net_response;
			$resp['authorized']		=	$authorized;
			$resp['failed']		=	$failed;
			$resp['declined']		=	$declined;
			return $resp;
		}
		// END Auth
		
		function _check_method($host,$port,$path)
		{
			$fp = fsockopen("ssl://" . $host, $port, $error_number, $error_string, $time_out = 180);
			$ch = curl_init("https://" . $host . $path);
			if ($ch)
			{	
				$connect['connect']	=	'curl';
				$connect['method']	=	$ch;
				return $connect;
			}
			elseif ($fp)
			{
				$connect['connect']	=	'socket';
				$connect['method']	=	$fp;
				return $connect;
			}
			else
			{
				return FALSE;
			}
		}
		
		function _parse_connect($connect,$data)
		{
			global $LANG;
			
			if($connect['connect'] == 'socket')
			{
				if(!$connect['method'])
				{ 
					$parsed['error_message']		= 'Error: '.$error_string.' ('.$error_number.')<br />';
				}
				else
				{ 
					//send the server request 
					fputs($connect['method'], "POST ".$this->_path." HTTP/1.1\r\n"); 
					fputs($connect['method'], "Host: ".$this->_host."\r\n"); 
					fputs($connect['method'], "Content-type: application/x-www-form-urlencoded\r\n"); 
					fputs($connect['method'], "Content-length: ".strlen($data)."\r\n");
					fputs($connect['method'], "Connection: close\r\n\r\n");
					
					fputs($connect['method'], $data . "\r\n\r\n");
					while (!feof($connect['method'])) 
					{
						$parsed['response'] 	= 	fgets ($connect['method'], 1024);
						$response = explode(",",$parsed['response']);
						if ($parsed['response']{0} == 1) 
						{
							$parsed['authorized']	= TRUE;
							$parsed['transaction_id']	=	@$response[6];
						}
						elseif($parsed['response']{0} == 2)
						{
							$parsed['authorized'] 	= FALSE;
							$parsed['declined']		= TRUE;
							$parsed['return_error'] = $response;
							$parsed['error_message'] = @$response[3];
						}
						elseif($parsed['response']{0} == 3)
						{
							$parsed['authorized'] 	= FALSE;
							$parsed['declined']		= FALSE;
							$parsed['return_error'] = $response;
							$parsed['error_message'] = @$response[3];
						}
						elseif($parsed['response']{0} == 4)
						{
							$parsed['authorized'] 	= FALSE;
							$parsed['declined']		= FALSE;
							$parsed['return_error'] = $response;
							$parsed['error_message'] = @$response[3];
						}
						else
						{
							$parsed['error_message'] = $LANG->line('authorize_net_error_1').$parsed['response']{0};
							$parsed['authorized']	= FALSE;
							$parsed['declined']		= FALSE;
							$parsed['return_error'] = $response;
						}
					}
				}
			fclose($connect['method']); 
			}
			elseif($connect['connect'] == 'curl')
			{
				curl_setopt($connect['method'], CURLOPT_HEADER, 0); 					// set to 0 to eliminate header info from response
				curl_setopt($connect['method'], CURLOPT_RETURNTRANSFER, 1); 			// Returns response data instead of TRUE(1)
				curl_setopt($connect['method'], CURLOPT_POSTFIELDS, $data); 			// use HTTP POST to send form data
				### curl_setopt($connect['method'], CURLOPT_SSL_VERIFYPEER, FALSE); 	// uncomment this line if you get no gateway response. ###
				$parsed['response'] = curl_exec($connect['method']); 					// execute post and get results
				curl_close ($connect['method']);
				$response = explode(",",$parsed['response']);
				if ($parsed['response']{0} == 1) 
				{
					$parsed['authorized']	= TRUE;
					$parsed['transaction_id']	=	@$response[6];
				}
				elseif($parsed['response']{0} == 2)
				{
					$parsed['authorized'] 	= FALSE;
					$parsed['declined']		= TRUE;
					$parsed['return_error'] = $response;
					$parsed['error_message'] = @$response[3];
				}
				elseif($parsed['response']{0} == 3)
				{
					$parsed['authorized'] 	= FALSE;
					$parsed['declined']		= FALSE;
					$parsed['return_error'] = $response;
					$parsed['error_message'] = @$response[3];
				}
				elseif($parsed['response']{0} == 4)
				{
					$parsed['authorized'] 	= FALSE;
					$parsed['declined']		= FALSE;
					$parsed['return_error'] = $response;
					$parsed['error_message'] = @$response[3];
				}
				else
				{
					$parsed['error_message'] = $LANG->line('authorize_net_error_1').$parsed['response']{0};
					$parsed['authorized']	= FALSE;
					$parsed['declined']		= FALSE;
					$parsed['return_error'] = $response;
				}
			}
			else
			{
				$parsed['error_message']			= $LANG->line('authorize_net_error_2').$parsed['response']{0};
				$parsed['authorized']				= FALSE;
				$parsed['declined']					= FALSE;
				$parsed['return_error']				= $parsed['error_message'].$LANG->line('authorize_net_no_response');
				//$parsed['response']					=	'no response';
			}
			return $parsed;
		}
		// END
	}
	// END Class
}
/* End of file cartthrob.authorize_net.php */
/* Location: ./system/modules/payment_gateways/cartthrob.authorize_net.php */