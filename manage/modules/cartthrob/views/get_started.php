<?php global $PREFS, $LANG; ?>

<!-- start instruction box -->
<div class="ct_instruction_box">
	<h2><?php echo $LANG->line('get_started_header'); ?></h2>
	<p><?php echo $LANG->line('get_started_description'); ?></p>
</div>

<!-- end instruction box -->
<div id="ct_form_options">
	<div class="ct_form_header">
		<h2><?php echo $LANG->line('get_started_form_header'); ?></h2>
	</div>
	<div class="legend">
		<div class="ct_dashboard">
			<a href="http://cartthrob.com/docs/sub_pages/choose_blogs_to_store_product_data_orders_and_coupons" target="_blank">
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_step1.jpg" width="130" height="130" border="0" />
			</a>
			<p>
				<a href="http://cartthrob.com/docs/sub_pages/choose_blogs_to_store_product_data_orders_and_coupons" target="_blank">
					<?php echo $LANG->line('get_started_view_video'); ?> &raquo;
				</a>
			</p>          
		</div>

		<div class="ct_dashboard">
			<a href="http://cartthrob.com/docs/sub_pages/backend_configuration_settings" target="_blank">
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_step2.jpg" width="130" height="130" border="0" />
			</a>
			<p>
				<a href="http://cartthrob.com/docs/sub_pages/backend_configuration_settings" target="_blank">
					<?php echo $LANG->line('get_started_view_video'); ?> &raquo;
				</a>
			</p> 
		</div>

		<div class="ct_dashboard">
			<a href="http://cartthrob.com/docs/tags/" target="_blank">
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_step3.jpg" width="130" height="130" border="0" />
			</a>
			<p>
				<a href="http://cartthrob.com/docs/tags/" target="_blank">
					View the docs &raquo;
				</a>
			</p>  
		</div>

		<div class="ct_dashboard">
			<a href="http://cartthrob.com/tutorials/test_system" target="_blank">
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_step4.jpg" width="130" height="130" border="0" />
			</a>
			<p>
				<a href="http://cartthrob.com/docs/" target="_blank">
					<?php echo $LANG->line('get_started_view_video'); ?> &raquo;
				</a>
			</p>   
		</div>

		<div class="ct_dashboard">
			<a href="http://cartthrob.com/docs/" target="_blank">
				<img src="<?php echo $PREFS->ini('theme_folder_url'); ?>cp_themes/<?php echo $PREFS->ini('cp_theme'); ?>/cartthrob/images/ct_dashboard_how_do_i.png" width="130" height="130" border="0" />
			</a>
			<p>
				<a href="http://cartthrob.com/docs/" target="_blank">
					<?php echo $LANG->line('get_started_view_user_guide'); ?> &raquo;
				</a>
			</p>
		</div>
		<div class="clear"></div>       
	</div>                      
</div> 