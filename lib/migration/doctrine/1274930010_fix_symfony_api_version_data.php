<?php

class FixSymfonyApiVersionData extends Doctrine_Migration_Base
{
  protected $symfonyApiVersions = array('1.0', '1.1', '1.2', '1.3', '1.4', '2.0');
  
  public function preUp()
  { 
    $apiVersions = Doctrine_Query::create()
                  ->from('SymfonyApiVersion sav INDEXBY sav.name')->execute();

    include_once(dirname(__FILE__).'/../model/1274930010/PluginRelease.php');
    
    $releases = Doctrine::getTable('Migration_1274930010_PluginRelease')
                  ->findAll();

    foreach ($releases as $release) 
    {
      $releaseApiVersions = $this->getReleasesForDiff($release['symfony_version_min'], $release['symfony_version_min']);
      
      if ($releaseApiVersions) 
      {
        foreach ($releaseApiVersions as $releaseApiVersion)
        {
          $release['ApiVersions'][] = $apiVersions[$releaseApiVersion];
        }
        
        $release->save();
      }
      else
      {
        $release->delete();
      }
    }
  }
  
  public function up()
  {
    $this->removeColumn('plugin_release', 'symfony_version_min');
    $this->removeColumn('plugin_release', 'symfony_version_max');
  }

  public function down()
  {
    $this->addColumn('plugin_release', 'symfony_version_min', 'string', '255', array());
    $this->addColumn('plugin_release', 'symfony_version_max', 'string', '255', array());
  }
  
  public function postDown()
  {
    // Your values are gone... sorry sukka.
  }
  
  protected function getReleasesForDiff($min, $max)
  {
    $versionsDiff = array();
    
    if (($i = array_search($min, $this->symfonyApiVersions)) !== false) 
    {
      if (($j = array_search($max, $this->symfonyApiVersions)) !== false) 
      {
        return array_slice($this->symfonyApiVersions, $i, ($j-$i+1));
      }
      return array($min);
    }
    if (false !== array_search($max, $this->symfonyApiVersions)) 
    {
      return array($max);
    }
    
    return array();
  }
}
