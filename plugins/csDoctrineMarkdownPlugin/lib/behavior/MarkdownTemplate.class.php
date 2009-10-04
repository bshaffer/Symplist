<?php

// 
//  MarkdownTemplate.class.php
//  
//  Created by Brent Shaffer on 2009-10-03
// 

class Doctrine_Template_Markdown extends Doctrine_Template
{    
  /**
   * Array of default markdown options
   */  
  protected $_options = array(  'fields'  =>  array(), 'options' => array() );


  /**
   * Constructor for Markdown Template
   *
   * @param array $options 
   * @return void
   * @author Brent Shaffer
   */
  public function __construct(array $options = array())
  {  
    if (!isset($options['fields'])) 
    {
      throw new sfException("Required parameter 'fields' not set in Doctrine Markdown");
    }
    
    $this->_options = Doctrine_Lib::arrayDeepMerge($this->_options, $options);
    
    // Set markdown field names if they are not set by the user
    foreach ($this->_options['fields'] as $key => $value) 
    {
      if (is_int($key)) 
      {
        unset($this->_options['fields'][$key]);
        $this->_options['fields'][$value.'_html'] = $value;
      }
    }
  }

  /**
   * Add the database columns to hold the parsed HTML.
   * 
   *
   * @return void
   * @author Brent Shaffer
   */
  public function setTableDefinition()
  { 
    $this->addListener(new Doctrine_Template_Listener_Markdown($this->_options));
    foreach ($this->_options['fields'] as $key => $value) 
    {
      $this->hasColumn($key, 'clob', $this->_options['options']);
    }
  }

}
