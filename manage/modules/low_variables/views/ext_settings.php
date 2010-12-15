<h1 style="margin-bottom:10px"><?=lang('low_variables_module_name')?> <small><?=$version?></small></h1>
<form method="post" action="<?=BASE?>&amp;C=admin&amp;M=utilities&amp;P=save_extension_settings">
	<div>
		<input type="hidden" name="name" value="<?=$name?>" />
	</div>
	<table cellpadding="0" cellspacing="0" class="tableBorder" style="width:100%">
		<colgroup>
			<col style="width:50%" />
			<col style="width:50%" />
		</colgroup>
		<thead>
			<tr>
				<td colspan="2" class="tableHeading"><?=lang('extension_settings')?></td>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="tableCellOne">
					<span class="defaultBold">
						<span class="alert">*</span>
						<label for="license_key"><?=lang('license_key')?></label>
					</span>
					<div class="itemWrapper"><?=lang('license_key_help')?></div>
				</td>
				<td class="tableCellOne">
					<input type="text" name="license_key" id="license_key" style="width:90%" value="<?=htmlspecialchars($license_key)?>" />
				</td>
			</tr>
			<tr>
				<td class="tableCellTwo" style="vertical-align:top">
					<span class="defaultBold">
						<label><?=lang('can_manage')?></label>
					</span>
					<div class="itemWrapper"><?=lang('can_manage_help')?></div>
				</td>
				<td class="tableCellTwo">
					<?php foreach ($member_groups AS $group_id => $group_name): ?>
						<label style="display:block;cursor:pointer">
							<input type="checkbox" name="can_manage[]" value="<?=$group_id?>" <?php if (in_array($group_id, $can_manage)): ?>checked="checked" <?php endif; ?>/>
							<?=htmlspecialchars($group_name)?>
						</label>
					<?php endforeach; ?>
				</td>
			</tr>
			<tr>
				<td class="tableCellOne">
					<span class="defaultBold">
						<?=lang('register_globals')?>
					</span>
					<div class="itemWrapper"><?=lang('register_globals_help')?></div>
				</td>
				<td class="tableCellOne">
					<label style="cursor:pointer"><input type="radio" name="register_globals" value="y"<?php if ($register_globals == 'y'): ?> checked="checked"<?php endif; ?> /> <?=lang('yes')?></label>
					<label style="cursor:pointer;margin-left:10px"><input type="radio" name="register_globals" value="n"<?php if ($register_globals == 'n'): ?> checked="checked"<?php endif; ?> /> <?=lang('no')?></label>
				</td>
			</tr>
			<tr>
				<td class="tableCellTwo">
					<span class="defaultBold">
						<?=lang('register_member_data')?>
					</span>
					<div class="itemWrapper"><?=lang('register_member_data_help')?></div>
				</td>
				<td class="tableCellTwo">
					<label style="cursor:pointer"><input type="radio" name="register_member_data" value="y"<?php if ($register_member_data == 'y'): ?> checked="checked"<?php endif; ?> /> <?=lang('yes')?></label>
					<label style="cursor:pointer;margin-left:10px"><input type="radio" name="register_member_data" value="n"<?php if ($register_member_data == 'n'): ?> checked="checked"<?php endif; ?> /> <?=lang('no')?></label>
				</td>
			</tr>
			<tr>
				<td class="tableCellOne" style="vertical-align:top">
					<span class="defaultBold">
						<?=lang('variable_types')?>
					</span>
					<div class="itemWrapper"><?=lang('variable_types_help')?></div>
				</td>
				<td class="tableCellOne">
					<?php foreach($variable_types AS $type => $info): ?>
						<label style="display:block;cursor:pointer"><input type="checkbox" name="enabled_types[]" value="<?=$type?>" <?php if(in_array($type, $enabled_types)): ?>checked="checked" <?php endif; ?>
							<?php if($info['is_default']): ?> disabled="disabled"<?php endif; ?> />
						<?=$info['name']?> &ndash; <small><?=$info['version']?></small></label>
					<?php endforeach; ?>
				</td>
			</tr>
		</tbody>
	</table>
	<div class="box">
		<input type="submit" value="<?=lang('submit')?>" />
	</div>
</form>