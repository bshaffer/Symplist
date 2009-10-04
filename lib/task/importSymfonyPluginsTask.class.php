<?php
class importSymfonyPluginsTask extends BaseSymfonyPluginsTask
{
  protected function configure()
  {
	  $this->addOptions(array(
      new sfCommandOption('app', null, sfCommandOption::PARAMETER_REQUIRED, 'The application', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
    ));

    $this->namespace        = 'symfony-plugins';
    $this->name             = 'import';
    $this->briefDescription = 'pull new plugins from the symfony plugin repository';
    $this->detailedDescription = <<<EOF
This task shound be run on a cron to import plugins from the symfony repo.
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $app     = $options['app'];
    $env     = $options['env'];

		$this->bootstrapSymfony($app, $env, true);
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase('doctrine')->getConnection();
    
    $this->logSection('import', 'initializing...');
    
    $plugins = SymfonyPluginApi::getPlugins();
    $count = 0;
    foreach ($plugins as $plugin) 
    {
      $new = Doctrine::getTable('SymfonyPlugin')->findOneByTitle($plugin['id']);
      
      // if plugin exists update info.  Otherwise, create it
      if ($new) 
      {
        // Nothing Yet
      }
      elseif($plugin['id'])
      {
        $new = new SymfonyPlugin();
        $new['title'] = (string)$plugin['id'];
        $new['description'] = (string)$plugin->description;
        $new['repository'] = (string)$plugin->scm;
        $new['image'] = (string)$plugin->image;
        $new['homepage'] = (string)$plugin->homepage;
        $new['ticketing'] = (string)$plugin->ticketing;
        $new->saveNoIndex();
        $this->logSection('import', "added '$new->title'");
        $count++;
      }      
    }
    
    $this->logSection('import', "Running Lucene Cleanup");
    
    $this->runLuceneRebuild();
        
    $this->logSection('import', "Completed.  Added $count new plugins(s)");
  }
}