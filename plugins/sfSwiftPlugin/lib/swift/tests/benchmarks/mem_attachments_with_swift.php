<?php

/**
 * Benchmarking tests for Swift Mailer
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

set_time_limit(500);
error_reporting(E_ALL);
ini_set("display_errors", "On");
require_once "../TestConfiguration.php";

xdebug_start_trace(TestConfiguration::WRITABLE_PATH . "/bench-output");

//Attachment size
$file = isset($_GET["s"]) ? $_GET["s"] : "10k";

require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift.php";

Swift_CacheFactory::setClassName("Swift_Cache_Disk");
Swift_Cache_Disk::setSavePath(TestConfiguration::WRITABLE_PATH);

$conn = null;
switch (TestConfiguration::CONNECTION_TYPE)
{
  case "smtp":
    require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/Connection/SMTP.php";
    $enc = null;
    $test_enc = TestConfiguration::SMTP_ENCRYPTION;
    if ($test_enc == "ssl") $enc = Swift_Connection_SMTP::ENC_SSL;
    elseif ($test_enc == "tls") $enc = Swift_Connection_SMTP::ENC_TLS;
    $conn = new Swift_Connection_SMTP(
      TestConfiguration::SMTP_HOST, TestConfiguration::SMTP_PORT, $enc);
    if ($user = TestConfiguration::SMTP_USER) $conn->setUsername($user);
    if ($pass = TestConfiguration::SMTP_PASS) $conn->setPassword($pass);
    break;
  case "sendmail":
    require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/Connection/Sendmail.php";
    $conn = new Swift_Connection_Sendmail(TestConfiguration::SENDMAIL_PATH);
    break;
  case "nativemail":
    require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/Connection/NativeMail.php";
    $conn = new Swift_Connection_NativeMail();
    break;
}

?>Run Test for attachment of size:
<ul>
  <li><a href="?s=10k">10KB</a></li>
  <li><a href="?s=100k">100KB</a></li>
  <li><a href="?s=300k">300KB</a></li>
  <li><a href="?s=500k">500KB</a></li>
</ul><?php

$swift = new Swift($conn);
$message = new Swift_Message("Test");
$message->attach(new Swift_Message_Part("test"));
$message->attach(new Swift_Message_Attachment(new Swift_File("../files/" . $file)));
$from = new Swift_Address(TestConfiguration::FROM_ADDRESS, TestConfiguration::FROM_NAME);
$to = new Swift_Address(TestConfiguration::TO_ADDRESS, TestConfiguration::TO_NAME);
$swift->send($message, $to, $from);

echo "Check the output file [" . TestConfiguration::WRITABLE_PATH . "/bench-output.xt] for the trace if the peak memory value below is zero<br />";
echo xdebug_peak_memory_usage();

