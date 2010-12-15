<?php global $LANG; ?>

<!-- start instruction box -->
<div class="ct_instruction_box">
  <h2><?php echo $LANG->line('email_admin_heading'); ?></h2>
  <p><?php echo $LANG->line('email_admin_description'); ?></p>
</div>

<!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
                
<h2><?php echo $LANG->line('email_form_header'); ?></h2><div class="tooltip_icon"><a rel="#email_admin_variables" href="#email_admin_variables" title="Email Variables" class="ct_question_bttn">?</a></div>

        </div>
		<div class="hidden_tooltip" id="email_admin_variables">
			<p><strong><?php echo $LANG->line('email_form_variables'); ?><br /><br />
{transaction_id}<br />
{shipping}<br />
{tax}<br />
{subtotal}<br />
{total}<br />
{customer_name}<br />
{customer_email}<br />
{customer_phone}<br />
{coupon_codes}<br />
{last_four_digits}<br />
{full_billing_address}<br />
{full_shipping_address}<br />
{billing_first_name}<br />
{billing_last_name}<br />
{billing_address}<br />
{billing_address2}<br />
{billing_city}<br />
{billing_state}<br />
{billing_zip}<br />
{shipping_first_name}<br />
{shipping_last_name}<br />
{shipping_address}<br />
{shipping_address2}<br />
{shipping_city}<br />
{shipping_state}<br />
{shipping_zip}<br />
{shipping_option}	
			</strong></p> 
		</div>

		<fieldset>
			<label><?php echo $LANG->line('send_email'); ?></label>
			<label class="radio"><input class='radio' type='radio' name='send_email' value='1' <?php if ($settings['send_email']) : ?>checked='checked'<?php endif; ?> /> <?php echo $LANG->line('yes'); ?></label>
			<label class="radio"><input class='radio' type='radio' name='send_email' value='0' <?php if ( ! $settings['send_email']) : ?>checked='checked'<?php endif; ?> /> <?php echo $LANG->line('no'); ?></label>
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('admin_email'); ?></label>
			<input  dir='ltr' type='text' name='admin_email' id='admin_email' value='<?php echo $settings['admin_email']; ?>' size='90' maxlength='300' />
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('email_admin_notification_from'); ?> (<?php echo $LANG->line('variables'); ?>: {customer_email})</label>
			<input  dir='ltr' type='text' name='email_admin_notification_from' id='email_admin_notification_from' value='<?php echo $settings['email_admin_notification_from']; ?>' size='90' maxlength='100' />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('email_admin_notification_from_name'); ?> (<?php echo $LANG->line('variables'); ?>: {customer_name})</label>
			<input  dir='ltr' type='text' name='email_admin_notification_from_name' id='email_admin_notification_from_name' value='<?php echo $settings['email_admin_notification_from_name']; ?>' size='90' maxlength='100' />
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('email_admin_notification_subject'); ?></label>
			<input  dir='ltr' type='text' name='email_admin_notification_subject' id='email_admin_notification_subject' value='<?php echo $settings['email_admin_notification_subject']; ?>' size='90' maxlength='100' />
		</fieldset>

		<fieldset>
			<label><?php echo $LANG->line('email_admin_notification_type'); ?></label>
			<label class="radio"><input class='radio' type='radio' name='email_admin_notification_plaintext' value='0' <?php if ( ! $settings['email_admin_notification_plaintext']) : ?>checked='checked'<?php endif; ?> /> <?php echo $LANG->line('email_admin_notification_html'); ?></label>
			<label class="radio"><input class='radio' type='radio' name='email_admin_notification_plaintext' value='1' <?php if ($settings['email_admin_notification_plaintext']) : ?>checked='checked'<?php endif; ?> /> <?php echo $LANG->line('email_admin_notification_plaintext'); ?></label>
		</fieldset>
		
		<fieldset>
			<label><?php echo $LANG->line('email_admin_notification'); ?> <br /><?php echo $LANG->line('email_admin_body_note'); ?><br /><br /> ex: {exp:weblog:entries entry_id="ORDER_ID"}... </label>
			<textarea  dir='ltr' name='email_admin_notification' id='email_admin_notification' cols='90' rows='20' ><?php echo $settings['email_admin_notification']; ?></textarea>
		</fieldset>
		
</div>