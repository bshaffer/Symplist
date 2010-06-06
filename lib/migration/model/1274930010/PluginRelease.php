<?php

/**
* 
*/
class Migration_1274930010_PluginRelease extends PluginRelease
{
  public function setUp()
  {
    parent::setUp();
    $this->hasColumn('symfony_version_min', 'string', '255', array('length' => '255', 'type' => 'string'));
    $this->hasColumn('symfony_version_max', 'string', '255', array('length' => '255', 'type' => 'string'));
  }
}

class Migration_1274930010_PluginReleaseTable extends PluginReleaseTable
{
}
