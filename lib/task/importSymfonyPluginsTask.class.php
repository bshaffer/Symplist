<?php
class importSymfonyPluginsTask extends sfBaseTask
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
    
    $cmd = "curl -u 5beafc386c79e4a705ec84d24e5fab1c:x http://www.symfony-project.org/plugins/api/1.0/profile.xml";

    $plugins = SymfonyPluginApi::getPlugins();
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
        $new->save();
        $this->logSection('import', "added '$new->title'");
        $count++;

        // Run Lucene Task every 50 plugins
        // if (!($count%50)) 
        // {
        //   $this->logSection('import', "running lucene cleanup task");
        //   $luceneTask = new sfLuceneRebuildTask($this->dispatcher, $this->formatter);
        //   $luceneTask->run(array('application' => 'frontend'), array());
        // }
        
      }      
    }
    
    $this->logSection('import', "Completed.  Added $count new plugins(s)");
    
    // Execute SVN command to list data
    $xml = CurlRequestHelper::processCurl("5beafc386c79e4a705ec84d24e5fab1c:x@www.symfony-project.org/plugins/api/1.0/profile.xml");


    // $count = 0;
    // // return output
    // $uncategorized = Doctrine::getTable("PluginCategory")->findOneByName('Uncategorized');
    // foreach ($output as $line) 
    // {
    //   $name = $this->cleanValue($line);
    //   if (!Doctrine::getTable("SymfonyPlugin")->findOneByTitle($name)) 
    //   {
    //     $plugin = new SymfonyPlugin();
    //     $plugin['title'] = $name;
    //     $plugin["Category"] = $uncategorized;
    //     $plugin->save();
    //     
    //        $this->logSection('import', 'added plugin '.$line);        
    //        $count++;
    //   }
    // }
    // $this->logSection('import', "added $count plugins");            
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