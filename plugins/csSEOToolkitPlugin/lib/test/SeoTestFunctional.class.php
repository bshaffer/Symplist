<?php

class SeoTestFunctional extends sfTestFunctional
{
	protected $url;
	protected $_comments = false;
	public function __construct(sfBrowserBase $browser, lime_test $lime = null, $testers = array())
	{
		$lime = $lime ? $lime : new SeoLimeTest($this->_comments);
		parent::__construct($browser, $lime, $testers);
	}
	public function loadUrl($url)
	{
		$this->url = $url;
	}
	public function getStatusCode()
	{
		if ($page = $this->get($this->url)) 
		{
			return $this->getWebResponseObject()->getStatusCode();
		}
		return 404;
	}
	public function isStatusCode($code)
	{
		return ($this->getStatusCode() == $code);		
	}
	public function get($uri, $parameters = array(), $changeStack = true)
	{
		try 
		{
			return parent::get($uri, $parameters, $changeStack);	
		} 
		catch (Exception $e) 
		{
			//If the URI cannot be found, the page is a 404 and should be removed
		}	
		return false;
	}

  public function call($uri, $method = 'get', $parameters = array(), $changeStack = true)
  {
    $this->checkCurrentExceptionIsEmpty();

    $uri = $this->browser->fixUri($uri);
		if ($this->_comments) 
		{
			$this->test()->comment(sprintf('%s %s', strtolower($method), $uri));
		}

    foreach ($this->testers as $tester)
    {
      $tester->prepare();
    }

    $this->browser->call($uri, $method, $parameters, $changeStack);

    return $this;
  }

	public function getWebRequestObject()
	{
		return $this->browser->getRequest();
		// return $this->get($this->url)->with('request')->getWebRequestObject();
	}
	public function getWebResponseObject()
	{
		return $this->browser->getResponse();
		// return $this->get($this->url)->with('response')->getWebResponseObject();
	}
	public function getContent()
	{
		return $this->getWebResponseObject()->getContent();
	}
	public function __destruct()
  {
	}
}