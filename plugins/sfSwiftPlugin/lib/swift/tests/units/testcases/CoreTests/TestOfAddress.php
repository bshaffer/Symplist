<?php

/**
 * Swift Mailer Unit Test Case for Swift_Address
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
 
/**
 * Swift Mailer Unit Test Case for Swift_Address
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfAddress extends UnitTestCase
{
  /**
   * Checks the validity of the address (RFC 2822)
   */
  public function testAddressIsBuiltInCorrectFormat()
  {
    $address = new Swift_Address("foo@bar.com");
    $this->assertEqual("foo@bar.com", $address->build());
    $address->setName("Foo");
    $this->assertEqual("Foo <foo@bar.com>", $address->build());
    $address->setAddress("joe@bloggs.com");
    $this->assertEqual("Foo <joe@bloggs.com>", $address->build());
    
    $address = new Swift_Address("zip@button.com", "Zip");
    $this->assertEqual("Zip <zip@button.com>", $address->build());
  }
  /**
   * Checks the address can be used in SMTP envelopes (no name).
   */
  public function testAddressCanBeReturnedForSMTPEnvelope()
  {
    $address = new Swift_Address("foo@bar.xxx", "FooBar");
    $this->assertEqual("<foo@bar.xxx>", $address->build(true));
    
    $address->setAddress("zip@button.com");
    $this->assertEqual("<zip@button.com>", $address->build(true));
  }
}
