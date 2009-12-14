<?php

/**
 * PluginVideoAttachment form.
 *
 * @package    form
 * @subpackage VideoAttachment
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
abstract class PluginVideoAttachmentForm extends AttachmentForm
{
  public function setUp()
  {
    $this->getObject()->setType('video');
    parent::setUp();
  }
}