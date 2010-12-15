<?php global $PREFS, $LANG; ?>
<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('tax_header'); ?></h2>
	<p><?php echo $LANG->line('tax_description'); ?></p>
</div>
<!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('tax_form_header'); ?></h2>
		<p><?php echo $LANG->line('tax_form_header_description'); ?></p>
	</div>
	<fieldset>
		<label class="checkbox"><input type="checkbox" name="tax_use_shipping_address" class="int_tax_shipping_address" value="1" <?php if ( ! empty($settings['tax_use_shipping_address'])) : ?>checked="checked"<?php endif; ?> /> Use Shipping Address?</label>
	</fieldset>
	<div class="legend">
		<div class="ct_instruction_int_left">
			<?php echo $LANG->line('tax_form_legend'); ?>
		</div>
		<div class="clear"></div>
	</div>
	<?php
		if ( ! $settings['tax_settings'] || ! count($settings['tax_settings']))
	    {
			$settings['tax_settings'][] = array(
				'state' => '',
				'zip' => '',
				'rate' => '',
				'name' => '',
			    );
		  }
	?>
	<?php foreach ($settings['tax_settings'] as $count => $setting) : ?>
		<fieldset class="int_tax_setting" id="int_tax_setting_<?php echo $count; ?>">
			<div class="int_tax_info">
				<?php echo $LANG->line('tax_name'); ?> 
				<input name="tax_settings[<?php echo $count; ?>][name]" type="text" value="<?php echo $setting['name']; ?>" class="int_name" /> 
				<?php echo $LANG->line('tax_percent'); ?>
				<input name="tax_settings[<?php echo $count; ?>][rate]" type="text" value="<?php echo $setting['rate']; ?>" class="int_tax_rate" />
				<?php echo $LANG->line('tax_state'); ?>
				<select name="tax_settings[<?php echo $count; ?>][state]" size="1" class="int_state_dropdown">
					<option value="">--------</option>
						<?php foreach($states_and_countries as $abbrev => $state) : ?>
							<option value="<?php echo $abbrev; ?>" <?php if (@$setting['state'] == $abbrev) : ?>selected="selected"<?php endif; ?>>
								<?php echo $state; ?>
							</option>
						<?php endforeach; ?>
				</select> 
				<strong><span class="red">&nbsp;<?php echo $LANG->line('or'); ?>&nbsp;</span></strong>
				<?php echo $LANG->line('tax_region'); ?> 
				<input name="tax_settings[<?php echo $count; ?>][zip]" type="text" class="int_zip_code_box" value="<?php echo @$setting['zip']; ?>" />
				<label class="checkbox"><input type="checkbox" name="tax_settings[<?php echo $count; ?>][tax_shipping]" class="int_tax_shipping" value="1" <?php if ( ! empty($setting['tax_shipping'])) : ?>checked="checked"<?php endif; ?> /> Tax Shipping?</label>
			</div>
			<a href="#" class="remove_matrix_row" style="display:block;float:right;margin: 0 0 0 8px;position:relative;top:2px;">
				<img border="0" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
			</a>
		</fieldset>
	<?php endforeach; ?>
	<fieldset id="add_int_tax_setting">
		<a href="#" class="ct_add_field_bttn"><?php echo $LANG->line('tax_add_another_setting'); ?></a>
	</fieldset>
	<fieldset  id="int_tax_setting_blank" style="display:none;">
		<div class="int_tax_info">
			<?php echo $LANG->line('tax_name'); ?> 
			<input type="text" class="int_name" /> 	
			<?php echo $LANG->line('tax_percent'); ?> 
			<input class="int_tax_rate" type="text" /> 		
			<?php echo $LANG->line('tax_state'); ?> 
			<select size="1" class="int_state_dropdown">
				<option value="">--------</option>
				<?php foreach($states_and_countries as $abbrev => $state) : ?>
					<option value="<?php echo $abbrev; ?>"><?php echo $state; ?></option>
				<?php endforeach; ?>
			</select> 
			<strong><span class="red">&nbsp;<?php echo $LANG->line('or'); ?>&nbsp;</span></strong>
			<?php echo $LANG->line('tax_region'); ?> 
			<input type="text" class="int_zip_code_box" /> 
			<label class="checkbox"><input type="checkbox" class="int_tax_shipping" value="1" /> Tax Shipping?</label>
		</div>
		<a href="#" class="remove_matrix_row" style="display:block;float:right;margin: 0 0 0 8px;position:relative;top:2px;">
			<img border="0" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
		</a>
	</fieldset>
</div>