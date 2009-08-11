<?php

/**
 * site actions.
 *
 * @package    plugintracker
 * @subpackage site
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class siteActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

  }
  
  public function executeAbout(sfWebRequest $request)
  {
    
  }
  
  public function executeContact(sfWebRequest $request)
  {
    $this->form = new ContactForm();
    if ($request->isMethod('POST')) 
    {
      $this->form->bind($request->getParameter('contact'));
      if ($this->form->isValid()) 
      {
        EmailHelper::sendEmail(array(
          'to'      => 'bshafs@gmail.com',
          'from'    => $this->form->getValue('email'),
          'body'    => $this->form->getValue('message')
          ));
          
        return 'Confirm';
      }
    }
    return 'Form';
  }
}
