<?php global $LANG; ?> 
    <!-- start instruction box -->
    <div class="ct_instruction_box">
      <h2><?php echo $LANG->line('coupon_error_msgs_heading'); ?></h2>
      <p><?php echo $LANG->line('warning_and_error_messages'); ?></p>
    </div>

    <!-- end instruction box -->
      <div id="ct_form_options">

	      	<div class="ct_form_header">
				<h2><?php echo $LANG->line('warning_and_error_messages'); ?></h2>
	        </div>		
			<fieldset>
			<label><?php echo $LANG->line('coupon_valid_msg'); ?> (<?php echo $LANG->line('variables'); ?>: <span class="red">{discount}</span> <?php echo $LANG->line('and'); ?> <span class="red">{total}</span></label>
			<input  dir='ltr' type='text' name='coupon_valid_msg' id='coupon_valid_msg' value='<?php echo $settings['coupon_valid_msg']; ?>' size='90' maxlength='100' />
			</fieldset>

			<fieldset>
			<label><?php echo $LANG->line('coupon_invalid_msg'); ?></label>
			<input  dir='ltr' type='text' name='coupon_invalid_msg' id='coupon_invalid_msg' value='<?php echo $settings['coupon_invalid_msg']; ?>' size='90' maxlength='100' />
			</fieldset>

			<fieldset>
			<label><?php echo $LANG->line('coupon_inactive_msg'); ?></label>
			<input  dir='ltr' type='text' name='coupon_inactive_msg' id='coupon_inactive_msg' value='<?php echo $settings['coupon_inactive_msg']; ?>' size='90' maxlength='100' />
			</fieldset>

			<fieldset>
			<label><?php echo $LANG->line('coupon_expired_msg'); ?></label>
			<input  dir='ltr' type='text' name='coupon_expired_msg' id='coupon_expired_msg' value='<?php echo $settings['coupon_expired_msg']; ?>' size='90' maxlength='100' />
			</fieldset>

			<fieldset>
			<label><?php echo $LANG->line('coupon_limit_msg'); ?></label>
			<input  dir='ltr' type='text' name='coupon_limit_msg' id='coupon_limit_msg' value='<?php echo $settings['coupon_limit_msg']; ?>' size='90' maxlength='100' />
			</fieldset>

			<fieldset>
			<label><?php echo $LANG->line('coupon_user_limit_msg'); ?></label>
			<input  dir='ltr' type='text' name='coupon_user_limit_msg' id='coupon_user_limit_msg' value='<?php echo $settings['coupon_user_limit_msg']; ?>' size='90' maxlength='100' />
			</fieldset>
</div>