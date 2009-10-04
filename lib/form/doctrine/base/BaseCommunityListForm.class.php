<?php

/**
 * CommunityList form base class.
 *
 * @package    form
 * @subpackage community_list
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCommunityListForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'title'            => new sfWidgetFormInput(),
      'description'      => new sfWidgetFormInput(),
      'featured'         => new sfWidgetFormInputCheckbox(),
      'submitted_by'     => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'slug'             => new sfWidgetFormInput(),
      'description_html' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => 'CommunityList', 'column' => 'id', 'required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255)),
      'description'      => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'featured'         => new sfValidatorBoolean(array('required' => false)),
      'submitted_by'     => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'created_at'       => new sfValidatorDateTime(array('required' => false)),
      'updated_at'       => new sfValidatorDateTime(array('required' => false)),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description_html' => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('community_list[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityList';
  }

}
