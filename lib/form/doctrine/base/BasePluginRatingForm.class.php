<?php

/**
 * PluginRating form base class.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BasePluginRatingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'symfony_plugin_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SymfonyPlugin', 'add_empty' => true)),
      'sf_guard_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'rating'            => new sfWidgetFormInputText(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => 'PluginRating', 'column' => 'id', 'required' => false)),
      'symfony_plugin_id' => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPlugin', 'required' => false)),
      'sf_guard_user_id'  => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'rating'            => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(),
      'updated_at'        => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('plugin_rating[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRating';
  }

}
