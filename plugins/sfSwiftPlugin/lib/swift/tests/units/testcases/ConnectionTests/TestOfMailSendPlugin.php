<?php

/**
 * Swift Mailer Unit Tests for the MailSend Plugin needed for NativeMail connection.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

error_reporting(E_ALL);

/**
 * Custom Expectation base class since SimpleTest mocks didn't offer the functionality to fetch args.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class CustomMailSendExpectation extends Swift_Plugin_MailSend
{
  /**
   * The instance of the test case, so we can pass or fail.
   * @var UnitTestCase
   */
  protected $testcase = null;
  
  /**
   * Ctor.
   * @param UnitTestCase The instance of the test being executed.
   */
  public function __construct($test)
  {
    parent::__construct();
    $this->testcase = $test;
  }
}

//Some custom expectations - ouch, yes, yes I know, perhaps I've dug myself into a hole here!

/**
 * An (ad-hoc) expectation to ensure no To: field is passed in the headers.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class MailSendExpectingNoTo extends CustomMailSendExpectation
{
  /**
   * Overrides the plugin's doMail() function so we can catch the args rather than actually sending.
   * Checks if $headers contains a To: field.
   * @param string Recipients sent to
   * @param string The subject of the message
   * @param string The message body
   * @param Swift_Message_Headers The headers to send
   */
  public function doMail($to, $subject, $message, $headers)
  {
    if ($headers->has("To")) $this->testcase->fail("The headers should NOT have a To field in them");
    else $this->testcase->pass();
  }
}

/**
 * An (ad-hoc) expectation to ensure no Subject: field is passed in the headers.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class MailSendExpectingNoSubject extends CustomMailSendExpectation
{
  /**
   * Overrides the plugin's doMail() function so we can catch the args rather than actually sending.
   * Checks if $headers contains a Subject: field.
   * @param string Recipients sent to
   * @param string The subject of the message
   * @param string The message body
   * @param Swift_Message_Headers The headers to send
   */
  public function doMail($to, $subject, $message, $headers)
  {
    if ($headers->has("Subject")) $this->testcase->fail("The headers should NOT have a Subject field in them");
    else $this->testcase->pass();
  }
}

/**
 * An (ad-hoc) expectation to ensure all required header fields are passed in the headers.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class MailSendExpectingVitalHeaders extends CustomMailSendExpectation
{
  /**
   * Overrides the plugin's doMail() function so we can catch the args rather than actually sending.
   * Checks if $headers contains a number of needed fields.
   * @param string Recipients sent to
   * @param string The subject of the message
   * @param string The message body
   * @param Swift_Message_Headers The headers to send
   */
  public function doMail($to, $subject, $message, $headers)
  {
    if (!$headers->has("From")) $this->testcase->fail("The headers MUST have a From field in them");
    else $this->testcase->pass();
    if (!$headers->has("Return-Path")) $this->testcase->fail("The headers MUST have a Return-Path field in them");
    else $this->testcase->pass();
    if (!$headers->has("Content-Type")) $this->testcase->fail("The headers MUST have a Content-Type field in them");
    else $this->testcase->pass();
    if (!$headers->has("Content-Transfer-Encoding")) $this->testcase->fail("The headers MUST have a Content-Transfer-Encoding field in them");
    else $this->testcase->pass();
  }
}

/**
 * A subclass of the MailSend plugin which never sends, but allow retreival of arguments passed.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class MailSendWithGetDoMailArgs extends Swift_Plugin_MailSend
{
  /**
   * The arguments passed to doMail()
   * @var array
   * @see getDoMailArgs
   */
  protected $args = array();
  
  /**
   * Get the arguments that were passed to doMail()
   * @return array
   */
  public function getDoMailArgs()
  {
    return $this->args;
  }
  /**
   * Overrides the doMail() method of the plugin to capture arguments.
   */
  public function doMail()
  {
    foreach (func_get_args() as $v)
    {
      if (is_object($v)) $this->args[] = clone $v;
      else $this->args[] = $v;
    }
  }
}

