<?php

/**
 * Upload form.
 *
 * @package    form
 * @subpackage Upload
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class BackendAttachmentsForm extends sfForm
{
  public function configure()
  {
    foreach ($this->getOption('attachments') as $attachment) {
      $attachmentsForm = new AttachmentForm($attachment);
      $this->embedForm($attachment->id, $attachmentsForm);
    }
  }
}