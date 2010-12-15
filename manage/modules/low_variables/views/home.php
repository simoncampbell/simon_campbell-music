<?php if ($message && !$skipped): ?>
	<div class="box success" id="lowvars_msg" style="padding:0 10px;line-height:3em">
		<?=lang($message)?>
	</div>
	<script type="text/javascript">
		setTimeout(function(){$('#lowvars_msg').slideUp(500)},2000);
	</script>
<?php endif?>

<?php if ($skipped): ?>
	<div class="box">
		<span class="success"><?=lang('low_variables_saved_except')?></span>
		<ul class="alert"><?php foreach($skipped AS $row): ?>
			<li><?=($row['var_label']?$row['var_label']:$row['var_name'])?></li>
		<?php endforeach; ?></ul>
	</div>
<?php endif; ?>

<form method="post" action="<?=$base_url.AMP?>P=save" enctype="multipart/form-data" style="overflow:hidden">

	<div>
		<input type="hidden" name="all_ids" value="<?=$all_ids?>" />
	</div>

<?php if ($group_count > 1): ?>

	<div id="low-grouplist"<?php if ($settings['is_manager']): ?> class="low-manager"<?php endif; ?>>
		<div class="tableHeading"><?=lang('groups')?></div>
		<div class="profileMenuInner">
			<ul id="low-sortable-groups" class="ee1">
				<?php foreach ($group_list AS $group_id => $row): ?>
					<?php if ($group_id == 0) continue; ?>
					<li>
						<?php if ($settings['is_manager']): ?>
							<a href="<?=$base_url?>&amp;P=group_delete_confirmation&amp;id=<?=$group_id?>"
								class="low-delete" title="<?=lang('delete_group').' '.htmlspecialchars($row['group_label'])?>"><?=lang('delete_group')?></a>
							<a href="<?=$base_url?>&amp;P=groups&amp;id=<?=$group_id?>&amp;from=home"
								class="low-edit" title="<?=lang('edit_group').' '.htmlspecialchars($row['group_label'])?>"><?=lang('edit_group')?></a>
							<span class="low-handle"></span>
						<?php endif; ?>
						<?php if ($row['count'] == 0): ?>
							<span class="low-grouplink" id="group_id_<?=$group_id?>"><?=htmlspecialchars($row['group_label'])?></span>
						<?php else: ?>
							<a href="#group-<?=$group_id?>" class="low-grouplink" id="group_id_<?=$group_id?>"><?=htmlspecialchars($row['group_label'])?> (<?=$row['count']?>)</a>
						<?php endif; ?>
					</li>
				<?php endforeach; ?>
			</ul>
			<ul>
				<?php if (isset($group_list['0'])): ?>
					<li>
						<?php if ($settings['is_manager']): ?>
							<a href="<?=$base_url?>&amp;P=groups&amp;id=0&amp;from=home"
								class="low-edit" title="<?=lang('edit_group').' '.htmlspecialchars($group_list['0']['group_label'])?>"><?=lang('edit_group')?></a>
						<?php endif; ?>
						<a href="#group-0" class="low-grouplink"><?=$group_list['0']['group_label']?> (<?=$group_list['0']['count']?>)</a>
					</li>
				<?php endif; ?>
				<li><a href="#all" class="low-grouplink"><?=lang('show_all')?></a></li>
			</ul>
		</div>
	</div>

	<div id="low-varlist">

<?php endif; ?>

		<?php foreach($variables AS $group_id => $rows): ?>
			<table class="tableBorder low-vargroup" cellspacing="0" cellpadding="0" id="group-<?=$group_id?>">
				<colgroup>
					<col class="label" />
					<col class="input" />
				</colgroup>
				<thead>
					<?php if($settings['group'] == 'y'): ?>
					<tr>
						<td class="tableHeading" colspan="2"><?=htmlspecialchars($groups[$group_id]['group_label'])?></td>
					</tr>
					<?php else: ?>
					<tr>
						<td class="tableHeadingAlt"><?=lang('variable_name')?></td>
						<td class="tableHeadingAlt"><?=lang('variable_data')?></td>
					</tr>
					<?php endif; ?>
				<tbody>
				<?php if($groups[$group_id]['group_notes']): ?>
					<tr>
						<td class="low-group-notes" colspan="2"><div class="box"><?=$groups[$group_id]['group_notes']?></div></td>
					</tr>
				<?php endif; ?>
				<?php foreach($rows AS $i => $row): ?>
					<tr>
						<td class="tableCell<?=(($i%2)?'One':'Two')?>" style="vertical-align:top">
							<strong class="low-label">
								<?php if($settings['is_manager']): ?>
									<a href="<?=$base_url.AMP?>P=manage&amp;id=<?=$row['var_id']?>" title="<?=lang('manage_this_variable')?>">
								<?php endif; ?>
										<?=$row['var_name']?>
								<?php if($settings['is_manager']): ?>
									</a>
								<?php endif; ?>
							</strong>
							<?php if(isset($row['error_msg']) && !empty($row['error_msg'])): ?>
								<div class="low-var-alert"><?=(is_array($row['error_msg']) ? implode('<br />', $row['error_msg']) : lang($row['error_msg']))?></div>
							<?php endif; ?>
							<?php if($row['var_notes']): ?>
								<div class="low-var-notes"><?=$row['var_notes']?></div>
							<?php endif; ?>
						</td>
						<td class="tableCell<?=(($i%2)?'One':'Two')?>" style="vertical-align:top">
							<?=$row['var_input']?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		<?php endforeach; ?>

		<div class="box">
			<button type="submit"><?=lang('low_variables_save')?></button>
		</div>

	<?php if($settings['group'] == 'y'): ?>
	</div>
	<?php endif; ?>
</form>