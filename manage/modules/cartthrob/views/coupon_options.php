<?php global $LANG; ?> 

	
    <!-- start instruction box -->
    <div class="ct_instruction_box">
      <h2><?php echo $LANG->line('coupon_options_heading'); ?></h2>
      <p><?php echo $LANG->line('coupon_options_description'); ?></p>
    </div>

    <!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
                
			<h2><?php echo $LANG->line('coupon_options_form_header'); ?></h2>

        </div>
        
		<fieldset>
		<label><?php echo $LANG->line('coupon_code_weblog'); ?></label>
		<select name='coupon_code_weblog' class="weblogs" id="select_coupon_code">
		<option value=''></option>
		<?php foreach ($weblogs as $weblog) : ?>
		<option value="<?php echo $weblog['weblog_id']; ?>" <?php if ($settings['coupon_code_weblog'] == $weblog['weblog_id']) : ?>selected="selected"<?php endif; ?>><?php echo $weblog['blog_title']; ?></option>
		<?php endforeach; ?>
		</select>
		</fieldset>


	<div style="display:none" class="requires_coupons_blog">

       	<div class="ct_form_header">
			<h2><?php echo $LANG->line('coupon_code_field_header'); ?></h2><div class="tooltip_icon"><a rel="#coupon_data_fields" href="#coupon_data_fields" title="Setup Instructions" class="ct_question_bttn">?</a></div>
        </div>
		<div class="hidden_tooltip" id="coupon_data_fields">
			<p><strong><?php echo $LANG->line('choose_a_weblog'); ?></strong></p> 
		</div>
		<fieldset>
		<label><?php echo $LANG->line('coupon_code_field'); ?></label>
		<select name='coupon_code_field' class="field_coupon_code">
		<option value='' class="blank" ></option>
		<option value='title' class="blank" <?php if ($settings['coupon_code_field'] == 'title') : ?>selected="selected"<?php endif; ?>><?php echo $LANG->line('title'); ?></option>
		<?php if ($settings['coupon_code_weblog']) : ?>
		<?php foreach ($fields[$settings['coupon_code_weblog']] as $field) : ?>
		<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['coupon_code_field'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>><?php echo $field['field_label']; ?></option>
		<?php endforeach; ?>
		<?php endif; ?>
		</select>
		</fieldset>
		
		<fieldset>
		<label><?php echo $LANG->line('coupon_code_type'); ?></label>
		<select name='coupon_code_type' class="field_coupon_code">
		<option value='' class="blank" ></option>
		<?php if ($settings['coupon_code_weblog']) : ?>
		<?php foreach ($fields[$settings['coupon_code_weblog']] as $field) : ?>
		<option value="<?php echo $field['field_id']; ?>" <?php if ($settings['coupon_code_type'] == $field['field_id']) : ?>selected="selected"<?php endif; ?>><?php echo $field['field_label']; ?></option>
		<?php endforeach; ?>
		<?php endif; ?>
		</select>
		</fieldset>
	</div>	


        
</div>