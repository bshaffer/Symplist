<?php

/**
 * author actions.
 *
 * @package    plugintracker
 * @subpackage author
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class authorActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $q = Doctrine::getTable('sfGuardUser')->createQuery('u')
                      ->orderBy('u.updated_at DESC')
                      ->limit(10);
                      
    $this->pager = new sfDoctrinePager('sfGuardUser');
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
  
  public function executeAll(sfWebRequest $request)
  {
    $this->users = Doctrine::getTable('sfGuardUser')->createQuery('u')->orderBy('u.username ASC')->execute();
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->user = $this->getRoute()->getObject();

    $this->isUser = $this->getUser()->isUser($this->user);
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getGuardUser();
    $this->forward403Unless($this->user['username'] == $request->getParameter('username'));
    
    $this->userform = new sfGuardUserAdminForm($this->user);
    $this->profileform = new PluginAuthorForm($this->user['Author']);
    
    if ($request->isMethod('PUT'))
    {
      $this->userform->bind($request->getParameter('sf_guard_user'));
      $this->profileform->bind($profile = $request->getParameter('plugin_author'));
      if ($this->userform->isValid() && $this->profileform->isValid()) 
      {
        $this->userform->save();
        $this->profileform->save();
        $this->getUser()->setFlash('notice', 'Your profile has been saved');
      }
    }
  }
  
  public function executePluginRemove(sfWebRequest $request)
  {
    $pluginAuthor = $this->getRoute()->getObject();
    
    if ($this->getUser()->isUser($pluginAuthor['Author'])) 
    {
      $plugin = $pluginAuthor['Plugin'];
      $pluginAuthor->delete();
      
      $this->getUser()->setFlash('notice', sprintf('You have removed "%s" from your plugins', $plugin));
    }
    else
    {
      $this->getUser()->setFlash('error', 'You do not have the permission to perform this function');
    }
    
    $referer = $request->getReferer();
    $this->redirect($referer ? $referer : '@homepage');
  }
  
  public function executeJoin(sfWebRequest $request)
  {
    if ($request->isMethod('POST')) 
    {
      if ($user = $request->getParameter('sf_guard_user')) 
      {
        $this->form = new sfGuardUserAdminForm();
        $this->form->bind($user);
        if ($this->form->isValid()) 
        {
          $this->form->save();
          $user = $this->form->getObject();
          $this->form = new PluginAuthorForm();
          $this->getUser()->signin($user);          
          $this->form->setDefault('sf_guard_user_id', $user['id']);
        }
        else
        {
          return 'One';
        }
      }
      else
      {
        $this->form = new PluginAuthorForm();
        $this->form->bind($request->getParameter('plugin_author'));
        if ($this->form->isValid()) 
        {
          $this->form->save();
          $this->getUser()->setFlash('notice', 'New user profile successfully created');
          return 'Confirm';
        }
      }
      return 'Two';
    }
    $this->form = new sfGuardUserAdminForm();
    return 'One';

  }
}
