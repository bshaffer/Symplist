<?php

/**
 * CommunityList form base class.
 *
 * @method CommunityList getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCommunityListForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'title'            => new sfWidgetFormInputText(),
      'description'      => new sfWidgetFormTextarea(),
      'featured'         => new sfWidgetFormInputCheckbox(),
      'submitted_by'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('User'), 'add_empty' => false)),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
      'slug'             => new sfWidgetFormInputText(),
      'description_html' => new sfWidgetFormTextarea(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'title'            => new sfValidatorString(array('max_length' => 255)),
      'description'      => new sfValidatorString(array('required' => false)),
      'featured'         => new sfValidatorBoolean(array('required' => false)),
      'submitted_by'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('User'))),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
      'slug'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description_html' => new sfValidatorString(array('required' => false)),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'CommunityList', 'column' => array('slug')))
    );

    $this->widgetSchema->setNameFormat('community_list[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CommunityList';
  }

}
