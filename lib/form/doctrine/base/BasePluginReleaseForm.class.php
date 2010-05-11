<?php

/**
 * PluginRelease form base class.
 *
 * @method PluginRelease getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BasePluginReleaseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'plugin_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'), 'add_empty' => false)),
      'version'             => new sfWidgetFormInputText(),
      'date'                => new sfWidgetFormDateTime(),
      'symfony_version_min' => new sfWidgetFormInputText(),
      'symfony_version_max' => new sfWidgetFormInputText(),
      'summary'             => new sfWidgetFormTextarea(),
      'stability'           => new sfWidgetFormChoice(array('choices' => array('alpha' => 'alpha', 'beta' => 'beta', 'stable' => 'stable'))),
      'readme'              => new sfWidgetFormTextarea(),
      'dependencies'        => new sfWidgetFormInputText(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
      'position'            => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'plugin_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Plugin'))),
      'version'             => new sfValidatorString(array('max_length' => 10, 'required' => false)),
      'date'                => new sfValidatorDateTime(array('required' => false)),
      'symfony_version_min' => new sfValidatorNumber(array('required' => false)),
      'symfony_version_max' => new sfValidatorNumber(array('required' => false)),
      'summary'             => new sfValidatorString(array('required' => false)),
      'stability'           => new sfValidatorChoice(array('choices' => array(0 => 'alpha', 1 => 'beta', 2 => 'stable'), 'required' => false)),
      'readme'              => new sfValidatorString(array('required' => false)),
      'dependencies'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
      'position'            => new sfValidatorInteger(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PluginRelease', 'column' => array('position', 'plugin_id')))
    );

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
