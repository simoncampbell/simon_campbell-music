<?php global $LANG; ?>           
	<!-- start instruction box -->
	<div class="ct_instruction_box">
		<h2><?php echo $LANG->line('validation_header'); ?></h2>
		<p><?php echo $LANG->line('validation_description'); ?></p>
	</div>

	<!-- end instruction box -->
	<div id="ct_form_options">
		<div class="ct_form_header">
			<h2><?php echo $LANG->line('validation_form_header'); ?></h2>
		</div>

		<fieldset >
			<label><?php echo $LANG->line('validation_missing_fields'); ?></label>
			<input dir='ltr' type='text' name='customer_info_validation_msg' id='customer_info_validation_msg' value='<?php echo $settings['customer_info_validation_msg']; ?>' size='90' maxlength='100' />
		</fieldset>

		<div class="ct_form_header">
			<h2><?php echo $LANG->line('validation_customer_name'); ?></h2>
		</div>
		<div class="legend">
			<div class="ct_instruction_left"> 
				<strong><?php echo $LANG->line('validation_form_field_name'); ?></strong><br />
				<?php echo $LANG->line('validation_form_field_description'); ?>
			</div>
			<div class="ct_instruction_right"> 
				<strong><?php echo $LANG->line('validation_error_display_text'); ?></strong><br />
				<?php echo $LANG->line('validation_error_display_description'); ?>
			</div>
			<div class="clear"></div>
		</div>

		<fieldset >
			<label><?php echo $LANG->line('validation_first_name'); ?></label>
			<input name="customer_field_labels[first_name]" type="text" value="<?php echo @$settings['customer_field_labels']['first_name']; ?>" />
		</fieldset>
	
		<fieldset >
			<label><?php echo $LANG->line('validation_last_name'); ?></label>
			<input name="customer_field_labels[last_name]" type="text" value="<?php echo @$settings['customer_field_labels']['last_name']; ?>" />
		</fieldset>
	
		<div class="ct_form_header">
			<h2><?php echo $LANG->line('validation_customer_billing_address'); ?></h2>
		</div>
	
		<fieldset >
			<label><?php echo $LANG->line('validation_address'); ?></label>
			<input name="customer_field_labels[address]" type="text" value="<?php echo @$settings['customer_field_labels']['address']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_address2'); ?></label>
			<input name="customer_field_labels[address2]" type="text" value="<?php echo @$settings['customer_field_labels']['address2']; ?>" />
		</fieldset>

		<fieldset >
			<label><?php echo $LANG->line('validation_city'); ?></label>
			<input name="customer_field_labels[city]" type="text" value="<?php echo @$settings['customer_field_labels']['city']; ?>" />
		</fieldset>

		<fieldset >
			<label><?php echo $LANG->line('validation_state'); ?></label>
			<input name="customer_field_labels[state]" type="text" value="<?php echo @$settings['customer_field_labels']['state']; ?>" />
		</fieldset>

		<fieldset >
			<label><?php echo $LANG->line('validation_zip'); ?></label>
			<input name="customer_field_labels[zip]" type="text" value="<?php echo @$settings['customer_field_labels']['zip']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_country'); ?></label>
			<input name="customer_field_labels[country]" type="text" value="<?php echo @$settings['customer_field_labels']['country']; ?>" />
		</fieldset>

		<div class="ct_form_header">
			<h2><?php echo $LANG->line('validation_customer_contact_info'); ?></h2>
		</div>

		<fieldset >
			<label><?php echo $LANG->line('validation_phone'); ?></label>
			<input name="customer_field_labels[phone]" type="text" value="<?php echo @$settings['customer_field_labels']['phone']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_email_address'); ?></label>
			<input name="customer_field_labels[email_address]" type="text" value="<?php echo @$settings['customer_field_labels']['email_address']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_company'); ?></label>
			<input name="customer_field_labels[company]" type="text" value="<?php echo @$settings['customer_field_labels']['company']; ?>" />
		</fieldset>

		<div class="ct_form_header">
			<h2><?php echo $LANG->line('validation_customer_shipping_address'); ?></h2>
		</div>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_first_name'); ?></label>
			<input name="customer_field_labels[shipping_first_name]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_first_name']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_last_name'); ?></label>
			<input name="customer_field_labels[shipping_last_name]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_last_name']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_address'); ?></label>
			<input name="customer_field_labels[shipping_address]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_address']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_address2'); ?></label>
			<input name="customer_field_labels[shipping_address2]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_address2']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_city'); ?></label>
			<input name="customer_field_labels[shipping_city]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_city']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_state'); ?></label>
			<input name="customer_field_labels[shipping_state]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_state']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_zip'); ?></label>
			<input name="customer_field_labels[shipping_zip]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_zip']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_shipping_option'); ?></label>
			<input name="customer_field_labels[shipping_option]" type="text" value="<?php echo @$settings['customer_field_labels']['shipping_option']; ?>" />
		</fieldset>

		<div class="ct_form_header">
			<h2><?php echo $LANG->line('validation_credit_card_information'); ?></h2>
		</div>

		<fieldset >
			<label><?php echo $LANG->line('validation_credit_card_number'); ?></label>
			<input name="customer_field_labels[credit_card_number]" type="text" value="<?php echo @$settings['customer_field_labels']['credit_card_number']; ?>" />
		</fieldset>

		<fieldset >
			<label><?php echo $LANG->line('validation_expiration_month'); ?></label>
			<input name="customer_field_labels[expiration_month]" type="text" value="<?php echo @$settings['customer_field_labels']['expiration_month']; ?>" />
		</fieldset>

		<fieldset >
			<label><?php echo $LANG->line('validation_expiration_year'); ?></label>
			<input name="customer_field_labels[expiration_year]" type="text" value="<?php echo @$settings['customer_field_labels']['expiration_year']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('validation_card_code'); ?></label>
			<input name="customer_field_labels[card_code]" type="text" value="<?php echo @$settings['customer_field_labels']['card_code']; ?>" />
		</fieldset>
	</div>