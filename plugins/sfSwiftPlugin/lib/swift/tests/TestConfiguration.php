<?php

define("TEST_CONFIG_PATH", dirname(__FILE__));
define("DEFAULT_WRITABLE_PATH", TEST_CONFIG_PATH . "/tmp");
define("DEFAULT_LIBRARY_PATH", TEST_CONFIG_PATH . "/../lib");
define("FILES_PATH", TEST_CONFIG_PATH . "/files");

/**
 * Adjust the values contained inside this class in order to run the tests
 * NOTE: SimpleTest is NOT provided with Swift.  You must download this from SouceForge yourself.
 * Paths given should be either relative to the "tests/units" directory or absolute.
 * @package Swift_Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestConfiguration
{
  /**
   * Somewhere to write to when testing disk cache
   */
  const WRITABLE_PATH = DEFAULT_WRITABLE_PATH;
  /**
   * The location of SimpleTest (Unit Test Tool)
   */
  const SIMPLETEST_PATH = "/Users/d11wtq/PHPLibs/simpletest";
  /**
   * The location of the Swift library directory
   */
  const SWIFT_LIBRARY_PATH = DEFAULT_LIBRARY_PATH;
  /**
   * The location of some files used in testing.
   */
  const FILES_PATH = FILES_PATH;
  
  /*
   * EVERYTHING BELOW IS FOR SMOKE TESTING ONLY
   */
   
  /**
   * The connection tye to use in testing
   * "smtp", "sendmail" or "nativemail"
   */
  const CONNECTION_TYPE = "smtp";
  /**
   * An address to send emails from
   */
  const FROM_ADDRESS = "chris@w3tyle.co.uk";
  /**
   * The name of the sender
   */
  const FROM_NAME = "Chris Corbyn - from";
  /**
   * An address to send emails to
   */
  const TO_ADDRESS = "chris@w3style.co.uk";
  /**
   * The name of the recipient
   */
  const TO_NAME = "Chris Corbyn - to";
  
  /*
   * SMTP SETTINGS - IF APPLICABLE
   */
   
  /**
   * The FQDN of the host
   */
  const SMTP_HOST = "smtp.swiftmailer.org";
  /**
   * The remote port of the SMTP server
   */
  const SMTP_PORT = 25;
  /**
   * Encryption to use if any
   * "ssl", "tls" or false
   */
  const SMTP_ENCRYPTION = false;
  /**
   * A username for SMTP, if any
   */
  const SMTP_USER = false;
  /**
   * Password for SMTP, if any
   */
  const SMTP_PASS = false;
  
  /*
   * SENDMAIL BINARY SETTINGS - IF APPLICABLE
   */
  
  /**
   * The path to sendmail, including the -bs options
   */
  const SENDMAIL_PATH = "/usr/sbin/sendmail -bs";
}
