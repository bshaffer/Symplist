<?php

/**
 * PluginReleaseSymfonyApiVersion form base class.
 *
 * @method PluginReleaseSymfonyApiVersion getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BasePluginReleaseSymfonyApiVersionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'release_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Release'), 'add_empty' => false)),
      'api_version_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ApiVersion'), 'add_empty' => false)),
      'created_at'     => new sfWidgetFormDateTime(),
      'updated_at'     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'release_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Release'))),
      'api_version_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ApiVersion'))),
      'created_at'     => new sfValidatorDateTime(),
      'updated_at'     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('plugin_release_symfony_api_version[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginReleaseSymfonyApiVersion';
  }

}
