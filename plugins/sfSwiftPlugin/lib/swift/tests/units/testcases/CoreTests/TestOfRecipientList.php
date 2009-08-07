<?php

/**
 * Swift Mailer Unit Test Case for Swift_RecipientList.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

/**
 * Swift Mailer Unit Test Case for Swift_RecipientList.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfRecipientList extends UnitTestCase
{
  /**
   * Test that addresses can be added in a flexible manner using Swift_Address, or as a string.
   */
  public function testAddressCanBeAddedAsStringOrSwift_Address()
  {
    $list = new Swift_RecipientList();
    $list->addTo(new Swift_Address("foo@bar.tld", "FooBar"));
    $to1 = $list->getTo();
    
    $list = new Swift_RecipientList();
    $list->addTo("foo@bar.tld", "FooBar");
    $to2 = $list->getTo();
    
    $this->assertEqual($to1, $to2);
  }
  /**
   * Test that addresses are always returned as swift_Address instances.
   */
  public function testReturnedListsAreALWAYSOfTypeSwift_Address()
  {
    $list = new Swift_RecipientList();
    $list->addCc(new Swift_Address("foo@bar.com"));
    $list->addCc("joe@bloggs.com", "Joe");
    $list->addCc("jim@somewhere.co.uk");
    
    foreach ($list->getCc() as $entry)
    {
      $this->assertIsA($entry, "Swift_Address");
    }
  }
  /**
   * Test that only no duplicates can exist.
   */
  public function testDuplicateEntriesInSameFieldAreOverWritten()
  {
    $list = new Swift_RecipientList();
    $list->addCc(new Swift_Address("foo@bar.com"));
    $list->addCc("joe@bloggs.com", "Joe");
    $list->addCc("jim@somewhere.co.uk");
    $list->addCc("foo@bar.com", "Foo");
    $this->assertEqual(3, count($list->getCc()));
  }
  /**
   * Test that addresses can be taken back out of the list once added.
   */
  public function testAddressesCanBeRemoved()
  {
    $list = new Swift_RecipientList();
    $list->addBcc(new Swift_Address("foo@bar.com"));
    $list->addBcc("joe@bloggs.com", "Joe");
    $list->addBcc("jim@somewhere.co.uk");
    $list->removeBcc("joe@bloggs.com");
    $this->assertEqual(array("foo@bar.com", "jim@somewhere.co.uk"), array_keys($list->getBcc()));
  }
  /**
   * Test that addresses can be taken back out of the list by passing the Swift_Address instance back in.
   */
  public function testAddressesCanBeRemovedUsingObject()
  {
    $list = new Swift_RecipientList();
    $foo = new Swift_Address("foo@bar.com");
    $list->addTo($foo);
    $list->addTo("joe@bloggs.com", "Joe");
    $list->addTo("jim@somewhere.co.uk");
    $list->removeTo($foo);
    $this->assertEqual(array("joe@bloggs.com", "jim@somewhere.co.uk"), array_keys($list->getTo()));
  }
  
  public function testArraysCanBeAdded()
  {
    $list = new Swift_RecipientList();
    $list->addTo("a@a");
    $list->addTo(array("b@b", "a@a", "c@c"));
    $list->addTo(array(new Swift_Address("d@d", "D"), "e@e"), "E");
    $this->assertEqual(array("a@a", "b@b", "c@c", "d@d", "e@e"), array_keys($list->getTo()));
  }
}
