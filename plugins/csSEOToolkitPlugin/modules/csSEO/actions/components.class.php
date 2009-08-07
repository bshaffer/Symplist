<?php

class csSEOComponents extends sfComponents
{
	public function executeMetas(sfWebRequest $request)
	{
		$this->include_admin_bar = false;
		$this->page = SeoToolkit::getCurrentSeoPage($request);
		$this->metas = $this->getMetas($this->page, sfContext::getInstance());
		if ($this->page && $this->validatedUser()) 
		{
			$this->include_admin_bar = true;
		}
	}
	public function getMetas($page, $context)
	{
 		$i18n = sfConfig::get('sf_i18n') ? $context->getI18N() : null;
		$metatags = array();
		$metanames = array_merge(array('description' => null, 'keywords' => null), $context->getResponse()->getMetas());
		foreach ($metanames as $name => $content)
 		{	
			if(isset($page[$name]) && $page[$name])
			{
				$content = $page[$name];
			}
   		$metatags[] = tag('meta', array('name' => $name, 'content' => is_null($i18n) ? $content : $i18n->__($content)))."\n";
 		}
		$this->title = $page['title'] ? $page['title'] : $context->getResponse()->getTitle();
		return $metatags;
	}
	public function executeMeta_data(sfWebRequest $request)
	{
		$this->sf_request = $request;
		$this->sf_response = sfContext::getInstance()->getResponse();
		if (!isset($this->sf_content))
		{
			throw new sfException("Must include \$sf_content when generating meta data");
		} 
	}
	/**
	 * executeMeta_data_admin_bar
	 *
	 * Be careful calling this component individually, you may add an unnecessary query to every page
	 *
	 * @param sfWebRequest $request 
	 * @return void
	 * @author Brent Shaffer
	 */
	public function executeSeo_admin_bar(sfWebRequest $request)
	{
		if (sfConfig::get('app_csSEOToolkitPlugins_IncludeAssets', true)) 
		{
			$this->includeAdminBarAssets($request);
		}

		if (!isset($this->page)) 
		{
			$this->page = SeoToolkit::getCurrentSeoPage($request);
		}
		$this->metaform = new MetaDataForm($this->page);
		$this->sitemapform = new SitemapItemForm($this->page);
		$this->validated = $this->validatedUser();
	}
	/**
	 * validatedUser
	 * calls AuthMethod method on the application's User class.  If no method is specified, returns true
	 *
	 * @return void
	 * @author Brent Shaffer
	 */
	public function validatedUser()
	{
		$user = sfContext::getInstance()->getUser();
		$authmethod = sfConfig::get('app_csSEOToolkitPlugin_AuthMethod');
		return $authmethod ? $user->$authmethod() : true;
	}
	public function includeAdminBarAssets(sfWebRequest $request)
	{
		sfContext::getInstance()->getResponse()->addStylesheet('/csSEOToolkitPlugin/css/seo.css');
		sfContext::getInstance()->getResponse()->addStylesheet('/csSEOToolkitPlugin/css/slider_default.css');		
		sfContext::getInstance()->getResponse()->addJavascript('/csSEOToolkitPlugin/js/slider.js');		
	}
}