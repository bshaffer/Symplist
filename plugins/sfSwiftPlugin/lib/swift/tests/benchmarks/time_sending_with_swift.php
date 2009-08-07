<?php

/**
 * Benchmarking tests for Swift Mailer
 * @author Chris Corbyn <chris@w3style.co.uk>
 */

set_time_limit(500);
error_reporting(E_ALL);
ini_set("display_errors", "On");
require_once "../TestConfiguration.php";

//Number of emails to send
$n = isset($_GET["n"]) ? $_GET["n"] : 1;

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

?>Run Test for number of recipients:
<ul>
  <li><a href="?n=1">1</a></li>
  <li><a href="?n=10">10</a></li>
  <li><a href="?n=30">30</a></li>
  <li><a href="?n=100">100</a></li>
</ul><?php

$start = microtime(true);

$swift = new Swift($conn);
$message = new Swift_Message("Test", "Test");
$from = new Swift_Address(TestConfiguration::FROM_ADDRESS, TestConfiguration::FROM_NAME);
$to = new Swift_Address(TestConfiguration::TO_ADDRESS, TestConfiguration::TO_NAME);
for ($i = 0; $i < $n; $i++)
{
  $swift->send($message, $to, $from);
}


echo "Sent " . $n . " emails in ";
echo (microtime(true) - $start);
echo " seconds.";
