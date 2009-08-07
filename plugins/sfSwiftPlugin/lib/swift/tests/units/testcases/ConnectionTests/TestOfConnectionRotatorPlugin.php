<?php

/**
 * SwiftMailer Unit Test For the ConnectionRotator plugin.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

/**
 * SwiftMailer Unit Test For the ConnectionRotator plugin.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfConnectionRotatorPlugin extends AbstractTestWithSend
{
  /**
   * Test that the connection is switched when emails are sent.
   */
  public function testPluginInvokesTheNextConnectionMethod()
  {
    $plugin = new Swift_Plugin_ConnectionRotator();
    $conn = $this->getWorkingMockConnection(5, new MockRotatorConnection(), 1);
    $conn->expectCallCount("nextConnection", 5);
    $conn->setReturnValueAt(0, "getActive", 0);
    $conn->setReturnValueAt(1, "getActive", 1);
    $conn->setReturnValueAt(2, "getActive", 2);
    $conn->setReturnValueAt(3, "getActive", 3);
    $conn->setReturnValueAt(4, "getActive", 4);
    
    $swift = new Swift($conn);
    $swift->attachPlugin(new Swift_Plugin_ConnectionRotator(1), "foo");
    
    for ($i = 0; $i < 5; $i++)
    {
      $swift->send(new Swift_Message("subject", "body"), new Swift_Address("foo@bar.tld"), new Swift_Address("zip@button.com"));
    }
  }
  /**
   * Test that the number of emails (threshold) can be set.
   */
  public function testThresholdIsHonouredBeforeRotating()
  {
    $plugin = new Swift_Plugin_ConnectionRotator();
    $conn = $this->getWorkingMockConnection(20, new MockRotatorConnection(), 6, 2);
    $conn->expectCallCount("nextConnection", 3);
    $conn->setReturnValueAt(0, "getActive", 0);
    $conn->setReturnValueAt(1, "getActive", 1);
    $conn->setReturnValueAt(2, "getActive", 2);
    
    $swift = new Swift($conn);
    $swift->attachPlugin(new Swift_Plugin_ConnectionRotator(6), "foo");
    
    for ($i = 0; $i < 20; $i++)
    {
      $swift->send(new Swift_Message("subject", "body"), new Swift_Address("foo@bar.tld"), new Swift_Address("zip@button.com"));
    }
  }
  
  // testAllConnectionsAreClosedWhenDisconnectIsCalled() has been removed.  Already tested in TestOfRotatorConnection
}
