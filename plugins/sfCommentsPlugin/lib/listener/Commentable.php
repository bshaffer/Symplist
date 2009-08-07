<?php

// 
//  Commentable.php
//  csDoctrineActAsCommentablePlugin
//  
//  Created by Brent Shaffer on 2008-12-22.
//  Copyright 2008 Centre{source}. All rights reserved.
// 

class Doctrine_Template_Listener_Commentable extends Doctrine_Record_Listener
{
  /**
   * Array of Commentable options
   */  
  protected $_options = array();


  /**
   * Constructor for Commentable Template
   *
   * @param array $options 
   * @return void
   * @author Brent Shaffer
   */  
  public function __construct(array $options)
  {
    $this->_options = $options;
  }


  /**
   * Set the position value automatically when a new Commentable object is created
   *
   * @param Doctrine_Event $event
   * @return void
   * @author Brent Shaffer
   */
  public function preInsert(Doctrine_Event $event)
  {
    $object = $event->getInvoker();
  }

  
  /**
   * When a Commentable object is deleted, promote all objects positioned lower than itself
   *
   * @param string $Doctrine_Event 
   * @return void
   * @author Brent Shaffer
   */  
  public function postDelete(Doctrine_Event $event)
  {
    $object = $event->getInvoker();
  }  
}
