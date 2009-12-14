<?php

/**
 * DocumentAttachment form base class.
 *
 * @method DocumentAttachment getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseDocumentAttachmentForm extends AttachmentForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('document_attachment[%s]');
  }

  public function getModelName()
  {
    return 'DocumentAttachment';
  }

}
