<form method="post" action="<?=$base_url?>&amp;P=save_group" id="low-variable-form">
	<div>
		<input type="hidden" name="group_id" value="<?=$group_id?>" />
		<input type="hidden" name="from" value="<?=$from?>" />
	</div>
	<table cellpadding="0" cellspacing="0" class="tableBorder">
		<colgroup>
			<col class="key" />
			<col class="val" />
		</colgroup>
		<thead>
			<tr>
				<td colspan="2" class="tableHeading"><?=lang('edit_group')?> (#<?=$group_id?>)</td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="tableCellOne">
					<label class="low-label" for="group_label"><span class="alert">*</span> <?=lang('group_label')?></label>
				</td>
				<td class="tableCellOne">
					<?php if ($group_id === '0'): ?>
						<?=htmlspecialchars($group_label)?>
					<?php else: ?>
						<input type="text" name="group_label" id="low_group_label" class="medium" value="<?=htmlspecialchars($group_label)?>" />
						<?php if ($group_id == 'new'): ?><script type="text/javascript"> document.getElementById('low_group_label').focus(); </script><?php endif; ?>
					<?php endif; ?>
				</td>
			</tr>
			<?php if ($group_id !== '0'): ?>
				<tr>
					<td class="tableCellTwo" style="vertical-align:top">
						<label class="low-label" for="group_notes"><?=lang('group_notes')?></label>
						<div class="low-var-notes"><?=lang('group_notes_help')?></div>
					</td>
					<td class="tableCellTwo">
						<textarea name="group_notes" id="group_notes" rows="4" cols="40"><?=htmlspecialchars($group_notes)?></textarea>
					</td>
				</tr>
			<?php endif; ?>
			<?php if ($group_id != 'new' && count($variables)): ?>
				<tr>
					<td class="tableCellOne" style="vertical-align:top">
						<span class="low-label"><?=lang('variable_order')?></span>
					</td>
					<td class="tableCellOne" style="padding:0">
						<ul id="low-variables-list">
							<?php foreach($variables AS $i => $row): ?>
								<li>
									<input type="hidden" name="vars[]" value="<?=$row['variable_id']?>" />
									<?=(strlen($row['variable_label'])?$row['variable_label']:$row['variable_name'])?>
								</li>
							<?php endforeach; ?>
						</ul>
					</td>
				</tr>
			<?php endif; ?>
		</tbody>
	</table>

	<div class="box">
		<button type="submit" class="submit"><?=lang('low_variables_save')?></button>
	</div>

</form>