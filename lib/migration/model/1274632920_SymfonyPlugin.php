<?php

/**
* 
*/
class Migration_1274632920_SymfonyPlugin extends SymfonyPlugin
{
  public function setUp()
  {
    parent::setUp();
    $this->hasColumn('user_id', 'integer', '4', array('length' => '4', 'type' => 'integer'));
  }
}

/**
* 
*/
class Migration_1274632920_SymfonyPluginTable extends SymfonyPluginTable
{
}