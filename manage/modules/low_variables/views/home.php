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

<?php if($settings['group'] == 'y'): ?>

	<div id="low-grouplist">
		<div class="tableHeading"><?=lang('groups')?></div>
		<div class="profileMenuInner">
			<ul>
			<?php foreach ($variables AS $group => $rows): ?>
				<li><a href="#group-<?=$group?>" class="low-grouplink"><?=ucwords($group)?> (<?=count($rows)?>)</a></li>
			<?php endforeach; ?>
			<?php if (count($variables) > 1): ?>
				<li><a href="#all" class="low-grouplink"><?=lang('show_all')?></a></li>
			<?php endif; ?>
			</ul>
		</div>
	</div>

	<div id="low-varlist">

<?php endif; ?>

		<?php foreach($variables AS $group => $rows): ?>
			<table class="tableBorder low-vargroup" cellspacing="0" cellpadding="0" id="group-<?=$group?>">
				<colgroup>
					<col class="label" />
					<col class="input" />
				</colgroup>
				<thead>
					<?php if($settings['group'] == 'y'): ?>
					<tr>
						<td class="tableHeading" colspan="2"><?=ucwords($group)?></td>
					</tr>
					<?php else: ?>
					<tr>
						<td class="tableHeadingAlt"><?=lang('variable_name')?></td>
						<td class="tableHeadingAlt"><?=lang('variable_data')?></td>
					</tr>
					<?php endif; ?>
				<tbody>
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