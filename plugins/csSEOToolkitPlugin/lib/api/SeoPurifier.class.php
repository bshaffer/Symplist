<?php

/**
 * SeoPurifier
 * Singleton wrapper for HTMLPurifier
 *
 * @package default
 * @author Brent Shaffer
 */
class SeoPurifier
{
  public $config;
  private $purifier;
  private static $instance;
  
  protected function __construct()
  {
    // set_include_path(sfConfig::get('sf_lib_dir') . '/vendor' . PATH_SEPARATOR . get_include_path());
    require_once dirname(__FILE__).'/../vendor/htmlpurifier/HTMLPurifier.includes.php';
    $this->config = HTMLPurifier_Config::createDefault();
    $this->config->set('Cache', 'SerializerPath', sfConfig::get('sf_cache_dir'));
    $this->config->set('HTML', 'Trusted', true);
    $this->purifier = new HTMLPurifier($this->config);
  }
  
  public static function getInstance() {
    if (!self::$instance instanceof self) { 
      self::$instance = new self;
    }
    
    return self::$instance;
  }
  
  public function getPurifier()
  {
    return $this->purifier;
  }
  
  public static function purify($text)
  {
    return self::getInstance()->getPurifier()->purify($text);
  }
  
  public function __clone() {
    throw new sfException('Clone is not allowed.');
  }

  public function __wakeup() {
    throw new sfException('Deserializing is not allowed.');
  }

}
