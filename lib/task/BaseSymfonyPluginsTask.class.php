<?php
abstract class BaseSymfonyPluginsTask extends sfBaseTask
{ 
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