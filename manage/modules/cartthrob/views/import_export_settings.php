<?php global $LANG; ?>

<!-- start instruction box -->
<div class="ct_instruction_box">
  <h2>Import/Export Settings</h2>
  <p>Import and export your CartThrob settings for backup or use in other installations.</p>
</div>

<!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
			<h2></h2>
        </div>
<fieldset>
	<label>Export Settings</label>
	<div class="right"><a href="<?php echo BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extension_settings'.AMP.'name=cartthrob_ext'.AMP.'export_settings=1'; ?>">Export to file</a></div>
</fieldset>
<fieldset>
	<label>Import Settings</label>
	<p>WARNING:&nbsp;This will overwrite your existing settings.</p>
	<div class="right">
	  <input type="file" name="settings" />
	  <input type="submit" value="Import" />
	</div>
</fieldset>
	</div>