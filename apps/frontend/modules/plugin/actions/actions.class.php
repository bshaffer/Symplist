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
    $this->category = Doctrine::getTable('PluginCategory')->findOneBySlug($request->getParameter('slug'));
    $this->forward404Unless($this->category);
    
    $this->pager = new DoctrinePager('Plugin', 10);
    $this->pager->setQuery(Doctrine::getTable("Plugin")->createQuery()->where('category_id = ?', $this->category['id']));
    $this->pager->setPage($request->getParameter('page', 1));
  }
}
