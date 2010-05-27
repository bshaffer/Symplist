<?php


class SymfonyPluginAuthorTable extends Doctrine_Table
{
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('SymfonyPluginAuthor');
    }
}