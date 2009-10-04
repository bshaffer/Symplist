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
    $this->plugins = Doctrine::getTable("SymfonyPlugin")->createQuery()->orderBy('title ASC')->execute();
  }
  
  public function executeList(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('SymfonyPlugin', 10);

    $q = Doctrine::getTable("SymfonyPlugin")->createQuery()->orderBy('title ASC');
                
    $this->pager->setQuery($q);

    $this->pager->setPage($request->getParameter('page', 1));
    
    $this->pager->init();    
  }
  
  public function executeRegister(sfWebRequest $request)
  {
    $this->form = new SymfonyPluginForm();
    if ($user = $this->getUser()->getGuardUser()) 
    {
      $this->form->setDefault('user_id', $user['id']);
    }
    if ($request->isMethod('POST')) 
    {
      $this->form->bind($request->getParameter('symfony_plugin'), $request->getFiles('symfony_plugin'));
      if ($this->form->isValid()) 
      {
        $this->form->save();
        $this->redirect('@plugin?title='.$this->form->getValue('title'));
      }
    }
  }
  
  public function executeRate(sfWebRequest $request)
  {
    $this->plugin = Doctrine::getTable('SymfonyPlugin')->findOneByTitle($request->getParameter('title'));
    $this->forward404Unless($this->plugin);
    $this->plugin->addRating($request->getParameter('rating'), $this->getUser());
    $this->plugin->refresh();
    return $this->renderPartial('plugin/rating_info', array('plugin' => $this->plugin));
  }
  
  public function executeClaim(sfWebRequest $request)
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
  
  public function executeEdit(sfWebRequest $request)
  {
    $this->plugin = Doctrine::getTable("SymfonyPlugin")->findOneByTitle($request->getParameter('title'));
    $this->forward404Unless($this->plugin);
    $this->form = new SymfonyPluginForm($this->plugin);
    if ($request->isMethod('POST')) 
    {
      $this->form->bind($request->getParameter('symfony_plugin'), $request->getFiles('symfony_plugin'));
      if ($this->form->isValid()) 
      {
        $this->form->save();
        $this->getUser()->setFlash('notice', 'Plugin Saved');
      }
    }
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->plugin = Doctrine::getTable("SymfonyPlugin")->findOneByTitle($request->getParameter('title'));
    $this->forward404Unless($this->plugin);
  }
  
  public function executeAutocomplete(sfWebRequest $request)
  {
    $q = $request->getParameter('q');
    
    $results = Doctrine::getTable('SymfonyPlugin')->createQuery('p')
                    ->select('p.title')->where('title like ?', "%$q%")
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)->limit(20)->execute();

    return $this->renderPartial('plugin/autocomplete_results', array('results' => $results));
  }

  public function executeVerboseAutocomplete(sfWebRequest $request)
  {
    $q = $request->getParameter('form[query]');
    
    $query = Doctrine::getTable('SymfonyPlugin')->createQuery('p')
                    ->select('p.title, LEFT(p.description, 200) as description, AVG(r.rating) as rating')
                    ->leftJoin('p.Ratings r')
                    ->addWhere('title like ?', "%$q%")
                    // ->orWhere('description like ?', "%$q%")
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(10)
                    ->groupBy('p.id');
                    
    if ($request->getParameter('published_only') == 'true') 
    {
      $query->innerJoin('p.Releases rel');
    }
    
    if ($request->hasParameter('version') && $request->getParameter('version') != 'all') 
    {
      $v = $request->getParameter('version');
      $query->innerJoin('p.Releases rel')
            ->andWhere('rel.symfony_version_min like ? OR rel.symfony_version_max like ?', array("$v%", "$v%"));
    }

    $results = $query->execute();

    return $this->renderPartial('plugin/verbose_autocomplete_results', array('results' => $results));
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    $plugin = Doctrine::getTable('SymfonyPlugin')->findOneByTitle($request->getParameter('form[query]'));
    if ($plugin) 
    {
      $this->redirect('@plugin?title='.$plugin['title']);
    }
    $this->forward('sfLucene', 'search');
  }
}
