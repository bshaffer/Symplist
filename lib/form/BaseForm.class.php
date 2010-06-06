<?php

/**
 * Base project form.
 * 
 * @package    plugintracker
 * @subpackage form
 * @author     Your name here 
 * @version    SVN: $Id: BaseForm.class.php 20147 2009-07-13 11:46:57Z FabianLange $
 */
class BaseForm extends sfFormSymfony
{
  public function mergeWidgets($widgets)
  {
    foreach ($widgets as $name => $widget) 
    {
      $this->widgetSchema[$name] = $widget;
    }
  }
  
  public function mergeValidators($validator)
  {
    foreach ($validator as $name => $validator) 
    {
      $this->validatorSchema[$name] = $validator;
    }
  }
}
