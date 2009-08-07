<?php

/**
 * Swift Mailer Unit Test Case for EasySwift Wrapper.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

/**
 * Swift Mailer Unit Test Case for EasySwift Wrapper.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfEasySwift extends AbstractTestWithSend
{
  /**
   * The old API would never spit out errors, so we should be catching them in EasySwift too.
   */
  public function testNoExceptionsAreThrownBut_HasFailed_IsTrueOnBadConnection()
  {
    $mockConnection = new FullMockConnection();
    $mockConnection->setReturnValue("read", "500 Bad");
    $swift = new EasySwift($mockConnection);
    $this->assertTrue($swift->hasFailed());
    $this->assertFalse($swift->isConnected());
  }
  public function testLastErrorCanBeFetched()
  {
    $mockConnection = new FullMockConnection();
    $mockConnection->setReturnValue("read", "500 Bad");
    $swift = new EasySwift($mockConnection);
    $this->assertTrue($swift->hasFailed());
    $this->assertFalse($swift->isConnected());
  }
  /**
   * Because the old API doesn't show errors, isConnected() needs to give useful info.
   */
  public function testIsConnectedReturnsTrueOnSuccess()
  {
    $mockConnection = $this->getWorkingMockConnection(1);
    
    $swift = new EasySwift($mockConnection);
    $this->assertFalse($swift->hasFailed());
    $this->assertTrue($swift->isConnected());
  }
  /**
   * The old API, by default sent emails as a batch.
   */
  public function testSendCallsBatchSendWithRecipientListInSwift()
  {
    $mockConnection = $this->getWorkingMockConnection(3);
    $mockConnection->expectMinimumCallCount("write", 13);
    $mockConnection->expectAt(0, "write", array("EHLO xxx", "*"));
    $mockConnection->expectAt(1, "write", array("MAIL FROM: <me@myplace.com>", "*"));
    $mockConnection->expectAt(2, "write", array("RCPT TO: <foo@bar.com>", "*"));
    $mockConnection->expectAt(3, "write", array("DATA", "*"));
    $mockConnection->expectAt(4, "write", array("*", "*"));
    
    $swift = new EasySwift($mockConnection, "xxx");
    $addresses = array("Foo Bar <foo@bar.com>", '"Zip Button" <zip@button.tld>', "mail@cheese.domain");
    $this->assertEqual(3, $swift->send($addresses, "My name <me@myplace.com>", "My subject", "My message"));
  }
  /**
   * useExactCopy() should be called to enable the new API behaviour when sending.
   */
  public function testSendIsASingleEmailWhenUseExactCopyIsCalled()
  {
    $mockConnection = $this->getWorkingMockConnection(3, null, 0, 0, true);
    $mockConnection->expectMinimumCallCount("write", 7);
    $mockConnection->expectAt(0, "write", array("EHLO xxx", "*"));
    $mockConnection->expectAt(1, "write", array("MAIL FROM: <me@myplace.com>", "*"));
    $mockConnection->expectAt(2, "write", array("RCPT TO: <foo@bar.com>", "*"));
    $mockConnection->expectAt(3, "write", array("RCPT TO: <zip@button.tld>", "*"));
    $mockConnection->expectAt(4, "write", array("RCPT TO: <mail@cheese.domain>", "*"));
    $mockConnection->expectAt(5, "write", array("DATA", "*"));
    $mockConnection->expectAt(6, "write", array("*", "*"));
    
    $swift = new EasySwift($mockConnection, "xxx");
    $swift->useExactCopy();
    $addresses = array("Foo Bar <foo@bar.com>", '"Zip Button" <zip@button.tld>', "mail@cheese.domain");
    $this->assertEqual(3, $swift->send($addresses, "My name <me@myplace.com>", "My subject", "My message"));
  }
  /**
   * Equates to the same test as testSendIsASingleEmailWhenUseExactCopyIsCalled.
   * @see testSendIsASingleEmailWhenUseExactCopyIsCalled
   */
  public function testSendIsASingleEmailWhenCcAddressesAreUsed()
  {
    $mockConnection = $this->getWorkingMockConnection(5, null, 0, 0, true);
    $mockConnection->expectMinimumCallCount("write", 7);
    $mockConnection->expectAt(0, "write", array("EHLO xxx", "*"));
    $mockConnection->expectAt(1, "write", array("MAIL FROM: <me@myplace.com>", "*"));
    $mockConnection->expectAt(2, "write", array("RCPT TO: <foo@bar.com>", "*"));
    $mockConnection->expectAt(3, "write", array("RCPT TO: <zip@button.tld>", "*"));
    $mockConnection->expectAt(4, "write", array("RCPT TO: <mail@cheese.domain>", "*"));
    $mockConnection->expectAt(5, "write", array("RCPT TO: <cc1@address.co.uk>", "*"));
    $mockConnection->expectAt(6, "write", array("RCPT TO: <cc2@address.xxx>", "*"));
    $mockConnection->expectAt(7, "write", array("DATA", "*"));
    $mockConnection->expectAt(8, "write", array("*", "*"));
    
    $swift = new EasySwift($mockConnection, "xxx");
    $swift->addCc("Carbon Copy Recipient One <cc1@address.co.uk>");
    $swift->addCc("cc2@address.xxx");
    $addresses = array("Foo Bar <foo@bar.com>", '"Zip Button" <zip@button.tld>', "mail@cheese.domain");
    $this->assertEqual(5, $swift->send($addresses, "My name <me@myplace.com>", "My subject", "My message"));
  }
  /**
   * The new API has a complete MIME layer, all message operations should be handed to it.
   */
  public function testAddingPartsIsHandledByMessageObject()
  {
    $mockConnection = $this->getWorkingMockConnection();
    
    $swift = new EasySwift($mockConnection, "xxx");
    $mockMessage = new MockMessage();
    $mockMessage->expectOnce("attach");
    $swift->newMessage($mockMessage);
    $swift->addPart("my part");
  }
  /**
   * Attachments should be dealt with by the MIME layer too.
   * @see testAddingPartsIsHandledByMessageObject
   */
  public function testAddingAttachmentsIsHandledByMessageObject()
  {
    $mockConnection = $this->getWorkingMockConnection();
    
    $swift = new EasySwift($mockConnection, "xxx");
    $mockMessage = new MockMessage();
    $mockMessage->expectCallCount("attach", 2);
    $swift->newMessage($mockMessage);
    $swift->addAttachment("my attachment", "my name.txt");
    $swift->addAttachment(new Swift_File(TestConfiguration::FILES_PATH . "/gecko.png"));
  }
  /**
   * Images handled by MIME layer.
   * @see testAddingPartsIsHandledByMessageObject
   */
  public function testAddingImagesIsHandledByMessageObject()
  {
    $mockConnection = $this->getWorkingMockConnection();
    
    $swift = new EasySwift($mockConnection, "xxx");
    $mockMessage = new MockMessage();
    $mockMessage->expectCallCount("attach", 3);
    $swift->newMessage($mockMessage);
    $swift->addImage(TestConfiguration::FILES_PATH . "/manchester.jpeg");
    $swift->addImage(TestConfiguration::FILES_PATH . "/durham.gif");
    $swift->addImage(TestConfiguration::FILES_PATH . "/gecko.png");
  }
  /**
   * Special case, adding images (or embedded files) returns Content-ID
   */
  public function testCIDSrcValueIsReturnedWhenAddingImage()
  {
    $mockConnection = $this->getWorkingMockConnection();
    
    $swift = new EasySwift($mockConnection, "xxx");
    
    $this->assertPattern("/^cid:.+\$/i", $swift->addImage(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $this->assertPattern("/^cid:.+\$/i", $swift->addImage(TestConfiguration::FILES_PATH . "/durham.gif"));
    $this->assertPattern("/^cid:.+\$/i", $swift->addImage(new Swift_File(TestConfiguration::FILES_PATH . "/gecko.png")));
  }
  /**
   * Special case, adding images (or embedded files) returns Content-ID
   */
  public function testCIDSrcValueIsReturnedWhenAddingEmbeddedFile()
  {
    $mockConnection = $this->getWorkingMockConnection();
    
    $swift = new EasySwift($mockConnection, "xxx");
    
    $this->assertPattern("/^cid:.+\$/i", $swift->embedFile(file_get_contents(TestConfiguration::FILES_PATH . "/manchester.jpeg"), "image/jpeg"));
    $this->assertPattern("/^cid:.+\$/i", $swift->embedFile(new Swift_File(TestConfiguration::FILES_PATH . "/durham.gif"), "image/gif", "myimage.gif"));
    $this->assertPattern("/^cid:my_cid123\$/i", $swift->embedFile(file_get_contents(TestConfiguration::FILES_PATH . "/gecko.png"), "image/png", "myimage.png", "my_cid123"));
  }
  /**
   * EasySwift loads plugins in the manner of the old API but simply wraps around the new API.
   */
  public function testPluginsAreLoadedWithEasySwiftButHandledBySwiftAsNormal()
  {
    $conn = $this->getWorkingMockConnection();
    $swift = new EasySwift($conn);
    $plugin = new MockSendListener();
    $plugin->expectOnce("sendPerformed");
    $swift->loadPlugin($plugin, "myplugin");
    $swift->send("foo@bar.com", "me@mydomain.com", "Subject", "body");
  }
  /**
   * SMTP authentication will be enabled if SMTP connection is used.
   */
  public function testSmtpAuthenticatorsAreAddedIfSmtpConnectionIsUsed()
  {
    $conn = $this->getWorkingMockConnection(1, new MockSMTPConnection());
    $auth = new Swift_Authenticator_PLAIN();
    $conn->expectOnce("attachAuthenticator", array($auth));
    
    $swift = new EasySwift($conn);
    $swift->loadAuthenticator($auth);
  }
  /**
   * The authenticate() method comes from the old API, but is now wrapped around the new API.
   */
  public function testSMTPAuthenticationReturnsTrueOnSuccess()
  {
    $conn = new MockSMTPConnectionAuth();
    $conn->setReturnValue("isAlive", true);
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250-AUTH PLAIN\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "235 Authenticated");
    $conn->expectAt(1, "write", array("AUTH PLAIN " . base64_encode("foo\0foo\0bar"), "*"));
    
    $auth = new Swift_Authenticator_PLAIN();
    
    $swift = new EasySwift($conn);
    $swift->loadAuthenticator($auth);
    $this->assertTrue($swift->authenticate("foo", "bar"));
  }
  /**
   * The authenticate() method comes from the old API, but is now wrapped around the new API.
   * @see testSMTPAuthenticationReturnsTrueOnSuccess
   */
  public function testSMTPAuthenticationReturnsFalseOnFailure()
  {
    $conn = new MockSMTPConnectionAuth();
    $conn->setReturnValue("isAlive", true);
    $conn->setReturnValueAt(0, "read", "220 xxx ESMTP");
    $conn->setReturnValueAt(1, "read", "250-Hello xxx\r\n250-AUTH PLAIN\r\n250 HELP");
    $conn->setReturnValueAt(2, "read", "500 No good");
    $conn->expectAt(1, "write", array("AUTH PLAIN " . base64_encode("foo\0foo\0bar"), "*"));
    
    $auth = new Swift_Authenticator_PLAIN();
    
    $swift = new EasySwift($conn);
    $swift->loadAuthenticator($auth);
    $this->assertFalse($swift->authenticate("foo", "bar"));
  }
  /**
   * addHeaders() from the old API should translate calls into the new API.
   */
  public function testMessageHeadersAreInvokedWhenAddHeadersIsCalled()
  {
    $conn = $this->getWorkingMockConnection();
    $swift = new EasySwift($conn);
    $headers = new MockHeaders();
    $headers->expectCallCount("set", 2);
    $headers->expectAt(0, "set", array("Foo", "test"));
    $headers->expectAt(1, "set", array("Bar", "test2"));
    $swift->message->setHeaders($headers);
    $swift->addHeaders("Foo: test\r\nBar: test2");
  }
  /**
   * Headers should be parsed and attributes passed to the setAttribute() method of the Swift_Message_Headers class.
   */
  public function testAttributesCanBeSetInHeaders()
  {
    $conn = $this->getWorkingMockConnection();
    $swift = new EasySwift($conn);
    $headers = new MockHeaders();
    $headers->expectCallCount("set", 2);
    $headers->expectAt(0, "set", array("Foo", "test"));
    $headers->expectAt(1, "set", array("Bar", "test2"));
    $headers->expectCallCount("setAttribute", 4);
    $headers->expectAt(0, "setAttribute", array("Foo", "xxx", "yyy"));
    $headers->expectAt(1, "setAttribute", array("Bar", "abc", "def"));
    $headers->expectAt(2, "setAttribute", array("Bar", "example", "something"));
    $headers->expectAt(3, "setAttribute", array("Bar", "foo", "bar"));
    $swift->message->setHeaders($headers);
    $swift->addHeaders("Foo: test; xxx=\"yyy\"\r\nBar: test2;\r\n abc=def; example=\"something\"; foo=bar");
  }
}
