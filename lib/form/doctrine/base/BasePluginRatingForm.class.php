<?php

/**
 * PluginRating form base class.
 *
 * @package    form
 * @subpackage plugin_rating
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasePluginRatingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'symfony_plugin_id' => new sfWidgetFormDoctrineChoice(array('model' => 'SymfonyPlugin', 'add_empty' => true)),
      'sf_guard_user_id'  => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'rating'            => new sfWidgetFormInput(),
      'created_at'        => new sfWidgetFormDateTime(),
      'updated_at'        => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorDoctrineChoice(array('model' => 'PluginRating', 'column' => 'id', 'required' => false)),
      'symfony_plugin_id' => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPlugin', 'required' => false)),
      'sf_guard_user_id'  => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'rating'            => new sfValidatorInteger(array('required' => false)),
      'created_at'        => new sfValidatorDateTime(array('required' => false)),
      'updated_at'        => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plugin_rating[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginRating';
  }

}
