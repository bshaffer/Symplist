<td>
  <ul class="sf_admin_td_actions">
        
    <?php 
    if (array_key_exists("Doctrine_Template_Sortable", $symfony_plugin->getTable()->getTemplates()) && $symfony_plugin->getPosition() != $symfony_plugin->getFinalPosition()){
      echo link_to(image_tag("/csDoctrineActAsSortablePlugin/images/sortable/icons/demote.png"),"symfony_plugin/demote?id=".$symfony_plugin->getId());
    } ?>

    <?php 
    if (array_key_exists("Doctrine_Template_Sortable", $symfony_plugin->getTable()->getTemplates()) && $symfony_plugin->getPosition() != 1){
      echo link_to(image_tag("/csDoctrineActAsSortablePlugin/images/sortable/icons/promote.png"),"symfony_plugin/promote?id=".$symfony_plugin->getId());
    } ?>    <?php echo $helper->linkToEdit($symfony_plugin, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($symfony_plugin, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
</td>
