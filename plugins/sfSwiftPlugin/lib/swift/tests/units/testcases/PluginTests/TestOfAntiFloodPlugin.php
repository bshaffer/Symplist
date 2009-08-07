<?php

/**
 * SwiftMailer Unit Test For the AntiFlood plugin.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

Mock::GeneratePartial("Swift_Plugin_AntiFlood", "MockAntiFloodPlugin", array("wait"));

/**
 * SwiftMailer Unit Test For the AntiFlood plugin.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfAntiFloodPlugin extends AbstractTestWithSend
{
  /**
   * Tests that the connection is actually dropped when it's told to.
   */
  public function testDisconnectIsInvokedAsManyTimesAsNeeded()
  {
    $conn = $this->getWorkingMockConnection(20, null, 5);
    $conn->expectCallCount("stop", 4);
    $conn->expectCallCount("start", 5);
    
    $swift = new Swift($conn);
    $swift->attachPlugin(new Swift_Plugin_AntiFlood(5), "antiflood");
    for ($i = 0; $i < 20; $i++)
    {
      $swift->send(new Swift_Message("foo", "bar"), new Swift_Address("foo@bar.com"), new Swift_Address("foo@bar.com"));
    }
    
    $conn = $this->getWorkingMockConnection(20, null, 15);
    $conn->expectCallCount("stop", 1);
    $conn->expectCallCount("start", 2);
    
    $swift = new Swift($conn);
    $swift->attachPlugin(new Swift_Plugin_AntiFlood(15), "antiflood");
    for ($i = 0; $i < 20; $i++)
    {
      $swift->send(new Swift_Message("foo", "bar"), new Swift_Address("foo@bar.com"), new Swift_Address("foo@bar.com"));
    }
  }
  /**
   * Tests that the sleep() time is used if it's set.
   */
  public function testWaitingTimeIsHonoured()
  {
    $conn = $this->getWorkingMockConnection(20, null, 5);
    
    $swift = new Swift($conn);
    $plugin = new MockAntiFloodPlugin();
    $plugin->setWait(10);
    $plugin->setThreshold(5);
    $plugin->expect("wait", array(10));
    
    $swift->attachPlugin($plugin, "antiflood");
    for ($i = 0; $i < 20; $i++)
    {
      $swift->send(new Swift_Message("foo", "bar"), new Swift_Address("foo@bar.com"), new Swift_Address("foo@bar.com"));
    }
  }
}
