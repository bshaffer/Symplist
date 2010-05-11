<?php

class sfDoctrineMigrationSetTask extends sfDoctrineBaseTask
{
  /**
   * @see sfTask
   */
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('version', sfCommandArgument::OPTIONAL, 'The migration version to set'),
    ));
    
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_OPTIONAL, 'The application name', true),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
    ));

    $this->namespace = 'doctrine';
    $this->name = 'migration-set';

    $this->briefDescription = 'set the migration version for your project';

    $this->detailedDescription = <<<EOF
      set the migration version for your project
EOF;
  }

  /**
   * @see sfTask
   */
  protected function execute($arguments = array(), $options = array())
  {
    $databaseManager = new sfDatabaseManager($this->configuration);
    $config = $this->getCliConfig();
    $migration = new Doctrine_Migration($config['migrations_path']);
    $intValidator = new sfValidatorInteger();
    $migration->setCurrentVersion($arguments['version']);
    $this->logSection('doctrine', 'Migration version set to '.$arguments['version']);
  }
}