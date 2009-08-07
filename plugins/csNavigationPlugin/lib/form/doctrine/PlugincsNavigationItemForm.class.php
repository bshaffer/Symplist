<?php

/**
 * PlugincsNavigationItem form.
 *
 * @package    form
 * @subpackage csNavigationItem
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PlugincsNavigationItemForm extends BasecsNavigationItemForm
{
  protected $parentId = null;
  // protected $display_root;
  // 
  // public function __construct($model = null, $display_root = null)
  // {
  //  parent::__construct($model);
  //  $this->display_root = $display_root;
  // }

  public function setup()
  {
    parent::setup();
    unset($this['root_id'], $this['lft'], $this['rgt'], $this['level'], $this['id']);
    unset($this['locked']);
    
    $this->widgetSchema['route'] = new sfWidgetFormInputHidden();
    
    if($this->isNew())
    {
      $this->setDefault('route', '@generic_interior');
      $this->validatorSchema['route'] = new sfValidatorString();
    }

    Doctrine::getTable('csNavigation')->setForm($this);
    
    $this->widgetSchema['parent_id'] = new sfWidgetFormDoctrineChoice(array(
      'model' => 'csNavigationItem',
      'add_empty' => '~ (object is at root level)',
      'order_by' => array('root_id, lft',''),
      'method' => 'getIndentedName'
      ));

    $this->validatorSchema['parent_id'] = new sfValidatorDoctrineChoice(array(
      'required' => false,
      'model' => 'csNavigationItem'
      ));

    $this->setDefault('parent_id', $this->object->getParentId());
    $this->widgetSchema->setLabel('parent_id', 'Child of');
  }
  
  public function updateParentIdColumn($parentId)
  {    
    $this->parentId = $parentId;
    // further action is handled in the save() method
  }  
 
  protected function doSave($con = null)
  {
    parent::doSave($con);
 
    $node = $this->object->getNode();
 
    if ($this->parentId != $this->object->getParentId() || !$node->isValidNode())
    {
      if (empty($this->parentId))
      {
        //save as a root
        if ($node->isValidNode())
        {
          $node->makeRoot($this->object['id']);
          $this->object->save($con);
        }
        else
        {
          $this->object->getTable()->getTree()->createRoot($this->object); //calls $this->object->save internally
        }
      }
      else
      {
        //form validation ensures an existing ID for $this->parentId
        $parent = $this->object->getTable()->find($this->parentId);
        $method = ($node->isValidNode() ? 'move' : 'insert') . 'AsFirstChildOf';
        $node->$method($parent); //calls $this->object->save internally
      }
    }
  }
}