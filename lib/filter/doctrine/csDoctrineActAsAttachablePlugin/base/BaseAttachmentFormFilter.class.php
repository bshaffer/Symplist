<?php

/**
 * Attachment filter form base class.
 *
 * @package    plugintracker
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAttachmentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'title'        => new sfWidgetFormFilterInput(),
      'description'  => new sfWidgetFormFilterInput(),
      'url'          => new sfWidgetFormFilterInput(),
      'type'         => new sfWidgetFormChoice(array('choices' => array('' => '', 'image' => 'image', 'video' => 'video', 'audio' => 'audio', 'document' => 'document', 'application' => 'application', 'link' => 'link', 'model' => 'model', 'custom' => 'custom', 'other' => 'other'))),
      'object_id'    => new sfWidgetFormFilterInput(),
      'object_class' => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'title'        => new sfValidatorPass(array('required' => false)),
      'description'  => new sfValidatorPass(array('required' => false)),
      'url'          => new sfValidatorPass(array('required' => false)),
      'type'         => new sfValidatorChoice(array('required' => false, 'choices' => array('image' => 'image', 'video' => 'video', 'audio' => 'audio', 'document' => 'document', 'application' => 'application', 'link' => 'link', 'model' => 'model', 'custom' => 'custom', 'other' => 'other'))),
      'object_id'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'object_class' => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('attachment_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Attachment';
  }

  public function getFields()
  {
    return array(
      'id'           => 'Number',
      'title'        => 'Text',
      'description'  => 'Text',
      'url'          => 'Text',
      'type'         => 'Enum',
      'object_id'    => 'Number',
      'object_class' => 'Text',
    );
  }
}
