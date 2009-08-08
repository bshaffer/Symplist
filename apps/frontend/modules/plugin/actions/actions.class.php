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
