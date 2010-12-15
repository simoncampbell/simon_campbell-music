<?php global $LANG; ?>
<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('global_settings_header'); ?> </h2>
	<p><?php echo $LANG->line('global_settings_description'); ?></p>
</div>
<!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('customer_login_options'); ?></h2>
	</div>

	<fieldset>
		<label><?php echo $LANG->line('logged_in'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='logged_in' value='1' <?php if ($settings['logged_in']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='logged_in' value='0' <?php if ( ! $settings['logged_in']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('no'); ?>
		</label>
		<p><?php echo $LANG->line('global_settings_login_description'); ?></p>  
	</fieldset>

	<fieldset>
		<label><?php echo $LANG->line('global_settings_default_member_id'); ?></label>
		<input  dir='ltr' type='text' name='default_member_id' id='default_member_id' value='<?php echo $settings['default_member_id']; ?>' size='90' maxlength='100' />
		<p><?php echo $LANG->line('global_settings_default_member_id_description'); ?></p>  
	</fieldset> 

	<div class="ct_form_header">
		<h2><?php echo $LANG->line('global_settings_session_options'); ?></h2>
	</div>

	<fieldset>
		<label><?php echo $LANG->line('global_settings_session_expire'); ?></label>
		<input  dir='ltr' type='text' name='session_expire' id='session_expire' value='<?php echo $settings['session_expire']; ?>' size='90' maxlength='100' />
		<p><?php echo $LANG->line('global_settings_session_description'); ?></p>  
	</fieldset> 

	<div class="ct_form_header">
		<h2><?php echo $LANG->line('global_settings_cart_history'); ?></h2>
	</div>   

	<fieldset>
		<label><?php echo $LANG->line('global_settings_clear_cart'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='clear_cart_on_logout' value='1' <?php if ($settings['clear_cart_on_logout']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='clear_cart_on_logout' value='0' <?php if ( ! $settings['clear_cart_on_logout']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('no'); ?> 
		</label>
		<p><?php echo $LANG->line('global_settings_clear_cart_description'); ?></p>  
	</fieldset>
	
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('global_settings_checkout_options'); ?></h2>
	</div>   

	<fieldset>
		<label><?php echo $LANG->line('allow_empty_cart_checkout'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='allow_empty_cart_checkout' value='1' <?php if ($settings['allow_empty_cart_checkout']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='allow_empty_cart_checkout' value='0' <?php if ( ! $settings['allow_empty_cart_checkout']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('no'); ?> 
		</label>
		<p><?php echo $LANG->line('allow_empty_cart_checkout_description'); ?></p>  
	</fieldset>

	<fieldset>
		<label><?php echo $LANG->line('global_settings_allow_gateway_selection'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='allow_gateway_selection' value='1' <?php if ($settings['allow_gateway_selection']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='allow_gateway_selection' value='0' <?php if ( ! $settings['allow_gateway_selection']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('no'); ?> 
		</label>
		<p><?php echo $LANG->line('global_settings_allow_gateway_selection_description'); ?></p>  
		
	</fieldset>

	<fieldset>
		<label><?php echo $LANG->line('global_settings_encode_gateway_selection'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='encode_gateway_selection' value='1' <?php if ($settings['encode_gateway_selection']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='encode_gateway_selection' value='0' <?php if ( ! $settings['encode_gateway_selection']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('no'); ?> 
		</label>
		<p><?php echo $LANG->line('global_settings_encode_gateway_selection_description'); ?></p>  
		
	</fieldset>

	<div class="ct_form_header">
		<h2><?php echo $LANG->line('global_settings_quantity_options'); ?></h2>
	</div>  

	<fieldset>
		<label><?php echo $LANG->line('global_settings_quantity_limit'); ?></label>
		<input  dir='ltr' type='text' name='global_item_limit' id='global_item_limit' value='<?php echo $settings['global_item_limit']; ?>' size='90' maxlength='100' />
		<p><?php echo $LANG->line('global_settings_quantity_description'); ?></p>  
	</fieldset>  

	<div class="ct_form_header">
		<h2><?php echo $LANG->line('globaL_settings_cc_validation'); ?></h2>
	</div>  

	<fieldset>
		<label><?php echo $LANG->line('global_settings_cc_modulus_checking'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='modulus_10_checking' value='1' <?php if ($settings['modulus_10_checking']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='modulus_10_checking' value='0' <?php if ( ! $settings['modulus_10_checking']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('no'); ?> 
		</label>
		<p><?php echo $LANG->line('global_settings_cc_modulus_description'); ?></p>  

	</fieldset>


	<div class="ct_form_header">
		<h2><?php echo $LANG->line('global_settings_logging'); ?></h2>
	</div>  

	<fieldset>
		<label><?php echo $LANG->line('global_settings_logging_enabled'); ?></label>
		<label class="radio">
			<input class='radio' type='radio' name='enable_logging' value='1' <?php if ($settings['enable_logging']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='enable_logging' value='0' <?php if ( ! $settings['enable_logging']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('no'); ?> 
		</label>
		<p><?php echo $LANG->line('global_settings_logging_description'); ?></p>  
		
	</fieldset>

	
</div>