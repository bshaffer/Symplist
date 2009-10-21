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
    $this->pager = new sfDoctrinePager('CommunityList', 10);

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
  
  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    $this->form = new CommunityListForm();
    $this->form->setDefault('submitted_by', $this->getUser()->getGuardUser()->getId());
    $this->item_forms = array();
    
    if ($request->isMethod('POST')) 
    {
      // exit(print_r($request->getParameter('community_list')));
      $this->form->bind($request->getParameter('community_list'));
      
      if ($this->form->isValid()) 
      {
        $list = $this->form->save();
        $success = true;
        
        // Bind all of the item forms
        foreach ($request->getParameter('community_list_item', array()) as $item) 
        {
          $item['list_id'] = $list['id'];
          $item_form = new InlineCommunityListItemForm();;
          $item_form->bind($item);
          
          if ($item_form->isValid()) 
          {
            $item_form->save();
          }
          else
          {
            $success = false;
          }
          
          $this->item_forms[] = $item_form;
        }
        
        if ($success) 
        {
          $this->redirect('@community_list?slug='.$list['slug']);
        }
      }
    }
  }
  
  public function executeAddListItem(sfWebRequest $request)
  {
    $this->forward404Unless($this->getUser()->isAuthenticated());
    $this->list = Doctrine::getTable('CommunityList')->findOneBySlug($request->getParameter('slug'));
    $this->forward404Unless($this->list);
            
    $item = new CommunityListItem();
    $item['User'] = $this->getUser()->getGuardUser();
    $item['List'] = $this->list;
    $this->form = new CommunityListItemForm($item);
    if ($request->isMethod('Post')) 
    {
      $this->form->bind($request->getParameter('community_list_item'));
      if ($this->form->isValid()) 
      {
        $this->form->save();
        $this->getUser()->setFlash('notice', 'List item added');
        
        $item = new CommunityListItem();
        $item['List'] = $this->list;
        $this->form = new CommunityListItemForm($item);
      }
    }
  }
  
  public function executeAddListItemAjax(sfWebRequest $request)
  {
    if (!$this->getUser()->isAuthenticated()) 
    {
      return $this->renderText('Your Session has Expired');
    }
    $form = new InlineCommunityListItemForm();
    $form->setDefault('list_id', $request->getParameter('list_id'));
    $form->setDefault('submitted_by', $this->getUser()->getGuardUser()->getId())
    return $this->renderText($form->__toString());
  }

}
