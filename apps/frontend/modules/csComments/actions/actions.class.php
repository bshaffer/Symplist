<?php

require_once(sfConfig::get('sf_plugins_dir').'/sfCommentsPlugin/modules/csComments/lib/BasecsCommentsActions.class.php');
/**
* 
*/
class csCommentsActions extends BasecsCommentsActions
{
  public function executeDoAdd(sfWebRequest $request)
  {  
    // Pull associated model
    $record_id = $request->getParameter('record_id');
    $model = $request->getParameter('model');
    $this->record = Doctrine::getTable($model)->find($record_id);

    $commentForm = new CommentForm();
    $commentForm->bind($request->getParameter('comment'));

    // return bound form with errors if form is invalid
    if(!$commentForm->isValid())
    {
      return $this->renderPartial('csComments/add_comment', 
          array('commentForm' => $commentForm));
    }
    
    // save the object
    
    /* SHOULD USE IMBEDDED FORMS
        Used this hack instead.  Need to fix
        -B.Shaffer
    */
    $commentVals = $commentForm->getValues();
    $commenter = new Commenter();
    $commenter->fromArray($commentVals['Commenter']);
    $commenter->save();
    
    $comment = new Comment();
    $comment['body'] = $commentVals['body'];
    $comment['rating'] = $commentVals['rating'];
    $comment['Commenter'] = $commenter;
    $comment->save();
    
    $this->comment = $comment;
    
    // Pass parent comment id if comment is nested
    $parent_id = $this->getRequestParameter('comment_id');
    $this->record->addComment($this->comment, $parent_id);
    $this->record->save();
  }
}
