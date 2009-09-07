<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());
$username = 'brohan'.rand();
$browser->
  get('/')->
  click('register')->

  with('request')->begin()->
    isParameter('module', 'author')->
    isParameter('action', 'join')->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
    contains('Step 1:')->
  end()->
    
  setField('sf_guard_user[username]', $username)->
  setField('sf_guard_user[password]', 'password')->
  setField('sf_guard_user[password_again]', 'password')->  
  
  click('Submit')->
  
  with('request')->begin()->
    isParameter('module', 'author')->
    isParameter('action', 'join')->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
    info('ensure the user is directed to step two')->
    contains('Step 2:')->

    info('ensure the system logs the user in')->
    contains('sign out')->
  end()->
  
  setField('plugin_author[first_name]', 'Fake')->
  setField('plugin_author[last_name]', 'Guy')->
  setField('plugin_author[email]', 'fake.guy@gmail.com')->  
  setField('plugin_author[bio]', 'I am not fake, despite my unfortunate birth name.  Thanks mom.')->
  
  click('Submit')->
  
  with('request')->begin()->
    isParameter('module', 'author')->
    isParameter('action', 'join')->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
    contains('You have successfully created your account')->
  end()->
  
  click('here')->
  
  with('request')->begin()->
    isParameter('module', 'author')->
    isParameter('action', 'show')->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
    contains($username)->
    contains('[edit]')->
  end()->
  
  click('[edit]')->
  
  with('request')->begin()->
    isParameter('module', 'author')->
    isParameter('action', 'edit')->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
  end()->
  
  setField('plugin_author[email]', 'invalidemail')->  
  
  click('Save')->
  
  with('response')->begin()->
    contains('invalid')->
  end()->
  
  setField('plugin_author[email]', 'valid.email@gmail.com')->  
  setField('plugin_author[first_name]', 'TestFirstName')->  

  click('Save')->
  
  with('form')->begin()->
    hasErrors(false)->
  end()->
  
  click('my profile')->
  
  with('response')->begin()->
    contains('TestFirstName')->
  end()
;
