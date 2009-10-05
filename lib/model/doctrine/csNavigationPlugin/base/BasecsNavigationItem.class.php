<?php

/**
 * BasecsNavigationItem
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $route
 * @property boolean $protected
 * @property boolean $locked
 * @property Doctrine_Collection $NavigationMenu
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6365 2009-09-15 18:22:38Z jwage $
 */
abstract class BasecsNavigationItem extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('cs_navigation_item');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('route', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('protected', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
        $this->hasColumn('locked', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
    $this->hasMany('csNavigationMenu as NavigationMenu', array(
             'local' => 'id',
             'foreign' => 'root_id'));

        $nestedset0 = new Doctrine_Template_NestedSet(array(
             'hasManyRoots' => true,
             ));
        $this->actAs($nestedset0);
    }
}