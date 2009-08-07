<?php echo get_partial('value_element', array('sf_setting' => $sf_setting, 'name' => 'settings['.$sf_setting->getId().']')); ?>


<?php //if ( sfConfig::get('app_sfSettingsPlugin_edit_mode', 'single_page') == 'single_page' ) : ?>
<?php //echo get_partial('value_element', array('sf_setting' => $sf_setting, 'name' => 'settings['.$sf_setting->getId().']')); ?>
<?php //else: ?>
<?php //echo get_partial('value_element', array('sf_setting' => $sf_setting, 'name' => 'sf_setting[value]')); ?>
<?php //endif;?>
