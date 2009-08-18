<?php

/**
* Inflector Class for Ad Hoc Inflection
*/
class csInflector
{
  static public function indexize($camel_cased_word)
  {
    $tmp = $camel_cased_word;

    $tmp = str_replace('::', '/', $tmp);
    
    $tmp = sfToolkit::pregtr($tmp, array('/([A-Z]+)([A-Z][a-z])/' => '\\1 \\2',
                                         '/([a-z\d])([A-Z])/'     => '\\1 \\2'));
    return strtolower($tmp);
  }
}
