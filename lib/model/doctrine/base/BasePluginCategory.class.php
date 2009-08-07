<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BasePluginCategory extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('plugin_category');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('description', 'clob', null, array(
             'type' => 'clob',
             ));
    }

    public function setUp()
    {
        $this->hasMany('SymfonyPlugin as Plugins', array(
             'local' => 'id',
             'foreign' => 'category_id'));

        $sluggable0 = new Doctrine_Template_Sluggable();
        $this->actAs($sluggable0);
    }
}