<?php

/**
 * list actions.
 *
 * @package    plugintracker
 * @subpackage list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class listActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->pager = new sfDoctrinePager('SymfonyPlugin', 10);

    $q = Doctrine::getTable('CommunityList')->getPopularListsQuery();
                
    $this->pager->setQuery($q);

    $this->pager->setPage($request->getParameter('page', 1));
    
    $this->pager->init();  
    
    $this->lists = $this->pager->getResults();  
  }
  
  public function executeShow(sfWebRequest $request)
  {
    $this->list = Doctrine::getTable('CommunityList')->findOneBySlug($request->getParameter('slug'));
    $this->forward404Unless($this->list);
  }
  
  public function executeRate(sfWebRequest $request)
  {
    $item = Doctrine::getTable('CommunityListItem')->findOneById($request->getParameter('id'));
    $this->forward404Unless($item);
    $item['score'] = (int)$item['score'] + $request->getParameter('rating', 0);
    $item['count'] = $item['count'] + 1;
    $item->save();
    $selected = $request->getParameter('rating') > 0 ? 'thumbs-up-selected' : 'thumbs-down-selected';
    return $this->renderPartial('list/rating', array('item' => $item, 'selected' => $selected));
  }

}
