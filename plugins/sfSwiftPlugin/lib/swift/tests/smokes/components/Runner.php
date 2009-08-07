<?php

error_reporting(E_STRICT | E_ALL);
ini_set("display_errors", "On");

require_once dirname(__FILE__) . "/../../TestConfiguration.php";
require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift.php";
require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/Connection/SMTP.php";
require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/Connection/Sendmail.php";
require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/Connection/NativeMail.php";

abstract class Runner
{
  protected $failed = false;
  protected $error = "";
  protected $swiftInstance;
  
  protected function getConnection()
  {
    Swift_LogContainer::getLog()->setLogLevel(Swift_Log::LOG_EVERYTHING);
    switch (TestConfiguration::CONNECTION_TYPE)
    {
      case "smtp":
        $enc = null;
        $test_enc = TestConfiguration::SMTP_ENCRYPTION;
        if ($test_enc == "ssl") $enc = Swift_Connection_SMTP::ENC_SSL;
        elseif ($test_enc == "tls") $enc = Swift_Connection_SMTP::ENC_TLS;
        $conn = new Swift_Connection_SMTP(
          TestConfiguration::SMTP_HOST, TestConfiguration::SMTP_PORT, $enc);
        if ($user = TestConfiguration::SMTP_USER) $conn->setUsername($user);
        if ($pass = TestConfiguration::SMTP_PASS) $conn->setPassword($pass);
        return $conn;
      case "sendmail":
        $conn = new Swift_Connection_Sendmail(TestConfiguration::SENDMAIL_PATH);
        return $conn;
      case "nativemail":
        $conn = new Swift_Connection_NativeMail();
        return $conn;
    }
  }
  
  public function setSwiftInstance($swift)
  {
    $this->swiftInstance = $swift;
  }
  
  public function getSwiftInstance()
  {
    return $this->swiftInstance;
  }
  
  public function getLogDetails()
  {
    $swift = $this->getSwiftInstance();
    $log = Swift_LogContainer::getLog();
    return "<h3>Log Information</h3><pre>" . htmlentities($log->dump(true)) . "</pre>";
  }
  
  public function setSent($sent)
  {
    $this->sent = $sent;
    if (!$sent)
    {
      $this->failed = true;
      $this->error = "Message did not send!" . $this->getLogDetails();
    }
  }
  
  abstract public function go();
  
  abstract public function paintTestName();
  
  abstract public function paintTopInfo();
  
  abstract public function paintImageName();
  
  public function isError()
  {
    return $this->failed;
  }
  
  public function setError($errstr)
  {
    $this->error = $errstr;
  }
  
  public function paintError()
  {
    echo $this->error;
  }
  
  public function paintResult()
  {
    echo "Message sent successfully";
  }
  
  public function paintBottomInfo()
  {
    //
  }
  
  public function render()
  {
    require_once dirname(__FILE__) . "/template.php";
  }
}
