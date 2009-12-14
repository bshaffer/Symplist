<?php

/**
 * PluginAttachment form.
 *
 * @package    form
 * @subpackage Attachment
 */
abstract class PluginAttachmentForm extends BaseAttachmentForm
{
  protected $_relatedObject;
  protected $_button = 'Upload';

  public function __construct($object = null, $relatedObject = null)
  {
    $this->_relatedObject = $relatedObject ? $relatedObject : $object->getObject();

    return parent::__construct($object);
  }

  public function getRelatedObject()
  {
    return $this->_relatedObject;
  }

  public function getObjectClass()
  {
    return get_class($this->_relatedObject);
  }

  public function getObjectId()
  {
    return $this->_relatedObject->getId();
  }

  public function prepare(array $params = array())
  {
    foreach ($params as $key => $value) 
    {
      $this->$key = $value;
    }
  }

  public function setUp()
  {
    parent::setUp();

    unset($this['description']);

    $this->setWidget('url',           new sfWidgetFormInputFile(array(),   array()));
    $this->setWidget('type',          new sfWidgetFormInputHidden(array(), array()));
    $this->setWidget('title',         new sfWidgetFormInputHidden(array(), array()));
    $this->setWidget('object_id',     new sfWidgetFormInputHidden(array(), array()));
    $this->setWidget('object_class',  new sfWidgetFormInputHidden(array(), array()));
    $this->setDefault('object_class', $this->getObjectClass());
    $this->setDefault('object_id',    $this->getObjectId());

    $uploadpath = isset($this->uploadpath) ? $this->uploadpath : sfConfig::get('sf_upload_dir') . DIRECTORY_SEPARATOR . strtolower($this->getObjectClass());
    $mimetypes  = isset($this->mimetypes) ? $this->mimetypes : null;

    $this->widgetSchema->setLabels(array('url' => 'File'));
    $this->setValidators(array(
        'object_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getObjectClass(), 'required' => false)),
        'object_class'   => new sfValidatorString(),
        'type'           => new sfValidatorString(),
        'title'          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
        'url'            => new sfValidatorFile(array('required'   => false,
                                                      'max_size'   => 2048000,
                                                      'mime_types' => $mimetypes,
                                                      'path'       => $uploadpath))));
  }

  public function setObjectClass($class)
  {
    $this->setValidator('url', new sfValidatorFile(array('required' => false,
                                                         'max_size' => 2048000,
                                                         'path'     => 'uploads/' . $class)));

    $this->setDefault('object_class', $class);
  }

  public function setObjectId($id)
  {
    $this->setDefault('object_id', $id);
  }

  public function getErrorList()
  {
    $errors = array();

    if($this->hasGlobalErrors())
    {
      $errors[] = $this->getGlobalErrors();
    }

    foreach ($this->validatorSchema->getFields() as $key => $value) 
    {
      if($this[$key]->hasError())
      {
        $errors[$key] = $this[$key]->getError();
      }
    }

    return $errors;
  }

  public function setButton($text)
  {
    $this->_button = $text;
  }

  public function getButton()
  {
    return $this->_button;
  }
}
