<?php

class quietLuceneRebuildTask extends sfLuceneRebuildTask
{
  protected function configure()
  {
    parent::configure();
    $this->addOption('verbose', null, sfCommandOption::PARAMETER_NONE, 'verbose output');
    $this->aliases = array();
    $this->name = 'quiet-rebuild';    
  }
  
  protected function execute($arguments = array(), $options = array())
  {
    $app = $arguments['application'];

    $this->checkAppExists($app);
    $this->standardBootstrap($app, $options['env']);

    $start = microtime(true);

    $instances = sfLucene::getAllInstances(true);

    foreach ($instances as $instance)
    {
      if ($options['verbose']) 
      {
        $this->setupEventDispatcher($instance);
      }

      $this->rebuild($instance);
    }

    $time = microtime(true) - $start;

    $final = $this->formatter->format('All done!', array('fg' => 'red', 'bold' => true)) . ' Rebuilt for ' . $this->formatter->format(count($instances), array('fg' => 'cyan'));
    $final .= count($instances) == 1 ? ' index in ' : ' indexes in ';
    $final .= $this->formatter->format(number_format($time, 5), array('fg' => 'cyan')) . ' seconds.';

    $this->dispatcher->notify(new sfEvent($this, 'command.log', array('', $final)));
  }
}