<?php

/**
 * Swift Mailer Unit Test for The Bandwidth Monitor Plugin.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

if (!class_exists("FullMockConnection")) Mock::Generate("DummyConnection", "FullMockConnection");

/**
 * Swift Mailer Unit Test for The Bandwidth Monitor Plugin.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfBandwidthMonitorPlugin extends UnitTestCase
{
  /**
   * Checks that the readings for bytes coming into the local machine are accurate from Swift point of view.
   */
  public function testBytesInIsAccurate()
  {
    $conn = new FullMockConnection();
    //7 chars + 2 for EOL
    $conn->setReturnValueAt(0, "read", "250 foo");
    //15 chars + 2 for EOL
    $conn->setReturnValueAt(1, "read", "221 bye for now");
    
    $swift = new Swift($conn, null, Swift::NO_START);
    
    $plugin = new Swift_Plugin_BandwidthMonitor();
    
    $swift->attachPlugin($plugin, "bwmon");
    
    //20 chars + 2 for EOL
    $swift->command("abcdefghijklm 123456");
    //3 chars + 2 for EOL
    $swift->command("bar");
    
    $this->assertEqual(26, $plugin->getBytesIn());
  }
  /**
   * Checks that the readings for bytes going out of the local machine are accurate from Swift point of view.
   */
  public function testBytesOutIsAccurate()
  {
    $conn = new FullMockConnection();
    //7 chars + 2 for EOL
    $conn->setReturnValueAt(0, "read", "250 foo");
    //15 chars + 2 for EOL
    $conn->setReturnValueAt(1, "read", "221 bye for now");
    
    $swift = new Swift($conn, null, Swift::NO_START);
    
    $plugin = new Swift_Plugin_BandwidthMonitor();
    
    $swift->attachPlugin($plugin, "bwmon");
    
    //20 chars + 2 for EOL
    $swift->command("abcdefghijklm 123456");
    //3 chars + 2 for EOL
    $swift->command("bar");
    
    $this->assertEqual(27, $plugin->getBytesOut());
  }
  /**
   * When the expected code is set to -1 were sending a literal chunk of data (not a full command).
   * Therefore EOL \r\n won't be included.
   */
  public function testBytesOutDoesNotAddEOLOverheadIfCodeIsMinusOne()
  {
    $conn = new FullMockConnection();
    
    $conn->setReturnValue("read", "250 foo");
    
    $swift = new Swift($conn, null, Swift::NO_START);
    
    $plugin = new Swift_Plugin_BandwidthMonitor();
    
    $swift->attachPlugin($plugin, "bwmon");
    
    //Just 3 chars, no EOL
    $swift->command("foo", -1);
    
    $this->assertEqual(3, $plugin->getBytesOut());
  }
  /**
   * The counters should be settable through setBytesIn() and setBytesOut().
   */
  public function testBytesCanBeReset()
  {
    $conn = new FullMockConnection();
    //7 chars + 2 for EOL
    $conn->setReturnValueAt(0, "read", "250 foo");
    //15 chars + 2 for EOL
    $conn->setReturnValueAt(1, "read", "221 bye for now");
    
    $swift = new Swift($conn, null, Swift::NO_START);
    
    $plugin = new Swift_Plugin_BandwidthMonitor();
    
    $swift->attachPlugin($plugin, "bwmon");
    
    //20 chars + 2 for EOL
    $swift->command("abcdefghijklm 123456");
    
    $this->assertEqual(22, $plugin->getBytesOut());
    $this->assertEqual(9, $plugin->getBytesIn());
    
    $plugin->setBytesOut(0);
    
    $this->assertEqual(0, $plugin->getBytesOut());
    
    //3 chars + 2 for EOL
    $swift->command("bar");
    
    $this->assertEqual(5, $plugin->getBytesOut());
    $this->assertEqual(26, $plugin->getBytesIn());
    
    $plugin->setBytesIn(0);
    
    $this->assertEqual(0, $plugin->getBytesIn());
  }
}
