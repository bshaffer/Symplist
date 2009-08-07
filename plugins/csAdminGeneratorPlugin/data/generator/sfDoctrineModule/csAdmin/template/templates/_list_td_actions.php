<td>
  <ul class="sf_admin_td_actions">
    <?php $model = $this->getSingularName(); ?>
    <?php $arrows = '
    [?php 
    if (array_key_exists("Doctrine_Template_Sortable", $'.$model.'->getTable()->getTemplates()) && $'.$model.'->getPosition() != $'.$model.'->getFinalPosition()){
      echo link_to(image_tag("/csDoctrineActAsSortablePlugin/images/sortable/icons/demote.png"),"'.$this->getModuleName().'/demote?id=".$'.$model.'->getId());
    } ?]

    [?php 
    if (array_key_exists("Doctrine_Template_Sortable", $'.$model.'->getTable()->getTemplates()) && $'.$model.'->getPosition() != 1){
      echo link_to(image_tag("/csDoctrineActAsSortablePlugin/images/sortable/icons/promote.png"),"'.$this->getModuleName().'/promote?id=".$'.$model.'->getId());
    } ?]';
    echo $arrows;
    ?>
<?php foreach ($this->configuration->getValue('list.object_actions') as $name => $params): ?>
<?php if ('_delete' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToDelete($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php elseif ('_edit' == $name): ?>
    <?php echo $this->addCredentialCondition('[?php echo $helper->linkToEdit($'.$this->getSingularName().', '.$this->asPhp($params).') ?]', $params) ?>

<?php else: ?>
    <li class="sf_admin_action_<?php echo $params['class_suffix'] ?>">
      <?php echo $this->addCredentialCondition($this->getLinkToAction($name, $params, true), $params) ?>

    </li>
<?php endif; ?>
<?php endforeach; ?>
  </ul>
</td>
