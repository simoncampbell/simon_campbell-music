<?php global $LANG; ?>           

<!-- start instruction box -->
<div class="ct_instruction_box">
  <h2><?php echo $LANG->line('gateways_header'); ?></h2>
  <p><?php echo $LANG->line('gateways_description'); ?></p>
</div>
<!-- end instruction box -->

<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('gateways_form_header'); ?></h2>
	</div>

	<fieldset>
		<label><?php echo $LANG->line('gateways_choose'); ?></label>
		<select name='payment_gateway' class="plugins" id="select_payment_gateway">
		<option value='' selected='selected'></option>
			<?php foreach ($payment_gateways as $plugin) : ?>
				<option value="<?php echo $plugin['classname']; ?>" <?php if ($settings['payment_gateway'] == $plugin['classname']) : ?>selected="selected"<?php endif; ?>>
					<?php echo $plugin['title']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</fieldset>
	<?php echo $this->load_view('plugin_settings', array('settings'=>$settings,'plugins'=>$payment_gateways, 'plugin_type'=>'payment_gateway')); ?>
</div>