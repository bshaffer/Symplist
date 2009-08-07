<?php sfProjectConfiguration::getActive()->loadHelpers(array('csAdminGen')); ?>
<?php if( has_helper("Thumbnail")): ?>
  <?php use_helper("Thumbnail") ?>
<?php endif; ?>
  <td class="sf_admin_text sf_admin_list_td_title" style="padding: 10px 10px 10px 10px; padding-top: 10px; padding-bottom: 10px;">
  <?php echo $symfony_plugin->getTitle() ?>
</td>
  <td class="sf_admin_text sf_admin_list_td_description" style="padding: 10px 10px 10px 10px; padding-top: 10px; padding-bottom: 10px;">
  <?php echo $symfony_plugin->getDescription() ?>
</td>
