<?php

/**
* 
*/
class sfValidatorVersion extends sfValidatorString
{
  function doClean($value)
  {
    $value = parent::doClean($value);
    
    foreach (explode('.', $value) as $num) 
    {
      if (!is_numeric($num)) 
      {
        throw new sfValidatorError($this, 'invalid', array('version' => $value));
      }
    }
    
    return $value;
  }
}
