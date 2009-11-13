<?php

/**
 * Comment form base class.
 *
 * @method Comment getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseCommentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'body'                  => new sfWidgetFormTextarea(),
      'approved'              => new sfWidgetFormInputCheckbox(),
      'approved_at'           => new sfWidgetFormDateTime(),
      'user_id'               => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Commenter'), 'add_empty' => true)),
      'authenticated_user_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AuthenticatedUser'), 'add_empty' => true)),
      'root_id'               => new sfWidgetFormInputText(),
      'lft'                   => new sfWidgetFormInputText(),
      'rgt'                   => new sfWidgetFormInputText(),
      'level'                 => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'body'                  => new sfValidatorString(array('required' => false)),
      'approved'              => new sfValidatorBoolean(array('required' => false)),
      'approved_at'           => new sfValidatorDateTime(array('required' => false)),
      'user_id'               => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Commenter'), 'required' => false)),
      'authenticated_user_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AuthenticatedUser'), 'required' => false)),
      'root_id'               => new sfValidatorInteger(array('required' => false)),
      'lft'                   => new sfValidatorInteger(array('required' => false)),
      'rgt'                   => new sfValidatorInteger(array('required' => false)),
      'level'                 => new sfValidatorInteger(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('comment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Comment';
  }

}
