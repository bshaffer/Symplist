<?php

/**
 * plugin actions.
 *
 * @package    plugintracker
 * @subpackage plugin
 */
class pluginActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  }
  
  public function executeList(sfWebRequest $request)
  {
    
  }
  
  public function executeNew(sfWebRequest $request)
  {
    $this->form = new NewSymfonyPlugin();
    if ($user = $this->getUser()->getGuardUser()) 
    {
      $this->form->setDefault('user_id', $user['id']);
    }
  }
  
  public function executeRegister(sfWebRequest $request)
  {
    $this->plugin = Doctrine::getTable('SymfonyPlugin')->findOneByTitle($request->getParameter('title'));
    $this->forward404Unless($this->plugin);
    
    if (!$this->user = $this->getUser()->getGuardUser()) 
    {
      $this->getUser()->setFlash('notice', 'You must sign in first before accessing this function');
      $this->redirect('@signin');
    }
    
    // Register the Plugin
    if ($request->isMethod('POST')) 
    {
      $this->plugin['User'] = $this->user;
      $this->plugin->save();
      return 'Confirm';
    }
  }
  
  public function executeClaim(sfWebRequest $request)
  {
    exit('coming soon');
  }
  
  public function executeByCategory(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('SymfonyPlugin', 10);
    $this->category = Doctrine::getTable('PluginCategory')->findOneBySlug($request->getParameter('slug'));
    $this->forward404Unless($this->category);

    $q = Doctrine::getTable("SymfonyPlugin")->createQuery()
                ->where('category_id = ?', $this->category['id'])
                ->orderBy('title ASC');
                
    $this->pager->setQuery($q);

    $this->pager->setPage($request->getParameter('page', 1));
    
    $this->pager->init();
  }
  
  public function executeCategories(sfWebRequest $request)
  {
    $this->categories = Doctrine::getTable('PluginCategory')->createQuery('c')->orderBy('name ASC')->execute();
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->plugin = Doctrine::getTable("SymfonyPlugin")->findOneByTitle($request->getParameter('title'));
  }
}
