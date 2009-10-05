<?php

/**
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class BaseCommunityListItem extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('community_list_item');
        $this->hasColumn('title', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => '255',
             ));
        $this->hasColumn('body', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('list_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('score', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('count', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('submitted_by', 'integer', 4, array(
             'type' => 'integer',
             'length' => '4',
             ));
    }

    public function setUp()
    {
        $this->hasOne('CommunityList as List', array(
             'local' => 'list_id',
             'foreign' => 'id'));

        $this->hasOne('sfGuardUser as User', array(
             'local' => 'submitted_by',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $markdown0 = new Doctrine_Template_Markdown(array(
             'fields' => 
             array(
              0 => 'body',
             ),
             ));
        $this->actAs($timestampable0);
        $this->actAs($markdown0);
    }
}