<?php

/**
 * Provides the business logic for wrapping a very basic test suite around simpletest.
 */


require_once dirname(__FILE__) . "/../../TestConfiguration.php";
define("UNITS", TEST_CONFIG_PATH . "/units/testcases");

require_once TestConfiguration::SIMPLETEST_PATH . "/unit_tester.php";
require_once TestConfiguration::SIMPLETEST_PATH . "/mock_objects.php";
require_once TestConfiguration::SIMPLETEST_PATH . "/reporter.php";

/**
 * Test suite controller.
 * @author Chris Corbyn
 */
class BasicTestSuite
{
	/**
	 * Template variables.
	 * @var array
	 */
	protected $vars = array();
	/**
	 * Singleton instance.
	 * @var BasicTestSuite
	 */
	protected static $instance = null;
	
	/**
	 * Singleton factory.
	 * @return BasicTestSuite
	 */
	public function getInstance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	/**
	 * Set a template variable.
	 * @param string Key
	 * @param mixed Value
	 */
	protected function setVar($key, $value)
	{
		$this->vars[$key] = $value;
	}
	/**
	 * Load the template file and create variables from the template vars.
	 * @param string Path to template file.
	 */
	protected function render($path)
	{
		foreach ($this->vars as $k => $v)
		{
			$$k = $v;
		}
		require_once dirname(__FILE__) . "/" . $path;
	}
	/**
	 * Recursively load test cases into the test runner.
	 * @param string Path to scan
	 * @param GroupTest The test case from SimpleTest
	 */
	public function loadTests($path, &$group)
	{
		$base = basename($path);
		if (is_file($path) && !is_dir($path)
			&& substr($base, -4) == ".php" && substr($base, 0, 4) == "Test")
		{
			require_once $path;
			$name = substr($base, 0, -4);
			$group->addTestCase(new $name());
		}
		elseif (is_dir($path))
		{
			$mygroup = new GroupTest($base);
			$group->addTestCase($mygroup);
			$handle = opendir($path);
			while (false !== $file = readdir($handle))
			{
				if (substr($file, 0, 1) != "." && is_dir($path . "/" . $file))
				{
					$this->loadTests($path . "/" . $file, $mygroup);
				}
				else
				{
					if (is_file($path . "/" . $file) && !is_dir($path . "/" . $file)
						&& substr($file, -4) == ".php" && substr($file, 0, 6) == "TestOf")
					{
						require_once $path . "/" . $file;
						$name = basename($file);
						$name = substr($file, 0, -4);
						$mygroup->addTestCase(new $name());
					}
				}
			}
			closedir($handle);
		}
	}
	/**
	 * Execute the list action to show test cases.
	 */
	public function executeList()
	{
		$tests = array();
		$handle = opendir(UNITS);
		while (false !== $file = readdir($handle))
		{
			if (substr($file, 0, 1) == ".") continue;
			if (substr($file, -4) == ".php" && substr($file, 0, 4) == "Test" && !is_dir(UNITS . "/" . $file))
			{
				$tests[$file] = array("name" => substr($file, 0, -4), "tests" => array());
			}
			elseif (is_dir(UNITS . "/" . $file))
			{
				$tests[$file] = array("name" => $file, "tests" => array());
				$subhandle = opendir(UNITS . "/" . $file);
				while (false !== $subfile = readdir($subhandle))
				{
					if (substr($subfile, -4) == ".php" && substr($subfile, 0, 4) == "Test" && !is_dir(UNITS . "/" . $file . "/" . $subfile))
					{
						$tests[$file]["tests"][$file . "/" . $subfile] = substr($subfile, 0, -4);
					}
				}
			}
		}
		closedir($handle);
		$this->setVar("tests", $tests);
		$this->setVar("phpVersion", phpversion());
		$simpletestVer = "Unknown";
		if (file_exists(TestConfiguration::SIMPLETEST_PATH . "/VERSION"))
		{
		  $simpletestVer = trim(file_get_contents(TestConfiguration::SIMPLETEST_PATH . "/VERSION"));
	  }
		$this->setVar("simpletestVer", $simpletestVer);
		$this->setVar("os", PHP_OS);
		$this->setVar("safeMode", ini_get("safe_mode") ? "On!!" : "Off");
		$this->setVar("magicQuotes", get_magic_quotes_runtime() ? "On!!" : "Off");
		$this->setVar("registerGlobals", ini_get("register_globals") ? "On!!" : "Off");
		$this->setVar("memLimit", ini_get("memory_limit"));
		$notices = array();
		$swift_found = file_exists(TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift.php");
		$simpletest_found = file_exists(TestConfiguration::SIMPLETEST_PATH . "/unit_tester.php");
		$files_found = is_dir(TestConfiguration::FILES_PATH);
		$swiftVer = "Unknown";
		if (!($swift_found && $simpletest_found && $files_found))
		{
		  $notices[] = "FAULTY!";
		  if (!$swift_found)
		  {
		    $color = "red";
	      $notices[] = "Swift not found.";
	    }
	    if (!$simpletest_found)
	    {
	      $color = "red";
	      $notices[] = "SimpleTest not found.";
      }
      if (!$files_found)
      {
        $color = "red";
	      $notices[] = "'files' dir not found.";
      }
	  }
	  else
	  {
	    require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift.php";
	    $swiftVer = Swift::VERSION;
	    $color = "green";
	    $notices[] = "OK";
    }
		$this->setVar("swiftVer", $swiftVer);
		$this->setVar("confOk", '<span style="color: ' . $color . ';">' . implode("<br />", $notices) . '</span>');
		$this->render("templates/list_panel.tpl.php");
	}
	/**
	 * Execute the Test action to run test cases.
	 */
	public function executeTests()
	{
		if (empty($_GET["doTests"]))
		{
			echo "Select a test case or a group from the left.<br />";
			echo "<strong>If</strong> your memory limit is exhausted, change memory_limit in php.ini, or run less tests at one time.";
			return;
		}
		$name = false;
		if ($_GET["doTests"] == "all")
		{
			$path = UNITS;
			$name = "All Tests";
		}
		else
		{
			$path = UNITS . "/" . $_GET["doTests"];
		}
		if (!$name) $name = ucwords(basename($path));
		if (substr($name, -4) == ".php")
		{
			$name = substr($name, 0, -4);
		}
		$suite = new GroupTest($name);
		$this->loadTests($path, $suite);
		$suite->run(new HtmlReporter());
	}
}
