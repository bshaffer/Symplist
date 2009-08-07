<?php

class TestOfJointOutputStream extends UnitTestCase
{
  public function testMultipleStreamsAreReadLikeAConcatenatedString()
  {
    $cache1 = new Swift_Cache_Memory();
    $cache1->write("foo", "abc");
    $os1 = $cache1->getOutputStream("foo");
    
    $cache2 = new Swift_Cache_Memory();
    $cache2->write("bar", "def");
    $os2 = $cache2->getOutputStream("bar");
    
    $cache3 = new Swift_Cache_Memory();
    $cache3->write("zip", "123456789");
    $os3 = $cache3->getOutputStream("zip");
    
    $joint_os = new Swift_Cache_JointOutputStream(array($os1, $os2, $os3));
    $ret = "";
    while (false !== $bytes = $joint_os->read())
      $ret .= $bytes;
    $this->assertEqual("abcdef123456789", $ret);
  }
}
