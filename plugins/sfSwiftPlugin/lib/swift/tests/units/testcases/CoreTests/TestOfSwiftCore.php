<?php

if (!class_exists("FullMockConnection")) Mock::Generate("DummyConnection", "FullMockConnection");
if (!class_exists("MockBaseConnection")) Mock::GeneratePartial("DummyConnection", "MockBaseConnection", array("start", "stop", "read", "write"));
Mock::GeneratePartial("Swift_Message", "Message_RecipientsMocked", array("setTo", "setCc", "setBcc", "setFrom", "setReplyTo"));
Mock::GeneratePartial("Swift_Message", "Message_IdMocked", array("generateId"));
Mock::GeneratePartial("Swift_Message", "Message_EncodingMocked", array("setEncoding", "getEncoding"));
Mock::GeneratePartial("Swift_Log_DefaultLog", "MockLogger", array("add"));

class TestOfSwiftCore extends UnitTestCase
{
  public function setUp()
  {
    $log = new Swift_Log_DefaultLog();
    Swift_LogContainer::setLog($log);
  }
  
  public function testConnectionIsInvokedAtInstantiation()
  {
    $conn = new FullMockConnection();
    $conn->expectOnce("start");
    $swift = new Swift($conn, false, Swift::NO_HANDSHAKE);
  }
  
  public function testConnectionIsNotStartedIfNO_STARTFlagIsSet()
  {
    $conn = new FullMockConnection();
    $conn->expectNever("start");
    $swift = new Swift($conn, null, Swift::NO_START);
  }
  
