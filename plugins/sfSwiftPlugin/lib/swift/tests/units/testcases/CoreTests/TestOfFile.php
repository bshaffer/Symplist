<?php

/**
 * Swift Mailer Unit Test Case for Swift_File
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */


/**
 * Swift Mailer Unit Test Case for Swift_File
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfFile extends UnitTestCase
{
  /**
   * The current working dir, so we can change directories.
   * @var string
   */
  protected $cwd;
  /**
   * Store the working dir.
   */
  public function setUp()
  {
    $this->cwd = getcwd();
  }
  /**
   * Restore the working dir.
   */
  public function tearDown()
  {
    chdir($this->cwd);
  }
  /**
   * We want an error triggered if the file doesn't exist.
   */
  public function testExceptionIsThrowIfFileNotFound()
  {
    try {
      $file = new Swift_File("/no/such/file.php");
      $this->fail("This should have thrown an exception");
    } catch (Swift_FileException $e) {
      //Pass if file really is not there
      $this->assertFalse(file_exists("/no/such/file.php"));
    }
  }
  /**
   * Streaming data from the file shoudl yield the same results as file_get_contents().
   */
  public function testBytesReadFromFileAreCorrect()
  {
    $file = new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg");
    
    $data = "";
    while (false !== $byte = $file->getByte()) $data .= $byte;
    
    $this->assertIdentical($data, file_get_contents(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
  }
  /**
   * ReadFull() should just stream all the data.
   */
  public function testReadFullIsSameAsActualFileContents()
  {
    $file = new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg");
    $this->assertIdentical($file->readFull(), file_get_contents(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
  }
  /**
   * The filename should be returned, without the rest of the path.
   */
  public function testFileNameIsReturned()
  {
    $file = new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg");
    $this->assertEqual("manchester.jpeg", $file->getFileName());
    
    $file->setPath(__FILE__); //TestOfFile.php
    $this->assertEqual(basename(__FILE__), $file->getFileName());
    
    chdir(TestConfiguration::FILES_PATH);
    $file = new Swift_File("manchester.jpeg");
    $this->assertEqual("manchester.jpeg", $file->getFileName());
  }
  
  //Not easy to test exception throw if file cannot be read so I just trust it ;)
}
