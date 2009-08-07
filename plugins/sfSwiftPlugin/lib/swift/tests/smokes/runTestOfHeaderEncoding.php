<?php

require_once dirname(__FILE__) . "/components/Runner.php";

class TestOfHeaderEncoding extends Runner
{
  protected $to;
  protected $from;
  
  public function go()
  {
    try {
      $swift = new Swift($this->getConnection(), null, Swift::ENABLE_LOGGING);
      $this->setSwiftInstance($swift);
      $message = new Swift_Message("Smoke Test 4 - Esto es un correo electrónico con algunos caracteres especiales en jefes");
      //$message = new Swift_Message("Varování_před_expirací_domény_logomix");
      $message->setBody("This is a test message");
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
    echo "Test of Encoding in Headers";
  }
  
  public function paintTopInfo()
  {
    echo "An email containing a UTF-8 string in the subject will be sent to the address given in the test configuration. " .
    "<ul><li>Check that the subject is \"<em>Smoke Test 4 - Esto es un correo electrónico con algunos caracteres especiales en jefes</em>\"</li></ul>";
  }
  
  public function paintBottomInfo()
  {
    echo "<strong style=\"color: #aa1111;\">NOTE:</strong> Some web-based e-mail service like Hotmail may not display the message correctly due to their own character encoding compatability problems";
  }
  
  public function paintImageName()
  {
    echo "smoke4.png";
  }
}

$runner = new TestOfHeaderEncoding();
$runner->go();
