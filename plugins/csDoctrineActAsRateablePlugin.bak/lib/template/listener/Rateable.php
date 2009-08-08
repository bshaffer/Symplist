<?php

// 
//  Sortable.php
//  csDoctrineActAsSortablePlugin
//  
//  Created by Travis Black on 2008-12-22.
//  Copyright 2008 Centre{source}. All rights reserved.
// 

class Doctrine_Template_Listener_Rateable extends Doctrine_Record_Listener
{
  /**
   * Array of sortable options
   */  
  protected $_options = array();


  /**
   * Constructor for Sortable Template
   *
   * @param array $options 
   * @return void
   * @author Travis Black
   */  
  public function __construct(array $options)
  {
    $this->_options = $options;
  }

  

  /**
   * Set the position value automatically when a new sortable object is created
   *
   * @param Doctrine_Event $event
   * @return void
   * @author Travis Black
   */
  public function postSave(Doctrine_Event $event)
  {
    $object = $event->getInvoker();
    
    $added_rating = Doctrine_Template_Rateable::get_rating($object);
    
    foreach ($added_rating as $rated){
      $rating = new rating;
      $rating->setClass(get_class($object));
      $rating->setObjectId($object->getId());
      $rating->setRating($rated);
      $rating->save();
    }
  }


  /**
   * When a sortable object is deleted, promote all objects positioned lower than itself
   *
   * @param string $Doctrine_Event 
   * @return void
   * @author Travis Black
   */  
 public function preDelete(Doctrine_Event $event)
 {
   
     $object = $event->getInvoker();
     
     Doctrine::getTable('Rating')->createQuery()
       ->delete()
       ->addWhere('object_id = ?', $object->id)
       ->addWhere('class = ?', get_class($object))
       ->execute();
 }
}
