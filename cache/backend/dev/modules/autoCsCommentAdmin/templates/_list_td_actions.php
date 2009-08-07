<td>
  <ul class="sf_admin_td_actions">
        
    <?php 
    if (array_key_exists("Doctrine_Template_Sortable", $comment->getTable()->getTemplates()) && $comment->getPosition() != $comment->getFinalPosition()){
      echo link_to(image_tag("/csDoctrineActAsSortablePlugin/images/sortable/icons/demote.png"),"csCommentAdmin/demote?id=".$comment->getId());
    } ?>

    <?php 
    if (array_key_exists("Doctrine_Template_Sortable", $comment->getTable()->getTemplates()) && $comment->getPosition() != 1){
      echo link_to(image_tag("/csDoctrineActAsSortablePlugin/images/sortable/icons/promote.png"),"csCommentAdmin/promote?id=".$comment->getId());
    } ?>    <?php echo $helper->linkToEdit($comment, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($comment, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
    <li class="sf_admin_action_approve">
      <?php echo link_to(__('Approve', array(), 'messages'), 'csCommentAdmin/ListApprove?id='.$comment->getId(), array()) ?>
    </li>
  </ul>
</td>
