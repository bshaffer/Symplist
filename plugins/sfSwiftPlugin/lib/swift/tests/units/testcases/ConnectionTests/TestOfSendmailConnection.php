<?php

Mock::GeneratePartial("Swift_Connection_Sendmail", "PartialSendmailConnection", array("pipeIn", "pipeOut", "start", "stop"));

class TestOfSendmailConnection extends UnitTestCase
{
  public function testRunningIn_bs_ModeWritesAllSMTPCommands()
  {
    $sendmail = new PartialSendmailConnection();
    $sendmail->setReturnValueAt(0, "pipeOut", "220 xxx Hello");
    $sendmail->setReturnValueAt(1, "pipeOut", "250 Blah blah");
    $sendmail->setReturnValueAt(2, "pipeOut", "250 Ok");
    $sendmail->setReturnValueAt(3, "pipeOut", "250 Ok");
    $sendmail->setReturnValueAt(4, "pipeOut", "354 Go ahead");
    $sendmail->setReturnValueAt(5, "pipeOut", "250 Ok");
    $sendmail->expectAt(0, "pipeIn", array("HELO xxx", "*"));
    $sendmail->expectAt(1, "pipeIn", array("MAIL FROM: <zip@button.name>", "*"));
    $sendmail->expectAt(2, "pipeIn", array("RCPT TO: <foo@bar.tld>", "*"));
    $sendmail->expectAt(3, "pipeIn", array("DATA", "*"));
    $sendmail->expectAt(4, "pipeIn", array("*", "*"));
    $sendmail->setFlags("bs");
    $swift = new Swift($sendmail, "xxx");
    $message = new Swift_Message("subject", "body");
    $swift->send($message, new Swift_Address("foo@bar.tld"), new Swift_Address("zip@button.name"));
  }
  
  public function testRunningIn_t_ModeOnlyWritesMessageData()
  {
    //Dropped due to issues with Bcc handling and (correct) unreliability with mailers such as Exim
    // There are arguments online regarding this topic if you Google for 'sendmail "-t option" bcc recipients'
    // The code still exists in the Sendmail class, but I will not be supporting it's usage.
    
    /*$sendmail = new PartialSendmailConnection();
    $sendmail->expectOnce("pipeIn");
    $sendmail->expectNever("pipeOut");
    $sendmail->setFlags("t");
    $swift = new Swift($sendmail, "xxx");
    $message = new Swift_Message("subject", "body");
    $swift->send($message, new Swift_Address("foo@bar.tld"), new Swift_Address("zip@button.name"));*/
  }
}
