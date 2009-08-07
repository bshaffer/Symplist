<?php

require_once dirname(__FILE__) . "/components/Runner.php";

class TestOfMultipart extends Runner
{
  protected $to;
  protected $from;
  
  public function go()
  {
    try {
      $swift = new Swift($this->getConnection(), null, Swift::ENABLE_LOGGING);
      $this->setSwiftInstance($swift);
      $message = new Swift_Message("Smoke Test 2 - Multipart");
      $message->attach(new Swift_Message_Part("This message was sent in plain text"));
      $message->attach(new Swift_Message_Part("This message was sent in <strong>HTML</strong>", "text/html"));
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
    echo "Test of Sending Multipart E-Mail";
  }
  
  public function paintTopInfo()
  {
    echo "An email containing a HTML parts, and an alternative plain text part will be sent from Swift, to the account given in the test configuration.  Simply open up the email and " .
    "check that the details given below are accurate: " .
    "<ul><li>The subject of the message is \"<em>Smoke Test 2 - Multipart</em>\"</li>" .
    "<li>The sender of the message is \"<em>" . htmlentities($this->from) . "</em>\"</li>" . 
    "<li>The recipient in the To: header is \"<em>" . htmlentities($this->to) . "</em>\"</li>" .
    "<li>The plain text message body is<br />\"<em>This message was sent in plain text</em>\"</li>" .
    "<li>The HTML message body is<br />\"<em>This message was sent in <strong>HTML</strong></em>\"</li>" .
    "<li>The E-mail DOES NOT appear to have any attachments</li>" .
    "<li>The Date: header relects the date on the server.</li></ul>";
  }
  
  public function paintBottomInfo()
  {
    echo "<strong style=\"color: #aa1111;\">NOTE:</strong> You'll need to find the option in your e-mail client to switch between HTML and plain text viewing.";
  }
  
  public function paintImageName()
  {
    echo "smoke2.png";
  }
}

$runner = new TestOfMultipart();
$runner->go();
