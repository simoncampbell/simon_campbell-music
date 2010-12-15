<?php global $LANG; ?> 

	
    <!-- start instruction box -->
    <div class="ct_instruction_box">
      <h2><?php echo $LANG->line('discount_options_heading'); ?></h2>
      <p><?php echo $LANG->line('discount_options_description'); ?></p>
    </div>

    <!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
                
			<h2><?php echo $LANG->line('discount_options_form_header'); ?></h2>

        </div>
        
		<fieldset>
		<label><?php echo $LANG->line('discount_weblog'); ?></label>
		<select name='discount_weblog' class="weblogs" id="select_discount">
		<option value=''></option>
		<?php foreach ($weblogs as $weblog) : ?>
		<option value="<?php echo $weblog['weblog_id']; ?>" <?php if ($settings['discount_weblog'] == $weblog['weblog_id']) : ?>selected="selected"<?php endif; ?>><?php echo $weblog['blog_title']; ?></option>
		<?php endforeach; ?>
		</select>
		</fieldset>


	<div class="requires_discounts_blog">

       	<div class="ct_form_header">
			<h2><?php echo $LANG->line('discount_field_header'); ?></h2><div class="tooltip_icon"><a rel="#discount_data_fields" href="#discount_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
        </div>
		<div class="hidden_tooltip" id="discount_data_fields">
			<p><strong><?php echo $LANG->line('choose_a_weblog'); ?></strong></p> 
		</div>
		
		<fieldset>
		<label><?php echo $LANG->line('discount_type'); ?></label>
		<select name='discount_type' class="field_discount">
		<option value='' class="blank" ></option>
		<?php if ($settings['discount_weblog']) : ?>
		<?php foreach ($fields[$settings['discount_weblog']] as $field) : ?>
		<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['discount_type'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>><?php echo $field['field_label']; ?></option>
		<?php endforeach; ?>
		<?php endif; ?>
		</select>
		</fieldset>
	</div>	


        
</div>