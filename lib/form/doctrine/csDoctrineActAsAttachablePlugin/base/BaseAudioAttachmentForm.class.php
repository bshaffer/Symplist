<?php

/**
 * AudioAttachment form base class.
 *
 * @method AudioAttachment getObject() Returns the current form's model object
 *
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedInheritanceTemplate.php 24051 2009-11-16 21:08:08Z Kris.Wallsmith $
 */
abstract class BaseAudioAttachmentForm extends AttachmentForm
{
  protected function setupInheritance()
  {
    parent::setupInheritance();

    $this->widgetSchema->setNameFormat('audio_attachment[%s]');
  }

  public function getModelName()
  {
    return 'AudioAttachment';
  }

}
