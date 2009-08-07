<?php

/**
 * Swift Mailer Unit Test Case for the Default Logging class.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */


/**
 * Swift Mailer Unit Test Case for the Default Logging class.
 * @package Swift
 * @subpackage Tests
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class TestOfDefaultLog extends UnitTestCase
{
  /**
   * The logger should use visual keys to indicate the type of action that was logged.
   */
  public function testLoggerAddsEntriesWithLabelPrepended()
  {
    $log = new Swift_Log_DefaultLog();
    $log->add("xxx", ">>"); //Swift_Log::COMMAND
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $this->assertPattern("~>> xxx\\b~", $dump);
    
    $log = new Swift_Log_DefaultLog();
    $log->add("xxx", "++"); //Swift_Log::COMMAND
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $this->assertPattern("~\\+\\+ xxx\\b~", $dump);
  }
  /**
   * Each line in the log is separate entry.
   */
  public function testDumpReturnsRecordsSeparatedByLF()
  {
    $log = new Swift_Log_DefaultLog();
    $log->add("xxx", ">>");
    $log->add("yyy", "!!");
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $this->assertPattern("~>> xxx\n!! yyy\\b~", $dump);
  }
  /**
   * The maximum log size should be settable.
   */
  public function testNoMoreThanMaxEntriesAreStored()
  {
    $log = new Swift_Log_DefaultLog();
    $log->setMaxSize(10);
    for ($i = 0; $i < 100; $i++)
    {
      $log->add(rand(), ">>");
    }
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $lines = explode("\n", $dump);
    $this->assertEqual(10, count($lines));
    
    $log->setMaxSize(11);
    for ($i = 0; $i < 100; $i++)
    {
      $log->add(rand(), ">>");
    }
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $lines = explode("\n", $dump);
    $this->assertEqual(11, count($lines));
  }
  /**
   * When the log is truncated it should be trimmed from the start, not the end.
   */
  public function testLastEntryInTruncatedLogIsNewset()
  {
    $log = new Swift_Log_DefaultLog();
    $log->setMaxSize(10);
    for ($i = 0; $i < 100; $i++)
    {
      $log->add(rand(), ">>");
    }
    $log->add("Foo", "!!");
    $log->add("Bar", "<<");
    
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $lines = explode("\n", $dump);
    $this->assertEqual("<< Bar", $lines[count($lines)-1]);
  }
  /**
   * A max size of zero is equivalent to disabling the log size.
   */
  public function testLogSizeOfZeroIsIgnored()
  {
    $log = new Swift_Log_DefaultLog();
    $log->setMaxSize(0);
    for ($i = 0; $i < 100; $i++)
    {
      $log->add(rand(), ">>");
    }
    
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $lines = explode("\n", $dump);
    $this->assertTrue(count($lines) >= 100);
  }
  /**
   * It should be possible to empty the log.
   */
  public function testClearEmptiesTheLog()
  {
    $log = new Swift_Log_DefaultLog();
    $log->setMaxSize(0);
    for ($i = 0; $i < 100; $i++)
    {
      $log->add(rand(), ">>");
    }
    $log->clear();
    ob_start();
    $log->dump();
    $dump = ob_get_clean();
    $this->assertEqual("", $dump);
  }
}
