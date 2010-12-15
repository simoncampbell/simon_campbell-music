<?php global $PREFS, $LANG; ?>
<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('product_weblog_header'); ?></h2>
	<p><?php echo $LANG->line('product_weblog_description'); ?></p>
</div>

<!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('product_weblog_form_header'); ?></h2>
		<div class="tooltip_icon">
			<a rel="#manage_product_weblogs_tooltip" href="#manage_product_weblogs_tooltip" title="Tips" class="ct_question_bttn">?
			</a>
		</div>
		<p><?php echo $LANG->line('product_weblog_form_description'); ?> </p>
	</div>
	<div class="hidden_tooltip" id="manage_product_weblogs_tooltip">
		<?php echo $LANG->line('product_weblog_manage_tooltip'); ?>
	</div>
	<div class="legend">
		<div class="ct_product_column">
			<strong class="red">*<?php echo $LANG->line('product_weblog'); ?>:</strong>
			<br /><?php echo $LANG->line('product_weblog_choose_a_weblog'); ?> </div>
			<div class="ct_product_column">
				<strong><?php echo $LANG->line('product_weblog_price_field'); ?></strong><br />
				<?php echo $LANG->line('product_weblog_price_field_description'); ?> 
			</div>
			<div class="ct_product_column">
				<strong><?php echo $LANG->line('product_weblog_shipping_field'); ?></strong><br />
				<?php echo $LANG->line('product_weblog_shipping_field_description'); ?>
			</div>
			<div class="ct_product_column">
				<strong><?php echo $LANG->line('product_weblog_weight_field'); ?></strong><br />
				<?php echo $LANG->line('product_weblog_weight_field_description'); ?>
			</div>
			<!-- hide for now -->
			<div class="ct_product_column">
				<strong><?php echo $LANG->line('product_weblog_inventory_field'); ?></strong><br />
				<?php echo $LANG->line('product_weblog_inventory_field_description'); ?>
			</div>
			<div class="ct_product_column">
				<strong><?php echo $LANG->line('product_weblog_price_modifier_field'); ?></strong><br />
				<?php echo $LANG->line('product_weblog_price_modifier_field_description'); ?>
			</div>
			<div class="ct_product_column">
				<strong><?php echo $LANG->line('product_weblog_global_price'); ?></strong><br />
				<?php echo $LANG->line('product_weblog_global_price_description'); ?>
			</div>
			<div class="clear"></div>
		</div>
		
		<?php if (count($settings['product_weblogs']) && strlen(implode('', $settings['product_weblogs']))) : ?>
			<?php foreach ($settings['product_weblogs'] as $product_weblog) : ?>
				<div class="ct_product_weblogs">
					<select name='product_weblogs[]' class='ct_product_column product_weblog' >
						<option value='' class="blank" ></option>
						<?php foreach ($weblogs as $weblog) : ?>
							<option value="<?php echo $weblog['weblog_id']; ?>" <?php if ($product_weblog == $weblog['weblog_id']) : ?>selected="selected"<?php endif; ?>>
								<?php echo $weblog['blog_title']; ?>
							</option>
						<?php endforeach; ?>
					</select>
					<select name='product_weblog_fields[<?php echo $product_weblog; ?>][price]' class='ct_product_column product_price' >
						<option value='' class="blank" ></option>
						<?php foreach ($fields[$product_weblog] as $field) : ?>
							<option value="<?php echo $field['field_id']; ?>" <?php if (isset($settings['product_weblog_fields'][$product_weblog]['price']) && $settings['product_weblog_fields'][$product_weblog]['price'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
								<?php echo $field['field_label']; ?>
							</option>
						<?php endforeach; ?>
					</select>

					<select name='product_weblog_fields[<?php echo $product_weblog; ?>][shipping]' class='ct_product_column product_shipping' >
						<option value='' class="blank" ></option>
						<?php foreach ($fields[$product_weblog] as $field) : ?>
							<option value="<?php echo $field['field_id']; ?>" <?php if (isset($settings['product_weblog_fields'][$product_weblog]['shipping']) && $settings['product_weblog_fields'][$product_weblog]['shipping'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
								<?php echo $field['field_label']; ?>
							</option>
						<?php endforeach; ?>
					</select>

					<select name='product_weblog_fields[<?php echo $product_weblog; ?>][weight]' class='ct_product_column product_weight' >
						<option value='' class="blank" ></option>
						<?php foreach ($fields[$product_weblog] as $field) : ?>
							<option value="<?php echo $field['field_id']; ?>" <?php if (isset($settings['product_weblog_fields'][$product_weblog]['weight']) && $settings['product_weblog_fields'][$product_weblog]['weight'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
								<?php echo $field['field_label']; ?>
							</option>
						<?php endforeach; ?>
					</select>
<?php /**/ ?>
					<select name='product_weblog_fields[<?php echo $product_weblog; ?>][inventory]' class='ct_product_column product_inventory' >
						<option value='' class="blank" ></option>
						<?php foreach ($fields[$product_weblog] as $field) : ?>
							<option value="<?php echo $field['field_id']; ?>" <?php if (isset($settings['product_weblog_fields'][$product_weblog]['inventory']) && $settings['product_weblog_fields'][$product_weblog]['inventory'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>>
								<?php echo $field['field_label']; ?>
							</option>
						<?php endforeach; ?>
					</select>
  <?php /*    */ ?>

					<select multiple="multiple" size="3" name='product_weblog_fields[<?php echo $product_weblog; ?>][price_modifiers][]' class='ct_product_column product_price_modifiers' >
						<?php foreach ($fields[$product_weblog] as $field) : ?>
							<option value="<?php echo $field['field_id']; ?>" <?php if (isset($settings['product_weblog_fields'][$product_weblog]['price_modifiers']) && is_array($settings['product_weblog_fields'][$product_weblog]['price_modifiers']) && in_array($field['field_id'], $settings['product_weblog_fields'][$product_weblog]['price_modifiers'])) : ?>selected="selected"<?php endif; ?>>
								<?php echo $field['field_label']; ?>
							</option>
						<?php endforeach; ?>
					</select>

					<input  dir='ltr' type='text' name='product_weblog_fields[<?php echo $product_weblog; ?>][global_price]' value='<?php echo (isset($settings['product_weblog_fields'][$product_weblog]['global_price'])) ? $settings['product_weblog_fields'][$product_weblog]['global_price'] : ''; ?>' size='4' maxlength='128' class='ct_product_column product_global_price'  />

					<a href="#" class="remove_matrix_row" style="display:block;float:left;margin: 0 0 0 8px;position:relative;top: 9px;">
						<img border="0" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
					</a>
					<div class="clear"></div>
				</div>
			<?php endforeach; ?>
		<?php else : ?>
			<div class="ct_product_weblogs">
				<select name='product_weblogs[]' class='ct_product_column product_weblog' >
					<option value='' class="blank" ></option>
					<?php foreach ($weblogs as $weblog) : ?>
						<option value="<?php echo $weblog['weblog_id']; ?>">
							<?php echo $weblog['blog_title']; ?>
						</option>
					<?php endforeach; ?>
				</select>

				<select class='ct_product_column product_price' >
					<option value='' class="blank" ></option>
				</select>

				<select class='ct_product_column product_shipping' >
					<option value='' class="blank" ></option>
				</select>

				<select class='ct_product_column product_weight' >
					<option value='' class="blank" ></option>
				</select>

				<select class='ct_product_column product_inventory' >
					<option value='' class="blank" ></option>
				</select>

				<select multiple="multiple" size="3" class='ct_product_column product_price_modifiers' >
				</select>

				<input  dir='ltr' type='text' size='4' maxlength='128' class='ct_product_column product_global_price'  />

				<a href="#" class="remove_matrix_row" style="display:block;float:left;margin: 0 0 0 8px;position:relative;top: 9px;">
					<img border="0" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
				</a>
				<div class="clear"></div>	
			</div>
		<?php endif; ?>

		<fieldset id="add_product_weblog">
			<a href="#" class="ct_add_field_bttn">
				<?php echo $LANG->line('product_weblog_add_another_weblog'); ?>
			</a>
		</fieldset>

		<div class="ct_product_weblogs" id="product_weblog_blank" style="display:none;">
			<select class='ct_product_column product_weblog' >
				<option value='' class="blank" ></option>
				<?php foreach ($weblogs as $weblog) : ?>
					<option value="<?php echo $weblog['weblog_id']; ?>">
						<?php echo $weblog['blog_title']; ?>
					</option>
				<?php endforeach; ?>
			</select>

			<select class='ct_product_column product_price' >
				<option value='' class="blank" ></option>
			</select>

			<select class='ct_product_column product_shipping' >
				<option value='' class="blank" ></option>
			</select>

			<select class='ct_product_column product_weight' >
				<option value='' class="blank" ></option>
			</select>

			<select class='ct_product_column product_inventory' >
				<option value='' class="blank" ></option>
			</select>

			<select multiple="multiple" size="3" class='ct_product_column product_price_modifiers' >
			</select>

			<input  dir='ltr' type='text' value='' size='4' maxlength='128' class='ct_product_column product_global_price'  />

			<a href="#" class="remove_matrix_row" style="display:block;float:left;margin: 0 0 0 8px;position:relative;top: 9px;">
				<img border="0" alt="<?php echo $LANG->line('delete_this_row'); ?>" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
			</a>
			<div class="clear"></div>	
		</div>
	</div>