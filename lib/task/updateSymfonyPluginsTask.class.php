<?php
class updateSymfonyPluginsTask extends BaseSymfonyPluginsTask
{
  protected function configure()
  {
	  $this->addOptions(array(
      new sfCommandOption('app', null, sfCommandOption::PARAMETER_REQUIRED, 'The application', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('plugin', null, sfCommandOption::PARAMETER_REQUIRED, 'A specific plugin to update'),      
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
    
    $plugins = $options['plugin'] ? array(SymfonyPluginApi::getPlugin($options['plugin'])) : SymfonyPluginApi::getPlugins();
    
    // Rebuild the index before starting
        
    $count = 0;
    foreach ($plugins as $plugin) 
    {
      $this->logSection('import', $plugin['id']);      
      $new = Doctrine::getTable('SymfonyPlugin')->findOneByTitle($plugin['id']);
      
      // if plugin exists update info.  Otherwise, create it
      if (!$new) 
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
            $newrel['symfony_version_min'] = $this->parseVersionNumber($release->symfony->min);
            $newrel['symfony_version_max'] = $this->parseVersionNumber($release->symfony->max);
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
  
  public function parseVersionNumber($version)
  {
    if (substr_count($version, '.') > 1) 
    { 
      return substr($version, 0, strpos($version, '.', 2));
    }
    
    return $version;
  }
}