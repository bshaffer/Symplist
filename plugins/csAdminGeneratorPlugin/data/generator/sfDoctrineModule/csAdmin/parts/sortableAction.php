public function executeDemote(sfWebRequest $request)
{
  $object=Doctrine::getTable('<?php echo $this->getModelClass() ?>')->findOneById($this->getRequestParameter('id'));

  $object->demote();
  $this->redirect("<?php echo $this->getModuleName() ?>/index");
}

public function executePromote(sfWebRequest $request)
{
  $object=Doctrine::getTable('<?php echo $this->getModelClass() ?>')->findOneById($this->getRequestParameter('id'));

  $object->promote();
  $this->redirect("<?php echo $this->getModuleName() ?>/index");
}