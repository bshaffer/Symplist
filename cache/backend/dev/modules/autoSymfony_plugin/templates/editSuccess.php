<?php use_helper('I18N', 'Date') ?>
<?php include_partial('symfony_plugin/assets') ?>

<div id="sf_admin_container" class='clearfix'>
  <h1><?php echo __('Edit Symfony plugin', array(), 'messages') ?></h1>



  <div id="sf_admin_header">
    <?php include_partial('symfony_plugin/form_header', array('symfony_plugin' => $symfony_plugin, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content" class="grid_11 prefix_4">
  	<?php include_partial('symfony_plugin/flashes') ?>
    <?php include_partial('symfony_plugin/form', array('symfony_plugin' => $symfony_plugin, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('symfony_plugin/form_footer', array('symfony_plugin' => $symfony_plugin, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
