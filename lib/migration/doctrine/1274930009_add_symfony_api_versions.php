<?php

class addSymfonyApiVersionsMigration extends Doctrine_Migration_Base
{
  protected $symfonyApiVersions = array('1.0', '1.1', '1.2', '1.3', '1.4', '2.0');
  
  public function up()
  {
    // Load Versions
    foreach ($this->symfonyApiVersions as $apiVersion)
    {
      $version = new SymfonyApiVersion();
      $version['name'] = $apiVersion;
      $version->save();
    }
  }

  public function down()
  {
    Doctrine::getTable('SymfonyApiVersion')
      ->createQuery()->delete()->execute();
  }
}
