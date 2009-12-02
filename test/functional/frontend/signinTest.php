<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../fixtures/fixtures.php');

$browser = new sfTestFunctional(new sfBrowser());

$browser->
  get('/')->
  click('Sign In')->
  setField('signin[username]', 'test')->
  setField('signin[password]', 'test')->
  
  click('sign in')->
  
  isRedirected()->
  followRedirect()->
  
  with('response')->begin()->
    contains('Sign Out')->
  end()
;