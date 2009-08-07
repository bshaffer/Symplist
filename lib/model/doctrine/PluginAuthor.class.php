<?php

/**
 * PluginAuthor
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5925 2009-06-22 21:27:17Z jwage $
 */
class PluginAuthor extends BasePluginAuthor
{
  public function getRoute()
  {
    return '@author?username='.$this['User']['username'];
  }
  
  public function getUsername()
  {
    return $this['User']['username'];
  }
}