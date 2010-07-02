<!-- EXTENSION ACCESS -->
<div class="tg">
	<h2><?php echo $LANG->line("enable_extension_title") ?></h2>
	<div class="info"><?php echo $LANG->line("enable_extension_info") ?></div>
	<table>
		<tbody>
			<tr class="even">
				<th><?php echo $LANG->line("enable_extension_label") ?></th>
				<td>
					<?php echo $this->select_box($settings["enabled"], array("y" => "yes", "n" => "no"), "Lg_better_meta_ext[enabled]"); ?>
				</td>
			</tr>
			<tr class="odd">
				<th><?php echo $LANG->line("enable_groups_label") ?></th>
				<td>
					<?php if ($member_group_query->num_rows > 0) : ?>
					<?php foreach($member_group_query->result as $count => $member_group) :?>
					<?php $class = ($count%2) ? "tableCellTwo" : "tableCellOne"; ?>
					<label class='checkbox'>
						<input type='checkbox' name="Lg_better_meta_ext[allowed_member_groups][]" value='<?php echo $member_group["group_id"] ?>'
							<?php echo in_array($member_group['group_id'], $settings['allowed_member_groups']) ? 'checked="checked"' : '' ?>
						>
						<?php echo $member_group["group_title"] ?>
					</label>
					<?php endforeach; ?>
				</td>
				<?php else : ?>
				<td class="highlight"><?php echo $LANG->line("error_no_assigned_weblogs") ?></td>
				<?php endif; ?>
			</tr>
		</tbody>
	</table>
</div>

<!-- PUBLISH TAB CUSTOMISATION -->
<div class="tg">
	<h2><?php echo $LANG->line("publish_tab_customisation_title") ?></h2>
	<div class="info"><?php echo $LANG->line("publish_tab_customisation_info") ?></div>
	<table id="publish-tab-customisation">
		<thead>
			<tr>
				<th><?php echo $LANG->line("weblog_title") ?></th>
				<th style="width:100px"><?php echo $LANG->line("element") ?></th>
				<th><?php echo $LANG->line("display?") ?></th>
			</tr>
		</thead>
		<tbody>
			<?php $fields = array('title', 'description', 'keywords', 'author', 'publisher', 'rights', 'canonical_url', 'robots_meta', 'sitemap_meta', 'geo_meta'); ?>
			<?php if ($weblog_query->num_rows > 0) : ?>
			<?php foreach($weblog_query->result as $count => $weblog) :?>
			<tr class="<?php echo ($count%2) ? 'odd' : 'even'; ?>">
				<th rowspan="<?php echo count($fields) + 1 ?>"><?php echo $weblog["blog_title"] ?></th>
				<th class="sub-heading">
					<em><?php echo $LANG->line("publish_tab") ?></em>
					<div class="note">Display the publish tab and all the meta custom fields</div> 
				</th>
				<td>
					<?php echo $this->select_box(
						$settings['weblogs'][$weblog["weblog_id"]]["show_tab"],
						array("y" => "yes", "n" => "no"),
						"Lg_better_meta_ext[weblogs][".$weblog["weblog_id"]."][show_tab]");
					?>
				</td>
			</tr>
			<?php foreach($fields as $field_count => $field) :?>
			<tr class='<?php echo ($count%2) ? 'odd' : 'even'; ?>  lg_better_meta_ext_weblogs_<?php echo $weblog['weblog_id'] ?>_target'>
				<th class="sub-heading"><?php echo $LANG->line($field) ?></th>
				<td>
					<?php echo $this->select_box(
						$settings['weblogs'][$weblog['weblog_id']]['show_'.$field],
						array("y" => "yes", "n" => "no"),
						"Lg_better_meta_ext[weblogs][".$weblog["weblog_id"]."][show_".$field."]"
					); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php endforeach; ?>
			<?php else : ?>
			<tr class="highlight">
				<td colspan="3"><?php echo $LANG->line("error_no_assigned_weblogs") ?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- DEFAULT VALUES -->
