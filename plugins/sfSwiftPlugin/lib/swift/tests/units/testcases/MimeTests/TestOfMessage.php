<?php

/**
 * Swift Mailer Unit Tests for Swift_Message class.
 * There are several tests in this file which all get grouped into TestOfMessage at the end.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
 

/**
 * Swift Mailer Overall Tests on Swift_Message.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class GeneralTestOfMessage extends UnitTestCase
{
  /**
   * Tests to ensure that the required headers appear in the message structure.
   */
  public function testMessageContainsNeededHeaders()
  {
    $msg = new Swift_Message("Test Subject", "my body");
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~To: .*?\r\n".
      "From: .*?\r\n" .
      "Subject: .*?\r\n" .
      "Date: .*?\r\n" .
      "MIME-Version: 1\\.0\r\n" .
      "Content-Type: .*?\r\n" .
      "Content-Transfer-Encoding: .*?\r\n\r\n~s", $structure);
    
    $msg = new Swift_Message();
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~To: .*?\r\n".
      "From: .*?\r\n" .
      "Subject: .*?\r\n" .
      "Date: .*?\r\n" .
      "MIME-Version: 1\\.0\r\n" .
      "Content-Type: .*?\r\n" .
      "Content-Transfer-Encoding: .*?\r\n\r\n~s", $structure);
  }
  /**
   * Multiple recipients should appear as comma delimited strings.
   */
  public function testRecipientHeadersCanBeAListOfAddresses()
  {
    $headers = array("To", "Reply-To", "Cc");
    
    foreach ($headers as $field)
    {
      $method = "set" . str_replace("-", "", $field);
      $msg = new Swift_Message();
      $msg->$method("foo@bar.com");
      $structure = $msg->build()->readFull();
      $this->assertPattern(
        "~" . $field . ": foo@bar\\.com\r\n".
        ".*?" .
        "Content-Transfer-Encoding: .*?\r\n\r\n~s", $structure);
      
      $msg->$method(array("joe@bloggs.tld", "Mr Grumpy <mr@grumpy.org>"));
      $structure = $msg->build()->readFull();
      $this->assertPattern(
        "~" . $field . ": joe@bloggs\\.tld,\\s*[\t ]Mr Grumpy <mr@grumpy\\.org>\r\n".
        ".*?" .
        "Content-Transfer-Encoding: .*?\r\n\r\n~s", $structure);
        
      $msg = new Swift_Message("Some Subject");
      $msg->$method(array("joe@bloggs.tld", "Mr Grumpy <mr@grumpy.org>", "test"));
      $structure = $msg->build()->readFull();
      $this->assertPattern(
        "~" . $field . ": joe@bloggs\\.tld,\\s*[\t ]Mr Grumpy <mr@grumpy\\.org>,\\s*[\t ]test\r\n".
        ".*?" .
        "Content-Transfer-Encoding: .*?\r\n\r\n~s", $structure);
    }
  }
  /**
   * UTF8 will be auto-set if no charset was specified and UTF8 sequences are found.
   */
  public function testUTF8CharsetIsUsedIfDetectedUnlessOverridden()
  {
    $msg = new Swift_Message();
    $msg->setBody("cenvéla");
    $structure = $msg->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=utf-8~s", $structure);
    
    $msg = new Swift_Message();
    $msg->setBody("cenvela");
    $structure = $msg->build()->readFull();
    $this->assertNoPattern("~Content-Type: text/plain;\\s* charset=utf-8~s", $structure);
  }
  /**
   * Flowed formatting will be on by default (&gt; at the start of a line indicates a quote).
   */
  public function testFlowedFormattingCanBeTurnedOnOrOff()
  {
    $msg = new Swift_Message();
    $msg->setBody("some body");
    $msg->setFlowed(true);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=.*?;\\s* format=flowed~s", $structure);
    
    $msg = new Swift_Message();
    $msg->setBody("some body");
    $msg->setFlowed(false);
    $structure = $msg->build()->readFull();
    $this->assertNoPattern("~Content-Type: text/plain;\\s* charset=.*?;\\s* format=flowed~s", $structure);
  }
  /**
   * The message priority should be set as a numeric value but yield various headers.
   */
  public function testPriorityCanBeSet()
  {
    $msg = new Swift_Message();
    $msg->setPriority(1);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 1\r\nX-MSMail-Priority: High~s", $structure);
    
    $msg->setPriority(Swift_Message::PRIORITY_HIGH);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 1\r\nX-MSMail-Priority: High~s", $structure);
    
    $msg->setPriority(2);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 2\r\nX-MSMail-Priority: High~s", $structure);
    
    $msg->setPriority(3);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 3\r\nX-MSMail-Priority: Normal~s", $structure);
    
    $msg->setPriority(Swift_Message::PRIORITY_NORMAL);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 3\r\nX-MSMail-Priority: Normal~s", $structure);
    
    $msg->setPriority(4);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 4\r\nX-MSMail-Priority: Low~s", $structure);
    
    $msg->setPriority(Swift_Message::PRIORITY_LOW);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 5\r\nX-MSMail-Priority: Low~s", $structure);
    
    $msg->setPriority(5);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~X-Priority: 5\r\nX-MSMail-Priority: Low~s", $structure);
  }
  /**
   * The maximum range for the priority is 1-5.
   */
  public function testPriorityIsAdjustedIfSetTooHighOrLow()
  {
    for ($i = -10; $i < 1; $i++)
    {
      $msg = new Swift_Message();
      $msg->setPriority($i);
      $this->assertEqual(Swift_Message::PRIORITY_HIGH, $msg->getPriority());
      $structure = $msg->build()->readFull();
      $this->assertPattern("~X-Priority: 1\r\nX-MSMail-Priority: High~s", $structure);
    }
    
    for ($i = 15; $i > 5; $i--)
    {
      $msg = new Swift_Message();
      $msg->setPriority($i);
      $this->assertEqual(Swift_Message::PRIORITY_LOW, $msg->getPriority());
      $structure = $msg->build()->readFull();
      $this->assertPattern("~X-Priority: 5\r\nX-MSMail-Priority: Low~s", $structure);
    }
  }
  /**
   * Read-receipts set a Disposition-notification-to: header.
   */
  public function testReadReceiptHeadersAreSetIfRequested()
  {
    $msg = new Swift_Message();
    $msg->requestReadReceipt("foo@bar.tld");
    $structure = $msg->build()->readFull();
    $this->assertPattern("~Disposition-Notification-To: foo@bar\\.tld~s", $structure);
    
    $msg->requestReadReceipt("zip@button.tld");
    $structure = $msg->build()->readFull();
    $this->assertPattern("~Disposition-Notification-To: zip@button\\.tld~s", $structure);
    
    $msg->requestReadReceipt(false);
    $structure = $msg->build()->readFull();
    $this->assertNoPattern("~Disposition-Notification-To: .*~s", $structure);
  }
  /**
   * The body is just a bit of text that appears before any sub-parts.
   * This is incidentally where the mime warning goes.
   */
  public function testBodyBecomesMimeWarningInMultipartMessages()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foobar"));
    $msg->attach(new Swift_Message_Part("zipbutton", "text/html"));
    $msg->setBody("This is a message in MIME format");
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=.*?\r\n\r\nThis is a message in MIME format\r\n--.*~s", $structure);
  }
}


