<?php

/**
 * Attachment form base class.
 *
 * @method Attachment getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 24171 2009-11-19 16:37:50Z Kris.Wallsmith $
 */
abstract class BaseAttachmentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'           => new sfWidgetFormInputHidden(),
      'title'        => new sfWidgetFormInputText(),
      'description'  => new sfWidgetFormTextarea(),
      'url'          => new sfWidgetFormInputText(),
      'type'         => new sfWidgetFormChoice(array('choices' => array('image' => 'image', 'video' => 'video', 'audio' => 'audio', 'document' => 'document', 'application' => 'application', 'link' => 'link', 'model' => 'model', 'custom' => 'custom', 'other' => 'other'))),
      'object_id'    => new sfWidgetFormInputText(),
      'object_class' => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'           => new sfValidatorDoctrineChoice(array('model' => $this->getModelName(), 'column' => 'id', 'required' => false)),
      'title'        => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'description'  => new sfValidatorString(array('required' => false)),
      'url'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'type'         => new sfValidatorChoice(array('choices' => array(0 => 'image', 1 => 'video', 2 => 'audio', 3 => 'document', 4 => 'application', 5 => 'link', 6 => 'model', 7 => 'custom', 8 => 'other'), 'required' => false)),
      'object_id'    => new sfValidatorInteger(array('required' => false)),
      'object_class' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attachment[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attachment';
  }

}
