<?php

/**
 * csNavigationItem form base class.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BasecsNavigationItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'name'      => new sfWidgetFormInput(),
      'route'     => new sfWidgetFormInput(),
      'protected' => new sfWidgetFormInputCheckbox(),
      'locked'    => new sfWidgetFormInputCheckbox(),
      'root_id'   => new sfWidgetFormInput(),
      'lft'       => new sfWidgetFormInput(),
      'rgt'       => new sfWidgetFormInput(),
      'level'     => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorDoctrineChoice(array('model' => 'csNavigationItem', 'column' => 'id', 'required' => false)),
      'name'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'route'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'protected' => new sfValidatorBoolean(array('required' => false)),
      'locked'    => new sfValidatorBoolean(array('required' => false)),
      'root_id'   => new sfValidatorInteger(array('required' => false)),
      'lft'       => new sfValidatorInteger(array('required' => false)),
      'rgt'       => new sfValidatorInteger(array('required' => false)),
      'level'     => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cs_navigation_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'csNavigationItem';
  }

}
