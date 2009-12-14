<?php

/**
 * CustomAttachment form base class.
 *
 * @method CustomAttachment getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseCustomAttachmentForm extends AttachmentForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('custom_attachment[%s]');
  }

  public function getModelName()
  {
    return 'CustomAttachment';
  }

}
