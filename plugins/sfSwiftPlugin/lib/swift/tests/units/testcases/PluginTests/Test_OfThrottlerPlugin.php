<?php

///////////////////////////////////////////////////////////////////
/// WARNING!!! THIS TEST IS SUPPOSED TO SLEEP() FOR A LONG TIME ///
///////////////////////////////////////////////////////////////////

class Test_OfThrottlerPlugin extends UnitTestCase
{
  /** Get a mock connection for testing
   * @param int The number emails you expect to send
   * @param boolean If the email will be duplicated to all recipients
   * @return FullMockConnection
   */
  protected function getWorkingMockConnection($send=1, $duplicate=false, $conn=null)
  {
    $count = 0;
    if ($conn === null) $conn = new FullMockConnection();
    $conn->setReturnValue("isAlive", true);
    $conn->setReturnValueAt($count++, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt($count++, "read", "250-Hello xxx\r\n250-AUTH PLAIN\r\n250 HELP");
    for ($i = 0; $i < $send; $i++)
    {
      $conn->setReturnValueAt($count++, "read", "250 Ok");
      if (!$duplicate || ($i == $send-1))
      {
        $conn->setReturnValueAt($count++, "read", "250 Ok");
        $conn->setReturnValueAt($count++, "read", "354 Go ahead");
        $conn->setReturnValueAt($count++, "read", "250 Ok");
      }
    }
    $conn->setReturnValueAt($count++, "read", "250 Bye");
    return $conn;
  }
  
  public function testBytesPerMinuteThrottling()
  {
    $conn = new FullMockConnection();
    for ($i = 0; $i < 10; $i++)
    {
      $conn->setReturnValueAt($i, "read", "250 xx");
    }
    
    $swift = new Swift($conn, null, Swift::NO_START);
    set_time_limit(90); //60 secs expected + standard 30 secs
    
    $plugin = new Swift_Plugin_Throttler();
    
    //Outgoing bytes
    $plugin->setBytesPerMinute(60);
    $swift->attachPlugin($plugin, "throttler");
    
    $start = time();
    for ($i = 0; $i < 10; $i++)
    {
      //4 + 2 = 6 bytes each (and 6 x 10 = 60)
      $swift->command("1234");
    }
    $end = time();
    
    $duration = $end - $start;
    $this->assertTrue($duration >= 60);
    
    $this->dump("Sending 60 bytes at 60 bytes per minute took " . $duration . " secs");
    
    //
    
    $conn = new FullMockConnection();
    for ($i = 0; $i < 10; $i++)
    {
      $conn->setReturnValueAt($i, "read", "250 xx");
    }
    
    $swift = new Swift($conn, null, Swift::NO_START);
    set_time_limit(50); //20 secs expected + standard 30 secs
    
    $plugin = new Swift_Plugin_Throttler();
    
    //Outgoing bytes
    $plugin->setBytesPerMinute(180);
    $swift->attachPlugin($plugin, "throttler");
    
    $start = time();
    for ($i = 0; $i < 10; $i++)
    {
      //4 + 2 = 6 bytes each (and 6 x 10 = 60)
      $swift->command("ab c");
    }
    $end = time();
    
    $duration = $end - $start;
    $this->assertTrue($duration >= 20);
    
    $this->dump("Sending 60 bytes at 180 bytes per minute took " . $duration . " secs");
  }
  
  public function testEmailsPerMinuteThrottling()
  {
    $conn = $this->getWorkingMockConnection(6);
    $swift = new Swift($conn);
    $plugin = new Swift_Plugin_Throttler();
    $plugin->setEmailsPerMinute(18);
    
    $swift->attachPlugin($plugin, "throttler");
    
    $msg = new Swift_Message();
    set_time_limit(50);
    
    $start = time();
    for ($i = 0; $i < 6; $i++)
    {
      $swift->send($msg, "foo@bar", "zip@button");
    }
    $end = time();
    $duration = $end - $start;
    
    $this->assertTrue($duration >= 20);
    
    $this->dump("Sending 6 emails at 18 emails per minute took " . $duration . " secs");
    
    //
    
    $conn = $this->getWorkingMockConnection(6);
    $swift = new Swift($conn);
    $plugin = new Swift_Plugin_Throttler();
    $plugin->setEmailsPerMinute(24);
    
    $swift->attachPlugin($plugin, "throttler");
    
    $msg = new Swift_Message();
    set_time_limit(45);
    
    $start = time();
    for ($i = 0; $i < 6; $i++)
    {
      $swift->send($msg, "foo@bar", "zip@button");
    }
    $end = time();
    $duration = $end - $start;
    
    $this->assertTrue($duration >= 15);
    
    $this->dump("Sending 6 emails at 24 emails per minute took " . $duration . " secs");
  }
}
