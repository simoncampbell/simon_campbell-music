<!-- Start LG Better Meta Tab -->
<div id='blockbm' class='mor pt' style="display:none">
	<div class="mor">
		<h1>Entry meta</h1>
		<div class="mor-alert info"><?php echo $LANG->line("tab_info"); ?></div>
		<div class="mor-tg form">
			<table class="mor">
				<tbody>
					<?php $count_fields_shown = 0; ?>
					<?php if ($settings['show_title'] == 'y'): ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th><?php echo $LANG->line("title") ?></th>
						<td colspan="2"><input type='text' recommended_length="66" id='lg_better_meta_ext_title' name="Lg_better_meta_ext[title]" value="<?php echo $REGX->form_prep($entry['title'], TRUE) ?>" /></td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_description'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th><?php echo $LANG->line("description") ?></th>
						<td colspan="2"><textarea recommended_length="150" id='lg_better_meta_ext_description' name="Lg_better_meta_ext[description]"><?php echo $REGX->form_prep($entry['description'], TRUE) ?></textarea></td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_keywords'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th rowspan="2"><?php echo $LANG->line("keywords") ?></th>
						<td colspan="2">
							<input type='text' recommended_length="100" id='lg_better_meta_ext_keywords' name="Lg_better_meta_ext[keywords]" value="<?php echo $REGX->form_prep($entry['keywords'], TRUE) ?>" />
						</td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<td colspan="2">
							<label class="checkbox"><input type="checkbox" <?php echo !empty($entry['append_default_keywords']) ? 'checked="checked"' : '' ?> name="Lg_better_meta_ext[append_default_keywords]" value="1" />Append default keywords</label>
						</td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_author'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th><?php echo $LANG->line("author") ?></th>
						<td colspan="2"><input type='text' name="Lg_better_meta_ext[author]" value="<?php echo $REGX->form_prep($entry['author'], TRUE) ?>" /></td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_publisher'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th><?php echo $LANG->line("publisher") ?></th>
						<td colspan="2"><input type='text' name="Lg_better_meta_ext[publisher]" value="<?php echo $REGX->form_prep($entry['publisher'], TRUE) ?>" /></td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_rights'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th><?php echo $LANG->line("rights") ?></th>
						<td colspan="2"><input type='text' name="Lg_better_meta_ext[rights]" value="<?php echo $REGX->form_prep($entry['rights'], TRUE) ?>" /></td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_canonical_url'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th>
							<?php echo $LANG->line("canonical_url") ?>
						</th>
						<td colspan="2"><input type='text' name="Lg_better_meta_ext[canonical_url]" value="<?php echo $REGX->form_prep($entry['canonical_url'], TRUE) ?>" /></td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_geo_meta'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th rowspan="4">
							<?php echo $LANG->line("geo_meta") ?>
							<span class="note"><?php echo $LANG->line("geo_meta_info") ?> </span>
						</th>
						<th class='sub-heading'>
							<div>
								<?php echo $LANG->line("region") ?> <span class='note-trigger'>?</span>
								<div class='note'><?php echo $LANG->line("region_info") ?></div>
							</div>
						</th>
						<td><input type='text' name="Lg_better_meta_ext[region]" value="<?php echo $REGX->form_prep($entry['region'], TRUE) ?>" id="lg_better_meta_ext_region" /></td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'>
							<div>
								<?php echo $LANG->line("placename") ?> <span class='note-trigger'>?</span>
								<div class='note'><?php echo $LANG->line("placename_info") ?></div>
							</div>
						</th>
						<td><input type='text' name="Lg_better_meta_ext[placename]" value="<?php echo $REGX->form_prep($entry['placename'], TRUE) ?>" id="lg_better_meta_ext_placename" /></td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'><?php echo $LANG->line("latitude") ?></th>
						<td><input type='text' name="Lg_better_meta_ext[latitude]" value="<?php echo $REGX->form_prep($entry['latitude'], TRUE) ?>" id="lg_better_meta_ext_latitude" /></td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'><?php echo $LANG->line("longitude") ?></th>
						<td><input type='text' name="Lg_better_meta_ext[longitude]" value="<?php echo $REGX->form_prep($entry['longitude'], TRUE) ?>" id="lg_better_meta_ext_longitude" /></td>
					</tr>

					<?php endif; ?>

					<?php if ($settings['show_robots_meta'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th rowspan="3"><?php echo $LANG->line("robots_meta") ?></th>
						<th class='sub-heading'><?php echo $LANG->line("index_entry") ?></th>
						<td>
							<?php echo $this->select_box($entry["index"], array("" => "use_default_setting", "y" => "yes", "n" => "no"), "Lg_better_meta_ext[index]"); ?>
						</td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'><?php echo $LANG->line("archive_entry") ?></th>
						<td>
							<?php echo $this->select_box($entry["follow"], array("" => "use_default_setting", "y" => "yes", "n" => "no"), "Lg_better_meta_ext[follow]"); ?>
						</td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'><?php echo $LANG->line("follow_external_links") ?></th>
						<td>
							<?php echo $this->select_box($entry["archive"], array("" => "use_default_setting", "y" => "yes", "n" => "no"), "Lg_better_meta_ext[archive]"); ?>
						</td>
					</tr>
					<?php endif; ?>

					<?php if ($settings['show_sitemap_meta'] == 'y'): ?>
					<?php ++$count_fields_shown; ?>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th rowspan="3"><?php echo $LANG->line("sitemap_meta") ?></th>
						<th class='sub-heading'><?php echo $LANG->line("include_in_sitemap") ?></th>
						<td>
							<?php echo $this->select_box($entry['include_in_sitemap'], array("" => "use_default_setting", "y" => "yes", "n" => "no"), "Lg_better_meta_ext[include_in_sitemap]"); ?>
						</td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'><?php echo $LANG->line("change_frequency") ?></th>
						<td>
							<?php echo $this->select_box($entry['change_frequency'], array("" => $LANG->line("use_default_setting"), "Always","Hourly","Daily","Weekly","Monthly","Yearly","Never"), "Lg_better_meta_ext[change_frequency]", FALSE, FALSE, FALSE); ?>
						</td>
					</tr>
					<tr <?php echo ($count_fields_shown % 2) ? "class='even'" : "class='odd'" ?>>
						<th class='sub-heading'><?php echo $LANG->line("priority") ?></th>
						<td>
							<?php echo $this->select_box($entry['priority'], array("" => $LANG->line("use_default_setting"), "0.1","0.2","0.3","0.4","0.5","0.6","0.7","0.8","0.9","1.0"), "Lg_better_meta_ext[priority]", FALSE, FALSE, FALSE); ?>
						</td>
					</tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- End LG Better Meta Tab -->