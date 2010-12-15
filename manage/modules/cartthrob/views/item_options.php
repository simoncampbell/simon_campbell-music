<?php global $LANG; ?>
<!-- start instruction box -->
<div class="ct_instruction_box">
 <h2><?php echo $LANG->line('item_options_header'); ?></h2>
<p><?php echo $LANG->line('item_options_description'); ?></p>
 </div>

    <!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
			<h2><?php echo $LANG->line('item_options_form_header'); ?></h2>
		</div>
        

        <fieldset>
        <label><?php echo $LANG->line('item_options_allow_duplicate_items'); ?></label>
	<label class="radio"><input class='radio' type='radio' name='allow_products_more_than_once' value='1' <?php if ($settings['allow_products_more_than_once']) : ?>checked='checked'<?php endif; ?> /> <?php echo $LANG->line('yes'); ?></label>
	<label class="radio"><input class='radio' type='radio' name='allow_products_more_than_once' value='0' <?php if ( ! $settings['allow_products_more_than_once']) : ?>checked='checked'<?php endif; ?> /> <?php echo $LANG->line('no'); ?></label>
        <p><?php echo $LANG->line('item_options_duplicate_items_instructions'); ?></p>
        </fieldset>
</div>