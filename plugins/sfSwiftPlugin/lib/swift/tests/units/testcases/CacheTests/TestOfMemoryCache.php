<?php

/**
 * Swift Mailer Memory Cache Test Case.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMemoryCache extends AbstractTestOfCache
{
  public function getCache()
  {
    $cache = new Swift_Cache_Memory();
    return $cache;
  }
}
