<form method="post" action="<?=$base_url?>&amp;P=save_var" id="low-variable-form">
	<div>
		<input type="hidden" name="variable_id" value="<?=$variable_id?>" />
	</div>
	<table cellpadding="0" cellspacing="0" class="tableBorder">
		<colgroup>
			<col class="key" />
			<col class="val" />
		</colgroup>
		<thead>
			<tr>
				<td colspan="2" class="tableHeading"><?=lang('edit_variable')?> (#<?=$variable_id?>)</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="tableCellOne">
					<label class="low-label" for="low_variable_name"><span class="alert">*</span> <?=lang('variable_name')?></label>
					<div class="low-var-notes"><?=lang('variable_name_help')?></div>
				</td>
				<td class="tableCellOne">
					<input type="text" name="variable_name" id="low_variable_name" class="medium" value="<?=htmlspecialchars($variable_name)?>" />
					<?php if ($variable_id == 'new'): ?><script type="text/javascript"> document.getElementById('low_variable_name').focus(); </script><?php endif; ?>
				</td>
			</tr>
			<tr>
				<td class="tableCellTwo">
					<label class="low-label" for="low_variable_label"><?=lang('variable_label')?></label>
					<div class="low-var-notes"><?=lang('variable_label_help')?></div>
				</td>
				<td class="tableCellTwo">
					<input type="text" name="variable_label" id="low_variable_label" class="medium" value="<?=htmlspecialchars($variable_label)?>" />
				</td>
			</tr>
			<tr>
				<td class="tableCellOne" style="vertical-align:top">
					<label class="low-label" for="low_variable_notes"><?=lang('variable_notes')?></label>
					<div class="low-var-notes"><?=lang('variable_notes_help')?></div>
				</td>
				<td class="tableCellOne">
					<textarea name="variable_notes" id="low_variable_notes" rows="4" cols="40"><?=htmlspecialchars($variable_notes)?></textarea>
				</td>
			</tr>
			<tr>
				<td class="tableCellTwo">
					<label class="low-label" for="low_variable_order"><?=lang('variable_order')?></label>
				</td>
				<td class="tableCellTwo">
					<input type="text" name="variable_order" id="low_variable_order" class="x-small" maxlength="4" value="<?=htmlspecialchars($variable_order)?>" />
				</td>
			</tr>
			<tr>
				<td class="tableCellOne">
					<strong class="low-label"><?=lang('early_parsing')?></strong>
					<div class="low-var-notes"><?=lang('early_parsing_help')?></div>
				</td>
				<td class="tableCellOne">
					<?php if ($settings['register_globals'] == 'y'): ?>
						<label class="low-checkbox">
							<input type="checkbox" name="early_parsing" id="early_parsing" value="y"<?php if($early_parsing == 'y'):?> checked="checked"<?php endif; ?>>
							<?=lang('enable_early_parsing')?>
						</label>
					<?php else: ?>
						<em><?=lang('early_parsing_disabled_msg')?></em>
					<?php endif; ?>
				</td>
			</tr>
			<tr>
				<td class="tableCellTwo" style="vertical-align:top;">
					<label class="low-label" for="low-select-type"><?=lang('variable_type')?></label>
					<div class="low-var-notes"><?=lang('variable_type_help')?></div>
				</td>
				<td class="tableCellTwo">
					<select name="variable_type" id="low-select-type" class="select">
					<?php foreach($types AS $type => $row): ?>
						<option value="<?=$type?>"<?php if ($type == $variable_type): ?> selected="selected"<?php endif; ?>><?=htmlspecialchars($row['name'])?></option>
					<?php endforeach; ?>
					</select>
				</td>
			</tr>
		</tbody>
	</table>

	<?php foreach($types AS $type => $row): ?>
		<?php if (empty($row['settings'])) continue; ?>
		<table cellpadding="0" cellspacing="0" class="tableBorder low-var-type" id="<?=$type?>"<?php if($variable_type != $type): ?> style="display:none"<?php endif; ?>>
			<colgroup>
				<col class="key" />
				<col class="val" />
			</colgroup>
			<thead>
				<tr>
					<td colspan="2" class="tableHeadingAlt"><?=lang('settings_for')?> <?=$row['name']?></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($row['settings'] AS $cells): ?>
					<tr>
						<td class="tableCellOne">
							<?=isset($cells[0])?$cells[0]:''?>
						</td>
						<td class="tableCellOne">
							<?=isset($cells[1])?$cells[1]:''?>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	<?php endforeach; ?>

	<?php if ($variable_id == 'new'): ?>
		<table cellpadding="0" cellspacing="0" class="tableBorder">
			<colgroup>
				<col class="key" />
				<col class="val" />
			</colgroup>
			<thead>
				<tr>
					<td colspan="2" class="tableHeadingAlt"><?=lang('initiate_variable_data')?></td>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="tableCellTwo" style="vertical-align:top">
						<label class="low-label" for="low_variable_data"><?=lang('variable_data')?></label>
						<div class="low-var-notes"><?=lang('variable_data_help')?></div>
					</td>
					<td class="tableCellTwo">
						<textarea name="variable_data" id="low_variable_data" rows="4" cols="40"></textarea>
					</td>
				</tr>
			</tbody>
		</table>
	<?php endif; ?>

	<div class="box">
		<button type="submit"><?=lang('low_variables_save')?></button>
	</div>

</form>