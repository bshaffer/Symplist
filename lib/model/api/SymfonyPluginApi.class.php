<?php

/**
* Loads Symfony Plugins API data into a SimpleXML object
*/
class SymfonyPluginApi
{
  static protected $_root_url = "http://www.symfony-project.org/plugins/api/1.0/",
                   $_api_key  = "e1afc1bd3ccff394d1cb90565c91c5c3",
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
  
  public function getPlugin($plugin)
  {
    $xml = self::loadFile("plugins/$plugin.xml");
    return $xml;
  }
  
  public function getPluginRelease($plugin, $release)
  {
    // ex: $plugin = sfFakePlugin, $release = 1.0.0
    $xml = self::loadFile("plugins/$plugin/releases/$release.xml");
    return $xml;
  }
  
  public function getDeveloper($developer)
  {
    $xml = self::loadFile("developers/$developer.xml");
    return $xml;
  }
  
  static public function loadFile($path, $silent = false)
  {
    $cmd = "curl -u ".self::$_api_key.":".self::$_password." ".self::$_root_url.$path.($silent?" --silent":'');
    return simplexml_load_string(shell_exec($cmd)); 
  }
}
