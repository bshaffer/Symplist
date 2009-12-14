<?php
/**
 * Associates Attachments with Doctrine Objects
 *
 * @package csActAsAttachablePlugin
 * @author Joshua Pruitt
 */
class Doctrine_Template_Listener_Attachable extends Doctrine_Record_Listener
{
  protected $_options = array();

  /**
   * Attachment Saving Logic
   *
   * @return void
   * @author Joshua Pruitt
   */
  public function preSave(Doctrine_Event $event)
  {
    $object = $event->getInvoker();
    
    //If the object is new, and attachments are set, save them
    if(!$object->getId() &&  isset($object['Attachments']))
    {
      foreach ($object['Attachments'] as $attachment) 
      {
        $object->addAttachment(new Attachment($attachment));
      }
    }
  }


  /**
   * Attachment Deletion Logic
   *
   * @param string $Doctrine_Event 
   * @return void
   * @author Joshua Pruitt
   */
  public function preDelete(Doctrine_Event $event)
  {
  }
}