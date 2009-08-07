<?php

/**
 * SymfonyPluginComment form base class.
 *
 * @package    form
 * @subpackage symfony_plugin_comment
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseSymfonyPluginCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'comment_id' => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPluginComment', 'column' => 'id', 'required' => false)),
      'comment_id' => new sfValidatorDoctrineChoice(array('model' => 'SymfonyPluginComment', 'column' => 'comment_id', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('symfony_plugin_comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'SymfonyPluginComment';
  }

}
