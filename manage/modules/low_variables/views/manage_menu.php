<table cellpadding="0" cellspacing="0" id="low-variables-menu">
	<tr>
		<td class="<?=($active=='home')?'altTabSelected':'altTabs'?>"><a href="<?=$base_url?>"><?=lang('low_variables_module_name')?></a></td>
		<td class="<?=($active=='manage')?'altTabSelected':'altTabs'?>"><a href="<?=$base_url?>&amp;P=manage"><?=lang('manage_variables')?></a></td>
		<td class="<?=($active=='create_new')?'altTabSelected':'altTabs'?>"><a href="<?=$base_url?>&amp;P=manage&amp;id=new"><?=lang('create_new')?></a></td>
		<td class="<?=($active=='create_group')?'altTabSelected':'altTabs'?>"><a href="<?=$base_url?>&amp;P=groups&amp;id=new"><?=lang('create_new_group')?></a></td>
		<td class="altTabs last"><a href="<?=LOW_VAR_DOCS?>"><?=lang('low_variables_docs')?></a></td>
	</tr>
</table>