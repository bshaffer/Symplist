<?php

/**
 * default actions.
 *
 * @package    cfit
 * @subpackage sfGuardUser
 */
class defaultActions extends sfActions
{
  public function executeError404(sfWebRequest $request)
  {
    $this->getResponse()->setStatusCode(404, 'This page does not exist');    
  }
  
  public function executeSecure(sfWebRequest $request)
  {
    $this->getResponse()->setStatusCode(403);
  }
  
  public function executeConfirmation(sfWebRequest $request)
  {
    $this->url = $request->getUri();
    $this->title = $request->getAttribute('title');
    $this->message = $request->getAttribute('message');
  }
  
  public function executeMaintenance(sfWebRequest $request)
  {
    $this->getResponse()->setStatusCode(302); // Temporary redirect
  }
  
  public function executeDevelopment(sfWebRequest $request)
  {
    $this->getResponse()->setStatusCode(302); // Temporary redirect
  }
}
