<?php

/**
 * CommunityListItem form base class.
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id$
 */
class BaseCommunityListItemForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'title'        => new sfWidgetFormInputText(),
      'body'         => new sfWidgetFormTextarea(),
      'list_id'      => new sfWidgetFormDoctrineChoice(array('model' => 'CommunityList', 'add_empty' => true)),
      'score'        => new sfWidgetFormInputText(),
      'count'        => new sfWidgetFormInputText(),
      'submitted_by' => new sfWidgetFormDoctrineChoice(array('model' => 'sfGuardUser', 'add_empty' => true)),
      'created_at'   => new sfWidgetFormDateTime(),
      'updated_at'   => new sfWidgetFormDateTime(),
      'body_html'    => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => 'CommunityListItem', 'column' => 'id', 'required' => false)),
      'title'        => new sfValidatorString(array('max_length' => 255)),
      'body'         => new sfValidatorString(array('required' => false)),
      'list_id'      => new sfValidatorDoctrineChoice(array('model' => 'CommunityList', 'required' => false)),
      'score'        => new sfValidatorInteger(array('required' => false)),
      'count'        => new sfValidatorInteger(array('required' => false)),
      'submitted_by' => new sfValidatorDoctrineChoice(array('model' => 'sfGuardUser', 'required' => false)),
      'created_at'   => new sfValidatorDateTime(),
      'updated_at'   => new sfValidatorDateTime(),
      'body_html'    => new sfValidatorString(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('community_list_item[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityListItem';
  }

}
