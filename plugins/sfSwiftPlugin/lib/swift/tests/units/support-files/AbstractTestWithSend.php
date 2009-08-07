<?php

/**
 * SwiftMailer Unit Testing Component.
 * Provides a testcase with functionality to get a Working Mock Connection.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

Mock::Generate("Swift_Connection", "FullMockConnection");

/**
 * SwiftMailer Abstract test with sending capabilities.
 * Provides a testcase with functionality to get a Working Mock Connection.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
abstract class AbstractTestWithSend extends UnitTestCase
{
  /**
   * Get a mock connection for testing.
   * The mock will be set up to send to X addresses (sccuessfully).
   * The mock can also be configured to reconnect after X emails have been sent.
   * @param int The number emails you expect to send
   * @param Swift_Connection A mocked object which has not been setup yet, optional
   * @param int The number of emails to send before reconnecting, optional
   * @param int The maximum number of times the connection will re-connect, optional
   * @param boolean True if the same email is copied to all recipients
   * @return FullMockConnection
   */
  protected function getWorkingMockConnection($send=1, $conn=null, $reconnect_at=0, $max_reconnect=0, $duplicate=false)
  {
    $count = 0;
    if (!$conn) $conn = new FullMockConnection();
    $conn->setReturnValueAt($count++, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt($count++, "read", "250-Hello xxx\r\n250-AUTH PLAIN\r\n250 HELP");
    $cycle = 0;
    $reconnected = 0;
    for ($i = 0; $i < $send; $i++)
    {
      $conn->setReturnValueAt($count++, "read", "250 Ok");
      if (!$duplicate || ($i == $send-1))
      {
        $cycle++;
        $conn->setReturnValueAt($count++, "read", "250 Ok");
        $conn->setReturnValueAt($count++, "read", "354 Go ahead");
        $conn->setReturnValueAt($count++, "read", "250 Ok");
      }
      if ($reconnect_at && $reconnect_at == $cycle)
      {
        if (!$max_reconnect || $max_reconnect > $reconnected)
        {
          $conn->setReturnValueAt($count++, "read", "220 xxx ESMTP");
          $conn->setReturnValueAt($count++, "read", "250-Hello xxx\r\n250 HELP");
          $cycle = 0;
          $reconnected++;
        }
      }
    }
    $conn->setReturnValue("read", "250 ok");
    $conn->setReturnValue("isAlive", true);
    return $conn;
  }
}
