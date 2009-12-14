<?php
class Doctrine_Template_Attachable extends Doctrine_Template
{
  protected $_options = array('types' => array());

  /**
   * Constructor for Attachable Template
   *
   * @param array $options 
   * @return void
   * @author Brent Shaffer
   */
  public function __construct(array $options = array())
  {
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
  }

  public function setup()
  {
  }


  public function setTableDefinition()
  {
     $this->addListener(new Doctrine_Template_Listener_Attachable());
  }

  public function getAttachmentsQuery()
  {
    $object = $this->getInvoker();
    $query = Doctrine_Core::getTable('Attachment')->createQuery();
    $query->addWhere('Attachment.object_class = ?', get_class($object))
          ->addWhere('Attachment.object_id = ?', $object->getId());
          
    return $query;
  }
  public function getAttachments()
  {
    $object = $this->getInvoker();
    return $object->getAttachmentsQuery()->execute();
  }
  public function setAttachments($attachments)
  {
    foreach ($attachments as $attachment) 
    {
      $this->addAttachment($attachment);
    }
  }
  public function hasAttachments()
  {
    return ($this->getAttachmentsQuery()->count() > 0);
  }
  public function hasAttachmentsOfType($type)
  {
    return ($this->getAttachmentsByTypeQuery($type)->count() > 0);
  }
  public function addAttachment($attachment)
  {
    $object = $this->getInvoker();
    $attachment->setObjectClass(get_class($object));
    if(!$object['id'])
    {
      $object->save();
    }
    $attachment->setObjectId($object->getId());
    $attachment->save();  
  }
  
  public function getAttachmentsByTypeQuery($type)
  {
    return Doctrine_Core::getTable('Attachment')
                  ->createQuery()
                  ->where('object_class = ?', get_class($this->getInvoker()))
                  ->andWhere('object_id = ?', $this->getInvoker()->getId())
                  ->andWhere('type = ?', strtolower($type));
  }
  
  public function getAttachmentsByType($type)
  {
    if(in_array($type, $this->_options['types']))
    {
      return $this->getAttachmentsByTypeQuery($type)
                  ->execute();
    }     
    $table = strtolower($type) == 'other' ? 'Attachment' : sfInflector::classify($type.'_attachment');
    return new Doctrine_Collection($table);
  }
  public function getSupportedAttachmentTypes()
  {
    return $this->getAttachableConfig('types');
  }
  public function getAttachableConfig($index = null)
  {
    if($index)
    {
      return $this->_options[$index];
    }
    return $this->_options;
  }
  public function getVideoAttachments()
  {
    return $this->getAttachmentsByType('Video');
  }
  public function getImageAttachments()
  {
    return $this->getAttachmentsByType('Image');
  }
  public function getDocumentAttachments()
  {
    return $this->getAttachmentsByType('Document');
  }
  public function getOtherAttachments()
  {
    return $this->getAttachmentsByType('Other');
  }
  public function getModelAttachments()
  {
    return $this->getAttachmentsByType('Model');
  }

  // This method only works if "Attachable" is added as the final behavior!
  // public function __call($method, $arguments)
  // {
  //   foreach ($this->_options['types'] as $type) 
  //   {
  //     if(sfInflector::camelize('get_'.$type.'_attachments') == $method)
  //     {
  //       return $this->getAttachmentsByType($type);
  //     }
  //   }
  //   throw new Exception("Method $method not found");
  // }
}
