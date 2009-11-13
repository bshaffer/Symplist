<?php

/**
 * PluginRelease form base class.
 *
 * @method PluginRelease getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BasePluginReleaseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'plugin_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'), 'add_empty' => true)),
      'version'             => new sfWidgetFormInputText(),
      'date'                => new sfWidgetFormDateTime(),
      'symfony_version_min' => new sfWidgetFormInputText(),
      'symfony_version_max' => new sfWidgetFormInputText(),
      'summary'             => new sfWidgetFormTextarea(),
      'stability'           => new sfWidgetFormInputText(),
      'readme'              => new sfWidgetFormTextarea(),
      'dependencies'        => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'plugin_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'), 'required' => false)),
      'version'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'date'                => new sfValidatorDateTime(array('required' => false)),
      'symfony_version_min' => new sfValidatorNumber(array('required' => false)),
      'symfony_version_max' => new sfValidatorNumber(array('required' => false)),
      'summary'             => new sfValidatorString(array('required' => false)),
      'stability'           => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'readme'              => new sfValidatorString(array('required' => false)),
      'dependencies'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plugin_release[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRelease';
  }

}
