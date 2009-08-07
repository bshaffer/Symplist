<?php

/**
 * Swift Mailer Abstract class for testing cache classes.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
 

/**
 * Swift Mailer Abstract class for testing cache classes.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
abstract class AbstractTestOfCache extends UnitTestCase
{
  /**
   * The factory method to get the cache object which subclasses must implement.
   * @returns Swift_Cache
   */
  abstract public function getCache();
  /**
   * Basic test to make sure data comes back from the cache in the same state it goes in.
   */
  public function testDataWrittenToCacheIsRetreivable()
  {
    $cache = $this->getCache();
    $testdata = "abc123";
    $cache->write("test", $testdata);
    $ret = "";
    while(false !== $bytes = $cache->read("test"))
      $ret .= $bytes;
    $this->assertEqual($testdata, $ret);
    
    $testdata = "Happy Go Lucky";
    $cache->write("test2", $testdata);
    $ret = "";
    while(false !== $bytes = $cache->read("test2"))
      $ret .= $bytes;
    $this->assertEqual($testdata, $ret);
  }
  /**
   * Makes sure the cache is honest about what's stored in it.
   */
  public function testCacheOnlyReportsToHaveCachedData()
  {
    $cache = $this->getCache();
    $testdata = "abc123";
    $cache->write("test", $testdata);
    $this->assertTrue($cache->has("test"));
    
    $testdata = "Happy Go Lucky";
    $cache->write("test2", $testdata);
    $this->assertTrue($cache->has("test2"));
    
    $this->assertFalse($cache->has("foobar"));
    
    $cache->write("foobar", "abc");
    $this->assertTrue($cache->has("foobar"));
  }
  /**
   * Make sure data can be streamed into the cache.
   */
  public function testPutIsABuffer()
  {
    $cache = $this->getCache();
    $cache->write("test", "abc");
    $ret = "";
    while (false !== $bytes = $cache->read("test"))
      $ret .= $bytes;
    $this->assertEqual("abc", $ret);
    $cache->write("test", "def");
    $ret = "";
    while (false !== $bytes = $cache->read("test"))
      $ret .= $bytes;
    $this->assertEqual("abcdef", $ret);
    $cache->write("test", "123");
    $ret = "";
    while (false !== $bytes = $cache->read("test"))
      $ret .= $bytes;
    $this->assertEqual("abcdef123", $ret);
    
  }
  /**
   * Make sure data can be cleaned out of the cache.
   */
  public function testCacheKeyCanBeCleared()
  {
    $cache = $this->getCache();
    $cache->write("test", "abc");
    $this->assertTrue($cache->has("test"));
    $cache->clear("test");
    $this->assertFalse($cache->has("test"));
  }
  /**
   * Make sure the cache is returning an output stream that can be read like the cache.
   */
  public function testReturnedOutputStreamIsJustAWrapper()
  {
    $cache = $this->getCache();
    $cache->write("test", "abcdefghijklmnopqrstuvwxyz");
    $os = $cache->getOutputStream("test");
    $ret = "";
    while (false !== $bytes = $os->read())
      $ret .= $bytes;
    $this->assertEqual("abcdefghijklmnopqrstuvwxyz", $ret);
  }
}
