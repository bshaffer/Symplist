<?php

/**
 * Swift Mailer Disk Cache Test Case.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfDiskCache extends AbstractTestOfCache
{
  /**
   * Get rid of anything already in the cache dir.
   */
  public function setUp()
  {
    $list = glob(TestConfiguration::WRITABLE_PATH . "/*");
    foreach ((array)$list as $f)
    {
      if (!is_dir($f)) @unlink($f);
    }
  }
  
  public function getCache()
  {
    Swift_Cache_Disk::setSavePath(TestConfiguration::WRITABLE_PATH);
    $cache = new Swift_Cache_Disk();
    return $cache;
  }
}
