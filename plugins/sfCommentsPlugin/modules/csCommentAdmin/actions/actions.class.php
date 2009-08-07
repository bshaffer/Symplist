<?php

require_once dirname(__FILE__).'/../lib/csCommentAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/csCommentAdminGeneratorHelper.class.php';

/**
 * csCommentsAdmin actions.
 *
 * @package    ./
 * @subpackage csCommentsAdmin
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12474 2008-10-31 10:41:27Z fabien $
 */
class csCommentAdminActions extends autoCsCommentAdminActions
{
  public function executeBatchApprove(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    $q = Doctrine_Query::create()->from('Comment')->whereIn('id', $ids);
    foreach ($q->execute() as $comment) 
    {
      $comment->approve();
    }
  }
  public function executeBatchUnapprove(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    $q = Doctrine_Query::create()->from('Comment')->whereIn('id', $ids);
    foreach ($q->execute() as $comment) 
    {
      $comment->unapprove();
    }
  }
  
  //Ensures comments are properly moved from the nested set tree
  public function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    $q = Doctrine_Query::create()->from('Comment')->whereIn('id', $ids);
    foreach ($q->execute() as $comment) 
    {
      $comment->getNode()->delete();
      $comment->delete();
    }
  }
  public function executeListApprove(sfWebRequest $request)
  {
    Doctrine::getTable('Comment')->findOneById($request->getParameter('id'))->approve();
    $this->redirect('@comment_csCommentAdmin');
  }
  public function executeListApproveAll(sfWebRequest $request)
  {
    $unapproved = Doctrine::getTable('Comment')->findUnapproved();
    Doctrine::getTable('Comment')->approveAll();
    $notice = $unapproved->count() > 0 ? 'Successfully approved '.$unapproved->count(). ' comment' . ($unapproved->count() > 1 ? 's' : '') : 'All comments are already approved';
    $this->getUser()->setFlash('notice', $notice);
    $this->redirect('@comment_csCommentAdmin');
  }
}
