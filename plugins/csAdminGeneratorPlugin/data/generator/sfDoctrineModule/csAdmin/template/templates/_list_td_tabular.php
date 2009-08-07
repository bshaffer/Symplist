<?php sfProjectConfiguration::getActive()->loadHelpers(array('Helper', 'csAdminGen')); ?>
<?php echo <<<EOF
[?php sfProjectConfiguration::getActive()->loadHelpers(array('csAdminGen')); ?]
[?php if( has_helper("Thumbnail")): ?]
  [?php use_helper("Thumbnail") ?]
[?php endif; ?]
EOF;
?>

<?php foreach ($this->configuration->getValue('list.display') as $name => $field): ?>
<?php $this->getSingularName()?>
<?php $fieldConfig = $field->getConfig(); ?>
<?php if ($fieldConfig['type'] == 'Image' ): ?>
  <?php $imageMethod = (!isset($fieldConfig['method'])) ? 'get'.ucfirst($name).'WebPath' : $fieldConfig['method']; ?>
  <?php $imageHeight = (!isset($fieldConfig['height'])) ? '100' : $fieldConfig['height']; ?>
  <?php $imageWidth = (!isset($fieldConfig['width'])) ? '100' : $fieldConfig['width']; ?>
  <?php if (has_helper("Thumbnail")): ?>
    <?php $fieldDisplay = "thumbnail_tag($".$this->getSingularName()."->$imageMethod(), ".$imageWidth.", ".$imageHeight.")"; ?>
  <?php else: ?>
    <?php $fieldDisplay = "image_tag($".$this->getSingularName()."->$imageMethod(), array('width' => '".$imageWidth."'))"; ?>
  <?php endif; ?>
<?php else: ?>
  <?php $fieldDisplay = $this->renderField($field); ?>
<?php endif; ?>
<?php echo $this->addCredentialCondition(sprintf(<<<EOF
<td class="sf_admin_%s sf_admin_list_td_%s" style="padding: 10px 10px 10px 10px; padding-top: 10px; padding-bottom: 10px;">
  [?php echo %s ?]
</td>

EOF
, strtolower($field->getType()), $name, $fieldDisplay), $field->getConfig()) ?>
<?php endforeach; ?>