<?php
global $LANG; 

$weblogs = array();
$template_groups = array();
$member_groups = array();

foreach ($templates as $index => $template)
{
  switch($template['type'])
  {
    case 'weblog':
      $weblogs[$index] = $template['name'];
      break;
    
    case 'template_group':
      $template_groups[$index] = $template['name'];
      break;
    
    case 'member_group':
      $member_groups[$index] = $template['name'];
      break;
    
  }
}

function ct_title($str)
{
  return ucwords(str_replace('_', ' ', $str));
}

?>

<!-- start instruction box -->
<div class="ct_instruction_box">
  <h2><?php echo $LANG->line('install_blogs_header'); ?></h2>
  <p><?php echo $LANG->line('install_blogs_description'); ?></p>
</div>
	<?php if (count($this->template_errors) || count($this->templates_installed)) : ?>
	<div class="box">
	  <?php if (count($this->templates_installed)) : ?>
	  <span class="highlight_alt_bold"><?php echo $LANG->line('installed'); ?>:</span><br />
	  <ul>
	    <?php foreach ($this->templates_installed as $installed) : ?>
	    <li><span class="highlight_alt_bold"><?php echo ct_title($installed[0]); ?>: <?php echo $installed[1]; ?></span></li>
	    <?php endforeach; ?>
	  </ul>
	  <?php endif; ?>
	  <?php if (count($this->templates_installed) && count($this->template_errors)) : ?>
	  <br />
	  <?php endif; ?>
	  <?php if (count($this->template_errors)) : ?>
	  <span class="alert"><?php echo $LANG->line('errors'); ?>:</span><br />
	  <ul>
	    <?php foreach ($this->template_errors as $error) : ?>
	    <li><span class="alert"><?php echo ct_title($error[0]); ?>: <?php echo $error[1]; ?> <?php if (isset($error[2])) : ?> - <?php echo $error[2]; ?><?php endif; ?></span></li>
	    <?php endforeach; ?>
	  </ul>
	  <?php endif; ?>
	</div>
	<?php endif; ?>

<!-- end instruction box -->
      <div id="ct_form_options">
        <div class="ct_form_header">
			<h2><?php echo $LANG->line('install_blogs_form_header'); ?>?</h2>
        </div>
<?php if (count($weblogs)) : ?>
<fieldset>
	<label><?php echo $LANG->line('section'); ?></label>
	<?php foreach ($weblogs as $index => $name): ?>
	<label class="radio"><input type="checkbox" checked="checked" name="templates[]" class="templates" value="<?php echo $index; ?>" /> <?php echo $name; ?></label>
	<?php endforeach; ?>
</fieldset>
<?php endif; ?>
<?php if (count($template_groups)) : ?>
<fieldset>
	<label><?php echo $LANG->line('templates'); ?></label>
	<?php foreach ($template_groups as $index => $name): ?>
	<label class="radio"><input type="checkbox" checked="checked" name="templates[]" class="templates" value="<?php echo $index; ?>" /> <?php echo $name; ?></label>
	<?php endforeach; ?>
</fieldset>
<?php endif; ?>
<?php if (count($member_groups)) : ?>
<fieldset>
	<label><?php echo $LANG->line('section'); ?></label>
	<?php foreach ($member_groups as $index => $name): ?>
	<label class="radio"><input type="checkbox" checked="checked" name="templates[]" class="templates" value="<?php echo $index; ?>" /> <?php echo $name; ?></label>
	<?php endforeach; ?>
</fieldset>
<?php endif; ?>
	</div>