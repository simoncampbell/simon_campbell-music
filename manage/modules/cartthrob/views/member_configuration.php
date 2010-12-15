<?php global $LANG; ?>

<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('members_header'); ?></h2>
	<p><?php echo $LANG->line('members_description'); ?></p>
</div> 
<!-- end instruction box -->

<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('members_form_header'); ?></h2>
		<p></p> 
	</div> 
	
	<fieldset>
		<label><?php echo $LANG->line('members_save_data'); ?>?</label>
		<p><?php echo $LANG->line('members_saving_instructions'); ?></p>
		<label class="radio">
			<input class='radio' type='radio' name='save_member_data' value='1' <?php if ($settings['save_member_data']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='save_member_data' value='0' <?php if ( ! $settings['save_member_data']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('no'); ?>
		</label>
	</fieldset>	

	<div class="requires_member_save">
		<div class="ct_form_header">
			<h2><?php echo $LANG->line('member_data_fields_header'); ?></h2>
			<p><?php echo $LANG->line('member_data_fields_instructions'); ?></p>
   		</div>
		<div class="legend">
			<div class="ct_instruction_left">
				<strong><?php echo $LANG->line('member_data_template_fields'); ?></strong><br />
			</div>
			<div class="ct_instruction_right"> 
				<strong><?php echo $LANG->line('member_data_custom_fields'); ?></strong><br />
			</div>
			<div class="clear"></div>
		</div>  
		<?php
		
		$customer_data_fields = array(
			'first_name',
			'last_name',
			'address',
			'address2',
			'city',
			'state',
			'zip',
			'country',
			'country_code',
			'company',

			'phone',
			'email_address',
			'use_billing_info',

			'shipping_first_name',
			'shipping_last_name',
			'shipping_address',
			'shipping_address2',
			'shipping_city',
			'shipping_state',
			'shipping_zip',
			'shipping_country',
			'shipping_country_code',
			'shipping_company',

			'language',
			'shipping_option',
			'region'
			
		);
		
		if (isset($member_fields))
		{
			foreach($customer_data_fields as $value)
			{
				echo "<fieldset>"; 
				echo "<label>".ucwords(str_replace('_', ' ', $value))." (".$value.")</label>";
				echo "<select name='member_".$value."_field' class='select field_orders' >"; 
				echo "<option value='' class='blank' ></option>";
				foreach ($member_fields as $value2)
				{
					echo "<option value='".$value2['m_field_id']."' ".(($settings["member_".$value."_field"]== $value2['m_field_id'])? "selected " : "").">"; 
					echo $value2['m_field_label'];
					echo "</option>"; 
					
				}
				echo "</select>";
				echo "</fieldset>";
			}
		}
		?>
	</div>
</div>