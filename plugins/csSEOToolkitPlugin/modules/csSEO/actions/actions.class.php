<?php

class csSEOActions extends sfActions
{
	public function executeEditMetaData(sfWebRequest $request)
	{
		$data = $request->getParameter('seo_page_meta_data');
		$obj = Doctrine::getTable('SeoPage')->findOneById($data['id']);
		$form = new SeoPageForm($obj);
		$form->bind($data);
		if ($obj->id && $form->isValid()) 
		{
			$this->getUser()->setFlash('notice', 'Meta Data for this page has been updated!');
			$form->save();
		}
		else
		{
			$this->getUser()->setFlash('notice', 'Error: Meta Data for this page has not updated');			
		}
		$this->redirect($obj['absolute_url']);
	}
	public function executeEditSitemapData(sfWebRequest $request)
	{

		$data = $request->getParameter('seo_page_sitemap_info');
				// exit(print_r($data));
		$obj = Doctrine::getTable('SeoPage')->findOneById($data['id']);
		$form = new SeoPageForm($obj);
		$form->bind($data);
		if ($obj->id && $form->isValid()) 
		{
			$this->getUser()->setFlash('notice', 'Sitemap.xml Data for this page has been updated!');
			$form->save();
		}
		else
		{
			$this->getUser()->setFlash('notice', 'Error: Sitemap.xml Data for this page has not updated');			
		}
		$this->redirect($obj['absolute_url']);
	}

 // ===========
  // = Sitemap =
  // ===========
	public function executeSitemap(sfWebRequest $request)
	{
		$this->items = Doctrine::getTable('SeoPage')->findByExcludeFromSitemap(false);
		$this->setLayout(false);
    $this->getResponse()->setHttpHeader('Content-type','text/xml');
		return 'XML';
	}
	public function executeError404(sfWebRequest $request)
	{
		$this->search = preg_split ("/\/|-/", $request->getPathInfo());
		$query = Doctrine::getTable('SeoPage')
								->getSearchQuery(array_filter($this->search))
								->limit(10);
								
		$this->results = $query->execute();
		
    $this->getResponse()->setStatusCode(404, 'This page does not exist');
	}
}