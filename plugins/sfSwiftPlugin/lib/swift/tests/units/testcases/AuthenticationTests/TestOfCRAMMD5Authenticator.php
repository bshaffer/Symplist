<?php

/**
 * Swift Mailer Unit Test Case of CRAM-MD5 authentication.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */


/**
 * Swift Mailer Unit Test Case of CRAM-MD5 authentication.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfCRAMMD5Authenticator extends AbstractTestOfAuthenticator
{
  /**
   * Returns the name of the authentication method (i.e. CRAM-MD5)
   * @return string
   */
  public function getAuthMethod()
  {
    return "CRAM-MD5";
  }
  /**
   * Returns an instance of the authenticator.
   * @return Swift_Authenticator_CRAMMD5
   */
  public function getAuthObject()
  {
    $auth = new Swift_Authenticator_CRAMMD5();
    return $auth;
  }
  /**
   * Test that cram md5 digests are used.
   */
  public function testAuthenticatorSendsCorrectlyFormattedHashedRequests()
  {
    $auth = $this->getAuthObject();
    $smtp = new PartialSmtpConnectionIO();
    $smtp->setReturnValueAt(0, "read", "334 " . base64_encode("<xxx.yyy@domain.tld>"));
    $smtp->setReturnValueAt(1, "read", "235 Authenticated");
    $smtp->expectAt(0, "write", array("AUTH CRAM-MD5", "*"));
    $smtp->expectAt(1, "write", array(base64_encode("foo " . Swift_Authenticator_CRAMMD5::generateCRAMMD5Hash("bar", "<xxx.yyy@domain.tld>")), "*"));
    
    $smtp->setExtension("AUTH", array("CRAM-MD5"));
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
      $smtp->expectAt(1, "write", array("RSET", "*"));
      $smtp->setExtension("AUTH", array("CRAM-MD5"));
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
