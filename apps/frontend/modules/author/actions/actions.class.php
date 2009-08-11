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
    $this->recentlyActive = Doctrine::getTable('sfGuardUser')->createQuery('u')
                      ->orderBy('u.updated_at DESC')
                      ->limit(10)
                      ->execute();
  }
  public function executeShow(sfWebRequest $request)
  {
    $this->user = Doctrine::getTable('sfGuardUser')->findOneByUsername($request->getParameter('username'));
    $this->forward404Unless($this->user);
  }
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->user = $this->getUser()->getGuardUser();
    $this->forward404Unless($this->user['username'] == $request->getParameter('username'));
    
    $this->userform = new sfGuardUserAdminForm($this->user);
    $this->profileform = new PluginAuthorForm($this->user['Author']);
    
    if ($request->isMethod('POST'))
    {
      $this->userform->bind($request->getParameter('sf_guard_user'));
      $this->profileform->bind($profile = $request->getParameter('plugin_author'));
      if ($this->userform->isValid() && $this->profileform->isValid()) 
      {
        $this->userform->save();
        $this->profileform->save();
        $this->setFlash('notice', 'Your profile has been saved');
      }
    }
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
