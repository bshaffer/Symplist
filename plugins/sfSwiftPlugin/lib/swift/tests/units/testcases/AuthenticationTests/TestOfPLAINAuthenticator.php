<?php

/**
 * Swift Mailer Unit Test Case of PLAIN authentication.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */


/**
 * Swift Mailer Unit Test Case of PLAIN authentication.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfPLAINAuthenticator extends AbstractTestOfAuthenticator
{
  /**
   * Returns the name of the authentication method (i.e. PLAIN)
   * @return string
   */
  public function getAuthMethod()
  {
    return "PLAIN";
  }
  /**
   * Returns an instance of the authenticator.
   * @return Swift_Authenticator_PLAIN
   */
  public function getAuthObject()
  {
    $auth = new Swift_Authenticator_PLAIN();
    return $auth;
  }
  /**
   * Test that null bytes are used as separators.
   */
  public function testAuthenticatorSendsCorrectlyFormattedNullDelimitedRequests()
  {
    $auth = $this->getAuthObject();
    $smtp = new PartialSmtpConnectionIO();
    $smtp->setReturnValueAt(0, "read", "235 Authenticated");
    $smtp->expectAt(0, "write", array("AUTH PLAIN " . base64_encode("foo\0foo\0bar"), "*"));
    
    $smtp->setExtension("AUTH", array("PLAIN"));
    $smtp->setUsername("foo");
    $smtp->setPassword("bar");
    $smtp->attachAuthenticator($auth);
    $smtp->postConnect(new Swift($smtp, "xx", Swift::NO_START));
  }
  /**
   * Test that RSET is issued after a bad response.
   */
  public function testRSETIsSentOnFailure()
  {
    try {
      $auth = $this->getAuthObject();
      $smtp = new PartialSmtpConnectionIO();
      $smtp->setReturnValueAt(0, "read", "500 Something");
      $smtp->expectAt(0, "write", array("AUTH PLAIN " . base64_encode("foo\0foo\0bar"), "*"));
      $smtp->expectAt(1, "write", array("RSET", "*"));
      
      $smtp->setExtension("AUTH", array("PLAIN"));
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
