<?php

/**
 * Swift Mailer Unit Test Case for Attachments.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
 

/**
 * Swift Mailer Unit Test Case for Attachments.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfAttachment extends UnitTestCase
{
  /**
   * Check that the headers which make this mime part an attachment exist.
   */
  public function testAttachmentContainsNeededHeaders()
  {
    $attachment = new Swift_Message_Attachment("some string");
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(.*?)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
      
    $attachment = new Swift_Message_Attachment(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(.*?)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
  }
  /**
   * Make sure the filename is settable (various headers).
   */
  public function testFileNameCanBeChanged()
  {
    $attachment = new Swift_Message_Attachment("some string", "my_file.txt");
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(my_file\\.txt)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
    
    $attachment = new Swift_Message_Attachment("some string");
    $attachment->setFileName("foo.txt");
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(foo\\.txt)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
  }
  /**
   * If a Swift_File object is used, we can use it's filename.
   */
  public function testFileNameCanBeReadFromFileStream()
  {
    $attachment = new Swift_Message_Attachment(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $this->assertEqual("manchester.jpeg", $attachment->getFileName());
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(manchester\\.jpeg)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
      
    $attachment = new Swift_Message_Attachment();
    $attachment->setData(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $this->assertEqual("manchester.jpeg", $attachment->getFileName());
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(manchester\\.jpeg)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
  }
  /**
   * Just because we use Swift_File doesn't neccesarily mean we want to use it's filename.
   * Make sure you can still set it.
   */
  public function testFileNameCanBeOverriddenEvenWhenUsingFileStream()
  {
    $attachment = new Swift_Message_Attachment(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"), "foo.bar");
    $this->assertEqual("foo.bar", $attachment->getFileName());
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(foo\\.bar)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
    
    $attachment = new Swift_Message_Attachment(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $attachment->setFileName("zip.button");
    $this->assertEqual("zip.button", $attachment->getFileName());
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(zip\\.button)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
    
    $attachment = new Swift_Message_Attachment(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"), "foo.bar");
    $attachment->setFileName("test.file");
    $this->assertEqual("test.file", $attachment->getFileName());
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(test\\.file)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
  }
  /**
   * The description is, by default, just filename.  Make sure we can override this default.
   */
  public function testDescriptionCanBeOverridden()
  {
    $attachment = new Swift_Message_Attachment("some string", "my_file.txt");
    $attachment->setDescription("another_file.txt");
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(my_file\\.txt)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: another_file\\.txt\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
      
    $attachment = new Swift_Message_Attachment(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $attachment->setDescription("my_image.jpg");
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(.*?)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: my_image\\.jpg\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
  }
  /**
   * Setting the filename should set the description first.
   */
  public function testSettingFileNameResetsDescription()
  {
    $attachment = new Swift_Message_Attachment("some string", "my_file.txt");
    $attachment->setDescription("another_file.txt");
    $this->assertEqual("another_file.txt", $attachment->getDescription());
    $attachment->setFileName("zip.button");
    $this->assertEqual("zip.button", $attachment->getDescription());
    $structure = $attachment->build()->readFull();
    $this->assertPattern(
      "~Content-Type: application/octet-stream;\\s* name=(\"?)(zip\\.button)\\1\r\nContent-Transfer-Encoding: base64\r\n".
      "Content-Description: \\2\r\nContent-Disposition: attachment;\\s* filename=(\"?)\\2\\3\r\n\r\n.*~s", $structure);
  }
  /**
   * It should be possible to specify our own prefix on the filename.
   */
  public function testFileNamePrefixIsUsed()
  {
    $name = Swift_Message_Attachment::generateFileName("prefix");
    $this->assertPattern("/^prefix\\d+/", $name);
    $name = Swift_Message_Attachment::generateFileName("filename");
    $this->assertPattern("/^filename\\d+/", $name);
    $name = Swift_Message_Attachment::generateFileName("xxx.yyy.zzz.");
    $this->assertPattern("/^xxx\\.yyy\\.zzz\\.\\d+/", $name);
  }
  /**
   * The number of the file should go up by one each time.
   */
  public function testSequenceNumberIsAlwaysIncrementedInFileName()
  {
    $name = Swift_Message_Attachment::generateFileName();
    $id1 = (int) substr($name, -1);
    $name = Swift_Message_Attachment::generateFileName();
    $id2 = (int) substr($name, -1);
    $this->assertTrue($id2 > $id1);
    $name = Swift_Message_Attachment::generateFileName();
    $id3 = (int) substr($name, -1);
    $this->assertTrue($id3 > $id2);
  }
}
