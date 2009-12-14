<?php

/**
 * PluginDocumentAttachment form.
 *
 * @package    form
 * @subpackage DocumentAttachment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginDocumentAttachmentForm extends AttachmentForm
{
  public function setUp()
  {
    $this->getObject()->setType('document');
    $this->prepare(array(
      'mimetypes' => array(
        'text/plain',
        'application/msword',
        'application/pdf',                                                
        'application/rtf',
        'text/richtext',
      ),
    ));

    parent::setUp();
  }
}