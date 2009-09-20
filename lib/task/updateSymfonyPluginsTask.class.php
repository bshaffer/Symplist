<?php
class updateSymfonyPluginsTask extends sfBaseTask
{
  protected function configure()
  {
	  $this->addOptions(array(
      new sfCommandOption('app', null, sfCommandOption::PARAMETER_REQUIRED, 'The application', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('id', null, sfCommandOption::PARAMETER_REQUIRED, 'A specific id to rebuild', null),
      new sfCommandOption('where', null, sfCommandOption::PARAMETER_REQUIRED, 'A where clause (equals signs must be replaced with the word "is")', null),
      new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'executes task without confirmations'),
    ));

    $this->namespace        = 'symfony-plugins';
    $this->name             = 'update';
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

    sfConfig::set('symfony_import', true);
    
    $this->logSection('update', 'initializing...');
    
    $plugins = SymfonyPluginApi::getPlugins();
    
    // Rebuild the index before starting
    $this->runLuceneRebuild();
        
    $count = 0;
    foreach ($plugins as $plugin) 
    {
      $new = Doctrine::getTable('SymfonyPlugin')->findOneByTitle($plugin['id']);
      
      // if plugin exists update info.  Otherwise, create it
      if ($new) 
      {

      }
      else
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
      
      $info = SymfonyPluginApi::getPlugin($plugin['id']);
      
      if (isset($info->releases->release[0])) 
      {
        foreach ($info->releases->release as $release) 
        {
          if (!$new->hasRelease($release['id'])) 
          {
            $newrel = new PluginRelease();
            $newrel['Plugin'] = $new;
            $newrel['version'] = (string)$release['id'];
            $newrel['stability'] = (string)$release->stability;
            $newrel['symfony_version_min'] = (string)$release->symfony->min;
            $newrel['symfony_version_max'] = (string)$release->symfony->max;          
            $newrel['date'] = (string)$release->date;         
            $newrel['summary'] = (string)$release->summary;
            $newrel->save();
            $this->logSection('update', "New release ($release[id]) found for $new[title]");
          }
        }
      }
    }

    $this->logSection('import', "Running Lucene Cleanup");
    
    $this->runLuceneRebuild();
    
    $this->logSection('import', "Completed.  Added $count new plugins(s)");
  }
  
  protected function bootstrapSymfony($app, $env, $debug = true)
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);

    sfContext::createInstance($configuration);
  }
  protected function cleanValue($value)
  {
    return str_replace('/', '', $value);
  }
  
  public function runLuceneRebuild()
  {
    $this->logSection('import', "running lucene cleanup task");
    $luceneTask = new sfLuceneRebuildTask($this->dispatcher, $this->formatter);
    $luceneTask->run(array('application' => 'frontend'), array());
  } 
}