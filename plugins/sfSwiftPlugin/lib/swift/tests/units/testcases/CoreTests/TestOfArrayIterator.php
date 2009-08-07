<?php

class TestOfArrayIterator extends UnitTestCase
{
  public function testNextIteratesBy1()
  {
    $input = array("foo" => "bar", "zip" => "button");
    $it = new Swift_Iterator_Array($input);
    
    $it->next();
    $this->assertEqual("bar", $it->getValue());
    $it->next();
    $this->assertEqual("button", $it->getValue());
  }
  
  public function testHasNextReturnsTrueIfHasNext()
  {
    $input = array("foo" => "bar", "zip" => "button", "milk" => "cheese", "cow");
    $it = new Swift_Iterator_Array($input);
    
    $it->next();
    $this->assertTrue($it->hasNext());
    $it->next();
    $this->assertTrue($it->hasNext());
    $it->next();
    $this->assertTrue($it->hasNext());
    $it->next();
    $this->assertFalse($it->hasNext());
  }
  
  public function testSeekToReturnTrueOnlyOnSuccess()
  {
    $input = array("foo" => "bar", "zip" => "button", "milk" => "cheese", "cow");
    $it = new Swift_Iterator_Array($input);
    
    $this->assertTrue($it->seekTo(0));
    $this->assertTrue($it->seekTo(1));
    $this->assertTrue($it->seekTo(2));
    $this->assertTrue($it->seekTo(3));
    $this->assertFalse($it->seekTo(4));
    $this->assertFalse($it->seekTo(10));
    $this->assertFalse($it->seekTo(-1));
  }
  
  public function testIteratingInWhileLoop()
  {
    $input = array("foo" => "bar", "zip" => "button", "milk" => "cheese", "cow");
    $it = new Swift_Iterator_Array($input);
    $seen = 0;
    while ($it->hasNext())
    {
      $it->next();
      $seen++;
    }
    $this->assertEqual(4, $seen);
  }
}
