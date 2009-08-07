<?php

class TestOfMimePart extends UnitTestCase
{
  public function testPartContainsNeededHeaders()
  {
    $part = new Swift_Message_Part("Just some random message", Swift_Message_Part::PLAIN, "7bit");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=.*?\r\nContent-Transfer-Encoding: 7bit\r\n\r\nJust some random message~", $structure);
  }
  
  public function testCharsetIsSetToUTF8IfRequiredAndNotOverridden()
  {
    $part = new Swift_Message_Part("cenvéla", "text/plain");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\ncenvéla~", $structure);
  }
  
  //Ok, so this is one thing that *could* piss people off but you can force it (read the test properly!)
  public function testEncodingIsForcedAs8BitIfUTF8IsUsedButOnlyIfNoCharsetIsGiven()
  {
    $part = new Swift_Message_Part("cenvéla", "text/plain", "7bit");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\ncenvéla~", $structure);
    
    $part = new Swift_Message_Part("cenvéla", "text/plain", "7bit", "utf-8");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\ncenvéla~", $structure);
    $part->setEncoding("7bit"); //Override!
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=utf-8\r\nContent-Transfer-Encoding: 7bit\r\n\r\ncenvéla~", $structure);
  }
  
  public function testCharsetCanBeChangedAfterInstantiation()
  {
    $part = new Swift_Message_Part("Just some random message");
    $part->setEncoding("8bit");
    $part->setCharset("iso-8859-1");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
    
    $part->setCharset("utf-8");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=utf-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
  }
  
  public function testEncodingCanBeSetAfterInstantiation()
  {
    $part = new Swift_Message_Part("Just some random message");
    $part->setEncoding("8bit");
    $part->setCharset("iso-8859-1");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
    
    $part->setEncoding("7bit");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=iso-8859-1\r\nContent-Transfer-Encoding: 7bit\r\n\r\nJust some random message~", $structure);
  }
  
  public function testContentTypeCanBeSetAfterInstantiation()
  {
    $part = new Swift_Message_Part("Just some random message");
    $part->setEncoding("8bit");
    $part->setCharset("iso-8859-1");
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
    
    $part->setContentType(Swift_Message_Part::HTML);
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/html;\\s* charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
  }
  
  public function testFormatCanBeSetToFlowed()
  {
    $part = new Swift_Message_Part("Just some random message");
    $part->setEncoding("8bit");
    $part->setCharset("iso-8859-1");
    $part->setFlowed(true);
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=iso-8859-1;\\s* format=flowed\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
    
    $part->setFlowed(false);
    $structure = $part->build()->readFull();
    $this->assertPattern("~Content-Type: text/plain;\\s* charset=iso-8859-1\r\nContent-Transfer-Encoding: 8bit\r\n\r\nJust some random message~", $structure);
  }
}
