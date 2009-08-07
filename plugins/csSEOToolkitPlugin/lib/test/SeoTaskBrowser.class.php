<?php

class SeoTaskBrowser extends sfBrowser
{
 protected function doCall()
  {
    // recycle our context object
    $this->context = $this->getContext(true);

    sfConfig::set('sf_test', true);

    // we register a fake rendering filter
    sfConfig::set('sf_rendering_filter', array('sfFakeRenderingFilter', null));

    $this->resetCurrentException();

    // dispatch our request
    ob_start();

		//Remove layout for parsing metadata
		$moduleName = $this->context->getRequest()->getParameter('module');
		$actionName = $this->context->getRequest()->getParameter('action');
		sfConfig::set('symfony.view.'.$moduleName.'_'.$actionName.'_layout', false);

    $this->context->getController()->dispatch();
    $retval = ob_get_clean();
		

    // append retval to the response content
		// exit('first?');
    $this->context->getResponse()->setContent($retval);
		// $content = $this->context->getController()->getView()->render();
		// exit($this->context->getResponse()->getContent());
		// exit("Content = ".$content);

    // manually shutdown user to save current session data
    if ($this->context->getUser())
    {
      $this->context->getUser()->shutdown();
      $this->context->getStorage()->shutdown();
    }
  }
}
