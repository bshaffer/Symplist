<?php

/**
 * Swift Mailer abstract test case for Authenticator tests.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

if (!class_exists("PartialSmtpConnectionIO")) Mock::GeneratePartial("Swift_Connection_SMTP", "PartialSmtpConnectionIO", array("read", "write"));

/**
 * Swift Mailer abstract test case for Authenticator tests.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
abstract class AbstractTestOfAuthenticator extends UnitTestCase
{
  /**
   * Test that RSET is issued at the appropriate time.
   */
  abstract public function testRSETIsSentOnFailure();
  /**
   * Get the name of the authentication mechanism (e.g. LOGIN)
   * @return string
   */
  abstract public function getAuthMethod();
  /**
   * Get the authenticator instance.
   * @return Swift_Authenticator
   */
  abstract public function getAuthObject();
  /**
   * Test that an exception is thrown is a bad response is sent (test uses a 500 response)
   */
  public function testExceptionIsThrownIfBadResponseReceived()
  {
    try {
      $auth = $this->getAuthObject();
      $smtp = new PartialSmtpConnectionIO();
      $smtp->setReturnValueAt(0, "read", "500 Something");
      
      $smtp->setExtension("AUTH", array($this->getAuthMethod()));
      $smtp->setUsername("foo");
      $smtp->setPassword("bar");
      $smtp->attachAuthenticator($auth);
      $smtp->postConnect(new Swift($smtp, "xx", Swift::NO_START));
      $this->fail("This should have thrown an exception since a 235 response was needed.");
    } catch (Swift_ConnectionException $e) {
      $this->pass();
    }
  }
}