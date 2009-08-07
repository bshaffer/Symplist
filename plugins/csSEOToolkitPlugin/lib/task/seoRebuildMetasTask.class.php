<?php

class seoRebuildMetasTask extends seoBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('application', sfCommandArgument::REQUIRED, 'The application name'),
		));

	  $this->addOptions(array(
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('id', null, sfCommandOption::PARAMETER_REQUIRED, 'A specific id to rebuild', null),
      new sfCommandOption('where', null, sfCommandOption::PARAMETER_REQUIRED, 'A where clause (equals signs must be replaced with the word "is")', null),
      new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'executes task without confirmations'),
    ));

    $this->namespace        = 'seo';
    $this->name             = 'rebuild-metas';
    $this->briefDescription = 'rebuilds metas across the site, using configurations set in app.yml';
    $this->detailedDescription = <<<EOF
This task rebuilds your SEO metadata across the entire site, using the urls available.
It requires an application argument.  

A SQL WHERE clause can be passed using the [where|INFO] option to limit the query to a certain group of objects.  A single SeoPage id can also be passed. 
[You must use "is" instead of an equals sign.|COMMENT]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $app     = $arguments['application'];
    $env     = $options['env'];

		$this->bootstrapSymfony($app, $env, true);
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase('doctrine')->getConnection();

		$q = 	Doctrine_Query::create()
								   ->select('*')
									 ->from('SeoPage');
									
		if (isset($options['id'])) 
		{
			$pages = $q->addWhere('id = ?', $options['id']);
		}
		if (isset($options['where'])) 
		{
			$pages = $q->addWhere(str_replace('is', '=', $options['where']));
		}
		$pages = $q->execute();

		if (!$pages->count() && isset($options['id'])) 
		{
			$this->logSection('seo', 'Page of id "'.$options['id'].'" not found.');
			return 1;
		}							
		
		$browser = new SeoTestFunctional(new SeoTaskBrowser());

		$updated = array();
		$missing = array();
		foreach ($pages as $page) 
		{
			$browser->loadUrl($page['url']);
			if($browser->isStatusCode(200))
			{
				$new = SeoToolkit::createMetaData($browser->getContent());
				if ($page['title'] != $new['title'] || $page['description'] != $new['description'] || $page['keywords'] != $new['keywords']) 
				{
					$page->fromArray($new);
					$update[] = $page;
				}
			}
			else
			{
				$missing[] = $page;
			}
		}
		$num_up = (int) count($update);
		$num_miss = (int) count($missing);
		$total = $pages->count();
		
		if ($num_up) 
		{
			if(
				!(isset($options['no-confirmation']) && $options['no-confirmation']) && 
				!$this->askConfirmation(array('This command will update '.$num_up.' page(s) in your database.', 'Are you sure you want to proceed? (y/N)'), null, false)
    	)
			{
				$this->logSection('seo', 'task aborted');
				return 1;
			}
			foreach ($update as $page) 
			{
				$page->save();
			}
			$this->logSection('seo', $num_up.' of '. $total.' were updated');
		}
		else
		{
			$this->logSection('seo', 'All of your pages metas are up to date');
		}
		if ($num_miss) 
		{
			$this->logSection('seo', 'Missing Pages Found',null, 'ERROR');
			$this->removePages($missing, $options);
		}
		$this->logSection('seo', 'Task Complete');
  }
  protected function bootstrapSymfony($app, $env, $debug = true)
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);

    sfContext::createInstance($configuration);
  }
}