/**
 * Swift Mailer Tests For Operations on a message with Nested Subparts.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithSubParts extends UnitTestCase
{
  /**
   * When parts have been nested, the content-type should be "multipart/alternative"
   */
  public function testContentTypeIsMultipartAlternative()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foobar"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=.*~", $structure);
    
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foobar"));
    $msg->attach(new Swift_Message_Part("zipbutton", "text/html"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=.*~", $structure);
  }
  /**
   * The parts' headers should appear within the main message body, with boundaries.
   */
  public function testSubPartsAreNestedCorrectly()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foobar"));
    $msg->attach(new Swift_Message_Part("zipbutton", "text/html"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoobar\r\n--\\2\r\n" .
      ".*?\r\n\r\nzipbutton\r\n" .
      "--\\2--~s", $structure);
  }
  /**
   * The last part is shown by default.
   */
  public function testHtmlPartsAlwaysAppearAfterPlainParts()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foobar"));
    $msg->attach(new Swift_Message_Part("zipbutton", "text/html"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoobar\r\n--\\2\r\n" .
      ".*?\r\n\r\nzipbutton\r\n" .
      "--\\2--~s", $structure);
      
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("zipbutton", "text/html"));
    $msg->attach(new Swift_Message_Part("foobar"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoobar\r\n--\\2\r\n" .
      ".*?\r\n\r\nzipbutton\r\n" .
      "--\\2--~s", $structure);
  }
  /**
   * The message should re-assess it's structure when parts get removed again.
   */
  public function testPartsCanBeDetached()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Part("foo"));
    $id2 = $msg->attach(new Swift_Message_Part("bar", "text/html"));
    $structure = $msg->build()->readFull();
    
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoo\r\n--\\2\r\n" .
      ".*?\r\n\r\nbar\r\n" .
      "--\\2--~s", $structure);
    
    $msg->detach($id2);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoo\r\n" .
      "--\\2--~s", $structure);
  }
  /**
   * When all parts get removed we expect an empty message.
   */
  public function testDetatchingAllParts()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Part("foo"));
    $id2 = $msg->attach(new Swift_Message_Part("bar", "text/html"));
    $structure = $msg->build()->readFull();
    
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoo\r\n--\\2\r\n" .
      ".*?\r\n\r\nbar\r\n" .
      "--\\2--~s", $structure);
    
    $msg->detach($id2);
    $structure = $msg->build()->readFull();
    
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\nfoo\r\n" .
      "--\\2--~s", $structure);
      
    $msg->detach($id1);
    $structure = $msg->build()->readFull();
    $this->assertNoPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2~s", $structure);
  }
}


