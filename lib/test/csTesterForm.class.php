<?php

class csTesterForm extends sfTesterForm
{
  public function setFormForPosition($position)
  {
    $this->form = null;

    $action = $this->browser->getContext()->getActionStack()->getLastEntry()->getActionInstance();

    $count = 0;
    
    foreach ($action->getVarHolder()->getAll() as $name => $value)
    {
      if ($value instanceof sfForm && $value->isBound())
      {
        $count++;
        if ($count == $position) 
        {
          $this->form = $value;
          break;
        }
      }
    }
    
    if (null === $this->form)
    {
      throw new LogicException(sprintf('no form has been submitted for position %s. Only %s forms found', $position, $count));
    }
    
    return $this->getObjectToReturn();
  }
}