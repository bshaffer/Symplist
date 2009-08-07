<?php

Mock::Generate("Swift_Authenticator", "MockAuthenticator");

class TestOfSMTPConnection extends UnitTestCase
{
  public function testPortDefaultsTo25ForUnencryptedConnections()
  {
    $conn = new Swift_Connection_SMTP();
    $this->assertEqual(25, $conn->getPort());
  }
  
  public function testPortDefaultsTo465ForSSLConnections()
  {
    $conn = new Swift_Connection_SMTP("localhost", null, Swift_Connection_SMTP::ENC_SSL);
    $this->assertEqual(465, $conn->getPort());
  }
  
  public function testPortDefaultsTo465ForTLSConnections()
  {
    $conn = new Swift_Connection_SMTP("localhost", null, Swift_Connection_SMTP::ENC_TLS);
    $this->assertEqual(465, $conn->getPort());
  }
  
  public function testAuthenticationIsOnlyInvokedIfUsernameAndPasswordSet()
  {
    $auth = new MockAuthenticator();
    $auth->setReturnValue("isAuthenticated", true);
    $auth->setReturnValue("getAuthExtensionName", "foo");
    $auth->expectOnce("isAuthenticated");
    
    $conn = new Swift_Connection_SMTP();
    $conn->setExtension("AUTH", array("foo"));
    $conn->attachAuthenticator($auth);
    $conn->setUsername("xxx");
    $conn->setPassword("yyyy");
    $conn->postConnect(new Swift($conn, "xxx", Swift::NO_START));
    
    $auth = new MockAuthenticator();
    $auth->setReturnValue("isAuthenticated", true);
    $auth->setReturnValue("getAuthExtensionName", "foo");
    $auth->expectNever("isAuthenticated");
    
    $conn = new Swift_Connection_SMTP();
    $conn->setExtension("AUTH", array("foo"));
    $conn->attachAuthenticator($auth);
    //No username/password set
    $conn->postConnect(new Swift($conn, "xxx", Swift::NO_START));
  }
  
  public function testAuthIsForcedIfCredentialsSet()
  {
    $conn = new Swift_Connection_SMTP();
    $this->assertFalse($conn->hasExtension("AUTH"));
    $conn->setUsername("xxx");
    $conn->setPassword("yyyy");
    
    try {
      $conn->postConnect(new Swift($conn, "xxx", Swift::NO_START));
    } catch (Exception $e) {}
    
    $this->assertTrue($conn->hasExtension("AUTH"));
  }
  
  public function testAuthExtensionsWithAsteriskAsNameAreRunAlways()
  {
    $auth = new MockAuthenticator();
    $auth->setReturnValue("isAuthenticated", true);
    $auth->setReturnValue("getAuthExtensionName", "*foo");
    $auth->expectOnce("isAuthenticated");
    
    $conn = new Swift_Connection_SMTP();
    $conn->setExtension("AUTH", array("not-an-asterisk"));
    $conn->attachAuthenticator($auth);
    $conn->setUsername("xxx");
    $conn->setPassword("yyyy");
    $conn->postConnect(new Swift($conn, "xxx", Swift::NO_START));
  }
}
