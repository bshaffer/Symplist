<?php

/**
 * BasePluginTag
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $tag_id
 * @property integer $plugin_id
 * @property Tag $Tag
 * @property SymfonyPlugin $Plugin
 * 
 * @method integer       getTagId()     Returns the current record's "tag_id" value
 * @method integer       getPluginId()  Returns the current record's "plugin_id" value
 * @method Tag           getTag()       Returns the current record's "Tag" value
 * @method SymfonyPlugin getPlugin()    Returns the current record's "Plugin" value
 * @method PluginTag     setTagId()     Sets the current record's "tag_id" value
 * @method PluginTag     setPluginId()  Sets the current record's "plugin_id" value
 * @method PluginTag     setTag()       Sets the current record's "Tag" value
 * @method PluginTag     setPlugin()    Sets the current record's "Plugin" value
 * 
 * @package    plugintracker
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePluginTag extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('plugin_tag');
        $this->hasColumn('tag_id', 'integer', null, array(
             'notnull' => true,
             'type' => 'integer',
             ));
        $this->hasColumn('plugin_id', 'integer', null, array(
             'notnull' => true,
             'type' => 'integer',
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Tag', array(
             'local' => 'tag_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('SymfonyPlugin as Plugin', array(
             'local' => 'plugin_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}