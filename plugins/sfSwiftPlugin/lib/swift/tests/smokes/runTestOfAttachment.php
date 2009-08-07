<?php

require_once dirname(__FILE__) . "/components/Runner.php";

class TestOfAttachment extends Runner
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
      $message = new Swift_Message("Smoke Test 3 - Attachment");
      $message->attach(new Swift_Message_Part("This message contains an attachment"));
      $message->attach(new Swift_Message_Part("This message contains an <em>attachment</em>", "text/html"));
      $message->attach(new Swift_Message_Attachment(new Swift_File(dirname(__FILE__) . "/../files/cv.pdf"), "Authors_CV.pdf", "application/pdf"));
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
    echo "Test of Sending Attachment";
  }
  
  public function paintTopInfo()
  {
    echo "An email containing a PDF attachment will be sent from Swift, to the account given in the test configuration.  Open up the email & its attachment and " .
    "check that the details given below are accurate: " .
    "<ul><li>The message body is<br />\"<em>This message contains an an attachment</em>\"</li>" .
    "<li>There is an attachment included named <em>Authors_CV.pdf</em></li>" .
    "<li>The attachment opens successfully in a PDF reader such as Adobe Acrobat Reader</li></ul>";
  }
  
  public function paintImageName()
  {
    echo "smoke3.png";
  }
}

$runner = new TestOfAttachment();
$runner->go();
