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
			<col style="width:3%" />
			<col style="width:20%" />
			<col style="width:20%" />
			<col style="width:20%" />
			<col style="width:10%" />
			<col style="width:10%" />
			<col style="width:6%" />
			<col style="width:1%" />
		</colgroup>
		<thead>
			<tr>
				<td scope="col" class="tableHeading">&nbsp;</td>
				<td scope="col" class="tableHeading"><?=lang('variable_name')?></td>
				<td scope="col" class="tableHeading"><?=lang('variable_code')?></td>
				<td scope="col" class="tableHeading"><?=lang('variable_label')?></td>
				<td scope="col" class="tableHeading"><?=lang('variable_type')?></td>
				<td scope="col" class="tableHeading"><?=lang('early_parsing')?></td>
				<td scope="col" class="tableHeading"><?=lang('clone')?></td>
				<td scope="col" class="tableHeading"><input type="checkbox" class="checkbox" value="" name="toggleflag" id="toggleflag" onclick="toggle(this)" /></td>
			</tr>
		</thead>
		<tbody>
			<?php foreach($variables AS $i => $row): ?>
				<?php $class = ($i % 2) ? 'tableCellOne' : 'tableCellTwo'?>
				<tr>
					<td class="<?=$class?>"><?=$row['variable_order']?></td>
					<td class="<?=$class?>"><a href="<?=$base_url?>&amp;P=manage&amp;id=<?=$row['variable_id']?>"><?=$row['variable_name']?></td>
					<td class="<?=$class?>"><input type="text" value="<?=LD.$row['variable_name'].RD?>" readonly="readonly" /></td>
					<td class="<?=$class?>"><?=$row['variable_label']?>&nbsp;</td>
					<td class="<?=$class?>"><?=isset($types[$row['variable_type']])?$types[$row['variable_type']]->info['name']:lang('unknown_type')?></td>
					<td class="<?=$class?>"><?=($settings['register_globals']=='y'?lang($row['early_parsing']):'--')?></td>
					<td class="<?=$class?>"><a href="<?=$base_url?>&amp;P=manage&amp;id=new&amp;clone=<?=$row['variable_id']?>"><?=lang('clone')?></a></td>
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
				<?php if($settings['register_globals'] == 'y'): ?>
					<optgroup label="<?=lang('early_parsing')?>">
						<option value="enable_early_parsing"><?=lang('enable_early_parsing')?></option>
						<option value="disable_early_parsing"><?=lang('disable_early_parsing')?></option>
					</optgroup>
				<?php endif; ?>
				<optgroup label="<?=lang('change_type_to')?>">
					<?php foreach($types AS $type => $obj): ?>
						<option value="<?=$type?>"><?=$obj->info['name']?></option>
					<?php endforeach; ?>
				</optgroup>
			</select>
			<button type="submit"><?=lang('submit')?></button>
		</div>

		<a href="<?=$base_url?>&amp;P=sort_order" style="float:left;padding:3px"><?=lang('change_sort_order')?></a>

	</div>
</form>
<?php endif; ?>