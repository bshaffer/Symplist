<?php
class csNavigationRebuildTask extends sfBaseTask
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

    $this->namespace        = 'navigation';
    $this->name             = 'rebuild';
    $this->briefDescription = 'rebuild your navigation for a certain environment from navigation.yml';
    $this->detailedDescription = <<<EOF
      rebuild your navigation for a certain environment from navigation.yml
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $app     = $arguments['application'];
    $env     = $options['env'];

    $this->checkAppExists($app);
		$this->bootstrapSymfony($app, $env, true);
		
		$context = sfContext::getInstance();
		
    // Remove existing cache files
    $this->runSymfonyCacheClear();
    		
		$this->logSection('navigation', 'loading navigation.yml');
		
		/*
		  TODO What happens when the user has two or more applications with separate navigation.yml files?
		       We may want to restructure (migrate) the tree rather than drop it and rebuild it!
		*/
    if(file_exists(sfConfig::get('sf_config_dir').'/navigation.yml'))
    {
      $path = sfConfig::get('sf_config_dir').'/navigation.yml';
    }
    else
    {
      $path = sfConfig::get('sf_app_config_dir').'/navigation.yml';
    }
    
    include(sfContext::getInstance()->getConfiguration()->getConfigCache()->checkConfig($path));
    
    csNavigationHelper::init($settings, $navigation, true);
    
    $this->logSection('navigation', "Completed.");
  }
  
   
  protected function bootstrapSymfony($app, $env, $debug = true)
  {
    $configuration = ProjectConfiguration::getApplicationConfiguration($app, $env, $debug);

    sfContext::createInstance($configuration);
  }
  
  public function runSymfonyCacheClear()
  {
    $cacheClear = new sfCacheClearTask($this->dispatcher, $this->formatter);
    $cacheClear->run();
  } 
}