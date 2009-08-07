<?php

require_once(dirname(__FILE__).'/../lib/BaseCsCommentAdminGeneratorConfiguration.class.php');
require_once(dirname(__FILE__).'/../lib/BaseCsCommentAdminGeneratorHelper.class.php');

/**
 * csCommentAdmin actions.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage csCommentAdmin
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: actions.class.php 12493 2008-10-31 14:43:26Z fabien $
 */
class autoCsCommentAdminActions extends sfActions
{
  public function preExecute()
  {
    $this->configuration = new csCommentAdminGeneratorConfiguration();

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($this->getActionName())))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $this->dispatcher->notify(new sfEvent($this, 'admin.pre_execute', array('configuration' => $this->configuration)));

    $this->helper = new csCommentAdminGeneratorHelper();
  }

  public function executeIndex(sfWebRequest $request)
  {
    // sorting
    if ($request->getParameter('sort'))
    {
      $this->setSort(array($request->getParameter('sort'), $request->getParameter('sort_type')));
    }
    elseif (array_key_exists("Doctrine_Template_Sortable", Doctrine::getTable('Comment')->getTemplates())){
      $this->setSort(array('position', 'ASC'));
    }

    // pager
    if ($request->getParameter('page'))
    {
      $this->setPage($request->getParameter('page'));
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();
  }

  public function executeFilter(sfWebRequest $request)
  {
    $this->setPage(1);

    if ($request->hasParameter('_reset'))
    {
      $this->setFilters($this->configuration->getFilterDefaults());

      $this->redirect('@comment_csCommentAdmin');
    }

    $this->filters = $this->configuration->getFilterForm($this->getFilters());

    $this->filters->bind($request->getParameter($this->filters->getName()));
    if ($this->filters->isValid())
    {
      $this->setFilters($this->filters->getValues());

      $this->redirect('@comment_csCommentAdmin');
    }

    $this->pager = $this->getPager();
    $this->sort = $this->getSort();

    $this->setTemplate('index');
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->comment = $this->form->getObject();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->form = $this->configuration->getForm();
    $this->comment = $this->form->getObject();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->comment = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->comment);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->comment = $this->getRoute()->getObject();
    $this->form = $this->configuration->getForm($this->comment);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    $this->getRoute()->getObject()->delete();

    $this->getUser()->setFlash('notice', 'The item was deleted successfully.');

    $this->redirect('@comment_csCommentAdmin');
  }

  public function executeBatch(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    if (!$ids = $request->getParameter('ids'))
    {
      $this->getUser()->setFlash('error', 'You must at least select one item.');

      $this->redirect('@comment_csCommentAdmin');
    }

    if (!$action = $request->getParameter('batch_action'))
    {
      $this->getUser()->setFlash('error', 'You must select an action to execute on the selected items.');

      $this->redirect('@comment_csCommentAdmin');
    }

    if (!method_exists($this, $method = 'execute'.ucfirst($action)))
    {
      throw new InvalidArgumentException(sprintf('You must create a "%s" method for action "%s"', $method, $action));
    }

    if (!$this->getUser()->hasCredential($this->configuration->getCredentials($action)))
    {
      $this->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }

    $validator = new sfValidatorDoctrineChoiceMany(array('model' => 'Comment'));
    try
    {
      // validate ids
      $ids = $validator->clean($ids);

      // execute batch
      $this->$method($request);
    }
    catch (sfValidatorError $e)
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items as some items do not exist anymore.');
    }

    $this->redirect('@comment_csCommentAdmin');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');

    $count = Doctrine_Query::create()
      ->delete()
      ->from('Comment')
      ->whereIn('id', $ids)
      ->execute();

    if ($count >= count($ids))
    {
      $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    }
    else
    {
      $this->getUser()->setFlash('error', 'A problem occurs when deleting the selected items.');
    }

    $this->redirect('@comment_csCommentAdmin');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $this->getUser()->setFlash('notice', $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.');

      $comment = $form->save();

      $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $comment)));

      if ($request->hasParameter('_save_and_add'))
      {
        $this->getUser()->setFlash('notice', $this->getUser()->getFlash('notice').' You can add another one below.');

        $this->redirect('@comment_csCommentAdmin_new');
      }
      else
      {
        $this->redirect('@comment_csCommentAdmin_edit?id='.$comment->getId());
      }
    }
    else
    {
      $this->getUser()->setFlash('error', 'The item has not been saved due to some errors.');
    }
  }

  protected function getFilters()
  {
    return $this->getUser()->getAttribute('csCommentAdmin.filters', $this->configuration->getFilterDefaults(), 'admin_module');
  }

  protected function setFilters(array $filters)
  {
    return $this->getUser()->setAttribute('csCommentAdmin.filters', $filters, 'admin_module');
  }

  protected function getPager()
  {
    $pager = $this->configuration->getPager('Comment');
    $pager->setQuery($this->buildQuery());
    $pager->setPage($this->getPage());
    $pager->init();

    return $pager;
  }

  protected function setPage($page)
  {
    $this->getUser()->setAttribute('csCommentAdmin.page', $page, 'admin_module');
  }

  protected function getPage()
  {
    return $this->getUser()->getAttribute('csCommentAdmin.page', 1, 'admin_module');
  }

  protected function buildQuery()
  {
    $tableMethod = $this->configuration->getTableMethod();
    if (is_null($this->filters))
    {
      $this->filters = $this->configuration->getFilterForm($this->getFilters());
    }

    $this->filters->setTableMethod($tableMethod);

    $query = $this->filters->buildQuery($this->getFilters());

    $this->addSortQuery($query);

    $event = $this->dispatcher->filter(new sfEvent($this, 'admin.build_query'), $query);
    $query = $event->getReturnValue();

    return $query;
  }

  protected function addSortQuery($query)
  {
    if (array(null, null) == ($sort = $this->getSort()))
    {
      return;
    }

    $query->addOrderBy($sort[0] . ' ' . $sort[1]);
  }

  protected function getSort()
  {
    if (!is_null($sort = $this->getUser()->getAttribute('csCommentAdmin.sort', null, 'admin_module')))
    {
      return $sort;
    }

    $this->setSort($this->configuration->getDefaultSort());

    return $this->getUser()->getAttribute('csCommentAdmin.sort', null, 'admin_module');
  }

  protected function setSort(array $sort)
  {
    if (!is_null($sort[0]) && is_null($sort[1]))
    {
      $sort[1] = 'asc';
    }

    $this->getUser()->setAttribute('csCommentAdmin.sort', $sort, 'admin_module');
  }

public function executeDemote(sfWebRequest $request)
{
  $object=Doctrine::getTable('Comment')->findOneById($this->getRequestParameter('id'));

  $object->demote();
  $this->redirect("csCommentAdmin/index");
}

public function executePromote(sfWebRequest $request)
{
  $object=Doctrine::getTable('Comment')->findOneById($this->getRequestParameter('id'));

  $object->promote();
  $this->redirect("csCommentAdmin/index");
}
}
