<?php

// 
//  ContentCoupled.php
//  
//  Created by Brent Shaffer on 2008-12-22.
//  Copyright 2008 Centre{source}. All rights reserved.
// 

class Doctrine_Template_Listener_ContentCoupled extends Doctrine_Record_Listener
{
  /**
   * Array of options
   */  
  protected $_options = array();


  /**
   * Constructor for ContentCoupled Template
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
   *
   * @param Doctrine_Event $event
   * @return void
   * @author Brent Shaffer
   */
  public function preInsert(Doctrine_Event $event)
  {
  }


  /**
   *
   * @param string $Doctrine_Event 
   * @return void
   * @author Brent Shaffer
   */  
  public function postDelete(Doctrine_Event $event)
  {
  }  
}
