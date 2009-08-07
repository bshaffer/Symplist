<?php

require_once TestConfiguration::SWIFT_LIBRARY_PATH . "/Swift/ConnectionBase.php";

class DummyConnection extends Swift_ConnectionBase
{
  public function start() {}
  public function stop() {}
  public function read() {}
  public function write($command, $end="\r\n") {}
  public function isAlive() {}
}
