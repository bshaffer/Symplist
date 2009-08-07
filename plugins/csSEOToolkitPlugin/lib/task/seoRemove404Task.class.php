<?php

class seoRemove404Task extends seoBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
		));

	  $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'executes task without confirmations'),
    ));

    $this->namespace        = 'seo';
    $this->name             = 'remove-404';
    $this->briefDescription = 'removes all 404 pages being indexed in the SeoPage model';
    $this->detailedDescription = <<<EOF
This task removes 404 pages from the SeoPage Model.
It requires an application argument.
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $app     = $arguments['application'];
    $env     = $options['application'];

		$this->bootstrapSymfony($app, $env, true);
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase('doctrine')->getConnection();

		$pages = Doctrine_Query::create()
								   ->select('*')
									 ->from('SeoPage')
									 ->execute();		
									
		$browser = new SeoTestFunctional(new sfBrowser());
					
		$missingPages = array();
		foreach ($pages as $page) 
		{
			$browser->loadUrl($page['url']);
			if($browser->isStatusCode(404))
			{
				$missingPages[] = $page;

				$this->logMessage('invalid page of url %s', $page->getUrl());
			}
		}
		if (count($missingPages)) 
		{
			$this->removePages($missingPages, $options);
		}
		else
		{
			$this->logSection('seo', 'all your pages are valid');
		}
  }

  protected function bootstrapSymfony($app, $env, $debug = true)
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);

    sfContext::createInstance($configuration);
  }
}
