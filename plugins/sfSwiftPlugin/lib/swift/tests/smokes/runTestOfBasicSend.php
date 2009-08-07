<?php

require_once dirname(__FILE__) . "/components/Runner.php";

class TestOfBasicSend extends Runner
{
  protected $to;
  protected $from;
  
  public function go()
  {
    try {
      $swift = new Swift($this->getConnection());
      $this->setSwiftInstance($swift);
      $message = new Swift_Message("Smoke Test 1 - Basic");
      $message->setBody("This is just a basic test\n".
        "It has two lines and no special non-ascii characters.");
      
      $to = new Swift_Address(TestConfiguration::TO_ADDRESS, TestConfiguration::TO_NAME);
      $from = new Swift_Address(TestConfiguration::FROM_ADDRESS, TestConfiguration::FROM_NAME);
      
      $this->setSent($swift->send($message, $to, $from));
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
    echo "Test of Sending Basic E-Mail";
  }
  
  public function paintTopInfo()
  {
    echo "A basic, 7 bit ascii email will be sent from Swift, to the account given in the test configuration.  Simply open up the email and " .
    "check that the details given below are accurate: " .
    "<ul><li>The subject of the message is \"<em>Smoke Test 1 - Basic</em>\"</li>" .
    "<li>The sender of the message is \"<em>" . htmlentities($this->from) . "</em>\"</li>" . 
    "<li>The recipient in the To: header is \"<em>" . htmlentities($this->to) . "</em>\"</li>" .
    "<li>The message body is<br />\"<em>This is just a basic test<br />
    It has two lines and no special non-ascii characters.</em>\"</li>" .
    "<li>The Date: header relects the date on the server.</li></ul>";
  }
  
  public function paintImageName()
  {
    echo "smoke1.png";
  }
}

$runner = new TestOfBasicSend();
$runner->go();
