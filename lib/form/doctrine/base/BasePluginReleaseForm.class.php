<?php

/**
 * PluginRelease form base class.
 *
 * @package    form
 * @subpackage plugin_release
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasePluginReleaseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'plugin_id'           => new sfWidgetFormDoctrineChoice(array('model' => 'SymfonyPlugin', 'add_empty' => true)),
      'version'             => new sfWidgetFormInput(),
      'date'                => new sfWidgetFormDateTime(),
      'symfony_version_min' => new sfWidgetFormInput(),
      'symfony_version_max' => new sfWidgetFormInput(),
      'summary'             => new sfWidgetFormTextarea(),
      'stability'           => new sfWidgetFormInput(),
      'readme'              => new sfWidgetFormTextarea(),
      'dependencies'        => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => 'PluginRelease', 'column' => 'id', 'required' => false)),
      'plugin_id'           => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPlugin', 'required' => false)),
      'version'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'date'                => new sfValidatorDateTime(array('required' => false)),
      'symfony_version_min' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'symfony_version_max' => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'summary'             => new sfValidatorString(array('required' => false)),
      'stability'           => new sfValidatorString(array('max_length' => 30, 'required' => false)),
      'readme'              => new sfValidatorString(array('required' => false)),
      'dependencies'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plugin_release[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRelease';
  }

}
