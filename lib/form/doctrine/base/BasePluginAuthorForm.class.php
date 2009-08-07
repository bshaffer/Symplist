<?php

/**
 * PluginAuthor form base class.
 *
 * @package    form
 * @subpackage plugin_author
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BasePluginAuthorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'first_name'       => new sfWidgetFormInput(),
      'last_name'        => new sfWidgetFormInput(),
      'email'            => new sfWidgetFormInput(),
      'sf_guard_user_id' => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => 'PluginAuthor', 'column' => 'id', 'required' => false)),
      'first_name'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'last_name'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'sf_guard_user_id' => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('plugin_author[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'PluginAuthor';
  }

}
