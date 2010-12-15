<?php global $LANG; ?>

<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('orders_header'); ?></h2>
	<p><?php echo $LANG->line('orders_options_description'); ?></p>
</div> 
<!-- end instruction box -->

<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('orders_form_header'); ?></h2>
		<p></p> 
	</div> 
	
	<fieldset>
		<label> <?php echo $LANG->line('section'); ?></label>
		<select name='orders_weblog' class="weblogs" id="select_orders">
			<option value=''></option>
			<?php foreach ($weblogs as $weblog) : ?>
			<option value="<?php echo $weblog['weblog_id']; ?>" <?php if ($settings['orders_weblog'] == $weblog['weblog_id']) : ?>selected="selected"<?php endif; ?>>
				<?php echo $weblog['blog_title']; ?>
			</option>
			<?php endforeach; ?>
		</select>                    
	</fieldset>	

	<fieldset>
		<label><?php echo $LANG->line('save_orders'); ?>?</label>
		<p><?php echo $LANG->line('orders_saving_instructions'); ?></p>
		<label class="radio">
			<input class='radio' type='radio' name='save_orders' value='1' <?php if ($settings['save_orders']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='save_orders' value='0' <?php if ( ! $settings['save_orders']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('no'); ?>
		</label>
	</fieldset>

	<fieldset>
		<label><?php echo $LANG->line('order_numbers'); ?></label>
		<p><?php echo $LANG->line('order_numbers_instructions'); ?></p>
		<label class="radio">
			<input class='radio' type='radio' name='orders_sequential_order_numbers' value='0' <?php if ( ! $settings['orders_sequential_order_numbers']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('order_numbers_entry_id'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='orders_sequential_order_numbers' value='1' <?php if ($settings['orders_sequential_order_numbers']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('order_numbers_sequential'); ?>
		</label>
	</fieldset>
	
	<fieldset>
		<label> <?php echo $LANG->line('orders_title_prefix'); ?></label>
		<input type="text" name="orders_title_prefix" value="<?php echo $settings['orders_title_prefix']; ?>" />           
	</fieldset>
	
	<fieldset>
		<label> <?php echo $LANG->line('orders_title_suffix'); ?></label>
		<input type="text" name="orders_title_suffix" value="<?php echo $settings['orders_title_suffix']; ?>" />           
	</fieldset>
	
	<fieldset>
		<label> <?php echo $LANG->line('orders_url_title_prefix'); ?></label>
		<input type="text" name="orders_url_title_prefix" value="<?php echo $settings['orders_url_title_prefix']; ?>" />           
	</fieldset>
	
	<fieldset>
		<label> <?php echo $LANG->line('orders_url_title_suffix'); ?></label>
		<input type="text" name="orders_url_title_suffix" value="<?php echo $settings['orders_url_title_suffix']; ?>" />           
	</fieldset>

	<fieldset>
		<label><?php echo $LANG->line('orders_convert_country_code'); ?>?</label>
		<p><?php echo $LANG->line('orders_convert_country_code_instructions'); ?></p>
		<label class="radio">
			<input class='radio' type='radio' name='orders_convert_country_code' value='1' <?php if ($settings['orders_convert_country_code']) : ?>checked='checked'<?php endif; ?> />
			<?php echo $LANG->line('yes'); ?>
		</label>
		<label class="radio">
			<input class='radio' type='radio' name='orders_convert_country_code' value='0' <?php if ( ! $settings['orders_convert_country_code']) : ?>checked='checked'<?php endif; ?> /> 
			<?php echo $LANG->line('no'); ?>
		</label>
	</fieldset>


	<div class="requires_orders_blog" style="display:none">
		<div class="ct_form_header">                    
			<h2><?php echo $LANG->line('orders_status_field'); ?></h2>
			<div class="tooltip_icon"><a rel="#order_data_fields" href="#order_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
		</div>

		<fieldset>
			<label><?php echo $LANG->line('orders_default_status'); ?></label>
			<p><?php echo $LANG->line('orders_set_status'); ?> </p>
			<select name='orders_default_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($statuses[$settings['orders_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['orders_default_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset> 

		<fieldset>
			<label><?php echo $LANG->line('orders_processing_status'); ?></label>
			<p><?php echo $LANG->line('orders_set_processing_status'); ?> </p>
			<select name='orders_processing_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($statuses[$settings['orders_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['orders_processing_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>        

		<fieldset>
			<label><?php echo $LANG->line('orders_failed_status'); ?></label>
			<select name='orders_failed_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($statuses[$settings['orders_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['orders_failed_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>        

		<fieldset>
			<label><?php echo $LANG->line('orders_declined_status'); ?></label>
			<select name='orders_declined_status' class='select status_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($statuses[$settings['orders_weblog']] as $status) : ?>
						<option value="<?php echo $status['status']; ?>" <?php if ($settings['orders_declined_status'] == $status['status']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $status['status']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>            

		<div class="ct_form_header">
			<h2><?php echo $LANG->line('order_data_fields'); ?></h2>
			<div class="tooltip_icon"><a rel="#order_data_fields" href="#order_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
			<p><?php echo $LANG->line('order_data_fields_instructions'); ?></p>
   		</div>
		<div class="hidden_tooltip" id="order_data_fields">
			<p><strong><?php echo $LANG->line('choose_a_webog'); ?></strong></p> 
			<p><?php echo $LANG->line('order_info_is_not_required'); ?></p>
		</div>    
		<div class="legend">
			<div class="ct_instruction_left">
				<strong><?php echo $LANG->line('order_data_type'); ?></strong><br />
				<?php echo $LANG->line('order_data_type_instructions'); ?>
			</div>
			<div class="ct_instruction_right"> 
				<strong><?php echo $LANG->line('orders_weblog'); ?></strong><br />
				<?php echo $LANG->line('order_fields_in_weblog'); ?>
			</div>
			<div class="clear"></div>
		</div>     
		<fieldset>
			<label><?php echo $LANG->line('orders_items_field'); ?></label>
			<p><?php echo $LANG->line('orders_items_field_instructions'); ?></p>
			<select name='orders_items_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_items_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>   
				<?php endif; ?>         
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_subtotal_field'); ?> </label>
			<select name='orders_subtotal_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_subtotal_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
						<?php echo $field['field_label']; ?></option>
					<?php endforeach; ?>
				<?php endif; ?>
				</select>   
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_tax_field'); ?> </label>
			<p><?php echo $LANG->line('orders_tax_instructions'); ?></p>
			<select name='orders_tax_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_tax_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>   
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_field'); ?> </label>
			<p><?php echo $LANG->line('orders_shipping_field_instructions'); ?></p>
			<select name='orders_shipping_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_discount_field'); ?> </label>
			<p><?php echo $LANG->line('orders_discount_field_instructions'); ?></p>
			<select name='orders_discount_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_discount_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_total_field'); ?> </label>
			<select name='orders_total_field' class='select field_orders' >
			<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_total_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select> 
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_transaction_id'); ?> </label>
			<p><?php echo $LANG->line('orders_transaction_id_instructions'); ?></p>
			<select name='orders_transaction_id' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_transaction_id'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_last_four_digits'); ?> </label>
			<p><?php echo $LANG->line('orders_last_four_digits_instructions'); ?></p>
			<select name='orders_last_four_digits' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_last_four_digits'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_coupon_codes'); ?> </label>
			<p><?php echo $LANG->line('orders_coupon_codes_instructions'); ?></p>
			<select name='orders_coupon_codes' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_coupon_codes'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>    
			</select>   
		</fieldset>  
		
		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_method'); ?> </label>
			<p><?php echo $LANG->line('orders_shipping_method_instructions'); ?></p>
			<select name='orders_shipping_option' class='select field_orders' >
	   			<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_option'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_error_message_field'); ?> </label>
			<p><?php echo $LANG->line('orders_error_message_field_instructions'); ?></p>
			<select name='orders_error_message_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_error_message_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select> 
		</fieldset> 

		<fieldset>
			<label> <?php echo $LANG->line('orders_language_field'); ?> </label>
			<p><?php echo $LANG->line('orders_language_field_instructions'); ?></p>
			<select name='orders_language_field' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_language_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select> 
		</fieldset> 

		<div class="ct_form_header">
			<h2><?php echo $LANG->line('orders_customer_info_fields_header'); ?></h2>
			<div class="tooltip_icon"><a rel="#order_data_fields" href="#order_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
			<p><?php echo $LANG->line('orders_customer_info_fields_instructions'); ?></p>
	    </div>

		<fieldset>
			<label> <?php echo $LANG->line('orders_customer_name'); ?> </label>
			<p><?php echo $LANG->line('orders_customer_name_instructions'); ?></p>
			<select name='orders_customer_name' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_customer_name'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>              
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_customer_email'); ?> </label>
			<p><?php echo $LANG->line('orders_customer_email_instructions'); ?></p>
			<select name='orders_customer_email' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_customer_email'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>            
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_customer_ip_address'); ?> </label>
			<select name='orders_customer_ip_address' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_customer_ip_address'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select>
		</fieldset>
		
		<fieldset>
			<label> <?php echo $LANG->line('orders_customer_phone'); ?> </label>
			<select name='orders_customer_phone' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_customer_phone'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select> 
		</fieldset> 
		
		<div class="ct_form_header">
			<h2><?php echo $LANG->line('orders_billing_info_fields'); ?></h2>
			<div class="tooltip_icon"><a rel="#order_data_fields" href="#order_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
	    </div>

		<fieldset>
			<label> <?php echo $LANG->line('orders_full_billing_address'); ?> </label>
			<p><?php echo $LANG->line('orders_full_billing_address_instructions'); ?></p>
			<select name='orders_full_billing_address' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_full_billing_address'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_first_name'); ?> </label>
			<select name='orders_billing_first_name' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_first_name'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_last_name'); ?> </label>
			<select name='orders_billing_last_name' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_last_name'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select>
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_company'); ?> </label>
			<select name='orders_billing_company' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_company'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select>
		</fieldset>
		
		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_address'); ?> </label>
			<select name='orders_billing_address' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_address'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_address2'); ?> </label>
			<select name='orders_billing_address2' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_address2'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_city'); ?> </label>
			<select name='orders_billing_city' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_city'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?> 
				<?php endif; ?> 
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_state'); ?> </label>
			<select name='orders_billing_state' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_state'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_zip'); ?> </label>
			<select name='orders_billing_zip' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_zip'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>   
			</select>   
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_country'); ?> </label>
			<select name='orders_billing_country' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_billing_country'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>   
			</select>   
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_billing_country_code'); ?> </label>
			<select name='orders_country_code' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_country_code'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select> 
		</fieldset> 
		
		<div class="ct_form_header">
			<h2><?php echo $LANG->line('orders_shipping_info_fields'); ?></h2>
			<div class="tooltip_icon"><a rel="#order_data_fields" href="#order_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
	    </div>
	
		<fieldset>
			<label> <?php echo $LANG->line('orders_full_shipping_address'); ?> </label>
			<p><?php echo $LANG->line('orders_shipping_info_fields_instructions'); ?></p>
			<select name='orders_full_shipping_address' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_full_shipping_address'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>  
				<?php endif; ?>
			</select> 
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_first_name'); ?> </label>
			<select name='orders_shipping_first_name' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_first_name'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?> 
				<?php endif; ?> 
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_last_name'); ?> </label>
			<select name='orders_shipping_last_name' class='select field_orders' >
	   			<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_last_name'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?> 
				<?php endif; ?>
			</select> 
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_company'); ?> </label>
			<select name='orders_shipping_company' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_company'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select>
		</fieldset>
		
		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_address'); ?> </label>
			<select name='orders_shipping_address' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_address'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>
			</select> 
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_address2'); ?> </label>
			<select name='orders_shipping_address2' class='select field_orders' >
	   			<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_address2'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>   
					<?php endforeach; ?>
				<?php endif; ?>
			</select> 
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_city'); ?> </label>
			<select name='orders_shipping_city' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_city'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?>  
			</select>   
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_state'); ?> </label>
			<select name='orders_shipping_state' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_state'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option> 
					<?php endforeach; ?>
				<?php endif; ?> 
			</select>  
		</fieldset>

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_zip'); ?> </label>
			<select name='orders_shipping_zip' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_zip'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>   
					<?php endforeach; ?> 
				<?php endif; ?>
			</select>  
		</fieldset>   
		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_country'); ?> </label>
			<select name='orders_shipping_country' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_country'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>   
					<?php endforeach; ?> 
				<?php endif; ?>
			</select>  
		</fieldset> 

		<fieldset>
			<label> <?php echo $LANG->line('orders_shipping_country_code'); ?> </label>
			<select name='orders_shipping_country_code' class='select field_orders' >
				<option value='' class="blank" ></option>
				<?php if ($settings['orders_weblog']) : ?>
					<?php foreach ($fields[$settings['orders_weblog']] as $field) : ?>
						<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['orders_shipping_country_code'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
							<?php echo $field['field_label']; ?>
						</option>
					<?php endforeach; ?>
				<?php endif; ?> 
			</select> 
		</fieldset> 
	</div> <!-- // end requires blog div -->
</div>