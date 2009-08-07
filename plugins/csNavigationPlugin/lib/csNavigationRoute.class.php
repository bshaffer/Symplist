<?php 

/*
  TODO Refactor this class
*/

/**
* 
*/
class csNavigationRoute
{
  var $route;
  
  function __construct($route)
  {
    $this->route = $route;
  }
  
  // ==================
  // = Route Matching =
  // ==================
    
  public function matchUrl($url1, $url2)
  {
    // echo "URL1: $url1 & URL2: $url2";
    if($url1 == $url2)
    {
      return true;
    }
    elseif(stripos($url1, '*') !== false || stripos($url2, '*') !== false)
    {
      return $this->matchWildcardRoutes($url1, $url2);
    }
    return false;
  }
  public function matchWildcardRoutes($url1, $url2)
  {
    $url1_arr = explode('/', $url1);
    $url2_arr = explode('/', $url2);
    if(sizeof($url1_arr) == sizeof($url2_arr))
    {
      for ($i = 0; $i < sizeof($url1_arr); $i++) 
      {
        if($url1_arr[$i] != $url2_arr[$i] && $url1_arr[$i] != '*' &&  $url2_arr[$i] != '*')
        {
          return false;
        }
      }
      return true;
    }
    return false;
  }

  //attempt to fill parameters in the route
  public function fillParams()
  {
    $routing = sfContext::getInstance()->getRouting()->getRoutes();
    if(!isset($routing[substr($this->getBaseRoute(), 1)]))
    {
      throw new sfException('Undefined Route: ' . $this->getBaseRoute());
    }
    $route = $routing[substr($this->getBaseRoute(), 1)];
    foreach ($route->getVariables() as $key => $value) 
    {
      if($param = $this->routeHasParameter($key))
      {
        $this->addRouteParam($key, $param);
      }
      elseif(method_exists(new csNavigationMenu(), sfInflector::camelize('get_default_'.$key)))
      {
        $method = sfInflector::camelize('get_default_'.$key);
        $this->addRouteParam($key, csNavigationMenu::$method($this));
      }
    }
  }

  // Check if a paramter being looked for is already set
  public function routeHasParameter($key)
  {
    $params = array();
    parse_str(substr(strstr($this->route, '?'), 1));

    if(isset($params[$key]))
    {
      return $params[$key];
    }
    return false;
  }
  
  //adds a paramter to the route
  public function addRouteParam($key, $value)
  {
    $route = $this->route;
    $route .= stripos($route, '?') === false ? '?' : '&';
    $this->setRoute($route .= "$key=$value");
  }
  
  // whether or not route is a token route
  public function isTokenRoute()
  {
    $route = $this->route;
    return ($route && $route[0] == '@');
  }
  
  public function getRouteUrl($relative = false) 
  { 
    if($this->isTokenRoute())
    {
      $this->fillParams();
    }
    return $relative ? $this->makeUrlRelative($this->getRenderedRoute()) : $this->getRenderedRoute();
  }
  
  public function getRenderedRoute()
  {
    if($this->isTokenRoute())
    {
      sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
      return url_for($this->route, 'absolute=true'); 
    }
    return stripos($this->route, '://') === false ? $this->getRootSiteUrl() .$this->route : $this->route;    
  }
  
  public function getCurrentUrl($relative = false)
  { 
    return $relative ? $this->makeUrlRelative($this->getCurrentUri()) : $this->getCurrentUri();
  }
  
  public function getCurrentUri()
  {
    return sfContext::getInstance()->getRequest()->getUri();
  }
  
  public function makeUrlRelative($url)
  {
    $url = str_replace('index.php/', '', $url);
    $url = str_replace('index.php', '', $url);
    $url = str_replace($this->getRootSiteUrl(), '', $url);
    $url = stripos($url, '?') ? substr($url, 0, stripos($url, '?')) : $url;
    return isset($url[0]) &&$url[0] == '/' ? substr($url, 1) : $url;
  }

  public function getBaseRoute()
  {
    if($this->isTokenRoute())
    {
      if(stripos($this->route, '?') !== false)
      {
        return substr($this->route, 0, stripos($this->route, '?'));
      }
    }
    return $this->route;
  }
  
  public function isCurrentUrl() 
  { 
    return $this->matchUrl($this->getCurrentUrl(true), $this->getRouteUrl(true)); 
  }
  
  public function getRootSiteUrl()
  {
    $request = sfContext::getInstance()->getRequest();
    return $request->getUriPrefix().$request->getScriptName();
  }
}
