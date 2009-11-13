<?php

/**
 * csNavigationMenu form base class.
 *
 * @method csNavigationMenu getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BasecsNavigationMenuForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'title'       => new sfWidgetFormInputText(),
      'description' => new sfWidgetFormInputText(),
      'root_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('NavigationRoot'), 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'title'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'root_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('NavigationRoot'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('cs_navigation_menu[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'csNavigationMenu';
  }

}
