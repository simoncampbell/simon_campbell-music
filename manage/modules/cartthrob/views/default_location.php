<?php global $LANG; ?>           
	<!-- start instruction box -->
	<div class="ct_instruction_box">
		<h2><?php echo $LANG->line('default_location_header'); ?></h2>
		<p><?php echo $LANG->line('default_location_description'); ?></p>
	</div>

	<!-- end instruction box -->
	<div id="ct_form_options">

		<div class="legend">
			<div class="ct_instruction_left"> 
				<strong><?php echo $LANG->line('default_location_form_field_name'); ?></strong><br />
				<?php echo $LANG->line('default_location_form_field_description'); ?>
			</div>
			<div class="ct_instruction_right"> 
				<strong><?php echo $LANG->line('default_location_default_display_text'); ?></strong><br />
				<?php echo $LANG->line('default_location_default_display_description'); ?>
			</div>
			<div class="clear"></div>
		</div>

		<fieldset >
			<label>state</label>
			<input name="default_location[state]" type="text" value="<?php echo @$settings['default_location']['state']; ?>" />
		</fieldset>

		<fieldset >
			<label>zip</label>
			<input name="default_location[zip]" type="text" value="<?php echo @$settings['default_location']['zip']; ?>" />
		</fieldset>

		<fieldset>
			<label>country_code</label>
			<input name="default_location[country_code]" type="text" value="<?php echo @$settings['default_location']['country_code']; ?>" />
		</fieldset>

		<fieldset>
			<label>region</label>
			<input name="default_location[region]" type="text" value="<?php echo @$settings['default_location']['region']; ?>" />
		</fieldset>

		<fieldset >
			<label>shipping_state</label>
			<input name="default_location[shipping_state]" type="text" value="<?php echo @$settings['default_location']['shipping_state']; ?>" />
		</fieldset>

		<fieldset >
			<label>shipping_zip</label>
			<input name="default_location[shipping_zip]" type="text" value="<?php echo @$settings['default_location']['shipping_zip']; ?>" />
		</fieldset>

		<fieldset>
			<label>shipping_country_code</label>
			<input name="default_location[shipping_country_code]" type="text" value="<?php echo @$settings['default_location']['shipping_country_code']; ?>" />
		</fieldset>

		<fieldset>
			<label>shipping_region</label>
			<input name="default_location[region]" type="text" value="<?php echo @$settings['default_location']['shipping_region']; ?>" />
		</fieldset>

	</div>