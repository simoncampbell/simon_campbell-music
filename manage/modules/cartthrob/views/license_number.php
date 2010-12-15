<?php global $LANG; ?>
<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('license_number_header'); ?> </h2>
	<p><?php echo $LANG->line('license_number_description'); ?></p>
</div>
<!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('license_number_label'); ?></h2>
	</div>

	<fieldset>
		<label><?php echo $LANG->line('license_number_label'); ?></label>
		<input  dir='ltr' type='text' name='license_number' id='license_number' value='<?php echo $settings['license_number']; ?>' size='90' maxlength='100' />
	</fieldset>
</div>