/**
 * Swift Mailer Tests on Operations for a Message with attachments.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithAttachments extends UnitTestCase
{
  /**
   * Attatchments should trigger the use of the "multipart/mixed" content-type.
   */
  public function testContentTypeIsMultipartMixed()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=.*~", $structure);
    
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $msg->attach(new Swift_Message_Attachment("zipbutton"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=.*~", $structure);
  }
  /**
   * Removing all the attachments should give an empty message.
   */
  public function testDetatchingAllAttachments()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Attachment("foo"));
    $id2 = $msg->attach(new Swift_Message_Attachment("bar"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n.*?\r\n" .
      "--\\2--~s", $structure);
    
    $msg->detach($id2);
    $structure = $msg->build()->readFull();
    $this->assertPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n.*?\r\n" .
      "--\\2--~s", $structure);
      
    $msg->detach($id1);
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~^(?:.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n.*?\r\n--\\2~s", $structure);
  }
}


/**
 * Swift Mailer Tests on Operations on a message with both attachments and subParts.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithSubPartsAndAttachments extends UnitTestCase
{
  /**
   * The overall content-type will be multipart/mixed since it's more significant than multipart/alternative.
   */
  public function testContentTypeIsMixedIfPartsAndAttachmentsAdded()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $msg->attach(new Swift_Message_Part("foo"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=.*~", $structure);
    
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("some part"));
    $msg->attach(new Swift_Message_Part("another part"));
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $msg->attach(new Swift_Message_Attachment("zipbutton"));
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/mixed;\\s* boundary=.*~", $structure);
  }
  /**
   * There should a multipart/alternative nested document inside a multipart/mixed document. Tricky!
   */
  public function testMessageIsCorrectlyStructured()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $msg->attach(new Swift_Message_Part("foo"));
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
    
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("some part"));
    $msg->attach(new Swift_Message_Part("another part"));
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $msg->attach(new Swift_Message_Attachment("zipbutton"));
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * It shouldn't matter if we make changes to the message once it's been rendered and cached once.
   */
  public function testMessageRemainsCorrectlyStructuredWhenPartsAreAddedAfterCompilation()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("foobar"));
    $msg->attach(new Swift_Message_Part("foo"));
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
    $msg->attach(new Swift_Message_Part("bar"));
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * The message should reconsider it's strucuture when sub-parts are removed.
   */
  public function testPartsCanBeDetatched()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Part("some part"));
    $id2 = $msg->attach(new Swift_Message_Part("another part"));
    $id3 = $msg->attach(new Swift_Message_Attachment("foobar"));
    $id4 = $msg->attach(new Swift_Message_Attachment("zipbutton"));
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
    
    $msg->detach($id2);
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * If all sub-parts are removed the message should act like we just added attachments (basic multipart/mixed).
   */
  public function testDetachingAllSubParts()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Part("some part"));
    $id2 = $msg->attach(new Swift_Message_Part("another part"));
    $id3 = $msg->attach(new Swift_Message_Attachment("foobar"));
    $id4 = $msg->attach(new Swift_Message_Attachment("zipbutton"));
    
    $msg->detach($id2);
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
    
    $msg->detach($id1);
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~Content-Type: multipart/alternative~", $structure);
    $this->assertNoPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;.*?\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * If all attachments are removed the message should behave like a basic multipart/alternative message.
   */
  public function testDetatchingAllAttachments()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Part("some part"));
    $id2 = $msg->attach(new Swift_Message_Part("another part"));
    $id3 = $msg->attach(new Swift_Message_Attachment("foobar"));
    $id4 = $msg->attach(new Swift_Message_Attachment("zipbutton"));
    
    $msg->detach($id4);
    $structure = $msg->build()->readFull();
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
    
    $msg->detach($id3);
    $structure = $msg->build()->readFull();
    $this->assertNoPattern("~.*?Content-Type: multipart/mixed~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
    //$this->dump($structure);
  }
}


