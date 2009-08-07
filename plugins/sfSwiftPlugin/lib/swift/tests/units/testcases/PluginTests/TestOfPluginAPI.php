<?php

if (!class_exists("FullMockConnection")) Mock::Generate("DummyConnection", "FullMockConnection");
Mock::Generate("Swift_Events_SendListener", "MockSendListener");
Mock::Generate("Swift_Events_BeforeSendListener", "MockBeforeSendListener");
Mock::Generate("Swift_Events_CommandListener", "MockCommandListener");
Mock::Generate("Swift_Events_BeforeCommandListener", "MockBeforeCommandListener");
Mock::Generate("Swift_Events_ResponseListener", "MockResponseListener");
Mock::Generate("Swift_Events_ConnectListener", "MockConnectListener");
Mock::Generate("Swift_Events_DisconnectListener", "MockDisconnectListener");

class TestOfPluginAPI extends UnitTestCase
{
  /** Get a mock connection for testing
   * @param int The number emails you expect to send
   * @return FullMockConnection
   */
  protected function getWorkingMockConnection($send=1)
  {
    $count = 0;
    $conn = new FullMockConnection();
    $conn->setReturnValueAt($count++, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt($count++, "read", "250-Hello xxx\r\n250 HELP");
    for ($i = 0; $i < $send; $i++)
    {
      $conn->setReturnValueAt($count++, "read", "250 Ok");
      $conn->setReturnValueAt($count++, "read", "250 Ok");
      $conn->setReturnValueAt($count++, "read", "354 Go ahead");
      $conn->setReturnValueAt($count++, "read", "250 Ok");
    }
    $conn->setReturnValueAt($count++, "read", "221 Bye");
    return $conn;
  }
  
  /** Get a mock connection for testing
   * @param int The number emails you expect to send
   * @return FullMockConnection
   */
  protected function getFailingMockConnection($send=1)
  {
    $count = 0;
    $conn = new FullMockConnection();
    $conn->setReturnValueAt($count++, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt($count++, "read", "250-Hello xxx\r\n250 HELP");
    for ($i = 0; $i < $send; $i++)
    {
      $conn->setReturnValueAt($count++, "read", "250 Ok");
      $conn->setReturnValueAt($count++, "read", "500 Denied");
      $conn->setReturnValueAt($count++, "read", "250 Reset done");
    }
    $conn->setReturnValueAt($count++, "read", "221 Bye");
    return $conn;
  }
  
  public function testListenersCanBeRetreivedByReference()
  {
    $listener = new MockSendListener();
    $conn = $this->getWorkingMockConnection(1);
    $swift = new Swift($conn);
    $swift->attachPlugin($listener, "myplugin");
    $this->assertReference($listener, $swift->getPlugin("myplugin"));
  }
  
  public function testListenersCanBeRemovedOnceAdded()
  {
    $listener = new MockSendListener();
    $conn = $this->getWorkingMockConnection(1);
    $swift = new Swift($conn);
    $swift->attachPlugin($listener, "myplugin");
    $this->assertReference($listener, $swift->getPlugin("myplugin"));
    $swift->removePlugin("myplugin");
    $this->assertNull($swift->getPlugin("myplugin"));
  }
  
  public function testSendListenerIsNotifiedOnSend()
  {
    $listener = new MockSendListener();
    $listener->expectOnce("sendPerformed");
    $conn = $this->getWorkingMockConnection(1);
    $message = new Swift_Message("Subject", "Body");
    $swift = new Swift($conn);
    $swift->attachPlugin($listener, "myplugin");
    $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
    
    $listener = new MockSendListener();
    $listener->expectCallCount("sendPerformed", 5);
    $conn = $this->getWorkingMockConnection(5);
    $message = new Swift_Message("Subject", "Body");
    $swift = new Swift($conn);
    $swift->attachPlugin($listener, "myplugin");
    for ($i = 0; $i < 5; $i++)
      $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
  }
  
  public function testSendListenerDoesntRunWhenSendNotSuccessful()
  {
    //This changed in 3.0.7
  }
  
  public function testBeforeSendListenerIsNotifiedBeforeSending()
  {
    $before_send_listener = new MockBeforeSendListener();
    $before_send_listener->expectOnce("beforeSendPerformed");
    $conn = $this->getWorkingMockConnection(1);
    $message = new Swift_Message("Subject", "Body");
    $swift = new Swift($conn);
    $swift->attachPlugin($before_send_listener, "myplugin");
    $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
    
    $before_send_listener = new MockBeforeSendListener();
    $before_send_listener->expectCallCount("beforeSendPerformed", 5);
    $conn = $this->getWorkingMockConnection(5);
    $message = new Swift_Message("Subject", "Body");
    $swift = new Swift($conn);
    $swift->attachPlugin($before_send_listener, "myplugin");
    for ($i = 0; $i < 5; $i++)
      $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
  }
  
  public function testBeforeSendListenerRunsEvenWhenSendNotSuccessful()
  {
    $before_send_listener = new MockBeforeSendListener();
    $before_send_listener->expectOnce("beforeSendPerformed");
    $conn = $this->getFailingMockConnection(1);
    $message = new Swift_Message("Subject", "Body");
    $swift = new Swift($conn);
    $swift->attachPlugin($before_send_listener, "myplugin");
    try {
      $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
    } catch (Swift_ConnectionException $e) {
      //
    }
    
    $before_send_listener = new MockBeforeSendListener();
    $before_send_listener->expectCallCount("beforeSendPerformed", 5);
    $conn = $this->getFailingMockConnection(5);
    $message = new Swift_Message("Subject", "Body");
    $swift = new Swift($conn);
    $swift->attachPlugin($before_send_listener, "myplugin");
    for ($i = 0; $i < 5; $i++)
    {
      try {
        $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
      } catch (Swift_ConnectionException $e) {
        //
      }
    }
  }
  
  public function testCommandListenerRunsAfterEachCommand()
  {
    $conn = $this->getWorkingMockConnection();
    //ehlo, mail from, rcpt to, data, msg
    $conn->expectMinimumCallCount("write", 5);
    
    $command_listener = new MockCommandListener();
    $command_listener->expectMinimumCallCount("commandSent", 5);
    
    $swift = new Swift($conn, "xxx", Swift::NO_START);
    $swift->attachPlugin($command_listener, "myplugin");
    $swift->connect();
    $message = new Swift_Message("Subject", "Body");
    $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
    
    $this->assertTrue($conn->getCallCount("write") >= $command_listener->getCallCount("commandSent"));
  }
  
  public function testBeforeCommandListenerRunsBeforeEachCommand()
  {
    $conn = $this->getWorkingMockConnection();
    //ehlo, mail from, rcpt to, data, msg
    $conn->expectMinimumCallCount("write", 5);
    
    $before_command_listener = new MockBeforeCommandListener();
    $before_command_listener->expectMinimumCallCount("beforeCommandSent", 5);
    
    $swift = new Swift($conn, "xxx", Swift::NO_START);
    $swift->attachPlugin($before_command_listener, "myplugin");
    $swift->connect();
    $message = new Swift_Message("Subject", "Body");
    $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
    $this->assertTrue($conn->getCallCount("write") >= $before_command_listener->getCallCount("beforeCommandSent"));
  }
  
  public function testResponseListenerRunsAfterEachResponse()
  {
    $conn = $this->getWorkingMockConnection();
    //ehlo, mail from, rcpt to, data, msg
    $conn->expectMinimumCallCount("read", 6);
    
    $response_listener = new MockResponseListener();
    $response_listener->expectMinimumCallCount("responseReceived", 6);
    
    $swift = new Swift($conn, "xxx", Swift::NO_START);
    $swift->attachPlugin($response_listener, "myplugin");
    $swift->connect();
    $message = new Swift_Message("Subject", "Body");
    $swift->send($message, new Swift_Address("foo@bar.com"), new Swift_Address("me@myplace.com"));
    
    $this->assertTrue($conn->getCallCount("read") >= $response_listener->getCallCount("responseReceived"));
  }
  
  public function testConnectListenerRunsUponConnect()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 Hello xx");
    $conn->setReturnValueAt(1, "read", "250 Hello xxx");
    $conn->setReturnValueAt(2, "read", "221 Bye");
    
    $connect_listener = new MockConnectListener();
    $connect_listener->expectCallCount("connectPerformed", 1);
    
    $swift = new Swift($conn, "xxx", Swift::NO_START);
    $swift->attachPlugin($connect_listener, "myplugin");
    $swift->connect();
    
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 Hello xx");
    $conn->setReturnValueAt(1, "read", "250 Hello xxx");
    $conn->setReturnValueAt(2, "read", "221 Bye");
    $conn->setReturnValueAt(3, "read", "220 Hello xx");
    $conn->setReturnValueAt(4, "read", "250 Hello xxx");
    $conn->setReturnValueAt(5, "read", "221 Bye");
    $conn->setReturnValueAt(6, "read", "220 Hello xx");
    $conn->setReturnValueAt(7, "read", "250 Hello xxx");
    $conn->setReturnValueAt(8, "read", "221 Bye");
    
    $connect_listener = new MockConnectListener();
    $connect_listener->expectCallCount("connectPerformed", 3);
    
    $swift = new Swift($conn, "xxx", Swift::NO_START);
    $swift->attachPlugin($connect_listener, "myplugin");
    $swift->connect();
    $swift->disconnect();
    $swift->connect();
    $swift->disconnect();
    $swift->connect();
    $swift->disconnect();
  }
  
  public function testDisconnectListenerRunsUponDisconnect()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 Hello xx");
    $conn->setReturnValueAt(1, "read", "250 Hello xxx");
    $conn->setReturnValueAt(2, "read", "221 Bye");
    
    $disconnect_listener = new MockDisconnectListener();
    $disconnect_listener->expectCallCount("disconnectPerformed", 1);
    
    $swift = new Swift($conn);
    $swift->attachPlugin($disconnect_listener, "myplugin");
    $swift->disconnect();
    
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 Hello xx");
    $conn->setReturnValueAt(1, "read", "250 Hello xxx");
    $conn->setReturnValueAt(2, "read", "221 Bye");
    $conn->setReturnValueAt(3, "read", "220 Hello xx");
    $conn->setReturnValueAt(4, "read", "250 Hello xxx");
    $conn->setReturnValueAt(5, "read", "221 Bye");
    $conn->setReturnValueAt(6, "read", "220 Hello xx");
    $conn->setReturnValueAt(7, "read", "250 Hello xxx");
    $conn->setReturnValueAt(8, "read", "221 Bye");
    
    $disconnect_listener = new MockDisconnectListener();
    $disconnect_listener->expectCallCount("disconnectPerformed", 3);
    
    $swift = new Swift($conn);
    $swift->attachPlugin($disconnect_listener, "myplugin");
    $swift->disconnect();
    $swift->connect();
    $swift->disconnect();
    $swift->connect();
    $swift->disconnect();
  }
}
