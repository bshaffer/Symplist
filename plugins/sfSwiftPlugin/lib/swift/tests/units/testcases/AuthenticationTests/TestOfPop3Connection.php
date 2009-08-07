<?php

class TestOfPop3Connection extends UnitTestCase
{
  public function testAssertOkThrowsExceptionOnBadResponse()
  {
    $conn = new Swift_Authenticator_PopB4Smtp_Pop3Connection("host");
    try {
      $conn->assertOk("+OK Foo");
    } catch (Swift_ConnectionException $e) {
      $this->fail("No exception should have been thrown since this response is good");
    }
    try {
      $conn->assertOk("bad response");
      $this->fail("This should have thrown an exception since the response is not correct (+OK).");
    } catch (Swift_ConnectionException $e) {
      //Pass
    }
  }
}
