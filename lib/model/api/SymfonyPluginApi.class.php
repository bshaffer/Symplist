<?php

/**
* 
*/
class SymfonyPluginApi
{
  static protected $_root_url = "http://www.symfony-project.org/plugins/api/1.0/",
                   $_api_key  = "5beafc386c79e4a705ec84d24e5fab1c",
                   $_password = "x";
  
  static public function getDevelopers()
  {
    $xml = self::loadFile('profile.xml');
    return $xml;
  }
  
  static public function getPlugins()
  {
    $xml = self::loadFile('plugins.xml');
    return $xml;
  }
  
  static public function loadFile($path)
  {
    $cmd = "curl -u ".self::$_api_key.":".self::$_password." ".self::$_root_url."$path";
    return simplexml_load_string(shell_exec($cmd)); 
  }
}