/**
 * Swift Mailer Unit Test Case for the MailSend Plugin needed for NativeMail connection.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfMailSendPlugin extends UnitTestCase
{
  /**
   * Checks that no To: field is passed in $headers.
   */
  public function testHeadersDoNotContainThe_To_Field()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendExpectingNoTo($this);
    
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    
    $swift->send($message, $recipients, $sender);
  }
  /**
   * Checks that no Subject: field is passed in $headers
   */
  public function testHeadersDoNotContainThe_Subject_Field()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendExpectingNoSubject($this);
    
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    
    $swift->send($message, $recipients, $sender);
  }
  /**
   * Tests that all needed headers are passed.
   */
  public function testVitalHeadersAreIncluded()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendExpectingVitalHeaders($this);
    
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    
    $swift->send($message, $recipients, $sender);
  }
  /**
   * Windows uses SMTP, so CRLF is needed for the EOL.
   */
  public function testLineEndingIsCRLFForWindows()
  {
    //Windows users will be using SMTP and therefore need CRLF,
    // *nix and OS X users will be using Sendmail in "-t" mode and therefore need LF
    
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $mailsend->setOS("WIN");
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $body_orig = $message->build()->readFull();
    $this->assertPattern("~\r\n~", $body);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertNoPattern("~(?<!\r)\n~", $passed[2]);
    $this->assertNoPattern("~(?<!\r)\n~", $passed[3]->build());
  }
  /**
   * Unix-like systems use sendmail in -t mode so LF is needed for the EOL.
   */
  public function testLineEndingIsLFForOtherSystems()
  {
    //Windows users will be using SMTP and therefore need CRLF,
    // *nix and OS X users will be using Sendmail in "-t" mode and therefore need LF
    
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $mailsend->setOS("MAC");
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $body_orig = $message->build()->readFull();
    $this->assertPattern("~\r\n~", $body_orig);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertNoPattern("~\r\n~", $passed[2]);
    $this->assertNoPattern("~\r\n~", $passed[3]->build());
    
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $mailsend->setOS("UNIX");
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $body_orig = $message->build()->readFull();
    $this->assertPattern("~\r\n~", $body_orig);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertNoPattern("~\r\n~", $passed[2]);
    $this->assertNoPattern("~\r\n~", $passed[3]->build());
  }
  /**
   * mail() doesn't like line breaks in the recipients field.
   */
  public function testRecipientsArePassedCommaSeparatedWithLWSP() //as in "no line breaks"
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $mailsend->setOS("UNIX"); //Just so we have a common format to test with
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_RecipientList();
    $recipients->addTo("foo@bar.com", "Foo bar");
    $recipients->addTo("zip@button.com", "ZipButton");
    $recipients->addTo("fred@somewhere.tld");
    $recipients->addTo("joe@bloggs.com", "Ol' Joe");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertEqual("Foo bar <foo@bar.com>, ZipButton <zip@button.com>, fred@somewhere.tld, Ol' Joe <joe@bloggs.com>", $passed[0]);
  }
  /**
   * Windows creates a lovely mess if the <> quotes are sent.
   */
  public function testBracesAreLeftOutOfToFieldIfOSIsWindows()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $mailsend->setOS("WIN");
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_RecipientList();
    $recipients->addTo("foo@bar.com", "Foo bar");
    $recipients->addTo("zip@button.com", "ZipButton");
    $recipients->addTo("fred@somewhere.tld");
    $recipients->addTo("joe@bloggs.com", "Ol' Joe");
    $sender = "foobar@bar.com";
    $subject = "Foo Bar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertEqual("foo@bar.com, zip@button.com, fred@somewhere.tld, joe@bloggs.com", $passed[0]);
  }
  /**
   * The subject needs to be encoded externally, mail() will just mess it up if not.
   */
  public function testSubjectIsProvidedInItsEncodedFormatIfNonAsciiIsUsed()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "cenvéla";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $this->assertPattern("~\r\n~", $body);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertPattern("~^=\\?[^\\?]+\\?[QB]\\?.*?\\?=\$~sm", $passed[1]);
  }
  /**
   * The subject should not be encoded if 7-bit ascii is used.
   */
  public function testSubjectIsProvidedUnencodedIfAsciiIsUsed()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $mailsend = new MailSendWithGetDoMailArgs();
    $swift->attachPlugin($mailsend, "_MAIL_SEND"); //Override the MailSend plugin with a custom mock
    
    $recipients = new Swift_Address("test@bar.tld", "Test");
    $sender = "foobar@bar.com";
    $subject = "foobar";
    $body = "Foo test\r\nBar";
    $message = new Swift_Message($subject, $body);
    $this->assertPattern("~\r\n~", $body);
    $swift->send($message, $recipients, $sender);
    $passed = $mailsend->getDoMailArgs();
    $this->assertEqual("foobar", $passed[1]);
  }
}
