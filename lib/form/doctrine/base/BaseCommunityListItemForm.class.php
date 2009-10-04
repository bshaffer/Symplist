<?php

/**
 * CommunityListItem form base class.
 *
 * @package    form
 * @subpackage community_list_item
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 8508 2008-04-17 17:39:15Z fabien $
 */
class BaseCommunityListItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'title'        => new sfWidgetFormInput(),
      'body'         => new sfWidgetFormTextarea(),
      'list_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CommunityList', 'add_empty' => true)),
      'score'        => new sfWidgetFormInput(),
      'count'        => new sfWidgetFormInput(),
      'submitted_by' => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => 'CommunityListItem', 'column' => 'id', 'required' => false)),
      'title'        => new sfValidatorString(array('max_length' => 255)),
      'body'         => new sfValidatorString(array('required' => false)),
      'list_id'      => new sfValidatorDoctrineChoice(array('model' => 'CommunityList', 'required' => false)),
      'score'        => new sfValidatorInteger(array('required' => false)),
      'count'        => new sfValidatorInteger(array('required' => false)),
      'submitted_by' => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'created_at'   => new sfValidatorDateTime(array('required' => false)),
      'updated_at'   => new sfValidatorDateTime(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('community_list_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityListItem';
  }

}
