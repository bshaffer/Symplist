<?php

/**
* 
*/
class csNavigationCollectionManager extends Doctrine_Collection
{
  public function __construct($table = 'csNavigationMenu', $keyColumn = null)
  {
    return parent::__construct($table, $keyColumn = null);
  }

  public function toArray($deep = false, $prefixKey = false)
  {
    $arr = array();
    foreach ($this as $item) 
    {
      $arr[] = $item->toArray();
    }
    return $arr;
  }
}
