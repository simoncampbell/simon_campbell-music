<?php global $LANG; ?>           
<!-- start instruction box -->

<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('shipping_header'); ?></h2>
	<p><?php echo $LANG->line('shipping_description'); ?> </p>
</div>

   <!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
    	<h2><?php echo $LANG->line('shipping_form_header'); ?></h2>
		<div class="tooltip_icon">
			<a 
				rel="#shipping_plugin_notes" 
				href="#shipping_plugin_notes" 
				title="Additional Plugins" 
				class="ct_question_bttn">?</a>
		</div>
	</div>
	<div class="hidden_tooltip" id="shipping_plugin_notes">
		<p><?php echo $LANG->line('shipping_form_tooltip'); ?></p>
	</div>

		<fieldset>
	    <label><?php echo $LANG->line('shipping_choose_a_plugin'); ?></label>
	    <select name='shipping_plugin' class='plugins' id="select_shipping_plugin">
			<option value=''><?php echo $LANG->line('shipping_defined_per_product'); ?></option>
			<?php foreach ($shipping_plugins as $plugin) : ?>
				<option value="<?php echo $plugin['classname']; ?>" <?php if ($settings['shipping_plugin'] == $plugin['classname']) : ?>selected="selected"<?php endif; ?>>
					<?php echo $plugin['title']; ?>
				</option>
			<?php endforeach; ?>
		</select>
	</fieldset>

	<?php echo $this->load_view('plugin_settings', array('settings'=>$settings,'plugins'=>$shipping_plugins, 'plugin_type'=>'shipping_plugin')); ?>
</div>