<?php

/**
 * comments actions.
 *
 * @package    vandyhw
 * @subpackage comments
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class BasecsCommentsActions extends sfActions
{
  /**
   * displays the form to add a comment
   *
   * @return void
   * @author Brent Shaffer
   */
  public function executeAdd(sfWebRequest $request)
  {
    $record = Doctrine::getTable($request->getParameter('model'))->find($request->getParameter('record_id'));
    return $this->renderComponent('csComments', 'add_comment', array('record' => $record));
  }

  /**
   * executeDo_add_new_comment 
   * 
   * @access public
   * @return void
   */
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
    $comment['Commenter'] = $commenter;
    $comment->save();
    
    $this->comment = $comment;
    
    // Pass parent comment id if comment is nested
    $parent_id = $this->getRequestParameter('comment_id');
    $this->record->addComment($this->comment, $parent_id);
    $this->record->save();
  }

  /**
   * executeDo_delete_comment 
   * 
   * @access public
   * @return void
   */
  public function executeDoDelete()
  {
    // Setup some needed vars
    $comment_id = $this->getRequestParameter('comment_id');

    // Get the comment we are deleting
    $comment = Doctrine::getTable('Comment')->find($comment_id);
    $comment->getNode()->delete();

    $this->getUser()->setFlash('notice', 'Comment was successfully deleted!');
    $this->redirect($this->getRequestParameter('return_uri').'#comments');
  }
}
