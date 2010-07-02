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
				<td class="tableCellTwo">
					<span class="defaultBold">
						<label for="prefix"><?=lang('prefix')?></label>
					</span>
					<div class="itemWrapper"><?=lang('prefix_help')?></div>
				</td>
				<td class="tableCellTwo">
					<input type="text" name="prefix" id="prefix" style="width:50px" value="<?=htmlspecialchars($prefix)?>" />
				</td>
			</tr>
			<tr>
				<td class="tableCellOne">
					<span class="defaultBold">
						<label for="with_prefixed"><?=lang('with_prefixed')?></label>
					</span>
					<div class="itemWrapper"><?=lang('with_prefixed_help')?></div>
				</td>
				<td class="tableCellOne">
					<select name="with_prefixed" id="with_prefixed">
						<option value="show"<?php if ($with_prefixed == 'show'): ?> selected="selected"<?php endif; ?>><?=lang('show_prefixed')?></option>
						<option value="hide"<?php if ($with_prefixed == 'hide'): ?> selected="selected"<?php endif; ?>><?=lang('hide_prefixed')?></option>
					</select>
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
						<?=lang('ignore_prefixes')?>
					</span>
					<div class="itemWrapper"><?=lang('ignore_prefixes_help')?></div>
				</td>
				<td class="tableCellOne">
					<label style="cursor:pointer"><input type="radio" name="ignore_prefixes" value="y"<?php if ($ignore_prefixes == 'y'): ?> checked="checked"<?php endif; ?> /> <?=lang('yes')?></label>
					<label style="cursor:pointer;margin-left:10px"><input type="radio" name="ignore_prefixes" value="n"<?php if ($ignore_prefixes == 'n'): ?> checked="checked"<?php endif; ?> /> <?=lang('no')?></label>
				</td>
			</tr>
			<tr>
				<td class="tableCellTwo">
					<span class="defaultBold">
						<?=lang('group')?>
					</span>
					<div class="itemWrapper"><?=lang('group_help')?></div>
				</td>
				<td class="tableCellTwo">
					<label style="cursor:pointer"><input type="radio" name="group" value="y"<?php if ($group == 'y'): ?> checked="checked"<?php endif; ?> /> <?=lang('yes')?></label>
					<label style="cursor:pointer;margin-left:10px"><input type="radio" name="group" value="n"<?php if ($group == 'n'): ?> checked="checked"<?php endif; ?> /> <?=lang('no')?></label>
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
		</tbody>
	</table>
	<div class="box">
		<input type="submit" value="<?=lang('submit')?>" />
	</div>
</form>