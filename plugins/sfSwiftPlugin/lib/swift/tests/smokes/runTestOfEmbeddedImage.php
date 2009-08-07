<?php

require_once dirname(__FILE__) . "/components/Runner.php";

class TestOfEmbeddedImage extends Runner
{
  protected $to;
  protected $from;
  
  public function go()
  {
    try {
      Swift_ClassLoader::load("Swift_Cache_Disk");
      Swift_Cache_Disk::setSavePath(TestConfiguration::WRITABLE_PATH);
      Swift_CacheFactory::setClassName("Swift_Cache_Disk");
      $swift = new Swift($this->getConnection(), null, Swift::ENABLE_LOGGING);
      $this->setSwiftInstance($swift);
      $message = new Swift_Message("Smoke Test 5 - Embedded Image");
      $part = new Swift_Message_Part(
        "
        Here is an embedded image: <br />
        <img src=\"" .
          $message->attach(new Swift_Message_Image(new Swift_File(dirname(__FILE__) . "/../files/manchester.jpeg"))) .
          "\" alt=\"image\" /><br />And here is the rest of the message.",
        "text/html"
      );
      $message->attach($part);
      $message->attach(new Swift_Message_Part("You are viewing this message in plain text.  Switch to HTML mode to see the image.", "text/plain"));
      $to = new Swift_Address(TestConfiguration::TO_ADDRESS, TestConfiguration::TO_NAME);
      $from = new Swift_Address(TestConfiguration::FROM_ADDRESS, TestConfiguration::FROM_NAME);
      $swift->send($message, $to, $from);
      $this->to = $to->build();
      $this->from = $from->build();
    } catch (Exception $e) {
      $this->failed = true;
      $this->setError($e->getMessage());
    }
    $this->render();
  }
  
  public function paintTestName()
  {
    echo "Test of Sending Embedded Image";
  }
  
  public function paintTopInfo()
  {
    echo "An email containing an embedded JPEG image will be sent from Swift, to the account given in the test configuration.  Open up the email and " .
    "check that the details given below are accurate: " .
    "<ul><li>The message body is<br />\"<em>Here is an embedded image: <br /><img src=\"../files/manchester.jpeg\" alt=\"image\" /><br />And here is the rest of the message.</em>\"</li>" .
    "<li>The image displays inline with the content</li></ul>";
  }
  
  public function paintBottomInfo()
  {
    echo "<strong style=\"color: #aa1111;\">NOTE:</strong> Make sure you have your e-mail client in HTML mode.  Some web-based e-mail providers do not work with embedded images at all.";
  }
  
  public function paintImageName()
  {
    echo "smoke5.png";
  }
}

$runner = new TestOfEmbeddedImage();
$runner->go();

