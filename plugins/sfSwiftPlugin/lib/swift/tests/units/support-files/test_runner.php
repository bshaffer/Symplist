<?php

require_once dirname(__FILE__) . "/BasicTestSuite.php";
require_once dirname(__FILE__) . "/common.php";

ini_set("memory_limit", "64M");

$suite = BasicTestSuite::getInstance();
$suite->executeTests();
