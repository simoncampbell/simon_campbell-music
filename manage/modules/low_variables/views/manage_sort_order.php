<form id="target" name="target" action="<?=$base_url?>&amp;P=save_order" method="post">
	<ul id="low-variables-list">
		<?php foreach($variables AS $i => $row): ?>
			<li>
				<input type="hidden" name="vars[]" value="<?=$row['variable_id']?>" />
				<span class="order"><?=($i+1)?></span>
				<span class="name"><?=$row['variable_name']?></span>
				<span class="label"><?=$row['variable_label']?></span>
			</li>
		<?php endforeach; ?>
	</ul>
	<div class="box">
		<button type="submit"><?=lang('update')?></button>
	</div>
</form>