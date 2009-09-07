<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');

$browser = new sfTestFunctional(new sfBrowser());
$plugin = 'sfFakePlugin'.rand();
$browser->
  get('/')->
  click('sign in')->
  setField('signin[username]', 'test')->
  setField('signin[password]', 'test')->
  
  click('sign in', array(), array('position' => 2))->
  
  isRedirected()->
  followRedirect()->
  
  with('response')->begin()->
    contains('sign out')->
  end()->
  
  click('register a plugin')->
  
  setField('symfony_plugin[title]', $plugin)->
  setField('symfony_plugin[description]', 'description')->  
  setField('symfony_plugin[repository]', 'kasjdjfds')->  
  
  click('Submit')->
  
  with('form')->begin()->
    hasErrors()->
  end()->
  
  setField('symfony_plugin[title]', $plugin)->
  setField('symfony_plugin[description]', 'description')->  
  setField('symfony_plugin[repository]', 'http://repository.com')->  
  
  click('Submit')->
  
  with('form')->begin()->
    hasErrors(false)->
  end()->
  
  isRedirected()->
  followRedirect()->
  
  with('request')->begin()->
    isParameter('module', 'plugin')->
    isParameter('action', 'show')->
    isParameter('title', $plugin)->
  end()->
  
  with('response')->begin()->
    isStatusCode(200)->
  end()
  
;