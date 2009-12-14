<?php

/*
 * This file is part of the symfony package.
 * (c) 2004-2006 Fabien Potencier <fabien.potencier@symfony-project.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 *
 * @package    csDoctrineActAsAttachablePlugin
 * @subpackage module
 * @author     Gordon Franke <gfranke@nevalon.de>
 * @version    SVN: $Id: BasecsAttachableComponents.class.php 25145 2009-12-09 18:10:42Z gimler $
 */
class BasecsAttachableComponents extends sfComponents
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeAttachments()
  {
    // Get New Attachment Form
    $object = $this->form ? $this->form->getObject() : $this->object;
    $this->table = isset($this->table) ? $this->table : get_class($this->form->getObject());
    $this->types = $object->getSupportedAttachmentTypes();

    if ($this->types)
    {
      foreach ($this->types as $type) {
        $this->setAttachmentType($type, $object);
      }
    }
    else
    {
      $this->attachment = new AttachmentForm(null, $object);
      unset($this->attachment['id']);

      // If the object is set, get the attachment forms for the object
      if ($object)
      {
        $this->attachments = new BackendAttachmentsForm(array(), array('attachments' => $object->getAttachments()));
      }
    }

    if ($object)
    {
      $newForm = $this->table.'Form';
      $this->form = new $newForm($object);
    }

    // Javascript Helper (Protoculous or jQuery)
    $this->javascriptHelper = isset($this->javascriptHelper) && $this->javascriptHelper == 'jQuery' ? 'jQuery' : 'Javascript';
  }

  public function setAttachmentType($type, $object)
  {
    $prefix = strtolower($type) == 'other' ? '' : $type;
    $form_class = $prefix . 'AttachmentForm';
    $table_name = $prefix .'AttachmentTable';
    $type_form = $type.'_form';
    $form = new $form_class(null, $object);

    unset($form['id']);

    $this->$type_form = $form;

    // If the object is set, get the attachment forms for the object
    if ($object)
    {
      // $object = Doctrine_Core::getTable($this->table)->findOneById($this->objectId);
      $this->$type = new BackendAttachmentsForm(array(), array('attachments' => $object->getAttachmentsByType($type)));
    }
  }

  public function executeAttachments_group()
  {
  }

  public function executeAttachments_list()
  {
  }
}