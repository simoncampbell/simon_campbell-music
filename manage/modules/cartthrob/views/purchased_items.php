<?php global $LANG; ?>           
<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('purchased_items_headers'); ?></h2>
	<p><?php echo $LANG->line('purchased_items_description'); ?></p>
</div>

<!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('purchased_items_form_header'); ?></h2>
		<p></p>
	</div>

	<fieldset>
		<label>
			<?php echo $LANG->line('save_purchased_items'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='save_purchased_items' value='1' <?php if ($settings['save_purchased_items']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='save_purchased_items' value='0' <?php if ( ! $settings['save_purchased_items']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('no'); ?>
		</label>
	</fieldset>

	<fieldset>
		<label><?php echo $LANG->line('purchased_items_weblog'); ?></label>
		<select name='purchased_items_weblog' class="weblogs" id='select_purchased_items' >
			<option value=''></option>
			<?php foreach ($weblogs as $weblog) : ?>
				<option value="<?php echo $weblog['weblog_id']; ?>" <?php if ($settings['purchased_items_weblog'] == $weblog['weblog_id']) : ?>selected="selected"<?php endif; ?>>
					<?php echo $weblog['blog_title']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	
	<div class="requires_purchased_items_blog" style="display:none">
		<div class="ct_form_header">                    
			<h2><?php echo $LANG->line('purchased_items_status_field'); ?></h2>
		</div>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_default_status'); ?></label>
			<p><?php echo $LANG->line('purchased_items_set_status'); ?> </p>
			<select name='purchased_items_default_status' class='select status_purchased_items' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($statuses[$settings['purchased_items_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['purchased_items_default_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset> 
		
		
		<fieldset>
			<label><?php echo $LANG->line('purchased_items_processing_status'); ?></label>
			<p><?php echo $LANG->line('purchased_items_set_processing_status'); ?> </p>
			<select name='purchased_items_processing_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($statuses[$settings['purchased_items_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['purchased_items_processing_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>        

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_failed_status'); ?></label>
			<select name='purchased_items_failed_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($statuses[$settings['purchased_items_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['purchased_items_failed_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>        

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_declined_status'); ?></label>
			<select name='purchased_items_declined_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($statuses[$settings['purchased_items_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['purchased_items_declined_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>
		</div>

	<div style="display:none" class="requires_purchased_items_blog">
		<div class="ct_form_header">
			<h2><?php echo $LANG->line('purchased_items_data_fields'); ?></h2>
			<div class="tooltip_icon">
				<a rel="#products_data_fields" href="#products_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a>
			</div>
			<p><?php echo $LANG->line('purchased_items_data_fields_description'); ?></p>
		</div>
		<div class="hidden_tooltip" id="products_data_fields">
			<?php echo $LANG->line('purchased_items_data_fields_tooltip'); ?>
		</div>    
		<div class="legend">
			<div class="ct_instruction_left"> 
				<strong><?php echo $LANG->line('purchased_items_data_type'); ?></strong><br />
				<?php echo $LANG->line('purchased_items_data_type_description'); ?>
			</div>
			<div class="ct_instruction_right"> <strong><?php echo $LANG->line('purchased_items_weblog_field'); ?></strong><br />
				<?php echo $LANG->line('purchased_items_weblog_field_description'); ?>
			</div>
			<div class="clear"></div>
		</div>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_title_prefix'); ?></label>
			<input type="text" name="purchased_items_title_prefix" value="<?php echo $settings['purchased_items_title_prefix']; ?>" />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_id_field'); ?></label>
			<select name='purchased_items_id_field' class='select field_purchased_items' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($fields[$settings['purchased_items_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['purchased_items_id_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_quantity_field'); ?></label>
			<select name='purchased_items_quantity_field' class='select field_purchased_items' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($fields[$settings['purchased_items_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['purchased_items_quantity_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_price_field'); ?></label>
			<select name='purchased_items_price_field' class='select field_purchased_items' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($fields[$settings['purchased_items_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['purchased_items_price_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_order_id_field'); ?></label>
			<select name='purchased_items_order_id_field' class='select field_purchased_items' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($fields[$settings['purchased_items_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['purchased_items_order_id_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_license_number_field'); ?></label>
			<select name='purchased_items_license_number_field' class='select field_purchased_items' >
				<option value='' class="blank" ></option>
				<?php if ($settings['purchased_items_weblog']) : ?>
					<?php foreach ($fields[$settings['purchased_items_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['purchased_items_license_number_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('purchased_items_license_number_type'); ?></label>
			<select name='purchased_items_license_number_type' class='select field_purchased_items' >
				<option value='uuid' class="blank" >UUID/GUID</option>
			</select>
		</fieldset>
	</div>
</div>