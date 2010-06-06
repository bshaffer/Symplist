<?php

/**
* 
*/
class sfActionExtra
{
  public static function observeMethodNotFound(sfEvent $event)
  {
    if (method_exists('sfActionExtra', $event['method'])) 
    {
      $args = array_merge(array($event->getSubject()), $event['arguments']);

      return call_user_func_array(array('sfActionExtra', $event['method']), $args);
    }
  }
  
  public static function forward403($action)
  {
    $action->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    
    throw new sfStopException();
  }
  
  public static function forward403Unless($action, $bool)
  {
    if (!$bool) 
    {
      $action->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));

      throw new sfStopException();
    }
    
    return true;
  }
}
