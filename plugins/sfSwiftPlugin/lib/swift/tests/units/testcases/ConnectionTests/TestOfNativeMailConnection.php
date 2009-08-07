<?php

class TestOfNativeMailConnection extends UnitTestCase
{
  public function testMailSendPluginIsLoadedWhenConnected()
  {
    $swift = new Swift(new Swift_Connection_NativeMail());
    $this->assertIsA($swift->getPlugin("_MAIL_SEND"), "Swift_Plugin_MailSend");
  }
  
  public function test220ResponseIsSentOnStart()
  {
    $connection = new Swift_Connection_NativeMail();
    $connection->start();
    $this->assertPattern("~^220\\b~", $connection->read());
  }
  
  public function assert250Response($command)
  {
    $connection = new Swift_Connection_NativeMail();
    $connection->start();
    $connection->write($command);
    $this->assertPattern("~^250\\b~", $connection->read());
  }
  
  public function test250ResponseIsSentOnEHLO()
  {
    $this->assert250Response("EHLO foo");
    $this->assert250Response("EHLO bar");
    $this->assert250Response("EHLO");
  }
  
  public function test250ResponseIsSentOnMAIL()
  {
    $this->assert250Response("MAIL FROM: <foo@bar>");
    $this->assert250Response("MAIL FROM: <>");
  }
  
  public function test250ResponseIsSentOnRCPT()
  {
    $this->assert250Response("RCPT TO: <foo@bar>");
    $this->assert250Response("RCPT TO: <>");
  }
  
  public function test354ResponseIsSentOnData()
  {
    $connection = new Swift_Connection_NativeMail();
    $connection->start();
    $connection->write("DATA");
    $this->assertPattern("~^354\\b~", $connection->read());
  }
  
  public function test250ResponseIsSentByDefault()
  {
    $this->assert250Response("fgdfshd");
    $this->assert250Response("");
    $this->assert250Response("dgsethjs");
  }
  
  public function test220ResponseIsSentWhenStoppedAndStarted()
  {
    $connection = new Swift_Connection_NativeMail();
    $connection->start();
    $this->assertPattern("~^220\\b~", $connection->read());
    $connection->write("foo");
    $this->assertNoPattern("~^220\\b~", $connection->read());
    $connection->stop();
    $connection->start();
    $this->assertPattern("~^220\\b~", $connection->read());
  }
}