/**
 * Swift Mailer Tests on Operations on a message with Embedded files.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithEmbeddedFiles extends UnitTestCase
{
  /**
   * Embedded files appear in a multipart/related message as inline attachments.
   */
  public function testMimeTypeIsRelated()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $this->assertEqual("multipart/related", $msg->getContentType());
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/related;\\s* boundary=.*~", $structure);
    
    $msg->attach(new Swift_Message_EmbeddedFile(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg")));
    $this->assertEqual("multipart/related", $msg->getContentType());
    $structure = $msg->build()->readFull();
    $this->assertPattern("~(.(?!\r\n\r\n))*?\r\nContent-Type: multipart/related;\\s* boundary=.*~", $structure);
  }
  /**
   * The embedded files should be nested in the message with boundaries separating them.
   */
  public function testMessageStructure()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $msg->attach(new Swift_Message_EmbeddedFile("bar"));
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * The Content-ID value should be returned so it can be passed as a src value in HTML for example.
   */
  public function testCIDIsReturned()
  {
    $msg = new Swift_Message();
    $this->assertPattern("/^cid:.+/i", $msg->attach(new Swift_Message_EmbeddedFile("foo")));
    
    $this->assertPattern("/^cid:.+/i", $msg->attach(new Swift_Message_EmbeddedFile("bar")));
  }
}


/**
 * Swift Mailer Tests on a message with Embedded files and subParts.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithSubPartsAndEmbeddedFiles extends UnitTestCase
{
  /**
   * The multipart/related content-type is more significant than the multipart/alternative type.
   */
  public function testMimeTypeIsRelated()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foo"));
    $this->assertEqual("multipart/alternative", $msg->getContentType());
    $msg->attach(new Swift_Message_EmbeddedFile("bar"));
    $this->assertEqual("multipart/related", $msg->getContentType());
  }
  /**
   * There should be a multipart/alternative document nested inside a multipart/related one.
   */
  public function testMessageStructure()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $msg->attach(new Swift_Message_EmbeddedFile("bar"));
    $msg->attach(new Swift_Message_Part("test"));
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4--\r\n\\s*" .
      "--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * If all sub-parts are removed we expect the same structure as if we only added embedded files.
   */
  public function testRemovingAllSubParts()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id2 = $msg->attach(new Swift_Message_Part("test"));
    
    $msg->detach($id2);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~.*?Content-Type: multipart/alternative~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * If all the embedded files are removed we expect the same structure as a basic multipart/alternative message.
   */
  public function testRemovingAllEmbeddedFiles()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id2 = $msg->attach(new Swift_Message_Part("test"));
    
    $msg->detach($id1);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~.*?Content-Type: multipart/related~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
}


/**
 * Swift Mailer Tests on operations on a message with both attachments and embedded files.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithAttachmentsAndEmbeddedFiles extends UnitTestCase
{
  /**
   * The multipart/mixed content-type is more significant than multipart/related.
   */
  public function testMimeTypeIsMixed()
  {
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("foo"));
    $this->assertEqual("multipart/alternative", $msg->getContentType());
    $msg->attach(new Swift_Message_EmbeddedFile("bar"));
    $this->assertEqual("multipart/related", $msg->getContentType());
    $msg->attach(new Swift_Message_Attachment("zip"));
    $this->assertEqual("multipart/mixed", $msg->getContentType());
    $msg->attach(new Swift_Message_EmbeddedFile("button"));
    $this->assertEqual("multipart/mixed", $msg->getContentType());
  }
  /**
   * Removing all embedded files should give a basic multipart/mixed message.
   */
  public function testRemovingAllEmbeddedFiles()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id2 = $msg->attach(new Swift_Message_Attachment("test"));
    
    $msg->detach($id1);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~.*?Content-Type: multipart/related~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * Removing all attachments should give a basic multipart/related message.
   */
  public function testRemovingAllAttachments()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id2 = $msg->attach(new Swift_Message_Attachment("test"));
    
    $msg->detach($id2);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~.*?Content-Type: multipart/mixed~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
}


