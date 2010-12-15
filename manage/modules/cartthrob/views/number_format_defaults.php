<?php global $LANG; ?>

<!-- start instruction box -->
<div class="ct_instruction_box">
  <h2><?php echo $LANG->line('number_format_defaults_heading'); ?></h2>
  <p><?php echo $LANG->line('number_format_defaults_description'); ?></p>
</div>

<!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
                
<h2><?php echo $LANG->line('number_format_defaults_header'); ?></h2>
	</div>


		<fieldset>
			<label><?php echo $LANG->line('number_format_defaults_decimals'); ?></label>
			<input  dir='ltr' type='text' name='number_format_defaults_decimals' id='number_format_defaults_decimals' value='<?php echo $settings['number_format_defaults_decimals']; ?>' size='90' maxlength='100' />
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('number_format_defaults_dec_point'); ?></label>
			<input  dir='ltr' type='text' name='number_format_defaults_dec_point' id='number_format_defaults_dec_point' value='<?php echo $settings['number_format_defaults_dec_point']; ?>' size='90' maxlength='100' />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('number_format_defaults_thousands_sep'); ?></label>
			<input  dir='ltr' type='text' name='number_format_defaults_thousands_sep' id='number_format_defaults_thousands_sep' value='<?php echo $settings['number_format_defaults_thousands_sep']; ?>' size='90' maxlength='100' />
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('number_format_defaults_prefix'); ?></label>
			<input  dir='ltr' type='text' name='number_format_defaults_prefix' id='number_format_defaults_prefix' value='<?php echo $settings['number_format_defaults_prefix']; ?>' size='90' maxlength='100' />
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('number_format_defaults_currency_code'); ?></label>
			<input  dir='ltr' type='text' name='number_format_defaults_currency_code' id='number_format_defaults_currency_code' value='<?php echo $settings['number_format_defaults_currency_code']; ?>' size='90' maxlength='100' />
		</fieldset>
		
		
			<div class="ct_form_header">
				<h2><?php echo $LANG->line('global_settings_rounding_options'); ?></h2>
			</div>  

			<fieldset>
				<label><?php echo $LANG->line('round_to'); ?></label>
				<label class="radio">
				<input class='radio' type='radio' name='rounding_default' value='standard' <?php if (! $settings['rounding_default'] || $settings['rounding_default'] =="standard") : ?>checked='checked'<?php endif; ?> /> 
					<?php echo $LANG->line('rounding_standard'); ?>
			<input class='radio' type='radio' name='rounding_default' value='swedish' <?php if ($settings['rounding_default'] == "swedish") : ?>checked='checked'<?php endif; ?> /> 
						
					<?php echo $LANG->line('rounding_swedish'); ?>
			<input class='radio' type='radio' name='rounding_default' value='new_zealand' <?php if ($settings['rounding_default'] == "new_zealand") : ?>checked='checked'<?php endif; ?> /> 

					<?php echo $LANG->line('rounding_new_zealand'); ?>
				</label>
				<p><?php echo $LANG->line('rounding_description'); ?></p>  
			</fieldset>
</div>