<?php global $PREFS, $LANG; ?>
	<div id="ct_container">
		<!-- left nav start -->
		<div id="ct_left_nav"> 
			<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/cartthrob_logo_bg.jpg" alt="cartthrob. the only cart you'll ever love" width="223" height="82" border="0" />
			<ul id="ct_navigation">
				<?php foreach ($nav as $nav_title => $subnav) : ?>
				<li>
					<a href="#" class="head">
						<?php echo $nav_title; ?>
					</a>
					<ul>
						<?php foreach ($subnav as $subnav_url_title => $subnav_title) : ?>
							<li>
								<a href="<?php echo (preg_match('/^http/', $subnav_url_title)) ? $subnav_url_title : '#'.$subnav_url_title; ?>" <?php if (preg_match('/^http/', $subnav_url_title)) : ?>target="_blank"<?php else: ?>class="ct_show_section"<?php endif; ?>>
									<?php echo $subnav_title; ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</li>
				<?php endforeach; ?>
		    </ul>
			<div id="ct_news">
				<?php $info = $this->get_news(); ?>
				<h2><?php echo $LANG->line('ct_news_and_updates'); ?></h2>
				<p><?php echo $info['version_update']; ?></p>
				<p><em><?php echo $info['news']; ?></em></p>
	    	</div>
	    	<div id="ct_see_more"> 
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_we_believe.jpg" alt="We believe in love at first sight. But the passion shouldn't end there." width="224" height="107" /> 
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_see_more.jpg" alt="See more of what CartThrob can do for your online store!" /> 
				<a href="http://cartthrob.com" target="_blank" class="ct_cartthrob_bttn">cartthrob.com</a> 
			</div>
		</div>
		<!-- left nav end -->
		<!-- begin right column -->
		<div id="ct_right_column">
			<?php if ($settings['license_number'] == '') : ?>
			<div id="ct_system_error">
				<h4>You have not entered your license number.</h4>
				Please enter before proceeding.
			</div>
			<?php endif; ?>
			<?php if ( ! $extension_enabled) : ?>
			<div id="ct_system_error">
				<h4>You have not enabled the CartThrob extension.</h4>
				Please <a href="<?php echo BASE.AMP.'C=admin'.AMP.'M=utilities'.AMP.'P=extensions_manager'; ?>">enable</a> before proceeding.
			</div>
			<?php endif; ?>
			<?php if ( ! $module_enabled) : ?>
			<div id="ct_system_error">
				<h4>You have not installed the CartThrob module.</h4>
				Please <a href="<?php echo BASE.AMP.'C=modules'; ?>">install</a> before proceeding.
			</div>
			<?php endif; ?>
			<?php echo $form_open; ?>
			<input type="hidden" name="cartthrob_tab" value="get_started" id="cartthrob_tab" />
			<?php foreach ($sections as $section) : ?>
				<?php if ($section != 'install_blogs') :?>
				<div class="ct_section" id="<?php echo $section; ?>">
					<?php echo $this->load_view($section, $data, (isset($view_paths[$section])) ? $view_paths[$section] : ''); ?>
					<?php if ($section == 'install_blogs') : ?>
			        	<a href="#" id="submit_install_templates">
							<img class="save_all_settings" border="0" src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/install_button.gif" />
						</a>
					<?php else : ?>
			      		<input class="save_all_settings" name="Submit" type="image" src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/save_all_settings.jpg" value="Save All Settings" />
					<?php endif; ?>
				</div>
				<?php endif; ?>
			<?php endforeach; ?>
			</form>
			<?php echo $template_form_open; ?>
				<div class="ct_section" id="install_blogs">
					<?php echo $this->load_view('install_blogs', $data); ?>
			      		<input class="save_all_settings" name="Submit" type="image" src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/install_button.gif" value="Install" />
				</div>
			</form>
		</div>
		<!-- end right column -->
	</div>

	<div>
	</div>

	<div class="clear"></div>
