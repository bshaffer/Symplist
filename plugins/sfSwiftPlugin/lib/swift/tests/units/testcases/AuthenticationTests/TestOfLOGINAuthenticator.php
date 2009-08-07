<?php

/**
 * Swift Mailer Unit Test Case of LOGIN authentication.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */


/**
 * Swift Mailer Unit Test Case of LOGIN authentication.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfLOGINAuthenticator extends AbstractTestOfAuthenticator
{
  /**
   * Returns the name of the authentication method (i.e. LOGIN)
   * @return string
   */
  public function getAuthMethod()
  {
    return "LOGIN";
  }
  /**
   * Returns an instance of the authenticator.
   * @return Swift_Authenticator_LOGIN
   */
  public function getAuthObject()
  {
    $auth = new Swift_Authenticator_LOGIN();
    return $auth;
  }
  /**
   * Test that base64 is used.
   */
  public function testAuthenticatorSendsCorrectlyFormattedBase64EncodedRequests()
  {
    $auth = $this->getAuthObject();
    $smtp = new PartialSmtpConnectionIO();
    $smtp->setReturnValueAt(0, "read", "334 " . base64_encode("username:"));
    $smtp->setReturnValueAt(1, "read", "334 " . base64_encode("password:"));
    $smtp->setReturnValueAt(2, "read", "235 Authenticated");
    $smtp->expectAt(0, "write", array("AUTH LOGIN", "*"));
    $smtp->expectAt(1, "write", array(base64_encode("foo"), "*"));
    $smtp->expectAt(2, "write", array(base64_encode("bar"), "*"));
    
    $smtp->setExtension("AUTH", array("LOGIN"));
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
      $smtp->setReturnValueAt(0, "read", "334 " . base64_encode("username:"));
      $smtp->setReturnValueAt(1, "read", "400 No");
      $smtp->setReturnValueAt(2, "read", "400 No");
      $smtp->expectAt(0, "write", array("AUTH LOGIN", "*"));
      $smtp->expectAt(1, "write", array(base64_encode("foo"), "*"));
      $smtp->expectAt(2, "write", array("RSET", "*"));
      $smtp->setExtension("AUTH", array("LOGIN", "*"));
      $smtp->setUsername("foo");
      $smtp->setPassword("bar");
      $smtp->attachAuthenticator($auth);
      $smtp->postConnect(new Swift($smtp, "xx", Swift::NO_START));
      $this->fail("This should have failed since a 334 and 235 response were wanted.");
    } catch (Swift_ConnectionException $e) {
      $this->pass();
    }
  }
}
