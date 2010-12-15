<?php global $LANG; ?>           
    <!-- start instruction box -->
    <div class="ct_instruction_box">
 		<h2><?php echo $LANG->line('product_header'); ?></h2>
		<p><?php echo $LANG->line('product_description'); ?></p>
     </div>
      <div id="ct_form_options">
        <div class="ct_form_header">
			<h2><?php echo $LANG->line('product_form_header'); ?></h2>
			<p><?php echo $LANG->line('product_form_description'); ?></p>
		</div>
		<fieldset>
			<label><?php echo $LANG->line('product_allow_duplicate_items'); ?></label>
			<label class="radio"><input class='radio' type='radio' name='allow_products_more_than_once' value='1' <?php if ($settings['allow_products_more_than_once']) : ?>checked='checked'<?php endif; ?> /> 
				<?php echo $LANG->line('yes'); ?>
			</label>
			<label class="radio"><input class='radio' type='radio' name='allow_products_more_than_once' value='0' <?php if ( ! $settings['allow_products_more_than_once']) : ?>checked='checked'<?php endif; ?> /> 
				<?php echo $LANG->line('no'); ?>
			</label>
			<p><?php echo $LANG->line('product_allow_duplicate_instructions'); ?></p>
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('product_split_items_by_quantity'); ?></label>
			<label class="radio"><input class='radio' type='radio' name='product_split_items_by_quantity' value='1' <?php if ($settings['product_split_items_by_quantity']) : ?>checked='checked'<?php endif; ?> /> 
				<?php echo $LANG->line('yes'); ?>
			</label>
			<label class="radio"><input class='radio' type='radio' name='product_split_items_by_quantity' value='0' <?php if ( ! $settings['product_split_items_by_quantity']) : ?>checked='checked'<?php endif; ?> /> 
				<?php echo $LANG->line('no'); ?>
			</label>
			<p><?php echo $LANG->line('product_split_items_by_quantity_instructions'); ?></p>
		</fieldset>

</div>