<div class="tg">
	<h2><?php echo $LANG->line("default_meta_values_title") ?></h2>
	<div class="info"><?php echo $LANG->line("default_meta_values_info") ?></div>
	<table>
		<tbody>
			<!-- Standard values -->
			<tr class="even">
				<th>
					<?php echo $LANG->line("title") ?>
					<span class='note'><?php echo $LANG->line("site_title_info") ?></span>
				</th>
				<td colspan='2'>
					<input type="text" type='text' recommended_length="66" id="lg_better_meta_ext_title" value="<?php echo $REGX->form_prep($settings['title']) ?>" name="Lg_better_meta_ext[title]" />
				</td>
			</tr>
			<tr class="odd">
				<th>
					<?php echo $LANG->line("entry_title_divider") ?>
					<span class="note"><?php echo $LANG->line('entry_title_divider_info'); ?></span>
				</th>
				<td colspan='2'>
					<?php $dividers = array(
									0 => "Dash [ - ]",
									1 => "Pipe [ | ]",
									2 => "Right Angled Quote [ » ]",
									3 => "Period [ . ]",
									4 => "Right Arrow [ → ]",
								); ?>
					<select name='Lg_better_meta_ext[divider]'>
					<?php foreach ($dividers as $id => $div): ?>
						<option value="<?php echo $id ?>"
							<?php echo $id == $settings['divider'] ? 'selected="selected"' : '' ?>
						><?php echo $div ?></option>
					<?php endforeach ?>
					</select>
				</td>
			</tr>
			<tr class="even">
				<th>
					<?php echo $LANG->line("description") ?>
				</th>
				<td colspan='2'>
					<textarea recommended_length="150" id='lg_better_meta_ext_description' name="Lg_better_meta_ext[description]" rows="5"><?php echo $REGX->form_prep($settings['description']) ?></textarea>
				</td>
			</tr>
			<tr class="odd">
				<th>
					<?php echo $LANG->line("keywords") ?>
				</th>
				<td colspan='2'>
					<input type="text" recommended_length="100" id='lg_better_meta_ext_keywords' value="<?php echo $REGX->form_prep($settings['keywords']) ?>" name="Lg_better_meta_ext[keywords]" />
				</td>
			</tr>
			<tr class="even">
				<th><?php echo $LANG->line("author") ?></th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['author']) ?>" name="Lg_better_meta_ext[author]" />
				</td>
			</tr>
			<tr class="odd">
				<th><?php echo $LANG->line("publisher") ?></th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['publisher']) ?>" name="Lg_better_meta_ext[publisher]" />
				</td>
			</tr>
			<tr class="even">
				<th><?php echo $LANG->line("rights") ?></th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['rights']) ?>" name="Lg_better_meta_ext[rights]" />
				</td>
			</tr>
		</tbody>
	</table>
	<h3><?php echo $LANG->line("geo_meta") ?></h3>
	<div class="info">
		<?php echo $LANG->line("geo_meta_info") ?>
		<?php echo $LANG->line("geo_meta_default_info"); ?>
	</div>
	<table>
		<tbody>
			<tr class="even">
				<th>
					<?php echo $LANG->line("region") ?>
					<span class='note'><?php echo $LANG->line('region_info') ?></span>
				</th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['region']) ?>" name="Lg_better_meta_ext[region]" id="lg_better_meta_ext_region" />
				</td>
			</tr>
			<tr class="odd">
				<th>
					<?php echo $LANG->line("placename") ?>
					<span class='note'><?php echo $LANG->line('placename_info') ?></span>
				</th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['placename']) ?>" name="Lg_better_meta_ext[placename]" id="lg_better_meta_ext_placename" />
				</td>
			</tr>
			<tr class="even">
				<th><?php echo $LANG->line("latitude") ?></th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['latitude']) ?>" name="Lg_better_meta_ext[latitude]" id="lg_better_meta_ext_latitude" />
				</td>
			</tr>
			<tr class="odd">
				<th><?php echo $LANG->line("longitude") ?></th>
				<td colspan='2'>
					<input type="text" value="<?php echo $REGX->form_prep($settings['longitude']) ?>" name="Lg_better_meta_ext[longitude]" id="lg_better_meta_ext_longitude" />
				</td>
			</tr>
		</tbody>
	</table>
	<h3><?php echo $LANG->line("robots_meta") ?></h3>
	<div class="info"><?php echo $LANG->line("robots_meta_info") ?></div>
	<table>
		<tbody>
			<tr class="even">
				<th><?php echo $LANG->line("index_entry") ?></th>
				<td colspan='2'>
					<?php echo $this->select_box($settings["robots_index"], array("y" => "yes", "n" => "no"), "Lg_better_meta_ext[robots_index]"); ?>
				</td>
			</tr>
			<tr class="odd">
				<th><?php echo $LANG->line("archive_entry") ?></th>
				<td colspan='2'>
					<?php echo $this->select_box($settings["robots_archive"], array("y" => "yes", "n" => "no"), "Lg_better_meta_ext[robots_archive]"); ?>
				</td>
			</tr>
			<tr class="even">
				<th><?php echo $LANG->line("follow_external_links") ?></th>
				<td colspan='2'>
					<?php echo $this->select_box($settings["robots_follow"], array("y" => "yes", "n" => "no"), "Lg_better_meta_ext[robots_follow]"); ?>
				</td>
			</tr>
		</tbody>
	</table>
	<!-- Sitemaps -->
	<h3><?php echo $LANG->line("sitemap_meta") ?></h3>
	<div class="info"><?php echo $LANG->line("sitemap_meta_info") ?></div>
	<table>
		<tbody>
			<?php if ($weblog_query->num_rows > 0) : ?>
			<?php foreach($weblog_query->result as $count => $weblog) :?>
			<?php $class = ($count%2) ? "odd" : "even"; ?>
			<tr class="<?php echo $class ?>">
				<th rowspan="3"><?php echo $weblog["blog_title"] ?></th>
				<th class="sub-heading"><?php echo $LANG->line("include_in_sitemap") ?></th>
				<td>
					<?php echo $this->select_box($settings['weblogs'][$weblog['weblog_id']]['include_in_sitemap'], array("y" => "yes", "n" => "no"), "Lg_better_meta_ext[weblogs][".$weblog["weblog_id"]."][include_in_sitemap]"); ?>
				</td>
			</tr>
			<tr class="<?php echo $class ?>">
				<th class="sub-heading"><?php echo $LANG->line("change_frequency") ?></th>
				<td>
					<?php echo $this->select_box($settings['weblogs'][$weblog['weblog_id']]['change_frequency'], array("Always","Hourly","Daily","Weekly","Monthly","Yearly","Never"), "Lg_better_meta_ext[weblogs][".$weblog["weblog_id"]."][change_frequency]", FALSE, FALSE, FALSE); ?>
				</td>
			</tr>
			<tr class="<?php echo $class ?>">
				<th class="sub-heading"><?php echo $LANG->line("priority") ?></th>
				<td>
					<?php echo $this->select_box($settings['weblogs'][$weblog['weblog_id']]['priority'], array("0.1","0.2","0.3","0.4","0.5","0.6","0.7","0.8","0.9","1.0"), "Lg_better_meta_ext[weblogs][".$weblog["weblog_id"]."][priority]", FALSE, FALSE, FALSE); ?>
				</td>
			</tr>
			<?php endforeach; ?>
			<?php else : ?>
			<tr>
				<td class="highlight" colspan="3"><?php echo $LANG->line("error_no_assigned_weblogs") ?></td>
			</tr>
			<?php endif; ?>
		</tbody>
	</table>
</div>

<!-- META TEMPLATE -->
<div class="tg">
	<h2><?php echo $LANG->line("meta_template_title") ?></h2>
	<div class="info"><?php echo $LANG->line("meta_template_info") ?></div>
	<table>
		<tbody>
			<tr class="even">
				<th><?php echo $LANG->line("meta_template_label") ?></th>
				<td><textarea name="Lg_better_meta_ext[template]" rows="25"><?php echo $REGX->form_prep($settings['template']) ?></textarea></td>
			</tr>
		</tbody>
	</table>
</div>

<!-- CHECK FOR UPDATES -->
<div class="tg">
	<h2><?php echo $LANG->line("check_for_updates_title") ?></h2>
	<div class="info"><?php echo str_replace("{addon_name}", $addon_name, $LANG->line("check_for_updates_info")); ?></div>
	<table>
		<tbody>
			<tr class="even">
				<th><?php echo $LANG->line("check_for_updates_label") ?></th>
				<td>
					<?php echo $this->select_box($settings['check_for_updates'], array("y" => "yes", "n" => "no"), "Lg_better_meta_ext[check_for_updates]"); ?>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<input type="submit" value="<?php print $LANG->line('save_extension_settings') ?>" />