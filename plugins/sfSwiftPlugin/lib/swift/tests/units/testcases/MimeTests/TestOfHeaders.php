<?php

class TestOfHeaders extends UnitTestCase
{
  public function testHeadersAreAddedButNotDuplicated()
  {
    $headers = new Swift_Message_Headers();
    $size1 = count($headers->getList());
    $headers->set("Foo", "bar");
    $size2 = count($headers->getList());
    $this->assertTrue($size1 < $size2);
    $headers->set("Bar", "xxx");
    $size3 = count($headers->getList());
    $this->assertTrue($size2 < $size3);
    $headers->set("Foo", "newFoo");
    $size4 = count($headers->getList());
    $this->assertEqual($size3, $size4);
    $headers->set("Bar", "newBar");
    $size5 = count($headers->getList());
    $this->assertEqual($size4, $size5);
    $headers->set("My-Header", "my value");
    $size6 = count($headers->getList());
    $this->assertTrue($size5 < $size6);
  }
  
  public function testHeadersAreEncodedAccordingToSpecification()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Subject", "cenvéla");
    $headers->forceEncoding();
    $headers->setEncoding("Q");
    $structure = $headers->build();
    $this->assertPattern("/^.*?Subject: =\\?[^\\?]+\\?Q\\?.*?\\?=\$/sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Subject", "aicassë");
    $headers->forceEncoding();
    $headers->setEncoding("Base64");
    $structure = $headers->build();
    $this->assertPattern("/^.*?Subject: =\\?[^\\?]+\\?B\\?.*?\\?=\$/sm", $structure);
  }
  
  public function testHeadersAreNotLongerThan76CharsLong()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Normal-Header", "foo");
    $headers->set(
      "Really-Long-Header",
      "abcdefghijklmn opqrstuvwxzyabc defghijklm" .
      "nopqrst uvwxzyabcdefghijkl mnopqrst uvwxzy" .
      "abcdefg hijklmnopqrstuvw xzyabcdef ghijklm" .
      "nopqrstu vwxzyabcdefghijklm nopqrs tuvwxzy" .
      "abcdefg hijklmnopqrstu vwxzyabcde fghijklm" .
      "nopqrstu vwxzyabcde fghijklm nopqrst uvwxzy");
    $headers->setEncoding("Q");
    $structure = $headers->build();
    //$this->dump($structure);
    $lines = explode("\r\n", $structure);
    foreach ($lines as $line)
    {
      $line .= "\r\n"; //The bit lost from explode
      $this->assertWithinMargin(0, strlen($line), 76);
    }
    
    $headers = new Swift_Message_Headers();
    $headers->set("Normal-Header", "foo");
    $headers->set(
      "Really-Long-Header",
      "abcdefg hijklmnopqrs tuvwxzyab cdefghijklm" .
      "nopqrstuv wxzyabcd efg hijklmn opqr stuvwxzy" .
      "abcde fghijklmnop qrstuvwxz yabc defghijk lm" .
      "nop qrstuvwx zyab cdefghijklmn opqrs tuvwxzy" .
      "abcd efghijklmnopqr stuvwxzyabc defghi jklm" .
      "nopqrs tuvwxzyabcde fghijklmno pqrstuv wxzy");
    $headers->setEncoding("B");
    $structure = $headers->build();
    
    $lines = explode("\r\n", $structure);
    foreach ($lines as $line)
    {
      $line .= "\r\n"; //The bit lost from explode
      $this->assertWithinMargin(0, strlen($line), 76);
    }
    
    //Contains some LF chars, thus will be encoded
    $headers = new Swift_Message_Headers();
    $headers->set("Normal-Header", "foo");
    $headers->set(
      "Really-Long-Header",
      "abcde fghijklmn\nopqrst uvwxzyabcdefgh ijklm" .
      "nopqrs tuvwxzyabcdefghijk lmnopqrs tuvwxzy" .
      "abcdefghijklm nopqrstuvwxzya bcdefghij klm" .
      "nopqrs tuvwxzyabcdefg hijklmno pqrstuvwxzy" .
      "abcdef ghijklmnopq\nrstu vwxzyabc defghijklm" .
      "nopqrs tuvwxzya bcdefghijkl mnopqrst uvwxzy");
    $headers->setEncoding("Q");
    $structure = $headers->build();
    
    $lines = explode("\r\n", $structure);
    foreach ($lines as $line)
    {
      $line .= "\r\n"; //The bit lost from explode
      $this->assertWithinMargin(0, strlen($line), 76);
    }
    
    $headers = new Swift_Message_Headers();
    $headers->set("Normal-Header", "foo");
    $headers->set(
      "Really-Long-Header",
      "abcdefg hijklmno pqrstuvwxzyab cdefghijklm" .
      "nopqrstuvw xzyabcdefghijklmno pqrstuvwxzy" .
      "abcdefgh ijk lmnopqrstu\nv wxzyabc defgh ijklm" .
      "nopqrstuvw xzyabcd efghijklmno pqrstuvwxzy" .
      "abc defg\nhijklmnopqrstuvw xzyabcdefghijklm" .
      "nopqrstuv wxzya bcdefghijk lmnopqrstu vwxzy");
    $headers->setEncoding("B");
    $structure = $headers->build();
    
    $lines = explode("\r\n", $structure);
    foreach ($lines as $line)
    {
      $line .= "\r\n"; //The bit lost from explode
      $this->assertWithinMargin(0, strlen($line), 76);
    }
  }
  
  public function testHeadersAreOnlyEncodedIfNot7BitPrintable()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", " !\"#\$%&'()*+,-./0123456789:<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\\]^_`abcdefghijklmnopqrstuvwxyz{|}~");
    $structure = $headers->build();
    $this->assertNoPattern("~^.*?Foo: =\\?[^\\?]+\\?[QB]\\?.*?\\?=\$~sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", " !\"#\$%&'()*+,-./\r\nqrstuvwxyz{|}~");
    $structure = $headers->build();
    $this->assertPattern("~^.*?Foo: =\\?[^\\?]+\\?[QB]\\?.*?\\?=\\s*\$~sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", " abc\rd");
    $structure = $headers->build();
    $this->assertPattern("~^.*?Foo: =\\?[^\\?]+\\?[QB]\\?.*?\\?=\\s*\$~sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", " abcdef\nfg");
    $structure = $headers->build();
    $this->assertPattern("~^.*?Foo: =\\?[^\\?]+\\?[QB]\\?.*?\\?=\\s*\$~sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "cenvéla");
    $structure = $headers->build();
    $this->assertPattern("~^.*?Foo: =\\?[^\\?]+\\?[QB]\\?.*?\\?=\\s*\$~sm", $structure);
  }
  
  public function testEmailAddressesCanBePreservedInRelevantHeaders()
  {
    $relevant = array("To", "From", "Reply-To", "Cc", "Bcc", "Return-Path", "Sender");
    
    foreach ($relevant as $header)
    {
      $headers = new Swift_Message_Headers();
      $headers->set($header, "Somé Pérson <some@person.com>");
      $headers->setEncoding("Q");
      $structure = $headers->build();
      $this->assertPattern("~^.*?" . $header . ": =\\?[^\\?]+\\?Q\\?.*?\\?=.*?<some@person.com>\\s*\$~sm", $structure);
      
      $headers = new Swift_Message_Headers();
      $headers->set($header, "Somé Pérson <some@person.com>");
      $headers->setEncoding("B");
      $structure = $headers->build();
      $this->assertPattern("~^.*?" . $header . ": =\\?[^\\?]+\\?B\\?.*?\\?=.*?<some@person.com>\\s*\$~sm", $structure);
    }
    
    //and now try some non-relevant ones
    $headers = new Swift_Message_Headers();
    $headers->set("Subject", "Somé Pérson some@person.com");
    $headers->setEncoding("B");
    $structure = $headers->build();
    $this->assertNoPattern("~^.*?Subject: =\\?[^\\?]+\\?B\\?.*?\\?=.*?some@person.com\\s*\$~sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("X-Address", "Somé Pérson some@person.com");
    $headers->setEncoding("B");
    $structure = $headers->build();
    $this->assertNoPattern("~^.*?X-Address: =\\?[^\\?]+\\?B\\?.*?\\?=.*?some@person.com\\s*\$~sm", $structure);
  }
  
  public function testNullHeadersAreExcluded()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("To", "Test@Address");
    $headers->set("From", "foo@bar");
    $headers->set("Reply-To", "joe@bloggs.com");
    $headers->set("Reply-To", NULL);
    $structure = $headers->build();
    $this->assertPattern("/^To: .*/m", $structure);
    $this->assertPattern("/^From: .*/m", $structure);
    $this->assertNoPattern("/^Reply-To: .*/m", $structure);
  }
  
  public function testHeadersCanBeSetAsLists()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("To", array("Joe Bloggs <joe@bloggs.com>", "Jeoff Banks <jeoff@banks.it>"));
    $structure = $headers->build();
    $this->assertPattern("/^To: Joe Bloggs <joe@bloggs.com>,\\s*?[ \t]Jeoff Banks <jeoff@banks.it>\\s*\$/sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->setEncoding("Q");
    $headers->set("Reply-To", array("Joé Bloggs <joe@bloggs.com>", "Jéoff Banks <jeoff@banks.it>", "Zoe Ball <zoe@ball.co.uk>"));
    $structure = $headers->build();
    $this->assertPattern("/^Reply-To: =\\?[^\\?]+\\?Q\\?.*?\\?=.*?<joe@bloggs.com>,\\s*?[ \t]=\\?[^\\?]+\\?Q\\?.*?\\?=.*?<jeoff@banks.it>,\\s*?[ \t]Zoe Ball <zoe@ball.co.uk>\\s*\$/sm", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->setEncoding("B");
    $headers->set("Reply-To", array("Joé Bloggs <joe@bloggs.com>", "Jéoff Banks <jeoff@banks.it>", "Zoe Ball <zoe@ball.co.uk>"));
    $structure = $headers->build();
    $this->assertPattern("/^Reply-To: =\\?[^\\?]+\\?B\\?.*?\\?=.*?<joe@bloggs.com>,\\s*?[ \t]=\\?[^\\?]+\\?B\\?.*?\\?=.*?<jeoff@banks.it>,\\s*?[ \t]Zoe Ball <zoe@ball.co.uk>\\s*\$/sm", $structure);
  }
  
  public function testHeaderNamesAreCaseInsensitive()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Subject", "foo");
    $this->assertEqual(1, count($headers->getList()));
    $headers->set("From", "joe@bloggs.com");
    $this->assertEqual(2, count($headers->getList()));
    $headers->set("subject", "Bar");
    $this->assertEqual(2, count($headers->getList()));
  }
  
  public function testAttributesCanBeSetInHeaders()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Content-Type", "text/plain");
    $headers->setAttribute("Content-Type", "charset", "utf-8");
    $headers->setAttribute("Content-Type", "format", "flowed");
    $structure = $headers->build();
    $this->assertPattern("~^Content-Type: text/plain;\\s* charset=utf-8;\\s* format=flowed\$~m", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Content-Disposition", "attachment");
    $headers->setAttribute("Content-Disposition", "filename", "space in it.txt");
    $structure = $headers->build();
    $this->assertPattern("~^Content-Disposition: attachment;\\s* filename=\"space in it.txt\"\$~m", $structure);
  }
  
  public function testShortAttributesAreNotBrokenOntoNewLine()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "xxx");
    $headers->setAttribute("Foo", "bar", "yyy");
    $structure = $headers->build();
    $this->assertEqual("Foo: xxx; bar=yyy", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "xxx");
    $headers->setAttribute("Foo", "bar", "yyy");
    $headers->setAttribute("Foo", "abc", "xyz");
    $structure = $headers->build();
    $this->assertEqual("Foo: xxx; bar=yyy; abc=xyz", $structure);
  }
  
  public function testLongAttributesMoveOntoNewLine()
  {	
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "xxx");
    $headers->setAttribute(
      "Foo", "bar",
      "abcdefghijklmnopqrstuvwxzyabcdefghijklm" .
      "nopqrstuvwxzyabcdefghijklmnopqrstuvwxzy" .
      "abcdefghijklmnopqrstuvwxzyabcdefghijklm" .
      "nopqrstuvwxzyabcdefghijklmnopqrstuvwxzy" .
      "abcdefghijklmnopqrstuvwxzyabcdefghijklm" .
      "nopqrstuvwxzyabcdefghijklmnopqrstuvwxzy");
    $structure = $headers->build();
    $this->assertPattern("~^Foo: xxx;(\r\n bar\\*[0-9]?=.*?)+~sm", $structure);
  }
  
  public function testAttributesWithNonPrintingOrHighValueCharsAreRFC2047Encoded()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "xxx");
    //Contains some CRLF and LF
    $headers->setAttribute(
      "Foo", "bar",
      "abcdefghijklmnopqrstuvwxzyabcdefghijklm" .
      "nopqrstuvwxzyabcdefghijklmnopqrstuvwxzy" .
      "abcdefghijklmnopq\nrstuvwxzyabcdefghijklm" .
      "nopqrstuvwxzyabcdefghijklmnopqrstuvwxzy" .
      "abcdefghijklmno\r\npqrstuvwxzyabcdefghijklm" .
      "nopqrstuvwxzyabcdefghijklmnopqrstuvwxzy");
    $structure = $headers->build();
    $this->assertPattern("~^Foo: xxx;(\r\n bar\\*[0-9]\\*=.*?)+~sm", $structure);
  }
  
  public function testLongListsOfAttributesAreBrokenOntoNewLines()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "xxx");
    $headers->setAttribute("Foo", "bar", "yyy");
    $headers->setAttribute("Foo", "zip", "498567hgdjwbvi");
    $headers->setAttribute("Foo", "verylong", "asfsafvasdbfouiwebgjwkebvfewivg");
    $structure = $headers->build();
    $this->assertEqual("Foo: xxx; bar=yyy; zip=498567hgdjwbvi;\r\n verylong=asfsafvasdbfouiwebgjwkebvfewivg", $structure);
  }
  
  public function testAttemptsToInjectLFFollowedByDotAreSquashed()
  {
    $headers = new Swift_Message_Headers();
    $headers->set(".Foo", "xxx");
    $structure = $headers->build();
    $this->assertEqual("Foo: xxx", $structure);
    
    $headers = new Swift_Message_Headers();
    $headers->set(".......Foo", "xxx");
    $structure = $headers->build();
    $this->assertEqual("Foo: xxx", $structure);
  }
  
  public function testPersonalNamesWithCommasGetQuoted()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("From", "Test, Test, Test <test@test.tld>");
    $structure = $headers->getEncoded("From");
    $this->assertEqual("\"Test, Test, Test\" <test@test.tld>", $structure);
  }
  
  public function testQuotedEmailAddressesAreNeverSplit()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("From", "Test Test <test@test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $structure = $headers->getEncoded("From");
    $this->assertPattern("/<test@test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
    
    $headers->set("From", "cenvéla <test@test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $headers->setEncoding("Q");
    $structure = $headers->getEncoded("From");
    $this->assertPattern("/<test@test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
    
    $headers->set("From", "cenvéla <test@test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $headers->setEncoding("B");
    $structure = $headers->getEncoded("From");
    $this->assertPattern("/<test@test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
  }
  
  public function testQuoted7BitStringsAreNeverSplit()
  {
    //This should only work for header-safe sequences (i.e. no newlines).
    $headers = new Swift_Message_Headers();
    $headers->set("X-Foo", "Test Test <test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $structure = $headers->getEncoded("X-Foo");
    $this->assertPattern("/<test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
    
    $headers->set("X-Bar", "cenvéla <test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $headers->setEncoding("Q");
    $structure = $headers->getEncoded("X-Bar");
    $this->assertPattern("/<test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
    
    $headers->set("X-Bar", "cenvéla <test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $headers->setEncoding("B");
    $structure = $headers->getEncoded("X-Bar");
    $this->assertPattern("/<test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
    //Not 7-bit
    $headers->set("X-Zip", "foobar <cenvéla-test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh.tld>");
    $headers->setEncoding("B");
    $structure = $headers->getEncoded("X-Zip");
    $this->assertNoPattern("/<cenvéla-test-test-fbhksdjbfsjkbgjdfbvgjfbgijrebjbvjkrbgjfbvbrejghdghdh\\.tld>/", $structure);
  }
  
  public function testSingleHeadersCanBeRetreivedInEncodedForm()
  {
    $headers = new Swift_Message_Headers();
    $headers->set("Foo", "cenvéla");
    $encoded = $headers->getEncoded("Foo");
    $this->assertPattern("~^(?<!Foo: )=\\?[^\\?]+\\?[QB]\\?.*?\\?=\$~sm", $encoded);
  }
}
