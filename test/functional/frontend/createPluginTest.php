<?php

include(dirname(__FILE__).'/../../bootstrap/functional.php');
include(dirname(__FILE__).'/../../fixtures/fixtures.php');

$browser = new csTestFunctional(new sfBrowser());
$plugin = 'sfFakePlugin'.rand();

$browser
  ->get('/')
  ->click('Sign In')
  ->setField('signin[username]', 'test')
  ->setField('signin[password]', 'test')
  
  ->click('sign in')
  
  ->followRedirect()
  
  ->click('Plugins')
    ->isModuleAction('plugin', 'list')
  
  ->click('Register a Plugin')
    ->isModuleAction('plugin', 'register')
    
  ->setField('symfony_plugin[title]', $plugin)
  ->setField('symfony_plugin[description]', 'description')
  ->setField('symfony_plugin[repository]', 'kasjdjfds')
    
  ->click('Submit')
    
  ->with('form')->begin()
    ->hasErrors()
  ->end()
    
  ->setField('symfony_plugin[title]', $plugin)
  ->setField('symfony_plugin[description]', 'description')
  ->setField('symfony_plugin[repository]', 'http://repository.com')
    
  ->click('Submit')
    
  ->with('form')->begin()
    ->hasErrors(false)
  ->end()
    
  ->isRedirected()
  ->followRedirect()
    
  ->with('request')->begin()
    ->isParameter('module', 'plugin')
    ->isParameter('action', 'show')
    ->isParameter('title', $plugin)
  ->end()
    
  ->with('response')->begin()
    ->isStatusCode(200)
  ->end()  
;