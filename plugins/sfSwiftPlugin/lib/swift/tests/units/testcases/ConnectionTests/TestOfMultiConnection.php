<?php

if (!class_exists("FullMockConnection")) Mock::Generate("DummyConnection", "FullMockConnection");

class TestOfMultiConnection extends UnitTestCase
{
  public function testConnectionChoosesOnlyOneWorkingConnection()
  {
    $mock1 = new FullMockConnection();
    $mock1->setReturnValue("isAlive", false);
    $mock1->expectOnce("start");
    $mock1->expectNever("read");
    $mock1->expectNever("write");
    
    $mock2 = new FullMockConnection();
    $mock2->setReturnValue("isAlive", true);
    $mock2->expectOnce("start");
    $mock2->expectOnce("read");
    $mock2->expectCallCount("write", 3);
    $mock2->expectAt(0, "write", array("foo", "*"));
    $mock2->expectAt(1, "write", array("bar", "*"));
    $mock2->expectAt(2, "write", array("zip", "*"));
    
    $mock3 = new FullMockConnection();
    $mock3->setReturnValue("isAlive", true);
    $mock3->expectNever("start");
    $mock3->expectNever("read");
    $mock3->expectNever("write");
    
    $multi = new Swift_Connection_Multi();
    $multi->addConnection($mock1, "mock1");
    $multi->addConnection($mock2, "mock2");
    $multi->addConnection($mock3, "mock3");
    
    $multi->start();
    $multi->read();
    $multi->write("foo");
    $multi->write("bar");
    $multi->write("zip");
  }
  
  public function testExceptionIsThrownIfNoConnectionsCanBeStarted()
  {
    $mock1 = new FullMockConnection();
    $mock1->setReturnValue("isAlive", false);
    $mock1->expectOnce("start");
    
    $mock2 = new FullMockConnection();
    $mock2->setReturnValue("isAlive", false);
    $mock2->expectOnce("start");
    
    $multi = new Swift_Connection_Multi();
    $multi->addConnection($mock1, "mock1");
    $multi->addConnection($mock2, "mock2");
    
    try {
      $multi->start();
      $this->fail("This should have thrown an exception since none of the connections started.");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
  }
  
  public function testReadIsCalledBackFromActiveConnection()
  {
    $mock1 = new FullMockConnection();
    $mock1->setReturnValue("isAlive", false);
    $mock1->setReturnValue("read", "foo");
    $mock1->expectOnce("start");
    $mock1->expectNever("read");
    
    $mock2 = new FullMockConnection();
    $mock2->setReturnValue("isAlive", true);
    $mock2->setReturnValue("read", "bar");
    $mock2->expectOnce("start");
    $mock2->expectOnce("read");
    
    $multi = new Swift_Connection_Multi();
    $multi->addConnection($mock1, "mock1");
    $multi->addConnection($mock2, "mock2");
    
    $multi->start();
    $this->assertEqual("bar", $multi->read());
  }
  
  public function testIsAliveReturnsTrueWhenAConnectionIsUp()
  {
    $mock1 = new FullMockConnection();
    $mock1->setReturnValue("isAlive", false);
    
    $mock2 = new FullMockConnection();
    $mock2->setReturnValue("isAlive", true);
    
    $multi = new Swift_Connection_Multi();
    $this->assertFalse($multi->isAlive());
    
    $multi->addConnection($mock1, "mock1");
    $multi->addConnection($mock2, "mock2");
    
    $multi->start();
    $this->assertTrue($multi->isAlive());
  }
  
  public function testIsAliveReturnsFalseIfTheConnectionIsClosed()
  {
    $mock1 = new FullMockConnection();
    $mock1->setReturnValue("isAlive", false);
    $mock1->expectOnce("start");
    $mock1->expectNever("stop");
    
    $mock2 = new FullMockConnection();
    $mock2->setReturnValue("isAlive", true);
    $mock2->expectOnce("start");
    $mock2->expectOnce("stop");
    
    $multi = new Swift_Connection_Multi();
    $multi->addConnection($mock1, "mock1");
    $multi->addConnection($mock2, "mock2");
    
    $multi->start();
    $this->assertTrue($multi->isAlive());
    $multi->stop();
    $this->assertFalse($multi->isAlive());
  }
}
