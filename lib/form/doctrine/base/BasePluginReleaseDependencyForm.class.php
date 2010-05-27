<?php

/**
 * PluginReleaseDependency form base class.
 *
 * @method PluginReleaseDependency getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePluginReleaseDependencyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'release_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Release'), 'add_empty' => false)),
      'dependency_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Dependency'), 'add_empty' => false)),
      'dependency_version_min' => new sfWidgetFormInputText(),
      'dependency_version_max' => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'release_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Release'))),
      'dependency_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Dependency'))),
      'dependency_version_min' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'dependency_version_max' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('plugin_release_dependency[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginReleaseDependency';
  }

}
