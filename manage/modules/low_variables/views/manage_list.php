<?php if ($message): ?>
	<div class="box success" id="lowvars_msg" style="padding:0 10px;line-height:3em">
		<?=lang($message)?>
	</div>
	<script type="text/javascript">
		setTimeout(function(){$('#lowvars_msg').slideUp(500)},2000);
	</script>
<?php endif?>

<?php if (empty($variables)): ?>

	<div class="box alert">
		<?=lang('no_variables_found')?>
	</div>

<?php else: ?>

<form id="target" name="target" action="<?=$base_url?>&amp;P=save_list" method="post">
	<table cellpadding="0" cellspacing="0" class="tableBorder" style="width:100%">
		<colgroup>
			<col style="width:4%" />
			<col style="width:20%" />
			<col style="width:20%" />
			<col style="width:20%" />
			<col style="width:20%" />
			<col style="width:5%" />
			<col style="width:5%" />
			<col style="width:4%" />
			<col style="width:2%" />
		</colgroup>
		<thead>
			<tr>
				<td scope="col" class="tableHeading">#</td>
				<td scope="col" class="tableHeading"><?=lang('variable_name')?></td>
				<td scope="col" class="tableHeading"><?=lang('variable_label')?></td>
				<td scope="col" class="tableHeading"><?=lang('variable_group')?></td>
				<td scope="col" class="tableHeading"><?=lang('variable_type')?></td>
				<td scope="col" class="tableHeading" style="text-align:center"><?=lang('is_hidden_th')?></td>
				<td scope="col" class="tableHeading" style="text-align:center"><?=lang('early_parsing')?></td>
				<td scope="col" class="tableHeading" style="text-align:center"><?=lang('clone')?></td>
				<td scope="col" class="tableHeading"><input type="checkbox" class="checkbox" value="" name="toggleflag" id="toggleflag" onclick="toggle(this)" /></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($variables AS $i => $row): ?>
				<?php $class = ($i % 2) ? 'tableCellOne' : 'tableCellTwo'?>
				<tr>
					<td class="<?=$class?>"><?=$row['variable_id']?></td>
					<td class="<?=$class?>"><a class="low-var-name" href="<?=$base_url?>&amp;P=manage&amp;id=<?=$row['variable_id']?>"><?=$row['variable_name']?></td>
					<td class="<?=$class?>"><div class="smallNoWrap"><?=$row['variable_label']?></div></td>
					<td class="<?=$class?>"><a href="<?=$base_url?>&amp;P=groups&amp;id=<?=$row['group_id']?>&amp;from=manage"><?=htmlspecialchars($variable_groups[$row['group_id']])?></a></td>
					<td class="<?=$class?>"><div class="smallNoWrap"><?=isset($types[$row['variable_type']])?$types[$row['variable_type']]->info['name']:lang('unknown_type')?></div></td>
					<td class="<?=$class?>" style="text-align:center"><div class="smallNoWrap"><?=lang($row['is_hidden'])?></div></td>
					<td class="<?=$class?>" style="text-align:center"><div class="smallNoWrap"><?=($settings['register_globals']=='y'?lang($row['early_parsing']):'--')?></div></td>
					<td class="<?=$class?>"><a class="clone" href="<?=$base_url?>&amp;P=manage&amp;id=new&amp;clone=<?=$row['variable_id']?>"><?=lang('clone')?></a></td>
					<td class="<?=$class?>"><input type="checkbox" class="checkbox" id="var_<?=$row['variable_id']?>" name="toggle[]" value="<?=$row['variable_id']?>" /></td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
	<div class="box" style="overflow:hidden">

		<div style="float:right">
			<label for="select_action"><?=lang('with_selected')?></label>
			<select name="action" id="select_action">
				<option value=""></option>
				<option value="delete"><?=lang('delete')?></option>
				<optgroup label="<?=lang('show-hide')?>">
					<option value="show"><?=lang('show')?></option>
					<option value="hide"><?=lang('hide')?></option>
				</optgroup>

				<?php if($settings['register_globals'] == 'y'): ?>
					<optgroup label="<?=lang('early_parsing')?>">
						<option value="enable_early_parsing"><?=lang('enable_early_parsing')?></option>
						<option value="disable_early_parsing"><?=lang('disable_early_parsing')?></option>
					</optgroup>
				<?php endif; ?>
				<optgroup label="<?=lang('change_group_to')?>">
					<?php foreach($variable_groups AS $vg_id => $vg_label): ?>
						<option value="<?=$vg_id?>"><?=$vg_label?></option>
					<?php endforeach; ?>
				</optgroup>
				<optgroup label="<?=lang('change_type_to')?>">
					<?php foreach($types AS $type => $obj): ?>
						<option value="<?=$type?>"><?=$obj->info['name']?></option>
					<?php endforeach; ?>
				</optgroup>
			</select>
			<button type="submit"><?=lang('submit')?></button>
		</div>

	</div>
</form>
<?php endif; ?>