<?php

// 
//  ContentCoupled.php
//  
//  Created by Brent Shaffer on 2008-12-22.
//  Copyright 2008 Centre{source}. All rights reserved.
// 

class Doctrine_Template_ContentCoupled extends Doctrine_Template
{    
  /**
   * Array of options
   */  
  protected $_options = array('content'  =>  array(
                                  'name'          =>  'cs_content_id',
                                  'alias'         =>  null,
                                  'foreignAlias'  =>  'csNavigation',
                                  'type'          =>  'integer',
                                  'length'        =>  8,
                                  'model'         => array(
                                      'class'        => 'csContent',
                                      'alias'        => 'Content',
                                      'foreignAlias' => 'Navigation',
                                   ),
                                  'options'       =>  array())
    );


  /**
   * Constructor for Sortable Template
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
    $content = $this->_options['content'];
    if($model = $content['model'])
    {
      $name = $model['alias'] ? $model['class'] . ' as ' . $model['alias'] : $model['class'];
      $this->hasOne($name, array(
                              'local'         => $content['name'],
                              'foreignAlias'  => $model['foreignAlias'],
                              'foreignType'   => 'one',
                              'foreign'       => 'id')
                          );
    }
  }


  /**
   * Set table definition for behavior
   *
   * @return void
   * @author Brent Shaffer
   */
  public function setTableDefinition()
  {
    $content = $this->_options['content'];
    $name = $content['name'];
    
    if ($content['alias'])
    {
      $name .= ' as ' . $content['alias'];
    }

    $this->hasColumn($name, $content['type'], $content['length'], $content['options']);

    $this->addListener(new Doctrine_Template_Listener_ContentCoupled($this->_options));
  }


  public function getRelatedClassesArray()
  {
    $relations = array();

    foreach ($this->getInvoker()->getTable()->getRelations() as $rel)
    {
      $componentName = $rel->getTable()->getComponentName();
      $relations[] = $componentName;
    }

    return $relations;
  }


  public function getParentRelations()
  {
    $parents = array();

    foreach ($this->getInvoker()->getTable()->getRelations() as $rel)
    {
      if ($rel->isOwningSide())
      {
        $parents[] = $rel;
      }
    }
    
    return $parents;
  }

  public function setFormTableProxy(&$form)
  {
    unset($form[$this->_options['content']['name']]);
    if(!$form->getObject()->getLocked())
    {
      if(class_exists('NavigationContentForm'))
      {
        $form->embedForm('content', new NavigationContentForm($form->getObject()->getContent()));
      }
    }
    
    return $form;
  }

}
