<?php

/**
* Functional test for testing forms
*/
class csTestFunctional extends sfTestFunctional
{
  public function isModuleAction($module, $action, $statusCode = 200)
  {
    $this->with('request')->begin()->
  	  isParameter('module', $module)->
  	  isParameter('action', $action)->
  	end()->  

    with('response')->begin()->
    	isStatusCode($statusCode)->
    end();

    return $this;
  }

  public function login($username, $password = null, $debug = false)
  {
    if ($username instanceof sfGuardUser) 
    {
      $username = $username['username'];
      
      if ($password === null) 
      {
        $password = cfitFactory::DEFAULT_PASSWORD;
      }
    }
    
    $this
      ->info(sprintf('Logging in with %s/%s ', $username, $password))
      ->get('/login')
      ->setField('signin[username]', $username)
      ->setField('signin[password]', $password)
      ->click('sign in');
      
    if ($debug) 
    {
      $this->with('response')->begin()
        ->debug()
      ->end();
    }
    
    return $this->followRedirect();
  }
  
  public function logout()
  {
    return $this
      ->get('/logout')
      
      ->isModuleAction('sfGuardAuth', 'signout', 302)
      
      ->followRedirect()
      
      ->with('user')->begin()
        ->isAuthenticated(false)
      ->end()
    ;
  }
}