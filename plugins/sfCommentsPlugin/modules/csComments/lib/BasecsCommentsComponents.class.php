<?php
class BasecsCommentsComponents extends sfComponents
{
  public function executeThread()
  {
    $this->comments = $this->record->getCommentThread();
  }
  
  public function executeAdd_comment()
  {
    try
    {
      $commentFormClass = $this->record->getCommentFormClass();
      if(sfContext::getInstance()->getRequest()->hasParameter($commentFormClass))
      {
        $this->commentForm = sfContext::getInstance()->getRequest()->getParameter($commentFormClass);
      } 
      else
      {
        $this->commentForm = new $commentFormClass();
      }
    }
    catch(Exception $e)
    {
      echo $e;
    }
  }
}