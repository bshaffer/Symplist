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
    $this->plugin = $this->getRoute()->getObject();
    $this->plugin->addRating($request->getParameter('rating'), $this->getUser());
    $this->plugin->refresh();
    return $this->renderPartial('plugin/rating', array('rating' => $this->plugin->getRating()));
  }
  
  public function executeClaim(sfWebRequest $request)
  {
    $this->plugin = $this->getRoute()->getObject();
    
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
    $this->plugin = $this->getRoute()->getObject();
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
    $this->plugin = $this->getRoute()->getObject();
    $this->rating = $this->plugin->getRating();
    $this->forward404Unless($this->plugin);
  }
  
  public function executeAutocomplete(sfWebRequest $request)
  {
    $q = $request->getParameter('q');
    
    $results = Doctrine::getTable('SymfonyPlugin')->createQuery('p')
                    ->select('p.title')->where('title like ?', "%$q%")
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)->limit(20)->execute();
    
    $ret = count($results) ? '' : 'No Results';
    foreach ($results as $result) 
      $ret .= $result['title']."\n";
    return $this->renderText($ret);
  }

  public function executeHomeAutocomplete(sfWebRequest $request)
  {    
    $q = str_replace(' ', '%', $request->getParameter('q'));
    if ($q == '') 
    {
      return $this->renderText('');
    }

    $query = Doctrine::getTable('SymfonyPlugin')->createQuery('p')
                    ->select('p.title, LEFT(p.description, 200) as summary, AVG(r.rating) as rating')
                    ->leftJoin('p.Ratings r')
                    ->addWhere('title like ?', "%$q%")
                    ->orWhere('description like ?', "%$q%")
                    ->setHydrationMode(Doctrine::HYDRATE_ARRAY)
                    ->limit(8)
                    ->groupBy('p.id');

    // $query->innerJoin('p.Releases rel');
    $results = $query->execute();

    return $this->renderPartial('plugin/home_autocomplete_results', array('results' => $results, 'classes' => array('alpha','','','omega')));
  }
  
  public function executeSearch(sfWebRequest $request)
  {
    $q = $request->hasParameter('form[query]') ? $request->getParameter('form[query]') : $request->getParameter('q');
    $plugin = $q ? Doctrine::getTable('SymfonyPlugin')->findOneByTitle($q) : null;
    if ($plugin) 
    {
      $this->redirect('@plugin?title='.$plugin['title']);
    }
    $request->setParameter('form', array('query' => $q));

    $this->forward('sfLucene', 'search');
  }
}