/**
 * Swift Mailer Tests on a complex message with all of embedded files, attachments and subParts.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessageWithAttachments_EmbeddedFiles_AndSubParts extends UnitTestCase
{
  /**
   * The structure hierarchy should start with multipart/mixed, then nest multipart/related, followed by a nested multipart/alternative.
   */
  public function testMessageStructure()
  {
    $re = "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\5" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\6\r\n" .
      ".*?\r\n--\\6--\r\n\\s*" .
      "--\\4\r\n" .
      ".*?\r\n--\\4--\r\n\\s*" .
      "--\\2\r\n" .
      ".*?\r\n--\\2--~s";
    
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("test"));
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $msg->attach(new Swift_Message_Attachment("bar"));
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern($re, $structure);
    
    //Just double-checking by doing it in different orders
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $msg->attach(new Swift_Message_Part("test"));
    $msg->attach(new Swift_Message_Attachment("bar"));
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern($re, $structure);
      
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("bar"));
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $msg->attach(new Swift_Message_Part("test"));
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern($re, $structure);
      
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Attachment("bar"));
    $msg->attach(new Swift_Message_Part("test"));
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern($re, $structure);
    
    $msg = new Swift_Message();
    $msg->attach(new Swift_Message_Part("test"));
    $msg->attach(new Swift_Message_Attachment("bar"));
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern($re, $structure);
      
    $msg = new Swift_Message();
    
    $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $msg->attach(new Swift_Message_Attachment("bar"));
    $msg->attach(new Swift_Message_Part("test"));
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertPattern($re, $structure);
  }
  /**
   * Removing all the embedded files should give a multipart/mixed with a nested multipart/alternative message.
   */
  public function testRemovingAllEmbeddedFiles()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Attachment("bar"));
    $id2 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id3 = $msg->attach(new Swift_Message_Part("test"));
    
    $msg->detach($id2);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~Content-Type: multipart/related~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * Removing all the attachments should give a multipart/related message with a nested multipart/alternative document.
   */
  public function testRemovingAllAttachments()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Attachment("bar"));
    $id2 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id3 = $msg->attach(new Swift_Message_Part("test"));
    
    $msg->detach($id1);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~Content-Type: multipart/mixed~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/alternative;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
  /**
   * Removing all subParts should give a multipart/mixed message with a nested multipart/related document.
   */
  public function testRemovingAllSubParts()
  {
    $msg = new Swift_Message();
    $id1 = $msg->attach(new Swift_Message_Attachment("bar"));
    $id2 = $msg->attach(new Swift_Message_EmbeddedFile("foo"));
    $id3 = $msg->attach(new Swift_Message_Part("test"));
    
    $msg->detach($id3);
    
    $structure = $msg->build()->readFull();
    //$this->dump($structure);
    $this->assertNoPattern("~Content-Type: multipart/alternative~", $structure);
    $this->assertPattern(
      "~.*?Content-Type: multipart/mixed;\\s* boundary=(\"?)(.*?)\\1\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2\r\n" .
      "Content-Type: multipart/related;\\s* boundary=(\"?)(.*?)\\3\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\4\r\n" .
      ".*?\r\n--\\4--" .
      "\\s*\r\n--\\2\r\n" .
      ".*?\r\n\r\n" .
      ".*?\r\n--\\2--~s",
      $structure);
  }
}


/**
 * Swift Mailer Group Test for all the smaller message tests.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMessage extends GroupTest
{
  /**
   * Constructor.
   * Loads in all the testcases.
   */
  public function __construct()
  {
    parent::__construct("TestOfMessage");
    $this->addTestCase(new GeneralTestOfMessage());
    $this->addTestCase(new TestOfMessageWithSubParts());
    $this->addTestCase(new TestOfMessageWithAttachments());
    $this->addTestCase(new TestOfMessageWithSubPartsAndAttachments());
    $this->addTestCase(new TestOfMessageWithEmbeddedFiles());
    $this->addTestCase(new TestOfMessageWithSubPartsAndEmbeddedFiles());
    $this->addTestCase(new TestOfMessageWithAttachmentsAndEmbeddedFiles());
    $this->addTestCase(new TestOfMessageWithAttachments_EmbeddedFiles_AndSubParts());
  }
}
