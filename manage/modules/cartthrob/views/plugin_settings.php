<?php global $PREFS, $LANG; ?>
	<?php foreach ($plugins as $plugin) : ?>
		<div style="display:none;" class="<?php echo $plugin_type; ?>_settings" id="<?php echo $plugin['classname']; ?>">
			<div class="ct_form_header">
				<h2><?php echo $plugin['title']; ?> <?php echo $LANG->line('settings'); ?></h2>
				<?php 
					if (isset($plugin['note'])) 
					{
						echo'<p>'.$plugin['note'].'</p>';
					}
				?>
			</div>
	    	<?php
	    	if (isset($plugin['overview'])) 
			{
				echo "<div class='legend'><div class='ct_instruction_full'>".$plugin['overview']."</div></div>";
			}
	    	if (isset($plugin['affiliate'])) 
			{
				echo "<div class='legend'><div class='ct_instruction_full'>".$plugin['affiliate']."</div></div>";
			}
	    	?>
			<?php foreach ($plugin['settings'] as $setting) : ?>
			    <?php if ($setting['type'] == 'matrix') : ?>
				<?php
				    //retrieve the current set value of the field
				    $current_values = (isset($settings[$plugin['classname'].'_settings'][$setting['short_name']])) ? $settings[$plugin['classname'].'_settings'][$setting['short_name']] : FALSE;
				    
				    //set the value to the default value if there is no set value and the default value is defined
				    $current_values = ($current_values === FALSE && isset($setting['default'])) ? $setting['default'] : $current_values;
				?>
		    	<div class="matrix">
					<table cellpadding="0" cellspacing="0" border="0">
						<thead>
						    <tr>
								<?php foreach ($setting['settings'] as $count => $matrix_setting) : ?>
								<?php
								    //$style = 'width:'.floor(868/count($setting['settings'])).'px;';
								    //$style = 'width:'.floor(97.69585/count($setting['settings'])).'%;';
								    $style = 'width:auto;';
								    if ($count == 0)
								    {
									$style .= 'padding-left:26px;';
								    }
								    $setting['settings'][$count]['style'] = $style;
								?>
								<th style="<?php echo $style; ?>">
									<strong><?php echo $matrix_setting['name']; ?></strong><?php echo (isset($matrix_setting['note'])) ? '<br />'.$matrix_setting['note'] : ''; ?>
								</th>
								<?php endforeach; ?>
								<th style="width:20px;"></th>
						    </tr>
						</thead>
						<tbody>
							<?php
								if ($current_values === FALSE || ! count($current_values))
								{
									$current_values = array(array());
									foreach ($setting['settings'] as $matrix_setting)
									{
										$current_values[0][$matrix_setting['short_name']] = isset($matrix_setting['default']) ? $matrix_setting['default'] : '';
									}
								}
							?>
							<?php foreach ($current_values as $count => $current_value) : ?>
								<tr class="<?php echo $plugin['classname'].'_'.$setting['short_name']; ?>_setting" id="<?php echo $plugin['classname'].'_'.$setting['short_name']; ?>_setting_<?php echo $count; ?>">
									<?php foreach ($setting['settings'] as $matrix_setting) : ?>
										<td style="<?php echo $matrix_setting['style']; ?>">
											<?php echo $this->_plugin_setting($matrix_setting['type'], $plugin['classname'].'_settings['.$setting['short_name'].']['.$count.']['.$matrix_setting['short_name'].']', @$current_value[$matrix_setting['short_name']], @$matrix_setting['options'], @$matrix_setting['width']); ?>
										</td>
									<?php endforeach; ?>
									<td>
										<a href="#" class="remove_matrix_row">
											<img border="0" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
										</a>
									</td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
				<fieldset class="plugin_add_new_setting">
					<a href="#" class="ct_add_field_bttn" id="add_new_<?php echo $plugin['classname'].'_'.$setting['short_name']; ?>">
						<?php echo $LANG->line('add_another_row'); ?>
					</a>
				</fieldset>

				<table style="display: none;" class="<?php echo $plugin['classname']; ?>">
					<tr id="<?php echo $plugin['classname'].'_'.$setting['short_name']; ?>_blank" class="<?php echo $setting['short_name']; ?>">
						<?php foreach ($setting['settings'] as $matrix_setting) : ?>
							<td class="<?php echo $matrix_setting['short_name']; ?>" style="<?php echo $matrix_setting['style']; ?>"><?php echo $this->_plugin_setting($matrix_setting['type'], '', (isset($matrix_setting['default'])) ? $matrix_setting['default'] : '', @$matrix_setting['options']); ?></td>
						<?php endforeach; ?>
						<td>
						<a href="#" class="remove_matrix_row"><img border="0" src='<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_help_close_x.gif' />
							</a>
						</td>
					</tr>
				</table>
				<?php elseif ($setting['type'] == 'header') : ?>
					<div class="ct_form_header">
							<h2><?php echo $setting['name']; ?></h2>
					</div>
			<?php else : ?>
				<fieldset>
					<?php
						//retrieve the current set value of the field
						$current_value = (isset($settings[$plugin['classname'].'_settings'][$setting['short_name']])) ? $settings[$plugin['classname'].'_settings'][$setting['short_name']] : FALSE;
						//set the value to the default value if there is no set value and the default value is defined
						$current_value = ($current_value === FALSE && isset($setting['default'])) ? $setting['default'] : $current_value;
					?>
					<label>
						<?php echo $setting['name']; ?>:<?php echo (isset($setting['note'])) ? '<br /><small>'.$setting['note'].'</small>' : ''; ?>
					</label>
					<?php echo $this->_plugin_setting($setting['type'], $plugin['classname'].'_settings['.$setting['short_name'].']', $current_value, @$setting['options']); ?>
				</fieldset>
			<?php endif; ?>
		<?php endforeach; ?>
		<?php
			if (isset($plugin['required_fields'])) 
			{
				echo "<div class='legend'><div class='ct_instruction_full'>";
				echo "<strong>".$LANG->line('gateways_required_fields')."</strong><br /><p>";
				foreach ($plugin['required_fields'] as $value)
				{
					echo $value."<br />" ; 
				}
				echo "</p></div></div>";
			}
			if (isset($plugin['html'])) 
			{
				echo "<div class='legend'><div class='ct_instruction_full'>";
				echo "<strong>".$LANG->line('gateways_select')."</strong>";
				//echo str_replace('Cartthrob_', '', $plugin['classname']);
				$plugin_name = $this->CART->_get_plugin_name($plugin['classname']);
				echo $plugin_name;
				echo "</div></div>";
				echo "<div class='legend'><div class='ct_instruction_full'>";
				echo "<strong>".$LANG->line('gateways_form_input')."</strong>";
				echo $this->CART->_encode_string($plugin_name);
				echo "</div></div>";
				echo "<div class='legend'><div class='ct_instruction_full'>";
				echo "<strong>".$LANG->line('gateways_form_input_urlencoded')."</strong>";
				echo urlencode($this->CART->_encode_string($plugin_name));
				echo "</div></div>";
				echo "<div class='legend'><div class='ct_instruction_full'>";
				echo "<strong>".$LANG->line('gateways_sample_html')."</strong>";
				echo "<br /><p><pre><code>";
				echo htmlentities($plugin['html']);
				echo "</pre></code></p>";
				echo "</div></div>";
			}			
			
			if (isset($plugin['additional_template_fields']))
			{
				echo "<div class='legend'><div class='ct_instruction_full'>";
				echo "<strong>". $LANG->line('plugins_fields')."</strong><br />";
				echo "<p>".$LANG->line('plugins_in_addition_to')."<a href='http://cartthrob.com/docs/plugins/cartthrob/checkout_form/'>".$LANG->line('plugins_field_notes')."</p><br />";
				foreach ($plugin['additional_template_fields'] as $template_field)
				{
					echo "<div>";
					echo "<strong"; 
					if ($template_field['required'])
					{
						echo " class='red'"; 
					}
					echo ">".$template_field['name']."</strong><br />"; 
					if (isset($template_field['description']))
					{
						echo $template_field['description']. "<br />";
					}
					echo "Field Name: ".$template_field['short_name']."<br />";
					if (isset($template_field['option_values']))
					{
						echo "Expected values: " . $template_field['option_values']."<br />";
					}
					echo "<br />";
					echo "</div>"; 
				}
				echo "</div></div>"; 
			}
			?>
		</div>
	<?php endforeach; ?>