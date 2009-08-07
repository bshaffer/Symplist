<?php

class TestOfImage extends UnitTestCase
{
  public function testImageTypeIsDetected()
  {
    $image = new Swift_Message_Image(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $this->assertEqual("image/jpeg", $image->getContentType());
    
    $image = new Swift_Message_Image(new Swift_File(TestConfiguration::FILES_PATH . "/gecko.png"));
    $this->assertEqual("image/png", $image->getContentType());
    
    $image = new Swift_Message_Image(new Swift_File(TestConfiguration::FILES_PATH . "/durham.gif"));
    $this->assertEqual("image/gif", $image->getContentType());
  }
  
  public function testExceptionIsThrownIfWrongFileTypeGiven()
  {
    try {
      $image = new Swift_Message_Image(new Swift_File(TestConfiguration::FILES_PATH . "/cv.pdf"));
      $this->fail("This should have thrown an exception since PDF is not an image");
    } catch (Swift_Message_MimeException $e) {
      //Pass
    }
  }
  
  public function testFilenameSetsInConstructor()
  {
    $image = new Swift_Message_Image(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"));
    $this->assertEqual("manchester.jpeg", $image->getFileName());
    
    $image = new Swift_Message_Image(new Swift_File(TestConfiguration::FILES_PATH . "/manchester.jpeg"), "joe.gif");
    $this->assertEqual("joe.gif", $image->getFileName());
  }
}
