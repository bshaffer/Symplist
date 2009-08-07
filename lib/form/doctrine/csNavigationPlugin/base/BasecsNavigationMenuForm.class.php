<?php

/**
 * csNavigationMenu form base class.
 *
 * @package    form
 * @subpackage cs_navigation_menu
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasecsNavigationMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInput(),
      'description' => new sfWidgetFormInput(),
      'root_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'csNavigationItem', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'csNavigationMenu', 'column' => 'id', 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'root_id'     => new sfValidatorDoctrineChoice(array('model' => 'csNavigationItem', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cs_navigation_menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'csNavigationMenu';
  }

}
