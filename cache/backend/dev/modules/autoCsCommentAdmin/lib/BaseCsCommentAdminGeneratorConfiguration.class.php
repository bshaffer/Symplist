<?php

/**
 * csCommentAdmin module configuration.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage csCommentAdmin
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: configuration.php 12474 2008-10-31 10:41:27Z fabien $
 */
class BaseCsCommentAdminGeneratorConfiguration extends sfModelGeneratorConfiguration
{
  public function getCredentials($action)
  {
    if (0 === strpos($action, '_'))
    {
      $action = substr($action, 1);
    }

    return isset($this->configuration['credentials'][$action]) ? $this->configuration['credentials'][$action] : array();
  }

  public function getActionsDefault()
  {
    return array();
  }

  public function getFormActions()
  {
    return array(  '_delete' => NULL,  '_list' => NULL,  '_save' => NULL,  '_save_and_add' => NULL,);
  }

  public function getNewActions()
  {
    return array();
  }

  public function getEditActions()
  {
    return array();
  }

  public function getListObjectActions()
  {
    return array(  '_edit' => NULL,  '_delete' => NULL,  'approve' =>   array(    'label' => 'Approve',  ),);
  }

  public function getListActions()
  {
    return array(  'approve_all' =>   array(    'label' => 'Approve All',  ),);
  }

  public function getListBatchActions()
  {
    return array(  'approve' =>   array(    'label' => 'Approve Selected',  ),  'unapprove' =>   array(    'label' => 'Unapprove Selected',  ),  '_delete' => NULL,);
  }

  public function getListParams()
  {
    return '%%=body%% - %%created_at%% - %%approved%%';
  }

  public function getListLayout()
  {
    return 'tabular';
  }

  public function getListTitle()
  {
    return 'CsCommentAdmin List';
  }

  public function getEditTitle()
  {
    return 'Edit CsCommentAdmin';
  }

  public function getNewTitle()
  {
    return 'New CsCommentAdmin';
  }

  public function getFilterDisplay()
  {
    return array(  0 => 'body',  1 => 'user_id',  2 => 'approved',);
  }

  public function getFormDisplay()
  {
    return array(  0 => 'body',  1 => 'user_id',  2 => 'approved',);
  }

  public function getEditDisplay()
  {
    return array();
  }

  public function getNewDisplay()
  {
    return array();
  }

  public function getListDisplay()
  {
    return array(  0 => '=body',  1 => 'created_at',  2 => 'approved',);
  }

  public function getFieldsDefault()
  {
    return array(
      'id' => array(  'is_link' => true,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'body' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Comment Body',),
      'approved' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Boolean',),
      'approved_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'user_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'ForeignKey',  'label' => 'User',),
      'root_id' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'lft' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'rgt' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'level' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',),
      'created_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'updated_at' => array(  'is_link' => false,  'is_real' => true,  'is_partial' => false,  'is_component' => false,  'type' => 'Date',),
      'object_link' => array(  'is_link' => false,  'is_real' => false,  'is_partial' => false,  'is_component' => false,  'type' => 'Text',  'label' => 'Item',),
    );
  }

  public function getFieldsList()
  {
    return array(
      'id' => array(),
      'body' => array(),
      'approved' => array(),
      'approved_at' => array(),
      'user_id' => array(),
      'root_id' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_at' => array(),
      'updated_at' => array(),
    );
  }

  public function getFieldsFilter()
  {
    return array(
      'id' => array(),
      'body' => array(),
      'approved' => array(),
      'approved_at' => array(),
      'user_id' => array(),
      'root_id' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_at' => array(),
      'updated_at' => array(),
    );
  }

  public function getFieldsForm()
  {
    return array(
      'id' => array(),
      'body' => array(),
      'approved' => array(),
      'approved_at' => array(),
      'user_id' => array(),
      'root_id' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_at' => array(),
      'updated_at' => array(),
    );
  }

  public function getFieldsEdit()
  {
    return array(
      'id' => array(),
      'body' => array(),
      'approved' => array(),
      'approved_at' => array(),
      'user_id' => array(),
      'root_id' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_at' => array(),
      'updated_at' => array(),
    );
  }

  public function getFieldsNew()
  {
    return array(
      'id' => array(),
      'body' => array(),
      'approved' => array(),
      'approved_at' => array(),
      'user_id' => array(),
      'root_id' => array(),
      'lft' => array(),
      'rgt' => array(),
      'level' => array(),
      'created_at' => array(),
      'updated_at' => array(),
    );
  }


  public function getForm($object = null)
  {
    $class = $this->getFormClass();

    return new $class($object, $this->getFormOptions());
  }

  /**
   * Gets the form class name.
   *
   * @return string The form class name
   */
  public function getFormClass()
  {
    return 'CommentForm';
  }

  public function getFormOptions()
  {
    return array();
  }

  public function hasFilterForm()
  {
    return true;
  }

  /**
   * Gets the filter form class name
   *
   * @return string The filter form class name associated with this generator
   */
  public function getFilterFormClass()
  {
    return 'CommentFormFilter';
  }

  public function getFilterForm($filters)
  {
    $class = $this->getFilterFormClass();

    return new $class($filters, $this->getFilterFormOptions());
  }

  public function getFilterFormOptions()
  {
    return array();
  }

  public function getFilterDefaults()
  {
    return array();
  }

  public function getPager($model)
  {
    $class = $this->getPagerClass();

    return new $class($model, $this->getPagerMaxPerPage());
  }

  public function getPagerClass()
  {
    return 'sfDoctrinePager';
  }

  public function getPagerMaxPerPage()
  {
    return 10;
  }

  public function getDefaultSort()
  {
    return array('created_at', 'desc');
  }

  public function getTableMethod()
  {
    return '';
  }

  public function getTableCountMethod()
  {
    return '';
  }

  public function getConnection()
  {
    return null;
  }
}
