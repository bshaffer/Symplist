<?php

if (!class_exists("PartialSmtpConnection2")) Mock::GeneratePartial("Swift_Connection_SMTP", "PartialSmtpConnection2", array("read", "write", "start", "stop"));
Mock::GeneratePartial("Swift_Authenticator_PopB4Smtp_Pop3Connection", "MockPop3Connection", array("start", "stop", "read", "write"));

class TestOfPopB4SmtpAuthenticator extends UnitTestCase
{
  public function testSmtpConnectionIsClosedBeforeAnythingIsDone()
  {
    $pop3conn = new MockPop3Connection();
    $pop3conn->setReturnValue("read", "+OK foo");
    $auth = new Swift_Authenticator_PopB4Smtp($pop3conn);
    
    $conn = new PartialSmtpConnection2();
    $conn->attachAuthenticator($auth);
    $conn->setUsername("foo");
    $conn->setPassword("bar");
    
    $conn->setReturnValueAt(0, "read", "220 Hello ESMTP foo");
    $conn->setReturnValueAt(3, "read", "220 Hello ESMTP foo");
    $conn->setReturnValueAt(2, "read", "221 bye");
    $conn->setReturnValue("read", "250 Ok");
    $conn->expectMinimumCallCount("write", 2);
    $conn->expectAt(1, "write", array("QUIT", "*"));
    $conn->expectAtLeastOnce("stop");
    
    $swift = new Swift($conn, "xxx");
  }
  
  public function testAuthenticationPassesWithSuccessfulPop3Coversation()
  {
    $pop3conn = new MockPop3Connection();
    $pop3conn->setReturnValue("read", "+OK xxx");
    $pop3conn->expectAt(0, "write", array("USER foo"));
    $pop3conn->expectAt(1, "write", array("PASS bar"));
    $pop3conn->expectAt(2, "write", array("QUIT"));
    
    $auth = new Swift_Authenticator_PopB4Smtp($pop3conn);
    
    $conn = new PartialSmtpConnection2();
    $conn->attachAuthenticator($auth);
    $conn->setUsername("foo");
    $conn->setPassword("bar");
    
    $conn->setReturnValueAt(0, "read", "220 Hello ESMTP foo");
    $conn->setReturnValueAt(2, "read", "221 bye");
    $conn->setReturnValueAt(3, "read", "220 Hello ESMTP foo");
    $conn->setReturnValue("read", "250 Ok");
    $conn->expectAtLeastOnce("stop");
    
    try {
      $swift = new Swift($conn, "xxx");
    } catch (Swift_ConnectionException $e) {
      $this->fail("No exception should have been thrown: " . $e->getMessage());
    }
  }
  
  public function testAuthenticationFailsWithBadResponse()
  {
    $pop3conn = new MockPop3Connection();
    $pop3conn->setReturnValueAt(0, "read", "+OK xxx");
    $pop3conn->setReturnValueAt(1, "read", "Bad");
    $pop3conn->expectAt(0, "write", array("USER foo"));;
    
    $auth = new Swift_Authenticator_PopB4Smtp($pop3conn);
    
    $conn = new PartialSmtpConnection2();
    $conn->attachAuthenticator($auth);
    $conn->setUsername("foo");
    $conn->setPassword("bar");
    
    $conn->setReturnValueAt(0, "read", "220 Hello ESMTP foo");
    $conn->setReturnValueAt(2, "read", "221 bye");
    $conn->setReturnValueAt(3, "read", "220 Hello ESMTP foo");
    $conn->setReturnValue("read", "250 Ok");
    $conn->expectMinimumCallCount("write", 2);
    $conn->expectAt(1, "write", array("QUIT", "*"));
    $conn->expectAtLeastOnce("stop");
    
    try {
      $swift = new Swift($conn, "xxx");
      $this->fail("This should have thrown an exception since the authentication failed");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
  }
  
  public function testConnectIsRunAgainAfterSuccessfulAuthentication()
  {
    $pop3conn = new MockPop3Connection();
    $pop3conn->setReturnValue("read", "+OK xxx");
    $pop3conn->expectAt(0, "write", array("USER foo"));
    $pop3conn->expectAt(1, "write", array("PASS bar"));
    $pop3conn->expectAt(2, "write", array("QUIT"));
    
    $auth = new Swift_Authenticator_PopB4Smtp($pop3conn);
    
    $conn = new PartialSmtpConnection2();
    $conn->attachAuthenticator($auth);
    $conn->setUsername("foo");
    $conn->setPassword("bar");
    
    $conn->setReturnValueAt(0, "read", "220 Hello ESMTP foo");
    $conn->setReturnValueAt(2, "read", "221 bye");
    $conn->setReturnValueAt(3, "read", "220 Hello ESMTP foo");
    $conn->setReturnValue("read", "250 Ok");
    $conn->expectAtLeastOnce("stop");
    $conn->expectCallCount("start", 2);
    
    try {
      $swift = new Swift($conn, "xxx");
    } catch (Swift_ConnectionException $e) {
      $this->fail("No exception should have been thrown: " . $e->getMessage());
    }
  }
}