  public function testHELOIsSentAfterA220Response()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx");
    $conn->setReturnValueAt(1, "read", "250 xxx");
    $conn->expectOnce("write", array("HELO mydomain", "*"));
    $swift = new Swift($conn, "mydomain");
  }
  
  public function testEHLOIsSentIf220ResponseContainsESMTP()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 abc ESMTP xx");
    $conn->setReturnValueAt(1, "read", "250 xxx");
    $conn->expectOnce("write", array("EHLO mydomain", "*"));
    $swift = new Swift($conn, "mydomain");
    
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 ESMTP");
    $conn->setReturnValueAt(1, "read", "250 xxx");
    $conn->expectOnce("write", array("EHLO mydomain", "*"));
    $swift = new Swift($conn, "mydomain");
  }
  
  public function testExceptionIsThrownIf200ResponseIsNotReceivedAtStart()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValue("read", "000 abc ESMTP xx");
    try {
      $swift = new Swift($conn, "mydomain");
      $this->fail("No 220 response was given so this should have failed");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
    
    $conn = new FullMockConnection();
    $conn->setReturnValue("read", "120 abc ESMTP xx");
    try {
      $swift = new Swift($conn, "mydomain");
      $this->fail("No 220 response was given so this should have failed");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
    
    $conn = new FullMockConnection();
    $conn->setReturnValue("read", "x220 abc ESMTP xx");
    try {
      $swift = new Swift($conn, "mydomain");
      $this->fail("No 220 response was given so this should have failed");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
  }
  
  public function testExtensionListIsStored()
  {
    $conn = new MockBaseConnection();
    $conn->setReturnValueAt(0, "read", "220 abc ESMTP xx");
    $conn->setReturnValueAt(1, "read",
      "250-Hello xxxx\r\n" .
      "250-SIZE 52428800\r\n" .
      "250-8BITMIME\r\n" .
      "250-PIPELINING\r\n" .
      "250-STARTTLS\r\n" .
      "250-AUTH LOGIN PLAIN CRAM-MD5\r\n" .
      "250 HELP");
    $swift = new Swift($conn, "mydomain");
    $this->assertTrue($swift->connection->hasExtension("SIZE"));
    $this->assertTrue($swift->connection->hasExtension("8BITMIME"));
    $this->assertTrue($swift->connection->hasExtension("PIPELINING"));
    $this->assertTrue($swift->connection->hasExtension("STARTTLS"));
    $this->assertTrue($swift->connection->hasExtension("AUTH"));
    $this->assertTrue($swift->connection->hasExtension("HELP"));
    $this->assertFalse($swift->connection->hasExtension("FOOBAR"));
    $this->assertFalse($swift->connection->hasExtension("XXXX"));
  }
  
  public function testAttributesCanBeReadFromExtensions()
  {
    $conn = new MockBaseConnection();
    $conn->setReturnValueAt(0, "read", "220 abc ESMTP xx");
    $conn->setReturnValueAt(1, "read",
      "250-Hello xxxx\r\n" .
      "250-SIZE 52428800\r\n" .
      "250-8BITMIME\r\n" .
      "250-PIPELINING\r\n" .
      "250-STARTTLS\r\n" .
      "250-AUTH LOGIN PLAIN CRAM-MD5\r\n" .
      "250 HELP");
    $swift = new Swift($conn, "mydomain");
    $this->assertEqual(array("52428800"), $swift->connection->getAttributes("SIZE"));
    $this->assertEqual(array(), $swift->connection->getAttributes("8BITMIME"));
    $this->assertEqual(array(), $swift->connection->getAttributes("PIPELINING"));
    $this->assertEqual(array(), $swift->connection->getAttributes("STARTTLS"));
    $this->assertEqual(array("LOGIN", "PLAIN", "CRAM-MD5"), $swift->connection->getAttributes("AUTH"));
    $this->assertEqual(array(), $swift->connection->getAttributes("HELP"));
  }
  
  public function testExceptionIsThrownIfAttributesAreReadFromNonExistentExtension()
  {
    $conn = new MockBaseConnection();
    $conn->setReturnValueAt(0, "read", "220 abc ESMTP xx");
    $conn->setReturnValueAt(1, "read",
      "250-Hello xxxx\r\n" .
      "250 SIZE 52428800");
    $swift = new Swift($conn, "mydomain");
    
    try {
      $x = $swift->connection->getAttributes("AUTH");
      $this->fail("This should have failed since AUTH extension does not exist.");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
    
    try {
      $x = $swift->connection->getAttributes("8BITMIME");
      $this->fail("This should have failed since 8BITMIME extension does not exist.");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
  }
  
  public function testPostConnectIsInvokedInConnectionAfterHandshake()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 ESMTP");
    $conn->setReturnValueAt(1, "read", "250 xxx");
    $conn->expectOnce("postConnect");
    $swift = new Swift($conn, "mydomain");
  }
  
  public function testSMTPCommandsAreExecutedOnSend()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "354 Go ahead");
    $conn->setReturnValueAt(5, "read", "250 Ok");
    $conn->expectMinimumCallCount("write", 5);
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $conn->expectAt(3, "write", array("DATA", "*"));
    $conn->expectAt(4, "write", array("*", "*"));
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    $swift->send($message, new Swift_Address("xxx@yyy.tld", "XXX YYY"), new Swift_Address("foo@bar.tld", "Foo Bar"));
    
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "250 Ok");
    $conn->setReturnValueAt(5, "read", "354 Go ahead");
    $conn->setReturnValueAt(6, "read", "250 Ok");
    $conn->expectMinimumCallCount("write", 6);
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $conn->expectAt(3, "write", array("RCPT TO: <abc@def.tld>", "*"));
    $conn->expectAt(4, "write", array("DATA", "*"));
    $conn->expectAt(5, "write", array("*", "*"));
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addCc("abc@def.tld");
    $swift->send($message, $recipients, new Swift_Address("foo@bar.tld", "Foo Bar"));
  }
  
  public function testExceptionIsThrownIfNo250ResponsesAreIssuedAtRCPT()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "550 Denied");
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    try {
      $swift->send($message, new Swift_Address("xxx@yyy.tld", "XXX YYY"), new Swift_Address("foo@bar.tld", "Foo Bar"));
      $this->fail("This should have thrown an exception since denied codes were being returned.");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
  }
  
  public function testRSETIsIssuedOnFailure()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "550 Denied");
    $conn->setReturnValueAt(4, "read", "550 Denied");
    $conn->setReturnValueAt(5, "read", "250 Reset ok");
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $conn->expectAt(3, "write", array("RCPT TO: <abc@def.tld>", "*"));
    $conn->expectAt(4, "write", array("RSET", "*"));
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addCc("abc@def.tld");
    
    $this->assertFalse($swift->send($message, $recipients, new Swift_Address("foo@bar.tld", "Foo Bar")));
  }
  
  public function testAddressHeadersAreInjectedBeforeSending()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "250 Ok");
    $conn->setReturnValueAt(5, "read", "354 Go ahead");
    $conn->setReturnValueAt(6, "read", "250 Ok");
    $conn->expectMinimumCallCount("write", 6);
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $conn->expectAt(3, "write", array("RCPT TO: <abc@def.tld>", "*"));
    $conn->expectAt(4, "write", array("DATA", "*"));
    $conn->expectAt(5, "write", array("*", "*"));
    $swift = new Swift($conn, "abc");
    
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addCc("abc@def.tld");
    $from = new Swift_Address("foo@bar.tld", "Foo Bar");
    
    $message = new Message_RecipientsMocked();
    $message->__construct();
    $message->setSubject("the subject");
    $message->setBody("the body");
    $message->expectAt(0, "setTo", array(array("XXX YYY <xxx@yyy.tld>")));
    $message->expectAt(0, "setCc", array(array("abc@def.tld")));
    $message->expectAt(0, "setFrom", array($from->build()));
    
    $swift->send($message, $recipients, $from);
  }
  
  public function testRecipientHeadersAreRestoredAfterSending()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "250 Ok");
    $conn->setReturnValueAt(5, "read", "354 Go ahead");
    $conn->setReturnValueAt(6, "read", "250 Ok");
    $conn->expectMinimumCallCount("write", 6);
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $conn->expectAt(3, "write", array("RCPT TO: <abc@def.tld>", "*"));
    $conn->expectAt(4, "write", array("DATA", "*"));
    $conn->expectAt(5, "write", array("*", "*"));
    $swift = new Swift($conn, "abc");
    
    $message = new Swift_Message("the subject", "the body");
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addCc("abc@def.tld");
    $swift->send($message, $recipients, new Swift_Address("foo@bar.tld", "Foo Bar"));
    
    $this->assertEqual(array(), $message->getTo());
    $this->assertFalse($message->getCc());
    $this->assertFalse($message->getReturnPath());
    $this->assertFalse($message->getReplyTo());
  }
  
  public function testMessageIdIsGeneratedBeforeSending()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "250 Ok");
    $conn->setReturnValueAt(5, "read", "354 Go ahead");
    $conn->setReturnValueAt(6, "read", "250 Ok");
    $conn->expectMinimumCallCount("write", 6);
    $conn->expectAt(0, "write", array("EHLO abc", "*"));
    $conn->expectAt(1, "write", array("MAIL FROM: <foo@bar.tld>", "*"));
    $conn->expectAt(2, "write", array("RCPT TO: <xxx@yyy.tld>", "*"));
    $conn->expectAt(3, "write", array("RCPT TO: <abc@def.tld>", "*"));
    $conn->expectAt(4, "write", array("DATA", "*"));
    $conn->expectAt(5, "write", array("*", "*"));
    $swift = new Swift($conn, "abc");
    
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addCc("abc@def.tld");
    $from = new Swift_Address("foo@bar.tld", "Foo Bar");
    
    $message = new Message_IdMocked();
    $message->__construct();
    $message->setSubject("the subject");
    $message->setBody("the body");
    $message->expectOnce("generateId");
    
    $swift->send($message, $recipients, $from);
  }
  
  public function testQPEncodingIsUsedIf8BITMIMENotPresentAndCharactersOutside7BitRange()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "354 Go ahead");
    $conn->setReturnValueAt(5, "read", "250 Ok");
    
    $message = new Message_EncodingMocked();
    $message->__construct();
    $message->setSubject("foobar");
    $message->setBody("cenvéla");
    $message->setReturnValue("getEncoding", false);
    $message->setReturnValueAt(2, "getEncoding", "quoted-printable");
    $message->expectCallCount("setEncoding", 2);
    $message->expectAt(1, "setEncoding", array("QP", true, true));
    
    $swift = new Swift($conn, "xxx");
    $swift->send($message, new Swift_Address("xxx@yyy.com"), new Swift_Address("abc@vvv.tld"));
  }
  
  public function testSendReturnsNumberOfSuccessfulEnvelopes()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "354 Go ahead");
    $conn->setReturnValueAt(5, "read", "250 Ok");
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    $ret = $swift->send($message, new Swift_Address("xxx@yyy.tld", "XXX YYY"), new Swift_Address("foo@bar.tld", "Foo Bar"));
    $this->assertEqual(1, $ret);
    
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "250 Ok");
    $conn->setReturnValueAt(5, "read", "354 Go ahead");
    $conn->setReturnValueAt(6, "read", "250 Ok");
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addCc("abc@def.tld");
    $ret = $swift->send($message, $recipients, new Swift_Address("foo@bar.tld", "Foo Bar"));
    $this->assertEqual(2, $ret);
  }
  
  public function testFailedRecipientsAreReturned()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "550 Denied");
    $conn->setReturnValueAt(4, "read", "250 ok");
    $conn->setReturnValueAt(5, "read", "550 Denied");
    $conn->setReturnValueAt(6, "read", "354 Go ahead");
    $conn->setReturnValueAt(7, "read", "250 ok");
    $log = Swift_LogContainer::getLog();
    
    $swift = new Swift($conn, "abc", Swift::ENABLE_LOGGING);
    $message = new Swift_Message("My Subject", "my body");
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addTo("someone@somewhere.tld");
    $recipients->addCc("abc@def.tld");
    
    $this->assertEqual(1, $swift->send($message, $recipients, new Swift_Address("foo@bar.tld", "Foo Bar")));
    $this->assertEqual(array("xxx@yyy.tld", "abc@def.tld"), $log->getFailedRecipients());
  }
  
  public function testBatchSendingDoesNotCopyAllRecipientsInOnASingleEmail()
  {
    //Most of this test has been removed due to complexity working out when the commands when be issued. Sorry.
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 Ok");
    $conn->setReturnValueAt(4, "read", "354 Go ahead");
    $conn->setReturnValueAt(5, "read", "250 ok");
    $conn->setReturnValueAt(6, "read", "250 Ok");
    $conn->setReturnValueAt(7, "read", "250 Ok");
    $conn->setReturnValueAt(8, "read", "354 Go ahead");
    $conn->setReturnValueAt(9, "read", "250 ok");
    
    $message = new Swift_Message("My Subject", "my body");
    $message->setEncoding("8bit");
    
    $swift = new Swift($conn, "abc", Swift::ENABLE_LOGGING);
    $recipients = new Swift_RecipientList();
    $recipients->addTo("xxx@yyy.tld", "XXX YYY");
    $recipients->addTo("someone@somewhere.tld");
    
    $this->assertEqual(2, $swift->batchSend($message, $recipients, new Swift_Address("foo@bar.tld", "Foo Bar")));
  }
  
  public function testLoggerIsInvokedIfSetActive()
  {
    $conn = new FullMockConnection();
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "250 Ok");
    $conn->setReturnValueAt(3, "read", "250 ok");
    $conn->setReturnValueAt(4, "read", "354 Go ahead");
    $conn->setReturnValueAt(5, "read", "250 ok");
    $logger = new MockLogger();
    $logger->setLogLevel(Swift_Log::LOG_EVERYTHING);
    $logger->expectMinimumCallCount("add", 8);
    Swift_LogContainer::setLog($logger);
    $swift = new Swift($conn, "abc");
    $message = new Swift_Message("My Subject", "my body");
    $swift->send($message, new Swift_Address("zip@button.tld"), new Swift_Address("foo@bar.tld", "Foo Bar"));
  }
}
