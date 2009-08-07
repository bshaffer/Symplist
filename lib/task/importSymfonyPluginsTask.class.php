<?php
class importSymfonyPluginsTask extends seoBaseTask
{
  protected $_url = 'http://svn.symfony-project.com/plugins';
  
  protected function configure()
  {
	  $this->addOptions(array(
      new sfCommandOption('app', null, sfCommandOption::PARAMETER_REQUIRED, 'The application', 'frontend'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'prod'),
      new sfCommandOption('id', null, sfCommandOption::PARAMETER_REQUIRED, 'A specific id to rebuild', null),
      new sfCommandOption('where', null, sfCommandOption::PARAMETER_REQUIRED, 'A where clause (equals signs must be replaced with the word "is")', null),
      new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'executes task without confirmations'),
    ));

    $this->namespace        = 'import';
    $this->name             = 'symfony-plugins';
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

    $output = array();

    $this->logSection('import', 'initializing...');
    // Execute Etilize script
    exec("svn list ".$this->_url, $output); 

    $count = 0;
    // return output
    $uncategorized = Doctrine::getTable("PluginCategory")->findOneByName('Uncategorized');
    foreach ($output as $line) 
    {
      $name = $this->cleanValue($line);
      if (!Doctrine::getTable("SymfonyPlugin")->findOneByTitle($name)) 
      {
        $plugin = new SymfonyPlugin();
        $plugin['title'] = $name;
        $plugin["Category"] = $uncategorized;
        $plugin->save();
        
		    $this->logSection('import', 'added plugin '.$line);        
		    $count++;
      }
    }
    $this->logSection('import', "added $count plugins");            
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
}