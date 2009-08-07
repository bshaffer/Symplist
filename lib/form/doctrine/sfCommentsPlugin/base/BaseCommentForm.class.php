<?php

/**
 * Comment form base class.
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
      'id'          => new sfWidgetFormInputHidden(),
      'body'        => new sfWidgetFormTextarea(),
      'approved'    => new sfWidgetFormInputCheckbox(),
      'approved_at' => new sfWidgetFormDateTime(),
      'user_id'     => new sfWidgetFormDoctrineChoice(array('model' => 'Commenter', 'add_empty' => true)),
      'root_id'     => new sfWidgetFormInput(),
      'lft'         => new sfWidgetFormInput(),
      'rgt'         => new sfWidgetFormInput(),
      'level'       => new sfWidgetFormInput(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorDoctrineChoice(array('model' => 'Comment', 'column' => 'id', 'required' => false)),
      'body'        => new sfValidatorString(array('required' => false)),
      'approved'    => new sfValidatorBoolean(array('required' => false)),
      'approved_at' => new sfValidatorDateTime(array('required' => false)),
      'user_id'     => new sfValidatorDoctrineChoice(array('model' => 'Commenter', 'required' => false)),
      'root_id'     => new sfValidatorInteger(array('required' => false)),
      'lft'         => new sfValidatorInteger(array('required' => false)),
      'rgt'         => new sfValidatorInteger(array('required' => false)),
      'level'       => new sfValidatorInteger(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
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
