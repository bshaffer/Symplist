<?php

/**
 * Commenter form base class.
 *
 * @package    form
 * @subpackage commenter
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCommenterForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'       => new sfWidgetFormInputHidden(),
      'username' => new sfWidgetFormInput(),
      'email'    => new sfWidgetFormInput(),
      'website'  => new sfWidgetFormInput(),
    ));

    $this->setValidators(array(
      'id'       => new sfValidatorDoctrineChoice(array('model' => 'Commenter', 'column' => 'id', 'required' => false)),
      'username' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'website'  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('commenter[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'Commenter';
  }

}
